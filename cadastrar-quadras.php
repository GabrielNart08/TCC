<?php
session_start();

// Verifica se o usuário está logado como administrador
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "reservaquadras";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Variável para verificar se o cadastro foi bem-sucedido
$cadastro_sucesso = false; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Dados da quadra
    $nome = $_POST['nome'];
    $endereco = $_POST['endereco'];
    $preco = $_POST['preco'];
    $imagem = $_FILES['imagem']['name'];

    // Upload da imagem
    $target_dir = "img/";
    $target_file = $target_dir . basename($_FILES["imagem"]["name"]);
    if (!move_uploaded_file($_FILES["imagem"]["tmp_name"], $target_file)) {
        die("Erro ao fazer upload da imagem.");
    }

    // Inserir quadra no banco
    $sql = "INSERT INTO quadra (nome, endereco, preco, imagem, id_usuario) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdsi", $nome, $endereco, $preco, $imagem, $_SESSION['user_id']);
    
    if ($stmt->execute()) {
        $id_quadra = $stmt->insert_id; // Obtém o ID da quadra cadastrada

        // Inserir horários no banco
        if (!empty($_POST['dias']) && !empty($_POST['hora_inicio']) && !empty($_POST['hora_fim'])) {
            $dias = $_POST['dias'];
            $horas_inicio = $_POST['hora_inicio'];
            $horas_fim = $_POST['hora_fim'];

            $sql_horarios = "INSERT INTO horario (id_quadra, hora_inicio, hora_fim, dia_semana) VALUES (?, ?, ?, ?)";
            $stmt_horarios = $conn->prepare($sql_horarios);

            // Inserir cada horário
            foreach ($dias as $index => $dia) {
                $hora_inicio = $horas_inicio[$index];
                $hora_fim = $horas_fim[$index];

                $stmt_horarios->bind_param("isss", $id_quadra, $hora_inicio, $hora_fim, $dia);
                if (!$stmt_horarios->execute()) {
                    echo "Erro ao inserir horário: " . $stmt_horarios->error;
                }
            }
        }

        // Definir que o cadastro foi bem-sucedido
        $cadastro_sucesso = true; 
    } else {
        echo "Erro ao cadastrar quadra: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!-- HTML com Formulário -->
<link rel="stylesheet" href="styles/cadastroquad.css">

<div class="container">
    <h2>Cadastrar Nova Quadra</h2>

    <!-- Botão de Voltar -->
    <a href="painel-admin.php" class="btn-voltar">← Voltar</a>

    <!-- Exibe o modal de sucesso se o cadastro for bem-sucedido -->
    <?php if ($cadastro_sucesso): ?>
        <div id="successModal" class="success-modal">
            <div class="modal-content">
                <span class="close-btn">&times;</span>
                <p>Quadra cadastrada com sucesso!</p>
            </div>
        </div>
    <?php endif; ?>

    <form action="cadastrar-quadras.php" method="POST" enctype="multipart/form-data">
        <div>
            <label for="nome">Nome da Quadra:</label>
            <input type="text" id="nome" name="nome" required>
        </div>
        <div>
            <label for="endereco">Endereço:</label>
            <input type="text" id="endereco" name="endereco" required>
        </div>
        <div>
            <label for="preco">Preço (por hora):</label>
            <input type="text" id="preco" name="preco" required>
        </div>
        <div>
            <label for="imagem">Imagem da Quadra:</label>
            <input type="file" id="imagem" name="imagem" required>
        </div>
        <div id="horarios">
        <label>Horários Disponíveis:</label>
        <div>
            <select name="dias[]" required>
                <option value="">Selecione o dia</option>
                <option value="Segunda">Segunda</option>
                <option value="Terça">Terça</option>
                <option value="Quarta">Quarta</option>
                <option value="Quinta">Quinta</option>
                <option value="Sexta">Sexta</option>
                <option value="Sábado">Sábado</option>
                <option value="Domingo">Domingo</option>
            </select>
            <input type="time" name="hora_inicio[]" required>
            <input type="time" name="hora_fim[]" required>
            <button type="button" id="addHorario">Adicionar horário</button>
        </div>
    </div>
        <button type="submit">Cadastrar Quadra</button>
    </form>
</div>

<script>
// Mostrar o modal de sucesso se o cadastro foi bem-sucedido
<?php if ($cadastro_sucesso): ?>
    document.getElementById("successModal").style.display = "block";

    // Fechar o modal após 2 segundos (não é mais necessário recarregar a página)
    setTimeout(function() {
        document.getElementById("successModal").style.display = "none";

        // Redirecionar para o painel-admin após o modal desaparecer
        window.location.href = 'painel-admin.php';
    }, 2000);
<?php endif; ?>

// Função para fechar o modal quando clicar no botão de fechar
document.querySelector(".close-btn")?.addEventListener("click", function() {
    document.getElementById("successModal").style.display = "none";
});


// Função para adicionar mais horários
document.getElementById("addHorario").addEventListener("click", function() {
    const horariosContainer = document.getElementById("horarios");
    const novoHorario = document.createElement("div");
    novoHorario.classList.add("horario-item");
    novoHorario.innerHTML = `
        <select name="dias[]" required>
            <option value="">Selecione o dia</option>
            <option value="Segunda">Segunda</option>
            <option value="Terça">Terça</option>
            <option value="Quarta">Quarta</option>
            <option value="Quinta">Quinta</option>
            <option value="Sexta">Sexta</option>
            <option value="Sábado">Sábado</option>
            <option value="Domingo">Domingo</option>
        </select>
        <input type="time" name="hora_inicio[]" required>
        <input type="time" name="hora_fim[]" required>
        <button type="button" class="remover-horario">Remover</button>
    `;
    
    horariosContainer.appendChild(novoHorario);

    // Adiciona o evento de remover o horário
    novoHorario.querySelector(".remover-horario").addEventListener("click", function() {
        novoHorario.remove();
    });
});
</script>

<style>
/* Estilo para o modal de sucesso */
.success-modal {
    display: none; 
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.4); /* Fundo semitransparente */
    z-index: 9999; /* Para garantir que o modal fique sobreposto */
}

.modal-content {
    background-color: #4CAF50;
    color: white;
    margin: 15% auto;
    padding: 20px;
    width: 300px;
    text-align: center;
    border-radius: 5px;
}

.close-btn {
    color: white;
    font-size: 24px;
    position: absolute;
    top: 10px;
    right: 10px;
    cursor: pointer;
}

/* Estilo para o botão de voltar */
.btn-voltar {
    display: inline-block;
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    font-size: 16px;
    text-decoration: none;
    border-radius: 5px;
    margin-bottom: 20px;
    position: absolute;
    top: 10px;
    left: 10px;
}

.btn-voltar:hover {
    background-color: #45a049;
}
</style>

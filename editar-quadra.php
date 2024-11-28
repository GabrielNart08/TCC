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

// Verifica se a quadra existe
$quadra_id = $_GET['id'];
$sql = "SELECT * FROM quadra WHERE id_quadra = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $quadra_id);
$stmt->execute();
$result = $stmt->get_result();
$quadra = $result->fetch_assoc();

// Atualiza os dados se o formulário for enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST['nome'];
    $endereco = $_POST['endereco'];
    $preco = $_POST['preco'];
    $tipo = $_POST['tipo'];
    $imagem = $_FILES['imagem']['name'];

    // Upload da imagem, se houver nova imagem
    if (!empty($imagem)) {
        $target_dir = "img/";
        $target_file = $target_dir . basename($_FILES["imagem"]["name"]);
        move_uploaded_file($_FILES["imagem"]["tmp_name"], $target_file);
        $sql_imagem = ", imagem = ?";
    } else {
        $sql_imagem = "";
    }

    $sql = "UPDATE quadra SET nome = ?, endereco = ?, preco = ?, tipo = ? $sql_imagem WHERE id_quadra = ?";
    $stmt = $conn->prepare($sql);
    if (!empty($imagem)) {
        $stmt->bind_param("ssdssi", $nome, $endereco, $preco, $tipo, $imagem, $quadra_id);
    } else {
        $stmt->bind_param("ssdsi", $nome, $endereco, $preco, $tipo, $quadra_id);
    }

    if ($stmt->execute()) {
        // Atualizar horários
        if (!empty($_POST['dias']) && !empty($_POST['hora_inicio']) && !empty($_POST['hora_fim'])) {
            $datas = $_POST['dias'];
            $horas_inicio = $_POST['hora_inicio'];
            $horas_fim = $_POST['hora_fim'];

            $sql_horarios = "DELETE FROM horario WHERE id_quadra = ?";
            $stmt_horarios = $conn->prepare($sql_horarios);
            $stmt_horarios->bind_param("i", $quadra_id);
            $stmt_horarios->execute();

            $sql_horarios_insert = "INSERT INTO horario (id_quadra, hora_inicio, hora_fim, data) VALUES (?, ?, ?, ?)";
            $stmt_horarios_insert = $conn->prepare($sql_horarios_insert);
            foreach ($datas as $index => $data) {
                $hora_inicio = $horas_inicio[$index];
                $hora_fim = $horas_fim[$index];
                $stmt_horarios_insert->bind_param("isss", $quadra_id, $hora_inicio, $hora_fim, $data);
                $stmt_horarios_insert->execute();
            }
        }
        header("Location: painel-admin.php");
    } else {
        echo "Erro ao atualizar quadra: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Quadra</title>
    <link rel="stylesheet" href="styles/styles.css">

</head>
<style>
/* Estilo geral */
body {
    font-family: 'Poppins', sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
}

/* Cabeçalho */
header {
    background-color: #2c3e50;
    color: #fff;
    padding: 20px 0;
    text-align: center;
    width: 100%;
}

header h1 {
    margin: 0;
    font-size: 2.5rem;
}

/* Navegação */
nav ul {
    list-style: none;
    padding: 10px;
    display: flex;
    justify-content: center;
    margin: 0;
}

nav ul li {
    margin-right: 20px;
}

nav ul li a {
    color: #fff;
    text-decoration: none;
    font-size: 1.2rem;
    padding: 8px 15px;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

nav ul li a:hover {
    background-color: #16a085;
}

/* Seção do formulário */
.container {
    width: 100%;
    max-width: 900px;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    margin-top: 20px;
}

h2 {
    text-align: center;
    font-size: 2rem;
    color: #333;
    margin-bottom: 20px;
}

a.btn-voltar {
    display: inline-block;
    margin-bottom: 20px;
    color: #333;
    text-decoration: none;
    background-color: #f8f8f8;
    padding: 8px 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

a.btn-voltar:hover {
    background-color: #e0e0e0;
}

/* Formulário */
.form-section {
    width: 100%;
}

label {
    font-size: 1.1em;
    color: #555;
    margin-bottom: 8px;
    display: block;
}

input[type="text"],
select,
input[type="file"],
input[type="date"],
input[type="time"] {
    width: 100%;
    padding: 12px;
    margin-bottom: 20px;
    border: 2px solid black;
    border-radius: 4px;
    font-size: 1em;
}

input[type="text"]:focus,
select:focus,
input[type="file"]:focus,
input[type="date"]:focus,
input[type="time"]:focus {
    border-color: #4CAF50;
    outline: none;
}

button[type="submit"],
button#addHorario {
    background-color: #4CAF50;
    color: white;
    font-size: 1.2em;
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    width: 100%;
    margin-bottom: 20px;
}

button[type="submit"]:hover,
button#addHorario:hover {
    background-color: #45a049;
}

button.remover-horario {
    background-color: #e74c3c;
    color: white;
    border: none;
    padding: 8px 15px;
    border-radius: 4px;
    cursor: pointer;
    margin-top: 10px;
}

button.remover-horario:hover {
    background-color: #c0392b;
}

/* Mensagens de erro */
.error-message {
    color: red;
    text-align: center;
    margin-top: 10px;
    font-size: 1.1em;
}
#horarios {
    margin-top: 20px;
    display: flex;
    flex-direction: column;
    gap: 20px; /* Adiciona um espaço entre cada item */
}

button#addHorario {
    background-color: #4CAF50;
    color: white;
    font-size: 1.2em;
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    width: 100%;
    margin-top: 20px;
}

button#addHorario:hover {
    background-color: #45a049;
}

/* Estilo para remover o horário */
#horarios div {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
}

#horarios div input[type="date"],
#horarios div input[type="time"] {
    width: 30%;
    margin-right: 10px;
}

/* Estilos adicionais */
img {
    margin-top: 10px;
    border-radius: 4px;
}

#horarios {
    margin-top: 20px;
}

/* Adicionando mais espaçamento entre os itens */
.form-section > div {
    margin-bottom: 20px;
}


</style>
<body>
    <header>
        <h1>Editar Quadra</h1>
        <nav>
            <ul>
                <li><a href="minhas-quadras.php">Minhas Quadras</a></li>
                <li><a href="painel-admin.php">Painel</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">


    <form action="editar-quadra.php?id=<?= $quadra['id_quadra'] ?>" method="POST" enctype="multipart/form-data">
        <div>
            <label for="nome">Nome da Quadra:</label>
            <input type="text" id="nome" name="nome" value="<?= $quadra['nome'] ?>" required>
        </div>
        <div>
            <label for="endereco">Endereço:</label>
            <input type="text" id="endereco" name="endereco" value="<?= $quadra['endereco'] ?>" required>
        </div>
        <div>
            <label for="preco">Preço (por hora):</label>
            <input type="text" id="preco" name="preco" value="<?= $quadra['preco'] ?>" required>
        </div>
        <div>
            <label for="tipo">Tipo de Quadra:</label>
            <select id="tipo" name="tipo" required>
                <option value="society" <?= $quadra['tipo'] == 'society' ? 'selected' : '' ?>>Society</option>
                <option value="futsal" <?= $quadra['tipo'] == 'futsal' ? 'selected' : '' ?>>Futsal</option>
            </select>
        </div>
        <div>
            <label for="imagem">Imagem da Quadra:</label>
            <input type="file" id="imagem" name="imagem">
            <img src="img/<?= $quadra['imagem'] ?>" alt="Imagem da quadra" width="100">
        </div>
        <div id="horarios">
            <label>Horários Disponíveis:</label>
            <?php
                $sql_horarios = "SELECT * FROM horario WHERE id_quadra = ?";
                $stmt_horarios = $conn->prepare($sql_horarios);
                $stmt_horarios->bind_param("i", $quadra_id);
                $stmt_horarios->execute();
                $result_horarios = $stmt_horarios->get_result();
                while ($horario = $result_horarios->fetch_assoc()):
            ?>
            <div>
                <input type="date" name="dias[]" value="<?= $horario['data'] ?>" required>
                <input type="time" name="hora_inicio[]" value="<?= $horario['hora_inicio'] ?>" required>
                <input type="time" name="hora_fim[]" value="<?= $horario['hora_fim'] ?>" required>
                <button type="button" class="remover-horario">Remover</button>
            </div>
            <?php endwhile; ?>
            <button type="button" id="addHorario">Adicionar horário</button>
        </div>
        <button type="submit">Atualizar Quadra</button>
    </form>
</div>
<script>
// Função para adicionar horários
document.getElementById("addHorario").addEventListener("click", function() {
    const horariosContainer = document.getElementById("horarios");
    const novoHorario = document.createElement("div");
    novoHorario.classList.add("horario-item");
    novoHorario.innerHTML = ` 
        <input type="date" name="dias[]" required>
        <input type="time" name="hora_inicio[]" required>
        <input type="time" name="hora_fim[]" required>
        <button type="button" class="remover-horario">Remover</button>
    `;
    
    // Insere o novo horário antes do botão
    horariosContainer.insertBefore(novoHorario, document.getElementById("addHorario"));

    // Adiciona o evento de remover o horário
    novoHorario.querySelector(".remover-horario").addEventListener("click", function() {
        novoHorario.remove();
    });
});

// Remover horários existentes
document.querySelectorAll(".remover-horario").forEach(function(button) {
    button.addEventListener("click", function() {
        button.parentElement.remove();
    });
});
// Remover horários existentes
document.querySelectorAll(".remover-horario").forEach(function(button) {
    button.addEventListener("click", function() {
        const id_horario = button.getAttribute("data-id");

        // Enviar a requisição AJAX para o PHP
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "remover-horario.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function() {
            if (xhr.status === 200) {
                if (xhr.responseText === "sucesso") {
                    button.parentElement.remove(); // Remove o horário da interface
                } else {
                    alert("Erro ao remover o horário.");
                }
            }
        };
        xhr.send("id_horario=" + id_horario);
    });
});
</script>
</body>
</html>

<?php
// Fechar a conexão
$stmt->close();
$conn->close();
?>

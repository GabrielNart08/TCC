<?php
// Verificar se o usuário está logado como administrador
session_start();


// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "reservaquadras";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
// Receber dados do formulário
$nome = $_POST['nome'];
$endereco = $_POST['endereco'];
$preco = $_POST['preco'];
$imagem = $_FILES['imagem']['name'];
$horarios = $_POST['dias'];  // Array de dias
$hora_inicio = $_POST['hora_inicio'];  // Array de horas de início
$hora_fim = $_POST['hora_fim'];  // Array de horas de fim

// Upload da imagem
$target_dir = "img/";
$target_file = $target_dir . basename($_FILES["imagem"]["name"]);
move_uploaded_file($_FILES["imagem"]["tmp_name"], $target_file);

// Inserir quadra
$sql = "INSERT INTO quadra (nome, endereco, preco, imagem, id_usuario) VALUES ('$nome', '$endereco', '$preco', '$imagem', '{$_SESSION['user_id']}')";
if ($conn->query($sql) === TRUE) {
    $id_quadra = $conn->insert_id;  // ID da quadra inserida

    // Inserir horários
    for ($i = 0; $i < count($horarios); $i++) {
        $dia_semana = $horarios[$i];
        $hora_inicio_value = $hora_inicio[$i];
        $hora_fim_value = $hora_fim[$i];
        $sql_horario = "INSERT INTO horario (id_quadra, dia_semana, hora_inicio, hora_fim) 
                        VALUES ('$id_quadra', '$dia_semana', '$hora_inicio_value', '$hora_fim_value')";
        $conn->query($sql_horario);
    }

    echo "Quadra cadastrada com sucesso!";
} else {
    echo "Erro ao cadastrar quadra: " . $conn->error;
}

}

$conn->close();
?>


<link rel="stylesheet" href="styles/cadastroquad.css">

<div class="container">
    <h2>Cadastrar Nova Quadra</h2>
    <form action="cadastro_quadras.php" method="POST" enctype="multipart/form-data">
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

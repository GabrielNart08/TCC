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

// Processar o cadastro de quadra
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $endereco = $_POST['endereco'];
    $preco = $_POST['preco'];
    $imagem = $_FILES['imagem']['name'];
    $horarios = $_POST['horarios'];

    // Upload da imagem
    $target_dir = "img/";
    $target_file = $target_dir . basename($_FILES["imagem"]["name"]);
    move_uploaded_file($_FILES["imagem"]["tmp_name"], $target_file);

    // Inserir no banco de dados
    $sql = "INSERT INTO quadra (nome, endereco, preco, imagem, horarios, id_usuario) VALUES ('$nome', '$endereco', '$preco', '$imagem', '$horarios', '{$_SESSION['user_id']}')";
    if ($conn->query($sql) === TRUE) {
        echo "Quadra cadastrada com sucesso!";
    } else {
        echo "Erro ao cadastrar quadra: " . $conn->error;
    }
}

$conn->close();
?>

<!-- Formulário de Cadastro -->
<h2>Cadastrar Nova Quadra</h2>
<form action="quadras.php" method="POST" enctype="multipart/form-data">
    <label for="nome">Nome da Quadra:</label>
    <input type="text" id="nome" name="nome" required><br><br>
    
    <label for="endereco">Endereço:</label>
    <input type="text" id="endereco" name="endereco" required><br><br>
    
    <label for="preco">Preço (por hora):</label>
    <input type="text" id="preco" name="preco" required><br><br>
    
    <label for="imagem">Imagem da Quadra:</label>
    <input type="file" id="imagem" name="imagem" required><br><br>
    
    <label for="horarios">Horários Disponíveis:</label>
    <textarea id="horarios" name="horarios" rows="4" cols="50" required></textarea><br><br>
    
    <button type="submit">Cadastrar Quadra</button>
</form>

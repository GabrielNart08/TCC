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

// Verifica se o ID do horário foi enviado
if (isset($_POST['id_horario'])) {
    $id_horario = $_POST['id_horario'];

    // Remove o horário do banco de dados
    $sql = "DELETE FROM horario WHERE id_horario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_horario);

    if ($stmt->execute()) {
        echo "sucesso";
    } else {
        echo "erro";
    }

    $stmt->close();
    $conn->close();
}
?>

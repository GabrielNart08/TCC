<?php
session_start();
require 'conexao.php';

// Verificar se os dados foram recebidos
if (isset($_GET['horario'], $_GET['nome'], $_GET['valor'], $_SESSION['user_id'])) {
    $horario = $_GET['horario'];
    $nome = $_GET['nome'];
    $valor = $_GET['valor'];
    $usuario_id = $_SESSION['user_id']; // ID do usuário que está logado

    $stmt = $conn->prepare("INSERT INTO reservas (usuario_id, horario, valor) VALUES (?, ?, ?)");
    $stmt->bind_param("isi", $usuario_id, $horario, $valor);

    if ($stmt->execute()) {
        echo "Reserva confirmada!";
    } else {
        echo "Erro ao salvar a reserva: " . $stmt->error;
    }
} else {
    echo "Dados de reserva não encontrados.";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Pagamento Confirmado</title>
</head>
<body>
    <h1>Pagamento Confirmado!</h1>
    <p>Obrigado pela sua reserva!</p>
    <a href="index.php">Voltar à tela inicial</a>
</body>
</html>

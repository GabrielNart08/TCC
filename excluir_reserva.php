<?php
session_start();
require 'conexao.php';  // Certifique-se de que você tem a conexão com o banco de dados.

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    die('Acesso não autorizado');
}

if (isset($_POST['id_reserva'])) {
    $id_reserva = $_POST['id_reserva'];
    
    // Verifica se a reserva realmente pertence ao usuário logado
    $user_id = $_SESSION['user_id'];
    $query = "SELECT id_reserva FROM reservas WHERE id_reserva = '$id_reserva' AND id_usuario = '$user_id' AND status = 'Em Análise'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        // Exclui a reserva
        $delete_query = "DELETE FROM reservas WHERE id_reserva = '$id_reserva'";
        if (mysqli_query($conn, $delete_query)) {
            echo "Reserva excluída com sucesso!";
        } else {
            echo "Erro ao excluir reserva.";
        }
    } else {
        echo "Reserva não encontrada ou não é sua.";
    }
} else {
    echo "Nenhum ID de reserva fornecido.";
}
?>

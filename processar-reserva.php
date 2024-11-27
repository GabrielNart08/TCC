<?php
session_start();
require 'conexao.php';


$id_admin = $_SESSION['user_id'];

// Verificar se os dados foram enviados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_reserva']) && isset($_POST['acao'])) {
    $id_reserva = $_POST['id_reserva'];
    $acao = $_POST['acao'];

    // Consultar a reserva no banco de dados para garantir que ela pertence ao administrador
    $query_reserva = "SELECT r.id_reserva, r.status, q.id_usuario FROM reservas r JOIN quadra q ON r.id_quadra = q.id_quadra WHERE r.id_reserva = '$id_reserva' AND q.id_usuario = '$id_admin'";
    $result_reserva = mysqli_query($conn, $query_reserva);

    if (mysqli_num_rows($result_reserva) > 0) {
        // Definir a ação de acordo com o valor de 'acao'
        if ($acao == 'confirmar') {
            // Atualizar o status para "Confirmada"
            $query_atualiza_status = "UPDATE reservas SET status = 'Confirmada' WHERE id_reserva = '$id_reserva'";
        } elseif ($acao == 'cancelar') {
            // Atualizar o status para "Cancelada"
            $query_atualiza_status = "UPDATE reservas SET status = 'Cancelada' WHERE id_reserva = '$id_reserva'";
        } elseif ($acao == 'ok') {
            // Atualizar o status para "Ok"
            $query_atualiza_status = "UPDATE reservas SET status = 'Ok' WHERE id_reserva = '$id_reserva'";
        } elseif ($acao == 'Não Compareceu') {
            // Atualizar o status para "Não Compareceu"
            $query_atualiza_status = "UPDATE reservas SET status = 'Não Compareceu' WHERE id_reserva = '$id_reserva'";
        } elseif ($acao == 'excluir') {
            // Excluir a reserva
            $query_excluir_reserva = "DELETE FROM reservas WHERE id_reserva = '$id_reserva'";
        } else {
            echo "Ação inválida.";
            exit;
        }

        // Verificar se a ação é para atualizar o status ou excluir a reserva
        if (isset($query_atualiza_status)) {
            // Executar a atualização do status
            if (mysqli_query($conn, $query_atualiza_status)) {
                // Redirecionar para a página de reservas após a atualização
                header('Location: painel-admin.php');  // Substitua pelo nome correto da página
                exit;
            } else {
                echo "Erro ao atualizar o status da reserva: " . mysqli_error($conn);
            }
        } elseif (isset($query_excluir_reserva)) {
            // Executar a exclusão da reserva
            if (mysqli_query($conn, $query_excluir_reserva)) {
                // Redirecionar para a página de reservas após a exclusão
                header('Location: painel-admin.php?status=excluida');  // Redireciona com o parâmetro de sucesso
                exit;
            } else {
                echo "Erro ao excluir a reserva: " . mysqli_error($conn);
            }
        }
    } else {
        echo "Reserva não encontrada ou você não tem permissão para modificar essa reserva.";
    }
} else {
    echo "Dados inválidos ou método inválido.";
}
?>

<?php
session_start();
require 'conexao.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'administrador') {
    header('Location: login.php');
    exit;
}

$id_admin = $_SESSION['user_id'];

// Buscar reservas "em análise" para as quadras do administrador
$query_reservas = "
    SELECT r.id_reserva, r.data_reserva, r.status, u.nome AS nome_usuario, q.nome AS nome_quadra, q.endereco
    FROM reservas r
    JOIN usuario u ON r.id_usuario = u.id_usuario
    JOIN quadra q ON r.id_quadra = q.id_quadra
    WHERE r.status = 'em analise' AND q.id_usuario = '$id_admin'
";

$result_reservas = mysqli_query($conn, $query_reservas);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Reservas</title>
</head>
<body>
    <h1>Reservas Pendentes</h1>
    <table border="1">
        <tr>
            <th>Usuário</th>
            <th>Quadra</th>
            <th>Endereço</th>
            <th>Data</th>
            <th>Status</th>
            <th>Ações</th>
        </tr>
        <?php while ($reserva = mysqli_fetch_assoc($result_reservas)): ?>
            <tr>
                <td><?= htmlspecialchars($reserva['nome_usuario']); ?></td>
                <td><?= htmlspecialchars($reserva['nome_quadra']); ?></td>
                <td><?= htmlspecialchars($reserva['endereco']); ?></td>
                <td><?= htmlspecialchars($reserva['data_reserva']); ?></td>
                <td><?= htmlspecialchars($reserva['status']); ?></td>
                <td>
                    <form method="post" action="processar-reserva.php" style="display: inline;">
                        <input type="hidden" name="id_reserva" value="<?= $reserva['id_reserva']; ?>">
                        <button type="submit" name="acao" value="confirmar">Confirmar</button>
                    </form>
                    <form method="post" action="processar-reserva.php" style="display: inline;">
                        <input type="hidden" name="id_reserva" value="<?= $reserva['id_reserva']; ?>">
                        <button type="submit" name="acao" value="cancelar">Cancelar</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

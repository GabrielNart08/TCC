<?php
session_start();
require 'conexao.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'administrador') {
    header('Location: login.php');
    exit;
}

$id_admin = $_SESSION['user_id'];

// Alterando a consulta SQL para pegar as reservas confirmadas
$query_reservas = "
    SELECT r.id_reserva, r.status, c.nome_completo AS nome_usuario, c.cpf, q.nome AS nome_quadra, q.endereco, r.id_horario
    FROM reservas r
    JOIN clientes c ON r.id_cliente = c.id_cliente  -- Pegando dados diretamente da tabela clientes
    JOIN quadra q ON r.id_quadra = q.id_quadra
    WHERE r.status = 'confirmada' AND q.id_usuario = '$id_admin'
";

$result_reservas = mysqli_query($conn, $query_reservas);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/reservasconf.css">
    <title>Admin - Reservas Confirmadas</title>
    <style>
        /* Estilo básico para o botão de voltar */
        .btn-voltar {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            text-align: center;
            text-decoration: none;
        }
        .btn-voltar:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Reservas Confirmadas</h1>

    <table border="1">
        <tr>
            <th>Usuário</th>
            <th>Quadra</th>
            <th>CPF</th>
            <th>Data e Horário</th>
            <th>Status</th>
            <th>Ações</th>
        </tr>
        <?php while ($reserva = mysqli_fetch_assoc($result_reservas)): ?>
            <?php
            // Buscar o horário e a data da reserva com base no id_horario
            $id_horario = $reserva['id_horario'];
            $query_horario = "SELECT hora_inicio, hora_fim, dia_semana FROM horario WHERE id_horario = '$id_horario'";
            $result_horario = mysqli_query($conn, $query_horario);
            $horario = mysqli_fetch_assoc($result_horario);
            ?>
            <tr>
                <td><?= htmlspecialchars($reserva['nome_usuario']); ?></td>
                <td><?= htmlspecialchars($reserva['nome_quadra']); ?></td>
                <td><?= htmlspecialchars($reserva['cpf']); ?></td>
                <td>
                    <?= htmlspecialchars($horario['dia_semana']); ?> 
                    <?= htmlspecialchars($horario['hora_inicio']) . ' - ' . htmlspecialchars($horario['hora_fim']); ?>
                </td>
                <td><?= htmlspecialchars($reserva['status']); ?></td>
                <td>
                    <!-- Botões OK e Não Compareceu -->
                    <form method="post" action="processar-reserva.php" style="display: inline;">
                        <input type="hidden" name="id_reserva" value="<?= $reserva['id_reserva']; ?>">
                        <button type="submit" name="acao" value="ok">OK</button>
                    </form>
                    <form method="post" action="processar-reserva.php" style="display: inline;">
                        <input type="hidden" name="id_reserva" value="<?= $reserva['id_reserva']; ?>">
                        <button type="submit" name="acao" value="nao_compareceu">Não Compareceu</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <!-- Botão de Voltar -->
    <a href="painel-admin.php" class="btn-voltar">Voltar para o Painel</a>

</body>
</html>
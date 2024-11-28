<?php
session_start();
require 'conexao.php';

// Verifica se o usuário está logado e se é administrador
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'administrador') {
    header("Location: login.php");
    exit();
}

$id_admin = $_SESSION['user_id'];

// Alterando a consulta SQL para pegar as reservas com status "OK" ou "Não Compareceu"
$query_reservas = "
    SELECT r.id_reserva, r.status, c.nome_completo AS nome_usuario, c.cpf, q.nome AS nome_quadra, q.endereco, r.id_horario
    FROM reservas r
    JOIN clientes c ON r.id_cliente = c.id_cliente
    JOIN quadra q ON r.id_quadra = q.id_quadra
    WHERE r.status IN ('OK', 'nao_compareceu') AND q.id_usuario = '$id_admin'
";

$result_reservas = mysqli_query($conn, $query_reservas);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Reservas Finalizadas</title>
    <link rel="stylesheet" href="styles/reservasconf.css">
    <style>

h1 {
    background-color:darkblue;
    color: white;
    padding: 20px;
    text-align: center;
    margin: 0;
}

table th {
    background-color: darkblue;
    color: white;
}
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
    <h1>Reservas Finalizadas (OK / Não Compareceu)</h1>

    <table border="1">
        <tr>
            <th>Usuário</th>
            <th>Quadra</th>
            <th>CPF</th>
            <th>Data e Horário</th>
            <th>Status</th>
        </tr>
        <?php while ($reserva = mysqli_fetch_assoc($result_reservas)): ?>
            <?php
            // Buscar o horário e a data da reserva com base no id_horario
            $id_horario = $reserva['id_horario'];
            $query_horario = "SELECT hora_inicio, hora_fim, data FROM horario WHERE id_horario = '$id_horario'";
            $result_horario = mysqli_query($conn, $query_horario);
            $horario = mysqli_fetch_assoc($result_horario);

            // Formatar a data para o formato dia/mês/ano
            $data_reserva = date('d/m/Y', strtotime($horario['data']));
            ?>
            <tr>
                <td><?= htmlspecialchars($reserva['nome_usuario']); ?></td>
                <td><?= htmlspecialchars($reserva['nome_quadra']); ?></td>
                <td><?= htmlspecialchars($reserva['cpf']); ?></td>
                <td>
                    <?= $data_reserva; ?> 
                    <?= htmlspecialchars($horario['hora_inicio']) . ' - ' . htmlspecialchars($horario['hora_fim']); ?>
                </td>
                <td><?= htmlspecialchars($reserva['status']); ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <!-- Botão de Voltar -->
    <a href="painel-admin.php" class="btn-voltar">Voltar para o Painel</a>

</body>
</html>

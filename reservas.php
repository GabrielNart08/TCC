<?php
session_start();
require 'conexao.php';  // Certifique-se de que você tem a conexão com o banco de dados.

// Verificar se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];  // Obter o ID do usuário logado

// Consulta SQL para buscar as reservas feitas pelo usuário
$query_reservas = "
    SELECT r.id_reserva, r.status, q.nome AS nome_quadra, q.imagem AS foto_quadra, r.id_horario, r.data_reserva
    FROM reservas r
    JOIN quadra q ON r.id_quadra = q.id_quadra
    WHERE r.id_usuario = '$user_id'
";

$result_reservas = mysqli_query($conn, $query_reservas);

// Verifique se a consulta retornou resultados
if (!$result_reservas) {
    die("Erro na consulta: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/home.css">
    <link rel="stylesheet" href="styles/header.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>Página Inicial</title>
    <style>

        /* Estilo para o botão de cancelar reserva */
.cancel-btn {
    background-color: #e74c3c;  /* Cor de fundo vermelha */
    color: white;               /* Cor do texto branca */
    border: none;               /* Remove a borda padrão */
    padding: 10px 20px;         /* Espaçamento interno */
    border-radius: 25px;        /* Bordas arredondadas */
    cursor: pointer;            /* Cursor em forma de mão ao passar sobre o botão */
    font-size: 16px;            /* Tamanho da fonte */
    transition: background-color 0.3s ease; /* Transição suave na cor de fundo */
}

/* Efeito de hover */
.cancel-btn:hover {
    background-color: #c0392b;  /* Cor de fundo mais escura quando o mouse passa */
}

        /* Container de reserva */
        .reservation-container {
            display: flex;
            flex-direction: row;
            margin: 20px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            background-color: #f9f9f9;
            width: 90%;
            max-width: 800px;
            border: 2px solid #1d1d1d;  /* Borda preta */
        }

        /* Efeito de hover na reserva */
        .reservation-container:hover {
            transform: scale(1.02);
        }

       /* Imagem da reserva */
/* Imagem da reserva */
.reservation-img {
    width: 150px;  /* Ajuste a largura desejada */
    height: auto;  /* A altura será proporcional à largura */
    margin-right: 20px;
    border-radius: 8px;
    overflow: hidden;
    display: flex;
    justify-content: flex-start; /* Alinha a imagem à esquerda */
    align-items: center;
}

/* Aplique a propriedade object-fit na imagem */
.reservation-img img {
    width: 100%;  /* A imagem ocupa toda a largura do container */
    height: auto; /* Ajusta a altura automaticamente */
    object-fit: contain; /* A imagem vai se ajustar sem cortar */
    border-radius: 8px;
}



        /* Informações da reserva */
        .reservation-info {
            display: flex;
            flex-direction: column;
            gap: 10px;
            flex-grow: 1;
            border: 2px solid #ccc;
            border-radius: 8px;
            padding: 15px;
            background-color: #ffffff;
        }

        /* Nome da quadra */
        .reservation-info h3 {
            margin-bottom: 10px;
            text-align: center;
        }

        /* Status da reserva */
        .reservation-status {
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 5px;
            width: fit-content;
            margin-bottom: 10px;
        }

        /* Horário da reserva */
        .reservation-info p {
            margin-bottom: 10px;
            text-align: center;
        }

        .reservation-status.pendente {
            background-color: yellow;
            color:  #1d1d1d;
        }

        .reservation-status.confirmada {
            background-color: green;
            color:  #1d1d1d;
        }

        .reservation-status.cancelada {
            background-color: red;
            color:  #1d1d1d;
        }

        .reservation-status.ok {
            background-color: green;
            color:  #1d1d1d;
        }

        .reservation-status.nao-compareceu {
            background-color: gray;
            color: #1d1d1d;
        }

        /* Título da página */
        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        /* Estilo para o Modal */
.modal {
    display: none; /* Inicialmente oculto */
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    justify-content: center;
    align-items: center;
}

.modal-content {
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    width: 400px;
    text-align: center;
}

.modal button {
    margin-top: 10px;
    padding: 10px;
    border: none;
    cursor: pointer;
}

.btn-confirm {
    background-color: red;
    color: white;
}

.btn-close {
    background-color: green;
    color: white;
}

    p {
        text-align: center;
    }
    </style>
</head>
<body>
<header>
    <nav id="navbar">
        <i class="fa-regular fa-futbol" id="logo">FutReserva</i>
        <ul id="nav_list">
            <li id="nav-item">
                <a href="index.php">Início</a>
            </li>
            <li id="nav-item">
                <a href="quadras.php">Quadras</a>
            </li>
            <li id="nav-item">
                <a href="contatos.php">Contato</a>
            </li>
            <li id="nav-item">
                <a href="reservas.php">Minhas Reservas</a>
            </li>
        </ul>
        <div id="login-section">
            <?php if (!isset($_SESSION['user_id'])): ?>
                <button id="btn-default">
                    <a href="login.php" id="Login-botton">Login</a>
                </button>
            <?php endif; ?>
        </div>

        <div id="user-section">
            <?php if (isset($_SESSION['user_id'])): ?>
                <i class="fa-regular fa-user" id="profile-icon"></i>
            <?php endif; ?>
        </div>
    </nav>
</header>

<!-- Conteúdo Principal -->
<div class="container">
    <h1>Minhas Reservas</h1>
    <?php if (mysqli_num_rows($result_reservas) > 0): ?>
        <div class="reservations-list">
            <?php while ($reserva = mysqli_fetch_assoc($result_reservas)): ?>
                <?php
                // Buscar o horário da reserva
                $id_horario = $reserva['id_horario'];
                $query_horario = "SELECT hora_inicio, hora_fim FROM horario WHERE id_horario = '$id_horario'";
                $result_horario = mysqli_query($conn, $query_horario);
                $horario = mysqli_fetch_assoc($result_horario);
                $data_reserva = date('d/m/Y', strtotime($reserva['data_reserva']));  // Formata a data
                ?>
 <div class="reservation-container">
    <!-- Imagem da quadra -->
    <div class="reservation-img">
    <img src="img/<?= htmlspecialchars($reserva['foto_quadra']); ?>" alt="<?= htmlspecialchars($reserva['nome_quadra']); ?>">

    </div>
    <div class="reservation-info">
        <h3><?= htmlspecialchars($reserva['nome_quadra']); ?></h3>
        <p><strong>Status:</strong> 
            <span class="reservation-status <?= strtolower(str_replace(' ', '-', $reserva['status'])); ?>">
                <?= htmlspecialchars($reserva['status']); ?>
            </span>
        </p>
        <p><strong>Data:</strong> <?= $data_reserva; ?></p>
        <p><strong>Horário:</strong> <?= htmlspecialchars($horario['hora_inicio']) . ' - ' . htmlspecialchars($horario['hora_fim']); ?></p>
        
        <!-- Botão de Cancelar reserva visível apenas para reservas "em análise" -->
        <?php if ($reserva['status'] == 'em análise'): ?>
            <button class="cancel-btn" data-reserva-id="<?= $reserva['id_reserva']; ?>" data-nome-quadra="<?= htmlspecialchars($reserva['nome_quadra']); ?>">Cancelar Reserva</button>

        <?php endif; ?>
    </div>
</div>

            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p>Você não tem reservas.</p>
    <?php endif; ?>
</div>

<!-- Modal de confirmação -->
<div id="cancelModal" class="modal">
    <div class="modal-content">
        <h3>Você tem certeza que quer excluir sua reserva?</h3>
        <p id="modal-info"></p>
        <button id="confirm-cancel" class="btn-confirm">Sim</button>
        <button id="close-modal" class="btn-close">Não</button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var sidebar = document.getElementById('sidebar');
        var profileIcon = document.getElementById('profile-icon');
        var closeButton = document.getElementById('close-sidebar');

        sidebar.style.width = '0';

        function openSidebar() {
            sidebar.style.width = '250px';
        }

        function closeSidebar() {
            sidebar.style.width = '0';
        }

        profileIcon.addEventListener('click', openSidebar);

        closeButton.addEventListener('click', closeSidebar);
    });

    document.addEventListener('DOMContentLoaded', function () {
    // Abre o modal com informações
    const cancelBtns = document.querySelectorAll('.cancel-btn');
    const modal = document.getElementById('cancelModal');
    const modalInfo = document.getElementById('modal-info');
    const confirmCancelBtn = document.getElementById('confirm-cancel');
    const closeModalBtn = document.getElementById('close-modal');
    let reservaId = null;

    cancelBtns.forEach(button => {
        button.addEventListener('click', function () {
            reservaId = this.getAttribute('data-reserva-id');
            const nomeQuadra = this.getAttribute('data-nome-quadra');
            modalInfo.innerText = `Você está prestes a cancelar a reserva da quadra: ${nomeQuadra}.`;
            modal.style.display = 'flex';
        });
    });

    // Fecha o modal sem excluir
    closeModalBtn.addEventListener('click', function () {
        modal.style.display = 'none';
    });

    // Confirma a exclusão e chama o PHP para excluir a reserva
    confirmCancelBtn.addEventListener('click', function () {
        if (reservaId) {
            // Envia a requisição para excluir a reserva via AJAX
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'excluir_reserva.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert('Reserva excluída com sucesso!');
                    location.reload(); // Atualiza a página para refletir a exclusão
                }
            };
            xhr.send('id_reserva=' + reservaId);
        }
        modal.style.display = 'none';
    });
});

</script>
</body>
</html>

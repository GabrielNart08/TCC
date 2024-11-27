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
    SELECT r.id_reserva, r.status, q.nome AS nome_quadra, q.imagem AS foto_quadra, r.id_horario
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
/* Container de reserva */
.reservation-container {
    display: flex; /* Usar flexbox para alinhar os itens lado a lado */
    flex-direction: row; /* Alinha os itens na horizontal (imagem à esquerda, informações à direita) */
    margin: 20px auto; /* Centraliza o container e dá margem entre as reservas */
    padding: 50px; /* Ajusta o padding para uma área interna confortável */
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    background-color: #f9f9f9;
    width: 90%; /* Ajuste para que o container não ocupe toda a largura */
    max-width: 800px; /* Limita a largura máxima para manter o design controlado */
    transition: transform 0.3s ease;
    margin-left: 20px; /* Adiciona um espaço à esquerda do container */
}

/* Efeito de hover na reserva */
.reservation-container:hover {
    transform: scale(1.02); /* Efeito de zoom ao passar o mouse */
}

/* Imagem da reserva */
.reservation-img {
    width: 150px; /* Tamanho fixo para a imagem */
    height: 100px; /* Altura da imagem */
    margin-right: 20px; /* Espaço entre a imagem e as informações */
    border-radius: 8px;
    object-fit: cover;
}

/* Informações da reserva */
.reservation-info {
    display: flex;
    flex-direction: column; /* Alinha as informações na vertical */
    justify-content: center; /* Alinha as informações no centro verticalmente */
    align-items: center; /* Alinha as informações no centro horizontalmente */
    gap: 10px; /* Espaçamento entre os itens de texto */
    flex-grow: 1; /* Faz as informações ocuparem o espaço restante */
    border: 2px solid #ccc; /* Adiciona uma borda ao redor das informações */
    border-radius: 8px; /* Deixa os cantos arredondados */
    padding: 15px; /* Espaçamento interno */
    background-color: #ffffff; /* Cor de fundo branca para destacar */
}

/* Nome da quadra */
.reservation-info h3 {
    margin-bottom: 10px; /* Espaço entre o nome da quadra e o próximo item */
    text-align: center; /* Centraliza o nome da quadra */
}

/* Status da reserva */
.reservation-status {
    font-weight: bold;
    padding: 5px 10px;
    border-radius: 5px;
    width: fit-content;
    margin-bottom: 10px; /* Espaço entre o status e o horário */
}

/* Horário da reserva */
.reservation-info p {
    margin-bottom: 10px; /* Espaço entre o horário e o próximo item, se houver */
    text-align: center; /* Centraliza o texto */
}

/* Estilos específicos para o status da reserva */
.reservation-status.em-analise {
    background-color: yellow;
}

.reservation-status.confirmada {
    background-color: green;
    color: white;
}

.reservation-status.cancelada {
    background-color: red;
    color: white;
}

/* Botões de ação */
.reservation-actions button {
    padding: 8px 15px;
    margin-top: 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.reservation-actions button.cancelar {
    background-color: red;
    color: white;
}

.reservation-actions button.cancelar:hover {
    background-color: darkred;
}

/* Título da página */
h1 {
    text-align: center;
    margin-bottom: 30px; /* Maior espaço entre o título e as reservas */
    color: #333; /* Cor do título */
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

        <div id="sidebar">
            <div id="sidebar-header">
                <button id="close-sidebar">&times;</button>
            </div>
            <div id="sidebar-content">
                <div id="profile-section">
                    <h2 id="user-name">
                        <span style="color: white;">Bem-Vindo,</span>
                        <span style="color: green;"><?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : ""; ?></span>
                    </h2>
                </div>
                <div id="settings-section">
                    <a href="config.php">Configurações</a>
                    <br>
                    <a href="logout.php">Sair</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Conteúdo Principal -->
    <div class="container">
        <h1>Minhas Reservas</h1>
                            <br><br>
        <?php if (mysqli_num_rows($result_reservas) > 0): ?>
            <div class="reservations-list">
                <?php while ($reserva = mysqli_fetch_assoc($result_reservas)): ?>
                    <?php
                    // Buscar o horário da reserva
                    $id_horario = $reserva['id_horario'];
                    $query_horario = "SELECT hora_inicio, hora_fim FROM horario WHERE id_horario = '$id_horario'";
                    $result_horario = mysqli_query($conn, $query_horario);
                    $horario = mysqli_fetch_assoc($result_horario);
                    ?>
                   <div class="reservation-container">
                  
    <div class="reservation-info">
        <div>
            <h3><?= htmlspecialchars($reserva['nome_quadra']); ?></h3>
            <p><strong>Status:</strong> 
                <span class="reservation-status <?= strtolower(str_replace(' ', '-', $reserva['status'])); ?>">
                    <?= htmlspecialchars($reserva['status']); ?>
                </span>
            </p>
            <p><strong>Horário:</strong> <?= htmlspecialchars($horario['hora_inicio']) . ' - ' . htmlspecialchars($horario['hora_fim']); ?></p>
        </div>
        <div class="reservation-actions">
        <?php if ($reserva['status'] != 'confirmada'): ?>
    
<?php endif; ?>
        </div>
    </div>
</div>


                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>Você não tem reservas.</p>
        <?php endif; ?>
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
    </script>
</body>
</html>

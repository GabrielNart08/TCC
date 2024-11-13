<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/quadra.css">
    <link rel="stylesheet" href="styles/header.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <title>Nossas Quadras</title>
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

    <h2>Escolha em qual quadra você quer jogar</h2>

    <div class="container">
    <div class="item">
        <a href="society.php"> 
            <div class="image-container">
                <img src="img/societyquad.jpg" alt="society">
                <div class="overlay">
                    <h3>Quadra de Society</h3>
                    <p>Perfeita para jogos entre amigos, com espaço amplo e gramado sintético de qualidade.</p>
                </div>
            </div>
        </a>
    </div>
    <div class="item">
        <a href="futsal.php"> 
            <div class="image-container">
                <img src="img/futsalquad.jpg" alt="futsal">
                <div class="overlay">
                    <h3>Quadra de Futsal</h3>
                    <p>Ambiente fechado e piso ideal para jogadas rápidas e emocionantes partidas de futsal.</p>
                </div>
            </div>
        </a>
    </div>
</div>
    <script src="javascript/script.js"></script>
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
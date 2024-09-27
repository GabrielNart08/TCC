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
    <link rel="stylesheet" href="styles/home.css">
    <link rel="stylesheet" href="styles/header.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>Página Inicial</title>
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
                    <a href="quadras.php">Contato</a>
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
            <img src="path/to/profile-image.jpg" alt="Profile Picture" id="profile-image">
            <h2 id="user-name">Nome do Usuário</h2>
        </div>
        <div id="settings-section">
            <a href="config.php">Configurações</a>
            <br>
            <a href="logout.php">Sair</a>
        </div>
    </div>
</div>
      
    </header>

    <main id="content">
        <section id="home">
            <div class="shape"></div>
            <div id="cta">
                <h1 class="title">
                    Reserve com mais
                    <span>facilidade!</span>
                </h1>
                <p class="descricao">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                    Quisque sed aliquam est, tincidunt mollis eros. Ut sit amet lacinia urna. 
                </p>

                <div id="cta_button">
                    <a href="#" id="btn-default">Ver Quadras</a>
                    <a href="tel:+554899999-9999" id="phone">
                        <button id="btn-default"><i class="fa-solid fa-phone"></i></button>(48)99999-9999
                    </a>
                </div>

                <div class="social-media">
                    <a href="#">
                        <i class="fa-brands fa-whatsapp"></i>
                    </a>
                    <a href="#">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href="#">
                        <i class="fa-brands fa-facebook"></i>
                    </a>
                </div>
            </div>

            <div id="banner">
                <img src="img/telaprincipal1.png" alt="principal">
            </div>
        </section>
    </main>

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

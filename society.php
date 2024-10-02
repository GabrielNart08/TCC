<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/quadras.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/home.css">
    <link rel="stylesheet" href="styles/header.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>Aluguel de Quadras Esportivas</title>
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

    <div class="quadras-container">
    <div class="quadra">
        <img src="img/society.jpg" alt="Quadra Society 1" class="foto">
        <div class="detalhes">
            <h2 class="nome">Quadra Society 1</h2>
            <p>Endereço: Rua Exemplo, 123</p>
            <p>Valor: R$ 100/hora</p>
            <button>Ver mais</button>
        </div>
    </div>
    
    <div class="quadra">
        <img src="img/society.jpg" alt="Quadra Society 2" class="foto">
        <div class="detalhes">
            <h2 class="nome">Quadra Society 2</h2>
            <p>Endereço: Rua Exemplo, 456</p>
            <p>Valor: R$ 120/hora</p>
            <button>Ver mais</button>
        </div>
    </div>

    <div class="quadra">
        <img src="img/society.jpg" alt="Quadra Society 3" class="foto">
        <div class="detalhes">
            <h2 class="nome">Quadra Society 3</h2>
            <p>Endereço: Rua Exemplo, 789</p>
            <p>Valor: R$ 150/hora</p>
            <button>Ver mais</button>
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
</script>
</body>
</html>

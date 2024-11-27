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
    <title>Contato</title>
    <style>
        body {
            text-align: center;
        }
        h2 {
            margin: 25px 0;
        }
        #cta_button, .contact-info, .contact-form {
            margin-top: 20px;
        }
        .contact-image {
            width: 100%;
            max-width: 300px;
            margin: 0 auto 20px;
            display: block;
        }
        .contact-info p {
            font-size: 1.1em;
            margin: 10px 0;
        }
        .contact-info i {
            color: orangered;
        }
        .contact-info a, .social-media a {
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s;
        }
        .contact-info a:hover {
            color: #0056b3;
        }

        .social-media{
            display: flex;
        justify-content: center;
        gap: 20px; /* Espaçamento entre os ícones */
    margin-top: 20px;

        }
        .social-media a {
            color: #ff4500; /* Cor mais chamativa */
    font-size: 1.8em; /* Aumenta o tamanho dos ícones */
    border: 2px solid black;
    transition: color 0.3s;
        }
        .social-media a:hover {
            color: orange;
        }
        .contact-form {
            max-width: 400px;
            margin: 0 auto;
            text-align: left;
        }
        .contact-form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .contact-form input, .contact-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .contact-form button {
            width: 100%;
            padding: 12px;
            font-size: 1.1em;
            color: #fff;
            background-color: #28a745;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .contact-form button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <header>
        <nav id="navbar">
            <i class="fa-regular fa-futbol" id="logo">FutReserva</i>
            <ul id="nav_list">
                <li id="nav-item"><a href="index.php">Início</a></li>
                <li id="nav-item"><a href="quadras.php">Quadras</a></li>
                <li id="nav-item"><a href="contatos.php">Contato</a></li>
                <li id="nav-item"><a href="reservas.php">Minhas Reservas</a></li>
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

    <h2>Dúvida? Contate-nos</h2>
    
    <!-- Imagem centralizada -->
    <img src="img/contato.png" alt="Imagem de Contato" class="contact-image">

    <!-- Informações de contato -->
    <div class="contact-info">
        <p><i class="fas fa-phone"></i> Telefone: <a href="https://wa.me/5548998566251">(48) 99856-6251</a></p>
        <p><i class="fas fa-envelope"></i> E-mail: <a href="mailto:futreserva@gmail.com">futreserva@gmail.com</a></p>
        <p><i class="fas fa-map-marker-alt"></i> Endereço: Av. Universitária, 345 - Universitário, Criciúma - SC, 88806-000</p>
    </div>
        <!-- Redes Sociais -->
        <div class="social-media">
        <a href="https://wa.me/5548998566251" title="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
        <a href="https://www.instagram.com/gabriel.nart" title="Instagram"><i class="fa-brands fa-instagram"></i></a>
        <a href="https://www.facebook.com/gabrielserafimnart" title="Facebook"><i class="fa-brands fa-facebook"></i></a>
    </div>

    <!-- Formulário de Contato -->
    <div class="contact-form">
        <form action="processar_email.php" method="post">
            <label for="email">Seu E-mail:</label>
            <input type="email" id="email" name="email" required placeholder="Digite seu e-mail">

            <label for="message">Mensagem:</label>
            <textarea id="message" name="message" rows="5" required placeholder="Escreva sua mensagem"></textarea>

            <button type="submit">Enviar Mensagem</button>
        </form>
    </div>
    

    <div id="success-modal" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.2); text-align: center;">
    <i class="fa-solid fa-check-circle" style="color: green; font-size: 2em; margin-bottom: 10px;"></i>
    <p style="font-size: 1.2em; color: green; font-weight: bold;">E-mail enviado com sucesso!</p>
    <button onclick="closeModal()" style="margin-top: 10px; padding: 5px 10px; background-color: green; color: white; border: none; border-radius: 5px; cursor: pointer;">OK</button>
</div>

    <!-- Sidebar Script -->
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

            if (profileIcon) {
                profileIcon.addEventListener('click', openSidebar);
            }
            if (closeButton) {
                closeButton.addEventListener('click', closeSidebar);
            }
        });
        document.querySelector('.contact-form form').addEventListener('submit', function(event) {
    event.preventDefault(); // Impede o envio real do formulário
    document.getElementById('success-modal').style.display = 'block'; // Exibe o modal
});

function closeModal() {
    document.getElementById('success-modal').style.display = 'none'; // Fecha o modal
}

    </script>
    
</body>
</html>

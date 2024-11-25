<?php
session_start();

// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "reservaquadras";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Consultar as quadras no banco de dados
$sql = "SELECT id_quadra, nome, endereco, preco, imagem, horarios, id_usuario FROM quadra";
$result = $conn->query($sql);

// Fechar a conexão com o banco de dados
$conn->close();
?>

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
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>Aluguel de Quadras Esportivas</title>
    <style>
       
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
}

.modal-content {
    background-color: #fefefe;
    margin: 5% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 600px;
    border-radius: 15px;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    position: relative;
}

.modal-image {
    width: 100%;
    height: 250px;
    margin-top: 20px;
    border-radius: 15px 15px 0 0;
    overflow: hidden;
}


.modal-info {
    padding: 10px;
    border-radius: 0 0 15px 15px;
}

.horarios {
    margin-top: 20px;
}


.horario-intervalo {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px;
    background-color: #f0f0f0;
    margin-bottom: 5px;
    border-radius: 4px;
}

.reservar-btn-horario {
    padding: 5px 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.reservar-btn-horario:hover {
    background-color: #45a049;
}
.swiper-container {
    position: relative;
    width: 100%;
    height: 250px; }

.swiper-button-next,
.swiper-button-prev {
    position: absolute;
    top: 50%;   
    transform: translateY(-50%);     
    width: 40px;
    height: 40px;
    background-color: rgba(0, 0, 0, 0.5);   
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10;
}

.swiper-button-next {
    right: 8px; }

.swiper-button-prev {
    left: 8px; }

.swiper-button-next:hover,
.swiper-button-prev:hover {
    background-color: rgba(0, 0, 0, 0.8); }

    .swiper-button-next::after,
.swiper-button-prev::after {
    font-size: 18px;
    font-weight: bold; 
}

.swiper-slide img {
    width: 100%;
    height: 100%;
    object-fit: cover;     border-radius: 15px; }

    .close {
    font-size: 36px; 
    position: absolute;
    top: -10px;
    right: 15px;
    color: #333;
    background: none;
    border: none;
    cursor: pointer;
    padding: 5px;  
    transition: color 0.3s ease;
}

.close:hover {
    color: #555; 
}

.modal-detail {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}

.modal-detail i {
    margin-right: 10px;
    color: #4CAF50; 
}

.modal-detail p {
    margin: 0;
    font-size: 16px;
}

#modal-avaliacao-estrelas {
    color: #FFD700; 
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
                <button id="btn-default"><a href="login.php" id="Login-botton">Login</a></button>
            <?php endif; ?>
        </div>
        <div id="user-section">
            <?php if (isset($_SESSION['user_id'])): ?>
                <i class="fa-regular fa-user" id="profile-icon"></i>
            <?php endif; ?>
        </div>
    </nav>
</header>

<h1>Centros Esportivos</h1>
<div class="quadras-container">
    <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
            <div class="quadra">
                <img src="img/<?= $row['imagem']; ?>" alt="Imagem da quadra" class="foto">
                <div class="detalhes">
                    <h2 class="nome"><?= $row['nome']; ?></h2>
                    <div class="info">
                        <i class="fa-solid fa-location-dot"></i>
                        <p>Endereço: <?= $row['endereco']; ?></p>
                    </div>
                    <div class="info">
                        <i class="fa-solid fa-money-bill-wave"></i>
                        <p>Valor: R$ <?= number_format($row['preco'], 2, ',', '.'); ?>/h</p>
                    </div>
                    <div class="info">
                        <i class="fa-solid fa-star"></i>
                        <p>Avaliações:</p>
                    </div>
                    <button class="ver-mais" data-target="#modal-<?= $row['id_quadra']; ?>">Ver mais</button>
                </div>
            </div>

            <!-- Modal de Detalhes da Quadra -->
            <div id="modal-<?= $row['id_quadra']; ?>" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <div class="swiper-container modal-image">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide"><img src="img/<?= $row['imagem']; ?>" alt="Imagem 1"></div>
                            <div class="swiper-slide"><img src="img/futsalquad.jpg" alt="Imagem 2"></div>
                            <div class="swiper-slide"><img src="img/futsalsociety.jpg" alt="Imagem 3"></div>
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                    <div class="modal-info">
                        <h2 id="modal-nome"><?= $row['nome']; ?> - Detalhes</h2>
                        <div class="modal-detail">
                            <i class="fa-solid fa-location-pin"></i>
                            Endereço: <?= $row['endereco']; ?>
                        </div>
                        <div class="modal-detail">
                            <i class="fa-solid fa-dollar-sign"></i>
                            R$ <?= number_format($row['preco'], 2, ',', '.'); ?>/hora
                        </div>
                        <div class="modal-detail">
                            <i class="fa-solid fa-star"></i>
                            Avaliações: 
                        </div>
                        <div class="horarios">
                            <h3>Horários:</h3>
                            <!-- Aqui você pode ajustar conforme necessário para adicionar horários dinâmicos -->
                            <div class="horario-intervalo">
                                <span>18:00 - 19:00</span>
                                <button class="reservar-btn-horario" data-horario="18:00 - 19:00">Reservar</button>
                            </div>
                            <div class="horario-intervalo">
                                <span>19:00 - 20:00</span>
                                <button class="reservar-btn-horario" data-horario="19:00 - 20:00">Reservar</button>
                            </div>
                            <div class="horario-intervalo">
                                <span>20:00 - 21:00</span>
                                <button class="reservar-btn-horario" data-horario="20:00 - 21:00">Reservar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Não há quadras disponíveis no momento.</p>
    <?php endif; ?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var modals = document.querySelectorAll(".modal");
        var closeBtns = document.querySelectorAll(".close");

        // Fechar modal ao clicar no botão "fechar"
        closeBtns.forEach(function(btn) {
            btn.addEventListener("click", function() {
                var modal = this.closest(".modal");
                modal.style.display = "none";
            });
        });

        // Fechar modal ao clicar fora dele
        window.addEventListener("click", function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = "none";
            }
        });

        // Iniciar o swiper para as imagens no modal
        var swiper = new Swiper('.swiper-container', {
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });

        // Exibir o modal ao clicar no botão "Ver mais"
        var btns = document.querySelectorAll('.ver-mais');
        btns.forEach(function(btn) {
            btn.addEventListener('click', function() {
                var targetModal = document.querySelector(this.getAttribute("data-target"));
                targetModal.style.display = "block";
            });
        });
    });
</script>

</body>
</html>

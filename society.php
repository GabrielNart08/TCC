<?php
session_start();
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
<h1>Centros Esportivos</h1>
<div class="quadras-container">
    <div class="quadra">
        <img src="img/society.jpg" alt="Quadra Society 1" class="foto">
        <div class="detalhes">
            <h2 class="nome">BROTOLÂNDIA CLUBE</h2>
            <div class="info">
                <i class="fa-solid fa-location-dot"></i>
                <p> Endereço: R. João Olivo - Rio Maina, Criciúma - SC, 88806-813</p>
            </div>
            <div class="info">
                <i class="fa-solid fa-money-bill-wave"></i>
                <p>Valor: R$100,00/h</p>
            </div>
            <div class="info">
                <i class="fa-solid fa-star"></i>
                <p>Avaliações: <span class="avaliacao">☆☆☆☆☆</span>(0 avaliações)</p>
            </div>
            <button class="ver-mais" data-target="#modal-brotolandia">Ver mais</button>
        </div>
    </div>

    <div class="quadra">
        <img src="img/resenha.png" alt="Quadra Society 2" class="foto">
        <div class="detalhes">
            <h2 class="nome">RESENHA DA BOLA</h2>
            <div class="info">
                <i class="fa-solid fa-location-dot"></i>
                <p> Endereço: Av. Centenário, 500 - Pinheirinho, Criciúma - SC, 88804-000</p>
            </div>
            <div class="info">
                <i class="fa-solid fa-money-bill-wave"></i>
                <p>Valor: R$140,00/h</p>
            </div>
            <div class="info">
                <i class="fa-solid fa-star"></i>
                <p>Avaliações: <span class="avaliacao">☆☆☆☆☆</span>(0 avaliações)</p>
            </div>
            <button class="ver-mais" data-target="#modal-resenha">Ver mais</button>
        </div>
    </div>

    <div class="quadra">
        <img src="img/angeloni.jpg" alt="Quadra Society 3" class="foto">
        <div class="detalhes">
            <h2 class="nome">ASSOCIAÇÃO ANGELONI</h2>
            <div class="info">
                <i class="fa-solid fa-location-dot"></i>
                <p> Endereço: 397, R. Rubéns Nunes Albino, 239 - Pres. Vargas, Içara - Estado ng Santa Catarina, 88820-000</p>
            </div>
            <div class="info">
                <i class="fa-solid fa-money-bill-wave"></i>
                <p>Valor: R$125,00/h</p>
            </div>
            <div class="info">
                <i class="fa-solid fa-star"></i>
                <p>Avaliações: <span class="avaliacao">☆☆☆☆☆</span>(0 avaliações)</p>
            </div>
            <button class="ver-mais" data-target="#modal-angeloni">Ver mais</button>
        </div>
    </div>
</div>

<div id="modal-brotolandia" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div class="swiper-container modal-image">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><img src="img/society.jpg" alt="Imagem 1"></div>
                <div class="swiper-slide"><img src="img/futsalquad.jpg" alt="Imagem 2"></div>
                <div class="swiper-slide"><img src="img/futsalsociety.jpg" alt="Imagem 3"></div>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>

        <div class="modal-info">
            <h2 id="modal-nome">Detalhes da Quadra</h2>
            
            <!-- Endereço com ícone -->
            <div class="modal-detail">
                <i class="fa-solid fa-location-pin"></i>
                Endereço: R. João Olivo - Rio Maina, Criciúma - SC, 88806-813
                <p id="modal-endereco"></p>
            </div>
            
            <!-- Valor com ícone -->
            <div class="modal-detail">
                <i class="fa-solid fa-dollar-sign"></i>
                R$100,00/hora
                <p id="modal-valor"></p>
            </div>

            <!-- Novas informações sobre avaliações -->
            <div class="modal-detail">
                <i class="fa-solid fa-star"></i>
                <p id="modal-avaliacoes">Avaliações: <span id="modal-avaliacao-estrelas">☆☆☆☆☆</span>(0 avaliações)</p>
            </div>

            <div class="horarios">
                <h3>Horários:</h3>
                <div class="horario-intervalo">
                    <span>18:00 - 19:00</span> 
                    <a href="dadoscliente.php?id=1" class="botao-reservar">Reservar</a>
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
</div>

<div id="modal-resenha" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div class="swiper-container modal-image">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><img src="img/resenha.png" alt="Imagem 1"></div>
                <div class="swiper-slide"><img src="img/futsalquad.jpg" alt="Imagem 2"></div>
                <div class="swiper-slide"><img src="img/futsalsociety.jpg" alt="Imagem 3"></div>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>

        <div class="modal-info">
            <h2 id="modal-nome">Detalhes da Quadra</h2>
            
            <!-- Endereço com ícone -->
            <div class="modal-detail">
                <i class="fa-solid fa-location-pin"></i>
                Endereço: Av. Centenário, 500 - Pinheirinho, Criciúma - SC, 88804-000
                <p id="modal-endereco"></p>
            </div>
            
            <!-- Valor com ícone -->
            <div class="modal-detail">
                <i class="fa-solid fa-dollar-sign"></i>
                R$140,00/hora
                <p id="modal-valor"></p>
            </div>

            <!-- Novas informações sobre avaliações -->
            <div class="modal-detail">
                <i class="fa-solid fa-star"></i>
                <p id="modal-avaliacoes">Avaliações: <span id="modal-avaliacao-estrelas">☆☆☆☆☆</span>(0 avaliações)</p>
            </div>

            <div class="horarios">
                <h3>Horários:</h3>
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
</div>

<div id="modal-angeloni" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div class="swiper-container modal-image">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><img src="img/angeloni.jpg" alt="Imagem 1"></div>
                <div class="swiper-slide"><img src="img/futsalquad.jpg" alt="Imagem 2"></div>
                <div class="swiper-slide"><img src="img/futsalsociety.jpg" alt="Imagem 3"></div>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>

        <div class="modal-info">
            <h2 id="modal-nome">Detalhes da Quadra</h2>
            
            <!-- Endereço com ícone -->
            <div class="modal-detail">
                <i class="fa-solid fa-location-pin"></i>
                Endereço: 397, R. Rubéns Nunes Albino, 239 - Pres. Vargas, Içara - Estado ng Santa Catarina, 88820-000
                <p id="modal-endereco"></p>
            </div>
            
            <!-- Valor com ícone -->
            <div class="modal-detail">
                <i class="fa-solid fa-dollar-sign"></i>
                R$125,00/hora
                <p id="modal-valor"></p>
            </div>

            <!-- Novas informações sobre avaliações -->
            <div class="modal-detail">
                <i class="fa-solid fa-star"></i>
                <p id="modal-avaliacoes">Avaliações: <span id="modal-avaliacao-estrelas">☆☆☆☆☆</span>(0 avaliações)</p>
            </div>

            <div class="horarios">
                <h3>Horários:</h3>
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
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    var sidebar = document.getElementById('sidebar');
    var profileIcon = document.getElementById('profile-icon');
    var closeButton = document.getElementById('close-sidebar');
    var btns = document.querySelectorAll(".ver-mais");
    var modals = document.querySelectorAll(".modal");
    var span = document.getElementsByClassName("close")[0];
    var swiper;

    btns.forEach(function (btn) {
        btn.addEventListener("click", function () {
            var targetModal = document.querySelector(this.getAttribute("data-target"));
            targetModal.style.display = "block";
        });
    });

    // Fechar os modais
    modals.forEach(function (modal) {
        var closeBtn = modal.querySelector(".close");
        closeBtn.addEventListener("click", function () {
            modal.style.display = "none";
        });

        window.addEventListener("click", function (event) {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        });
    });


            
            if (swiper) {
                swiper.destroy(true, true); 
            }
            swiper = new Swiper('.swiper-container', {
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                loop: true, 
            });
        

    sidebar.style.width = '0';

    function openSidebar() {
        sidebar.style.width = '250px';
    }

    function closeSidebar() {
        sidebar.style.width = '0';
    }

    profileIcon.addEventListener('click', openSidebar);
    closeButton.addEventListener('click', closeSidebar);

    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    // Função de reserva para cada horário
    document.querySelectorAll('.reservar-btn-horario').forEach(function(btn) {
        btn.onclick = function() {
            var horario = this.getAttribute('data-horario');
            var quadraNome = document.getElementById("modal-nome").innerText;
            var valor = document.getElementById("modal-valor").innerText;

            // Redireciona para a página de pagamento com os detalhes do horário selecionado
            window.location.href = `dadoscliente.php?quadra=${encodeURIComponent(quadraNome)}&horario=${encodeURIComponent(horario)}&valor=${encodeURIComponent(valor)}`;
        };
    });
});

</script>
</body>
</html>

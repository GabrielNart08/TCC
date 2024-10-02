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
    width: 90%;
    max-width: 800px;
    border-radius: 15px;
    display: flex;
    max-height: 80%;
    overflow: hidden; /* Impede a rolagem do conteúdo */
    position: relative; /* Para o botão de fechar */
}

.modal-image {
    flex: 1; /* Aumenta a flexibilidade da imagem */
    border-radius: 15px 0 0 15px; /* Borda arredondada à esquerda */
    overflow: hidden; /* Para garantir que a imagem não saia dos limites */
}

.modal-image img {
    width: 100%; /* Aumenta a largura da imagem para preencher a área */
    height: 100%; /* Faz a imagem ocupar toda a altura do container */
    object-fit: cover; /* Cobre a área sem distorcer */
}

.modal-info {
    flex: 2;
    padding-left: 20px; /* Espaçamento à esquerda do conteúdo textual */
    border-radius: 0 15px 15px 0; /* Borda arredondada à direita */
}

.close {
    color: #aaa;
    font-size: 28px;
    font-weight: bold;
    position: absolute; /* Faz o botão de fechar ficar posicionado no canto */
    right: 20px; /* Distância do lado direito */
    top: 15px; /* Distância do topo */
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

.horarios {
    margin-top: 20px;
    background-color: white; /* Fundo branco para os horários */
    padding: 10px; /* Adiciona um pouco de espaçamento */
    border-radius: 5px; /* Borda arredondada */
    display: flex; /* Alinha os botões horizontalmente */
    border: 1px solid #ccc; /* Borda ao redor da seção de horários */
}

.horario-btn {
    margin: 5px; /* Espaçamento entre os botões de horário */
    padding: 10px 15px; /* Aumenta o tamanho dos botões */
    background-color: #f0f0f0; /* Cor de fundo dos botões */
    border: 1px solid #ccc; /* Borda dos botões */
    cursor: pointer;
    border-radius: 4px; /* Borda arredondada */
    transition: background-color 0.3s; /* Transição suave */
}

.horario-btn:hover {
    background-color: #dcdcdc; /* Cor ao passar o mouse */
}

.reservar-btn {
    margin-top: 20px;
    background-color: #4CAF50;
    color: white;
    border: none;
    padding: 15px 50px; /* Aumenta a altura e largura do botão */
    cursor: pointer;
    border-radius: 5px; /* Borda arredondada */
    font-size: 16px; /* Aumenta a fonte */
    width: 100%; /* Botão ocupa toda a largura disponível */
}

.reservar-btn:hover {
    background-color: #45a049;
}

.horario-btn.selecionado {
    background-color: #76c7c0; /* Verde claro quando selecionado */
}

.horario-btn.indisponivel {
    background-color: red; /* Vermelho para horários reservados */
    pointer-events: none; /* Impede que o botão seja clicado */
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
            <button class="ver-mais" data-nome="Quadra Society 1" data-endereco="Rua Exemplo, 123" data-valor="R$ 100/hora" data-imagem="img/society.jpg">Ver mais</button>
        </div>
    </div>

    <div class="quadra">
        <img src="img/society.jpg" alt="Quadra Society 2" class="foto">
        <div class="detalhes">
            <h2 class="nome">Quadra Society 2</h2>
            <p>Endereço: Rua Exemplo, 456</p>
            <p>Valor: R$ 120/hora</p>
            <button class="ver-mais" data-nome="Quadra Society 2" data-endereco="Rua Exemplo, 456" data-valor="R$ 120/hora" data-imagem="img/society.jpg">Ver mais</button>
        </div>
    </div>

    <div class="quadra">
        <img src="img/society.jpg" alt="Quadra Society 3" class="foto">
        <div class="detalhes">
            <h2 class="nome">Quadra Society 3</h2>
            <p>Endereço: Rua Exemplo, 789</p>
            <p>Valor: R$ 150/hora</p>
            <button class="ver-mais" data-nome="Quadra Society 3" data-endereco="Rua Exemplo, 789" data-valor="R$ 150/hora" data-imagem="img/society.jpg">Ver mais</button>
        </div>
    </div>
</div>

<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div class="modal-image">
            <img id="modal-img" src="" alt="Imagem da Quadra" style="width: 100%; height: auto;">
        </div>
        <div class="modal-info">
            <h2 id="modal-nome">Detalhes da Quadra</h2>
            <p id="modal-endereco"></p>
            <p id="modal-valor"></p>
            <div class="horarios">
    <h3>Horários Disponíveis:</h3>
    <button class="horario-btn" data-horario="08:00">08:00</button>
    <button class="horario-btn" data-horario="10:00">10:00</button>
    <button class="horario-btn" data-horario="12:00">12:00</button>
    <button class="horario-btn" data-horario="14:00">14:00</button>
            </div>
            <button class="reservar-btn">Reservar</button>
        </div>
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

    var modal = document.getElementById("myModal");
    var btns = document.querySelectorAll(".ver-mais");
    var span = document.getElementsByClassName("close")[0];

    btns.forEach(function(btn) {
        btn.onclick = function() {
            modal.style.display = "block";
            document.getElementById("modal-nome").innerText = this.getAttribute("data-nome");
            document.getElementById("modal-endereco").innerText = "Endereço: " + this.getAttribute("data-endereco");
            document.getElementById("modal-valor").innerText = "Valor: " + this.getAttribute("data-valor");
            document.getElementById("modal-img").src = this.getAttribute("data-imagem");
        }
    });

    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    var horariosReservados = []; // Array para armazenar horários reservados

document.querySelectorAll('.horario-btn').forEach(function(btn) {
    btn.onclick = function() {
        var horario = this.getAttribute('data-horario');
        
        // Verifica se o horário já está reservado
        if (!horariosReservados.includes(horario)) {
            horariosReservados.push(horario); // Adiciona o horário ao array
            this.classList.add('indisponivel'); // Marca o botão como indisponível
            alert("Horário " + horario + " reservado com sucesso!"); // Mensagem de sucesso
        } else {
            alert("Este horário já está reservado."); // Mensagem de erro
        }
    };
    var horarioSelecionado = null; // Armazena o horário selecionado

document.querySelectorAll('.horario-btn').forEach(function(btn) {
    btn.onclick = function() {
        // Remove a classe de seleção de qualquer botão previamente selecionado
        if (horarioSelecionado) {
            horarioSelecionado.classList.remove('selecionado');
        }

        // Adiciona a classe de selecionado ao botão atual
        this.classList.add('selecionado');
        horarioSelecionado = this; // Armazena o horário selecionado

        // Quando o botão "Reservar" é clicado
        document.querySelector('.reservar-btn').onclick = function() {
            if (horarioSelecionado) {
                horarioSelecionado.classList.add('indisponivel'); // Marca como reservado
                alert("Horário " + horarioSelecionado.getAttribute('data-horario') + " reservado com sucesso!");
                horarioSelecionado = null; // Reseta a seleção
                // Aqui você pode adicionar a lógica para salvar a reserva
            } else {
                alert("Por favor, selecione um horário primeiro.");
            }
        };
    };
});
});
});
</script>
</body>
</html>

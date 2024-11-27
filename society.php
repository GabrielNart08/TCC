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
$sql = "SELECT id_quadra, nome, endereco, preco, imagem, id_usuario FROM quadra";
$result = $conn->query($sql);

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

@import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

*{
    font-family: 'Poppins', sans-serif;
}
.horario-intervalo {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px;
    margin-bottom: 8px;
    background-color: #f4f4f4;
    border: 1px solid #ccc;
    border-radius: 4px;
    transition: background-color 0.3s ease;
}

.horario-intervalo:hover {
    background-color: #e0e0e0;
}

.reservar-btn-horario {
    padding: 5px 15px;
    background-color: #007BFF;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.reservar-btn-horario:hover {
    background-color: #0056b3;
}

.reservar-btn-horario:active {
    background-color: #004080;
}

       
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

/* Estilo para o botão */
.btn-selecionar-dia {
    padding: 10px 20px;
    background-color: #007BFF;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.btn-selecionar-dia:hover {
    background-color: #0056b3;
}

.lista-dias {
    display: none;  /* Esconde a lista por padrão */
}

.lista-dias.show {
    display: block;  /* Exibe a lista quando a classe 'show' é adicionada */
}

select {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    background-color: #f4f4f4;
    border: 1px solid #ccc;
    border-radius: 8px;
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
                        <div>
                        <button id="btn-selecionar-dia-<?= $row['id_quadra']; ?>" class="btn-selecionar-dia" data-quadra="<?= $row['id_quadra']; ?>">Selecionar Dia</button>

                            <select id="seletorDia-<?= $row['id_quadra']; ?>" class="seletorDia" style="display: none;">
                                <option value="Segunda">Segunda-feira</option>
                                <option value="Terça">Terça-feira</option>
                                <option value="Quarta">Quarta-feira</option>
                                <option value="Quinta">Quinta-feira</option>
                                <option value="Sexta">Sexta-feira</option>
                                <option value="Sábado">Sábado</option>
                                <option value="Domingo">Domingo</option>
                            </select>
                        </div>


                        <!-- Exibição dos horários -->
                        <div id="horariosDisponiveis-<?= $row['id_quadra']; ?>" style="display: none;">
                            <h3>Horários Disponíveis:</h3>
                            <ul id="listaHorarios-<?= $row['id_quadra']; ?>"></ul>
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
    // Abrir e fechar sidebar
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

    // Modal de Detalhes da Quadra
    var modals = document.querySelectorAll(".modal");
    var closeBtns = document.querySelectorAll(".close");

    closeBtns.forEach(function(btn) {
        btn.addEventListener("click", function() {
            var modal = this.closest(".modal");
            modal.style.display = "none";
        });
    });

    window.addEventListener("click", function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.style.display = "none";
        }
    });

    // Iniciar Swiper para as imagens no modal
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

    // Exibir seletor de dia e carregar horários
    document.querySelectorAll('.ver-mais').forEach(button => {
        button.addEventListener('click', (event) => {
            const targetModal = document.querySelector(event.target.getAttribute('data-target'));
            const idQuadra = targetModal.id.split('-')[1]; // Extrai o id da quadra

            // Lógica do botão Selecionar Dia
            const btnSelecionarDia = document.getElementById(`btn-selecionar-dia-${idQuadra}`);
            const seletorDia = document.getElementById(`seletorDia-${idQuadra}`);
            const horariosDisponiveisDiv = document.getElementById(`horariosDisponiveis-${idQuadra}`);
            const listaHorarios = document.getElementById(`listaHorarios-${idQuadra}`);

            // Mostrar/Esconder seletor de dia
            btnSelecionarDia.addEventListener('click', function() {
                if (seletorDia.style.display === 'none' || seletorDia.style.display === '') {
                    seletorDia.style.display = 'block';
                } else {
                    seletorDia.style.display = 'none';
                }
            });

           // Quando o dia for selecionado, faz a requisição para obter os horários
seletorDia.addEventListener('change', function (event) {
    const diaSelecionado = event.target.value;

    // Fazendo a requisição AJAX para obter os horários
    fetch(`get_horarios.php?id_quadra=${idQuadra}&dia_semana=${diaSelecionado}`)
        .then(response => response.json())
        .then(data => {
            // Limpar lista de horários
            listaHorarios.innerHTML = '';

            // Adicionar horários na lista
            if (data.horarios && data.horarios.length > 0) {
                data.horarios.forEach(horario => {
                    const li = document.createElement('li');
                    li.classList.add('horario-intervalo');
                    li.innerHTML = `
                        ${horario.hora_inicio} - ${horario.hora_fim}
                        <button class="reservar-btn-horario" 
                            data-id-horario="${horario.id_horario}" 
                            data-id-quadra="${data.id_quadra}">Reservar</button>`;
                    listaHorarios.appendChild(li);
                });
            } else {
                listaHorarios.innerHTML = '<li>Não há horários disponíveis.</li>';
            }

            // Exibir a div com os horários disponíveis
            horariosDisponiveisDiv.style.display = 'block';
        })
        .catch(error => {
            console.error('Erro ao buscar horários:', error);
        });
});
        });
    });
});


document.addEventListener('click', function (event) {
    // Verifica se o clique foi em um botão com a classe '.reservar-btn-horario'
    if (event.target.classList.contains('reservar-btn-horario')) {
        const idHorario = event.target.getAttribute('data-id-horario'); // Obtém o id do horário
        const idQuadra = event.target.getAttribute('data-id-quadra'); // Obtém o id da quadra

        // Verifique se os dados estão corretos
        console.log(`id_horario: ${idHorario}, id_quadra: ${idQuadra}`);

        // Monta a URL para a página de dados do cliente
        const urlReserva = `/TCC/dadoscliente.php?id_horario=${idHorario}&id_quadra=${idQuadra}`;

        // Redireciona o usuário para a página de dados do cliente
        window.location.href = urlReserva;
    }
});


// Função para mostrar ou esconder a lista de dias
document.querySelectorAll('.btn-selecionar-dia').forEach(btn => {
    btn.addEventListener('click', function() {
        const idQuadra = this.id.split('-')[3]; // Pega o id_quadra da string do botão
        const listaDias = document.getElementById(`listaDias-${idQuadra}`);

        // Alterna a visibilidade da lista de dias
        listaDias.classList.toggle('show');
    });
});

// Atualizar o texto do botão com o dia selecionado
document.querySelectorAll('.lista-dias li').forEach(item => {
    item.addEventListener('click', function() {
        const diaSelecionado = this.getAttribute('data-dia'); // Pega o dia selecionado
        const idQuadra = this.parentElement.id.split('-')[1]; // Pega o id_quadra da string do id da lista
        const btn = document.getElementById(`btn-selecionar-dia-${idQuadra}`);

        // Atualiza o texto do botão com o valor do dia selecionado
        btn.textContent = diaSelecionado;

        // Esconde a lista de dias após a seleção
        const listaDias = document.getElementById(`listaDias-${idQuadra}`);
        listaDias.classList.remove('show');
    });
});

// Fechar a lista de dias se o usuário clicar fora do botão ou da lista
document.addEventListener('click', function(event) {
    const isClickInside = event.target.closest('.btn-selecionar-dia') || event.target.closest('.lista-dias');
    if (!isClickInside) {
        document.querySelectorAll('.lista-dias').forEach(lista => {
            lista.classList.remove('show');
        });
    }
});

</script>

</body>
</html>
<?php
// Fechar a conexão com o banco de dados ao final
$conn->close();
?>
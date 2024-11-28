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

// Consultar as quadras do tipo "society"
$sql = "SELECT id_quadra, nome, endereco, preco, imagem, id_usuario FROM quadra WHERE tipo = 'society'"; // Adicionando filtro para tipo "society"
$result = $conn->query($sql);

// Dentro do loop que exibe as quadras
$horarios_sql = "SELECT * FROM horario WHERE id_quadra = ? AND data = ?"; // Modifiquei 'data' para 'dia' para corresponder à tabela
$stmt = $conn->prepare($horarios_sql);
$stmt->bind_param("is", $row['id_quadra'], $data); // Recebe 'id_quadra' e a data

// Aqui você pode preparar a resposta com os horários
$stmt->execute();
$horarios_result = $stmt->get_result();

$horarios = [];
while ($horario = $horarios_result->fetch_assoc()) {
    $horarios[] = $horario;
}
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
/* Estilo para o item de horário (com o botão dentro) */
.lista-horarios-item {
    display: flex;
    justify-content: space-between; /* Afastar o horário do botão */
    align-items: center; /* Alinhar os itens no centro verticalmente */
    background-color: #f8f9fa; /* Cor de fundo leve */
    border: 1px solid #ddd; /* Borda leve */
    padding: 10px;
    margin-bottom: 10px; /* Espaço entre os itens */
    border-radius: 8px; /* Bordas arredondadas */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Sombra leve */
    width: 100%; /* Garantir que ocupe toda a largura disponível */
    max-width: 600px; /* Limitar a largura máxima */
    margin: 5px auto; /* Centralizar os itens na tela */
}

/* Estilo do botão de reservar */
.reservar-btn {
    background-color: #28a745; /* Cor verde */
    color: white;
    border: none;
    padding: 10px 15px; /* Aumentar o tamanho do botão */
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.reservar-btn:hover {
    background-color: #218838; /* Cor verde mais escuro no hover */
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
            </div>
            
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

            <!-- Campo para selecionar a data -->
            <input type="date" id="dataReserva-<?= $row['id_quadra']; ?>" name="dataReserva">

            <!-- Botão para disparar a busca dos horários -->
            <button onclick="buscarHorarios(<?= $row['id_quadra']; ?>)">Buscar Horários</button>

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
    fetch(`get_horarios.php?id_quadra=${idQuadra}&data=${diaSelecionado}`)
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


function buscarHorarios(idQuadra) {
    var data = document.getElementById('dataReserva-' + idQuadra).value;
    
    // Verifique se a data foi selecionada
    if (!data) {
        alert("Por favor, selecione uma data.");
        return;
    }

    // Aqui você faz a requisição AJAX para buscar os horários
    $.ajax({
        url: 'buscar_horarios.php', // Crie um arquivo PHP para buscar os horários
        type: 'POST',
        data: { id_quadra: idQuadra, data: data },
        success: function(response) {
            // Exibir os horários na lista
            var horarios = JSON.parse(response);
            var listaHorarios = document.getElementById('listaHorarios-' + idQuadra);
            listaHorarios.innerHTML = '';

            if (horarios.length > 0) {
                horarios.forEach(function(horario) {
                    var li = document.createElement('li');
                    li.classList.add('lista-horarios-item'); // Adiciona a classe para o estilo do item de horário
                    li.textContent = horario.hora_inicio + ' - ' + horario.hora_fim;

                    // Criar o botão de reservar
                    var botaoReservar = document.createElement('button');
                    botaoReservar.textContent = 'Reservar';
                    botaoReservar.classList.add('reservar-btn');
                    botaoReservar.onclick = function() {
                        // Redireciona para dadoscliente.php com os parâmetros necessários
                        window.location.href = "dadoscliente.php?id_horario=" + horario.id_horario + "&id_quadra=" + idQuadra + "&data=" + data;
                    };

                    // Adicionar o botão ao item de horário
                    li.appendChild(botaoReservar);

                    // Adicionar o item de horário na lista
                    listaHorarios.appendChild(li);
                });
                document.getElementById('horariosDisponiveis-' + idQuadra).style.display = 'block';
            } else {
                listaHorarios.innerHTML = '<li>Não há horários disponíveis.</li>';
            }
        },
        error: function() {
            alert("Erro ao buscar os horários.");
        }
    });
}



const horariosDisponiveis = <?php echo json_encode($horarios); ?>;
console.log(horariosDisponiveis);  // Exibir os horários no console para debug


function reservarHorario(horarioId) {
    $.ajax({
        url: 'reservar_horario.php', // Arquivo PHP que processará a reserva
        type: 'POST',
        data: { horario_id: horarioId, usuario_id: <?php echo $_SESSION['user_id']; ?> }, // Envia o ID do horário e o usuário
        success: function(response) {
            alert('Reserva realizada com sucesso!');
            // Atualizar a interface, como ocultar o modal ou limpar os campos
        },
        error: function() {
            alert('Erro ao realizar a reserva. Tente novamente.');
        }
    });
}

// Aplique a função 'reservarHorario' no botão de reserva
document.querySelectorAll('.reservar-btn-horario').forEach(button => {
    button.addEventListener('click', function() {
        const horarioId = this.dataset.horarioId;  // Passe o id do horário para o servidor
        reservarHorario(horarioId);
    });
});



</script>

</body>
</html>
<?php
// Fechar a conexão com o banco de dados ao final
$conn->close();
?>
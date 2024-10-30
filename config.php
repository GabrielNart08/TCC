<?php
session_start();
include 'conexao.php'; // Certifique-se de que esse arquivo faz a conexão com o banco de dados

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Obtém o ID do usuário da sessão
$user_id = $_SESSION['user_id'];

// Consulta para buscar as informações do usuário
$sql = "SELECT nome, username, email FROM usuario WHERE id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Variável para armazenar a mensagem do modal
$modalMessage = '';
$modalSuccess = false;

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    
    // Atualiza as informações do usuário no banco de dados
    $sql = "UPDATE usuario SET nome = ?, username = ?, email = ? WHERE id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssi', $nome, $username, $email, $user_id);

    if ($stmt->execute()) {
        $modalMessage = "Informações atualizadas com sucesso!";
        $modalSuccess = true;
        $_SESSION['user_name'] = $nome;
    } else {
        $modalMessage = "Erro ao atualizar informações.";
    }

    $stmt->close();
}

// Fecha a conexão com o banco de dados
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="styles/styles.css">
<link rel="stylesheet" href="styles/header.css">
<link rel="stylesheet" href="styles/config.css">
<title>Configurações de Conta</title>
</head>
<style>
    
</style>
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

<h1>Configurações de Conta</h1>

<form action="config.php" method="POST">
    <label for="nome">Nome:</label>
    <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($user['nome']); ?>" required>

    <label for="username">Nome de Usuário:</label>
    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

    <button type="submit">Salvar Alterações</button>
</form>

<div id="modal" class="<?php echo $modalSuccess ? 'success' : 'error'; ?>">
    <i class="fa-solid <?php echo $modalSuccess ? 'fa-check-circle' : 'fa-times-circle'; ?>"></i>
    <p><?php echo $modalMessage; ?></p>
    <button onclick="closeModal()">OK</button>
</div>

<script>
    // Mostra o modal se houver uma mensagem
    <?php if (!empty($modalMessage)): ?>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('modal').style.display = 'block';
        });
    <?php endif; ?>

    // Função para fechar o modal
    function closeModal() {
        document.getElementById('modal').style.display = 'none';
    }

    // Script para a sidebar
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

        if (profileIcon) profileIcon.addEventListener('click', openSidebar);
        if (closeButton) closeButton.addEventListener('click', closeSidebar);
    });
</script>
</body>
</html>

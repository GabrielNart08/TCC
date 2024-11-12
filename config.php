<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT nome, username, email FROM usuario WHERE id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

$message = '';
$messageClass = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $username = $_POST['username'];
    $email = $_POST['email'];

    // Atualiza as informações no banco de dados
    $sql = "UPDATE usuario SET nome = ?, username = ?, email = ? WHERE id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssi', $nome, $username, $email, $user_id);
    if ($stmt->execute()) {
        // Atualiza a sessão com as novas informações
        $_SESSION['user_name'] = $nome;
        $_SESSION['message'] = "Informações atualizadas com sucesso!";
        $_SESSION['message_class'] = 'success';
        
        // Redireciona para a mesma página para recarregar os dados atualizados
        header("Location: config.php");
        exit();
    } else {
        $_SESSION['message'] = "Erro ao atualizar informações.";
        $_SESSION['message_class'] = 'error';
    }
    $stmt->close();
}


$conn->close();

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $messageClass = $_SESSION['message_class'];
    unset($_SESSION['message']);
    unset($_SESSION['message_class']);
}
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
    <div class="form-group">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($user['nome']); ?>" required>
    </div>

    <div class="form-group">
        <label for="username">Nome de Usuário:</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
    </div>

    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
    </div>

    <button type="submit">Salvar Alterações</button>
</form>

<?php if (!empty($message)): ?>
    <div class="message-box <?php echo $messageClass; ?>">
        <p><?php echo $message; ?></p>
    </div>
<?php endif; ?>

<script>
    setTimeout(function() {
        const messageBox = document.querySelector('.message-box');
        if (messageBox) {
            messageBox.style.display = 'none';
        }
    }, 3000);
</script>
</body>
</html>

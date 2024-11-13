<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT nome, username, email, senha FROM usuario WHERE id_usuario = ?";
$stmt1 = $conn->prepare($sql);
$stmt1->bind_param('i', $user_id);
$stmt1->execute();
$result = $stmt1->get_result();
$user = $result->fetch_assoc();
$stmt1->close();

$message = '';
$messageClass = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['confirm_new_password'];

    $canUpdate = true;

    // Verificar se a senha atual está correta
    if (!empty($current_password) && !empty($new_password) && !empty($confirm_new_password)) {
        if (password_verify($current_password, $user['senha'])) {
            // Verificar se a nova senha e a confirmação de senha são iguais
            if ($new_password === $confirm_new_password) {
                // Atualizar a senha no banco de dados
                $new_password_hash = password_hash($new_password, PASSWORD_BCRYPT);
                $sql = "UPDATE usuario SET senha = ? WHERE id_usuario = ?";
                $stmt2 = $conn->prepare($sql);
                $stmt2->bind_param('si', $new_password_hash, $user_id);
                $stmt2->execute();
                $stmt2->close();

                $_SESSION['message'] = "Senha atualizada com sucesso!";
                $_SESSION['message_class'] = 'success';
            } else {
                $_SESSION['message'] = "A nova senha e a confirmação de senha não coincidem.";
                $_SESSION['message_class'] = 'error';
                $canUpdate = false;
            }
        } else {
            $_SESSION['message'] = "Senha atual incorreta.";
            $_SESSION['message_class'] = 'error';
            $canUpdate = false;
        }
    }


    if ($canUpdate) {
        $sql = "UPDATE usuario SET nome = ?, username = ?, email = ? WHERE id_usuario = ?";
        $stmt3 = $conn->prepare($sql);
        $stmt3->bind_param('sssi', $nome, $username, $email, $user_id);
        if ($stmt3->execute()) {
            $_SESSION['user_name'] = $nome;
            $_SESSION['message'] = "Informações atualizadas com sucesso!";
            $_SESSION['message_class'] = 'success';
        } else {
            $_SESSION['message'] = "Erro ao atualizar informações.";
            $_SESSION['message_class'] = 'error';
        }
        $stmt3->close();
    }

    // Redireciona para a mesma página para recarregar os dados atualizados
    header("Location: config.php");
    exit();
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

<form id="config-form" action="config.php" method="POST" onsubmit="return validateForm()">
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

    <div class="form-group">
        <label for="current_password">Senha Atual:</label>
        <div class="password-wrapper">
            <input type="password" id="current_password" name="current_password">
            <i class="fa fa-eye show-password" onclick="togglePasswordVisibility('current_password')"></i>
        </div>
    </div>

    <div class="form-group">
        <label for="new_password">Nova Senha:</label>
        <div class="password-wrapper">
            <input type="password" id="new_password" name="new_password">
            <i class="fa fa-eye show-password" onclick="togglePasswordVisibility('new_password')"></i>
        </div>
    </div>

    <div class="form-group">
        <label for="confirm_new_password">Confirmar Nova Senha:</label>
        <div class="password-wrapper">
            <input type="password" id="confirm_new_password" name="confirm_new_password">
            <i class="fa fa-eye show-password" onclick="togglePasswordVisibility('confirm_new_password')"></i>
        </div>
        <div id="error-message" class="message-box error" style="display:none;">
    <p></p>
</div>
    </div>

    <button type="submit">Salvar Alterações</button>
</form>

<?php if (!empty($message)): ?>
    <div class="message-box <?php echo $messageClass; ?>" id="message-box">
        <p><?php echo $message; ?></p>
    </div>
<?php endif; ?>

<script>
   
    setTimeout(function() {
        const messageBox = document.getElementById('message-box');
        if (messageBox) {
            messageBox.style.display = 'none'; 
        }
    }, 3000);
    function togglePasswordVisibility(fieldId) {
        const passwordField = document.getElementById(fieldId);
        const showPasswordIcon = passwordField.nextElementSibling;
        
        if (passwordField.type === "password") {
            passwordField.type = "text";
            showPasswordIcon.classList.replace("fa-eye", "fa-eye-slash");
        } else {
            passwordField.type = "password";
            showPasswordIcon.classList.replace("fa-eye-slash", "fa-eye");
        }
    }
    function validateForm() {
    const currentPassword = document.getElementById("current_password").value;
    const newPassword = document.getElementById("new_password").value;
    const confirmNewPassword = document.getElementById("confirm_new_password").value;
    const errorMessageDiv = document.getElementById("error-message");
    
    // Limpar qualquer mensagem anterior
    errorMessageDiv.style.display = 'none';
    
    if (newPassword !== confirmNewPassword) {
        errorMessageDiv.querySelector('p').textContent = "A nova senha e a confirmação de senha não coincidem.";
        errorMessageDiv.style.display = 'block';
        return false; 
    }

    return true;
}
</script>
</body>
</html>

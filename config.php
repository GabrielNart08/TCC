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
$sql = "SELECT nome, username, email, foto_perfil FROM usuario WHERE id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Inicializa a variável para a mensagem
$message = '';
$messageClass = ''; // Para definir a classe de estilo (sucesso ou erro)

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $foto_perfil = $_FILES['foto_perfil'];

    // Processa o envio da foto, se houver
    if ($foto_perfil['error'] === UPLOAD_ERR_OK) {
        // Valida o tipo e o tamanho da imagem
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($foto_perfil['type'], $allowed_types)) {
            if ($foto_perfil['size'] < 5 * 1024 * 1024) { // Limite de 5MB
                // Define o caminho onde a imagem será salva
                $target_dir = "uploads/";
                $target_file = $target_dir . basename($foto_perfil['name']);

                // Define o nome do arquivo de foto
                $foto_nome = basename($foto_perfil['name']);

                // Atualiza o caminho da foto no banco de dados
                $sql = "UPDATE usuario SET nome = ?, username = ?, email = ?, foto_perfil = ? WHERE id_usuario = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('ssssi', $nome, $username, $email, $foto_nome, $user_id);
                if ($stmt->execute()) {
                    // Atualiza as informações do usuário na sessão
                    $_SESSION['user_name'] = $nome;
                    // Armazena a mensagem de sucesso na sessão
                    $_SESSION['message'] = "Informações e foto de perfil atualizadas com sucesso!";
                    $_SESSION['message_class'] = 'success'; // Classe de estilo para o sucesso
                } else {
                    // Armazena a mensagem de erro na sessão
                    $_SESSION['message'] = "Erro ao atualizar informações.";
                    $_SESSION['message_class'] = 'error'; // Classe de estilo para o erro
                }
                $stmt->close();
            } else {
                // Mensagem de erro para tamanho de imagem
                $_SESSION['message'] = "A imagem é muito grande. O limite é 5MB.";
                $_SESSION['message_class'] = 'error';
            }
        } else {
            // Mensagem de erro para tipo de imagem
            $_SESSION['message'] = "Formato de imagem não permitido. Apenas JPG, PNG e GIF são aceitos.";
            $_SESSION['message_class'] = 'error';
        }
    } else {
        // Se não houver foto, apenas atualize as informações
        $sql = "UPDATE usuario SET nome = ?, username = ?, email = ? WHERE id_usuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssi', $nome, $username, $email, $user_id);
        if ($stmt->execute()) {
            // Armazena a mensagem de sucesso na sessão
            $_SESSION['message_class'] = 'success'; // Classe de estilo para o sucesso
            $_SESSION['user_name'] = $nome;
        } else {
            // Armazena a mensagem de erro na sessão
            $_SESSION['message'] = "Erro ao atualizar informações.";
            $_SESSION['message_class'] = 'error'; // Classe de estilo para o erro
        }
        $stmt->close();
    }
}

// Fecha a conexão com o banco de dados
$conn->close();

// Exibe a mensagem se houver e depois a limpa
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $messageClass = $_SESSION['message_class'];
    unset($_SESSION['message']); // Limpa a mensagem da sessão
    unset($_SESSION['message_class']); // Limpa a classe de mensagem
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

<form action="config.php" method="POST" enctype="multipart/form-data">
        <!-- Campo para a foto de perfil -->
        <div class="form-group profile-picture-container">
        <label for="foto_perfil">Foto de Perfil:</label>
        
        <!-- Exibir a foto de perfil se já existir -->
        <div class="profile-picture">
            <?php if (!empty($user['foto_perfil'])): ?>
                <img src="uploads/<?php echo htmlspecialchars($user['foto_perfil']); ?>" alt="Foto de Perfil">
            <?php else: ?>
                <div class="default-picture">Sem Foto</div>
            <?php endif; ?>
        </div>
    </div>
    <input type="file" id="foto_perfil" name="foto_perfil" accept="image/*">

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

    <!-- Exibir a mensagem de erro, se houver -->
    <?php if (!empty($message)): ?>
        <div class="message <?php echo $messageClass; ?>">
            <p><?php echo $message; ?></p>
        </div>
    <?php endif; ?>
</form>


</body>
</html>

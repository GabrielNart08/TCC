<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="styles/logincad.css">
</head>
<body>
<a href="index.php" class="back-button">Voltar</a>
    <div class="welcome-container">
        <h2 class="bem-vindo">Seja bem-vindo a</h2>
        <div class="logo-container">
            <i class="fa-regular fa-futbol" id="logo-icon"></i>
            <span class="logo-text">FutReserva</span>
        </div>
    </div>
    
    <div class="container">
        <h2>Login</h2>
        <form id="loginForm" action="logar.php" method="POST">
            <label for="loginUser">Usuário:</label>
            <input type="text" id="loginUser" name="user" required>
            
            <label for="loginPassword">Senha:</label>
            <input type="password" id="loginPassword" name="password" required>
            
            <button type="submit">Entrar</button>
            <br><br>
            Não tem uma conta? <a href="registra.php" class="register-link">Cadastre-se</a>
        </form>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="styles/logincad.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
        <h2>Cadastro</h2>
        <form id="registerForm" action="registro.php" method="POST">
            <label for="registerName">Nome:</label>
            <input type="text" id="registerName" name="name" required>

            <label for="registerUser">Usuário:</label>
            <input type="text" id="registerUser" name="user" required>
            
            <label for="registerEmail">Email:</label>
            <input type="text" id="registerEmail" name="email" required>
            
            <label for="registerPassword">Senha:</label>
            <input type="password" id="registerPassword" name="password" required>
            
            <button type="submit">Cadastrar</button>
        </form>
        <div class="link-container">
            Já tem uma conta? <a href="login.php" class="login-link">Faça login</a>
        </div>
    </div>
</body>
</html>

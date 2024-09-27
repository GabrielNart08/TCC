<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="styles/logincad.css">
</head>
<body>
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
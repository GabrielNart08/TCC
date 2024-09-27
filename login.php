<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de Login</title>
    <link rel="stylesheet" href="styles/logincad.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form id="loginForm" action="logar.php" method="POST">
            <label for="loginEmail">Usuário:</label>
            <input type="text" id="loginUser" name="user" required>
            
            <label for="loginPassword">Senha:</label>
            <input type="password" id="loginPassword" name="password" required>
            
            <button type="submit">Entrar</button>
            <br>
            <br>
            não tem uma conta?  <a href="registra.php" class="register-link">Cadastre-se</a>
        </form>

</body>
</html>

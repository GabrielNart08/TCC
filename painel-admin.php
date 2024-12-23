<?php
session_start();

// Verifica se o usuário está logado e se é administrador
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'administrador') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Admin</title>
    <style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Poppins', sans-serif;
    background-color: white;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    color: #333;
}

.container {
    text-align: center;
    background: #fff;
    padding: 40px 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border: 2px solid #1d1d1d;
    max-width: 600px; /* Limita a largura do container */
    width: 100%;
}

h1 {
    margin-bottom: 20px;
    color: #333;
}

.options {
    display: flex;
    flex-wrap: wrap; /* Permite que os botões quebrem linha */
    justify-content: center;
    gap: 20px;
    margin-bottom: 20px;
}

.option {
    display: inline-block;
    padding: 15px 30px; /* Ajustado o padding para um tamanho mais confortável */
    background-color: #007bff;
    color: #fff;
    text-decoration: none;
    border-radius: 8px;
    font-size: 18px;
    transition: background-color 0.3s ease;
    max-width: 200px; /* Limita a largura dos botões */
    text-align: center;
    border: 2px solid #1d1d1d;
}

.option:hover {
    background-color: #0056b3;
}

.logout {
    margin-top: 20px;
    display: inline-block;
    padding: 10px 20px;
    background-color: #dc3545;
    color: #fff;
    text-decoration: none;
    border-radius: 8px;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

.logout:hover {
    background-color: #a71d2a;
}

#pend {
    background-color: rgb(255, 208, 0);
    color: #1d1d1d;
    font-weight: 500;
    transition: background-color 0.3s ease;
}

#pend:hover {
    background-color: rgb(245, 190, 0);
}

#conf {
    background-color: forestgreen;
    font-weight: 500;
    color: #1d1d1d;
    transition: background-color 0.3s ease;
}

#conf:hover {
    background-color: green;
}

#finalizada {
    background-color: darkblue;
    color: white;
    font-weight: 480;
    transition: background-color 0.3s ease;
}

#finalizada:hover {
    background-color: blue;
}

#minhasquad {
    background-color: #1c3e50;
    color: white;
    font-weight: 480;
    transition: background-color 0.3s ease;
}

#minhasquad:hover {
    background-color: #2c3e50;
}
    </style>
</head>
<body>
    <div class="container">
        <h1>Bem-vindo, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <div class="options">
            <a href="admin-reservas.php" class="option" id="pend">Reservas Pendentes</a>
            <a href="reservas-confirmadas.php" class="option" id="conf">Reservas Confirmadas</a>
            <a href="reservas-finalizadas.php" class="option" id="finalizada">Reservas Finalizadas</a>
            <a href="cadastrar-quadras.php" class="option">Cadastrar Quadras</a>
            <a href="minhas-quadras.php" class="option" id="minhasquad">Minhas Quadras</a>
            
            
        </div>
        <a href="logout.php" class="logout">Sair</a>
    </div>
</body>
</html>

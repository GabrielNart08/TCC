<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "reservaquadras";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

session_start();

if (isset($_POST['user']) && isset($_POST['password'])) {

    $usuario = $_POST['user'];
    $senha = $_POST['password'];
    $sql = "SELECT * FROM usuario WHERE username = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param('s', $usuario);
        $stmt->execute();
        
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Verifica a senha
            if (isset($user['senha']) && password_verify($senha, $user['senha'])) {
                // Armazena informações na sessão
                $_SESSION['user_id'] = $user['id_usuario'];
                $_SESSION['user_name'] = $user['nome'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['user_type'] = $user['tipo']; // Tipo de usuário

                
                echo "Tipo de usuário: " . $_SESSION['user_type']; 
                
                // Redireciona com base no tipo do usuário
                if ($user['tipo'] === 'administrador') {
                    header("Location: painel-admin.php");  
                } else {
                    header("Location: index.php");  
                }
                exit();
            } else {
                echo "Senha inválida.";
            }
        } else {
            echo "Usuário não encontrado.";
        }

        $stmt->close();
    } else {
        echo "Erro na preparação da consulta: " . $conn->error;
    }
} else {
    echo "Dados não enviados.";
}

$conn->close();
?>

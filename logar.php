<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bancotcc";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}


session_start();

if (isset($_POST['user']) && isset($_POST['password'])) {

    $usuario = $_POST['user'];
    $senha = $_POST['password'];
    $sql = "SELECT * FROM usuario WHERE usuario=?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param('s', $usuario);
        
        $stmt->execute();
        
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            

            if (isset($user['senha']) && password_verify($senha, $user['senha'])) {

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];
                

                header("Location: index.php");
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
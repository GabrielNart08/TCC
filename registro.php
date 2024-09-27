<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bancotcc";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se os campos 'name', 'email' e 'password' estão definidos e não estão vazios
    if (isset($_POST['name'], $_POST['user'], $_POST['email'], $_POST['password'])) {
        $name = $_POST['name'];
        $user = $_POST['user'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        // Prepara a consulta SQL para verificar se o email já está registrado
        $stmt = $conn->prepare("SELECT * FROM usuario WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "Email já registrado.";
        } else {
            // Prepara a consulta SQL para inserir um novo usuário
            $stmt = $conn->prepare("INSERT INTO usuario (nome, usuario, email, senha) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name,$user, $email, $password);

            if ($stmt->execute()) {
                header("Location: login.php");
            } else {
                echo "Erro: " . $stmt->error;
            }
        }

        $stmt->close();
    } else {
        echo "Por favor, preencha todos os campos.";
    }
} else {
    echo "Formulário não enviado.";
}

$conn->close();
?>

<?php
session_start();

// Verifica se o usuário está logado como administrador
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "reservaquadras";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Processar o cadastro de quadra
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Dados da quadra
    $nome = $_POST['nome'];
    $endereco = $_POST['endereco'];
    $preco = $_POST['preco'];
    $imagem = $_FILES['imagem']['name'];

    // Upload da imagem
    $target_dir = "img/";
    $target_file = $target_dir . basename($_FILES["imagem"]["name"]);
    if (!move_uploaded_file($_FILES["imagem"]["tmp_name"], $target_file)) {
        die("Erro ao fazer upload da imagem.");
    }

    // Inserir quadra no banco
    $sql = "INSERT INTO quadra (nome, endereco, preco, imagem, id_usuario) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdsi", $nome, $endereco, $preco, $imagem, $_SESSION['user_id']);
    
    if ($stmt->execute()) {
        $id_quadra = $stmt->insert_id; // Obtém o ID da quadra cadastrada

        // Inserir horários no banco
        if (!empty($_POST['datas']) && !empty($_POST['hora_inicio']) && !empty($_POST['hora_fim'])) {
            $datas = $_POST['datas'];
            $horas_inicio = $_POST['hora_inicio'];
            $horas_fim = $_POST['hora_fim'];

            $sql_horarios = "INSERT INTO horario (id_quadra, data, hora_inicio, hora_fim) VALUES (?, ?, ?, ?)";
            $stmt_horarios = $conn->prepare($sql_horarios);

            foreach ($datas as $index => $data) {
                $hora_inicio = $horas_inicio[$index];
                $hora_fim = $horas_fim[$index];

                $stmt_horarios->bind_param("isss", $id_quadra, $data, $hora_inicio, $hora_fim);
                if (!$stmt_horarios->execute()) {
                    echo "Erro ao inserir horário: " . $stmt_horarios->error;
                }
            }
        }

        // Setar uma variável de sucesso para ser exibida na página
        $_SESSION['quadra_cadastrada'] = true;

        // Não redirecionar, apenas carregar a página atual
        header("Location: cadastro_quadras.php");
        exit();
    } else {
        echo "Erro ao cadastrar quadra: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

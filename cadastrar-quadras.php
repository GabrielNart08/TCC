<?php
// Conectar ao banco de dados
include('conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Receber os dados do formulário
    $nome = $_POST['nome'];
    $endereco = $_POST['endereco'];
    $tipo = $_POST['tipo'];
    $preco = $_POST['preco'];
    $imagens = $_FILES['imagens'];

    // Lógica para salvar imagens (pode ser adaptada conforme necessidade)
    $imagensString = "";
    foreach ($imagens['tmp_name'] as $key => $tmp_name) {
        $nomeImagem = $imagens['name'][$key];
        $caminhoImagem = "uploads/" . $nomeImagem;
        move_uploaded_file($tmp_name, $caminhoImagem);
        $imagensString .= $caminhoImagem . ",";
    }

    // Receber horários como JSON
    $horarios = [];
    foreach ($_POST['horarios'] as $horario) {
        list($inicio, $fim) = explode('-', $horario);
        $horarios[] = ['inicio' => $inicio, 'fim' => $fim];
    }
    $horariosJson = json_encode($horarios); // Convertendo para JSON

    // Inserir dados no banco de dados
    $sql = "INSERT INTO quadra (nome, endereco, tipo, preco, imagens, horarios)
            VALUES ('$nome', '$endereco', '$tipo', '$preco', '$imagensString', '$horariosJson')";

    if ($conn->query($sql) === TRUE) {
        echo "Quadra cadastrada com sucesso!";
    } else {
        echo "Erro ao cadastrar quadra: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Quadra</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="form-container">
        <h1>Cadastrar Quadra</h1>
        <form action="cadastro_quadras.php" method="POST" enctype="multipart/form-data">
            <label for="nome">Nome da Quadra:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="endereco">Endereço:</label>
            <input type="text" id="endereco" name="endereco" required>

            <label for="tipo">Tipo da Quadra:</label>
            <select id="tipo" name="tipo">
                <option value="futsal">Futsal</option>
                <option value="society">Society</option>
            </select>

            <label for="preco">Preço:</label>
            <input type="number" id="preco" name="preco" step="0.01" required>

            <label for="imagens">Imagens (selecione múltiplas):</label>
            <input type="file" id="imagens" name="imagens[]" multiple>

            <label for="horarios">Horários Disponíveis (formato: 19:00-20:00):</label>
            <input type="text" id="horarios" name="horarios[]" required>

            <button type="submit">Cadastrar Quadra</button>
        </form>
    </div>
</body>
</html>

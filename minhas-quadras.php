<?php
session_start();
require 'conexao.php';

// Verifica se o usuário está logado e se é administrador
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'administrador') {
    header("Location: login.php");
    exit();
}

$id_admin = $_SESSION['user_id'];

// Buscar todas as quadras cadastradas pelo admin
$query = "SELECT * FROM quadra WHERE id_usuario = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_admin);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Quadras</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<style>
    /* Reset básico */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Fonte geral */
body {
    font-family: 'Poppins', sans-serif;
    background-color: #f4f4f4;
    color: #333;
    line-height: 1.6;
}

/* Cabeçalho */
header {
    background-color: #2c3e50;
    color: #fff;
    padding: 20px 0;
    text-align: center;
}

header h1 {
    margin: 0;
    font-size: 2.5rem;
}

/* Navegação */
nav ul {
    list-style: none;
    padding: 10px;
}

nav ul li {
    display: inline-block;
    margin-right: 20px;
}

nav ul li a {
    color: #fff;
    text-decoration: none;
    font-size: 1.2rem;
    padding: 5px 15px;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

nav ul li a:hover {
    background-color: #16a085;
}

/* Conteúdo principal */
main {
    max-width: 1100px;
    margin: 0 auto;
    padding: 40px 20px;
}

/* Seção de quadras */
.quadras-list {
    margin-top: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table th, table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

table th {
    background-color: #34495e;
    color: #fff;
}

table td {
    background-color: #fff;
    font-size: 1.1rem;
}

table td a {
    color: #2c3e50;
    text-decoration: none;
    font-weight: bold;
}

table td a:hover {
    color: #e74c3c;
}

/* Estilo para a mensagem quando não houver quadras */
.quadras-list p {
    font-size: 1.2rem;
    color: #e74c3c;
    text-align: center;
}

/* Estilo da tabela em diferentes tamanhos de tela */
@media screen and (max-width: 768px) {
    table th, table td {
        font-size: 1rem;
        padding: 10px;
    }

    table td a {
        font-size: 1rem;
    }
}

</style>
<body>
    <header>
        <h1>Minhas Quadras</h1>
        <nav>
            <ul>
                <li><a href="painel-admin.php">Voltar</a></li>
            </ul>
        </nav>
    </header>

    <section class="quadras-list">
        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Endereço</th>
                        <th>Tipo</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['nome']); ?></td>
                            <td><?php echo htmlspecialchars($row['endereco']); ?></td>
                            <td><?php echo htmlspecialchars($row['tipo']); ?></td>
                            <td>
                                <a href="editar-quadra.php?id=<?php echo $row['id_quadra']; ?>">Editar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Você não tem quadras cadastradas.</p>
        <?php endif; ?>
    </section>
</body>
</html>

<?php
// Fechar a conexão
$stmt->close();
$conn->close();
?>

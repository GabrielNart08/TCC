<?php
// buscar_horarios.php
session_start();
include("conexao.php"); // Inclua o arquivo de conexão com o banco de dados

$id_quadra = $_POST['id_quadra'];
$data = $_POST['data'];

$sql = "SELECT * FROM horario WHERE id_quadra = ? AND data = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $id_quadra, $data);
$stmt->execute();
$result = $stmt->get_result();

$horarios = [];
while ($row = $result->fetch_assoc()) {
    $horarios[] = $row;
}

echo json_encode($horarios); // Retorna os horários como JSON
?>

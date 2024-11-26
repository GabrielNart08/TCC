<?php
// Conectar ao banco de dados
include 'conexao.php'; // Arquivo com a conexão ao banco

// Obter os parâmetros passados pela URL
$id_quadra = $_GET['id_quadra'];
$dia_semana = $_GET['dia_semana'];

// Consulta para buscar os horários disponíveis
$query = "SELECT id_horario, hora_inicio, hora_fim FROM horario 
          WHERE id_quadra = ? AND dia_semana = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('is', $id_quadra, $dia_semana);
$stmt->execute();
$result = $stmt->get_result();

$horarios = array();
while ($row = $result->fetch_assoc()) {
    // Adicionar cada horário ao array, incluindo id_horario
    $horarios[] = $row;
}

// Retornar os dados em formato JSON
echo json_encode(array(
    'id_quadra' => $id_quadra, // Inclui o id_quadra na resposta
    'horarios' => $horarios    // Lista de horários
));
?>

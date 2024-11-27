<?php
// Conectar ao banco de dados
include 'conexao.php'; // Arquivo com a conexão ao banco

// Verificar se os parâmetros necessários estão presentes na URL
if (isset($_GET['id_quadra']) && isset($_GET['dia_semana'])) {
    $id_quadra = $_GET['id_quadra'];
    $dia_semana = $_GET['dia_semana'];

    // Consulta para buscar os horários disponíveis
    $query = "SELECT id_horario, hora_inicio, hora_fim FROM horario WHERE id_quadra = ? AND dia_semana = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        // Vincular os parâmetros e executar a consulta
        $stmt->bind_param('is', $id_quadra, $dia_semana);
        $stmt->execute();
        $result = $stmt->get_result();

        // Array para armazenar os horários
        $horarios = array();
        while ($row = $result->fetch_assoc()) {
            // Adicionar cada horário ao array, incluindo id_horario
            $horarios[] = $row;
        }

        // Fechar a declaração e o resultado
        $stmt->close();
        
        // Retornar os dados em formato JSON
        echo json_encode(array(
            'id_quadra' => $id_quadra, // Inclui o id_quadra na resposta
            'horarios' => $horarios    // Lista de horários
        ));
    } else {
        // Se houver falha ao preparar a consulta, retorna erro
        echo json_encode(array('error' => 'Falha ao preparar a consulta'));
    }

} else {
    // Se os parâmetros não forem passados corretamente
    echo json_encode(array('error' => 'Parâmetros inválidos ou ausentes'));
}

// Fechar a conexão
$conn->close();
?>

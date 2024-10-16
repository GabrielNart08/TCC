<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Pagamento</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .payment-info {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            padding: 10px 15px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Página de Pagamento</h1>
        
        <?php
        // Receber os dados via GET
        $horario = isset($_GET['horario']) ? $_GET['horario'] : 'N/A';
        $nome = isset($_GET['nome']) ? $_GET['nome'] : 'N/A';
        $valor = isset($_GET['valor']) ? $_GET['valor'] : 'N/A';

        echo "<div class='payment-info'>";
        echo "<p>Você está reservando o horário: <strong>$horario</strong></p>";
        echo "<p>Quadra: <strong>$nome</strong></p>";
        echo "<p>Valor: <strong>R$ $valor</strong></p>";
        echo "</div>";

        // Simulação de geração de código PIX
        $codigoPix = "PIX1234567890"; // Aqui você geraria o código PIX real
        ?>

        <p>Código PIX: <strong><?php echo $codigoPix; ?></strong></p>

        <button onclick="confirmarPagamento()">Confirmar Pagamento</button>

        <script>
        function confirmarPagamento() {
            // Simulação de validação do pagamento
            
            // Envia os dados da reserva para o servidor
            window.location.href = "confirmar_pagamento.php?horario=<?php echo $horario; ?>&nome=<?php echo $nome; ?>&valor=<?php echo $valor; ?>"; // Redireciona para a página de confirmação
        }
        </script>
    </div>
</body>
</html>

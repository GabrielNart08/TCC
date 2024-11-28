<?php
// Conectar ao banco de dados
include('conexao.php');
session_start(); // Certifique-se de que a sessão está ativa para identificar o usuário logado

// Verificar se os parâmetros estão definidos
if (isset($_GET['id_quadra']) && isset($_GET['id_horario'])) {
  $id_quadra = $_GET['id_quadra'];
  $id_horario = $_GET['id_horario'];

  // Armazenar o id_quadra na sessão
  $_SESSION['id_quadra'] = $id_quadra;
  $_SESSION['id_horario'] = $id_horario; // Opcional, se necessário
} else {
  echo "Parâmetros inválidos!";
  exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recebe os dados do formulário
    $nome_completo = $_POST['nome_completo'];
    $email = $_POST['email'];
    $data_nascimento = $_POST['data_nascimento'];
    $cpf = $_POST['cpf'];
    $cep = $_POST['cep'];
    $rua = $_POST['rua'];
    $bairro = $_POST['bairro'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];
    $telefone = $_POST['telefone'];
    $id_quadra = $_SESSION['id_quadra']; 
    $horario = $id_horario;  // Usando o horário passado via GET

    // Obter a imagem da quadra a partir do id_quadra
$query_imagem = "SELECT imagem FROM quadra WHERE id_quadra = '$id_quadra'";
$result_imagem = mysqli_query($conn, $query_imagem);

if ($result_imagem && mysqli_num_rows($result_imagem) > 0) {
    $row_imagem = mysqli_fetch_assoc($result_imagem);
    $imagem_quadra = $row_imagem['imagem'];  // Caminho da imagem da quadra
} else {
    $imagem_quadra = '';  // Caso a imagem não exista, atribui uma string vazia
}

    // Inserir os dados na tabela `clientes`
    $query_cliente = "INSERT INTO clientes (nome_completo, email, data_nascimento, cpf, cep, rua, bairro, cidade, estado, telefone) 
                      VALUES ('$nome_completo', '$email', '$data_nascimento', '$cpf', '$cep', '$rua', '$bairro', '$cidade', '$estado', '$telefone')";

    if (mysqli_query($conn, $query_cliente)) {
        $id_cliente = mysqli_insert_id($conn); // Obtém o ID do cliente inserido

        // Inserir a reserva na tabela `reservas`
        $id_usuario = $_SESSION['user_id']; // Exemplo: ID do usuário logado
        $query_reserva = "INSERT INTO reservas (id_usuario, id_cliente, id_quadra, id_horario, imagem) 
                  VALUES ('$id_usuario', '$id_cliente', '$id_quadra', '$horario', '$imagem_quadra')";

if (mysqli_query($conn, $query_reserva)) {
    // Reserva feita com sucesso
    $message = "Reserva feita com sucesso!";
    $message_type = "success"; // Cor verde para sucesso

    // Redireciona o usuário para a página de "Minhas Reservas"
    echo "<script>
            setTimeout(function() {
                window.location.href = 'reservas.php'; 
            }, 2000); // Redireciona após 2 segundos
          </script>";
} else {
    $message = "Erro ao salvar a reserva: " . mysqli_error($conn);
    $message_type = "error";
}
    } else {
        $message = "Erro ao salvar os dados do cliente: " . mysqli_error($conn);
        $message_type = "error";
    }
}
?>





<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/dadoscliente.css">

    <title>Dados do Usuário</title>
</head>
<body>
    
<style>
        /* Estilo do alertbox */
        .alertbox {
            display: none; /* Inicialmente oculto */
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #28a745; /* Verde para sucesso */
            color: white;
            padding: 20px 40px;
            font-size: 18px;
            border-radius: 10px;
            z-index: 9999;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
            text-align: center;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
            width: 80%;
            max-width: 500px;
        }

        .alertbox.show {
            display: block;
            opacity: 1;
        }

        .alertbox .icon {
            font-size: 30px;
            margin-right: 15px;
        }

        .alertbox .message {
            display: inline-block;
            font-size: 18px;
            margin-left: 10px;
        }
    </style>

<form id="dadoscliente-form" method="POST">
  <h3>Preencha seus dados para completar a reserva</h3>
  
  <div class="form-row">
    <div class="form-column">
      <label for="nome_completo">Nome Completo</label>
      <input type="text" id="nome_completo" name="nome_completo" placeholder="Digite seu nome completo" required>
    </div>
    <div class="form-column">
      <label for="email">E-mail</label>
      <input type="email" id="email" name="email" placeholder="Digite seu e-mail" required>
    </div>
  </div>

  <div class="form-row">
    <div class="form-column">
      <label for="data_nascimento">Data de Nascimento</label>
      <input type="date" id="data_nascimento" name="data_nascimento" required>
    </div>
    <div class="form-column">
    <label for="cpf">CPF:</label>
    <input type="text" id="cpf" name="cpf" placeholder="Digite seu CPF" required maxlength="14">
    </div>
  </div>

  <div class="form-row">
    <div class="form-column">
      <label for="cep">CEP</label>
      <input type="text" id="cep" name="cep" placeholder="Digite seu CEP" required>
    </div>
    <div class="form-column">
      <label for="rua">Rua</label>
      <input type="text" id="rua" name="rua" placeholder="Digite sua rua" required>
    </div>
  </div>

  <div class="form-row">
    <div class="form-column">
      <label for="bairro">Bairro</label>
      <input type="text" id="bairro" name="bairro" placeholder="Digite seu bairro" required>
    </div>
    <div class="form-column">
      <label for="cidade">Cidade</label>
      <input type="text" id="cidade" name="cidade" placeholder="Digite sua cidade" required>
    </div>
  </div>

  <div class="form-row">
    <div class="form-column">
      <label for="estado">Estado</label>
      <input type="text" id="estado" name="estado" placeholder="Digite seu estado" required>
    </div>
    <div class="form-column">
    <label for="telefone">Telefone</label>
<input type="text" id="telefone" name="telefone" placeholder="(00) 99999-9999" required>

    </div>
  </div>

  <div class="button-group">
    <a href="quadras.php">
      <button type="button" class="btn-voltar">Voltar</button>
    </a>
    <button type="submit" id="continuar-btn">Continuar</button>
  </div>
</form>


<?php if (isset($message)): ?>
    <!-- Exibe o alertbox -->
    <div class="alertbox <?php echo $message_type == 'success' ? 'show' : ''; ?>" id="alertbox">
        <span class="icon">✔</span>
        <span class="message"><?php echo $message; ?></span>
    </div>
<?php endif; ?>


<script>
    // Função para formatar o CPF
  function formatCPF(cpf) {
    return cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4");
  }

  // Adiciona a formatação no campo de CPF enquanto o usuário digita
  document.getElementById('cpf').addEventListener('input', function(event) {
    let cpf = event.target.value.replace(/\D/g, ''); // Remove qualquer caracter não numérico
    if (cpf.length <= 11) {
      event.target.value = formatCPF(cpf);
    }
  });
     // Função para formatar o telefone com máscara
  function formatarTelefone(input) {
    let telefone = input.value.replace(/\D/g, ''); // Remove tudo que não for número

    // Aplica a formatação (XX) xxxxx-xxxx
    if (telefone.length <= 2) {
      input.value = `(${telefone}`;
    } else if (telefone.length <= 6) {
      input.value = `(${telefone.substring(0, 2)}) ${telefone.substring(2)}`;
    } else {
      input.value = `(${telefone.substring(0, 2)}) ${telefone.substring(2, 7)}-${telefone.substring(7, 11)}`;
    }
  }

  // Adiciona o evento de input no campo telefone
  document.getElementById('telefone').addEventListener('input', function() {
    formatarTelefone(this);
  });
  // Função para buscar o endereço via API ViaCEP
  function buscarEndereco() {
    var cep = document.getElementById('cep').value.replace(/\D/g, ''); // Limpa o CEP
    if (cep.length === 8) { // Verifica se o CEP tem 8 dígitos
      var url = `https://viacep.com.br/ws/${cep}/json/`;
      

      fetch(url)
        .then(response => response.json())
        .then(data => {
 
          if (data.erro) {
            alert('CEP não encontrado!');
          } else {
            document.getElementById('rua').value = data.logradouro;
            document.getElementById('bairro').value = data.bairro;
            document.getElementById('cidade').value = data.localidade;
            document.getElementById('estado').value = data.uf;
          }
        })
        .catch(error => {
          alert('Erro ao buscar o CEP. Tente novamente.');
          console.error(error);
        });
    } else {
      // Limpa os campos se o CEP for inválido
      document.getElementById('rua').value = '';
      document.getElementById('bairro').value = '';
      document.getElementById('cidade').value = '';
      document.getElementById('estado').value = '';
    }
  }

  // Adiciona o evento de digitação no campo de CEP
  document.getElementById('cep').addEventListener('blur', buscarEndereco);

   // Função para exibir o alertbox
   function mostrarAlerta() {
        var alerta = document.getElementById('alertbox');
        alerta.classList.add('show');
        
        // Esconder o alerta após 3 segundos
        setTimeout(function() {
            alerta.classList.remove('show');
        }, 3000);  // O alerta ficará visível por 3 segundos
    }

    // Dispara o alerta de sucesso ao enviar o formulário
    <?php if (isset($message_type) && $message_type == 'success'): ?>
        mostrarAlerta();
    <?php endif; ?>

</script>


</body>
</html>
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 26-Nov-2024 às 23:28
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `reservaquadras`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `nome_completo` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `data_nascimento` date NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `cep` varchar(8) NOT NULL,
  `rua` varchar(255) NOT NULL,
  `bairro` varchar(255) NOT NULL,
  `cidade` varchar(255) NOT NULL,
  `estado` varchar(2) NOT NULL,
  `telefone` varchar(15) NOT NULL,
  `data_reserva` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `nome_completo`, `email`, `data_nascimento`, `cpf`, `cep`, `rua`, `bairro`, `cidade`, `estado`, `telefone`, `data_reserva`) VALUES
(3, 'Gabriel Nart', 'gabrielsnart132@gmail.com', '2002-02-02', '086.343.539-40', '88817677', 'Servidão Santa Fé', 'Rio Maina', 'Criciúma', 'SC', '(48) 99999-9999', '2024-11-26 21:26:34');

-- --------------------------------------------------------

--
-- Estrutura da tabela `horario`
--

CREATE TABLE `horario` (
  `id_horario` int(11) NOT NULL,
  `id_quadra` int(11) NOT NULL,
  `dia_semana` enum('Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo') NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fim` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `horario`
--

INSERT INTO `horario` (`id_horario`, `id_quadra`, `dia_semana`, `hora_inicio`, `hora_fim`) VALUES
(1, 3, 'Segunda', '20:00:00', '21:00:00'),
(2, 4, 'Segunda', '20:00:00', '21:00:00'),
(3, 5, 'Terça', '20:00:00', '21:00:00'),
(4, 5, 'Terça', '21:00:00', '22:00:00'),
(5, 6, 'Terça', '20:00:00', '21:00:00'),
(6, 6, 'Terça', '19:00:00', '20:00:00'),
(7, 6, 'Quarta', '21:00:00', '22:00:00'),
(8, 7, 'Quinta', '21:00:00', '22:00:00'),
(9, 7, 'Sexta', '19:00:00', '20:00:00'),
(10, 7, 'Sexta', '20:00:00', '21:00:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `quadra`
--

CREATE TABLE `quadra` (
  `id_quadra` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `imagem` varchar(255) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `horarios` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`horarios`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `quadra`
--

INSERT INTO `quadra` (`id_quadra`, `nome`, `endereco`, `tipo`, `preco`, `imagem`, `id_usuario`, `horarios`) VALUES
(1, 'Brotolandia', 'Rua Henrique Lage', '', 120.00, 'Captura de Tela (1).png', 1, NULL),
(2, 'tigrezinho', 'Rua Henrique Lage', '', 120.00, 'Captura de Tela (6).png', 1, 'null'),
(3, 'tigrezao', 'Rua Henrique Lage', '', 140.00, 'Captura de Tela (6) - Copia.png', 1, NULL),
(4, 'teste1', 'vila isabel', '', 200.00, 'Leonardo_Phoenix_a_dramatic_highcontrast_cinematic_photograph_1.jpg', 1, NULL),
(5, 'flamengo', 'rio maina', '', 180.00, 'Leonardo_Phoenix_A_hauntingly_beautiful_highcontrast_cinematic_2.jpg', 1, NULL),
(6, 'Angeloni', 'Rua henrique 123', '', 200.00, 'Leonardo_Phoenix_A_hauntingly_beautiful_highcontrast_cinematic_2.jpg', 1, NULL),
(7, 'testeeeeee', 'rio maina', '', 160.00, 'Leonardo_Phoenix_A_modern_digital_calendar_interface_featuring_3.jpg', 1, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `reservas`
--

CREATE TABLE `reservas` (
  `id_reserva` int(11) NOT NULL,
  `id_quadra` int(11) NOT NULL,
  `id_horario` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `data_reserva` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('em análise','confirmada','cancelada') DEFAULT 'em análise',
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `reservas`
--

INSERT INTO `reservas` (`id_reserva`, `id_quadra`, `id_horario`, `id_cliente`, `data_reserva`, `status`, `id_usuario`) VALUES
(1, 7, 9, 3, '2024-11-26 21:26:34', 'em análise', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `tipo` enum('cliente','administrador') DEFAULT 'cliente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `username`, `senha`, `email`, `nome`, `tipo`) VALUES
(1, 'nartzera', '$2y$10$qn29kGOay0Cxi6P/rWP7Yel2TciDq3R9cPcEbjuIwwmIs4hJb5nHm', 'gabrielnart132@gmail.com', 'Gabriel Serafim Nart', 'administrador'),
(2, 'nartt', '$2y$10$WlQ8CZ2P2RMsRUFT0Ba8kug7jIkFaHR5.LoOfcLWGwVQr3c5l8guK', 'gabrielsnart132@gmail.com', 'Gabriel', 'cliente'),
(3, 'narti', '$2y$10$Oyc.mXVq1A3ovvAC72OTx.iczyUvWRX9z1FwJZLSKfAIises3ide2', 'gabrielnart@hotmail.com', 'Gabriel', 'administrador'),
(4, 'top123', '$2y$10$XxVmDvGfMQEXYNG4Muukuu2cBQrWPaizK.tW8UJZyGvjw/3i./8bG', 'gustavo@gmail.com', 'Gustavo', 'cliente'),
(0, 'ggg', '$2y$10$OumMILsCpK/5nXOKf3F4seubxrbcigonA/9/hCU0uOybDV1smaqHq', 'gustavo1@gmail.com', 'gustavo', 'cliente');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`),
  ADD UNIQUE KEY `id_cliente` (`id_cliente`);

--
-- Índices para tabela `horario`
--
ALTER TABLE `horario`
  ADD PRIMARY KEY (`id_horario`),
  ADD KEY `id_quadra` (`id_quadra`);

--
-- Índices para tabela `quadra`
--
ALTER TABLE `quadra`
  ADD PRIMARY KEY (`id_quadra`);

--
-- Índices para tabela `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id_reserva`),
  ADD KEY `id_quadra` (`id_quadra`),
  ADD KEY `id_horario` (`id_horario`),
  ADD KEY `reservas_ibfk_3` (`id_cliente`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `horario`
--
ALTER TABLE `horario`
  MODIFY `id_horario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `quadra`
--
ALTER TABLE `quadra`
  MODIFY `id_quadra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id_reserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `horario`
--
ALTER TABLE `horario`
  ADD CONSTRAINT `horario_ibfk_1` FOREIGN KEY (`id_quadra`) REFERENCES `quadra` (`id_quadra`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`id_quadra`) REFERENCES `quadra` (`id_quadra`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservas_ibfk_2` FOREIGN KEY (`id_horario`) REFERENCES `horario` (`id_horario`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservas_ibfk_3` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

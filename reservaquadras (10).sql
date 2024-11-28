-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 28-Nov-2024 às 05:47
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
(3, 'Gabriel Nart', 'gabrielsnart132@gmail.com', '2002-02-02', '086.343.539-40', '88817677', 'Servidão Santa Fé', 'Rio Maina', 'Criciúma', 'SC', '(48) 99999-9999', '2024-11-26 21:26:34'),
(4, 'gustavo felipe', 'gugafelipe@gmail.com', '2005-05-11', '118.882.769-32', '88804690', 'Rua Padre Mário Labarbuta', 'Pinheirinho', 'Criciúma', 'SC', '(48) 99918-4155', '2024-11-27 02:14:50'),
(5, 'Gabriel Nart', 'gugafelipe@gmail.com', '2006-04-08', '118.882.769-32', '88817677', 'Servidão Santa Fé', 'Rio Maina', 'Criciúma', 'SC', '(48) 99918-4155', '2024-11-27 02:57:27'),
(6, 'Fernando Colombo', 'gugafelipe@gmail.com', '2001-02-21', '118.882.769-32', '88850-00', 'Rua Padre Mário Labarbuta', 'Pinheirinho', 'Forquilhinha', 'SC', '(48) 99918-4155', '2024-11-27 03:03:52'),
(7, 'Isadora Pinto', 'gugafelipe@gmail.com', '1111-02-21', '118.882.769-32', '88850-00', 'Rua Padre Mário Labarbuta', 'Pinheirinho', 'Forquilhinha', 'SC', '(48) 99918-4155', '2024-11-27 03:20:13'),
(8, 'Isadora Carvalho', 'gugadugrau@gmail.com', '2001-02-21', '118.882.769-32', '88850-00', 'Rua Padre Mário Labarbuta', 'Pinheirinho', 'Forquilhinha', 'SC', '(48) 99918-4155', '2024-11-27 03:49:58'),
(9, 'gustavo felipe', 'gugadugrau@gmail.com', '2006-04-08', '118.882.769-32', '88850-00', 'Rua Padre Mário Labarbuta', 'Pinheirinho', 'Forquilhinha', 'SC', '(48) 99918-4155', '2024-11-27 04:42:14'),
(10, 'Fernando Colombo', 'gugadugrau@gmail.com', '2000-02-22', '118.882.769-32', '88850-00', 'Rua Padre Mário Labarbuta', 'Rio Maina', 'Forquilhinha', 'SC', '(48) 99918-4155', '2024-11-27 05:30:38'),
(11, 'Isadora Pinto', 'gugafelipe@gmail.com', '2001-03-22', '118.882.769-32', '88850-00', 'Rua Padre Mário Labarbuta', 'Pinheirinho', 'Forquilhinha', 'SC', '(48) 99918-4155', '2024-11-27 08:42:48'),
(12, 'Isadora Carvalho', 'gugafelipe@gmail.com', '2000-10-10', '118.882.769-32', '88850-00', 'Rua Padre Mário Labarbuta', 'Pinheirinho', 'Forquilhinha', 'SC', '(48) 99918-4155', '2024-11-27 09:02:27'),
(13, 'Gustavo Topanotti Fernandes', 'gabrielnart132@gmail.com', '2000-02-10', '086.343.539-40', '88817-67', 'Servidão Santa Fé', 'Rio Maina', 'Criciúma', 'SC', '(48) 99856-6251', '2024-11-28 01:47:28'),
(14, 'Pedro Paulo', 'gabrielnart132@gmail.com', '1998-02-10', '086.343.539-40', '88817-67', 'Servidão Santa Fé', 'Rio Maina', 'Criciúma', 'SC', '(48) 99856-6251', '2024-11-28 02:19:10'),
(15, 'Pedro Paulo', 'gabrielnart132@gmail.com', '1998-02-10', '086.343.539-40', '88817-67', 'Servidão Santa Fé', 'Rio Maina', 'Criciúma', 'SC', '(48) 99856-6251', '2024-11-28 02:19:35'),
(16, 'Gabriel Serafim Nart', 'gabrielnart132@gmail.com', '0006-04-08', '086.343.539-40', '88817677', 'Servidão Santa Fé', 'Rio Maina', 'Criciúma', 'SC', '(48) 99856-6251', '2024-11-28 02:35:10'),
(17, 'Gabriel Serafim Nart', 'gabrielnart132@gmail.com', '2006-04-08', '086.343.539-40', '88817-67', 'Servidão Santa Fé', 'Rio Maina', 'Criciúma', 'SC', '(48) 99856-6251', '2024-11-28 03:48:28');

-- --------------------------------------------------------

--
-- Estrutura da tabela `horario`
--

CREATE TABLE `horario` (
  `id_horario` int(11) NOT NULL,
  `id_quadra` int(11) NOT NULL,
  `data` date DEFAULT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fim` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `horario`
--

INSERT INTO `horario` (`id_horario`, `id_quadra`, `data`, `hora_inicio`, `hora_fim`) VALUES
(53, 48, '2024-12-10', '19:00:00', '20:00:00'),
(55, 47, '2025-02-10', '10:00:00', '11:00:00'),
(56, 47, '2025-02-11', '11:00:00', '12:00:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `quadra`
--

CREATE TABLE `quadra` (
  `id_quadra` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `imagem` varchar(255) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `quadra`
--

INSERT INTO `quadra` (`id_quadra`, `nome`, `endereco`, `tipo`, `preco`, `imagem`, `id_usuario`) VALUES
(47, 'Angelonii', 'Rua Henrique Lagee', 'society', 180.00, 'Imagens Turma Do Chaves - Chaves E Seu Madruga Em Png Grátis 1F2.png', 1),
(48, 'tigrezao', 'Rua Henrique Lage', 'society', 180.00, 'Leonardo_Phoenix_A_cluttered_and_disorganized_clock_or_calenda_3.jpg', 1);

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
  `status` enum('pendente','confirmada','OK','Não Compareceu') NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `imagem` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(5, 'ggg', '$2y$10$OumMILsCpK/5nXOKf3F4seubxrbcigonA/9/hCU0uOybDV1smaqHq', 'gustavo1@gmail.com', 'gustavo', 'cliente'),
(6, 'guga00', '$2y$10$MfDDATys84rkSyjKa4ueo.KFwAP5If4VIY.43oQnHx3UPHauO43T2', 'gugafelipe@gmail.com', 'gustavo felipe', 'cliente');

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
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `horario`
--
ALTER TABLE `horario`
  MODIFY `id_horario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT de tabela `quadra`
--
ALTER TABLE `quadra`
  MODIFY `id_quadra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de tabela `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id_reserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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

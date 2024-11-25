-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 25/11/2024 às 17:51
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

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
-- Estrutura para tabela `administradores`
--

CREATE TABLE `administradores` (
  `id_admin` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `clientes`
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
-- Despejando dados para a tabela `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `nome_completo`, `email`, `data_nascimento`, `cpf`, `cep`, `rua`, `bairro`, `cidade`, `estado`, `telefone`, `data_reserva`) VALUES
(1, 'Gabriel Serafim Nart', 'gabrielnart132@gmail.com', '2006-04-08', '086.343.539-40', '88817677', 'Servidão Santa Fé', 'Rio Maina', 'Criciúma', 'SC', '(48) 99856-6251', '2024-11-24 14:27:16'),
(2, 'Gabriel Serafim Nart', 'gabrielnart132@gmail.com', '2006-04-08', '086.343.539-40', '88817-67', 'Servidão Santa Fé', 'Rio Maina', 'Criciúma', 'SC', '(48) 99856-6251', '2024-11-24 14:52:35'),
(3, 'Gabriel Serafim Nart', 'gabrielnart132@gmail.com', '2006-04-08', '086.343.539-40', '88817677', 'Servidão Santa Fé', 'Rio Maina', 'Criciúma', 'SC', '(48) 99856-6251', '2024-11-24 22:35:15'),
(4, 'Gabriel Serafim Nart', 'gabrielnart132@gmail.com', '2006-04-08', '086.343.539-40', '88817677', 'Servidão Santa Fé', 'Rio Maina', 'Criciúma', 'SC', '(48) 99856-6251', '2024-11-24 22:37:53'),
(5, 'Gabriel Serafim Nart', 'gabrielnart132@gmail.com', '2006-04-08', '086.343.539-40', '88817-67', 'Servidão Santa Fé', 'Rio Maina', 'Criciúma', 'SC', '(48) 99856-6251', '2024-11-25 12:33:33'),
(6, 'Gabriel Serafim Nart', 'gabrielnart132@gmail.com', '2006-04-08', '086.343.539-40', '88817-67', 'Servidão Santa Fé', 'Rio Maina', 'Criciúma', 'SC', '(48) 99856-6251', '2024-11-25 12:33:50'),
(7, 'Gabriel Serafim Nart', 'gabriel@gmail.com', '2006-04-08', '086.343.539-40', '88817677', 'Servidão Santa Fé', 'Rio Maina', 'Criciúma', 'SC', '(48) 99856-6251', '2024-11-25 13:21:57'),
(8, 'Gabriel', 'gabriel@gmail.com', '2006-04-08', '086.343.539-40', '88817677', 'Servidão Santa Fé', 'Rio Maina', 'Criciúma', 'SC', '(48) 99856-6251', '2024-11-25 16:33:37');

-- --------------------------------------------------------

--
-- Estrutura para tabela `notificacoes`
--

CREATE TABLE `notificacoes` (
  `id_notificacao` int(11) NOT NULL,
  `id_admin` int(11) NOT NULL,
  `id_reserva` int(11) NOT NULL,
  `mensagem` varchar(255) NOT NULL,
  `data_notificacao` datetime DEFAULT current_timestamp(),
  `status` enum('pendente','lida') DEFAULT 'pendente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `quadra`
--

CREATE TABLE `quadra` (
  `id_quadra` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `imagem` varchar(255) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `horarios` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`horarios`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `quadra`
--

INSERT INTO `quadra` (`id_quadra`, `nome`, `endereco`, `preco`, `imagem`, `id_usuario`, `horarios`) VALUES
(2, 'Quadra Teste', 'Rua Teste, 123', 0.00, 'resenha.jpg', 1, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `quadras_futsal`
--

CREATE TABLE `quadras_futsal` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `imagem` varchar(255) NOT NULL,
  `avaliacoes` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `reservas`
--

CREATE TABLE `reservas` (
  `id_reserva` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_quadra` int(11) NOT NULL,
  `horario` datetime NOT NULL,
  `status` varchar(20) DEFAULT 'em análise',
  `id_cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
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
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `username`, `senha`, `email`, `nome`, `tipo`) VALUES
(1, 'nartzera', '$2y$10$qn29kGOay0Cxi6P/rWP7Yel2TciDq3R9cPcEbjuIwwmIs4hJb5nHm', 'gabrielnart132@gmail.com', 'Gabriel Serafim Nart', 'administrador'),
(2, 'nartt', '$2y$10$WlQ8CZ2P2RMsRUFT0Ba8kug7jIkFaHR5.LoOfcLWGwVQr3c5l8guK', 'gabrielsnart132@gmail.com', 'Gabriel', 'cliente'),
(3, 'narti', '$2y$10$Oyc.mXVq1A3ovvAC72OTx.iczyUvWRX9z1FwJZLSKfAIises3ide2', 'gabrielnart@hotmail.com', 'Gabriel', 'administrador'),
(4, 'top123', '$2y$10$XxVmDvGfMQEXYNG4Muukuu2cBQrWPaizK.tW8UJZyGvjw/3i./8bG', 'gustavo@gmail.com', 'Gustavo', 'cliente'),
(5, 'nart', '$2y$10$0HrdZtaMoAA1SwmERYYGk.5M78yI/bPaYY8fay7/5hH4EDNLz.VSC', 'gabriel@gmail.com', 'Gabriel Nart', 'cliente');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices de tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Índices de tabela `notificacoes`
--
ALTER TABLE `notificacoes`
  ADD PRIMARY KEY (`id_notificacao`),
  ADD KEY `id_admin` (`id_admin`),
  ADD KEY `id_reserva` (`id_reserva`);

--
-- Índices de tabela `quadra`
--
ALTER TABLE `quadra`
  ADD PRIMARY KEY (`id_quadra`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices de tabela `quadras_futsal`
--
ALTER TABLE `quadras_futsal`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id_reserva`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_quadra` (`id_quadra`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `administradores`
--
ALTER TABLE `administradores`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `notificacoes`
--
ALTER TABLE `notificacoes`
  MODIFY `id_notificacao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `quadra`
--
ALTER TABLE `quadra`
  MODIFY `id_quadra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `quadras_futsal`
--
ALTER TABLE `quadras_futsal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id_reserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `notificacoes`
--
ALTER TABLE `notificacoes`
  ADD CONSTRAINT `notificacoes_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `notificacoes_ibfk_2` FOREIGN KEY (`id_reserva`) REFERENCES `reservas` (`id_reserva`);

--
-- Restrições para tabelas `quadra`
--
ALTER TABLE `quadra`
  ADD CONSTRAINT `quadra_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE;

--
-- Restrições para tabelas `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `reservas_ibfk_2` FOREIGN KEY (`id_quadra`) REFERENCES `quadra` (`id_quadra`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

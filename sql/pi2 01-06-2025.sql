pi2.sql
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 10/06/2025 às 01:33
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
-- Banco de dados: `pi2`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `estados`
--

CREATE TABLE `estados` (
  `id` int(11) NOT NULL,
  `uf` varchar(2) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `estados`
--

INSERT INTO `estados` (`id`, `uf`, `nome`) VALUES
(1, 'AC', 'Acre'),
(2, 'AL', 'Alagoas'),
(3, 'AP', 'Amapá'),
(4, 'AM', 'Amazonas'),
(5, 'BA', 'Bahia'),
(6, 'CE', 'Ceará'),
(7, 'DF', 'Distrito Federal'),
(8, 'ES', 'Espírito Santo'),
(9, 'GO', 'Goiás'),
(10, 'MA', 'Maranhão'),
(11, 'MT', 'Mato Grosso'),
(12, 'MS', 'Mato Grosso do Sul'),
(13, 'MG', 'Minas Gerais'),
(14, 'PA', 'Pará'),
(15, 'PB', 'Paraíba'),
(16, 'PR', 'Paraná'),
(17, 'PE', 'Pernambuco'),
(18, 'PI', 'Piauí'),
(19, 'RJ', 'Rio de Janeiro'),
(20, 'RN', 'Rio Grande do Norte'),
(21, 'RS', 'Rio Grande do Sul'),
(22, 'RO', 'Rondônia'),
(23, 'RR', 'Roraima'),
(24, 'SC', 'Santa Catarina'),
(25, 'SP', 'São Paulo'),
(26, 'SE', 'Sergipe'),
(27, 'TO', 'Tocantins');

-- --------------------------------------------------------

--
-- Estrutura para tabela `reservas`
--

CREATE TABLE `reservas` (
  `id_reserva` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_vaga` int(11) NOT NULL,
  `id_uf` int(11) NOT NULL,
  `cidade` varchar(255) NOT NULL,
  `bairro` varchar(255) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `numero` varchar(20) DEFAULT NULL,
  `complemento` varchar(255) DEFAULT NULL,
  `quant_dias` int(10) UNSIGNED NOT NULL,
  `valor_reserva` decimal(10,2) NOT NULL,
  `status` enum('r','l','c') NOT NULL COMMENT 'r=Reservado, l=Liberado, c=Cancelado',
  `data_reserva` date NOT NULL,
  `data_criacao_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `reservas`
--

INSERT INTO `reservas` (`id_reserva`, `id_usuario`, `id_vaga`, `id_uf`, `cidade`, `bairro`, `endereco`, `numero`, `complemento`, `quant_dias`, `valor_reserva`, `status`, `data_reserva`, `data_criacao_registro`) VALUES
(1, 1, 1, 24, 'Jaraguá do Sul', 'Vieira', 'Rua Gustavo Lessmann', '123', 'casa', 5, 450.00, 'c', '2025-06-08', '2025-06-07 21:51:28'),
(2, 1, 1, 24, 'Jaraguá do Sul', 'Vieira', 'Rua Gustavo Lessmann', '123', 'casa', 1, 90.00, 'c', '2025-06-09', '2025-06-08 01:20:02'),
(3, 1, 1, 24, 'Jaraguá do Sul', 'Vieira', 'Rua Gustavo Lessmann', '123', 'casa', 1, 90.00, 'c', '2025-06-10', '2025-06-09 20:34:15'),
(4, 4, 2, 24, 'Jaraguá do Sul', 'Vieira', 'Rua Gustavo Lessmann', '1350', 'casa', 12, 600.00, 'r', '2025-06-10', '2025-06-09 21:25:26');

-- --------------------------------------------------------

--
-- Estrutura para tabela `sessions`
--

CREATE TABLE `sessions` (
  `session_id` varchar(128) NOT NULL,
  `session_data` text NOT NULL,
  `session_timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `cpf` varchar(20) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `dataCadastro` date DEFAULT curdate(),
  `nivel_acesso` int(11) NOT NULL DEFAULT 1 COMMENT '1=Usuário Padrão, 2=Administrador'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `cpf`, `telefone`, `email`, `senha`, `dataCadastro`, `nivel_acesso`) VALUES
(1, 'Anderson', '000.000.000-77', '(47) 99999-9999', 'anderson@gmail.com', '$2y$10$rwiAWRJLhNQvH4kaDP8/2O3EIGTeAQKSgdmvg9L08HK2m1zn6hYDm', '2025-06-07', 1),
(4, 'Carlos Tadeu Godoi', '000.000.000-00', '(47) 99999-9999', 'test@gmail.com', '$2y$10$Yghnnj01lIy9dndPZZFoxuZ1LBEXdfXxV.J76pYYkHiii4aqNzCkG', '2025-06-09', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `vagas`
--

CREATE TABLE `vagas` (
  `id` int(11) NOT NULL,
  `descricao` text NOT NULL,
  `cep` varchar(10) NOT NULL,
  `cidade` varchar(255) NOT NULL,
  `bairro` varchar(255) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `numero` varchar(20) DEFAULT NULL,
  `complemento` varchar(255) DEFAULT NULL,
  `foto_vaga` varchar(255) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `id_uf` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `status_vaga` enum('ativa','inativa') NOT NULL DEFAULT 'ativa' COMMENT 'Status da vaga: ativa para listagem, inativa para não aparecer nas buscas',
  `dataCadastro` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `vagas`
--

INSERT INTO `vagas` (`id`, `descricao`, `cep`, `cidade`, `bairro`, `endereco`, `numero`, `complemento`, `foto_vaga`, `preco`, `id_uf`, `id_usuario`, `status_vaga`, `dataCadastro`) VALUES
(1, 'Vaga shopping urubici', '89257-200', 'Jaraguá do Sul', 'Vieira', 'Rua Gustavo Lessmann', '123', 'casa', 'assets/img/vagas/vaga_6844b45369e787.28731260.png', 90.00, 24, 1, 'ativa', '2025-06-07'),
(2, 'Sombra', '', 'Jaraguá do Sul', 'Vieira', 'Rua Gustavo Lessmann', '1350', 'casa', 'assets/img/vagas/vaga_6844b65dea4776.05937936.png', 50.00, 24, 1, 'ativa', '2025-06-07');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `estados`
--
ALTER TABLE `estados`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id_reserva`),
  ADD KEY `idx_reservas_id_usuario` (`id_usuario`),
  ADD KEY `idx_reservas_id_vaga` (`id_vaga`),
  ADD KEY `idx_reservas_id_uf` (`id_uf`),
  ADD KEY `idx_data_reserva` (`data_reserva`);

--
-- Índices de tabela `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`session_id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_email_unique` (`email`),
  ADD UNIQUE KEY `idx_cpf_unique` (`cpf`);

--
-- Índices de tabela `vagas`
--
ALTER TABLE `vagas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_vagas_id_usuario` (`id_usuario`),
  ADD KEY `idx_vagas_id_uf` (`id_uf`),
  ADD KEY `idx_cidade` (`cidade`(191)),
  ADD KEY `idx_preco` (`preco`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `estados`
--
ALTER TABLE `estados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de tabela `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id_reserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `vagas`
--
ALTER TABLE `vagas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `fk_reservas_id_uf` FOREIGN KEY (`id_uf`) REFERENCES `estados` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_reservas_id_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_reservas_id_vaga` FOREIGN KEY (`id_vaga`) REFERENCES `vagas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `vagas`
--
ALTER TABLE `vagas`
  ADD CONSTRAINT `fk_vagas_id_uf` FOREIGN KEY (`id_uf`) REFERENCES `estados` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_vagas_id_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

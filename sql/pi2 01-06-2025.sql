-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 11/06/2025 às 19:09
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
  `id` int(20) NOT NULL,
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
  `id_reserva` int(20) NOT NULL,
  `id_usuario` int(20) NOT NULL,
  `id_vaga` int(20) NOT NULL,
  `id_uf` int(20) NOT NULL,
  `cidade` varchar(255) NOT NULL,
  `bairro` varchar(255) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `numero` varchar(20) DEFAULT NULL,
  `complemento` varchar(255) NOT NULL,
  `quant_dias` int(10) UNSIGNED NOT NULL,
  `valor_reserva` decimal(10,2) NOT NULL,
  `status` enum('r','l','c') NOT NULL COMMENT 'r=Reservado, l=Liberado, c=Cancelado',
  `data_reserva` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `reservas`
--

INSERT INTO `reservas` (`id_reserva`, `id_usuario`, `id_vaga`, `id_uf`, `cidade`, `bairro`, `endereco`, `numero`, `complemento`, `quant_dias`, `valor_reserva`, `status`, `data_reserva`) VALUES
(6, 1, 9, 0, 'Jaraguá do Sul', 'Centro', 'Av. Mal. Deodoro da Fonseca', '915', 'Próximo ao calçadão', 4, 20.00, 'r', '2025-05-14'),
(7, 11, 13, 24, 'Jaraguá do Sul', 'Vieira', 'Rua Gustavo Lessmann', '1', 'casa', 1, 23.00, 'r', '2025-05-31'),
(8, 1, 8, 24, 'Jaraguá do Sul', 'Vieira', 'Rua Gustavo Lessmann', '1350', 'casa', 9, 207.00, 'r', '2025-05-31');

-- --------------------------------------------------------

--
-- Estrutura para tabela `sessions`
--

CREATE TABLE `sessions` (
  `session_id` varchar(255) NOT NULL,
  `session_data` text NOT NULL,
  `session_timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `sessions`
--

INSERT INTO `sessions` (`session_id`, `session_data`, `session_timestamp`) VALUES
('n99ufni50d09e8e1igpqaukuh1', 'usuario_id|i:123;nome_usuario|s:11:\"João Silva\";', '2025-05-02 21:27:37');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(20) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `cpf` varchar(20) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `dataCadastro` date DEFAULT curdate(),
  `nivel_acesso` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `cpf`, `telefone`, `email`, `senha`, `dataCadastro`, `nivel_acesso`) VALUES
(1, 'Adimistrador', '123.456.789-10', '(47) 12345-6789', 'adm@gmail.com', '$2y$10$ompWLChzMvGh7NmDTAMK/eDfRdlJzz7xNcvf/gPqGNHFVcrYuDh4y', '2025-05-09', 2),
(3, 'Mayckon Ricardo', '44444444444', '47944444444', 'mayckon@gmail.com', '123456789', '2025-03-10', 1),
(5, 'Bartolomeu', '11000000000', '49000000000', 'barto@hotmail.com', '$2y$10$bUSxlxPevUwyY1a1aNh/neA1N42lIWimRJ/x/eErFeSzciboEki9y', '2025-04-16', 2),
(7, 'Maria ', '99999999999', '49988888888', 'maria@gmail.com', '$2y$10$zUfzSLPIgcsd9BcbHi0OmerAe.cMYKGi0lZQbjIgrfH6KMN3IfZhG', '2025-04-08', 1),
(8, 'João Mineiro', '01234587965', '47915155151', 'mineiro@hotmail.com', '$2y$10$KL8Jb5p4lBGKbDlMNpTRhOb5urHEBufsREslHxY23QVRJU3IAMGD6', '2025-04-29', 1),
(9, 'Marlon Brando', '98765432109', '47955442233', 'marlon@bol.com', '$2y$10$OKTldXrJMjABsL3Vppy6Bup2LLAM0568X1pNoc4W1s5gOYTtc8zS6', '2025-04-29', 1),
(10, 'carlos', '11111111111', '47911111111', 'tadeu@gmail.com', '$2y$10$..7cBuXrlhJ7f/t5iq5ReOriPmhqpKz9d08s/NKnaQd5Ex4vZyxum', '2025-05-02', 1),
(11, 'Anderson', '00000000077', '47977777777', 'anderson@gmail.com', '$2y$10$WdQSXSEkKZ0chmPF/G0x1OIqz5BdJ/RSX.iT6voxmGd7lKdovpKBm', '2025-05-14', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `vagas`
--

CREATE TABLE `vagas` (
  `id` int(20) NOT NULL,
  `descricao` text NOT NULL,
  `cep` varchar(20) NOT NULL,
  `cidade` varchar(255) NOT NULL,
  `bairro` varchar(255) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `numero` varchar(20) DEFAULT NULL,
  `complemento` varchar(255) DEFAULT NULL,
  `foto_vaga` varchar(255) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `id_uf` int(20) NOT NULL,
  `id_usuario` int(20) NOT NULL,
  `dataCadastro` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `vagas`
--

INSERT INTO `vagas` (`id`, `descricao`, `cep`, `cidade`, `bairro`, `endereco`, `numero`, `complemento`, `foto_vaga`, `preco`, `id_uf`, `id_usuario`, `dataCadastro`) VALUES
(8, 'Aberta', '', 'Jaraguá do Sul', 'Vieira', 'Rua Gustavo Lessmann', '1350', 'casa', 'assets/img/vagas/vaga_683924a8ca1fd0.00058114.jpeg', 23.00, 24, 1, '2025-05-30'),
(9, 'Vaga em prédio residencial.', '', 'Jaraguá do Sul', 'Água Verde', 'Rua Carlos Hardt', '1570', 'Em frente ao Cooper', 'assets/img/vagas/vaga_683cab805e3e12.81594062.jpg', 16.00, 24, 10, '2025-06-01'),
(13, 'Vaga para carro de passeio.', '89251-100', 'Jaraguá do Sul', 'Centro', 'Rua Presidente Epitácio Pessoa', '44', 'Próximo a farmácia BB', 'assets/img/vagas/vaga_683cc85736aae2.59856803.jpg', 12.00, 24, 10, '2025-06-01');

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
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_vaga` (`id_vaga`);

--
-- Índices de tabela `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`session_id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `vagas`
--
ALTER TABLE `vagas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `vagas_ibfk_1` (`id_uf`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `estados`
--
ALTER TABLE `estados`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de tabela `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id_reserva` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `vagas`
--
ALTER TABLE `vagas`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `reservas_ibfk_2` FOREIGN KEY (`id_vaga`) REFERENCES `vagas` (`id`);

--
-- Restrições para tabelas `vagas`
--
ALTER TABLE `vagas`
  ADD CONSTRAINT `vagas_ibfk_1` FOREIGN KEY (`id_uf`) REFERENCES `estados` (`id`),
  ADD CONSTRAINT `vagas_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

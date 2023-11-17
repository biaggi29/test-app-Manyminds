-- phpMyAdmin SQL Dump
-- version 4.3.7
-- http://www.phpmyadmin.net
--
-- Host: mysql02-farm2.uni5.net
-- Tempo de geração: 17/11/2023 às 02:47
-- Versão do servidor: 10.2.36-MariaDB-log
-- Versão do PHP: 5.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de dados: `sql`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `enderecos`
--

CREATE TABLE IF NOT EXISTS `enderecos` (
  `id` bigint(20) unsigned NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `cep` varchar(15) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `pais` varchar(100) DEFAULT NULL,
  `uf` varchar(2) DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `rua` varchar(255) DEFAULT NULL,
  `numero` varchar(10) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Fazendo dump de dados para tabela `enderecos`
--

INSERT INTO `enderecos` (`id`, `id_usuario`, `cep`, `pais`, `uf`, `cidade`, `rua`, `numero`) VALUES
(1, 1, '18915-578', 'Brasil', 'SP', 'Santa Cruz do Rio Pardo', 'Rua João Renofio', '4234234'),
(2, 2, '12345-678', 'Brasil', 'RJ', 'Rio de Janeiro', 'Avenida Principal', '567'),
(3, 3, '12345-678', 'Brasil', 'RJ', 'Rio de Janeiro', 'Avenida Principal', '567'),
(4, 4, '56789-012', 'Brasil', 'MG', 'Belo Horizonte', 'Rua das Flores', '987'),
(7, 7, '18915-578', 'Brasil', 'SP', 'Santa Cruz do Rio Pardo', 'Rua João Renofio', '999');

-- --------------------------------------------------------

--
-- Estrutura para tabela `login_attempts`
--

CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` int(11) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=271 DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `login_attempts`
--

INSERT INTO `login_attempts` (`id`, `ip_address`, `login`, `time`) VALUES
(270, '2804:fec:d203:6300:de49:92d:4726:c2eb', '', '2023-11-17 02:29:43');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedidos`
--

CREATE TABLE IF NOT EXISTS `pedidos` (
  `id` int(11) NOT NULL,
  `id_colaborador` int(11) DEFAULT NULL,
  `valor_total` decimal(10,2) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Fazendo dump de dados para tabela `pedidos`
--

INSERT INTO `pedidos` (`id`, `id_colaborador`, `valor_total`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, '2000.00', 0, '2023-11-17 02:53:22', '2023-11-17 04:01:24'),
(3, 4, '1000.00', 1, '2023-11-17 04:01:48', '2023-11-17 04:12:07'),
(4, 4, '4500.00', 1, '2023-11-17 04:11:39', '2023-11-17 04:11:39'),
(5, 2, '500.00', 0, '2023-11-17 04:14:14', '2023-11-17 04:14:33'),
(6, 2, '500.00', 1, '2023-11-17 05:16:03', '2023-11-17 05:16:03');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedidos_produtos`
--

CREATE TABLE IF NOT EXISTS `pedidos_produtos` (
  `id` int(11) NOT NULL,
  `id_pedido` int(11) DEFAULT NULL,
  `id_produto` int(11) DEFAULT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `preco` decimal(10,2) DEFAULT NULL,
  `id_fornecedor` int(11) DEFAULT NULL,
  `nome_fornecedor` varchar(255) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Fazendo dump de dados para tabela `pedidos_produtos`
--

INSERT INTO `pedidos_produtos` (`id`, `id_pedido`, `id_produto`, `nome`, `preco`, `id_fornecedor`, `nome_fornecedor`, `quantidade`, `observacoes`, `created_at`, `updated_at`) VALUES
(1, 1, 4, 'Produto 2', '500.00', 3, 'Fornecedor Um', 3, 'teste 2', '2023-11-17 02:53:22', '2023-11-17 02:53:22'),
(2, 1, 3, 'Produto 1', '500.00', 3, 'Fornecedor Um', 1, 'teste', '2023-11-17 02:53:22', '2023-11-17 02:53:22'),
(5, 3, 3, 'Produto 1', '500.00', 3, 'Fornecedor Um', 1, 'Teste', '2023-11-17 04:01:48', '2023-11-17 04:01:48'),
(6, 3, 4, 'Produto 2', '500.00', 3, 'Fornecedor Um', 1, '', '2023-11-17 04:01:48', '2023-11-17 04:01:48'),
(7, 4, 3, 'Produto 1', '500.00', 3, 'Fornecedor Um', 1, '', '2023-11-17 04:11:39', '2023-11-17 04:11:39'),
(8, 4, 4, 'Produto 2', '500.00', 3, 'Fornecedor Um', 1, '', '2023-11-17 04:11:39', '2023-11-17 04:11:39'),
(9, 4, 6, 'Produto 4', '100.00', 7, 'Fornecedor Dois', 35, 'teste', '2023-11-17 04:11:39', '2023-11-17 04:11:39'),
(10, 5, 3, 'Produto 1', '500.00', 3, 'Fornecedor Um', 1, '', '2023-11-17 04:14:14', '2023-11-17 04:14:14'),
(11, 6, 3, 'Produto 1', '500.00', 3, 'Fornecedor Um', 1, '', '2023-11-17 05:16:03', '2023-11-17 05:16:03');

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE IF NOT EXISTS `produtos` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `id_fornecedor` int(11) DEFAULT NULL,
  `nome_fornecedor` varchar(255) DEFAULT NULL,
  `preco` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Fazendo dump de dados para tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `status`, `id_fornecedor`, `nome_fornecedor`, `preco`) VALUES
(3, 'Produto 1', '1', 3, 'Terceiro Usuario', '500.00'),
(4, 'Produto 2', '1', 3, 'Terceiro Usuario', '500.00'),
(5, 'Produto 3', '1', 7, 'Teste 6 teste', '200.00'),
(6, 'Produto 4', '1', 3, 'Fornecedor Um', '100.00'),
(7, 'Teste', '1', 3, 'Fornecedor Um', '10.00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `sobrenome` varchar(255) DEFAULT NULL,
  `cpf` varchar(14) DEFAULT NULL,
  `nascimento` date DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `funcao` varchar(100) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Fazendo dump de dados para tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `email`, `senha`, `nome`, `sobrenome`, `cpf`, `nascimento`, `telefone`, `funcao`, `status`) VALUES
(1, 'superadmin@gmail.com', '32250170a0dca92d53ec9624f336ca24', 'Super', 'Admin', '446.766.538-24', '1969-12-31', '423423432432', '1', 1),
(2, 'colaborador1@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'Usuário', 'Dois', '010.816.760-78', '1969-12-31', '987654321', '2', 1),
(3, 'fornecedor1@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'Fornecedor', 'Um', '010.816.760-78', '1969-12-31', '123456789', '3', 1),
(4, 'colaborador2@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'Usuário', 'Dois', '010.816.760-78', '1969-12-31', '987654321', '2', 1),
(7, 'fornecedor2@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'Fornecedor', 'Dois', '906.699.700-18', '1969-12-31', '143443534564', '3', 1);

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `enderecos`
--
ALTER TABLE `enderecos`
  ADD PRIMARY KEY (`id`), ADD KEY `enderecos_ibfk_1` (`id_usuario`);

--
-- Índices de tabela `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `pedidos_produtos`
--
ALTER TABLE `pedidos_produtos`
  ADD PRIMARY KEY (`id`), ADD KEY `id_pedido` (`id_pedido`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `enderecos`
--
ALTER TABLE `enderecos`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de tabela `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=271;
--
-- AUTO_INCREMENT de tabela `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de tabela `pedidos_produtos`
--
ALTER TABLE `pedidos_produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- Restrições para dumps de tabelas
--

--
-- Restrições para tabelas `enderecos`
--
ALTER TABLE `enderecos`
ADD CONSTRAINT `enderecos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Restrições para tabelas `pedidos_produtos`
--
ALTER TABLE `pedidos_produtos`
ADD CONSTRAINT `pedidos_produtos_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

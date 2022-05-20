-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2022 at 09:32 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `delivery`
--

-- --------------------------------------------------------

--
-- Table structure for table `bairros`
--

CREATE TABLE `bairros` (
  `id` int(5) UNSIGNED NOT NULL,
  `nome` varchar(128) NOT NULL,
  `slug` varchar(128) NOT NULL,
  `cidade` varchar(20) NOT NULL DEFAULT 'Juazeiro do Norte',
  `valor_entrega` decimal(10,2) NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `criado_em` datetime DEFAULT NULL,
  `atualizado_em` datetime DEFAULT NULL,
  `deletado_em` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bairros`
--

INSERT INTO `bairros` (`id`, `nome`, `slug`, `cidade`, `valor_entrega`, `ativo`, `criado_em`, `atualizado_em`, `deletado_em`) VALUES
(1, 'Santa Tereza', 'santa-tereza', 'Juazeiro do Norte', '5.00', 1, '2022-05-16 15:38:31', '2022-05-16 15:38:31', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categorias`
--

CREATE TABLE `categorias` (
  `id` int(5) UNSIGNED NOT NULL,
  `nome` varchar(128) NOT NULL,
  `slug` varchar(128) NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `criado_em` datetime DEFAULT NULL,
  `atualizado_em` datetime DEFAULT NULL,
  `deletado_em` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categorias`
--

INSERT INTO `categorias` (`id`, `nome`, `slug`, `ativo`, `criado_em`, `atualizado_em`, `deletado_em`) VALUES
(1, 'Pizza Salgada', 'pizza-salgada', 1, '2022-05-09 16:51:58', '2022-05-09 16:51:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `entregadores`
--

CREATE TABLE `entregadores` (
  `id` int(5) UNSIGNED NOT NULL,
  `nome` varchar(128) NOT NULL,
  `cpf` varchar(20) NOT NULL,
  `cnh` varchar(20) NOT NULL,
  `email` varchar(128) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `endereco` varchar(240) NOT NULL,
  `imagem` varchar(240) DEFAULT NULL,
  `veiculo` varchar(240) NOT NULL,
  `placa` varchar(20) NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `criado_em` datetime DEFAULT NULL,
  `atualizado_em` datetime DEFAULT NULL,
  `deletado_em` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `entregadores`
--

INSERT INTO `entregadores` (`id`, `nome`, `cpf`, `cnh`, `email`, `telefone`, `endereco`, `imagem`, `veiculo`, `placa`, `ativo`, `criado_em`, `atualizado_em`, `deletado_em`) VALUES
(1, 'Motoqueiro Fantasma', '822.940.930-70', '83921817934', 'moto@gmail.com', '(88) 88989-8988', 'Rua das almas, 666 - Inferno - 66666-666', '1652294712_c4a8c82f02498c5a5cf2.jfif', 'Moto Honda Titan 150 - 2000', 'HWH-2528', 1, '2022-05-10 18:41:16', '2022-05-11 15:45:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `expediente`
--

CREATE TABLE `expediente` (
  `id` int(5) UNSIGNED NOT NULL,
  `dia` int(5) NOT NULL,
  `dia_descricao` varchar(50) NOT NULL,
  `abertura` time DEFAULT NULL,
  `fechamento` time DEFAULT NULL,
  `situacao` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `expediente`
--

INSERT INTO `expediente` (`id`, `dia`, `dia_descricao`, `abertura`, `fechamento`, `situacao`) VALUES
(1, 0, 'Domingo', '18:00:00', '23:00:00', 1),
(2, 1, 'Segunda', '18:00:00', '23:00:00', 1),
(3, 2, 'Terça', '18:00:00', '23:00:00', 1),
(4, 3, 'Quarta', '18:00:00', '23:00:00', 1),
(5, 4, 'Quinta', '08:00:00', '23:00:00', 1),
(6, 5, 'Sexta', '18:00:00', '23:00:00', 1),
(7, 6, 'Sábado', '18:00:00', '23:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `extras`
--

CREATE TABLE `extras` (
  `id` int(5) UNSIGNED NOT NULL,
  `nome` varchar(128) NOT NULL,
  `slug` varchar(128) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `descricao` text NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `criado_em` datetime DEFAULT NULL,
  `atualizado_em` datetime DEFAULT NULL,
  `deletado_em` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `extras`
--

INSERT INTO `extras` (`id`, `nome`, `slug`, `preco`, `descricao`, `ativo`, `criado_em`, `atualizado_em`, `deletado_em`) VALUES
(1, 'Catupiry', 'catupiry', '2.00', '', 1, '2022-05-16 08:32:14', '2022-05-16 08:32:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `formas_pagamento`
--

CREATE TABLE `formas_pagamento` (
  `id` int(5) UNSIGNED NOT NULL,
  `nome` varchar(128) NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `criado_em` datetime DEFAULT NULL,
  `atualizado_em` datetime DEFAULT NULL,
  `deletado_em` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `formas_pagamento`
--

INSERT INTO `formas_pagamento` (`id`, `nome`, `ativo`, `criado_em`, `atualizado_em`, `deletado_em`) VALUES
(1, 'Dinheiro', 1, '2022-05-10 09:03:04', '2022-05-10 09:03:04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `medidas`
--

CREATE TABLE `medidas` (
  `id` int(5) UNSIGNED NOT NULL,
  `nome` varchar(128) NOT NULL,
  `descricao` text NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `criado_em` datetime DEFAULT NULL,
  `atualizado_em` datetime DEFAULT NULL,
  `deletado_em` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `medidas`
--

INSERT INTO `medidas` (`id`, `nome`, `descricao`, `ativo`, `criado_em`, `atualizado_em`, `deletado_em`) VALUES
(1, 'Pequena', '4 Pedaços', 1, '2022-05-12 08:46:05', '2022-05-13 14:01:52', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2022-05-02-225705', 'App\\Database\\Migrations\\CriaTabelaUsuarios', 'default', 'App', 1652117796, 1),
(2, '2022-05-08-043800', 'App\\Database\\Migrations\\CriaTabelaCategorias', 'default', 'App', 1652117796, 1),
(3, '2022-05-08-063230', 'App\\Database\\Migrations\\CriaTabelaExtras', 'default', 'App', 1652117796, 1),
(4, '2022-05-08-075413', 'App\\Database\\Migrations\\CriaTabelaMedidas', 'default', 'App', 1652117796, 1),
(5, '2022-05-08-181317', 'App\\Database\\Migrations\\CriaTabelaProdutos', 'default', 'App', 1652117796, 1),
(6, '2022-05-09-035558', 'App\\Database\\Migrations\\CriaTabelaProdutosExtras', 'default', 'App', 1652117796, 1),
(7, '2022-05-09-222536', 'App\\Database\\Migrations\\CriaTabelaProdutosEspecificacoes', 'default', 'App', 1652184181, 2),
(8, '2022-05-10-024109', 'App\\Database\\Migrations\\CriaTabelaFormasPagamento', 'default', 'App', 1652184181, 2),
(10, '2022-05-10-124616', 'App\\Database\\Migrations\\CriaTabelaEntregadores', 'default', 'App', 1652200865, 3),
(11, '2022-05-11-014349', 'App\\Database\\Migrations\\CriaTabelaBairros', 'default', 'App', 1652268020, 4),
(12, '2022-05-11-051539', 'App\\Database\\Migrations\\CriaTabelaExpediente', 'default', 'App', 1652268020, 4),
(13, '2022-05-18-030159', 'App\\Database\\Migrations\\CriaTabelaPedidos', 'default', 'App', 1652874189, 5),
(14, '2022-05-19-235041', 'App\\Database\\Migrations\\CriaTabelaPedidosProdutos', 'default', 'App', 1653045906, 6);

-- --------------------------------------------------------

--
-- Table structure for table `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(5) UNSIGNED NOT NULL,
  `usuario_id` int(5) UNSIGNED NOT NULL,
  `entregador_id` int(5) UNSIGNED DEFAULT NULL,
  `codigo` varchar(10) NOT NULL,
  `forma_pagamento` varchar(50) NOT NULL,
  `situacao` tinyint(1) NOT NULL DEFAULT 0,
  `produtos` text NOT NULL,
  `valor_produtos` decimal(10,2) NOT NULL,
  `valor_entrega` decimal(10,2) NOT NULL,
  `valor_pedido` decimal(10,2) NOT NULL,
  `endereco_entrega` varchar(255) NOT NULL,
  `observacoes` varchar(255) NOT NULL,
  `criado_em` datetime DEFAULT NULL,
  `atualizado_em` datetime DEFAULT NULL,
  `deletado_em` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pedidos`
--

INSERT INTO `pedidos` (`id`, `usuario_id`, `entregador_id`, `codigo`, `forma_pagamento`, `situacao`, `produtos`, `valor_produtos`, `valor_entrega`, `valor_pedido`, `endereco_entrega`, `observacoes`, `criado_em`, `atualizado_em`, `deletado_em`) VALUES
(1, 2, NULL, '25098741', 'Dinheiro', 0, 'a:2:{i:0;a:6:{s:2:\"id\";s:1:\"2\";s:4:\"nome\";s:23:\"Pizza de bacon Pequena \";s:4:\"slug\";s:22:\"pizza-de-bacon-pequena\";s:5:\"preco\";s:5:\"25.00\";s:10:\"quantidade\";i:1;s:7:\"tamanho\";s:7:\"Pequena\";}i:1;a:6:{s:2:\"id\";s:1:\"1\";s:4:\"nome\";s:27:\"Pizza de calabresa Pequena \";s:4:\"slug\";s:26:\"pizza-de-calabresa-pequena\";s:5:\"preco\";s:5:\"25.00\";s:10:\"quantidade\";i:1;s:7:\"tamanho\";s:7:\"Pequena\";}}', '50.00', '5.00', '55.00', 'Santa Tereza - Juazeiro do Norte - Rua Duque de Caxias - CEP: 63050-460 - CE - R$ 5.00 - Número: 39', 'Ponto de referência: Arena Romeirão - Número: 39 - Você informou que não precisa de troco.', '2022-05-19 09:37:17', '2022-05-19 09:37:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pedidos_produtos`
--

CREATE TABLE `pedidos_produtos` (
  `id` int(5) UNSIGNED NOT NULL,
  `pedido_id` int(5) UNSIGNED NOT NULL,
  `produto` varchar(128) NOT NULL,
  `quantidade` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `produtos`
--

CREATE TABLE `produtos` (
  `id` int(5) UNSIGNED NOT NULL,
  `categoria_id` int(5) UNSIGNED NOT NULL,
  `nome` varchar(128) NOT NULL,
  `slug` varchar(128) NOT NULL,
  `ingredientes` text NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `imagem` varchar(200) NOT NULL,
  `criado_em` datetime DEFAULT NULL,
  `atualizado_em` datetime DEFAULT NULL,
  `deletado_em` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `produtos`
--

INSERT INTO `produtos` (`id`, `categoria_id`, `nome`, `slug`, `ingredientes`, `ativo`, `imagem`, `criado_em`, `atualizado_em`, `deletado_em`) VALUES
(1, 1, 'Pizza de calabresa', 'pizza-de-calabresa', 'Calabresa show', 1, '1652445869_6ae404761d0a3f59fdb1.jpg', '2022-05-09 17:07:22', '2022-05-13 09:44:29', NULL),
(2, 1, 'Pizza de bacon', 'pizza-de-bacon', 'Baconzitos', 1, '1652700632_3047adb82e800c4429b9.jfif', '2022-05-16 08:30:04', '2022-05-16 08:30:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `produtos_especificacoes`
--

CREATE TABLE `produtos_especificacoes` (
  `id` int(5) UNSIGNED NOT NULL,
  `produto_id` int(5) UNSIGNED NOT NULL,
  `medida_id` int(5) UNSIGNED NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `customizavel` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `produtos_especificacoes`
--

INSERT INTO `produtos_especificacoes` (`id`, `produto_id`, `medida_id`, `preco`, `customizavel`) VALUES
(1, 1, 1, '25.00', 1),
(2, 2, 1, '25.00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `produtos_extras`
--

CREATE TABLE `produtos_extras` (
  `id` int(5) UNSIGNED NOT NULL,
  `produto_id` int(5) UNSIGNED NOT NULL,
  `extra_id` int(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `produtos_extras`
--

INSERT INTO `produtos_extras` (`id`, `produto_id`, `extra_id`) VALUES
(1, 1, 1),
(2, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(5) UNSIGNED NOT NULL,
  `nome` varchar(128) NOT NULL,
  `email` varchar(255) NOT NULL,
  `cpf` varchar(20) DEFAULT NULL,
  `telefone` varchar(20) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `ativo` tinyint(1) NOT NULL DEFAULT 0,
  `password_hash` varchar(255) NOT NULL,
  `ativacao_hash` varchar(64) DEFAULT NULL,
  `reset_hash` varchar(64) DEFAULT NULL,
  `reset_expira_em` datetime DEFAULT NULL,
  `criado_em` datetime DEFAULT NULL,
  `atualizado_em` datetime DEFAULT NULL,
  `deletado_em` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `cpf`, `telefone`, `is_admin`, `ativo`, `password_hash`, `ativacao_hash`, `reset_hash`, `reset_expira_em`, `criado_em`, `atualizado_em`, `deletado_em`) VALUES
(1, 'Ademiro', 'admin@admin.com', '822.940.930-70', '(88) 88989-8989', 1, 1, '$2y$10$EeqWlO.p1EyFpEOdV.6MquZse9MMI1wbRLeuD4q3Y63LtX36R0CZa', NULL, NULL, NULL, '2022-05-09 14:50:09', '2022-05-09 14:50:09', NULL),
(2, 'Leon', 'leandrobruto42@gmail.com', '629.954.360-47', '(34) 23434-2342', 0, 1, '$2y$10$eYrnIr9RS9bdiIm.pqKFEuiCo62FwOutxE896SWWMKb69IPTxjlmK', NULL, NULL, NULL, '2022-05-19 09:33:26', '2022-05-19 09:33:26', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bairros`
--
ALTER TABLE `bairros`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Indexes for table `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Indexes for table `entregadores`
--
ALTER TABLE `entregadores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD UNIQUE KEY `cnh` (`cnh`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `telefone` (`telefone`);

--
-- Indexes for table `expediente`
--
ALTER TABLE `expediente`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `extras`
--
ALTER TABLE `extras`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Indexes for table `formas_pagamento`
--
ALTER TABLE `formas_pagamento`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Indexes for table `medidas`
--
ALTER TABLE `medidas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedidos_usuario_id_foreign` (`usuario_id`),
  ADD KEY `pedidos_entregador_id_foreign` (`entregador_id`);

--
-- Indexes for table `pedidos_produtos`
--
ALTER TABLE `pedidos_produtos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedidos_produtos_pedido_id_foreign` (`pedido_id`);

--
-- Indexes for table `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`),
  ADD KEY `produtos_categoria_id_foreign` (`categoria_id`);

--
-- Indexes for table `produtos_especificacoes`
--
ALTER TABLE `produtos_especificacoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produtos_especificacoes_produto_id_foreign` (`produto_id`),
  ADD KEY `produtos_especificacoes_medida_id_foreign` (`medida_id`);

--
-- Indexes for table `produtos_extras`
--
ALTER TABLE `produtos_extras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produtos_extras_produto_id_foreign` (`produto_id`),
  ADD KEY `produtos_extras_extra_id_foreign` (`extra_id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD UNIQUE KEY `ativacao_hash` (`ativacao_hash`),
  ADD UNIQUE KEY `reset_hash` (`reset_hash`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bairros`
--
ALTER TABLE `bairros`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `entregadores`
--
ALTER TABLE `entregadores`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `expediente`
--
ALTER TABLE `expediente`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `extras`
--
ALTER TABLE `extras`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `formas_pagamento`
--
ALTER TABLE `formas_pagamento`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `medidas`
--
ALTER TABLE `medidas`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pedidos_produtos`
--
ALTER TABLE `pedidos_produtos`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `produtos_especificacoes`
--
ALTER TABLE `produtos_especificacoes`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `produtos_extras`
--
ALTER TABLE `produtos_extras`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_entregador_id_foreign` FOREIGN KEY (`entregador_id`) REFERENCES `entregadores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pedidos_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pedidos_produtos`
--
ALTER TABLE `pedidos_produtos`
  ADD CONSTRAINT `pedidos_produtos_pedido_id_foreign` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `produtos_categoria_id_foreign` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`);

--
-- Constraints for table `produtos_especificacoes`
--
ALTER TABLE `produtos_especificacoes`
  ADD CONSTRAINT `produtos_especificacoes_medida_id_foreign` FOREIGN KEY (`medida_id`) REFERENCES `medidas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `produtos_especificacoes_produto_id_foreign` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `produtos_extras`
--
ALTER TABLE `produtos_extras`
  ADD CONSTRAINT `produtos_extras_extra_id_foreign` FOREIGN KEY (`extra_id`) REFERENCES `extras` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `produtos_extras_produto_id_foreign` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

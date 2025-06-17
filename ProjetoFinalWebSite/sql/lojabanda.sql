-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 17-Abr-2025 às 20:24
-- Versão do servidor: 8.0.17
-- versão do PHP: 8.2.12
CREATE DATABASE IF NOT EXISTS lojabanda;
USE lojabanda;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `lojabanda`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `encomendas`
--

CREATE TABLE `encomendas` (
  `id` int(11) NOT NULL,
  `nome` varchar(45) DEFAULT NULL,
  `username` varchar(45) NOT NULL,
  `datanascimento` date DEFAULT NULL,
  `morada` varchar(100) DEFAULT NULL,
  `produtos` varchar(1000) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `total` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `encomendas`
--

INSERT INTO `encomendas` (`id`, `nome`, `username`, `datanascimento`, `morada`, `produtos`, `quantidade`, `total`) VALUES
(11, 'augusto', 'augusto', '1995-05-26', 'rua forno', 'Produto C (Quantidade: 3)', NULL, 14.97);

-- --------------------------------------------------------

--
-- Estrutura da tabela `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `names` varchar(100) DEFAULT NULL,
  `quant` int(11) DEFAULT NULL,
  `cost` float DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `products`
--

INSERT INTO `products` (`id`, `names`, `quant`, `cost`, `description`) VALUES
(1, 'T-Shirt', 3, 29.99, 'Camisa T-Shirt'),
(2, 'CD', 4, 9.99, 'CD da Banda'),
(3, 'Souvenirs', 64, 4.99, 'Chaveiro'),
(4, 'Gifts', 15, 3.99, NULL),
(5, 'tshirt2', 11, 25.99, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `utilizadores`
--

CREATE TABLE `utilizadores` (
  `id` int(11) NOT NULL,
  `nome` varchar(45) DEFAULT NULL,
  `apelido` varchar(45) DEFAULT NULL,
  `username` varchar(45) DEFAULT NULL,
  `passe` varchar(300) DEFAULT NULL,
  `permissao` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `utilizadores`
--

INSERT INTO `utilizadores` (`id`, `nome`, `apelido`, `username`, `passe`, `permissao`) VALUES
(1, 'adm', 'adm', 'adm', '123', 'adm'),
(19, 'augusto', 'augusto', 'augusto', '$2y$10$KGZbzY.l/qtK8X..IwrcyO24O2h4FZibHK.CcdeyQmUsTDZOmEp6e', NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `encomendas`
--
ALTER TABLE `encomendas`
  ADD PRIMARY KEY (`id`,`username`);

--
-- Índices para tabela `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD UNIQUE KEY `name_UNIQUE` (`names`);

--
-- Índices para tabela `utilizadores`
--
ALTER TABLE `utilizadores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username_UNIQUE` (`username`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `encomendas`
--
ALTER TABLE `encomendas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `utilizadores`
--
ALTER TABLE `utilizadores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

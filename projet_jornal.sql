-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 05-Mar-2024 às 20:17
-- Versão do servidor: 10.4.27-MariaDB
-- versão do PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `projet_jornal`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `cadastre-se`
--

CREATE TABLE `cadastre-se` (
  `pk_id` int(11) NOT NULL,
  `e_mail` varchar(220) NOT NULL,
  `cpf` varchar(15) NOT NULL,
  `senha` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cinema`
--

CREATE TABLE `cinema` (
  `pk_id` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `sinopse` varchar(300) NOT NULL,
  `elenco` varchar(50) NOT NULL,
  `imagem` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `clientes`
--

CREATE TABLE `clientes` (
  `pk_id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cpf` varchar(15) NOT NULL,
  `whatsapp` varchar(20) NOT NULL,
  `email` varchar(220) NOT NULL,
  `senha` varchar(80) NOT NULL,
  `token` varchar(12) NOT NULL,
  `habilita` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `clientes`
--

INSERT INTO `clientes` (`pk_id`, `nome`, `cpf`, `whatsapp`, `email`, `senha`, `token`, `habilita`) VALUES
(1, 'Samuel', '222225678912', '341242344234', 'teste@gmail.com', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', '', 1),
(3, 'douvlis', '12345678912', '12996568721', 'testando@gmail.com', '173af653133d964edfc16cafe0aba33c8f500a07f3ba3f81943916910c257705', '', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `destaque_home`
--

CREATE TABLE `destaque_home` (
  `pk_id` int(11) NOT NULL,
  `fk_noticia` int(11) NOT NULL,
  `fk_redacao` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `generos`
--

CREATE TABLE `generos` (
  `pk_id` int(11) NOT NULL,
  `tipo_genero` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `noticia`
--

CREATE TABLE `noticia` (
  `pk_id` int(11) NOT NULL,
  `palavra_chave` varchar(200) NOT NULL,
  `texto` text NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `sub_titulo` varchar(300) NOT NULL,
  `data_postagem` datetime DEFAULT NULL,
  `imagem` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `noticia`
--

INSERT INTO `noticia` (`pk_id`, `palavra_chave`, `texto`, `titulo`, `sub_titulo`, `data_postagem`, `imagem`) VALUES
(1, 'Teste, Testando, Testar', 'Testando algo que ainda não foi implementado na face da terra!', 'Teste', 'Teste', '2024-03-01 16:55:47', 'assets/img/noticia/Qpnj1tzb-480x480-480x480.webp');

-- --------------------------------------------------------

--
-- Estrutura da tabela `redacao`
--

CREATE TABLE `redacao` (
  `pk_id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `salario` float NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `cpf` char(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `revisor`
--

CREATE TABLE `revisor` (
  `pk_id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `salario` float NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `cpf` char(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `token`
--

CREATE TABLE `token` (
  `pk_id` int(11) NOT NULL,
  `email` varchar(150) NOT NULL,
  `cpf` varchar(15) NOT NULL,
  `token` varchar(12) NOT NULL,
  `data_criacao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `token`
--

INSERT INTO `token` (`pk_id`, `email`, `cpf`, `token`, `data_criacao`) VALUES
(1, 'Da@gmail.com', '12012316578', 'f6a95880e88e', '2024-02-08 13:56:21'),
(6, 'bashsaudhasudh@gmail.com', '42432423432423', '4e692ca25aba', '2024-02-08 14:22:51');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `pk_id` int(11) NOT NULL,
  `e_mail` varchar(220) NOT NULL,
  `senha` varchar(80) NOT NULL,
  `habilita` smallint(6) NOT NULL,
  `recuperar_senha` varchar(30) NOT NULL,
  `cargo` varchar(80) NOT NULL,
  `cpf` varchar(15) NOT NULL,
  `codigo` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`pk_id`, `e_mail`, `senha`, `habilita`, `recuperar_senha`, `cargo`, `cpf`, `codigo`) VALUES
(2, 'costasamuca8@gmail.com', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 1, '', 'ADM', '', 'a90a9d'),
(21, 'teste@gmail.com', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 1, '', 'FUNCIONARIO', '', '8119ed'),
(22, 'sdfsdfdfsd@gmail.com', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 1, '', 'REDACAO', '', ''),
(23, 'samuel@gmail.com', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 1, '', 'REVISOR', '', '');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `cadastre-se`
--
ALTER TABLE `cadastre-se`
  ADD PRIMARY KEY (`pk_id`);

--
-- Índices para tabela `cinema`
--
ALTER TABLE `cinema`
  ADD PRIMARY KEY (`pk_id`);

--
-- Índices para tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`pk_id`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices para tabela `destaque_home`
--
ALTER TABLE `destaque_home`
  ADD PRIMARY KEY (`pk_id`);

--
-- Índices para tabela `generos`
--
ALTER TABLE `generos`
  ADD PRIMARY KEY (`pk_id`);

--
-- Índices para tabela `noticia`
--
ALTER TABLE `noticia`
  ADD PRIMARY KEY (`pk_id`);

--
-- Índices para tabela `redacao`
--
ALTER TABLE `redacao`
  ADD PRIMARY KEY (`pk_id`);

--
-- Índices para tabela `revisor`
--
ALTER TABLE `revisor`
  ADD PRIMARY KEY (`pk_id`);

--
-- Índices para tabela `token`
--
ALTER TABLE `token`
  ADD PRIMARY KEY (`pk_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD UNIQUE KEY `token` (`token`),
  ADD UNIQUE KEY `email_2` (`email`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`pk_id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `cadastre-se`
--
ALTER TABLE `cadastre-se`
  MODIFY `pk_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `cinema`
--
ALTER TABLE `cinema`
  MODIFY `pk_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `pk_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `destaque_home`
--
ALTER TABLE `destaque_home`
  MODIFY `pk_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `generos`
--
ALTER TABLE `generos`
  MODIFY `pk_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `noticia`
--
ALTER TABLE `noticia`
  MODIFY `pk_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `redacao`
--
ALTER TABLE `redacao`
  MODIFY `pk_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `revisor`
--
ALTER TABLE `revisor`
  MODIFY `pk_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `token`
--
ALTER TABLE `token`
  MODIFY `pk_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `pk_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

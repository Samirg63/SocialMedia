-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 16/01/2024 às 14:24
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `socialmedia2`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_admin.likes`
--

CREATE TABLE `tb_admin.likes` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_post` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_admin.usuarios`
--

CREATE TABLE `tb_admin.usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `nascimento` varchar(255) NOT NULL,
  `genero` varchar(255) NOT NULL,
  `user` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `bio` varchar(255) NOT NULL,
  `localizacao` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_admin.usuarios`
--

INSERT INTO `tb_admin.usuarios` (`id`, `nome`, `nascimento`, `genero`, `user`, `login`, `senha`, `img`, `bio`, `localizacao`) VALUES
(2, 'samir gomes de sá', '22/02/2006', 'M', 'samirg_sa', 'samir-gomes13@hotmail.com', '22022006sa', '659f05db06df2.jpeg', 'To tranquilão, to numa boa to curtindo o batidão', ''),
(8, 'Giovana', '20/12/2020', 'F', 'Gih', '82999250507', 'gih123', '659f08488210a.jpeg', 'Bio aleatória de qualé qualé de caô', ''),
(9, 'Jorge', '10/05/1995', 'M', 'Jorge25', 'jorge@hotmail.com', 'jorge123', '', '', '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_site.comments`
--

CREATE TABLE `tb_site.comments` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_site.notificacoes`
--

CREATE TABLE `tb_site.notificacoes` (
  `id` int(11) NOT NULL,
  `id_from` int(11) NOT NULL,
  `id_to` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
  `view` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_site.notificacoes`
--

INSERT INTO `tb_site.notificacoes` (`id`, `id_from`, `id_to`, `action`, `view`) VALUES
(15, 8, 2, 'amizadeAceita', 1),
(16, 2, 8, 'amizadeAceita', 1),
(17, 8, 9, 'amizade', 0),
(18, 8, 9, 'amizade', 0),
(19, 8, 9, 'amizade', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_site.posts`
--

CREATE TABLE `tb_site.posts` (
  `id` int(11) NOT NULL,
  `images` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `data` varchar(255) NOT NULL,
  `likes` int(11) NOT NULL,
  `comments` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_site.posts`
--

INSERT INTO `tb_site.posts` (`id`, `images`, `content`, `data`, `likes`, `comments`, `id_user`) VALUES
(4, '65a5476181c35.jpeg<-!->65a5476181f45.jpeg', 'Pega essa bomba', '15/01/2024', 0, 0, 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_site.solicitacoes`
--

CREATE TABLE `tb_site.solicitacoes` (
  `id` int(11) NOT NULL,
  `id_from` int(11) NOT NULL,
  `id_to` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_site.solicitacoes`
--

INSERT INTO `tb_site.solicitacoes` (`id`, `id_from`, `id_to`, `status`) VALUES
(10, 8, 2, 1),
(13, 8, 9, 0);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `tb_admin.likes`
--
ALTER TABLE `tb_admin.likes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tb_admin.usuarios`
--
ALTER TABLE `tb_admin.usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tb_site.comments`
--
ALTER TABLE `tb_site.comments`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tb_site.notificacoes`
--
ALTER TABLE `tb_site.notificacoes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tb_site.posts`
--
ALTER TABLE `tb_site.posts`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tb_site.solicitacoes`
--
ALTER TABLE `tb_site.solicitacoes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tb_admin.likes`
--
ALTER TABLE `tb_admin.likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `tb_admin.usuarios`
--
ALTER TABLE `tb_admin.usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `tb_site.comments`
--
ALTER TABLE `tb_site.comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `tb_site.notificacoes`
--
ALTER TABLE `tb_site.notificacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de tabela `tb_site.posts`
--
ALTER TABLE `tb_site.posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `tb_site.solicitacoes`
--
ALTER TABLE `tb_site.solicitacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

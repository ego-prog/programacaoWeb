-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 27-Maio-2022 às 15:32
-- Versão do servidor: 10.4.22-MariaDB
-- versão do PHP: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `fatec`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoriaprodutos`
--

CREATE TABLE `categoriaprodutos` (
  `id` int(11) NOT NULL,
  `descricao` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria_produto`
--

CREATE TABLE `categoria_produto` (
  `id` int(11) NOT NULL,
  `nome` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `categoria_produto`
--

INSERT INTO `categoria_produto` (`id`, `nome`) VALUES
(1, 'Bebida Gelada'),
(2, 'Bebida Quente'),
(3, 'Salgado'),
(4, 'Lanche');

-- --------------------------------------------------------

--
-- Estrutura da tabela `emprestimo`
--

CREATE TABLE `emprestimo` (
  `id` int(11) NOT NULL,
  `usuario` varchar(35) NOT NULL,
  `tombo` varchar(11) NOT NULL,
  `data_emprestimo` date NOT NULL,
  `data_devolucao` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `emprestimo`
--

INSERT INTO `emprestimo` (`id`, `usuario`, `tombo`, `data_emprestimo`, `data_devolucao`) VALUES
(1, 'teste', 'teste', '2022-05-16', '0000-00-00'),
(2, 'JosÃ©', '8575225340', '2022-05-20', '2022-05-21');

-- --------------------------------------------------------

--
-- Estrutura da tabela `livros`
--

CREATE TABLE `livros` (
  `autor` varchar(20) DEFAULT NULL,
  `titulo` varchar(40) DEFAULT NULL,
  `area` varchar(16) DEFAULT NULL,
  `ano` smallint(6) DEFAULT NULL,
  `tombo` char(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `livros`
--

INSERT INTO `livros` (`autor`, `titulo`, `area`, `ano`, `tombo`) VALUES
('Maria Margarida', 'PHP', 'Programacao', 2017, '1234567890'),
('Juliano Niederauer', 'Desenvolvendo Websites com PHP: Aprenda ', 'Web', 2016, '8575225340'),
('Catarina Bertonha', 'MySQL', 'Programacao', 2016, '1234567893');

-- --------------------------------------------------------

--
-- Estrutura da tabela `privilegio`
--

CREATE TABLE `privilegio` (
  `codigo` int(11) NOT NULL,
  `descricao` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `privilegio`
--

INSERT INTO `privilegio` (`codigo`, `descricao`) VALUES
(0, 'Administrador'),
(1, 'Administrador'),
(2, 'caixa'),
(3, 'Gerente');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto`
--

CREATE TABLE `produto` (
  `id` int(11) NOT NULL,
  `nome` varchar(20) NOT NULL,
  `valor` float NOT NULL,
  `categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `produto`
--

INSERT INTO `produto` (`id`, `nome`, `valor`, `categoria`) VALUES
(1, 'Coca', 10, 1),
(2, 'CafÃ©', 5, 2),
(3, 'Coxinha', 5, 3),
(5, 'Sanduba', 25, 3),
(7, 'Ãgua', 3, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `login` varchar(15) NOT NULL,
  `senha` varchar(15) NOT NULL,
  `nivel` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`login`, `senha`, `nivel`) VALUES
('admin', '123', 1),
('anv', 'f@tek', 2),
('ego', '123', 3);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `categoriaprodutos`
--
ALTER TABLE `categoriaprodutos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `categoria_produto`
--
ALTER TABLE `categoria_produto`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `emprestimo`
--
ALTER TABLE `emprestimo`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `livros`
--
ALTER TABLE `livros`
  ADD KEY `autor` (`autor`),
  ADD KEY `titulo` (`titulo`(20)),
  ADD KEY `area` (`area`(4)),
  ADD KEY `ano` (`ano`);

--
-- Índices para tabela `privilegio`
--
ALTER TABLE `privilegio`
  ADD PRIMARY KEY (`codigo`);

--
-- Índices para tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoria` (`categoria`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`login`),
  ADD KEY `nivel` (`nivel`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categoria_produto`
--
ALTER TABLE `categoria_produto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `emprestimo`
--
ALTER TABLE `emprestimo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `produto`
--
ALTER TABLE `produto`
  ADD CONSTRAINT `produto_ibfk_1` FOREIGN KEY (`categoria`) REFERENCES `categoria_produto` (`id`);

--
-- Limitadores para a tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`nivel`) REFERENCES `privilegio` (`codigo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 01-Jul-2019 às 05:16
-- Versão do servidor: 10.1.32-MariaDB
-- PHP Version: 7.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kanoah`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `modulo`
--

CREATE TABLE `modulo` (
  `id` int(10) NOT NULL,
  `modulo` varchar(12) COLLATE latin1_bin NOT NULL,
  `numero` int(2) NOT NULL,
  `nome` varchar(50) COLLATE latin1_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

--
-- Extraindo dados da tabela `modulo`
--

INSERT INTO `modulo` (`id`, `modulo`, `numero`, `nome`) VALUES
(1, 'SIGAFIN', 6, 'Financeiro');

-- --------------------------------------------------------

--
-- Estrutura da tabela `modulo_parametro`
--

CREATE TABLE `modulo_parametro` (
  `id` int(10) NOT NULL,
  `idmodulo` int(10) NOT NULL,
  `idparametro` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `modulo_rotina`
--

CREATE TABLE `modulo_rotina` (
  `id` int(10) NOT NULL,
  `idmodulo` int(10) NOT NULL,
  `idrotina` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `rotina`
--

CREATE TABLE `rotina` (
  `id` int(10) NOT NULL,
  `rotina` varchar(10) COLLATE latin1_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `rotina_parametro`
--

CREATE TABLE `rotina_parametro` (
  `id` int(10) NOT NULL,
  `idrotina` int(10) NOT NULL,
  `idparametro` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `rotina_tabela`
--

CREATE TABLE `rotina_tabela` (
  `id` int(10) NOT NULL,
  `idrotina` int(10) NOT NULL,
  `idtabela` int(10) NOT NULL,
  `idtipo` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tabela`
--

CREATE TABLE `tabela` (
  `id` int(10) NOT NULL,
  `tabela` varchar(6) COLLATE latin1_bin NOT NULL,
  `nome` varchar(50) COLLATE latin1_bin NOT NULL,
  `query` text COLLATE latin1_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tabela_relacao`
--

CREATE TABLE `tabela_relacao` (
  `id` int(10) NOT NULL,
  `idtabela` int(10) NOT NULL,
  `idrelacao` int(10) NOT NULL,
  `campo` varchar(10) COLLATE latin1_bin NOT NULL,
  `camporel` varchar(10) COLLATE latin1_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `modulo`
--
ALTER TABLE `modulo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero` (`numero`);

--
-- Indexes for table `modulo_parametro`
--
ALTER TABLE `modulo_parametro`
  ADD PRIMARY KEY (`id`),
  ADD KEY `modulo_parametro_fk_modulo` (`idmodulo`) USING BTREE;

--
-- Indexes for table `modulo_rotina`
--
ALTER TABLE `modulo_rotina`
  ADD PRIMARY KEY (`id`),
  ADD KEY `modulo_rotina_fk_modulo` (`idmodulo`),
  ADD KEY `modulo_rotina_fk_rotina` (`idrotina`);

--
-- Indexes for table `rotina`
--
ALTER TABLE `rotina`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rotina_parametro`
--
ALTER TABLE `rotina_parametro`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rotina_tabela`
--
ALTER TABLE `rotina_tabela`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tabela`
--
ALTER TABLE `tabela`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tabela_relacao`
--
ALTER TABLE `tabela_relacao`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `modulo`
--
ALTER TABLE `modulo`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `modulo_parametro`
--
ALTER TABLE `modulo_parametro`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `modulo_rotina`
--
ALTER TABLE `modulo_rotina`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rotina`
--
ALTER TABLE `rotina`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rotina_parametro`
--
ALTER TABLE `rotina_parametro`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rotina_tabela`
--
ALTER TABLE `rotina_tabela`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tabela`
--
ALTER TABLE `tabela`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tabela_relacao`
--
ALTER TABLE `tabela_relacao`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `modulo_parametro`
--
ALTER TABLE `modulo_parametro`
  ADD CONSTRAINT `fk_modulo` FOREIGN KEY (`idmodulo`) REFERENCES `modulo` (`id`);

--
-- Limitadores para a tabela `modulo_rotina`
--
ALTER TABLE `modulo_rotina`
  ADD CONSTRAINT `modulo_rotina_fk_modulo` FOREIGN KEY (`idmodulo`) REFERENCES `modulo` (`id`),
  ADD CONSTRAINT `modulo_rotina_fk_rotina` FOREIGN KEY (`idrotina`) REFERENCES `rotina` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

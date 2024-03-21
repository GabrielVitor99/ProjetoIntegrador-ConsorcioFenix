-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 05-Dez-2023 às 21:40
-- Versão do servidor: 8.0.31
-- versão do PHP: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `banco_fenix`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `adminn`
--

DROP TABLE IF EXISTS `adminn`;
CREATE TABLE IF NOT EXISTS `adminn` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `cargo_id` int NOT NULL,
  `matricula` int NOT NULL,
  `senha` varchar(255) NOT NULL,
  `data_cadastro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `matricula` (`matricula`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `adminn`
--

INSERT INTO `adminn` (`id`, `nome`, `cargo_id`, `matricula`, `senha`, `data_cadastro`) VALUES
(1, 'Gustavo R.', 2, 4040, '$argon2i$v=19$m=65536,t=4,p=1$QVB5a2U4TFB0QUcuczBSLg$oWhhWmv03ssc/mINbVcnHmC/DrjuA7Co3aMqIIfKd7U', '2023-12-05 21:22:02');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cargos_admin`
--

DROP TABLE IF EXISTS `cargos_admin`;
CREATE TABLE IF NOT EXISTS `cargos_admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cargo` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `cargos_admin`
--

INSERT INTO `cargos_admin` (`id`, `cargo`) VALUES
(1, 'Fiscal'),
(2, 'Supervisor');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cargos_funcionario`
--

DROP TABLE IF EXISTS `cargos_funcionario`;
CREATE TABLE IF NOT EXISTS `cargos_funcionario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cargo` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `cargos_funcionario`
--

INSERT INTO `cargos_funcionario` (`id`, `cargo`) VALUES
(1, 'Motorista'),
(2, 'Cobrador');

-- --------------------------------------------------------

--
-- Estrutura da tabela `escalas`
--

DROP TABLE IF EXISTS `escalas`;
CREATE TABLE IF NOT EXISTS `escalas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `numero_escala` int NOT NULL,
  `veiculo_id` int DEFAULT NULL,
  `motorista_id` int DEFAULT NULL,
  `cobrador_id` int DEFAULT NULL,
  `inicio_jornada` time DEFAULT NULL,
  `tempo_intervalo` time DEFAULT NULL,
  `final_jornada` time DEFAULT NULL,
  `arquivo` blob,
  `data_cadastro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `numero_veiculo` (`veiculo_id`),
  KEY `motorista_id` (`motorista_id`),
  KEY `cobrador_id` (`cobrador_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `escalas`
--

INSERT INTO `escalas` (`id`, `numero_escala`, `veiculo_id`, `motorista_id`, `cobrador_id`, `inicio_jornada`, `tempo_intervalo`, `final_jornada`, `arquivo`, `data_cadastro`) VALUES
(1, 1, 1, 1, 2, '09:00:00', '00:59:00', '05:20:00', 0x737461722d776172732d6261636b67726f756e64732d32395f39653732623833632e706e67, '2023-12-05 21:38:16');

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcionarios`
--

DROP TABLE IF EXISTS `funcionarios`;
CREATE TABLE IF NOT EXISTS `funcionarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `matricula` int NOT NULL,
  `cargo_id` int DEFAULT NULL,
  `telefone` varchar(255) DEFAULT NULL,
  `data_cadastro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `cargo_id` (`cargo_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `funcionarios`
--

INSERT INTO `funcionarios` (`id`, `nome`, `matricula`, `cargo_id`, `telefone`, `data_cadastro`) VALUES
(1, 'Baldasso', 111, 1, '(48) 9000-0001	', '2023-12-05 21:31:33'),
(2, 'Justin', 222, 2, '(48) 5555-5555	', '2023-12-05 21:31:59'),
(3, 'César', 1112, 1, '(48) 9 0000 - 0001', '2023-12-05 21:32:58');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipos_veiculo`
--

DROP TABLE IF EXISTS `tipos_veiculo`;
CREATE TABLE IF NOT EXISTS `tipos_veiculo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tipo` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `tipos_veiculo`
--

INSERT INTO `tipos_veiculo` (`id`, `tipo`) VALUES
(1, 'Padrão'),
(2, 'Executivo'),
(3, 'Articulado');

-- --------------------------------------------------------

--
-- Estrutura da tabela `veiculos`
--

DROP TABLE IF EXISTS `veiculos`;
CREATE TABLE IF NOT EXISTS `veiculos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tipo_id` int DEFAULT NULL,
  `numero` varchar(20) NOT NULL,
  `capacidade` int DEFAULT NULL,
  `data_cadastro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `numero` (`numero`),
  KEY `tipo_id` (`tipo_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `veiculos`
--

INSERT INTO `veiculos` (`id`, `tipo_id`, `numero`, `capacidade`, `data_cadastro`) VALUES
(1, 1, '1509', 124, '2023-12-05 21:29:57');

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `escalas`
--
ALTER TABLE `escalas`
  ADD CONSTRAINT `escalas_ibfk_1` FOREIGN KEY (`veiculo_id`) REFERENCES `veiculos` (`id`),
  ADD CONSTRAINT `escalas_ibfk_2` FOREIGN KEY (`motorista_id`) REFERENCES `funcionarios` (`id`),
  ADD CONSTRAINT `escalas_ibfk_3` FOREIGN KEY (`cobrador_id`) REFERENCES `funcionarios` (`id`);

--
-- Limitadores para a tabela `veiculos`
--
ALTER TABLE `veiculos`
  ADD CONSTRAINT `veiculos_ibfk_1` FOREIGN KEY (`tipo_id`) REFERENCES `tipos_veiculo` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

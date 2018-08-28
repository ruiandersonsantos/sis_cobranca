-- MySQL dump 10.13  Distrib 5.6.23, for Win64 (x86_64)
--
-- Host: localhost    Database: bd_cobranca
-- ------------------------------------------------------
-- Server version	5.6.25-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `agencia`
--

DROP TABLE IF EXISTS `agencia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agencia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chave_origem` varchar(45) DEFAULT NULL,
  `codigo` varchar(200) DEFAULT NULL,
  `nome_agencia` varchar(45) DEFAULT NULL,
  `chave_primaria_banco` varchar(200) DEFAULT NULL,
  `chave_primaria_cidade` varchar(200) DEFAULT NULL,
  `data_hora_criacao` datetime DEFAULT CURRENT_TIMESTAMP,
  `ultima_atualizacao` datetime DEFAULT NULL,
  `qt_atualizacoes` int(11) DEFAULT '0',
  `banco_id` int(11) NOT NULL,
  `cidade_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_iagencia_chave_origem` (`chave_origem`),
  KEY `fk_agencia_banco_idx` (`banco_id`),
  KEY `fk_agencia_cidade1_idx` (`cidade_id`),
  CONSTRAINT `fk_agencia_banco` FOREIGN KEY (`banco_id`) REFERENCES `banco` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_agencia_cidade1` FOREIGN KEY (`cidade_id`) REFERENCES `cidade` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agencia`
--

LOCK TABLES `agencia` WRITE;
/*!40000 ALTER TABLE `agencia` DISABLE KEYS */;
INSERT INTO `agencia` VALUES (1,NULL,'2206','Rio Branco',NULL,NULL,'2018-08-26 22:15:41',NULL,0,1,0),(2,NULL,'2222','Teste',NULL,NULL,'2018-08-26 22:15:41',NULL,0,1,0);
/*!40000 ALTER TABLE `agencia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `banco`
--

DROP TABLE IF EXISTS `banco`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `banco` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chave_origem` varchar(45) DEFAULT NULL,
  `codigo` varchar(200) DEFAULT NULL,
  `nome_banco` varchar(45) DEFAULT NULL,
  `nome_banco_completo` varchar(200) DEFAULT NULL,
  `data_hora_criacao` datetime DEFAULT CURRENT_TIMESTAMP,
  `ultima_atualizacao` datetime DEFAULT NULL,
  `qt_atualizacoes` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_ibanco_chave_origem` (`chave_origem`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banco`
--

LOCK TABLES `banco` WRITE;
/*!40000 ALTER TABLE `banco` DISABLE KEYS */;
INSERT INTO `banco` VALUES (1,NULL,'341','Itau','Itau','2018-08-26 22:15:41',NULL,0);
/*!40000 ALTER TABLE `banco` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cidade`
--

DROP TABLE IF EXISTS `cidade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cidade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chave_origem` varchar(45) DEFAULT NULL,
  `descricao` varchar(200) DEFAULT NULL,
  `chave_estado` varchar(45) DEFAULT NULL,
  `data_hora_criacao` datetime DEFAULT CURRENT_TIMESTAMP,
  `ultima_atualizacao` datetime DEFAULT NULL,
  `qt_atualizacoes` int(11) DEFAULT '0',
  `estado_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_icidade_chave_origem` (`chave_origem`),
  KEY `fk_cidade_estado1_idx` (`estado_id`),
  CONSTRAINT `fk_cidade_estado1` FOREIGN KEY (`estado_id`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cidade`
--

LOCK TABLES `cidade` WRITE;
/*!40000 ALTER TABLE `cidade` DISABLE KEYS */;
/*!40000 ALTER TABLE `cidade` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `conta`
--

DROP TABLE IF EXISTS `conta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `conta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chave_origem` varchar(45) DEFAULT NULL,
  `numero_conta` varchar(200) DEFAULT NULL,
  `chave_primaria_agencia` varchar(200) DEFAULT NULL,
  `data_hora_criacao` datetime DEFAULT CURRENT_TIMESTAMP,
  `ultima_atualizacao` datetime DEFAULT NULL,
  `qt_atualizacoes` int(11) DEFAULT '0',
  `agencia_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_iconta_chave_origem` (`chave_origem`),
  KEY `fk_conta_agencia1_idx` (`agencia_id`),
  CONSTRAINT `fk_conta_agencia1` FOREIGN KEY (`agencia_id`) REFERENCES `agencia` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `conta`
--

LOCK TABLES `conta` WRITE;
/*!40000 ALTER TABLE `conta` DISABLE KEYS */;
/*!40000 ALTER TABLE `conta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estado`
--

DROP TABLE IF EXISTS `estado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chave_origem` varchar(45) DEFAULT NULL,
  `descricao` varchar(200) DEFAULT NULL,
  `sigla` varchar(45) DEFAULT NULL,
  `chave_origem_pais` varchar(45) DEFAULT NULL,
  `data_hora_criacao` datetime DEFAULT CURRENT_TIMESTAMP,
  `ultima_atualizacao` datetime DEFAULT NULL,
  `qt_atualizacoes` int(11) DEFAULT '0',
  `pais_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_iestado_chave_origem` (`chave_origem`),
  KEY `fk_estado_pais1_idx` (`pais_id`),
  CONSTRAINT `fk_estado_pais1` FOREIGN KEY (`pais_id`) REFERENCES `pais` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estado`
--

LOCK TABLES `estado` WRITE;
/*!40000 ALTER TABLE `estado` DISABLE KEYS */;
/*!40000 ALTER TABLE `estado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `i_agencia`
--

DROP TABLE IF EXISTS `i_agencia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `i_agencia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chave_origem` varchar(45) DEFAULT NULL,
  `codigo` varchar(200) DEFAULT NULL,
  `nome_agencia` varchar(45) DEFAULT NULL,
  `chave_primaria_banco` varchar(200) DEFAULT NULL,
  `chave_primaria_cidade` varchar(200) DEFAULT NULL,
  `data_hora_criacao` datetime DEFAULT CURRENT_TIMESTAMP,
  `ultima_atualizacao` datetime DEFAULT NULL,
  `qt_atualizacoes` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_iagencia_chave_origem` (`chave_origem`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `i_agencia`
--

LOCK TABLES `i_agencia` WRITE;
/*!40000 ALTER TABLE `i_agencia` DISABLE KEYS */;
/*!40000 ALTER TABLE `i_agencia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `i_banco`
--

DROP TABLE IF EXISTS `i_banco`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `i_banco` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chave_origem` varchar(45) DEFAULT NULL,
  `codigo` varchar(200) DEFAULT NULL,
  `nome_banco` varchar(45) DEFAULT NULL,
  `nome_banco_completo` varchar(200) DEFAULT NULL,
  `data_hora_criacao` datetime DEFAULT CURRENT_TIMESTAMP,
  `ultima_atualizacao` datetime DEFAULT NULL,
  `qt_atualizacoes` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_ibanco_chave_origem` (`chave_origem`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `i_banco`
--

LOCK TABLES `i_banco` WRITE;
/*!40000 ALTER TABLE `i_banco` DISABLE KEYS */;
/*!40000 ALTER TABLE `i_banco` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `i_cidade`
--

DROP TABLE IF EXISTS `i_cidade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `i_cidade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chave_origem` varchar(45) DEFAULT NULL,
  `descricao` varchar(200) DEFAULT NULL,
  `chave_estado` varchar(45) DEFAULT NULL,
  `data_hora_criacao` datetime DEFAULT CURRENT_TIMESTAMP,
  `ultima_atualizacao` datetime DEFAULT NULL,
  `qt_atualizacoes` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_icidade_chave_origem` (`chave_origem`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `i_cidade`
--

LOCK TABLES `i_cidade` WRITE;
/*!40000 ALTER TABLE `i_cidade` DISABLE KEYS */;
/*!40000 ALTER TABLE `i_cidade` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `i_cliente`
--

DROP TABLE IF EXISTS `i_cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `i_cliente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chave_origem` varchar(45) DEFAULT NULL,
  `codigo` varchar(200) DEFAULT NULL,
  `razao` varchar(500) DEFAULT NULL,
  `nome_fantasia` varchar(500) DEFAULT NULL,
  `documento` varchar(45) DEFAULT NULL,
  `endereco` varchar(500) DEFAULT NULL,
  `bairro` varchar(100) DEFAULT NULL,
  `complemento` varchar(200) DEFAULT NULL,
  `ddd` varchar(45) DEFAULT NULL,
  `telefone` varchar(45) DEFAULT NULL,
  `contato` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `chave_pais` varchar(200) DEFAULT NULL,
  `chave_estado` varchar(200) DEFAULT NULL,
  `chave_municipio` varchar(200) DEFAULT NULL,
  `data_hora_criacao` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ultima_atualizacao` datetime DEFAULT NULL,
  `qt_atualizacoes` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_icliente_chave_origem` (`chave_origem`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `i_cliente`
--

LOCK TABLES `i_cliente` WRITE;
/*!40000 ALTER TABLE `i_cliente` DISABLE KEYS */;
/*!40000 ALTER TABLE `i_cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `i_conta`
--

DROP TABLE IF EXISTS `i_conta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `i_conta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chave_origem` varchar(45) DEFAULT NULL,
  `numero_conta` varchar(200) DEFAULT NULL,
  `chave_primaria_agencia` varchar(200) DEFAULT NULL,
  `data_hora_criacao` datetime DEFAULT CURRENT_TIMESTAMP,
  `ultima_atualizacao` datetime DEFAULT NULL,
  `qt_atualizacoes` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_iconta_chave_origem` (`chave_origem`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `i_conta`
--

LOCK TABLES `i_conta` WRITE;
/*!40000 ALTER TABLE `i_conta` DISABLE KEYS */;
/*!40000 ALTER TABLE `i_conta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `i_estado`
--

DROP TABLE IF EXISTS `i_estado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `i_estado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chave_origem` varchar(45) DEFAULT NULL,
  `descricao` varchar(200) DEFAULT NULL,
  `sigla` varchar(45) DEFAULT NULL,
  `chave_origem_pais` varchar(45) DEFAULT NULL,
  `data_hora_criacao` datetime DEFAULT CURRENT_TIMESTAMP,
  `ultima_atualizacao` datetime DEFAULT NULL,
  `qt_atualizacoes` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_iestado_chave_origem` (`chave_origem`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `i_estado`
--

LOCK TABLES `i_estado` WRITE;
/*!40000 ALTER TABLE `i_estado` DISABLE KEYS */;
/*!40000 ALTER TABLE `i_estado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `i_pais`
--

DROP TABLE IF EXISTS `i_pais`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `i_pais` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chave_origem` varchar(45) NOT NULL,
  `descricao` varchar(45) NOT NULL,
  `data_hora_criacao` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ultima_atualizacao` datetime NOT NULL,
  `qt_atualizacoes` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_ipais_chave_origem` (`chave_origem`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `i_pais`
--

LOCK TABLES `i_pais` WRITE;
/*!40000 ALTER TABLE `i_pais` DISABLE KEYS */;
/*!40000 ALTER TABLE `i_pais` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `i_parcela`
--

DROP TABLE IF EXISTS `i_parcela`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `i_parcela` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chave_origem` varchar(45) DEFAULT NULL,
  `numero_parcela` varchar(200) DEFAULT NULL,
  `data_vencimento` date DEFAULT NULL,
  `valor_liquido` decimal(16,2) DEFAULT NULL,
  `valor_bruto` decimal(16,2) DEFAULT NULL,
  `valor_estorno` decimal(16,2) DEFAULT NULL,
  `valor_reparcelamento` decimal(16,2) DEFAULT NULL,
  `valor_quitado` decimal(16,2) DEFAULT NULL,
  `data_prorrogacao` date DEFAULT NULL,
  `valor_aberto` decimal(16,2) DEFAULT NULL,
  `chave_banco` varchar(200) DEFAULT NULL,
  `chave_agencia` varchar(200) DEFAULT NULL,
  `chave_conta` varchar(200) DEFAULT NULL,
  `chave_primaria_titulo` varchar(200) DEFAULT NULL,
  `data_hora_criacao` datetime DEFAULT CURRENT_TIMESTAMP,
  `ultima_atualizacao` datetime DEFAULT NULL,
  `qt_atualizacoes` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_iparcela_chave_origem` (`chave_origem`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `i_parcela`
--

LOCK TABLES `i_parcela` WRITE;
/*!40000 ALTER TABLE `i_parcela` DISABLE KEYS */;
/*!40000 ALTER TABLE `i_parcela` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `i_titulo`
--

DROP TABLE IF EXISTS `i_titulo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `i_titulo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chave_origem` varchar(45) DEFAULT NULL,
  `numero` varchar(200) DEFAULT NULL,
  `serie` varchar(45) DEFAULT NULL,
  `emissao` date DEFAULT NULL,
  `valor` decimal(16,2) DEFAULT NULL,
  `data_hora_criacao` datetime DEFAULT CURRENT_TIMESTAMP,
  `ultima_atualizacao` datetime DEFAULT NULL,
  `qt_atualizacoes` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_ititulo_chave_origem` (`chave_origem`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `i_titulo`
--

LOCK TABLES `i_titulo` WRITE;
/*!40000 ALTER TABLE `i_titulo` DISABLE KEYS */;
/*!40000 ALTER TABLE `i_titulo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log_importacao`
--

DROP TABLE IF EXISTS `log_importacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_importacao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data_hora` datetime DEFAULT CURRENT_TIMESTAMP,
  `nome_classe` varchar(200) DEFAULT NULL,
  `nome_metodo` varchar(200) DEFAULT NULL,
  `inicio` datetime DEFAULT NULL,
  `fim` datetime DEFAULT NULL,
  `quantidade_registro` int(11) DEFAULT NULL,
  `ocorrencia` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_importacao`
--

LOCK TABLES `log_importacao` WRITE;
/*!40000 ALTER TABLE `log_importacao` DISABLE KEYS */;
/*!40000 ALTER TABLE `log_importacao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pais`
--

DROP TABLE IF EXISTS `pais`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pais` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chave_origem` varchar(45) NOT NULL,
  `descricao` varchar(45) NOT NULL,
  `data_hora_criacao` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ultima_atualizacao` datetime NOT NULL,
  `qt_atualizacoes` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_ipais_chave_origem` (`chave_origem`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pais`
--

LOCK TABLES `pais` WRITE;
/*!40000 ALTER TABLE `pais` DISABLE KEYS */;
/*!40000 ALTER TABLE `pais` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-08-26 23:33:24

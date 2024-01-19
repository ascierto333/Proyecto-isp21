-- MariaDB dump 10.19  Distrib 10.4.24-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: papasfriendsobj
-- ------------------------------------------------------
-- Server version	10.4.24-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cabfacturas`
--

DROP TABLE IF EXISTS `cabfacturas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cabfacturas` (
  `nroFact` int(8) NOT NULL AUTO_INCREMENT,
  `idCliente` int(11) NOT NULL,
  `fechaFact` datetime DEFAULT NULL,
  `tipoFact` enum('Factura A','Factura B','Factura C','Factura D','Factura E','Presupuesto') NOT NULL,
  `eliminado` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`nroFact`),
  KEY `idCliente` (`idCliente`) USING BTREE,
  CONSTRAINT `cabfacturas_ibfk_1` FOREIGN KEY (`idCliente`) REFERENCES `clientes` (`idCliente`)
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cabfacturas`
--

LOCK TABLES `cabfacturas` WRITE;
/*!40000 ALTER TABLE `cabfacturas` DISABLE KEYS */;
INSERT INTO `cabfacturas` VALUES (54,1,'2023-09-22 19:52:53','Factura A',0),(55,1,'2023-09-22 20:00:28','Factura A',0),(56,1,'2023-09-22 20:03:15','Presupuesto',0),(57,14,'2023-09-28 19:31:05','Factura B',0),(58,1,'2023-09-28 19:42:07','Factura E',0),(59,1,'2023-09-28 19:47:52','Factura E',0),(60,1,'2023-09-28 19:49:45','Factura E',0),(61,3,'2023-09-28 19:52:02','Factura C',1),(62,4,'2023-10-02 19:50:43','Factura A',1),(63,1,'2023-10-03 22:42:32','Factura B',0),(64,1,'2023-10-04 21:31:33','Factura A',0),(65,1,'2023-10-04 21:37:51','Factura A',0),(66,1,'2023-10-09 20:04:11','Factura A',1),(67,2,'2023-10-09 20:21:24','Factura B',0),(68,3,'2023-10-09 20:25:43','Factura A',0),(69,1,'2023-11-19 17:49:30','',1),(70,1,'2023-11-19 20:00:16','',1),(71,1,'2023-11-19 20:11:47','',1),(72,1,'2023-11-19 20:31:58','Factura A',0),(73,1,'2023-11-19 20:38:03','Factura A',0),(74,1,'2023-11-19 20:38:56','Factura A',0),(75,1,'2023-11-19 20:40:51','Factura A',0),(76,1,'2023-11-19 20:42:48','Factura A',0),(77,2,'2023-11-19 20:43:43','Factura A',0),(78,3,'2023-11-19 20:46:04','Factura A',0),(79,1,'2023-11-19 20:54:24','Factura A',0),(80,1,'2023-11-19 21:02:06','Factura A',0),(81,1,'2023-11-19 21:23:20','Factura A',0),(82,1,'2023-11-19 21:28:50','Factura A',0),(83,1,'2023-11-20 12:02:33','Factura A',0),(84,1,'2023-11-20 12:34:54','Factura A',0),(85,1,'2023-11-20 12:38:46','Factura A',0),(86,1,'2023-11-20 12:42:20','Factura A',0),(87,1,'2023-11-20 12:44:15','Factura A',0),(88,1,'2023-11-20 22:19:57','Factura A',0),(89,1,'2023-11-20 22:22:48','Factura A',0),(90,1,'2023-11-20 22:29:23','Factura A',0),(91,1,'2023-11-20 22:35:18','Factura A',0),(92,2,'2023-11-20 22:37:28','Factura A',0),(93,3,'2023-11-20 22:42:21','Factura A',0),(94,3,'2023-11-20 22:53:39','Factura A',0),(95,3,'2023-11-20 22:56:50','Factura A',0),(96,1,'2023-11-20 23:03:47','Factura A',0),(97,3,'2023-11-20 23:04:22','Factura B',0),(98,1,'2023-11-20 23:07:51','Factura B',0),(99,3,'2023-11-20 23:08:57','Factura A',0),(100,1,'2023-11-22 20:58:21','Factura A',0),(101,1,'2023-11-23 16:55:54','Factura A',0),(102,1,'2023-11-26 19:53:46','Factura B',0),(103,1,'2023-11-27 10:38:35','Factura A',0),(104,1,'2023-12-01 19:02:46','Factura A',1);
/*!40000 ALTER TABLE `cabfacturas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clientes` (
  `idCliente` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(40) NOT NULL,
  `direccioncliente` varchar(40) NOT NULL,
  `dni` int(8) NOT NULL,
  `cuit` char(11) DEFAULT NULL,
  PRIMARY KEY (`idCliente`),
  UNIQUE KEY `dni` (`dni`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes`
--

LOCK TABLES `clientes` WRITE;
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` VALUES (1,'Lomoteca','libertad 135,Arroyo Seco',11111,'20234857739'),(2,'zabba','sarmiento 335, Arroyo Seco',22222,'22222222222'),(3,'dixie','Belgrano y Libertad',33333,'27124567999'),(4,'cielo del paraná','Playa mansa ',44444,'11111111111'),(14,'TheClover','San Martin 568, Arroyo Seco',55555,'20351235399');
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detallefactura`
--

DROP TABLE IF EXISTS `detallefactura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detallefactura` (
  `nroDetalle` int(11) NOT NULL AUTO_INCREMENT,
  `nroFact` int(11) NOT NULL,
  `codProd` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` float NOT NULL,
  PRIMARY KEY (`nroDetalle`),
  KEY `nroFact` (`nroFact`),
  KEY `codProd` (`codProd`),
  CONSTRAINT `detallefactura_ibfk_1` FOREIGN KEY (`nroFact`) REFERENCES `cabfacturas` (`nroFact`),
  CONSTRAINT `detallefactura_ibfk_2` FOREIGN KEY (`codProd`) REFERENCES `productos` (`codProd`)
) ENGINE=InnoDB AUTO_INCREMENT=130 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detallefactura`
--

LOCK TABLES `detallefactura` WRITE;
/*!40000 ALTER TABLE `detallefactura` DISABLE KEYS */;
INSERT INTO `detallefactura` VALUES (68,54,111,1,350),(69,54,222,4,350),(70,55,111,1,350),(71,56,111,1,350),(72,57,333,6,350),(73,57,555,4,350),(74,58,111,1,350),(75,59,666,1,350),(76,60,666,1,350),(77,61,333,1,350),(78,62,777,1,350),(79,63,111,1,350),(80,64,111,1,350),(81,65,111,1,350),(82,66,222,1,350),(83,66,333,1,350),(84,67,666,1,350),(85,68,777,1,350),(86,69,111,1,350),(87,70,111,1,350),(88,71,111,1,350),(89,71,222,1,350),(90,72,222,1,350),(91,73,111,1,350),(92,74,111,1,350),(93,75,111,1,350),(94,76,111,1,350),(95,76,222,1,350),(96,77,666,1,350),(97,78,111,1,350),(98,79,111,1,350),(99,80,555,1,350),(100,81,111,1,350),(101,82,111,1,350),(102,83,222,1,350),(103,84,111,1,350),(104,85,111,1,350),(105,86,111,1,350),(106,87,111,1,350),(107,88,111,1,350),(108,89,111,1,350),(109,90,111,1,350),(110,90,222,1,350),(111,91,111,1,350),(112,91,222,1,350),(113,92,666,1,350),(114,93,111,1,350),(115,93,222,1,350),(116,93,333,1,350),(117,94,111,3,350),(118,95,111,1,350),(119,96,111,1,350),(120,97,222,1,350),(121,97,111,4,350),(122,98,111,1,350),(123,99,222,1,350),(124,100,111,1,350),(125,100,222,1,350),(126,101,111,1,350),(127,102,111,1,350),(128,103,111,1,350),(129,104,111,2,350);
/*!40000 ALTER TABLE `detallefactura` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produccion`
--

DROP TABLE IF EXISTS `produccion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `produccion` (
  `codigoproduccion` int(11) NOT NULL AUTO_INCREMENT,
  `codProd` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `cantidad` int(11) NOT NULL,
  `materiaprima` int(11) NOT NULL,
  PRIMARY KEY (`codigoproduccion`),
  KEY `codProd` (`codProd`) USING BTREE,
  CONSTRAINT `produccion_ibfk_1` FOREIGN KEY (`codProd`) REFERENCES `productos` (`codProd`)
) ENGINE=InnoDB AUTO_INCREMENT=126 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produccion`
--

LOCK TABLES `produccion` WRITE;
/*!40000 ALTER TABLE `produccion` DISABLE KEYS */;
INSERT INTO `produccion` VALUES (92,222,'2023-09-14',1,1),(93,222,'2023-09-01',1,1),(94,111,'2023-09-14',1,1),(95,111,'2023-09-22',1,1),(96,111,'2023-11-21',10,10),(99,111,'2023-11-26',1,1),(100,111,'2023-12-04',1,1),(101,111,'2023-12-04',1,1),(102,111,'2023-12-04',10,10),(103,111,'2023-12-04',1,1),(104,111,'2023-12-04',3,29),(105,111,'2023-12-04',1,1),(107,111,'2023-12-04',1,1),(109,111,'2023-12-04',1,1),(110,111,'2023-12-04',1,1),(111,111,'2023-12-01',1,1),(112,111,'2023-12-04',1,1),(113,111,'2023-12-04',1,1),(114,111,'2023-12-05',1,1),(115,111,'2023-12-05',1,1),(116,111,'2023-12-05',1,1),(117,111,'2023-12-05',1,1),(118,111,'2023-12-05',1,1),(120,111,'2023-12-05',1,1),(121,111,'2023-12-05',2,2),(122,222,'2023-12-05',1,1),(125,111,'2023-12-05',1,1);
/*!40000 ALTER TABLE `produccion` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER tr_trigger_eliminacion_produccion
AFTER DELETE ON produccion
FOR EACH ROW
BEGIN
    INSERT INTO produccion_eliminados (codigoproduccion, codProd, fecha, cantidad, materiaprima)
    VALUES (OLD.codigoproduccion, OLD.codProd, OLD.fecha, OLD.cantidad, OLD.materiaprima);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `produccion_eliminados`
--

DROP TABLE IF EXISTS `produccion_eliminados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `produccion_eliminados` (
  `codigoproduccion` int(11) NOT NULL,
  `codProd` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `cantidad` decimal(10,2) DEFAULT NULL,
  `materiaprima` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`codigoproduccion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produccion_eliminados`
--

LOCK TABLES `produccion_eliminados` WRITE;
/*!40000 ALTER TABLE `produccion_eliminados` DISABLE KEYS */;
INSERT INTO `produccion_eliminados` VALUES (123,111,'2023-12-05',3.00,3.00),(124,111,'2023-12-05',3.00,3.00);
/*!40000 ALTER TABLE `produccion_eliminados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `productos` (
  `codProd` int(8) NOT NULL,
  `descProd` varchar(30) NOT NULL,
  `precio` float NOT NULL,
  `stock` int(11) NOT NULL,
  PRIMARY KEY (`codProd`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` VALUES (0,'MateriaPrima',0,955),(111,'BastonFino',350,987),(222,'BastonGrueso',350,979),(333,'Españolas',350,988),(444,'Rejillas',350,997),(555,'Noissette',350,995),(666,'Cubos',350,896),(777,'Peladas',350,998);
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `idusuario` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(10) NOT NULL,
  `clave` char(8) NOT NULL,
  PRIMARY KEY (`idusuario`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'matias','11111111'),(2,'Ascierto3','Asciert3'),(3,'alvaro','12345678');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `vista_produccion`
--

DROP TABLE IF EXISTS `vista_produccion`;
/*!50001 DROP VIEW IF EXISTS `vista_produccion`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vista_produccion` (
  `codigoproduccion` tinyint NOT NULL,
  `tipo_corte` tinyint NOT NULL,
  `fecha` tinyint NOT NULL,
  `cantidad` tinyint NOT NULL,
  `materiaprima` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `vista_produccion`
--

/*!50001 DROP TABLE IF EXISTS `vista_produccion`*/;
/*!50001 DROP VIEW IF EXISTS `vista_produccion`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vista_produccion` AS select `p`.`codigoproduccion` AS `codigoproduccion`,`pr`.`descProd` AS `tipo_corte`,`p`.`fecha` AS `fecha`,`p`.`cantidad` AS `cantidad`,`p`.`materiaprima` AS `materiaprima` from (`produccion` `p` join `productos` `pr` on(`p`.`codProd` = `pr`.`codProd`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-01-18 23:39:39

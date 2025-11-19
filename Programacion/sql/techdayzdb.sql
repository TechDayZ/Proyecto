-- MySQL dump 10.13  Distrib 8.0.43, for Linux (x86_64)
--
-- Host: localhost    Database: techdayzdb
-- ------------------------------------------------------
-- Server version	8.0.43-0ubuntu0.24.04.2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `avisos`
--

DROP TABLE IF EXISTS `avisos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `avisos` (
  `idAviso` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `contenido` text NOT NULL,
  `idUser` int NOT NULL,
  `fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idAviso`),
  KEY `idUser` (`idUser`),
  CONSTRAINT `avisos_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `usuarios` (`idUser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `avisos`
--

LOCK TABLES `avisos` WRITE;
/*!40000 ALTER TABLE `avisos` DISABLE KEYS */;
/*!40000 ALTER TABLE `avisos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comentarios`
--

DROP TABLE IF EXISTS `comentarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comentarios` (
  `idComentario` int NOT NULL AUTO_INCREMENT,
  `idAviso` int NOT NULL,
  `idUser` int NOT NULL,
  `comentario` text NOT NULL,
  `fecha_comentario` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idComentario`),
  KEY `idAviso` (`idAviso`),
  KEY `idUser` (`idUser`),
  CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`idAviso`) REFERENCES `avisos` (`idAviso`),
  CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`idUser`) REFERENCES `usuarios` (`idUser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comentarios`
--

LOCK TABLES `comentarios` WRITE;
/*!40000 ALTER TABLE `comentarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `comentarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `horastrabajo`
--

DROP TABLE IF EXISTS `horastrabajo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `horastrabajo` (
  `idHoras` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `work_date` date NOT NULL,
  `horas` decimal(5,2) NOT NULL,
  `descripcion` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idHoras`),
  UNIQUE KEY `unique_user_date` (`user_id`,`work_date`),
  CONSTRAINT `horastrabajo_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`idUser`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `horastrabajo`
--

LOCK TABLES `horastrabajo` WRITE;
/*!40000 ALTER TABLE `horastrabajo` DISABLE KEYS */;
/*!40000 ALTER TABLE `horastrabajo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pagos`
--

DROP TABLE IF EXISTS `pagos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pagos` (
  `idPago` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `tipo` enum('pago','certificado','eximido') NOT NULL,
  `archivo` varchar(255) NOT NULL,
  `estado` enum('pendiente','aprobado','rechazado') DEFAULT 'pendiente',
  `fecha_subida` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idPago`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`idUser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pagos`
--

LOCK TABLES `pagos` WRITE;
/*!40000 ALTER TABLE `pagos` DISABLE KEYS */;
/*!40000 ALTER TABLE `pagos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reportes_unidad`
--

DROP TABLE IF EXISTS `reportes_unidad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reportes_unidad` (
  `idReporte` int NOT NULL AUTO_INCREMENT,
  `idUnidad` int NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha_reporte` datetime DEFAULT CURRENT_TIMESTAMP,
  `archivo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idReporte`),
  KEY `idUnidad` (`idUnidad`),
  CONSTRAINT `reportes_unidad_ibfk_1` FOREIGN KEY (`idUnidad`) REFERENCES `unidades` (`idUnidad`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reportes_unidad`
--

LOCK TABLES `reportes_unidad` WRITE;
/*!40000 ALTER TABLE `reportes_unidad` DISABLE KEYS */;
/*!40000 ALTER TABLE `reportes_unidad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `solicitudes_unidad`
--

DROP TABLE IF EXISTS `solicitudes_unidad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `solicitudes_unidad` (
  `idSolicitud` int NOT NULL AUTO_INCREMENT,
  `idUser` int NOT NULL,
  `idUnidad` int NOT NULL,
  `estado` enum('pendiente','aprobada','rechazada') DEFAULT 'pendiente',
  `fecha_solicitud` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idSolicitud`),
  KEY `idUser` (`idUser`),
  KEY `idUnidad` (`idUnidad`),
  CONSTRAINT `solicitudes_unidad_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `usuarios` (`idUser`),
  CONSTRAINT `solicitudes_unidad_ibfk_2` FOREIGN KEY (`idUnidad`) REFERENCES `unidades` (`idUnidad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `solicitudes_unidad`
--

LOCK TABLES `solicitudes_unidad` WRITE;
/*!40000 ALTER TABLE `solicitudes_unidad` DISABLE KEYS */;
/*!40000 ALTER TABLE `solicitudes_unidad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `uniCoop`
--

DROP TABLE IF EXISTS `uniCoop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `uniCoop` (
  `idUniCoop` int NOT NULL,
  `BlockCoop` int NOT NULL,
  `finalidad` varchar(100) NOT NULL,
  PRIMARY KEY (`idUniCoop`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `uniCoop`
--

LOCK TABLES `uniCoop` WRITE;
/*!40000 ALTER TABLE `uniCoop` DISABLE KEYS */;
/*!40000 ALTER TABLE `uniCoop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unidades`
--

DROP TABLE IF EXISTS `unidades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `unidades` (
  `idUnidad` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int DEFAULT NULL,
  `numero_unidad` varchar(255) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `descripcion` text,
  `cuartos` int NOT NULL,
  `banos` int NOT NULL,
  `metros` int NOT NULL,
  `estado` enum('disponible','asignada','ocupada') DEFAULT 'disponible',
  `fecha_asignacion` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idUnidad`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `unidades_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`idUser`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unidades`
--

LOCK TABLES `unidades` WRITE;
/*!40000 ALTER TABLE `unidades` DISABLE KEYS */;
INSERT INTO `unidades` VALUES (1,NULL,'A1','Av. Principal 123','Unidad en excelente estado, primer piso.',3,1,68,'disponible',NULL),(2,NULL,'B2','Calle Secundaria 456','Cercana al parque y comercios.',2,1,52,'disponible',NULL),(3,NULL,'C3','Boulevard Central 789','Amplia, orientación norte.',4,2,89,'disponible',NULL);
/*!40000 ALTER TABLE `unidades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `idUser` int NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `fechNac` date NOT NULL,
  `email` varchar(50) NOT NULL,
  `telefono` int NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `status` enum('pending','active','denied') DEFAULT 'pending',
  `rol` enum('user','admin','tesorero') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `foto_perfil` varchar(255) DEFAULT 'default.jpg',
  PRIMARY KEY (`idUser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'Administrador','2000-01-01','admin@cooperativa.com',123456789,'$2y$10$Nh7KBpDcE4QTSLHbwWcNtum1gYffw0z9VL0YsRrhKtdl8/1fj0r6i','active','admin','2025-11-19 13:21:40','default.jpg');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-11-19 13:29:50

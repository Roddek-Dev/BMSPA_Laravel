/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-11.8.2-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: bmspa_arquitecture_hexagonal_laravel
-- ------------------------------------------------------
-- Server version	11.8.2-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Table structure for table `direcciones`
--

DROP TABLE IF EXISTS `direcciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `direcciones` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `direccionable_id` bigint(20) unsigned NOT NULL,
  `direccionable_type` varchar(255) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `colonia` varchar(100) NOT NULL,
  `codigo_postal` varchar(10) NOT NULL,
  `ciudad` varchar(100) NOT NULL,
  `estado` varchar(100) NOT NULL,
  `referencias` text DEFAULT NULL COMMENT 'Referencias adicionales para la ubicación',
  `es_predeterminada` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `direcciones_direccionable_id_direccionable_type_index` (`direccionable_id`,`direccionable_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `direcciones`
--

LOCK TABLES `direcciones` WRITE;
/*!40000 ALTER TABLE `direcciones` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `direcciones` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `especialidades`
--

DROP TABLE IF EXISTS `especialidades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `especialidades` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `icono_clave` varchar(50) DEFAULT NULL COMMENT 'Clave para mapear a un icono en el frontend, ej: CORTE_HOMBRE, UNIAS_GEL',
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `especialidades_nombre_unique` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `especialidades`
--

LOCK TABLES `especialidades` WRITE;
/*!40000 ALTER TABLE `especialidades` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `especialidades` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `horarios_sucursal`
--

DROP TABLE IF EXISTS `horarios_sucursal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `horarios_sucursal` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sucursal_id` bigint(20) unsigned NOT NULL,
  `dia_semana` tinyint(3) unsigned NOT NULL COMMENT '0=Domingo, 1=Lunes,..., 6=Sábado',
  `hora_apertura` time DEFAULT NULL,
  `hora_cierre` time DEFAULT NULL,
  `esta_cerrado_regularmente` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Si este día de la semana la sucursal está normalmente cerrada, ej: Domingos',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `horarios_sucursal_sucursal_id_dia_semana_unique` (`sucursal_id`,`dia_semana`),
  CONSTRAINT `horarios_sucursal_sucursal_id_foreign` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursales` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `horarios_sucursal`
--

LOCK TABLES `horarios_sucursal` WRITE;
/*!40000 ALTER TABLE `horarios_sucursal` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `horarios_sucursal` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `reseñas`
--

DROP TABLE IF EXISTS `reseñas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `reseñas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cliente_usuario_id` bigint(20) unsigned NOT NULL,
  `calificacion` tinyint(3) unsigned NOT NULL COMMENT '1 a 5 estrellas',
  `comentario` text DEFAULT NULL,
  `reseñable_id` bigint(20) unsigned NOT NULL COMMENT 'ID del modelo reseñado',
  `reseñable_type` varchar(255) NOT NULL COMMENT 'Namespace del modelo reseñado, ej: App\\Models\\Servicio, App\\Models\\Producto, App\\Models\\Personal',
  `aprobada` tinyint(1) NOT NULL DEFAULT 1,
  `fecha_reseña` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reseñas_cliente_usuario_id_foreign` (`cliente_usuario_id`),
  KEY `reseñas_reseñable_id_reseñable_type_index` (`reseñable_id`,`reseñable_type`),
  CONSTRAINT `reseñas_cliente_usuario_id_foreign` FOREIGN KEY (`cliente_usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reseñas`
--

LOCK TABLES `reseñas` WRITE;
/*!40000 ALTER TABLE `reseñas` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `reseñas` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `especialidad_personal`
--

DROP TABLE IF EXISTS `especialidad_personal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `especialidad_personal` (
  `especialidad_id` bigint(20) unsigned NOT NULL,
  `personal_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`especialidad_id`,`personal_id`),
  KEY `especialidad_personal_personal_id_foreign` (`personal_id`),
  CONSTRAINT `especialidad_personal_especialidad_id_foreign` FOREIGN KEY (`especialidad_id`) REFERENCES `especialidades` (`id`) ON DELETE CASCADE,
  CONSTRAINT `especialidad_personal_personal_id_foreign` FOREIGN KEY (`personal_id`) REFERENCES `personal` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `especialidad_personal`
--

LOCK TABLES `especialidad_personal` WRITE;
/*!40000 ALTER TABLE `especialidad_personal` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `especialidad_personal` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `personal`
--

DROP TABLE IF EXISTS `personal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `usuario_id` bigint(20) unsigned NOT NULL,
  `sucursal_asignada_id` bigint(20) unsigned DEFAULT NULL,
  `tipo_personal` varchar(50) NOT NULL COMMENT 'Ej: ADMIN_GENERAL, ADMIN_SUCURSAL, BARBERO, ESTILISTA, MASAJISTA, RECEPCIONISTA',
  `numero_empleado` varchar(50) DEFAULT NULL,
  `fecha_contratacion` date DEFAULT NULL,
  `activo_en_empresa` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Si el empleado está actualmente activo en la empresa',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_usuario_id_unique` (`usuario_id`),
  UNIQUE KEY `personal_numero_empleado_unique` (`numero_empleado`),
  KEY `personal_sucursal_asignada_id_foreign` (`sucursal_asignada_id`),
  CONSTRAINT `personal_sucursal_asignada_id_foreign` FOREIGN KEY (`sucursal_asignada_id`) REFERENCES `sucursales` (`id`) ON DELETE SET NULL,
  CONSTRAINT `personal_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal`
--

LOCK TABLES `personal` WRITE;
/*!40000 ALTER TABLE `personal` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `personal` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `servicio_sucursal`
--

DROP TABLE IF EXISTS `servicio_sucursal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `servicio_sucursal` (
  `servicio_id` bigint(20) unsigned NOT NULL,
  `sucursal_id` bigint(20) unsigned NOT NULL,
  `precio_en_sucursal` decimal(10,2) DEFAULT NULL COMMENT 'Precio específico del servicio en esta sucursal, si difiere del base del servicio',
  `esta_disponible` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Si el servicio está actualmente activo/ofreciéndose en esta sucursal',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`servicio_id`,`sucursal_id`),
  KEY `servicio_sucursal_sucursal_id_foreign` (`sucursal_id`),
  CONSTRAINT `servicio_sucursal_servicio_id_foreign` FOREIGN KEY (`servicio_id`) REFERENCES `servicios` (`id`) ON DELETE CASCADE,
  CONSTRAINT `servicio_sucursal_sucursal_id_foreign` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursales` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `servicio_sucursal`
--

LOCK TABLES `servicio_sucursal` WRITE;
/*!40000 ALTER TABLE `servicio_sucursal` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `servicio_sucursal` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `agendamientos`
--

DROP TABLE IF EXISTS `agendamientos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `agendamientos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cliente_usuario_id` bigint(20) unsigned NOT NULL,
  `personal_id` bigint(20) unsigned DEFAULT NULL,
  `servicio_id` bigint(20) unsigned NOT NULL,
  `sucursal_id` bigint(20) unsigned NOT NULL,
  `fecha_hora_inicio` datetime NOT NULL,
  `fecha_hora_fin` datetime NOT NULL,
  `precio_final` decimal(10,2) NOT NULL,
  `estado` varchar(50) NOT NULL DEFAULT 'PROGRAMADA' COMMENT 'Ej: PROGRAMADA, CONFIRMADA, CANCELADA_CLIENTE, CANCELADA_PERSONAL, COMPLETADA, NO_ASISTIO',
  `notas_cliente` text DEFAULT NULL,
  `notas_internas` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `agendamientos_cliente_usuario_id_foreign` (`cliente_usuario_id`),
  KEY `agendamientos_personal_id_foreign` (`personal_id`),
  KEY `agendamientos_servicio_id_foreign` (`servicio_id`),
  KEY `agendamientos_sucursal_id_foreign` (`sucursal_id`),
  CONSTRAINT `agendamientos_cliente_usuario_id_foreign` FOREIGN KEY (`cliente_usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  CONSTRAINT `agendamientos_personal_id_foreign` FOREIGN KEY (`personal_id`) REFERENCES `personal` (`id`) ON DELETE SET NULL,
  CONSTRAINT `agendamientos_servicio_id_foreign` FOREIGN KEY (`servicio_id`) REFERENCES `servicios` (`id`),
  CONSTRAINT `agendamientos_sucursal_id_foreign` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursales` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agendamientos`
--

LOCK TABLES `agendamientos` WRITE;
/*!40000 ALTER TABLE `agendamientos` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `agendamientos` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `detalle_ordenes`
--

DROP TABLE IF EXISTS `detalle_ordenes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `detalle_ordenes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `orden_id` bigint(20) unsigned NOT NULL,
  `producto_id` bigint(20) unsigned NOT NULL,
  `nombre_producto_historico` varchar(255) NOT NULL,
  `cantidad` int(10) unsigned NOT NULL,
  `precio_unitario_historico` decimal(10,2) NOT NULL,
  `subtotal_linea` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `detalle_ordenes_orden_id_foreign` (`orden_id`),
  KEY `detalle_ordenes_producto_id_foreign` (`producto_id`),
  CONSTRAINT `detalle_ordenes_orden_id_foreign` FOREIGN KEY (`orden_id`) REFERENCES `ordenes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `detalle_ordenes_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_ordenes`
--

LOCK TABLES `detalle_ordenes` WRITE;
/*!40000 ALTER TABLE `detalle_ordenes` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `detalle_ordenes` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `transacciones_pago`
--

DROP TABLE IF EXISTS `transacciones_pago`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `transacciones_pago` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `orden_id` bigint(20) unsigned DEFAULT NULL,
  `agendamiento_id` bigint(20) unsigned DEFAULT NULL,
  `cliente_usuario_id` bigint(20) unsigned NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `moneda` varchar(10) NOT NULL DEFAULT 'MXN',
  `metodo_pago` varchar(100) NOT NULL,
  `id_transaccion_pasarela` varchar(255) DEFAULT NULL,
  `estado_pago` varchar(50) NOT NULL COMMENT 'Ej: PENDIENTE, COMPLETADO, FALLIDO, REEMBOLSADO',
  `fecha_transaccion` datetime NOT NULL DEFAULT current_timestamp(),
  `datos_pasarela_request` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`datos_pasarela_request`)),
  `datos_pasarela_response` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`datos_pasarela_response`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `transacciones_pago_id_transaccion_pasarela_unique` (`id_transaccion_pasarela`),
  KEY `transacciones_pago_orden_id_foreign` (`orden_id`),
  KEY `transacciones_pago_agendamiento_id_foreign` (`agendamiento_id`),
  KEY `transacciones_pago_cliente_usuario_id_foreign` (`cliente_usuario_id`),
  CONSTRAINT `transacciones_pago_agendamiento_id_foreign` FOREIGN KEY (`agendamiento_id`) REFERENCES `agendamientos` (`id`) ON DELETE SET NULL,
  CONSTRAINT `transacciones_pago_cliente_usuario_id_foreign` FOREIGN KEY (`cliente_usuario_id`) REFERENCES `usuarios` (`id`),
  CONSTRAINT `transacciones_pago_orden_id_foreign` FOREIGN KEY (`orden_id`) REFERENCES `ordenes` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transacciones_pago`
--

LOCK TABLES `transacciones_pago` WRITE;
/*!40000 ALTER TABLE `transacciones_pago` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `transacciones_pago` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `sucursales`
--

DROP TABLE IF EXISTS `sucursales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `sucursales` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `imagen_path` varchar(255) DEFAULT NULL,
  `telefono_contacto` varchar(25) DEFAULT NULL,
  `email_contacto` varchar(255) DEFAULT NULL,
  `link_maps` varchar(512) DEFAULT NULL,
  `latitud` decimal(10,7) DEFAULT NULL,
  `longitud` decimal(10,7) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sucursales_email_contacto_unique` (`email_contacto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sucursales`
--

LOCK TABLES `sucursales` WRITE;
/*!40000 ALTER TABLE `sucursales` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `sucursales` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `musica_preferencias_navegacion`
--

DROP TABLE IF EXISTS `musica_preferencias_navegacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `musica_preferencias_navegacion` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_opcion` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `stream_url_ejemplo` varchar(512) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `musica_preferencias_navegacion_nombre_opcion_unique` (`nombre_opcion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `musica_preferencias_navegacion`
--

LOCK TABLES `musica_preferencias_navegacion` WRITE;
/*!40000 ALTER TABLE `musica_preferencias_navegacion` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `musica_preferencias_navegacion` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `ordenes`
--

DROP TABLE IF EXISTS `ordenes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `ordenes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cliente_usuario_id` bigint(20) unsigned NOT NULL,
  `numero_orden` varchar(50) NOT NULL,
  `fecha_orden` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_recibida` datetime DEFAULT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `descuento_total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `impuestos_total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_orden` decimal(10,2) NOT NULL,
  `estado_orden` varchar(50) NOT NULL DEFAULT 'PENDIENTE_PAGO' COMMENT 'Ej: PENDIENTE_PAGO, PAGADA, EN_PROCESO, ENVIADA, ENTREGADA, CANCELADA',
  `notas_orden` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ordenes_numero_orden_unique` (`numero_orden`),
  KEY `ordenes_cliente_usuario_id_foreign` (`cliente_usuario_id`),
  CONSTRAINT `ordenes_cliente_usuario_id_foreign` FOREIGN KEY (`cliente_usuario_id`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ordenes`
--

LOCK TABLES `ordenes` WRITE;
/*!40000 ALTER TABLE `ordenes` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `ordenes` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `excepciones_horario_sucursal`
--

DROP TABLE IF EXISTS `excepciones_horario_sucursal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `excepciones_horario_sucursal` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sucursal_id` bigint(20) unsigned NOT NULL,
  `fecha` date NOT NULL COMMENT 'Fecha específica de la excepción',
  `esta_cerrado` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Indica si la sucursal está cerrada en esta fecha específica',
  `hora_apertura` time DEFAULT NULL COMMENT 'Hora de apertura especial para esta fecha, si aplica y no está cerrada',
  `hora_cierre` time DEFAULT NULL COMMENT 'Hora de cierre especial para esta fecha, si aplica y no está cerrada',
  `descripcion` varchar(255) DEFAULT NULL COMMENT 'Motivo de la excepción, ej: Festivo Nacional, Mantenimiento',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `excepciones_horario_sucursal_sucursal_id_fecha_index` (`sucursal_id`,`fecha`),
  CONSTRAINT `excepciones_horario_sucursal_sucursal_id_foreign` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursales` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `excepciones_horario_sucursal`
--

LOCK TABLES `excepciones_horario_sucursal` WRITE;
/*!40000 ALTER TABLE `excepciones_horario_sucursal` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `excepciones_horario_sucursal` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `servicio_personal`
--

DROP TABLE IF EXISTS `servicio_personal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `servicio_personal` (
  `servicio_id` bigint(20) unsigned NOT NULL,
  `personal_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`servicio_id`,`personal_id`),
  KEY `servicio_personal_personal_id_foreign` (`personal_id`),
  CONSTRAINT `servicio_personal_personal_id_foreign` FOREIGN KEY (`personal_id`) REFERENCES `personal` (`id`) ON DELETE CASCADE,
  CONSTRAINT `servicio_personal_servicio_id_foreign` FOREIGN KEY (`servicio_id`) REFERENCES `servicios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `servicio_personal`
--

LOCK TABLES `servicio_personal` WRITE;
/*!40000 ALTER TABLE `servicio_personal` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `servicio_personal` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `producto_promocion`
--

DROP TABLE IF EXISTS `producto_promocion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `producto_promocion` (
  `promocion_id` bigint(20) unsigned NOT NULL,
  `producto_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`promocion_id`,`producto_id`),
  KEY `producto_promocion_producto_id_foreign` (`producto_id`),
  CONSTRAINT `producto_promocion_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `producto_promocion_promocion_id_foreign` FOREIGN KEY (`promocion_id`) REFERENCES `promociones` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto_promocion`
--

LOCK TABLES `producto_promocion` WRITE;
/*!40000 ALTER TABLE `producto_promocion` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `producto_promocion` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `categorias`
--

DROP TABLE IF EXISTS `categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `categorias` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `tipo_categoria` varchar(50) NOT NULL COMMENT 'Ej: PRODUCTO, SERVICIO',
  `icono_clave` varchar(50) DEFAULT NULL COMMENT 'Clave para mapear a un icono en el frontend',
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categorias_nombre_unique` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias`
--

LOCK TABLES `categorias` WRITE;
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `imagen_path` varchar(255) DEFAULT NULL,
  `telefono` varchar(25) DEFAULT NULL,
  `rol` varchar(50) NOT NULL DEFAULT 'CLIENTE' COMMENT 'Ej: CLIENTE, EMPLEADO. Si es EMPLEADO, tiene un registro en la tabla `personal`',
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `musica_preferencia_navegacion_id` bigint(20) unsigned DEFAULT NULL,
  `sucursal_preferida_id` bigint(20) unsigned DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuarios_email_unique` (`email`),
  UNIQUE KEY `usuarios_telefono_unique` (`telefono`),
  KEY `usuarios_musica_preferencia_navegacion_id_foreign` (`musica_preferencia_navegacion_id`),
  KEY `usuarios_sucursal_preferida_id_foreign` (`sucursal_preferida_id`),
  CONSTRAINT `usuarios_musica_preferencia_navegacion_id_foreign` FOREIGN KEY (`musica_preferencia_navegacion_id`) REFERENCES `musica_preferencias_navegacion` (`id`) ON DELETE SET NULL,
  CONSTRAINT `usuarios_sucursal_preferida_id_foreign` FOREIGN KEY (`sucursal_preferida_id`) REFERENCES `sucursales` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `recordatorios`
--

DROP TABLE IF EXISTS `recordatorios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `recordatorios` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `usuario_id` bigint(20) unsigned NOT NULL,
  `agendamiento_id` bigint(20) unsigned DEFAULT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_hora_recordatorio` datetime NOT NULL,
  `canal_notificacion` varchar(50) NOT NULL DEFAULT 'EMAIL' COMMENT 'Ej: EMAIL, SMS, PUSH_NOTIFICATION',
  `enviado` tinyint(1) NOT NULL DEFAULT 0,
  `fecha_envio` datetime DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `fijado` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `recordatorios_usuario_id_foreign` (`usuario_id`),
  KEY `recordatorios_agendamiento_id_foreign` (`agendamiento_id`),
  CONSTRAINT `recordatorios_agendamiento_id_foreign` FOREIGN KEY (`agendamiento_id`) REFERENCES `agendamientos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `recordatorios_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recordatorios`
--

LOCK TABLES `recordatorios` WRITE;
/*!40000 ALTER TABLE `recordatorios` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `recordatorios` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `servicios`
--

DROP TABLE IF EXISTS `servicios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `servicios` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `imagen_path` varchar(255) DEFAULT NULL,
  `precio_base` decimal(10,2) NOT NULL,
  `duracion_minutos` int(10) unsigned NOT NULL,
  `categoria_id` bigint(20) unsigned DEFAULT NULL,
  `especialidad_requerida_id` bigint(20) unsigned DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `servicios_categoria_id_foreign` (`categoria_id`),
  KEY `servicios_especialidad_requerida_id_foreign` (`especialidad_requerida_id`),
  CONSTRAINT `servicios_categoria_id_foreign` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE SET NULL,
  CONSTRAINT `servicios_especialidad_requerida_id_foreign` FOREIGN KEY (`especialidad_requerida_id`) REFERENCES `especialidades` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `servicios`
--

LOCK TABLES `servicios` WRITE;
/*!40000 ALTER TABLE `servicios` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `servicios` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `promocion_servicio`
--

DROP TABLE IF EXISTS `promocion_servicio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `promocion_servicio` (
  `promocion_id` bigint(20) unsigned NOT NULL,
  `servicio_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`promocion_id`,`servicio_id`),
  KEY `promocion_servicio_servicio_id_foreign` (`servicio_id`),
  CONSTRAINT `promocion_servicio_promocion_id_foreign` FOREIGN KEY (`promocion_id`) REFERENCES `promociones` (`id`) ON DELETE CASCADE,
  CONSTRAINT `promocion_servicio_servicio_id_foreign` FOREIGN KEY (`servicio_id`) REFERENCES `servicios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `promocion_servicio`
--

LOCK TABLES `promocion_servicio` WRITE;
/*!40000 ALTER TABLE `promocion_servicio` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `promocion_servicio` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `promociones`
--

DROP TABLE IF EXISTS `promociones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `promociones` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(50) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `tipo_descuento` varchar(50) NOT NULL COMMENT 'Ej: PORCENTAJE, MONTO_FIJO',
  `valor_descuento` decimal(10,2) NOT NULL,
  `fecha_inicio` datetime NOT NULL,
  `fecha_fin` datetime DEFAULT NULL,
  `usos_maximos_total` int(10) unsigned DEFAULT NULL,
  `usos_maximos_por_cliente` int(10) unsigned DEFAULT 1,
  `usos_actuales` int(10) unsigned NOT NULL DEFAULT 0,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `aplica_a_todos_productos` tinyint(1) NOT NULL DEFAULT 0,
  `aplica_a_todos_servicios` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `promociones_codigo_unique` (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `promociones`
--

LOCK TABLES `promociones` WRITE;
/*!40000 ALTER TABLE `promociones` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `promociones` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `productos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `imagen_path` varchar(255) DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `stock` int(10) unsigned NOT NULL DEFAULT 0,
  `sku` varchar(100) DEFAULT NULL,
  `categoria_id` bigint(20) unsigned DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `productos_sku_unique` (`sku`),
  KEY `productos_categoria_id_foreign` (`categoria_id`),
  CONSTRAINT `productos_categoria_id_foreign` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;
commit;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2025-07-18 19:22:56

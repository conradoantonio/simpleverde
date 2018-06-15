/*
SQLyog Ultimate v9.63 
MySQL - 5.5.5-10.1.31-MariaDB : Database - nominas
*********************************************************************
*/


/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`nominas` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `nominas`;

/*Table structure for table `aditamentos` */

DROP TABLE IF EXISTS `aditamentos`;

CREATE TABLE `aditamentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `empleado_id` int(11) NOT NULL,
  `fornitura` tinyint(4) DEFAULT NULL,
  `tolete` tinyint(4) DEFAULT NULL,
  `gas` tinyint(4) DEFAULT NULL,
  `aros_aprehensores` tinyint(4) DEFAULT NULL,
  `radio` tinyint(4) DEFAULT NULL,
  `celular` tinyint(4) DEFAULT NULL,
  `lampara` tinyint(4) DEFAULT NULL,
  `otros` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `aditamentos` */

insert  into `aditamentos`(`id`,`empleado_id`,`fornitura`,`tolete`,`gas`,`aros_aprehensores`,`radio`,`celular`,`lampara`,`otros`,`created_at`,`updated_at`) values (1,3,1,1,1,1,1,1,1,'sdasdasd','2018-06-14 17:05:46','2018-06-14 17:05:46'),(2,2,1,1,1,0,0,0,0,'NO','2018-06-14 17:07:05','2018-06-14 22:07:05');

/*Table structure for table `asistencias` */

DROP TABLE IF EXISTS `asistencias`;

CREATE TABLE `asistencias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_pago_id` int(11) DEFAULT NULL,
  `dia` int(11) DEFAULT NULL,
  `status` varchar(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `asistencias` */

insert  into `asistencias`(`id`,`usuario_pago_id`,`dia`,`status`,`created_at`,`updated_at`) values (5,1,13,'X','2018-06-14 22:11:18','2018-06-14 22:11:18'),(6,1,14,'X','2018-06-14 22:11:18','2018-06-14 22:11:18'),(7,2,13,'X','2018-06-14 22:11:18','2018-06-14 22:11:18'),(8,2,14,'X','2018-06-14 22:11:18','2018-06-14 22:11:18');

/*Table structure for table `documentacion` */

DROP TABLE IF EXISTS `documentacion`;

CREATE TABLE `documentacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `empleado_id` int(11) DEFAULT NULL,
  `comprobante_domicilio` tinyint(4) DEFAULT NULL,
  `identificacion` tinyint(4) DEFAULT NULL,
  `curp` tinyint(4) DEFAULT NULL,
  `rfc` tinyint(4) DEFAULT NULL,
  `hoja_imss` tinyint(4) DEFAULT NULL,
  `carta_no_antecedentes_penales` tinyint(4) DEFAULT NULL,
  `acta_nacimiento` tinyint(4) DEFAULT NULL,
  `comprobante_estudios` tinyint(4) DEFAULT NULL,
  `resultado_psicometrias` tinyint(4) DEFAULT NULL,
  `examen_socieconomico` tinyint(4) DEFAULT NULL,
  `examen_toxicologico` tinyint(4) DEFAULT NULL,
  `solicitud_frente_vuelta` tinyint(4) DEFAULT NULL,
  `deposito_uniforme` tinyint(4) DEFAULT NULL,
  `constancia_recepcion_uniforme` tinyint(4) DEFAULT NULL,
  `comprobante_recepcion_reglamento_interno_trabajo` tinyint(4) DEFAULT NULL,
  `autorizacion_pago_tarjeta` tinyint(4) DEFAULT NULL,
  `carta_aceptacion_cambio_lugar` tinyint(4) DEFAULT NULL,
  `finiquito` tinyint(4) DEFAULT NULL,
  `calendario` tinyint(4) DEFAULT NULL,
  `formato_datos_personales` tinyint(4) DEFAULT NULL,
  `solicitud_autorizacion_consulta` tinyint(4) DEFAULT NULL,
  `licencia_conduccion` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `documentacion` */

insert  into `documentacion`(`id`,`empleado_id`,`comprobante_domicilio`,`identificacion`,`curp`,`rfc`,`hoja_imss`,`carta_no_antecedentes_penales`,`acta_nacimiento`,`comprobante_estudios`,`resultado_psicometrias`,`examen_socieconomico`,`examen_toxicologico`,`solicitud_frente_vuelta`,`deposito_uniforme`,`constancia_recepcion_uniforme`,`comprobante_recepcion_reglamento_interno_trabajo`,`autorizacion_pago_tarjeta`,`carta_aceptacion_cambio_lugar`,`finiquito`,`calendario`,`formato_datos_personales`,`solicitud_autorizacion_consulta`,`licencia_conduccion`,`created_at`,`updated_at`) values (1,1,1,1,1,1,1,1,1,1,1,1,1,0,0,0,0,0,0,0,0,0,0,NULL,'2017-11-21 23:28:19','2017-11-21 23:28:19'),(2,2,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,'','2017-11-21 23:30:09','2018-06-14 21:48:09'),(3,3,1,0,1,0,1,0,1,0,1,0,0,1,0,1,1,0,1,0,1,1,0,'','2018-06-14 16:56:35','2018-06-14 17:43:55');

/*Table structure for table `empleados` */

DROP TABLE IF EXISTS `empleados`;

CREATE TABLE `empleados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `apellido_paterno` varchar(50) DEFAULT NULL,
  `apellido_materno` varchar(50) DEFAULT NULL,
  `num_empleado` varchar(20) DEFAULT NULL,
  `num_cuenta` varchar(10) DEFAULT NULL,
  `domicilio` text,
  `ciudad` varchar(40) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `rfc` varchar(13) DEFAULT NULL,
  `curp` varchar(20) DEFAULT NULL,
  `nss` varchar(30) DEFAULT NULL,
  `telefono_emergencia` varchar(30) DEFAULT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `escolaridad` varchar(100) DEFAULT NULL,
  `infonavit` varchar(100) DEFAULT NULL,
  `vacaciones` varchar(100) DEFAULT NULL,
  `pensionado` varchar(100) DEFAULT NULL,
  `perfil_laboral` varchar(255) DEFAULT NULL,
  `fecha_baja` date DEFAULT NULL,
  `motivo_baja` varchar(255) DEFAULT NULL,
  `fecha_finiquito` date DEFAULT NULL,
  `descripcion_finiquito` varchar(255) DEFAULT NULL,
  `fecha_entrega_papeles` date DEFAULT NULL,
  `entrega_papeles` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `empleados` */

insert  into `empleados`(`id`,`nombre`,`apellido_paterno`,`apellido_materno`,`num_empleado`,`num_cuenta`,`domicilio`,`ciudad`,`telefono`,`rfc`,`curp`,`nss`,`telefono_emergencia`,`fecha_ingreso`,`escolaridad`,`infonavit`,`vacaciones`,`pensionado`,`perfil_laboral`,`fecha_baja`,`motivo_baja`,`fecha_finiquito`,`descripcion_finiquito`,`fecha_entrega_papeles`,`entrega_papeles`,`status`,`created_at`,`updated_at`) values (1,'CONRADO ANTONIO','CARRILLO','ROSALES','001','0016415225','Hector Hernández #5712 A Colonia Paseos del Sol','Zapopan','9801010','SARL600830L21','BEML920313HMCLNS09','45136684587745','6699854621',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2018-06-14 12:14:54','2018-06-14 17:14:54'),(2,'DANIELA','GONZÁLEZ','CASTRO','002','0025621598','Cuautitlán 211 Colonia Chapalita','Zapopan','9801010','SARL600830L21','BEML920313HMCLNS09','986562147','6699875632','2018-06-14','Universidad','NO','El 1 de septiembre cumple el año','NO','Buen perfil pesicológico','2018-06-15','Se portó mal >:v','2018-06-15','Se le dio su finiquito en cheque','2018-06-16','Todo en orden',1,'2018-06-14 17:07:05','2018-06-14 22:07:05'),(3,'EDGARD JOSÉ','VARGAS','FLORES','003','3127386128','Calle simón Bolivar #594','Guadalajara','6691549832','VECJ880326HNJ','BADD110313HCMLNS09','321','6698542398','2018-06-14','','','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'2018-06-14 16:34:25','2018-06-14 21:34:25');

/*Table structure for table `empresa_servicio` */

DROP TABLE IF EXISTS `empresa_servicio`;

CREATE TABLE `empresa_servicio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `empresa_id` int(11) DEFAULT NULL,
  `servicio` varchar(200) DEFAULT NULL,
  `horario` varchar(200) DEFAULT NULL,
  `sueldo` decimal(10,0) DEFAULT NULL,
  `sueldo_diario_guardia` decimal(6,2) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `empresa_servicio` */

insert  into `empresa_servicio`(`id`,`empresa_id`,`servicio`,`horario`,`sueldo`,`sueldo_diario_guardia`,`status`,`created_at`,`updated_at`) values (1,1,'01 de 24x24 hrs','1 servicio de lunes a viernes de 7:00 a 7:00','2600','300.50',1,'2017-12-14 11:35:13','2017-12-13 17:22:52');

/*Table structure for table `empresas` */

DROP TABLE IF EXISTS `empresas`;

CREATE TABLE `empresas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `oficina_cargo` varchar(100) DEFAULT NULL,
  `direccion` text,
  `contacto` varchar(100) DEFAULT NULL,
  `telefono` varchar(18) DEFAULT NULL,
  `marcacion_corta` varchar(10) DEFAULT NULL,
  `contrato` varchar(100) DEFAULT NULL,
  `numero_elementos` varchar(100) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_termino` date DEFAULT NULL,
  `observaciones` text,
  `rfc` varchar(15) DEFAULT NULL,
  `tipo_pago` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `empresas` */

insert  into `empresas`(`id`,`nombre`,`oficina_cargo`,`direccion`,`contacto`,`telefono`,`marcacion_corta`,`contrato`,`numero_elementos`,`fecha_inicio`,`fecha_termino`,`observaciones`,`rfc`,`tipo_pago`,`status`,`created_at`,`updated_at`) values (1,'Bridge Studio','Guadalajara, Jal','Colonia Chapalita, Cuautitlan','Edgard','33658974','116','2 Meses','40','2018-01-14','2018-01-15','Buen cliente','VECJ880326TGH','Quincenal',1,'2018-06-13 12:06:55','2018-06-14 10:20:02');

/*Table structure for table `pagos` */

DROP TABLE IF EXISTS `pagos`;

CREATE TABLE `pagos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `empresa_id` int(11) NOT NULL,
  `servicio_id` int(11) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date DEFAULT NULL,
  `num_empleados` varchar(50) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `pagos` */

insert  into `pagos`(`id`,`empresa_id`,`servicio_id`,`fecha_inicio`,`fecha_fin`,`num_empleados`,`status`,`created_at`,`updated_at`) values (1,1,1,'2018-06-13','2018-06-14','21',0,'2018-06-14 17:11:22',NULL);

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rol` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `roles` */

insert  into `roles`(`id`,`rol`) values (1,'Administrador'),(2,'Nóminas'),(3,'Recepción'),(4,'Captura (empleados)'),(5,'Captura (clientes)');

/*Table structure for table `uniformes` */

DROP TABLE IF EXISTS `uniformes`;

CREATE TABLE `uniformes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `empleado_id` int(11) NOT NULL,
  `playera_polo` tinyint(4) DEFAULT NULL,
  `camisa` tinyint(4) DEFAULT NULL,
  `pantalones` tinyint(4) DEFAULT NULL,
  `chaleco` tinyint(4) DEFAULT NULL,
  `sueter` tinyint(4) DEFAULT NULL,
  `chamarra` tinyint(4) DEFAULT NULL,
  `gorra` tinyint(4) DEFAULT NULL,
  `botas` tinyint(4) DEFAULT NULL,
  `traje` tinyint(4) DEFAULT NULL,
  `corbata` tinyint(4) DEFAULT NULL,
  `otros` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `uniformes` */

insert  into `uniformes`(`id`,`empleado_id`,`playera_polo`,`camisa`,`pantalones`,`chaleco`,`sueter`,`chamarra`,`gorra`,`botas`,`traje`,`corbata`,`otros`,`created_at`,`updated_at`) values (1,3,0,1,0,0,1,0,0,1,0,0,'asdasdasd','2018-06-14 17:05:46','2018-06-14 17:05:46'),(2,2,1,0,1,0,1,0,1,0,1,0,'NO','2018-06-14 17:07:05','2018-06-14 22:07:05');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(255) NOT NULL,
  `password` varchar(60) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `foto_usuario` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `role_id` tinyint(4) DEFAULT '1',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `users` */

insert  into `users`(`id`,`user`,`password`,`email`,`foto_usuario`,`remember_token`,`role_id`,`status`,`created_at`,`updated_at`) values (1,'admin','$2y$10$UpoeuWNzFK8yZ5D8ErdMl.u4Qu6n7qyQS7RvuWYIyvIYmWNN8gJJ2','anton_con@hotmail.com','img/user_perfil/default.jpg','MhLGk8z7qGI7yMeWALfyQEfMcGYd7wDs1MThG2yNrQHTApGXk3ghU0QxTX0T',1,1,'2017-03-23 11:30:45','2018-01-15 16:49:17'),(2,'nomina','$2y$10$oOcNC86L3Wz9C4QEDBvtPO5tUiM1XhdoAA8U3gJk4BwYD4Zjov1OW','nomina@topali.com','img/user_perfil/default.jpg','Fht9CjGGx9vmdaFCSeDazmuJB7G5yDnguZOUPlN5FvDWcTYnrdGw3VKpTEEj',2,1,'2018-01-15 12:27:49','2018-01-15 18:38:59'),(3,'recepcion','$2y$10$dgshy7FS/T2JO8NjlvoEa.gs0wMo2WJ9oeXXRZlWgidkN/QVVgROy','recepcion@topali.com','img/user_perfil/default.jpg','EFaOXF4hCEfi88jeg4lKPYNAk4F5i9B5DaJmkp74GImFVz5sfP8mgcHIolKa',3,1,'2018-01-15 12:37:15','2018-01-15 18:41:37'),(4,'captura.empleado','$2y$10$vNdpi6CddMTyCZ2/fgUf0uNfyRB5D36TdkpmrI.l.CBxROqGTuz/K','cap_empleado@topali.com','img/user_perfil/default.jpg','3T8PjawO0B6qw5mMinOLR5sfULvnEnGFfuDnKgz56yjoccs1tdCMSC37H0pt',4,1,'2018-01-15 12:37:44','2018-01-15 21:16:23'),(5,'captura.cliente','$2y$10$uBPZ.NY28Mm/ifWl2Boyce0W6Jcm2aSXecf.jo8pxuDpq/PMyveIe','cap_cliente@topali.com','img/user_perfil/default.jpg',NULL,5,1,'2018-01-15 12:38:06','2018-01-15 12:38:06');

/*Table structure for table `usuario_pagos` */

DROP TABLE IF EXISTS `usuario_pagos`;

CREATE TABLE `usuario_pagos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trabajador_id` int(11) NOT NULL,
  `pago_id` int(11) DEFAULT NULL,
  `notas` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `usuario_pagos` */

insert  into `usuario_pagos`(`id`,`trabajador_id`,`pago_id`,`notas`) values (1,1,1,NULL),(2,2,1,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

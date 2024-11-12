/*
SQLyog Ultimate v11.42 (64 bit)
MySQL - 5.7.32-log : Database - andercode_helpdesk
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`andercode_helpdesk` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci */;

USE `andercode_helpdesk`;

/*Table structure for table `cargo` */

DROP TABLE IF EXISTS `cargo`;

CREATE TABLE `cargo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripción` varchar(250) COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

/*Data for the table `cargo` */

insert  into `cargo`(`id`,`descripción`) values (0,'Administrador'),(1,'Usuario');

/*Table structure for table `estatus` */

DROP TABLE IF EXISTS `estatus`;

CREATE TABLE `estatus` (
  `id_estatus` int(10) NOT NULL AUTO_INCREMENT,
  `descrip_estatus` varchar(50) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_estatus`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

/*Data for the table `estatus` */

insert  into `estatus`(`id_estatus`,`descrip_estatus`) values (1,'Activo'),(2,'Cerrado');

/*Table structure for table `td_documento` */

DROP TABLE IF EXISTS `td_documento`;

CREATE TABLE `td_documento` (
  `doc_id` int(11) NOT NULL AUTO_INCREMENT,
  `tick_id` int(11) DEFAULT NULL,
  `doc_nom` varchar(400) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `fech_crea` datetime DEFAULT NULL,
  `est` int(11) DEFAULT NULL,
  KEY `doc_id` (`doc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

/*Data for the table `td_documento` */

insert  into `td_documento`(`doc_id`,`tick_id`,`doc_nom`,`fech_crea`,`est`) values (14,14,'Captura de pantalla 2024-10-28 134217.png','2024-11-04 11:43:22',1),(15,15,'Captura de pantalla 2024-08-06 131831.png','2024-11-05 10:18:14',1),(16,16,'Captura de pantalla 2024-11-12 132157.png','2024-11-12 13:10:56',1);

/*Table structure for table `td_documento_detalle` */

DROP TABLE IF EXISTS `td_documento_detalle`;

CREATE TABLE `td_documento_detalle` (
  `det_id` int(11) NOT NULL AUTO_INCREMENT,
  `tickd_id` int(11) DEFAULT NULL,
  `det_nom` varchar(200) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `est` int(11) DEFAULT NULL,
  KEY `det_id` (`det_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

/*Data for the table `td_documento_detalle` */

/*Table structure for table `td_ticketdetalle` */

DROP TABLE IF EXISTS `td_ticketdetalle`;

CREATE TABLE `td_ticketdetalle` (
  `tickd_id` int(11) NOT NULL AUTO_INCREMENT,
  `tick_id` int(11) NOT NULL,
  `usu_id` int(11) NOT NULL,
  `tickd_descrip` mediumtext COLLATE utf8mb4_spanish_ci NOT NULL,
  `fech_crea` datetime NOT NULL,
  `descrip_estatus` int(11) NOT NULL,
  PRIMARY KEY (`tickd_id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

/*Data for the table `td_ticketdetalle` */

insert  into `td_ticketdetalle`(`tickd_id`,`tick_id`,`usu_id`,`tickd_descrip`,`fech_crea`,`descrip_estatus`) values (32,14,122,'<p>adaddada</p>','2024-11-04 11:44:05',1),(33,14,122,'problema resuelto','2024-11-04 11:54:37',1),(35,16,122,'<p>que puedo hacer? porque no me responden</p>','2024-11-12 13:11:51',1);

/*Table structure for table `tm_categoria` */

DROP TABLE IF EXISTS `tm_categoria`;

CREATE TABLE `tm_categoria` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_nom` varchar(150) COLLATE utf8mb4_spanish_ci NOT NULL,
  `est` int(11) NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

/*Data for the table `tm_categoria` */

insert  into `tm_categoria`(`cat_id`,`cat_nom`,`est`) values (1,'Bienes Informáticos',1),(2,'Sistemas - Office',1),(3,'Incidencia',1),(4,'petición de servicio',1),(5,'Redes/Internet',1),(6,'Carpeta compartida',1);

/*Table structure for table `tm_notificacion` */

DROP TABLE IF EXISTS `tm_notificacion`;

CREATE TABLE `tm_notificacion` (
  `not_id` int(11) NOT NULL AUTO_INCREMENT,
  `usu_id` int(11) DEFAULT NULL,
  `not_mensaje` varchar(400) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `tick_id` int(11) DEFAULT NULL,
  `est` int(11) DEFAULT NULL,
  KEY `not_id` (`not_id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

/*Data for the table `tm_notificacion` */

insert  into `tm_notificacion`(`not_id`,`usu_id`,`not_mensaje`,`tick_id`,`est`) values (41,122,'Se le ha asignado el ticket Nro : ',14,2),(42,122,'Tiene una nueva respuesta de soporte del ticket Nro : ',14,2),(43,122,'Tiene una nueva respuesta de soporte del ticket Nro : ',14,2),(44,122,'Tiene una nueva respuesta de soporte del ticket Nro : ',14,2),(45,122,'Tiene una nueva respuesta de soporte del ticket Nro : ',16,2),(46,150,'Se le ha asignado el ticket Nro : ',16,2);

/*Table structure for table `tm_prioridad` */

DROP TABLE IF EXISTS `tm_prioridad`;

CREATE TABLE `tm_prioridad` (
  `prio_id` int(11) NOT NULL AUTO_INCREMENT,
  `prio_nom` varchar(100) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `est` int(11) DEFAULT NULL,
  KEY `prio_id` (`prio_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

/*Data for the table `tm_prioridad` */

insert  into `tm_prioridad`(`prio_id`,`prio_nom`,`est`) values (1,'Bajo',1),(2,'Medio',1),(3,'Alto',1);

/*Table structure for table `tm_subcategoria` */

DROP TABLE IF EXISTS `tm_subcategoria`;

CREATE TABLE `tm_subcategoria` (
  `cats_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) DEFAULT NULL,
  `cats_nom` varchar(150) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `est` int(11) DEFAULT NULL,
  KEY `cats_id` (`cats_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

/*Data for the table `tm_subcategoria` */

insert  into `tm_subcategoria`(`cats_id`,`cat_id`,`cats_nom`,`est`) values (1,1,'CPU',1),(2,1,'Monitor',1),(3,1,'Teclado',1),(4,1,'Mouse',1),(5,1,'Regulador',1),(6,1,'Impresora',1),(7,1,'Teléfono',1),(8,1,'Fotocopiadora',1),(9,2,'Word',1),(10,2,'Nitro',1),(11,2,'Excel',1),(12,2,'PowerPoint',1),(13,2,'Antivirus',1),(14,2,'Navegador Web',1),(15,5,'Lentitud',1),(16,5,'Desconeccion recurrente',1),(17,4,'Formula en Excel',1),(18,4,'Dar Formato a un Dcumento',1),(19,NULL,NULL,1);

/*Table structure for table `tm_ticket` */

DROP TABLE IF EXISTS `tm_ticket`;

CREATE TABLE `tm_ticket` (
  `tick_id` int(11) NOT NULL AUTO_INCREMENT,
  `usu_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `cats_id` int(11) DEFAULT NULL,
  `tick_titulo` varchar(250) COLLATE utf8mb4_spanish_ci NOT NULL,
  `tick_descrip` mediumtext COLLATE utf8mb4_spanish_ci NOT NULL,
  `fech_crea` datetime DEFAULT NULL,
  `fk_estatus` int(11) DEFAULT '1',
  `fech_asig` datetime DEFAULT NULL,
  `tick_estre` int(11) DEFAULT '0',
  `tick_coment` varchar(300) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `fech_cierre` datetime DEFAULT NULL,
  `usu_asig` int(11) DEFAULT NULL,
  PRIMARY KEY (`tick_id`),
  KEY `fk_estatus` (`fk_estatus`),
  CONSTRAINT `tm_ticket_ibfk_1` FOREIGN KEY (`fk_estatus`) REFERENCES `estatus` (`id_estatus`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

/*Data for the table `tm_ticket` */

insert  into `tm_ticket`(`tick_id`,`usu_id`,`cat_id`,`cats_id`,`tick_titulo`,`tick_descrip`,`fech_crea`,`fk_estatus`,`fech_asig`,`tick_estre`,`tick_coment`,`fech_cierre`,`usu_asig`) values (14,122,5,16,'AYUDA CON MI EQUIPO','<p>Prendo mi equipo de computo y no esta activo el fondo de pantalla y no tiene internet&nbsp;</p>','2024-11-04 11:43:21',2,'2024-11-04 11:43:45',0,NULL,'2024-11-12 13:15:43',122),(15,122,2,10,'tiket prueba','<p><i>tiket de prueba</i></p>','2024-11-05 10:18:14',1,NULL,0,NULL,NULL,NULL),(16,122,5,16,'Ticket de falla en el modem','<p>mi internet se desconecta cuando muevo el cable c:</p>','2024-11-12 13:10:56',1,'2024-11-12 13:15:56',0,NULL,NULL,150),(17,150,1,1,'No me funciona el CPU','<p>No prende mi computador y no cargan las luces de encendido en el botón</p>','2024-11-12 14:20:31',1,NULL,0,NULL,NULL,NULL);

/* Procedure structure for procedure `filtrar_ticket` */

/*!50003 DROP PROCEDURE IF EXISTS  `filtrar_ticket` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`user_helpdesk`@`%` PROCEDURE `filtrar_ticket`(
in tick_titulo varchar(50),
in cat_id int)
BEGIN
IF tick_titulo = '' THEN
SET tick_titulo =NULL;
END IF;

IF cat_id = '' THEN
SET cat_id =NULL;
END IF;
SELECT
            tm_ticket.tick_id,
            tm_ticket.usu_id,
            tm_ticket.cat_id,
            tm_ticket.tick_titulo,
            tm_ticket.tick_descrip,
            tm_ticket.fech_crea,
            tm_ticket.usu_asig,
            tm_ticket.fech_asig,  
            tm_usuario.usu_nom,
            tm_usuario.usu_ape,
            tm_categoria.cat_nom,
            estatus.descrip_estatus
            FROM 
            tm_ticket
            INNER JOIN tm_categoria ON tm_ticket.cat_id = tm_categoria.cat_id
            INNER JOIN tm_usuario ON tm_ticket.usu_id = tm_usuario.usu_id
            INNER JOIN estatus ON tm_ticket.fk_estatus = estatus.id_estatus
            WHERE
             estatus.descrip_estatus = ''
            AND tm_ticket.tick_titulo like IFNULL (null,tm_ticket.tick_titulo)
            AND tm_ticket.cat_id = IFNULL (null,tm_ticket.cat_id);
END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_i_ticketdetalle_01` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_i_ticketdetalle_01` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`user_helpdesk`@`%` PROCEDURE `sp_i_ticketdetalle_01`(
	IN xtick_id INT,
    IN xusu_id INT
)
BEGIN
	INSERT INTO 
                td_ticketdetalle   
                    SET 
                        tickd_id =$xtick_id,
                        usu_id=$xusu_id,
                        tickd_descrip=$tickd_descrip,
                        fech_crea=NOW(),
                        descrip_estatus=1;
END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_l_usuario_01` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_l_usuario_01` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`user_helpdesk`@`%` PROCEDURE `sp_l_usuario_01`()
BEGIN
	SELECT * FROM tm_usuario where est='1';
END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_l_usuario_02` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_l_usuario_02` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`user_helpdesk`@`%` PROCEDURE `sp_l_usuario_02`(
	in xusu_id int
)
BEGIN
	SELECT * FROM tm_usuario where usu_id=xusu_id;
END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

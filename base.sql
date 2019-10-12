# Host: localhost  (Version 5.5.5-10.1.37-MariaDB-0+deb9u1)
# Date: 2018-12-06 05:34:42
# Generator: MySQL-Front 6.1  (Build 1.26)


#
# Structure for table "artists"
#

DROP TABLE IF EXISTS `artists`;
CREATE TABLE `artists` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `addedBy` int(11) DEFAULT NULL,
  `added` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

#
# Data for table "artists"
#

INSERT INTO `artists` VALUES (1,'AC/DC',1,'2018-12-02 04:10:55'),(2,'Green Day',1,'2018-12-03 00:45:50'),(6,'Blue Man Group',1,'2018-12-03 02:05:55'),(7,'Green Day',1,'2018-12-06 03:38:36'),(8,'Laurent Baffie',1,'2018-12-06 03:46:37'),(9,'CONMEBOL',1,'2018-12-06 04:16:00');

#
# Structure for table "eventInstances"
#

DROP TABLE IF EXISTS `eventInstances`;
CREATE TABLE `eventInstances` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `eventId` int(11) NOT NULL DEFAULT '0',
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tickets` int(11) DEFAULT NULL,
  `ticketsSold` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

#
# Data for table "eventInstances"
#

INSERT INTO `eventInstances` VALUES (1,1,'2018-12-08','21:00:00','2018-11-30 04:09:56',30000,10855),(2,1,'2018-12-10','21:30:00','2018-11-30 04:10:05',15000,30000),(3,1,'2018-12-09','21:00:00','2018-12-04 19:59:22',30000,0),(4,6,'2018-12-10','21:30:00','2018-12-05 00:13:31',12,0),(5,1,'1912-12-12','12:12:00','2018-12-05 01:52:16',1212,0),(6,26,'2019-01-03','22:00:00','2018-12-06 03:34:48',450,0),(7,26,'2019-01-04','22:00:00','2018-12-06 03:34:48',450,2),(8,26,'2019-01-05','22:00:00','2018-12-06 03:34:48',450,0),(9,26,'2019-01-06','22:00:00','2018-12-06 03:34:48',450,0),(10,28,'2018-12-15','21:00:00','2018-12-06 03:48:49',500,1),(11,28,'2018-12-22','21:00:00','2018-12-06 03:48:49',500,0),(12,28,'2018-12-29','21:00:00','2018-12-06 03:48:49',500,0),(13,28,'2019-01-05','21:00:00','2018-12-06 03:48:49',500,0),(14,28,'2019-01-12','21:00:00','2018-12-06 03:48:49',500,0),(15,28,'2019-01-19','21:00:00','2018-12-06 03:48:49',500,0),(16,28,'2019-01-26','21:00:00','2018-12-06 03:48:49',500,0),(22,27,'2018-12-30','18:00:00','2018-12-06 03:51:19',3000,5),(23,29,'2018-12-09','16:30:00','2018-12-06 04:20:12',25,1);

#
# Structure for table "events"
#

DROP TABLE IF EXISTS `events`;
CREATE TABLE `events` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `description` text,
  `ticketprice` float NOT NULL DEFAULT '0',
  `artistId` int(11) DEFAULT NULL,
  `locationId` int(255) DEFAULT NULL,
  `imgcover` varchar(80) DEFAULT NULL,
  `eventType` int(2) NOT NULL DEFAULT '0',
  `adminId` int(11) NOT NULL DEFAULT '0',
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4;

#
# Data for table "events"
#

INSERT INTO `events` VALUES (1,'AC/DC: The Razor\'s Edge','AC/DC vuelve a la Argentina después de ocho años para repetir uno de sus espectáculos más memorables.',800,1,1,'b0f47444b982d81822ccc253bd9ce073.jpg',1,1,'2018-11-30 05:29:02'),(26,'Blue Man Experience','Son calvos, son azules, y te harán reír. Embárcate en esta extraña aventura y conoce su mundo.',600,6,7,'95c0072b39123b5b9a5585b5a86840f5.jpg',2,1,'2018-12-05 13:56:35'),(27,'Green Day: World Tour','Green Day deslumbra a la Argentina durante su gira mundial.',650,7,5,'0b21822215b29f188346542bb4f9f14a.jpg',1,1,'2018-12-06 03:42:03'),(28,'Toc Toc: ¡Obsesivamente divertida!','Un grupo de pacientes con Trastorno Obsesivo Compulsivo coinciden en la sala de espera de la consulta de un gran psicólogo. El médico se retrasa por un problema con su avión, por lo que todos tendrán que esperar juntos intentando mantener a raya sus manías, impulsos, obsesiones y rituales.',400,8,4,'a7456253bd24bd59bcdf8975624fd54c.jpg',2,1,'2018-12-06 03:48:49'),(29,'Superfinal: River Plate vs Boca Juniors','Vive la final de la Copa CONMEBOL Libertadores en Madrid.\r\nPasaje de avión y alojamiento no incluidos. Huso horario de Argentina.',45000,9,6,'94d0f08d142df32b285ee2e9c116e06f.jpg',3,1,'2018-12-06 04:20:12');

#
# Structure for table "eventTypes"
#

DROP TABLE IF EXISTS `eventTypes`;
CREATE TABLE `eventTypes` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

#
# Data for table "eventTypes"
#

INSERT INTO `eventTypes` VALUES (1,'Concierto'),(2,'Teatro'),(3,'Espectáculo deportivo');

#
# Structure for table "frontPage"
#

DROP TABLE IF EXISTS `frontPage`;
CREATE TABLE `frontPage` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `desc` varchar(255) DEFAULT NULL,
  `eventId` int(11) NOT NULL DEFAULT '0',
  `isFrontVideo` int(1) NOT NULL DEFAULT '0',
  `frontFile` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

#
# Data for table "frontPage"
#

INSERT INTO `frontPage` VALUES (1,'AC/DC','8, 9 y 10 de Diciembre - Estadio Monumental',1,1,'83fb2013a85eec4973da1302e8af87f2.mp4'),(2,'Blue Man Group','3, 4, 5 y 6 de Diciembre - Teatro Gran Rex',26,1,'929e2d0605b0531e3065c7879e638900.mp4'),(3,'Green Day','30 de Diciembre<br/>¡Única función!',27,0,'0b21822215b29f188346542bb4f9f14a.jpg');

#
# Structure for table "locations"
#

DROP TABLE IF EXISTS `locations`;
CREATE TABLE `locations` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `lat` double NOT NULL DEFAULT '0',
  `lon` double NOT NULL DEFAULT '0',
  `addresstext` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) DEFAULT NULL,
  `addedBy` int(11) DEFAULT NULL,
  `added` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

#
# Data for table "locations"
#

INSERT INTO `locations` VALUES (1,-34.545320000000004,-58.44973999999999,'Av. Pres. Figueroa Alcorta 7597','Estadio Monumental',NULL,'2018-12-03 02:17:00'),(4,-34.6042735,-58.3884975,'Av. Corrientes 1530','Teatro General José de San Martín',1,'2018-12-03 02:39:56'),(5,-34.602021,-58.3705487,'Av. Eduardo Madero 420','Luna Park',1,'2018-12-06 03:40:26'),(6,40.4530541,-3.6883445,'Av. de Concha Espina, 1, 28036, Madrid','Estadio Santiago Bernabéu',1,'2018-12-06 04:15:44'),(7,-34.603449,-58.3811517,'Av. Corrientes 857','Teatro Gran Rex',1,'2018-12-06 04:34:57');

#
# Structure for table "ticketsSold"
#

DROP TABLE IF EXISTS `ticketsSold`;
CREATE TABLE `ticketsSold` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `eventInstanceId` int(11) DEFAULT NULL,
  `when` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ownerId` int(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

#
# Data for table "ticketsSold"
#


#
# Structure for table "users"
#

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `surname` varchar(45) DEFAULT NULL,
  `mail` varchar(45) DEFAULT NULL,
  `password` varchar(60) DEFAULT NULL,
  `confirmationKey` varchar(32) DEFAULT NULL,
  `usertype` int(1) DEFAULT '0',
  `createdAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

#
# Data for table "users"
#


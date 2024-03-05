-- bhlxwvmh8s7krbir0jfv.fastreading_cat_idiomas definition

CREATE TABLE `fastreading_cat_idiomas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `IDIOMA` varchar(3) DEFAULT NULL,
  `HTML_ICON` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- bhlxwvmh8s7krbir0jfv.fastreading_r_libros_grupos definition

CREATE TABLE `fastreading_r_libros_grupos` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ID_LIBRO` int(11) DEFAULT NULL,
  `ID_GRUPO` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- bhlxwvmh8s7krbir0jfv.fastreading_r_usuarios_libros_favoritos definition

CREATE TABLE `fastreading_r_usuarios_libros_favoritos` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ID_USUARIO` int(11) NOT NULL,
  `ID_LIBRO` int(11) NOT NULL,
  `FECHA_CREADO` datetime NOT NULL DEFAULT current_timestamp(),
  `FECHA_ACTUALIZADO` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- bhlxwvmh8s7krbir0jfv.fastreading_t_libros definition

CREATE TABLE `fastreading_t_libros` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TÍTULO` varchar(255) DEFAULT NULL,
  `ID_IDIOMA` int(11) DEFAULT NULL,
  `RESEÑA` mediumtext DEFAULT NULL,
  `FECHA_CREADO` datetime NOT NULL DEFAULT current_timestamp(),
  `FECHA_ACTUALIZADO` datetime NOT NULL DEFAULT current_timestamp(),
  `MODIFICADO_POR` int(11) NOT NULL DEFAULT 1,
  `PORTADA_URL` varchar(100) NOT NULL DEFAULT 'https://placehold.co/400x600',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- bhlxwvmh8s7krbir0jfv.fastreading_t_libros_capítulos definition

CREATE TABLE `fastreading_t_libros_capítulos` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TÍTULO` varchar(255) DEFAULT NULL,
  `ID_LIBRO` int(11) DEFAULT NULL,
  `ARCHIVO_JSON` varchar(255) DEFAULT NULL,
  `FECHA_MODIFICADO` datetime NOT NULL DEFAULT current_timestamp(),
  `TEXTO` text DEFAULT NULL,
  `NO_CAPÍTULO` float NOT NULL,
  `FECHA_ACTUALIZADO` datetime NOT NULL DEFAULT current_timestamp(),
  `FECHA_CREADO` datetime NOT NULL DEFAULT current_timestamp(),
  `MODIFICADO_POR` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- bhlxwvmh8s7krbir0jfv.fastreading_t_usuarios definition

CREATE TABLE `fastreading_t_usuarios` (
  `PERSONA_NOMBRE` varchar(100) DEFAULT NULL,
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `PERSONA_PA` varchar(100) DEFAULT NULL,
  `PERSONA_SA` varchar(100) DEFAULT NULL,
  `USUARIO_NOMBRE` varchar(100) DEFAULT NULL,
  `USUARIO_FOTO` varchar(100) DEFAULT NULL,
  `ACTIVO` smallint(1) NOT NULL DEFAULT 1,
  `PW` varchar(100) DEFAULT NULL,
  `USUARIO_CORREO` varchar(100) DEFAULT NULL,
  `FECHA_CREADO` datetime NOT NULL DEFAULT current_timestamp(),
  `FECHA_ACTUALIZADO` datetime NOT NULL DEFAULT current_timestamp(),
  `MODIFICADO_POR` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
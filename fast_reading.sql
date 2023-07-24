/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 100428
 Source Host           : localhost:3306
 Source Schema         : fast_reading

 Target Server Type    : MySQL
 Target Server Version : 100428
 File Encoding         : 65001

 Date: 24/07/2023 17:31:09
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for cat_idiomas
-- ----------------------------
DROP TABLE IF EXISTS `cat_idiomas`;
CREATE TABLE `cat_idiomas`  (
  `ID` int NOT NULL AUTO_INCREMENT,
  `IDIOMA` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `HTML_ICON` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for r_libros_grupos
-- ----------------------------
DROP TABLE IF EXISTS `r_libros_grupos`;
CREATE TABLE `r_libros_grupos`  (
  `ID` int NOT NULL AUTO_INCREMENT,
  `ID_LIBRO` int NULL DEFAULT NULL,
  `ID_GRUPO` int NULL DEFAULT NULL,
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for t_libros
-- ----------------------------
DROP TABLE IF EXISTS `t_libros`;
CREATE TABLE `t_libros`  (
  `ID` int NOT NULL AUTO_INCREMENT,
  `TÍTULO` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `ID_IDIOMA` int NULL DEFAULT NULL,
  `RESEÑA` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 34 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for t_libros_capítulos
-- ----------------------------
DROP TABLE IF EXISTS `t_libros_capítulos`;
CREATE TABLE `t_libros_capítulos`  (
  `ID` int NOT NULL AUTO_INCREMENT,
  `TÍTULO` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `ID_LIBRO` int NULL DEFAULT NULL,
  `ARCHIVO_JSON` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `FECHA_MODIFICADO` datetime NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;

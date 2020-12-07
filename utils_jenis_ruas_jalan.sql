/*
 Navicat Premium Data Transfer

 Source Server         : MySQLLocal
 Source Server Type    : MySQL
 Source Server Version : 100414
 Source Host           : localhost:3306
 Source Schema         : teman_jabar

 Target Server Type    : MySQL
 Target Server Version : 100414
 File Encoding         : 65001

 Date: 03/12/2020 17:20:55
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for utils_jenis_ruas_jalan
-- ----------------------------
DROP TABLE IF EXISTS `utils_jenis_ruas_jalan`;
CREATE TABLE `utils_jenis_ruas_jalan`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `desc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of utils_jenis_ruas_jalan
-- ----------------------------
INSERT INTO `utils_jenis_ruas_jalan` VALUES (1, 'pembangunan', 'Pembangunan Jalan dll.');
INSERT INTO `utils_jenis_ruas_jalan` VALUES (2, 'rehabilitasi', 'Rehabilitasi jalan');
INSERT INTO `utils_jenis_ruas_jalan` VALUES (3, 'peningkatan', 'Peningkatan jalan');
INSERT INTO `utils_jenis_ruas_jalan` VALUES (4, 'pemeliharaan', 'Pemeliharaan berkala');

SET FOREIGN_KEY_CHECKS = 1;

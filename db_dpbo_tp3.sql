/*
 Navicat Premium Data Transfer

 Source Server         : Local Mysql (XAMPP)
 Source Server Type    : MySQL
 Source Server Version : 100427 (10.4.27-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : db_dpbo_tp3

 Target Server Type    : MySQL
 Target Server Version : 100427 (10.4.27-MariaDB)
 File Encoding         : 65001

 Date: 25/05/2023 23:59:39
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for coaches
-- ----------------------------
DROP TABLE IF EXISTS `coaches`;
CREATE TABLE `coaches`  (
  `coach_id` int NOT NULL AUTO_INCREMENT,
  `coach_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `coach_nationality` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `team_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`coach_id`) USING BTREE,
  INDEX `team_id`(`team_id` ASC) USING BTREE,
  CONSTRAINT `coaches_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `teams` (`team_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of coaches
-- ----------------------------
INSERT INTO `coaches` VALUES (1, 'Ole Gunnar Solskjaer', 'Norwegian', 1);
INSERT INTO `coaches` VALUES (2, 'Jürgen Klopp', 'German', 2);
INSERT INTO `coaches` VALUES (3, 'Thomas Tuchel', 'German', 3);

-- ----------------------------
-- Table structure for matches
-- ----------------------------
DROP TABLE IF EXISTS `matches`;
CREATE TABLE `matches`  (
  `match_id` int NOT NULL AUTO_INCREMENT,
  `home_team_id` int NULL DEFAULT NULL,
  `away_team_id` int NULL DEFAULT NULL,
  `match_date` date NULL DEFAULT NULL,
  `match_location` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `home_team_score` int NULL DEFAULT NULL,
  `away_team_score` int NULL DEFAULT NULL,
  PRIMARY KEY (`match_id`) USING BTREE,
  INDEX `home_team_id`(`home_team_id` ASC) USING BTREE,
  INDEX `away_team_id`(`away_team_id` ASC) USING BTREE,
  CONSTRAINT `matches_ibfk_1` FOREIGN KEY (`home_team_id`) REFERENCES `teams` (`team_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `matches_ibfk_2` FOREIGN KEY (`away_team_id`) REFERENCES `teams` (`team_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of matches
-- ----------------------------
INSERT INTO `matches` VALUES (1, 1, 2, '2023-01-01', 'Old Trafford', 2, 1);
INSERT INTO `matches` VALUES (2, 2, 3, '2023-02-01', 'Anfield', 0, 0);
INSERT INTO `matches` VALUES (3, 3, 1, '2023-03-01', 'Stamford Bridge', 1, 1);
INSERT INTO `matches` VALUES (4, 2, 1, '2023-05-11', 'Anfield', 3, 4);
INSERT INTO `matches` VALUES (5, 4, 1, '2023-05-05', '02 Stadium', 2, 1);

-- ----------------------------
-- Table structure for players
-- ----------------------------
DROP TABLE IF EXISTS `players`;
CREATE TABLE `players`  (
  `player_id` int NOT NULL AUTO_INCREMENT,
  `player_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `player_position` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `player_birthdate` date NULL DEFAULT NULL,
  `team_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`player_id`) USING BTREE,
  INDEX `team_id`(`team_id` ASC) USING BTREE,
  CONSTRAINT `players_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `teams` (`team_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of players
-- ----------------------------
INSERT INTO `players` VALUES (1, 'Harry Kane', 'Forward', '1993-07-28', 1);
INSERT INTO `players` VALUES (2, 'Mohamed Salah', 'Forward', '1992-06-15', 2);
INSERT INTO `players` VALUES (3, 'NGolo Kante', 'Midfielder', '1991-03-29', 3);

-- ----------------------------
-- Table structure for teams
-- ----------------------------
DROP TABLE IF EXISTS `teams`;
CREATE TABLE `teams`  (
  `team_id` int NOT NULL AUTO_INCREMENT,
  `team_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `team_logo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `team_founded_date` date NULL DEFAULT NULL,
  `team_home_stadium` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`team_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of teams
-- ----------------------------
INSERT INTO `teams` VALUES (1, 'Manchester United', 'logo1.jpg', '1878-01-01', 'Old Trafford');
INSERT INTO `teams` VALUES (2, 'Liverpool', 'logo2.jpg', '1892-06-03', 'Anfield');
INSERT INTO `teams` VALUES (3, 'Chelsea', 'logo3.jpg', '1905-03-10', 'Stamford Bridge');
INSERT INTO `teams` VALUES (4, 'Arsenal', 'logo4.jpg', '1915-03-15', '02 Stadium');

SET FOREIGN_KEY_CHECKS = 1;

-- MySQL schema inferred from the queries and fetched columns in php/*.php.
-- Target: MySQL 5.7+ / MariaDB 10.2+
-- This creates structure only; it does not include production data or users.

SET NAMES utf8mb4;
SET time_zone = '+08:00';

CREATE DATABASE IF NOT EXISTS `demo`
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE IF NOT EXISTS `uniqlo`
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE IF NOT EXISTS `Melaka`
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE IF NOT EXISTS `ijm`
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE IF NOT EXISTS `felda`
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Application accounts (php/login.php, changepassword.php, updateProfile.php).
CREATE TABLE IF NOT EXISTS `demo`.`users` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(150) NOT NULL,
  `username` VARCHAR(191) NOT NULL,
  `password` CHAR(128) NOT NULL COMMENT 'SHA-512 hex digest used by the current PHP code',
  `salt` VARCHAR(128) NOT NULL,
  `role_code` VARCHAR(50) NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_users_username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Initial administrator: username admin@123, password 123456.
-- Change this password immediately after the first login.
INSERT INTO `demo`.`users`
  (`name`, `username`, `password`, `salt`, `role_code`)
VALUES
  ('Administrator', 'admin@123',
   '36b6e7ba3677aa928f492258135ce3394171eab78a6cb08f1ad347e8271c0146d273a72eda77b9ca59a5c566927bdad45ed836eb0f19b75f88d0a2101c79546d',
   'b529247c31c0c08ef5eca8022bfd6b2ea709d1b4eb1f5bd968451b6ef7520822',
   'admin')
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `password` = VALUES(`password`),
  `salt` = VALUES(`salt`),
  `role_code` = VALUES(`role_code`);

-- Uniqlo visitor counter records.
CREATE TABLE IF NOT EXISTS `uniqlo`.`uniqlo_1u` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `Date` DATETIME NOT NULL,
  `Mode` VARCHAR(50) NOT NULL,
  `Door` VARCHAR(50) NOT NULL,
  `Device` VARCHAR(50) DEFAULT NULL,
  `Count` INT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `idx_uniqlo_1u_date` (`Date`),
  KEY `idx_uniqlo_1u_mode_date` (`Mode`, `Date`),
  KEY `idx_uniqlo_1u_door_date` (`Door`, `Date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `uniqlo`.`uniqlo_DA` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `Date` DATETIME NOT NULL,
  `Mode` VARCHAR(50) NOT NULL,
  `Door` VARCHAR(50) NOT NULL,
  `Device` VARCHAR(50) DEFAULT NULL,
  `Count` INT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `idx_uniqlo_da_date` (`Date`),
  KEY `idx_uniqlo_da_door_device_date` (`Door`, `Device`, `Date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `uniqlo`.`transaction` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `Date` DATETIME NOT NULL,
  `Transaction` INT UNSIGNED NOT NULL DEFAULT 0,
  `Outlet` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_transaction_date_outlet` (`Date`, `Outlet`),
  KEY `idx_transaction_outlet_date` (`Outlet`, `Date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Melaka pedestrian/vehicle traffic records.
CREATE TABLE IF NOT EXISTS `Melaka`.`Melaka_traffic` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `Date` DATETIME NOT NULL,
  `Place` VARCHAR(100) NOT NULL,
  `Condition` VARCHAR(50) NOT NULL,
  `Device` VARCHAR(50) NOT NULL,
  `Count` INT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `idx_melaka_traffic_date` (`Date`),
  KEY `idx_melaka_traffic_place_date` (`Place`, `Date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- IJM vehicle counts.
CREATE TABLE IF NOT EXISTS `ijm`.`vehicle_count` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `Date` DATETIME NOT NULL,
  `Vehicle_Type` VARCHAR(20) NOT NULL,
  `Count` INT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `idx_ijm_vehicle_count_date` (`Date`),
  KEY `idx_ijm_vehicle_type_date` (`Vehicle_Type`, `Date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Felda harvester tracking. ID is the harvester/device identifier in gettracking.php.
CREATE TABLE IF NOT EXISTS `felda`.`felda_table1` (
  `row_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `ID` VARCHAR(64) NOT NULL,
  `Rec_time` DATETIME NOT NULL,
  `Node_name` VARCHAR(100) NOT NULL,
  `R_m` DECIMAL(12,3) NOT NULL DEFAULT 0,
  PRIMARY KEY (`row_id`),
  KEY `idx_felda_table1_id_time` (`ID`, `Rec_time`),
  KEY `idx_felda_table1_time` (`Rec_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `felda`.`felda_table2` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `Rec_time` DATETIME NOT NULL,
  `Node_name` VARCHAR(100) NOT NULL,
  `Big_car` INT UNSIGNED NOT NULL DEFAULT 0,
  `Small_car` INT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `idx_felda_table2_time` (`Rec_time`),
  KEY `idx_felda_table2_node_time` (`Node_name`, `Rec_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Compatibility tables required by PHP files that query these through $db
-- (the demo connection), even though other files use the uniqlo/ijm connection.
CREATE TABLE IF NOT EXISTS `demo`.`uniqlo_1u` LIKE `uniqlo`.`uniqlo_1u`;
CREATE TABLE IF NOT EXISTS `demo`.`uniqlo_DA` LIKE `uniqlo`.`uniqlo_DA`;
CREATE TABLE IF NOT EXISTS `demo`.`transaction` LIKE `uniqlo`.`transaction`;
CREATE TABLE IF NOT EXISTS `demo`.`vehicle_count` LIKE `ijm`.`vehicle_count`;

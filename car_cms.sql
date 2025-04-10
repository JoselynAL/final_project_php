-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 10, 2025 at 10:47 PM
-- Server version: 8.0.39
-- PHP Version: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `car_cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `action` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `target_table` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `target_id` bigint UNSIGNED DEFAULT NULL,
  `old_values` json DEFAULT NULL,
  `new_values` json DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `audit_logs`
--

INSERT INTO `audit_logs` (`id`, `user_id`, `action`, `target_table`, `target_id`, `old_values`, `new_values`, `ip_address`, `user_agent`, `created_at`) VALUES
(1, NULL, 'create_user', 'users', NULL, NULL, '{\"role\": \"admin\", \"email\": \"testuser15@gmail.com\", \"password\": \"test123\", \"username\": \"testuser15\"}', '127.0.0.1', NULL, '2025-04-06 02:43:48'),
(2, NULL, 'create_user', 'users', 0, NULL, '{\"role\": \"admin\", \"email\": \"testuser16@gmail.com\", \"password\": \"test123\", \"username\": \"testuser16\"}', '127.0.0.1', NULL, '2025-04-06 02:47:36'),
(3, 0, 'create_user', 'users', 0, NULL, '{\"role\": \"admin\", \"email\": \"testuser19@gmail.com\", \"password\": \"test123\", \"username\": \"testuser19\"}', '127.0.0.1', NULL, '2025-04-06 02:59:59'),
(4, 24, 'create_user', 'users', 24, NULL, '{\"role\": \"admin\", \"email\": \"testuser20@gmail.com\", \"password\": \"test123\", \"username\": \"testuser20\"}', '127.0.0.1', NULL, '2025-04-06 03:02:40'),
(5, 24, 'login', 'users', 24, NULL, NULL, '127.0.0.1', NULL, '2025-04-06 03:42:35'),
(6, 24, 'logout', 'users', 24, NULL, NULL, '127.0.0.1', NULL, '2025-04-06 03:43:30'),
(7, 25, 'create_user', 'users', 25, NULL, '{\"role\": \"admin\", \"email\": \"testuser21@gmail.com\", \"password\": \"test123\", \"username\": \"testuser21\"}', '127.0.0.1', NULL, '2025-04-09 19:07:25'),
(8, 25, 'login', 'users', 25, NULL, NULL, '127.0.0.1', NULL, '2025-04-09 19:15:32'),
(11, 25, 'create_car', 'cars', 1007, NULL, '{\"year\": 2022, \"brand\": \"Toyota\", \"color\": \"White\", \"image\": \"toyota-corolla.jpg\", \"model\": \"Corolla\", \"price\": 24000.5, \"status\": \"in_stock\", \"description\": \"Fuel-efficient and reliable sedan.\"}', '127.0.0.1', NULL, '2025-04-09 19:26:58'),
(12, 25, 'update_car', 'cars', 1007, '{\"id\": 1007, \"year\": 2022, \"Color\": \"White\", \"brand\": \"Toyota\", \"image\": \"toyota-corolla.jpg\", \"model\": \"Corolla\", \"price\": \"24000.50\", \"status\": \"in_stock\", \"user_id\": 25, \"created_at\": \"2025-04-09 12:26:58\", \"updated_at\": \"2025-04-09 12:26:58\", \"description\": \"Fuel-efficient and reliable sedan.\"}', '{\"year\": 2022, \"brand\": \"Toyota\", \"color\": \"White\", \"image\": \"toyota-corolla.jpg\", \"model\": \"Corolla\", \"price\": 24000.5, \"status\": \"reserved\", \"description\": \"Fuel-efficient and reliable sedan.\"}', '127.0.0.1', NULL, '2025-04-09 19:36:16'),
(13, 25, 'delete_car', 'cars', 1007, '{\"id\": 1007, \"year\": 2022, \"Color\": \"White\", \"brand\": \"Toyota\", \"image\": \"toyota-corolla.jpg\", \"model\": \"Corolla\", \"price\": \"24000.50\", \"status\": \"reserved\", \"user_id\": 25, \"created_at\": \"2025-04-09 12:26:58\", \"updated_at\": \"2025-04-09 12:36:16\", \"description\": \"Fuel-efficient and reliable sedan.\"}', NULL, '127.0.0.1', NULL, '2025-04-09 19:40:04'),
(14, 25, 'login', 'users', 25, NULL, NULL, '127.0.0.1', NULL, '2025-04-10 08:38:56'),
(15, 25, 'create_car', 'cars', 1008, NULL, '{\"year\": \"2002\", \"brand\": \"Ferrari\", \"color\": \"blue\", \"image\": \"ferrari_sf90stradale_blue.jpeg\", \"model\": \"SF90 Stradale\", \"price\": \"200000.00\", \"status\": \"in_stock\", \"description\": \"The most powerful Ferrari car ever references Scuderia Ferrari\"}', '127.0.0.1', NULL, '2025-04-10 08:39:05'),
(16, 25, 'create_car', 'cars', 1009, NULL, '{\"year\": \"2002\", \"brand\": \"Ferrari\", \"color\": \"Red\", \"image\": \"ferrari_sf90stradale_red.jpeg\", \"model\": \"SF90 Stradale\", \"price\": \"200000.00\", \"status\": \"in_stock\", \"description\": \"The most powerful Ferrari car ever references Scuderia Ferrari\"}', '127.0.0.1', NULL, '2025-04-10 08:42:26'),
(17, 25, 'update_car', 'cars', 1009, '{\"id\": 1009, \"year\": 2002, \"Color\": \"red\", \"brand\": \"Ferrari\", \"image\": \"ferrari_sf90stradale_red.jpeg\", \"model\": \"SF90 Stradale\", \"price\": \"200000.00\", \"status\": \"in_stock\", \"user_id\": 25, \"created_at\": \"2025-04-10 01:42:26\", \"updated_at\": \"2025-04-10 01:42:26\", \"description\": \"The most powerful Ferrari car ever references Scuderia Ferrari\"}', NULL, '127.0.0.1', NULL, '2025-04-10 08:55:46'),
(18, 25, 'update_car', 'cars', 1009, '{\"id\": 1009, \"year\": 2002, \"Color\": \"\", \"brand\": \"Ferrari\", \"image\": \"ferrari_sf90stradale_red.jpeg\", \"model\": \"SF90 Stradale\", \"price\": \"200000.00\", \"status\": \"in_stock\", \"user_id\": 25, \"created_at\": \"2025-04-10 01:42:26\", \"updated_at\": \"2025-04-10 01:55:46\", \"description\": \"The most powerful Ferrari car ever references Scuderia Ferrari\"}', NULL, '127.0.0.1', NULL, '2025-04-10 08:59:14'),
(19, 25, 'update_car', 'cars', 1009, '{\"id\": 1009, \"year\": 2002, \"Color\": \"\", \"brand\": \"Ferrari\", \"image\": \"ferrari_sf90stradale_red.jpeg\", \"model\": \"SF90 Stradale\", \"price\": \"200000.00\", \"status\": \"in_stock\", \"user_id\": 25, \"created_at\": \"2025-04-10 01:42:26\", \"updated_at\": \"2025-04-10 01:55:46\", \"description\": \"The most powerful Ferrari car ever references Scuderia Ferrari\"}', NULL, '127.0.0.1', NULL, '2025-04-10 08:59:18'),
(20, 25, 'update_car', 'cars', 1009, '{\"id\": 1009, \"year\": 2002, \"Color\": \"\", \"brand\": \"Ferrari\", \"image\": \"ferrari_sf90stradale_red.jpeg\", \"model\": \"SF90 Stradale\", \"price\": \"200000.00\", \"status\": \"in_stock\", \"user_id\": 25, \"created_at\": \"2025-04-10 01:42:26\", \"updated_at\": \"2025-04-10 01:55:46\", \"description\": \"The most powerful Ferrari car ever references Scuderia Ferrari\"}', NULL, '127.0.0.1', NULL, '2025-04-10 09:02:35'),
(21, 25, 'update_car', 'cars', 1009, '{\"id\": 1009, \"year\": 2002, \"Color\": \"\", \"brand\": \"Ferrari\", \"image\": \"ferrari_sf90stradale_red.jpeg\", \"model\": \"SF90 Stradale\", \"price\": \"200000.00\", \"status\": \"in_stock\", \"user_id\": 25, \"created_at\": \"2025-04-10 01:42:26\", \"updated_at\": \"2025-04-10 01:55:46\", \"description\": \"The most powerful Ferrari car ever references Scuderia Ferrari\"}', NULL, '127.0.0.1', NULL, '2025-04-10 09:03:57'),
(22, 25, 'create_car', 'cars', 1010, NULL, '{\"year\": \"2002\", \"brand\": \"Ferrari\", \"color\": \"Red\", \"image\": \"ferrari_sf90stradale_red.jpeg\", \"model\": \"SF90 Stradale\", \"price\": \"200000.00\", \"status\": \"in_stock\", \"description\": \"The most powerful Ferrari car ever references Scuderia Ferrari\"}', '127.0.0.1', NULL, '2025-04-10 09:06:54'),
(23, 25, 'update_car', 'cars', 1010, '{\"id\": 1010, \"year\": 2002, \"Color\": \"red\", \"brand\": \"Ferrari\", \"image\": \"ferrari_sf90stradale_red.jpeg\", \"model\": \"SF90 Stradale\", \"price\": \"200000.00\", \"status\": \"in_stock\", \"user_id\": 25, \"created_at\": \"2025-04-10 02:06:54\", \"updated_at\": \"2025-04-10 02:06:54\", \"description\": \"The most powerful Ferrari car ever references Scuderia Ferrari\"}', NULL, '127.0.0.1', NULL, '2025-04-10 09:07:28'),
(24, 25, 'update_car', 'cars', 1010, '{\"id\": 1010, \"year\": 2002, \"Color\": \"\", \"brand\": \"Ferrari\", \"image\": \"ferrari_sf90stradale_red.jpeg\", \"model\": \"SF90 Stradale\", \"price\": \"200000.00\", \"status\": \"in_stock\", \"user_id\": 25, \"created_at\": \"2025-04-10 02:06:54\", \"updated_at\": \"2025-04-10 02:07:28\", \"description\": \"The most powerful Ferrari car ever references Scuderia Ferrari\"}', '{\"year\": \"2002\", \"brand\": \"Ferrari\", \"color\": \"Blue\", \"image\": \"ferrari_sf90stradale_blue.jpg\", \"model\": \"SF90 Stradale\", \"price\": \"200000.00\", \"status\": \"in_stock\", \"description\": \"The most powerful Ferrari car ever references Scuderia Ferrari\"}', '127.0.0.1', NULL, '2025-04-10 09:16:30'),
(25, 25, 'login', 'users', 25, NULL, NULL, '127.0.0.1', NULL, '2025-04-10 19:11:00'),
(26, 25, 'logout', 'users', 25, NULL, NULL, '127.0.0.1', NULL, '2025-04-10 19:11:35'),
(27, 25, 'login', 'users', 25, NULL, NULL, '127.0.0.1', NULL, '2025-04-10 19:12:02'),
(28, 25, 'update_car', 'cars', 1010, '{\"id\": 1010, \"year\": 2002, \"Color\": \"blue\", \"brand\": \"Ferrari\", \"image\": \"ferrari_sf90stradale_blue.jpg\", \"model\": \"SF90 Stradale\", \"price\": \"200000.00\", \"status\": \"in_stock\", \"user_id\": 25, \"created_at\": \"2025-04-10 02:06:54\", \"updated_at\": \"2025-04-10 02:16:30\", \"description\": \"The most powerful Ferrari car ever references Scuderia Ferrari\"}', '{\"year\": \"2002\", \"brand\": \"Ferrari\", \"color\": \"Red\", \"image\": \"ferrari_sf90stradale_red.jpeg\", \"model\": \"SF90 Stradale\", \"price\": \"200000.00\", \"status\": \"in_stock\", \"description\": \"The most powerful Ferrari car ever references Scuderia Ferrari\"}', '127.0.0.1', NULL, '2025-04-10 19:13:26'),
(29, 25, 'view_car_detail', 'cars', 1010, NULL, NULL, '127.0.0.1', NULL, '2025-04-10 19:19:01'),
(30, 25, 'view_car_detail', 'cars', 1010, NULL, NULL, '127.0.0.1', NULL, '2025-04-10 19:19:21'),
(31, 25, 'view_car_detail', 'cars', 1010, NULL, NULL, '127.0.0.1', NULL, '2025-04-10 19:26:37'),
(32, 25, 'login', 'users', 25, NULL, NULL, '127.0.0.1', NULL, '2025-04-10 19:28:56'),
(33, 25, 'view_car_detail', 'cars', 1010, NULL, NULL, '127.0.0.1', NULL, '2025-04-10 19:28:58'),
(34, 25, 'view_car_detail', 'cars', 1010, NULL, NULL, '127.0.0.1', NULL, '2025-04-10 19:29:08'),
(35, 25, 'login', 'users', 25, NULL, NULL, '127.0.0.1', NULL, '2025-04-10 19:29:21'),
(36, 25, 'login', 'users', 25, NULL, NULL, '127.0.0.1', NULL, '2025-04-10 19:29:50'),
(37, 25, 'login', 'users', 25, NULL, NULL, '127.0.0.1', NULL, '2025-04-10 19:30:07'),
(38, 25, 'view_car_detail', 'cars', 1010, NULL, NULL, '127.0.0.1', NULL, '2025-04-10 19:30:26'),
(39, 26, 'create_user', 'users', 26, NULL, '{\"role\": \"admin\", \"email\": \"testuser22@gmail.com\", \"password\": \"test123\", \"username\": \"testuser22\"}', '127.0.0.1', NULL, '2025-04-10 20:32:31'),
(40, 26, 'login', 'users', 26, NULL, NULL, '127.0.0.1', NULL, '2025-04-10 20:33:38'),
(41, 26, 'create_car', 'cars', 1011, NULL, '{\"year\": \"2002\", \"brand\": \"Ferrari\", \"color\": \"Red\", \"image\": \"ferrari_sf90stradale_red.jpeg\", \"model\": \"SF90 Stradale\", \"price\": \"200000.00\", \"status\": \"in_stock\", \"description\": \"The most powerful Ferrari car ever references Scuderia Ferrari\"}', '127.0.0.1', NULL, '2025-04-10 20:36:42'),
(42, 26, 'view_car_detail', 'cars', 1011, NULL, NULL, '127.0.0.1', NULL, '2025-04-10 20:41:39'),
(43, 26, 'update_car', 'cars', 1011, '{\"id\": 1011, \"year\": 2002, \"Color\": \"red\", \"brand\": \"Ferrari\", \"image\": \"ferrari_sf90stradale_red.jpeg\", \"model\": \"SF90 Stradale\", \"price\": \"200000.00\", \"status\": \"in_stock\", \"user_id\": 26, \"created_at\": \"2025-04-10 13:36:42\", \"updated_at\": \"2025-04-10 13:36:42\", \"description\": \"The most powerful Ferrari car ever references Scuderia Ferrari\"}', '{\"year\": \"2002\", \"brand\": \"Ferrari\", \"color\": \"Blue\", \"image\": \"ferrari_sf90stradale_blue.jpg\", \"model\": \"SF90 Stradale\", \"price\": \"200000.00\", \"status\": \"in_stock\", \"description\": \"The most powerful Ferrari car ever references Scuderia Ferrari\"}', '127.0.0.1', NULL, '2025-04-10 20:42:36'),
(44, 26, 'delete_car', 'cars', 1011, '{\"id\": 1011, \"year\": 2002, \"Color\": \"blue\", \"brand\": \"Ferrari\", \"image\": \"ferrari_sf90stradale_blue.jpg\", \"model\": \"SF90 Stradale\", \"price\": \"200000.00\", \"status\": \"in_stock\", \"user_id\": 26, \"created_at\": \"2025-04-10 13:36:42\", \"updated_at\": \"2025-04-10 13:42:36\", \"description\": \"The most powerful Ferrari car ever references Scuderia Ferrari\"}', NULL, '127.0.0.1', NULL, '2025-04-10 20:43:35'),
(45, 26, 'logout', 'users', 26, NULL, NULL, '127.0.0.1', NULL, '2025-04-10 20:44:09'),
(46, 27, 'create_user', 'users', 27, NULL, '{\"role\": \"admin\", \"email\": \"testuser23@gmail.com\", \"password\": \"test123\", \"username\": \"testuser23\"}', '127.0.0.1', NULL, '2025-04-10 22:36:00'),
(47, 27, 'login', 'users', 27, NULL, NULL, '127.0.0.1', NULL, '2025-04-10 22:36:37'),
(48, 27, 'create_car', 'cars', 1012, NULL, '{\"year\": \"2002\", \"brand\": \"Ferrari\", \"color\": \"Red\", \"image\": \"ferrari_sf90stradale_red.jpeg\", \"model\": \"SF90 Stradale\", \"price\": \"200000.00\", \"status\": \"in_stock\", \"description\": \"The most powerful Ferrari car ever references Scuderia Ferrari\"}', '127.0.0.1', NULL, '2025-04-10 22:37:44'),
(49, 27, 'create_car', 'cars', 1013, NULL, '{\"year\": \"2002\", \"brand\": \"Ferrari\", \"color\": \"Red\", \"image\": \"ferrari_sf90stradale_red.jpeg\", \"model\": \"SF90 Stradale\", \"price\": \"200000.00\", \"status\": \"in_stock\", \"description\": \"The most powerful Ferrari car ever references Scuderia Ferrari\"}', '127.0.0.1', NULL, '2025-04-10 22:38:31');

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `id` int NOT NULL,
  `brand` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `model` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `year` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` enum('in_stock','reserved','sold') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'in_stock',
  `Color` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`id`, `brand`, `model`, `year`, `price`, `description`, `image`, `status`, `Color`, `user_id`, `created_at`, `updated_at`) VALUES
(1001, 'Ferrari', 'SF90 Stradale', 2002, 200000.00, 'The most powerful Ferrari car ever references Scuderia Ferrari\nA new chapter begins in the history of Ferrari with the introduction of its first series-production PHEV (Plug-in Hybrid Electric Vehicle), the SF90 Stradale.\n', 'ferrariSF90.Stradale', 'sold', 'Red', 12, '2025-04-04 03:43:03', '2025-04-10 08:35:19'),
(1002, 'Macerati', 'GT2 Stradale', 2025, 500000.00, 'The garage door opens, and you start the engine. It’s go time. The light turns green – go chase down that racing line. Faster. Nothing can stop you.', 'Maserati.GT2Stradale', 'in_stock', 'Blue', 4, '2025-04-04 03:43:03', '2025-04-04 17:48:47'),
(1003, 'Lamborghini', 'Huracan Sterrato', 2023, 800000.00, 'The first of its kind, the Huracán Sterrato explores a new frontier in driving pleasure, designed to push the envelope when the asphalt ends. The super sports car is equipped with a dedicated iteration of the LDVI (Lamborghini Integrated Vehicle Dynamics) system.', 'LamborghiniHuracan.Sterrato', 'reserved', 'Verde Scandal', 7, '2025-04-04 03:43:03', '2025-04-04 18:06:14'),
(1004, 'Aston Martin', 'Valkyrie', 2024, 950000.00, 'The Aston Martin Valkyrie is a limited production hybrid sports car collaboratively built by British automobile manufacturers Aston Martin, Red Bull Racing Advanced Technologies and several other parties. ', 'AstonMartin.Valkyrie', 'in_stock', 'Black', 8, '2025-04-04 03:43:03', '2025-04-04 18:06:49'),
(1013, 'Ferrari', 'SF90 Stradale', 2002, 200000.00, 'The most powerful Ferrari car ever references Scuderia Ferrari', 'ferrari_sf90stradale_red.jpeg', 'in_stock', 'red', 27, '2025-04-10 22:38:31', '2025-04-10 22:38:31');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('admin','seller','customer') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'customer',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'testuser', 'testuser@example.com', '$2y$10$c5KfZOQwNmE3WmXabDKssOvPJ7Vvud702QLfGZfd4FZ82YXsRCcY2', 'customer', '2025-04-02 02:50:55'),
(2, 'testuser1', 'testuser1@example.com', '$2y$10$nTgoPY/dtUo3rPgofHU86OMLEwIVg4NSCNQk//mmw4qltQW1kDREy', 'admin', '2025-04-02 02:55:46'),
(3, 'testuser2', 'testuser2@example.com', '$2y$10$PXJ26Mjl6fYonFITSiPP6OcmTxGsTskG6FOEamoXF65A/jbm2F0BS', 'seller', '2025-04-02 03:04:17'),
(4, 'testuser3', 'testuser3@example.com', '$2y$10$FS4xW0HNwAcg7gnxPrTIUejkSPsPDB/XRKleKFYAtsB4opHbH1lfy', 'customer', '2025-04-02 03:12:09'),
(7, 'testuser5', 'testuser5@example.com', '$2y$10$g4Un157xroqMlcrF5129.OelhDCUH5Lf/VI51hkbHDOYto9DCimH6', 'customer', '2025-04-02 03:43:32'),
(8, 'testuser4', 'testuser4@example.com', '$2y$10$4nI8Q3FKVi.TkSIS4sCZDeLEtMAhmiYAXp6hLtSIDRMJ004vl2MWS', 'customer', '2025-04-02 03:44:57'),
(9, 'testuser6', 'testuser6@example.com', '$2y$10$oBMpD1qPW9yHHB5HdV/29OFoQXTOpomX5ke27pLArshZpPDwwtkuu', 'seller', '2025-04-02 03:49:30'),
(10, 'testuser7', 'testuser7@example.com', '$2y$10$QipTWDEBjTzDOPCf0TkaL.gHfgo.YbXYRopSwbV4bzRbS6Qtcu52.', 'customer', '2025-04-02 09:36:41'),
(11, 'bestJay', 'bestJay@gmail.com', '$2y$10$qhlG/jHNTmeIrn3JWlT9bOrR1AGv3OZj0Z3fNHqmlXR2yn2uYMhWC', 'admin', '2025-04-02 09:45:08'),
(12, 'testuser8', 'testuser8@gmail.com', '$2y$10$.q/0JOCVdTygZ9Oou2PwO.5ZxvnfnxnnV2iq/TLNDzHMNwq1ZZhVK', 'customer', '2025-04-02 21:36:21'),
(13, 'testuser9', 'testuser9@gmail.com', '$2y$10$xm6MJwCzTG2xp/vJ9R9BQ.2/1EAZ2nbM4cg/unWRGWLKl7mppkMMS', 'customer', '2025-04-03 00:10:31'),
(14, 'testuser10', 'testuser10@gmail.com', '$2y$10$0.IuUjBMP3WM3Tf4zDp/TeKHXvS.zQO5YgxykPSsry67pwzPKS.rS', 'customer', '2025-04-03 01:23:35'),
(15, 'testuser11', 'testuser11@gmail.com', '$2y$10$6ub5bbCIlNGTnkVB/NZtauWscZJnqnsePrL9JUpXXAC4s2AVTa25O', 'admin', '2025-04-06 02:29:47'),
(16, 'testuser12', 'testuser12@gmail.com', '$2y$10$wCBaHklZ8Wn5x5oOtV2D3uBpB4nrxjFwYnMP4uAVcEguEyTijBnCa', 'admin', '2025-04-06 02:35:33'),
(17, 'testuser13', 'testuser13@gmail.com', '$2y$10$18IpzRDkGPBhjOLdo8RAJOQrKs0bYmTgBhWeTbP8JrYj6gQNArg2S', 'admin', '2025-04-06 02:38:30'),
(18, 'testuser14', 'testuser14@gmail.com', '$2y$10$BV3uLfz9bUIyeFseBd8gAOZkB6CfFiP8xOJWks61Hp5dFi/.Lc41u', 'admin', '2025-04-06 02:41:37'),
(19, 'testuser15', 'testuser15@gmail.com', '$2y$10$Ep4dY5LvAJuHzhqi03sDQ.HK/tqfDaPi7drB2KtDcmtnJSHzHiQRu', 'admin', '2025-04-06 02:43:48'),
(20, 'testuser16', 'testuser16@gmail.com', '$2y$10$J39AbR.niPLsnZewNwByveIrnWGdsBUnNWGnMV5.zZvBM8lYvV4/G', 'admin', '2025-04-06 02:47:36'),
(21, 'testuser17', 'testuser17@gmail.com', '$2y$10$NQ8cyONnnexYRSe3J/JekeYGGaMBK8PYu6/4fEcKQf4rCt/LoX2rC', 'admin', '2025-04-06 02:52:36'),
(22, 'testuser18', 'testuser18@gmail.com', '$2y$10$O/OXPjsx1sczq.CSPlSljO9NI/fDIcn5zNQykYxgwt5TBmQ4MjCbK', 'admin', '2025-04-06 02:53:32'),
(23, 'testuser19', 'testuser19@gmail.com', '$2y$10$QNKZc2GvFlQTzDrOX2X08OhBwex27NiOhG9Xl3ZoINDLG62fmUSGW', 'admin', '2025-04-06 02:59:59'),
(24, 'testuser20', 'testuser20@gmail.com', '$2y$10$lnibC0slGq4kaOAZNYFDHeSMee63vyodZp3OHx4A7qvZysFJXLVQ.', 'admin', '2025-04-06 03:02:40'),
(25, 'testuser21', 'testuser21@gmail.com', '$2y$10$6BfE9qMNzJ6rRwColjFSeeui0F0cFDnwqslSx4ejdy3hSTDjsVVZC', 'admin', '2025-04-09 19:07:25'),
(26, 'testuser22', 'testuser22@gmail.com', '$2y$10$aQxEHgJmGRUBV2hUeVGHIOf/1JV64PUcGFndj1au7Z2UKGWVozLv.', 'admin', '2025-04-10 20:32:31'),
(27, 'testuser23', 'testuser23@gmail.com', '$2y$10$KSHvvzcepoWN/QVplCCUG.Wv7yT.Z0ZPWP5IyLhR09o3DwArOT5ia', 'admin', '2025-04-10 22:35:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1014;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cars`
--
ALTER TABLE `cars`
  ADD CONSTRAINT `cars_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

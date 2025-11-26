/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.11.13-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: hotel
-- ------------------------------------------------------
-- Server version	10.11.13-MariaDB-0ubuntu0.24.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `activity_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `activity_type` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `role` varchar(255) NOT NULL,
  `old_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`old_values`)),
  `new_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`new_values`)),
  `model_type` varchar(255) DEFAULT NULL,
  `model_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_logs_user_id_foreign` (`user_id`),
  KEY `activity_logs_model_type_model_id_index` (`model_type`,`model_id`),
  CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=689 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_logs`
--

LOCK TABLES `activity_logs` WRITE;
/*!40000 ALTER TABLE `activity_logs` DISABLE KEYS */;
INSERT INTO `activity_logs` VALUES
(1,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-12 22:46:57','2025-08-12 22:46:57'),
(2,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-12 22:47:29','2025-08-12 22:47:29'),
(3,2,'delete','Menghapus kamar: ','127.0.0.1',NULL,'admin','\"{\\\"id\\\":5,\\\"number\\\":\\\"105\\\",\\\"type\\\":\\\"Junior Suite\\\",\\\"price\\\":\\\"80000.00\\\",\\\"status\\\":\\\"dipesan\\\",\\\"photo\\\":\\\"room-photos\\\\\\/8Dj5ySk3KqVZbnimFcPSCf09T7hbZdCwv2BT33Hg.jpg\\\",\\\"description\\\":\\\"Junior Suite\\\\r\\\\nIndulge in a refined stay in our Junior Suite, where sophistication meets spacious comfort. Perfect for couples or executives, this elegantly appointed suite offers a seamless blend of relaxation and functionality in a stylish open-concept layout.\\\\r\\\\n\\\\r\\\\nRoom Features:\\\\r\\\\n-Luxurious King-sized bed with premium linen and plush pillows\\\\r\\\\n-Separate seating or lounge area for added privacy\\\\r\\\\n-Individually controlled air-conditioning\\\\r\\\\n-Spacious ensuite bathroom with walk-in shower and deluxe amenities\\\\r\\\\n-43\\\\\\\" or larger Flat-screen Smart TV with international channels-\\\\r\\\\n-Complimentary high-speed Wi-Fi\\\\r\\\\n-Executive writing desk with comfortable chair\\\\r\\\\n-Daily complimentary bottled water, coffee & tea-making facilities\\\\r\\\\n-Mini bar and in-room safe\\\\r\\\\n-Large wardrobe with full-length mirror\\\\r\\\\n-Private balcony or large window with scenic view (available in selected suites)\\\\r\\\\n-Room Size: \\\\u00b140\\\\u201345 m\\\\u00b2\\\\r\\\\n-Capacity: Up to 2 adults (ideal for longer or luxury stays)\\\\r\\\\n-Relax in style and experience a higher level of comfort and service in our Junior Suite\\\\u2014where every detail is designed to elevate your stay.\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-08-07T05:52:13.000000Z\\\",\\\"updated_at\\\":\\\"2025-08-07T12:22:38.000000Z\\\"}\"',NULL,NULL,NULL,'2025-08-12 22:55:44','2025-08-12 22:55:44'),
(4,1,'delete','Menghapus pembayaran #24','127.0.0.1',NULL,'resepsionis','\"{\\\"id\\\":24,\\\"booking_id\\\":15,\\\"amount\\\":\\\"390000.00\\\",\\\"paid_at\\\":\\\"2025-08-11T06:56:00.000000Z\\\",\\\"method\\\":\\\"cash\\\",\\\"total\\\":\\\"0.00\\\",\\\"created_at\\\":\\\"2025-08-11T06:56:21.000000Z\\\",\\\"updated_at\\\":\\\"2025-08-11T06:56:21.000000Z\\\"}\"',NULL,NULL,NULL,'2025-08-12 23:06:10','2025-08-12 23:06:10'),
(5,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-12 23:06:20','2025-08-12 23:06:20'),
(6,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-12 23:08:36','2025-08-12 23:08:36'),
(7,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-12 23:08:45','2025-08-12 23:08:45'),
(8,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-12 23:16:27','2025-08-12 23:16:27'),
(9,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-12 23:17:42','2025-08-12 23:17:42'),
(10,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-12 23:21:37','2025-08-12 23:21:37'),
(11,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-12 23:23:29','2025-08-12 23:23:29'),
(12,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-12 23:26:00','2025-08-12 23:26:00'),
(13,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-12 23:27:59','2025-08-12 23:27:59'),
(14,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-12 23:28:59','2025-08-12 23:28:59'),
(15,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-12 23:30:33','2025-08-12 23:30:33'),
(16,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-12 23:31:24','2025-08-12 23:31:24'),
(17,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-12 23:31:32','2025-08-12 23:31:32'),
(18,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-12 23:31:56','2025-08-12 23:31:56'),
(19,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-12 23:32:36','2025-08-12 23:32:36'),
(20,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-12 23:32:50','2025-08-12 23:32:50'),
(21,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-12 23:33:07','2025-08-12 23:33:07'),
(22,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-12 23:33:34','2025-08-12 23:33:34'),
(23,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-12 23:33:40','2025-08-12 23:33:40'),
(24,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-12 23:34:53','2025-08-12 23:34:53'),
(25,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-12 23:38:13','2025-08-12 23:38:13'),
(26,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-12 23:38:31','2025-08-12 23:38:31'),
(27,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-12 23:38:38','2025-08-12 23:38:38'),
(28,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-12 23:39:26','2025-08-12 23:39:26'),
(29,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-12 23:39:37','2025-08-12 23:39:37'),
(30,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-12 23:39:43','2025-08-12 23:39:43'),
(31,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-12 23:39:48','2025-08-12 23:39:48'),
(32,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-12 23:40:07','2025-08-12 23:40:07'),
(33,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-12 23:41:37','2025-08-12 23:41:37'),
(34,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-12 23:45:50','2025-08-12 23:45:50'),
(35,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-12 23:46:16','2025-08-12 23:46:16'),
(36,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-12 23:50:50','2025-08-12 23:50:50'),
(37,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-12 23:57:04','2025-08-12 23:57:04'),
(38,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-12 23:57:42','2025-08-12 23:57:42'),
(39,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 00:00:59','2025-08-13 00:00:59'),
(40,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 00:10:15','2025-08-13 00:10:15'),
(41,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 00:16:13','2025-08-13 00:16:13'),
(42,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 00:16:24','2025-08-13 00:16:24'),
(43,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 00:16:35','2025-08-13 00:16:35'),
(44,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 00:16:47','2025-08-13 00:16:47'),
(45,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 00:16:59','2025-08-13 00:16:59'),
(46,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 00:18:08','2025-08-13 00:18:08'),
(47,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 00:19:08','2025-08-13 00:19:08'),
(48,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 00:20:18','2025-08-13 00:20:18'),
(49,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 00:23:24','2025-08-13 00:23:24'),
(50,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 00:24:34','2025-08-13 00:24:34'),
(51,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 00:31:36','2025-08-13 00:31:36'),
(52,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 00:41:12','2025-08-13 00:41:12'),
(53,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 00:44:15','2025-08-13 00:44:15'),
(54,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 00:45:39','2025-08-13 00:45:39'),
(55,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 00:50:15','2025-08-13 00:50:15'),
(56,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 00:55:08','2025-08-13 00:55:08'),
(57,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 01:00:22','2025-08-13 01:00:22'),
(58,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 01:03:33','2025-08-13 01:03:33'),
(59,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 01:11:37','2025-08-13 01:11:37'),
(60,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 01:12:49','2025-08-13 01:12:49'),
(61,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 01:14:53','2025-08-13 01:14:53'),
(62,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 01:21:38','2025-08-13 01:21:38'),
(63,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 01:30:19','2025-08-13 01:30:19'),
(64,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 01:32:01','2025-08-13 01:32:01'),
(65,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 01:34:57','2025-08-13 01:34:57'),
(66,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 01:35:15','2025-08-13 01:35:15'),
(67,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 01:35:23','2025-08-13 01:35:23'),
(68,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 01:35:41','2025-08-13 01:35:41'),
(69,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 01:41:14','2025-08-13 01:41:14'),
(70,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 01:42:24','2025-08-13 01:42:24'),
(71,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 01:46:30','2025-08-13 01:46:30'),
(72,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 01:46:37','2025-08-13 01:46:37'),
(73,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 01:50:29','2025-08-13 01:50:29'),
(74,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 01:51:04','2025-08-13 01:51:04'),
(75,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 01:53:21','2025-08-13 01:53:21'),
(76,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 01:54:20','2025-08-13 01:54:20'),
(77,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 18:34:18','2025-08-13 18:34:18'),
(78,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 18:36:39','2025-08-13 18:36:39'),
(79,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 18:40:19','2025-08-13 18:40:19'),
(80,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 18:55:41','2025-08-13 18:55:41'),
(81,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 19:02:59','2025-08-13 19:02:59'),
(82,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 19:03:02','2025-08-13 19:03:02'),
(83,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 19:03:22','2025-08-13 19:03:22'),
(84,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 19:11:54','2025-08-13 19:11:54'),
(85,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 19:12:15','2025-08-13 19:12:15'),
(86,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 19:13:03','2025-08-13 19:13:03'),
(87,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 19:13:19','2025-08-13 19:13:19'),
(88,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 19:18:10','2025-08-13 19:18:10'),
(89,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 19:21:20','2025-08-13 19:21:20'),
(90,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 19:21:50','2025-08-13 19:21:50'),
(91,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 19:29:24','2025-08-13 19:29:24'),
(92,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 19:29:53','2025-08-13 19:29:53'),
(93,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 19:32:42','2025-08-13 19:32:42'),
(94,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 20:00:11','2025-08-13 20:00:11'),
(95,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 20:32:25','2025-08-13 20:32:25'),
(96,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 20:34:24','2025-08-13 20:34:24'),
(97,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 20:35:37','2025-08-13 20:35:37'),
(98,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 20:42:31','2025-08-13 20:42:31'),
(99,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 20:43:13','2025-08-13 20:43:13'),
(100,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 20:44:30','2025-08-13 20:44:30'),
(101,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 20:51:47','2025-08-13 20:51:47'),
(102,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 20:54:47','2025-08-13 20:54:47'),
(103,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 20:59:57','2025-08-13 20:59:57'),
(104,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 21:02:30','2025-08-13 21:02:30'),
(105,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 21:03:29','2025-08-13 21:03:29'),
(106,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 21:04:13','2025-08-13 21:04:13'),
(107,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 21:32:47','2025-08-13 21:32:47'),
(108,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 21:38:14','2025-08-13 21:38:14'),
(109,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 21:38:20','2025-08-13 21:38:20'),
(110,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 21:57:59','2025-08-13 21:57:59'),
(111,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 22:39:26','2025-08-13 22:39:26'),
(112,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 22:46:17','2025-08-13 22:46:17'),
(113,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 22:54:18','2025-08-13 22:54:18'),
(114,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 22:59:58','2025-08-13 22:59:58'),
(115,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 23:01:09','2025-08-13 23:01:09'),
(116,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 23:02:31','2025-08-13 23:02:31'),
(117,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 23:02:49','2025-08-13 23:02:49'),
(118,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 23:04:33','2025-08-13 23:04:33'),
(119,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 23:05:47','2025-08-13 23:05:47'),
(120,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 23:06:11','2025-08-13 23:06:11'),
(121,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 23:08:59','2025-08-13 23:08:59'),
(122,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-13 23:17:09','2025-08-13 23:17:09'),
(123,2,'delete','Membatalkan booking #21','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin','\"{\\\"id\\\":21,\\\"user_id\\\":2,\\\"guest_id\\\":1,\\\"room_id\\\":2,\\\"check_in\\\":\\\"2025-08-11T00:00:00.000000Z\\\",\\\"check_out\\\":\\\"2025-08-13T00:00:00.000000Z\\\",\\\"status\\\":\\\"booked\\\",\\\"created_at\\\":\\\"2025-08-11T07:44:20.000000Z\\\",\\\"updated_at\\\":\\\"2025-08-11T07:44:20.000000Z\\\",\\\"total_price\\\":0}\"',NULL,NULL,NULL,'2025-08-13 23:23:52','2025-08-13 23:23:52'),
(124,2,'update','Memperbarui booking #18','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin','\"{\\\"id\\\":18,\\\"user_id\\\":2,\\\"guest_id\\\":2,\\\"room_id\\\":5,\\\"check_in\\\":\\\"2025-08-08T00:00:00.000000Z\\\",\\\"check_out\\\":\\\"2025-08-13T00:00:00.000000Z\\\",\\\"status\\\":\\\"booked\\\",\\\"created_at\\\":\\\"2025-08-07T12:22:38.000000Z\\\",\\\"updated_at\\\":\\\"2025-08-07T12:22:38.000000Z\\\",\\\"total_price\\\":0}\"','\"{\\\"guest_id\\\":\\\"2\\\",\\\"new_guest_name\\\":null,\\\"new_guest_phone\\\":null,\\\"new_guest_identity\\\":null,\\\"room_id\\\":\\\"2\\\",\\\"check_in\\\":\\\"2025-08-14\\\",\\\"check_out\\\":\\\"2025-08-16\\\",\\\"status\\\":\\\"canceled\\\"}\"',NULL,NULL,'2025-08-13 23:24:42','2025-08-13 23:24:42'),
(125,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-14 00:29:38','2025-08-14 00:29:38'),
(126,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-14 00:31:08','2025-08-14 00:31:08'),
(127,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-14 00:47:52','2025-08-14 00:47:52'),
(128,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-14 01:31:41','2025-08-14 01:31:41'),
(129,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-14 01:49:04','2025-08-14 01:49:04'),
(130,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-14 06:04:48','2025-08-14 06:04:48'),
(131,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-14 06:12:35','2025-08-14 06:12:35'),
(132,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-14 06:14:29','2025-08-14 06:14:29'),
(133,3,'delete','Membatalkan booking #18','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','resepsionis','\"{\\\"id\\\":18,\\\"user_id\\\":2,\\\"guest_id\\\":2,\\\"room_id\\\":2,\\\"check_in\\\":\\\"2025-08-14T00:00:00.000000Z\\\",\\\"check_out\\\":\\\"2025-08-16T00:00:00.000000Z\\\",\\\"status\\\":\\\"canceled\\\",\\\"created_at\\\":\\\"2025-08-07T12:22:38.000000Z\\\",\\\"updated_at\\\":\\\"2025-08-14T06:24:42.000000Z\\\",\\\"total_price\\\":0}\"',NULL,NULL,NULL,'2025-08-14 06:28:20','2025-08-14 06:28:20'),
(134,3,'delete','Membatalkan booking #17','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','resepsionis','\"{\\\"id\\\":17,\\\"user_id\\\":2,\\\"guest_id\\\":4,\\\"room_id\\\":4,\\\"check_in\\\":\\\"2025-08-21T00:00:00.000000Z\\\",\\\"check_out\\\":\\\"2025-08-25T00:00:00.000000Z\\\",\\\"status\\\":\\\"paid\\\",\\\"created_at\\\":\\\"2025-08-07T12:21:32.000000Z\\\",\\\"updated_at\\\":\\\"2025-08-11T13:22:47.000000Z\\\",\\\"total_price\\\":0}\"',NULL,NULL,NULL,'2025-08-14 06:28:22','2025-08-14 06:28:22'),
(135,3,'delete','Membatalkan booking #16','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','resepsionis','\"{\\\"id\\\":16,\\\"user_id\\\":2,\\\"guest_id\\\":5,\\\"room_id\\\":3,\\\"check_in\\\":\\\"2025-08-12T00:00:00.000000Z\\\",\\\"check_out\\\":\\\"2025-08-15T00:00:00.000000Z\\\",\\\"status\\\":\\\"paid\\\",\\\"created_at\\\":\\\"2025-08-07T12:21:09.000000Z\\\",\\\"updated_at\\\":\\\"2025-08-12T03:52:13.000000Z\\\",\\\"total_price\\\":0}\"',NULL,NULL,NULL,'2025-08-14 06:28:24','2025-08-14 06:28:24'),
(136,3,'delete','Membatalkan booking #15','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','resepsionis','\"{\\\"id\\\":15,\\\"user_id\\\":2,\\\"guest_id\\\":1,\\\"room_id\\\":1,\\\"check_in\\\":\\\"2025-08-08T00:00:00.000000Z\\\",\\\"check_out\\\":\\\"2025-08-13T00:00:00.000000Z\\\",\\\"status\\\":\\\"booked\\\",\\\"created_at\\\":\\\"2025-08-07T12:17:48.000000Z\\\",\\\"updated_at\\\":\\\"2025-08-07T12:18:16.000000Z\\\",\\\"total_price\\\":0}\"',NULL,NULL,NULL,'2025-08-14 06:28:26','2025-08-14 06:28:26'),
(137,3,'create','Membuat booking baru untuk kamar ','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','resepsionis',NULL,NULL,NULL,NULL,'2025-08-14 06:28:44','2025-08-14 06:28:44'),
(138,3,'create','Membuat booking baru untuk kamar ','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','resepsionis',NULL,NULL,NULL,NULL,'2025-08-14 06:56:02','2025-08-14 06:56:02'),
(139,3,'create','Membuat booking baru untuk kamar ','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','resepsionis',NULL,NULL,NULL,NULL,'2025-08-14 06:56:21','2025-08-14 06:56:21'),
(140,3,'create','Membuat booking baru untuk kamar ','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','resepsionis',NULL,NULL,NULL,NULL,'2025-08-14 06:56:44','2025-08-14 06:56:44'),
(141,3,'delete','Membatalkan booking #25','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','resepsionis','\"{\\\"id\\\":25,\\\"user_id\\\":3,\\\"guest_id\\\":3,\\\"room_id\\\":3,\\\"check_in\\\":\\\"2025-08-14T00:00:00.000000Z\\\",\\\"check_out\\\":\\\"2025-08-18T00:00:00.000000Z\\\",\\\"status\\\":\\\"booked\\\",\\\"created_at\\\":\\\"2025-08-14T13:56:44.000000Z\\\",\\\"updated_at\\\":\\\"2025-08-14T13:56:44.000000Z\\\",\\\"total_price\\\":0}\"',NULL,NULL,NULL,'2025-08-14 06:56:51','2025-08-14 06:56:51'),
(142,3,'create','Membuat booking baru untuk kamar ','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','resepsionis',NULL,NULL,NULL,NULL,'2025-08-14 06:57:08','2025-08-14 06:57:08'),
(143,3,'create','Membuat booking baru untuk kamar ','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','resepsionis',NULL,NULL,NULL,NULL,'2025-08-14 06:57:24','2025-08-14 06:57:24'),
(144,3,'create','Mencatat pembayaran untuk booking #23','127.0.0.1',NULL,'resepsionis',NULL,NULL,NULL,NULL,'2025-08-14 07:00:41','2025-08-14 07:00:41'),
(145,3,'create','Mencatat pembayaran untuk booking #26','127.0.0.1',NULL,'resepsionis',NULL,NULL,NULL,NULL,'2025-08-14 07:00:54','2025-08-14 07:00:54'),
(146,3,'create','Mencatat pembayaran untuk booking #27','127.0.0.1',NULL,'resepsionis',NULL,NULL,NULL,NULL,'2025-08-14 07:01:21','2025-08-14 07:01:21'),
(147,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-14 07:01:49','2025-08-14 07:01:49'),
(148,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-14 07:09:39','2025-08-14 07:09:39'),
(149,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-14 08:26:40','2025-08-14 08:26:40'),
(150,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-14 08:28:26','2025-08-14 08:28:26'),
(151,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-14 19:24:03','2025-08-14 19:24:03'),
(152,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-14 19:25:08','2025-08-14 19:25:08'),
(153,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-14 19:38:05','2025-08-14 19:38:05'),
(154,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-14 19:41:39','2025-08-14 19:41:39'),
(155,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-14 19:44:55','2025-08-14 19:44:55'),
(156,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-14 19:45:31','2025-08-14 19:45:31'),
(157,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-14 19:45:51','2025-08-14 19:45:51'),
(158,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-14 19:47:47','2025-08-14 19:47:47'),
(159,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-14 19:48:01','2025-08-14 19:48:01'),
(160,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-14 19:48:18','2025-08-14 19:48:18'),
(161,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-14 19:58:14','2025-08-14 19:58:14'),
(162,2,'delete','Menghapus pembayaran #29','127.0.0.1',NULL,'admin','\"{\\\"id\\\":29,\\\"booking_id\\\":23,\\\"amount\\\":\\\"120000.00\\\",\\\"paid_at\\\":\\\"2025-08-14T14:00:00.000000Z\\\",\\\"method\\\":\\\"transfer\\\",\\\"total\\\":\\\"120000.00\\\",\\\"created_at\\\":\\\"2025-08-14T14:00:41.000000Z\\\",\\\"updated_at\\\":\\\"2025-08-14T14:00:41.000000Z\\\"}\"',NULL,NULL,NULL,'2025-08-14 19:58:51','2025-08-14 19:58:51'),
(163,2,'delete','Menghapus pembayaran #30','127.0.0.1',NULL,'admin','\"{\\\"id\\\":30,\\\"booking_id\\\":26,\\\"amount\\\":\\\"390000.00\\\",\\\"paid_at\\\":\\\"2025-08-14T14:00:00.000000Z\\\",\\\"method\\\":\\\"qris\\\",\\\"total\\\":\\\"390000.00\\\",\\\"created_at\\\":\\\"2025-08-14T14:00:54.000000Z\\\",\\\"updated_at\\\":\\\"2025-08-14T14:00:54.000000Z\\\"}\"',NULL,NULL,NULL,'2025-08-14 19:59:09','2025-08-14 19:59:09'),
(164,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-14 20:11:47','2025-08-14 20:11:47'),
(165,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-14 20:11:54','2025-08-14 20:11:54'),
(166,2,'create','Membuat booking baru untuk kamar ','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-14 20:14:10','2025-08-14 20:14:10'),
(167,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-14 20:14:57','2025-08-14 20:14:57'),
(168,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-14 21:21:25','2025-08-14 21:21:25'),
(169,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-14 21:36:42','2025-08-14 21:36:42'),
(170,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-14 21:39:16','2025-08-14 21:39:16'),
(171,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-14 21:43:07','2025-08-14 21:43:07'),
(172,2,'delete','Menghapus kamar: ','127.0.0.1',NULL,'admin','\"{\\\"id\\\":6,\\\"number\\\":\\\"106\\\",\\\"type\\\":\\\"kamar baru\\\",\\\"price\\\":\\\"500000.00\\\",\\\"status\\\":\\\"tersedia\\\",\\\"photo\\\":\\\"room-photos\\\\\\/aaXC6lZGkvc8OyAc5tMO4ZdtLmGDwsTGh786NqzO.jpg\\\",\\\"description\\\":\\\"dummy\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-08-15T03:01:42.000000Z\\\",\\\"updated_at\\\":\\\"2025-08-15T04:20:35.000000Z\\\"}\"',NULL,NULL,NULL,'2025-08-14 22:08:15','2025-08-14 22:08:15'),
(173,2,'create','Menambahkan kamar baru: 110','127.0.0.1',NULL,'admin',NULL,NULL,NULL,NULL,'2025-08-14 22:12:38','2025-08-14 22:12:38'),
(174,2,'delete','Menghapus kamar: 107','127.0.0.1',NULL,'admin','\"{\\\"id\\\":7,\\\"number\\\":\\\"107\\\",\\\"type\\\":\\\"baru\\\",\\\"price\\\":\\\"800000.00\\\",\\\"status\\\":\\\"tersedia\\\",\\\"photo\\\":null,\\\"description\\\":\\\"dummy\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-08-15T05:08:46.000000Z\\\",\\\"updated_at\\\":\\\"2025-08-15T05:08:46.000000Z\\\"}\"',NULL,NULL,NULL,'2025-08-14 22:12:44','2025-08-14 22:12:44'),
(175,2,'delete','Menghapus kamar: 108','127.0.0.1',NULL,'admin','\"{\\\"id\\\":8,\\\"number\\\":\\\"108\\\",\\\"type\\\":\\\"baru\\\",\\\"price\\\":\\\"800000.00\\\",\\\"status\\\":\\\"tersedia\\\",\\\"photo\\\":\\\"room-photos\\\\\\/KxEqkOqzkrPxNn2SOxxQC9X4aHfYmGa8lDHxNkwB.jpg\\\",\\\"description\\\":\\\"dummy\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-08-15T05:10:36.000000Z\\\",\\\"updated_at\\\":\\\"2025-08-15T05:10:36.000000Z\\\"}\"',NULL,NULL,NULL,'2025-08-14 22:12:48','2025-08-14 22:12:48'),
(176,2,'delete','Menghapus kamar: 109','127.0.0.1',NULL,'admin','\"{\\\"id\\\":9,\\\"number\\\":\\\"109\\\",\\\"type\\\":\\\"baru\\\",\\\"price\\\":\\\"800000.00\\\",\\\"status\\\":\\\"tersedia\\\",\\\"photo\\\":\\\"room-photos\\\\\\/DlJpjMfIXHWnY95h6Q22i7ZVk3WUfbp46QD7bqVK.jpg\\\",\\\"description\\\":\\\"dummy\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-08-15T05:11:00.000000Z\\\",\\\"updated_at\\\":\\\"2025-08-15T05:11:00.000000Z\\\"}\"',NULL,NULL,NULL,'2025-08-14 22:12:53','2025-08-14 22:12:53'),
(177,2,'update','Memperbarui data kamar: 110','127.0.0.1',NULL,'admin','\"{\\\"id\\\":10,\\\"number\\\":\\\"110\\\",\\\"type\\\":\\\"baru\\\",\\\"price\\\":\\\"800000.00\\\",\\\"status\\\":\\\"tersedia\\\",\\\"photo\\\":null,\\\"description\\\":\\\"dummy\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-08-15T05:12:38.000000Z\\\",\\\"updated_at\\\":\\\"2025-08-15T05:12:38.000000Z\\\"}\"','\"{\\\"number\\\":\\\"110\\\",\\\"type\\\":\\\"baru\\\",\\\"price\\\":\\\"800000.00\\\",\\\"status\\\":\\\"tersedia\\\",\\\"description\\\":\\\"dummy\\\",\\\"photo\\\":\\\"room-photos\\\\\\/AjRgWVvXriP2wy0YlxJFWEqt9N5HmwWUaZcTv5jJ.jpg\\\"}\"',NULL,NULL,'2025-08-14 22:13:03','2025-08-14 22:13:03'),
(178,2,'update','Memperbarui data kamar: 110','127.0.0.1',NULL,'admin','\"{\\\"id\\\":10,\\\"number\\\":\\\"110\\\",\\\"type\\\":\\\"baru\\\",\\\"price\\\":\\\"800000.00\\\",\\\"status\\\":\\\"tersedia\\\",\\\"photo\\\":\\\"room-photos\\\\\\/AjRgWVvXriP2wy0YlxJFWEqt9N5HmwWUaZcTv5jJ.jpg\\\",\\\"description\\\":\\\"dummy\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-08-15T05:12:38.000000Z\\\",\\\"updated_at\\\":\\\"2025-08-15T05:13:03.000000Z\\\"}\"','\"{\\\"number\\\":\\\"110\\\",\\\"type\\\":\\\"baru\\\",\\\"price\\\":\\\"800000.00\\\",\\\"status\\\":\\\"tersedia\\\",\\\"description\\\":\\\"dummyy\\\"}\"',NULL,NULL,'2025-08-14 22:13:12','2025-08-14 22:13:12'),
(179,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-14 23:02:03','2025-08-14 23:02:03'),
(180,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-18 18:56:53','2025-08-18 18:56:53'),
(181,3,'update','Memperbarui data kamar: 110','127.0.0.1',NULL,'resepsionis','\"{\\\"id\\\":10,\\\"number\\\":\\\"110\\\",\\\"type\\\":\\\"baru\\\",\\\"price\\\":\\\"800000.00\\\",\\\"status\\\":\\\"tersedia\\\",\\\"photo\\\":\\\"room-photos\\\\\\/AjRgWVvXriP2wy0YlxJFWEqt9N5HmwWUaZcTv5jJ.jpg\\\",\\\"description\\\":\\\"dummyy\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-08-15T05:12:38.000000Z\\\",\\\"updated_at\\\":\\\"2025-08-15T05:13:12.000000Z\\\"}\"','\"{\\\"number\\\":\\\"110\\\",\\\"type\\\":\\\"baru\\\",\\\"price\\\":\\\"800000.00\\\",\\\"status\\\":\\\"tersedia\\\",\\\"description\\\":\\\"dummy\\\"}\"',NULL,NULL,'2025-08-18 19:11:21','2025-08-18 19:11:21'),
(182,3,'update','Memperbarui data kamar: 110','127.0.0.1',NULL,'resepsionis','\"{\\\"id\\\":10,\\\"number\\\":\\\"110\\\",\\\"type\\\":\\\"baru\\\",\\\"price\\\":\\\"800000.00\\\",\\\"status\\\":\\\"tersedia\\\",\\\"photo\\\":\\\"room-photos\\\\\\/AjRgWVvXriP2wy0YlxJFWEqt9N5HmwWUaZcTv5jJ.jpg\\\",\\\"description\\\":\\\"dummy\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-08-15T05:12:38.000000Z\\\",\\\"updated_at\\\":\\\"2025-08-19T02:11:21.000000Z\\\"}\"','\"{\\\"number\\\":\\\"110\\\",\\\"type\\\":\\\"baru ada\\\",\\\"price\\\":\\\"800000.00\\\",\\\"status\\\":\\\"tersedia\\\",\\\"description\\\":\\\"dummy\\\"}\"',NULL,NULL,'2025-08-18 19:16:57','2025-08-18 19:16:57'),
(183,3,'update','Memperbarui data kamar: 110','127.0.0.1',NULL,'resepsionis','\"{\\\"id\\\":10,\\\"number\\\":\\\"110\\\",\\\"type\\\":\\\"baru ada\\\",\\\"price\\\":\\\"800000.00\\\",\\\"status\\\":\\\"tersedia\\\",\\\"photo\\\":\\\"room-photos\\\\\\/AjRgWVvXriP2wy0YlxJFWEqt9N5HmwWUaZcTv5jJ.jpg\\\",\\\"description\\\":\\\"dummy\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-08-15T05:12:38.000000Z\\\",\\\"updated_at\\\":\\\"2025-08-19T02:16:57.000000Z\\\"}\"','\"{\\\"number\\\":\\\"110\\\",\\\"type\\\":\\\"baru ada\\\",\\\"price\\\":\\\"800000.00\\\",\\\"status\\\":\\\"tersedia\\\",\\\"description\\\":\\\"dummy\\\"}\"',NULL,NULL,'2025-08-18 19:18:29','2025-08-18 19:18:29'),
(184,3,'create','Menambahkan tamu baru: yani','127.0.0.1',NULL,'resepsionis',NULL,'\"{\\\"name\\\":\\\"yani\\\",\\\"phone\\\":\\\"04957355346\\\",\\\"identity_number\\\":\\\"09655448\\\",\\\"updated_at\\\":\\\"2025-08-19T02:21:36.000000Z\\\",\\\"created_at\\\":\\\"2025-08-19T02:21:36.000000Z\\\",\\\"id\\\":10}\"',NULL,NULL,'2025-08-18 19:21:36','2025-08-18 19:21:36'),
(185,3,'delete','Menghapus tamu: yani','127.0.0.1',NULL,'resepsionis','\"{\\\"id\\\":9,\\\"name\\\":\\\"yani\\\",\\\"phone\\\":\\\"04957355346\\\",\\\"identity_number\\\":\\\"84358746535\\\",\\\"created_at\\\":\\\"2025-08-19T02:18:53.000000Z\\\",\\\"updated_at\\\":\\\"2025-08-19T02:18:53.000000Z\\\"}\"',NULL,NULL,NULL,'2025-08-18 19:21:41','2025-08-18 19:21:41'),
(186,3,'update','Memperbarui data tamu: yanii','127.0.0.1',NULL,'resepsionis','\"{\\\"id\\\":10,\\\"name\\\":\\\"yani\\\",\\\"phone\\\":\\\"04957355346\\\",\\\"identity_number\\\":\\\"09655448\\\",\\\"created_at\\\":\\\"2025-08-19T02:21:36.000000Z\\\",\\\"updated_at\\\":\\\"2025-08-19T02:21:36.000000Z\\\"}\"','\"{\\\"name\\\":\\\"yanii\\\",\\\"phone\\\":\\\"04957355346\\\",\\\"identity_number\\\":\\\"09655448\\\"}\"',NULL,NULL,'2025-08-18 19:21:50','2025-08-18 19:21:50'),
(187,3,'create','Membuat booking baru untuk kamar ','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','resepsionis',NULL,NULL,NULL,NULL,'2025-08-18 19:22:21','2025-08-18 19:22:21'),
(188,3,'create','Mencatat pembayaran untuk booking #23','127.0.0.1',NULL,'resepsionis',NULL,NULL,NULL,NULL,'2025-08-18 19:23:15','2025-08-18 19:23:15'),
(189,3,'create','Mencatat pembayaran untuk booking #26','127.0.0.1',NULL,'resepsionis',NULL,NULL,NULL,NULL,'2025-08-18 19:29:28','2025-08-18 19:29:28'),
(190,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-18 20:35:48','2025-08-18 20:35:48'),
(191,2,'create','Mencatat pembayaran untuk booking #29','127.0.0.1',NULL,'admin',NULL,NULL,NULL,NULL,'2025-08-18 20:49:32','2025-08-18 20:49:32'),
(192,2,'delete','Membatalkan booking #28','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin','\"{\\\"id\\\":28,\\\"user_id\\\":2,\\\"guest_id\\\":8,\\\"room_id\\\":6,\\\"check_in\\\":\\\"2025-08-15T00:00:00.000000Z\\\",\\\"check_out\\\":\\\"2025-08-19T00:00:00.000000Z\\\",\\\"status\\\":\\\"booked\\\",\\\"created_at\\\":\\\"2025-08-15T03:14:10.000000Z\\\",\\\"updated_at\\\":\\\"2025-08-15T03:14:10.000000Z\\\",\\\"total_price\\\":0}\"',NULL,NULL,NULL,'2025-08-18 20:49:53','2025-08-18 20:49:53'),
(193,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-18 21:27:28','2025-08-18 21:27:28'),
(194,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-18 21:30:29','2025-08-18 21:30:29'),
(195,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-18 21:31:36','2025-08-18 21:31:36'),
(196,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-18 21:31:44','2025-08-18 21:31:44'),
(197,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-18 21:44:34','2025-08-18 21:44:34'),
(198,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-18 22:52:04','2025-08-18 22:52:04'),
(199,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-18 23:09:00','2025-08-18 23:09:00'),
(200,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-19 00:12:42','2025-08-19 00:12:42'),
(201,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-19 00:14:00','2025-08-19 00:14:00'),
(202,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-19 00:15:39','2025-08-19 00:15:39'),
(203,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-19 00:21:30','2025-08-19 00:21:30'),
(204,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-19 00:23:35','2025-08-19 00:23:35'),
(205,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-19 00:42:59','2025-08-19 00:42:59'),
(206,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-19 01:04:57','2025-08-19 01:04:57'),
(207,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-19 01:12:55','2025-08-19 01:12:55'),
(208,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-19 01:27:40','2025-08-19 01:27:40'),
(209,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-19 01:43:47','2025-08-19 01:43:47'),
(210,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-19 01:47:16','2025-08-19 01:47:16'),
(211,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-19 01:52:09','2025-08-19 01:52:09'),
(212,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-19 19:02:55','2025-08-19 19:02:55'),
(213,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-19 19:14:55','2025-08-19 19:14:55'),
(214,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-19 19:15:07','2025-08-19 19:15:07'),
(215,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-19 19:15:22','2025-08-19 19:15:22'),
(216,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-19 19:18:28','2025-08-19 19:18:28'),
(217,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-19 19:24:30','2025-08-19 19:24:30'),
(218,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-19 19:25:23','2025-08-19 19:25:23'),
(219,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-19 19:33:50','2025-08-19 19:33:50'),
(220,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-19 19:33:55','2025-08-19 19:33:55'),
(221,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-19 19:51:37','2025-08-19 19:51:37'),
(222,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-19 19:51:42','2025-08-19 19:51:42'),
(223,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-19 19:51:53','2025-08-19 19:51:53'),
(224,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-19 19:55:34','2025-08-19 19:55:34'),
(225,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-19 20:27:55','2025-08-19 20:27:55'),
(226,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-19 20:29:31','2025-08-19 20:29:31'),
(227,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-19 20:31:59','2025-08-19 20:31:59'),
(228,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-19 20:32:36','2025-08-19 20:32:36'),
(229,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-19 20:33:46','2025-08-19 20:33:46'),
(230,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-19 20:49:02','2025-08-19 20:49:02'),
(231,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-19 23:00:58','2025-08-19 23:00:58'),
(232,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-19 23:04:09','2025-08-19 23:04:09'),
(233,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-19 23:11:09','2025-08-19 23:11:09'),
(234,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-19 23:16:13','2025-08-19 23:16:13'),
(235,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-19 23:17:48','2025-08-19 23:17:48'),
(236,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-19 23:43:58','2025-08-19 23:43:58'),
(237,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-19 23:44:56','2025-08-19 23:44:56'),
(238,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-20 01:57:15','2025-08-20 01:57:15'),
(239,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-20 21:29:07','2025-08-20 21:29:07'),
(240,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-20 21:30:11','2025-08-20 21:30:11'),
(241,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-20 21:31:38','2025-08-20 21:31:38'),
(242,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-20 21:35:14','2025-08-20 21:35:14'),
(243,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-20 21:39:13','2025-08-20 21:39:13'),
(244,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-20 21:39:18','2025-08-20 21:39:18'),
(245,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-20 21:40:58','2025-08-20 21:40:58'),
(246,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-20 21:47:24','2025-08-20 21:47:24'),
(247,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-20 21:47:41','2025-08-20 21:47:41'),
(248,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-20 21:48:09','2025-08-20 21:48:09'),
(249,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-20 21:49:47','2025-08-20 21:49:47'),
(250,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-20 21:51:30','2025-08-20 21:51:30'),
(251,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-20 21:51:47','2025-08-20 21:51:47'),
(252,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-20 21:52:52','2025-08-20 21:52:52'),
(253,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-20 21:53:07','2025-08-20 21:53:07'),
(254,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-20 21:57:04','2025-08-20 21:57:04'),
(255,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-20 21:57:09','2025-08-20 21:57:09'),
(256,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-20 22:04:05','2025-08-20 22:04:05'),
(257,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-20 22:04:30','2025-08-20 22:04:30'),
(258,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-20 22:05:00','2025-08-20 22:05:00'),
(259,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-20 22:05:08','2025-08-20 22:05:08'),
(260,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-20 22:11:25','2025-08-20 22:11:25'),
(261,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-20 23:12:40','2025-08-20 23:12:40'),
(262,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-20 23:19:20','2025-08-20 23:19:20'),
(263,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-20 23:44:48','2025-08-20 23:44:48'),
(264,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-21 19:28:09','2025-08-21 19:28:09'),
(265,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-21 19:28:38','2025-08-21 19:28:38'),
(266,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-21 19:29:13','2025-08-21 19:29:13'),
(267,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-21 20:12:29','2025-08-21 20:12:29'),
(268,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-21 20:43:45','2025-08-21 20:43:45'),
(269,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-21 20:53:14','2025-08-21 20:53:14'),
(270,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-21 20:53:21','2025-08-21 20:53:21'),
(271,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-21 20:56:31','2025-08-21 20:56:31'),
(272,2,'update','Memperbarui data kamar: 101','127.0.0.1',NULL,'admin','\"{\\\"id\\\":1,\\\"number\\\":\\\"101\\\",\\\"type\\\":\\\"Deluxe\\\",\\\"price\\\":\\\"76000.00\\\",\\\"status\\\":\\\"tersedia\\\",\\\"photo\\\":\\\"room-photos\\\\\\/WRawlDlMNd8zildb5UKNyE9TooDAHs4bOxJOcWTk.png\\\",\\\"description\\\":\\\"Deluxe Room\\\\r\\\\nExperience the perfect blend of comfort and sophistication in our Deluxe Room, thoughtfully designed for discerning guests seeking refined accommodation. Whether for business or leisure, this room offers exceptional amenities and elegant ambiance to ensure a truly memorable stay.\\\\r\\\\n\\\\r\\\\nRoom Features:\\\\r\\\\n-Premium Queen\\\\\\/King-sized bed with luxury linen\\\\r\\\\n-Individually controlled air-conditioning\\\\r\\\\n-Ensuite bathroom with hot shower and exclusive toiletries\\\\r\\\\n-Flat-screen TV with international cable channels\\\\r\\\\n-Complimentary high-speed Wi-Fi\\\\r\\\\n-Functional work desk with ambient lighting\\\\r\\\\n-Daily complimentary bottled water & coffee\\\\\\/tea making facilities\\\\r\\\\n-Wardrobe, digital safe, and large mirror\\\\r\\\\n-Private balcony (available in selected rooms)\\\\r\\\\n-Room Size: \\\\u00b128\\\\u201332 m\\\\u00b2\\\\r\\\\n-Capacity: Up to 2 adults (extra bed available upon request)\\\\r\\\\n-Unwind in style and enjoy warm hospitality with every stay.\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-08-07T05:48:41.000000Z\\\",\\\"updated_at\\\":\\\"2025-08-11T07:05:10.000000Z\\\"}\"','\"{\\\"number\\\":\\\"101\\\",\\\"type\\\":\\\"Deluxe\\\",\\\"price\\\":\\\"76000.00\\\",\\\"status\\\":\\\"tersedia\\\",\\\"description\\\":\\\"Deluxe Room\\\\r\\\\nExperience the perfect blend of comfort and sophistication in our Deluxe Room, thoughtfully designed for discerning guests seeking refined accommodation. Whether for business or leisure, this room offers exceptional amenities and elegant ambiance to ensure a truly memorable stay.\\\\r\\\\n\\\\r\\\\nRoom Features:\\\\r\\\\n-Premium Queen\\\\\\/King-sized bed with luxury linen\\\\r\\\\n-Individually controlled air-conditioning\\\\r\\\\n-Ensuite bathroom with hot shower and exclusive toiletries\\\\r\\\\n-Flat-screen TV with international cable channels\\\\r\\\\n-Complimentary high-speed Wi-Fi\\\\r\\\\n-Functional work desk with ambient lighting\\\\r\\\\n-Daily complimentary bottled water & coffee\\\\\\/tea making facilities\\\\r\\\\n-Wardrobe, digital safe, and large mirror\\\\r\\\\n-Private balcony (available in selected rooms)\\\\r\\\\n-Room Size: \\\\u00b128\\\\u201332 m\\\\u00b2\\\\r\\\\n-Capacity: Up to 2 adults (extra bed available upon request)\\\\r\\\\n-Unwind in style and enjoy warm hospitality with every stay.\\\",\\\"photo\\\":\\\"1755835247_Standard-Room-3.jpg\\\"}\"',NULL,NULL,'2025-08-21 21:00:47','2025-08-21 21:00:47'),
(273,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-21 21:01:27','2025-08-21 21:01:27'),
(274,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-21 21:47:15','2025-08-21 21:47:15'),
(275,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-21 22:43:32','2025-08-21 22:43:32'),
(276,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-21 23:12:00','2025-08-21 23:12:00'),
(277,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-21 23:13:52','2025-08-21 23:13:52'),
(278,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-21 23:14:45','2025-08-21 23:14:45'),
(279,2,'update','Memperbarui data kamar: 102','127.0.0.1',NULL,'admin','\"{\\\"id\\\":2,\\\"number\\\":\\\"102\\\",\\\"type\\\":\\\"Superior Room\\\",\\\"price\\\":\\\"60000.00\\\",\\\"status\\\":\\\"maintenance\\\",\\\"photo\\\":\\\"room-photos\\\\\\/oP5VWzcfk0bL1nCMF9fYjWgw0TFPJPxvvwmnmWv4.jpg\\\",\\\"description\\\":\\\"Superior Room\\\\r\\\\nDiscover understated elegance and modern convenience in our Superior Room, designed to provide a relaxing retreat for both business and leisure travelers. With stylish furnishings and thoughtful amenities, this room promises comfort and practicality for a delightful stay.\\\\r\\\\n\\\\r\\\\nRoom Features:\\\\r\\\\n-Comfortable Queen or Twin-sized bed with soft linen\\\\r\\\\n-Individually controlled air-conditioning\\\\r\\\\n-Ensuite bathroom with hot shower and essential toiletries\\\\r\\\\n-Flat-screen TV with local and international channels\\\\r\\\\n-Complimentary high-speed Wi-Fi\\\\r\\\\n-Functional work desk and reading lamp\\\\r\\\\n-Daily complimentary bottled water & coffee\\\\\\/tea making facilities\\\\r\\\\n-Wardrobe, in-room safe, and vanity mirror\\\\r\\\\n-Private balcony (available in selected rooms)\\\\r\\\\n-Room Size: \\\\u00b124\\\\u201328 m\\\\u00b2\\\\r\\\\n-Capacity: Up to 2 adults\\\\r\\\\n-Enjoy a serene atmosphere and warm hospitality in the heart of your destination.\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-08-07T05:49:30.000000Z\\\",\\\"updated_at\\\":\\\"2025-08-08T02:11:15.000000Z\\\"}\"','\"{\\\"number\\\":\\\"102\\\",\\\"type\\\":\\\"Superior Room\\\",\\\"price\\\":\\\"60000.00\\\",\\\"status\\\":\\\"maintenance\\\",\\\"description\\\":\\\"Superior Room\\\\r\\\\nDiscover understated elegance and modern convenience in our Superior Room, designed to provide a relaxing retreat for both business and leisure travelers. With stylish furnishings and thoughtful amenities, this room promises comfort and practicality for a delightful stay.\\\\r\\\\n\\\\r\\\\nRoom Features:\\\\r\\\\n-Comfortable Queen or Twin-sized bed with soft linen\\\\r\\\\n-Individually controlled air-conditioning\\\\r\\\\n-Ensuite bathroom with hot shower and essential toiletries\\\\r\\\\n-Flat-screen TV with local and international channels\\\\r\\\\n-Complimentary high-speed Wi-Fi\\\\r\\\\n-Functional work desk and reading lamp\\\\r\\\\n-Daily complimentary bottled water & coffee\\\\\\/tea making facilities\\\\r\\\\n-Wardrobe, in-room safe, and vanity mirror\\\\r\\\\n-Private balcony (available in selected rooms)\\\\r\\\\n-Room Size: \\\\u00b124\\\\u201328 m\\\\u00b2\\\\r\\\\n-Capacity: Up to 2 adults\\\\r\\\\n-Enjoy a serene atmosphere and warm hospitality in the heart of your destination.\\\",\\\"photo\\\":\\\"1755843304_superior.jpg\\\"}\"',NULL,NULL,'2025-08-21 23:15:04','2025-08-21 23:15:04'),
(280,2,'update','Memperbarui data kamar: 103','127.0.0.1',NULL,'admin','\"{\\\"id\\\":3,\\\"number\\\":\\\"103\\\",\\\"type\\\":\\\"Standard Room\\\",\\\"price\\\":\\\"78000.00\\\",\\\"status\\\":\\\"dipesan\\\",\\\"photo\\\":\\\"room-photos\\\\\\/yITKNntBiAeZJljeCyLktfh7dPJuTk3IkON6znOD.jpg\\\",\\\"description\\\":\\\"Standard Room\\\\r\\\\nSimplicity meets comfort in our Standard Room, offering a cozy and practical space for travelers seeking excellent value without compromising essential amenities. Ideal for solo guests or couples, this room provides a restful environment for a pleasant and convenient stay.\\\\r\\\\n\\\\r\\\\nRoom Features:\\\\r\\\\n-Comfortable Queen or Twin-sized bed with fresh linen\\\\r\\\\n-Air-conditioning with individual temperature control\\\\r\\\\n-Private bathroom with hot shower and basic toiletries\\\\r\\\\n-Flat-screen TV with local channels\\\\r\\\\n-Complimentary Wi-Fi access\\\\r\\\\n-Compact work desk or bedside table\\\\r\\\\n-Daily complimentary bottled water\\\\r\\\\n-Wardrobe or open hanging rack\\\\r\\\\n-Room Size: \\\\u00b118\\\\u201322 m\\\\u00b2\\\\r\\\\n-Capacity: Up to 2 adults\\\\r\\\\n-A smart choice for budget-conscious guests looking for clean, comfortable, and well-located accommodation.\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-08-07T05:50:32.000000Z\\\",\\\"updated_at\\\":\\\"2025-08-07T12:21:09.000000Z\\\"}\"','\"{\\\"number\\\":\\\"103\\\",\\\"type\\\":\\\"Standard Room\\\",\\\"price\\\":\\\"78000.00\\\",\\\"status\\\":\\\"dipesan\\\",\\\"description\\\":\\\"Standard Room\\\\r\\\\nSimplicity meets comfort in our Standard Room, offering a cozy and practical space for travelers seeking excellent value without compromising essential amenities. Ideal for solo guests or couples, this room provides a restful environment for a pleasant and convenient stay.\\\\r\\\\n\\\\r\\\\nRoom Features:\\\\r\\\\n-Comfortable Queen or Twin-sized bed with fresh linen\\\\r\\\\n-Air-conditioning with individual temperature control\\\\r\\\\n-Private bathroom with hot shower and basic toiletries\\\\r\\\\n-Flat-screen TV with local channels\\\\r\\\\n-Complimentary Wi-Fi access\\\\r\\\\n-Compact work desk or bedside table\\\\r\\\\n-Daily complimentary bottled water\\\\r\\\\n-Wardrobe or open hanging rack\\\\r\\\\n-Room Size: \\\\u00b118\\\\u201322 m\\\\u00b2\\\\r\\\\n-Capacity: Up to 2 adults\\\\r\\\\n-A smart choice for budget-conscious guests looking for clean, comfortable, and well-located accommodation.\\\",\\\"photo\\\":\\\"1755843316_Standard-Room-3.jpg\\\"}\"',NULL,NULL,'2025-08-21 23:15:16','2025-08-21 23:15:16'),
(281,2,'update','Memperbarui data kamar: 104','127.0.0.1',NULL,'admin','\"{\\\"id\\\":4,\\\"number\\\":\\\"104\\\",\\\"type\\\":\\\"Executive Room\\\",\\\"price\\\":\\\"70000.00\\\",\\\"status\\\":\\\"dipesan\\\",\\\"photo\\\":\\\"room-photos\\\\\\/NZ4zDz5Dz5UTFEhh8q76yEOfupWdAYVpIL71TUKg.jpg\\\",\\\"description\\\":\\\"Executive Room\\\\r\\\\nDesigned for business travelers and guests who appreciate extra space and upgraded amenities, our Executive Room combines modern elegance with enhanced comfort. Featuring a spacious layout and thoughtful touches, this room is ideal for extended stays or working on the go.\\\\r\\\\n\\\\r\\\\nRoom Features:\\\\r\\\\n-Premium King or Twin-sized bed with high-quality linen\\\\r\\\\n-Spacious seating area for added comfort\\\\r\\\\n-Individually controlled air-conditioning\\\\r\\\\n-Ensuite bathroom with walk-in shower and deluxe toiletries\\\\r\\\\n-43\\\\\\\" Flat-screen Smart TV with international cable channels\\\\r\\\\n-Complimentary high-speed Wi-Fi\\\\r\\\\n-Executive work desk with ergonomic chair and ambient lighting\\\\r\\\\n-Daily complimentary bottled water, coffee & tea-making facilities\\\\r\\\\n-Mini refrigerator and in-room digital safe\\\\r\\\\n-Full-length mirror and wardrobe with extra storage\\\\r\\\\n-Privatebalcony with city or garden view (available in selectedrooms)\\\\r\\\\n-Room Size: \\\\u00b132\\\\u201338 m\\\\u00b2\\\\r\\\\n-Capacity: Up to 2 adults (extra bed available upon request)\\\\r\\\\n-Experience elevated hospitality with extra space, exclusive comfort, and refined ambiance in every stay.\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-08-07T05:51:30.000000Z\\\",\\\"updated_at\\\":\\\"2025-08-07T12:21:32.000000Z\\\"}\"','\"{\\\"number\\\":\\\"104\\\",\\\"type\\\":\\\"Executive Room\\\",\\\"price\\\":\\\"70000.00\\\",\\\"status\\\":\\\"dipesan\\\",\\\"description\\\":\\\"Executive Room\\\\r\\\\nDesigned for business travelers and guests who appreciate extra space and upgraded amenities, our Executive Room combines modern elegance with enhanced comfort. Featuring a spacious layout and thoughtful touches, this room is ideal for extended stays or working on the go.\\\\r\\\\n\\\\r\\\\nRoom Features:\\\\r\\\\n-Premium King or Twin-sized bed with high-quality linen\\\\r\\\\n-Spacious seating area for added comfort\\\\r\\\\n-Individually controlled air-conditioning\\\\r\\\\n-Ensuite bathroom with walk-in shower and deluxe toiletries\\\\r\\\\n-43\\\\\\\" Flat-screen Smart TV with international cable channels\\\\r\\\\n-Complimentary high-speed Wi-Fi\\\\r\\\\n-Executive work desk with ergonomic chair and ambient lighting\\\\r\\\\n-Daily complimentary bottled water, coffee & tea-making facilities\\\\r\\\\n-Mini refrigerator and in-room digital safe\\\\r\\\\n-Full-length mirror and wardrobe with extra storage\\\\r\\\\n-Privatebalcony with city or garden view (available in selectedrooms)\\\\r\\\\n-Room Size: \\\\u00b132\\\\u201338 m\\\\u00b2\\\\r\\\\n-Capacity: Up to 2 adults (extra bed available upon request)\\\\r\\\\n-Experience elevated hospitality with extra space, exclusive comfort, and refined ambiance in every stay.\\\",\\\"photo\\\":\\\"1755843333_ExecutiveRoom.jpg\\\"}\"',NULL,NULL,'2025-08-21 23:15:33','2025-08-21 23:15:33'),
(282,2,'delete','Menghapus kamar: 110','127.0.0.1',NULL,'admin','\"{\\\"id\\\":10,\\\"number\\\":\\\"110\\\",\\\"type\\\":\\\"baru ada\\\",\\\"price\\\":\\\"800000.00\\\",\\\"status\\\":\\\"tersedia\\\",\\\"photo\\\":\\\"room-photos\\\\\\/AjRgWVvXriP2wy0YlxJFWEqt9N5HmwWUaZcTv5jJ.jpg\\\",\\\"description\\\":\\\"dummy\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-08-15T05:12:38.000000Z\\\",\\\"updated_at\\\":\\\"2025-08-19T02:16:57.000000Z\\\"}\"',NULL,NULL,NULL,'2025-08-21 23:15:37','2025-08-21 23:15:37'),
(283,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-21 23:15:48','2025-08-21 23:15:48'),
(284,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-21 23:20:01','2025-08-21 23:20:01'),
(285,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-21 23:37:52','2025-08-21 23:37:52'),
(286,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-26 00:06:49','2025-08-26 00:06:49'),
(287,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-26 00:11:03','2025-08-26 00:11:03'),
(288,2,'create','Menambahkan kamar baru: 923','127.0.0.1',NULL,'admin',NULL,NULL,NULL,NULL,'2025-08-26 00:46:45','2025-08-26 00:46:45'),
(289,2,'create','Menambahkan kamar baru: 958','127.0.0.1',NULL,'admin',NULL,NULL,NULL,NULL,'2025-08-26 00:47:02','2025-08-26 00:47:02'),
(290,2,'update','Memperbarui booking #29','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin','\"{\\\"id\\\":29,\\\"user_id\\\":3,\\\"guest_id\\\":11,\\\"room_id\\\":10,\\\"check_in\\\":\\\"2025-08-19T00:00:00.000000Z\\\",\\\"check_out\\\":\\\"2025-08-22T00:00:00.000000Z\\\",\\\"status\\\":\\\"paid\\\",\\\"created_at\\\":\\\"2025-08-19T02:22:21.000000Z\\\",\\\"updated_at\\\":\\\"2025-08-19T03:49:32.000000Z\\\",\\\"total_price\\\":0}\"','\"{\\\"guest_id\\\":\\\"11\\\",\\\"new_guest_name\\\":null,\\\"new_guest_phone\\\":null,\\\"new_guest_identity\\\":null,\\\"room_id\\\":\\\"11\\\",\\\"check_in\\\":\\\"2025-08-26\\\",\\\"check_out\\\":\\\"2025-08-29\\\",\\\"status\\\":\\\"booked\\\"}\"',NULL,NULL,'2025-08-26 01:12:52','2025-08-26 01:12:52'),
(291,2,'create','Membuat booking baru untuk kamar ','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-26 01:13:34','2025-08-26 01:13:34'),
(292,2,'create','Mencatat pembayaran untuk booking #30','127.0.0.1',NULL,'admin',NULL,NULL,NULL,NULL,'2025-08-26 01:20:08','2025-08-26 01:20:08'),
(293,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-26 06:12:07','2025-08-26 06:12:07'),
(294,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-26 18:58:36','2025-08-26 18:58:36'),
(295,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-26 20:18:01','2025-08-26 20:18:01'),
(296,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-26 20:55:42','2025-08-26 20:55:42'),
(297,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-27 00:37:11','2025-08-27 00:37:11'),
(298,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-27 00:48:33','2025-08-27 00:48:33'),
(299,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-27 01:16:44','2025-08-27 01:16:44'),
(300,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-27 01:34:29','2025-08-27 01:34:29'),
(301,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-28 19:13:54','2025-08-28 19:13:54'),
(302,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-07 06:21:49','2025-09-07 06:21:49'),
(303,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-07 06:26:04','2025-09-07 06:26:04'),
(304,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (iPhone; CPU iPhone OS 15_0 like Mac OS X) AppleWebKit/603.1.30 (KHTML, like Gecko) Version/17.5 Mobile/15A5370a Safari/602.1','admin',NULL,NULL,NULL,NULL,'2025-09-07 06:27:04','2025-09-07 06:27:04'),
(305,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-07 06:27:19','2025-09-07 06:27:19'),
(306,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-07 19:01:57','2025-09-07 19:01:57'),
(307,2,'delete','Membatalkan booking #22','127.0.0.1','Mozilla/5.0 (iPhone; CPU iPhone OS 15_0 like Mac OS X) AppleWebKit/603.1.30 (KHTML, like Gecko) Version/17.5 Mobile/15A5370a Safari/602.1','admin','\"{\\\"id\\\":22,\\\"user_id\\\":3,\\\"guest_id\\\":1,\\\"room_id\\\":1,\\\"check_in\\\":\\\"2025-08-14T00:00:00.000000Z\\\",\\\"check_out\\\":\\\"2025-08-18T00:00:00.000000Z\\\",\\\"status\\\":\\\"paid\\\",\\\"created_at\\\":\\\"2025-08-14T13:28:44.000000Z\\\",\\\"updated_at\\\":\\\"2025-08-14T13:57:50.000000Z\\\",\\\"total_price\\\":0}\"',NULL,NULL,NULL,'2025-09-07 19:14:06','2025-09-07 19:14:06'),
(308,2,'create','Membuat booking baru untuk kamar ','127.0.0.1','Mozilla/5.0 (iPhone; CPU iPhone OS 15_0 like Mac OS X) AppleWebKit/603.1.30 (KHTML, like Gecko) Version/17.5 Mobile/15A5370a Safari/602.1','admin',NULL,NULL,NULL,NULL,'2025-09-07 19:14:41','2025-09-07 19:14:41'),
(309,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-07 19:41:03','2025-09-07 19:41:03'),
(310,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-07 19:57:55','2025-09-07 19:57:55'),
(311,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-07 19:59:09','2025-09-07 19:59:09'),
(312,2,'create','Menambahkan tamu baru: nara','127.0.0.1',NULL,'admin',NULL,'\"{\\\"name\\\":\\\"nara\\\",\\\"phone\\\":\\\"03583458\\\",\\\"identity_number\\\":\\\"8932746835\\\",\\\"date_of_birth\\\":\\\"2025-09-08T00:00:00.000000Z\\\",\\\"guest_type\\\":\\\"vip\\\",\\\"marital_status\\\":\\\"single\\\",\\\"notes\\\":\\\"alergi\\\",\\\"photo\\\":\\\"1757310469__ (2).jpeg\\\",\\\"updated_at\\\":\\\"2025-09-08T05:47:49.000000Z\\\",\\\"created_at\\\":\\\"2025-09-08T05:47:49.000000Z\\\",\\\"id\\\":14}\"',NULL,NULL,'2025-09-07 22:47:49','2025-09-07 22:47:49'),
(313,2,'update','Memperbarui data tamu: nara','127.0.0.1',NULL,'admin','\"{\\\"id\\\":14,\\\"name\\\":\\\"nara\\\",\\\"phone\\\":\\\"03583458\\\",\\\"identity_number\\\":\\\"8932746835\\\",\\\"created_at\\\":\\\"2025-09-08T05:47:49.000000Z\\\",\\\"updated_at\\\":\\\"2025-09-08T05:47:49.000000Z\\\",\\\"date_of_birth\\\":\\\"2025-09-08T00:00:00.000000Z\\\",\\\"nationality\\\":null,\\\"profession\\\":null,\\\"notes\\\":\\\"alergi\\\",\\\"photo\\\":\\\"1757310469__ (2).jpeg\\\",\\\"marital_status\\\":\\\"single\\\",\\\"loyalty_points\\\":0,\\\"social_account\\\":null,\\\"guest_type\\\":\\\"vip\\\",\\\"health_notes\\\":null}\"','\"{\\\"name\\\":\\\"nara\\\",\\\"phone\\\":\\\"03583458\\\",\\\"identity_number\\\":\\\"8932746835\\\",\\\"date_of_birth\\\":null,\\\"guest_type\\\":\\\"vip\\\",\\\"marital_status\\\":\\\"single\\\",\\\"notes\\\":\\\"mriyan\\\"}\"',NULL,NULL,'2025-09-07 23:18:38','2025-09-07 23:18:38'),
(314,2,'update','Memperbarui data tamu: nara','127.0.0.1',NULL,'admin','\"{\\\"id\\\":14,\\\"name\\\":\\\"nara\\\",\\\"phone\\\":\\\"03583458\\\",\\\"identity_number\\\":\\\"8932746835\\\",\\\"created_at\\\":\\\"2025-09-08T05:47:49.000000Z\\\",\\\"updated_at\\\":\\\"2025-09-08T06:18:38.000000Z\\\",\\\"date_of_birth\\\":null,\\\"nationality\\\":null,\\\"profession\\\":null,\\\"notes\\\":\\\"mriyan\\\",\\\"photo\\\":\\\"1757310469__ (2).jpeg\\\",\\\"marital_status\\\":\\\"single\\\",\\\"loyalty_points\\\":0,\\\"social_account\\\":null,\\\"guest_type\\\":\\\"vip\\\",\\\"health_notes\\\":null}\"','\"{\\\"name\\\":\\\"nara\\\",\\\"phone\\\":\\\"03583458\\\",\\\"identity_number\\\":\\\"8932746835\\\",\\\"date_of_birth\\\":\\\"2005-01-02\\\",\\\"guest_type\\\":\\\"vip\\\",\\\"marital_status\\\":\\\"single\\\",\\\"notes\\\":\\\"mriyan\\\"}\"',NULL,NULL,'2025-09-07 23:19:48','2025-09-07 23:19:48'),
(315,2,'update','Memperbarui data tamu: naura','127.0.0.1',NULL,'admin','\"{\\\"id\\\":7,\\\"name\\\":\\\"naura\\\",\\\"phone\\\":\\\"098737374\\\",\\\"identity_number\\\":\\\"327458433\\\",\\\"created_at\\\":\\\"2025-08-15T03:12:12.000000Z\\\",\\\"updated_at\\\":\\\"2025-08-15T03:12:12.000000Z\\\",\\\"date_of_birth\\\":null,\\\"nationality\\\":null,\\\"profession\\\":null,\\\"notes\\\":null,\\\"photo\\\":null,\\\"marital_status\\\":null,\\\"loyalty_points\\\":0,\\\"social_account\\\":null,\\\"guest_type\\\":\\\"reguler\\\",\\\"health_notes\\\":null}\"','\"{\\\"name\\\":\\\"naura\\\",\\\"phone\\\":\\\"098737374\\\",\\\"identity_number\\\":\\\"327458433\\\",\\\"date_of_birth\\\":null,\\\"guest_type\\\":\\\"reguler\\\",\\\"marital_status\\\":null,\\\"notes\\\":null}\"',NULL,NULL,'2025-09-07 23:20:25','2025-09-07 23:20:25'),
(316,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-08 11:24:50','2025-09-08 11:24:50'),
(317,2,'update','Memperbarui data tamu: nara','127.0.0.1',NULL,'admin','\"{\\\"id\\\":14,\\\"name\\\":\\\"nara\\\",\\\"phone\\\":\\\"03583458\\\",\\\"identity_number\\\":\\\"8932746835\\\",\\\"created_at\\\":\\\"2025-09-08T05:47:49.000000Z\\\",\\\"updated_at\\\":\\\"2025-09-08T06:19:48.000000Z\\\",\\\"date_of_birth\\\":\\\"2005-01-02T00:00:00.000000Z\\\",\\\"nationality\\\":null,\\\"profession\\\":null,\\\"notes\\\":\\\"mriyan\\\",\\\"photo\\\":\\\"1757310469__ (2).jpeg\\\",\\\"marital_status\\\":\\\"single\\\",\\\"loyalty_points\\\":0,\\\"social_account\\\":null,\\\"guest_type\\\":\\\"vip\\\",\\\"health_notes\\\":null}\"','\"{\\\"name\\\":\\\"nara\\\",\\\"phone\\\":\\\"03583458\\\",\\\"identity_number\\\":\\\"8932746835\\\",\\\"date_of_birth\\\":\\\"2005-01-02\\\",\\\"guest_type\\\":\\\"vip\\\",\\\"marital_status\\\":\\\"single\\\",\\\"notes\\\":\\\"suka sarapan pagi\\\"}\"',NULL,NULL,'2025-09-08 11:25:33','2025-09-08 11:25:33'),
(318,2,'create','Menambahkan tamu baru: jena','127.0.0.1',NULL,'admin',NULL,'\"{\\\"name\\\":\\\"jena\\\",\\\"phone\\\":\\\"043857857645\\\",\\\"identity_number\\\":\\\"0845783\\\",\\\"date_of_birth\\\":\\\"1994-01-10T00:00:00.000000Z\\\",\\\"guest_type\\\":\\\"vvip\\\",\\\"marital_status\\\":\\\"married\\\",\\\"notes\\\":\\\"suka sarapan\\\",\\\"photo\\\":\\\"1757356227__.jpeg\\\",\\\"updated_at\\\":\\\"2025-09-08T18:30:27.000000Z\\\",\\\"created_at\\\":\\\"2025-09-08T18:30:27.000000Z\\\",\\\"id\\\":15}\"',NULL,NULL,'2025-09-08 11:30:27','2025-09-08 11:30:27'),
(319,2,'create','Menambahkan tamu baru: ana','127.0.0.1',NULL,'admin',NULL,'\"{\\\"name\\\":\\\"ana\\\",\\\"phone\\\":\\\"084637462342\\\",\\\"identity_number\\\":\\\"875834785\\\",\\\"email\\\":\\\"ana@gmail.com\\\",\\\"date_of_birth\\\":\\\"2002-02-13T00:00:00.000000Z\\\",\\\"gender\\\":\\\"female\\\",\\\"address\\\":\\\"dummy\\\",\\\"guest_type\\\":\\\"reguler\\\",\\\"marital_status\\\":\\\"single\\\",\\\"notes\\\":\\\"suka sarapan pagi\\\",\\\"photo\\\":\\\"1757357050__ (2).jpeg\\\",\\\"updated_at\\\":\\\"2025-09-08T18:44:10.000000Z\\\",\\\"created_at\\\":\\\"2025-09-08T18:44:10.000000Z\\\",\\\"id\\\":16}\"',NULL,NULL,'2025-09-08 11:44:10','2025-09-08 11:44:10'),
(320,2,'create','Menambahkan tamu baru: nanda','127.0.0.1',NULL,'admin',NULL,'\"{\\\"name\\\":\\\"nanda\\\",\\\"phone\\\":\\\"083117711364\\\",\\\"identity_number\\\":\\\"12345678\\\",\\\"email\\\":\\\"nanda@gmail.com\\\",\\\"date_of_birth\\\":\\\"1994-07-06T00:00:00.000000Z\\\",\\\"gender\\\":\\\"female\\\",\\\"address\\\":\\\"dummy\\\",\\\"guest_type\\\":\\\"vvip\\\",\\\"marital_status\\\":\\\"married\\\",\\\"notes\\\":\\\"dummy\\\",\\\"photo\\\":\\\"1757359311__ (2).jpeg\\\",\\\"guest_code\\\":\\\"TM250001\\\",\\\"updated_at\\\":\\\"2025-09-08T19:21:51.000000Z\\\",\\\"created_at\\\":\\\"2025-09-08T19:21:51.000000Z\\\",\\\"id\\\":17}\"',NULL,NULL,'2025-09-08 12:21:51','2025-09-08 12:21:51'),
(321,2,'delete','Menghapus tamu: ana','127.0.0.1',NULL,'admin','\"{\\\"id\\\":16,\\\"guest_code\\\":\\\"\\\",\\\"name\\\":\\\"ana\\\",\\\"phone\\\":\\\"084637462342\\\",\\\"identity_number\\\":\\\"875834785\\\",\\\"email\\\":null,\\\"gender\\\":null,\\\"address\\\":null,\\\"created_at\\\":\\\"2025-09-08T18:44:10.000000Z\\\",\\\"updated_at\\\":\\\"2025-09-08T18:44:10.000000Z\\\",\\\"date_of_birth\\\":\\\"2002-02-13T00:00:00.000000Z\\\",\\\"nationality\\\":null,\\\"profession\\\":null,\\\"notes\\\":\\\"suka sarapan pagi\\\",\\\"photo\\\":\\\"1757357050__ (2).jpeg\\\",\\\"marital_status\\\":\\\"single\\\",\\\"loyalty_points\\\":0,\\\"social_account\\\":null,\\\"guest_type\\\":\\\"reguler\\\",\\\"health_notes\\\":null}\"',NULL,NULL,NULL,'2025-09-08 12:32:20','2025-09-08 12:32:20'),
(322,2,'delete','Membatalkan booking #23','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin','\"{\\\"id\\\":23,\\\"user_id\\\":3,\\\"guest_id\\\":2,\\\"room_id\\\":2,\\\"check_in\\\":\\\"2025-08-16T00:00:00.000000Z\\\",\\\"check_out\\\":\\\"2025-08-18T00:00:00.000000Z\\\",\\\"status\\\":\\\"paid\\\",\\\"created_at\\\":\\\"2025-08-14T13:56:02.000000Z\\\",\\\"updated_at\\\":\\\"2025-08-14T14:00:41.000000Z\\\",\\\"total_price\\\":0}\"',NULL,NULL,NULL,'2025-09-08 12:36:25','2025-09-08 12:36:25'),
(323,2,'delete','Membatalkan booking #24','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin','\"{\\\"id\\\":24,\\\"user_id\\\":3,\\\"guest_id\\\":3,\\\"room_id\\\":3,\\\"check_in\\\":\\\"2025-08-14T00:00:00.000000Z\\\",\\\"check_out\\\":\\\"2025-08-19T00:00:00.000000Z\\\",\\\"status\\\":\\\"checked_out\\\",\\\"created_at\\\":\\\"2025-08-14T13:56:21.000000Z\\\",\\\"updated_at\\\":\\\"2025-08-14T13:56:21.000000Z\\\",\\\"total_price\\\":0}\"',NULL,NULL,NULL,'2025-09-08 12:39:53','2025-09-08 12:39:53'),
(324,2,'update','Memperbarui booking #26','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin','\"{\\\"id\\\":26,\\\"user_id\\\":3,\\\"guest_id\\\":4,\\\"room_id\\\":3,\\\"check_in\\\":\\\"2025-08-14T00:00:00.000000Z\\\",\\\"check_out\\\":\\\"2025-08-19T00:00:00.000000Z\\\",\\\"status\\\":\\\"paid\\\",\\\"created_at\\\":\\\"2025-08-14T13:57:08.000000Z\\\",\\\"updated_at\\\":\\\"2025-08-14T14:00:54.000000Z\\\",\\\"total_price\\\":0}\"','\"{\\\"guest_id\\\":\\\"3\\\",\\\"new_guest_name\\\":null,\\\"new_guest_phone\\\":null,\\\"new_guest_identity\\\":null,\\\"room_id\\\":\\\"3\\\",\\\"check_in\\\":\\\"2025-09-09\\\",\\\"check_out\\\":\\\"2025-09-11\\\",\\\"status\\\":\\\"booked\\\"}\"',NULL,NULL,'2025-09-08 12:40:53','2025-09-08 12:40:53'),
(325,2,'update','Memperbarui booking #26','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin','\"{\\\"id\\\":26,\\\"user_id\\\":3,\\\"guest_id\\\":3,\\\"room_id\\\":3,\\\"check_in\\\":\\\"2025-09-09T00:00:00.000000Z\\\",\\\"check_out\\\":\\\"2025-09-11T00:00:00.000000Z\\\",\\\"status\\\":\\\"booked\\\",\\\"created_at\\\":\\\"2025-08-14T13:57:08.000000Z\\\",\\\"updated_at\\\":\\\"2025-09-08T19:40:53.000000Z\\\",\\\"total_price\\\":0}\"','\"{\\\"guest_id\\\":\\\"1\\\",\\\"new_guest_name\\\":null,\\\"new_guest_phone\\\":null,\\\"new_guest_identity\\\":null,\\\"room_id\\\":\\\"3\\\",\\\"check_in\\\":\\\"2025-09-09\\\",\\\"check_out\\\":\\\"2025-09-11\\\",\\\"status\\\":\\\"booked\\\"}\"',NULL,NULL,'2025-09-08 12:42:23','2025-09-08 12:42:23'),
(326,2,'update','Memperbarui data kamar: 101','127.0.0.1',NULL,'admin','\"{\\\"id\\\":1,\\\"number\\\":\\\"101\\\",\\\"type\\\":\\\"Deluxe\\\",\\\"price\\\":\\\"76000.00\\\",\\\"status\\\":\\\"tersedia\\\",\\\"photo\\\":\\\"1755835247_Standard-Room-3.jpg\\\",\\\"description\\\":\\\"Deluxe Room\\\\r\\\\nExperience the perfect blend of comfort and sophistication in our Deluxe Room, thoughtfully designed for discerning guests seeking refined accommodation. Whether for business or leisure, this room offers exceptional amenities and elegant ambiance to ensure a truly memorable stay.\\\\r\\\\n\\\\r\\\\nRoom Features:\\\\r\\\\n-Premium Queen\\\\\\/King-sized bed with luxury linen\\\\r\\\\n-Individually controlled air-conditioning\\\\r\\\\n-Ensuite bathroom with hot shower and exclusive toiletries\\\\r\\\\n-Flat-screen TV with international cable channels\\\\r\\\\n-Complimentary high-speed Wi-Fi\\\\r\\\\n-Functional work desk with ambient lighting\\\\r\\\\n-Daily complimentary bottled water & coffee\\\\\\/tea making facilities\\\\r\\\\n-Wardrobe, digital safe, and large mirror\\\\r\\\\n-Private balcony (available in selected rooms)\\\\r\\\\n-Room Size: \\\\u00b128\\\\u201332 m\\\\u00b2\\\\r\\\\n-Capacity: Up to 2 adults (extra bed available upon request)\\\\r\\\\n-Unwind in style and enjoy warm hospitality with every stay.\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-08-07T05:48:41.000000Z\\\",\\\"updated_at\\\":\\\"2025-08-22T04:00:47.000000Z\\\"}\"','\"{\\\"number\\\":\\\"101\\\",\\\"type_id\\\":\\\"1\\\",\\\"price\\\":\\\"76000.00\\\",\\\"status\\\":\\\"tersedia\\\",\\\"description\\\":\\\"Deluxe Room\\\\r\\\\nExperience the perfect blend of comfort and sophistication in our Deluxe Room, thoughtfully designed for discerning guests seeking refined accommodation. Whether for business or leisure, this room offers exceptional amenities and elegant ambiance to ensure a truly memorable stay.\\\\r\\\\n\\\\r\\\\nRoom Features:\\\\r\\\\n-Premium Queen\\\\\\/King-sized bed with luxury linen\\\\r\\\\n-Individually controlled air-conditioning\\\\r\\\\n-Ensuite bathroom with hot shower and exclusive toiletries\\\\r\\\\n-Flat-screen TV with international cable channels\\\\r\\\\n-Complimentary high-speed Wi-Fi\\\\r\\\\n-Functional work desk with ambient lighting\\\\r\\\\n-Daily complimentary bottled water & coffee\\\\\\/tea making facilities\\\\r\\\\n-Wardrobe, digital safe, and large mirror\\\\r\\\\n-Private balcony (available in selected rooms)\\\\r\\\\n-Room Size: \\\\u00b128\\\\u201332 m\\\\u00b2\\\\r\\\\n-Capacity: Up to 2 adults (extra bed available upon request)\\\\r\\\\n-Unwind in style and enjoy warm hospitality with every stay.\\\"}\"',NULL,NULL,'2025-09-08 12:45:11','2025-09-08 12:45:11'),
(327,2,'create','Menambahkan kamar baru: 878','127.0.0.1',NULL,'admin',NULL,NULL,NULL,NULL,'2025-09-08 12:47:59','2025-09-08 12:47:59'),
(328,2,'update','Memperbarui data kamar: 878','127.0.0.1',NULL,'admin','\"{\\\"id\\\":13,\\\"number\\\":\\\"878\\\",\\\"type\\\":\\\"1\\\",\\\"price\\\":\\\"700000.00\\\",\\\"status\\\":\\\"tersedia\\\",\\\"photo\\\":null,\\\"description\\\":\\\"dummy\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-09-08T19:47:59.000000Z\\\",\\\"updated_at\\\":\\\"2025-09-08T19:47:59.000000Z\\\"}\"','\"{\\\"number\\\":\\\"878\\\",\\\"type\\\":\\\"1\\\",\\\"price\\\":\\\"700000.00\\\",\\\"status\\\":\\\"tersedia\\\",\\\"description\\\":\\\"dummy\\\"}\"',NULL,NULL,'2025-09-08 12:48:20','2025-09-08 12:48:20'),
(329,2,'update','Memperbarui data kamar: 878','127.0.0.1',NULL,'admin','\"{\\\"id\\\":13,\\\"number\\\":\\\"878\\\",\\\"type\\\":\\\"1\\\",\\\"price\\\":\\\"700000.00\\\",\\\"status\\\":\\\"tersedia\\\",\\\"photo\\\":null,\\\"description\\\":\\\"dummy\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-09-08T19:47:59.000000Z\\\",\\\"updated_at\\\":\\\"2025-09-08T19:47:59.000000Z\\\"}\"','\"{\\\"number\\\":\\\"878\\\",\\\"type\\\":\\\"1\\\",\\\"price\\\":\\\"700000.00\\\",\\\"status\\\":\\\"tersedia\\\",\\\"description\\\":\\\"dummy\\\"}\"',NULL,NULL,'2025-09-08 12:54:27','2025-09-08 12:54:27'),
(330,2,'create','Menambahkan kamar baru: 829','127.0.0.1',NULL,'admin',NULL,NULL,NULL,NULL,'2025-09-08 12:54:45','2025-09-08 12:54:45'),
(331,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-08 19:03:48','2025-09-08 19:03:48'),
(332,2,'update','Memperbarui data kamar: 958','127.0.0.1',NULL,'admin','\"{\\\"id\\\":12,\\\"number\\\":\\\"958\\\",\\\"type\\\":\\\"kdfir\\\",\\\"price\\\":\\\"800000.00\\\",\\\"status\\\":\\\"terisi\\\",\\\"photo\\\":null,\\\"description\\\":\\\"lndfkjrsngkr\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-08-26T07:47:02.000000Z\\\",\\\"updated_at\\\":\\\"2025-08-26T07:47:02.000000Z\\\"}\"','\"{\\\"number\\\":\\\"958\\\",\\\"type\\\":\\\"1\\\",\\\"price\\\":\\\"800000.00\\\",\\\"status\\\":\\\"terisi\\\",\\\"description\\\":\\\"lndfkjrsngkr\\\"}\"',NULL,NULL,'2025-09-08 19:04:32','2025-09-08 19:04:32'),
(333,2,'update','Memperbarui data kamar: 829','127.0.0.1',NULL,'admin','\"{\\\"id\\\":14,\\\"number\\\":\\\"829\\\",\\\"type\\\":\\\"1\\\",\\\"price\\\":\\\"300000.00\\\",\\\"status\\\":\\\"tersedia\\\",\\\"photo\\\":null,\\\"description\\\":\\\"dummy\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-09-08T19:54:45.000000Z\\\",\\\"updated_at\\\":\\\"2025-09-08T19:54:45.000000Z\\\"}\"','\"{\\\"number\\\":\\\"829\\\",\\\"type\\\":\\\"1\\\",\\\"price\\\":\\\"300000.00\\\",\\\"status\\\":\\\"tersedia\\\",\\\"description\\\":\\\"dummy\\\"}\"',NULL,NULL,'2025-09-08 19:10:17','2025-09-08 19:10:17'),
(334,2,'delete','Menghapus kamar: 829','127.0.0.1',NULL,'admin','\"{\\\"id\\\":14,\\\"number\\\":\\\"829\\\",\\\"type\\\":\\\"1\\\",\\\"price\\\":\\\"300000.00\\\",\\\"status\\\":\\\"tersedia\\\",\\\"photo\\\":null,\\\"description\\\":\\\"dummy\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-09-08T19:54:45.000000Z\\\",\\\"updated_at\\\":\\\"2025-09-08T19:54:45.000000Z\\\"}\"',NULL,NULL,NULL,'2025-09-08 19:10:23','2025-09-08 19:10:23'),
(335,2,'create','Menambahkan kamar baru: 484','127.0.0.1',NULL,'admin',NULL,NULL,NULL,NULL,'2025-09-08 19:10:46','2025-09-08 19:10:46'),
(336,2,'create','Menambahkan kamar baru: 874','127.0.0.1',NULL,'admin',NULL,NULL,NULL,NULL,'2025-09-08 19:15:54','2025-09-08 19:15:54'),
(337,2,'delete','Menghapus kamar: 958','127.0.0.1',NULL,'admin','\"{\\\"id\\\":12,\\\"number\\\":\\\"958\\\",\\\"type\\\":\\\"1\\\",\\\"price\\\":\\\"800000.00\\\",\\\"status\\\":\\\"terisi\\\",\\\"photo\\\":null,\\\"description\\\":\\\"lndfkjrsngkr\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-08-26T07:47:02.000000Z\\\",\\\"updated_at\\\":\\\"2025-09-09T02:04:32.000000Z\\\"}\"',NULL,NULL,NULL,'2025-09-08 19:23:34','2025-09-08 19:23:34'),
(338,2,'delete','Menghapus kamar: 878','127.0.0.1',NULL,'admin','\"{\\\"id\\\":13,\\\"number\\\":\\\"878\\\",\\\"type\\\":\\\"1\\\",\\\"price\\\":\\\"700000.00\\\",\\\"status\\\":\\\"tersedia\\\",\\\"photo\\\":null,\\\"description\\\":\\\"dummy\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-09-08T19:47:59.000000Z\\\",\\\"updated_at\\\":\\\"2025-09-08T19:47:59.000000Z\\\"}\"',NULL,NULL,NULL,'2025-09-08 19:23:39','2025-09-08 19:23:39'),
(339,2,'delete','Menghapus kamar: 484','127.0.0.1',NULL,'admin','\"{\\\"id\\\":15,\\\"number\\\":\\\"484\\\",\\\"type\\\":\\\"1\\\",\\\"price\\\":\\\"400000.00\\\",\\\"status\\\":\\\"tersedia\\\",\\\"photo\\\":null,\\\"description\\\":\\\"dummy\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-09-09T02:10:46.000000Z\\\",\\\"updated_at\\\":\\\"2025-09-09T02:10:46.000000Z\\\"}\"',NULL,NULL,NULL,'2025-09-08 19:23:43','2025-09-08 19:23:43'),
(340,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-09 18:59:45','2025-09-09 18:59:45'),
(341,2,'create','Membuat booking baru untuk kamar ','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-09 19:12:25','2025-09-09 19:12:25'),
(342,2,'create','Menambahkan kamar baru: 758','127.0.0.1',NULL,'admin',NULL,NULL,NULL,NULL,'2025-09-09 19:48:39','2025-09-09 19:48:39'),
(343,2,'create','Menambahkan kamar baru: 893','127.0.0.1',NULL,'admin',NULL,NULL,NULL,NULL,'2025-09-09 19:49:03','2025-09-09 19:49:03'),
(344,2,'create','Membuat booking baru untuk kamar 758','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-09 19:55:28','2025-09-09 19:55:28'),
(345,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-10 19:23:41','2025-09-10 19:23:41'),
(346,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-10 19:48:26','2025-09-10 19:48:26'),
(347,2,'create','Menambahkan kamar baru: 333','127.0.0.1',NULL,'admin',NULL,NULL,NULL,NULL,'2025-09-10 22:59:47','2025-09-10 22:59:47'),
(348,2,'update','Memperbarui data kamar: 333','127.0.0.1',NULL,'admin','\"{\\\"id\\\":19,\\\"number\\\":\\\"333\\\",\\\"price\\\":\\\"900000.00\\\",\\\"status\\\":\\\"terisi\\\",\\\"photo\\\":null,\\\"description\\\":\\\"wewewe\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-09-11T05:59:47.000000Z\\\",\\\"updated_at\\\":\\\"2025-09-11T05:59:47.000000Z\\\",\\\"tipe_kamar_id\\\":null}\"','\"{\\\"number\\\":\\\"333\\\",\\\"tipe_kamar_id\\\":\\\"2\\\",\\\"price\\\":\\\"900000.00\\\",\\\"status\\\":\\\"terisi\\\",\\\"description\\\":\\\"wewewe\\\"}\"',NULL,NULL,'2025-09-10 23:05:49','2025-09-10 23:05:49'),
(349,2,'delete','Menghapus kamar: 333','127.0.0.1',NULL,'admin','\"{\\\"id\\\":19,\\\"number\\\":\\\"333\\\",\\\"price\\\":\\\"900000.00\\\",\\\"status\\\":\\\"terisi\\\",\\\"photo\\\":null,\\\"description\\\":\\\"wewewe\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-09-11T05:59:47.000000Z\\\",\\\"updated_at\\\":\\\"2025-09-11T05:59:47.000000Z\\\",\\\"tipe_kamar_id\\\":null}\"',NULL,NULL,NULL,'2025-09-10 23:05:55','2025-09-10 23:05:55'),
(350,2,'create','Menambahkan kamar baru: 999','127.0.0.1',NULL,'admin',NULL,NULL,NULL,NULL,'2025-09-10 23:06:13','2025-09-10 23:06:13'),
(351,2,'create','Menambahkan kamar baru: 111','127.0.0.1',NULL,'admin',NULL,NULL,NULL,NULL,'2025-09-10 23:06:34','2025-09-10 23:06:34'),
(352,2,'create','Menambahkan kamar baru: 666','127.0.0.1',NULL,'admin',NULL,NULL,NULL,NULL,'2025-09-10 23:09:24','2025-09-10 23:09:24'),
(353,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-11 17:43:36','2025-09-11 17:43:36'),
(354,2,'create','Menambahkan kamar baru: 900','127.0.0.1',NULL,'admin',NULL,NULL,NULL,NULL,'2025-09-11 17:46:28','2025-09-11 17:46:28'),
(355,2,'delete','Menghapus kamar: 666','127.0.0.1',NULL,'admin','\"{\\\"id\\\":22,\\\"number\\\":\\\"666\\\",\\\"price\\\":\\\"300000.00\\\",\\\"status\\\":\\\"tersedia\\\",\\\"photo\\\":null,\\\"description\\\":\\\"dwe\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-09-11T06:09:24.000000Z\\\",\\\"updated_at\\\":\\\"2025-09-11T06:09:24.000000Z\\\",\\\"tipe_kamar_id\\\":null}\"',NULL,NULL,NULL,'2025-09-11 18:20:31','2025-09-11 18:20:31'),
(356,2,'delete','Menghapus kamar: 900','127.0.0.1',NULL,'admin','\"{\\\"id\\\":23,\\\"number\\\":\\\"900\\\",\\\"price\\\":\\\"300000.00\\\",\\\"status\\\":\\\"tersedia\\\",\\\"photo\\\":null,\\\"description\\\":\\\"msdf\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-09-12T00:46:28.000000Z\\\",\\\"updated_at\\\":\\\"2025-09-12T00:46:28.000000Z\\\",\\\"tipe_kamar_id\\\":null}\"',NULL,NULL,NULL,'2025-09-11 18:20:36','2025-09-11 18:20:36'),
(357,2,'create','Menambahkan kamar baru: 289','127.0.0.1',NULL,'admin',NULL,NULL,NULL,NULL,'2025-09-11 18:20:51','2025-09-11 18:20:51'),
(358,2,'update','Memperbarui data kamar: 289','127.0.0.1',NULL,'admin','\"{\\\"id\\\":24,\\\"number\\\":\\\"289\\\",\\\"price\\\":\\\"200000.00\\\",\\\"status\\\":\\\"tersedia\\\",\\\"photo\\\":null,\\\"description\\\":\\\"fwd\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-09-12T01:20:51.000000Z\\\",\\\"updated_at\\\":\\\"2025-09-12T01:20:51.000000Z\\\",\\\"tipe_kamar_id\\\":null}\"','\"{\\\"number\\\":\\\"289\\\",\\\"tipe_kamar_id\\\":\\\"1\\\",\\\"price\\\":\\\"200000.00\\\",\\\"status\\\":\\\"tersedia\\\",\\\"description\\\":\\\"fwd\\\"}\"',NULL,NULL,'2025-09-11 18:55:27','2025-09-11 18:55:27'),
(359,2,'update','Memperbarui data kamar: 289','127.0.0.1',NULL,'admin','\"{\\\"id\\\":24,\\\"number\\\":\\\"289\\\",\\\"price\\\":\\\"200000.00\\\",\\\"status\\\":\\\"tersedia\\\",\\\"photo\\\":null,\\\"description\\\":\\\"fwd\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-09-12T01:20:51.000000Z\\\",\\\"updated_at\\\":\\\"2025-09-12T01:55:27.000000Z\\\",\\\"tipe_kamar_id\\\":1}\"','\"{\\\"number\\\":\\\"289\\\",\\\"tipe_kamar_id\\\":\\\"2\\\",\\\"price\\\":\\\"200000.00\\\",\\\"status\\\":\\\"tersedia\\\",\\\"description\\\":\\\"fwd\\\"}\"',NULL,NULL,'2025-09-11 18:55:36','2025-09-11 18:55:36'),
(360,2,'create','Menambahkan kamar baru: 892','127.0.0.1',NULL,'admin',NULL,NULL,NULL,NULL,'2025-09-11 18:55:56','2025-09-11 18:55:56'),
(361,2,'update','Memperbarui data kamar: 892','127.0.0.1',NULL,'admin','\"{\\\"id\\\":25,\\\"number\\\":\\\"892\\\",\\\"price\\\":\\\"200000.00\\\",\\\"status\\\":\\\"tersedia\\\",\\\"photo\\\":null,\\\"description\\\":\\\"asdas\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-09-12T01:55:56.000000Z\\\",\\\"updated_at\\\":\\\"2025-09-12T01:55:56.000000Z\\\",\\\"tipe_kamar_id\\\":3}\"','\"{\\\"number\\\":\\\"892\\\",\\\"tipe_kamar_id\\\":\\\"3\\\",\\\"price\\\":\\\"200000.00\\\",\\\"status\\\":\\\"terisi\\\",\\\"description\\\":\\\"asdas\\\"}\"',NULL,NULL,'2025-09-11 18:56:22','2025-09-11 18:56:22'),
(362,2,'update','Memperbarui data kamar: 892','127.0.0.1',NULL,'admin','\"{\\\"id\\\":25,\\\"number\\\":\\\"892\\\",\\\"price\\\":\\\"200000.00\\\",\\\"status\\\":\\\"terisi\\\",\\\"photo\\\":null,\\\"description\\\":\\\"asdas\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-09-12T01:55:56.000000Z\\\",\\\"updated_at\\\":\\\"2025-09-12T01:56:22.000000Z\\\",\\\"tipe_kamar_id\\\":3}\"','\"{\\\"number\\\":\\\"892\\\",\\\"tipe_kamar_id\\\":\\\"3\\\",\\\"price\\\":\\\"200000.00\\\",\\\"status\\\":\\\"tersedia\\\",\\\"description\\\":\\\"asdas\\\"}\"',NULL,NULL,'2025-09-11 19:13:20','2025-09-11 19:13:20'),
(363,2,'create','Membuat booking baru untuk kamar 892 (Superior Room)','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-11 19:55:16','2025-09-11 19:55:16'),
(364,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-11 21:26:38','2025-09-11 21:26:38'),
(365,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-11 21:26:38','2025-09-11 21:26:38'),
(366,2,'create','Mencatat pembayaran untuk booking #34','127.0.0.1',NULL,'admin',NULL,NULL,NULL,NULL,'2025-09-11 21:27:13','2025-09-11 21:27:13'),
(367,2,'delete','Membatalkan booking #30 untuk kamar Room Deleted','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin','\"{\\\"id\\\":30,\\\"user_id\\\":2,\\\"guest_id\\\":12,\\\"room_id\\\":12,\\\"check_in\\\":\\\"2025-08-26T00:00:00.000000Z\\\",\\\"check_out\\\":\\\"2025-08-30T00:00:00.000000Z\\\",\\\"status\\\":\\\"paid\\\",\\\"created_at\\\":\\\"2025-08-26T08:13:34.000000Z\\\",\\\"updated_at\\\":\\\"2025-08-26T08:20:08.000000Z\\\",\\\"total_price\\\":0,\\\"room\\\":{\\\"number\\\":\\\"Room Deleted\\\"}}\"',NULL,NULL,NULL,'2025-09-11 21:28:14','2025-09-11 21:28:14'),
(368,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-14 19:15:11','2025-09-14 19:15:11'),
(369,2,'delete','Menghapus tamu: Budi Santoso','127.0.0.1',NULL,'admin','\"{\\\"id\\\":3,\\\"guest_code\\\":\\\"\\\",\\\"name\\\":\\\"Budi Santoso\\\",\\\"phone\\\":\\\"0857-2233-4455\\\",\\\"identity_number\\\":\\\"3301042108900003\\\",\\\"email\\\":null,\\\"gender\\\":null,\\\"address\\\":null,\\\"created_at\\\":\\\"2025-08-07T05:58:40.000000Z\\\",\\\"updated_at\\\":\\\"2025-08-07T05:58:40.000000Z\\\",\\\"date_of_birth\\\":null,\\\"nationality\\\":null,\\\"profession\\\":null,\\\"notes\\\":null,\\\"photo\\\":null,\\\"marital_status\\\":null,\\\"loyalty_points\\\":0,\\\"social_account\\\":null,\\\"guest_type\\\":\\\"reguler\\\",\\\"health_notes\\\":null}\"',NULL,NULL,NULL,'2025-09-14 19:19:26','2025-09-14 19:19:26'),
(370,2,'update','Memperbarui data kamar: 101','127.0.0.1',NULL,'admin','\"{\\\"id\\\":1,\\\"number\\\":\\\"101\\\",\\\"price\\\":\\\"76000.00\\\",\\\"status\\\":\\\"tersedia\\\",\\\"photo\\\":\\\"1755835247_Standard-Room-3.jpg\\\",\\\"description\\\":\\\"Deluxe Room\\\\r\\\\nExperience the perfect blend of comfort and sophistication in our Deluxe Room, thoughtfully designed for discerning guests seeking refined accommodation. Whether for business or leisure, this room offers exceptional amenities and elegant ambiance to ensure a truly memorable stay.\\\\r\\\\n\\\\r\\\\nRoom Features:\\\\r\\\\n-Premium Queen\\\\\\/King-sized bed with luxury linen\\\\r\\\\n-Individually controlled air-conditioning\\\\r\\\\n-Ensuite bathroom with hot shower and exclusive toiletries\\\\r\\\\n-Flat-screen TV with international cable channels\\\\r\\\\n-Complimentary high-speed Wi-Fi\\\\r\\\\n-Functional work desk with ambient lighting\\\\r\\\\n-Daily complimentary bottled water & coffee\\\\\\/tea making facilities\\\\r\\\\n-Wardrobe, digital safe, and large mirror\\\\r\\\\n-Private balcony (available in selected rooms)\\\\r\\\\n-Room Size: \\\\u00b128\\\\u201332 m\\\\u00b2\\\\r\\\\n-Capacity: Up to 2 adults (extra bed available upon request)\\\\r\\\\n-Unwind in style and enjoy warm hospitality with every stay.\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-08-07T05:48:41.000000Z\\\",\\\"updated_at\\\":\\\"2025-08-22T04:00:47.000000Z\\\",\\\"tipe_kamar_id\\\":1}\"','\"{\\\"number\\\":\\\"101\\\",\\\"tipe_kamar_id\\\":\\\"3\\\",\\\"price\\\":\\\"76000.00\\\",\\\"status\\\":\\\"tersedia\\\",\\\"description\\\":\\\"Deluxe Room\\\\r\\\\nExperience the perfect blend of comfort and sophistication in our Deluxe Room, thoughtfully designed for discerning guests seeking refined accommodation. Whether for business or leisure, this room offers exceptional amenities and elegant ambiance to ensure a truly memorable stay.\\\\r\\\\n\\\\r\\\\nRoom Features:\\\\r\\\\n-Premium Queen\\\\\\/King-sized bed with luxury linen\\\\r\\\\n-Individually controlled air-conditioning\\\\r\\\\n-Ensuite bathroom with hot shower and exclusive toiletries\\\\r\\\\n-Flat-screen TV with international cable channels\\\\r\\\\n-Complimentary high-speed Wi-Fi\\\\r\\\\n-Functional work desk with ambient lighting\\\\r\\\\n-Daily complimentary bottled water & coffee\\\\\\/tea making facilities\\\\r\\\\n-Wardrobe, digital safe, and large mirror\\\\r\\\\n-Private balcony (available in selected rooms)\\\\r\\\\n-Room Size: \\\\u00b128\\\\u201332 m\\\\u00b2\\\\r\\\\n-Capacity: Up to 2 adults (extra bed available upon request)\\\\r\\\\n-Unwind in style and enjoy warm hospitality with every stay.\\\"}\"',NULL,NULL,'2025-09-14 19:31:40','2025-09-14 19:31:40'),
(371,1,'create','Menambahkan kamar baru: 122','127.0.0.1',NULL,'resepsionis',NULL,NULL,NULL,NULL,'2025-09-14 19:41:50','2025-09-14 19:41:50'),
(372,1,'create','Menambahkan kamar baru: 127','127.0.0.1',NULL,'resepsionis',NULL,NULL,NULL,NULL,'2025-09-14 19:57:26','2025-09-14 19:57:26'),
(373,1,'create','Menambahkan kamar baru: 322','127.0.0.1',NULL,'resepsionis',NULL,NULL,NULL,NULL,'2025-09-14 20:03:23','2025-09-14 20:03:23'),
(374,1,'create','Menambahkan kamar baru: 344','127.0.0.1',NULL,'resepsionis',NULL,NULL,NULL,NULL,'2025-09-14 20:05:16','2025-09-14 20:05:16'),
(375,1,'create','Menambahkan kamar baru: 665','127.0.0.1',NULL,'resepsionis',NULL,NULL,NULL,NULL,'2025-09-14 20:13:29','2025-09-14 20:13:29'),
(376,1,'delete','Menghapus kamar: 665','127.0.0.1',NULL,'resepsionis','\"{\\\"id\\\":30,\\\"number\\\":\\\"665\\\",\\\"price\\\":\\\"700000.00\\\",\\\"status\\\":\\\"tersedia\\\",\\\"photo\\\":null,\\\"description\\\":\\\"sd\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-09-15T03:13:29.000000Z\\\",\\\"updated_at\\\":\\\"2025-09-15T03:13:29.000000Z\\\",\\\"tipe_kamar_id\\\":3}\"',NULL,NULL,NULL,'2025-09-14 20:17:38','2025-09-14 20:17:38'),
(377,1,'create','Menambahkan tamu baru: galih pradana','127.0.0.1',NULL,'resepsionis',NULL,'\"{\\\"name\\\":\\\"galih pradana\\\",\\\"phone\\\":\\\"03846563\\\",\\\"identity_number\\\":\\\"32436456\\\",\\\"email\\\":\\\"galih@gmail.com\\\",\\\"date_of_birth\\\":\\\"1999-05-12T00:00:00.000000Z\\\",\\\"gender\\\":\\\"male\\\",\\\"address\\\":\\\"dummy\\\",\\\"guest_type\\\":\\\"reguler\\\",\\\"marital_status\\\":\\\"single\\\",\\\"notes\\\":\\\"dummy\\\",\\\"guest_code\\\":\\\"TM250002\\\",\\\"updated_at\\\":\\\"2025-09-15T03:21:02.000000Z\\\",\\\"created_at\\\":\\\"2025-09-15T03:21:02.000000Z\\\",\\\"id\\\":18}\"',NULL,NULL,'2025-09-14 20:21:02','2025-09-14 20:21:02'),
(378,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-14 20:24:05','2025-09-14 20:24:05'),
(379,2,'create','Membuat booking baru untuk kamar 101 (Superior Room)','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-14 20:31:47','2025-09-14 20:31:47'),
(380,2,'create','Membuat booking baru untuk kamar 893 (deluxe)','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-14 20:42:33','2025-09-14 20:42:33'),
(381,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-15 19:19:52','2025-09-15 19:19:52'),
(382,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-16 19:23:09','2025-09-16 19:23:09'),
(383,2,'update','Memperbarui booking #37','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin','\"{\\\"id\\\":37,\\\"user_id\\\":2,\\\"guest_id\\\":10,\\\"room_id\\\":27,\\\"check_in\\\":\\\"2025-09-17T00:00:00.000000Z\\\",\\\"check_out\\\":\\\"2025-09-20T00:00:00.000000Z\\\",\\\"status\\\":\\\"booked\\\",\\\"created_at\\\":\\\"2025-09-17T05:22:35.000000Z\\\",\\\"updated_at\\\":\\\"2025-09-17T05:22:35.000000Z\\\",\\\"total_price\\\":0,\\\"room\\\":{\\\"id\\\":27,\\\"number\\\":\\\"127\\\",\\\"price\\\":\\\"80000.00\\\",\\\"status\\\":\\\"terisi\\\",\\\"photo\\\":null,\\\"description\\\":\\\"guy\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-09-15T02:57:26.000000Z\\\",\\\"updated_at\\\":\\\"2025-09-17T05:22:35.000000Z\\\",\\\"tipe_kamar_id\\\":3,\\\"tipe_kamar\\\":{\\\"id\\\":3,\\\"tipe_kamar\\\":\\\"Superior Room\\\",\\\"jumlah_kamar\\\":12,\\\"created_at\\\":\\\"2025-09-12T01:32:06.000000Z\\\",\\\"updated_at\\\":\\\"2025-09-12T01:32:06.000000Z\\\",\\\"kamar_tersedia\\\":0}},\\\"facilities\\\":[]}\"','\"{\\\"guest_id\\\":\\\"15\\\",\\\"room_id\\\":\\\"27\\\",\\\"check_in\\\":\\\"2025-09-17\\\",\\\"check_out\\\":\\\"2025-09-20\\\",\\\"status\\\":\\\"booked\\\",\\\"facility_start_date\\\":null,\\\"facility_end_date\\\":null,\\\"facilities\\\":[\\\"11\\\"]}\"',NULL,NULL,'2025-09-16 22:32:18','2025-09-16 22:32:18'),
(384,2,'delete','Menghapus pembayaran #36','127.0.0.1',NULL,'admin','\"{\\\"id\\\":36,\\\"booking_id\\\":34,\\\"amount\\\":\\\"800000.00\\\",\\\"paid_at\\\":\\\"2025-09-12T04:26:00.000000Z\\\",\\\"method\\\":\\\"cash\\\",\\\"total\\\":\\\"800000.00\\\",\\\"created_at\\\":\\\"2025-09-12T04:27:13.000000Z\\\",\\\"updated_at\\\":\\\"2025-09-12T04:27:13.000000Z\\\"}\"',NULL,NULL,NULL,'2025-09-16 22:48:42','2025-09-16 22:48:42'),
(385,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-17 19:01:22','2025-09-17 19:01:22'),
(386,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-17 19:16:53','2025-09-17 19:16:53'),
(387,2,'delete','Membatalkan booking #26','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin','\"{\\\"id\\\":26,\\\"user_id\\\":3,\\\"guest_id\\\":1,\\\"room_id\\\":3,\\\"check_in\\\":\\\"2025-09-09T00:00:00.000000Z\\\",\\\"check_out\\\":\\\"2025-09-11T00:00:00.000000Z\\\",\\\"status\\\":\\\"booked\\\",\\\"created_at\\\":\\\"2025-08-14T13:57:08.000000Z\\\",\\\"updated_at\\\":\\\"2025-09-08T19:42:23.000000Z\\\",\\\"total_price\\\":0,\\\"room\\\":{\\\"id\\\":3,\\\"number\\\":\\\"103\\\",\\\"price\\\":\\\"78000.00\\\",\\\"status\\\":\\\"dipesan\\\",\\\"photo\\\":\\\"1755843316_Standard-Room-3.jpg\\\",\\\"description\\\":\\\"Standard Room\\\\r\\\\nSimplicity meets comfort in our Standard Room, offering a cozy and practical space for travelers seeking excellent value without compromising essential amenities. Ideal for solo guests or couples, this room provides a restful environment for a pleasant and convenient stay.\\\\r\\\\n\\\\r\\\\nRoom Features:\\\\r\\\\n-Comfortable Queen or Twin-sized bed with fresh linen\\\\r\\\\n-Air-conditioning with individual temperature control\\\\r\\\\n-Private bathroom with hot shower and basic toiletries\\\\r\\\\n-Flat-screen TV with local channels\\\\r\\\\n-Complimentary Wi-Fi access\\\\r\\\\n-Compact work desk or bedside table\\\\r\\\\n-Daily complimentary bottled water\\\\r\\\\n-Wardrobe or open hanging rack\\\\r\\\\n-Room Size: \\\\u00b118\\\\u201322 m\\\\u00b2\\\\r\\\\n-Capacity: Up to 2 adults\\\\r\\\\n-A smart choice for budget-conscious guests looking for clean, comfortable, and well-located accommodation.\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-08-07T05:50:32.000000Z\\\",\\\"updated_at\\\":\\\"2025-08-22T06:15:16.000000Z\\\",\\\"tipe_kamar_id\\\":1}}\"',NULL,NULL,NULL,'2025-09-17 20:21:13','2025-09-17 20:21:13'),
(388,2,'delete','Membatalkan booking #27','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin','\"{\\\"id\\\":27,\\\"user_id\\\":3,\\\"guest_id\\\":5,\\\"room_id\\\":4,\\\"check_in\\\":\\\"2025-08-20T00:00:00.000000Z\\\",\\\"check_out\\\":\\\"2025-08-27T00:00:00.000000Z\\\",\\\"status\\\":\\\"paid\\\",\\\"created_at\\\":\\\"2025-08-14T13:57:24.000000Z\\\",\\\"updated_at\\\":\\\"2025-08-14T14:01:21.000000Z\\\",\\\"total_price\\\":0,\\\"room\\\":{\\\"id\\\":4,\\\"number\\\":\\\"104\\\",\\\"price\\\":\\\"70000.00\\\",\\\"status\\\":\\\"dipesan\\\",\\\"photo\\\":\\\"1755843333_ExecutiveRoom.jpg\\\",\\\"description\\\":\\\"Executive Room\\\\r\\\\nDesigned for business travelers and guests who appreciate extra space and upgraded amenities, our Executive Room combines modern elegance with enhanced comfort. Featuring a spacious layout and thoughtful touches, this room is ideal for extended stays or working on the go.\\\\r\\\\n\\\\r\\\\nRoom Features:\\\\r\\\\n-Premium King or Twin-sized bed with high-quality linen\\\\r\\\\n-Spacious seating area for added comfort\\\\r\\\\n-Individually controlled air-conditioning\\\\r\\\\n-Ensuite bathroom with walk-in shower and deluxe toiletries\\\\r\\\\n-43\\\\\\\" Flat-screen Smart TV with international cable channels\\\\r\\\\n-Complimentary high-speed Wi-Fi\\\\r\\\\n-Executive work desk with ergonomic chair and ambient lighting\\\\r\\\\n-Daily complimentary bottled water, coffee & tea-making facilities\\\\r\\\\n-Mini refrigerator and in-room digital safe\\\\r\\\\n-Full-length mirror and wardrobe with extra storage\\\\r\\\\n-Privatebalcony with city or garden view (available in selectedrooms)\\\\r\\\\n-Room Size: \\\\u00b132\\\\u201338 m\\\\u00b2\\\\r\\\\n-Capacity: Up to 2 adults (extra bed available upon request)\\\\r\\\\n-Experience elevated hospitality with extra space, exclusive comfort, and refined ambiance in every stay.\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-08-07T05:51:30.000000Z\\\",\\\"updated_at\\\":\\\"2025-08-22T06:15:33.000000Z\\\",\\\"tipe_kamar_id\\\":1}}\"',NULL,NULL,NULL,'2025-09-17 20:21:20','2025-09-17 20:21:20'),
(389,2,'create','Mencatat pembayaran untuk booking #32','127.0.0.1',NULL,'admin',NULL,NULL,NULL,NULL,'2025-09-17 20:39:42','2025-09-17 20:39:42'),
(390,2,'create','Menambahkan kamar baru: 871','127.0.0.1',NULL,'admin',NULL,NULL,NULL,NULL,'2025-09-17 21:09:35','2025-09-17 21:09:35'),
(391,2,'update','Memperbarui data kamar: 871','127.0.0.1',NULL,'admin','\"{\\\"id\\\":31,\\\"number\\\":\\\"871\\\",\\\"price\\\":\\\"600000.00\\\",\\\"status\\\":\\\"tersedia\\\",\\\"photo\\\":null,\\\"description\\\":\\\"dummy\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-09-18T04:09:35.000000Z\\\",\\\"updated_at\\\":\\\"2025-09-18T04:09:35.000000Z\\\",\\\"tipe_kamar_id\\\":3}\"','\"{\\\"number\\\":\\\"871\\\",\\\"tipe_kamar_id\\\":\\\"3\\\",\\\"price\\\":\\\"600000.00\\\",\\\"status\\\":\\\"tersedia\\\",\\\"description\\\":\\\"dummy\\\",\\\"photo\\\":{}}\"',NULL,NULL,'2025-09-17 21:09:59','2025-09-17 21:09:59'),
(392,2,'update','Memperbarui data kamar: 871','127.0.0.1',NULL,'admin','\"{\\\"id\\\":31,\\\"number\\\":\\\"871\\\",\\\"price\\\":\\\"600000.00\\\",\\\"status\\\":\\\"tersedia\\\",\\\"photo\\\":\\\"\\\\\\/tmp\\\\\\/php793jkkqgsqsi9ijHBMP\\\",\\\"description\\\":\\\"dummy\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-09-18T04:09:35.000000Z\\\",\\\"updated_at\\\":\\\"2025-09-18T04:09:59.000000Z\\\",\\\"tipe_kamar_id\\\":3}\"','\"{\\\"number\\\":\\\"871\\\",\\\"tipe_kamar_id\\\":\\\"3\\\",\\\"price\\\":\\\"600000.00\\\",\\\"status\\\":\\\"tersedia\\\",\\\"description\\\":\\\"dummy\\\",\\\"photo\\\":{}}\"',NULL,NULL,'2025-09-17 21:10:15','2025-09-17 21:10:15'),
(393,2,'update','Memperbarui data kamar: 871','127.0.0.1',NULL,'admin','\"{\\\"id\\\":31,\\\"number\\\":\\\"871\\\",\\\"price\\\":\\\"600000.00\\\",\\\"status\\\":\\\"tersedia\\\",\\\"photo\\\":\\\"\\\\\\/tmp\\\\\\/phpsgh674udkjck2MhFEmo\\\",\\\"description\\\":\\\"dummy\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-09-18T04:09:35.000000Z\\\",\\\"updated_at\\\":\\\"2025-09-18T04:10:15.000000Z\\\",\\\"tipe_kamar_id\\\":3}\"','\"{\\\"number\\\":\\\"871\\\",\\\"tipe_kamar_id\\\":\\\"3\\\",\\\"price\\\":\\\"600000.00\\\",\\\"status\\\":\\\"tersedia\\\",\\\"description\\\":\\\"dummy\\\",\\\"photo\\\":{}}\"',NULL,NULL,'2025-09-17 21:15:52','2025-09-17 21:15:52'),
(394,2,'update','Memperbarui data kamar: 923','127.0.0.1',NULL,'admin','\"{\\\"id\\\":11,\\\"number\\\":\\\"923\\\",\\\"price\\\":\\\"800000.00\\\",\\\"status\\\":\\\"terisi\\\",\\\"photo\\\":null,\\\"description\\\":\\\"lkdlfjflkrn\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-08-26T07:46:45.000000Z\\\",\\\"updated_at\\\":\\\"2025-08-26T07:46:45.000000Z\\\",\\\"tipe_kamar_id\\\":1}\"','\"{\\\"number\\\":\\\"923\\\",\\\"tipe_kamar_id\\\":\\\"1\\\",\\\"price\\\":\\\"800000.00\\\",\\\"status\\\":\\\"terisi\\\",\\\"description\\\":\\\"lkdlfjflkrn\\\",\\\"photo\\\":{}}\"',NULL,NULL,'2025-09-17 21:21:24','2025-09-17 21:21:24'),
(395,2,'update','Memperbarui data kamar: 923','127.0.0.1',NULL,'admin','\"{\\\"id\\\":11,\\\"number\\\":\\\"923\\\",\\\"price\\\":\\\"800000.00\\\",\\\"status\\\":\\\"terisi\\\",\\\"photo\\\":\\\"\\\\\\/tmp\\\\\\/phpnttqtpq0uk1n9eeBbjd\\\",\\\"description\\\":\\\"lkdlfjflkrn\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-08-26T07:46:45.000000Z\\\",\\\"updated_at\\\":\\\"2025-09-18T04:21:24.000000Z\\\",\\\"tipe_kamar_id\\\":1}\"','\"{\\\"number\\\":\\\"923\\\",\\\"tipe_kamar_id\\\":\\\"1\\\",\\\"price\\\":\\\"800000.00\\\",\\\"status\\\":\\\"terisi\\\",\\\"description\\\":\\\"lkdlfjflkrn\\\",\\\"photo\\\":{}}\"',NULL,NULL,'2025-09-17 21:21:47','2025-09-17 21:21:47'),
(396,2,'update','Memperbarui data kamar: 101','127.0.0.1',NULL,'admin','\"{\\\"id\\\":1,\\\"number\\\":\\\"101\\\",\\\"price\\\":\\\"76000.00\\\",\\\"status\\\":\\\"terisi\\\",\\\"photo\\\":\\\"1755835247_Standard-Room-3.jpg\\\",\\\"description\\\":\\\"Deluxe Room\\\\r\\\\nExperience the perfect blend of comfort and sophistication in our Deluxe Room, thoughtfully designed for discerning guests seeking refined accommodation. Whether for business or leisure, this room offers exceptional amenities and elegant ambiance to ensure a truly memorable stay.\\\\r\\\\n\\\\r\\\\nRoom Features:\\\\r\\\\n-Premium Queen\\\\\\/King-sized bed with luxury linen\\\\r\\\\n-Individually controlled air-conditioning\\\\r\\\\n-Ensuite bathroom with hot shower and exclusive toiletries\\\\r\\\\n-Flat-screen TV with international cable channels\\\\r\\\\n-Complimentary high-speed Wi-Fi\\\\r\\\\n-Functional work desk with ambient lighting\\\\r\\\\n-Daily complimentary bottled water & coffee\\\\\\/tea making facilities\\\\r\\\\n-Wardrobe, digital safe, and large mirror\\\\r\\\\n-Private balcony (available in selected rooms)\\\\r\\\\n-Room Size: \\\\u00b128\\\\u201332 m\\\\u00b2\\\\r\\\\n-Capacity: Up to 2 adults (extra bed available upon request)\\\\r\\\\n-Unwind in style and enjoy warm hospitality with every stay.\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-08-07T05:48:41.000000Z\\\",\\\"updated_at\\\":\\\"2025-09-15T03:31:47.000000Z\\\",\\\"tipe_kamar_id\\\":3}\"','\"{\\\"number\\\":\\\"101\\\",\\\"tipe_kamar_id\\\":\\\"3\\\",\\\"price\\\":\\\"76000.00\\\",\\\"status\\\":\\\"terisi\\\",\\\"description\\\":\\\"Deluxe Room\\\\r\\\\nExperience the perfect blend of comfort and sophistication in our Deluxe Room, thoughtfully designed for discerning guests seeking refined accommodation. Whether for business or leisure, this room offers exceptional amenities and elegant ambiance to ensure a truly memorable stay.\\\\r\\\\n\\\\r\\\\nRoom Features:\\\\r\\\\n-Premium Queen\\\\\\/King-sized bed with luxury linen\\\\r\\\\n-Individually controlled air-conditioning\\\\r\\\\n-Ensuite bathroom with hot shower and exclusive toiletries\\\\r\\\\n-Flat-screen TV with international cable channels\\\\r\\\\n-Complimentary high-speed Wi-Fi\\\\r\\\\n-Functional work desk with ambient lighting\\\\r\\\\n-Daily complimentary bottled water & coffee\\\\\\/tea making facilities\\\\r\\\\n-Wardrobe, digital safe, and large mirror\\\\r\\\\n-Private balcony (available in selected rooms)\\\\r\\\\n-Room Size: \\\\u00b128\\\\u201332 m\\\\u00b2\\\\r\\\\n-Capacity: Up to 2 adults (extra bed available upon request)\\\\r\\\\n-Unwind in style and enjoy warm hospitality with every stay.\\\",\\\"photo\\\":{}}\"',NULL,NULL,'2025-09-17 21:24:12','2025-09-17 21:24:12'),
(397,2,'update','Memperbarui data kamar: 101','127.0.0.1',NULL,'admin','\"{\\\"id\\\":1,\\\"number\\\":\\\"101\\\",\\\"price\\\":\\\"76000.00\\\",\\\"status\\\":\\\"terisi\\\",\\\"photo\\\":\\\"\\\\\\/tmp\\\\\\/phpkmd3p7hf6th8elLLGdL\\\",\\\"description\\\":\\\"Deluxe Room\\\\r\\\\nExperience the perfect blend of comfort and sophistication in our Deluxe Room, thoughtfully designed for discerning guests seeking refined accommodation. Whether for business or leisure, this room offers exceptional amenities and elegant ambiance to ensure a truly memorable stay.\\\\r\\\\n\\\\r\\\\nRoom Features:\\\\r\\\\n-Premium Queen\\\\\\/King-sized bed with luxury linen\\\\r\\\\n-Individually controlled air-conditioning\\\\r\\\\n-Ensuite bathroom with hot shower and exclusive toiletries\\\\r\\\\n-Flat-screen TV with international cable channels\\\\r\\\\n-Complimentary high-speed Wi-Fi\\\\r\\\\n-Functional work desk with ambient lighting\\\\r\\\\n-Daily complimentary bottled water & coffee\\\\\\/tea making facilities\\\\r\\\\n-Wardrobe, digital safe, and large mirror\\\\r\\\\n-Private balcony (available in selected rooms)\\\\r\\\\n-Room Size: \\\\u00b128\\\\u201332 m\\\\u00b2\\\\r\\\\n-Capacity: Up to 2 adults (extra bed available upon request)\\\\r\\\\n-Unwind in style and enjoy warm hospitality with every stay.\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-08-07T05:48:41.000000Z\\\",\\\"updated_at\\\":\\\"2025-09-18T04:24:12.000000Z\\\",\\\"tipe_kamar_id\\\":3}\"','\"{\\\"number\\\":\\\"101\\\",\\\"tipe_kamar_id\\\":\\\"3\\\",\\\"price\\\":\\\"76000.00\\\",\\\"status\\\":\\\"terisi\\\",\\\"description\\\":\\\"Deluxe Room\\\\r\\\\nExperience the perfect blend of comfort and sophistication in our Deluxe Room, thoughtfully designed for discerning guests seeking refined accommodation. Whether for business or leisure, this room offers exceptional amenities and elegant ambiance to ensure a truly memorable stay.\\\\r\\\\n\\\\r\\\\nRoom Features:\\\\r\\\\n-Premium Queen\\\\\\/King-sized bed with luxury linen\\\\r\\\\n-Individually controlled air-conditioning\\\\r\\\\n-Ensuite bathroom with hot shower and exclusive toiletries\\\\r\\\\n-Flat-screen TV with international cable channels\\\\r\\\\n-Complimentary high-speed Wi-Fi\\\\r\\\\n-Functional work desk with ambient lighting\\\\r\\\\n-Daily complimentary bottled water & coffee\\\\\\/tea making facilities\\\\r\\\\n-Wardrobe, digital safe, and large mirror\\\\r\\\\n-Private balcony (available in selected rooms)\\\\r\\\\n-Room Size: \\\\u00b128\\\\u201332 m\\\\u00b2\\\\r\\\\n-Capacity: Up to 2 adults (extra bed available upon request)\\\\r\\\\n-Unwind in style and enjoy warm hospitality with every stay.\\\",\\\"photo\\\":{}}\"',NULL,NULL,'2025-09-17 21:24:13','2025-09-17 21:24:13'),
(398,2,'update','Memperbarui data kamar: 101','127.0.0.1',NULL,'admin','\"{\\\"id\\\":1,\\\"number\\\":\\\"101\\\",\\\"price\\\":\\\"76000.00\\\",\\\"status\\\":\\\"terisi\\\",\\\"photo\\\":\\\"1758170227__ (2).jpeg\\\",\\\"description\\\":\\\"Deluxe Room\\\\r\\\\nExperience the perfect blend of comfort and sophistication in our Deluxe Room, thoughtfully designed for discerning guests seeking refined accommodation. Whether for business or leisure, this room offers exceptional amenities and elegant ambiance to ensure a truly memorable stay.\\\\r\\\\n\\\\r\\\\nRoom Features:\\\\r\\\\n-Premium Queen\\\\\\/King-sized bed with luxury linen\\\\r\\\\n-Individually controlled air-conditioning\\\\r\\\\n-Ensuite bathroom with hot shower and exclusive toiletries\\\\r\\\\n-Flat-screen TV with international cable channels\\\\r\\\\n-Complimentary high-speed Wi-Fi\\\\r\\\\n-Functional work desk with ambient lighting\\\\r\\\\n-Daily complimentary bottled water & coffee\\\\\\/tea making facilities\\\\r\\\\n-Wardrobe, digital safe, and large mirror\\\\r\\\\n-Private balcony (available in selected rooms)\\\\r\\\\n-Room Size: \\\\u00b128\\\\u201332 m\\\\u00b2\\\\r\\\\n-Capacity: Up to 2 adults (extra bed available upon request)\\\\r\\\\n-Unwind in style and enjoy warm hospitality with every stay.\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-08-07T05:48:41.000000Z\\\",\\\"updated_at\\\":\\\"2025-09-18T04:37:07.000000Z\\\",\\\"tipe_kamar_id\\\":\\\"3\\\"}\"','\"{\\\"number\\\":\\\"101\\\",\\\"tipe_kamar_id\\\":\\\"3\\\",\\\"price\\\":\\\"76000.00\\\",\\\"status\\\":\\\"terisi\\\",\\\"description\\\":\\\"Deluxe Room\\\\r\\\\nExperience the perfect blend of comfort and sophistication in our Deluxe Room, thoughtfully designed for discerning guests seeking refined accommodation. Whether for business or leisure, this room offers exceptional amenities and elegant ambiance to ensure a truly memorable stay.\\\\r\\\\n\\\\r\\\\nRoom Features:\\\\r\\\\n-Premium Queen\\\\\\/King-sized bed with luxury linen\\\\r\\\\n-Individually controlled air-conditioning\\\\r\\\\n-Ensuite bathroom with hot shower and exclusive toiletries\\\\r\\\\n-Flat-screen TV with international cable channels\\\\r\\\\n-Complimentary high-speed Wi-Fi\\\\r\\\\n-Functional work desk with ambient lighting\\\\r\\\\n-Daily complimentary bottled water & coffee\\\\\\/tea making facilities\\\\r\\\\n-Wardrobe, digital safe, and large mirror\\\\r\\\\n-Private balcony (available in selected rooms)\\\\r\\\\n-Room Size: \\\\u00b128\\\\u201332 m\\\\u00b2\\\\r\\\\n-Capacity: Up to 2 adults (extra bed available upon request)\\\\r\\\\n-Unwind in style and enjoy warm hospitality with every stay.\\\",\\\"photo\\\":{}}\"',NULL,NULL,'2025-09-17 21:37:07','2025-09-17 21:37:07'),
(399,2,'update','Memperbarui data kamar: 871','127.0.0.1',NULL,'admin','\"{\\\"id\\\":31,\\\"number\\\":\\\"871\\\",\\\"price\\\":\\\"600000.00\\\",\\\"status\\\":\\\"tersedia\\\",\\\"photo\\\":\\\"1758170254_Baixar Cart\\\\u00e3o de quadro de circo gratuitamente.jpeg\\\",\\\"description\\\":\\\"dummy\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-09-18T04:09:35.000000Z\\\",\\\"updated_at\\\":\\\"2025-09-18T04:37:34.000000Z\\\",\\\"tipe_kamar_id\\\":\\\"3\\\"}\"','\"{\\\"number\\\":\\\"871\\\",\\\"tipe_kamar_id\\\":\\\"3\\\",\\\"price\\\":\\\"600000.00\\\",\\\"status\\\":\\\"tersedia\\\",\\\"description\\\":\\\"dummy\\\",\\\"photo\\\":{}}\"',NULL,NULL,'2025-09-17 21:37:34','2025-09-17 21:37:34'),
(400,2,'delete','Menghapus kamar: 871','127.0.0.1',NULL,'admin','\"{\\\"id\\\":31,\\\"number\\\":\\\"871\\\",\\\"price\\\":\\\"600000.00\\\",\\\"status\\\":\\\"tersedia\\\",\\\"photo\\\":\\\"1758170254_Baixar Cart\\\\u00e3o de quadro de circo gratuitamente.jpeg\\\",\\\"description\\\":\\\"dummy\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-09-18T04:09:35.000000Z\\\",\\\"updated_at\\\":\\\"2025-09-18T04:37:34.000000Z\\\",\\\"tipe_kamar_id\\\":3}\"',NULL,NULL,NULL,'2025-09-17 21:37:41','2025-09-17 21:37:41'),
(401,2,'create','Menambahkan tamu baru: dana','127.0.0.1',NULL,'admin',NULL,'\"{\\\"name\\\":\\\"dana\\\",\\\"phone\\\":\\\"038485345\\\",\\\"identity_number\\\":\\\"78465384\\\",\\\"email\\\":\\\"dana@gmail.com\\\",\\\"date_of_birth\\\":\\\"2000-02-24T00:00:00.000000Z\\\",\\\"gender\\\":\\\"male\\\",\\\"address\\\":\\\"mriyan\\\",\\\"guest_type\\\":null,\\\"marital_status\\\":\\\"single\\\",\\\"notes\\\":\\\"suka renang\\\",\\\"photo\\\":\\\"1758170353_dummy man.jpeg\\\",\\\"guest_code\\\":\\\"TM250003\\\",\\\"updated_at\\\":\\\"2025-09-18T04:39:13.000000Z\\\",\\\"created_at\\\":\\\"2025-09-18T04:39:13.000000Z\\\",\\\"id\\\":19}\"',NULL,NULL,'2025-09-17 21:39:13','2025-09-17 21:39:13'),
(402,2,'update','Memperbarui data tamu: dana','127.0.0.1',NULL,'admin','\"{\\\"id\\\":19,\\\"guest_code\\\":\\\"TM250003\\\",\\\"name\\\":\\\"dana\\\",\\\"phone\\\":\\\"038485345\\\",\\\"identity_number\\\":\\\"78465384\\\",\\\"email\\\":\\\"dana@gmail.com\\\",\\\"gender\\\":\\\"male\\\",\\\"address\\\":\\\"mriyan\\\",\\\"created_at\\\":\\\"2025-09-18T04:39:13.000000Z\\\",\\\"updated_at\\\":\\\"2025-09-18T04:39:13.000000Z\\\",\\\"date_of_birth\\\":\\\"2000-02-24T00:00:00.000000Z\\\",\\\"nationality\\\":null,\\\"profession\\\":null,\\\"notes\\\":\\\"suka renang\\\",\\\"photo\\\":\\\"1758170353_dummy man.jpeg\\\",\\\"marital_status\\\":\\\"single\\\",\\\"loyalty_points\\\":0,\\\"social_account\\\":null,\\\"guest_type\\\":null,\\\"health_notes\\\":null}\"','\"{\\\"name\\\":\\\"dana\\\",\\\"phone\\\":\\\"038485345\\\",\\\"identity_number\\\":\\\"78465384\\\",\\\"email\\\":\\\"dana@gmail.com\\\",\\\"date_of_birth\\\":\\\"2000-02-24\\\",\\\"gender\\\":\\\"male\\\",\\\"address\\\":\\\"mriyan\\\",\\\"guest_type\\\":\\\"vip\\\",\\\"marital_status\\\":\\\"single\\\",\\\"notes\\\":\\\"suka renang\\\"}\"',NULL,NULL,'2025-09-17 21:39:52','2025-09-17 21:39:52'),
(403,2,'update','Memperbarui data tamu: danaa','127.0.0.1',NULL,'admin','\"{\\\"id\\\":19,\\\"guest_code\\\":\\\"TM250003\\\",\\\"name\\\":\\\"dana\\\",\\\"phone\\\":\\\"038485345\\\",\\\"identity_number\\\":\\\"78465384\\\",\\\"email\\\":\\\"dana@gmail.com\\\",\\\"gender\\\":\\\"male\\\",\\\"address\\\":\\\"mriyan\\\",\\\"created_at\\\":\\\"2025-09-18T04:39:13.000000Z\\\",\\\"updated_at\\\":\\\"2025-09-18T04:39:52.000000Z\\\",\\\"date_of_birth\\\":\\\"2000-02-24T00:00:00.000000Z\\\",\\\"nationality\\\":null,\\\"profession\\\":null,\\\"notes\\\":\\\"suka renang\\\",\\\"photo\\\":\\\"1758170353_dummy man.jpeg\\\",\\\"marital_status\\\":\\\"single\\\",\\\"loyalty_points\\\":0,\\\"social_account\\\":null,\\\"guest_type\\\":\\\"vip\\\",\\\"health_notes\\\":null}\"','\"{\\\"name\\\":\\\"danaa\\\",\\\"phone\\\":\\\"038485345\\\",\\\"identity_number\\\":\\\"78465384\\\",\\\"email\\\":\\\"dana@gmail.com\\\",\\\"date_of_birth\\\":\\\"2000-02-24\\\",\\\"gender\\\":\\\"male\\\",\\\"address\\\":\\\"mriyan\\\",\\\"guest_type\\\":\\\"vip\\\",\\\"marital_status\\\":\\\"single\\\",\\\"notes\\\":\\\"suka renang\\\"}\"',NULL,NULL,'2025-09-17 21:43:22','2025-09-17 21:43:22'),
(404,2,'delete','Menghapus tamu: danaa','127.0.0.1',NULL,'admin','\"{\\\"id\\\":19,\\\"guest_code\\\":\\\"TM250003\\\",\\\"name\\\":\\\"danaa\\\",\\\"phone\\\":\\\"038485345\\\",\\\"identity_number\\\":\\\"78465384\\\",\\\"email\\\":\\\"dana@gmail.com\\\",\\\"gender\\\":\\\"male\\\",\\\"address\\\":\\\"mriyan\\\",\\\"created_at\\\":\\\"2025-09-18T04:39:13.000000Z\\\",\\\"updated_at\\\":\\\"2025-09-18T04:43:22.000000Z\\\",\\\"date_of_birth\\\":\\\"2000-02-24T00:00:00.000000Z\\\",\\\"nationality\\\":null,\\\"profession\\\":null,\\\"notes\\\":\\\"suka renang\\\",\\\"photo\\\":\\\"1758170353_dummy man.jpeg\\\",\\\"marital_status\\\":\\\"single\\\",\\\"loyalty_points\\\":0,\\\"social_account\\\":null,\\\"guest_type\\\":\\\"vip\\\",\\\"health_notes\\\":null}\"',NULL,NULL,NULL,'2025-09-17 21:43:29','2025-09-17 21:43:29'),
(405,2,'create','Membuat booking baru untuk kamar 103','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-17 21:44:02','2025-09-17 21:44:02'),
(406,2,'delete','Membatalkan booking #38','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin','\"{\\\"id\\\":38,\\\"user_id\\\":2,\\\"guest_id\\\":12,\\\"room_id\\\":3,\\\"check_in\\\":\\\"2025-09-18T00:00:00.000000Z\\\",\\\"check_out\\\":\\\"2025-09-20T00:00:00.000000Z\\\",\\\"status\\\":\\\"booked\\\",\\\"created_at\\\":\\\"2025-09-18T04:44:02.000000Z\\\",\\\"updated_at\\\":\\\"2025-09-18T04:44:02.000000Z\\\",\\\"total_price\\\":0,\\\"room\\\":{\\\"id\\\":3,\\\"number\\\":\\\"103\\\",\\\"price\\\":\\\"78000.00\\\",\\\"status\\\":\\\"terisi\\\",\\\"photo\\\":\\\"1755843316_Standard-Room-3.jpg\\\",\\\"description\\\":\\\"Standard Room\\\\r\\\\nSimplicity meets comfort in our Standard Room, offering a cozy and practical space for travelers seeking excellent value without compromising essential amenities. Ideal for solo guests or couples, this room provides a restful environment for a pleasant and convenient stay.\\\\r\\\\n\\\\r\\\\nRoom Features:\\\\r\\\\n-Comfortable Queen or Twin-sized bed with fresh linen\\\\r\\\\n-Air-conditioning with individual temperature control\\\\r\\\\n-Private bathroom with hot shower and basic toiletries\\\\r\\\\n-Flat-screen TV with local channels\\\\r\\\\n-Complimentary Wi-Fi access\\\\r\\\\n-Compact work desk or bedside table\\\\r\\\\n-Daily complimentary bottled water\\\\r\\\\n-Wardrobe or open hanging rack\\\\r\\\\n-Room Size: \\\\u00b118\\\\u201322 m\\\\u00b2\\\\r\\\\n-Capacity: Up to 2 adults\\\\r\\\\n-A smart choice for budget-conscious guests looking for clean, comfortable, and well-located accommodation.\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-08-07T05:50:32.000000Z\\\",\\\"updated_at\\\":\\\"2025-09-18T04:44:02.000000Z\\\",\\\"tipe_kamar_id\\\":1}}\"',NULL,NULL,NULL,'2025-09-17 21:44:20','2025-09-17 21:44:20'),
(407,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-18 17:55:50','2025-09-18 17:55:50'),
(408,2,'create','Menambahkan tamu baru: janu','127.0.0.1',NULL,'admin',NULL,'\"{\\\"name\\\":\\\"janu\\\",\\\"phone\\\":\\\"047684586\\\",\\\"identity_number\\\":\\\"894574\\\",\\\"email\\\":\\\"janu@gmail.com\\\",\\\"date_of_birth\\\":\\\"2006-01-17T00:00:00.000000Z\\\",\\\"gender\\\":\\\"male\\\",\\\"address\\\":\\\"dummy\\\",\\\"guest_type\\\":\\\"vvip\\\",\\\"marital_status\\\":\\\"single\\\",\\\"notes\\\":\\\"alergi udang\\\",\\\"photo\\\":\\\"1758244284_dummy man.jpeg\\\",\\\"guest_code\\\":\\\"TM250003\\\",\\\"updated_at\\\":\\\"2025-09-19T01:11:24.000000Z\\\",\\\"created_at\\\":\\\"2025-09-19T01:11:24.000000Z\\\",\\\"id\\\":20}\"',NULL,NULL,'2025-09-18 18:11:24','2025-09-18 18:11:24'),
(409,2,'create','Membuat booking baru untuk kamar 103','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-18 18:12:02','2025-09-18 18:12:02'),
(410,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-19 05:56:23','2025-09-19 05:56:23'),
(411,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-21 21:32:53','2025-09-21 21:32:53'),
(412,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-21 21:33:51','2025-09-21 21:33:51'),
(413,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-22 19:01:09','2025-09-22 19:01:09'),
(414,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-22 19:29:50','2025-09-22 19:29:50'),
(415,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-25 21:30:37','2025-09-25 21:30:37'),
(416,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-25 21:38:31','2025-09-25 21:38:31'),
(417,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-25 21:39:20','2025-09-25 21:39:20'),
(418,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-25 21:39:48','2025-09-25 21:39:48'),
(419,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-25 21:40:36','2025-09-25 21:40:36'),
(420,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-25 21:41:06','2025-09-25 21:41:06'),
(421,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-25 21:43:21','2025-09-25 21:43:21'),
(422,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-25 21:44:07','2025-09-25 21:44:07'),
(423,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-25 21:45:43','2025-09-25 21:45:43'),
(424,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-25 21:50:12','2025-09-25 21:50:12'),
(425,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-25 21:50:43','2025-09-25 21:50:43'),
(426,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-25 21:52:33','2025-09-25 21:52:33'),
(427,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-25 21:53:46','2025-09-25 21:53:46'),
(428,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-25 21:53:57','2025-09-25 21:53:57'),
(429,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-25 21:54:11','2025-09-25 21:54:11'),
(430,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-25 21:54:26','2025-09-25 21:54:26'),
(431,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-25 21:54:31','2025-09-25 21:54:31'),
(432,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-25 21:58:22','2025-09-25 21:58:22'),
(433,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-25 22:00:15','2025-09-25 22:00:15'),
(434,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-25 22:03:06','2025-09-25 22:03:06'),
(435,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-25 22:07:41','2025-09-25 22:07:41'),
(436,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-25 22:12:17','2025-09-25 22:12:17'),
(437,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-25 22:13:21','2025-09-25 22:13:21'),
(438,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-25 22:14:39','2025-09-25 22:14:39'),
(439,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-25 22:20:30','2025-09-25 22:20:30'),
(440,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-25 22:23:06','2025-09-25 22:23:06'),
(441,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-25 22:30:58','2025-09-25 22:30:58'),
(442,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-25 22:34:58','2025-09-25 22:34:58'),
(443,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-25 22:48:43','2025-09-25 22:48:43'),
(444,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-25 22:48:50','2025-09-25 22:48:50'),
(445,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-25 22:49:01','2025-09-25 22:49:01'),
(446,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-25 22:50:58','2025-09-25 22:50:58'),
(447,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-25 23:00:05','2025-09-25 23:00:05'),
(448,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-25 23:00:39','2025-09-25 23:00:39'),
(449,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-25 23:02:06','2025-09-25 23:02:06'),
(450,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-25 23:02:31','2025-09-25 23:02:31'),
(451,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-25 23:03:13','2025-09-25 23:03:13'),
(452,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-25 23:04:58','2025-09-25 23:04:58'),
(453,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-25 23:07:00','2025-09-25 23:07:00'),
(454,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-25 23:08:43','2025-09-25 23:08:43'),
(455,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-25 23:09:43','2025-09-25 23:09:43'),
(456,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-25 23:12:43','2025-09-25 23:12:43'),
(457,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-25 23:16:22','2025-09-25 23:16:22'),
(458,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-25 23:17:11','2025-09-25 23:17:11'),
(459,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-25 23:17:52','2025-09-25 23:17:52'),
(460,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-25 23:19:45','2025-09-25 23:19:45'),
(461,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-25 23:25:36','2025-09-25 23:25:36'),
(462,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-25 23:44:31','2025-09-25 23:44:31'),
(463,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-25 23:44:59','2025-09-25 23:44:59'),
(464,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-25 23:48:28','2025-09-25 23:48:28'),
(465,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-26 00:01:46','2025-09-26 00:01:46'),
(466,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-26 00:23:22','2025-09-26 00:23:22'),
(467,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-26 04:16:41','2025-09-26 04:16:41'),
(468,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-26 04:17:56','2025-09-26 04:17:56'),
(469,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-26 04:22:01','2025-09-26 04:22:01'),
(470,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-26 04:24:19','2025-09-26 04:24:19'),
(471,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-26 04:26:09','2025-09-26 04:26:09'),
(472,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-26 04:28:02','2025-09-26 04:28:02'),
(473,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-26 04:28:55','2025-09-26 04:28:55'),
(474,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-26 04:35:29','2025-09-26 04:35:29'),
(475,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-26 04:36:00','2025-09-26 04:36:00'),
(476,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-26 04:36:46','2025-09-26 04:36:46'),
(477,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-26 04:41:57','2025-09-26 04:41:57'),
(478,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-26 04:54:30','2025-09-26 04:54:30'),
(479,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-26 04:54:39','2025-09-26 04:54:39'),
(480,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-26 04:54:55','2025-09-26 04:54:55'),
(481,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-26 04:56:49','2025-09-26 04:56:49'),
(482,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-26 04:57:10','2025-09-26 04:57:10'),
(483,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-26 04:58:34','2025-09-26 04:58:34'),
(484,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-26 05:00:08','2025-09-26 05:00:08'),
(485,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-26 05:00:20','2025-09-26 05:00:20'),
(486,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-26 05:01:22','2025-09-26 05:01:22'),
(487,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-26 05:01:32','2025-09-26 05:01:32'),
(488,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-26 05:06:58','2025-09-26 05:06:58'),
(489,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-26 05:16:32','2025-09-26 05:16:32'),
(490,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-26 05:17:52','2025-09-26 05:17:52'),
(491,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-26 05:26:40','2025-09-26 05:26:40'),
(492,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-26 05:28:52','2025-09-26 05:28:52'),
(493,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-26 05:34:36','2025-09-26 05:34:36'),
(494,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-26 05:35:17','2025-09-26 05:35:17'),
(495,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-26 05:36:14','2025-09-26 05:36:14'),
(496,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-26 05:36:42','2025-09-26 05:36:42'),
(497,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-26 05:37:17','2025-09-26 05:37:17'),
(498,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-26 05:40:10','2025-09-26 05:40:10'),
(499,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-26 05:41:52','2025-09-26 05:41:52'),
(500,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-26 05:44:14','2025-09-26 05:44:14'),
(501,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-26 05:47:37','2025-09-26 05:47:37'),
(502,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-26 05:55:55','2025-09-26 05:55:55'),
(503,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-26 05:56:20','2025-09-26 05:56:20'),
(504,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-26 06:02:25','2025-09-26 06:02:25'),
(505,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-26 06:03:58','2025-09-26 06:03:58'),
(506,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-28 18:32:56','2025-09-28 18:32:56'),
(507,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-28 18:36:49','2025-09-28 18:36:49'),
(508,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-28 19:40:47','2025-09-28 19:40:47'),
(509,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-28 20:01:29','2025-09-28 20:01:29'),
(510,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-28 20:08:36','2025-09-28 20:08:36'),
(511,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-28 20:14:58','2025-09-28 20:14:58'),
(512,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-28 20:15:16','2025-09-28 20:15:16'),
(513,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-28 20:17:42','2025-09-28 20:17:42'),
(514,2,'delete','Menghapus kamar: 923','127.0.0.1',NULL,'admin','\"{\\\"id\\\":11,\\\"number\\\":\\\"923\\\",\\\"price\\\":\\\"800000.00\\\",\\\"status\\\":\\\"terisi\\\",\\\"photo\\\":\\\"\\\\\\/tmp\\\\\\/php95jtv2tf16b74NglMiL\\\",\\\"description\\\":\\\"lkdlfjflkrn\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-08-26T07:46:45.000000Z\\\",\\\"updated_at\\\":\\\"2025-09-18T04:21:47.000000Z\\\",\\\"tipe_kamar_id\\\":1}\"',NULL,NULL,NULL,'2025-09-28 20:35:35','2025-09-28 20:35:35'),
(515,2,'delete','Menghapus kamar: 874','127.0.0.1',NULL,'admin','\"{\\\"id\\\":16,\\\"number\\\":\\\"874\\\",\\\"price\\\":\\\"300000.00\\\",\\\"status\\\":\\\"terisi\\\",\\\"photo\\\":null,\\\"description\\\":\\\"dummy\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-09-09T02:15:54.000000Z\\\",\\\"updated_at\\\":\\\"2025-09-09T02:15:54.000000Z\\\",\\\"tipe_kamar_id\\\":1}\"',NULL,NULL,NULL,'2025-09-28 20:35:38','2025-09-28 20:35:38'),
(516,2,'delete','Menghapus kamar: 758','127.0.0.1',NULL,'admin','\"{\\\"id\\\":17,\\\"number\\\":\\\"758\\\",\\\"price\\\":\\\"600000.00\\\",\\\"status\\\":\\\"terisi\\\",\\\"photo\\\":null,\\\"description\\\":\\\"kjsdfj\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-09-10T02:48:39.000000Z\\\",\\\"updated_at\\\":\\\"2025-09-10T02:55:28.000000Z\\\",\\\"tipe_kamar_id\\\":1}\"',NULL,NULL,NULL,'2025-09-28 20:35:41','2025-09-28 20:35:41'),
(517,2,'delete','Menghapus kamar: 893','127.0.0.1',NULL,'admin','\"{\\\"id\\\":18,\\\"number\\\":\\\"893\\\",\\\"price\\\":\\\"500000.00\\\",\\\"status\\\":\\\"terisi\\\",\\\"photo\\\":null,\\\"description\\\":\\\"adhas\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-09-10T02:49:03.000000Z\\\",\\\"updated_at\\\":\\\"2025-09-15T03:42:33.000000Z\\\",\\\"tipe_kamar_id\\\":1}\"',NULL,NULL,NULL,'2025-09-28 20:35:43','2025-09-28 20:35:43'),
(518,2,'delete','Menghapus kamar: 999','127.0.0.1',NULL,'admin','\"{\\\"id\\\":20,\\\"number\\\":\\\"999\\\",\\\"price\\\":\\\"400000.00\\\",\\\"status\\\":\\\"maintenance\\\",\\\"photo\\\":null,\\\"description\\\":\\\"yayaya\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-09-11T06:06:13.000000Z\\\",\\\"updated_at\\\":\\\"2025-09-11T06:06:13.000000Z\\\",\\\"tipe_kamar_id\\\":1}\"',NULL,NULL,NULL,'2025-09-28 20:35:54','2025-09-28 20:35:54'),
(519,2,'delete','Menghapus kamar: 111','127.0.0.1',NULL,'admin','\"{\\\"id\\\":21,\\\"number\\\":\\\"111\\\",\\\"price\\\":\\\"200000.00\\\",\\\"status\\\":\\\"terisi\\\",\\\"photo\\\":null,\\\"description\\\":\\\"wdw\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-09-11T06:06:34.000000Z\\\",\\\"updated_at\\\":\\\"2025-09-11T06:06:34.000000Z\\\",\\\"tipe_kamar_id\\\":1}\"',NULL,NULL,NULL,'2025-09-28 20:35:58','2025-09-28 20:35:58'),
(520,2,'delete','Menghapus kamar: 289','127.0.0.1',NULL,'admin','\"{\\\"id\\\":24,\\\"number\\\":\\\"289\\\",\\\"price\\\":\\\"200000.00\\\",\\\"status\\\":\\\"tersedia\\\",\\\"photo\\\":null,\\\"description\\\":\\\"fwd\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-09-12T01:20:51.000000Z\\\",\\\"updated_at\\\":\\\"2025-09-12T01:55:36.000000Z\\\",\\\"tipe_kamar_id\\\":2}\"',NULL,NULL,NULL,'2025-09-28 20:36:02','2025-09-28 20:36:02'),
(521,2,'delete','Menghapus kamar: 892','127.0.0.1',NULL,'admin','\"{\\\"id\\\":25,\\\"number\\\":\\\"892\\\",\\\"price\\\":\\\"200000.00\\\",\\\"status\\\":\\\"terisi\\\",\\\"photo\\\":null,\\\"description\\\":\\\"asdas\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-09-12T01:55:56.000000Z\\\",\\\"updated_at\\\":\\\"2025-09-12T02:55:16.000000Z\\\",\\\"tipe_kamar_id\\\":3}\"',NULL,NULL,NULL,'2025-09-28 20:36:06','2025-09-28 20:36:06'),
(522,2,'delete','Menghapus kamar: 122','127.0.0.1',NULL,'admin','\"{\\\"id\\\":26,\\\"number\\\":\\\"122\\\",\\\"price\\\":\\\"90000.00\\\",\\\"status\\\":\\\"tersedia\\\",\\\"photo\\\":null,\\\"description\\\":\\\"dummy\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-09-15T02:41:50.000000Z\\\",\\\"updated_at\\\":\\\"2025-09-15T02:41:50.000000Z\\\",\\\"tipe_kamar_id\\\":2}\"',NULL,NULL,NULL,'2025-09-28 20:36:09','2025-09-28 20:36:09'),
(523,2,'delete','Menghapus kamar: 127','127.0.0.1',NULL,'admin','\"{\\\"id\\\":27,\\\"number\\\":\\\"127\\\",\\\"price\\\":\\\"80000.00\\\",\\\"status\\\":\\\"terisi\\\",\\\"photo\\\":null,\\\"description\\\":\\\"guy\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-09-15T02:57:26.000000Z\\\",\\\"updated_at\\\":\\\"2025-09-17T05:22:35.000000Z\\\",\\\"tipe_kamar_id\\\":3}\"',NULL,NULL,NULL,'2025-09-28 20:36:17','2025-09-28 20:36:17'),
(524,2,'delete','Menghapus kamar: 322','127.0.0.1',NULL,'admin','\"{\\\"id\\\":28,\\\"number\\\":\\\"322\\\",\\\"price\\\":\\\"20000.00\\\",\\\"status\\\":\\\"tersedia\\\",\\\"photo\\\":null,\\\"description\\\":\\\"we\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-09-15T03:03:23.000000Z\\\",\\\"updated_at\\\":\\\"2025-09-15T03:03:23.000000Z\\\",\\\"tipe_kamar_id\\\":2}\"',NULL,NULL,NULL,'2025-09-28 20:36:19','2025-09-28 20:36:19'),
(525,2,'delete','Menghapus kamar: 344','127.0.0.1',NULL,'admin','\"{\\\"id\\\":29,\\\"number\\\":\\\"344\\\",\\\"price\\\":\\\"700000.00\\\",\\\"status\\\":\\\"tersedia\\\",\\\"photo\\\":null,\\\"description\\\":\\\"sd\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-09-15T03:05:16.000000Z\\\",\\\"updated_at\\\":\\\"2025-09-15T03:05:16.000000Z\\\",\\\"tipe_kamar_id\\\":3}\"',NULL,NULL,NULL,'2025-09-28 20:36:23','2025-09-28 20:36:23'),
(526,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-28 22:05:01','2025-09-28 22:05:01'),
(527,2,'update','Memperbarui data kamar: 102','127.0.0.1',NULL,'admin','\"{\\\"id\\\":2,\\\"number\\\":\\\"102\\\",\\\"price\\\":\\\"60000.00\\\",\\\"status\\\":\\\"maintenance\\\",\\\"photo\\\":\\\"1759125414_Baixar Cart\\\\u00e3o de quadro de circo gratuitamente.jpeg\\\",\\\"description\\\":\\\"Superior Room\\\\r\\\\nDiscover understated elegance and modern convenience in our Superior Room, designed to provide a relaxing retreat for both business and leisure travelers. With stylish furnishings and thoughtful amenities, this room promises comfort and practicality for a delightful stay.\\\\r\\\\n\\\\r\\\\nRoom Features:\\\\r\\\\n-Comfortable Queen or Twin-sized bed with soft linen\\\\r\\\\n-Individually controlled air-conditioning\\\\r\\\\n-Ensuite bathroom with hot shower and essential toiletries\\\\r\\\\n-Flat-screen TV with local and international channels\\\\r\\\\n-Complimentary high-speed Wi-Fi\\\\r\\\\n-Functional work desk and reading lamp\\\\r\\\\n-Daily complimentary bottled water & coffee\\\\\\/tea making facilities\\\\r\\\\n-Wardrobe, in-room safe, and vanity mirror\\\\r\\\\n-Private balcony (available in selected rooms)\\\\r\\\\n-Room Size: \\\\u00b124\\\\u201328 m\\\\u00b2\\\\r\\\\n-Capacity: Up to 2 adults\\\\r\\\\n-Enjoy a serene atmosphere and warm hospitality in the heart of your destination.\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-08-07T05:49:30.000000Z\\\",\\\"updated_at\\\":\\\"2025-09-29T05:56:54.000000Z\\\",\\\"tipe_kamar_id\\\":\\\"1\\\"}\"','\"{\\\"number\\\":\\\"102\\\",\\\"tipe_kamar_id\\\":\\\"1\\\",\\\"price\\\":\\\"60000.00\\\",\\\"status\\\":\\\"maintenance\\\",\\\"description\\\":\\\"Superior Room\\\\r\\\\nDiscover understated elegance and modern convenience in our Superior Room, designed to provide a relaxing retreat for both business and leisure travelers. With stylish furnishings and thoughtful amenities, this room promises comfort and practicality for a delightful stay.\\\\r\\\\n\\\\r\\\\nRoom Features:\\\\r\\\\n-Comfortable Queen or Twin-sized bed with soft linen\\\\r\\\\n-Individually controlled air-conditioning\\\\r\\\\n-Ensuite bathroom with hot shower and essential toiletries\\\\r\\\\n-Flat-screen TV with local and international channels\\\\r\\\\n-Complimentary high-speed Wi-Fi\\\\r\\\\n-Functional work desk and reading lamp\\\\r\\\\n-Daily complimentary bottled water & coffee\\\\\\/tea making facilities\\\\r\\\\n-Wardrobe, in-room safe, and vanity mirror\\\\r\\\\n-Private balcony (available in selected rooms)\\\\r\\\\n-Room Size: \\\\u00b124\\\\u201328 m\\\\u00b2\\\\r\\\\n-Capacity: Up to 2 adults\\\\r\\\\n-Enjoy a serene atmosphere and warm hospitality in the heart of your destination.\\\",\\\"photo\\\":{}}\"',NULL,NULL,'2025-09-28 22:56:54','2025-09-28 22:56:54'),
(528,2,'update','Memperbarui data kamar: 103','127.0.0.1',NULL,'admin','\"{\\\"id\\\":3,\\\"number\\\":\\\"103\\\",\\\"price\\\":\\\"78000.00\\\",\\\"status\\\":\\\"terisi\\\",\\\"photo\\\":\\\"1755843316_Standard-Room-3.jpg\\\",\\\"description\\\":\\\"Standard Room\\\\r\\\\nSimplicity meets comfort in our Standard Room, offering a cozy and practical space for travelers seeking excellent value without compromising essential amenities. Ideal for solo guests or couples, this room provides a restful environment for a pleasant and convenient stay.\\\\r\\\\n\\\\r\\\\nRoom Features:\\\\r\\\\n-Comfortable Queen or Twin-sized bed with fresh linen\\\\r\\\\n-Air-conditioning with individual temperature control\\\\r\\\\n-Private bathroom with hot shower and basic toiletries\\\\r\\\\n-Flat-screen TV with local channels\\\\r\\\\n-Complimentary Wi-Fi access\\\\r\\\\n-Compact work desk or bedside table\\\\r\\\\n-Daily complimentary bottled water\\\\r\\\\n-Wardrobe or open hanging rack\\\\r\\\\n-Room Size: \\\\u00b118\\\\u201322 m\\\\u00b2\\\\r\\\\n-Capacity: Up to 2 adults\\\\r\\\\n-A smart choice for budget-conscious guests looking for clean, comfortable, and well-located accommodation.\\\",\\\"capacity\\\":1,\\\"floor\\\":null,\\\"facilities\\\":null,\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-08-07T05:50:32.000000Z\\\",\\\"updated_at\\\":\\\"2025-09-29T06:03:33.000000Z\\\",\\\"tipe_kamar_id\\\":\\\"3\\\"}\"','\"{\\\"number\\\":\\\"103\\\",\\\"tipe_kamar_id\\\":\\\"3\\\",\\\"price\\\":\\\"78000.00\\\",\\\"status\\\":\\\"terisi\\\",\\\"description\\\":\\\"Standard Room\\\\r\\\\nSimplicity meets comfort in our Standard Room, offering a cozy and practical space for travelers seeking excellent value without compromising essential amenities. Ideal for solo guests or couples, this room provides a restful environment for a pleasant and convenient stay.\\\\r\\\\n\\\\r\\\\nRoom Features:\\\\r\\\\n-Comfortable Queen or Twin-sized bed with fresh linen\\\\r\\\\n-Air-conditioning with individual temperature control\\\\r\\\\n-Private bathroom with hot shower and basic toiletries\\\\r\\\\n-Flat-screen TV with local channels\\\\r\\\\n-Complimentary Wi-Fi access\\\\r\\\\n-Compact work desk or bedside table\\\\r\\\\n-Daily complimentary bottled water\\\\r\\\\n-Wardrobe or open hanging rack\\\\r\\\\n-Room Size: \\\\u00b118\\\\u201322 m\\\\u00b2\\\\r\\\\n-Capacity: Up to 2 adults\\\\r\\\\n-A smart choice for budget-conscious guests looking for clean, comfortable, and well-located accommodation.\\\"}\"',NULL,NULL,'2025-09-28 23:03:33','2025-09-28 23:03:33'),
(529,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-29 18:57:35','2025-09-29 18:57:35'),
(530,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-30 19:00:54','2025-09-30 19:00:54'),
(531,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-30 21:30:29','2025-09-30 21:30:29'),
(532,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-30 22:29:13','2025-09-30 22:29:13'),
(533,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-30 22:30:03','2025-09-30 22:30:03'),
(534,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-09-30 22:42:49','2025-09-30 22:42:49'),
(535,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-01 19:12:15','2025-10-01 19:12:15'),
(536,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-01 19:23:11','2025-10-01 19:23:11'),
(537,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-01 19:34:43','2025-10-01 19:34:43'),
(538,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-01 19:50:34','2025-10-01 19:50:34'),
(539,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-01 19:50:45','2025-10-01 19:50:45'),
(540,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-01 19:51:29','2025-10-01 19:51:29'),
(541,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-01 19:55:03','2025-10-01 19:55:03'),
(542,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-01 20:01:44','2025-10-01 20:01:44'),
(543,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-01 20:07:37','2025-10-01 20:07:37'),
(544,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 18:54:33','2025-10-05 18:54:33'),
(545,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 18:55:13','2025-10-05 18:55:13'),
(546,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 18:59:20','2025-10-05 18:59:20'),
(547,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 19:00:05','2025-10-05 19:00:05'),
(548,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 20:01:29','2025-10-05 20:01:29'),
(549,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 20:02:47','2025-10-05 20:02:47'),
(550,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 20:03:22','2025-10-05 20:03:22'),
(551,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 20:04:05','2025-10-05 20:04:05'),
(552,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 20:04:28','2025-10-05 20:04:28'),
(553,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 20:05:58','2025-10-05 20:05:58'),
(554,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 20:06:55','2025-10-05 20:06:55'),
(555,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 20:08:21','2025-10-05 20:08:21'),
(556,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 20:15:01','2025-10-05 20:15:01'),
(557,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 20:17:10','2025-10-05 20:17:10'),
(558,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 20:21:55','2025-10-05 20:21:55'),
(559,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 20:22:11','2025-10-05 20:22:11'),
(560,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 20:25:58','2025-10-05 20:25:58'),
(561,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 20:32:54','2025-10-05 20:32:54'),
(562,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 20:34:38','2025-10-05 20:34:38'),
(563,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 20:36:36','2025-10-05 20:36:36'),
(564,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 20:36:48','2025-10-05 20:36:48'),
(565,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 20:36:57','2025-10-05 20:36:57'),
(566,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 20:39:28','2025-10-05 20:39:28'),
(567,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 20:47:35','2025-10-05 20:47:35'),
(568,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 20:49:05','2025-10-05 20:49:05'),
(569,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 20:52:00','2025-10-05 20:52:00'),
(570,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 21:01:09','2025-10-05 21:01:09'),
(571,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 21:01:28','2025-10-05 21:01:28'),
(572,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 21:01:33','2025-10-05 21:01:33'),
(573,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 21:01:40','2025-10-05 21:01:40'),
(574,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 21:01:46','2025-10-05 21:01:46'),
(575,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 21:01:53','2025-10-05 21:01:53'),
(576,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 21:02:01','2025-10-05 21:02:01'),
(577,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 21:03:13','2025-10-05 21:03:13'),
(578,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 21:04:38','2025-10-05 21:04:38'),
(579,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 21:11:47','2025-10-05 21:11:47'),
(580,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 21:15:33','2025-10-05 21:15:33'),
(581,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 21:15:53','2025-10-05 21:15:53'),
(582,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 21:16:41','2025-10-05 21:16:41'),
(583,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 21:17:17','2025-10-05 21:17:17'),
(584,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 21:18:05','2025-10-05 21:18:05'),
(585,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 21:18:57','2025-10-05 21:18:57'),
(586,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 21:21:38','2025-10-05 21:21:38'),
(587,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 21:30:41','2025-10-05 21:30:41'),
(588,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 21:31:50','2025-10-05 21:31:50'),
(589,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 21:34:51','2025-10-05 21:34:51'),
(590,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 21:35:39','2025-10-05 21:35:39'),
(591,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 21:36:02','2025-10-05 21:36:02'),
(592,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 21:36:47','2025-10-05 21:36:47'),
(593,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 21:37:09','2025-10-05 21:37:09'),
(594,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 21:39:42','2025-10-05 21:39:42'),
(595,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 21:41:01','2025-10-05 21:41:01'),
(596,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 21:41:36','2025-10-05 21:41:36'),
(597,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 21:41:54','2025-10-05 21:41:54'),
(598,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 21:44:13','2025-10-05 21:44:13'),
(599,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 21:44:21','2025-10-05 21:44:21'),
(600,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 21:44:49','2025-10-05 21:44:49'),
(601,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 21:45:06','2025-10-05 21:45:06'),
(602,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 21:45:15','2025-10-05 21:45:15'),
(603,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 21:45:24','2025-10-05 21:45:24'),
(604,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 21:48:54','2025-10-05 21:48:54'),
(605,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 21:49:56','2025-10-05 21:49:56'),
(606,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 21:54:14','2025-10-05 21:54:14'),
(607,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 21:54:31','2025-10-05 21:54:31'),
(608,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 21:54:41','2025-10-05 21:54:41'),
(609,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 21:54:47','2025-10-05 21:54:47'),
(610,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 21:54:58','2025-10-05 21:54:58'),
(611,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 21:57:05','2025-10-05 21:57:05'),
(612,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 21:57:14','2025-10-05 21:57:14'),
(613,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-05 21:59:59','2025-10-05 21:59:59'),
(614,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-06 18:56:50','2025-10-06 18:56:50'),
(615,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-06 19:27:55','2025-10-06 19:27:55'),
(616,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-06 20:20:56','2025-10-06 20:20:56'),
(617,2,'create','Menambahkan kamar baru: 433','127.0.0.1',NULL,'admin',NULL,NULL,NULL,NULL,'2025-10-06 20:51:05','2025-10-06 20:51:05'),
(618,2,'delete','Menghapus kamar: 433','127.0.0.1',NULL,'admin','\"{\\\"id\\\":32,\\\"number\\\":\\\"433\\\",\\\"price\\\":\\\"3000000.00\\\",\\\"status\\\":\\\"maintenance\\\",\\\"photo\\\":\\\"1759809065_Screenshot from 2025-06-30 20-22-42.png\\\",\\\"description\\\":\\\"dummy\\\",\\\"capacity\\\":2,\\\"max_occupancy\\\":2,\\\"floor\\\":12,\\\"room_size\\\":\\\"35.00\\\",\\\"bed_type\\\":\\\"Queen\\\",\\\"facilities\\\":null,\\\"features\\\":\\\"[\\\\\\\"Air Conditioning\\\\\\\"]\\\",\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-10-07T03:51:05.000000Z\\\",\\\"updated_at\\\":\\\"2025-10-07T03:51:05.000000Z\\\",\\\"tipe_kamar_id\\\":2}\"',NULL,NULL,NULL,'2025-10-06 20:51:32','2025-10-06 20:51:32'),
(619,2,'delete','Menghapus kamar: 104','127.0.0.1',NULL,'admin','\"{\\\"id\\\":4,\\\"number\\\":\\\"104\\\",\\\"price\\\":\\\"70000.00\\\",\\\"status\\\":\\\"tersedia\\\",\\\"photo\\\":\\\"1755843333_ExecutiveRoom.jpg\\\",\\\"description\\\":\\\"Executive Room\\\\r\\\\nDesigned for business travelers and guests who appreciate extra space and upgraded amenities, our Executive Room combines modern elegance with enhanced comfort. Featuring a spacious layout and thoughtful touches, this room is ideal for extended stays or working on the go.\\\\r\\\\n\\\\r\\\\nRoom Features:\\\\r\\\\n-Premium King or Twin-sized bed with high-quality linen\\\\r\\\\n-Spacious seating area for added comfort\\\\r\\\\n-Individually controlled air-conditioning\\\\r\\\\n-Ensuite bathroom with walk-in shower and deluxe toiletries\\\\r\\\\n-43\\\\\\\" Flat-screen Smart TV with international cable channels\\\\r\\\\n-Complimentary high-speed Wi-Fi\\\\r\\\\n-Executive work desk with ergonomic chair and ambient lighting\\\\r\\\\n-Daily complimentary bottled water, coffee & tea-making facilities\\\\r\\\\n-Mini refrigerator and in-room digital safe\\\\r\\\\n-Full-length mirror and wardrobe with extra storage\\\\r\\\\n-Privatebalcony with city or garden view (available in selectedrooms)\\\\r\\\\n-Room Size: \\\\u00b132\\\\u201338 m\\\\u00b2\\\\r\\\\n-Capacity: Up to 2 adults (extra bed available upon request)\\\\r\\\\n-Experience elevated hospitality with extra space, exclusive comfort, and refined ambiance in every stay.\\\",\\\"capacity\\\":1,\\\"max_occupancy\\\":2,\\\"floor\\\":1,\\\"room_size\\\":null,\\\"bed_type\\\":null,\\\"facilities\\\":null,\\\"features\\\":[],\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-08-07T05:51:30.000000Z\\\",\\\"updated_at\\\":\\\"2025-09-18T03:21:20.000000Z\\\",\\\"tipe_kamar_id\\\":1}\"',NULL,NULL,NULL,'2025-10-06 20:52:01','2025-10-06 20:52:01'),
(620,2,'create','Menambahkan kamar baru: 355','127.0.0.1',NULL,'admin',NULL,NULL,NULL,NULL,'2025-10-06 21:06:36','2025-10-06 21:06:36'),
(621,2,'create','Menambahkan kamar baru: 788','127.0.0.1',NULL,'admin',NULL,NULL,NULL,NULL,'2025-10-06 21:08:35','2025-10-06 21:08:35'),
(622,2,'delete','Menghapus kamar: 355','127.0.0.1',NULL,'admin','\"{\\\"id\\\":33,\\\"number\\\":\\\"355\\\",\\\"price\\\":\\\"2000000.00\\\",\\\"status\\\":\\\"maintenance\\\",\\\"photo\\\":\\\"1759809996_Screenshot from 2025-06-30 20-22-42.png\\\",\\\"description\\\":\\\"dummy\\\",\\\"capacity\\\":2,\\\"max_occupancy\\\":2,\\\"floor\\\":6,\\\"room_size\\\":\\\"35.00\\\",\\\"bed_type\\\":\\\"King\\\",\\\"facilities\\\":null,\\\"features\\\":\\\"[\\\\\\\"Air Conditioning\\\\\\\",\\\\\\\"TV\\\\\\\",\\\\\\\"Balcony\\\\\\\"]\\\",\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-10-07T04:06:36.000000Z\\\",\\\"updated_at\\\":\\\"2025-10-07T04:06:36.000000Z\\\",\\\"tipe_kamar_id\\\":2,\\\"tipe_kamar\\\":{\\\"id\\\":2,\\\"tipe_kamar\\\":\\\"king bad\\\",\\\"jumlah_kamar\\\":1,\\\"price\\\":null,\\\"created_at\\\":\\\"2025-09-10T02:23:44.000000Z\\\",\\\"updated_at\\\":\\\"2025-10-07T04:06:36.000000Z\\\",\\\"kamar_tersedia\\\":0}}\"',NULL,NULL,NULL,'2025-10-06 21:09:08','2025-10-06 21:09:08'),
(623,2,'create','Menambahkan kamar baru: 211','127.0.0.1',NULL,'admin',NULL,NULL,NULL,NULL,'2025-10-06 21:13:18','2025-10-06 21:13:18'),
(624,2,'delete','Menghapus kamar: 211','127.0.0.1',NULL,'admin','\"{\\\"id\\\":35,\\\"number\\\":\\\"211\\\",\\\"price\\\":\\\"200000.00\\\",\\\"status\\\":\\\"tersedia\\\",\\\"photo\\\":\\\"1759810398__ (2).jpeg\\\",\\\"description\\\":\\\"dummy\\\",\\\"capacity\\\":3,\\\"max_occupancy\\\":3,\\\"floor\\\":4,\\\"room_size\\\":\\\"35.00\\\",\\\"bed_type\\\":\\\"Twin\\\",\\\"facilities\\\":null,\\\"features\\\":\\\"[\\\\\\\"Air Conditioning\\\\\\\"]\\\",\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-10-07T04:13:18.000000Z\\\",\\\"updated_at\\\":\\\"2025-10-07T04:13:18.000000Z\\\",\\\"tipe_kamar_id\\\":5}\"',NULL,NULL,NULL,'2025-10-06 21:13:37','2025-10-06 21:13:37'),
(625,2,'create','Menambahkan kamar baru: 799','127.0.0.1',NULL,'admin',NULL,NULL,NULL,NULL,'2025-10-06 21:15:18','2025-10-06 21:15:18'),
(626,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-07 03:35:48','2025-10-07 03:35:48'),
(627,2,'create','Menambahkan kamar baru: 544','127.0.0.1',NULL,'admin',NULL,NULL,NULL,NULL,'2025-10-07 04:15:08','2025-10-07 04:15:08'),
(628,2,'delete','Menghapus kamar: 544','127.0.0.1',NULL,'admin','\"{\\\"id\\\":37,\\\"number\\\":\\\"544\\\",\\\"price\\\":\\\"200000.00\\\",\\\"status\\\":\\\"dipesan\\\",\\\"photo\\\":\\\"1759835708__ (2).jpeg\\\",\\\"description\\\":\\\"dummy\\\",\\\"capacity\\\":3,\\\"max_occupancy\\\":3,\\\"floor\\\":4,\\\"room_size\\\":\\\"23.00\\\",\\\"bed_type\\\":\\\"Single\\\",\\\"facilities\\\":null,\\\"features\\\":\\\"[\\\\\\\"Air Conditioning\\\\\\\",\\\\\\\"TV\\\\\\\",\\\\\\\"Minibar\\\\\\\",\\\\\\\"WiFi\\\\\\\"]\\\",\\\"deleted_at\\\":null,\\\"created_at\\\":\\\"2025-10-07T11:15:08.000000Z\\\",\\\"updated_at\\\":\\\"2025-10-07T11:15:08.000000Z\\\",\\\"tipe_kamar_id\\\":6}\"',NULL,NULL,NULL,'2025-10-07 04:18:35','2025-10-07 04:18:35'),
(629,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-07 04:56:08','2025-10-07 04:56:08'),
(630,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-07 04:56:56','2025-10-07 04:56:56'),
(631,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-07 05:05:06','2025-10-07 05:05:06'),
(632,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-07 05:07:59','2025-10-07 05:07:59'),
(633,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-07 05:25:09','2025-10-07 05:25:09'),
(634,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-07 19:04:15','2025-10-07 19:04:15'),
(635,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-07 19:04:24','2025-10-07 19:04:24'),
(636,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-07 20:52:01','2025-10-07 20:52:01'),
(637,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-07 23:24:34','2025-10-07 23:24:34'),
(638,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-08 19:06:45','2025-10-08 19:06:45'),
(639,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-10 05:46:36','2025-10-10 05:46:36'),
(640,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-15 19:01:22','2025-10-15 19:01:22'),
(641,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-15 19:34:46','2025-10-15 19:34:46'),
(642,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-15 19:36:30','2025-10-15 19:36:30'),
(643,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-15 19:41:29','2025-10-15 19:41:29'),
(644,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-15 19:44:44','2025-10-15 19:44:44'),
(645,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-15 19:48:18','2025-10-15 19:48:18'),
(646,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-15 20:04:26','2025-10-15 20:04:26'),
(647,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-15 21:56:21','2025-10-15 21:56:21'),
(648,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-15 21:56:39','2025-10-15 21:56:39'),
(649,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-15 21:57:47','2025-10-15 21:57:47'),
(650,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-15 21:57:55','2025-10-15 21:57:55'),
(651,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-16 21:56:57','2025-10-16 21:56:57'),
(652,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-19 22:12:45','2025-10-19 22:12:45'),
(653,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-19 22:18:56','2025-10-19 22:18:56'),
(654,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-19 22:19:34','2025-10-19 22:19:34'),
(655,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-19 22:20:02','2025-10-19 22:20:02'),
(656,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-19 22:52:24','2025-10-19 22:52:24'),
(657,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-20 03:11:50','2025-10-20 03:11:50'),
(658,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-20 20:36:16','2025-10-20 20:36:16'),
(659,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-20 20:37:18','2025-10-20 20:37:18'),
(660,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-20 21:01:21','2025-10-20 21:01:21'),
(661,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-20 21:30:15','2025-10-20 21:30:15'),
(662,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-20 22:30:46','2025-10-20 22:30:46'),
(663,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-21 19:51:29','2025-10-21 19:51:29'),
(664,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-22 19:35:09','2025-10-22 19:35:09'),
(665,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-22 22:14:05','2025-10-22 22:14:05'),
(666,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-10-22 22:14:58','2025-10-22 22:14:58'),
(667,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-11-04 00:18:18','2025-11-04 00:18:18'),
(668,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-11-04 00:19:35','2025-11-04 00:19:35'),
(669,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-11-04 00:19:44','2025-11-04 00:19:44'),
(670,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-11-04 00:19:59','2025-11-04 00:19:59'),
(671,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-11-04 00:20:33','2025-11-04 00:20:33'),
(672,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-11-04 00:21:05','2025-11-04 00:21:05'),
(673,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-11-04 00:24:31','2025-11-04 00:24:31'),
(674,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-11-04 00:25:26','2025-11-04 00:25:26'),
(675,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-11-04 00:25:48','2025-11-04 00:25:48'),
(676,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-11-04 00:25:56','2025-11-04 00:25:56'),
(677,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-11-04 00:27:12','2025-11-04 00:27:12'),
(678,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-11-04 00:28:20','2025-11-04 00:28:20'),
(679,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-11-04 00:33:26','2025-11-04 00:33:26'),
(680,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-11-04 00:34:33','2025-11-04 00:34:33'),
(681,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-11-06 23:11:38','2025-11-06 23:11:38'),
(682,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-11-07 01:53:09','2025-11-07 01:53:09'),
(683,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-11-07 01:54:17','2025-11-07 01:54:17'),
(684,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-11-09 20:43:55','2025-11-09 20:43:55'),
(685,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-11-10 20:21:27','2025-11-10 20:21:27'),
(686,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-11-10 20:25:58','2025-11-10 20:25:58'),
(687,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-11-10 20:25:58','2025-11-10 20:25:58'),
(688,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-11-10 20:41:14','2025-11-10 20:41:14');
/*!40000 ALTER TABLE `activity_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `analytics_cache`
--

DROP TABLE IF EXISTS `analytics_cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `analytics_cache` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `period` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `room_type` varchar(255) DEFAULT NULL,
  `channel` varchar(255) DEFAULT NULL,
  `bookings_count` int(11) NOT NULL DEFAULT 0,
  `revenue` bigint(20) NOT NULL DEFAULT 0,
  `occupancy_rate` decimal(5,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `analytics_cache`
--

LOCK TABLES `analytics_cache` WRITE;
/*!40000 ALTER TABLE `analytics_cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `analytics_cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `booking_facility`
--

DROP TABLE IF EXISTS `booking_facility`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `booking_facility` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `booking_id` bigint(20) unsigned NOT NULL,
  `facility_id` bigint(20) unsigned NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `booking_facility_booking_id_foreign` (`booking_id`),
  KEY `booking_facility_facility_id_foreign` (`facility_id`),
  CONSTRAINT `booking_facility_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  CONSTRAINT `booking_facility_facility_id_foreign` FOREIGN KEY (`facility_id`) REFERENCES `facilities` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `booking_facility`
--

LOCK TABLES `booking_facility` WRITE;
/*!40000 ALTER TABLE `booking_facility` DISABLE KEYS */;
INSERT INTO `booking_facility` VALUES
(1,37,11,1,20000.00,NULL,NULL,'2025-09-16 22:32:18','2025-09-16 22:32:18'),
(3,39,12,1,50000.00,'2025-09-19','2025-09-20','2025-09-18 18:12:02','2025-09-18 18:12:02');
/*!40000 ALTER TABLE `booking_facility` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bookings`
--

DROP TABLE IF EXISTS `bookings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `bookings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `guest_id` bigint(20) unsigned NOT NULL,
  `booking_code` varchar(255) NOT NULL,
  `room_id` bigint(20) unsigned NOT NULL,
  `booking_source` varchar(255) DEFAULT NULL,
  `adults` int(11) NOT NULL DEFAULT 1,
  `children` int(11) NOT NULL DEFAULT 0,
  `special_requests` text DEFAULT NULL,
  `check_in` date NOT NULL,
  `check_in_time` time DEFAULT NULL,
  `check_out` date NOT NULL,
  `check_out_time` time DEFAULT NULL,
  `status` enum('booked','checked_in','checked_out','canceled','paid') NOT NULL DEFAULT 'booked',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `total_price` int(11) NOT NULL DEFAULT 0,
  `deposit` decimal(10,2) NOT NULL DEFAULT 0.00,
  `payment_method` varchar(255) DEFAULT NULL,
  `early_checkin` tinyint(1) NOT NULL DEFAULT 0,
  `breakfast_included` tinyint(1) NOT NULL DEFAULT 0,
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bookings_booking_code_unique` (`booking_code`),
  KEY `bookings_user_id_foreign` (`user_id`),
  KEY `bookings_guest_id_foreign` (`guest_id`),
  KEY `bookings_room_id_foreign` (`room_id`),
  CONSTRAINT `bookings_guest_id_foreign` FOREIGN KEY (`guest_id`) REFERENCES `guests` (`id`) ON DELETE CASCADE,
  CONSTRAINT `bookings_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
  CONSTRAINT `bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bookings`
--

LOCK TABLES `bookings` WRITE;
/*!40000 ALTER TABLE `bookings` DISABLE KEYS */;
INSERT INTO `bookings` VALUES
(29,3,11,'BK-000029',11,NULL,1,0,NULL,'2025-08-26',NULL,'2025-08-29',NULL,'booked','2025-08-18 19:22:21','2025-08-26 01:12:52',0,0.00,NULL,0,0,0.00),
(31,2,13,'BK-000031',1,NULL,1,0,NULL,'2025-09-08',NULL,'2025-09-10',NULL,'booked','2025-09-07 19:14:41','2025-09-07 19:14:41',0,0.00,NULL,0,0,0.00),
(32,2,14,'BK-000032',16,NULL,1,0,NULL,'2025-09-10',NULL,'2025-09-12',NULL,'paid','2025-09-09 19:12:25','2025-09-17 20:39:42',0,0.00,NULL,0,0,0.00),
(33,2,2,'BK-000033',17,NULL,1,0,NULL,'2025-09-10',NULL,'2025-09-13',NULL,'booked','2025-09-09 19:55:28','2025-09-09 19:55:28',0,0.00,NULL,0,0,0.00),
(34,2,8,'BK-000034',25,NULL,1,0,NULL,'2025-09-12',NULL,'2025-09-16',NULL,'paid','2025-09-11 19:55:16','2025-09-11 21:27:13',0,0.00,NULL,0,0,0.00),
(35,2,18,'BK-000035',1,NULL,1,0,NULL,'2025-09-15',NULL,'2025-09-19',NULL,'booked','2025-09-14 20:31:47','2025-09-14 20:31:47',0,0.00,NULL,0,0,0.00),
(36,2,17,'BK-000036',18,NULL,1,0,NULL,'2025-09-22',NULL,'2025-09-24',NULL,'booked','2025-09-14 20:42:32','2025-09-14 20:42:32',0,0.00,NULL,0,0,0.00),
(37,2,15,'BK-000037',27,NULL,1,0,NULL,'2025-09-17',NULL,'2025-09-20',NULL,'booked','2025-09-16 22:22:35','2025-09-16 22:32:18',0,0.00,NULL,0,0,0.00),
(39,2,20,'BK-000039',3,NULL,1,0,NULL,'2025-09-19',NULL,'2025-09-22',NULL,'checked_in','2025-09-18 18:12:02','2025-09-18 18:12:02',0,0.00,NULL,0,0,0.00);
/*!40000 ALTER TABLE `bookings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `coupons`
--

DROP TABLE IF EXISTS `coupons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `coupons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `discount_type` enum('percentage','fixed') NOT NULL,
  `discount_value` decimal(10,2) NOT NULL,
  `max_uses` int(11) DEFAULT NULL,
  `valid_from` date NOT NULL,
  `valid_to` date NOT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coupons`
--

LOCK TABLES `coupons` WRITE;
/*!40000 ALTER TABLE `coupons` DISABLE KEYS */;
/*!40000 ALTER TABLE `coupons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `facilities`
--

DROP TABLE IF EXISTS `facilities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `facilities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `capacity` int(10) unsigned DEFAULT 0,
  `price_per_night` decimal(12,2) unsigned DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `facilities`
--

LOCK TABLES `facilities` WRITE;
/*!40000 ALTER TABLE `facilities` DISABLE KEYS */;
INSERT INTO `facilities` VALUES
(9,'Spa','dummy','facilities/zDCaWlVObOizS86GYHWgr4PTZNObL6m1KvRrKpNa.jpg','inactive',13,55000.00,'2025-09-16 21:35:03','2025-09-17 21:44:02'),
(10,'Kolam Renang','dummy','facilities/LDBkYVirSi0X0Jg43selcV83CZPH4EYo5qeOIqml.jpg','active',20,30000.00,'2025-09-16 22:21:55','2025-09-17 21:00:06'),
(11,'Gym','dummy','facilities/oP5wNSuXE79570qO3yrC8vr4oiy96ttOmUuJaipU.jpg','active',40,20000.00,'2025-09-16 22:31:52','2025-09-17 20:59:58'),
(12,'Gym lt2','dummy','facilities/ur6Eb9Z8XFf7HKe4BXeHXHV4gkes1gKzGejx0AId.jpg','inactive',12,50000.00,'2025-09-18 18:00:48','2025-09-18 18:12:02');
/*!40000 ALTER TABLE `facilities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `finances`
--

DROP TABLE IF EXISTS `finances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `finances` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `transaction_id` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `type` enum('income','expense') NOT NULL,
  `amount` bigint(20) NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `finances_transaction_id_unique` (`transaction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `finances`
--

LOCK TABLES `finances` WRITE;
/*!40000 ALTER TABLE `finances` DISABLE KEYS */;
/*!40000 ALTER TABLE `finances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `guests`
--

DROP TABLE IF EXISTS `guests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `guests` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `guest_code` varchar(255) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `identity_number` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL COMMENT 'Tanggal lahir untuk promosi ulang tahun',
  `nationality` varchar(100) DEFAULT NULL COMMENT 'Negara / kebangsaan',
  `profession` varchar(255) DEFAULT NULL COMMENT 'Profesi / pekerjaan tamu',
  `notes` text DEFAULT NULL COMMENT 'Catatan khusus / preferensi tamu',
  `photo` varchar(255) DEFAULT NULL COMMENT 'Foto / scan KTP',
  `marital_status` enum('single','married','divorced','widowed') DEFAULT NULL COMMENT 'Status pernikahan',
  `loyalty_points` int(10) unsigned DEFAULT 0 COMMENT 'Frekuensi menginap / loyalty points',
  `social_account` varchar(255) DEFAULT NULL COMMENT 'Akun media sosial / WhatsApp',
  `guest_type` enum('reguler','vip','vvip','corporate','staff') DEFAULT 'reguler' COMMENT 'Tipe tamu',
  `health_notes` text DEFAULT NULL COMMENT 'Catatan kesehatan / alergi',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `guests`
--

LOCK TABLES `guests` WRITE;
/*!40000 ALTER TABLE `guests` DISABLE KEYS */;
INSERT INTO `guests` VALUES
(1,'','Dandi','Pratamaa','Dandi Pratamaa','0812-3456-7890','3174091203980001',NULL,NULL,NULL,'2025-08-06 22:57:18','2025-08-14 20:38:12',NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,'reguler',NULL),
(2,'','Siti','Nurhaliza','Siti Nurhaliza','0821-9876-5432','3271056704920002',NULL,NULL,NULL,'2025-08-06 22:57:46','2025-08-06 22:57:46',NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,'reguler',NULL),
(4,'','Rina','Maharani','Rina Maharani','0813-4455-6677','3205061803950004',NULL,NULL,NULL,'2025-08-06 22:59:10','2025-08-06 22:59:10',NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,'reguler',NULL),
(5,'','Fajar','Ramadhan','Fajar Ramadhan','0896-1122-3344','3173063001010005',NULL,NULL,NULL,'2025-08-06 22:59:43','2025-08-06 22:59:43',NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,'reguler',NULL),
(7,'','naura','naura','naura','098737374','327458433',NULL,NULL,NULL,'2025-08-14 20:12:12','2025-08-14 20:12:12',NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,'reguler',NULL),
(8,'','manda','manda','manda','0434786733','74385745',NULL,NULL,NULL,'2025-08-14 20:14:10','2025-08-14 20:14:10',NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,'reguler',NULL),
(10,'','yanii','yanii','yanii','04957355346','09655448',NULL,NULL,NULL,'2025-08-18 19:21:36','2025-08-18 19:21:50',NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,'reguler',NULL),
(11,'','narin','prandari','narin prandari','0857465363737','5857478449',NULL,NULL,NULL,'2025-08-18 19:22:21','2025-08-18 19:22:21',NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,'reguler',NULL),
(12,'','pak','sugi','pak sugi','0947457534','5787838',NULL,NULL,NULL,'2025-08-26 01:13:34','2025-08-26 01:13:34',NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,'reguler',NULL),
(13,'','jena','jena','jena','088445737','384758364785',NULL,NULL,NULL,'2025-09-07 19:14:41','2025-09-07 19:14:41',NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,'reguler',NULL),
(14,'','nara','nara','nara','03583458','8932746835',NULL,NULL,NULL,'2025-09-07 22:47:49','2025-09-08 11:25:33','2005-01-02',NULL,NULL,'suka sarapan pagi','1757310469__ (2).jpeg','single',0,NULL,'vip',NULL),
(15,'','jena','jena','jena','043857857645','0845783',NULL,NULL,NULL,'2025-09-08 11:30:27','2025-09-08 11:30:27','1994-01-10',NULL,NULL,'suka sarapan','1757356227__.jpeg','married',0,NULL,'vvip',NULL),
(17,'TM250001','nanda','nanda','nanda','083117711364','12345678',NULL,NULL,NULL,'2025-09-08 12:21:51','2025-09-08 12:21:51','1994-07-06',NULL,NULL,'dummy','1757359311__ (2).jpeg','married',0,NULL,'vvip',NULL),
(18,'TM250002','galih','pradana','galih pradana','03846563','32436456','galih@gmail.com','male','dummy','2025-09-14 20:21:02','2025-09-14 20:21:02','1999-05-12',NULL,NULL,'dummy',NULL,'single',0,NULL,'reguler',NULL),
(20,'TM250003','janu','janu','janu','047684586','894574','janu@gmail.com','male','dummy','2025-09-18 18:11:24','2025-09-18 18:11:24','2006-01-17',NULL,NULL,'alergi udang','1758244284_dummy man.jpeg','single',0,NULL,'vvip',NULL);
/*!40000 ALTER TABLE `guests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoices`
--

DROP TABLE IF EXISTS `invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `invoices` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `invoice_number` varchar(255) NOT NULL,
  `client` varchar(255) NOT NULL,
  `issue_date` date NOT NULL,
  `due_date` date NOT NULL,
  `amount` bigint(20) NOT NULL,
  `status` enum('paid','pending','overdue') NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invoices_invoice_number_unique` (`invoice_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoices`
--

LOCK TABLES `invoices` WRITE;
/*!40000 ALTER TABLE `invoices` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES
(1,'0001_01_01_000000_create_users_table',1),
(2,'0001_01_01_000001_create_cache_table',1),
(3,'0001_01_01_000002_create_jobs_table',1),
(4,'2025_07_21_072421_create_rooms_table',1),
(5,'2025_07_21_072435_create_guests_table',1),
(7,'2025_07_21_072517_create_payments_table',1),
(8,'2025_07_31_024841_add_role_and_password_plain_to_users_table',1),
(9,'2025_07_31_070435_create_activity_logs_table',1),
(10,'2025_08_01_060505_add_photo_to_users_table',1),
(11,'2025_08_05_035249_add_deleted_at_to_rooms_table',1),
(12,'2025_08_06_040854_add_total_price_to_bookings_table',1),
(13,'2025_08_06_054439_create_user_activities_table',1),
(14,'2025_08_11_130110_add_total_to_payments_table',2),
(15,'2025_08_11_131954_add_paid_status_to_bookings_table',3),
(16,'2025_08_06_054439_create_activities_logs_table',4),
(17,'2025_08_12_025810_create_user_activities_table',5),
(18,'2025_08_14_063129_add_address_phone_to_users_table',6),
(19,'2025_09_08_030928_add_timestamps_to_tipe_kamar_table',7),
(22,'2025_09_08_184625_add_guest_code_to_guests_table',1),
(26,'2025_09_08_184335_add_email_gender_address_to_guests_table',8),
(27,'2025_09_11_050108_remove_tipe_kamar_id_from_rooms_temporarily',9),
(28,'2025_09_11_050814_add_tipe_kamar_id_to_rooms_table',10),
(30,'2025_09_11_051154_add_foreign_key_tipe_kamar_id_to_rooms',11),
(31,'2025_09_16_033402_create_facilities_table',12),
(32,'2025_09_16_034016_create_room_facility_table',13),
(33,'2025_09_17_023520_update_facilities_table',14),
(34,'2025_09_17_050959_create_booking_facility_table',14),
(35,'2025_09_17_052915_add_dates_to_booking_facility_table',15),
(36,'2025_09_26_121409_create_rate_plans_table',16),
(37,'2025_10_01_022356_add_price_to_tipe_kamar_table',17),
(38,'2025_10_02_054314_add_missing_columns_to_rate_plans_table',18),
(39,'2025_10_07_022017_add_more_fields_to_rooms_table',19),
(40,'2025_10_07_102921_add_missing_columns_to_tipe_kamar_table',20),
(41,'2025_10_09_054417_add_missing_columns_to_bookings_table',21),
(42,'2025_10_16_050703_add_staff_fields_to_users_table',22),
(43,'2025_10_17_052805_create_analytics_cache_table',23),
(44,'2025_10_21_034115_create_finances_table',24),
(45,'2025_10_23_061548_create_rooms_table',1),
(46,'2025_10_23_061645_create_bookings_table',1),
(47,'2025_10_24_035149_add_missing_columns_to_bookings_table',25),
(48,'2025_10_24_035211_split_guest_name_into_first_last',25),
(49,'2025_10_24_035231_add_type_view_beds_to_rooms_table',25),
(50,'2025_10_27_034424_add_cleaning_status_to_rooms_table',26);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `payments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `booking_id` bigint(20) unsigned NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `paid_at` timestamp NOT NULL,
  `method` enum('cash','transfer','qris') NOT NULL DEFAULT 'cash',
  `total` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payments_booking_id_foreign` (`booking_id`),
  CONSTRAINT `payments_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES
(34,29,2400000.00,'2025-08-18 20:49:00','transfer',2400000.00,'2025-08-18 20:49:32','2025-08-18 20:49:32'),
(37,32,600000.00,'2025-09-17 20:39:00','cash',600000.00,'2025-09-17 20:39:42','2025-09-17 20:39:42');
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rate_plans`
--

DROP TABLE IF EXISTS `rate_plans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `rate_plans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `room_types` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `rate_adjustment_sign` varchar(1) NOT NULL DEFAULT '+',
  `rate_adjustment_value` decimal(10,2) NOT NULL,
  `rate_adjustment_type` varchar(255) NOT NULL DEFAULT 'percentage',
  `min_stay` int(11) DEFAULT NULL,
  `release_days` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rate_plans`
--

LOCK TABLES `rate_plans` WRITE;
/*!40000 ALTER TABLE `rate_plans` DISABLE KEYS */;
INSERT INTO `rate_plans` VALUES
(2,'dummy','seasonal','[\"all\"]','2025-10-02','2025-10-08','2025-10-01 22:56:06','2025-10-01 22:56:06','+',25.00,'percentage',2,22,'dummy',0),
(4,'jajaw','promotion','[\"deluxe\",\"king bad\"]','2025-10-06','2025-10-10','2025-10-05 19:20:09','2025-10-05 22:37:19','+',15.00,'percentage',2,3,'dummy',1),
(5,'dummy 2','event','[\"deluxe\"]','2025-10-08','2025-10-11','2025-10-05 21:21:30','2025-10-05 21:21:30','+',25.00,'percentage',2,3,'dummy',1),
(6,'sfk','seasonal','[\"all\"]','2025-10-06','2025-11-06','2025-10-05 22:04:05','2025-10-05 22:04:05','+',15.00,'percentage',4,3,'sdmls',1);
/*!40000 ALTER TABLE `rate_plans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `room_facility`
--

DROP TABLE IF EXISTS `room_facility`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `room_facility` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `room_id` bigint(20) unsigned NOT NULL,
  `facility_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_room_id` (`room_id`),
  KEY `idx_facility_id` (`facility_id`),
  CONSTRAINT `room_facility_facility_id_foreign` FOREIGN KEY (`facility_id`) REFERENCES `facilities` (`id`) ON DELETE CASCADE,
  CONSTRAINT `room_facility_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `room_facility`
--

LOCK TABLES `room_facility` WRITE;
/*!40000 ALTER TABLE `room_facility` DISABLE KEYS */;
/*!40000 ALTER TABLE `room_facility` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rooms`
--

DROP TABLE IF EXISTS `rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `rooms` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `number` varchar(255) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `view` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` enum('tersedia','terisi','maintenance','dipesan','cleaning') NOT NULL DEFAULT 'tersedia',
  `photo` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `capacity` int(11) NOT NULL DEFAULT 1,
  `max_occupancy` int(11) NOT NULL DEFAULT 2,
  `beds` int(11) NOT NULL DEFAULT 1,
  `floor` int(11) NOT NULL DEFAULT 1,
  `room_size` decimal(8,2) DEFAULT NULL,
  `bed_type` varchar(255) DEFAULT NULL,
  `facilities` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`facilities`)),
  `features` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`features`)),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tipe_kamar_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rooms_number_unique` (`number`),
  KEY `idx_tipe_kamar_id` (`tipe_kamar_id`),
  CONSTRAINT `rooms_tipe_kamar_id_foreign` FOREIGN KEY (`tipe_kamar_id`) REFERENCES `tipe_kamar` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rooms`
--

LOCK TABLES `rooms` WRITE;
/*!40000 ALTER TABLE `rooms` DISABLE KEYS */;
INSERT INTO `rooms` VALUES
(1,'101',NULL,NULL,76000.00,'terisi','1758170227__ (2).jpeg','Deluxe Room\r\nExperience the perfect blend of comfort and sophistication in our Deluxe Room, thoughtfully designed for discerning guests seeking refined accommodation. Whether for business or leisure, this room offers exceptional amenities and elegant ambiance to ensure a truly memorable stay.\r\n\r\nRoom Features:\r\n-Premium Queen/King-sized bed with luxury linen\r\n-Individually controlled air-conditioning\r\n-Ensuite bathroom with hot shower and exclusive toiletries\r\n-Flat-screen TV with international cable channels\r\n-Complimentary high-speed Wi-Fi\r\n-Functional work desk with ambient lighting\r\n-Daily complimentary bottled water & coffee/tea making facilities\r\n-Wardrobe, digital safe, and large mirror\r\n-Private balcony (available in selected rooms)\r\n-Room Size: ±28–32 m²\r\n-Capacity: Up to 2 adults (extra bed available upon request)\r\n-Unwind in style and enjoy warm hospitality with every stay.',1,2,1,1,NULL,NULL,NULL,NULL,NULL,'2025-08-06 22:48:41','2025-09-17 21:37:07',3),
(2,'102',NULL,NULL,60000.00,'maintenance','1759125414_Baixar Cartão de quadro de circo gratuitamente.jpeg','Superior Room\r\nDiscover understated elegance and modern convenience in our Superior Room, designed to provide a relaxing retreat for both business and leisure travelers. With stylish furnishings and thoughtful amenities, this room promises comfort and practicality for a delightful stay.\r\n\r\nRoom Features:\r\n-Comfortable Queen or Twin-sized bed with soft linen\r\n-Individually controlled air-conditioning\r\n-Ensuite bathroom with hot shower and essential toiletries\r\n-Flat-screen TV with local and international channels\r\n-Complimentary high-speed Wi-Fi\r\n-Functional work desk and reading lamp\r\n-Daily complimentary bottled water & coffee/tea making facilities\r\n-Wardrobe, in-room safe, and vanity mirror\r\n-Private balcony (available in selected rooms)\r\n-Room Size: ±24–28 m²\r\n-Capacity: Up to 2 adults\r\n-Enjoy a serene atmosphere and warm hospitality in the heart of your destination.',1,2,1,1,NULL,NULL,NULL,NULL,NULL,'2025-08-06 22:49:30','2025-09-28 22:56:54',1),
(3,'103',NULL,NULL,78000.00,'terisi','1755843316_Standard-Room-3.jpg','Standard Room\r\nSimplicity meets comfort in our Standard Room, offering a cozy and practical space for travelers seeking excellent value without compromising essential amenities. Ideal for solo guests or couples, this room provides a restful environment for a pleasant and convenient stay.\r\n\r\nRoom Features:\r\n-Comfortable Queen or Twin-sized bed with fresh linen\r\n-Air-conditioning with individual temperature control\r\n-Private bathroom with hot shower and basic toiletries\r\n-Flat-screen TV with local channels\r\n-Complimentary Wi-Fi access\r\n-Compact work desk or bedside table\r\n-Daily complimentary bottled water\r\n-Wardrobe or open hanging rack\r\n-Room Size: ±18–22 m²\r\n-Capacity: Up to 2 adults\r\n-A smart choice for budget-conscious guests looking for clean, comfortable, and well-located accommodation.',1,2,1,1,NULL,NULL,NULL,NULL,NULL,'2025-08-06 22:50:32','2025-09-28 23:03:33',3),
(4,'104',NULL,NULL,70000.00,'tersedia','1755843333_ExecutiveRoom.jpg','Executive Room\r\nDesigned for business travelers and guests who appreciate extra space and upgraded amenities, our Executive Room combines modern elegance with enhanced comfort. Featuring a spacious layout and thoughtful touches, this room is ideal for extended stays or working on the go.\r\n\r\nRoom Features:\r\n-Premium King or Twin-sized bed with high-quality linen\r\n-Spacious seating area for added comfort\r\n-Individually controlled air-conditioning\r\n-Ensuite bathroom with walk-in shower and deluxe toiletries\r\n-43\" Flat-screen Smart TV with international cable channels\r\n-Complimentary high-speed Wi-Fi\r\n-Executive work desk with ergonomic chair and ambient lighting\r\n-Daily complimentary bottled water, coffee & tea-making facilities\r\n-Mini refrigerator and in-room digital safe\r\n-Full-length mirror and wardrobe with extra storage\r\n-Privatebalcony with city or garden view (available in selectedrooms)\r\n-Room Size: ±32–38 m²\r\n-Capacity: Up to 2 adults (extra bed available upon request)\r\n-Experience elevated hospitality with extra space, exclusive comfort, and refined ambiance in every stay.',1,2,1,1,NULL,NULL,NULL,NULL,'2025-10-06 20:52:01','2025-08-06 22:51:30','2025-10-06 20:52:01',1),
(5,'105',NULL,NULL,80000.00,'dipesan','room-photos/8Dj5ySk3KqVZbnimFcPSCf09T7hbZdCwv2BT33Hg.jpg','Junior Suite\r\nIndulge in a refined stay in our Junior Suite, where sophistication meets spacious comfort. Perfect for couples or executives, this elegantly appointed suite offers a seamless blend of relaxation and functionality in a stylish open-concept layout.\r\n\r\nRoom Features:\r\n-Luxurious King-sized bed with premium linen and plush pillows\r\n-Separate seating or lounge area for added privacy\r\n-Individually controlled air-conditioning\r\n-Spacious ensuite bathroom with walk-in shower and deluxe amenities\r\n-43\" or larger Flat-screen Smart TV with international channels-\r\n-Complimentary high-speed Wi-Fi\r\n-Executive writing desk with comfortable chair\r\n-Daily complimentary bottled water, coffee & tea-making facilities\r\n-Mini bar and in-room safe\r\n-Large wardrobe with full-length mirror\r\n-Private balcony or large window with scenic view (available in selected suites)\r\n-Room Size: ±40–45 m²\r\n-Capacity: Up to 2 adults (ideal for longer or luxury stays)\r\n-Relax in style and experience a higher level of comfort and service in our Junior Suite—where every detail is designed to elevate your stay.',1,2,1,1,NULL,NULL,NULL,NULL,'2025-08-12 22:55:44','2025-08-06 22:52:13','2025-08-12 22:55:44',1),
(6,'106',NULL,NULL,500000.00,'tersedia','room-photos/aaXC6lZGkvc8OyAc5tMO4ZdtLmGDwsTGh786NqzO.jpg','dummy',1,2,1,1,NULL,NULL,NULL,NULL,'2025-08-14 22:08:15','2025-08-14 20:01:42','2025-08-14 22:08:15',1),
(7,'107',NULL,NULL,800000.00,'tersedia',NULL,'dummy',1,2,1,1,NULL,NULL,NULL,NULL,'2025-08-14 22:12:44','2025-08-14 22:08:46','2025-08-14 22:12:44',1),
(8,'108',NULL,NULL,800000.00,'tersedia','room-photos/KxEqkOqzkrPxNn2SOxxQC9X4aHfYmGa8lDHxNkwB.jpg','dummy',1,2,1,1,NULL,NULL,NULL,NULL,'2025-08-14 22:12:48','2025-08-14 22:10:36','2025-08-14 22:12:48',1),
(9,'109',NULL,NULL,800000.00,'tersedia','room-photos/DlJpjMfIXHWnY95h6Q22i7ZVk3WUfbp46QD7bqVK.jpg','dummy',1,2,1,1,NULL,NULL,NULL,NULL,'2025-08-14 22:12:53','2025-08-14 22:11:00','2025-08-14 22:12:53',1),
(10,'110',NULL,NULL,800000.00,'tersedia','room-photos/AjRgWVvXriP2wy0YlxJFWEqt9N5HmwWUaZcTv5jJ.jpg','dummy',1,2,1,1,NULL,NULL,NULL,NULL,'2025-08-21 23:15:37','2025-08-14 22:12:38','2025-08-21 23:15:37',1),
(11,'923',NULL,NULL,800000.00,'terisi','/tmp/php95jtv2tf16b74NglMiL','lkdlfjflkrn',1,2,1,1,NULL,NULL,NULL,NULL,'2025-09-28 20:35:35','2025-08-26 00:46:45','2025-09-28 20:35:35',1),
(12,'958',NULL,NULL,800000.00,'terisi',NULL,'lndfkjrsngkr',1,2,1,1,NULL,NULL,NULL,NULL,'2025-09-08 19:23:34','2025-08-26 00:47:02','2025-09-08 19:23:34',1),
(13,'878',NULL,NULL,700000.00,'tersedia',NULL,'dummy',1,2,1,1,NULL,NULL,NULL,NULL,'2025-09-08 19:23:39','2025-09-08 12:47:59','2025-09-08 19:23:39',1),
(14,'829',NULL,NULL,300000.00,'tersedia',NULL,'dummy',1,2,1,1,NULL,NULL,NULL,NULL,'2025-09-08 19:10:23','2025-09-08 12:54:45','2025-09-08 19:10:23',1),
(15,'484',NULL,NULL,400000.00,'tersedia',NULL,'dummy',1,2,1,1,NULL,NULL,NULL,NULL,'2025-09-08 19:23:43','2025-09-08 19:10:46','2025-09-08 19:23:43',1),
(16,'874',NULL,NULL,300000.00,'terisi',NULL,'dummy',1,2,1,1,NULL,NULL,NULL,NULL,'2025-09-28 20:35:38','2025-09-08 19:15:54','2025-09-28 20:35:38',1),
(17,'758',NULL,NULL,600000.00,'terisi',NULL,'kjsdfj',1,2,1,1,NULL,NULL,NULL,NULL,'2025-09-28 20:35:41','2025-09-09 19:48:39','2025-09-28 20:35:41',1),
(18,'893',NULL,NULL,500000.00,'terisi',NULL,'adhas',1,2,1,1,NULL,NULL,NULL,NULL,'2025-09-28 20:35:43','2025-09-09 19:49:03','2025-09-28 20:35:43',1),
(19,'333',NULL,NULL,900000.00,'terisi',NULL,'wewewe',1,2,1,1,NULL,NULL,NULL,NULL,'2025-09-10 23:05:55','2025-09-10 22:59:47','2025-09-10 23:05:55',NULL),
(20,'999',NULL,NULL,400000.00,'maintenance',NULL,'yayaya',1,2,1,1,NULL,NULL,NULL,NULL,'2025-09-28 20:35:54','2025-09-10 23:06:13','2025-09-28 20:35:54',1),
(21,'111',NULL,NULL,200000.00,'terisi',NULL,'wdw',1,2,1,1,NULL,NULL,NULL,NULL,'2025-09-28 20:35:58','2025-09-10 23:06:34','2025-09-28 20:35:58',1),
(22,'666',NULL,NULL,300000.00,'tersedia',NULL,'dwe',1,2,1,1,NULL,NULL,NULL,NULL,'2025-09-11 18:20:31','2025-09-10 23:09:24','2025-09-11 18:20:31',NULL),
(23,'900',NULL,NULL,300000.00,'tersedia',NULL,'msdf',1,2,1,1,NULL,NULL,NULL,NULL,'2025-09-11 18:20:36','2025-09-11 17:46:28','2025-09-11 18:20:36',NULL),
(24,'289',NULL,NULL,200000.00,'tersedia',NULL,'fwd',1,2,1,1,NULL,NULL,NULL,NULL,'2025-09-28 20:36:02','2025-09-11 18:20:51','2025-09-28 20:36:02',2),
(25,'892',NULL,NULL,200000.00,'terisi',NULL,'asdas',1,2,1,1,NULL,NULL,NULL,NULL,'2025-09-28 20:36:06','2025-09-11 18:55:56','2025-09-28 20:36:06',3),
(26,'122',NULL,NULL,90000.00,'tersedia',NULL,'dummy',1,2,1,1,NULL,NULL,NULL,NULL,'2025-09-28 20:36:09','2025-09-14 19:41:50','2025-09-28 20:36:09',2),
(27,'127',NULL,NULL,80000.00,'terisi',NULL,'guy',1,2,1,1,NULL,NULL,NULL,NULL,'2025-09-28 20:36:17','2025-09-14 19:57:26','2025-09-28 20:36:17',3),
(28,'322',NULL,NULL,20000.00,'tersedia',NULL,'we',1,2,1,1,NULL,NULL,NULL,NULL,'2025-09-28 20:36:19','2025-09-14 20:03:23','2025-09-28 20:36:19',2),
(29,'344',NULL,NULL,700000.00,'tersedia',NULL,'sd',1,2,1,1,NULL,NULL,NULL,NULL,'2025-09-28 20:36:23','2025-09-14 20:05:16','2025-09-28 20:36:23',3),
(30,'665',NULL,NULL,700000.00,'tersedia',NULL,'sd',1,2,1,1,NULL,NULL,NULL,NULL,'2025-09-14 20:17:38','2025-09-14 20:13:29','2025-09-14 20:17:38',3),
(31,'871',NULL,NULL,600000.00,'tersedia','1758170254_Baixar Cartão de quadro de circo gratuitamente.jpeg','dummy',1,2,1,1,NULL,NULL,NULL,NULL,'2025-09-17 21:37:41','2025-09-17 21:09:35','2025-09-17 21:37:41',3),
(32,'433',NULL,NULL,3000000.00,'maintenance','1759809065_Screenshot from 2025-06-30 20-22-42.png','dummy',2,2,1,12,35.00,'Queen',NULL,'\"[\\\"Air Conditioning\\\"]\"','2025-10-06 20:51:32','2025-10-06 20:51:05','2025-10-06 20:51:32',2),
(33,'355',NULL,NULL,2000000.00,'maintenance','1759809996_Screenshot from 2025-06-30 20-22-42.png','dummy',2,2,1,6,35.00,'King',NULL,'\"[\\\"Air Conditioning\\\",\\\"TV\\\",\\\"Balcony\\\"]\"','2025-10-06 21:09:08','2025-10-06 21:06:36','2025-10-06 21:09:08',2),
(34,'788',NULL,NULL,180000.00,'tersedia','1759810115__ (2).jpeg','dummy',2,2,1,4,34.00,'Queen',NULL,'\"[\\\"TV\\\",\\\"Minibar\\\",\\\"Safe\\\",\\\"Sea View\\\"]\"',NULL,'2025-10-06 21:08:35','2025-10-06 21:08:35',4),
(35,'211',NULL,NULL,200000.00,'tersedia','1759810398__ (2).jpeg','dummy',3,3,1,4,35.00,'Twin',NULL,'\"[\\\"Air Conditioning\\\"]\"','2025-10-06 21:13:37','2025-10-06 21:13:18','2025-10-06 21:13:37',5),
(36,'799',NULL,NULL,1000000.00,'maintenance','1759810518__.jpeg','dummy',2,2,1,2,34.00,'Single',NULL,'\"[\\\"Air Conditioning\\\"]\"',NULL,'2025-10-06 21:15:18','2025-10-06 21:15:18',5),
(37,'544',NULL,NULL,200000.00,'dipesan','1759835708__ (2).jpeg','dummy',3,3,1,4,23.00,'Single',NULL,'\"[\\\"Air Conditioning\\\",\\\"TV\\\",\\\"Minibar\\\",\\\"WiFi\\\"]\"','2025-10-07 04:18:35','2025-10-07 04:15:08','2025-10-07 04:18:35',6);
/*!40000 ALTER TABLE `rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipe_kamar`
--

DROP TABLE IF EXISTS `tipe_kamar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipe_kamar` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tipe_kamar` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jumlah_kamar` int(11) NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `kamar_tersedia` int(11) DEFAULT 0,
  `deskripsi` text DEFAULT NULL,
  `kapasitas` int(11) NOT NULL DEFAULT 2,
  `fitur` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipe_kamar`
--

LOCK TABLES `tipe_kamar` WRITE;
/*!40000 ALTER TABLE `tipe_kamar` DISABLE KEYS */;
INSERT INTO `tipe_kamar` VALUES
(1,'deluxe',13,NULL,'2025-09-07 20:10:23','2025-09-07 20:10:23',0,NULL,2,NULL),
(2,'king bad',0,NULL,'2025-09-09 19:23:44','2025-10-06 21:09:08',0,NULL,2,NULL),
(3,'Superior Room',12,NULL,'2025-09-11 18:32:06','2025-09-11 18:32:06',0,NULL,2,NULL),
(4,'Family',1,NULL,'2025-10-06 21:07:23','2025-10-06 21:08:35',1,NULL,2,NULL),
(5,'Suite',7,NULL,'2025-10-06 21:12:16','2025-10-06 21:12:16',0,NULL,2,NULL),
(6,'Standard',5,2000000.00,'2025-10-07 03:39:19','2025-10-07 03:39:19',5,'dummy',9,'[\"Bathtub\",\"Jacuzzi\",\"WiFi\",\"Room Service\"]');
/*!40000 ALTER TABLE `tipe_kamar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_activities`
--

DROP TABLE IF EXISTS `user_activities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_activities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `activity_type` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_activities_user_id_foreign` (`user_id`),
  CONSTRAINT `user_activities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_activities`
--

LOCK TABLES `user_activities` WRITE;
/*!40000 ALTER TABLE `user_activities` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_activities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','resepsionis') NOT NULL DEFAULT 'resepsionis',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `password_plain` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `join_date` date DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `salary` bigint(20) unsigned DEFAULT NULL,
  `notes` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(1,'yaya','yaya@gmail.com',NULL,'$2y$12$9nHqhFJjoUrvsiBqASLy5eW.wQ/k.rJ6FMcWaIsn7UH6UmrcR8j6S','resepsionis',NULL,'2025-08-06 21:37:34','2025-09-14 19:38:57','12345678','1755843091_dummy man.jpeg','083117711364','dummy',NULL,NULL,NULL,NULL,NULL,'active',NULL,NULL),
(2,'Yani','sriyani@gmail.com',NULL,'$2y$12$23kn.TMSUfiSjyFt31/ure/rAvcCT8Bf7yDAN5Xkh/n13eDoEtMLS','admin',NULL,'2025-08-06 21:45:07','2025-08-21 23:13:47','12345678','1755843227_Girl icon.jpeg','08123456789','mriyan',NULL,NULL,NULL,NULL,NULL,'active',NULL,NULL),
(3,'nora','naura123@gmail.com',NULL,'$2y$12$Ji2/PgBBiU5HqdMd3hn8XORjm.Awhdz9ZjoaEoZbDbsvzNBVHWw8S','resepsionis',NULL,'2025-08-13 23:49:02','2025-08-21 23:11:46','12345678','1755843106_dummy man.jpeg','08123456789','dummy',NULL,NULL,NULL,NULL,NULL,'active',NULL,NULL),
(4,'mandaa','manda123@gmail.com',NULL,'$2y$12$ClIsDRX7s.5lKIuKAjHpceiJn7YystbJENDTc0vnGsfVJJ4XkX5PS','resepsionis',NULL,'2025-08-14 20:14:52','2025-08-21 23:11:57','12345678','1755843117_dummy man.jpeg','008438754','dummy',NULL,NULL,NULL,NULL,NULL,'active',NULL,NULL),
(5,'disa','disa@gmail.com',NULL,'$2y$12$OH8nFSr1pyEbNAW3xc1OYu7SX6mTdDDjgp8e6EyszXFncMlqJbta6','resepsionis',NULL,'2025-08-26 21:26:55','2025-08-26 21:26:55','12345678','1756268815_dummy man.jpeg','084357834234','dummy',NULL,NULL,NULL,NULL,NULL,'active',NULL,NULL),
(6,'admin','admin@gmail.com',NULL,'$2y$12$MNW2kF9z5tlIC248kRNAsusxR6g.gtv8Tk9jfCKYfBfJ.r2KYHyjW','resepsionis',NULL,'2025-08-26 21:27:58','2025-08-26 21:27:58','yani010407','1756268878_Girl icon.jpeg','08375673423','dummy',NULL,NULL,NULL,NULL,NULL,'active',NULL,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-11-11 10:43:24

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
) ENGINE=InnoDB AUTO_INCREMENT=263 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
(262,2,'access','Admin mengakses dashboard','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','admin',NULL,NULL,NULL,NULL,'2025-08-20 23:19:20','2025-08-20 23:19:20');
/*!40000 ALTER TABLE `activity_logs` ENABLE KEYS */;
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
  `room_id` bigint(20) unsigned NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `status` enum('booked','checked_in','checked_out','canceled','paid') NOT NULL DEFAULT 'booked',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `total_price` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `bookings_user_id_foreign` (`user_id`),
  KEY `bookings_guest_id_foreign` (`guest_id`),
  KEY `bookings_room_id_foreign` (`room_id`),
  CONSTRAINT `bookings_guest_id_foreign` FOREIGN KEY (`guest_id`) REFERENCES `guests` (`id`) ON DELETE CASCADE,
  CONSTRAINT `bookings_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
  CONSTRAINT `bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bookings`
--

LOCK TABLES `bookings` WRITE;
/*!40000 ALTER TABLE `bookings` DISABLE KEYS */;
INSERT INTO `bookings` VALUES
(22,3,1,1,'2025-08-14','2025-08-18','paid','2025-08-14 06:28:44','2025-08-14 06:57:50',0),
(23,3,2,2,'2025-08-16','2025-08-18','paid','2025-08-14 06:56:02','2025-08-14 07:00:41',0),
(24,3,3,3,'2025-08-14','2025-08-19','checked_out','2025-08-14 06:56:21','2025-08-14 06:56:21',0),
(26,3,4,3,'2025-08-14','2025-08-19','paid','2025-08-14 06:57:08','2025-08-14 07:00:54',0),
(27,3,5,4,'2025-08-20','2025-08-27','paid','2025-08-14 06:57:24','2025-08-14 07:01:21',0),
(29,3,11,10,'2025-08-19','2025-08-22','paid','2025-08-18 19:22:21','2025-08-18 20:49:32',0);
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
-- Table structure for table `guests`
--

DROP TABLE IF EXISTS `guests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `guests` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `identity_number` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `guests`
--

LOCK TABLES `guests` WRITE;
/*!40000 ALTER TABLE `guests` DISABLE KEYS */;
INSERT INTO `guests` VALUES
(1,'Dandi Pratamaa','0812-3456-7890','3174091203980001','2025-08-06 22:57:18','2025-08-14 20:38:12'),
(2,'Siti Nurhaliza','0821-9876-5432','3271056704920002','2025-08-06 22:57:46','2025-08-06 22:57:46'),
(3,'Budi Santoso','0857-2233-4455','3301042108900003','2025-08-06 22:58:40','2025-08-06 22:58:40'),
(4,'Rina Maharani','0813-4455-6677','3205061803950004','2025-08-06 22:59:10','2025-08-06 22:59:10'),
(5,'Fajar Ramadhan','0896-1122-3344','3173063001010005','2025-08-06 22:59:43','2025-08-06 22:59:43'),
(7,'naura','098737374','327458433','2025-08-14 20:12:12','2025-08-14 20:12:12'),
(8,'manda','0434786733','74385745','2025-08-14 20:14:10','2025-08-14 20:14:10'),
(10,'yanii','04957355346','09655448','2025-08-18 19:21:36','2025-08-18 19:21:50'),
(11,'narin prandari','0857465363737','5857478449','2025-08-18 19:22:21','2025-08-18 19:22:21');
/*!40000 ALTER TABLE `guests` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
(6,'2025_07_21_072502_create_bookings_table',1),
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
(18,'2025_08_14_063129_add_address_phone_to_users_table',6);
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
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES
(28,22,304000.00,'2025-08-14 06:57:00','cash',304000.00,'2025-08-14 06:57:50','2025-08-14 06:57:50'),
(31,27,500000.00,'2025-08-14 07:00:00','cash',490000.00,'2025-08-14 07:01:21','2025-08-14 07:01:21'),
(32,23,130000.00,'2025-08-18 19:22:00','cash',120000.00,'2025-08-18 19:23:15','2025-08-18 19:23:15'),
(33,26,400000.00,'2025-08-18 19:29:00','cash',390000.00,'2025-08-18 19:29:28','2025-08-18 19:29:28'),
(34,29,2400000.00,'2025-08-18 20:49:00','transfer',2400000.00,'2025-08-18 20:49:32','2025-08-18 20:49:32');
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
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
  `type` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` enum('tersedia','terisi','maintenance','dipesan') NOT NULL DEFAULT 'tersedia',
  `photo` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `capacity` int(11) NOT NULL DEFAULT 1,
  `floor` int(11) DEFAULT NULL,
  `facilities` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`facilities`)),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rooms_number_unique` (`number`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rooms`
--

LOCK TABLES `rooms` WRITE;
/*!40000 ALTER TABLE `rooms` DISABLE KEYS */;
INSERT INTO `rooms` VALUES
(1,'101','Deluxe',76000.00,'tersedia','room-photos/WRawlDlMNd8zildb5UKNyE9TooDAHs4bOxJOcWTk.png','Deluxe Room\r\nExperience the perfect blend of comfort and sophistication in our Deluxe Room, thoughtfully designed for discerning guests seeking refined accommodation. Whether for business or leisure, this room offers exceptional amenities and elegant ambiance to ensure a truly memorable stay.\r\n\r\nRoom Features:\r\n-Premium Queen/King-sized bed with luxury linen\r\n-Individually controlled air-conditioning\r\n-Ensuite bathroom with hot shower and exclusive toiletries\r\n-Flat-screen TV with international cable channels\r\n-Complimentary high-speed Wi-Fi\r\n-Functional work desk with ambient lighting\r\n-Daily complimentary bottled water & coffee/tea making facilities\r\n-Wardrobe, digital safe, and large mirror\r\n-Private balcony (available in selected rooms)\r\n-Room Size: ±28–32 m²\r\n-Capacity: Up to 2 adults (extra bed available upon request)\r\n-Unwind in style and enjoy warm hospitality with every stay.',1,NULL,NULL,NULL,'2025-08-06 22:48:41','2025-08-11 00:05:10'),
(2,'102','Superior Room',60000.00,'maintenance','room-photos/oP5VWzcfk0bL1nCMF9fYjWgw0TFPJPxvvwmnmWv4.jpg','Superior Room\r\nDiscover understated elegance and modern convenience in our Superior Room, designed to provide a relaxing retreat for both business and leisure travelers. With stylish furnishings and thoughtful amenities, this room promises comfort and practicality for a delightful stay.\r\n\r\nRoom Features:\r\n-Comfortable Queen or Twin-sized bed with soft linen\r\n-Individually controlled air-conditioning\r\n-Ensuite bathroom with hot shower and essential toiletries\r\n-Flat-screen TV with local and international channels\r\n-Complimentary high-speed Wi-Fi\r\n-Functional work desk and reading lamp\r\n-Daily complimentary bottled water & coffee/tea making facilities\r\n-Wardrobe, in-room safe, and vanity mirror\r\n-Private balcony (available in selected rooms)\r\n-Room Size: ±24–28 m²\r\n-Capacity: Up to 2 adults\r\n-Enjoy a serene atmosphere and warm hospitality in the heart of your destination.',1,NULL,NULL,NULL,'2025-08-06 22:49:30','2025-08-07 19:11:15'),
(3,'103','Standard Room',78000.00,'dipesan','room-photos/yITKNntBiAeZJljeCyLktfh7dPJuTk3IkON6znOD.jpg','Standard Room\r\nSimplicity meets comfort in our Standard Room, offering a cozy and practical space for travelers seeking excellent value without compromising essential amenities. Ideal for solo guests or couples, this room provides a restful environment for a pleasant and convenient stay.\r\n\r\nRoom Features:\r\n-Comfortable Queen or Twin-sized bed with fresh linen\r\n-Air-conditioning with individual temperature control\r\n-Private bathroom with hot shower and basic toiletries\r\n-Flat-screen TV with local channels\r\n-Complimentary Wi-Fi access\r\n-Compact work desk or bedside table\r\n-Daily complimentary bottled water\r\n-Wardrobe or open hanging rack\r\n-Room Size: ±18–22 m²\r\n-Capacity: Up to 2 adults\r\n-A smart choice for budget-conscious guests looking for clean, comfortable, and well-located accommodation.',1,NULL,NULL,NULL,'2025-08-06 22:50:32','2025-08-07 05:21:09'),
(4,'104','Executive Room',70000.00,'dipesan','room-photos/NZ4zDz5Dz5UTFEhh8q76yEOfupWdAYVpIL71TUKg.jpg','Executive Room\r\nDesigned for business travelers and guests who appreciate extra space and upgraded amenities, our Executive Room combines modern elegance with enhanced comfort. Featuring a spacious layout and thoughtful touches, this room is ideal for extended stays or working on the go.\r\n\r\nRoom Features:\r\n-Premium King or Twin-sized bed with high-quality linen\r\n-Spacious seating area for added comfort\r\n-Individually controlled air-conditioning\r\n-Ensuite bathroom with walk-in shower and deluxe toiletries\r\n-43\" Flat-screen Smart TV with international cable channels\r\n-Complimentary high-speed Wi-Fi\r\n-Executive work desk with ergonomic chair and ambient lighting\r\n-Daily complimentary bottled water, coffee & tea-making facilities\r\n-Mini refrigerator and in-room digital safe\r\n-Full-length mirror and wardrobe with extra storage\r\n-Privatebalcony with city or garden view (available in selectedrooms)\r\n-Room Size: ±32–38 m²\r\n-Capacity: Up to 2 adults (extra bed available upon request)\r\n-Experience elevated hospitality with extra space, exclusive comfort, and refined ambiance in every stay.',1,NULL,NULL,NULL,'2025-08-06 22:51:30','2025-08-07 05:21:32'),
(5,'105','Junior Suite',80000.00,'dipesan','room-photos/8Dj5ySk3KqVZbnimFcPSCf09T7hbZdCwv2BT33Hg.jpg','Junior Suite\r\nIndulge in a refined stay in our Junior Suite, where sophistication meets spacious comfort. Perfect for couples or executives, this elegantly appointed suite offers a seamless blend of relaxation and functionality in a stylish open-concept layout.\r\n\r\nRoom Features:\r\n-Luxurious King-sized bed with premium linen and plush pillows\r\n-Separate seating or lounge area for added privacy\r\n-Individually controlled air-conditioning\r\n-Spacious ensuite bathroom with walk-in shower and deluxe amenities\r\n-43\" or larger Flat-screen Smart TV with international channels-\r\n-Complimentary high-speed Wi-Fi\r\n-Executive writing desk with comfortable chair\r\n-Daily complimentary bottled water, coffee & tea-making facilities\r\n-Mini bar and in-room safe\r\n-Large wardrobe with full-length mirror\r\n-Private balcony or large window with scenic view (available in selected suites)\r\n-Room Size: ±40–45 m²\r\n-Capacity: Up to 2 adults (ideal for longer or luxury stays)\r\n-Relax in style and experience a higher level of comfort and service in our Junior Suite—where every detail is designed to elevate your stay.',1,NULL,NULL,'2025-08-12 22:55:44','2025-08-06 22:52:13','2025-08-12 22:55:44'),
(6,'106','kamar baru',500000.00,'tersedia','room-photos/aaXC6lZGkvc8OyAc5tMO4ZdtLmGDwsTGh786NqzO.jpg','dummy',1,NULL,NULL,'2025-08-14 22:08:15','2025-08-14 20:01:42','2025-08-14 22:08:15'),
(7,'107','baru',800000.00,'tersedia',NULL,'dummy',1,NULL,NULL,'2025-08-14 22:12:44','2025-08-14 22:08:46','2025-08-14 22:12:44'),
(8,'108','baru',800000.00,'tersedia','room-photos/KxEqkOqzkrPxNn2SOxxQC9X4aHfYmGa8lDHxNkwB.jpg','dummy',1,NULL,NULL,'2025-08-14 22:12:48','2025-08-14 22:10:36','2025-08-14 22:12:48'),
(9,'109','baru',800000.00,'tersedia','room-photos/DlJpjMfIXHWnY95h6Q22i7ZVk3WUfbp46QD7bqVK.jpg','dummy',1,NULL,NULL,'2025-08-14 22:12:53','2025-08-14 22:11:00','2025-08-14 22:12:53'),
(10,'110','baru ada',800000.00,'tersedia','room-photos/AjRgWVvXriP2wy0YlxJFWEqt9N5HmwWUaZcTv5jJ.jpg','dummy',1,NULL,NULL,NULL,'2025-08-14 22:12:38','2025-08-18 19:16:57');
/*!40000 ALTER TABLE `rooms` ENABLE KEYS */;
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
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(1,'Yaya','yaya@gmail.com',NULL,'$2y$12$0cFWpl4OSsJb0t/4Q7o0ZublqM3aUHB8whVM8Mk7bOGmDzWUesrdO','resepsionis',NULL,'2025-08-06 21:37:34','2025-08-14 00:30:14','123456','sos1i2z79yHJ9GivcvNxlf8UQB2wfbcQMwBD1bRi.jpg','083117711364','dummy'),
(2,'Yani','sriyani@gmail.com',NULL,'$2y$12$23kn.TMSUfiSjyFt31/ure/rAvcCT8Bf7yDAN5Xkh/n13eDoEtMLS','admin',NULL,'2025-08-06 21:45:07','2025-08-20 21:53:03','12345678','profile_photos/88CQQHEZrIDaDFUtIIaQbHQzb3sYinLjwXdw2kf9.png','08123456789','mriyan'),
(3,'nora','naura123@gmail.com',NULL,'$2y$12$Uimn2892Y9Q8sJGZzda2DOFWxhu2ZlXriJwTQ6EIO1MOry8h8nl32','resepsionis',NULL,'2025-08-13 23:49:02','2025-08-20 21:38:12','12345678','b78dknqGvS8zNvqr7LoemLtB2bRQCmb9XJqsdGb4.png','08123456789','dummy'),
(4,'mandaa','manda123@gmail.com',NULL,'$2y$12$ClIsDRX7s.5lKIuKAjHpceiJn7YystbJENDTc0vnGsfVJJ4XkX5PS','resepsionis',NULL,'2025-08-14 20:14:52','2025-08-20 22:04:27','12345678','JlDZYbjZhjDmO1uq0Pz8hwqk8JpzAzvULOsiSgyr.png','008438754','dummy');
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

-- Dump completed on 2025-08-21 13:24:55

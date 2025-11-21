-- MySQL dump 10.13  Distrib 8.0.43, for Linux (x86_64)
--
-- Host: localhost    Database: code_test
-- ------------------------------------------------------
-- Server version	8.0.43-0ubuntu0.22.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('laravel-cache-analytics_dashboard_2025-10-22 20:19:16_2025-11-21 20:19:16','a:6:{s:11:\"total_sales\";s:8:\"74233.56\";s:13:\"monthly_chart\";O:29:\"Illuminate\\Support\\Collection\":2:{s:8:\"\0*\0items\";a:1:{i:0;a:4:{s:5:\"month\";s:7:\"2025-11\";s:11:\"total_sales\";d:74233.56;s:11:\"order_count\";i:5;s:15:\"avg_order_value\";d:14846.712;}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:15:\"daily_breakdown\";O:29:\"Illuminate\\Support\\Collection\":2:{s:8:\"\0*\0items\";a:1:{i:0;a:5:{s:4:\"date\";s:10:\"2025-11-21\";s:11:\"total_sales\";d:74233.56;s:11:\"order_count\";i:5;s:9:\"total_tax\";d:3711.68;s:14:\"total_discount\";d:6797.46;}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:12:\"top_products\";O:29:\"Illuminate\\Support\\Collection\":2:{s:8:\"\0*\0items\";a:10:{i:0;a:5:{s:10:\"product_id\";i:6;s:12:\"product_name\";s:15:\"et deserunt qui\";s:14:\"total_quantity\";s:2:\"18\";s:13:\"total_revenue\";d:13100.04;s:11:\"order_count\";i:2;}i:1;a:5:{s:10:\"product_id\";i:2;s:12:\"product_name\";s:29:\"quo exercitationem blanditiis\";s:14:\"total_quantity\";s:2:\"16\";s:13:\"total_revenue\";d:11644.48;s:11:\"order_count\";i:2;}i:2;a:5:{s:10:\"product_id\";i:18;s:12:\"product_name\";s:22:\"commodi doloremque aut\";s:14:\"total_quantity\";s:2:\"16\";s:13:\"total_revenue\";d:11644.48;s:11:\"order_count\";i:2;}i:3;a:5:{s:10:\"product_id\";i:10;s:12:\"product_name\";s:19:\"distinctio aut enim\";s:14:\"total_quantity\";s:2:\"14\";s:13:\"total_revenue\";d:10188.92;s:11:\"order_count\";i:2;}i:4;a:5:{s:10:\"product_id\";i:12;s:12:\"product_name\";s:19:\"dolores error illum\";s:14:\"total_quantity\";s:2:\"11\";s:13:\"total_revenue\";d:8005.58;s:11:\"order_count\";i:2;}i:5;a:5:{s:10:\"product_id\";i:1;s:12:\"product_name\";s:20:\"possimus porro atque\";s:14:\"total_quantity\";s:1:\"8\";s:13:\"total_revenue\";d:5822.24;s:11:\"order_count\";i:1;}i:6;a:5:{s:10:\"product_id\";i:11;s:12:\"product_name\";s:27:\"hic accusantium perferendis\";s:14:\"total_quantity\";s:1:\"7\";s:13:\"total_revenue\";d:5094.46;s:11:\"order_count\";i:1;}i:7;a:5:{s:10:\"product_id\";i:19;s:12:\"product_name\";s:32:\"consequatur quisquam consequatur\";s:14:\"total_quantity\";s:1:\"6\";s:13:\"total_revenue\";d:4366.68;s:11:\"order_count\";i:1;}i:8;a:5:{s:10:\"product_id\";i:4;s:12:\"product_name\";s:16:\"reiciendis ut et\";s:14:\"total_quantity\";s:1:\"3\";s:13:\"total_revenue\";d:2183.34;s:11:\"order_count\";i:1;}i:9;a:5:{s:10:\"product_id\";i:17;s:12:\"product_name\";s:15:\"sint placeat in\";s:14:\"total_quantity\";s:1:\"3\";s:13:\"total_revenue\";d:2183.34;s:11:\"order_count\";i:1;}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:7:\"summary\";a:5:{s:12:\"total_orders\";i:5;s:15:\"avg_order_value\";d:14846.712;s:13:\"total_revenue\";d:74233.56;s:19:\"total_tax_collected\";d:3711.68;s:21:\"total_discounts_given\";d:6797.46;}s:19:\"transaction_summary\";a:7:{s:18:\"total_transactions\";i:7;s:22:\"completed_transactions\";i:6;s:19:\"failed_transactions\";i:0;s:14:\"total_payments\";d:74233.56;s:13:\"total_refunds\";d:0;s:12:\"success_rate\";d:85.71;s:15:\"payment_methods\";O:29:\"Illuminate\\Support\\Collection\":2:{s:8:\"\0*\0items\";a:3:{i:0;a:3:{s:6:\"method\";s:4:\"cash\";s:5:\"count\";i:4;s:5:\"total\";d:35661.22;}i:1;a:3:{s:6:\"method\";s:11:\"credit_card\";s:5:\"count\";i:1;s:5:\"total\";d:17466.72;}i:2;a:3:{s:6:\"method\";s:6:\"paypal\";s:5:\"count\";i:1;s:5:\"total\";d:21105.62;}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}}',1763759956);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
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
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
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
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
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
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
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
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_11_21_092237_create_products_table',1),(5,'2025_11_21_092325_create_orders_table',1),(6,'2025_11_21_092346_create_order_items_table',1),(7,'2025_11_21_094346_create_personal_access_tokens_table',1),(8,'2025_11_21_153826_create_transactions_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `quantity` int NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_product_id_foreign` (`product_id`),
  KEY `order_items_order_id_product_id_index` (`order_id`,`product_id`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (1,1,14,1,727.78,727.78,'2025-11-21 13:45:52','2025-11-21 13:45:52'),(2,1,6,3,727.78,2183.34,'2025-11-21 13:45:52','2025-11-21 13:45:52'),(3,2,6,10,727.78,7277.80,'2025-11-21 13:45:52','2025-11-21 13:45:52'),(4,2,17,3,727.78,2183.34,'2025-11-21 13:45:52','2025-11-21 13:45:52'),(5,2,2,6,727.78,4366.68,'2025-11-21 13:45:52','2025-11-21 13:45:52'),(6,3,11,7,727.78,5094.46,'2025-11-21 13:45:52','2025-11-21 13:45:52'),(7,3,2,10,727.78,7277.80,'2025-11-21 13:45:52','2025-11-21 13:45:52'),(8,3,18,9,727.78,6550.02,'2025-11-21 13:45:52','2025-11-21 13:45:52'),(9,4,10,7,727.78,5094.46,'2025-11-21 13:45:52','2025-11-21 13:45:52'),(10,4,4,3,727.78,2183.34,'2025-11-21 13:45:52','2025-11-21 13:45:52'),(11,4,18,7,727.78,5094.46,'2025-11-21 13:45:52','2025-11-21 13:45:52'),(12,4,12,7,727.78,5094.46,'2025-11-21 13:45:52','2025-11-21 13:45:52'),(13,5,12,4,727.78,2911.12,'2025-11-21 13:45:52','2025-11-21 13:45:52'),(14,6,1,8,727.78,5822.24,'2025-11-21 13:45:52','2025-11-21 13:45:52'),(15,6,6,8,727.78,5822.24,'2025-11-21 13:45:52','2025-11-21 13:45:52'),(16,6,19,6,727.78,4366.68,'2025-11-21 13:45:52','2025-11-21 13:45:52'),(17,6,10,7,727.78,5094.46,'2025-11-21 13:45:52','2025-11-21 13:45:52');
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `order_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `tax_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `discount_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` enum('pending','processing','completed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_order_number_unique` (`order_number`),
  KEY `orders_user_id_created_at_index` (`user_id`,`created_at`),
  KEY `orders_status_index` (`status`),
  KEY `orders_order_number_index` (`order_number`),
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,1,'ORD-76BD74E3-BE76-4E82-A55C-BA0D44BAED86',2911.12,145.56,0.00,'processing','2025-11-07 13:45:52','2025-11-21 13:45:52','2025-11-21 13:45:53',NULL),(2,2,'ORD-57C16082-1B8B-4405-BEA9-DBC8D7E84028',13827.82,691.39,1382.78,'completed','2025-11-21 13:45:53','2025-11-21 13:45:52','2025-11-21 13:45:53',NULL),(3,3,'ORD-AB6E370E-4FF5-4695-AE03-5915DFA7ACBB',18922.28,946.11,2270.67,'completed','2025-11-21 13:45:53','2025-11-21 13:45:52','2025-11-21 13:45:53',NULL),(4,4,'ORD-5241B5D5-E99B-4D31-BDD9-4857FCB80B8B',17466.72,873.34,3144.01,'completed','2025-11-21 13:45:53','2025-11-21 13:45:52','2025-11-21 13:45:53',NULL),(5,5,'ORD-B22142D4-B158-40DC-ABB9-9006EE23CD0A',2911.12,145.56,0.00,'completed','2025-11-21 13:45:53','2025-11-21 13:45:52','2025-11-21 13:45:53',NULL),(6,6,'ORD-18152351-516B-4DED-B918-F578F916594F',21105.62,1055.28,0.00,'completed','2025-11-21 13:45:53','2025-11-21 13:45:52','2025-11-21 13:45:53',NULL);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  KEY `personal_access_tokens_expires_at_index` (`expires_at`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
INSERT INTO `personal_access_tokens` VALUES (1,'App\\Models\\User',1,'auth_token','5587c51e55714adbd2885a42c3e780e11e9e15f65ca6ed601dbb68a17fda1018','[\"*\"]','2025-11-21 13:49:16',NULL,'2025-11-21 13:48:58','2025-11-21 13:49:16');
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(10,2) NOT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `products_is_active_index` (`is_active`),
  KEY `products_created_at_index` (`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'possimus porro atque','Consequuntur in dicta eos non qui aut sed necessitatibus. Nostrum quae illum natus cum. Voluptate numquam recusandae fugiat ipsum maxime. Nemo ab doloribus eaque repellat expedita animi.',727.78,95,1,'2025-11-21 13:45:51','2025-11-21 13:45:51',NULL),(2,'quo exercitationem blanditiis','Consequatur dicta vel iure ut autem. Sint sunt enim consequuntur ad sed aut qui. Doloribus fugit fugit veniam enim iste. Autem labore itaque cum iure aperiam delectus omnis.',727.78,95,1,'2025-11-21 13:45:51','2025-11-21 13:45:51',NULL),(3,'saepe eum accusantium','Corporis culpa nobis quia sint eius. Est dolorem ea velit enim maiores quam doloremque. Qui sed aut consequatur voluptas consequatur minima dolores.',727.78,95,0,'2025-11-21 13:45:51','2025-11-21 13:45:51',NULL),(4,'reiciendis ut et','Tempore modi aperiam et minima occaecati quam a. Sint et fuga repudiandae odit repellat iusto. Voluptatem adipisci exercitationem consequatur. Ea quis est aut molestiae.',727.78,95,0,'2025-11-21 13:45:51','2025-11-21 13:45:51',NULL),(5,'dolor error velit','Perferendis occaecati consequuntur architecto rem eos illo. Est qui voluptatem odio ullam autem vitae veritatis. Facilis vel repudiandae rerum veniam neque doloribus.',727.78,95,1,'2025-11-21 13:45:51','2025-11-21 13:45:51',NULL),(6,'et deserunt qui','Ea magni tempora sequi facilis pariatur. Sapiente ea aut inventore incidunt est ratione. Ea ut aliquid excepturi quia numquam eligendi. Dolor vel iusto eaque ratione sint.',727.78,95,1,'2025-11-21 13:45:51','2025-11-21 13:45:51',NULL),(7,'nulla perferendis natus','Expedita vel molestiae earum. Autem ut illum ea quia veniam ut aspernatur. Enim et est qui. Sunt molestiae sapiente repudiandae repellendus nulla maxime quo.',727.78,95,1,'2025-11-21 13:45:51','2025-11-21 13:45:51',NULL),(8,'id voluptate dolores','Velit velit accusamus commodi et alias. Beatae repellendus quis repellendus harum distinctio. Beatae voluptate quibusdam commodi dolores laudantium voluptatem.',727.78,95,1,'2025-11-21 13:45:51','2025-11-21 13:45:51',NULL),(9,'unde nam vero','Omnis eligendi consectetur non. Voluptatem dolor qui voluptatibus et quia excepturi odit. Soluta ea quidem aut culpa odio animi enim.',727.78,95,1,'2025-11-21 13:45:52','2025-11-21 13:45:52',NULL),(10,'distinctio aut enim','Aut velit saepe voluptatem accusamus ratione dolorum et. Enim quas eaque sit perspiciatis dolor. Voluptatem soluta enim qui quo pariatur et.',727.78,95,1,'2025-11-21 13:45:52','2025-11-21 13:45:52',NULL),(11,'hic accusantium perferendis','Suscipit quod soluta veritatis. Deserunt tenetur laborum quisquam molestiae iure doloremque debitis sint. Ut nisi ipsam eveniet consequatur omnis quia ea error.',727.78,95,1,'2025-11-21 13:45:52','2025-11-21 13:45:52',NULL),(12,'dolores error illum','Neque ullam tempore sit. Ipsum provident quis necessitatibus dolorum ut.',727.78,95,1,'2025-11-21 13:45:52','2025-11-21 13:45:52',NULL),(13,'voluptas nostrum praesentium','Quaerat qui ut delectus aut et. Optio iste voluptas illum quo deserunt pariatur beatae. Cum animi provident voluptate quis aut iure. Nulla officiis quia quisquam odit maxime.',727.78,95,1,'2025-11-21 13:45:52','2025-11-21 13:45:52',NULL),(14,'inventore voluptatem consectetur','Adipisci suscipit recusandae quis. Quae nihil non eum illum blanditiis. Minima voluptas vitae ea minus. Ut praesentium vel totam eum qui quo.',727.78,95,1,'2025-11-21 13:45:52','2025-11-21 13:45:52',NULL),(15,'tempore voluptas sit','Ipsa mollitia quo reiciendis repellendus eos nisi qui maxime. Natus non accusantium culpa possimus. Voluptatem nesciunt deserunt qui magnam vel aperiam et. Vitae quasi ipsam veniam sit nihil aut sed.',727.78,95,1,'2025-11-21 13:45:52','2025-11-21 13:45:52',NULL),(16,'impedit est quia','Ut neque nihil voluptatibus quos necessitatibus. Sed officia mollitia quibusdam totam. Nihil et tempore nobis ex. Eaque culpa explicabo non cupiditate architecto facere fugiat.',727.78,95,1,'2025-11-21 13:45:52','2025-11-21 13:45:52',NULL),(17,'sint placeat in','Accusantium quisquam sunt qui sequi culpa rem. Animi qui soluta est a. Corporis tenetur a incidunt maiores molestias consequatur quas.',727.78,95,1,'2025-11-21 13:45:52','2025-11-21 13:45:52',NULL),(18,'commodi doloremque aut','Mollitia nisi aliquid velit et ea qui. Omnis quibusdam omnis quas totam. Officiis dolor illum pariatur ipsum sit est voluptatum. Autem non et autem hic et reprehenderit. Iste saepe autem asperiores est asperiores iure temporibus distinctio.',727.78,95,1,'2025-11-21 13:45:52','2025-11-21 13:45:52',NULL),(19,'consequatur quisquam consequatur','Molestiae illo quis rerum ut non eum placeat placeat. Sunt soluta aut quia hic. Voluptatibus architecto quis voluptatum exercitationem fugiat labore.',727.78,95,1,'2025-11-21 13:45:52','2025-11-21 13:45:52',NULL),(20,'enim minima consequatur','Libero qui natus cumque et enim. In dicta sed rerum impedit.',727.78,95,1,'2025-11-21 13:45:52','2025-11-21 13:45:52',NULL);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transactions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `transaction_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `type` enum('payment','refund','adjustment') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'payment',
  `payment_method` enum('credit_card','debit_card','paypal','bank_transfer','cash') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','processing','completed','failed','cancelled','refunded') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment_gateway` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gateway_transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gateway_response` text COLLATE utf8mb4_unicode_ci,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `processed_at` timestamp NULL DEFAULT NULL,
  `failed_at` timestamp NULL DEFAULT NULL,
  `refunded_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `transactions_transaction_number_unique` (`transaction_number`),
  KEY `transactions_order_id_status_index` (`order_id`,`status`),
  KEY `transactions_user_id_created_at_index` (`user_id`,`created_at`),
  KEY `transactions_transaction_number_index` (`transaction_number`),
  KEY `transactions_status_type_index` (`status`,`type`),
  KEY `transactions_created_at_index` (`created_at`),
  CONSTRAINT `transactions_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
INSERT INTO `transactions` VALUES (1,1,1,'TXN-6920C87908477',2911.12,'payment','paypal','pending',NULL,NULL,NULL,'Payment authorization pending',NULL,NULL,NULL,'2025-11-21 13:45:52','2025-11-21 13:45:52',NULL),(2,2,2,'TXN-6920C879113CA',13827.82,'payment','cash','completed',NULL,NULL,'{\"status\":\"success\",\"message\":\"Payment processed successfully\",\"card_last4\":null}','Full payment for order ORD-57C16082-1B8B-4405-BEA9-DBC8D7E84028','2025-11-21 13:45:52',NULL,NULL,'2025-11-21 13:45:52','2025-11-21 13:45:53',NULL),(3,3,3,'TXN-6920C8791E443',18922.28,'payment','cash','completed',NULL,NULL,'{\"status\":\"success\",\"message\":\"Payment processed successfully\",\"card_last4\":null}','Full payment for order ORD-AB6E370E-4FF5-4695-AE03-5915DFA7ACBB','2025-11-21 13:45:53',NULL,NULL,'2025-11-21 13:45:52','2025-11-21 13:45:53',NULL),(4,4,4,'TXN-6920C8792B8B8',17466.72,'payment','credit_card','completed','stripe','ch_6920c8792b8d4','{\"status\":\"success\",\"message\":\"Payment processed successfully\",\"card_last4\":\"9561\"}','Full payment for order ORD-5241B5D5-E99B-4D31-BDD9-4857FCB80B8B','2025-11-21 13:45:52',NULL,NULL,'2025-11-21 13:45:52','2025-11-21 13:45:52',NULL),(5,5,5,'TXN-6920C8793829D',1222.67,'payment','cash','completed',NULL,NULL,'{\"status\":\"success\",\"message\":\"Partial payment processed\"}','Partial payment 1/2 for order ORD-B22142D4-B158-40DC-ABB9-9006EE23CD0A','2025-11-21 13:45:53',NULL,NULL,'2025-11-21 13:45:53','2025-11-21 13:45:53',NULL),(6,5,5,'TXN-6920C879413F1',1688.45,'payment','cash','completed',NULL,NULL,'{\"status\":\"success\",\"message\":\"Partial payment processed\"}','Partial payment 2/2 for order ORD-B22142D4-B158-40DC-ABB9-9006EE23CD0A','2025-11-21 13:45:52',NULL,NULL,'2025-11-21 13:45:52','2025-11-21 13:45:52',NULL),(7,6,6,'TXN-6920C8794E427',21105.62,'payment','paypal','completed','stripe','ch_6920c8794e460','{\"status\":\"success\",\"message\":\"Payment processed successfully\",\"card_last4\":null}','Full payment for order ORD-18152351-516B-4DED-B918-F578F916594F','2025-11-21 13:45:52',NULL,NULL,'2025-11-21 13:45:52','2025-11-21 13:45:52',NULL);
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Test User','test@example.com','2025-11-21 13:45:51','$2y$12$xZcxLD3LAhqrgX0v8d/J7uY0LtLxZo1Uswkh8.M8gRIJPGkFDAS1O','U47Oj4jcxV','2025-11-21 13:45:51','2025-11-21 13:45:51'),(2,'Kian Dietrich','gino.reynolds@example.org','2025-11-21 13:45:51','$2y$12$Z4x1pHInzzZzmKCPizE/1OhEiWlYuj/ts7Y.wrUs2Ch3orJbUjZ/G','8ykDpDalbs','2025-11-21 13:45:51','2025-11-21 13:45:51'),(3,'Nelle Wintheiser','alessandra57@example.net','2025-11-21 13:45:51','$2y$12$Z4x1pHInzzZzmKCPizE/1OhEiWlYuj/ts7Y.wrUs2Ch3orJbUjZ/G','457zBLnRyd','2025-11-21 13:45:51','2025-11-21 13:45:51'),(4,'Miss Maureen Casper DVM','bdouglas@example.net','2025-11-21 13:45:51','$2y$12$Z4x1pHInzzZzmKCPizE/1OhEiWlYuj/ts7Y.wrUs2Ch3orJbUjZ/G','ojAmIRqyGM','2025-11-21 13:45:51','2025-11-21 13:45:51'),(5,'Dr. Antonio Sawayn IV','abergstrom@example.net','2025-11-21 13:45:51','$2y$12$Z4x1pHInzzZzmKCPizE/1OhEiWlYuj/ts7Y.wrUs2Ch3orJbUjZ/G','OrmbYCXHJ4','2025-11-21 13:45:51','2025-11-21 13:45:51'),(6,'Yolanda Mills','kasey.heller@example.org','2025-11-21 13:45:51','$2y$12$Z4x1pHInzzZzmKCPizE/1OhEiWlYuj/ts7Y.wrUs2Ch3orJbUjZ/G','wJBr1L2qo3','2025-11-21 13:45:51','2025-11-21 13:45:51');
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

-- Dump completed on 2025-11-22  3:08:17

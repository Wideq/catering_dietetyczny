-- MySQL dump 10.13  Distrib 8.0.41, for Win64 (x86_64)
--
-- Host: localhost    Database: catering_db
-- ------------------------------------------------------
-- Server version	8.0.41

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
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
-- Table structure for table `diet_plans`
--

DROP TABLE IF EXISTS `diet_plans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `diet_plans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `price_per_day` decimal(8,2) NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `diet_plans`
--

LOCK TABLES `diet_plans` WRITE;
/*!40000 ALTER TABLE `diet_plans` DISABLE KEYS */;
INSERT INTO `diet_plans` VALUES (4,'xd','1',83.90,'fa-utensils',NULL,1,'2025-06-04 17:12:31','2025-06-04 17:12:42'),(5,'xd','1',76.50,'fa-utensils',NULL,1,'2025-06-04 17:32:07','2025-06-04 17:32:23');
/*!40000 ALTER TABLE `diet_plans` ENABLE KEYS */;
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
-- Table structure for table `menu_diet_plan`
--

DROP TABLE IF EXISTS `menu_diet_plan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `menu_diet_plan` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `diet_plan_id` bigint unsigned NOT NULL,
  `menu_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_diet_plan_diet_plan_id_foreign` (`diet_plan_id`),
  KEY `menu_diet_plan_menu_id_foreign` (`menu_id`),
  CONSTRAINT `menu_diet_plan_diet_plan_id_foreign` FOREIGN KEY (`diet_plan_id`) REFERENCES `diet_plans` (`id`) ON DELETE CASCADE,
  CONSTRAINT `menu_diet_plan_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_diet_plan`
--

LOCK TABLES `menu_diet_plan` WRITE;
/*!40000 ALTER TABLE `menu_diet_plan` DISABLE KEYS */;
INSERT INTO `menu_diet_plan` VALUES (27,4,11,'2025-06-04 17:12:42','2025-06-04 17:12:42'),(28,4,14,'2025-06-04 17:12:42','2025-06-04 17:12:42'),(29,4,4,'2025-06-04 17:12:42','2025-06-04 17:12:42'),(30,5,11,'2025-06-04 17:32:23','2025-06-04 17:32:23'),(31,5,18,'2025-06-04 17:32:23','2025-06-04 17:32:23'),(32,5,20,'2025-06-04 17:32:23','2025-06-04 17:32:23');
/*!40000 ALTER TABLE `menu_diet_plan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `menus` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(8,2) NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menus`
--

LOCK TABLES `menus` WRITE;
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;
INSERT INTO `menus` VALUES (1,'Zupa krem z batatów','Aksamitna zupa krem z batatów z dodatkiem mleka kokosowego, kurkumy i prażonych pestek dyni. Rozgrzewająca i sycąca.',22.90,'kolacja',NULL,'2025-06-03 19:43:42','2025-06-03 19:43:42'),(2,'Pudding chia z owocami','Pudding z nasion chia na mleku roślinnym, z dodatkiem miodu, owoców leśnych i granoli. Pełen antyoksydantów i błonnika.',19.90,'drugie śniadanie',NULL,'2025-06-03 19:43:42','2025-06-03 19:43:42'),(3,'Energy ball orzechowe','Domowe kulki energetyczne z daktyli, orzechów i nasion. Naturalna słodycz i zastrzyk energii bez dodatku cukru.',15.90,'podwieczorek',NULL,'2025-06-03 19:43:42','2025-06-03 19:43:42'),(4,'Łosoś z komosą ryżową','Delikatny filet z łososia pieczony z ziołami, podawany z komosą ryżową i warzywami sezonowymi. Bogate źródło kwasów omega-3.',36.90,'obiad',NULL,'2025-06-03 19:43:42','2025-06-03 19:43:42'),(5,'Bowl z tofu i warzywami','Wegański bowl z marynowanym tofu, brązowym ryżem, awokado, marchewką, brokułami i hummusem. Posypany prażonymi ziarnami.',32.50,'kolacja',NULL,'2025-06-03 19:43:42','2025-06-03 19:43:42'),(6,'Kurczak w ziołach prowansalskich','Soczysta pierś z kurczaka marynowana w ziołach prowansalskich, podawana z kaszą bulgur i mieszanką warzyw na parze.',29.90,'obiad',NULL,'2025-06-03 19:43:42','2025-06-03 19:43:42'),(7,'Bowl z tofu i warzywami','Wegański bowl z marynowanym tofu, brązowym ryżem, awokado, marchewką, brokułami i hummusem. Posypany prażonymi ziarnami.',32.50,'kolacja',NULL,'2025-06-03 19:43:42','2025-06-03 19:43:42'),(8,'Chili con carne fit','Klasyczne chili przygotowane z chudej wołowiny, czerwonej fasoli, kukurydzy i warzyw. Podawane z brązowym ryżem.',31.90,'kolacja',NULL,'2025-06-03 19:43:42','2025-06-03 19:43:42'),(9,'Muffin proteinowy','Puszysty muffin z dodatkiem białka, z kawałkami gorzkiej czekolady i orzechami. Słodka przekąska z obniżoną zawartością cukru.',16.90,'podwieczorek',NULL,'2025-06-03 19:43:42','2025-06-03 19:43:42'),(10,'Energy ball orzechowe','Domowe kulki energetyczne z daktyli, orzechów i nasion. Naturalna słodycz i zastrzyk energii bez dodatku cukru.',15.90,'podwieczorek',NULL,'2025-06-03 19:43:42','2025-06-03 19:43:42'),(11,'Omlet proteinowy','Omlet z białek jaj, ze szpinakiem, pomidorami suszonymi i fetą. Idealny na śniadanie, bogaty w białko.',24.50,'śniadanie',NULL,'2025-06-03 19:43:43','2025-06-03 19:43:43'),(12,'Makaron pełnoziarnisty z warzywami','Makaron pełnoziarnisty z bogatym sosem z pieczonych warzyw, pomidorami cherry i bazylią. Opcja wegetariańska bogata w błonnik.',26.50,'obiad',NULL,'2025-06-03 19:43:43','2025-06-03 19:43:43'),(13,'Energy ball orzechowe','Domowe kulki energetyczne z daktyli, orzechów i nasion. Naturalna słodycz i zastrzyk energii bez dodatku cukru.',15.90,'podwieczorek',NULL,'2025-06-03 19:43:43','2025-06-03 19:43:43'),(14,'Wrap z hummusem i warzywami','Tortilla pełnoziarnista z kremowym hummusem, świeżymi warzywami i kiełkami. Lekka i pożywna przekąska na drugie śniadanie.',22.50,'drugie śniadanie',NULL,'2025-06-03 19:43:44','2025-06-03 19:43:44'),(15,'Zupa krem z batatów','Aksamitna zupa krem z batatów z dodatkiem mleka kokosowego, kurkumy i prażonych pestek dyni. Rozgrzewająca i sycąca.',22.90,'kolacja',NULL,'2025-06-03 19:43:44','2025-06-03 19:43:44'),(16,'Pudding chia z owocami','Pudding z nasion chia na mleku roślinnym, z dodatkiem miodu, owoców leśnych i granoli. Pełen antyoksydantów i błonnika.',19.90,'drugie śniadanie',NULL,'2025-06-03 19:43:44','2025-06-03 19:43:44'),(17,'Bowl z tofu i warzywami','Wegański bowl z marynowanym tofu, brązowym ryżem, awokado, marchewką, brokułami i hummusem. Posypany prażonymi ziarnami.',32.50,'kolacja',NULL,'2025-06-03 19:43:44','2025-06-03 19:43:44'),(18,'Szakszuka fit','Jajka gotowane w aromatycznym sosie pomidorowym z papryką, cebulą i przyprawami. Serwowane z pieczywem pełnoziarnistym.',26.50,'śniadanie',NULL,'2025-06-03 19:43:45','2025-06-03 19:43:45'),(19,'Zupa krem z batatów','Aksamitna zupa krem z batatów z dodatkiem mleka kokosowego, kurkumy i prażonych pestek dyni. Rozgrzewająca i sycąca.',22.90,'kolacja',NULL,'2025-06-03 19:43:45','2025-06-03 19:43:45'),(20,'Omlet proteinowy','Omlet z białek jaj, ze szpinakiem, pomidorami suszonymi i fetą. Idealny na śniadanie, bogaty w białko.',24.50,'śniadanie',NULL,'2025-06-03 19:43:45','2025-06-03 19:43:45'),(21,'Smoothie bowl proteinowe','Gęsty koktajl ze świeżych owoców i białka serweczkowego, posypany orzechami, nasionami i płatkami kokosowymi.',23.90,'drugie śniadanie',NULL,'2025-06-03 19:43:45','2025-06-03 19:43:45'),(22,'Energy ball orzechowe','Domowe kulki energetyczne z daktyli, orzechów i nasion. Naturalna słodycz i zastrzyk energii bez dodatku cukru.',15.90,'podwieczorek',NULL,'2025-06-03 19:43:46','2025-06-03 19:43:46'),(23,'Chili con carne fit','Klasyczne chili przygotowane z chudej wołowiny, czerwonej fasoli, kukurydzy i warzyw. Podawane z brązowym ryżem.',31.90,'kolacja',NULL,'2025-06-03 19:43:46','2025-06-03 19:43:46'),(24,'Makaron pełnoziarnisty z warzywami','Makaron pełnoziarnisty z bogatym sosem z pieczonych warzyw, pomidorami cherry i bazylią. Opcja wegetariańska bogata w błonnik.',26.50,'obiad',NULL,'2025-06-03 19:43:46','2025-06-03 19:43:46'),(25,'Kurczak w ziołach prowansalskich','Soczysta pierś z kurczaka marynowana w ziołach prowansalskich, podawana z kaszą bulgur i mieszanką warzyw na parze.',29.90,'obiad',NULL,'2025-06-03 19:43:46','2025-06-03 19:43:46'),(26,'Jogurt grecki z granolą','Kremowy jogurt grecki z domową granolą, orzechami i świeżymi owocami sezonowymi. Doskonałe źródło białka na początek dnia.',18.90,'śniadanie',NULL,'2025-06-03 19:43:47','2025-06-03 19:43:47'),(27,'Energy ball orzechowe','Domowe kulki energetyczne z daktyli, orzechów i nasion. Naturalna słodycz i zastrzyk energii bez dodatku cukru.',15.90,'podwieczorek',NULL,'2025-06-03 19:43:47','2025-06-03 19:43:47'),(28,'Wrap z hummusem i warzywami','Tortilla pełnoziarnista z kremowym hummusem, świeżymi warzywami i kiełkami. Lekka i pożywna przekąska na drugie śniadanie.',22.50,'drugie śniadanie',NULL,'2025-06-03 19:43:47','2025-06-03 19:43:47'),(29,'Smoothie bowl proteinowe','Gęsty koktajl ze świeżych owoców i białka serweczkowego, posypany orzechami, nasionami i płatkami kokosowymi.',23.90,'drugie śniadanie',NULL,'2025-06-03 19:43:47','2025-06-03 19:43:47'),(30,'Kurczak w ziołach prowansalskich','Soczysta pierś z kurczaka marynowana w ziołach prowansalskich, podawana z kaszą bulgur i mieszanką warzyw na parze.',29.90,'obiad',NULL,'2025-06-03 19:43:48','2025-06-03 19:43:48');
/*!40000 ALTER TABLE `menus` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_05_13_113558_create_menuv2_table',1),(5,'2025_05_13_113611_create_orders_table',1),(6,'2025_05_13_113626_create_transactions_table',1),(7,'2025_05_19_173502_add_role_to_users_table',1),(8,'2025_05_20_101134_add_image_to_menus_table',1),(9,'2025_05_22_120334_add_description_to_transactions_table',1),(10,'2025_05_22_120524_add_status_to_transactions_table',1),(11,'2025_05_22_121114_add_columns_to_transactions_table',1),(12,'2025_05_30_214506_add_status_to_transactions_table',1),(13,'2025_05_31_181341_add_fields_to_transactions_table',1),(14,'2025_05_31_181402_add_transaction_id_to_orders_table',1),(15,'2025_05_31_185014_make_order_id_nullable_in_transactions_table',1),(16,'2025_06_01_090559_create_order_items_table',1),(17,'2025_06_01_091631_add_total_amount_to_orders',1),(18,'2025_06_03_102504_create_diet_plans_table',1),(19,'2025_06_03_102507_create_menu_diet',1),(20,'2025_06_03_123043_add_category_to_menus_table',1),(21,'2025_06_03_214913_remove_day_and_meal_type_from_menu_diet_plan_table',2),(22,'2025_06_04_202007_add_diet_plan_fields_to_order_items',3),(23,'2025_06_04_203013_change_menu_id_to_nullable_in_orders_table',4),(24,'2025_06_04_203612_update_orders_table_make_menu_id_nullable',5);
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
  `menu_id` bigint unsigned DEFAULT NULL,
  `diet_plan_id` bigint unsigned DEFAULT NULL,
  `quantity` int NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `item_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'menu',
  `duration` int DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_menu_id_foreign` (`menu_id`),
  KEY `order_items_diet_plan_id_foreign` (`diet_plan_id`),
  CONSTRAINT `order_items_diet_plan_id_foreign` FOREIGN KEY (`diet_plan_id`) REFERENCES `diet_plans` (`id`) ON DELETE SET NULL,
  CONSTRAINT `order_items_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (1,21,NULL,4,1,419.50,'diet_plan',5,'2025-06-06','','2025-06-04 18:30:39','2025-06-04 18:30:39'),(2,22,NULL,5,1,382.50,'diet_plan',5,'2025-06-06','','2025-06-04 18:37:05','2025-06-04 18:37:05'),(3,23,NULL,5,1,382.50,'diet_plan',5,'2025-06-06','','2025-06-04 18:37:59','2025-06-04 18:37:59'),(4,25,2,NULL,1,19.90,'menu',NULL,NULL,NULL,'2025-06-04 19:32:18','2025-06-04 19:32:18');
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
  `menu_id` bigint unsigned DEFAULT NULL,
  `quantity` int NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `transaction_id` bigint unsigned DEFAULT NULL,
  `total_amount` decimal(8,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_user_id_foreign` (`user_id`),
  KEY `orders_transaction_id_foreign` (`transaction_id`),
  KEY `orders_menu_id_foreign` (`menu_id`),
  CONSTRAINT `orders_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE SET NULL,
  CONSTRAINT `orders_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`),
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,26,11,9,'2025-05-15 08:58:19','completed','2025-06-03 19:43:48','2025-06-03 19:43:48',1,NULL),(2,27,12,2,'2025-05-16 13:04:55','pending','2025-06-03 19:43:48','2025-06-03 19:43:48',2,NULL),(3,28,13,6,'2025-05-27 11:40:12','cancelled','2025-06-03 19:43:48','2025-06-03 19:43:48',3,NULL),(4,29,14,10,'2025-05-30 12:43:28','cancelled','2025-06-03 19:43:48','2025-06-03 19:43:48',4,NULL),(5,30,15,1,'2025-06-01 16:56:38','pending','2025-06-03 19:43:48','2025-06-03 19:43:48',5,NULL),(6,31,16,1,'2025-05-06 19:03:19','pending','2025-06-03 19:43:48','2025-06-03 19:43:48',6,NULL),(7,32,17,9,'2025-05-22 13:16:58','cancelled','2025-06-03 19:43:48','2025-06-03 19:43:48',7,NULL),(8,33,18,3,'2025-05-27 07:20:50','cancelled','2025-06-03 19:43:48','2025-06-03 19:43:48',8,NULL),(9,34,19,2,'2025-05-16 08:18:24','cancelled','2025-06-03 19:43:48','2025-06-03 19:43:48',9,NULL),(10,35,20,9,'2025-05-18 21:30:39','cancelled','2025-06-03 19:43:48','2025-06-03 19:43:48',10,NULL),(11,36,21,1,'2025-05-31 09:09:28','completed','2025-06-03 19:43:48','2025-06-03 19:43:48',11,NULL),(12,37,22,5,'2025-05-07 02:50:15','cancelled','2025-06-03 19:43:48','2025-06-03 19:43:48',12,NULL),(13,38,23,7,'2025-05-13 05:46:51','pending','2025-06-03 19:43:48','2025-06-03 19:43:48',13,NULL),(14,39,24,6,'2025-05-24 10:06:26','completed','2025-06-03 19:43:48','2025-06-03 19:43:48',14,NULL),(15,40,25,2,'2025-05-27 18:07:46','pending','2025-06-03 19:43:48','2025-06-03 19:43:48',15,NULL),(16,41,26,9,'2025-05-21 00:42:06','cancelled','2025-06-03 19:43:48','2025-06-03 19:43:48',16,NULL),(17,42,27,9,'2025-05-09 02:07:30','cancelled','2025-06-03 19:43:48','2025-06-03 19:43:48',17,NULL),(18,43,28,9,'2025-05-13 01:07:45','cancelled','2025-06-03 19:43:48','2025-06-03 19:43:48',18,NULL),(19,44,29,7,'2025-05-06 05:05:16','pending','2025-06-03 19:43:48','2025-06-03 19:43:48',19,NULL),(20,45,30,3,'2025-05-31 01:48:41','completed','2025-06-03 19:43:48','2025-06-03 19:43:48',20,NULL),(21,5,NULL,1,'2025-06-04 18:30:39','new','2025-06-04 18:30:39','2025-06-04 18:30:39',NULL,NULL),(22,5,NULL,1,'2025-06-04 18:37:05','new','2025-06-04 18:37:05','2025-06-04 18:37:05',NULL,NULL),(23,5,NULL,1,'2025-06-04 18:37:59','new','2025-06-04 18:37:59','2025-06-04 18:37:59',NULL,NULL),(24,5,NULL,1,'2025-06-04 19:31:59','new','2025-06-04 19:31:59','2025-06-04 19:31:59',NULL,NULL),(25,5,NULL,1,'2025-06-04 19:32:18','new','2025-06-04 19:32:18','2025-06-04 19:32:18',NULL,NULL);
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
  `order_id` bigint unsigned DEFAULT NULL,
  `amount` decimal(8,2) NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `transactions_order_id_foreign` (`order_id`),
  KEY `transactions_user_id_foreign` (`user_id`),
  CONSTRAINT `transactions_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
INSERT INTO `transactions` VALUES (1,1,159.46,'Quia quam et nemo labore quidem quia occaecati ea.','failed','paypal','2025-05-22 23:27:57','2025-06-03 19:43:48','2025-06-03 19:43:48',26),(2,2,24.44,'Consequuntur est modi iste quas soluta occaecati cum.','pending','bank_transfer','2025-05-08 16:51:38','2025-06-03 19:43:48','2025-06-03 19:43:48',27),(3,3,102.06,'Quos id deserunt dolorum soluta dicta mollitia.','failed','credit_card','2025-05-23 22:04:38','2025-06-03 19:43:48','2025-06-03 19:43:48',28),(4,4,112.83,'Aut voluptas est voluptas vero aut libero odio id.','pending','bank_transfer','2025-06-01 02:52:50','2025-06-03 19:43:48','2025-06-03 19:43:48',29),(5,5,43.20,'Quis beatae quis perferendis itaque.','pending','bank_transfer','2025-05-30 00:30:50','2025-06-03 19:43:48','2025-06-03 19:43:48',30),(6,6,52.30,'Error quod iusto ad ex est.','pending','bank_transfer','2025-05-19 22:48:08','2025-06-03 19:43:48','2025-06-03 19:43:48',31),(7,7,114.42,'Soluta laudantium est expedita neque et.','completed','paypal','2025-05-23 01:43:28','2025-06-03 19:43:48','2025-06-03 19:43:48',32),(8,8,88.06,'Sit rerum ea quis temporibus illum.','completed','credit_card','2025-06-01 12:08:31','2025-06-03 19:43:48','2025-06-03 19:43:48',33),(9,9,120.38,'Necessitatibus et temporibus autem quia quia et fugit.','pending','bank_transfer','2025-05-27 08:23:10','2025-06-03 19:43:48','2025-06-03 19:43:48',34),(10,10,171.85,'Nam ut ea ut amet.','failed','credit_card','2025-05-06 00:02:02','2025-06-03 19:43:48','2025-06-03 19:43:48',35),(11,11,121.51,'Nemo amet maxime quidem voluptate odio consequatur.','failed','credit_card','2025-06-03 12:59:09','2025-06-03 19:43:48','2025-06-03 19:43:48',36),(12,12,27.14,'Et dolores veritatis sunt inventore illum sint eveniet maiores.','failed','bank_transfer','2025-06-01 18:45:33','2025-06-03 19:43:48','2025-06-03 19:43:48',37),(13,13,31.90,'Excepturi illo similique inventore dolor.','completed','bank_transfer','2025-05-23 12:56:53','2025-06-03 19:43:48','2025-06-03 19:43:48',38),(14,14,104.54,'Vel recusandae pariatur autem.','completed','bank_transfer','2025-05-21 23:00:30','2025-06-03 19:43:48','2025-06-03 19:43:48',39),(15,15,159.34,'Delectus aut excepturi consequuntur nihil aliquam omnis.','failed','paypal','2025-05-07 23:56:38','2025-06-03 19:43:48','2025-06-03 19:43:48',40),(16,16,70.27,'Quia illo distinctio quas est.','completed','paypal','2025-05-08 11:19:36','2025-06-03 19:43:48','2025-06-03 19:43:48',41),(17,17,21.50,'Ab vel voluptatem impedit aut rem ratione eum.','completed','paypal','2025-05-18 01:05:47','2025-06-03 19:43:48','2025-06-03 19:43:48',42),(18,18,177.70,'Numquam eos minus ut omnis quibusdam.','failed','bank_transfer','2025-05-19 09:05:57','2025-06-03 19:43:48','2025-06-03 19:43:48',43),(19,19,43.87,'Eaque dolor ut voluptas.','pending','bank_transfer','2025-05-24 03:28:42','2025-06-03 19:43:48','2025-06-03 19:43:48',44),(20,20,24.86,'Fugiat magni ut blanditiis libero et amet a.','pending','paypal','2025-06-01 21:50:46','2025-06-03 19:43:48','2025-06-03 19:43:48',45),(21,NULL,155.59,'Pariatur vel qui enim dicta libero.','completed','paypal','2025-05-20 14:30:10','2025-06-03 19:43:48','2025-06-03 19:43:48',7),(22,NULL,198.39,'Praesentium sed voluptas nulla molestiae.','failed','bank_transfer','2025-05-05 11:50:42','2025-06-03 19:43:48','2025-06-03 19:43:48',21),(23,NULL,101.95,'Dignissimos praesentium atque suscipit ipsum molestiae eligendi.','failed','bank_transfer','2025-05-08 17:27:58','2025-06-03 19:43:48','2025-06-03 19:43:48',43),(24,NULL,134.67,'Quos quis tempore ducimus culpa totam iste iusto quia.','failed','paypal','2025-05-13 22:29:49','2025-06-03 19:43:48','2025-06-03 19:43:48',27),(25,NULL,168.43,'Nulla voluptas autem temporibus eos.','pending','paypal','2025-05-04 03:12:21','2025-06-03 19:43:48','2025-06-03 19:43:48',44),(26,NULL,138.89,'Saepe aut praesentium sed sunt.','failed','credit_card','2025-05-18 08:01:45','2025-06-03 19:43:48','2025-06-03 19:43:48',4),(27,NULL,101.06,'Enim quaerat quis architecto nisi commodi eaque deserunt.','completed','paypal','2025-05-30 19:23:27','2025-06-03 19:43:48','2025-06-03 19:43:48',31),(28,NULL,198.63,'Hic eius dignissimos accusantium eum vel.','completed','credit_card','2025-05-30 18:10:53','2025-06-03 19:43:48','2025-06-03 19:43:48',19),(29,NULL,168.98,'Nihil ut eligendi tenetur expedita pariatur nobis porro.','failed','bank_transfer','2025-06-02 01:25:42','2025-06-03 19:43:48','2025-06-03 19:43:48',2),(30,NULL,112.33,'Totam aut quam aliquid nobis.','failed','credit_card','2025-05-15 23:53:51','2025-06-03 19:43:48','2025-06-03 19:43:48',38),(40,NULL,419.50,'Zamówienie online','completed','online','2025-06-04 20:30:39','2025-06-04 18:30:39','2025-06-04 18:30:39',5),(41,NULL,382.50,'Zamówienie online','completed','online','2025-06-04 20:37:05','2025-06-04 18:37:05','2025-06-04 18:37:05',5),(42,NULL,382.50,'Zamówienie online','completed','online','2025-06-04 20:37:59','2025-06-04 18:37:59','2025-06-04 18:37:59',5),(43,NULL,97.50,'Zamówienie online','completed','online','2025-06-04 21:31:59','2025-06-04 19:31:59','2025-06-04 19:31:59',5),(44,NULL,19.90,'Zamówienie online','completed','online','2025-06-04 21:32:18','2025-06-04 19:32:18','2025-06-04 19:32:18',5);
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
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Jan Kowalski','jan.kowalski@example.com','2025-06-03 19:43:36','$2y$12$XwIEjl.JzzSzb1K5luOqLul63m0YuOrak6OJGMdjAHADbGG6KpmfO','QwVipO4tdr','2025-06-03 19:43:36','2025-06-03 19:43:36','user'),(2,'Anna Nowak','anna.nowak@example.com','2025-06-03 19:43:36','$2y$12$2MChc8mohFlOmzp2sWSOauCNrWjvsSjVH/vnVXXi5CsAbOHwFkrx6','MjLWfvVtio','2025-06-03 19:43:37','2025-06-03 19:43:37','user'),(3,'Piotr Wiśniewski','piotr.wisniewski@example.com','2025-06-03 19:43:37','$2y$12$dcu8RSmAryuPGGX4v93hEeMp5cRBsWH7ua6zOkQ16RvZb6uapk4dy','xP9Z2PGEzc','2025-06-03 19:43:37','2025-06-03 19:43:37','user'),(4,'Katarzyna Dąbrowska','kat.dabrowska@example.com','2025-06-03 19:43:37','$2y$12$AFZzymX2VWGl5UDSLhnhgu5NmTmI0uWK6PDGETE38IiwkKOOs9t0a','lAihK0Q1a9','2025-06-03 19:43:37','2025-06-03 19:43:37','user'),(5,'Administrator','admin@puremeal.pl','2025-06-03 19:43:37','$2y$12$sJX5UelaGz.856kuseAQOuRl8DCpQzwHW0InlFo2rRtGWmsjwRJ3u','4ulxjiBBV8','2025-06-03 19:43:37','2025-06-03 19:43:37','admin'),(6,'Fernando Sanford','roob.paul@example.com','2025-06-03 19:43:37','$2y$12$2MRi5TZXAwhliP0KPbX1L.0XGnxNSIlkvSx947ptRRFHRkysL3hgy','9JAh1kgp1W','2025-06-03 19:43:42','2025-06-03 19:43:42','user'),(7,'Dr. Leopoldo Veum','bonita20@example.com','2025-06-03 19:43:38','$2y$12$e2i8oab60mTDxCVW.HSfmuEwAFuQim2LueJh7uksYJOGljJgT77Wm','378XMRgG5R','2025-06-03 19:43:42','2025-06-03 19:43:42','user'),(8,'Torrey Block','bennie.hermiston@example.org','2025-06-03 19:43:38','$2y$12$NpbamUJzMmz9RT1mAA4Wre/HN/qkYzw7UQWB/2OHj.IZwERDYS3Ku','eOElYhigq2','2025-06-03 19:43:42','2025-06-03 19:43:42','user'),(9,'Jakayla Keebler','strosin.grayson@example.com','2025-06-03 19:43:38','$2y$12$HqC7zySmwcnMLX/jAQjA4OIEkfgjh8ws7ybLPIlnPPIxNYu.C5nay','eoOCCDqGUR','2025-06-03 19:43:42','2025-06-03 19:43:42','user'),(10,'Prof. Misael Mueller','itzel.weissnat@example.com','2025-06-03 19:43:38','$2y$12$Pu/Ocp1odu53qTff23n2S.N73VqQFJa39LoiNo2UVSi2LsLHqomdC','OEOAXkdoTE','2025-06-03 19:43:42','2025-06-03 19:43:42','user'),(11,'Esmeralda Jast','sauer.liam@example.org','2025-06-03 19:43:39','$2y$12$QorNHe1rQobOA2dMeN9x4u2Jfh6.fMFH982WlpKA630Cs59XFBxSi','iDZXQOGHN0','2025-06-03 19:43:42','2025-06-03 19:43:42','user'),(12,'Isabell Johnson I','bjerde@example.org','2025-06-03 19:43:39','$2y$12$B2EwjHYY4qxu/GMvZsVXHu2Nv4wgwDb38FiykugrfVO9rFxyAkkey','fBoUbuk19m','2025-06-03 19:43:42','2025-06-03 19:43:42','user'),(13,'Dr. Jordi Breitenberg','jada60@example.net','2025-06-03 19:43:39','$2y$12$e1QdJMZmRxkzEy.P0epfleRfmlfLuH3f.O.NCG3sd/zP33iKsi2uu','K1fnh26wUo','2025-06-03 19:43:42','2025-06-03 19:43:42','user'),(14,'Ms. Helena Wehner MD','crona.kenyatta@example.net','2025-06-03 19:43:39','$2y$12$Rvszde6HExllZR5Djg.nN.Mb8eUXrFRZbE8OJZHiKrXDiX7N9iFe6','v14A1pABWI','2025-06-03 19:43:42','2025-06-03 19:43:42','user'),(15,'Tamara Lind','paige.bednar@example.com','2025-06-03 19:43:40','$2y$12$jtiIsRI7ZlayVgfI53JCDu9yhLxQLOj0dkbdHr9AdTLUnY8tHzJ3O','L2i2krqJSz','2025-06-03 19:43:42','2025-06-03 19:43:42','user'),(16,'Miss Kaia Herman','matilda33@example.net','2025-06-03 19:43:40','$2y$12$1PFuxf7G0lsLeXw77c4u1OS.PXJk1sDPixLbq1Brz7T8M7QPFKoYC','2mZ1n87jzE','2025-06-03 19:43:42','2025-06-03 19:43:42','user'),(17,'Benton Hansen PhD','blanda.jadyn@example.com','2025-06-03 19:43:40','$2y$12$HyKeVlq4bwX4vNskf0Yntu.BmO75.aBstIvCf/C30hHigcBw7Lwjm','Sx9IGREV4Y','2025-06-03 19:43:42','2025-06-03 19:43:42','user'),(18,'Dr. Lois Pfeffer','mallie.dooley@example.com','2025-06-03 19:43:40','$2y$12$.qJvrgTCEZTXhb1nehemT.AkRiutXAUcvs3uOpPqkGT2G8m3/6Aom','dLUBeMlvYX','2025-06-03 19:43:42','2025-06-03 19:43:42','user'),(19,'Rigoberto Stark','trey76@example.com','2025-06-03 19:43:41','$2y$12$8XbVFu/2r/zprNRzXAs8ae4v91Sqm8dnlWJ5SkAxYARWWITNvPWVe','CGpdL4Nk8t','2025-06-03 19:43:42','2025-06-03 19:43:42','user'),(20,'Jadyn Klein','woodrow.berge@example.com','2025-06-03 19:43:41','$2y$12$4SS8KDQI01kALLi0eUCBH.LZS3wqIhyz8H2f2I5Kb0GAF1kVkPUn2','2VLrbKhDz6','2025-06-03 19:43:42','2025-06-03 19:43:42','user'),(21,'Gaetano Larson','runte.haley@example.com','2025-06-03 19:43:41','$2y$12$Uba9cvI3pEHeFR/8kmmNz.NybsQbavEJesCj0Bvh.1uB4IT7R7GMi','CzUz8ECl77','2025-06-03 19:43:42','2025-06-03 19:43:42','user'),(22,'Dr. Sophie Heller','hamill.greyson@example.net','2025-06-03 19:43:41','$2y$12$xZivEz6sSlEUbHV4f0oYO.sMqWBn.8Ez0EjVgt9rlygma07WIIj9q','qM2glTL6AF','2025-06-03 19:43:42','2025-06-03 19:43:42','user'),(23,'Pat Murray','fschaden@example.org','2025-06-03 19:43:42','$2y$12$Wk1g1YXpID5aumwGcn.xjuHRjBzchK4g.lnQWKmobc.8ILGP9Ex3u','tyItKD5tbR','2025-06-03 19:43:42','2025-06-03 19:43:42','user'),(24,'Noe Sauer PhD','alfonso81@example.com','2025-06-03 19:43:42','$2y$12$3BtYBCjDuRYPz1RssHmNv.UrD/j6CdbOLP.A2VQUW0.dJzvIWOxQm','K4NZueAHpt','2025-06-03 19:43:42','2025-06-03 19:43:42','user'),(25,'Rosendo Schuppe','phoebe.langosh@example.org','2025-06-03 19:43:42','$2y$12$LiF1yhyy8JxLIXtOvUT8MehmuKP28aRb35Rr11q8pcS1oRjmHdYny','NYg3haWOLS','2025-06-03 19:43:42','2025-06-03 19:43:42','user'),(26,'Mrs. Daniella Jenkins Jr.','anne.schmidt@example.org','2025-06-03 19:43:43','$2y$12$oYU7jJChlEaraqovhcXhDeZq137DDMS705xl46nNXYJFnoa6QFovW','ZaFAnk7X55','2025-06-03 19:43:43','2025-06-03 19:43:43','user'),(27,'Alba Thiel','kelly68@example.net','2025-06-03 19:43:43','$2y$12$fCc3hqBp3Bm.YrxeRFYijuG0jKgPxWDCu5NyWOZifCqBIrOP/D1C.','uD4TBOJaSf','2025-06-03 19:43:43','2025-06-03 19:43:43','user'),(28,'Connor Kozey','lehner.jerald@example.com','2025-06-03 19:43:43','$2y$12$/3hcabyIleeA7Z1WhZMi.uHROF19ll0RZalynxe97xVgqsQid0iVa','oLEtx7nDkO','2025-06-03 19:43:43','2025-06-03 19:43:43','user'),(29,'Hailee Langworth','damon.hirthe@example.com','2025-06-03 19:43:43','$2y$12$viqcSd99zfGTw4e/TD6pSOLenH2PLSbphFgbtChFc2QPThkc7Hyp2','YfpcRmrScG','2025-06-03 19:43:44','2025-06-03 19:43:44','user'),(30,'Frieda Schaefer','mueller.loren@example.org','2025-06-03 19:43:44','$2y$12$X3eGcy.sul9As9RWAgmkGOeOa1cZlXkoQyQv0PTaMamrVuBldB6nC','Q7EyIYnBUZ','2025-06-03 19:43:44','2025-06-03 19:43:44','user'),(31,'Prof. Monte O\'Kon','elyssa13@example.com','2025-06-03 19:43:44','$2y$12$8UQQOdn/wWt192sV1vVZa.NwD8CRe9WDYtYnEhf5Dj5TL3xvP5pLq','qXp3xEWbd4','2025-06-03 19:43:44','2025-06-03 19:43:44','user'),(32,'Rosalia Streich','leda.kohler@example.org','2025-06-03 19:43:44','$2y$12$d/3/isBlYDj4TQ/GMH5v/uhb3rNwpMoZ7ph5eUgzA0qo1A5rf8z1C','DR7r8Ad5A8','2025-06-03 19:43:44','2025-06-03 19:43:44','user'),(33,'Herminia Leannon V','gerson.purdy@example.net','2025-06-03 19:43:44','$2y$12$qYa7xOiZZwikllLUNiGI3OCzL9ecUuV.Do2QdgS7j08g6YeXr9yaq','4YQKwzsqSg','2025-06-03 19:43:45','2025-06-03 19:43:45','user'),(34,'Jimmy Bartoletti','dusty.brekke@example.org','2025-06-03 19:43:45','$2y$12$9TcXyh/wFav6aCCA0mlHoubvHCNcMCDXR4a4M.7KvRMW1D.WCv/4.','QJDNJeoCng','2025-06-03 19:43:45','2025-06-03 19:43:45','user'),(35,'Trycia Morissette','kunde.xander@example.net','2025-06-03 19:43:45','$2y$12$GvzKqOnK1DzozLq5Mrra7Or4nzAcL4pNZDJHpQQqCOT2FwpCHmEjW','D1vFAPmf1R','2025-06-03 19:43:45','2025-06-03 19:43:45','user'),(36,'Efren Tromp','cwindler@example.net','2025-06-03 19:43:45','$2y$12$nnq7RW9FeGC9g0iJOw45del8lxJKzXN.WxhdkX9obS/YblnEZ/b6G','CY3DMJeFMS','2025-06-03 19:43:45','2025-06-03 19:43:45','user'),(37,'Mikel Pollich','rosalyn97@example.com','2025-06-03 19:43:45','$2y$12$bqhYh5EJGnbUFxxeGcfi6uIkoVEN0XfN1ByxneGhb4rum7qPn8d1O','HR3MMeilHK','2025-06-03 19:43:46','2025-06-03 19:43:46','user'),(38,'Susana Cronin','mueller.leta@example.net','2025-06-03 19:43:46','$2y$12$gUIao/2i1cXeRN5oqEM6XerCvIt5MYMcuXP35iDZNZpAlmpm7Od/O','Q95dVKWVJt','2025-06-03 19:43:46','2025-06-03 19:43:46','user'),(39,'Mr. Gino Schultz','murray.jerel@example.net','2025-06-03 19:43:46','$2y$12$yKKZOWdzgQGmzShRxa6hFe8tyjSW9jcf5QTtyI9zrjzKvgnxz2VCu','iOfAMPIVSH','2025-06-03 19:43:46','2025-06-03 19:43:46','user'),(40,'Laurianne Tremblay','hodkiewicz.shirley@example.com','2025-06-03 19:43:46','$2y$12$dpp11.isuqZG9ExplrTut.lDh1PIQTwU0SZRAbItsUk48k2WsTGAu','JmJ0XKtAQe','2025-06-03 19:43:46','2025-06-03 19:43:46','user'),(41,'Prof. Lawrence Block','gwalker@example.org','2025-06-03 19:43:46','$2y$12$j7kL5GLauvu2Pwaqb3k9S.f9VHckBDqBasoh2MUqgK/tab6mvSCDe','ew5BnbgIpG','2025-06-03 19:43:47','2025-06-03 19:43:47','user'),(42,'Humberto Lowe','ashtyn78@example.com','2025-06-03 19:43:47','$2y$12$ZG8Pl1UjEchA8IITKuysQeoq8w0K74zooCoBErHxOwlMlBIipeg2a','PU4v1793oK','2025-06-03 19:43:47','2025-06-03 19:43:47','user'),(43,'Christ Little','damore.skyla@example.org','2025-06-03 19:43:47','$2y$12$FjLVl0qRhfv2j28K5GCXCuvCStO84tcE10KWK9GQJUh2tgzlwgb4C','gng4VojgJr','2025-06-03 19:43:47','2025-06-03 19:43:47','user'),(44,'Sylvia Waelchi','morissette.zackery@example.net','2025-06-03 19:43:47','$2y$12$xYeF4DH1XWs6RWCIPUbIWuwFz5a0RoJ72ugktN40EmSK3G7U9HSCO','L1H5AJfd1d','2025-06-03 19:43:47','2025-06-03 19:43:47','user'),(45,'Greyson Trantow II','erwin.goyette@example.net','2025-06-03 19:43:47','$2y$12$3TiF1U9Xy7Vdgd/AF6PkBeQjOoPzLJiYyV05p43kdr8IGQ1IeuQ4e','zkXnfdjeC1','2025-06-03 19:43:48','2025-06-03 19:43:48','user');
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

-- Dump completed on 2025-06-05  0:09:22

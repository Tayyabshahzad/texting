-- MySQL dump 10.13  Distrib 8.0.29, for macos12.2 (arm64)
--
-- Host: localhost    Database: digital_coupons
-- ------------------------------------------------------
-- Server version	8.0.29

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
-- Table structure for table `coupons`
--

DROP TABLE IF EXISTS `coupons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `coupons` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiry` datetime NOT NULL,
  `created_by_id` int unsigned NOT NULL,
  `customer_details_id` int unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `coupons_created_by_id_foreign` (`created_by_id`),
  KEY `coupons_customer_details_id_foreign` (`customer_details_id`),
  CONSTRAINT `coupons_created_by_id_foreign` FOREIGN KEY (`created_by_id`) REFERENCES `users` (`id`),
  CONSTRAINT `coupons_customer_details_id_foreign` FOREIGN KEY (`customer_details_id`) REFERENCES `customer_details` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coupons`
--

LOCK TABLES `coupons` WRITE;
/*!40000 ALTER TABLE `coupons` DISABLE KEYS */;
INSERT INTO `coupons` VALUES (1,'TestMetric','test','2023-03-31 00:00:00',2,1,'2023-03-30 20:46:13','2023-03-30 20:46:13'),(2,'testhook','121212','2023-03-31 01:05:00',2,1,'2023-03-30 20:52:36','2023-03-30 20:52:36'),(3,'webhook','webhook testing','2023-03-31 00:00:00',2,1,'2023-03-30 21:05:16','2023-03-30 21:05:16'),(4,'test','test','2023-03-31 00:00:00',2,1,'2023-03-30 21:10:58','2023-03-30 21:10:58'),(5,'NewTest','New testing coupon from prod','2023-04-03 18:00:00',2,1,'2023-03-31 09:59:45','2023-03-31 09:59:45'),(6,'New','test3','2023-03-31 23:58:00',2,1,'2023-03-31 10:03:21','2023-03-31 10:03:21'),(7,'aa','aa','2023-03-31 00:00:00',2,1,'2023-03-31 10:04:11','2023-03-31 10:04:11'),(8,'aaaaa','aaaaa','2023-03-31 00:00:00',2,1,'2023-03-31 10:06:19','2023-03-31 10:06:19');
/*!40000 ALTER TABLE `coupons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `coupons_list`
--

DROP TABLE IF EXISTS `coupons_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `coupons_list` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `coupon_id` int unsigned NOT NULL,
  `user_id` int unsigned NOT NULL,
  `redeemed` int NOT NULL DEFAULT '0',
  `redeemed_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `coupons_list_coupon_id_foreign` (`coupon_id`),
  KEY `coupons_list_user_id_foreign` (`user_id`),
  CONSTRAINT `coupons_list_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`),
  CONSTRAINT `coupons_list_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coupons_list`
--

LOCK TABLES `coupons_list` WRITE;
/*!40000 ALTER TABLE `coupons_list` DISABLE KEYS */;
INSERT INTO `coupons_list` VALUES (1,1,1,1,NULL),(3,2,1,0,NULL),(4,2,1,1,NULL),(23,8,1,0,NULL);
/*!40000 ALTER TABLE `coupons_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_details`
--

DROP TABLE IF EXISTS `customer_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customer_details` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `map_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verification_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `logo_location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customer_details_phone_unique` (`phone`),
  KEY `customer_details_user_id_foreign` (`user_id`),
  CONSTRAINT `customer_details_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_details`
--

LOCK TABLES `customer_details` WRITE;
/*!40000 ALTER TABLE `customer_details` DISABLE KEYS */;
INSERT INTO `customer_details` VALUES (1,2,'Johns Brewery','2223123123','Cold brews from John, located in urban NY','asdasd','123123','2023-03-29 14:11:57','2023-03-29 14:11:57',NULL);
/*!40000 ALTER TABLE `customer_details` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2023_03_15_221850_create_permission_tables',1),(7,'2023_03_20_154306_create_coupons_list_table',3),(11,'2023_03_27_152210_create_subscriptions_table',5),(12,'2023_03_20_154259_create_coupons_table',6),(13,'2023_03_22_103244_create_customer_details_table',7),(15,'2023_03_29_195150_create_twilio_sms_logs_table',9),(17,'2023_03_30_204414_update_users_table_add_dob',10),(18,'2023_03_30_212301_update_customer_details_add_logo',11),(20,'2023_03_31_041237_subscriptions_table_add_unsubbed',12),(22,'2023_03_29_195145_create_twilio_sms_table',13);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (3,'App\\Models\\User',1),(2,'App\\Models\\User',2),(3,'App\\Models\\User',5),(3,'App\\Models\\User',6);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
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
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Super-Admin','web',NULL,NULL),(2,'Customer','web',NULL,NULL),(3,'User','web',NULL,NULL);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subscriptions`
--

DROP TABLE IF EXISTS `subscriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subscriptions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `customer_details_id` int unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `unsubbed_at` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subscriptions_user_id_foreign` (`user_id`),
  KEY `subscriptions_customer_details_id_foreign` (`customer_details_id`),
  CONSTRAINT `subscriptions_customer_details_id_foreign` FOREIGN KEY (`customer_details_id`) REFERENCES `customer_details` (`id`),
  CONSTRAINT `subscriptions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subscriptions`
--

LOCK TABLES `subscriptions` WRITE;
/*!40000 ALTER TABLE `subscriptions` DISABLE KEYS */;
INSERT INTO `subscriptions` VALUES (3,1,1,'2023-03-27 17:08:58','2023-03-27 17:08:58',NULL),(10,6,1,'2023-03-31 01:22:24','2023-03-31 01:22:24',NULL),(12,6,1,'2023-03-31 03:36:34','2023-03-31 03:36:34','2023-03-31'),(13,6,1,'2023-03-31 03:36:36','2023-03-31 03:36:36',NULL),(14,6,1,'2023-03-31 03:36:37','2023-03-31 03:36:37',NULL),(15,6,1,'2023-01-31 22:00:00','2023-03-31 03:37:04',NULL),(16,6,1,'2023-01-31 22:00:00','2023-03-31 03:37:07',NULL),(17,6,1,'2023-02-22 22:00:00','2023-03-31 03:37:12',NULL),(19,6,1,'2023-02-22 22:00:00','2023-03-31 03:37:18',NULL),(20,6,1,'2023-03-22 22:00:00','2023-03-31 03:37:26',NULL);
/*!40000 ALTER TABLE `subscriptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `twilio_sms`
--

DROP TABLE IF EXISTS `twilio_sms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `twilio_sms` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sid` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direction` enum('sent','received') COLLATE utf8mb4_unicode_ci NOT NULL,
  `from` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `to` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` varchar(1600) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('request_error','accepted','queued','sending','sent','receiving','received','delivered','undelivered','failed','read') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'request_error',
  `to_user_id` int unsigned NOT NULL,
  `coupon_id` int unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `twilio_sms_sid_unique` (`sid`),
  KEY `twilio_sms_from_index` (`from`),
  KEY `twilio_sms_to_index` (`to`),
  KEY `twilio_sms_to_user_id_foreign` (`to_user_id`),
  KEY `twilio_sms_coupon_id_foreign` (`coupon_id`),
  CONSTRAINT `twilio_sms_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`),
  CONSTRAINT `twilio_sms_to_user_id_foreign` FOREIGN KEY (`to_user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `twilio_sms`
--

LOCK TABLES `twilio_sms` WRITE;
/*!40000 ALTER TABLE `twilio_sms` DISABLE KEYS */;
INSERT INTO `twilio_sms` VALUES (3,'SM7f0ce1e56addad5fc418861dbb402a6c','sent','+15075025744','+27713400456','Sent from your Twilio trial account - TEXTING DISCOUNTS: You have received a new coupon becuase you are subscripted to: John\'s Brewery. Visit https://textingdiscounts.thecodekitchen.co.za/redeem/19 to claim!','delivered',1,1,'2023-03-31 04:32:13','2023-03-31 04:32:16'),(5,'SM7f0ce1e56daddad5fc418861dbb402a6c','sent','+15075025744','+27713400456','Sent from your Twilio trial account - TEXTING DISCOUNTS: You have received a new coupon becuase you are subscripted to: John\'s Brewery. Visit https://textingdiscounts.thecodekitchen.co.za/redeem/19 to claim!','delivered',4,1,'2023-03-31 04:32:13','2023-03-31 04:32:16'),(6,'SM7f0ce1e56daddad5fc4d18861dbb402a6c','sent','+15075025744','+27713400456','Sent from your Twilio trial account - TEXTING DISCOUNTS: You have received a new coupon becuase you are subscripted to: John\'s Brewery. Visit https://textingdiscounts.thecodekitchen.co.za/redeem/19 to claim!','sent',4,1,'2023-03-31 04:32:13','2023-03-31 04:32:16'),(7,'SM7f0ce1e56daddad5fwc4d18861dbb402a6c','sent','+15075025744','+27713400456','Sent from your Twilio trial account - TEXTING DISCOUNTS: You have received a new coupon becuase you are subscripted to: John\'s Brewery. Visit https://textingdiscounts.thecodekitchen.co.za/redeem/19 to claim!','delivered',4,1,'2023-03-31 04:32:13','2023-03-31 04:32:16'),(8,'SM7f0sce1e56daddad5fwc4d18861dbb402sa6c','sent','+15075025744','+27713400456','Sent from your Twilio trial account - TEXTING DISCOUNTS: You have received a new coupon becuase you are subscripted to: John\'s Brewery. Visit https://textingdiscounts.thecodekitchen.co.za/redeem/19 to claim!','failed',4,1,'2023-03-31 04:32:13','2023-03-31 04:32:16'),(9,'SM7f0sce1e56daddad5fwc4d18861dbbs402sa6c','sent','+15075025744','+27713400456','Sent from your Twilio trial account - TEXTING DISCOUNTS: You have received a new coupon becuase you are subscripted to: John\'s Brewery. Visit https://textingdiscounts.thecodekitchen.co.za/redeem/19 to claim!','failed',4,1,'2023-03-31 04:32:13','2023-03-31 04:32:16'),(10,'SM7f0sce1e56daddad5fwsc4d18861dbbs402sa6c','sent','+15075025744','+27713400456','Sent from your Twilio trial account - TEXTING DISCOUNTS: You have received a new coupon becuase you are subscripted to: John\'s Brewery. Visit https://textingdiscounts.thecodekitchen.co.za/redeem/19 to claim!','failed',4,1,'2023-03-31 04:32:13','2023-03-31 04:32:16'),(11,'SM7f0sce1e56daddad5fwsdc4d18861dbbs402sa6c','sent','+15075025744','+27713400456','Sent from your Twilio trial account - TEXTING DISCOUNTS: You have received a new coupon becuase you are subscripted to: John\'s Brewery. Visit https://textingdiscounts.thecodekitchen.co.za/redeem/19 to claim!','failed',4,2,'2023-03-31 04:32:13','2023-03-31 04:32:16'),(12,'SM7f0sce1ed56daddad5fwsdc4d18861dbbs402sa6c','sent','+15075025744','+27713400456','Sent from your Twilio trial account - TEXTING DISCOUNTS: You have received a new coupon becuase you are subscripted to: John\'s Brewery. Visit https://textingdiscounts.thecodekitchen.co.za/redeem/19 to claim!','failed',4,2,'2023-03-31 04:32:13','2023-03-31 04:32:16'),(13,'SM7f0sce1ed56daddads5fwsdc4d18861dbbs402sa6c','sent','+15075025744','+27713400456','Sent from your Twilio trial account - TEXTING DISCOUNTS: You have received a new coupon becuase you are subscripted to: John\'s Brewery. Visit https://textingdiscounts.thecodekitchen.co.za/redeem/19 to claim!','failed',4,2,'2023-03-31 04:32:13','2023-03-31 04:32:16');
/*!40000 ALTER TABLE `twilio_sms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `twilio_sms_log`
--

DROP TABLE IF EXISTS `twilio_sms_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `twilio_sms_log` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `twilio_sms_id` bigint unsigned DEFAULT NULL,
  `sms_sid` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sms_message_sid` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event` enum('send_sms_request','send_sms_request_error','message_received','segment_status_changed','status_changed','invalid_request_sid_not_defined','twilio_sms_not_found','generic_error','not_categorized') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'not_categorized',
  `new_status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `twilio_sms_log_twilio_sms_id_index` (`twilio_sms_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `twilio_sms_log`
--

LOCK TABLES `twilio_sms_log` WRITE;
/*!40000 ALTER TABLE `twilio_sms_log` DISABLE KEYS */;
INSERT INTO `twilio_sms_log` VALUES (7,3,'SM7f0ce1e56addad5fc418861dbb402a6c','SM7f0ce1e56addad5fc418861dbb402a6c','send_sms_request','queued','{\"to\": \"+27713400456\", \"sid\": \"SM7f0ce1e56addad5fc418861dbb402a6c\", \"uri\": \"/2010-04-01/Accounts/AC78f98655e2aecee92d2a4f5dcb8c59fb/Messages/SM7f0ce1e56addad5fc418861dbb402a6c.json\", \"body\": \"Sent from your Twilio trial account - TEXTING DISCOUNTS: You have received a new coupon becuase you are subscripted to: John\'s Brewery. Visit https://textingdiscounts.thecodekitchen.co.za/redeem/19 to claim!\", \"from\": \"+15075025744\", \"price\": null, \"status\": \"queued\", \"dateSent\": null, \"numMedia\": \"0\", \"direction\": \"outbound-api\", \"errorCode\": null, \"priceUnit\": \"USD\", \"accountSid\": \"AC78f98655e2aecee92d2a4f5dcb8c59fb\", \"apiVersion\": \"2010-04-01\", \"dateCreated\": {\"date\": \"2023-03-30 23:32:13.000000\", \"timezone\": \"+00:00\", \"timezone_type\": 1}, \"dateUpdated\": {\"date\": \"2023-03-30 23:32:13.000000\", \"timezone\": \"+00:00\", \"timezone_type\": 1}, \"numSegments\": \"2\", \"errorMessage\": null, \"subresourceUris\": {\"media\": \"/2010-04-01/Accounts/AC78f98655e2aecee92d2a4f5dcb8c59fb/Messages/SM7f0ce1e56addad5fc418861dbb402a6c/Media.json\"}, \"messagingServiceSid\": null}','2023-03-31 06:32:13','2023-03-31 06:32:13'),(8,3,'SM7f0ce1e56addad5fc418861dbb402a6c','SM7f0ce1e56addad5fc418861dbb402a6c','status_changed','sent','{\"To\": \"+27713400456\", \"From\": \"+15075025744\", \"SmsSid\": \"SM7f0ce1e56addad5fc418861dbb402a6c\", \"SmsStatus\": \"sent\", \"AccountSid\": \"AC78f98655e2aecee92d2a4f5dcb8c59fb\", \"ApiVersion\": \"2010-04-01\", \"MessageSid\": \"SM7f0ce1e56addad5fc418861dbb402a6c\", \"MessageStatus\": \"sent\"}','2023-03-31 06:32:15','2023-03-31 06:32:15'),(9,3,'SM7f0ce1e56addad5fc418861dbb402a6c','SM7f0ce1e56addad5fc418861dbb402a6c','status_changed','delivered','{\"To\": \"+27713400456\", \"From\": \"+15075025744\", \"SmsSid\": \"SM7f0ce1e56addad5fc418861dbb402a6c\", \"SmsStatus\": \"delivered\", \"AccountSid\": \"AC78f98655e2aecee92d2a4f5dcb8c59fb\", \"ApiVersion\": \"2010-04-01\", \"MessageSid\": \"SM7f0ce1e56addad5fc418861dbb402a6c\", \"MessageStatus\": \"delivered\", \"RawDlrDoneDate\": \"2303310132\"}','2023-03-31 06:32:16','2023-03-31 06:32:16'),(10,NULL,NULL,NULL,'send_sms_request_error',NULL,'{\"error_message\": \"[HTTP 400] Unable to create record: The StatusCallback URL http://localhost:8000/api/twilio/webhook/status-changed is not a valid URL.\"}','2023-03-31 09:59:47','2023-03-31 09:59:47'),(11,NULL,NULL,NULL,'send_sms_request_error',NULL,'{\"error_message\": \"[HTTP 400] Unable to create record: The StatusCallback URL http://localhost:8000/api/twilio/webhook/status-changed is not a valid URL.\"}','2023-03-31 09:59:48','2023-03-31 09:59:48'),(12,NULL,NULL,NULL,'send_sms_request_error',NULL,'{\"error_message\": \"[HTTP 400] Unable to create record: The StatusCallback URL http://localhost:8000/api/twilio/webhook/status-changed is not a valid URL.\"}','2023-03-31 10:03:22','2023-03-31 10:03:22'),(13,NULL,NULL,NULL,'send_sms_request_error',NULL,'{\"error_message\": \"[HTTP 400] Unable to create record: The StatusCallback URL http://localhost:8000/api/twilio/webhook/status-changed is not a valid URL.\"}','2023-03-31 10:03:24','2023-03-31 10:03:24'),(14,NULL,NULL,NULL,'send_sms_request_error',NULL,'{\"error_message\": \"[HTTP 400] Unable to create record: The StatusCallback URL http://localhost:8000/api/twilio/webhook/status-changed is not a valid URL.\"}','2023-03-31 10:04:13','2023-03-31 10:04:13'),(15,NULL,NULL,NULL,'send_sms_request_error',NULL,'{\"error_message\": \"[HTTP 400] Unable to create record: The StatusCallback URL http://localhost:8000/api/twilio/webhook/status-changed is not a valid URL.\"}','2023-03-31 10:04:15','2023-03-31 10:04:15'),(16,NULL,'SM1f908c26f9c3f38369440bf8d4e98f28','SM1f908c26f9c3f38369440bf8d4e98f28','send_sms_request_error','queued','{\"to\": \"+27713400456\", \"sid\": \"SM1f908c26f9c3f38369440bf8d4e98f28\", \"uri\": \"/2010-04-01/Accounts/AC78f98655e2aecee92d2a4f5dcb8c59fb/Messages/SM1f908c26f9c3f38369440bf8d4e98f28.json\", \"body\": \"Sent from your Twilio trial account - TEXTING DISCOUNTS: You have received a new coupon becuase you are subscripted to: John\'s Brewery. Visit http://localhost:8000/redeem/8 to claim!\", \"from\": \"+15075025744\", \"price\": null, \"status\": \"queued\", \"dateSent\": null, \"numMedia\": \"0\", \"direction\": \"outbound-api\", \"errorCode\": null, \"priceUnit\": \"USD\", \"accountSid\": \"AC78f98655e2aecee92d2a4f5dcb8c59fb\", \"apiVersion\": \"2010-04-01\", \"dateCreated\": {\"date\": \"2023-03-31 12:06:21.000000\", \"timezone\": \"+00:00\", \"timezone_type\": 1}, \"dateUpdated\": {\"date\": \"2023-03-31 12:06:21.000000\", \"timezone\": \"+00:00\", \"timezone_type\": 1}, \"numSegments\": \"2\", \"errorMessage\": null, \"error_message\": \"SQLSTATE[HY000]: General error: 1364 Field \'to_user_id\' doesn\'t have a default value (SQL: insert into `twilio_sms` (`sid`, `direction`, `from`, `to`, `status`, `body`, `updated_at`, `created_at`) values (SM1f908c26f9c3f38369440bf8d4e98f28, sent, +15075025744, +27713400456, queued, Sent from your Twilio trial account - TEXTING DISCOUNTS: You have received a new coupon becuase you are subscripted to: John\'s Brewery. Visit http://localhost:8000/redeem/8 to claim!, 2023-03-31 12:06:21, 2023-03-31 12:06:21))\", \"subresourceUris\": {\"media\": \"/2010-04-01/Accounts/AC78f98655e2aecee92d2a4f5dcb8c59fb/Messages/SM1f908c26f9c3f38369440bf8d4e98f28/Media.json\"}, \"messagingServiceSid\": null}','2023-03-31 10:06:21','2023-03-31 10:06:21'),(17,NULL,'SM1f908c26f9c3f38369440bf8d4e98f28','SM1f908c26f9c3f38369440bf8d4e98f28','send_sms_request_error','queued','{\"to\": \"+27713400456\", \"sid\": \"SM1f908c26f9c3f38369440bf8d4e98f28\", \"uri\": \"/2010-04-01/Accounts/AC78f98655e2aecee92d2a4f5dcb8c59fb/Messages/SM1f908c26f9c3f38369440bf8d4e98f28.json\", \"body\": \"Sent from your Twilio trial account - TEXTING DISCOUNTS: You have received a new coupon becuase you are subscripted to: John\'s Brewery. Visit http://localhost:8000/redeem/8 to claim!\", \"from\": \"+15075025744\", \"price\": null, \"status\": \"queued\", \"dateSent\": null, \"numMedia\": \"0\", \"direction\": \"outbound-api\", \"errorCode\": null, \"priceUnit\": \"USD\", \"accountSid\": \"AC78f98655e2aecee92d2a4f5dcb8c59fb\", \"apiVersion\": \"2010-04-01\", \"dateCreated\": {\"date\": \"2023-03-31 12:06:21.000000\", \"timezone\": \"+00:00\", \"timezone_type\": 1}, \"dateUpdated\": {\"date\": \"2023-03-31 12:06:21.000000\", \"timezone\": \"+00:00\", \"timezone_type\": 1}, \"numSegments\": \"2\", \"errorMessage\": null, \"error_message\": \"[HTTP 400] Unable to create record: The \'To\' number +122222 is not a valid phone number.\", \"subresourceUris\": {\"media\": \"/2010-04-01/Accounts/AC78f98655e2aecee92d2a4f5dcb8c59fb/Messages/SM1f908c26f9c3f38369440bf8d4e98f28/Media.json\"}, \"messagingServiceSid\": null}','2023-03-31 10:06:22','2023-03-31 10:06:22');
/*!40000 ALTER TABLE `twilio_sms_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `verification_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `unsubbed_at` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_phone_unique` (`phone`),
  UNIQUE KEY `users_verification_code_unique` (`verification_code`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Sanushen Govender','27713400456',NULL,NULL,'$2y$10$.XoQgomEpNFbFGyEyGc0ZOhHFrHN2L5Vid/Qpf5hD/VKQeqZjuKJW','bFipukUEh9ROohkWPrqLKKZgXaN0Cn4suuBAUgLrTIZQ6Z0mR3hTqoLiDsnd','2023-03-16 17:28:48','2023-03-16 17:28:48',NULL,NULL),(2,'John Smith','277134',NULL,NULL,'$2y$10$gslcbz.Soteaoc.ffNg9IugCO2jZOZqk/y3Kxjuh2AwcfR68XgHxO','ml0LXnHiZNTxyHbWuX4bO8C6eIl3gfDlgtOK8PaXJt79vpfyB5G2MdubNdCw','2023-03-22 10:33:12','2023-03-22 10:33:12',NULL,NULL),(3,'1h1qnVi7nn','1000000',NULL,NULL,'$2y$10$Cn1FUHviSn3h/8gHoaOsgOlo18ZwoplmnbQAAMrw8LQ8K8BOVBoFW',NULL,NULL,NULL,NULL,NULL),(4,'iamatest','123123123',NULL,NULL,'$2y$10$RzGnW2JbHkY46zFttbodyu8HcVzxPy8.eeUPNjUAf9OmwrsDV7ArO',NULL,'2023-03-29 19:37:11','2023-03-29 19:37:11',NULL,NULL),(5,'iamatest2','12312312322',NULL,NULL,'$2y$10$pUOeBU/a4I49uaaO.opAHe5sSy2hCj0SqzKBSz06By5Jq6p67Wlj.',NULL,'2023-03-29 19:38:04','2023-03-29 19:38:04',NULL,NULL),(6,'tete','22222',NULL,NULL,'$2y$10$QcmTBcLBuUYRkWM2gQ7m/.d1oheo06s082wXbwz.bTpzgLoDf.GXa',NULL,'2023-03-31 01:12:10','2023-03-31 01:12:10',NULL,NULL);
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

-- Dump completed on 2023-03-31 14:30:14

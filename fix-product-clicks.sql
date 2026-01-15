-- Fix product_clicks table structure
-- Run this SQL on your server database

-- First, backup existing data (if any)
CREATE TABLE IF NOT EXISTS product_clicks_backup AS SELECT * FROM product_clicks;

-- Drop the problematic table
DROP TABLE IF EXISTS product_clicks;

-- Recreate with correct structure
CREATE TABLE `product_clicks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) unsigned NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_clicks_product_id_date_index` (`product_id`,`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- If you had backed up data and want to restore it:
-- INSERT INTO product_clicks (product_id, date) SELECT product_id, date FROM product_clicks_backup;

-- Optional: Drop backup table after verification
-- DROP TABLE IF EXISTS product_clicks_backup;

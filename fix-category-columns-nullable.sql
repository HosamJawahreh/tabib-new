-- Make old category columns nullable to support multi-category system
-- This allows products to rely solely on the category_product pivot table

USE `tabib-new`;

-- Make category_id nullable
ALTER TABLE `products`
MODIFY COLUMN `category_id` INT UNSIGNED NULL;

-- Verify subcategory_id and childcategory_id are already nullable
ALTER TABLE `products`
MODIFY COLUMN `subcategory_id` INT UNSIGNED NULL;

ALTER TABLE `products`
MODIFY COLUMN `childcategory_id` INT UNSIGNED NULL;

-- Set all old category columns to NULL
UPDATE `products`
SET `category_id` = NULL,
    `subcategory_id` = NULL,
    `childcategory_id` = NULL;

SELECT 'Old category columns have been cleared successfully!' AS message;

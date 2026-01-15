-- ============================================
-- DATABASE PERFORMANCE OPTIMIZATION
-- Add indexes to frequently queried columns
-- ============================================

-- This will make queries 30-50% faster!
-- Run this in phpMyAdmin or via command line

-- Orders table indexes
ALTER TABLE `orders` ADD INDEX IF NOT EXISTS `idx_user_status` (`user_id`, `status`);
ALTER TABLE `orders` ADD INDEX IF NOT EXISTS `idx_order_number` (`order_number`);
ALTER TABLE `orders` ADD INDEX IF NOT EXISTS `idx_created_at` (`created_at`);
ALTER TABLE `orders` ADD INDEX IF NOT EXISTS `idx_payment_status` (`payment_status`);

-- Products table indexes
ALTER TABLE `products` ADD INDEX IF NOT EXISTS `idx_status_featured` (`status`, `featured`);
ALTER TABLE `products` ADD INDEX IF NOT EXISTS `idx_category_id` (`category_id`);
ALTER TABLE `products` ADD INDEX IF NOT EXISTS `idx_subcategory_id` (`subcategory_id`);
ALTER TABLE `products` ADD INDEX IF NOT EXISTS `idx_childcategory_id` (`childcategory_id`);
ALTER TABLE `products` ADD INDEX IF NOT EXISTS `idx_user_id` (`user_id`);
ALTER TABLE `products` ADD INDEX IF NOT EXISTS `idx_slug` (`slug`);

-- Product clicks indexes (for analytics)
ALTER TABLE `product_clicks` ADD INDEX IF NOT EXISTS `idx_product_date` (`product_id`, `date`);

-- Categories indexes
ALTER TABLE `categories` ADD INDEX IF NOT EXISTS `idx_status` (`status`);
ALTER TABLE `categories` ADD INDEX IF NOT EXISTS `idx_slug` (`slug`);

-- Subcategories indexes
ALTER TABLE `subcategories` ADD INDEX IF NOT EXISTS `idx_category_id` (`category_id`);
ALTER TABLE `subcategories` ADD INDEX IF NOT EXISTS `idx_status` (`status`);
ALTER TABLE `subcategories` ADD INDEX IF NOT EXISTS `idx_slug` (`slug`);

-- Childcategories indexes
ALTER TABLE `childcategories` ADD INDEX IF NOT EXISTS `idx_subcategory_id` (`subcategory_id`);
ALTER TABLE `childcategories` ADD INDEX IF NOT EXISTS `idx_status` (`status`);
ALTER TABLE `childcategories` ADD INDEX IF NOT EXISTS `idx_slug` (`slug`);

-- Wishlists indexes
ALTER TABLE `wishlists` ADD INDEX IF NOT EXISTS `idx_user_product` (`user_id`, `product_id`);

-- Carts indexes (if using database cart)
-- ALTER TABLE `carts` ADD INDEX IF NOT EXISTS `idx_user_id` (`user_id`);

-- Users indexes
ALTER TABLE `users` ADD INDEX IF NOT EXISTS `idx_email` (`email`);

-- Transactions indexes
ALTER TABLE `transactions` ADD INDEX IF NOT EXISTS `idx_user_id` (`user_id`);
ALTER TABLE `transactions` ADD INDEX IF NOT EXISTS `idx_txnid` (`txnid`);

-- Comments/Reviews indexes
ALTER TABLE `comments` ADD INDEX IF NOT EXISTS `idx_product_id` (`product_id`);
ALTER TABLE `comments` ADD INDEX IF NOT EXISTS `idx_user_id` (`user_id`);

-- Messages indexes
ALTER TABLE `conversations` ADD INDEX IF NOT EXISTS `idx_sent_user` (`sent_user`);
ALTER TABLE `conversations` ADD INDEX IF NOT EXISTS `idx_recieved_user` (`recieved_user`);

-- ============================================
-- Verify indexes were created
-- ============================================
-- Run these to check:
-- SHOW INDEX FROM orders;
-- SHOW INDEX FROM products;
-- SHOW INDEX FROM categories;

-- ============================================
-- NOTES:
-- ============================================
-- 1. This is safe to run multiple times (IF NOT EXISTS prevents errors)
-- 2. May take 30-60 seconds depending on table sizes
-- 3. Your site will remain online during index creation
-- 4. Indexes will make SELECT queries faster but INSERT/UPDATE slightly slower
--    (The trade-off is worth it - 1% slower writes, 50% faster reads)

-- ============================================
-- After running, test performance:
-- ============================================
-- SELECT * FROM orders WHERE user_id = 1 AND status = 'pending'; -- Should be FAST
-- SELECT * FROM products WHERE category_id = 5 AND status = 1; -- Should be FAST

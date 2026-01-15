-- Fix currency_name column size and correct the typo
-- This fixes the error: Data too long for column 'currency_name' at row 1

-- 1. Increase currency_name column size in orders table
ALTER TABLE `orders`
MODIFY COLUMN `currency_name` VARCHAR(50) DEFAULT NULL;

-- 2. Fix the typo in currencies table: "Joradainain" -> "Jordanian"
UPDATE `currencies`
SET `name` = 'Jordanian Dinar'
WHERE `name` = 'Joradainain Dinar';

-- 3. Verify the changes
SELECT id, sign, name, value, is_default FROM currencies WHERE sign = 'JD';
SHOW COLUMNS FROM orders LIKE 'currency_name';

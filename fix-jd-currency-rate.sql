-- Fix JD currency conversion rate
-- Prices are already in JD, so conversion rate should be 1, not 0.71

-- Update JD currency value to 1
UPDATE `currencies`
SET `value` = 1
WHERE `sign` = 'JD';

-- Verify the update
SELECT id, sign, name, value, is_default
FROM currencies
WHERE sign = 'JD';

-- Expected result:
-- id | sign | name            | value | is_default
-- 12 | JD   | Jordanian Dinar | 1     | 1

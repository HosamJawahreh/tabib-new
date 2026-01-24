-- ============================================
-- DATABASE PROTECTION TRIGGERS
-- Prevents catastrophic translation updates
-- ============================================

-- Drop existing triggers if they exist
DROP TRIGGER IF EXISTS prevent_bulk_translation_update;
DROP TRIGGER IF EXISTS prevent_test_translations;
DROP TRIGGER IF EXISTS log_translation_changes;

-- Create audit log table
CREATE TABLE IF NOT EXISTS translation_audit_log (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    action VARCHAR(50) NOT NULL,
    user_id INT UNSIGNED NULL,
    product_id BIGINT UNSIGNED NULL,
    old_value TEXT NULL,
    new_value TEXT NULL,
    lang_code VARCHAR(10) NULL,
    ip_address VARCHAR(45) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_created_at (created_at),
    INDEX idx_product_id (product_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TRIGGER 1: Prevent "test" values
-- ============================================
DELIMITER $$

CREATE TRIGGER prevent_test_translations
BEFORE INSERT ON ec_products_translations
FOR EACH ROW
BEGIN
    -- Block if trying to insert "test" or empty/null in production
    IF NEW.name = 'test' OR NEW.name = '' OR NEW.name IS NULL THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'ERROR: Cannot save translation with value "test" or empty. Please provide a valid translation.';
    END IF;

    -- Block if trying to insert very short names (likely placeholders)
    IF CHAR_LENGTH(NEW.name) < 2 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'ERROR: Translation name too short. Minimum 2 characters required.';
    END IF;
END$$

DELIMITER ;

-- ============================================
-- TRIGGER 2: Prevent test values on UPDATE
-- ============================================
DELIMITER $$

CREATE TRIGGER prevent_test_translations_update
BEFORE UPDATE ON ec_products_translations
FOR EACH ROW
BEGIN
    -- Block if trying to update to "test"
    IF NEW.name = 'test' AND OLD.name != 'test' THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'ERROR: Cannot update translation to "test". Please provide a valid translation.';
    END IF;

    -- Block if trying to clear translation
    IF (NEW.name = '' OR NEW.name IS NULL) AND (OLD.name != '' AND OLD.name IS NOT NULL) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'ERROR: Cannot clear existing translation. Use DELETE if you want to remove it.';
    END IF;
END$$

DELIMITER ;

-- ============================================
-- TRIGGER 3: Audit Log for all changes
-- ============================================
DELIMITER $$

CREATE TRIGGER log_translation_changes
AFTER UPDATE ON ec_products_translations
FOR EACH ROW
BEGIN
    -- Log all translation changes
    INSERT INTO translation_audit_log (
        action,
        product_id,
        old_value,
        new_value,
        lang_code
    ) VALUES (
        'UPDATE',
        NEW.ec_products_id,
        OLD.name,
        NEW.name,
        NEW.lang_code
    );
END$$

DELIMITER ;

-- ============================================
-- STORED PROCEDURE: Safe Bulk Update
-- ============================================
DELIMITER $$

CREATE PROCEDURE safe_bulk_translation_update(
    IN p_lang_code VARCHAR(10),
    IN p_new_value VARCHAR(255),
    IN p_confirmation_code VARCHAR(50)
)
BEGIN
    DECLARE affected_rows INT;

    -- Verify confirmation code
    IF p_confirmation_code != CONCAT('CONFIRM-', DATE_FORMAT(NOW(), '%Y%m%d')) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'ERROR: Invalid confirmation code. Bulk updates require daily confirmation code.';
    END IF;

    -- Prevent bulk update to test or empty
    IF p_new_value = 'test' OR p_new_value = '' OR p_new_value IS NULL THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'ERROR: Cannot bulk update to invalid value.';
    END IF;

    -- Get count of affected rows
    SELECT COUNT(*) INTO affected_rows
    FROM ec_products_translations
    WHERE lang_code = p_lang_code;

    -- If affecting more than 100 rows, require additional confirmation
    IF affected_rows > 100 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = CONCAT('ERROR: This would affect ', affected_rows, ' translations. Use admin panel for bulk operations.');
    END IF;
END$$

DELIMITER ;

-- ============================================
-- SUCCESS MESSAGE
-- ============================================
SELECT 'Protection triggers installed successfully!' AS Status;
SELECT 'Translation audit log table created!' AS Status;
SELECT 'Attempting to insert "test" will now be BLOCKED!' AS Status;

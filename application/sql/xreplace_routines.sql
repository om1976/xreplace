DELIMITER ;;
CREATE PROCEDURE `copy_sample_category`(IN user_id VARCHAR(40), sample_category_id INT, OUT new_category_id INT)
BEGIN

    DECLARE done INT DEFAULT FALSE;
    DECLARE new_group_id, _id, _order INT;
    DECLARE _name, _type, _global VARCHAR(128);
    DECLARE curs CURSOR FOR  SELECT `id`, `name`, `type`, `global`, `order` FROM `ed_groups` WHERE `category_id` = sample_category_id;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
    DECLARE EXIT HANDLER FOR SQLEXCEPTION 
        BEGIN
              ROLLBACK;
        END;

    START TRANSACTION;
    
        INSERT INTO `ed_categories` 
        (`name`, `added_at`, `added_by`, `info`) 
        SELECT 
        `name`, NOW(), user_id, `info` 
        FROM `ed_categories` where `id` = sample_category_id;
        
        SET new_category_id = LAST_INSERT_ID();
        
        OPEN curs;

        group_loop: LOOP
            FETCH curs INTO _id, _name, _type, _global, _order;
                IF done THEN
                    CLOSE curs;
                    LEAVE group_loop;
                END IF;
            INSERT INTO `ed_groups` 
                (`category_id`, `name`, `type`, `global`, `added_at`, `added_by`, `order`) 
                VALUES 
                (new_category_id, _name, _type, _global, NOW(), user_id, _order);
            
            SET new_group_id = LAST_INSERT_ID();
            
            INSERT INTO `ed_rules`
                (`group_id`, `pattern`, `separator`, `modifiers`, `replacement`, `description`, `type`, `order`, `deleted`, `added_at`, `added_by`) 
                SELECT 
                new_group_id, `pattern`, `separator`, `modifiers`, `replacement`, `description`, `type`, `order`, `deleted`, NOW(), user_id
                FROM `ed_rules` where `group_id` = _id;
                
        END LOOP;
    
    COMMIT;

END */;;
DELIMITER ;
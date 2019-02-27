/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 10.1.34-MariaDB : Database - cubix_commerce
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/* Procedure structure for procedure `category_parents` */

/*!50003 DROP PROCEDURE IF EXISTS  `category_parents` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `category_parents`(IN _category_id INT)
BEGIN
	DECLARE _parent_id INT;
	DECLARE rv VARCHAR(100);
	DECLARE cm CHAR(1);
	SET cm = '';
	SET rv = '';
	SET _parent_id = (SELECT parent_id FROM sys_category WHERE category_id = _category_id);
	WHILE _parent_id > 0 DO		
		IF _parent_id > 0 THEN
			SET rv = CONCAT(_parent_id,cm,rv);
			SET cm = ',';
		END IF;
		SET _parent_id = (SELECT parent_id FROM sys_category WHERE category_id = _parent_id);
	END WHILE;
	
	IF rv = '' THEN
		SET rv = _category_id;
	ELSE
		SET rv = CONCAT(rv,cm,_category_id);
	END IF;
	
	SET @stmt = CONCAT("UPDATE sys_category SET `parent_ids` = '",rv,"' WHERE category_id = ", _category_id);
	PREPARE statement FROM @stmt;
	EXECUTE statement; 
END */$$
DELIMITER ;

/* Procedure structure for procedure `delete_entity_attribute_values` */

/*!50003 DROP PROCEDURE IF EXISTS  `delete_entity_attribute_values` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `delete_entity_attribute_values`(IN _entity_id INT,IN _attribute_id INT , IN _table VARCHAR(100) )
BEGIN
	SET @stmt = CONCAT("DELETE FROM ",_table," WHERE entity_id = ", _entity_id," AND attribute_id = ", _attribute_id );
	PREPARE statement FROM @stmt;
	EXECUTE statement; 
END */$$
DELIMITER ;

/* Procedure structure for procedure `delete_entity_type_data` */

/*!50003 DROP PROCEDURE IF EXISTS  `delete_entity_type_data` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `delete_entity_type_data`(IN _entity_type_id INT)
BEGIN
	SET @stmt = CONCAT("DELETE 
	  sset, sc, sc2, sc3, sc4, sc5, sc6, sc8, sc9, sc10, sc11, sc12, sc13, sc14, sc15, sc16 ,sme
	FROM
	  `sys_entity_type` sset 
	  LEFT JOIN `sys_category` sc 
	    ON sc.`entity_type_id` = sset.`entity_type_id` 
	  LEFT JOIN `sys_chating` sc2 
	    ON sc2.`entity_type_id` = sset.`entity_type_id` 
	  LEFT JOIN `sys_entity` sc3 
	    ON sc3.`entity_type_id` = sset.`entity_type_id` 
	  LEFT JOIN `sys_entity_attribute` sc4 
	    ON sc4.`entity_type_id` = sset.`entity_type_id` 
	  LEFT JOIN `sys_entity_datetime` sc5 
	    ON sc5.`entity_type_id` = sset.`entity_type_id` 
	  LEFT JOIN `sys_entity_decimal` sc6 
	    ON sc6.`entity_type_id` = sset.`entity_type_id` 
	  LEFT JOIN `sys_entity_extension` sc8 
	    ON sc8.`entity_type_id` = sset.`entity_type_id` 
	  LEFT JOIN `sys_entity_gallery` sc9 
	    ON sc9.`entity_type_id` = sset.`entity_type_id` 
	  LEFT JOIN `sys_entity_history` sc10 
	    ON sc10.`entity_type_id` = sset.`entity_type_id` 
	  LEFT JOIN `sys_entity_int` sc11 
	    ON sc11.`entity_type_id` = sset.`entity_type_id` 
	  LEFT JOIN `sys_entity_notification` sc12 
	    ON sc12.`entity_type_id` = sset.`entity_type_id` 
	  LEFT JOIN `sys_entity_text` sc13 
	    ON sc13.`entity_type_id` = sset.`entity_type_id` 
	  LEFT JOIN `sys_entity_time` sc14 
	    ON sc14.`entity_type_id` = sset.`entity_type_id` 
	  LEFT JOIN `sys_entity_type_extension_map` sc15 
	    ON sc15.`target_entity_type_id` = sset.`entity_type_id` OR sc15.`actor_entity_type_id` = sset.`entity_type_id` 
	  LEFT JOIN `sys_entity_varchar` sc16 
	    ON sc16.`entity_type_id` = sset.`entity_type_id` 
	    LEFT JOIN `sys_module` sme ON sme.`entity_type_id` = sset.`entity_type_id`
	WHERE sset.`entity_type_id` = ",_entity_type_id);
	
	#select @stmt;
	PREPARE statement FROM @stmt;
	EXECUTE statement;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `get_entities_listing` */

/*!50003 DROP PROCEDURE IF EXISTS  `get_entities_listing` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `get_entities_listing`(IN _entity_type_id INT, IN _attribute_code VARCHAR(250))
BEGIN
	DECLARE _attribute_id INT(20);
	DECLARE _data_type VARCHAR(250);
	
	SELECT attribute_id, sys_data_type.type INTO _attribute_id, _data_type FROM sys_attribute 
LEFT JOIN sys_data_type ON sys_data_type.data_type_id = sys_attribute.data_type_id
WHERE attribute_code = _attribute_code;
	
	SET @stmt = CONCAT("SELECT entity_id,value FROM sys_entity_", _data_type, " WHERE entity_type_id = ", _entity_type_id, ' AND deleted_at is NULL', " AND  attribute_id = ",_attribute_id );
	
	#select @stmt;
	PREPARE statement FROM @stmt;
	EXECUTE statement;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `get_item_inventory` */

/*!50003 DROP PROCEDURE IF EXISTS  `get_item_inventory` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `get_item_inventory`(IN _entity_id INT, IN _attribute_code VARCHAR(250))
BEGIN
	DECLARE _attribute_id INT(20);
	DECLARE _data_type VARCHAR(250);
	
	SELECT attribute_id, sys_data_type.type INTO _attribute_id, _data_type FROM sys_attribute 
LEFT JOIN sys_data_type ON sys_data_type.data_type_id = sys_attribute.data_type_id
WHERE attribute_code = _attribute_code;
	
	SET @stmt = CONCAT("SELECT value FROM sys_entity_", _data_type, " WHERE entity_id = ", _entity_id, 
	" AND  attribute_id = ",_attribute_id);
	
	#select @stmt;
	PREPARE statement FROM @stmt;
	EXECUTE statement;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `soft_delete_entity_data` */

/*!50003 DROP PROCEDURE IF EXISTS  `soft_delete_entity_data` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `soft_delete_entity_data`( IN _entity_id INT(10), IN _deleted_at DATETIME)
BEGIN
	
	UPDATE `sys_entity_int` SET deleted_at = _deleted_at WHERE `entity_id` = _entity_id;
	UPDATE `sys_entity_varchar`  SET deleted_at = _deleted_at WHERE `entity_id` = _entity_id ;
	UPDATE `sys_entity_decimal` SET deleted_at = _deleted_at WHERE `entity_id` = _entity_id ;
	UPDATE `sys_entity_text` SET deleted_at = _deleted_at WHERE `entity_id` = _entity_id ;
	UPDATE `sys_entity_time` SET deleted_at = _deleted_at WHERE `entity_id` = _entity_id ;
	UPDATE `sys_entity_datetime` SET deleted_at = _deleted_at WHERE `entity_id` = _entity_id ; 
END */$$
DELIMITER ;

/* Procedure structure for procedure `update_category_product_count` */

/*!50003 DROP PROCEDURE IF EXISTS  `update_category_product_count` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `update_category_product_count`(IN _category_id INT,  IN _count_operator VARCHAR(1))
BEGIN
	#WHILE _category_id > 0 DO
	
		SET @stmt = CONCAT("UPDATE sys_category SET `product_count` = `product_count` ", _count_operator, ' ', "1"," WHERE category_id = ", _category_id);
		SET _category_id = (SELECT parent_id FROM sys_category WHERE category_id = _category_id);
		#select @stmt;
		PREPARE statement FROM @stmt;
		EXECUTE statement; 
		
	#END WHILE;
END */$$
DELIMITER ;

/* Procedure structure for procedure `update_entity_attribute_value` */

/*!50003 DROP PROCEDURE IF EXISTS  `update_entity_attribute_value` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `update_entity_attribute_value`(IN _entity_id INT, IN _attribute_code VARCHAR(250), 
			IN _attribute_value INT)
BEGIN
	DECLARE _attribute_id INT(20);
	DECLARE _data_type VARCHAR(250);
	SELECT attribute_id, sys_data_type.type INTO _attribute_id, _data_type FROM sys_attribute 
LEFT JOIN sys_data_type ON sys_data_type.data_type_id = sys_attribute.data_type_id
WHERE attribute_code = _attribute_code;
	
	SET @stmt = CONCAT("UPDATE sys_entity_", _data_type, " SET `value` = ", _attribute_value, 
	" WHERE entity_id = ", _entity_id, " AND  attribute_id = ",_attribute_id);
	
	#select @stmt;
	PREPARE statement FROM @stmt;
	EXECUTE statement; 
    END */$$
DELIMITER ;

/* Procedure structure for procedure `update_item_inventory` */

/*!50003 DROP PROCEDURE IF EXISTS  `update_item_inventory` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `update_item_inventory`(IN _entity_id INT, IN _attribute_code VARCHAR(250), 
			IN _attribute_value INT, IN _attribute_operator VARCHAR(1))
BEGIN
	DECLARE _attribute_id INT(20);
	DECLARE _data_type VARCHAR(250);
	SELECT attribute_id, sys_data_type.type INTO _attribute_id, _data_type FROM sys_attribute 
LEFT JOIN sys_data_type ON sys_data_type.data_type_id = sys_attribute.data_type_id
WHERE attribute_code = _attribute_code;
	
	SET @stmt = CONCAT("UPDATE sys_entity_", _data_type, " SET `value` = `value` ", _attribute_operator, ' ', _attribute_value, 
	" WHERE entity_id = ", _entity_id, " AND  attribute_id = ",_attribute_id);
	
	#select @stmt;
	PREPARE statement FROM @stmt;
	EXECUTE statement; 
    END */$$
DELIMITER ;

/* Procedure structure for procedure `hard_delete_entity_data` */

/*!50003 DROP PROCEDURE IF EXISTS  `hard_delete_entity_data` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `hard_delete_entity_data`( IN _identifier VARCHAR(100))
BEGIN
	DECLARE _entity_type_id  TINYINT(3);
	SET _entity_type_id = (SELECT entity_type_id FROM sys_entity_type WHERE identifier = CONVERT(_identifier USING utf8) COLLATE utf8_swedish_ci);
	DELETE FROM `sys_entity_int` WHERE `entity_type_id` = _entity_type_id ;
	DELETE FROM `sys_entity_varchar` WHERE `entity_type_id` = _entity_type_id ;
	DELETE FROM `sys_entity_decimal` WHERE `entity_type_id` = _entity_type_id ;
	DELETE FROM `sys_entity_text` WHERE `entity_type_id` = _entity_type_id ;
	DELETE FROM `sys_entity_time` WHERE `entity_type_id` = _entity_type_id ;
	DELETE FROM `sys_entity_datetime` WHERE `entity_type_id` = _entity_type_id ;
	DELETE FROM `sys_entity` WHERE `entity_type_id` = _entity_type_id ;
	SET @stmt = CONCAT("TRUNCATE TABLE ", _identifier, "_flat");
	PREPARE statement FROM @stmt;
	EXECUTE statement;  
END */$$
DELIMITER ;

/* Procedure structure for procedure `update_product_count_in_category` */

/*!50003 DROP PROCEDURE IF EXISTS  `update_product_count_in_category` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `update_product_count_in_category`()
BEGIN
	SET @stmt = CONCAT("UPDATE 
	  `sys_category` sc 
	  LEFT JOIN 
	    (SELECT 
	      sei.`value` AS category_id, COUNT(*) AS count_item 
	    FROM
	      `sys_entity_int` sei 
	    WHERE sei.attribute_id = 
	      (SELECT 
		attribute_id 
	      FROM
		sys_attribute att 
	      WHERE att.`attribute_code` = 'product_category') 
	      AND sei.entity_type_id = 
	      (SELECT 
		sett.`entity_type_id` 
	      FROM
		sys_entity_type sett 
	      WHERE sett.`identifier` = 'product') 
	    GROUP BY sei.`value`) AS t2 
	    ON t2.category_id = sc.`category_id` SET sc.`product_count` = 
	    CASE
	      WHEN t2.count_item is null 
	      THEN 0 
	      ELSE t2.count_item 
	    END");
	    PREPARE statement FROM @stmt;
	    EXECUTE statement; 
END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

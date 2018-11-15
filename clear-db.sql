CALL hard_delete_entity_data('order')
CALL hard_delete_entity_data('order_item')
CALL hard_delete_entity_data('order_dropoff')
CALL hard_delete_entity_data('order_pickup')
CALL hard_delete_entity_data('order_trucks')
CALL hard_delete_entity_data('order_history')
CALL hard_delete_entity_data('order_driver_location')
CALL hard_delete_entity_data('customer')
CALL hard_delete_entity_data('shifts')
CALL hard_delete_entity_data('item')
CALL hard_delete_entity_data('truck_selected')
CALL hard_delete_entity_data('truck_suggested')
CALL hard_delete_entity_data('customer')
CALL hard_delete_entity_data('truck')
CALL hard_delete_entity_data('vehicle')
CALL hard_delete_entity_data('truck_class')
CALL hard_delete_entity_data('delivery_professional')
CALL hard_delete_entity_data('city')
CALL hard_delete_entity_data('cart_item');
CALL hard_delete_entity_data('custom_notification');

DELETE FROM pl_attachment WHERE attachment_type_id = 8;
SELECT COUNT(attachment_id) FROM pl_attachment WHERE entity_id <> 0 AND entity_id NOT IN (SELECT entity_id FROM sys_entity);
DELETE FROM sys_attribute WHERE linked_entity_type_id > 0 AND linked_entity_type_id  NOT IN (SELECT entity_type_id FROM sys_entity_type);
DELETE FROM sys_entity_attribute WHERE entity_type_id NOT IN (SELECT entity_type_id FROM sys_entity_type);
DELETE FROM sys_attribute_option WHERE attribute_id > 0 AND attribute_id NOT IN (SELECT attribute_id FROM sys_attribute);
DELETE FROM  sys_entity_attribute WHERE attribute_id > 0 AND attribute_id NOT IN (SELECT attribute_id FROM sys_attribute);
DELETE FROM sys_entity_role WHERE entity_id NOT IN (SELECT entity_id FROM sys_entity)
SELECT * FROM sys_entity_attribute WHERE entity_type_id > 0 AND entity_type_id NOT IN (SELECT entity_type_id FROM sys_entity_type);

DELETE FROM sys_entity_role WHERE entity_id > 0 AND entity_id  NOT IN (SELECT entity_id FROM sys_entity);

SELECT *  FROM sys_role_permission_map WHERE role_id > 0 AND role_id NOT IN (SELECT role_id FROM sys_role);
DELETE FROM sys_entity_history WHERE entity_id <> 0 AND entity_id NOT IN (SELECT entity_id FROM sys_entity);
DELETE FROM sys_entity_history WHERE actor_entity_id <> 0 AND actor_entity_id NOT IN (SELECT entity_id FROM sys_entity);
DELETE FROM sys_entity_notification WHERE entity_history_id <> 0 AND entity_history_id NOT IN (SELECT entity_history_id FROM sys_entity_history);
DELETE FROM api_token WHERE entity_id <> 0 AND entity_id NOT IN (SELECT entity_id FROM sys_entity);
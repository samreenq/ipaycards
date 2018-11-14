
insert into `api_method` (`type`, `name`, `uri`, `mask_uri`, `method`, `schema`, `description`, `plugin_identifier`, `order`, `type_id`, `is_active`, `is_token_required`, `created_at`) values('get','Extension : {plugin_name} : Type : Listing','{api_base_route}/type/listing','','',NULL,'API call to retrieve available post types','ext_post','1','0','1','0','{wildcard_datetime}');

insert into `api_method_field` (`method_uri`, `request_type`, `type`, `data_type`, `name`, `description`, `element_type`, `is_read_only`, `is_search`, `element_validation_type`, `depend_table`, `depend_table_id`, `depend_table_where`, `depend_table_title`, `depend_table_value`, `is_entity_auth`, `default_value`, `is_active`, `order`, `created_at`) values('{api_base_route}/type/listing','get','required','int','target_entity_type_id','Target Entity Type ID','option','0','1','string','sys_entity_type','0',NULL,NULL,'entity_type_id','0','','1','1','{wildcard_datetime}');

insert into `api_method_field` (`method_uri`, `request_type`, `type`, `data_type`, `name`, `description`, `element_type`, `is_read_only`, `is_search`, `element_validation_type`, `depend_table`, `depend_table_id`, `depend_table_where`, `depend_table_title`, `depend_table_value`, `is_entity_auth`, `default_value`, `is_active`, `order`, `created_at`) values('{api_base_route}/type/listing','get','required','int','actor_entity_type_id','Actor Entity Type ID','option','0','1','string','sys_entity_type','0',NULL,NULL,'entity_type_id','0','','1','2','{wildcard_datetime}');


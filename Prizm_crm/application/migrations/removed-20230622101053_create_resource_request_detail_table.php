<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
class Migration_create_resource_request_detail_table extends CI_Migration { 

    public function up()
    {

        $CI = &get_instance();

        if (!$CI->db->table_exists(db_prefix() . 'resource_req_detail')) {
          $CI->db->query('CREATE TABLE `' . db_prefix() . 'resource_req_detail` (
              `id`  int(11)  NOT NULL AUTO_INCREMENT,
              `resource_fk` int(11)  NOT NULL, 
              `item_fk` int(11)  NOT NULL, 
              `total_quantity` int(11)  NOT NULL DEFAULT 0, 
              `status` varchar(20)   NULL DEFAULT "Initial",
              `addedat` datetime NULL DEFAULT NULL, 
              PRIMARY KEY (`id`),
              CONSTRAINT `resource_fkid` FOREIGN KEY (`resource_fk`) REFERENCES `' . db_prefix() . 'resource_request`(`id`),
              CONSTRAINT `myitem_fkid` FOREIGN KEY (`item_fk`) REFERENCES `' . db_prefix() . 'items`(`id`)
              ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
          }

    }

    public function down()
    {
        $this->dbforge->drop_table('resource_req_detail');
    }

}






<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
class Migration_create_project_budget_detail extends CI_Migration { 

    public function up()
    {

        $CI = &get_instance();

        if (!$CI->db->table_exists(db_prefix() . 'project_budget_detail')) {
          $CI->db->query('CREATE TABLE `' . db_prefix() . 'project_budget_detail` (
              `id`  int(11)  NOT NULL AUTO_INCREMENT,
              `budget_fk` int(11)  NOT NULL, 
              `item_fk` int(11)  NOT NULL, 
              `total_quantity` int(11)  NOT NULL DEFAULT 0, 
              `remaining_quantity` int(11)  NOT NULL DEFAULT 0, 
              `item_cost` int(11)  NOT NULL DEFAULT 0, 
              `total_item_cost` int(11)  NOT NULL DEFAULT 0, 
              PRIMARY KEY (`id`),
              CONSTRAINT `budget_fkid` FOREIGN KEY (`budget_fk`) REFERENCES `' . db_prefix() . 'project_budget`(`id`),
              CONSTRAINT `item_fkid` FOREIGN KEY (`item_fk`) REFERENCES `' . db_prefix() . 'items`(`id`)
              ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
          }

    }

    public function down()
    {
        $this->dbforge->drop_table('project_budget_detail');
    }

}






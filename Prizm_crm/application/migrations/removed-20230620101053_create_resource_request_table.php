<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
class Migration_create_resource_request_table extends CI_Migration { 

    public function up()
    {

        $CI = &get_instance();

        if (!$CI->db->table_exists(db_prefix() . 'resource_request')) {
          $CI->db->query('CREATE TABLE `' . db_prefix() . 'resource_request` (
              `id`  int(11)  NOT NULL AUTO_INCREMENT,
              `resource_code` text null default NULL,
              `budget_fk` int(11)  NOT NULL, 
              `staff_fk` int(11)  NOT NULL, 
              `description` text null default NULL,
              `status` varchar(20) null default NULL,
              `addedat` datetime NULL DEFAULT NULL,
              PRIMARY KEY (`id`),
              CONSTRAINT `mybudget_fkkid` FOREIGN KEY (`budget_fk`) REFERENCES `' . db_prefix() . 'project_budget`(`id`),
              CONSTRAINT `myfkkk_staff` FOREIGN KEY (`staff_fk`) REFERENCES `' . db_prefix() . 'staff`(`staffid`)
              ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
          }

    }

    public function down()
    {
        $this->dbforge->drop_table('resource_request');
    }

}






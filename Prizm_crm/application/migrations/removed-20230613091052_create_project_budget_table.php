<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
class Migration_create_project_budget_table extends CI_Migration { 

    public function up()
    {

        $CI = &get_instance();

        if (!$CI->db->table_exists(db_prefix() . 'project_budget')) {
          $CI->db->query('CREATE TABLE `' . db_prefix() . 'project_budget` (
              `id`  int(11)  NOT NULL AUTO_INCREMENT,
              `description` text null default NULL,
              `project_fk` int(11)  NOT NULL, 
              `staff_fk` int(11)  NOT NULL, 
              `addedat` datetime NULL DEFAULT NULL, 
              `status` int(11)  NOT NULL, 
              PRIMARY KEY (`id`),
              CONSTRAINT `project_fkkid` FOREIGN KEY (`project_fk`) REFERENCES `' . db_prefix() . 'projects`(`id`),
              CONSTRAINT `fkkk_staff` FOREIGN KEY (`staff_fk`) REFERENCES `' . db_prefix() . 'staff`(`staffid`)
              ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
          }

    }

    public function down()
    {
        $this->dbforge->drop_table('project_budget');
    }

}






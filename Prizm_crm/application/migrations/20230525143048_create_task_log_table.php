<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
class Migration_create_task_log_table extends CI_Migration { 

    public function up()
    {

        $CI = &get_instance();

        if (!$CI->db->table_exists(db_prefix() . 'tasklog')) {
          $CI->db->query('CREATE TABLE `' . db_prefix() . 'tasklog` (
              `id`  int(11)  NOT NULL AUTO_INCREMENT,
              `logdetail` text null default NULL,
              `fktaskid` int(11)   NULL,
              `fkstaffid` int(11)   NULL,
              `adddate` datetime NULL DEFAULT NULL, 
              PRIMARY KEY (`id`),
              CONSTRAINT `fk_task_id` FOREIGN KEY (`fktaskid`) REFERENCES `' . db_prefix() . 'tasks`(`id`),
              CONSTRAINT `fk_staff_id` FOREIGN KEY (`fkstaffid`) REFERENCES `' . db_prefix() . 'staff`(`staffid`)
              ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
          }

    }

    public function down()
    {
        $this->dbforge->drop_table('tasklog');
    }

}






<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
class Migration_craete_expense_categories_table extends CI_Migration { 

    public function up()
    {

        $CI = &get_instance();

        if (!$CI->db->table_exists(db_prefix() . 'expense_categories')) {
          $CI->db->query('CREATE TABLE `' . db_prefix() . 'expense_categories` (
              `id`  int(11)  NOT NULL AUTO_INCREMENT,
              `name` text null default NULL,
              `addedat` datetime NULL DEFAULT NULL, 
              `status`  int(11)  NOT NULL,
              PRIMARY KEY (`id`)
              ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
          }

    }

    public function down()
    {
        $this->dbforge->drop_table('expense_categories');
    }

}






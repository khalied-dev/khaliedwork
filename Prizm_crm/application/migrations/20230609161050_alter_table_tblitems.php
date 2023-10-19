<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
class Migration_alter_table_tblitems extends CI_Migration { 

 


    public function up()
    {
        $CI = &get_instance();
        $db_prefix = db_prefix();
    
        if ($CI->db->table_exists($db_prefix . 'items')) {
            // Check if the 'jk' column doesn't exist in the 'tblitems' table
            if (!$CI->db->field_exists('expense_cat_fk', $db_prefix . 'items')) {
                // Check if the 'tablesk' table exists
                if ($CI->db->table_exists($db_prefix . 'expense_categories')) {
                    $CI->db->query('ALTER TABLE `' . $db_prefix . 'items` ADD COLUMN `expense_cat_fk` INT(11) DEFAULT NULL AFTER `group_id`;');
                    $CI->db->query('ALTER TABLE `' . $db_prefix . 'items` ADD CONSTRAINT `fk_expense_cat_fk` FOREIGN KEY (`expense_cat_fk`) REFERENCES `' . $db_prefix . 'expense_categories` (`id`)');
                }
            }
        }
    }



    public function down()
    {
       
    }

}





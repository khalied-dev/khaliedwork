<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
class Migration_alter_table_expensecat extends CI_Migration { 

 


    public function up()
    {
        $CI = &get_instance();
        $db_prefix = db_prefix();
    
        if ($CI->db->table_exists($db_prefix . 'expense_categories')) {
            // Check if the 'jk' column doesn't exist in the 'tblitems' table
            if (!$CI->db->field_exists('resreq_type', $db_prefix . 'expense_categories')) {
                // Check if the 'tablesk' table exists
                if ($CI->db->table_exists($db_prefix . 'expense_categories')) {
                    $CI->db->query('ALTER TABLE `' . $db_prefix . 'expense_categories` ADD COLUMN `resreq_type` varchar(30) DEFAULT NULL;');
                }
            }
        }
    }









    public function down()
    {
       
    }

}





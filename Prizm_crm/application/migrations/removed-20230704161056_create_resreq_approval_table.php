<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
class Migration_create_resreq_approval_table extends CI_Migration { 

    public function up()
    {

        $CI = &get_instance();
        if (!$CI->db->table_exists(db_prefix() . 'resreq_approval')) {
            $CI->db->query('CREATE TABLE `' . db_prefix() . 'resreq_approval` (
            `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `subject` varchar(35) NOT NULL,
            `resreq_type` varchar(30)  NOT NULL, 
            `approver` int(11)  NOT NULL,
            `action` varchar(35) NOT NULL,
            `addeddate` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            CONSTRAINT `thepsfkkk_staff` FOREIGN KEY (`approver`) REFERENCES `' . db_prefix() . 'staff`(`staffid`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
        }
        


    }

    public function down()
    {
        $this->dbforge->drop_table('resreq_approval');
       
    }

}






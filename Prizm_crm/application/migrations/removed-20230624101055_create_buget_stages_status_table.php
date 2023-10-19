<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
class Migration_create_buget_stages_status_table extends CI_Migration { 

    public function up()
    {

        $CI = &get_instance();
        if (!$CI->db->table_exists(db_prefix() . 'przbudget_stages')) {
            $CI->db->query('CREATE TABLE `' . db_prefix() . 'przbudget_stages` (
            `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `level` int(11) NOT NULL,
            `stage_name` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
        }
        
        if (!$CI->db->table_exists(db_prefix() . 'przbudget_statuses')) {
            $CI->db->query('CREATE TABLE `' . db_prefix() . 'przbudget_statuses` (
            `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `stage_id` int(11) UNSIGNED NOT NULL DEFAULT 1,
            `status_name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
            `color` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 757575,
            `total_count` int(11) NOT NULL,
            `order_in_list` int(11) NOT NULL DEFAULT 0,
            `approver` int(11)  NOT NULL, 
            `filter_default` int(11) NOT NULL,
            PRIMARY KEY (`id`),
            CONSTRAINT `psfkkk_staff` FOREIGN KEY (`approver`) REFERENCES `' . db_prefix() . 'staff`(`staffid`),
            CONSTRAINT `tfk_statuses_stages` FOREIGN KEY (`stage_id`) REFERENCES `' . db_prefix() . 'przbudget_stages`(`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
        }
        
        if (!$CI->db->table_exists(db_prefix() . 'przbudget_statusdetails')) {
            $CI->db->query('CREATE TABLE `' . db_prefix() . 'przbudget_statusdetails` (
            `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `resreq_id` int(11)  NULL,
            `stage_id` int(11) UNSIGNED NOT NULL,
            `status_id` int(11) NOT NULL,
            `rel_type` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
            `approvedBy_staffId` varchar(45) COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
            `rejectedBy_staffId` varchar(45) COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
            `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `date_approved` timestamp NULL DEFAULT NULL,
            `date_rejected` timestamp NULL DEFAULT NULL,
            `approve_action` varchar(45) COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
            `reject_action` varchar(45) COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
            `approver_email` varchar(150) COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
            `reject_value` varchar(150) COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
            `action` varchar(150) COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
            `sender` int(11) NULL DEFAULT NULL,
            `date_send` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
        }

    }

    public function down()
    {
        $this->dbforge->drop_table('przbudget_stages');
        $this->dbforge->drop_table('przbudget_statuses');
        $this->dbforge->drop_table('przbudget_statusdetails');
       
    }

}






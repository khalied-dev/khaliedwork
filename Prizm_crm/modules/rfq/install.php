<?php

defined('BASEPATH') or exit('No direct script access allowed');

if (!$CI->db->table_exists(db_prefix() . 'suppliers')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'suppliers` (
    `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `supplier_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `firstname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `middlename` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `lastname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `sufix` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `company` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `display_name_as` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `trn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `fax` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `other` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `is_sub_supplier` tinyint(1) DEFAULT NULL,
    `bill_with_parent` tinyint(1) DEFAULT NULL,
    `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `billing_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `billing_address_map` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `same_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `shipping_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `shipping_address_map` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `city_town` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `state_province` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `postal_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `shipping_city_town` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `shipping_state_province` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `shipping_postal_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `shipping_country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `preferred_payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `preferred_delivery_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `terms` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `opening_balance` double(18,4) DEFAULT NULL,
    `balance_as_of` date DEFAULT NULL,
    `currency_id` int(11) DEFAULT NULL,
    `language` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `deleted_at` timestamp NULL DEFAULT NULL,
    `status` tinyint(4) DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'supplier_contacts')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . 'supplier_contacts` (
`id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
`title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
`firstname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
`middlename` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
`lastname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
`sufix` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
`designation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
`Department` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
`email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
`phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
`whatsapp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
`supplier_id` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'rfqs')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'rfqs` (
    `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `RFQ_code` varchar(255) DEFAULT NULL,
    `rel_id` int(11) DEFAULT NULL,
    `rel_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `assigned_eng_staff_id` int(11) DEFAULT NULL,
    `Acceptance` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `EmailSubject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `Remarks` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `delete_flag` tinyint(4) DEFAULT NULL,
    `status` tinyint(4) DEFAULT NULL,
    `attach_file1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `attach_file2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `attach_file3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `created_by` int(11) DEFAULT NULL,
    `deleted_at` timestamp NULL DEFAULT NULL,
    `deleted_by` int(11) DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    `cost_center_id` int(11) DEFAULT -1,
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'rfq_template_list')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . 'rfq_template_list` (
    `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `templateName` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `RFQId` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'rfq_attirbute_item_list')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . 'rfq_attirbute_item_list` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ColumnId` int(11) NOT NULL,
  `description` text CHARACTER SET utf8 DEFAULT NULL,
  `value` text CHARACTER SET utf8 DEFAULT NULL,
  `RFQId` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'rfq_cc_emails')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'rfq_cc_emails` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `RFQId` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'rfq_columns_list')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'rfq_columns_list` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `TemplateId` int(11) NOT NULL,
  `ColumnName` text NOT NULL,
  `RFQId` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'rfq_supplier')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'rfq_supplier` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `RFQId` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'rfq_supplier_contact')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'rfq_supplier_contact` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `RFQId` int(11) NOT NULL,
  `supplier_contact_id` int(11) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}


$CI->db->query('ALTER TABLE `' . db_prefix() . 'suppliers` CHANGE `id` `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT;');





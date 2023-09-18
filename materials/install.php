<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!$CI->db->table_exists(db_prefix() . 'fields')) {
      $CI->db->query('CREATE TABLE `' . db_prefix() .'fields` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `name` text NOT NULL,
        `description` INT(11) NOT NULL,
        `dateadded` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`));');
  }
  
if (!$CI->db->table_exists(db_prefix() . 'materials')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() .'materials` (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `item_code` text NOT NULL,
      `item_name` text NOT NULL,
      `staff_id` INT(11) NOT NULL,
      `remarks` text NULL,
      `partner` text NULL,
      `partner_item_code` text NULL,
      `partner_item_name` text NULL,
      `category_id` INT(11) NULL,
      `field_id` INT(11) NULL,
      `purchase_price` DECIMAL(10,4)  NULL,
      `sell_price` DECIMAL(10,4)  NULL,
      `datecreated` DATETIME NOT null DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`));');
}

if (!$CI->db->table_exists(db_prefix() . 'materials_metadata')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() .'materials_metadata` (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `material_id` INT(11) NOT NULL,
      `meta_field`  text NULL,
      `meta_value`  text NULL,
      `remarks` text NULL,
      `dateadded` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`));');
}




if (!$CI->db->table_exists(db_prefix() . 'materials_metafields_ignored')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() .'materials_metafields_ignored` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
  `material_partner_item_name` text DEFAULT NULL,
  `item_name_meta_field_name` text DEFAULT NULL,
  `item_name_meta_field_values` text DEFAULT NULL,
  `master_or_general` text DEFAULT NULL,
  PRIMARY KEY (`id`));');


  // $CI->db->query('ALTER TABLE `'.db_prefix().'materials_metafields_ignored`
  // ADD PRIMARY KEY (`id`);');

  // $CI->db->query('ALTER TABLE `'.db_prefix().'materials_metafields_ignored`
  // MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;');


}






if (!$CI->db->table_exists(db_prefix() . 'materials_metafields_grouped')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() .'materials_metafields_grouped` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
  `material_partner_item_name` text DEFAULT NULL,
  `item_name_meta_field_name` text DEFAULT NULL,
  `item_name_meta_field_values` text DEFAULT NULL,
  `master_or_general` text DEFAULT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`id`));');
}






if (!$CI->db->table_exists(db_prefix() . 'materials_metafields_groups')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() .'materials_metafields_groups` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` text DEFAULT NULL,
  `group_details` text DEFAULT NULL,
  PRIMARY KEY (`id`));');
}
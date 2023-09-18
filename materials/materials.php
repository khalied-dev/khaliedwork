<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
Module Name: Materials
Description: Standard materials records.
Version: 1.0.0
Requires at least: 2.3.*
Author: Khalid Battran - Prizm
Author URI: 
*/


define('MATERIALS_MODULE_NAME', 'PRZ_Materials');
define('MATERIALS_FOLDER', 'materials');

hooks()->add_action('admin_init', 'materials_module_init_menu_items');
hooks()->add_action('admin_init', 'materials_permissions');
hooks()->add_action('app_admin_head', 'materials_add_head_components');
hooks()->add_action('app_admin_footer', 'materials_add_footer_components');
hooks()->add_action('customers_navigation_end', 'materials_module_init_client_menu_items');
hooks()->add_action('app_customers_head', 'materials_client_add_head_components');
hooks()->add_action('app_customers_footer', 'materials_client_add_footer_components');


/**
* Register activation module hook
*/
register_activation_hook(MATERIALS_FOLDER, 'materials_module_activation_hook');

/**
* Functions of the module
*/
function materials_add_head_components(){
    $CI = &get_instance();
    $viewuri = $_SERVER['REQUEST_URI'];
    if(!(strpos($viewuri, '/admin/materials') === false)){
           echo "<link href='https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css' rel='stylesheet' type='text/css'>";   
        // echo '<link href="' . base_url('modules/materials/assets/css/styles.css') .'"  rel="stylesheet" type="text/css" />';
        // echo '<link href="' . base_url('modules/materials/assets/css/jquery.atwho.css') .'"  rel="stylesheet" type="text/css" />';        
        // echo '<link href="' . base_url('modules/materials/assets/css/jquery.materialssInput.css') .'"  rel="stylesheet" type="text/css" />';        
        // echo "<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>";    
    }
}

function materials_add_footer_components(){
    $CI = &get_instance();
    $viewuri = $_SERVER['REQUEST_URI'];
    if(!(strpos($viewuri, '/admin/materials') === false)){
         echo '<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>';
         echo '<script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>';
        // echo '<script src="' . base_url('modules/materials/assets/js/materials.js') . '"></script>';
        // echo '<script src="' . base_url('modules/materials/assets/third-party/jquery.caret.js') . '"></script>';
        // echo '<script src="' . base_url('modules/materials/assets/third-party/jquery.atwho.js') . '"></script>';  
    }
}

function materials_client_add_head_components(){
    $CI = &get_instance();
    $viewuri = $_SERVER['REQUEST_URI'];
    if(!(strpos($viewuri, '/materials') === false)){
        // echo '<link href="' . base_url('modules/materials/assets/css/styles.css') .'"  rel="stylesheet" type="text/css" />';
        // echo '<link href="' . base_url('modules/materials/assets/css/jquery.atwho.css') .'"  rel="stylesheet" type="text/css" />';        
        // echo '<link href="' . base_url('modules/materials/assets/css/jquery.materialssInput.css') .'"  rel="stylesheet" type="text/css" />';        
        // echo "<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>";    
    }
}

function materials_client_add_footer_components(){
    $CI = &get_instance();
    $viewuri = $_SERVER['REQUEST_URI'];
    if(!(strpos($viewuri, '/materials') === false)){
        // echo '<script src="' . base_url('modules/materials/assets/js/materials_client.js') . '"></script>';
        // echo '<script src="' . base_url('modules/materials/assets/third-party/jquery.caret.js') . '"></script>';
        // echo '<script src="' . base_url('modules/materials/assets/third-party/jquery.atwho.js') . '"></script>';  
        
    }
}

function materials_module_activation_hook()
{
    $CI = &get_instance();
    require_once(__DIR__ . '/install.php');
}

/**
* Register language files, must be registered if the module is using languages
*/
register_language_files(MATERIALS_FOLDER, [MATERIALS_FOLDER]);

/**
 * Init materials module menu items in setup in admin_init hook
 * @return null
 */
function materials_module_init_menu_items()
{
    if (has_permission('materials', '', 'view')) {
        $CI = &get_instance();
        $CI->app_menu->add_sidebar_menu_item('materials', [
                'name'     => _l('materials'),
                'href'     => admin_url('materials'),
                'icon'     => 'fa fa-box-open',
                'position' => 30

        ]);


        /* $CI->app_menu->add_sidebar_children_item('materials', [
            'slug'     => 'child-to-custom-menu-item', // Required ID/slug UNIQUE for the child menu
            'name'     => 'Sub Menu', // The name if the item
            'href'     => admin_url(''), // URL of the item
            'position' => 5, // The menu position
            'icon'     => 'fa fa-exclamation', // Font awesome icon
        ]); */







    }
}

/**
 * Init materials module permissions in setup in admin_init hook
 */
function materials_permissions()
{
    $capabilities = [];
    $capabilities['capabilities'] = [
            'view'   => _l('permission_view'),
            'view_own'   => _l('permission_view_own'),
            'view_details'   => _l('permission_view_details'),
            'create'   => _l('permission_create'),
            'edit'   => _l('permission_edit'),
            'delete'   => _l('permission_edit'),
    ];
    register_staff_capabilities('materials', $capabilities, _l('materials'));
}

/**
 * Init materials module menu items in setup in customers_navigation_end hook
 */
function materials_module_init_client_menu_items()
{
    $menu = '';
    if (is_client_logged_in()) {
        $menu .= '<li class="customers-nav-item-Insurances-plan">
                  <a href="'.site_url('materials/materials_client').'">
                    <i class=""></i> '
                    . _l('materials').'
                  </a>
               </li>';
    }
    echo html_entity_decode($menu);
}
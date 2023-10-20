<?php

defined('BASEPATH') or exit('No direct script access allowed');
require_once(__DIR__ . '/vendor/autoload.php');
//include 'vendor/autoload.php';


/*
Module Name: Request for Quota Management
Description: Request for Quota Management
Version: 1.0.0

Author: Mustafa Zaroug - Prizm Energy
*/
$CI = &get_instance();

define('rfq_MODULE_NAME', 'rfq');
// $CI->load->helper(rfq_MODULE_NAME . '/rfq');

// hooks()->add_action('after_cron_run', 'rfq_notification');
hooks()->add_action('admin_init', 'rfq_module_init_menu_items');
hooks()->add_action('admin_init', 'rfq_permissions');
hooks()->add_action('app_admin_footer', 'rfq_load_js');

// hooks()->add_action('staff_member_deleted', 'rfq_staff_member_deleted');

// hooks()->add_filter('migration_tables_to_replace_old_links', 'rfq_migration_tables_to_replace_old_links');
// hooks()->add_filter('global_search_result_query', 'rfq_global_search_result_query', 10, 3);
// hooks()->add_filter('global_search_result_output', 'rfq_global_search_result_output', 10, 2);
// hooks()->add_filter('get_dashboard_widgets', 'rfq_add_dashboard_widget');

// /**
// * Register activation module hook
// */
register_activation_hook(rfq_MODULE_NAME, 'rfq_module_activation_hook');
// register_deactivation_hook();
// register_uninstall_hook();


// /**
// * Register language files, must be registered if the module is using languages
// */
register_language_files(rfq_MODULE_NAME, [rfq_MODULE_NAME]);

function rfq_module_activation_hook()
{
	$CI = &get_instance();
	require_once(__DIR__ . '/install.php');
}
function rfq_add_dashboard_widget($widgets)
{
    $widgets[] = [
        'path'      => 'rfq/widget',
        'container' => 'right-4',
    ];

    return $widgets;
}

/**
 * load js
 */
function rfq_load_js(){
	$CI = &get_instance();
	$viewuri = $_SERVER['REQUEST_URI'];
    
    //echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">';
    //echo '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>';

    echo '<script src="' . module_dir_url(rfq_MODULE_NAME, 'assets/js/jquery-csv/jquery.csv.min.js') . '"></script>';
    echo '<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>';
    
       
    if (!(strpos($viewuri, '/admin/rfq/') === false)) {
		echo '<script src="' . module_dir_url(rfq_MODULE_NAME, 'assets/js/rfq.js') . '"></script>';
       }
}





// function rfq_staff_member_deleted($data)
// {
//     $CI = &get_instance();
//     $CI->db->where('staff_id', $data['id']);
//     $CI->db->update(db_prefix() . 'rfq', [
//         'staff_id' => $data['transfer_data_to'],
//     ]);
// }

// function rfq_global_search_result_output($output, $data)
// {
//     if ($data['type'] == 'rfq') {
//         $output = '<a href="' . admin_url('rfq/rfq/' . $data['result']['id']) . '">' . $data['result']['subject'] . '</a>';
//     }

//     return $output;
// }

// function rfq_global_search_result_query($result, $q, $limit)
// {
//     $CI = &get_instance();
//     if (has_permission('rfq', '', 'view')) {
//         // Goals
//         $CI->db->select()->from(db_prefix() . 'rfq')->like('description', $q)->or_like('subject', $q)->limit($limit);

//         $CI->db->order_by('subject', 'ASC');

//         $result[] = [
//             'result'         => $CI->db->get()->result_array(),
//             'type'           => 'rfq',
//             'search_heading' => _l('rfq'),
//         ];
//     }

//     return $result;
// }

// function rfq_migration_tables_to_replace_old_links($tables)
// {
//     $tables[] = [
//         'table' => db_prefix() . 'rfq',
//         'field' => 'description',
//     ];

//     return $tables;
// }

function rfq_permissions()
{
    $capabilities = [];

    $capabilities['capabilities'] = [
        'view'          => _l('permission_view') . '(' . _l('permission_global') . ')',
        'view_own'      => _l('permission_view'),
        'action'        => _l('permission_action'),
        'change_status' => _l('permission_change_status'),
        'create'        => _l('permission_create'),
        'edit'          => _l('permission_edit'),
        'convert'       => _l('permission_convert'),
        'delete'        => _l('permission_delete'),
    ];

    register_staff_capabilities('rfq', $capabilities, _l('rfq'));
}

// function rfq_notification()
// {
//     $CI = &get_instance();
//     $CI->load->model('rfq/rfq_model');
//     $rfq = $CI->rfq_model->get('', true);
//     foreach ($rfq as $rfq) {
//         $achievement = $CI->rfq_model->calculate_rfq_achievement($rfq['id']);

//         if ($achievement['percent'] >= 100) {
//             if (date('Y-m-d') >= $rfq['end_date']) {
//                 if ($rfq['notify_when_achieve'] == 1) {
//                     $CI->rfq_model->notify_staff_members($rfq['id'], 'success', $achievement);
//                 } else {
//                     $CI->rfq_model->mark_as_notified($rfq['id']);
//                 }
//             }
//         } else {
//             // not yet achieved, check for end date
//             if (date('Y-m-d') > $rfq['end_date']) {
//                 if ($rfq['notify_when_fail'] == 1) {
//                     $CI->rfq_model->notify_staff_members($rfq['id'], 'failed', $achievement);
//                 } else {
//                     $CI->rfq_model->mark_as_notified($rfq['id']);
//                 }
//             }
//         }
//     }
// }


// /**
// * Init rfq module menu items in setup in admin_init hook
// * @return null
// */
function rfq_module_init_menu_items()
{
    $CI = &get_instance();
    // if (has_permission('rfq', '', 'view')) {

    // $CI->app->add_quick_actions_link(['name'       => _l('rfq'),
    // 'url'        => 'rfq/',
    // 'permission' => 'rfq',
    // 'position'   => 56,
    // 'icon'       => 'fa fa-exclamation-triangle']);
    // }
    
    if (has_permission('rfq', '', 'view')) {
        $CI->app_menu->add_sidebar_menu_item('rfq', [
            'slug'     => 'rfq-tracking',
            'name'     => _l('rfq'),
            'href'     => admin_url('rfq/'),
            'position' => 24,
            'icon'       => 'fa fa-cart-arrow-down ',
        ]);
    }
    // if (has_permission('rfq', '', 'view')) {
    //     $CI->app_menu->add_sidebar_children_item('utilities', [
    //         'slug'     => 'rfq-tracking',
    //         'name'     => _l('rfq'),
    //         'href'     => admin_url('rfq'),
    //         'position' => 24,
    //     ]);
    // }
}



// /**
// * Get rfq types for the rfq feature
// *
// * @return array
// */
// function get_rfq_types()
// {
//     $types = [
//         [
//             'key'       => 1,
//             'lang_key'  => 'rfq_type_total_income',
//             'subtext'   => 'rfq_type_income_subtext',
//             'dashboard' => has_permission('invoices', 'view'),
//         ],
//         [
//             'key'       => 8,
//             'lang_key'  => 'rfq_type_invoiced_amount',
//             'subtext'   => '',
//             'dashboard' => has_permission('invoices', 'view'),
//         ],
//         [
//             'key'       => 2,
//             'lang_key'  => 'rfq_type_convert_leads',
//             'dashboard' => is_staff_member(),
//         ],
//         [
//             'key'       => 3,
//             'lang_key'  => 'rfq_type_increase_customers_without_leads_conversions',
//             'subtext'   => 'rfq_type_increase_customers_without_leads_conversions_subtext',
//             'dashboard' => has_permission('customers', 'view'),
//         ],
//         [
//             'key'       => 4,
//             'lang_key'  => 'rfq_type_increase_customers_with_leads_conversions',
//             'subtext'   => 'rfq_type_increase_customers_with_leads_conversions_subtext',
//             'dashboard' => has_permission('customers', 'view'),

//         ],
//         [
//             'key'       => 5,
//             'lang_key'  => 'rfq_type_make_contracts_by_type_calc_database',
//             'subtext'   => 'rfq_type_make_contracts_by_type_calc_database_subtext',
//             'dashboard' => has_permission('contracts', 'view'),
//         ],
//         [
//             'key'       => 7,
//             'lang_key'  => 'rfq_type_make_contracts_by_type_calc_date',
//             'subtext'   => 'rfq_type_make_contracts_by_type_calc_date_subtext',
//             'dashboard' => has_permission('contracts', 'view'),
//         ],
//         [
//             'key'       => 6,
//             'lang_key'  => 'rfq_type_total_estimates_converted',
//             'subtext'   => 'rfq_type_total_estimates_converted_subtext',
//             'dashboard' => has_permission('estimates', 'view'),
//         ],
//     ];

//     return hooks()->apply_filters('get_rfq_types', $types);
// }

// /**
// * Get rfq type by given key
// *
// * @param  int $key
// *
// * @return array
// */
// function get_rfq_type($key)
// {
//     foreach (get_rfq_types() as $type) {
//         if ($type['key'] == $key) {
//             return $type;
//         }
//     }
// }

// /**
// * Translate rfq type based on passed key
// *
// * @param  mixed $key
// *
// * @return string
// */
// function format_rfq_type($key)
// {
//     foreach (get_rfq_types() as $type) {
//         if ($type['key'] == $key) {
//             return _l($type['lang_key']);
//         }
//     }

//     return $type;
// }
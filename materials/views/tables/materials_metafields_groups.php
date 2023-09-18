<?php
//$search_key;
defined('BASEPATH') or exit('No direct script access allowed');
$this->ci->load->model('Material_model');
$has_permission_delete = has_permission('materials', '', 'delete');
$custom_fields         = get_table_custom_fields('materials');
$statuses              = array();//$this->ci->materials_model->get_materials_statuses();

$aColumns = [
    'id',
    'group_name',
    'group_details'
    ];

$aColumns = array_merge($aColumns, [
]);

$sIndexColumn = 'id';
$sTable       = db_prefix() . 'materials_metafields_groups';

$join = [];

foreach ($custom_fields as $key => $field) {
    $selectAs = (is_cf_date($field) ? 'date_picker_cvalue_' . $key : 'cvalue_' . $key);
    array_push($customFieldsColumns, $selectAs);
    array_push($aColumns, 'ctable_' . $key . '.value as ' . $selectAs);
    array_push($join, 'LEFT JOIN ' . db_prefix() . 'customfieldsvalues as ctable_' . $key . ' ON ' . db_prefix() . 'materials.id = ctable_' . $key . '.relid AND ctable_' . $key . '.fieldto="' . $field['fieldto'] . '" AND ctable_' . $key . '.fieldid=' . $field['id']);
}

$where  = [];
$filter = false;
$statusIds = [];




if (count($statusIds) > 0) {
    array_push($where, 'AND ' . db_prefix() . 'material.status IN (' . implode(', ', $statusIds) . ')');
}



$aColumns = hooks()->apply_filters('materials_table_sql_columns', $aColumns);

// Fix for big queries. Some hosting have max_join_limit
if (count($custom_fields) > 4) {
    @$this->ci->db->query('SET SQL_BIG_SELECTS=1');
}

$additionalColumns = hooks()->apply_filters('materials_table_additional_columns_sql', [
    // "GROUP_CONCAT(CONCAT(" . db_prefix() . "materials_metadata.meta_field, ': ', " . db_prefix() . "materials_metadata.meta_value) SEPARATOR ', ') as metadata",
    //'datecreated'
]);
 $groupby = '';
/*$groupby = ' GROUP by '.
    db_prefix() . 'materials.id,item_code,item_name,'.db_prefix() . 'materials.remarks,
partner,
partner_item_code,
partner_item_name';
 */
$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, $additionalColumns,$groupby, /* 'DISTINCT' */);

$output  = $result['output'];
$rResult = $result['rResult'];

//print_r($rResult);
//exit();









foreach ($rResult as $aRow) {

    $row = array();

    $id = '<div class="checkbox"><input type="checkbox" value="' . $aRow['id'] . '"><label></label></div>';
    $edithrefAttr = 'href="' . admin_url(MATERIALS_FOLDER.'/edit_metafields_groups/' . $aRow['id']) . '" ';
    //$deletehrefAttr =  'href="' . admin_url(MATERIALS_FOLDER.'/delete_metafields_groups/' . $aRow['id']) . '" ';
    $deletehrefAttr =  'href="' . admin_url(MATERIALS_FOLDER.'/managefieldsgroups/') .'" onclick="do_delete_metafields_groups(' . $aRow['id'] . ')" ';


    $row[]    = $id.'<a>' . $aRow['id'] . '</a>';

    $nameRow = '<a>' . $aRow['group_name'] . '</a><br/>';
    // $nameRow .= '<div >' . $aRow['metadata'] . '</div>';


    $nameRow .= '<div class="row-options">';
    $nameRow .= '  <a ' . $edithrefAttr . '>' . _l('edit') . '</a>';
    $nameRow .= '  | <a ' . $deletehrefAttr . '>' . _l('delete') . '</a>';
    $nameRow .= '</div>';
    $row[] = $nameRow;

    $row[] = $aRow['group_details'];

    
 
    // $row[] = '<span data-toggle="tooltip" data-title="' . _dt($aRow['dateadded']) . '" class="text-has-action is-date">' . time_ago($aRow['dateadded']) . '</span>';

    // Custom fields add values
    foreach ($customFieldsColumns as $customFieldColumn) {
        $row[] = (strpos($customFieldColumn, 'date_picker_') !== false ? _d($aRow[$customFieldColumn]) : $aRow[$customFieldColumn]);
    }

    $row['DT_RowId'] = 'material_' . $aRow['id'];

    // if ($aRow['assigned'] == get_staff_user_id()) {
    //     $row['DT_RowClass'] = 'info';
    // }

    if (isset($row['DT_RowClass'])) {
        $row['DT_RowClass'] .= ' has-row-options';
    } else {
        $row['DT_RowClass'] = 'has-row-options';
    }

    $row = hooks()->apply_filters('materials_table_row_data', $row, $aRow);

    $output['aaData'][] = $row;

}
<?php

defined('BASEPATH') or exit('No direct script access allowed');
$this->ci->load->model('Material_model');
$has_permission_delete = has_permission('materials', '', 'delete');
$custom_fields         = get_table_custom_fields('materials');
$statuses              = array();//$this->ci->materials_model->get_materials_statuses();

$aColumns = [
    db_prefix() . 'materials.id as id',
    'item_code',
    'item_name',
    db_prefix() . 'materials.remarks as remarks',
    'partner',
    'partner_item_code',
    'partner_item_name'
    ];

$aColumns = array_merge($aColumns, [
]);

$sIndexColumn = 'id';
$sTable       = db_prefix() . 'materials';

$join = [
    'JOIN ' . db_prefix() . 'materials_metadata ON ' . db_prefix() . 'materials.id = ' . db_prefix() . 'materials_metadata.material_id',
    // 'LEFT JOIN ' . db_prefix() . 'advance_leads ON ' . db_prefix() . 'advance_leads.lead_id = ' . db_prefix() . 'leads.id',
    // 'LEFT JOIN ' . db_prefix() . 'advance_leads_statuses ON ' . db_prefix() . 'advance_leads_statuses.id = ' . db_prefix() . 'advance_leads.status',
    // 'LEFT JOIN ' . db_prefix() . 'leads_sources ON ' . db_prefix() . 'leads_sources.id = ' . db_prefix() . 'leads.source',
];

foreach ($custom_fields as $key => $field) {
    $selectAs = (is_cf_date($field) ? 'date_picker_cvalue_' . $key : 'cvalue_' . $key);
    array_push($customFieldsColumns, $selectAs);
    array_push($aColumns, 'ctable_' . $key . '.value as ' . $selectAs);
    array_push($join, 'LEFT JOIN ' . db_prefix() . 'customfieldsvalues as ctable_' . $key . ' ON ' . db_prefix() . 'materials.id = ctable_' . $key . '.relid AND ctable_' . $key . '.fieldto="' . $field['fieldto'] . '" AND ctable_' . $key . '.fieldid=' . $field['id']);
}

$where  = [];
$filter = false;
$statusIds = [];

// foreach ($this->ci->advanceleads_model->get_advanceleads_statuses() as $status) {
//     if ($this->ci->input->post('material_status_' . $status['id'])) {
//         array_push($statusIds, $status['id']);
//     }
// }

if (count($statusIds) > 0) {
    array_push($where, 'AND ' . db_prefix() . 'material.status IN (' . implode(', ', $statusIds) . ')');
}
// $is_initial = count($this->ci->advanceleads_model->get_advanceleads_statuses())==count($statusIds);
// if (is_admin() && $is_initial) {
//     array_push($where, 'AND ' . db_prefix() . 'material.status = 1');
// }

// if ($this->ci->input->post('custom_view')) {
//     $filter = $this->ci->input->post('custom_view');
//     if ($filter == 'lost') {
//         array_push($where, 'AND lost = 1');
//     } elseif ($filter == 'junk') {
//         array_push($where, 'AND junk = 1');
//     } elseif ($filter == 'not_assigned') {
//         array_push($where, 'AND assigned = 0');
//     } elseif ($filter == 'contacted_today') {
//         array_push($where, 'AND lastcontact LIKE "' . date('Y-m-d') . '%"');
//     } elseif ($filter == 'created_today') {
//         array_push($where, 'AND dateadded LIKE "' . date('Y-m-d') . '%"');
//     } elseif ($filter == 'public') {
//         array_push($where, 'AND is_public = 1');
//     } elseif (startsWith($filter, 'consent_')) {
//         array_push($where, 'AND ' . db_prefix() . 'leads.id IN (SELECT lead_id FROM ' . db_prefix() . 'consents WHERE purpose_id=' . $this->ci->db->escape_str(strafter($filter, 'consent_')) . ' and action="opt-in" AND date IN (SELECT MAX(date) FROM ' . db_prefix() . 'consents WHERE purpose_id=' . $this->ci->db->escape_str(strafter($filter, 'consent_')) . ' AND lead_id=' . db_prefix() . 'leads.id))');
//     }
// }


$aColumns = hooks()->apply_filters('materials_table_sql_columns', $aColumns);

// Fix for big queries. Some hosting have max_join_limit
if (count($custom_fields) > 4) {
    @$this->ci->db->query('SET SQL_BIG_SELECTS=1');
}

$additionalColumns = hooks()->apply_filters('materials_table_additional_columns_sql', [
    // "GROUP_CONCAT(CONCAT(" . db_prefix() . "materials_metadata.meta_field, ': ', " . db_prefix() . "materials_metadata.meta_value) SEPARATOR ', ') as metadata",
    'datecreated'
]);

$groupby = ' GROUP by '.
    db_prefix() . 'materials.id,item_code,item_name,'.db_prefix() . 'materials.remarks,
partner,
partner_item_code,
partner_item_name';

$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, $additionalColumns,$groupby);

$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = array();
    
    $id = '<div class="checkbox"><input type="checkbox" value="' . $aRow['id'] . '"><label></label></div>';
    $hrefAttr = 'href="' . admin_url(MATERIALS_FOLDER.'/view/' . $aRow['id']) . '" ';
    $edithrefAttr = 'href="' . admin_url(MATERIALS_FOLDER.'/edit/' . $aRow['id']) . '" ';
    $view_detailshrefAttr = 'href="' . admin_url(MATERIALS_FOLDER.'/view_details/' . $aRow['id']) . '" ';


    $row[]    = $id.'<a ' . $hrefAttr . '>' . $aRow['id'] . '</a>';

    $row[] = $aRow['item_code'];

    $nameRow = '<a ' . $hrefAttr . '>' . $aRow['item_name'] . '</a><br/>';
    // $nameRow .= '<div >' . $aRow['metadata'] . '</div>';

    
    $nameRow .= '<div class="row-options">';
    $nameRow .= '<a ' . $hrefAttr . '>' . _l('view') . '</a>';
    $nameRow .= ' | <a ' . $edithrefAttr . '>' . _l('edit') . '</a>';
    $nameRow .= ' | <a ' . $view_detailshrefAttr . '>' . _l('view_details') . '</a>';
/*  if(has_permission('materials','','view_details'))
    $nameRow .= ' | <a href="#" onclick="material_details();" class="_delete text-info">' . _l('details') . '</a>'; */


    // if ($aRow['addedfrom'] == get_staff_user_id() || $has_permission_delete) {
    //     $nameRow .= ' | <a href="#" class="_delete text-danger">' . _l('delete') . '</a>';
    // }
    $nameRow .= '</div>';
    $row[] = $nameRow;

  
    $row[] = $aRow['remarks'];
    $row[] = $aRow['partner'];
    $row[] = $aRow['partner_item_code'];
    $row[] = $aRow['partner_item_name'];
    
 
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
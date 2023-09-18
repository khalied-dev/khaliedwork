<?php

defined('BASEPATH') or exit('No direct script access allowed');
$this->ci->load->model('Material_model');
$has_permission_delete = has_permission('materials', '', 'delete');
$custom_fields         = get_table_custom_fields('materials');
$statuses              = array();//$this->ci->materials_model->get_materials_statuses();










//$material = $this->Material_model->get_material($search_id);
 //$the_item_name = "RING";

$the_item_name = $search_key;
















$aColumns = [
    /* db_prefix().'materials.id', */
    db_prefix().'materials.partner_item_name',
    db_prefix().'materials.remarks',
    db_prefix().'advance_leads_details.floatingdate'
    ];

$aColumns = array_merge($aColumns, [
]);

//for COUNT  => SELECT COUNT(tblmaterials.id)
$sIndexColumn = 'id';
$sTable       = db_prefix() . 'materials';

$join = [
    'LEFT JOIN ' . db_prefix() . 'leads ON '.db_prefix().'materials.remarks = '.db_prefix().'leads.name',
    'LEFT JOIN ' . db_prefix() . 'advance_leads_details ON '.db_prefix().'leads.id = '.db_prefix().'advance_leads_details.lead_id'
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




//array_push($where, " AND ".db_prefix()."materials.partner_item_name LIKE '".$the_item_name."'");

//SELECT * FROM ksa WHERE FIND_IN_SET('SOFT GOODS FOR ANGLE PRESSURE REDUCING CONTROL VALVE INJECTION TYPE', REPLACE(col1, ',', ''));
$search_key = str_replace( array('-'), '', $the_item_name);
$search_keyy = str_replace( array('%20'), ' ', $search_key);
array_push($where, " AND FIND_IN_SET('".$search_keyy."' , REPLACE(".db_prefix()."materials.partner_item_name, ',', '') )  "); 




if (count($statusIds) > 0) {
    array_push($where, 'AND ' . db_prefix() . 'material.status IN (' . implode(', ', $statusIds) . ')');
}


/* 
SELECT tblmaterials.remarks, tbladvance_leads_details.floatingdate FROM `tblmaterials` 
LEFT JOIN tblleads ON tblmaterials.remarks = tblleads.name 
LEFT JOIN tbladvance_leads_details ON tblleads.id = tbladvance_leads_details.lead_id
WHERE item_name LIKE 'SEAL_RING'
*/



$aColumns = hooks()->apply_filters('materials_table_sql_columns', $aColumns);

// Fix for big queries. Some hosting have max_join_limit
if (count($custom_fields) > 4) {
    @$this->ci->db->query('SET SQL_BIG_SELECTS=1');
}

$additionalColumns = hooks()->apply_filters('materials_table_additional_columns_sql', [
    // "GROUP_CONCAT(CONCAT(" . db_prefix() . "materials_metadata.meta_field, ': ', " . db_prefix() . "materials_metadata.meta_value) SEPARATOR ', ') as metadata",
    'datecreated'
]);
$groupby = '';
$groupby = ' GROUP by '.
    db_prefix() . 'materials.id,item_code,item_name,'.db_prefix() . 'materials.remarks,
partner,
partner_item_code,
partner_item_name';

$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, $additionalColumns,$groupby/*,  'DISTINCT' */);

$output  = $result['output'];
$rResult = $result['rResult'];

//print_r($rResult);
//exit();























foreach ($rResult as $aRow) {

    $row = array();



/* 
$hrefAttr = 'href="' . admin_url(MATERIALS_FOLDER.'/view/' . $aRow[db_prefix() . 'materials.remarks']) . '" ';
//$edithrefAttr = 'href="' . admin_url(MATERIALS_FOLDER.'/edit/' . $aRow[db_prefix() . 'materials.remarks']) . '" ';
//$view_detailshrefAttr = 'href="' . admin_url(MATERIALS_FOLDER.'/view_details/' . $aRow[db_prefix() . 'materials.remarks']) . '" ';
$nameRow = '<a ' . $hrefAttr . '>' . $aRow[db_prefix() . 'materials.remarks'] . '</a><br/>';
$nameRow .= '<div class="row-options">';
$nameRow .= '<a ' . $hrefAttr . '>' . _l('view') . '</a>';
$nameRow .= ' | <a ' . $edithrefAttr . '>' . _l('edit') . '</a>';
$nameRow .= ' | <a ' . $view_detailshrefAttr . '>' . _l('view_details') . '</a>';
$nameRow .= '</div>';
 */





//$row[] = $aRow[db_prefix() . 'materials.remarks'];
$row[] = '<a href="' . admin_url(MATERIALS_FOLDER.'/view_rfxs/' . $aRow[db_prefix() . 'materials.remarks']) . '">' . $aRow[db_prefix() . 'materials.remarks'] . '</a><br/>';
$row[] = $aRow[db_prefix() . 'advance_leads_details.floatingdate'];
$row[] = '0' ;

    
 

    // Custom fields add values
    foreach ($customFieldsColumns as $customFieldColumn) {
        $row[] = (strpos($customFieldColumn, 'date_picker_') !== false ? _d($aRow[$customFieldColumn]) : $aRow[$customFieldColumn]);
    }

    //$row['DT_RowId'] = 'material_' . $aRow['id'];



    if (isset($row['DT_RowClass'])) {
        $row['DT_RowClass'] .= ' has-row-options';
    } else {
        $row['DT_RowClass'] = 'has-row-options';
    }

    $row = hooks()->apply_filters('materials_table_row_data', $row, $aRow);

    $output['aaData'][] = $row;


}
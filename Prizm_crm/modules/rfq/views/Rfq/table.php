<?php

defined('BASEPATH') or exit('No direct script access allowed');
$aColumns = [
    'id',
    'rfq_code',
    'assigned_eng_staff_id',
    'Acceptance',
    'created_at',

];
$join = [];
$where  = [];
$filter = false;

$additionalColumns = [
    'rel_id',
    'rel_type',
    'status',
    'attach_file1',
    'attach_file2',
    'attach_file3',
];

$sIndexColumn = 'id';
$sTable       = db_prefix() . 'rfqs';
$result       = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, $additionalColumns);

// $result       = 
// data_tables_init($aColumns, $sIndexColumn, $sTable, [], [
//     'where section =' . $params['section'].''], ['section',
//     '(SELECT GROUP_CONCAT(supervisor_id SEPARATOR ",") FROM ' . db_prefix() . 'rfq_supervisors WHERE rfq_id=' . db_prefix() . 'rfq.id ORDER BY supervisor_id) as supervisors_ids',
//     '(SELECT GROUP_CONCAT(member_id SEPARATOR ",") FROM ' . db_prefix() . 'rfq_members WHERE rfq_id=' . db_prefix() . 'rfq.id ORDER BY member_id) as members_ids'
//     ]
// );

$output  = $result['output'];
$rResult = $result['rResult'];
foreach ($rResult as $aRow) {
    $row = [];
    $row[] = $aRow['id'];
   
    //$ٌrfq_Code='<a href="' . admin_url('rfq/rfq/rfq/' . $aRow['id']) . '">' . $aRow['rfq_code'] . '</a>';
    $ٌrfq_Code='<a href="' . admin_url('rfq/rfq/rfq/' . $aRow['id']."/0/1/1/") . '">' . $aRow['rfq_code'] . '</a>';

            $ٌrfq_Code .= '<div class="row-options">';

            //$ٌrfq_Code .= '<a href="' . site_url('rfq/rfq/rfq/' . $aRow['id']) . '" target="_blank">' . _l('rfq_list_view_tooltip') . '</a>';
            $ٌrfq_Code .= '<a href="' . admin_url('rfq/rfq/rfq/' . $aRow['id']."/0/1/") . '">' . _l('view') . '</a>';

            // if (total_rows(db_prefix() . 'rfq', 'id=' . $aRow['id']) > 0) {
            //     $_data .= ' | <a href="' . admin_url('rfq/results/' . $aRow['id']) . '">' . _l('rfq_list_view_results_tooltip') . '</a>';
            // }
            $ٌrfq_Code .= $aRow['Acceptance'] != "Accepted" ? (' | <a href="' . admin_url('rfq/rfq/rfq/' . $aRow['id']) . '">' . _l('edit') . '</a>') : "";

            // $title .= ' | <a href="' . admin_url('rfq/rfq/' . $aRow['section'].'/' . $aRow['id']) . '">' . _l('edit') . '</a>';

            if (has_permission('rfq', '', 'delete')) {
                $ٌrfq_Code .= ' | <a href="' . admin_url('rfq/delete/' . $aRow['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
                //$ٌrfq_Code .= ' | <a href="' . admin_url('rfq/rfq/rfq/' . $aRow['id']."/0/1/") . '" class="text-danger _delete">' . _l('delete') . '</a>';
            }

            $ٌrfq_Code .= '</div>';
    $row[] = $ٌrfq_Code;
    $row[] = $aRow['Acceptance'];
    $rfq_manager ='<a href="' . admin_url('profile/' . $aRow['assigned_eng_staff_id']) . '">' .
    staff_profile_image($aRow['assigned_eng_staff_id'], [
        'staff-profile-image-small mright5',
        ], 'small', [
        'data-toggle' => 'tooltip',
        'data-title'  => get_staff_full_name($aRow['assigned_eng_staff_id']),
        ]) . '</a>';
    $row[] = $rfq_manager;
    
    $row[] = $aRow['created_at'];
    if ($aRow['status']==1)
    $status=    '<span class="label" style="color:green;">  <i class="fas fa-dot-circle" style="color: #64c995; margin-right:4px;"></i>Active </span>';
    else
    $status=    '<span class="label" style="color:gray;"><i class="fas fa-dot-circle" style="color: #ababab;margin-right:4px"></i>Inactive</span>';

    $row[] = $status;

    $row['DT_RowClass'] = 'has-row-options';
    $output['aaData'][] = $row;
}

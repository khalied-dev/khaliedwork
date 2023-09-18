<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>


<div id="wrapper">
    <?php echo form_hidden('material_id', $material->id) ?>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="_buttons">
                    <div class="row">
                         <div class="col-md-7 project-heading">
                            <div class="tw-flex tw-flex-wrap tw-items-center">
                                <h3 class="hide project-name"><?php echo $material->item_name; ?></h3>
                                <!-- <div id="project_view_name" class="tw-max-w-sm tw-mr-3">
                                    <div class="tw-w-full">
                                        <select class="selectpicker" id="project_top" data-width="100%"
                                            <?php ////if (count($other_projects) > 6) { ?> data-live-search="true"
                                            <?php ////} ?>>
                                            <option value="<?php //echo $project->id; ?>" selected
                                                data-content="<?php //echo $project->name; ?> - <small><?php //echo $project->client_data->company; ?></small>">
                                                <?php ////echo $project->client_data->company; ?>
                                                <?php ////echo $project->name; ?>
                                            </option>
                                            <?php ////foreach ($other_projects as $op) { ?>
                                            <option value="<?php ////echo $op['id']; ?>"
                                                data-subtext="<?php ////echo $op['company']; ?>">#<?php ////echo $op['id']; ?> -
                                                <?php ////echo $op['name']; ?></option>
                                            <?php ////} ?>
                                        </select>
                                    </div>
                                </div> -->
                                <div class="visible-xs">
                                    <div class="clearfix"></div>
                                </div>

<!--                                 <div class="tw-items-center ltr:tw-space-x-2 tw-inline-flex">
                                    <div class="tw-flex -tw-space-x-1">
                                    </div>
                                    <a href="#" data-target="#add-edit-members" data-toggle="modal"
                                        class="tw-mt-1.5 rtl:tw-mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="tw-w-5 tw-h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                        </svg>
                                    </a>
                                </div> -->
                                <?php
                               // echo '<span class="tw-ml-1 project_status tw-inline-block label project-status-' . $material->status . '" style="color:;border:1px solid ">Active</span>';
                            ?>
                            </div>
                        </div> 
                        <div class="col-md-5 text-right">
                            <?php //if (has_permission('materials', '', 'create')) { ?>
<!--                             <a href="#"
                                onclick="new_task_from_relation(undefined,'project',<?php //echo $material->id; ?>); return false;"
                                class="btn btn-primary">
                                <i class="fa-regular fa-plus tw-mr-1"></i>
                                <?php //echo _l('new_material'); ?>
                            </a> -->
                            <?php //} ?>
                            <?php
                           //$invoice_func = 'pre_invoice_project';
                           ?>
                            <?php //if (has_permission('materials', '', 'create')) { ?>
                            
                            <?php //} ?>
                            <?php
                          
                           ?>
                            <!-- <div class="btn-group">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <?php //echo _l('more'); ?> <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right width200 project-actions">
                                    <li>
                                        <a href="<?php //echo admin_url('projects/pin_action/' . $material->id); ?>">
                                            <?php ////echo $project_pin_tooltip; ?>
                                        </a>
                                    </li>
                                    <?php //if (has_permission('materials', '', 'edit')) { ?>
                                    <li>
                                        <a href="<?php ////echo admin_url('projects/project/' . $project->id); ?>">
                                            <?php //echo _l('edit_project'); ?>
                                        </a>
                                    </li>
                                    <?php //} ?>
                                    <?php //if (has_permission('materials', '', 'create')) { ?>
                                    <li>
                                        <a href="#" onclick="copy_project(); return false;">
                                            <?php //echo _l('copy_project'); ?>
                                        </a>
                                    </li>
                                    <?php //} ?>
                                    <?php //if (has_permission('materials', '', 'create') || has_permission('materials', '', 'edit')) { ?>
                                    <li class="divider"></li>
                                    <?php ////foreach ($statuses as $status) {
                            ////    if ($status['id'] == $project->status) {
                            ////        continue;
                              //// } ?>
                                    <li>
                                        <a href="#" data-name="<?php ////echo _l('project_status_' . $status['id']); ?>"
                                            onclick="project_mark_as_modal(<?php ////echo $status['id']; ?>,<?php //echo $material->id; ?>, this); return false;"><?php //echo _l('project_mark_as', 'Active'); ?></a>
                                    </li>
                                    <?php
                          // } ?>
                                    <?php //} ?>
                                    <li class="divider"></li>
                                    <?php //if (has_permission('materials', '', 'create')) { ?>
                                    <li>
                                        <a href="<?php //echo admin_url('projects/export_project_data/' . $material->id); ?>"
                                            target="_blank"><?php //echo _l('export_project_data'); ?></a>
                                    </li>
                                    <?php //} ?>
                                    <?php //if (is_admin()) { ?>
                                    <li>
                                        <a href="<?php //echo admin_url('projects/view_project_as_client/' . $material->id . '/' . $material->id); ?>"
                                            target="_blank"><?php //echo _l('project_view_as_client'); ?></a>
                                    </li>
                                    <?php //} ?>
                                    <?php //if (has_permission('projects', '', 'delete')) { ?>
                                    <li>
                                        <a href="<?php //echo admin_url('projects/delete/' . $material->id); ?>"
                                            class="_delete">
                                            <span class="text-danger"><?php //echo _l('delete_project'); ?></span>
                                        </a>
                                    </li>
                                    <?php //} ?>
                                </ul>
                            </div> -->
                        </div>
                    </div>
                </div>
                <div class="project-menu-panel tw-my-5">
                    <?php //hooks()->do_action('before_render_project_view', $material->id); ?>
                    <?php ////$this->load->view('admin/projects/project_tabs'); ?>
                </div>
                <?php
              //// if ((has_permission('materials', '', 'create') || has_permission('materials', '', 'edit'))
                ////) {
                   ?>
<!--                 <div class="alert alert-warning project-no-started-timers-found mbot15">
                    <?php ////echo _l('project_not_started_status_tasks_timers_found'); ?>
                </div> -->
                <?php
              //// } ?>
              
                <?php //$this->load->view(($tab ? $tab['view'] : 'admin/projects/project_overview')); ?>















                


<input type="hidden" id="search_key" name="search_key"  value="<?php echo str_replace( array(',', '\'', '"', ';', '<', '>', '(', ')', '/'), '-', $material->partner_item_name);  ?>" />
<!-- <input type="hidden" id="search_id" name="search_id"  value="<?php //echo $material->id ?>" /> -->

<h3 style="font-weight: 900;">Item name :</h3><h4><span style="color:blue"><?php echo $material->item_name ?></span></h4>( Num of Appearence : <span style="color:red"><?php echo $numof_item_name; ?></span> )



<br>
<br>
<br>
<br>





<div class="panel-body panel-table-full">
                        <?php render_datatable([
                    _l('id'),
                    _l('item_code'),
                    _l('item_name'),
                    _l('remarks'),
                    _l('partner'),
                    _l('partner_item_code'),
                    _l('partner_item_name'),
                ], 'materials'); ?>
                    </div>













<?php //$browser = $CI->agent->browser(); $IEfix   = ''; if ($browser == 'Internet Explorer') $IEfix = 'ie-dt-fix'; echo $IEfix ?>
<!-- 
<div class="ie-dt-fix">
<table class="dt-table-loading table table-materials" id="DataTables_Table_1">
<thead>
<tr><th>ddsf</th></tr> 
</thead>
<tbody>
<tr><td>sdf</td></tr>   
</tbody>;
</table>
</div>
-->























<br>
<br>
<br>
<br>







<div style="overflow: scroll;">
<h3 style="font-weight: 900;">RfXs Contains this Item :</h3>



<div class="panel-body panel-table-full">
                        <?php render_datatable([
                    /* _l('ID'), */
                    _l('RFX'),
                    _l('Date'),
                    _l('Qty')
                ], 'rfxs'); ?>
</div>
<br>
<br>
<br>
<br>














<!-- 
 <table class="table table-striped">

    <thead>
    <tr>
<th><h4 style="font-weight: 900;">RFX</h4></th>
<th><h4 style="font-weight: 900;">Date</h4></th>
<th><h4 style="font-weight: 900;">Qty</h4></th>
    </tr>
    </thead>

    <tbody>

    <?php  
/*       
foreach($RFXs_for_itemName_with_DateAndQty as $RFXs_with_DateAndQty){

    echo "<tr>";
    echo "<td>".$RFXs_with_DateAndQty['remarks']."</td>";
    echo "<td>".$RFXs_with_DateAndQty['floatingdate']."</td>";
    echo "<td>0</td>";
    echo "</tr>";

    }
 */
?>

    </tbody>
  </table>
</div>

 -->





















<!-- 
<br>
<br>
<br>
<br>
<h4 style="font-weight: 900;">Meta Data Fields' Specifications :</h4>
 -->
 <?php
/* 
if ($material_metadata) {
    // Create an associative array to hold the transposed data
    
    
    // Start creating the HTML table
    echo '<table class="table table-striped">';
    
   
    // Create the table header with meta_value values
   
    foreach ($material_metadata as $metadata) {
        echo '<tr>';
        echo '<th>' . $metadata['meta_field'] . '</th><td>'.$metadata['meta_value'].'</td>';
        echo '</tr>';

    }

    echo '</table>';
}
*/                                   
?>








































<br>
<br>
<br>
<br>
<h3 style="font-weight: 900;">Meta Data' Master Fields :</h3>
<div style="width:100%;background: white;padding: 20px;border-radius: 5px;">
<!-- <span style='font-size: 11px;'>Member of Group</span> :<br> -->

<!-- class="row-border table-striped" -->
 <table class="thetableee row-border" style="width:100%">
    <thead>
      <tr>
      <th style='text-align:center'>
      <a href="<?php echo admin_url(MATERIALS_FOLDER.'/managefieldsgroups/'); ?>" class="btn btn-info" style='font-size: 0.7em'>
      <i class="fa-regular tw-mr-1"></i><?php echo _l('Manage'); ?>
      </a>
      Group</th>
      <th>Actions</th>
      <th>Meta Field</th>
      <th>Num of appearenece</th>
      <th>Meta Values Captured</th>
      </tr>
    </thead>
    <tbody>
<?php




$cnt = 0;
$ignored_master_fields = array_unique($ignored_fields[0]);//the ignored Master fields 1D array from controller




////--------------is to determine group id and name for each of the captured Master Fields--------------////////////////////////////////////////////

$groupsArr = array();
$groupsArr_all = array();
$groups_m_f_NameOnly_ar = array();

$grouped_master_fields = $grouped_fields[0];//the grouped Master fields 2D array came from controller
//print_r($grouped_master_fields);

for($L = 0;  $L < sizeof($materialMetaDataMasterFields_correspondNumOfAppearenceForEach) ; $L++){
//$materialMetaDataMasterFields_correspondNumOfAppearenceForEach[$L][3] = rand(0,3);

foreach($grouped_master_fields as $grouped_m_f){
if( !strcmp( $materialMetaDataMasterFields_correspondNumOfAppearenceForEach[$L][0] , $grouped_m_f['item_name_meta_field_name'])) { 
$materialMetaDataMasterFields_correspondNumOfAppearenceForEach[$L][3] = $grouped_m_f['group_id'];
$materialMetaDataMasterFields_correspondNumOfAppearenceForEach[$L][4] = $grouped_m_f['group_name'];

//to get the only used groups of which there is fields included in them, for this item_name
array_push($groups_m_f_NameOnly_ar, $grouped_m_f['group_name']);
}/* else{
$materialMetaDataMasterFields_correspondNumOfAppearenceForEach[$L][3] = 0;
$materialMetaDataMasterFields_correspondNumOfAppearenceForEach[$L][4] = '';
} */

}

}

for($L = 0;  $L < sizeof($materialMetaDataMasterFields_correspondNumOfAppearenceForEach) ; $L++){
    $materialMetaDataMasterFields_correspondNumOfAppearenceForEach[$L][3] = isset($materialMetaDataMasterFields_correspondNumOfAppearenceForEach[$L][3]) ? $materialMetaDataMasterFields_correspondNumOfAppearenceForEach[$L][3] : 0;
    $materialMetaDataMasterFields_correspondNumOfAppearenceForEach[$L][4] = isset($materialMetaDataMasterFields_correspondNumOfAppearenceForEach[$L][4]) ? $materialMetaDataMasterFields_correspondNumOfAppearenceForEach[$L][4] : '';
}

$groups_m_f_NameOnly_ar = array_unique($groups_m_f_NameOnly_ar);

$ctrr = 0;
// pushing all groups exists in database in  'tblmaterials_metafields_groups'
foreach($fields_groupsArr as $groupsAr){
    $groupsArr_all[$ctrr]['gid'] = $groupsAr['id'];
    $groupsArr_all[$ctrr]['gname'] = $groupsAr['group_name'];
    $groupsArr_all[$ctrr]['gdetails'] = $groupsAr['group_details'];

// pushing the only used groups here in $groupsArr according to $groups_m_f_NameOnly_ar
if(in_array($groupsAr['group_name'] , $groups_m_f_NameOnly_ar)){
    $groupsArr[$ctrr]['gid'] = $groupsAr['id'];
    $groupsArr[$ctrr]['gname'] = $groupsAr['group_name'];
    $groupsArr[$ctrr]['gdetails'] = $groupsAr['group_details'];
}
    $ctrr++;
}


//exit(0);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////








//getting Single Fields
foreach($materialMetaDataMasterFields_correspondNumOfAppearenceForEach as $master_fields){

//this is the group number that the field is under it - if(value = 0) means alone not under any group , otherwize it is under some group with the given number(the value)
    //$master_fields[3] = '1';

if(!in_array($master_fields[0], $ignored_master_fields) && $master_fields[3] == 0 ){


echo "<tr>";


echo "<td style='text-align:center'>-</td>";




echo "<td>
<div class='row'>
<div class='col-md-3'>
<br>
<button id='button_do_ignore_metafield_m_".$cnt."' onclick='do_ignore_metafield(\"".$material->item_name."\", \"".$master_fields[0]."\", \"".''/* $master_fields[2] */."\", \"m\", \"button_do_ignore_metafield_m_".$cnt."\")' style='color: black; border: 2px black solid;'>ignore</button>
</div>
<div class='col-md-5'>
<select id='mgroupsselect".$cnt."' onchange='do_group_field(\"".$material->item_name."\", \"".$master_fields[0]."\", \"".''/* $master_fields[2] */."\", \"m\", \"mgroupsselect".$cnt."\")' style='border-radius: 5px; height: 25px;font-size: 0.8em;margin-top: 1.7em;'>
<option  value='0' selected>NOT Member of Group</option>";

//--------------------
foreach($groupsArr_all as $groupsAr_all)
echo "<option value='".$groupsAr_all['gid']."'>".$groupsAr_all['gname']."</option>";
//--------------------

echo "</select>
</div>
</div>
</td>";







echo "<td>".$master_fields[0]."</td>";






echo "<td>".$master_fields[1]."</td>";







echo "<td>
<div class='panel-group'>
<!--<div class='panel panel-default'>-->
    <div class='panel'>
      <div class='panel-heading'>
        <h4 class='panel-title' style='text-align:center'>
          <a data-toggle='collapse' href='#mcollapse".($cnt+1)."'>Show(".$master_fields[0].")</a>
        </h4>
      </div>
      <div id='mcollapse".($cnt+1)."' class='panel-collapse collapse'>
        <div class='panel-body'>".$master_fields[2]."</div>
        <!--<div class='panel-footer'>Panel Footer</div>-->
      </div>
    </div>
  </div>
</td>";





echo "</tr>";

}

$cnt++;
}
















// Getting Group that each field/s contained in, from the resulted array '$groupsArr'  above , for presenting the fields inside each group gonna be visualized in the Datatable --------------------------------
$groupsArray = array();
foreach($groupsArr as $g_arr){

 $groupsArrayElement = array(); 
 array_push($groupsArrayElement,$g_arr['gname']);
 array_push($groupsArrayElement,$g_arr['gid']);

    $buff = array(); 
    foreach($materialMetaDataMasterFields_correspondNumOfAppearenceForEach as $master_fields){
      if($master_fields[3] == $g_arr['gid']){
        $buff2 = array('fieldsArr' => [],'noOfApArr' => [],'valuesArr' => [] );    
        array_push($buff2['fieldsArr'],$master_fields[0]);
        array_push($buff2['noOfApArr'],$master_fields[1]);
        array_push($buff2['valuesArr'],$master_fields[2]);
        array_push($buff,$buff2);
        }
    }

array_push($groupsArrayElement,$buff);

array_push($groupsArray, $groupsArrayElement);

}//end foreach($groupsArr as $g_arr)

/* 
To Refrence to any Section of the Groups' resulted array '$groupsArray'  => is like the following Explanation :
print_r(
$groupsArray[0  ...  < TotalNumOfGroups]
then [0  ...   2]   where [0] => 'gname'    [1] => 'gid'    [2] => 'ArrayOfFieldsUnderThisGroup'
then [0  ...   < NumOfFieldsUnderTheSpecificGroup]
then ['fieldsArr'  or  'noOfApArr'  or  'valuesArr']   where 'fieldsArr' => 'theCorrespondNameForEachFieldUnderTheSpecificGroup'   ,   where 'noOfApArr' => 'theCorrespondNumOfAppearenceForEachFieldUnderTheSpecificGroup'   ,   where 'valuesArr' => 'theCorrespondValuesForEachNameForEachOfFieldUnderTheSpecificGroup'   
then [0  ...   < NumOf(fieldsArr or noOfApArr or valuesArr)ForFieldsUnderTheSpecificGroup]        
        )*/

//example :
//print_r($groupsArray[0][2][0]['fieldsArr'][0]);
// ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

//Start presenting groups in datatable-----------------------------------------------------------------------------------------------------------------------------------------------
$cntt = 0;
$cntt_in = 0;
$cntt_in2 = 0;
foreach($groupsArray as $g_ar){


echo "<tr>
<td><div class='panel-group'>
        <div class=''>
          <div class='panel-heading'>
            <h4 class='panel-title' style='text-align:center'>
              <a data-toggle='collapse' href='.mgroupcollapse".($cntt+1)."'>".$g_ar[0]."</a>
            </h4>
          </div>
          <div id='' class='panel-collapse collapse mgroupcollapse".($cntt+1)."'></div>
        </div>
      </div></td>








<td><div class='panel-group'>
<div class='panel'>
 <a data-toggle='collapse' href='.mgroupcollapse".($cntt+1)."'></a>
  <div id='' class='panel-collapse collapse mgroupcollapse".($cntt+1)."'>
    <div class='panel-body' style='padding-top: 0.5rem;'>";
foreach($g_ar[2] as $g_arr){
echo "<div class='row'>
    <div class='col-md-3'>
    <br>
    <button id='button_do_ignore_metafield_m_g_".($cntt_in+1)."' onclick='do_ignore_metafield(\"".$material->item_name."\", \"".$g_arr['fieldsArr'][0]."\", \"".''/* $master_fields[2] */."\", \"m\", \"button_do_ignore_metafield_m_g_".($cntt_in+1)."\")' style='color: black; border: 2px black solid;'>ignore</button>
    </div>
    <div class='col-md-5'>
    <select  id='mgroupsselect_c".$cntt_in."' onchange='do_group_field(\"".$material->item_name."\", \"".$g_arr['fieldsArr'][0]."\", \"".''/* $g_arr['valuesArr'][0] */."\", \"m\", \"mgroupsselect_c".$cntt_in."\")' style='border-radius: 5px; height: 25px;font-size: 0.8em;margin-top: 1.7em;'>
    <option value='ungr'>UNgroup</option>";
    foreach($groupsArr_all as $groupsAr_all)
    echo "<option ".($groupsAr_all['gid']==$g_ar[1] ? "selected" : "" )." value='".$groupsAr_all['gid']."'>".$groupsAr_all['gname']."</option>";
echo "</select>
    </div>
    </div>";   
$cntt_in++;
}   
echo "</div>
  </div>
</div>
</div></td>









<td><div class='panel-group'>
<div class='panel'>
      <a data-toggle='collapse' href='.mgroupcollapse".($cntt+1)."'></a>
  <div id='' class='panel-collapse collapse mgroupcollapse".($cntt+1)."'>
    <div class='panel-body'>
    <table>";
    foreach($g_ar[2] as $g_arr)
    echo "<tr><td style='padding-top:12px'>".$g_arr['fieldsArr'][0]."</td><tr>";
echo "</table>
</div>
  </div>
</div>
</div></td>








<td><div class='panel-group'>
<div class='panel'>
      <a data-toggle='collapse' href='.mgroupcollapse".($cntt+1)."'></a>
  <div id='' class='panel-collapse collapse mgroupcollapse".($cntt+1)."'>
    <div class='panel-body'>
    <table>";
    foreach($g_ar[2] as $g_arr)
    echo "<tr><td style='padding-top:12px'>".$g_arr['noOfApArr'][0]."</td><tr>";
echo "</table>
    </div>
  </div>
</div>
</div></td>









<td><div class='panel-group'>
<div class='panel'>
      <a data-toggle='collapse' href='.mgroupcollapse".($cntt+1)."'></a>
  <div id='' class='panel-collapse collapse mgroupcollapse".($cntt+1)."'>
    <div class='panel-body'>";

    foreach($g_ar[2] as $g_arr){
echo "<div class='panel-group' style='margin-bottom: 0px;'>
    <div class=''>
      <div class='panel-heading'>
        <h4 class='panel-title' style='text-align:center'>
          <a data-toggle='collapse' href='#mgroupcollapsev".($cntt_in2+1)."'>Show (".$g_arr['fieldsArr'][0].")</a>
        </h4>
      </div>
      <div id='mgroupcollapsev".($cntt_in2+1)."' class='panel-collapse collapse'><div class='panel-body'>".$g_arr['valuesArr'][0]."</div></div>
    </div>
  </div>";
  $cntt_in2++;   
    }
echo "</div>
  </div>
</div>
</div></td>


</tr>";

$cntt++;
}


?>
    </tbody>
  </table>
</div>
<!-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->































































<br>
<br>
<br>
<br>
<h3 style="font-weight: 900;">Meta Data' General Fields :</h3>
<div style="width:100%;background: white;padding: 20px;border-radius: 5px;">
<!-- <span style='font-size: 11px;'>Member of Group</span> :<br> -->

<!-- class="row-border table-striped" -->
 <table class="thetableee row-border" style="width:100%">
    <thead>
      <tr>
      <th style='text-align:center'>
      <a href="<?php echo admin_url(MATERIALS_FOLDER.'/managefieldsgroups/'); ?>" class="btn btn-info" style='font-size: 0.7em'>
      <i class="fa-regular tw-mr-1"></i><?php echo _l('Manage'); ?>
      </a>
      Group</th>
      <th>Actions</th>
      <th>Meta Field</th>
      <th>Num of appearenece</th>
      <th>Meta Values Captured</th>
      </tr>
    </thead>
    <tbody>
<?php




$cnt = 0;
$ignored_general_fields = array_unique($ignored_fields[1]);//the ignored Master fields 1D array from controller




////--------------is to determine group id and name for each of the captured Master Fields--------------////////////////////////////////////////////

$groupsArr = array();
$groupsArr_all = array();
$groups_g_f_NameOnly_ar = array();

$grouped_general_fields = $grouped_fields[1];//the grouped Master fields 2D array came from controller
//print_r($grouped_general_fields);

for($L = 0;  $L < sizeof($materialMetaDataGeneralFields_correspondNumOfAppearenceForEach) ; $L++){
//$materialMetaDataGeneralFields_correspondNumOfAppearenceForEach[$L][3] = rand(0,3);

foreach($grouped_general_fields as $grouped_g_f){
if( !strcmp( $materialMetaDataGeneralFields_correspondNumOfAppearenceForEach[$L][0] , $grouped_g_f['item_name_meta_field_name'])) { 
$materialMetaDataGeneralFields_correspondNumOfAppearenceForEach[$L][3] = $grouped_g_f['group_id'];
$materialMetaDataGeneralFields_correspondNumOfAppearenceForEach[$L][4] = $grouped_g_f['group_name'];

//to get the only used groups of which there is fields included in them, for this item_name
array_push($groups_g_f_NameOnly_ar, $grouped_g_f['group_name']);
}/* else{
$materialMetaDataGeneralFields_correspondNumOfAppearenceForEach[$L][3] = 0;
$materialMetaDataGeneralFields_correspondNumOfAppearenceForEach[$L][4] = '';
} */

}

}

for($L = 0;  $L < sizeof($materialMetaDataGeneralFields_correspondNumOfAppearenceForEach) ; $L++){
    $materialMetaDataGeneralFields_correspondNumOfAppearenceForEach[$L][3] = isset($materialMetaDataGeneralFields_correspondNumOfAppearenceForEach[$L][3]) ? $materialMetaDataGeneralFields_correspondNumOfAppearenceForEach[$L][3] : 0;
    $materialMetaDataGeneralFields_correspondNumOfAppearenceForEach[$L][4] = isset($materialMetaDataGeneralFields_correspondNumOfAppearenceForEach[$L][4]) ? $materialMetaDataGeneralFields_correspondNumOfAppearenceForEach[$L][4] : '';
}

$groups_g_f_NameOnly_ar = array_unique($groups_g_f_NameOnly_ar);

$ctrr = 0;
// pushing all groups exists in database in  'tblmaterials_metafields_groups'
foreach($fields_groupsArr as $groupsAr){
    $groupsArr_all[$ctrr]['gid'] = $groupsAr['id'];
    $groupsArr_all[$ctrr]['gname'] = $groupsAr['group_name'];
    $groupsArr_all[$ctrr]['gdetails'] = $groupsAr['group_details'];

// pushing the only used groups here in $groupsArr according to $groups_g_f_NameOnly_ar
if(in_array($groupsAr['group_name'] , $groups_g_f_NameOnly_ar)){
    $groupsArr[$ctrr]['gid'] = $groupsAr['id'];
    $groupsArr[$ctrr]['gname'] = $groupsAr['group_name'];
    $groupsArr[$ctrr]['gdetails'] = $groupsAr['group_details'];
}
    $ctrr++;
}


//exit(0);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////








//getting Single Fields
foreach($materialMetaDataGeneralFields_correspondNumOfAppearenceForEach as $general_fields){

//this is the group number that the field is under it - if(value = 0) means alone not under any group , otherwize it is under some group with the given number(the value)
    //$general_fields[3] = '1';

if(!in_array($general_fields[0], $ignored_general_fields) && $general_fields[3] == 0 ){


echo "<tr>";


echo "<td style='text-align:center'>-</td>";




echo "<td>
<div class='row'>
<div class='col-md-3'>
<br>
<button id='button_do_ignore_metafield_g_".$cnt."' onclick='do_ignore_metafield(\"".$material->item_name."\", \"".$general_fields[0]."\", \"".''/* $general_fields[2] */."\", \"g\", \"button_do_ignore_metafield_g_".$cnt."\")' style='color: black; border: 2px black solid;'>ignore</button>
</div>
<div class='col-md-5'>
<select id='ggroupsselect".$cnt."' onchange='do_group_field(\"".$material->item_name."\", \"".$general_fields[0]."\", \"".''/* $general_fields[2] */."\", \"g\", \"ggroupsselect".$cnt."\")' style='border-radius: 5px; height: 25px;font-size: 0.8em;margin-top: 1.7em;'>
<option  value='0' selected>NOT Member of Group</option>";

//--------------------
foreach($groupsArr_all as $groupsAr_all)
echo "<option value='".$groupsAr_all['gid']."'>".$groupsAr_all['gname']."</option>";
//--------------------

echo "</select>
</div>
</div>
</td>";







echo "<td>".$general_fields[0]."</td>";






echo "<td>".$general_fields[1]."</td>";







echo "<td>
<div class='panel-group'>
<!--<div class='panel panel-default'>-->
    <div class='panel'>
      <div class='panel-heading'>
        <h4 class='panel-title' style='text-align:center'>
          <a data-toggle='collapse' href='#gcollapse".($cnt+1)."'>Show(".$general_fields[0].")</a>
        </h4>
      </div>
      <div id='gcollapse".($cnt+1)."' class='panel-collapse collapse'>
        <div class='panel-body'>".$general_fields[2]."</div>
        <!--<div class='panel-footer'>Panel Footer</div>-->
      </div>
    </div>
  </div>
</td>";





echo "</tr>";

}

$cnt++;
}
















// Getting Group that each field/s contained in, from the resulted array '$groupsArr'  above , for presenting the fields inside each group gonna be visualized in the Datatable --------------------------------
$groupsArray = array();
foreach($groupsArr as $g_arr){

 $groupsArrayElement = array(); 
 array_push($groupsArrayElement,$g_arr['gname']);
 array_push($groupsArrayElement,$g_arr['gid']);

    $buff = array(); 
    foreach($materialMetaDataGeneralFields_correspondNumOfAppearenceForEach as $general_fields){
      if($general_fields[3] == $g_arr['gid']){
        $buff2 = array('fieldsArr' => [],'noOfApArr' => [],'valuesArr' => [] );    
        array_push($buff2['fieldsArr'],$general_fields[0]);
        array_push($buff2['noOfApArr'],$general_fields[1]);
        array_push($buff2['valuesArr'],$general_fields[2]);
        array_push($buff,$buff2);
        }
    }

array_push($groupsArrayElement,$buff);

array_push($groupsArray, $groupsArrayElement);

}//end foreach($groupsArr as $g_arr)

/* 
To Refrence to any Section of the Groups' resulted array '$groupsArray'  => is like the following Explanation :
print_r(
$groupsArray[0  ...  < TotalNumOfGroups]
then [0  ...   2]   where [0] => 'gname'    [1] => 'gid'    [2] => 'ArrayOfFieldsUnderThisGroup'
then [0  ...   < NumOfFieldsUnderTheSpecificGroup]
then ['fieldsArr'  or  'noOfApArr'  or  'valuesArr']   where 'fieldsArr' => 'theCorrespondNameForEachFieldUnderTheSpecificGroup'   ,   where 'noOfApArr' => 'theCorrespondNumOfAppearenceForEachFieldUnderTheSpecificGroup'   ,   where 'valuesArr' => 'theCorrespondValuesForEachNameForEachOfFieldUnderTheSpecificGroup'   
then [0  ...   < NumOf(fieldsArr or noOfApArr or valuesArr)ForFieldsUnderTheSpecificGroup]        
        )*/

//example :
//print_r($groupsArray[0][2][0]['fieldsArr'][0]);
// ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

//Start presenting groups in datatable-----------------------------------------------------------------------------------------------------------------------------------------------
$cntt = 0;
$cntt_in = 0;
$cntt_in2 = 0;
foreach($groupsArray as $g_ar){


echo "<tr>
<td><div class='panel-group'>
        <div class=''>
          <div class='panel-heading'>
            <h4 class='panel-title' style='text-align:center'>
              <a data-toggle='collapse' href='.ggroupcollapse".($cntt+1)."'>".$g_ar[0]."</a>
            </h4>
          </div>
          <div id='' class='panel-collapse collapse ggroupcollapse".($cntt+1)."'></div>
        </div>
      </div></td>








<td><div class='panel-group'>
<div class='panel'>
 <a data-toggle='collapse' href='.ggroupcollapse".($cntt+1)."'></a>
  <div id='' class='panel-collapse collapse ggroupcollapse".($cntt+1)."'>
    <div class='panel-body' style='padding-top: 0.5rem;'>";
foreach($g_ar[2] as $g_arr){
echo "<div class='row'>
    <div class='col-md-3'>
    <br>
    <button id='button_do_ignore_metafield_g_g_".($cntt_in+1)."' onclick='do_ignore_metafield(\"".$material->item_name."\", \"".$g_arr['fieldsArr'][0]."\", \"".''/* $general_fields[2] */."\", \"g\", \"button_do_ignore_metafield_g_g_".($cntt_in+1)."\")' style='color: black; border: 2px black solid;'>ignore</button>
    </div>
    <div class='col-md-5'>
    <select  id='ggroupsselect_c".$cntt_in."' onchange='do_group_field(\"".$material->item_name."\", \"".$g_arr['fieldsArr'][0]."\", \"".''/* $g_arr['valuesArr'][0] */."\", \"g\", \"ggroupsselect_c".$cntt_in."\")' style='border-radius: 5px; height: 25px;font-size: 0.8em;margin-top: 1.7em;'>
    <option value='ungr'>UNgroup</option>";
    foreach($groupsArr_all as $groupsAr_all)
    echo "<option ".($groupsAr_all['gid']==$g_ar[1] ? "selected" : "" )." value='".$groupsAr_all['gid']."'>".$groupsAr_all['gname']."</option>";
echo "</select>
    </div>
    </div>";   
$cntt_in++;
}   
echo "</div>
  </div>
</div>
</div></td>









<td><div class='panel-group'>
<div class='panel'>
      <a data-toggle='collapse' href='.ggroupcollapse".($cntt+1)."'></a>
  <div id='' class='panel-collapse collapse ggroupcollapse".($cntt+1)."'>
    <div class='panel-body'>
    <table>";
    foreach($g_ar[2] as $g_arr)
    echo "<tr><td style='padding-top:12px'>".$g_arr['fieldsArr'][0]."</td><tr>";
echo "</table>
</div>
  </div>
</div>
</div></td>








<td><div class='panel-group'>
<div class='panel'>
      <a data-toggle='collapse' href='.ggroupcollapse".($cntt+1)."'></a>
  <div id='' class='panel-collapse collapse ggroupcollapse".($cntt+1)."'>
    <div class='panel-body'>
    <table>";
    foreach($g_ar[2] as $g_arr)
    echo "<tr><td style='padding-top:12px'>".$g_arr['noOfApArr'][0]."</td><tr>";
echo "</table>
    </div>
  </div>
</div>
</div></td>









<td><div class='panel-group'>
<div class='panel'>
      <a data-toggle='collapse' href='.ggroupcollapse".($cntt+1)."'></a>
  <div id='' class='panel-collapse collapse ggroupcollapse".($cntt+1)."'>
    <div class='panel-body'>";

    foreach($g_ar[2] as $g_arr){
echo "<div class='panel-group' style='margin-bottom: 0px;'>
    <div class=''>
      <div class='panel-heading'>
        <h4 class='panel-title' style='text-align:center'>
          <a data-toggle='collapse' href='#ggroupcollapsev".($cntt_in2+1)."'>Show (".$g_arr['fieldsArr'][0].")</a>
        </h4>
      </div>
      <div id='ggroupcollapsev".($cntt_in2+1)."' class='panel-collapse collapse'><div class='panel-body'>".$g_arr['valuesArr'][0]."</div></div>
    </div>
  </div>";
  $cntt_in2++;   
    }
echo "</div>
  </div>
</div>
</div></td>


</tr>";

$cntt++;
}


?>
    </tbody>
  </table>
</div>
<!-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->




















































            </div>
        </div>
    </div>
</div>
</div>
</div>

<div class="modal fade" id="add-edit-members" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <?php echo form_open(admin_url('projects/add_edit_members/' . $material->id)); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo _l('project_members'); ?></h4>
            </div>
            <div class="modal-body">
             
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                <button type="submit" class="btn btn-primary" autocomplete="off"
                    data-loading-text="<?php echo _l('wait_text'); ?>"><?php echo _l('submit'); ?></button>
            </div>
        </div>
        <!-- /.modal-content -->
        <?php echo form_close(); ?>
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<?php
   //echo form_hidden('project_percent', $percent);
?>
<div id="invoice_project"></div>
<div id="pre_invoice_project"></div>
<?php //$this->load->view('admin/projects/milestone'); ?>
<?php //$this->load->view('admin/projects/copy_settings'); ?>
<?php //$this->load->view('admin/projects/_mark_tasks_finished'); ?>
<?php init_tail(); ?>
<!-- For invoices table -->
<script>
//taskid = '<?php //echo $this->input->get('taskid'); ?>';
</script>
<script>






$(function() {
    //console.log($('#search_key').val());
    initDataTable('.table-materials',  admin_url + 'materials/table/'+ $('#search_key').val());
    initDataTable('.table-rfxs',  admin_url + 'materials/tablerfx/'+ $('#search_key').val());
} ); 


function do_ignore_metafield(material_partner_item_namee, item_name_meta_field_namee, item_name_meta_field_valuess, master_or_generall, button_do_ignore_metafield){

$.ajax({
  method: "POST",
  url: admin_url+"materials/do_ignore_metafield/",
  data: { material_partner_item_name: material_partner_item_namee, item_name_meta_field_name: item_name_meta_field_namee, item_name_meta_field_values: item_name_meta_field_valuess, master_or_general : master_or_generall}
}).done(function( response ) {

//console.log("response is :"+response);
    
if(response == "success"){
alert('Added Successfully to the Ignored List');
//set_alert('success', _l('Added Successfully to the Ignored List', _l('Material')));
document.getElementById(""+button_do_ignore_metafield).style += "background: transparent; border: 2px #cfcfcf solid; color: #b5b1b1";
document.getElementById(""+button_do_ignore_metafield).disabled = "disabled";
document.getElementById(""+button_do_ignore_metafield).innerHTML = "ignored";

}else if(response == "fail")
alert('Unsuccessfully Ignored');
//set_alert('fail', _l('Unsuccessfully Ignored', _l('Material')));

else if(response == "empty")
alert('Empty Item Name ! ');
//set_alert('info', _l('Empty Item Name ! ', _l('Material')));

else if(response == "access_denied"){
alert('Access Denied for user ! ');
//set_alert('info', _l('Access Denied for user ! ', _l('Material')));
access_denied('Material Add');
}
});

  //console.log("counter is :"+counter); 

}











function do_group_field(material_partner_item_namee, item_name_meta_field_namee, item_name_meta_field_valuess, master_or_generall, menu_do_group_field){

var groupidd = document.getElementById(""+menu_do_group_field).value ; 

if(groupidd == 'ungr'){
//whatto => gr : grouping  ,  ungr : ungrouping
whattoo = "ungr"; 
groupidd = -1;
}else {whattoo = "gr";}

if(confirm((whattoo == "gr" ? "Adding" : "Removing")+" field "+(whattoo == "gr" ? "to" : "from")+" Group ? ") && groupidd != 0){

$.ajax({
  method: "POST",
  url: admin_url+"materials/do_group_ungroup_field/",
  data: { whatto : whattoo, material_partner_item_name: material_partner_item_namee, item_name_meta_field_name: item_name_meta_field_namee, item_name_meta_field_values: item_name_meta_field_valuess, master_or_general : master_or_generall, groupid : groupidd}
}).done(function( response ) {

//console.log("response is :"+response);
    
if(response == "success"){
alert('Field Successfully grouped');
//set_alert('success', _l('Field Successfully grouped', _l('Material')));
location.reload();

}else if(response == "deleted"){
alert('Successfully UNGrouped');
location.reload();
//set_alert('fail', _l('Unsuccessfully Ignored', _l('Material')));

}else if(response == "fail")
alert('Unsuccessfully Grouped');
//set_alert('fail', _l('Unsuccessfully Ignored', _l('Material')));

else if(response == "empty")
alert('Empty Item Name ! ');
//set_alert('info', _l('Empty Item Name ! ', _l('Material')));

else if(response == "access_denied"){
alert('Access Denied for user ! ');
//set_alert('info', _l('Access Denied for user ! ', _l('Material')));
access_denied('Material Add');
}
});
}//end if
else;
  //console.log("counter is :"+counter); 

}















let table = new DataTable('.thetableee', {
    scrollX: true,
    columnDefs: [{ width: 400, targets: 1 }/* ,{ width: 400, targets: 1 },{ width: 50, targets: 0 } */],
    fixedColumns: true,
 /* paging: false, */
    scrollCollapse: true,
 /*
    "columnDefs": [
        {"className": "dt-center", "targets": "_all"}
      ],
    autoWidth: true,
    scrollY: 200 */});



/* 






var gantt_data = {};
<?php /////////////if (isset($gantt_data)) { ?>
gantt_data = <?php //////////////echo json_encode($gantt_data); ?>;
<?php /////////} ?>
var discussion_id = $('input[name="discussion_id"]').val();
var discussion_user_profile_image_url = $('input[name="discussion_user_profile_image_url"]').val();
var current_user_is_admin = $('input[name="current_user_is_admin"]').val();
var project_id = $('input[name="project_id"]').val();
if (typeof(discussion_id) != 'undefined') {
    discussion_comments('#discussion-comments', discussion_id, 'regular');
}
$(function() {
    var project_progress_color =
        '<?php ////////////echo hooks()->apply_filters('admin_project_progress_color', '#84c529'); ?>';
    var circle = $('.project-progress').circleProgress({
        fill: {
            gradient: [project_progress_color, project_progress_color]
        }
    }).on('circle-animation-progress', function(event, progress, stepValue) {
        $(this).find('strong.project-percent').html(parseInt(100 * stepValue) + '<i>%</i>');
    });
});

function discussion_comments(selector, discussion_id, discussion_type) {
    var defaults = _get_jquery_comments_default_config(
        <?php ////////////echo json_encode(get_project_discussions_language_array()); ?>);
    var options = {
        // https://github.com/Viima/jquery-comments/pull/169
        wysiwyg_editor: {
            opts: {
                enable: true,
                is_html: true,
                container_id: 'editor-container',
                comment_index: 0,
            },
            init: function(textarea, content) {
                var comment_index = textarea.data('comment_index');
                var editorConfig = _simple_editor_config();
                editorConfig.setup = function(ed) {
                    textarea.data('wysiwyg_editor', ed);

                    ed.on('change', function() {
                        var value = ed.getContent();
                        if (value !== ed._lastChange) {
                            ed._lastChange = value;
                            textarea.trigger('change');
                        }
                    });

                    ed.on('keyup', function() {
                        var value = ed.getContent();
                        if (value !== ed._lastChange) {
                            ed._lastChange = value;
                            textarea.trigger('change');
                        }
                    });

                    ed.on('Focus', function(e) {
                        setTimeout(function() {
                            textarea.trigger('click');
                        }, 500)
                    });

                    ed.on('init', function() {
                        if (content) ed.setContent(content);

                        if ($('#mention-autocomplete-css').length === 0) {
                            $('<link>').appendTo('head').attr({
                                id: 'mention-autocomplete-css',
                                type: 'text/css',
                                rel: 'stylesheet',
                                href: site_url +
                                    'assets/plugins/tinymce/plugins/mention/autocomplete.css'
                            });
                        }

                        if ($('#mention-css').length === 0) {
                            $('<link>').appendTo('head').attr({
                                type: 'text/css',
                                id: 'mention-css',
                                rel: 'stylesheet',
                                href: site_url +
                                    'assets/plugins/tinymce/plugins/mention/rte-content.css'
                            });
                        }
                    })
                }

                editorConfig.toolbar = editorConfig.toolbar.replace('alignright', 'alignright strikethrough')
                editorConfig.plugins[0] += ' mention';
                editorConfig.content_style = 'span.mention {\
                     background-color: #eeeeee;\
                     padding: 3px;\
                  }';
                var projectUserMentions = [];
                editorConfig.mentions = {
                    source: function(query, process, delimiter) {
                        if (projectUserMentions.length < 1) {
                            $.getJSON(admin_url + 'projects/get_staff_names_for_mentions/' + project_id,
                                function(data) {
                                    projectUserMentions = data;
                                    process(data)
                                });
                        } else {
                            process(projectUserMentions)
                        }
                    },
                    insert: function(item) {
                        return '<span class="mention" contenteditable="false" data-mention-id="' + item
                            .id + '">@' +
                            item.name + '</span>&nbsp;';
                    }
                };

                var containerId = this.get_container_id(comment_index);
                tinyMCE.remove('#' + containerId);

                setTimeout(function() {
                    init_editor('#' + containerId, editorConfig)
                }, 100)
            },
            get_container: function(textarea) {
                if (!textarea.data('comment_index')) {
                    textarea.data('comment_index', ++this.opts.comment_index);
                }

                return $('<div/>', {
                    'id': this.get_container_id(this.opts.comment_index)
                });
            },
            get_contents: function(editor) {
                return editor.getContent();
            },
            on_post_comment: function(editor, evt) {
                editor.setContent('');
            },
            get_container_id: function(comment_index) {
                var container_id = this.opts.container_id;
                if (comment_index) container_id = container_id + "-" + comment_index;
                return container_id;
            }
        },
        currentUserIsAdmin: current_user_is_admin,
        getComments: function(success, error) {
            $.get(admin_url + 'projects/get_discussion_comments/' + discussion_id + '/' + discussion_type,
                function(response) {
                    success(response);
                }, 'json');
        },
        postComment: function(commentJSON, success, error) {
            $.ajax({
                type: 'post',
                url: admin_url + 'projects/add_discussion_comment/' + discussion_id + '/' +
                    discussion_type,
                data: commentJSON,
                success: function(comment) {
                    comment = JSON.parse(comment);
                    success(comment)
                },
                error: error
            });
        },
        putComment: function(commentJSON, success, error) {
            $.ajax({
                type: 'post',
                url: admin_url + 'projects/update_discussion_comment',
                data: commentJSON,
                success: function(comment) {
                    comment = JSON.parse(comment);
                    success(comment)
                },
                error: error
            });
        },
        deleteComment: function(commentJSON, success, error) {
            $.ajax({
                type: 'post',
                url: admin_url + 'projects/delete_discussion_comment/' + commentJSON.id,
                success: success,
                error: error
            });
        },
        uploadAttachments: function(commentArray, success, error) {
            var responses = 0;
            var successfulUploads = [];
            var serverResponded = function() {
                responses++;
                // Check if all requests have finished
                if (responses == commentArray.length) {
                    // Case: all failed
                    if (successfulUploads.length == 0) {
                        error();
                        // Case: some succeeded
                    } else {
                        successfulUploads = JSON.parse(successfulUploads);
                        success(successfulUploads)
                    }
                }
            }
            $(commentArray).each(function(index, commentJSON) {
                // Create form data
                var formData = new FormData();
                if (commentJSON.file.size && commentJSON.file.size > app
                    .max_php_ini_upload_size_bytes) {
                    alert_float('danger', "<?php //////////////echo _l('file_exceeds_max_filesize'); ?>");
                    serverResponded();
                } else {
                    $(Object.keys(commentJSON)).each(function(index, key) {
                        var value = commentJSON[key];
                        if (value) formData.append(key, value);
                    });

                    if (typeof(csrfData) !== 'undefined') {
                        formData.append(csrfData['token_name'], csrfData['hash']);
                    }
                    $.ajax({
                        url: admin_url + 'projects/add_discussion_comment/' + discussion_id +
                            '/' + discussion_type,
                        type: 'POST',
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(commentJSON) {
                            successfulUploads.push(commentJSON);
                            serverResponded();
                        },
                        error: function(data) {
                            var error = JSON.parse(data.responseText);
                            alert_float('danger', error.message);
                            serverResponded();
                        },
                    });
                }
            });
        }
    }
    var settings = $.extend({}, defaults, options);
    $(selector).comments(settings);
} */
</script>
</body>

</html>
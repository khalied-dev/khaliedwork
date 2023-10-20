<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head();
?>
<?php
$bgcolor = 'bg-secondary';
if (isset($id)) {
    $TemplatesList = [];
    $i = 0;

    foreach ($rfqTemplates as $rfqTemplate) {
        $TemplatesList[$i] = ['id' => $rfqTemplate['id'], 'templateName' => $rfqTemplate['templateName']];

        $TemplateId = $rfqTemplate['id'];
        $rfqColumns = $this->Rfq_model->get_templete_columns($TemplateId);
        $TemplatesList[$i]['columns'] = [];
        $rfqTemplateindex = 0;
        $TemplatesList[$i]['Rows'][$rfqTemplateindex][] = null;
        foreach ($rfqColumns as $rfqColumn) {
            $colindex = 0;
            $TemplatesList[$i]['columns'][] = ['id' => $rfqColumn['id'], 'ColumnName' => $rfqColumn['ColumnName']];
            $ColumnId = $rfqColumn['id'];
            $rfqItemAttirbutes = $this->Rfq_model->get_column_attribute($ColumnId);
            foreach ($rfqItemAttirbutes as $rfqItemAttirbute) {
                $TemplatesList[$i]['Rows'][$colindex][$rfqTemplateindex] = $rfqItemAttirbute['description'];
                $colindex++;
            }
            $rfqTemplateindex++;
        }
        $i++;
    }
}
?>
<style>
    .addReadMore.showlesscontent .SecSec,
    .addReadMore.showlesscontent .readLess {
        display: none;
    }

    .addReadMore.showmorecontent .readMore {
        display: none;
    }

    .addReadMore .readMore,
    .addReadMore .readLess {
        font-weight: bold;
        margin-left: 2px;
        color: blue;
        cursor: pointer;
    }

    .addReadMoreWrapTxt.showmorecontent .SecSec,
    .addReadMoreWrapTxt.showmorecontent .readLess {
        display: block;
    }

    /* table td:nth-child(2),
                                    table td:nth-child(3) {
                                        /* white-space:nowrap !important;
                                        width: 1px !important;
                                        border-spacing: 0px;
                                        table-layout: fixed;
                                        margin-left:auto;
                                        margin-right:auto;
                                    } */

    .fileUpload {
        position: relative;
        overflow: hidden;
        margin: 0px;
        margin-top: -6px;
    }

    .fileUpload input.upload {
        position: absolute;
        top: 0;
        right: 0;
        margin: 0;
        padding: 0;
        font-size: 20px;
        cursor: pointer;
        opacity: 0;
        filter: alpha(opacity=0);
    }



/*the container must be positioned relative:*/
.autocomplete {
  position: relative;
  display: inline-block;
}


.autocomplete-items {
  position: absolute;
  border: 1px solid #d4d4d4;
  border-bottom: none;
  border-top: none;
  z-index: 99;
  /*position the autocomplete items to be the same width as the container:*/
  top: 100%;
  left: 0;
  right: 0;
}

.autocomplete-items div {
  padding: 10px;
  cursor: pointer;
  background-color: #fff; 
  border-bottom: 1px solid #d4d4d4; 
}

/*when hovering an item:*/
.autocomplete-items div:hover {
  background-color: #e9e9e9; 
}

/*when navigating through the items using the arrow keys:*/
.autocomplete-active {
  background-color: DodgerBlue !important; 
  color: #ffffff; 
}
</style>
<!-- <div id="wrapper" onmousedown="mouseClickEventHandl(event)"> -->
<div id="wrapper" >
    <div class="content">
        <div class="row">




















































<!-- ////////////////////////heeeeeeeeeeeeeeeeeeeereeeeeeeeeeeeee the main form starts   --> 
<!-- (isset($id) ? "0/1/" : "") => can be 1 or any other symbol except being Empty("") or null -->         
            <?php echo form_open($this->uri->uri_string()/* .(isset($id) ? "/0/1/" : "") */, ['id' => 'rfq_form']); ?>
            <div class="col-md-12">
                <h4 class="tw-mt-0 tw-font-semibold tw-text-lg tw-text-neutral-700">
<?php if($isdisabled == '1' && $rfqRow->Acceptance != "Accepted"){ ?>
                <a href="<?= admin_url('rfq/rfq/rfq/' . $id); ?>" style="font-size: 20px !important;" class="btn btn-primary m-2" >edit</a>
<?php } ?>
                <?php echo $title; ?>
                </h4>
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="horizontal-scrollable-tabs panel-full-width-tabs">
                            <div class="scroller arrow-left"><i class="fa fa-angle-left"></i></div>
                            <div class="scroller arrow-right"><i class="fa fa-angle-right"></i></div>
                            <div class="horizontal-tabs">
                                <ul class="nav nav-tabs nav-tabs-horizontal" role="tablist">
                                    <li role="presentation" class="active">
                                        <a href="#tab_request_for_quotation" aria-controls="tab_request_for_quotation"
                                            role="tab" data-toggle="tab">
                                            <?php echo _l('request_for_quotation'); ?>
                                        </a>
                                    </li>
                                    <!-- <li role="presentation">
                                        <a href="#tab_settings" aria-controls="tab_settings" role="tab"
                                            data-toggle="tab">
                                            <?php //echo _l('request_for_quotation_settings');
                                            ?>
                                        </a>
                                    </li> -->
                                </ul>
                            </div>
                        </div>
                        <div class="tab-content tw-mt-3">
                            <div role="tabpanel" class="tab-pane active" id="tab_request_for_quotation">
                                <div class="row"
                                    style="padding-top: 10px;padding-bottom: 5px;margin-bottom: 15px;margin-left: 0px;border-radius: 5px;">
                                    <div class="col-md-6" style="padding-left:0">
                                        <label class="pl-4" style="color:#747474">rfq No :
                                        <span style="color:#e70a0a;font-size: 11px;font-weight: bold;">
                                            <?= isset($id) ? $rfqRow->RFQ_code : '( Auto generated )' ?>
                                        </span>
                                    </label>
                                    </div>

                                    <div class="col-md-6" style="padding-left:0"><label class="pl-4" style="color:#747474">Acceptance : <span
                                            class="<?php //echo $bgcolor
                                            ?>"
                                            style="font-weight:bold; padding: 8px; border-radius: 5px;padding-top: 1px;padding-bottom: 4px; color:<?= isset($id) ? ($rfqRow->Acceptance == 'Accepted' ? "green" : 'red') : '#6c757d' ?> ;" ><?= isset($id) ? ($rfqRow->Acceptance == '' ? 'Pending' : $rfqRow->Acceptance) : 'Pending' ?></span></label>
                                        </div>
                                </div>
                                <form id="rfq-form" action="" method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <input hidden name="Acceptance"
                                                value="<?= isset($rfqRow) ? ($rfqRow->Acceptance == '' || $rfqRow->Acceptance == null ? 'Pending' : $rfqRow->Acceptance) : 'Pending' ?>" />
                                            <?php
                                             if (isset($id))
                                             {
                                                ?>
                                            <input hidden name="id" value="<?= $id ?>" />
                                            <input hidden name="RFQ_code" value="<?= $rfqRow->RFQ_code ?>" />
                                            <?php
                                             }
                                                ?>
                                            <!-- <input hidden name="RFXNo" value="{{ $RFXNo }}" /> -->
                                            <!-- <input hidden name="assigned_eng_uid" value="{{ $assigned_eng_uid }}" /> -->
                                            <div style="margin-bottom:20px">
                                            <button <?= ($isdisabled == '1' || $isdisabled == 1) ? "disabled" : ""; ?> style="border-radius:4px; border-color:#1C90FF; background-color:#1C90FF" class="btn btn-primary bg-gradient-primary btn-sm" type="button"
                                                id="new_items_templete"><i class="fa fa-plus"></i> New Items
                                                Templete</button>
                                            <input type="file" id="fileElem" multiple accept=".csv"
                                                style="display:none">
                                            <button <?= ($isdisabled == '1' || $isdisabled == 1) ? "disabled" : ""; ?> style="border-radius:4px; border-color:#1C90FF; background-color:white; color:#1C90FF" id="fileSelect" type="button"
                                                class="btn btn-primary bg-gradient-primary btn-sm"><i
                                                    class="fa fa-upload"></i> CSV</button>
                                            <?php
                                                        if(isset($id))
                                                        {
                                                    ?>

                                            <!-- <a style="border-radius:4pxborder-color:#1C90FF; background-color:white;margin-right:10px; color:#1C90FF" href="<?php /* echo $viewTheEmailPath; */ ?>" target="_blank"
                                            class="btn pull-right btn-primary bg-gradient-primary btn-sm"><i style="margin-right:10px" class="fa fa-envelope"></i>Preview Email</a> -->


                                            <a onclick="window.open('<?= $viewTheEmailPath; ?>',null,'toolbar=no,menubar=no,location=no,titlebar=no,width=1400,height=1000');" 
                                            style="border-radius:4pxborder-color:#1C90FF; background-color:white;margin-right:10px; color:#1C90FF" class="btn pull-right btn-primary bg-gradient-primary btn-sm"><i style="margin-right:10px" class="fa fa-envelope"></i>Preview Email</a>

                                            <?php
                                                    }
                                                    
                                                    ?>
                                                    </div>  
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <div style="form-group form-inline">

                                                        <label for="EmailSubject"><?php echo _l('email_subject'); ?></label>
                                                        <input <?= ($isdisabled == '1' || $isdisabled == 1) ? "disabled" : ""; ?> type="text" name="EmailSubject" name="EmailSubject"
                                                            value="<?= isset($rfqRow->EmailSubject) ? $rfqRow->EmailSubject : '' ?>"
                                                            placeholder="Email Subject"
                                                            class="form-control col-lg-3 m-2">

                                                    </div>
                                                </div>
                                                <?php
                                                $rel_type = '';
                                                $rel_id = '';
                                                if (isset($rfqRow) || ($this->input->get('rel_id') && $this->input->get('rel_type'))) {
                                                    $rel_id = isset($rfqRow) ? $rfqRow->rel_id : $this->input->get('rel_id');
                                                    $rel_type = isset($rfqRow) ? $rfqRow->rel_type : $this->input->get('rel_type');
                                                }
                                                ?>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label for="rel_type"
                                                            class="control-label"><?php echo _l('task_related_to'); ?></label>
                                                        <select name="rel_type" <?= ($isdisabled == '1' || $isdisabled == 1) ? "disabled" : ""; ?> class="selectpicker" id="rel_type"
                                                            data-width="100%"
                                                            data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                                            <option value=""></option>
                                                            <option value="project" <?php if (isset($rfqRow) || $this->input->get('rel_type')) {
                                                                if ($rel_type == 'project') {
                                                                    echo 'selected';
                                                                }
                                                            } ?>>
                                                                <?php echo _l('project'); ?></option>
                                                            <option value="invoice" <?php if (isset($rfqRow) || $this->input->get('rel_type')) {
                                                                if ($rel_type == 'invoice') {
                                                                    echo 'selected';
                                                                }
                                                            } ?>>
                                                                <?php echo _l('invoice'); ?>
                                                            </option>
                                                            <option value="customer" <?php if (isset($rfqRow) || $this->input->get('rel_type')) {
                                                                if ($rel_type == 'customer') {
                                                                    echo 'selected';
                                                                }
                                                            } ?>>
                                                                <?php echo _l('client'); ?>
                                                            </option>
                                                            <option value="estimate" <?php if (isset($rfqRow) || $this->input->get('rel_type')) {
                                                                if ($rel_type == 'estimate') {
                                                                    echo 'selected';
                                                                }
                                                            } ?>>
                                                                <?php echo _l('estimate'); ?>
                                                            </option>
                                                            <option value="contract" <?php if (isset($rfqRow) || $this->input->get('rel_type')) {
                                                                if ($rel_type == 'contract') {
                                                                    echo 'selected';
                                                                }
                                                            } ?>>
                                                                <?php echo _l('contract'); ?>
                                                            </option>
                                                            <option value="ticket" <?php if (isset($rfqRow) || $this->input->get('rel_type')) {
                                                                if ($rel_type == 'ticket') {
                                                                    echo 'selected';
                                                                }
                                                            } ?>>
                                                                <?php echo _l('ticket'); ?>
                                                            </option>
                                                            <option value="expense" <?php if (isset($rfqRow) || $this->input->get('rel_type')) {
                                                                if ($rel_type == 'expense') {
                                                                    echo 'selected';
                                                                }
                                                            } ?>>
                                                                <?php echo _l('expense'); ?>
                                                            </option>
                                                            <option value="lead" <?php if (isset($rfqRow) || $this->input->get('rel_type')) {
                                                                if ($rel_type == 'lead') {
                                                                    echo 'selected';
                                                                }
                                                            } ?>>
                                                                <?php echo _l('lead'); ?>
                                                            </option>
                                                            <option value="proposal" <?php if (isset($rfqRow) || $this->input->get('rel_type')) {
                                                                if ($rel_type == 'proposal') {
                                                                    echo 'selected';
                                                                }
                                                            } ?>>
                                                                <?php echo _l('proposal'); ?>
                                                            </option>
                                                            <?php
                                                            hooks()->do_action('task_modal_rel_type_select', ['task' => isset($rfqRow) ? $rfqRow : 0, 'rel_type' => $rel_type]);
                                                            //echo "<option value='opportunity' ".((isset($rfqRow) && isset($rel_type) && $rel_type == 'opportunity') ? "selected" : "").">"._l('Opportunity') . "</option>";
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group<?php if ($rel_id == ''/*  || $isdisabled == '1' || $isdisabled == 1 */) {
                                                        echo ' hide';
                                                    } ?>" id="rel_id_wrapper">
                                                        <label for="rel_id" class="control-label"><span
                                                                class="rel_id_label"></span></label>
                                                        <div id="rel_id_select">

                                                            <select name="rel_id" <?= ($isdisabled == '1' || $isdisabled == 1) ? "disabled" : ""; ?> id="rel_id"
                                                                class="ajax-sesarch" data-width="100%"
                                                                data-live-search="true"
                                                                data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                                                <?php if ($rel_id != '' && $rel_type != '') {

if($rel_type != "opportunity"){
                                                                    $rel_data = get_relation_data($rel_type, $rel_id);
                                                                    $rel_val = get_relation_values($rel_data, $rel_type);
                                                                    echo '<option value="' . $rel_val['id'] . '" selected>' . $rel_val['name'] . '</option>';
}else{
foreach($opportunitiess as $opportunityy)
if( $opportunityy["opportunity_id"] == $rfqRow->rel_id ){
echo '<option value="' . $opportunityy["id"] . '" selected>' . "#".$opportunityy["opportunity_id"]." - ".$opportunityy["opportunity_code"]." - ".$opportunityy["opportunity_name"]." - ".$opportunityy["partner_code"] . '</option>';
break;
}
                                                                    }
                                                                } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                <?php //echo "<h2>".(get_option('new_task_auto_assign_current_member') == '1' ? "OK" : "not OK")."</h2>"; ?>
                                                    <div class="form-group select-placeholder>">
                                                        <label for="assigned_eng_staff_id"><?php echo _l('assigned_eng'); ?></label>
                                                        <select name="assigned_eng_staff_id"
                                                        <?= ($isdisabled == '1' || $isdisabled == 1) ? "disabled" : ""; ?>
                                                            id="assigned_eng_staff_id" class="selectpicker"
                                                            data-width="100%"
                                                            data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>"
                                                            data-live-search="true">
                                                            <?php foreach ($members as $member) { ?>
                                                            <option value="<?php echo $member['staffid']; ?>" 
                                                            <?php 

//get_staff_user_id() : this function brings the logged in USER' (id) from "tblstaff" table in DB

                                                            if(/*get_option('new_task_auto_assign_current_member') == '1' &&  get_staff_user_id() */ (isset($rfqRow->assigned_eng_staff_id) ? $rfqRow->assigned_eng_staff_id : get_staff_user_id()) == $member['staffid']) {
                                                                echo 'selected';
                                                            } 
                                                            ?> 
                                                            >
                                                                <?php echo $member['firstname'] . ' ' . $member['lastname']; ?>
                                                            </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <script>
                                                var TemplateIndex = 1;
                                                const fileSelect = document.getElementById("fileSelect");
                                                const fileElem = document.getElementById("fileElem");
                                                fileElem.addEventListener("change", (e) => {
                                                    const fileList = e.target.files;
                                                    const file = fileList[0];
                                                    var FR = new FileReader();
                                                    FR.readAsText(file);
                                                    FR.onload = function(data) {
                                                        var csv = $.csv.toArrays(data.target.result);
                                                        RowsCount = csv.length;
                                                        ColumnsCount = csv[0].length;
                                                        var table = $('<table class="table table-bordered table-hover table-striped" id="tblItems_' +
                                                            TemplateIndex +
                                                            '"> <caption  style="caption-side:top;text-align:left"><h4><b>Template - (' +
                                                            TemplateIndex + ')</b></h4></caption></table>').addClass('table');

                                                        var dvItems = $('<div id="dvTemplate_' + TemplateIndex + '"></div>');
                                                        var row = $('<tr style="border-top:none; "></tr>');
                                                        var cell = $('<th ></th>')
                                                        row.append(cell);
                                                        for (j = 1; j <= ColumnsCount; j++) {
                                                            var cell = $('<th></th>').addClass(TemplateIndex + '_Columns');
                                                            var input = $('<div style="display:flex; justify-content:space-between"><input placeholder="Enter Column Name" style="border:none; background:gainsboro;" required value="' + csv[0][j - 1] +
                                                                '" width="100%" name="Tampletes[' + TemplateIndex + '][Columns][' + (j) +
                                                                ']" /><a width="20%" id="deleteColumn' +
                                                                ' href="javascript:void(0)" onclick="DeleteColumn(this,' + TemplateIndex +
                                                                ')"  class="btn btn-warning"><i class="fa fa-times"></i></a></div>');
                                                            cell.append(input);


                                                            row.append(cell);
                                                        }
                                                        table.append(row);

                                                        for (i = 1; i < RowsCount; i++) {
                                                            var row = $('<tr ></tr>');
                                                            for (j = 0; j <= ColumnsCount; j++) {

                                                                var cell = $('<td></td>').addClass('bar');
                                                                if (j == 0) {
                                                                    var deleteItem =
                                                                    '<button style="border:none; border-radius:2px; background:gainsboro; " type=button onclick="DeleteRow(this)"   id="deleteItem" > - </i></button>';
                                                                    cell.append(deleteItem);

                                                                } else {
                                                                    var input = $('<input required value="' + csv[i][j - 1] + '" name="Tampletes[' +
                                                                        TemplateIndex + '][Rows][Row_' + (j) + '][' + (i + 2) +
                                                                        ']" style="width: 100%;" />');
                                                                    cell.append(input);
                                                                }
                                                                row.append(cell);

                                                            }

                                                            table.append(row);
                                                        }
                                                        dvItems.append(table);
                                                        dvItems.append('<button class="btn btn-primary bg-gradient-primary btn-sm" style="background-color:white; border-radius:0; color:blue" onclick="AddRow(' +
                                                            TemplateIndex +
                                                            ')"  type="button" id="new_items_templete" <?= ($isdisabled == '1' || $isdisabled == 1) ? 'disabled' : ''; ?> ><i class="fa fa-plus"></i> New Row</button>')
                                                        dvItems.append(
                                                            '<button class="btn btn-success m-3   btn-sm" type="button" style="background-color:white; border-radius:0; color:green" onclick="AddColumn(' +
                                                            TemplateIndex +
                                                            ')" id="new_items_templete" <?= ($isdisabled == '1' || $isdisabled == 1) ? 'disabled' : ''; ?> ><i class="fa fa-plus"></i> New Column</button>')
                                                        dvItems.append(
                                                            '<button <?= ($isdisabled == '1' || $isdisabled == 1) ? 'disabled' : ''; ?> style="position:absolute; right:0" class="btn btn-danger   btn-sm" type="button" onclick="RemoveTemplate(' +
                                                            TemplateIndex + ')"><i class="fa fa-trash-o"></i>Delete Template</button>')
                                                        $('#dvItems').append(dvItems);


                                                        TemplateIndex++;
                                                        $("#fileElem").val('');
                                                    }
                                                });
                                                fileSelect.addEventListener("click", (e) => {
                                                    if (fileElem) {
                                                        fileElem.click();

                                                        //
                                                    }
                                                }, false);
                                            </script>
                                            <div class="row">
                                                <hr>
                                                <div id="dvItems" class="col-lg-12 table-responsive">
                                                    <h2 style="margin-top:0;margin-bottom:0; font-weight:bold; color:#1C90FF">Templates</h2>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">












                                                <div class="col-lg-12"
                                                    style="background: #e9f0f7;padding: 20px;border-radius: 5px;">
                                                    <div class="form-group" id="thenotesarea">
                                                        <h4
                                                            style="text-align: center;padding: 5px;background: #6586a9;color: white;border-radius: 6px;width: 100%;">
                                                            Notes <span style="font-size: 15px; color:#ffc800">(
                                                                Appears at the Email Body - Head
                                                                )</span></h4>
                                                        <?php
                                                        // onclick and onfocus used for convert ticket to task too
                                                        // echo render_textarea('note', '', isset($id) ? $rfqRow->note : '', ['rows' => 6, 'placeholder' => _l('rfq_add_note'), 'data-rfq-ae-editor' => true, !is_mobile() ? 'onclick' : 'onfocus' => !isset($id) || (isset($id) && $rfqRow->note == '') ? 'init_editor(\'.tinymce-task\', {height:200, auto_focus: true});' : ''], [], 'no-mbot', 'tinymce-task');
                                                        //, 'disabled' => (($isdisabled == '1' || $isdisabled == 1) ? "true" : "")
                                                        
                                                        
                                                        echo render_textarea('note', '', isset($id) ? $rfqRow->note : '', ['rows' => 6, 'placeholder' => _l('rfq_add_note'), 'data-rfq-ae-editor' => true, !is_mobile() ? 'onclick' : 'onfocus' => 'init_editor(\'.tinymce-task\', {height:200, auto_focus: true});'], [], 'no-mbot', 'tinymce-task');
                                                        
                                                        






/* 
 
$txtAreaRemarksaCont = "<div class='row' style='display: inline-flex; width:100%'>
<div class='row' style='display: inline-flex; width:150px'>
<div style='text-align:right; margin-right:10px;width:50%;margin-bottom:1px;margin-top:1px'>
<span><h5 style='margin-bottom:3px;margin-top:3px'>Inquiry No: </h5></span>
<span><h5 style='margin-bottom:3px;margin-top:3px' >Date: </h5></span>
<span><h6 style='margin-bottom:3px;margin-top:3px'>Request No: </h6></span>
</div>
<div style='text-align:left; margin-left:110px;width:150%;height:30px;margin-bottom:1px;margin-top:-70px'>
<span><h5 style='margin-bottom:3px;margin-top:3px'>" .$rfqRow->RFQ_code  . "</h5></span>
<span><h5 style='margin-bottom:3px;margin-top:3px'>" . date('M d, y') . "</h5></span>
////<span><h6 style='margin-bottom:3px;margin-top:3px'>" . date('y') . str_pad(     $RFQId     , 6, '0', STR_PAD_LEFT) . "-" . str_pad(  $TemplateIndex   , 2, '0', STR_PAD_LEFT) . "</h6></span>  
<span><h6 style='margin-bottom:3px;margin-top:3px'>" . date('y') . str_pad( '' , 6, '0', STR_PAD_LEFT) . "-" . str_pad(  '', 2, '0', STR_PAD_LEFT) . "</h6></span>  

</div>
</div>
<div class='row' style='float:right;display: inline-flex; width:300px'>
<div style='text-align:right; margin-right:10px;width:150px;margin-bottom:1px;margin-top:1px'>
<span><h5 style='margin-bottom:3px;margin-top:3px'>Requested By: </h5></span>
</div>
<div style='text-align:left; margin-left:160px;width:150px;height:30px;margin-bottom:1px;margin-top:-50px'>
////<span><h5 style='margin-bottom:3px;margin-top:3px'>" .  $staff_member->firstname  . " " .  $staff_member->lastname  . "</h5></span>
<span><h5 style='margin-bottom:3px;margin-top:3px'>" . '' . " " . '' . "</h5></span>
<span><h5 style='margin-bottom:3px;margin-top:3px'></h5></span>
</div>
</div>
</div>
</div>";


echo render_textarea('note', '', isset($id) ? $txtAreaRemarksaCont : '', ['rows' => 6, 'placeholder' => _l('rfq_add_note'), 'data-rfq-ae-editor' => true, !is_mobile() ? 'onclick' : 'onfocus' => !isset($id) || (isset($id) && $rfqRow->note == '') ? 'init_editor(\'.tinymce-task\', {height:200, auto_focus: true});' : ''], [], 'no-mbot', 'tinymce-task');
 */                                                       
                                                        
                                                   
                                                        
                                                        ?>
                                                        <!-- <textarea name="note" id="note" cols="30" rows="10" class="summernote form-control">
                                        
                                                        </textarea> -->
                                                    </div>
                                                </div>

                                                <hr>










                                                <div class="col-lg-12 table-responsive" id="thesupplsarea"
                                                    style="background: #f9f9f9;padding: 20px;border-radius: 5px; margin-top: 30px;">



<div class="form-group autocomplete" style="width:100%;">

<input id="searchWord" type="text" size="30" class="form-control"
placeholder="Suppliers' General Search"
size="30" 
onkeyup="showResult(this.value,'suppliers','searchWord')" />

</div>




    <!-- <div class="">
    <table id="tblSuppliersSearchResults" class="table table-striped" ></table>
    </div> -->




<h4 style="text-align: center;padding: 5px;background: #6586a9;color: white;border-radius: 6px;width: 100%;">
Suppliers List - TO
</h4>

<table class="table table-striped">
<thead>
                                                            <tr class="bg-navy disabled">
                                                                <td><!-- Custom Search --></td>
                                                                <td>
<div class="form-group autocomplete" style="width:100%;">

<input id="searchWordfl" type="text" size="30" class="form-control"
placeholder="first\lastname"
size="30" 
onkeyup="showResult(this.value,'suppliers','searchWordfl')" style="    width: 100%;" />

</div>
                                                                </td>
                                                                <td>
<div class="form-group autocomplete" style="width:100%;">

<input id="searchWordem" type="text" size="30" class="form-control"
placeholder="E-mail"
size="30" 
onkeyup="showResult(this.value,'suppliers','searchWordem')" style="    width: 100%;" />

</div>
                                                                </td>
                                                                <td>
<div class="form-group autocomplete" style="width:100%;">

<input id="searchWordky" type="text" size="30" class="form-control"
placeholder="Keyword\s"
size="30" 
onkeyup="showResult(this.value,'suppliers','searchWordky')" style="    width: 100%;" />

</div>
                                                                </td>
                                                            </tr>
                                                        </thead>
                                                        <colgroup>
                                                            <col width="10%">
                                                            <col width="25%">
                                                            <col width="25%">
                                                            <col width="40%">
                                                        </colgroup>
</table>



<table id="tblSuppliers" class="table table-striped">

                                                        
                                                        <thead>
                                                            <tr class="bg-navy disabled">
                                                                <th></th>
                                                                <th>Supplier</th>
                                                                <th>Email</th>
                                                                <th>keywords</th>
                                                            </tr>
                                                        </thead>

                                                        <colgroup>
                                                            <col width="10%">
                                                            <col width="25%">
                                                            <col width="25%">
                                                            <col width="40%">
                                                        </colgroup>
                                                        <tbody>





                                                            <?php
                                                                foreach ($suppliers as $Supplier)
                                                                {
                                                                    if(isset($Supplier['selected']) )
                                                                    if($Supplier['selected'] != '' ){
                                                            ?>
                                                            <tr id="roww<?= $Supplier['id'] ?>">
                                                                <td>
                                                                    <input
                                                                        <?= isset($id) ? $Supplier['selected'] : '' ?>
                                                                        type="checkbox" value="<?= $Supplier['id'] ?>"
                                                                        name="SupplierList[]" 
                                                                        onchange ="removeifexist('<?= $Supplier['id'] ?>','suppliers')"
                                                                        />
                                                                </td>
                                                                <td>
                                                                    <?= $Supplier['company'] ?><br>
                                                                    <?= $Supplier['title'] . ' ' . $Supplier['firstname'] . ' ' . $Supplier['lastname'] ?>
                                                                </td>
                                                                <td>
                                                                    <?= $Supplier['email'] ?>
                                                                </td>
                                                                <td>
                                                                    <span class="addReadMore showlesscontent">
                                                                        <?= $Supplier['keywords'] ?>
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                            if (isset($id)) {
                                                                $SupplierContacts=$this->suppliers_model->get_selected_rfq_supplier_contacts($Supplier['id'],$id);
                                                            }
                                                            else
                                                            {
                                                             $SupplierContacts=$this->suppliers_model->get_selected_rfq_supplier_contacts($Supplier['id']);
                                                            }
                                                            foreach ($SupplierContacts as $Contact)
                                                            {
                                                        ?>
                                                            <tr>
                                                                <td>
                                                                    <input <?= isset($id) ? $Contact['selected'] : '' ?>
                                                                        type="checkbox" value="<?= $Contact['id'] ?>"
                                                                        name="SupplierContactList[]" />
                                                                </td>
                                                                <td>
                                                                    <?= $Contact['company'] ?><br />
                                                                    <?= $Contact['title'] . ' ' . $Contact['firstname'] . ' ' . $Contact['lastname'] ?>
                                                                </td>
                                                                <td>
                                                                    <?= $Contact->email ?>
                                                                </td>
                                                                <td>
                                                                    <span class="addReadMore showlesscontent"><?= $Supplier->keywords ?><span>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                    }
                                                  }
                                                }
                                                ?>







                                                        <tbody>
                                                    </table>








<table class="table table-striped">
                                                <tr id="suppAdder">
                                                                <td class="text-center">
                                                                <abbr title="Add Quick Supplier"><button type="button" class="btn btn-primary"
                                                                        id="AddSupplier"><i
                                                                            class="fa fa-plus"></i></button></abbr>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group">
                                                                        <input class="form-control"
                                                                            placeholder="Supplier' First Name"
                                                                            id="SupplierName" />
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group">
                                                                        <input class="form-control"
                                                                            placeholder="Last Name"
                                                                            id="SupplierLName" />
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group">
                                                                        <input class="form-control"
                                                                            placeholder="Company Name"
                                                                            id="SupplierCompanyName" />
                                                                    </div>
                                                                </td>
<!--                                                                 <td>
                                                                    <div class="form-group">
                                                                        <input class="form-control"
                                                                            placeholder="Contact Person"
                                                                            id="SupplierContactPerson" />
                                                                    </div>
                                                                </td> 
 -->
                                                                <td>
                                                                    <div class="form-group">
                                                                        <input class="form-control"
                                                                            placeholder="Email" 
                                                                            id="SupplierEmail" />
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group">
                                                                        <input class="form-control"
                                                                            placeholder="Phone"
                                                                            id="SupplierPhone" />
                                                                    </div>
                                                                </td>
                                                                keywords
                                                                <td>
                                                                    <div class="form-group">
                                                                        <input class="form-control"
                                                                            placeholder="Mobile"
                                                                            id="SupplierMobile" />
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group">
                                                                        <textarea class="form-control"
                                                                            placeholder="Keywords - Comma seperated"
                                                                            id="SupplierKeywords" style="width: 240px;height: 35px;"></textarea>
                                                                    </div>
                                                                </td>

                                                                <td style="visibility:hidden;overflow:hidden"></td>
                                                            </tr>
</table>
</div>

<hr>

                                                <div class="col-lg-12" style="margin-top:60px" id="thestuffarea">

                                                    <div class="row mt=3">
                                                        <div class="col-lg-12"
                                                            style="background: #f9f9f9;padding: 20px;border-radius: 5px;">




<div class="form-group" style="margin-bottom: 5px;">
<input type="text" size="30" class="form-control"
placeholder="Stuff Search" 
size="30" 
onkeyup="showResult(this.value,'stuff')" />
</div>


<table id="tblEmailCCUsersSearchResults" class="table table-striped" style="margin-top: 0px;"></table>




                                                            <h4
                                                                style="text-align: center;padding: 5px;background: #6586a9;color: white;border-radius: 6px;width: 100%;">
                                                                Prizm Employees List - CC</h4>
                                                            <table id="tblEmailCCUsers"
                                                                class="table table-hover table-striped">
                                                                <thead>
                                                                    <tr class="bg-navy disabled">
                                                                        <th></th>
                                                                        <th>Name</th>
                                                                        <th>Email</th>
                                                                    </tr>
                                                                </thead>
                                                                <colgroup>
                                                                    <col width="10%">
                                                                    <col width="45%">
                                                                    <col width="45%">
                                                                </colgroup>
                                                                <tbody>


                                                                <?php 
                                                            foreach ($staff as $member)
                                                            { 
                                                                if(isset($member['selected']) )
                                                                if($member['selected'] != '' ){
                                                            ?>
                                                                    <tr id="rowww<?= $member['staffid'] ?>">
                                                                        <td><input
                                                                                <?= isset($id) ? $member['selected'] : '' ?>
                                                                                value="<?= $member['staffid'] ?>"
                                                                                type="checkbox"
                                                                                name="EmailCCUsersList[<?= $member['staffid'] ?>]"
                                                                                onchange ="removeifexist('<?= $member['staffid'] ?>','stuff')"
                                                                                />
                                                                        <td><?= $member['firstname'] . ' ' . $member['lastname'] ?>
                                                                        </td>
                                                                        <td><?= $member['email'] ?></td>
                                                                    </tr>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>

                                            </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">

                                            

<hr>
<!-- ///////////////////////////////////Notes was here///////////////////////////////////-->



                                                <div class="col-lg-12"
                                                    style="background: #e9f0f7;padding: 20px;border-radius: 5px;    margin-top: 30px;">
                                                    <div class="form-group" id="theremarksarea">
                                                        <h4
                                                            style="text-align: center;padding: 5px;background: #6586a9;color: white;border-radius: 6px;width: 100%;">
                                                            Remarks <span style="font-size: 15px; color:#ffc800">(
                                                                Appears at the Email Body - foot
                                                                )</span></h4>
                                                        <?php
                                                        // onclick and onfocus used for convert ticket to task too
                                                        //echo render_textarea('Remarks', '', isset($id) ? $rfqRow->Remarks : '', ['rows' => 6, 'placeholder' => _l('rfq_add_description'), 'data-rfq-ae-editor' => true, !is_mobile() ? 'onclick' : 'onfocus' => !isset($id) || (isset($id) && $rfqRow->Remarks == '') ? 'init_editor(\'.tinymce-task\', {height:200, auto_focus: true});' : ''], [], 'no-mbot', 'tinymce-task');
                                                        echo render_textarea('Remarks', '', isset($id) ? $rfqRow->Remarks : '', ['rows' => 6, 'placeholder' => _l('rfq_add_description'), 'data-rfq-ae-editor' => true, !is_mobile() ? 'onclick' : 'onfocus' => 'init_editor(\'.tinymce-task\', {height:200, auto_focus: true});'], [], 'no-mbot', 'tinymce-task');
                                                        ?>

                                                        <!-- <textarea name="Remarks" id="Remarks" cols="30" rows="10" class="summernote form-control">    
                                                        </textarea> -->
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    <?php if (1 == 1)
                                    {
                                    ?>
                                    <div class="row pt-5" style="width: 100% !important; text-align:center">
                                        <!-- <div class="col-lg-12 btn-group" style="text-align:center" id="theactionsbuttonsarea"> -->
                                        <div class="col-lg-12 btn-group" style="text-align:center" >
<?php if(isset($id) && $toshowaccrej=='1' && $afteradd!='1')
                                            {




if($rfqRow->Acceptance == "Rejected"){    ?>
                                            <input type="button" id="Accept" value="Accept"
                                                class="btn btn-success m-2" style="font-size: 20px !important;" />
<?php } 
else if($rfqRow->Acceptance == "Accepted"){
?>
<!--                                             <input type="button" id="Reject" value="Reject"
                                                class="btn btn-danger m-2" style="font-size: 20px !important;" /> -->
<?php }else{ ?>
                                            <!-- <input style="font-size: 20px !important;" class="btn btn-primary m-2"
                                                type="submit" value="Save" /> -->
                                                <input type="button" id="Accept" value="Accept"
                                                class="btn btn-success m-2" style="font-size: 20px !important;" />

                                            <input type="button" id="Reject" value="Reject"
                                                class="btn btn-danger m-2" style="font-size: 20px !important;" />

<?php } 




                                            }
                                                else if(isset($rfqRow->Acceptance))
                                                {
                                                    if($rfqRow->Acceptance != "Accepted"){
                                                    ?>
                                            <input style="font-size: 20px !important;" class="btn btn-primary m-2"
                                                type="submit" value="Save" />
                                            <?php
                                                      }else; 

                                    }else{
                                        ?>
                                <input style="font-size: 20px !important;" class="btn btn-primary m-2"
                                    type="submit" value="Save" />
                                <?php
                         }
                                                                                       
                                    
                                    
                                    
                                    
                                    }
                                                                                            ?>
                                        </div>
                                    </div>

                            </div>
<input type="hidden" name="toshowaccrej" value="<?php echo (isset($id) && $toshowaccrej=='1') ? 0 : 1 ?>"/>

                            </form>














                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div id="dialog" title="New Item Templete">
                <form action="" id="item-form">
                    <input type="hidden" name="id">
                    <div class="container-fluid">
                        <div class="form-group">
                            <label for="Rows" class="control-label">Rows</label>
                            <input type="number" value="1" min="2" id="Rows"
                                class="form-control rounded-0" required>
                        </div>
                        <div class="form-group">
                            <label for="Columns" class="control-label">Columns</label>
                            <input type="number" value="2" min="2" id="Columns"
                                class="form-control rounded-0" required>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php init_tail(); ?>
<?php if($isdisabled == '1' || $isdisabled == 1){ ?>
    <script>
    $("#thenotesarea *").attr("disabled", "disabled").off('click');
    $("#thesupplsarea *").attr("disabled", "disabled").off('click');
    $("#dvItems *").attr("disabled", "disabled").off('click');
    $("#thestuffarea *").attr("disabled", "disabled").off('click');
    $("#theremarksarea *").attr("disabled", "disabled").off('click');
    $("#theactionsbuttonsarea *").attr("disabled", "disabled").off('click');
    </script>
<?php } ?>
    <script>
        var _rel_id = $('#rel_id'),
            _rel_type = $('#rel_type'),
            _rel_id_wrapper = $('#rel_id_wrapper'),
            _current_member = undefined,
            data = {};



            
        $(function() {
            AddReadMore();
            $("body").off("change", "#rel_id");

            var inner_popover_template =
                '<div class="popover"><div class="arrow"></div><div class="popover-inner"><h3 class="popover-title"></h3><div class="popover-content"></div></div></div>';

            $('#_task_modal .task-menu-options .trigger').popover({
                html: true,
                placement: "bottom",
                trigger: 'click',
                title: "<?php echo _l('actions'); ?>",
                content: function() {
                    return $('body').find('#_task_modal .task-menu-options .content-menu').html();
                },
                template: inner_popover_template
            });

            custom_fields_hyperlink();

            appValidateForm($('#task-form'), {
                name: 'required',
                startdate: 'required',
                repeat_every_custom: {
                    min: 1
                },
            }, task_form_handler);

            $('.rel_id_label').html(_rel_type.find('option:selected').text());

            _rel_type.on('change', function() {

                var clonedSelect = _rel_id.html('').clone();
                _rel_id.selectpicker('destroy').remove();
                _rel_id = clonedSelect;
                $('#rel_id_select').append(clonedSelect);
                $('.rel_id_label').html(_rel_type.find('option:selected').text());

                task_rel_select();
                if ($(this).val() != '') {
                    _rel_id_wrapper.removeClass('hide');
                } else {
                    _rel_id_wrapper.addClass('hide');
                }
                init_project_details(_rel_type.val());
            });

            init_datepicker();
            init_color_pickers();
            init_selectpicker();
            task_rel_select();

            var _allAssigneeSelect = $("#assignees").html();

            $('body').on('change', '#rel_id', function() {
                if ($(this).val() != '') {
                    if (_rel_type.val() == 'project') {
                        $.get(admin_url + 'projects/get_rel_project_data/' + $(this).val() + '/' + taskid,
                            function(project) {
                                $("select[name='milestone']").html(project.milestones);
                                if (typeof(_milestone_selected_data) != 'undefined') {
                                    $("select[name='milestone']").val(_milestone_selected_data.id);
                                    $('input[name="duedate"]').val(_milestone_selected_data.due_date)
                                }
                                $("select[name='milestone']").selectpicker('refresh');

                                $("#assignees").html(project.assignees);
                                if (typeof(_current_member) != 'undefined') {
                                    $("#assignees").val(_current_member);
                                }
                                $("#assignees").selectpicker('refresh')
                                if (project.billing_type == 3) {
                                    $('.task-hours').addClass('project-task-hours');
                                } else {
                                    $('.task-hours').removeClass('project-task-hours');
                                }

                                if (project.deadline) {
                                    var $duedate = $('#_task_modal #duedate');
                                    var currentSelectedTaskDate = $duedate.val();
                                    $duedate.attr('data-date-end-date', project.deadline);
                                    $duedate.datetimepicker('destroy');
                                    init_datepicker($duedate);

                                    if (currentSelectedTaskDate) {
                                        var dateTask = new Date(unformat_date(currentSelectedTaskDate));
                                        var projectDeadline = new Date(project.deadline);
                                        if (dateTask > projectDeadline) {
                                            $duedate.val(project.deadline_formatted);
                                        }
                                    }
                                } else {
                                    reset_task_duedate_input();
                                }
                                init_project_details(_rel_type.val(), project.allow_to_view_tasks);
                            }, 'json');



                    } else {
                        reset_task_duedate_input();
                    }
                }
            });

            <?php if (!isset($task) && $rel_id != '') { ?>
            _rel_id.change();
            <?php } ?>


        });











        

        function task_rel_select() {
            var serverData = {};
            serverData.rel_id = _rel_id.val();
            data.type = _rel_type.val();
            init_ajax_search(_rel_type.val(), _rel_id, serverData);
        }

        function init_project_details(type, tasks_visible_to_customer) {
            var wrap = $('.non-project-details');
            var wrap_task_hours = $('.task-hours');
            if (type == 'project') {
                if (wrap_task_hours.hasClass('project-task-hours') == true) {
                    wrap_task_hours.removeClass('hide');
                } else {
                    wrap_task_hours.addClass('hide');
                }
                wrap.addClass('hide');
                $('.project-details').removeClass('hide');
            } else {
                wrap_task_hours.removeClass('hide');
                wrap.removeClass('hide');
                $('.project-details').addClass('hide');
                $('.task-visible-to-customer').addClass('hide').prop('checked', false);
            }
            if (typeof(tasks_visible_to_customer) != 'undefined') {
                if (tasks_visible_to_customer == 1) {
                    $('.task-visible-to-customer').removeClass('hide');
                    $('.task-visible-to-customer input').prop('checked', true);
                } else {
                    $('.task-visible-to-customer').addClass('hide')
                    $('.task-visible-to-customer input').prop('checked', false);
                }
            }
        }

        function reset_task_duedate_input() {
            var $duedate = $('#_task_modal #duedate');
            $duedate.removeAttr('data-date-end-date');
            $duedate.datetimepicker('destroy');
            init_datepicker($duedate);
        }

        function AddRow(Templateindex) {
            var colCount = $("#tblItems_" + Templateindex + " tr th").length;
            var rowCount = $("#tblItems_" + Templateindex + " tr").length;
            var row = $('<tr style="border-top:none;"></tr>');

            for (let i = 0; i < colCount - 1; i++) {
                if (i == 0) {
                    var deleteItem = $(
                        '<button style="border:none; border-radius:2px; background:gainsboro; " type=button onclick="DeleteRow(this)"   id="deleteItem" > - </i></button>'
                    );
                    row.append(deleteItem)
                }
                cell = $('<td><input name="Tampletes[' + Templateindex + '][Rows][Row_' + (i + 1) + '][' + (
                        rowCount + 1) +
                    ']" style="width: 100%;"/></td>')
                row.append(cell)
                $('#tblItems_' + Templateindex + '').append(row);
            }

        }

        function DeleteRow(e) {
            $(e).closest("tr").remove();
        }

        function AddColumn(Templateindex) {
            var colCount = $("#tblItems_" + Templateindex + " tr th").length;
            var rowCount = $("#tblItems_" + Templateindex + " tr").length;

            $('#tblItems_' + Templateindex + '').find('tr').each(function(i) {
                $(this).find('th').eq(colCount - 1).after(
                    '<th><div style="display:flex; justify-content:space-between ;border:none; background:gainsboro;"><input placeholder="Enter Column Name"  style="border:none; background:gainsboro;" name="Tampletes[' + Templateindex +
                    '][Columns][' + (colCount) +
                    ']" /><a width="20%" id="deleteColumn" href="javascript:void(0)" onclick="DeleteColumn(this,' +
                    Templateindex +
                    ')" class="btn btn-warning" style="border:none; background:gainsboro; "><i class="fa fa-times"></i></a></div></th>');
                $(this).find('td').eq(colCount - 1).after('<td><input name="Tampletes[' +
                    Templateindex +
                    '][Rows][Row_' + (colCount) + '][' + (i + 1) + ']" style="width: 100%;"/></td>');
            });
        }

        function DeleteColumn(e, Templateindex) {
            var index = $(e).closest('th').index();
            $("#tblItems_" + Templateindex + " tr").each(function() {
                $(this).find("th:eq(" + index + ")").remove();
                $(this).find("td:eq(" + index + ")").remove();
            });
        }

        function RemoveTemplate(Templateindex) {
            $('#dvItems').find('#dvTemplate_' + Templateindex + '').remove()
        }







        var i = 1
        var j = 1
        var id = -1

        function sendMail() {
            url = "rfq/rfq/send_inquery/<?= isset($id) ? $id : '' ?>";
            //  var taskModalVisible = $("#task-modal").is(":visible");

            $("body").append('<div class="dt-loader"></div>');
            requestGetJSON(url).done(function(response) {
                $("body").find(".dt-loader").remove();
                //console.log(response)
                if (response.success == true || response.success == "true") {
                    console.log("OKK");
                    alert("Message sent successfully");
                    //   reload_tasks_tables();
                    //   if (taskModalVisible) {
                    //     _task_append_html(response.taskHtml);
                    //   }
                    //   if (
                    //     status == 5 &&
                    //     typeof _maybe_remove_task_from_project_milestone == "function"
                    //   ) {
                    //     _maybe_remove_task_from_project_milestone(task_id);
                    //   }
                    //   if ($(".tasks-kanban").length === 0) {
                    //     alert_float("success", response.message);
                    //   }
                }
            });
            // var form_data = new FormData();
            // <?php
            // if (isset($id)) {
            //     echo 'id=' . $id;
            // }
            //
            ?>

            // form_data.append('id', id<?php //if(isset($id)) echo $id;
            //
            ?>);
            // $.ajax({
            //     url: "/api/rfq/send_inquery",
            //     headers: {
            //         "Authorization": "Bearer {{ Auth::user()->api_token }}"
            //     },
            //     data: form_data,
            //     cache: false,
            //     contentType: false,
            //     processData: false,
            //     method: 'POST',
            //     type: 'POST',
            //     dataType: 'json',
            //     error: err => {
            //         console.log(err)
            //         toastr.error("An error occured", 'error', 'top');
            //         // end_loader();
            //     },
            //     success: function(resp) {
            //         if (typeof resp == 'object' && resp.status == 'success') {
            //             window.location.href =
            //                 "{{ config('app.url') }}/rfq_listpage?id={{ $RFXId }}&RFXNo={{ $RFXNo }}&assigned_eng_uid={{ $assigned_eng_uid }}"

            //         } else if (resp.status == 'failed' && !!resp.msg) {
            //             var el = $('<div>')
            //             el.addClass("alert alert-danger err-msg").text(resp.msg)
            //             _this.prepend(el)
            //             el.show('slow')
            //             $("html, body").animate({
            //                 scrollTop: _this.closest('.card').offset().top
            //             }, "fast");
            //             end_loader()
            //         } else {
            //             toastr.error("An error occured", 'error', 'top');
            //             // end_loader();

            //         }
            //     }
            // })
        }
        <?php //}
        ?>

        function openPopup(url) {
            var popup = window.open(url, "popup", "fullscreen");
            if (popup.outerWidth < screen.availWidth || popup.outerHeight < screen.availHeight) {
                popup.moveTo(0, 0);
                popup.resizeTo(screen.availWidth, screen.availHeight);
            }
        }

        function createDetailsTable(itemNo) {
            //  NAME, CODE, DESCRIPTION, MANUFACTURER PART NUMBER
            return '<table id="tblAttributes_' + itemNo +
                '" class="table table-bordered table-hover table-striped">' +
                '<thead>' +
                '<tr  class="">' +
                '<th>#</th>' +
                '<th>Description</th>' +
                '<th>Value</th>' +
                '<th>Action</th>' +
                '</tr>' +
                '</thead>' +
                '<colgroup>' +
                '<col width="10%">' +
                '<col width="25%">' +
                '<col width="25%">' +
                '<col width="25%">' +
                '<col width="25%">' +
                '</colgroup> ' +
                '<tbody>' +
                '<tr>' +
                '<td class="text-center">' +
                '<button type="button" class="btn btn-success" id="AddAttribute_' + itemNo + '" >+</button>' +
                '</td>' +
                '<td>' +
                '<div class="form-group">' +
                '<input class="form-control" id="description_' + itemNo + '" />' +
                '</div>' +
                '</td>' +
                '<td>' +
                '<div class="form-group">' +
                '<input class="form-control" id="value_' + itemNo + '" />' +
                '</div>' +
                '</td>' +
                '<td align="center"></td>' +
                '</tr>' +
                '</tbody>' +
                '</table>';

        }

        function addAttribute(itemNo, descriptionText, valueText) {

            const description = $('#description_' + itemNo + '').val();
            if (description === '') {
                $('#description_' + itemNo + '').focus();
                $('#description_' + itemNo + '').css("background-color", "yellow");
                return
            }
            const value = $('#value_' + itemNo + '').val();
            // if (value==='')
            // {
            //     $('#value_'+itemNo+'').focus();
            //     $('#value_'+itemNo+'').css("background-color", "yellow");
            //     return
            // }
            $("#tblAttributes_" + itemNo + " tr").eq(-1).before($("<tr>").append(

                '<td></td>' +
                '<td>' +
                '<input value="' + descriptionText + '" name="detailList[' + itemNo + '][' +
                description + ']"/>' +
                '</td>' +

                '<td>' +
                '<input  value="' + valueText + '"  name="valueList[' + itemNo + '][' + value + ']"/>' +
                '</td>' +
                '<td>' +
                '<button id="deleteItem" type="button"  class="btn btn-warning" style="border:none; background:gainsboro; " ><i class="fa fa-times"></i></button>' +
                '</td>'

            ));
            $('#description_' + itemNo + '').val('')
            $('#value_' + itemNo + '').val('')

            $('#tblAttributes_' + itemNo + ' tr').each(function(i) {
                //  $(this).find('tr.attributeIndex').text(j++-1);
            });
        }

        function AddTemplate() {

            RowsCount = $("#Rows").val();
            ColumnsCount = $("#Columns").val();
            var table = $('<table class="table table-bordered table-hover table-striped" id="tblItems_' +
                TemplateIndex +
                '"> <caption  style="caption-side:top;text-align:left"><h4><b>Template - (' +
                TemplateIndex +
                ')</b></h4></caption></table>').addClass('table');

            var dvItems = $('<div id="dvTemplate_' + TemplateIndex + '"></div>');
            var row = $('<tr></tr>');
            var cell = $('<th style="width:1%"></th>')
            row.append(cell);
            for (j = 1; j <= ColumnsCount; j++) {
                var cell = $('<th></th>').addClass(TemplateIndex + '_Columns');
                var input = $('<div style="border:none; display:flex;; justify-content:space-between; background:gainsboro;" ><input placeholder="Enter Column Name"  style="border:none; background:gainsboro;" width="100%" name="Tampletes[' +
                    TemplateIndex +
                    '][Columns][' + (j) + ']" /><a width="20%" id="deleteColumn' +
                    ' href="javascript:void(0)" onclick="DeleteColumn(this,' + TemplateIndex +
                    ')" class="btn btn-warning" style="border:none; background:gainsboro; "><i class="fa fa-times"></i></a></div>');
                cell.append(input);


                row.append(cell);
            }
            table.append(row);

            for (i = 0; i < RowsCount; i++) {
                var row = $('<tr ></tr>');
                for (j = 0; j <= ColumnsCount; j++) {

                    var cell = $('<td></td>').addClass('bar');
                    if (j == 0) {
                        var deleteItem =
                        '<button style="border:none; border-radius:2px; background:gainsboro; " type=button onclick="DeleteRow(this)"   id="deleteItem" > - </i></button>';
                        cell.append(deleteItem);

                    } else {
                        var input = $('<input  name="Tampletes[' + TemplateIndex + '][Rows][Row_' + (j) + '][' +
                            (i + 2) +
                            ']" style="width: 100%;" />');
                        cell.append(input);
                    }
                    row.append(cell);

                }

                table.append(row);
            }
            dvItems.append(table);
            dvItems.append('<button class="btn btn-primary bg-gradient-primary btn-sm" style="background-color:white; border-radius:0; color:blue" onclick="AddRow(' +
                TemplateIndex +
                ')"  type="button" id="new_items_templete" <?= ($isdisabled == '1' || $isdisabled == 1) ? 'disabled' : ''; ?> ><i class="fa fa-plus"></i> New Row</button>')
            dvItems.append('<button class="btn btn-success m-3   btn-sm" type="button" style="background-color:white; border-radius:0; color:green" onclick="AddColumn(' +
                TemplateIndex + ')" id="new_items_templete" <?= ($isdisabled == '1' || $isdisabled == 1) ? 'disabled' : ''; ?> ><i class="fa fa-plus"></i> New Column</button>')
            dvItems.append('<button <?= ($isdisabled == '1' || $isdisabled == 1) ? 'disabled' : ''; ?> style="position:absolute; right:0" class="btn btn-danger   btn-sm" type="button" onclick="RemoveTemplate(' +
                TemplateIndex + ')"><i class="fa fa-trash-o"></i>Delete Template</button>')
            $('#dvItems').append(dvItems);


            TemplateIndex++;

            dialog.dialog("close");
        }

        var dialog, form;


        $(document).ready(function() {
            $('#tblSuppliers').DataTable({
                "pageLength": 100
            });
            $('#tblEmailCCUsers').DataTable({
                "pageLength": 100
            });

            dialog = $("#dialog").dialog({
                autoOpen: false,
                height: 400,
                width: 350,
                modal: true,
                buttons: {
                    "Add Template": AddTemplate,
                    Close: function() {
                        dialog.dialog("close");
                    }
                },
                close: function() {
                    // form[ 0 ].reset();
                    //  allFields.removeClass( "ui-state-error" );
                }
            });

            form = dialog.find("form").on("submit", function(event) {
                event.preventDefault();
                addUser();
            });

            <?php 
            if (isset($id))
            {
                ?>

            <?php
            } else {
                ?>

            <?php
            }

            ?>


            $("#Accept").on("click", function(e) {
                //Do you want to save the changes,
                if (confirm_send()) {
                    sendMail();
                    return true;
                }
                return false;
                // Swal.fire({
                //     title: ' suppliers will be informed by email?',
                //     //showDenyButton: true,
                //     showCancelButton: true,
                //     confirmButtonText: 'Send'
                // }).
                // then((result) => {
                //     /* Read more about isConfirmed, isDenied below */
                //     if (result.value) {
                //         sendMail();
                //     } else if (result.isDenied) {
                //         toastr.error('Changes are not saved', "error");
                //     }
                // })
            })

            // Will give alert to confirm delete
            function confirm_send() {
                var message = "Are you sure you want to perform this action?";

                // Clients area
                if (typeof app != "undefined") {
                    message = app.lang.confirm_action_prompt;
                }

                var r = confirm(message);
                if (r == false) {
                    return false;
                }
                return true;
            }

            //Load rfq
            <?php
            if (isset($id))
            {
                ?>

            Templates = <?= json_encode($TemplatesList) ?>;
            Templates.map(Template => {
                //console.log(Templates);
                RowsCount = Template.Rows.length
                ColumnsCount = Template.columns.length
                var table = $(
                    '<table class="table table-bordered table-hover table-striped" id="tblItems_' +
                    TemplateIndex +
                    '"> <caption  style="caption-side:top;text-align:left"><h4><b>Template - (' +
                    TemplateIndex + ')</b></h4></caption></table>').addClass('table');

                var dvItems = $('<div id="dvTemplate_' + TemplateIndex + '"></div>');
                var row = $('<tr style="border-top:none; background:gainsboro ;"></tr>');
                var cell = $('<th style="border:none" ></th>')
                row.append(cell);
                for (j = 1; j <= ColumnsCount; j++) {
                    var cell = $('<th></th>').addClass(TemplateIndex + '_Columns');
                    var input = $(
                        '<div style="border:none; display:flex; justify-content:space-between; background:gainsboro;" ><input placeholder="Enter Column Name"  style="border:none; background:transparent" width="100%" value="' +
                        Template
                        .columns[j - 1].ColumnName + '" name="Tampletes[' + TemplateIndex +
                        '][Columns][' + (j) +
                        ']" /><a width="20%" id="deleteColumn" href="javascript:void(0)" onclick="DeleteColumn(this,' +
                        TemplateIndex +
                        ')" class="btn btn-warning" style="border:none; background:transparent; "><i class="fa fa-times"></i></a></div>');
                    cell.append(input);
                    row.append(cell);
                }
                table.append(row);

                for (i = 0; i < RowsCount; i++) {
                    var row = $('<tr></tr>');
                    for (j = 0; j <= ColumnsCount; j++) {

                        var cell = $('<td></td>').addClass('bar');
                        if (j == 0) {
                            var deleteItem =
                                '<button style="border:none; border-radius:2px; background:gainsboro; " type=button onclick="DeleteRow(this)"   id="deleteItem" > - </i></button>';
                            cell.append(deleteItem);

                        } else {
                            var input = $('<input value="' + Template.Rows[i][j - 1] +
                                '" name="Tampletes[' + TemplateIndex + '][Rows][Row_' + (
                                    j) + '][' + (
                                    i + 2) + ']" style="width: 100%;" />');
                            cell.append(input);
                        }
                        row.append(cell);

                    }

                    table.append(row);
                }
                dvItems.append(table);
                dvItems.append(
                    '<button class="btn btn-primary bg-gradient-primary btn-sm" style="background-color:white; border-radius:0; color:blue" onclick="AddRow(' +
                    TemplateIndex +
                    ')"  type="button" id="new_items_templete" <?= ($isdisabled == '1' || $isdisabled == 1) ? 'disabled' : ''; ?> ><i class="fa fa-plus"></i> New Row</button>'
                )
                dvItems.append(
                    '<button class="btn btn-success m-3   btn-sm" type="button" style="background-color:white; border-radius:0; color:green" onclick="AddColumn(' +
                    TemplateIndex +
                    ')" id="new_items_templete" <?= ($isdisabled == '1' || $isdisabled == 1) ? 'disabled' : ''; ?> ><i class="fa fa-plus"></i> New Column</button>'
                )
                dvItems.append(
                    '<button <?= ($isdisabled == '1' || $isdisabled == 1) ? 'disabled' : ''; ?> style="position:absolute; right:0" class="btn btn-danger   btn-sm" type="button" onclick="RemoveTemplate(' +
                    TemplateIndex + ')"><i class="fa fa-trash-o"></i>Delete Template</button>')
                $('#dvItems').append(dvItems);


                TemplateIndex++;
            });
            <?php
       
            }
            ?>
            $("#tblSuppliers_wrapper").removeClass("table-loading");
            $("#tblEmailCCUsers_wrapper").removeClass("table-loading");

            //End Load rfq
            // $('.summernote').summernote();

        })

        <?php
            if (isset($id))
            {
                    if ($rfqRow->Acceptance=="Rejected")
                    {
            ?>
        // $('#Reject').trigger('click');
        <?php
                    }
            }
            ?>


        $('#AddItem').click(function() {

            const itemNo = $('#itemNo').val();
            if (itemNo === '') {
                $('#itemNo').focus();
                $('#itemNo').css("background-color", "yellow");
                return
            }

            if ($(":input[name^='ItemNoList'][value='" + itemNo + "']").length > 0) {
                toastr.error("Item already added!", 'error', 'top');
                return
            }

            var detailstable = createDetailsTable(itemNo);
            $("#tblItems tr").eq(-1).before($("<tr>").append(
                '<td id="itemIndex">' +
                '' +
                '</td>' +
                '<td>' +
                '<input required readonly value="' + itemNo + '"  name="ItemNoList[' + itemNo +
                ']"/>' +
                '</td>' +

                '<td>' +
                '<input value="' + itemName + '" required name="ItemNameList[' + itemName +
                ']"/>' +
                '</td>' +
                '<td>' +
                '' + detailstable + '' +
                '</td>' +
                '<td>' +
                '<button id="deleteItem" type="button"  class="btn btn-danger" ><i class="fa fa-times"></i></button>' +
                '</td>'
            ));

            $('#AddAttribute_' + itemNo + '').on("click", function() {
                addAttribute('' + itemNo + '', '' + $('#description_' + itemNo + '').val() + '',
                    '' + $(
                        '#value_' + itemNo + '').val() + '');
            });
            $('#itemNo').val('')
            $('#itemName').val('')

            $('#description_' + itemNo + '').val('Manufacturer');
            $('#value_' + itemNo + '').val('Manufacturer');
            addAttribute(itemNo, 'Manufacturer', '-');
            $('#description_' + itemNo + '').val('PartNo');
            $('#value_' + itemNo + '').val('PartNo');
            addAttribute(itemNo, 'PartNo', '-');
            $('#description_' + itemNo + '').val('');
            $('#value_' + itemNo + '').val('');


            var rowCount = $("#tblItems tr").length;
            $('#tblItems tr').each(function() {
                $(this).find('tr.itemIndex').text(i++);
            });
        });

        $('.edit_data').click(function() {
            uni_modal("Edit Employee", "employees/manage_employee.php?id=" + $(this).attr('data-id'),
                'mid-large');
        })
        $('#new_items_templete').click(function() {
            dialog.dialog("open");
        })

        $('#Reject').click(function() {

            //console.log("Rejected");
          /*   uni_modal("<i class='fa fa-plus'></i> New Progress",
                "/manage_discussion?<?php  //echo isset($id) ? 'id=' . $id : ''  ?>&Remarks=Rejected",
                'Default'); */

                if(confirm("Rejection Sure ?")){
                url = "rfq/rfq/reject_inquery/<?= isset($id) ? $id : '' ?>";

            $("body").append('<div class="dt-loader"></div>');
            requestGetJSON(url).done(function(response){
                $("body").find(".dt-loader").remove();
                //console.log("OK");
            if (response.success === true || response.success == "true"){
                    alert("Rejection Done");
                }
            });
        }

        });



        $('.manage_progress').click(function() {
            uni_modal("<i class='fa fa-edit'></i> Edit Progress",
                "/manage_discussion??id=<?= isset($id) ? $id : '' ?>&id=" + $(this).attr(
                    'data-id'), 'large')
        })
        $('.view_data').click(function() {
            uni_modal("View Employee", "employees/view_employee.php?id=" + $(this).attr('data-id'));
        })
        $('.attachments_data').click(function() {
            uni_modal("View Employee", "employees/manage_attachments.php?id=" + $(this).attr(
                'data-id'));
        })
        $('.delete_data').click(function() {
            _conf("Are you sure to delete this Employee permanently?", "delete_employee", [$(this).attr(
                'data-id')])
        })





















function showResult(searchkeyy,theTablee,theId=''){
if(searchkeyy.length >= 4){
//console.log(document.getElementById("searchWord").value)    

//if(!(/[^a-zA-Z]/.test(searchkeyy)))  //to check/ensure that button in only alphabets using regular expression
$.ajax({
  method: "POST",
  url: admin_url+"rfq/Rfq/livesearch/",
  data: { searchkey: searchkeyy, thetable: theTablee }
}).done(function( response ) {
    //$("#metablock").append(response)
    if(theTablee == "suppliers"){


////document.getElementById("tblSuppliersSearchResults").innerHTML = response;

//let matchedSupps = ""+response;
//const matchedSuppliers_notfiltered = matchedSupps.split(",");
////var matchedSuppliers_filtered = matchedSuppliers_notfiltered.filter(function(value, index, arr){return value != "-_-";});
//matchedSuppliers = matchedSuppliers_notfiltered;

var matchedSuppliers_ids = [];
var matchedSuppliers_company = [];
var matchedSuppliers_tittle = [];
var matchedSuppliers_firstname = [];
var matchedSuppliers_lastname = [];
var matchedSuppliers_email = [];
var matchedSuppliers_keywords = [];

matchedSuppliers_ids = JSON.parse(response)[0];
matchedSuppliers_company = JSON.parse(response)[1];
matchedSuppliers_tittle = JSON.parse(response)[2];
matchedSuppliers_firstname = JSON.parse(response)[3];
matchedSuppliers_lastname = JSON.parse(response)[4];
matchedSuppliers_email = JSON.parse(response)[5];
matchedSuppliers_keywords = JSON.parse(response)[6];

//console.log(matchedSuppliers_email);


for(var i=0 ; i < matchedSuppliers_firstname.length ; i++){
if(matchedSuppliers_company[i] == "" || matchedSuppliers_company[i] == null) matchedSuppliers_company[i] = " ";
if(matchedSuppliers_tittle[i] == "" || matchedSuppliers_tittle[i] == null) matchedSuppliers_tittle[i] = " ";
if(matchedSuppliers_firstname[i] == "" || matchedSuppliers_firstname[i] == null) matchedSuppliers_firstname[i] = ( (matchedSuppliers_lastname[i]== "" || matchedSuppliers_lastname[i] == null) ? "-NO NAME-" : " ");
if(matchedSuppliers_lastname[i] == "" || matchedSuppliers_lastname[i] == null) matchedSuppliers_lastname[i] = " ";
if(matchedSuppliers_email[i] == "" || matchedSuppliers_email[i] == null) matchedSuppliers_email[i] = " ";
if(matchedSuppliers_keywords[i] == "" || matchedSuppliers_keywords[i] == null) matchedSuppliers_keywords[i] = " ";
}

//console.log(matchedSuppliers_email);
//console.log(matchedSuppliers_firstname);

//searchWordfl searchWordem searchWordky
/*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
//if( $(this).attr('id') == "searchWord")
autocomplete(document.getElementById(""+theId),matchedSuppliers_ids,matchedSuppliers_company,matchedSuppliers_tittle,matchedSuppliers_firstname,matchedSuppliers_lastname,matchedSuppliers_email,matchedSuppliers_keywords);
//else if()





}else if(theTablee == "stuff"){
    document.getElementById("tblEmailCCUsersSearchResults").innerHTML = response;
    }
    //console.log("founds are :"+response);
    //tinyMce_Creator();
  });

}
}









function additifnotexist(Supplier_id='', Supplier_company='', Supplier_title='', Supplier_firstname='', Supplier_lastname='', Supplier_email='', Supplier_keywords=''){



if(Supplier_company != ''){
//console.log("if");
if($("#cbb"+Supplier_id).is(':checked')){
 if (!$("#roww"+Supplier_id).length){
    //console.log("OK");
    $('#tblSuppliers tr:last').before("<tr id='roww"+Supplier_id+"'><td><input checked type='checkbox' value="+Supplier_id+" name='SupplierList[]' onchange ='removeifexist(\""+Supplier_id+"\",\"suppliers\")'/></td><td>"+Supplier_company+"<br>"+Supplier_title+" "+Supplier_firstname+" "+Supplier_lastname+"</td><td>"+Supplier_email+"</td><td><span class='addReadMore showlesscontent'>"+Supplier_keywords+"</span></td></tr>");
}
}
}else{
//console.log("else");
    if($("#cbbb"+Supplier_id).is(':checked')){
 if (!$("#rowww"+Supplier_id).length){
//console.log("OK");
//$('#tblEmailCCUsers').append("<tr id='rowww"+Supplier_id+"'><td><input checked type='checkbox' value="+Supplier_id+" name='EmailCCUsersList["+ Supplier_id +"]' onchange ='removeifexist(\""+Supplier_id+"\",\"stuff\")'/></td><td>"+Supplier_firstname+" "+Supplier_lastname+"</td><td>"+Supplier_email+"</td></tr>");
$('#tblEmailCCUsers tr:last').before("<tr id='rowww"+Supplier_id+"'><td><input checked type='checkbox' value="+Supplier_id+" name='EmailCCUsersList["+ Supplier_id +"]' onchange ='removeifexist(\""+Supplier_id+"\",\"stuff\")'/></td><td>"+Supplier_firstname+" "+Supplier_lastname+"</td><td>"+Supplier_email+"</td></tr>");
}
}
}

//console.log(Supplier_id);
}







function removeifexist(Supplier_id,whatis){

    if(whatis == "suppliers"){
    //console.log("suppliers");
    $("#roww"+Supplier_id).remove();
}else if(whatis == "stuff"){
    //console.log("stuff");
    $("#rowww"+Supplier_id).remove();
}
}







////Auto complete --------------------------------------------------------------------------------------------------------------------



function autocomplete(inp, arr_id=[], arr_company=[],arr_title=[], arr_firstname=[], arr_lastname=[], arr_email=[], arr_keywords=[]) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
  var currentFocus;
  /*execute a function when someone writes in the text field:*/
//inp.addEventListener("input", function(e) {
      var a, b, i, val = inp.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", inp.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      a.setAttribute("style", "height:auto; max-height:300px; overflow:scroll;background: white;");
      /*append the DIV element as a child of the autocomplete container:*/
      inp.parentNode.appendChild(a);
      /*for each item in the array...*/
      for (i = 0; i < arr_firstname.length; i++) {
        /*check if the item starts with the same letters as the text field value:*/

var cond1 = (arr_company[i].toUpperCase().includes(val.toUpperCase()));
var cond2 = (arr_title[i].toUpperCase().includes(val.toUpperCase()));
var cond3 = (arr_firstname[i].toUpperCase().includes(val.toUpperCase()));
var cond4 = (arr_lastname[i].toUpperCase().includes(val.toUpperCase()));
var cond5 = (arr_email[i].toUpperCase().includes(val.toUpperCase()));
var cond6 = (arr_keywords[i].toUpperCase().includes(val.toUpperCase()));

        if (cond1 || cond2 || cond3 || cond4 || cond5 || cond6 ) {
            //console.log(arr_email[i])
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
          b.setAttribute("class", "ccbb");

          /*make the matching letters bold:*/
          b.innerHTML ="<input class='ccbb' id='cbb"+arr_id[i]+"' type='checkbox' value='"+arr_firstname[i]+" "+arr_lastname[i]+"' name='SupplierList_aftsrch[]' onchange='additifnotexist(\""+arr_id[i]+"\", \""+arr_company[i]+"\", \""+arr_title[i]+"\", \""+arr_firstname[i]+"\", \""+arr_lastname[i]+"\", \""+arr_email[i]+"\", \""+arr_keywords[i]+"\")'/>&nbsp&nbsp<strong  class='ccbb'>"+arr_firstname[i]+" "+arr_lastname[i]+"<br>"+arr_email[i]+"</strong>";

          a.appendChild(b);
        }
      }
  //});

  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        currentFocus--;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();
        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }


  /*execute a function when someone clicks in the document:*/
  document.addEventListener("click", function (e) {
      //closeAllLists(e.target);
  });



}



function closeAllLists2() {
    //close all autocomplete lists in the document
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++)
        x[i].parentNode.removeChild(x[i]);
  }

$(document).click(function(event) {
    var text = $(event.target).attr('class');
    //var text2 = $(event.target).attr('id');
    if(text != "ccbb" )
    closeAllLists2();
    if(text != "tblEmailCCUsersSearchResults" )
    document.getElementById("tblEmailCCUsersSearchResults").innerHTML = "";
});



////----------------------------------------------------------------------------------------------------------------------------------




/* function seevalueof(){
    console.log(SupplierList);
} */







        $('#AddSupplier').click(function() {
            //    start_loader();

//SupplierMobile

/* 
            const name  = $('#SupplierName').val();
            const contact_person = $('#ContactPerson').val();
            const email = $('#SupplierEmail').val();
 */
            const SupplierName = $('#SupplierName').val();
            const SupplierLName = $('#SupplierLName').val();
            const SupplierCompanyName = $('#SupplierCompanyName').val();
            //const SupplierContactPerson = $('#SupplierContactPerson').val();
            const SupplierEmail = $('#SupplierEmail').val();
            const SupplierPhone = $('#SupplierPhone').val();
            const SupplierMobile = $('#SupplierMobile').val();
            const SupplierKeywords = $('#SupplierKeywords').val();


            $.ajax({
  method: "POST",
  url: admin_url+"rfq/Rfq/addquicksupplier/",
  data: { firstname: SupplierName, lastname: SupplierLName, company: SupplierCompanyName, /* unknown: SupplierContactPerson, */ email: SupplierEmail, phone: SupplierPhone, mobile: SupplierMobile, keywords: SupplierKeywords }
}).done(function( response ) {

    if (JSON.parse(response).success === true || JSON.parse(response).success == "true"){
        
        alert("Supplier successfully Added");

        $('#tblSuppliers tr:last').before("<tr id='roww"+JSON.parse(response).theaddedid+"'><td><input checked type='checkbox' value="+JSON.parse(response).theaddedid+" name='SupplierList[]' onchange ='removeifexist(\""+JSON.parse(response).theaddedid+"\",\"suppliers\")'/></td><td>"+SupplierCompanyName+"<br>"/* +"Supplier_tittle" */+" "+SupplierName+" "+SupplierLName+"</td><td>"+SupplierEmail+"</td><td><span class='addReadMore showlesscontent'>"+SupplierKeywords+"</span></td></tr>");


                }

});

            


        });













        var items = [];
        <?php
   if (isset($ItemsList))
   {
    ?>

        items = <?= json_encode($ItemsList) ?>;
        items.map(item => {
            var detailstable = createDetailsTable(item.itemNo);
            //  $('#tblItems').append('<tr class="itemIndex" id="tr_'+item.itemNo+'"> '+
            $("#tblItems tr").eq(-1).before($("<tr>").append(
                '<td id="itemIndex">' +
                '' +
                '</td>' +
                '<td>' +
                '<input style="width:100%" readonly value="' + item.itemNo +
                '" required  name="ItemNoList[' + item.itemNo + ']"/>' +
                '</td>' +

                '<td>' +
                '<input value="' + item.itemName + '" required name="ItemNameList[' + item
                .itemName +
                ']"/>' +
                '</td>' +
                '<td>' +
                '' + detailstable + '' +
                '</td>' +
                '<td>' +
                '<input id="deleteItem" type="button"  class="btn btn-danger" value="-"/>' +
                '</td>'
            ));
            item.AttributesList.map(Attribute => {
                $('#description_' + item.itemNo + '').val(Attribute.description);
                $('#value_' + item.itemNo + '').val(Attribute.value);
                addAttribute(item.itemNo, Attribute.description, Attribute.value);
                $('#description_' + item.itemNo + '').val('');
                $('#value_' + item.itemNo + '').val('');
            })
            $('#AddAttribute_' + item.itemNo + '').on("click", function() {
                addAttribute('' + item.itemNo + '', '' + $('#description_' + item.itemNo + '')
                    .val() + '',
                    '' + $('#value_' + item.itemNo + '').val() + '');
            });
        });



        <?php } ?>
        $("#tblItems").on("click", "#deleteItem", function() {
            $(this).closest("tr").remove();
            // $('#tblItems tr').each(function(i){
            //     $(this).find('td#index').text(i-1);
        });


        //End document ready

        function delete_employee($id) {
            // start_loader();
            $.ajax({
                url: "classes/Master.php?f=delete_employee",
                method: "POST",
                data: {
                    id: $id
                },
                dataType: "json",
                error: err => {
                    console.log(err)
                    toastr.error("An error occured.", 'error', 'top');
                    end_loader();
                },
                success: function(resp) {
                    if (typeof resp == 'object' && resp.status == 'success') {
                        location.reload();
                    } else {
                        toastr.error("An error occured.", 'error', 'top');
                        // end_loader();
                    }
                }
            })
        }
        $('#attach_fileinput1').on("change", function() {

            var imgfilenameee = "ksaa";
            var fd = new FormData();
            var files = $('#attach_fileinput1')[0].files;
            if (files.length > 0) {
                fd.append('prizmrfq_file', files[0]);
                $.ajax({
                    url: "classes/Master.php?f=uploadattach&fieldname=prizmrfq_file&isimage=0&todirectory=rfqs",
                    method: 'POST',
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST',
                    success: function(resp) {
                        if (resp != '') {
                            toastr.success("File Uploaded Successfully", 'success');
                            $('#attach_file1').val(resp);
                            //imgfilenameee = resp;

                            /*setTimeout(function(){
                              location.href = _base_url_+"admin/?page=items&forwarded=1&duplicateornot=on&attach_file1="+resp+"<?php //echo $redirectString
                              ?>";
                            },1500);*/


                        } else {
                            toastr.error("File Un-successfully Uploaded", 'failed');
                            //imgfilenameee = "";
                        }
                    }
                })
            }


        });









        $('#attach_fileinput2').on("change", function() {

            var imgfilenameee = "ksaa";
            var fd = new FormData();
            var files = $('#attach_fileinput2')[0].files;
            if (files.length > 0) {
                fd.append('prizmrfq_file', files[0]);
                $.ajax({
                    url: "classes/Master.php?f=uploadattach&fieldname=prizmrfq_file&isimage=0&todirectory=rfqs",
                    method: 'POST',
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST',
                    success: function(resp) {
                        if (resp != '') {
                            toastr.success("File Uploaded Successfully", 'success');
                            $('#attach_file2').val(resp);
                            //imgfilenameee = resp;

                            /*setTimeout(function(){
                              location.href = _base_url_+"admin/?page=items&forwarded=1&duplicateornot=on&attach_file1="+resp+"<?php //echo $redirectString
                              ?>";
                            },1500);*/


                        } else {
                            toastr.error("File Un-successfully Uploaded", 'failed');
                            //imgfilenameee = "";
                        }
                    }
                })
            }
        });
        $('#attach_fileinput3').on("change", function() {
            var imgfilenameee = "ksaa";
            var fd = new FormData();
            var files = $('#attach_fileinput3')[0].files;
            if (files.length > 0) {
                fd.append('prizmrfq_file', files[0]);
                $.ajax({
                    url: "classes/Master.php?f=uploadattach&fieldname=prizmrfq_file&isimage=0&todirectory=rfqs",
                    method: 'POST',
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST',
                    success: function(resp) {
                        if (resp != '') {
                            toastr.success("File Uploaded Successfully", 'success');
                            $('#attach_file3').val(resp);
                            //imgfilenameee = resp;

                            /*setTimeout(function(){
                              location.href = _base_url_+"admin/?page=items&forwarded=1&duplicateornot=on&attach_file1="+resp+"<?php //echo $redirectString
                              ?>";
                            },1500);*/
                        } else {
                            toastr.error("File Un-successfully Uploaded", 'failed');
                            //imgfilenameee = "";
                        }
                    }
                })
            }


        });

        function file_displayer(x) {
            //document.getElementById("attach_fileinput"+x).style = "display:";
            $('.fileshower' + x).css("display", "");
        }




        // document.getElementById("attach_fileinput1").onchange = function() {
        //     document.getElementById("uploadFile1").value = this.value;
        // };
        // document.getElementById("attach_fileinput2").onchange = function() {
        //     document.getElementById("uploadFile2").value = this.value;
        // };
        // document.getElementById("attach_fileinput3").onchange = function() {
        //     document.getElementById("uploadFile3").value = this.value;
        // };
    </script>
    <script>
        function AddReadMore() {
            //This limit you can set after how much characters you want to show Read More.
            var carLmt = 100;
            // Text to show when text is collapsed
            var readMoreTxt = " ... Read More";
            // Text to show when text is expanded
            var readLessTxt = " Read Less";
            //Traverse all selectors with this class and manupulate HTML part to show Read More
            $(".addReadMore").each(function() {
                if ($(this).find(".firstSec").length)
                    return;
                var allstr = $(this).text();
                if (allstr.length > carLmt) {
                    var firstSet = allstr.substring(0, carLmt);
                    var secdHalf = allstr.substring(carLmt, allstr.length);
                    var strtoadd = firstSet + "<span class='SecSec'>" + secdHalf +
                        "</span><span class='readMore'  title='Click to Show More'>" + readMoreTxt +
                        "</span><span class='readLess' title='Click to Show Less'>" + readLessTxt + "</span>";
                    $(this).html(strtoadd);
                }

            });
            //Read More and Read Less Click Event binding
            $(document).on("click", ".readMore,.readLess", function() {
                $(this).closest(".addReadMore").toggleClass("showlesscontent showmorecontent");
            });
        }
    </script>

    <?php
    require 'modules/rfq/assets/js/RFQ_js.php';
    ?>
    </body>

    </html>

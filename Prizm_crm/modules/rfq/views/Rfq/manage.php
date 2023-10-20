<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); 
?>

<input type="hidden" id= "addedid" name="addedid" value="<?php $addedid = isset($addeddid) ? $addeddid : ""/* $this->session->flashdata('addeddid') */ ; echo $addedid != "" ? $addedid : "" ; ?>" />
<input type="hidden" id= "updatedid" name="updatedid" value="<?php $updatedid = isset($updateddid) ? $updateddid : ""/* $this->session->flashdata('updateddid') */ ; echo $updatedid != "" ? $updatedid : "" ; ?>" />
<input type="hidden" id= "deletedid" name="deletedid" value="<?php $deletedid = /* isset($deleteddid) ? $deleteddid : "" */$this->session->flashdata('deleteddid') ; echo $deletedid != "" ? $deletedid : "" ; ?>" />

<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <?php 
                if (has_permission('rfq', '', 'create')) { ?>
                <div class="tw-mb-2 sm:tw-mb-4">
                    <a style="width:130px;background-color:#1C90FF; border-color:#1C90FF" href="<?php echo admin_url('rfq/rfq/rfq'); ?>" class="btn btn-primary">
                        <i class="fa-regular fa-plus tw-mr-1"></i>
                        <?php echo _l('Add RFQ'); ?>
                    </a>
                </div>
                <?php } ?>
                <div style="background-color:white; border-radius:20px; box-shadow:0 .125rem .25rem rgba(0,0,0,.075)!important">
                    <div class="header" style="padding:10px 27px">

                        <h1 style="font-size:24px; font-weight:bold; color:#1C90FF">
                            <svg style="color:#1C90FF" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                class="tw-w-5 tw-h-5 tw-text-neutral-500 tw-mr-1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z">
                                </path>
                            </svg>
                            RFQ Summary
                        </h1>
                    </div>
                    <div class="row" style="padding: 20px 30px 30px;
    margin-bottom: 30px;">
                        <div class="col-xs-6 col-md-2" style="text-align:center">
                            <div style="display:flex; gap:5px; justify-content:center; border-right:1px solid gainsboro">
                                <i style="height: 10%;
                                    border-radius: 500%;
                                    background: #dcdcdc40;
                                    padding: 10px;
                                    color:#1C90FF" class="fa fa-car">
                                </i>
                            <div>
                                    <a href="#" class="tw-text-neutral-600 hover:tw-opacity-70 tw-flex tw-items-center" style="gap:5px;    flex-direction: column-reverse;">
                                        <span style="color:#1C90FF; font-size:1.5rem"
                                            class="tw-font-bold rtl:tw-ml-3 tw-text-lg">
                                            1122 </span>
                                        <span style="color:#4755698f; font-weight:500" >
                                            Status #1 </span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-6 col-md-2" style="text-align:center">
                            <div style="display:flex; gap:5px; justify-content:center; border-right:1px solid gainsboro">
                                <i style="height: 10%;
                                    border-radius: 500%;
                                    background: #dcdcdc40;
                                    padding: 10px;
                                    color:#1C90FF" class="fa fa-dollar">
                                </i>
                            <div>
                                    <a href="#" class="tw-text-neutral-600 hover:tw-opacity-70 tw-flex tw-items-center" style="gap:5px;    flex-direction: column-reverse;">
                                        <span style="color:#1C90FF; font-size:1.5rem"
                                            class="tw-font-bold rtl:tw-ml-3 tw-text-lg">
                                            N/A </span>
                                        <span style="color:#4755698f; font-weight:500" >
                                            Status #2 </span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        

                        <div class="col-xs-6 col-md-2" style="text-align:center">
                            <div style="display:flex; gap:5px; justify-content:center; border-right:1px solid gainsboro">
                                <i style="height: 10%;
                                    border-radius: 500%;
                                    background: #dcdcdc40;
                                    padding: 10px;
                                    color:#1C90FF" class="fa fa-pencil">
                                </i>
                            <div>
                                    <a href="#" class="tw-text-neutral-600 hover:tw-opacity-70 tw-flex tw-items-center" style="gap:5px;    flex-direction: column-reverse;">
                                        <span style="color:#1C90FF; font-size:1.5rem"
                                            class="tw-font-bold rtl:tw-ml-3 tw-text-lg">
                                            34 </span>
                                        <span style="color:#4755698f; font-weight:500" >
                                            Status #4 </span>
                                    </a>
                                </div>
                            </div>
                        </div>



                        <div class="col-xs-6 col-md-2" style="text-align:center">
                            <div style="display:flex; gap:5px; justify-content:center; border-right:1px solid gainsboro">
                                <i style="height: 10%;
                                    border-radius: 500%;
                                    background: #dcdcdc40;
                                    padding: 10px;
                                    color:#1C90FF" class="fa fa-file">
                                </i>
                            <div>
                                    <a href="#" class="tw-text-neutral-600 hover:tw-opacity-70 tw-flex tw-items-center" style="gap:5px;    flex-direction: column-reverse;">
                                        <span style="color:#1C90FF; font-size:1.5rem"
                                            class="tw-font-bold rtl:tw-ml-3 tw-text-lg">
                                            4011 </span>
                                        <span style="color:#4755698f; font-weight:500" >
                                            Status #3 </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-2" style="text-align:center">
                            <div style="display:flex; gap:5px; justify-content:center; border-right:1px solid gainsboro">
                                <i style="height: 10%;
                                    border-radius: 500%;
                                    background: #dcdcdc40;
                                    padding: 10px;
                                    color:#1C90FF" class="fa fa-pencil">
                                </i>
                            <div>
                                    <a href="#" class="tw-text-neutral-600 hover:tw-opacity-70 tw-flex tw-items-center" style="gap:5px;    flex-direction: column-reverse;">
                                        <span style="color:#1C90FF; font-size:1.5rem"
                                            class="tw-font-bold rtl:tw-ml-3 tw-text-lg">
                                            239 </span>
                                        <span style="color:#4755698f; font-weight:500" >
                                            Status #5 </span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-6 col-md-2" style="text-align:center">
                            <div style="display:flex; gap:5px; justify-content:center;">
                                <i style="height: 10%;
                                    border-radius: 500%;
                                    background: #dcdcdc40;
                                    padding: 10px;
                                    color:#1C90FF" class="fa fa-pencil">
                                </i>
                            <div>
                                    <a href="#" class="tw-text-neutral-600 hover:tw-opacity-70 tw-flex tw-items-center" style="gap:5px;    flex-direction: column-reverse;">
                                        <span style="color:#1C90FF; font-size:1.5rem"
                                            class="tw-font-bold rtl:tw-ml-3 tw-text-lg">
                                            12 </span>
                                        <span style="color:#4755698f; font-weight:500" >
                                            Status #6 </span>
                                    </a>
                                </div>
                            </div>
                        </div>


                            

                        </div>
                </div>
                <div class="panel_s" style="border-radius:20px">
                    <div style="border-radius:20px" class="panel-body panel-table-full">
                        <?php render_datatable([
                                    _l('id'),
                                    _l('rfq_code'),
                                    _l('Acceptance'),
                                    _l('assigned_employee'),
                                    _l('created_at'),
                                    _l('status'),
                                ], 'RFQ'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  
    <!-- Modal -->
    <div class="modal fade in" id="opp_details_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">#1 </dd></h4>
                </div>
                <div class="modal-body">
                    
                </div>
            </div>
        </div>
    </div>
    <!-- end modal -->


<!-- <?php //echo $oppID->email ?> -->
<script id="hidden-columns-table-RFQs" type="text/json">
</script>
<?php init_tail(); ?>


<?php 
require('modules/rfq/assets/js/RFQ_js.php');
?>
<style>
        table{
            padding: 0 10px !important;
        }
        th{
            background-color: #f8f9fa !important;
            color: #6c757d !important;
    font-weight: 400 !important;
    font-size: 14px !important;
            padding-top: 5px !important;
            padding-bottom: 5px !important;
            height: 10px !important;
            border-top:none !important;
            border-right:none !important;
        }
        select[name="DataTables_Table_0_length"] {

            box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075) !important;
            border: 1px solid #1c90ff1c !important;
        }

        .dt-buttons,
        .input-group {
            border-radius: 153px;
            box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075) !important;
            width: 199px
        }

        .dt-buttons>button:first-child {
            width: 166px;
        }

        .input-group>input {
            width: 250px !important;
        }

        .dt-buttons>button,
        .input-group>* {
            border: 1px solid #0000000e !important;
        }

        .input-group>span {
            color: #1C90FF
        }

        .fa.fa-refresh {
            color: #1C90FF !important;
        }
        .col-md-2.col-xs-6{
            padding: 0 !important
        }
        .col-md-7, .col-md-5{
            margin-bottom:10px
        }
    </style>
</body>

</html>
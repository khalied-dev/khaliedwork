<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head();
// $section = $this->uri->segment('4');
?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <?php 
            
            //gets the current string comes after "http://localhost/Prizm_crm/" from the URL
            //echo "<h1>".$this->uri->uri_string()."</h1>";
            //exit(1);

            echo form_open(/* $this->uri->uri_string()*/admin_url('materials/add_metafields_groups/'), ['id' => 'materials_form']); ?>
            <div class="col-md-8 col-md-offset-2">
                <h4 class="tw-mt-0 tw-font-semibold tw-text-lg tw-text-neutral-700">
                    <?php 
                    echo $title; 
                    //echo "Edit Material";
                    ?>
                </h4>
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="horizontal-scrollable-tabs panel-full-width-tabs">
                            <div class="scroller arrow-left"><i class="fa fa-angle-left"></i></div>
                            <div class="scroller arrow-right"><i class="fa fa-angle-right"></i></div>
                            <div class="horizontal-tabs">
                                <ul class="nav nav-tabs nav-tabs-horizontal" role="tablist">
                                    <li role="presentation" class="active">
                                        <a href="#tab_materials" aria-controls="tab_materials" role="tab"
                                            data-toggle="tab">
                                            <?php echo _l('Meta fields\' Groups'); ?>
                                        </a>
                                    </li>
                                    <!-- <li role="presentation">
                                        <a href="#tab_settings" aria-controls="tab_settings" role="tab"
                                            data-toggle="tab">
                                            <?php //echo _l('materials_settings');
                                            ?>
                                        </a>
                                    </li> -->
                                </ul>
                            </div>
                        </div>
                        <div class="tab-content tw-mt-3">
                            <div role="tabpanel" class="tab-pane active" id="tab_materials">


                            <div class="col-md-12">
                                <?php 
                                //$value = isset($material) ? $material->item_name : ''; 
                                echo render_input('group_name', 'Group Name', null); 
                                ?>
                            </div>

                            <div class="col-md-12">
                                    <div class="form-group">
                                        <p class="bold"><?php echo _l('Group Details'); ?></p>

                                        <?php
                                        //$remarks = isset($material) ? $material->remarks : '';
                                        
                                        echo render_textarea('group_details', '', null, [], [], '', 'tinymce');
                                        ?>
                                    </div>
                            </div>
                            </div>
                        </div>
                        <?php //echo form_close(); ?>
                    </div>
                  
                    <div class="panel-footer text-right" style="background-color: white">
                                    <button type="submit" data-form="#costcenter_form" class="btn btn-primary"
                                        autocomplete="off" data-loading-text="<?php echo _l('wait_text'); ?>">
                                        <?php echo _l('submit'); ?>
                                    </button>
                    </div>



<div class="panel-body">

                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>

                </div>
            </div>
            <?php init_tail(); ?>
            <script>

var counter = 0;



                <?php if (isset($costcenter)) { ?>
                //var original_materials_status = '<?php //echo $costcenter->status; ?>';
                <?php } ?>

                $(function() {});



            </script>
            </body>

            </html>

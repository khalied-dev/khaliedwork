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

            echo form_open(/* $this->uri->uri_string()*/admin_url('' . $tittle), []); ?>
            <div class="col-md-8 col-md-offset-2">
                <h4 class="tw-mt-0 tw-font-semibold tw-text-lg tw-text-neutral-700">
                    <?php 
                    //echo $tittle;
                    echo "RFX details > <span style='color:blue; font-size: 75%;'>".$rfxno."</span>";
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
<!--                                         <a href="#tab_materials" aria-controls="tab_materials" role="tab"
                                            data-toggle="tab">
                                            <?php //echo _l('RFX Lead Details'); ?>
                                        </a> -->
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="tab-content tw-mt-3">
                            <div role="tabpanel" class="tab-pane active" id="tab_materials">

<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

                                <?php $value = isset($material) ? $material->datecreated : ''; ?>
                                <input type="hidden" name="datecreated" value="<?= $value ?>" />
                            </div>
                        </div>
                    </div>


                    















                    <div class="panel-body">





  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home"><?php echo _l('RFX Details'); ?></a></li>
    <li><a data-toggle="tab" href="#menu1"><?php echo _l('RFX Advanced Details'); ?></a></li>
    <li><a data-toggle="tab" href="#menu2"><?php echo _l('RFX Scrapping Details'); ?></a></li>
<!--<li><a data-toggle="tab" href="#menu3">Menu 3</a></li> -->
  </ul>
































  <div class="tab-content">
  <!-- //////////////////////////////////RFX Lead' Details //////////////////////////////////////////////////////// -->
  <!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
    <div id="home" class="tab-pane fade in active">

    <h3 style="font-weight: 900;">RFX Lead' Details :</h3>

<br><br>

                            <div class="col-md-6">
                                <!-- <br> -->
                                <?php 
/* 
//------['leads_res']   ['advance_leads_res']    ['advance_leads_details_res'] -----
print_r($data['rfxno_details']['----'] ;
$value = isset($material) ? $material->item_code : '';
*/

                                $value = isset($rfxno_details) ? $rfxno_details['leads_res'][0]['title'] : '';
                                echo render_input('title', 'Lead tittle' , $value,'text',['disabled' => 'disabled']);
                                ?>
                            </div>

                            <div class="col-md-6">
                                <?php 
                                $value = isset($rfxno_details) ? $rfxno_details['leads_res'][0]['company'] : ''; 
                                echo render_input('company', 'Company', $value,'text',['disabled' => 'disabled']); 
                                ?>
                            </div>

                            <div class="col-md-6">
                            </div>

                            <div class="col-md-12">
                                    <div class="form-group">
                                        <p class="bold"><?php echo _l('Description'); ?></p>

                                        <?php
                                        $description = isset($rfxno_details) ? $rfxno_details['leads_res'][0]['description'] : '';

                                        echo render_textarea('description', '', $description, ['disabled' => 'disabled'], [], '', '');
                                        ?>
                                    </div>
                            </div>

                            <div class="col-md-6">
                                <?php 
                                $value = isset($rfxno_details) ? $rfxno_details['leads_res'][0]['country'] : ''; 
                                echo render_input('country', 'Country', $value,'text',['disabled' => 'disabled']); 
                                ?>
                            </div>
                            
                            <div class="col-md-6">
                                <?php 
                                 $value = isset($rfxno_details) ? $rfxno_details['leads_res'][0]['zip'] : ''; 
                                 echo render_input('zip', 'Zip', $value,'text',['disabled' => 'disabled']); 
                                ?>
                            </div>
                            
                            <div class="col-md-6">
                                <?php 
                                 $value = isset($rfxno_details) ? $rfxno_details['leads_res'][0]['city'] : ''; 
                                 echo render_input('city', 'City', $value,'text',['disabled' => 'disabled']); 
                                ?>
                            </div>
                            
                            <div class="col-md-6">
                                <?php 
                                 $value = isset($rfxno_details) ? $rfxno_details['leads_res'][0]['state'] : ''; 
                                 echo render_input('state', 'State', $value,'text',['disabled' => 'disabled']); 
                                ?>
                            </div>
                            
                            <div class="col-md-6">
                                <?php 
                                 $value = isset($rfxno_details) ? $rfxno_details['leads_res'][0]['address'] : ''; 
                                 echo render_input('address', 'Address', $value,'text',['disabled' => 'disabled']); 
                                ?>
                            </div>
                            
                            
                            <div class="col-md-6">
                                <?php 
                                $value = isset($rfxno_details) ? $rfxno_details['leads_res'][0]['assigned'] : ''; 
                                echo render_input('assigned', 'Assigned', $value,'text',['disabled' => 'disabled']); 
                                ?>
                            </div>
                            
                            <div class="col-md-6">
                                <?php 
                                 $value = isset($rfxno_details) ? $rfxno_details['leads_res'][0]['dateadded'] : ''; 
                                 echo render_input('dateadded', 'Date added', $value,'text',['disabled' => 'disabled']); 
                                ?>
                            </div>
                            
                            <div class="col-md-6">
                                <?php 
                                $value = isset($rfxno_details) ? $rfxno_details['leads_res'][0]['from_form_id'] : ''; 
                                echo render_input('from_form_id', 'From form id\' item code', $value,'text',['disabled' => 'disabled']); 
                                ?>
                            </div>

                            <div class="col-md-6">    
                                <?php
                                $value = isset($rfxno_details) ? $rfxno_details['leads_res'][0]['status'] : ''; 
                                echo render_input('status', 'Status', $value,'text',['disabled' => 'disabled']);  
                                ?>
                            </div>
                            <div class="col-md-6">
                                <?php 
                                $value = isset($rfxno_details) ? $rfxno_details['leads_res'][0]['source'] : ''; 
                                echo render_input('source', 'Source', $value,'text',['disabled' => 'disabled']); 
                                ?>
                            </div>
                            <div class="col-md-6">
                                <?php 
                                $value = isset($rfxno_details) ? $rfxno_details['leads_res'][0]['lastcontact'] : ''; 
                                echo render_input('lastcontact', 'Last Contact', $value,'text',['disabled' => 'disabled']); 
                                ?>
                            </div>
                            
                            <div class="col-md-6">
                                <?php 
                                $value = isset($rfxno_details) ? $rfxno_details['leads_res'][0]['dateassigned'] : ''; 
                                echo render_input('dateassigned', 'Date Assigned', $value,'text',['disabled' => 'disabled']); 
                                ?>
                            </div>
                            <div class="col-md-6">
                                <?php 
                                $value = isset($rfxno_details) ? $rfxno_details['leads_res'][0]['last_status_change'] : ''; 
                                echo render_input('last_status_change', 'Last Status Change', $value,'text',['disabled' => 'disabled']); 
                                ?>
                            </div>
                            
                            <div class="col-md-6">
                                <?php 
                                 $value = isset($rfxno_details) ? $rfxno_details['leads_res'][0]['addedfrom'] : ''; 
                                 echo render_input('addedfrom', 'Added From', $value,'text',['disabled' => 'disabled']); 
                                ?>
                            </div>
                            
                            <div class="col-md-6">
                                <?php 
                                 $value = isset($rfxno_details) ? $rfxno_details['leads_res'][0]['email'] : ''; 
                                 echo render_input('email', 'E-mail', $value,'text',['disabled' => 'disabled']); 
                                ?>
                            </div>
                            
                            <div class="col-md-6">
                                <?php 
                                 $value = isset($rfxno_details) ? $rfxno_details['leads_res'][0]['website'] : ''; 
                                 echo render_input('website', 'Website', $value,'text',['disabled' => 'disabled']); 
                                ?>
                            </div>
                            
                            <div class="col-md-6">
                                <?php 
                                 $value = isset($rfxno_details) ? $rfxno_details['leads_res'][0]['leadorder'] : ''; 
                                 echo render_input('leadorder', 'Lead Order', $value,'text',['disabled' => 'disabled']); 
                                ?>
                            </div>
                            
                            
                            <div class="col-md-6">
                                <?php 
                                $value = isset($rfxno_details) ? $rfxno_details['leads_res'][0]['phonenumber'] : ''; 
                                echo render_input('phonenumber', 'phonenumber', $value,'text',['disabled' => 'disabled']); 
                                ?>
                            </div>
                            
                            <div class="col-md-6">
                                <?php 
                                 $value = isset($rfxno_details) ? $rfxno_details['leads_res'][0]['date_converted'] : ''; 
                                 echo render_input('date_converted', 'Date Converted', $value,'text',['disabled' => 'disabled']); 
                                ?>
                            </div>
                            
                            <div class="col-md-6">
                                <?php 
                                $value = isset($rfxno_details) ? $rfxno_details['leads_res'][0]['lost'] : ''; 
                                echo render_input('lost', 'Lost', $value,'text',['disabled' => 'disabled']); 
                                ?>
                            </div>

                            <div class="col-md-6">    
                                <?php
                                $value = isset($rfxno_details) ? $rfxno_details['leads_res'][0]['junk'] : ''; 
                                echo render_input('junk', 'Junk', $value,'text',['disabled' => 'disabled']);  
                                ?>
                            </div>
                            <div class="col-md-6">
                                <?php 
                                $value = isset($rfxno_details) ? $rfxno_details['leads_res'][0]['last_lead_status'] : ''; 
                                echo render_input('last_lead_status', 'last Lead Status', $value,'text',['disabled' => 'disabled']); 
                                ?>
                            </div>
                            <div class="col-md-6">
                                <?php 
                                $value = isset($rfxno_details) ? $rfxno_details['leads_res'][0]['is_imported_from_email_integration'] : ''; 
                                echo render_input('is_imported_from_email_integration', 'Is Imported From Email Integration', $value,'text',['disabled' => 'disabled']); 
                                ?>
                            </div>
                            <div class="col-md-6">
                                <?php 
                                $value = isset($rfxno_details) ? $rfxno_details['leads_res'][0]['email_integration_uid'] : ''; 
                                echo render_input('email_integration_uid', 'Email Integration Uid', $value,'text',['disabled' => 'disabled']); 
                                ?>
                            </div>
                            <div class="col-md-6">
                                <?php 
                                $value = isset($rfxno_details) ? $rfxno_details['leads_res'][0]['is_public'] : ''; 
                                echo render_input('is_public', 'Is Public', $value,'text',['disabled' => 'disabled']); 
                                ?>
                            </div>
                            <div class="col-md-6">
                                <?php 
                                $value = isset($rfxno_details) ? $rfxno_details['leads_res'][0]['default_language'] : ''; 
                                echo render_input('default_language', 'Default Language', $value,'text',['disabled' => 'disabled']); 
                                ?>
                            </div>

                            <div class="col-md-6">
                                <?php 
                                $value = isset($rfxno_details) ? $rfxno_details['leads_res'][0]['client_id'] : ''; 
                                echo render_input('client_id', 'Client |ID', $value,'text',['disabled' => 'disabled']); 
                                ?>
                            </div>

                            <div class="col-md-6">
                                <?php 
                                $value = isset($rfxno_details) ? $rfxno_details['leads_res'][0]['lead_value'] : ''; 
                                echo render_input('lead_value', 'Lead Value', $value,'text',['disabled' => 'disabled']); 
                                ?>
                            </div>
    </div>
  <!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
  <!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
































































  <!-- //////////////////////////////////RFX advance Lead' Details//////////////////////////////////////////////////////// -->
  <!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
    <div id="menu1" class="tab-pane fade">
    <h3 style="font-weight: 900;">RFX Lead' advance Details :</h3>
    <br><br>
                            <div class="col-md-6">
                                <?php 
                                $value = isset($rfxno_details) ? $rfxno_details['advance_leads_res'][0]['action'] : '';
                                echo render_input('action', 'Action' , $value,'text',['disabled' => 'disabled']);
                                ?>
                            </div>
                            <div class="col-md-6">
                                <?php 
                                $value = isset($rfxno_details) ? $rfxno_details['advance_leads_res'][0]['action_at'] : ''; 
                                echo render_input('action_at', 'Action At', $value,'text',['disabled' => 'disabled']); 
                                ?>
                            </div>
                            <div class="col-md-6">
                                <?php 
                                $value = isset($rfxno_details) ? $rfxno_details['advance_leads_res'][0]['action_staff_id'] : ''; 
                                echo render_input('action_staff_id', 'Action Staff ID', $value,'text',['disabled' => 'disabled']); 
                                ?>
                            </div>
                            <div class="col-md-12">
                                    <div class="form-group">
                                        <p class="bold"><?php echo _l('Notes'); ?></p>

                                        <?php
                                        $notes = isset($rfxno_details) ? $rfxno_details['advance_leads_res'][0]['notes'] : '';

                                        echo render_textarea('notes', '', $notes, ['disabled' => 'disabled'], [], '', '');
                                        ?>
                                    </div>
                            </div>

                            <div class="col-md-6">
                                <?php 
                                $value = isset($rfxno_details) ? $rfxno_details['advance_leads_res'][0]['feedback_at'] : ''; 
                                echo render_input('feedback_at', 'Feed back At', $value,'text',['disabled' => 'disabled']); 
                                ?>
                            </div>
                            
                            <div class="col-md-6">
                                <?php 
                                 $value = isset($rfxno_details) ? $rfxno_details['advance_leads_res'][0]['feedback_staff_id'] : ''; 
                                 echo render_input('feedback_staff_id', 'feed back\' Staff ID', $value,'text',['disabled' => 'disabled']); 
                                ?>
                            </div>
                            
                            <div class="col-md-12">
                                    <div class="form-group">
                                        <p class="bold"><?php echo _l('Feed back\' Note'); ?></p>

                                        <?php
                                        $feedback_note = isset($rfxno_details) ? $rfxno_details['advance_leads_res'][0]['feedback_note'] : '';

                                        echo render_textarea('feedback_note', '', $feedback_note, ['disabled' => 'disabled'], [], '', '');
                                        ?>
                                    </div>
                            </div>
                            
                            <div class="col-md-6">
                                <?php 
                                 $value = isset($rfxno_details) ? $rfxno_details['advance_leads_res'][0]['feedback_attachment'] : ''; 
                                 echo render_input('feedback_attachment', 'Feed back\' Attachment', $value,'text',['disabled' => 'disabled']); 
                                ?>
                            </div>
                            
                            <div class="col-md-6">
                                <?php 
                                 $value = isset($rfxno_details) ? $rfxno_details['advance_leads_res'][0]['active_at'] : ''; 
                                 echo render_input('active_at', 'Active At', $value,'text',['disabled' => 'disabled']); 
                                ?>
                            </div>
                            
                            
                            <div class="col-md-6">
                                <?php 
                                $value = isset($rfxno_details) ? $rfxno_details['advance_leads_res'][0]['responsible_staff_id'] : ''; 
                                echo render_input('responsible_staff_id', 'Responsible Staff\' ID', $value,'text',['disabled' => 'disabled']); 
                                ?>
                            </div>
                            
                            <div class="col-md-6">
                                <?php 
                                 $value = isset($rfxno_details) ? $rfxno_details['advance_leads_res'][0]['job_field'] : ''; 
                                 echo render_input('job_field', 'Job Field', $value,'text',['disabled' => 'disabled']); 
                                ?>
                            </div>
                            
                            <div class="col-md-6">
                                <?php 
                                $value = isset($rfxno_details) ? $rfxno_details['advance_leads_res'][0]['job_type'] : ''; 
                                echo render_input('job_type', 'Job Type', $value,'text',['disabled' => 'disabled']); 
                                ?>
                            </div>

                            <div class="col-md-6">    
                                <?php
                                $value = isset($rfxno_details) ? $rfxno_details['advance_leads_res'][0]['is_dewa'] : ''; 
                                echo render_input('is_dewa', 'Is Dewa', $value,'text',['disabled' => 'disabled']);  
                                ?>
                            </div>
                            <div class="col-md-6">
                                <?php 
                                $value = isset($rfxno_details) ? $rfxno_details['advance_leads_res'][0]['status'] : ''; 
                                echo render_input('status', 'Status', $value,'text',['disabled' => 'disabled']); 
                                ?>
                            </div>

    

    </div>
  <!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
  <!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
  


































 
  <!-- //////////////////////////////////RFX Lead' Details //////////////////////////////////////////////////////// -->
  <!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
    <div id="menu2" class="tab-pane fade">

    <h3 style="font-weight: 900;">RFX Lead' Scrapping Details :</h3>

    <div style="overflow: scroll;">


 <table class="table table-striped">
    <thead>
      <tr>
      <th><h4 style="font-weight: 900;">Floating Date</h4></th>
      <th><h4 style="font-weight: 900;">Closing Date</h4></th>
      <th><h4 style="font-weight: 900;">Scraped at</h4></th>
      </tr>
    </thead>
    <tbody>
<?php

foreach($rfxno_details['advance_leads_details_res'] as $advance_leads_details_res){
echo "<tr>";
echo "<td>".$advance_leads_details_res['floatingdate']."</td>";
echo "<td>".$advance_leads_details_res['closingdate']."</td>";
echo "<td>".$advance_leads_details_res['scrapedat']."</td>";
echo "</tr>";

}
?>
    </tbody>
  </table>
</div>


    </div>
  <!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
  <!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
  </div>




























                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
            <?php init_tail(); ?>
            <script>


var counter = parseInt(document.getElementById("sizeof_material_metadata_recs").value);

   //console.log("counter is :"+counter);

                <?php if (isset($costcenter)) { ?>
                //var original_materials_status = '<?php //echo $costcenter->status; ?>';
                <?php } ?>
                $(function() {});

/* $(function() {
    //console.log($('#search_key').val());
    initDataTable('.table-materials',  admin_url + 'materials/tablerfx_detailed/'+ $('#search_key').val());
    //initDataTable('.table-materials',  admin_url + 'materials/table');
});   */

            </script>
            </body>

            </html>


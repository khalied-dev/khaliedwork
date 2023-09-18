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

            echo form_open(/* $this->uri->uri_string()*/admin_url('' . $material->id), []); ?>
            <div class="col-md-8 col-md-offset-2">
                <h4 class="tw-mt-0 tw-font-semibold tw-text-lg tw-text-neutral-700">
                    <?php 
                    echo $title; 
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
                                            <?php echo _l('Material\' Data'); ?>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="tab-content tw-mt-3">
                            <div role="tabpanel" class="tab-pane active" id="tab_materials">

                            <div class="col-md-12">
                                <!-- <br> -->
                                <?php 
                                $value = isset($material) ? $material->item_code : '';
                                echo render_input('item_code', 'item code' , $value,'text',['disabled' => 'disabled']);
                                ?>
                            </div>

                            <div class="col-md-12">
                                <?php 
                                $value = isset($material) ? $material->item_name : ''; 
                                echo render_input('item_name', 'item name', $value,'text',['disabled' => 'disabled']); 
                                ?>
                            </div>

                            <div class="col-md-12">
                            </div>

                            <div class="col-md-12">
                                    <div class="form-group">
                                        <p class="bold"><?php echo _l('remarks'); ?></p>

                                        <?php
                                        $remarks = isset($material) ? $material->remarks : '';
                                        
                                        echo render_textarea('remarks', '', $remarks, ['disabled' => 'disabled'], [], '', '');
                                        ?>
                                    </div>
                            </div>

                            <div class="col-md-12">
                                <?php 
                                $value = isset($material) ? $material->partner : ''; 
                                echo render_input('partner', 'Partner', $value,'text',['disabled' => 'disabled']); 
                                ?>
                            </div>
                            
                            <div class="col-md-6">
                                <?php 
                                $value = isset($material) ? $material->partner_item_code : ''; 
                                echo render_input('partner_item_code', 'Partner\' item code', $value,'text',['disabled' => 'disabled']); 
                                ?>
                            </div>
                            
                            <div class="col-md-6">
                                <?php 
                                $value = isset($material) ? $material->partner_item_name : ''; 
                                echo render_input('partner_item_name', 'Partner\' item name', $value,'text',['disabled' => 'disabled']); 
                                ?>
                            </div>
                            
                            <div class="col-md-6">
                                <?php 
                                $value = isset($material) ? $material->category_id : ''; 
                                echo render_input('category_id', 'Category ID', $value,'text',['disabled' => 'disabled']); 
                                ?>
                            </div>

                            <div class="col-md-6">    
                                <?php
                                $value = isset($material) ? $material->field_id : ''; 
                                echo render_input('field_id', 'Field id', $value,'text',['disabled' => 'disabled']); 
                                ?>
                            </div>
                            
                            <div class="col-md-6">
                                <?php 
                                $value = isset($material) ? $material->purchase_price : ''; 
                                echo render_input('purchase_price', 'Purchase price', $value,'text',['disabled' => 'disabled']); 
                                ?>
                            </div>
                            
                            <div class="col-md-6">
                                <?php 
                                $value = isset($material) ? $material->sell_price : ''; 
                                echo render_input('sell_price', 'Sell price', $value,'text',['disabled' => 'disabled']);
                                ?>
                            </div>

                                <?php $value = isset($material) ? $material->datecreated : ''; ?>
                                <input type="hidden" name="datecreated" value="<?= $value ?>" />
                            </div>
                        </div>
                    </div>


                    















                    <div class="panel-body">










  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#menu1"><?php echo _l('Material\' Meta Data'); ?></a></li>
    <li><a data-toggle="tab" href="#home"><?php echo _l('Meta Data (Raw)'); ?></a></li>
<!--<li><a data-toggle="tab" href="#menu2">Menu 2</a></li> -->
<!--<li><a data-toggle="tab" href="#menu3">Menu 3</a></li> -->
  </ul>

  <div class="tab-content">




  <!-- //////////////////////////////////Material' Meta Data CONT//////////////////////////////////////////////////////// -->
  <!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
    <div id="menu1" class="tab-pane fade in active">
      <!-- <h4><?php //echo _l('Material\' Meta Data'); ?></h4> -->

<!--                    
                        <div class="horizontal-scrollable-tabs panel-full-width-tabs">
                            <div class="scroller arrow-left"><i class="fa fa-angle-left"></i></div>
                            <div class="scroller arrow-right"><i class="fa fa-angle-right"></i></div>
                            <div class="horizontal-tabs">
                                <ul class="nav nav-tabs nav-tabs-horizontal" role="tablist">
                                    <li role="presentation" class="active">
                                        <a href="#tab_materials" aria-controls="tab_materials" role="tab"
                                            data-toggle="tab">
                                            <?php //echo _l('Material\' Meta Data'); ?>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div> 
-->


<?php 
$sizeof_material_metadata_recs = sizeof($material_metadata);
?>

<input type="hidden" id="sizeof_material_metadata_recs" name="sizeof_material_metadata_recs" value="<?= $sizeof_material_metadata_recs ?>" />

<?php

for($i=0 ; $i < $sizeof_material_metadata_recs ; $i++){
?>
                    <div class="tab-content tw-mt-3" id="metablock_<?php echo $i+1; ?>">
                            <div role="tabpanel" class="tab-pane active" id="tab_materials">

                            <div class="col-md-12">
                            <br>
                            <h4>Meta Field <?= $i+1 ?> :</h4>
                            </div>
                    <?php $value = $material_metadata[$i]['id']; ?>
                    <input type="hidden" name="id_<?php echo ($i+1); ?>" value="<?= $value ?>" />
                            <div class="col-md-6">
                                <br>
                                <?php 
                                $value = isset($material_metadata[$i]) ? $material_metadata[$i]['meta_field'] : ''; 
                                echo render_input('meta_field_'.($i+1), 'Name', $value,'text',['disabled' => 'disabled']); 
                                ?>
                            </div>

                            <div class="col-md-6">
                                <br>
                                <?php 
                                $value = isset($material_metadata[$i]) ? $material_metadata[$i]['meta_value'] : ''; 
                                echo render_input('meta_value_'.($i+1), 'Value', $value,'text',['disabled' => 'disabled']); 
                                ?>
                            </div>

                            <div class="col-md-12">
                                    <div class="form-group">
                                        <p class="bold"><?php echo _l('remarks'); ?></p>

                                        <?php
                                        $remarks = isset($material_metadata[$i]) ? $material_metadata[$i]['remarks'] : '';
                                        
                                        echo render_textarea('remarks_'.($i+1), '', $remarks, ['disabled' => 'disabled'], [], '', '');
                                        ?>
                                    </div>
                            </div>
                          </div>
                        </div>
<?php } ?>





    </div>
  <!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
  <!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
















  <!-- //////////////////////////////////Meta Fields Specifications CONT//////////////////////////////////////////////////////// -->
  <!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
  <div id="home" class="tab-pane fade">

<div style="overflow: scroll;">


<table class="table table-striped">
   <thead>
     <tr>
     <th><h4 style="font-weight: 900;">#</h4></th>
     <th><h4 style="font-weight: 900;">Name</h4></th>
     <th><h4 style="font-weight: 900;">Value</h4></th>
     <th><h4 style="font-weight: 900;">remarks</h4></th>
     </tr>
   </thead>
   <tbody>
<?php

for($i=0 ; $i < $sizeof_material_metadata_recs ; $i++){
echo "<tr>";
echo "<td> Meta Field ".($i+1)."</td>";
echo "<td>".(isset($material_metadata[$i]) ? $material_metadata[$i]['meta_field'] : '')."</td>";
echo "<td>".(isset($material_metadata[$i]) ? $material_metadata[$i]['meta_value'] : '')."</td>";
echo "<td>".(isset($material_metadata[$i]) ? $material_metadata[$i]['remarks'] : '')."</td>";
echo "</tr>";

}
?>
   </tbody>
 </table>
</div>


      

    </div>
  <!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
  <!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->






<!--<div id="menu2" class="tab-pane fade">
      <h3>Menu 2</h3>
      <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
    </div>
    <div id="menu3" class="tab-pane fade">
      <h3>Menu 3</h3>
      <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
    </div> -->






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






/*                 $(function() {
    initDataTable('.table-materials',  admin_url + 'materials/table/mfspecs');
} );  */


            </script>
            </body>

            </html>

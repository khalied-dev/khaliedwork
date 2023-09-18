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

            echo form_open(/* $this->uri->uri_string()*/admin_url('materials/add/'), ['id' => 'materials_form', 'onsubmit' => 'return false;']); ?>
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
                                            <?php echo _l('Material\' Data'); ?>
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
                                <!-- <br> -->
                                <?php 
                                //$value = isset($material) ? $material->item_code : ''; 
                                echo render_input('item_code', 'item code', null); 
                                ?>
                            </div>

                            <div class="col-md-12">
                                <?php 
                                //$value = isset($material) ? $material->item_name : ''; 
                                echo render_input('item_name', 'item name', null); 
                                ?>
                            </div>

                            <div class="col-md-12">
                                <?php 
                                //$value = isset($material) ? $material->staff_id : ''; 
                                $value = get_staff_user_id();
                                //echo render_input('staff_id', 'staff id', $value); 
                                //form_hidden('staff_id', $value);
                                ?>
                                <input type="hidden" name="staff_id" value="<?= $value ?>" />
                            </div>

                            <div class="col-md-12">
                                    <div class="form-group">
                                        <p class="bold"><?php echo _l('remarks'); ?></p>

                                        <?php
                                        //$remarks = isset($material) ? $material->remarks : '';
                                        
                                        echo render_textarea('remarks', '', null, [], [], '', 'tinymce');
                                        ?>
                                    </div>
                            </div>

                            <div class="col-md-12">
                                <?php 
                                //$value = isset($material) ? $material->partner : ''; 
                                echo render_input('partner', 'Partner', null); 
                                ?>
                            </div>
                            
                            <div class="col-md-6">
                                <?php 
                                //$value = isset($material) ? $material->partner_item_code : ''; 
                                echo render_input('partner_item_code', 'Partner\' item code', null); 
                                ?>
                            </div>
                            
                            <div class="col-md-6">
                                <?php 
                                //$value = isset($material) ? $material->partner_item_name : ''; 
                                echo render_input('partner_item_name', 'Partner\' item name', null); 
                                ?>
                            </div>
                            
                            <div class="col-md-6">
                                <?php 
                                //$value = isset($material) ? $material->category_id : ''; 
                                echo render_input('category_id', 'Category ID', null); 
                                ?>
                            </div>

                            <div class="col-md-6">    
                                <?php
                                //$value = isset($material) ? $material->field_id : ''; 
                                echo render_input('field_id', 'Field id', null); 
                                ?>
                            </div>
                            
                            <div class="col-md-6">
                                <?php 
                                //$value = isset($material) ? $material->purchase_price : ''; 
                                echo render_input('purchase_price', 'Purchase price', null); 
                                ?>
                            </div>
                            
                            <div class="col-md-6">
                                <?php 
                                //$value = isset($material) ? $material->sell_price : ''; 
                                echo render_input('sell_price', 'Sell price', null); 
                                ?>
                            </div>
                            
                                <?php
                                //$this->load->helper('date'); 
                                //$value = isset($material) ? $material->datecreated : ''; 
                                //echo render_input('datecreated', 'Date created', $value);
                                //form_hidden('datecreated', $value); // Would produce: <input type="hidden" name="username" value="johndoe" />
                                ?>
                                <input type="hidden" name="datecreated" value="<?php echo date('Y-m-d H:i:s'); ?>" />
                                <!-- <div class="panel-footer text-right">
                                    <button type="submit" data-form="#costcenter_form" class="btn btn-primary"
                                        autocomplete="off" data-loading-text="<?php //echo _l('wait_text'); ?>">
                                        <?php //echo _l('submit'); ?>
                                    </button>
                                </div> -->
                            </div>
                        </div>
                        <?php //echo form_close(); ?>
                    </div>


                    
                    <div class="panel-footer text-right" style="background-color: white">
                                    <button id="submitter" onclick="to_decider(0)" type="submit" data-form="#costcenter_form" class="btn btn-primary"
                                        autocomplete="off" data-loading-text="<?php echo _l('wait_text'); ?>">
                                        <?php echo _l('submit'); ?>
                                    </button>
                    </div>














<div class="panel-body">
                        <div class="horizontal-scrollable-tabs panel-full-width-tabs">
                            <div class="scroller arrow-left"><i class="fa fa-angle-left"></i></div>
                            <div class="scroller arrow-right"><i class="fa fa-angle-right"></i></div>
                            <div class="horizontal-tabs">
                                <ul class="nav nav-tabs nav-tabs-horizontal" role="tablist">
                                    <li role="presentation" class="active">
                                        <a href="#tab_materials" aria-controls="tab_materials" role="tab"
                                            data-toggle="tab">
                                            <?php echo _l('Material\' Meta Data'); ?>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>


<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

<!-- /////Here Block Appended//////////////////////////////////////////////////////////////////////////////////// -->
<div class="tab-content tw-mt-3" id="metablock"></div>
<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

<div class="panel-footer text-right" style="background-color: white">
                                    <button type="button" data-form="#costcenter_form" class="btn btn-primary"
                                        autocomplete="off" data-loading-text="<?php echo _l('wait_text'); ?>"  onclick="add_metafield()">
                                        <?php echo _l('+ Add Meta field'); ?>
                                    </button>
</div>
<input type="hidden" id="sizeof_material_metadata_recs" name="sizeof_material_metadata_recs" value="0" />

<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////// -->








                            </div>
                        </div>






                        <?php echo form_close(); ?>
                    </div>




                </div>
            </div>









<!-- ///////Hidden Meta field' block//////////////////////////////////////////////////////////////////////////////////// -->


<!-- <div id="meta_element" class="tab-content tw-mt-3" style="display:none"> -->
<!-- <div id="meta_element" class="tab-content tw-mt-3" style="visibility:hidden">
    <div role="tabpanel" class="tab-pane active" id="tab_materials">

                            <div class="col-md-12">
                            <br>
                            <h4>Meta Field <span id="fieldno"></span> :</h4>
                            </div>
                            

                            <div class="col-md-6">
                                <br>
                                <?php 
                                ////$value = isset($material_metadata[$i]) ? $material_metadata[$i]['meta_field'] : ''; 
                                //echo render_input('meta_field_', 'Name'); 
                                ?>
                            </div>

                            <div class="col-md-6">
                                <br>
                                <?php 
                                ////$value = isset($material_metadata[$i]) ? $material_metadata[$i]['meta_value'] : ''; 
                                //echo render_input('meta_value_', 'Value'); 
                                ?>
                            </div>

                            <div class="col-md-12">
                                    <div class="form-group">
                                        <p class="bold"><?php //echo _l('remarks'); ?></p>

                                        <?php
                                        ////$remarks = isset($material_metadata[$i]) ? $material_metadata[$i]['remarks'] : '';
                                        ////echo render_textarea('remarks_', '', '', [], [], '', 'tinymce');
                                        ?>
                                        <textarea id="remarks_" name="remarks_" class="form-control" rows="4" ></textarea>
                                    </div>
                            </div>

                            <input type="hidden" id="dateadded_" name="dateadded_" value="<?php //date('Y-m-d H:i:s'); ?>" />

                                <div class="panel-footer text-right">
                                    <button type="button" style="visibility:hidden">
                                        <?php //echo _l(''); ?>
                                    </button>
                                </div>


    </div>
</div> -->
<!-- ///////finish Hidden block//////////////////////////////////////////////////////////////////////////////////// -->











            <?php init_tail(); ?>
            <script>

var counter = 0;



                <?php if (isset($costcenter)) { ?>
                //var original_materials_status = '<?php //echo $costcenter->status; ?>';
                <?php } ?>

                $(function() {

                 
                });






/* 
function to_decider(x){

//for(var i=0 ; i<=15000 ; i++)
//console.log("Looper" + i); 


if(x != 0){



//document.getElementById("isdeleted_"+x).value = "1";
//document.getElementById("materials_form").submit();

////----- here just do delete the block from DOM and (Don't => reduce the value of hidden field "sizeof_material_metadata_recs" ) -----////





}else{
   
document.getElementById("materials_form").submit();
}

} 
*/




function to_decider(x){

if(x != 0){


    if((document.getElementById("isjustadded_"+x).value) != '1'){ 
document.getElementById("isdeleted_"+x).value = "1";
document.getElementById("materials_form").submit();
}else{
    //////////////////////////////
    document.getElementById("metablock_"+x).style.display = "none";
    document.getElementById("is_to_take_in_mind_"+x).value = '0';
}


}else{
//console.log("to submit"+x);    
document.getElementById("materials_form").submit();
}

}






function add_metafield(){
//console.log("ksa");


$.ajax({
  method: "POST",
  url: admin_url+"materials/metadata_blockcloner/",
  data: { countr: counter }
}).done(function( response ) {
    $("#metablock").append(response)
    //console.log("counter is :"+counter);
    tinyMce_Creator();
  });

  //console.log("counter is :"+counter); 
  counter++;
document.getElementById("sizeof_material_metadata_recs").value = counter;






/* 
const node = document.getElementById("meta_element");
const clone = node.cloneNode(true);
//clone.style.display = "block";
clone.style.visibility = "visible";
document.getElementById("metablock").appendChild(clone);
document.getElementById("meta_field_").name = "meta_field_"+(counter+1);
document.getElementById("meta_value_").name = "meta_value_"+(counter+1);

document.getElementById("remarks_").name = "remarks_"+(counter+1);
document.getElementById("remarks_").id = "remarks_"+(counter+1);
tinyMce_Creator();

document.getElementById("dateadded_").name = "dateadded_"+(counter+1);
document.getElementById("fieldno").innerHTML = (counter+1);

counter++;
document.getElementById("sizeof_material_metadata_recs").value = counter;
*/



            }










function tinyMce_Creator(){

    var useDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;    
            tinymce.init({
                selector: "#remarks_"+(counter),
                plugins: 'print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
  imagetools_cors_hosts: ['picsum.photos'],
  menubar: 'file edit view insert format tools table help',
  toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
  toolbar_sticky: true,
  autosave_ask_before_unload: true,
  autosave_interval: '30s',
  autosave_prefix: '{path}{query}-{id}-',
  autosave_restore_when_empty: false,
  autosave_retention: '2m',
  image_advtab: true,
  link_list: [
    { title: 'My page 1', value: 'https://www.tiny.cloud' },
    { title: 'My page 2', value: 'http://www.moxiecode.com' }
  ],
  image_list: [
    { title: 'My page 1', value: 'https://www.tiny.cloud' },
    { title: 'My page 2', value: 'http://www.moxiecode.com' }
  ],
  image_class_list: [
    { title: 'None', value: '' },
    { title: 'Some class', value: 'class-name' }
  ],
  importcss_append: true,
  file_picker_callback: function (callback, value, meta) {
    /* Provide file and text for the link dialog */
    if (meta.filetype === 'file') {
      callback('https://www.google.com/logos/google.jpg', { text: 'My text' });
    }

    /* Provide image and alt text for the image dialog */
    if (meta.filetype === 'image') {
      callback('https://www.google.com/logos/google.jpg', { alt: 'My alt text' });
    }

    /* Provide alternative source and posted for the media dialog */
    if (meta.filetype === 'media') {
      callback('movie.mp4', { source2: 'alt.ogg', poster: 'https://www.google.com/logos/google.jpg' });
    }
  },
  templates: [
        { title: 'New Table', description: 'creates a new table', content: '<div class="mceTmpl"><table width="98%%"  border="0" cellspacing="0" cellpadding="0"><tr><th scope="col"> </th><th scope="col"> </th></tr><tr><td> </td><td> </td></tr></table></div>' },
    { title: 'Starting my story', description: 'A cure for writers block', content: 'Once upon a time...' },
    { title: 'New list with dates', description: 'New List with dates', content: '<div class="mceTmpl"><span class="cdate">cdate</span><br /><span class="mdate">mdate</span><h2>My List</h2><ul><li></li><li></li></ul></div>' }
  ],
  template_cdate_format: '[Date Created (CDATE): %m/%d/%Y : %H:%M:%S]',
  template_mdate_format: '[Date Modified (MDATE): %m/%d/%Y : %H:%M:%S]',
  height: 100,
  image_caption: true,
  quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
  noneditable_noneditable_class: 'mceNonEditable',
  toolbar_mode: 'sliding',
  contextmenu: 'link image imagetools table',
  skin: useDarkMode ? 'oxide-dark' : 'oxide',
  content_css: useDarkMode ? 'dark' : 'default',
  content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
            });

        }




            </script>
            </body>

            </html>

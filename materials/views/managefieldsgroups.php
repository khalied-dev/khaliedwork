<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
              <div class="tw-mb-2 sm:tw-mb-4">
                   <!--  <a href="#" onclick="new_material(); return false;" class="btn btn-primary"> -->
                   <a href="<?php echo admin_url(MATERIALS_FOLDER.'/add_metafields_groups/'); ?>" class="btn btn-primary">
                        <i class="fa-regular fa-plus tw-mr-1"></i>
                        <?php echo _l('New Group'); ?>
                    </a>
                </div>

                <div class="panel_s">
                    <div class="panel-body panel-table-full">
                        <?php render_datatable([
                    _l('id'),
                    _l('Group Name'),
                    _l('Group details'),
                ], 'materials_metafields_groups'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php init_tail(); ?>
<script>
$(function() {
    initDataTable('.table-materials_metafields_groups',  admin_url + 'materials/table_fields_groups');
} );    


function do_delete_metafields_groups(id){

    if(confirm("Delete this Group ? "))
    window.open(admin_url + "materials/delete_metafields_groups/"+id , "_parent");
    else
    window.open(admin_url + "materials/managefieldsgroups/"+id , "_parent");
    
}

</script>
</body>

</html>
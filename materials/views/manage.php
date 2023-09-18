<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
              <div class="tw-mb-2 sm:tw-mb-4">
                   <!--  <a href="#" onclick="new_material(); return false;" class="btn btn-primary"> -->
                   <a href="<?php echo admin_url(MATERIALS_FOLDER.'/add/'); ?>" class="btn btn-primary">
                        <i class="fa-regular fa-plus tw-mr-1"></i>
                        <?php echo _l('new_material'); ?>
                    </a>
                </div>

                <div class="panel_s">
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
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="department" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <?php echo form_open(admin_url('materials/material'), ['id' => 'material-form']); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    <span class="edit-title"><?php echo _l('edit_material'); ?></span>
                    <span class="add-title"><?php echo _l('new_material'); ?></span>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div id="additional"></div>
                        <!-- fake fields are a workaround for chrome autofill getting the wrong fields -->
                        <input type="text" class="fake-autofill-field" name="fakeusernameremembered" value=''
                            tabindex="-1" />
                        <input type="password" class="fake-autofill-field" name="fakepasswordremembered" value=''
                            tabindex="-1" />
                        <?php echo render_input('name', 'material_name'); ?>
                        <?php if (get_option('google_api_key') != '') { ?>
                        <?php echo render_input('calendar_id', 'department_calendar_id'); ?>
                        <?php } ?>
                        <div class="checkbox checkbox-primary">
                            <input type="checkbox" name="hidefromclient" id="hidefromclient">
                            <label for="hidefromclient"><?php echo _l('department_hide_from_client'); ?></label>
                        </div>
                        <hr />
                        <?php echo render_input('email', 'department_email', '', 'email'); ?>
                        <br />
                        <h4><?php echo _l('email_to_ticket_config'); ?></h4>
                        <br />
                        <i class="fa-regular fa-circle-question pull-left tw-mt-0.5 tw-mr-1" data-toggle="tooltip"
                            data-title="<?php echo _l('department_username_help'); ?>"></i>
                        <?php echo render_input('imap_username', 'department_username'); ?>
                        <?php echo render_input('host', 'dept_imap_host'); ?>
                        <?php echo render_input('password', 'dept_email_password', '', 'password'); ?>
                        <div class="form-group">
                            <label for="encryption"><?php echo _l('dept_encryption'); ?></label><br />
                            <div class="radio radio-primary radio-inline">
                                <input type="radio" name="encryption" value="tls" id="tls">
                                <label for="tls">TLS</label>
                            </div>
                            <div class="radio radio-primary radio-inline">
                                <input type="radio" name="encryption" value="ssl" id="ssl">
                                <label for="ssl">SSL</label>
                            </div>
                            <div class="radio radio-primary radio-inline">
                                <input type="radio" name="encryption" value="" id="no_enc" checked>
                                <label for="no_enc"><?php echo _l('dept_email_no_encryption'); ?></label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="folder" class="control-label">
                                <?php echo _l('imap_folder'); ?>
                                <a href="#" onclick="retrieve_imap_department_folders(); return false;">
                                    <i class="fa fa-refresh hidden" id="folders-loader"></i>
                                    <?php echo _l('retrieve_folders'); ?>
                                </a>
                            </label>
                            <select name="folder" class="form-control selectpicker" id="folder"></select>
                        </div>
                        <div class="form-group">
                            <div class="checkbox checkbox-primary">
                                <input type="checkbox" name="delete_after_import" id="delete_after_import">
                                <label for="delete_after_import"><?php echo _l('delete_mail_after_import'); ?>
                            </div>
                            <hr />
                            <button onclick="test_dep_imap_connection(); return false;"
                                class="btn btn-default"><?php echo _l('leads_email_integration_test_connection'); ?></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                <button type="submit" class="btn btn-primary"><?php echo _l('submit'); ?></button>
            </div>
        </div><!-- /.modal-content -->
        <?php echo form_close(); ?>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php init_tail(); ?>
<script>
$(function() {
    initDataTable('.table-materials',  admin_url + 'materials/table');
    
    
//     $('.table-materials thead tr')        .clone(true)
//         .addClass('filters')
//         .appendTo('.table-materials thead');
//             var table = $('.table-materials');
//             // table = $('.table-materials').DataTable();

//             table.DataTable().destroy()

// //     $('.table-materials').on( 'draw.dt', function () {
// //       if ( $.fn.dataTable.isDataTable( '.table-materials' ) ) {
    
// // }
// // else {
// //     table = $('.table-materials').DataTable( {
// //         paging: false
// //     } );
// //     alert('2');
// // }
  
//         var table = $(".table-materials").DataTable( {
//         orderCellsTop: true,
//         fixedHeader: true,
//         initComplete: function() {
//             var api = this.api();
//             // For each column
//             api.columns().eq(0).each(function(colIdx) {
//                 // Set the header cell to contain the input element
//                 var cell = $('.filters th').eq($(api.column(colIdx).header()).index());
//                 var title = $(cell).text();
//                 $(cell).html( '<input type="text" placeholder="'+title+'" />' );
//                 // On every keypress in this input
//                 $('input', $('.filters th').eq($(api.column(colIdx).header()).index()) )
//                     .off('keyup change')
//                     .on('keyup change', function (e) {
//                         e.stopPropagation();
//                         // Get the search value
//                         $(this).attr('title', $(this).val());
//                         var regexr = '({search})'; //$(this).parents('th').find('select').val();
//                         var cursorPosition = this.selectionStart;
//                         // Search the column for that value
//                         $(".table-materials").DataTable().column(colIdx).search('^' + $(this).val() + '$',true).draw()
//                         initDataTable('.table-materials',  admin_url + 'materials/table');

//                         // api
//                         //     .column(colIdx)
//                         //     .search((this.value != "") ? regexr.replace('{search}', '((('+this.value+')))') : "", this.value != "", this.value == "")
//                         //     .draw();
//                         // $(this).focus()[0].setSelectionRange(cursorPosition, cursorPosition);
//                     });
//             });
//         }
//     } );
} );    
</script>
</body>

</html>
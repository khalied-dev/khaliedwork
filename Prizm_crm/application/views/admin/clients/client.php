<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper" class="customer_profile">
    <div class="content">
        <div class="row">


            <div class="clearfix"></div>

            <?php if (isset($client)) { ?>
                <div class="col-md-3">
                    <?php $this->load->view('admin/clients/tabs'); ?>
                </div>
            <?php } ?>

            <div class="tw-mt-12 sm:tw-mt-0 <?php echo isset($client) ? 'col-md-9' : 'col-md-8 col-md-offset-2'; ?>">
                <div class="panel_s">
                    <div class="panel-body">
                        <?php if (isset($client)) { ?>
                            <?php echo form_hidden('isedit'); ?>
                            <?php echo form_hidden('userid', $client->userid); ?>
                            <div class="clearfix"></div>
                        <?php } ?>
                        <div>
                            <div class="tab-content">
                                <?php $this->load->view((isset($tab) ? $tab['view'] : 'admin/clients/groups/profile')); ?>
                            </div>
                        </div>
                    </div>
                    <?php if ($group == 'profile') { ?>
                        <div class="panel-footer text-right tw-space-x-1" id="profile-save-section">
                            <?php if (!isset($client)) { ?>
                                <button class="btn btn-default save-and-add-contact customer-form-submiter">
                                    <?php echo _l('save_customer_and_add_contact'); ?>
                                </button>
                            <?php } ?>
                            <button class="btn btn-primary only-save customer-form-submiter">
                                <?php echo _l('submit'); ?>
                            </button>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>

    </div>
</div>
<?php init_tail(); ?>
<?php if (isset($client)) { ?>
    <script>
        $(function() {
            init_rel_tasks_table(<?php echo $client->userid; ?>, 'customer');
        });
    </script>
<?php } ?>
<?php $this->load->view('admin/clients/client_js'); ?>
</body>

</html>
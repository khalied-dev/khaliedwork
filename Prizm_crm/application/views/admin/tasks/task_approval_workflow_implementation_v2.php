<?php
$task_id = $task->id;
// $task_id = 23;
$is_task_assigned_to_me = is_task_assigned_to_me($task_id);

$is_direct_manager_of_task_assign = get_direct_manager_of_task_assign($task_id);

$user_task_approval = is_user_task_approval($task_id);

$user_id =  get_staff_user_id();

$task_status_for_approval = task_status_for_approval($task_id);

$staff_id = "";
$staff_name = "";
$staff_profile_image = "";

?>
<!-- if user assinge -->

<!-- as approvel -->
<?php foreach (get_task_approval($task_id) as $approval) : ?>
    <?php
    if (isset($approval['staff'])) {
        $staff_id = $approval['staff']->staffid;
        $staff_name = $approval['staff']->firstname . " " . $approval['staff']->lastname;
        $staff_profile_image = $approval['staff']->profile_image;
    }
    ?>

    <?php if ($user_task_approval) : ?>
        <div style="margin-top: 20px;display: flex;align-items: center;flex-direction: row;" class="p-4 mx-3 col-md-12">
            <a href="http://localhost/prizm_ms/admin/profile/<?= $staff_id ?>">
                <img data-toggle="tooltip" data-title="<?= $staff_name ?>" src="http://localhost/prizm_ms/uploads/staff_profile_images/<?= $staff_id ?>/small_<?= $staff_profile_image   ?>" class="tw-h-7 tw-w-7 tw-inline-block tw-rounded-full tw-ring-2 tw-ring-white" data-original-title="<?= $staff_name ?>" title="<?= $staff_name ?>">
            </a>


            <?php if ($approval['approval_status'] == 1) : ?>
                <p class="no-margin pull-left">
                    <a href="#" class="btn btn-info mleft5 disabled" data-toggle="tooltip" data-title="<?php echo _l('Only the assigned person can Send to approval.'); ?>" onclick="Send_task_to_approval('approval',<?php echo $task->id ?>,2); return false;">
                        Send to approval
                    </a>
                </p>
            <?php elseif ($approval['approval_status'] == 2) : ?>
                <?php if ($approval['staff']->staffid == $user_id) : ?>
                    <p class="no-margin pull-left">
                        <a href="#" class="btn btn-success btn-approve mleft5" data-toggle="tooltip" data-title="<?php echo _l('approve'); ?>" onclick="Send_task_to_approval('approval',<?php echo $task->id ?>,3); return false;">
                            approve
                        </a>

                    </p>
                    <p class="no-margin pull-left">
                        <a href="#" class="btn btn-danger btn-reject mleft5" data-toggle="tooltip" data-title="<?php echo _l('reject'); ?>" onclick="Send_task_to_approval('approval',<?php echo $task->id ?>,4); return false;">
                            reject
                        </a>
                    </p>
                <?php else : ?>
                    <p class="no-margin pull-left">
                        <a href="#" class="btn btn-warning mleft5   " data-toggle="tooltip" data-title="<?php echo _l('Waiting Manager Approval'); ?>">
                            Waiting Manager Approval
                        </a>
                    </p>
                <?php endif; ?>
            <?php elseif ($approval['approval_status'] == 3) : ?>
                <p class="no-margin pull-left">
                    <a href="#" class="btn btn-success mleft5" data-toggle="tooltip" data-title="<?php echo _l('approved'); ?>">
                        approved
                    </a>
                </p>
            <?php elseif ($approval['approval_status'] == 4) : ?>
                <p class="no-margin pull-left">
                    <a href="#" class="btn btn-danger mleft5 disabled" data-toggle="tooltip" data-title="<?php echo _l('Only the assigned person can resubmit for approval.'); ?>">
                        Resubmit for Approval
                    </a>
                </p>



            <?php endif; ?>

        </div>
    <?php elseif ($is_task_assigned_to_me) : ?>

        <div style="margin-top: 20px;display: flex;align-items: center;flex-direction: row;" class="p-4 mx-3 col-md-12">
            <a href="http://localhost/prizm_ms/admin/profile/<?= $staff_id ?>">
                <img data-toggle="tooltip" data-title="<?= $staff_name ?>" src="http://localhost/prizm_ms/uploads/staff_profile_images/<?= $staff_id ?>/small_<?= $staff_profile_image   ?>" class="tw-h-7 tw-w-7 tw-inline-block tw-rounded-full tw-ring-2 tw-ring-white" data-original-title="<?= $staff_name ?>" title="<?= $staff_name ?>">
            </a>


            <?php if ($approval['approval_status'] == 1) : ?>
                <p class="no-margin pull-left">
                    <a href="#" class="btn btn-info mleft5" data-toggle="tooltip" data-title="<?php echo _l('Only the assigned person can Send to approval.'); ?>" onclick="Send_task_to_approval('assignees',<?php echo $task->id ?>,2,<?php echo $staff_id ?>); return false;">
                        Send to approval
                    </a>
                </p>
            <?php elseif ($approval['approval_status'] == 2) : ?>
                <p class="no-margin pull-left">
                    <a href="#" class="btn btn-warning mleft5   " data-toggle="tooltip" data-title="<?php echo _l('Waiting Manager Approval'); ?>">
                        Waiting Manager Approval
                    </a>
                </p>
            <?php elseif ($approval['approval_status'] == 3) : ?>
                <p class="no-margin pull-left">
                    <a href="#" class="btn btn-success mleft5" data-toggle="tooltip" data-title="<?php echo _l('approved'); ?>">
                        approved
                    </a>
                </p>
            <?php elseif ($approval['approval_status'] == 4) : ?>
                <p class="no-margin pull-left">
                    <a href="#" class="btn btn-danger mleft5" data-toggle="tooltip" data-title="<?php echo _l('Only the assigned person can resubmit for approval.'); ?>" onclick="Send_task_to_approval('assignees',<?php echo $task->id ?>,2,<?php echo $staff_id ?>); return false;">
                        Resubmit for Approval
                    </a>
                </p>



            <?php endif; ?>

        </div>
    <?php else : ?>
        <div style="margin-top: 20px;display: flex;align-items: center;flex-direction: row;" class="p-4 mx-3 col-md-12">
            <a href="http://localhost/prizm_ms/admin/profile/<?= $staff_id ?>">
                <img data-toggle="tooltip" data-title="<?= $staff_name ?>" src="http://localhost/prizm_ms/uploads/staff_profile_images/<?= $staff_id ?>/small_<?= $staff_profile_image   ?>" class="tw-h-7 tw-w-7 tw-inline-block tw-rounded-full tw-ring-2 tw-ring-white" data-original-title="<?= $staff_name ?>" title="<?= $staff_name ?>">
            </a>


            <?php if ($approval['approval_status'] == 1) : ?>
                <p class="no-margin pull-left">
                    <a href="#" class="btn btn-info mleft5 disabled" data-toggle="tooltip" data-title="<?php echo _l('Only the assigned person can Send to approval.'); ?>">
                        Send to approval
                    </a>
                </p>
            <?php elseif ($approval['approval_status'] == 2) : ?>
                <p class="no-margin pull-left">
                    <a href="#" class="btn btn-warning mleft5   " data-toggle="tooltip" data-title="<?php echo _l('Waiting Manager Approval'); ?>">
                        Waiting Manager Approval
                    </a>
                </p>
            <?php elseif ($approval['approval_status'] == 3) : ?>
                <p class="no-margin pull-left">
                    <a href="#" class="btn btn-success mleft5" data-toggle="tooltip" data-title="<?php echo _l('approved'); ?>">
                        approved
                    </a>
                </p>
            <?php elseif ($approval['approval_status'] == 4) : ?>
                <p class="no-margin pull-left">
                    <a href="#" class="btn btn-danger mleft5 disabled" data-toggle="tooltip" data-title="<?php echo _l('Only the assigned person can resubmit for approval.'); ?>">
                        Resubmit for Approval
                    </a>
                </p>



            <?php endif; ?>

        </div>
    <?php endif; ?>
<?php endforeach; ?>
<!-- end as approvel -->
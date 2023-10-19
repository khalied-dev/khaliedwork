<?php $is_task_assigned_to_me = is_task_assigned_to_me($task->id); ?>
<?php $is_direct_manager_of_task_assign = get_direct_manager_of_task_assign($task->id) ?>

<?php if ($is_task_assigned_to_me) : ?>
    <?php if ($task->approval_status == 1) : ?>
        <p class="no-margin pull-left">
            <a href="#" class="btn btn-info mleft5" data-toggle="tooltip" data-title="<?php echo _l('Send to approval'); ?>" onclick="Send_task_to_approval(<?php echo $task->id ?>,2); return false;">
                Send to approval
            </a>
        </p>
    <?php elseif ($task->approval_status == 2) : ?>
        <p class="no-margin pull-left">
            <a href="#" class="btn btn-warning mleft5" data-toggle="tooltip" data-title="<?php echo _l('Waiting Manager Approval'); ?>">
                Waiting Manager Approval
            </a>
        </p>
    <?php elseif ($task->approval_status == 3) : ?>
        <p class="no-margin pull-left">
            <a href="#" class="btn btn-success mleft5" data-toggle="tooltip" data-title="<?php echo _l('approved'); ?>">
                approved
            </a>
        </p>
    <?php elseif ($task->approval_status == 4) : ?>
        <p class="no-margin pull-left">
            <a href="#" class="btn btn-danger mleft5" data-toggle="tooltip" data-title="<?php echo _l('Resubmit for Approval'); ?>" onclick="Send_task_to_approval(<?php echo $task->id ?>,2); return false;">
                Resubmit for Approval
            </a>
        </p>

    <?php endif; ?>


<?php elseif ($is_direct_manager_of_task_assign) : ?>
    <?php if ($task->approval_status == 1) : ?>
        <p class="no-margin pull-left">
            <a href="#" class="btn btn-info mleft5 disabled" data-toggle="tooltip" data-title="<?php echo _l('Only the assigned person can Send to approval.'); ?>" onclick="Send_task_to_approval(<?php echo $task->id ?>,2); return false;">
                Send to approval
            </a>
        </p>
    <?php elseif ($task->approval_status == 2) : ?>
        <p class="no-margin pull-left">
            <a href="#" class="btn btn-success btn-approve mleft5" data-toggle="tooltip" data-title="<?php echo _l('approve'); ?>" onclick="Send_task_to_approval(<?php echo $task->id ?>,3); return false;">
                approve
            </a>

        </p>
        <p class="no-margin pull-left">
            <a href="#" class="btn btn-danger btn-reject mleft5" data-toggle="tooltip" data-title="<?php echo _l('reject'); ?>" onclick="Send_task_to_approval(<?php echo $task->id ?>,4); return false;">
                reject
            </a>
        </p>

    <?php elseif ($task->approval_status == 3) : ?>
        <p class="no-margin pull-left">
            <a href="#" class="btn btn-success mleft5" data-toggle="tooltip" data-title="<?php echo _l('approved'); ?>">
                approved
            </a>
        </p>
    <?php elseif ($task->approval_status == 4) : ?>
        <p class="no-margin pull-left">
            <a href="#" class="btn btn-danger mleft5 disabled" data-toggle="tooltip" data-title="<?php echo _l('Only the assigned person can resubmit for approval.'); ?>">
                Resubmit for Approval
            </a>
        </p>



    <?php endif; ?>
<?php else : ?>
    <?php if ($task->approval_status == 1) : ?>
        <p class="no-margin pull-left">
            <a href="#" class="btn btn-info mleft5 disabled" data-toggle="tooltip" data-title="<?php echo _l('Only the assigned person can Send to approval.'); ?>" onclick="Send_task_to_approval(<?php echo $task->id ?>,2); return false;">
                Send to approval
            </a>
        </p>
    <?php elseif ($task->approval_status == 2) : ?>
        <p class="no-margin pull-left">
            <a href="#" class="btn btn-warning mleft5   " data-toggle="tooltip" data-title="<?php echo _l('Waiting Manager Approval'); ?>">
                Waiting Manager Approval
            </a>
        </p>
    <?php elseif ($task->approval_status == 3) : ?>
        <p class="no-margin pull-left">
            <a href="#" class="btn btn-success mleft5 " data-toggle="tooltip" data-title="<?php echo _l('Approved'); ?>">
                approved
            </a>
        </p>
    <?php elseif ($task->approval_status == 4) : ?>
        <p class="no-margin pull-left">
            <a href="#" class="btn btn-danger mleft5 disabled" data-toggle="tooltip" data-title="<?php echo _l('Only the assigned person can resubmit for approval.'); ?>">
                Resubmit for Approval
            </a>
        </p>

    <?php endif; ?>
<?php endif; ?>
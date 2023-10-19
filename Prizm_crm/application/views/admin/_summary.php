<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<h4 class="tw-mt-0 tw-font-semibold tw-text-lg tw-flex tw-items-center">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
        class="tw-w-5 tw-h-5 tw-text-neutral-500 tw-mr-1.5">
        <path stroke-linecap="round" stroke-linejoin="round"
            d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
    </svg>

    <span>
        <?php echo _l('tasks_summary'); ?>
    </span>
</h4>
<div class="row">
<div class="_filters _hidden_inputs">

    <?php
    echo form_hidden('my_tasks');
    foreach ($task_statuses as $status) {
        $value = $status['id'];
        if ($status['filter_default'] == false && !$this->input->get('status')) {
            $value = '';
        } elseif ($this->input->get('task_status_<?=$status["id"]?>')) {
            $value = ($this->input->get('status') == $status['id'] ? $status['id'] : '');
        }
        // echo form_hidden('task_status_' . $status['id'], $value);
     
    
    foreach (tasks_summary_data((isset($rel_id) ? $rel_id : null), (isset($rel_type) ? $rel_type : null)) as $summary) { 
      if  ($summary['status_id']==$status['id'])
      { ?>
    <div class="col-md-2 col-xs-6 md:tw-border-r md:tw-border-solid md:tw-border-neutral-300 last:tw-border-r-0">
        <div class="tw-flex tw-items-center">
        <a href="#" data-cview="task_status_<?php echo $summary['status_id']; ?>"
                                        class="tw-text-neutral-600 hover:tw-opacity-70 tw-inline-flex tw-items-center"
                                        onclick="dt_custom_view_task('task_status_<?php echo  $status['id']; ?>','.table-tasks','task_status_<?php echo $status['id']; ?>',0); return false;">
                                      
            <span class="tw-font-semibold tw-mr-3 rtl:tw-ml-3 tw-text-lg">
                <?php echo $summary['total_tasks']; ?>
            </span>
            <span style="color:<?php echo $summary['color']; ?>">
                <?php echo $summary['name']; ?>
            </span>
        </div>
    </a>
        <p class="tw-text-sm tw-mb-0 tw-text-neutral-600">
            <?php echo _l('tasks_view_assigned_to_user'); ?>: <?php echo $summary['total_my_tasks']; ?>
        </p>
    </div>
    <?php }
    } 
    }
    ?>
</div>
</div>

<hr class="hr-panel-separator" />
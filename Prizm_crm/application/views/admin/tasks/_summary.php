<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<h4 style="margin-bottom:30px" class="tw-mt-0 tw-font-semibold tw-text-lg tw-flex tw-items-center">
    <svg style="color:#1C90FF" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
        class="tw-w-5 tw-h-5 tw-text-neutral-500 tw-mr-1.5">
        <path stroke-linecap="round" stroke-linejoin="round"
            d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
    </svg>

    <span style="font-size:24px; font-weight:bold; color:#1C90FF">
        <?php echo _l('tasks_summary'); ?>
    </span>
</h4>
<div class="row">
    <?php foreach (tasks_summary_data((isset($rel_id) ? $rel_id : null), (isset($rel_type) ? $rel_type : null)) as $summary) { ?>
    <div class="col-md-2 col-xs-6 md:tw-border-r md:tw-border-solid md:tw-border-neutral-300 last:tw-border-r-0" style="margin-bottom:30px">
        <div class="tw-flex tw-items-center" style="flex-direction:column; margin-bottom:5px">
            <span style="margin:auto;padding-bottom:5px;font-size:24px;color:<?php echo $summary['color']; ?>" class="tw-font-semibold tw-mr-3 rtl:tw-ml-3 tw-text-lg">
                <?php echo $summary['total_tasks']; ?>
            </span>
            <span style="font-weight:bold;color:<?php echo $summary['color']; ?>">
                <?php echo $summary['name']; ?>
            </span>
        </div>
        <p style="margin:auto; color:#787878e8;font-size:12px; padding-left:15px" class="tw-text-sm tw-mb-0 tw-text-neutral-600">
            Assigned to me: <span style="color:<?php echo $summary['color']; ?>; font-weight:600; font-size:14px"> <?php echo $summary['total_my_tasks']; ?></span>
        </p>
    </div>
    <?php } ?>
</div>

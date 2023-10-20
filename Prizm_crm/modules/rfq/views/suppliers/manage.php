
<script>
</script>
<h4>Opportuntiy. : <?=$RFXNo?></h4>
<div id="tabs">
    <ul>
        <li><a href="#tabs-1">Issued</a></li>
        <li><a href="#tabs-2">Pending / Rejected</a></li>
        <li><a href="#tabs-3">Approved and Sent</a></li>
        <li><a href="#tabs-4">Received Qoutations</a></li>
    </ul>
    <div id="tabs-1">
        <div class=" layout-spacing">
            <div class="card card-outline rounded-0 shadow">
                <div class="card-header">
                    <h3 class="card-title">List of Inquiries</h3><br>
                    <div class="card-tools" style="float:left !important">
                        <div class="add-record-btn">
                            <a href="{{config('app.url')}}/RFQ_managerpage?id=<?=$RFXId?>&RFXNo=<?=$RFXNo?>&assigned_eng_uid=<?=$assigned_eng_uid?>"><span class="btn btn-sm btn-primary"><i class="fa fa-plus icon"></i>Add New</span></a>
                        </div>
                    </div>
            </div>
            <div class="card-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped" >
                                <!-- <colgroup>
                                    <col width="5%">
                                    <col width="20%">
                                    <col width="15%">
                                    <col width="25%">
                                    <col width="15%">
                                    <col width="10%">
                                    <col width="10%">
                                </colgroup> -->
                                <thead>
                                    <tr class="bg-navy disabled ">
                                        <th class="text-center">RFQ Id</th>
                                        <th class="text-center">RFX No.</th>
                                        <th class="text-center">Acceptance</th>
                                        <th class="text-center">Date Added</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        
                                    $i = 1;
                                    // if (Auth::user()->user_role_id==1)
                                        $RFQS = RFQ::where("RFXNo",$RFXNo)->get();
                                    // $sql ="sELECT  `id`, `RFXId`, `RFXNo`, `Acceptance`, `note`, `created_at`, `status` from rfq_list where RFXNo=$RFXNo ";
                                    // else
                                    //     $RFQS = RFQ::where("RFXNo",$RFXNo)->where("assigned_eng_uid",Auth::user()->user_id)->get();

                                    // $sql ="sELECT  `id`, `RFXId`, `RFXNo`, `Acceptance`, `note`, `created_at`, `status` from rfq_list where RFXNo=$RFXNo and assigned_eng_uid=".$_SESSION['login_id']." ";
                                    
                                    
                                    foreach($RFQS as $RFQ)
                                    {
                                    ?>
                                    <tr>
                                        <td class="text-center"><?php echo $RFQ->id ?></td>
                                        <td class="text-center"><a href="{{config('app.url')}}/RFQ_managerpage?id=<?=$RFXId?>&RFQId=<?=$RFQ->id?>&RFXNo=<?=$RFXNo?>&assigned_eng_uid=<?=$assigned_eng_uid?>"
                                                    data-id="<?php echo $RFQ->id ?>"><?php echo $RFQ->RFXNo ?></td>
                                        <td class="text-center"><span class="badge <?php 
                                            switch ($RFQ->Acceptance) {
                                                case "Accepted":
                                                    echo  "badge-success";
                                                break;
                                                case "Rejected":
                                                    echo "badge-danger ";
                                                break;
                                                default:
                                                echo  "badge-secondary";
                                                break; 
                                                }?>" ><?php echo $RFQ->Acceptance ?></span></td>
                                        <td class="text-center"><?php echo date("Y-m-d H:i",strtotime($RFQ->created_at)) ?></td>
                                        <td class="text-center">
                                            <?php if($RFQ->status == 1): ?>
                                            <span class="badge badge-success px-3 rounded-pill">Active</span>
                                            <?php else: ?>
                                            <span class="badge badge-danger px-3 rounded-pill">Inactive</span>
                                            <?php endif; ?>
                                        </td>
                                        
                                        <td align="center">
                                        
                                                    <a class="dropdown-item" href="{{config('app.url')}}/RFQViewpage?id=<?=$RFXId?>&RFQId=<?=$RFQ->id?>&RFXNo=<?=$RFXNo?>&assigned_eng_uid=<?=$assigned_eng_uid?>"
                                                    data-id="<?php //echo $RFQ->id'] ?>"><span class="fa fa-eye text-dark"></span>
                                                    View</a>
                                                    <!-- <a class="dropdown-item" href="{{config('app.url')}}/RFQ_manager?id=<?=$RFXId?>&RFQId=<?=$RFQ->id?>&RFXNo=<?=$RFXNo?>"
                                                    data-id="<?php //echo $RFQ->id'] ?>"><span class="fa fa-trash text-danger"></span>
                                                    Delete</a> -->
                                            <!-- <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon"
                                                data-toggle="dropdown">
                                                Action
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu" role="menu">
                                                <a class="dropdown-item view_data" href="javascript:void(0)"
                                                    data-id="<?php //echo $RFQ->id'] ?>"><span class="fa fa-eye text-dark"></span>
                                                    View</a>
                                                <div class="dropdown-divider"></div>
                                                
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item delete_data" href="javascript:void(0)"
                                                    data-id="<?php //echo $RFQ->id'] ?>"><span class="fa fa-trash text-danger"></span>
                                                    Delete</a>
                                            </div>-->
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
    <div id="tabs-2">
        <div class="layout-spacing">
            <div class="card card-outline rounded-0 shadow">
                <div class="card-header">
                    <h3 class="card-title">Pending / Rejected Inquiries</h3><br>
                    <div class="card-tools" style="float:left !important">
                    </div>
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped" >
                                    <!-- <colgroup>
                                        <col width="5%">
                                        <col width="20%">
                                        <col width="15%">
                                        <col width="25%">
                                        <col width="15%">
                                        <col width="10%">
                                        <col width="10%">
                                    </colgroup> -->
                                    <thead>
                                        <tr class="bg-navy disabled"> 
                                            
                                            <th>RFQ Id</th>
                                            <th>RFX No.</th>
                                            <th>Acceptance</th>
                                            <th>Date Added</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            
                                        $i = 1;
                                        // if (Auth::user()->user_role_id==1)
                                        $RFQs= RFQ::where('RFXNo',$RFXNo)->whereIn('acceptance',['Pending',null,'','Rejected'])->get();
                                        // $sql ="sELECT  `id`, `RFXId`, `RFXNo`, `Acceptance`, `note`, `created_at`, `status` from rfq_list
                                        // where RFXNo=$RFXNo and `acceptance` in ('Pending',null,'','Rejected')";
                                        // else
                                        // $RFQs= RFQ::where('RFXNo',$RFXNo)->
                                        //             where('assigned_eng_uid',Auth::user()->user_id)->whereIn('acceptance',['Pending',null,'','Rejected'])->get();

                                        //    $sql ="sELECT  `id`, `RFXId`, `RFXNo`, `Acceptance`, `note`, `created_at`, `status` from rfq_list
                                        // where RFXNo=$RFXNo and `acceptance` in ('Pending',null,'','Rejected') and assigned_eng_uid=".$_SESSION['login_id']."";
                                        
                                            foreach($RFQs as $RFQ){
                                        ?>
                                        <tr>
                                    
                                            <td class="text-center"><?php echo $RFQ->id ?></td>
                                            <td class="text-center"><a href="{{config('app.url')}}/RFQ_managerpage?id=<?=$RFXId?>&RFQId=<?=$RFQ->id?>&RFXNo=<?=$RFXNo?>&assigned_eng_uid=<?=$assigned_eng_uid?>"
                                                        data-id="<?php echo $RFQ->id ?>"><?php echo $RFQ->RFXNo ?></td>
                                            <td class="text-center"><span class="badge <?php 
                                                switch ($RFQ->Acceptance) {
                                                    case "Accepted":
                                                        echo  "badge-success";
                                                    break;
                                                    case "Rejected":
                                                        echo "badge-danger ";
                                                    break;
                                                    default:
                                                    echo  "badge-secondary";
                                                    break; 
                                                    }?>" ><?php echo $RFQ->Acceptance ?></span></td>
                                            <td class="text-center"><?php echo date("Y-m-d H:i",strtotime($RFQ->created_at)) ?></td>
                                            <td class="text-center">
                                                <?php if($RFQ->status == 1): ?>
                                                <span class="badge badge-success px-3 rounded-pill">Active</span>
                                                <?php else: ?>
                                                <span class="badge badge-danger px-3 rounded-pill">Inactive</span>
                                                <?php endif; ?>
                                            </td>
                                            
                                            <td align="center">
                                            <a class="dropdown-item" href="{{config('app.url')}}/RFQ_managerpage?id=<?=$RFXId?>&RFQId=<?=$RFQ->id?>&RFXNo=<?=$RFXNo?>&assigned_eng_uid=<?=$assigned_eng_uid?>"
                                                        data-id="<?php echo $RFQ->id ?>"><span class="fa fa-edit text-primary"></span>
                                                        Edit</a> 
                                                        <a class="dropdown-item" href="{{config('app.url')}}/RFQViewpage?id=<?=$RFXId?>&RFQId=<?=$RFQ->id?>&RFXNo=<?=$RFXNo?>"
                                                        data-id="<?php //echo $RFQ->id ?>"><span class="fa fa-eye text-dark"></span>
                                                        View</a>
                                                        <!-- <a class="dropdown-item" href="{{config('app.url')}}/RFQ_manager?id=<?=$RFXId?>&RFQId=<?=$RFQ->id?>&RFXNo=<?=$RFXNo?>"
                                                        data-id="<?php //echo $RFQ->id ?>"><span class="fa fa-trash text-danger"></span>
                                                        Delete</a> -->
                                                <!-- <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon"
                                                    data-toggle="dropdown">
                                                    Action
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu" role="menu">
                                                    <a class="dropdown-item view_data" href="javascript:void(0)"
                                                        data-id="<?php //echo $RFQ->id'] ?>"><span class="fa fa-eye text-dark"></span>
                                                        View</a>
                                                    <div class="dropdown-divider"></div>
                                                    
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item delete_data" href="javascript:void(0)"
                                                        data-id="<?php //echo $RFQ->id'] ?>"><span class="fa fa-trash text-danger"></span>
                                                        Delete</a>
                                                </div>-->
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="tabs-3">
        <div class="layout-spacing">
            <div class="card card-outline  rounded-0 shadow">
                <div class="card-header">
                    <h3 class="card-title">Approved & Sent Inquiries</h3><br>
                    <div class="card-tools" style="float:left !important">
                    </div>
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped" >
                                    <!-- <colgroup>
                                        <col width="5%">
                                        <col width="20%">
                                        <col width="15%">
                                        <col width="25%">
                                        <col width="15%">
                                        <col width="10%">
                                        <col width="10%">
                                    </colgroup> -->
                                    <thead>
                                        <tr class="bg-navy disabled"> 
                                            
                                            <th>RFQ Id</th>
                                            <th>RFX No.</th>
                                            <th>Acceptance</th>
                                            <th>Date Added</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            
                                        $i = 1;
                                        // if (Auth::user()->user_role_id==1)
                                        $RFQS = RFQ::where("RFXNo",$RFXNo)->whereIn("acceptance",['accepted'])->get();
                                        // $sql="sELECT  `id`, `RFXId`, `RFXNo`, `Acceptance`, `note`, `created_at`, `status` from rfq_list
                                        // where RFXNo=$RFXNo and `acceptance` in ('accepted') ";
                                        // else
                                        // $RFQS = RFQ::where("RFXNo",$RFXNo)->where("assigned_eng_uid",Auth::user()->user_id)->whereIn("acceptance",['accepted'])->get();

                                        // $sql ="sELECT  `id`, `RFXId`, `RFXNo`, `Acceptance`, `note`, `created_at`, `status` from rfq_list
                                        //             where RFXNo=$RFXNo and `acceptance` in ('accepted') and assigned_eng_uid=".$_SESSION['login_id']."";
                                            foreach($RFQS as $RFQ){
                                                //$RFQList=$RFQ->VehicleLicense'] ;
                                        ?>
                                        <tr>
                                    
                                            <td class="text-center"><?php echo $RFQ->id ?></td>
                                            <td class="text-center"><a href="{{config('app.url')}}/RFQ_managerpage?id=<?=$RFXId?>&RFQId=<?=$RFQ->id?>&RFXNo=<?=$RFXNo?>&assigned_eng_uid=<?=$assigned_eng_uid?>"
                                                        data-id="<?php echo $RFQ->id ?>"><?php echo $RFQ->RFXNo ?></td>
                                            <td class="text-center"><span class="badge <?php 
                                                switch ($RFQ->Acceptance) {
                                                    case "Accepted":
                                                        echo  "badge-success";
                                                    break;
                                                    case "Rejected":
                                                        echo "badge-danger ";
                                                    break;
                                                    default:
                                                    echo  "badge-secondary";
                                                    break; 
                                                    }?>" ><?php echo $RFQ->Acceptance ?></span></td>
                                            <td class="text-center"><?php echo date("Y-m-d H:i",strtotime($RFQ->created_at)) ?></td>
                                            <td class="text-center">
                                                <?php if($RFQ->status == 1): ?>
                                                <span class="badge badge-success px-3 rounded-pill">Active</span>
                                                <?php else: ?>
                                                <span class="badge badge-danger px-3 rounded-pill">Inactive</span>
                                                <?php endif; ?>
                                            </td>
                                            
                                            <td align="center">
                                            <a class="dropdown-item" href="{{config('app.url')}}/RFQ_managerpage?id=<?=$RFXId?>&RFQId=<?=$RFQ->id?>&RFXNo=<?=$RFXNo?>&assigned_eng_uid=<?=$assigned_eng_uid?>"
                                                        data-id="<?php echo $RFQ->id ?>"><span class="fa fa-edit text-primary"></span>
                                                        Edit</a> 
                                                        <a class="dropdown-item" href="{{config('app.url')}}/RFQViewpage?id=<?=$RFXId?>&RFQId=<?=$RFQ->id?>&RFXNo=<?=$RFXNo?>"
                                                        data-id="<?php //echo $RFQ->id ?>"><span class="fa fa-eye text-dark"></span>
                                                        View</a>
                                                        <!-- <a class="dropdown-item" href="{{config('app.url')}}/RFQ_manager?id=<?=$RFXId?>&RFQId=<?=$RFQ->id?>&RFXNo=<?=$RFXNo?>"
                                                        data-id="<?php //echo $RFQ->id ?>"><span class="fa fa-trash text-danger"></span>
                                                        Delete</a> -->
                                                <!-- <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon"
                                                    data-toggle="dropdown">
                                                    Action
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu" role="menu">
                                                    <a class="dropdown-item view_data" href="javascript:void(0)"
                                                        data-id="<?php //echo $RFQ->id ?>"><span class="fa fa-eye text-dark"></span>
                                                        View</a>
                                                    <div class="dropdown-divider"></div>
                                                    
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item delete_data" href="javascript:void(0)"
                                                        data-id="<?php //echo $RFQ->id ?>"><span class="fa fa-trash text-danger"></span>
                                                        Delete</a>
                                                </div>-->
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="tabs-4">
        <div class="card card-outline card-primary">
        </div>
    </div>
</div>
</div>


		{{-- <div class="card-header">
			<h3 class="card-title">Suppliers' Recieved Emails </h3>
			<div class="card-tools">
				<!--<a href="javascript:void(0)" id="create_new" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>  Create New</a>-->
			</div>
		</div>
		<div class="card-body">
			<div class="container-fluid"> --}}








	<!--///////////////////////////////This part Filtering Results///////////////////////////////////////////////////////////////////////////-->
<?php

?>


{{-- 
<br />
<br /> --}}
	
	
<!--<div id="searchresults">	-->		
{{-- <form action="" method="get">
	<table class="table table-hover table-striped" style="width:100%">
					<colgroup>
                        <col width="5%">
						<col width="20%">
						<col width="15%">
						<col width="5%">
						<col width="8%">
						<col width="30%">
                        <col width="8%">
					</colgroup>
					<thead>
						<tr class="bg-navy disabled">
                            <th style="text-align:center;border: 5px solid #fffcfc;">#</th>
                            <th  style="text-align:center;border: 5px solid #fffcfc;">RFQ No.</th>
                            <!--<th style="text-align:center;border: 5px solid #fffcfc;">MailID</th>-->
							<th style="text-align:center;border: 5px solid #fffcfc;">From</th>
							<th style="text-align:center;border: 5px solid #fffcfc;">Supplier Name</th>
							<th style="text-align:center;border: 5px solid #fffcfc;">Subject</th>
							<th style="text-align:center;border: 5px solid #fffcfc;">Recieved at</th>
							<th style="text-align:center;border: 5px solid #fffcfc;">Content</th>
							<th style="text-align:center;border: 5px solid #fffcfc;">Attachments</th>
						</tr>
					</thead>
					<tbody id="searchresults"> --}}
	<?php
 
	
	// $counter = 1;
	
	// foreach($qr as $emailsTable){
	// 	//for(;$counter<10;){
    //         $RFQId=0;

    //         $position= strpos($emailsTable['subject'],'RFQ-22');
    //         if($position>-1)
    //         {
    //         $RFQId= (int)substr($emailsTable['subject'],((int)$position)+6,7);
    //         $result = $conn->query("select RFXNo  from rfq_list where id={$RFQId}");
    //         if ($result->num_rows>0)
    //         {
    //         $row = $result->fetch_assoc();
            
    //         if ($RFQ->RFXNo==$RFXNo)
    //         {

	?>	
					  {{-- <tr>
                            <td style="text-align:center;border: 5px solid #fffcfc;"><b><?php //echo $counter; ?></b></td>
                            <!--<td style="text-align:center;border: 5px solid #fffcfc;"><?php //echo $emailsTable['mailid']; ?></td>-->
							
                            
                            <td style="text-align:center;border: 5px solid #fffcfc;">
                            <?php
                            //  $position= strpos($emailsTable['subject'],'RFQ-22');
                            //         if($position>-1)
                            //         echo substr($emailsTable['subject'],(int)$position,12);
                            ?></td>
                            <td style="text-align:center;border: 5px solid #fffcfc;"><?php //echo $emailsTable['fromm']; ?></td>
							<td style="text-align:center;border: 5px solid #fffcfc;"><?php //echo $emailsTable['supplier_name']; ?></td>
							<td style="text-align:center;border: 5px solid #fffcfc;"><?php //echo $emailsTable['subject']; ?></td>
							<td style="text-align:center;border: 5px solid #fffcfc;"><?php //echo $emailsTable['datee']; ?></td>
							<td style="text-align:center;border: 5px solid #fffcfc;"><textarea disabled="disabled" style="height: 150px;width: 500px;"><?php //echo $emailsTable['boody']; ?></textarea></td>
							<td style="text-align:center;border: 5px solid #fffcfc;"> --}}
							<?php 
							// $tAttachments = explode(";",$emailsTable['attachments']);
							// $stopper = 0;
							
							// foreach($tAttachments as $Attch){
							// if($stopper == 1){	
							?>
                            
							{{-- <a class="dropdown-item open_external_file2" href="javascript:void(0)" data-filename="<?php //echo $Attch ?>" style="background:none;color:#212544;text-align:center;font-weight:500;border-radius: 4px;" ><span class='fa fa-edit'></span> <?php //echo $Attch ?></a> --}}

							<?php 
							// }
							// $stopper = 1;
							// } ?>
                            {{-- </td>
					  </tr> --}}
<?php 

// $counter++;
    //                     }
    //                     }
    //                     }
	// } 
?>
					{{-- </tbody>
	</table>
</form>  

 --}}

<?php

?>      
<script>

function openPopup(url)//w  w  w.  j  a  v a  2s .com
{
   var popup = window.open(url, "popup", "fullscreen");
  if (popup.outerWidth < screen.availWidth || popup.outerHeight < screen.availHeight)
  {
     popup.moveTo(0,0);
     popup.resizeTo(screen.availWidth, screen.availHeight);
  }
}

$(document).ready(function() {
    $( "#tabs" ).tabs();
    // $('#create_new').click(function() {
    //     uni_modal("Add New Gate Pass", "gatepass/manage_gatepass.php", 'large');
    // })
    $('.edit_data').click(function() {
        uni_modal("Edit Employee", "employees/manage_employee.php?id=" + $(this).attr('data-id'),
            'mid-large');
    })
    $('.view_data').click(function() {
        uni_modal("View Employee", "employees/view_employee.php?id=" + $(this).attr('data-id'));
    })
    $('.attachments_data').click(function() {
        uni_modal("View Employee", "employees/manage_attachments.php?id=" + $(this).attr('data-id'));
    })
    $('.delete_data').click(function() {
        _conf("Are you sure to delete this Employee permanently?", "delete_employee", [$(this).attr(
            'data-id')])
    })
    // $('.table').dataTable();
})  


</script>
@endsection
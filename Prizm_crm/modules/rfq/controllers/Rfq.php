<?php
defined('BASEPATH') or exit('No direct script access allowed');
use Dompdf\Dompdf;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PhpOffice\PhpSpreadsheet\IOFactory;

// define('POROJECTS_SECTION', '1');
// define('OPPORTUNITIES_SECTION', '2');
// define('ADMIN_SECTION', '3');

class rfq extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Rfq_model');
        $this->load->model('suppliers_model');
        $this->load->model('przpurchase/Supplier_model');
        $this->load->model('misc_model');
        $this->load->helper('date');
    }

    public function index()
    {
        close_setup_menu();
        $data['title'] = _l('rfq_list');
        $this->load->view('Rfq/manage',$data);
    }

    public function table()
    {
        $this->app->get_table_data(module_views_path('rfq', 'Rfq/table'));
    }




    //public function rfq($id = '', $fromEmail = 0, $isToUpdate = '', $isToDelete = '')
    //public function rfq($id = '', $fromEmail = 0, $isToDelete = '')
    public function rfq($id = '', $fromEmail = 0, $isdisabled = 0, $afteradd = '0')
    {
        if (!is_numeric($id)) {
            if ($this->input->post()) {
            // Do Add' Block    
                $dataa = $this->input->post();
                $toshowaccrej = $dataa['toshowaccrej'];
                unset($dataa['toshowaccrej']);
                $data['addeddid'] = $this->Rfq_model->add_RFQ($dataa);
                $data['toshowaccrej'] = $toshowaccrej=="1" ? "1" : "0";
                $isdisabled = $toshowaccrej=="1" ? "1" : "0";

                $data['afteradd'] = "1";

                ////$data['isdisabled'] = "1";
                //$this->load->view('rfq/Rfq/manage', $data);
                ////$this->session->set_flashdata('addeddid',$id);
                ////redirect(admin_url('rfq/'));
/*                 
                if(isset($data['addeddid'])){
                $data['id'] = $data['addeddid'];
                $data['rfqRow'] = $this->Rfq_model->get($data['addeddid']);
                $data['rfqTemplates'] = $this->Rfq_model->get_RFQTemplates($data['addeddid']);
                } 
*/
            }

            $data['members'] = $this->staff_model->get();
            $data['suppliers'] = /* isset($data['addeddid']) ? $this->suppliers_model->get_selected_rfq_supplier($data['addeddid']) :  */$this->suppliers_model->get();
            $data['staff'] = /* isset($data['addeddid']) ? $this->Rfq_model->get_selected_rfq_staff($data['addeddid']) : */ $this->staff_model->get(['active = 1']);
            //// $data['id'] = $id;         
            $data['title'] = _l('rfq_list');
            $data['isdisabled'] = isset($data['isdisabled']) ? $data['isdisabled'] : $isdisabled;


        }else{ 
            if($this->input->post()){
            // Do Update' Block
            $dataa = $this->input->post();
            $toshowaccrej = $dataa['toshowaccrej'];
            unset($dataa['toshowaccrej']);
            $id = $this->Rfq_model->update_RFQ($dataa);
            $data['toshowaccrej'] = $toshowaccrej=="1" ? "1" : "0";
            $isdisabled = $toshowaccrej=="1" ? "1" : "0";
            //$this->load->view('rfq/Rfq/manage',$data);
            ////$this->session->set_flashdata('updatedid',$id);
            ////redirect(admin_url('rfq/'));
             }
            $data['rfqRow'] = $this->Rfq_model->get($id);
            $data['rfqTemplates'] = $this->Rfq_model->get_RFQTemplates($id);
            $data['suppliers'] = $this->suppliers_model->get_selected_rfq_supplier($id);
            $data['staff'] = $this->Rfq_model->get_selected_rfq_staff($id);
            $data['members'] = $this->staff_model->get();
            $data['id'] = $id;
            $data['isdisabled'] = $isdisabled;//"0";

            $data['toshowaccrej'] = $afteradd=="1" ? "1" : (isset($data['toshowaccrej']) ? $data['toshowaccrej'] : "0");
            $data['afteradd'] = ($afteradd=="1"/*  && $isdisabled==0 */) ? "0" : /* "1" */($data['toshowaccrej']=="1" ? "0" : "1");

            //$data['updateddid'] = isset($data['updateddid']) ? $data['updateddid'] : "";
            //$this->session->set_flashdata('updateddid',$id);
            //redirect(admin_url('rfq/'));

/* 
if($isToDelete == '1' || $isToDelete == 1){
close_setup_menu();
$data['deleteddid'] = $this->Rfq_model->delete_RFQ($data);
$data['title'] = _l('rfq_list');
$this->load->view('rfq/Rfq/manage',$data);
//$this->session->set_flashdata('deleteddid',$id);
//redirect(admin_url('rfq/'));
}
 */
        }


        $data['title'] = _l('rfq');
        $data['opportunitiess'] = $this->misc_model->get_advanceleads_statuses2();


        //$data['PreviewEmail'] = $this->send_inquery($id, 2);
        //$data['SupplierInquiriesFolderPath'] = module_dir_path(rfq_MODULE_NAME,"media/buffers/SupplierInquiries/");
        $data['viewTheEmailPath'] = base_url("rfq/rfq/rfq/".$id."/2/");//module_dir_path(rfq_MODULE_NAME,"rfq/Rfq/".$id."/2/");
        if($fromEmail != 0 && $fromEmail != ''){
            if($fromEmail == 1 || $fromEmail == '1'){
            $data['html'] = $this->send_inquery($id, 1);
            $this->load->view('rfq/Rfq/viewFromEmail', $data);
            }else if($fromEmail == 2 || $fromEmail == '2'){
            $data['PreviewEmail'] = $this->send_inquery($id, 2);
            $this->load->view('rfq/Rfq/viewTheEmail', $data);
            }
        }
        else{
        if(!isset($data['addeddid']))
        $this->load->view('rfq/Rfq/rfq', $data);
        else/* {
        echo $data['afteradd'];
        exit(0);
        } */
        redirect(admin_url('rfq/rfq/rfq/'.$data['addeddid']."/0/1/".$data['afteradd']."/"));
        }
        // $this->load->view(module_views_path('rfq','RFQ/rfq', $data));
    }










    public function delete($id){
            $data['id'] = $id ;
            close_setup_menu();
            $data['deleteddid'] = $this->Rfq_model->delete_RFQ($data);
            $data['title'] = _l('rfq_list');
            //$this->load->view('rfq/Rfq/manage',$data);
            $this->session->set_flashdata('deleteddid',$id);
            redirect(admin_url('rfq/'));
    }












public function livesearch(){

    $q=$_POST['searchkey'];
    $theTable=$_POST['thetable'];
    $hint="";

$matchedSuppliers_ids = [];
$matchedSuppliers_company = [];   
$matchedSuppliers_tittle = [];   
$matchedSuppliers = []; 
$matchedSuppliers_lastname = []; 
$matchedSuppliers_email = []; 
$matchedSuppliers_keywords = [];




if($theTable == 'suppliers')
$x = $this->suppliers_model->get('',$q,1);
else if($theTable == 'stuff')  
$x = $this->Rfq_model->get_selected_rfq_staff('',$q,1);  


    if (strlen($q)>0) {

      foreach($x as $names) {


if($theTable == "suppliers"){

array_push($matchedSuppliers_ids, $names['id']);
array_push($matchedSuppliers_company, $names['company']);
array_push($matchedSuppliers_tittle, $names['title']);
array_push($matchedSuppliers, $names['firstname']);
array_push($matchedSuppliers_lastname, $names['lastname']);
array_push($matchedSuppliers_email, $names['email']);
array_push($matchedSuppliers_keywords, $names['keywords']);
$resultedRow = "";
//$resultedRow = "<tr>
//<td>
//   <input
//        id='cbb".$names['id']."'
//        type='checkbox' 
//        value='". $names['id'] ."'
//        name='SupplierList_aftsrch[]' onchange='additifnotexist(\"". $names['id'] ."\", \"".$names['company']."\", \"".$names['title']."\", \"".$names['firstname']."\", \"".$names['lastname']."\", \"".$names['email']."\", \"".$names['keywords']."\")'/>
//</td>
//<td>
//    ".$names['company']."<br>
//    ".$names['title'] ." " .$names['firstname']." ".$names['lastname']."
//</td>
//<td>
//    ". $names['email']."
//</td>
//<td>
//    <span class='addReadMore showlesscontent'>
//        ".$names['keywords']."
//    </span>
//</td>
//</tr>";
}else if($theTable == "stuff"){
    $resultedRow = "<tr>
    <td><input 
            class='tblEmailCCUsersSearchResults'
            id='cbbb".$names['staffid']."'
            value='". $names['staffid'] ."'
            type='checkbox'
            name='EmailCCUsersList[". $names['staffid'] ."]' onchange='additifnotexist(\"". $names['staffid'] ."\", \"\" , \"\", \"".$names['firstname']."\", \"".$names['lastname']."\", \"".$names['email']."\",\"\")'/>
    <td>". $names['firstname'] . "  " . $names['lastname'] ."</td>
    <td>".  $names['email'] ."</td>
</tr>";
}



            if ($hint=="") {
              $hint=$resultedRow;
            } else {
              $hint .= $resultedRow;
            }
      }



    }



if($theTable == "stuff"){
    if ($hint=="") {
      $response=""; //"No suggestions..";
    } else {
      $response=$hint;
    }
    
    //output the response
    echo $response;
}else
 $response=json_encode([$matchedSuppliers_ids,$matchedSuppliers_company,$matchedSuppliers_tittle,$matchedSuppliers,$matchedSuppliers_lastname,$matchedSuppliers_email,$matchedSuppliers_keywords]);
echo $response;


}










public function addquicksupplier(){

    $firstname=$_POST['firstname'];
    $lastname=$_POST['lastname'];
    $company=$_POST['company'];
    $email=$_POST['email'];
    $phone=$_POST['phone'];
    $mobile=$_POST['mobile'];
    $keywords=$_POST['keywords'];

    $data = [
        'firstname' => $firstname,
        'lastname' => $lastname,
        'company' => $company,
        'email' => $email,
        'phone' => $phone,
        'mobile' => $mobile,
        'keywords' => $keywords
    ];

    $theaddedid = $this->Supplier_model->create_supplier_post($data);


if (is_numeric($theaddedid) && $theaddedid != "") {
    $resp['status'] = 'success';
    $resp['success'] = true;
    $resp['theaddedid'] = $theaddedid;
    echo json_encode($resp);
} else {
    $resp['status'] = 'failed';
    $resp['success'] = false;
    echo json_encode($resp);
}


}











    public function add_report(Request $request)
    {
        $report = new Report();
        $report->project_id = $request->input('project_id');

        $project = Project::where('project_id', $report->project_id)->first();
        $project_code = filter_var($project->project_code, FILTER_SANITIZE_NUMBER_INT);
        $report->report_code = 'PED-' . $project_code . '-DSR-' . date('ymd');
        $report->outstanding_issues = $request->input('outstanding_issues');
        $report->Suggestions = $request->input('suggestions');
        $report->scope_description = $request->input('scope_description');
        $report->company_approval = $request->input('project_id');
        $report->company_approval = 'Pending Approval';
        $report->client_approval = 'Pending Approval';
        $report->client_id = 1;
        $report->user_id = 1;
        $report->report_date = $request->input('report_date');
        $report->Status = 1;
        $report->save();

        $ClientCCContacts = [];
        $ClientContacts = [];
        $EmailCCUsersList = [];
        if (isset($request->ClientCCContacts)) {
            $ClientCCContacts = $request->input('ClientCCContacts');
        }
        if (isset($request->ClientCCContacts)) {
            $ClientContacts = $request->input('ClientContacts');
        }
        if (isset($request->ClientCCContacts)) {
            $EmailCCUsersList = $request->input('EmailCCUsersList');
        }
        $locationslist = $request->input('locationslist');
        $work_donelist = $request->input('work_donelist');
        $work_to_be_donelist = $request->input('work_to_be_donelist');
        $CCList = array_merge($EmailCCUsersList, $ClientCCContacts);
        // dd($locationslist);
        foreach ($locationslist as $key => $value) {
            $report_details = new Report_Details();
            $report_details->report_id = $report->report_id;
            $report_details->location = $value;
            $report_details->work_done = $work_donelist[$key];
            $report_details->work_to_be_done = $work_to_be_donelist[$key];
            $report_details->save();
        }

        $html = '';
        $html .= '<!DOCTYPE html>';
        $html .= '<html>';
        $html .= '<head>';
        $html .= "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>";
        $html .= '<style></style>';
        $html .= '</head><body>';
        $Header = "<div class='row' >";
        $Header .= "<div class='col-lg-4' style='float:right'>";
        $Header .= '</div>';
        $Header .= "<div class='col-lg-8' style='border-bottom: 2px solid #000;height:65px;z-index:1'>";
        $Header .= "<img src='data:image/png;base64,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' style='margin-top:20px;width:110px;float:left;z-index:auto'/>";
        $Header .= '</div>';
        $Header .= '</div>';
        $Header .= "<div class='row' >";
        $Header .= "<div class='col-lg-12' style='text-align: right;margin-top:-40px'>";
        $Header .= '<h3>Daily Status Report</h3>';
        $Header .= '</div>';
        $Header .= '</div>';
        $html .= '<br />';
        $html .= '<div>';
        $html .= "<table  style='width:90%;  font-family: Arial, Helvetica, sans-serif;border-collapse: collapse;width: 100%;' id='tblItems'>";
        $html .= '</colgroup>';
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= "<th style='border: 1px solid #000;width:20%;padding: 5px;font-size:12px;text-align: left;background-color: #ededed;color: black;'>Project Name</th>";
        $html .= "<td style='border: 1px solid #000;width:30%;padding: 5px;font-size:12px;text-align: left;background-color: #ededed;color: black;'>" . $project->title . '</th>';
        $html .= "<th style='border: 1px solid #000;width:15%;padding: 5px;font-size:12px;text-align: left;background-color: #ededed;color: black;'>PE Project No.</th>";
        $html .= "<td style='border: 1px solid #000;width:35%;padding: 5px;font-size:12px;text-align: left;background-color: #ededed;color: black;'>" . $project->project_code . '</th>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= "<th style='border: 1px solid #000;width:20%;padding: 5px;font-size:12px;text-align: left;background-color: #ededed;color: black;'>Client PO No</th>";
        $html .= "<td style='border: 1px solid #000;width:30%;padding: 5px;font-size:12px;text-align: left;background-color: #ededed;color: black;'></td>";
        $html .= "<th style='border: 1px solid #000;width:15%;padding: 5px;font-size:12px;text-align: left;background-color: #ededed;color: black;'>Report Date</th>";
        $report_date = new \DateTime($report->report_date);
        $html .= "<td style='border: 1px solid #000;width:35%;padding: 5px;font-size:12px;text-align: left;background-color: #ededed;color: black;'>" . date_format($report_date, 'd-F, Y') . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= "<th style='border: 1px solid #000;width:20%;padding: 5px;font-size:12px;text-align: left;background-color: #ededed;color: black;'>Scope Description</th>";
        $html .= "<td style='border: 1px solid #000;width:30%;padding: 5px;font-size:12px;text-align: left;background-color: #ededed;color: black;'>$report->scope_description</td>";
        $html .= "<th style='border: 1px solid #000;width:15%;padding: 5px;font-size:12px;text-align: left;background-color: #ededed;color: black;'>Report No.</th>";
        $html .= "<td style='border: 1px solid #000;width:35%;padding: 5px;font-size:12px;text-align: left;background-color: #ededed;color: black;'>$report->report_code</td>";
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '</table>';
        $html .= '<br />';
        $html .= '<br />';
        $html .= "<table  style='width:90%;  margin-left: auto;margin-right: auto; font-family: Arial, Helvetica, sans-serif;border-collapse: collapse;width: 100%;' id='tblItems'>";
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= "<th style='border: 1px solid #000;width:50px;padding-top: 5px;padding-bottom: 5px;font-size:12px;text-align: center;background-color: #d5dce4;color: black;'>Location</th>";
        $html .= "<th style='border: 1px solid #000;width:100px;padding-top: 5px;padding-bottom: 5px;font-size:12px;text-align: center;background-color: #d5dce4;color: black;'>Work Done</th>";
        $html .= "<th style='border: 1px solid #000;width:100px;padding-top: 5px;padding-bottom: 5px;font-size:12px;text-align: center;background-color: #d5dce4;color: black;'>Work to be Done</th>";
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';
        foreach ($locationslist as $key => $value) {
            $html .= '<tr>';
            $html .= "<th style='border: 1px solid #000;width:50px;padding-top: 5px;padding-bottom: 5px;font-size:12px;text-align: center;color: black;'>" . $value . '</td>';
            $html .= "<td style='border: 1px solid #000;width:100px;padding-top: 5px;padding-bottom: 5px;font-size:12px;text-align: center;color: black;'>" . $work_donelist[$key] . '</td>';
            $html .= "<th style='border: 1px solid #000;width:100px;padding-top: 5px;padding-bottom: 5px;font-size:12px;text-align: center;color: black;'>" . $work_to_be_donelist[$key] . '</th>';
            $html .= '</tr>';
        }
        $html .= '</tbody>';
        $html .= '</table>';

        $html .= "<br/><br/><br/><br/><br/><br/><br/><br/><div style='margin-bottom:50px'><span><h4>• Outstanding Issues</h4></span>";
        $html .= "<div style='padding:5px;border: 1px solid #000;height:100px;width:100%'>" . $report->outstanding_issues . '</div><br/>';
        $html .= '<br/><span><h4>• Suggestions</h4></span>';
        $html .= "<div style='padding:5px;border: 1px solid #000;height:100px;width:100%'>" . $report->Suggestions . '</div><br/><br/><br/><br/></div>';

        $html .= '</div>';

        $html .= '</body>';
        $html .= '</html>';
        $mpdf = new \Mpdf\Mpdf([
            'setAutoBottomMargin' => 'stretch',
            'setAutoTopMargin' => 'stretch',
        ]);

        $footer = "<table  style='width:90%;height:100px; font-family: Arial, Helvetica, sans-serif;border-collapse: collapse;width: 100%;' id='tblItems'>";
        $footer .= '<thead>';
        $footer .= '<tr>';
        $footer .= "<th style='border: 1px solid #000;height:100px;width:100px;padding:10px;font-size:12px;text-align: left;padding-top:5px;background-color: #ededed;color: black;'>Submitted By:<br/>" . Auth::user()->first_name . ' ' . Auth::user()->last_name . ' </th>';
        $footer .= "<td style='border: 1px solid #000;height:100px;width:100px;padding: 10px;font-size:12px;text-align: left;padding-top:5px;background-color: #ededed;color: black;'>Date:" . date_format($report_date, 'd-F, Y') . '</th>';
        $footer .= "<th style='border: 1px solid #000;height:100px;width:100px;padding: 10px;font-size:12px;text-align: left;padding-top:5px;background-color: #ededed;color: black;'>Approved By Client:
</th>";

        $footer .= '</tr>';
        $footer .= '</thead>';
        $footer .= '</table>';

        $mpdf->SetHeader($Header);
        $mpdf->SetFooter($footer);
        $mpdf->WriteHTML($html);
        $mpdf->Output($report->report_code . '.pdf', 'F');
        $Signature = '<br/><br/><br/><br/><br/>Regards,<br/>';
        $Signature .= '<hr />';
        $Signature .=
            "<img src='data:image/png;base64,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' style='margin-top:20px;width:90px;float:right;z-index:auto'/>";
        $Signature .= '<div><strong>Procurement Department</strong></div>';
        $Signature .= '<div><strong>Prizm Energy</strong></div>';
        $Signature .= "<div><strong>Tel:</strong> <a href='tel:+971 4 5896400'>+971 4 5896400</a></div>";
        $Signature .= "<div><strong>Email:</strong> <a href='mailto:Procurement@prizm-energy.com'>Procurement@prizm-energy.com</a></div>";
        $Signature .= '<div></div>';
        $Signature .= "<div><strong>Web:</strong> <a href='https://www.prizm-energy.com'>www.prizm-energy.com</a></div>";
        $Signature .= '<div>3707 Churchill Tower, Business Bay</div>';
        $Signature .= '<div>Dubai, UAE</div>';
        $Signature .= '<hr />';
        $Signature .= '<div>This message contains confidential information and is intended only for the intended recipients. If you are not an intended recipient you should not disseminate, distribute or copy this e-mail. Please notify us immediately by the e-mail if you have received this e-mail by mistake and delete this e-mail from your system. E-mail transmission cannot be guaranteed to be secure or error-free as information could be intercepted, corrupted, lost, destroyed, arrive late or incomplete, or contain viruses. Therefor we do not accept liability for any errors or omissions in the contents of this message, which arise as a result of e-mail transmission. If verification is required please request a hard-copy version.</div>';

        $filename = $report->report_code . '.pdf';
        $RFQFiles[] = $filename;
        //mail($receiver, $subject, $body, $headers)
        $Message =
            "Hello <br/>
 Please Find Attached the daily report for your project.<br/>
 
 <br/>
 " .
            $Signature .
            '';
        $ReplayEmail['name'] = Auth::user()->first_name . ' ' . Auth::user()->last_name;
        $ReplayEmail['email'] = Auth::user()->email;
        if ($this->SendMail($ClientContacts, 'Prizm Energy', 'Daily Status Report', $Message, $RFQFiles, $CCList, $ReplayEmail)) {
            $Success = true;
        } else {
            $Success = false;
        }
    }
    //Start send_inquery
    // Khalied Batran Sep 15th 2023
    public function send_inquery($id, $fromEmail = 0)
    {
        $Success = false;
        //Start Send Mail block
        $RFQId =$id;
        $company_logo = get_option('company_logo');
        $RFQ = $this->Rfq_model->get($RFQId);

        $EmailCCUsers = [];
        $RFQCCEmails = $this->Rfq_model->get_rfq_cc_emails($RFQId);
        foreach ($RFQCCEmails as $RFQCCEmail) {
            $staff_member =$this->staff_model->get($RFQCCEmail['staff_id']);
            $EmailCCUsers[] = ['email' => $staff_member->email , 'firstname' => $staff_member->firstname ,
             'lastname' => $staff_member->lastname ];
        }

        $RFQSuppliers = $this->suppliers_model->get_rfq_supplier($RFQId);

        $i = 1;
        $rfqTemplates = $this->Rfq_model->get_RFQTemplates($RFQId);
        $staff_member = $this->staff_model->get($RFQ->assigned_eng_staff_id);
        $Columns = [];
        $TemplateIndex = 1;
        $RFQFiles = [];

      //$imbededImagePath = 'uploads/company/fd1989935b085ada5b493ebe2778362d.jpg';
      //$imbededImagePath = base_url('uploads/company/' . $company_logo) ;
      $imbededImagePath = 'uploads/company/' . $company_logo ;


        $htmlforExcel = "";
        //foreach ($rfqTemplates as $TemplateRow) {
            $htmlhead = '';
            $htmlhead .= '<!DOCTYPE html>';
            $htmlhead .= '<html>';
            $htmlhead .= '<head>';
            $htmlhead .= "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>";
/*          $htmlhead .= "<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>";
            $htmlhead .= "<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>";
            $htmlhead .= "<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>"; 
*/
            $htmlhead .= '<style>
            * {
                -webkit-print-color-adjust: exact !important;   
                color-adjust: exact !important;                 
                print-color-adjust: exact !important;           
            }
            </style>';
            $htmlhead .= '</head><body>';

            $Injection1ForEmailView = $htmlhead;

            $html ="";
            $html .= $htmlhead."<div class='row' style='margin-top:70px'>";
            $Injection3ForEmailView = $html;


            $html .= "<div class='col-lg-4' style='float:right'>";
            $html .= '</div>';
            $html .= "<div class='col-lg-8' style='border-bottom: 2px solid #000;height:65px;z-index:1'>";
            //$html .= "<img src='" . base_url('uploads/company/' . $company_logo)."' style='margin-top:20px;width:90px;float:left;z-index:auto'/>";
            //$html .= "<img src='http://localhost/Prizm_crm/uploads/company/fd1989935b085ada5b493ebe2778362d.jpg' style='margin-top:20px;width:90px;float:left;z-index:auto'/>";
            //$html .= "<img src='".(  $fromEmail == 2 ? base_url($imbededImagePath) : "cid:logo_2prizm" )."' style='margin-top:20px;width:90px;float:left;z-index:auto'/>";
            $html .= "<img src='data:image/png;base64,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' style='margin-top:20px;width:90px;float:left;z-index:auto'/>";
            $html .= '</div>';
            $html .= '</div>';
            $html .= "<div class='row' >";
            $html .= "<div class='col-lg-12' style='text-align: center;margin-top:-50px'>";
            $html .= '<h4>REQUEST FOR QUOTATION</h4>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '<br/>';
            //$html .= $RFQ->note;
            ////$html .= "<div class='row' style='display: inline-flex; width:100%'>";
            ////$html .= "<div class='row' style='display: inline-flex; width:150px'>";
            ////$html .= "<div style='text-align:right; margin-right:10px;width:50%;margin-bottom:1px;margin-top:1px'>";
            ////$html .= "<span><h5 style='margin-bottom:3px;margin-top:3px'>Inquiry No: </h5></span>";
            ////$html .= "<span><h5 style='margin-bottom:3px;margin-top:3px' >Date: </h5></span>";
            ////$html .= "<span><h6 style='margin-bottom:3px;margin-top:3px'>Request No: </h6></span>";
            ////$html .= '</div>';
            ////$html .= "<div style='text-align:left; margin-left:110px;width:150%;height:30px;margin-bottom:1px;margin-top:-70px'>";
            ////$html .= "<span><h5 style='margin-bottom:3px;margin-top:3px'>  " .$RFQ->RFQ_code  . '</h5></span>';
            ////$html .= "<span><h5 style='margin-bottom:3px;margin-top:3px'>" . date('M d, y') . '</h5></span>';
            ////$html .= "<span><h6 style='margin-bottom:3px;margin-top:3px'>" . date('y') . str_pad($RFQId, 6, '0', STR_PAD_LEFT) . '-' . str_pad($TemplateIndex, 2, '0', STR_PAD_LEFT) . '</h6></span>';
            ////$html .= '</div>';
            ////$html .= '</div>';
            ////$html .= "<div class='row' style='float:right;display: inline-flex; width:300px'>";
            ////$html .= "<div style='text-align:right; margin-right:10px;width:150px;margin-bottom:1px;margin-top:1px'>";
            ////$html .= "<span><h5 style='margin-bottom:3px;margin-top:3px'>Requested By: </h5></span>";
            ////$html .= '</div>';
            ////$html .= "<div style='text-align:left; margin-left:160px;width:150px;height:30px;margin-bottom:1px;margin-top:-50px'>";
            ////$html .= "<span><h5 style='margin-bottom:3px;margin-top:3px'>" . $staff_member->firstname . ' ' . $staff_member->lastname . '</h5></span>';
            ////$html .= "<span><h5 style='margin-bottom:3px;margin-top:3px'></h5></span>"; 
            //// $html.= "<span><h6 style='margin-bottom:3px;margin-top:3px'>PR #22904701</h6></span>";
            ////$html .= '</div>';
            ////$html .= '</div>';
            ////$html .= '</div>';
            ////$html .= '</div>';
            $html .= '<br>';
            $html .= '<br>';
            $html .= '<br>';
            $html .= '<br>';



foreach ($rfqTemplates as $TemplateRow) {
            $html .= '<div>';
            $html .= "<table cellspacing='0' cellpadding='0' border='0' width='100%' style='width:100%'>";
            $htmlforExcel .= "<table>";

                                $stylechanger = "";
                                $html .= "<tr>";
                                $htmlforExcel .= "<tr>";

                                $html .= "<td width='5%' align='left' style='font-weight: 400;padding: 10px;text-aligh:center;font-size: 0.7rem;font-family: Inter,sans-serif;border: 1px solid #e2e8f0;width:5%;background:#f1f5f9'>#</td>";
                                $htmlforExcel .= "<td>#</td>";

                                $RFQColumns = $this->Rfq_model->get_templete_columns($TemplateRow['id']);
                                $Columns = [];
                                $indexer = 0;
                                foreach ($RFQColumns as $RFQColumn):
                                    $Columns[] = $RFQColumn['id'];
                    
                                $html .= "<td align='left' bgcolor='#f1f5f9' style='font-weight: 400;font-size: 0.7rem;font-family: Inter,sans-serif;font-weight: 400;padding: 10px;text-aligh:center;border: 1px solid #e2e8f0;'>" . $RFQColumn['ColumnName'] . '</td>';
                                $htmlforExcel .= "<td>" . $RFQColumn['ColumnName'] . "</td>";

                                    $sstrr = "".$RFQColumn['ColumnName'];
                                    $pattern1 = "name";$pattern2 = "Name";$pattern3 = "NAME";
                                    if ((str_contains($sstrr, $pattern1) || str_contains($sstrr, $pattern2) || str_contains($sstrr, $pattern3)) && $indexer == 0)
                                    $stylechanger =  "align='left' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 11px; font-weight: 600; line-height: 24px; padding: 15px 10px 5px 10px;border-bottom: 1px solid #e2e8f0; color:#64748b'";
                                    else
                                    $stylechanger =  "align='left' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 11px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;border-bottom: 1px solid #e2e8f0'";   
                                    
                                    $indexer++;
                                endforeach;

                                $html .= "<td align='left' bgcolor='#f1f5f9' style='font-weight: 400;font-size: 0.7rem;font-family: Inter,sans-serif;font-weight: 400;padding: 10px;text-aligh:center;border: 1px solid #e2e8f0;'><b>Unit Price</b></td>";
                                $htmlforExcel .= "<td>Unit Price</td>";

                                $html .= "<td align='left' bgcolor='#f1f5f9' style='font-weight: 400;font-size: 0.7rem;font-family: Inter,sans-serif;font-weight: 400;padding: 10px;text-aligh:center;border: 1px solid #e2e8f0;'><b>Amount</b></td>";
                                $htmlforExcel .= "<td>Amount</td>";

                                $RFQItemAttirbutes =$this->Rfq_model->get_column_attribute($Columns[0]);
                                $RowsCount = count($RFQItemAttirbutes);
                                $Rows = [];
                    
                                for ($j = 0; $j < count($Columns); $j++) {
                                    $RFQItemAttirbutes = $this->Rfq_model->get_column_attribute($Columns[$j]);
                    
                                    $i = 0;
                                    foreach ($RFQItemAttirbutes as $RFQItemAttirbute):
                                        $Rows[$j][$i] = $RFQItemAttirbute['description'];
                                        $i++;
                                    endforeach;
                                }

                                $html .= "</tr>";
                                $htmlforExcel .= "</tr>";

                                for ($i = 0; $i < $RowsCount; $i++) {
                                    $html .= '<tr>';
                                    $htmlforExcel .= "<tr>";

                                    $html .= "<td align='left' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 11px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;border-bottom: 1px solid #e2e8f0'>" . ($i + 1) . '</td>';
                                    $htmlforExcel .= "<td>" . ($i + 1) . "</td>";

                                    for ($j = 0; $j < count($Columns); $j++) {
                                        if($j == 0){
                                        $html .= "<td ".$stylechanger.">" . $Rows[$j][$i] . '</td>';
                                        $htmlforExcel .= "<td>" . $Rows[$j][$i] . "</td>";

                                        }else{
                                        $html .= "<td align='left' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 11px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;border-bottom: 1px solid #e2e8f0'>" . $Rows[$j][$i] . '</td>';
                                        $htmlforExcel .= "<td>" . $Rows[$j][$i] . "</td>";
                                             }
                                    }
                                    $html .= "<td align='left' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 11px; font-weight: 600; line-height: 24px; padding: 15px 10px 5px 10px;border-bottom: 1px solid #e2e8f0;border-right: 1px solid #e2e8f0; color:#64748b; background-color:#f1f5f9'></td>";
                                    $htmlforExcel .= "<td></td>";

                                    $html .= "<td align='left' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 11px; font-weight: 600; line-height: 24px; padding: 15px 10px 5px 10px;border-bottom: 1px solid #e2e8f0;border-right: 1px solid #e2e8f0; color:#64748b; background-color:#f1f5f9'>AED</td>";
                                    $htmlforExcel .= "<td>&nbsp;&nbsp;&nbsp;AED</td>";

                                    $html .= '</tr>';
                                    $htmlforExcel .= "<tr>";
                                }

                                $html .= "</table>";
                                $htmlforExcel .= "</table><br/><br/>";

            //$html .= $html_part;
            $html .= '<br />';
          //$html .= $RFQ->Remarks;
            $html .= '<br />';
            $html .= '</div>';
}





            $html .= "<footer style='position: fixed; bottom:-30px; right: 0px; left: 0px;height: 50px; line-height: 35px;'>";
            $html .= '<hr/>';
            $html .= "<div class='row' style='display: inline-flex; width:100%'>";
            $html .= "<div class='row' style='display: inline-flex; width:200px'>";
            $html .= "<div style='text-align:right; margin-right:10px;width:50%;margin-bottom:1px;'>";
            $html .= "<span><h5 style='margin-bottom:3px;margin-top:3px;color:grey;font-size: 9px;'>Prizm Energy&copy;</h5></span>";
            $html .= '</div>';
            $html .= '</div>';
            $html .= "<div class='row' style='float:right;display: inline-flex; width:300px'>";
            $html .= "<div style='text-align:left; margin-left:160px;width:50%;height:30px;margin-bottom:1px;'>";
            $html .= "<span><h5 style='margin-bottom:3px;margin-top:3px;color:grey;font-size: 9px;'>PE-PRJ-0PR V1.0 " . date('M y') . '</h5></span>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</footer>';
            $html .= '</body>';
            $html .= '</html>';

            $Injection3ForEmailView = $Injection3ForEmailView.$html;


// Creating PDF and XLS files ////////////////////////////////////////////////////////////////////////////////////////////////////////////// 

$pdfFileName = 'RFQ-' . date('y') . str_pad($RFQId, 6, '0', STR_PAD_LEFT) ./*  '-' . $TemplateIndex .  */'.pdf';

$excelExactfilename = 'RFQ-' . date('y') . str_pad($RFQId, 6, '0', STR_PAD_LEFT)/*   */;
$excelfilename = $excelExactfilename . '.xlsx';

//if($fromEmail != 1){
// Creating PDF file --------------------------------------------------------------------------------------------------------------------- 
            $html2pdf = new Dompdf();
            $html2pdf->set_option('isRemoteEnabled', true);
            $html2pdf->loadHtml($html);
            $html2pdf->setPaper('A4', 'landscape');
            $html2pdf->render();
            //// $html2pdf->stream("abc.pdf", array('Attachment'=>1));
            $output = $html2pdf->output();
            
            $dir = module_dir_path(rfq_MODULE_NAME, 'media/buffers/SupplierInquiries' );
            $fileName = $dir . '/' . $pdfFileName;

    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
           //// $dir = 'media/buffers/SupplierInquiries';
            //$TemplateIndex++;
            if (is_dir($dir) === false) {
                mkdir($dir);
            }

            file_put_contents($fileName, $output);
            $RFQFiles[] = $fileName;
// ----------------------------------------------------------------------------------------------------------------------------------------   
//}



// Creating EXCEL file --------------------------------------------------------------------------------------------------------------------- 
//$temporary_html_file = './tmp_html/' . time() . '.html';

$temporary_html_file = module_dir_path(rfq_MODULE_NAME, 'media/buffers/SupplierInquiries/' ). $excelExactfilename . '.html';
$temporary_html_file_preview = module_dir_path(rfq_MODULE_NAME, 'media/buffers/SupplierInquiries/' ). $excelExactfilename . '_preview.html';

//if($fromEmail != 2){
file_put_contents($temporary_html_file, $htmlforExcel);
$reader = IOFactory::createReader('Html');
$spreadsheet = $reader->load($temporary_html_file);
$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$xlsFileName = module_dir_path(rfq_MODULE_NAME, 'media/buffers/SupplierInquiries/' ).$excelfilename;
$writer->save($xlsFileName);
//}
//exit(0);

//for Downloading////////////////////////////////////////////////////////////
////header('Content-Type: application/x-www-form-urlencoded');
////header('Content-Transfer-Encoding: Binary');
////header("Content-disposition: attachment; filename=\"".$excelfilename."\"");
////readfile($excelfilename); 
/////////////////////////////////////////////////////////////////////////////


////unlink($temporary_html_file);
////unlink($excelfilename);
// -----------------------------------------------------------------------------------------------------------------------------------------
//}//end if($fromEmail != 1)
// Creating PDF and XLS files ////////////////////////////////////////////////////////////////////////////////////////////////////////////// 


$TemplateIndex++;








// if request comes from email-------------------------------------------------------------------------------------------------------------------------------------------------
//$Injection2ForEmailView = "<div style='display:inline-block; max-width:50%; min-width:240px; vertical-align:top; width:100%;text-align: right;margin-top: 15px;'></div>";
$Injection2ForEmailView = "<div style='display:inline-block; max-width:inherit; min-width:240px; vertical-align:top; width:100%;text-align: right;margin-top: 15px;'>
<a href='' style='font-size: 13px;border: 1px solid #e2e8f0;padding: 7px;text-decoration: auto;color: black;background: #f1f5f994;'  onclick='window.print()'><span style='font-size: 20px;'>&#9113;</span> Print</a>
&nbsp;&nbsp;
<a href='".base_url('modules/rfq/media/buffers/SupplierInquiries/' . $pdfFileName)."' style='font-size: 13px;border: 1px solid #e2e8f0;padding: 7px;text-decoration: auto;color: black;background: #f1f5f994;margin-right: 5px;' download>&#x27C0; PDF</a>
&nbsp;&nbsp;
<a href='".base_url('modules/rfq/media/buffers/SupplierInquiries/' . $excelfilename)."' style='font-size: 13px;border: 1px solid #e2e8f0;padding: 7px;text-decoration: auto;color: black;background: #f1f5f994;' download>&#x27C0; XLS</a>
</div>";
if($fromEmail == 1)
return $Injection1ForEmailView.$Injection2ForEmailView.$Injection3ForEmailView;
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------






    $thenote = str_replace("<p","<p style='font-weight: 200; margin: 0; font-size: 0.85rem; --tw-text-opacity: 1; color: rgb(100 116 139/var(--tw-text-opacity));line-height: 20px;'",$RFQ->note); 
 
    
//$imbededImagePath = base_url('uploads/company/'. $company_logo);
//$imbededImagePath = 'uploads/company/'.$company_logo;

//$html_first_half .= "<img src='cid:logo_2prizm' width='285' height='120' style='display: block; border: 0px;width:285px' />";

//$html_first_half .= "<p style='font-weight: 600; margin-top: 10px;margin-bottom: 10px;font-size:0.85rem;'>NOTES : </p>".$thenote

//module_dir_path(rfq_MODULE_NAME, "media/buffers/SupplierInquiries/".$pdfFileName )
//<button onclick='downloadthefile(\"".module_dir_url(rfq_MODULE_NAME, "media/buffers/SupplierInquiries/".$pdfFileName )."\",\"\",\"\",\"".$pdfFileName."\")' style='font-size: 16px;'>pdf</button>
          

//<a href='".module_dir_url(rfq_MODULE_NAME, "media/buffers/SupplierInquiries/".$pdfFileName )."' style='font-size: 13px;border: 1px solid #e2e8f0;padding: 7px;text-decoration: auto;color: black;background: #f1f5f94f;margin-right: 5px;' download>&#x27C0; PDF</a>
//<a href='".module_dir_url(rfq_MODULE_NAME, "media/buffers/SupplierInquiries/".$excelfilename )."' style='font-size: 13px;border: 1px solid #e2e8f0;padding: 7px;text-decoration: auto;color: black;background: #f1f5f994;' download>&#x27C0; XLS</a>


    $firstPiece= "<!DOCTYPE html>
    <html>
    <head>
    <title></title>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge' />
    <style type='text/css'>
    
        body, table, td, a { -webkit-text-size-adjust: 100% !important; -ms-text-size-adjust: 100% !important; }
        table, td { mso-table-lspace: 0pt !important; mso-table-rspace: 0pt !important; }
        img { -ms-interpolation-mode: bicubic !important; }
        
        img { border: 0 !important; height: auto !important; line-height: 100% !important; outline: none !important; text-decoration: none !important; }
        table { border-collapse: collapse !important; }
        body { height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important; }
        
        
        a[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }
        
        @media screen and (max-width: 480px) {
            .mobile-hide {
                display: none !important;
            }
            .mobile-center {
                text-align: center !important;
            }
        }
        div[style*='margin: 16px 0 !important;'] { margin: 0 !important; }
        </style>
    <body style='margin: 0 !important; padding: 0 !important; background-color: #f8fafc !important; '>";



//  $html_first_half = "<table border='0' cellpadding='0' cellspacing='0' width='60%' style='width:60%' align='center'>    
    $html_first_half = "<table border='0' cellpadding='0' cellspacing='0' width='90%' style='width:90%' align='center'>
    <tbody>
        <tr>
            <td align='center' style='background-color: #f8fafc;' bgcolor='#f8fafc'>
            
            <table align='center' border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 70em;width:100%'>
    
                <tr>           
                    <table border='0' cellpadding='0' cellspacing='0' width='100%' style='
                    margin-top: 10px;
                    margin-bottom: 90px;
                    width:100%
                    '>
                    <tr>
                        <td align='center' height='100%' valign='top' width='100%' style='padding: 10px 0px 10px 0px; width:100%' >
                        <table align='center' border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 78%;margin-left: 0;width:100%'>
                            <tbody><tr>
                                <td align='center' valign='top' style='font-size:0;'>
                                    <div style='display:inline-block; max-width:50%; min-width:240px; vertical-align:top; width:100%;'>
                
                                        <table align='left' border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width:300px;width:100%'>
                                            <tbody>
                                        </tbody></table>
                                    </div>
                                    <div style='display:inline-block; max-width:50%; min-width:240px; vertical-align:top; width:100%;'>
                                    </div>
                                </td>
                            </tr>
                        </tbody></table>
                        </td>
                    </tr>
    
    <tr>           
        <table border='0' cellpadding='0' cellspacing='0' width='100%' style='
        --tw-border-opacity: 1;
        --tw-bg-opacity: 1;
        --tw-shadow: 0 1px 2px 0 rgba(0,0,0,.05);
        --tw-shadow-colored: 0 1px 2px 0 var(--tw-shadow-color);
        border-color: #e3e7eb;
        border-style: solid;
        border-width: 1px;
        border-bottom: none;
        box-shadow: var(--tw-ring-offset-shadow,0 0 #0000),var(--tw-ring-shadow,0 0 #0000),var(--tw-shadow);
        
        margin-top: 0px;
        margin-bottom: 0px;
        width:100%
        '>
        <tr>
            <td align='left' valign='top' style='padding: 10px 0px 10px 0px; background-color: #ffffff;width:100%'>
            <table align='center' border='0' cellpadding='0' cellspacing='0' style='width:80%'>
                <tbody><tr>
    
                
                <tr>
    
    
                                                <td align='left' valign='top' style='   background:white; font-weight: 400;
                                                font-size: 1.1rem;
                                                line-height: 1.1;
                                                font-family: Inter,sans-serif;
                                                font-weight: 600; .
                                                line-height: 24px;'>";

//if($fromEmail == 2)
                            $html_first_half .= "<img src='".(  $fromEmail == 2 ? base_url($imbededImagePath) : "cid:logo_2prizm" )."' width='120' height='70' style='display: block; border: 0px;width:120px; height:70px' />";
                            //$html_first_half .= "<img src='".(  $fromEmail == 2 ? $imbededImagePath : "cid:logo_2prizm" )."' width='120' height='70' style='display: block; border: 0px;width:120px; height:70px' />";
/*                             else
                            $html_first_half .= "<img src='cid:logo_2prizm' width='120' height='70' style='display: block; border: 0px;width:120px; height:70px' />"; */
                                                
                            $html_first_half .= "</td>
                                                <td align='right' valign='bottom'>
                                                <table border='0' cellpadding='0' cellspacing='0'>
                                                <tbody>
                                                <tr>
                                                <div>

                        <a href='".base_url('rfq/Rfq_email_api/rfq/'.$id.'/1')."' target='_blank' style='font-size: 13px;border: 1px solid #e2e8f0;padding: 7px;text-decoration: auto;color: black;background: #f1f5f94f;margin-right: 5px;' download>VIEW</a>
                        &nbsp;&nbsp;
                        <a href='".base_url('modules/rfq/media/buffers/SupplierInquiries/' . $pdfFileName)."' style='font-size: 13px;border: 1px solid #e2e8f0;padding: 7px;text-decoration: auto;color: black;background: #f1f5f994;margin-right: 5px;' download>&#x27C0; PDF</a>
                        &nbsp;&nbsp;
                        <a href='".base_url('modules/rfq/media/buffers/SupplierInquiries/' . $excelfilename)."' style='font-size: 13px;border: 1px solid #e2e8f0;padding: 7px;text-decoration: auto;color: black;background: #f1f5f994;' download>&#x27C0; XLS</a>
                        </div>
                        </tr>
                        </tbody>
                        </table>


                        </td>




                    </tr>


<td align='left' style='padding: 0px 35px 20px 30px; background-color: #ffffff;' bgcolor='#ffffff'>
<table align='left' border='0' cellpadding='0' cellspacing='0'>


        <tbody><tr>
            <td align='left' valign='top' style='    font-weight: 400;
            font-size: 1.1rem;
            line-height: 1.1;
            font-family: Inter,sans-serif;
            font-weight: 600; .
            line-height: 24px;'>
            </td>
            </tr>
        </tbody></table>
    </div>
    <div style='display:inline-block; max-width:50%; min-width:240px; vertical-align:top; width:100%;'>
    </div>
</td>
</tr>
</tbody></table>
</td>
</tr>
<tr>
<table border='0' cellpadding='0' cellspacing='0' width='100%' style='
--tw-border-opacity: 1;
--tw-bg-opacity: 1;
--tw-shadow: 0 1px 2px 0 rgba(0,0,0,.05);
--tw-shadow-colored: 0 1px 2px 0 var(--tw-shadow-color);
border-color: #e3e7eb;
border-style: solid;
border-width: 1px;
border-bottom: none;
border-top: none;
box-shadow: var(--tw-ring-offset-shadow,0 0 #0000),var(--tw-ring-shadow,0 0 #0000),var(--tw-shadow);

margin-top: 1.5px;
margin-bottom: 0px;
width:100%
'>
<tr>




<td align='center' style='padding: 0px 35px 20px 35px; background-color: #ffffff;' bgcolor='#ffffff'>
<table align='center' border='0' cellpadding='0' cellspacing='0' width='85%' style='width:85%'>



    <tbody><tr>





        <td align='left' valign='top' >


            
                <table align='left' border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width:300px;width:100%'>
                    <tbody><tr>
                        <td align='left' valign='top' style='    font-weight: 400;
                        font-size: 1.1rem;
                        line-height: 1.1;
                        font-family: Inter,sans-serif;
                        font-weight: 600; .
                        line-height: 24px;'>
                            <p style='font-weight: 700;margin-top: 10px;margin-bottom: 10px;font-size: 1.0rem;'>".$RFQ->RFQ_code."</p>
                            <p style='font-weight: 600; font-size: 0.9rem; margin: 0;'>PRIZM ENERGY</p>
                            <p style='font-weight: 200; margin: 0; font-size: 0.85rem; --tw-text-opacity: 1; color: #7f8b9d;line-height: 20px;'>3707 Churchill Tower,<br>Business bay,<br>Dubai,UAE</p>

                            </td>
                        </tr>
                    </tbody></table>


                    </td>

                    <td align='right' valign='top''>
                      <table align='right' border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width:300px; float: right;width:100%'>
                        <tbody><tr>
                            <td align='right' valign='top' style='    font-weight: 400;
                            font-size: 1.1rem;
                            line-height: 1.1;
                            font-family: Inter,sans-serif;
                            font-weight: 600; .
                            line-height: 24px;'>
                                <p style='font-weight: 200; margin: 0; font-size: 0.85rem; text-align: end;'>To</p>
                                <p style='font-weight: 600; font-size: 0.9rem; margin: 0; --tw-text-opacity: 1; color: #7f8b9d;text-align: end;'>";

                                               
$html_second_half = "</p><p style='font-weight: 600; font-size: 0.9rem; margin: 0; text-align: end;'><br><br><br><br></p>
<p style='font-weight: 200; margin: 0; font-size: 0.85rem; text-align: end;line-height: 20px;'>
    <br>
    Inquery Date: ".date('Y-m-d')/* date('M y') */."<br>Sale Agent: </p>
    </td>
</tr>
</tbody></table>
</td>
</td>
</tr>
</tbody></table>
</td>
</tr>";





foreach ($rfqTemplates as $TemplateRow) {

$html_second_half .= "<tr>
<td align='center' style='padding: 0px 35px 20px 35px; background-color: #ffffff;' bgcolor='#ffffff'>
<table align='center' border='0' cellpadding='0' cellspacing='0' width='90%' style='width:90%'>
<tr>
<td align='left' style='padding-top: 20px;'>
<table cellspacing='0' cellpadding='0' border='0' width='100%' style='width:100%'>
<tr>
<td width='5%' align='left' bgcolor='#f1f5f9' style='
    font-weight: 400;
    font-size: 0.7rem;
    font-family: Inter,sans-serif;
    padding: 2%;
    border: 1px solid #e2e8f0;
    width:5%
    '>
    #
</td>";

$RFQColumns = $this->Rfq_model->get_templete_columns($TemplateRow['id']);
$Columns = [];
$indexer = 0;
foreach ($RFQColumns as $RFQColumn):
    $Columns[] = $RFQColumn['id'];
    $html_second_half .= "<td  align='left' bgcolor='#f1f5f9' style='
    font-weight: 400;
    font-size: 0.7rem;
    font-family: Inter,sans-serif;
    font-weight: 400;
    padding: 2%;
    border: 1px solid #e2e8f0;
    '>" . $RFQColumn['ColumnName'] . '</td>';
    $sstrr = "".$RFQColumn['ColumnName'];
    $pattern1 = "name";$pattern2 = "Name";$pattern3 = "NAME";   
$indexer++;
endforeach;

$html_second_half .= "<td  align='left' bgcolor='#f1f5f9' style='
font-weight: 400;
font-size: 0.7rem;
font-family: Inter,sans-serif;
font-weight: 400;
padding: 2%;
border: 1px solid #e2e8f0;
'>
Unit Price
</td>
<td  align='left' bgcolor='#f1f5f9' style='
font-weight: 400;
font-size: 0.7rem;
font-family: Inter,sans-serif;
font-weight: 400;
padding: 2%;
border: 1px solid #e2e8f0;
'>
Amount
</td>";
$RFQItemAttirbutes =$this->Rfq_model->get_column_attribute($Columns[0]);
$RowsCount = count($RFQItemAttirbutes);
$Rows = [];

for ($j = 0; $j < count($Columns); $j++) {
    $RFQItemAttirbutes = $this->Rfq_model->get_column_attribute($Columns[$j]);

    $i = 0;
    foreach ($RFQItemAttirbutes as $RFQItemAttirbute):
        $Rows[$j][$i] = $RFQItemAttirbute['description'];
        $i++;
    endforeach;
}

$html_second_half .= "</tr>";

for ($i = 0; $i < $RowsCount; $i++) {
    $html_second_half .= '<tr>';
    $html_second_half .= "<td width='5%' align='left' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 11px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;border-bottom: 1px solid #e2e8f0;width:5%'>" . ($i + 1) . '</td>';

    for ($j = 0; $j < count($Columns); $j++) {
        $html_second_half .= "<td  align='left' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 11px; font-weight: 600; line-height: 24px; padding: 15px 10px 5px 10px;border-bottom: 1px solid #e2e8f0; color:#64748b;'>" . $Rows[$j][$i] . '</td>';
    }
    $html_second_half .= "<td bgcolor='#f1f5f9'  align='left' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 11px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;border-bottom: 1px solid #e2e8f0; border-right:0.5px solid #8080802e'></td>";
    $html_second_half .= "<td bgcolor='#f1f5f9'  align='left' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 11px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;border-bottom: 1px solid #e2e8f0; border-right:0.5px solid #8080802e'>AED</td>";
    $html_second_half .= '</tr>';
}

$html_second_half .= "</table>
<br>
<br>
<br>
<br>
<hr style='color : rgb(226 232 240/var(--tw-border-opacity));opacity: 22%;'> 
</td>
</tr>
</table>
</td>
</tr>";
}





//$RFQ->Remarks  
$theRemarks =   str_replace("<p>","<br>",str_replace("</p>","",$RFQ->Remarks));

$html_second_half .= "<tr>
<td align='center' style='padding: 0px 35px 20px 35px; background-color: #ffffff;' bgcolor='#ffffff'>
<table align='center' border='0' cellpadding='0' cellspacing='0' width='85%' style='width:85%'>

<tbody><tr>

<td align='center' valign='top' style='font-size:0;'>


    <table align='left' border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width:100%;width:100%'>


        <tbody><tr>
            <td align='left' valign='top' style='    font-weight: 400;
            font-size: 1.1rem;
            line-height: 1.1;
            font-family: Inter,sans-serif;
            font-weight: 600; .
            line-height: 24px;'>

                <p  
                style='font-weight: 600; font-size: 0.9rem; margin-bottom: 10px'>REMARKS :</p>
                <p style='font-weight: 200; margin: 0; font-size: 0.95rem; --tw-text-opacity: 1; color: #7f8b9d;line-height: 20px;'>
                ".$theRemarks."
                </p>

                </td>
            </tr>
        </tbody></table>



    <div style='display:inline-block; max-width:50%; min-width:240px; vertical-align:top; width:100%;'>

    </div>
</td>
</tr>
</tbody></table>
</td>
</tr>
</table>
</tr>
<tr>
<td align='center' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 400; line-height: 24px; padding-top: 12px;padding-bottom: 12px; border-top: 1px solid #e2e8f0;background: #f1f5f9;'>
2023 Copyright PRIZM ENERGY<br>
</td>
</tr>
</table>
</td>
</tr>
</table>
</body>
<script>
function downloadthefile(theurl,name,type,fullname_with_type=''){
 axios({
     url:''+theurl,
     method:'GET',
     responseType: 'blob'
}).then((response) => {
    const url = window.URL
    .createObjectURL(new Blob([response.data]));
           const link = document.createElement('a');
           link.href = url;
           if(fullname_with_type != '')
           link.setAttribute('download', ''+fullname_with_type);
           else
           link.setAttribute('download', ''+name+'.'+type);
           document.body.appendChild(link);
           link.click();
})
}
</script>
</html>";



















        $headers = "From: procurement@prizm-energy.com \r\n";
        // $receiver = $RFQSupplier->Supplier->email;
        $subject = 'RFQ-' . date('y') . str_pad($RFQId, 6, '0', STR_PAD_LEFT) . '  ' . $RFQ->EmailSubject . '';
        $sender = 'From:procurement@prizm-energy.com';

        $boundary = md5('random'); // define boundary with a md5 hashed value

        //plain text
        //$Signature="<br/>Regards,<br/>";
        $Signature = '';
        $Signature .= '<hr />';
        /*$Signature.="<img src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOIAAAA8CAYAAAB7JGaIAAAAAXNSR0IArs4c6QAAAAlwSFlzAAAOxAAADsQBlSsOGwAAABl0RVh0U29mdHdhcmUATWljcm9zb2Z0IE9mZmljZX/tNXEAADL+SURBVHhe7X0JfNTVtf+997fMlmWSAIY1gmiL2tYNFCTBhEiVp1CXtlakEcQCVl5p60K1NQb37S+KCAokRKSvrV1cqm0RSSF90Prq0odtVHZkCYEkE5LM9tv+3/PLwmQyk5lJguKr108kmbm/u/3uufcs33OOXFZWxr4oX6zAp7ECq6oHjBKWvBN97Z1dUHvqp9Hn56UP+fMy0MhxVv2PZ+JVQ/7V5Buat+3TGv+6dV5FH8GGMObsly4DLGigrWCQNQYW5odak220tLSU4/C0kq8/RmQV73K11c/qfC6LZXFZPqTPGO8LJdtWZL3KrcO+ZOosz2I65hGjCNPiTPVYZjgwO79uw/EaVphLal5F9aB7LVN8gM95iv1bTDCVmWZ6ouck1cNYsHlrSeHR/6W6q6pzT5dkV5EVjrPcQqiolom20Yewmw+zYMW8fN/BRH1Ffr+qKne84nRNNsKt9npzRothpnHGPSZnXd6d4DK3DOOTzxUhVm7MPd0U7qdVK/zXK0a9O3qI6+c/ftT3k7pUFqm3dQMjnKOFZb2HxRQWM3vbTOdzKnNoFrP8Ks9qLq82D3OhvMdMqUqww2+W5Id8sToor85dMPKyF+aUV/uTHsCpxQ2Sxbxpbe0d3wOG1cANzREqrz7Fzy3WYnGxh5n8fVOIqjn5+99LNEFd1+6SHdnfNcPHYle1JCYpHqaFNLoBR0dUMrHRsYquUt6211MvHG9BlhI+J6npLKwH7kZFmxCFzi5V0gYs00HJcamflghNWwLkIzmY1FJfjU9SIkTskOmSa+CdFo4i+i9y7SOnTF0J2cn0YH3954IQ6RY49ZKVP+BcKlUdmd6PD0qV2e6mc5vNIU9hLt9J+Eb6oYKCd2MKxQGCYdhdjGOR+1Q4Q0PCjfNyAE7fkZjbRZZkzjfMnP3l1Wy5Y5//8RkzfOHIPizLOk1yZH2VGaDDpO9E9GDFqYwp0EaxN50Q+UwWM5nhN8urh6w3dX/pnELf2/HmiK28yzJCWBRcHjHuRAs7zhS4bLn1TnQbnOprmBoIKqWJRDQUb0rHq1jM4Daxah2fYdU+0P21+y3THMb0ntfQUiSmaa3bZKbvS/U9W6a0RfPX7mSGcRrT4p+ZlsTxKnE9W/zpk54QKzcOGDvyktWPgaWYZOLFG3oL1iUz7FbMd1W3u2yWXrm2orXkjVQXK9X6u/YFd+YNcV5hKdYywaU8DCTVJmLUP/6S2nkYnJDKMK44Hgjlsakrqtm3ItkisDDPaK21AzgXM7gWmyNMdVAdJNrxLxf4T3VdxoVUVF6lzp9dWFceq809WVn359XXB3CiP8L0zr3eWZUrTmbqreX7lPDcuGNKTE2pTud4fUliptaqgX1+q+PDOYW1m1ds9ExWlYx3uBBp9oEWq9ABgYPECmvzwNbuSXUQcwoPvlpeNegsyZnxoKXFlzoE1sjQW5+dPenw4pOWEJe8muv2pkt3cc7vAIugGBoRINYH7AL+b6npR/7BjBHMpYoVdygrvvaob15jqguWSv2yGT7aba+vrh6Yz+WMOy29PwgxagREDZqGDawxyZV2sarpry6pzi1YmF/rp5pzCo/uWFE1YLEqy9eDUDixeP1dOG44FmxlXFFU7nCtLt+U2zx7Uu1L0f2UnV1jVFYN+LNpgc2kjduNqOgz8U7ZeN8JWKhEs7YYxs6MUNOKOYVH3o2sHWzRD6teE+sptbPrMdrCXDhXcCjq5+PbLYl6i/m9xK6wEh7W9rrV0/MnJSFWbMydkpUuPy5k91fAImFj2vsQBWwUjjjG9FaW6T/k22uwbI80vO6Y+//hw1m9WrAUH+KmAJWk+FCK1SGzMTPQAmLMPD8z3FSKx+/saMIlM7dxIm+S9nVmGtYZm5FJ/LkV1d4tuJkPRE/DlIm1jl+4MOnU/PSLojIc3HWykBZHd+50ulQsb2LplA4507pl3bpxz82Y8XYXESHRhKAUmigJeQLTk3rMpsGTihAr13sHMsVznxDSXC5kLGZzzDmrjlaZXcx2B3daQRYwnZku6ca5Yt2rz/lm/C7RIvX5e07Sz4kvRIxWOADxQSyorM5dVpJfa8sqmi5jeaB7+zRKGGeOOy1LDZs/Qnc/7tcuSStpa2uSFXbb5EnLJJYcNxYpQWI8SqI7l3GA6OGfYc2O9nrMkGFxq345NGzf19HGa6m0Iyzz+8S5WXTxJllOGkKsrBp2PVP5g0Jy5YFvZlYMuaNjTulqUFm8tKxlbubag+CKRulgp3BJLbvZW/mXlb6SI0nOvf+rEfXQ5hJJXpl06oK1i7sXYRkAIbjM0LHrMNhH2wdM5gZiC7q9O1OATcQmtBVKSRaoaZhlaMyijRdDl2hBMYUBfntJ9Zh7FubXJG1m6al7SybOBjw4Y02k209qqNBUYXE1S7IGYpwSN2KfRVyF3KW1vL1vbvYqVlPbremgyxlUiULsQ6AHOZt6A1Vb3LolFUIEu34qNLrTLS2Y1LQ6Kn3mhLhqfe5psiI/LCT1WtqU8W7ByFm5hdE+bmu3KotRTQGTDfBIg4+0WM+i3jdTWoF+rExaMNjVAnjBDdi88amRg2LpUJdYNg4e8FGgK2IFYxGCgc3C+X90EKLi1FsNXQLV8G7vjssqRI7wH9HeK1jKRKcB1J0mHpCGY6zTudNxmhWKoQ2GLMxVx9BMs34sxvDnPi0X7AaQPZ1cUkD85nSPcLwNO2qicdpdBqBgVE11PPbJb6FkkbrLpKgE7a8FJSmUWreV1dTEFqCzsnTWUN9duxRrYsRaSmIKWM2z5uTX/jOZuRtCukmSPS4rkNqZ9ZkSYsXGYQtwgJdBI5pl2NqlZNgU29ZqM984THdInE+ms7HRD3nRLV17s7V2xsrmmeuSWbT+rkM2IcMI/A47a3473xWni0YWcLm4q0UeZLBwASbyEFfknJiaUBCpyawzV1TnZs/Lr20AawozVWzWlMMejdutelZ+7YpU5lZZ7bjPMHJ+LVTnZAZi7FJwEZGd29BD4/pKiLqs+4Wlb8Lte2T2pLo/pDJGqrt686AfECUzI/ZtYyto9Oa1UGqR7S92aWyk7ZIcaw+tqlDd2G0tpPn9z0TjhQiRxrg5i7iLVMtnQoirNuaeJ3PpCVlxXWKbJNo1ogkHbyuZDFwGpi084mKpsU1RKKTsC8E2pMr8qZsdlZtXhko+Sdhev1ew5ZZgSUFtHCt3ZIf2hidN70cw1IeYpFbaIJXoswgyEZfEANizgOphuGl7KvSw1Y6iSX5yBCBYVWUuYor+VwHbjL2YkaVNORRplE++8Yia7aaYS3rzMLS3N0iqu9gKBmJTEQz8puE/JjNxV2/aBwtqkyePPuOINRdsxorqkWXz8nfbGs54xTTNa4WaNpRhjF2WDxAQeq892Z4/VUJc8qrDlZU2YJEi+J1cOB1JE2DUzHGq2nKFqbGdQZ1UzW3ac3/YYjlpUk69YT3DQmx6b15IX58Bz5mczBPREc7PNxU90CIJBbatKLmFXiDJM5bs7evYenpekdkHMC7XMeEYDDV1FCGie84Hpd4/7cC+F9w0GZawHqSDiuglutgKGhXKEa35oZL8uv296ZHkY5NDxo4mc/QpXGnZariVgCPP9EiInM2XbLk/avkwaJFgW3xqhFhZNaQ4K0N6HDLR10yIUTD29ma9ujyjKmKHP2RCi86Fbtt+2ljULI807SZr7ezVzTNjGqP73HE/N+DKYgGjkeGW5/FtWwwnzgksuzZ8L5RX/FwTjv/BMbvhHMDN1AoQLEnJf4la1S3zblnJGG5C7orFUwIAQcb7Dx1y+MlEbfX4PR3oIJpuNxfJ8MKcW/rBB8vLzj47poansiq3QKjKOBbuypZ23LSJxnXCCRGyzQCXJpVBk3hLTyaJRAPt8r0JqZyKUz/IAqJOEiyXEEtU6GYMAlbkUvj/m+9Z9+flrTN2pdT2Z1A5EGBpqmV5bQ3qZ1TOL37eddSyssBnxKZDGFNSGZp9iwvuTeWZWHXhsTEGNrmFlhabJSV4nq0A1dgdvQWwR/ZLF5cNwYssUNoAKXR2Xn1xEWO1b8YapwF4IiBJ2IBRJosk+aMTSogVVcOuc3L+kFBcpyYySST3wqAVIxlR6LaMmD13V3PtktF7FZnnhiIujADg1DD0Z9YbBiktpiTXdv/UwrZIGUmi+s2rheJ2dVOU0JBwzdsgBg5V/wksdbp+vqS6BrJwjAOfWD+L9cIm1yHB937gYOke5TI0y+HYNjnA8cBdHXt99qQjKdn64o6oQ5UTyX/gbIKXBNN58Pt4rhshVm4dcCoE+eks2mRhg4vodkg8/xNCiKs2ekfKIu1hSVK/ZSVpkkg81PYatjlJtjUd5A7E2dqdsmAXRj5Pa+lrNcikcenNZuWtK5tLeuTtk+47UUWMDf95IdPkJaqqsSBekXMo/jcZbxmQOS2m/GMTIrPq05l+KFGbNoTb5MlbkdsbrKz25kmy8gRBv2HA7d4NjcGydkR/AdYTWPXEo+ptDSixpnLZcYUVgtkvViPAk1pmIGQa0h297SPqORISQftgT6PslGRPBZJiKljQM0oKaz+OfM7QxRwBkwWLMlm0ESHB4m1S7HGl+p0QK6qGfB/Yj8WQBbNtOfDEwLE63wso8UMR4+ClmbeGTOZQpUfmD6hcv/xoSZfF66cX16UZkn3BJl0NCFpCRZFgDlLCKFxyQskQxIunmyjGdiMDval9+O18X48aOxoIfP9wAptF5ZsGJWAjhQzZJRNUBxcpPgoDKYSJIqftRo4ag30jA/8qxN+i1wzSeZMgEEEb6KVfy7qtXoLHPW5rMWNwy3TkwdxC5oolcwoP/6vvndvzbsE0/goc75RugHDblOFRDLP5ZtS7vaM/YIHT0i3rxphwNjrXTPM3WB+gc3hGT4vUb4SIk+Ic3FRPSLKzyDLCEJ7bQNonomiWHrFbxMeaQdbx7tMkjWqWW3I3+q2V+HrSiRhLV0rEjWTBANAmtSRR8No7ZZ84SBHyItB5Ut4llg6DvOwoFqqjOGHn7QckcSyErIlJhNSILANbHjqkNPKt3dqUyeJNKJ7kzHIJxxRRIaSr/4lbZowViH0bcpVsm80HZMYfTKXduHXbtQ5QnK60uH4Ol+RB0cRoo4w4m1lZPea+kvwa20SVCZMFj2GyoHWzWHg33MXKscJXxdygEYPpMyHSyaUH0xaho5+QSQLaq35Zl/iNcEvhcqcgQyYMP1aP1Degxy7FZlGhRQWLWnCTXnnn6taSR07k4GzVur3B++l6gG0MJp6ALoJrkxm3ICVlWCd0TzLVO+u07cHuxGTfOtBIwnewvGRabQzgL7BqJ6CAVQbaR77b9vuM0b5trpCwdcPBu0smHU7CZpvEIEnrLlRVaNp24LZ+yWTnAvhmdn0Q2lPh9JxihOu/hS9WkZ/siMnLb5Fi+YfSuoW1cny1XcgATscp5L1PX/WJECs3DikCKPlxSXafaxr9Y5LoaclsJ1bik/Rgp+LCqej7woZoUhWeacTR8DeDRfU4JfJd/ENFqMT21j7ZC202oDpwUx17eN4k32cATmh3JQof2wP00uOf5nrppvoAFEeZDLdhrEJ4UjPcvGXvxlteYJPK+m1oJPBqTHMrurLM5MEF8MxsQ4p0FPqViI5zIKfYquHFz10shDKWhaPQSFDjm0ZrUBLB500zDfbXeJhWHHUIodFrQlzxqjfHme65F7z0raIHL4l+W6FuDTk7Vydr8K76wwdHf6JIPDMchxBJo+p1C0fIJVbeM6p0wuKasv7xqj1BE7Q95l2w7Yd8v9+rhvuH9UplrHS1QxsJ3GazaRjXzS486kvl8b7UhaJropDlmeR5EltBY+NJAWKxfphK7J7kxgQOQBaekvz9W1dvPuUvkuKeyEJRcDqb/VfPQ1ya87hkzeS2ySKKA8FBwfTm35Xk++oqq5wjoeeP2z2OO9s+m/KNCHzoN53p7BHcgiP7xySR3BLFq0VEBS+MXdCcnh2vDi1DE8K8DEiTxh08MPpn+PPevvV6gp6mExgsDUmYRrh57TFf09yyaaHU+Mw+DK3Dhcg2kOuBD4UWvHFW4dFuSpo+dNHjo6Wl9/C84uWPCw6UXkw8KbYtAkKZWlMF8KRxw3j0ZXyc6bZ2U1j8WUDbJnaT7YiRJMW9ZMI0xkfairbIDgl4DtimxMTT9DHYN6hsevCGaQ8mlTQhknsH1O0PSbJ6Xb+bJFJbOcw72GXuYFk/ktpt/D01RV4abkXcPctT+TrCa/xPat0mUTtVNyhSN4LqELbBthea2HzcCv+3FTaeiuUVn2gENioEyh1yg4olpZISjdvhIbqe0KSut1XtGIIljN1Ma10LFdEShInoFAES9d0f3+cVPT9byOkXRmM1O9smvLfur5e49tP+6K/HvdLU+HKG19wLIH8eRU3oUqCjEoo61rZpdyBJOirQIWa0bp5VUPdX+yOZNYNecJhCe9OD7iApQoSv4Dy8pfu47BxwAk0Side2TU+OSITOLvwCNuDHJgnbbYdV3BKGNifTxWXNkFZe51134S98M3oVSjBeB0m7QbURAlnpg7AyNQgm7QQl/AMk+RbYor8nXog4NUg24XodWKXd7cvRXpFWxdblngNzlsqjtFr2+QHPERwEaxyi9ZYZF/cuxGKvx40HybtEFex+RiFI4uFJ4XnPQq33lUzydXc07EvnMZ5dOC0UqNgkypmilkUTIvmGm1BVtAHEIw619j9hlnqqky5lptkONAlKj4SI8IVfA7bnMajELyUV94k0SSQaqP09aSTJcJXVdV6mZu4MQoEXM3RKRMO0TsdwKwIY/jWt2SApf1FS/SZZKVk3qIAzyF1Bp7bre1n+uH5zSfYZWc0OzWc0//am/COkTOhW4MFwD5AoZSwIJUjkZieetM2OOVnXA+S90a8HVDJTUUzjZ8KRmWv54+BJAeqGBnmbc3+IfE4/lRISrFzVW+4Al+Fp4ySOF5sIoyP54aAw9ZaPHZ9ox1E+cFtLRosekxARTFcND0m7AyH27kIwWJepkfaqn1TyfVhCYgWE7PKaYT/Jebd2NAXH4j0BzQwhAp7DjqSQoBCL6lH57Td71r2+snVGfN+1RA11+95e8yTdoPBwDA/ylLtM4YFjovGJDJ3NhkkiLxqcTI7JksuTZ4R1xHk5ktD3LoVuE1aFguYrQpK+b4XiKGhI7oKJCm6YtyHEZHJOvQl7TVwB/p8IbTnot1zxUJjJ7oQY1QSZVLghPTtjxpGUx9iNEIGMuUQMlR6TJdcFtknihNsFEy9IZA0ShMFGfb+yatDLJYVtEaTlwJFa05VzUJHESD1eiLyIRggA4FKg71WslQtyXz1vae20lGFh8UbdGzeo1FYgQW34K8WrQRHFK6pZGZOk8lh8vK2plNS50Agi+lltP6BVkpuZzozHJeFWGPqPWeDwa4Vbfjtn0uH1ybXYf7WgdFlmmsGZZKi2I9zFKxABda3lqBYKvdCb3jsJccV6b5ZTdZfBLxT2EwjFcQI39aaT/nyGFEUUp9m05Odxkp6HAEG+paGFgXnOFw+oEhsZ51V2Pc3w17GgrUX9Ul2z72H8+aneAP25Hqm2ted7WZV5z9XfCrjWed1U8zjEuOJWuXSM1mRaqm33pj5unGvA+U2JS4QANVi6PyAJozOSXW/66e0z2F9/W715IEwZad1NGZGNkrY7HFwzb4qvsTd92YT49G9O+7Y7Q39CyN6hiOOHT4gFhHmjixxqg48jsKMdv9tA57a+O3Gl3f/uPEv6AXlC2kUszEgj3PLM1q3eG8cjdiYMS1udqjzxGNQ4ycBbaWo+mDQyHNKCmzxrX1vdOjOme0tvFvXEPkMyRzi+YSpB5ySTVvBBdyEO9h9jnvK4lYTquhIEUtw1Z0X/zwo4TXc6Mx+247PGU2dgg1ta0+MlBUe7gc57P6LUwrTDlLEspimjYwCkJNNbg6ZwLO/tmOQD1rH8/MkfFPlbnb9qrHfX7tk3sC6EgCq6LuBwa2aqjrBHcVhp+N0rJAPO9fCbI89JztKxG4iQndj4FDoeCnAzs20g3I4CDJKAmgv+IwiyBuO/jb8E62Or6o+XSGpv+73DS9om3k4fvUjitg05JCtf9Dd9sGM88+m5kvTTo80mS3OI25tx2yVTKPobBccFKmfFgtzKc5fWlvQPXCqZzntZRwEDZHB4zPVBZJ+VX/en8s0D/yjU9Mu6mQpoTUgraPFHSj8YM44CCfdyqAkfyzDNHws1Y7RFAY1j1VYVEo0+ciij7mcpemFR5ilFzX4MoIgPZxfUUf4Lu2Rhk4KnSsk2C13Jy0goswfKsFO7mTKoUTLga80vzyk41GvfVznLKX904SV/rUSClSLFoV8gyeE0WQ4fSvNo76lycNupo+p2jGItBxYvLutRjoIxVmSd/7ydKikry0rHvSql6wzMveUARFuGiyCuWJ1LGrL4kNHP0pHNR1B9aK1NINNB4uSYSq4UlpUBFTAiIZkO7DcE5CFsG7L0tMW3oyxATqTQ0fHE9zpC/C32zQiPGVO66JJDo78Bp+DTyScxUaGXT/C3gWnSqLpjFgUpnpPomc/6+0Ag2KK6HKTVTNljPnLscB26m0mhSxEPB6EJow4uQLYkZ9p5CKk/C8+sOhFztu3SinSHbRCPY66goETcwo2562NriT7G42SNcDUimu05VKHLRbeCNF9SM65GtO93Mf5OQgSrGUTinZZYoSPjzbPtmdxVTFbu70aItJXNEEw/5tK+rJPsDrnr9m8qpIxKW/wO/+CcUTWXutzBb8uq9uTAXEk++t5wVuXTjKH56/fh5kMcUWsX6GgHet+HjCzb5bTg/lHn76JYokSoHcTab8qPVCZXU1NmFmS8uBc3XFKESG0TMTYAGJ7hEjfNZWtfea55Zv84mKYy8M+gLpQx75ZvGviCUDNndQv9R4RBcWWFuBcR3l5CcKl+N+zrEn9YRtBWK47DLxLyAKECIhXs7tBwx08zWAPuCpaOrHh4ZeCq4hYc0TY3JrL1gO051i9cjsSCa2AP/IlArMQucYXaDfhA+mzpy2vsojUFUR4K1Jz/Am6zF3ZYZs5Xzv7g625Xy9WqQxR7B4iRimKN1MLGxfAHBcLBgueMyVqbnOH3q848PGTim4dwtO3BhbYLfM0eDHh7WCNnVteh2i35vr4MMpVn8fr2OKG1aQF7moQC1W66AzwPxdezdzh++d+Phr6dIFpaKiM6eetKQisDTPGbQkYeiKg0hxbQJKCToUbYhNPtcdauP2ZTXpU7GfFdvm3GMVfYUDvsMfoHjBGix7Wb4pLVL5D6glK/Rdnb+zJ24EYPrK4+5TeAIH63w5Rhj7Ptx4az9aXENeiP5qI+8M+v/hxE+XMz98ApoUBtsaSErpZla7In3cqkGLn0I0lcBXMzXJL5cPw7jrzxTJgHdMSNQUQnuHAHaodMXH8Ya7kPY96FwYNY2XYcuESk+0GkKYVgyJ28fjjT5Dwoi7Mlh0A0RmnH/s2FH3YswmC3ueBIk9Ga7hQ/IH/EIFjURJoN+r4Fhwq0qMOOmOGlMGfP6Muifl6exebaW77JsQT5RH9qwYk7WnK3wmABufxDBNhdgwC72/tjXpA7pTy54XFIK5DWYotqbe5k7aOJUyfRWBK980TPx/re0o1lFg9+t8MrgwI6Q0nzkeOT8Ku9aS/ymaQgbqJ26OGG2qEUtHed31s/bODQPZe5PaFrIU/mp2dabjK0h5AANzL5jZ3ZitI0SHwI/YBIz21LYIQ0nyAQoPohDgbqQKRHsAP2ou3dgHnthkP6DvDbBwAr3NfYnN7ge3u8Pm7cOvWgc+B3JEncYOpirKSYmWi5DRzN9fCIwg1/h9btD8fq/MsX15QQP7JwvnftP+CRsSzTKVxNuB0TvRj6vhHhNbwucf3N5tpXEKT4VzEXlyzLPRSyNvX1pfT0PBA5huGKb9DCsZOSIgJixhMwVc0BdjK3Ldp4RKFQgk5IXHrLU/h0avS4KD55T0wi6KnbWPLqG+ci9uc5NrrnMyvxo3RBXxFXACWgOYIcVyMBa75t+gELxcMMBvweQQZRMKbISdNN3xaUKylCjHzU7cvZ3+rLWQX331XhAXtH5wyru9KhhKbLSnhCupcDqYTY1cQWUqxc3Ix0O0bDDGwitTOy8kEglkG4Tc8iIqXoHkSoFJ8VUekaXMqxetfF63cc4AOHuNzy12gcRPAa4pdSof+jHVVR+ATVJU2A79CNctb6y45umbJjuW9mxSzHun9ZaVYlHIO/1AAiS6S+oe1NHJoqs6dvQJDiF0Ml3TCNGCFiV/RA1jz1AL+p7MdAViPAXtkx97+NKOUm/N+SL2SHRWiNx6CIeKIbIdIag32EM+zlSF562+z8g138EmU9mAPUSfubiOqTIE6W9eXIT1dUO7JVbv3Mlj8TvYzkp5BSTdieR+CBodicXZ9rWzyIKeLi0tIx1WVlsUP2w469DKd6voVAsEhKdiTk9sR12rZvf9ZYAFcpoPC7n8+EBcfBnY/gxTkpE2Lk6NWjeTuaj+Y9CdftJ83TPzwz0988zeUITJMU/aJ06D0N7GqSI6NhZ8TqU04RIrpuuWaISLEgQubZgKxly7I43QAx+1tiH/RE6AEoW+gn3aucZuj6i97r1uX7fjFDqwjN+NsNwcp8M5utzk6TriRXKI3U8z28utawzaKeAvTNMrCo13RULd3qlYcH3VMR7eU78RKM2KEUhHR5xaYhN6qq/7/6I7xf5FBXVQ04W1VsWxXMb92tCsRKClmdDg3f0r1y8IfJ5CZEiJOxXJWvIc1frNgzbVmp8J3EH1uzZdSVlua/f9ak2jfLNw25SnYoS+wcgDEuaBPaUECXvlWxOddq8jXOJhC1zFw5GPvAbkGUUyKliMo9vcgYhA7E0JlwTnkLgJVcG1we+TzNkwJEKe4H8oobKd1cTA8PRcivwANkt+zKGWkEjlbMG7s7rgH/1PrGOQjDuMKkcIy27xQJlMfHT94wiHA4XtX9m/tEiJHrJ7Z/+V8gSPp52Dr9w3Nzgk1TVUdouuDG2DRYF2H9sm/KhLk1MV7ypCAipasU0W+Sfk3N4BDSs5QLjb0D78VDtsr6RY7sUI1s2vfZ2gccsriLPMP8obZgxLFKB4uKIMVXI4/GTLCo9ok3SneONlX5FdhD7esawnGMxylPhOJFPJUKPRzejQqbkh58EhUByitQPUMm6sEGsOXdJ0AvG/A/1dCabs06EqDQ8zHCW3TtyJTZuYr7lAl60Ic2Y19T1BMh52TXgAKtee/5+PNN3B0FsmvICD2AscRYCltPIju4EWq8zpnFKAwh+BzErBLggZApl8SZvpf41yopa2y7SMT2EaoJO0BWLnlO2IOOWkJKcQ7bKjP9gTPjjc02ZWzKrTS1wL2GIZ7vaQ4I5DVcUtMwVyhuieOj+EB23+1P0fDpb8sa2m+EGDkgvv3L70Ht+B4+e0A6fccFgUDDVaoaulJVta8QUULziugClOuu768iugV/s84cbvGT3Akb/1C7pegvHd8va5x5N+TG91WJPw9vfa8PwO94B6qdNBdKHofCnlrgrdy01Feyj9oBzrWJwpn1KCaCJ+dICSB0ud+ZL+yt/9GDR5aahMmMF57Kwq0Mr+KBA134JbEThcH0d3iwntpswg7BroifezGshwE4Yza+F2qyX+j+Q63IbhwX4MyNIMyA7JP0/S5EEgvBPVauMw19vmG1ICJVfzCnpg96Agoxd/xVCpJvBPLJWrMUx4Cvm35/JxsfNsX/8mAzUtzF33iIusIlg9f0tDPxHl5iWsspyEa8s6d6km6uQmDkKju6HqRAk/g/Aya+DqqjUQOegdzE4RNCiJGDM7aP/jvu7r/D4H/Pw7+6+mJ3S/gqAAWmOj3GGQ4X4lyFIPMRUfbTtjVAQDC3cEPWV46ZUHlBzZaSzmhWkBtfglPwhx5LWgsj/tfqSW6M02+gLY9GVn2LRUGKp8r7gjvZCOdX7QRh/Hioju4vAk7LFnAKMjvc38cMbH/kzNyvDs1z8o++A9QKflIrcBomz/2UvPdxm5BNL6VMVamN6nhtsNx7AIXMx2nbqRWCNwVp6H/Z2zY7niNAPDyUfpCoHazRHqwtfhKXE06IHUMoK1tshGrO2YwzenP1gQk/uaRgxaQMbyvdlJe73NYIFRgamyhBAH0iSpwygRYY6LOVL/vqBxN4eUHkMsAzf9sNRyoLrGFsOdK4XU/gb3IYjr4dO/JoZKfJl99kVc5jM0poA9k34xfl5F+BXQOz/j687tDZutI/Bv3oGfe3O9anRoiRE8kfuiVo7Pzqn3BT/umA35E++vx3JqVl+K6WZGOK220OhXuSrR3Vcbv1iihBVS3HdOb0iFtzJ254vfYvxX+M7P9FNzClDWzG/Oy1/6sK/hCAtJwAANFyI/UdgPLGqUiPQQP7JpQ/PbIiJ//2/PcZYTtGluT0z0X5TAgxcmWGukPNgZqzfw+p5/eA2HmHnfXPSyRZh2tM6OueDGsg8sWzEOQ5IspUCmlTKRGKIlnLveetn+h7d8qB6OeXN8x8ZL63cpssyauRKyOXMklFF2JRoXFN0wzzudJF91yKmz21gaQy6C/q/tuuwGdOiJErD4idr+HdsS/js5frHf5Bw0Z/jBsycLWqBgrd6dwLEbz9pkzufQUgAzrd0qmZXrElY9KG+z2XVK+uKSvrIqkv95W8gdtuIk+3XoDZYgLZGyO18XRLUh6NHI88uebBcQt/pV3xZHK9f1HrixVIfgVOKkKMHHYOwOiBf57zIm7KF01v/dD0oXsud7r9QPNoBRleAa+O7mie6GkTEYVwy6kuMUJ1iudbN+ffOMLYULpvc7Gt+esoxHL+R+OS4pFDBzyZ6RZzW6E8oliokVpmPyJo56S13j+5oeqNt3jhR8kv8Rc1v1iBxCtw0hJi5NCFL+dAB5oHuNfTwkP2T3U4wtNhI5gIc4jDgnGb2NfoZLt2G6Amsl/SjytNnmBo5pvDJ735X5ol3Vu7uagzMc3r7oUB2BvnzbfWbkP67yeBVVXIr7GDGANQ0me7dffwtKPPl952TyFY1F4bX1asz812yPJkMhXACqG04ZsjmyNXTnjBKS3rgQdNOmIZgn2dAVwQ2flQwrtKimq7aTWhTbxQCNcZsKV9XFK4PyWtJ1Kuj1SYehEEBdhozO7oHosieJnhpmbztYXTapPGsGHc0G7KQ2FlpoETCBX/CMQWJcOo2LHL+dI7ZePHpwTdi7X1KzbmTgEQ63LY8s4l8w9smu+Zpv7KrMKDf05MKl1rYMwThOQZZWrNvpLiut/Hen7dunGqPnj/FXjLaYIF34UW9YN4/XwuCLELUdYO3emrHUq+X0ulMTvO0Iz6y2G3u0ZRQhPSMmACAjWGCDgQw14cADqHoHXuNOk7PGBeMbxww5NayP9E7ZZpna4yMHEsu9m7bhuu3DU5Hmkksart9IxsxCYb4tULtj943o9/rn3jsVRfXkd9WZa/JMkOG8tq6n7acO0JyNtrWLB7A/dnme5iMMZJEyI279WSM+MhO+KebjYDznUmTAb7I8cJtnuR6s79RrB5z8v4/KpU5gAwxGVo/1k4wYIh6Z5IkXAjQEw1wYD/32g3aUKEUux+2ektYGGYMk3NXgsKhgLruiyQLWtU6Lr3KzaG7pxVVNurmDV08DkVuVJxZFxBGbsAunwHCIVWgKOvl9W0hS/8ecSfYOtbgIMraWA7ULin4B2uxXtiFVXyN0HMv45ey/DgfbcpzkEPMA3by5Qv6GmtP3eEGDkZo2b0x0fZaLrVngKa5ytZgNg5nQG6KYHmQczmGGgeQuyQRlVWRLrbI90TZO7rRxRsKAO7+mJH2yt9MzYDa1pgedhqyI1TSIlDcWTpdmyBNjcrPVD2H01vvP66MbVXAZawoQ0KgkUwP+RbKA7Ieg1iGHYx0VsBH5fTGfmJplLCph60iVt2ZKbroYYH8HBJVANB2owoPXvXxugVN7cmtWWPquGKNQVNQHHljLD86IQTNg8NyoINNYXzg2LVEgjM1NYGdbbI5bIEsiibLsWfburGDyXVOxfYxNcQX3ccbvF/pLIgpWPGiFM3Nr6ouAZcrgWObIe34rU3FtXa+U9gC1TCg81vIGr9C6YZ/iE+uiXZtmcXHfzdmo3Gr2XnoGtxYj6ypHrMHzqc1KkNypGJ5KaLCLUCv8oH0WePttrPNSFGLhrQPNt8jG3DZw9YIz8cl93qm644CM1jAs2DMzAKzUNuWs0+5E90SaMlB18LdvUmzbLuqd08xQ6vCMD3/jGLSi+f/PToxzyq+BHZGkmDSoibLI/pynU3rx6zdczEmj6FkiCAI98HQ/PBZDdAonqUHh3H7wcIEXFMUjK/W1llPA+WiG6o9mKjR/F7LL/4RK13fh+Mvmm7PpkKEdJQ2sdisaZ5U7qtxbw1G80CENIYPXB0IWrPSnqUqJi3rB4OCd7L9WAjvP1DN5UUHe1MQtRuC3xp1UbPO7oyKDEMKapjzpXb9VDj5bIje1RmsIFyJt7bUQVgmgcVV1a6Hjy6hytZDyU6mP7PEGIXotz95bdho3yb0Dz3//xbE7z+Y9+QFf0Kp6sNzaMBOGBD7LAfQwGIOzjTIT9ewoPG5rzCDasAVL+vdsuUfaRhrWlkP57rrfyHQ5KWQ5HjppioFHQqN8O8aOzY+xfVBK6hW+ekKWSyAU/XzFn4hwgQ9TfLUpdgcGNPmgH2MBC4IMbMqgu+4T1wD2PwxuLmN4nXrMSkb3IJYfC1pvdnFR2NGcN2TlErYs2kbnLE7bwHcieBRu7DAXjbuqrctTMKa3dCDp+EPKHXU4QBjHnRjfk1gPj1XP5PEmLHlAnNY2w/uxoOitXVB3LvvvKyP14sgXUFmmeqw2mdFonm8YNdhccHyY9zQJ9XjZi04bGw5l8K+dH/nK/kBUDjgD+U1oBVPbMByJ1j4KEyXOye68w3Xv9FaOr7iRY63veQZk+tXO8NMpezjTWlyNBai79kii9VtrSzC5BiJk7+t9e8JT+jeAbfWr5BnzO7uK6fYs/QhWo57fTkJG4hPkznuJv1BuRR7JfQFF3WC/7ntmBAQbNSLBgtANy2CNB5E6bYRI/Vm1qynvCyxpnIRnFGOHj0PrhQ3TByUuPjspKOCJF1G2dNPpwUpO7/NCFGrmD+0Nqgb9s5b+GztwAcuHPg6B0FTk/LtYoc/rrLYw1HGBDbRtnSpCHdgchxpEkPmy2ukmGTNpTu31T8EiWtubllRb6e7SmHgX86uVR5HKaarjetGufaetHbvtS0eoTEp6sY22u9BZ8+3p4EWchuEiAR2tEHGax3BZvPJo6gGryXBxtuwOn8IOLW/qa3MTcjR2HCdQetj8GBsYdhzRAPzP5aYA56WtNt+PWJ3o3aVvV0Szm+5FWHy5vGxpP6BvTUiwxQSHtGsrhpdZGJyQfQqQXvQrt0ADbZ+iErVNGGD02+LJxWE0BQ7jtMw/8yGrp2ZEEj4sI6LtDDjUD+8x8l29K/DSFGLgiAA4HWf371T0CDE8Qu84wL/zYZsXmuEpI+JS3DGkTpNYJ+ncDjY/D6f5VXtOH3IV3cu3LzvHdg4vjGLXztvXCpKiW5cWC6df5Zvj13v83GlyW76FTPfu92phjxI5Obn4CNbH8cKlNu9RkwTk6pZfk19eUb1Z863MOecRihe9ABKST6VCj4NMoemDA688jbDcKrGxux17eOhRyDiNk2ktg64q2xMDipRHpWmnWL5MgcoQXrD0FB1Asib0teCAGxK5w4EHAwhZ+FNzEArmPnC+GAyOIjb52UCJHahsb0lYq3TnlDVjOnQulzjSBWOORbVjL5cNKKpX9LQozciYDYNbVuO+e3IMrf1nvrB44YvmuKUw1dozg0hJdkmRJsCwADXMGajcvAri7fq/kfeHbLzHvne9a+C6BAOawhOWkO86ez9N+8XhG6JoVMTrQv6EbRfzNrSm0EmDxFRUcCsto7KGfFqLqD8yQl/QeV1fwJbPA+sY50gUC10gAtYJS6vm/jtpDeAUQ+jX46pkQZfCkeih5qflvXW6+fU+jbm/IpYlkH0AYiBfAhkc+2K4Uu++X63MEBy7+bSSZCdXcLJpF0d4g1e7vQA/mQb9KRLGdv0AildDD/2xNi5Ern+HKOADiwDkS5zso9MCxn2MFi2CevFiI8KSNbznCniQXWIWsGn7ShbPmmmU/fc2TFOQ3DPL/LzlYu0Ixg+XWudWNTTvWmyIjpeuIKgZ/LN+b+pyo5Nmqh1kdB/DAV9A0uG0+p0pdZCMmFSB0NLwtTo/iydkH4sbskh/cyixseVzrrYg9Nti9YZDeiJYAn+HjItZnQ9sJYebzoMgI09nE9qLU5RbX/guLmL6qaDTNJ3fpUxYAvCDHOG+W1Q/cjYNYafL3GGrljeCjQOFVxBK+SJOXS3OHSU7zozVufkUbfcuuE6nEtT45aNijXOV8/pJMGleSk5IusQMF7YsvsotqqNRutX0ty+ncMvaWebI29LyTXphagKqm+EBAeV+3eksLDnZpN2A3nm+Fj2xQ16yzNbxKBkqd/SiWk+9fwILtddmTl6KF6itqA8JARhIhg4lyDNEcR6I1QD6l9E3eLdUk5C1RHq18QYuL1ZXz36E8adrPnUPU5a9je0/0tB6c5PY7rwZK+ueovBW/UO41FC/584B/pTplQORsACOjidhXdBd6WhBvK1qggBszSNRsHR4WUBLwLGyNsND85p+hoj97iXdpG9gCkrWM81JAW3ScksDsUM3SlrHpzOG16lnqQK3DpCtkpyYyAMXcLEwFMHiXwDAb1QGlKNwJSNlBuRySC7sIdtJsHFiNfw6OQE2+p2CC9Oqv44J+SeGWdVTCOgxUbnN9F3sKXZMeA29ds5LkAQ65Bm02Qak/DO1gEIlWMcNM2oZidkMdU+uioC5E/jZRtOFEox2RK5QtCTGm5sMT787b79ueR0uAJ6fQPzsnOar4+w68/u/Si0a9d+dHB23Kbgj++2VH5wUoAAnpousnQA1ttTSCDBrJbND1iHS2ucLYmpeFZbC9yWQI/iiDP3wS9RJAwWKfdYJ3u5KZ2XVtcPZGyYgWs4gGEXvwrHiZ7X2H02Ej5hNOlxeVyUu6TpAvW4R3kuKBnuh06e1zBJ0f6G84XjoxRiM8xHUiZN1NN7jqruPa1VRu9F0PJ+xPIndfBtjiT4guiX5pHjRFq/lGjcuR5SluX9KBjVMTbfNfQWj14rf9MtZ0vCDHVFYuoDxvl+8g18D6AA/yp164c/8KQMTln6YFfF5u7zrpnUemBxWVlMYWxOUX7CRo3oQ9dx3y0pOjgfzFGP7S9EL85qgCr+RQ+op9elVlFBymQbp+D6UZ3XlJ0CGr+7uOlem2R6HyIM9MGPir91lzOylLSg9jPzSnyAWLmu7ayegyimjcPUJhD0rXG5r7Ya6PncePkQ9Akx55HogX//2eYowJf8E7nAAAAAElFTkSuQmCC' style='margin-top:20px;width:90px;float:right;z-index:auto'/>";*/
        $Signature .= '<div><strong>Procurement Department</strong></div>';
        $Signature .= '<div><strong>Prizm Energy</strong></div>';
        $Signature .= "<div><strong>Tel:</strong> <a href='tel:+971 4 5896400'>+971 4 5896400</a></div>";
        $Signature .= "<div><strong>Email:</strong> <a href='mailto:Procurement@prizm-energy.com'>Procurement@prizm-energy.com</a></div>";
        $Signature .= '<div></div>';
        $Signature .= "<div><strong>Web:</strong> <a href='https://www.prizm-energy.com'>www.prizm-energy.com</a></div>";
        $Signature .= '<div>3707 Churchill Tower, Business Bay</div>';
        $Signature .= '<div>Dubai, UAE</div>';
        $Signature .= '<hr />';
        $Signature .= '<div>This message contains confidential information and is intended only for the intended recipients. If you are not an intended recipient you should not disseminate, distribute or copy this e-mail. Please notify us immediately by the e-mail if you have received this e-mail by mistake and delete this e-mail from your system. E-mail transmission cannot be guaranteed to be secure or error-free as information could be intercepted, corrupted, lost, destroyed, arrive late or incomplete, or contain viruses. Therefor we do not accept liability for any errors or omissions in the contents of this message, which arise as a result of e-mail transmission. If verification is required please request a hard-copy version.</div>';
        $headers .= "MIME-Version: 1.0\r\n"; // Defining the MIME version
        $headers .= 'Content-Type: multipart/mixed;'; // Defining Content-Type
        $headers .= "boundary = $boundary\r\n"; //Defining the Boundary

        $resp = [];

        foreach ($RFQSuppliers as $RFQSupplier) {  


            $Greetings = '';
            $SupplierName = '';

            $theNotes =   str_replace("<p>","<br>",str_replace("</p>","",$RFQ->note));

if(str_contains($RFQ->note , "dear") || str_contains($RFQ->note , "Dear") || str_contains($RFQ->note , "DEAR")){
    if ($RFQSupplier->firstname == '' || empty($RFQSupplier->firstname) || $RFQSupplier->firstname == null) {
        $SupplierName = 'Supplier';
    } else {
        $SupplierName = $RFQSupplier->firstname . ' ' . $RFQSupplier->lastname;
    }

    $Message = $firstPiece."<br><p style='margin-left:20px;'>".$theNotes."</p><br />";

}else{
            if ($RFQSupplier->firstname == '' || empty($RFQSupplier->firstname) || $RFQSupplier->firstname == null) {
                $Greetings = "<b style='margin-left:20px;'>Dear Sir,</b><br><br>Greeting from Prizm Energy..";
                $SupplierName = 'Supplier';
            } else {
                $Greetings = "<b style='margin-left:20px;'>Dear " .( $fromEmail == 2 ? "[Supplier' name goes here]" : $RFQSupplier->firstname . " " . $RFQSupplier->lastname).",</b><br><br><b style='margin-left:20px;'>Greeting from Prizm Energy..</b>";
                $SupplierName = $RFQSupplier->firstname . ' ' . $RFQSupplier->lastname;
            }
            $Greetings .= "<br/><b style='margin-left:20px;'>We Kindly Asking for Inquirey about the following Items shown in the table below :</b>";
            $Message = $firstPiece."<br>".$Greetings." <br/><p style='margin-left:20px;'>".$theNotes."</p><br />";
    }






          //$Message .= "<br><br>".$firstPiece;
            $Message .= $html_first_half;
          //$Message .= "<p style='font-weight: 600; font-size: 0.9rem; margin: 0; --tw-text-opacity: 1; color: #7f8b9d;text-align: end;'>".$SupplierName."</p>";
            $Message .= $SupplierName;
            $Message .= $html_second_half;
            $Message .= ' <br/> <br />' .'' /* $RFQ->note */ . '<br/>' . $Signature . '';


            //$SupplierName = '';
            //if ($RFQSupplier->firstname == '' || empty($RFQSupplier->firstname) || $RFQSupplier->firstname == null) {
            //    $Greetings = 'Hello';
            //} else {
            //    $Greetings = 'Dear ' . $RFQSupplier->firstname . ' ' . $RFQSupplier->lastname;
            //}

            //$Message = $Greetings. ' <br/> <br />';


            //$Message .= $html;

            //$Message .= ' <br/> <br />' .'' /* $RFQ->note */ . '<br/>' . $Signature . '';


            ////$Message = $Greetings . ' <br/> <br />' . $RFQ->note . '<br/>' . $Signature . '';

            if($fromEmail == 2){
            //file_put_contents($temporary_html_file_preview, $Message);
            return $Message; //module_dir_path(rfq_MODULE_NAME, 'media/buffers/SupplierInquiries/' ). $excelExactfilename . '_preview.html'; 
            }


            if ($this->SendRFQMail($RFQSupplier->email, $SupplierName, $subject, $Message, $RFQFiles, $EmailCCUsers,$imbededImagePath)) {
                $Success = true;
            } else {
                $Success = false;
            }
        }
/*
        $RFQSupplierContacts = $this->suppliers_model->get_rfq_supplier_contacts('', $RFQId);         
            foreach ($RFQSupplierContacts as $RFQSupplierContact) {
            $SupplierName = '';
            $SupplierContact = $this->suppliers_model->get_supplier_contact($RFQSupplierContact->supplier_contact_id);
            if ($SupplierContact != null) {
                if ($SupplierContact->firstname == '' || empty($SupplierContact->firstname) || $SupplierContact->firstname == null) {
                    $Greetings = 'Hello';
                } else {
                    $Greetings = 'Dear ' . $SupplierContact->firstname . ' ' . $SupplierContact->lastname;
                }
                $Message =
                    $Greetings .
                    ' <br/> <br />' .
                    $RFQ->note .
                    "
                    <br/>
                    " .
                    $Signature .
                    '';
                // $SupplierName = "";
                // if ($SupplierContact->firstname=="" || empty($SupplierContact->firstname )
                // || $SupplierContact->firstname==null)
                // $SupplierName ="Hello";
                // else
                // $SupplierName =$SupplierContact->firstname.' '.$SupplierContact->lastname;

                // $Message="  ".$SupplierName." <br/> <br />".$RFQ->note."

                // <br/>
                // ". $Signature."";

                if ($this->SendRFQMail($SupplierContact->email, $SupplierName, $subject, $Message, $RFQFiles, $EmailCCUsers)) {
                    $Success = true;
                } else {
                    $Success = false;
                }
            }
        } 
*/
//$resp = [];
//echo "succ is : ".$Success;
        if ($Success) {
            //echo "OKkkkkk";
            $result =$this->Rfq_model->update(['Acceptance'=>'Accepted'],$RFQId);
            $resp['status'] = 'success';
            $resp['success'] = true;
            echo json_encode($resp);
        } else {
            $resp['status'] = 'failed';
            $resp['success'] = false;
            echo json_encode($resp);
        }
        //return json_encode($resp);
        //echo json_encode($resp);
        //End Send Mail Block

    }

    //End send_inquery




































    function SendRFQMail($ReceiverMail,$ReseiverName,$Subject,$Body,$Attachements,$EmailCCUsers,$imbededImagepath)

{
    $mail = new PHPMailer(true);

    //echo "---".print_r($EmailCCUsers)."---";
    
    try {
    
        
      ////Server settings
      ////$mail->SMTPDebug = 0;                      //Enable verbose debug output
      ////$mail->SMTPDebug = false;
      ////$mail->do_debug = 0;


      //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
      
      $mail->isSMTP();
      $mail->SMTPAuth = true;
    //$mail->Host       = 'smtp-mail.outlook.com';                     //Set the SMTP server to send through    
      $mail->Host = "smtp.gmail.com";
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
      $mail->Port = 587;
      //$mail->Username   = 'Procurement@prizm-energy.com';                     //SMTP username
      $mail->Username = "techani31999@gmail.com";
      //$mail->Password   = 'Bab99269';                               //SMTP password
      $mail->Password = "xappqkxhlovddvzx";
    
    
    ////Recipients
    ////$mail->setFrom('khalied@ksa.com', 'Khalied');
    $mail->setFrom('Procurement@prizm-energy.com', 'Prizm Energy');
    $mail->addAddress(($ReceiverMail=="" ? "khalied@ksa.com" : $ReceiverMail), ($ReseiverName=="" ? "Prizm Energy\' Supplier" : $ReseiverName));     //Add a recipient
    //$mail->addAddress("Khalied.Battran@prizm-energy.com", "khalied");
    
        
        
        
        
        
        
        //// $mail->addReplyTo('info@example.com', 'Information');
        foreach($EmailCCUsers as $EmailCCUser){
            //$EmailCCUser["email"] = "Khalied.Battran@prizm-energy.com";
        $mail->addCC($EmailCCUser["email"],$EmailCCUser["firstname"]." ".$EmailCCUser["lastname"]);
        //// $mail->addBCC('bcc@example.com');
        }
    /* print_r($EmailCCUser);
    exit(0); */
    
        ////Attachments
    
    
        //foreach($Attachements as $key -> $Attachment)
         //$mail->addAttachment($Attachment);         //Add attachments
         ////FCPATH : Gives => C:\xampp\htdocs\ProjectFolder\
         $mail->AddEmbeddedImage(FCPATH.$imbededImagepath, 'logo_2prizm');
        ////$mail->AddEmbeddedImage(module_dir_path(rfq_MODULE_NAME, '../../'.$imbededImagepath ), 'logo_2prizm');
        ////$mail->addAttachment(module_dir_path(rfq_MODULE_NAME, ''.$imbededImagepath ), 'RFQ-23000001-1.pdf');
        ////$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
    
    
    
        ////Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $Subject;
        $mail->Body    = $Body;
        ////$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        $mail->send();
        return true;
    } catch (Exception $e) {
    return false;
        ////"Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}


















public function reject_inquery($id='')
{

if($id != ''){
    $result =$this->Rfq_model->update(['Acceptance'=>'Rejected'],$id);
    $resp['status'] = 'Rejected';
    $resp['success'] = true;
    //return json_encode($resp);
echo json_encode($resp);
}

}













    public function replaceBookmark($word, $bookmarkname, $bookmarktext)
    {
        $objBookmark = $word->ActiveDocument->Bookmarks($bookmarkname);
        $range = $objBookmark->Range;
        $range->Text = $bookmarktext;
    }

    function SendMail($ReceiverMail, $ReseiverName, $Subject, $Body, $Attachements, $EmailCCUsers, $ReplayEmail)
    {
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER; //Enable verbose debug output
            $mail->isSMTP(); //Send using SMTP
            $mail->Host = 'smtp-mail.outlook.com'; //Set the SMTP server to send through
            $mail->SMTPAuth = true; //Enable SMTP authentication
            $mail->Username = 'procurement@prizm-energy.com'; //SMTP username
            $mail->Password = 'Bab99269'; //SMTP password
            // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            $mail->SMTPDebug = false;
            $mail->do_debug = 0;
            // $mail->ClearReplyTos();
            // $mail->addReplyTo(example@example.com, 'EXAMPLE');
            //Recipients
            $mail->setFrom('procurement@prizm-energy.com', 'Prizm Energy');
            //foreach($ReceiverMail as $key=>$value)

            $keys = array_keys($ReceiverMail);
            for ($i = 0; $i < count($ReceiverMail); $i++) {
                // echo $keys[$i] . "<br>";
                foreach ($ReceiverMail[$keys[$i]] as $key => $value) {
                    // echo $keys[$i] . " : " . $key . "<br>";
                    $mail->addAddress($key, $keys[$i]);
                }
            }
            //Add a recipient
            // $mail->addAddress('ellen@example.com');               //Name is optional
            $mail->addReplyTo($ReplayEmail['email'], $ReplayEmail['name']);
            // foreach($EmailCCUsers as $EmailCCUser)
            $keys1 = array_keys($EmailCCUsers);
            for ($i = 0; $i < count($EmailCCUsers); $i++) {
                // echo $keys[$i] . "<br>";
                foreach ($EmailCCUsers[$keys1[$i]] as $key => $value) {
                    // echo $keys[$i] . " : " . $key . "<br>";
                    $mail->addCC($key, $keys1[$i]);
                }
            }
            //Attachments
            foreach ($Attachements as $Attachment) {
                $mail->addAttachment($Attachment);
            } //Add attachments
            $mail->isHTML(true); //Set email format to HTML
            $mail->Subject = $Subject;
            $mail->Body = $Body;

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
            //"Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

        function SendRFQMail($ReceiverMail, $ReseiverName, $Subject, $Body, $Attachements, $EmailCCUsers)
        {
            $mail = new PHPMailer(true);
            try {
                //Server settings
                $mail->SMTPDebug = SMTP::DEBUG_SERVER; //Enable verbose debug output
                $mail->isSMTP(); //Send using SMTP
                $mail->Host = 'smtp-mail.outlook.com'; //Set the SMTP server to send through
                $mail->SMTPAuth = true; //Enable SMTP authentication
                $mail->Username = 'Procurement@prizm-energy.com'; //SMTP username
                $mail->Password = 'Bab99269'; //SMTP password
                $mail->Port = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                $mail->SMTPDebug = false;
                $mail->do_debug = 0;
                //Recipients
                $mail->setFrom('Procurement@prizm-energy.com', 'Prizm Energy');

                $mail->addAddress($ReceiverMail, $ReseiverName); //Add a recipient
                foreach ($EmailCCUsers as $EmailCCUser) {
                    $mail->addCC($EmailCCUser['email'], $EmailCCUser['firstname'] . ' ' . $EmailCCUser['lastname']);
                }
                //Attachments
                foreach ($Attachements as $Attachment) {
                    $mail->addAttachment($Attachment);
                } //Add attachments

                //Content

                $mail->isHTML(true); //Set email format to HTML
                $mail->Subject = $Subject;
                $mail->Body = $Body;
                //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
                $mail->send();
                return true;
            } catch (Exception $e) {
                return false;
                //"Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    }
}

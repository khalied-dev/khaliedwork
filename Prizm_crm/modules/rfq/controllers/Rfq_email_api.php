<?php
defined('BASEPATH') or exit('No direct script access allowed');
use Dompdf\Dompdf;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PhpOffice\PhpSpreadsheet\IOFactory;

// define('POROJECTS_SECTION', '1');
// define('OPPORTUNITIES_SECTION', '2');
// define('ADMIN_SECTION', '3');

class Rfq_email_api  extends  App_Controller
{



    public function __construct() {

        hooks()->do_action('after_clients_area_init', $this);
        parent::__construct();
        $this->load->model('Rfq_model');
        $this->load->model('suppliers_model');
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
    public function rfq($id = '', $fromEmail = 0)
    {
/* 
        echo "data Array is : <br>";
        $data = $this->input->post();
        echo $fromEmail."--------".$isToUpdate;
        //echo $data['EmailSubject'];
        //print_r($data['EmailSubject']);
        exit(0);

 */
        if (!is_numeric($id)) {
            if ($this->input->post()) {
            // Do Add' Block    
                $data = $this->input->post();
                $id = $this->Rfq_model->add_RFQ($data);
                //$this->load->view('Rfq/manage');
                $this->session->set_flashdata('addedid',$id);
                redirect(admin_url('rfq/'));
            }
            $data['members'] = $this->staff_model->get();
            $data['suppliers'] = $this->suppliers_model->get();
            $data['staff'] = $this->staff_model->get(['active = 1']);
            // $data['id'] = $id;         
            $data['title'] = _l('rfq_list');
            
                        //echo "here";
                        //exit(0);
            
        }else{ 
            if($this->input->post()){
            // Do Update' Block
            $data = $this->input->post();
            $id = $this->Rfq_model->update_RFQ($data);
            //$this->load->view('Rfq/manage');
            //$this->session->set_flashdata('updatedid',$id);
            //redirect(admin_url('rfq/'));
             }
            $data['rfqRow'] = $this->Rfq_model->get($id);
            $data['rfqTemplates'] = $this->Rfq_model->get_RFQTemplates($id);
            $data['suppliers'] = $this->suppliers_model->get_selected_rfq_supplier($id);
            $data['staff'] = $this->Rfq_model->get_selected_rfq_staff($id);
            $data['members'] = $this->staff_model->get();
            $data['id'] = $id;

/* 
if($isToDelete == '1' || $isToDelete == 1){
close_setup_menu();
$data['deletedid'] = $this->Rfq_model->delete_RFQ($data);
$data['title'] = _l('rfq_list');
$this->load->view('Rfq/manage',$data);
}
*/
        }


        $data['title'] = _l('rfq');
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
        else
        $this->load->view('rfq/Rfq/rfq', $data);

        // $this->load->view(module_views_path('rfq','RFQ/rfq', $data));
    }











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
            $html .= "<img src='" . base_url('uploads/company/' . $company_logo)."' style='margin-top:20px;width:90px;float:left;z-index:auto'/>";
            //$html .= "<img src='http://localhost/Prizm_crm/uploads/company/fd1989935b085ada5b493ebe2778362d.jpg' style='margin-top:20px;width:90px;float:left;z-index:auto'/>";
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
$imbededImagePath = 'uploads/company/fd1989935b085ada5b493ebe2778362d.jpg';
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
            <table align='center' border='0' cellpadding='0' cellspacing='0' style='width:85%'>
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
    Inquery Date: ".date('M y')."<br>Sale Agent: </p>
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
        /*$Signature.="<img src='data:image/png;base64,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' style='margin-top:20px;width:90px;float:right;z-index:auto'/>";*/
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











}

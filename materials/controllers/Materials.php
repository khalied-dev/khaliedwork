<?php
defined('BASEPATH') or exit('No direct script access allowed');

require __DIR__ . '../../vendor/autoload.php';
require __DIR__ . '../../third_party/Davincho/Tabula/Tabula.php';

use Davincho\Tabula\Tabula;
/**
 * Memtion Controller
 */
class materials extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Material_model');
        $this->load->model('staff_model');
        $this->load->model('projects_model');
        $this->load->model('Leads_model');
    }

    /**
     * Start Dewa RFxs' Scrape.
     *
     * @author  @MustafaZaroug
     * @version 1.0
     * @since   2023-05-24
     */

    public function extract_dewa_rfx_materials($RFxNo = '')
    {
        $data_model['remarks'] = $RFxNo;

        $filename = preg_replace('/\s+/', '', $RFxNo) . '.pdf';

        $local_file = module_dir_path(ADVANCELEADS_MODULE_NAME, 'media/buffers/' . $filename);

        if (!is_dir(module_dir_path(ADVANCELEADS_MODULE_NAME, 'media/buffers/'))) {
            mkdir(module_dir_path(ADVANCELEADS_MODULE_NAME, 'media/buffers/'), 0777, true);
        }
        if (!file_exists($local_file)) {
            // echo 'exists<br>';
            return;
        }
        // Specify the path to the folder containing CSV files
        $folderPath = module_dir_path(ADVANCELEADS_MODULE_NAME, 'media/buffers/');

        // Get the list of CSV files in the folder
        $pdfFiles = glob($folderPath . $RFxNo . '.pdf');
        //var_dump ($pdfFiles);
        // Iterate over the CSV files
        $onefiledata = [];
        $index = 0;
        foreach ($pdfFiles as $pdfFile) {
            // Load and process each CSV file
            //echo "Processing file: $pdfFile\n";

            // Read the CSV file into an array
            // Perform any desired operations on the CSV data
            // ...
            // Instantiate the TabulaPdfWrapper
            $file = $pdfFile;
            $tabulaWrapper = new \Davincho\Tabula\Tabula($file);

            // Extract tables from the PDF
            $tables = $tabulaWrapper->parse();

            // Specify the path to the CSV file

            $csvFile = $file . '.csv';
            $data = [];
            if (($handle = fopen($csvFile, 'r')) !== false) {
                while (($row = fgetcsv($handle)) !== false) {
                    $data[] = $row;
                }
                fclose($handle);
            }
            // Specify the keywords to remove lines
            $keywords = ['SUPPLIER\'S', 'SL', 'REQUEST'];

            // Read the CSV file into an array
            for ($i = 0; $i < count($data); $i++) {
                //$data[$i][1] = trim($data[$i][1]);
                $startsWithKeyword = false;
                // Merge the line without SLN value into the upper line
                foreach ($keywords as $keyword) {
                    if (strpos($data[$i][0], $keyword) !== false) {
                        $startsWithKeyword = true;
                    }
                }
                if ($startsWithKeyword) {
                    //         unset($lines[$key]);
                    for ($j = 0; $j < count($data[$i]); $j++) {
                        $data[$i][$j] = '';
                        // Remove the line without SLN value
                        //unset($data[$i]);
                        //$i--;
                    };
                }
            }
            // Iterate over the array and merge lines without an SLN value
            for ($i = count($data) - 1; $i > 0; $i--) {
                if (empty($data[$i][0])) {
                    // Merge the line without SLN value into the upper line
                    if (!empty($data[$i][3]) && !empty($data[$i - 1][3])) {
                        $data[$i - 1][3] .= '' . $data[$i][3];
                    }
                    // Remove the line without SLN value
                    unset($data[$i]);
                }
            }
            // Iterate over the array and merge lines without an SLN value
            for ($i = 0; $i < count($data); $i++) {
                if (empty($data[$i][0])) {
                    // Remove the line without SLN value
                    unset($data[$i]);
                }
            }
            $outputFilename = $pdfFile . '.csv';
            $outputHandle = fopen($outputFilename, 'w');
            foreach ($data as $row) {
                fputcsv($outputHandle, $row);
            }
            fclose($outputHandle);
            $i = 0;
            $csvFile = $outputFilename;
            $datanew = [];
            if (($handle = fopen($csvFile, 'r')) !== false) {
                while (($row = fgetcsv($handle)) !== false) {
                    $datanew[] = $row;
                }
                fclose($handle);
            }

            // Iterate over the array and merge lines without an SLN value
            for ($i = 0; $i < count($datanew); $i++) {
                // Merge the line without SLN value into the upper line
                // Remove the line without SLN value
                if (!empty($datanew[$i][3])) {
                    // Generate HTML table markup
                    $z = 0;
                    $MaterialAttributes = $this->extractkeys($datanew[$i][3]);
                    if (!empty(key($MaterialAttributes))) {
                        $is_material_found = false;
                        $materials = $this->Material_model->get_material('',"remarks = '".$RFxNo."' and partner_item_name like '%".$this->validMySQL(key($MaterialAttributes))."%'");
                        foreach($materials as $material)
                        {
                           $material_metadata= $this->Material_model->
                                    get_material_metadata('',"material_id = ".$material['id']."");
                                $db_material_metadata = array();
                                foreach($material_metadata as $material_attributes)
                                {
                                    $db_material_metadata[] = array('meta_field'=>$material_attributes['meta_field'],
                                                                'meta_value'=>$material_attributes['meta_value']);
                                }
                                
                                if (ksort($db_material_metadata)==ksort($db_material_metadata))
                                {
                                    $is_material_found=true;
                                    continue;
                                }
                        
                        }
                        if ($is_material_found) continue;
                        $data_model['staff_id'] = get_staff_user_id();
                        $data_model['remarks'] = $RFxNo;
                        $data_model['category_id'] = null;
                        $data_model['partner'] = 'DEWA';
                        $data_model['partner_item_code'] = $this->validMySQL($datanew[$i][1]);
                        $data_model['item_code'] = '';
                        $data_model['item_name'] = $this->validMySQL(key($MaterialAttributes));
                        $data_model['partner_item_name'] = $this->validMySQL(key($MaterialAttributes));

                        $inserted_id = $this->Material_model->add_Material($data_model);
                        unset($data_model);
                        foreach ($MaterialAttributes as $key => $value) {
                            if ($z == 0) {
                                $z++;
                                continue;
                            }
                            if (!empty($key) && isset($key)) {
                                $onefiledata[$i + $index][$z] = $key;
                                if (is_numeric($inserted_id)) {
                                    $data_model['material_id'] = $inserted_id;
                                    $data_model['meta_field'] = $this->validMySQL($key);
                                    $data_model['meta_value'] = $this->validMySQL($value);
                                    $inserted_metadata_id = $this->Material_model->add_material_metadata($data_model);
                                    unset($data_model);
                                }
                                $z++;
                            }
                        }
                        $index++;
                        if ($i == count($datanew) - 1) {
                            $index++;
                        }
                    }
                }
            }
            // Write the modified array back to the CSV file
            $outputFilename = $pdfFile . '.csv';
            $outputHandle = fopen($outputFilename, 'w');
            foreach ($datanew as $row) {
                fputcsv($outputHandle, $row);
            }
            fclose($outputHandle);
        }
    }

    public function extractkeys($str)
    {
        $text = $str;
        // Rectify typos
        $text = str_replace('CL ASS', 'CLASS', $text);

        $parts = explode(';', $text);

        $result = [];
        $currentKey = '';
        foreach ($parts as $part) {
            $keyValuePair = explode(':', $part, 2);
            if (count($keyValuePair) === 2) {
                $subkeyValuePair = explode('_', $part, 2);
                if (count($subkeyValuePair) === 2) {
                    $key = trim($subkeyValuePair[0]);
                    $value = null;
                    $result[$key] = trim($value);
                    $subkeyValuePair[1] = trim(str_replace(':', '', $subkeyValuePair[1]));
                    $key = trim(str_replace($keyValuePair[1], '', $subkeyValuePair[1]));

                    $value = trim($keyValuePair[1]);
                    $result[$key] = trim($value);

                    $currentKey = '';
                } else {
                    $key = trim($keyValuePair[0]);
                    $value = trim($keyValuePair[1]);
                    $result[$key] = trim($value);

                    $currentKey = '';
                }
            } else {
                if (empty($currentKey)) {
                    $key = trim($part);
                    if (strtolower($key) === 'class') {
                        $currentKey = trim($key);
                    } else {
                        $currentKey = '';
                        $value = null;
                        $result[$key] = trim($value);
                    }
                }
            }
        }

        if (!empty($currentKey)) {
            $result[$currentKey] = null;
        }

        return $result;
    }

    /**
     * End Dewa RFxs' Scrape.
     */


      /**
     * Start validMySQL.
     *
     * @author  @MustafaZaroug
     * @version 1.0
     * @since   2023-06-01
     */
     public function validMySQL($var) {
        $var=stripslashes($var);
        $var=htmlentities($var);
        $var=strip_tags($var);
        $var=str_replace("'", '', $var);
        $var=str_replace('"', '', $var);
        // $var=$this->seo_friendly_url($var);
        return $var;
    }

    /**
     * End ValidateMySQL.
     */

/**
     * Start seo_friendly_url.
     *
     * @author  @MustafaZaroug
     * @version 1.0
     * @since   2023-06-01
     */
    public function seo_friendly_url($string){
        $string = str_replace(array('[\', \']'), '', $string);
        $string = preg_replace('/\[.*\]/U', '', $string);
        $string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);
        $string = htmlentities($string, ENT_COMPAT, 'utf-8');
        $string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string );
        $string = preg_replace(array('/[^a-z0-9]/i', '/[-]+/') , '-', $string);
        return strtolower(trim($string, '-'));
    }
/**
     * End seo_friendly_url
     */

    /**
     * index page
     * @return
     */
    public function index()
    {

        $data['title'] = _l('Materials');

        $this->load->view(MATERIALS_FOLDER . '/manage', $data);
    }

    public function managefieldsgroups()
    {

        $data['title'] = _l('Meta fields\' Groups');

        $this->load->view(MATERIALS_FOLDER . '/managefieldsgroups', $data);
    }




public function scrapping_dewa_rfx_folder()
{
            //  Specify the path to the folder containing CSV files
         $folderPath = module_dir_path(ADVANCELEADS_MODULE_NAME, 'media/buffers/');
         // Get the list of CSV files in the folder
        //  $pdfFiles = glob($folderPath . $RFxNo . '.pdf');
        $pdfFiles = glob($folderPath . '*.pdf');
        
        ini_set('max_execution_time', '0'); // for infinite time of execution 

foreach ($pdfFiles as $file) {
    
    // Remove the ".php" extension from the filename
    $RFxNo = str_replace('.pdf', '',  basename($file));
    //$number = '2412345678'; // The number to check

    $prefixes = array('201', '241', '249');
    
    $startsWithDesiredPrefix = false;
    foreach ($prefixes as $prefix) {
        if (substr($RFxNo, 0, strlen($prefix)) === $prefix) {
            $startsWithDesiredPrefix = true;
            break;
        }
    }
    
    if ($startsWithDesiredPrefix) {
        // $rfx='2012205636';//2012205636 2012302509
        $this->extract_dewa_rfx_materials($RFxNo);
    }
}
}
    public function table($id = '')
    {


//cleaning string $id which contains 'search_key' ,  cleaning it from commas ','
        
     if(isset($id) && $id != ''){

        $ID = $id;/* str_replace( array( '\'', '"',
',' , ';', '<', '>' ), ' ', $id); */  

        $this->app->get_table_data(module_views_path(MATERIALS_FOLDER, 'tables/materials_insider'), ['search_key'=>$ID]); 
     }else
        $this->app->get_table_data(module_views_path(MATERIALS_FOLDER, 'tables/materials'));
    }

    public function tablerfx($id = '')
    {
        
        $ID = $id; /* str_replace( array( '\'', '"',
',' , ';', '<', '>' ), ' ', $id); */  

        $this->app->get_table_data(module_views_path(MATERIALS_FOLDER, 'tables/rfxs'), ['search_key'=>$ID]);
    }


/*     public function tablerfx_detailed($id = '')
    {
        $this->app->get_table_data(module_views_path(MATERIALS_FOLDER, 'tables/rfx_detailed'), ['search_key'=>$id]);
    } */


    public function table_fields_groups($id = '')
    {
        
        $this->app->get_table_data(module_views_path(MATERIALS_FOLDER, 'tables/materials_metafields_groups'));
    }





















public function view($id){

    if (staff_can('view', 'materials')) {

            //then view:
            close_setup_menu();

            $material = $this->Material_model->get_material($id);
            $material_metadata = $this->Material_model->get_material_metadata('',"material_id = ".$id."");
            


            $data['title'] = _l('View Material');
            $data['material']=$material;
            $data['material_metadata']=$material_metadata;



            //echo "<h1>".$material->id."</h1>";
            //echo "<h1><br>".$id."</h1>";
            //exit(1);




/* 
//getting Meta Fields' Specifications/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$master_general_fields_specifier = $this->master_general_fieldsSpecifier($id) ;
$data['materialMetaDataMasterFields_correspondNumOfAppearenceForEach']=$master_general_fields_specifier[0];//$theMasterFields_arr;
$data['materialMetaDataGeneralFields_correspondNumOfAppearenceForEach']=$master_general_fields_specifier[1];//$theGeneralFields_arr;
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
 */








            $this->load->view(MATERIALS_FOLDER.'/view', $data);    

   
} else{
    access_denied('Material Edite');
} 

} 















    public function edit($id)
    {
         if (staff_can('edit', 'materials')) { 

            if ($this->input->post()) {

            close_setup_menu();
            


            //do edit:
            //////////////////////

            $data = $this->input->post();
            $data['remarks'] = html_purify($this->input->post('remarks', false));

//echo "<h1>".$data['item_name']."</h1>";
//exit();
            $id = $this->Material_model->update_material($data,$id);
            if ($id) {
            set_alert('success', _l('updated_successfully', _l('Material')));
            //$data['title'] = _l('Edit Material');

            //then just Re-view:
            close_setup_menu();
            //$material = $this->Material_model->get_material($id);
            //$material_metadata = $this->Material_model->
            //get_material_metadata('',"material_id = ".$id."");
            //$data['material']=$material;
            //$data['material_metadata']=$material_metadata;
            //$this->load->view(MATERIALS_FOLDER.'/edit', $data);
            $this->load->view(MATERIALS_FOLDER.'/manage');


                //$this->load->view('costcenters/manage',$data);
                // redirect(admin_url('costcenters/sections/' . $section));
            }else{

            //then just Re-view:
            set_alert('fail', _l('updated_Unsuccessfully', _l('Material')));
            $data['title'] = _l('Edit Material');
            close_setup_menu();
            $material = $this->Material_model->get_material($id);
            $material_metadata = $this->Material_model->get_material_metadata('',"material_id = ".$id."");

            $data['material']=$material;
            $data['material_metadata']=$material_metadata;

            $this->load->view(MATERIALS_FOLDER.'/edit', $data);
            }



            }//end if
            else{
                //then view:
                close_setup_menu();
                //echo "<h1>has no</h1>";
                //exit(1);
                $material = $this->Material_model->get_material($id);
                $material_metadata = $this->Material_model->
                get_material_metadata('',"material_id = ".$id."");
                $data['title'] = _l('Edit Material');
                $data['material']=$material;
                $data['material_metadata']=$material_metadata;
                $this->load->view(MATERIALS_FOLDER.'/edit', $data);    
            }
       
    } else{
        access_denied('Material Edite');
    
    } 
}












































public function edit_metafields_groups($id){
    if (staff_can('edit', 'materials')) { 

        if ($this->input->post()) {
        close_setup_menu();
        //do edit:
        $data = $this->input->post();
        $data['group_details'] = html_purify($this->input->post('group_details', false));

        $id = $this->Material_model->update_metafields_groups($data, $id);
        if ($id) {
        set_alert('success', _l('updated_successfully', _l('Meta field\' Group')));
        //$data['title'] = _l('Edit Material');

        //then just Re-view:
        close_setup_menu();
        $this->load->view(MATERIALS_FOLDER.'/managefieldsgroups');

        }else{

        //then just Re-view:
        set_alert('fail', _l('updated_Unsuccessfully', _l('Meta field\' Group')));
        $data['title'] = _l('Edit Meta fields\' Groups');
        close_setup_menu();
        $metafields_groups = $this->Material_model->get_metafields_groups($id);
        $data['metafields_groups']=$metafields_groups;
        $this->load->view(MATERIALS_FOLDER.'/editfieldsgroups', $data);
        }



        }//end if
        else{
            //then view:
            close_setup_menu();
            $data['title'] = _l('Edit Meta fields\' Groups');
        $metafields_groups = $this->Material_model->get_metafields_groups($id);
        $data['metafields_groups']=$metafields_groups;
            $this->load->view(MATERIALS_FOLDER.'/editfieldsgroups', $data);    
        }
   
} else{
    access_denied('Material Edite');

} 
}


















public function delete_metafields_groups($id){

        $id = $this->Material_model->delete_metafields_groups($id);


        //then just Re-view:
        close_setup_menu();
        
        if($id)
        set_alert('success', _l('Deleted Successfully', _l('Meta field\' Group')));
        else
        set_alert('info', _l('UNsuccessfully Delete', _l('Meta field\' Group')));

        $this->load->view(MATERIALS_FOLDER.'/managefieldsgroups');

}


















    public function view_details($id)
    {

        if (staff_can('view', 'materials')) {
            close_setup_menu();
            $material = $this->Material_model->get_material($id);
            $material_metadata = $this->Material_model->
            get_material_metadata('',"material_id = ".$id."");
            $data['material']=$material;
            $data['material_metadata']=$material_metadata;
          
//getting Meta Fields' Specifications/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$master_general_fields_specifier = $this->master_general_fieldsSpecifier($id) ;
$data['materialMetaDataMasterFields_correspondNumOfAppearenceForEach']=$master_general_fields_specifier[0];//$theMasterFields_arr;
$data['materialMetaDataGeneralFields_correspondNumOfAppearenceForEach']=$master_general_fields_specifier[1];//$theGeneralFields_arr;
$data['numof_item_name']=$master_general_fields_specifier[2];//$theGeneralFields_arr;
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//getting ignored Meta Fields' Specifications/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$data['ignored_fields'] = array();

$ignored_master_fields = $this->master_general_fields_ignoredFieldsSpecifier($id,0);
array_push($data['ignored_fields'],$ignored_master_fields);

$ignored_general_fields = $this->master_general_fields_ignoredFieldsSpecifier($id,1);
array_push($data['ignored_fields'],$ignored_general_fields);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////








//getting grouped Meta Fields' Specifications/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$data['grouped_fields'] = array();
$data['fields_groupsArr'] = array();

$grouped_master_fields = $this->grouped_fields_Specifier($id,0);
array_push($data['grouped_fields'],$grouped_master_fields);

$grouped_general_fields = $this->grouped_fields_Specifier($id,1);
array_push($data['grouped_fields'],$grouped_general_fields);

$data['fields_groupsArr'] = $this->Material_model->get_fields_groups();

/* 
print_r($fields_groupsArr);
exit(0);
*/
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




//getting RFXs contains the Item name with_Date And Qty///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* 
SELECT tblmaterials.remarks, tbladvance_leads_details.floatingdate FROM `tblmaterials` 
LEFT JOIN tblleads ON tblmaterials.remarks = tblleads.name 
LEFT JOIN tbladvance_leads_details ON tblleads.id = tbladvance_leads_details.lead_id
WHERE item_name LIKE 'SEAL_RING'
*/

$the_item_name = $material->partner_item_name;
$data['RFXs_for_itemName_with_DateAndQty']= $this->Material_model->get_RFXs_for_itemName_with_DateAndQty('', ["partner_item_name" => $the_item_name], '');
//print_r($RFXs_for_itemName_with_DateAndQty);
//exit(0);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




            $this->load->view(MATERIALS_FOLDER.'/view_details', $data);
        

       
    } else {
        access_denied('Material View');
    
    }
 
}













public function view_rfxs($rfxno)
{

    $rfxnoo = str_replace( array('<p>','</p>','%3Cp%3E','%3C'), '', $rfxno);

    $data['rfxno'] = $rfxnoo;

    $data['rfxno_details']= $this->Leads_model->getAll('', [db_prefix()."leads.name" => $rfxnoo], '');

/* ['leads_res']   ['advance_leads_res']    ['advance_leads_details_res'] 
print_r($data['rfxno_details']['leads_res']);
print_r($data['rfxno_details']['advance_leads_res']);
print_r($data['rfxno_details']['advance_leads_details_res']);

print_r($data['rfxno_details']);
exit(0); */

$data['tittle'] = "";



    $this->load->view(MATERIALS_FOLDER.'/view_rfxs', $data);
}

















public function add()
{
     if (staff_can('add', 'materials')) { 

        if ($this->input->post()) {

            
        close_setup_menu();
        


        //do add:

        $data = $this->input->post();
        $data['remarks'] = html_purify($this->input->post('remarks', false));

//echo "<h1>".$data['item_name']."</h1>";
//exit();
        $id = $this->Material_model->add_material($data);
        if ($id) {
        set_alert('success', _l('Added_successfully', _l('Material')));
        //$data['title'] = _l('Add new Material');

        //then just Re-view:
        close_setup_menu();
        //$material = $this->Material_model->get_material($id);
        //$material_metadata = $this->Material_model->
        //get_material_metadata('',"material_id = ".$id."");
        //$data['material']=$material;
        //$data['material_metadata']=$material_metadata;
        //$this->load->view(MATERIALS_FOLDER.'/edit', $data);
        $this->load->view(MATERIALS_FOLDER.'/manage');


            //$this->load->view('costcenters/manage',$data);
            // redirect(admin_url('costcenters/sections/' . $section));
        }else{

        //then just Re-view:
        set_alert('info', _l('updated_Unsuccessfully', _l('Material')));
        //$data['title'] = _l('Add new Material');
        close_setup_menu();
        //$material = $this->Material_model->get_material($id);
        //$material_metadata = $this->Material_model->
        //get_material_metadata('',"material_id = ".$id."");
        //$data['material']=$material;
        //$data['material_metadata']=$material_metadata;
        //$this->load->view(MATERIALS_FOLDER.'/add', $data);
        $this->load->view(MATERIALS_FOLDER.'/manage');
        }



        }//end if
        else{
            //then view:
            close_setup_menu();
            //echo "<h1>has no</h1>";
            //exit(1);
            //$material = $this->Material_model->get_material($id);
            //$material_metadata = $this->Material_model->
            //get_material_metadata('',"material_id = ".$id."");
            $data['title'] = _l('Add Material');
            //$data['material']=$material;
            //$data['material_metadata']=$material_metadata;
            $this->load->view(MATERIALS_FOLDER.'/add', $data);    
        }
   
} else{
    access_denied('Material Add');

} 
}





public function add_metafields_groups()
{
     if (staff_can('add', 'materials')) { 
        if ($this->input->post()) {
        close_setup_menu();
        //do add:
        $data = $this->input->post();
        $data['group_details'] = html_purify($this->input->post('group_details', false));
//echo "<h1>".$data['item_name']."</h1>";
//exit();
        $id = $this->Material_model->add_metafields_groups($data);
        if ($id) {
        set_alert('success', _l('Added Successfully', _l('Meta field\' Group')));

        //then just Re-view:
        close_setup_menu();
        $this->load->view(MATERIALS_FOLDER.'/managefieldsgroups');
        }else{

        //then just Re-view:
        set_alert('info', _l('Unsuccessfully Added', _l('Meta field\' Group')));
        close_setup_menu();
        $this->load->view(MATERIALS_FOLDER.'/managefieldsgroups');
        }
        }//end if
        else{
            close_setup_menu();
            $data['title'] = _l('Add Meta fields\' Groups');
            $this->load->view(MATERIALS_FOLDER.'/addfieldsgroups', $data);    
        }
   
} else{
    access_denied('Material Add');

} 
}











public function master_general_fieldsSpecifier($id){


    $material = $this->Material_model->get_material($id);




////////////////////////////////////////////////////            
//process for getting Meta Fields' Specifications///
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// step 1 => in "$numof_item_name" : get the number of the appearence/existance of the item_name inside "materials" table
$the_item_name = $material->item_name;
$numof_item_name = $this->Material_model->get_numof_item_name('', ["partner_item_name" => $the_item_name], '');


// step 3 => in "$idsarr_of_item_name" : get IDs for each appearence of that item_nameabove 
$buff = $this->Material_model->get_idsarr_of_item_name('', ["partner_item_name" => $the_item_name], '');
$idsarr_of_item_name = array();
foreach($buff as $idd)
  array_push($idsarr_of_item_name, $idd['id']);
//print_r($idsarr_of_item_name);



// step 3 => in "$meta_fieldsArr_ofEachOf_theIds_ofTheItem" : get all the "materials_metadata->meta_field" values for each of that IDs above
/*
// The resulted  $meta_fieldsArr_ofEachOf_theIds_ofTheItem :  is an array, where :
//first element is : (one of the (material_id)s from the IDs array "$idsarr_of_item_name" above ) , 
//second element is : (an array contains all of the "meta_field" values for that material_id in the "tblmaterials_metadata" table),
//third element is : (the lenght of second element[the array of the "meta_field" values]  )
*/
$meta_fieldsArr_ofEachOf_theIds_ofTheItem = $this->Material_model->get_meta_fieldsArr_ofEachOf_theIds_ofTheItem('', $idsarr_of_item_name,'');
//print_r($meta_fieldsArr_ofEachOf_theIds_ofTheItem);





// step 4 => bring the unique meta_fields from each meta_fields() array inside $meta_fieldsArr_ofEachOf_theIds_ofTheItem and put them together in one array to start searching process
$meta_fileds_words = array();
$meta_values_words = array();
foreach($meta_fieldsArr_ofEachOf_theIds_ofTheItem as $meta_fieldsArr){  

//for($k = 0 ; $k < sizeof($meta_fieldsArr[1])  ; $k++)
//array_push($meta_fileds_words, $meta_fieldsArr[1][$k] );

for($k = 0 ; $k < sizeof($meta_fieldsArr[1]/*$meta_fieldsArr[1][0]*/)  ; $k++){
array_push($meta_fileds_words, $meta_fieldsArr[1][$k] );    
//array_push($meta_fileds_words, $meta_fieldsArr[1][0][$k] );
//array_push($meta_values_words, $meta_fieldsArr[1][1][$k] );
}
}

$unique_meta_fileds_words = array_unique($meta_fileds_words);


//print_r(  $meta_fileds_words  );




// step 5 => Now search and get the number of appearence for each unique meta_field's value and put together as pairs(meta_field's value , it's number of appearence) in "$eachMetaField_corresondNumOfAppearence_arr_all"
$eachMetaField_corresondNumOfAppearence_arr_all = array();

foreach($unique_meta_fileds_words as $unique_meta_fileds_word){

$eachMetaField_corresondNumOfAppearence_arr = array();
$numof_appearence_inAll = 0;

foreach($meta_fieldsArr_ofEachOf_theIds_ofTheItem as $meta_fieldsArr){
if( in_array($unique_meta_fileds_word,  $meta_fieldsArr[1]  )  )
$numof_appearence_inAll++;
//echo "<br><br><br>".print_r($meta_fieldsArr[1]);

}
//echo "<br>".$numof_appearence_inAll++;
array_push($eachMetaField_corresondNumOfAppearence_arr , $unique_meta_fileds_word);
array_push($eachMetaField_corresondNumOfAppearence_arr , $numof_appearence_inAll);

$metaValues_foreach_uniqueMetafield = $this->Material_model->get_metaValues_foreach_uniqueMetafield($idsarr_of_item_name, array( $unique_meta_fileds_word) );
array_push($eachMetaField_corresondNumOfAppearence_arr , $metaValues_foreach_uniqueMetafield);

array_push($eachMetaField_corresondNumOfAppearence_arr_all , $eachMetaField_corresondNumOfAppearence_arr);
}
//print_r($eachMetaField_corresondNumOfAppearence_arr_all);





// step 6 => Finally Decide whome is Master by calculation , in comparison with 60% , then put the master fields together in one array "$theMasterFields_arr"
$theMasterFields_corresondNumOfAppearence = array();
$theGeneralFields_corresondNumOfAppearence = array();
//$theMaster_Fields = array();
foreach($eachMetaField_corresondNumOfAppearence_arr_all as $eachMetaField_corresondNumOfAppearence){

$theMasterFields_arr = array();
$theGeneralFields_arr = array();

if(   (( intval($eachMetaField_corresondNumOfAppearence[1]) /  intval($numof_item_name) ) * 100 )  >= 30.0  ){
array_push($theMasterFields_arr, $eachMetaField_corresondNumOfAppearence[0]);
//array_push($theMaster_Fields, $eachMetaField_corresondNumOfAppearence[0]);
array_push($theMasterFields_arr, $eachMetaField_corresondNumOfAppearence[1]);
array_push($theMasterFields_arr, $eachMetaField_corresondNumOfAppearence[2]);
array_push($theMasterFields_corresondNumOfAppearence, $theMasterFields_arr);
}else{
array_push($theGeneralFields_arr , $eachMetaField_corresondNumOfAppearence[0]);
array_push($theGeneralFields_arr , $eachMetaField_corresondNumOfAppearence[1]);
array_push($theGeneralFields_arr , $eachMetaField_corresondNumOfAppearence[2]);
array_push($theGeneralFields_corresondNumOfAppearence , $theGeneralFields_arr);
}
}


//print_r($theMasterFields_arr);










//$data['materialMetaDataMasterFields_correspondNumOfAppearenceForEach']=$theMasterFields_corresondNumOfAppearence;//$theMasterFields_arr;
//$data['materialMetaDataGeneralFields_correspondNumOfAppearenceForEach']=$theGeneralFields_corresondNumOfAppearence;//$theGeneralFields_arr;





return [$theMasterFields_corresondNumOfAppearence , $theGeneralFields_corresondNumOfAppearence, $numof_item_name];

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



}















public function master_general_fields_ignoredFieldsSpecifier($id, $what_is){

$material = $this->Material_model->get_material($id);
$the_item_name = $material->item_name;

$res = $this->Material_model->get_master_general_fields_ignored('', ["material_partner_item_name" => $the_item_name,"master_or_general" => ($what_is == 0 ? 'm' : 'g')  ]);

$buff = array();
foreach($res as $ignored_fields)
array_push($buff,$ignored_fields['item_name_meta_field_name']);

return $buff;
}




public function grouped_fields_Specifier($id, $what_is){

    $material = $this->Material_model->get_material($id);
    $the_item_name = $material->item_name;
    
    $res = $this->Material_model->get_grouped_fields('', ["material_partner_item_name" => $the_item_name,"master_or_general" => ($what_is == 0 ? 'm' : 'g')  ]);
    
    $buff = array();
    foreach($res as $ignored_fields){
    array_push($buff,$ignored_fields['item_name_meta_field_name']);
    array_push($buff,$ignored_fields['group_name']);
    array_push($buff,$ignored_fields['group_id']);
    }

/* 
print_r($res);
exit(0); 
*/
    //return $buff;
    return $res;
    }













public function metadata_blockcloner(){


    $counter = $_POST['countr'];
              
    $output ="<div  class='tab-content tw-mt-3' id='metablock_".($counter+1)."'>"
              ."<div role='tabpanel' class='tab-pane active' id='tab_materials'>"

              ."<div class='col-md-12'>"
                  ."<br>"
                  ."<h4>Meta Field ".($counter+1)." :</h4>"
                  ."</div>"
                
                  /* ."<input type='hidden' name='id_".($counter+1)."' value='' />" */
                  ."<input type='hidden' id='isnew_".($counter+1)."' name='isnew_".($counter+1)."' value='1' />"
                  ."<input type='hidden' id='isdeleted_".($counter+1)."' name='isdeleted_".($counter+1)."' value='0' />"
                  ."<input type='hidden' id='isjustadded_".($counter+1)."' name='isjustadded_".($counter+1)."' value='1' />"
                  ."<input type='hidden' id='is_to_take_in_mind_".($counter+1)."' name='is_to_take_in_mind_".($counter+1)."' value='1' />"

                  ."<div class='col-md-6'>"
                      ."<br>"
                                .render_input('meta_field_'.($counter+1), 'Name')
                  ."</div>"

                  ."<div class='col-md-6'>"
                      ."<br> "
                                .render_input('meta_value_'.($counter+1), 'Value')
                  ."</div>"

                  ."<div class='col-md-12'>"
                          ."<div class='form-group'>"
                              ."<p class='bold'>"._l('remarks')."</p>"
                                        .render_textarea('remarks_'.($counter+1), '', '', [], [], '', 'tinymce')
                                        /* ."<textarea id='remarks_".($counter+1)."' name='remarks_".($counter+1)."' class='form-control' rows='4' ></textarea>" */
                          ."</div>"
                  ."</div>"

                  ."<input type='hidden' id='dateadded_".($counter+1)."' name='dateadded_".($counter+1)."' value='".date('Y-m-d H:i:s')."' />"

                      ."<div class='panel-footer text-right'>"

                          ."<button  id='submitter' onclick='to_decider(0)'  type='submit' data-form='#costcenter_form' class='btn btn-primary' autocomplete='off' data-loading-text='"._l('wait_text')."' >"
                                         ._l('submit')
                          ."</button>&nbsp"

                          ."<button  id='deleter' onclick='to_decider(".($counter+1).")'  type='submit' data-form='#costcenter_form' class='btn btn-primary' autocomplete='off' data-loading-text='"._l('wait_text')."' >"
                                        ._l('remove')
                          ."</button>"
                      ."</div>"


        ."</div>"
        ."</div>";

echo $output;

}


































public function do_ignore_metafield(){


    if (staff_can('add', 'materials')) { 
        if ($_POST['material_partner_item_name'] != "") {
        //do add:
    //echo "<h1>".$data['item_name']."</h1>";
    //exit();
$data = array( 'material_partner_item_name' => $_POST['material_partner_item_name'], 
'item_name_meta_field_name' => $_POST['item_name_meta_field_name'], 
'item_name_meta_field_values' => $_POST['item_name_meta_field_values'], 
'master_or_general' => $_POST['master_or_general'] );

        $id = $this->Material_model->add_ignored_metafield($data);

        if ($id) {
        echo "success";
        }else{
        echo "fail";
        }
    
        }//end if
        else{
            //return empty item_name:
            echo "empty";    
        }
    
    } else{
    echo "access_denied";    
    
    } 
    
}


















public function do_group_ungroup_field(){

    if (staff_can('add', 'materials')) { 
        if ($_POST['material_partner_item_name'] != "") {
        //do add:
    //echo "<h1>".$data['item_name']."</h1>";
    //exit();
$data = array( 'material_partner_item_name' => $_POST['material_partner_item_name'], 
'item_name_meta_field_name' => $_POST['item_name_meta_field_name'], 
'item_name_meta_field_values' => $_POST['item_name_meta_field_values'], 
'master_or_general' => $_POST['master_or_general'],  
'group_id' => $_POST['groupid'] );

        $id = $this->Material_model->group_ungroup_metafield_whithin_group($data,$_POST['whatto']);

        if ($id && $id != "d") {
        echo "success";
        }else if($id == "d"){
        echo "deleted";
        }else 
        echo "fail";
    
        }//end if
        else{
            //return empty item_name:
            echo "empty";    
        }
    
    } else{
    echo "access_denied";    
    
    } 
    
}
















}

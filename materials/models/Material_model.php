<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Material model
 */
class Material_model extends App_Model
{

	public function __construct()
    {
        parent::__construct();
    }

    /**
     * add material
     * @param $data
     */
    

    public function add_material($data)
    {
        //$this->db->select('status');
        //$this->db->where('id', $id);
        //$old_id = $this->db->get(db_prefix() . 'materials')->row()->id;

/*         $send_created_email = false;
        if (isset($data['send_created_email'])) {
            unset($data['send_created_email']);
            $send_created_email = true;
        } 

        $send_costcenter_marked_as_finished_email_to_contacts = false;
        if (isset($data['costcenter_marked_as_finished_email_to_contacts'])) {
            unset($data['costcenter_marked_as_finished_email_to_contacts']);
            $send_costcenter_marked_as_finished_email_to_contacts = true;
        }

        $original_costcenter = $this->get($id);

        if (isset($data['notify_costcenter_members_status_change'])) {
            $notify_costcenter_members_status_change = true;
            unset($data['notify_costcenter_members_status_change']);
        }
        $affectedRows = 0;
       
        if ($data['parent_id'] == null) {
            unset($data['parent_id']);
        }
        $data['updated_at'] = date('Y-m-d h:i:s');

        if (isset($data['costcenter_supervisors'])) {
            $costcenter_supervisors = $data['costcenter_supervisors'];
            unset($data['costcenter_supervisors']);
        }

        if (isset($data['costcenter_members'])) {
            $costcenter_members = $data['costcenter_members'];
            unset($data['costcenter_members']);
        }
        $_pm = [];
       
        if (isset($costcenter_members)) {
            $_pm['costcenter_members'] = $costcenter_members;
            $this->add_edit_members($_pm, $id);
        }
        if (isset($costcenter_supervisors)) {
            $_pm['costcenter_supervisors'] = $costcenter_supervisors;
            $this->add_edit_supervisors($_pm, $id);
        }

        
        if (isset($data['contact_notification'])) {
            if ($data['contact_notification'] == 2) {
                $data['notify_contacts'] = serialize($data['notify_contacts']);
            } else {
                $data['notify_contacts'] = serialize([]);
            }
        }
     */   
        //$data = hooks()->apply_filters('before_update_costcenter', $data, $id);


//echo "<h1>".$data['meta_field_1']."</h1>";
//exit(0);


$dataArr = array(
    'item_code'=>$data['item_code'] , 
    'item_name'=>$data['item_name'] , 
    'staff_id'=>$data['staff_id'] ,
    'remarks'=>$data['remarks'] ,
    'partner'=>$data['partner'] ,
    'partner_item_code'=>$data['partner_item_code'] ,
    'partner_item_name'=>$data['partner_item_name'] ,
    'category_id'=>$data['category_id'] ,
    'field_id'=>$data['field_id'] ,
    'purchase_price'=>$data['purchase_price'] ,
    'sell_price'=>$data['sell_price'] ,
    'datecreated'=>$data['datecreated'] ,
);

        //$this->db->where('id', $id);
        //$stat = $this->db->update(db_prefix() . 'materials', $dataArr);

        $stat = 0;
        $this->db->insert(db_prefix() . 'materials', $dataArr);
        $insert_id = $this->db->insert_id();
        $stat = $insert_id;






    $dataArr2 = null;

        for($i=0 ; $i < $data['sizeof_material_metadata_recs'] ; $i++){

            if($data['is_to_take_in_mind_'.($i+1)] == '1'){
            $dataArr2 = array(
                'material_id'=>$insert_id ,
                'meta_field'=>$data['meta_field_'.($i+1)] , 
                'meta_value'=>$data['meta_value_'.($i+1)] , 
                'remarks'=>$data['remarks_'.($i+1)] ,
                'dateadded'=>$data['dateadded_'.($i+1)]
            );


            //$this->db->where('id', $data['id_'.($i+1)]);
            //$qryst="id='".$data['id_'.($i+1)]."' AND material_id='".$id."'";
            //$this->db->where($qryst, NULL, FALSE);
            $stat2 = 0;
            $this->db->insert(db_prefix() . 'materials_metadata', $dataArr2);
            $stat2 = $this->db->insert_id();
            
        }else{ $stat2 = true;}

            if($stat2){
                continue;
            }else{
                $stat2 = false;
                break;
            }

        }






//echo "<h1>".$stat."</h1>";
//exit();


        if (/* $affectedRows > 0 */$stat && $stat2) {
            //$this->log_activity($id, 'costcenter_activity_updated');
            //log_activity('costcenter Updated [ID: ' . $id . ']');

            //// if ($original_costcenter->status != $data['status']) {
            ////     hooks()->do_action('costcenter_status_changed', [
            ////         'status'     => $data['status'],
            ////         'costcenter_id' => $id,
            ////     ]);
                //// Give space this log to be on top
                //sleep(1);
                    //// $this->db->where('id', $id);
                    //// $this->db->update(db_prefix() . 'costcenters', ['updated_at' => date('Y-m-d H:i:s')]);
            

                /* if (isset($notify_costcenter_members_status_change)) {
                    $this->_notify_costcenter_members_status_change($id, $original_costcenter->status, $data['status']);
                } */
            //// }
            //hooks()->do_action('after_update_costcenter', $id);

            return $insert_id;
        }

        return 0;
    }  
















    public function add_metafields_groups($data){


        $this->db->where('group_name',$data['group_name']);
        $res = $this->db->get(db_prefix() . 'materials_metafields_groups')->result_array();

        if(sizeof($res) > 0){
        $this->db->where('group_name',$data['group_name']);
        $res = $this->db->delete(db_prefix() . 'materials_metafields_groups');
        }

        $this->db->insert(db_prefix() . 'materials_metafields_groups', $data);
        $stat = $this->db->insert_id();
        
        if($stat){
            return 1;
        }else{
            return 0;
        }


    }
    














    
    /*     public function addd_material($data)
    {
        // if(isset($data['material_metadata']))
        // {
        //     $material_metadata=$data['material_metadata'];
        //     uset($data['material_metadata']);
        // }
        $this->db->insert(db_prefix() . 'materials', $data);
        $insert_id = $this->db->insert_id();

        
        if($insert_id){

        return $insert_id;
        }
        return false;
    } */


    /**
    * End add material.
    */




    /**
     * add material metadata
     * @param $data
     */
    public function add_material_metadata($data)
    {
        $this->db->insert(db_prefix() . 'materials_metadata', $data);
        
        $insert_id = $this->db->insert_id();
    }
    /**
    * End add material metadata.
    */



    public function add_ignored_metafield($data)
    {
        $this->db->insert(db_prefix() . 'materials_metafields_ignored', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }



    public function group_ungroup_metafield_whithin_group($data,$whatto){

        $this->db->where('material_partner_item_name', $data['material_partner_item_name']);
        $this->db->where('item_name_meta_field_name', $data['item_name_meta_field_name']);    
        $this->db->where('master_or_general', $data['master_or_general']);    
        $this->db->delete(db_prefix() . 'materials_metafields_grouped');

if($whatto == 'gr'){
        $this->db->insert(db_prefix() . 'materials_metafields_grouped', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
}else 
return 'd';
    }




    /**
     * Get materials
     * @param  string $id    optional id
     * @param  array  $where perform where
     * @param  string $limit
     * @return mixed
     */
    public function get_material($id = '', $where = [], $limit = '')
    {
        if (is_numeric($id)) {
            $this->db->where('id', $id);
            $this->db->where($where);
            return $this->db->get(db_prefix() . 'materials')->row();
        }
        if (is_numeric($limit)) {
            $this->db->where($where);
            $this->db->limit($limit);
        }
        else
        {
            $this->db->where($where);
        }
        return $this->db->get(db_prefix() . 'materials')->result_array();
    }
    /**
    * End Get materials.
    */



    public function get_metafields_groups($id = '', $where = [], $limit = ''){
        if (is_numeric($id)) {
            $this->db->where('id', $id);
            $this->db->where($where);
            return $this->db->get(db_prefix() . 'materials_metafields_groups')->row();
        }
        if (is_numeric($limit)) {
            $this->db->where($where);
            $this->db->limit($limit);
        }
        else
        {
            $this->db->where($where);
        }
        return $this->db->get(db_prefix() . 'materials_metafields_groups')->result_array();
    }







    /**
     * Get materials metadata
     * @param  string $id    optional id
     * @param  array  $where perform where
     * @param  string $limit
     * @return mixed
     */
    public function get_material_metadata($id = '', $where = [], $limit = '')
    {
        if (is_numeric($id)) {
            $this->db->where('id', $id);

            return $this->db->get(db_prefix() . 'materials_metadata')->row();
        }
        if (is_numeric($limit)) {
            $this->db->where($where);
            $this->db->limit($limit);
        }
        else
        {
            $this->db->where($where);
        }

        return $this->db->get(db_prefix() . 'materials_metadata')->result_array();
    }
    /**
    * End Get materials metadata.
    */












































    public function get_numof_item_name($id = '', $where = [], $limit = '')
    {

        //$this->db->like($where);
        $this->db->where($where);

//echo "<h1>".$this->db->get(db_prefix() . 'materials')->num_rows()."</h1>";
//print_r($this->db->get(db_prefix() . 'materials')->result_array());
//exit();

          //return $this->db->get(db_prefix() . 'materials')->result_array(); 
          return $this->db->get(db_prefix() . 'materials')->num_rows();
          //print_r($this->db->query("SELECT * FROM tblmaterials")->result());
          
    }




    public function get_idsarr_of_item_name($id = '', $where = [], $limit = '')
    {
        $this->db->select('id');
        $this->db->where($where);
        //$this->db->like($where);

//print_r($this->db->get(db_prefix() . 'materials')->result_array());
//exit();

        return $this->db->get(db_prefix() . 'materials')->result_array();


    }




    public function get_meta_fieldsArr_ofEachOf_theIds_ofTheItem($id = '', $ids = [],$limit = '')
    {

        $this->db->select('meta_field');

//echo $this->db->get(db_prefix() . 'materials_metadata')->result_array()[0]['material_id'];
//$this->db->where(["material_id" => '1' ]);
//print_r($this->db->get(db_prefix() . 'materials_metadata')->result_array());
//exit(0);

$materialId_metaFields_arr_all = array();


$i = 0;


foreach($ids as $idds){
$materialId_metaFields_arr = array();
$meta_fields_arr = array();
$this->db->where(["material_id" => $ids[$i] ]);

foreach($this->db->get(db_prefix() . 'materials_metadata')->result_array() as $meta_fields){
    //$meta_arr = array();
    //array_push($meta_arr, $meta_fields['meta_field']);
    //array_push($meta_arr, $meta_fields['meta_value']);
    //array_push($meta_fields_arr, $meta_arr);
   array_push($meta_fields_arr, $meta_fields['meta_field']);
}


array_push($materialId_metaFields_arr, $ids[$i] );
array_push($materialId_metaFields_arr, $meta_fields_arr );
array_push($materialId_metaFields_arr, sizeof($meta_fields_arr) );
array_push($materialId_metaFields_arr_all, $materialId_metaFields_arr);
$i++;
}



//print_r($materialId_metaFields_arr);
//exit(0);

return $materialId_metaFields_arr_all;

    }







    public function get_metaValues_foreach_uniqueMetafield($idsarr_of_item_name = [], $unique_meta_fileds_word = []){
        
        $metaValues_arr = "-------";

foreach($unique_meta_fileds_word as $unique_words){
    $metaValues = array();  
        $this->db->where(["meta_field" => $unique_words/* , 'material_id IN' =>  trim('('.implode(',',$idsarr_of_item_name).')',"'") */ ]); 
        $this->db->where_in('material_id', $idsarr_of_item_name);   
        
    foreach($this->db->get(db_prefix().'materials_metadata')->result_array() as $meta_value){
        array_push($metaValues, $meta_value['meta_value']);
    }

    $metaValues_arr .= implode("<br>-------", $metaValues);
        //$this->db->like(["item_name" => $unique_meta_fileds_word[$i]]);
        //$i++;
    }
//echo $metaValues_arr;
//exit(0);
return $metaValues_arr;
}














































public function get_master_general_fields_ignored($id = '', $where = [])
{

    //$this->db->like($where);
    $this->db->where($where);

//echo "<h1>".$this->db->get(db_prefix() . 'materials')->num_rows()."</h1>";
//print_r($this->db->get(db_prefix() . 'materials_metafields_ignored')->result_array());
//exit();

 
      return $this->db->get(db_prefix() . 'materials_metafields_ignored')->result_array() ;
      //print_r($this->db->query("SELECT * FROM tblmaterials")->result());
      
}





public function get_grouped_fields($id = '', $where = [])
{
    $this->db->where($where);
    $this->db->join(db_prefix().'materials_metafields_groups', db_prefix().'materials_metafields_grouped.group_id = '.db_prefix().'materials_metafields_groups.id', 'left');
    $this->db->select(db_prefix().'materials_metafields_groups.group_name, '.db_prefix().'materials_metafields_grouped.group_id, '.db_prefix().'materials_metafields_grouped.item_name_meta_field_name');

//echo "<h1>".$this->db->get(db_prefix() . 'materials_metafields_grouped')->num_rows()."</h1>";
//print_r($this->db->get(db_prefix() . 'materials_metafields_grouped')->result_array());
//exit();

      return $this->db->get(db_prefix() . 'materials_metafields_grouped')->result_array() ;
      //print_r($this->db->query("SELECT * FROM tblmaterials")->result());
      
}






public function get_fields_groups()
{
    //$this->db->where($where);
      return $this->db->get(db_prefix() . 'materials_metafields_groups')->result_array() ;
}




































    public function get_RFXs_for_itemName_with_DateAndQty($id = '', $the_item_name = [],$limit = ''){


        //$query = $this->db->query("SELECT tblmaterials.item_name, tblmaterials.remarks, tbladvance_leads_details.floatingdate FROM 'tblmaterials' LEFT JOIN tbladvance_leads_details ON tbladvance_leads_details.lead_id = tblmaterials.id WHERE item_name LIKE 'SEAL_RING' ");

        //$this->db->where(["item_name" => 'SEAL_RING' ]);
        $this->db->join(db_prefix().'leads', db_prefix().'materials.remarks = '.db_prefix().'leads.name', 'left');
        $this->db->join(db_prefix().'advance_leads_details', db_prefix().'leads.id = '.db_prefix().'advance_leads_details.lead_id', 'left');
        $this->db->select(db_prefix().'materials.partner_item_name, '.db_prefix().'materials.remarks, '.db_prefix().'advance_leads_details.floatingdate');
        $this->db->like($the_item_name);

        $res = $this->db->get(db_prefix() . 'materials')->result_array();

//print_r($res);
//exit(0);



return $res;

}





































    public function update_material($data, $id)
    {
        //$this->db->select('status');
        $this->db->where('id', $id);
        $old_id = $this->db->get(db_prefix() . 'materials')->row()->id;

/*         $send_created_email = false;
        if (isset($data['send_created_email'])) {
            unset($data['send_created_email']);
            $send_created_email = true;
        } 

        $send_costcenter_marked_as_finished_email_to_contacts = false;
        if (isset($data['costcenter_marked_as_finished_email_to_contacts'])) {
            unset($data['costcenter_marked_as_finished_email_to_contacts']);
            $send_costcenter_marked_as_finished_email_to_contacts = true;
        }

        $original_costcenter = $this->get($id);

        if (isset($data['notify_costcenter_members_status_change'])) {
            $notify_costcenter_members_status_change = true;
            unset($data['notify_costcenter_members_status_change']);
        }
        $affectedRows = 0;
       
        if ($data['parent_id'] == null) {
            unset($data['parent_id']);
        }
        $data['updated_at'] = date('Y-m-d h:i:s');

        if (isset($data['costcenter_supervisors'])) {
            $costcenter_supervisors = $data['costcenter_supervisors'];
            unset($data['costcenter_supervisors']);
        }

        if (isset($data['costcenter_members'])) {
            $costcenter_members = $data['costcenter_members'];
            unset($data['costcenter_members']);
        }
        $_pm = [];
       
        if (isset($costcenter_members)) {
            $_pm['costcenter_members'] = $costcenter_members;
            $this->add_edit_members($_pm, $id);
        }
        if (isset($costcenter_supervisors)) {
            $_pm['costcenter_supervisors'] = $costcenter_supervisors;
            $this->add_edit_supervisors($_pm, $id);
        }

        
        if (isset($data['contact_notification'])) {
            if ($data['contact_notification'] == 2) {
                $data['notify_contacts'] = serialize($data['notify_contacts']);
            } else {
                $data['notify_contacts'] = serialize([]);
            }
        }
     */   
        //$data = hooks()->apply_filters('before_update_costcenter', $data, $id);


//echo "<h1>".$data['meta_field_1']."</h1>";
//exit(0);


$dataArr = array(
    'item_code'=>$data['item_code'] , 
    'item_name'=>$data['item_name'] , 
    'staff_id'=>$data['staff_id'] ,
    'remarks'=>$data['remarks'] ,
    'partner'=>$data['partner'] ,
    'partner_item_code'=>$data['partner_item_code'] ,
    'partner_item_name'=>$data['partner_item_name'] ,
    'category_id'=>$data['category_id'] ,
    'field_id'=>$data['field_id'] ,
    'purchase_price'=>$data['purchase_price'] ,
    'sell_price'=>$data['sell_price'] ,
    'datecreated'=>$data['datecreated'] ,
);

        $this->db->where('id', $id);
        $stat = $this->db->update(db_prefix() . 'materials', $dataArr);









    $dataArr2 = null;
        
        for($i=0 ; $i < $data['sizeof_material_metadata_recs'] ; $i++){

            
if($data['isnew_'.($i+1)] == '0'){

            $this->db->where('id', $data['id_'.($i+1)]);

if($data['isdeleted_'.($i+1)] == '0'){

    

            $dataArr2 = array(
                'meta_field'=>$data['meta_field_'.($i+1)] , 
                'meta_value'=>$data['meta_value_'.($i+1)] , 
                'remarks'=>$data['remarks_'.($i+1)] 
            );

            //$this->db->where('material_id', $id);
            
            //$qryst="id='".$data['id_'.($i+1)]."' AND material_id='".$id."'";
            //$this->db->where($qryst, NULL, FALSE);
            
            $stat2 = $this->db->update(db_prefix() . 'materials_metadata', $dataArr2);


        

        }else{
            $stat2 = $this->db->delete(db_prefix() . 'materials_metadata');
        }




}else{

    if($data['is_to_take_in_mind_'.($i+1)] == '1'){

            $dataArr2 = array(
                'material_id'=>$id ,//$insert_id ,
                'meta_field'=>$data['meta_field_'.($i+1)] , 
                'meta_value'=>$data['meta_value_'.($i+1)] , 
                'remarks'=>$data['remarks_'.($i+1)] ,
                'dateadded'=>$data['dateadded_'.($i+1)]
            );

            //$this->db->where('id', $data['id_'.($i+1)]);
            //$qryst="id='".$data['id_'.($i+1)]."' AND material_id='".$id."'";
            //$this->db->where($qryst, NULL, FALSE);
            $stat2 = 0;
            $this->db->insert(db_prefix() . 'materials_metadata', $dataArr2);
            $stat2 = $this->db->insert_id();

        }else{$stat2 = true;}


        }





            if($stat2){
                continue;
            }else{
                $stat2 = false;
                break;
            }


        }






//echo "<h1>".$stat."</h1>";
//exit();


        if (/* $affectedRows > 0 */$stat && $stat2) {
            //$this->log_activity($id, 'costcenter_activity_updated');
            //log_activity('costcenter Updated [ID: ' . $id . ']');

            //// if ($original_costcenter->status != $data['status']) {
            ////     hooks()->do_action('costcenter_status_changed', [
            ////         'status'     => $data['status'],
            ////         'costcenter_id' => $id,
            ////     ]);
                //// Give space this log to be on top
                //sleep(1);
                    //// $this->db->where('id', $id);
                    //// $this->db->update(db_prefix() . 'costcenters', ['updated_at' => date('Y-m-d H:i:s')]);
            

                /* if (isset($notify_costcenter_members_status_change)) {
                    $this->_notify_costcenter_members_status_change($id, $original_costcenter->status, $data['status']);
                } */
            //// }
            //hooks()->do_action('after_update_costcenter', $id);

            return $old_id;
        }

        return 0;
    }


















    public function update_metafields_groups($data, $id){

 
        $this->db->where('id',$id);
       /* 
        $res = $this->db->get(db_prefix() . 'materials_metafields_groups')->result_array();

        if(sizeof($res) > 0){
        $this->db->where('group_name',$data['group_name']);
        $res = $this->db->delete(db_prefix() . 'materials_metafields_groups');
        } */

        $stat = $this->db->update(db_prefix() . 'materials_metafields_groups', $data);

        if($stat){
            return 1;
        }else{
            return 0;
        }

    }
    














    public function delete_metafields_groups($id){

 
        $this->db->where('id',$id);
        $stat = $this->db->delete(db_prefix() . 'materials_metafields_groups');

        $this->db->where('group_id',$id);
        $stat2 = $this->db->delete(db_prefix() . 'materials_metafields_grouped');

        if($stat){
            return 1;
        }else{
            return 0;
        }

    }    














 

}
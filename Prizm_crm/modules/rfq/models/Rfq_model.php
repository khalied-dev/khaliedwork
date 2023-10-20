<?php

defined('BASEPATH') or exit('No direct script access allowed');

class RFQ_model extends App_Model
{
    public function get($id = '', $where = [])
    {
        if ((is_array($where) && count($where) > 0) || (is_string($where) && $where != '')) {
            $this->db->where($where);
        }
        if (is_numeric($id)) {
            $this->db->where('id', $id);

            return $this->db->get(db_prefix() . 'rfqs')->row();
        }
        return $this->db->get(db_prefix() . 'rfqs')->result_array();
    }
    public function get_RFQTemplates($RFQId)
    {
        $this->db->where('RFQId', $RFQId);
        return $this->db->get(db_prefix() . 'rfq_template_list')->result_array();
    }

    /**
     * @param  $_POST array
     * @param  integer
     * @return boolean
     * This function updates RFQ
     */
    public function update($data, $id)
    {
       // $data = hooks()->apply_filters('before_announcement_updated', $data, $id);

        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'rfqs', $data);
        if ($this->db->affected_rows() > 0) {
           // hooks()->do_action('announcement_updated', $id);

         //   log_activity('RFQ Updated [' . $data['name'] . ']');

            return true;
        }

        return false;
    }

    public function get_templete_columns($templete_id)
    {
        $this->db->where('TemplateId', $templete_id);
        return $this->db->get(db_prefix() . 'rfq_columns_list')->result_array();
    }

    public function get_column_attribute($ColumnId)
    {
        $this->db->where('ColumnId', $ColumnId);
        return $this->db->get(db_prefix() . 'rfq_attirbute_item_list')->result_array();
    }

    public function get_rfq_cc_emails($RFQId)
    {
        $this->db->where('RFQId', $RFQId);
        return $this->db->get(db_prefix().'rfq_cc_emails')->result_array();
    }

    public function get_selected_rfq_staff($rfq_id,$where = [],$isliking = 0)
    {

        if ($isliking == 0)
        $this->db->select(
            "staffid,  firstname,lastname, email,
        IF(staffid in (select staff_id from " .
                db_prefix() .
                'rfq_cc_emails where ' .
                db_prefix() .
                "rfq_cc_emails.RFQId=$rfq_id),
        'checked', '') as selected"
        );

        
       else{
       $this->db->select("staffid,  firstname,lastname, email,");
       $this->db->like('firstname', $where, 'both'); 
       $this->db->or_like('lastname', $where, 'both');
       $this->db->or_like('email', $where, 'both');
       }

        return $this->db->get(db_prefix() . 'staff')->result_array();
    }
























    public function add_RFQ($data)
    {

        $EmailCCUsersList = [];
        $SupplierList = [];
        $Tampletes = [];

        if (isset($data['EmailCCUsersList'])) {
            $EmailCCUsersList = $data['EmailCCUsersList'];
            unset($data['EmailCCUsersList']);
        }
        if (isset($data['SupplierList'])) {
            $SupplierList = $data['SupplierList'];
            unset($data['SupplierList']);
        }
        if (isset($data['SupplierContactList'])) {
            $SupplierContactList = $data['SupplierContactList'];
            unset($data['SupplierContactList']);
        }
        if (isset($data['Tampletes'])) {
            $Tampletes = $data['Tampletes'];
            unset($data['Tampletes']);
        }

        unset($data['tblSuppliers_length']);
        unset($data['tblEmailCCUsers_length']);

        $this->db->insert(db_prefix().'rfqs', $data);
        $id = $this->db->insert_id();
        $data['RFQ_code']="RFQ-".date('y').str_pad($id, 6, '0', STR_PAD_LEFT);
        $this->db->where('id',$id);
        $this->db->update(db_prefix().'rfqs',$data);

        if ($id){
        unset($data);
        $EmailCCUsersListkeys = array_keys($EmailCCUsersList);
        $this->db->where('RFQId', $id);
        $this->db->delete(db_prefix().'rfq_cc_emails');
        for ($i = 0; $i < count($EmailCCUsersListkeys); $i++) {
            unset($data);
            if (!isset($RFQId) || !empty($RFQId) || $RFQId != null) {
                $data['staff_id'] = $EmailCCUsersListkeys[$i];
                $data['RFQId'] = $id;
                $this->db->insert(db_prefix().'rfq_cc_emails', $data);
            } else {
                $data['staff_id'] = $EmailCCUsersListkeys[$i];
                $data['RFQId'] = $id;
                $this->db->insert(db_prefix().'rfq_cc_emails', $data);
            }
        }
       
        unset($data);
        if (count($SupplierList)>0) 
        {
            $this->db->where('RFQId', $id);
            $this->db->delete(db_prefix().'rfq_supplier');
            for ($i = 0; $i < count($SupplierList); $i++) {
                unset($data);
                $supplier_id = $SupplierList[$i];
                if (!isset($RFQId) || !empty($RFQId) || $RFQId != null) {
                    $data['supplier_id'] = $supplier_id;
                    $data['RFQId'] = $id;
                } else {
                    $data['supplier_id'] = $supplier_id;
                    $data['RFQId'] = $id;
                }
                $this->db->insert(db_prefix().'rfq_supplier',$data);
            }
        }

        $this->db->where('RFQId', $id);
        $this->db->delete(db_prefix().'rfq_supplier_contact');
        if(isset($SupplierContactList))
        {
            if (count($SupplierContactList)>0) {
                for ($i = 0; $i < count($SupplierContactList); $i++) {
                    unset($data);
                    $supplier_contact_id = $SupplierContactList[$i];
                    if (!isset($RFQId) || !empty($RFQId) || $RFQId != null) {
                        $data['supplier_contact_id'] = $supplier_contact_id;
                        $data['RFQId'] = $id;
                    } else {
                        $data['supplier_contact_id'] = $supplier_contact_id;
                        $data['RFQId'] = $id;
                    }
                    $this->db->insert(db_prefix().'rfq_supplier_contact',$data);

                }
            }
        }
          

            if (!isset($id) || !empty($id) || $id != null) {
                $this->db->where('RFQId', $id);
                $this->db->delete(db_prefix().'rfq_attirbute_item_list');

                $this->db->where('RFQId', $id);
                $this->db->delete(db_prefix().'rfq_columns_list');

                $this->db->where('RFQId', $id);
                $this->db->delete(db_prefix().'rfq_template_list');
            }
            foreach ($Tampletes as $key => $Attributes) {
                unset($data);
                $data['templateName'] = $key;
                $data['RFQId'] = $id;
                $this->db->insert(db_prefix().'rfq_template_list',$data);
                $TemlateId = $this->db->insert_id();
                $Columns = [];
                foreach ($Tampletes[$key]['Columns'] as $Column) {
                    unset($data);
                    $data['TemplateId'] = $TemlateId;
                    $data['ColumnName'] = $Column;
                    $data['RFQId'] = $id;
                    $this->db->insert(db_prefix().'rfq_columns_list',$data);
                    $ColumnId = $this->db->insert_id();
                    $Columns[] = $ColumnId;
                }
                $Rows = [];
                foreach ($Tampletes[$key]['Rows'] as $Row) {
                    $Rows[] = $Row;
                }
                for ($i = 0; $i < count($Rows); $i++) {
                    foreach ($Rows[$i] as $Column) {
                        unset($data);
                        $data['ColumnId'] = $Columns[$i];
                        $data['description'] = $Column;
                        $data['RFQId'] = $id;
                        $this->db->insert(db_prefix().'rfq_attirbute_item_list',$data);
                    }
                }
            }
        }

        return $id;

    }
























    public function update_RFQ($data)
    {

 $EmailCCUsersList = [];
 $SupplierList = [];
 $Tampletes = [];


        if (isset($data['EmailCCUsersList'])) {
            $EmailCCUsersList = $data['EmailCCUsersList'];
            unset($data['EmailCCUsersList']);
        }
        if (isset($data['SupplierList'])) {
            $SupplierList = $data['SupplierList'];
            unset($data['SupplierList']);
        }
        if (isset($data['SupplierContactList'])) {
            $SupplierContactList = $data['SupplierContactList'];
            unset($data['SupplierContactList']);
        }
        if (isset($data['Tampletes'])) {
            $Tampletes = $data['Tampletes'];
            unset($data['Tampletes']);
        }

        unset($data['tblSuppliers_length']);
        unset($data['tblEmailCCUsers_length']);



        $data['Acceptance'] = "Pending";

    
        //$this->db->insert(db_prefix().'rfqs', $data);
        $id = $data['id'];
        //$data['RFQ_code']="RFQ-".date('y').str_pad($id, 6, '0', STR_PAD_LEFT);
        $this->db->where('id',$id);
        $this->db->update(db_prefix().'rfqs',$data);
        



        if ($id){


        unset($data);
        $EmailCCUsersListkeys = array_keys($EmailCCUsersList);
        $this->db->where('RFQId', $id);
        $this->db->delete(db_prefix().'rfq_cc_emails');
        for ($i = 0; $i < count($EmailCCUsersListkeys); $i++) {
            unset($data);
            if (!isset($RFQId) || !empty($RFQId) || $RFQId != null) {
                $data['staff_id'] = $EmailCCUsersListkeys[$i];
                $data['RFQId'] = $id;
                $this->db->insert(db_prefix().'rfq_cc_emails', $data);
            } else {
                $data['staff_id'] = $EmailCCUsersListkeys[$i];
                $data['RFQId'] = $id;
                $this->db->insert(db_prefix().'rfq_cc_emails', $data);
            }
        }


      
        unset($data);
        /* if (count($SupplierList)>0) 
        { */
            $this->db->where('RFQId', $id);
            $this->db->delete(db_prefix().'rfq_supplier');
            for ($i = 0; $i < count($SupplierList); $i++) {
                unset($data);
                $supplier_id = $SupplierList[$i];
                if (!isset($RFQId) || !empty($RFQId) || $RFQId != null) {
                    $data['supplier_id'] = $supplier_id;
                    $data['RFQId'] = $id;
                } else {
                    $data['supplier_id'] = $supplier_id;
                    $data['RFQId'] = $id;
                }
                $this->db->insert(db_prefix().'rfq_supplier',$data);
            }
        //}

        $this->db->where('RFQId', $id);
        $this->db->delete(db_prefix().'rfq_supplier_contact');
        if(isset($SupplierContactList))
        {
            if (count($SupplierContactList)>0) {
                for ($i = 0; $i < count($SupplierContactList); $i++) {
                    unset($data);
                    $supplier_contact_id = $SupplierContactList[$i];
                    if (!isset($RFQId) || !empty($RFQId) || $RFQId != null) {
                        $data['supplier_contact_id'] = $supplier_contact_id;
                        $data['RFQId'] = $id;
                    } else {
                        $data['supplier_contact_id'] = $supplier_contact_id;
                        $data['RFQId'] = $id;
                    }
                    $this->db->insert(db_prefix().'rfq_supplier_contact',$data);

                }
            }
        }
          

            if (!isset($id) || !empty($id) || $id != null) {
                $this->db->where('RFQId', $id);
                $this->db->delete(db_prefix().'rfq_attirbute_item_list');

                $this->db->where('RFQId', $id);
                $this->db->delete(db_prefix().'rfq_columns_list');

                $this->db->where('RFQId', $id);
                $this->db->delete(db_prefix().'rfq_template_list');
            }
            foreach ($Tampletes as $key => $Attributes) {
                unset($data);
                $data['templateName'] = $key;
                $data['RFQId'] = $id;
                $this->db->insert(db_prefix().'rfq_template_list',$data);
                $TemlateId = $this->db->insert_id();
                $Columns = [];
                foreach ($Tampletes[$key]['Columns'] as $Column) {
                    unset($data);
                    $data['TemplateId'] = $TemlateId;
                    $data['ColumnName'] = $Column;
                    $data['RFQId'] = $id;
                    $this->db->insert(db_prefix().'rfq_columns_list',$data);
                    $ColumnId = $this->db->insert_id();
                    $Columns[] = $ColumnId;
                }
                $Rows = [];
                foreach ($Tampletes[$key]['Rows'] as $Row) {
                    $Rows[] = $Row;
                }
                for ($i = 0; $i < count($Rows); $i++) {
                    foreach ($Rows[$i] as $Column) {
                        unset($data);
                        $data['ColumnId'] = $Columns[$i];
                        $data['description'] = $Column;
                        $data['RFQId'] = $id;
                        $this->db->insert(db_prefix().'rfq_attirbute_item_list',$data);
                    }
                }
            }
        }

return $id;

    }




















    public function delete_RFQ($data)
    {

        $id = $data['id'];
        $this->db->where('id', $id);
        $this->db->delete(db_prefix().'rfqs');

        $this->db->where('RFQId', $id);
        $this->db->delete(db_prefix().'rfq_cc_emails');

        $this->db->where('RFQId', $id);
        $this->db->delete(db_prefix().'rfq_supplier');

        $this->db->where('RFQId', $id);
        $this->db->delete(db_prefix().'rfq_supplier_contact');

        $this->db->where('RFQId', $id);
        $this->db->delete(db_prefix().'rfq_attirbute_item_list');

        $this->db->where('RFQId', $id);
        $this->db->delete(db_prefix().'rfq_columns_list');

        $this->db->where('RFQId', $id);
        $this->db->delete(db_prefix().'rfq_template_list');

        return $id;

    }






















}

<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Suppliers_model extends App_Model
{
    public function get($id = '', $where = [], $isliking = 0)
    {
        if ((is_array($where) && count($where) > 0) || (is_string($where) && $where != '')) {

            if ($isliking == 0)
            $this->db->where($where);
            else{
            $this->db->like('supplier_code', $where, 'both'); 
            $this->db->or_like('firstname', $where, 'both');
            $this->db->or_like('middlename', $where, 'both');
            $this->db->or_like('lastname', $where, 'both');
            $this->db->or_like('company', $where, 'both');
            $this->db->or_like('display_name_as', $where, 'both');
            $this->db->or_like('email', $where, 'both');
            $this->db->or_like('phone', $where, 'both');
            $this->db->or_like('mobile', $where, 'both');
            $this->db->or_like('website', $where, 'both');
                }
        }
        if (is_numeric($id)) {
            $this->db->where('id', $id);

            return $this->db->get(db_prefix() . 'suppliers')->row();
        }
        return $this->db->get(db_prefix() . 'suppliers')->result_array();
    }

    public function get_selected_rfq_supplier($RFQId = '', $where = [])
    {
        $this->db->select("id,title,supplier_code, firstname,lastname, company, email,IF(id in (select supplier_id from ".db_prefix() .'rfq_supplier where '.db_prefix() .'rfq_supplier.RFQId=' .$RFQId ."),'checked', '') as selected,keywords",
        );
        return $this->db->get(db_prefix() . 'suppliers')->result_array();
    }


    public function get_rfq_supplier($RFQId = '', $where = [])
    {
        $this->db->select('*');
$this->db->from(db_prefix() . 'suppliers');
$this->db->join(db_prefix() . 'rfq_supplier', db_prefix() . 'rfq_supplier.supplier_id='.db_prefix() . 'suppliers.id');
$this->db->where('RFQId',$RFQId);
$query = $this->db->get();
        return $query->result();
    }

    public function get_selected_rfq_supplier_contacts($supplier_id = '', $RFQId = '', $where = [])
    {
        if (is_null($RFQId)) {
            $this->db->select(
                "supplier_contact_id,title, firstname,lastname, email,
                    IF(supplier_contact_id in (select supplier_contact_id from " .
                    db_prefix() .
                    "rfq_supplier_contact
                    where " .
                    db_prefix() .
                    'rfq_supplier_contact.RFQId=' .
                    $RFQId .
                    "), 'checked', '') as selected",
            );
        } else {
            $this->db->select('*');
        }

        if (is_null($supplier_id)) {
            $this->db->where('supplier_id', $supplier_id);
        }
        return $this->db->get(db_prefix() . 'supplier_contacts')->result_array();
    }

    public function get_rfq_supplier_contacts($supplier_id = '', $RFQId = '', $where = [])
    {
        $this->db->select('*');
        $this->db->from(db_prefix() . 'supplier_contacts');
        $this->db->join(db_prefix() . 'rfq_supplier_contact', db_prefix() . 'rfq_supplier_contact.supplier_id='.db_prefix() . 'supplier_contacts.id');
        $this->db->where('RFQId',$RFQId);
        $query = $this->db->get();
        return $query->result();
        
    }

    public function get_supplier_contact($id='', $where = [])
    {
        if ((is_array($where) && count($where) > 0) || (is_string($where) && $where != '')) {
            $this->db->where($where);
        }
        if (is_numeric($id)) {
            $this->db->where('id', $id);

            return $this->db->get(db_prefix() . 'supplier_contacts')->row();
        }
        return $this->db->get(db_prefix() . 'supplier_contacts')->result_array();
    }
}

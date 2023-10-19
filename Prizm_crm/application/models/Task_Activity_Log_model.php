<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Task_Activity_Log_model extends App_Model
{
    /**
     * Add new Task Activity Log
     * @param mixed $data
     */
    public function add($data)
    {

        $this->db->insert(db_prefix() . 'tasklog', $data);
        $insert_id = $this->db->insert_id();

        if ($insert_id) {
            return $insert_id;
        }

        return false;
    }


    public function get_Alltask_log_detail($taskid)
    {
        $this->db->select(db_prefix() .'tasklog.*,'.db_prefix() . 'staff.employee_code,' . db_prefix() . 'staff.firstname,' . db_prefix() . 'staff.lastname,' . db_prefix() . 'staff.staffid');
        $this->db->from(db_prefix() . 'staff');
        $this->db->join(db_prefix() . 'tasklog', db_prefix() . 'tasklog.fkstaffid = ' . db_prefix() . 'staff.staffid', 'inner');
        $this->db->where(db_prefix() . 'tasklog.fktaskid', $taskid);
        $this->db->order_by('adddate', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    
    }






   
}

<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Task_model extends CI_Model
{


    function taskListingCount()
    {
        $this->db->select('BaseTbl.id, BaseTbl.name, BaseTbl.description, User.name, BaseTbl.status, BaseTbl.create_date');
        $this->db->from('tbl_tasks as BaseTbl');
        $this->db->join('tbl_users as User', 'User.userId = BaseTbl.user_id');

        $query = $this->db->get();
        
        return $query->num_rows();
    }
    function taskListing($page, $segment,$id)
    {
        
        $this->db->select('BaseTbl.*, tbl_users.name as user_name');
        $this->db->from('tbl_tasks as BaseTbl, tbl_users ');
        $this->db->where('tbl_users.userId = BaseTbl.user_id');
        
        if($id!=1){
            $this->db->where('BaseTbl.user_id='.$id);
        }

        $this->db->order_by('BaseTbl.id', 'DESC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result(); 
        // echo "<pre>";
        // print_r($result);       
        // echo "<pre>";    
        // die;   
        return $result;
    }
    function addNewtask($taskInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_tasks', $taskInfo);
        
        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();
        return $insert_id;
    }

    function getTaskInfo($user_id)
    {
        $this->db->select('id, name, description, task_id, status,create_date');
        $this->db->from('tbl_tasks');
        $this->db->where('id', $user_id);
        $query = $this->db->get();
        
        return $query->row();
    }

    function getUsers()
    {
        $this->db->select('userId, name');
        $this->db->from('tbl_users');
        $this->db->where('userId !=', 1);
        $query = $this->db->get();
        
        return $query->result();
    }
    
    function editTask($taskInfo, $taskId)
    {
        $this->db->where('id', $taskId);
        $this->db->update('tbl_tasks', $taskInfo);
        
        return TRUE;
    }
    
    
    function deleTetask($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('tbl_tasks');
    }
}

  
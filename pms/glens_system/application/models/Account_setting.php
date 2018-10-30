<?php
defined('BASEPATH') OR exit('');


class Account_setting extends CI_Model{
    public function __construct(){
        parent::__construct();
    }
   
    /**
     * 
     * @param type $admin_id
     * @return boolean
     */
    public function update_last_login($admin_id){
        $this->db->where('id', $admin_id);
        
        //set the datetime based on the db driver in use
        $this->db->platform() == "sqlite3" 
                ? 
        $this->db->set('last_login', "datetime('now')", FALSE) 
                : 
        $this->db->set('last_login', "NOW()", FALSE);
        
        $this->db->update('admin');
        
        if(!$this->db->error()){
            return TRUE;
        }
        
        else{
            return FALSE;
        }
    }
    
    
    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
    
    /**
     * Get some details about an admin (stored in session)
     * @param type $email
     * @return boolean
     */
    public function get_admin_info($email){
        $this->db->select('id, first_name, last_name, role');
        $this->db->where('email', $email);

        $run_q = $this->db->get('admin');

        if($run_q->num_rows() > 0){
            return $run_q->result();
        }

        else{
            return FALSE;
        }
    }


    
    /**
     * 
     * @param type $orderBy
     * @param type $orderFormat
     * @param type $start
     * @param type $limit
     * @return boolean
     */
    public function getAll($orderBy = "first_name", $orderFormat = "ASC", $start = 0, $limit = ""){
        $this->db->select('id, first_name, last_name, email, role, mobile1, mobile2, created_on, last_login, account_status, deleted');
        $this->db->where("id = ", $_SESSION['admin_id']);
        $this->db->where("email = ", $_SESSION['admin_email']);//added to prevent people from removing the demo admin account
        $this->db->limit($limit, $start);
        $this->db->order_by($orderBy, $orderFormat);
        
        $run_q = $this->db->get('admin');
        
        if($run_q->num_rows() > 0){
            return $run_q->result();
        }
        
        else{
            return FALSE;
        }
    }
    


    
    public function update($admin_id, $first_name, $last_name, $email, $password, $mobile1, $mobile2, $role){
        $data = ['first_name'=>$first_name, 'last_name'=>$last_name, 'mobile1'=>$mobile1, 'mobile2'=>$mobile2, 'email'=>$email, 'password'=>$password, 
            'role'=>$role];
        
        $this->db->where('id', $admin_id);
        
        $this->db->update('admin', $data);
        
        return TRUE;
    }
    
    
    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
    
    
   
}

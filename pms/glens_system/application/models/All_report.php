<?php
defined('BASEPATH') OR exit(':D');

class All_report extends CI_Model{
    
    public function __construct() {
        parent::__construct();
    }
    

    
    public function get_Items(){
            $this->db->select('*');
            $this->db->order_by('items.name', 'DESC');
            $run_q = $this->db->get('items');
               
        return $run_q->num_rows() ? $run_q->result() : FALSE;
    }

    public function get_cancel_orders(){
            $this->db->select('transactions.ref,
                               transactions.totalMoneySpent, 
                               transactions.pick_date,
                               transactions.cust_name, 
                               transactions.cust_phone,
                               transactions.totalMoneySpent, 
                               transactions.cust_address, 
                               transactions.cust_email');

            $this->db->select_sum('transactions.quantity');
            $this->db->order_by('transactions.ref', 'DESC');
            $this->db->where('status','Cancel');
            $this->db->group_by('ref');
            $run_q = $this->db->get('transactions');
               
        return $run_q->num_rows() ? $run_q->result() : FALSE;
    }
}
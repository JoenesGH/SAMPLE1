<?php
class shop_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_all(){
        $query=$this->db->query("SELECT name.*
                                 FROM items name 
                                 WHERE quantity >= 1 
                                 ORDER BY name.name ASC");

        return $query->result_array();
    }

     public function myOrder_all($data){
    
        $this->db->select('*');
        $this->db->select_sum('transactions.quantity');
        $this->db->where('cust_email', $this->session->userdata['email']);
        $this->db->group_by('ref');
        $run_q = $this->db->get('transactions');
        
        if($run_q->num_rows() > 0){
            return $run_q->result();
        }
        
        else{
            return FALSE;
        }
    }

    // Insert customer details in "customer" table in database.
    public function insert_reserved($data)
    {
        $this->db->insert('transactions', $data);
        $id = $this->db->insert_id();
        return (isset($id)) ? $id : FALSE;
    }


    public function isRefExist($ref) {
        $q = "SELECT DISTINCT ref FROM transactions WHERE ref = ?";

        $run_q = $this->db->query($q, [$ref]);

        if ($run_q->num_rows() > 0) {
            return TRUE;
        }
        else {
            return FALSE;
        }
    }
   
   public function get_items($limit, $start,$st = "", $orderField, $orderDirection)
    {

         $query = $this->db->or_like('name', $st)->limit($limit, $start)->order_by($orderField, $orderDirection)->where('quantity >= 1')->get('items');
        return $query->result();
        
    }

    public function count_items($limit, $start, $st = "", $orderField, $orderDirection)
    {
        
         $query = $this->db->or_like('name', $st)->order_by($orderField, $orderDirection)->where('quantity >= 1')->get('items');
        return $query->num_rows();
    }

}
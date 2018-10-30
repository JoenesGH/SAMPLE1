<?php
defined('BASEPATH') OR exit('');

class Cat extends CI_Model{
    public function __construct(){
        parent::__construct();
    }
    

    public function getAll($orderBy, $orderFormat, $start=0, $limit=''){
        $this->db->limit($limit, $start);
        $this->db->order_by($orderBy, $orderFormat);
        
        $run_q = $this->db->get('category');
        
        if($run_q->num_rows() > 0){
            return $run_q->result();
        }
        
        else{
            return FALSE;
        }
    }
    
 
    public function add($itemName){
        $data = ['name'=>$itemName];
                
        //set the datetime based on the db driver in use
        $this->db->platform() == "sqlite3" 
                ? 
        $this->db->set('dateAdded', "datetime('now')", FALSE) 
                : 
        $this->db->set('dateAdded', "NOW()", FALSE);
        
        $this->db->insert('category', $data);
        
        if($this->db->insert_id()){
            return $this->db->insert_id();
        }
        
        else{
            return FALSE;
        }
    }
    
 
    public function itemsearch($value){
        $q = "SELECT * FROM category 
            WHERE 
            name LIKE '%".$this->db->escape_like_str($value)."%'";
        
        $run_q = $this->db->query($q, [$value]);
        
        if($run_q->num_rows() > 0){
            return $run_q->result();
        }
        
        else{
            return FALSE;
        }
    }
    
   
  
   public function edit($itemId, $itemName){
       $data = ['name'=>$itemName];
       
       $this->db->where('id', $itemId);
       $this->db->update('category', $data);
       
       return TRUE;
   }
   


    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */

    /**
     * array $where_clause
     * array $fields_to_fetch
     * 
     * return array | FALSE
     */
    public function getItemInfo($where_clause, $fields_to_fetch){
        $this->db->select($fields_to_fetch);
        
        $this->db->where($where_clause);

        $run_q = $this->db->get('category');
        
        return $run_q->num_rows() ? $run_q->row() : FALSE;
    }
    
    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */

    public function getItemsCumTotal(){

        $run_q = $this->db->get('category');
        
    }
}
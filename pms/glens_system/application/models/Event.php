<?php
defined('BASEPATH') OR exit('');

class Event extends CI_Model{
    public function __construct(){
        parent::__construct();
    }
    

    public function getAll($orderBy, $orderFormat, $start=0, $limit=''){
        $this->db->limit($limit, $start);
        $this->db->order_by($orderBy, $orderFormat);
        
        $run_q = $this->db->get('eventlog');
        
        if($run_q->num_rows() > 0){
            return $run_q->result();
        }
        
        else{
            return FALSE;
        }
    }
    
 
  
    
 
    public function itemsearch($value){
        $q = "SELECT * FROM eventlog 
            WHERE 
            event LIKE '%".$this->db->escape_like_str($value)."%'";
        
        $run_q = $this->db->query($q, [$value]);
        
        if($run_q->num_rows() > 0){
            return $run_q->result();
        }
        
        else{
            return FALSE;
        }
    }
    
   

    public function getItemInfo($where_clause, $fields_to_fetch){
        $this->db->select($fields_to_fetch);
        
        $this->db->where($where_clause);

        $run_q = $this->db->get('eventlog');
        
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

        $run_q = $this->db->get('eventlog');
        
    }
}
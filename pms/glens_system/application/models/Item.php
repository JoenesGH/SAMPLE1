<?php
defined('BASEPATH') OR exit('');

class Item extends CI_Model{
    public function __construct(){
        parent::__construct();
    }
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
   // GET DATA FROM DATABASE 
    public function getAll($orderBy, $orderFormat, $start=0, $limit=''){
        $this->db->limit($limit, $start);
        $this->db->order_by($orderBy, $orderFormat);
        $this->db->select('items.id,
                           items.code,
                           items.name,
                           items.batch_number,
                           items.description,
                           items.unitPrice,
                           items.sellPrice,
                           items.quantity,
                           items.prescription,
                           items.category,
                           items.unit,
                           items.date_expire,
                           items.dateAdded,
                           items.lastUpdated,
                           items.notif,
                           CONCAT_WS(" ", category.name) as "cats"');
       
        $this->db->join('category', 'items.category = category.id', 'LEFT');

        $run_q = $this->db->get('items');
        
        if($run_q->num_rows() > 0){
            return $run_q->result();
        }
        
        else{
            return FALSE;
        }
    }

//GET CATEGORY FROM DATABSE
     public function getCategory(){
        $this->db->select('*');
        $run_q = $this->db->get('category');     
        if($run_q->num_rows() > 0){
            return $run_q->result();
        }
        
        else{
            return FALSE;
        }
    }

 ///POP UP WARNING
    public function pwaning($orderBy, $orderFormat, $start=0, $limit=''){
        $this->db->limit($limit, $start);
        $this->db->order_by($orderBy, $orderFormat);
        $this->db->where('quantity <= 50');
        $this->db->where('notif','1');

        $run_q = $this->db->get('items');
        
        if($run_q->num_rows() > 0){
            return $run_q->result();
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
     * 
     * @param type $itemName
     * @param type $itemQuantity
     * @param type $itemPrice
     * @param type $itemDescription
     * @param type $itemCode
     * @return boolean
     */
    public function add($itemName,$itemBatch,$prescription,$category,$unit,$itemDex, $itemQuantity, $itemPrice,$itemUnit, $itemDescription, $itemCode){
        $data = ['name'=>$itemName,'batch_number'=>$itemBatch,'prescription'=>$prescription,'category'=>$category,'unit'=>$unit,'date_expire'=>$itemDex, 'quantity'=>$itemQuantity, 'unitPrice'=>$itemPrice,'sellPrice'=>$itemUnit, 'description'=>$itemDescription, 'code'=>$itemCode];
                
        //set the datetime based on the db driver in use
        $this->db->platform() == "sqlite3" 
                ? 
        $this->db->set('dateAdded', "datetime('now')", FALSE) 
                : 
        $this->db->set('dateAdded', "NOW()", FALSE);
        
        $this->db->insert('items', $data);
        
        if($this->db->insert_id()){
            return $this->db->insert_id();
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
     * 
     * @param type $value
     * @return boolean
     */
    public function itemsearch($value){
        $q = "SELECT * FROM items 
            WHERE 
            name LIKE '%".$this->db->escape_like_str($value)."%'
            || 
            code LIKE '%".$this->db->escape_like_str($value)."%'";
        
        $run_q = $this->db->query($q, [$value, $value]);
        
        if($run_q->num_rows() > 0){
            return $run_q->result();
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
     * To add to the number of an item in stock
     * @param type $itemId
     * @param type $numberToadd
     * @return boolean
     */
    public function incrementItem($itemId, $numberToadd){
        $q = "UPDATE items SET quantity = quantity + ? WHERE id = ?";
        
        $this->db->query($q, [$numberToadd, $itemId]);
        
        if($this->db->affected_rows() > 0){
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
    
    public function decrementItem($itemCode, $numberToRemove){
        $q = "UPDATE items SET quantity = quantity - ? WHERE code = ?";
        
        $this->db->query($q, [$numberToRemove, $itemCode]);
        
        if($this->db->affected_rows() > 0){
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
    
    
   public function newstock($itemId, $qty){
       $q = "UPDATE items SET quantity = quantity + $qty WHERE id = ?";
       
       $this->db->query($q, [$itemId]);
       
       if($this->db->affected_rows()){
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
   
   public function deficit($itemId, $qty){
       $q = "UPDATE items SET quantity = quantity - $qty WHERE id = ?";
       
       $this->db->query($q, [$itemId]);
       
       if($this->db->affected_rows()){
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
    * 
    * @param type $itemId
    * @param type $itemName
    * @param type $itemDesc
    * @param type $itemPrice
    */
   public function edit($itemId,$itemCode,$itemName,$itemBatch,$itemPrescription,$itemCategory,$itemDex,$itemDesc, $itemPrice,$itemUnit){
       $data = ['code'=>$itemCode,'name'=>$itemName,'batch_number'=>$itemBatch,'prescription'=>$itemPrescription,'category'=>$itemCategory,'date_expire'=>$itemDex, 'unitPrice'=>$itemPrice,'sellPrice'=>$itemUnit, 'description'=>$itemDesc];
       
       $this->db->where('id', $itemId);
       $this->db->update('items', $data);
       
       return TRUE;
   }
   
   
   public function suspend($items_id, $new_status){       
        $this->db->where('id', $items_id);
        $this->db->update('items', ['notif'=>$new_status]);

        if($this->db->affected_rows()){
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
   
	public function getActiveItems($orderBy, $orderFormat){
        $this->db->order_by($orderBy, $orderFormat);
		
		$this->db->where('quantity >=', 1);
        
        $run_q = $this->db->get('items');
        
        if($run_q->num_rows() > 0){
            return $run_q->result();
        }
        
        else{
            return FALSE;
        }
    }


    public function getActiveItems2($orderBy, $orderFormat){
        $this->db->order_by($orderBy, $orderFormat);
        
        
        
        $run_q = $this->db->get('walkin_register');
        
        if($run_q->num_rows() > 0){
            return $run_q->result();
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
     * array $where_clause
     * array $fields_to_fetch
     * 
     * return array | FALSE
     */
    public function getItemInfo($where_clause, $fields_to_fetch){
        $this->db->select($fields_to_fetch);
        
        $this->db->where($where_clause);

        $run_q = $this->db->get('items');
        
        return $run_q->num_rows() ? $run_q->row() : FALSE;
    }

    public function getItemInfo2($where_clause, $fields_to_fetch){
        $this->db->select($fields_to_fetch);
        
        $this->db->where($where_clause);

        $run_q = $this->db->get('walkin_register');
        
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
        $this->db->select("SUM(unitPrice*quantity) as cumPrice");

        $run_q = $this->db->get('items');
        
        return $run_q->num_rows() ? $run_q->row()->cumPrice : FALSE;
    }

    public function trash($items_id, $new_value){       
        $this->db->where('id', $items_id);
        $this->db->update('items', ['deleted'=>$new_value]);
       
        if($this->db->affected_rows()){
            return TRUE;
        }

        else{
            return FALSE;
        }
   }

}
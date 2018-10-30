<?php
defined('BASEPATH') OR exit('');

class Sms_notif extends CI_Model{
    public function __construct(){
        parent::__construct();
    }
    

    public function getAll($orderBy, $orderFormat, $start=0, $limit=''){
        $this->db->limit($limit, $start);
        $this->db->order_by($orderBy, $orderFormat);
        $this->db->group_by('cust_name');
        //only for available mobile numbers
        $this->db->where('cust_phone >= 1');
        
        $run_q = $this->db->get('transactions');
        
        if($run_q->num_rows() > 0){
            return $run_q->result();
        }
        
        else{
            return FALSE;
        }
    }
    
 
    public function itemsearch($value){
        $q = "SELECT * FROM transactions 
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
    
   
  
   public function edit($itemId, $itemName, $itemMobile, $itemSms){
       $data = ['cust_name'=>$itemName,'cust_phone'=>$itemMobile,'sent_sms'=>$itemSms];

       $this->db->where('transId', $itemId);
       $this->db->update('transactions', $data);
       
       return TRUE;
   }

  //API ONE WAY SMS
  // to Send Message to loyal customer
   public function gw_send_sms($user,$pass,$sms_from,$sms_to,$sms_msg)  
            {           
                        $query_string = "api.aspx?apiusername=".$user."&apipassword=".$pass;
                        $query_string .= "&senderid=".rawurlencode($sms_from)."&mobileno=".rawurlencode($sms_to);
                        $query_string .= "&message=".rawurlencode(stripslashes($sms_msg)) . "&languagetype=1";        
                        $url = "http://gateway.onewaysms.com.au:10001/".$query_string;       
                        $fd = @implode ('', file ($url));      
                        if ($fd)  
                        {                       
                    if ($fd > 0) {
                    Print("MT ID : " . $fd);
                    $ok = "success";
                    }        
                    else {
                    print("Please refer to API on Error : " . $fd);
                    $ok = "fail";
                    }
                        }           
                        else      
                        {                       
                                    // no contact with gateway                      
                                    $ok = "fail";       
                        }           
                        return $ok;  
            }  
  

    /**
     * array $where_clause
     * array $fields_to_fetch
     * 
     * return array | FALSE
     */
    public function getItemInfo($where_clause, $fields_to_fetch){
        $this->db->select($fields_to_fetch);
        
        $this->db->where($where_clause);

        $run_q = $this->db->get('transactions');
        
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

        $run_q = $this->db->get('transactions');
        
    }
}
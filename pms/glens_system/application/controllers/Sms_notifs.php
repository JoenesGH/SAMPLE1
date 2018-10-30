<?php
defined('BASEPATH') OR exit('');

class Sms_notifs extends CI_Controller{
    
    public function __construct(){
        parent::__construct();
        
        $this->genlib->checkLogin();
        
        $this->load->model(['sms_notif']);
    }
    
   
    public function index(){
        $data['pageContent'] = $this->load->view('send_sms/sms_notifs', '', TRUE);
        $data['pageTitle'] = "SMS";
        $this->load->view('main', $data);
    }
    
  
    public function lilt(){
        $this->genlib->ajaxOnly();
        
        $this->load->helper('text');
        
        //set the sort order
        $orderBy = $this->input->get('orderBy', TRUE) ? $this->input->get('orderBy', TRUE) : "cust_name";
        $orderFormat = $this->input->get('orderFormat', TRUE) ? $this->input->get('orderFormat', TRUE) : "ASC";
        
        //count the total number of items in db
        $totalItems = $this->db->count_all('transactions');
        
        $this->load->library('pagination');
        
        $pageNumber = $this->uri->segment(3, 0);//set page number to zero if the page number is not set in the third segment of uri
	
        $limit = $this->input->get('limit', TRUE) ? $this->input->get('limit', TRUE) : 10;//show $limit per page
        $start = $pageNumber == 0 ? 0 : ($pageNumber - 1) * $limit;//start from 0 if pageNumber is 0, else start from the next iteration
        
        //call setPaginationConfig($totalRows, $urlToCall, $limit, $attributes) in genlib to configure pagination
        $config = $this->genlib->setPaginationConfig($totalItems, "sms_notifs/lilt", $limit, ['onclick'=>'return lilt(this.href);']);
        
        $this->pagination->initialize($config);//initialize the library class
        
        //get all items from db
        $data['topCustomer'] = $this->sms_notif->getAll($orderBy, $orderFormat, $start, $limit);
        $data['range'] = $totalItems > 0 ? "Showing " . ($start+1) . "-" . ($start + count($data['topCustomer'])) . " of " . $totalItems : "";
        $data['links'] = $this->pagination->create_links();//page links
        $data['sn'] = $start+1;
        $data['cum_total'] = $this->sms_notif->getItemsCumTotal();
        
        $json['itemsListTable'] = $this->load->view('send_sms/smslisttable', $data, TRUE);//get view with populated items table

        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
    

    public function edit(){
        $this->genlib->ajaxOnly();
        
        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters('', '');
        
        $this->form_validation->set_rules('_itransId', 'Item ID', ['required', 'trim', 'numeric']);
        $this->form_validation->set_rules('itemName', 'Customer Full Name', ['required', 'trim',
            'callback_crosscheckName['.$this->input->post('_itransId', TRUE).']'], ['required'=>'required']);
        $this->form_validation->set_rules('itemMobile', 'Mobile', ['required', 'trim' ]);
        $this->form_validation->set_rules('itemSms', 'Message', ['required', 'trim' ]);

        
        $this->form_validation->set_rules(['trim']);
        
        if($this->form_validation->run() !== FALSE){
            $itemId = set_value('_itransId');
            $itemName = set_value('itemName');
            $itemMobile = set_value('itemMobile');
            $itemSms = set_value('itemSms');
           //API ONE WAY SMS
            $sms_to = set_value('itemMobile');
            $sms_msg = set_value('itemSms');
            $user = 'API527JVSP3BH';
            $pass = 'API527JVSP3BHBNPC4';
            $sms_from = 'senderid';
           
            
            //update sms message in db
            $updated = $this->sms_notif->edit($itemId, $itemName, $itemMobile, $itemSms);
            $json['status'] = $updated ? 1 : 0;     

            // to Send SMS Message to loyal Customer
            $sms = $this->sms_notif->gw_send_sms($user,$pass,$sms_from,$sms_to,$sms_msg);
            $json['status'] = $sms ? 1 : 0;
            
            //add event to log
            //function header: addevent($event, $eventRowId, $eventDesc, $eventTable, $staffId)
            $desc = "Send SMS to $itemName, $itemMobile, $itemSms";
            
            $this->genmod->addevent("Notification", $itemId, $desc, 'SMS', $this->session->admin_id);
        }
        
        else{
            $json['status'] = 0;
            $json = $this->form_validation->error_array();
        }
        
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }

    
    public function crosscheckName($itemName, $itemId){
        //check db to ensure name was previously used for the item we are updating
        $itemWithName = $this->genmod->getTableCol('transactions', 'transId', 'cust_name', $itemName);
        
        //if item name does not exist or it exist but it's the name of current item
        if(!$itemWithName || ($itemWithName == $itemId)){
            return TRUE;
        }
        
        else{//if it exist
            $this->form_validation->set_message('crosscheckName', 'There is an  user with this name');
                
            return FALSE;
        }
    }
    
}
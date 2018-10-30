<?php
defined('BASEPATH') OR exit('');

class Items extends CI_Controller{
    
    public function __construct(){
        parent::__construct();
        
        $this->genlib->checkLogin();
        
        $this->load->model(['item']);
    }
    
    public function index(){     
         //out of stock warning
        $data['waning_stock'] =  $this->db->where('quantity <= 50')->from("items")->count_all_results();
        //out of stock warning
        $data['waning_expired'] =  $this->db->where('date_expire <= NOW()')->from("items")->count_all_results();
        $data['Category'] = $this->item->getCategory();
        //$data['pageContent'] = $this->load->view('items/items', '', TRUE);  
        $data['pageContent'] = $this->load->view('items/items', $data, TRUE);
        $data['pageTitle'] = "Items";

        $this->load->view('main', $data);
    }
    
    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
    
    /**
     * "lilt" = "load Items List Table"
     */
    public function lilt(){
        $this->genlib->ajaxOnly();
        
        $this->load->helper('text');
        
        //set the sort order
        $orderBy = $this->input->get('orderBy', TRUE) ? $this->input->get('orderBy', TRUE) : "name";
        $orderFormat = $this->input->get('orderFormat', TRUE) ? $this->input->get('orderFormat', TRUE) : "ASC";
        
        //count the total number of items in db
        $totalItems = $this->db->count_all('items');
        
        $this->load->library('pagination');
        
        $pageNumber = $this->uri->segment(3, 0);//set page number to zero if the page number is not set in the third segment of uri
    
        $limit = $this->input->get('limit', TRUE) ? $this->input->get('limit', TRUE) : 10;//show $limit per page
        $start = $pageNumber == 0 ? 0 : ($pageNumber - 1) * $limit;//start from 0 if pageNumber is 0, else start from the next iteration
        
        //call setPaginationConfig($totalRows, $urlToCall, $limit, $attributes) in genlib to configure pagination
        $config = $this->genlib->setPaginationConfig($totalItems, "items/lilt", $limit, ['onclick'=>'return lilt(this.href);']);
        
        $this->pagination->initialize($config);//initialize the library class
        // POPUP WARNING
        $data['PWarning'] = $this->item->pwaning($orderBy, $orderFormat, $start, $limit);
        $data['sn2'] = $start+1;
        
        //items list
        $data['allItems'] = $this->item->getAll($orderBy, $orderFormat, $start, $limit);
        $data['range'] = $totalItems > 0 ? "Showing " . ($start+1) . "-" . ($start + count($data['allItems'])) . " of " . $totalItems : "";
        $data['links'] = $this->pagination->create_links();//page links
        $data['sn'] = $start+1;
        $data['cum_total'] = $this->item->getItemsCumTotal();
        
        $json['itemsListTable'] = $this->load->view('items/itemslisttable', $data, TRUE);//get view with populated items table

        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
    
    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
    
    
    //To upload image to items table
    private function do_upload($file, $name=''){

        if (!file_exists('./images/')) {
            mkdir('./images/', 0777, true);
        }

        $config['upload_path']          = './images/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 100;
        $config['max_width']            = 1024;
        $config['max_height']           = 768;
        $config['file_name']            = $name;
        $config['overwrite']            = TRUE;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload($file))
        {
                $error = array('error' => $this->upload->display_errors());

                return $error;
        }
        else
        {
                $data = array('upload_data' => $this->upload->data());

                return $data;
        }
    }    
    
    public function add(){
        // $this->genlib->ajaxOnly();
        if (!$this->input->is_ajax_request()) {
           redirect(base_url(), 'refresh');
        }


        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters('', '');
        
        $this->form_validation->set_rules('itemName', 'Item name', ['required', 'trim', 'max_length[80]', 'is_unique[items.name]'],
                ['required'=>"required"]);
        $this->form_validation->set_rules('itemBatch', 'Batch #', ['required', 'trim'],
                ['required'=>"required"]);
        $this->form_validation->set_rules('prescription', 'Prescription', ['required', 'trim'],
                ['required'=>"required"]);
        $this->form_validation->set_rules('category', 'Category', ['required', 'trim'],
                ['required'=>"required"]);
        $this->form_validation->set_rules('unit', 'M-Unit', ['required', 'trim'],
                ['required'=>"required"]);

        $this->form_validation->set_rules('itemQuantity', 'Item quantity', ['required', 'trim', 'numeric'], ['required'=>"required"]);
        $this->form_validation->set_rules('itemPrice', 'Item Price', ['required', 'trim', 'numeric'], ['required'=>"required"]);
        $this->form_validation->set_rules('itemUnit', 'Item Unit', ['required', 'trim', 'numeric'], ['required'=>"required"]);
        $this->form_validation->set_rules('itemCode', 'Item Code', ['required', 'trim', 'max_length[20]', 'is_unique[items.code]'], 
                ['required'=>"required", 'is_unique'=>"There is already an item with this code"]);
        
        if($this->form_validation->run() !== FALSE){
            $this->db->trans_start();//start transaction
            
            /**
             * insert info into db
             * function header: add($itemName, $itemQuantity, $itemPrice, $itemDescription, $itemCode)
             */
            $insertedId = $this->item->add($this->input->post('itemName'),$this->input->post('itemBatch'),$this->input->post('prescription'),$this->input->post('category'),$this->input->post('unit'),$this->input->post('itemDex'), $this->input->post('itemQuantity'), $this->input->post('itemPrice'),$this->input->post('itemUnit'), 
                    $this->input->post('itemDescription'), $this->input->post('itemCode'));
            
            $itemName = $this->input->post('itemName');
            $itemBatch = $this->input->post('itemBatch');
            $prescription = $this->input->post('prescription');
            $category = $this->input->post('category');
            $unit = $this->input->post('unit');
            $itemQty = $this->input->post('itemQuantity');
            $itemPrice = "Php ".number_format($this->input->post('itemPrice'), 2);
            $itemUnit = "Php ".number_format($this->input->post('itemUnit'), 2);
            
            //insert into eventlog
            //function header: addevent($event, $eventRowId, $eventDesc, $eventTable, $staffId)
            $desc = "Addition of {$itemQty} quantities of a new item '{$itemName}' with a Sell price of {$itemPrice} to stock";
            
            $insertedId ? $this->genmod->addevent("Creation of new item", $insertedId, $desc, "items", $this->session->admin_id) : "";
            
            $this->db->trans_complete();
            
            if ($this->db->trans_status() !== FALSE) {
                $upload  = $this->do_upload('itemImage', $insertedId);

                if ( isset($upload['upload_data']['file_name']) ) {
                    $this->db->where('id', $insertedId);
                    $this->db->update('items', array('image' => $upload['upload_data']['file_name']));

                    $json = ['status'=>1, 'msg'=> "Item successfully added."];
                }
                else {
                    $json = ['status'=>1, 'msg'=>"Item successfully added. But unable to upload image. <br>" . print_r($upload, 1)];
                }
            }
            else {
                $json = ['status'=>0, 'msg'=>"Oops! Unexpected server error! Please contact administrator for help. Sorry for the embarrassment"];
            }
        }
        
        else{
            //return all error messages
            $json = $this->form_validation->error_array();//get an array of all errors
            
            $json['msg'] = "One or more required fields are empty or not correctly filled";
            $json['status'] = 0;
        }
                    
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
    
    
    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
    
    
    /**
     * Primarily used to check whether an item already has a particular random code being generated for a new item
     * @param type $selColName
     * @param type $whereColName
     * @param type $colValue
     */
    public function gettablecol($selColName, $whereColName, $colValue){
        $a = $this->genmod->gettablecol('items', $selColName, $whereColName, $colValue);
        
        $json['status'] = $a ? 1 : 0;
        $json['colVal'] = $a;
        
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
    
    public function suspend(){
        $this->genlib->ajaxOnly();
        
        $items_id = $this->input->post('_aId');
        $new_status = $this->genmod->gettablecol('items', 'notif', 'id', $items_id) == 1 ? 0 : 1;
        
        $done = $this->item->suspend($items_id, $new_status);
        
        $json['status'] = $done ? 1 : 0;
        $json['_ns'] = $new_status;
        $json['_aId'] = $items_id;
        
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
    

    public function gcoandqty(){
        $json['status'] = 0;
        
        $itemCode = $this->input->get('_iC', TRUE);
        
        if($itemCode){
            $item_info = $this->item->getItemInfo(['code'=>$itemCode], ['quantity', 'unitPrice', 'prescription', 'description']);

            if($item_info){
                $json['availQty'] = (int)$item_info->quantity;
                $json['unitPrice'] = $item_info->unitPrice;
                $json['prescription'] = $item_info->prescription;
                

                $json['description'] = $item_info->description;
                $json['status'] = 1;
            }
        }
        
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }

     public function gcoandqty2(){
        $json['status'] = 0;
        
        $itemCode = $this->input->get('_iC', TRUE);
        
        if($itemCode){
            $item_info = $this->item->getItemInfo2(['vcard'=>$itemCode], ['vcard', 'pcard']);

            if($item_info){
                $json['vcard'] = $item_info->vcard;
                $json['pcard'] = $item_info->pcard;

                $json['status'] = 1;
            }
        }
        
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }

    
    
    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
    
    
    public function updatestock(){
        $this->genlib->ajaxOnly();
        
        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters('', '');
        
        $this->form_validation->set_rules('_iId', 'Item ID', ['required', 'trim', 'numeric'], ['required'=>"required"]);
        $this->form_validation->set_rules('_upType', 'Update type', ['required', 'trim', 'in_list[newStock,deficit]'], ['required'=>"required"]);
        $this->form_validation->set_rules('qty', 'Quantity', ['required', 'trim', 'numeric'], ['required'=>"required"]);
        $this->form_validation->set_rules('desc', 'Update Description', ['required', 'trim'], ['required'=>"required"]);
        
        if($this->form_validation->run() !== FALSE){
            //update stock based on the update type
            $updateType = set_value('_upType');
            $itemId = set_value('_iId');
            $qty = set_value('qty');
            $desc = set_value('desc');
            
            $this->db->trans_start();
            
            $updated = $updateType === "deficit" 
                    ? 
                $this->item->deficit($itemId, $qty, $desc) 
                    : 
                $this->item->newstock($itemId, $qty, $desc);
            
            //add event to log if successful
            $stockUpdateType = $updateType === "deficit" ? "Deficit" : "New Stock";
            
            $event = "Stock Update ($stockUpdateType)";
            
            $action = $updateType === "deficit" ? "removed from" : "added to";//action that happened
            
            $eventDesc = "<p>{$qty} quantities of {$this->genmod->gettablecol('items', 'name', 'id', $itemId)} was {$action} stock</p>
                Reason: <p>{$desc}</p>";
            
            //function header: addevent($event, $eventRowId, $eventDesc, $eventTable, $staffId)
            $updated ? $this->genmod->addevent($event, $itemId, $eventDesc, "items", $this->session->admin_id) : "";
            
            $this->db->trans_complete();//end transaction
            
            $json['status'] = $this->db->trans_status() !== FALSE ? 1 : 0;
            $json['msg'] = $updated ? "Stock successfully updated" : "Unable to update stock at this time. Please try again later";
        }
        
        else{
            $json['status'] = 0;
            $json['msg'] = "One or more required fields are empty or not correctly filled";
            $json = $this->form_validation->error_array();
        }
        
        
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
   
   
   /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
   
    public function edit(){
        $this->genlib->ajaxOnly();        
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('_iId', 'Item ID', ['required', 'trim', 'numeric']);
        $this->form_validation->set_rules('itemName', 'Item Name', ['required', 'trim', 
            'callback_crosscheckName['.$this->input->post('_iId', TRUE).']'], ['required'=>'required']);
        $this->form_validation->set_rules('itemBatch', 'Batch #', ['required', 'trim']);
        $this->form_validation->set_rules('itemPrescription', 'Types of drugs', ['required', 'trim']);
        $this->form_validation->set_rules('itemCategory', 'Category', ['required', 'trim']);       
        $this->form_validation->set_rules('itemDex', 'Date Expire', ['trim']);
        $this->form_validation->set_rules('itemCode', 'Item Code', ['required', 'trim', 
            'callback_crosscheckCode['.$this->input->post('_iId', TRUE).']'], ['required'=>'required']);
        $this->form_validation->set_rules('itemPrice', 'Item Sell Price', ['required', 'trim', 'numeric']);
        $this->form_validation->set_rules('itemUnit', 'Item Unit Price', ['required', 'trim', 'numeric']);
        $this->form_validation->set_rules('itemDesc', 'Item Description', ['trim']);
        
        if($this->form_validation->run() !== FALSE){
            $itemId = set_value('_iId');
            $itemDesc = set_value('itemDesc');
            $itemPrice = set_value('itemPrice');
            $itemUnit = set_value('itemUnit');
            $itemName = set_value('itemName');
            $itemBatch = set_value('itemBatch');
            $itemPrescription = set_value('itemPrescription');
            $itemCategory = set_value('itemCategory');        
            $itemDex = set_value('itemDex');
            $itemCode = $this->input->post('itemCode', TRUE);
            
            //update item in db
            $updated = $this->item->edit($itemId,$itemCode,$itemName,$itemBatch,$itemPrescription,$itemCategory,$itemDex,$itemDesc, $itemPrice, $itemUnit);
            
            $json['status'] = $updated ? 1 : 0;
            
            //add event to log
            //function header: addevent($event, $eventRowId, $eventDesc, $eventTable, $staffId)
            $desc = "Details of item with code '$itemCode' was updated";
            
            $this->genmod->addevent("Item Update", $itemId, $desc, 'items', $this->session->admin_id);
        }
        
        else{
            $json['status'] = 0;
            $json = $this->form_validation->error_array();
        }
        
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }




   /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
    
    public function crosscheckName($itemName, $itemId){
        //check db to ensure name was previously used for the item we are updating
        $itemWithName = $this->genmod->getTableCol('items', 'id', 'name', $itemName);
        
        //if item name does not exist or it exist but it's the name of current item
        if(!$itemWithName || ($itemWithName == $itemId)){
            return TRUE;
        }
        
        else{//if it exist
            $this->form_validation->set_message('crosscheckName', 'There is an item with this name');
                
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
     * @param type $item_code
     * @param type $item_id
     * @return boolean
     */
    public function crosscheckCode($item_code, $item_id){
        //check db to ensure item code was previously used for the item we are updating
        $item_with_code = $this->genmod->getTableCol('items', 'id', 'code', $item_code);
        
        //if item code does not exist or it exist but it's the code of current item
        if(!$item_with_code || ($item_with_code == $item_id)){
            return TRUE;
        }
        
        else{//if it exist
            $this->form_validation->set_message('crosscheckCode', 'There is an item with this code');
                
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
    
    
    public function delete(){
        $this->genlib->ajaxOnly();
        
        $json['status'] = 0;
        $item_id = $this->input->post('i', TRUE);
        
        if($item_id){
            $this->db->where('id', $item_id)->delete('items');
            
            $json['status'] = 1;
        }
        
        //set final output
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }

}
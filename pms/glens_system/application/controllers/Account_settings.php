<?php
defined('BASEPATH') OR exit('');

class Account_settings extends CI_Controller{
    
    public function __construct(){
        parent::__construct();
        
        $this->genlib->checkLogin();
        
        $this->genlib->superOnly();
        
        $this->load->model(['Account_setting']);
    }
    
    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
    
    public function index(){
        $data['waning_stock'] =  $this->db->where('quantity <= 50')->from("items")->count_all_results();//out of stock warning
        $data['waning_expired'] =  $this->db->where('date_expire <= NOW()')->from("items")->count_all_results();//out of stock warning
        $data['pageContent'] = $this->load->view('Account_settings/account_settings', '', TRUE);
        $data['pageTitle'] = "Account Settings";
        
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
     * lac_ = "Load all administrators"
     */
    public function laad_(){
        //set the sort order
        $orderBy = $this->input->get('orderBy', TRUE) ? $this->input->get('orderBy', TRUE) : "first_name";
        $orderFormat = $this->input->get('orderFormat', TRUE) ? $this->input->get('orderFormat', TRUE) : "ASC";
        
        //count the total administrators in db (excluding the currently logged in admin)
        $totalAdministrators = count($this->Account_setting->getAll());
        
        $this->load->library('pagination');
        
        $pageNumber = $this->uri->segment(3, 0);//set page number to zero if the page number is not set in the third segment of uri
	
        $limit = $this->input->get('limit', TRUE) ? $this->input->get('limit', TRUE) : 10;//show $limit per page
        $start = $pageNumber == 0 ? 0 : ($pageNumber - 1) * $limit;//start from 0 if pageNumber is 0, else start from the next iteration
        
        //call setPaginationConfig($totalRows, $urlToCall, $limit, $attributes) in genlib to configure pagination
        $config = $this->genlib->setPaginationConfig($totalAdministrators, "Account_settings/laad_", $limit, ['class'=>'lnp']);
        
        $this->pagination->initialize($config);//initialize the library class
        
        //get all customers from db
        $data['allAdministrators'] = $this->Account_setting->getAll($orderBy, $orderFormat, $start, $limit);
        $data['range'] = $totalAdministrators > 0 ? ($start+1) . "-" . ($start + count($data['allAdministrators'])) . " of " . $totalAdministrators : "";
        $data['links'] = $this->pagination->create_links();//page links
        
        $json['adminTable'] = $this->load->view('Account_settings/adminlist', $data, TRUE);//get view with populated customers table

        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
    
    
    /**
     * 
     */
    public function update(){
        $this->genlib->ajaxOnly();
        
        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters('', '');
        
        $this->form_validation->set_rules('firstName', 'First name', ['required', 'trim', 'max_length[20]'], ['required'=>"required"]);
        $this->form_validation->set_rules('lastName', 'Last name', ['required', 'trim', 'max_length[20]'], ['required'=>"required"]);
        $this->form_validation->set_rules('mobile1', 'Phone number', ['required', 'trim', 'numeric', 'max_length[15]', 
            'min_length[11]', 'callback_crosscheckMobile['. $this->input->post('adminId', TRUE).']'], ['required'=>"required"]);
        $this->form_validation->set_rules('mobile2', 'Other number', ['trim', 'numeric', 'max_length[15]', 'min_length[11]']);
        $this->form_validation->set_rules('email', 'E-mail', ['required', 'trim', 'valid_email', 'callback_crosscheckEmail['. $this->input->post('adminId', TRUE).']']);
        $this->form_validation->set_rules('role', 'Role', ['required', 'trim'], ['required'=>"required"]);
        $this->form_validation->set_rules('passwordOrig', 'Password', ['required', 'min_length[8]'], ['required'=>"Enter password"]);
        $this->form_validation->set_rules('passwordDup', 'Password Confirmation', ['required', 'matches[passwordOrig]'], ['required'=>"Please retype password"]);
        
        if($this->form_validation->run() !== FALSE){
            /**
             * update info in db
             * function header: update($admin_id, $first_name, $last_name, $email, $mobile1, $mobile2, $role)
             */
            $hashedPassword = password_hash(set_value('passwordOrig'), PASSWORD_BCRYPT);
				
            $admin_id = $this->input->post('adminId', TRUE);

            $updated = $this->Account_setting->update($admin_id, set_value('firstName'), set_value('lastName'), set_value('email'), $hashedPassword,
                    set_value('mobile1'), set_value('mobile2'), set_value('role'));
            
            
            $json = $updated ? 
                    ['status'=>1, 'msg'=>"Admin info successfully updated"] 
                    : 
                    ['status'=>0, 'msg'=>"Oops! Unexpected server error! Pls contact administrator for help. Sorry for the embarrassment"];
        }
        
        else{
            //return all error messages
            $json = $this->form_validation->error_array();//get an array of all errors
            
            $json['msg'] = "One or more required fields are empty or not correctly filled";
            $json['status'] = 0;
        }
                    
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
    
   
    

    
    /**
     * Used as a callback while updating admin info to ensure 'mobile1' field does not contain a number already used by another admin
     * @param type $mobile_number
     * @param type $admin_id
     */
    public function crosscheckMobile($mobile_number, $admin_id){
        //check db to ensure number was previously used for admin with $admin_id i.e. the same admin we're updating his details
        $adminWithNum = $this->genmod->getTableCol('admin', 'id', 'mobile1', $mobile_number);
        
        if($adminWithNum == $admin_id){
            //used for same admin. All is well.
            return TRUE;
        }
        
        else{
            $this->form_validation->set_message('crosscheckMobile', 'This number is already attached to an administrator');
                
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
     * Used as a callback while updating admin info to ensure 'email' field does not contain an email already used by another admin
     * @param type $email
     * @param type $admin_id
     */
    public function crosscheckEmail($email, $admin_id){
        //check db to ensure email was previously used for admin with $admin_id i.e. the same admin we're updating his details
        $adminWithEmail = $this->genmod->getTableCol('admin', 'id', 'email', $email);
        
        if($adminWithEmail == $admin_id){
            //used for same admin. All is well.
            return TRUE;
        }
        
        else{
            $this->form_validation->set_message('crosscheckEmail', 'This email is already attached to an administrator');
                
            return FALSE;
        }
    }
    
}
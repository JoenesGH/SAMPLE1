<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shop extends CI_Controller {

	public $status;
    public $roles;

	public function __construct()
	{
	parent::__construct();
        $this->load->model('User_model', 'user_model', TRUE);
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->status = $this->config->item('status');
        $this->roles = $this->config->item('roles');
        $this->load->library('userlevel');
	//Load Library and model.
	$this->load->library('cart');
	$this->load->model('shop_model');
	}

    public function index() {

        if(empty($this->session->userdata['email'])){
            // no email found
        $data['readyItems'] =  $this->db->where('status','Ready')->where('cust_email')->from("transactions")->count_all_results();
        $this->load->library('pagination');
        $config['base_url'] = base_url('shop/index');  
        $config['per_page'] = ($this->input->get('limitRows')) ? $this->input->get('limitRows') : 10;
        $config['enable_query_strings'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config['reuse_query_string'] = TRUE;
         // integrate bootstrap pagination
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';     
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = 'Prev';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="'.$config['base_url'].'?per_page=0">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $data['role'] = "0"; //null role - 0 as null
        $data['email'] = null; //null role - 0 as null

        $data['page'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $data['searchFor'] = ($this->input->get('query')) ? $this->input->get('query') : NULL;
        $data['orderField'] = ($this->input->get('orderField')) ? $this->input->get('orderField') : '';
        $data['orderDirection'] = ($this->input->get('orderDirection')) ? $this->input->get('orderDirection') : '';
        $data['allitems'] = $this->shop_model->get_items($config["per_page"], $data['page'], $data['searchFor'], $data['orderField'], $data['orderDirection']);
        $config['total_rows'] = $this->shop_model->count_items($config["per_page"], $data['page'], $data['searchFor'], $data['orderField'], $data['orderDirection']);
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $this->load->view('shop', $data);

        }else{
            //for login user
        $data = $this->session->userdata; //to get data to session role = 1
        $data['readyItems'] =  $this->db->where('status','Ready')->where('cust_email', $this->session->userdata['email'])->group_by('ref')->from("transactions")->count_all_results();  

        $this->load->library('pagination');
        $config['base_url'] = base_url('shop/index');  
        $config['per_page'] = ($this->input->get('limitRows')) ? $this->input->get('limitRows') : 10;
        $config['enable_query_strings'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config['reuse_query_string'] = TRUE;
         // integrate bootstrap pagination
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';     
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = 'Prev';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="'.$config['base_url'].'?per_page=0">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $data['page'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $data['searchFor'] = ($this->input->get('query')) ? $this->input->get('query') : NULL;
        $data['orderField'] = ($this->input->get('orderField')) ? $this->input->get('orderField') : '';
        $data['orderDirection'] = ($this->input->get('orderDirection')) ? $this->input->get('orderDirection') : '';
        $data['allitems'] = $this->shop_model->get_items($config["per_page"], $data['page'], $data['searchFor'], $data['orderField'], $data['orderDirection']);
        $config['total_rows'] = $this->shop_model->count_items($config["per_page"], $data['page'], $data['searchFor'], $data['orderField'], $data['orderDirection']);
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $this->load->view('shop', $data);
     }
    }



    //click home button
	public function home()
	{
		if(empty($this->session->userdata['email'])){
			// no email found
        $data['role'] = "0"; //null role - 0 as null
        $data['email'] = null; //null role - 0 as null    
	    $data['readyItems'] =  $this->db->where('status','Ready')->where('cust_email')->from("transactions")->count_all_results();
		$this->load->view('home',$data);
        }else{
        	//for login user
        $data = $this->session->userdata; //to get data to session role = 1
        $data['readyItems'] =  $this->db->where('status','Ready')->where('cust_email', $this->session->userdata['email'])->group_by('ref')->from("transactions")->count_all_results();  
		$this->load->view('home',$data);
	}
	}

	 //click mu order button
	public function myOrder()
	{
		//user data from session
        $data = $this->session->userdata;
        if(empty($data)){
            redirect(site_url().'shop/login/');
        }

        //check user level
        if(empty($data['role'])){
            redirect(site_url().'shop/login/');
        }
        $dataLevel = $this->userlevel->checkLevel($data['role']);
        //check user level
        
        if(empty($this->session->userdata['email'])){
            redirect(site_url().'shop/login/');
        }else{

		$data = $this->session->userdata;
        $data['readyItems'] =  $this->db->where('status','Ready')->where('cust_email', $this->session->userdata['email'])->group_by('ref')->from("transactions")->count_all_results();  
		$data['allOrders'] = $this->shop_model->myOrder_all($data);
		$this->load->view('my_orders',$data);
	  }
	}



	function add()
	{
	// Set array for send data.
	$insert_data = array(
				'id' => $this->input->post('id'),
				'itemCode' => $this->input->post('code'),
				'name' => $this->input->post('name'),
				'price' => $this->input->post('price'),
				'aqty' => $this->input->post('aqty'),
                'prescription' => $this->input->post('prescription'),
				'image' => $this->input->post('image'),
				'qty' => 1
				);
	// This function add items into cart.
	$this->cart->insert($insert_data);
	echo $fefe = count($this->cart->contents());
	// This will show insert data in cart.
	}

	


	function remove() {
	$rowid = $this->input->post('rowid');
	// Check rowid value.
	if ($rowid==="all"){
	// Destroy data which store in session.
		$this->cart->destroy();
	}else{
	// Destroy selected rowid in session.
	$data = array(
			'rowid' => $rowid,
			'qty' => 0
			);
	// Update cart data, after cancel.
	$this->cart->update($data);
	}
	echo $fefe = count($this->cart->contents());
	// This will show cancel data in cart.
	}




	function update_cart(){
	// Recieve post values,calcute them and update
	$rowid = $_POST['rowid'];
	$price = $_POST['price'];
	$amount = $price * $_POST['qty'];
	$qty = $_POST['qty'];

	$data = array(
		'rowid' => $rowid,
		'price' => $price,
		'amount' => $amount,
		'qty' => $qty
		);
	$this->cart->update($data);
	echo $data['amount'];
	}

	public function save_order()
	{
	// This will store all values which inserted from user.
    do{
        $ref = strtoupper(generateRandomCode('numeric', 6, 10, ""));
        }     
    while($this->shop_model->isRefExist($ref));

    if ($cart = $this->cart->contents()):
	foreach ($cart as $item):

	$customer = array(
	'cust_name' => $this->input->post('name'),
	'cust_email' => $this->input->post('email'),
	'cust_address' => $this->input->post('address'),
	'cust_phone' => $this->input->post('phone'),
	'pick_date' => $this->input->post('pdate'),
	'ref' => $ref,
	'status' => 'Pending',
	'modeOfPayment' => 'Cash - Reserved',
    'transType' => '2',
    'transDate' => $this->input->post('pdate'),
	'itemCode' => $item['itemCode'],
	'itemName' => $item['name'],
	'quantity' => $item['qty'],
	'unitPrice' => $item['price'],
	'totalPrice' => $item['subtotal'],
	'totalMoneySpent' => $this->input->post('grand_total'),
	);
     

     //to minus qty from items table
	$q = "UPDATE items SET quantity = quantity - $item[qty] WHERE code = ?";
        $this->db->query($q, $item['itemCode']);

	// And store user information in database.
	$cust_id = $this->shop_model->insert_reserved($customer);
	
	$order = array(
	'date' => date('Y-m-d'),
	'customerid' => $cust_id
	);

	// Insert product imformation with order detail, store in cart also store in database.

	endforeach;
	endif;

	$this->cart->destroy();

	// After storing all imformation in database load "billing_success".

    if(empty($this->session->userdata['email'])){
            // no email found
        $data['readyItems'] =  $this->db->where('status','Ready')->where('cust_email')->from("transactions")->count_all_results();
        $data = $this->session->userdata; //to get data to session role = 1
        $this->load->view('billing_success', $data);
        }else{
            //for login user
        $data = $this->session->userdata; //to get data to session role = 1
        $data['readyItems'] =  $this->db->where('status','Ready')->where('cust_email', $this->session->userdata['email'])->group_by('ref')->from("transactions")->count_all_results();  
        $this->load->view('billing_success', $data);
      }
    }

	public function MyCart()
    {
    	if(empty($this->session->userdata['email'])){
			// no email found
        $data['role'] = "0"; //null role - 0 as null
        $data['email'] = null; //null role - 0 as null    
	    $data['readyItems'] =  $this->db->where('status','Ready')->where('cust_email')->from("transactions")->count_all_results();
		$data['cart']  = $this->cart->contents();
        $this->load->view("cart", $data);
        }else{
        	//for login user
        $data = $this->session->userdata; //to get data to session role = 1
        $data['readyItems'] =  $this->db->where('status','Ready')->where('cust_email', $this->session->userdata['email'])->group_by('ref')->from("transactions")->count_all_results();  
		$data['cart']  = $this->cart->contents();
        $this->load->view("cart", $data);
	}
    }



    public function review()
    {    
        //user data from session
        $data = $this->session->userdata;
        if(empty($data)){
            redirect(site_url().'shop/login/');
        }
        //check user level
        if(empty($data['role'])){
            redirect(site_url().'shop/login/');
        }
        $dataLevel = $this->userlevel->checkLevel($data['role']);
        
        if(empty($this->session->userdata['email'])){
            redirect(site_url().'shop/login/');
        }else{
        $data['readyItems'] =  $this->db->where('status','Ready')->where('cust_email', $this->session->userdata['email'])->group_by('ref')->from("transactions")->count_all_results(); 
        $data['cart']  = $this->cart->contents();
        $this->load->view("review_orders", $data);
        }
    }

    // for register /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //index dasboard
    public function login_user()
    {
        //user data from session
        $data = $this->session->userdata;
        if(empty($data)){
            redirect(site_url().'shop/login/');
        }

        //check user level
        if(empty($data['role'])){
            redirect(site_url().'shop/login/');
        }
        $dataLevel = $this->userlevel->checkLevel($data['role']);
        //check user level
        
        $data['title'] = "Dashboard Admin";
        
        if(empty($this->session->userdata['email'])){
            redirect(site_url().'shop/login/');
        }else{
          //  $this->load->view('header', $data);
          //  $this->load->view('navbar', $data);
          //  $this->load->view('container');
            $this->load->view('review_orders', $data);
        }

    }

    public function checkLoginUser(){
         //user data from session
        $data = $this->session->userdata;
        if(empty($data)){
            redirect(site_url().'shop/login/');
        }
        
    $this->load->library('user_agent');
        $browser = $this->agent->browser();
        $os = $this->agent->platform();
        $getip = $this->input->ip_address();
        
        $result = $this->user_model->getAllSettings();
        $stLe = $result->site_title;
    $tz = $result->timezone;
        
    $now = new DateTime();
        $now->setTimezone(new DateTimezone($tz));
        $dTod =  $now->format('Y-m-d');
        $dTim =  $now->format('H:i:s');
        
        $this->load->helper('cookie');
        $keyid = rand(1,9000);
        $scSh = sha1($keyid);
        $neMSC = md5($data['email']);
        $setLogin = array(
            'name'   => $neMSC,
            'value'  => $scSh,
            'expire' => strtotime("+2 year"),
        );
        $getAccess = get_cookie($neMSC);
        
        if(!$getAccess && $setLogin["name"] == $neMSC){
            $this->load->library('email');
            $this->load->library('sendmail');
            $bUrl = base_url();
            $message = $this->sendmail->secureMail($data['first_name'],$data['last_name'],$data['email'],$dTod,$dTim,$stLe,$browser,$os,$getip,$bUrl);
            $to_email = $data['email'];
            $this->email->from($this->config->item('register'), 'New sign-in! from '.$browser.'');
            $this->email->to($to_email);
            $this->email->subject('New sign-in! from '.$browser.'');
            $this->email->message($message);
            $this->email->set_mailtype("html");
            $this->email->send();
            
            $this->input->set_cookie($setLogin, TRUE);
            redirect(site_url().'shop/');
        }else{
            $this->input->set_cookie($setLogin, TRUE);
            redirect(site_url().'shop/');
        }
    }
    
    public function settings(){
        $data = $this->session->userdata;
        if(empty($data['role'])){
            redirect(site_url().'shop/login/');
        }
        $dataLevel = $this->userlevel->checkLevel($data['role']);
        //check user level

        $data['title'] = "Settings";
        $this->form_validation->set_rules('site_title', 'Site Title', 'required');
        $this->form_validation->set_rules('timezone', 'Timezone', 'required');
        $this->form_validation->set_rules('recaptcha', 'Recaptcha', 'required');
  //      $this->form_validation->set_rules('theme', 'Theme', 'required');

        $result = $this->user_model->getAllSettings();
        $data['id'] = $result->id;
        $data['site_title'] = $result->site_title;
        $data['timezone'] = $result->timezone;
        
        if (!empty($data['timezone']))
        {
            $data['timezonevalue'] = $result->timezone;
            $data['timezone'] = $result->timezone;
        }
        else
        {
            $data['timezonevalue'] = "";
            $data['timezone'] = "Select a time zone";
        }
        
        if($dataLevel == "is_admin"){
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('header', $data);
                $this->load->view('navbar', $data);
                $this->load->view('container');
                $this->load->view('settings', $data);
            }else{
                $post = $this->input->post(NULL, TRUE);
                $cleanPost = $this->security->xss_clean($post);
                $cleanPost['id'] = $this->input->post('id');
                $cleanPost['site_title'] = $this->input->post('site_title');
                $cleanPost['timezone'] = $this->input->post('timezone');
                $cleanPost['recaptcha'] = $this->input->post('recaptcha');
         //       $cleanPost['theme'] = $this->input->post('theme');
    
                if(!$this->user_model->settings($cleanPost)){
                    $this->session->set_flashdata('flash_message', 'There was a problem updating your data!');
                }else{
                    $this->session->set_flashdata('success_message', 'Your data has been updated.');
                }
                redirect(site_url().'shop/settings/');
            }
        }

    }
    
        //user list
    public function users()
    {
        $data = $this->session->userdata;
        $data['title'] = "User List";
        $data['groups'] = $this->user_model->getUserData();

        //check user level
        if(empty($data['role'])){
            redirect(site_url().'shop/login/');
        }
        $dataLevel = $this->userlevel->checkLevel($data['role']);
        //check user level

        //check is admin or not
        if($dataLevel == "is_admin"){
            $this->load->view('header', $data);
            $this->load->view('navbar', $data);
            $this->load->view('container');
            $this->load->view('user', $data);
        }else{
            redirect(site_url().'shop/');
        }
    } 

    //edit user
    public function changeuser() 
    {
        $data = $this->session->userdata;
        if(empty($data['role'])){
            redirect(site_url().'shop/login/');
        }

        $dataInfo = array(
            'firstName'=> $data['first_name'],
            'id'=>$data['id'],
        );

        $data['title'] = "Change Password";
        $this->form_validation->set_rules('firstname', 'First Name', 'required');
        $this->form_validation->set_rules('lastname', 'Last Name', 'required');
        $this->form_validation->set_rules('mobile', 'Mobile', 'required');
        $this->form_validation->set_rules('address', 'address', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
        $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]');

        $data['groups'] = $this->user_model->getUserInfo($dataInfo['id']);

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('header', $data);
            $this->load->view('navbar', $data);
            $this->load->view('container');
            $this->load->view('changeuser', $data);
        }else{
            $this->load->library('password');
            $post = $this->input->post(NULL, TRUE);
            $cleanPost = $this->security->xss_clean($post);
            $hashed = $this->password->create_hash($cleanPost['password']);
            $cleanPost['password'] = $hashed;
            $cleanPost['user_id'] = $dataInfo['id'];
            $cleanPost['mobile'] = $this->input->post('mobile');
            $cleanPost['address'] = $this->input->post('address');
            $cleanPost['email'] = $this->input->post('email');
            $cleanPost['firstname'] = $this->input->post('firstname');
            $cleanPost['lastname'] = $this->input->post('lastname');
            unset($cleanPost['passconf']);
            if(!$this->user_model->updateProfile($cleanPost)){
                $this->session->set_flashdata('flash_message', 'There was a problem updating your profile');
            }else{
                $this->session->set_flashdata('success_message', 'Your profile has been updated.');
            }
            redirect(site_url().'shop/');
        }
    }

    //open profile and gravatar user
    public function profile()
    {
        $data = $this->session->userdata;
        if(empty($data['role'])){
            redirect(site_url().'shop/login/');
        }

        $data['title'] = "Profile";
    //    $this->load->view('header', $data);
    //    $this->load->view('navbar', $data);
    //    $this->load->view('container');
         $data['readyItems'] =  $this->db->where('status','Ready')->where('cust_email', $this->session->userdata['email'])->group_by('ref')->from("transactions")->count_all_results();  
        $this->load->view('profile', $data);

    }

    //register new user from frontend
    public function register()
    {
        $data['title'] = "Register";
        $this->load->library('curl');
        $this->load->library('recaptcha');
        $this->form_validation->set_rules('firstname', 'First Name', 'required');
        $this->form_validation->set_rules('lastname', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        
        $result = $this->user_model->getAllSettings();
        $sTl = $result->site_title;
        $data['recaptcha'] = $result->recaptcha;

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('header', $data);
            $this->load->view('container');
            $this->load->view('register');
        }else{
            if($this->user_model->isDuplicate($this->input->post('email'))){
                $this->session->set_flashdata('flash_message', 'User email already exists');
                redirect(site_url().'shop/register');
            }else{
                $post = $this->input->post(NULL, TRUE);
                $clean = $this->security->xss_clean($post);

                if($data['recaptcha'] == 'yes'){
                    //recaptcha
                    $recaptchaResponse = $this->input->post('g-recaptcha-response');
                    $userIp = $_SERVER['REMOTE_ADDR'];
                    $key = $this->recaptcha->secret;
                    $url = "https://www.google.com/recaptcha/api/siteverify?secret=".$key."&response=".$recaptchaResponse."&remoteip=".$userIp; //link
                    $response = $this->curl->simple_get($url);
                    $status= json_decode($response, true);
    
                    //recaptcha check
                    if($status['success']){
                        //insert to database
                        $id = $this->user_model->insertUser($clean);
                        $token = $this->user_model->insertToken($id);
    
                        //generate token
                        $qstring = $this->base64url_encode($token);
                        $url = site_url() . 'shop/complete/token/' . $qstring;
                        $link = '<a href="' . $url . '">' . $url . '</a>';
    
                        $this->load->library('email');
                        $this->load->library('sendmail');
                        
                        $message = $this->sendmail->sendRegister($this->input->post('lastname'),$this->input->post('email'),$link, $sTl);
                        $to_email = $this->input->post('email');
                        $this->email->from($this->config->item('register'), 'Set Password ' . $this->input->post('firstname') .' '. $this->input->post('lastname')); //from sender, title email
                        $this->email->to($to_email);
                        $this->email->subject('Set Password Login');
                        $this->email->message($message);
                        $this->email->set_mailtype("html");
    
                        //Sending mail
                        if($this->email->send()){
                            redirect(site_url().'shop/successregister/');
                        }else{
                            $this->session->set_flashdata('flash_message', 'There was a problem sending an email.');
                            exit;
                        }
                    }else{
                        //recaptcha failed
                        $this->session->set_flashdata('flash_message', 'Error...! Google Recaptcha UnSuccessful!');
                        redirect(site_url().'shop/register/');
                        exit;
                    }
                }else{
                    //insert to database
                    $id = $this->user_model->insertUser($clean);
                    $token = $this->user_model->insertToken($id);
    
                    //generate token
                    $qstring = $this->base64url_encode($token);
                    $url = site_url() . 'shop/complete/token/' . $qstring;
                    $link = '<a href="' . $url . '">' . $url . '</a>';
    
                    $this->load->library('email');
                    $this->load->library('sendmail');
                    
                    $message = $this->sendmail->sendRegister($this->input->post('lastname'),$this->input->post('email'),$link,$sTl);
                    $to_email = $this->input->post('email');
                    $this->email->from($this->config->item('register'), 'Set Password ' . $this->input->post('firstname') .' '. $this->input->post('lastname')); //from sender, title email
                    $this->email->to($to_email);
                    $this->email->subject('Set Password Login');
                    $this->email->message($message);
                    $this->email->set_mailtype("html");
    
                    //Sending mail
                    if($this->email->send()){
                        redirect(site_url().'shop/successregister/');
                    }else{
                        $this->session->set_flashdata('flash_message', 'There was a problem sending an email.');
                        exit;
                    }
                }
            };
        }
    }

    //if success new user register
    public function successregister()
    {
        $data['title'] = "Success Register";
        $this->load->view('header', $data);
        $this->load->view('container');
        $this->load->view('register-info');
    }

    //if success after set password
    public function successresetpassword()
    {
        $data['title'] = "Success Reset Password";
        $this->load->view('header', $data);
        $this->load->view('container');
        $this->load->view('reset-pass-info');
    }

    protected function _islocal(){
        return strpos($_SERVER['HTTP_HOST'], 'local');
    }

    //check if complate after add new user
    public function complete()
    {
        $token = base64_decode($this->uri->segment(4));
        $cleanToken = $this->security->xss_clean($token);

        $user_info = $this->user_model->isTokenValid($cleanToken); //either false or array();

        if(!$user_info){
            $this->session->set_flashdata('flash_message', 'Token is invalid or expired');
            redirect(site_url().'shop/login');
        }
        $data = array(
            'firstName'=> $user_info->first_name,
            'email'=>$user_info->email,
            'user_id'=>$user_info->id,
            'token'=>$this->base64url_encode($token)
        );

        $data['title'] = "Set the Password";

        $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
        $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('header', $data);
            $this->load->view('container');
            $this->load->view('complete', $data);
        }else{
            $this->load->library('password');
            $post = $this->input->post(NULL, TRUE);

            $cleanPost = $this->security->xss_clean($post);

            $hashed = $this->password->create_hash($cleanPost['password']);
            $cleanPost['password'] = $hashed;
            unset($cleanPost['passconf']);
            $userInfo = $this->user_model->updateUserInfo($cleanPost);

            if(!$userInfo){
                $this->session->set_flashdata('flash_message', 'There was a problem updating your record');
                redirect(site_url().'shop/login');
            }

            unset($userInfo->password);

            foreach($userInfo as $key=>$val){
                $this->session->set_userdata($key, $val);
            }
            redirect(site_url().'shop/');

        }
    }

    //check login failed or success
    public function login()
    {
        $data = $this->session->userdata;
        if(!empty($data['email'])){
            redirect(site_url().'shop/');
        }else{
            $this->load->library('curl');
            $this->load->library('recaptcha');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required');
            
            $data['title'] = "Welcome Back!";
            
            $result = $this->user_model->getAllSettings();
            $data['recaptcha'] = $result->recaptcha;

            if($this->form_validation->run() == FALSE) {
                $this->load->view('header', $data);
                $this->load->view('container');
                $this->load->view('login');
            }else{
                $post = $this->input->post();
                $clean = $this->security->xss_clean($post);
                $userInfo = $this->user_model->checkLogin($clean);
                
                if($data['recaptcha'] == 'yes'){
                    //recaptcha
                    $recaptchaResponse = $this->input->post('g-recaptcha-response');
                    $userIp = $_SERVER['REMOTE_ADDR'];
                    $key = $this->recaptcha->secret;
                    $url = "https://www.google.com/recaptcha/api/siteverify?secret=".$key."&response=".$recaptchaResponse."&remoteip=".$userIp; //link
                    $response = $this->curl->simple_get($url);
                    $status= json_decode($response, true);
    
                    if(!$userInfo)
                    {
                        $this->session->set_flashdata('flash_message', 'Wrong password or email.');
                        redirect(site_url().'shop/login');
                    }
                    elseif($userInfo->banned_users == "ban")
                    {
                        $this->session->set_flashdata('danger_message', 'You’re temporarily banned from our website!');
                        redirect(site_url().'shop/login');
                    }
                    else if(!$status['success'])
                    {
                        //recaptcha failed
                        $this->session->set_flashdata('flash_message', 'Error...! Google Recaptcha UnSuccessful!');
                        redirect(site_url().'shop/login/');
                        exit;
                    }
                    elseif($status['success'] && $userInfo && $userInfo->banned_users == "unban") //recaptcha check, success login, ban or unban
                    {
                        foreach($userInfo as $key=>$val){
                        $this->session->set_userdata($key, $val);
                        }
                        redirect(site_url().'shop/checkLoginUser/');
                    }
                    else
                    {
                        $this->session->set_flashdata('flash_message', 'Something Error!');
                        redirect(site_url().'shop/login/');
                        exit;
                    }
                }else{
                    if(!$userInfo)
                    {
                        $this->session->set_flashdata('flash_message', 'Wrong password or email.');
                        redirect(site_url().'shop/login');
                    }
                    elseif($userInfo->banned_users == "ban")
                    {
                        $this->session->set_flashdata('danger_message', 'You’re temporarily banned from our website!');
                        redirect(site_url().'shop/login');
                    }
                    elseif($userInfo && $userInfo->banned_users == "unban") //recaptcha check, success login, ban or unban
                    {
                        foreach($userInfo as $key=>$val){
                        $this->session->set_userdata($key, $val);
                        }
                        redirect(site_url().'shop/checkLoginUser/');
                    }
                    else
                    {
                        $this->session->set_flashdata('flash_message', 'Something Error!');
                        redirect(site_url().'shop/login/');
                        exit;
                    }
                }
            }
        }
    }

    //Logout
    public function logout()
    {
        $this->session->sess_destroy();
        redirect(site_url().'shop/');
    }

    //forgot password
    public function forgot()
    {
        $data['title'] = "Forgot Password";
        $this->load->library('curl');
        $this->load->library('recaptcha');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        
        $result = $this->user_model->getAllSettings();
        $sTl = $result->site_title;
        $data['recaptcha'] = $result->recaptcha;

        if($this->form_validation->run() == FALSE) {
            $this->load->view('header', $data);
            $this->load->view('container');
            $this->load->view('forgot');
        }else{
            $email = $this->input->post('email');
            $clean = $this->security->xss_clean($email);
            $userInfo = $this->user_model->getUserInfoByEmail($clean);

            if(!$userInfo){
                $this->session->set_flashdata('flash_message', 'We cant find your email address');
                redirect(site_url().'shop/login');
            }

            if($userInfo->status != $this->status[1]){ //if status is not approved
                $this->session->set_flashdata('flash_message', 'Your account is not in approved status');
                redirect(site_url().'shop/login');
            }

            if($data['recaptcha'] == 'yes'){
                //recaptcha
                $recaptchaResponse = $this->input->post('g-recaptcha-response');
                $userIp = $_SERVER['REMOTE_ADDR'];
                $key = $this->recaptcha->secret;
                $url = "https://www.google.com/recaptcha/api/siteverify?secret=".$key."&response=".$recaptchaResponse."&remoteip=".$userIp; //link
                $response = $this->curl->simple_get($url);
                $status= json_decode($response, true);
    
                //recaptcha check
                if($status['success']){
    
                    //generate token
                    $token = $this->user_model->insertToken($userInfo->id);
                    $qstring = $this->base64url_encode($token);
                    $url = site_url() . 'shop/reset_password/token/' . $qstring;
                    $link = '<a href="' . $url . '">' . $url . '</a>';
    
                    $this->load->library('email');
                    $this->load->library('sendmail');
                    
                    $message = $this->sendmail->sendForgot($this->input->post('lastname'),$this->input->post('email'),$link,$sTl);
                    $to_email = $this->input->post('email');
                    $this->email->from($this->config->item('forgot'), 'Reset Password! ' . $this->input->post('firstname') .' '. $this->input->post('lastname')); //from sender, title email
                    $this->email->to($to_email);
                    $this->email->subject('Reset Password');
                    $this->email->message($message);
                    $this->email->set_mailtype("html");
    
                    if($this->email->send()){
                        redirect(site_url().'shop/successresetpassword/');
                    }else{
                        $this->session->set_flashdata('flash_message', 'There was a problem sending an email.');
                        exit;
                    }
                }else{
                    //recaptcha failed
                    $this->session->set_flashdata('flash_message', 'Error...! Google Recaptcha UnSuccessful!');
                    redirect(site_url().'shop/register/');
                    exit;
                }
            }else{
                //generate token
                $token = $this->user_model->insertToken($userInfo->id);
                $qstring = $this->base64url_encode($token);
                $url = site_url() . 'shop/reset_password/token/' . $qstring;
                $link = '<a href="' . $url . '">' . $url . '</a>';

                $this->load->library('email');
                $this->load->library('sendmail');
                
                $message = $this->sendmail->sendForgot($this->input->post('lastname'),$this->input->post('email'),$link,$sTl);
                $to_email = $this->input->post('email');
                $this->email->from($this->config->item('forgot'), 'Reset Password! ' . $this->input->post('firstname') .' '. $this->input->post('lastname')); //from sender, title email
                $this->email->to($to_email);
                $this->email->subject('Reset Password');
                $this->email->message($message);
                $this->email->set_mailtype("html");

                if($this->email->send()){
                    redirect(site_url().'shop/successresetpassword/');
                }else{
                    $this->session->set_flashdata('flash_message', 'There was a problem sending an email.');
                    exit;
                }
            }
            
        }

    }

    //reset password
    public function reset_password()
    {
        $token = $this->base64url_decode($this->uri->segment(4));
        $cleanToken = $this->security->xss_clean($token);
        $user_info = $this->user_model->isTokenValid($cleanToken); //either false or array();

        if(!$user_info){
            $this->session->set_flashdata('flash_message', 'Token is invalid or expired');
            redirect(site_url().'shop/login');
        }
        $data = array(
            'firstName'=> $user_info->first_name,
            'email'=>$user_info->email,
            //'user_id'=>$user_info->id,
            'token'=>$this->base64url_encode($token)
        );

        $data['title'] = "Reset Password";
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
        $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('header', $data);
            $this->load->view('container');
            $this->load->view('reset_password', $data);
        }else{
            $this->load->library('password');
            $post = $this->input->post(NULL, TRUE);
            $cleanPost = $this->security->xss_clean($post);
            $hashed = $this->password->create_hash($cleanPost['password']);
            $cleanPost['password'] = $hashed;
            $cleanPost['user_id'] = $user_info->id;
            unset($cleanPost['passconf']);
            if(!$this->user_model->updatePassword($cleanPost)){
                $this->session->set_flashdata('flash_message', 'There was a problem updating your password');
            }else{
                $this->session->set_flashdata('success_message', 'Your password has been updated. You may now login');
            }
            redirect(site_url().'shop/checkLoginUser');
        }
    }

    public function base64url_encode($data) {
      return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    public function base64url_decode($data) {
      return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }
}
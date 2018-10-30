<?php
defined('BASEPATH') OR exit('');

class All_reports extends CI_Controller{
    
    public function __construct(){
        parent::__construct();
        
        $this->load->model(['All_report','transaction', 'analytic']);
    }

    public function index(){
        $values['pageContent'] = $this->load->view('all_report/all_report', '', TRUE);
        $values['pageTitle'] = "Reports";     
        $this->load->view('main', $values);

    }
   
    //WHEN "GENERATE STOCK REPORT" BUTTON IS CLICKED FROM THE MODAL
    public function items_report(){        
     $data['allitems'] = $this->All_report->get_items();
        $this->load->view('all_report/itemsReport' , $data);
    }

     //WHEN "GENERATE STOCK REPORT" BUTTON IS CLICKED FROM THE MODAL
    public function cancel_report(){        
     $data['allitems'] = $this->All_report->get_cancel_orders();
        $this->load->view('all_report/cancelReport' , $data);
    }
}
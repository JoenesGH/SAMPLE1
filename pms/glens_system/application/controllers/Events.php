<?php
defined('BASEPATH') OR exit('');

class Events extends CI_Controller{
    
    public function __construct(){
        parent::__construct();
        
        $this->genlib->checkLogin();
        
        $this->load->model(['event']);
    }
    
 
    public function index(){
        $data['pageContent'] = $this->load->view('events/events', '', TRUE);
        $data['pageTitle'] = "Log";

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
        $orderBy = $this->input->get('orderBy', TRUE) ? $this->input->get('orderBy', TRUE) : "event";
        $orderFormat = $this->input->get('orderFormat', TRUE) ? $this->input->get('orderFormat', TRUE) : "ASC";
        
        //count the total number of items in db
        $totalItems = $this->db->count_all('eventlog');
        
        $this->load->library('pagination');
        
        $pageNumber = $this->uri->segment(3, 0);//set page number to zero if the page number is not set in the third segment of uri
	
        $limit = $this->input->get('limit', TRUE) ? $this->input->get('limit', TRUE) : 10;//show $limit per page
        $start = $pageNumber == 0 ? 0 : ($pageNumber - 1) * $limit;//start from 0 if pageNumber is 0, else start from the next iteration
        
        //call setPaginationConfig($totalRows, $urlToCall, $limit, $attributes) in genlib to configure pagination
        $config = $this->genlib->setPaginationConfig($totalItems, "events/lilt", $limit, ['onclick'=>'return lilt(this.href);']);
        
        $this->pagination->initialize($config);//initialize the library class
        
        //get all items from db
        $data['allItems'] = $this->event->getAll($orderBy, $orderFormat, $start, $limit);
        $data['range'] = $totalItems > 0 ? "Showing " . ($start+1) . "-" . ($start + count($data['allItems'])) . " of " . $totalItems : "";
        $data['links'] = $this->pagination->create_links();//page links
        $data['sn'] = $start+1;
        $data['cum_total'] = $this->event->getItemsCumTotal();
        
        $json['itemsListTable'] = $this->load->view('events/eventslisttable', $data, TRUE);//get view with populated items table

        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
    
  }
<?php
defined('BASEPATH') OR exit('');

class reserved_pending extends CI_Controller{
    
    public function __construct(){
        parent::__construct();
        
        
        
        $this->load->model(['reservation','transaction', 'analytic']);
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
     */
    public function index(){

        
        $data['topDemanded'] = $this->analytic->topDemanded();
        $data['leastDemanded'] = $this->analytic->leastDemanded();
        $data['highestEarners'] = $this->analytic->highestEarners();
        $data['lowestEarners'] = $this->analytic->lowestEarners();
        $data['totalItems'] = $this->db->count_all('items');
        $data['totalSalesToday'] = (int)$this->analytic->totalSalesToday();
        $data['totalTransactions'] = $this->transaction->totalTransactions();
        $data['dailyTransactions'] = $this->analytic->getDailyTrans();
        $data['transByDays'] = $this->analytic->getTransByDays();
        $data['transByMonths'] = $this->analytic->getTransByMonths();
        $data['transByYears'] = $this->analytic->getTransByYears();
        
        $values['pageContent'] = $this->load->view('reservation/reserved_pending', $data, TRUE);
        
        $values['pageTitle'] = "Reservation";
        
        $this->load->view('main', $values);
    }


   
}
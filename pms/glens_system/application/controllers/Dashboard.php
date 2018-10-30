<?php
defined('BASEPATH') OR exit('');

class Dashboard extends CI_Controller{
    
    public function __construct(){
        parent::__construct();
        
        
        
        $this->load->model(['item','transaction', 'analytic']);
    }
    
    
    public function index(){
        
        $data['PWarning'] = $this->analytic->pwaning($orderBy='name', $orderFormat='', $start='0', $limit='');
        $data['sn2'] = $start+1;
        $data['topDemanded'] = $this->analytic->topDemanded();
        $data['leastDemanded'] = $this->analytic->leastDemanded();
        $data['highestEarners'] = $this->analytic->highestEarners();
        $data['lowestEarners'] = $this->analytic->lowestEarners();
    //  $data['totalItems'] = $this->db->count_all('items');

        $data['totalItems'] =  $this->db->where('quantity <= 50')->from("items")->count_all_results();//out of stock warning
        
        $data['waning_stock'] =  $this->db->where('quantity <= 50')->from("items")->count_all_results();//out of stock warning
        $data['waning_expired'] =  $this->db->where('date_expire <= NOW()')->from("items")->count_all_results();//out of stock warning
        $data['totalSalesToday'] = (int)$this->analytic->totalSalesToday();
        $data['totalTransactions'] =  $this->db->where('status', 'Pending')->group_by('ref')->from("transactions")->count_all_results();//out of stock warning
       // $data['totalTransactions'] = $this->transaction->totalTransactions();
        $data['dailyTransactions'] = $this->analytic->getDailyTrans();
        $data['transByDays'] = $this->analytic->getTransByDays();
        $data['transByMonths'] = $this->analytic->getTransByMonths();
        $data['transByYears'] = $this->analytic->getTransByYears();
        
        $values['pageContent'] = $this->load->view('dashboard', $data, TRUE);
        
        $values['pageTitle'] = "Dashboard";
        
        $this->load->view('main', $values);
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
     * @param type $year year of earnings to fetch
     * @param boolean $not_ajax if request if ajax request or not
     * @return int
     */
    public function earningsGraph($year="", $not_ajax = false) {
        //set the year of expenses to show
        $year_to_fetch = $year ? $year : date('Y');
        
        $earnings = $this->genmod->getYearEarnings($year_to_fetch);
        $lastEarnings = 0;
        $monthEarnings = array();
        $hightEarn['highestEarning'] = 0;
        $dataarr = [];
        $allMonths = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

        if ($earnings) {
            foreach ($allMonths as $allMonth) {
                foreach ($earnings as $get) {
                    $earningMonth = date("M", strtotime($get->transDate));
                    
                    if ($allMonth == $earningMonth) {
                        $lastEarnings += $get->totalPrice;
                        
                        $monthEarnings[$allMonth] = $lastEarnings;
                    } 
                    
                    else {
                        if (!array_key_exists($allMonth, $monthEarnings)) {
                            $monthEarnings[$allMonth] = 0;
                        }
                    }
                }

                if ($lastEarnings > $hightEarn['highestEarning']) {
                    $hightEarn['highestEarning'] = $lastEarnings;
                }
                
                $lastEarnings = 0;
            }

            foreach ($monthEarnings as $me) {
                $dataarr[] = $me;
            }
        }

        else {//if no earning, set earning to 0
            foreach ($allMonths as $allMonth) {
                $dataarr[] = 0;
            }
        }

        //add info into array
        $json = array("total_earnings" => $dataarr, 'earningsYear'=>$year_to_fetch);

        //set final output based on where the request is coming from
        if($not_ajax){
            return $json;
        }

        else{
            $this->output->set_content_type('application/json')->set_output(json_encode($json));
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
     */
    function paymentMethodChart($year=''){
        $year_to_fetch = $year ? $year : date('Y');
        
        $payment_methods = $this->genmod->getPaymentMethods($year_to_fetch);
        
        $json['status'] = 0;
        $cash = 0;
        $reserved = 0;
        $cash_and_reserved = 0;
        $json['year'] = $year_to_fetch;

        if($payment_methods) {
            foreach ($payment_methods as $get) {
                if ($get->modeOfPayment == "Cash") {
                    $cash++;
                } 
                
                else if ($get->modeOfPayment == "Cash - Reserved") {
                    $reserved++;
                }
                
                else if($get->modeOfPayment === "Cash and Reserved"){
                    $cash_and_reserved++;
                }
            }
            
            //calculate the percentage of each
            $total = $cash + $reserved + $cash_and_reserved;
            
            $cash_percentage = round(($cash/$total) * 100, 2);
            $reserved_percentage =  round(($reserved/$total) * 100, 2);
            $cash_and_reserved_percentage = round(($cash_and_reserved/$total) * 100, 2);
            
            $json['status'] = 1;
            $json['cash'] = $cash_percentage;
            $json['reserved'] = $reserved_percentage;
            $json['cashAndReserved'] = $cash_and_reserved_percentage;
        }
        
        //set final output
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
}
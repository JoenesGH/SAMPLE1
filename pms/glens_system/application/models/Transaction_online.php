<?php

defined('BASEPATH') OR exit('');


class Transaction_online extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

 

    public function add($_iN, $_iC, $desc, $q, $_up, $_tp, $_tas, $_at, $_cd, $_mop, $_tt, $_va, $_vp, $da, $dp, $oid) {
        $data = ['itemName' => $_iN, 'itemCode' => $_iC, 'quantity' => $q, 'unitPrice' => $_up, 'totalPrice' => $_tp,
            'amountTendered' => $_at, 'changeDue' => $_cd, 'modeOfPayment' => $_mop, 'transType' => $_tt,
            'staffId' => $this->session->admin_id, 'totalMoneySpent' => $_tas, 'vatAmount' => $_va,
            'vatPercentage' => $_vp, 'discount_amount'=>$da, 'discount_percentage'=>$dp, 'orderid'=>$oid];


        $this->db->insert('customer_reserved', $data);

        if ($this->db->affected_rows()) {
            return $this->db->insert_id();
        }
        else {
            return FALSE;
        }
    }


}
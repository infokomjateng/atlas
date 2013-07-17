<?php

class T_payment_m extends MY_Model
{
    function __construct() 
    {
        parent::__construct();
        
        $this->table_name = 'm_drivers';
        $this->primary_key = 'M_DriversID';
    }
    
    function get($ids = false)
    {
        return parent::get($ids);
    }
    
    function listing($inp, $ar_search)
    {
        $this->db->select('M_DriversID, M_DriversName, M_DriversCode, M_DriversAddress, M_DriversKS + M_DriversBS as M_DriversKSBS', false)
                ->where('M_DriversIsBlocked', 0);
        return parent::listing($inp, $ar_search);
    }
}
?>

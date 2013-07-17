<?php

class M_voucher_m extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        
        $this->table_name = 'm_voucher';
        $this->active_field = 'IsActive';
        $this->primary_key = 'M_VoucherID';
    }
    
    function get($ids = false)
    {
        return parent::get($ids);
    }
}
?>

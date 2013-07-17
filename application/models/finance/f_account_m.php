<?php

class F_account_m extends MY_Model
{
    function __construct() 
    {
        parent::__construct();
        
        $this->table_name = 'f_account';
        $this->primary_key = 'F_AccountID';
        $this->active_field = 'IsActive';
    }
    
    function get($ids = false)
    {
        return parent::get($ids);
    }
}
?>

<?php

class F_accountitem_m extends MY_Model
{
    function __construct() 
    {
        parent::__construct();
        
        $this->table_name = 'f_accountitem';
        $this->primary_key = 'F_AccountItemID';
        $this->active_field = 'IsActive';
    }
    
    function get($ids = false)
    {
        return parent::get($ids);
    }
}
?>

<?php

class Branch_m extends MY_Model
{
    function __construct() 
    {
        parent::__construct();
        
        $this->table_name = 'branch';
        $this->primary_key = 'BranchID';
    }
    
    function get($ids = false)
    {
        return parent::get($ids);
    }
}
?>

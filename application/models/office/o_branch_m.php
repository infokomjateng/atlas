<?php

class O_branch_m extends MY_Model
{
    function __construct() 
    {
        parent::__construct();
        
        $this->table_name = 'o_branch';
        $this->primary_key = 'O_BranchID';
    }
    
    function get($ids = false)
    {
        return parent::get($ids);
    }
}
?>

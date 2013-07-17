<?php

class M_sim_m extends MY_Model
{
    function __construct() 
    {
        parent::__construct();
        
        $this->table_name = 'm_sim';
        $this->primary_key = 'M_SimID';
        $this->active_field = 'IsActive';
    }
    
    function get($ids = false)
    {
        return parent::get($ids);
    }
}
?>

<?php

class M_sparepartscategory_m extends MY_Model
{
    function __construct() 
    {
        parent::__construct();
        
        $this->table_name = 'm_sparepartscategory';
        $this->primary_key = 'M_SparePartsCategoryID';
    }
    
    function get($ids = false)
    {
        $this->db->select('M_SparePartsCategoryName, M_SparePartsCategoryID, M_SparePartsCategoryLeft,
            M_SparePartsCategoryRight', false);
        return parent::get($ids);
    }
    
    
}
?>

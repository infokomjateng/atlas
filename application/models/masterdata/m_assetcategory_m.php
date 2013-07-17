<?php

class M_assetcategory_m extends MY_Model
{
    function __construct() 
    {
        parent::__construct();
        
        $this->table_name = 'm_assetcategory';
        $this->primary_key = 'M_AssetCategoryID';
    }
    
    function get($ids = false)
    {
        
        return parent::get($ids);
    }
    
    
}
?>

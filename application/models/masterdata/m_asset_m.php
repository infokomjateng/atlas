<?php

class M_asset_m extends MY_Model
{
    function __construct() 
    {
        parent::__construct();
        
        $this->table_name = 'm_asset';
        $this->primary_key = 'M_AssetID';
    }
    
    function get($ids = false)
    {
        $this->db->select('m_asset.*,substring(M_AssetBuyDate,1,10) as M_AssetBuyDate',false);
        return parent::get($ids);
    }
    
    
}
?>

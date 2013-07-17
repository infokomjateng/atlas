<?php

class M_spareparts_m extends MY_Model
{
    function __construct() 
    {
        parent::__construct();
        
        $this->table_name = 'm_spareparts';
        $this->primary_key = 'M_SparePartsID';
    }
    
    function get($ids = false)
    {
        $this->db->select('M_SparePartsName, M_SparePartsCode, M_SparePartsID, M_SparePartsStock,
            M_SparePartsM_SparePartsCategoryID, M_SparePartsCategoryID,M_SparePartsCategoryName,
            M_SparePartsPrice', false);
        $this->db->join('m_sparepartscategory','M_SparePartsM_SparePartsCategoryID = M_SparePartsCategoryID', 'left');
        return parent::get($ids);
    }
    
    function autocomplete($sup, $q)
    {
        $this->db->where();
    }
    
}
?>

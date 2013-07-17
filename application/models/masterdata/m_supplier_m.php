<?php

class M_supplier_m extends MY_Model
{
    function __construct() 
    {
        parent::__construct();
        
        $this->table_name = 'm_supplier';
        $this->primary_key = 'M_SupplierID';
    }
    
    function get($ids = false)
    {
        $this->db->select('M_SupplierCode, M_SupplierID, M_SupplierName,
            M_SupplierPhone,M_SupplierHP, M_SupplierAddress, M_SupplierFax', false);
        return parent::get($ids);
    }
    
    
}
?>

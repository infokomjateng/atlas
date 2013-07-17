<?php

class S_usergroup_m extends MY_Model
{
    function __construct() 
    {
        parent::__construct();
        
        $this->table_name = 's_usergroup';
        $this->primary_key = 'S_UserGroupID';
        $this->active_field = 'IsActive';
    }
    
    function get($ids = false)
    {
        $this->db->select('s_usergroup.*',false); 
        return parent::get($ids);
    }
    
    
}
?>

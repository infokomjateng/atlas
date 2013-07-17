<?php

class S_user_m extends MY_Model
{
    function __construct ()
    {
        parent::__construct();
        
        $this->table_name = 's_user';
        $this->primary_key = 'S_UserID';
        $this->active_field = 'IsActive';
    }
    
    function get($ids = false)
    {
        $this->db->select('S_UserID,S_UserName, S_UserUsername, S_UserPassword,S_UserS_UserGroupID, S_UserGroupID, S_UserGroupName',false);
        $this->db->join('s_usergroup','S_UserS_UserGroupID = S_UserGroupID', 'left');
        return parent::get($ids);
    }
}
?>

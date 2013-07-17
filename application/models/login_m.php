<?php

class Login_m extends MY_Model
{
    function __construct ()
    {
        parent::__construct();
        
        $this->table_name = 's_user';
        $this->primary_key = 'S_UserID';
        $this->active_field = 'IsActive';
    }
    
    function login ($username, $password)
    { 
        $password = md5($this->salt . $password . $this->salt);
        $r = $this->db->where('S_UserUsername', $username)
                ->where('S_UserPassword', $password)
                ->where('S_UserIsActive', 1)
                ->get($this->table_name)
                ->row();
        
        if ($r)
            return $r;
        
        return false;
    }
}
?>

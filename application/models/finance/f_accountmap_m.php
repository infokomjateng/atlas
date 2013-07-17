<?php

class F_accountmap_m extends MY_Model
{
    function __construct()
    {
        $this->table_name = 'f_accountmap';
        $this->primary_key = 'F_AccountMapID';
        $this->active_field = 'IsActive';
    }
    
    function get($ids = false)
    {
        return parent::get($ids);
    }
    
    function save($inp)
    {
        $this->db->trans_start();
        
        foreach ($inp['id'] as $k => $v)
        {
            $this->db->where('F_AccountMapID', $v)
                ->update($this->table_name, array(
                    'F_AccountMapF_AccountCode' => $inp['F_AccountMapF_AccountCode'][$k],
                    'F_AccountMapUserID'        => $inp['F_AccountMapUserID'],
                    'F_AccountMapLastUpdate'    => date('Y-m-d H:i:s')
                ));
        }
        
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
}
?>

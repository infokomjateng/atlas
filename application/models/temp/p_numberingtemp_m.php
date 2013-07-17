<?php

class P_numberingtemp_m extends MY_Model
{
    function __construct() 
    {
        parent::__construct();
        
        $this->table_name = 'p_numberingtemp';
        $this->primary_key = 'P_NumberingTempID';
        $this->active_field = 'IsActive';
    }
    
    function useme($type, $user, $branch)
    {
        //delete un-used
        $this->db->where('P_NumberingTempIsActive', 0)
            ->delete($this->table_name);
        
        $r = $this->db->where('P_NumberingTempIsActive', 1)
                ->where('P_NumberingTempInUse', 0)
                ->where('P_NumberingTempType', $type)
                ->where('P_NumberingTempO_BranchCode', $branch)
                ->get($this->table_name)
                ->row();
        if ($r)
        {
            $this->db->where('P_NumberingTempID', $r->P_NumberingTempID)
                    ->where('P_NumberingTempO_BranchCode', $branch)
                    ->set('P_NumberingTempInUse', 1)
                    ->set('P_NumberingTempUserID', $user)
                    ->update($this->table_name);
            return $r->P_NumberingTempNumber;
        }
        else
        {
            $r = $this->db->query("SELECT fn_get_numbering('{$type}','{$branch}') as num")->row();
            $this->clean_mysqli_connection($this->db->conn_id);
            $this->db->insert($this->table_name, array(
                'P_NumberingTempType' => $type,
                'P_NumberingTempInUse' => 1,
                'P_NumberingTempNumber' => $r->num,
                'P_NumberingTempUserID' => $user,
                'P_NumberingTempO_BranchCode' => $branch,
                'P_NumberingTempLastUpdate' => date('Y-m-d H:i:s')
            ));
            
            return $r->num;
        }
    }
    
    function delme($id)
    {
        $this->db->where("(P_NumberingTempID = '{$id}' OR P_NumberingTempNumber = '{$id}')", null, false)
            ->delete($this->table_name);
    }
    
    function notuse($id)
    {
        $this->db->where("(P_NumberingTempID = '{$id}' OR P_NumberingTempNumber = '{$id}')", null, false)
            ->update($this->table_name, array(
                'P_NumberingTempInUse' => 0,
                'P_NumberingTempLastUpdate' => date('Y-m-d H:i:s')
            ));
    }
}
?>

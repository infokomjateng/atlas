<?php

class M_drivers_m extends MY_Model
{
    function __construct() 
    {
        parent::__construct();
        
        $this->table_name = 'm_drivers';
        $this->primary_key = 'M_DriversID';
    }
    
    function get($ids = false)
    {
        $this->db->select('M_DriversName, M_DriversAddress, M_DriversID, M_DriversCode, IF(M_DriversIsGoing = 1, \'Jalan\', \'Tidak\') as M_DriversIsGoing,
                           M_DriversPOB, M_DriversDOB, M_DriversBranchID, M_DriversWorkDate, M_DriversSIMType, M_DriversSIMDate,
                           M_DriversKSLimit, M_DriversIsBlocked, M_DriversBlockedNote,
                           M_DriversKS, M_DriversBS', false);
        return parent::get($ids);
    }
    
    function ori_get($ids = false)
    {
        return parent::get($ids);
    }
    
    function autocomplete($q)
    {
        $r = $this->db->select('M_DriversID, M_DriversCode, M_DriversName', false)
                ->where('M_DriversIsActive', 1)
                ->where('M_DriversIsBlocked', 0)
                ->where("(M_DriversCode LIKE '%{$q}%' OR  M_DriversName LIKE '%{$q}%')", null, false)
                ->order_by('M_DriversCode')
                ->get($this->table_name)
                ->result_array();
                
        if ($r)
        {
            $d = array();
            foreach ($r as $k => $v)
            {
                array_push($d, array('id'=>$v['M_DriversID'],'label'=>$v['M_DriversCode'] . ' | ' . $v['M_DriversName'],'value'=>$v['M_DriversCode']));
            }
            return $d;
        }
        
        return false;
    }
    
    function get_by_code($code)
    {
        $r = $this->db->select('M_DriversID, M_DriversCode, M_DriversName, M_DriversAddress, M_DriversKSLimit,
                                (IFNULL(M_DriversKS,0) + IFNULL(M_DriversBS,0)) as TotalKSBS', false)
                ->join('m_driverspay', 'M_DriversPayM_DriversCode = M_DriversCode AND M_DriversPayIsActive = M_DriversIsActive', 'left')
                ->where('M_DriversIsActive', 1)
                ->where('M_DriversIsBlocked', 0)
                ->where("M_DriversCode", $code)
                ->get($this->table_name)
                ->row();
        
        if ($r)
            return $r;
        
        return false;
    }
}
?>

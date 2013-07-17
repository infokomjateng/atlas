<?php

class T_spjsetor_m extends MY_Model
{
    function __construct() 
    {
        parent::__construct();
        
        $this->table_name = 't_spjsetor';
        $this->primary_key = 'T_SpjSetorID';
        $this->active_field = 'IsActive';
    }
    
    function get($ids = false)
    {
        $this->db->join('t_spj', 'T_SpjSetorT_SpjNumber = T_SpjNumber AND T_SpjSetorIsActive = T_SpjIsActive')
                ->join('m_drivers', 'T_SpjM_DriversCode = M_DriversCode')
                ->select('*', false);
        return parent::get($ids);
    }
    
    function get_drivers_available ($term)
    {
        $r = $this->db->select('T_SpjID, M_DriversID, M_DriversCode, M_DriversName', false)
                ->join('m_drivers', 'T_SpjM_DriversCode = M_DriversCode AND T_SpjIsActive = M_DriversIsActive')
                ->join('m_driverspay', 'M_DriversPayM_DriversCode = M_DriversCode AND M_DriversPayIsActive = M_DriversIsActive', 'left')
                ->where('M_DriversIsBlocked', 0)
                ->where("(M_DriversCode LIKE '%{$term}%' OR M_DriversName LIKE '%{$term}%')", null, false)
                ->get('v_spjavailable')
                ->result_array();
        
        if ($r)
        {
            $d = array();
            foreach ($r as $k => $v)
            {
                array_push($d, array('id'=>$v['T_SpjID'],'value'=>$v['M_DriversCode'],'label'=>$v['M_DriversCode'] . ' | ' . $v['M_DriversName']));
            }
            return $d;
        }
            return $r;
        
        return false;
    }
    
    function get_spj_info ($code)
    {
        $r = $this->db->select('T_SpjID, M_DriversID, M_DriversCode, M_DriversName, M_DriversAddress', false)
                ->join('')
                ->join('m_drivers', 'T_SpjM_DriversCode = M_DriversCode AND T_SpjIsActive = M_DriversIsActive')
                ->join('m_driverspay', 'M_DriversPayM_DriversCode = M_DriversCode AND M_DriversPayIsActive = M_DriversIsActive', 'left')
                ->where('M_DriversIsBlocked', 0)
                ->where("T_SpjM_DriversCode", $code)
                ->get($this->table_name)
                ->result_array();
        
        if ($r)
        {
            $d = array();
            foreach ($r as $k => $v)
            {
                array_push($d, array('id'=>$v['T_SpjID'],'value'=>$v['M_DriversCode'],'label'=>$v['M_DriversCode'] . ' | ' . $v['M_DriversName']));
            }
            return $d;
        }
            return $r;
        
        return false;
    }
    
    function save($data, $id = FALSE) 
    {
        $this->db->trans_start();
        
        $this->db->where('M_FleetCode', $data['T_SpjSetorM_FleetCode'])
                ->update('m_fleet', array(
                    'M_FleetEndKM' => $data['T_SpjSetorEndKM']
                ));
        
        if ($data['T_SpjSetorDibayar'] == 0)
        {
            $this->db->set('M_DriversBS', 'M_DriversBS + ' . $data['T_SpjSetorTotal'], false);
        }
        else
        {
            $this->db->set('M_DriversKS', 'M_DriversKS + ' . $data['T_SpjSetorKS'], false);
        }
        $this->db->where('M_DriversCode', $data['T_SpjSetorM_DriversCode'])
                ->update('m_drivers');
        
        $x = parent::save($data, $id);
        
        $this->db->trans_complete();
        return $x;
    }
}
?>

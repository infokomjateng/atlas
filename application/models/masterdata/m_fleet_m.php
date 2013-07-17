<?php

class M_fleet_m extends MY_Model
{
    function __construct() 
    {
        parent::__construct();
        
        $this->table_name = 'm_fleet';
        $this->primary_key = 'M_FleetID';
    }
    
    function get($ids = false)
    {
        $this->db->select('*', false);
        return parent::get($ids);
    }
    
    function get_list()
    {
        $r = $this->db->select('M_FleetCode, M_FleetVehicleType', false)
                ->where('M_FleetIsActive', 1)
                ->get($this->table_name)
                ->result_array();
        
        $d = array();
        foreach ($r as $k => $v)
        {
            $d[$v['M_FleetCode']] = $v['M_FleetCode'] . ' - ' . $v['M_FleetVehicleType'];
        }
        
        return $d;
    }
    
    function get_info($code)
    {
        $r = $this->db->where('M_FleetCode', $code)
                ->get('v_fleetinfo')
                ->row();
        
        return $r;
    }
}
?>

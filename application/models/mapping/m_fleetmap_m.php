<?php

class M_fleetmap_m extends MY_Model
{
    function __construct() 
    {
        parent::__construct();
        
        $this->table_name = 'm_fleetmap';
        $this->primary_key = 'M_FleetMapID';
        $this->active_field = 'IsActive';
    }
    
    function get($ids = false)
    {
        
        return parent::get($ids);
    }
    
    public function listing($inp, $ar_search) 
    {
        $iDisplayLength = $inp->get("iDisplayLength");
        $iDisplayStart = $inp->get("iDisplayStart");

        for($i=0;$i< $inp->get("iSortingCols"); $i++) {
                $idx = $inp->get("iSortCol_" . $i);
                $sort_field = $inp->get("mDataProp_$idx");
                $sort_dir = $inp->get("sSortDir_$i");

                $this->db->order_by($sort_field,$sort_dir);
        }

        $xrst = $this->db->select('FleetCode, FleetVehicleType, IFNULL(GROUP_CONCAT(DriversName), "~ Belum ada data ~") as DriversName, "" as xaction', false)
                ->join($this->table_name, 'FleetMapFleetCode = FleetCode', 'left')
                ->join('drivers', 'FleetMapDriversCode = DriversCode', 'left')
                ->where('FleetIsActive', 1)
                ->where( "(FleetCode LIKE '%{$inp->get('sSearch')}%' OR FleetVehicleType LIKE '%{$inp->get('sSearch')}%')" )
                ->group_by('FleetCode')
                ->limit($iDisplayLength)->offset($iDisplayStart)
                ->get('fleet')
                ->result_array();

        $n  = $this->db->select('count(FleetID) as cnt', false)
                ->where('FleetIsActive', 1)
                ->where( "(FleetCode LIKE '%{$inp->get('sSearch')}%' OR FleetVehicleType LIKE '%{$inp->get('sSearch')}%')" )
                ->get('fleet')
                ->row();
        
        $tot_rec = $n->cnt;
        $tot_disp_rec= $n->cnt;

        return array($tot_rec,$tot_disp_rec,$xrst);		
    }
    
    function get_available()
    {
        $r = $this->db->select('DriversCode, DriversName')
                ->where('DriversCode NOT IN (SELECT DriversCode FROM fleetmap WHERE FleetMapIsActive = 1)')
                ->where('DriversIsActive', 1)
                ->get('drivers')
                ->result_array();
        
        return $r;
    }
    
    function get_connected($id)
    {
        $r = $this->db->select('DriversCode, DriversName')
                ->where('DriversCode IN (SELECT DriversCode FROM fleetmap WHERE FleetMapIsActive = 1 AND FleetMapFleetCode = "' . $id . '")')
                ->where('DriversIsActive', 1)
                ->get('drivers')
                ->result_array();
        
        return $r;
    }
    
    public function listing_available($inp, $ar_search) 
    {
        $iDisplayLength = $inp->get("iDisplayLength");
        $iDisplayStart = $inp->get("iDisplayStart");

        for($i=0;$i< $inp->get("iSortingCols"); $i++) {
                $idx = $inp->get("iSortCol_" . $i);
                $sort_field = $inp->get("mDataProp_$idx");
                $sort_dir = $inp->get("sSortDir_$i");

                $this->db->order_by($sort_field,$sort_dir);
        }

        $xrst = $this->db->select('DriversCode, DriversName, "" as xaction', false)
                ->where('DriversIsActive', 1)
                ->where( "(DriversCode LIKE '%{$inp->get('sSearch')}%' OR DriversName LIKE '%{$inp->get('sSearch')}%')" )
                ->where( 'DriversCode NOT IN (SELECT DriversCode FROM fleetmap WHERE FleetMapIsActive = 1)' )
                ->limit($iDisplayLength)->offset($iDisplayStart)
                ->get('drivers')
                ->result_array();

        $n  = $this->db->select('count(DriversID) as cnt', false)
                ->where('DriversIsActive', 1)
                ->where( "(DriversCode LIKE '%{$inp->get('sSearch')}%' OR DriversName LIKE '%{$inp->get('sSearch')}%')" )
                ->where( 'DriversCode NOT IN (SELECT DriversCode FROM fleetmap WHERE FleetMapIsActive = 1)' )
                ->get('drivers')
                ->row();
        
        $tot_rec = $n->cnt;
        $tot_disp_rec= $n->cnt;

        return array($tot_rec,$tot_disp_rec,$xrst);		
    }
    
    public function listing_connected($inp, $ar_search) 
    {
        $iDisplayLength = $inp->get("iDisplayLength");
        $iDisplayStart = $inp->get("iDisplayStart");

        for($i=0;$i< $inp->get("iSortingCols"); $i++) {
                $idx = $inp->get("iSortCol_" . $i);
                $sort_field = $inp->get("mDataProp_$idx");
                $sort_dir = $inp->get("sSortDir_$i");

                $this->db->order_by($sort_field,$sort_dir);
        }

        $xrst = $this->db->select('DriversCode, DriversName, "" as xaction', false)
                ->where('DriversIsActive', 1)
                ->where( "(DriversCode LIKE '%{$inp->get('sSearch')}%' OR DriversName LIKE '%{$inp->get('sSearch')}%')" )
                ->where( "DriversCode IN (SELECT DriversCode FROM fleetmap WHERE FleetMapIsActive = 1 AND FleetMapFleetCode = '{$inp->get('FleetMapFleetCode')}')" )
                ->limit($iDisplayLength)->offset($iDisplayStart)
                ->get('drivers')
                ->result_array();

        $n  = $this->db->select('count(DriversID) as cnt', false)
                ->where('DriversIsActive', 1)
                ->where( "(DriversCode LIKE '%{$inp->get('sSearch')}%' OR DriversName LIKE '%{$inp->get('sSearch')}%')" )
                ->where( "DriversCode IN (SELECT DriversCode FROM fleetmap WHERE FleetMapIsActive = 1 AND FleetMapFleetCode = '{$inp->get('FleetMapFleetCode')}')" )
                ->get('drivers')
                ->row();
        
        $tot_rec = $n->cnt;
        $tot_disp_rec= $n->cnt;

        return array($tot_rec,$tot_disp_rec,$xrst);		
    }
    
    function get_by_driverscode ($code)
    {
        $this->db->select('M_FleetMapM_FleetCode', false)
                ->where('M_FleetMapM_DriversCode', $code);
        return parent::get(false);
    }
}
?>

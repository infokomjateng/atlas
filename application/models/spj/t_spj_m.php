<?php

class T_spj_m extends MY_Model
{
    function __construct() 
    {
        parent::__construct();
        
        $this->table_name = 't_spj';
        $this->primary_key = 'T_SpjID';
    }
    
    function get($ids = false)
    {
        $this->db->join('m_drivers', 'T_SpjM_DriversCode = M_DriversCode')
                ->select('*', false);
        return parent::get($ids);
    }
    
    function get_available ($code)
    {
        $r = $this->db->select('*')
                ->where('T_SpjM_DriversCode', $code)
                ->get('v_spjavailable')
                ->row();
        if ($r)
            return $r;
        
        return false;
    }
    
    function get_info ($id)
    {
        $r = $this->db->select('T_SpjID, T_SpjDate, T_SpjTime, T_SpjStartKM, T_SpjNumber,
                                M_DriversID, M_DriversCode, M_DriversName, M_DriversAddress, M_FleetCode,
                                T_SpjPay, T_SpjPotongan, (T_SpjPay - T_SpjPotongan) as T_SpjSetoran,
                                M_FleetHour')
                ->join('m_drivers', 'T_SpjM_DriversCode = M_DriversCode AND T_SpjIsACtive = M_DriversIsActive', 'left')
                ->join('m_fleet', 'T_SpjM_FleetCode = M_FleetCode AND T_SpjIsACtive = M_FleetIsActive', 'left')
                ->where('T_SpjID', $id)
                ->get($this->table_name)
                ->row();
        if ($r)
        {
            $s = new DateTime($r->T_SpjDate . ' ' . $r->T_SpjTime);
            $e = new DateTime(date('Y-m-d H:i:s'));
            $d = $s->diff($e);
            
            $r1 = 15000;
            $r2 = 25000;
            $h = ceil($d->h + ($d->i / 60) + ($d->d * 24));
            if ($h <= $r->M_FleetHour )
            {
                $r->T_SpjSetoran = $r->T_SpjSetoran;
            } 
            else
            {
                //if 2 days -> lanjut
                if (strtotime(date('Y-m-d')) >= ( strtotime($r->T_SpjDate) + (24*2*3600) ) )
                {
                    
                    $r->T_SpjSetoran = ( $r->T_SpjPay * 2 ) - $r->T_SpjPotongan;
                }
                else
                {
                    $r->T_SpjSetoran = ( $r1 * ceil($d->h + ($d->i / 60)) ) + $r->T_SpjPay - $r->T_SpjPotongan;
                }
            }
            
            return $r;
        }
            
        
        return false;
    }
    
    function save($data, $id = false)
    {
        $this->db->trans_start();
        
        if ($id == false) {
            $n = $this->db->query("SELECT fn_get_numbering('SPJ1','{$this->user->Branch}') as num")->row();
            $data['T_SpjNumber'] = $n->num;
        }
            
        $x = parent::save($data, $id);
        
        $this->db->where('M_FleetCode', $data['T_SpjM_FleetCode'])
                ->update('m_fleet', array(
                    'M_FleetStartKM' => $data['T_SpjStartKM']
                ));
        
        $this->db->trans_complete();
        return array($x, $data['T_SpjNumber']);
    }
}
?>

<?php

class M_menu_m extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        
        $this->table_name = 'm_menu';
        $this->active_field = 'IsActive';
        $this->primary_key = 'M_MenuID';
    }
    
    function get_level_0()
    {
        return $this->db->select('m1.M_MenuName, m1.M_MenuUrl, m1.M_MenuIcon, m1.M_MenuRel', false)
                ->join('m_menu m2', 'm2.M_MenuLeft < m1.M_MenuLeft AND m2.M_MenuRight > m1.M_MenuRight AND m2.M_MenuIsActive = m1.M_MenuIsActive', 'left')
                ->where('m1.M_MenuIsActive', 1)
                ->group_by('m1.M_MenuID')
                ->having('COUNT(m2.M_MenuID)', 0)
                ->order_by('m1.M_MenuLeft ASC')
                ->get($this->table_name . ' m1')
                ->result_array();
    }
    
    function get_level_1($rel)
    {
        return $this->db->select('m1.M_MenuName, IF(m1.M_MenuUrl = "#", "javascript:void(0)", m1.M_MenuUrl) as M_MenuUrl, m1.M_MenuIcon, m1.M_MenuRel', false)
                ->join('m_menu m2', 'm2.M_MenuLeft < m1.M_MenuLeft AND m2.M_MenuRight > m1.M_MenuRight AND m2.M_MenuIsActive = m1.M_MenuIsActive', 'left')
                ->where('m1.M_MenuIsActive', 1)
                ->where('m2.M_MenuRel', $rel)
                ->group_by('m1.M_MenuID')
                ->order_by('m1.M_MenuLeft')
                ->having('COUNT(m2.M_MenuID)', 1)
                ->get($this->table_name . ' m1')
                ->result_array();
    }
    
    function get_level_all()
    {
        $r = $this->db->select('m1.M_MenuName, m1.M_MenuUrl, m1.M_MenuIcon, m1.M_MenuRel, COUNT(m2.M_MenuID) as level', false)
                ->join('m_menu m2', 'm2.M_MenuLeft < m1.M_MenuLeft AND m2.M_MenuRight > m1.M_MenuRight AND m2.M_MenuIsActive = m1.M_MenuIsActive', 'left')
                ->where('m1.M_MenuIsActive', 1)
                ->group_by('m1.M_MenuID')
                ->having('COUNT(m2.M_MenuID) < ', 2)
                ->order_by('m1.M_MenuLeft ASC')
                ->get($this->table_name . ' m1')
                ->result_array();
        
        if ($r)
        {
            $d = array();
            $c = -1;
            $e = 0;
            foreach ($r as $k => $v)
            {
                if ($v['level'] == 0)
                {
                    $c++;
                    array_push($d, $v);
                    $e = 0;
                }
                else {
                    $d[$c]['menuitems'][$e] = $v;
                    $e++;
                }
            }
            
            return $d;
        }
        
        return false;
    }
}
?>

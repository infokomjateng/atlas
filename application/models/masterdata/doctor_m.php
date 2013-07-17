<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Doctor_m extends MY_Model
{
    function __construct() 
    {
        parent::__construct();
        
        $this->table_name = 'doctor';
        $this->primary_key = 'DoctorID';
    }
    
    function get($ids = false)
    {
        $this->db->flush_cache();
        return parent::get($ids);
    }
    
    function autocomplete2($term) 
    {
        $r = $this->db->where("DoctorName LIKE '%{$term}%'")
                ->where('DoctorIsActive', 'Y')
                ->get($this->table_name)
                ->result_array();
                
        if ($r)
        {
            $d = array();
            foreach ($r as $k => $v)
            {
                $t = array('id' => $v['DoctorID'], 'label' => array(
                                                            'DoctorName' => $v['DoctorName']
                                                        ), 'value' => $v['DoctorName'], 
                            'desc' => "<h5 class=\"h5list\">{$v['DoctorName']}</h5>");
                array_push($d,$t);
            }
            
            return $d;
        }
        
        return false;
    }
}
?>

<?php

class L_paylog_m extends MY_Model
{
    function __construct()
    {
        $this->table_name = 'l_paylog';
        $this->primary_key = 'L_PayLogID';
        $this->active_field = 'IsActive';
    }
    
    function get($ids = false)
    {
        return parent::get($ids);
    }
    
    function save($data, $id = FALSE) 
    {
        $this->db->trans_start();
                
        /* delete temp number */
        $this->load->model('temp/p_numberingtemp_m');
        $this->p_numberingtemp_m->delme($data['L_PayLogNumber']);
        
        if ($data['L_PayLogType'] == 'KS')
        {
            //$n = $this->db->query("SELECT fn_get_numbering('NTKS','{$data['L_PayLogO_BranchCode']}') as numb")->row();
            //$this->clean_mysqli_connection($this->db->conn_id);
            //$data['L_PayLogNumber'] = $n->numb;
            
            $this->db->where('M_DriversCode', $data['L_PayLogM_DriversCode'])
                ->set('M_DriversKS', 'M_DriversKS - ' . $data['L_PayLogAmount'], false)
                ->update('m_drivers');
        }
        else if ($data['L_PayLogType'] == 'BS')
        {
            //$n = $this->db->query("SELECT fn_get_numbering('NTKS','{$data['L_PayLogO_BranchCode']}') as numb")->row();
            //$this->clean_mysqli_connection($this->db->conn_id);
            //$data['L_PayLogNumber'] = $n->numb;
            
            $this->db->where('M_DriversCode', $data['L_PayLogM_DriversCode'])
                ->set('M_DriversBS', 'M_DriversBS - ' . $data['L_PayLogAmount'], false)
                ->update('m_drivers');
        }
        else if ($data['L_PayLogType'] == 'CC')
        {
            
        }
        
        $x = parent::save($data);
        
        if ($data['L_PayLogType'] == 'BS' || $data['L_PayLogType'] == 'KS')
            $this->db->query("
                UPDATE l_paylog
                JOIN m_drivers ON L_PayLogM_DriversCode = M_DriversCode AND L_PayLogIsActive = M_DriversIsActive
                SET L_PayLogBalance = M_Drivers{$data['L_PayLogType']}
                WHERE L_PayLogID = {$x}
                ");
        
        $this->db->trans_complete();
        return $x;
    }
}
?>

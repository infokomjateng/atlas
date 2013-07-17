<?php

class R_reports_m extends MY_Model
{
    function spjrekap($branch, $sdate, $edate)
    {
        $rst = $this->db->query("CALL `sp_rpt_spjsetor`('{$branch}','{$sdate}','$edate')")->result_array();
        $this->clean_mysqli_connection($this->db->conn_id);
        
        return $rst;
    }
}
?>

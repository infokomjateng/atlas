<?php

class Notabs extends MY_Controller
{
    function __construct() 
    {
        parent::__construct();
        
        $this->load->model('log/l_paylog_m');
    }
    
    function index()
    {
        $this->load->view('reports/notabs');
    }
    
    function report($id)
    {
        $this->db->join('m_drivers', 'L_PayLogM_DriversCode = M_DriversCode');
        $dt['bs'] = $this->l_paylog_m->get($id);
        $this->load->view('reports/notabs', $dt);
    }
    
    function reportRaw($id, $inline = false)
    {
        $this->db->join('m_drivers', 'L_PayLogM_DriversCode = M_DriversCode');
        $bs = $this->l_paylog_m->get($id);
        
        $arr = array();
        $arr = $this->headerSans('NEW ATLAS TAXI|BUKTI PEMBAYARAN BS', $arr);
        array_push($arr, str_pad('Tanggal', 18, ' ', STR_PAD_RIGHT) . ': ' . str_pad($bs->L_PayLogDate, 19, ' ', STR_PAD_RIGHT) . '  ' .
                         str_pad('No. Bukti', 18, ' ', STR_PAD_RIGHT) . ': ' . str_pad($bs->L_PayLogNumber, 19, ' ', STR_PAD_RIGHT) . "\r\n");
        array_push($arr, str_pad('No. KTA', 18, ' ', STR_PAD_RIGHT) . ': ' . str_pad($bs->M_DriversCode, 19, ' ', STR_PAD_RIGHT) . '  ' .
                         str_pad('Nama Pengemudi', 18, ' ', STR_PAD_RIGHT) . ': ' . str_pad($bs->M_DriversName, 19, ' ', STR_PAD_RIGHT) . "\r\n");
        array_push($arr, str_repeat('-', 80) . "\r\n");
        array_push($arr, str_pad('Jumlah BS', 18, ' ', STR_PAD_RIGHT) . ': ' . str_pad(number_format($bs->L_PayLogAmount + $bs->L_PayLogBalance, 0, ',', '.'), 19, ' ', STR_PAD_LEFT) . '  ' .
                         str_pad('Catatan :', 20, 'TAMBAL BAN ', STR_PAD_RIGHT) . "\r\n");
        array_push($arr, str_pad('Potongan', 18, ' ', STR_PAD_RIGHT) . ': ' . str_pad(number_format($bs->L_PayLogAmount + $bs->L_PayLogDiscount, 0, ',', '.'), 19, ' ', STR_PAD_LEFT) . '  ' 
                          . "\r\n");
        array_push($arr, str_repeat('-', 39) . "\r\n");
        array_push($arr, str_pad('Jumlah Bayar', 18, ' ', STR_PAD_RIGHT) . ': ' . str_pad(number_format($bs->L_PayLogAmount, 0, ',', '.'), 19, ' ', STR_PAD_LEFT) . "\r\n");
        array_push($arr, str_repeat('-', 39) . "\r\n");
        array_push($arr, str_pad('Jumlah KS', 18, ' ', STR_PAD_RIGHT) . ': ' . str_pad(number_format($bs->L_PayLogBalance, 0, ',', '.'), 19, ' ', STR_PAD_LEFT) . "\r\n");
        array_push($arr, str_repeat('=', 80) . "\r\n");
        array_push($arr, date('d-m-Y H:i:s') . " " . $this->user->UserUn . " | " . $this->user->UserNm . "\r\n");
        array_push($arr, str_repeat(' ', 55) . str_pad('Tanda Terima', floor( (25 - strlen('Tanda Terima'))/2 ) + strlen('Tanda Terima'), ' ', STR_PAD_LEFT) . "\r\n");
        array_push($arr, str_repeat(' ', 55) . str_pad('Kasir', floor( (25 - strlen('Kasir'))/2 ) + strlen('Kasir'), ' ', STR_PAD_LEFT) . "\r\n\r\n\r\n\r\n");
        array_push($arr, str_repeat(' ', 55) . str_pad('( ' . $this->user->UserNm . ' )', floor( (25 - strlen('( ' . $this->user->UserNm . ' )'))/2 ) + strlen('( ' . $this->user->UserNm . ' )'), ' ', STR_PAD_LEFT) . "\r\n");
        
        //return $arr;
        if ($inline)
            return $arr;
        else
            echo json_encode($arr);
    }
    
    
    function reportInline($id)
    {
        $x = $this->reportRaw($id, true);
        $s = '';
        foreach ($x as $k => $v)
        {
            $s = $s . $v;
        }
        echo $s;
    }
}
?>

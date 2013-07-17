<?php

class Spjsetor extends MY_Controller
{
    function __construct() 
    {
        parent::__construct();
        
        $this->load->model(array('spj/t_spjsetor_m','reports/r_reports_m'));
    }
    
    function index()
    {
        $this->load->view('reports/spjsetor');
    }
    
    function report($id)
    {
        $this->db->join('m_fleet', 'T_SpjSetorM_FleetCode = M_FleetCode');
        $dt['spj'] = $this->t_spjsetor_m->get($id);
        $this->load->view('reports/spjsetor', $dt);
    }
    
    function rekap($startdate, $enddate)
    {
        $r = $this->r_reports_m->spjrekap($this->user->Branch, $startdate, $enddate);
        
    }
    
    function reportRaw($id, $inline = false)
    {
        $this->db->join('m_fleet', 'T_SpjSetorM_FleetCode = M_FleetCode');
        $spj = $this->t_spjsetor_m->get($id);
        $x = $this->session->userdata('atlas');
        
        $arr = array();
        $arr = $this->headerSans('NEW ATLAS TAXI|BUKTI SETORAN ARMADA JALAN', $arr);
        array_push($arr, str_pad('Tanggal', 18, ' ', STR_PAD_RIGHT) . ': ' . str_pad($spj->T_SpjDate, 19, ' ', STR_PAD_RIGHT) . '  ' .
                         str_pad('No. SPJ', 18, ' ', STR_PAD_RIGHT) . ': ' . str_pad($spj->T_SpjNumber, 19, ' ', STR_PAD_RIGHT) . "\r\n");
        array_push($arr, str_pad('No. Lambung', 18, ' ', STR_PAD_RIGHT) . ': ' . str_pad($spj->M_FleetCode, 19, ' ', STR_PAD_RIGHT) . '  ' .
                         str_pad('Jenis Mobil', 18, ' ', STR_PAD_RIGHT) . ': ' . str_pad($spj->M_FleetVehicleType, 19, ' ', STR_PAD_RIGHT) . "\r\n");
        array_push($arr, str_pad('No. KTA', 18, ' ', STR_PAD_RIGHT) . ': ' . str_pad($spj->M_DriversCode, 19, ' ', STR_PAD_RIGHT) . '  ' .
                         str_pad('Nama Pengemudi', 18, ' ', STR_PAD_RIGHT) . ': ' . str_pad($spj->M_DriversName, 19, ' ', STR_PAD_RIGHT) . "\r\n");
        array_push($arr, str_repeat(' ', 79). "\r\n");
        array_push($arr, str_pad('Jam Berangkat', 18, ' ', STR_PAD_RIGHT) . ': ' . str_pad(substr($spj->T_SpjTime, 0, 5), 19, ' ', STR_PAD_RIGHT) . '  ' .
                         str_pad('Batas Jam Pulang', 18, ' ', STR_PAD_RIGHT) . ': ' . str_pad(date('H:i', strtotime($spj->T_SpjDate . ' ' . $spj->T_SpjTime) + ($spj->M_FleetHour * 3600)), 19, ' ', STR_PAD_RIGHT) . "\r\n");
        array_push($arr, str_pad('Tanggal Merapat', 18, ' ', STR_PAD_RIGHT) . ': ' . str_pad(date('d-m-Y', strtotime($spj->T_SpjSetorDate)), 19, ' ', STR_PAD_RIGHT) . '  ' .
                         str_pad('Jam Pulang', 18, ' ', STR_PAD_RIGHT) . ': ' . str_pad(date('H:i', strtotime('2001-01-01 ' . $spj->T_SpjSetorTime)), 19, ' ', STR_PAD_RIGHT) . "\r\n");
        array_push($arr, str_repeat('-', 80) . "\r\n");
        array_push($arr, str_pad('Target Setoran', 18, ' ', STR_PAD_RIGHT) . ': ' . str_pad(number_format($spj->T_SpjSetorPay,0,',','.') , 19, ' ', STR_PAD_LEFT) . '  ' .
                         str_pad('Catatan', 12, ' ', STR_PAD_RIGHT) . ': ' . str_pad($spj->T_SpjNote, 24, ' ', STR_PAD_RIGHT) . "\r\n");
        array_push($arr, str_pad('Iuran Laka', 18, ' ', STR_PAD_RIGHT) . ': ' . str_pad(number_format($spj->T_SpjSetorLaka,0,',','.'), 19, ' ', STR_PAD_LEFT) . "\r\n");
        array_push($arr, str_repeat('-', 39) . "\r\n");
        array_push($arr, str_pad('Over Time', 18, ' ', STR_PAD_RIGHT) . ': ' . str_pad(number_format($spj->T_SpjSetorOvertime,0,',','.'), 19, ' ', STR_PAD_LEFT) . '  ' .
                         str_pad('KM. Spido Berangkat', 22, ' ', STR_PAD_RIGHT) . ': ' . str_pad(number_format($spj->T_SpjStartKM,0,',','.'), 14, ' ', STR_PAD_LEFT) . "\r\n");
        array_push($arr, str_repeat('-', 39) . '  ' . str_pad('KM. Spido Kembali', 22, ' ', STR_PAD_RIGHT) . ': ' . str_pad(number_format($spj->T_SpjSetorEndKM,0,',','.'), 14, ' ', STR_PAD_LEFT) . "\r\n");
        array_push($arr, str_pad('Jml. Pendapatan', 18, ' ', STR_PAD_RIGHT) . ': ' . str_pad(number_format($spj->T_SpjSetorPay + $spj->T_SpjSetorLaka + $spj->T_SpjSetorOvertime,0,',','.'), 19, ' ', STR_PAD_LEFT) . '  ' .
                         str_repeat(' ', 28) . str_repeat('-', 10) . "\r\n");
        array_push($arr, str_repeat('-', 39) . '  ' .
                         str_pad('Selisih KM', 22, ' ', STR_PAD_RIGHT) . ': ' . str_pad(number_format($spj->T_SpjSetorEndKM - $spj->T_SpjStartKM,0,',','.'), 14, ' ', STR_PAD_LEFT) . "\r\n");
        array_push($arr, str_pad('Angsuran/Cicilan', 18, ' ', STR_PAD_RIGHT) . ': ' . str_pad(number_format($spj->T_SpjSetorAngsuran,0,',','.'), 19, ' ', STR_PAD_LEFT) . '  ' .
                         "\r\n");
        array_push($arr, str_repeat('-', 39) . '  ' . str_pad('RIT', 22, ' ', STR_PAD_RIGHT) . ': ' . str_pad($spj->T_SpjPotonganNote, 14, ' ', STR_PAD_RIGHT) . "\r\n");
        array_push($arr, str_pad('Potongan', 18, ' ', STR_PAD_RIGHT) . ': ' . str_pad(number_format($spj->T_SpjSetorPotonganLain,0,',','.'), 19, ' ', STR_PAD_LEFT)  . "\r\n");
        array_push($arr, str_repeat('-', 39) . "\r\n");
        array_push($arr, str_pad('Jml Harus Disetor', 18, ' ', STR_PAD_RIGHT) . ': ' . str_pad(number_format($spj->T_SpjSetorPay + $spj->T_SpjSetorLaka + $spj->T_SpjSetorOvertime + $spj->T_SpjSetorAngsuran - $spj->T_SpjSetorPotonganLain,0,',','.'), 19, ' ', STR_PAD_LEFT) . '  ' .
                         str_pad('Disetujui', 12, ' ', STR_PAD_RIGHT) . ': ' . str_pad('( ' . $spj->T_SpjSignature . ' )', 24, ' ', STR_PAD_RIGHT) . "\r\n");
        array_push($arr, str_repeat('-', 39). "\r\n");
        array_push($arr, str_pad('Voucher', 18, ' ', STR_PAD_RIGHT) . ': ' . str_pad(number_format($spj->T_SpjSetorVoucherAmount, 0,',','.'), 19, ' ', STR_PAD_LEFT) . '  ' .
                          "\r\n");
        array_push($arr, str_pad('Setoran', 18, ' ', STR_PAD_RIGHT) . ': ' . str_pad(number_format($spj->T_SpjSetorDibayar, 0,',','.'), 19, ' ', STR_PAD_LEFT) . '  ' .
                          "\r\n");
        array_push($arr, str_repeat('-', 39).'  '.str_repeat('-', 18).'  '.str_repeat('-', 18). "\r\n");
        array_push($arr, str_pad('Kurang/Belum Setor', 18, ' ', STR_PAD_RIGHT) . ': ' . str_pad(number_format($spj->T_SpjSetorKS + $spj->T_SpjSetorBS, 0,',','.').'', 19, ' ', STR_PAD_LEFT) . '  ' .
                         str_pad('    Pengemudi', 18, ' ', STR_PAD_RIGHT) . '  ' . str_pad('      Kasir', 18, ' ', STR_PAD_RIGHT) . "\r\n");
        array_push($arr, str_repeat('-', 79). "\r\n");
        array_push($arr, date('d-m-Y H:i:s') . ' ' . $x['un'] . ' | ' . $x['nm'] . "\r\n");
        
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

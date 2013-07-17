<?php

class Spj extends MY_Controller
{
    function __construct() 
    {
        parent::__construct();
        
        $this->load->model('spj/t_spj_m');
    }
    
    function index()
    {
        $this->load->view('reports/spj');
    }
    
    function report($id)
    {
        $this->db->join('m_fleet', 'T_SpjM_FleetCode = M_FleetCode');
        $dt['spj'] = $this->t_spj_m->get($id);
        $this->load->view('reports/spj-min', $dt);
    }
    
    function reportRaw($id, $inline = false)
    {
        $this->db->join('m_fleet', 'T_SpjM_FleetCode = M_FleetCode');
        //$this->db->join('m_drivers', 'T_SpjM_DriversCode = M_DriversCode');
        $this->db->join('o_branch', 'T_SpjO_BranchCode = O_BranchCode');
        $spj = $this->t_spj_m->get($id);
        $x = $this->session->userdata('atlas');
        
        $arr = array();
        $arr = $this->headerSans('NEW ATLAS TAXI|SURAT PERINTAH JALAN', $arr);
        array_push($arr, str_pad('Tanggal', 18, ' ', STR_PAD_RIGHT) . ': ' . str_pad($spj->T_SpjDate, 19, ' ', STR_PAD_RIGHT) . '  ' .
                         str_pad('No. SPJ', 18, ' ', STR_PAD_RIGHT) . ': ' . str_pad($spj->T_SpjNumber, 19, ' ', STR_PAD_RIGHT) . "\r\n");
        array_push($arr, str_pad('No. Lambung', 18, ' ', STR_PAD_RIGHT) . ': ' . str_pad($spj->M_FleetCode, 19, ' ', STR_PAD_RIGHT) . '  ' .
                         str_pad('Jenis Mobil', 18, ' ', STR_PAD_RIGHT) . ': ' . str_pad($spj->M_FleetVehicleType, 19, ' ', STR_PAD_RIGHT) . "\r\n");
        array_push($arr, str_pad('No. KTA', 18, ' ', STR_PAD_RIGHT) . ': ' . str_pad($spj->M_DriversCode, 19, ' ', STR_PAD_RIGHT) . '  ' .
                         str_pad('Nama Pengemudi', 18, ' ', STR_PAD_RIGHT) . ': ' . str_pad($spj->M_DriversName, 19, ' ', STR_PAD_RIGHT) . "\r\n");
        array_push($arr, str_pad('Jam Berangkat', 18, ' ', STR_PAD_RIGHT) . ': ' . str_pad(substr($spj->T_SpjTime, 0, 5), 19, ' ', STR_PAD_RIGHT) . '  ' .
                         str_pad('Batas Jam Pulang', 18, ' ', STR_PAD_RIGHT) . ': ' . str_pad(date('H:i', strtotime($spj->T_SpjDate . ' ' . $spj->T_SpjTime) + ($spj->M_FleetHour * 3600)), 19, ' ', STR_PAD_RIGHT) . "\r\n");
        array_push($arr, str_pad('KM.Spido Berangkat', 18, ' ', STR_PAD_RIGHT) . ': ' . str_pad($spj->T_SpjStartKM, 19, ' ', STR_PAD_RIGHT) . '  ' .
                         str_pad('Jumlah Angsuran', 18, ' ', STR_PAD_RIGHT) . ': ' . str_pad('0', 19, ' ', STR_PAD_LEFT) . "\r\n");
        array_push($arr, str_repeat('-', 80) . "\r\n");
        array_push($arr, str_pad('Target Setoran', 18, ' ', STR_PAD_RIGHT) . ': ' . str_pad(number_format($spj->T_SpjPay,0,',','.'), 19, ' ', STR_PAD_LEFT) . '  ' .
                         str_pad('Catatan', 12, ' ', STR_PAD_RIGHT) . ': ' . str_pad($spj->T_SpjNote, 24, ' ', STR_PAD_RIGHT) . "\r\n");
        array_push($arr, str_pad('Iuran Laka', 18, ' ', STR_PAD_RIGHT) . ': ' . str_pad(number_format($spj->T_SpjLaka,0,',','.'), 19, ' ', STR_PAD_LEFT) . "\r\n");
        array_push($arr, str_repeat('-', 39) . "\r\n");
        array_push($arr, str_pad('Over Time', 18, ' ', STR_PAD_RIGHT) . ': ' . str_pad('', 19, ' ', STR_PAD_RIGHT) . '  ' .
                         str_pad('KM. Pulang', 12, ' ', STR_PAD_RIGHT) . ': ' . str_pad('', 24, ' ', STR_PAD_RIGHT) . "\r\n");
        array_push($arr, str_repeat('-', 39). "\r\n");
        array_push($arr, str_pad('Jumlah Pendapatan', 18, ' ', STR_PAD_RIGHT) . ': ' . str_pad('', 19, ' ', STR_PAD_RIGHT) . '  ' . "\r\n");
        array_push($arr, str_repeat('-', 39). "\r\n");
        array_push($arr, str_pad('Potongan Jam', 18, ' ', STR_PAD_RIGHT) . ': ' . str_pad(number_format($spj->T_SpjPotongan,0,',','.'), 19, ' ', STR_PAD_LEFT) . '  ' .
                         str_pad('Keterangan', 12, ' ', STR_PAD_RIGHT) . ': ' . str_pad($spj->T_SpjPotonganNote, 24, ' ', STR_PAD_RIGHT) . "\r\n");
        array_push($arr, str_repeat('-', 39). "\r\n");
        array_push($arr, str_pad('Potongan Lain-2', 18, ' ', STR_PAD_RIGHT) . ': ' . str_pad('', 19, ' ', STR_PAD_RIGHT)  . "\r\n");
        array_push($arr, str_repeat('-', 39). "\r\n");
        array_push($arr, str_pad('Jml Potongan', 18, ' ', STR_PAD_RIGHT) . ': ' . str_pad('', 19, ' ', STR_PAD_RIGHT) . '  ' .
                         str_pad('Disetujui', 12, ' ', STR_PAD_RIGHT) . ': ' . str_pad('( ' . $spj->T_SpjSignature . ' )', 24, ' ', STR_PAD_RIGHT) . "\r\n");
        array_push($arr, str_repeat('-', 39). "\r\n");
        array_push($arr, str_pad('Jml Harus Disetor', 18, ' ', STR_PAD_RIGHT) . ': ' . str_pad(number_format($spj->T_SpjTotal, 0,',','.'), 19, ' ', STR_PAD_LEFT) . '  ' .
                          "\r\n");
        array_push($arr, str_repeat('-', 39).'  '.str_repeat('-', 18).'  '.str_repeat('-', 18). "\r\n");
        array_push($arr, str_pad('Kurang/Belum Setor', 18, ' ', STR_PAD_RIGHT) . ': ' . str_pad('', 19, ' ', STR_PAD_RIGHT) . '  ' .
                         str_pad('    Pengemudi', 18, ' ', STR_PAD_RIGHT) . '  ' . str_pad('     Security', 18, ' ', STR_PAD_RIGHT) . "\r\n");
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

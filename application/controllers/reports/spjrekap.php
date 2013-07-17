<?php

class Spjrekap extends MY_Controller
{
    function __construct() 
    {
        parent::__construct();
        
        $this->load->model('reports/r_reports_m');
    }
    
    function reportRaw($id)
    {
        $startdate = '2001-12-01';
        $enddate = '2013-12-12';
        $r = $this->r_reports_m->spjrekap($this->user->Branch, $startdate, $enddate);
        $arr = array();
        
        $col = array(3,13,5,6,20,11,11,11,11,11,11,11,4,8);
        $arr = $this->headerSans('NEW ATLAS TAXI|LAPORAN SETORAN SPJ TANGGAL ' . date('d-m-Y', strtotime($startdate)) . ' s/d ' . date('d-m-Y', strtotime($enddate)) . ' Hal 1', $arr, true, false, 137);
        array_push($arr, str_pad('No', $col[0], ' ', STR_PAD_LEFT) . ' ' . 
                         str_pad('No SPJ', $col[1], ' ', STR_PAD_RIGHT) . 
                         str_pad('Armd', $col[2], ' ', STR_PAD_RIGHT) . 
                         str_pad('KTA', $col[3], ' ', STR_PAD_RIGHT) .
                         str_pad('Nama Pengemudi', $col[4], ' ', STR_PAD_RIGHT) . 
                         str_pad('Target', $col[5], ' ', STR_PAD_LEFT) .
                         str_pad('OverTime', $col[6], ' ', STR_PAD_LEFT) .
                         str_pad('Cicilan', $col[7], ' ', STR_PAD_LEFT) .
                         str_pad('Potongan', $col[8], ' ', STR_PAD_LEFT) .
                         str_pad('Voucher', $col[9], ' ', STR_PAD_LEFT) .
                         str_pad('Setoran', $col[10], ' ', STR_PAD_LEFT) .
                         str_pad('Kurang', $col[11], ' ', STR_PAD_LEFT) .
                         str_pad('Ket', $col[12], ' ', STR_PAD_LEFT) .
                         str_pad('LAKA', $col[13], ' ', STR_PAD_LEFT) . "\r\n");
        array_push($arr, str_repeat('-', 137) . "\r\n");
        if ($r)
        {
            $no = 1;
            $tt = array('pay'=>0,'ang'=>0,'ovt'=>0,'pot'=>0,'vcr'=>0,'dby'=>0,'ks'=>0,'lak'=>0);
            foreach ($r as $k => $v)
            {
                array_push($arr, str_pad($no, $col[0], ' ', STR_PAD_LEFT) . ' ' . 
                         str_pad($v['T_SpjSetorT_SpjNumber'], $col[1], ' ', STR_PAD_RIGHT) . 
                         str_pad($v['T_SpjSetorM_DriversCode'], $col[2], ' ', STR_PAD_RIGHT) . 
                         str_pad($v['T_SpjSetorM_FleetCode'], $col[3], ' ', STR_PAD_RIGHT) .
                         str_pad($v['M_DriversName'], $col[4], ' ', STR_PAD_RIGHT) . 
                         str_pad(number_format($v['T_SpjSetorPay'],0,',','.'), $col[5], ' ', STR_PAD_LEFT) .
                         str_pad(number_format($v['T_SpjSetorOvertime'],0,',','.'), $col[6], ' ', STR_PAD_LEFT) .
                         str_pad(number_format($v['T_SpjSetorAngsuran'],0,',','.'), $col[7], ' ', STR_PAD_LEFT) .
                         str_pad(number_format($v['T_SpjSetorPotonganLain'],0,',','.'), $col[8], ' ', STR_PAD_LEFT) .
                         str_pad(number_format($v['T_SpjSetorVoucherAmount'],0,',','.'), $col[9], ' ', STR_PAD_LEFT) .
                         str_pad(number_format($v['T_SpjSetorDibayar'],0,',','.'), $col[10], ' ', STR_PAD_LEFT) .
                         str_pad(number_format($v['T_SpjSetorKS'] + $v['T_SpjSetorBS'],0,',','.'), $col[11], ' ', STR_PAD_LEFT) .
                         str_pad('LJT', $col[12], ' ', STR_PAD_LEFT) .
                         str_pad(number_format($v['T_SpjSetorLaka'],0,',','.'), $col[13], ' ', STR_PAD_LEFT) . "\r\n");
                $no++;
                $tt['pay'] += $v['T_SpjSetorPay'];
                $tt['ovt'] += $v['T_SpjSetorOvertime'];
                $tt['ang'] += $v['T_SpjSetorAngsuran'];
                $tt['pot'] += $v['T_SpjSetorPotonganLain'];
                $tt['vcr'] += $v['T_SpjSetorVoucherAmount'];
                $tt['dby'] += $v['T_SpjSetorDibayar'];
                $tt['ks'] += $v['T_SpjSetorKS'];
                $tt['lak'] += $v['T_SpjSetorLaka'];
            }
        }
        else
        {
            $str = 'Tidak Ada Data';
            array_push($arr, str_pad(str_repeat(' ', floor((137 - strlen($str))/2) ) . $str, 137));
        }
        array_push($arr, str_repeat('-', 137) . "\r\n");
        array_push($arr, str_pad('Jumlah Total', $col[0] + $col[1] + $col[2] + $col[3] + $col[4], ' ', STR_PAD_RIGHT) . ' ' .
                         str_pad(number_format($tt['pay'],0,',','.'), $col[5], ' ', STR_PAD_LEFT) . 
                         str_pad(number_format($tt['ovt'],0,',','.'), $col[6], ' ', STR_PAD_LEFT) . 
                         str_pad(number_format($tt['ang'],0,',','.'), $col[7], ' ', STR_PAD_LEFT) . 
                         str_pad(number_format($tt['pot'],0,',','.'), $col[8], ' ', STR_PAD_LEFT) .
                         str_pad(number_format($tt['vcr'],0,',','.'), $col[9], ' ', STR_PAD_LEFT) .
                         str_pad(number_format($tt['dby'],0,',','.'), $col[10], ' ', STR_PAD_LEFT) .
                         str_pad(number_format($tt['ks'],0,',','.'), $col[11], ' ', STR_PAD_LEFT) .
                         str_pad('', $col[12], ' ', STR_PAD_LEFT) . 
                         str_pad(number_format($tt['lak'],0,',','.'), $col[13], ' ', STR_PAD_LEFT) . "\r\n");
        array_push($arr, str_repeat('=', 137) . "\r\n");
        array_push($arr, str_pad('Dicetak Tanggal/Waktu : ' . date('d-m-Y H:i:s'), 137, ' ', STR_PAD_RIGHT) . "\r\n");
        
        // I
        array_push($arr, "\r\n\r\n");
        array_push($arr, str_pad('I.   OPERASIONAL ARMADA TANGGAL : ' . date('d-m-Y', strtotime($startdate)) . ' s/d ' . date('d-m-Y', strtotime($enddate)), 71, ' ', STR_PAD_RIGHT) . "\r\n");
        array_push($arr, str_repeat('=', 73) . "\r\n");
        
        array_push($arr, str_pad('Jumlah Armada Jalan', 29, ' ', STR_PAD_RIGHT) . '= ' . str_pad('2', 5, ' ', STR_PAD_LEFT) . '       ' . str_pad('Armada Batal Jalan', 23, ' ', STR_PAD_RIGHT) . '= ' . str_pad('0', 5, ' ', STR_PAD_LEFT) . "\r\n");
        array_push($arr, str_pad('Jumlah Armada Lanjut Jalan', 29, ' ', STR_PAD_RIGHT) . '= ' . str_pad('2', 5, ' ', STR_PAD_LEFT) . '       ' . str_pad('Armada Belum Masuk', 23, ' ', STR_PAD_RIGHT) . '= ' . str_pad('0', 5, ' ', STR_PAD_LEFT) . "\r\n");
        array_push($arr, str_pad('Jumlah Armada Tidak Jalan', 29, ' ', STR_PAD_RIGHT) . '= ' . str_pad('2', 5, ' ', STR_PAD_LEFT) . '       ' . str_pad('Armada Lunas Setoran', 23, ' ', STR_PAD_RIGHT) . '= ' . str_pad('0', 5, ' ', STR_PAD_LEFT) . "\r\n");
        array_push($arr, str_pad('', 29, ' ', STR_PAD_RIGHT) . '  ' . str_pad('-----', 5, ' ', STR_PAD_LEFT) . '-+     ' . str_pad('Armada Kurang Setoran', 23, ' ', STR_PAD_RIGHT) . '= ' . str_pad('0', 5, ' ', STR_PAD_LEFT) . "\r\n");
        array_push($arr, str_pad('Jumlah Armada', 29, ' ', STR_PAD_RIGHT) . '= ' . str_pad('2', 5, ' ', STR_PAD_LEFT) . '       ' . str_pad('Armada Belum Setoran', 23, ' ', STR_PAD_RIGHT) . '= ' . str_pad('0', 5, ' ', STR_PAD_LEFT) . "\r\n");
        
        //II
        $col = array(24,4,11,11,11,11);
        array_push($arr, "\r\n\r\n");
        array_push($arr, str_pad('II. PENERIMAAN KAS SETORAN TANGGAL : ' . date('d-m-Y', strtotime($startdate)) . ' s/d ' . date('d-m-Y', strtotime($enddate)), 71, ' ', STR_PAD_RIGHT) . "\r\n");
        array_push($arr, str_repeat('=', 73) . "\r\n");
        array_push($arr, str_pad('Tanggal', $col[0], ' ', STR_PAD_RIGHT) . ' ' . 
                         str_pad('Armd', $col[1], ' ', STR_PAD_RIGHT) . 
                         str_pad('Overtime', $col[2], ' ', STR_PAD_LEFT) . 
                         str_pad('Cicilan', $col[3], ' ', STR_PAD_LEFT) .
                         str_pad('Setoran', $col[4], ' ', STR_PAD_LEFT) . 
                         str_pad('Diterima', $col[5], ' ', STR_PAD_LEFT) . "\r\n");
        array_push($arr, str_repeat('-', 73) . "\r\n");
        array_push($arr, str_pad('2012-12-12', $col[0], ' ', STR_PAD_RIGHT) . ' ' . 
                         str_pad('2', $col[1], ' ', STR_PAD_LEFT) . 
                         str_pad(number_format(30000,0,',','.'), $col[2], ' ', STR_PAD_LEFT) . 
                         str_pad(number_format(30000,0,',','.'), $col[3], ' ', STR_PAD_LEFT) .
                         str_pad(number_format(230000,0,',','.'), $col[4], ' ', STR_PAD_LEFT) . 
                         str_pad(number_format(230000,0,',','.'), $col[5], ' ', STR_PAD_LEFT) . "\r\n");
        array_push($arr, str_repeat('-', 73) . "\r\n");
        array_push($arr, str_pad('Jumlah', $col[0], ' ', STR_PAD_RIGHT) . ' ' . 
                         str_pad('2', $col[1], ' ', STR_PAD_LEFT) . 
                         str_pad(number_format(30000,0,',','.'), $col[2], ' ', STR_PAD_LEFT) . 
                         str_pad(number_format(30000,0,',','.'), $col[3], ' ', STR_PAD_LEFT) .
                         str_pad(number_format(230000,0,',','.'), $col[4], ' ', STR_PAD_LEFT) . 
                         str_pad(number_format(230000,0,',','.'), $col[5], ' ', STR_PAD_LEFT) . "\r\n");
        
        
        // III
        $col = array(3,13,5,5,33,11,11,11,11,11,11,11);
        array_push($arr, "\r\n\r\n");
        array_push($arr, str_pad('III.POTONGAN SETORAN TANGGAL : ' . date('d-m-Y', strtotime($startdate)) . ' s/d ' . date('d-m-Y', strtotime($enddate)), 71, ' ', STR_PAD_RIGHT) . "\r\n");
        array_push($arr, str_repeat('=', 137) . "\r\n");
        array_push($arr, str_pad('No', $col[0], ' ', STR_PAD_LEFT) . ' ' . 
                         str_pad('No SPJ', $col[1], ' ', STR_PAD_RIGHT) . 
                         str_pad('Armd', $col[2], ' ', STR_PAD_RIGHT) . 
                         str_pad('KTA', $col[3], ' ', STR_PAD_RIGHT) .
                         str_pad('Nama Pengemudi', $col[4], ' ', STR_PAD_RIGHT) . 
                         str_pad('Tgl OPS', $col[5], ' ', STR_PAD_RIGHT) . 
                         str_pad('Target', $col[6], ' ', STR_PAD_LEFT) . 
                         str_pad('Overtime', $col[6], ' ', STR_PAD_LEFT) . 
                         str_pad('Cicilan', $col[6], ' ', STR_PAD_LEFT) . 
                         str_pad('Potongan', $col[6], ' ', STR_PAD_LEFT) .
                         str_pad('Setoran', $col[6], ' ', STR_PAD_LEFT) . 
                         str_pad('Kurang', $col[6], ' ', STR_PAD_LEFT) . "\r\n");
        array_push($arr, str_repeat('-', 137) . "\r\n");
        array_push($arr, str_pad('113', $col[0], ' ', STR_PAD_LEFT) . ' ' . 
                         str_pad('011307070001', $col[1], ' ', STR_PAD_RIGHT) . 
                         str_pad('C06', $col[2], ' ', STR_PAD_RIGHT) .
                         str_pad('A067', $col[3], ' ', STR_PAD_RIGHT) .
                         str_pad('A. Hartono', $col[4], ' ', STR_PAD_RIGHT) .
                         str_pad('2013-07-07', $col[5], ' ', STR_PAD_RIGHT) .
                         str_pad(number_format(30000,0,',','.'), $col[6], ' ', STR_PAD_LEFT) . 
                         str_pad(number_format(30000,0,',','.'), $col[7], ' ', STR_PAD_LEFT) .
                         str_pad(number_format(230000,0,',','.'), $col[8], ' ', STR_PAD_LEFT) . 
                         str_pad(number_format(230000,0,',','.'), $col[9], ' ', STR_PAD_LEFT) . 
                         str_pad(number_format(230000,0,',','.'), $col[10], ' ', STR_PAD_LEFT) . 
                         str_pad(number_format(230000,0,',','.'), $col[11], ' ', STR_PAD_LEFT) . "\r\n");
        array_push($arr, str_repeat('-', 137) . "\r\n");
        array_push($arr, str_pad('Jumlah Total', $col[0] + $col[1] + $col[2] + $col[3] + $col[4] + $col[5], ' ', STR_PAD_RIGHT) . ' ' .
                         str_pad(number_format(30000,0,',','.'), $col[6], ' ', STR_PAD_LEFT) . 
                         str_pad(number_format(30000,0,',','.'), $col[7], ' ', STR_PAD_LEFT) .
                         str_pad(number_format(230000,0,',','.'), $col[8], ' ', STR_PAD_LEFT) . 
                         str_pad(number_format(230000,0,',','.'), $col[9], ' ', STR_PAD_LEFT) . 
                         str_pad(number_format(230000,0,',','.'), $col[10], ' ', STR_PAD_LEFT) . 
                         str_pad(number_format(230000,0,',','.'), $col[11], ' ', STR_PAD_LEFT) . "\r\n");
        
        // IV
        array_push($arr, "\r\n\r\n");
        array_push($arr, str_pad('IV. PENERIMAAN PEMBAYARAN KS/BS TANGGAL : ' . date('d-m-Y', strtotime($startdate)) . ' s/d ' . date('d-m-Y', strtotime($enddate)), 71, ' ', STR_PAD_RIGHT) . "\r\n");
        array_push($arr, str_repeat('=', 73) . "\r\n");
        array_push($arr, str_pad('Pembayaran KS dari', 20, ' ', STR_PAD_RIGHT) . str_pad(1,4,' ',STR_PAD_LEFT) . ' Driver = ' . str_pad(number_format(28000,0,',','.'), 10, ' ', STR_PAD_LEFT) . "\r\n");
        array_push($arr, str_pad('Pembayaran BS dari', 20, ' ', STR_PAD_RIGHT) . str_pad(1,4,' ',STR_PAD_LEFT) . ' Driver = ' . str_pad(number_format(300000,0,',','.'), 10, ' ', STR_PAD_LEFT) . "\r\n");
        array_push($arr, str_pad('', 34, ' ', STR_PAD_RIGHT) . '  ' . str_pad('--------+', 5, ' ', STR_PAD_LEFT) . "\r\n");
        array_push($arr, str_pad('Jumlah', 34, ' ', STR_PAD_RIGHT) . str_pad(number_format(328000,0,',','.'), 10, ' ', STR_PAD_LEFT) . "\r\n");
        return $arr;
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

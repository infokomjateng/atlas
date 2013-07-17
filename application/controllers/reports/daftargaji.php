<?php

class Daftargaji extends MY_Controller
{
    function index()
    {
        $dt['extrajs'] = array('r_daftargaji');
        $dt['secnav'] = $this->load->view('main/secnav', array('form'=>$this->form()), true);
        $this->load->view('pages/reports', $dt);
    }
    
    function form()
    {
        $this->load->model(array('masterdata/m_divisi_m','absensi/a_absensi_m'));
        $dvsi_list = $this->m_divisi_m->get_key_value('M_DivisiCode', 'M_DivisiName');
        $thun_list = $this->a_absensi_m->get_tahun();
        
        $dvsi_list[''] = 'SEMUA';
        
        $form = array(
            array(
                'title' => 'Data Pribadi',
                'col0' => array(
                    array('label'=>'Divisi','field'=>  form_dropdown('A_HitungGajiM_DivisiCode', $dvsi_list, '', 'class=select')),
                    array('label'=>'Tahun','field'=>  form_dropdown('A_HitungGajiTahun', $thun_list, '', 'class=select')),
                    array('label'=>'Bulan','field'=>  form_dropdown('A_HitungGajiBulan', array(), '', 'class=select'))
                )
            )
        );        
        return $form;
    }
    
    function load_report()
    {
        $url = base_url() . "reports/daftargaji/report/{$this->input->post('A_HitungGajiTahun')}/{$this->input->post('A_HitungGajiBulan')}/{$this->input->post('A_HitungGajiM_DivisiCode')}";
        echo $url;
        /*echo <<<EOF
            <div>
            <object data="{$url}" type="application/pdf" width="100%" height="600">
            alt : <a href="test.pdf">test.pdf</a>
            </object>
            </div>
EOF;
        return;*/
    }
    
    function header_starterkit($pdf)
    {
                //columns
                return parent::header_starterkit($pdf, 'DATA GAJI KARYAWAN');
	}
	function footer_starterkit($pdf)
        {
		return parent::footer_starterkit($pdf);
	}
	function tbl_header($pdf)
        {
		return parent::tbl_header($pdf, array(
                    array('column' => 'NIK', 'width' => 30, 'align' => 'L'),
                    array('column' => 'NAMA KARYAWAN', 'width' => 100, 'align' => 'L'),
                    array('column' => 'JABATAN', 'width' => 30, 'align' => 'L'),
                    array('column' => 'GAJI POKOK', 'width' => 30, 'align' => 'L')
                ));
	}
	public function report($tahun, $bulan, $code = '') 
        {
            $this->load->library('pdf');
            $this->pdf->rptclass = "Daftargaji";
            $this->pdf->header_func = "header_starterkit";
            $this->pdf->footer_func = "footer_starterkit";
            $this->pdf->AddPage();

            //sub title
            /*$m = $this->member_m->get($id);
            $this->pdf->SetFontSize(12);
            $this->pdf->cell(190,5,"Periode Tanggal {$sd} sampai {$ed}",'',0,'C');
            $this->pdf->ln(5);
            $this->pdf->cell(190,5,"Member : {$m->MemberName}",'',0,'C');
            $this->pdf->ln(10);*/

            $this->load->model('reports/r_reports_m');
            $rst = $this->r_reports_m->daftargaji($tahun, $bulan, $code);
            
            $this->tbl_header($this->pdf);
            foreach($rst as $r => $v) {

                    $data = array($v['M_KaryawanNIK'], $v['M_KaryawanName'], $v['A_HitungGajiPayment'] , $v["M_KaryawanPosition"] );
                    $this->pdf->row($data);
            }			

            $this->pdf->Output();		
	}
}
?>

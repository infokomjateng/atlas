<?php

class Karyawanasuransi extends MY_Controller
{
    function index()
    {
        $dt['extrajs'] = array('r_karyawanasuransi');
        $dt['secnav'] = $this->load->view('main/secnav', array('form'=>$this->form()), true);
        $this->load->view('pages/reports', $dt);
    }
    
    function form()
    {
        $this->load->model(array('masterdata/m_divisi_m','masterdata/m_asuransi_m'));
        $asrn_list = $this->m_asuransi_m->get_key_value('M_AsuransiCode', 'M_AsuransiName');
        $asrn_list[''] = 'SEMUA';
        
        $form = array(
            array(
                'title' => 'Data Pribadi',
                'col0' => array(
                    array('label'=>'Jenis Asuransi','field'=>  form_dropdown('M_KaryawanM_AsuransiCode', $asrn_list, '', 'class=select'))
                )
            )
        );        
        return $form;
    }
    
    function load_report()
    {
        $url = base_url() . "reports/karyawanasuransi/report/{$this->input->post('M_KaryawanM_AsuransiCode')}";
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
                return parent::header_starterkit($pdf, 'DATA KARYAWAN BERDASARKAN JENIS ASURANSI');
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
                    array('column' => 'STATUS', 'width' => 30, 'align' => 'L'),
                    array('column' => 'ASURANSI', 'width' => 30, 'align' => 'L')
                ));
	}
	public function report($code = '') 
        {
            $this->load->library('pdf');
            $this->pdf->rptclass = "Karyawanasuransi";
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
            $rst = $this->r_reports_m->karyawanasuransi($code);
            
            $this->tbl_header($this->pdf);
            foreach($rst as $r => $v) {

                    $data = array($v['M_KaryawanNIK'], $v['M_KaryawanName'], $v['M_KaryawanStatus'] , $v["M_KaryawanAsuransi"] );
                    $this->pdf->row($data);
            }			

            $this->pdf->Output();		
	}
}
?>

<?php

class Payment extends MY_Controller
{
    function __construct() 
    {
        parent::__construct();
        
        $this->load->model(array('spj/t_payment_m', 'masterdata/m_drivers_m', 'log/l_paylog_m'));
    }
    
    function index()
    {
        $data['extrajs'] = array('t_payment','printer');
        
        //table parameter
        $tblprm = array(
            'id'        => 'dynamic',
            'source'    => base_url() . 'spj/payment/listing',
            'columns'   => array('M_DriversCode', 'M_DriversName', 'M_DriversAddress', 'M_DriversKSBS'),
            'titles'    => array('Kode', 'Nama', 'Alamat', 'Total KS & BS'),
            'tabletitle'=> 'Daftar Driver',
            
            //total column widths = 75%
            //the rest 25% has been used for the Action button
            'widths'    => array('5', '20', '30', '10'),
            
            //now, we're adding edit button
            //write the button action prefix here
            //'edit'      => 't_payment_',
            //'delete'    => 't_payment_',
            'action_width'  => '22',
            'action_title'  => 'Pembayaran',
            'custombtn'     => array(
                array('text'=>'K S','click'=>'t_payment_ks(this)','class'=>'bLightBlue mr3'),
                array('text'=>'B S','click'=>'t_payment_bs(this)','class'=>'bBlue mr3'),
                array('text'=>'Cicilan','click'=>'t_payment_cicilan(this)','class'=>'bGreen')
            ),
            'dLength'       => 1,
            'fnInitComplete' => "$('.whead').find('.buttonS').remove()"
        );
        
        $data['content'] = $this->load->view('parts/dataTable', $tblprm, true);
        $data['formCRUD'] = '&nbsp;';
        $this->load->view('pages/tableOnlyApplet', $data);
    }
    
    function form($type, $id)
    {
        $this->load->model(array('masterdata/m_drivers_m'));
        
        if ($type == 'ks')
        {
            $r = $this->m_drivers_m->get($id);
            $form = array(
                array(
                    'title' => 'Data Pribadi',
                    'col0' => array(
                        array('label'=>'No Bukti','field'=>  form_input('L_PayLogNumber', '', 'readonly=readonly autocomplete=off') .
                                                            form_hidden('L_PayLogType', 'KS')),
                        array('label'=>'No KTA','field'=>  form_input('L_PayLogM_DriversCode', $r->M_DriversCode, 'readonly=readonly autocomplete=off')),
                        array('label'=>'Jumlah KS','field'=>  form_input('M_DriversKS', $r->M_DriversKS, 'disabled=disabled autocomplete=off class=rtl-inputz')),
                        array('label'=>'Jumlah Bayar','field'=>  form_input('L_PayLogAmount', '', 'autocomplete=off class="rtl-inputz maskNum"'))
                    )
                )
            );
        }
        else if ($type == 'bs')
        {
            $r = $this->m_drivers_m->get($id);
            $form = array(
                array(
                    'title' => 'Data Pribadi',
                    'col0' => array(
                        array('label'=>'No Bukti','field'=>  form_input('L_PayLogNumber', '', 'readonly=readonly autocomplete=off') .
                                                            form_hidden('L_PayLogType', 'BS')),
                        array('label'=>'No KTA','field'=>  form_input('L_PayLogM_DriversCode', $r->M_DriversCode, 'readonly=readonly autocomplete=off')),
                        array('label'=>'Jumlah BS','field'=>  form_input('M_DriversKS', $r->M_DriversBS, 'disabled=disabled autocomplete=off class=rtl-inputz')),
                        array('label'=>'Jumlah Bayar','field'=>  form_input('L_PayLogAmount', '', 'autocomplete=off class="rtl-inputz maskNum"')),
                        array('label'=>'Jumlah Potongan','field'=>  form_input('L_PayLogDiscount', '', 'autocomplete=off class="rtl-inputz maskNum"'))
                    )
                )
            );
        }
        else if ($type == 'cicilan')
        {
            $this->db->select('IFNULL(M_DriversDebtAmount, 0) as M_DriversDebtAmount, IFNULL(M_DriversDebtPaid, 0) as M_DriversDebtPaid, M_DriversCode', false)
                    ->join('(select M_DriversDebtM_DriversCode, M_DriversDebtAmount, M_DriversDebtPaid from m_driversdebt where M_DriversDebtIsActive="Y" AND M_DriversDebtIsComplete=0) a', 
                            'M_DriversDebtM_DriversCode = M_DriversCode', 'left');
            $r = $this->m_drivers_m->ori_get($id);
            $form = array(
                array(
                    'title' => 'Data Pribadi',
                    'col0' => array(
                        array('label'=>'No Bukti','field'=>  form_input('L_PayLogNumber', '', 'readonly=readonly autocomplete=off') .
                                                            form_hidden('L_PayLogType', 'CC')),
                        array('label'=>'No KTA','field'=>  form_input('L_PayLogM_DriversCode', $r->M_DriversCode, 'readonly=readonly autocomplete=off')),
                        array('label'=>'Jumlah Tanggungan','field'=>  form_input('M_DriversDebtAmount', $r->M_DriversDebtAmount, 'disabled=disabled autocomplete=off class=rtl-inputz')),
                        array('label'=>'Telah Dibayar','field'=>  form_input('M_DriversDebtPaid', $r->M_DriversDebtPaid, 'disabled=disabled autocomplete=off class=rtl-inputz')),
                        array('label'=>'Jumlah Bayar','field'=>  form_input('L_PayLogAmount', '', 'autocomplete=off class="rtl-inputz maskNum"'))
                    )
                )
            );
        }
        echo $this->load->view('parts/formCRUD', array('form'=>$form,'formname'=>'formpayment','submit'=>array('button'=>'t_spj_save()')), true);
        
        return true;
    }
    
    function listing()
    {
        //getting param data
        list($tot_rec,$tot_disp_rec,$r) = $this->t_payment_m->listing($this->input,
			array("M_DriversName") );
        
        $output = array(
            'sEcho' => $this->input->get("sEcho"),
            'iTotalRecords' => $tot_rec,
            'iTotalDisplayRecords' => $tot_disp_rec,
            'aaData' => $r
        );
        
        echo json_encode($output);
    }
    
    function save($id)
    {
        $i = $this->input->post();
        $i['L_PayLogUserID'] = $this->user->UserID;
        $i['L_PayLogDate'] = date('Y-m-d');
        $i['L_PayLogO_BranchCode'] = $this->user->Branch;
        
        $tp = $i['L_PayLogType'];
        
        if ($tp == 'KS')
        {
            if (!$this->save_ks_validate())
            {
                echo json_encode(array('err'=>$this->form_validation->error_array(),'msg'=>  validation_errors()));
                exit;
            }
            $r = $this->l_paylog_m->save($i);
        }
        else if ($tp == 'BS')
        {
            if (!$this->save_bs_validate())
            {
                echo json_encode(array('err'=>$this->form_validation->error_array(),'msg'=>  validation_errors()));
                exit;
            }
            $r = $this->l_paylog_m->save($i);
        }
        else if ($tp == 'CC')
        {
            if (!$this->save_cicilan_validate())
            {
                echo json_encode(array('err'=>$this->form_validation->error_array(),'msg'=>  validation_errors()));
                exit;
            }
            $r = $this->l_paylog_m->save($i);
        }
        
        if (!$r)
        {
            echo json_encode(array('err'=>'Error tenan','msg'=>'Error pancene'));
        }
        else
        {
            echo json_encode(array('rst'=>$r,'msg'=>'Data SPJ berhasil disimpan'));
            return;
        }
    }
    
    function save_ks_validate()
    {
        $this->form_validation->set_rules('L_PayLogAmount', 'Jumlah Bayar', 'required|numeric');
        return $this->form_validation->run();
    }
    
    function save_bs_validate()
    {
        $this->form_validation->set_rules('L_PayLogAmount', 'Jumlah Bayar', 'required|numeric');
        return $this->form_validation->run();
    }
    
    function save_cicilan_validate()
    {
        $this->form_validation->set_rules('L_PayLogAmount', 'Jumlah Bayar', 'required|numeric');
        return $this->form_validation->run();
    }
    
    /*function delete()
    {
        $i = $this->input->post();
        $i['DriversUserID'] = $this->user->UserID;
        $i['DriversLastUpdate'] = date('Y-m-d H:i:s');
        $i['DriversIsActive'] = 'N';
        $r = $this->drivers_m->save($i, $i['DriversID']);
        echo json_encode(array('rst'=>$r,'msg'=>'Data driver berhasil dihapus'));
        return;
    }
    
    function check_drivers ($str)
    {
        $this->load->model(array('masterdata/m_drivers_m'));
        $r = $this->m_drivers_m->get_by_code($str);
        if ($r == false)
        {
            $this->form_validation->set_message('check_drivers', 'Kode Driver tersebut ( %s ) tidak diketemukan / telah diblokir');
            return false;
        }
        
        $r = $this->t_spj_m->get_available ($str);
        if ($r)
        {
            $this->form_validation->set_message('check_drivers', 'Kode Driver tersebut ( %s ) telah melakukan SPJ, dan belum melakukan setoran');
            return false;
        }
        
        return true;
    }
    
    function check_ks ($str)
    {
        if ($str == '')
        {
            $this->form_validation->set_message('check_ks', 'Jumlah KS / BS tidak sesuai, silahkan cek kembali');
            return false;
        }
        
        if ($str < $this->input->post('TotalKSBS'))
        {
            $this->form_validation->set_message('check_ks', 'Jumlah KS / BS Driver ( %s ) telah melampaui limit');
            return false;
        }
        
        return true;
    }
    
    function get_info ()
    {
        $r = $this->t_spj_m->get_info($this->input->get('id'));
        if ($r)
        {
            echo json_encode ($r);
            return true;
        }
        
        return false;
    }*/
}
?>

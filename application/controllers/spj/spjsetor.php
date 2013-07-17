<?php

class Spjsetor extends MY_Controller
{
    function __construct() 
    {
        parent::__construct();
        
        $this->load->model('spj/t_spjsetor_m');
    }
    
    function index()
    {
        $data['extrajs'] = array('t_spjsetor','printer');
        $data['extrabasicjs'] = array('others/html2canvas', 'others/jquery.plugin.html2canvas');
        
        //table parameter
        $tblprm = array(
            'id'        => 'dynamic',
            'source'    => base_url() . 'spj/spjsetor/listing',
            'columns'   => array('T_SpjNumber', 'M_DriversCode', 'M_DriversName', 'T_SpjDateTime', 'T_SpjSetorDateTime'),
            'titles'    => array('Nomor SPJ', 'Kode Driver', 'Nama Driver', 'Tanggal SPJ', 'Tanggal Setor'),
            
            //total column widths = 75%
            //the rest 25% has been used for the Action button
            'widths'    => array('10', '5', '50', '10', '10'),
            
            //now, we're adding edit button
            //write the button action prefix here
            'edit'      => 't_spjsetor_',
            'delete'    => 't_spjsetor_',
            'dLength'   => 1
        );
        
        $data['content'] = $this->load->view('parts/dataTable', $tblprm, true);
        $data['formCRUD'] = $this->form('new');
        $this->load->view('pages/crudOnly', $data);
    }
    
    function form($id)
    {
        $this->load->model(array('office/o_branch_m', 'masterdata/m_voucher_m'));
        
        $brch_list = $this->o_branch_m->get_key_value('O_BranchID', 'O_BranchName');
        $vocr_list = $this->m_voucher_m->get_key_value('M_VoucherCode', 'M_VoucherName');
        
        if ($id == 'new')
        {
            $form = array(
                array(
                    'title' => 'Data Pribadi',
                    'col0' => array(
                        array('label'=>'Kode','field'=>  form_input('T_SpjSetorM_DriversCode', '', 'autocomplete=off') . form_hidden('T_SpjID', '')),
                        array('label'=>'Nama','field'=>  form_input('M_DriversName', '', 'disabled=disabled autocomplete=off'))
                    ),
                    'col1' => array(
                        array('label'=>'Nomor SPJ','field'=>  form_input('T_SpjSetorT_SpjNumber', '', 'autocomplete=off readonly=readonly')),
                        array('label'=>'Armada','field'=>  form_input('T_SpjSetorM_FleetCode', '', 'readonly=readonly autocomplete=off'))
                    )
                ),
                array(
                    'title' => 'Data SPJ',
                    'col0' => array(
                        array('label'=>'Tanggal SPJ','field'=>  form_input('T_SpjDate', '', 'autocomplete=off class=datepicker disabled=disabled')),
                        array('label'=>'Jam','field'=>  form_input('T_SpjTime', '', 'disabled=disabled autocomplete=off class=time')),
                        array('label'=>'KM Berangkat','field'=>  form_input('T_SpjStartKM', '', 'disabled=disabled autocomplete=off class="km"'))
                    ),
                    'col1' => array(
                        array('label'=>'Tanggal Merapat','field'=>  form_input('T_SpjSetorDate', date('d-m-Y'), 'autocomplete=off class=datepicker readonly=readonly')),
                        array('label'=>'Jam','field'=>  form_input('T_SpjSetorTime', date('H:i'), 'readonly=readonly autocomplete=off class=time')),
                        array('label'=>'KM Kembali','field'=>  form_input('T_SpjSetorEndKM', '', 'autocomplete=off class="km maskNum"'))
                    )
                ),
                array(
                    'title' => 'Data Setoran',
                    'col0' => array(
                        array('label'=>'Jumlah Setoran','field'=>  form_input('T_SpjSetorPay', '0', 'class="rtl-inputz maskNum" autocomplete=off readonly=readonly')),
                        array('label'=>'Overtime','field'=>  form_input('T_SpjSetorOvertime', '0', 'class="rtl-inputz maskNum" autocomplete=off readonly=readonly')),
                        array('label'=>'Cicilan / Angsuran','field'=> form_input('T_SpjSetorAngsuran', '0', 'class="rtl-inputz maskNum" autocomplete=off readonly=readonly')),
                        array('label'=>'Cicilan / Angsuran','field'=> form_input('T_SpjSetorLaka', '3000', 'class="rtl-inputz maskNum" autocomplete=off readonly=readonly')),
                        array('label'=>'Potongan Jam','field'=> form_input('T_SpjSetorPotonganJam', '0', 'class="rtl-inputz maskNumMin" autocomplete=off')),
                        array('label'=>'Potongan Lain - lain','field'=> form_input('T_SpjSetorPotonganLain', '0', 'class="rtl-inputz maskNumMin" autocomplete=off'),
                                'note'=>form_input('T_SpjSetorPotonganLainNote', '', 'autocomplete=off style="width:30%"') . '<span class="note">Tuliskan keterangan potongan</span>')                        
                    ),
                    'col1' => array(
                        array('label'=>'Jumlah Disetor','field'=> form_input('T_SpjSetorTotal', '0', 'class="rtl-inputz maskNum" autocomplete=off readonly=readonly')),
                        array('label'=>'Jumlah Voucher','field'=> form_input('T_SpjSetorVoucherAmount', '0', 'class="rtl-inputz maskNum" autocomplete=off')),
                        array('label'=>'Jenis Voucher','field'=> '<div class=grid5>' . form_dropdown('T_SpjSetorM_VoucherCode', $vocr_list, '', 'class=select style=width:100%') . '</div>'),
                        array('label'=>'Kode Voucher','field'=> '<div class=grid5>' . form_input('T_SpjSetorVoucherCode', '', 'autocomplete=off') . '</div>'),
                        array('label'=>'Dibayar','field'=> form_input('T_SpjSetorDibayar', '0', 'class="rtl-inputz maskNum" autocomplete=off')),
                        array('label'=>'Kurang Setor','field'=>  form_input('T_SpjSetorKS', '0', 'class="rtl-inputz maskNum" autocomplete=off readonly=readonly'))
                    )
                )
            );
        }
        else
        {
            $d = $this->m_drivers_m->get($id);
            
            $form = array(
                array(
                    'title' => 'Data Pribadi',
                    'col0' => array(
                        array('label'=>'Nama','field'=>  form_input('M_DriversName', $d->DriversName) .
                            form_hidden('DriversID', $d->DriversID)),
                        array('label'=>'Alamat','field'=>  form_input('DriversAddress', $d->DriversAddress))
                    ),
                    'col1' => array(
                        array('label'=>'Tanggal Lahir','field'=>  form_input('DriversDOB', date('d-m-Y', strtotime($d->DriversDOB)), 'class=datepicker')),
                        array('label'=>'Tempat Lahir','field'=>  form_input('DriversPOB', $d->DriversPOB))
                    )
                ),
                array(
                    'title' => 'Data Pekerjaan',
                    'col0' => array(
                        array('label'=>'Kode (KTA)','field'=>  form_input('DriversCode', $d->DriversCode, '')),
                        array('label'=>'Cabang','field'=>  form_dropdown('DriversBranchID', $brch_list, $d->DriversBranchID, 'class=\'select grid8\' style=\'\'')),
                        array('label'=>'Tanggal Mulai Kerja','field'=>  form_input('DriversWorkDate', date('d-m-Y', strtotime($d->DriversWorkDate)), 'class=datepicker')),
                        array('label'=>'Limit KS','field'=>  form_input('DriversKSLimit', $d->DriversKSLimit, ''))
                    ),
                    'col1' => array(
                        array('label'=>'Jenis SIM','field'=> form_dropdown('DriversSIMType', $sims_list, $d->DriversSIMType, 'class=\'select grid8\'')),
                        array('label'=>'Tanggal Exp SIM','field'=>  form_input('DriversSIMDate', date('d-m-Y', strtotime($d->DriversSIMDate)), 'class=datepicker')),
                        array('label'=>'Blokir ?','field'=> form_checkbox('DriversIsBlocked', '1', $d->DriversIsBlocked == 1 ? true : false)),
                        array('label'=>'Catatan Blokir)','field'=> form_input('DriversBlockedNote', $d->DriversBlockedNote, ''))
                    )
                )
            );
        }
        return $this->load->view('parts/formCRUDSpj', array('form'=>$form,'formname'=>'formspjsetor','submit'=>array('button'=>'t_spjsetor_save()')), true);
        
        return true;
    }
    
    function listing()
    {
        //getting param data
        list($tot_rec,$tot_disp_rec,$r) = $this->t_spjsetor_m->listing($this->input,
			array("DriversName") );
        
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
        $i['T_SpjSetorUserID'] = $this->user->UserID;
        
        //pada saat penyimpanan, data DATE diubah formatnya menjadi Y-m-d
        $i['T_SpjSetorDate'] = date('Y-m-d', strtotime($i['T_SpjSetorDate']));
        $i['T_SpjSetorDateTime'] = date('Y-m-d H:i:s', strtotime($i['T_SpjSetorDate'] . ' ' . $i['T_SpjSetorTime']));
        $i['T_SpjSetorT_SpjID'] = $i['T_SpjID'];
        $i['T_SpjSetorO_BranchCode'] = $this->user->Branch;
        unset($i['T_SpjID']);
        
        if ($id == 'new')
        {
            if (!$this->save_validate())
            {
                echo json_encode(array('err'=>$this->form_validation->error_array(),'msg'=>  validation_errors()));
                exit;
            }
            $r = $this->t_spjsetor_m->save($i);
        }
        else
        {
            if (!$this->edit_validate())
            {
                echo json_encode(array('err'=>$this->form_validation->error_array(),'msg'=>  validation_errors()));
                exit;
            }
            $r = $this->t_spjsetor_m->save($i, $id);
        }
        
        if (!$r)
        {
            echo json_encode(array('err'=>'Error tenan','msg'=>'Error pancene'));
        }
        else
        {
            echo json_encode(array('rst'=>$r,'msg'=>'Data driver berhasil disimpan'));
            return;
        }
    }
    
    function save_validate()
    {
        return true;
        $this->form_validation->set_rules('DriversName', 'Nama Driver', 'required');
        return $this->form_validation->run();
    }
    
    function edit_validate()
    {
        $this->form_validation->set_rules('DriversName', 'Nama Driver', 'required');
        return $this->form_validation->run();
    }
    
    function delete()
    {
        $i = $this->input->post();
        $i['DriversUserID'] = $this->user->UserID;
        $i['DriversLastUpdate'] = date('Y-m-d H:i:s');
        $i['DriversIsActive'] = 'N';
        $r = $this->drivers_m->save($i, $i['DriversID']);
        echo json_encode(array('rst'=>$r,'msg'=>'Data driver berhasil dihapus'));
        return;
    }
    
    function get_drivers_available ()
    {
        $r = $this->t_spjsetor_m->get_drivers_available($this->input->get('term'));
        if ($r)
            echo json_encode($r);
        
        return false;
    }
}
?>

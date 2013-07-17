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
        $data['extrajs'] = array('t_spj','printer');
        $data['extrabasicjs'] = array('others/html2canvas', 'others/jquery.plugin.html2canvas');
        
        //table parameter
        $tblprm = array(
            'id'        => 'dynamic',
            'source'    => base_url() . 'spj/spj/listing',
            'columns'   => array('T_SpjNumber', 'T_SpjDate', 'T_SpjTime', 'M_DriversCode', 'T_SpjM_FleetCode', 'M_DriversName'),
            'titles'    => array('No SPJ', 'Tanggal', 'Waktu', 'Kode Driver', 'Kode Armada', 'Nama Driver'),
            
            //total column widths = 75%
            //the rest 25% has been used for the Action button
            'widths'    => array('10', '7', '5', '7', '7', '64'),
            'nopagination' => true,
            'sScrollY'  => '500px',
            
            //now, we're adding edit button
            //write the button action prefix here
            'edit'      => 't_spj_',
            'delete'    => 't_spj_',
            'dLength'   => 1,
            'removeButtons' => true,
            
            //callbacks
            'fnInitComplete' => '$("#dtdynamic .tableFooter").remove()'
        );
        
        $data['content'] = '&nbsp;';//$this->load->view('parts/dataTables', $tblprm, true);
        $data['formCRUD'] = $this->form('new');
        $data['tab2title'] = 'Daftar Armada Jalan';
        $data['tab1title'] = 'Surat Perintah Jalan';
        $this->load->view('pages/crudOnly', $data);
    }
    
    function form($id)
    {
        $this->load->model(array('office/o_branch_m','masterdata/m_sim_m'));
        
        $brch_list = $this->o_branch_m->get_key_value('O_BranchID', 'O_BranchName');
        $sims_list = $this->m_sim_m->get_key_value('M_SimName', 'M_SimName');
        
        if ($id == 'new')
        {
            $form = array(
                array(
                    'title' => 'Data Pribadi',
                    'col0' => array(
                        array('label'=>'Kode','field'=>  form_input('T_SpjM_DriversCode', '', 'autocomplete=off')),
                        array('label'=>'Nama','field'=>  form_input('M_DriversName', '', 'disabled=disabled autocomplete=off')),
                        array('label'=>'Alamat','field'=>  form_input('M_DriversAddress', '', 'disabled=disabled autocomplete=off')),
                        array('label'=>'Limit KS / BS','field'=>  form_input('M_DriversKSLimit', '', 'readonly=readonly autocomplete=off class=rtl-inputz')),
                        array('label'=>'Jumlah KS / BS','field'=>  form_input('TotalKSBS', '', 'readonly=readonly autocomplete=off class=rtl-inputz'))
                    ),
                    'col1' => array(
                        array('label'=>'Tanggal','field'=>  form_input('T_SpjDate2', date('d-m-Y'), 'class=datepicker autocomplete=off disabled=disabled') . form_input(array('name'=>'T_SpjDate','value'=>date('Y-m-d'),'type'=>'hidden','autocomplete'=>'off'))),
                        array('label'=>'Jam','field'=>  form_input('T_SpjTime2', date('H:i'), 'class=datepicker autocomplete=off disabled=disabled') . form_input(array('name'=>'T_SpjTime','value'=>date('H:i:s'),'type'=>'hidden','autocomplete'=>'off')))
                    )
                ),
                array(
                    'title' => 'Data Pekerjaan',
                    'col0' => array(
                        array('label'=>'Kode Kendaraan','field'=>  form_dropdown('T_SpjM_FleetCode', array(), '', 'class="select grid8" onchange="fleetInfo($(this).val())"')),
                        array('label'=>'KM Kendaraan','field'=>  form_input('T_SpjStartKM', '', 'readonly=readonly')),
                        array('label'=>'Info Kendaraan','field'=>  '
                            <div class="body" style="padding:0px">
                                <ul class="liWarning">
                                </ul>
                            </div>
                        ')
                    ),
                    'col1' => array(
                        array('label'=>'Jumlah Setoran','field'=> form_input('T_SpjPay', '', 'class="rtl-inputz maskNum" autocomplete=off')),
                        array('label'=>'Potongan','field'=>  form_input('T_SpjPotongan', '', 'class="rtl-inputz maskNum" autocomplete=off')),
                        array('label'=>'Disetujui','field'=> form_input('T_SpjSignature', '', 'style=width:65%')),
                        array('label'=>'Jumlah yang Harus Disetor','field'=> form_input('T_SpjTotal', '', 'class="rtl-inputz maskNum" autocomplete=off readonly=readonly'))
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
        return $this->load->view('parts/formCRUDSpj', array('form'=>$form,'formname'=>'formspj','submit'=>array('button'=>'t_spj_save()')), true);
        
        return true;
    }
    
    function listing()
    {
        //getting param data
        $this->db->join('t_spjsetor', 'T_SpjSetorT_SpjID = T_SpjSetorID', 'left')
                ->where('T_SpjSetorID is NULL', null, false);
        list($tot_rec,$tot_disp_rec,$r) = $this->t_spj_m->listing($this->input,
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
        $i['T_SpjUserID'] = $this->user->UserID;
        
        //pada saat penyimpanan, data DATE diubah formatnya menjadi Y-m-d
        /*$i['DriversWorkDate'] = date('Y-m-d', strtotime($i['DriversWorkDate']));
        $i['DriversSIMDate'] = date('Y-m-d', strtotime($i['DriversSIMDate']));
        $i['DriversDOB'] = date('Y-m-d', strtotime($i['DriversDOB']));*/
        unset($i['M_DriversKSLimit']);
        unset($i['TotalKSBS']);
        
        $i['T_SpjO_BranchCode'] = $this->user->Branch;
        
        if ($id == 'new')
        {
            if (!$this->save_validate())
            {
                echo json_encode(array('err'=>$this->form_validation->error_array(),'msg'=>  validation_errors()));
                exit;
            }
            $r = $this->t_spj_m->save($i);
        }
        else
        {
            if (!$this->edit_validate())
            {
                echo json_encode(array('err'=>$this->form_validation->error_array(),'msg'=>  validation_errors()));
                exit;
            }
            $r = $this->drivers_m->save($i, $id);
        }
        
        if (!$r)
        {
            echo json_encode(array('err'=>'Error','msg'=>'Something Error'));
        }
        else
        {
            echo json_encode(array('rst'=>$r[1],'id'=>$r[0],'msg'=>'Data SPJ berhasil disimpan'));
            return;
        }
    }
    
    function save_validate()
    {
        $this->form_validation->set_rules('T_SpjM_DriversCode', 'Kode Driver', 'required|callback_check_drivers');
        $this->form_validation->set_rules('T_SpjPay', 'Jumlah Setoran', 'required|numeric');
        $this->form_validation->set_rules('T_SpjTotal', 'Jumlah Setoran', 'required|numeric');
        $this->form_validation->set_rules('M_DriversKSLimit', 'Limit KS', 'callback_check_ks');
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
            $r->date = date('d-m-Y');
            $r->time = date('H:i');
            echo json_encode ($r);
            return true;
        }
        
        return false;
    }
}
?>

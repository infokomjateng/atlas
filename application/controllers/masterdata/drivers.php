<?php

class Drivers extends MY_Controller
{
    function __construct() 
    {
        parent::__construct();
        
        $this->load->model('masterdata/m_drivers_m');
    }
    
    function index()
    { 
        $data['extrajs'] = array('m_drivers');
        
        //table parameter
        $tblprm = array(
            'id'        => 'dynamic',
            'source'    => base_url() . 'masterdata/drivers/listing',
            'columns'   => array('M_DriversCode', 'M_DriversName', 'M_DriversAddress', 'M_DriversIsGoing'),
            'titles'    => array('Kode', 'Nama', 'Alamat', 'Status Jalan'),
            
            //total column widths = 75%
            //the rest 25% has been used for the Action button
            'widths'    => array('5', '20', '50', '10'),
            
            //now, we're adding edit button
            //write the button action prefix here
            'edit'      => 'm_drivers_',
            'delete'    => 'm_drivers_',
            'dLength'   => 1
        );
        
        $data['content'] = $this->load->view('parts/dataTable', $tblprm, true);
        $data['formCRUD'] = '';
        $data['tableTitle'] = 'Master Data Driver';
        $this->load->view('pages/masterdata', $data);
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
                        array('label'=>'Nama','field'=>  form_input('M_DriversName', '')),
                        array('label'=>'Alamat','field'=>  form_input('M_DriversAddress', ''))
                    ),
                    'col1' => array(
                        array('label'=>'Tanggal Lahir','field'=>  form_input('M_DriversDOB', '', 'class=datepicker')),
                        array('label'=>'Tempat Lahir','field'=>  form_input('M_DriversPOB', ''))
                    )
                ),
                array(
                    'title' => 'Data Pekerjaan',
                    'col0' => array(
                        array('label'=>'Kode (KTA)','field'=>  form_input('M_DriversCode', '', '')),
                        array('label'=>'Cabang','field'=>  form_dropdown('M_DriversBranchID', $brch_list, '', 'class=\'select grid8\' style=\'\'')),
                        array('label'=>'Tanggal Mulai Kerja','field'=>  form_input('M_DriversWorkDate', '', 'class=datepicker')),
                        array('label'=>'Limit KS','field'=>  form_input('M_DriversKSLimit', '', ''))
                    ),
                    'col1' => array(
                        array('label'=>'Jenis SIM','field'=> form_dropdown('M_DriversSIMType', $sims_list, 'SIM B1 UMUM', 'class=\'select grid8\'')),
                        array('label'=>'Tanggal Exp SIM','field'=>  form_input('M_DriversSIMDate', '', 'class=datepicker')),
                        array('label'=>'Blokir ?','field'=> form_checkbox('M_DriversIsBlocked', '1', false)),
                        array('label'=>'Catatan Blokir','field'=> form_input('M_DriversBlockedNote', '', ''))
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
                        array('label'=>'Nama','field'=>  form_input('M_DriversName', $d->M_DriversName) .
                            form_hidden('DriversID', $d->M_DriversID)),
                        array('label'=>'Alamat','field'=>  form_input('M_DriversAddress', $d->M_DriversAddress))
                    ),
                    'col1' => array(
                        array('label'=>'Tanggal Lahir','field'=>  form_input('M_DriversDOB', date('d-m-Y', strtotime($d->M_DriversDOB)), 'class=datepicker')),
                        array('label'=>'Tempat Lahir','field'=>  form_input('M_DriversPOB', $d->M_DriversPOB))
                    )
                ),
                array(
                    'title' => 'Data Pekerjaan',
                    'col0' => array(
                        array('label'=>'Kode (KTA)','field'=>  form_input('M_DriversCode', $d->M_DriversCode, 'disabled=disabled')),
                        array('label'=>'Cabang','field'=>  form_dropdown('M_DriversBranchID', $brch_list, $d->M_DriversBranchID, 'class=\'select grid8\' style=\'\'')),
                        array('label'=>'Tanggal Mulai Kerja','field'=>  form_input('M_DriversWorkDate', date('d-m-Y', strtotime($d->M_DriversWorkDate)), 'class=datepicker')),
                        array('label'=>'Limit KS','field'=>  form_input('M_DriversKSLimit', $d->M_DriversKSLimit, ''))
                    ),
                    'col1' => array(
                        array('label'=>'Jenis SIM','field'=> form_dropdown('M_DriversSIMType', $sims_list, $d->M_DriversSIMType, 'class=\'select grid8\'')),
                        array('label'=>'Tanggal Exp SIM','field'=>  form_input('M_DriversSIMDate', date('d-m-Y', strtotime($d->M_DriversSIMDate)), 'class=datepicker')),
                        array('label'=>'Blokir ?','field'=> form_checkbox('M_DriversIsBlocked', '1', $d->M_DriversIsBlocked == 1 ? true : false)),
                        array('label'=>'Catatan Blokir','field'=> form_input('M_DriversBlockedNote', $d->M_DriversBlockedNote, ''))
                    )
                )
            );
        }
        echo $this->load->view('parts/formCRUD', array('form'=>$form,'formname'=>'formdrivers'), true);
        
        return true;
    }
    
    function listing()
    {
        //getting param data
        list($tot_rec,$tot_disp_rec,$r) = $this->m_drivers_m->listing($this->input,
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
        $i['M_DriversLastUpdate'] = date('Y-m-d H:i:s');
        $i['M_DriversUserID'] = $this->user->UserID;
        
        //pada saat penyimpanan, data DATE diubah formatnya menjadi Y-m-d
        $i['M_DriversWorkDate'] = date('Y-m-d', strtotime($i['M_DriversWorkDate']));
        $i['M_DriversSIMDate'] = date('Y-m-d', strtotime($i['M_DriversSIMDate']));
        $i['M_DriversDOB'] = date('Y-m-d', strtotime($i['M_DriversDOB']));
        
        if (!isset($i['M_DriversIsBlocked']))
            $i['M_DriversIsBlocked'] = 0;
        
        if ($id == 'new')
        {
            if (!$this->save_validate())
            {
                echo json_encode(array('err'=>$this->form_validation->error_array(),'msg'=>  validation_errors()));
                exit;
            }
            $r = $this->m_drivers_m->save($i);
        }
        else
        {
            if (!$this->edit_validate())
            {
                echo json_encode(array('err'=>$this->form_validation->error_array(),'msg'=>  validation_errors()));
                exit;
            }
            $r = $this->m_drivers_m->save($i, $id);
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
        $this->form_validation->set_rules('M_DriversName', 'Nama Driver', 'required');
        return $this->form_validation->run();
    }
    
    function edit_validate()
    {
        $this->form_validation->set_rules('M_DriversName', 'Nama Driver', 'required');
        return $this->form_validation->run();
    }
    
    function delete()
    {
        $i = $this->input->post();
        $i['M_DriversUserID'] = $this->user->UserID;
        $i['M_DriversLastUpdate'] = date('Y-m-d H:i:s');
        $i['M_DriversIsActive'] = 'N';
        $r = $this->drivers_m->save($i, $i['M_DriversID']);
        echo json_encode(array('rst'=>$r,'msg'=>'Data driver berhasil dihapus'));
        return;
    }
    
    function autocomplete()
    {
        $r = $this->m_drivers_m->autocomplete($this->input->get('term'));
        if ($r)
            echo json_encode($r);
        
        return false;
    }
    
    function get_by_code()
    {
        $r = $this->m_drivers_m->get_by_code($this->input->get('code'));
        if ($r)
            echo json_encode($r);
        
        return false;
    }
    
}
?>

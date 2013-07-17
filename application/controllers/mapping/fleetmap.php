<?php

class Fleetmap extends MY_Controller
{
    function __construct() 
    {
        parent::__construct();
        
        $this->load->model('mapping/m_fleetmap_m');
    }
    
    function index()
    {
        $data['extrajs'] = array('fleetmap');
        
        //table parameter
        $tblprm = array(
            'id'        => 'dynamic',
            'source'    => base_url() . 'mapping/fleetmap/listing',
            'columns'   => array('FleetCode', 'FleetVehicleType', 'DriversName'),
            'titles'    => array('Kode Armada', 'Nama Kendaraan', 'Nama Driver'),
            
            //total column widths = 75%
            //the rest 25% has been used for the Action button
            'widths'    => array('10', '20', '55'),
            
            //now, we're adding edit button
            //write the button action prefix here
            'edit'      => 'fleetmap_',
            'delete'    => 'fleetmap_',
            'dLength'   => 1
        );
        
        $data['content'] = $this->load->view('parts/dataTable', $tblprm, true);
        
        
        $data['formCRUD'] = '';
        
        $this->load->model('masterdata/fleet_m');
        $data['master'] = $this->fleet_m->get_list();
        
        $this->load->view('pages/mapping', $data);
    }
    
    function form($id)
    {
        //table parameter
        $tblprm = array(
            'id'        => 'leftside',
            'source'    => base_url() . 'mapping/fleetmap/listing',
            'columns'   => array('DriversCode', 'DriversName'),
            'titles'    => array('Kode Driver', 'Nama Driver'),
            
            //total column widths = 75%
            //the rest 25% has been used for the Action button
            'widths'    => array('10', '20', '55'),
            
            //now, we're adding edit button
            //write the button action prefix here
            'edit'      => 'fleetmap_',
            'delete'    => 'fleetmap_',
            'dLength'   => 1
        );
        
        $dt['leftside'] = $tblprm;
        
        
        //table parameter
        $tblprm = array(
            'id'        => 'rightside',
            'source'    => base_url() . 'mapping/fleetmap/listing',
            'columns'   => array('DriversCode', 'DriversName'),
            'titles'    => array('Kode Driver', 'Nama Driver'),
            
            //total column widths = 75%
            //the rest 25% has been used for the Action button
            'widths'    => array('10', '20', '55'),
            
            //now, we're adding edit button
            //write the button action prefix here
            'edit'      => 'fleetmap_',
            'delete'    => 'fleetmap_',
            'dLength'   => 1
        );
        $dt['rightside'] = $tblprm;
        $this->load->model('masterdata/fleet_m');
        $dt['masterList'] = $this->fleet_m->get_list();
        echo $this->load->view('parts/dialogMapping', $dt, true);
        exit;
        
        $this->load->model(array('masterdata/branch_m','masterdata/sim_m'));
        
        $brch_list = $this->branch_m->get_key_value('BranchID', 'BranchName');
        $sims_list = $this->sim_m->get_key_value('SimName', 'SimName');
        
        if ($id == 'new')
        {
            $form = array(
                array(
                    'title' => 'Data Pribadi',
                    'col0' => array(
                        array('label'=>'Nama','field'=>  form_input('DriversName', '')),
                        array('label'=>'Alamat','field'=>  form_input('DriversAddress', ''))
                    ),
                    'col1' => array(
                        array('label'=>'Tanggal Lahir','field'=>  form_input('DriversDOB', '', 'class=datepicker')),
                        array('label'=>'Tempat Lahir','field'=>  form_input('DriversPOB', ''))
                    )
                ),
                array(
                    'title' => 'Data Pekerjaan',
                    'col0' => array(
                        array('label'=>'Kode (KTA)','field'=>  form_input('DriversCode', '', '')),
                        array('label'=>'Cabang','field'=>  form_dropdown('DriversBranchID', $brch_list, '', 'class=\'select grid8\' style=\'\'')),
                        array('label'=>'Tanggal Mulai Kerja','field'=>  form_input('DriversWorkDate', '', 'class=datepicker')),
                        array('label'=>'Limit KS','field'=>  form_input('DriversKSLimit', '', ''))
                    ),
                    'col1' => array(
                        array('label'=>'Jenis SIM','field'=> form_dropdown('DriversSIMType', $sims_list, 'SIM B1 UMUM', 'class=\'select grid8\'')),
                        array('label'=>'Tanggal Exp SIM','field'=>  form_input('DriversSIMDate', '', 'class=datepicker')),
                        array('label'=>'Blokir ?','field'=> form_checkbox('DriversIsBlocked', '1', false)),
                        array('label'=>'Catatan Blokir)','field'=> form_input('DriversBlockedNote', '', ''))
                    )
                )
            );
            
        }
        else
        {
            $d = $this->drivers_m->get($id);
            
            $form = array(
                array(
                    'title' => 'Data Pribadi',
                    'col0' => array(
                        array('label'=>'Nama','field'=>  form_input('DriversName', $d->DriversName) .
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
        echo $this->load->view('parts/formCRUD', array('form'=>$form,'formname'=>'formdrivers'), true);
        
        return true;
    }
    
    function listing()
    {
        //getting param data
        list($tot_rec,$tot_disp_rec,$r) = $this->fleetmap_m->listing($this->input,
			array("FleetCode") );
        
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
        $i['DriversLastUpdate'] = date('Y-m-d H:i:s');
        $i['DriversUserID'] = $this->user->UserID;
        
        //pada saat penyimpanan, data DATE diubah formatnya menjadi Y-m-d
        $i['DriversWorkDate'] = date('Y-m-d', strtotime($i['DriversWorkDate']));
        $i['DriversSIMDate'] = date('Y-m-d', strtotime($i['DriversSIMDate']));
        $i['DriversDOB'] = date('Y-m-d', strtotime($i['DriversDOB']));
        
        if ($id == 'new')
        {
            if (!$this->save_validate())
            {
                echo json_encode(array('err'=>$this->form_validation->error_array(),'msg'=>  validation_errors()));
                exit;
            }
            $r = $this->drivers_m->save($i);
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
    
    function get_available()
    {
        $r = $this->fleetmap_m->get_available();
        echo json_encode($r);
        return;
    }
    
    function listing_available()
    {
        //getting param data
        list($tot_rec,$tot_disp_rec,$r) = $this->fleetmap_m->listing_available($this->input,
			array("FleetCode") );
        
        $output = array(
            'sEcho' => $this->input->get("sEcho"),
            'iTotalRecords' => $tot_rec,
            'iTotalDisplayRecords' => $tot_disp_rec,
            'aaData' => $r
        );
        
        echo json_encode($output);
    }
    
    function listing_connected()
    {
        //getting param data
        list($tot_rec,$tot_disp_rec,$r) = $this->fleetmap_m->listing_connected($this->input,
			array("FleetCode") );
        
        $output = array(
            'sEcho' => $this->input->get("sEcho"),
            'iTotalRecords' => $tot_rec,
            'iTotalDisplayRecords' => $tot_disp_rec,
            'aaData' => $r
        );
        
        echo json_encode($output);
    }
    
    function get_by_driverscode()
    {
        $r = $this->m_fleetmap_m->get_by_driverscode($this->input->get('code'));
        if ($r)
        {
            echo json_encode($r);
            return true;
        }
        
        return false;
    }
}
?>

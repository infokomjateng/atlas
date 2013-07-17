<?php

class Fleet extends MY_Controller
{
    function __construct() 
    {
        parent::__construct();
        
        $this->load->model('masterdata/m_fleet_m');
    }
    
    function index()
    {
        $data['extrajs'] = array('m_fleet');
        
        //table parameter
        $tblprm = array(
            'id'        => 'dynamic',
            'source'    => base_url() . 'masterdata/fleet/listing',
            'columns'   => array('M_FleetCode', 'M_FleetVehicleType', 'M_FleetNoPol'),
            'titles'    => array('Kode', 'Tipe Kendaraan', 'Nomor Polisi'),
            
            //total column widths = 75%
            //the rest 25% has been used for the Action button
            'widths'    => array('5', '70', '10'),
            
            //now, we're adding edit button
            //write the button action prefix here
            'edit'      => 'm_fleet_',
            'delete'    => 'm_fleet_',
            'dLength'   => 1
        );
        
        $data['content'] = $this->load->view('parts/dataTable', $tblprm, true);
        $data['formCRUD'] = '';
        $data['tableTitle'] = 'Master Data Armada';
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
                    'title' => 'Data Umum',
                    'col0' => array(
                        array('label'=>'Kode','field'=>  form_input('M_FleetCode', '')),
                        array('label'=>'Tipe Kendaraan','field'=>  form_input('M_FleetVehicleType', '')),
                        array('label'=>'Nomor Polisi','field'=>  form_input('M_FleetNoPol', ''))
                    ),
                    'col1' => array(
                        array('label'=>'Nomor Mesin','field'=>  form_input('M_FleetNoMesin', '')),
                        array('label'=>'Nomor Rangka','field'=>  form_input('M_FleetNoRangka', '')),
                        array('label'=>'Nomor BPKB','field'=>  form_input('M_FleetBPKBNumber', '')),
                        array('label'=>'Catatan BPKB','field'=>  form_input('M_FleetBPKBNote', ''))
                    )
                ),
                array(
                    'title' => 'Data Jalan',
                    'col0' => array(
                        array('label'=>'Jam Jalan','field'=>  form_input('M_FleetHour', '', '')),
                        array('label'=>'Jumlah Setoran','field'=>  form_input('M_FleetPay', '', ''))
                    ),
                    'col1' => array(
                        array('label'=>'Jumlah Overtime','field'=> form_input('M_FleetOvertime', '', '')),
                        array('label'=>'Bonus ?','field'=> form_checkbox('M_FleetBonus', '1', false))
                    )
                ),
                array(
                    'title' => 'Data Tanggal',
                    'col0' => array(
                        array('label'=>'Tanggal STNK','field'=>  form_input('M_FleetSTNKDate', '', 'class=datepicker')),
                        array('label'=>'Tanggal KIR','field'=>  form_input('M_FleetKIRDate', '', 'class=datepicker')),
                        array('label'=>'Tanggal KPS','field'=>  form_input('M_FleetKPSDate', '', 'class=datepicker')),
                        array('label'=>'Tanggal Terra','field'=>  form_input('M_FleetTerraDate', '', 'class=datepicker'))
                    ),
                    'col1' => array(
                        array('label'=>'Tanggal Trayek','field'=>  form_input('M_FleetTrayekDate', '', 'class=datepicker')),
                        array('label'=>'KM Ganti Oli','field'=> form_input('M_FleetOilKM', '', '')),
                        array('label'=>'KM Ganti Belt','field'=> form_input('M_FleetBeltKM', '', ''))
                    )
                )
            );
        }
        else
        {
            $d = $this->m_fleet_m->get($id);
            
            $form = array(
                array(
                    'title' => 'Data Umum',
                    'col0' => array(
                        array('label'=>'Kode','field'=>  form_input('M_FleetCode', $d->M_FleetCode, 'disabled=disabled') . form_hidden('M_FleetID', $d->M_FleetID)),
                        array('label'=>'Tipe Kendaraan','field'=>  form_input('M_FleetVehicleType', $d->M_FleetVehicleType)),
                        array('label'=>'Nomor Polisi','field'=>  form_input('M_FleetNoPol', $d->M_FleetNoPol))
                    ),
                    'col1' => array(
                        array('label'=>'Nomor Mesin','field'=>  form_input('M_FleetNoMesin', $d->M_FleetNoMesin)),
                        array('label'=>'Nomor Rangka','field'=>  form_input('M_FleetNoRangka', $d->M_FleetNoRangka)),
                        array('label'=>'Nomor BPKB','field'=>  form_input('M_FleetBPKBNumber', $d->M_FleetBPKBNumber)),
                        array('label'=>'Catatan BPKB','field'=>  form_input('M_FleetBPKBNote', $d->M_FleetBPKBNote))
                    )
                ),
                array(
                    'title' => 'Data Jalan',
                    'col0' => array(
                        array('label'=>'Jam Jalan','field'=>  form_input('M_FleetHour', $d->M_FleetHour, '')),
                        array('label'=>'Jumlah Setoran','field'=>  form_input('M_FleetPay', $d->M_FleetPay, ''))
                    ),
                    'col1' => array(
                        array('label'=>'Jumlah Overtime','field'=> form_input('M_FleetOvertime', $d->M_FleetOvertime, '')),
                        array('label'=>'Bonus ?','field'=> form_checkbox('M_FleetBonus', '1', $d->M_FleetBonus == '1' ? true : false ))
                    )
                ),
                array(
                    'title' => 'Data Tanggal',
                    'col0' => array(
                        array('label'=>'Tanggal STNK','field'=>  form_input('M_FleetSTNKDate', $d->M_FleetSTNKDate == NULL ? '' : date('d-m-Y', strtotime($d->M_FleetSTNKDate)), 'class=datepicker')),
                        array('label'=>'Tanggal KIR','field'=>  form_input('M_FleetKIRDate', $d->M_FleetKIRDate == NULL ? '' : date('d-m-Y', strtotime($d->M_FleetKIRDate)), 'class=datepicker')),
                        array('label'=>'Tanggal KPS','field'=>  form_input('M_FleetKPSDate', $d->M_FleetKPSDate == NULL ? '' : date('d-m-Y', strtotime($d->M_FleetKPSDate)), 'class=datepicker')),
                        array('label'=>'Tanggal Terra','field'=>  form_input('M_FleetTerraDate', $d->M_FleetTerraDate == NULL ? '' : date('d-m-Y', strtotime($d->M_FleetTerraDate)), 'class=datepicker'))
                    ),
                    'col1' => array(
                        array('label'=>'Tanggal Trayek','field'=>  form_input('M_FleetTrayekDate', $d->M_FleetTrayekDate == NULL ? '' : date('d-m-Y', strtotime($d->M_FleetTrayekDate)), 'class=datepicker')),
                        array('label'=>'KM Ganti Oli','field'=> form_input('M_FleetOilKM', $d->M_FleetOilKM, '')),
                        array('label'=>'KM Ganti Belt','field'=> form_input('M_FleetBeltKM', $d->M_FleetBeltKM, ''))
                    )
                )
            );
        }
        echo $this->load->view('parts/formCRUD', array('form'=>$form,'formname'=>'formfleet'), true);
        
        return true;
    }
    
    function listing()
    {
        //getting param data
        list($tot_rec,$tot_disp_rec,$r) = $this->m_fleet_m->listing($this->input,
			array("M_FleetName") );
        
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
        $i['M_FleetLastUpdate'] = date('Y-m-d H:i:s');
        $i['M_FleetUserID'] = $this->user->UserID;
        
        //pada saat penyimpanan, data DATE diubah formatnya menjadi Y-m-d
        //check jika NULL
        $i['M_FleetSTNKDate'] = $i['M_FleetSTNKDate'] == '' ? NULL : date('Y-m-d', strtotime($i['M_FleetSTNKDate']));
        $i['M_FleetKIRDate'] = $i['M_FleetKIRDate'] == '' ? NULL : date('Y-m-d', strtotime($i['M_FleetKIRDate']));
        $i['M_FleetKPSDate'] = $i['M_FleetKPSDate'] == '' ? NULL : date('Y-m-d', strtotime($i['M_FleetKPSDate']));
        $i['M_FleetTerraDate'] = $i['M_FleetTerraDate'] == '' ? NULL : date('Y-m-d', strtotime($i['M_FleetTerraDate']));
        $i['M_FleetTrayekDate'] = $i['M_FleetTrayekDate'] == '' ? NULL : date('Y-m-d', strtotime($i['M_FleetTrayekDate']));
        
        //checkbox bonus
        if (!isset($i['M_FleetBonus'])) 
            $i['M_FleetBonus'] = 0;
        
        if ($id == 'new')
        {
            if (!$this->save_validate())
            {
                echo json_encode(array('err'=>$this->form_validation->error_array(),'msg'=>  validation_errors()));
                exit;
            }
            $r = $this->m_fleet_m->save($i);
        }
        else
        {
            if (!$this->edit_validate())
            {
                echo json_encode(array('err'=>$this->form_validation->error_array(),'msg'=>  validation_errors()));
                exit;
            }
            $r = $this->m_fleet_m->save($i, $id);
        }
        
        if (!$r)
        {
            echo json_encode(array('err'=>'Error tenan','msg'=>'Error pancene'));
        }
        else
        {
            echo json_encode(array('rst'=>$r,'msg'=>'Data armada berhasil disimpan'));
            return;
        }
    }
    
    function save_validate()
    {
        $this->form_validation->set_rules('M_FleetCode', 'Kode Armada', 'required');
        return $this->form_validation->run();
    }
    
    function edit_validate()
    {
        $this->form_validation->set_rules('M_FleetCode', 'Kode Armada', 'required');
        return $this->form_validation->run();
    }
    
    function delete()
    {
        $i = $this->input->post();
        $i['M_FleetUserID'] = $this->user->UserID;
        $i['M_FleetLastUpdate'] = date('Y-m-d H:i:s');
        $i['M_FleetIsActive'] = 0;
        $r = $this->m_fleet_m->save($i, $i['M_FleetID']);
        echo json_encode(array('rst'=>$r,'msg'=>'Data Armada berhasil dihapus'));
        return;
    }
    
    function get_info()
    {
        $r = $this->m_fleet_m->get_info($this->input->get('code'));
        if ($r)
        {
            $alr = '';
            $alr .= $r->M_FleetAlertOilKM == 'Y' ? '<li>Saatnya ganti Oli [KM ' . $r->M_FleetOilKM . ']</li>' : '';
            $alr .= $r->M_FleetAlertBeltKM == 'Y' ? '<li>Saatnya ganti Belt [KM ' . $r->M_FleetBeltKM . ']</li>' : '';
            $alr .= $r->M_FleetAlertSTNKDate == 'Y' ? '<li>Tanggal STNK telah jatuh tempo [ ' . $r->M_FleetSTNKDate . ' ]</li>' : '';
            $alr .= $r->M_FleetAlertKIRDate == 'Y' ? '<li>Tanggal KIR telah jatuh tempo [ ' . $r->M_FleetKIRDate . ' ]</li>' : '';
            $alr .= $r->M_FleetAlertKPSDate == 'Y' ? '<li>Tanggal KPS telah jatuh tempo [ ' . $r->M_FleetKPSDate . ' ]</li>' : '';
            $alr .= $r->M_FleetAlertTerraDate == 'Y' ? '<li>Tanggal Terra telah jatuh tempo [ ' . $r->M_FleetTerraDate . ' ]</li>' : '';
            $alr .= $r->M_FleetAlertTrayekDate == 'Y' ? '<li>Tanggal Trayek telah jatuh tempo [ ' . $r->M_FleetTrayekDate . ' ]</li>' : '';
            echo json_encode(array(
                'currkm'=>$r->M_FleetEndKM,
                'pay'=>$r->M_FleetPay,
                'alert'=>$alr
            ));
            return true;
        }
        
        return false;
    }
}
?>

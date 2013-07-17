<?php

class Purchasing extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $this->load->model(array('transaction/t_purchasing_m'));
    }
    
    function index()
    {
        $data['extrajs'] = array('t_purchasing');
        
        //table parameter
        $tblprm = array(
            'id'        => 'dynamic',
            'source'    => base_url() . 'spj/spj/listing',
            'columns'   => array('T_SpjDate', 'T_SpjTime', 'M_DriversCode', 'M_DriversName'),
            'titles'    => array('Tanggal', 'Waktu', 'Kode Driver', 'Nama Driver'),
            
            //total column widths = 75%
            //the rest 25% has been used for the Action button
            'widths'    => array('5', '5', '20', '55'),
            
            //now, we're adding edit button
            //write the button action prefix here
            'edit'      => 't_spj_',
            'delete'    => 't_spj_',
            'dLength'   => 1
        );
        
        $data['content'] = $this->load->view('parts/dataTable', $tblprm, true);
        $data['formCRUD'] = $this->form('new');
        $this->load->view('pages/purchasing', $data);
    }
    
    function form($id)
    {
        $this->load->model(array('office/o_branch_m','masterdata/m_supplier_m'));
        
        $brch_list = $this->o_branch_m->get_key_value('O_BranchCode', 'O_BranchName');
        $sups_list = $this->m_supplier_m->get_key_value('M_SupplierCode', 'M_SupplierName');
        
        if ($id == 'new')
        {
            $form = array(
                array(
                    'title' => 'Data Pribadi',
                    'col0' => array(
                        array('label'=>'Cabang','field'=>  form_dropdown('T_PurchasingO_BranchCode', $brch_list, '', 'class="select grid12"')),
                        array('label'=>'Supplier','field'=>  form_dropdown('T_PurchasingM_SupplierCode', $sups_list, '', 'class="select grid12"'))
                    ),
                    'col1' => array(
                        array('label'=>'Tanggal','field'=> form_input('T_PurchasingDate2', date('d-m-Y'), 'class=datepicker autocomplete=off') . form_input(array('name'=>'T_PurchasingDate','value'=>date('Y-m-d'),'type'=>'hidden','autocomplete'=>'off'))),
                        array('label'=>'No Faktur','field'=> form_input('T_PurchasingNumber', '', 'autocomplete=off'))
                    ),
                    'col2' => array(
                        array('label'=>'Total','field'=>  '<div class=grid4>' . form_input('T_PurchasingTotal', '0', 'autocomplete=off class="maskNum rtl-inputf" readonly=readonly') . '</div>'),
                        array('label'=>'Tempo','field'=>  '<div class=grid4>' . form_input('T_PurchasingTempo', '0', 'autocomplete=off class="maskNum rtl-inputf" style="float:none"') .
                            '<span class=note>dalam hari</span></div>'
                            )
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
        return $this->load->view('parts/formCRUD', array('form'=>$form,'formname'=>'formspj'), true);
        
        return true;
    }
    
    function detail()
    {
        
    }
    
    function save($id)
    {
        $i = $this->input->post();
        $i['T_PurchasingUserID'] = $this->user->UserID;
                
        if ($id == 'new')
        {
            if (!$this->save_validate())
            {
                echo json_encode(array('err'=>$this->form_validation->error_array(),'msg'=>  validation_errors()));
                exit;
            }
            $r = $this->t_purchasing_m->save($i);
        }
        else
        {
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
    
    function save_validate()
    {
        return true;
    }

}
?>

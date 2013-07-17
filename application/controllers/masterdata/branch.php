<?php

class Drivers extends MY_Controller
{
    function __construct() 
    {
        parent::__construct();
        
        $this->load->model('masterdata/drivers_m');
    }
    
    function index()
    {
        //table parameter
        $tblprm = array(
            'id'        => 'dynamic',
            'source'    => base_url() . 'masterdata/drivers/listing',
            'columns'   => array('DriversName'),
            'titles'    => array('Nama'),
            
            //total column widths = 75%
            //the rest 25% has been used for the Action button
            'widths'    => array('85'),
            
            //now, we're adding edit button
            //write the button action prefix here
            'edit'      => 'drivers_',
            'delete'    => 'drivers_',
            'dLength'   => 1
        );
        
        $data['content'] = $this->load->view('parts/dataTable', $tblprm, true);
        $data['formCRUD'] = $this->load->view('parts/formCRUD', array('form'=>$this->form()), true);
        $this->load->view('pages/table', $data);
    }
    
    function form()
    {
        $this->load->model(array('masterdata/branch_m','masterdata/sim_m'));
        
        $brch_list = $this->branch_m->get_key_value('BranchID', 'BranchName');
        $sims_list = $this->sim_m->get_key_value('SimName', 'SimName');
        
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
                    array('label'=>'Cabang','field'=>  form_dropdown('DriversBranchID', $brch_list, '', 'class=\'select grid8\' style=\'\'')),
                    array('label'=>'Tanggal Mulai Kerja','field'=>  form_input('DriversWorkDate', '', 'class=datepicker')),
                    array('label'=>'Limit KS','field'=>  form_input('DriversKSLimit', '', '')),
                    array('label'=>'Jenis SIM','field'=> form_dropdown('DriversSIMType', $sims_list, 'SIM B1 UMUM', 'class=\'select grid8\'')),
                    array('label'=>'Tanggal Exp SIM','field'=>  form_input('DriversSIMDate', '', 'class=datepicker'))
                ),
                'col1' => array(
                    array('label'=>'Blocked ?','field'=> form_checkbox('DriversIsBlocked', '1', false)),
                    array('label'=>'Catatan (Blocked)','field'=> form_input('DriversBlockedNote', '', ''))
                )
            )
        );
        
        return $form;
    }
    
    function listing()
    {
        //getting param data
        list($tot_rec,$tot_disp_rec,$r) = $this->drivers_m->listing($this->input,
			array("DriversName") );
        
        $output = array(
            'sEcho' => $this->input->get("sEcho"),
            'iTotalRecords' => $tot_rec,
            'iTotalDisplayRecords' => $tot_disp_rec,
            'aaData' => $r
        );
        
        echo json_encode($output);
    }
}
?>

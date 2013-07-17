<?php

class Doctor extends MY_Controller
{
    function __construct() 
    {
        $this->isRequiredLogin = true;
        parent::__construct();
        
        $this->load->model('masterdata/doctor_m');
    }
    
    function index()
    {
        //print_r($this->user);
        $dt['pagetitle'] = 'Master Data Dokter';
        $dt['tabletitle'] = 'Data Dokter';
        
        //dialogs
        $dt['dialogs'] = $this->load->view('parts/dialogform', '', true);
        
        $dt['extrajs'] = array('doctor');
        
        //table parameter
        $tblprm = array(
            'id'        => 'dynamic',
            'source'    => base_url() . 'masterdata/doctor/listing',
            'columns'   => array('DoctorName'),
            'titles'    => array('Nama'),
            
            //total column widths = 75%
            //the rest 25% has been used for the Action button
            'widths'    => array('83'),
            
            //now, we're adding edit button
            //write the button action prefix here
            'edit'      => 'doctor_',
            'delete'    => 'doctor_',
            'dLength'   => 1
        );
        
        //load datatable view
        $tbl = $this->load->view('basics/dataTable', $tblprm, true);

        $dt['table'] = $tbl;
        $dt['new'] = 'doctor_';
        
        $this->load->view('pages/table', $dt);
    }
    
    public function listing()
    {        
        //getting param data
        list($tot_rec,$tot_disp_rec,$r) = $this->doctor_m->listing($this->input,
			array("DoctorName") );
        
        $output = array(
            'sEcho' => $this->input->get("sEcho"),
            'iTotalRecords' => $tot_rec,
            'iTotalDisplayRecords' => $tot_disp_rec,
            'aaData' => $r
        );
        
        echo json_encode($output);
    }
    
    public function form($id)
    {
        if ($id != 'new')
        {
            $r = $this->doctor_m->get($id);
            
            $dt['form'] = array(
                array('type'=>'field', 'label'=>'Nama Dokter',
                    'field'=>form_input(array('name'=>'DoctorName','style'=>'width:80%;margin-right:20%;','placeholder'=>'Masukkan nama dokter','class'=>'clear','value'=>$r->DoctorName)) . form_hidden('DoctorID',$r->DoctorID))
            );
        }
        else
        {
            $dt['form'] = array(
                array('type'=>'field', 'label'=>'Nama Dokter',
                    'field'=>form_input(array('name'=>'DoctorName','style'=>'width:80%;margin-right:20%;','placeholder'=>'Masukkan nama dokter','class'=>'clear')))
            );
        }
        
        
        echo $this->load->view('parts/dialogFormContent', $dt);
    }
    
    public function save()
    {
        $cmd = $this->input->post("cmd");
	$inp = $this->input->post();
        unset($inp["cmd"]);
		
        $inp['DoctorUserID'] = 1;
                        
        if ($cmd == "new" ) 
        {
                $rst = $this->doctor_m->save($inp);
        } else {
                $id = $this->input->post("DoctorID");
                unset($inp["DoctorID"]);
                $rst = $this->doctor_m->save($inp,$id);
        }
        if (!$rst) {
                $msg = $this->db->_error_message();
                $num = $this->db->_error_number();

                $rst = array("rst"=>false , "msg" => "$num : $msg " );
                echo json_encode( $rst );
                exit;
        }
        $rst = array("rst"=>$rst , "msg" => "Result");
        echo json_encode( $rst );
    }
    
    public function delete ($id) {
        $inp["DoctorIsActive"] = "N";
        $rst = $this->doctor_m->save($inp,$id);

        $rst = array("rst"=>$rst , "msg" => "Result");
        echo json_encode( $rst );
    }
    
    public function autocomplete2()
    {
        $r = $this->doctor_m->autocomplete2($this->input->get('term'));
        if ($r)
        {
            echo json_encode($r);
            exit;
        }
        return false;
    }
}
    
?>
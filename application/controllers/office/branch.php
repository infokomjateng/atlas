<?php

class Branch extends MY_Controller
{
    function __construct() 
    {
        parent::__construct();
        
        $this->load->model('office/o_branch_m');
    }
    
    function index()
    {
        $data['extrajs'] = array('o_branch');
        
        //table parameter
        $tblprm = array(
            'id'        => 'dynamic',
            'source'    => base_url() . 'office/branch/listing',
            'columns'   => array('O_BranchCode', 'O_BranchName', 'O_BranchAddress'),
            'titles'    => array('Kode', 'Nama', 'Alamat'),
            
            //total column widths = 75%
            //the rest 25% has been used for the Action button
            'widths'    => array('10', '25', '50'),
            
            //now, we're adding edit button
            //write the button action prefix here
            'edit'      => 'o_branch_',
            'delete'    => 'o_branch_',
            'dLength'   => 1
        );
        
        $data['content'] = $this->load->view('parts/dataTable', $tblprm, true);
        $data['formCRUD'] = '';//$this->load->view('parts/formCRUD', array('form'=>$this->form()), true);
        $data['tableTitle'] = 'Master Data <u>Cabang Perusahaan</u>';
        $this->load->view('pages/masterdata', $data);
    }
    
    function form($id)
    {        
        if ($id == 'new')
        {
            $form = array(
                array(
                    'title' => 'Data Perusahaan',
                    'col0' => array(
                        array('label'=>'Kode','field'=>  form_input('O_BranchCode', '')),
                        array('label'=>'Nama','field'=>  form_input('O_BranchName', ''))
                    ),
                    'col1' => array(
                        array('label'=>'Nama','field'=>  form_input('O_BranchAddress', ''))
                    )
                )
            );
            
        }
        else
        {
            $d = $this->o_branch_m->get($id);
            
            $form = array(
                array(
                    'title' => 'Data Perusahaan',
                    'col0' => array(
                        array('label'=>'Kode','field'=>  form_input('O_BranchCode', $d->O_BranchCode, 'disabled=disabled') .
                            form_hidden('O_BranchID', $d->O_BranchID)),
                        array('label'=>'Nama','field'=>  form_input('O_BranchName', $d->O_BranchName))
                    ),
                    'col1' => array(
                        array('label'=>'Alamat','field'=>  form_input('O_BranchAddress', $d->O_BranchAddress))
                    )
                )
            );
        }
        echo $this->load->view('parts/formCRUD', array('form'=>$form,'formname'=>'formbranch'), true);
        
        return true;
    }
    
    function listing()
    {
        //getting param data
        list($tot_rec,$tot_disp_rec,$r) = $this->o_branch_m->listing($this->input,
			array("O_BranchName") );
        
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
        //$i['O_BranchLastUpdate'] = date('Y-m-d H:i:s');
        $i['O_BranchUserID'] = $this->user->UserID;
        
        if ($id == 'new')
        {
            if (!$this->save_validate())
            {
                echo json_encode(array('err'=>$this->form_validation->error_array(),'msg'=>  validation_errors()));
                exit;
            }
            $r = $this->o_branch_m->save($i);
        }
        else
        {
            if (!$this->edit_validate())
            {
                echo json_encode(array('err'=>$this->form_validation->error_array(),'msg'=>  validation_errors()));
                exit;
            }
            $r = $this->o_branch_m->save($i, $id);
        }
        
        if (!$r)
        {
            echo json_encode(array('err'=>'Error tenan','msg'=>'Error pancene'));
        }
        else
        {
            echo json_encode(array('rst'=>$r,'msg'=>'Data cabang berhasil disimpan'));
            return;
        }
    }
    
    function save_validate()
    {
        $this->form_validation->set_rules('O_BranchName', 'Nama Cabang', 'required');
        $this->form_validation->set_rules('O_BranchCode', 'Kode Cabang', 'required');
        return $this->form_validation->run();
    }
    
    function edit_validate()
    {
        $this->form_validation->set_rules('O_BranchName', 'Nama Cabang', 'required');
        return $this->form_validation->run();
    }
    
    function delete()
    {
        $i = $this->input->post();
        $i['O_BranchUserID'] = $this->user->UserID;
        $i['O_BranchLastUpdate'] = date('Y-m-d H:i:s');
        $i['O_BranchIsActive'] = 0;
        $r = $this->o_branch_m->save($i, $i['O_BranchID']);
        echo json_encode(array('rst'=>$r,'msg'=>'Data cabang berhasil dihapus'));
        return;
    }
}
?>

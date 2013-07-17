<?php

class Accountitem extends MY_Controller
{
    function __construct() 
    {
        parent::__construct();
        
        $this->load->model('finance/f_accountitem_m');
    }
    
    function index()
    {
        $data['extrajs'] = array('f_account');
        
        //table parameter
        $tblprm = array(
            'id'        => 'dynamic',
            'source'    => base_url() . 'finance/account/listing',
            'columns'   => array('F_AccountCode', 'F_AccountName'),
            'titles'    => array('Kode', 'Nama Akun'),
            
            //total column widths = 75%
            //the rest 25% has been used for the Action button
            'widths'    => array('10', '75'),
            
            //now, we're adding edit button
            //write the button action prefix here
            'edit'      => 'f_account_',
            'delete'    => 'f_account_',
            'dLength'   => 1
        );
        
        $data['content'] = $this->load->view('parts/dataTable', $tblprm, true);
        $data['formCRUD'] = '';//$this->load->view('parts/formCRUD', array('form'=>$this->form()), true);
        $this->load->view('pages/table', $data);
    }
    
    function form($id)
    {        
        if ($id == 'new')
        {
            $form = array(
                array(
                    'title' => 'Data Akun',
                    'col0' => array(
                        array('label'=>'Kode Akun','field'=>  form_input('F_AccountItemCode', '') . form_hidden('F_AccountItemF_AccountCode', $this->input->post('F_AccountCode'))),
                        array('label'=>'Nama Akun','field'=>  form_input('F_AccountItemName', ''))
                    )
                )
            );
            
        }
        else
        {
            $d = $this->f_accountitem_m->get($id);
            
            $form = array(
                array(
                    'title' => 'Data Akun',
                    'col0' => array(
                        array('label'=>'Kode Akun','field'=>  form_input('F_AccountItemCode', $d->F_AccountItemCode) .
                            form_hidden('F_AccountItemID', $d->F_AccountItemID)),
                        array('label'=>'Nama Akun','field'=>  form_input('F_AccountItemName', $d->F_AccountItemName))
                    )
                )
            );
        }
        echo $this->load->view('parts/formCRUD', array('form'=>$form,'formname'=>'formaccountitem'), true);
        
        return true;
    }
    
    function listing($code)
    {
        //getting param data
        $this->db->where('F_AccountItemF_AccountCode', $code);
        list($tot_rec,$tot_disp_rec,$r) = $this->f_accountitem_m->listing($this->input,
			array("F_AccountItemCode") );
        
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
        $i['F_AccountItemUserID'] = $this->user->UserID;
        
        if ($id == 'new')
        {
            if (!$this->save_validate())
            {
                echo json_encode(array('err'=>$this->form_validation->error_array(),'msg'=>  validation_errors()));
                exit;
            }
            $r = $this->f_accountitem_m->save($i);
        }
        else
        {
            if (!$this->edit_validate())
            {
                echo json_encode(array('err'=>$this->form_validation->error_array(),'msg'=>  validation_errors()));
                exit;
            }
            $r = $this->f_accountitem_m->save($i, $id);
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
        $this->form_validation->set_rules('F_AccountItemName', 'Nama Akun', 'required');
        $this->form_validation->set_rules('F_AccountItemCode', 'Kode Akun', 'required|exact_length[5]');
        return $this->form_validation->run();
    }
    
    function edit_validate()
    {
        $this->form_validation->set_rules('F_AccountItemName', 'Nama Akun', 'required');
        $this->form_validation->set_rules('F_AccountItemCode', 'Kode Akun', 'required|exact_length[5]');
        return $this->form_validation->run();
    }
    
    function delete()
    {
        $i = $this->input->post();
        $i['F_AccountItemUserID'] = $this->user->UserID;
        $i['F_AccountItemLastUpdate'] = date('Y-m-d H:i:s');
        $i['F_AccountItemIsActive'] = 0;
        $r = $this->f_accountitem_m->save($i, $i['F_AccountItemID']);
        echo json_encode(array('rst'=>$r,'msg'=>'Data akun berhasil dihapus'));
        return;
    }
    
    
}
?>

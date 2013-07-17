<?php

class Account extends MY_Controller
{
    function __construct() 
    {
        parent::__construct();
        
        $this->load->model('finance/f_account_m');
    }
    
    function index()
    {
        $data['extrajs'] = array('f_account','f_accountitem');
        
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
        $data['tabletitle'] = 'Data Akun / Perkiraan';//$this->load->view('parts/formCRUD', array('form'=>$this->form()), true);
        $this->load->view('pages/tableOnly', $data);
    }
    
    function form($id)
    {        
        if ($id == 'new')
        {
            $form = array(
                array(
                    'title' => 'Data Akun',
                    'col0' => array(
                        array('label'=>'Kode Akun','field'=>  form_input('F_AccountCode', '')),
                        array('label'=>'Nama Akun','field'=>  form_input('F_AccountName', ''))
                    )
                )
            );
            
        }
        else
        {
            $d = $this->f_account_m->get($id);
            
            $form = array(
                array(
                    'title' => 'Data Akun',
                    'col0' => array(
                        array('label'=>'Kode Akun','field'=>  form_input('F_AccountCode', $d->F_AccountCode) .
                            form_hidden('F_AccountID', $d->F_AccountID)),
                        array('label'=>'Nama Akun','field'=>  form_input('F_AccountName', $d->F_AccountName))
                    )
                )
            );
        }
        echo $this->load->view('parts/formCRUD', array('form'=>$form,'formname'=>'formaccount'), true);
        
        return true;
    }
    
    function listing()
    {
        //getting param data
        list($tot_rec,$tot_disp_rec,$r) = $this->f_account_m->listing($this->input,
			array("F_AccountCode") );
        
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
        $i['F_AccountUserID'] = $this->user->UserID;
        
        if ($id == 'new')
        {
            if (!$this->save_validate())
            {
                echo json_encode(array('err'=>$this->form_validation->error_array(),'msg'=>  validation_errors()));
                exit;
            }
            $r = $this->f_account_m->save($i);
        }
        else
        {
            if (!$this->edit_validate())
            {
                echo json_encode(array('err'=>$this->form_validation->error_array(),'msg'=>  validation_errors()));
                exit;
            }
            $r = $this->f_account_m->save($i, $id);
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
        $this->form_validation->set_rules('F_AccountName', 'Nama Akun', 'required');
        $this->form_validation->set_rules('F_AccountCode', 'Kode Akun', 'required|exact_length[10]');
        return $this->form_validation->run();
    }
    
    function edit_validate()
    {
        $this->form_validation->set_rules('F_AccountName', 'Nama Akun', 'required');
        $this->form_validation->set_rules('F_AccountCode', 'Kode Akun', 'required|exact_length[10]');
        return $this->form_validation->run();
    }
    
    function delete()
    {
        $i = $this->input->post();
        $i['F_AccountID'] = $this->user->UserID;
        $i['F_AccountLastUpdate'] = date('Y-m-d H:i:s');
        $i['F_AccountIsActive'] = 0;
        $r = $this->f_account_m->save($i, $i['F_AccountID']);
        echo json_encode(array('rst'=>$r,'msg'=>'Data akun berhasil dihapus'));
        return;
    }
    
    function listingItem($id)
    {
        $d = $this->f_account_m->get($id);
        
        $form = array(
            array(
                'title' => 'Data Akun',
                'col0' => array(
                    array('label'=>'Kode Akun','field'=>  form_input('F_AccountCode', $d->F_AccountCode) . form_hidden('F_AccountID', $d->F_AccountID)),
                    //array('label'=>'Nama Akun','field'=>  form_input('F_AccountName', $d->F_AccountName))
                ),
                'col1' => array(
                    //array('label'=>'Kode Akun','field'=>  form_input('F_AccountCode', $d->F_AccountCode) . form_hidden('F_AccountID', $d->F_AccountID)),
                    array('label'=>'Nama Akun','field'=>  form_input('F_AccountName', $d->F_AccountName))
                )
            )
        );
        
        //table parameter
        $tblprm = array(
            'id'        => 'accountitem',
            'source'    => base_url() . 'finance/accountitem/listing/' . $this->input->post('code'),
            'columns'   => array('F_AccountItemCode', 'F_AccountItemName'),
            'titles'    => array('Kode Akun', 'Nama Akun'),
            
            //total column widths = 75%
            //the rest 25% has been used for the Action button
            'widths'    => array('10', '75'),
            
            //now, we're adding edit button
            //write the button action prefix here
            'edit'      => 'f_accountitem_',
            'delete'    => 'f_accountitem_',
            'dLength'   => 1,
            'initcomplete' => "accountitemTable.width('100%'); $('#accountitem_wrapper').prev().click(function(){ $(this).parent().find('.tablePars').toggle() })"
        );
        $table = $this->load->view('parts/dataTable', $tblprm, true);
        echo $this->load->view('parts/formTable', array('form'=>$form,'formname'=>'formaccount','table'=>$table,'new'=>'f_accountitem_'), true);
    }
}
?>

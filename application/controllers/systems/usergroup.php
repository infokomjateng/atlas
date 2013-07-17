<?php

class Usergroup extends MY_Controller
{
    function __construct() 
    {
        parent::__construct();
        
        $this->load->model('systems/s_usergroup_m');
    }
    
    function index()
    {
        $data['extrajs'] = array('s_usergroup');
        
        //table parameter
        $tblprm = array(
            'id'        => 'dynamic',
            'source'    => base_url() . 'systems/usergroup/listing',
            'columns'   => array('S_UserGroupName'),
            'titles'    => array('Nama'),
            
            //total column widths = 75%
            //the rest 25% has been used for the Action button
            'widths'    => array('83'),
            
            //now, we're adding edit button
            //write the button action prefix here
            'edit'      => 's_usergroup_',
            'delete'    => 's_usergroup_',
            'dLength'   => 1
        );
        
        $data['content'] = $this->load->view('parts/dataTable', $tblprm, true);
        $data['formCRUD'] = '';
        $data['tableTitle'] = 'Master Data Usergroup';
        $this->load->view('pages/masterdata', $data);
    }
    
    function form($id)
    {
        
        if ($id == 'new')
        {
            $form = array(
                array(
                    'title' => 'Data Group User',
                    'col0' => array(
                        array('label'=>'Nama','field'=>  form_input('S_UserGroupName', ''))                       
                )
                )
            );
            
        }
        else
        {
            
            $d = $this->s_usergroup_m->get($id);
            
            $form = array(
                array(
                    'title' => 'Data Group User',
                    'col0' => array(
                        array('label'=>'Nama','field'=>  form_input('S_UserGroupName', $d->S_UserGroupName)).form_hidden('UserGroupID', $d->S_UserGroupID))                        
                    )
                );
            
        }
        echo $this->load->view('parts/formCRUD', array('form'=>$form,'formname'=>'formusergroup'), true);
        
        return true;
    }
    
    function listing()
    {
        //getting param data
        list($tot_rec,$tot_disp_rec,$r) = $this->s_usergroup_m->listing($this->input,
			array("S_UserGroupName") );
        
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
        
        $i['S_UserGroupUserID'] = $this->user->UserID;
       
                
        if ($id == 'new')
        {
            if (!$this->save_validate())
            {
                echo json_encode(array('err'=>$this->form_validation->error_array(),'msg'=>  validation_errors()));
                exit;
            }
            $r = $this->s_usergroup_m->save($i);
        }
        else
        {
            if (!$this->edit_validate())
            {
                echo json_encode(array('err'=>$this->form_validation->error_array(),'msg'=>  validation_errors()));
                exit;
            }
            $r = $this->s_usergroup_m->save($i, $id);
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
        $this->form_validation->set_rules('S_UserGroupName', 'Nama', 'required');
        
        return $this->form_validation->run();
    }
    
    function edit_validate()
    {
        $this->form_validation->set_rules('S_UserGroupName', 'Nama', 'required');

        return $this->form_validation->run();
    }
    
    function delete()
    {
        $i = $this->input->post();
        $i['S_UserGroupUserID'] = $this->user->UserID;
        $i['S_UserGroupLastUpdate'] = date('Y-m-d H:i:s');
        $i['S_UserGroupIsActive'] = 'N';
        $r = $this->s_usergroup_m->save($i, $i['S_UserGroupID']);
        echo json_encode(array('rst'=>$r,'msg'=>'Data driver berhasil dihapus'));
        return;
    }
    
    }
?>

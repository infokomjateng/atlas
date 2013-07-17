<?php

class User extends MY_Controller
{
    function __construct() 
    {
        parent::__construct();
        
        $this->load->model('systems/s_user_m');
    }
    
    function index()
    {
        $data['extrajs'] = array('s_user');
        
        //table parameter
        $tblprm = array(
            'id'        => 'dynamic',
            'source'    => base_url() . 'systems/user/listing',
            'columns'   => array('S_UserName', 'S_UserUsername', 'S_UserPassword', 'S_UserGroupName'),
            'titles'    => array('Name', 'Username', 'Password', 'Group'),
            
            //total column widths = 75%
            //the rest 25% has been used for the Action button
            'widths'    => array('5', '20', '50', '10'),
            
            //now, we're adding edit button
            //write the button action prefix here
            'edit'      => 's_user_',
            'delete'    => 's_user_',
            'dLength'   => 1
        );
        
        $data['content'] = $this->load->view('parts/dataTable', $tblprm, true);
        $data['formCRUD'] = '';
        $data['tableTitle'] = 'Master Data User';
        $this->load->view('pages/masterdata', $data);
    }
    
    function form($id)
    {
        $this->load->model(array('systems/s_usergroup_m'));
        
        $usergroup_list = $this->s_usergroup_m->get_key_value('S_UserGroupID', 'S_UserGroupName');
        
        if ($id == 'new')
        {
            $form = array(
                array(
                    'title' => 'Data User',
                    'col0' => array(
                        array('label'=>'Nama','field'=>  form_input('S_UserName', '')),
                        array('label'=>'Password','field'=>  form_password('S_UserPassword', ''))
                    ),
                    'col1' => array(
                        array('label'=>'Username','field'=>  form_input('S_UserUsername', '')),
                        array('label'=>'Group','field'=>  form_dropdown('S_UserS_UserGroupID', $usergroup_list, '', 'class=\'select grid8\' style=\'\''))
						
                    )
                )
            );
            
        }
        else
        {
            
            $d = $this->s_user_m->get($id);
            
            $form = array(
                array(
                    'title' => 'Data User',
                    'col0' => array(
                        array('label'=>'Nama','field'=>  form_input('S_UserName', $d->S_UserName)).form_input('S_UserID', $d->S_UserID)),
                        array('label'=>'Group','field'=>  form_dropdown('S_UserS_UserGroupID', $usergroup_list, $d->S_UserS_UserGroupID, 'class=\'select grid8\' style=\'\''))
                    ),
                    'col1' => array(
                        array('label'=>'Username','field'=>  form_input('S_UserUsername', $d->S_UserUsername)),
                        array('label'=>'Group','field'=>  form_dropdown('S_UserS_UserGroupID', $usergroup_list, $d->S_UserS_UserGroupID, 'class=\'select grid8\' style=\'\''))
						
                    )
                );
            
        }
        echo $this->load->view('parts/formCRUD', array('form'=>$form,'formname'=>'formuser'), true);
        
        return true;
    }
    
    function listing()
    {
        //getting param data
        list($tot_rec,$tot_disp_rec,$r) = $this->s_user_m->listing($this->input,
			array("S_UserName") );
        
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
        
        $i['S_UserUserID'] = $this->user->UserID;
        $i['S_UserPassword'] = md5($i['S_UserPassword']) ;         
                
        if ($id == 'new')
        {
            if (!$this->save_validate())
            {
                echo json_encode(array('err'=>$this->form_validation->error_array(),'msg'=>  validation_errors()));
                exit;
            }
            $r = $this->s_user_m->save($i);
        }
        else
        {
            if (!$this->edit_validate())
            {
                echo json_encode(array('err'=>$this->form_validation->error_array(),'msg'=>  validation_errors()));
                exit;
            }
            $r = $this->s_user_m->save($i, $id);
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
        $this->form_validation->set_rules('S_UserUsername', 'Username', 'required');
        
        return $this->form_validation->run();
    }
    
    function edit_validate()
    {
        $this->form_validation->set_rules('S_UserUsername', 'Username', 'required');

        return $this->form_validation->run();
    }
    
    function delete()
    {
        $i = $this->input->post();
        $i['S_UserUserID'] = $this->user->UserID;
        $i['S_UserLastUpdate'] = date('Y-m-d H:i:s');
        $i['S_UserIsActive'] = 'N';
        $r = $this->s_user_m->save($i, $i['S_UserID']);
        echo json_encode(array('rst'=>$r,'msg'=>'Data driver berhasil dihapus'));
        return;
    }
    
    }
?>

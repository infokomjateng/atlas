<?php

class Password extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('systems/s_user_m');
    }
    
    function index()
    {
        $data['extrajs'] = array('m_password');
       
        $data['content'] = '';
        $data['formCRUD'] = $this->form($this->user->UserID);
        $this->load->view('pages/crudOnly', $data);
    }
    
    function form($id)
    {
        $u = $this->s_user_m->get($id);
        
        
            $form = array(
                array(
                    'title' => 'Data Pribadi',
                    'col0' => array(
                        array('label'=>'Username','field'=>  form_input('S_UserUsername', $u->S_UserUsername, 'disabled=disabled autocomplete=off') .
                                                             form_hidden('S_UserID', $u->S_UserID)),
                        array('label'=>'Nama','field'=>  form_input('S_UserName', $u->S_UserName, 'disabled=disabled autocomplete=off'))
                    ),
                    'col1' => array()
                ),
                array(
                    'title' => 'Data Password',
                    'col0' => array(
                        array('label'=>'Password Lama','field'=>  form_password('S_UserPasswordOld', '', 'autocomplete=off')),
                        array('label'=>'Password Baru','field'=> form_password('S_UserPassword', '', 'autocomplete=off')),
                        array('label'=>'(Konf) Password Baru','field'=> form_password('S_UserPasswordRe', '', 'autocomplete=off'))
                    ),
                    'col1' => array()
                )
            );
        
        
        return $this->load->view('parts/formCRUD', array('form'=>$form,'formname'=>'formdrivers'), true);
    }
}
?>

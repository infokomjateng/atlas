<?php

class Login extends MY_Controller
{
    public $err;
    
    function __construct ()
    {
        $this->isRequiredLogin = false;
        parent::__construct();
        
        $this->load->model('login_m');
        $this->err = false;
    }
    
    function index ()
    {
        if ($this->isLoggedIn())
        {
            $this->load->helper('url');
            redirect($this->Default_Route);
        }
        
        if ($this->input->post('username') && $this->input->post('password'))
        {
            if ($r = $this->login())
            {
                $this->doLogin($r);
            }
            else
            {
                //$this->err = 'anu';
            }
        }
        //print_r($this->session->all_userdata());
        $data['log'] = $this->session->userdata('username');
        $data['err'] = $this->err;
        $this->load->view('pages/login', $data);
    }
    
    private function login ()
    {
        $r = $this->login_m->login($this->input->post('username'), $this->input->post('password'));
        if (!$r)
        {
            return false;
        }
        
        return $r;
    }
    
    function logout ()
    {
        $this->session->unset_userdata('atlas');
        header('Location:' . base_url() . '/login');
    }
    
    function doLogin ($r) 
    {
        $this->session->set_userdata(array('atlas'=>array(
            'id'=>$r->S_UserID,
            'un'=>$r->S_UserUsername,
            'nm'=>$r->S_UserName,
            'br'=>$r->S_UserM_BranchCode
        )));
        
        $this->load->helper('url');
        redirect($this->Default_Route);
        //$this->load->model('app_m');
                
            //if ($r = $this->app_m->login($username, $password)) {
                    //$r->doubleLogin = false;
                    //$from = strtotime($r->UserLastLogin );
                    //$to = strtotime( date('Y-m-d H:i:s') );
                    //$diff = round(abs($to - $from) / 60,2) ;
                    //if ( $diff < 15  && $r->UserIsLoggedIn == 'Y') {
                    //        $r->doubleLogin  = true;
                    //}
                    
                    //return $r;
            //}
                
            //return false;
    }
}
?>

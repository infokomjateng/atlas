<?php

class Numberingtemp extends MY_Controller
{
    function __construct() 
    {
        parent::__construct();
        
        $this->load->model('temp/p_numberingtemp_m');
    }
    
    function notuse()
    {
        $this->p_numberingtemp_m->notuse($this->input->get('id'));
    }
}
?>

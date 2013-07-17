<?php

class Menurole extends MY_Controller
{
    function __construct() 
    {
        parent::__construct();
    }
    
    function index()
    {
        $this->load->view('pages/menurole');
    }
}
?>

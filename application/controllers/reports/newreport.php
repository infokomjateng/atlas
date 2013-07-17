<?php

class Newreport extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
    }

    function index() {
       echo $this->lang->line('menu_add');
        $dt["contents"] =  $this->load->view('pages/new_report', '', true);
     
        $this->load->view('pages/reports_new', $dt);
    }

    

}

?>

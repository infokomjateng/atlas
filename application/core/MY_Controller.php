<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class MY_Controller extends CI_Controller 
{
    public $isRequiredLogin = true;
    public $Default_Route ='masterdata/drivers';
    public $index;
    public $user;
    public $menu;
    public $salt = '5m5';
    
    public $data;
    public $My_Url;
    
    
    
    function __construct() {
        parent::__construct();
        
        $this->load->helper(array('url','form'));
        $this->load->library(array('form_validation','session'));
        $this->lang->load('menu', 'indonesia');
        //loading models
        //$this->load->model('masterdata/service_m');
        
        $this->My_Url = base_url();
        $this->Default_Route = base_url() . $this->Default_Route;
        // $this->user = $this->getCurrentUser();
        // $this->index = 'index.php/';
        
        //load breadcrumb converter config
        // $this->load->config('bhi_breadcrumb');
        
        //load numbering config
        // $this->load->config('bhi_autonumbering');
        
        //loading SERVICES
        //$r = $this->service_m->get();
       // foreach ($r as $k => $v)
       // {
        //    define("SVC_{$v['ServiceDefine']}",$v['ServiceID']);
       // }
        //$this->user->UserID = 1;
        if( !is_object( $this->user ) ) {
            $this->user = new StdClass;
        }
        if ($this->isRequiredLogin) 
        {
                //load menus
                //$this->load->config('bhi_menu');
                //$m = $this->config->item('menu');
                        
                if (!$this->isLoggedIn()) {
                    $this->session->set_userdata('curi', current_url());
                    redirect($this->My_Url . 'login');
                }
                $r = $this->session->userdata('atlas');
                $this->user->UserID = $r['id'];
                $this->user->Branch = $r['br'];
                $this->user->UserUn = $r['un'];
                $this->user->UserNm = $r['nm'];
        }
        
        //loading menu
        $this->load->model('masterdata/m_menu_m');
        $this->menu = $this->m_menu_m->get_level_0();
    }
    
    function isLoggedIn () {
            if ($this->session->userdata('atlas')) {
                    $r = $this->session->userdata('atlas');
                    
                    return true;                    
            }
            
            return false;
    }
    
    function getCurrentUser () 
    {
            if (!$this->isLoggedIn())
                    return false;

            $s = $this->session->userdata('userlog');
            $this->load->model('app_m');
            return $this->app_m->get($s->UserID);
    }
    
    /**
     * Reports PDF
     */
    public function tbl_header($pdf, $columns){
            //initiating columns
            $w = array();
            $c = array();
            $a = array();
            $f = array();
            $no_f = array();
            
            foreach ($columns as $k => $v)
            {
                //column name
                array_push($c, $v['column']);
                
                //column width
                array_push($w, $v['width']);
                
                //column align
                array_push($a, $v['align']);
                
                //others
                array_push($f,true);
                array_push($no_f,false);
            }
            //A4 portrait width = 190 mm
            $pdf->setAligns($a);
            $pdf->SetFont('Arial','B',10);
            $pdf->setWidths($w);
            $pdf->setFills($f);
            $dt = $c;
            $pdf->row($dt);

            $pdf->setFills($no_f);
            $pdf->setAligns($a);
            $pdf->SetFont('Arial','',10);

    }
    
    public function header_starterkit($pdf, $title)
    {
            //A4 portrait width = 190 mm
            $pdf->SetFont('Arial','B',16);
            $pdf->Cell(190,10,$title,0,1,'C');
            $pdf->Ln(3);
            
    }
    public function footer_starterkit($pdf){
            $pdf->setY(-20);

            $pdf->SetFont('Arial','I',7);
            $pdf->Cell(190,0.2,'','B',1,'R');
            $page_no = $pdf->PageNo();
            $pdf->Cell(194,7,"Page $page_no of {nb}",'',1,'R');

    }
    
    //REPORT RAW PRINTING
    function headerSans($str, $arr, $bold = true, $big = true, $chperline = 80)
    {
        $f = 0;
        $f += $big == true ? 20 : 0;
        $f += $bold == true ? 8 : 0;
        
        if ($f < 10) $f = '0' . $f;
        
        array_push($arr, "\x1B\x40");
        array_push($arr, "\x1B\x21\x$f");
        $e = explode('|', $str);
        foreach ($e as $k => $v)
        {
            array_push($arr, $v . " \r\n");
        }
        array_push($arr, "\x1B\x21\x01");
        array_push($arr, str_repeat('=', $chperline) . " \r\n");
        
        return $arr;
    }
    
}
?>
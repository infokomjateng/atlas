<?php

class Menu extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('masterdata/m_menu_m');
    }
    
    function get_level_1($rel)
    {
        $r = $this->m_menu_m->get_level_1($rel);
        if (!$r)
            return false;
        
        $s = <<<EOF
            <ul class="leftUser" style="display: block !important;">
EOF;
        foreach ($r as $k => $v)
        {
            $s .= '<li><a class="sProfile" title="" href="' . base_url() . $v['M_MenuUrl'] . '">' . $v['M_MenuName'] . '</a></li>';
        }
        $s .= '</ul>';
        
        echo $s;
        return true;
    }
}
?>

<?php

class Menu extends MY_Controller
{
    function __construct ()
    {
        
    }
    
    function test ()
    {
        echo <<<EOF
            <ul class="leftUser" style="display: block !important;">
                <li><a class="sProfile" title="" href="#">My profile</a></li>
                <li><a class="sMessages" title="" href="#">Messages</a></li>
                <li><a class="sSettings" title="" href="#">Settings</a></li>
                <li><a class="sLogout" title="" href="#">Logout</a></li>
            </ul>
EOF;
    }
}
?>

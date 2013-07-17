<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><!-- saved from url=(0042)http://demo.kopyov.com/aquincum/forms.html -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <?= $this->load->view('basics/header') ?>

<body>

        <!-- Style switcher -->

<!-- Top line begins -->
<?= $this->load->view('basics/topbar') ?>
<!-- Top line ends -->


<!-- Sidebar begins -->
<div id="sidebar">

	<!-- Main nav -->
    <?= $this->load->view('basics/mainnav') ?>
    
    <!-- Secondary nav -->
    <?= isset($secnav)?$secnav:$this->load->view('parts/regsecnav') ?>
</div>
<!-- Sidebar ends -->


<!-- Content begins -->
<div id="content">
    <div class="contentTop">
        <span class="pageTitle"><span class="icon-link"></span><?=isset($pagetitle)?$pagetitle:'Untitled'?></span>
        <ul class="quickStats">
            <!--<li>
                <a href="" class="blueImg"><img src="<?= base_url() ?>includes/images/icons/quickstats/plus.png" alt="" /></a>
                <div class="floatR"><strong class="blue">5489</strong><span>visits</span></div>
            </li>-->
            
        </ul>
    </div>
    
    <!-- Breadcrumbs line -->
    
    
    <!-- Main content -->
    <div class="wrapper">
        
    
        <form action="" class="main" method="post" id="defaultform">
            
                    <?php
                    foreach ($form as $k => $v)
                    {
                        
                        echo <<<EOF
            <fieldset>
                <div class="fluid" style="margin-top:5px !important">
                        <div class="widget grid12">
                    <div class="whead"><h6>{$v['title']}</h6></div>        
EOF;
                        foreach ($v['data'] as $kk => $vv)
                        {
                            if (isset($vv['type']) && $vv['type'] == 'freeform')
                            {
                                
                                    echo <<<EOF
                                        
                                            {$vv['freeform']}
                                        
EOF;
                                    continue;
                                
                            }
                            else
                            {
                                echo <<<EOF
                    <div class="formRow">
                        <div class="grid3"><label>{$vv['label']}</label></div>
                        <div class="{$vv['frame']}">{$vv['field']}</div>
                    </div>    
EOF;
                            }
                             
                        }    
                        
                        echo <<<EOF
   </div>
                </div>
            </fieldset>
EOF;
                    }
                    ?>
                    
               

            
    
            
        
            <fieldset>
                <div class="widget fluid" style="margin-top:5px !important">
                    <div class="formRow noBorderB">
                        <?php
                        //buttons
                        
                        $a = isset($submitbtn_action)?$submitbtn_action:'save_new()';
                        $init_btn = array('class'=>'buttonM bBlack', 'value'=>'Submit', 'click'=>$a);
                        
                        if (isset($buttons))
                            array_push ($buttons, $init_btn);
                        else
                            $buttons = array($init_btn);
                        
                        for ($i = sizeof($buttons); $i > 0; $i--)
                        {
                            $v = $buttons[$i-1];
                            echo <<<EOF
                                <a href="javascript:;" class="{$v['class']}" onclick='{$v['click']}' style='margin-left:3px;float:right'>{$v['value']}</a>
EOF;
                        }
                        ?>
                        
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>
<!-- Content ends -->  
<?= isset($dialogs) ? $dialogs : '' ?>         
</body>
</html>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?= $this->load->view('main/header') ?>
<body>

<?= $this->load->view('main/topbar') ?>
<?= $this->load->view('main/sidebar') ?>


<!-- Content begins -->
<div id="content">
    <!-- Breadcrumbs line -->
    <!-- Main content -->
    <div class="wrapper" style="margin: 0px 5px">
        
            <div id="tab-container" class="widget grid12 tab-container" style="margin-top:5px">       
                <ul class="tabs">
                    <li class="selector"><a href="#tabb2"><?=isset($tab1title)?$tab1title:'Untitled'?></a></li>
                    <li class="selector"><a href="#tabb1"><?=isset($tab2title)?$tab2title:'Untitled'?></a></li>
                </ul>

                <div class="tab_container" style="height: auto !important">
                    <div id="tabb1" class="tab_content">
                        <div class="widget" style="margin-top:15px !important">
                            <div class="whead" style="overflow:hidden"><h6>Table</h6><a style="float: right; margin:5px 50px 0px" class="buttonS bDefault" href="javascript:;" onclick="formNew()"><span class="icos-books2" style="padding:0px 5px 0px 0px"></span> Tambah Data</a></div>
                            
                            <div id="dyn" class="hiddenpars">

                                <a class="tOptions" title="Options"><img src="<?= base_url() ?>includes/images/icons/options" alt="" /></a>
                                <?= isset($content) ? $content : '' ?>

                            </div>
                        </div>           
                    </div>
                    <div id="tabb2" class="tab_content">
                         <?= $formCRUD ?>
                    </div>
                </div>
             
                <div class="clear"></div>		 
            </div>
        
        <!-- Table with hidden toolbar -->
        
    
        <!-- Table with opened toolbar -->
        
        
    </div>
</div>
<!-- Content ends -->  
        
</body>
</html>
<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

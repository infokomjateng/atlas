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
        
            <div class="widget grid12" style="margin-top:5px">       
                
<?= isset($applet) ? $applet : '' ?>
                
                            <div class="whead" style="overflow:hidden"><h6><?= isset($tabletitle) ? $tabletitle : 'Untitled' ?></h6><a style="float: right; margin:5px 50px 0px" class="buttonS bDefault" href="javascript:;" onclick="formNew()"><span class="icos-books2" style="padding:0px 5px 0px 0px"></span> Tambah Data</a></div>
                            
                            <div id="dyn" class="hiddenpars">

                                <a class="tOptions" title="Options"><img src="<?= base_url() ?>includes/images/icons/options" alt="" /></a>
                                <?= isset($content) ? $content : '' ?>

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

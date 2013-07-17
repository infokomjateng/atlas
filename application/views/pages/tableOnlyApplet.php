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
                
<applet name="jzebra" code="jzebra.PrintApplet.class" archive="../includes/js/others/jzebra.jar" width="0px" height="0px">
      <!-- Optional, searches for printer with "zebra" in the name on load -->
      <!-- Note:  It is recommended to use applet.findPrinter() instead for ajax heavy applications -->
      <param name="printer" value="zebra">
      <!-- ALL OF THE CACHE OPTIONS HAVE BEEN REMOVED DUE TO A BUG WITH JAVA 7 UPDATE 25 -->
	  <!-- Optional, these "cache_" params enable faster loading "caching" of the applet -->
      <param name="cache_option" value="plugin">
      <!-- Change "cache_archive" to point to relative URL of jzebra.jar -->
      <param name="cache_archive" value="../includes/js/others/jzebra.jar">
      <!-- Change "cache_version" to reflect current jZebra version -->
      <param name="cache_version" value="1.4.9.1">
   </applet>
                
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

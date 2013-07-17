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

</div>
<!-- Sidebar ends -->


<!-- Content begins -->
<div id="content">
    <div class="contentTop">
        <span class="pageTitle"><span class="icon-loop_alt1"></span><?= isset($pagetitle) ? $pagetitle : 'Untitled Table' ?></span>
        <ul class="quickStats">
            <li>
                <a href="javascript:;" class="blueImg" onclick="<?=$new . 'add()'?>"><img src="<?= base_url() ?>includes/images/icons/quickstats/plus.png" alt="" /></a>
                <div class="floatR"><strong class="blue">Tambah</strong><span><?=$tabletitle?></span></div>
            </li>
            
        </ul>
    </div>
    
    <!-- Breadcrumbs line -->
    
    
    <!-- Main content -->
    <div class="wrapper">
        
    
    	<!-- Table with hidden toolbar -->
        <div class="widget" style="margin-top:15px !important">
            <div class="whead"><h6><?=$tabletitle?></h6></div>
            
            <div id="dyn" class="hiddenpars">
                
                <a class="tOptions" title="Options"><img src="<?= base_url() ?>includes/images/icons/options" alt="" /></a>
                <?= $table ?>
                
            </div>
        </div> 
    
        <!-- Table with opened toolbar -->
        
    
        <!-- Table with always visible toolbar -->
        
    </div>
    <!-- Main content ends -->
    
</div>
<!-- Content ends -->  
<?= isset($dialogs) ? $dialogs : '' ?>       
</body>
</html>



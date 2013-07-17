<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?= $this->load->view('main/header') ?>
<body>

<!-- Top line begins -->
<div id="top">
	<div class="wrapper">
    	<a href="#" title="" class="logo"><img src="<?= base_url() ?>includes/images/logo.png" alt="" /></a>
        <div class="clear"></div>
    </div>
</div>
<!-- Top line ends -->


<!-- Login wrapper begins -->
<div class="loginWrapper">
<?= $log . '<br />' ?>
<?= $err == false ? '' : $err ?>
	<!-- Current user form -->
    <form action="" id="login" method="post">
        <div class="loginPic">
            <a href="#" title=""><img src="images/userLogin.png" alt="" /></a>
            <span>~ Login ~<br />Masukkan Username dan Password Anda</span>
            
        </div>
        
        <input type="text" name="username" placeholder="Masukkan Username anda" class="loginEmail" />
        <input type="password" name="password" placeholder="Masukkan Password anda" class="loginPassword" />
        
        <div class="logControl">
            <div class="memory"><input type="checkbox" checked="checked" class="check" id="remember1" /><label for="remember1">Remember me</label></div>
            <input type="submit" name="submit" value="Login" class="buttonM bBlue" />
            <div class="clear"></div>
        </div>
    </form>
</div>
<!-- Login wrapper ends -->

</body>
</html>

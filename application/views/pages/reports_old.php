<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <?= $this->load->view('main/header') ?>
    <body>

        <?= $this->load->view('main/topbar') ?>
        <?= $this->load->view('main/sidebar') ?>
        <!-- Content begins -->
        <div id="content">
            
            <div class="wrapper">
                <form action="" class="main" method="post" id="defaultform">
                    <div>
                        <object data="<?= isset($form) ? $form : '' ?>" type="application/pdf" width="100%" height="600">
                            alt : <a href="test.pdf">test.pdf</a>
                        </object>
                    </div>
                </form>
            </div>
        </div>
        <!-- Content ends -->  
        <?= isset($dialogs) ? $dialogs : '' ?>         
    </body>
</html>

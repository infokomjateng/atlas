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
                <ul class="tabs">
                    <li><a href="#tabb1">Tab active</a></li>
                    <li><a href="#tabb2">Tab inactive</a></li>
                </ul>

                <div class="tab_container">
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
                        
                        <form name="purchasingdetail">
                            <fieldset style="overflow: hidden">
                                
                            
                        <div class="fluid widget" style="margin-top:15px !important">
                            
                            <form style="" name="formspj" onsubmit="return false" class="main" action="">
                            <fieldset style="overflow:hidden">
                                <div style="padding:5px" class="fluid">
                                    <div style="margin-top:5px" class="grid12">
                                        <div class="fluid">
                                            <div style="margin-left:0px" class="grid6">
                                                <div class="fluid">
                                                    <div class="formRow">
                                                        <div class="grid3"><label>Nama Barang</label></div>
                                                        <div class="grid6">
                                                            <?= form_input('T_PurchasingDetailM_SparePartsName', '', 'autocomplete=off') ?>
                                                            <?= /*form_dropdown('T_PurchasingDetailM_SparePartsCode', array(''=>''), '', 'class=select style=width:100% onchange="get_info_price($(this).val())"')*/'' ?>
                                                        </div>
                                                        <div class="grid3">
                                                            <?= form_input('T_PurchasingDetailM_SparePartsCode', '', 'autocomplete=off readonly=readonly') ?>
                                                        </div>
                                                        <div class="clear"></div>
                                                    </div>
                                                    <div class="formRow noBorderB">
                                                        <div class="grid3"><label>Qty</label></div>
                                                        <div class="grid2"><input type="text" name="T_PurchasingDetailQty" class="maskNum rtl-inputf" /></div>
                                                        <div class="clear"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="grid6">
                                                <div class="fluid">
                                                    <div class="formRow">
                                                        <div class="grid3"><label>Harga</label></div>
                                                        <div class="grid3">
                                                            <input type="text" name="T_PurchasingDetailPrice" class="maskNum rtl-inputf" />
                                                        </div>
                                                        <div class="clear"></div>
                                                    </div>
                                                    <div class="formRow noBorderB">
                                                        <div class="grid3"><label>Discount</label></div>
                                                        <div class="grid9">
                                                            <div class="grid2">
                                                                <input type="text" name="T_PurchasingDetailDiscount1" class="maskNum rtl-inputf" />
                                                            </div>
                                                            <div class="grid2">
                                                                <input type="text" name="T_PurchasingDetailDiscount2" class="maskNum rtl-inputf" />
                                                            </div>
                                                            <div class="grid2">
                                                                <input type="text" name="T_PurchasingDetailDiscount3" class="maskNum rtl-inputf" />
                                                            </div>
                                                            <div class="grid6">
                                                                <a class="buttonS bGreen " href="javascript:;" style="float:right" onclick="add_item($('input[name=T_PurchasingDetailM_SparePartsCode]').val())">Tambah</a>
                                                            </div>
                                                        </div>
                                                        <div class="clear"></div>
                                                    </div>
                                                    
                                                </div>
                                                
                                            </div>
                                            
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                            </fieldset>    
                        </form>
                            
                            <table cellpadding="0" cellspacing="0" width="100%" class="tDefault" id="purchaseTable">
                                <thead>
                                    <tr>
                                        <td width="30">No</td>
                                        <td>Kode / Nama Barang</td>
                                        <td width="50">Qty</td>
                                        <td>Harga</td>
                                        <td width="50">Disc 1</td>
                                        <td width="50">Disc 2</td>
                                        <td width="50">Disc 3</td>
                                        <td>Jumlah</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>   
                        </fieldset>
                        </form>
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

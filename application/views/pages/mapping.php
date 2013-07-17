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
                        <li><a href="#tabb1">Hasil mapping</a></li>
                        <li><a href="#tabb2">Mapping kendaraan</a></li>
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
                            <div class="fluid">
                                <div class="grid5">
                                            <?= $left ?>
                                </div>
                                <div class="grid2">b</div>
                                <div class="grid5">c</div>
                            </div>
                            <fieldset>
                                <div class="widget" style="margin-top:0px">
                                    <div class="formRow">
                                        <?= form_dropdown('FleetMapDriversCode', $master, '', 'class=select') ?>
                                    </div>
                                </div>
                                <div class="widget" style="margin-top:0px">
                                    <div class="body">
                                        <div class="leftBox">
                                            <input type="text" id="box1Filter" class="boxFilter" placeholder="Filter entries..." /><button type="button" id="box1Clear" class="dualBtn fltr">x</button><br />

                                            <select id="box1View" multiple="multiple" class="multiple" style="height:300px;">
                                                
                                            </select>
                                            <br/>
                                            <span id="box1Counter" class="countLabel"></span>

                                            <div class="displayNone"><select id="box1Storage"></select></div>
                                        </div>

                                        <div class="dualControl">
                                            <button id="to2" type="button" class="dualBtn mr5 mb15">&nbsp;&gt;&nbsp;</button>
                                            <button id="allTo2" type="button" class="dualBtn">&nbsp;&gt;&gt;&nbsp;</button><br />
                                            <button id="to1" type="button" class="dualBtn mr5">&nbsp;&lt;&nbsp;</button>
                                            <button id="allTo1" type="button" class="dualBtn">&nbsp;&lt;&lt;&nbsp;</button>
                                        </div>

                                        <div class="rightBox">
                                            <input type="text" id="box2Filter" class="boxFilter" placeholder="Filter entries..." /><button type="button" id="box2Clear" class="dualBtn fltr">x</button><br />
                                            <select id="box2View" multiple="multiple" class="multiple" style="height:300px;">
                                                
                                            </select>
                                            <br/>
                                            <span id="box2Counter" class="countLabel"></span>

                                            <div class="displayNone"><select id="box2Storage"></select></div>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                            </fieldset>
                            <?= ''; //$formCRUD ?>
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

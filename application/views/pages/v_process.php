<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><!-- saved from url=(0042)http://demo.kopyov.com/aquincum/forms.html -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <?= $this->load->view('basics/v_header') ?>

    <body>

        <!-- Style switcher -->



        <!-- Top line begins -->
        <?= $this->load->view('basics/v_topbar') ?>
        <!-- Top line ends -->


        <!-- Sidebar begins -->
        <div id="sidebar">

            <!-- Main nav -->
            <?= $this->load->view('basics/v_mainnav') ?>

            <!-- Secondary nav -->

        </div>
        <!-- Sidebar ends -->
        <div id="content">
            <div class="contentTop">
                <span class="pageTitle"><span class="<?= isset($icontitle) ? $icontitle : '' ?>"></span><?= isset($pagetitle) ? $pagetitle : 'Untitled Table' ?> <span id="datenow"><?= isset($date) ? $date : '' ?></span></span> 
                <?= isset($contentTopRight) ? $contentTopRight : '' ?>
            </div>

            <!-- Breadcrumbs line -->


            <!-- Main content -->
            <div class="wrapper">

                <!-- Content begins -->

                <div class="clear"></div>
                <div class="fluid">
                    <script>
<?php if (isset($sel_tab)) : ?>
                                var p_inital_tab = '<?= $sel_tab ?>';
<?php endif; ?>
                    </script>
                    <div id="tab-container" class="tab-container widget grid12 xbox">
                        <ul class="tabs">
                            <li class="selector">
                                <a href="#tabbSampling" init="0">Sample System</a>
                            </li>
                            <li class="selector">
                                <a href="#tabbSampleDistribution" init="0">Sample Distribution</a>
                            </li>
                            <li class="selector">
                                <a href="#tabbWorkList" init="0">Work List</a>
                            </li>
                            <li class="selector">
                                <a href="#tabbEntryResult" init="0">Result Entry</a>
                            </li>
                            <li class="selector">
                                <a href="#tabb5" init="0">Sample Storage</a>
                            </li>
                            <li class="selector">
                                <a href="#tabb6" init="0">View Storage</a>
                            </li>
                            <li class="selector">
                                <a href="#tabbPrintResult" init="0">Print Result</a>
                            </li>
                        </ul>
                        <div id="tabbSampling" class="tab_content" style="display: block;"> 

                            <div class="clear"></div>
                            <div class="fluid">
                                <div  class="stripe"></div>
                                <div class="understripepro widget fluid">
                                    <div style ="margin-top:-8px;" class="formRow">
                                        <span style="font-weight:bold;" class="grid1">Date :</span>
                                        <span style="width:15%;margin-left:-15px" class="grid3"><input style="width:60%!important;"  placeholder="yyyy-mm-dd" type="text"  name="q_s_date" id="q_s_date" class="searchLine datepicker" onchange="samplingpatientTable.fnDraw()" /></span>
                                        <span style="font-weight:bold;" class="grid1">Search :</span>
                                        <span style="margin-left:0px;margin-right:5%"class="grid3"><input id="q_s_labno"  type="text" placeholder="Name / No. Lab" name="q_s_labno" class="searchLine" onchange="samplingpatientTable.fnDraw()" /></span>
                                    </div>
                                </div>
                                
                                <div class="fluid">
                                    <div class="grid12 mt10">
                                            <div class="grid6 widget mt0" style="padding:5px">
                                                <div class="grid3 pl10">
                                                    <img  style="margin-right:1%" id="foto" src="<?= base_url() ?>includes/images/profile.png" alt="" />
                                                    <div class="clear"></div>
                                                    <a class="buttonM bGreyish Bcenter" href="#"  style="margin:4px 0px;padding:8px 3px;width:110px!important;">
                                                        <span style="font-size:8pt;margin-left:0px;">Historical</span>
                                                    </a>
                                                    <div class="clear"></div>
                                                    <img id="barcode"  alt="" src="<?= base_url() ?>includes/images/barcode6.png" style="border: 3px solid #5E6779 !important;" />
                                                </div>
                                                
                                                <div class="widget grid9 leftSide" style="margin-top:0px;" >
                                                    <div class="whead"><h6>Data Patients</h6>
                                                    </div>
                                                    <div id="dynDP" class="hiddenpars">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="grid6 widget mt0" style="padding:5px">
                                                <div class="fluid">
                                                    <div class="grid3">Doctor<span class="floatR">:</span></div>
                                                    <div class="grid9" id="samplingDetailDoctor">&nbsp;</div>
                                                </div>
                                                <div class="fluid">
                                                    <div class="grid3">Diagnose<span class="floatR">:</span></div>
                                                    <div class="grid9" id="samplingDetailNote">&nbsp;</div>
                                                </div>
                                                <div class="fluid mt10">
                                                    <div class="grid12 widget mt0">
                                                        <div class="whead"><h6>Details Tests</h6></div>
                                                        <div id="dynDT" class="hiddenpars">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                                <div  style="padding-left: 50px;margin-top:20px;margin-bottom:-10px;margin-left:0px;" class="widget  grid12 sbox ">
                                    <div class="body mb5" align="center" style="padding-top:0px">
                                        <div style="padding:5px;border-top:0px;border-bottom:0px;" class="formRow block grid12 noBottom" id="samples">
                                        </div>
                                        <div class="clear"></div>
                                    </div>            

                                </div>
                            </div>

                        </div>
                        <div id="tabbSampleDistribution" class="tab_content" style="display: block;"> 
                            <div class="clear"></div>
                            <div class="fluid">
                                <div  class="stripe"></div>
                                <div class="understripepro widget fluid">
                                    <div style ="margin-top:-8px;" class="formRow">
                                        <span style="font-weight:bold;" class="grid1">Date :</span>
                                        <span style="width:15%;margin-left:-15px" class="grid3"><input style="width:60%!important;"  placeholder="yyyy-mm-dd" type="text"  name="q_d_date" id="q_d_date" class="searchLine datepicker" onchange="sampledistributionTable.fnDraw()" /></span>
                                        <span style="font-weight:bold;" class="grid1">Search :</span>
                                        <span style="margin-left:0px;margin-right:5%"class="grid3"><input id="q_d_labno"  type="text" placeholder="Name / No. Lab" name="q_d_labno" class="searchLine" onchange="sampledistributionTable.fnDraw()" /></span>
                                        <span style="width:8%;margin-left:0px;" class="grid2">Sample Type :</span>
                                        <span style="margin-left:6px" class="grid3">
                                            <?php  $sampletypelist[0] = 'ALL'; ?>
                                            <?= form_dropdown('q_d_sampletype', $sampletypelist, '0', 'class=select style="width:100%;margin-left:10px;" id=q_d_sampletype onchange=sampledistributionTable.fnDraw()') ?>
                                        </span>      
                                    </div>
                                </div>

                                <div style="margin-top:10px;margin-left:0px;" class="widget block grid12">

                                    <div class="widget grid12" style="margin-top:0px;" >
                                        <div class="whead"><h6>Data Patients</h6>
                                        </div>
                                        <div id="dynSD" class="hiddenpars">
                                        </div>
                                    </div>
                                    <!-- Standard table -->
                                    <!--<div class="whead"><h6>Sample Distribution Table</h6><div class="clear"></div></div>-->
                                    <!--<div style="overflow-y:auto!important;"  class="scrollleft">
                                        <table style="border-bottom:1px solid #DFDFDF;" cellpadding="0" cellspacing="0" width="100%" class="tDefault">
                                            <thead>
                                                <tr>
                                                    <td style="width:5%">No</td>
                                                    <td style="width:15%">No. Lab</td>
                                                    <td style="width:15%">Name</td>
                                                    <td style="">Sample Type</td>
                                                </tr>
                                            </thead>
                                            <tbody id="dstablelist">
                                                <tr class="datarow">
                                                    <td ></td>
                                                    <td ></td>
                                                    <td ></td>
                                                    <td >
                                                        <button style="width:50px;height:50px;" class="bsamplegreen">EDTA</button>
                                                        <button style="width:50px;height:50px;"class="bsampleyellow">Serum</button>
                                                        <button style="width:50px;height:50px;"class="bsamplered">Heparin</button>
                                                        <button style="width:50px;height:50px;"class="bsamplegreen">FLUOR</button>
                                                        <button style="width:50px;height:50px;"class="bsampleyellow">Serum</button>
                                                        <button style="width:50px;height:50px;"class="bsamplered">Heparin</button>
                                                        <button style="width:50px;height:50px;"class="bsamplegreen">FLUOR</button>
                                                        <button style="width:50px;height:50px;" class="bsamplegrey">EDTA</button>
                                                        <button style="width:50px;height:50px;"class="bsampleyellow">Serum</button>
                                                        <button style="width:50px;height:50px;"class="bsamplered">Heparin</button>

                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table> 
                                    </div>-->
                                </div>
                            </div>
                        </div>
                        <div id="tabbWorkList" class="tab_content" style="display: block;"> 

                            <div class="clear"></div>
                            <div class="fluid">
                                <div  class="stripe"></div>
                                <div class="understripepro widget fluid">
                                    <div class="formRow noBorderB" style="margin-top:-8px;">
                                        <span class="grid1" style="font-weight:bold;">Date :</span>
                                        <span class="grid2" style="width:10%;margin-left:-15px"><input type="text" rule="textbox" class="searchLine datepicker" onchange="processworklistTable.fnDraw()" id="wl_date" name="wl_date" value="<?=date('Y-m-d')?>" placeholder="yyyy-mm-dd" style="width:100%!important;" size="10"><span class="ui-datepicker-append">(yyyy-mm-dd)</span></span>
                                        <span class="grid1" style="margin-left:5%;font-weight:bold;">Search :</span>
                                        <span class="grid2" style="margin-left:0px;"><input type="text" rule="textbox" class="searchLine" onkeyup="processworklistTable.fnDraw()" name="wl_name" placeholder="Name / No. Lab" id="wl_name"></span>
                                        <span class="grid1" style="font-weight:bold;margin-left:5%;">Worklist :</span>
                                        <span style="margin-left:16px" class="grid2">
                                            <?php // $worklist_list[0] = 'ALL'; ?>
                                            <?= form_dropdown('wl_id', $worklist_list, '1', 'class=select style="width:100%;margin-left:10px;" id=wl_id onchange=processworklistTable.fnDraw()') ?>
                                        </span>
                                        <span class="grid1" style="margin-left:5%;font-weight:bold;">Status :</span>
                                        <span style="margin-left:6px" class="grid2">
                                            <select style="width:100%;"  id ="wl_status" onchange="processworklistTable.fnDraw()" class="select" tabindex="2">
                                                <option value="all">All</option> 
                                                <option value="notvalidation">Pending</option> 
                                                <option value="validation1">Done</option> 
                                            </select>
                                        </span>    
                                    </div>
                                </div>
                                
                                <div class="widget" style="margin-top:10px !important; overflow: hidden">
                                
                                <div class="whead"><h6>Worklist</h6>
                                    <div class="breadLinks" style="margin-right:39px !important">
                                        <ul><li onclick="p_worklist_add()"><a title="" href="javascript:;" style="padding:7px 5px 8px"><i class="icos-trolly" style="margin:-2px 5px"></i><span>Print</span> <strong>&nbsp;</strong></a></li></ul>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                                <div id="dynWL" class="hiddenpars">
                                    <a class="tOptions" title="Options"><img src="<?= base_url() ?>includes/images/icons/options" alt="" /></a>
                                </div>
                            </div>

                                                           
                            </div>
                        </div>
                        <div id="tabbEntryResult" class="tab_content" style="display: block;"> 
                            <div class="clear"></div>
                            <div class="fluid">
                                <div  class="stripe"></div>
                                <div class="understripepro widget fluid">
                                    <div style ="margin-top:-8px;" class="formRow">
                                        <span style="font-weight:bold;" class="grid1">Date :</span>
                                        <span style="width:15%;margin-left:-15px" class="grid3"><input style="width:60%!important;"  placeholder="yyyy-mm-dd" type="text"  name="d_d_date" id="d_d_date" class="searchLine datepicker" /></span>
                                        <span style="font-weight:bold;" class="grid1">Search :</span>
                                        <span style="margin-left:0px;margin-right:5%"class="grid3"><input id="d_d_name"  type="text" placeholder="Test" name="d_d_name" class="searchLine" /></span>
                                        <span style="font-weight:bold;" class="grid1">Status :</span>
                                        <span style="margin-left:0px" class="grid3">
                                            <select style="width:100%;margin-left:10px;" data-placeholder="Payment Status" class="select" tabindex="2">
                                                <option value=""></option> 
                                                <option value="1">Lunas</option> 
                                                <option value="2">Belum Lunas</option> 
                                            </select>
                                        </span>
                                    </div>
                                </div>
                                <div style="padding:2%;margin-top:10px;" class="widget fluid">
                                    <div style="border-bottom: 0px solid #DDDDDD; padding:0px" class="formRow grid12" >
                                        <div class="grid6">
                                            <div class="fluid mb5">
                                                <div class="grid2">No Lab<span class="floatR">:</span></div>
                                                <div class="grid4"><input type="text" name="T_OrderHeaderLabNumber" disabled="disabled" /><input type="hidden" name="T_OrderHeaderID" value="" /></div>
                                                <div class="grid2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MR<span class="floatR">:</span></div>
                                                <div class="grid3"><input type="text" name="M_PatientNoReg" disabled="disabled" /></div>
                                            </div>
                                            <div class="fluid mb5">
                                                <div class="grid2">Name<span class="floatR">:</span></div>
                                                <div class="grid9"><input type="text"  name="M_PatientName" disabled="disabled" /></div>
                                            </div>
                                            <div class="fluid mb5">
                                                <div class="grid2">Phone<span class="floatR">:</span></div>
                                                <div class="grid9"><input type="text" name="M_PatientHP" disabled="disabled" /></div>
                                            </div>
                                            <div class="fluid">
                                                <div class="grid2">Address<span class="floatR">:</span></div>
                                                <div class="grid9"><textarea rows="2" cols="" name="M_PatientAddress" class="auto" style="overflow: hidden;" disabled="disabled"></textarea></div>
                                            </div>
                                        </div>
                                        <div class="grid6">
                                            <div class="fluid mb5">
                                                <div class="grid2">Doctor<span class="floatR">:</span></div>
                                                <div class="grid9"><input type="text" name="M_DoctorName" disabled="disabled" /></div>
                                            </div>
                                            <div class="fluid mb5">
                                                <div class="grid2">Patient Type<span class="floatR">:</span></div>
                                                <div class="grid9"><input type="text" name="M_PatientTypeName" disabled="disabled" /></div>
                                            </div>
                                            <div class="fluid mb5">
                                                <div class="grid2">Result Type<span class="floatR">:</span></div>
                                                <div class="grid9"><input type="text" name="T_ResultTypeName" disabled="disabled" /></div>
                                            </div>
                                            <div class="fluid">
                                                <div class="grid2">Diagnose<span class="floatR">:</span></div>
                                                <div class="grid9"><textarea rows="2" cols="" name="T_OrderHeaderNote" class="auto" style="overflow: hidden;" disabled="disabled"></textarea></div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="clear"></div>
                                <div  style="margin-left:0px;border-top: 0px solid #DDDDDD;border-bottom: 0px solid #DDDDDD;padding:10px 0px 0px 0px" class="formRow grid12">
                                    <span style="width:100%;eight:60px!important; display:none" class="grid12 sPayment sPaymentGreen" id="paymentstatus"> STATUS LUNAS</span>
                                </div>
                                <!--<div  style="margin-left:0px;border-top: 0px solid #DDDDDD;border-bottom: 0px solid #DDDDDD;padding:10px 0px 0px 0px" class="formRow grid12">
                                    <span  style="width:100%;eight:60px!important;" class="grid12 sPaymentRed"> STATUS BELUM LUNAS</span>
                                </div>-->
                                <div  style="margin-left:0px;border-top: 0px solid #DDDDDD;padding:10px 0px 0px 0px" class="formRow grid12">
                                    <!-- Table with checkboxes -->
                                    <div style="overflow:auto;  height:170px; border: 1px solid #CDCDCD;">
                                        <div class="widget zbox">
                                            <div style="margin-bottom:0px;" class="whead grid12"><span class="titleIcon check"><input type="checkbox" id="titleCheck" name="titleCheck" onchange="var a = $('tbody#testlist').find('input:checkbox[name^=resultrow]'); if ($(this).is(':checked')) { a.attr('checked','checked') } else { a.removeAttr('checked') } $.uniform.update('input:checkbox')" /></span><h6>Static table with checkboxes</h6><a href="javascript:re_delete()" ><span class="icos-trash" style="float:right;margin:10px 10px 0px 10px; "></span></a><div class="clear"></div>
                                                <table   cellpadding="0" cellspacing="0" width="100%" class="tDefault checkAll check" id="checkAll">
                                                    <thead>
                                                        <tr>
                                                            <td></td>
                                                            <td style="width:20px">Status</td>
                                                            <td>Test</td>
                                                            <td style="width:14%">Result</td>
                                                            <td style="width:20%">Normal Value</td>
                                                            <td style="width:10%">Unit</td>
                                                            <td style="width:25%">Note</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="testlist" >
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="clear"></div>
                                <div align="center" style="margin-left:0px;border-bottom: 0px solid #DDDDDD;" class="formRow block grid12">
                                    <div class="grid2">
                                        <span class="grid12"><a  class="buttonM bGreen Bcenter" href="javascript:re_val1()">VALIDATE</a></span>
                                    </div>
                                    <!--<div class="grid2">
                                        <span class="grid12"><a  class="buttonM bGreyish Bcenter" href="#">HYSTORICAL</a></span>
                                    </div>-->
                                    <div class="grid2">
                                        <span class="grid12"><a  class="buttonM bRed Bcenter" href="#">RERUN</a></span>
                                    </div>
                                    <div class="grid2">
                                        <span class="grid12"><a  class="buttonM bLightBlue Bcenter" href="javascript:re_save()">SAVE</a></span>
                                    </div>
                                    <div class="grid2">
                                        <span class="grid12"><a  class="buttonM bBlue Bcenter" href="javascript:get_prev();">PREVIOUS</a></span>
                                    </div>
                                    <div class="grid2">
                                        <span class="grid12"><a  class="buttonM bBlue Bcenter" href="javascript:get_next();">NEXT</a></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="tabb5" class="tab_content" style="display: block;"> 
                            <div class="clear"></div>
                            <div class="fluid">
                                <div  class="stripe"></div>
                                <div class="understripepro widget fluid">
                                    <div style ="margin-top:-8px;" class="formRow">
                                        <span style="font-weight:bold;" class="grid1">Date :</span>
                                        <span style="width:15%;margin-left:-15px" class="grid3"><input style="width:60%!important;"  placeholder="yyyy-mm-dd" type="text"  name="date" id="datesso" class="searchLine datepicker" rule="textbox"></span>
                                        <span style="font-weight:bold;" class="grid1">Search :</span>
                                        <span style="margin-left:0px;margin-right:5%"class="grid3"><input id="sspasien"  type="text" placeholder="Name / No. Lab" name="test" class="searchLine" rule="textbox"></span>
                                        <span style="font-weight:bold;"style="width:8%;margin-left:0px;" class="grid2">Sample Type :</span>
                                        <span style="margin-left:6px" class="grid3">
                                            <select style="width:100%;margin-left:10px;" data-placeholder="Sample Type" class="select" tabindex="2">
                                                <option value=""></option>
                                                <option value="1">PLAIN</option> 
                                                <option value="2">Serum</option> 
                                                <option value="3">Urine</option> 
                                                <option value="4">Heparin</option> 
                                                <option value="5">EDTA</option> 
                                                <option value="6">SST</option> 
                                                <option value="7">ESR</option> 
                                                <option value="8">Floride</option>
                                            </select>
                                        </span>
                                    </div>
                                </div>

                                <!--
                                <div style="margin-left:0px;" class="widget block grid12 noBottom">
                                   <div style="margin:20px 20px;" class="widget">

                                       <div style="border-left:1px solid #CDCDCD!important;border-right:1px solid #CDCDCD!important;margin-bottom:20px;" class="whead grid12"><span style="padding:7px 4px;" class="titleIcon check colomn"><input type="checkbox" onclick="chkall()" id="titleCheck" name="titleCheck" /></span><h6 style="padding-bottom:3px;">Detail Test</h6><a href="#" onclick="deleterow()"><span class="icos-trash" style="float:right;margin:4px 15px 0px 340px; "></span></a><div class="clear"></div>
                                -->


                                <div style="margin-top:10px;margin-left:0px;overflow-y:auto!important" class="widget block grid12 noBottom">

                                    <div style="height:450px;" class="whead grid12"><h6 style="padding-bottom:3px;">Sample Storage Table</h6><div class="clear"></div>

                                        <table   cellpadding="0" cellspacing="0" width="100%" class="tDefault checkAll check" id="checkAll" style="border-bottom:1px solid #DFDFDF;">

                                            <thead>
                                                <tr>
                                                    <td style="width:40px" class="colomn"></td>
                                                    <td class="colomn" style="font-weight: bold;">No Lab</td>
                                                    <td class="colomn" style="font-weight:bold;width:17%">Name</td>
                                                    <td class="colomn" style="font-weight:bold;width:22%">Address</td>
                                                    <td class="colomn" style="font-weight:bold;width:16%;">Sample Type</td>
                                                    <td class="colomn"  style="font-weight:bold;width:24%">Action</td>
                                                </tr>
                                            </thead>
                                            <tbody id="sstablelist" >
                                                <tr id="trsstable1">
                                                    <td class="colomn" style="border-left:0px" ><input  type="checkbox" id="titleCheck2" name="checkRow" /></td>
                                                    <td class="colomn">151655101061</td>
                                                    <td class="colomn">Farhan Zainal</td>
                                                    <td class="colomn">Jl. Cempaka Putih , No.5</td>
                                                    <td class="colomn">EDTA, Serum, Flouride</td>
                                                    <td class="colomn" align="center">
                                                        <a class="buttonS bRed" id="openafterstore" href="#" style="color:white;width:40px">Store</a>
                                                        <a class="buttonS bSea" href="#" style="color:white;width:40px">Edit</a>
                                                        <a class="buttonS bBlue" href="#" style="color:white;width:40px">Put</a>
                                                    </td>
                                                </tr>
                                            </tbody>

                                        </table>

                                    </div>
                                </div>
                                <div style="margin-top:20px;" class="fluid grid12">
                                    <div class="grid2" style="margin-top: 15px;">
                                        <a href="#" onclick="storecheck()" class="buttonM bBlue" style="font-size:14px;text-align:center;color:white;width:82px;height:20px;padding-top:12px;">Store</a>
                                    </div>
                                    <div class="grid2" style="margin-top: 15px;">
                                        <a href="#" class="buttonM bSea" style="font-size:14px;text-align:center;color:white;width:82px;height:20px;padding-top:12px;">Edit</a>
                                    </div>
                                    <div class="grid2" style="margin-top: 15px;">
                                        <a href="#" class="buttonM bBlack" style="font-size:14px;text-align:center;color:white;width:82px;height:20px;padding-top:12px;">Destroy</a>
                                    </div>
                                    <div class="grid2" style="margin-top: 15px;">
                                        <a href="#" class="buttonM bGreen" style="font-size:14px;text-align:center;color:white;width:82px;height:20px;padding-top:12px;">View Detail</a>
                                    </div>
                                </div>
                                <!--dialog box after simpan-->
                                <div class="formRow block" style="width:600px;" id="afterstore" title="">

                                    <div class="fluid grid8 rowdialog">
                                        <span style="width:20%;min-width:30%;" class="grid4"><label>No. Lab</label></span>
                                        <span class="grid1" style="width:1%;"><label>:</label></span>  
                                        <span style="width:60%;display:inline-block;margin-top:-6px;" class="grid7"><input type="text" id="nolab" readonly="readonly" name="reguler"></span>
                                    </div>
                                    <div class="fluid grid8 rowdialog">
                                        <span style="width:20%;min-width:30%;" class="grid4"><label>Name</label></span>
                                        <span class="grid1" style="width:1%;"><label>:</label></span>  
                                        <span style="width:60%;display:inline-block;margin-top:-6px;" class="grid7"><input type="text" id="name"readonly="readonly" name="reguler"></span>
                                    </div>

                                    <div class="fluid grid8 rowdialog">
                                        <span style="width:20%;min-width:30%;" class="grid4"><label>Address</label></span>
                                        <span class="grid1" style="width:1%;"><label>:</label></span>  
                                        <span style="width:60%;display:inline-block;margin-top:-6px;" class="grid7"><input type="text" id="address" readonly="readonly" name="reguler"></span>
                                    </div>
                                    <div class="fluid grid8 rowdialog">
                                        <span style="width:20%;min-width:30%;" class="grid4"><label>Telephone</label></span>
                                        <span class="grid1" style="width:1%;"><label>:</label></span>  
                                        <span style="width:60%;display:inline-block;margin-top:-6px;" class="grid7"><input type="text" id="telephone" readonly="readonly" name="reguler"></span>
                                    </div>
                                    <div class="fluid grid8 rowdialog">
                                        <span style="width:20%;min-width:30%;" class="grid4"><label>Sample Type</label></span>
                                        <span class="grid1" style="width:1%;"><label>:</label></span>  
                                        <span style="width:60%;display:inline-block;margin-top:-6px;" class="grid7"><input type="text" id="sampletype" readonly="readonly" name="reguler"></span>
                                    </div>
                                    <!--rack-->
                                    <div class="widget fluid" style="margin-top:3%!important; background-color: #E9FBE9;border-color: #52E052 !important;">
                                        <div style="margin:3% 0%;" class="fluid grid12 rowdialog">
                                            <div class="grid6">
                                                <div style="margin-left:2%;" class="grid12">
                                                    <span style="margin-left:2%;" class="grid5"><label style="margin-top:1px;">Rack Number</label></span>
                                                    <span class="grid1" style="width:1%;"><label style="margin-top:1px;">:</label></span>  
                                                    <span class="grid4"><input type="text" style="margin-top:0px;" id="racknumberrack"  name="reguler"></span>
                                                </div>
                                                <div style="margin-left:2%;" class="grid12">
                                                    <span style="margin-left:2%;" class="grid5"><label style="margin-top:1px;">Empty</label></span>
                                                    <span class="grid1" style="width:1%;"><label style="margin-top:1px;">:</label></span>  
                                                    <span class="grid4"><input type="text" id="emptyrack" style="margin-top:0px;"  name="reguler"></span>
                                                </div>
                                                <div class="grid12">
                                                    <span style="margin-left:2%;" class="grid5"><label style="margin-top:1px;">Fill</label></span>
                                                    <span class="grid1" style="width:1%;"><label style="margin-top:1px;">:</label></span>  
                                                    <span class="grid4"><input type="text" style="margin-top:0px;" id="fillrack" name="reguler"></span>
                                                </div>
                                                <div class="grid12">
                                                    <span style="margin-left:2%;" class="grid5"><label style="margin-top:1px;">ED</label></span>
                                                    <span class="grid1" style="width:1%;" ><label style="margin-top:1px;">:</label></span>  
                                                    <span class="grid4"><input type="text" style="margin-top:0px;"  id="edrack" name="reguler"></span>
                                                </div>
                                                <div class="grid12" style="margin:16% 8% 0% 3%;">
                                                    <span class="grid3">
                                                        <button class="buttonS bBlue" style="height:35px;width:120px;">Store</button>
                                                    </span>
                                                    <span class="grid4" style="margin-left:31%">
                                                        <img id="barcode" style="border:1px solid maroon;" src="http://192.168.1.112/smartprox/includes/images/barcodes5.png" alt="">
                                                    </span>
                                                </div>


                                            </div>

                                            <div style="margin-left:6%;" class="grid5">
                                                <span style="" >
                                                    <table class="rack">

                                                        <tbody>
                                                            <tr>

                                                                <td  onclick="openOffersDialog($(this));" style="border-style:solid!important;border-width: 1px!important;"><div id="r11"  style="margin-left:auto; margin-right:auto;"  class="tuberound empty">
                                                                        <!--<div class="tooltip">
                                                                        <img src="http://192.168.1.112/smartprox/includes/images/big1.jpg" alt="" width="330" height="185" />
                                                                        <span class="overlay"></span>
                                                                        </div> -->
                                                                        <span></span></div></td>
                                                                <td onclick="openOffersDialog($(this));" style="border-style:solid!important;border-width: 1px!important;"><div id="r12"  style="margin-left:auto; margin-right:auto;"  class="tuberound empty"><span><input type="hidden" name="samplenumber" class="samplenumber" ></span></div></td>
                                                                <td onclick="openOffersDialog($(this));" style="border-style:solid!important;border-width: 1px!important;"><div id="r13"  style="margin-left:auto; margin-right:auto;"  class="tuberound empty"><span><input type="hidden" name="samplenumber" class="samplenumber" ></span></div></td>
                                                                <td onclick="openOffersDialog($(this));" style="border-style:solid!important;border-width: 1px!important;"><div id="r14"  style="margin-left:auto; margin-right:auto;" class="tuberound empty"><span><input type="hidden" name="samplenumber" class="samplenumber" ></span></div></td>
                                                                <td onclick="openOffersDialog($(this));" style="border-style:solid!important;border-width: 1px!important;"><div id="r15"  style="margin-left:auto; margin-right:auto;"  class="tuberound empty"><span><input type="hidden" name="samplenumber" class="samplenumber" ></span></div></td>
                                                            </tr>
                                                            <tr>

                                                                <td onclick="openOffersDialog($(this));"><div id="r21"  style="margin-left:auto; margin-right:auto;" class="tuberound empty"><span><input type="hidden" name="samplenumber" class="samplenumber" ></span></div></td>
                                                                <td onclick="openOffersDialog($(this));"><div id="r22"  style="margin-left:auto; margin-right:auto;" class="tuberound empty"><span><input type="hidden" name="samplenumber" class="samplenumber" ></span></div></td>
                                                                <td onclick="openOffersDialog($(this));"> <div id="r23"  style="margin-left:auto; margin-right:auto;" class="tuberound empty"><span><input type="hidden" name="samplenumber" class="samplenumber" ></span></div></td>
                                                                <td onclick="openOffersDialog($(this));"><div id="r24"  style="margin-left:auto; margin-right:auto;" class="tuberound empty"><span><input type="hidden" name="samplenumber" class="samplenumber" ></span></div></td>
                                                                <td onclick="openOffersDialog($(this));"><div id="r25"  style="margin-left:auto; margin-right:auto;" class="tuberound empty"><span><input type="hidden" name="samplenumber" class="samplenumber" ></span></div></td>
                                                            </tr>
                                                            <tr>

                                                                <td onclick="openOffersDialog($(this));"><div id="r31"  style="margin-left:auto; margin-right:auto;" class="tuberound empty"><span><input type="hidden" name="samplenumber" class="samplenumber" ></span></div></td>
                                                                <td onclick="openOffersDialog($(this));"><div id="r32"  style="margin-left:auto; margin-right:auto;" class="tuberound empty"><span><input type="hidden" name="samplenumber" class="samplenumber" ></span></div></td>
                                                                <td onclick="openOffersDialog($(this));"><div id="r33"  style="margin-left:auto; margin-right:auto;" class="tuberound empty"><span><input type="hidden" name="samplenumber" class="samplenumber" ></span></div></td>
                                                                <td onclick="openOffersDialog($(this));"><div id="r34"  style="margin-left:auto; margin-right:auto;" class="tuberound empty"><span><input type="hidden" name="samplenumber" class="samplenumber" ></span></div></td>
                                                                <td onclick="openOffersDialog($(this));"><div id="r35"  style="margin-left:auto; margin-right:auto;" class="tuberound empty"><span><input type="hidden" name="samplenumber" class="samplenumber" ></span></div></td>
                                                            </tr>
                                                            <tr>

                                                                <td onclick="openOffersDialog($(this));"><div id="r41" style="margin-left:auto; margin-right:auto;" class="tuberound empty"><span><input type="hidden" name="samplenumber" class="samplenumber" ></span></div></td>
                                                                <td onclick="openOffersDialog($(this));"><div id="r42" style="margin-left:auto; margin-right:auto;" class="tuberound empty"><span><input type="hidden" name="samplenumber" class="samplenumber" ></span></div></td>
                                                                <td onclick="openOffersDialog($(this));"><div id="r43" style="margin-left:auto; margin-right:auto;" class="tuberound empty"><span><input type="hidden" name="samplenumber" class="samplenumber" ></span></div></td>
                                                                <td onclick="openOffersDialog($(this));"><div id="r44" style="margin-left:auto; margin-right:auto;" class="tuberound empty"><span><input type="hidden" name="samplenumber" class="samplenumber" ></span></div></td>
                                                                <td onclick="openOffersDialog($(this));"><div id="r45" style="margin-left:auto; margin-right:auto;" class="tuberound empty"><span><input type="hidden" name="samplenumber" class="samplenumber" ></span></div></td>
                                                            </tr>
                                                            <tr>

                                                                <td onclick="openOffersDialog($(this));"><div id="r51" style="margin-left:auto; margin-right:auto;" class="tuberound empty"><span><input type="hidden" name="samplenumber" class="samplenumber" ></span></div></td>
                                                                <td onclick="openOffersDialog($(this));"><div id="r52" style="margin-left:auto; margin-right:auto;" class="tuberound empty"><span><input type="hidden" name="samplenumber" class="samplenumber" ></span></div></td>
                                                                <td onclick="openOffersDialog($(this));"><div id="r53" style="margin-left:auto; margin-right:auto;" class="tuberound empty"><span><input type="hidden" name="samplenumber" class="samplenumber" ></span></div></td>
                                                                <td onclick="openOffersDialog($(this));"><div id="r54" style="margin-left:auto; margin-right:auto;" class="tuberound empty"><span><input type="hidden" name="samplenumber" class="samplenumber" ></span></div></td>
                                                                <td onclick="openOffersDialog($(this));"><div id="r55" style="margin-left:auto; margin-right:auto;" class="tuberound empty"><span><input type="hidden" name="samplenumber" class="samplenumber" ></span></div></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>


                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                </div>  
                                <!--dialog box end-->      
                                <!--dialog popup-->
                                <div id="overlay" style="display:none" class="overlay"></div>
                                <div id="boxpopup" class="box" style="display: none; right: 0px; left: 36.5%;">
                                    <div><a onclick="closeOffersDialog('boxpopup');" class="boxclose">X</a></div>
                                    <div id="contentpopup" class="grid12" style="top:-12%;">
                                        <div class="grid4" align="center" style="margin-left:-5px;background-color:#90EE90;border: 8px solid #32CD32;border-radius:5px;height:200px;">
                                            <img id="dtimg" style="padding:5px!important;" src="http://192.168.1.112/smartprox/includes/images/tube/ssts">
                                        </div>
                                        <div class="grid8" style="background-color:#90EE90;border: 8px solid #32CD32;border-radius:5px;height:200px">
                                            <div style="margin-top:5%;" lass="grid12">
                                                <span style="margin-left:5%;" class="grid4">Sample Number</span>
                                                <span class="grid1">:</span>
                                                <span class="grid6" id="dtsamplenumber">A-Faj-18960-12876</span>
                                                <span style="margin-left:5%;" class="grid4">Sample Type</span>
                                                <span class="grid1">:</span>
                                                <span class="grid6" id="dtsampletype" >EDTA</span>
                                                <span style="margin-left:5%;" class="grid4">Rack Number</span>
                                                <span class="grid1">:</span>
                                                <span class="grid6" id="dtracknumber">A101</span>
                                                <span style="margin-left:5%;" class="grid4">In Date</span>
                                                <span class="grid1">:</span>
                                                <span class="grid6" id="dtindate">01-05-2013</span>
                                                <span style="margin-left:5%;" class="grid4">Expired Date</span>
                                                <span class="grid1">:</span>
                                                <span class="grid6" id="dtED">11-05-2013</span>
                                                <span style="margin-left:5%;" class="grid4">Sample Status</span>
                                                <span class="grid1">:</span>
                                                <span class="grid6" id="dtsamplestatus">Available</span>

                                            </div>
                                        </div>

                                        <!--<div id="imgtube"></div>
                                        <span id="samplenumberpopup"></span>-->
                                    </div>
                                    <!--dialog popup end-->
                                </div>
                            </div>
                        </div>

                        <div id="tabb6" class="tab_content" style="display: block;"> 
                            <div class="clear"></div>
                            <div class="fluid">
                                <div  class="stripe"></div>
                                <div class="understripepro widget fluid">
                                    <div style ="margin-top:-8px;" class="formRow">
                                        <span style="font-weight:bold;" class="grid1">Date :</span>
                                        <span style="width:15%;margin-left:-15px" class="grid3"><input style="width:60%!important;"  placeholder="yyyy-mm-dd" type="text"  name="date" id="datevs" class="searchLine datepicker" rule="textbox"></span>
                                        <span style="font-weight:bold;" class="grid1">Search :</span>
                                        <span style="margin-left:0px;margin-right:5%"class="grid3"><input id="vspasien"  type="text" placeholder="Rack Number" name="test" class="searchLine" rule="textbox"></span>
                                    </div>
                                </div>
                                <div class="widget fluid grid8 vbox" style="margin-top:10px;margin-bottom:2%;margin-left:-0.05%;">
                                    <div class="body" align="center">

                                        <div class="grid12">
                                            <div style="margin-left:0px;border-top:0px;border-bottom:0px;margin-top:-20px;" class="formRow block grid12 noBottom">
                                                <!-- Standard table -->
                                                <div style="margin-top:10px;" class="widget">
                                                    <div class="whead"><h6>Storage Table</h6><div class="clear"></div></div>
                                                    <div class="scrollleftvs">
                                                        <table style="border-bottom:1px solid #DFDFDF;" cellpadding="0" cellspacing="0" width="100%" class="tLight noBorderT">
                                                            <thead>
                                                                <tr>
                                                                    <td style="width:25%">Rack</td>
                                                                    <td style='width:25%'>Fill</td>
                                                                    <td style="width:25%">Empty</td>
                                                                    <td style='width:25%'>Expired Date</td>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="rackbiglist">
                                                                <tr class="datarow">
                                                                    <td style="height:20px;"></td>
                                                                    <td ></td>
                                                                    <td ></td>
                                                                    <td ></td>
                                                                </tr>
                                                                <tr class="datarow">
                                                                    <td style="height:20px;"></td>
                                                                    <td ></td>
                                                                    <td ></td>
                                                                    <td ></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div style="padding:2% 0%;"class="grid6">
                                                        <span class="grid6"><a  class="buttonM bBlack Bcenter" href="#">Destroy</a></span>
                                                        <span class="grid6"><a  class="buttonM bSea Bcenter" href="#">Edit</a></span>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                    </div>              

                                </div>
                                <div style="margin-top:10px;" class="widget grid4 vbox noBottom">
                                    <table width="100%" class="rackbig">

                                        <tbody id="rackbigtable">
                                            <tr>

                                                <td><div id="11" align="center" class="tuberound empty"><span></span></div></td>
                                                <td><div id="12"  align="center" class="tuberound empty"><span></span></div></td>
                                                <td><div id="13"  align="center" class="tuberound empty"><span></span></div></td>
                                                <td><div id="14"  align="center" class="tuberound empty"><span></span></div></td>
                                                <td><div id="15"  align="center" class="tuberound empty"><span></span></div></td>
                                            </tr>
                                            <tr>

                                                <td><div id="21"  align="center" class="tuberound empty"><span></span></div></td>
                                                <td><div id="22"  align="center" class="tuberound empty"><span></span></div></td>
                                                <td><div id="23"  align="center" class="tuberound empty"><span></span></div></td>
                                                <td><div id="24"  align="center" class="tuberound empty"><span></span></div></td>
                                                <td><div id="25" align="center" class="tuberound empty"><span></span></div></td>
                                            </tr>
                                            <tr>

                                                <td><div id="31"  align="center" class="tuberound empty"><span></span></div></td>
                                                <td><div id="32"  align="center" class="tuberound empty"><span></span></div></td>
                                                <td><div id="33"  align="center" class="tuberound empty"><span></span></div></td>
                                                <td><div id="34"  align="center" class="tuberound empty"><span></span></div></td>
                                                <td><div id="35"  align="center" class="tuberound empty"><span></span></div></td>
                                            </tr>
                                            <tr>

                                                <td><div id="41" align="center" class="tuberound empty"><span></span></div></td>
                                                <td><div id="42"  align="center" class="tuberound empty"><span></span></div></td>
                                                <td><div id="43"  align="center" class="tuberound empty"><span></span></div></td>
                                                <td><div id="44"  align="center" class="tuberound empty"><span></span></div></td>
                                                <td><div id="45"  align="center" class="tuberound empty"><span></span></div></td>
                                            </tr>
                                            <tr>

                                                <td><div id="51"  align="center" class="tuberound empty"><span></span></div></td>
                                                <td><div id="52"  align="center" class="tuberound empty"><span></span></div></td>
                                                <td><div id="53"  align="center" class="tuberound empty"><span></span></div></td>
                                                <td><div id="54"  align="center" class="tuberound empty"><span></span></div></td>
                                                <td><div id="55"  align="center" class="tuberound empty"><span></span></div></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="clear"></div>
                                    <span id="racknumber" class="grid12 sPayment" style="padding:4% 0%; margin-left:1%;margin-right:1%;margin-top:5%;width:98%;eight:60px!important;"> Rack Number : A102</span>
                                </div>


                            </div>

                        </div>
                        <div id="tabbPrintResult" class="tab_content" style="display: block;"> 
                            <div class="clear"></div>

                            <div class="fluid">
                                <div  class="stripe"></div>
                                <div class="understripepro widget fluid">
                                    <div style ="margin-top:-8px;" class="formRow">
                                        <span style="font-weight:bold;" class="grid1">Date :</span>
                                        <span style="width:15%;margin-left:-15px" class="grid3"><input style="width:60%!important;"  placeholder="yyyy-mm-dd" type="text"  name="date" id="datepr" class="searchLine datepicker" rule="textbox"></span>
                                        <span style="font-weight:bold;" class="grid1">Search :</span>
                                        <span style="margin-left:0px;margin-right:5%"class="grid3"><input id="prpasien"  type="text" placeholder="Name / No. Lab" name="test" class="searchLine" rule="textbox"></span>
                                        <span style="font-weight:bold;" class="grid1">Status :</span>
                                        <span style="margin-left:0px" class="grid3">
                                            <select style="width:100%;margin-left:10px;" data-placeholder="Patient Status" class="select" tabindex="2">
                                                <option value=""></option>
                                                <option value="1">Print Ticket Queue</option> 
                                                <option value="2">Called FO</option> 
                                                <option value="3">Register</option> 
                                                <option value="4">Payment</option> 
                                                <option value="5">Sampling</option> 
                                                <option value="6">Ready</option> 
                                                <option value="7">Process</option> 
                                                <option value="8">First Validation</option>
                                                <option value="9">Second Validation</option> 
                                                <option value="10">Print Result</option> 
                                                <option value="11">Delivered Result</option>
                                                <option value="12">All</option>
                                            </select>
                                        </span>
                                    </div>
                                </div>


                                <div style="margin-top:10px;" class="widget">
                                    <div class="whead"><h6>Data Patient</h6><div class="clear"></div></div>
                                    <div style="overflow-y:auto;height:460px;" class="scrollleft">
                                        <table style="border-bottom:1px solid #DFDFDF;" cellpadding="0" cellspacing="0" width="100%" class="tLight noBorderT">
                                            <thead>
                                                <tr>
                                                    <td width="10">No</td>
                                                    <td width="150">No Lab</td>
                                                    <td width="150">Name(s)</td>
                                                    <td width="180">Doctor</td>
                                                    <td>Status</td>
                                                </tr>
                                            </thead>
                                            <tbody id='prtablelist'>
                                                <tr class="gradeX">
                                                    <td>Trident</td>
                                                    <td>Internet Explorer 4.0</td>
                                                    <td>Win 95+</td>
                                                    <td>Win 95+</td>
                                                    <td class="center">4</td>
                                                </tr>
                                            </tbody>
                                        </table> 
                                    </div>
                                </div>
                                <div class="clear"></div> 
                            </div>                 
                        </div>




                    </div>

                </div>





            </div>
        </div>
        <!-- Content ends -->  
        <?= isset($dialogs) ? $dialogs : '' ?>       
    </body>
</html>


<?php

class Accountmap extends MY_Controller
{
    function __construct() 
    {
        parent::__construct();
        
        $this->load->model('finance/f_accountmap_m');
    }
    
    function index()
    {
        $data['extrajs'] = array('f_accountmap');
        
        //table parameter
        $tblprm = array(
            'id'        => 'dynamic',
            'source'    => base_url() . 'masterdata/asset/listing',
            'columns'   => array('M_AssetCode', 'M_AssetName', 'M_AssetO_BranchCode','M_AssetM_AssetCategoryCode','M_AssetBuyDate','M_AssetBuyValue','M_AssetResidualValue','M_AssetEconomicPeriod','M_AssetShrinkValue'),
            'titles'    => array('Kode', 'Nama', 'Cabang', 'Kategori', 'Tanggal Perolehan','Nilai Perolehan','Nilai Residu','Umur Ekonomis','Nilai Penyusutan'),
            
            //total column widths = 75%
            //the rest 25% has been used for the Action button
            'widths'    => array('10','20', '5', '5', '5','10','10','10','10'),
            
            //now, we're adding edit button
            //write the button action prefix here
            'edit'      => 'm_asset_',
            'delete'    => 'm_asset_',
            'dLength'   => 1
        );
        
        $data['content'] = '&nbsp;';
        $data['formCRUD'] = $this->form();
        $this->load->view('pages/formOnly', $data);
    }
    
    function form()
    {
        $this->load->model(array('office/o_branch_m'));
        
        $brch_list = $this->o_branch_m->get_key_value('O_BranchID', 'O_BranchName');
        $this->db->join('v_accountmapcount', 'code = LEFT(F_AccountMapConstantCode, 2)', 'left')
                ->order_by('F_AccountMapConstantCode');
        $r = $this->f_accountmap_m->get(false);
        
                
        /*$form = array(
            array(
                'title' => 'Data Pribadi',
                'col0' => array(
                    array('label'=>'Kode','field'=>  form_input('T_SpjM_DriversCode', '', 'autocomplete=off'))
                ),
                'col1' => array(
                )
            ),
            array(
                'title' => 'Data Pekerjaan',
                'col0' => array(
                    array('label'=>'Kode Kendaraan','field'=>  form_dropdown('T_SpjM_FleetCode', array(), '', 'class="select grid8" onchange="fleetInfo($(this).val())"')),
                    array('label'=>'KM Kendaraan','field'=>  form_input('T_SpjStartKM', '', 'readonly=readonly')),
                    array('label'=>'Info Kendaraan','field'=>  '
                        <div class="body" style="padding:0px">
                            <ul class="liWarning">
                            </ul>
                        </div>
                    ')
                ),
                'col1' => array(
                    array('label'=>'Jumlah Setoran','field'=> form_input('T_SpjPay', '', 'class="rtl-inputz maskNum" autocomplete=off')),
                    array('label'=>'Potongan','field'=>  form_input('T_SpjPotongan', '', 'class="rtl-inputz maskNum" autocomplete=off')),
                    array('label'=>'Disetujui','field'=> form_input('T_SpjPotonganNote', '', 'style=width:65%')),
                    array('label'=>'Jumlah yang Harus Disetor','field'=> form_input('T_SpjTotal', '', 'class="rtl-inputz maskNum" autocomplete=off readonly=readonly'))
                )
            )
        );*/

        $g = '';
        $l = -1;
        $f = array();
        $lf = 0;
        $rg = 0;
        foreach ($r as $k => $v)
        {
            if (substr($v['F_AccountMapConstantCode'], 0, 2) != $g)
            {
               $g =  substr($v['F_AccountMapConstantCode'], 0, 2);
               $l++;
               
               array_push($f, array(
                   'title' => $v['F_AccountMapName'],
                   'col0' => array(),
                   'col1' => array()
               ));
               
               $lf = 0;
               $rg = 0;
            }     
            else 
            {
                if ($lf < $v['lft'])
                {
                    array_push($f[$l]['col0'],
                        array('label'=>$v['F_AccountMapName'],'field'=>'<div class=grid1><input type=checkbox name=id[] value=' . $v['F_AccountMapID'] . ' checked=checked autocomplete=off /></div><div class=grid11>' . form_input('F_AccountMapF_AccountCode[]', $v['F_AccountMapF_AccountCode'], 'autocomplete=off') . '</div>')
                    );
                    $lf ++;
                }
                
                else
                {
                    if ($rg < $v['rgt'])
                    {
                        array_push($f[$l]['col1'],
                            array('label'=>$v['F_AccountMapName'],'field'=>'<div class=grid1><input type=checkbox name=id[] value=' . $v['F_AccountMapID'] . ' checked=checked autocomplete=off /></div><div class=grid11>' . form_input('F_AccountMapF_AccountCode[]', $v['F_AccountMapF_AccountCode'], 'autocomplete=off') . '</div>')
                        );
                        $rg++;
                    }
                }
                
            }
        }
        return $this->load->view('parts/formCRUDOnly', array('form'=>$f,'formname'=>'formaccount','submit'=>array('button'=>'f_account_save()')), true);
    }
    
    function listing()
    {
        //getting param data
        list($tot_rec,$tot_disp_rec,$r) = $this->m_asset_m->listing($this->input,
			array("M_AssetName") );
        
        $output = array(
            'sEcho' => $this->input->get("sEcho"),
            'iTotalRecords' => $tot_rec,
            'iTotalDisplayRecords' => $tot_disp_rec,
            'aaData' => $r
        );
        
        echo json_encode($output);
    }
    
    function save()
    {
        $i = $this->input->post();
       
        $i['F_AccountMapUserID'] = $this->user->UserID;
       
        if (!$this->edit_validate())
        {
            echo json_encode(array('err'=>$this->form_validation->error_array(),'msg'=>  validation_errors()));
            exit;
        }
        $r = $this->f_accountmap_m->save($i);
        
        if (!$r)
        {
            echo json_encode(array('err'=>'Error tenan','msg'=>'Error pancene'));
        }
        else
        {
            echo json_encode(array('rst'=>$r,'msg'=>'Data aktiva tetap berhasil disimpan'));
            return;
        }
    }
    
    function edit_validate()
    {
        $this->form_validation->set_rules('id', 'Kode Rekening Penghubung', 'required');
        return $this->form_validation->run();
    }    
}
?>

<?php

class Asset extends MY_Controller
{
    function __construct() 
    {
        parent::__construct();
        
        $this->load->model('masterdata/m_asset_m');
    }
    
    function index()
    {
        $data['extrajs'] = array('m_asset');
        
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
        
        $data['content'] = $this->load->view('parts/dataTable', $tblprm, true);
        $data['formCRUD'] = '';
        $data['tableTitle'] = 'Master Data Aktiva Tetap';
        $this->load->view('pages/masterdata', $data);
    }
    
    function form($id)
    {
        $this->load->model(array('office/o_branch_m','masterdata/m_assetcategory_m'));
        
        $brch_list = $this->o_branch_m->get_key_value('O_BranchCode', 'O_BranchName');
        $asca_list = $this->m_assetcategory_m->get_key_value('M_AssetCategoryCode', 'M_AssetCategoryName');
        
        if ($id == 'new')
        {
            $form = array(
                array(
                    'title' => 'Data Asset',
                    'col0' => array(
                        array('label'=>'Cabang','field'=>  form_dropdown('M_AssetO_BranchCode', $brch_list, '', 'class=\'select grid8\' style=\'\'')),
                        array('label'=>'Kode','field'=>  form_input('M_AssetCode', '')),
                        array('label'=>'Nama','field'=>  form_input('M_AssetName', '')),
                        array('label'=>'Kategori','field'=>  form_dropdown('M_AssetM_AssetCategoryCode', $asca_list, '', 'class=\'select grid8\' style=\'\'')),
                        array('label'=>'Tanggal Perolehan','field'=>  form_input('M_AssetBuyDate', '' , 'class=datepicker')),
                        array('label'=>'Keterangan','field'=>  form_textarea('M_AssetNote', '' )),
                        
                        ),
                    'col1' => array(
                        array('label'=>'Nilai Prolehan','field'=>  form_input('M_AssetBuyValue', '')),
                        array('label'=>'Umur Ekonomis','field'=>  form_input('M_AssetEconomicPeriod', '')),
                        array('label'=>'Nilai Residu','field'=>  form_input('M_AssetResidualValue', '')),
                        array('label'=>'Nilai Penyusutan','field'=>  form_input('M_AssetShrinkValue', '')),
                        array('label'=>'Lama Penyusutan','field'=>  form_input('M_AssetShrinkMonth', '')),
                        array('label'=>'Total Penyusutan','field'=>  form_input('M_AssetShrinkTotalValue', ''))
                    ))
            );
            
        }
        else
        {
            $d = $this->m_asset_m->get($id);
            
            $form = array(
                 array(
                    'title' => 'Data Asset',
                    'col0' => array(
                        array('label'=>'Cabang','field'=>  form_dropdown('M_AssetO_BranchCode', $brch_list, $d->M_AssetBranchCode, 'class=\'select grid8\' style=\'\'')),
                        array('label'=>'Kode','field'=>  form_input('M_AssetCode', $d->M_AssetCode).
                             form_hidden('M_AssetID', $d->M_AssetID)),
                        array('label'=>'Nama','field'=>  form_input('M_AssetName', $d->M_AssetName)),
                        array('label'=>'Kategori','field'=> form_dropdown('M_AssetM_AssetCategoryCode', $asca_list, $d->M_AssetCategoryCode, 'class=\'select grid8\' style=\'\'')),
                        array('label'=>'Tanggal Perolehan','field'=>  form_input('M_AssetBuyDate', $d->M_AssetBuyDate , 'class=datepicker')),
                        array('label'=>'Keterangan','field'=>  form_textarea('M_AssetNote', $d->M_AssetNote ))
                        
                        ),
                    'col1' => array(
                        array('label'=>'Nilai Prolehan','field'=>  form_input('M_AssetBuyValue', $d->M_AssetBuyValue)),
                        array('label'=>'Umur Ekonomis','field'=>  form_input('M_AssetEconomicPeriod', $d->M_AssetEconomicPeriod)),
                        array('label'=>'Nilai Residu','field'=>  form_input('M_AssetResidualValue', $d->M_AssetResidualValue)),
                        array('label'=>'Nilai Penyusutan','field'=>  form_input('M_AssetShrinkValue', $d->M_AssetShrinkValue)),
                        array('label'=>'Lama Penyusutan','field'=>  form_input('M_AssetShrinkMonth', $d->M_AssetShrinkMonth)),
                        array('label'=>'Total Penyusutan','field'=>  form_input('M_AssetShrinkTotalValue', $d->M_AssetShrinkTotalValue))
                    ))
            );
        }
        echo $this->load->view('parts/formCRUD', array('form'=>$form,'formname'=>'formasset'), true);
        
        return true;
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
    
    function save($id)
    {
        $i = $this->input->post();
       
        $i['M_AssetUserID'] = $this->user->UserID;
        $i['M_AssetBuyDate'] = date('Y-m-d', strtotime($i['M_AssetBuyDate']));
        
        if ($id == 'new')
        {
            if (!$this->save_validate())
            {
                echo json_encode(array('err'=>$this->form_validation->error_array(),'msg'=>  validation_errors()));
                exit;
            }
            $r = $this->m_asset_m->save($i);
        }
        else
        {
            if (!$this->edit_validate())
            {
                echo json_encode(array('err'=>$this->form_validation->error_array(),'msg'=>  validation_errors()));
                exit;
            }
            $r = $this->m_asset_m->save($i, $id);
        }
        
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
    
    function save_validate()
    {
        $this->form_validation->set_rules('M_AssetName', 'Nama', 'required');
        return $this->form_validation->run();
    }
    
    function edit_validate()
    {
        $this->form_validation->set_rules('M_AssetName', 'Nama', 'required');
        return $this->form_validation->run();
    }
    
    function delete()
    {
        $i = $this->input->post();
        $i['M_AssetUserID'] = $this->user->UserID;
        $i['M_AssetLastUpdate'] = date('Y-m-d H:i:s');
        $i['M_AssetIsActive'] = 'N';
        $r = $this->m_asset_m->save($i, $i['M_AssetID']);
        echo json_encode(array('rst'=>$r,'msg'=>'Data aktiva tetap berhasil dihapus'));
        return;
    }
    
    
    
}
?>

<?php

class Assetcategory extends MY_Controller
{
    function __construct() 
    {
        parent::__construct();
        
        $this->load->model('masterdata/m_assetcategory_m');
    }
    
    function index()
    {
        $data['extrajs'] = array('m_assetcategory');
        
        //table parameter
        $tblprm = array(
            'id'        => 'dynamic',
            'source'    => base_url() . 'masterdata/assetcategory/listing',
            'columns'   => array('M_AssetCategoryCode', 'M_AssetCategoryName', 'M_AssetCategoryBranchCode','M_AssetCategoryAccountCode'),
            'titles'    => array('Kode', 'Nama', 'Cabang', 'Kode Akun'),
            
            //total column widths = 75%
            //the rest 25% has been used for the Action button
            'widths'    => array('10','20', '10', '35'),
            
            //now, we're adding edit button
            //write the button action prefix here
            'edit'      => 'm_assetcategory_',
            'delete'    => 'm_assetcategory_',
            'dLength'   => 1
        );
        
        $data['content'] = $this->load->view('parts/dataTable', $tblprm, true);
        $data['formCRUD'] = '';
        $data['tableTitle'] = 'Master Data Kategori Aktiva';
        $this->load->view('pages/masterdata', $data);
    }
    
    function form($id)
    {
        $this->load->model(array('office/o_branch_m'));
        $brch_list = $this->o_branch_m->get_key_value('O_BranchCode', 'O_BranchName');
        
        if ($id == 'new')
        {
            $form = array(
               array(
                    'title' => 'Data Kategori Asset ',
                    'col0' => array(
                        array('label'=>'Cabang','field'=>  form_dropdown('M_AssetCategoryBranchCode', $brch_list, '', 'class=\'select grid8\' style=\'\'')),
                        array('label'=>'Kode','field'=>  form_input('M_AssetCategoryCode', '')),
                        array('label'=>'Nama','field'=>  form_input('M_AssetCategoryName', '')),
                        ),
                    'col1' => array(
                        array('label'=>'Kode Akun','field'=>  form_input('M_AssetCategoryAccountCode', '')),
                        array('label'=>'Kode Akun Penyusutan','field'=>  form_input('M_AssetCategoryShrinkAccountCode', '')),
                        array('label'=>'Kode Akun Biaya Penyusutan','field'=>  form_input('M_AssetCategoryShrinkValueAccountCode', ''))
                        
                    ))
            );
            
        }
        else
        {
            $d = $this->m_assetcategory_m->get($id);
            
            $form = array(
                 array(
                    'title' => 'Data Kategori Asset ',
                    'col0' => array(
                        array('label'=>'Cabang','field'=>  form_dropdown('M_AssetCategoryBranchCode', $brch_list, $d->M_AssetCategoryBranchCode, 'class=\'select grid8\' style=\'\'')),
                        array('label'=>'Kode','field'=>  form_input('M_AssetCategoryCode', $d->M_AssetCategoryCode).
                             form_hidden('M_AssetCategoryID', $d->M_AssetCategoryID)),
                        array('label'=>'Nama','field'=>  form_input('M_AssetCategoryName', $d->M_AssetCategoryName))
                        ),
                    'col1' => array(
                        array('label'=>'Kode Akun','field'=>  form_input('M_AssetCategoryAccountCode', $d->M_AssetCategoryAccountCode)),
                        array('label'=>'Kode Akun Penyusutan','field'=>  form_input('M_AssetCategoryShrinkAccountCode', $d->M_AssetCategoryShrinkAccountCode)),
                        array('label'=>'Kode Akun Biaya Penyusutan','field'=>  form_input('M_AssetCategoryShrinkValueAccountCode', $d->M_AssetCategoryShrinkValueAccountCode))
                        
                    ))
            );
        }
        echo $this->load->view('parts/formCRUD', array('form'=>$form,'formname'=>'formassetcategory'), true);
        
        return true;
    }
    
    function listing()
    {
        //getting param data
        list($tot_rec,$tot_disp_rec,$r) = $this->m_assetcategory_m->listing($this->input,
			array("M_AssetCategoryName") );
        
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
       
        $i['M_AssetcategoryUserID'] = $this->user->UserID;
       
        
        if ($id == 'new')
        {
            if (!$this->save_validate())
            {
                echo json_encode(array('err'=>$this->form_validation->error_array(),'msg'=>  validation_errors()));
                exit;
            }
            $r = $this->m_assetcategory_m->save($i);
        }
        else
        {
            if (!$this->edit_validate())
            {
                echo json_encode(array('err'=>$this->form_validation->error_array(),'msg'=>  validation_errors()));
                exit;
            }
            $r = $this->m_assetcategory_m->save($i, $id);
        }
        
        if (!$r)
        {
            echo json_encode(array('err'=>'Error tenan','msg'=>'Error pancene'));
        }
        else
        {
            echo json_encode(array('rst'=>$r,'msg'=>'Data kategori aktiva berhasil disimpan'));
            return;
        }
    }
    
    function save_validate()
    {
        $this->form_validation->set_rules('M_AssetCategoryName', 'Nama', 'required');
        return $this->form_validation->run();
    }
    
    function edit_validate()
    {
        $this->form_validation->set_rules('M_AssetCategoryName', 'Nama', 'required');
        return $this->form_validation->run();
    }
    
    function delete()
    {
        $i = $this->input->post();
        $i['M_AssetCategoryUserID'] = $this->user->UserID;
        $i['M_AssetCategoryLastUpdate'] = date('Y-m-d H:i:s');
        $i['M_AssetCategoryIsActive'] = 'N';
        $r = $this->m_assetcategory_m->save($i, $i['M_AssetCategoryID']);
        echo json_encode(array('rst'=>$r,'msg'=>'Data kategori aktiva berhasil dihapus'));
        return;
    }
    
    
    
}
?>

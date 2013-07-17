<?php

class Spareparts extends MY_Controller
{
    function __construct() 
    {
        parent::__construct();
        
        $this->load->model('masterdata/m_spareparts_m');
    }
    
    function index()
    {
        $data['extrajs'] = array('m_spareparts');
        
        //table parameter
        $tblprm = array(
            'id'        => 'dynamic',
            'source'    => base_url() . 'masterdata/spareparts/listing',
            'columns'   => array('M_SparePartsCode', 'M_SparePartsName', 'M_SparePartsStock', 'M_SparePartsCategoryName'),
            'titles'    => array('Kode', 'Nama', 'Stok', 'Kategori'),
            
            //total column widths = 75%
            //the rest 25% has been used for the Action button
            'widths'    => array('5', '60', '5', '15'),
            
            //now, we're adding edit button
            //write the button action prefix here
            'edit'      => 'm_spareparts_',
            'delete'    => 'm_spareparts_',
            'dLength'   => 1
        );
        
        $data['content'] = $this->load->view('parts/dataTable', $tblprm, true);
        $data['formCRUD'] = '';
        $data['tableTitle'] = 'Master Data Spare Parts';
        $this->load->view('pages/masterdata', $data);
    }
    
    function form($id)
    {
        $this->load->model(array('masterdata/m_sparepartscategory_m'));
        $category_list = $this->m_sparepartscategory_m->get_key_value('M_SparePartsCategoryID', 'M_SparePartsCategoryName');
        if ($id == 'new')
        {
            $form = array(
                array(
                    'title' => 'Data Spare Parts',
                    'col0' => array(
                        array('label'=>'Code','field'=>  form_input('M_SparePartsCode', '')),
                        array('label'=>'Stok','field'=>  form_input('M_SparePartsStock', '')),
                        array('label'=>'Nama','field'=>  form_input('M_SparePartsName', '')),
                        array('label'=>'Kategori','field'=>  form_dropdown('M_SparePartsM_SparePartsCategoryID', $category_list, '', 'class=\'select grid8\' style=\'\''))
                    )
                )
            );
            
        }
        else
        {
            $d = $this->m_spareparts_m->get($id);
            
            $form = array(
                array(
                    'title' => 'Data Spare Part',
                    'col0' => array(
                        array('label'=>'Code','field'=>  form_input('M_SparePartsCode', $d->M_SparePartsCode)
                            .form_hidden('M_SparePartsID', $d->M_SparePartsID)),
                        array('label'=>'Stok','field'=>  form_input('M_SparePartsStock', $d->M_SparePartsStock)),
                        array('label'=>'Nama','field'=>  form_input('M_SparePartsName', $d->M_SparePartsName)),
                        array('label'=>'Kategori','field'=>  form_dropdown('M_SparePartsM_SparePartsCategoryID', $category_list, $d->M_SparePartsM_SparePartsCategoryID, 'class=\'select grid8\' style=\'\''))
                    )
                )
            );
        }
        echo $this->load->view('parts/formCRUD', array('form'=>$form,'formname'=>'formspareparts'), true);
        
        return true;
    }
    
    function listing()
    {
        //getting param data
        list($tot_rec,$tot_disp_rec,$r) = $this->m_spareparts_m->listing($this->input,
			array("M_SparePartsName") );
        
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
        $i['M_SparePartsUserID'] = $this->user->UserID;
        
        if ($id == 'new')
        {
            if (!$this->save_validate())
            {
                echo json_encode(array('err'=>$this->form_validation->error_array(),'msg'=>  validation_errors()));
                exit;
            }
            $r = $this->m_spareparts_m->save($i);
        }
        else
        {
            if (!$this->edit_validate())
            {
                echo json_encode(array('err'=>$this->form_validation->error_array(),'msg'=>  validation_errors()));
                exit;
            }
            $r = $this->m_spareparts_m->save($i, $id);
        }
        
        if (!$r)
        {
            echo json_encode(array('err'=>'Error tenan','msg'=>'Error pancene'));
        }
        else
        {
            echo json_encode(array('rst'=>$r,'msg'=>'Data driver berhasil disimpan'));
            return;
        }
    }
    
    function save_validate()
    {
        $this->form_validation->set_rules('M_SparePartsName', 'Nama Spare Parts', 'required');
        return $this->form_validation->run();
    }
    
    function edit_validate()
    {
        $this->form_validation->set_rules('M_SparePartsName', 'Nama Spare Parts', 'required');
        return $this->form_validation->run();
    }
    
    function delete()
    {
        $i = $this->input->post();
        $i['M_SparePartsUserID'] = $this->user->UserID;
        $i['M_SparePartsLastUpdate'] = date('Y-m-d H:i:s');
        $i['M_SparePartsIsActive'] = 'N';
        $r = $this->m_spareparts_m->save($i, $i['M_SparePartsID']);
        echo json_encode(array('rst'=>$r,'msg'=>'Data driver berhasil dihapus'));
        return;
    }
    
    function getby_supplier()
    {
        $this->db->select('M_SparePartsCode, M_SparePartsName', false)
                ->where('M_SparePartsM_SupplierCode', $this->input->get('code'));
        $r = $this->m_spareparts_m->get(false);
        if ($r)
        {
            echo json_encode($r);
            return true;
        }
        
        return false;
    }
    
    function autocompleteby_supplier()
    {
        $this->db->select('M_SparePartsCode, M_SparePartsName', false)
                ->where("(M_SparePartsCode LIKE '%{$this->input->get('term')}%' OR M_SparePartsName LIKE '%{$this->input->get('term')}%')", null, false);
        if ($this->input->get('code') != '')
            $this->db->where('M_SparePartsM_SupplierCode', $this->input->get('code'));
        $r = $this->m_spareparts_m->get(false);
        $d = array();
        if ($r)
        {
            foreach ($r as $k => $v)
            {
                array_push($d, array(
                    'id' => $v['M_SparePartsCode'],
                    'label' => $v['M_SparePartsCode'] . ' | ' . $v['M_SparePartsName'],
                    'value' => $v['M_SparePartsName']
                ));
            }
            echo json_encode($d);
            return true;
        }
        
        return false;
    }
    
    function get_info()
    {
        $this->db->where('M_SparePartsCode', $this->input->get('code'))
            ->where('M_SparePartsIsActive', 1);
        
        $r = $this->m_spareparts_m->get(false);
        if ($r)
            echo json_encode($r[0]);
        
        return true;
    }
}
?>

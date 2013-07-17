<?php

class Sparepartscategory extends MY_Controller
{
    function __construct() 
    {
        parent::__construct();
        
        $this->load->model('masterdata/m_sparepartscategory_m');
    }
    
    function index()
    {
        $data['extrajs'] = array('m_sparepartscategory');
        
        //table parameter
        $tblprm = array(
            'id'        => 'dynamic',
            'source'    => base_url() . 'masterdata/sparepartscategory/listing',
            'columns'   => array('M_SparePartsCategoryName'),
            'titles'    => array('Nama'),
            
            //total column widths = 75%
            //the rest 25% has been used for the Action button
            'widths'    => array('85'),
            
            //now, we're adding edit button
            //write the button action prefix here
            'edit'      => 'm_sparepartscategory_',
            'delete'    => 'm_sparepartscategory_',
            'dLength'   => 1
        );
        
        $data['content'] = $this->load->view('parts/dataTable', $tblprm, true);
        $data['formCRUD'] = '';
        $data['tableTitle'] = 'Master Data Spare Parts Category';
        $this->load->view('pages/masterdata', $data);
    }
    
    function form($id)
    {
       
        if ($id == 'new')
        {
            $form = array(
                array(
                    'title' => 'Data Spare Parts Kategori',
                    'col0' => array(
                        array('label'=>'Nama','field'=>  form_input('M_SparePartsCategoryName', ''))
                    )
                )
            );
        }
        else
        {
            $d = $this->m_sparepartscategory_m->get($id);
            
            $form = array(
               array(
                    'title' => 'Data Spare Parts Kategori',
                    'col0' => array(
                        array('label'=>'Nama','field'=>  form_input('M_SparePartsCategoryName', $d->M_SparePartsCategoryName).
                            form_hidden('M_SparePartsCategoryID', $d->M_SparePartsCategoryID))
                    )
                )
            );
        }
        echo $this->load->view('parts/formCRUD', array('form'=>$form,'formname'=>'formsparepartscategory'), true);
        
        return true;
    }
    
    function listing()
    {
        //getting param data
        list($tot_rec,$tot_disp_rec,$r) = $this->m_sparepartscategory_m->listing($this->input,
			array("M_SparePartsCategoryName") );
        
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
        $i['M_SparePartsCategoryUserID'] = $this->user->UserID;
        
        if ($id == 'new')
        {
            if (!$this->save_validate())
            {
                echo json_encode(array('err'=>$this->form_validation->error_array(),'msg'=>  validation_errors()));
                exit;
            }
            $r = $this->m_sparepartscategory_m->save($i);
        }
        else
        {
            if (!$this->edit_validate())
            {
                echo json_encode(array('err'=>$this->form_validation->error_array(),'msg'=>  validation_errors()));
                exit;
            }
            $r = $this->m_sparepartscategory_m->save($i, $id);
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
        $this->form_validation->set_rules('M_SparePartsCategoryName', 'Nama Spare Parts', 'required');
        return $this->form_validation->run();
    }
    
    function edit_validate()
    {
        $this->form_validation->set_rules('M_SparePartsCategoryName', 'Nama Spare Parts', 'required');
        return $this->form_validation->run();
    }
    
    function delete()
    {
        $i = $this->input->post();
        $i['M_SparePartsCategoryUserID'] = $this->user->UserID;
        $i['M_SparePartsCategoryLastUpdate'] = date('Y-m-d H:i:s');
        $i['M_SparePartsCategoryIsActive'] = 'N';
        $r = $this->m_sparepartscategory_m->save($i, $i['M_SparePartsCategoryID']);
        echo json_encode(array('rst'=>$r,'msg'=>'Data driver berhasil dihapus'));
        return;
    }
    
  
}
?>

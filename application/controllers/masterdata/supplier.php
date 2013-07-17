<?php

class Supplier extends MY_Controller
{
    function __construct() 
    {
        parent::__construct();
        
        $this->load->model('masterdata/m_supplier_m');
    }
    
    function index()
    {
        $data['extrajs'] = array('m_supplier');
        
        //table parameter
        $tblprm = array(
            'id'        => 'dynamic',
            'source'    => base_url() . 'masterdata/supplier/listing',
            'columns'   => array('M_SupplierCode', 'M_SupplierName','M_SupplierPhone','M_SupplierHP', 'M_SupplierAddress'),
            'titles'    => array('Kode', 'Nama', 'Telepon', 'Hp','Alamat'),
            
            //total column widths = 75%
            //the rest 25% has been used for the Action button
            'widths'    => array('5', '20', '5', '5','50'),
            
            //now, we're adding edit button
            //write the button action prefix here
            'edit'      => 'm_supplier_',
            'delete'    => 'm_supplier_',
            'dLength'   => 1
        );
        
        $data['content'] = $this->load->view('parts/dataTable', $tblprm, true);
        $data['formCRUD'] = '';
        $data['tableTitle'] = 'Master Data Suplier';
        $this->load->view('pages/masterdata', $data);
    }
    
    function form($id)
    {
        
        if ($id == 'new')
        {
            $form = array(
                array(
                    'title' => 'Data Suplier ',
                    'col0' => array(
                        array('label'=>'Kode','field'=>  form_input('M_SupplierCode', '')),
                        array('label'=>'Telepon','field'=>  form_input('M_SupplierPhone', '')),
                        array('label'=>'Fax','field'=>  form_input('M_SupplierFax', ''))
                        ),
                    'col1' => array(
                        array('label'=>'Nama','field'=>  form_input('M_SupplierName', '')),
                        array('label'=>'HP','field'=>  form_input('M_SupplierHP', '')),
                        array('label'=>'Alamat','field'=>  form_textarea('M_SupplierAddress', ''))
                    )
                )
            );
            
        }
        else
        {
            $d = $this->m_supplier_m->get($id);
            
            $form = array(
                 array(
                    'title' => 'Data Suplier ',
                    'col0' => array(
                        array('label'=>'Kode','field'=>  form_input('M_SupplierCode', $d->M_SupplierCode).
                           form_hidden('M_SupplierID', $d->M_SupplierID)),
                        array('label'=>'Telepon','field'=>  form_input('M_SupplierPhone', $d->M_SupplierPhone)),
                        array('label'=>'Fax','field'=>  form_input('M_SupplierFax', $d->M_SupplierFax))
                        ),
                    'col1' => array(
                        array('label'=>'Nama','field'=>  form_input('M_SupplierName', $d->M_SupplierName)),
                        array('label'=>'HP','field'=>  form_input('M_SupplierHP', $d->M_SupplierHP)),
                        array('label'=>'Alamat','field'=>  form_textarea('M_SupplierAddress', $d->M_SupplierAddress))
                    )
                )
            );
        }
        echo $this->load->view('parts/formCRUD', array('form'=>$form,'formname'=>'formsupplier'), true);
        
        return true;
    }
    
    function listing()
    {
        //getting param data
        list($tot_rec,$tot_disp_rec,$r) = $this->m_supplier_m->listing($this->input,
			array("M_SupplierName") );
        
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
        //$i['M_DriversLastUpdate'] = date('Y-m-d H:i:s');
        $i['M_SupplierUserID'] = $this->user->UserID;
        
        if ($id == 'new')
        {
            if (!$this->save_validate())
            {
                echo json_encode(array('err'=>$this->form_validation->error_array(),'msg'=>  validation_errors()));
                exit;
            }
            $r = $this->m_supplier_m->save($i);
        }
        else
        {
            if (!$this->edit_validate())
            {
                echo json_encode(array('err'=>$this->form_validation->error_array(),'msg'=>  validation_errors()));
                exit;
            }
            $r = $this->m_supplier_m->save($i, $id);
        }
        
        if (!$r)
        {
            echo json_encode(array('err'=>'Error tenan','msg'=>'Error pancene'));
        }
        else
        {
            echo json_encode(array('rst'=>$r,'msg'=>'Data suplier berhasil disimpan'));
            return;
        }
    }
    
    function save_validate()
    {
        $this->form_validation->set_rules('M_SupplierName', 'Nama', 'required');
        return $this->form_validation->run();
    }
    
    function edit_validate()
    {
        $this->form_validation->set_rules('M_SupplierName', 'Nama', 'required');
        return $this->form_validation->run();
    }
    
    function delete()
    {
        $i = $this->input->post();
        $i['M_SupplierUserID'] = $this->user->UserID;
        $i['M_SupplierLastUpdate'] = date('Y-m-d H:i:s');
        $i['M_SupplierIsActive'] = 'N';
        $r = $this->m_supplier_m->save($i, $i['M_SupplierID']);
        echo json_encode(array('rst'=>$r,'msg'=>'Data suplier berhasil dihapus'));
        return;
    }
    
    
    
}
?>

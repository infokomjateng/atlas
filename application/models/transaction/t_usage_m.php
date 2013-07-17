<?php

class T_usage_m extends MY_Model
{
    function __construct()
    {
        $this->table_name = 't_usage';
        $this->primary_key = 'T_UsageID';
        $this->active_field = 'IsActive';
    }
    
    function get($ids = false)
    {
        $this->db->join('t_usagedetail', 'T_UsageID = T_UsageDetailT_UsageID AND T_UsageIsActive = T_UsageDetailIsActive', 'left');
        return parent::get($ids);
    }
    
    function save($data, $id = false)
    {
        
        $this->db->trans_start();
        
        $p['T_PurchasingDate']              = $data['T_PurchasingDate'];
        $p['T_PurchasingNumber']            = $data['T_PurchasingNumber'];
        $p['T_PurchasingO_BranchCode']      = $data['T_PurchasingO_BranchCode'];
        $p['T_PurchasingM_SupplierCode']    = $data['T_PurchasingM_SupplierCode'];
        $p['T_PurchasingTotal']             = $data['T_PurchasingTotal'];
        $p['T_PurchasingTempo']             = $data['T_PurchasingTempo'];
        $p['T_PurchasingUserID']            = $data['T_PurchasingUserID'];
        $r = parent::save($p);
        $pid = $this->db->insert_id();
        
        $d = array();
        foreach ($data['code'] as $k => $v)
        {
            $q['T_PurchasingDetailT_PurchasingID']      = $pid;
            $q['T_PurchasingDetailT_PurchasingNumber']  = $data['T_PurchasingNumber'];
            $q['T_PurchasingDetailM_SparePartsCode']    = $v;
            $q['T_PurchasingDetailQty']                 = $data['qty'][$k];
            $q['T_PurchasingDetailPrice']               = $data['price'][$k];
            $q['T_PurchasingDetailDiscount1']           = $data['disc1'][$k];
            $q['T_PurchasingDetailDiscount2']           = $data['disc2'][$k];
            $q['T_PurchasingDetailDiscount3']           = $data['disc3'][$k];
            $q['T_PurchasingDetailLastUpdate']          = date('Y-m-d H:i:s');
            $q['T_PurchasingDetailUserID']              = $data['T_PurchasingUserID'];
            
            $q['T_PurchasingDetailTotal']               = $data['qty'][$k] * $data['price'][$k] * (100 - $data['disc1'][$k]) / 100;
            $q['T_PurchasingDetailTotal']               = $q['T_PurchasingDetailTotal'] * (100 - $data['disc2'][$k]) / 100;
            $q['T_PurchasingDetailTotal']               = $q['T_PurchasingDetailTotal'] * (100 - $data['disc3'][$k]) / 100;
            
            array_push($d, $q);
        }
        $this->db->insert_batch('t_purchasingdetail', $d);
        
        /**
         * Stock Log 
         */
        foreach ($data['code'] as $k => $v)
        {
            /* 1. find stock */
            $r = $this->db->where('L_StockM_SparePartsCode', $v)
                    ->where('L_StockDate', date('Y-m-d'))
                    ->where('L_StockIsActive', 1)
                    ->get('l_stock')
                    ->row();

            /* 2. update stock */
            if ($r)
            {
                $this->db->where('L_StockM_SparePartsCode', $v)
                        ->where('L_StockDate', date('Y-m-d'))
                        ->update('l_stock', array(
                            'L_StockLastUpdate' => date('Y-m-d H:i:s'),
                            'L_StockAmount' => $r->L_StockAmount - $data['qty'][$k]
                )); 
            }
            
            /* insert stock */
            else
            {
                $this->db->insert('l_stock', array(
                    'L_StockDate' => date('Y-m-d'),
                    'L_StockM_SparePartsCode' => $v,
                    'L_StockAmount' => $data['qty'][$k],
                    'L_StockLastUpdate' => date('Y-m-d H:i:s')
                ));
            }
        }
        
        $this->db->trans_complete();
        return $r;
    }
}
?>

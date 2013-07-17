<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class MY_Model extends CI_Model
{
    public $table_name;
    
    public $primary_key;
    
    public $active_field = 'IsActive';
    
    public $my_active_field;
    
    public $salt = '34Sy';
    
    /**
     * The filter that is used on the primary key. Since most primary keys are 
     * autoincrement integers, this defaults to intval. On non-integers, you would 
     * typically use something like xss_clean of htmlentities.
     * @var string
     */
    public $primaryFilter = 'htmlentities'; // htmlentities for string keys

    
    function __construct() 
    {
        parent::__construct();
        
        $this->load->database();
    }
    
    public function get ($ids)
    {
        $this->db->from($this->table_name);
        
        if ($ids)
        {
            $r = $this->db->where($this->table_name . '.' . $this->primary_key, $ids)
                ->get()->row();
            return $r;
        }
        
        $r = $this->db->get()->result_array();
        return $r;
    }
    
    private function _gen_search ($inp,$ar_search) {
            $t = $this->table_name . '_m';
            $this->load->model($t);
            
            $active_flag = $this->table_name . "." . preg_replace('/(xtra\_)/', '', $this->table_name) . $this->active_field; 
            if (isset($this->$t->my_active_field))
                    if ($this->$t->my_active_field != "")
                            $active_flag = $this->$t->my_active_field;

            $x = "( ({$active_flag}=1) ";
                    
            $s_search = $inp->get("sSearch");
            if ($s_search != "") {
                    //search based on ar_search
                    if (count($ar_search)>0) {
                            $n = 0;
                            $x .= "AND ( ";
                            foreach($ar_search as $s_field) {
                                    $x .= $n == 0 ? "{$s_field} LIKE '%{$s_search}%' " : "OR {$this->table_name}.{$s_field} LIKE '%{$s_search}%' ";
                                    $n++;
                            }

                            $x .= " ) ";
                    }
            }
            
            $x .= " )";
            $this->db->where($x, NULL, FALSE);
    }
    
    public function listing($inp,$ar_search, $fn_count = FALSE) {
            $this->db->stop_cache();
            
            $iDisplayLength = $inp->get("iDisplayLength");
            $iDisplayStart = $inp->get("iDisplayStart");

            if ($iDisplayLength > -1)
                $this->db->limit($iDisplayLength)->offset($iDisplayStart);
            
            $new_ar_search = array();
            for($i=0;$i< $inp->get("iSortingCols"); $i++) {
                    $idx = $inp->get("iSortCol_" . $i);
                    $sort_field = $inp->get("mDataProp_$idx");
                    $sort_dir = $inp->get("sSortDir_$i");
                    $new_ar_search[] = $sort_field;

                    $this->db->order_by($sort_field,$sort_dir);
            }
            
            if (count($new_ar_search) > 0 ) {
                $ar_search = $new_ar_search;
            }

            //searching
            $this->_gen_search($inp, $ar_search);
            
            $x = $this->table_name . '_m';
            $this->load->model($x);
            $this->db->start_cache();
            $xrst = $this->$x->get();
            $this->db->stop_cache();
            
            /**
             * Counting all results 
             */
            if (method_exists($this->$x, '_count_record_first')) {
                    $this->db->flush_cache();
                    list($tot_rec, $tot_disp_rec) = $this->$x->_count_record_first($inp, $ar_search);
                
            } else if ($fn_count && method_exists($this->$x, $fn_count)) {
                    $this->db->flush_cache();
                    list($tot_rec, $tot_disp_rec) = $this->$x->$fn_count($inp, $ar_search);
                    
            } else {
                    //searching
                    $this->_gen_search($inp, $ar_search);
                    $this->db->select("count(*) as cnt");
            
                    if (method_exists($this->$x, '_count_record'))
                        $x = $this->$x->_count_record();
                    else
                        $x = $this->db->get($this->table_name)->row();
                    
                    if ($x) { 
                        $tot_rec = $x->cnt;
                        $tot_disp_rec= $x->cnt;
                    } else {
                        $tot_rec = 0;
                        $tot_disp_rec= 0;
                    }
            }
            
            $this->db->flush_cache();
            
            //manipulating data
            foreach ($xrst as $k => $v)
            {
                $xrst[$k]['xaction'] = '';
            }
            
            return array($tot_rec,$tot_disp_rec,$xrst);		
    }
    
    public function save($data, $id = FALSE)
    {
        if (isset($data['cmd']))
            unset($data['cmd']);
        
        $data[ucfirst(preg_replace('/(xtra\_)/', '', $this->table_name)) . 'LastUpdate'] = date('Y-m-d H:i:s');
        if ($id == FALSE) {
            
            // This is an insert
            $this->db->set($data)->insert($this->table_name);
        }
        else {
            
            // This is an update
            $filter = $this->primaryFilter;
            $ret_db = $this->db->set($data)->where($this->primary_key, $filter($id))->update($this->table_name);
			if (!$ret_db) $id = FALSE;
        }
        
        // Return the ID
        return $id == FALSE ? $this->db->insert_id() : $id;
    }
    
    /**
     * Get one or more records as a key=>value pair array.
     *
     * @param string $key_field The field that holds the key
     * @param string $value_field The field that holds the value
     * @param mixed $id An ID or an array of IDs (optional, default = FALSE)
     * @uses get
     * @return array
     * @author Joost van Veen
     */
    public function get_key_value ($key_field, $value_field, $ids = FALSE, $customselect = FALSE, $customvalue = FALSE){
        
        // Get records
        $t = $this->table_name . '_m';
        $this->load->model($t);
            
        $active_flag = $this->table_name . "." . preg_replace('/(xtra\_)/', '', $this->table_name) . $this->active_field; 
            if (isset($this->$t->my_active_field))
                    if ($this->$t->my_active_field != "")
                            $active_flag = $this->$t->my_active_field;
        $this->db->where($active_flag, 1);            
        if (!$customselect) $this->db->select($key_field . ', ' . $value_field, false);
        $result = $this->get($ids);
        
        // Turn results into key=>value pair array.
        $data = array();
        if (count($result) > 0) {
            
            if ($ids != FALSE && !is_array($ids)) {
                $result = array($result);
            }
            
            if ($customvalue) {
                foreach ($customvalue as $k => $v) {
                    $data[$k] = $v;
                }
            }
            
            foreach ($result as $row) {
                if (strpos($key_field, ' as ')) {
                        $k = explode(' as ', $key_field); 
                        $v = explode(' as ', $value_field);
                        
                        $key_field = $k[1];
                        $value_field = $v[1];
                }
                        
                    
                $data[$row[$key_field]] = $row[$value_field];
            }
            
            
        }
        
        return $data;
    }
    
    /**
     * Get one or more records as a key=>value pair array.
     *
     * @param string $key_field The field that holds the key
     * @param string $value_field The field that holds the value
     * @param mixed $id An ID or an array of IDs (optional, default = FALSE)
     * @uses get
     * @return array
     * @author Joost van Veen
     */
    public function get_key_value_2 ($key_field, $value_field, $ids = FALSE, $customselect = FALSE, $customvalue = FALSE){
        
        // Get records
        $t = $this->table_name . '_m';
        $this->load->model($t);
            
        $active_flag = $this->table_name . "." . preg_replace('/(xtra\_)/', '', $this->table_name) . $this->active_field; 
            if (isset($this->$t->my_active_field))
                    if ($this->$t->my_active_field != "")
                            $active_flag = $this->$t->my_active_field;
        $this->db->where($active_flag, 1);            
        $this->db->select($key_field . ', ' . $value_field, false);
        $result = $this->get($ids);
        
        // Turn results into key=>value pair array.
        $data = array();
        if (count($result) > 0) {
            
            if ($ids != FALSE && !is_array($ids)) {
                $result = array($result);
            }
            
            if ($customvalue) {
                foreach ($customvalue as $k => $v) {
                    $data[$k] = $v;
                }
            }
            
            foreach ($result as $row) {
                if (strpos($key_field, ' as ')) {
                        $k = explode(' as ', $key_field); 
                        $v = explode(' as ', $value_field);
                        
                        $key_field = $k[1];
                        $value_field = $v[1];
                }
                        
                    
                $data[$row[$key_field]] = $row[$value_field];
            }
            
            
        }
        
        return $data;
    }
    
    public function clean_mysqli_connection( $dbc ) {
        while( mysqli_more_results($dbc) )
        {
            if(mysqli_next_result($dbc))
            {
                $result = mysqli_use_result($dbc);

                unset($result);
            } 
        }
    }
}
?>

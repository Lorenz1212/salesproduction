<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Serverside_model extends CI_Model {
    /*
     * Fetch members data from the database
     * @param $_POST filter data based on the posted parameters
     */
    public function getRows($postData,$table,$column_order,$column_search,$order,$column_where){
        $this->_get_datatables_query($postData,$table,$column_order,$column_search,$order,$column_where);
        if($postData['length'] != -1){
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    /*
     * Count all records
     */
    public function countAll($table,$column_where){
        $this->db->from($table);
        if($column_where !=false){
            $this->db->where($column_where);
        }
        return $this->db->count_all_results();
    }
    /*
     * Count records based on the filter params
     * @param $_POST filter data based on the posted parameters
     */
    public function countFiltered($postData,$table,$column_order,$column_search,$order,$column_where){
        $this->_get_datatables_query($postData,$table,$column_order,$column_search,$order,$column_where);
        $query = $this->db->get();
        return $query->num_rows();
    }
    /*
     * Perform the SQL queries needed for an server-side processing requested
     * @param $_POST filter data based on the posted parameters
     */

    private function _get_datatables_query($postData,$table,$column_order,$column_search,$order,$column_where){
        $this->db->from($table);
        if($column_where !=false){
            $this->db->where($column_where);
        }
        $i = 0;
        // loop searchable columns 
        foreach($column_search as $item){
            // if datatable send POST for search
            if($postData['search']['value']){
                // first loop
                if($i===0){
                    // open bracket
                    $this->db->group_start();
                    $this->db->like($item, $postData['search']['value']);
                }else{
                    $this->db->or_like($item, $postData['search']['value']);
                }
                
                // last loop
                if(count($column_search) - 1 == $i){
                    // close bracket
                    $this->db->group_end();
                }
            }
            $i++;
        }
         
        if(isset($postData['order'])){
            $this->db->order_by($column_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        }else if(isset($order)){
            $order = $order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
}
?>
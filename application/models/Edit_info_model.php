<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Edit_info_model extends CI_Model {

    public function getInfo() {
        $query = $this->db->get('tbl_info'); 
        return $query->result_array();
    }

    public function editInfo($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('tbl_info', $data);
    }
}


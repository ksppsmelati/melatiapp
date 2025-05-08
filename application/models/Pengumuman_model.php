<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengumuman_model extends CI_Model {
    // public function getPengumuman() {
    //     $query = $this->db->get('tbl_pengumuman');
    //     return $query->row(); // Return the entire row
    // }
    public function getPengumuman() {
        $this->db->order_by('tanggal', 'desc'); // Order by the 'tanggal' column in descending order
        $this->db->limit(1); // Limit the result to only one row
        $query = $this->db->get('tbl_pengumuman');
        return $query->row(); // Return the latest row
    }
    
    

}

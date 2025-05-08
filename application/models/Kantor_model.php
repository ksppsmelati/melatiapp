<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kantor_model extends CI_Model {

    private $tbl_kantor = 'tbl_kantor';
    private $tbl_user = 'tbl_user';

    // Function to get all kantor data
    public function get_all_kantor() {
        return $this->db->get($this->tbl_kantor)->result();
    }

    // Function to get kantor by ID
    public function get_kantor_by_id($id) {
        return $this->db->get_where($this->tbl_kantor, array('id' => $id))->row();
    }

    // Function to get kantor by kode_kantor
    public function get_kantor_by_kode_kantor($kode_kantor) {
        return $this->db->get_where($this->tbl_kantor, array('kode_kantor' => $kode_kantor))->row();
    }

    public function get_all_kantor_with_users() {
        // Query to join tbl_kantor with tbl_user based on kode_kantor
        $this->db->select('tbl_kantor.kode_kantor, tbl_kantor.nama_kantor, tbl_kantor.link_map, tbl_kantor.alamat, tbl_kantor.telepon, tbl_user.level, tbl_user.nama_lengkap');
        $this->db->from($this->tbl_kantor);
        $this->db->join($this->tbl_user, 'tbl_kantor.kode_kantor = tbl_user.kode_kantor', 'left');
        $this->db->where('tbl_user.status', 'aktif');
        $this->db->order_by('tbl_kantor.kode_kantor', 'ASC');
        return $this->db->get()->result();
    }    

    // Function to get all kantor where status is aktif
    public function get_active_kantor() {
        $this->db->where('status', 'aktif');
        return $this->db->get($this->tbl_kantor)->result();
    }

    // Function to insert new kantor data
    public function insert_kantor($data) {
        $this->db->insert($this->tbl_kantor, $data);
        return $this->db->insert_id(); // Return the ID of the newly inserted record
    }

    // Function to update kantor data
    public function update_kantor($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update($this->tbl_kantor, $data);
    }

    // Function to delete kantor by ID
    public function delete_kantor($id) {
        $this->db->where('id', $id);
        $this->db->delete($this->tbl_kantor);
        return $this->db->affected_rows() > 0; // Return true if rows were affected
    }
}

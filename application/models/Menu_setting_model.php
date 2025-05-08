<?php

class Menu_setting_model extends CI_Model {

    // Fungsi untuk mengambil semua data menu
    public function get_all_menu() {
        $this->db->select('*');
        $this->db->from('tbl_user_main_menu');
        return $this->db->get()->result();
    }

    // Fungsi untuk mengambil menu berdasarkan id_menu
    public function get_menu_by_id($id_menu) {
        $this->db->select('*');
        $this->db->from('tbl_user_main_menu');
        $this->db->where('id_menu', $id_menu);
        return $this->db->get()->row();
    }

    // Fungsi untuk menambahkan data menu baru
    public function insert_menu($data) {
        return $this->db->insert('tbl_user_main_menu', $data);
    }

    // Fungsi untuk mengupdate data menu
    public function update_menu($id_menu, $data) {
        $this->db->where('id_menu', $id_menu);
        return $this->db->update('tbl_user_main_menu', $data);
    }

    // Fungsi untuk menghapus menu berdasarkan id_menu
    public function delete_menu($id_menu) {
        $this->db->where('id_menu', $id_menu);
        return $this->db->delete('tbl_user_main_menu');
    }
}

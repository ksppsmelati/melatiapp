<?php
class Menu_model extends CI_Model {
    
    // Fungsi untuk mengambil semua data menu
    public function get_all_menus() {
        $this->db->select('id_menu, menu_name, icon, url');
        $this->db->from('tbl_user_main_menu');
        return $this->db->get()->result();
    }
    
    // Fungsi untuk mengecek akses menu untuk user tertentu
    public function get_user_menu_access($id_user) {
        $this->db->select('id_menu, has_access');
        $this->db->from('tbl_user_main_menu_access');
        $this->db->where('id_user', $id_user);
        return $this->db->get()->result();
    }
    
    // Fungsi untuk mendapatkan menu yang bisa diakses oleh user
    public function get_user_accessible_menus($id_user) {
        $this->db->select('m.id_menu, m.menu_name, m.icon, m.url');
        $this->db->from('tbl_user_main_menu m');
        $this->db->join('tbl_user_main_menu_access a', 'm.id_menu = a.id_menu');
        $this->db->where('a.id_user', $id_user);
        $this->db->where('a.has_access', 1);  // hanya menampilkan menu yang diakses
        return $this->db->get()->result();
    }
    public function get_user_accessible_menus_umum() {
        $this->db->select('m.id_menu, m.menu_name, m.icon, m.url, m.category');
        $this->db->from('tbl_user_main_menu m');
        $this->db->where('m.category', 'umum');
        return $this->db->get()->result();
    }

    public function get_user_accessible_menus_alat() {
        $this->db->select('m.id_menu, m.menu_name, m.icon, m.url, m.category');
        $this->db->from('tbl_user_main_menu m');
        $this->db->where('m.category', 'alat');
        return $this->db->get()->result();
    }

    public function get_user_accessible_menus_keuangan() {
        $this->db->select('m.id_menu, m.menu_name, m.icon, m.url, m.category');
        $this->db->from('tbl_user_main_menu m');
        $this->db->where('m.category', 'keuangan');
        return $this->db->get()->result();
    }

    public function get_user_accessible_menus_lainnya() {
        $this->db->select('m.id_menu, m.menu_name, m.icon, m.url, m.category, m.custom');
        $this->db->from('tbl_user_main_menu m');
        $this->db->where('m.category', 'lainnya');
        return $this->db->get()->result();
    }

    public function get_user_accessible_menus_navigasi() {
        $this->db->select('m.id_menu, m.menu_name, m.icon, m.url, m.category, m.custom');
        $this->db->from('tbl_user_main_menu m');
        $this->db->where('m.category', 'navigasi');
        return $this->db->get()->result();
    }
}

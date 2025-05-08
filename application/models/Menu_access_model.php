<?php

class Menu_access_model extends CI_Model
{

    // Fungsi untuk mengambil semua data menu access dengan join ke tbl_user dan tbl_user_main_menu
    public function get_all_menu_access()
    {
        $this->db->select('tbl_user_main_menu_access.*, tbl_user.nama_lengkap, tbl_user.level, tbl_user.status, tbl_user.kode_kantor, tbl_user_main_menu.menu_name, tbl_user_main_menu.icon, tbl_user_main_menu.url');
        $this->db->from('tbl_user_main_menu_access');
        $this->db->join('tbl_user', 'tbl_user.id_user = tbl_user_main_menu_access.id_user', 'left');
        $this->db->join('tbl_user_main_menu', 'tbl_user_main_menu.id_menu = tbl_user_main_menu_access.id_menu', 'left');
        $this->db->where('tbl_user.status', 'aktif');
        return $this->db->get()->result();
    }

    // Fungsi untuk mengambil menu access berdasarkan id_access dengan join ke tbl_user dan tbl_user_main_menu
    public function get_menu_access_by_id($id_access)
    {
        $this->db->select('tbl_user_main_menu_access.*, tbl_user.nama_lengkap, tbl_user.level, tbl_user_main_menu.menu_name, tbl_user_main_menu.icon, tbl_user_main_menu.url');
        $this->db->from('tbl_user_main_menu_access');
        $this->db->join('tbl_user', 'tbl_user.id_user = tbl_user_main_menu_access.id_user', 'left');
        $this->db->join('tbl_user_main_menu', 'tbl_user_main_menu.id_menu = tbl_user_main_menu_access.id_menu', 'left');
        $this->db->where('tbl_user_main_menu_access.id_access', $id_access);
        return $this->db->get()->row();
    }

    public function get_menu_access_by_user($id_user)
    {
        $this->db->select('tbl_user_main_menu_access.*, tbl_user.nama_lengkap, tbl_user.level, tbl_user_main_menu.menu_name, tbl_user_main_menu.icon, tbl_user_main_menu.url');
        $this->db->from('tbl_user_main_menu_access');
        $this->db->join('tbl_user', 'tbl_user.id_user = tbl_user_main_menu_access.id_user', 'left');
        $this->db->join('tbl_user_main_menu', 'tbl_user_main_menu.id_menu = tbl_user_main_menu_access.id_menu', 'left');
        $this->db->where('tbl_user_main_menu_access.id_user', $id_user);
        return $this->db->get()->result();
    }

    // Fungsi untuk menambahkan data menu baru
    public function insert_menu_access($data)
    {
        return $this->db->insert('tbl_user_main_menu_access', $data);
    }

    // Fungsi untuk mengupdate data menu
    public function update_menu_access($id_access, $data)
    {
        $this->db->where('id_access', $id_access);
        return $this->db->update('tbl_user_main_menu_access', $data);
    }

    // Fungsi untuk menghapus menu berdasarkan id_menu
    public function delete_menu_access($id_access)
    {
        $this->db->where('id_access', $id_access);
        return $this->db->delete('tbl_user_main_menu_access');
    }
}

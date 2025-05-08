<?php
defined('BASEPATH') OR die('No direct script access allowed!');

class Karyawan_model extends CI_Model
{
    public function get_all()
    {
        $this->db->join('divisi', 'tbl_user.kode_devisi = divisi.id_divisi', 'LEFT');
        $this->db->where('level', 'marketing');
        $result = $this->db->get('tbl_user');
        return $result->result();
    }

    public function find($id)
    {
        $this->db->join('divisi', 'tbl_user.kode_devisi = divisi.id_divisi', 'LEFT');
        $this->db->where('id_user', $id);
        $result = $this->db->get('tbl_user');
        return $result->row();
    }

    public function insert_data($data)
    {
        $result = $this->db->insert('tbl_user', $data);
        return $result;
    }

    public function update_data($id, $data)
    {
        $this->db->where('id_user', $id);
        $result = $this->db->update('tbl_user', $data);
        return $result;
    }

    public function delete_data($id)
    {
        $this->db->where('id_user', $id);
        $result = $this->db->delete('tbl_user');
        return $result;
    }
}

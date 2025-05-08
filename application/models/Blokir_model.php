<?php
class Blokir_model extends CI_Model
{
    public function get_all_blokir()
    {
        $this->db->select('*');
        $this->db->from('tbl_blokir');
        $this->db->order_by('tanggal', 'DESC'); // Ganti 'tanggal' dengan kolom yang ingin Anda urutkan secara descending
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_all_blokir_proses()
    {
        $this->db->select('*');
        $this->db->from('tbl_blokir');
        $this->db->where('status', 'proses');  // Fetch only 'proses' records
        $this->db->order_by('tanggal', 'DESC'); // Order by 'tanggal' descending
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_all_blokir_done()
    {
        $this->db->select('*');
        $this->db->from('tbl_blokir');
        $this->db->where('status', 'done');  // Fetch only 'done' records
        $this->db->order_by('tanggal', 'DESC'); // Order by 'tanggal' descending
        $query = $this->db->get();
        return $query->result_array();
    }

    public function simpan_blokir($data)
    {
        $this->db->insert('tbl_blokir', $data);
        return $this->db->insert_id();
    }

    public function hapus_blokir($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tbl_blokir');
    }

    public function get_blokir_by_id($id)
    {
        return $this->db->get_where('tbl_blokir', ['id' => $id])->row_array();
    }

    public function update_blokir($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('tbl_blokir', $data);
    }
}

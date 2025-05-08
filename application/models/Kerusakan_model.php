<?php
class Kerusakan_model extends CI_Model
{
    public function get_all_kerusakan()
    {
        return $this->db->get('tbl_kerusakan')->result_array();
    }

    public function get_all_kerusakan_respond()
    {
    $this->db->select('*');
    $this->db->from('tbl_kerusakan');
    $this->db->where('tindakan IS NOT NULL AND tindakan !=', '');
    $this->db->order_by('created_at', 'DESC');
    return $this->db->get()->result_array();
    }

    public function get_all_kerusakan_waiting()
	{
    $this->db->select('*');
    $this->db->from('tbl_kerusakan');
    $this->db->where('tindakan IS NULL OR tindakan =', '');
    $this->db->order_by('created_at', 'DESC');
    return $this->db->get()->result_array();
	}

    public function simpan_kerusakan($data)
    {
        $this->db->insert('tbl_kerusakan', $data);
        return $this->db->insert_id();
    }

    public function hapus_kerusakan($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tbl_kerusakan');
    }

    public function get_kerusakan_by_id($id)
    {
        return $this->db->get_where('tbl_kerusakan', ['id' => $id])->row_array();
    }

    public function update_kerusakan($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('tbl_kerusakan', $data);
    }
}

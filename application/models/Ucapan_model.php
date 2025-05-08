<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ucapan_model extends CI_Model
{

    // Get all messages
    public function get_all_ucapan()
    {
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get('tbl_ucapan');
        return $query->result();
    }

    // Get a specific message by its ID
    public function get_ucapan_by_id($id_ucapan)
    {
        $this->db->where('id_ucapan', $id_ucapan);
        $query = $this->db->get('tbl_ucapan');
        return $query->row();
    }

    // Add a new message
    public function add_ucapan($data)
    {
        return $this->db->insert('tbl_ucapan', $data);
    }

    // Update an existing message
    public function update_ucapan($id_ucapan, $data)
    {
        $this->db->where('id_ucapan', $id_ucapan);
        return $this->db->update('tbl_ucapan', $data);
    }

    // Delete a message
    public function delete_ucapan($id_ucapan)
    {
        $this->db->where('id_ucapan', $id_ucapan);
        return $this->db->delete('tbl_ucapan');
    }

    // Get today's message based on 'tanggal_kirim'
    public function get_today_ucapan()
    {
        $this->db->where('tanggal_kirim', date('Y-m-d'));
        $query = $this->db->get('tbl_ucapan');
        return $query->row();
    }

    // Get messages that are scheduled after today
    public function get_future_ucapan()
    {
        $this->db->where('tanggal_kirim >', date('Y-m-d'));
        $this->db->order_by('tanggal_kirim', 'ASC');
        $query = $this->db->get('tbl_ucapan');
        return $query->result();
    }

    public function get_ucapan_masuk_aktif()
    {
        $this->db->where('kategori', 'Masuk');
        $this->db->where('status', 'aktif');
        $this->db->order_by('tanggal', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('tbl_ucapan');
        return $query->result();
    }

    public function get_ucapan_pulang_aktif()
    {
        $this->db->where('kategori', 'Pulang');
        $this->db->where('status', 'aktif');
        $this->db->order_by('tanggal', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('tbl_ucapan');
        return $query->result();
    }

    public function get_ucapan_by_day($day, $kategori)
    {
        $this->db->where('hari', $day);
        $this->db->where('kategori', $kategori);
        $this->db->where('status', 'aktif');
        $this->db->order_by('tanggal', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('tbl_ucapan');
        return $query->result();
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Edit_absen_model extends CI_Model {
    public function getAbsenByIdAndDate($id_user, $tanggal) {
        $this->db->where('id_user', $id_user);
        $this->db->where('tgl', $tanggal);
        $query = $this->db->get('tbl_absensi');
        return $query->result_array();
    }

    public function getAbsenByDate($tanggal) {
        $this->db->select('tbl_absensi.*, tbl_user.nama_lengkap');
        $this->db->from('tbl_absensi');
        $this->db->join('tbl_user', 'tbl_user.id_user = tbl_absensi.id_user');
        $this->db->where('tbl_absensi.tgl', $tanggal);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function getAllUsers() {
        $this->db->select('id_user, nama_lengkap, sisa_cuti'); // Pilih hanya kolom yang dibutuhkan
        $this->db->where('status', 'aktif');
        $this->db->order_by('nama_lengkap', 'ASC');
        $query = $this->db->get('tbl_user');
        return $query->result_array();
    }
    
    // Tambahkan method untuk mengambil semua data absen
    public function getAllAbsen() {
        $query = $this->db->get('tbl_absensi');
        return $query->result_array();
    }

    public function getAbsenHariIni() {
        $tanggal_sekarang = date('Y-m-d');
        $this->db->where('tgl', $tanggal_sekarang);
        $query = $this->db->get('tbl_absensi');
        return $query->result_array();
    }

    // Method untuk menyimpan data absen
    public function simpanAbsen($data) {
        $this->db->insert('tbl_absensi', $data);
        return $this->db->insert_id();
    }

    public function getAbsenById($id_absen) {
        $this->db->select('tbl_absensi.*, tbl_user.nama_lengkap');
        $this->db->from('tbl_absensi');
        $this->db->join('tbl_user', 'tbl_user.id_user = tbl_absensi.id_user');
        $this->db->where('tbl_absensi.id_absen', $id_absen);
        $query = $this->db->get();
        return $query->row_array();
    }
    

    // Method untuk mengupdate data absen
    public function updateAbsen($id_absen, $data) {
        $this->db->where('id_absen', $id_absen);
        $this->db->update('tbl_absensi', $data);
        return $this->db->affected_rows(); // Tambahkan baris ini untuk memeriksa apakah pembaruan berhasil
    }
    

    // Method untuk menghapus data absen
    public function hapusAbsen($id_absen) {
        $this->db->where('id_absen', $id_absen);
        $this->db->delete('tbl_absensi');
    }
    
}



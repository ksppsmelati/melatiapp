<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Edit_absen_model_manual extends CI_Model {
    public function getAbsenByIdAndDate($id_user, $tanggal) {
        $this->db->where('id_user', $id_user);
        $this->db->where('tgl', $tanggal);
        $query = $this->db->get('tbl_absensi_manual');
        return $query->result_array();
    }

    public function getAbsenByDate($tanggal) {
        $this->db->select('tbl_absensi_manual.*, tbl_user.nama_lengkap');
        $this->db->from('tbl_absensi_manual');
        $this->db->join('tbl_user', 'tbl_user.id_user = tbl_absensi_manual.id_user');
        $this->db->where('tbl_absensi_manual.tgl', $tanggal);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function getAllUsers() {
        $this->db->select('id_user, nama_lengkap'); // Pilih hanya kolom yang dibutuhkan
        $this->db->order_by('nama_lengkap', 'ASC');
        $query = $this->db->get('tbl_user');
        return $query->result_array();
    }
    
    // Tambahkan method untuk mengambil semua data absen
    public function getAllAbsen() {
        $query = $this->db->get('tbl_absensi_manual');
        return $query->result_array();
    }

    public function getAbsenHariIni() {
        $tanggal_sekarang = date('Y-m-d');
        $this->db->where('tgl', $tanggal_sekarang);
        $query = $this->db->get('tbl_absensi_manual');
        return $query->result_array();
    }

    // Method untuk menyimpan data absen
    public function simpanAbsen($data) {
        $this->db->insert('tbl_absensi_manual', $data);
        return $this->db->insert_id();
    }

    public function getAbsenById($id_absen) {
        $this->db->select('tbl_absensi_manual.*, tbl_user.nama_lengkap');
        $this->db->from('tbl_absensi_manual');
        $this->db->join('tbl_user', 'tbl_user.id_user = tbl_absensi_manual.id_user');
        $this->db->where('tbl_absensi_manual.id_absen', $id_absen);
        $query = $this->db->get();
        return $query->row_array();
    }
    

    // Method untuk mengupdate data absen
    public function updateAbsen($id_absen, $data) {
        $this->db->where('id_absen', $id_absen);
        $this->db->update('tbl_absensi_manual', $data);
        return $this->db->affected_rows(); // Tambahkan baris ini untuk memeriksa apakah pembaruan berhasil
    }
    

    // Method untuk menghapus data absen
    public function hapusAbsen($id_absen) {
        $this->db->where('id_absen', $id_absen);
        $this->db->delete('tbl_absensi_manual');
    }

    public function getAbsenManualByBulan($id_user, $tahun, $bulan) {
        $bulan_tahun = $tahun . '-' . str_pad($bulan, 2, '0', STR_PAD_LEFT);
        $this->db->select('tbl_absensi_manual.*, tbl_user.nama_lengkap');
        $this->db->from('tbl_absensi_manual');
        $this->db->join('tbl_user', 'tbl_user.id_user = tbl_absensi_manual.id_user');
        $this->db->where('tbl_absensi_manual.id_user', $id_user);
        $this->db->like('tbl_absensi_manual.tgl', $bulan_tahun);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getAbsenManualByDateRange($tanggal_awal, $tanggal_akhir)
    {
        $this->db->select('tbl_user.id_user, tbl_user.nama_lengkap, GROUP_CONCAT(tbl_absensi_manual.tgl ORDER BY tbl_absensi_manual.tgl ASC) as tgl_list, GROUP_CONCAT(tbl_absensi_manual.waktu ORDER BY tbl_absensi_manual.tgl ASC) as waktu_list, GROUP_CONCAT(tbl_absensi_manual.keterangan ORDER BY tbl_absensi_manual.tgl ASC) as keterangan_list, GROUP_CONCAT(tbl_absensi_manual.foto_absen ORDER BY tbl_absensi_manual.tgl ASC) as foto_list, GROUP_CONCAT(tbl_absensi_manual.keterangan_absen ORDER BY tbl_absensi_manual.tgl ASC) as keterangan_absen_list');
        $this->db->from('tbl_absensi_manual');
        $this->db->join('tbl_user', 'tbl_user.id_user = tbl_absensi_manual.id_user');
        $this->db->where('tbl_absensi_manual.tgl >=', $tanggal_awal);
        $this->db->where('tbl_absensi_manual.tgl <=', $tanggal_akhir);
        $this->db->group_by('tbl_user.id_user');
        $query = $this->db->get();
        return $query->result();
    }
    
    
}



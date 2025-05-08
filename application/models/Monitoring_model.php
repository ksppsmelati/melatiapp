<?php
class Monitoring_model extends CI_Model
{
    private $tbl_monitoring = 'tbl_monitoring';

    public function get_data_monitoring($tanggal_awal = null, $tanggal_akhir = null)
    {
        if ($tanggal_awal && $tanggal_akhir) {
            $this->db->where('tanggal >=', $tanggal_awal);
            $this->db->where('tanggal <=', $tanggal_akhir);
        }
        
        $this->db->order_by('id', 'DESC');
        return $this->db->get($this->tbl_monitoring)->result();
    }

    public function get_data_monitoring_proses($tanggal_awal = null, $tanggal_akhir = null)
    {
        $this->db->select('*');
        $this->db->from($this->tbl_monitoring);
        $this->db->where('status_proses', '1');
        
        if ($tanggal_awal && $tanggal_akhir) {
            $this->db->where('tanggal >=', $tanggal_awal);
            $this->db->where('tanggal <=', $tanggal_akhir);
        }

        return $this->db->get()->result();
    }

    public function get_all_monitoring($tanggal_awal = null, $tanggal_akhir = null)
    {
        $columns = array(
            'TOFJAMIN.noreg', 'mCIF.nocif', 'TOFLMB.nokontrak',
            'TOFJAMIN.jnsjamin', 'TOFJAMIN.digunakan',
            'TOFJAMIN.jnsdokumen', 'TOFJAMIN.dokumen',
            'TOFJAMIN.an','TOFJAMIN.lokasi', 'TOFJAMIN.catatan', 'TOFJAMIN.kdloc',
            'TOFJAMIN.tglmasuk', 'TOFJAMIN.tglkeluar',
            'mCIF.nm AS nama', 'mCIF.alamat'
        );

        $this->db->select($columns);
        $this->db->from('TOFJAMIN');
        $this->db->join('TOFLMB', 'TOFJAMIN.nokontrak = TOFLMB.nokontrak');
        $this->db->join('mCIF', 'TOFLMB.nocif = mCIF.nocif');

        if ($tanggal_awal && $tanggal_akhir) {
            $this->db->where('TOFJAMIN.tanggal >=', $tanggal_awal);
            $this->db->where('TOFJAMIN.tanggal <=', $tanggal_akhir);
        }

        return $this->db->get()->result();
    }

    public function monitoring_simpan($data)
    {
        $this->db->insert('tbl_monitoring', $data);
        return $this->db->insert_id();
    }

    public function get_monitoring_by_id($id)
    {
        return $this->db->get_where('tbl_monitoring', array('id' => $id))->row();
    }

    public function monitoring_update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('tbl_monitoring', $data);
    }

    public function monitoring_hapus($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tbl_monitoring');
        return $this->db->affected_rows() > 0;
    }

    public function get_jenis_usaha_counts($tanggal_awal = null, $tanggal_akhir = null) {
        $this->db->select('jns_usaha, COUNT(*) as count');
        $this->db->from($this->tbl_monitoring);
        
        if ($tanggal_awal && $tanggal_akhir) {
            $this->db->where('tanggal >=', $tanggal_awal);
            $this->db->where('tanggal <=', $tanggal_akhir);
        }

        $this->db->group_by('jns_usaha'); // Group by jns_usaha to count occurrences
        $query = $this->db->get();
        return $query->result_array(); // Return results as an associative array
    }
}
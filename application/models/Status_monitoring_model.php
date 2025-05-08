<?php
class Status_monitoring_model extends CI_Model
{
    private $tbl_blokir = 'tbl_blokir';
    private $tbl_kerusakan = 'tbl_kerusakan';
    private $tbl_sm = 'tbl_sm';
    private $tbl_kritik_saran = 'tbl_kritik_saran';
    private $tbl_agunan = 'tbl_agunan';
    private $tbl_agunan_shm = 'tbl_agunan_shm';
    private $tbl_monitoring = 'tbl_monitoring';
    private $tbl_absensi = 'tbl_absensi';
    private $tbl_tofjamin = 'TOFJAMIN';
    private $tbl_tabungan = 'tbl_tabungan';
    private $tbl_usulan = 'tbl_usulan';

    // Method to count rows where status is 'proses'
    public function count_proses_blokir()
    {
        $this->db->from($this->tbl_blokir);
        $this->db->where('status', 'proses');
        return $this->db->count_all_results();
    }

    public function count_done_blokir()
    {
        $this->db->from($this->tbl_blokir);
        $this->db->where('status', 'done');
        return $this->db->count_all_results();
    }

    public function count_empty_tindakan()
    {
        $this->db->from($this->tbl_kerusakan);
        $this->db->where('tindakan', ''); 
        return $this->db->count_all_results();
    }

    public function count_filled_tindakan()
    {
        $this->db->from($this->tbl_kerusakan);
        $this->db->where('tindakan !=', ''); 
        return $this->db->count_all_results();
    }    

    public function count_belum_otorisasi()
    {
        $today = date('d-m-Y');
        $this->db->from($this->tbl_sm);
        $this->db->where('dibaca', '0'); 
        $this->db->where('tgl_sm', $today);
        return $this->db->count_all_results();
    }

    public function count_sudah_otorisasi()
    {
        $today = date('d-m-Y');
        $this->db->from($this->tbl_sm);
        $this->db->where('dibaca', '1'); 
        $this->db->where('tgl_sm', $today);
        return $this->db->count_all_results();
    }

    public function count_kritik_saran_belum_direspond()
    {
        $this->db->from($this->tbl_kritik_saran);
        $this->db->where('status', ''); 
        return $this->db->count_all_results();
    }

    public function count_kritik_saran_sudah_direspond()
    {
        $this->db->from($this->tbl_kritik_saran);
        $this->db->where('status !=', ''); 
        return $this->db->count_all_results();
    }

    public function count_agunan()
    {
        $this->db->from($this->tbl_agunan);
        return $this->db->count_all_results();
    }   
    
    public function count_agunan_shm()
    {
        $this->db->from($this->tbl_agunan_shm);
        return $this->db->count_all_results();
    }  

    public function count_agunan_dipesan()
    {
        $this->db->from($this->tbl_agunan);
        $this->db->where('status_proses', '1'); 
        return $this->db->count_all_results();
    }

    public function count_agunan_shm_dipesan()
    {
        $this->db->from($this->tbl_agunan_shm);
        $this->db->where('status_proses', '1'); 
        return $this->db->count_all_results();
    }

    public function count_monitoring()
    {
        $today = date('Y-m-d');
        $this->db->from($this->tbl_monitoring);
        $this->db->where('tanggal', $today);
        return $this->db->count_all_results();
    }

    public function count_absensi()
    {
        $today = date('Y-m-d');
        $this->db->from($this->tbl_absensi);
        $this->db->where('tgl', $today);
        $this->db->where('keterangan', 'masuk');
        return $this->db->count_all_results();
    }

    public function count_tofjamin()
    {
        $this->db->from($this->tbl_tofjamin);
        return $this->db->count_all_results();
    }

    public function count_tabungan()
    {
        $this->db->from($this->tbl_tabungan);
        return $this->db->count_all_results();
    }

    public function get_absensi_tidak_sesuai()
    {
        $this->db->select('
            u.id_user,
            u.username,
            u.nama_lengkap,
            a.tgl AS tanggal,
            a.jam_masuk,
            a.jam_pulang,
            a.jam_izin,
            a.jam_cuti,
            a.jam_sakit,
            a.status_lengkap
        ');
        $this->db->from('tbl_user u');
        $this->db->join('(
            SELECT
                a.id_user,
                a.tgl,
                COUNT(CASE WHEN a.keterangan = "Masuk" THEN 1 END) AS jumlah_masuk,
                GROUP_CONCAT(CASE WHEN a.keterangan = "Masuk" THEN a.waktu END) AS jam_masuk,
                COUNT(CASE WHEN a.keterangan = "Pulang" THEN 1 END) AS jumlah_pulang,
                GROUP_CONCAT(CASE WHEN a.keterangan = "Pulang" THEN a.waktu END) AS jam_pulang,
                COUNT(CASE WHEN a.keterangan = "Izin" THEN 1 END) AS jumlah_izin,
                GROUP_CONCAT(CASE WHEN a.keterangan = "Izin" THEN a.waktu END) AS jam_izin,
                COUNT(CASE WHEN a.keterangan = "Cuti" THEN 1 END) AS jumlah_cuti,
                GROUP_CONCAT(CASE WHEN a.keterangan = "Cuti" THEN a.waktu END) AS jam_cuti,
                COUNT(CASE WHEN a.keterangan = "Sakit" THEN 1 END) AS jumlah_sakit,
                GROUP_CONCAT(CASE WHEN a.keterangan = "Sakit" THEN a.waktu END) AS jam_sakit,
                CASE
                    WHEN COUNT(CASE WHEN a.keterangan = "Masuk" THEN 1 END) = 1
                         AND COUNT(CASE WHEN a.keterangan = "Pulang" THEN 1 END) = 1
                         AND COUNT(CASE WHEN a.keterangan = "Izin" THEN 1 END) <= 1
                         AND COUNT(CASE WHEN a.keterangan = "Cuti" THEN 1 END) <= 1
                         AND COUNT(CASE WHEN a.keterangan = "Sakit" THEN 1 END) <= 1
                    THEN "[OK] Lengkap"
                    WHEN COUNT(CASE WHEN a.keterangan = "Masuk" THEN 1 END) > 1
                         OR COUNT(CASE WHEN a.keterangan = "Pulang" THEN 1 END) > 1
                         OR COUNT(CASE WHEN a.keterangan = "Izin" THEN 1 END) > 1
                         OR COUNT(CASE WHEN a.keterangan = "Cuti" THEN 1 END) > 1
                         OR COUNT(CASE WHEN a.keterangan = "Sakit" THEN 1 END) > 1
                    THEN "Tidak Sesuai"
                    ELSE "Belum Lengkap"
                END AS status_lengkap
            FROM tbl_absensi a
            GROUP BY a.id_user, a.tgl
        ) a', 'u.id_user = a.id_user', 'left');
        $this->db->where('a.status_lengkap', 'Tidak Sesuai');

        $query = $this->db->get();
        return $query->result();
    }

    public function get_usulan_with_duplicate_nik() {
        // Subquery untuk mendapatkan NIK yang memiliki lebih dari satu usulan
        $subquery = $this->db->select('nik')
                             ->from('tbl_usulan')
                             ->group_by('nik')
                             ->having('COUNT(nik) > 1')
                             ->get_compiled_select();

        // Query utama untuk mendapatkan data usulan dengan NIK duplikat
        $this->db->select('*');
        $this->db->from('tbl_usulan');
        $this->db->where("nik IN ($subquery)", null, false);
        $query = $this->db->get();

        // Mengembalikan hasil query sebagai array objek
        return $query->result();
    }
}

<?php
defined('BASEPATH') or die('No direct script access allowed!');

class Absensi_model_manual extends CI_Model
{
    public function get_absen($id_user, $bulan, $tahun)
    {
        $this->db->select("DATE_FORMAT(a.tgl, '%d-%m-%Y') AS tgl,
                  MAX(CASE WHEN a.keterangan = 'Masuk' THEN a.waktu ELSE NULL END) AS jam_masuk,
                  MAX(CASE WHEN a.keterangan = 'Pulang' THEN a.waktu ELSE NULL END) AS jam_pulang");
        $this->db->where('id_user', $id_user);
        $this->db->where("DATE_FORMAT(tgl, '%m') = ", $bulan);
        $this->db->where("DATE_FORMAT(tgl, '%Y') = ", $tahun);
        $this->db->group_by("tgl");
        $result = $this->db->get('tbl_absensi_manual a');
        return $result->result_array();
    }

    public function get_izin_cuti($id_user, $bulan, $tahun, $keterangan)
    {
        $this->db->select("DATE_FORMAT(a.tgl, '%d-%m-%Y') AS tgl, a.keterangan");
        $this->db->where('id_user', $id_user);
        $this->db->where("DATE_FORMAT(tgl, '%m') = ", $bulan);
        $this->db->where("DATE_FORMAT(tgl, '%Y') = ", $tahun);
        $this->db->where('keterangan', $keterangan); // Use the provided $keterangan parameter
        $result = $this->db->get('tbl_absensi_manual a');
        return $result->result_array();
    }


    public function absen_harian_user($id_user)
    {
        $today = date('Y-m-d');
        $this->db->where('tgl', $today);
        $this->db->where('id_user', $id_user);
        $data = $this->db->get('tbl_absensi_manual');
        return $data;
    }

    // public function insert_data($data)
    // {
    //     $result = $this->db->insert('tbl_absensi_manual', $data);
    //     return $result;
    // }

    public function get_jam_by_time($time)
    {
        $this->db->where('start', $time, '<=');
        $this->db->or_where('finish', $time, '>=');
        $data = $this->db->get('tbl_jam');
        return $data->row();
    }

    public function get_rekap_absensi($bulan, $tahun)
    {
        $query = $this->db->query("
            SELECT u.id_user, u.nama_lengkap, DATE_FORMAT(a.tgl, '%d') as day, 
            SUM(CASE WHEN a.keterangan = 'masuk' THEN 1 ELSE 0.5 END) as jumlah_absen
            FROM tbl_user u
            LEFT JOIN tbl_absensi_manual a ON u.id_user = a.id_user
            WHERE DATE_FORMAT(a.tgl, '%m') = ? AND DATE_FORMAT(a.tgl, '%Y') = ?
            GROUP BY u.id_user, u.nama_lengkap, DATE_FORMAT(a.tgl, '%d')
            ORDER BY u.id_user, DATE_FORMAT(a.tgl, '%d')
        ", array($bulan, $tahun));

        return $query->result_array();
    }

    public function get_absen_all_users($id_user, $bulan, $tahun)
    {
        $this->db->select("DATE_FORMAT(tgl, '%d-%m-%Y') AS tgl, keterangan, waktu");
        $this->db->where('id_user', $id_user);
        $this->db->where("DATE_FORMAT(tgl, '%m') = ", $bulan);
        $this->db->where("DATE_FORMAT(tgl, '%Y') = ", $tahun);
        $result = $this->db->get('tbl_absensi_manual');
        return $result->result_array();
    }

    public function getAbsensi($id_user, $bulan, $tahun)
    {
        $this->db->select('DATE_FORMAT(tgl, "%d") as day, keterangan');
        $this->db->where('id_user', $id_user);
        $this->db->where('DATE_FORMAT(tgl, "%m") =', $bulan);
        $this->db->where('DATE_FORMAT(tgl, "%Y") =', $tahun);
        $query = $this->db->get('tbl_absensi_manual');
        return $query->result_array();
    }


    public function insert_data_with_location($data)
    {
        $result = $this->db->insert('tbl_absensi_manual', $data);
        return $result;
    }
    public function check_absen_status($id_user, $keterangan, $latitude, $longitude)
    {
        $this->db->where('id_user', $id_user);
        $this->db->where('keterangan', $keterangan);
        $this->db->where('latitude', $latitude);
        $this->db->where('longitude', $longitude);
        $result = $this->db->get('tbl_absensi_manual');
        return $result->num_rows() > 0;
    }

    public function get_masuk_time($id_user, $tgl)
    {
        $this->db->select('waktu');
        $this->db->where('id_user', $id_user);
        $this->db->where('tgl', $tgl);
        $this->db->where('keterangan', 'Masuk');
        $result = $this->db->get('tbl_absensi_manual');

        return $result->row('waktu');
    }

    public function get_pulang_time($id_user, $tgl)
    {
        $this->db->select('waktu');
        $this->db->where('id_user', $id_user);
        $this->db->where('tgl', $tgl);
        $this->db->where('keterangan', 'Pulang');
        $result = $this->db->get('tbl_absensi_manual');

        return $result->row('waktu');
    }

    public function getAbsensiByDateRange($id_user, $tanggal_awal, $tanggal_akhir)
    {
        $this->db->select('DATE_FORMAT(tgl, "%d") as day, keterangan');
        $this->db->where('id_user', $id_user);
        $this->db->where('tgl >=', $tanggal_awal);
        $this->db->where('tgl <=', $tanggal_akhir);
        $query = $this->db->get('tbl_absensi_manual');
        return $query->result_array();
    }

    public function getJamMasukPulangByDateRange($id_user, $tanggal_awal, $tanggal_akhir)
    {
        $this->db->select('DATE_FORMAT(tgl, "%d") as day, keterangan, waktu');
        $this->db->where('id_user', $id_user);
        $this->db->where('tgl >=', $tanggal_awal);
        $this->db->where('tgl <=', $tanggal_akhir);
        $this->db->where_in('keterangan', ['Masuk', 'Pulang']);
        $query = $this->db->get('tbl_absensi_manual');
        return $query->result_array();
    }

    public function getJamMasukHariIni($id_user)
    {
        $today = date('Y-m-d');
        $this->db->select('waktu');
        $this->db->where('id_user', $id_user);
        $this->db->where('tgl', $today);
        $this->db->where('keterangan', 'Masuk');
        $this->db->order_by('waktu', 'asc');
        $this->db->limit(1);
        $query = $this->db->get('tbl_absensi_manual');
        $result = $query->row();

        return $result ? $result->waktu : null;
    }

    public function getJamPulangHariIni($id_user)
    {
        $today = date('Y-m-d');
        $this->db->select('waktu');
        $this->db->where('id_user', $id_user);
        $this->db->where('tgl', $today);
        $this->db->where('keterangan', 'Pulang');
        $this->db->order_by('waktu', 'desc');
        $this->db->limit(1);
        $query = $this->db->get('tbl_absensi_manual');
        $result = $query->row();

        return $result ? $result->waktu : null;
    }

    // Di dalam model Absensi_model, tambahkan metode getUserData($id_user)
    public function getUserData($id_user)
    {
        $this->db->select('*');
        $this->db->where('id_user', $id_user);
        $query = $this->db->get('tbl_user');
        return $query->row_array();
    }
    public function getUserRekapDataByDateRange($id_user, $tanggal_awal, $tanggal_akhir)
    {
        $query = $this->db->query("
        SELECT 
        SUM(CASE WHEN a1.keterangan = 'Masuk' AND a2.keterangan = 'Pulang' THEN 1 ELSE 0 END) AS hadir,
        SUM(CASE WHEN a1.keterangan = 'Masuk' AND a2.keterangan IS NULL THEN 1 ELSE 0 END) AS setengah_hari,
        SUM(CASE WHEN a1.keterangan = 'Izin' THEN 1 ELSE 0 END) AS izin,
        SUM(CASE WHEN a1.keterangan = 'Cuti' THEN 1 ELSE 0 END) AS cuti,
        SUM(CASE WHEN a1.keterangan = 'Sakit' THEN 1 ELSE 0 END) AS sakit,
        SUM(CASE WHEN a1.keterangan = 'Perjalanan_tugas' THEN 1 ELSE 0 END) AS perjalanan_tugas,
        SUM(CASE WHEN a1.keterangan = 'Masuk' AND TIME(a1.waktu) > '08:00:59' THEN 1 ELSE 0 END) AS telat,
        (
            SELECT COUNT(*)
            FROM (
                SELECT *
                FROM (
                    SELECT DATE_ADD('{$tanggal_awal}', INTERVAL (@row := @row + 1) - 1 DAY) AS date
                    FROM (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6) AS a1
                    CROSS JOIN (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6) AS a2
                    CROSS JOIN (SELECT @row := 0) AS vars
                    WHERE DATE_ADD('{$tanggal_awal}', INTERVAL @row DAY) <= '{$tanggal_akhir}'
                ) dates
                WHERE WEEKDAY(date) < 5
            ) weekdays
            LEFT JOIN tbl_absensi_manual a1 ON WEEKDAY(weekdays.date) < 5 AND a1.id_user = '{$id_user}' AND DATE(a1.tgl) = weekdays.date
            WHERE a1.id_user IS NULL
        ) AS tidak_masuk,
        SUM(CASE WHEN a1.keterangan = 'Masuk' AND a2.keterangan = 'Pulang' THEN 1 ELSE 0 END) + SUM(CASE WHEN a1.keterangan = 'Masuk' AND a2.keterangan IS NULL THEN 1 ELSE 0 END) AS total_hadir
        FROM tbl_absensi_manual a1
        LEFT JOIN tbl_absensi_manual a2 ON a1.id_user = a2.id_user AND DATE(a1.tgl) = DATE(a2.tgl) AND a2.keterangan = 'Pulang'
        WHERE a1.id_user = '{$id_user}' AND DATE(a1.tgl) BETWEEN '{$tanggal_awal}' AND '{$tanggal_akhir}'
    ");

        return $query->row_array();
    }

    public function getKeterangan($id_user, $tgl)
    {
        $this->db->select('keterangan');
        $this->db->where('id_user', $id_user);
        $this->db->where('tgl', $tgl);
        $query = $this->db->get('tbl_absensi_manual');
        return $query->row('keterangan');
    }
    public function getAbsenByDate($tanggal)
    {
        $this->db->select('tbl_user.id_user, tbl_user.nama_lengkap, tbl_user.level, tbl_absensi_manual.keterangan, tbl_absensi_manual.keterangan_absen, tbl_absensi_manual.waktu, tbl_absensi_manual.foto_absen');
        $this->db->from('tbl_user');
        $this->db->join('(SELECT id_user, MAX(waktu) AS max_waktu FROM tbl_absensi_manual WHERE tgl = ' . $this->db->escape($tanggal) . ' GROUP BY id_user) latest_absensi', 'tbl_user.id_user = latest_absensi.id_user', 'left');
        $this->db->join('tbl_absensi_manual', 'tbl_user.id_user = tbl_absensi_manual.id_user AND tbl_absensi_manual.waktu = latest_absensi.max_waktu', 'left');
        $this->db->where('(tbl_absensi_manual.tgl = ' . $this->db->escape($tanggal) . ' OR tbl_absensi_manual.tgl IS NULL)');
        $this->db->where('tbl_user.id_user !=', 0); // Menambahkan kondisi WHERE untuk memfilter id_user yang tidak sama dengan 0
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

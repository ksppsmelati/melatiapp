<?php
class Laporan_kerja_model extends CI_Model
{
    public function get_all_laporan_kerja($selectedMonth, $selectedYear)
    {

        // Selecting specific columns from both tables using aliases
        $this->db->select('u.id_user, u.nama_lengkap, u.level, lk.id, lk.tanggal, lk.jam, lk.pekerjaan, lk.approval, lk.id_user');

        // Joining tbl_user and tbl_laporan_kerja based on id_user
        $this->db->from('tbl_user u');
        $this->db->join('tbl_laporan_kerja lk', 'u.id_user = lk.id_user');

        // Adding where conditions for selected month and year
        $this->db->where('MONTH(lk.tanggal)', $selectedMonth);
        $this->db->where('YEAR(lk.tanggal)', $selectedYear);

        // Getting the result
        $result = $this->db->get()->result_array();

        return $result;
    }

    public function get_laporan_kerja_by_id_user($id_user, $selectedMonth, $selectedYear)
    {
        $this->db->select('lk.id, lk.tanggal, lk.foto_pekerjaan, lk.pekerjaan, lk.approval, lk.id_user');
        $this->db->from('tbl_user u');
        $this->db->join('tbl_laporan_kerja lk', 'u.id_user = lk.id_user');
        $this->db->where('u.id_user', $id_user);

        if ($selectedMonth && $selectedYear) {
            $this->db->where('MONTH(lk.tanggal)', $selectedMonth);
            $this->db->where('YEAR(lk.tanggal)', $selectedYear);
        }

        return $this->db->get()->result_array();
    }


    public function get_laporan_kerja_by_devisi($devisi)
    {
        $this->db->where('devisi', $devisi);
        return $this->db->get('tbl_laporan_kerja')->result_array();
    }

    public function get_laporan_kerja_by_kodeloc($kodeloc)
    {
        $this->db->where('kodeloc', $kodeloc);
        return $this->db->get('tbl_laporan_kerja')->result_array();
    }

    public function get_laporan_kerja_by_id($id)
    {
        $this->db->select('tbl_laporan_kerja.*, tbl_user.nama_lengkap');
        $this->db->from('tbl_laporan_kerja');
        $this->db->join('tbl_user', 'tbl_laporan_kerja.id_user = tbl_user.id_user');
        $this->db->where('tbl_laporan_kerja.id', $id);
        return $this->db->get()->row_array();
    }


    public function laporan_kerja_edit($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('tbl_laporan_kerja', $data);
        return $this->db->affected_rows();
    }

    public function laporan_kerja_hapus($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tbl_laporan_kerja');
        return $this->db->affected_rows();
    }

    public function get_laporan_kerja_by_kode_devisi($kode_kantor, $kode_devisi, $selectedMonth, $selectedYear)
    {
        // Selecting specific columns from both tables using aliases
        $this->db->select('u.id_user, u.nama_lengkap, lk.id, lk.tanggal, lk.jam, lk.pekerjaan, lk.approval');

        // Joining tbl_user and tbl_laporan_kerja based on id_user
        $this->db->from('tbl_user u');
        $this->db->join('tbl_laporan_kerja lk', 'u.id_user = lk.id_user');

        // Adding where condition for kode_kantor
        $this->db->where('u.kode_kantor', $kode_kantor);
        $this->db->where('u.kode_devisi', $kode_devisi);

        // Adding where conditions for selected month and year
        $this->db->where('MONTH(lk.tanggal)', $selectedMonth);
        $this->db->where('YEAR(lk.tanggal)', $selectedYear);

        // Getting the result
        $result = $this->db->get()->result_array();

        return $result;
    }

    public function get_laporan_kerja_by_kode_devisi_all($kode_devisi, $selectedMonth, $selectedYear)
    {
        // Selecting specific columns from both tables using aliases
        $this->db->select('u.id_user, u.nama_lengkap, lk.id, lk.tanggal, lk.jam, lk.pekerjaan, lk.approval');

        // Joining tbl_user and tbl_laporan_kerja based on id_user
        $this->db->from('tbl_user u');
        $this->db->join('tbl_laporan_kerja lk', 'u.id_user = lk.id_user');

        // Adding where condition for kode_devisi
        $this->db->where('u.kode_devisi', $kode_devisi);

        // Adding where conditions for selected month and year
        $this->db->where('MONTH(lk.tanggal)', $selectedMonth);
        $this->db->where('YEAR(lk.tanggal)', $selectedYear);

        // Getting the result
        $result = $this->db->get()->result_array();

        return $result;
    }

    public function get_laporan_kerja_by_kode_atasan($kode_atasan, $selectedMonth, $selectedYear)
    {
        // Selecting specific columns from both tables using aliases
        $this->db->select('u.id_user, u.nama_lengkap, lk.id, lk.tanggal, lk.jam, lk.pekerjaan, lk.approval, lk.foto_pekerjaan');
    
        // Joining tbl_user and tbl_laporan_kerja based on id_user
        $this->db->from('tbl_user u');
        $this->db->join('tbl_laporan_kerja lk', 'u.id_user = lk.id_user');
    
        // Adding where condition for kode_atasan
        $this->db->where('u.kode_atasan', $kode_atasan);
    
        // Adding where conditions for selected month and year
        $this->db->where('MONTH(lk.tanggal)', $selectedMonth);
        $this->db->where('YEAR(lk.tanggal)', $selectedYear);
    
        // Getting the result
        $result = $this->db->get()->result_array();
    
        return $result;
    }    

    public function get_laporan_kerja_by_kode_atasan_2($kode_atasan, $selectedMonth, $selectedYear)
    {
        // Selecting specific columns from both tables using aliases
        $this->db->select('u.id_user, u.nama_lengkap, lk.id, lk.tanggal, lk.jam, lk.pekerjaan, lk.approval');

        // Joining tbl_user and tbl_laporan_kerja based on id_user
        $this->db->from('tbl_user u');
        $this->db->join('tbl_laporan_kerja lk', 'u.id_user = lk.id_user');

        // Adding where condition for kode_atasan
        $this->db->where('u.kode_atasan_2', $kode_atasan);

        // Adding where conditions for selected month and year
        $this->db->where('MONTH(lk.tanggal)', $selectedMonth);
        $this->db->where('YEAR(lk.tanggal)', $selectedYear);

        // Getting the result
        $result = $this->db->get()->result_array();

        return $result;
    }
}

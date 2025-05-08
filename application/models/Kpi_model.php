<?php
class Kpi_model extends CI_Model
{
    private $tbl_kpi = 'tbl_kpi';
    private $tbl_user = 'tbl_user';

    public function get_data_kpi()
    {
        $this->db->select('tbl_kpi.*, tbl_user.nama_lengkap, tbl_user.level, tbl_user.kode_kantor'); // Menambahkan level
        $this->db->from($this->tbl_kpi);
        $this->db->join($this->tbl_user, 'tbl_kpi.id_user = tbl_user.id_user');
        $this->db->order_by('tbl_kpi.id_kpi', 'DESC');
        return $this->db->get()->result();
    }

    public function get_data_kpi_user($id_user)
    {
        $this->db->select('tbl_kpi.*, tbl_user.nama_lengkap, tbl_user.level, tbl_user.kode_kantor'); // Menambahkan level dan kode_kantor dari tbl_user
        $this->db->from($this->tbl_kpi);
        $this->db->join($this->tbl_user, 'tbl_kpi.id_user = tbl_user.id_user');
        $this->db->where('tbl_kpi.id_user', $id_user); // Hanya menampilkan data kpi untuk user dengan id_user yang sesuai
        $this->db->order_by('tbl_kpi.id_kpi', 'DESC');
        return $this->db->get()->result();
    }

    public function get_kpi_by_id($id_kpi)
    {
        $this->db->select('tbl_kpi.*, tbl_user.nama_lengkap, tbl_user.level, tbl_user.kode_kantor');
        $this->db->from($this->tbl_kpi);
        $this->db->join($this->tbl_user, 'tbl_kpi.id_user = tbl_user.id_user');
        $this->db->where('tbl_kpi.id_kpi', $id_kpi);
        return $this->db->get()->row();
    }

    public function get_data_kpi_by_month_year($bulan, $tahun)
    {
        // Select columns from both tbl_kpi and tbl_user
        $this->db->select('tbl_kpi.*, tbl_user.nama_lengkap');
        
        // From the tbl_kpi table
        $this->db->from('tbl_kpi');
        
        // Join with tbl_user on id_user
        $this->db->join('tbl_user', 'tbl_kpi.id_user = tbl_user.id_user');
        
        // Filter by the month and year
        $this->db->where('MONTH(tgl) =', $bulan);
        $this->db->where('YEAR(tgl) =', $tahun);
        
        // Get the result
        return $this->db->get()->result_array();
    }
    
    public function kpi_simpan($data)
    {
        $this->db->insert($this->tbl_kpi, $data);
        return $this->db->insert_id();
    }

    public function kpi_update($id_kpi, $data)
    {
        $this->db->where('id_kpi', $id_kpi);
        return $this->db->update($this->tbl_kpi, $data);
    }

    public function kpi_hapus($id_kpi)
    {
        $this->db->where('id_kpi', $id_kpi);
        $this->db->delete($this->tbl_kpi);
        return $this->db->affected_rows() > 0;
    }
}

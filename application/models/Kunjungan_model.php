<?php
class Kunjungan_model extends CI_Model
{
    private $tbl_kunjungan = 'tbl_kunjungan';

    public function get_all_kunjungan($id_user)
    {
        $this->db->where('id_user', $id_user);
        $this->db->order_by('tanggal', 'ASC');
        return $this->db->get($this->tbl_kunjungan)->result();
    }

    public function get_data_kunjungan($tanggal_awal = null, $tanggal_akhir = null)
    {
        if ($tanggal_awal && $tanggal_akhir) {
            $this->db->where('tanggal >=', $tanggal_awal);
            $this->db->where('tanggal <=', $tanggal_akhir);
        }

        $this->db->order_by('id', 'DESC');
        return $this->db->get($this->tbl_kunjungan)->result();
    }

    public function get_data_kunjungan_by_id_user($id_user, $tanggal_awal = null, $tanggal_akhir = null)
    {
        // Menambahkan kondisi untuk filter berdasarkan id_user
        $this->db->where('id_user', $id_user);

        // Jika tanggal_awal dan tanggal_akhir disediakan, tambahkan filter berdasarkan tanggal
        if ($tanggal_awal && $tanggal_akhir) {
            $this->db->where('tanggal >=', $tanggal_awal);
            $this->db->where('tanggal <=', $tanggal_akhir);
        }

        // Mengurutkan berdasarkan id secara menurun
        $this->db->order_by('id', 'DESC');

        // Mengambil data dari tabel kunjungan
        return $this->db->get($this->tbl_kunjungan)->result();
    }

    // Kunjungan_model.php
    public function get_kunjungan_by_category($tanggal_awal, $tanggal_akhir)
    {
        // Select data yang dibutuhkan, termasuk inpuser dari tbl_kunjungan
        $this->db->select('k.id_user, k.inpuser, k.kode_kantor, COUNT(*) as visit_count');

        // Tabel kunjungan
        $this->db->from($this->tbl_kunjungan . ' k');

        // Filter berdasarkan tanggal
        $this->db->where('k.tanggal >=', $tanggal_awal);
        $this->db->where('k.tanggal <=', $tanggal_akhir);

        // Grouping berdasarkan id_user dan kode_kantor
        $this->db->group_by(['k.id_user', 'k.inpuser', 'k.kode_kantor']);

        // Menjalankan query dan mengembalikan hasilnya
        return $this->db->get()->result();  // Mengembalikan hasil sebagai array objek
    }

    public function get_kunjungan_detail_by_category($tanggal_awal, $tanggal_akhir)
    {
        $this->db->select('id_user, inpuser, tujuan, COUNT(*) as visit_count');
        $this->db->from('tbl_kunjungan');
        $this->db->where('tanggal >=', $tanggal_awal);
        $this->db->where('tanggal <=', $tanggal_akhir);
        $this->db->group_by(['id_user', 'tujuan']);
        return $this->db->get()->result();
    }

    public function get_kunjungan_by_category_tujuan($tanggal_awal, $tanggal_akhir)
    {
        // Select data yang dibutuhkan, termasuk inpuser dari tbl_kunjungan
        $this->db->select('k.id_user, k.inpuser, k.tujuan, COUNT(*) as visit_count');

        // Tabel kunjungan
        $this->db->from($this->tbl_kunjungan . ' k');

        // Filter berdasarkan tanggal
        $this->db->where('k.tanggal >=', $tanggal_awal);
        $this->db->where('k.tanggal <=', $tanggal_akhir);

        // Grouping berdasarkan id_user dan kode_kantor
        $this->db->group_by(['k.id_user', 'k.inpuser', 'k.tujuan']);

        // Menjalankan query dan mengembalikan hasilnya
        return $this->db->get()->result();  // Mengembalikan hasil sebagai array objek
    }

    public function get_kunjungan_by_tujuan($tanggal_awal, $tanggal_akhir)
    {
        $this->db->where('tanggal >=', $tanggal_awal);
        $this->db->where('tanggal <=', $tanggal_akhir);
        $query = $this->db->get('tbl_kunjungan');
        return $query->result();
    }


    public function get_data_kunjungan_by_range($id_user, $tanggal_awal, $tanggal_akhir)
    {
        $this->db->where('id_user', $id_user);
        $this->db->where('tanggal >=', $tanggal_awal);
        $this->db->where('tanggal <=', $tanggal_akhir);
        $this->db->order_by('tanggal', 'ASC');
        return $this->db->get($this->tbl_kunjungan)->result();
    }

    public function kunjungan_simpan($data)
    {
        $this->db->insert('tbl_kunjungan', $data);
        return $this->db->insert_id();
    }

    public function get_kunjungan_by_id($id)
    {
        return $this->db->get_where('tbl_kunjungan', array('id' => $id))->row();
    }

    public function kunjungan_update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('tbl_kunjungan', $data);
    }

    public function kunjungan_hapus($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tbl_kunjungan');
        return $this->db->affected_rows() > 0;
    }
}

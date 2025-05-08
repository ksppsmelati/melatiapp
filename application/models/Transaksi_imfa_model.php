<?php
class Transaksi_imfa_model extends CI_Model
{
    private $TOFTRNC = 'TOFTRNC';

    public function get_all_transaksi()
    {
        return $this->db->get($this->TOFTRNC)->result();
    }

    public function get_all_transaksi_sukses()
    {
        $current_date = date('Ymd'); // Mengambil format tanggal berjalan dalam format YYYYmmdd
        $this->db->where_in('ststrn', ['6', '5']); // Kondisi ststrn = 6 atau 5
        $this->db->where('(drmodul <> "7" OR crmodul <> "7")'); // Kondisi untuk drmodul atau crmodul
        $this->db->where('tgldok', $current_date); // Tambahkan kondisi untuk filter berdasarkan tanggal (YYYYmmdd)
        return $this->db->get($this->TOFTRNC)->result(); // Mengambil data dari tabel
    }

    public function get_data_transaksi($tanggal_awal = null, $tanggal_akhir = null)
    {
        if ($tanggal_awal && $tanggal_akhir) {
            $this->db->where('tanggal >=', $tanggal_awal);
            $this->db->where('tanggal <=', $tanggal_akhir);
        }

        $this->db->order_by('id', 'DESC');
        return $this->db->get($this->TOFTRNC)->result();
    }

    public function get_data_transaksi_by_id_user($id_user, $tanggal_awal = null, $tanggal_akhir = null)
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

        // Mengambil data dari tabel transaksi
        return $this->db->get($this->TOFTRNC)->result();
    }

    // transaksi_model.php
    public function get_transaksi_by_category($tanggal_awal, $tanggal_akhir)
    {
        // Select data yang dibutuhkan, termasuk inpuser dari TOFTRNC
        $this->db->select('k.id_user, k.inpuser, k.kode_kantor, COUNT(*) as visit_count');

        // Tabel transaksi
        $this->db->from($this->TOFTRNC . ' k');

        // Filter berdasarkan tanggal
        $this->db->where('k.tanggal >=', $tanggal_awal);
        $this->db->where('k.tanggal <=', $tanggal_akhir);

        // Grouping berdasarkan id_user dan kode_kantor
        $this->db->group_by(['k.id_user', 'k.kode_kantor']);

        // Menjalankan query dan mengembalikan hasilnya
        return $this->db->get()->result();  // Mengembalikan hasil sebagai array objek
    }

    public function get_data_transaksi_by_range($id_user, $tanggal_awal, $tanggal_akhir)
    {
        $this->db->where('id_user', $id_user);
        $this->db->where('tanggal >=', $tanggal_awal);
        $this->db->where('tanggal <=', $tanggal_akhir);
        $this->db->order_by('tanggal', 'ASC');
        return $this->db->get($this->TOFTRNC)->result();
    }

    public function transaksi_simpan($data)
    {
        $this->db->insert('TOFTRNC', $data);
        return $this->db->insert_id();
    }

    public function get_transaksi_by_id($id)
    {
        return $this->db->get_where('TOFTRNC', array('id' => $id))->row();
    }

    public function transaksi_update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('TOFTRNC', $data);
    }

    public function transaksi_hapus($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('TOFTRNC');
        return $this->db->affected_rows() > 0;
    }
}

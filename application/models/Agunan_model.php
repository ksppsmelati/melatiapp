<?php
class Agunan_model extends CI_Model
{
    private $TOFJAMIN = 'TOFJAMIN';
    private $tbl_agunan = 'tbl_agunan';
    private $tbl_agunan_shm = 'tbl_agunan_shm';

    // public function get_data_agunan()
    // {
    //     return $this->db->get($this->tbl_agunan)->result();
    // }

    public function get_data_agunan($kode_kantor = null)
    {
        $this->db->where_in('jenis_dokumen', array('6', '8', '9'));

        if ($kode_kantor) {
            $this->db->where('kode_kantor', $kode_kantor);
        }
        // $this->db->order_by('tanggal_ubah', 'DESC');
        $this->db->order_by('id', 'DESC');
        return $this->db->get($this->tbl_agunan)->result();
    }

    public function get_data_agunan_shm($kode_kantor = null)
    {
        $this->db->where_in('jenis_dokumen', array('1', '2', '3', '4', '5', '19', '21'));

        // Apply filter by "kode kantor" if provided
        if ($kode_kantor) {
            $this->db->where('kode_kantor', $kode_kantor);
        }

        $this->db->order_by('id', 'DESC');
        return $this->db->get($this->tbl_agunan_shm)->result();
    }

    public function get_data_agunan_proses()
    {
        $this->db->select('*');
        $this->db->from($this->tbl_agunan);
        $this->db->where('status_proses', '1');

        $query1 = $this->db->get_compiled_select(); // Menyimpan hasil query pertama

        $this->db->reset_query(); // Mereset query builder

        $this->db->select('*');
        $this->db->from($this->tbl_agunan_shm);
        $this->db->where('status_proses', '1');

        $query2 = $this->db->get_compiled_select(); // Menyimpan hasil query kedua

        // Menggabungkan dua query dengan UNION dan mengurutkan berdasarkan tanggal_pesan DESC
        $final_query = $query1 . ' UNION ' . $query2 . ' ORDER BY tanggal_pesan DESC';

        // Menjalankan query gabungan dan mengembalikan hasilnya
        return $this->db->query($final_query)->result();
    }

    public function get_data_agunan_bergerak()
    {
        // Query untuk tabel tbl_agunan tanpa menggunakan kolom status_proses dan menghilangkan status_proses = 1
        $this->db->select('*');
        $this->db->from($this->tbl_agunan);
        $this->db->where_in('status', ['DIBAWA', 'CABANG', 'AGUNAN_DIPUSAT','NOTARIS']);

        $query1 = $this->db->get_compiled_select(); // Menyimpan hasil query pertama

        $this->db->reset_query(); // Mereset query builder

        // Query untuk tabel tbl_agunan_shm tanpa menggunakan kolom status_proses dan menghilangkan status_proses = 1
        $this->db->select('*');
        $this->db->from($this->tbl_agunan_shm);
        $this->db->where_in('status', ['DIBAWA', 'CABANG', 'AGUNAN_DIPUSAT','NOTARIS']);

        $query2 = $this->db->get_compiled_select(); // Menyimpan hasil query kedua

        // Menggabungkan dua query dengan UNION
        $final_query = $query1 . ' UNION ' . $query2;

        // Menjalankan query gabungan dan mengembalikan hasilnya
        return $this->db->query($final_query)->result();
    }

    // public function get_data_agunan_proses_cabang($kode_kantor)
    // {
    //     $this->db->select('*');
    //     $this->db->from($this->tbl_agunan);
    //     $this->db->where('status_proses', '1');
    //     $this->db->where('kode_kantor', $kode_kantor);

    //     $query1 = $this->db->get_compiled_select(); 

    //     $this->db->reset_query(); 

    //     $this->db->select('*');
    //     $this->db->from($this->tbl_agunan_shm);
    //     $this->db->where('status_proses', '1');
    //     $this->db->where('kode_kantor', $kode_kantor);

    //     $query2 = $this->db->get_compiled_select(); 

    //     $final_query = $query1 . ' UNION ' . $query2;
    //     return $this->db->query($final_query)->result();
    // }

    public function get_data_agunan_proses_cabang()
    {
        $this->db->select('*');
        $this->db->from($this->tbl_agunan);
        $this->db->where('status_proses', '1');

        $query1 = $this->db->get_compiled_select(); // Menyimpan hasil query pertama

        $this->db->reset_query(); // Mereset query builder

        $this->db->select('*');
        $this->db->from($this->tbl_agunan_shm);
        $this->db->where('status_proses', '1');

        $query2 = $this->db->get_compiled_select(); // Menyimpan hasil query kedua

        // Menggabungkan dua query dengan UNION dan mengurutkan berdasarkan tanggal_pesan DESC
        $final_query = $query1 . ' UNION ' . $query2 . ' ORDER BY tanggal_pesan DESC';

        // Menjalankan query gabungan dan mengembalikan hasilnya
        return $this->db->query($final_query)->result();
    }


    // public function get_all_agunan()
    // {
    //     $columns = array(
    //         'noreg', 'nocif', 'nokontrak', 'urut', 'jnsjamin', 'nomtaksasi', 'nompasar',
    //         'nomlikuid', 'plafond', 'digunakan', 'akandiguna', 'jnsdokumen', 'dokumen', 'an',
    //         'namaci', 'tgltaks1', 'tgltaks2', 'lokasi', 'status', 'catatan', 'kdcab', 'kdloc',
    //         'jnsikat', 'stsrec', 'inpuser', 'inptgljam', 'tglmasuk', 'tglkeluar'
    //     );
    //     $this->db->select($columns);
    //     return $this->db->get($this->TOFJAMIN)->result();
    // }

    public function get_all_agunan()
    {
        $columns = array(
            'TOFJAMIN.noreg', 'mCIF.nocif', 'TOFLMB.nokontrak',
            'TOFJAMIN.jnsjamin', 'TOFJAMIN.digunakan',
            'TOFJAMIN.jnsdokumen', 'TOFJAMIN.dokumen',
            'TOFJAMIN.an', 'TOFJAMIN.lokasi', 'TOFJAMIN.catatan', 'TOFJAMIN.kdloc',
            'TOFJAMIN.tglmasuk', 'TOFJAMIN.tglkeluar',
            'mCIF.nm AS nama', 'mCIF.alamat'
        );

        $this->db->select($columns);
        $this->db->from('TOFJAMIN');
        $this->db->join('TOFLMB', 'TOFJAMIN.nokontrak = TOFLMB.nokontrak');
        $this->db->join('mCIF', 'TOFLMB.nocif = mCIF.nocif');

        return $this->db->get()->result();
    }

    public function agunan_simpan($data)
    {
        $this->db->insert('tbl_agunan', $data);
        return $this->db->insert_id();
    }

    public function agunan_simpan_shm($data)
    {
        $this->db->insert('tbl_agunan_shm', $data);
        return $this->db->insert_id();
    }

    public function get_agunan_by_id($id)
    {
        return $this->db->get_where('tbl_agunan', array('id' => $id))->row();
    }

    public function get_agunan_by_id_shm($id)
    {
        return $this->db->get_where('tbl_agunan_shm', array('id' => $id))->row();
    }

    public function agunan_update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('tbl_agunan', $data);
    }

    public function agunan_update_shm($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('tbl_agunan_shm', $data);
    }

    public function agunan_delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tbl_agunan');
        return $this->db->affected_rows() > 0;
    }

    public function agunan_delete_shm($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tbl_agunan_shm');
        return $this->db->affected_rows() > 0;
    }

    public function check_no_kontrak_exists($no_kontrak)
    {
        $this->db->where('no_kontrak', $no_kontrak);
        $query = $this->db->get('tbl_agunan');
        return $query->num_rows() > 0; // Return true if exists, false otherwise
    }

    public function check_no_kontrak_exists_shm($no_kontrak)
    {
        $this->db->where('no_kontrak', $no_kontrak);
        $query = $this->db->get('tbl_agunan_shm');
        return $query->num_rows() > 0; // Return true if exists, false otherwise
    }
}

<?php
class Sp_model extends CI_Model
{
    private $TOFLMB = 'TOFLMB';
    private $TBL_SP = 'tbl_sp';
    private $tbl_kantor = 'tbl_kantor';

    public function get_all_sp()
    {
        $this->db->where('colbaru >', 1);
        $this->db->where('stsrec', 'A');
        $this->db->order_by('tgltagih', 'ASC');
        return $this->db->get($this->TOFLMB)->result();
    }

    public function get_data_col($tanggal_awal = null, $tanggal_akhir = null, $kode_kantor = null)
    {
        // Filter berdasarkan tanggal jika diberikan
        if ($tanggal_awal && $tanggal_akhir) {
            $this->db->where('tgltagih >=', $tanggal_awal);
            $this->db->where('tgltagih <=', $tanggal_akhir);
        }

        if ($kode_kantor) {
            $this->db->where('kdloc', $kode_kantor);
        }

        // Menambahkan kondisi colbaru > 1 dan stsrec = 'A'
        $this->db->where('collama >', 1);
        $this->db->where($this->TOFLMB . '.stsrec', 'A');

        // Join tabel TOFLMB dengan tabel mCIF berdasarkan nocif
        $this->db->join('mCIF', 'mCIF.nocif = ' . $this->TOFLMB . '.nocif', 'left');

        // Join ke tbl_sp berdasarkan nokontrak
        $this->db->join('tbl_sp', 'tbl_sp.nokontrak = ' . $this->TOFLMB . '.nokontrak', 'left');

        // Join ke TOFJAMIN berdasarkan nokontrak
        $this->db->join('TOFJAMIN', 'TOFJAMIN.nokontrak = ' . $this->TOFLMB . '.nokontrak', 'left');

        // Select kolom yang dibutuhkan
        $this->db->select($this->TOFLMB . '.*, mCIF.alamat, mCIF.hp, tbl_sp.jenis_sp, TOFJAMIN.jnsdokumen');

        // Urutkan berdasarkan tgltagih
        $this->db->order_by('tgltagih', 'DESC');

        // Mengambil hasil query
        return $this->db->get($this->TOFLMB)->result();
    }

    public function get_data_sp($tanggal_awal = null, $tanggal_akhir = null)
    {
        if ($tanggal_awal && $tanggal_akhir) {
            $this->db->where('tgltagih >=', $tanggal_awal);
            $this->db->where('tgltagih <=', $tanggal_akhir);
        }

        return $this->db->get($this->TBL_SP)->result();
    }

    public function get_data_sp_by_nokontrak($nokontrak)
    {
        $this->db->select($this->TOFLMB . '.*, mCIF.alamat, mCIF.hp, TOFJAMIN.jnsdokumen');
        $this->db->from($this->TOFLMB);
        $this->db->join('mCIF', $this->TOFLMB . '.nocif = mCIF.nocif', 'left');
        $this->db->join('TOFJAMIN', $this->TOFLMB . '.nokontrak = TOFJAMIN.nokontrak', 'left');
        $this->db->where($this->TOFLMB . '.nokontrak', $nokontrak);
        return $this->db->get()->row();
    }

    public function get_sp_by_nokontrak($nokontrak)
    {
        return $this->db->get_where('tbl_sp', ['nokontrak' => $nokontrak])->row();
    }

    public function sp_update_by_nokontrak($nokontrak, $data)
    {
        $this->db->where('nokontrak', $nokontrak);
        return $this->db->update('tbl_sp', $data);
    }

    // sp_model.php
    public function get_sp_by_category($tanggal_awal, $tanggal_akhir)
    {
        // Select data yang dibutuhkan, termasuk inpuser dari TOFLMB
        $this->db->select('k.id_user, k.inpuser, k.kode_kantor, COUNT(*) as visit_count');

        // Tabel sp
        $this->db->from($this->TOFLMB . ' k');

        // Filter berdasarkan tanggal
        $this->db->where('k.tanggal >=', $tanggal_awal);
        $this->db->where('k.tanggal <=', $tanggal_akhir);

        // Grouping berdasarkan id_user dan kode_kantor
        $this->db->group_by(['k.id_user', 'k.kode_kantor']);

        // Menjalankan query dan mengembalikan hasilnya
        return $this->db->get()->result();  // Mengembalikan hasil sebagai array objek
    }

    public function get_data_sp_by_range($id_user, $tanggal_awal, $tanggal_akhir)
    {
        $this->db->where('id_user', $id_user);
        $this->db->where('tanggal >=', $tanggal_awal);
        $this->db->where('tanggal <=', $tanggal_akhir);
        $this->db->order_by('tanggal', 'ASC');
        return $this->db->get($this->TOFLMB)->result();
    }

    public function sp_simpan($data)
    {
        $this->db->insert('tbl_sp', $data);
        return $this->db->insert_id();
    }

    public function sp_hapus_by_nokontrak($nokontrak)
    {
        $this->db->where('nokontrak', $nokontrak);
        $this->db->delete('tbl_sp');
    }

    public function get_sp_by_id($id)
    {
        return $this->db->get_where('TOFLMB', array('id' => $id))->row();
    }

    public function sp_update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('TOFLMB', $data);
    }

    public function sp_hapus($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('TOFLMB');
        return $this->db->affected_rows() > 0;
    }

    public function get_all_kantor()
	{
		$this->db->from('tbl_kantor'); // Gantilah 'tbl_kantor' dengan nama tabel yang sesuai jika berbeda
		$query = $this->db->get(); // Mengambil seluruh data dari tabel kantor
		return $query->result_array(); // Mengembalikan hasil dalam bentuk array
	}
}

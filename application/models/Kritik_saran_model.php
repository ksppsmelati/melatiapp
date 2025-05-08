<?php
class Kritik_saran_model extends CI_Model
{
    // Mendapatkan semua kritik dan saran
    public function get_all_kritik_saran()
    {
        // Select all columns from tbl_kritik_saran and nama_lengkap from tbl_user
        $this->db->select('tbl_kritik_saran.*, tbl_user.nama_lengkap');
        $this->db->from('tbl_kritik_saran');
        // Join tbl_user on id_user
        $this->db->join('tbl_user', 'tbl_kritik_saran.id_user = tbl_user.id_user', 'left');
        // Order by id in descending order
        $this->db->order_by('tbl_kritik_saran.id', 'DESC');
        $query = $this->db->get();
        // Return the result as an array of associative arrays
        return $query->result_array();
    }

    public function get_data_kritik_saran_by_date($tanggal_awal = null, $tanggal_akhir = null)
    {
        // Select semua kolom dari tbl_kritik_saran dan nama_lengkap dari tbl_user
        $this->db->select('tbl_kritik_saran.id_user, tbl_user.nama_lengkap, COUNT(tbl_kritik_saran.id) as jumlah');
        $this->db->from('tbl_kritik_saran');

        // Join dengan tbl_user berdasarkan id_user
        $this->db->join('tbl_user', 'tbl_kritik_saran.id_user = tbl_user.id_user', 'left');

        // Cek apakah filter tanggal diberikan
        if ($tanggal_awal && $tanggal_akhir) {
            $this->db->where('tbl_kritik_saran.tanggal >=', $tanggal_awal);
            $this->db->where('tbl_kritik_saran.tanggal <=', $tanggal_akhir);
        }

        // Group by petugas_input (id_user) dan hitung jumlah kritik_saran per petugas
        $this->db->group_by('tbl_kritik_saran.id_user');

        // Urutkan berdasarkan id_user
        $this->db->order_by('tbl_user.nama_lengkap', 'ASC');

        // Eksekusi query dan kembalikan hasil dalam bentuk array
        $query = $this->db->get();
        return $query->result_array();  // Mengembalikan data dalam bentuk array
    }

    public function get_all_kritik_saran_belum_direspond()
    {
        // Select all columns from tbl_kritik_saran and nama_lengkap from tbl_user
        $this->db->select('tbl_kritik_saran.*, tbl_user.nama_lengkap');
        $this->db->from('tbl_kritik_saran');
        // Join tbl_user on id_user
        $this->db->join('tbl_user', 'tbl_kritik_saran.id_user = tbl_user.id_user', 'left');
        // Add condition where status is either NULL or an empty string
        $this->db->where('tbl_kritik_saran.status IS NULL OR tbl_kritik_saran.status = ""');
        // Order by id in descending order
        $this->db->order_by('tbl_kritik_saran.id', 'DESC');
        $query = $this->db->get();
        // Return the result as an array of associative arrays
        return $query->result_array();
    }

    public function get_all_kritik_saran_sudah_direspond()
    {
        // Select all columns from tbl_kritik_saran and nama_lengkap from tbl_user
        $this->db->select('tbl_kritik_saran.*, tbl_user.nama_lengkap');
        $this->db->from('tbl_kritik_saran');
        // Join tbl_user on id_user
        $this->db->join('tbl_user', 'tbl_kritik_saran.id_user = tbl_user.id_user', 'left');
        // Add condition where status is either NULL or an empty string
        $this->db->where('tbl_kritik_saran.status IS NOT NULL AND tbl_kritik_saran.status != ""');
        // Order by id in descending order
        $this->db->order_by('tbl_kritik_saran.id', 'DESC');
        $query = $this->db->get();
        // Return the result as an array of associative arrays
        return $query->result_array();
    }

    public function get_all_kritik_saran_user($id_user)
    {
        // Select all columns from tbl_kritik_saran and nama_lengkap from tbl_user
        $this->db->select('tbl_kritik_saran.*, tbl_user.nama_lengkap');
        $this->db->from('tbl_kritik_saran');
        // Join tbl_user on id_user
        $this->db->join('tbl_user', 'tbl_kritik_saran.id_user = tbl_user.id_user', 'left');
        // Add condition to match the id_user
        $this->db->where('tbl_kritik_saran.id_user', $id_user);
        // Order by id in descending order
        $this->db->order_by('tbl_kritik_saran.id', 'DESC');
        $query = $this->db->get();
        // Return the result as an array of associative arrays
        return $query->result_array();
    }

    // Mendapatkan kritik dan saran berdasarkan ID
    public function get_kritik_saran_by_id($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('tbl_kritik_saran')->row_array();
    }

    // Menambahkan kritik dan saran baru
    public function tambah_kritik_saran($data)
    {
        $this->db->insert('tbl_kritik_saran', $data);
        return $this->db->insert_id(); // Mengembalikan ID dari entri yang baru ditambahkan
    }

    // Mengupdate kritik dan saran
    public function kritik_saran_update($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('tbl_kritik_saran', $data);
        return $this->db->affected_rows(); // Mengembalikan jumlah baris yang terpengaruh
    }

    // Menghapus kritik dan saran
    public function kritik_saran_hapus($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tbl_kritik_saran');
        return $this->db->affected_rows(); // Mengembalikan jumlah baris yang terpengaruh
    }

    // Mendapatkan kritik dan saran berdasarkan status
    public function get_kritik_saran_by_status($status)
    {
        $this->db->where('status', $status);
        return $this->db->get('tbl_kritik_saran')->result_array();
    }

    // Mendapatkan kritik dan saran berdasarkan rentang tanggal
    public function get_kritik_saran_by_date_range($startDate, $endDate)
    {
        $this->db->where('tgl >=', $startDate);
        $this->db->where('tgl <=', $endDate);
        return $this->db->get('tbl_kritik_saran')->result_array();
    }
}

<?php
class File_user_model extends CI_Model
{
    // Retrieve a specific file by its ID
    public function get_file_by_id($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('tbl_file_user');
        return $query->row_array();
    }

    public function get_file_by_id_pby($id_pby)
    {
        $this->db->where('id_pby', $id_pby);
        $query = $this->db->get('tbl_file_user');
        return $query->row_array();
    }

    public function get_file_by_id_mlt($id_mlt)
    {
        $this->db->where('id_mlt', $id_mlt);
        $query = $this->db->get('tbl_file_user');
        return $query->row_array();
    }

    // Retrieve all files uploaded by a specific user, filtered by month and year
    public function get_files_by_date($month, $year)
    {
        $this->db->where('MONTH(tanggal)', $month);
        $this->db->where('YEAR(tanggal)', $year);
        $this->db->order_by('uploaded_at', 'DESC');
        $query = $this->db->get('tbl_file_user');
        return $query->result_array();
    }

    // Insert a new file record
    public function insert_file($data)
    {
        return $this->db->insert('tbl_file_user', $data);
    }

    // Update an existing file record
    public function update_file($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('tbl_file_user', $data);
    }

    // Delete a file record by its ID
    public function delete_file($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('tbl_file_user');
    }

    public function get_all_files()
    {
        $this->db->select('tbl_file_user.*, tbl_user.nama_lengkap');
        $this->db->from('tbl_file_user');

        $this->db->join('tbl_user', 'tbl_file_user.id_user = tbl_user.id_user', 'left');
        $this->db->order_by('tbl_file_user.uploaded_at', 'DESC');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_all_files_slik()
    {
        $this->db->select('tbl_file_user.*, tbl_user.nama_lengkap');
        $this->db->from('tbl_file_user');

        $this->db->join('tbl_user', 'tbl_file_user.id_user = tbl_user.id_user', 'left');
        $this->db->where('tbl_file_user.category', 'SLIK');
        $this->db->order_by('tbl_file_user.uploaded_at', 'DESC');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_files_by_category($category)
    {
        $this->db->where('category', $category);
        return $this->db->get('tbl_file_user')->result_array();
    }

    public function get_all_categories()
    {
        $this->db->distinct();
        $this->db->select('category'); // Ganti 'category' dengan nama kolom kategori yang sesuai
        $query = $this->db->get('tbl_file_user'); // Ganti dengan nama tabel Anda

        if ($query->num_rows() > 0) {
            return $query->result_array(); // Kembalikan hasil sebagai array
        } else {
            return []; // Kembalikan array kosong jika tidak ada data
        }
    }

    public function get_all_categories_by_id_user($id_user)
{
    $this->db->distinct();
    $this->db->select('category'); // Pastikan nama kolom 'category' sesuai dengan tabel Anda
    $this->db->from('tbl_file_user'); // Ganti dengan nama tabel yang sesuai
    $this->db->where('id_user', $id_user); // Tambahkan filter berdasarkan id_user
    $query = $this->db->get();

    if ($query->num_rows() > 0) {
        return $query->result_array(); // Kembalikan hasil sebagai array
    } else {
        return []; // Kembalikan array kosong jika tidak ada data
    }
}

    public function get_all_usulan()
    {
        $this->db->distinct();
        $this->db->select('tbl_file_user.category, tbl_usulan.nama'); // Select category from tbl_file_user and nama from tbl_usulan
        $this->db->from('tbl_file_user'); // Main table
        $this->db->join('tbl_usulan', 'tbl_file_user.id_pby = tbl_usulan.id', 'left'); // Join based on id_pby and id
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array(); // Return the result as an array
        } else {
            return []; // Return an empty array if no data found
        }
    }

    public function get_files_by_user($id_user)
    {
        $this->db->where('id_user', $id_user);
        $this->db->order_by('uploaded_at', 'DESC');
        $query = $this->db->get('tbl_file_user');
        return $query->result_array();
    }

    public function get_all_files_id_pby($id_pby)
    {
        // Get the 'nama' from 'tbl_usulan' using 'id_pby'
        $this->db->select('nama');
        $this->db->from('tbl_usulan');
        $this->db->where('id', $id_pby); // Assuming 'id' is the column in tbl_usulan that corresponds to 'id_pby'
        $query = $this->db->get();
    
        // Check if 'nama' exists for the given 'id_pby'
        $result = $query->row_array();
    
        // Return the 'nama' or an empty string if not found
        return isset($result['nama']) ? $result['nama'] : '';
    }
    
    public function get_files_surat_kuasa_by_user($id_user)
    {
        $this->db->where('id_user', $id_user);
        $this->db->where('category', 'surat_kuasa');
        $this->db->order_by('uploaded_at', 'DESC');
        $query = $this->db->get('tbl_file_user');
        return $query->result_array();
    }
}

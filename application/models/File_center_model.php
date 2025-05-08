<?php
class File_center_model extends CI_Model
{
    // Retrieve a specific file by its ID
    public function get_file_by_id($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('tbl_file');
        return $query->row_array();
    }

    // Retrieve all files uploaded by a specific user, filtered by month and year
    public function get_files_by_date($month, $year)
    {
        $this->db->where('MONTH(tanggal)', $month);
        $this->db->where('YEAR(tanggal)', $year);
        $this->db->order_by('uploaded_at', 'DESC');
        $query = $this->db->get('tbl_file');
        return $query->result_array();
    }

    // Insert a new file record
    public function insert_file($data)
    {
        return $this->db->insert('tbl_file', $data);
    }

    // Update an existing file record
    public function update_file($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('tbl_file', $data);
    }

    // Delete a file record by its ID
    public function delete_file($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('tbl_file');
    }

    // Get all files (useful for admin view or management)
    public function get_all_files()
    {
        $this->db->order_by('uploaded_at', 'DESC');
        $query = $this->db->get('tbl_file');
        return $query->result_array();
    }
    public function get_files_by_category($category)
{
    $this->db->where('category', $category);
    return $this->db->get('tbl_file')->result_array();
}

public function get_all_categories()
{
    $this->db->distinct();
    $this->db->select('category'); // Ganti 'category' dengan nama kolom kategori yang sesuai
    $query = $this->db->get('tbl_file'); // Ganti dengan nama tabel Anda

    if ($query->num_rows() > 0) {
        return $query->result_array(); // Kembalikan hasil sebagai array
    } else {
        return []; // Kembalikan array kosong jika tidak ada data
    }
}


}

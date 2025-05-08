<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tracking_model extends CI_Model
{
    protected $table = 'tbl_user'; // Sesuaikan dengan nama tabel Anda

    public function getAllUserLocations()
    {   
        $this->db->where('status', 'aktif');
        $query = $this->db->get($this->table); // Menggunakan variabel $this->table

        return $query->result(); // Mengembalikan hasil dalam bentuk array
    }
    
    public function getMarketingUsers()
    {
        // Define the user level you want to retrieve (e.g., "marketing")
        $userLevel = 'marketing';

        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('level', $userLevel);
        $this->db->where('status', 'aktif');

        $query = $this->db->get();

        return $query->result();
    }
}

// class Tracking_model extends CI_Model
// {
//     protected $table = 'tbl_user';

//     public function getAllUserLocations()
//     {
//         return $this->db->select('id_user, latitude, longitude')->get($this->table)->result_array();
//     }
// }

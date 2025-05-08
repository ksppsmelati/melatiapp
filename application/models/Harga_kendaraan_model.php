<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Harga_kendaraan_model extends CI_Model {

    public function save_harga_kendaraan($data) {
        $this->db->insert('tbl_harga_kendaraan', $data);
    }

    public function update_harga_kendaraan($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('tbl_harga_kendaraan', $data);
    }

    public function get_harga_kendaraan_by_id($id) {
        return $this->db->get_where('tbl_harga_kendaraan', array('id' => $id))->row();
    }

    public function delete_harga_kendaraan_by_id($id) {
        $this->db->where('id', $id);
        $this->db->delete('tbl_harga_kendaraan');
    }

    public function getSimilarVehicles($merek, $model, $currentVehicleId)
{
    // Fetch similar vehicles based on "merek" and "model"
    $this->db->where('merek', $merek);
    $this->db->where('model', $model);
    $this->db->where('id !=', $currentVehicleId); // Exclude the current vehicle
    // $this->db->limit(5); // Adjust the limit as needed
    $this->db->order_by('tahun', 'DESC'); // Sort by "tahun" in descending order
    return $this->db->get('tbl_harga_kendaraan')->result();
}



}
?>

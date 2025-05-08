<?php
class Setting_model extends CI_Model
{   
    private $tbl_setting = 'tbl_setting';

    public function get_setting($key)
    {
        $this->db->where('key', $key);
        return $this->db->get($this->tbl_setting)->row();
    }

    public function update_setting($key, $data)
    {
        // Check if the setting already exists
        $this->db->where('key', $key);
        $existing = $this->db->get($this->tbl_setting)->row();
    
        if ($existing) {
            // Jika sudah ada, lakukan update pada value dan keterangan
            $this->db->where('key', $key);
            $this->db->update($this->tbl_setting, $data); // Update dengan array $data yang berisi 'value' dan 'keterangan'
            return $this->db->affected_rows();
        } else {
            // Jika belum ada, tambahkan record baru
            $data['key'] = $key; // Tambahkan key ke dalam array data
            $this->db->insert($this->tbl_setting, $data);
            return $this->db->insert_id();
        }
    }    

    public function delete_setting($key)
    {
        $this->db->where('key', $key);
        $this->db->delete($this->tbl_setting);
    }

    public function get_all_settings()
    {
        return $this->db->get($this->tbl_setting)->result();
    }

    public function insert_setting($key, $value, $catatan)
    {
        $this->db->where('key', $key);
        $existing = $this->db->get($this->tbl_setting)->row();

        if ($existing) {
            return false; 
        } else {
            $data = [
                'key' => $key,
                'value' => $value,
                'catatan' => $catatan
            ];
            $this->db->insert($this->tbl_setting, $data);
            return $this->db->insert_id();
        }
    }
}

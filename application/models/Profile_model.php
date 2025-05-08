<?php
class Profile_model extends CI_Model
{
    public function get_user_by_id($id_user)
    {
        $this->db->where('id_user', $id_user);
        return $this->db->get('tbl_user')->row();
    }
    
    public function update_foto_profile($id_user, $data) {
        $this->db->where('id_user', $id_user);
        return $this->db->update('tbl_user', $data);
    }

}

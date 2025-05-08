<?php
class Catatan_model extends CI_Model
{   
    private $tbl_catatan = 'tbl_catatan';

    public function get_catatan_by_id_user($id_user)
    {
    $this->db->where('id_user', $id_user);
    return $this->db->get($this->tbl_catatan)->result();
    }

    public function save_catatan($data)
	{
		$this->db->insert($this->tbl_catatan, $data);
		return $this->db->insert_id();
	}

	public function update_catatan($where, $data)
	{
		$this->db->update($this->tbl_catatan, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_catatan_by_id($id)
	{
		$this->db->where('id_catatan', $id);
		$this->db->delete($this->tbl_catatan);
	}
	
	public function get_catatan_by_id($id)
    {
        $this->db->where('id_catatan', $id);
        return $this->db->get($this->tbl_catatan)->row();
    }
}

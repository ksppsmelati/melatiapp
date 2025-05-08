<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Info_model extends CI_Model {
    public function getInfo() {
        $query = $this->db->get('tbl_info');
        return $query->row();
    }
    public function getInfo1() {
        $query = $this->db->get('tbl_info');
        return $query->row('info_1');
    }

    public function getInfo2() {
        $query = $this->db->get('tbl_info');
        return $query->row('info_2');
    }

    public function getInfo3() {
        $query = $this->db->get('tbl_info');
        return $query->row('info_3');
    }

    public function getInfo4() {
        $query = $this->db->get('tbl_info');
        return $query->row('info_4');
    }
    public function getInfo5() {
        $query = $this->db->get('tbl_info');
        return $query->row('info_5');
    }
    public function getInfo6() {
        $query = $this->db->get('tbl_info');
        return $query->row('info_6');
    }
    public function getInfo7() {
        $query = $this->db->get('tbl_info');
        return $query->row('info_7');
    }
    public function getInfo8() {
        $query = $this->db->get('tbl_info');
        return $query->row('info_8');
    }
    public function getInfo9() {
        $query = $this->db->get('tbl_info');
        return $query->row('info_9');
    }
    public function getInfo10() {
        $query = $this->db->get('tbl_info');
        return $query->row('info_10');
    }
    public function getInfo11() {
        $query = $this->db->get('tbl_info');
        return $query->row('info_11');
    }
    public function getInfo12() {
        $query = $this->db->get('tbl_info');
        return $query->row('info_12');
    }
    public function getInfo13() {
        $query = $this->db->get('tbl_info');
        return $query->row('info_13');
    }
    public function getInfo14() {
        $query = $this->db->get('tbl_info');
        return $query->row('info_14');
    }
    public function getInfo15() {
        $query = $this->db->get('tbl_info');
        return $query->row('info_15');
    }
    public function getInfo16() {
        $query = $this->db->get('tbl_info');
        return $query->row('info_16');
    }
    public function getInfo17() {
        $query = $this->db->get('tbl_info');
        return $query->row('info_17');
    }
    public function getInfo18() {
        $query = $this->db->get('tbl_info');
        return $query->row('info_18');
    }
    public function getInfo19() {
        $query = $this->db->get('tbl_info');
        return $query->row('info_19');
    }
    public function getInfo20() {
        $query = $this->db->get('tbl_info');
        return $query->row('info_20');
    }

}

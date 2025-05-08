<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// application/controllers/CariTabController.php

class CariTabController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('CariTab'); // Memuat model yang sudah dibuat
    }

    public function getAnggotaData() {
        $searchTerm = $this->input->get('q'); // Mendapatkan teks pencarian dari parameter 'q'
        $data = $this->CariTab->getAnggota($searchTerm);

        echo json_encode($data); // Mengirim data dalam format JSON
    }

    public function getInfoRekening() {
        $searchTerm = $this->input->get('q'); // Mendapatkan teks pencarian dari parameter 'q'
        $data = $this->CariTab->getInfoRekening($searchTerm);

        echo json_encode($data); // Mengirim data dalam format JSON
    }

    // cari semua data agunan
    public function getAgunanData() {
        $searchTerm = $this->input->get('q'); 
        $data = $this->CariTab->getAgunan($searchTerm);

        echo json_encode($data); 
    }
    // cari data agunan BPKB
    public function getAgunanDataBpkb() {
        $searchTerm = $this->input->get('q'); 
        $data = $this->CariTab->getAgunanBpkb($searchTerm);

        echo json_encode($data); 
    }
    // cari data agunan SHM
    public function getAgunanDataShm() {
        $searchTerm = $this->input->get('q'); 
        $data = $this->CariTab->getAgunanShm($searchTerm);

        echo json_encode($data); 
    }
}

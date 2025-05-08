<?php

class Cek_bi_model extends CI_Model
{
    public function insert_data($form_data)
    {
        return $this->db->insert('tbl_cek_bi', $form_data);
    }

    public function get_all_data()
    {
        // Mengambil semua data dari tabel tbl_cek_bi
        $this->db->select('u.*, 
                       s.status_analisa, 
                       s.status_komite,
                       u.tgl_cek_bi,
                       f.category,
                       t_kelurahan.nama AS kelurahan_nama, 
                       t_kecamatan.nama AS kecamatan_nama, 
                       t_kota.nama AS kota_nama, 
                       t_provinsi.nama AS provinsi_nama'); // Ambil semua kolom dari tbl_cek_bi dan status_analisa dari tbl_survey

        $this->db->from('tbl_cek_bi u');
        $this->db->join('tbl_survey s', 'u.id = s.id_pby', 'left'); // Menggunakan left join untuk mengaitkan tbl_cek_bi dan tbl_survey

        // Tambahkan join untuk mengambil nama kelurahan, kecamatan, kota, dan provinsi
        $this->db->join('t_kelurahan', 'u.kelurahan = t_kelurahan.id', 'left');
        $this->db->join('t_kecamatan', 'u.kecamatan = t_kecamatan.id', 'left');
        $this->db->join('t_kota', 'u.kota_kabupaten = t_kota.id', 'left');
        $this->db->join('t_provinsi', 'u.provinsi = t_provinsi.id', 'left');

        $this->db->join('tbl_file_user f', 'u.id = f.id_mlt', 'left');

        $this->db->order_by('u.id', 'DESC'); // Mengurutkan berdasarkan id tbl_cek_bi

        $query = $this->db->get();
        return $query->result(); // Mengembalikan hasil query dalam bentuk array objek
    }

    public function get_all_data_by_id_user($id_user)
    {
        // Mengambil data dari tabel tbl_cek_bi berdasarkan id_user
        $this->db->select('u.*, 
                       s.status_analisa, 
                       s.status_komite,
                       u.tgl_cek_bi,
                       f.category,
                       t_kelurahan.nama AS kelurahan_nama, 
                       t_kecamatan.nama AS kecamatan_nama, 
                       t_kota.nama AS kota_nama, 
                       t_provinsi.nama AS provinsi_nama'); // Ambil semua kolom dari tbl_cek_bi dan status_analisa dari tbl_survey

        $this->db->from('tbl_cek_bi u');
        $this->db->join('tbl_survey s', 'u.id = s.id_pby', 'left'); // Menggunakan left join untuk mengaitkan tbl_cek_bi dan tbl_survey

        // Tambahkan join untuk mengambil nama kelurahan, kecamatan, kota, dan provinsi
        $this->db->join('t_kelurahan', 'u.kelurahan = t_kelurahan.id', 'left');
        $this->db->join('t_kecamatan', 'u.kecamatan = t_kecamatan.id', 'left');
        $this->db->join('t_kota', 'u.kota_kabupaten = t_kota.id', 'left');
        $this->db->join('t_provinsi', 'u.provinsi = t_provinsi.id', 'left');

        $this->db->join('tbl_file_user f', 'u.id = f.id_mlt', 'left');

        // Filter data berdasarkan id_user
        $this->db->where('u.id_user', $id_user);

        $this->db->order_by('u.id', 'DESC'); // Mengurutkan berdasarkan id tbl_cek_bi

        $query = $this->db->get();
        return $query->result(); // Mengembalikan hasil query dalam bentuk array objek
    }

    public function get_usulan_bulan_berjalan_per_kantor()
    {
        $this->db->select("kode_kantor, COUNT(id) as jumlah_usulan, SUM(nominal) as total_nominal, 
                           DATE_FORMAT(tanggal, '%M %Y') as bulan_tahun"); // Menambahkan bulan dan tahun
        $this->db->from('tbl_cek_bi');
        $this->db->where("MONTH(tanggal) = MONTH(CURDATE())");
        $this->db->where("YEAR(tanggal) = YEAR(CURDATE())");
        $this->db->group_by("kode_kantor, bulan_tahun");
        $this->db->order_by("bulan_tahun ASC, kode_kantor ASC");
        $query = $this->db->get();
        return $query->result();
    }

    public function get_all_data_belum_survey()
    {
        $this->db->select('tbl_cek_bi.*, tbl_file_user.category');
        $this->db->from('tbl_cek_bi');
        $this->db->join('tbl_file_user', 'tbl_file_user.id_pby = tbl_cek_bi.id', 'left');
        $this->db->where('status_survey', 0);
        $this->db->order_by('id', 'DESC');

        $query = $this->db->get();
        return $query->result(); // Mengembalikan hasil query dalam bentuk array objek
    }

    public function get_usulan_data_cabang()
    {
        $this->db->select('tbl_cek_bi.*, tbl_file_user.category');
        $this->db->from('tbl_cek_bi');
        $this->db->join('tbl_file_user', 'tbl_file_user.id_pby = tbl_cek_bi.id', 'left');
        // Get usulan data where nominal is less than or equal to 20 million
        $this->db->where('status_survey', 0);
        $this->db->where('nominal <=', 20000000);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_usulan_data_pusat()
    {
        $this->db->select('tbl_cek_bi.*, tbl_file_user.category');
        $this->db->from('tbl_cek_bi');
        $this->db->join('tbl_file_user', 'tbl_file_user.id_pby = tbl_cek_bi.id', 'left');
        $this->db->where('status_survey', 0);
        $this->db->where('nominal >', 20000000);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_all_data_sudah_survey()
    {
        $this->db->select('tbl_cek_bi.*, tbl_file_user.category, tbl_survey.tgl_cek_bi'); // Menambahkan kolom category dari tbl_file_user
        $this->db->from('tbl_cek_bi');
        $this->db->join('tbl_file_user', 'tbl_file_user.id_pby = tbl_cek_bi.id', 'left'); // JOIN dengan tbl_file_user
        $this->db->join('tbl_survey', 'tbl_survey.id_pby = tbl_cek_bi.id', 'left'); // JOIN dengan tbl_survey
        $this->db->where('tbl_cek_bi.status_survey', 1); // Filter berdasarkan status_survey = 1
        $this->db->order_by('tbl_cek_bi.id', 'DESC'); // Urutkan berdasarkan id di tbl_cek_bi

        $query = $this->db->get();
        return $query->result(); // Mengembalikan hasil query dalam bentuk array objek
    }

    public function get_all_data_sudah_survey_pusat()
    {
        $this->db->select('tbl_cek_bi.*, tbl_file_user.category, tbl_survey.tgl_cek_bi'); // Menambahkan kolom category dari tbl_file_user
        $this->db->from('tbl_cek_bi');
        $this->db->join('tbl_file_user', 'tbl_file_user.id_pby = tbl_cek_bi.id', 'left'); // JOIN dengan tbl_file_user
        $this->db->join('tbl_survey', 'tbl_survey.id_pby = tbl_cek_bi.id', 'left'); // JOIN dengan tbl_survey
        $this->db->where('tbl_cek_bi.status_survey', 1); // Filter berdasarkan status_survey = 1
        $this->db->order_by('tbl_cek_bi.id', 'DESC'); // Urutkan berdasarkan id di tbl_cek_bi
        $this->db->where('nominal >', 20000000);
        $query = $this->db->get();
        return $query->result(); // Mengembalikan hasil query dalam bentuk array objek
    }

    public function get_all_data_sudah_survey_cabang()
    {
        $this->db->select('tbl_cek_bi.*, tbl_file_user.category, tbl_survey.tgl_cek_bi'); // Menambahkan kolom category dari tbl_file_user
        $this->db->from('tbl_cek_bi');
        $this->db->join('tbl_file_user', 'tbl_file_user.id_pby = tbl_cek_bi.id', 'left'); // JOIN dengan tbl_file_user
        $this->db->join('tbl_survey', 'tbl_survey.id_pby = tbl_cek_bi.id', 'left'); // JOIN dengan tbl_survey
        $this->db->where('tbl_cek_bi.status_survey', 1); // Filter berdasarkan status_survey = 1
        $this->db->order_by('tbl_cek_bi.id', 'DESC'); // Urutkan berdasarkan id di tbl_cek_bi
        $this->db->where('nominal <=', 20000000);
        $query = $this->db->get();
        return $query->result(); // Mengembalikan hasil query dalam bentuk array objek
    }

    public function get_data_by_id($id)
    {

        $this->db->select('u.*, f.category'); 
        $this->db->from('tbl_cek_bi u');
        $this->db->join('tbl_file_user f', 'u.id = f.id_mlt', 'left'); 
        $this->db->where('u.id', $id);
    
        // Get data by ID
        $query = $this->db->get();
        return $query->row();
    }
    

    public function delete_data($id)
    {
        // Delete data by ID
        $this->db->where('id', $id);
        $this->db->delete('tbl_cek_bi');

        // Check if the deletion was successful
        return $this->db->affected_rows() > 0;
    }

    public function getUsulanDetail($id)
    {
        $this->db->select('tbl_cek_bi.*, 
                       tbl_survey.status_analisa,  
                       tbl_survey.status_komite,
                       tbl_survey.tgl_cek_bi,
                       t_kelurahan.nama AS kelurahan_nama,
                       t_kecamatan.nama AS kecamatan_nama,
                       t_kota.nama AS kota_nama,
                       t_provinsi.nama AS provinsi_nama'); // Select additional names

        $this->db->from('tbl_cek_bi');
        $this->db->join('tbl_survey', 'tbl_survey.id_pby = tbl_cek_bi.id', 'left'); // Join with tbl_survey

        // Join with t_kelurahan, t_kecamatan, t_kota, and t_provinsi
        $this->db->join('t_kelurahan', 'tbl_cek_bi.kelurahan = t_kelurahan.id', 'left');
        $this->db->join('t_kecamatan', 'tbl_cek_bi.kecamatan = t_kecamatan.id', 'left');
        $this->db->join('t_kota', 'tbl_cek_bi.kota_kabupaten = t_kota.id', 'left');
        $this->db->join('t_provinsi', 'tbl_cek_bi.provinsi = t_provinsi.id', 'left');

        $this->db->where('tbl_cek_bi.id', $id);
        $query = $this->db->get();
        return $query->row();  // Return a single row result
    }

    public function get_cek_bi_data_by_id($row_id)
    {
        // Select kolom dari tbl_cek_bi dan tabel terkait
        $this->db->select('tbl_cek_bi.id AS usulan_id,
                           tbl_cek_bi.*, 
                           t_kelurahan.nama AS kelurahan_nama,
                           t_kecamatan.nama AS kecamatan_nama,
                           t_kota.nama AS kota_nama,
                           t_provinsi.nama AS provinsi_nama'); // Pilih kolom yang diinginkan
    
        $this->db->from('tbl_cek_bi');
    
        // Join dengan tabel-tabel terkait untuk mendapatkan nama wilayah
        $this->db->join('t_kelurahan', 'tbl_cek_bi.kelurahan = t_kelurahan.id', 'left');
        $this->db->join('t_kecamatan', 'tbl_cek_bi.kecamatan = t_kecamatan.id', 'left');
        $this->db->join('t_kota', 'tbl_cek_bi.kota_kabupaten = t_kota.id', 'left');
        $this->db->join('t_provinsi', 'tbl_cek_bi.provinsi = t_provinsi.id', 'left');
    
        // Tambahkan kondisi untuk mengambil data berdasarkan row_id
        $this->db->where('tbl_cek_bi.id', $row_id);
    
        // Eksekusi query dan kembalikan hasil sebagai objek
        $query = $this->db->get();
        return $query->row(); // Mengembalikan hasil query dalam bentuk objek
    }
    

    public function cek_bi_update($row_id, $data)
    {
        $this->db->where('id', $row_id);
        $this->db->update('tbl_cek_bi', $data);
    }

    public function insert_survey_data($data)
    {
        return $this->db->insert('tbl_survey', $data);
    }

    public function set_status_survey($row_id, $status)
    {
        // Update status_survey menjadi 1
        $this->db->where('id', $row_id);
        $this->db->update('tbl_cek_bi', array('status_survey' => $status));
    }
    public function getSurveyData()
    {
        $this->db->select('tbl_survey.*, 
                       tbl_cek_bi.id AS usulan_id,
                       tbl_cek_bi.nama, 
                       tbl_cek_bi.nik, 
                       tbl_cek_bi.tgl_lahir, 
                       tbl_cek_bi.tempat_lahir, 
                       tbl_cek_bi.jk, 
                       tbl_cek_bi.alamat, 
                       tbl_cek_bi.jns_alamat,
                       tbl_cek_bi.provinsi,
                       tbl_cek_bi.kota_kabupaten,
                       tbl_cek_bi.kecamatan,
                       tbl_cek_bi.kelurahan,
                       tbl_cek_bi.kode_pos,
                       tbl_cek_bi.negara,
                       tbl_cek_bi.status_kawin,
                       tbl_cek_bi.status_pendidikan,
                       tbl_cek_bi.nama_ibu, 
                       tbl_cek_bi.pekerjaan, 
                       tbl_cek_bi.tujuan, 
                       tbl_cek_bi.nominal, 
                       tbl_cek_bi.telepon, 
                       tbl_cek_bi.jangka_waktu, 
                       tbl_cek_bi.jaminan, 
                       tbl_cek_bi.id_user,
                       tbl_cek_bi.bpkb, 
                       tbl_cek_bi.jns_kendaraan, 
                       tbl_cek_bi.thn_pembuatan, 
                       tbl_cek_bi.merk, 
                       tbl_cek_bi.no_mesin, 
                       tbl_cek_bi.no_rangka, 
                       tbl_cek_bi.no_pol, 
                       tbl_cek_bi.sertifikat, 
                       tbl_cek_bi.an_sertifikat, 
                       tbl_cek_bi.luas, 
                       tbl_cek_bi.alamat_lokasi, 
                       tbl_cek_bi.foto_ktp, 
                       tbl_cek_bi.kode_kantor,
                       tbl_cek_bi.ttd,
                       tbl_cek_bi.tanggal,
                       t_kelurahan.nama AS kelurahan_nama,
                       t_kecamatan.nama AS kecamatan_nama,
                       t_kota.nama AS kota_nama,
                       t_provinsi.nama AS provinsi_nama,
                       tbl_file_user.file_name, 
                       tbl_file_user.file_path, 
                       tbl_file_user.category, 
                       tbl_file_user.uploaded_at'); // Select additional names

        $this->db->from('tbl_survey');
        $this->db->join('tbl_cek_bi', 'tbl_survey.id_pby = tbl_cek_bi.id', 'inner'); // Join with tbl_cek_bi

        // Join with t_kelurahan, t_kecamatan, t_kota, and t_provinsi
        $this->db->join('t_kelurahan', 'tbl_cek_bi.kelurahan = t_kelurahan.id', 'left');
        $this->db->join('t_kecamatan', 'tbl_cek_bi.kecamatan = t_kecamatan.id', 'left');
        $this->db->join('t_kota', 'tbl_cek_bi.kota_kabupaten = t_kota.id', 'left');
        $this->db->join('t_provinsi', 'tbl_cek_bi.provinsi = t_provinsi.id', 'left');

        $this->db->join('tbl_file_user', 'tbl_survey.id_pby = tbl_file_user.id_pby', 'left');

        $this->db->where('(tbl_survey.hasil_analisa IS NULL OR tbl_survey.hasil_analisa = 0)');

        $this->db->order_by('tbl_survey.tgl_survey', 'DESC');  // Sort by latest id
        $query = $this->db->get();
        return $query->result();  // Return the query result as an array of objects
    }

    public function getHasilAnalisa()
    {
        $this->db->select('tbl_survey.*, 
                       tbl_cek_bi.id AS usulan_id,
                       tbl_cek_bi.nama, 
                       tbl_cek_bi.nik, 
                       tbl_cek_bi.tgl_lahir, 
                       tbl_cek_bi.tempat_lahir, 
                       tbl_cek_bi.jk, 
                       tbl_cek_bi.alamat, 
                       tbl_cek_bi.jns_alamat,
                       tbl_cek_bi.provinsi,
                       tbl_cek_bi.kota_kabupaten,
                       tbl_cek_bi.kecamatan,
                       tbl_cek_bi.kelurahan,
                       tbl_cek_bi.kode_pos,
                       tbl_cek_bi.negara,
                       tbl_cek_bi.status_kawin,
                       tbl_cek_bi.status_pendidikan,
                       tbl_cek_bi.nama_ibu, 
                       tbl_cek_bi.pekerjaan, 
                       tbl_cek_bi.tujuan, 
                       tbl_cek_bi.nominal, 
                       tbl_cek_bi.telepon, 
                       tbl_cek_bi.jangka_waktu, 
                       tbl_cek_bi.jaminan, 
                       tbl_cek_bi.id_user,
                       tbl_cek_bi.bpkb, 
                       tbl_cek_bi.jns_kendaraan, 
                       tbl_cek_bi.thn_pembuatan, 
                       tbl_cek_bi.merk, 
                       tbl_cek_bi.no_mesin, 
                       tbl_cek_bi.no_rangka, 
                       tbl_cek_bi.no_pol, 
                       tbl_cek_bi.sertifikat, 
                       tbl_cek_bi.an_sertifikat, 
                       tbl_cek_bi.luas, 
                       tbl_cek_bi.alamat_lokasi, 
                       tbl_cek_bi.foto_ktp, 
                       tbl_cek_bi.kode_kantor,
                       tbl_cek_bi.ttd,
                       tbl_cek_bi.tanggal,
                       tbl_file_user.category, 
                       t_kelurahan.nama AS kelurahan_nama,
                       t_kecamatan.nama AS kecamatan_nama,
                       t_kota.nama AS kota_nama,
                       t_provinsi.nama AS provinsi_nama'); // Select additional names

        $this->db->from('tbl_survey');
        $this->db->join('tbl_cek_bi', 'tbl_survey.id_pby = tbl_cek_bi.id', 'inner'); // Join with tbl_cek_bi

        $this->db->join('tbl_file_user', 'tbl_survey.id_pby = tbl_file_user.id_pby', 'left');

        // Join with t_kelurahan, t_kecamatan, t_kota, and t_provinsi
        $this->db->join('t_kelurahan', 'tbl_cek_bi.kelurahan = t_kelurahan.id', 'left');
        $this->db->join('t_kecamatan', 'tbl_cek_bi.kecamatan = t_kecamatan.id', 'left');
        $this->db->join('t_kota', 'tbl_cek_bi.kota_kabupaten = t_kota.id', 'left');
        $this->db->join('t_provinsi', 'tbl_cek_bi.provinsi = t_provinsi.id', 'left');

        $this->db->where('(tbl_survey.hasil_analisa IS NOT NULL AND tbl_survey.hasil_analisa != 0)');

        // $this->db->where('tbl_survey.status_status', 0);  
        $this->db->order_by('tbl_survey.id', 'DESC');  // Sort by latest id
        $query = $this->db->get();
        return $query->result();  // Return the query result as an array of objects
    }


    // Usulan_model.php
    public function getUsernameById($id_user)
    {
        $this->db->select('nama_lengkap');
        $this->db->where('id_user', $id_user);
        $query = $this->db->get('tbl_user');

        if ($query->num_rows() > 0) {
            return $query->row()->nama_lengkap;
        } else {
            return '-';
        }
    }

    public function getSurveyDetail($id_pby)
    {
        // Select fields from the relevant tables
        $this->db->select('tbl_survey.*, 
                       tbl_cek_bi.id AS usulan_id,
                       tbl_cek_bi.nama, 
                       tbl_cek_bi.nik, 
                       tbl_cek_bi.tgl_lahir, 
                       tbl_cek_bi.tempat_lahir, 
                       tbl_cek_bi.jk, 
                       tbl_cek_bi.alamat,
                       tbl_cek_bi.jns_alamat,
                       tbl_cek_bi.provinsi,
                       tbl_cek_bi.kota_kabupaten,
                       tbl_cek_bi.kecamatan,
                       tbl_cek_bi.kelurahan,
                       tbl_cek_bi.kode_pos,
                       tbl_cek_bi.negara,
                       tbl_cek_bi.status_kawin,
                       tbl_cek_bi.status_pendidikan,
                       tbl_cek_bi.nama_ibu, 
                       tbl_cek_bi.pekerjaan, 
                       tbl_cek_bi.tujuan, 
                       tbl_cek_bi.telepon,
                       tbl_cek_bi.nominal, 
                       tbl_cek_bi.jangka_waktu, 
                       tbl_cek_bi.jaminan,
                       tbl_cek_bi.id_user,
                       tbl_cek_bi.bpkb, 
                       tbl_cek_bi.jns_kendaraan, 
                       tbl_cek_bi.thn_pembuatan, 
                       tbl_cek_bi.merk, 
                       tbl_cek_bi.no_mesin, 
                       tbl_cek_bi.no_rangka, 
                       tbl_cek_bi.no_pol, 
                       tbl_cek_bi.sertifikat, 
                       tbl_cek_bi.an_sertifikat, 
                       tbl_cek_bi.luas, 
                       tbl_cek_bi.alamat_lokasi, 
                       tbl_cek_bi.foto_ktp, 
                       tbl_cek_bi.kode_kantor,
                       tbl_file_user.category, 
                       t_provinsi.nama AS provinsi_nama,
                       t_kota.nama AS kota_nama,
                       t_kecamatan.nama AS kecamatan_nama,
                       t_kelurahan.nama AS kelurahan_nama');

        // From tbl_survey
        $this->db->from('tbl_survey');

        // Join with tbl_cek_bi
        $this->db->join('tbl_cek_bi', 'tbl_survey.id_pby = tbl_cek_bi.id');

        // Join with the province table
        $this->db->join('t_provinsi', 'tbl_cek_bi.provinsi = t_provinsi.id', 'left');

        // Join with the city table
        $this->db->join('t_kota', 'tbl_cek_bi.kota_kabupaten = t_kota.id', 'left');

        // Join with the district table
        $this->db->join('t_kecamatan', 'tbl_cek_bi.kecamatan = t_kecamatan.id', 'left');

        // Join with the village table
        $this->db->join('t_kelurahan', 'tbl_cek_bi.kelurahan = t_kelurahan.id', 'left');

        $this->db->join('tbl_file_user', 'tbl_survey.id_pby = tbl_file_user.id_pby', 'left');

        // Where clause to filter by the provided ID
        $this->db->where('tbl_survey.id_pby', $id_pby);

        // Execute the query
        $query = $this->db->get();

        // Return the result as a single row
        return $query->row();
    }

    public function update_survey_data($row_id, $data)
    {
        $this->db->where('id_pby', $row_id);
        $this->db->update('tbl_survey', $data);
    }

    public function delete_survey_data($id_pby)
    {
        // First, get the survey data by ID
        $survey_data = $this->getSurveyDetail($id_pby);

        if (!$survey_data) {
            // Handle the case where the survey data with the given ID doesn't exist
            return false;
        }

        // Delete the survey data
        $this->db->where('id_pby', $id_pby);
        $this->db->delete('tbl_survey');

        // Additional logic if needed, e.g., deleting associated files or records

        return true; // Deletion successful
    }
    public function getCatatanById($id_user)
    {
        $this->db->select('catatan');
        $this->db->where('id_user', $id_user);
        $query = $this->db->get('tbl_survey');

        // Memeriksa apakah ada hasil dari kueri
        if ($query->num_rows() > 0) {
            // Mengembalikan nilai 'catatan' jika hasilnya ada
            return $query->row()->catatan;
        } else {
            // Mengembalikan nilai default (misalnya: null) jika tidak ada hasil
            return null; // Atau sesuaikan dengan nilai default yang sesuai
        }
    }

    public function getKomiteData()
    {
        $this->db->select('tbl_survey.*, 
                       tbl_cek_bi.id AS usulan_id,
                       tbl_cek_bi.nama, 
                       tbl_cek_bi.nik, 
                       tbl_cek_bi.tgl_lahir, 
                       tbl_cek_bi.tempat_lahir, 
                       tbl_cek_bi.jk, 
                       tbl_cek_bi.alamat, 
                       tbl_cek_bi.jns_alamat,
                       tbl_cek_bi.provinsi,
                       tbl_cek_bi.kota_kabupaten,
                       tbl_cek_bi.kecamatan,
                       tbl_cek_bi.kelurahan,
                       tbl_cek_bi.kode_pos,
                       tbl_cek_bi.negara,
                       tbl_cek_bi.status_kawin,
                       tbl_cek_bi.status_pendidikan,
                       tbl_cek_bi.nama_ibu, 
                       tbl_cek_bi.pekerjaan, 
                       tbl_cek_bi.tujuan, 
                       tbl_cek_bi.nominal, 
                       tbl_cek_bi.telepon, 
                       tbl_cek_bi.jangka_waktu, 
                       tbl_cek_bi.jaminan, 
                       tbl_cek_bi.id_user,
                       tbl_cek_bi.bpkb, 
                       tbl_cek_bi.jns_kendaraan, 
                       tbl_cek_bi.thn_pembuatan, 
                       tbl_cek_bi.merk, 
                       tbl_cek_bi.no_mesin, 
                       tbl_cek_bi.no_rangka, 
                       tbl_cek_bi.no_pol, 
                       tbl_cek_bi.sertifikat, 
                       tbl_cek_bi.an_sertifikat, 
                       tbl_cek_bi.luas, 
                       tbl_cek_bi.alamat_lokasi, 
                       tbl_cek_bi.foto_ktp, 
                       tbl_cek_bi.kode_kantor,
                       tbl_cek_bi.tanggal,
                       tbl_file_user.category,
                       t_kelurahan.nama AS kelurahan_nama,
                       t_kecamatan.nama AS kecamatan_nama,
                       t_kota.nama AS kota_nama,
                       t_provinsi.nama AS provinsi_nama'); // Select additional names

        $this->db->from('tbl_survey');
        $this->db->join('tbl_cek_bi', 'tbl_survey.id_pby = tbl_cek_bi.id', 'inner'); // Join with tbl_cek_bi

        // Join with t_kelurahan, t_kecamatan, t_kota, and t_provinsi
        $this->db->join('t_kelurahan', 'tbl_cek_bi.kelurahan = t_kelurahan.id', 'left');
        $this->db->join('t_kecamatan', 'tbl_cek_bi.kecamatan = t_kecamatan.id', 'left');
        $this->db->join('t_kota', 'tbl_cek_bi.kota_kabupaten = t_kota.id', 'left');
        $this->db->join('t_provinsi', 'tbl_cek_bi.provinsi = t_provinsi.id', 'left');

        $this->db->join('tbl_file_user', 'tbl_survey.id_pby = tbl_file_user.id_pby', 'left');

        $this->db->where('(tbl_survey.status_komite IS NULL OR tbl_survey.status_komite = 0)');

        $this->db->where('tbl_survey.status_analisa', 1);
        $this->db->order_by('tbl_survey.id', 'DESC');  // Sort by latest id
        $query = $this->db->get();
        return $query->result();  // Return the query result as an array of objects
    }

    public function getKomiteHasil()
    {
        $this->db->select('tbl_survey.*, 
                       tbl_cek_bi.id AS usulan_id,
                       tbl_cek_bi.nama, 
                       tbl_cek_bi.nik, 
                       tbl_cek_bi.tgl_lahir, 
                       tbl_cek_bi.tempat_lahir, 
                       tbl_cek_bi.jk, 
                       tbl_cek_bi.alamat, 
                       tbl_cek_bi.jns_alamat,
                       tbl_cek_bi.provinsi,
                       tbl_cek_bi.kota_kabupaten,
                       tbl_cek_bi.kecamatan,
                       tbl_cek_bi.kelurahan,
                       tbl_cek_bi.kode_pos,
                       tbl_cek_bi.negara,
                       tbl_cek_bi.status_kawin,
                       tbl_cek_bi.status_pendidikan,
                       tbl_cek_bi.nama_ibu, 
                       tbl_cek_bi.pekerjaan, 
                       tbl_cek_bi.tujuan, 
                       tbl_cek_bi.nominal, 
                       tbl_cek_bi.telepon, 
                       tbl_cek_bi.jangka_waktu, 
                       tbl_cek_bi.jaminan, 
                       tbl_cek_bi.id_user,
                       tbl_cek_bi.bpkb, 
                       tbl_cek_bi.jns_kendaraan, 
                       tbl_cek_bi.thn_pembuatan, 
                       tbl_cek_bi.merk, 
                       tbl_cek_bi.no_mesin, 
                       tbl_cek_bi.no_rangka, 
                       tbl_cek_bi.no_pol, 
                       tbl_cek_bi.sertifikat, 
                       tbl_cek_bi.an_sertifikat, 
                       tbl_cek_bi.luas, 
                       tbl_cek_bi.alamat_lokasi, 
                       tbl_cek_bi.foto_ktp, 
                       tbl_cek_bi.kode_kantor,
                       tbl_cek_bi.tanggal,
                       tbl_file_user.category,
                       t_kelurahan.nama AS kelurahan_nama,
                       t_kecamatan.nama AS kecamatan_nama,
                       t_kota.nama AS kota_nama,
                       t_provinsi.nama AS provinsi_nama'); // Select additional names

        $this->db->from('tbl_survey');
        $this->db->join('tbl_cek_bi', 'tbl_survey.id_pby = tbl_cek_bi.id', 'inner'); // Join with tbl_cek_bi

        // Join with t_kelurahan, t_kecamatan, t_kota, and t_provinsi
        $this->db->join('t_kelurahan', 'tbl_cek_bi.kelurahan = t_kelurahan.id', 'left');
        $this->db->join('t_kecamatan', 'tbl_cek_bi.kecamatan = t_kecamatan.id', 'left');
        $this->db->join('t_kota', 'tbl_cek_bi.kota_kabupaten = t_kota.id', 'left');
        $this->db->join('t_provinsi', 'tbl_cek_bi.provinsi = t_provinsi.id', 'left');

        $this->db->join('tbl_file_user', 'tbl_survey.id_pby = tbl_file_user.id_pby', 'left');

        // Where condition for 'status_komite' being NOT NULL
        $this->db->where('(tbl_survey.status_komite IS NOT NULL AND tbl_survey.status_komite != 0)');

        $this->db->where('tbl_survey.status_analisa', 1); // Keep the condition for 'status_analisa' as 1
        $this->db->order_by('tbl_survey.id', 'DESC');  // Sort by latest id
        $query = $this->db->get();

        return $query->result();  // Return the query result as an array of objects
    }

    public function getKomiteDetail($id_pby)
    {
        // Select fields from the relevant tables
        $this->db->select('tbl_survey.*, 
                       tbl_cek_bi.id AS usulan_id,
                       tbl_cek_bi.nama, 
                       tbl_cek_bi.nik, 
                       tbl_cek_bi.tgl_lahir, 
                       tbl_cek_bi.tempat_lahir, 
                       tbl_cek_bi.jk, 
                       tbl_cek_bi.alamat,
                       tbl_cek_bi.jns_alamat,
                       tbl_cek_bi.provinsi,
                       tbl_cek_bi.kota_kabupaten,
                       tbl_cek_bi.kecamatan,
                       tbl_cek_bi.kelurahan,
                       tbl_cek_bi.kode_pos,
                       tbl_cek_bi.negara,
                       tbl_cek_bi.status_kawin,
                       tbl_cek_bi.status_pendidikan,
                       tbl_cek_bi.nama_ibu, 
                       tbl_cek_bi.pekerjaan, 
                       tbl_cek_bi.tujuan, 
                       tbl_cek_bi.telepon,
                       tbl_cek_bi.nominal, 
                       tbl_cek_bi.jangka_waktu, 
                       tbl_cek_bi.jaminan,
                       tbl_cek_bi.id_user,
                       tbl_cek_bi.bpkb, 
                       tbl_cek_bi.jns_kendaraan, 
                       tbl_cek_bi.thn_pembuatan, 
                       tbl_cek_bi.merk, 
                       tbl_cek_bi.no_mesin, 
                       tbl_cek_bi.no_rangka, 
                       tbl_cek_bi.no_pol, 
                       tbl_cek_bi.sertifikat, 
                       tbl_cek_bi.an_sertifikat, 
                       tbl_cek_bi.luas, 
                       tbl_cek_bi.alamat_lokasi, 
                       tbl_cek_bi.foto_ktp, 
                       tbl_cek_bi.kode_kantor,
                       t_provinsi.nama AS provinsi_nama,
                       t_kota.nama AS kota_nama,
                       t_kecamatan.nama AS kecamatan_nama,
                       t_kelurahan.nama AS kelurahan_nama');

        // From tbl_survey
        $this->db->from('tbl_survey');

        // Join with tbl_cek_bi
        $this->db->join('tbl_cek_bi', 'tbl_survey.id_pby = tbl_cek_bi.id');

        // Join with the province table
        $this->db->join('t_provinsi', 'tbl_cek_bi.provinsi = t_provinsi.id', 'left');

        // Join with the city table
        $this->db->join('t_kota', 'tbl_cek_bi.kota_kabupaten = t_kota.id', 'left');

        // Join with the district table
        $this->db->join('t_kecamatan', 'tbl_cek_bi.kecamatan = t_kecamatan.id', 'left');

        // Join with the village table
        $this->db->join('t_kelurahan', 'tbl_cek_bi.kelurahan = t_kelurahan.id', 'left');

        // Where clause to filter 
        $this->db->where('tbl_survey.status_analisa', 1);
        $this->db->where('tbl_survey.id_pby', $id_pby);

        // Execute the query
        $query = $this->db->get();

        // Return the result as a single row
        return $query->row();
    }
}

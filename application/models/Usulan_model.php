<?php

class Usulan_model extends CI_Model
{
    protected $tbl_usulan = 'tbl_usulan';
    protected $tbl_survey = 'tbl_survey';

    public function insert_data($form_data)
    {
        return $this->db->insert('tbl_usulan', $form_data);
    }

    public function get_all_data()
    {
        // Mengambil semua data dari tabel tbl_usulan
        $this->db->select('u.*, 
                       s.status_analisa, 
                       s.status_komite,
                       s.tgl_cek_bi,
                       s.keterangan,
                       f.category,
                       t_kelurahan.nama AS kelurahan_nama, 
                       t_kecamatan.nama AS kecamatan_nama, 
                       t_kota.nama AS kota_nama, 
                       t_provinsi.nama AS provinsi_nama'); // Ambil semua kolom dari tbl_usulan dan status_analisa dari tbl_survey

        $this->db->from('tbl_usulan u');
        $this->db->join('tbl_survey s', 'u.id = s.id_pby', 'left'); // Menggunakan left join untuk mengaitkan tbl_usulan dan tbl_survey

        // Tambahkan join untuk mengambil nama kelurahan, kecamatan, kota, dan provinsi
        $this->db->join('t_kelurahan', 'u.kelurahan = t_kelurahan.id', 'left');
        $this->db->join('t_kecamatan', 'u.kecamatan = t_kecamatan.id', 'left');
        $this->db->join('t_kota', 'u.kota_kabupaten = t_kota.id', 'left');
        $this->db->join('t_provinsi', 'u.provinsi = t_provinsi.id', 'left');

        $this->db->join('tbl_file_user f', 'u.id = f.id_pby', 'left');

        $this->db->order_by('u.id', 'DESC'); // Mengurutkan berdasarkan id tbl_usulan

        $query = $this->db->get();
        return $query->result(); // Mengembalikan hasil query dalam bentuk array objek
    }

    public function get_all_data_by_id_user($id_user)
    {
        // Mengambil semua data dari tabel tbl_usulan
        $this->db->select('u.*, 
                       s.status_analisa, 
                       s.status_komite,
                       s.tgl_cek_bi,
                       s.keterangan,
                       f.category,
                       t_kelurahan.nama AS kelurahan_nama, 
                       t_kecamatan.nama AS kecamatan_nama, 
                       t_kota.nama AS kota_nama, 
                       t_provinsi.nama AS provinsi_nama'); // Ambil semua kolom dari tbl_usulan dan status_analisa dari tbl_survey

        $this->db->from('tbl_usulan u');
        $this->db->join('tbl_survey s', 'u.id = s.id_pby', 'left'); // Menggunakan left join untuk mengaitkan tbl_usulan dan tbl_survey

        // Tambahkan join untuk mengambil nama kelurahan, kecamatan, kota, dan provinsi
        $this->db->join('t_kelurahan', 'u.kelurahan = t_kelurahan.id', 'left');
        $this->db->join('t_kecamatan', 'u.kecamatan = t_kecamatan.id', 'left');
        $this->db->join('t_kota', 'u.kota_kabupaten = t_kota.id', 'left');
        $this->db->join('t_provinsi', 'u.provinsi = t_provinsi.id', 'left');

        $this->db->join('tbl_file_user f', 'u.id = f.id_pby', 'left');

        // Tambahkan kondisi untuk id_user
        $this->db->where('u.id_user', $id_user);

        $this->db->order_by('u.id', 'DESC'); // Mengurutkan berdasarkan id tbl_usulan

        $query = $this->db->get();
        return $query->result(); // Mengembalikan hasil query dalam bentuk array objek
    }

    public function get_usulan_bulan_berjalan_per_kantor()
    {
        $this->db->select("kode_kantor, COUNT(id) as jumlah_usulan, SUM(nominal) as total_nominal, 
                           DATE_FORMAT(tanggal, '%M %Y') as bulan_tahun"); // Menambahkan bulan dan tahun
        $this->db->from('tbl_usulan');
        $this->db->where("MONTH(tanggal) = MONTH(CURDATE())");
        $this->db->where("YEAR(tanggal) = YEAR(CURDATE())");
        $this->db->group_by("kode_kantor, bulan_tahun");
        $this->db->order_by("bulan_tahun ASC, kode_kantor ASC");
        $query = $this->db->get();
        return $query->result();
    }

    public function get_usulan_bulan_berjalan_per_user()
    {
        $this->db->select("u.id_user, u.nama_lengkap, COUNT(usulan.id) as jumlah_usulan, 
                           SUM(usulan.nominal) as total_nominal, 
                           DATE_FORMAT(usulan.tanggal, '%M %Y') as bulan_tahun"); // Menambahkan nama lengkap dan bulan tahun
        $this->db->from('tbl_usulan usulan');
        $this->db->join('tbl_user u', 'u.id_user = usulan.id_user', 'left'); // Melakukan JOIN ke tbl_user
        $this->db->where("MONTH(usulan.tanggal) = MONTH(CURDATE())");
        $this->db->where("YEAR(usulan.tanggal) = YEAR(CURDATE())");
        $this->db->group_by("u.id_user, u.nama_lengkap, bulan_tahun"); // Group by id_user dan nama_lengkap
        $this->db->order_by("bulan_tahun ASC, u.nama_lengkap ASC"); // Mengurutkan berdasarkan nama_lengkap
        $query = $this->db->get();
        return $query->result();
    }    

    public function get_all_data_belum_survey()
    {
        $this->db->select('tbl_usulan.*, tbl_file_user.category');
        $this->db->from('tbl_usulan');
        $this->db->join('tbl_file_user', 'tbl_file_user.id_pby = tbl_usulan.id', 'left');
        $this->db->where('status_survey', 0);
        $this->db->where('tbl_usulan.status', 'Aktif');
        $this->db->order_by('id', 'DESC');

        $query = $this->db->get();
        return $query->result(); // Mengembalikan hasil query dalam bentuk array objek
    }

    public function get_usulan_data_cabang()
    {
        $this->db->select('tbl_usulan.*, tbl_file_user.category');
        $this->db->from('tbl_usulan');
        $this->db->join('tbl_file_user', 'tbl_file_user.id_pby = tbl_usulan.id', 'left');
        // Get usulan data where nominal is less than or equal to 20 million
        $this->db->where('status_survey', 0);
        $this->db->where('nominal <=', 20000000);
        $this->db->where('tbl_usulan.status', 'Aktif');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_usulan_data_pusat()
    {
        $this->db->select('tbl_usulan.*, tbl_file_user.category');
        $this->db->from('tbl_usulan');
        $this->db->join('tbl_file_user', 'tbl_file_user.id_pby = tbl_usulan.id', 'left');
        $this->db->where('status_survey', 0);
        $this->db->where('nominal >', 20000000);
        $this->db->where('tbl_usulan.status', 'Aktif');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_all_data_sudah_survey()
    {
        $this->db->select('tbl_usulan.*, tbl_file_user.category, tbl_survey.tgl_cek_bi'); // Menambahkan kolom category dari tbl_file_user
        $this->db->from('tbl_usulan');
        $this->db->join('tbl_file_user', 'tbl_file_user.id_pby = tbl_usulan.id', 'left'); // JOIN dengan tbl_file_user
        $this->db->join('tbl_survey', 'tbl_survey.id_pby = tbl_usulan.id', 'left'); // JOIN dengan tbl_survey
        $this->db->where('tbl_usulan.status_survey', 1); // Filter berdasarkan status_survey = 1
        $this->db->order_by('tbl_usulan.id', 'DESC'); // Urutkan berdasarkan id di tbl_usulan

        $query = $this->db->get();
        return $query->result(); // Mengembalikan hasil query dalam bentuk array objek
    }

    public function get_all_data_sudah_survey_pusat()
    {
        $this->db->select('tbl_usulan.*, tbl_file_user.category, tbl_survey.tgl_cek_bi'); // Menambahkan kolom category dari tbl_file_user
        $this->db->from('tbl_usulan');
        $this->db->join('tbl_file_user', 'tbl_file_user.id_pby = tbl_usulan.id', 'left'); // JOIN dengan tbl_file_user
        $this->db->join('tbl_survey', 'tbl_survey.id_pby = tbl_usulan.id', 'left'); // JOIN dengan tbl_survey
        $this->db->where('tbl_usulan.status_survey', 1); // Filter berdasarkan status_survey = 1
        $this->db->order_by('tbl_usulan.id', 'DESC'); // Urutkan berdasarkan id di tbl_usulan
        $this->db->where('nominal >', 20000000);
        $query = $this->db->get();
        return $query->result(); // Mengembalikan hasil query dalam bentuk array objek
    }

    public function get_all_data_sudah_survey_cabang()
    {
        $this->db->select('tbl_usulan.*, tbl_file_user.category, tbl_survey.tgl_cek_bi'); // Menambahkan kolom category dari tbl_file_user
        $this->db->from('tbl_usulan');
        $this->db->join('tbl_file_user', 'tbl_file_user.id_pby = tbl_usulan.id', 'left'); // JOIN dengan tbl_file_user
        $this->db->join('tbl_survey', 'tbl_survey.id_pby = tbl_usulan.id', 'left'); // JOIN dengan tbl_survey
        $this->db->where('tbl_usulan.status_survey', 1); // Filter berdasarkan status_survey = 1
        $this->db->order_by('tbl_usulan.id', 'DESC'); // Urutkan berdasarkan id di tbl_usulan
        $this->db->where('nominal <=', 20000000);
        $query = $this->db->get();
        return $query->result(); // Mengembalikan hasil query dalam bentuk array objek
    }

    public function get_data_by_id($id)
    {
        // Get data by ID
        $query = $this->db->get_where('tbl_usulan', array('id' => $id));
        return $query->row();
    }

    public function delete_data($id)
    {
        // Delete data by ID
        $this->db->where('id', $id);
        $this->db->delete('tbl_usulan');

        // Check if the deletion was successful
        return $this->db->affected_rows() > 0;
    }

    public function getUsulanDetail($id)
    {
        $this->db->select('tbl_usulan.*, 
                       tbl_survey.status_analisa,  
                       tbl_survey.status_komite,
                       tbl_survey.tgl_cek_bi,
                       t_kelurahan.nama AS kelurahan_nama,
                       t_kecamatan.nama AS kecamatan_nama,
                       t_kota.nama AS kota_nama,
                       t_provinsi.nama AS provinsi_nama'); // Select additional names

        $this->db->from('tbl_usulan');
        $this->db->join('tbl_survey', 'tbl_survey.id_pby = tbl_usulan.id', 'left'); // Join with tbl_survey

        // Join with t_kelurahan, t_kecamatan, t_kota, and t_provinsi
        $this->db->join('t_kelurahan', 'tbl_usulan.kelurahan = t_kelurahan.id', 'left');
        $this->db->join('t_kecamatan', 'tbl_usulan.kecamatan = t_kecamatan.id', 'left');
        $this->db->join('t_kota', 'tbl_usulan.kota_kabupaten = t_kota.id', 'left');
        $this->db->join('t_provinsi', 'tbl_usulan.provinsi = t_provinsi.id', 'left');

        $this->db->where('tbl_usulan.id', $id);
        $query = $this->db->get();
        return $query->row();  // Return a single row result
    }

    public function get_survey_data_by_id($row_id)
    {
        // Select kolom dari tbl_usulan dan tabel terkait
        $this->db->select('tbl_usulan.id AS usulan_id,
                           tbl_usulan.*, 
                           tbl_survey.*, 
                           t_kelurahan.nama AS kelurahan_nama,
                           t_kecamatan.nama AS kecamatan_nama,
                           t_kota.nama AS kota_nama,
                           t_provinsi.nama AS provinsi_nama'); // Pilih kolom yang diinginkan

        $this->db->from('tbl_usulan');

        $this->db->join('tbl_survey', 'tbl_usulan.id = tbl_survey.id_pby', 'left');
        // Join dengan tabel-tabel terkait untuk mendapatkan nama wilayah
        $this->db->join('t_kelurahan', 'tbl_usulan.kelurahan = t_kelurahan.id', 'left');
        $this->db->join('t_kecamatan', 'tbl_usulan.kecamatan = t_kecamatan.id', 'left');
        $this->db->join('t_kota', 'tbl_usulan.kota_kabupaten = t_kota.id', 'left');
        $this->db->join('t_provinsi', 'tbl_usulan.provinsi = t_provinsi.id', 'left');

        // Tambahkan kondisi untuk mengambil data berdasarkan row_id
        $this->db->where('tbl_usulan.id', $row_id);

        // Eksekusi query dan kembalikan hasil sebagai objek
        $query = $this->db->get();
        return $query->row(); // Mengembalikan hasil query dalam bentuk objek
    }

    public function update_usulan($row_id, $data)
    {
        $this->db->where('id', $row_id);
        $this->db->update('tbl_usulan', $data);
    }

    // public function insert_survey_data($data)
    // {
    //     return $this->db->insert('tbl_survey', $data);
    // }

    public function insert_survey_data($data) {
        // Cek apakah id_pby sudah ada di database
        $this->db->where('id_pby', $data['id_pby']);
        $existing_survey = $this->db->get('tbl_survey')->row();
        
        if ($existing_survey) {
            // Jika id_pby sudah ada, lakukan update
            $this->db->where('id_pby', $data['id_pby']);
            $this->db->update('tbl_survey', $data);
        } else {
            // Jika belum ada, lakukan insert
            $this->db->insert('tbl_survey', $data);
        }
    }    

    public function set_status_survey($row_id, $status)
    {
        // Update status_survey menjadi 1
        $this->db->where('id', $row_id);
        $this->db->update('tbl_usulan', array('status_survey' => $status));
    }
    public function getSurveyData()
    {
        $this->db->select('tbl_survey.*, 
                       tbl_usulan.id AS usulan_id,
                       tbl_usulan.nama, 
                       tbl_usulan.nik, 
                       tbl_usulan.tgl_lahir, 
                       tbl_usulan.tempat_lahir, 
                       tbl_usulan.jk, 
                       tbl_usulan.alamat, 
                       tbl_usulan.jns_alamat,
                       tbl_usulan.provinsi,
                       tbl_usulan.kota_kabupaten,
                       tbl_usulan.kecamatan,
                       tbl_usulan.kelurahan,
                       tbl_usulan.kode_pos,
                       tbl_usulan.negara,
                       tbl_usulan.status_kawin,
                       tbl_usulan.status_pendidikan,
                       tbl_usulan.nama_ibu, 
                       tbl_usulan.pekerjaan, 
                       tbl_usulan.tujuan, 
                       tbl_usulan.nominal, 
                       tbl_usulan.telepon, 
                       tbl_usulan.jangka_waktu, 
                       tbl_usulan.jaminan, 
                       tbl_usulan.id_user,
                       tbl_usulan.bpkb, 
                       tbl_usulan.jns_kendaraan, 
                       tbl_usulan.thn_pembuatan, 
                       tbl_usulan.merk, 
                       tbl_usulan.no_mesin, 
                       tbl_usulan.no_rangka, 
                       tbl_usulan.no_pol, 
                       tbl_usulan.sertifikat, 
                       tbl_usulan.an_sertifikat, 
                       tbl_usulan.luas, 
                       tbl_usulan.alamat_lokasi, 
                       tbl_usulan.foto_ktp, 
                       tbl_usulan.kode_kantor,
                       tbl_usulan.ttd,
                       tbl_usulan.tanggal,
                       t_kelurahan.nama AS kelurahan_nama,
                       t_kecamatan.nama AS kecamatan_nama,
                       t_kota.nama AS kota_nama,
                       t_provinsi.nama AS provinsi_nama,
                       tbl_file_user.file_name, 
                       tbl_file_user.file_path, 
                       tbl_file_user.category, 
                       tbl_file_user.uploaded_at'); // Select additional names

        $this->db->from('tbl_survey');
        $this->db->join('tbl_usulan', 'tbl_survey.id_pby = tbl_usulan.id', 'inner'); // Join with tbl_usulan

        // Join with t_kelurahan, t_kecamatan, t_kota, and t_provinsi
        $this->db->join('t_kelurahan', 'tbl_usulan.kelurahan = t_kelurahan.id', 'left');
        $this->db->join('t_kecamatan', 'tbl_usulan.kecamatan = t_kecamatan.id', 'left');
        $this->db->join('t_kota', 'tbl_usulan.kota_kabupaten = t_kota.id', 'left');
        $this->db->join('t_provinsi', 'tbl_usulan.provinsi = t_provinsi.id', 'left');

        $this->db->join('tbl_file_user', 'tbl_survey.id_pby = tbl_file_user.id_pby', 'left');

        $this->db->where('(tbl_survey.hasil_analisa IS NULL OR tbl_survey.hasil_analisa = 0)');

        $this->db->order_by('tbl_survey.tgl_survey', 'DESC');  // Sort by latest id
        $query = $this->db->get();
        return $query->result();  // Return the query result as an array of objects
    }

    public function getHasilAnalisa()
    {
        $this->db->select('tbl_survey.*, 
                       tbl_usulan.id AS usulan_id,
                       tbl_usulan.nama, 
                       tbl_usulan.nik, 
                       tbl_usulan.tgl_lahir, 
                       tbl_usulan.tempat_lahir, 
                       tbl_usulan.jk, 
                       tbl_usulan.alamat, 
                       tbl_usulan.jns_alamat,
                       tbl_usulan.provinsi,
                       tbl_usulan.kota_kabupaten,
                       tbl_usulan.kecamatan,
                       tbl_usulan.kelurahan,
                       tbl_usulan.kode_pos,
                       tbl_usulan.negara,
                       tbl_usulan.status_kawin,
                       tbl_usulan.status_pendidikan,
                       tbl_usulan.nama_ibu, 
                       tbl_usulan.pekerjaan, 
                       tbl_usulan.tujuan, 
                       tbl_usulan.nominal, 
                       tbl_usulan.telepon, 
                       tbl_usulan.jangka_waktu, 
                       tbl_usulan.jaminan, 
                       tbl_usulan.id_user,
                       tbl_usulan.bpkb, 
                       tbl_usulan.jns_kendaraan, 
                       tbl_usulan.thn_pembuatan, 
                       tbl_usulan.merk, 
                       tbl_usulan.no_mesin, 
                       tbl_usulan.no_rangka, 
                       tbl_usulan.no_pol, 
                       tbl_usulan.sertifikat, 
                       tbl_usulan.an_sertifikat, 
                       tbl_usulan.luas, 
                       tbl_usulan.alamat_lokasi, 
                       tbl_usulan.foto_ktp, 
                       tbl_usulan.kode_kantor,
                       tbl_usulan.ttd,
                       tbl_usulan.tanggal,
                       tbl_file_user.category, 
                       t_kelurahan.nama AS kelurahan_nama,
                       t_kecamatan.nama AS kecamatan_nama,
                       t_kota.nama AS kota_nama,
                       t_provinsi.nama AS provinsi_nama'); // Select additional names

        $this->db->from('tbl_survey');
        $this->db->join('tbl_usulan', 'tbl_survey.id_pby = tbl_usulan.id', 'inner'); // Join with tbl_usulan

        $this->db->join('tbl_file_user', 'tbl_survey.id_pby = tbl_file_user.id_pby', 'left');

        // Join with t_kelurahan, t_kecamatan, t_kota, and t_provinsi
        $this->db->join('t_kelurahan', 'tbl_usulan.kelurahan = t_kelurahan.id', 'left');
        $this->db->join('t_kecamatan', 'tbl_usulan.kecamatan = t_kecamatan.id', 'left');
        $this->db->join('t_kota', 'tbl_usulan.kota_kabupaten = t_kota.id', 'left');
        $this->db->join('t_provinsi', 'tbl_usulan.provinsi = t_provinsi.id', 'left');

        $this->db->where('(tbl_survey.hasil_analisa IS NOT NULL AND tbl_survey.hasil_analisa != 0)');

        // $this->db->where('tbl_survey.status_status', 0);  
        $this->db->order_by('tbl_survey.id', 'DESC');  // Sort by latest id
        $query = $this->db->get();
        return $query->result();  // Return the query result as an array of objects
    }

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

    public function getUsernameByLevel($level)
    {
        $this->db->select('nama_lengkap');  // Select the 'nama_lengkap' column
        $this->db->where('level', $level);  // Filter by the specified level
        $query = $this->db->get('tbl_user');  // Get data from 'tbl_user' table

        if ($query->num_rows() > 0) {
            return $query->row()->nama_lengkap;  // Return 'nama_lengkap' of the first matching user
        } else {
            return '-';  // Return '-' if no matching user is found
        }
    }

    public function getUsernameByLevelAndKantor($level, $id_pby)
    {
        $this->db->select('u.nama_lengkap');  // Select the 'nama_lengkap' from 'tbl_user'
        $this->db->from('tbl_user u');  // Start with the 'tbl_user' table, alias it as 'u'

        // Join with 'tbl_usulan' where 'tbl_user.kode_kantor' matches 'tbl_usulan.kode_kantor'
        $this->db->join('tbl_usulan us', 'u.kode_kantor = us.kode_kantor', 'inner');

        // Add condition for the level of the user
        $this->db->where('u.level', $level);

        // Add condition to match the 'id_pby' from the 'tbl_survey' with the 'id' in 'tbl_usulan'
        $this->db->where('us.id', $id_pby);

        // Execute the query
        $query = $this->db->get();

        // Check if a matching user is found
        if ($query->num_rows() > 0) {
            return $query->row()->nama_lengkap;  // Return 'nama_lengkap' of the matched user
        } else {
            return '-';  // Return '-' if no matching user is found
        }
    }

    public function getSurveyDetail($id_pby)
    {
        // Select fields from the relevant tables
        $this->db->select('tbl_survey.*, 
                       tbl_usulan.id AS usulan_id,
                       tbl_usulan.nama, 
                       tbl_usulan.nik, 
                       tbl_usulan.tgl_lahir, 
                       tbl_usulan.tempat_lahir, 
                       tbl_usulan.jk, 
                       tbl_usulan.alamat,
                       tbl_usulan.jns_alamat,
                       tbl_usulan.provinsi,
                       tbl_usulan.kota_kabupaten,
                       tbl_usulan.kecamatan,
                       tbl_usulan.kelurahan,
                       tbl_usulan.kode_pos,
                       tbl_usulan.negara,
                       tbl_usulan.status_kawin,
                       tbl_usulan.status_pendidikan,
                       tbl_usulan.nama_ibu, 
                       tbl_usulan.pekerjaan, 
                       tbl_usulan.tujuan, 
                       tbl_usulan.telepon,
                       tbl_usulan.nominal, 
                       tbl_usulan.jangka_waktu, 
                       tbl_usulan.jaminan,
                       tbl_usulan.id_user,
                       tbl_usulan.bpkb, 
                       tbl_usulan.jns_kendaraan, 
                       tbl_usulan.thn_pembuatan, 
                       tbl_usulan.merk, 
                       tbl_usulan.no_mesin, 
                       tbl_usulan.no_rangka, 
                       tbl_usulan.no_pol, 
                       tbl_usulan.sertifikat, 
                       tbl_usulan.an_sertifikat, 
                       tbl_usulan.luas, 
                       tbl_usulan.alamat_lokasi, 
                       tbl_usulan.foto_ktp, 
                       tbl_usulan.kode_kantor,
                       tbl_file_user.category, 
                       t_provinsi.nama AS provinsi_nama,
                       t_kota.nama AS kota_nama,
                       t_kecamatan.nama AS kecamatan_nama,
                       t_kelurahan.nama AS kelurahan_nama');

        // From tbl_survey
        $this->db->from('tbl_survey');

        // Join with tbl_usulan
        $this->db->join('tbl_usulan', 'tbl_survey.id_pby = tbl_usulan.id');

        // Join with the province table
        $this->db->join('t_provinsi', 'tbl_usulan.provinsi = t_provinsi.id', 'left');

        // Join with the city table
        $this->db->join('t_kota', 'tbl_usulan.kota_kabupaten = t_kota.id', 'left');

        // Join with the district table
        $this->db->join('t_kecamatan', 'tbl_usulan.kecamatan = t_kecamatan.id', 'left');

        // Join with the village table
        $this->db->join('t_kelurahan', 'tbl_usulan.kelurahan = t_kelurahan.id', 'left');

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
        // Pastikan menggunakan 'set' untuk setiap field yang akan diupdate
        foreach ($data as $key => $value) {
            $this->db->set($key, $value);
        }

        // Tentukan id yang akan diupdate
        $this->db->where('id_pby', $row_id);

        // Proses update data
        $this->db->update('tbl_survey');
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
                       tbl_usulan.id AS usulan_id,
                       tbl_usulan.nama, 
                       tbl_usulan.nik, 
                       tbl_usulan.tgl_lahir, 
                       tbl_usulan.tempat_lahir, 
                       tbl_usulan.jk, 
                       tbl_usulan.alamat, 
                       tbl_usulan.jns_alamat,
                       tbl_usulan.provinsi,
                       tbl_usulan.kota_kabupaten,
                       tbl_usulan.kecamatan,
                       tbl_usulan.kelurahan,
                       tbl_usulan.kode_pos,
                       tbl_usulan.negara,
                       tbl_usulan.status_kawin,
                       tbl_usulan.status_pendidikan,
                       tbl_usulan.nama_ibu, 
                       tbl_usulan.pekerjaan, 
                       tbl_usulan.tujuan, 
                       tbl_usulan.nominal, 
                       tbl_usulan.telepon, 
                       tbl_usulan.jangka_waktu, 
                       tbl_usulan.jaminan, 
                       tbl_usulan.id_user,
                       tbl_usulan.bpkb, 
                       tbl_usulan.jns_kendaraan, 
                       tbl_usulan.thn_pembuatan, 
                       tbl_usulan.merk, 
                       tbl_usulan.no_mesin, 
                       tbl_usulan.no_rangka, 
                       tbl_usulan.no_pol, 
                       tbl_usulan.sertifikat, 
                       tbl_usulan.an_sertifikat, 
                       tbl_usulan.luas, 
                       tbl_usulan.alamat_lokasi, 
                       tbl_usulan.foto_ktp, 
                       tbl_usulan.kode_kantor,
                       tbl_usulan.tanggal,
                       tbl_file_user.category,
                       t_kelurahan.nama AS kelurahan_nama,
                       t_kecamatan.nama AS kecamatan_nama,
                       t_kota.nama AS kota_nama,
                       t_provinsi.nama AS provinsi_nama'); // Select additional names

        $this->db->from('tbl_survey');
        $this->db->join('tbl_usulan', 'tbl_survey.id_pby = tbl_usulan.id', 'inner'); // Join with tbl_usulan

        // Join with t_kelurahan, t_kecamatan, t_kota, and t_provinsi
        $this->db->join('t_kelurahan', 'tbl_usulan.kelurahan = t_kelurahan.id', 'left');
        $this->db->join('t_kecamatan', 'tbl_usulan.kecamatan = t_kecamatan.id', 'left');
        $this->db->join('t_kota', 'tbl_usulan.kota_kabupaten = t_kota.id', 'left');
        $this->db->join('t_provinsi', 'tbl_usulan.provinsi = t_provinsi.id', 'left');

        $this->db->join('tbl_file_user', 'tbl_survey.id_pby = tbl_file_user.id_pby', 'left');

        $this->db->where('(tbl_survey.status_komite IS NULL OR tbl_survey.status_komite = 0)');

        $this->db->where('tbl_survey.status_analisa', 1);
        $this->db->order_by('tbl_survey.id', 'DESC');  // Sort by latest id
        $query = $this->db->get();
        return $query->result();  // Return the query result as an array of objects
    }

    public function getKomiteDataByDate($start_date = null, $end_date = null)
    {
        $this->db->select('tbl_survey.*, 
                       tbl_usulan.id AS usulan_id,
                       tbl_usulan.nama, 
                       tbl_usulan.nik, 
                       tbl_usulan.tgl_lahir, 
                       tbl_usulan.tempat_lahir, 
                       tbl_usulan.jk, 
                       tbl_usulan.alamat, 
                       tbl_usulan.jns_alamat,
                       tbl_usulan.provinsi,
                       tbl_usulan.kota_kabupaten,
                       tbl_usulan.kecamatan,
                       tbl_usulan.kelurahan,
                       tbl_usulan.kode_pos,
                       tbl_usulan.negara,
                       tbl_usulan.status_kawin,
                       tbl_usulan.status_pendidikan,
                       tbl_usulan.nama_ibu, 
                       tbl_usulan.pekerjaan, 
                       tbl_usulan.tujuan, 
                       tbl_usulan.nominal, 
                       tbl_usulan.telepon, 
                       tbl_usulan.jangka_waktu, 
                       tbl_usulan.jaminan, 
                       tbl_usulan.id_user,
                       tbl_usulan.bpkb, 
                       tbl_usulan.jns_kendaraan, 
                       tbl_usulan.thn_pembuatan, 
                       tbl_usulan.merk, 
                       tbl_usulan.no_mesin, 
                       tbl_usulan.no_rangka, 
                       tbl_usulan.no_pol, 
                       tbl_usulan.sertifikat, 
                       tbl_usulan.an_sertifikat, 
                       tbl_usulan.luas, 
                       tbl_usulan.alamat_lokasi, 
                       tbl_usulan.foto_ktp, 
                       tbl_usulan.kode_kantor,
                       tbl_usulan.tanggal,
                       tbl_file_user.category,
                       t_kelurahan.nama AS kelurahan_nama,
                       t_kecamatan.nama AS kecamatan_nama,
                       t_kota.nama AS kota_nama,
                       t_provinsi.nama AS provinsi_nama'); // Select additional names

        $this->db->from('tbl_survey');
        $this->db->join('tbl_usulan', 'tbl_survey.id_pby = tbl_usulan.id', 'inner');

        // Join with t_kelurahan, t_kecamatan, t_kota, and t_provinsi
        $this->db->join('t_kelurahan', 'tbl_usulan.kelurahan = t_kelurahan.id', 'left');
        $this->db->join('t_kecamatan', 'tbl_usulan.kecamatan = t_kecamatan.id', 'left');
        $this->db->join('t_kota', 'tbl_usulan.kota_kabupaten = t_kota.id', 'left');
        $this->db->join('t_provinsi', 'tbl_usulan.provinsi = t_provinsi.id', 'left');

        $this->db->join('tbl_file_user', 'tbl_survey.id_pby = tbl_file_user.id_pby', 'left');

        $this->db->where('(tbl_survey.status_komite IS NULL OR tbl_survey.status_komite = 0)');
        $this->db->where('tbl_survey.status_analisa', 1);

        // Filter by date range if provided
        if ($start_date && $end_date) {
            $this->db->where('tbl_survey.tgl_survey >=', $start_date);
            $this->db->where('tbl_survey.tgl_survey <=', $end_date);
        }

        $this->db->order_by('tbl_survey.id', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function getKomiteHasil()
    {
        $this->db->select('tbl_survey.*, 
                       tbl_usulan.id AS usulan_id,
                       tbl_usulan.nama, 
                       tbl_usulan.nik, 
                       tbl_usulan.tgl_lahir, 
                       tbl_usulan.tempat_lahir, 
                       tbl_usulan.jk, 
                       tbl_usulan.alamat, 
                       tbl_usulan.jns_alamat,
                       tbl_usulan.provinsi,
                       tbl_usulan.kota_kabupaten,
                       tbl_usulan.kecamatan,
                       tbl_usulan.kelurahan,
                       tbl_usulan.kode_pos,
                       tbl_usulan.negara,
                       tbl_usulan.status_kawin,
                       tbl_usulan.status_pendidikan,
                       tbl_usulan.nama_ibu, 
                       tbl_usulan.pekerjaan, 
                       tbl_usulan.tujuan, 
                       tbl_usulan.nominal, 
                       tbl_usulan.telepon, 
                       tbl_usulan.jangka_waktu, 
                       tbl_usulan.jaminan, 
                       tbl_usulan.id_user,
                       tbl_usulan.bpkb, 
                       tbl_usulan.jns_kendaraan, 
                       tbl_usulan.thn_pembuatan, 
                       tbl_usulan.merk, 
                       tbl_usulan.no_mesin, 
                       tbl_usulan.no_rangka, 
                       tbl_usulan.no_pol, 
                       tbl_usulan.sertifikat, 
                       tbl_usulan.an_sertifikat, 
                       tbl_usulan.luas, 
                       tbl_usulan.alamat_lokasi, 
                       tbl_usulan.foto_ktp, 
                       tbl_usulan.kode_kantor,
                       tbl_usulan.tanggal,
                       tbl_file_user.category,
                       t_kelurahan.nama AS kelurahan_nama,
                       t_kecamatan.nama AS kecamatan_nama,
                       t_kota.nama AS kota_nama,
                       t_provinsi.nama AS provinsi_nama'); // Select additional names

        $this->db->from('tbl_survey');
        $this->db->join('tbl_usulan', 'tbl_survey.id_pby = tbl_usulan.id', 'inner'); // Join with tbl_usulan

        // Join with t_kelurahan, t_kecamatan, t_kota, and t_provinsi
        $this->db->join('t_kelurahan', 'tbl_usulan.kelurahan = t_kelurahan.id', 'left');
        $this->db->join('t_kecamatan', 'tbl_usulan.kecamatan = t_kecamatan.id', 'left');
        $this->db->join('t_kota', 'tbl_usulan.kota_kabupaten = t_kota.id', 'left');
        $this->db->join('t_provinsi', 'tbl_usulan.provinsi = t_provinsi.id', 'left');

        $this->db->join('tbl_file_user', 'tbl_survey.id_pby = tbl_file_user.id_pby', 'left');

        // Where condition for 'status_komite' being NOT NULL
        $this->db->where('(tbl_survey.status_komite IS NOT NULL AND tbl_survey.status_komite != 0)');

        $this->db->where('tbl_survey.status_analisa', 1); // Keep the condition for 'status_analisa' as 1
        $this->db->order_by('tbl_survey.id', 'DESC');  // Sort by latest id
        $query = $this->db->get();

        return $query->result();  // Return the query result as an array of objects
    }

    public function getKomiteHasilByDate($start_date = null, $end_date = null)
    {
        $this->db->select('tbl_survey.*, 
                       tbl_usulan.id AS usulan_id,
                       tbl_usulan.nama, 
                       tbl_usulan.nik, 
                       tbl_usulan.tgl_lahir, 
                       tbl_usulan.tempat_lahir, 
                       tbl_usulan.jk, 
                       tbl_usulan.alamat, 
                       tbl_usulan.jns_alamat,
                       tbl_usulan.provinsi,
                       tbl_usulan.kota_kabupaten,
                       tbl_usulan.kecamatan,
                       tbl_usulan.kelurahan,
                       tbl_usulan.kode_pos,
                       tbl_usulan.negara,
                       tbl_usulan.status_kawin,
                       tbl_usulan.status_pendidikan,
                       tbl_usulan.nama_ibu, 
                       tbl_usulan.pekerjaan, 
                       tbl_usulan.tujuan, 
                       tbl_usulan.nominal, 
                       tbl_usulan.telepon, 
                       tbl_usulan.jangka_waktu, 
                       tbl_usulan.jaminan, 
                       tbl_usulan.id_user,
                       tbl_usulan.bpkb, 
                       tbl_usulan.jns_kendaraan, 
                       tbl_usulan.thn_pembuatan, 
                       tbl_usulan.merk, 
                       tbl_usulan.no_mesin, 
                       tbl_usulan.no_rangka, 
                       tbl_usulan.no_pol, 
                       tbl_usulan.sertifikat, 
                       tbl_usulan.an_sertifikat, 
                       tbl_usulan.luas, 
                       tbl_usulan.alamat_lokasi, 
                       tbl_usulan.foto_ktp, 
                       tbl_usulan.kode_kantor,
                       tbl_usulan.tanggal,
                       tbl_file_user.category,
                       t_kelurahan.nama AS kelurahan_nama,
                       t_kecamatan.nama AS kecamatan_nama,
                       t_kota.nama AS kota_nama,
                       t_provinsi.nama AS provinsi_nama'); // Select additional names

        $this->db->from('tbl_survey');
        $this->db->join('tbl_usulan', 'tbl_survey.id_pby = tbl_usulan.id', 'inner'); // Join with tbl_usulan

        // Join with t_kelurahan, t_kecamatan, t_kota, and t_provinsi
        $this->db->join('t_kelurahan', 'tbl_usulan.kelurahan = t_kelurahan.id', 'left');
        $this->db->join('t_kecamatan', 'tbl_usulan.kecamatan = t_kecamatan.id', 'left');
        $this->db->join('t_kota', 'tbl_usulan.kota_kabupaten = t_kota.id', 'left');
        $this->db->join('t_provinsi', 'tbl_usulan.provinsi = t_provinsi.id', 'left');

        $this->db->join('tbl_file_user', 'tbl_survey.id_pby = tbl_file_user.id_pby', 'left');

        // Where condition for 'status_komite' being NOT NULL
        $this->db->where('(tbl_survey.status_komite IS NOT NULL AND tbl_survey.status_komite != 0)');

        $this->db->where('tbl_survey.status_analisa', 1); // Keep the condition for 'status_analisa' as 1
        
        if ($start_date && $end_date) {
            $this->db->where('tbl_survey.tgl_survey >=', $start_date);
            $this->db->where('tbl_survey.tgl_survey <=', $end_date);
        }
        $this->db->order_by('tbl_survey.id', 'DESC');  // Sort by latest id
        $query = $this->db->get();

        return $query->result();  // Return the query result as an array of objects
    }

    public function getKomiteDetail($id_pby)
    {
        // Select fields from the relevant tables
        $this->db->select('tbl_survey.*, 
                       tbl_usulan.id AS usulan_id,
                       tbl_usulan.nama, 
                       tbl_usulan.nik, 
                       tbl_usulan.tgl_lahir, 
                       tbl_usulan.tempat_lahir, 
                       tbl_usulan.jk, 
                       tbl_usulan.alamat,
                       tbl_usulan.jns_alamat,
                       tbl_usulan.provinsi,
                       tbl_usulan.kota_kabupaten,
                       tbl_usulan.kecamatan,
                       tbl_usulan.kelurahan,
                       tbl_usulan.kode_pos,
                       tbl_usulan.negara,
                       tbl_usulan.status_kawin,
                       tbl_usulan.status_pendidikan,
                       tbl_usulan.nama_ibu, 
                       tbl_usulan.pekerjaan, 
                       tbl_usulan.tujuan, 
                       tbl_usulan.telepon,
                       tbl_usulan.nominal, 
                       tbl_usulan.jangka_waktu, 
                       tbl_usulan.jaminan,
                       tbl_usulan.id_user,
                       tbl_usulan.bpkb, 
                       tbl_usulan.jns_kendaraan, 
                       tbl_usulan.thn_pembuatan, 
                       tbl_usulan.merk, 
                       tbl_usulan.no_mesin, 
                       tbl_usulan.no_rangka, 
                       tbl_usulan.no_pol, 
                       tbl_usulan.sertifikat, 
                       tbl_usulan.an_sertifikat, 
                       tbl_usulan.luas, 
                       tbl_usulan.alamat_lokasi, 
                       tbl_usulan.foto_ktp, 
                       tbl_usulan.kode_kantor,
                       t_provinsi.nama AS provinsi_nama,
                       t_kota.nama AS kota_nama,
                       t_kecamatan.nama AS kecamatan_nama,
                       t_kelurahan.nama AS kelurahan_nama');

        // From tbl_survey
        $this->db->from('tbl_survey');

        // Join with tbl_usulan
        $this->db->join('tbl_usulan', 'tbl_survey.id_pby = tbl_usulan.id');

        // Join with the province table
        $this->db->join('t_provinsi', 'tbl_usulan.provinsi = t_provinsi.id', 'left');

        // Join with the city table
        $this->db->join('t_kota', 'tbl_usulan.kota_kabupaten = t_kota.id', 'left');

        // Join with the district table
        $this->db->join('t_kecamatan', 'tbl_usulan.kecamatan = t_kecamatan.id', 'left');

        // Join with the village table
        $this->db->join('t_kelurahan', 'tbl_usulan.kelurahan = t_kelurahan.id', 'left');

        // Where clause to filter 
        $this->db->where('tbl_survey.status_analisa', 1);
        $this->db->where('tbl_survey.id_pby', $id_pby);

        // Execute the query
        $query = $this->db->get();

        // Return the result as a single row
        return $query->row();
    }

    public function getSurveyDataByDate($tanggal_awal, $tanggal_akhir)
    {
        $this->db->select('tbl_survey.surveyor, tbl_user.nama_lengkap, COUNT(tbl_survey.id) as jumlah');
        $this->db->from('tbl_survey');
        $this->db->join('tbl_user', 'tbl_survey.surveyor = tbl_user.id_user');
        $this->db->where('tbl_survey.tgl_survey >=', $tanggal_awal);
        $this->db->where('tbl_survey.tgl_survey <=', $tanggal_akhir);
        $this->db->group_by('tbl_survey.surveyor');
        $query = $this->db->get();
        return $query->result_array(); // Mengembalikan data dalam bentuk array
    }

    public function getAnalisaDataByDate($tanggal_awal, $tanggal_akhir)
    {
        // Pilih analyst dan nama lengkap dari tbl_user, hitung jumlah yang memenuhi status_analisa = 1
        $this->db->select('tbl_survey.analyst, tbl_user.nama_lengkap, 
                           SUM(CASE WHEN tbl_survey.status_analisa = 1 THEN 1 ELSE NULL END) as jumlah');
        $this->db->from('tbl_survey');
        $this->db->join('tbl_user', 'tbl_survey.analyst = tbl_user.id_user');
        $this->db->where('tbl_survey.tgl_analisa >=', $tanggal_awal);
        $this->db->where('tbl_survey.tgl_analisa <=', $tanggal_akhir);
        $this->db->where('tbl_survey.status_analisa', 1); // Filter untuk hanya yang status_analisa = 1
        $this->db->group_by('tbl_survey.analyst');

        $query = $this->db->get();

        return $query->result_array(); // Mengembalikan data dalam bentuk array
    }

    public function get_data_usulan_by_date($tanggal_awal = null, $tanggal_akhir = null)
    {
        $this->db->select('
            COUNT(CASE WHEN status_survey = 1 THEN 1 END) as sudah_survey, 
            COUNT(CASE WHEN status_survey = 0 THEN 1 END) as belum_survey
        ');
        $this->db->from('tbl_usulan');
        
        // Filter berdasarkan tanggal jika diberikan
        if ($tanggal_awal && $tanggal_akhir) {
            $this->db->where('tanggal >=', $tanggal_awal);
            $this->db->where('tanggal <=', $tanggal_akhir);
        }
        
        // Tidak ada pengelompokkan berdasarkan status_survey
        // Hanya menghitung jumlah sudah_survey dan belum_survey secara total
        
        return $this->db->get()->row();  // Gunakan row() untuk mendapatkan hasil tunggal
    }    
    
    public function get_data_survey_by_date($tanggal_awal, $tanggal_akhir)
    {
        // Query untuk menghitung status analisa, hasil analisa, dan status komite
        $this->db->select("
            SUM(CASE WHEN status_analisa = 1 THEN 1 ELSE 0 END) AS sudah_analisa,
            SUM(CASE WHEN status_analisa = 0 THEN 1 ELSE 0 END) AS belum_analisa,
            SUM(CASE WHEN hasil_analisa = 0 OR hasil_analisa IS NULL THEN 1 ELSE 0 END) AS menunggu_komite,
            SUM(CASE WHEN hasil_analisa = 1 THEN 1 ELSE 0 END) AS tidak_rekomendasi,
            SUM(CASE WHEN hasil_analisa = 2 THEN 1 ELSE 0 END) AS pertimbangkan,
            SUM(CASE WHEN hasil_analisa = 3 THEN 1 ELSE 0 END) AS rekomendasi,
            SUM(CASE WHEN status_komite = 1 THEN 1 ELSE 0 END) AS acc,
            SUM(CASE WHEN status_komite = 2 THEN 1 ELSE 0 END) AS revisi,
            SUM(CASE WHEN status_komite = 3 THEN 1 ELSE 0 END) AS ditolak
        ");
        $this->db->from('tbl_survey');
        $this->db->where('tgl_survey >=', $tanggal_awal);
        $this->db->where('tgl_survey <=', $tanggal_akhir);

        $query = $this->db->get();
        return $query->row();
    }
    
}

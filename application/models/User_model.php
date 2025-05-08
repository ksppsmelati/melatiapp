<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    // Fungsi untuk memperbarui lokasi pengguna berdasarkan ID pengguna
    public function updateLocation($user_id, $latitude, $longitude)
    {
        // Gantilah 'nama_tabel' dengan nama tabel yang sesuai di database Anda
        $this->db->where('id_user', $user_id);
        $this->db->update('tbl_user', array(
            'latitude' => $latitude,
            'longitude' => $longitude
        ));
    }

    // Function to get online_status based on username
    public function getOnlineStatus($username)
    {
        $this->db->select('online_status');
        $this->db->where('username', $username);
        $query = $this->db->get('tbl_user');

        if ($query->num_rows() > 0) {
            return $query->row()->online_status;
        }

        return 'Offline'; // Mengembalikan 'Offline' jika data tidak ditemukan
    }

    public function updateLocUpdateTime($user_id, $loc_update_time)
    {
        // Gantilah 'nama_tabel' dengan nama tabel yang sesuai di database Anda
        $this->db->where('id_user', $user_id);
        $this->db->update('tbl_user', array('loc_update_time' => $loc_update_time));
    }

    // Fungsi untuk menyimpan device_info ke dalam database

    // Metode untuk memperbarui device info pengguna
    public function updateDeviceInfo($user_id, $device_info)
    {
        $this->db->where('id_user', $user_id);
        $this->db->update('tbl_user', array('device_info' => $device_info));
    }

    public function get_user_by_id($user_id)
    {
        $this->db->where('id_user', $user_id);
        $query = $this->db->get('tbl_user');

        if ($query->num_rows() > 0) {
            return $query->row();
        }

        return null; // Atau Anda bisa mengembalikan data default atau pesan kesalahan sesuai kebutuhan.
    }

    public function kurangi_sisa_cuti($id_user)
    {
        // Mengambil data user
        $this->db->where('id_user', $id_user);
        $user = $this->db->get('tbl_user')->row(); // Ganti 'users' dengan 'tbl_user'

        if ($user) {
            // Cek apakah sisa_cuti lebih dari 0
            if ($user->sisa_cuti > 0) {
                // Kurangi sisa cuti
                $new_sisa_cuti = $user->sisa_cuti - 1;

                // Memperbarui kolom sisa_cuti
                $this->db->set('sisa_cuti', $new_sisa_cuti);
                $this->db->where('id_user', $id_user);

                // Melakukan update dan mengembalikan status
                if ($this->db->update('tbl_user')) {
                    return true; // Pengurangan berhasil
                } else {
                    return false; // Gagal mengupdate
                }
            } else {
                // Sisa cuti sudah habis
                return false; // Atau bisa mengembalikan pesan khusus
            }
        }
        return false; // Jika user tidak ditemukan
    }

    public function getTabunganByNocif($id_user)
    {
        // Mengambil nocif pengguna dari tabel tbl_user
        $this->db->select('nocif');
        $this->db->from('tbl_user');
        $this->db->where('id_user', $id_user);
        $user = $this->db->get()->row();

        if (!$user) {
            return []; // Jika tidak ada pengguna, kembalikan array kosong
        }

        $nocif = $user->nocif;

        // Mengambil data tabungan berdasarkan nocif dengan join TOFTABQQ untuk namaqq
        $this->db->select('TOFTABC.notab, TOFTABC.kodeprd, TOFTABC.nocif, TOFTABC.sahirrp, TOFTABC.fnama, TOFTABQQ.namaqq');
        $this->db->from('TOFTABC');
        $this->db->join('TOFTABQQ', 'TOFTABC.notab = TOFTABQQ.notab', 'left'); // Left join TOFTABQQ berdasarkan notab
        $this->db->where('TOFTABC.nocif', $nocif);
        $this->db->where('TOFTABC.stsrec', 'A');
        $tabungan = $this->db->get()->result_array();

        return $tabungan;
    }

    public function getTabunganAllUser()
    {
        // Mengambil semua nocif pengguna dari tabel tbl_user
        $this->db->select('id_user, nocif');
        $this->db->from('tbl_user');
        $users = $this->db->get()->result_array();

        if (empty($users)) {
            return []; // Jika tidak ada pengguna, kembalikan array kosong
        }

        $result = [];
        foreach ($users as $user) {
            $nocif = $user['nocif'];

            // Mengambil data tabungan berdasarkan nocif dengan join TOFTABQQ untuk namaqq
            $this->db->select('TOFTABC.notab, TOFTABC.kodeprd, TOFTABC.nocif, TOFTABC.sahirrp, TOFTABC.fnama, TOFTABQQ.namaqq, tbl_user.id_user');
            $this->db->from('TOFTABC');
            $this->db->join('TOFTABQQ', 'TOFTABC.notab = TOFTABQQ.notab', 'left'); // Left join TOFTABQQ berdasarkan notab
            $this->db->join('tbl_user', 'tbl_user.nocif = TOFTABC.nocif'); // Join dengan tbl_user untuk mendapatkan id_user
            $this->db->where('TOFTABC.nocif', $nocif);
            $this->db->where('TOFTABC.stsrec', 'A');
            $tabungan = $this->db->get()->result_array();

            if (!empty($tabungan)) {
                // Tambahkan data tabungan ke dalam hasil
                foreach ($tabungan as $row) {
                    $result[] = $row;
                }
            }
        }

        return $result;
    }

    public function getPembiayaanByNocif($id_user)
    {
        // Mengambil nocif pengguna dari tabel tbl_user
        $this->db->select('nocif');
        $this->db->from('tbl_user');
        $this->db->where('id_user', $id_user);
        $user = $this->db->get()->row();

        if (!$user) {
            return []; // Jika tidak ada pengguna, kembalikan array kosong
        }

        $nocif = $user->nocif;

        // Mengambil data pembiayaan berdasarkan nocif dengan join TOFLMB
        $this->db->select('TOFLMB.nokontrak, TOFLMB.nama, TOFLMB.kdprd, TOFLMB.mdlawal');
        $this->db->from('TOFLMB');
        $this->db->where('TOFLMB.nocif', $nocif);
        $this->db->where('TOFLMB.stsrec', 'A'); // Sesuaikan dengan status aktif jika perlu
        $pembiayaan = $this->db->get()->result_array();

        return $pembiayaan;
    }

    public function get_transaction_history($notab, $start_date, $end_date)
    {
        // Query pertama (h_tabtrn)
        $this->db->select('h_tabtrn.tgltrn, h_tabtrn.trnke, h_tabtrn.nominal, h_tabtrn.ket, h_tabtrn.dc');
        $this->db->from('h_tabtrn');

        // Apply date range filter
        $this->db->where("h_tabtrn.tgltrn >=", $start_date);
        $this->db->where("h_tabtrn.tgltrn <=", $end_date);

        // Filter by noacc (same as notab)
        $this->db->where('h_tabtrn.noacc', $notab);

        // Filter by transaction status (5 or 6)
        $this->db->where_in('h_tabtrn.ststrn', ['5', '6']);

        // Urutkan berdasarkan trnkedr
        $this->db->order_by('h_tabtrn.trnke', 'ASC');

        $query1 = $this->db->get_compiled_select(); // Simpan query pertama

        // Query kedua (TOFTRNC)
        $this->db->select('TOFTRNC.tgltrn, TOFTRNC.trnkedr, TOFTRNC.nominalrp AS nominal, TOFTRNC.ket, TOFTRNC.dc');
        $this->db->from('TOFTRNC');

        // Apply date range filter
        $this->db->where("TOFTRNC.tgltrn >=", $start_date);
        $this->db->where("TOFTRNC.tgltrn <=", $end_date);

        // Filter berdasarkan kondisi dracc, cracc, atau noreff sama dengan notab
        $this->db->group_start();
        $this->db->where('TOFTRNC.dracc', $notab);
        $this->db->or_where('TOFTRNC.cracc', $notab);
        $this->db->or_where('TOFTRNC.noreff', $notab);
        $this->db->group_end();

        // Filter by transaction status (5 or 6)
        $this->db->where_in('TOFTRNC.ststrn', ['5', '6']);

        // Urutkan berdasarkan trnkedr
        $this->db->order_by('TOFTRNC.trnkedr', 'ASC');

        $query2 = $this->db->get_compiled_select(); // Simpan query kedua

        // Gabungkan kedua query dengan UNION ALL
        $final_query = "($query1) UNION ALL ($query2) ORDER BY tgltrn ASC, trnke ASC";

        // Jalankan query gabungan
        $query = $this->db->query($final_query);

        // Kembalikan hasil sebagai array
        return $query->result_array();
    }
}

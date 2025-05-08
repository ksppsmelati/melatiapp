<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mcrud extends CI_Model
{

	var $tbl_users				= 'tbl_user';
	var $tbl_bagian		 		= 'tbl_bagian';
	var $tbl_ns		 			= 'tbl_ns';
	var $tbl_sm		 			= 'tbl_sm';
	var $tbl_sk		 			= 'tbl_sk';
	var $tbl_memo	 			= 'tbl_memo';
	var $tbl_pengumuman	 		= 'tbl_pengumuman';
	var $tbl_absensi	 		= 'tbl_absensi';
	var $tbl_setting	 		= 'tbl_setting';

	//Sent mail
	public function sent_mail($username, $email, $aksi)
	{
		$email_saya = "";
		$pass_saya  = "";

		//konfigurasi email
		$config = array();
		$config['charset'] = 'utf-8';
		$config['useragent'] = 'jkp.ordodev.com';
		$config['protocol'] = "smtp";
		$config['mailtype'] = "html";
		$config['smtp_host'] = "ssl://smtp.gmail.com";
		$config['smtp_port'] = "465";
		$config['smtp_timeout'] = "465";
		$config['smtp_user'] = "$email_saya";
		$config['smtp_pass'] = "$pass_saya";
		$config['crlf'] = "\r\n";
		$config['newline'] = "\r\n";

		$config['wordwrap'] = TRUE;
		//memanggil library email dan set konfigurasi untuk pengiriman email

		$this->email->initialize($config);
		//$ipaddress = get_real_ip(); //untuk mendeteksi alamat IP

		date_default_timezone_set('Asia/Jakarta');
		$waktu 	  = date('Y-m-d H:i:s');
		$tgl 			= date('Y-m-d');

		$id = md5("$email * $tgl");

		if ($aksi == 'reg') {
			$link			= base_url() . 'web/verify';
			$pesan    = "Hello $username,
													<br /><br />
													Welcome to Jam Kerja Proyek!<br/>
													Untuk melengkapi pendaftaran Anda, silahkan klik link berikut<br/>
													<br /><br />
													<b><a href='$link/$id/$username'>Klik Aktivasi disini :)</a></b>
													<br /><br />
													Terimakasih ^_^,
													";
			$subject = 'Aktivasi Akun | JKP';
		} elseif ($aksi == 'lp') {
			$link			= base_url() . 'web/konfirm_pass';
			$pesan    = "Hello $username,
													<br /><br />
													Welcome to Jam Kerja Proyek!<br/>
													Untuk membuat password baru, silahkan klik link berikut<br/>
													<br /><br />
													<b><a href='$link/$id/$username'>Klik disini untuk merubah Password baru :)</a></b>
													<br /><br />
													Terimakasih ^_^,
													";
			$subject = 'Lupa Password | JKP';
		}

		$this->email->from("$email_saya");
		$this->email->to("$email");
		$this->email->subject($subject);
		$this->email->message($pesan);
	}
	//End Sent mail


	public function get_users()
	{
		$this->db->from($this->tbl_users);
		$query = $this->db->get();

		return $query;
	}

	public function get_users_daftar()
	{
		$this->db->from($this->tbl_users);
		$this->db->where('status', 'terdaftar');
		$query = $this->db->get();

		return $query;
	}

	public function get_level_users()
	{
		$this->db->from($this->tbl_users);
		// $this->db->where('tbl_user.level', 'user');
		$query = $this->db->get();

		return $query;
	}

	public function get_users_by_un($id)
	{
		$this->db->from($this->tbl_users);
		$this->db->where('username', $id);
		$query = $this->db->get();

		return $query;
	}

	public function get_level_users_by_id($id)
	{
		$this->db->from($this->tbl_users);
		$this->db->where('tbl_user.level', 'user');
		$this->db->where('tbl_user.id_user', $id);
		$query = $this->db->get();

		return $query->row();
	}

	public function save_user($data)
	{
		$this->db->insert($this->tbl_users, $data);
		return $this->db->insert_id();
	}

	public function update_user($where, $data)
	{
		$this->db->update($this->tbl_users, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_user_by_id($id)
	{
		$this->db->where('id_user', $id);
		$this->db->delete($this->tbl_users);
	}


	public function save_bagian($data)
	{
		$this->db->insert($this->tbl_bagian, $data);
		return $this->db->insert_id();
	}

	public function update_bagian($where, $data)
	{
		$this->db->update($this->tbl_bagian, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_bagian_by_id($id)
	{
		$this->db->where('id_bagian', $id);
		$this->db->delete($this->tbl_bagian);
	}

	public function save_ns($data)
	{
		$this->db->insert($this->tbl_ns, $data);
		return $this->db->insert_id();
	}

	public function update_ns($where, $data)
	{
		$this->db->update($this->tbl_ns, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_ns_by_id($id)
	{
		$this->db->where('id_ns', $id);
		$this->db->delete($this->tbl_ns);
	}

	public function is_username_exists($username)
	{
		$this->db->where('username', $username);
		$query = $this->db->get('tbl_user'); // Sesuaikan dengan nama tabel Anda

		return ($query->num_rows() > 0);
	}

	// get data dropdown
	function data_ns($aksi = '', $id = '')
	{
		// ambil data dari db
		if ($aksi != 'semua') {
			$this->db->where('jenis_ns', $aksi);
		}
		// $this->db->where('id_user', $id);
		$this->db->order_by('no_surat', 'asc');
		$query = $this->db->get('tbl_ns')->result();

		return $query;
	}

	public function get_surat_masuk_by_filter($tanggal = '', $nama_anggota = '', $order_by = 'tgl_sm_date', $order_type = 'desc')
	{
		// Memilih tabel utama
		$this->db->from('tbl_sm');

		// Menambahkan kondisi WHERE berdasarkan tanggal jika disediakan
		if (!empty($tanggal)) {
			$this->db->where('tgl_sm_date', $tanggal);
		}

		// Menambahkan kondisi WHERE berdasarkan nama anggota jika disediakan
		if (!empty($nama_anggota)) {
			$this->db->like('nama_anggota', $nama_anggota);
		}

		// Mengatur urutan berdasarkan kolom yang ditentukan dan tipe urutan yang ditentukan
		$this->db->order_by($order_by, $order_type);

		// Mengambil data dan mengembalikannya sebagai objek hasil query
		return $this->db->get();
	}


	public function save_sm($data)
	{
		$this->db->insert($this->tbl_sm, $data);
		return $this->db->insert_id();
	}

	public function update_sm($where, $data)
	{
		$this->db->update($this->tbl_sm, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_sm_by_id($id)
	{
		$this->db->where('id_sm', $id);
		$this->db->delete($this->tbl_sm);
	}


	public function delete_lampiran($id)
	{
		$this->db->where('token_lampiran', $id);
		$this->db->delete('tbl_lampiran');
	}


	public function save_sk($data)
	{
		$this->db->insert($this->tbl_sk, $data);
		return $this->db->insert_id();
	}

	public function update_sk($where, $data)
	{
		$this->db->update($this->tbl_sk, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_sk_by_id($id)
	{
		$this->db->where('id_sk', $id);
		$this->db->delete($this->tbl_sk);
	}

	public function save_memo($data)
	{
		$this->db->insert($this->tbl_memo, $data);
		return $this->db->insert_id();
	}

	public function update_memo($where, $data)
	{
		$this->db->update($this->tbl_memo, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_memo_by_id($id)
	{
		$this->db->where('id_memo', $id);
		$this->db->delete($this->tbl_memo);
	}

	public function get_memo_by_id($id)
	{
		$this->db->select('tbl_memo.*, tbl_user.nama_lengkap');
		$this->db->from('tbl_memo');
		$this->db->join('tbl_user', 'tbl_user.id_user = tbl_memo.id_user', 'left');
		$this->db->where('tbl_memo.id_memo', $id);
		return $this->db->get()->row();
	}


	public function save_pengumuman($data)
	{
		$this->db->insert($this->tbl_pengumuman, $data);
		return $this->db->insert_id();
	}

	public function update_pengumuman($where, $data)
	{
		$this->db->update($this->tbl_pengumuman, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_pengumuman_by_id($id)
	{
		$this->db->where('id_pengumuman', $id);
		$this->db->delete($this->tbl_pengumuman);
	}

	public function get_pengumuman_by_id($id)
	{
		$this->db->where('id_pengumuman', $id);
		return $this->db->get($this->tbl_pengumuman)->row();
	}
	public function get_all_users()
	{
		$query = $this->db->get('tbl_user'); // Gantilah 'tbl_user' dengan nama tabel yang sesuai
		return $query->result_array();
	}

	public function get_all_users_aktif()
	{
		$this->db->where('status', 'aktif'); // Filter berdasarkan status yang 'aktif'
		$this->db->where('id_user !=', 0);
		$this->db->order_by('tgl_daftar', 'ASC');
		$query = $this->db->get('tbl_user'); // Gantilah 'tbl_user' dengan nama tabel yang sesuai
		return $query->result_array();
	}

	public function get_all_users_aktif_except($id_user)
	{
		$this->db->where('status', 'aktif'); // Filter based on 'aktif' status
		$this->db->where('id_user !=', $id_user); // Exclude the specified user ID
		$this->db->where('id_user !=', 0); // Avoid user ID with value 0
		$this->db->order_by('tgl_daftar', 'ASC'); // Sort by registration date
		$query = $this->db->get('tbl_user'); // Replace 'tbl_user' with the appropriate table name

		return $query->result(); // Return results as objects, not arrays
	}

	public function get_all_users_tgl_daftar()
	{
		$this->db->where('id_user !=', 0); // Memfilter id_user yang tidak sama dengan 0
		$this->db->order_by('tgl_daftar', 'ASC'); // Mengurutkan berdasarkan tanggal_daftar secara menaik
		$this->db->where('status', 'aktif');
		$this->db->where('level !=', 'satpam');
		$query = $this->db->get('tbl_user');
		return $query->result_array(); // Mengembalikan hasil dalam bentuk array
	}

	public function get_all_users_tgl_daftar_by_id_user($id_user)
	{
		$this->db->where('id_user', $id_user);
		$this->db->order_by('tgl_daftar', 'ASC'); // Mengurutkan berdasarkan tanggal_daftar secara menaik
		$this->db->where('status', 'aktif');
		$this->db->where('level !=', 'satpam');
		$query = $this->db->get('tbl_user');
		return $query->result_array(); // Mengembalikan hasil dalam bentuk array
	}

	public function get_all_users_tgl_daftar_manual()
	{
		$this->db->where('id_user !=', 0); // Memfilter id_user yang tidak sama dengan 0
		$this->db->order_by('tgl_daftar', 'ASC'); // Mengurutkan berdasarkan tanggal_daftar secara menaik
		$this->db->where('status', 'aktif');
		$this->db->where('level =', 'satpam');
		$query = $this->db->get('tbl_user');
		return $query->result_array(); // Mengembalikan hasil dalam bentuk array
	}

	// Get all settings
	public function get_all_settings()
	{
		$query = $this->db->get($this->tbl_setting);
		return $query->result();
	}

	// Get setting by key
	public function get_setting_by_key($key)
	{
		$this->db->from($this->tbl_setting);
		$this->db->where('key', $key);
		$query = $this->db->get();

		// Return value if exists
		if ($query->num_rows() > 0) {
			return $query->row()->value; // Mengambil nilai dari kolom 'value'
		}
		return null; // Jika tidak ditemukan
	}

	// Save new setting
	public function save_setting($data)
	{
		$this->db->insert($this->tbl_setting, $data);
		return $this->db->insert_id();
	}

	// Update setting by key
	public function update_setting($key, $data)
	{
		$this->db->where('key', $key);
		$this->db->update($this->tbl_setting, $data);
		return $this->db->affected_rows();
	}

	// Delete setting by key
	public function delete_setting_by_key($key)
	{
		$this->db->where('key', $key);
		$this->db->delete($this->tbl_setting);
	}

	// Get setting by value keyword
	public function get_setting_by_value_keyword($keyword)
	{
		$this->db->from($this->tbl_setting);
		$this->db->like('value', $keyword);
		$query = $this->db->get();

		return $query->result(); // Mengambil beberapa baris hasil
	}
}

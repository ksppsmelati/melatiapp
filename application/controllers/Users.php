<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;

class Users extends CI_Controller
{
	// start load helper absensi
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		// Muat helper 'Tanggal' dan 'Check_absen'
		$this->load->model('Absensi_model', 'absensi');
		$this->load->model('Jam_model', 'jam');
		$this->load->model('info_model');
		$this->load->model('Pengumuman_model');
		$this->load->model('Edit_absen_model');
		$this->load->model('Edit_absen_model_manual');
		$this->load->model('Profile_model');
		$this->load->model('User_model');
		$this->load->model('Story_model');
		$this->load->helper('Tanggal');
		$this->load->helper('Check_absen');
		$this->load->helper('file');
	}
	public function index()
	{

		$ceks = $this->session->userdata('user@mt');
		$id_user = $this->session->userdata('id_user@mt');
		// tambahan untuk menampilkan absensi
		$this->load->model('Absensi_model');
		$this->load->model('User_model');
		$this->load->model('Menu_model');
		$this->load->model('Imsakiyah_model');

		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['users'] = $this->Mcrud->get_users();
			$data['judul_web'] = "Beranda | MelatiApp ";

			$data['logo'] = $this->Mcrud->get_setting_by_key('logo');
			$data['status_app'] = $this->Mcrud->get_setting_by_key('status_app');
			$data['greeting'] = $this->Mcrud->get_setting_by_key('greeting');
			// tambahan untuk menampilkan absensi
			$data['absen_harian'] = $this->Absensi_model->absen_harian_user($id_user);

			$data['pengumuman'] = $this->Pengumuman_model->getPengumuman();
			$this->db->join('tbl_user', 'tbl_memo.id_user=tbl_user.id_user');
			$this->db->order_by('tbl_memo.judul_memo', 'DESC');
			$data['memo'] = $this->db->get("tbl_memo");
			$data['menu_category'] = $this->Menu_model->get_user_accessible_menus($id_user);
			$data['menus'] = $this->Menu_model->get_user_accessible_menus_umum();
			$data['menu_alat'] = $this->Menu_model->get_user_accessible_menus_alat();
			$data['menu_keuangan'] = $this->Menu_model->get_user_accessible_menus_keuangan();
			$data['menu_lainnya'] = $this->Menu_model->get_user_accessible_menus_lainnya();

			$data['info_1'] = $this->info_model->getInfo1();
			$data['info_2'] = $this->info_model->getInfo2();
			$data['info_3'] = $this->info_model->getInfo3();
			$data['info_4'] = $this->info_model->getInfo4();
			$data['info_5'] = $this->info_model->getInfo5();
			$data['info_6'] = $this->info_model->getInfo6();
			$data['info_7'] = $this->info_model->getInfo7();
			$data['info_8'] = $this->info_model->getInfo8();
			$data['info_9'] = $this->info_model->getInfo9();
			$data['info_10'] = $this->info_model->getInfo10();
			$data['info_11'] = $this->info_model->getInfo11();
			$data['info_12'] = $this->info_model->getInfo12();
			$data['info_13'] = $this->info_model->getInfo13();
			$data['info_14'] = $this->info_model->getInfo14();
			$data['info_15'] = $this->info_model->getInfo15();
			$data['info_16'] = $this->info_model->getInfo16();
			$data['info_17'] = $this->info_model->getInfo17();
			$data['info_18'] = $this->info_model->getInfo18();
			$data['info_19'] = $this->info_model->getInfo19();
			$data['info_20'] = $this->info_model->getInfo20();

			$baghas1 = $data['info_5'];
			$baghas2 = $data['info_6'];
			$baghas3 = $data['info_7'];
			$baghas4 = $data['info_8'];
			$baghas5 = $data['info_15'];

			// Gunakan data info untuk simulasi
			$nisbah_anggota_1_bulan = $data['info_1'];
			$nisbah_anggota_3_bulan = $data['info_2']; // Sesuaikan dengan info_2
			$nisbah_anggota_6_bulan = $data['info_3']; // Sesuaikan dengan info_3
			$nisbah_anggota_12_bulan = $data['info_4']; // Sesuaikan dengan info_4
			$nisbah_anggota_9_bulan = $data['info_14'];

			$nisbah_kspps_melati_1_bulan = 100 - $nisbah_anggota_1_bulan;
			$nisbah_kspps_melati_3_bulan = 100 - $nisbah_anggota_3_bulan;
			$nisbah_kspps_melati_6_bulan = 100 - $nisbah_anggota_6_bulan;
			$nisbah_kspps_melati_12_bulan = 100 - $nisbah_anggota_12_bulan;
			$nisbah_kspps_melati_9_bulan = 100 - $nisbah_anggota_9_bulan;

			$bagi_hasil_1_bulan = $baghas1;
			$bagi_hasil_3_bulan = $baghas2;
			$bagi_hasil_6_bulan = $baghas3;
			$bagi_hasil_12_bulan = $baghas4;
			$bagi_hasil_9_bulan = $baghas5;

			$simulations = array(
				array('Jangka waktu' => '1 Bulan', 'Nisbah Anggota' => $nisbah_anggota_1_bulan, 'Nisbah KSPPS MELATI' => $nisbah_kspps_melati_1_bulan, 'Bagi Hasil' => $bagi_hasil_1_bulan),
				array('Jangka waktu' => '3 Bulan', 'Nisbah Anggota' => $nisbah_anggota_3_bulan, 'Nisbah KSPPS MELATI' => $nisbah_kspps_melati_3_bulan, 'Bagi Hasil' => $bagi_hasil_3_bulan),
				array('Jangka waktu' => '6 Bulan', 'Nisbah Anggota' => $nisbah_anggota_6_bulan, 'Nisbah KSPPS MELATI' => $nisbah_kspps_melati_6_bulan, 'Bagi Hasil' => $bagi_hasil_6_bulan),
				array('Jangka waktu' => '9 Bulan', 'Nisbah Anggota' => $nisbah_anggota_9_bulan, 'Nisbah KSPPS MELATI' => $nisbah_kspps_melati_9_bulan, 'Bagi Hasil' => $bagi_hasil_9_bulan),
				array('Jangka waktu' => '12 Bulan', 'Nisbah Anggota' => $nisbah_anggota_12_bulan, 'Nisbah KSPPS MELATI' => $nisbah_kspps_melati_12_bulan, 'Bagi Hasil' => $bagi_hasil_12_bulan),
			);
			// Tambahkan data simulasi ke dalam array $data
			$data['simulations'] = $simulations;

			$data['tabungan'] = $this->User_model->getTabunganByNocif($id_user);
			$data['imsakiyah'] = $this->Imsakiyah_model->get_today_imsakiyah();

			// Perbarui device info pengguna ke dalam database
			$device_info = $this->input->post('device_info'); // Ambil device info dari input tersembunyi
			if ($device_info) {
				$this->User_model->updateDeviceInfo($id_user, $device_info);
			}

			// Ambil foto banner terakhir dari database
			$query = $this->db->query("SELECT foto_banner FROM tbl_banner ORDER BY id DESC LIMIT 1");
			if ($query->num_rows() > 0) {
				$row = $query->row();
				$data['foto_banner'] = $row->foto_banner;
			} else {
				$data['foto_banner'] = ''; // Jika tidak ada data, gunakan default atau kosongkan
			}

			$this->load->view('users/header', $data);
			$this->load->view('users/beranda', $data);
			$this->load->view('users/footer');
		}
	}

	public function index_update()
	{

		$ceks = $this->session->userdata('user@mt');
		$id_user = $this->session->userdata('id_user@mt');
		// tambahan untuk menampilkan absensi
		$this->load->model('Absensi_model');
		$this->load->model('User_model');
		$this->load->model('Menu_model');
		$this->load->model('Imsakiyah_model');

		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['users'] = $this->Mcrud->get_users();
			$data['judul_web'] = "Beranda | MelatiApp ";

			$data['logo'] = $this->Mcrud->get_setting_by_key('logo');
			$data['status_app'] = $this->Mcrud->get_setting_by_key('status_app');
			$data['greeting'] = $this->Mcrud->get_setting_by_key('greeting');
			// tambahan untuk menampilkan absensi
			$data['absen_harian'] = $this->Absensi_model->absen_harian_user($id_user);

			$data['pengumuman'] = $this->Pengumuman_model->getPengumuman();
			$this->db->join('tbl_user', 'tbl_memo.id_user=tbl_user.id_user');
			$this->db->order_by('tbl_memo.judul_memo', 'DESC');
			$data['memo'] = $this->db->get("tbl_memo");
			$data['menu_category'] = $this->Menu_model->get_user_accessible_menus($id_user);
			$data['menus'] = $this->Menu_model->get_user_accessible_menus_umum();
			$data['menu_alat'] = $this->Menu_model->get_user_accessible_menus_alat();
			$data['menu_keuangan'] = $this->Menu_model->get_user_accessible_menus_keuangan();
			$data['menu_lainnya'] = $this->Menu_model->get_user_accessible_menus_lainnya();

			$data['info_1'] = $this->info_model->getInfo1();
			$data['info_2'] = $this->info_model->getInfo2();
			$data['info_3'] = $this->info_model->getInfo3();
			$data['info_4'] = $this->info_model->getInfo4();
			$data['info_5'] = $this->info_model->getInfo5();
			$data['info_6'] = $this->info_model->getInfo6();
			$data['info_7'] = $this->info_model->getInfo7();
			$data['info_8'] = $this->info_model->getInfo8();
			$data['info_9'] = $this->info_model->getInfo9();
			$data['info_10'] = $this->info_model->getInfo10();
			$data['info_11'] = $this->info_model->getInfo11();
			$data['info_12'] = $this->info_model->getInfo12();
			$data['info_13'] = $this->info_model->getInfo13();
			$data['info_14'] = $this->info_model->getInfo14();
			$data['info_15'] = $this->info_model->getInfo15();
			$data['info_16'] = $this->info_model->getInfo16();
			$data['info_17'] = $this->info_model->getInfo17();
			$data['info_18'] = $this->info_model->getInfo18();
			$data['info_19'] = $this->info_model->getInfo19();
			$data['info_20'] = $this->info_model->getInfo20();

			$baghas1 = $data['info_5'];
			$baghas2 = $data['info_6'];
			$baghas3 = $data['info_7'];
			$baghas4 = $data['info_8'];
			$baghas5 = $data['info_15'];

			// Gunakan data info untuk simulasi
			$nisbah_anggota_1_bulan = $data['info_1'];
			$nisbah_anggota_3_bulan = $data['info_2']; // Sesuaikan dengan info_2
			$nisbah_anggota_6_bulan = $data['info_3']; // Sesuaikan dengan info_3
			$nisbah_anggota_12_bulan = $data['info_4']; // Sesuaikan dengan info_4
			$nisbah_anggota_9_bulan = $data['info_14'];

			$nisbah_kspps_melati_1_bulan = 100 - $nisbah_anggota_1_bulan;
			$nisbah_kspps_melati_3_bulan = 100 - $nisbah_anggota_3_bulan;
			$nisbah_kspps_melati_6_bulan = 100 - $nisbah_anggota_6_bulan;
			$nisbah_kspps_melati_12_bulan = 100 - $nisbah_anggota_12_bulan;
			$nisbah_kspps_melati_9_bulan = 100 - $nisbah_anggota_9_bulan;

			$bagi_hasil_1_bulan = $baghas1;
			$bagi_hasil_3_bulan = $baghas2;
			$bagi_hasil_6_bulan = $baghas3;
			$bagi_hasil_12_bulan = $baghas4;
			$bagi_hasil_9_bulan = $baghas5;

			$simulations = array(
				array('Jangka waktu' => '1 Bulan', 'Nisbah Anggota' => $nisbah_anggota_1_bulan, 'Nisbah KSPPS MELATI' => $nisbah_kspps_melati_1_bulan, 'Bagi Hasil' => $bagi_hasil_1_bulan),
				array('Jangka waktu' => '3 Bulan', 'Nisbah Anggota' => $nisbah_anggota_3_bulan, 'Nisbah KSPPS MELATI' => $nisbah_kspps_melati_3_bulan, 'Bagi Hasil' => $bagi_hasil_3_bulan),
				array('Jangka waktu' => '6 Bulan', 'Nisbah Anggota' => $nisbah_anggota_6_bulan, 'Nisbah KSPPS MELATI' => $nisbah_kspps_melati_6_bulan, 'Bagi Hasil' => $bagi_hasil_6_bulan),
				array('Jangka waktu' => '9 Bulan', 'Nisbah Anggota' => $nisbah_anggota_9_bulan, 'Nisbah KSPPS MELATI' => $nisbah_kspps_melati_9_bulan, 'Bagi Hasil' => $bagi_hasil_9_bulan),
				array('Jangka waktu' => '12 Bulan', 'Nisbah Anggota' => $nisbah_anggota_12_bulan, 'Nisbah KSPPS MELATI' => $nisbah_kspps_melati_12_bulan, 'Bagi Hasil' => $bagi_hasil_12_bulan),
			);
			// Tambahkan data simulasi ke dalam array $data
			$data['simulations'] = $simulations;

			$data['tabungan'] = $this->User_model->getTabunganByNocif($id_user);
			$data['imsakiyah'] = $this->Imsakiyah_model->get_today_imsakiyah();

			// Perbarui device info pengguna ke dalam database
			$device_info = $this->input->post('device_info'); // Ambil device info dari input tersembunyi
			if ($device_info) {
				$this->User_model->updateDeviceInfo($id_user, $device_info);
			}

			// Ambil foto banner terakhir dari database
			$query = $this->db->query("SELECT foto_banner FROM tbl_banner ORDER BY id DESC LIMIT 1");
			if ($query->num_rows() > 0) {
				$row = $query->row();
				$data['foto_banner'] = $row->foto_banner;
			} else {
				$data['foto_banner'] = ''; // Jika tidak ada data, gunakan default atau kosongkan
			}

			$this->load->view('users/header', $data);
			$this->load->view('users/beranda_update', $data);
			$this->load->view('users/footer');
		}
	}

	public function profile()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['level_users'] = $this->Mcrud->get_level_users();
			$data['judul_web'] = "Profile | Melati-App";
			$id_user = $this->session->userdata('id_user');

			$data['application_version'] = $this->Mcrud->get_setting_by_key('application_version');
			$data['tabungan'] = $this->User_model->getTabunganByNocif($id_user);
			$data['pembiayaan'] = $this->User_model->getPembiayaanByNocif($id_user);

			$this->load->view('users/header', $data);
			$this->load->view('users/profile', $data);
			$this->load->view('users/footer');

			if (isset($_POST['btnupdate'])) {
				$username = htmlentities(strip_tags($this->input->post('username')));
				$nama_lengkap = htmlentities(strip_tags($this->input->post('nama_lengkap')));
				// $status	 	= htmlentities(strip_tags($this->input->post('status')));
				$email = htmlentities(strip_tags($this->input->post('email')));
				// $kode_kantor	 				= htmlentities(strip_tags($this->input->post('kode_kantor')));
				// $kode_devisi	 				= htmlentities(strip_tags($this->input->post('kode_devisi')));
				$alamat = htmlentities(strip_tags($this->input->post('alamat')));
				$telp = htmlentities(strip_tags($this->input->post('telp')));
				$nomor_rekening = htmlentities(strip_tags($this->input->post('nomor_rekening')));
				$pengalaman = htmlentities(strip_tags($this->input->post('pengalaman')));
				// $level	 				= htmlentities(strip_tags($this->input->post('level')));

				$data = array(
					'username' => $username,
					'nama_lengkap' => $nama_lengkap,
					// 'status' => $status,
					'email' => $email,
					// 'level'			 	 => $level,
					// 'kode_kantor'				=> $kode_kantor,
					// 'kode_devisi'				=> $kode_devisi,
					'alamat' => $alamat,
					'telp' => $telp,
					'nomor_rekening' => $nomor_rekening,
					'pengalaman' => $pengalaman
				);
				$this->Mcrud->update_user(array('username' => $ceks), $data);
				$this->session->set_userdata('user@mt', $username);

				$this->session->set_flashdata(
					'msg',
					'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Profile berhasil disimpan.
										</div>'
				);
				redirect('users/profile');
			}


			if (isset($_POST['btnupdate2'])) {
				$password = htmlentities(strip_tags($this->input->post('password')));
				$password2 = htmlentities(strip_tags($this->input->post('password2')));

				if ($password != $password2) {
					$this->session->set_flashdata(
						'msg2',
						'
									<div class="alert alert-warning alert-dismissible" role="alert">
										 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
											 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
										 </button>
										 <strong>Gagal!</strong> PIN tidak cocok.
									</div>'
					);
				} else {
					$data = array(
						'password' => md5($password)
					);
					$this->Mcrud->update_user(array('username' => $ceks), $data);

					$this->session->set_flashdata(
						'msg2',
						'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> PIN berhasil disimpan.
										</div>'
					);
				}
				redirect('users/profile');
			}
		}
	}

	public function profile_edit_photo()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Edit Photo Profile | Melati-App";

			$this->load->view('users/header', $data);
			$this->load->view('users/profile/profile_edit_photo', $data);
			$this->load->view('users/footer');
		}
	}

	public function update_foto_profile()
	{
		// Periksa apakah pengguna sudah login (sesi ada)
		if (!$this->session->userdata('username')) {
			// Jika tidak ada sesi, alihkan pengguna ke halaman login
			redirect('web/login'); // Ubah URL sesuai dengan alamat halaman login Anda
		}

		$id_user = $this->session->userdata('id_user');

		// Check if a file is selected
		if (!empty($_FILES['foto_profile']['name'])) {
			// Konfigurasi pengaturan upload gambar
			$config['upload_path'] = './foto/foto_profile/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif';
			$config['max_size'] = 2048; // 2MB

			// Inisialisasi perpustakaan upload dengan konfigurasi
			$this->upload->initialize($config);

			// Check if the file is successfully uploaded
			if (!$this->upload->do_upload('foto_profile')) {
			}

			// Get the uploaded file data
			$upload_data = $this->upload->data();
			$foto_path = $upload_data['file_name'];
			$data['id_user'] = $id_user;
			$data['foto_profile'] = $foto_path;

			$this->load->model('Profile_model');
			$this->Profile_model->update_foto_profile($id_user, $data);
		}
		// $this->db->insert('tbl_user', $data);
		redirect('users/profile');
	}

	public function update_foto_profile_by_sys()
	{
		// Periksa apakah pengguna sudah login (sesi ada)
		if (!$this->session->userdata('username')) {
			// Jika tidak ada sesi, alihkan pengguna ke halaman login
			redirect('web/login'); // Ubah URL sesuai dengan alamat halaman login Anda
		}

		$id_user = $this->input->post('id_user');

		// Check if a file is selected
		if (!empty($_FILES['foto_profile']['name'])) {
			// Konfigurasi pengaturan upload gambar
			$config['upload_path'] = './foto/foto_profile/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif';
			$config['max_size'] = 2048; // 2MB

			// Inisialisasi perpustakaan upload dengan konfigurasi
			$this->upload->initialize($config);

			// Check if the file is successfully uploaded
			if (!$this->upload->do_upload('foto_profile')) {
			}

			// Get the uploaded file data
			$upload_data = $this->upload->data();
			$foto_path = $upload_data['file_name'];
			$data['id_user'] = $id_user;
			$data['foto_profile'] = $foto_path;

			$this->load->model('Profile_model');
			$this->Profile_model->update_foto_profile($id_user, $data);
		}
		// $this->db->insert('tbl_user', $data);
	}

	public function profile_data($id_user)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Profile_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Profile | Melati-App";
			$data['users'] = $this->Profile_model->get_user_by_id($id_user);

			$this->load->view('users/header', $data);
			$this->load->view('users/profile/profile_data', $data);
			$this->load->view('users/footer');
		}
	}

	public function pengguna($aksi = '', $id = '')
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);

			if ($data['user']->row()->level == 'admin' or $data['user']->row()->level == 'user') {
				redirect('404_content');
			}

			$this->db->order_by('id_user', 'DESC');
			$data['level_users'] = $this->Mcrud->get_level_users();

			if ($aksi == 't') {
				$p = "pengguna_tambah";

				$data['judul_web'] = "Tambah Pengguna | Melati-App";
			} elseif ($aksi == 'd') {
				$p = "pengguna_detail";

				$data['query'] = $this->db->get_where("tbl_user", "id_user = '$id'")->row();
				$data['judul_web'] = "Detail Pengguna | Melati-App";
			} elseif ($aksi == 'e') {
				$p = "pengguna_edit";

				$data['query'] = $this->db->get_where("tbl_user", "id_user = '$id'")->row();
				$data['judul_web'] = "Edit Pengguna | Melati-App";
			} elseif ($aksi == 'h') {

				$data['query'] = $this->db->get_where("tbl_user", "id_user = '$id'")->row();
				$data['judul_web'] = "Hapus Pengguna | Melati-App";

				if ($ceks == $data['query']->username) {
					$this->session->set_flashdata(
						'msg',
						'
							<div class="alert alert-warning alert-dismissible" role="alert">
								 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
									 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
								 </button>
								 <strong>Gagal!</strong> Maaf, Anda tidak bisa menghapus Nama Pengguna "' . $ceks . '" ini.
							</div>'
					);
				} else {
					$this->Mcrud->delete_user_by_id($id);
					$this->session->set_flashdata(
						'msg',
						'
							<div class="alert alert-success alert-dismissible" role="alert">
								 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
									 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
								 </button>
								 <strong>Sukses!</strong> Pengguna berhasil dihapus.
							</div>'
					);
				}
				redirect('users/pengguna');
			} else {
				$p = "pengguna";

				$data['judul_web'] = "Pengguna | Melati-App";
			}

			$this->load->view('users/header', $data);
			$this->load->view("users/pengaturan/$p", $data);
			$this->load->view('users/footer');

			date_default_timezone_set('Asia/Jakarta');
			$tgl = date('d-m-Y H:i:s');
			// TAMBAH USER
			if (isset($_POST['btnsimpan'])) {
				$username = htmlentities(strip_tags($this->input->post('username')));
				$nama_lengkap = htmlentities(strip_tags($this->input->post('nama_lengkap')));
				$status = htmlentities(strip_tags($this->input->post('status')));
				$nomor_rekening = htmlentities(strip_tags($this->input->post('nomor_rekening')));
				$email = htmlentities(strip_tags($this->input->post('email')));
				$kode_kantor = htmlentities(strip_tags($this->input->post('kode_kantor')));
				$kode_devisi = htmlentities(strip_tags($this->input->post('kode_devisi')));
				$password = htmlentities(strip_tags($this->input->post('password')));
				$password2 = htmlentities(strip_tags($this->input->post('password2')));
				$level = htmlentities(strip_tags($this->input->post('level')));

				$cek_user = $this->db->get_where("tbl_user", "username = '$username'")->num_rows();
				if ($cek_user != 0) {
					$this->session->set_flashdata(
						'msg',
						'
									<div class="alert alert-warning alert-dismissible" role="alert">
										 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
											 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
										 </button>
										 <strong>Gagal!</strong> Nama Pengguna "' . $username . '" Sudah ada.
									</div>'
					);
				} else {
					if ($password != $password2) {
						$this->session->set_flashdata(
							'msg',
							'
											<div class="alert alert-warning alert-dismissible" role="alert">
												 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
													 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
												 </button>
												 <strong>Gagal!</strong> Katasandi tidak cocok.
											</div>'
						);
					} else {
						$data = array(
							'username' => $username,
							'nama_lengkap' => $nama_lengkap,
							'password' => md5($password),
							'email' => $email,
							'kode_kantor' => $kode_kantor,
							'kode_devisi' => $kode_devisi,
							'alamat' => '-',
							'telp' => '-',
							'nomor_rekening' => $nomor_rekening,
							'pengalaman' => '-',
							'status' => $status,
							'level' => $level,
							'tgl_daftar' => $tgl
						);
						$this->Mcrud->save_user($data);

						$this->session->set_flashdata(
							'msg',
							'
											<div class="alert alert-success alert-dismissible" role="alert">
												 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
													 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
												 </button>
												 <strong>Sukses!</strong> Pengguna berhasil ditambahkan.
											</div>'
						);
					}
				}

				redirect('users/pengguna/t');
			}
			// UPDATE USER
			if (isset($_POST['btnupdate'])) {
				$username = htmlentities(strip_tags($this->input->post('username')));
				$nama_lengkap = htmlentities(strip_tags($this->input->post('nama_lengkap')));
				$nocif = htmlentities(strip_tags($this->input->post('nocif')));
				$status = htmlentities(strip_tags($this->input->post('status')));
				$email = htmlentities(strip_tags($this->input->post('email')));
				$alamat = htmlentities(strip_tags($this->input->post('alamat')));
				$telp = htmlentities(strip_tags($this->input->post('telp')));
				$nomor_rekening = htmlentities(strip_tags($this->input->post('nomor_rekening')));
				$pengalaman = htmlentities(strip_tags($this->input->post('pengalaman')));
				$level = htmlentities(strip_tags($this->input->post('level')));
				$kode_kantor = htmlentities(strip_tags($this->input->post('kode_kantor')));
				$kode_devisi = htmlentities(strip_tags($this->input->post('kode_devisi')));
				$kode_atasan = htmlentities(strip_tags($this->input->post('kode_atasan')));
				$custom_menu = $this->input->post('custom_menu');
				$device_reg = $this->input->post('device_reg');
				$device_info = $this->input->post('device_info');


				$data = array(
					'username' => $username,
					'nama_lengkap' => $nama_lengkap,
					'nocif' => $nocif,
					'email' => $email,
					'alamat' => $alamat,
					'telp' => $telp,
					'nomor_rekening' => $nomor_rekening,
					'pengalaman' => $pengalaman,
					'status' => $status,
					'level' => $level,
					'kode_kantor' => $kode_kantor,
					'kode_devisi' => $kode_devisi,
					'kode_atasan' => $kode_atasan,
					'custom_menu' => $custom_menu,
					'device_reg' => $device_reg,
					'device_info' => $device_info,

				);
				$this->Mcrud->update_user(array('id_user' => $id), $data);

				$this->session->set_flashdata(
					'msg',
					'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Pengguna berhasil diupdate.
										</div>'
				);
				redirect('users/pengguna');
			}
		}
	}

	public function sdi($aksi = '', $id = '')
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);

			if ($data['user']->row()->level == 'admin') {
				redirect('404_content');
			}

			$this->db->order_by('id_user', 'DESC');
			$data['level_users'] = $this->Mcrud->get_level_users();

			foreach ($data['level_users']->result() as $baris) {
				$tgl_masuk = strtotime($baris->tgl_daftar);
				$current_date = time();
				$time_difference = $current_date - $tgl_masuk;
				$years = floor($time_difference / (365 * 24 * 60 * 60));
				$months = floor(($time_difference % (365 * 24 * 60 * 60)) / (30 * 24 * 60 * 60));

				$baris->years = $years;  // Add this line to store years in $baris object
				$baris->months = $months; // Add this line to store months in $baris object
			}


			if ($aksi == 'e') {
				$p = "sdi_edit";

				$data['query'] = $this->db->get_where("tbl_user", "id_user = '$id'")->row();
				$data['judul_web'] = "Edit Pengguna | Melati-App";

				$this->load->view('users/header', $data);
				$this->load->view("users/pengaturan/$p", $data); // Ganti dengan nama file view yang sesuai
				$this->load->view('users/footer');
			} else {
				$p = "pengguna";
				$data['judul_web'] = "SDI | Melati-App";

				$this->load->view('users/header', $data);
				$this->load->view("users/pengaturan/sdi", $data);
				$this->load->view('users/footer');
			}

			date_default_timezone_set('Asia/Jakarta');
			$tgl = date('d-m-Y H:i:s');


			// UPDATE USER
			if (isset($_POST['btnupdate'])) {
				$username = htmlentities(strip_tags($this->input->post('username')));

				$data = array(
					'username' => $this->input->post('username'),
					'alamat' => $this->input->post('alamat'),
					'telp' => $this->input->post('telp'),
					'email' => $this->input->post('email'),
					'tgl_daftar' => $this->input->post('tgl_daftar'),
					'jenjang_pen' => $this->input->post('jenjang_pen'),
					'jurusan_pen' => $this->input->post('jurusan_pen'),
					'performa' => $this->input->post('performa'),
					'sisa_cuti' => $this->input->post('sisa_cuti'),
					'evaluasi' => $this->input->post('evaluasi'),
					'pengalaman' => $this->input->post('pengalaman'),
					'tgl_lahir' => $this->input->post('tgl_lahir'),
					'pesan' => $this->input->post('pesan'),
					'notifikasi' => $this->input->post('notifikasi'),
				);

				$this->Mcrud->update_user(array('id_user' => $id), $data);

				$this->session->set_flashdata(
					'msg',
					'
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
            </button>
            <strong>Sukses!</strong> Data berhasil diupdate.
        </div>'
				);
				redirect('users/sdi');
			}
		}
	}

	public function sdi_export_excel()
	{
		// Get all active users
		$users = $this->Mcrud->get_all_users_aktif();

		// Create new Spreadsheet object
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		// Set the header row
		$sheet->setCellValue('A1', 'No.');
		$sheet->setCellValue('B1', 'Nama');
		$sheet->setCellValue('C1', 'Tgl Lahir');
		$sheet->setCellValue('D1', 'Telp');
		$sheet->setCellValue('E1', 'Pend');
		$sheet->setCellValue('F1', 'Tgl Masuk');
		$sheet->setCellValue('G1', 'Rate');
		$sheet->setCellValue('H1', 'Sisa Cuti');

		// Populate data rows
		$row = 2; // Start row for data
		$no = 1; // Start counter for No.
		foreach ($users as $user) {
			$sheet->setCellValue('A' . $row, $no);
			$sheet->setCellValue('B' . $row, $user['nama_lengkap']);
			$sheet->setCellValue('C' . $row, $user['tgl_lahir']);
			$sheet->setCellValue('D' . $row, $user['telp']);
			$sheet->setCellValue('E' . $row, $user['jenjang_pen'] . ' ' . $user['jurusan_pen']);
			$sheet->setCellValue('F' . $row, date('Y-m-d', strtotime($user['tgl_daftar'])));
			$sheet->setCellValue('G' . $row, $user['performa']);
			$sheet->setCellValue('H' . $row, $user['sisa_cuti']);

			$no++;
			$row++;
		}

		// Set the Excel file for download
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Data_karyawan.xlsx"');
		header('Cache-Control: max-age=0');

		// Write to PHP output
		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
	}


	public function bagian($aksi = '', $id = '')
	{
		$ceks = $this->session->userdata('user@mt');
		$id_user = $this->session->userdata('id_user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);

			if ($data['user']->row()->level == 'user') {
				redirect('404_content');
			}

			$this->db->join('tbl_user', 'tbl_bagian.id_user=tbl_user.id_user');
			if ($data['user']->row()->level == 'user') {
				$this->db->where('tbl_bagian.id_user', "$id_user");
			}
			$this->db->order_by('tbl_bagian.nama_bagian', 'ASC');
			$data['bagian'] = $this->db->get("tbl_bagian");

			if ($aksi == 't') {
				$p = "bagian_tambah";
				if ($data['user']->row()->level == 'umum') {
					redirect('404_content');
				}

				$data['judul_web'] = "Tambah Bagian | Melati-App";
			} elseif ($aksi == 'e') {
				$p = "bagian_edit";
				if ($data['user']->row()->level == 'umum') {
					redirect('404_content');
				}

				$data['query'] = $this->db->get_where("tbl_bagian", array('id_bagian' => "$id"))->row();
				$data['judul_web'] = "Edit Bagian | Melati-App";

				// if ($data['query']->id_user == '') {
				// 		$this->session->set_flashdata('msg',
				// 			'
				// 			<div class="alert alert-warning alert-dismissible" role="alert">
				// 				 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				// 					 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
				// 				 </button>
				// 				 <strong>Gagal!</strong> Maaf, Anda tidak berhak mengubah data bagian.
				// 			</div>'
				// 		);
				//
				// 		redirect('users/bagian');
				// }

			} elseif ($aksi == 'h') {

				$disallowedLevels = array('surveyor', 'audit', 'it', 'satpam', 'ofb', 'marketing');
				if (in_array($data['user']->row()->level, $disallowedLevels)) {
					redirect('404_content');
				}

				$data['query'] = $this->db->get_where("tbl_bagian", array('id_bagian' => "$id"))->row();
				$data['judul_web'] = "Hapus Bagian | Melati-App";

				// if ($data['query']->id_user == '') {
				// 		$this->session->set_flashdata('msg',
				// 			'
				// 			<div class="alert alert-warning alert-dismissible" role="alert">
				// 				 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				// 					 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
				// 				 </button>
				// 				 <strong>Gagal!</strong> Maaf, Anda tidak berhak menghapus data bagian.
				// 			</div>'
				// 		);
				// }else {
				$this->Mcrud->delete_bagian_by_id($id);
				$this->session->set_flashdata(
					'msg',
					'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Bagian berhasil dihapus.
								</div>'
				);
				// }

				redirect('users/bagian');
			} else {
				$p = "bagian";

				$data['judul_web'] = "Bagian | Melati-App";
			}

			$this->load->view('users/header', $data);
			$this->load->view("users/pengaturan/$p", $data);
			$this->load->view('users/footer');

			date_default_timezone_set('Asia/Jakarta');
			$tgl = date('d-m-Y H:i:s');

			if (isset($_POST['btnsimpan'])) {
				$nama_bagian = htmlentities(strip_tags($this->input->post('nama_bagian')));

				$data = array(
					'nama_bagian' => $nama_bagian,
					'id_user' => $id_user
				);
				$this->Mcrud->save_bagian($data);

				$this->session->set_flashdata(
					'msg',
					'
											<div class="alert alert-success alert-dismissible" role="alert">
												 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
													 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
												 </button>
												 <strong>Sukses!</strong> Bagian berhasil ditambahkan.
											</div>'
				);

				redirect('users/bagian/t');
			}

			if (isset($_POST['btnupdate'])) {
				$nama_bagian = htmlentities(strip_tags($this->input->post('nama_bagian')));

				$data = array(
					'nama_bagian' => $nama_bagian
				);
				$this->Mcrud->update_bagian(array('id_bagian' => $id), $data);

				$this->session->set_flashdata(
					'msg',
					'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Bagian berhasil diupdate.
										</div>'
				);
				redirect('users/bagian');
			}
		}
	}



	public function ns($aksi = '', $id = '')
	{
		redirect('404_content');
		$ceks = $this->session->userdata('user@mt');
		$id_user = $this->session->userdata('id_user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);

			$this->db->where('tbl_bagian.id_user', "$id_user");
			$this->db->order_by('nama_bagian', 'ASC');
			$data['bagian'] = $this->db->get("tbl_bagian")->result();

			if ($data['user']->row()->level == 'admin') {
				redirect('404_content');
			}

			// $this->db->join('tbl_bagian', 'tbl_bagian.id_bagian=tbl_ns.id_bagian');
			$this->db->order_by('tbl_ns.id_ns', 'DESC');
			$data['ns'] = $this->db->get("tbl_ns");

			if ($aksi == 't') {
				$p = "ns_tambah";
				if ($data['user']->row()->level == 'umum') {
					redirect('404_content');
				}

				$data['judul_web'] = "Tambah Nomor Surat | Melati-App";
			} elseif ($aksi == 'e') {
				$p = "ns_edit";
				if ($data['user']->row()->level == 'umum') {
					redirect('404_content');
				}

				$data['query'] = $this->db->get_where("tbl_ns", array('id_ns' => "$id", 'id_user' => "$id_user"))->row();
				$data['judul_web'] = "Edit Nomor Surat | Melati-App";

				if ($data['query']->id_user == '') {
					$this->session->set_flashdata(
						'msg',
						'
								<div class="alert alert-warning alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Gagal!</strong> Maaf, Anda tidak berhak mengubah data nomor surat.
								</div>'
					);

					redirect('users/ns');
				}
			} elseif ($aksi == 'h') {

				$disallowedLevels = array('surveyor', 'audit', 'it', 'satpam', 'ofb', 'marketing');
				if (in_array($data['user']->row()->level, $disallowedLevels)) {
					redirect('404_content');
				}

				$data['query'] = $this->db->get_where("tbl_ns", array('id_ns' => "$id", 'id_user' => "$id_user"))->row();
				$data['judul_web'] = "Hapus Nomor Surat | Melati-App";

				if ($data['query']->id_user == '') {
					$this->session->set_flashdata(
						'msg',
						'
								<div class="alert alert-warning alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Gagal!</strong> Maaf, Anda tidak berhak menghapus data nomor surat.
								</div>'
					);
				} else {
					$this->Mcrud->delete_ns_by_id($id);
					$this->session->set_flashdata(
						'msg',
						'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Nomor surat berhasil dihapus.
								</div>'
					);
				}

				redirect('users/ns');
			} else {
				$p = "ns";

				$data['judul_web'] = "Nomor surat | Melati-App";
			}

			$this->load->view('users/header', $data);
			$this->load->view("users/pengaturan/$p", $data);
			$this->load->view('users/footer');

			date_default_timezone_set('Asia/Jakarta');
			$tgl = date('d-m-Y H:i:s');

			if (isset($_POST['btnsimpan'])) {
				$separator = htmlentities(strip_tags($this->input->post('separator')));

				$no_posisi = htmlentities(strip_tags($this->input->post('no_posisi')));
				$no = htmlentities(strip_tags($this->input->post('no')));

				$org_posisi = htmlentities(strip_tags($this->input->post('org_posisi')));
				$org = htmlentities(strip_tags($this->input->post('org')));

				$bag_posisi = htmlentities(strip_tags($this->input->post('bag_posisi')));
				$bag = htmlentities(strip_tags($this->input->post('bag')));

				$subbag_posisi = htmlentities(strip_tags($this->input->post('subbag_posisi')));
				$subbag = htmlentities(strip_tags($this->input->post('subbag')));

				$bln_posisi = htmlentities(strip_tags($this->input->post('bln_posisi')));
				$bln = htmlentities(strip_tags($this->input->post('bln')));

				$thn_posisi = htmlentities(strip_tags($this->input->post('thn_posisi')));
				$thn = htmlentities(strip_tags($this->input->post('thn')));
				$reset_no = htmlentities(strip_tags($this->input->post('reset_no')));

				$prefix = htmlentities(strip_tags($this->input->post('prefix')));
				$prefix_posisi = htmlentities(strip_tags($this->input->post('prefix_posisi')));

				$jenis_ns = htmlentities(strip_tags($this->input->post('jenis_ns')));
				$ket = htmlentities(strip_tags($this->input->post('ket')));

				//1
				if ($no_posisi == 1) {
					$no1 = $no;
				} elseif ($no_posisi == 2) {
					$no2 = $no;
				} elseif ($no_posisi == 3) {
					$no3 = $no;
				} elseif ($no_posisi == 4) {
					$no4 = $no;
				} elseif ($no_posisi == 5) {
					$no5 = $no;
				} elseif ($no_posisi == 6) {
					$no6 = $no;
				}

				//2
				if ($org_posisi == 1) {
					$no1 = $org;
				} elseif ($org_posisi == 2) {
					$no2 = $org;
				} elseif ($org_posisi == 3) {
					$no3 = $org;
				} elseif ($org_posisi == 4) {
					$no4 = $org;
				} elseif ($org_posisi == 5) {
					$no5 = $org;
				} elseif ($org_posisi == 6) {
					$no6 = $org;
				}

				//3
				if ($bag_posisi == 1) {
					$no1 = $bag;
				} elseif ($bag_posisi == 2) {
					$no2 = $bag;
				} elseif ($bag_posisi == 3) {
					$no3 = $bag;
				} elseif ($bag_posisi == 4) {
					$no4 = $bag;
				} elseif ($bag_posisi == 5) {
					$no5 = $bag;
				} elseif ($bag_posisi == 6) {
					$no6 = $bag;
				}

				//4
				if ($subbag_posisi == 1) {
					$no1 = $subbag;
				} elseif ($subbag_posisi == 2) {
					$no2 = $subbag;
				} elseif ($subbag_posisi == 3) {
					$no3 = $subbag;
				} elseif ($subbag_posisi == 4) {
					$no4 = $subbag;
				} elseif ($subbag_posisi == 5) {
					$no5 = $subbag;
				} elseif ($subbag_posisi == 6) {
					$no6 = $subbag;
				}

				//5
				if ($bln_posisi == 1) {
					$no1 = $bln;
				} elseif ($bln_posisi == 2) {
					$no2 = $bln;
				} elseif ($bln_posisi == 3) {
					$no3 = $bln;
				} elseif ($bln_posisi == 4) {
					$no4 = $bln;
				} elseif ($bln_posisi == 5) {
					$no5 = $bln;
				} elseif ($bln_posisi == 6) {
					$no6 = $bln;
				}

				//6
				if ($thn_posisi == 1) {
					$no1 = $thn;
				} elseif ($thn_posisi == 2) {
					$no2 = $thn;
				} elseif ($thn_posisi == 3) {
					$no3 = $thn;
				} elseif ($thn_posisi == 4) {
					$no4 = $thn;
				} elseif ($thn_posisi == 5) {
					$no5 = $thn;
				} elseif ($thn_posisi == 6) {
					$no6 = $thn;
				}

				if ($no1 != '') {
					if ($no2 != '') {
						$no1 = "$no1$separator";
					} else {
						$no1 = "$no1";
					}
				}
				if ($no2 != '') {
					if ($no3 != '') {
						$no2 = "$no2$separator";
					} else {
						$no2 = "$no2";
					}
				}
				if ($no3 != '') {
					if ($no4 != '') {
						$no3 = "$no3$separator";
					} else {
						$no3 = "$no3";
					}
				}
				if ($no4 != '') {
					if ($no5 != '') {
						$no4 = "$no4$separator";
					} else {
						$no4 = "$no4";
					}
				}
				if ($no5 != '') {
					if ($no6 != '') {
						$no5 = "$no5$separator";
					} else {
						$no5 = "$no5";
					}
				}

				if ($prefix_posisi == "kiri") {
					$p_kiri = "$prefix$separator";
					$p_kanan = '';
				} elseif ($prefix_posisi == "kanan") {
					$p_kiri = '';
					$p_kanan = "$separator$prefix";
				} else {
					$p_kiri = '';
					$p_kanan = '';
				}

				if ($reset_no == '') {
					$reset_no = 'thn';
				}

				$no_surat = "$p_kiri$no1$no2$no3$no4$no5$no6$p_kanan";

				if ($ket == '') {
					$ket = '-';
				}
				$data = array(
					'separator' => $separator,
					'no_posisi' => $no_posisi,
					'no' => $no,
					'org_posisi' => $org_posisi,
					'org' => $org,
					'bag_posisi' => $bag_posisi,
					'bag' => $bag,
					'subbag_posisi' => $subbag_posisi,
					'subbag' => $subbag,
					'bln_posisi' => $bln_posisi,
					'bln' => $bln,
					'thn_posisi' => $thn_posisi,
					'thn' => $thn,
					'reset_no' => $reset_no,
					'prefix' => $prefix,
					'prefix_posisi' => $prefix_posisi,
					'jenis_ns' => $jenis_ns,
					'ket' => $ket,
					'no_surat' => $no_surat,
					'id_user' => $id_user,
					'tgl_ns' => $tgl
				);
				$this->Mcrud->save_ns($data);

				$this->session->set_flashdata(
					'msg',
					'
											<div class="alert alert-success alert-dismissible" role="alert">
												 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
													 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
												 </button>
												 <strong>Sukses!</strong> Nomor Surat berhasil ditambahkan.
											</div>'
				);

				redirect('users/ns/t');
			}

			if (isset($_POST['btnupdate'])) {
				$separator = htmlentities(strip_tags($this->input->post('separator')));

				$no_posisi = htmlentities(strip_tags($this->input->post('no_posisi')));
				$no = htmlentities(strip_tags($this->input->post('no')));

				$org_posisi = htmlentities(strip_tags($this->input->post('org_posisi')));
				$org = htmlentities(strip_tags($this->input->post('org')));

				$bag_posisi = htmlentities(strip_tags($this->input->post('bag_posisi')));
				$bag = htmlentities(strip_tags($this->input->post('bag')));

				$subbag_posisi = htmlentities(strip_tags($this->input->post('subbag_posisi')));
				$subbag = htmlentities(strip_tags($this->input->post('subbag')));

				$bln_posisi = htmlentities(strip_tags($this->input->post('bln_posisi')));
				$bln = htmlentities(strip_tags($this->input->post('bln')));

				$thn_posisi = htmlentities(strip_tags($this->input->post('thn_posisi')));
				$thn = htmlentities(strip_tags($this->input->post('thn')));
				$reset_no = htmlentities(strip_tags($this->input->post('reset_no')));

				$prefix = htmlentities(strip_tags($this->input->post('prefix')));
				$prefix_posisi = htmlentities(strip_tags($this->input->post('prefix_posisi')));

				$jenis_ns = htmlentities(strip_tags($this->input->post('jenis_ns')));
				$ket = htmlentities(strip_tags($this->input->post('ket')));

				$no1 = '';
				$no2 = '';
				$no3 = '';
				$no4 = '';
				$no5 = '';
				$no6 = '';

				//1
				if ($no_posisi == 1) {
					$no1 = $no;
				} elseif ($no_posisi == 2) {
					$no2 = $no;
				} elseif ($no_posisi == 3) {
					$no3 = $no;
				} elseif ($no_posisi == 4) {
					$no4 = $no;
				} elseif ($no_posisi == 5) {
					$no5 = $no;
				} elseif ($no_posisi == 6) {
					$no6 = $no;
				}

				//2
				if ($org_posisi == 1) {
					$no1 = $org;
				} elseif ($org_posisi == 2) {
					$no2 = $org;
				} elseif ($org_posisi == 3) {
					$no3 = $org;
				} elseif ($org_posisi == 4) {
					$no4 = $org;
				} elseif ($org_posisi == 5) {
					$no5 = $org;
				} elseif ($org_posisi == 6) {
					$no6 = $org;
				}

				//3
				if ($bag_posisi == 1) {
					$no1 = $bag;
				} elseif ($bag_posisi == 2) {
					$no2 = $bag;
				} elseif ($bag_posisi == 3) {
					$no3 = $bag;
				} elseif ($bag_posisi == 4) {
					$no4 = $bag;
				} elseif ($bag_posisi == 5) {
					$no5 = $bag;
				} elseif ($bag_posisi == 6) {
					$no6 = $bag;
				}

				//4
				if ($subbag_posisi == 1) {
					$no1 = $subbag;
				} elseif ($subbag_posisi == 2) {
					$no2 = $subbag;
				} elseif ($subbag_posisi == 3) {
					$no3 = $subbag;
				} elseif ($subbag_posisi == 4) {
					$no4 = $subbag;
				} elseif ($subbag_posisi == 5) {
					$no5 = $subbag;
				} elseif ($subbag_posisi == 6) {
					$no6 = $subbag;
				}

				//5
				if ($bln_posisi == 1) {
					$no1 = $bln;
				} elseif ($bln_posisi == 2) {
					$no2 = $bln;
				} elseif ($bln_posisi == 3) {
					$no3 = $bln;
				} elseif ($bln_posisi == 4) {
					$no4 = $bln;
				} elseif ($bln_posisi == 5) {
					$no5 = $bln;
				} elseif ($bln_posisi == 6) {
					$no6 = $bln;
				}

				//6
				if ($thn_posisi == 1) {
					$no1 = $thn;
				} elseif ($thn_posisi == 2) {
					$no2 = $thn;
				} elseif ($thn_posisi == 3) {
					$no3 = $thn;
				} elseif ($thn_posisi == 4) {
					$no4 = $thn;
				} elseif ($thn_posisi == 5) {
					$no5 = $thn;
				} elseif ($thn_posisi == 6) {
					$no6 = $thn;
				}

				if ($no1 != '') {
					if ($no2 != '') {
						$no1 = "$no1$separator";
					} else {
						$no1 = "$no1";
					}
				}
				if ($no2 != '') {
					if ($no3 != '') {
						$no2 = "$no2$separator";
					} else {
						$no2 = "$no2";
					}
				}
				if ($no3 != '') {
					if ($no4 != '') {
						$no3 = "$no3$separator";
					} else {
						$no3 = "$no3";
					}
				}
				if ($no4 != '') {
					if ($no5 != '') {
						$no4 = "$no4$separator";
					} else {
						$no4 = "$no4";
					}
				}
				if ($no5 != '') {
					if ($no6 != '') {
						$no5 = "$no5$separator";
					} else {
						$no5 = "$no5";
					}
				}


				if ($prefix_posisi == "kiri") {
					$p_kiri = "$prefix$separator";
					$p_kanan = '';
				} else {
					$p_kiri = '';
					$p_kanan = "$separator$prefix";
				}

				if ($reset_no == '') {
					$reset_no = 'thn';
				}

				$no_surat = "$p_kiri$no1$no2$no3$no4$no5$no6$p_kanan";

				if ($ket == '') {
					$ket = '-';
				}
				$data = array(
					'separator' => $separator,
					'no_posisi' => $no_posisi,
					'no' => $no,
					'org_posisi' => $org_posisi,
					'org' => $org,
					'bag_posisi' => $bag_posisi,
					'bag' => $bag,
					'subbag_posisi' => $subbag_posisi,
					'subbag' => $subbag,
					'bln_posisi' => $bln_posisi,
					'bln' => $bln,
					'thn_posisi' => $thn_posisi,
					'thn' => $thn,
					'reset_no' => $reset_no,
					'prefix' => $prefix,
					'prefix_posisi' => $prefix_posisi,
					'jenis_ns' => $jenis_ns,
					'ket' => $ket,
					'no_surat' => $no_surat,
					'id_user' => $id_user
				);
				$this->Mcrud->update_ns(array('id_ns' => $id), $data);

				$this->session->set_flashdata(
					'msg',
					'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Nomor Surat berhasil diupdate.
										</div>'
				);
				redirect('users/ns');
			}
		}
	}

	// tampilkan data yang sudah selesai otorisasi
	public function sm($aksi = '', $id = '')
	{
		$ceks = $this->session->userdata('user@mt');
		$id_user = $this->session->userdata('id_user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);

			$this->db->where('dibaca', 0);

			// Menyiapkan data untuk sort
			$data['order_by'] = $this->input->get('order_by') ? $this->input->get('order_by') : 'tgl_sm';
			$data['order_type'] = $this->input->get('order_type') ? $this->input->get('order_type') : 'asc';

			// Menyiapkan data filter
			// $tanggal = $this->input->get('tanggal') ? date('d-m-Y', strtotime($this->input->get('tanggal'))) : null;
			$tanggal = $this->input->get('tanggal') ? date('Y-m-d', strtotime($this->input->get('tanggal'))) : date('Y-m-d');
			$nama_anggota = $this->input->get('nama_anggota') ? $this->input->get('nama_anggota') : null;

			/// Menyiapkan data untuk sort
			if (isset($_GET['sort_by'])) {
				$sort_by = $_GET['sort_by'];
				if ($sort_by === 'nama_anggota_asc') {
					$data['order_by'] = 'tbl_sm.nama_anggota';
					$data['order_type'] = 'ASC';
				} elseif ($sort_by === 'nama_anggota_desc') {
					$data['order_by'] = 'tbl_sm.nama_anggota';
					$data['order_type'] = 'DESC';
				} else {
					// Default sorting jika parameter sort tidak valid
					$data['order_by'] = 'tbl_sm.id_sm';
					$data['order_type'] = 'DESC';
				}
			} else {
				// Default sorting jika tidak ada parameter sort yang dipilih
				$data['order_by'] = 'tbl_sm.id_sm';
				$data['order_type'] = 'DESC';
			}

			// Mengambil data surat masuk dengan filter dan sort
			if ($tanggal || $nama_anggota) {
				$data['sm'] = $this->Mcrud->get_surat_masuk_by_filter(
					$tanggal,
					$nama_anggota,
					$data['order_by'],
					$data['order_type']
				);
			} else {
				// Jika tidak ada filter, gunakan default sorting
				$this->db->order_by($data['order_by'], $data['order_type']);
				$data['sm'] = $this->db->get("tbl_sm");
			}

			if ($aksi == 't') {
				$p = "sm_tambah";
				$data['judul_web'] = "Tambah Data Otorisasi | Melati-App";
				$data['data_ns'] = $this->Mcrud->data_ns('sm', "$id_user");
			} elseif ($aksi == 'd') {
				$p = "sm_detail";
				$data['query'] = $this->db->get_where("tbl_sm", array('id_sm' => "$id"))->row();
				$data['judul_web'] = "Proses Data Otorisasi | Melati-App";
				// 	disini yang di perbolehkan untuk melakukan otorisasi
				$allowedLevels = array('k_admin', 's_admin');
				if (in_array($data['user']->row()->level, $allowedLevels)) {
					$currentDibaca = $data['query']->dibaca;
					if ($currentDibaca == 0) {
						$this->Mcrud->update_sm(['id_sm' => $id], ['dibaca' => '1']);
					}
					// if ($currentDibaca == 0) {
					// 	$data2 = array(
					// 		'dibaca' => '1'
					// 	);
					// } else {
					// 	$data2 = array(
					// 		'dibaca' => '0'
					// 	);
					// }

					$current_page = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null; // Dapatkan URL halaman saat ini

					// $this->Mcrud->update_sm(array('id_sm' => $id), $data2);

					if (strpos($current_page, 'users/sm') !== false) {
						redirect('users/sm');
					} elseif (strpos($current_page, 'users/ss') !== false) {
						redirect('users/ss');
					}
				}
			} elseif ($aksi == 'l') {
				$p = "sm_detail";
				$data['query'] = $this->db->get_where("tbl_sm", array('id_sm' => "$id"))->row();
				$data['judul_web'] = "Detail Data Otorisasi | Melati-App";
			} elseif ($aksi == 'e') {
				$p = "sm_edit";
				if ($data['user']->row()->level == 'user' or $data['user']->row()->level == 'umum') {
					redirect('404_content');
				}

				$data['query'] = $this->db->get_where("tbl_sm", array('id_sm' => "$id"))->row();
				$data['judul_web'] = "Edit Data Otorisasi | Melati-App";
			} elseif ($aksi == 'h') {

				if ($data['user']->row()->level == 'k_admin' or $data['user']->row()->level == 's_admin') {

					$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
					foreach ($query_h->result() as $baris) {
						// Construct the file path
						$filePath = 'lampiran/' . $baris->nama_berkas;

						// Check if the file exists before attempting to delete
						if (file_exists($filePath)) {
							unlink($filePath); // Delete the file
						}
					}

					$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
					$this->Mcrud->delete_sm_by_id($id);
					$this->session->set_flashdata(
						'msg',
						'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data otorisasi berhasil dihapus.
								</div>'
					);
				}

				$data['query'] = $this->db->get_where("tbl_sm", array('id_sm' => "$id", 'id_user' => "$id_user"))->row();
				$data['judul_web'] = "Hapus data otorisasi masuk | Melati-App";

				if ($data['query']->level != 'user') {
					// $this->session->set_flashdata('msg',
					// 	'
					// 	<div class="alert alert-warning alert-dismissible" role="alert">
					// 		 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					// 			 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
					// 		 </button>
					// 		 <strong>Gagal!</strong> Maaf, Anda tidak berhak menghapus data surat masuk.
					// 	</div>'
					// );

					$data2 = array(
						'id_user' => ''
					);
					$current_page = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null; // Dapatkan URL halaman saat ini
					$this->Mcrud->update_sm(array('id_sm' => "$id"), $data2);
					if (strpos($current_page, 'users/sm') !== false) {
						redirect('users/sm');
					} elseif (strpos($current_page, 'users/ss') !== false) {
						redirect('users/ss');
					}
				} else {

					redirect('404_content');
				}

				redirect('users/sm');
			} else {
				$p = "sm";

				$data['judul_web'] = "Otorisasi Masuk | Melati-App";
			}

			$this->load->view('users/header', $data);
			$this->load->view("users/pemrosesan/$p", $data);
			$this->load->view('users/footer');


			if (isset($_POST['ns'])) {

				$this->upload->initialize(
					array(
						"upload_path" => "./lampiran",
						"allowed_types" => "*" //jpg|jpeg|png|gif|bmp
					)
				);

				if ($this->upload->do_upload('userfile')) {
					$tgl_no_asal = htmlentities(strip_tags($this->input->post('tgl_no_asal')));
					$nama_anggota = htmlentities(strip_tags($this->input->post('nama_anggota')));
					$nomor_rekening = htmlentities(strip_tags($this->input->post('nomor_rekening')));
					$kode_kantor = htmlentities(strip_tags($this->input->post('kode_kantor')));
					$kode_devisi = htmlentities(strip_tags($this->input->post('kode_devisi')));
					$penerima = htmlentities(strip_tags($this->input->post('penerima')));
					$nominal = htmlentities(strip_tags($this->input->post('nominal')));
					$keterangan = htmlentities(strip_tags($this->input->post('keterangan')));
					$id_surat = $this->input->post('id_surat');
					date_default_timezone_set('Asia/Jakarta');
					$waktu = date('Y-m-d H:m:s');
					$tgl = date('d-m-Y');
					$tgl_sm_date = $this->input->post('tgl_sm_date');
					$tgl_transaksi = $this->input->post('tgl_transaksi');
					$token = md5("$id_user-$tgl_no_asal-$waktu");
					$cek_status = $this->db->get_where('tbl_sm', "token_lampiran='$token'")->num_rows();
					if ($cek_status == 0) {
						$data = array(
							'tgl_ns' => $tgl_no_asal,
							'tgl_no_asal' => $tgl_no_asal,
							'pengirim' => $data['user']->row()->nama_lengkap,
							'nama_anggota' => $nama_anggota,
							'nomor_rekening' => $nomor_rekening,
							'kode_kantor' => $kode_kantor,
							'kode_devisi' => $kode_devisi,
							'penerima' => $penerima,
							'nominal' => $nominal,
							'keterangan' => $keterangan,
							'id_surat' => $id_surat,
							'token_lampiran' => $token,
							'dibaca' => 0,
							'tgl_sm' => $tgl,
							'tgl_sm_date' => $tgl_sm_date,
							'tgl_transaksi' => $tgl_transaksi,
							'id_user' => $id_user
						);
						$this->Mcrud->save_sm($data);
					}

					$nama = $this->upload->data('file_name');
					$ukuran = $this->upload->data('file_size');

					$this->db->insert('tbl_lampiran', array('nama_berkas' => $nama, 'ukuran' => $ukuran, 'token_lampiran' => "$token"));
				}
			}

			if (isset($_POST['btnupdate'])) {
				$tgl_ns = htmlentities(strip_tags($this->input->post('tgl_ns')));
				$tgl_no_asal = htmlentities(strip_tags($this->input->post('tgl_no_asal')));
				$tgl_sm_date = $this->input->post('tgl_sm_date');
				$tgl_transaksi = $this->input->post('tgl_transaksi');
				// $pengirim   	= htmlentities(strip_tags($this->input->post('pengirim')));
				$penerima = htmlentities(strip_tags($this->input->post('penerima')));
				$nominal = htmlentities(strip_tags($this->input->post('nominal')));
				$keterangan = htmlentities(strip_tags($this->input->post('keterangan')));
				$kode_devisi = htmlentities(strip_tags($this->input->post('kode_devisi')));
				$id_surat = $this->input->post('id_surat');

				$data = array(
					'tgl_ns' => $tgl_no_asal,
					'tgl_no_asal' => $tgl_no_asal,
					'tgl_sm_date' => $tgl_sm_date,
					'tgl_transaksi' => $tgl_transaksi,
					// 'pengirim' => $data['user']->row()->nama_lengkap,
					'penerima' => $penerima,
					'nominal' => $nominal,
					'keterangan' => $keterangan,
					'kode_devisi' => $kode_devisi,
					'id_surat' => $id_surat
					// 'id_user' => $id_user
				);
				$this->Mcrud->update_sm(array('id_sm' => $id), $data);

				$this->session->set_flashdata(
					'msg',
					'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Data otorisasi berhasil diupdate.
										</div>'
				);
				redirect('users/sm');
			}
		}
	}
	// tampilkan data yang sudah selesai otorisasi
	public function ss($aksi = '', $id = '')
	{
		$ceks = $this->session->userdata('user@mt');
		$id_user = $this->session->userdata('id_user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);

			// if ($data['user']->row()->level == 'admin') {
			// 		redirect('404_content');
			// }

			// $this->db->join('tbl_user', 'tbl_sm.id_user=tbl_user.id_user');
			// if ($data['user']->row()->level == 'user') {
			// 		$this->db->where('tbl_sm.id_user', "$id_user");
			// }
			$this->db->order_by('tbl_sm.id_sm', 'DESC');
			$this->db->where('dibaca', 1);
			// Siapkan data filter
			// $tanggal = $this->input->get('tanggal') ? date('d-m-Y', strtotime($this->input->get('tanggal'))) : null;
			$tanggal = $this->input->get('tanggal') ? date('Y-m-d', strtotime($this->input->get('tanggal'))) : date('Y-m-d');
			$nama_anggota = $this->input->get('nama_anggota') ? $this->input->get('nama_anggota') : null;

			// Mengambil data surat masuk yang sudah selesai otorisasi dengan filter
			if ($tanggal || $nama_anggota) {
				$this->db->where('dibaca', 1);
				if ($tanggal) {
					$this->db->where('tgl_sm_date', $tanggal);
				}
				if ($nama_anggota) {
					$this->db->like('nama_anggota', $nama_anggota);
				}
				$data['sm'] = $this->db->get("tbl_sm");
			} else {
				// Jika tidak ada filter, ambil semua data
				$this->db->where('dibaca', 1);
				$data['sm'] = $this->db->get("tbl_sm");
			}

			if ($aksi == 't') {
				$p = "sm_tambah";
				if ($data['user']->row()->level == 'umum') {
					redirect('404_content');
				}

				$data['judul_web'] = "Tambah Data Otorisai | Melati-App";
				$data['data_ns'] = $this->Mcrud->data_ns('sm', "$id_user");
			} elseif ($aksi == 'd') {
				$p = "sm_detail";

				$data['query'] = $this->db->get_where("tbl_sm", array('id_sm' => "$id"))->row();
				$data['judul_web'] = "Detail Otorisasi | Melati-App";
				if ($data['user']->row()->level == 'admin' or $data['user']->row()->level == 's_admin') {
					// Ambil nilai dibaca saat ini
					$currentDibaca = $data['query']->dibaca;

					if ($currentDibaca == 0) {
						// Jika nilai dibaca saat ini adalah 0, set menjadi 1
						$data2 = array(
							'dibaca' => '1'
						);
					} else {
						// Jika nilai dibaca saat ini bukan 0, set menjadi 0
						$data2 = array(
							'dibaca' => '0'
						);
					}

					$this->Mcrud->update_sm(array('id_sm' => "$id"), $data2);
					redirect('users/sm');
				}
			} elseif ($aksi == 'e') {
				$p = "sm_edit";
				if ($data['user']->row()->level == 'umum' or $data['user']->row()->level == 'user') {
					redirect('404_content');
				}

				$data['query'] = $this->db->get_where("tbl_sm", array('id_sm' => "$id"))->row();
				$data['judul_web'] = "Edit Data Otorisasi | Melati-App";
			} elseif ($aksi == 'h') {

				if ($data['user']->row()->level == 'admin' or $data['user']->row()->level == 's_admin') {


					$query_h = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $data['query']->token_lampiran));
					foreach ($query_h->result() as $baris) {
						unlink('lampiran/' . $baris->nama_berkas);
					}

					$this->Mcrud->delete_lampiran($data['query']->token_lampiran);
					$this->Mcrud->delete_sm_by_id($id);
					$this->session->set_flashdata(
						'msg',
						'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Data berhasil dihapus.
								</div>'
					);
				}

				$data['query'] = $this->db->get_where("tbl_sm", array('id_sm' => "$id", 'id_user' => "$id_user"))->row();
				$data['judul_web'] = "Hapus Otorisasi Masuk | Melati-App";

				if ($data['query']->level != 'user' or $data['query']->level != 'umum') {
					// $this->session->set_flashdata('msg',
					// 	'
					// 	<div class="alert alert-warning alert-dismissible" role="alert">
					// 		 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					// 			 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
					// 		 </button>
					// 		 <strong>Gagal!</strong> Maaf, Anda tidak berhak menghapus data surat masuk.
					// 	</div>'
					// );

					$data2 = array(
						'id_user' => ''
					);
					$this->Mcrud->update_sm(array('id_sm' => "$id"), $data2);
				} else {

					redirect('404_content');
				}

				redirect('users/sm');
			} else {
				$p = "sm";

				$data['judul_web'] = "Otorisasi Masuk | Melati-App";
			}

			$this->load->view('users/header', $data);
			$this->load->view("users/pemrosesan/$p", $data);
			$this->load->view('users/footer');


			if (isset($_POST['ns'])) {

				$this->upload->initialize(
					array(
						"upload_path" => "./lampiran",
						"allowed_types" => "*" //jpg|jpeg|png|gif|bmp
					)
				);

				if ($this->upload->do_upload('userfile')) {
					// $ns   	 			= htmlentities(strip_tags($this->input->post('ns')));
					$no_asal = htmlentities(strip_tags($this->input->post('no_asal')));
					// $tgl_ns   	 	= htmlentities(strip_tags($this->input->post('tgl_ns')));
					$tgl_no_asal = htmlentities(strip_tags($this->input->post('tgl_no_asal')));
					$nama_anggota = htmlentities(strip_tags($this->input->post('nama_anggota')));
					$nomor_rekening = htmlentities(strip_tags($this->input->post('nomor_rekening')));
					$kode_kantor = htmlentities(strip_tags($this->input->post('kode_kantor')));
					$kode_devisi = htmlentities(strip_tags($this->input->post('kode_devisi')));
					$penerima = htmlentities(strip_tags($this->input->post('penerima')));
					$nominal = htmlentities(strip_tags($this->input->post('nominal')));
					$keterangan = htmlentities(strip_tags($this->input->post('keterangan')));

					date_default_timezone_set('Asia/Jakarta');
					$waktu = date('Y-m-d H:m:s');
					$tgl = date('d-m-Y');
					$tgl_transaksi = $this->input->post('tgl_transaksi');

					$token = md5("$id_user-$tgl_no_asal-$waktu");

					$cek_status = $this->db->get_where('tbl_sm', "token_lampiran='$token'")->num_rows();
					if ($cek_status == 0) {
						$data = array(
							'no_surat' => $no_surat,
							'tgl_ns' => $tgl_no_asal,
							'no_asal' => $no_asal,
							'tgl_no_asal' => $tgl_no_asal,
							'pengirim' => $data['user']->row()->nama_lengkap,
							'nama_anggota' => $nama_anggota,
							'nomor_rekening' => $nomor_rekening,
							'kode_kantor' => $kode_kantor,
							'kode_devisi' => $kode_devisi,
							'penerima' => $penerima,
							'nominal' => $nominal,
							'keterangan' => $keterangan,
							'token_lampiran' => $token,
							'id_user' => $id_user,
							'dibaca' => 0,
							'tgl_sm' => $tgl,
							'tgl_transaksi' => $tgl_transaksi,
							'id_user' => $penerima
						);
						$this->Mcrud->save_sm($data);
					}

					$nama = $this->upload->data('file_name');
					$ukuran = $this->upload->data('file_size');

					$this->db->insert('tbl_lampiran', array('nama_berkas' => $nama, 'ukuran' => $ukuran, 'token_lampiran' => "$token"));
				}
			}

			if (isset($_POST['btnupdate'])) {
				$no_asal = htmlentities(strip_tags($this->input->post('no_asal')));
				// $tgl_ns   	 	= htmlentities(strip_tags($this->input->post('tgl_ns')));
				$tgl_no_asal = htmlentities(strip_tags($this->input->post('tgl_no_asal')));
				// $pengirim   	= htmlentities(strip_tags($this->input->post('pengirim')));
				$penerima = htmlentities(strip_tags($this->input->post('penerima')));
				$nominal = htmlentities(strip_tags($this->input->post('nominal')));
				$tgl_transaksi = $this->input->post('tgl_transaksi');
				$keterangan = htmlentities(strip_tags($this->input->post('keterangan')));

				$data = array(
					'tgl_ns' => $tgl_no_asal,
					'no_asal' => $no_asal,
					'tgl_no_asal' => $tgl_no_asal,
					'pengirim' => $data['user']->row()->nama_lengkap,
					'penerima' => $penerima,
					'nominal' => $nominal,
					'tgl_transaksi' => $tgl_transaksi,
					'keterangan' => $keterangan,
					'id_user' => $penerima
				);
				$this->Mcrud->update_sm(array('id_sm' => $id), $data);

				$this->session->set_flashdata(
					'msg',
					'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Data berhasil diupdate.
										</div>'
				);
				redirect('users/sm');
			}
		}
	}

	public function memo($aksi = '', $id = '')
	{
		$ceks = $this->session->userdata('user@mt');
		$id_user = $this->session->userdata('id_user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$this->db->join('tbl_user', 'tbl_memo.id_user=tbl_user.id_user');
			if ($data['user']->row()->level == 'user') {
				$this->db->where('tbl_memo.id_user', "$id_user");
			}
			$this->db->order_by('tbl_memo.judul_memo', 'DESC');
			$data['memo'] = $this->db->get("tbl_memo");

			if ($aksi == 't') {
				$p = "memo_tambah";
				$AllowedLevels = array('k_hrd', 'kadiv_manrisk', 's_admin');
				if (!in_array($data['user']->row()->level, $AllowedLevels)) {
					redirect('404_content');
				}


				$data['judul_web'] = "Tambah Memo | Melati-App";
			} elseif ($aksi == 'lihat') {
				$p = "memo_lihat";
				$data['judul_web'] = "Lihat Memo | Melati-App";
				$data['memo'] = $this->Mcrud->get_memo_by_id($id);

				if (!$data['memo']) {
					redirect('404_content');
				}
			} elseif ($aksi == 'e') {
				$p = "memo_edit";
				$AllowedLevels = array('k_hrd', 'kadiv_manrisk', 's_admin');
				if (!in_array($data['user']->row()->level, $AllowedLevels)) {
					redirect('404_content');
				}

				$data['query'] = $this->db->get_where("tbl_memo", array('id_memo' => "$id", 'id_user' => "$id_user"))->row();
				$data['judul_web'] = "Edit Info | Melati-App";

				if ($data['query']->id_user == '') {
					$this->session->set_flashdata(
						'msg',
						'
								<div class="alert alert-warning alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Gagal!</strong> Maaf, Anda tidak berhak mengubah data info.
								</div>'
					);

					redirect('users/memo');
				}
			} elseif ($aksi == 'h') {

				$AllowedLevels = array('k_hrd', 'kadiv_manrisk', 's_admin');
				if (!in_array($data['user']->row()->level, $AllowedLevels)) {
					redirect('404_content');
				}
				$data['query'] = $this->db->get_where("tbl_memo", array('id_memo' => "$id", 'id_user' => "$id_user"))->row();
				$data['judul_web'] = "Hapus Info | Melati-App";

				if ($data['query']->id_user == '') {
					$this->session->set_flashdata(
						'msg',
						'
								<div class="alert alert-warning alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Gagal!</strong> Maaf, Anda tidak berhak menghapus data info.
								</div>'
					);
				} else {
					$this->Mcrud->delete_memo_by_id($id);
					$this->session->set_flashdata(
						'msg',
						'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> Info berhasil dihapus.
								</div>'
					);
				}

				redirect('users/memo');
			} else {
				$p = "memo";

				$data['judul_web'] = "Info | Melati-App";
			}

			$this->load->view('users/header', $data);
			$this->load->view("users/memo/$p", $data);
			$this->load->view('users/footer');

			date_default_timezone_set('Asia/Jakarta');
			$tgl = date('d-m-Y H:i:s');

			if (isset($_POST['btnsimpan'])) {
				$judul_memo = htmlentities(strip_tags($this->input->post('judul_memo')));
				$memo = $this->input->post('memo');
				$status_pin = $this->input->post('status_pin');

				$data = array(
					'judul_memo' => $judul_memo,
					'memo' => $memo,
					'status_pin' => $status_pin,
					'id_user' => $id_user
				);
				$this->Mcrud->save_memo($data);

				$this->session->set_flashdata(
					'msg',
					'
											<div class="alert alert-success alert-dismissible" role="alert">
												 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
													 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
												 </button>
												 <strong>Sukses!</strong> Info berhasil ditambahkan.
											</div>'
				);

				redirect('users/memo/');
			}

			if (isset($_POST['btnupdate'])) {
				$judul_memo = htmlentities(strip_tags($this->input->post('judul_memo')));
				$memo = $this->input->post('memo');
				$status_pin = $this->input->post('status_pin');

				$data = array(
					'judul_memo' => $judul_memo,
					'memo' => $memo,
					'status_pin' => $status_pin,
					'id_user' => $id_user
				);
				$this->Mcrud->update_memo(array('id_memo' => $id), $data);

				$this->session->set_flashdata(
					'msg',
					'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Info berhasil diupdate.
										</div>'
				);
				redirect('users/memo');
			}
		}
	}

	public function catatan($aksi = '', $id = '')
	{
		$ceks = $this->session->userdata('user@mt');
		$id_user = $this->session->userdata('id_user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Catatan_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['catatan'] = $this->Catatan_model->get_catatan_by_id_user($id_user);
			$this->db->order_by('tbl_catatan.judul_catatan', 'DESC');

			if ($aksi == 't') {
				$p = "catatan_tambah";
				$data['judul_web'] = "Tambah catatan | Melati-App";
			} elseif ($aksi == 'lihat') {
				$p = "catatan_lihat";
				$data['judul_web'] = "Lihat catatan | Melati-App";
				$data['catatan'] = $this->Catatan_model->get_catatan_by_id($id);

				if (!$data['catatan']) {
					redirect('404_content');
				}
			} elseif ($aksi == 'e') {
				$p = "catatan_edit";
				$data['query'] = $this->db->get_where("tbl_catatan", array('id_catatan' => "$id", 'id_user' => "$id_user"))->row();
				$data['judul_web'] = "Edit catatan | Melati-App";

				if ($data['query']->id_user == '') {
					$this->session->set_flashdata(
						'msg',
						'
								<div class="alert alert-warning alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Gagal!</strong> Maaf, Anda tidak berhak mengubah data catatan.
								</div>'
					);

					redirect('users/catatan');
				}
			} elseif ($aksi == 'h') {
				$data['query'] = $this->db->get_where("tbl_catatan", array('id_catatan' => "$id", 'id_user' => "$id_user"))->row();
				$data['judul_web'] = "Hapus Catatan | Melati-App";

				if ($data['query']->id_user == '') {
					$this->session->set_flashdata(
						'msg',
						'
								<div class="alert alert-warning alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Gagal!</strong> Maaf, Anda tidak berhak menghapus data catatan.
								</div>'
					);
				} else {
					$this->Catatan_model->delete_catatan_by_id($id);
					$this->session->set_flashdata(
						'msg',
						'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> catatan berhasil dihapus.
								</div>'
					);
				}

				redirect('users/catatan');
			} else {
				$p = "catatan";

				$data['judul_web'] = "catatan | Melati-App";
			}

			$this->load->view('users/header', $data);
			$this->load->view("users/catatan/$p", $data);
			$this->load->view('users/footer');

			date_default_timezone_set('Asia/Jakarta');
			$tgl = date('d-m-Y H:i:s');

			if (isset($_POST['btnsimpan'])) {
				$judul_catatan = htmlentities(strip_tags($this->input->post('judul_catatan')));
				$catatan = $this->input->post('catatan');

				$data = array(
					'judul_catatan' => $judul_catatan,
					'catatan' => $catatan,
					'id_user' => $id_user
				);
				$this->Catatan_model->save_catatan($data);

				$this->session->set_flashdata(
					'msg',
					'
											<div class="alert alert-success alert-dismissible" role="alert">
												 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
													 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
												 </button>
												 <strong>Sukses!</strong> catatan berhasil ditambahkan.
											</div>'
				);

				redirect('users/catatan/');
			}

			if (isset($_POST['btnupdate'])) {
				$judul_catatan = htmlentities(strip_tags($this->input->post('judul_catatan')));
				$catatan = $this->input->post('catatan');

				$data = array(
					'judul_catatan' => $judul_catatan,
					'catatan' => $catatan,
					'id_user' => $id_user
				);
				$this->Catatan_model->update_catatan(array('id_catatan' => $id), $data);

				$this->session->set_flashdata(
					'msg',
					'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> Catatan berhasil diupdate.
										</div>'
				);
				redirect('users/catatan');
			}
		}
	}

	public function pengumuman($aksi = '', $id = '')
	{
		$ceks = $this->session->userdata('user@mt');
		$id_user = $this->session->userdata('id_user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);

			// if ($data['user']->row()->level == 'admin') {
			// 		redirect('404_content');
			// }

			$this->db->join('tbl_user', 'tbl_pengumuman.id_user=tbl_user.id_user');
			if ($data['user']->row()->level == 'user') {
				$this->db->where('tbl_pengumuman.id_user', "$id_user");
			}
			$this->db->order_by('tbl_pengumuman.judul_pengumuman', 'DESC');
			$data['pengumuman'] = $this->db->get("tbl_pengumuman");

			if ($aksi == 't') {
				$p = "pengumuman_tambah";
				$AllowedLevels = array('kabag_hrd', 's_admin');
				if (!in_array($data['user']->row()->level, $AllowedLevels)) {
					redirect('404_content');
				}


				$data['judul_web'] = "Tambah pengumuman | Melati-App";
			} elseif ($aksi == 'lihat') {
				$p = "pengumuman_lihat";
				$data['judul_web'] = "Lihat pengumuman | Melati-App";
				$data['pengumuman'] = $this->Mcrud->get_pengumuman_by_id($id);

				if (!$data['pengumuman']) {
					redirect('404_content');
				}
			} elseif ($aksi == 'e') {
				$p = "pengumuman_edit";
				$AllowedLevels = array('kabah_hrd', 's_admin');
				if (!in_array($data['user']->row()->level, $AllowedLevels)) {
					redirect('404_content');
				}

				$data['query'] = $this->db->get_where("tbl_pengumuman", array('id_pengumuman' => "$id", 'id_user' => "$id_user"))->row();
				$data['judul_web'] = "Edit pengumuman | Melati-App";

				if ($data['query']->id_user == '') {
					$this->session->set_flashdata(
						'msg',
						'
								<div class="alert alert-warning alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Gagal!</strong> Maaf, Anda tidak berhak mengubah data pengumuman.
								</div>'
					);

					redirect('users/pengumuman');
				}
			} elseif ($aksi == 'h') {

				$AllowedLevels = array('kabag_hrd', 's_admin');
				if (!in_array($data['user']->row()->level, $AllowedLevels)) {
					redirect('404_content');
				}
				$data['query'] = $this->db->get_where("tbl_pengumuman", array('id_pengumuman' => "$id", 'id_user' => "$id_user"))->row();
				$data['judul_web'] = "Hapus pengumuman | Melati-App";

				if ($data['query']->id_user == '') {
					$this->session->set_flashdata(
						'msg',
						'
								<div class="alert alert-warning alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Gagal!</strong> Maaf, Anda tidak berhak menghapus data pengumuman.
								</div>'
					);
				} else {
					$this->Mcrud->delete_pengumuman_by_id($id);
					$this->session->set_flashdata(
						'msg',
						'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
									 </button>
									 <strong>Sukses!</strong> pengumuman berhasil dihapus.
								</div>'
					);
				}

				redirect('users/pengumuman');
			} else {
				$p = "pengumuman";

				$data['judul_web'] = "Pengumuman | Melati-App";
			}

			$this->load->view('users/header', $data);
			$this->load->view("users/pengumuman/$p", $data);
			$this->load->view('users/footer');

			date_default_timezone_set('Asia/Jakarta');
			$tgl = date('d-m-Y H:i:s');

			if (isset($_POST['btnsimpan'])) {
				$judul_pengumuman = htmlentities(strip_tags($this->input->post('judul_pengumuman')));
				$isi_pengumuman = $this->input->post('isi_pengumuman');

				$data = array(
					'judul_pengumuman' => $judul_pengumuman,
					'isi_pengumuman' => $isi_pengumuman,
					'id_user' => $id_user
				);
				$this->Mcrud->save_pengumuman($data);

				$this->session->set_flashdata(
					'msg',
					'
											<div class="alert alert-success alert-dismissible" role="alert">
												 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
													 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
												 </button>
												 <strong>Sukses!</strong> pengumuman berhasil ditambahkan.
											</div>'
				);

				redirect('users/pengumuman/t');
			}

			if (isset($_POST['btnupdate'])) {
				$judul_pengumuman = htmlentities(strip_tags($this->input->post('judul_pengumuman')));
				$isi_pengumuman = $this->input->post('isi_pengumuman');

				$data = array(
					'judul_pengumuman' => $judul_pengumuman,
					'isi_pengumuman' => $isi_pengumuman,
					'id_user' => $id_user
				);
				$this->Mcrud->update_pengumuman(array('id_pengumuman' => $id), $data);

				$this->session->set_flashdata(
					'msg',
					'
										<div class="alert alert-success alert-dismissible" role="alert">
											 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												 <span aria-hidden="true">&times;&nbsp; &nbsp;</span>
											 </button>
											 <strong>Sukses!</strong> pengumuman berhasil diupdate.
										</div>'
				);
				redirect('users/pengumuman');
			}
		}
	}

	public function harga_kendaraan($aksi = '', $id = '')
	{
		$ceks = $this->session->userdata('user@mt');
		$id_user = $this->session->userdata('id_user@mt');
		$this->load->model('Harga_kendaraan_model');

		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['harga_kendaraan'] = $this->db->get("tbl_harga_kendaraan");
			$data['harga_kendaraan_detail'] = $this->Harga_kendaraan_model->get_harga_kendaraan_by_id($id);

			// Fetch similar vehicles data
			if ($data['harga_kendaraan_detail']) {
				$data['similarVehicles'] = $this->Harga_kendaraan_model->getSimilarVehicles(
					$data['harga_kendaraan_detail']->merek,
					$data['harga_kendaraan_detail']->model,
					$id // Pass the current vehicle's ID
				);
			} else {
				$data['similarVehicles'] = [];
			}

			if ($aksi == 't') {
				$p = "harga_kendaraan_tambah";
				$allowedLevels = array('kadiv_manrisk', 's_admin');

				if (!in_array($data['user']->row()->level, $allowedLevels)) {
					redirect('404_content');
				}

				$data['judul_web'] = "Tambah Harga Kendaraan | Melati-App";
			} elseif ($aksi == 'lihat') {
				$p = "harga_kendaraan_lihat";
				$data['judul_web'] = "Lihat Harga Kendaraan | Melati-App";
				$data['harga_kendaraan_detail'] = $this->Harga_kendaraan_model->get_harga_kendaraan_by_id($id);
				// Fetch details and similar vehicles
				$data['harga_kendaraan_detail'] = $this->Harga_kendaraan_model->get_harga_kendaraan_by_id($id);

				// Fetch similar vehicles data
				if ($data['harga_kendaraan_detail']) {
					$data['similarVehicles'] = $this->Harga_kendaraan_model->getSimilarVehicles(
						$data['harga_kendaraan_detail']->merek,
						$data['harga_kendaraan_detail']->model,
						$id // Pass the current vehicle's ID
					);
				} else {
					$data['similarVehicles'] = [];
				}


				if (!$data['harga_kendaraan_detail']) {
					redirect('404_content');
				}
			} elseif ($aksi == 'e') {
				$p = "harga_kendaraan_edit";
				$data['harga_kendaraan_detail'] = $this->Harga_kendaraan_model->get_harga_kendaraan_by_id($id);
				$data['query'] = $data['harga_kendaraan_detail'];
				$data['judul_web'] = "Edit Harga Kendaraan | Melati-App";
			} elseif ($aksi == 'h') {
				$data['harga_kendaraan_detail'] = $this->Harga_kendaraan_model->get_harga_kendaraan_by_id($id);
				$data['judul_web'] = "Hapus Harga Kendaraan | Melati-App";

				$this->Harga_kendaraan_model->delete_harga_kendaraan_by_id($id);
				$this->session->set_flashdata(
					'msg',
					'<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;&nbsp; &nbsp;</span>
						</button>
						<strong>Sukses!</strong> Harga kendaraan berhasil dihapus.
					</div>'
				);

				redirect('users/harga_kendaraan');
			} else {
				$p = "harga_kendaraan";
				$data['judul_web'] = "Harga Kendaraan | Melati-App";
			}

			$this->load->view('users/header', $data);
			$this->load->view("users/harga_kendaraan/$p", $data);
			$this->load->view('users/footer');

			// Proses tambah harga kendaraan
			if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnsimpan'])) {
				$this->load->library('upload');
				$this->load->library('image_lib');

				// Ambil data dari formulir
				$merek = htmlentities(strip_tags($this->input->post('merek')));
				$model = htmlentities(strip_tags($this->input->post('model')));
				$tahun = htmlentities(strip_tags($this->input->post('tahun')));
				$harga_jual = htmlentities(strip_tags($this->input->post('harga_jual')));
				$transmisi = htmlentities(strip_tags($this->input->post('transmisi')));
				$bahan_bakar = htmlentities(strip_tags($this->input->post('bahan_bakar')));
				$kapasitas_mesin = htmlentities(strip_tags($this->input->post('kapasitas_mesin')));
				$jenis_kendaraan = htmlentities(strip_tags($this->input->post('jenis_kendaraan')));

				// Jika kapasitas mesin custom, ambil nilai dari input manual
				if ($kapasitas_mesin == 'custom') {
					$kapasitas_mesin_manual = htmlentities(strip_tags($this->input->post('kapasitas_mesin_manual')));
					$kapasitas_mesin = $kapasitas_mesin_manual;
				}

				if (!empty($_FILES['foto']['name'])) {

					// Konfigurasi upload foto
					$config['upload_path'] = './foto/kendaraan/'; // Sesuaikan dengan lokasi yang benar
					$config['allowed_types'] = 'jpg|jpeg|png|gif'; // Sesuaikan dengan jenis file yang diizinkan
					$config['max_size'] = 2048; // Sesuaikan dengan batasan ukuran file (dalam kilobyte)

					$this->upload->initialize($config);

					$foto_path = null; // Default value for the photo path

					if (!$this->upload->do_upload('foto')) {
						// Handle error unggah foto
						$error = array('error' => $this->upload->display_errors());
						print_r($error);
						exit;
					}

					// Jika berhasil upload, ambil nama file
					$upload_data = $this->upload->data();
					$foto_path = $upload_data['file_name'];

					// Compress the uploaded image
					$config['image_library'] = 'gd2';
					$config['source_image'] = './foto/kendaraan/' . $foto_path;
					$config['maintain_ratio'] = TRUE;
					$config['width'] = 800; // Set the desired width (you can set it to the original width)
					$config['height'] = 600; // Set the desired height (you can set it to the original height)
					$config['quality'] = '50%'; // Set the desired quality (adjust as needed)
					$config['encrypt_name'] = TRUE;
					$this->image_lib->initialize($config);

					if (!$this->image_lib->resize()) {
						// Handle error resizing the image
						echo $this->image_lib->display_errors();
						exit;
					}

					$this->image_lib->clear();

					// Masukkan data ke dalam array
					$data_foto['foto'] = $foto_path;
				} else {
					// If no file is selected, set the foto_path to an empty string or null, depending on your database schema
					$foto_path = ''; // You may need to adjust this based on your database schema
				}

				$data = array(
					'merek' => $merek,
					'model' => $model,
					'tahun' => $tahun,
					'harga_jual' => $harga_jual,
					'transmisi' => $transmisi,
					'bahan_bakar' => $bahan_bakar,
					'kapasitas_mesin' => $kapasitas_mesin,
					'jenis_kendaraan' => $jenis_kendaraan,
					'foto' => $foto_path,
					// Tambahkan field lainnya sesuai kebutuhan
				);

				// Panggil model untuk menyimpan data
				$this->Harga_kendaraan_model->save_harga_kendaraan($data);

				// Redirect atau tampilkan pesan sukses
				redirect('users/harga_kendaraan');
			}

			// Proses update harga kendaraan
			if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnupdate'])) {
				$this->load->library('upload');
				$this->load->library('image_lib');

				// Ambil data dari formulir
				$merek = htmlentities(strip_tags($this->input->post('merek')));
				$model = htmlentities(strip_tags($this->input->post('model')));
				$tahun = htmlentities(strip_tags($this->input->post('tahun')));
				$harga_jual = htmlentities(strip_tags($this->input->post('harga_jual')));
				$transmisi = htmlentities(strip_tags($this->input->post('transmisi')));
				$bahan_bakar = htmlentities(strip_tags($this->input->post('bahan_bakar')));
				$kapasitas_mesin = htmlentities(strip_tags($this->input->post('kapasitas_mesin')));
				$jenis_kendaraan = htmlentities(strip_tags($this->input->post('jenis_kendaraan')));

				// Jika kapasitas mesin custom, ambil nilai dari input manual
				if ($kapasitas_mesin == 'custom') {
					$kapasitas_mesin_manual = htmlentities(strip_tags($this->input->post('kapasitas_mesin_manual')));
					$kapasitas_mesin = $kapasitas_mesin_manual;
				}

				// Inisialisasi konfigurasi upload foto
				$config['upload_path'] = './foto/kendaraan/';
				$config['allowed_types'] = 'jpg|jpeg|png|gif';
				$config['max_size'] = 2048;

				$this->upload->initialize($config);

				$foto_path = null; // Default value for the photo path

				// Proses unggah foto jika ada perubahan
				if ($this->upload->do_upload('foto')) {
					// Jika berhasil upload, ambil nama file
					$upload_data = $this->upload->data();
					$foto_path = $upload_data['file_name'];

					// Compress the uploaded image
					$config['image_library'] = 'gd2';
					$config['source_image'] = './foto/kendaraan/' . $foto_path;
					$config['maintain_ratio'] = TRUE;
					$config['width'] = 800; // Set the desired width (you can set it to the original width)
					$config['height'] = 600; // Set the desired height (you can set it to the original height)
					$config['quality'] = '50%'; // Set the desired quality (adjust as needed)

					$this->image_lib->initialize($config);

					if (!$this->image_lib->resize()) {
						// Handle error resizing the image
						echo $this->image_lib->display_errors();
						exit;
					}

					$this->image_lib->clear();

					// Masukkan path foto ke dalam array
					$data['foto'] = $foto_path;
				}

				// Masukkan data ke dalam array
				$data = array(
					'merek' => $merek,
					'model' => $model,
					'tahun' => $tahun,
					'harga_jual' => $harga_jual,
					'transmisi' => $transmisi,
					'bahan_bakar' => $bahan_bakar,
					'kapasitas_mesin' => $kapasitas_mesin,
					'jenis_kendaraan' => $jenis_kendaraan,
					'foto' => $foto_path,
					// Tambahkan field lainnya sesuai kebutuhan
				);

				// Panggil model untuk menyimpan data
				$this->Harga_kendaraan_model->update_harga_kendaraan($id, $data);

				// Redirect atau tampilkan pesan sukses
				redirect('users/harga_kendaraan');
			}
		}
	}

	public function lap_sk()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Laporan Otorisasi Keluar | Melati-App";

			$this->load->view('users/header', $data);
			$this->load->view('users/laporan/lap_sk', $data);
			$this->load->view('users/footer');

			if (isset($_POST['data_lap'])) {
				$tgl1 = date('d-m-Y', strtotime(htmlentities(strip_tags($this->input->post('tgl1')))));
				$tgl2 = date('d-m-Y', strtotime(htmlentities(strip_tags($this->input->post('tgl2')))));

				redirect("users/data_sk/$tgl1/$tgl2");
			}
		}
	}

	public function data_sk($tgl1 = '', $tgl2 = '')
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {

			if ($tgl1 != '' and $tgl2 != '') {
				$data['sql'] = $this->db->query("SELECT * FROM tbl_sk WHERE (tgl_sk BETWEEN '$tgl1' AND '$tgl2') ORDER BY id_sk DESC");

				$data['user'] = $this->Mcrud->get_users_by_un($ceks);
				$data['judul_web'] = "Data Laporan Otorisasi Keluar | Melati-App";
				$this->load->view('users/header', $data);
				$this->load->view('users/laporan/data_sk', $data);
				$this->load->view('users/footer', $data);

				if (isset($_POST['btncetak'])) {
					redirect("users/cetak_sk/$tgl1/$tgl2");
				}
			} else {
				redirect('404_content');
			}
		}
	}


	public function cetak_sk($tgl1 = '', $tgl2 = '')
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {

			if ($tgl1 != '' and $tgl2 != '') {
				$data['sql'] = $this->db->query("SELECT * FROM tbl_sk WHERE (tgl_sk BETWEEN '$tgl1' AND '$tgl2') ORDER BY id_sk DESC");

				$data['user'] = $this->Mcrud->get_users_by_un($ceks);
				$data['judul_web'] = "Data Laporan Surat Keluar | Melati-App";

				$this->load->view('users/laporan/cetak_sk', $data);
			} else {
				redirect('404_content');
			}
		}
	}


	public function lap_sm()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Laporan Data Otorisasi | Melati-App";

			$this->load->view('users/header', $data);
			$this->load->view('users/laporan/lap_sm', $data);
			$this->load->view('users/footer');

			if (isset($_POST['data_lap'])) {
				$tgl1 = $this->input->post('tgl1');
				$tgl2 = $this->input->post('tgl2');

				redirect("users/data_sm/$tgl1/$tgl2");
			}
		}
	}

	public function data_sm($tgl1 = '', $tgl2 = '')
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {

			if ($tgl1 != '' and $tgl2 != '') {
				$data['sql'] = $this->db->query("SELECT * FROM tbl_sm WHERE (tgl_transaksi BETWEEN '$tgl1' AND '$tgl2') ORDER BY id_sm DESC");

				$data['user'] = $this->Mcrud->get_users_by_un($ceks);
				$data['judul_web'] = "Data Laporan Otorisasi | Melati-App";
				$data['tgl1'] = $tgl1;
				$data['tgl2'] = $tgl2;
				$this->load->view('users/header', $data);
				$this->load->view('users/laporan/data_sm', $data);
				$this->load->view('users/footer', $data);

				if (isset($_POST['btncetak'])) {
					redirect("users/cetak_sm/$tgl1/$tgl2");
				}
			} else {
				redirect('404_content');
			}
		}
	}

	public function cetak_sm($tgl1 = '', $tgl2 = '')
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {

			if ($tgl1 != '' and $tgl2 != '') {
				$data['sql'] = $this->db->query("SELECT * FROM tbl_sm WHERE (tgl_transaksi BETWEEN '$tgl1' AND '$tgl2') ORDER BY id_sm DESC");

				$data['user'] = $this->Mcrud->get_users_by_un($ceks);
				$data['judul_web'] = "Data Laporan Data Otorisasi | Melati-App";

				$this->load->view('users/laporan/cetak_sm', $data);
			} else {
				redirect('404_content');
			}
		}
	}

	public function data_sm_export($tgl1 = '', $tgl2 = '')
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		}

		if ($tgl1 != '' and $tgl2 != '') {
			$data = $this->db->query("SELECT * FROM tbl_sm WHERE (tgl_transaksi BETWEEN '$tgl1' AND '$tgl2') ORDER BY id_sm ASC")->result();

			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();

			// Set Judul
			$sheet->setCellValue('A1', 'Laporan Data Otorisasi');
			$sheet->mergeCells('A1:G1');
			$sheet->getStyle('A1')->getFont()->setSize(14)->setBold(true);
			$sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

			$sheet->setCellValue('A2', "Periode: $tgl1 s/d $tgl2");
			$sheet->mergeCells('A2:G2');
			$sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

			// Header kolom
			$sheet->setCellValue('A4', 'NO');
			$sheet->setCellValue('B4', 'TGL TRANSAKSI');
			$sheet->setCellValue('C4', 'NAMA ANGGOTA');
			$sheet->setCellValue('D4', 'NO REKENING');
			$sheet->setCellValue('E4', 'NOMINAL');
			$sheet->setCellValue('F4', 'STATUS');
			$sheet->setCellValue('G4', 'PENGIRIM');

			$sheet->getStyle('A4:G4')->getFont()->setBold(true);
			$sheet->getStyle('A4:G4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

			$row = 5;
			$no = 1;
			foreach ($data as $baris) {
				$sheet->setCellValue('A' . $row, $no);
				$sheet->setCellValue('B' . $row, $baris->tgl_transaksi); // Y-m-d
				$sheet->setCellValue('C' . $row, $baris->nama_anggota);
				$sheet->setCellValue('D' . $row, $baris->nomor_rekening);
				$sheet->setCellValue('E' . $row, 'Rp ' . number_format($baris->nominal, 0, ',', '.'));
				$sheet->setCellValue('F' . $row, $baris->dibaca);
				$sheet->setCellValue('G' . $row, $baris->pengirim);

				$sheet->getStyle('A' . $row . ':G' . $row)->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
				$sheet->getStyle('A' . $row . ':G' . $row)->getAlignment()->setWrapText(true);

				$row++;
				$no++;
			}

			// Otomatis lebar kolom
			foreach (range('A', 'G') as $col) {
				$sheet->getColumnDimension($col)->setAutoSize(true);
			}

			// Set nama file
			$filename = 'Laporan_Data_Otorisasi_' . $tgl1 . '_sd_' . $tgl2 . '.xlsx';
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header("Content-Disposition: attachment;filename=\"$filename\"");
			header('Cache-Control: max-age=0');

			$writer = new Xlsx($spreadsheet);
			$writer->save('php://output');
		} else {
			redirect('404_content');
		}
	}

	// Start Absensi
	public function absensi()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->helper('tanggal_helper');
			$bulan = $this->input->get('bulan') ? $this->input->get('bulan') : date('m');
			$tahun = $this->input->get('tahun') ? $this->input->get('tahun') : date('Y');

			// Mendapatkan ID user dari sesi	
			$id_user = $this->session->userdata('id_user@mt');

			// Perbarui device info pengguna ke dalam database
			$this->load->model('User_model');
			$device_info = $this->input->post('device_info'); // Ambil device info dari input tersembunyi
			if ($device_info) {
				$this->User_model->updateDeviceInfo($id_user, $device_info);
			}

			$hari = hari_bulan($bulan, $tahun);
			$data['hari'] = $hari;
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Absensi | MelatiApp";
			$data['absen'] = $this->absensi->get_absen($id_user, $bulan, $tahun);
			$data['bulan'] = $bulan;
			$data['tahun'] = $tahun;
			$data['all_bulan'] = bulan();

			$this->load->view('users/header', $data);
			$this->load->view('users/absensi/absen', $data);
			$this->load->view('users/footer');
		}
	}

	// Detail absensi
	public function detail_absensi()
	{
		$ceks = $this->session->userdata('user@mt');

		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->helper('tanggal_helper');
			$bulan = $this->input->get('bulan') ? $this->input->get('bulan') : date('m');
			$tahun = $this->input->get('tahun') ? $this->input->get('tahun') : date('Y');
			$hari = hari_bulan($bulan, $tahun);
			$user = $this->Mcrud->get_users_by_un($ceks);
			$now = date('H:i:s');


			$data['judul_web'] = "Detail Absensi | MelatiApp";
			$data['user'] = $user;
			$data['all_bulan'] = bulan();
			$id_user = $this->session->id_user;
			$data['hari'] = $hari;
			$data['bulan'] = $bulan;
			$data['tahun'] = $tahun;

			// Mengambil data absensi dari model (pastikan model Anda mengambil data dengan benar)
			$this->load->model('Absensi_model');
			$data['absen'] = $this->Absensi_model->get_absen($id_user, $bulan, $tahun);

			$this->load->view('users/header', $data);
			$this->load->view('users/absensi/detail', $data);
			$this->load->view('users/footer');
		}
	}

	public function check_absen()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Absensi_model');
			$this->load->model('Ucapan_model');
			$user = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Absensi | MelatiApp";
			$data['user'] = $user;
			$data['absen'] = $this->absensi->absen_harian_user($this->session->id_user)->num_rows();
			$data['jam_masuk'] = $this->Absensi_model->getJamMasukHariIni($this->session->id_user);
			$data['jam_pulang'] = $this->Absensi_model->getJamPulangHariIni($this->session->id_user);
			$data['keterangan'] = $this->Absensi_model->getKeterangan($this->session->id_user, date('Y-m-d'));

			$current_day = date('l');
			$data['ucapan_masuk_by_day'] = $this->Ucapan_model->get_ucapan_by_day($current_day, 'Masuk');
			$data['ucapan_pulang_by_day'] = $this->Ucapan_model->get_ucapan_by_day($current_day, 'Pulang');

			$data['ucapan_masuk_aktif'] = $this->Ucapan_model->get_ucapan_masuk_aktif();
			$data['ucapan_pulang_aktif'] = $this->Ucapan_model->get_ucapan_pulang_aktif();

			$data['kantor_pusat_01'] = $this->Mcrud->get_setting_by_key('kantor_pusat_01');
			$data['kantor_sedayu_02'] = $this->Mcrud->get_setting_by_key('kantor_sedayu_02');
			$data['kantor_sapuran_03'] = $this->Mcrud->get_setting_by_key('kantor_sapuran_03');
			$data['kantor_kertek_04'] = $this->Mcrud->get_setting_by_key('kantor_kertek_04');
			$data['kantor_wonosobo_05'] = $this->Mcrud->get_setting_by_key('kantor_wonosobo_05');
			$data['kantor_kaliwiro_06'] = $this->Mcrud->get_setting_by_key('kantor_kaliwiro_06');
			$data['kantor_banjarnegara_07'] = $this->Mcrud->get_setting_by_key('kantor_banjarnegara_07');
			$data['kantor_randusari_08'] = $this->Mcrud->get_setting_by_key('kantor_randusari_08');
			$data['kantor_kepil_09'] = $this->Mcrud->get_setting_by_key('kantor_kepil_09');

			$data['jarak_absen'] = $this->Mcrud->get_setting_by_key('jarak_absen');
			$data['titik_absen'] = $this->Mcrud->get_setting_by_key('titik_absen');
			$data['kantor_terdekat'] = $this->Mcrud->get_setting_by_key('kantor_terdekat');
			$data['marker'] = $this->Mcrud->get_setting_by_key('marker');

			$this->load->view('users/header', $data);
			$this->load->view('users/absensi/absen', $data);
			$this->load->view('users/footer', $data);
		}
	}

	// public function absen($keterangan)
	// {
	// 	$this->load->model('Absensi_model');

	// 	$latitude = $this->session->userdata('latitude');
	// 	$longitude = $this->session->userdata('longitude');

	// 	if (!$latitude || !$longitude) {
	// 		$this->session->set_flashdata('response', [
	// 			'status' => 'error',
	// 			'message' => 'Gagal mengirim data lokasi. Latitude dan longitude tidak valid.'
	// 		]);
	// 		redirect('users/check_absen');
	// 		return;
	// 	}

	// 	if ($this->uri->segment(3)) {
	// 		$keterangan = ucfirst($this->uri->segment(3));
	// 	} else {
	// 		$absen_harian = $this->Absensi_model->absen_harian_user($this->session->id_user)->num_rows();
	// 		$keterangan = ($absen_harian < 2 && $absen_harian < 1) ? 'Masuk' : 'Pulang';
	// 	}

	// 	$data = [
	// 		'tgl' => date('Y-m-d'),
	// 		'waktu' => date('H:i:s'),
	// 		'keterangan' => $keterangan,
	// 		'id_user' => $this->session->id_user,
	// 		'latitude' => $latitude,
	// 		'longitude' => $longitude
	// 	];

	// 	$result = $this->Absensi_model->insert_data_with_location($data);

	// 	if ($result) {
	// 		$this->session->set_flashdata('response', [
	// 			'status' => 'success',
	// 			'message' => 'Absensi berhasil dicatat'
	// 		]);
	// 	} else {
	// 		$this->session->set_flashdata('response', [
	// 			'status' => 'error',
	// 			'message' => 'Absensi gagal dicatat'
	// 		]);
	// 	}

	// 	redirect('users/check_absen');
	// }

	public function absen($keterangan)
	{
		$this->load->model('Absensi_model');

		// Mendapatkan data lokasi dan foto dari permintaan
		$latitude = $this->input->post('latitude');
		$longitude = $this->input->post('longitude');
		$photoData = $this->input->post('photo');

		// Jika keterangan bukan Izin, periksa apakah data lokasi dan foto sudah terkirim
		if ($keterangan !== 'Izin') {
			if (!$latitude || !$longitude || !$photoData) {
				$this->session->set_flashdata('response', [
					'status' => 'error',
					'message' => 'Gagal mengirim data lokasi atau foto tidak valid.'
				]);
				redirect('users/check_absen');
				return;
			}

			// Mendekode foto dari Base64 jika bukan Izin
			$photoFileName = uniqid() . '.jpg';
			$photoFilePath = './foto/foto_absen/absensi/' . $photoFileName;
			file_put_contents($photoFilePath, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $photoData)));
		} else {
			// Jika Izin, foto tidak diperlukan
			$photoFileName = null;
		}

		// Cek apakah ada segment 3 di URI untuk keterangan
		if ($this->uri->segment(3)) {
			$keterangan = ucfirst($this->uri->segment(3));
		} else {
			$absen_harian = $this->Absensi_model->absen_harian_user($this->session->id_user)->num_rows();
			$keterangan = ($absen_harian < 2 && $absen_harian < 1) ? 'Masuk' : 'Pulang';
		}

		$data = [
			'tgl' => date('Y-m-d'),
			'waktu' => date('H:i:s'),
			'keterangan' => $keterangan,
			'id_user' => $this->session->id_user,
			'latitude' => $latitude,
			'longitude' => $longitude,
			'foto_absen' => $photoFileName
		];

		$result = $this->Absensi_model->insert_data_with_location($data);

		if ($result) {
			$this->session->set_flashdata('response', [
				'status' => 'success',
				'message' => 'Absensi berhasil dicatat'
			]);
		} else {
			$this->session->set_flashdata('response', [
				'status' => 'error',
				'message' => 'Absensi gagal dicatat'
			]);
		}

		redirect('users/check_absen');
	}

	public function kurangi_cuti()
	{
		$this->load->model('User_model');
		$id_user = $this->session->userdata('id_user@mt');

		// Tidak perlu memeriksa apakah $id_user kosong, langsung lanjutkan
		// Anda bisa menambahkan pengecekan khusus untuk 0 jika perlu
		if ($this->User_model->kurangi_sisa_cuti($id_user)) {
			echo json_encode(['success' => true, 'message' => 'Sisa cuti berhasil dikurangi.']);
		} else {
			echo json_encode(['success' => false, 'message' => 'Gagal mengurangi sisa cuti.']);
		}
	}

	public function set_location_session()
	{
		$latitude = $this->input->post('latitude');
		$longitude = $this->input->post('longitude');

		// Validate latitude and longitude before setting them in the session
		if ($latitude !== null && $longitude !== null) {
			$this->session->set_userdata('latitude', $latitude);
			$this->session->set_userdata('longitude', $longitude);
			echo json_encode(['status' => 'success']);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Invalid latitude or longitude']);
		}
	}

	// Start bantuan absensi
	public function bantuan_absensi()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Bantuan Absensi | MelatiApp";

			$this->load->view('users/header', $data);
			$this->load->view('users/absensi/bantuan_absensi');
			$this->load->view('users/footer');
		}
	}
	// end bantuan absensi

	public function export_pdf()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->library('pdf');
			$this->load->model('Mcrud');
			$user = $this->Mcrud->get_users_by_un($ceks);
			if ($user) {
				$user = $user->row();
			} else {
				redirect('web/login');
			}

			$data = $this->detail_data_absen();
			$userNama = $user->nama_lengkap;
			$html_content = $this->load->view('users/absensi/print_pdf', $data, true);

			$filename = 'Absensi ' . $userNama . ' - ' . bulan($data['bulan']) . ' ' . $data['tahun'] . '.pdf';

			$this->pdf->loadHtml($html_content);
			$this->pdf->render();
			$this->pdf->stream($filename, ['Attachment' => 1]);
		}
	}

	// rekap absensi per user
	public function export_excel()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Mcrud');
			$user = $this->Mcrud->get_users_by_un($ceks);
			if ($user) {
				$user = $user->row();
			} else {
				redirect('web/login');
			}
			$data = $this->detail_data_absen();
			$hari = $data['hari'];
			$absen = $data['absen'];
			$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
			$userNama = $user->nama_lengkap;

			// Set properties
			$spreadsheet->getProperties()
				->setCreator('Melati-App')
				->setLastModifiedBy('Melati-App')
				->setTitle('Data Absensi')
				->setSubject('Absensi')
				->setDescription('Absensi ' . $userNama . ' bulan ' . bulan($data['bulan']) . ', ' . $data['tahun'])
				->setKeywords('data absen');

			// Define styles
			$styleCol = [
				'font' => ['bold' => true],
				'alignment' => [
					'horizontal' => Alignment::HORIZONTAL_CENTER,
					'vertical' => Alignment::VERTICAL_CENTER,
				],
				'borders' => [
					'top' => ['style' => Border::BORDER_THIN],
					'bottom' => ['style' => Border::BORDER_THIN],
					'right' => ['style' => Border::BORDER_THIN],
					'left' => ['style' => Border::BORDER_THIN],
				],
			];

			$styleRow = [
				'alignment' => [
					'vertical' => Alignment::VERTICAL_CENTER,
				],
				'borders' => [
					'top' => ['style' => Border::BORDER_THIN],
					'bottom' => ['style' => Border::BORDER_THIN],
					'right' => ['style' => Border::BORDER_THIN],
					'left' => ['style' => Border::BORDER_THIN],
				],
			];

			$styleRowLibur = [
				'fill' => [
					'fillType' => Fill::FILL_SOLID,
					'startColor' => ['rgb' => '343A40'],
				],
				'font' => [
					'color' => ['rgb' => 'FFFFFF'],
				],
				'alignment' => [
					'vertical' => Alignment::VERTICAL_CENTER,
				],
				'borders' => [
					'top' => ['style' => Border::BORDER_THIN],
					'bottom' => ['style' => Border::BORDER_THIN],
					'right' => ['style' => Border::BORDER_THIN],
					'left' => ['style' => Border::BORDER_THIN],
				],
			];

			$styleRowTidakMasuk = [
				'fill' => [
					'fillType' => Fill::FILL_SOLID,
					'startColor' => ['rgb' => 'DC3545'],
				],
				'font' => [
					'color' => ['rgb' => 'FFFFFF'],
				],
				'alignment' => [
					'vertical' => Alignment::VERTICAL_CENTER,
				],
				'borders' => [
					'top' => ['style' => Border::BORDER_THIN],
					'bottom' => ['style' => Border::BORDER_THIN],
					'right' => ['style' => Border::BORDER_THIN],
					'left' => ['style' => Border::BORDER_THIN],
				],
			];

			$styleTelat = [
				'font' => [
					'color' => ['rgb' => 'DC3545'],
				],
			];

			$styleLembur = [
				'font' => [
					'color' => ['rgb' => '28A745'],
				],
			];

			// Set content and styles
			$sheet->setCellValue('A1', 'Nama : ' . $userNama);
			$sheet->mergeCells('A1:D1');
			$sheet->getStyle('A1')->applyFromArray($styleCol);
			$sheet->getStyle('A1')->getFont()->setSize(12);

			$sheet->setCellValue('A2', 'Level : ' . $user->level);
			$sheet->mergeCells('A2:D2');
			$sheet->getStyle('A2')->applyFromArray($styleCol);
			$sheet->getStyle('A2')->getFont()->setSize(12);

			$sheet->setCellValue('A3', '');
			$sheet->mergeCells('A3:D3');

			$sheet->setCellValue('A4', 'Data Absensi Bulan ' . bulan($data['bulan']) . ', ' . $data['tahun']);
			$sheet->mergeCells('A4:D4');
			$sheet->getStyle('A4')->applyFromArray($styleCol);
			$sheet->getStyle('A4')->getFont()->setSize(12);

			$sheet->setCellValue('A5', 'NO');
			$sheet->setCellValue('B5', 'Tanggal');
			$sheet->setCellValue('C5', 'Jam Masuk');
			$sheet->setCellValue('D5', 'Jam Keluar');

			$sheet->getStyle('A5')->applyFromArray($styleCol);
			$sheet->getStyle('B5')->applyFromArray($styleCol);
			$sheet->getStyle('C5')->applyFromArray($styleCol);
			$sheet->getStyle('D5')->applyFromArray($styleCol);

			$numrow = 6;
			foreach ($hari as $i => $h) {
				$absen_harian = array_search($h['tgl'], array_column($absen, 'tgl')) !== false ? $absen[array_search($h['tgl'], array_column($absen, 'tgl'))] : '';

				$sheet->setCellValue('A' . $numrow, ($i + 1));
				$sheet->setCellValue('B' . $numrow, $h['hari'] . ', ' . $h['tgl']);
				$sheet->setCellValue('C' . $numrow, is_weekend($h['tgl']) ? 'Libur Akhir Pekan' : check_jam(@$absen_harian['jam_masuk'], 'masuk', true)['text']);
				$sheet->setCellValue('D' . $numrow, is_weekend($h['tgl']) ? 'Libur Akhir Pekan' : check_jam(@$absen_harian['jam_pulang'], 'pulang', true)['text']);

				if (check_jam(@$absen_harian['jam_masuk'], 'masuk', true)['status'] == 'telat') {
					$sheet->getStyle('C' . $numrow)->applyFromArray($styleTelat);
				}

				if (check_jam(@$absen_harian['jam_pulang'], 'pulang', true)['status'] == 'lembur') {
					$sheet->getStyle('D' . $numrow)->applyFromArray($styleLembur);
				}

				if (is_weekend($h['tgl'])) {
					$sheet->getStyle('A' . $numrow)->applyFromArray($styleRowLibur);
					$sheet->getStyle('B' . $numrow)->applyFromArray($styleRowLibur);
					$sheet->getStyle('C' . $numrow)->applyFromArray($styleRowLibur);
					$sheet->getStyle('D' . $numrow)->applyFromArray($styleRowLibur);
				} elseif ($absen_harian == '') {
					$sheet->getStyle('A' . $numrow)->applyFromArray($styleRowTidakMasuk);
					$sheet->getStyle('B' . $numrow)->applyFromArray($styleRowTidakMasuk);
					$sheet->getStyle('C' . $numrow)->applyFromArray($styleRowTidakMasuk);
					$sheet->getStyle('D' . $numrow)->applyFromArray($styleRowTidakMasuk);
				} else {
					$sheet->getStyle('A' . $numrow)->applyFromArray($styleRow);
					$sheet->getStyle('B' . $numrow)->applyFromArray($styleRow);
					$sheet->getStyle('C' . $numrow)->applyFromArray($styleRow);
					$sheet->getStyle('D' . $numrow)->applyFromArray($styleRow);
				}
				$numrow++;
			}

			$sheet->getColumnDimension('A')->setWidth(5);
			$sheet->getColumnDimension('B')->setWidth(25);
			$sheet->getColumnDimension('C')->setWidth(25);
			$sheet->getColumnDimension('D')->setWidth(25);
			$sheet->getDefaultRowDimension()->setRowHeight(-1);

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment; filename="Absensi ' . $userNama . ' - ' . bulan($data['bulan']) . ' ' . $data['tahun'] . '.xlsx"');
			header('Cache-Control: max-age=0');

			$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
			$writer->save('php://output');
		}
	}

	private function detail_data_absen()
	{

		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			// Mengambil informasi pengguna berdasarkan username (cek apakah Anda mendapatkan 'id_user' dari pengguna yang sedang login)
			$user_info = $this->Mcrud->get_users_by_un($ceks);
			$id_user = @$this->uri->segment(3) ? $this->uri->segment(3) : $user_info->row()->id_user;
			$bulan = @$this->input->get('bulan') ? $this->input->get('bulan') : date('m');
			$tahun = @$this->input->get('tahun') ? $this->input->get('tahun') : date('Y');

			$data['user'] = $user_info;
			$data['absen'] = $this->absensi->get_absen($id_user, $bulan, $tahun);
			$data['jam_kerja'] = (array) $this->jam->get_all();
			$data['all_bulan'] = bulan();
			$data['bulan'] = $bulan;
			$data['tahun'] = $tahun;
			$data['hari'] = hari_bulan($bulan, $tahun);
			return $data;
		}
	}
	// end rekap absensi per user

	public function absen_info()
	{
		$ceks = $this->session->userdata('user@mt');

		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Absen Info | MelatiApp";
			$this->load->model('Absensi_model');

			// Mengambil tanggal dari URL menggunakan input get
			$tanggal = $this->input->get('tgl') ? $this->input->get('tgl') : date('Y-m-d');
			$data['absensi'] = $this->Absensi_model->getAbsenByDate($tanggal);

			// Load view untuk mengedit informasi
			$this->load->view('users/header', $data);
			$this->load->view('users/absensi/absen_info', $data);
			$this->load->view('users/footer');
		}
	}

	// rekap semua absensi ke excel
	public function export_rekap_all()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Absensi_model');
			$bulan = $this->input->get('bulan') ?? date('m');
			$tahun = $this->input->get('tahun') ?? date('Y');

			// $data['rekap'] = array();

			// Get the list of users
			$users = $this->Mcrud->get_all_users();
			$summaryData = $this->detail_data_absen_all($bulan, $tahun);


			$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();

			// Set properties
			$spreadsheet->getProperties()
				->setCreator('Melati-App')
				->setLastModifiedBy('Melati-App')
				->setTitle('Data Rekap Absensi')
				->setSubject('Rekap Absensi')
				->setDescription('Rekap Absensi Seluruh Karyawan bulan ' . bulan($bulan) . ', ' . $tahun)
				->setKeywords('data rekap absen');

			// Define styles
			$styleCol = [
				'font' => ['bold' => true],
				'alignment' => [
					'horizontal' => Alignment::HORIZONTAL_CENTER,
					'vertical' => Alignment::VERTICAL_CENTER,
				],
				'borders' => [
					'top' => ['style' => Border::BORDER_THIN],
					'bottom' => ['style' => Border::BORDER_THIN],
					'right' => ['style' => Border::BORDER_THIN],
					'left' => ['style' => Border::BORDER_THIN],
				],
			];

			$styleRow = [
				'alignment' => [
					'vertical' => Alignment::VERTICAL_CENTER,
				],
				'borders' => [
					'top' => ['style' => Border::BORDER_THIN],
					'bottom' => ['style' => Border::BORDER_THIN],
					'right' => ['style' => Border::BORDER_THIN],
					'left' => ['style' => Border::BORDER_THIN],
				],
			];

			$styleRowLibur = [
				'fill' => [
					'fillType' => Fill::FILL_SOLID,
					'startColor' => ['rgb' => '343A40'],
				],
				'font' => [
					'color' => ['rgb' => 'FFFFFF'],
				],
				'alignment' => [
					'vertical' => Alignment::VERTICAL_CENTER,
				],
				'borders' => [
					'top' => ['style' => Border::BORDER_THIN],
					'bottom' => ['style' => Border::BORDER_THIN],
					'right' => ['style' => Border::BORDER_THIN],
					'left' => ['style' => Border::BORDER_THIN],
				],
			];

			$styleRowTidakMasuk = [
				'fill' => [
					'fillType' => Fill::FILL_SOLID,
					'startColor' => ['rgb' => 'DC3545'],
				],
				'font' => [
					'color' => ['rgb' => 'FFFFFF'],
				],
				'alignment' => [
					'vertical' => Alignment::VERTICAL_CENTER,
				],
				'borders' => [
					'top' => ['style' => Border::BORDER_THIN],
					'bottom' => ['style' => Border::BORDER_THIN],
					'right' => ['style' => Border::BORDER_THIN],
					'left' => ['style' => Border::BORDER_THIN],
				],
			];

			$styleTelat = [
				'font' => [
					'color' => ['rgb' => 'DC3545'],
				],
			];

			$styleLembur = [
				'font' => [
					'color' => ['rgb' => '28A745'],
				],
			];

			// Set content and styles
			$sheet->setCellValue('A1', 'Rekap Data Absensi Seluruh Karyawan ');
			$sheet->mergeCells('A1:G1');
			$sheet->getStyle('A1')->applyFromArray($styleCol);
			$sheet->getStyle('A1')->getFont()->setSize(14);

			$sheet->setCellValue('A2', 'Bulan: ' . bulan($bulan) . ', Tahun: ' . $tahun);
			$sheet->mergeCells('A2:G2');
			$sheet->getStyle('A2')->applyFromArray($styleCol);
			$sheet->getStyle('A2')->getFont()->setSize(12);

			$sheet->setCellValue('A3', 'NO');
			$sheet->setCellValue('B3', 'NAMA');
			$sheet->setCellValue('C3', 'HADIR');
			$sheet->setCellValue('D3', 'SETENGAH HARI');
			$sheet->setCellValue('E3', 'IZIN');
			$sheet->setCellValue('F3', 'CUTI');
			$sheet->setCellValue('G3', 'TIDAK MASUK');

			$sheet->getStyle('A3:G3')->applyFromArray($styleCol);

			$row = 4; // Start from row 4 for data placement
			$sequenceNumber = 1;

			foreach ($summaryData as $userId => $data) {
				$sheet->setCellValue('A' . $row, $sequenceNumber);
				$sheet->setCellValue('B' . $row, $data['nama_lengkap']);
				$sheet->setCellValue('C' . $row, $data['totalHadir']);
				$sheet->setCellValue('D' . $row, $data['totalSetengahHari']);
				$sheet->setCellValue('E' . $row, $data['totalIzin']);
				$sheet->setCellValue('F' . $row, $data['totalCuti']);
				$sheet->setCellValue('G' . $row, $data['totalTidakMasuk']);

				$sheet->getStyle('A' . $row . ':G' . $row)->applyFromArray($styleRow);
				$row++;
				$sequenceNumber++;
			}

			// Set column widths
			foreach (range('A', 'G') as $col) {
				$sheet->getColumnDimension($col)->setAutoSize(true);
			}

			// Set filename and download
			$filename = 'Rekap_Absensi_Seluruh_Karyawan_' . bulan($bulan) . '_' . $tahun . '.xlsx';
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="' . $filename . '"');
			header('Cache-Control: max-age=0');
			$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
			$writer->save('php://output');
		}
	}
	private function detail_data_absen_all($bulan, $tahun)
	{
		// Assuming you have a model for users and absensi
		$this->load->model('Mcrud');
		$this->load->model('Absensi_model');

		// Get all users
		$users = $this->Mcrud->get_all_users();

		// Initialize an array to store summary data for all users
		$summaryData = [];

		foreach ($users as $user) {
			// Get user information
			$userData = $this->Mcrud->get_users_by_un($user['username']);
			$userId = $userData->row()->id_user;

			// Get absensi data for the user for the specified month and year
			$userAbsensi = $this->Absensi_model->getAbsensi($userId, $bulan, $tahun);

			// Get Izin data
			$izinData = $this->Absensi_model->get_izin_cuti($userId, $bulan, $tahun, 'Izin');

			// Get Cuti data
			$cutiData = $this->Absensi_model->get_izin_cuti($userId, $bulan, $tahun, 'Cuti');


			// Initialize an array to store unique dates for attendance counting
			$uniqueDates = [];

			$totalHadir = 0;
			$totalSetengahHari = 0;
			$totalTidakMasuk = 0;
			$totalIzin = 0;
			$totalCuti = 0;

			foreach ($userAbsensi as $attendance) {
				$currentDate = $attendance['day'];

				// Check if there is "Masuk" for the same date
				$masukOnDate = ($attendance['keterangan'] == 'Masuk' && !in_array($currentDate, $uniqueDates));

				if ($masukOnDate) {
					// Consider "Masuk" only, but only count once per date
					$uniqueDates[] = $currentDate;

					// Check if "Pulang" is also present on the same date
					$pulangExist = array_reduce($userAbsensi, function ($carry, $item) use ($currentDate) {
						return $carry || ($item['keterangan'] == 'Pulang' && $item['day'] == $currentDate);
					}, false);

					if ($pulangExist) {
						// If "Pulang" is present on the same date, count as full day
						$totalHadir++;
					} else {
						// If no "Pulang" on the same date, count as half day
						$totalSetengahHari++;
					}
				} elseif ($attendance['keterangan'] == 'Pulang' && !in_array($currentDate, $uniqueDates)) {
					// Consider "Pulang" only, but only count once per date
					$uniqueDates[] = $currentDate;

					if (!$this->isWeekday($currentDate, $bulan, $tahun)) {
						// If "Pulang" on a weekend, count as half day
						$totalSetengahHari++;
					}
				}
			}

			// Calculate totalTidakMasuk by subtracting totalHadir from total working days
			$totalTidakMasuk = $this->getTotalWorkingDays($bulan, $tahun) - $totalHadir - $totalSetengahHari;

			foreach ($izinData as $izin) {
				// Count "izin"
				$totalIzin++;
			}

			foreach ($cutiData as $cuti) {
				// Count "cuti"
				$totalCuti++;
			}

			// Store the summary data for the user
			$summaryData[$userId] = [
				'nama_lengkap' => $userData->row()->nama_lengkap,
				'totalHadir' => $totalHadir,
				'totalSetengahHari' => $totalSetengahHari,
				'totalTidakMasuk' => $totalTidakMasuk,
				'totalIzin' => $totalIzin,
				'totalCuti' => $totalCuti,
			];
		}


		return $summaryData;
	}

	// Add a function to get the total working days in a month
	private function getTotalWorkingDays($bulan, $tahun)
	{
		$totalDaysInMonth = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
		$workingDays = 0;

		for ($day = 1; $day <= $totalDaysInMonth; $day++) {
			$currentDate = date("$tahun-$bulan-$day");

			// Check if the current date is a weekday (Monday to Friday)
			if (date('N', strtotime($currentDate)) <= 5) {
				$workingDays++;
			}
		}

		return $workingDays;
	}
	// end rekap semua absensi ke excel

	// public function countWorkingDays($start_date, $end_date)
	// {
	// 	$start = strtotime($start_date);
	// 	$end = strtotime($end_date);

	// 	$workingDays = 0;
	// 	while ($start <= $end) {
	// 		$dayOfWeek = date("N", $start);
	// 		if ($dayOfWeek < 6) { 
	// 			$workingDays++;
	// 		}
	// 		$start = strtotime("+1 day", $start);
	// 	}

	// 	return $workingDays;
	// }

	public function countWorkingDays($start_date, $end_date)
	{
		$start = strtotime($start_date);
		$end = strtotime($end_date);

		$workingDays = 0;
		$additionalWorkDays = 0; // To track additional workdays from attendance on weekends

		while ($start <= $end) {
			$dayOfWeek = date("N", $start);

			// Check if it's a weekday (Monday to Friday)
			if ($dayOfWeek < 6) {
				$workingDays++;
			}
			// Check if it's Saturday or Sunday, and add to additional days if there is an attendance record
			elseif ($dayOfWeek >= 6 && $this->hasAttendance(date("Y-m-d", $start))) {
				$additionalWorkDays++;
			}

			$start = strtotime("+1 day", $start);
		}

		return $workingDays + $additionalWorkDays;
	}

	// Example of a function to check attendance record
	public function hasAttendance($date)
	{
		// Query your database to check if there is an attendance record for the given date
		$this->db->where('tgl', $date);
		$query = $this->db->get('tbl_absensi'); // Assuming the attendance table is 'attendance'

		return $query->num_rows() > 0;
	}


	public function rekap_by_date_range()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Absensi_model');
			$this->load->helper('tanggal_helper');

			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Rekap Data Absensi | MelatiApp";

			// Set default value for tanggal_awal and tanggal_akhir
			$tanggal_awal = $this->input->get('tanggal_awal');
			if (empty($tanggal_awal)) {
				$tanggal_awal = date('Y-m-d'); // Default to today's date
			}
			$tanggal_akhir = $this->input->get('tanggal_akhir');
			if (empty($tanggal_akhir)) {
				$tanggal_akhir = date('Y-m-d'); // Default to today's date
			}

			$data['rekap'] = array();

			$users = $this->Mcrud->get_all_users_tgl_daftar();

			foreach ($users as $user) {
				$userAbsensi = $this->Absensi_model->getAbsensiByDateRange($user['id_user'], $tanggal_awal, $tanggal_akhir);
				$jamMasukPulang = $this->Absensi_model->getJamMasukPulangByDateRange($user['id_user'], $tanggal_awal, $tanggal_akhir);
				$hadirCount = $telatCount = $setengahHariCount = $izinCount = $cutiCount = $sakitCount = $tidakMasukCount = $perjalananTugasCount = 0;
				$absensiDetail = array();

				// Menggunakan array asosiatif untuk melacak keberadaan keterangan masuk dan pulang di setiap hari
				$attendanceByDay = array();

				foreach ($userAbsensi as $attendance) {
					// Mengisi array asosiatif dengan keterangan absensi
					$attendanceByDay[$attendance['day']][] = $attendance['keterangan'];
				}

				foreach ($attendanceByDay as $day => $attendance) {
					if (in_array('Masuk', $attendance) && in_array('Pulang', $attendance)) {
						// Cari jam masuk dan pulang untuk hari ini
						foreach ($jamMasukPulang as $jam) {
							if ($jam['day'] == $day && $jam['keterangan'] == 'Masuk') {
								$jamMasuk = strtotime($jam['waktu']);
								foreach ($jamMasukPulang as $pulang) {
									if ($pulang['day'] == $day && $pulang['keterangan'] == 'Pulang') {
										$jamPulang = strtotime($pulang['waktu']);
										$durasiKerja = ($jamPulang - $jamMasuk) / 3600;
										$jamTelat = strtotime('08:00:59');
										if ($durasiKerja < 7) {
											$setengahHariCount++;
										} elseif ($jamMasuk > $jamTelat) {
											$telatCount++;
										} else {
											$hadirCount++;
										}
										break; // Hentikan iterasi setelah menemukan jam pulang
									}
								}
								break; // Hentikan iterasi setelah menemukan jam masuk
							}
						}
					} elseif (in_array('Masuk', $attendance) && !in_array('Pulang', $attendance)) {
						// Jika hanya ada keterangan masuk, hitung sebagai setengah hari
						$setengahHariCount++;
					} else {
						if (empty($attendance)) {
							$tidakMasukCount++;
						} else {
							foreach ($attendance as $keterangan) {
								if ($keterangan == 'Izin') {
									$izinCount++;
								} elseif ($keterangan == 'Cuti') {
									$cutiCount++;
								} elseif ($keterangan == 'Sakit') {
									$sakitCount++;
								} elseif ($keterangan == 'Perjalanan_tugas') {
									$perjalananTugasCount++;
								}
							}
						}
					}
				}

				// Buat daftar semua tanggal dalam rentang tanggal yang dipilih
				$allDates = [];
				$start_date = strtotime($tanggal_awal);
				$end_date = strtotime($tanggal_akhir);

				for ($current_date = $start_date; $current_date <= $end_date; $current_date = strtotime('+1 day', $current_date)) {
					$allDates[] = date('Y-m-d', $current_date);
				}

				// Lakukan pengecekan untuk setiap tanggal
				foreach ($allDates as $date) {
					$tgl = date('d', strtotime($date));
					$absensiDetail[$tgl]['jam_masuk'] = '';
					$absensiDetail[$tgl]['jam_pulang'] = '';
					$absensiDetail[$tgl]['keterangan'] = ''; // Inisialisasi keterangan

					foreach ($jamMasukPulang as $absensi) {
						if ($absensi['day'] == $tgl) {
							$absensiDetail[$tgl]['jam_masuk'] = isset($absensi['waktu']) && $absensi['keterangan'] == 'Masuk' ? $absensi['waktu'] : '-';
							$absensiDetail[$tgl]['keterangan'] = $absensi['keterangan'];

							foreach ($jamMasukPulang as $pulang) {
								if ($pulang['day'] == $tgl && $pulang['keterangan'] == 'Pulang') {
									$absensiDetail[$tgl]['jam_pulang'] = isset($pulang['waktu']) ? $pulang['waktu'] : '-';
									break;
								}
							}
							break;
						}
					}

					if (empty($absensiDetail[$tgl]['keterangan'])) {
						foreach ($userAbsensi as $attendance) {
							if ($attendance['day'] == $tgl && ($attendance['keterangan'] == 'Izin' || $attendance['keterangan'] == 'Cuti' || $attendance['keterangan'] == 'Sakit' || $attendance['keterangan'] == 'Perjalanan_tugas')) {
								$absensiDetail[$tgl]['keterangan'] = $attendance['keterangan'];
								break;
							}
						}
					}
				}

				// Hitung total hari kerja antara tanggal_awal dan tanggal_akhir
				$totalWorkingDays = $this->countWorkingDays($tanggal_awal, $tanggal_akhir);

				// Menghitung total tidak masuk sebagai total hari kerja yang tidak memiliki keterangan masuk, pulang, atau cuti plus satu adalah kajian minggu
				$tidakMasukCount = $totalWorkingDays - ($hadirCount + $setengahHariCount + $izinCount + $cutiCount + $sakitCount + $perjalananTugasCount + $telatCount);
				$totalHadir = $hadirCount + $setengahHariCount;

				$data['rekap'][$user['id_user']] = array(
					'nama_lengkap' => $user['nama_lengkap'],
					'hadir' => $hadirCount,
					'setengah_hari' => $setengahHariCount,
					'telat' => $telatCount,
					'izin' => $izinCount,
					'cuti' => $cutiCount,
					'sakit' => $sakitCount,
					'perjalanan_tugas' => $perjalananTugasCount,
					'tidak_masuk' => $tidakMasukCount,
					'total_hadir' => $totalHadir,
					'tanggal_awal' => $tanggal_awal,
					'tanggal_akhir' => $tanggal_akhir,
					'absensi_detail' => $absensiDetail
				);
				$data['tanggal_awal'] = $tanggal_awal;
				$data['tanggal_akhir'] = $tanggal_akhir;
			}
			$data['totalWorkingDays'] = $totalWorkingDays;

			$this->load->view('users/header', $data);
			$this->load->view('users/absensi/rekap_by_date_range', $data);
			$this->load->view('users/footer');
		}
	}

	public function rekap_by_date_range_public()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Absensi_model');
			$this->load->helper('tanggal_helper');
			$id_user = $this->session->userdata('id_user');

			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Rekap Data Absensi | MelatiApp";

			// Set default value for tanggal_awal and tanggal_akhir
			$tanggal_awal = $this->input->get('tanggal_awal');
			if (empty($tanggal_awal)) {
				$tanggal_awal = date('Y-m-d'); // Default to today's date
			}
			$tanggal_akhir = $this->input->get('tanggal_akhir');
			if (empty($tanggal_akhir)) {
				$tanggal_akhir = date('Y-m-d'); // Default to today's date
			}

			$data['rekap'] = array();

			$users = $this->Mcrud->get_all_users_tgl_daftar_by_id_user($id_user);

			foreach ($users as $user) {
				$userAbsensi = $this->Absensi_model->getAbsensiByDateRange($user['id_user'], $tanggal_awal, $tanggal_akhir);
				$jamMasukPulang = $this->Absensi_model->getDetailAbsenByDateRange($user['id_user'], $tanggal_awal, $tanggal_akhir);
				$hadirCount = $telatCount = $setengahHariCount = $izinCount = $cutiCount = $sakitCount = $tidakMasukCount = $perjalananTugasCount = 0;
				$absensiDetail = array();

				// Menggunakan array asosiatif untuk melacak keberadaan keterangan masuk dan pulang di setiap hari
				$attendanceByDay = array();

				foreach ($userAbsensi as $attendance) {
					// Mengisi array asosiatif dengan keterangan absensi
					$attendanceByDay[$attendance['day']][] = $attendance['keterangan'];
				}

				foreach ($attendanceByDay as $day => $attendance) {
					if (in_array('Masuk', $attendance) && in_array('Pulang', $attendance)) {
						// Cari jam masuk dan pulang untuk hari ini
						foreach ($jamMasukPulang as $jam) {
							if ($jam['day'] == $day && $jam['keterangan'] == 'Masuk') {
								$jamMasuk = strtotime($jam['waktu']);
								foreach ($jamMasukPulang as $pulang) {
									if ($pulang['day'] == $day && $pulang['keterangan'] == 'Pulang') {
										$jamPulang = strtotime($pulang['waktu']);
										$durasiKerja = ($jamPulang - $jamMasuk) / 3600;
										$jamTelat = strtotime('08:00:59');
										if ($durasiKerja < 7) {
											$setengahHariCount++;
										} elseif ($jamMasuk > $jamTelat) {
											$telatCount++;
										} else {
											$hadirCount++;
										}
										break; // Hentikan iterasi setelah menemukan jam pulang
									}
								}
								break; // Hentikan iterasi setelah menemukan jam masuk
							}
						}
					} elseif (in_array('Masuk', $attendance) && !in_array('Pulang', $attendance)) {
						// Jika hanya ada keterangan masuk, hitung sebagai setengah hari
						$setengahHariCount++;
					} else {
						if (empty($attendance)) {
							$tidakMasukCount++;
						} else {
							foreach ($attendance as $keterangan) {
								if ($keterangan == 'Izin') {
									$izinCount++;
								} elseif ($keterangan == 'Cuti') {
									$cutiCount++;
								} elseif ($keterangan == 'Sakit') {
									$sakitCount++;
								} elseif ($keterangan == 'Perjalanan_tugas') {
									$perjalananTugasCount++;
								}
							}
						}
					}
				}

				// Buat daftar semua tanggal dalam rentang tanggal yang dipilih
				$allDates = [];
				$start_date = strtotime($tanggal_awal);
				$end_date = strtotime($tanggal_akhir);

				for ($current_date = $start_date; $current_date <= $end_date; $current_date = strtotime('+1 day', $current_date)) {
					$allDates[] = date('Y-m-d', $current_date);
				}

				// Lakukan pengecekan untuk setiap tanggal
				foreach ($allDates as $date) {
					$tgl = date('d', strtotime($date));
					$absensiDetail[$tgl]['jam_masuk'] = '';
					$absensiDetail[$tgl]['jam_pulang'] = '';
					$absensiDetail[$tgl]['keterangan'] = ''; // Inisialisasi keterangan

					foreach ($jamMasukPulang as $absensi) {
						if ($absensi['day'] == $tgl) {
							$absensiDetail[$tgl]['jam_masuk'] = isset($absensi['waktu']) && $absensi['keterangan'] == 'Masuk' ? $absensi['waktu'] : '-';
							$absensiDetail[$tgl]['keterangan'] = $absensi['keterangan'];

							foreach ($jamMasukPulang as $pulang) {
								if ($pulang['day'] == $tgl && $pulang['keterangan'] == 'Pulang') {
									$absensiDetail[$tgl]['jam_pulang'] = isset($pulang['waktu']) ? $pulang['waktu'] : '-';
									break;
								}
							}
							break;
						}
					}

					if (empty($absensiDetail[$tgl]['keterangan'])) {
						foreach ($userAbsensi as $attendance) {
							if ($attendance['day'] == $tgl && ($attendance['keterangan'] == 'Izin' || $attendance['keterangan'] == 'Cuti' || $attendance['keterangan'] == 'Sakit' || $attendance['keterangan'] == 'Perjalanan_tugas')) {
								$absensiDetail[$tgl]['keterangan'] = $attendance['keterangan'];
								break;
							}
						}
					}
				}

				// Hitung total hari kerja antara tanggal_awal dan tanggal_akhir
				$totalWorkingDays = $this->countWorkingDays($tanggal_awal, $tanggal_akhir);

				// Menghitung total tidak masuk sebagai total hari kerja yang tidak memiliki keterangan masuk, pulang, atau cuti plus satu adalah kajian minggu
				$tidakMasukCount = $totalWorkingDays - ($hadirCount + $setengahHariCount + $izinCount + $cutiCount + $sakitCount + $perjalananTugasCount + $telatCount);
				$totalHadir = $hadirCount + $setengahHariCount;

				$data['rekap'][$user['id_user']] = array(
					'nama_lengkap' => $user['nama_lengkap'],
					'hadir' => $hadirCount,
					'setengah_hari' => $setengahHariCount,
					'telat' => $telatCount,
					'izin' => $izinCount,
					'cuti' => $cutiCount,
					'sakit' => $sakitCount,
					'perjalanan_tugas' => $perjalananTugasCount,
					'tidak_masuk' => $tidakMasukCount,
					'total_hadir' => $totalHadir,
					'tanggal_awal' => $tanggal_awal,
					'tanggal_akhir' => $tanggal_akhir,
					'absensi_detail' => $absensiDetail
				);
				$data['tanggal_awal'] = $tanggal_awal;
				$data['tanggal_akhir'] = $tanggal_akhir;
			}
			$data['totalWorkingDays'] = $totalWorkingDays;

			$this->load->view('users/header', $data);
			$this->load->view('users/absensi/rekap_by_date_range_public', $data);
			$this->load->view('users/footer');
		}
	}

	public function rekap_by_date_range_manual()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Absensi_model_manual');
			$this->load->helper('tanggal_helper');

			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Rekap Data Absensi Manual | MelatiApp";

			// Set default value for tanggal_awal and tanggal_akhir
			$tanggal_awal = $this->input->get('tanggal_awal');
			if (empty($tanggal_awal)) {
				$tanggal_awal = date('Y-m-d'); // Default to today's date
			}
			$tanggal_akhir = $this->input->get('tanggal_akhir');
			if (empty($tanggal_akhir)) {
				$tanggal_akhir = date('Y-m-d'); // Default to today's date
			}

			$data['rekap'] = array();

			$users = $this->Mcrud->get_all_users_tgl_daftar_manual();

			foreach ($users as $user) {
				if ($user['level'] !== 'satpam') {
					continue;
				}
				$userAbsensi = $this->Absensi_model_manual->getAbsensiByDateRange($user['id_user'], $tanggal_awal, $tanggal_akhir);
				$jamMasukPulang = $this->Absensi_model_manual->getJamMasukPulangByDateRange($user['id_user'], $tanggal_awal, $tanggal_akhir);
				$hadirCount = $telatCount = $setengahHariCount = $izinCount = $cutiCount = $tidakMasukCount = $sakitCount = $perjalananTugasCount = 0;
				$absensiDetail = array();

				// Menggunakan array asosiatif untuk melacak keberadaan keterangan masuk dan pulang di setiap hari
				$attendanceByDay = array();

				foreach ($userAbsensi as $attendance) {
					// Mengisi array asosiatif dengan keterangan absensi
					$attendanceByDay[$attendance['day']][] = $attendance['keterangan'];
				}

				foreach ($attendanceByDay as $day => $attendance) {
					// Jika hanya ada keterangan masuk di hari tersebut, itu dihitung sebagai setengah hari
					if (in_array('Masuk', $attendance) && !in_array('Pulang', $attendance)) {
						$setengahHariCount++;
					} else {
						// Jika tidak ada keterangan absensi untuk hari itu, itu dihitung sebagai tidak masuk
						if (empty($attendance)) {
							$tidakMasukCount++;
						} else {
							// Jika ada keterangan lain selain masuk dan pulang, itu dihitung sesuai
							foreach ($attendance as $keterangan) {
								if ($keterangan == 'Masuk') {
									// Periksa apakah masuk telat atau tidak
									foreach ($jamMasukPulang as $jam) {
										if ($jam['day'] == $day && $jam['keterangan'] == 'Masuk') {
											$masukJam = strtotime($jam['waktu']);
											$masukJamPulang = strtotime('08:00:59'); // Waktu yang ditetapkan sebagai batas untuk tidak telat
											if ($masukJam > $masukJamPulang) {
												$telatCount++;
												$hadirCount++;
											} else {
												$hadirCount++;
											}
											break; // Hentikan iterasi setelah menemukan jam masuk
										}
									}
								} elseif ($keterangan == 'Izin') {
									$izinCount++;
								} elseif ($keterangan == 'Cuti') {
									$cutiCount++;
								} elseif ($keterangan == 'Sakit') {
									$sakitCount++;
								} elseif ($keterangan == 'Perjalanan_tugas') {
									$perjalananTugasCount++;
								} else {
									$tidakMasukCount++;
								}
							}
						}
					}
				}

				// Buat daftar semua tanggal dalam rentang tanggal yang dipilih
				$allDates = [];
				$start_date = strtotime($tanggal_awal);
				$end_date = strtotime($tanggal_akhir);

				for ($current_date = $start_date; $current_date <= $end_date; $current_date = strtotime('+1 day', $current_date)) {
					$allDates[] = date('Y-m-d', $current_date);
				}


				// Lakukan pengecekan untuk setiap tanggal
				foreach ($allDates as $date) {
					$tgl = date('d', strtotime($date));
					$absensiDetail[$tgl]['jam_masuk'] = '';
					$absensiDetail[$tgl]['jam_pulang'] = '';
					$absensiDetail[$tgl]['keterangan'] = ''; // Inisialisasi keterangan

					// Periksa apakah ada data absensi untuk tanggal ini
					foreach ($jamMasukPulang as $absensi) {
						if ($absensi['day'] == $tgl) {
							// Jika ada data absensi untuk tanggal ini, gunakan datanya
							$absensiDetail[$tgl]['jam_masuk'] = isset($absensi['waktu']) && $absensi['keterangan'] == 'Masuk' ? $absensi['waktu'] : '-';
							$absensiDetail[$tgl]['keterangan'] = $absensi['keterangan']; // Simpan keterangan absensi

							// Cek apakah ada data absensi untuk pulang
							foreach ($jamMasukPulang as $pulang) {
								if ($pulang['day'] == $tgl && $pulang['keterangan'] == 'Pulang') {
									// Jika ada data absensi untuk pulang, gunakan datanya
									$absensiDetail[$tgl]['jam_pulang'] = isset($pulang['waktu']) ? $pulang['waktu'] : '-';
									break; // Keluar dari loop jika data ditemukan
								}
							}

							break; // Keluar dari loop jika data ditemukan
						}
					}

					// Jika tidak ada data absensi untuk tanggal ini, tapi ada keterangan izin atau cuti
					if (empty($absensiDetail[$tgl]['keterangan'])) {
						foreach ($userAbsensi as $attendance) {
							if ($attendance['day'] == $tgl && ($attendance['keterangan'] == 'Izin' || $attendance['keterangan'] == 'Cuti' || $attendance['keterangan'] == 'Sakit' || $attendance['keterangan'] == 'Perjalanan_tugas')) {
								$absensiDetail[$tgl]['keterangan'] = $attendance['keterangan']; // Simpan keterangan izin atau cuti
								break; // Keluar dari loop jika data ditemukan
							}
						}
					}
				}

				// Hitung total hari kerja antara tanggal_awal dan tanggal_akhir
				$totalWorkingDays = $this->countWorkingDays($tanggal_awal, $tanggal_akhir);

				// Menghitung total tidak masuk sebagai total hari kerja yang tidak memiliki keterangan masuk, pulang, atau cuti
				$tidakMasukCount = $totalWorkingDays - ($hadirCount + $setengahHariCount + $izinCount + $cutiCount + $sakitCount + $perjalananTugasCount);
				$totalHadir = $hadirCount + $setengahHariCount;

				$data['rekap'][$user['id_user']] = array(
					'tgl_daftar' => $user['tgl_daftar'],
					'nama_lengkap' => $user['nama_lengkap'],
					'hadir' => $hadirCount,
					'setengah_hari' => $setengahHariCount,
					'telat' => $telatCount,
					'izin' => $izinCount,
					'cuti' => $cutiCount,
					'sakit' => $sakitCount,
					'perjalanan_tugas' => $perjalananTugasCount,
					'tidak_masuk' => $tidakMasukCount,
					'total_hadir' => $totalHadir,
					'tanggal_awal' => $tanggal_awal,
					'tanggal_akhir' => $tanggal_akhir,
					'absensi_detail' => $absensiDetail
				);
				$data['tanggal_awal'] = $tanggal_awal;
				$data['tanggal_akhir'] = $tanggal_akhir;
			}

			$this->load->view('users/header', $data);
			$this->load->view('users/absensi/rekap_by_date_range_manual', $data);
			$this->load->view('users/footer');
		}
	}

	public function export_rekap_by_date_range()
	{
		// Ambil tanggal_awal dan tanggal_akhir dari request
		$tanggal_awal = $this->input->get('tanggal_awal');
		$tanggal_akhir = $this->input->get('tanggal_akhir');

		// Periksa apakah tanggal_awal dan tanggal_akhir telah diisi
		if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
			// Panggil model Absensi_model untuk mendapatkan data absensi
			$this->load->model('Absensi_model');
			$users = $this->Mcrud->get_all_users_tgl_daftar(); // Mendapatkan semua id_user

			// Buat objek PhpSpreadsheet
			$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
			$sheet->setTitle('Rekap Absensi');

			// Array untuk format tanggal Indonesia
			$bulan_indonesia = [
				'01' => 'Januari',
				'02' => 'Februari',
				'03' => 'Maret',
				'04' => 'April',
				'05' => 'Mei',
				'06' => 'Juni',
				'07' => 'Juli',
				'08' => 'Agustus',
				'09' => 'September',
				'10' => 'Oktober',
				'11' => 'November',
				'12' => 'Desember'
			];

			// Format tanggal Indonesia untuk judul
			$tanggal_awal_format = date('d', strtotime($tanggal_awal)) . ' ' .
				$bulan_indonesia[date('m', strtotime($tanggal_awal))] . ' ' .
				date('Y', strtotime($tanggal_awal));
			$tanggal_akhir_format = date('d', strtotime($tanggal_akhir)) . ' ' .
				$bulan_indonesia[date('m', strtotime($tanggal_akhir))] . ' ' .
				date('Y', strtotime($tanggal_akhir));

			// Set logo dan judul file Excel (jika ada logo)
			// $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
			// $drawing->setName('Logo');
			// $drawing->setDescription('Logo');
			// $drawing->setPath('path/to/logo.png');
			// $drawing->setCoordinates('A1');
			// $drawing->setHeight(60);
			// $drawing->setWorksheet($sheet);

			// Styling judul
			$titleStyle = [
				'font' => [
					'bold' => true,
					'size' => 16,
					'color' => ['rgb' => '000000'],
				],
				'alignment' => [
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
					'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
				],
			];

			$subtitleStyle = [
				'font' => [
					'bold' => true,
					'size' => 12,
					'color' => ['rgb' => '444444'],
				],
				'alignment' => [
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
					'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
				],
			];

			// Set judul dan deskripsi file Excel
			$sheet->setCellValue('A1', 'REKAP DATA ABSENSI KARYAWAN');
			$sheet->mergeCells('A1:K1');
			$sheet->getStyle('A1')->applyFromArray($titleStyle);
			$sheet->getRowDimension(1)->setRowHeight(30);

			$sheet->setCellValue('A2', 'Periode: ' . $tanggal_awal_format . ' s/d ' . $tanggal_akhir_format);
			$sheet->mergeCells('A2:K2');
			$sheet->getStyle('A2')->applyFromArray($subtitleStyle);
			$sheet->getRowDimension(2)->setRowHeight(25);

			// Beri jarak antara judul dan tabel
			$sheet->getRowDimension(3)->setRowHeight(10);

			// Set judul kolom pada baris 4
			$headerRow = 4;
			$sheet->setCellValue('A' . $headerRow, 'NO');
			$sheet->setCellValue('B' . $headerRow, 'NAMA LENGKAP');
			$sheet->setCellValue('C' . $headerRow, 'HADIR LENGKAP');
			$sheet->setCellValue('D' . $headerRow, 'SETENGAH HARI');
			$sheet->setCellValue('E' . $headerRow, 'TELAT');
			$sheet->setCellValue('F' . $headerRow, 'IZIN');
			$sheet->setCellValue('G' . $headerRow, 'CUTI');
			$sheet->setCellValue('H' . $headerRow, 'SAKIT');
			$sheet->setCellValue('I' . $headerRow, 'PERJALANAN TUGAS');
			$sheet->setCellValue('J' . $headerRow, 'MANGKIR');
			$sheet->setCellValue('K' . $headerRow, 'TOTAL HADIR');

			// Set warna latar belakang untuk header
			$headerBackgroundColor = '2C3E50'; // Warna biru gelap modern
			$headerStyle = [
				'fill' => [
					'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
					'startColor' => ['rgb' => $headerBackgroundColor],
				],
				'font' => [
					'bold' => true,
					'color' => ['rgb' => 'FFFFFF'],
					'size' => 11,
				],
				'alignment' => [
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
					'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
				],
				'borders' => [
					'allBorders' => [
						'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
						'color' => ['rgb' => '000000'],
					],
				],
			];
			$sheet->getStyle('A' . $headerRow . ':K' . $headerRow)->applyFromArray($headerStyle);
			$sheet->getRowDimension($headerRow)->setRowHeight(20);

			// Set lebar kolom secara manual untuk tampilan yang lebih baik
			$sheet->getColumnDimension('A')->setWidth(6);
			$sheet->getColumnDimension('B')->setWidth(35);
			$sheet->getColumnDimension('C')->setWidth(15);
			$sheet->getColumnDimension('D')->setWidth(15);
			$sheet->getColumnDimension('E')->setWidth(15);
			$sheet->getColumnDimension('F')->setWidth(15);
			$sheet->getColumnDimension('G')->setWidth(15);
			$sheet->getColumnDimension('H')->setWidth(15);
			$sheet->getColumnDimension('I')->setWidth(20);
			$sheet->getColumnDimension('J')->setWidth(15);
			$sheet->getColumnDimension('K')->setWidth(15);

			// Isi data absensi ke file Excel
			$row = $headerRow + 1;

			// Warna baris selang-seling
			$evenColor = 'F5F5F5'; // Abu-abu sangat terang
			$oddColor = 'FFFFFF';  // Putih

			$dataStyle = [
				'borders' => [
					'allBorders' => [
						'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
						'color' => ['rgb' => 'C0C0C0'], // Warna border abu-abu terang
					],
				],
				'alignment' => [
					'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
				],
			];

			$centerStyle = [
				'alignment' => [
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				],
			];

			foreach ($users as $index => $user) {
				$userData = $this->Absensi_model->getUserData($user['id_user']);
				$rekapData = $this->Absensi_model->getUserRekapDataByDateRange($user['id_user'], $tanggal_awal, $tanggal_akhir);

				// Default nilai jika tidak ada
				$hadir = isset($rekapData['hadir']) ? $rekapData['hadir'] : 0;
				$setengah_hari = isset($rekapData['setengah_hari']) ? $rekapData['setengah_hari'] : 0;
				$telat = isset($rekapData['telat']) ? $rekapData['telat'] : 0;
				$izin = isset($rekapData['izin']) ? $rekapData['izin'] : 0;
				$cuti = isset($rekapData['cuti']) ? $rekapData['cuti'] : 0;
				$sakit = isset($rekapData['sakit']) ? $rekapData['sakit'] : 0;
				$perjalanan_tugas = isset($rekapData['perjalanan_tugas']) ? $rekapData['perjalanan_tugas'] : 0;
				$tidak_masuk = isset($rekapData['tidak_masuk']) ? $rekapData['tidak_masuk'] : 0;
				$total_hadir = isset($rekapData['total_hadir']) ? $rekapData['total_hadir'] : 0;

				// Mengisi nilai sel-sel dalam spreadsheet dengan data pengguna dan rekap yang diperoleh
				$sheet->setCellValue('A' . $row, $index + 1);
				$sheet->setCellValue('B' . $row, isset($userData['nama_lengkap']) ? $userData['nama_lengkap'] : '');
				$sheet->setCellValue('C' . $row, $hadir);
				$sheet->setCellValue('D' . $row, $setengah_hari);
				$sheet->setCellValue('E' . $row, $telat);
				$sheet->setCellValue('F' . $row, $izin);
				$sheet->setCellValue('G' . $row, $cuti);
				$sheet->setCellValue('H' . $row, $sakit);
				$sheet->setCellValue('I' . $row, $perjalanan_tugas);
				$sheet->setCellValue('J' . $row, $tidak_masuk);
				$sheet->setCellValue('K' . $row, $total_hadir);

				// Set style untuk cell yang berisi angka
				$sheet->getStyle('C' . $row . ':K' . $row)->applyFromArray($centerStyle);

				// Set background warna selang-seling
				$backgroundColor = ($index % 2 == 0) ? $evenColor : $oddColor;
				$sheet->getStyle('A' . $row . ':K' . $row)->applyFromArray([
					'fill' => [
						'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
						'startColor' => ['rgb' => $backgroundColor],
					],
				]);

				// Set border dan alignment
				$sheet->getStyle('A' . $row . ':K' . $row)->applyFromArray($dataStyle);
				$sheet->getStyle('A' . $row)->applyFromArray($centerStyle);

				// Set tinggi baris
				$sheet->getRowDimension($row)->setRowHeight(20);

				$row++;
			}

			// Tambahkan footer dengan tanggal cetak
			$row += 2;
			$sheet->setCellValue('A' . $row, 'Laporan dicetak pada: ' . date('d-m-Y H:i:s'));
			$sheet->mergeCells('A' . $row . ':K' . $row);
			$sheet->getStyle('A' . $row)->getFont()->setItalic(true);

			// Kunci panel atas agar header tetap terlihat saat scroll
			$sheet->freezePane('A' . ($headerRow + 1));

			// Auto filter untuk kolom header
			$sheet->setAutoFilter('A' . $headerRow . ':K' . $headerRow);

			// Set nama file dan header untuk file Excel
			$filename = 'Rekap_Absensi_' . date('d-m-Y', strtotime($tanggal_awal)) . '_sd_' . date('d-m-Y', strtotime($tanggal_akhir)) . '.xlsx';
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="' . $filename . '"');
			header('Cache-Control: max-age=0');

			// Output file Excel
			$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
			$writer->save('php://output');
		} else {
			// Tampilkan pesan jika tanggal_awal dan tanggal_akhir kosong
			$this->session->set_flashdata('msg', 'Tanggal awal dan tanggal akhir harus diisi');
			redirect('users/rekap_by_date_range');
		}
	}

	public function export_rekap_by_date_range_manual()
	{
		// Ambil tanggal_awal dan tanggal_akhir dari request
		$tanggal_awal = $this->input->get('tanggal_awal');
		$tanggal_akhir = $this->input->get('tanggal_akhir');

		// Periksa apakah tanggal_awal dan tanggal_akhir telah diisi
		if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
			// Panggil model Absensi_model untuk mendapatkan data absensi
			$this->load->model('Absensi_model_manual');
			$users = $this->Mcrud->get_all_users_tgl_daftar_manual(); // Mendapatkan semua id_user

			// Buat objek PhpSpreadsheet
			$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();

			// Set judul dan deskripsi file Excel
			$sheet->setCellValue('A1', 'Rekap Data Absensi Satpam');
			$sheet->mergeCells('A1:K1'); // Update merge range untuk kolom baru
			$sheet->getStyle('A1')->getFont()->setSize(16)->setBold(true);
			$sheet->setCellValue('A2', 'Periode: ' . $tanggal_awal . ' - ' . $tanggal_akhir);
			$sheet->mergeCells('A2:K2'); // Update merge range untuk kolom baru
			$sheet->getStyle('A2')->getFont()->setSize(14)->setBold(true);

			$sheet->getStyle('A1:K1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle('A2:K2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

			// Set judul kolom
			$sheet->setCellValue('A3', 'No');
			$sheet->setCellValue('B3', 'Nama Lengkap');
			$sheet->setCellValue('C3', 'Hadir Lengkap');
			$sheet->setCellValue('D3', 'Setengah Hari');
			$sheet->setCellValue('E3', 'Telat');
			$sheet->setCellValue('F3', 'Izin');
			$sheet->setCellValue('G3', 'Cuti');
			$sheet->setCellValue('H3', 'Sakit');
			$sheet->setCellValue('I3', 'Perjalanan Tugas'); // Tambah kolom perjalanan tugas setelah Sakit
			$sheet->setCellValue('J3', 'Tidak Masuk');
			$sheet->setCellValue('K3', 'Total Hadir');

			// Set warna latar belakang untuk header
			$headerBackgroundColor = '4CAF50'; // Warna hijau
			$sheet->getStyle('A3:K3')->applyFromArray([
				'fill' => [
					'fillType' => Fill::FILL_SOLID,
					'startColor' => ['rgb' => $headerBackgroundColor],
				],
				'font' => ['color' => ['rgb' => 'FFFFFF']],
			]);

			// Set style untuk header
			$headerStyle = [
				'font' => ['bold' => true],
				'alignment' => [
					'horizontal' => Alignment::HORIZONTAL_CENTER,
					'vertical' => Alignment::VERTICAL_CENTER,
				],
				'borders' => [
					'allBorders' => ['borderStyle' => Border::BORDER_THIN],
				],
			];
			$sheet->getStyle('A3:K3')->applyFromArray($headerStyle);

			// Isi data absensi ke file Excel
			$row = 4;
			$backgroundColor = ['FFFFFF', 'F2F2F2']; // Warna putih dan abu-abu
			foreach ($users as $user) {
				$userData = $this->Absensi_model_manual->getUserData($user['id_user']); // Mendapatkan data pengguna berdasarkan id_user
				$rekapData = $this->Absensi_model_manual->getUserRekapDataByDateRange($user['id_user'], $tanggal_awal, $tanggal_akhir); // Mendapatkan data rekap termasuk perjalanan_tugas

				// Mengisi nilai sel-sel dalam spreadsheet dengan data pengguna dan rekap yang diperoleh
				$sheet->setCellValue('A' . $row, $row - 3);
				$sheet->setCellValue('B' . $row, isset($userData['nama_lengkap']) ? $userData['nama_lengkap'] : '');
				$sheet->setCellValue('C' . $row, isset($rekapData['hadir']) ? $rekapData['hadir'] : '');
				$sheet->setCellValue('D' . $row, isset($rekapData['setengah_hari']) ? $rekapData['setengah_hari'] : '');
				$sheet->setCellValue('E' . $row, isset($rekapData['telat']) ? $rekapData['telat'] : '');
				$sheet->setCellValue('F' . $row, isset($rekapData['izin']) ? $rekapData['izin'] : '');
				$sheet->setCellValue('G' . $row, isset($rekapData['cuti']) ? $rekapData['cuti'] : '');
				$sheet->setCellValue('H' . $row, isset($rekapData['sakit']) ? $rekapData['sakit'] : '');
				$sheet->setCellValue('I' . $row, isset($rekapData['perjalanan_tugas']) ? $rekapData['perjalanan_tugas'] : ''); // Isi data perjalanan tugas setelah sakit
				$sheet->setCellValue('J' . $row, isset($rekapData['tidak_masuk']) ? $rekapData['tidak_masuk'] : '');
				$sheet->setCellValue('K' . $row, isset($rekapData['total_hadir']) ? $rekapData['total_hadir'] : '');

				// Set style untuk data
				$sheet->getStyle('A' . $row . ':K' . $row)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
				$sheet->getStyle('A' . $row . ':K' . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

				// Set latar belakang baris secara bergantian
				$backgroundIndex = $row % 2; // Bergantian antara 0 dan 1
				$sheet->getStyle('A' . $row . ':K' . $row)->applyFromArray([
					'fill' => [
						'fillType' => Fill::FILL_SOLID,
						'startColor' => ['rgb' => $backgroundColor[$backgroundIndex]],
					],
				]);

				$row++;
			}

			// Set lebar kolom secara otomatis berdasarkan konten
			foreach (range('A', 'K') as $col) { // Update range untuk kolom K
				$sheet->getColumnDimension($col)->setAutoSize(true);
			}

			// Set nama file dan header untuk file Excel
			$filename = 'Rekap_Absensi_' . date('Ymd') . '.xlsx';
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="' . $filename . '"');
			header('Cache-Control: max-age=0');

			// Output file Excel
			$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
			$writer->save('php://output');
		} else {
			// Tampilkan pesan jika tanggal_awal dan tanggal_akhir kosong
			$this->session->set_flashdata('msg', 'Tanggal awal dan tanggal akhir harus diisi');
			redirect('users/rekap_by_date_range_manual');
		}
	}

	public function export_detail_absensi()
	{
		$this->load->model('Absensi_model');

		// Dapatkan tanggal awal dan akhir dari request GET
		$tanggal_awal = $this->input->get('tanggal_awal');
		$tanggal_akhir = $this->input->get('tanggal_akhir');

		// Ambil data absensi dari model
		$users = $this->Mcrud->get_all_users_tgl_daftar();

		// Inisialisasi Spreadsheet Excel baru
		$spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		// Set judul worksheet
		$sheet->setTitle('Detail Absensi');

		// Styling untuk header
		$headerStyle = [
			'font' => [
				'bold' => true,
				'color' => ['rgb' => 'FFFFFF'],
			],
			'alignment' => [
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
			],
			'fill' => [
				'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
				'startColor' => ['rgb' => '4472C4'],
			],
			'borders' => [
				'allBorders' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					'color' => ['rgb' => '000000'],
				],
			],
		];

		// Tambahkan judul laporan pada baris pertama
		$sheet->mergeCells('A1:B1');
		$sheet->setCellValue('A1', 'LAPORAN DETAIL ABSENSI');
		$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
		$sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

		// Tambahkan rentang tanggal
		$sheet->mergeCells('A2:B2');
		$sheet->setCellValue('A2', 'Periode: ' . date('d F Y', strtotime($tanggal_awal)) . ' s/d ' . date('d F Y', strtotime($tanggal_akhir)));
		$sheet->getStyle('A2')->getFont()->setBold(true);
		$sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

		// Baris untuk header tabel
		$headerRow = 4;

		// Buat header kolom
		$sheet->setCellValue('A' . $headerRow, 'No');
		$sheet->setCellValue('B' . $headerRow, 'Nama Lengkap');

		// Array untuk nama hari dalam bahasa Indonesia
		$hari_indonesia = [
			'Sun' => 'Minggu',
			'Mon' => 'Senin',
			'Tue' => 'Selasa',
			'Wed' => 'Rabu',
			'Thu' => 'Kamis',
			'Fri' => 'Jumat',
			'Sat' => 'Sabtu'
		];

		// Array untuk nama bulan dalam bahasa Indonesia
		$bulan_indonesia = [
			'Jan' => 'Jan',
			'Feb' => 'Feb',
			'Mar' => 'Mar',
			'Apr' => 'Apr',
			'May' => 'Mei',
			'Jun' => 'Jun',
			'Jul' => 'Jul',
			'Aug' => 'Agt',
			'Sep' => 'Sep',
			'Oct' => 'Okt',
			'Nov' => 'Nov',
			'Dec' => 'Des'
		];

		// Menambah header tanggal sesuai rentang yang dipilih
		$start_date = strtotime($tanggal_awal);
		$end_date = strtotime($tanggal_akhir);
		$col = 'C'; // Mulai dari kolom C untuk tanggal

		$dates = [];
		for ($current_date = $start_date; $current_date <= $end_date; $current_date = strtotime('+1 day', $current_date)) {
			$day = date('d', $current_date);
			$month_eng = date('M', $current_date);
			$month = $bulan_indonesia[$month_eng];
			$tgl = date('Y-m-d', $current_date);
			$dates[] = $tgl;

			// Tambahkan nama hari dalam bahasa Indonesia dan tanggal di header
			$day_eng = date('D', $current_date);
			$nama_hari = $hari_indonesia[$day_eng];
			$sheet->setCellValue($col . $headerRow, $nama_hari . "\n" . $day . ' ' . $month);
			$sheet->getStyle($col . $headerRow)->getAlignment()->setWrapText(true);

			// Set lebar kolom tanggal secara otomatis
			$sheet->getColumnDimension($col)->setWidth(15);

			$col++;
		}

		// Terapkan style pada header
		$lastCol = --$col;
		$sheet->getStyle('A' . $headerRow . ':' . $lastCol . $headerRow)->applyFromArray($headerStyle);

		// Set lebar kolom
		$sheet->getColumnDimension('A')->setWidth(5);
		$sheet->getColumnDimension('B')->setWidth(30);

		// Isi data absensi ke dalam spreadsheet
		$row = $headerRow + 1; // Mulai dari baris setelah header
		$nomor = 1;

		// Style untuk baris data
		$dataStyle = [
			'borders' => [
				'allBorders' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					'color' => ['rgb' => '000000'],
				],
			],
		];

		// Style untuk absensi masuk & pulang
		$absenStyle = [
			'alignment' => [
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
			],
		];

		foreach ($users as $user) {
			$sheet->setCellValue('A' . $row, $nomor++);
			$sheet->setCellValue('B' . $row, $user['nama_lengkap']);

			// Center align nomor urut
			$sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

			$colData = 'C';
			foreach ($dates as $tgl) {
				// Ambil data absensi untuk tanggal tertentu
				$absensi = $this->Absensi_model->getDetailAbsenByDateRange($user['id_user'], $tgl, $tgl);

				$jam_masuk = '';
				$jam_pulang = '';
				$keterangan = '';

				if (!empty($absensi)) {
					foreach ($absensi as $absen) {
						if ($absen['keterangan'] == 'Masuk') {
							$jam_masuk = isset($absen['waktu']) ? date('H:i', strtotime($absen['waktu'])) : '';
						} elseif ($absen['keterangan'] == 'Pulang') {
							$jam_pulang = isset($absen['waktu']) ? date('H:i', strtotime($absen['waktu'])) : '';
						} else {
							$keterangan = $absen['keterangan'];
						}
					}
				}

				if (!empty($keterangan)) {
					if ($keterangan == 'Izin') {
						$sheet->setCellValue($colData . $row, 'Izin');
						$sheet->getStyle($colData . $row)->getFont()->getColor()->setARGB('FFFF0000');
						$sheet->getStyle($colData . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
					} elseif ($keterangan == 'Cuti') {
						$sheet->setCellValue($colData . $row, 'Cuti');
						$sheet->getStyle($colData . $row)->getFont()->getColor()->setARGB('FF0000FF');
						$sheet->getStyle($colData . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
					} elseif ($keterangan == 'Sakit') {
						$sheet->setCellValue($colData . $row, 'Sakit');
						$sheet->getStyle($colData . $row)->getFont()->getColor()->setARGB('FF800080');
						$sheet->getStyle($colData . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
					} elseif ($keterangan == 'Perjalanan_tugas') {
						$sheet->setCellValue($colData . $row, 'Perjalanan Tugas');
						$sheet->getStyle($colData . $row)->getFont()->getColor()->setARGB('FF008000'); // Hijau
						$sheet->getStyle($colData . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
					} else {
						$sheet->setCellValue($colData . $row, $keterangan);
						$sheet->getStyle($colData . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
					}
				} else {
					if (!empty($jam_masuk) || !empty($jam_pulang)) {
						// Format absensi: Masuk (atas) dan Pulang (bawah) dengan warna berbeda
						$sheet->setCellValue($colData . $row, "M: " . $jam_masuk . "\nP: " . $jam_pulang);
						$sheet->getStyle($colData . $row)->getAlignment()->setWrapText(true);
						$sheet->getStyle($colData . $row)->applyFromArray($absenStyle);

						// Jika weekend, beri highlight
						$dayOfWeek = date('w', strtotime($tgl));
						if ($dayOfWeek == 0 || $dayOfWeek == 6) {
							$sheet->getStyle($colData . $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
							$sheet->getStyle($colData . $row)->getFill()->getStartColor()->setARGB('FFFFE6E6');
						}
					} else {
						$sheet->setCellValue($colData . $row, '-');
						$sheet->getStyle($colData . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

						// Jika weekend, beri highlight
						$dayOfWeek = date('w', strtotime($tgl));
						if ($dayOfWeek == 0 || $dayOfWeek == 6) {
							$sheet->getStyle($colData . $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
							$sheet->getStyle($colData . $row)->getFill()->getStartColor()->setARGB('FFFFE6E6');
						}
					}
				}
				$colData++;
			}
			$row++;
		}

		// Terapkan border pada semua data
		$sheet->getStyle('A' . ($headerRow + 1) . ':' . $lastCol . ($row - 1))->applyFromArray($dataStyle);

		// Tambahkan footer dengan tanggal cetak
		$row += 2;
		$sheet->setCellValue('A' . $row, 'Dicetak pada: ' . date('d-m-Y H:i:s'));

		// Auto-filter untuk memudahkan pencarian dan penyaringan
		$sheet->setAutoFilter('A' . $headerRow . ':' . $lastCol . $headerRow);

		// Kunci panel atas agar header tetap terlihat saat scroll
		$sheet->freezePane('A' . ($headerRow + 1));

		// Set nama file
		$filename = 'Detail_Absensi_' . date('d-m-Y', strtotime($tanggal_awal)) . '_sd_' . date('d-m-Y', strtotime($tanggal_akhir)) . '.xlsx';

		// Output file Excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');

		$writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		$writer->save('php://output');
	}

	private function isWeekday($day, $bulan, $tahun)
	{
		$dayOfWeek = date('N', strtotime("$tahun-$bulan-$day"));
		return $dayOfWeek < 6;
	}
	// End Absensi 

	// Start kalender
	public function kalender()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Kalender | MelatiApp";

			$this->load->view('users/header', $data);
			$this->load->view('users/kalender/kalender');
			$this->load->view('users/footer');
		}
	}
	// end kalender

	// Info Melatiapp
	public function info_melatiapp()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Info Aplikasi | MelatiApp";

			$this->load->view('users/header', $data);
			$this->load->view('users/info_melatiapp/info_melatiapp');
			$this->load->view('users/footer');
		}
	}
	// end Info Melatiapp

	// Start usulan
	public function usulan_tambah()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Tambah Usulan| MelatiApp";

			$this->load->view('users/header', $data);
			$this->load->view('users/usulan/usulan_tambah');
			$this->load->view('users/footer');
		}
	}

	public function cek_nik()
	{
		$nik = $this->input->post('nik'); // Ambil input NIK dari request

		// Cek apakah NIK sudah ada di database
		$cek_nik = $this->db->get_where('tbl_usulan', ['nik' => $nik])->row();

		if ($cek_nik) {
			// Jika NIK sudah ada
			echo json_encode(['status' => 'error', 'message' => 'NIK sudah ada di data usulan apakah akan lanjut?']);
		} else {
			// Jika NIK belum terdaftar
			echo json_encode(['status' => 'success', 'message' => 'NIK tersedia.']);
		}
	}

	public function usulan_simpan()
	{
		// Check if the user is logged in
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			// Load the Usulan_model
			$this->load->model('Usulan_model');

			// Tangkap data dari formulir
			$nama = $this->input->post('nama');
			$nik = $this->input->post('nik');
			$tgl_lahir = $this->input->post('tgl_lahir');
			$tempat_lahir = $this->input->post('tempat_lahir');
			$jk = $this->input->post('jk');
			$pekerjaan = $this->input->post('pekerjaan');
			$alamat = $this->input->post('alamat');
			$provinsi = $this->input->post('provinsi');
			$kota_kabupaten = $this->input->post('kota_kabupaten');
			$kecamatan = $this->input->post('kecamatan');
			$kelurahan = $this->input->post('kelurahan');
			$kode_pos = $this->input->post('kode_pos');
			$negara = $this->input->post('negara');
			$nama_ibu = $this->input->post('nama_ibu');
			$status_kawin = $this->input->post('status_kawin');
			$status_pendidikan = $this->input->post('status_pendidikan');
			$tujuan = $this->input->post('tujuan');
			$nominal = $this->input->post('nominal');
			$telepon = $this->input->post('telepon');
			$jangka_waktu = $this->input->post('jangka_waktu');
			$jaminan = $this->input->post('jaminan');
			$tgl_pembukuan = $this->input->post('tgl_pembukuan');
			$sertifikat = $this->input->post('sertifikat');
			$an_sertifikat = $this->input->post('an_sertifikat');
			$luas = $this->input->post('luas');
			$nib = $this->input->post('nib');
			$alamat_lokasi = $this->input->post('alamat_lokasi');
			$batas = $this->input->post('batas');
			$bpkb = $this->input->post('bpkb');
			$merk = $this->input->post('merk');
			$jns_kendaraan = $this->input->post('jns_kendaraan');
			$no_pol = $this->input->post('no_pol');
			$no_rangka = $this->input->post('no_rangka');
			$no_mesin = $this->input->post('no_mesin');
			$thn_pembuatan = $this->input->post('thn_pembuatan');
			$warna = $this->input->post('warna');
			$an_bpkb = $this->input->post('an_bpkb');
			$alamat_bpkb = $this->input->post('alamat_bpkb');
			$lainnya = $this->input->post('lainnya');
			$id_user = $this->input->post('id_user');
			$kode_kantor = $this->input->post('kode_kantor');
			$cek_req = $this->input->post('cek_req');


			// Check if the form data is valid (you can add validation here)

			// Prepare the data to be inserted into the database
			$data = array(
				'nama' => $nama,
				'nik' => $nik,
				'tgl_lahir' => $tgl_lahir,
				'tempat_lahir' => $tempat_lahir,
				'jk' => $jk,
				'pekerjaan' => $pekerjaan,
				'alamat' => $alamat,
				'provinsi' => $provinsi,
				'kota_kabupaten' => $kota_kabupaten,
				'kecamatan' => $kecamatan,
				'kelurahan' => $kelurahan,
				'kode_pos' => $kode_pos,
				'negara' => $negara,
				'nama_ibu' => $nama_ibu,
				'status_kawin' => $status_kawin,
				'status_pendidikan' => $status_pendidikan,
				'tujuan' => $tujuan,
				'nominal' => $nominal,
				'telepon' => $telepon,
				'jangka_waktu' => $jangka_waktu,
				'jaminan' => $jaminan,
				'tgl_pembukuan' => $tgl_pembukuan,
				'sertifikat' => $sertifikat,
				'an_sertifikat' => $an_sertifikat,
				'luas' => $luas,
				'nib' => $nib,
				'alamat_lokasi' => $alamat_lokasi,
				'batas' => $batas,
				'bpkb' => $bpkb,
				'merk' => $merk,
				'jns_kendaraan' => $jns_kendaraan,
				'no_pol' => $no_pol,
				'no_rangka' => $no_rangka,
				'no_mesin' => $no_mesin,
				'thn_pembuatan' => $thn_pembuatan,
				'warna' => $warna,
				'an_bpkb' => $an_bpkb,
				'alamat_bpkb' => $alamat_bpkb,
				'lainnya' => $lainnya,
				'id_user' => $id_user,
				'kode_kantor' => $kode_kantor,
				'cek_req' => $cek_req
			);

			$foto_fields = ['foto_ktp'];
			$foto_names = [];

			foreach ($foto_fields as $field) {
				// Cek jika ada file yang dipilih
				if (!empty($_FILES[$field]['name'])) {
					$config['upload_path'] = './foto/foto_usulan/foto_ktp';
					$config['allowed_types'] = 'jpg|jpeg|png|gif'; // Format yang diizinkan
					$config['max_size'] = 20480; // Maksimum ukuran file 20MB
					$this->load->library('upload');

					$this->upload->initialize($config); // Inisialisasi pustaka upload dengan konfigurasi

					// Cek jika file berhasil diupload
					if (!$this->upload->do_upload($field)) {
						// Jika gagal upload, tampilkan pesan error
						$upload_error = $this->upload->display_errors();
						$this->session->set_flashdata('error', "Gagal mengupload $field: $upload_error");
						redirect('users/usulan_data'); // Kembali ke form jika gagal
					}

					// Ambil data file yang diupload
					$upload_data = $this->upload->data();
					$foto_names[$field] = $upload_data['file_name']; // Simpan nama file di array foto_names
				}
			}

			if (!empty($this->input->post('ttd'))) {
				$ttd_data = $this->input->post('ttd');
				$ttd_data = str_replace('data:image/png;base64,', '', $ttd_data); // Hapus prefix base64
				$ttd_data = base64_decode($ttd_data); // Decode base64 ke format biner

				// Tentukan nama file tanda tangan (hanya nama file, tanpa path)
				$ttd_filename = 'ttd_' . $nik . '_' . time() . '.png';

				// Tentukan path lengkap untuk menyimpan file tanda tangan
				$ttd_file = './foto/foto_usulan/foto_ttd/' . $ttd_filename;

				// Simpan file tanda tangan
				file_put_contents($ttd_file, $ttd_data);

				// Simpan hanya nama file di array foto_names
				$foto_names['ttd'] = $ttd_filename;
			}

			// Tambahkan nama file foto ke dalam data yang akan disimpan
			$data = array_merge($data, $foto_names); // Gabungkan data dengan foto_names

			// Insert data into the Usulan_model and check if the insertion was successful
			$inserted = $this->Usulan_model->insert_data($data);

			if ($inserted) {
				// Set a flash data message for a successful save
				$this->session->set_flashdata('msg', 'Data saved successfully');
			} else {
				// Set a flash data message for an error
				$this->session->set_flashdata('msg', 'Error: Data could not be saved');
			}

			// Redirect to a relevant page after saving the data
			redirect('users/usulan'); // You can modify this URL as needed
		}
	}

	public function usulan_data()
	{
		// Check if the user is logged in
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			// Load the Usulan_model
			$this->load->model('Usulan_model');

			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Data Usulan | MelatiApp";

			$cek = $data['user']->row();
			$level = $cek->level;
			$kode_kantor = $cek->kode_kantor;

			if ($level == 's_admin') {
				// S_ADMIN can see all usulan data
				$data['usulan_data'] = $this->Usulan_model->get_all_data_belum_survey();
			} elseif ($kode_kantor == '01') {
				// Surveyor can see usulan data greater than 20 million
				$data['usulan_data'] = $this->Usulan_model->get_usulan_data_pusat();
			} elseif ($kode_kantor !== '01') {
				// Cabang can see usulan data less than or equal to 20 million
				$data['usulan_data'] = $this->Usulan_model->get_usulan_data_cabang();
			} else {
				// For specific office codes (if needed), you can implement additional checks here
				$data['usulan_data'] = []; // No data for unauthorized access
			}

			$this->load->view('users/header', $data);
			$this->load->view('users/usulan/usulan_data', $data);
			$this->load->view('users/footer');
		}
	}

	// public function usulan()
	// {
	// 	$ceks = $this->session->userdata('user@mt');
	// 	if (!isset($ceks)) {
	// 		redirect('web/login');
	// 	} else {
	// 		$this->load->model('Usulan_model');
	// 		$data['user'] = $this->Mcrud->get_users_by_un($ceks);
	// 		$data['judul_web'] = "Data Usulan | MelatiApp";
	// 		$data['usulan_data'] = $this->Usulan_model->get_all_data();

	// 		$this->load->view('users/header', $data);
	// 		$this->load->view('users/usulan/usulan', $data);
	// 		$this->load->view('users/footer');
	// 	}
	// }

	public function usulan()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$id_user = $this->session->userdata('id_user');
			$usulan_type = $this->input->get('usulan_type', TRUE);
			if (!$usulan_type) {
				$usulan_type = 'usulan_saya';
			}

			$this->load->model('Usulan_model');

			if ($usulan_type == 'usulan_saya') {
				$data['usulan_data'] = $this->Usulan_model->get_all_data_by_id_user($id_user);
			} else {
				$data['usulan_data'] = $this->Usulan_model->get_all_data();
			}

			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Data Usulan | MelatiApp";
			$data['usulan_type'] = $usulan_type;

			$this->load->view('users/header', $data);
			$this->load->view('users/usulan/usulan', $data);
			$this->load->view('users/footer');
		}
	}

	public function usulan_by_id_user()
	{
		// Check if the user is logged in
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			// Load the Usulan_model
			$this->load->model('Usulan_model');
			$id_user = $this->session->userdata('id_user');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Data Usulan | MelatiApp";
			$data['usulan_data'] = $this->Usulan_model->get_all_data_by_id_user($id_user);

			$this->load->view('users/header', $data);
			$this->load->view('users/usulan/usulan', $data);
			$this->load->view('users/footer');
		}
	}

	public function usulan_edit($row_id)
	{
		// Check if the user is logged in
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			// Load the Usulan_model
			$this->load->model('Usulan_model');

			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Usulan Edit | MelatiApp";

			// Mengambil data survei berdasarkan ID baris
			$data['usulan_data'] = $this->Usulan_model->get_data_by_id($row_id);

			$this->load->view('users/header', $data);
			$this->load->view('users/usulan/usulan_edit', $data);
			$this->load->view('users/footer');
		}
	}

	public function update_usulan($row_id)
	{
		// Periksa apakah pengguna sudah login
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			// Load the Usulan_model
			$this->load->model('Usulan_model');

			// Validasi formulir jika diperlukan
			$this->form_validation->set_rules('nama', 'Nama Pemohon', 'required');
			// Tambahkan validasi untuk kolom-kolom lainnya

			if ($this->form_validation->run() === FALSE) {
				// Jika validasi gagal, kembali ke halaman formulir dengan pesan error
				$this->load->view('users/header', $data);
				$this->load->view('users/usulan/usulan_edit', $data);
				$this->load->view('users/footer');
			} else {
				// Jika validasi berhasil, simpan data survei ke dalam database
				$data = array(
					'nama' => $this->input->post('nama'),
					'nik' => $this->input->post('nik'),
					'tgl_lahir' => $this->input->post('tgl_lahir'),
					'tempat_lahir' => $this->input->post('tempat_lahir'),
					'jk' => $this->input->post('jk'),
					'pekerjaan' => $this->input->post('pekerjaan'),
					'alamat' => $this->input->post('alamat'),
					'nama_ibu' => $this->input->post('nama_ibu'),
					'tujuan' => $this->input->post('tujuan'),
					'nominal' => $this->input->post('nominal'),
					'telepon' => $this->input->post('telepon'),
					'jangka_waktu' => $this->input->post('jangka_waktu'),
					'jaminan' => $this->input->post('jaminan'),
					'tgl_pembukuan' => $this->input->post('tgl_pembukuan'),
					'sertifikat' => $this->input->post('sertifikat'),
					'an_sertifikat' => $this->input->post('an_sertifikat'),
					'luas' => $this->input->post('luas'),
					'nib' => $this->input->post('nib'),
					'alamat_lokasi' => $this->input->post('alamat_lokasi'),
					'batas' => $this->input->post('batas'),
					'bpkb' => $this->input->post('bpkb'),
					'merk' => $this->input->post('merk'),
					'jns_kendaraan' => $this->input->post('jns_kendaraan'),
					'no_pol' => $this->input->post('no_pol'),
					'no_rangka' => $this->input->post('no_rangka'),
					'no_mesin' => $this->input->post('no_mesin'),
					'thn_pembuatan' => $this->input->post('thn_pembuatan'),
					'warna' => $this->input->post('warna'),
					'an_bpkb' => $this->input->post('an_bpkb'),
					'alamat_bpkb' => $this->input->post('alamat_bpkb'),
					'status' => $this->input->post('status'),
					'lainnya' => $this->input->post('lainnya')
				);

				$foto_fields = ['foto_ktp'];
				$foto_names = [];

				foreach ($foto_fields as $field) {
					// Cek jika ada file yang dipilih
					if (!empty($_FILES[$field]['name'])) {
						$config['upload_path'] = './foto/foto_usulan/foto_ktp';
						$config['allowed_types'] = 'jpg|jpeg|png|gif'; // Format yang diizinkan
						$config['max_size'] = 20480; // Maksimum ukuran file 20MB
						$this->load->library('upload');

						$this->upload->initialize($config); // Inisialisasi pustaka upload dengan konfigurasi

						// Cek jika file berhasil diupload
						if (!$this->upload->do_upload($field)) {
							// Jika gagal upload, tampilkan pesan error
							$upload_error = $this->upload->display_errors();
							$this->session->set_flashdata('error', "Gagal mengupload $field: $upload_error");
							redirect('users/usulan/usulan_edit'); // Kembali ke form jika gagal
						}

						// Ambil data file yang diupload
						$upload_data = $this->upload->data();
						$foto_names[$field] = $upload_data['file_name']; // Simpan nama file di array foto_names
					}
				}

				if (!empty($this->input->post('ttd'))) {
					$ttd_data = $this->input->post('ttd');
					$ttd_data = str_replace('data:image/png;base64,', '', $ttd_data); // Hapus prefix base64
					$ttd_data = base64_decode($ttd_data); // Decode base64 ke format biner

					// Tentukan nama file tanda tangan (hanya nama file, tanpa path)
					$ttd_filename = 'ttd_' . $nik . '_' . time() . '.png';

					// Tentukan path lengkap untuk menyimpan file tanda tangan
					$ttd_file = './foto/foto_usulan/foto_ttd/' . $ttd_filename;

					// Simpan file tanda tangan
					file_put_contents($ttd_file, $ttd_data);

					// Simpan hanya nama file di array foto_names
					$foto_names['ttd'] = $ttd_filename;
				}

				// Tambahkan nama file foto ke dalam data yang akan disimpan
				$data = array_merge($data, $foto_names); // Gabungkan data dengan foto_names

				// Panggil model untuk menyimpan data
				$this->Usulan_model->update_usulan($row_id, $data);

				// Redirect atau tampilkan pesan sukses
				redirect('users/usulan/usulan');
			}
		}
	}

	public function usulan_data_sudah_survey()
	{
		// Check if the user is logged in
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			// Load the Usulan_model
			$this->load->model('Usulan_model');

			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Data Usulan | MelatiApp";

			$cek = $data['user']->row();
			$level = $cek->level;
			$kode_kantor = $cek->kode_kantor;

			if ($level == 's_admin') {
				// S_ADMIN can see all usulan data
				$data['usulan_data'] = $this->Usulan_model->get_all_data_sudah_survey();
			} elseif ($kode_kantor == '01') {
				// Surveyor can see usulan data greater than 20 million
				$data['usulan_data'] = $this->Usulan_model->get_all_data_sudah_survey_pusat();
			} elseif ($kode_kantor !== '01') {
				// Cabang can see usulan data less than or equal to 20 million
				$data['usulan_data'] = $this->Usulan_model->get_all_data_sudah_survey_cabang();
			} else {
				// In case of any invalid office code or unauthorized access
				$data['usulan_data'] = []; // No data for unauthorized access
			}

			// Load the views
			$this->load->view('users/header', $data);
			$this->load->view('users/usulan/usulan_data_sudah_survey', $data);
			$this->load->view('users/footer');
		}
	}


	public function usulan_survey($row_id)
	{
		// Check if the user is logged in
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			// Load the Usulan_model
			$this->load->model('Usulan_model');

			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Form Survey | MelatiApp";

			// Mengambil data survei berdasarkan ID baris
			$data['survey_data'] = $this->Usulan_model->get_survey_data_by_id($row_id);

			$this->load->view('users/header', $data);
			$this->load->view('users/usulan/usulan_survey', $data);
			$this->load->view('users/footer');
		}
	}

	public function usulan_survey_edit($row_id)
	{
		// Check if the user is logged in
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			// Load the Usulan_model
			$this->load->model('Usulan_model');

			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Form Edit Survey | MelatiApp";

			// Mengambil data survei berdasarkan ID baris
			$data['survey_data'] = $this->Usulan_model->get_survey_data_by_id($row_id);

			$this->load->view('users/header', $data);
			$this->load->view('users/usulan/usulan_survey_edit', $data);
			$this->load->view('users/footer');
		}
	}

	public function usulan_survey_manual($row_id)
	{
		// Check if the user is logged in
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			// Load the Usulan_model
			$this->load->model('Usulan_model');

			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Form Survey Manual | MelatiApp";

			// Mengambil data survei berdasarkan ID baris
			$data['survey_data'] = $this->Usulan_model->get_survey_data_by_id($row_id);

			$this->load->view('users/header', $data);
			$this->load->view('users/usulan/usulan_survey_manual', $data);
			$this->load->view('users/footer');
		}
	}

	public function usulan_hapus($id)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Usulan_model');
			$usulan = $this->Usulan_model->get_data_by_id($id);
			if (!$usulan) {
				// Proposal tidak ditemukan
				$response = array('status' => 'error', 'message' => 'Data not found');
				echo json_encode($response);
				return;
			}

			// Lakukan penghapusan
			$deleted = $this->Usulan_model->delete_data($id);

			if ($deleted) {
				$response = array('status' => 'success', 'message' => 'Data deleted successfully');
			} else {
				$response = array('status' => 'error', 'message' => 'Error: Data could not be deleted');
			}

			// Kembalikan respons JSON
			echo json_encode($response);
		}
	}

	public function usulan_detail($id)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('usulan_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Detail Usulan | MelatiApp";
			$data['usulan_detail'] = $this->usulan_model->getUsulanDetail($id);

			$this->load->view('users/header', $data);
			$this->load->view('users/usulan/usulan_detail', $data);
			$this->load->view('users/footer');
		}
	}

	public function usulan_laporan()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Laporan Data Usulan | Melati-App";

			$this->load->view('users/header', $data);
			$this->load->view('users/usulan/usulan_laporan', $data);
			$this->load->view('users/footer');

			if (isset($_POST['usulan_data_laporan'])) {
				$tgl1 = date('d-m-Y', strtotime(htmlentities(strip_tags($this->input->post('tgl1')))));
				$tgl2 = date('d-m-Y', strtotime(htmlentities(strip_tags($this->input->post('tgl2')))));

				redirect("users/usulan_data_laporan/$tgl1/$tgl2");
			}
		}
	}

	public function usulan_data_laporan($tgl1 = '', $tgl2 = '')
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Usulan_model');

			if ($tgl1 != '' && $tgl2 != '') {
				// Ensure the dates are correctly formatted as Y-m-d
				$tgl1 = date('Y-m-d', strtotime($tgl1));
				$tgl2 = date('Y-m-d', strtotime($tgl2));

				// Ensure no array is passed into the query
				$data['sql'] = $this->db->query("
                SELECT u.*, 
                    s.status_analisa, 
                    s.status_komite, 
                    s.keterangan, 
                    f.category, 
                    t_kelurahan.nama AS kelurahan_nama, 
                    t_kecamatan.nama AS kecamatan_nama, 
                    t_kota.nama AS kota_nama, 
                    t_provinsi.nama AS provinsi_nama
                FROM tbl_usulan u
                LEFT JOIN tbl_survey s ON u.id = s.id_pby
                LEFT JOIN t_kelurahan ON u.kelurahan = t_kelurahan.id
                LEFT JOIN t_kecamatan ON u.kecamatan = t_kecamatan.id
                LEFT JOIN t_kota ON u.kota_kabupaten = t_kota.id
                LEFT JOIN t_provinsi ON u.provinsi = t_provinsi.id
                LEFT JOIN tbl_file_user f ON u.id = f.id_pby
                WHERE u.tanggal BETWEEN '$tgl1' AND '$tgl2'
                ORDER BY u.id DESC
            ");

				// Continue with rendering
				$data['tgl1'] = $tgl1;
				$data['tgl2'] = $tgl2;
				$data['user'] = $this->Mcrud->get_users_by_un($ceks);
				$data['judul_web'] = "Data Laporan Usulan | Melati-App";
				$this->load->view('users/header', $data);
				$this->load->view('users/usulan/usulan_data_laporan', $data);
				$this->load->view('users/footer', $data);
			} else {
				redirect('404_content');
			}
		}
	}

	public function usulan_export_excel($tgl1, $tgl2)
	{
		// Load model
		$this->load->model('Usulan_model');

		// Query data berdasarkan tanggal yang diberikan
		$this->db->select('u.*, s.status_analisa, s.status_komite, s.keterangan, f.category,
						   t_kelurahan.nama AS kelurahan_nama, 
						   t_kecamatan.nama AS kecamatan_nama, 
						   t_kota.nama AS kota_nama, 
						   t_provinsi.nama AS provinsi_nama');
		$this->db->from('tbl_usulan u');
		$this->db->join('tbl_survey s', 'u.id = s.id_pby', 'left');
		$this->db->join('t_kelurahan', 'u.kelurahan = t_kelurahan.id', 'left');
		$this->db->join('t_kecamatan', 'u.kecamatan = t_kecamatan.id', 'left');
		$this->db->join('t_kota', 'u.kota_kabupaten = t_kota.id', 'left');
		$this->db->join('t_provinsi', 'u.provinsi = t_provinsi.id', 'left');
		$this->db->join('tbl_file_user f', 'u.id = f.id_pby', 'left');

		// Corrected date range condition
		$this->db->where('u.tanggal >=', $tgl1);
		$this->db->where('u.tanggal <=', $tgl2);

		$data['sql'] = $this->db->get()->result();

		// Check if data is empty
		if (empty($data['sql'])) {
			exit('No data found for the selected date range.');
		}

		// Create Spreadsheet object
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		// Set Excel header
		$sheet->setCellValue('A1', 'No')
			->setCellValue('B1', 'Tanggal')
			->setCellValue('C1', 'Nama Anggota')
			->setCellValue('D1', 'NIK')  // Tambahan header baru
			->setCellValue('E1', 'Tanggal Lahir')
			->setCellValue('F1', 'Tempat Lahir')
			->setCellValue('G1', 'Jenis Kelamin')
			->setCellValue('H1', 'Status Kawin')
			->setCellValue('I1', 'Nama Ibu')
			->setCellValue('J1', 'Kode Pos')
			->setCellValue('K1', 'Nominal')  // Tambahkan kolom nominal setelah Kode Pos
			->setCellValue('L1', 'Tujuan')
			->setCellValue('M1', 'Status Survey')
			->setCellValue('N1', 'Alamat')
			->setCellValue('O1', 'Kelurahan')
			->setCellValue('P1', 'Kecamatan')
			->setCellValue('Q1', 'Kota')
			->setCellValue('R1', 'Provinsi')
			->setCellValue('S1', 'Kode Kantor')
			->setCellValue('T1', 'Nama User');  // Mengubah menjadi Nama User

		// Apply header styling (bold, background color, and center alignment)
		$styleArray = [
			'font' => [
				'bold' => true,
				'size' => 12,
			],
			'alignment' => [
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
			],
			'fill' => [
				'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
				'startColor' => [
					'rgb' => '4CAF50', // Green color (you can change this)
				],
			],
			'borders' => [
				'allBorders' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					'color' => ['rgb' => '000000'], // Black borders
				],
			],
		];

		// Apply styles to the header row (A1:T1)
		$sheet->getStyle('A1:T1')->applyFromArray($styleArray);

		// Fill data from the query into the Excel sheet
		$row = 2; // starting row
		$no = 1;
		foreach ($data['sql'] as $baris) {
			// Dapatkan nama user berdasarkan id_user
			$nama_user = $this->Usulan_model->getUsernameById($baris->id_user); // Mengambil nama user berdasarkan id_user

			$sheet->setCellValue('A' . $row, $no++)
				->setCellValue('B' . $row, date('d-m-Y', strtotime($baris->tanggal)))
				->setCellValue('C' . $row, $baris->nama)
				->setCellValueExplicit('D' . $row, $baris->nik, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)  // Kolom NIK, menggunakan setCellValueExplicit sebagai STRING
				->setCellValue('E' . $row, date('d-m-Y', strtotime($baris->tgl_lahir)))  // Kolom Tanggal Lahir
				->setCellValue('F' . $row, $baris->tempat_lahir)  // Kolom Tempat Lahir
				->setCellValue('G' . $row, $baris->jk)  // Kolom Jenis Kelamin
				->setCellValue('H' . $row, $baris->status_kawin)  // Kolom Status Kawin
				->setCellValue('I' . $row, $baris->nama_ibu)  // Kolom Nama Ibu
				->setCellValue('J' . $row, $baris->kode_pos)  // Kolom Kode Pos
				->setCellValue('K' . $row, $baris->nominal)  // Kolom Nominal yang ditambahkan
				->setCellValue('L' . $row, $baris->tujuan)
				->setCellValue('M' . $row, $baris->status_survey)
				->setCellValue('N' . $row, $baris->alamat)
				->setCellValue('O' . $row, $baris->kelurahan_nama)
				->setCellValue('P' . $row, $baris->kecamatan_nama)
				->setCellValue('Q' . $row, $baris->kota_nama)
				->setCellValue('R' . $row, $baris->provinsi_nama)
				->setCellValue('S' . $row, $baris->kode_kantor)
				->setCellValue('T' . $row, $nama_user); // Isi dengan nama user

			$row++;
		}

		// Create Excel file and export
		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		$filename = 'Laporan_Usulan_' . date('Ymd', strtotime($tgl1)) . '_' . date('Ymd', strtotime($tgl2)) . '.xlsx';

		// Clean the output buffer to avoid download issues
		ob_end_clean();

		// Set headers and output the Excel file
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');

		// Save the Excel file directly to output stream
		$writer->save('php://output');
	}

	public function update_survey($row_id)
	{
		// Periksa apakah pengguna sudah login
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			// Load the Usulan_model
			$this->load->model('Usulan_model');

			// Validasi formulir jika diperlukan
			$this->form_validation->set_rules('nama', 'Nama Pemohon', 'required');
			// Tambahkan validasi untuk kolom-kolom lainnya

			if ($this->form_validation->run() === FALSE) {
				// Jika validasi gagal, kembali ke halaman formulir dengan pesan error
				$this->load->view('users/header', $data);
				$this->load->view('users/usulan/usulan_survey', $data);
				$this->load->view('users/footer');
			} else {
				// Jika validasi berhasil, simpan data survei ke dalam database
				$data = array(
					'surveyor' => $this->input->post('surveyor'),
					// 'kode_kantor' => $this->input->post('kode_kantor'),
					'id_pby' => $this->input->post('id_pby'),
					// 'nama' => $this->input->post('nama'),
					// 'nik' => $this->input->post('nik'),
					// 'tgl_lahir' => $this->input->post('tgl_lahir'),
					// 'tempat_lahir' => $this->input->post('tempat_lahir'),
					// 'jk' => $this->input->post('jk'),
					// 'alamat' => $this->input->post('alamat'),
					// 'nama_ibu' => $this->input->post('nama_ibu'),
					'alamat_usaha' => $this->input->post('alamat_usaha'),
					// 'pekerjaan' => $this->input->post('pekerjaan'),
					'pekerjaan_sampingan' => $this->input->post('pekerjaan_sampingan'),
					// 'nominal' => $this->input->post('nominal'),
					'riwayat_pembiayaan' => $this->input->post('riwayat_pembiayaan'),
					// 'tujuan' => $this->input->post('tujuan'),
					'bidang_usaha' => $this->input->post('bidang_usaha'),
					'sumber_pelunasan' => $this->input->post('sumber_pelunasan'),
					// 'telepon' => $this->input->post('telepon'),
					// 'jangka_waktu' => $this->input->post('jangka_waktu'),
					// 'jaminan' => $this->input->post('jaminan'),
					'tgl_survey' => $this->input->post('tgl_survey'),
					'jam_mulai' => $this->input->post('jam_mulai'),
					'jam_selesai' => $this->input->post('jam_selesai'),
					'tempat_survey' => $this->input->post('tempat_survey'),
					'kondisi_rumah' => $this->input->post('kondisi_rumah'),
					'kekayaan1' => $this->input->post('kekayaan1'),
					'harga_taksiran1' => $this->input->post('harga_taksiran1'),
					'kekayaan2' => $this->input->post('kekayaan2'),
					'harga_taksiran2' => $this->input->post('harga_taksiran2'),
					'sumber_info' => $this->input->post('sumber_info'),
					'penjualan_usaha' => $this->input->post('penjualan_usaha'),
					'jml_penjualan' => $this->input->post('jml_penjualan'),
					'hrg_pokok_brg' => $this->input->post('hrg_pokok_brg'),
					'biaya_usaha' => $this->input->post('biaya_usaha'),
					'laba_usaha' => $this->input->post('laba_usaha'),
					'laba_usaha_bayar' => $this->input->post('laba_usaha_bayar'),
					'pendapatan_istri' => $this->input->post('pendapatan_istri'),
					'pendapatan_lain' => $this->input->post('pendapatan_lain'),
					'jml_pendapatan_diterima' => $this->input->post('jml_pendapatan_diterima'),
					'biaya_rt' => $this->input->post('biaya_rt'),
					'biaya_pendidikan' => $this->input->post('biaya_pendidikan'),
					'biaya_lain' => $this->input->post('biaya_lain'),
					'jml_pengeluaran' => $this->input->post('jml_pengeluaran'),
					'pendapatan_bersih' => $this->input->post('pendapatan_bersih'),
					'lending_maksimal' => $this->input->post('lending_maksimal'),
					// 'bpkb' => $this->input->post('bpkb'),
					// 'jns_kendaraan' => $this->input->post('jns_kendaraan'),
					// 'thn_pembuatan' => $this->input->post('thn_pembuatan'),
					// 'merk' => $this->input->post('merk'),
					// 'no_mesin' => $this->input->post('no_mesin'),
					'tipe' => $this->input->post('tipe'),
					// 'no_rangka' => $this->input->post('no_rangka'),
					// 'no_pol' => $this->input->post('no_pol'),
					'kepemilikan' => $this->input->post('kepemilikan'),
					'an' => $this->input->post('an'),
					'an_alamat' => $this->input->post('an_alamat'),
					'nilai_pasar' => $this->input->post('nilai_pasar'),
					'nilai_likuid' => $this->input->post('nilai_likuid'),
					// 'sertifikat' => $this->input->post('sertifikat'),
					// 'an_sertifikat' => $this->input->post('an_sertifikat'),
					// 'luas' => $this->input->post('luas'),
					// 'alamat_lokasi' => $this->input->post('alamat_lokasi'),
					'lokasi' => $this->input->post('lokasi'),
					'kecamatan' => $this->input->post('kecamatan'),
					'jarak' => $this->input->post('jarak'),
					'capai_lokasi' => $this->input->post('capai_lokasi'),
					'bentuk_tanah' => $this->input->post('bentuk_tanah'),
					'jenis_tanah' => $this->input->post('jenis_tanah'),
					'akses_jalan' => $this->input->post('akses_jalan'),
					'nilai_pasar_wajar' => $this->input->post('nilai_pasar_wajar'),
					'nilai_likuid_t' => $this->input->post('nilai_likuid_t'),
					'kepemilikan_t' => $this->input->post('kepemilikan_t'),
					'catatan' => $this->input->post('catatan'),
					'checklist' => $this->input->post('checklist'),
				);


				$foto_fields = ['foto_jaminan_1', 'foto_jaminan_1', 'foto_jaminan_2', 'foto_jaminan_3', 'foto_jaminan_4'];
				$foto_names = [];

				foreach ($foto_fields as $field) {
					// Cek jika ada file yang dipilih
					if (!empty($_FILES[$field]['name'])) {
						$config['upload_path'] = './foto/foto_usulan/';
						$config['allowed_types'] = 'jpg|jpeg|png|gif'; // Format yang diizinkan
						$config['max_size'] = 20480; // Maksimum ukuran file 20MB
						$this->load->library('upload');

						$this->upload->initialize($config); // Inisialisasi pustaka upload dengan konfigurasi

						// Cek jika file berhasil diupload
						if (!$this->upload->do_upload($field)) {
							// Jika gagal upload, tampilkan pesan error
							$upload_error = $this->upload->display_errors();
							$this->session->set_flashdata('error', "Gagal mengupload $field: $upload_error");
							redirect('users/usulan/usulan_survey'); // Kembali ke form jika gagal
						}

						// Ambil data file yang diupload
						$upload_data = $this->upload->data();
						$foto_names[$field] = $upload_data['file_name']; // Simpan nama file di array foto_names
					}
				}

				// Tambahkan nama file foto ke dalam data yang akan disimpan
				$data = array_merge($data, $foto_names); // Gabungkan data dengan foto_names

				// Panggil model untuk menyimpan data
				$this->Usulan_model->insert_survey_data($data);
				$this->Usulan_model->set_status_survey($row_id, 1);

				// Redirect atau tampilkan pesan sukses
				redirect('users/usulan/usulan_data');
			}
		}
	}

	public function update_survey_manual($row_id)
	{
		// Periksa apakah pengguna sudah login
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			// Load the Usulan_model
			$this->load->model('Usulan_model');

			// Validasi formulir jika diperlukan
			$this->form_validation->set_rules('nama', 'Nama Pemohon', 'required');
			// Tambahkan validasi untuk kolom-kolom lainnya

			if ($this->form_validation->run() === FALSE) {
				// Jika validasi gagal, kembali ke halaman formulir dengan pesan error
				$this->load->view('users/header', $data);
				$this->load->view('users/usulan/usulan_survey_manual', $data);
				$this->load->view('users/footer');
			} else {
				// Jika validasi berhasil, simpan data survei ke dalam database
				$data = array(
					'surveyor' => $this->input->post('surveyor'),
					// 'kode_kantor' => $this->input->post('kode_kantor'),
					'id_pby' => $this->input->post('id_pby'),
					// 'nama' => $this->input->post('nama'),
					// 'nik' => $this->input->post('nik'),
					// 'tgl_lahir' => $this->input->post('tgl_lahir'),
					// 'tempat_lahir' => $this->input->post('tempat_lahir'),
					// 'jk' => $this->input->post('jk'),
					// 'alamat' => $this->input->post('alamat'),
					// 'nama_ibu' => $this->input->post('nama_ibu'),
					'alamat_usaha' => $this->input->post('alamat_usaha'),
					// 'pekerjaan' => $this->input->post('pekerjaan'),
					'pekerjaan_sampingan' => $this->input->post('pekerjaan_sampingan'),
					// 'nominal' => $this->input->post('nominal'),
					'riwayat_pembiayaan' => $this->input->post('riwayat_pembiayaan'),
					// 'tujuan' => $this->input->post('tujuan'),
					'bidang_usaha' => $this->input->post('bidang_usaha'),
					'sumber_pelunasan' => $this->input->post('sumber_pelunasan'),
					// 'telepon' => $this->input->post('telepon'),
					// 'jangka_waktu' => $this->input->post('jangka_waktu'),
					// 'jaminan' => $this->input->post('jaminan'),
					'tgl_survey' => $this->input->post('tgl_survey'),
					'jam_mulai' => $this->input->post('jam_mulai'),
					'jam_selesai' => $this->input->post('jam_selesai'),
					'tempat_survey' => $this->input->post('tempat_survey'),
					// 'kondisi_rumah' => $this->input->post('kondisi_rumah'),
					'kekayaan1' => $this->input->post('kekayaan1'),
					'harga_taksiran1' => $this->input->post('harga_taksiran1'),
					'kekayaan2' => $this->input->post('kekayaan2'),
					'harga_taksiran2' => $this->input->post('harga_taksiran2'),
					'sumber_info' => $this->input->post('sumber_info'),
					'penjualan_usaha' => $this->input->post('penjualan_usaha'),
					'jml_penjualan' => $this->input->post('jml_penjualan'),
					'hrg_pokok_brg' => $this->input->post('hrg_pokok_brg'),
					'biaya_usaha' => $this->input->post('biaya_usaha'),
					'laba_usaha' => $this->input->post('laba_usaha'),
					'laba_usaha_bayar' => $this->input->post('laba_usaha_bayar'),
					'pendapatan_istri' => $this->input->post('pendapatan_istri'),
					'pendapatan_lain' => $this->input->post('pendapatan_lain'),
					'jml_pendapatan_diterima' => $this->input->post('jml_pendapatan_diterima'),
					'biaya_rt' => $this->input->post('biaya_rt'),
					'biaya_pendidikan' => $this->input->post('biaya_pendidikan'),
					'biaya_lain' => $this->input->post('biaya_lain'),
					'jml_pengeluaran' => $this->input->post('jml_pengeluaran'),
					'pendapatan_bersih' => $this->input->post('pendapatan_bersih'),
					'lending_maksimal' => $this->input->post('lending_maksimal'),
					// 'bpkb' => $this->input->post('bpkb'),
					// 'jns_kendaraan' => $this->input->post('jns_kendaraan'),
					// 'thn_pembuatan' => $this->input->post('thn_pembuatan'),
					// 'merk' => $this->input->post('merk'),
					// 'no_mesin' => $this->input->post('no_mesin'),
					'tipe' => $this->input->post('tipe'),
					// 'no_rangka' => $this->input->post('no_rangka'),
					// 'no_pol' => $this->input->post('no_pol'),
					'kepemilikan' => $this->input->post('kepemilikan'),
					'an' => $this->input->post('an'),
					'an_alamat' => $this->input->post('an_alamat'),
					'nilai_pasar' => $this->input->post('nilai_pasar'),
					'nilai_likuid' => $this->input->post('nilai_likuid'),
					// 'sertifikat' => $this->input->post('sertifikat'),
					// 'an_sertifikat' => $this->input->post('an_sertifikat'),
					// 'luas' => $this->input->post('luas'),
					// 'alamat_lokasi' => $this->input->post('alamat_lokasi'),
					'lokasi' => $this->input->post('lokasi'),
					'kecamatan' => $this->input->post('kecamatan'),
					'jarak' => $this->input->post('jarak'),
					'capai_lokasi' => $this->input->post('capai_lokasi'),
					'bentuk_tanah' => $this->input->post('bentuk_tanah'),
					'jenis_tanah' => $this->input->post('jenis_tanah'),
					'akses_jalan' => $this->input->post('akses_jalan'),
					'nilai_pasar_wajar' => $this->input->post('nilai_pasar_wajar'),
					'nilai_likuid_t' => $this->input->post('nilai_likuid_t'),
					'kepemilikan_t' => $this->input->post('kepemilikan_t'),
					'catatan' => $this->input->post('catatan'),
					'checklist' => $this->input->post('checklist'),
				);


				$foto_fields = ['foto_jaminan_1', 'foto_jaminan_1', 'foto_jaminan_2', 'foto_jaminan_3', 'foto_jaminan_4'];
				$foto_names = [];

				foreach ($foto_fields as $field) {
					// Cek jika ada file yang dipilih
					if (!empty($_FILES[$field]['name'])) {
						$config['upload_path'] = './foto/foto_usulan/';
						$config['allowed_types'] = 'jpg|jpeg|png|gif'; // Format yang diizinkan
						$config['max_size'] = 20480; // Maksimum ukuran file 20MB
						$this->load->library('upload');

						$this->upload->initialize($config); // Inisialisasi pustaka upload dengan konfigurasi

						// Cek jika file berhasil diupload
						if (!$this->upload->do_upload($field)) {
							// Jika gagal upload, tampilkan pesan error
							$upload_error = $this->upload->display_errors();
							$this->session->set_flashdata('error', "Gagal mengupload $field: $upload_error");
							redirect('users/usulan/usulan_survey_manual'); // Kembali ke form jika gagal
						}

						// Ambil data file yang diupload
						$upload_data = $this->upload->data();
						$foto_names[$field] = $upload_data['file_name']; // Simpan nama file di array foto_names
					}
				}

				// Tambahkan nama file foto ke dalam data yang akan disimpan
				$data = array_merge($data, $foto_names); // Gabungkan data dengan foto_names

				// Panggil model untuk menyimpan data
				$this->Usulan_model->insert_survey_data($data);
				$this->Usulan_model->set_status_survey($row_id, 1);

				// Redirect atau tampilkan pesan sukses
				redirect('users/usulan/usulan_data');
			}
		}
	}

	// end usulan

	// Start analisa
	public function analisa()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Usulan_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Analisa | MelatiApp";
			$data['survey_data'] = $this->Usulan_model->getSurveyData();

			$this->load->view('users/header', $data);
			$this->load->view('users/analisa/analisa', $data);
			$this->load->view('users/footer');
		}
	}

	public function analisa_hasil()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Usulan_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Hasil Analisa | MelatiApp";
			$data['survey_data'] = $this->Usulan_model->getHasilAnalisa();

			$this->load->view('users/header', $data);
			$this->load->view('users/analisa/analisa_hasil', $data);
			$this->load->view('users/footer');
		}
	}

	public function analisa_detail($id)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Usulan_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Detail Analisa | MelatiApp";
			$data['survey_detail'] = $this->Usulan_model->getSurveyDetail($id);

			$this->load->view('users/header', $data);
			$this->load->view('users/analisa/analisa_detail', $data);
			$this->load->view('users/footer');
		}
	}

	public function analisa_print($row_id)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('usulan_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Analisa Print | MelatiApp";
			$data['survey'] = $this->usulan_model->get_survey_data_by_id($row_id);
			$data['logo'] = $this->Mcrud->get_setting_by_key('logo');

			// Memuat view untuk print
			$this->load->view('users/analisa/analisa_print', $data);
		}
	}

	public function analisa_print_form($row_id)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('usulan_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Analisa Print Form | MelatiApp";
			$data['survey'] = $this->usulan_model->get_survey_data_by_id($row_id);
			$data['logo'] = $this->Mcrud->get_setting_by_key('logo');

			// Memuat view untuk print
			$this->load->view('users/analisa/analisa_print_form', $data);
		}
	}

	public function analisa_download($row_id)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('usulan_model');
			$this->load->library('pdf');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Analisa Download | MelatiApp";
			$data['survey'] = $this->usulan_model->get_survey_data_by_id($row_id);
			$data['logo'] = $this->Mcrud->get_setting_by_key('logo');

			// Mengatur tampilan PDF
			$html = $this->load->view('users/analisa/analisa_download', $data, true); // Mengembalikan HTML sebagai string

			// Generate PDF
			$this->pdf->loadHtml($html);
			$this->pdf->setPaper('A4', 'portrait'); // Anda bisa mengubah ukuran kertas dan orientasi jika diperlukan
			$this->pdf->render();

			// Download PDF
			$this->pdf->stream('Surat_Pernyataan_PBY' . $row_id . '.pdf', array('Attachment' => true));
		}
	}

	public function analisa_download_file($row_id)
	{
		// Cek session login
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			// Memuat model yang diperlukan
			$this->load->model('usulan_model');

			// Memuat helper download untuk menggunakan force_download
			$this->load->helper('download');

			// Ambil data file berdasarkan id_pby
			$this->db->where('id_pby', $row_id);
			$file_query = $this->db->get('tbl_file_user');  // Asumsikan tabel 'tbl_file_user' menyimpan file terkait

			if ($file_query->num_rows() > 0) {
				$file_data = $file_query->row();  // Ambil data file pertama
				$file_path = $file_data->file_path;  // Pastikan ada kolom 'file_path' di tabel

				// Cek apakah file ada
				if (file_exists($file_path)) {
					// Memaksa browser untuk mendownload file
					force_download($file_path, NULL);
				} else {
					// Tampilkan pesan error jika file tidak ditemukan
					$this->session->set_flashdata('msg', '<div class="alert alert-danger">File tidak ditemukan.</div>');
					redirect('users/analisa');
				}
			} else {
				// Jika tidak ada data file ditemukan
				$this->session->set_flashdata('msg', '<div class="alert alert-danger">Data file tidak ditemukan.</div>');
				redirect('users/analisa');
			}
		}
	}


	public function analisa_edit($id)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('usulan_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Edit Analisa | MelatiApp";
			$data['survey_data'] = $this->usulan_model->getSurveyDetail($id); // Load the survey data

			if ($this->input->post()) {
				$updated_data = array(
					'id_pby' => $this->input->post('id_pby'),
					'tgl_analisa' => $this->input->post('tgl_analisa'),
					// 'nama' => $this->input->post('nama'),
					// 'alamat' => $this->input->post('alamat'),
					'alamat_usaha' => $this->input->post('alamat_usaha'),
					// 'pekerjaan' => $this->input->post('pekerjaan'),
					'pekerjaan_sampingan' => $this->input->post('pekerjaan_sampingan'),
					// 'nominal' => $this->input->post('nominal'),
					'riwayat_pembiayaan' => $this->input->post('riwayat_pembiayaan'),
					// 'tujuan' => $this->input->post('tujuan'),
					'bidang_usaha' => $this->input->post('bidang_usaha'),
					'sumber_pelunasan' => $this->input->post('sumber_pelunasan'),
					// 'telepon' => $this->input->post('telepon'),
					// 'jangka_waktu' => $this->input->post('jangka_waktu'),
					// 'jaminan' => $this->input->post('jaminan'),
					'tgl_survey' => $this->input->post('tgl_survey'),
					'jam_mulai' => $this->input->post('jam_mulai'),
					'jam_selesai' => $this->input->post('jam_selesai'),
					'tempat_survey' => $this->input->post('tempat_survey'),
					'kondisi_rumah' => $this->input->post('kondisi_rumah'),
					'kekayaan1' => $this->input->post('kekayaan1'),
					'harga_taksiran1' => $this->input->post('harga_taksiran1'),
					'kekayaan2' => $this->input->post('kekayaan2'),
					'harga_taksiran2' => $this->input->post('harga_taksiran2'),
					'sumber_info' => $this->input->post('sumber_info'),
					'penjualan_usaha' => $this->input->post('penjualan_usaha'),
					'jml_penjualan' => $this->input->post('jml_penjualan'),
					'hrg_pokok_brg' => $this->input->post('hrg_pokok_brg'),
					'biaya_usaha' => $this->input->post('biaya_usaha'),
					'laba_usaha' => $this->input->post('laba_usaha'),
					'laba_usaha_bayar' => $this->input->post('laba_usaha_bayar'),
					'pendapatan_istri' => $this->input->post('pendapatan_istri'),
					'pendapatan_lain' => $this->input->post('pendapatan_lain'),
					'jml_pendapatan_diterima' => $this->input->post('jml_pendapatan_diterima'),
					'biaya_rt' => $this->input->post('biaya_rt'),
					'biaya_pendidikan' => $this->input->post('biaya_pendidikan'),
					'biaya_lain' => $this->input->post('biaya_lain'),
					'jml_pengeluaran' => $this->input->post('jml_pengeluaran'),
					'pendapatan_bersih' => $this->input->post('pendapatan_bersih'),
					'lending_maksimal' => $this->input->post('lending_maksimal'),
					// 'bpkb' => $this->input->post('bpkb'),
					// 'jns_kendaraan' => $this->input->post('jns_kendaraan'),
					// 'thn_pembuatan' => $this->input->post('thn_pembuatan'),
					// 'merk' => $this->input->post('merk'),
					// 'no_mesin' => $this->input->post('no_mesin'),
					'tipe' => $this->input->post('tipe'),
					// 'no_rangka' => $this->input->post('no_rangka'),
					// 'no_pol' => $this->input->post('no_pol'),
					'kepemilikan' => $this->input->post('kepemilikan'),
					'an' => $this->input->post('an'),
					'an_alamat' => $this->input->post('an_alamat'),
					'nilai_pasar' => $this->input->post('nilai_pasar'),
					'nilai_likuid' => $this->input->post('nilai_likuid'),
					// 'sertifikat' => $this->input->post('sertifikat'),
					// 'an_sertifikat' => $this->input->post('an_sertifikat'),
					// 'luas' => $this->input->post('luas'),
					// 'alamat_lokasi' => $this->input->post('alamat_lokasi'),
					'lokasi' => $this->input->post('lokasi'),
					'kecamatan' => $this->input->post('kecamatan'),
					'jarak' => $this->input->post('jarak'),
					'capai_lokasi' => $this->input->post('capai_lokasi'),
					'bentuk_tanah' => $this->input->post('bentuk_tanah'),
					'jenis_tanah' => $this->input->post('jenis_tanah'),
					'akses_jalan' => $this->input->post('akses_jalan'),
					'nilai_pasar_wajar' => $this->input->post('nilai_pasar_wajar'),
					'nilai_likuid_t' => $this->input->post('nilai_likuid_t'),
					'kepemilikan_t' => $this->input->post('kepemilikan_t'),
					'catatan' => $this->input->post('catatan'),
					'checklist' => $this->input->post('checklist'),
					'tgl_cek_bi' => $this->input->post('tgl_cek_bi'),
					'analyst' => $this->input->post('analyst'),
					'status_analisa' => $this->input->post('status_analisa'),
					'hasil_analisa' => $this->input->post('hasil_analisa'),
					'keterangan' => $this->input->post('keterangan'),
					// Tambahkan field lainnya yang perlu di-update
				);

				// Panggil model untuk menyimpan data
				$this->usulan_model->update_survey_data($id, $updated_data);

				// Redirect atau tampilkan pesan sukses
				redirect('users/analisa/analisa');
			}
			$this->load->view('users/header', $data);
			$this->load->view('users/analisa/analisa_edit', $data);
			$this->load->view('users/footer');
		}
	}

	public function analisa_cek_bi($id)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('usulan_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Bi Checking | MelatiApp";
			$data['survey_data'] = $this->usulan_model->getSurveyDetail($id); // Load the survey data

			if ($this->input->post()) {
				$updated_data = array(
					'tgl_cek_bi' => $this->input->post('tgl_cek_bi'),
				);

				// Panggil model untuk menyimpan data
				$this->usulan_model->update_survey_data($id, $updated_data);

				// Redirect atau tampilkan pesan sukses
				redirect('users/usulan');
			}
			$this->load->view('users/header', $data);
			$this->load->view('users/analisa/analisa_cek_bi', $data);
			$this->load->view('users/footer');
		}
	}

	public function analisa_delete($id)
	{
		$this->load->model('usulan_model');
		// Load your model method to delete the survey data
		$this->usulan_model->delete_survey_data($id);

		// Redirect to the desired page after deletion
		redirect('users/analisa/analisa');
	}

	// end analisa

	// Start kalkulator
	public function kalkulator()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Kalkulator | MelatiApp";

			$this->load->view('users/header', $data);
			$this->load->view('users/kalkulator/kalkulator');
			$this->load->view('users/footer');
		}
	}

	public function kalkulator_standar()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Kalkulator | MelatiApp";

			$this->load->view('users/header', $data);
			$this->load->view('users/kalkulator/kalkulator_standar');
			$this->load->view('users/footer');
		}
	}
	// end kalkulator

	// Kantor
	public function kantor()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Kantor_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Daftar Kantor | MelatiApp";
			$data['kantor_data'] = $this->Kantor_model->get_all_kantor_with_users();

			$this->load->view('users/header', $data);
			$this->load->view('users/kantor/daftar_kantor');
			$this->load->view('users/footer');
		}
	}

	public function kantor_data()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Kantor_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Daftar Kantor | MelatiApp";
			$data['kantor_data'] = $this->Kantor_model->get_all_kantor();

			$this->load->view('users/header', $data);
			$this->load->view('users/kantor/kantor_data');
			$this->load->view('users/footer');
		}
	}

	public function kantor_edit($id)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {

			$this->load->model('Kantor_model');

			$data['kantor_data'] = $this->Kantor_model->get_kantor_by_id($id);

			if ($data['kantor_data']) {
				$data['user'] = $this->Mcrud->get_users_by_un($ceks);
				$data['judul_web'] = "Edit Kantor | MelatiApp";

				$this->load->view('users/header', $data);
				$this->load->view('users/kantor/kantor_edit', $data);
				$this->load->view('users/footer');
			} else {
				redirect('users/kantor_data');
			}
		}
	}

	public function kantor_update($id)
	{
		// Check if the user is logged in
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {

			// Check if the form is submitted
			if ($this->input->post()) {

				$kode_kantor = $this->input->post('kode_kantor');
				$nama_kantor = $this->input->post('nama_kantor');
				$alamat = $this->input->post('alamat');
				$telepon = $this->input->post('telepon');
				$email = $this->input->post('email');
				$link_map = $this->input->post('link_map');
				$status = $this->input->post('status');
				$latitude = $this->input->post('latitude');
				$longitude = $this->input->post('longitude');

				// Set up array data
				$data = array(
					'kode_kantor' => $kode_kantor,
					'nama_kantor' => $nama_kantor,
					'alamat' => $alamat,
					'telepon' => $telepon,
					'email' => $email,
					'link_map' => $link_map,
					'status' => $status,
					'latitude' => $latitude,
					'longitude' => $longitude
				);

				$this->load->model('Kantor_model');
				$this->Kantor_model->update_kantor($id, $data);

				redirect('users/kantor_data');
			}
		}
	}

	public function kantor_hapus($id)
	{
		// Check if the user is logged in
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			// Load model
			$this->load->model('Kantor_model');

			// Hapus data agunan berdasarkan ID
			$this->Kantor_model->delete_kantor($id);

			// Redirect ke halaman list agunan
			redirect('users/kantor_data');
		}
	}

	public function kantor_tambah()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Tambah Kantor | MelatiApp"; // Judul halaman

			$this->load->view('users/header', $data);
			$this->load->view('users/kantor/kantor_tambah');
			$this->load->view('users/footer');
		}
	}

	public function kantor_simpan()
	{
		// Cek apakah pengguna sudah login
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Kantor_model');

			if ($this->input->post()) {
				// Ambil data dari form
				$kode_kantor = $this->input->post('kode_kantor');
				$nama_kantor = $this->input->post('nama_kantor');
				$alamat = $this->input->post('alamat');
				$telepon = $this->input->post('telepon');
				$email = $this->input->post('email');
				$link_map = $this->input->post('link_map');
				$status = $this->input->post('status');
				$latitude = $this->input->post('latitude');
				$longitude = $this->input->post('longitude');

				// Set up array data
				$data = array(
					'kode_kantor' => $kode_kantor,
					'nama_kantor' => $nama_kantor,
					'alamat' => $alamat,
					'telepon' => $telepon,
					'email' => $email,
					'link_map' => $link_map,
					'status' => $status,
					'latitude' => $latitude,
					'longitude' => $longitude
				);

				$this->Kantor_model->kunjungan_simpan($data);

				// Redirect ke halaman data kunjungan
				redirect('users/kantor_data');
			} else {
				// Jika form tidak disubmit, tampilkan halaman form
				$this->load->view('users/kantor_tambah');
			}
		}
	}
	// /Kantor

	// Berita
	public function berita()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Berita | MelatiApp";

			$this->load->view('users/header', $data);
			$this->load->view('users/berita/berita');
			$this->load->view('users/footer');
		}
	}
	// /berita

	// mengambil conten WordPress
	public function get_wordpress_content()
	{
		// Di sini, Anda perlu mengambil konten dari WordPress sesuai dengan kebutuhan Anda.
		// Misalnya, Anda dapat menggunakan library cURL atau metode lain untuk mengambil konten dari API WordPress.

		// Contoh pengambilan konten dari API WordPress menggunakan cURL:
		$api_url = 'https://bmtmelati.com/wp-json/wp/v2/posts'; // Ganti dengan URL API WordPress yang sesuai
		$curl = curl_init($api_url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($curl);
		curl_close($curl);

		// Pastikan untuk memproses $response sesuai dengan format data yang diharapkan dari WordPress.

		// Contoh pengembalian konten:
		return $response;
	}

	// end mengambil conten WordPress

	// Start blog
	public function blog()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);

			// Di sini, Anda perlu mengambil konten dari WordPress sesuai dengan slide yang diklik
			$wordpress_content = $this->get_wordpress_content(); // Misalnya, Anda perlu membuat fungsi ini
			// Kemudian, tampilkan tampilan blog dengan konten WordPress
			$data['wordpress_content'] = $wordpress_content;
			$data['judul_web'] = "Blog | MelatiApp"; // Judul halaman


			$this->load->view('users/header', $data);
			$this->load->view('users/blog/blog');
			$this->load->view('users/footer');
		}
	}
	// end blog

	// Start tracking
	public function tracking()
	{
		$ceks = $this->session->userdata('user@mt');

		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			// Load the Tracking_model
			$this->load->model('Tracking_model');
			// Load the User_model
			$this->load->model('User_model'); // Tambahkan ini

			// Get user tracking data from the model and assign it to $data['userLocations']
			// ini untuk ambil lokasi semua user
			// $data['userLocations'] = $this->Tracking_model->getAllUserLocations(); 

			// ini untuk ambil lokasi user marketing saja
			$data['userLocations'] = $this->Tracking_model->getMarketingUsers();


			// Get user data from the model
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);

			// Set other data for the view
			$data['judul_web'] = "Tracking | MelatiApp"; // Judul halaman

			// Load views and pass data
			$this->load->view('users/header', $data);
			$this->load->view('users/tracking/tracking', $data); // Pass userLocations data
			$this->load->view('users/footer');
		}
	}

	public function trackingall()
	{
		$ceks = $this->session->userdata('user@mt');

		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			// Load the Tracking_model
			$this->load->model('Tracking_model');
			// Load the User_model
			$this->load->model('User_model'); // Tambahkan ini

			// Get user tracking data from the model and assign it to $data['userLocations']
			// ini untuk ambil lokasi semua user
			$data['userLocations'] = $this->Tracking_model->getAllUserLocations();

			// ini untuk ambil lokasi user marketing saja
			// $data['userLocations'] = $this->Tracking_model->getMarketingUsers(); 


			// Get user data from the model
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);

			// Set other data for the view
			$data['judul_web'] = "TrackingAll | MelatiApp"; // Judul halaman

			// Load views and pass data
			$this->load->view('users/header', $data);
			$this->load->view('users/tracking/trackingall', $data); // Pass userLocations data
			$this->load->view('users/footer');
		}
	}

	public function trackingall_marker()
	{
		$ceks = $this->session->userdata('user@mt');

		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			// Load the Tracking_model
			$this->load->model('Tracking_model');
			// Load the User_model
			$this->load->model('User_model'); // Tambahkan ini

			// Get user tracking data from the model and assign it to $data['userLocations']
			// ini untuk ambil lokasi semua user
			$data['userLocations'] = $this->Tracking_model->getAllUserLocations();

			// ini untuk ambil lokasi user marketing saja
			// $data['userLocations'] = $this->Tracking_model->getMarketingUsers(); 


			// Get user data from the model
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);

			// Set other data for the view
			$data['judul_web'] = "TrackingAll | MelatiApp"; // Judul halaman

			// Load views and pass data
			$this->load->view('users/header', $data);
			$this->load->view('users/tracking/trackingall_marker', $data); // Pass userLocations data
			$this->load->view('users/footer');
		}
	}

	// end tracking

	// Start laporan
	public function laporan_kerja()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);

			$data['judul_web'] = "Laporan Kerja | MelatiApp";


			$this->load->view('users/header', $data);
			$this->load->view('users/laporan_kerja/laporan_kerja');
			$this->load->view('users/footer');
		}
	}
	// end laporan

	// laporan kerja lihat
	public function laporan_kerja_lihat($id)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Laporan_kerja_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Lihat Laporan Kerja | MelatiApp";

			// Ambil data laporan kerja dari model berdasarkan $id
			$data['laporan_kerja'] = $this->Laporan_kerja_model->get_laporan_kerja_by_id($id);

			if (empty($data['laporan_kerja'])) {
				// Handle case where laporan kerja with given ID is not found
				show_404(); // Or redirect to an error page
			}

			$this->load->view('users/header', $data);
			$this->load->view('users/laporan_kerja/laporan_kerja_lihat', $data);
			$this->load->view('users/footer');
		}
	}
	// /laporan kerja lihat

	public function laporan_kerja_export_excel()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		}

		$this->load->model('Laporan_kerja_model'); // Memuat model Laporan_kerja_model
		$id_user = $this->session->userdata('id_user');

		// Ambil bulan dan tahun dari query parameter (atau default ke bulan dan tahun saat ini)
		$selectedMonth = $this->input->get('bulan') ?: date('m');
		$selectedYear = $this->input->get('tahun') ?: date('Y');

		// Dapatkan data laporan kerja berdasarkan bulan dan tahun yang dipilih
		$laporan_kerja = $this->Laporan_kerja_model->get_laporan_kerja_by_id_user($id_user, $selectedMonth, $selectedYear);

		// Jika tidak ada data laporan kerja
		if (empty($laporan_kerja)) {
			show_404(); // Menampilkan halaman 404 jika data tidak ditemukan
		}

		// Membuat objek Spreadsheet baru
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		// Set header kolom (hanya untuk Tanggal dan Pekerjaan)
		$sheet->setCellValue('A1', 'Tanggal');
		$sheet->setCellValue('B1', 'Pekerjaan');

		// Menambahkan gaya pada header kolom
		$styleArray = [
			'font' => [
				'bold' => true,
				'color' => ['argb' => 'FFFFFF'],
				'size' => 12
			],
			'alignment' => [
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
			],
			'fill' => [
				'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
				'startColor' => ['argb' => '4CAF50']
			]
		];

		$sheet->getStyle('A1:B1')->applyFromArray($styleArray);

		// Mulai mengisi data laporan kerja ke dalam file Excel
		$row = 2; // Baris pertama untuk data mulai dari baris ke-2
		foreach ($laporan_kerja as $laporan) {
			// Membersihkan data pekerjaan agar tidak ada tag HTML
			$pekerjaan_clean = strip_tags($laporan['pekerjaan']);
			$pekerjaan_clean = html_entity_decode($pekerjaan_clean, ENT_NOQUOTES, 'UTF-8');

			// Menambahkan data ke setiap kolom (hanya Tanggal dan Pekerjaan)
			$sheet->setCellValue('A' . $row, date('Y-m-d', strtotime($laporan['tanggal'])));
			$sheet->setCellValue('B' . $row, $pekerjaan_clean);

			// Menambahkan border di sekitar setiap sel
			$sheet->getStyle('A' . $row . ':B' . $row)->applyFromArray([
				'borders' => [
					'allBorders' => [
						'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
						'color' => ['argb' => '000000'],
					]
				]
			]);

			$row++; // Pindah ke baris berikutnya
		}

		// Mengatur lebar kolom agar terlihat rapi
		foreach (range('A', 'B') as $column) {
			$sheet->getColumnDimension($column)->setAutoSize(true);
		}

		// Set file Excel untuk diunduh
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Laporan_Kerja_' . $selectedMonth . '_' . $selectedYear . '.xlsx"');
		header('Cache-Control: max-age=0');

		// Tulis ke output PHP
		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
	}

	public function laporan_kerja_export_word()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		}

		$this->load->model('Laporan_kerja_model');
		$id_user = $this->session->userdata('id_user');
		$selectedMonth = $this->input->get('bulan') ?: date('m');
		$selectedYear = $this->input->get('tahun') ?: date('Y');

		$laporan_kerja = $this->Laporan_kerja_model->get_laporan_kerja_by_id_user($id_user, $selectedMonth, $selectedYear);

		if (empty($laporan_kerja)) {
			show_404();
		}

		require_once APPPATH . 'libraries/PhpWord/Autoloader.php';
		\PhpOffice\PhpWord\Autoloader::register();
		$phpWord = new \PhpOffice\PhpWord\PhpWord();

		$section = $phpWord->addSection([
			'marginTop' => 600,
			'marginBottom' => 600,
			'marginLeft' => 600,
			'marginRight' => 600,
		]);

		// Judul dokumen
		$section->addText('Laporan Kerja', ['bold' => true, 'size' => 20, 'color' => '000000'], ['align' => 'center']);
		$section->addTextBreak(1); // Tambahkan spasi

		// Menambahkan subjudul periode laporan
		$section->addText('Periode: ' . $selectedMonth . ' - ' . $selectedYear, ['italic' => true, 'size' => 12], ['align' => 'center']);
		$section->addTextBreak(2); // Tambahkan spasi lebih banyak sebelum tabel

		// Membuat tabel
		$tableStyle = [
			'borderSize' => 6,
			'borderColor' => '999999',
			'cellMargin' => 50,
			'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER,
		];
		$phpWord->addTableStyle('LaporanKerjaTable', $tableStyle);

		$table = $section->addTable('LaporanKerjaTable');

		// Header tabel dengan background warna
		$headerStyle = ['bgColor' => 'cccccc'];
		$table->addRow();
		$table->addCell(3000, $headerStyle)->addText('Tanggal', ['bold' => true, 'color' => '000000']);
		$table->addCell(6000, $headerStyle)->addText('Pekerjaan', ['bold' => true, 'color' => '000000']);

		// Menambahkan data ke dalam tabel
		foreach ($laporan_kerja as $laporan) {
			$table->addRow();

			// Tampilkan tanggal
			$tanggal = !empty($laporan['tanggal']) ? date('Y-m-d', strtotime($laporan['tanggal'])) : '';
			$table->addCell(3000)->addText($tanggal);

			// Tampilkan pekerjaan tanpa pemeriksaan kosong
			$html_content = html_entity_decode($laporan['pekerjaan'], ENT_NOQUOTES, 'UTF-8');
			$htmlSection = $table->addCell(6000);

			// Tampilkan pekerjaan secara langsung tanpa pemeriksaan kosong
			\PhpOffice\PhpWord\Shared\Html::addHtml($htmlSection, $html_content, false, false);
		}

		// Set file untuk diunduh
		header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
		header('Content-Disposition: attachment;filename="Laporan_Kerja_' . $selectedMonth . '_' . $selectedYear . '.docx"');
		header('Cache-Control: max-age=0');

		$writer = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
		$writer->save('php://output');
	}

	public function laporan_kerja_export_all()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		}

		$this->load->model('Laporan_kerja_model');
		$selectedMonth = $this->input->get('bulan') ?: date('m');
		$selectedYear = $this->input->get('tahun') ?: date('Y');

		// Ambil semua data laporan kerja tanpa batasan id_user
		$laporan_kerja = $this->Laporan_kerja_model->get_all_laporan_kerja($selectedMonth, $selectedYear);

		if (empty($laporan_kerja)) {
			show_404();
		}

		require_once APPPATH . 'libraries/PhpWord/Autoloader.php';
		\PhpOffice\PhpWord\Autoloader::register();
		$phpWord = new \PhpOffice\PhpWord\PhpWord();

		$section = $phpWord->addSection([
			'marginTop' => 600,
			'marginBottom' => 600,
			'marginLeft' => 600,
			'marginRight' => 600,
		]);

		// Judul dokumen
		$section->addText('Laporan Kerja', ['bold' => true, 'size' => 20, 'color' => '000000'], ['align' => 'center']);
		$section->addTextBreak(1); // Tambahkan spasi

		// Menambahkan subjudul periode laporan
		$section->addText('Periode: ' . $selectedMonth . ' - ' . $selectedYear, ['italic' => true, 'size' => 12], ['align' => 'center']);
		$section->addTextBreak(2); // Tambahkan spasi lebih banyak sebelum tabel

		// Membuat tabel
		$tableStyle = [
			'borderSize' => 6,
			'borderColor' => '999999',
			'cellMargin' => 50,
			'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER,
		];
		$phpWord->addTableStyle('LaporanKerjaTable', $tableStyle);

		$table = $section->addTable('LaporanKerjaTable');

		// Header tabel dengan background warna
		$headerStyle = ['bgColor' => 'cccccc'];
		$table->addRow();
		$table->addCell(3000, $headerStyle)->addText('Tanggal', ['bold' => true, 'color' => '000000']);
		$table->addCell(3000, $headerStyle)->addText('Nama Lengkap', ['bold' => true, 'color' => '000000']);
		$table->addCell(6000, $headerStyle)->addText('Pekerjaan', ['bold' => true, 'color' => '000000']);

		// Menambahkan data ke dalam tabel
		foreach ($laporan_kerja as $laporan) {
			$table->addRow();

			// Tampilkan tanggal
			$tanggal = !empty($laporan['tanggal']) ? date('Y-m-d', strtotime($laporan['tanggal'])) : '';
			$table->addCell(3000)->addText($tanggal);

			// Tampilkan nama lengkap
			$table->addCell(3000)->addText($laporan['nama_lengkap']);

			// Tampilkan pekerjaan tanpa pemeriksaan kosong
			$html_content = html_entity_decode($laporan['pekerjaan'], ENT_NOQUOTES, 'UTF-8');
			$htmlSection = $table->addCell(6000);

			// Tampilkan pekerjaan secara langsung tanpa pemeriksaan kosong
			\PhpOffice\PhpWord\Shared\Html::addHtml($htmlSection, $html_content, false, false);
		}

		// Set file untuk diunduh
		header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
		header('Content-Disposition: attachment;filename="Laporan_Kerja_' . $selectedMonth . '_' . $selectedYear . '.docx"');
		header('Cache-Control: max-age=0');

		$writer = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
		$writer->save('php://output');
	}

	public function laporan_kerja_atasan_export_excel()
	{
		// Pastikan session aktif
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		}

		// Memuat model Laporan_kerja_model
		$this->load->model('Laporan_kerja_model');
		$kode_atasan = $this->session->userdata('kode_atasan');

		// Ambil bulan dan tahun dari query parameter, atau default ke bulan dan tahun saat ini
		$selectedMonth = $this->input->get('bulan') ?: date('m');
		$selectedYear = $this->input->get('tahun') ?: date('Y');

		// Dapatkan data laporan kerja berdasarkan kode atasan
		$laporan_kerja = $this->Laporan_kerja_model->get_laporan_kerja_by_kode_atasan($kode_atasan, $selectedMonth, $selectedYear);

		// Membuat objek Spreadsheet baru
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		// Set header kolom
		$sheet->setCellValue('A1', 'Tanggal');
		$sheet->setCellValue('B1', 'Nama Lengkap');
		$sheet->setCellValue('C1', 'Pekerjaan');

		// Menambahkan gaya pada header kolom
		$styleArray = [
			'font' => [
				'bold' => true,
				'color' => ['argb' => 'FFFFFF'],
				'size' => 12
			],
			'alignment' => [
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
			],
			'fill' => [
				'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
				'startColor' => ['argb' => '4CAF50']
			]
		];

		$sheet->getStyle('A1:C1')->applyFromArray($styleArray);

		// Mulai mengisi data laporan kerja ke dalam file Excel
		$row = 2; // Baris pertama untuk data mulai dari baris ke-2
		foreach ($laporan_kerja as $laporan) {
			// Membersihkan data pekerjaan agar tidak ada tag HTML
			$pekerjaan_clean = strip_tags($laporan['pekerjaan']);
			$pekerjaan_clean = html_entity_decode($pekerjaan_clean, ENT_NOQUOTES, 'UTF-8');

			// Menambahkan data ke setiap kolom (Tanggal, Nama Lengkap, dan Pekerjaan)
			$sheet->setCellValue('A' . $row, date('Y-m-d', strtotime($laporan['tanggal'])));
			$sheet->setCellValue('B' . $row, $laporan['nama_lengkap']);
			$sheet->setCellValue('C' . $row, $pekerjaan_clean);

			// Menambahkan border di sekitar setiap sel
			$sheet->getStyle('A' . $row . ':C' . $row)->applyFromArray([
				'borders' => [
					'allBorders' => [
						'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
						'color' => ['argb' => '000000'],
					]
				]
			]);

			$row++; // Pindah ke baris berikutnya
		}

		// Mengatur lebar kolom agar terlihat rapi
		foreach (range('A', 'C') as $column) {
			$sheet->getColumnDimension($column)->setAutoSize(true);
		}

		// Set file Excel untuk diunduh
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Laporan_Kerja_' . $selectedMonth . '_' . $selectedYear . '.xlsx"');
		header('Cache-Control: max-age=0');

		// Tulis ke output PHP
		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
	}

	// laporan Kerja edi
	public function laporan_kerja_edit($id)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Laporan_kerja_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Edit Laporan Kerja | MelatiApp";

			// Ambil data laporan kerja dari model berdasarkan $id
			$data['laporan_kerja'] = $this->Laporan_kerja_model->get_laporan_kerja_by_id($id);

			if (empty($data['laporan_kerja'])) {
				// Handle case where laporan kerja with given ID is not found
				show_404(); // Or redirect to an error page
			}

			$this->load->view('users/header', $data);
			$this->load->view('users/laporan_kerja/laporan_kerja_edit', $data);
			$this->load->view('users/footer');
		}
	}

	public function data_laporan_kerja_approval($id)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Laporan_kerja_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Approval Laporan Kerja | MelatiApp";

			// Ambil data laporan kerja dari model berdasarkan $id
			$data['laporan_kerja'] = $this->Laporan_kerja_model->get_laporan_kerja_by_id($id);

			if (empty($data['laporan_kerja'])) {
				// Handle case where laporan kerja with given ID is not found
				show_404(); // Or redirect to an error page
			}

			$this->load->view('users/header', $data);
			$this->load->view('users/laporan_kerja/data_laporan_kerja_approval', $data);
			$this->load->view('users/footer');
		}
	}

	public function data_laporan_kerja_approval_atasan($id)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Laporan_kerja_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Approval Laporan Kerja | MelatiApp";

			// Ambil data laporan kerja dari model berdasarkan $id
			$data['laporan_kerja'] = $this->Laporan_kerja_model->get_laporan_kerja_by_id($id);

			if (empty($data['laporan_kerja'])) {
				// Handle case where laporan kerja with given ID is not found
				show_404(); // Or redirect to an error page
			}

			$this->load->view('users/header', $data);
			$this->load->view('users/laporan_kerja/data_laporan_kerja_approval_atasan', $data);
			$this->load->view('users/footer');
		}
	}

	// Start update laporan kerja approval
	public function update_laporan_kerja_approval($id)
	{
		// Periksa apakah pengguna sudah login (sesi ada)
		if (!$this->session->userdata('username')) {
			// Jika tidak ada sesi, alihkan pengguna ke halaman login atau berikan pesan kesalahan
			redirect('web/login'); // Ubah URL sesuai dengan alamat halaman login Anda
		}

		// Tangkap data dari formulir
		$tanggal = $this->input->post('tanggal');
		$jam = $this->input->post('jam');
		$approval = $this->input->post('approval');
		$pekerjaan = $this->input->post('pekerjaan');

		// Siapkan data untuk diupdate ke dalam tabel
		$data = array(
			'tanggal' => $tanggal,
			'jam' => $jam,
			'approval' => $approval,
			'pekerjaan' => $pekerjaan
		);

		// Update data ke dalam tabel berdasarkan ID
		$this->db->where('id', $id);
		$this->db->update('tbl_laporan_kerja', $data);

		// Setelah berhasil diupdate, berikan pesan sukses dan alihkan pengguna ke halaman lain jika diperlukan
		$this->session->set_flashdata('msg', '<div class="alert alert-success"><strong>Sukses!</strong> Laporan Kerja berhasil diupdate!</div>');
		redirect('users/laporan_kerja_by_devisi/' . $id); // Ubah URL sesuai dengan halaman yang Anda inginkan setelah penyimpanan berhasil
	}
	// End update laporan kerja approval

	// Start update laporan kerja approval atasan
	public function update_laporan_kerja_approval_atasan($id)
	{
		// Periksa apakah pengguna sudah login (sesi ada)
		if (!$this->session->userdata('username')) {
			// Jika tidak ada sesi, alihkan pengguna ke halaman login atau berikan pesan kesalahan
			redirect('web/login'); // Ubah URL sesuai dengan alamat halaman login Anda
		}

		// Tangkap data dari formulir
		$tanggal = $this->input->post('tanggal');
		$jam = $this->input->post('jam');
		$approval = $this->input->post('approval');
		$pekerjaan = $this->input->post('pekerjaan');

		// Siapkan data untuk diupdate ke dalam tabel
		$data = array(
			'tanggal' => $tanggal,
			'jam' => $jam,
			'approval' => $approval,
			'pekerjaan' => $pekerjaan
		);

		// Update data ke dalam tabel berdasarkan ID
		$this->db->where('id', $id);
		$this->db->update('tbl_laporan_kerja', $data);

		// Setelah berhasil diupdate, berikan pesan sukses dan alihkan pengguna ke halaman lain jika diperlukan
		$this->session->set_flashdata('msg', '<div class="alert alert-success"><strong>Sukses!</strong> Laporan Kerja berhasil diupdate!</div>');
		redirect('users/laporan_kerja_by_atasan/' . $id); // Ubah URL sesuai dengan halaman yang Anda inginkan setelah penyimpanan berhasil
	}
	// End update laporan kerja approval atasan

	// Start Data laporan Kerja
	public function data_laporan_kerja()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Laporan_kerja_model'); // Memuat model Laporan_kerja_model
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);

			$data['judul_web'] = "Laporan Kerja | MelatiApp";
			$id_user = $this->session->userdata('id_user');

			// Check if form is submitted with month and year values
			$selectedMonth = $this->input->post('bulan');
			$selectedYear = $this->input->post('tahun');

			// If form is submitted, redirect with query parameters
			if ($selectedMonth && $selectedYear) {
				redirect('users/data_laporan_kerja?bulan=' . $selectedMonth . '&tahun=' . $selectedYear);
			}

			// If no form submission, check for query parameters in the URL
			$selectedMonth = $this->input->get('bulan');
			$selectedYear = $this->input->get('tahun');

			// Set default values if not provided
			$selectedMonth = $selectedMonth ?: date('m');
			$selectedYear = $selectedYear ?: date('Y');

			// Get laporan kerja based on selected month and year
			$data['laporan_kerja'] = $this->Laporan_kerja_model->get_laporan_kerja_by_id_user($id_user, $selectedMonth, $selectedYear);

			// Set selected month and year for the view
			$data['selectedMonth'] = $selectedMonth;
			$data['selectedYear'] = $selectedYear;


			$this->load->view('users/header', $data);
			$this->load->view('users/laporan_kerja/data_laporan_kerja', $data);
			$this->load->view('users/footer');
		}
	}

	// end data laporan kerja

	// start submit laporan
	public function submit_laporan()
	{
		// Periksa apakah pengguna sudah login (sesi ada)
		if (!$this->session->userdata('username')) {
			// Jika tidak ada sesi, alihkan pengguna ke halaman login atau berikan pesan kesalahan
			redirect('web/login'); // Ubah URL sesuai dengan alamat halaman login Anda
		}

		// Tangkap data dari formulir
		$tanggal = $this->input->post('tanggal');
		$jam = $this->input->post('jam');
		$pekerjaan = $this->input->post('pekerjaan');

		// Siapkan data untuk disimpan ke dalam tabel
		$data = array(
			'id_user' => $this->session->userdata('id_user'), // ID pengguna dari sesi
			'tanggal' => $tanggal,
			'jam' => $jam,
			'pekerjaan' => $pekerjaan
		);

		// Check if a file is selected
		if (!empty($_FILES['foto_pekerjaan']['name'])) {
			// Konfigurasi pengaturan upload gambar
			$config['upload_path'] = './foto/foto_pekerjaan/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif';
			$config['max_size'] = 20048; // 20MB
			$this->load->library('upload');

			// Inisialisasi perpustakaan upload dengan konfigurasi
			$this->upload->initialize($config);

			// Check if the file is successfully uploaded
			if (!$this->upload->do_upload('foto_pekerjaan')) {
				// Handle error uploading the file
			}

			// Get the uploaded file data
			$upload_data = $this->upload->data();
			$foto_pekerjaan_path = $upload_data['file_name'];

			// Set the file path in the data array
			$data['foto_pekerjaan'] = $foto_pekerjaan_path;
		}

		// Simpan data ke dalam tabel
		$this->db->insert('tbl_laporan_kerja', $data);
	}
	// end submit laporan

	// Start update laporan
	public function update_laporan($id)
	{
		// Periksa apakah pengguna sudah login (sesi ada)
		if (!$this->session->userdata('username')) {
			// Jika tidak ada sesi, alihkan pengguna ke halaman login atau berikan pesan kesalahan
			redirect('web/login'); // Ubah URL sesuai dengan alamat halaman login Anda
		}

		// Tangkap data dari formulir
		$tanggal = $this->input->post('tanggal');
		$jam = $this->input->post('jam');
		$approval = $this->input->post('approval');
		$pekerjaan = $this->input->post('pekerjaan');

		// Siapkan data untuk diupdate ke dalam tabel
		$data = array(
			'tanggal' => $tanggal,
			'jam' => $jam,
			'approval' => $approval,
			'pekerjaan' => $pekerjaan
		);

		// Update data ke dalam tabel berdasarkan ID
		$this->db->where('id', $id);
		$this->db->update('tbl_laporan_kerja', $data);

		// Setelah berhasil diupdate, berikan pesan sukses dan alihkan pengguna ke halaman lain jika diperlukan
		$this->session->set_flashdata('msg', '<div class="alert alert-success"><strong>Sukses!</strong> Laporan Kerja berhasil diupdate!</div>');
		redirect('users/data_laporan_kerja'); // Ubah URL sesuai dengan halaman yang Anda inginkan setelah penyimpanan berhasil
	}
	// End update laporan

	// Start hapus laporan kerja
	public function laporan_kerja_hapus($id)
	{
		// Periksa apakah pengguna sudah login (sesi ada)
		if (!$this->session->userdata('username')) {
			// Jika tidak ada sesi, alihkan pengguna ke halaman login atau berikan pesan kesalahan
			redirect('web/login'); // Ubah URL sesuai dengan alamat halaman login Anda
		}

		// Hapus data dari tabel berdasarkan ID
		$this->db->where('id', $id);
		$this->db->delete('tbl_laporan_kerja');

		// Setelah berhasil dihapus, berikan pesan sukses dan alihkan pengguna ke halaman lain jika diperlukan
		$this->session->set_flashdata('msg', '<div class="alert alert-success"><strong>Sukses!</strong> Laporan Kerja berhasil dihapus!</div>');
		redirect('users/data_laporan_kerja'); // Ubah URL sesuai dengan halaman yang Anda inginkan setelah hapus berhasil
	}
	// End hapus laporan kerja

	// laporan by kode devisi
	public function laporan_kerja_by_devisi()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$user = $this->Mcrud->get_users_by_un($ceks)->row();
			$kode_kantor = $user->kode_kantor;
			$kode_devisi = $user->kode_devisi;

			$this->load->model('Laporan_kerja_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Laporan Kerja Devisi | MelatiApp";

			// Check if form is submitted with month and year values
			$selectedMonth = $this->input->post('bulan');
			$selectedYear = $this->input->post('tahun');

			// If form is submitted, redirect with query parameters
			if ($selectedMonth && $selectedYear) {
				redirect('users/laporan_kerja_by_devisi?bulan=' . $selectedMonth . '&tahun=' . $selectedYear);
			}

			// If no form submission, check for query parameters in the URL
			$selectedMonth = $this->input->get('bulan');
			$selectedYear = $this->input->get('tahun');

			// Set default values if not provided
			$selectedMonth = $selectedMonth ?: date('m');
			$selectedYear = $selectedYear ?: date('Y');

			// Get laporan kerja based on selected month and year
			$data['laporan_kerja'] = $this->Laporan_kerja_model->get_laporan_kerja_by_kode_devisi($kode_kantor, $kode_devisi, $selectedMonth, $selectedYear);

			// Set selected month and year for the view
			$data['selectedMonth'] = $selectedMonth;
			$data['selectedYear'] = $selectedYear;

			$this->load->view('users/header', $data);
			$this->load->view('users/laporan_kerja/laporan_kerja_by_devisi', $data);
			$this->load->view('users/footer');
		}
	}
	// end laporan by kode devisi

	// laporan kerja by kode devisi semua kantor
	public function laporan_kerja_by_devisi_all()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$user = $this->Mcrud->get_users_by_un($ceks)->row();
			$kode_devisi = $user->kode_devisi;

			$this->load->model('Laporan_kerja_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Laporan Kerja Devisi Semua Kantor| MelatiApp";

			// Check if form is submitted with month and year values
			$selectedMonth = $this->input->post('bulan');
			$selectedYear = $this->input->post('tahun');

			// If form is submitted, redirect with query parameters
			if ($selectedMonth && $selectedYear) {
				redirect('users/laporan_kerja_by_devisi?bulan=' . $selectedMonth . '&tahun=' . $selectedYear);
			}

			// If no form submission, check for query parameters in the URL
			$selectedMonth = $this->input->get('bulan');
			$selectedYear = $this->input->get('tahun');

			// Set default values if not provided
			$selectedMonth = $selectedMonth ?: date('m');
			$selectedYear = $selectedYear ?: date('Y');

			// Get laporan kerja based on selected month and year
			$data['laporan_kerja'] = $this->Laporan_kerja_model->get_laporan_kerja_by_kode_devisi_all($kode_devisi, $selectedMonth, $selectedYear);

			// Set selected month and year for the view
			$data['selectedMonth'] = $selectedMonth;
			$data['selectedYear'] = $selectedYear;

			$this->load->view('users/header', $data);
			$this->load->view('users/laporan_kerja/laporan_kerja_by_devisi_all', $data);
			$this->load->view('users/footer');
		}
	}
	// end laporan kerja by kode devisi semua kantor

	// laporan by kode atasan
	public function laporan_kerja_by_atasan()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$user = $this->Mcrud->get_users_by_un($ceks)->row();
			$kode_atasan = $user->kode_atasan;

			$this->load->model('Laporan_kerja_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Laporan Kerja Atasan | MelatiApp";

			// Check if form is submitted with month and year values
			$selectedMonth = $this->input->post('bulan');
			$selectedYear = $this->input->post('tahun');

			// If form is submitted, redirect with query parameters
			if ($selectedMonth && $selectedYear) {
				redirect('users/laporan_kerja_by_atasan?bulan=' . $selectedMonth . '&tahun=' . $selectedYear);
			}

			// If no form submission, check for query parameters in the URL
			$selectedMonth = $this->input->get('bulan');
			$selectedYear = $this->input->get('tahun');

			// Set default values if not provided
			$selectedMonth = $selectedMonth ?: date('m');
			$selectedYear = $selectedYear ?: date('Y');

			// Get laporan kerja based on selected month and year
			$data['laporan_kerja'] = $this->Laporan_kerja_model->get_laporan_kerja_by_kode_atasan($kode_atasan, $selectedMonth, $selectedYear);

			// Set selected month and year for the view
			$data['selectedMonth'] = $selectedMonth;
			$data['selectedYear'] = $selectedYear;

			$this->load->view('users/header', $data);
			$this->load->view('users/laporan_kerja/laporan_kerja_by_atasan', $data);
			$this->load->view('users/footer');
		}
	}
	// end laporan by kode atasan

	// laporan by kode atasan custom
	public function laporan_kerja_by_atasan_2()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$user = $this->Mcrud->get_users_by_un($ceks)->row();
			$kode_atasan = $user->kode_atasan_2;

			$this->load->model('Laporan_kerja_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Laporan Kerja Atasan | MelatiApp";

			// Check if form is submitted with month and year values
			$selectedMonth = $this->input->post('bulan');
			$selectedYear = $this->input->post('tahun');

			// If form is submitted, redirect with query parameters
			if ($selectedMonth && $selectedYear) {
				redirect('users/laporan_kerja_by_atasan_2?bulan=' . $selectedMonth . '&tahun=' . $selectedYear);
			}

			// If no form submission, check for query parameters in the URL
			$selectedMonth = $this->input->get('bulan');
			$selectedYear = $this->input->get('tahun');

			// Set default values if not provided
			$selectedMonth = $selectedMonth ?: date('m');
			$selectedYear = $selectedYear ?: date('Y');

			// Get laporan kerja based on selected month and year
			$data['laporan_kerja'] = $this->Laporan_kerja_model->get_laporan_kerja_by_kode_atasan_2($kode_atasan, $selectedMonth, $selectedYear);

			// Set selected month and year for the view
			$data['selectedMonth'] = $selectedMonth;
			$data['selectedYear'] = $selectedYear;

			$this->load->view('users/header', $data);
			$this->load->view('users/laporan_kerja/laporan_kerja_by_atasan_2', $data);
			$this->load->view('users/footer');
		}
	}
	// end laporan by kode atasan custom

	// semua laporan kerja
	public function laporan_kerja_all()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Laporan_kerja_model'); // Memuat model Laporan_kerja_model
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);

			$data['judul_web'] = "Semua Laporan Kerja | MelatiApp";
			$id_user = $this->session->userdata('id_user');

			// Check if form is submitted with month and year values
			$selectedMonth = $this->input->post('bulan');
			$selectedYear = $this->input->post('tahun');

			// If form is submitted, redirect with query parameters
			if ($selectedMonth && $selectedYear) {
				redirect('users/laporan_kerja_all?bulan=' . $selectedMonth . '&tahun=' . $selectedYear);
			}

			// If no form submission, check for query parameters in the URL
			$selectedMonth = $this->input->get('bulan');
			$selectedYear = $this->input->get('tahun');

			// Set default values if not provided
			$selectedMonth = $selectedMonth ?: date('m');
			$selectedYear = $selectedYear ?: date('Y');

			// Get laporan kerja based on selected month and year
			$data['laporan_kerja'] = $this->Laporan_kerja_model->get_all_laporan_kerja($selectedMonth, $selectedYear);

			// Set selected month and year for the view
			$data['selectedMonth'] = $selectedMonth;
			$data['selectedYear'] = $selectedYear;


			$this->load->view('users/header', $data);
			$this->load->view('users/laporan_kerja/laporan_kerja_all', $data);
			$this->load->view('users/footer');
		}
	}
	// end semua laporan kerja


	// Start laporan
	public function kerusakan()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Tambah Data Kerusakan | MelatiApp"; // Judul halaman

			$this->load->view('users/header', $data);
			$this->load->view('users/kerusakan/kerusakan');
			$this->load->view('users/footer');
		}
	}
	// end laporan


	public function data_kerusakan()
	{
		$ceks = $this->session->userdata('user@mt');

		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Kerusakan_model'); // Memuat model
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);

			$data['judul_web'] = "Data Kerusakan | MelatiApp";

			// dengan kebutuhan Anda, misalnya dari sesi atau parameter URL.
			$id_user = $this->session->userdata('id_user'); // Sesuaikan dengan nama sesi Anda.

			// Ambil data kerusakan dari model
			$data['kerusakan'] = $this->Kerusakan_model->get_all_kerusakan_waiting(); // Ganti dengan method yang sesuai di model

			$this->load->view('users/header', $data);
			$this->load->view('users/kerusakan/data_kerusakan', $data);
			$this->load->view('users/footer');
		}
	}

	public function data_kerusakan_respond()
	{
		$ceks = $this->session->userdata('user@mt');

		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Kerusakan_model'); // Memuat model
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);

			$data['judul_web'] = "Data Kerusakan | MelatiApp";

			// dengan kebutuhan Anda, misalnya dari sesi atau parameter URL.
			$id_user = $this->session->userdata('id_user'); // Sesuaikan dengan nama sesi Anda.

			// Ambil data kerusakan dari model
			$data['kerusakan'] = $this->Kerusakan_model->get_all_kerusakan_respond(); // Ganti dengan method yang sesuai di model

			$this->load->view('users/header', $data);
			$this->load->view('users/kerusakan/data_kerusakan_respond', $data);
			$this->load->view('users/footer');
		}
	}

	// end data kerusakan
	public function simpan_kerusakan()
	{
		// Check if the user is logged in
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			// Load model Kerusakan_model
			$this->load->model('Kerusakan_model');

			// Check if the form is submitted
			if ($this->input->post()) {
				$tanggal = $this->input->post('tanggal');
				$petugas = $this->session->userdata('username');
				$kantor = $this->input->post('kantor');
				$kerusakan = $this->input->post('kerusakan');
				$tindakan = $this->input->post('tindakan');

				// Set up the data array
				$data = array(
					'tanggal' => $tanggal,
					'petugas' => $petugas,
					'kantor' => $kantor,
					'kerusakan' => $kerusakan,
					'tindakan' => $tindakan
				);

				// Check if a file is selected
				if (!empty($_FILES['foto_kerusakan']['name'])) {
					// Configure image upload settings
					$config['upload_path'] = './foto/kerusakan/';
					$config['allowed_types'] = 'jpg|jpeg|png|gif';
					$config['max_size'] = 20048; // 2MB
					$this->load->library('upload');

					// Initialize the upload library with configuration
					$this->upload->initialize($config);

					// Check if the file is successfully uploaded
					if (!$this->upload->do_upload('foto_kerusakan')) {
						// Handle error uploading the file
						$this->session->set_flashdata('msg', 'Error: ' . $this->upload->display_errors());
						redirect('users/kerusakan/data_kerusakan');
					}

					// Get the uploaded file data
					$upload_data = $this->upload->data();
					$foto_kerusakan_path = $upload_data['file_name'];

					// Set the file path in the data array
					$data['foto_kerusakan'] = $foto_kerusakan_path;

					// Resize and compress the uploaded photo
					$this->resize_and_compress_photo($foto_kerusakan_path);
				}

				// Use the Kerusakan_model to save the data
				$inserted = $this->Kerusakan_model->simpan_kerusakan($data);

				// Redirect to the appropriate page
				redirect('users/kerusakan/data_kerusakan');
			} else {
				// If the form is not submitted, load the view
				$this->load->view('users/kerusakan/data_kerusakan');
			}
		}
	}

	// Function to resize and compress the photo
	private function resize_and_compress_photo($file_name)
	{
		$config['image_library'] = 'gd2';
		$config['source_image'] = './foto/kerusakan/' . $file_name;
		$config['maintain_ratio'] = TRUE;
		$config['width'] = 300;

		// Load Intervention Image library
		$this->load->library('image_lib');
		$this->image_lib->initialize($config);

		if (!$this->image_lib->resize()) {
			// Handle error resizing the image
			echo $this->image_lib->display_errors();
		}

		// Compress the image
		$this->load->library('image_lib');
		$config['quality'] = '10%'; // Set compression quality
		$config['width'] = 0; // Set width to 0 to maintain aspect ratio
		$this->image_lib->initialize($config);
		$this->image_lib->resize();
	}


	public function hapus_kerusakan($id)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			// Load model Kerusakan_model
			$this->load->model('Kerusakan_model');

			$this->Kerusakan_model->hapus_kerusakan($id);
			redirect('users/kerusakan/data_kerusakan');
		}
	}

	public function edit_kerusakan($id)
	{	// Check if the user is logged in
		$ceks = $this->session->userdata('user@mt');
		$id_user = $this->session->userdata('id_user@mt');

		if (!isset($ceks)) {
			redirect('web/login');
		} else {

			$data['user'] = $this->Mcrud->get_users_by_un($ceks);

			$data['judul_web'] = "Edit Data Kerusakan | MelatiApp";

			$this->load->model('Kerusakan_model');

			$data['kerusakan'] = $this->Kerusakan_model->get_kerusakan_by_id($id);

			$this->load->view('users/header', $data);
			$this->load->view('users/kerusakan/edit_kerusakan', $data);
			$this->load->view('users/footer');
		}
	}

	public function update_kerusakan($id)
	{
		$ceks = $this->session->userdata('user@mt');

		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Kerusakan_model');

			// Ambil data kerusakan berdasarkan ID
			$existing_kerusakan = $this->Kerusakan_model->get_kerusakan_by_id($id);

			$data = array(
				'tanggal' => $this->input->post('tanggal'),
				'petugas' => $this->input->post('petugas'),
				'kantor' => $this->input->post('kantor'),
				'kerusakan' => $this->input->post('kerusakan'),
				'tindakan' => $this->input->post('tindakan')
				// Tambahkan field lainnya sesuai kebutuhan
			);

			// Check apakah ada file yang diupload
			if (!empty($_FILES['foto_kerusakan']['name'])) {
				// Configure upload settings
				$config['upload_path'] = './foto/kerusakan/';
				$config['allowed_types'] = 'jpg|jpeg|png';
				$config['max_size'] = 2048; // 2MB

				$this->load->library('upload', $config);

				if ($this->upload->do_upload('foto_kerusakan')) {
					// File berhasil diupload, ambil nama file baru
					$new_foto_kerusakan = $this->upload->data('file_name');

					// Hapus foto lama (jika ada)
					if (!empty($existing_kerusakan['foto_kerusakan'])) {
						unlink('./foto/kerusakan/' . $existing_kerusakan['foto_kerusakan']);
					}

					// Set nama file baru di dalam data
					$data['foto_kerusakan'] = $new_foto_kerusakan;
				} else {
					// Handle error upload file
					$error = $this->upload->display_errors();
					// Sesuaikan dengan penanganan kesalahan yang sesuai dengan aplikasi Anda
					redirect('users/edit_kerusakan/' . $id);
				}
			} else {
				// Jika tidak ada file yang diupload, pertahankan foto yang sudah ada
				$data['foto_kerusakan'] = $existing_kerusakan['foto_kerusakan'];
			}

			// Panggil model untuk update data
			$this->Kerusakan_model->update_kerusakan($id, $data);

			// Redirect ke halaman data_kerusakan
			redirect('users/kerusakan/data_kerusakan');
		}
	}

	// BLOKIR
	public function blokir()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Tambah Data Blokir | MelatiApp"; // Judul halaman

			$this->load->view('users/header', $data);
			$this->load->view('users/blokir/blokir'); // Sesuaikan dengan struktur folder dan nama file yang benar
			$this->load->view('users/footer');
		}
	}
	// end laporan

	public function data_blokir()
	{
		$ceks = $this->session->userdata('user@mt');

		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Blokir_model'); // Sesuaikan dengan nama model yang benar
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);

			$data['judul_web'] = "Data Blokir | MelatiApp";

			$data['blokir'] = $this->Blokir_model->get_all_blokir_proses(); // Sesuaikan dengan method yang sesuai di model

			$this->load->view('users/header', $data);
			$this->load->view('users/blokir/data_blokir', $data); // Sesuaikan dengan struktur folder dan nama file yang benar
			$this->load->view('users/footer');
		}
	}

	// end data blokir

	public function data_blokir_selesai()
	{
		$ceks = $this->session->userdata('user@mt');

		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Blokir_model'); // Sesuaikan dengan nama model yang benar
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);

			$data['judul_web'] = "Data Blokir Selesai | MelatiApp";

			$data['blokir'] = $this->Blokir_model->get_all_blokir_done(); // Sesuaikan dengan method yang sesuai di model

			$this->load->view('users/header', $data);
			$this->load->view('users/blokir/data_blokir_selesai', $data); // Sesuaikan dengan struktur folder dan nama file yang benar
			$this->load->view('users/footer');
		}
	}

	public function simpan_blokir()
	{
		// Check if the user is logged in
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			// Load model Blokir_model
			$this->load->model('Blokir_model');

			// Check if the form is submitted
			if ($this->input->post()) {
				$kantor = $this->input->post('kantor');
				$petugas = $this->session->userdata('username');
				$no_rek = $this->input->post('no_rek');
				$nama = $this->input->post('nama');
				$tanggal = $this->input->post('tanggal');
				$jumlah = $this->input->post('jumlah');
				$keterangan = $this->input->post('keterangan');
				$nomor_blokir = $this->input->post('nomor_blokir');

				// Set up the data array
				$data = array(
					'kantor' => $kantor,
					'petugas' => $petugas,
					'no_rek' => $no_rek,
					'nama' => $nama,
					'tanggal' => $tanggal,
					'jumlah' => $jumlah,
					'keterangan' => $keterangan,
					'nomor_blokir' => $nomor_blokir
				);

				// Use the Blokir_model to save the data
				$inserted = $this->Blokir_model->simpan_blokir($data);

				// Redirect to the appropriate page
				redirect('users/data_blokir');
			} else {
				// If the form is not submitted, load the view
				$this->load->view('users/data_blokir'); // Sesuaikan dengan struktur folder dan nama file yang benar
			}
		}
	}

	public function hapus_blokir($id)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			// Load model Blokir_model
			$this->load->model('Blokir_model');

			$this->Blokir_model->hapus_blokir($id);
			redirect('users/data_blokir');
		}
	}

	public function edit_blokir($id)
	{	// Check if the user is logged in
		$ceks = $this->session->userdata('user@mt');
		$id_user = $this->session->userdata('id_user@mt');

		if (!isset($ceks)) {
			redirect('web/login');
		} else {

			$data['user'] = $this->Mcrud->get_users_by_un($ceks);

			$data['judul_web'] = "Edit Data Blokir | MelatiApp";

			$this->load->model('Blokir_model');

			$data['blokir'] = $this->Blokir_model->get_blokir_by_id($id);

			$this->load->view('users/header', $data);
			$this->load->view('users/blokir/edit_blokir', $data);
			$this->load->view('users/footer');
		}
	}

	public function update_blokir($id)
	{
		$ceks = $this->session->userdata('user@mt');

		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Blokir_model');

			// Ambil data blokir berdasarkan ID
			$existing_blokir = $this->Blokir_model->get_blokir_by_id($id);

			// Mendapatkan nilai status dari form
			$status = $this->input->post('status');

			$data = array(
				'kantor' => $this->input->post('kantor'),
				'petugas' => $this->input->post('petugas'),
				'no_rek' => $this->input->post('no_rek'),
				'nama' => $this->input->post('nama'),
				'tanggal' => $this->input->post('tanggal'),
				'jumlah' => $this->input->post('jumlah'),
				'keterangan' => $this->input->post('keterangan'),
				'nomor_blokir' => $this->input->post('nomor_blokir'),
				'status' => $status // Memasukkan nilai status dari form
			);

			// Panggil model untuk update data
			$this->Blokir_model->update_blokir($id, $data);

			// Redirect ke halaman data_blokir
			redirect('users/data_blokir');
		}
	}




	// scan qr
	public function qr()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Qr Scanner | MelatiApp";

			$this->load->view('users/header', $data);
			$this->load->view('users/qr/qr');
			$this->load->view('users/footer');
		}
	}
	// /scan qr

	// Start Produk
	public function produk_simpati()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {

			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Simpati | MelatiApp"; // Judul halaman

			$this->load->view('users/header', $data);
			$this->load->view('users/produk/produk_simpati');
			$this->load->view('users/footer');
		}
	}

	public function produk_simasya()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {

			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Simasya | MelatiApp"; // Judul halaman

			$this->load->view('users/header', $data);
			$this->load->view('users/produk/produk_simasya');
			$this->load->view('users/footer');
		}
	}

	public function produk_simaya()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {

			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Simaya | MelatiApp"; // Judul halaman

			$this->load->view('users/header', $data);
			$this->load->view('users/produk/produk_simaya');
			$this->load->view('users/footer');
		}
	}

	public function produk_simatang()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {

			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Simatang | MelatiApp"; // Judul halaman

			$this->load->view('users/header', $data);
			$this->load->view('users/produk/produk_simatang');
			$this->load->view('users/footer');
		}
	}

	public function produk_simaroh()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {

			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Simaroh | MelatiApp"; // Judul halaman

			$this->load->view('users/header', $data);
			$this->load->view('users/produk/produk_simaroh');
			$this->load->view('users/footer');
		}
	}

	public function produk_simpel()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {

			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Simpel | MelatiApp"; // Judul halaman

			$this->load->view('users/header', $data);
			$this->load->view('users/produk/produk_simpel');
			$this->load->view('users/footer');
		}
	}

	public function produk_simmka()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {

			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Simmka | MelatiApp"; // Judul halaman

			$this->load->view('users/header', $data);
			$this->load->view('users/produk/produk_simmka');
			$this->load->view('users/footer');
		}
	}

	public function syarat_ketentuan()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {

			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Syarat dan Ketentuan | MelatiApp"; // Judul halaman

			$this->load->view('users/header', $data);
			$this->load->view('users/produk/syarat_ketentuan');
			$this->load->view('users/footer');
		}
	}

	public function form_simpanan()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {

			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Pembukaan Rekening Simpanan | MelatiApp"; // Judul halaman

			$this->load->view('users/header', $data);
			$this->load->view('users/produk/form_simpanan');
			$this->load->view('users/footer');
		}
	}

	// end Produk

	public function update_location()
	{
		// Terima data lokasi dari permintaan POST
		$latitude = $this->input->post('latitude');
		$longitude = $this->input->post('longitude');
		$loc_update_time = date('Y-m-d H:i:s'); // Menambahkan waktu saat ini

		// Simpan data lokasi ke dalam database (sesuaikan dengan model Anda)
		$this->load->model('User_model');
		$user_id = $this->session->userdata('id_user@mt');
		$this->User_model->updateLocation($user_id, $latitude, $longitude);

		// Tambahkan pembaruan loc_update_time
		$this->User_model->updateLocUpdateTime($user_id, $loc_update_time);


		// Beri respons sukses
		echo json_encode(['status' => 'success']);
	}

	// Start admin panel
	public function edit_info()
	{
		$ceks = $this->session->userdata('user@mt');

		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Edit info | MelatiApp";
			$this->load->model('Edit_info_model');
			$data['info'] = $this->Edit_info_model->getInfo();

			// Process form submission for updating information
			if (isset($_POST['btnupdate'])) {
				$id = $this->input->post('id');

				$data_to_update = array();
				foreach ($_POST as $key => $value) {
					// Check if the key starts with 'info_' and is not 'id'
					if (strpos($key, 'info_') === 0 && $key !== 'id') {
						$field_name = $key;
						$field_value = htmlentities(strip_tags($value));
						$data_to_update[$field_name] = $field_value;
					}
				}

				$this->Edit_info_model->editInfo($data_to_update, $id);

				$this->session->set_flashdata('msg', '<div class="alert alert-success">Information updated successfully!</div>');
				redirect('users/edit_info');
			}

			// Load the view to edit the information
			$this->load->view('users/header', $data);
			$this->load->view('users/edit_info/edit_info', $data);
			$this->load->view('users/footer');
		}
	}
	// end admin panel

	// Start absen panel
	public function edit_absen()
	{
		$ceks = $this->session->userdata('user@mt');

		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Edit Absen | MelatiApp";
			$this->load->model('Edit_absen_model');

			// Mengambil tanggal dari URL menggunakan input get
			$tanggal = $this->input->get('tgl') ? $this->input->get('tgl') : date('Y-m-d');
			$data['absensi'] = $this->Edit_absen_model->getAbsenByDate($tanggal);

			// Load view untuk mengedit informasi
			$this->load->view('users/header', $data);
			$this->load->view('users/edit_info/edit_absen', $data);
			$this->load->view('users/footer');
		}
	}

	public function edit_absen_manual()
	{
		$ceks = $this->session->userdata('user@mt');

		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Data Absen Manual | MelatiApp";
			$this->load->model('Edit_absen_model_manual');

			// Mengambil tahun dan bulan dari URL menggunakan input get
			$tahun = $this->input->get('tahun') ? $this->input->get('tahun') : date('Y');
			$bulan = $this->input->get('bulan') ? $this->input->get('bulan') : date('m');

			$id_user = $this->session->userdata('id_user'); // Mendapatkan id_user dari session

			// Mengambil data absensi berdasarkan bulan dan id_user
			$data['absensi'] = $this->Edit_absen_model_manual->getAbsenManualByBulan($id_user, $tahun, $bulan);

			// Load view untuk mengedit informasi
			$this->load->view('users/header', $data);
			$this->load->view('users/edit_info/edit_absen_manual', $data);
			$this->load->view('users/footer');
		}
	}

	public function edit_absen_manual_rekap()
	{
		$ceks = $this->session->userdata('user@mt');

		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Data Absen Manual | MelatiApp";
			$this->load->model('Edit_absen_model_manual');

			// Get start and end date from URL, default to current month range if not set
			$tanggal_awal = $this->input->get('tanggal_awal') ? $this->input->get('tanggal_awal') : date('Y-m-d');
			$tanggal_akhir = $this->input->get('tanggal_akhir') ? $this->input->get('tanggal_akhir') : date('Y-m-d');

			// Validate the date range
			$date_start = new DateTime($tanggal_awal);
			$date_end = new DateTime($tanggal_akhir);

			if ($date_end < $date_start) {
				// Handle invalid date range (end date before start date)
				$tanggal_akhir = $tanggal_awal;
			}

			// Get data for all users within the date range
			$data['absensi'] = $this->Edit_absen_model_manual->getAbsenManualByDateRange($tanggal_awal, $tanggal_akhir);

			// Load views
			$this->load->view('users/header', $data);
			$this->load->view('users/edit_info/edit_absen_manual_rekap', $data);
			$this->load->view('users/footer');
		}
	}

	public function edit_absen_id($id_absen)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Edit_absen_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Edit Absen | MelatiApp";
			$data['absen'] = $this->Edit_absen_model->getAbsenById($id_absen);

			$this->load->view('users/header', $data);
			$this->load->view('users/edit_info/edit_absen_id', $data);
			$this->load->view('users/footer');
		}
	}

	public function edit_absen_tambah()
	{
		// Periksa apakah pengguna sudah login
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			// Load model
			$this->load->model('Edit_absen_model');

			// Mendapatkan data pengguna
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);

			// Judul halaman
			$data['judul_web'] = "Tambah Absen | MelatiApp";
			$data['nama_lengkap'] = $this->Edit_absen_model->getAllUsers();

			// Load view
			$this->load->view('users/header', $data);
			$this->load->view('users/edit_info/edit_absen_tambah', $data);
			$this->load->view('users/footer');
		}
	}

	public function edit_absen_tambah_sys()
	{
		// Periksa apakah pengguna sudah login
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			// Load model
			$this->load->model('Edit_absen_model');

			// Mendapatkan data pengguna
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);

			// Judul halaman
			$data['judul_web'] = "Tambah Absen | MelatiApp";
			$data['nama_lengkap'] = $this->Edit_absen_model->getAllUsers();

			// Load view
			$this->load->view('users/header', $data);
			$this->load->view('users/edit_info/edit_absen_tambah_sys', $data);
			$this->load->view('users/footer');
		}
	}

	public function edit_absen_tambah_cuti()
	{
		// Periksa apakah pengguna sudah login
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			// Load model
			$this->load->model('Edit_absen_model');

			// Mendapatkan data pengguna
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);

			// Judul halaman
			$data['judul_web'] = "Tambah Absen Cuti | MelatiApp";
			$data['nama_lengkap'] = $this->Edit_absen_model->getAllUsers();

			// Load view
			$this->load->view('users/header', $data);
			$this->load->view('users/edit_info/edit_absen_tambah_cuti', $data);
			$this->load->view('users/footer');
		}
	}

	public function edit_absen_tambah_sakit()
	{
		// Periksa apakah pengguna sudah login
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			// Load model
			$this->load->model('Edit_absen_model');

			// Mendapatkan data pengguna
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);

			// Judul halaman
			$data['judul_web'] = "Tambah Absen Sakit | MelatiApp";
			$data['nama_lengkap'] = $this->Edit_absen_model->getAllUsers();

			// Load view
			$this->load->view('users/header', $data);
			$this->load->view('users/edit_info/edit_absen_tambah_sakit', $data);
			$this->load->view('users/footer');
		}
	}

	public function edit_absen_tambah_perjalanan_tugas()
	{
		// Periksa apakah pengguna sudah login
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			// Load model
			$this->load->model('Edit_absen_model');

			// Mendapatkan data pengguna
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);

			// Judul halaman
			$data['judul_web'] = "Tambah Absen Perjalanan Tugas | MelatiApp";
			$data['nama_lengkap'] = $this->Edit_absen_model->getAllUsers();

			// Load view
			$this->load->view('users/header', $data);
			$this->load->view('users/edit_info/edit_absen_tambah_perjalanan_tugas', $data);
			$this->load->view('users/footer');
		}
	}

	public function edit_absen_tambah_manual()
	{
		// Periksa apakah pengguna sudah login
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			// Load model
			$this->load->model('Edit_absen_model_manual');

			// Mendapatkan data pengguna
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);

			// Judul halaman
			$data['judul_web'] = "Tambah Absen Manual | MelatiApp";
			$data['nama_lengkap'] = $this->Edit_absen_model_manual->getAllUsers();

			// Load view
			$this->load->view('users/header', $data);
			$this->load->view('users/edit_info/edit_absen_tambah_manual', $data);
			$this->load->view('users/footer');
		}
	}

	public function simpan_absen()
	{
		// Check if the user is logged in
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			// Load model Edit_absen_model
			$this->load->model('Edit_absen_model');

			// Check if the form is submitted
			if ($this->input->post()) {
				// Ambil data dari form
				$tgl = date('Y-m-d', strtotime($this->input->post('tgl')));
				$waktu = date('H:i:s', strtotime($this->input->post('waktu')));
				$keterangan = $this->input->post('keterangan');
				$inpuser = $this->input->post('inpuser');
				$jns_absen = $this->input->post('jns_absen');
				$id_user = $this->input->post('id_user');
				$latitude = $this->input->post('latitude');
				$longitude = $this->input->post('longitude');
				$keterangan_absen = $this->input->post('keterangan_absen');

				// Set up the data array
				$data = array(
					'tgl' => $tgl,
					'waktu' => $waktu,
					'keterangan' => $keterangan,
					'inpuser' => $inpuser,
					'jns_absen' => $jns_absen,
					'id_user' => $id_user,
					'latitude' => $latitude,
					'longitude' => $longitude,
					'keterangan_absen' => $keterangan_absen
				);

				// Check if a file is selected
				if (!empty($_FILES['lampiran']['name'])) {
					// Konfigurasi pengaturan unggah gambar
					$config['upload_path'] = './foto/foto_absen/';
					$config['allowed_types'] = 'jpg|jpeg|png|gif';
					$config['max_size'] = 20048; // 2MB
					$this->load->library('upload');

					// Inisialisasi pustaka unggah dengan konfigurasi
					$this->upload->initialize($config);

					// Periksa apakah file berhasil diunggah
					if (!$this->upload->do_upload('lampiran')) {
						// Tangani kesalahan unggah file
						$this->session->set_flashdata('msg', 'Error: ' . $this->upload->display_errors());
						redirect('users/edit_absen');
					}

					// Dapatkan data file yang diunggah
					$upload_data = $this->upload->data();
					$foto_absen_path = $upload_data['file_name'];

					// Tetapkan jalur file dalam array data
					$data['lampiran'] = $foto_absen_path;
				}

				// Gunakan Edit_absen_model untuk menyimpan data
				$this->Edit_absen_model->simpanAbsen($data);

				// Redirect ke halaman yang sesuai
				redirect('users/edit_absen');
			} else {
				// Jika formulir tidak dikirimkan, muat tampilan
				$this->load->view('users/edit_absen');
			}
		}
	}

	public function simpan_absen_manual()
	{
		// Check if the user is logged in
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			// Load model Edit_absen_model
			$this->load->model('Edit_absen_model_manual');

			// Check if the form is submitted
			if ($this->input->post()) {
				// Ambil data dari form
				$tgl = date('Y-m-d', strtotime($this->input->post('tgl')));
				$waktu = date('H:i:s', strtotime($this->input->post('waktu')));
				$keterangan = $this->input->post('keterangan');
				$id_user = $this->input->post('id_user');
				$latitude = $this->input->post('latitude');
				$longitude = $this->input->post('longitude');
				$keterangan_absen = $this->input->post('keterangan_absen');

				// Set up the data array
				$data = array(
					'tgl' => $tgl,
					'waktu' => $waktu,
					'keterangan' => $keterangan,
					'id_user' => $id_user,
					'latitude' => $latitude,
					'longitude' => $longitude,
					'keterangan_absen' => $keterangan_absen
					// Tambahkan data lainnya sesuai kebutuhan
				);

				// Check if a file is selected
				if (!empty($_FILES['foto_absen']['name'])) {
					// Konfigurasi pengaturan unggah gambar
					$config['upload_path'] = './foto/foto_absen/manual';
					$config['allowed_types'] = 'gif|jpg|png';
					$config['max_size'] = 20048; // 2MB
					$this->load->library('upload');

					// Inisialisasi pustaka unggah dengan konfigurasi
					$this->upload->initialize($config);

					// Periksa apakah file berhasil diunggah
					if (!$this->upload->do_upload('foto_absen')) {
						// Tangani kesalahan unggah file
						$this->session->set_flashdata('msg', 'Error: ' . $this->upload->display_errors());
						redirect('users/edit_absen');
					}

					// Dapatkan data file yang diunggah
					$upload_data = $this->upload->data();
					$foto_absen_path = $upload_data['file_name'];

					// Tetapkan jalur file dalam array data
					$data['foto_absen'] = $foto_absen_path;
				}

				// Gunakan Edit_absen_model untuk menyimpan data
				$this->Edit_absen_model_manual->simpanAbsen($data);

				// Redirect ke halaman yang sesuai
				redirect('users/edit_absen');
			} else {
				// Jika formulir tidak dikirimkan, muat tampilan
				$this->load->view('users/edit_absen');
			}
		}
	}

	public function update_absen($id_absen)
	{
		// Ambil data dari form
		$data = array(
			'tgl' => date('Y-m-d', strtotime($this->input->post('tgl'))),
			'waktu' => date('H:i:s', strtotime($this->input->post('waktu'))),
			'keterangan' => $this->input->post('keterangan'),
			'chuser' => $this->input->post('chuser'),
			'jns_absen' => $this->input->post('jns_absen'),
			'id_user' => $this->input->post('id_user'),
			'latitude' => $this->input->post('latitude'),
			'longitude' => $this->input->post('longitude'),
			'keterangan_absen' => $this->input->post('keterangan_absen')
		);

		// Konfigurasi untuk upload foto_absen
		if (!empty($_FILES['foto_absen']['name'])) {
			$config_foto_absen['upload_path'] = './foto/foto_absen/absensi/';
			$config_foto_absen['allowed_types'] = 'jpg|jpeg|png|gif';
			$config_foto_absen['max_size'] = 2048; // Maksimal 2MB
			$config_foto_absen['file_name'] = time() . '_' . $_FILES['foto_absen']['name']; // Rename file
			$this->load->library('upload');

			$this->upload->initialize($config_foto_absen);

			if ($this->upload->do_upload('foto_absen')) {
				$upload_foto_absen = $this->upload->data();
				$data['foto_absen'] = $upload_foto_absen['file_name'];
			} else {
				// Jika gagal upload, tampilkan error
				$this->session->set_flashdata('msg', 'Error Upload Foto Absen: ' . $this->upload->display_errors());
				redirect('users/edit_absen');
			}
		}

		// Konfigurasi untuk upload lampiran
		if (!empty($_FILES['lampiran']['name'])) {
			$config_lampiran['upload_path'] = './foto/foto_absen/';
			$config_lampiran['allowed_types'] = 'jpg|jpeg|png|gif|pdf|docx';
			$config_lampiran['max_size'] = 5120; // Maksimal 5MB
			$config_lampiran['file_name'] = time() . '_' . $_FILES['lampiran']['name']; // Rename file
			$this->load->library('upload');

			$this->upload->initialize($config_lampiran);

			if ($this->upload->do_upload('lampiran')) {
				$upload_lampiran = $this->upload->data();
				$data['lampiran'] = $upload_lampiran['file_name'];
			} else {
				// Jika gagal upload, tampilkan error
				$this->session->set_flashdata('msg', 'Error Upload Lampiran: ' . $this->upload->display_errors());
				redirect('users/edit_absen');
			}
		}

		// Panggil model untuk mengupdate data absen
		$this->Edit_absen_model->updateAbsen($id_absen, $data);

		// Redirect ke halaman edit_absen setelah menyimpan data
		redirect('users/edit_absen');
	}


	public function hapus_absen($id_absen)
	{
		// Panggil model untuk menghapus data absen berdasarkan ID
		$this->Edit_absen_model->hapusAbsen($id_absen);

		echo json_encode(['success' => true]);
		exit();
	}

	public function hapus_absen_manual($id_absen)
	{
		// Panggil model untuk menghapus data absen berdasarkan ID
		$this->Edit_absen_model_manual->hapusAbsen($id_absen);

		// Redirect ke halaman edit_absen setelah menghapus data
		redirect('users/edit_absen_manual');
	}
	// end absen panel

	public function info_karyawan()
	{
		$ceks = $this->session->userdata('user@mt');

		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Absen Info| MelatiApp";
			$this->load->model('Absensi_model');

			// Mengambil tanggal dari URL menggunakan input get
			$tanggal = $this->input->get('tgl') ? $this->input->get('tgl') : date('Y-m-d');
			$data['absensi'] = $this->Absensi_model->getAbsenByDate($tanggal);

			// Load view untuk mengedit informasi
			$this->load->view('users/header', $data);
			$this->load->view('users/absensi/info_karyawan', $data);
			$this->load->view('users/footer');
		}
	}

	public function under_construction()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Under Construction | MelatiApp";

			$this->load->view('users/header', $data);
			$this->load->view('users/under_construction');
			$this->load->view('users/footer');
		}
	}

	public function agunan()
	{
		$ceks = $this->session->userdata('user@mt');

		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Agunan_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Agunan | MelatiApp";

			$cek = $data['user']->row();
			$level = $cek->level;
			$kode_kantor = $cek->kode_kantor;

			$allowedLevels = [''];

			// Capture selected "kode kantor" from the dropdown
			$selected_kode_kantor = $this->input->get('kode_kantor', TRUE);

			// If the user selects "All Kantor" (represented by 'all'), set $selected_kode_kantor to null
			if ($selected_kode_kantor == 'all') {
				$selected_kode_kantor = null;
			} elseif (!$selected_kode_kantor) {
				$selected_kode_kantor = $kode_kantor; // Default to user's "kode kantor"
			}

			// Fetch filtered data by "kode kantor" or show all for "s_admin" and "kabag_arsip"
			if (!in_array($level, $allowedLevels)) {
				$data['agunan_data'] = $this->Agunan_model->get_data_agunan($selected_kode_kantor);
			} else {
				$data['agunan_data'] = $this->Agunan_model->get_data_agunan(); // Show all data
			}

			// Pass "kode kantor" data to view for dropdown options
			$data['selected_kode_kantor'] = $selected_kode_kantor;
			$data['kantorNames'] = [
				'all' => 'SEMUA KANTOR',
				'01' => 'PUSAT',
				'02' => 'SEDAYU',
				'03' => 'SAPURAN',
				'04' => 'KERTEK',
				'05' => 'WONOSOBO',
				'06' => 'KALIWIRO',
				'07' => 'BANJARNEGARA',
				'08' => 'RANDUSARI',
				'09' => 'KEPIL'
			];

			// Load view untuk mengedit informasi
			$this->load->view('users/header', $data);
			$this->load->view('users/agunan/agunan', $data);
			$this->load->view('users/footer');
		}
	}

	public function agunan_shm()
	{
		$ceks = $this->session->userdata('user@mt');

		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Agunan_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Agunan SHM | MelatiApp";

			$cek = $data['user']->row();
			$level = $cek->level;
			$kode_kantor = $cek->kode_kantor;

			$allowedLevels = [''];

			// Capture selected "kode kantor" from the dropdown
			$selected_kode_kantor = $this->input->get('kode_kantor', TRUE);

			// If the user selects "All Kantor" (represented by 'all'), set $selected_kode_kantor to null
			if ($selected_kode_kantor == 'all') {
				$selected_kode_kantor = null;
			} elseif (!$selected_kode_kantor) {
				$selected_kode_kantor = $kode_kantor; // Default to user's "kode kantor"
			}

			// Fetch filtered data by "kode kantor" or show all for "s_admin" and "kabag_arsip"
			if (!in_array($level, $allowedLevels)) {
				$data['agunan_data'] = $this->Agunan_model->get_data_agunan_shm($selected_kode_kantor);
			} else {
				$data['agunan_data'] = $this->Agunan_model->get_data_agunan_shm(); // Show all data
			}

			// Pass "kode kantor" data to view for dropdown options
			$data['selected_kode_kantor'] = $selected_kode_kantor;
			$data['kantorNames'] = [
				'all' => 'SEMUA KANTOR',
				'01' => 'PUSAT',
				'02' => 'SEDAYU',
				'03' => 'SAPURAN',
				'04' => 'KERTEK',
				'05' => 'WONOSOBO',
				'06' => 'KALIWIRO',
				'07' => 'BANJARNEGARA',
				'08' => 'RANDUSARI',
				'09' => 'KEPIL'
			];

			// Load view untuk mengedit informasi
			$this->load->view('users/header', $data);
			$this->load->view('users/agunan/agunan_shm', $data);
			$this->load->view('users/footer');
		}
	}

	public function agunan_tambah()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);

			$data['judul_web'] = "Tambah data Agunan BPKB | MelatiApp";

			$this->load->view('users/header', $data);
			$this->load->view('users/agunan/agunan_tambah');
			$this->load->view('users/footer');
		}
	}

	public function agunan_tambah_shm()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);

			$data['judul_web'] = "Tambah data Agunan SHM | MelatiApp";

			$this->load->view('users/header', $data);
			$this->load->view('users/agunan/agunan_tambah_shm');
			$this->load->view('users/footer');
		}
	}

	public function agunan_lihat($id)
	{
		// Check if the user is logged in
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			// Load model
			$this->load->model('Agunan_model');

			// Get data agunan by ID
			$data['agunan'] = $this->Agunan_model->get_agunan_by_id($id);

			// Check if agunan data is found
			if ($data['agunan']) {
				$data['user'] = $this->Mcrud->get_users_by_un($ceks);
				$data['judul_web'] = "Detail Agunan | MelatiApp";

				// Load view untuk menampilkan detail agunan
				$this->load->view('users/header', $data);
				$this->load->view('users/agunan/agunan_lihat', $data);
				$this->load->view('users/footer');
			} else {
				// Jika data tidak ditemukan, redirect ke halaman list agunan
				redirect('users/agunan');
			}
		}
	}

	public function agunan_lihat_shm($id)
	{
		// Check if the user is logged in
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			// Load model
			$this->load->model('Agunan_model');

			// Get data agunan by ID
			$data['agunan'] = $this->Agunan_model->get_agunan_by_id_shm($id);

			// Check if agunan data is found
			if ($data['agunan']) {
				$data['user'] = $this->Mcrud->get_users_by_un($ceks);
				$data['judul_web'] = "Detail Agunan | MelatiApp";

				// Load view untuk menampilkan detail agunan
				$this->load->view('users/header', $data);
				$this->load->view('users/agunan/agunan_lihat_shm', $data);
				$this->load->view('users/footer');
			} else {
				// Jika data tidak ditemukan, redirect ke halaman list agunan
				redirect('users/agunan_shm');
			}
		}
	}

	public function agunan_delete($id)
	{
		// Check if the user is logged in
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			// Load model
			$this->load->model('Agunan_model');

			// Hapus data agunan berdasarkan ID
			$this->Agunan_model->agunan_delete($id);

			// Redirect ke halaman list agunan
			redirect('users/agunan');
		}
	}

	public function agunan_delete_shm($id)
	{
		// Check if the user is logged in
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			// Load model
			$this->load->model('Agunan_model');

			// Hapus data agunan berdasarkan ID
			$this->Agunan_model->agunan_delete_shm($id);

			// Redirect ke halaman list agunan
			redirect('users/agunan_shm');
		}
	}

	public function agunan_edit($id)
	{
		// Check if the user is logged in
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			// Load model
			$this->load->model('Agunan_model');

			// Get data agunan by ID
			$data['agunan'] = $this->Agunan_model->get_agunan_by_id($id);

			// Check if agunan data is found
			if ($data['agunan']) {
				$data['user'] = $this->Mcrud->get_users_by_un($ceks);
				$data['judul_web'] = "Edit Agunan | MelatiApp";

				// Load view untuk menampilkan form edit agunan
				$this->load->view('users/header', $data);
				$this->load->view('users/agunan/agunan_edit', $data);
				$this->load->view('users/footer');
			} else {
				// Jika data tidak ditemukan, redirect ke halaman list agunan
				redirect('users/agunan');
			}
		}
	}

	public function agunan_edit_shm($id)
	{
		// Check if the user is logged in
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			// Load model
			$this->load->model('Agunan_model');

			// Get data agunan by ID
			$data['agunan'] = $this->Agunan_model->get_agunan_by_id_shm($id);

			// Check if agunan data is found
			if ($data['agunan']) {
				$data['user'] = $this->Mcrud->get_users_by_un($ceks);
				$data['judul_web'] = "Edit Agunan | MelatiApp";

				// Load view untuk menampilkan form edit agunan
				$this->load->view('users/header', $data);
				$this->load->view('users/agunan/agunan_edit_shm', $data);
				$this->load->view('users/footer');
			} else {
				// Jika data tidak ditemukan, redirect ke halaman list agunan
				redirect('users/agunan_shm');
			}
		}
	}

	public function agunan_simpan()
	{
		// Check if the user is logged in
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			// Load model Edit_absen_model
			$this->load->model('Agunan_model');

			// Check if the form is submitted
			if ($this->input->post()) {
				// Ambil data dari form
				$tanggal = date('Y-m-d', strtotime($this->input->post('tanggal')));
				$tanggal_masuk = date('Y-m-d', strtotime($this->input->post('inptgljam')));
				$nama_anggota = $this->input->post('nm');
				$alamat = $this->input->post('alamat');
				$kode_kantor = $this->input->post('kdloc');
				$no_kontrak = $this->input->post('nokontrak');
				$no_registrasi = $this->input->post('noreg');
				$jenis_jaminan = $this->input->post('jnsjamin');
				$plafond = $this->input->post('digunakan');
				$jenis_dokumen = $this->input->post('jnsdokumen');
				$atas_nama = $this->input->post('an');
				$lokasi_jaminan = $this->input->post('lokasi');
				$keterangan = $this->input->post('catatan');
				$petugas_input = $this->input->post('username');
				$status = $this->input->post('status');
				$cabang = $this->input->post('cabang');
				$nama_pembawa = $this->input->post('pembawa');
				$catatan_status = $this->input->post('catatan_status');

				// Set up the data array
				$data = array(
					'tanggal' => $tanggal,
					'tgl_masuk' => $tanggal_masuk,
					'nama_anggota' => $nama_anggota,
					'alamat' => $alamat,
					'kode_kantor' => $kode_kantor,
					'no_kontrak' => $no_kontrak,
					'no_registrasi' => $no_registrasi,
					'jenis_jaminan' => $jenis_jaminan,
					'plafond' => $plafond,
					'jenis_dokumen' => $jenis_dokumen,
					'atas_nama' => $atas_nama,
					'lokasi_jaminan' => $lokasi_jaminan,
					'keterangan' => $keterangan,
					'petugas_input' => $petugas_input,
					'status' => $status,
					'cabang' => $cabang,
					'nama_pembawa' => $nama_pembawa,
					'catatan' => $catatan_status,
				);

				if ($this->Agunan_model->check_no_kontrak_exists($no_kontrak)) {
					// Set flashdata message
					$this->session->set_flashdata('msg', 'No Kontrak sudah ada di database!');
					redirect('users/agunan_tambah');
				} else {

					// Check if a file is selected
					if (!empty($_FILES['foto_agunan']['name'])) {
						// Konfigurasi pengaturan unggah gambar
						$config['upload_path'] = './foto/foto_agunan/';
						$config['allowed_types'] = 'jpg|jpeg|png|gif';
						$config['max_size'] = 20048; // 2MB
						$this->load->library('upload');

						// Inisialisasi pustaka unggah dengan konfigurasi
						$this->upload->initialize($config);

						// Periksa apakah file berhasil diunggah
						if (!$this->upload->do_upload('foto_agunan')) {
							// Tangani kesalahan unggah file
							$this->session->set_flashdata('msg', 'Error: ' . $this->upload->display_errors());
							redirect('users/agunan');
						}

						// Dapatkan data file yang diunggah
						$upload_data = $this->upload->data();
						$foto_path = $upload_data['file_name'];

						// Tetapkan jalur file dalam array data
						$data['foto_agunan'] = $foto_path;
					}

					// Gunakan Edit_absen_model untuk menyimpan data
					$this->Agunan_model->agunan_simpan($data);

					// Redirect ke halaman yang sesuai
					redirect('users/agunan');
				}
			} else {
				// Jika formulir tidak dikirimkan, muat tampilan
				$this->load->view('users/agunan');
			}
		}
	}

	public function agunan_simpan_shm()
	{
		// Check if the user is logged in
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			// Load model Edit_absen_model
			$this->load->model('Agunan_model');

			// Check if the form is submitted
			if ($this->input->post()) {
				// Ambil data dari form
				$tanggal = date('Y-m-d', strtotime($this->input->post('tanggal')));
				$tanggal_masuk = date('Y-m-d', strtotime($this->input->post('inptgljam')));
				$nama_anggota = $this->input->post('nm');
				$alamat = $this->input->post('alamat');
				$kode_kantor = $this->input->post('kdloc');
				$no_kontrak = $this->input->post('nokontrak');
				$no_registrasi = $this->input->post('noreg');
				$jenis_jaminan = $this->input->post('jnsjamin');
				$plafond = $this->input->post('digunakan');
				$jenis_dokumen = $this->input->post('jnsdokumen');
				$atas_nama = $this->input->post('an');
				$lokasi_jaminan = $this->input->post('lokasi');
				$keterangan = $this->input->post('catatan');
				$petugas_input = $this->input->post('username');
				$status = $this->input->post('status');
				$cabang = $this->input->post('cabang');
				$nama_pembawa = $this->input->post('pembawa');
				$catatan_status = $this->input->post('catatan_status');

				// Set up the data array
				$data = array(
					'tanggal' => $tanggal,
					'tgl_masuk' => $tanggal_masuk,
					'nama_anggota' => $nama_anggota,
					'alamat' => $alamat,
					'kode_kantor' => $kode_kantor,
					'no_kontrak' => $no_kontrak,
					'no_registrasi' => $no_registrasi,
					'jenis_jaminan' => $jenis_jaminan,
					'plafond' => $plafond,
					'jenis_dokumen' => $jenis_dokumen,
					'atas_nama' => $atas_nama,
					'lokasi_jaminan' => $lokasi_jaminan,
					'keterangan' => $keterangan,
					'petugas_input' => $petugas_input,
					'status' => $status,
					'cabang' => $cabang,
					'nama_pembawa' => $nama_pembawa,
					'catatan' => $catatan_status,
				);

				if ($this->Agunan_model->check_no_kontrak_exists_shm($no_kontrak)) {
					// Set flashdata message
					$this->session->set_flashdata('msg', '<div class="alert alert-danger"><strong>Gagal!</strong> No Kontrak sudah ada di database!</div>');
					redirect('users/agunan_shm');
				} else {

					// Check if a file is selected
					if (!empty($_FILES['foto_agunan']['name'])) {
						// Konfigurasi pengaturan unggah gambar
						$config['upload_path'] = './foto/foto_agunan/';
						$config['allowed_types'] = 'jpg|jpeg|png|gif';
						$config['max_size'] = 20048; // 2MB
						$this->load->library('upload');

						// Inisialisasi pustaka unggah dengan konfigurasi
						$this->upload->initialize($config);

						// Periksa apakah file berhasil diunggah
						if (!$this->upload->do_upload('foto_agunan')) {
							// Tangani kesalahan unggah file
							$this->session->set_flashdata('msg', 'Error: ' . $this->upload->display_errors());
							redirect('users/agunan_shm');
						}

						// Dapatkan data file yang diunggah
						$upload_data = $this->upload->data();
						$foto_path = $upload_data['file_name'];

						// Tetapkan jalur file dalam array data
						$data['foto_agunan'] = $foto_path;
					}

					// Gunakan Edit_absen_model untuk menyimpan data
					$this->Agunan_model->agunan_simpan_shm($data);

					// Redirect ke halaman yang sesuai
					redirect('users/agunan_shm');
				}
			} else {
				// Jika formulir tidak dikirimkan, muat tampilan
				$this->load->view('users/agunan_shm');
			}
		}
	}

	public function agunan_update($id)
	{
		// Check if the user is logged in
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {

			// Check if the form is submitted
			if ($this->input->post()) {

				$status = $this->input->post('status');
				$tgl_masuk = $this->input->post('tgl_masuk');
				$cabang = $this->input->post('cabang');
				$nama_pembawa = $this->input->post('nama_pembawa'); // Adjust the key to 'nama_pembawa'
				$tanggal_ubah = $this->input->post('tanggal_ubah');
				$petugas_ubah = $this->input->post('petugas_ubah');
				$keterangan = $this->input->post('keterangan');
				$catatan = $this->input->post('catatan');

				// Set up the data array
				$data = array(
					'status' => $status,
					'tgl_masuk' => $tgl_masuk,
					'cabang' => $cabang,
					'nama_pembawa' => $nama_pembawa,
					'tanggal_ubah' => $tanggal_ubah,
					'petugas_ubah' => $petugas_ubah,
					'keterangan' => $keterangan,
					'catatan' => $catatan
				);

				// Check if a file is selected
				if (!empty($_FILES['foto_agunan']['name'])) {
					// Konfigurasi pengaturan unggah gambar
					$config['upload_path'] = './foto/foto_agunan/';
					$config['allowed_types'] = 'jpg|jpeg|png|gif';
					$config['max_size'] = 2048; // 2MB

					$this->upload->initialize($config);

					// Periksa apakah file berhasil diunggah
					if ($this->upload->do_upload('foto_agunan')) {
						// Dapatkan data file yang diunggah
						$upload_data = $this->upload->data();
						$foto_path = $upload_data['file_name'];
						$data['foto_agunan'] = $foto_path;
					}
				}

				$this->load->model('Agunan_model');
				$this->Agunan_model->agunan_update($id, $data);
			}
		}
	}

	public function agunan_update_shm($id)
	{
		// Check if the user is logged in
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {

			// Check if the form is submitted
			if ($this->input->post()) {

				$status = $this->input->post('status');
				$tgl_masuk = $this->input->post('tgl_masuk');
				$cabang = $this->input->post('cabang');
				$nama_pembawa = $this->input->post('nama_pembawa'); // Adjust the key to 'nama_pembawa'
				$tanggal_ubah = $this->input->post('tanggal_ubah');
				$petugas_ubah = $this->input->post('petugas_ubah');
				$keterangan = $this->input->post('keterangan');
				$catatan = $this->input->post('catatan');

				// Set up the data array
				$data = array(
					'status' => $status,
					'tgl_masuk' => $tgl_masuk,
					'cabang' => $cabang,
					'nama_pembawa' => $nama_pembawa,
					'tanggal_ubah' => $tanggal_ubah,
					'petugas_ubah' => $petugas_ubah,
					'keterangan' => $keterangan,
					'catatan' => $catatan
				);

				// Check if a file is selected
				if (!empty($_FILES['foto_agunan']['name'])) {
					// Konfigurasi pengaturan unggah gambar
					$config['upload_path'] = './foto/foto_agunan/';
					$config['allowed_types'] = 'jpg|jpeg|png|gif';
					$config['max_size'] = 2048; // 2MB

					$this->upload->initialize($config);

					// Periksa apakah file berhasil diunggah
					if ($this->upload->do_upload('foto_agunan')) {
						// Dapatkan data file yang diunggah
						$upload_data = $this->upload->data();
						$foto_path = $upload_data['file_name'];
						$data['foto_agunan'] = $foto_path;
					}
				}

				$this->load->model('Agunan_model');
				$this->Agunan_model->agunan_update_shm($id, $data);
			}
		}
	}

	public function agunan_update_status_proses($id)
	{
		// Check if the user is logged in
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {

			// Check if the form is submitted
			if ($this->input->post()) {

				$status_proses = $this->input->post('status_proses');
				$tanggal_ubah = $this->input->post('tanggal_ubah');
				$petugas_ubah = $this->input->post('petugas_ubah');
				$catatan = $this->input->post('catatan');

				// Set up the data array
				$data = array(

					'status_proses' => $status_proses,
					'tanggal_pesan' => $tanggal_ubah,
					'petugas_pesan' => $petugas_ubah,
					'catatan' => $catatan
				);

				$this->load->model('Agunan_model');
				$this->Agunan_model->agunan_update($id, $data);
			}
		}
	}

	public function agunan_update_status_proses_shm($id)
	{
		// Check if the user is logged in
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {

			// Check if the form is submitted
			if ($this->input->post()) {

				$status_proses = $this->input->post('status_proses');
				$tanggal_ubah = $this->input->post('tanggal_ubah');
				$petugas_ubah = $this->input->post('petugas_ubah');
				$catatan = $this->input->post('catatan');

				// Set up the data array
				$data = array(

					'status_proses' => $status_proses,
					'tanggal_pesan' => $tanggal_ubah,
					'petugas_pesan' => $petugas_ubah,
					'catatan' => $catatan
				);

				$this->load->model('Agunan_model');
				$this->Agunan_model->agunan_update_shm($id, $data);
			}
		}
	}

	public function agunan_info()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);

			$data['judul_web'] = "Info data Agunan | MelatiApp";

			$this->load->view('users/header', $data);
			$this->load->view('users/agunan/agunan_info');
			$this->load->view('users/footer');
		}
	}

	public function agunan_cetak($id)
	{
		// Memastikan pengguna telah login
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			// Query untuk mendapatkan data agunan berdasarkan ID
			$query = $this->db->query("SELECT * FROM tbl_agunan WHERE id = '$id'");

			// Memeriksa apakah data agunan ditemukan
			if ($query->num_rows() > 0) {
				$data['agunan'] = $query->row(); // Mengambil baris data agunan

				// Mengambil data pengguna dan judul halaman
				$data['user'] = $this->Mcrud->get_users_by_un($ceks);
				$data['judul_web'] = "Cetak Agunan | Melati-App";

				// Memuat view dengan data agunan
				$this->load->view('users/agunan/agunan_cetak', $data);
			} else {
				// Jika data agunan tidak ditemukan, arahkan ke halaman 404
				redirect('404_content');
			}
		}
	}

	public function agunan_cetak_shm($id)
	{
		// Memastikan pengguna telah login
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			// Query untuk mendapatkan data agunan berdasarkan ID
			$query = $this->db->query("SELECT * FROM tbl_agunan_shm WHERE id = '$id'");

			// Memeriksa apakah data agunan ditemukan
			if ($query->num_rows() > 0) {
				$data['agunan'] = $query->row(); // Mengambil baris data agunan

				// Mengambil data pengguna dan judul halaman
				$data['user'] = $this->Mcrud->get_users_by_un($ceks);
				$data['judul_web'] = "Cetak Agunan | Melati-App";

				// Memuat view dengan data agunan
				$this->load->view('users/agunan/agunan_cetak_shm', $data);
			} else {
				// Jika data agunan tidak ditemukan, arahkan ke halaman 404
				redirect('404_content');
			}
		}
	}

	// public function agunan_cetak($id)
	// {
	// 	$ceks = $this->session->userdata('user@mt');
	// 	if (!isset($ceks)) {
	// 		redirect('web/login');
	// 	} else {
	// 		$query1 = $this->db->query("SELECT * FROM tbl_agunan WHERE id = '$id'");
	// 		$query2 = $this->db->query("SELECT COUNT(*) AS jumlah_jaminan FROM TOFJAMIN WHERE nokontrak = (SELECT no_kontrak FROM tbl_agunan WHERE id = '$id')");

	// 		if ($query1->num_rows() > 0) {
	// 			$data['agunan'] = $query1->row(); 
	// 			$data['jumlah_jaminan'] = $query2->row()->jumlah_jaminan;

	// 			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
	// 			$data['judul_web'] = "Cetak Agunan | Melati-App";

	// 			$this->load->view('users/agunan/agunan_cetak', $data);
	// 		} else {
	// 			redirect('404_content');
	// 		}
	// 	}
	// }

	// public function agunan_cetak_shm($id)
	// {
	// 	$ceks = $this->session->userdata('user@mt');
	// 	if (!isset($ceks)) {
	// 		redirect('web/login');
	// 	} else {
	// 		$query1 = $this->db->query("SELECT * FROM tbl_agunan_shm WHERE id = '$id'");
	// 		$query2 = $this->db->query("SELECT COUNT(*) AS jumlah_jaminan FROM TOFJAMIN WHERE nokontrak = (SELECT no_kontrak FROM tbl_agunan_shm WHERE id = '$id')");

	// 		if ($query1->num_rows() > 0) {
	// 			$data['agunan'] = $query1->row(); 
	// 			$data['jumlah_jaminan'] = $query2->row()->jumlah_jaminan;

	// 			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
	// 			$data['judul_web'] = "Cetak Agunan | Melati-App";

	// 			$this->load->view('users/agunan/agunan_cetak_shm', $data);
	// 		} else {
	// 			redirect('404_content');
	// 		}
	// 	}
	// }

	public function agunan_data_proses()
	{
		$ceks = $this->session->userdata('user@mt');

		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Agunan_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Data Agunan Proses | MelatiApp";

			$data['agunan_data'] = $this->Agunan_model->get_data_agunan_proses();
			$data['agunan_tracking'] = $this->Agunan_model->get_data_agunan_bergerak();

			// Load view untuk mengedit informasi
			$this->load->view('users/header', $data);
			$this->load->view('users/agunan/agunan_data_proses', $data);
			$this->load->view('users/footer');
		}
	}

	public function agunan_data_proses_cabang()
	{
		$ceks = $this->session->userdata('user@mt');

		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Mcrud');
			$this->load->model('Agunan_model');

			// Mengambil data user
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			if ($data['user']->num_rows() > 0) {
				$user = $data['user']->row();
				$kode_kantor = $user->kode_kantor;  // Mengambil kode_kantor dari data user

				// Memanggil fungsi model dengan parameter kode_kantor
				$data['agunan_data'] = $this->Agunan_model->get_data_agunan_proses_cabang($kode_kantor);
				$data['agunan_tracking'] = $this->Agunan_model->get_data_agunan_bergerak();
			} else {
				// Jika user tidak ditemukan, arahkan ke halaman login
				redirect('web/login');
			}

			$data['judul_web'] = "Data Agunan Proses Cabang | MelatiApp";

			// Load view untuk menampilkan data
			$this->load->view('users/header', $data);
			$this->load->view('users/agunan/agunan_data_proses_cabang', $data);
			$this->load->view('users/footer');
		}
	}


	public function update_device_info()
	{
		// Get the device info from the POST request
		$device_info = $this->input->post('device_info');
		$user_id = $this->session->userdata('id_user@mt');

		if ($user_id && $device_info) {
			// Load the User_model if not already loaded
			$this->load->model('User_model');

			// Update device info in the database
			$this->User_model->updateDeviceInfo($user_id, $device_info);

			// Send a success response
			echo json_encode(['status' => 'success']);
		} else {
			// Send an error response
			echo json_encode(['status' => 'error', 'message' => 'Invalid user or device info']);
		}
	}

	public function menu()
	{
		$ceks = $this->session->userdata('user@mt');
		$id_user = $this->session->userdata('id_user@mt');

		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Menu_model');
			$this->load->model('Monitoring_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['users'] = $this->Mcrud->get_users();
			$data['judul_web'] = "Menu | MelatiApp ";

			$data['menus'] = $this->Menu_model->get_user_accessible_menus_lainnya();

			// Ambil tanggal_awal dan tanggal_akhir dari input pengguna
			$tanggal_awal = $this->input->get('tanggal_awal');
			if (empty($tanggal_awal)) {
				$tanggal_awal = date('Y-m-d', strtotime('-5 years')); // Default ke 5 tahun lalu dari hari ini
			}
			$tanggal_akhir = $this->input->get('tanggal_akhir');
			if (empty($tanggal_akhir)) {
				$tanggal_akhir = date('Y-m-d'); // Default ke tanggal hari ini
			}

			// Ambil data berdasarkan tanggal_awal dan tanggal_akhir
			$data['agunan_data'] = $this->Monitoring_model->get_data_monitoring($tanggal_awal, $tanggal_akhir);
			$data['jenis_usaha_counts'] = $this->Monitoring_model->get_jenis_usaha_counts();

			$this->load->view('users/header', $data);
			$this->load->view('users/menu/menu', $data);
			$this->load->view('users/footer');
		}
	}

	public function edit_banner()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);

			$data['judul_web'] = "Edit Banner | MelatiApp";


			$this->load->view('users/header', $data);
			$this->load->view('users/edit_info/edit_banner');
			$this->load->view('users/footer');
		}
	}

	public function submit_banner()
	{
		// Periksa apakah pengguna sudah login (sesi ada)
		if (!$this->session->userdata('username')) {
			// Jika tidak ada sesi, alihkan pengguna ke halaman login atau berikan pesan kesalahan
			redirect('web/login'); // Ubah URL sesuai dengan alamat halaman login Anda
		}

		// Check if a file is selected
		if (!empty($_FILES['foto_banner']['name'])) {
			// Konfigurasi pengaturan upload gambar
			$config['upload_path'] = './foto/foto_banner/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif';
			$config['max_size'] = 20048; // 20MB
			$this->load->library('upload');

			// Inisialisasi perpustakaan upload dengan konfigurasi
			$this->upload->initialize($config);

			// Check if the file is successfully uploaded
			if (!$this->upload->do_upload('foto_banner')) {
				// Handle error uploading the file
			}

			// Get the uploaded file data
			$upload_data = $this->upload->data();
			$foto_banner_path = $upload_data['file_name'];

			// Set the file path in the data array
			$data['foto_banner'] = $foto_banner_path;
		}

		// Simpan data ke dalam tabel
		$this->db->insert('tbl_banner', $data);
	}

	public function monitoring()
	{
		$ceks = $this->session->userdata('user@mt');

		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Monitoring_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Monitoring| MelatiApp";

			$data['agunan_data'] = $this->Monitoring_model->get_data_monitoring();

			// Load view untuk mengedit informasi
			$this->load->view('users/header', $data);
			$this->load->view('users/monitoring/monitoring', $data);
			$this->load->view('users/footer');
		}
	}

	public function monitoring_lihat($id)
	{
		// Check if the user is logged in
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			// Load model
			$this->load->model('Monitoring_model');

			// Get data agunan by ID
			$data['monitoring'] = $this->Monitoring_model->get_monitoring_by_id($id);

			// Check if agunan data is found
			if ($data['monitoring']) {
				$data['user'] = $this->Mcrud->get_users_by_un($ceks);
				$data['judul_web'] = "Detail Monitoring | MelatiApp";

				// Load view untuk menampilkan detail agunan
				$this->load->view('users/header', $data);
				$this->load->view('users/monitoring/monitoring_lihat', $data);
				$this->load->view('users/footer');
			} else {
				// Jika data tidak ditemukan, redirect ke halaman list agunan
				redirect('users/monitoring_by_range_tgl');
			}
		}
	}

	public function monitoring_tambah()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Tambah Data Monitoring | MelatiApp"; // Judul halaman

			$this->load->view('users/header', $data);
			$this->load->view('users/monitoring/monitoring_tambah');
			$this->load->view('users/footer');
		}
	}

	public function monitoring_simpan()
	{
		// Check if the user is logged in
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			// Load model Edit_absen_model
			$this->load->model('Monitoring_model');

			// Check if the form is submitted
			if ($this->input->post()) {
				// Ambil data dari form
				$tanggal = date('Y-m-d', strtotime($this->input->post('tanggal')));
				$tanggal_masuk = date('Y-m-d', strtotime($this->input->post('inptgljam')));
				$nama_anggota = $this->input->post('nm');
				$alamat = $this->input->post('alamat');
				$kode_kantor = $this->input->post('kdloc');
				$no_kontrak = $this->input->post('nokontrak');
				$no_registrasi = $this->input->post('noreg');
				$jenis_jaminan = $this->input->post('jnsjamin');
				$plafond = $this->input->post('digunakan');
				$jenis_dokumen = $this->input->post('jnsdokumen');
				$atas_nama = $this->input->post('an');
				$lokasi_jaminan = $this->input->post('lokasi');
				$keterangan = $this->input->post('keterangan');
				$petugas_input = $this->input->post('username');
				$id_user = $this->input->post('id_user');
				$status = $this->input->post('status');
				$jns_usaha = $this->input->post('jns_usaha');
				$jml_karyawan = $this->input->post('jml_karyawan');

				// Set up the data array
				$data = array(
					'tanggal' => $tanggal,
					'tgl_masuk' => $tanggal_masuk,
					'nama_anggota' => $nama_anggota,
					'alamat' => $alamat,
					'kode_kantor' => $kode_kantor,
					'no_kontrak' => $no_kontrak,
					'no_registrasi' => $no_registrasi,
					'jenis_jaminan' => $jenis_jaminan,
					'plafond' => $plafond,
					'jenis_dokumen' => $jenis_dokumen,
					'atas_nama' => $atas_nama,
					'lokasi_jaminan' => $lokasi_jaminan,
					'keterangan' => $keterangan,
					'petugas_input' => $petugas_input,
					'id_user' => $id_user,
					'status' => $status,
					'jns_usaha' => $jns_usaha,
					'jml_karyawan' => $jml_karyawan,
				);

				// Check if a file is selected
				if (!empty($_FILES['foto_monitoring']['name'])) {
					// Konfigurasi pengaturan unggah gambar
					$config['upload_path'] = './foto/foto_monitoring';
					$config['allowed_types'] = 'jpg|jpeg|png|gif';
					$config['max_size'] = 20048; // 2MB
					$this->load->library('upload');

					// Inisialisasi pustaka unggah dengan konfigurasi
					$this->upload->initialize($config);

					// Periksa apakah file berhasil diunggah
					if (!$this->upload->do_upload('foto_monitoring')) {
						// Tangani kesalahan unggah file
						$this->session->set_flashdata('msg', 'Error: ' . $this->upload->display_errors());
						redirect('users/monitoring');
					}

					// Dapatkan data file yang diunggah
					$upload_data = $this->upload->data();
					$foto_path = $upload_data['file_name'];

					// Tetapkan jalur file dalam array data
					$data['foto_monitoring'] = $foto_path;
				}

				// Gunakan Edit_absen_model untuk menyimpan data
				$this->Monitoring_model->monitoring_simpan($data);

				// Redirect ke halaman yang sesuai
				redirect('users/monitoring_by_range_tgl');
			} else {
				// Jika formulir tidak dikirimkan, muat tampilan
				$this->load->view('users/monitoring_by_range_tgl');
			}
		}
	}

	public function monitoring_edit($id)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {

			$this->load->model('Monitoring_model');

			$data['monitoring'] = $this->Monitoring_model->get_monitoring_by_id($id);

			if ($data['monitoring']) {
				$data['user'] = $this->Mcrud->get_users_by_un($ceks);
				$data['judul_web'] = "Edit Monitoring | MelatiApp";

				$this->load->view('users/header', $data);
				$this->load->view('users/monitoring/monitoring_edit', $data);
				$this->load->view('users/footer');
			} else {
				redirect('users/monitoring_by_range_tgl');
			}
		}
	}

	public function monitoring_update($id)
	{
		// Check if the user is logged in
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {

			// Check if the form is submitted
			if ($this->input->post()) {

				$status = $this->input->post('status');
				$jns_usaha = $this->input->post('jns_usaha');
				$tanggal_ubah = $this->input->post('tanggal_ubah');
				$petugas_ubah = $this->input->post('petugas_ubah');
				$keterangan = $this->input->post('keterangan');

				// Set up the data array
				$data = array(
					'status' => $status,
					'jns_usaha' => $jns_usaha,
					'tanggal_ubah' => $tanggal_ubah,
					'petugas_ubah' => $petugas_ubah,
					'keterangan' => $keterangan
				);

				// Check if a file is selected
				if (!empty($_FILES['foto_monitoring']['name'])) {
					// Konfigurasi pengaturan unggah gambar
					$config['upload_path'] = './foto/foto_monitoring/';
					$config['allowed_types'] = 'jpg|jpeg|png|gif';
					$config['max_size'] = 2048; // 2MB

					$this->upload->initialize($config);

					// Periksa apakah file berhasil diunggah
					if ($this->upload->do_upload('foto_monitoring')) {
						// Dapatkan data file yang diunggah
						$upload_data = $this->upload->data();
						$foto_path = $upload_data['file_name'];
						$data['foto_monitoring'] = $foto_path;
					}
				}

				$this->load->model('Monitoring_model');
				$this->Monitoring_model->monitoring_update($id, $data);
			}
		}
	}

	public function monitoring_hapus($id)
	{
		// Check if the user is logged in
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			// Load model
			$this->load->model('Monitoring_model');

			// Hapus data agunan berdasarkan ID
			$this->Monitoring_model->monitoring_hapus($id);

			// Redirect ke halaman list agunan
			redirect('users/monitoring_by_range_tgl');
		}
	}

	public function monitoring_by_range_tgl()
	{
		$ceks = $this->session->userdata('user@mt');

		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Monitoring_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Monitoring | MelatiApp";

			// Ambil tanggal_awal dan tanggal_akhir dari input pengguna
			$tanggal_awal = $this->input->get('tanggal_awal');
			if (empty($tanggal_awal)) {
				$tanggal_awal = date('Y-m-01');
			}
			$tanggal_akhir = $this->input->get('tanggal_akhir');
			if (empty($tanggal_akhir)) {
				$tanggal_akhir = date('Y-m-d'); // Default ke tanggal hari ini
			}

			// Ambil data berdasarkan tanggal_awal dan tanggal_akhir
			$data['agunan_data'] = $this->Monitoring_model->get_data_monitoring($tanggal_awal, $tanggal_akhir);

			// Load view untuk mengedit informasi
			$this->load->view('users/header', $data);
			$this->load->view('users/monitoring/monitoring_by_range_tgl', $data);
			$this->load->view('users/footer');
		}
	}

	public function informasi()
	{
		$ceks = $this->session->userdata('user@mt');

		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Monitoring_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Informasi | MelatiApp";

			// Ambil tanggal_awal dan tanggal_akhir dari input pengguna
			$tanggal_awal = $this->input->get('tanggal_awal');
			if (empty($tanggal_awal)) {
				$tanggal_awal = date('Y-01-01');
			}
			$tanggal_akhir = $this->input->get('tanggal_akhir');
			if (empty($tanggal_akhir)) {
				$tanggal_akhir = date('Y-m-d'); // Default ke tanggal hari ini
			}

			// Ambil data berdasarkan tanggal_awal dan tanggal_akhir
			$data['agunan_data'] = $this->Monitoring_model->get_data_monitoring($tanggal_awal, $tanggal_akhir);
			$data['jenis_usaha_counts'] = $this->Monitoring_model->get_jenis_usaha_counts();

			// Load view untuk mengedit informasi
			$this->load->view('users/header', $data);
			$this->load->view('users/informasi/info_usaha', $data);
			$this->load->view('users/footer');
		}
	}

	public function infografis_jml_usaha()
	{
		$ceks = $this->session->userdata('user@mt');

		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Monitoring_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Grafik Total Jumlah Usaha | MelatiApp";

			// Ambil tanggal_awal dan tanggal_akhir dari input pengguna
			$tanggal_awal = $this->input->get('tanggal_awal');
			if (empty($tanggal_awal)) {
				$tanggal_awal = date('Y-01-01');
			}
			$tanggal_akhir = $this->input->get('tanggal_akhir');
			if (empty($tanggal_akhir)) {
				$tanggal_akhir = date('Y-m-d'); // Default ke tanggal hari ini
			}

			// Ambil data berdasarkan tanggal_awal dan tanggal_akhir
			$data['agunan_data'] = $this->Monitoring_model->get_data_monitoring($tanggal_awal, $tanggal_akhir);
			$data['jenis_usaha_counts'] = $this->Monitoring_model->get_jenis_usaha_counts();

			// Load view untuk mengedit informasi
			$this->load->view('users/header', $data);
			$this->load->view('users/informasi/infografis_jml_usaha', $data);
			$this->load->view('users/footer');
		}
	}

	public function infografis_trend_usaha()
	{
		$ceks = $this->session->userdata('user@mt');

		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Monitoring_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Grafik Trend Usaha | MelatiApp";

			// Ambil tanggal_awal dan tanggal_akhir dari input pengguna
			$tanggal_awal = $this->input->get('tanggal_awal');
			if (empty($tanggal_awal)) {
				$tanggal_awal = date('Y-01-01');
			}
			$tanggal_akhir = $this->input->get('tanggal_akhir');
			if (empty($tanggal_akhir)) {
				$tanggal_akhir = date('Y-m-d');
			}

			// Ambil data berdasarkan tanggal_awal dan tanggal_akhir
			$data['agunan_data'] = $this->Monitoring_model->get_data_monitoring($tanggal_awal, $tanggal_akhir);
			$data['jenis_usaha_counts'] = $this->Monitoring_model->get_jenis_usaha_counts();

			// Load view untuk mengedit informasi
			$this->load->view('users/header', $data);
			$this->load->view('users/informasi/infografis_trend_usaha', $data);
			$this->load->view('users/footer');
		}
	}

	public function infografis_monitoring_petugas()
	{
		$ceks = $this->session->userdata('user@mt');

		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Monitoring_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Grafik Monitoring Petugas | MelatiApp";

			// Ambil tanggal_awal dan tanggal_akhir dari input pengguna
			$tanggal_awal = $this->input->get('tanggal_awal');
			if (empty($tanggal_awal)) {
				$tanggal_awal = date('Y-m-01');
			}
			$tanggal_akhir = $this->input->get('tanggal_akhir');
			if (empty($tanggal_akhir)) {
				$tanggal_akhir = date('Y-m-d'); // Default ke tanggal hari ini
			}

			// Ambil data berdasarkan tanggal_awal dan tanggal_akhir
			$data['agunan_data'] = $this->Monitoring_model->get_data_monitoring($tanggal_awal, $tanggal_akhir);
			$data['jenis_usaha_counts'] = $this->Monitoring_model->get_jenis_usaha_counts();

			// Load view untuk mengedit informasi
			$this->load->view('users/header', $data);
			$this->load->view('users/informasi/infografis_monitoring_petugas', $data);
			$this->load->view('users/footer');
		}
	}

	public function infografis_kritik_saran_petugas()
	{
		// Cek session user
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		}

		// Load model
		$this->load->model('Kritik_saran_model');
		$data['user'] = $this->Mcrud->get_users_by_un($ceks);
		$data['judul_web'] = "Grafik Kritik Saran Petugas | MelatiApp";

		// Ambil tanggal_awal dan tanggal_akhir dari input pengguna
		$tanggal_awal = $this->input->get('tanggal_awal');
		if (empty($tanggal_awal)) {
			$tanggal_awal = date('Y-m-01'); // Default ke tanggal 1 bulan ini
		}

		$tanggal_akhir = $this->input->get('tanggal_akhir');
		if (empty($tanggal_akhir)) {
			$tanggal_akhir = date('Y-m-d'); // Default ke tanggal hari ini
		}

		// Ambil data kritik_saran berdasarkan tanggal_awal dan tanggal_akhir
		$data['kritik_saran_data'] = $this->Kritik_saran_model->get_data_kritik_saran_by_date($tanggal_awal, $tanggal_akhir);

		// Siapkan data untuk chart
		$data['tanggal_awal'] = $tanggal_awal;
		$data['tanggal_akhir'] = $tanggal_akhir;

		// Load views
		$this->load->view('users/header', $data);
		$this->load->view('users/informasi/infografis_kritik_saran_petugas', $data);
		$this->load->view('users/footer');
	}

	public function infografis_survey_petugas()
	{
		// Memastikan user sudah login
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		}

		// Memuat model yang diperlukan
		$this->load->model('Usulan_model');
		$this->load->model('Mcrud');

		// Mendapatkan data user yang sedang login
		$data['user'] = $this->Mcrud->get_users_by_un($ceks);
		$data['judul_web'] = "Grafik Survey Petugas | MelatiApp";

		// Mendapatkan filter tanggal dari input pengguna
		$tanggal_awal = $this->input->get('tanggal_awal');
		if (empty($tanggal_awal)) {
			$tanggal_awal = date('Y-m-01'); // Default ke awal bulan
		}

		$tanggal_akhir = $this->input->get('tanggal_akhir');
		if (empty($tanggal_akhir)) {
			$tanggal_akhir = date('Y-m-d'); // Default ke hari ini
		}

		// Mengambil data survei berdasarkan range tanggal
		$data['survey_data'] = $this->Usulan_model->getSurveyDataByDate($tanggal_awal, $tanggal_akhir);

		// Menyimpan tanggal awal dan akhir untuk dikembalikan ke view
		$data['tanggal_awal'] = $tanggal_awal;
		$data['tanggal_akhir'] = $tanggal_akhir;

		// Memuat tampilan dengan data yang telah diambil
		$this->load->view('users/header', $data);
		$this->load->view('users/informasi/infografis_survey_petugas', $data);
		$this->load->view('users/footer');
	}

	public function infografis_analisa_petugas()
	{
		// Memastikan user sudah login
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		}

		// Memuat model yang diperlukan
		$this->load->model('Usulan_model');
		$this->load->model('Mcrud');

		// Mendapatkan data user yang sedang login
		$data['user'] = $this->Mcrud->get_users_by_un($ceks);
		$data['judul_web'] = "Grafik Analisa Petugas | MelatiApp";

		// Mendapatkan filter tanggal dari input pengguna
		$tanggal_awal = $this->input->get('tanggal_awal');
		if (empty($tanggal_awal)) {
			$tanggal_awal = date('Y-m-01'); // Default ke awal bulan
		}

		$tanggal_akhir = $this->input->get('tanggal_akhir');
		if (empty($tanggal_akhir)) {
			$tanggal_akhir = date('Y-m-d'); // Default ke hari ini
		}

		// Mengambil data survei berdasarkan range tanggal
		$data['analisa_data'] = $this->Usulan_model->getAnalisaDataByDate($tanggal_awal, $tanggal_akhir);

		// Menyimpan tanggal awal dan akhir untuk dikembalikan ke view
		$data['tanggal_awal'] = $tanggal_awal;
		$data['tanggal_akhir'] = $tanggal_akhir;

		// Memuat tampilan dengan data yang telah diambil
		$this->load->view('users/header', $data);
		$this->load->view('users/informasi/infografis_analisa_petugas', $data);
		$this->load->view('users/footer');
	}

	public function infografis_status_usulan_by_date()
	{
		$ceks = $this->session->userdata('user@mt');

		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Usulan_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Grafik data usulan | MelatiApp";

			// Ambil tanggal_awal dan tanggal_akhir dari input pengguna
			$tanggal_awal = $this->input->get('tanggal_awal');
			if (empty($tanggal_awal)) {
				$tanggal_awal = date('Y-m-01');
			}
			$tanggal_akhir = $this->input->get('tanggal_akhir');
			if (empty($tanggal_akhir)) {
				$tanggal_akhir = date('Y-m-d');
			}

			// Ambil data usulan berdasarkan tanggal
			$data['usulan_status'] = $this->Usulan_model->get_data_usulan_by_date($tanggal_awal, $tanggal_akhir);
			$data['survey_status'] = $this->Usulan_model->get_data_survey_by_date($tanggal_awal, $tanggal_akhir);

			// Kirim variabel tanggal_awal dan tanggal_akhir ke view
			$data['tanggal_awal'] = $tanggal_awal;
			$data['tanggal_akhir'] = $tanggal_akhir;

			$this->load->view('users/header', $data);
			$this->load->view('users/informasi/infografis_status_usulan_by_date', $data);
			$this->load->view('users/footer');
		}
	}

	public function kpi_info()
	{
		$ceks = $this->session->userdata('user@mt');

		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Kpi_model');
			$this->load->model('Absensi_model');
			$this->load->model('Monitoring_model');
			$this->load->helper('tanggal_helper');

			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "KPI | MelatiApp";
			$id_user = $this->session->userdata('id_user');

			// Set default values for tanggal_awal and tanggal_akhir
			$tanggal_awal = $this->input->get('tanggal_awal') ?: date('Y-m-d'); // Default to today's date
			$tanggal_akhir = $this->input->get('tanggal_akhir') ?: date('Y-m-d'); // Default to today's date

			$data['rekap'] = array();
			$users = $this->Mcrud->get_all_users_tgl_daftar();

			foreach ($users as $user) {
				$userAbsensi = $this->Absensi_model->getAbsensiByDateRange($user['id_user'], $tanggal_awal, $tanggal_akhir);
				$jamMasukPulang = $this->Absensi_model->getJamMasukPulangByDateRange($user['id_user'], $tanggal_awal, $tanggal_akhir);
				$hadirCount = $telatCount = $setengahHariCount = $izinCount = $cutiCount = $sakitCount = $tidakMasukCount = 0;
				$absensiDetail = array();

				// Menggunakan array asosiatif untuk melacak keberadaan keterangan masuk dan pulang di setiap hari
				$attendanceByDay = array();

				foreach ($userAbsensi as $attendance) {
					$attendanceByDay[$attendance['day']][] = $attendance['keterangan'];
				}

				foreach ($attendanceByDay as $day => $attendance) {
					if (in_array('Masuk', $attendance) && !in_array('Pulang', $attendance)) {
						$setengahHariCount++;
					} else {
						if (empty($attendance)) {
							$tidakMasukCount++;
						} else {
							foreach ($attendance as $keterangan) {
								if ($keterangan == 'Masuk') {
									foreach ($jamMasukPulang as $jam) {
										if ($jam['day'] == $day && $jam['keterangan'] == 'Masuk') {
											$masukJam = strtotime($jam['waktu']);
											$masukJamPulang = strtotime('08:00:59');
											if ($masukJam > $masukJamPulang) {
												$telatCount++;
											}
											$hadirCount++;
											break; // Hentikan iterasi setelah menemukan jam masuk
										}
									}
								} elseif ($keterangan == 'Izin') {
									$izinCount++;
								} elseif ($keterangan == 'Cuti') {
									$cutiCount++;
								} elseif ($keterangan == 'Sakit') {
									$sakitCount++;
								} else {
									$tidakMasukCount++;
								}
							}
						}
					}
				}

				// Buat daftar semua tanggal dalam rentang tanggal yang dipilih
				$allDates = [];
				$start_date = strtotime($tanggal_awal);
				$end_date = strtotime($tanggal_akhir);

				for ($current_date = $start_date; $current_date <= $end_date; $current_date = strtotime('+1 day', $current_date)) {
					$allDates[] = date('Y-m-d', $current_date);
				}

				// Lakukan pengecekan untuk setiap tanggal
				foreach ($allDates as $date) {
					$tgl = date('d', strtotime($date));
					$absensiDetail[$tgl] = [
						'jam_masuk' => '-',
						'jam_pulang' => '-',
						'keterangan' => '-'
					];

					foreach ($jamMasukPulang as $absensi) {
						if ($absensi['day'] == $tgl) {
							if ($absensi['keterangan'] == 'Masuk') {
								$absensiDetail[$tgl]['jam_masuk'] = $absensi['waktu'];
							} elseif ($absensi['keterangan'] == 'Pulang') {
								$absensiDetail[$tgl]['jam_pulang'] = $absensi['waktu'];
							}
							$absensiDetail[$tgl]['keterangan'] = $absensi['keterangan'];
							break; // Keluar dari loop jika data ditemukan
						}
					}

					// Jika tidak ada data absensi untuk tanggal ini, tapi ada keterangan izin atau cuti
					if ($absensiDetail[$tgl]['keterangan'] == '-') {
						foreach ($userAbsensi as $attendance) {
							if ($attendance['day'] == $tgl && ($attendance['keterangan'] == 'Izin' || $attendance['keterangan'] == 'Cuti' || $attendance['keterangan'] == 'Sakit')) {
								$absensiDetail[$tgl]['keterangan'] = $attendance['keterangan'];
								break; // Keluar dari loop jika data ditemukan
							}
						}
					}
				}

				// Hitung total hari kerja antara tanggal_awal dan tanggal_akhir
				$totalWorkingDays = $this->countWorkingDays($tanggal_awal, $tanggal_akhir);
				$tidakMasukCount = $totalWorkingDays - ($hadirCount + $setengahHariCount + $izinCount + $cutiCount + $sakitCount);
				$totalHadir = $hadirCount + $setengahHariCount;

				$data['rekap'][$user['id_user']] = array(
					'nama_lengkap' => $user['nama_lengkap'],
					'hadir' => $hadirCount,
					'setengah_hari' => $setengahHariCount,
					'telat' => $telatCount,
					'izin' => $izinCount,
					'cuti' => $cutiCount,
					'sakit' => $sakitCount,
					'tidak_masuk' => $tidakMasukCount,
					'total_hadir' => $totalHadir,
					'tanggal_awal' => $tanggal_awal,
					'tanggal_akhir' => $tanggal_akhir,
					'absensi_detail' => $absensiDetail
				);
			}

			$data['tanggal_awal'] = $tanggal_awal;
			$data['tanggal_akhir'] = $tanggal_akhir;

			$data['kpi'] = $this->Kpi_model->get_data_kpi_user($id_user);
			$data['agunan_data'] = $this->Monitoring_model->get_data_monitoring($tanggal_awal, $tanggal_akhir);
			$petugas_counts = [];
			// Iterate through the agunan_data to count the occurrences of each id_user
			foreach ($data['agunan_data'] as $record) {
				// Assuming $record contains 'id_user' and 'tgl_monitoring'
				if (!isset($petugas_counts[$record->id_user])) {
					$petugas_counts[$record->id_user] = 0;
				}
				$petugas_counts[$record->id_user]++;
			}

			// Pass the counts to the view
			$data['petugas_counts'] = $petugas_counts;

			// Load view untuk mengedit informasi
			$this->load->view('users/header', $data);
			$this->load->view('users/kpi/kpi_info', $data);
			$this->load->view('users/footer');
		}
	}

	public function kpi_data()
	{
		$ceks = $this->session->userdata('user@mt');

		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Kpi_model');

			// Get month and year from URL parameters, or default to the current month and year
			$bulan = $this->input->get('bulan') ?: date('m'); // Default to current month
			$tahun = $this->input->get('tahun') ?: date('Y'); // Default to current year

			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "KPI | MelatiApp";
			$id_user = $this->session->userdata('id_user');

			// Get data from the tbl_kpi table based on month and year
			$data['kpi'] = $this->Kpi_model->get_data_kpi_by_month_year($bulan, $tahun);

			// Passing selected month and year to view
			$data['bulan'] = $bulan;
			$data['tahun'] = $tahun;

			// Load the view for displaying KPI data
			$this->load->view('users/header', $data);
			$this->load->view('users/kpi/kpi_data', $data);
			$this->load->view('users/footer');
		}
	}

	public function kpi_lihat($id)
	{
		$ceks = $this->session->userdata('user@mt');

		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Kpi_model');
			$this->load->model('Mcrud');

			// Fetch the specific KPI record by ID
			$data['kpi'] = $this->Kpi_model->get_kpi_by_id($id);

			if (!$data['kpi']) {
				// Handle case where KPI is not found
				show_404(); // Or redirect to an error page
			}

			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Lihat KPI | MelatiApp";

			// Load the view to show KPI details
			$this->load->view('users/header', $data);
			$this->load->view('users/kpi/kpi_lihat', $data);
			$this->load->view('users/footer');
		}
	}

	public function kpi_tambah()
	{
		$ceks = $this->session->userdata('user@mt');

		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Mcrud');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Tambah KPI | MelatiApp";
			$data['users'] = $this->Mcrud->get_all_users_aktif(); // Fetch all users for the dropdown

			// Load view to add KPI
			$this->load->view('users/header', $data);
			$this->load->view('users/kpi/kpi_tambah', $data);
			$this->load->view('users/footer');
		}
	}

	public function kpi_simpan()
	{
		// Check if the user is logged in
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			// Load the Kpi_model
			$this->load->model('Kpi_model');

			// Capture data from the form
			$tgl = $this->input->post('tgl');
			$id_user = $this->input->post('id_user');
			$nilai = $this->input->post('nilai');

			// Prepare the data to be inserted into the database
			$data = array(
				'tgl' => $tgl,
				'id_user' => $id_user,
				'nilai' => $nilai
			);

			// Insert data into the Kpi_model and check if the insertion was successful
			$inserted = $this->Kpi_model->kpi_simpan($data);

			// Redirect to a relevant page after saving the data
			redirect('users/kpi_data'); // Redirect to the page where you view the KPI list
		}
	}

	public function kpi_simpan_semua()
	{
		// Cek apakah user sudah login
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			// Load Kpi_model
			$this->load->model('Kpi_model');

			// Ambil data dari form
			$tgl = $this->input->post('tgl_semua');
			$nilai = $this->input->post('nilai_semua');

			// Ambil semua user
			$users = $this->db->where('status', 'aktif')->where('id_user !=', 0)->get('tbl_user')->result();

			// Looping untuk simpan data KPI untuk setiap user
			foreach ($users as $user) {
				$data = array(
					'tgl' => $tgl,
					'id_user' => $user->id_user,
					'nilai' => $nilai
				);
				$this->Kpi_model->kpi_simpan($data);  // Simpan data KPI
			}

			// Redirect setelah berhasil menyimpan
			redirect('users/kpi_data');
		}
	}

	public function kpi_edit($id)
	{
		$ceks = $this->session->userdata('user@mt');

		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Kpi_model');
			$this->load->model('Mcrud');

			// Fetch KPI details by ID
			$data['kpi'] = $this->Kpi_model->get_kpi_by_id($id);
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Edit KPI | MelatiApp";
			$data['users'] = $this->Mcrud->get_all_users();

			if ($this->input->post()) {
				// Update KPI details
				$tgl = $this->input->post('tgl');
				$id_user = $this->input->post('id_user');
				$nilai = $this->input->post('nilai');

				$this->Kpi_model->update_kpi($id, $tgl, $id_user, $nilai);

				$this->session->set_flashdata('msg', '<div class="alert alert-success">KPI updated successfully.</div>');
				redirect('kpi');
			} else {
				// Load view to edit KPI
				$this->load->view('users/header', $data);
				$this->load->view('users/kpi/kpi_edit', $data);
				$this->load->view('users/footer');
			}
		}
	}

	public function kpi_hapus($id)
	{
		$ceks = $this->session->userdata('user@mt');

		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			// Load Kpi_model
			$this->load->model('Kpi_model');

			// Perform delete operation
			$this->Kpi_model->kpi_hapus($id);

			// Set a flash message (optional)
			$this->session->set_flashdata('msg', '<div class="alert alert-success">KPI deleted successfully.</div>');

			// Redirect to KPI list page
			redirect('users/kpi_info');
		}
	}

	public function kpi_update($id)
	{
		// Check if the user is logged in
		if (!$this->session->userdata('user@mt')) {
			redirect('web/login'); // Redirect to login page if not logged in
		}

		// Capture data from the form
		$tgl = $this->input->post('tgl');
		$id_user = $this->input->post('id_user');
		$nilai = $this->input->post('nilai');

		// Prepare data to be updated
		$data = array(
			'tgl' => $tgl,
			'id_user' => $id_user,
			'nilai' => $nilai
		);

		// Update data in the database based on ID
		$this->load->model('Kpi_model');
		$this->Kpi_model->kpi_update($id, $data);

		// Set a flash message for success and redirect to another page
		$this->session->set_flashdata('msg', '<div class="alert alert-success"><strong>Sukses!</strong> KPI berhasil diupdate!</div>');
		redirect('users/kpi_info'); // Redirect to the KPI information page
	}

	// public function kritik_saran_data()
	// {
	// 	$ceks = $this->session->userdata('user@mt');

	// 	if (!isset($ceks)) {
	// 		redirect('web/login');
	// 	} else {
	// 		$data['user'] = $this->Mcrud->get_users_by_un($ceks);
	// 		$data['judul_web'] = "Data Kritik & Saran | MelatiApp";

	// 		// Load view untuk mengedit informasi
	// 		$this->load->view('users/header', $data);
	// 		$this->load->view('users/kritik_saran/kritik_saran_data');
	// 		$this->load->view('users/footer');
	// 	}
	// }

	// Start kritik saran
	public function kritik_saran_tambah()
	{
		// Mengambil data pengguna jika ada, namun tidak melakukan pengecekan login
		$ceks = $this->session->userdata('user@mt');

		// Jika pengguna login, ambil data pengguna
		if (isset($ceks)) {
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
		} else {
			// Jika tidak login, tetap bisa mengakses halaman ini
			$data['user'] = 0; // Atau Anda bisa mengisi dengan data default atau kosong
		}

		// Load view untuk form kritik saran
		$this->load->view('users/kritik_saran/kritik_saran_tambah', $data);
	}


	// End kritik saran

	// Kritik saran lihat
	public function kritik_saran_lihat($id)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Kritik_saran_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Lihat Kritik dan Saran | MelatiApp";

			// Get kritik saran data from model based on $id
			$data['kritik_saran'] = $this->Kritik_saran_model->get_kritik_saran_by_id($id);

			if (empty($data['kritik_saran'])) {
				show_404();
			}

			$this->load->view('users/header', $data);
			$this->load->view('users/kritik_saran/kritik_saran_lihat', $data);
			$this->load->view('users/footer');
		}
	}
	// /kritik saran lihat

	// Kritik saran edit
	public function kritik_saran_edit($id)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Kritik_saran_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Edit Kritik dan Saran | MelatiApp";

			// Get kritik saran data from model based on $id
			$data['kritik_saran'] = $this->Kritik_saran_model->get_kritik_saran_by_id($id);

			if (empty($data['kritik_saran'])) {
				show_404();
			}

			$this->load->view('users/header', $data);
			$this->load->view('users/kritik_saran/kritik_saran_edit', $data);
			$this->load->view('users/footer');
		}
	}

	public function kritik_saran_edit_user($id)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Kritik_saran_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Edit Kritik dan Saran | MelatiApp";

			// Get kritik saran data from model based on $id
			$data['kritik_saran'] = $this->Kritik_saran_model->get_kritik_saran_by_id($id);

			if (empty($data['kritik_saran'])) {
				show_404();
			}

			$this->load->view('users/header', $data);
			$this->load->view('users/kritik_saran/kritik_saran_edit_user', $data);
			$this->load->view('users/footer');
		}
	}

	// Start data kritik saran
	public function kritik_saran_data()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Kritik_saran_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);

			$data['judul_web'] = "Data Kritik dan Saran | MelatiApp";
			$id_user = $this->session->userdata('id_user');

			// Get kritik saran based on selected month and year
			$data['kritik_saran'] = $this->Kritik_saran_model->get_all_kritik_saran_belum_direspond();


			$this->load->view('users/header', $data);
			$this->load->view('users/kritik_saran/kritik_saran_data', $data);
			$this->load->view('users/footer');
		}
	}
	// End data kritik saran

	public function kritik_saran_data_direspond()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Kritik_saran_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);

			$data['judul_web'] = "Data Kritik dan Saran | MelatiApp";
			$id_user = $this->session->userdata('id_user');

			// Get kritik saran based on selected month and year
			$data['kritik_saran'] = $this->Kritik_saran_model->get_all_kritik_saran_sudah_direspond();


			$this->load->view('users/header', $data);
			$this->load->view('users/kritik_saran/kritik_saran_data_direspond', $data);
			$this->load->view('users/footer');
		}
	}

	public function kritik_saran_data_user()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Kritik_saran_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);

			$data['judul_web'] = "Data Kritik dan Saran | MelatiApp";
			$id_user = $this->session->userdata('id_user');

			// Get kritik saran based on selected month and year
			$data['kritik_saran'] = $this->Kritik_saran_model->get_all_kritik_saran_user($id_user);


			$this->load->view('users/header', $data);
			$this->load->view('users/kritik_saran/kritik_saran_data_user', $data);
			$this->load->view('users/footer');
		}
	}

	// Start submit kritik saran
	public function kritik_saran_submit()
	{
		$tanggal = $this->input->post('tanggal');
		$nama = $this->input->post('nama');
		$alamat = $this->input->post('alamat');
		$no_telepon = $this->input->post('no_telepon');
		$kritik_saran = $this->input->post('kritik_saran');
		$id_user = $this->input->post('id_user');

		$data = array(
			'tanggal' => $tanggal,
			'nama' => $nama,
			'alamat' => $alamat,
			'no_telepon' => $no_telepon,
			'kritik_saran' => $kritik_saran,
			'id_user' => $id_user
		);

		$this->load->model('Kritik_saran_model');
		$this->Kritik_saran_model->tambah_kritik_saran($data);

		redirect('users/success_page');
	}

	// End submit kritik saran

	// Start update kritik saran
	public function kritik_saran_update($id)
	{
		if (!$this->session->userdata('username')) {
			redirect('web/login');
		}

		$tanggal = $this->input->post('tanggal');
		$nama = $this->input->post('nama');
		$alamat = $this->input->post('alamat');
		$no_telepon = $this->input->post('no_telepon');
		$kritik_saran = $this->input->post('kritik_saran');
		$status = $this->input->post('status');

		$data = array(
			'tanggal' => $tanggal,
			'nama' => $nama,
			'alamat' => $alamat,
			'no_telepon' => $no_telepon,
			'kritik_saran' => $kritik_saran,
			'status' => $status
		);

		$this->load->model('Kritik_saran_model');
		$this->Kritik_saran_model->kritik_saran_update($id, $data);

		$this->session->set_flashdata('msg', '<div class="alert alert-success"><strong>Sukses!</strong> Kritik dan Saran berhasil diupdate!</div>');
		redirect('users/kritik_saran_data');
	}
	// End update kritik saran

	// Start hapus kritik saran
	public function kritik_saran_hapus($id)
	{
		if (!$this->session->userdata('username')) {
			redirect('web/login');
		}

		$this->load->model('Kritik_saran_model');
		$this->Kritik_saran_model->kritik_saran_hapus($id);

		$this->session->set_flashdata('msg', '<div class="alert alert-success"><strong>Sukses!</strong> Kritik dan Saran berhasil dihapus!</div>');
		redirect('users/kritik_saran_data');
	}
	// End hapus kritik saran

	public function success_page()
	{
		// Proses data formulir di sini

		// Muat halaman sukses
		$this->load->view('users/success_page');
	}

	public function status_monitoring()
	{
		$ceks = $this->session->userdata('user@mt');

		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Status_monitoring_model');
			$this->load->model('Agunan_model');
			$this->load->model('Usulan_model');
			$this->load->model('Menu_access_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Status Monitoring | MelatiApp";

			$data['proses_count'] = $this->Status_monitoring_model->count_proses_blokir();
			$data['done_count'] = $this->Status_monitoring_model->count_done_blokir();
			$data['empty_tindakan_count'] = $this->Status_monitoring_model->count_empty_tindakan();
			$data['filled_tindakan_count'] = $this->Status_monitoring_model->count_filled_tindakan();
			$data['belum_otorisasi_count'] = $this->Status_monitoring_model->count_belum_otorisasi();
			$data['sudah_otorisasi_count'] = $this->Status_monitoring_model->count_sudah_otorisasi();
			$data['kritik_saran_belum_direspond_count'] = $this->Status_monitoring_model->count_kritik_saran_belum_direspond();
			$data['kritik_saran_sudah_direspond_count'] = $this->Status_monitoring_model->count_kritik_saran_sudah_direspond();
			$data['agunan_count'] = $this->Status_monitoring_model->count_agunan();
			$data['agunan_shm_count'] = $this->Status_monitoring_model->count_agunan_shm();
			$data['agunan_dipesan_count'] = $this->Status_monitoring_model->count_agunan_dipesan();
			$data['agunan_shm_dipesan_count'] = $this->Status_monitoring_model->count_agunan_shm_dipesan();
			$data['monitoring_count'] = $this->Status_monitoring_model->count_monitoring();
			//$data['absensi_count'] = $this->Status_monitoring_model->count_absensi();
			$data['tofjamin_count'] = $this->Status_monitoring_model->count_tofjamin();
			$data['tabungan_count'] = $this->Status_monitoring_model->count_tabungan();

			$data['agunan_data'] = $this->Agunan_model->get_data_agunan_bergerak();
			$data['absensi_tidak_sesuai'] = $this->Status_monitoring_model->get_absensi_tidak_sesuai();
			$data['usulan_data'] = $this->Status_monitoring_model->get_usulan_with_duplicate_nik();

			$data['menu_access'] = $this->Menu_access_model->get_all_menu_access();

			// Load view untuk mengedit informasi
			$this->load->view('users/header', $data);
			$this->load->view('users/status_monitoring/status_monitoring', $data);
			$this->load->view('users/footer');
		}
	}

	public function tracking_agunan()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Agunan_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Tracking Agunan | MelatiApp";

			$data['agunan_tracking'] = $this->Agunan_model->get_data_agunan_bergerak();

			$this->load->view('users/header', $data);
			$this->load->view('users/tracking/agunan');
			$this->load->view('users/footer');
		}
	}

	// Function to display ucapan data
	public function ucapan_data()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			// Fetch user and ucapan data
			$this->load->model('Ucapan_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Ucapan Data | MelatiApp";
			$data['ucapan_list'] = $this->Ucapan_model->get_all_ucapan();

			// Load views
			$this->load->view('users/header', $data);
			$this->load->view('users/ucapan/ucapan_data', $data);
			$this->load->view('users/footer');
		}
	}

	public function ucapan_tambah()
	{
		$ceks = $this->session->userdata('user@mt');

		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Tambah Ucapan | MelatiApp";

			$this->load->view('users/header', $data);
			$this->load->view('users/ucapan/ucapan_tambah', $data);
			$this->load->view('users/footer');
		}
	}

	public function ucapan_submit()
	{
		$tanggal = $this->input->post('tgl_kirim');
		$kategori = $this->input->post('kategori');
		$isi_ucapan = $this->input->post('isi_ucapan');
		$hari = $this->input->post('hari');
		$status = $this->input->post('status');

		$data = array(
			'tanggal' => $this->input->post('tgl_kirim'),
			'kategori' => $this->input->post('kategori'),
			'isi_ucapan' => $this->input->post('isi_ucapan'),
			'hari' => $this->input->post('hari'),
			'status' => 'aktif',
		);

		$this->load->model('Ucapan_model');
		$this->Ucapan_model->add_ucapan($data);

		redirect('users/ucapan_data');
	}

	public function ucapan_edit($id)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Ucapan_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Edit Ucapan | MelatiApp";
			$data['ucapan'] = $this->Ucapan_model->get_ucapan_by_id($id);

			$this->load->view('users/header', $data);
			$this->load->view('users/ucapan/ucapan_edit', $data);
			$this->load->view('users/footer');
		}
	}

	public function ucapan_update($id)
	{
		if (!$this->session->userdata('username')) {
			redirect('web/login');
		}

		$tanggal = $this->input->post('tgl_kirim');
		$kategori = $this->input->post('kategori');
		$isi_ucapan = $this->input->post('isi_ucapan');
		$hari = $this->input->post('hari');
		$status = $this->input->post('status');

		$data = array(
			'tanggal' => $this->input->post('tgl_kirim'),
			'kategori' => $this->input->post('kategori'),
			'isi_ucapan' => $this->input->post('isi_ucapan'),
			'hari' => $this->input->post('hari'),
			'status' => $this->input->post('status'),
		);

		$this->load->model('Ucapan_model');
		$this->Ucapan_model->update_ucapan($id, $data);

		redirect('users/ucapan_data');
	}

	// Function to delete an ucapan
	public function ucapan_hapus($id)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Ucapan_model');
			$this->Ucapan_model->delete_ucapan($id);
			redirect('users/ucapan_data');
		}
	}

	public function ucapan_lihat($id_ucapan)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Ucapan_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Lihat Ucapan | MelatiApp";
			$data['ucapan'] = $this->Ucapan_model->get_ucapan_by_id($id_ucapan);

			$this->load->view('users/header', $data);
			$this->load->view('users/ucapan/ucapan_lihat', $data);
			$this->load->view('users/footer');
		}
	}

	public function file_center_upload()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('File_center_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "File Center Upload | MelatiApp";
			$data['categories'] = $this->File_center_model->get_all_categories();

			$this->load->view('users/header', $data);
			$this->load->view('users/file_center/file_center_upload', $data);
			$this->load->view('users/footer');
		}
	}

	public function file_center_lihat($id)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('File_center_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "File Center Lihat | MelatiApp";

			$data['file_center'] = $this->File_center_model->get_file_by_id($id);

			if (empty($data['file_center'])) {
				show_404();
			}

			$this->load->view('users/header', $data);
			$this->load->view('users/file_center/file_center_lihat', $data);
			$this->load->view('users/footer');
		}
	}

	public function file_center_edit($id)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('File_center_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "File Center Edit | MelatiApp";

			$data['file_center'] = $this->File_center_model->get_file_by_id($id);

			if (empty($data['file_center'])) {
				show_404();
			}

			$this->load->view('users/header', $data);
			$this->load->view('users/file_center/file_center_edit', $data);
			$this->load->view('users/footer');
		}
	}

	public function file_center_submit()
	{
		if (!$this->session->userdata('username')) {
			redirect('web/login');
		}

		// Load the model
		$this->load->model('File_center_model');

		// Ambil data dari form
		$download_status = $this->input->post('download_status');
		$description = $this->input->post('description');
		$category = $this->input->post('category');
		$folder = $this->input->post('folder');
		$tahun = $this->input->post('tahun');
		$uploaded_by = $this->session->userdata('nama_lengkap');
		$uploaded_at = date('Y-m-d H:i:s');

		// Persiapkan data untuk disimpan
		$data = array(
			'uploaded_by' => $uploaded_by,
			'download_status' => $download_status,
			'description' => $description,
			'category' => $category,
			'folder' => $folder,
			'tahun' => $tahun,
			'uploaded_at' => $uploaded_at,
		);

		if (!empty($_FILES['file_upload']['name'])) {
			// Konfigurasi upload
			$config['upload_path'] = './files/';
			$config['allowed_types'] = '*'; // Izinkan semua tipe file
			$config['max_size'] = 20480; // Maksimal ukuran file 20MB
			$this->load->library('upload');

			$this->upload->initialize($config);

			// Cek apakah file berhasil diupload
			if (!$this->upload->do_upload('file_upload')) {
			}

			// Ambil data upload
			$upload_data = $this->upload->data();
			$data['file_name'] = $upload_data['file_name'];
			$data['file_path'] = $upload_data['full_path'];
			$data['file_size'] = $upload_data['file_size'];
			$data['file_type'] = $upload_data['file_type'];
		}

		// Insert data ke tabel
		if ($this->File_center_model->insert_file($data)) {
			$this->session->set_flashdata('msg', '<div class="alert alert-success">File berhasil diupload!</div>');
		} else {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger">Gagal mengupload file.</div>');
		}

		redirect('users/file_center_categories');
	}

	public function file_center_update($id)
	{
		if (!$this->session->userdata('username')) {
			redirect('web/login');
		}

		$uploaded_at = $this->input->post('uploaded_at');
		$category = $this->input->post('category');
		$tahun = $this->input->post('tahun');
		$download_status = $this->input->post('download_status');
		$description = $this->input->post('description');

		$data = array(
			'uploaded_at' => $uploaded_at,
			'category' => $category,
			'tahun' => $tahun,
			'download_status' => $download_status,
			'description' => $description
		);

		if (!empty($_FILES['file_upload']['name'])) {
			$config['upload_path'] = './uploads/files/';
			$config['allowed_types'] = 'pdf|doc|docx|xls|xlsx|ppt|pptx|zip|rar';
			$config['max_size'] = 20048;
			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('file_upload')) {
				// Handle file upload error
			}

			$upload_data = $this->upload->data();
			$file_path = $upload_data['file_name'];

			$data['file_path'] = $file_path;
		}

		$this->db->where('id', $id);
		$this->db->update('tbl_file', $data);
		$this->session->set_flashdata('msg', '<div class="alert alert-success">File successfully updated!</div>');
		redirect('users/file_center_by_category/' . rawurlencode($category));
	}

	public function file_center_hapus($id)
	{
		if (!$this->session->userdata('username')) {
			redirect('web/login');
		}
		$this->load->model('File_center_model');
		$file = $this->File_center_model->get_file_by_id($id);

		if (isset($file['file_path']) && file_exists('./files/' . $file['file_path'])) {
			unlink('./files/' . $file['file_path']);
		}

		$this->db->where('id', $id);
		$this->db->delete('tbl_file');
		$this->session->set_flashdata('msg', '<div class="alert alert-success">File berhasil terhapus!</div>');
		redirect('users/file_center_categories');
	}

	public function file_center_download($id)
	{
		// Load the file model
		$this->load->model('File_center_model');

		// Get file details from the model
		$file = $this->File_center_model->get_file_by_id($id);

		if ($file) {
			$file_path = './files/' . $file['file_path'];

			if ($file && file_exists($file['file_path'])) {
				// Force download
				$this->load->helper('download');
				force_download($file['file_path'], NULL);
			} else {
				// File not found, redirect with error message
				$this->session->set_flashdata('msg', '<div class="alert alert-danger">File tidak ditemukan atau sudah dihapus.</div>');
				redirect('users/file_center_categories');
			}
		} else {
			// File record not found
			$this->session->set_flashdata('msg', 'File record not found.');
			redirect('users/file_center_data');
		}
	}

	public function file_center_categories()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('File_center_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "File Center Categories | MelatiApp";

			// Ambil kategori (distinct)
			$files = $this->File_center_model->get_all_files();
			$categories = array_unique(array_column($files, 'category'));

			$data['categories'] = $categories;
			$data['file_center'] = $this->File_center_model->get_all_files();

			$this->load->view('users/header', $data);
			$this->load->view('users/file_center/file_center_categories', $data);
			$this->load->view('users/footer');
		}
	}

	public function file_center_by_category($category)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('File_center_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "File Center by Category | MelatiApp";

			// Decode kategori dari URL
			$category = urldecode($category);

			// Ambil file berdasarkan kategori
			$files = $this->File_center_model->get_files_by_category($category);

			$data['category'] = $category;
			$data['files'] = $files;

			$this->load->view('users/header', $data);
			$this->load->view('users/file_center/file_center_by_category', $data);
			$this->load->view('users/footer');
		}
	}

	public function menu_setting_tambah()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Menu_setting_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Menu setting tambah | MelatiApp";

			$this->load->view('users/header', $data);
			$this->load->view('users/menu_setting/menu_setting_tambah', $data);
			$this->load->view('users/footer');
		}
	}
	public function menu_setting_data()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Menu_setting_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Menu setting data | MelatiApp";

			$data['menu_setting'] = $this->Menu_setting_model->get_all_menu();

			$this->load->view('users/header', $data);
			$this->load->view('users/menu_setting/menu_setting_data', $data);
			$this->load->view('users/footer');
		}
	}

	public function menu_setting_lihat($id_menu)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Menu_setting_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Menu setting lihat | MelatiApp";

			$data['menu_setting'] = $this->Menu_setting_model->get_menu_by_id($id_menu);

			$this->load->view('users/header', $data);
			$this->load->view('users/menu_setting/menu_setting_lihat', $data);
			$this->load->view('users/footer');
		}
	}

	public function menu_setting_edit($id_menu)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Menu_setting_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Menu setting edit | MelatiApp";

			$data['menu_setting'] = $this->Menu_setting_model->get_menu_by_id($id_menu);

			$this->load->view('users/header', $data);
			$this->load->view('users/menu_setting/menu_setting_edit', $data);
			$this->load->view('users/footer');
		}
	}

	public function menu_setting_simpan()
	{

		if (!$this->session->userdata('username')) {
			redirect('web/login');
		}

		$menu_name = $this->input->post('menu_name');
		$icon = $this->input->post('icon');
		$url = $this->input->post('url');
		$category = $this->input->post('category');
		$fungsi = $this->input->post('fungsi');
		$access_level = $this->input->post('access_level');

		// Siapkan data untuk disimpan ke dalam tabel
		$data = array(
			'menu_name' => $this->input->post('menu_name'),
			'icon' => $this->input->post('icon'),
			'url' => $this->input->post('url'),
			'category' => $this->input->post('category'),
			'fungsi' => $this->input->post('fungsi'),
			'access_level' => $this->input->post('access_level')
		);

		$this->db->insert('tbl_user_main_menu', $data);

		$this->session->set_flashdata('msg', '<div class="alert alert-success"><strong>Sukses!</strong> Menu setting berhasil ditambah!</div>');
		redirect('users/menu_setting_data');
	}

	public function menu_setting_update($id_menu)
	{
		if (!$this->session->userdata('username')) {
			redirect('web/login');
		}

		$menu_name = $this->input->post('menu_name');
		$icon = $this->input->post('icon');
		$url = $this->input->post('url');
		$category = $this->input->post('category');
		$fungsi = $this->input->post('fungsi');
		$access_level = $this->input->post('access_level');

		$data = array(
			'menu_name' => $this->input->post('menu_name'),
			'icon' => $this->input->post('icon'),
			'url' => $this->input->post('url'),
			'category' => $this->input->post('category'),
			'fungsi' => $this->input->post('fungsi'),
			'access_level' => $this->input->post('access_level')
		);

		$this->db->where('id_menu', $id_menu);
		$this->db->update('tbl_user_main_menu', $data);

		$this->session->set_flashdata('msg', '<div class="alert alert-success"><strong>Sukses!</strong> Menu setting berhasil diupdate!</div>');
		redirect('users/menu_setting_data');
	}

	public function menu_setting_hapus($id_menu)
	{
		if (!$this->session->userdata('username')) {
			redirect('web/login');
		}

		$this->db->where('id_menu', $id_menu);
		$this->db->delete('tbl_user_main_menu');

		$this->session->set_flashdata('msg', '<div class="alert alert-success"><strong>Sukses!</strong> Menu setting berhasil dihapus!</div>');
		redirect('users/menu_setting_data');
	}
	// 
	public function menu_access_tambah()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Menu_access_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Menu access tambah | MelatiApp";

			$this->load->view('users/header', $data);
			$this->load->view('users/menu_access/menu_access_tambah', $data);
			$this->load->view('users/footer');
		}
	}
	public function menu_access_data()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Menu_access_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Menu access data | MelatiApp";

			$id_user = $this->input->get('id_user');

			// Ambil data akses menu berdasarkan id_user jika ada
			if ($id_user !== null) {
				$data['menu_access'] = $this->Menu_access_model->get_menu_access_by_user($id_user);
			} else {
				$data['menu_access'] = $this->Menu_access_model->get_all_menu_access();
			}

			$this->load->view('users/header', $data);
			$this->load->view('users/menu_access/menu_access_data', $data);
			$this->load->view('users/footer');
		}
	}

	public function menu_access_lihat($id_access)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Menu_access_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Menu access lihat | MelatiApp";

			$data['menu_access'] = $this->Menu_access_model->get_menu_access_by_id($id_access);

			$this->load->view('users/header', $data);
			$this->load->view('users/menu_access/menu_access_lihat', $data);
			$this->load->view('users/footer');
		}
	}

	public function menu_access_edit($id_access)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Menu_access_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Menu access edit | MelatiApp";

			$data['menu_access'] = $this->Menu_access_model->get_menu_access_by_id($id_access);

			$this->load->view('users/header', $data);
			$this->load->view('users/menu_access/menu_access_edit', $data);
			$this->load->view('users/footer');
		}
	}

	public function menu_access_simpan()
	{

		if (!$this->session->userdata('username')) {
			redirect('web/login');
		}

		$id_user = $this->input->post('id_user');
		$id_menu = $this->input->post('id_menu');
		$has_access = $this->input->post('has_access');

		// Siapkan data untuk disimpan ke dalam tabel
		$data = array(
			'id_user' => $id_user,
			'id_menu' => $id_menu,
			'has_access' => $has_access
		);

		$this->db->insert('tbl_user_main_menu_access', $data);

		$this->session->set_flashdata('msg', '<div class="alert alert-success"><strong>Sukses!</strong> Menu access berhasil ditambah!</div>');
		redirect('users/menu_access_data');
	}

	public function menu_access_update($id_access)
	{
		if (!$this->session->userdata('username')) {
			redirect('web/login');
		}

		$id_user = $this->input->post('id_user');
		$id_menu = $this->input->post('id_menu');
		$has_access = $this->input->post('has_access');

		$data = array(
			'id_user' => $id_user,
			'id_menu' => $id_menu,
			'has_access' => $has_access
		);

		$this->db->where('id_access', $id_access);
		$this->db->update('tbl_user_main_menu_access', $data);

		$this->session->set_flashdata('msg', '<div class="alert alert-success"><strong>Sukses!</strong> Menu access berhasil diupdate!</div>');
		redirect('users/menu_access_data');
	}

	public function menu_access_hapus($id_access)
	{
		if (!$this->session->userdata('username')) {
			redirect('web/login');
		}

		$this->db->where('id_access', $id_access);
		$this->db->delete('tbl_user_main_menu_access');

		$this->session->set_flashdata('msg', '<div class="alert alert-success"><strong>Sukses!</strong> Menu access berhasil dihapus!</div>');
		redirect('users/menu_access_data');
	}

	public function setting_data()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Setting_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Data Pengaturan | MelatiApp";

			$data['settings'] = $this->Setting_model->get_all_settings();

			$this->load->view('users/header', $data);
			$this->load->view('users/setting/setting_data', $data);
			$this->load->view('users/footer');
		}
	}

	public function setting_tambah()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Setting_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Tambah Pengaturan | MelatiApp";

			// Load the form view
			$this->load->view('users/header', $data);
			$this->load->view('users/setting/setting_tambah', $data);
			$this->load->view('users/footer');
		}
	}

	public function setting_simpan()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Setting_model');

			// Get the form inputs
			$key = $this->input->post('key');
			$value = $this->input->post('value');
			$catatan = $this->input->post('catatan');

			// Call the model's insert_setting function
			$result = $this->Setting_model->insert_setting($key, $value, $catatan);

			// Check if the insertion was successful
			if ($result) {
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Setting berhasil ditambahkan!</div>');
				redirect('users/setting/setting_data');
			} else {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger">Key sudah ada, silakan coba lagi.</div>');
				redirect('users/setting/setting_data');
			}
		}
	}

	public function setting_edit($key)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Setting_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Edit Pengaturan | MelatiApp";
			$data['setting'] = $this->Setting_model->get_setting($key);

			$this->load->view('users/header', $data);
			$this->load->view('users/setting/setting_edit', $data);
			$this->load->view('users/footer');
		}
	}

	public function setting_update($key)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Setting_model');

			// Ambil nilai dari form
			$value = $this->input->post('value');
			$catatan = $this->input->post('catatan'); // Ambil keterangan dari form

			// Buat array untuk data yang akan di-update
			$data = array(
				'value' => $value,
				'catatan' => $catatan
			);

			// Panggil model untuk update
			$this->Setting_model->update_setting($key, $data);

			// Redirect ke halaman pengaturan
			redirect('users/setting/setting_data');
		}
	}

	public function setting_delete($key)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Setting_model');
			$this->Setting_model->delete_setting($key); // Panggil model untuk hapus pengaturan
			redirect('users/setting/setting_data'); // Redirect ke halaman pengaturan
		}
	}

	public function trend_usaha()
	{
		$ceks = $this->session->userdata('user@mt');
		$id_user = $this->session->userdata('id_user@mt');

		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Menu_model');
			$this->load->model('Monitoring_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['users'] = $this->Mcrud->get_users();
			$data['judul_web'] = "Trend Usaha | MelatiApp ";

			// Ambil tanggal_awal dan tanggal_akhir dari input pengguna
			$tanggal_awal = $this->input->get('tanggal_awal');
			if (empty($tanggal_awal)) {
				$tanggal_awal = date('Y-m-d', strtotime('-5 years')); // Default ke 5 tahun lalu dari hari ini
			}
			$tanggal_akhir = $this->input->get('tanggal_akhir');
			if (empty($tanggal_akhir)) {
				$tanggal_akhir = date('Y-m-d'); // Default ke tanggal hari ini
			}

			// Ambil data berdasarkan tanggal_awal dan tanggal_akhir
			$data['agunan_data'] = $this->Monitoring_model->get_data_monitoring($tanggal_awal, $tanggal_akhir);
			$data['jenis_usaha_counts'] = $this->Monitoring_model->get_jenis_usaha_counts();

			$this->load->view('users/header', $data);
			$this->load->view('users/data_visual/trend_usaha', $data);
			$this->load->view('users/footer');
		}
	}

	public function saldo_data()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('User_model');
			$this->load->model('Mcrud');
			$id_user = $this->session->userdata('id_user');

			// Get user details
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Saldo | MelatiApp";

			// Fetch saldo by nocif and id_user
			$data['tabungan'] = $this->User_model->getTabunganByNocif($id_user);

			// Set tanggal hari ini
			$data['tanggal_sekarang'] = date('Y-m-d'); // Tanggal hari ini

			$this->load->view('users/header', $data);
			$this->load->view('users/saldo/saldo_data', $data);
			$this->load->view('users/footer');
		}
	}

	public function saldo_data_riwayat($notab)
	{
		$ceks = $this->session->userdata('user@mt');

		if (!isset($ceks)) {
			redirect('web/login');  // Redirect to login if session not active
		} else {
			// Load necessary models
			$this->load->model('User_model');

			// Fetch the user data
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);

			// Set the title for the page
			$data['judul_web'] = "Riwayat Transaksi | MelatiApp";

			// Default date range (awal bulan berjalan dan hari ini)
			$start_date = $this->input->post('start_date', TRUE);
			$end_date = $this->input->post('end_date', TRUE);

			if (empty($start_date) || empty($end_date)) {
				// Set default to the start of the current month and today's date
				$start_date = date('Ymd', strtotime('first day of this month'));
				$end_date = date('Ymd');
			}

			// Get the transaction history based on the No Tabungan and date range
			$data['history'] = $this->User_model->get_transaction_history($notab, $start_date, $end_date);

			// Pass No Tabungan and date range to the view
			$data['notab'] = $notab;
			$data['start_date'] = $start_date;
			$data['end_date'] = $end_date;

			// Load the view components
			$this->load->view('users/header', $data);
			$this->load->view('users/saldo/saldo_data_riwayat', $data);
			$this->load->view('users/footer');
		}
	}


	public function saldo_semua_user()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('User_model');
			$this->load->model('Mcrud');

			// Get user details
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Saldo | MelatiApp";

			// Fetch saldo by nocif and id_user
			$data['tabungan'] = $this->User_model->getTabunganAllUser();

			// Set tanggal hari ini
			$data['tanggal_sekarang'] = date('Y-m-d'); // Tanggal hari ini

			$this->load->view('users/header', $data);
			$this->load->view('users/saldo/saldo_semua_user', $data);
			$this->load->view('users/footer');
		}
	}

	public function pembiayaan_data()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('User_model');
			$this->load->model('Mcrud');
			$id_user = $this->session->userdata('id_user');

			// Get user details
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Pembiayaan | MelatiApp";

			// Fetch pembiayaan by nocif and id_user
			$data['pembiayaan'] = $this->User_model->getPembiayaanByNocif($id_user);

			// Set tanggal hari ini
			$data['tanggal_sekarang'] = date('Y-m-d'); // Tanggal hari ini

			$this->load->view('users/header', $data);
			$this->load->view('users/pembiayaan/pembiayaan_data', $data);
			$this->load->view('users/footer');
		}
	}

	public function komite_lihat($id)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Usulan_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Detail Analisa | MelatiApp";
			$data['survey_detail'] = $this->Usulan_model->getSurveyDetail($id);

			$this->load->view('users/header', $data);
			$this->load->view('users/komite/komite_lihat', $data);
			$this->load->view('users/footer');
		}
	}

	public function komite_data()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Usulan_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Komite Data | MelatiApp";

			// Ambil input tanggal dari form
			$start_date = $this->input->get('start_date');
			$end_date = $this->input->get('end_date');

			// Jika tanggal tidak diset, gunakan fungsi tanpa filter
			if ($start_date && $end_date) {
				$data['survey_data'] = $this->Usulan_model->getKomiteDataByDate($start_date, $end_date);
			} else {
				$data['survey_data'] = $this->Usulan_model->getKomiteData();  // Semua data
			}

			$this->load->view('users/header', $data);
			$this->load->view('users/komite/komite_data', $data);
			$this->load->view('users/footer');
		}
	}

	public function komite_data_export_excel()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Usulan_model');

			$start_date = $this->input->get('start_date');
			$end_date = $this->input->get('end_date');

			// Cek apakah tanggal mulai dan akhir ada
			if (empty($start_date) || empty($end_date)) {
				$data_komite = $this->Usulan_model->getKomiteData(); // Jika tidak ada filter tanggal, ambil semua data
			} else {
				$data_komite = $this->Usulan_model->getKomiteDataByDate($start_date, $end_date); // Filter berdasarkan tanggal
			}

			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();

			// Menambahkan header Excel sesuai dengan tabel yang diinginkan
			$sheet->setCellValue('A1', 'ID/CekBI')
				->setCellValue('B1', 'Nama')
				->setCellValue('C1', 'Alamat')
				->setCellValue('D1', 'Plafon Usulan')
				->setCellValue('E1', 'Inpuser')
				->setCellValue('F1', 'Surveyor')
				->setCellValue('G1', 'Analyst')
				->setCellValue('H1', 'Hasil Analisa');

			// Menambahkan gaya pada header
			$headerStyleArray = [
				'font' => [
					'bold' => true,
					'color' => ['argb' => 'FFFFFF'],
					'size' => 12
				],
				'alignment' => [
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
					'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
				],
				'fill' => [
					'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
					'startColor' => ['argb' => '4CAF50']
				]
			];
			$sheet->getStyle('A1:H1')->applyFromArray($headerStyleArray);

			// Memasukkan data ke dalam Excel
			$row = 2; // Dimulai dari baris ke-2 (baris pertama untuk header)
			foreach ($data_komite as $data) {
				$cekbi = (!empty($data->tgl_cek_bi)) ? date('Ymd', strtotime($data->tgl_cek_bi)) . '_PBY' . $data->id_pby : 'PBY' . $data->id_pby;
				$sheet->setCellValue('A' . $row, $cekbi)
					->setCellValue('B' . $row, $data->nama)
					->setCellValue('C' . $row, $data->alamat . ' ' . $data->kelurahan_nama . ' ' . $data->kecamatan_nama . ' ' . $data->kota_nama)
					->setCellValue('D' . $row, 'Rp ' . number_format($data->nominal, 0, ',', '.'))
					->setCellValue('E' . $row, $this->Usulan_model->getUsernameById($data->id_user))
					->setCellValue('F' . $row, $this->Usulan_model->getUsernameById($data->surveyor))
					->setCellValue('G' . $row, $this->Usulan_model->getUsernameById($data->analyst))
					->setCellValue('H' . $row, $this->formatHasilAnalisa($data->hasil_analisa));

				// Menambahkan border di setiap sel data
				$sheet->getStyle('A' . $row . ':H' . $row)->applyFromArray([
					'borders' => [
						'allBorders' => [
							'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
							'color' => ['argb' => '000000'],
						]
					]
				]);
				$row++;
			}

			// Mengatur lebar kolom agar rapi
			foreach (range('A', 'H') as $column) {
				$sheet->getColumnDimension($column)->setAutoSize(true);
			}

			// Output file excel
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="Data_Komite_' . date('Ymd') . '.xlsx"');
			header('Cache-Control: max-age=0');

			$writer = new Xlsx($spreadsheet);
			$writer->save('php://output');
			exit;
		}
	}

	// Fungsi tambahan untuk memformat hasil analisa
	private function formatHasilAnalisa($hasil_analisa)
	{
		switch ($hasil_analisa) {
			case '1':
				return 'Tidak Rekomendasi';
			case '2':
				return 'Pertimbangkan';
			case '3':
				return 'Rekomendasi';
			default:
				return '-';
		}
	}

	public function komite_hasil()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Usulan_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Data Hasil Komite | MelatiApp";

			$start_date = $this->input->get('start_date');
			$end_date = $this->input->get('end_date');

			// Jika tanggal tidak diset, gunakan fungsi tanpa filter
			if ($start_date && $end_date) {
				$data['survey_data'] = $this->Usulan_model->getKomiteHasilByDate($start_date, $end_date);
			} else {
				$data['survey_data'] = $this->Usulan_model->getKomiteHasil();  // Semua data
			}

			$this->load->view('users/header', $data);
			$this->load->view('users/komite/komite_hasil', $data);
			$this->load->view('users/footer');
		}
	}

	public function komite_hasil_export_excel()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Usulan_model');

			$start_date = $this->input->get('start_date');
			$end_date = $this->input->get('end_date');

			// Retrieve data based on date filter or retrieve all data
			if (empty($start_date) || empty($end_date)) {
				$data_komite = $this->Usulan_model->getKomiteHasil();
			} else {
				$data_komite = $this->Usulan_model->getKomiteHasilByDate($start_date, $end_date);
			}

			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();

			// Set Excel headers
			$sheet->setCellValue('A1', 'ID/CekBI')
				->setCellValue('B1', 'Nama')
				->setCellValue('C1', 'Alamat')
				->setCellValue('D1', 'Plafon Usulan')
				->setCellValue('E1', 'Inpuser')
				->setCellValue('F1', 'Surveyor')
				->setCellValue('G1', 'Analyst')
				->setCellValue('H1', 'Hasil Analisa')
				->setCellValue('I1', 'Hasil Komite')
				->setCellValue('J1', 'Realisasi');

			// Apply header styles
			$headerStyleArray = [
				'font' => [
					'bold' => true,
					'color' => ['argb' => 'FFFFFF'],
					'size' => 12
				],
				'alignment' => [
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
					'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
				],
				'fill' => [
					'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
					'startColor' => ['argb' => '4CAF50']
				]
			];
			$sheet->getStyle('A1:J1')->applyFromArray($headerStyleArray);

			// Insert data into the spreadsheet
			$row = 2; // Data starts from row 2
			foreach ($data_komite as $data) {
				$cekbi = (!empty($data->tgl_cek_bi)) ? date('Ymd', strtotime($data->tgl_cek_bi)) . '_PBY' . $data->id_pby : 'PBY' . $data->id_pby;

				// Fill in the data
				$sheet->setCellValue('A' . $row, $cekbi)
					->setCellValue('B' . $row, $data->nama)
					->setCellValue('C' . $row, $data->alamat . ' ' . $data->kelurahan_nama . ' ' . $data->kecamatan_nama . ' ' . $data->kota_nama)
					->setCellValue('D' . $row, 'Rp ' . number_format($data->nominal, 0, ',', '.'))
					->setCellValue('E' . $row, $this->Usulan_model->getUsernameById($data->id_user))
					->setCellValue('F' . $row, $this->Usulan_model->getUsernameById($data->surveyor))
					->setCellValue('G' . $row, $this->Usulan_model->getUsernameById($data->analyst))
					->setCellValue('H' . $row, $this->formatHasilAnalisa($data->hasil_analisa))
					->setCellValue('J' . $row, 'Rp ' . number_format($data->jml_realisasi, 0, ',', '.'));

				switch ($data->status_komite) {
					case '1':
						$status_komite = 'Acc';
						break;
					case '2':
						$status_komite = 'Ditunda';
						break;
					case '3':
						$status_komite = 'Ditolak';
						break;
					default:
						$status_komite = '-';
				}
				$sheet->setCellValue('I' . $row, $status_komite);

				// Apply border to the cells
				$sheet->getStyle('A' . $row . ':J' . $row)->applyFromArray([
					'borders' => [
						'allBorders' => [
							'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
							'color' => ['argb' => '000000'],
						]
					]
				]);

				$row++;
			}

			// Set column widths
			foreach (range('A', 'J') as $column) {
				$sheet->getColumnDimension($column)->setAutoSize(true);
			}

			// Output the Excel file
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="Hasil_Komite_' . date('Ymd') . '.xlsx"');
			header('Cache-Control: max-age=0');

			$writer = new Xlsx($spreadsheet);
			$writer->save('php://output');
			exit;
		}
	}

	public function komite_edit($id)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Usulan_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Edit Komite | MelatiApp";
			$data['survey_data'] = $this->Usulan_model->getKomiteDetail($id); // Load the survey data

			$level = $this->session->userdata('level');

			if ($this->input->post()) {
				$updated_data = array(
					'status_komite' => $this->input->post('status_komite'),
					'tgl_komite' => $this->input->post('tgl_komite'),
					'jml_realisasi' => $this->input->post('jml_realisasi'),
					'akad' => $this->input->post('akad'),
					'tgl_dropping' => $this->input->post('tgl_dropping'),
					'cara_angsuran' => $this->input->post('cara_angsuran'),
					'pengikat' => $this->input->post('pengikat'),
					'catatan_komite' => $this->input->post('catatan_komite'),
				);

				// Signature fields to be handled (no level-based check)
				$signature_fields = [
					'ttd_gm',
					'ttd_mb',
					'ttd_mc',
					'ttd_ad',
					'ttd_mt',
					'ttd_sv'
				];

				$signature_names = [];

				foreach ($signature_fields as $field) {
					if (!empty($this->input->post($field))) {
						// Process the signature data (assuming base64 encoding)
						$signature_data = $this->input->post($field);
						$signature_data = str_replace('data:image/png;base64,', '', $signature_data); // Remove base64 prefix
						$signature_data = base64_decode($signature_data); // Decode from base64 to binary

						// Generate a unique file name
						$signature_filename = $field . '_' . time() . '.png';

						// Set the path to save the signature image
						$signature_file_path = './foto/foto_usulan/foto_ttd/' . $signature_filename;

						// Save the signature file
						file_put_contents($signature_file_path, $signature_data);

						// Store only the filename in the array
						$signature_names[$field] = $signature_filename;
					}
				}

				// Merge the uploaded signature files with the data to be updated
				$updated_data = array_merge($updated_data, $signature_names);

				// Call model to update the data
				$this->Usulan_model->update_survey_data($id, $updated_data);

				// Redirect or show a success message
				$this->session->set_flashdata('msg', 'Data successfully updated');
				redirect('users/komite_data');
			}

			$this->load->view('users/header', $data);
			$this->load->view('users/komite/komite_edit', $data);
			$this->load->view('users/footer');
		}
	}

	public function file_user_upload()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('File_user_model');
			$id_user = $this->session->userdata('id_user');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "File User Upload | MelatiApp";
			$data['categories'] = $this->File_user_model->get_all_categories_by_id_user($id_user);

			$this->load->view('users/header', $data);
			$this->load->view('users/file_user/file_user_upload', $data);
			$this->load->view('users/footer');
		}
	}

	public function file_user_lihat($id)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('File_user_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "File User Lihat | MelatiApp";

			$data['file_user'] = $this->File_user_model->get_file_by_id($id);

			$this->load->view('users/header', $data);
			$this->load->view('users/file_user/file_user_lihat', $data);
			$this->load->view('users/footer');
		}
	}

	public function file_user_lihat_id_pby($id_pby)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('File_user_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "File User Lihat SLIK | MelatiApp";

			$data['file_user'] = $this->File_user_model->get_file_by_id_pby($id_pby);

			$this->load->view('users/header', $data);
			$this->load->view('users/file_user/file_user_lihat_id_pby', $data);
			$this->load->view('users/footer');
		}
	}

	public function file_user_lihat_id_mlt($id_mlt)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('File_user_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "File User Lihat SLIK MLT | MelatiApp";

			$data['file_user'] = $this->File_user_model->get_file_by_id_mlt($id_mlt);

			$this->load->view('users/header', $data);
			$this->load->view('users/file_user/file_user_lihat_id_pby', $data);
			$this->load->view('users/footer');
		}
	}

	public function file_user_edit($id)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('File_user_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "File User Edit | MelatiApp";

			$data['file_user'] = $this->File_user_model->get_file_by_id($id);

			if (empty($data['file_user'])) {
				show_404();
			}

			$this->load->view('users/header', $data);
			$this->load->view('users/file_user/file_user_edit', $data);
			$this->load->view('users/footer');
		}
	}

	public function file_user_edit_id_pby($id_pby)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('File_user_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "File User Edit SLIK | MelatiApp";

			$data['file_user'] = $this->File_user_model->get_file_by_id_pby($id_pby);

			if (empty($data['file_user'])) {
				show_404();
			}

			$this->load->view('users/header', $data);
			$this->load->view('users/file_user/file_user_edit_id_pby', $data);
			$this->load->view('users/footer');
		}
	}

	public function file_user_submit()
	{
		if (!$this->session->userdata('username')) {
			redirect('web/login');
		}

		// Load the model
		$this->load->model('File_user_model');

		// Ambil data dari form
		$id_user = $this->input->post('id_user');
		$id_pby = $this->input->post('id_pby');
		$nama = $this->input->post('nama');
		$download_status = $this->input->post('download_status');
		$description = $this->input->post('description');
		$category = $this->input->post('category');
		$folder = $this->input->post('folder');
		$tahun = $this->input->post('tahun');
		$uploaded_by = $this->session->userdata('nama_lengkap');
		$uploaded_at = date('Y-m-d H:i:s');

		// Persiapkan data untuk disimpan
		$data = array(
			'id_user' => $id_user,
			'id_pby' => $id_pby,
			'nama' => $nama,
			'uploaded_by' => $uploaded_by,
			'download_status' => $download_status,
			'description' => $description,
			'category' => $category,
			'folder' => $folder,
			'tahun' => $tahun,
			'uploaded_at' => $uploaded_at,
		);

		if (!empty($_FILES['file_upload']['name'])) {
			// Konfigurasi upload
			$config['upload_path'] = './files/file_user';
			$config['allowed_types'] = '*'; // Izinkan semua tipe file
			$config['max_size'] = 20480; // Maksimal ukuran file 20MB
			$this->load->library('upload');

			$original_filename = $_FILES['file_upload']['name'];
			$file_ext = pathinfo($original_filename, PATHINFO_EXTENSION); // Ekstensi file

			// Buat nama file baru yang unik (gunakan uniqid atau timestamp)
			$unique_filename = uniqid() . '_' . time() . '.' . $file_ext;

			// Set nama file di konfigurasi upload
			$config['file_name'] = $unique_filename;

			$this->upload->initialize($config);

			// Cek apakah file berhasil diupload
			if (!$this->upload->do_upload('file_upload')) {
			}

			// Ambil data upload
			$upload_data = $this->upload->data();
			$data['file_name'] = $upload_data['file_name'];
			$data['file_path'] = $upload_data['full_path'];
			$data['file_size'] = $upload_data['file_size'];
			$data['file_type'] = $upload_data['file_type'];
		}

		// Insert data ke tabel
		if ($this->File_user_model->insert_file($data)) {
			$this->session->set_flashdata('msg', '<div class="alert alert-success">File berhasil diupload!</div>');
		} else {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger">Gagal mengupload file.</div>');
		}

		redirect('users/file_user_by_id_user');
	}

	public function file_user_submit_slik()
	{
		if (!$this->session->userdata('username')) {
			redirect('web/login');
		}

		// Load the model
		$this->load->model('File_user_model');

		// Ambil data dari form
		$id_pby = $this->input->post('id_pby');
		$nama = $this->input->post('nama');
		$download_status = $this->input->post('download_status');
		$description = $this->input->post('description');
		$category = $this->input->post('category');
		$folder = $this->input->post('folder');
		$tahun = $this->input->post('tahun');
		$uploaded_by = $this->session->userdata('nama_lengkap');
		$uploaded_at = date('Y-m-d H:i:s');

		// Persiapkan data untuk disimpan
		$data = array(
			'id_pby' => $id_pby,
			'nama' => $nama,
			'uploaded_by' => $uploaded_by,
			'download_status' => $download_status,
			'description' => $description,
			'category' => $category,
			'folder' => $folder,
			'tahun' => $tahun,
			'uploaded_at' => $uploaded_at,
		);

		if (!empty($_FILES['file_upload']['name'])) {
			// Konfigurasi upload
			$config['upload_path'] = './files/file_user';
			$config['allowed_types'] = '*'; // Izinkan semua tipe file
			$config['max_size'] = 20480; // Maksimal ukuran file 20MB
			$this->load->library('upload');

			$original_filename = $_FILES['file_upload']['name'];
			$file_ext = pathinfo($original_filename, PATHINFO_EXTENSION); // Ekstensi file

			// Buat nama file baru yang unik (gunakan uniqid atau timestamp)
			$unique_filename = uniqid() . '_' . time() . '.' . $file_ext;

			// Set nama file di konfigurasi upload
			$config['file_name'] = $unique_filename;

			$this->upload->initialize($config);

			// Cek apakah file berhasil diupload
			if (!$this->upload->do_upload('file_upload')) {
			}

			// Ambil data upload
			$upload_data = $this->upload->data();
			$data['file_name'] = $upload_data['file_name'];
			$data['file_path'] = $upload_data['full_path'];
			$data['file_size'] = $upload_data['file_size'];
			$data['file_type'] = $upload_data['file_type'];
		}

		// Insert data ke tabel
		if ($this->File_user_model->insert_file($data)) {
			$this->session->set_flashdata('msg', '<div class="alert alert-success">File berhasil diupload!</div>');
		} else {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger">Gagal mengupload file.</div>');
		}

		redirect('users/analisa');
	}

	public function file_user_update($id)
	{
		if (!$this->session->userdata('username')) {
			redirect('web/login');
		}

		$uploaded_at = $this->input->post('uploaded_at');
		$category = $this->input->post('category');
		$tahun = $this->input->post('tahun');
		$download_status = $this->input->post('download_status');
		$description = $this->input->post('description');

		$data = array(
			'uploaded_at' => $uploaded_at,
			'category' => $category,
			'tahun' => $tahun,
			'download_status' => $download_status,
			'description' => $description
		);

		if (!empty($_FILES['file_upload']['name'])) {
			$config['upload_path'] = './uploads/files/';
			$config['allowed_types'] = 'pdf|doc|docx|xls|xlsx|ppt|pptx|zip|rar';
			$config['max_size'] = 20048;
			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('file_upload')) {
				// Handle file upload error
			}

			$upload_data = $this->upload->data();
			$file_path = $upload_data['file_name'];

			$data['file_path'] = $file_path;
		}

		$this->db->where('id', $id);
		$this->db->update('tbl_file_user', $data);
		$this->session->set_flashdata('msg', '<div class="alert alert-success">File successfully updated!</div>');
		redirect('users/file_user_by_id/' . rawurlencode($category));
	}

	public function file_user_update_id_pby($id_pby)
	{
		if (!$this->session->userdata('username')) {
			redirect('web/login');
		}
		$nama = $this->input->post('nama');
		$uploaded_at = $this->input->post('uploaded_at');
		$category = $this->input->post('category');
		$tahun = $this->input->post('tahun');
		$download_status = $this->input->post('download_status');
		$description = $this->input->post('description');

		$data = array(
			'nama' => $nama,
			'uploaded_at' => $uploaded_at,
			'category' => $category,
			'tahun' => $tahun,
			'download_status' => $download_status,
			'description' => $description
		);

		if (!empty($_FILES['file_upload']['name'])) {
			$config['upload_path'] = './uploads/files/';
			$config['allowed_types'] = 'pdf|doc|docx|xls|xlsx|ppt|pptx|zip|rar';
			$config['max_size'] = 20048;
			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('file_upload')) {
				// Handle file upload error
			}

			$upload_data = $this->upload->data();
			$file_path = $upload_data['file_name'];

			$data['file_path'] = $file_path;
		}

		$this->db->where('id_pby', $id_pby);
		$this->db->update('tbl_file_user', $data);
		$this->session->set_flashdata('msg', '<div class="alert alert-success">File successfully updated!</div>');
		redirect('users/file_user_data_id_pby/');
	}

	public function file_user_hapus($id)
	{
		if (!$this->session->userdata('username')) {
			redirect('web/login');
		}
		$this->load->model('File_user_model');
		$file = $this->File_user_model->get_file_by_id($id);

		if (isset($file['file_path']) && file_exists('./files/file_user/' . $file['file_path'])) {
			unlink('./files/file_user/' . $file['file_path']);
		}

		$this->db->where('id', $id);
		$this->db->delete('tbl_file_user');
		$this->session->set_flashdata('msg', '<div class="alert alert-success">File berhasil terhapus!</div>');
		redirect('users/file_user_data');
	}

	public function file_user_hapus_by_id_user($id)
	{
		if (!$this->session->userdata('username')) {
			redirect('web/login');
		}
		$this->load->model('File_user_model');
		$file = $this->File_user_model->get_file_by_id($id);

		if (isset($file['file_path']) && file_exists('./files/file_user/' . $file['file_path'])) {
			unlink('./files/file_user/' . $file['file_path']);
		}

		$this->db->where('id', $id);
		$this->db->delete('tbl_file_user');
		$this->session->set_flashdata('msg', '<div class="alert alert-success">File berhasil terhapus!</div>');
		redirect('users/file_user_by_id_user');
	}

	public function file_user_hapus_surat_kuasa_by_id_user($id)
	{
		if (!$this->session->userdata('username')) {
			redirect('web/login');
		}
		$this->load->model('File_user_model');
		$file = $this->File_user_model->get_file_by_id($id);

		if (isset($file['file_path']) && file_exists('./files/file_user/' . $file['file_path'])) {
			unlink('./files/file_user/' . $file['file_path']);
		}

		$this->db->where('id', $id);
		$this->db->delete('tbl_file_user');
		$this->session->set_flashdata('msg', '<div class="alert alert-success">File berhasil terhapus!</div>');
		redirect('users/file_user_surat_kuasa_by_id_user');
	}

	public function file_user_download($id)
	{
		// Load the file model
		$this->load->model('File_user_model');

		// Get file details from the model
		$file = $this->File_user_model->get_file_by_id($id);

		if ($file) {
			$file_path = './files/file_user' . $file['file_path'];

			if ($file && file_exists($file['file_path'])) {
				// Force download
				$this->load->helper('download');
				force_download($file['file_path'], NULL);
			} else {
				// File not found, redirect with error message
				$this->session->set_flashdata('msg', '<div class="alert alert-danger">File tidak ditemukan atau sudah dihapus.</div>');
				redirect('users/file_user_data');
			}
		} else {
			// File record not found
			$this->session->set_flashdata('msg', 'File record not found.');
			redirect('users/file_user_data');
		}
	}

	public function file_user_data()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('File_user_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "File User Data | MelatiApp";

			// Ambil kategori (distinct)
			$files = $this->File_user_model->get_all_files();
			$categories = array_unique(array_column($files, 'category'));

			$data['categories'] = $categories;
			$data['file_user'] = $this->File_user_model->get_all_files();

			$this->load->view('users/header', $data);
			$this->load->view('users/file_user/file_user_data', $data);
			$this->load->view('users/footer');
		}
	}

	public function file_user_data_id_pby()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('File_user_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "File User SLIK | MelatiApp";

			$data['file_user'] = $this->File_user_model->get_all_files_slik();

			$this->load->view('users/header', $data);
			$this->load->view('users/file_user/file_user_data_id_pby', $data);
			$this->load->view('users/footer');
		}
	}

	public function file_user_by_id($category)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('File_user_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "File User by id | MelatiApp";

			// Decode kategori dari URL
			$category = urldecode($category);

			// Ambil file berdasarkan kategori
			$files = $this->File_user_model->get_files_by_category($category);

			$data['category'] = $category;
			$data['files'] = $files;

			$this->load->view('users/header', $data);
			$this->load->view('users/file_user/file_user_by_id', $data);
			$this->load->view('users/footer');
		}
	}

	public function file_user_by_id_user()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('File_user_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "My File | MelatiApp";

			$id_user = $this->session->userdata('id_user');
			$data['file_user'] = $this->File_user_model->get_files_by_user($id_user);

			$this->load->view('users/header', $data);
			$this->load->view('users/file_user/file_user_by_id_user', $data);
			$this->load->view('users/footer');
		}
	}

	public function file_user_id_pby()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('File_user_model');
			$this->load->model('Usulan_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "File Slik Usulan | MelatiApp";

			$data['file_user'] = $this->File_user_model->get_all_files_id_pby();

			$this->load->view('users/header', $data);
			$this->load->view('users/file_user/file_user_id_pby', $data);
			$this->load->view('users/footer');
		}
	}

	public function file_user_id_pby_upload($id_pby)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('File_user_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "File User Upload | MelatiApp";

			// Fetch the 'nama' based on 'id_pby' from tbl_usulan
			$data['nama'] = $this->File_user_model->get_all_files_id_pby($id_pby);

			$data['id_pby'] = $id_pby;

			$this->load->view('users/header', $data);
			$this->load->view('users/file_user/file_user_id_pby_upload', $data);
			$this->load->view('users/footer');
		}
	}

	public function infografis_usulan_per_bulan()
	{
		$ceks = $this->session->userdata('user@mt');

		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Usulan_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Grafik Usulan Kantor | MelatiApp";

			$data['usulan_by_kantor'] = $this->Usulan_model->get_usulan_bulan_berjalan_per_kantor();

			// Load view untuk mengedit informasi
			$this->load->view('users/header', $data);
			$this->load->view('users/informasi/infografis_usulan_per_bulan', $data);
			$this->load->view('users/footer');
		}
	}

	public function infografis_usulan_per_bulan_user()
	{
		$ceks = $this->session->userdata('user@mt');

		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Usulan_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Grafik Usulan User | MelatiApp";

			$data['usulan_by_user'] = $this->Usulan_model->get_usulan_bulan_berjalan_per_user();

			// Load view untuk mengedit informasi
			$this->load->view('users/header', $data);
			$this->load->view('users/informasi/infografis_usulan_per_bulan_user', $data);
			$this->load->view('users/footer');
		}
	}

	public function cek_bi_data()
	{
		$ceks = $this->session->userdata('user@mt');
		$id_user = $this->session->userdata('id_user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Cek_bi_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Data BI Checking | MelatiApp";

			if ($id_user === "0" || $id_user === "41" || $id_user === "24" || $id_user === "18" || $id_user === "4" || $id_user === "17") {
				$data['cek_bi_data'] = $this->Cek_bi_model->get_all_data();
			} else {
				$data['cek_bi_data'] = $this->Cek_bi_model->get_all_data_by_id_user($id_user);
			}

			$this->load->view('users/header', $data);
			$this->load->view('users/cek_bi/cek_bi_data', $data);
			$this->load->view('users/footer');
		}
	}

	public function cek_bi_tambah()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Tambah Cek BI | MelatiApp";

			$this->load->view('users/header', $data);
			$this->load->view('users/cek_bi/cek_bi_tambah');
			$this->load->view('users/footer');
		}
	}

	public function cek_bi_simpan()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Cek_bi_model');

			$nama = $this->input->post('nama');
			$nik = $this->input->post('nik');
			$tgl_lahir = $this->input->post('tgl_lahir');
			$tempat_lahir = $this->input->post('tempat_lahir');
			$jk = $this->input->post('jk');
			$pekerjaan = $this->input->post('pekerjaan');
			$alamat = $this->input->post('alamat');
			$provinsi = $this->input->post('provinsi');
			$kota_kabupaten = $this->input->post('kota_kabupaten');
			$kecamatan = $this->input->post('kecamatan');
			$kelurahan = $this->input->post('kelurahan');
			$kode_pos = $this->input->post('kode_pos');
			$negara = $this->input->post('negara');
			$nama_ibu = $this->input->post('nama_ibu');
			$status_kawin = $this->input->post('status_kawin');
			$status_pendidikan = $this->input->post('status_pendidikan');
			$telepon = $this->input->post('telepon');
			$id_user = $this->input->post('id_user');
			$kode_kantor = $this->input->post('kode_kantor');
			$cek_req = $this->input->post('cek_req');

			$data = array(
				'nama' => $nama,
				'nik' => $nik,
				'tgl_lahir' => $tgl_lahir,
				'tempat_lahir' => $tempat_lahir,
				'jk' => $jk,
				'pekerjaan' => $pekerjaan,
				'alamat' => $alamat,
				'provinsi' => $provinsi,
				'kota_kabupaten' => $kota_kabupaten,
				'kecamatan' => $kecamatan,
				'kelurahan' => $kelurahan,
				'kode_pos' => $kode_pos,
				'negara' => $negara,
				'nama_ibu' => $nama_ibu,
				'status_kawin' => $status_kawin,
				'status_pendidikan' => $status_pendidikan,
				'telepon' => $telepon,
				'id_user' => $id_user,
				'kode_kantor' => $kode_kantor,
				'cek_req' => $cek_req
			);

			$foto_fields = ['foto_ktp'];
			$foto_names = [];

			foreach ($foto_fields as $field) {
				// Cek jika ada file yang dipilih
				if (!empty($_FILES[$field]['name'])) {
					$config['upload_path'] = './foto/foto_cek_bi/foto_ktp';
					$config['allowed_types'] = 'jpg|jpeg|png|gif'; // Format yang diizinkan
					$config['max_size'] = 20480; // Maksimum ukuran file 20MB
					$this->load->library('upload');

					$this->upload->initialize($config); // Inisialisasi pustaka upload dengan konfigurasi

					// Cek jika file berhasil diupload
					if (!$this->upload->do_upload($field)) {
						// Jika gagal upload, tampilkan pesan error
						$upload_error = $this->upload->display_errors();
						$this->session->set_flashdata('error', "Gagal mengupload $field: $upload_error");
						redirect('users/cek_bi_data'); // Kembali ke form jika gagal
					}

					// Ambil data file yang diupload
					$upload_data = $this->upload->data();
					$foto_names[$field] = $upload_data['file_name']; // Simpan nama file di array foto_names
				}
			}

			if (!empty($this->input->post('ttd'))) {
				$ttd_data = $this->input->post('ttd');
				$ttd_data = str_replace('data:image/png;base64,', '', $ttd_data); // Hapus prefix base64
				$ttd_data = base64_decode($ttd_data); // Decode base64 ke format biner

				// Tentukan nama file tanda tangan (hanya nama file, tanpa path)
				$ttd_filename = 'ttd_' . $nik . '_' . time() . '.png';

				// Tentukan path lengkap untuk menyimpan file tanda tangan
				$ttd_file = './foto/foto_cek_bi/foto_ttd/' . $ttd_filename;

				// Simpan file tanda tangan
				file_put_contents($ttd_file, $ttd_data);

				// Simpan hanya nama file di array foto_names
				$foto_names['ttd'] = $ttd_filename;
			}

			// Tambahkan nama file foto ke dalam data yang akan disimpan
			$data = array_merge($data, $foto_names); // Gabungkan data dengan foto_names

			// Insert data into the Cek_bi_model and check if the insertion was successful
			$inserted = $this->Cek_bi_model->insert_data($data);

			if ($inserted) {
				// Set a flash data message for a successful save
				$this->session->set_flashdata('msg', 'Data saved successfully');
			} else {
				// Set a flash data message for an error
				$this->session->set_flashdata('msg', 'Error: Data could not be saved');
			}

			// Redirect to a relevant page after saving the data
			redirect('users/cek_bi_data'); // You can modify this URL as needed
		}
	}

	public function cek_bi_detail($id)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Cek_bi_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Detail BI Cheking | MelatiApp";
			$data['cek_bi_detail'] = $this->Cek_bi_model->getUsulanDetail($id);

			$this->load->view('users/header', $data);
			$this->load->view('users/cek_bi/cek_bi_detail', $data);
			$this->load->view('users/footer');
		}
	}

	public function cek_bi_edit($row_id)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Cek_bi_model');

			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Cek BI Edit | MelatiApp";

			$data['cek_bi_data'] = $this->Cek_bi_model->get_data_by_id($row_id);

			$this->load->view('users/header', $data);
			$this->load->view('users/cek_bi/cek_bi_edit', $data);
			$this->load->view('users/footer');
		}
	}

	public function cek_bi_edit_status($row_id)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Cek_bi_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Edit Status Cek BI | MelatiApp";
			$data['cek_bi_data'] = $this->Cek_bi_model->get_data_by_id($row_id);

			$this->load->view('users/header', $data);
			$this->load->view('users/cek_bi/cek_bi_edit_status', $data);
			$this->load->view('users/footer');
		}
	}

	public function cek_bi_update($row_id)
	{
		// Periksa apakah pengguna sudah login
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Cek_bi_model');

			// Set validation rules
			$this->form_validation->set_rules('nama', 'Nama Pemohon', 'required');

			// Fetch existing data for the current row
			$cek_bi_data = $this->Cek_bi_model->get_cek_bi_data_by_id($row_id); // Assume this function exists
			if (!$cek_bi_data) {
				$this->session->set_flashdata('error', 'Data tidak ditemukan');
				redirect('users/cek_bi_data');
			}

			// Initialize data array for the view
			$data = [
				'cek_bi_data' => $cek_bi_data
			];

			if ($this->form_validation->run() === FALSE) {
				// Validation failed, load the edit view with errors
				$this->load->view('users/header', $data);
				$this->load->view('users/cek_bi/cek_bi_edit', $data);
				$this->load->view('users/footer');
			} else {
				// Prepare data from input
				$update_data = [
					'nama' => $this->input->post('nama'),
					'nik' => $this->input->post('nik'),
					'tgl_lahir' => $this->input->post('tgl_lahir'),
					'tempat_lahir' => $this->input->post('tempat_lahir'),
					'jk' => $this->input->post('jk'),
					'pekerjaan' => $this->input->post('pekerjaan'),
					'alamat' => $this->input->post('alamat'),
					'nama_ibu' => $this->input->post('nama_ibu'),
					'telepon' => $this->input->post('telepon')
				];

				// Handle file uploads
				$foto_fields = ['foto_ktp'];
				$foto_names = [];

				foreach ($foto_fields as $field) {
					// Cek jika ada file yang dipilih
					if (!empty($_FILES[$field]['name'])) {
						$config['upload_path'] = './foto/foto_cek_bi/foto_ktp';
						$config['allowed_types'] = 'jpg|jpeg|png|gif'; // Format yang diizinkan
						$config['max_size'] = 20480; // Maksimum ukuran file 20MB
						$this->load->library('upload');

						$this->upload->initialize($config); // Inisialisasi pustaka upload dengan konfigurasi

						// Cek jika file berhasil diupload
						if (!$this->upload->do_upload($field)) {
							// Jika gagal upload, tampilkan pesan error
							$upload_error = $this->upload->display_errors();
							$this->session->set_flashdata('error', "Gagal mengupload $field: $upload_error");
							redirect('users/cek_bi_data'); // Kembali ke form jika gagal
						}

						// Ambil data file yang diupload
						$upload_data = $this->upload->data();
						$foto_names[$field] = $upload_data['file_name']; // Simpan nama file di array foto_names
					}
				}

				// Handle signature input
				if (!empty($this->input->post('ttd'))) {
					$ttd_data = $this->input->post('ttd');
					$ttd_data = str_replace('data:image/png;base64,', '', $ttd_data);
					$ttd_data = base64_decode($ttd_data);

					$ttd_filename = 'ttd_' . $this->input->post('nik') . '_' . time() . '.png';
					$ttd_file = './foto/foto_cek_bi/foto_ttd/' . $ttd_filename;

					file_put_contents($ttd_file, $ttd_data);
					$foto_names['ttd'] = $ttd_filename;
				}

				// Merge the file names into the update data
				$update_data = array_merge($update_data, $foto_names);

				// Update the record in the database
				$this->Cek_bi_model->cek_bi_update($row_id, $update_data);

				// Redirect to the data listing page
				redirect('users/cek_bi_data');
			}
		}
	}

	public function cek_bi_update_status($id)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Cek_bi_model');
			$data['cek_bi_data'] = $this->Cek_bi_model->get_data_by_id($id);

			if ($this->input->post()) {
				$updated_data = array(
					'tgl_cek_bi' => $this->input->post('tgl_cek_bi'),
					'keterangan' => $this->input->post('keterangan'),
				);

				$this->Cek_bi_model->cek_bi_update($id, $updated_data);

				// Redirect atau tampilkan pesan sukses
				redirect('users/cek_bi_edit_status/' . $id);
			}
		}
	}

	public function cek_bi_print($row_id)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Cek_bi_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "BI Checking Print | MelatiApp";
			$data['cek_bi'] = $this->Cek_bi_model->get_cek_bi_data_by_id($row_id);
			$data['logo'] = $this->Mcrud->get_setting_by_key('logo');

			// Memuat view untuk print
			$this->load->view('users/cek_bi/cek_bi_print', $data);
		}
	}

	public function cek_bi_hapus($id)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Cek_bi_model');
			$cek_bi = $this->Cek_bi_model->get_data_by_id($id);
			if (!$cek_bi) {
				$response = array('status' => 'error', 'message' => 'Data not found');
				echo json_encode($response);
				return;
			}

			$deleted = $this->Cek_bi_model->delete_data($id);

			if ($deleted) {
				$response = array('status' => 'success', 'message' => 'Data deleted successfully');
			} else {
				$response = array('status' => 'error', 'message' => 'Error: Data could not be deleted');
			}

			echo json_encode($response);
		}
	}

	public function cek_bi_upload($row_id)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Cek_bi_model');
			$data['cek_bi_data'] = $this->Cek_bi_model->get_cek_bi_data_by_id($row_id);
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Cek BI Upload | MelatiApp";
			$data['row_id'] = $row_id;

			$this->load->view('users/header', $data);
			$this->load->view('users/cek_bi/cek_bi_upload', $data);
			$this->load->view('users/footer');
		}
	}

	public function cek_bi_submit_slik()
	{
		if (!$this->session->userdata('username')) {
			redirect('web/login');
		}

		// Load the model
		$this->load->model('File_user_model');

		// Ambil data dari form
		$id_mlt = $this->input->post('id_mlt');
		$nama = $this->input->post('nama');
		$download_status = $this->input->post('download_status');
		$description = $this->input->post('description');
		$category = $this->input->post('category');
		$folder = $this->input->post('folder');
		$tahun = $this->input->post('tahun');
		$uploaded_by = $this->session->userdata('nama_lengkap');
		$uploaded_at = date('Y-m-d H:i:s');

		// Persiapkan data untuk disimpan
		$data = array(
			'id_mlt' => $id_mlt,
			'nama' => $nama,
			'uploaded_by' => $uploaded_by,
			'download_status' => $download_status,
			'description' => $description,
			'category' => $category,
			'folder' => $folder,
			'tahun' => $tahun,
			'uploaded_at' => $uploaded_at,
		);

		if (!empty($_FILES['file_upload']['name'])) {
			// Konfigurasi upload
			$config['upload_path'] = './files/file_user';
			$config['allowed_types'] = '*'; // Izinkan semua tipe file
			$config['max_size'] = 20480; // Maksimal ukuran file 20MB
			$this->load->library('upload');

			$original_filename = $_FILES['file_upload']['name'];
			$file_ext = pathinfo($original_filename, PATHINFO_EXTENSION); // Ekstensi file

			// Buat nama file baru yang unik (gunakan uniqid atau timestamp)
			$unique_filename = uniqid() . '_' . time() . '.' . $file_ext;

			// Set nama file di konfigurasi upload
			$config['file_name'] = $unique_filename;

			$this->upload->initialize($config);

			// Cek apakah file berhasil diupload
			if (!$this->upload->do_upload('file_upload')) {
			}

			// Ambil data upload
			$upload_data = $this->upload->data();
			$data['file_name'] = $upload_data['file_name'];
			$data['file_path'] = $upload_data['full_path'];
			$data['file_size'] = $upload_data['file_size'];
			$data['file_type'] = $upload_data['file_type'];
		}

		// Insert data ke tabel
		if ($this->File_user_model->insert_file($data)) {
			$this->session->set_flashdata('msg', '<div class="alert alert-success">File berhasil diupload!</div>');
		} else {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger">Gagal mengupload file.</div>');
		}

		redirect('users/cek_bi_data');
	}

	public function file_user_surat_kuasa_by_id_user()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('File_user_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Surat Kuasa | MelatiApp";

			$id_user = $this->session->userdata('id_user');
			$data['file_user'] = $this->File_user_model->get_files_surat_kuasa_by_user($id_user);

			$this->load->view('users/header', $data);
			$this->load->view('users/file_user/file_user_surat_kuasa_by_id_user', $data);
			$this->load->view('users/footer');
		}
	}

	public function file_user_surat_kuasa_upload()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('File_user_model');
			$id_user = $this->session->userdata('id_user');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Surat Kuasa Upload | MelatiApp";

			$this->load->view('users/header', $data);
			$this->load->view('users/file_user/file_user_surat_kuasa_upload', $data);
			$this->load->view('users/footer');
		}
	}

	public function file_user_surat_kuasa_edit($id)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('File_user_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Surat Kuasa Edit | MelatiApp";

			$data['file_user'] = $this->File_user_model->get_file_by_id($id);

			if (empty($data['file_user'])) {
				show_404();
			}

			$this->load->view('users/header', $data);
			$this->load->view('users/file_user/file_user_surat_kuasa_edit', $data);
			$this->load->view('users/footer');
		}
	}

	public function file_user_surat_kuasa_submit()
	{
		if (!$this->session->userdata('username')) {
			redirect('web/login');
		}

		// Load the model
		$this->load->model('File_user_model');

		// Ambil data dari form
		$id_user = $this->input->post('id_user');
		$nama = $this->input->post('nama');
		$download_status = $this->input->post('download_status');
		$description = $this->input->post('description');
		$category = $this->input->post('category');
		$folder = $this->input->post('folder');
		$tahun = $this->input->post('tahun');
		$uploaded_by = $this->session->userdata('nama_lengkap');
		$uploaded_at = date('Y-m-d H:i:s');

		// Persiapkan data untuk disimpan
		$data = array(
			'id_user' => $id_user,
			'nama' => $nama,
			'uploaded_by' => $uploaded_by,
			'download_status' => $download_status,
			'description' => $description,
			'category' => $category,
			'folder' => $folder,
			'tahun' => $tahun,
			'uploaded_at' => $uploaded_at,
		);

		if (!empty($_FILES['file_upload']['name'])) {
			// Konfigurasi upload
			$config['upload_path'] = './files/file_user';
			$config['allowed_types'] = '*'; // Izinkan semua tipe file
			$config['max_size'] = 20480; // Maksimal ukuran file 20MB
			$this->load->library('upload');

			$original_filename = $_FILES['file_upload']['name'];
			$file_ext = pathinfo($original_filename, PATHINFO_EXTENSION); // Ekstensi file

			// Buat nama file baru yang unik (gunakan uniqid atau timestamp)
			$unique_filename = uniqid() . '_' . time() . '.' . $file_ext;

			// Set nama file di konfigurasi upload
			$config['file_name'] = $unique_filename;

			$this->upload->initialize($config);

			// Cek apakah file berhasil diupload
			if (!$this->upload->do_upload('file_upload')) {
			}

			// Ambil data upload
			$upload_data = $this->upload->data();
			$data['file_name'] = $upload_data['file_name'];
			$data['file_path'] = $upload_data['full_path'];
			$data['file_size'] = $upload_data['file_size'];
			$data['file_type'] = $upload_data['file_type'];
		}

		// Insert data ke tabel
		if ($this->File_user_model->insert_file($data)) {
			$this->session->set_flashdata('msg', '<div class="alert alert-success">File berhasil diupload!</div>');
		} else {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger">Gagal mengupload file.</div>');
		}

		redirect('users/file_user_surat_kuasa_by_id_user');
	}

	public function file_user_surat_kuasa_update($id)
	{
		if (!$this->session->userdata('username')) {
			redirect('web/login');
		}
		$nama = $this->input->post('nama');
		$uploaded_at = $this->input->post('uploaded_at');
		$category = $this->input->post('category');
		$tahun = $this->input->post('tahun');
		$download_status = $this->input->post('download_status');
		$description = $this->input->post('description');

		$data = array(
			'nama' => $nama,
			'uploaded_at' => $uploaded_at,
			'category' => $category,
			'tahun' => $tahun,
			'download_status' => $download_status,
			'description' => $description
		);

		if (!empty($_FILES['file_upload']['name'])) {
			$config['upload_path'] = './uploads/files/';
			$config['allowed_types'] = 'pdf|doc|docx|xls|xlsx|ppt|pptx|zip|rar';
			$config['max_size'] = 20048;
			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('file_upload')) {
				// Handle file upload error
			}

			$upload_data = $this->upload->data();
			$file_path = $upload_data['file_name'];

			$data['file_path'] = $file_path;
		}

		$this->db->where('id', $id);
		$this->db->update('tbl_file_user', $data);
		$this->session->set_flashdata('msg', '<div class="alert alert-success">File successfully updated!</div>');
		redirect('users/file_user_surat_kuasa_by_id_user');
	}

	public function clik_data()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Data Clik | MelatiApp";

			$this->load->view('users/header', $data);
			$this->load->view('users/clik/clik_data', $data);
			$this->load->view('users/footer');
		}
	}

	public function kunjungan_data()
	{
		$ceks = $this->session->userdata('user@mt');
		$id_user = $this->session->userdata('id_user@mt');

		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Kunjungan_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Kunjungan | MelatiApp";

			// Ambil tanggal_awal dan tanggal_akhir dari input pengguna
			$tanggal_awal = $this->input->get('tanggal_awal');
			if (empty($tanggal_awal)) {
				$tanggal_awal = date('Y-m-01');
			}
			$tanggal_akhir = $this->input->get('tanggal_akhir');
			if (empty($tanggal_akhir)) {
				$tanggal_akhir = date('Y-m-d'); // Default ke tanggal hari ini
			}

			// Ambil data akses menu berdasarkan id_user jika ada
			if ($id_user === "0" || $id_user === "24") {
				$data['kunjungan_data'] = $this->Kunjungan_model->get_data_kunjungan($tanggal_awal, $tanggal_akhir);
			} else {
				$data['kunjungan_data'] = $this->Kunjungan_model->get_data_kunjungan_by_id_user($id_user, $tanggal_awal, $tanggal_akhir);
			}

			// Load view untuk mengedit informasi
			$this->load->view('users/header', $data);
			$this->load->view('users/kunjungan/kunjungan_data', $data);
			$this->load->view('users/footer');
		}
	}

	public function kunjungan_data_export_excel($tanggal_awal = null, $tanggal_akhir = null)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Kunjungan_model');

			$tanggal_awal = $tanggal_awal ? $tanggal_awal : date('Y-m-01');
			$tanggal_akhir = $tanggal_akhir ? $tanggal_akhir : date('Y-m-d');

			$tanggal_awal = date('Y-m-d', strtotime($tanggal_awal));
			$tanggal_akhir = date('Y-m-d', strtotime($tanggal_akhir));

			$data_kunjungan = $this->Kunjungan_model->get_kunjungan_by_tujuan($tanggal_awal, $tanggal_akhir);

			if (empty($data_kunjungan)) {
				exit('No data found for the selected date range.');
			}

			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();

			// Header kolom
			$headers = ['No', 'Tanggal', 'Nama Anggota', 'Alamat', 'Tujuan', 'Keterangan', 'User Input'];
			$col = 1;
			foreach ($headers as $header) {
				$sheet->setCellValueByColumnAndRow($col++, 1, $header);
			}

			// Styling header
			$sheet->getStyle('A1:G1')->applyFromArray([
				'font' => ['bold' => true, 'size' => 12],
				'alignment' => [
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
					'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
				],
				'fill' => [
					'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
					'startColor' => ['rgb' => '4CAF50'],
				],
				'borders' => [
					'allBorders' => [
						'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
						'color' => ['rgb' => '000000'],
					],
				],
			]);

			// Isi data
			$row = 2;
			$no = 1;
			foreach ($data_kunjungan as $item) {
				$sheet->setCellValue('A' . $row, $no++);
				$sheet->setCellValue('B' . $row, $item->tanggal);
				$sheet->setCellValue('C' . $row, $item->nama_anggota);
				$sheet->setCellValue('D' . $row, $item->alamat);
				$sheet->setCellValue('E' . $row, $item->tujuan);
				$sheet->setCellValue('F' . $row, $item->keterangan);
				$sheet->setCellValue('G' . $row, $item->inpuser);
				$row++;
			}

			$filename = 'Data_Kunjungan_' . date('Ymd', strtotime($tanggal_awal)) . '_' . date('Ymd', strtotime($tanggal_akhir)) . '.xlsx';

			ob_end_clean();
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="' . $filename . '"');
			header('Cache-Control: max-age=0');

			$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
			$writer->save('php://output');
		}
	}


	public function kunjungan_laporan()
	{
		$ceks = $this->session->userdata('user@mt');
		$id_user = $this->session->userdata('id_user@mt');

		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Kunjungan_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Laporan Kunjungan | MelatiApp";

			// Mendapatkan tanggal awal dan tanggal akhir untuk filter
			$tanggal_awal = isset($_GET['tanggal_awal']) ? $_GET['tanggal_awal'] : date('Y-m-01'); // Default tanggal awal adalah 1 bulan ini
			$tanggal_akhir = isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : date('Y-m-d'); // Default tanggal akhir adalah hari ini

			$data['tanggal_awal'] = $tanggal_awal;
			$data['tanggal_akhir'] = $tanggal_akhir;

			// Mendapatkan data kunjungan berdasarkan tanggal
			$kunjungan_data = $this->Kunjungan_model->get_kunjungan_by_category_tujuan($tanggal_awal, $tanggal_akhir);

			// Inisialisasi array untuk menghitung kunjungan per user
			$chart_categories_user = [];
			$chart_visits_user = [];

			// Inisialisasi array untuk menyimpan data user dan petugas
			$user_data = [];

			// Menghitung kunjungan per user
			foreach ($kunjungan_data as $item) {
				// Data per user
				if (!isset($user_data[$item->id_user])) {
					$user_data[$item->id_user] = [
						'inpuser' => $item->inpuser,  // Menyimpan inpuser untuk setiap user
						'visit_count_penagihan' => 0,
						'visit_count_survey' => 0,
						'visit_count_promosi' => 0,
						'visit_count_kolekting' => 0,
						'visit_count_lainnya' => 0,
						'visit_count' => 0,
					];
				}
				$tujuan = strtolower($item->tujuan); // biar gampang bandingkan
				$count = (int) $item->visit_count;

				switch ($tujuan) {
					case 'penagihan':
						$user_data[$item->id_user]['visit_count_penagihan'] += $count;
						break;
					case 'survey':
						$user_data[$item->id_user]['visit_count_survey'] += $count;
						break;
					case 'promosi':
						$user_data[$item->id_user]['visit_count_promosi'] += $count;
						break;
					case 'kolekting':
						$user_data[$item->id_user]['visit_count_kolekting'] += $count;
						break;
					default:
						$user_data[$item->id_user]['visit_count_lainnya'] += $count;
						break;
				}

				// Total semua
				$user_data[$item->id_user]['visit_count'] += $count;
			}

			// Menyiapkan data chart untuk user
			foreach ($user_data as $user_id => $user_info) {
				$chart_categories_user[] = $user_info['inpuser'];
				$chart_visits_user[] = $user_info['visit_count'];
			}

			// Pass data ke view
			$data['user_visit_data'] = $user_data; // Pastikan ini dikirim ke view
			$data['chart_categories_user'] = json_encode($chart_categories_user);
			$data['chart_visits_user'] = json_encode($chart_visits_user);

			// Load view untuk menampilkan data
			$this->load->view('users/header', $data);
			$this->load->view('users/kunjungan/kunjungan_laporan', $data);
			$this->load->view('users/footer');
		}
	}

	public function kunjungan_export_excel($tanggal_awal = null, $tanggal_akhir = null)
	{
		$ceks = $this->session->userdata('user@mt');
		$id_user = $this->session->userdata('id_user@mt');

		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Kunjungan_model');

			$tanggal_awal = $tanggal_awal ? $tanggal_awal : date('Y-m-01');
			$tanggal_akhir = $tanggal_akhir ? $tanggal_akhir : date('Y-m-d');

			$tanggal_awal = date('Y-m-d', strtotime($tanggal_awal));
			$tanggal_akhir = date('Y-m-d', strtotime($tanggal_akhir));

			$kunjungan_data = $this->Kunjungan_model->get_kunjungan_detail_by_category($tanggal_awal, $tanggal_akhir);

			if (empty($kunjungan_data)) {
				exit('No data found for the selected date range.');
			}

			$user_visits = [];
			$all_tujuan = [];

			// Hitung kunjungan berdasarkan user dan tujuan
			foreach ($kunjungan_data as $item) {
				$id_user = $item->id_user;
				$tujuan = $item->tujuan;
				$inpuser = $item->inpuser;

				// Simpan tujuan secara unik
				if (!in_array($tujuan, $all_tujuan)) {
					$all_tujuan[] = $tujuan;
				}

				if (!isset($user_visits[$id_user])) {
					$user_visits[$id_user] = [
						'inpuser' => $inpuser,
						'tujuan' => [],
						'total' => 0,
					];
				}

				// Inisialisasi jika belum ada tujuan
				if (!isset($user_visits[$id_user]['tujuan'][$tujuan])) {
					$user_visits[$id_user]['tujuan'][$tujuan] = 0;
				}

				$user_visits[$id_user]['tujuan'][$tujuan] += $item->visit_count;
				$user_visits[$id_user]['total'] += $item->visit_count;
			}

			// Sort tujuan biar rapih
			sort($all_tujuan);

			// Mulai Excel
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();

			// Header: No, Nama User, Tujuan1, Tujuan2, ..., Total
			$headers = ['No', 'Nama User'];
			foreach ($all_tujuan as $t) {
				$headers[] = $t;
			}
			$headers[] = 'Total Kunjungan';

			// Tulis header ke Excel
			$colIndex = 1;
			foreach ($headers as $header) {
				$sheet->setCellValueByColumnAndRow($colIndex++, 1, $header);
			}

			// Style header
			$styleArray = [
				'font' => ['bold' => true, 'size' => 12],
				'alignment' => [
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
					'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
				],
				'fill' => [
					'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
					'startColor' => ['rgb' => '4CAF50'],
				],
				'borders' => [
					'allBorders' => [
						'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
						'color' => ['rgb' => '000000'],
					],
				],
			];
			$lastColumn = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(count($headers));
			$sheet->getStyle("A1:{$lastColumn}1")->applyFromArray($styleArray);

			// Data rows
			$row = 2;
			$no = 1;
			foreach ($user_visits as $user_info) {
				$col = 1;
				$sheet->setCellValueByColumnAndRow($col++, $row, $no++);
				$sheet->setCellValueByColumnAndRow($col++, $row, $user_info['inpuser']);

				foreach ($all_tujuan as $t) {
					$jumlah = isset($user_info['tujuan'][$t]) ? $user_info['tujuan'][$t] : 0;
					$sheet->setCellValueByColumnAndRow($col++, $row, $jumlah);
				}

				$sheet->setCellValueByColumnAndRow($col, $row, $user_info['total']);

				$row++;
			}

			// Output Excel
			$filename = 'Laporan_Kunjungan_User_Tujuan_' . date('Ymd', strtotime($tanggal_awal)) . '_' . date('Ymd', strtotime($tanggal_akhir)) . '.xlsx';
			ob_end_clean();
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="' . $filename . '"');
			header('Cache-Control: max-age=0');

			$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
			$writer->save('php://output');
		}
	}

	public function kunjungan_lihat($id)
	{
		// Check if the user is logged in
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			// Load model
			$this->load->model('Kunjungan_model');

			// Get data agunan by ID
			$data['kunjungan'] = $this->Kunjungan_model->get_kunjungan_by_id($id);

			// Check if agunan data is found
			if ($data['kunjungan']) {
				$data['user'] = $this->Mcrud->get_users_by_un($ceks);
				$data['judul_web'] = "Detail Kunjungan | MelatiApp";

				// Load view untuk menampilkan detail agunan
				$this->load->view('users/header', $data);
				$this->load->view('users/kunjungan/kunjungan_lihat', $data);
				$this->load->view('users/footer');
			} else {
				// Jika data tidak ditemukan, redirect ke halaman list agunan
				redirect('users/kunjungan_data');
			}
		}
	}

	public function kunjungan_tambah()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Tambah Data Kunjungan | MelatiApp"; // Judul halaman

			$this->load->view('users/header', $data);
			$this->load->view('users/kunjungan/kunjungan_tambah');
			$this->load->view('users/footer');
		}
	}

	public function kunjungan_simpan()
	{
		// Cek apakah pengguna sudah login
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Kunjungan_model');

			if ($this->input->post()) {
				// Ambil data dari form
				$tanggal = $this->input->post('tanggal');
				$nama_anggota = $this->input->post('nama');
				$alamat = $this->input->post('alamat');
				$tujuan = $this->input->post('tujuan');
				$lokasi = $this->input->post('lokasi');
				$keterangan = $this->input->post('keterangan');
				$catatan = $this->input->post('catatan');
				$id_user = $this->input->post('id_user');
				$inpuser = $this->input->post('inpuser');
				$kode_kantor = $this->input->post('kode_kantor');

				// Set up array data
				$data = array(
					'tanggal' => $tanggal,
					'nama_anggota' => $nama_anggota,
					'alamat' => $alamat,
					'tujuan' => $tujuan,
					'lokasi' => $lokasi,
					'keterangan' => $keterangan,
					'catatan' => $catatan,
					'id_user' => $id_user,
					'inpuser' => $inpuser,
					'kode_kantor' => $kode_kantor
				);

				// Cek apakah ada file foto yang diunggah
				if (!empty($_FILES['foto_kunjungan']['name'])) {
					// Konfigurasi upload
					$config['upload_path'] = './foto/foto_kunjungan/';  // Relative path
					$config['allowed_types'] = 'jpg|jpeg|png|gif';
					$config['max_size'] = 20048; // 2MB
					$this->load->library('upload');

					$this->upload->initialize($config);

					// Proses unggah file
					if ($this->upload->do_upload('foto_kunjungan')) {
						// Ambil nama file yang berhasil diunggah
						$upload_data = $this->upload->data();
						$foto_path = $upload_data['file_name'];

						// Simpan nama file foto yang terkompresi ke dalam data
						$data['foto_kunjungan'] = $foto_path;
					} else {
						// Jika gagal upload, tampilkan pesan error
						$this->session->set_flashdata('msg', 'Error: ' . $this->upload->display_errors());
						redirect('users/kunjungan_data');
					}
				}

				// Simpan data ke database
				$this->Kunjungan_model->kunjungan_simpan($data);

				// Redirect ke halaman data kunjungan
				redirect('users/kunjungan_data');
			} else {
				// Jika form tidak disubmit, tampilkan halaman form
				$this->load->view('users/kunjungan_tambah');
			}
		}
	}

	public function kunjungan_edit($id)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {

			$this->load->model('Kunjungan_model');

			$data['kunjungan'] = $this->Kunjungan_model->get_kunjungan_by_id($id);

			if ($data['kunjungan']) {
				$data['user'] = $this->Mcrud->get_users_by_un($ceks);
				$data['judul_web'] = "Edit Kunjungan | MelatiApp";

				$this->load->view('users/header', $data);
				$this->load->view('users/kunjungan/kunjungan_edit', $data);
				$this->load->view('users/footer');
			} else {
				redirect('users/kunjungan_data');
			}
		}
	}

	public function kunjungan_update($id)
	{
		// Check if the user is logged in
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {

			// Check if the form is submitted
			if ($this->input->post()) {

				$tanggal = $this->input->post('tanggal');
				$nama_anggota = $this->input->post('nama_anggota');
				$alamat = $this->input->post('alamat');
				$tujuan = $this->input->post('tujuan');
				$lokasi = $this->input->post('lokasi');
				$keterangan = $this->input->post('keterangan');
				$catatan = $this->input->post('catatan');
				$chuser = $this->input->post('chuser');
				$tanggal_ubah = $this->input->post('tanggal_ubah');

				// Set up array data
				$data = array(
					'tanggal' => $tanggal,
					'nama_anggota' => $nama_anggota,
					'alamat' => $alamat,
					'tujuan' => $tujuan,
					'lokasi' => $lokasi,
					'keterangan' => $keterangan,
					'catatan' => $catatan,
					'chuser' => $chuser,
					'tanggal_ubah' => $tanggal_ubah
				);

				// Check if a file is selected
				if (!empty($_FILES['foto_kunjungan']['name'])) {
					// Konfigurasi pengaturan unggah gambar
					$config['upload_path'] = './foto/foto_kunjungan/';
					$config['allowed_types'] = 'jpg|jpeg|png|gif';
					$config['max_size'] = 2048; // 2MB

					$this->upload->initialize($config);

					// Periksa apakah file berhasil diunggah
					if ($this->upload->do_upload('foto_kunjungan')) {
						// Dapatkan data file yang diunggah
						$upload_data = $this->upload->data();
						$foto_path = $upload_data['file_name'];
						$data['foto_kunjungan'] = $foto_path;
					}
				}

				$this->load->model('Kunjungan_model');
				$this->Kunjungan_model->kunjungan_update($id, $data);

				redirect('users/kunjungan_data');
			}
		}
	}

	public function kunjungan_hapus($id)
	{
		// Check if the user is logged in
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			// Load model
			$this->load->model('Kunjungan_model');

			// Hapus data agunan berdasarkan ID
			$this->Kunjungan_model->kunjungan_hapus($id);

			// Redirect ke halaman list agunan
			redirect('users/kunjungan_data');
		}
	}

	public function rekening_data()
	{
		$ceks = $this->session->userdata('user@mt');
		$id_user = $this->session->userdata('id_user@mt');

		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Info Data Rekening | MelatiApp";

			$this->load->view('users/header', $data);
			$this->load->view('users/rekening/rekening_data', $data);
			$this->load->view('users/footer');
		}
	}

	public function transaksi_imfa_data()
	{
		$ceks = $this->session->userdata('user@mt');
		$id_user = $this->session->userdata('id_user@mt');

		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Transaksi_imfa_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Transaksi Data | MelatiApp";
			$data['transaksi_data'] = $this->Transaksi_imfa_model->get_all_transaksi_sukses();

			$this->load->view('users/header', $data);
			$this->load->view('users/transaksi_imfa/transaksi_imfa_data', $data);
			$this->load->view('users/footer');
		}
	}

	public function jadwal_imsakiyah_data()
	{
		$ceks = $this->session->userdata('user@mt');
		$id_user = $this->session->userdata('id_user@mt');

		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Imsakiyah_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Jadwal Imsakiyah | MelatiApp";

			$data['imsakiyah'] = $this->Imsakiyah_model->get_data_imsakiyah();

			$this->load->view('users/header', $data);
			$this->load->view('users/imsakiyah/imsakiyah_data', $data);
			$this->load->view('users/footer');
		}
	}

	public function sp_data_col()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Sp_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Data Col | MelatiApp";

			// Mengambil input tanggal dari form
			$tanggal_awal = $this->input->get('tanggal_awal');
			$tanggal_akhir = $this->input->get('tanggal_akhir');

			// Jika ada input tanggal, konversi formatnya dari Y-m-d ke Ymd
			if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
				$tanggal_awal = str_replace('-', '', $tanggal_awal);  // Format Ymd
				$tanggal_akhir = str_replace('-', '', $tanggal_akhir); // Format Ymd
			} else {
				// Jika tidak ada input tanggal, ambil semua data tanpa filter tanggal
				$tanggal_awal = null;
				$tanggal_akhir = null;
			}

			// Panggil model dengan atau tanpa filter tanggal
			$data['sp_data'] = $this->Sp_model->get_data_col($tanggal_awal, $tanggal_akhir);

			$this->load->view('users/header', $data);
			$this->load->view('users/sp/sp_data_col', $data);
			$this->load->view('users/footer');
		}
	}

	public function sp_data()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Sp_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "SP Data | MelatiApp";

			// Mengambil input tanggal dari form
			$tanggal_awal = $this->input->get('tanggal_awal');
			$tanggal_akhir = $this->input->get('tanggal_akhir');

			// Jika ada input tanggal, konversi formatnya dari Y-m-d ke Ymd
			if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
				$tanggal_awal = str_replace('-', '', $tanggal_awal);  // Format Ymd
				$tanggal_akhir = str_replace('-', '', $tanggal_akhir); // Format Ymd
			} else {
				// Jika tidak ada input tanggal, ambil semua data tanpa filter tanggal
				$tanggal_awal = null;
				$tanggal_akhir = null;
			}

			// Panggil model dengan atau tanpa filter tanggal
			$data['sp_data'] = $this->Sp_model->get_data_sp($tanggal_awal, $tanggal_akhir);

			$this->load->view('users/header', $data);
			$this->load->view('users/sp/sp_data', $data);
			$this->load->view('users/footer');
		}
	}


	public function sp_lihat($nokontrak)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Sp_model');

			$data_sp = $this->Sp_model->get_data_sp_by_nokontrak($nokontrak);

			if ($data_sp) {
				$data['sp_data']    = $data_sp;
				$data['user']       = $this->Mcrud->get_users_by_un($ceks);
				$data['judul_web']  = "Detail Data SP | MelatiApp";

				$this->load->view('users/header', $data);
				$this->load->view('users/sp/sp_lihat', $data);
				$this->load->view('users/footer');
			} else {
				redirect('users/sp_data');
			}
		}
	}

	public function sp_print_SP1($nokontrak)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Sp_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "SP Print | MelatiApp";
			$data['sp_data'] = $this->Sp_model->get_data_sp_by_nokontrak($nokontrak);
			$data['logo'] = $this->Mcrud->get_setting_by_key('logo');

			// Memuat view untuk print
			$this->load->view('users/sp/sp_print_SP1', $data);
		}
	}

	public function sp_print_SP2($nokontrak)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Sp_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "SP Print | MelatiApp";
			$data['sp_data'] = $this->Sp_model->get_data_sp_by_nokontrak($nokontrak);
			$data['logo'] = $this->Mcrud->get_setting_by_key('logo');

			// Memuat view untuk print
			$this->load->view('users/sp/sp_print_SP2', $data);
		}
	}

	public function sp_print_SP3_SHM($nokontrak)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Sp_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "SP Print | MelatiApp";
			$data['sp_data'] = $this->Sp_model->get_data_sp_by_nokontrak($nokontrak);
			$data['logo'] = $this->Mcrud->get_setting_by_key('logo');

			// Memuat view untuk print
			$this->load->view('users/sp/sp_print_SP3_SHM', $data);
		}
	}

	public function sp_print_SP3_BPKB($nokontrak)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Sp_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "SP Print | MelatiApp";
			$data['sp_data'] = $this->Sp_model->get_data_sp_by_nokontrak($nokontrak);
			$data['logo'] = $this->Mcrud->get_setting_by_key('logo');

			// Memuat view untuk print
			$this->load->view('users/sp/sp_print_SP3_BPKB', $data);
		}
	}

	public function sp_tambah($nokontrak)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Sp_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Tambah Data SP | MelatiApp";
			$data['sp_data'] = $this->Sp_model->get_data_sp_by_nokontrak($nokontrak);
			$data['last_id'] = $this->db->select('MAX(id) as last_id')->get('tbl_sp')->row()->last_id ?? 0;

			$this->load->view('users/header', $data);
			$this->load->view('users/sp/sp_tambah');
			$this->load->view('users/footer');
		}
	}

	public function sp_tambah_manual()
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Sp_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Tambah Data SP Manual | MelatiApp";
			$data['last_id'] = $this->db->select('MAX(id) as last_id')->get('tbl_sp')->row()->last_id ?? 0;

			$this->load->view('users/header', $data);
			$this->load->view('users/sp/sp_tambah_manual');
			$this->load->view('users/footer');
		}
	}

	public function sp_simpan()
	{
		// Cek apakah pengguna sudah login
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Sp_model');

			if ($this->input->post()) {
				// Ambil data dari form
				$nomor_sp = $this->input->post('nomor_sp');
				$nokontrak = $this->input->post('nokontrak');
				$noakad = $this->input->post('noakad');
				$nama = $this->input->post('nama');
				$alamat = $this->input->post('alamat');
				$jnsdokumen = $this->input->post('jnsdokumen');
				$kdloc = $this->input->post('kdloc');
				$tglakad = $this->input->post('tglakad');
				$tglexp = $this->input->post('tglexp');
				$jenis_sp = $this->input->post('jenis_sp');
				$ttd = $this->input->post('ttd');
				$inpuser = $this->input->post('inpuser');


				// Set up array data
				$data = array(
					'nomor_sp'     => $this->input->post('nomor_sp', TRUE),
					'nokontrak'     => $this->input->post('nokontrak', TRUE),
					'noakad'       => $this->input->post('noakad', TRUE),
					'nama'         => $this->input->post('nama', TRUE),
					'alamat'       => $this->input->post('alamat', TRUE),
					'jnsdokumen'       => $this->input->post('jnsdokumen', TRUE),
					'kdloc'       => $this->input->post('kdloc', TRUE),
					'tglakad'      => $this->input->post('tglakad', TRUE),
					'tglexp'      => $this->input->post('tglexp', TRUE),
					'jenis_sp'     => $this->input->post('jenis_sp', TRUE),
					'ttd'          => $this->input->post('ttd', TRUE),
					'inpuser'          => $this->input->post('inpuser', TRUE)
				);

				// Simpan data ke database
				$this->Sp_model->sp_simpan($data);

				redirect('users/sp_data');
			} else {
				$this->load->view('users/sp/sp_data');
			}
		}
	}

	public function sp_edit($nokontrak)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		}

		$this->load->model('Sp_model');
		$data['user'] = $this->Mcrud->get_users_by_un($ceks);
		$data['judul_web'] = "Edit SP | MelatiApp";
		$data['sp_data'] = $this->Sp_model->get_sp_by_nokontrak($nokontrak);

		$this->load->view('users/header', $data);
		$this->load->view('users/sp/sp_edit', $data);
		$this->load->view('users/footer');
	}

	public function sp_update($nokontrak)
	{
		// Check if the user is logged in
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		} else {

			// Check if the form is submitted
			if ($this->input->post()) {

				$nomor_sp = $this->input->post('nomor_sp');
				$noakad = $this->input->post('noakad');
				$nama = $this->input->post('nama');
				$alamat = $this->input->post('alamat');
				$jnsdokumen = $this->input->post('jnsdokumen');
				$tglakad = $this->input->post('tglakad');
				$jenis_sp = $this->input->post('jenis_sp');
				$ttd = $this->input->post('ttd');
				$chuser = $this->input->post('chuser');
				$tanggal_ubah = $this->input->post('tanggal_ubah');

				// Set up array data
				$data = array(
					'nomor_sp'     => $this->input->post('nomor_sp', TRUE),
					'noakad'       => $this->input->post('noakad', TRUE),
					'nama'         => $this->input->post('nama', TRUE),
					'alamat'       => $this->input->post('alamat', TRUE),
					'jnsdokumen'       => $this->input->post('jnsdokumen', TRUE),
					'tglakad'      => $this->input->post('tglakad', TRUE),
					'jenis_sp'     => $this->input->post('jenis_sp', TRUE),
					'ttd'          => $this->input->post('ttd', TRUE),
					'chuser'       => $this->input->post('chuser', TRUE),
					'tanggal_ubah' => date('Y-m-d H:i:s')
				);


				$this->load->model('Sp_model');
				$this->Sp_model->sp_update_by_nokontrak($nokontrak, $data);

				redirect('users/sp_data');
			}
		}
	}

	public function sp_hapus($nokontrak)
	{
		$ceks = $this->session->userdata('user@mt');
		if (!isset($ceks)) {
			redirect('web/login');
		}

		$this->load->model('Sp_model');
		$this->Sp_model->sp_hapus_by_nokontrak($nokontrak);

		$this->session->set_flashdata('msg', '<div class="alert alert-success">Data SP berhasil dihapus.</div>');
		redirect('users/sp_data');
	}

	public function story_data()
	{
		$ceks = $this->session->userdata('user@mt');
		$id_user = $this->session->userdata('id_user@mt');

		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Story_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Story | MelatiApp";

			$data['stories'] = $this->Story_model->get_active_stories();

			// Load view untuk mengedit informasi
			$this->load->view('users/header', $data);
			$this->load->view('users/story/story_data', $data);
			$this->load->view('users/footer');
		}
	}

	public function story_tambah()
	{
		$ceks = $this->session->userdata('user@mt');
		$id_user = $this->session->userdata('id_user@mt');

		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Story_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Story Upload | MelatiApp";

			$this->load->view('users/header', $data);
			$this->load->view('users/story/story_tambah', $data);
			$this->load->view('users/footer');
		}
	}

	public function story_upload()
	{
		$this->load->model('Story_model');

		$id_user = $this->session->userdata('id_user');
		$caption = $this->input->post('caption');
		$type = $this->input->post('type');

		// Siapkan data dasar untuk disimpan ke dalam tabel
		$data = array(
			'id_user' => $id_user, // Sesuaikan ID user
			'caption' => $caption,
			'created_at' => date('Y-m-d H:i:s'),
			'expiry_at' => date('Y-m-d H:i:s', strtotime('+24 hours')) // Story expired in 24 hours
		);

		// Check if a file is selected
		if (!empty($_FILES['file_story']['name'])) {
			// Konfigurasi pengaturan upload file
			$config['upload_path'] = './stories/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif|mp4|webm';
			$config['max_size'] = 20048; // 20MB
			$this->load->library('upload');

			$this->upload->initialize($config);

			// Check if the file is successfully uploaded
			if (!$this->upload->do_upload('file_story')) {
				// Jika gagal upload, tampilkan error
				$error = $this->upload->display_errors();
				echo json_encode(['status' => 'error', 'message' => $error]); // Return error as JSON
				return; // Hentikan proses jika ada error
			} else {
				// Berhasil upload, ambil data file yang diupload
				$upload_data = $this->upload->data();
				$file_story_path = $upload_data['file_name'];

				// Tentukan tipe file berdasarkan ekstensi
				$file_type = $upload_data['file_ext'];

				// Simpan file path dan tipe (image atau video)
				$data['file_path'] = $file_story_path;
				if (in_array($file_type, ['.jpg', '.jpeg', '.png', '.gif'])) {
					$data['type'] = 'image';
				} else if ($file_type === '.mp4') {
					$data['type'] = 'video';
				}
			}
		} else {
			// Jika tidak ada file yang diupload, tampilkan error atau logika lain
			echo json_encode(['status' => 'error', 'message' => 'No file selected!']); // Return error as JSON
			return; // Hentikan proses jika tidak ada file
		}

		// Simpan data ke dalam tabel
		$this->db->insert('tbl_story', $data);

		// Return success response as JSON
		echo json_encode(['status' => 'success', 'message' => 'Story uploaded successfully!']);
		redirect('users/story_data');
	}

	public function mark_viewed()
	{
		// Retrieve the posted data
		$storyId = $this->input->post('storyId');
		$viewerId = $this->input->post('viewerId');

		// Validate the input data
		if (!$storyId || !$viewerId) {
			echo json_encode(['status' => 'error', 'message' => 'Invalid input: storyId or viewerId is missing.']);
			return;
		}

		// Call the model function to mark the story as viewed
		$result = $this->Story_model->markAsViewed($storyId, $viewerId);

		// Respond with success or failure
		if ($result) {
			echo json_encode(['status' => 'success', 'views_count' => $result['views_count'], 'viewed_by' => $result['viewed_by']]);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Failed to mark the story as viewed']);
		}
	}

	public function delete_story()
	{
		$storyId = $this->input->post('storyId');

		// Pastikan story yang dihapus milik user yang sedang login
		$this->db->where('id_story', $storyId);
		$story = $this->db->get('tbl_story')->row();

		if ($story && $story->id_user == $this->session->userdata('id_user')) {
			// Hapus file story dari direktori
			$file_path = FCPATH . 'stories/' . $story->file_path;
			if (file_exists($file_path)) {
				unlink($file_path);
			}

			// Hapus story dari database
			$this->db->where('id_story', $storyId);
			$this->db->delete('tbl_story');

			$response = ['status' => 'success'];
		} else {
			$response = ['status' => 'error', 'message' => 'You are not authorized to delete this story.'];
		}

		echo json_encode($response);
	}

	public function delete_all_stories()
	{
		// Ensure the user is logged in
		$userId = $this->session->userdata('id_user');

		// Call the model method to delete all stories for the user
		$deletedCount = $this->Story_model->delete_all_stories_by_user($userId);

		if ($deletedCount > 0) {
			$response = ['status' => 'success', 'message' => 'All stories have been deleted.'];
		} else {
			$response = ['status' => 'error', 'message' => 'No stories found for this user.'];
		}

		echo json_encode($response);
	}

	public function chat_data()
	{
		$ceks = $this->session->userdata('user@mt');
		$id_user = $this->session->userdata('id_user@mt');

		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			$this->load->model('Chat_model');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks);
			$data['judul_web'] = "Chat | MelatiApp";
			$data['conversations'] = $this->Chat_model->get_conversations($id_user);
			$data['unread_count'] = $this->Chat_model->count_unread_messages($id_user);

			$this->load->model('Mcrud');
			$data['user_list'] = $this->Mcrud->get_all_users_aktif_except($id_user);

			$this->load->view('users/header', $data);
			$this->load->view('users/chat/chat_data', $data);
			$this->load->view('users/footer');
		}
	}

	// View conversation with a specific user
	public function chat_conversation($user_id)
	{
		$ceks = $this->session->userdata('user@mt');
		$id_user = $this->session->userdata('id_user@mt');

		if (!isset($ceks)) {
			redirect('web/login');
		} else {
			// Validate user_id
			if (!is_numeric($user_id)) {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger">Invalid user ID.</div>');
				redirect('chat');
			}

			// Check if the user exists
			$this->load->model('User_model');
			$other_user = $this->User_model->get_user_by_id($user_id);
			if (!$other_user) {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger">User not found.</div>');
				redirect('chat');
			}

			// Mark messages as read
			$this->load->model('Chat_model');
			$this->Chat_model->mark_as_read($id_user, $user_id);

			// Load user data
			$this->load->model('Mcrud');
			$data['user'] = $this->Mcrud->get_users_by_un($ceks); // Assuming this gets the current user's data
			if (empty($data['user'])) {
				show_error('User not found', 500);
			}

			$data['judul_web'] = "Chat with " . $other_user->nama_lengkap . " | MelatiApp";
			$data['other_user'] = $other_user;
			$data['messages'] = $this->Chat_model->get_messages($id_user, $user_id);
			$data['conversations'] = $this->Chat_model->get_conversations($id_user);

			// Load views
			$this->load->view('users/header', $data);
			$this->load->view('users/chat/chat_conversation', $data);
			$this->load->view('users/footer');
		}
	}

	// Send a message (AJAX)
	public function chat_send()
	{
		// Check if this is an AJAX request
		if (!$this->input->is_ajax_request()) {
			show_404();
		}

		$id_user = $this->session->userdata('id_user@mt');
		$receiver_id = $this->input->post('receiver_id');
		$message = $this->input->post('message');

		// Validate inputs
		if (!$receiver_id || !$message) {
			echo json_encode(['status' => false, 'msg' => 'Invalid input data.']);
			return;
		}

		$this->load->model('Chat_model');

		// Check if attachment exists
		$attachment = null;
		if (!empty($_FILES['attachment']['name'])) {
			$upload_result = $this->Chat_model->upload_attachment($_FILES);
			if ($upload_result['status']) {
				$attachment = $upload_result['data']['file_name'];
			} else {
				echo json_encode(['status' => false, 'msg' => $upload_result['error']]);
				return;
			}
		}

		// Prepare data
		$chat_data = [
			'id_user' => $id_user,
			'receiver_id' => $receiver_id,
			'message' => $message,
			'attachment' => $attachment,
			'is_read' => 0
		];

		// Save message
		$message_id = $this->Chat_model->send_message($chat_data);

		if ($message_id) {
			// Get the message with sender details
			$message = $this->Chat_model->get_message_by_id($message_id);

			echo json_encode([
				'status' => true,
				'msg' => 'Message sent successfully.',
				'message' => $message
			]);
		} else {
			echo json_encode(['status' => false, 'msg' => 'Failed to send message.']);
		}
	}

	// Delete a message (AJAX)
	public function chat_delete()
	{
		// Check authentication
		$ceks = $this->session->userdata('user@mt');
		$id_user = $this->session->userdata('id_user@mt');

		if (!isset($ceks)) {
			// For AJAX requests, we should return JSON instead of redirecting
			if ($this->input->is_ajax_request()) {
				echo json_encode([
					'status' => false,
					'msg' => 'Session expired. Please login again.'
				]);
				return;
			} else {
				redirect('web/login');
			}
		}

		// Check if this is an AJAX request
		if (!$this->input->is_ajax_request()) {
			show_404();
			return;
		}

		$message_id = $this->input->post('message_id');

		// Validate input
		if (!$message_id || !is_numeric($message_id)) {
			echo json_encode(['status' => false, 'msg' => 'Invalid message ID.']);
			return;
		}

		// Load model if not already loaded
		if (!isset($this->Chat_model)) {
			$this->load->model('Chat_model');
		}

		try {
			// Delete message
			$result = $this->Chat_model->delete_message($message_id, $id_user);

			if ($result) {
				echo json_encode(['status' => true, 'msg' => 'Message deleted successfully.']);
			} else {
				echo json_encode(['status' => false, 'msg' => 'Failed to delete message.']);
			}
		} catch (Exception $e) {
			// Log the error
			log_message('error', 'Delete message error: ' . $e->getMessage());

			echo json_encode([
				'status' => false,
				'msg' => 'An error occurred while deleting the message.'
			]);
		}
	}

	public function chat_clear()
	{
		// Check authentication
		$ceks = $this->session->userdata('user@mt');
		$id_user = $this->session->userdata('id_user@mt');

		if (!isset($ceks)) {
			// For AJAX requests, return JSON instead of redirecting
			if ($this->input->is_ajax_request()) {
				echo json_encode([
					'status' => false,
					'msg' => 'Session expired. Please login again.'
				]);
				return;
			} else {
				redirect('web/login');
			}
		}

		// Check if this is an AJAX request
		if (!$this->input->is_ajax_request()) {
			show_404();
			return;
		}

		$other_user_id = $this->input->post('other_user_id');

		// Validate input
		if (!$other_user_id || !is_numeric($other_user_id)) {
			echo json_encode(['status' => false, 'msg' => 'Invalid user ID.']);
			return;
		}

		// Load model if not already loaded
		if (!isset($this->Chat_model)) {
			$this->load->model('Chat_model');
		}

		try {
			// Clear all messages between these two users
			$result = $this->Chat_model->clear_conversation($id_user, $other_user_id);

			if ($result) {
				echo json_encode(['status' => true, 'msg' => 'Chat cleared successfully.']);
			} else {
				echo json_encode(['status' => false, 'msg' => 'Failed to clear chat.']);
			}
		} catch (Exception $e) {
			// Log the error
			log_message('error', 'Clear chat error: ' . $e->getMessage());

			echo json_encode([
				'status' => false,
				'msg' => 'An error occurred while clearing the chat.'
			]);
		}
	}

	// Get new messages (AJAX for polling)
	public function check_new_messages()
	{
		// Check authentication
		$ceks = $this->session->userdata('user@mt');
		$id_user = $this->session->userdata('id_user@mt');

		if (!isset($ceks)) {
			// For AJAX requests, we should return JSON instead of redirecting
			if ($this->input->is_ajax_request()) {
				echo json_encode([
					'status' => false,
					'msg' => 'Session expired. Please login again.'
				]);
				return;
			} else {
				redirect('web/login');
			}
		}

		// Check if this is an AJAX request
		if (!$this->input->is_ajax_request()) {
			show_404();
			return;
		}

		// Load model
		$this->load->model('Chat_model');

		// Get parameters
		$last_message_time = $this->input->post('last_message_time');
		$other_user_id = $this->input->post('other_user_id');

		// Add validation for other_user_id
		if ($other_user_id && !is_numeric($other_user_id)) {
			echo json_encode([
				'status' => false,
				'msg' => 'Invalid user ID'
			]);
			return;
		}

		// If we're in a conversation, check for messages from that user
		if ($other_user_id) {
			try {
				$this->db->select('c.*, u.nama_lengkap as sender_name, u.level as sender_level, u.foto_profile as sender_photo');
				$this->db->from("tbl_chat as c");
				$this->db->join('tbl_user as u', 'u.id_user = c.id_user');
				$this->db->where('c.id_user', $other_user_id);
				$this->db->where('c.receiver_id', $id_user);
				$this->db->where('c.status', 'active');

				if ($last_message_time) {
					$this->db->where('c.created_at >', $last_message_time);
				}

				$this->db->order_by('c.created_at', 'ASC');
				$new_messages = $this->db->get()->result();

				if (!empty($new_messages)) {
					// Mark messages as read
					$this->Chat_model->mark_as_read($id_user, $other_user_id);
				}

				echo json_encode([
					'status' => true,
					'new_messages' => $new_messages,
					'unread_count' => $this->Chat_model->count_unread_messages($id_user)
				]);
			} catch (Exception $e) {
				// Log the error
				log_message('error', 'Chat error: ' . $e->getMessage());

				echo json_encode([
					'status' => false,
					'msg' => 'An error occurred while retrieving messages.'
				]);
			}
		} else {
			// Just return unread count for the badge
			echo json_encode([
				'status' => true,
				'unread_count' => $this->Chat_model->count_unread_messages($id_user)
			]);
		}
	}

	public function get_conversations_html()
	{
		$id_user = $this->session->userdata('id_user@mt');
		$this->load->model('Chat_model');
		$data['conversations'] = $this->Chat_model->get_conversations($id_user); // Pastikan method ini sudah ada
		$this->load->view('users/chat/_conversation_list', $data);
	}

	// Search messages
	public function chat_search()
	{
		// Check authentication
		$ceks = $this->session->userdata('user@mt');
		$id_user = $this->session->userdata('id_user@mt');

		if (!isset($ceks)) {
			redirect('web/login');
			return;
		}

		// Load model if not already loaded
		if (!isset($this->Chat_model)) {
			$this->load->model('Chat_model');
		}

		$keyword = $this->input->get('keyword');

		// Validate keyword
		if (!$keyword || strlen(trim($keyword)) < 1) {
			$this->session->set_flashdata('error', 'Please enter a valid search term.');
			redirect('chat');
			return;
		}

		try {
			$data['user'] = $this->user_data;
			$data['judul_web'] = "Search Results | MelatiApp";
			$data['search_results'] = $this->Chat_model->search_messages($id_user, $keyword);
			$data['keyword'] = htmlspecialchars($keyword);
			$data['unread_count'] = $this->Chat_model->count_unread_messages($id_user);

			$this->load->view('users/header', $data);
			$this->load->view('users/chat/chat_search', $data);
			$this->load->view('users/footer');
		} catch (Exception $e) {
			// Log the error
			log_message('error', 'Chat search error: ' . $e->getMessage());

			$this->session->set_flashdata('error', 'An error occurred while searching messages.');
			redirect('chat');
		}
	}

	public function delete_all_chats()
	{
		$ceks = $this->session->userdata('user@mt');
		$id_user = $this->session->userdata('id_user@mt');

		if (!isset($ceks)) {
			redirect('web/login');
		}

		$this->load->model('Chat_model');
		$result = $this->Chat_model->delete_all_conversations($id_user);

		if ($result) {
			$this->session->set_flashdata('msg', '<div class="alert alert-success">All conversations have been deleted.</div>');
		} else {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger">Failed to delete conversations.</div>');
		}

		redirect('users/chat_data');
	}
}

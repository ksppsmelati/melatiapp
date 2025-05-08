<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Template extends CI_Controller
{
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
			if ($id_user === "0") {
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
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Web extends CI_Controller {

	public function index()
	{
		$ceks = $this->session->userdata('surat_menyurat@Proyek-2023');
		if(!isset($ceks)) {
			redirect('web/login');
		}else{
					redirect('users');
		}
	}

public function login()
{
    $ceks = $this->session->userdata('surat_menyurat@Proyek-2023');
    if (isset($ceks)) {
        $this->load->view('404_content');
    } else {
        $this->load->view('web/header');
        $this->load->view('web/login');
        
        if (isset($_POST['btnlogin'])) {
            $username = htmlentities(strip_tags($_POST['username']));
            $pass     = htmlentities(strip_tags(md5($_POST['password'])));
            
            
            // Mengambil nilai latitude dan longitude dari input tersembunyi
            $latitude = $this->input->post('latitude');
            $longitude = $this->input->post('longitude');
            
            // Memeriksa apakah pengguna sudah online
            $user_data = $this->Mcrud->get_users_by_un($username)->row();
            if ($user_data->online_status !== '1') {
                // Hanya ubah status jika tidak sedang online
                $data = array(
                    'online_status' => '1',
                );
                $this->Mcrud->update_user(array('username' => $username), $data);
            }
            
            // Memperbarui lokasi pengguna ke dalam database
            $this->load->model('User_model');
            $user_id = $this->session->userdata('id_user@Proyek-2023');
            $this->User_model->updateLocation($user_id, $latitude, $longitude);
            
            // Set lokasi dalam sesi untuk digunakan di tempat lain dalam aplikasi
            $this->session->set_userdata('latitude', $latitude);
            $this->session->set_userdata('longitude', $longitude);
            
            // Memperbarui device info pengguna ke dalam database
            $device_info = $this->input->post('device_info'); // Ambil device info dari input tersembunyi
            $this->User_model->updateDeviceInfo($user_id, $device_info);
            

            $this->session->set_userdata('login_success', true);
            $query  = $this->Mcrud->get_users_by_un($username);
            $cek    = $query->result();
            $cekun  = $cek[0]->username;
            $jumlah = $query->num_rows();
            
            if ($jumlah == 0) {
                $this->session->set_flashdata('msg',
                    '<div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;&nbsp;</span>
                        </button>
                        <strong>Username "' . $username . '"</strong> belum terdaftar.
                    </div>'
                );
                redirect('web/login');
            } else {
                $row = $query->row();
                $cekpass = $row->password;
                if ($cekpass <> $pass) {
                    $this->session->set_flashdata('msg',
                        '<div class="alert alert-warning alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;&nbsp;</span>
                            </button>
                            <strong>Username atau Password Salah!</strong>.
                        </div>'
                    );
                    redirect('web/login');
                } else {
                    $this->session->set_userdata('surat_menyurat@Proyek-2023', "$cekun");
                    $this->session->set_userdata('id_user@Proyek-2023', "$row->id_user");
                    $this->session->set_userdata('id_user', $row->id_user);
                    $this->session->set_userdata('username', $row->username);
                    $this->session->set_userdata('nama_lengkap', $row->nama_lengkap);
                    $this->session->set_userdata('level', $row->level);
                    $this->session->set_userdata('status', $row->status);
                    
                    // Memperbarui lokasi pengguna ke dalam database
                    $this->load->model('User_model');
                    $user_id = $this->session->userdata('id_user@Proyek-2023');
                    $this->User_model->updateLocation($user_id, $latitude, $longitude);
                    
                    // Set lokasi dalam sesi untuk digunakan di tempat lain dalam aplikasi
                    $this->session->set_userdata('latitude', $latitude);
                    $this->session->set_userdata('longitude', $longitude);
                    
                    // Memperbarui device info pengguna ke dalam database
                    $this->User_model->updateDeviceInfo($user_id, $device_info);
                    
                    date_default_timezone_set('Asia/Jakarta');
                    $tgl = date('d-m-Y H:i:s');
                    $data = array(
                        'terakhir_login' => $tgl,
                    );
                    $this->Mcrud->update_user(array('username' => $username), $data);
                    redirect('web');
                }
            }
        }
    }
}



	public function logout() {
     if ($this->session->has_userdata('surat_menyurat@Proyek-2023') and $this->session->has_userdata('id_user@Proyek-2023')) {           // Mendapatkan username pengguna yang sedang logout
        $username = $this->session->userdata('surat_menyurat@Proyek-2023');

        // Mengatur online_status menjadi "0" (offline) saat logout
        $data = array(
            'online_status' => '0',
        );
        $this->Mcrud->update_user(array('username' => $username), $data);

         $this->session->sess_destroy();
         redirect('');
     }
		 redirect('');
  }

  public function daftar()
  {
      $this->load->library('form_validation');
      $this->load->model('Mcrud');
  
      // Load view sebelum validasi
      $this->load->view('web/header');
  
      $this->form_validation->set_rules('username', 'Username', 'required|trim');
      $this->form_validation->set_rules('password', 'Password', 'required');
      $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required'); // Tambahkan aturan validasi untuk jenis kelamin
  
      if ($this->form_validation->run() === TRUE) {
          $username = htmlentities(strip_tags($this->input->post('username')));
          $password = md5($this->input->post('password'));
          $jenis_kelamin = $this->input->post('jenis_kelamin'); // Ambil nilai jenis kelamin dari formulir
  
          // Periksa apakah username sudah ada
          if ($this->Mcrud->is_username_exists($username)) {
              // Username sudah ada, set the error message
              $data['msg_error'] = 'Username sudah digunakan.';
          } else {
              // Data yang akan disimpan ke database
              $user_data = array(
                  'username' => $username,
                  'jenis_kelamin' => $jenis_kelamin,
                  'password' => $password,
                  // Isi kolom lainnya sesuai kebutuhan
              );
  
              // Panggil model untuk menyimpan data pengguna
              $user_id = $this->Mcrud->save_user($user_data);
  
              if ($user_id) {
                  // Pengguna berhasil ditambahkan, set the success message
                  $data['msg_success'] = 'Pengguna berhasil ditambahkan.';
                  // Anda juga dapat menambahkan pengalihan di sini jika diperlukan
                  $data['redirect'] = true; // Setel flag untuk memicu pengalihan di tampilan
              } else {
                  // Gagal menambahkan pengguna, set the error message
                  $data['msg_error'] = 'Gagal menambahkan pengguna.';
              }
          }
      } else {
          // Validasi form gagal, kirimkan pesan validasi ke tampilan
          $data['msg_error'] = validation_errors();
      }
  
      // Load the view with the updated data
      $this->load->view('web/daftar', $data);
  }
  

	public function lupa_password()
	{
		$ceks = $this->session->userdata('surat_menyurat@Proyek-2023');
		if(isset($ceks)) {
			$this->load->view('404_content');
		}else{
			$this->load->view('web/header');
			$this->load->view('web/lupa_password');
			$this->load->view('web/footer');

			if (isset($_POST['btnkirim'])){
				$email = htmlentities(strip_tags($_POST['email']));

				date_default_timezone_set('Asia/Jakarta');
				$tgl	 = date('d-m-Y');

				$cek_id = md5("$email * $tgl");

				$cek_mail  = $this->db->get_where('tbl_user', array('email' => $email));

				if ($cek_mail->num_rows() == 0) {

						$this->session->set_flashdata('msg',
							'
							<div class="alert alert-warning alert-dismissible" role="alert">
								 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
									 <span aria-hidden="true">&times;&nbsp;</span>
								 </button>
								 <strong>Gagal!</strong> Email "'.$email.'" belum terdaftar.
							</div>'
						);
						redirect('web/lupa_password');
				}else{

						$this->Mcrud->sent_mail($cek_mail->row()->username,$email,'lp');

						if ($this->email->send()){

							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-success alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp;</span>
									 </button>
										 <strong>Sukses!</strong> Cek email untuk membuat password baru.
								</div>'
							);
						}else{
							$this->session->set_flashdata('msg',
								'
								<div class="alert alert-warning alert-dismissible" role="alert">
									 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
										 <span aria-hidden="true">&times;&nbsp;</span>
									 </button>
										 <strong>Gagal!</strong> Ada kesalahan, silahkan cek koneksi lalu segarkan browser dan coba lagi.
								</div>'
							);
						}
						redirect('web/login');

				}

			}

		}
	}

	public function konfirm_pass($id='',$un='') {
		date_default_timezone_set('Asia/Jakarta');
		$tgl	 = date('d-m-Y');

     if ($id != '' or $un != '') {

			 $cek_un  = $this->db->get_where('tbl_user', array('username' => $un));

			 if ($cek_un->num_rows() == 0) {
					 $this->session->set_flashdata('msg',
						'
						<div class="alert alert-warning alert-dismissible" role="alert">
							 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
								 <span aria-hidden="true">&times;&nbsp;</span>
							 </button>
								<strong>Gagal!</strong> Data user tidak ditemukan.</a>
						</div>'
					);
					redirect('web/login');
			 }

			 $email  = $cek_un->row()->email;

			 $cek_id = md5("$email * $tgl");
			 if ($id == $cek_id) {

					 $this->load->view('web/header');
					 $this->load->view('web/reset_pass');
					 $this->load->view('web/footer');

		 				if (isset($_POST['btnkirim'])) {
		 						$pass  			= htmlentities(strip_tags($this->input->post('password')));
								$pass2 			= htmlentities(strip_tags($this->input->post('password2')));

								if ($pass == $pass2) {
										$data = array(
											'password'		=> md5($pass),
											);
										$this->Mcrud->update_user(array('username' => $un), $data);
										$this->session->set_flashdata('msg',
											'
											<div class="alert alert-success alert-dismissible" role="alert">
					 							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					 								<span aria-hidden="true">&times;&nbsp;</span>
					 							</button>
													<strong>Sukses!</strong> Password berhasil diperbarui.
											</div>'
										);
										redirect('web/login');
								}else{
									$this->session->set_flashdata('msg',
										'
										<div class="alert alert-warning alert-dismissible" role="alert">
				 							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				 								<span aria-hidden="true">&times;&nbsp;</span>
				 							</button>
												<strong>Gagal!</strong> Password Baru dan Ulangi Password Baru tidak cocok, silahkan coba lagi.
										</div>'
									);
								}

								redirect('web/konfirm_pass/'.$id.'/'.$un.'');
						}

			 }else{

				 $this->session->set_flashdata('msg',
					 '
					 <div class="alert alert-warning alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;&nbsp;</span>
							</button>
							 <strong>Gagal!</strong> Ubah Password baru kadaluarsa.</a>
					 </div>'
				 );
			 }
     }else{
		 	redirect('web/login');
		 }
  }


	function error_not_found(){
		$this->load->view('404_content');
	}
	

}

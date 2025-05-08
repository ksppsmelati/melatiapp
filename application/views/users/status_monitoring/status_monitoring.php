<?php
$cek = $user->row();
$nama_lengkap = $cek->nama_lengkap;
$level = $cek->level;
$kantorNames = [
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
?>
<style>
  .loader {
    width: 2px;
    /* Further reduced width */
    height: 4px;
    /* Further reduced height */
    border-radius: 1px;
    /* Reduced border-radius for smaller size */
    display: inline-block;
    margin: 0 2px;
    /* Adjusted margin for smaller size */
    position: relative;
    background: #FFF;
    /* White color */
    box-sizing: border-box;
    animation: animloader 0.3s 0.3s linear infinite alternate;
  }

  .loader::after,
  .loader::before {
    content: '';
    width: 2px;
    /* Further reduced width */
    height: 4px;
    /* Further reduced height */
    border-radius: 1px;
    /* Reduced border-radius for smaller size */
    background: #FFF;
    /* White color */
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    left: 6px;
    /* Adjusted positioning for smaller size */
    box-sizing: border-box;
    animation: animloader 0.3s 0.45s linear infinite alternate;
  }

  .loader::before {
    left: -6px;
    /* Adjusted positioning for smaller size */
    animation-delay: 0s;
  }

  @keyframes animloader {
    0% {
      height: 6px;
    }

    /* Adjusted height for animation start */
    100% {
      height: 1px;
    }

    /* Adjusted height for animation end */
  }

  /* Foto */
  .custom-popup-content {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 100%;
  }

  .popup-image-container {
    max-width: 100%;
    max-height: 100%;
    width: auto;
    height: auto;
  }

  .popup-image {
    max-width: 100%;
    max-height: 100%;
    width: auto;
    height: auto;
  }

  /* Custom styles for the popup */
  .custom-popup-content {
    padding: 0;
    /* Remove padding */
    background: none;
    /* Remove background */
    box-shadow: none;
    /* Remove box-shadow */
  }

  /* Custom styles for the close button */
  .custom-popup-close-button {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 40px;
    color: #fff;
    /* Change color if needed */
    cursor: pointer;
    background: transparent;
    border: none;
  }

  .gambar {
    width: 30px;
    /* Set the width of the thumbnail */
    height: 30px;
    /* Set the height of the thumbnail */
    object-fit: cover;
    /* Ensure the image covers the area and maintains aspect ratio */
    display: block;
    /* padding: 3px; */
    /* margin-bottom: 20px; */
    line-height: 1.5384616;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 3px;
    -webkit-transition: border .2s ease-in-out;
    -o-transition: border .2s ease-in-out;
    transition: border .2s ease-in-out;
  }
</style>
<div class="container">
  <!-- Content area -->
  <div class="content">
    <!-- Dashboard content -->
    <div class="row">
      <div class="col-md-12">
        <?php
        echo $this->session->flashdata('msg');
        ?>
        <div class="row">
          <!-- Box 1 -->
          <div class="col-12 col-sm-3 col-xs-6">
            <div class="panel panel-flat" onclick="window.location.href='<?php echo site_url('users/data_blokir'); ?>';" style="cursor: pointer;">
              <div class="panel-body text-center">
                <div class="text-center">
                  <a href="<?php echo site_url('users/data_blokir'); ?>" class="btn btn-danger" style="width: 100px;">
                    <b><?php echo $proses_count; ?></b>
                    <p>
                      <?php if ($proses_count > 0) : ?>
                        <span class="loader"></span>
                      <?php else : ?>
                        Kosong
                      <?php endif; ?>
                    </p>
                  </a>
                  <a href="<?php echo site_url('users/data_blokir'); ?>" class="btn btn-success" style="width: 100px;  margin: 3px;">
                    <b><?php echo $done_count; ?></b>
                    <p>Selesai</p>
                  </a>
                </div>
                <hr>
                <span class="text-warning"><i class="fa fa-lock"></i> Blokir</span>
                <p class="text-muted">Semua Data</p>
              </div>
            </div>
          </div>

          <!-- Box 2 -->
          <div class="col-12 col-sm-3 col-xs-6">
            <div class="panel panel-flat" onclick="window.location.href='<?php echo site_url('users/data_kerusakan'); ?>';" style="cursor: pointer;">
              <div class="panel-body text-center">
                <div class="text-center">
                  <a href="<?php echo site_url('users/data_kerusakan'); ?>" class="btn btn-danger" style="width: 100px; ">
                    <b><?php echo $empty_tindakan_count; ?></b>
                    <p>
                      <?php if ($empty_tindakan_count > 0) : ?>
                        <span class="loader"></span>
                      <?php else : ?>
                        Kosong
                      <?php endif; ?>
                    </p>
                  </a>
                  <a href="<?php echo site_url('users/data_kerusakan'); ?>" class="btn btn-success" style="width: 100px; margin: 3px;">
                    <b><?php echo $filled_tindakan_count; ?></b>
                    <p>Selesai</p>
                  </a>
                </div>
                <hr>
                <span class="text-danger"><i class="icon-warning2"></i> Kerusakan</span>
                <p class="text-muted">Semua Data</p>
              </div>
            </div>
          </div>
          <!-- Box 3 -->
          <div class="col-12 col-sm-3 col-xs-6">
            <div class="panel panel-flat" onclick="window.location.href='<?php echo site_url('users/sm'); ?>';" style="cursor: pointer;">
              <div class="panel-body text-center">
                <div class="text-center">
                  <a href="<?php echo site_url('users/sm'); ?>" class="btn btn-danger" style="width: 100px;">
                    <b><?php echo $belum_otorisasi_count; ?></b>
                    <p>
                      <?php if ($belum_otorisasi_count > 0) : ?>
                        <span class="loader"></span>
                      <?php else : ?>
                        Kosong
                      <?php endif; ?>
                    </p>
                  </a>
                  <a href="<?php echo site_url('users/ss'); ?>" class="btn btn-success" style="width: 100px; margin: 3px;">
                    <b><?php echo $sudah_otorisasi_count; ?></b>
                    <p>Selesai</p>
                  </a>
                </div>
                <hr>
                <span class="text-info"><i class="fa fa-inbox"></i> Otorisasi</span>
                <p class="text-muted"><?php echo date('d M Y'); ?></p>
              </div>
            </div>
          </div>
          <!-- Box 4 -->
          <div class="col-12 col-sm-3 col-xs-6">
            <div class="panel panel-flat" onclick="window.location.href='<?php echo site_url('users/kritik_saran_data'); ?>';" style="cursor: pointer;">
              <div class="panel-body text-center">
                <div class="text-center d-flex justify-content-center">
                  <!-- Tombol Kritik Saran Belum Direspond -->
                  <a href="<?php echo site_url('users/kritik_saran_data'); ?>" class="btn btn-danger mx-2" style="width: 100px;">
                    <b><?php echo $kritik_saran_belum_direspond_count; ?></b>
                    <p>
                      <?php if ($kritik_saran_belum_direspond_count > 0) : ?>
                        <span class="loader"></span>
                      <?php else : ?>
                        Kosong
                      <?php endif; ?>
                    </p>
                  </a>

                  <!-- Tombol Kritik Saran Sudah Direspond -->
                  <a href="<?php echo site_url('users/kritik_saran_data'); ?>" class="btn btn-success mx-2" style="width: 100px; margin: 3px;">
                    <b><?php echo $kritik_saran_sudah_direspond_count; ?></b>
                    <p>Direspond</p>
                  </a>
                </div>
                <hr>
                <span class="text-warning"><i class="fa fa-comments"></i> Kritik & Saran</span>
                <p class="text-muted">Semua Data</p>
              </div>
            </div>
          </div>


          <!-- Box 5 -->
          <div class="col-12 col-sm-3 col-xs-6">
            <div class="panel panel-flat" onclick="window.location.href='<?php echo site_url('users/agunan_shm'); ?>';" style="cursor: pointer;">
              <div class="panel-body text-center">
                <div class="text-center">
                  <a href="<?php echo site_url('users/agunan'); ?>" class="btn" style="width: 100px; background-color: #009688; color: #FFF;">
                    <b><?php echo $agunan_count; ?></b>
                    <p>BPKB</p>
                  </a>

                  <a href="<?php echo site_url('users/agunan_shm'); ?>" class="btn" style="width: 100px; background-color: #8BC34A; color: #FFF; margin: 3px;">
                    <b><?php echo $agunan_shm_count; ?></b>
                    <p>SHM</p>
                  </a>

                </div>
                <hr>
                <span class="text-light"><i class="fa fa-archive"></i> Agunan</span>
                <p class="text-muted">Semua Data</p>
              </div>
            </div>
          </div>

          <!-- Box 6 -->
          <div class="col-12 col-sm-3 col-xs-6">
            <div class="panel panel-flat">
              <div class="panel-body text-center" onclick="window.location.href='<?php echo site_url('users/agunan_data_proses'); ?>';" style="cursor: pointer;">
                <div class="text-center">
                  <a href="<?php echo site_url('users/agunan_data_proses'); ?>" class="btn" style="width: 100px; background-color: #E91E63; color: #FFF;">
                    <b><?php echo $agunan_dipesan_count; ?></b>
                    <p>BPKB Dipesan</p>
                  </a>
                  <a href="<?php echo site_url('users/agunan_data_proses'); ?>" class="btn" style="width: 100px; background-color: #9C27B0; color: #FFF; margin: 3px;">
                    <b><?php echo $agunan_shm_dipesan_count; ?></b>
                    <p>SHM Dipesan</p>
                  </a>
                </div>
                <hr>
                <span class="text-primary"><i class="fa fa-shopping-cart"></i> Pesanan Agunan</span>
                <p class="text-muted">Semua Data</p>
              </div>
            </div>
          </div>

          <!-- Box 7 -->
          <div class="col-12 col-sm-3 col-xs-6">
            <div class="panel panel-flat" onclick="window.location.href='<?php echo site_url('users/monitoring_by_range_tgl'); ?>';" style="cursor: pointer;">
              <div class="panel-body text-center">
                <div class="text-center">
                  <a href="<?php echo site_url('users/monitoring_by_range_tgl'); ?>" class="btn" style="width: 100%; background-color: #3F51B5; color: #FFF;">
                    <b><?php echo $monitoring_count; ?></b>
                    <p>Jml Monitoring</p>
                  </a>

                </div>
                <hr>
                <span class="text-warning"><i class="fa fa-television"></i> Monitoring</span>
                <p class="text-muted"><?php echo date('d M Y'); ?></p>
              </div>
            </div>
          </div>

          <!-- Box 8 -->
          <div class="col-12 col-sm-3 col-xs-6">
            <div class="panel panel-flat">
              <div class="panel-body text-center">
                <div class="text-center">
                  <div class="btn" style="width: 100px; background-color: #0652DD; color: #FFF; cursor: default;">
                    <b><?php echo number_format($tabungan_count, 0, ',', '.'); ?></b>
                    <p>DB Tabungan</p>
                  </div>

                  <div class="btn" style="width: 100px; background-color: #B53471; color: #FFF; margin: 3px; cursor: default;">
                    <b><?php echo number_format($tofjamin_count, 0, ',', '.'); ?></b>
                    <p>DB Jaminan</p>
                  </div>

                </div>
                <hr>
                <a href="<?php echo site_url('users/#'); ?>">
                  <span class="text-light"><i class="fa fa-archive"></i> Database</span>
                </a>

                <p class="text-muted">Semua Data</p>
              </div>
            </div>
          </div>

        </div>

        <div class="row">
          <div class="panel panel-flat">
            <div class="panel-body">
              <div class="navigation-buttons">
                <div class="btn-group" style="float: left;">
                  <i class="fa fa-id-card"></i> DATA ABSEN TIDAK SESUAI
                </div>
              </div>
              <div class="clearfix"></div>
            </div>
            <div class="table-responsive">
              <table class="table datatable-basic" width="100%">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Tanggal</th>
                    <th>Jam Masuk</th>
                    <th>Jam Pulang</th>
                    <th>Jam Izin</th>
                    <th>Jam Cuti</th>
                    <th>Jam Sakit</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($absensi_tidak_sesuai)) : ?>
                    <?php foreach ($absensi_tidak_sesuai as $absensi) : ?>
                      <tr>
                        <td><?php echo $absensi->id_user; ?></td>
                        <td><?php echo $absensi->nama_lengkap; ?></td>
                        <td><?php echo $absensi->tanggal; ?></td>
                        <td><?php echo $absensi->jam_masuk; ?></td>
                        <td><?php echo $absensi->jam_pulang; ?></td>
                        <td><?php echo $absensi->jam_izin; ?></td>
                        <td><?php echo $absensi->jam_cuti; ?></td>
                        <td><?php echo $absensi->jam_sakit; ?></td>
                        <td><?php echo $absensi->status_lengkap; ?></td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else : ?>
                    <!--  -->
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="panel panel-flat">
            <div class="panel-body">
              <div class="navigation-buttons">
                <div class="btn-group" style="float: left;">
                  <i class="fa-solid fa-clipboard-list"></i> DATA USULAN DOUBLE
                </div>
              </div>
              <div class="clearfix"></div>
            </div>
            <div class="table-responsive">
              <table class="table datatable-basic" width="100%">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Nik</th>
                    <th>Alamat</th>
                    <th>Nominal</th>
                    <th>Tanggal</th>
                    <th>Inpuser</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($usulan_data)) : ?>
                    <?php foreach ($usulan_data as $usulan) : ?>
                      <tr>
                        <td><?php echo $usulan->id; ?></td>
                        <td><?php echo $usulan->nama; ?></td>
                        <td><?php echo $usulan->nik; ?></td>
                        <td><?php echo $usulan->alamat; ?></td>
                        <td><?php echo $usulan->nominal; ?></td>
                        <td><?php echo date('Y-m-d', strtotime($usulan->tanggal)); ?></td>
                        <td><?php echo $this->Usulan_model->getUsernameById($usulan->id_user); ?></td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else : ?>
                    <!--  -->
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="panel panel-flat"> <!-- Panel Flat digunakan untuk membungkus tabel -->
            <div class="panel-body">
              <div class="navigation-buttons">
                <div class="btn-group" style="float: left;">
                  <i class="fa fa-plane"></i> DATA AKSES USER
                </div>
              </div>
              <div class="clearfix"></div>
            </div>
            <div class="table-responsive">
              <table class="table datatable-basic" width="100%">
                <thead>
                  <tr>
                    <th>Nama User</th>
                    <th>Level</th>
                    <th>Kode Kantor</th> <!-- Menambahkan kolom Kode Kantor -->
                    <th>Menu Akses</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  // Array untuk menyimpan akses menu berdasarkan ID user dan level
                  $user_menus = [];

                  // Kelompokkan menu akses berdasarkan id_user dan level
                  foreach ($menu_access as $access) {
                    if (!isset($user_menus[$access->id_user])) {
                      $user_menus[$access->id_user] = [
                        'user_name' => $access->nama_lengkap,
                        'level' => $access->level,
                        'kode_kantor' => $access->kode_kantor,  // Menambahkan kode_kantor
                        'menus' => []
                      ];
                    }
                    // Masukkan menu akses untuk user tersebut
                    $user_menus[$access->id_user]['menus'][] = $access;
                  }

                  // Loop untuk menampilkan setiap user dan menu aksesnya dalam bentuk tabel
                  foreach ($user_menus as $user_id => $user_data) {
                    echo render_user_menu_row($user_data['user_name'], $user_data['level'], $user_data['kode_kantor'], $user_data['menus']);
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div> <!-- Akhir dari panel panel-flat -->
        </div> <!-- Akhir dari row -->

        <?php
        // Fungsi untuk menampilkan baris tabel akses menu per user
        function render_user_menu_row($user_name, $level, $kode_kantor, $menu_list)
        {
          $levelText = getLevelText($level);
          $kodeKantorText = getKodeKantorText($kode_kantor);  // Mengambil deskripsi kode kantor

          // Mulai baris tabel
          echo '<tr>';

          // Kolom untuk Nama User dan Level
          echo '<td>' . htmlspecialchars($user_name) . '</td>';
          echo '<td>' . htmlspecialchars($levelText) . '</td>';
          echo '<td>' . htmlspecialchars($kodeKantorText) . '</td>';  // Menampilkan kode kantor

          // Kolom untuk menampilkan akses menu
          echo '<td>';

          // List menu akses untuk user
          echo '<ul class="list-unstyled">';  // Tidak menggunakan bullet point
          foreach ($menu_list as $access) {
            echo '<li><i class="fa ' . htmlspecialchars($access->icon) . '"></i> ' . htmlspecialchars($access->menu_name) . '</li>';
          }
          echo '</ul>';

          echo '</td>';

          echo '</tr>';
        }
        ?>


      </div>
    </div>
    <!-- /dashboard content -->
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
  setInterval(function() {
    location.reload(); // Me-refresh halaman
  }, 300000); // 300.000 milidetik = 5 menit

  function openPopup(imageURL) {
    Swal.fire({
      html: `<img src="${imageURL}" class="popup-image" />`,
      showCloseButton: true,
      showConfirmButton: false,
      customClass: {
        content: 'custom-popup-content',
        closeButton: 'custom-popup-close-button'
      }
    });
  }
</script>
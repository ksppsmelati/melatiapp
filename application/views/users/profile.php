<?php
$user = $user->row();
$jk = $user->jenis_kelamin;
$kodeKantor = $user->kode_kantor;
$level = $user->level;
$tgl_daftar = $user->tgl_daftar;
$status = $user->status;
$performa = $user->performa; // Gantilah ini dengan nilai performa yang sesuai
$starColor = ($performa > 0) ? 'gold' : 'white'; // Tentukan warna bintang
$filledStars = ($performa > 0) ? min($performa, 5) : 0; // Tentukan jumlah bintang yang diisi
$borderedStars = max(5 - $filledStars, 0); // Tentukan jumlah bintang dengan border

// menghitung lama kerja
$date_daftar = new DateTime($tgl_daftar);
$date_now = new DateTime();
$interval = $date_daftar->diff($date_now);
$years = $interval->y;
$months = $interval->m;
$nocif = $user->nocif;

// Mapping kode produk ke deskripsi
// $kode_produk_desc = [
//   10 => 'SIMPANAN MELATI',
//   17 => 'SIMPANAN MASA DATANG 10 THN',
//   20 => 'SIMPANAN MELATI EMAS SYARIAH',
//   21 => 'SIMPANAN PEMBIAYAAN',
//   22 => 'SIMPANAN HARI RAYA',
//   23 => 'SIMPANAN UKHUWAH PENDIDIKAN',
//   25 => 'SIMPANAN PEMUPUKAN MODAL',
//   29 => 'SIMPANAN POKOK',
//   30 => 'SIMPANAN WAJIB',
//   31 => 'SIMPANAN MASA DATANG 2 TAHUN',
//   32 => 'SIMPANAN MASA DATANG 5 TAHUN',
//   33 => 'SIMPANAN PENYERTAAN',
//   35 => 'SIMPANAN UMROH',
//   36 => 'SIMPANAN HAJI',
//   37 => 'SIMPANAN MASA DATANG 1 TAHUN',
// ];

?>
<style>
  body {
    overflow-x: hidden;
  }

  .logout-button-container {
    display: flex;
    justify-content: flex-end;
  }

  .toggle-section {
    margin-bottom: 20px;
    border: 1px solid #ddd;
    padding: 10px;
    cursor: pointer;
    background-color: #f7f7f7;
  }

  .toggle-content {
    display: none;
    /* Default sembunyikan form */
    margin-top: 10px;
  }

  .toggle-icon {
    float: right;
    transition: transform 0.5s ease-in-out;
    /* Perpanjang durasi dan gunakan ease-in-out untuk animasi yang lebih smooth */
  }

  .toggle-icon.rotate {
    transform: rotate(180deg);
  }

  .info {
    text-align: center;
  }

  .info .name {
    font-size: 18px;
    font-weight: bold;
    color: #333;
  }

  .info .job-title {
    font-size: 16px;
    color: #777;
    margin-bottom: 15px;
  }

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

  .circular-image:hover {
    transform: scale(1.1);
  }
</style>
<!-- Main content -->
<div class="container">

  <!-- Content area -->
  <div class="content">
    <!-- Dashboard content -->
    <div class="row">
      <?php echo $this->session->flashdata('msg'); ?>
      <?php echo $this->session->flashdata('msg2'); ?>
      <div class="panel panel-flat">
        <div class="panel-body">
          <?php
          $thumbnailURL = (!empty($user->foto_profile) && file_exists('./foto/foto_profile/' . $user->foto_profile)) ? './foto/foto_profile/' . $user->foto_profile : 'foto/default.png';
          ?>

          <div class="info" style="display: flex; flex-direction: column; align-items: center; text-align: center;">
            <div style="width: 100px; height: 100px; overflow: hidden; border-radius: 50%; border: 2px solid #ffffff; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); display: flex; justify-content: center; align-items: center; transition: transform 0.3s;">
              <img class="circular-image" onclick="openPopup('<?php echo $thumbnailURL; ?>');" src="<?php echo $thumbnailURL; ?>" style="width: 100%; height: auto; object-fit: cover;" loading="lazy" onerror="this.onerror=null; this.src='foto/default.png';">
            </div>

            <div class="name" style="margin-top: 10px;"><?php echo htmlspecialchars($user->nama_lengkap); ?></div>
            <div class="job-title"><?php echo $levelText = getLevelText($user->level); ?></div>

            <div class="stars-container">
              <?php for ($i = 0; $i < $filledStars; $i++) : ?>
                <span class="fa fa-star" style="color: <?php echo $starColor; ?>; font-size: 12px;"></span>
              <?php endfor; ?>
              <?php for ($i = 0; $i < $borderedStars; $i++) : ?>
                <span class="far fa-star" style="color: #fff; font-size: 12px; opacity: 0.5;"></span>
              <?php endfor; ?>
            </div>
          </div>


          <fieldset class="content-group">
            <hr style="margin-top:10px;;margin-bottom:10px;">
            <i class="fa-solid fa-id-card-clip"></i> <b>CIF</b> :
            <?php echo $user->nocif; ?>
            <hr style="margin-top:10px;;margin-bottom:10px;">
            <i class="fa fa-user"></i> <b>Status</b> :
            <?php echo $user->status; ?>
            <hr style="margin-top:10px;margin-bottom:10px;">
            <i class="icon-calendar"></i> <b>Tanggal Masuk</b> :
            <?php echo date('d-m-Y', strtotime($user->tgl_daftar)); ?>
            <hr style="margin-top:10px;margin-bottom:10px;">
            <i class="fa fa-clock"></i>&nbsp<b>Masa Kerja</b> : <?php echo $years . ' tahun ' . $months . ' bulan'; ?>
            <hr style="margin-top:10px;margin-bottom:10px;">
            <!-- <?php echo $user->terakhir_login; ?> -->
            <i class="fa fa-hourglass-half"></i> <b>Sisa Cuti</b> :
            <?php echo $user->sisa_cuti; ?>
          </fieldset>
          </form>
        </div>
      </div>

      <!-- Panel Rekening -->
      <!-- <div class="panel panel-flat">
        <div class="panel-heading">
          <h5 class="panel-title" data-toggle="collapse" href="#collapseSimpanan"><i class="fa-solid fa-money-check-dollar"></i> Rekening Simpanan<i class="fa fa-chevron-down toggle-icon"></i></h5>
        </div>
        <div id="collapseSimpanan" class="panel-collapse collapse">
          <div class="panel-body">
            <fieldset class="content-group">
              <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css">

              <div class="swiper-container">
                <div class="swiper-wrapper">
                  <?php foreach ($tabungan as $account) : ?>
                    <div class="swiper-slide">
                      <div class="panel panel-flat account-panel">
                        <div class="panel-body text-center">
                          <div class="account-name">
                            <?php echo $account['fnama']; ?>
                            <?php if (!empty($account['namaqq'])) : ?>
                              <?php echo ' QQ ' . $account['namaqq']; ?>
                            <?php endif; ?>
                          </div>
                          <hr>
                          <small class="account-product" style="font-size: 20px; font-weight: bold;">
                            <?php echo isset($kode_produk_desc[$account['kodeprd']]) ? $kode_produk_desc[$account['kodeprd']] : $account['kodeprd']; ?>
                          </small>
                          <div class="account-number">
                            <?php echo $account['notab']; ?>
                          </div>
                          <div class="account-balance">
                            <span class="saldo-amount" style="color: #e84c4f;">
                              <?php echo 'Rp ' . number_format($account['sahirrp'], 0, ',', '.'); ?>
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>
                <div class="swiper-pagination"></div>
              </div>

              <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

              <script>
                var swiper = new Swiper('.swiper-container', {
                  slidesPerView: 1,
                  spaceBetween: 10,
                  pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                  },
                  slideToClickedSlide: true, 
                  effect: 'fade',
                  speed: 500, 
                  breakpoints: {
                    640: {
                      slidesPerView: 1,
                      spaceBetween: 10,
                    },
                    768: {
                      slidesPerView: 2,
                      spaceBetween: 20,
                    },
                    1024: {
                      slidesPerView: 3,
                      spaceBetween: 30,
                    },
                  }
                });
              </script>

              <style>
                .account-panel {
                  background-color: #f5f5f5;
                  border-radius: 10px;
                  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                  opacity: 0;
                  transform: translateX(100%);
                  transition: opacity 0.5s, transform 0.5s ease-in-out;
                  width: 100%;
                  max-width: 350px;
                  margin: 0 auto;
                }

                .account-product {
                  font-size: 14px;
                  color: #333;
                }

                .account-number {
                  font-size: 18px;
                  font-weight: bold;
                  margin: 10px 0;
                }

                .account-balance {
                  font-size: 16px;
                  margin-top: 15px;
                }

                .saldo-amount {
                  margin-left: 10px;
                  font-size: 20px;
                  font-weight: bold;
                  color: #e84c4f;
                }

                .swiper-container {
                  width: 100%;
                  height: auto;
                }

                .swiper-wrapper {
                  display: flex;
                  justify-content: center;
                }

                .swiper-slide {
                  display: flex;
                  justify-content: center;
                  align-items: center;
                  width: 100%;
                }

                .swiper-pagination {
                  bottom: 10px;
                }

                .swiper-pagination-bullet-active {
                  background-color: #333;
                }

                @media (max-width: 480px) {
                  .swiper-slide {
                    padding: 10px;
                  }

                  .account-panel {
                    max-width: 100%;
                  }
                }

                .swiper-slide-active .account-panel {
                  opacity: 1;
                  transform: translateX(0);
                }
              </style>

            </fieldset>
          </div>
        </div>
      </div> -->

      <!-- Panel Ubah PIN -->
      <div class="panel panel-flat">
        <div class="panel-heading">
          <h5 class="panel-title" data-toggle="collapse" href="#collapsePin"><i class="fa fa-key"></i> Ubah PIN <i class="fa fa-chevron-down toggle-icon"></i></h5>
        </div>
        <div id="collapsePin" class="panel-collapse collapse">
          <div class="panel-body">
            <fieldset class="content-group">
              <form class="form-horizontal" action="" method="post">
                <div class="form-group">
                  <label class="control-label col-lg-3">PIN Baru</label>
                  <div class="col-lg-9">
                    <input type="password" pattern="\d*" inputmode="numeric" name="password" class="form-control" placeholder="PIN Baru" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-lg-3">Ulangi PIN</label>
                  <div class="col-lg-9">
                    <input type="password" pattern="\d*" inputmode="numeric" name="password2" class="form-control" placeholder="Ulangi PIN" required>
                  </div>
                </div>
            </fieldset>
            <div class="col-md-12">
              <button type="submit" name="btnupdate2" class="btn btn-danger" style="float:right;">Simpan</button>
            </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Panel Ubah Profile -->
      <div class="panel panel-flat">
        <div class="panel-heading">
          <h5 class="panel-title" data-toggle="collapse" href="#collapseProfile"><i class="fa fa-user"></i> Pengaturan Profile <i class="fa fa-chevron-down toggle-icon"></i></h5>
        </div>
        <div id="collapseProfile" class="panel-collapse collapse">
          <div class="panel-body">
            <fieldset class="content-group">
              <form class="form-horizontal" action="" method="post">
                <div class="form-group">
                  <label class="control-label col-lg-3">Username <span style="color: red;">*</span></label>
                  <div class="col-lg-9">
                    <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($user->username); ?>" placeholder="Username">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-lg-3">Nama Lengkap</label>
                  <div class="col-lg-9">
                    <input type="text" name="nama_lengkap" class="form-control" value="<?php echo htmlspecialchars($user->nama_lengkap); ?>" placeholder="Nama Lengkap" maxlength="100" required>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-lg-3">Email</label>
                  <div class="col-lg-9">
                    <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user->email); ?>" placeholder="Email" required>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-lg-3">Alamat</label>
                  <div class="col-lg-9">
                    <textarea name="alamat" rows="3" cols="80" class="form-control" placeholder="Alamat" required><?php echo htmlspecialchars($user->alamat); ?></textarea>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-lg-3">Telepon</label>
                  <div class="col-lg-9">
                    <input type="text" name="telp" class="form-control" value="<?php echo htmlspecialchars($user->telp); ?>" placeholder="Telepon" maxlength="30" required>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-lg-3">No. Rekening</label>
                  <div class="col-lg-9">
                    <input type="text" name="nomor_rekening" class="form-control" value="<?php echo htmlspecialchars($user->nomor_rekening); ?>" placeholder="No. Rekening" maxlength="30">
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-lg-3">Sertifikasi</label>
                  <div class="col-lg-9">
                    <textarea name="pengalaman" rows="3" cols="80" class="form-control" placeholder="Sertifikasi yang dimiliki"><?php echo htmlspecialchars($user->pengalaman); ?></textarea>
                  </div>
                </div>
            </fieldset>
            <div class="col-md-12">
              <button type="submit" name="btnupdate" class="btn btn-danger" style="float:right;">Simpan</button>
            </div>
            </form>
          </div>
        </div>
      </div>

      <div style="text-align: center;">
        <small style="font-family: 'Courier New'; font-size: 12;">
          Version <?php echo $application_version; ?>
        </small>
      </div>

      <div class="col-xs-12" style="margin-top: 20px; margin-bottom: 50px; border-radius: 10px;">
        <a href="web/logout" class="btn btn-outline-danger btn-block" style="padding: 15px; font-size: 18px; border: 2px solid #dc3545; color: #dc3545; background-color: transparent;">
          KELUAR
        </a>
      </div>

    </div>
  </div>
</div>
<!-- /dashboard content -->

<link rel="stylesheet" type="text/css" href="assets/upload/dropzone.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.css">

<script src="assets/js/jquery-ui.js"></script>
<script type="text/javascript" src="assets/js/core/app.js"></script>
<script type="text/javascript" src="assets/upload/dropzone.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.js"></script>

<script>
  $(document).ready(function() {
    // Inisialisasi collapse untuk Pin dan Profile
    $('#collapsePin').collapse('hide');
    $('#collapseProfile').collapse('hide');
    $('#collapseSimpanan').collapse('hide');

    // Toggle ikon pada collapse PIN
    $('#collapsePin').on('shown.bs.collapse', function() {
      $(this).prev().find('.toggle-icon').addClass('rotate');
    }).on('hidden.bs.collapse', function() {
      $(this).prev().find('.toggle-icon').removeClass('rotate');
    });

    // Toggle ikon pada collapse Profile
    $('#collapseProfile').on('shown.bs.collapse', function() {
      $(this).prev().find('.toggle-icon').addClass('rotate');
    }).on('hidden.bs.collapse', function() {
      $(this).prev().find('.toggle-icon').removeClass('rotate');
    });

    // Toggle ikon pada collapse Simpanan
    $('#collapseSimpanan').on('shown.bs.collapse', function() {
      $(this).prev().find('.toggle-icon').addClass('rotate');
    }).on('hidden.bs.collapse', function() {
      $(this).prev().find('.toggle-icon').removeClass('rotate');
    });
  });

  function openPopup(imageURL, linkURL) {
  Swal.fire({
    html: `
      <img src="${imageURL}" class="popup-image" style="width: 100%; height: auto; margin-bottom: 20px;" />
      <a href="<?php echo site_url('users/profile_edit_photo'); ?>" class="popup-link circular-image" style="display: inline-block; padding: 10px 20px; background-color: #f44336; color: white; text-decoration: none; border-radius: 5px; transition: background-color 0.3s;">Ganti Foto</a><br><br><br>
    `,
    showCloseButton: true,
    showConfirmButton: false,
    customClass: {
      content: 'custom-popup-content',
      closeButton: 'custom-popup-close-button'
    }
  });
}

</script>
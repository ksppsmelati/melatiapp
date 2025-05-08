<?php
$user = $query; ?>
<style>
  .dropzone {
    border: 2px dashed #0087F7;
    text-align: center;
    background-color: #f7f7f7;
    display: flex;
    flex-direction: column;
    align-items: center;
    min-height: 100px;
  }

  .panel .dropzone {
    background-color: #fff;
    border-color: #fff;
  }

  .plus-icon {
    position: absolute;
    bottom: 4px;
    top: 120px;
    font-size: 30px;
    cursor: pointer;
    color: #28a745;
    border-radius: 50%;
    background-color: #fff;
  }
</style>
<!-- Main content -->
<div class="container">
  <!-- Content area -->
  <div class="content">
    <!-- Dashboard content -->
    <div class="row">
      <div class="panel panel-flat">
        <div class="panel-body">
          <fieldset class="content-group">
            <legend class="text-bold"><i class="icon-user"></i> Edit Pengguna</legend>
            <?php
            echo $this->session->flashdata('msg');
            ?>
                        <?php
            $thumbnailURL = (!empty($user->foto_profile) && file_exists('./foto/foto_profile/' . $user->foto_profile)) ? './foto/foto_profile/' . $user->foto_profile : 'foto/default.png';
            ?>

            <form id="myForm" action="<?php echo site_url('users/update_foto_profile_by_sys'); ?>" method="post" enctype="multipart/form-data">
              <input type="hidden" name="id_user" value="<?php echo $user->id_user; ?>">
              <div class="form-group">
                <div class="dropzone" id="myDropzone">
                  <div class="dz-message">
                    <div style="width: 100px; height: 100px; overflow: hidden; border-radius: 50%; position: relative;">
                      <img src="<?php echo $thumbnailURL; ?>" alt="<?php echo htmlspecialchars($user->nama_lengkap); ?>" style="position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%) scale(1.2);" width="100%" height="auto" loading="lazy">
                    </div>
                    <i class="fas fa-plus-circle plus-icon" onclick="document.getElementById('foto_profile').click();"></i>
                  </div>
                </div>
              </div>
              <div class="col-md-12 text-center">
                <button type="submit" id="submit_compressed" name="btnupdate" class="btn btn-secondary">Simpan Foto</button>
              </div>
            </form>
            <div class="clearfix"></div>
            <hr>
            <form class="form-horizontal" action="" method="post">
              <div class="form-group">
                <label class="control-label col-lg-3">Username</label>
                <div class="col-lg-9">
                  <input type="text" name="username" class="form-control" value="<?php echo $user->username; ?>" placeholder="Nama Pengguna" readonly>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-lg-3">Password</label>
                <div class="col-lg-9">
                  <input type="text" name="password" class="form-control" value="<?php echo $user->password; ?>" readonly>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-lg-3">Nama Lengkap</label>
                <div class="col-lg-9">
                  <input type="text" name="nama_lengkap" class="form-control" value="<?php echo $user->nama_lengkap; ?>" placeholder="Nama Lengkap" maxlength="100" required>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-lg-3">CIF</label>
                <div class="col-lg-9">
                  <input type="text" name="nocif" class="form-control" value="<?php echo $user->nocif; ?>" placeholder="No CIF" maxlength="100">
                </div>
              </div>
              <!-- Add this block within the form -->
              <div class="form-group">
                <label class="control-label col-lg-3">Status</label>
                <div class="col-lg-9">
                  <?php
                  // Simulasi data kode kantor dan nama kantor dari database
                  $statusOptions = ['pending', 'aktif'];
                  $selectedStatus = $query->status; // Use $query to get the existing status for the user being edited

                  echo '<select class="form-control" name="status" required>';
                  echo '<option value="">- Pilih Status -</option>';

                  foreach ($statusOptions as $statusOption) {
                    $selected = ($selectedStatus == $statusOption) ? 'selected' : '';
                    echo "<option value='$statusOption' $selected>" . ucfirst($statusOption) . "</option>";
                  }

                  echo '</select>';
                  ?>
                </div>
              </div>


              <div class="form-group">
                <label class="control-label col-lg-3">Email</label>
                <div class="col-lg-9">
                  <input type="email" name="email" class="form-control" value="<?php echo $user->email; ?>" placeholder="Email">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-lg-3">Level</label>
                <div class="col-lg-9">
                  <select class="form-control" name="level">
                    <option value="">- Pilih Level Pengguna -</option>
                    <option value="umum_dan_pengadaan" <?php if ($user->level == "umum_dan_pengadaan") {
                                          echo "selected";
                                        } ?>>Staff Umum & Pengadaan</option>
                    <option value="marketing" <?php if ($user->level == "marketing") {
                                                echo "selected";
                                              } ?>>Marketing</option>
                    <option value="admin" <?php if ($user->level == "admin") {
                                            echo "selected";
                                          } ?>>Admin</option>
                    <option value="ofb" <?php if ($user->level == "ofb") {
                                          echo "selected";
                                        } ?>>Office Boy</option>
                    <option value="satpam" <?php if ($user->level == "satpam") {
                                              echo "selected";
                                            } ?>>Satpam</option>
                    <option value="it" <?php if ($user->level == "it") {
                                          echo "selected";
                                        } ?>>Staff IT</option>
                    <option value="audit" <?php if ($user->level == "audit") {
                                            echo "selected";
                                          } ?>>Staff Audit</option>
                    <option value="surveyor" <?php if ($user->level == "surveyor") {
                                                echo "selected";
                                              } ?>>Staff Surveyor</option>
                    <option value="k_cabang" <?php if ($user->level == "k_cabang") {
                                                echo "selected";
                                              } ?>>Kabag Cabang</option>
                    <option value="k_hrd" <?php if ($user->level == "k_hrd") {
                                            echo "selected";
                                          } ?>>Kabag HRD</option>
                    <option value="k_keuangan" <?php if ($user->level == "k_keuangan") {
                                                  echo "selected";
                                                } ?>>Kabag Keuangan</option>
                    <option value="k_admin" <?php if ($user->level == "k_admin") {
                                              echo "selected";
                                            } ?>>Kabag Admin</option>
                    <option value="k_arsip" <?php if ($user->level == "k_arsip") {
                                              echo "selected";
                                            } ?>>Kabag Arsip</option>
                    <option value="kadiv_pemasaran" <?php if ($user->level == "kadiv_pemasaran") {
                                                      echo "selected";
                                                    } ?>>Kadiv Pemasaran</option>
                    <option value="kadiv_opr" <?php if ($user->level == "kadiv_opr") {
                                                echo "selected";
                                              } ?>>Kadiv Operational</option>
                    <option value="ao" <?php if ($user->level == "ao") {
                                          echo "selected";
                                        } ?>>Account Officer</option>
                    <option value="kadiv_manrisk" <?php if ($user->level == "kadiv_manrisk") {
                                                    echo "selected";
                                                  } ?>>Kadiv Manrisk</option>
                    <option value="kadiv_maal" <?php if ($user->level == "kadiv_maal") {
                                                  echo "selected";
                                                } ?>>Kadiv Maal</option>
                    <option value="Fund_maal" <?php if ($user->level == "fund_maal") {
                                                echo "selected";
                                              } ?>>Fundrising Maal</option>
                    <option value="fo" <?php if ($user->level == "fo") {
                                          echo "selected";
                                        } ?>>Funding Officer</option>
                    <option value="mng_bisnis" <?php if ($user->level == "mng_bisnis") {
                                                  echo "selected";
                                                } ?>>Manager Business</option>
                    <option value="gm" <?php if ($user->level == "gm") {
                                          echo "selected";
                                        } ?>>General Manager</option>
                    <option value="s_admin" <?php if ($user->level == "s_admin") {
                                          echo "selected";
                                        } ?>>Super Admin</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-lg-3">Kode Kantor</label>
                <div class="col-lg-9">
                  <?php
                  // Simulasi data kode kantor dan nama kantor dari database
                  $kode_kantor = ['01', '02', '03', '04', '05', '06', '07', '08', '09'];
                  $nama_kantor = ['Pusat', 'Sedayu', 'Sapuran', 'Kertek', 'Wonosobo', 'Kaliwiro', 'Banjarnegara', 'Randusari', 'Kepil'];
                  $selectedKodeKantor = $user->kode_kantor; // Nilai kode kantor yang tersimpan pada database

                  echo '<select class="form-control" name="kode_kantor" required>';
                  echo '<option value="">- Pilih Kode Kantor -</option>';

                  for ($i = 0; $i < count($kode_kantor); $i++) {
                    $selected = ($selectedKodeKantor == $kode_kantor[$i]) ? 'selected' : '';
                    echo "<option value='$kode_kantor[$i]' $selected>$nama_kantor[$i]</option>";
                  }

                  echo '</select>';
                  ?>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-lg-3">Devisi</label>
                <div class="col-lg-9">
                  <?php
                  // Simulasi data kode devisi dan nama kantor dari database
                  $kode_devisi = ['01', '02', '03', '04'];
                  $nama_devisi = ['Pemasaran', 'Operasional', 'Manrisk', 'Manajemen Bisnis'];
                  $selectedKodeDevisi = $user->kode_devisi; // Nilai kode devisi yang tersimpan pada database

                  echo '<select class="form-control" name="kode_devisi" required>';
                  echo '<option value="">- Pilih Devisi -</option>';

                  for ($i = 0; $i < count($kode_devisi); $i++) {
                    $selected = ($selectedKodeDevisi == $kode_devisi[$i]) ? 'selected' : '';
                    echo "<option value='$kode_devisi[$i]' $selected>$nama_devisi[$i]</option>";
                  }

                  echo '</select>';
                  ?>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-lg-3">Kode Atasan (A1)</label>
                <div class="col-lg-9">
                  <?php
                  $kode_atasan = ['gmr', 'mnb', 'mbm', 'kop', 'kpm', 'kmr', 'kbm', 'kcb','khrd'];
                  $nama_atasan = ['General Manager', 'Manager Bisnis', 'Manager Baitul Maal', 'Kadiv Operasional', 'Kadiv Pemasaran', 'Kadiv Menrisk', 'Kadiv Baitul Maal', 'Kepala Cabang','Kabag HRD'];

                  // Ambil nilai properti yang sesuai dari objek $user
                  $selectedKodeAtasan = $user->kode_atasan;

                  echo '<select class="form-control" name="kode_atasan">';
                  echo '<option value="">- Pilih Atasan -</option>';

                  for ($i = 0; $i < count($kode_atasan); $i++) {
                    $selected = ($selectedKodeAtasan == $kode_atasan[$i]) ? 'selected' : '';
                    echo "<option value='$kode_atasan[$i]' $selected>$nama_atasan[$i]</option>";
                  }

                  echo '</select>';
                  ?>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-lg-3">Kode Atasan (A2)</label>
                <div class="col-lg-9">
                  <input type="text" name="kode_atasan_2" class="form-control" value="<?php echo $user->kode_atasan_2; ?>" placeholder="Kode Atasan (A2)" maxlength="30">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-lg-3">Alamat</label>
                <div class="col-lg-9">
                  <textarea name="alamat" rows="3" cols="80" class="form-control" placeholder="Alamat"><?php echo $user->alamat; ?></textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-lg-3">Telepon</label>
                <div class="col-lg-9">
                  <input type="text" name="telp" class="form-control" value="<?php echo $user->telp; ?>" placeholder="Telepon" maxlength="30" required>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-lg-3">No. Rekening</label>
                <div class="col-lg-9">
                  <input type="number" name="nomor rekening" class="form-control" value="<?php echo $user->nomor_rekening; ?>" placeholder="nomor rekening" maxlength="30">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-lg-3">Sertifikasi</label>
                <div class="col-lg-9">
                  <textarea name="pengalaman" rows="3" cols="80" class="form-control" placeholder="Sertifikasi"><?php echo $user->pengalaman; ?></textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-lg-3">Menu Custom</label>
                <div class="col-lg-9">
                  <textarea name="custom_menu" rows="3" cols="80" class="form-control" placeholder="Menu Custom"><?php echo $user->custom_menu; ?></textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-lg-3">Perangkat Terdaftar</label>
                <div class="col-lg-9">
                  <textarea name="device_reg" id="device_reg" rows="3" cols="80" class="form-control" placeholder="Perangkat Terdaftar"><?php echo $user->device_reg; ?></textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-lg-3">Perangkat Login</label>
                <div class="col-lg-9">
                  <textarea name="device_info" id="device_info" rows="3" cols="80" class="form-control" placeholder="Perangkat Login"><?php echo $user->device_info; ?></textarea>
                </div>
              </div>
              <div class="form-group text-center">
                <button type="button" id="copyDeviceInfo" class="btn btn-secondary"><i class="fa fa-refresh"></i></button>
              </div>
              
              <a href="users/pengguna" class="btn btn-default">
                << Kembali</a>
                  <button type="submit" name="btnupdate" class="btn btn-danger" style="float:right;">Update</button>
            </form>
          </fieldset>
        </div>
      </div>
    </div>
    <!-- /dashboard content -->
    <script>
                document.getElementById('copyDeviceInfo').addEventListener('click', function() {
                  var deviceInfo = document.getElementById('device_info').value;
                  document.getElementById('device_reg').value = deviceInfo;
                });
              </script>
  </div>
</div>

<link rel="stylesheet" type="text/css" href="assets/upload/dropzone.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.css">

<script src="assets/js/jquery-ui.js"></script>
<script type="text/javascript" src="assets/js/core/app.js"></script>
<script type="text/javascript" src="assets/upload/dropzone.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.js"></script>

<script>
  $('.msg').html('');
  Dropzone.options.myDropzone = {
    url: "<?php echo base_url('users/update_foto_profile_by_sys') ?>",
    paramName: "foto_profile",
    acceptedFiles: "'image/jpg,image/jpeg,image/png,image/bmp",
    autoProcessQueue: false,
    maxFilesize: 10, //MB
    parallelUploads: 1,
    maxFiles: 1,
    addRemoveLinks: true,
    dictCancelUploadConfirmation: "Yakin ingin membatalkan upload ini?",
    dictInvalidFileType: "Type file ini tidak dizinkan",
    dictFileTooBig: "File yang Anda Upload terlalu besar {{filesize}} MB. Maksimal Upload {{maxFilesize}} MB",
    dictRemoveFile: "Hapus",

    init: function() {
      myDropzone = this; // closure
      var submitButton = document.querySelector("#submit_compressed")

      submitButton.addEventListener("click", function(e) {
        e.preventDefault();
        e.stopPropagation();

        if (myDropzone.getQueuedFiles().length === 0) {
          submitFormWithoutFile();
        } else {
          myDropzone.processQueue();
        }
      });

      // files are dropped here:
      this.on("addedfile", function(file) {
        // Cek apakah file sudah terkompres
        if (file.hasOwnProperty("compressed")) {
          // File sudah terkompres, tidak perlu melakukan proses kompresi lagi
          return;
        }

        var reader = new FileReader();

        reader.onload = function(event) {
          var img = new Image();

          img.onload = function() {
            var canvas = document.createElement("canvas");
            var ctx = canvas.getContext("2d");

            var maxWidth = 800; // Lebar maksimum gambar
            var maxHeight = 800; // Tinggi maksimum gambar

            var width = img.width;
            var height = img.height;

            // Menghitung ulang lebar dan tinggi gambar sesuai dengan rasio aspek
            if (width > height) {
              if (width > maxWidth) {
                height *= maxWidth / width;
                width = maxWidth;
              }
            } else {
              if (height > maxHeight) {
                width *= maxHeight / height;
                height = maxHeight;
              }
            }

            // Mengatur ukuran canvas sesuai dengan gambar yang terkompresi
            canvas.width = width;
            canvas.height = height;

            // Menggambar gambar ke dalam canvas dengan ukuran yang terkompresi
            ctx.drawImage(img, 0, 0, width, height);

            // Mengonversi canvas menjadi gambar terkompresi dalam format JPEG dengan kualitas 0.8
            canvas.toBlob(function(blob) {
              var compressedFile = new File([blob], file.name, {
                type: "image/jpeg"
              });
              compressedFile.compressed = true; // Menandai file sebagai sudah terkompres

              // Menambahkan file terkompresi ke Dropzone untuk diupload
              myDropzone.addFile(compressedFile);
            }, "image/jpeg", 0.8);
          };

          img.src = event.target.result;
        };

        reader.readAsDataURL(file);
        if (!file.hasOwnProperty("compressed")) {
          myDropzone.removeFile(file);
        }
      });

      this.on("sending", function(file, xhr, formData) {
        // Mengumpulkan data form lainnya
        var data = $("#myForm").serializeArray();
        $.each(data, function(key, el) {
          formData.append(el.name, el.value);
        });
      });

      this.on("complete", function(file) {
        //Event ketika Memulai mengupload
        myDropzone.removeFile(file);
      });

      this.on("success", function(file, response) {
        // Menggunakan SweetAlert untuk menampilkan alert
        Swal.fire({
          icon: 'success',
          title: 'Sukses!',
          text: 'Foto profile berhasil diupdate.',
          confirmButtonColor: '#f44336',
          confirmButtonText: 'OK'
        }).then((result) => {
          if (result.isConfirmed) {
            window.location = "<?php echo base_url(); ?>users/pengguna";
          }
        });
      });
    }

  };

  // Capture Image
  function captureImage() {
    if (window.AndroidFunction) {
      window.AndroidFunction.captureImage();
    }
  }
</script>
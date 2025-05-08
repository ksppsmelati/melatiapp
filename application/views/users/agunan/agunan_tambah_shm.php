<?php
$cek = $user->row();
$level = $cek->level;
$username = $cek->username;
$nama_lengkap = $cek->nama_lengkap;
?>

<style>
  .animate-camera-click {
    animation: cameraClickAnimation 0.5s;
  }

  @keyframes cameraClickAnimation {
    0% {
      transform: scale(1);
    }

    50% {
      transform: scale(1.2);
    }

    100% {
      transform: scale(1);
    }
  }

  /* General Dropzone style */
  .dropzone {
    border: 2px dashed #0087F7;
    margin-top: 10px;
    text-align: center;
    padding: 40px;
    background-color: #f7f7f7;
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  /* Icons */
  .fa-camera-retro {
    font-size: 48px;
    color: #555;
  }

  .fa-cloud-upload-alt {
    font-size: 24px;
    color: #555;
    margin-bottom: 10px;
  }
</style>

<link rel="stylesheet" type="text/css" href="assets/upload/dropzone.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.css">

<script src="assets/js/select2.min.js"></script>
<script src="assets/js/jquery-ui.js"></script>
<script type="text/javascript" src="assets/js/core/app.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.js"></script>
<script type="text/javascript" src="assets/upload/dropzone.min.js"></script>

<div class="container">
  <div class="content">
    <div class="row">
      <div class="panel panel-flat">
        <div class="panel-body">
          <fieldset class="content-group">
            <div class="navigation-buttons">
              <div class="btn-group" style="float: left;">
                <i class="fa fa-folder"></i> Tambah SHM
              </div>
              <div class="btn-group" style="float: right;">
                <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-bars"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-right" role="menu">
                  <li><a href="<?php echo site_url('users/agunan/agunan'); ?>"><i class="fa fa-id-card"></i> DATA BPKB</a></li>
                  <li><a href="<?php echo site_url('users/agunan/agunan_shm'); ?>"><i class="fa fa-folder"></i> DATA SHM</a></li>
                  <?php
                  $allowedLevels = ['kadiv_opr', 'k_arsip', 's_admin'];
                  if (in_array($user->row()->level, $allowedLevels)) {
                    echo '<li><a href="' . site_url('users/agunan_data_proses') . '"><i class="fa fa-shopping-cart"></i> DATA PESANAN</a></li>';
                  }
                  ?>
                  <?php
                  $allowedLevels = ['admin'];
                  if (in_array($user->row()->level, $allowedLevels)) {
                    echo '<li><a href="' . site_url('users/agunan_data_proses_cabang') . '"><i class="fa fa-shopping-cart"></i> DATA PESANAN</a></li>';
                  }
                  ?>
                </ul>
              </div>
            </div>

            <div class="navigation-buttons text-right">
              <div class="btn-group">
                <input type="checkbox" id="inputManualCheckbox" onchange="toggleManualInput()">
                <small for="inputManualCheckbox">Input Manual&nbsp&nbsp&nbsp</small>
              </div>
            </div>

            <div class="clearfix"></div>
            <hr>
            <form class="form-horizontal" id="myForm" action="users/agunan_simpan_shm" enctype="multipart/form-data" method="post">
              <div class="row">
                <div class="col-xs-12 col-sm-6" style="display: none;">
                  <div class="form-group">
                    <label class="control-label col-lg-3" style="font-weight: bold;">Tanggal</label>
                    <div class="col-lg-9">
                      <div class="input-group">
                        <span class="input-group-addon"><i class="icon-calendar" style="pointer-events: none;"></i></span>
                        <input type="text" name="tanggal" class="form-control daterange-single" id="tanggal" style="pointer-events: none;" value="<?php echo date('Y-m-d'); ?>">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-xs-12 col-sm-6">
                  <div class="form-group">
                    <div class="col-lg-9">
                      <!-- kosong -->
                    </div>
                  </div>
                </div>

                <div class="col-xs-12 col-sm-6">
                  <div class="form-group">
                    <label class="control-label col-lg-3" style="font-weight: bold;"> </label>
                    <div class="col-lg-9">
                      <select class="form-control cari_anggota" name="cari_anggota">
                        <option value="" disabled selected> Cari No. kontrak / Nama / No. Registrasi</option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="col-xs-6 col-sm-6" style="display: none;">
                  <div class="form-group">
                    <label class="control-label col-lg-3" style="font-weight: bold;">Tgl Masuk</label>
                    <div class="col-lg-9">
                      <input type="text" name="inptgljam" id="inptgljam" class="form-control" required readonly maxlength="8">
                    </div>
                  </div>
                </div>

                <div class="col-xs-6 col-sm-6">
                  <div class="form-group">
                    <label class="control-label col-lg-3" style="font-weight: bold;">Nama Anggota</label>
                    <div class="col-lg-9">
                      <input type="text" name="nm" id="nm" class="form-control" required readonly>
                      <input type="text" name="nm_manual" id="nm_manual" class="form-control" placeholder="Nama Anggota (Input Manual)" oninput="syncManualInput('nm_manual', 'nm')" style="display: none;">
                    </div>
                  </div>
                </div>

                <div class="col-xs-6 col-sm-6">
                  <div class="form-group">
                    <label class="control-label col-lg-3" style="font-weight: bold;">Alamat</label>
                    <div class="col-lg-9">
                      <input type="text" name="alamat" id="alamat" class="form-control" required readonly>
                      <input type="text" name="alamat_manual" id="alamat_manual" class="form-control" placeholder="Alamat (Input Manual)" oninput="syncManualInput('alamat_manual', 'alamat')" style="display: none;">
                    </div>
                  </div>
                </div>

                <div class="col-xs-6 col-sm-6">
                  <div class="form-group">
                    <label class="control-label col-lg-3" style="font-weight: bold;">Kode Kantor</label>
                    <div class="col-lg-9">
                      <input type="text" name="kdloc" id="kdloc" class="form-control" required readonly>
                      <select name="kdloc_manual" id="kdloc_manual" class="form-control" onchange="syncManualInput('kdloc_manual', 'kdloc')" style="display: none;">
                        <option value="">Pilih Kode Kantor Manual</option>
                        <option value="01">PUSAT</option>
                        <option value="02">SEDAYU</option>
                        <option value="03">SAPURAN</option>
                        <option value="04">KERTEK</option>
                        <option value="05">WONOSOBO</option>
                        <option value="06">KALIWIRO</option>
                        <option value="07">BANJARNEGARA</option>
                        <option value="08">RANDUSARI</option>
                        <option value="09">KEPIL</option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="col-xs-6 col-sm-6">
                  <div class="form-group">
                    <label class="control-label col-lg-3" style="font-weight: bold;">No. Kontrak</label>
                    <div class="col-lg-9">
                      <input type="number" name="nokontrak" id="nokontrak" class="form-control" required readonly>
                      <input type="number" name="nokontrak_manual" id="nokontrak_manual" class="form-control" placeholder="No. Kontrak (Input Manual)" oninput="syncManualInput('nokontrak_manual', 'nokontrak')" style="display: none;">
                    </div>
                  </div>
                </div>

                <div class="col-xs-6 col-sm-6">
                  <div class="form-group">
                    <label class="control-label col-lg-3" style="font-weight: bold;">No. Registrasi</label>
                    <div class="col-lg-9">
                      <input type="text" name="noreg" id="noreg" class="form-control" required readonly>
                      <input type="text" name="noreg_manual" id="noreg_manual" class="form-control" placeholder="No. Registrasi (Input Manual)" oninput="syncManualInput('noreg_manual', 'noreg')" style="display: none;">
                    </div>
                  </div>
                </div>

                <div class="col-xs-6 col-sm-6">
                  <div class="form-group">
                    <label class="control-label col-lg-3" style="font-weight: bold;">Jenis Jaminan</label>
                    <div class="col-lg-9">
                      <input type="number" name="jnsjamin" id="jnsjamin" class="form-control" readonly>
                      <select name="jnsjamin_manual" id="jnsjamin_manual" class="form-control" onchange="syncManualInput('jnsjamin_manual', 'jnsjamin')" style="display: none;">
                        <option value="">Pilih Jenis Jaminan</option>
                        <option value="7">TANAH DAN BANGUNAN (SKMHT)</option>
                        <option value="8">TANAH DAN BANGUNAN (APHT)</option>
                        <option value="9">TANAH DAN BANGUNAN (NOTARIS)</option>
                        <option value="10">TANAH DAN BANGUNAN (BT)</option>
                        <option value="15">TANAH DAN BANGUNAN (KUASA JUAL BELI)</option>
                        <option value="99">LAINNYA</option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="col-xs-6 col-sm-6">
                  <div class="form-group">
                    <label class="control-label col-lg-3" style="font-weight: bold;">Plafond</label>
                    <div class="col-lg-9">
                      <input type="number" name="digunakan" id="digunakan" class="form-control" required readonly>
                      <input type="number" name="digunakan_manual" id="digunakan_manual" class="form-control" placeholder="Plafon (Input Manual)" oninput="syncManualInput('digunakan_manual', 'digunakan')" style="display: none;">
                    </div>
                  </div>
                </div>

                <div class="col-xs-6 col-sm-6">
                  <div class="form-group">
                    <label class="control-label col-lg-3" style="font-weight: bold;">Jenis Dokumen</label>
                    <div class="col-lg-9">
                      <input type="number" name="jnsdokumen" id="jnsdokumen" class="form-control" required readonly>
                      <select name="jnsdokumen_manual" id="jnsdokumen_manual" class="form-control" onchange="syncManualInput('jnsdokumen_manual', 'jnsdokumen')" style="display: none;">
                        <option value="">Pilih Jenis Dokumen</option>
                        <option value="1">SHM</option>
                        <option value="2">SHM A/Rusun</option>
                        <option value="3">SHGB</option>
                        <option value="4">SHP</option>
                        <option value="5">SHGU</option>
                        <option value="19">LAIN-LAIN</option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="col-xs-6 col-sm-6">
                  <div class="form-group">
                    <label class="control-label col-lg-3" style="font-weight: bold;">Atas Nama</label>
                    <div class="col-lg-9">
                      <input type="text" name="an" id="an" class="form-control" required readonly>
                      <input type="text" name="an_manual" id="an_manual" class="form-control" placeholder="Atas Nama (Input Manual)" oninput="syncManualInput('an_manual', 'an')" style="display: none;">
                    </div>
                  </div>
                </div>

                <div class="col-xs-6 col-sm-6">
                  <div class="form-group">
                    <label class="control-label col-lg-3" style="font-weight: bold;">Lokasi Jaminan</label>
                    <div class="col-lg-9">
                      <input type="text" name="lokasi" id="lokasi" class="form-control" required readonly>
                      <input type="text" name="lokasi_manual" id="lokasi_manual" class="form-control" placeholder="Lokasi Jaminan (Input Manual)" oninput="syncManualInput('lokasi_manual', 'lokasi')" style="display: none;">
                    </div>
                  </div>
                </div>

                <div class="col-xs-12 col-sm-12" style="display: none;">
                  <div class="form-group">
                    <div class="dropzone" id="myDropzone">
                      <div class="dz-message">
                        <i class="fas fa-camera-retro" id="cameraIcon" name="cameraIcon" onclick="captureImage()"></i>
                        <p class="upload-text">Ambil Foto</p>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-xs-12 col-sm-12">
                  <div class="form-group">
                    <label class="control-label col-lg-6" style="font-weight: bold;">Keterangan </label>
                    <div class="col-lg-12">
                      <textarea name="catatan" id="catatan" class="form-control" required style="height: 100px;"></textarea>
                      <textarea name="catatan_manual" id="catatan_manual" class="form-control" placeholder="Keterangan (Input Manual)" oninput="syncManualInput('catatan_manual', 'catatan')" style="display: none;" style="height: 100px;"></textarea>
                    </div>
                  </div>
                </div>

                <div class="form-group" style="display: none;">
                  <label class="control-label col-lg-3" style="font-weight: bold;">Petugas Input</label>
                  <div class="col-lg-9">
                    <input type="text" name="username" id="username" class="form-control" required readonly value="<?php echo $nama_lengkap; ?>">
                  </div>
                </div>

                <div class="col-xs-6 col-sm-6">
                  <div class="form-group">
                    <label class="control-label col-lg-3" style="font-weight: bold;">Status</label>
                    <div class="col-lg-9">
                      <select class="form-control" name="status" id="status" required onchange="showInputField()">
                        <option value="" disabled selected> Pilih Status </option>
                        <?php if ($level === 's_admin' || $level === 'k_arsip') : ?>
                          <option value="BRANGKAS">BRANGKAS</option>
                        <?php endif; ?>
                        <option value="CABANG">CABANG</option>
                        <option value="DIBAWA">DIBAWA</option>
                        <option value="DIAMBIL">DIAMBIL</option>
                        <option value="AGUNAN_DIPUSAT">AGUNAN DIPUSAT</option>
                        <option value="NOTARIS">NOTARIS</option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="col-xs-6 col-sm-6" id="cabangField" style="display: none;">
                  <div class="form-group">
                    <label class="control-label col-lg-3" style="font-weight: bold;">Kantor Cabang</label>
                    <div class="col-lg-9">
                      <select class="form-control" name="cabang" id="cabang" onchange="showInputField()">
                        <option value="" disabled selected> Pilih Cabang </option>
                        <option value="02">SEDAYU</option>
                        <option value="03">SAPURAN</option>
                        <option value="04">KERTEK</option>
                        <option value="05">WONOSOBO</option>
                        <option value="06">KALIWIRO</option>
                        <option value="07">BANJARNEGARA</option>
                        <option value="08">RANDUSARI</option>
                        <option value="09">KEPIL</option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="col-xs-6 col-sm-6" id="pembawaField" style="display: none;">
                  <div class="form-group">
                    <label class="control-label col-lg-3" style="font-weight: bold;">Nama Pembawa</label>
                    <div class="col-lg-9">
                      <input type="text" name="pembawa" id="pembawa" class="form-control" placeholder="Masukkan Nama pembawa">
                    </div>
                  </div>
                </div>

                <div class="col-xs-6 col-sm-6" id="catatanField" style="display: none;">
                  <div class="form-group">
                    <label class="control-label col-lg-3" style="font-weight: bold;">Catatan</label>
                    <div class="col-lg-9">
                      <input type="text" name="catatan_status" id="catatan_status" class="form-control" placeholder="Contoh: REALISASI BARU, RC, TAMBAH PLAFON ">
                    </div>
                  </div>
                </div>

                <div>
                  <div>
                    <input type="hidden" name="penerima" id="penerima" class="form-control" value="<?php echo $nama_lengkap; ?>" readonly>
                  </div>
                </div>
                <button type="submit" id="submit_compressed" class="btn btn-danger" style="float:right;">Simpan</button>
              </div>
            </form>

          </fieldset>
          <span style="color: red; font-size: 10px; font-style: italic; opacity: 0.7;">*Jika nokontrak sudah ada di Data BPKB/SHM maka tidak akan tersimpan</span>

        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $('.msg').html('');

  Dropzone.options.myDropzone = {
    url: "<?php echo base_url('users/agunan_simpan_shm') ?>",
    paramName: "foto_agunan",
    acceptedFiles: "image/jpg,image/jpegimage/bmp",
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

        var nm = $('#nm').val();
        var alamat = $('#alamat').val();
        var kdloc = $('#kdloc').val();
        var noKontrak = $('#nokontrak').val();
        var noReg = $('#noreg').val();
        var jnsDok = $('#jnsdokumen').val();
        var digunakan = $('#digunakan').val();
        var lokasi = $('#lokasi').val();
        var cabang = $('#cabang').val();
        var pembawa = $('#pembawa').val();
        var status = $('#status').val();

        if (nm === '' || alamat === '' || kdloc === '' || noKontrak === '' || noReg === '' || jnsDok === '' || digunakan === '' || lokasi === '' || status === null || status === '') {
          // Jika ada input yang kosong, tampilkan pesan kesalahan dengan Sweet Alert
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Mohon lengkapi semua kolom sebelum menyimpan.',
            confirmButtonColor: '#f44336',
            confirmButtonText: 'OK'
          });
          return; // Berhenti pengiriman formulir
        }

        if (status === 'CABANG' && (cabang === null || cabang === '')) {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Kolom cabang wajib diisi jika status adalah CABANG.',
            confirmButtonColor: '#f44336',
            confirmButtonText: 'OK'
          });
          return;
        }

        if (status === 'DIBAWA' && (pembawa === null || pembawa === '')) {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Kolom pembawa wajib diisi jika status adalah DIBAWA.',
            confirmButtonColor: '#f44336',
            confirmButtonText: 'OK'
          });
          return;
        }

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
          text: 'Data berhasil dikirim.',
          // confirmButtonColor: '#f44336',
          confirmButtonText: 'OK'
        }).then(() => {
          // Redirect after the timer ends
          window.location = "<?php echo base_url(); ?>users/agunan_shm";
        });
      });
    }
  };

  function submitFormWithoutFile() {
    $.ajax({
      type: "POST",
      url: "<?php echo site_url('users/agunan_simpan_shm'); ?>",
      data: $("#myForm").serialize(),
      success: function(response) {
        window.location = "<?php echo base_url(); ?>users/agunan_shm";
      }
    });
  }

  // Capture Image
  function captureImage() {
    if (window.AndroidFunction) {
      window.AndroidFunction.captureImage();
    }
  }
  const cameraIcon = document.getElementById('cameraIcon');

  cameraIcon.addEventListener('click', () => {
    // Tambahkan kelas animasi ke ikon kamera saat diklik
    cameraIcon.classList.add('animate-camera-click');

    // Hapus kelas animasi setelah selesai
    setTimeout(() => {
      cameraIcon.classList.remove('animate-camera-click');
    }, 1000); // Ganti dengan durasi animasi yang diinginkan (dalam milidetik)
  });
  // /Capture Image

  // otomatis nama dan rekening
  $(document).ready(function() {
    // Fungsi saat nilai pada select cari_anggota berubah
    $('.cari_anggota').change(function() {
      var selectedInptgljam = $('option:selected', this).attr('data-inptgljam');
      var selectedNm = $('option:selected', this).attr('data-nm');
      var selectedAlamat = $('option:selected', this).attr('data-alamat');
      var selectedKdloc = $('option:selected', this).attr('data-kdloc');
      var selectedNokontrak = $('option:selected', this).attr('data-nokontrak');
      var selectedNoreg = $('option:selected', this).attr('data-noreg');
      var selectedJnsjamin = $('option:selected', this).attr('data-jnsjamin');
      var selectedDigunakan = $('option:selected', this).attr('data-digunakan');
      var selectedJnsdokumen = $('option:selected', this).attr('data-jnsdokumen');
      var selectedAn = $('option:selected', this).attr('data-an');
      var selectedLokasi = $('option:selected', this).attr('data-lokasi');
      var selectedCatatan = $('option:selected', this).attr('data-catatan');
      var selectedAgunan1 = $('option:selected', this).attr('data-agunan1');
      var selectedAgunan2 = $('option:selected', this).attr('data-agunan2');
      var selectedAgunan3 = $('option:selected', this).attr('data-agunan3');

      $('#inptgljam').val(selectedInptgljam);
      $('#nm').val(selectedNm);
      $('#alamat').val(selectedAlamat);
      $('#kdloc').val(selectedKdloc);
      $('#nokontrak').val(selectedNokontrak);
      $('#noreg').val(selectedNoreg);
      $('#jnsjamin').val(selectedJnsjamin);
      $('#digunakan').val(selectedDigunakan);
      $('#jnsdokumen').val(selectedJnsdokumen);
      $('#an').val(selectedAn);
      $('#lokasi').val(selectedLokasi);
      $('#catatan').val(selectedCatatan);
    });

    // Fungsi saat nilai pada input cari berubah
    $('#cari').on('input', function() {
      var cari = $(this).val();

      // Cek apakah inputan cari berupa nomor rekening atau nama anggota
      var isNokontrak = /^\d+$/.test(cari);

      // Cek setiap opsi pada select cari_anggota
      $('.cari_anggota option').each(function() {
        var optionValue = $(this).val();
        var optionInptgljam = $(this).attr('data-inptgljam');
        var optionNm = $(this).attr('data-nm');
        var optionAlamat = $(this).attr('data-alamat');
        var optionKdloc = $(this).attr('data-kdloc');
        var optionNokontrak = $(this).attr('data-nokontrak');
        var optionNoreg = $(this).attr('data-noreg');
        var optionJnsjamin = $(this).attr('data-jnsjamin');
        var optionDigunakan = $(this).attr('data-digunakan');
        var optionJnsdokumen = $(this).attr('data-jnsdokumen');
        var optionAn = $(this).attr('data-an');
        var optionLokasi = $(this).attr('data-lokasi');
        var optionCatatan = $(this).attr('data-catatan');
        var optionAgunan1 = $(this).attr('data-agunan1');
        var optionAgunan2 = $(this).attr('data-agunan2');
        var optionAgunan3 = $(this).attr('data-agunan3');

        // Jika isNomorRekening true, cari berdasarkan nomor rekening
        // Jika isNomorRekening false, cari berdasarkan nama anggota
        if ((isNoKontrak && optionNokontrak === cari) || (!isNoKontrak && optionNm === cari)) {
          // Set nilai pada select cari_anggota
          $('.cari_anggota').val(optionValue).trigger('change');

          // Keluar dari loop each
          return false;
        }
      });
    });
  });

  // Cari anggota
  $(document).ready(function() {
    $(".cari_anggota").select2({
      ajax: {
        url: "<?php echo base_url('get-agunan-data-shm'); ?>",
        dataType: "json",
        delay: 250,
        processResults: function(data) {
          return {
            results: $.map(data, function(item) {
              return {
                // text: item.nocif + ' - ' + item.nokontrak,
                text: (item.nm || item.nocif) + ' - ' + (item.nokontrak || ''),
                id: item.nokontrak || 0,
                inptgljam: item.inptgljam || 0,
                nm: item.nm || 'N/A',
                alamat: item.alamat || 'N/A',
                kdloc: item.kdloc || 0,
                nokontrak: item.nokontrak || 0,
                noreg: item.noreg || 0,
                jnsjamin: item.jnsjamin || 0,
                digunakan: item.digunakan || 0,
                jnsdokumen: item.jnsdokumen || 0,
                an: item.an || 'N/A',
                lokasi: item.lokasi || 'N/A',
                catatan: item.catatan || 'N/A',
                agunan1: item.agunan1 || '',
                agunan2: item.agunan2 || '',
                agunan3: item.agunan3 || ''
              };
            })
          };
        },
        cache: true
      },
      minimumInputLength: 4
    });

    // Fungsi ini akan dipanggil saat pilihan diubah
    $(".cari_anggota").on("select2:select", function(e) {
      var data = e.params.data;

      // Mengisi input dengan informasi yang sesuai
      $("#inptgljam").val(data.inptgljam);
      $("#nm").val(data.nm);
      $("#alamat").val(data.alamat);
      $("#kdloc").val(data.kdloc);
      $("#nokontrak").val(data.nokontrak);
      $("#noreg").val(data.noreg);
      $("#jnsjamin").val(data.jnsjamin);
      $("#digunakan").val(data.digunakan);
      $("#jnsdokumen").val(data.jnsdokumen);
      $("#an").val(data.an);
      $("#lokasi").val(data.lokasi);
      $("#catatan").val(data.catatan);
      // $('#catatan').val([data.agunan1, data.agunan2, data.agunan3].filter(Boolean).join(', '));
    });

    // Fungsi ini akan dipanggil saat pilihan dibatalkan
    $(".cari_anggota").on("select2:unselect", function() {
      // Mengosongkan input jika pilihan dibatalkan
      $("#inptgljam").val("");
      $("#nm").val("");
      $("#alamat").val("");
      $("#kdloc").val("");
      $("#nokontrak").val("");
      $("#noreg").val("");
      $("#jnsjamin").val("");
      $("#digunakan").val("");
      $("#jnsdokumen").val("");
      $("#an").val("");
      $("#lokasi").val("");
      $("#catatan").val("");
    });
  });
  // /Cari anggota

  function showInputField() {
    var selectedValue = document.getElementById("status").value;

    // Objek untuk memetakan nilai yang dipilih dengan elemen yang ingin ditampilkan
    var elementsToShow = {
      "DIBAWA": "pembawaField",
      "CABANG": "cabangField",
      "AGUNAN_DIPUSAT": "catatanField"
      // Tambahkan nilai lain jika diperlukan
    };

    // Menampilkan atau menyembunyikan elemen berdasarkan nilai yang dipilih
    for (var key in elementsToShow) {
      if (selectedValue === key) {
        document.getElementById(elementsToShow[key]).style.display = "block";
      } else {
        document.getElementById(elementsToShow[key]).style.display = "none";
      }
    }
  }

  // Mendapatkan elemen input teks
  var pembawaInput = document.getElementById('pembawa');

  // Menambahkan event listener untuk memantau perubahan pada input
  pembawaInput.addEventListener('input', function() {
    // Mengonversi nilai input menjadi huruf kapital
    this.value = this.value.toUpperCase();
  });

  function syncManualInput(manualInputId, hiddenInputId) {
    var manualInputValue = document.getElementById(manualInputId).value;
    document.getElementById(hiddenInputId).value = manualInputValue;
  }

  // Function to toggle manual input fields
  function toggleManualInput() {
    var inputManualCheckbox = document.getElementById('inputManualCheckbox');
    var nmManual = document.getElementById('nm_manual');
    var alamatManual = document.getElementById('alamat_manual');
    var kdlocManual = document.getElementById('kdloc_manual');
    var nokontrakManual = document.getElementById('nokontrak_manual');
    var noregManual = document.getElementById('noreg_manual');
    var jnsjaminManual = document.getElementById('jnsjamin_manual');
    var digunakanManual = document.getElementById('digunakan_manual');
    var jnsdokumenManual = document.getElementById('jnsdokumen_manual');
    var anManual = document.getElementById('an_manual');
    var lokasiManual = document.getElementById('lokasi_manual');
    var catatanManual = document.getElementById('catatan_manual');

    if (inputManualCheckbox.checked) {
      // Jika checkbox dicentang, tampilkan input manual
      nmManual.style.display = 'block';
      alamatManual.style.display = 'block';
      kdlocManual.style.display = 'block';
      nokontrakManual.style.display = 'block';
      noregManual.style.display = 'block';
      jnsjaminManual.style.display = 'block';
      digunakanManual.style.display = 'block';
      jnsdokumenManual.style.display = 'block';
      anManual.style.display = 'block';
      lokasiManual.style.display = 'block';
      catatanManual.style.display = 'block';

    } else {
      // Jika checkbox tidak dicentang, sembunyikan input manual
      nmManual.style.display = 'none';
      alamatManual.style.display = 'none';
      kdlocManual.style.display = 'none';
      nokontrakManual.style.display = 'none';
      noregManual.style.display = 'none';
      jnsjaminManual.style.display = 'none';
      digunakanManual.style.display = 'none';
      jnsdokumenManual.style.display = 'none';
      anManual.style.display = 'none';
      lokasiManual.style.display = 'none';
      catatanManual.style.display = 'none';
    }
  }
</script>
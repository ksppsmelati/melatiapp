<?php
$cek = $user->row();
$id_user = $cek->id_user;

$this->db->order_by('id_sm', 'DESC');
$this->db->limit(1);
$cek_ns = $this->db->get('tbl_sm');
if ($cek_ns->num_rows() == 0) {
} else {
}
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

  /* Upload text */
  .upload-text {
    font-size: 16px;
    color: #555;
    margin-bottom: 5px;
  }

  /* Required message */
  .required {
    color: red;
    font-style: italic;
    margin-top: 10px;
    font-size: 12px;
  }

  /* Membuat select box responsif */
  select.form-control {
    width: 100%;
    max-width: 100%;
    padding: 8px;
    /* Sesuaikan dengan kebutuhan Anda */
    box-sizing: border-box;
  }

  /* Membuat label responsif */
  label.control-label {
    display: block;
    /* Membuat label menjadi elemen block */
    text-align: left;
    /* Sesuaikan dengan tata letak Anda */
    margin-bottom: 10px;
    /* Sesuaikan dengan kebutuhan Anda */
  }

  /* Mengatur tampilan kolom input saat fokus */
  #nominal:focus,
  #nomor_rekening_manual:focus,
  #nama_anggota_manual:focus,
  #kode_kantor_manual:focus {
    border-color: #f44336;
    /* Warna border saat fokus */
    box-shadow: 0 0 10px rgba(76, 175, 80, 0.5);
    /* Efek bayangan saat fokus */
    font-size: 16px;
    /* Menampilkan teks tebal saat fokus */
    outline: none;
    /* Menghilangkan outline default saat fokus */
  }
</style>

<link rel="stylesheet" type="text/css" href="assets/upload/dropzone.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.css">

<script src="assets/js/select2.min.js"></script>`
<script src="assets/js/jquery-ui.js"></script>
<script type="text/javascript" src="assets/js/core/app.js"></script>
<script type="text/javascript" src="assets/upload/dropzone.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.js"></script>

<div class="container">
  <div class="content">
    <div class="row">
      <div class="panel panel-flat">
        <div class="panel-body">
          <div class="navigation-buttons">
            <div class="btn-group" style="float: left;">
              <!-- Tombol Back (di pojok kiri atas) -->
              <i class="fa fa-inbox"></i> Tambah Data Otorisasi
            </div>
            <div class="navigation-buttons text-right">
              <div class="btn-group">
                <input type="checkbox" id="inputManualCheckbox" onchange="toggleManualInput()">
                <small for="inputManualCheckbox">Input Manual</small>
              </div>
            </div>
          </div>
          <div class="clearfix"></div>
          <fieldset class="content-group">
            <?php
            echo $this->session->flashdata('msg');
            ?>
            <div class="msg"></div>
            <form class="form-horizontal" action="users/sm" enctype="multipart/form-data" method="post">
              <div class="form-group">
                <div class="col-lg-4 col-sm-4" style="display: none;">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="icon-calendar" style="pointer-events: none;"></i></span>
                    <input type="text" name="tgl_no_asal" class="form-control daterange-single" id="tgl_no_asal" style="pointer-events: none;">
                    <script>
                      // Mendapatkan elemen input tanggal
                      var tglNoAsalInput = document.getElementById('tgl_no_asal');

                      // Mendapatkan waktu sekarang
                      var now = new Date();

                      // Format waktu menjadi 'dd-mm-yyyy HH:ii:ss'
                      var formattedDate = ('0' + now.getDate()).slice(-2) + '-' + ('0' + (now.getMonth() + 1)).slice(-2) + '-' + now.getFullYear();
                      var formattedTime = ('0' + now.getHours()).slice(-2) + ':' + ('0' + now.getMinutes()).slice(-2) + ':' + ('0' + now.getSeconds()).slice(-2);

                      // Mengatur nilai input tanggal
                      tglNoAsalInput.value = formattedDate + ' ' + formattedTime;
                    </script>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-lg-3" style="font-weight: bold;">Cari Anggota</label>
                <div class="col-lg-9">
                  <select class="form-control cari_anggota" name="cari_anggota" required>
                    <option value="" disabled selected>Cari Nama / No. Tabungan</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-lg-3" style="font-weight: bold;">Nama Anggota</label>
                <div class="col-lg-9">
                  <input type="text" name="nama_anggota" id="nama_anggota" class="form-control" required readonly>
                  <input type="text" name="nama_anggota_manual" id="nama_anggota_manual" class="form-control" placeholder="Nama Anggota (Input Manual)" oninput="syncManualInput('nama_anggota_manual', 'nama_anggota')" style="display: none;">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-lg-3" style="font-weight: bold;">No. Rekening</label>
                <div class="col-lg-9">
                  <input type="number" name="nomor_rekening" id="nomor_rekening" class="form-control" required readonly>
                  <input type="number" name="nomor_rekening_manual" id="nomor_rekening_manual" class="form-control" placeholder="No. Rekening (Input Manual)" oninput="syncManualInput('nomor_rekening_manual', 'nomor_rekening')" style="display: none;">
                </div>
              </div>

              <script>
                function syncManualInput(manualInputId, hiddenInputId) {
                  var manualInputValue = document.getElementById(manualInputId).value;
                  document.getElementById(hiddenInputId).value = manualInputValue;
                }
              </script>

              <div class="form-group" style="display: none;">
                <label class="control-label col-lg-3">Saldo Akhir</label>
                <div class="col-lg-9">
                  <input type="text" name="sahirrp" id="sahirrp" class="form-control" required readonly>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-lg-3" style="font-weight: bold;">Kode Kantor</label>
                <div class="col-lg-9">
                  <input type="number" name="kode_kantor" id="kode_kantor" class="form-control" required readonly>
                  <select name="kode_kantor_manual" id="kode_kantor_manual" class="form-control" onchange="syncManualInput('kode_kantor_manual', 'kode_kantor')" style="display: none;">
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
              <div class="form-group" style="display: none;">
                <label class="control-label col-lg-3">Kode Produk</label>
                <div class="col-lg-9">
                  <input type="text" name="kode_devisi" id="kode_devisi" class="form-control" required readonly>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-lg-3" style="font-weight: bold;">Nominal Otorisasi</label>
                <div class="col-lg-9">
                  <div class="input-group">
                    <span class="input-group-addon">Rp</span>
                    <input type="text" name="nominal" id="nominal" class="form-control" placeholder="Masukkan nominal" required inputmode="numeric" pattern="[0-9]*">
                  </div>
                </div>
              </div>


              <div class="form-group">
                <div class="col-lg-12">
                  <div class="dropzone" id="myDropzone">
                    <div class="dz-message">
                      <i class="fas fa-camera-retro" id="cameraIcon" onclick="captureImage()"></i>
                      <p class="upload-text">Ambil Foto</p>
                    </div>
                  </div>
                  <span class="required">*Foto wajib diisi</span>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-lg-3" style="font-weight: bold;">Tanggal Transaksi</label>
                <div class="col-lg-9">
                  <input type="date" name="tgl_transaksi" id="tgl_transaksi" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                </div>
                <span class="required">*Ubah jika tanggal transaksi berbeda dengan tanggal input</span>
              </div>

              <div class="form-group">
                <label class="control-label col-lg-3">Keterangan</label>
                <div class="col-lg-9">
                  <input type="text" name="keterangan" id="keterangan" class="form-control" placeholder="Keterangan (opsional)">
                </div>
              </div>

              <div class="form-group" style="display: none;">
                <label class="control-label col-lg-3">Tanggal SM</label>
                <div class="col-lg-9">
                  <input type="date" name="tgl_sm_date" id="tgl_sm_date" class="form-control" value="<?= date('Y-m-d'); ?>" required>
                </div>
              </div>

              <div class="form-group" style="float:left;">
                <div class="col-xs-12 col-sm-12">
                <a href="<?php echo site_url('users/file_user_surat_kuasa_by_id_user/'); ?>" class="btn btn-light btn-xs" style="background-color: #6c757d; color: white;"><i class="fa-solid fa-people-arrows" aria-hidden="true"></i> Surat Kuasa</a>
                </div>
              </div>

              <div class="form-group" style="float:right;">
                <div class="col-xs-12 col-sm-12">
                  <!-- <label for="id_surat">Surat Kuasa</label> -->
                  <select class="form-control cari_surat" name="id_surat" id="id_surat">
                    <option value="" disabled selected>Pilih Surat Kuasa</option>
                    <?php
                    $surat_kuasa = $this->db->where('category', 'surat_kuasa')->where('id_user', $id_user)->get('tbl_file_user')->result();
                    // $users = $this->db->get('tbl_user')->result();
                    foreach ($surat_kuasa as $surat) {
                      echo "<option value='{$surat->id}'>{$surat->nama} ( {$surat->description} )</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>

              <div class="clearfix"></div>
              <hr>
              <a href="users/sm" class="btn btn-default">
                << Kembali</a>
                  <button type="submit" id="submit-all" class="btn btn-danger" style="float:right;">Simpan</button>
            </form>

          </fieldset>
          <!-- penerima dokumen hanya yang mempunyai level s_admin-->
          <div>
            <div>
              <?php
              $this->db->where('level', 's_admin');
              $this->db->order_by('nama_lengkap', 'ASC');
              $result = $this->db->get('tbl_user')->result();
              $namaLengkap = '';
              if (!empty($result)) {
                $namaLengkap = $result[0]->nama_lengkap;
              }
              ?>
              <input type="text" name="penerima" id="penerima" class="form-control" value="<?php echo $namaLengkap; ?>" readonly style="display: none;">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $('.msg').html('');
  Dropzone.options.myDropzone = {
    // Prevents Dropzone from uploading dropped files immediately
    url: "<?php echo base_url('users/sm') ?>",
    paramName: "userfile",
    acceptedFiles: "image/jpg,image/jpeg,image/bmp",
    autoProcessQueue: false,
    maxFilesize: 10, //MB
    parallelUploads: 1,
    maxFiles: 1,
    addRemoveLinks: true,
    dictCancelUploadConfirmation: "Yakin ingin membatalkan upload ini?",
    dictInvalidFileType: "Type file ini tidak dizinkan",
    dictFileTooBig: "File yang Anda Upload terlalu besar {{filesize}} MB. Maksimal Upload {{maxFilesize}} MB",
    dictRemoveFile: "Hapus",
    renameFile: function(file) {
      var now = new Date();
      var timestamp = now.getTime(); // Gunakan timestamp sebagai nama file
      var randomNum = Math.floor(Math.random() * 1000); // Angka acak antara 0 dan 999
      var fileExtension = file.name.split('.').pop(); // Dapatkan ekstensi file

      // Gabungkan timestamp, angka acak, dan ekstensi file untuk mendapatkan nama file yang unik
      var fileName = timestamp + '-' + randomNum + '.' + fileExtension;

      return fileName;
    },


    init: function() {
      var submitButton = document.querySelector("#submit-all")
      myDropzone = this; // closure

      submitButton.addEventListener("click", function(e) {
        e.preventDefault();
        e.stopPropagation();

        var namaAnggota = $('#nama_anggota').val();
        var nomorRekening = $('#nomor_rekening').val();
        var kodeKantor = $('#kode_kantor').val();
        var nominal = $('#nominal').val();

        if (namaAnggota === '' || nomorRekening === '' || kodeKantor === '' || nominal === '') {
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

        myDropzone.processQueue(); // Tell Dropzone to process all queued files.
      });

      // You might want to show the submit button only when

      this.on("error", function(file, message) {
        alert(message);
        this.removeFile(file);
        errors = true;
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


      this.on("sending", function(data, xhr, formData) {
        formData.append("ns", jQuery("#ns").val());
        formData.append("tgl_ns", jQuery("#tgl_ns").val());
        formData.append("no_asal", jQuery("#no_asal").val());
        formData.append("tgl_no_asal", jQuery("#tgl_no_asal").val());
        formData.append("tgl_sm_date", jQuery("#tgl_sm_date").val());
        formData.append("tgl_transaksi", jQuery("#tgl_transaksi").val());
        formData.append("pengirim", jQuery("#pengirim").val());
        formData.append("penerima", jQuery("#penerima").val());
        formData.append("nominal", jQuery("#nominal").val());
        formData.append("keterangan", jQuery("#keterangan").val());
        formData.append("nama_anggota", jQuery("#nama_anggota").val());
        formData.append("nomor_rekening", jQuery("#nomor_rekening").val());
        formData.append("kode_kantor", jQuery("#kode_kantor").val());
        formData.append("kode_devisi", jQuery("#kode_devisi").val());
        formData.append("id_surat", jQuery("#id_surat").val());
      });

      this.on("complete", function(file) {
        //Event ketika Memulai mengupload
        myDropzone.removeFile(file);
      });

      this.on("success", function(file, response) {
        $(".cari_ns").select2({
          placeholder: "Pilih nomor",
          allowClear: true
        });
        $(".cari_ns").val('').trigger('change');
        $('.form-horizontal')[0].reset();

        // Menggunakan SweetAlert untuk menampilkan alert
        Swal.fire({
          icon: 'success',
          title: 'Sukses!',
          text: 'Data Otorisai berhasil dikirim.',
          showCancelButton: true,
          confirmButtonColor: '#5cb85c',
          cancelButtonColor: '#D3D3D3',
          confirmButtonText: 'Tambah Kritik Saran',
          cancelButtonText: 'Tidak'
        }).then((result) => {
          if (result.isConfirmed) {
            // Show the Kritik Saran modal
            window.location = "<?php echo base_url(); ?>users/kritik_saran_tambah";
          } else if (result.dismiss === Swal.DismissReason.cancel) {
            // Redirect to Monitoring page
            window.location = "<?php echo base_url(); ?>users/sm";
          }
        });

        // Fokus pada elemen dengan id "no_asal"
        $("#no_asal").focus();

        myDropzone.removeFile(file);
      });

    }
  };

  // otomatis nama dan rekening
  $(document).ready(function() {
    // Fungsi saat nilai pada select cari_anggota berubah
    $('.cari_anggota').change(function() {
      var selectedNama = $('option:selected', this).attr('data-nama');
      var selectedRekening = $('option:selected', this).attr('data-rekening');
      $('#nama_anggota').val(selectedNama);
      $('#nomor_rekening').val(selectedRekening);
    });

    // Fungsi saat nilai pada input cari berubah
    $('#cari').on('input', function() {
      var cari = $(this).val();

      // Cek apakah inputan cari berupa nomor rekening atau nama anggota
      var isNomorRekening = /^\d+$/.test(cari);

      // Cek setiap opsi pada select cari_anggota
      $('.cari_anggota option').each(function() {
        var optionValue = $(this).val();
        var optionNama = $(this).attr('data-nama');
        var optionRekening = $(this).attr('data-rekening');

        // Jika isNomorRekening true, cari berdasarkan nomor rekening
        // Jika isNomorRekening false, cari berdasarkan nama anggota
        if ((isNomorRekening && optionRekening === cari) || (!isNomorRekening && optionNama === cari)) {
          // Set nilai pada select cari_anggota
          $('.cari_anggota').val(optionValue).trigger('change');

          // Keluar dari loop each
          return false;
        }
      });
    });
  });

  $(function() {
    $("#tgl_ns").datepicker();
  });
  $(function() {
    $("#tgl_no_asal").datepicker();
  });

  // Cari anggota
  $(document).ready(function() {
    $(".cari_anggota").select2({
      ajax: {
        url: "<?php echo base_url('get-anggota-data'); ?>",
        dataType: "json",
        delay: 250,
        processResults: function(data) {
          return {
            results: $.map(data, function(item) {
              return {
                text: item.fnama + ' - ' + item.notab,
                id: item.notab,
                nama: item.fnama,
                rekening: item.notab,
                sahirrp: item.sahirrp,
                kode_kantor: item.kodeloc,
                kode_devisi: item.kodeprd
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
      $("#nama_anggota").val(data.nama);
      $("#nomor_rekening").val(data.rekening);
      $("#kode_kantor").val(data.kode_kantor);
      $("#kode_devisi").val(data.kode_devisi);
      var formattedSahirrp = formatRupiah(data.sahirrp);
      $("#sahirrp").val(formattedSahirrp);
    });


    // Fungsi ini akan dipanggil saat pilihan dibatalkan
    $(".cari_anggota").on("select2:unselect", function() {
      // Mengosongkan input jika pilihan dibatalkan
      $("#nama_anggota").val("");
      $("#nomor_rekening").val("");
      $("#kode_kantor").val("");
      $("#kode_devisi").val("");
    });
    $('.cari_surat').select2();
  });
  // /Cari anggota

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

  // Function to toggle manual input fields
  function toggleManualInput() {
    var inputManualCheckbox = document.getElementById('inputManualCheckbox');
    var namaAnggotaManual = document.getElementById('nama_anggota_manual');
    var nomorRekeningManual = document.getElementById('nomor_rekening_manual');
    var kodeKantorManual = document.getElementById('kode_kantor_manual');

    if (inputManualCheckbox.checked) {
      // Jika checkbox dicentang, tampilkan input manual
      namaAnggotaManual.style.display = 'block';
      nomorRekeningManual.style.display = 'block';
      kodeKantorManual.style.display = 'block';
    } else {
      // Jika checkbox tidak dicentang, sembunyikan input manual
      namaAnggotaManual.style.display = 'none';
      nomorRekeningManual.style.display = 'none';
      kodeKantorManual.style.display = 'none';
    }
  }

  // Fungsi untuk mengubah format nominal menjadi format Rupiah saat pengguna mengetik
  function formatRupiah(angka) {
    var reverse = angka.toString().split('').reverse().join('');
    var ribuan = reverse.match(/\d{1,3}/g);
    ribuan = ribuan.join('.').split('').reverse().join('');
    return 'Rp ' + ribuan;
  }

  // Fungsi untuk menghapus tanda pemisah ribuan saat nilai disimpan dalam variabel
  function unformatRupiah(rupiah) {
    return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);
  }

  // Menerapkan format Rupiah saat pengguna mengetik
  document.getElementById('nominal').addEventListener('input', function(e) {
    var input = e.target.value;
    // Menghapus karakter selain angka dan tanda koma
    var cleanedInput = input.replace(/[^\d,]/g, '');
    // Mengubah nilai input menjadi format Rupiah
    e.target.value = formatRupiah(cleanedInput);
  });

  // Menghapus format Rupiah saat nilai disalin dari clipboard ke input
  document.getElementById('nominal').addEventListener('paste', function(e) {
    e.preventDefault();
    var pasteData = e.clipboardData.getData('text/plain');
    var cleanedInput = pasteData.replace(/[^\d,]/g, '');
    e.target.value = formatRupiah(cleanedInput);
  });

  // Menghapus format Rupiah saat nilai disalin dari input
  document.getElementById('nominal').addEventListener('blur', function(e) {
    var input = e.target.value;
    // Menghapus format Rupiah sebelum menyimpan nilai ke dalam variabel
    e.target.value = unformatRupiah(input);
  });
</script>
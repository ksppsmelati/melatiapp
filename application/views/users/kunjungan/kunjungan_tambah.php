<?php
$cek = $user->row();
$level = $cek->level;
$username = $cek->username;
$id_user = $cek->id_user;
$kode_kantor = $cek->kode_kantor;
$nama_lengkap = $cek->nama_lengkap;
?>

<style>
  .file-upload-group {
    margin-bottom: 10px;
  }

  .img-preview {
    display: block;
    margin-top: 10px;
    margin-bottom: 10px;
    max-width: 100%;
    height: auto;
    border: 1px solid #ddd;
    border-radius: 4px;
    max-height: 100px;
    transition: all 0.3s ease;
  }

  .preview-container {
    display: flex;
    justify-content: center;
    align-items: center;
  }

  input[type="file"] {
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 10px;
    background-color: #f9f9f9;
    transition: border 0.3s ease;
  }

  input[type="file"]:focus {
    border-color: #007bff;
    outline: none;
  }

  .form-group label {
    font-weight: bold;
  }
</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.css">
<script src="assets/js/select2.min.js"></script>
<script src="assets/js/jquery-ui.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.js"></script>



<div class="container">
  <div class="content">
    <div class="row">
      <div class="panel panel-flat">
        <div class="panel-body">
          <fieldset class="content-group">
            <div class="navigation-buttons">
              <div class="btn-group" style="float: left;">
                <i class="fa fa-television"></i> Tambah Kunjungan
              </div>
              <div class="btn-group" style="float: right;">
                <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-bars"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-right" role="menu">
                  <li><a href="<?php echo site_url ('users/kunjungan_data'); ?>"><i class="fa fa-television"></i> Data Kunjungan</a></li>
                </ul>
              </div>
            </div>
            <div class="clearfix"></div>
            <hr>

            <form class="form-horizontal" id="myForm" action="users/kunjungan_simpan" enctype="multipart/form-data" method="post">
              <div class="row">
                <div class="col-xs-12 col-sm-12">
                  <div style="float: right;">
                    <div class="form-group">
                      <label for="kode_kantor">Kantor<span style="color: red;">*</span></label><br>
                      <select class="form-control" name="kode_kantor" id="kode_kantor" required>
                        <option value="" <?php echo ($kode_kantor == '') ? 'selected' : ''; ?>>- Pilih Kantor -</option>
                        <option value="01" <?php echo ($kode_kantor == '01') ? 'selected' : ''; ?>>PUSAT</option>
                        <option value="02" <?php echo ($kode_kantor == '02') ? 'selected' : ''; ?>>SEDAYU</option>
                        <option value="03" <?php echo ($kode_kantor == '03') ? 'selected' : ''; ?>>SAPURAN</option>
                        <option value="04" <?php echo ($kode_kantor == '04') ? 'selected' : ''; ?>>KERTEK</option>
                        <option value="05" <?php echo ($kode_kantor == '05') ? 'selected' : ''; ?>>WONOSOBO</option>
                        <option value="06" <?php echo ($kode_kantor == '06') ? 'selected' : ''; ?>>KALIWIRO</option>
                        <option value="07" <?php echo ($kode_kantor == '07') ? 'selected' : ''; ?>>BANJARNEGARA</option>
                        <option value="08" <?php echo ($kode_kantor == '08') ? 'selected' : ''; ?>>RANDUSARI</option>
                        <option value="09" <?php echo ($kode_kantor == '09') ? 'selected' : ''; ?>>KEPIL</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="clearfix"></div>
                <!-- Tanggal -->
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label col-md-3">Tanggal</label>
                    <div class="col-md-9">
                      <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?php echo date('Y-m-d'); ?>" required readonly>
                    </div>
                  </div>
                </div>

                <!-- Nama Anggota -->
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label col-md-3">Nama Anggota</label>
                    <div class="col-md-9">
                      <input type="text" name="nama" id="nama" class="form-control" required>
                    </div>
                  </div>
                </div>

                <!-- Alamat -->
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label col-md-3">Alamat</label>
                    <div class="col-md-9">
                      <input type="text" name="alamat" id="alamat" class="form-control" required>
                    </div>
                  </div>
                </div>

                <!-- Tujuan -->
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label col-md-3">Tujuan<span style="color: red;">*</span></label>
                    <div class="col-md-9">
                      <select class="form-control" name="tujuan" id="tujuan" required>
                        <option value="" disabled selected>Pilih Tujuan</option>
                        <option value="PENAGIHAN">PENAGIHAN</option>
                        <option value="SURVEY">SURVEY</option>
                        <option value="PROMOSI">PROMOSI</option>
                        <option value="KOLEKTING">KOLEKTING</option>
                        <option value="LAINNYA">LAINNYA</option>
                      </select>
                    </div>
                  </div>
                </div>

                <!-- Lokasi -->
                <div class="col-md-6" style="display: none;">
                  <div class="form-group">
                    <label class="control-label col-md-3">Lokasi (Latitude, Longitude)</label>
                    <div class="col-md-9">
                      <input type="text" name="lokasi" id="lokasi" class="form-control" readonly required>
                    </div>
                  </div>
                </div>

                <!-- Foto -->
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label col-md-3">Foto <span style="color: red;">*</span></label>
                    <div class="col-md-9">
                      <input type="file" name="foto_kunjungan" id="foto_kunjungan" class="form-control" accept="image/*" onchange="previewImage(event, 'preview1')" required>
                      <img id="preview1" class="img-preview" alt="Preview foto kunjungan" style="display: none;" />
                    </div>
                  </div>
                </div>

                <!-- Keterangan -->
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label">Keterangan<span style="color: red;">*</span></label>
                    <textarea name="keterangan" id="keterangan" class="form-control" rows="3" required></textarea>
                  </div>
                </div>

                <!-- Catatan -->
                <div class="col-md-6" style="display: none;">
                  <div class="form-group">
                    <label class="control-label col-md-3">Catatan</label>
                    <div class="col-md-9">
                      <input type="text" name="catatan" id="catatan" class="form-control">
                    </div>
                  </div>
                </div>

                <!-- ID User -->
                <div class="col-md-6" style="display: none;">
                  <div class="form-group">
                    <label class="control-label col-md-3">ID User</label>
                    <div class="col-md-9">
                      <input type="text" name="id_user" id="id_user" class="form-control" required readonly value="<?php echo $id_user; ?>">
                    </div>
                  </div>
                </div>

                <div class="col-md-6" style="display: none;">
                  <div class="form-group">
                    <label class="control-label col-md-3">Inpuser</label>
                    <div class="col-md-9">
                      <input type="text" name="inpuser" id="inpuser" class="form-control" required readonly value="<?php echo $nama_lengkap; ?>">
                    </div>
                  </div>
                </div>

              </div>

              <!-- Button Simpan -->
              <div class="form-group">
                <div class="col-md-12 text-right">
                  <button type="submit" id="submitButton" class="btn btn-danger">Simpan</button>
                </div>
              </div>
            </form>
            <div id="loadingSpinner" style="display: none; text-align: center; padding: 10px;">
              <i class="fa fa-spinner fa-spin" style="font-size: 24px;"></i> Processing...
            </div>
          </fieldset>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/compressorjs@1.0.7/dist/compressor.min.js"></script>

<script>
  document.querySelectorAll('input[type="file"]').forEach(function(input) {
    input.addEventListener('change', function(event) {
      const file = event.target.files[0];

      if (file) {
        // Gunakan Compressor.js untuk melakukan kompresi
        new Compressor(file, {
          quality: 0.3, // Menyesuaikan kualitas kompresi (0 - 1)
          success(result) {
            // Membuat nama file unik dengan menggabungkan timestamp dan nama input
            const inputName = input.getAttribute('name');
            const timestamp = Date.now();
            const fileExtension = file.name.split('.').pop(); // Ekstensi file asli
            const uniqueFileName = inputName + '_' + timestamp + '.' + fileExtension; // Nama file unik
            const compressedFile = new File([result], uniqueFileName, {
              type: result.type,
              lastModified: timestamp
            });
            // Gantikan file input dengan file yang sudah dikompres
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(compressedFile);
            input.files = dataTransfer.files; // Mengganti file di input
            console.log('File berhasil dikompres dengan nama unik:', compressedFile);
          },
          error(err) {
            console.error('Gagal melakukan kompresi:', err.message);
          },
        });
      }
    });
  });

  function previewImage(event, previewId) {
    const file = event.target.files[0];
    const previewElement = document.getElementById(previewId);

    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        previewElement.src = e.target.result; // Set src dari preview ke hasil pembacaan
        previewElement.style.display = 'block'; // Tampilkan gambar preview
      }
      reader.readAsDataURL(file); // Baca file sebagai Data URL
    } else {
      previewElement.src = ""; // Kosongkan src jika tidak ada file
      previewElement.style.display = 'none'; // Sembunyikan gambar preview
    }
  }

  document.getElementById('myForm').addEventListener('submit', function(event) {
    // Disable the submit button to prevent double submission
    document.getElementById('submitButton').disabled = true;

    // Show loading spinner
    document.getElementById('loadingSpinner').style.display = 'block';

    // Optionally, you can also show a loading message
    document.getElementById('submitButton').textContent = 'Processing...';

    // Allow the form to submit normally
  });

  // Periksa apakah browser mendukung Geolocation API
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var latitude = position.coords.latitude;
      var longitude = position.coords.longitude;

      // Masukkan latitude dan longitude ke dalam input form
      document.getElementById('lokasi').value = latitude + ", " + longitude;

    }, function(error) {
      console.log('Error mendapatkan lokasi: ', error.message);
    });
  } else {
    alert("Geolocation tidak didukung oleh browser ini.");
  }
</script>
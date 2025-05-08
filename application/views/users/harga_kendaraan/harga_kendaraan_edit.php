<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Proses input file
  if (!empty($_FILES['foto']['name'])) {
    $config['upload_path'] = './foto/kendaraan/';
    $config['allowed_types'] = 'jpg|jpeg|png|gif';
    $config['max_size'] = 2048; // maksimum 2 MB, sesuaikan kebutuhan

    $this->load->library('upload', $config);

    if ($this->upload->do_upload('foto')) {
      $upload_data = $this->upload->data();
      $foto_path = $upload_data['file_name'];

      // Lakukan hal lain sesuai kebutuhan
      // Update path ke database jika diperlukan
    } else {
      $error = array('error' => $this->upload->display_errors());
      print_r($error);
    }
  }

  // Lakukan hal lain sesuai kebutuhan
}
?>
<!-- Main content -->
<div class="content-wrapper">
  <!-- Content area -->
  <div class="content">
    <div class="container">
      <!-- Dashboard content -->
      <div class="row">

        <div class="panel panel-flat">
          <div class="panel-body">
            <fieldset class="content-group">
              <legend class="text-bold"><i class="fa fa-car"></i> <strong>Edit Harga Kendaraan</strong></legend>
              <?php echo $this->session->flashdata('msg'); ?>
              <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label class="control-label col-lg-3"><strong>Merek</strong></label>
                  <div class="col-lg-9">
                    <input type="text" name="merek" class="form-control" value="<?php echo $query->merek; ?>" placeholder="Merek" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-lg-3"><strong>Model</strong></label>
                  <div class="col-lg-9">
                    <input type="text" name="model" class="form-control" value="<?php echo $query->model; ?>" placeholder="Model" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-lg-3"><strong>Tahun</strong></label>
                  <div class="col-lg-9">
                    <input type="number" name="tahun" class="form-control" value="<?php echo $query->tahun; ?>" placeholder="Tahun" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-lg-3"><strong>Harga Jual</strong></label>
                  <div class="col-lg-9">
                    <input type="number" name="harga_jual" class="form-control" value="<?php echo isset($query->harga_jual) ? $query->harga_jual : ''; ?>" placeholder="Harga Jual" step="any">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-lg-3"><strong>Foto</strong></label>
                  <div class="col-lg-9">
                    <input type="file" name="foto" class="form-control" accept="image/*">
                    <?php if (!empty($harga_kendaraan_detail->foto)) : ?>
                      <?php
                      $imageURL = base_url('foto/kendaraan/' . $harga_kendaraan_detail->foto);
                      ?>
                      <img src="<?php echo $imageURL; ?>" alt="Foto" style="max-width: 50px;">
                    <?php endif; ?>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-lg-3"><strong>Transmisi</strong></label>
                  <div class="col-lg-9">
                    <select name="transmisi" class="form-control">
                      <option value="Manual" <?php echo ($query->transmisi == 'Manual') ? 'selected' : ''; ?>>Manual</option>
                      <option value="Automatic" <?php echo ($query->transmisi == 'Automatic') ? 'selected' : ''; ?>>Automatic</option>
                      <!-- Add more options as needed -->
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-lg-3"><strong>Bahan Bakar</strong></label>
                  <div class="col-lg-9">
                    <select name="bahan_bakar" class="form-control">
                      <!-- <option value="Pertamax" <?php echo ($query->bahan_bakar == 'Pertamax') ? 'selected' : ''; ?>>Pertamax</option>
                      <option value="Pertalite" <?php echo ($query->bahan_bakar == 'Pertalite') ? 'selected' : ''; ?>>Pertalite</option> -->
                      <option value="Bensin" <?php echo ($query->bahan_bakar == 'Bensin') ? 'selected' : ''; ?>>Bensin</option>
                      <option value="Solar" <?php echo ($query->bahan_bakar == 'Solar') ? 'selected' : ''; ?>>Solar</option>
                      <!-- Add more options as needed -->
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-lg-3"><strong>Kapasitas Mesin</strong></label>
                  <div class="col-lg-9">
                    <select name="kapasitas_mesin" class="form-control" id="kapasitas_mesin_select">
                      <option value="">Pilih Kapasitas Mesin</option>
                      <option value="1000" <?php echo ($query->kapasitas_mesin == '1000') ? 'selected' : ''; ?>>1000 CC</option>
                      <option value="1200" <?php echo ($query->kapasitas_mesin == '1200') ? 'selected' : ''; ?>>1200 CC</option>
                      <option value="1500" <?php echo ($query->kapasitas_mesin == '1500') ? 'selected' : ''; ?>>1500 CC</option>
                      <option value="2000" <?php echo ($query->kapasitas_mesin == '2000') ? 'selected' : ''; ?>>2000 CC</option>
                      <option value="2500" <?php echo ($query->kapasitas_mesin == '2500') ? 'selected' : ''; ?>>2500 CC</option>
                      <!-- Add more options for cars as needed -->

                      <option value="100" <?php echo ($query->kapasitas_mesin == '100') ? 'selected' : ''; ?>>100 CC</option>
                      <option value="110" <?php echo ($query->kapasitas_mesin == '110') ? 'selected' : ''; ?>>110 CC</option>
                      <option value="125" <?php echo ($query->kapasitas_mesin == '125') ? 'selected' : ''; ?>>125 CC</option>
                      <option value="150" <?php echo ($query->kapasitas_mesin == '150') ? 'selected' : ''; ?>>150 CC</option>
                      <option value="155" <?php echo ($query->kapasitas_mesin == '155') ? 'selected' : ''; ?>>155 CC</option>
                      <option value="200" <?php echo ($query->kapasitas_mesin == '200') ? 'selected' : ''; ?>>200 CC</option>
                      <!-- Add more options for motorcycles as needed -->

                      <option value="custom">Input Manual</option>
                    </select>

                    <!-- Input manual untuk kapasitas mesin -->
                    <input type="text" name="kapasitas_mesin_manual" class="form-control mt-2" id="kapasitas_mesin_manual" placeholder="Input Kapasitas Mesin" <?php echo ($query->kapasitas_mesin == 'custom') ? 'value="' . $query->kapasitas_mesin_manual . '"' : 'style="display:none;"'; ?>>
                  </div>
                </div>

                <!-- Script untuk menangani tampilan input manual -->
                <script>
                  document.getElementById('kapasitas_mesin_select').addEventListener('change', function() {
                    var inputManual = document.getElementById('kapasitas_mesin_manual');
                    if (this.value === 'custom') {
                      inputManual.style.display = 'block';
                    } else {
                      inputManual.style.display = 'none';
                    }
                  });
                </script>


                <div class="form-group">
                  <label class="control-label col-lg-3"><strong>Jenis Kendaraan</strong></label>
                  <div class="col-lg-9">
                    <select name="jenis_kendaraan" class="form-control" required>
                      <option value="motor" <?php echo ($query->jenis_kendaraan == 'motor') ? 'selected' : ''; ?>>Motor</option>
                      <option value="mobil" <?php echo ($query->jenis_kendaraan == 'mobil') ? 'selected' : ''; ?>>Mobil</option>
                    </select>
                  </div>
                </div>
                <a href="users/hargaKendaraan" class="btn btn-default">
                  << Kembali</a>
                    <button type="submit" name="btnupdate" class="btn btn-danger" style="float:right;">Update</button>
              </form>
            </fieldset>
          </div>
        </div>
        <!-- /dashboard content -->
      </div>
    </div>
  </div>

  <!-- Tambahkan skrip inisialisasi Summernote -->
  <script>
    $(document).ready(function() {
      // Tambahkan skrip inisialisasi Summernote di sini jika diperlukan
    });
  </script>
</div>
</div>
<!-- /main content -->
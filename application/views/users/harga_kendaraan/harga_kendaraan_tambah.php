<!-- Content area -->
<div class="container">
  <div class="content">
    <!-- Dashboard content -->
    <div class="row">
      <div class="panel panel-flat">
        <div class="panel-body">
          <fieldset class="content-group">
            <legend class="text-bold"><i class="fa fa-tags"></i> Tambah Harga Kendaraan</legend>
            <?php echo $this->session->flashdata('msg'); ?>
            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">

              <div class="col-xs-6 col-sm-6">
                <div class="form-group">
                  <div class="col-lg-9">
                    <label for="merek">Merek</label>
                    <select name="merek" class="form-control select2" required>
                      <option value="">Pilih Merek</option>
                      <option value="YAMAHA">Yamaha</option>
                      <option value="HONDA">Honda</option>
                      <option value="SUZUKI">Suzuki</option>
                      <option value="KAWASAKI">Kawasaki</option>
                      <!-- Tambahkan merek lainnya sesuai kebutuhan -->
                      <option value="TOYOTA">Toyota</option>
                      <option value="NISSAN">Nissan</option>
                      <option value="MITSUBISHI">Mitsubishi</option>
                      <option value="FORD">Ford</option>
                      <option value="WULING">Wuling</option>
                      <option value="MAZDA">Mazda</option>
                      <!-- Dan seterusnya -->
                    </select>
                  </div>
                </div>
              </div>

              <div class="col-xs-6 col-sm-6">
                <div class="form-group">
                  <div class="col-lg-9">
                    <label for="model">Model</label>
                    <input type="text" name="model" class="form-control" value="" placeholder="Model" required>
                  </div>
                </div>
              </div>

              <div class="col-xs-6 col-sm-6">
                <div class="form-group">
                  <div class="col-lg-9">
                    <label for="tahun">Tahun</label>
                    <input type="number" name="tahun" class="form-control" value="" placeholder="Tahun" required>
                  </div>
                </div>
              </div>

              <div class="col-xs-6 col-sm-6">
                <div class="form-group">
                  <div class="col-lg-9">
                    <label for="harga_jual">Harga Jual</label>
                    <input type="number" name="harga_jual" class="form-control" value="" placeholder="Harga Jual" required>
                  </div>
                </div>
              </div>

              <div class="col-xs-6 col-sm-6">
                <div class="form-group">
                  <div class="col-lg-9">
                    <label for="foto">Foto</label>
                    <input type="file" name="foto" class="form-control" accept="image/*">
                  </div>
                </div>
              </div>

              <div class="col-xs-6 col-sm-6">
                <div class="form-group">
                  <div class="col-lg-9">
                    <label for="transmisi">Transmisi</label>
                    <select name="transmisi" class="form-control" required>
                      <option value="Manual">Manual</option>
                      <option value="Automatic">Automatic</option>
                      <!-- Add more options as needed -->
                    </select>
                  </div>
                </div>
              </div>

              <div class="col-xs-6 col-sm-6">
                <div class="form-group">
                  <div class="col-lg-9">
                    <label for="bahan_bakar">Bahan Bakar</label>
                    <select name="bahan_bakar" class="form-control" required>
                      <option value="Bensin">Bensin</option>
                      <option value="Solar">Solar</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="col-xs-6 col-sm-6">
                <div class="form-group">
                  <div class="col-lg-9">
                    <label for="kapasitas_mesin">Kapasitas Mesin</label>
                    <select name="kapasitas_mesin" id="kapasitas_mesin" class="form-control" required>
                      <option value="">Pilih Kapasitas Mesin</option>
                      <option value="1000">1000 CC</option>
                      <option value="1200">1200 CC</option>
                      <option value="1500">1500 CC</option>
                      <option value="2000">2000 CC</option>
                      <option value="2500">2500 CC</option>
                      <option value="100">100 CC</option>
                      <option value="110">110 CC</option>
                      <option value="125">125 CC</option>
                      <option value="150">150 CC</option>
                      <option value="155">155 CC</option>
                      <option value="200">200 CC</option>
                      <option value="custom">Input Manual</option>
                    </select>
                    <!-- Input manual untuk Kapasitas Mesin jika memilih "Lainnya" -->
                    <input type="text" name="kapasitas_mesin_manual" id="kapasitas_mesin_manual" class="form-control" placeholder="Masukkan Kapasitas Mesin" style="display: none;">
                  </div>
                </div>
              </div>

              <div class="col-xs-6 col-sm-6">
                <div class="form-group">
                    <label for="jenis_kendaraan">Jenis Kendaraan</label>
                    <div class="col-lg-9">
                      <select name="jenis_kendaraan" class="form-control" required>
                        <option value="motor">Motor</option>
                        <option value="mobil">Mobil</option>
                      </select>
                    </div>
                </div>
              </div>

              <div class="col-xs-12 col-sm-12">
                <a href="users/harga_kendaraan" class="btn btn-default">
                  << Kembali</a>
                    <button type="submit" name="btnsimpan" class="btn btn-danger" style="float:right;">Simpan</button>
              </div>
        </div>
        </form>
        </fieldset>
      </div>
    </div>
    <!-- /dashboard content -->
  </div>
  <script>
    document.getElementById('kapasitas_mesin').addEventListener('change', function() {
      var selectedOption = this.value;
      var inputManual = document.getElementById('kapasitas_mesin_manual');

      // Jika memilih "Lainnya", tampilkan input manual, jika tidak, sembunyikan
      if (selectedOption === 'custom') {
        inputManual.style.display = 'block';
      } else {
        inputManual.style.display = 'none';
      }
    });

    $(document).ready(function() {
      $('.select2').select2({
        allowClear: true // Opsi untuk menghapus pilihan
      });
    });
  </script>
</div>
</div>
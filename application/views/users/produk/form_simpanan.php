<!-- Main content -->
<div class="content-wrapper">
  <!-- Content area -->
  <div class="content">
    <br><br>
    <div class="container">
    <!-- Dashboard content -->
    <div class="row">
      <div class="col-md-1"></div>
      <div class="panel panel-flat col-md-9">
        <?php
        echo $this->session->flashdata('msg');
        ?>
        <div class="panel-body">
          <fieldset class="content-group">
            <legend class="text-bold"><i class="fa fa-wallet"></i> FORM PEMBUKAAN REKENING SIMPANAN</legend>

            <!-- Form Pembukaan Rekening -->
            <form action="proses_pembukaan_rekening.php" method="post">
              <div class="form-group">
                <label for="nama">Nama :</label>
                <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama lengkap Anda" required>
              </div>
              <div class="form-group">
                <label for="nomor_id">Nomor ID :</label>
                <input type="text" class="form-control" id="nomor_id" name="nomor_id" placeholder="Nomor identitas Anda (KTP/SIM/Paspor)" required>
              </div>
              <div class="form-group">
                <label for="alamat">Alamat Lengkap :</label>
                <textarea class="form-control" id="alamat" name="alamat" placeholder="Alamat lengkap Anda" required></textarea>
              </div>
              <div class="form-group">
                <label for="pekerjaan">Pekerjaan :</label>
                <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" placeholder="Pekerjaan Anda" required>
              </div>
              <div class="form-group">
                <label for="no_telepon">No. Telepon :</label>
                <input type="tel" class="form-control" id="no_telepon" name="no_telepon" placeholder="Nomor telepon yang aktif" required>
              </div>
              <div class="form-group">
                <label for="jenis_simpanan">Jenis Simpanan :</label>
                <select class="form-control" id="jenis_simpanan" name="jenis_simpanan" required>
                  <option value="simpati">Simpati</option>
                  <option value="simasya">Simasya</option>
                  <option value="simaya">Simaya</option>
                  <option value="simpel">Simpel</option>
                  <option value="simaroh">Simaroh</option>
                  <option value="simatang">Simatang</option>
                  <option value="simmka">SIMMKA</option>
                </select>
              </div>
            <div class="col-md-6 text-center">
                <button type="submit" class="btn btn-warning" disabled>KIRIM</button>
              </div>
              
            </form>
            <!-- End of Form Pembukaan Rekening -->

          </fieldset>
        </div>
      </div>
    </div>
    <!-- /dashboard content -->
    </div>
  </div>
</div>

<!-- Main content -->
<div class="container">
  <!-- Content area -->
  <div class="content">

    <!-- Dashboard content -->
    <div class="row">
      <div class="panel panel-flat">
        <div class="panel-body">
          <fieldset class="content-group">
            <legend class="text-bold"><i class="icon-user"></i> Tambah Pengguna</legend>
            <?php
            echo $this->session->flashdata('msg');
            ?>
            <form class="form-horizontal" action="" method="post">
              <div class="form-group">
                <label class="control-label col-lg-3">Level<span class="text-danger"> *</span></label>
                <div class="col-lg-9">
                  <select class="form-control" name="level" required>
                    <option value="">- Pilih Level Pengguna -</option>
                    <option value="marketing">Marketing</option>
                    <option value="admin">Admin</option>
                    <option value="ofb">Office Boy</option>
                    <option value="satpam">Satpam</option>
                    <option value="it">Staff IT</option>
                    <option value="audit">Staff Audit</option>
                    <option value="surveyor">Staff Surveyor</option>
                    <option value="k_cabang">Kabag Cabang</option>
                    <option value="k_hrd">Kabag HRD</option>
                    <option value="k_keuangan">Kabag Keuangan</option>
                    <option value="k_admin">Kabag Admin</option>
                    <option value="k_arsip">Kabag Arsip</option>
                    <option value="kadiv_pemasaran">Kadiv Pemasaran</option>
                    <option value="kadiv_opr">Kadiv Operational</option>
                    <option value="kadiv_manrisk">Kadiv Manrisk</option>
                    <option value="mng_bisnis">Manager Business</option>
                    <option value="gm">General Manager</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-lg-3">Username<span class="text-danger"> *</span></label>
                <div class="col-lg-9">
                  <input type="text" name="username" id="username" class="form-control" value="" placeholder="Username" maxlength="100" required>
                  <div id="username-error" class="text-danger"></div>
                </div>
              </div>
              <!-- <div class="form-group">
                      <label class="control-label col-lg-3">Nama Lengkap</label>
                      <div class="col-lg-9">
                        <input type="text" name="nama_lengkap" class="form-control" value="" placeholder="Nama Lengkap" maxlength="100">
                      </div>
                    </div> -->
              <div class="form-group">
                <label class="control-label col-lg-3">Email<span class="text-danger"> *</span></label>
                <div class="col-lg-9">
                  <input type="email" name="email" class="form-control" value="" placeholder="Alamat Email" maxlength="100" required>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-lg-3">Kode Kantor<span class="text-danger"> *</span></label>
                <div class="col-lg-9">
                  <select class="form-control" name="kode_kantor" required>
                    <option value="">- Pilih Kode Kantor -</option>
                    <option value="01">Pusat</option>
                    <option value="02">Sedayu</option>
                    <option value="03">Sapuran</option>
                    <option value="04">Kertek</option>
                    <option value="05">Wonosobo</option>
                    <option value="06">Kaliwiro</option>
                    <option value="07">Banjarnegara</option>
                    <option value="08">Randusari</option>
                    <option value="09">Kepil</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-lg-3">Devisi</label>
                <div class="col-lg-9">
                  <select class="form-control" name="kode_devisi">
                    <option value="">- Pilih Devisi -</option>
                    <option value="01">Pemasaran</option>
                    <option value="02">Operasional</option>
                    <option value="03">Manrisk</option>
                    <option value="04">Manajemen Bisnis</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-lg-3">Katasandi<span class="text-danger"> *</span></label>
                <div class="col-lg-9">
                  <input type="password" name="password" class="form-control" value="" placeholder="Katasandi" required>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-lg-3">Ulangi Katasandi<span class="text-danger"> *</span></label>
                <div class="col-lg-9">
                  <input type="password" name="password2" class="form-control" value="" placeholder="Ulangi Katasandi" required>
                </div>
              </div>

              <a href="users/pengguna" class="btn btn-default">
                << Kembali</a>
                  <button type="submit" name="btnsimpan" class="btn btn-danger" style="float:right;">Simpan</button>
            </form>

          </fieldset>
          <!-- Informasi bahwa input yang bertanda bintang merah wajib diisi -->
          <p class="text-danger">Kolom yang ditandai dengan <span class="text-danger">*</span> harus diisi.</p>


        </div>

      </div>
    </div>
  </div>
  <!-- /dashboard content -->
</div>

<script>
  // Validasi username saat input berubah
  document.getElementById('username').addEventListener('input', function() {
    var usernameInput = this.value;
    var usernameError = document.getElementById('username-error');

    // Buat ekspresi reguler untuk memeriksa username tanpa spasi
    var usernameRegex = /^[a-zA-Z0-9_]+$/;

    if (usernameRegex.test(usernameInput)) {
      // Username valid
      usernameError.textContent = '';
    } else {
      // Username tidak valid
      usernameError.textContent = 'Username harus terdiri dari 3 hingga 20 karakter alfanumerik dan garis bawah (underscore), tanpa spasi.';
    }
  });
</script>
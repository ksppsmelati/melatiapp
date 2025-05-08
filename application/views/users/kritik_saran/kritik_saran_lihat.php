<div class="container">
  <!-- Content area -->
  <div class="content">
    <?php echo $this->session->flashdata('msg'); ?>

    <!-- Edit Kritik & Saran content -->
    <div class="row">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="navigation-buttons">
            <div class="btn-group" style="float: left;">
              <i class="fa fa-comments"></i> Detail Kritik Saran <br>
            </div>
            <div class="btn-group" style="float: right;">
              <!-- Tombol Dropdown (di pojok kanan atas) -->
              <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-bars"></i>
              </button>
              <!-- Isi Dropdown -->
              <ul class="dropdown-menu dropdown-menu-right" role="menu">
                <li><a href="<?php echo site_url('users/kritik_saran_tambah'); ?>"><i class="fa fa-plus"></i> Tambah Kritik Saran</a></li>
                <li><a href="<?php echo site_url('users/kritik_saran_data_user'); ?>"><i class="fa-solid fa-envelope-open-text"></i> Data Kritik Saran</a></li>
              </ul>
            </div>
          </div>
          <div class="clearfix"></div>

          <div class="form-group" style="display: none;">
            <label for="id">ID:</label>
            <input type="text" class="form-control" name="id" id="id" value="<?php echo $kritik_saran['id']; ?>" readonly>
          </div>
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="tanggal">Tanggal:</label>
              <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?php echo $kritik_saran['tanggal']; ?>" readonly>
            </div>
          </div>
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="nama">Nama:</label>
              <input type="text" class="form-control" name="nama" id="nama" value="<?php echo $kritik_saran['nama']; ?>" readonly>
            </div>
          </div>
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="alamat">Alamat:</label>
              <input type="text" class="form-control" name="alamat" id="alamat" value="<?php echo $kritik_saran['alamat']; ?>" readonly>
            </div>
          </div>
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="no_telepon">No Telepon:</label>
              <input type="text" class="form-control" name="no_telepon" id="no_telepon" value="<?php echo $kritik_saran['no_telepon']; ?>" readonly>
            </div>
          </div>
          <div class="col-xs-12 col-sm-12">
            <div class="form-group">
              <label for="kritik_saran">Kritik & Saran:</label>
              <textarea class="form-control" name="kritik_saran" id="kritik_saran" rows="4" readonly><?php echo $kritik_saran['kritik_saran']; ?></textarea>
            </div>
          </div>
          <div class="col-xs-12 col-sm-12">
            <div class="form-group">
              <label for="status">Jawaban:</label>
              <textarea class="form-control" name="status" id="status" rows="4" readonly><?php echo $kritik_saran['status']; ?></textarea>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /Edit Kritik & Saran content -->
  </div>
  <!-- /content area -->
</div>
<!-- /main content -->
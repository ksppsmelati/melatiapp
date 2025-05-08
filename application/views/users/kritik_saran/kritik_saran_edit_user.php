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
              <!-- Back button (top left) -->
              <a href="javascript:history.go(-1);" class="btn btn-light btn-sm btn-back">
                <i class="fa fa-arrow-left"></i> Kembali
              </a>
            </div>

            <div class="btn-group" style="float: right;">
              <!-- Dropdown button (top right) -->
              <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-bars"></i>
              </button>
              <!-- Dropdown menu -->
              <ul class="dropdown-menu dropdown-menu-right" role="menu">
                <li><a href="<?php echo site_url('users/kritik_saran_tambah'); ?>"><i class="fa fa-plus"></i> Tambah Kritik & Saran</a></li>
                <li><a href="<?php echo site_url('users/kritik_saran_data_user'); ?>"><i class="fa-solid fa-envelope-open-text"></i> Data Kritik & Saran</a></li>
              </ul>
            </div>
          </div>
          <!-- Clear float -->
          <div class="clearfix"></div>
          <br>
          <legend class="text-bold"><i class="fa fa-envelope"></i> Edit Kritik & Saran</legend>

          <!-- Form to update Kritik & Saran -->
          <form action="<?php echo site_url('users/kritik_saran_update/' . $kritik_saran['id']); ?>" method="post">
            <div class="col-xs-6 col-sm-6">
              <div class="form-group">
                <label for="id">ID:</label>
                <input type="text" class="form-control" name="id" id="id" value="<?php echo $kritik_saran['id']; ?>" readonly>
              </div>
            </div>
            <div class="col-xs-6 col-sm-6">
              <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" class="form-control" name="nama" id="nama" value="<?php echo $kritik_saran['nama']; ?>" required>
              </div>
            </div>
            <div class="col-xs-6 col-sm-6">
              <div class="form-group">
                <label for="alamat">Alamat:</label>
                <input type="text" class="form-control" name="alamat" id="alamat" value="<?php echo $kritik_saran['alamat']; ?>">
              </div>
            </div>
            <div class="col-xs-6 col-sm-6">
              <div class="form-group">
                <label for="no_telepon">No Telepon:</label>
                <input type="text" class="form-control" name="no_telepon" id="no_telepon" value="<?php echo $kritik_saran['no_telepon']; ?>">
              </div>
            </div>
            <div class="col-xs-6 col-sm-6">
              <div class="form-group">
                <label for="tanggal">Tanggal:</label>
                <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?php echo $kritik_saran['tanggal']; ?>" required>
              </div>
            </div>
            <div class="col-xs-12 col-sm-12">
              <div class="form-group">
                <label for="kritik_saran">Kritik & Saran:</label>
                <textarea class="form-control" name="kritik_saran" id="kritik_saran" rows="4" required><?php echo $kritik_saran['kritik_saran']; ?></textarea>
              </div>
            </div>
            <div class="col-xs-12 col-sm-12">
              <div class="form-group">
                <label for="status">Jawaban:</label>
                <textarea class="form-control" name="status" id="status" rows="4" readonly><?php echo $kritik_saran['status']; ?></textarea>
              </div>
            </div>
            <div class="col-xs-12 col-sm-12">
              <div class="form-group">
                <input type="submit" class="btn btn-danger" style="float:right;" value="Update">
              </div>
            </div>
          </form>
          <!-- /Form to update Kritik & Saran -->

        </div>
      </div>
    </div>
    <!-- /Edit Kritik & Saran content -->
  </div>
  <!-- /content area -->
</div>
<!-- /main content -->
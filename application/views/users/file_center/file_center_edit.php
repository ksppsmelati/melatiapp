<style>
  label {
    font-weight: bold;
  }
</style>
<div class="container">
  <!-- Content area -->
  <div class="content">
    <?php echo $this->session->flashdata('msg'); ?>

    <!-- Edit File Center content -->
    <div class="row">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="navigation-buttons">
            <div class="btn-group" style="float: left;">
              <!-- Tombol Back (di pojok kiri atas) -->
              <a href="javascript:history.go(-1);" class="btn btn-light btn-sm btn-back">
                <i class="fa fa-arrow-left"></i> Kembali
              </a>
            </div>

            <div class="btn-group" style="float: right;">
              <!-- Tombol Dropdown (di pojok kanan atas) -->
              <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-bars"></i>
              </button>
              <!-- Isi Dropdown -->
              <ul class="dropdown-menu dropdown-menu-right" role="menu">
                <!-- <li><a href="<?php echo site_url('users/file_center_upload'); ?>"><i class="fa fa-upload"></i> Upload File</a></li> -->
                <li><a href="<?php echo site_url('users/file_center_categories'); ?>"><i class="fa fa-file"></i> File Center Data</a></li>
              </ul>
            </div>
          </div>
          <!-- Membersihkan float -->
          <div class="clearfix"></div>
          <br>
          <legend class="text-bold"><i class="fa fa-file"></i> Edit File Center</legend>

          <!-- Form untuk mengedit file -->
          <form action="<?php echo site_url('users/file_center_update/' . $file_center['id']); ?>" method="post">
            <div class="col-xs-6 col-sm-6">
              <div class="form-group">
                <label for="file_name">Nama File:</label>
                <input type="text" class="form-control" name="file_name" id="file_name" value="<?php echo htmlspecialchars($file_center['file_name']); ?>" required readonly>
              </div>
            </div>
            <div class="col-xs-6 col-sm-6">
              <div class="form-group">
                <label for="category">Kategori:</label>
                <input type="text" class="form-control" name="category" id="category" value="<?php echo htmlspecialchars($file_center['category']); ?>" required>
              </div>
            </div>
            <div class="col-xs-6 col-sm-6">
              <div class="form-group">
                <label for="tahun">Tahun:</label>
                <input type="number" class="form-control" name="tahun" id="tahun" value="<?php echo htmlspecialchars($file_center['tahun']); ?>" required>
              </div>
            </div>
            <div class="col-xs-6 col-sm-6">
              <div class="form-group">
                <label for="download_status">Download:</label>
                <select class="form-control" name="download_status" id="download_status" required>
                  <option value="1" <?php echo ($file_center['download_status'] == 1) ? 'selected' : ''; ?>>Aktif</option>
                  <option value="0" <?php echo ($file_center['download_status'] == 0) ? 'selected' : ''; ?>>Tidak</option>
                </select>
              </div>
            </div>
            <div class="col-xs-6 col-sm-6">
              <div class="form-group">
                <label for="description">Deskripsi:</label>
                <input type="text" class="form-control" name="description" id="description" value="<?php echo htmlspecialchars($file_center['description']); ?>" required>
              </div>
            </div>
            <div class="col-xs-6 col-sm-6">
              <div class="form-group">
                <label for="file_size">Ukuran File:</label>
                <input type="text" class="form-control" name="file_size" id="file_size" value="<?php echo htmlspecialchars($file_center['file_size']); ?>" readonly>
              </div>
            </div>
            <div class="col-xs-6 col-sm-6" style="display: none;">
              <div class="form-group">
                <label for="uploaded_at">Tanggal Upload:</label>
                <input type="text" class="form-control" name="uploaded_at" id="uploaded_at" value="<?php echo htmlspecialchars($file_center['uploaded_at']); ?>" readonly>
              </div>
            </div>
            <div class="form-group">
              <input type="submit" class="btn btn-danger" style="float:right;" value="Update">
            </div>
          </form>
          <!-- /Form untuk mengedit file -->

        </div>
      </div>
    </div>
    <!-- /Edit File Center content -->
  </div>
  <!-- /content area -->
</div>
<!-- /main content -->
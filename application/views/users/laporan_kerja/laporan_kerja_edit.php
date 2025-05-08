<!-- Tambahkan CSS Summernote -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.css" rel="stylesheet">

<!-- Tambahkan script Summernote dan jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<div class="container">
  <!-- Content area -->
  <div class="content">
    <?php echo $this->session->flashdata('msg'); ?>

    <!-- Laporan Kerja content -->
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
                <li><a href="<?php echo site_url('users/laporan_kerja'); ?>"><i class="fa fa-plus"></i> Tambah Laporan Kerja</a></li>
                <li><a href="<?php echo site_url('users/data_laporan_kerja'); ?>"><i class="fa fa-file"></i> Data Laporan Kerja</a></li>
              </ul>
            </div>
          </div>
          <!-- Membersihkan float -->
          <div class="clearfix"></div>
          <br>
          <legend class="text-bold"><i class="fa fa-briefcase"></i> Edit Laporan Kerja</legend>

          <!-- Form untuk melaporkan pekerjaan -->
          <form action="<?php echo site_url('users/update_laporan/' . $laporan_kerja['id']); ?>" method="post">
            <div class="form-group" style="display: none;">
              <label for="id_user">ID User:</label>
              <input type="text" class="form-control" name="id_user" id="id_user" value="<?php echo isset($_SESSION['id_user']) ? $_SESSION['id_user'] : ''; ?>" readonly>
            </div>

            <div class="form-group">
              <label for="tanggal">Tanggal:</label>
              <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?php echo $laporan_kerja['tanggal']; ?>" required>
            </div>

            <div class="form-group" style="display: none;">
              <label for="jam">Jam:</label>
              <input type="time" class="form-control" name="jam" id="jam" value="<?php echo $laporan_kerja['jam']; ?>" required readonly>
            </div>

            <div class="form-group">
              <label for="pekerjaan">Pekerjaan:</label>
              <textarea class="form-control" name="pekerjaan" id="pekerjaan" rows="4" required><?php echo $laporan_kerja['pekerjaan']; ?></textarea>
            </div>

            <div class="form-group">
              <input type="submit" class="btn btn-danger" style="float:right;" value="Update">
            </div>
          </form>

          <!-- /Form untuk melaporkan pekerjaan -->

        </div>
      </div>
    </div>
    <!-- /Laporan Kerja content -->
  </div>
  <!-- /content area -->
</div>
<!-- /main content -->


<script>
  $(document).ready(function() {
    // Inisialisasi Summernote pada textarea dengan nama "pekerjaan"
    $('#pekerjaan').summernote({
      height: '50vh',
    });
  });
</script>
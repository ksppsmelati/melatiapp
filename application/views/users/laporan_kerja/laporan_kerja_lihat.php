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
      <div class="panel panel-flat">
        <div class="panel-body">
          <div class="navigation-buttons">
            <div class="btn-group" style="float: left;">
              <i class="fa fa-briefcase"></i> Detail Laporan Kerja <br>
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
          <hr>
          <small style="float: left;"><?php echo $laporan_kerja['nama_lengkap']; ?> | <?php echo date('d-m-Y', strtotime($laporan_kerja['tanggal'])); ?>
          </small>
          <a href="<?php echo site_url('users/laporan_kerja_edit/' . $laporan_kerja['id']); ?>" class="fa fa-pencil" style="float: right;"></a>
        </div>

        <!-- Detail laporan kerja -->
        <!-- <div class="form-group">
            <label for="tanggal">Tanggal:</label>
            <input type="text" class="form-control" value="<?php echo $laporan_kerja['tanggal']; ?>" readonly>
          </div> -->

        <!-- <div class="form-group" style="display: none;">
            <label for="jam">Jam:</label>
            <input type="text" class="form-control" value="<?php echo $laporan_kerja['jam']; ?>" readonly>
          </div> -->

          <div class="form-group">
              <?php if (!empty($laporan_kerja['foto_kerja'])) : ?>
                  <?php
                  $image_path = base_url('foto/foto_kerja/' . $laporan_kerja['foto_kerja']);
                  ?>
                  <img src="<?php echo $image_path; ?>" class="img-fluid" alt="Foto Kerja">
              <?php else : ?>
                  <p></p>
              <?php endif; ?>
          </div>

        <div class="form-group">
          <label for="pekerjaan" style="display: none;">Pekerjaan:</label>
          <div id="summernoteContent" style=" max-width: 100%;"><?php echo $laporan_kerja['pekerjaan']; ?></div>
        </div>
        <!-- /Detail laporan kerja -->
      </div>
    </div>
    <!-- /Laporan Kerja content -->
  </div>
  <!-- /content area -->
</div>
<!-- /main content -->

<script>
  $(document).ready(function() {
    // Inisialisasi Summernote pada div dengan id "summernoteContent"
    $('#summernoteContent').summernote({
      // Atur tinggi editor sesuai kebutuhan
      toolbar: [], // Nonaktifkan toolbar untuk mode read-only
      disableDragAndDrop: true, // Nonaktifkan fitur drag-and-drop
      disableResizeEditor: true // Nonaktifkan fitur resize editor
    });

    // Nonaktifkan interaksi dengan konten pada editor
    $('#summernoteContent').summernote('disable');
  });
</script>
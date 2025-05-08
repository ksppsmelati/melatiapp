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
          <!-- <div class="navigation-buttons">
            <div class="btn-group" style="float: left;">
              <a href="<?php echo base_url('users/laporan_kerja_by_devisi'); ?>" class="btn btn-light btn-sm">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
            </div>
          </div> -->
          <!-- Membersihkan float -->
          <div class="clearfix"></div>
          <br>
          <legend class="text-bold"><i class="fa fa-check"></i> Approval Laporan Kerja atasan</legend>

          <!-- Form untuk melaporkan pekerjaan -->
          <form action="<?php echo site_url('users/update_laporan_kerja_approval_atasan/' . $laporan_kerja['id']); ?>" method="post">
            <div class="form-group" style="display: none;">
              <label for="id_user">ID User:</label>
              <input type="text" class="form-control" name="id_user" id="id_user" value="<?php echo isset($_SESSION['id_user']) ? $_SESSION['id_user'] : ''; ?>" readonly>
            </div>
            <div class="col-xs-12 col-sm-6">
            <div class="form-group">
              <label for="nama_lengkap">Nama :</label>
              <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap" value="<?php echo $laporan_kerja['nama_lengkap']; ?>" readonly>
            </div>
            </div>
            <div class="col-xs-12 col-sm-6">
            <div class="form-group">
              <label for="tanggal">Tanggal:</label>
              <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?php echo $laporan_kerja['tanggal']; ?>" readonly>
            </div>
            </div>
            <div class="form-group" style="display: none;">
              <label for="jam">Jam:</label>
              <input type="time" class="form-control" name="jam" id="jam" value="<?php echo $laporan_kerja['jam']; ?>" required readonly>
            </div>
            <div class="form-group">
              <?php if (!empty($laporan_kerja['foto_pekerjaan'])) : ?>
                <?php
                $thumbnailURL = base_url('foto/foto_pekerjaan/' . $laporan_kerja['foto_pekerjaan']);
                ?>
                <div class="text-center">
                  <a href="javascript:void(0);" onclick="openPopup('<?php echo $thumbnailURL; ?>');">
                    <img src="<?php echo $thumbnailURL; ?>" alt="Current Kerusakan Photo" class="mx-auto" width="100">
                  </a>
                </div>
              <?php endif; ?>
            </div>
            <div class="clearfix"></div>

            <div class="form-group">
              <label for="pekerjaan"> </label>
              <textarea class="form-control" name="pekerjaan" id="pekerjaan" rows="4" required><?php echo $laporan_kerja['pekerjaan']; ?></textarea>
            </div>

            <div class="form-group">
              <label for="approval">Approval:</label><br>
              <select class="form-control col-xs-5" name="approval" id="approval" required style="width: 40%;">
                <option value="1" <?php echo $laporan_kerja['approval'] == 1 ? 'selected' : ''; ?>>
                  <i class="fa fa-check-circle text-success"></i> Approve
                </option>
                <option value="0" <?php echo $laporan_kerja['approval'] == 0 ? 'selected' : ''; ?>>
                  <i class="fa fa-clock"></i> Pending
                </option>
              </select>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    function openPopup(imageURL) {
        Swal.fire({
            html: `<img src="${imageURL}" class="popup-image" style="width: 100%;" />`,
            showCloseButton: true,
            showConfirmButton: false,
            customClass: {
                content: 'custom-popup-content',
                closeButton: 'custom-popup-close-button'
            }
        });
    }
</script>
<!-- Main content -->
<div class="container">
  <!-- Content area -->
  <div class="content">

    <!-- Dashboard content -->
    <div class="row">
      <div class="panel panel-flat">
        <div class="panel-body">
          <fieldset class="content-group">
            <legend class="text-bold"><i class="icon-file-text2"></i> Edit catatan</legend>
            <?php echo $this->session->flashdata('msg'); ?>
            <form class="form-horizontal" action="" method="post">
              <div class="form-group">
                <label class="control-label col-lg-3">Judul catatan</label>
                <div class="col-lg-9">
                  <input type="text" name="judul_catatan" class="form-control" value="<?php echo $query->judul_catatan; ?>" placeholder="Judul catatan" required>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-lg-3">Catatan</label>
                <div class="col-lg-9">
                  <!-- Ganti textarea dengan Summernote -->
                  <textarea name="catatan" class="form-control summernote" placeholder="catatan" required><?php echo $query->catatan; ?></textarea>
                </div>
              </div>

              <a href="users/catatan" class="btn btn-default">
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
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script>
  $(document).ready(function() {
    $('.summernote').summernote({
      height: '50vh',
    });
  });
</script>
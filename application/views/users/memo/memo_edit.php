<!-- Main content -->
<div class="container">
  <!-- Content area -->
  <div class="content">

    <!-- Dashboard content -->
    <div class="row">
      <div class="panel panel-flat">
        <div class="panel-body">
          <fieldset class="content-group">
            <legend class="text-bold"><i class="icon-file-text2"></i> Edit Info</legend>
            <?php echo $this->session->flashdata('msg'); ?>
            <form class="form-horizontal" action="" method="post">
              <div class="form-group">
                <label class="control-label col-lg-3">Judul Info</label>
                <div class="col-lg-9">
                  <input type="text" name="judul_memo" class="form-control" value="<?php echo $query->judul_memo; ?>" placeholder="Judul Memo" required>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-lg-3">Pin</label>
                <div class="col-lg-9">
                  <select name="status_pin" class="form-control" required>
                    <option value="1" <?php echo ($query->status_pin == 1) ? 'selected' : ''; ?>>Ya</option>
                    <option value="0" <?php echo ($query->status_pin == 0) ? 'selected' : ''; ?>>Tidak</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-lg-3">Info</label>
                <div class="col-lg-9">
                  <!-- Ganti textarea dengan Summernote -->
                  <textarea name="memo" class="form-control summernote" placeholder="Info" required><?php echo $query->memo; ?></textarea>
                </div>
              </div>

              <a href="users/memo" class="btn btn-default">
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
      height: 200,
    });
  });
</script>
<!-- Main content -->
<div class="container">
  <!-- Content area -->
  <div class="content">
    <!-- Dashboard content -->
    <div class="row">
      <div class="panel panel-flat">
        <div class="panel-body">
          <fieldset class="content-group">
            <legend class="text-bold"><i class="fa fa-bullhorn"></i> Tambah Pengumuman</legend>
            <?php echo $this->session->flashdata('msg'); ?>
            <form class="form-horizontal" action="" method="post">
              <div class="form-group">
                <label class="control-label col-lg-3">Judul </label>
                <div class="col-lg-9">
                  <input type="text" name="judul_pengumuman" class="form-control" value="" placeholder="Judul">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-lg-3">Isi Pengumuman</label>
                <div class="col-lg-9">
                  <!-- Ganti textarea dengan Summernote -->
                  <textarea name="isi_pengumuman" class="form-control summernote" placeholder="Isi Pengumuman" required></textarea>
                </div>
              </div>

              <a href="users/pengumuman" class="btn btn-default">
                << Kembali</a>
                  <button type="submit" name="btnsimpan" class="btn btn-danger" style="float:right;">Simpan</button>
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
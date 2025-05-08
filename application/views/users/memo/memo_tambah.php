<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Info</title>
  <!-- Tambahkan CSS dan JS Summernote -->
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
</head>

<body>

  <!-- Main content -->
  <div class="container">
    <!-- Content area -->
    <div class="content">

      <!-- Dashboard content -->
      <div class="row">
        <div class="panel panel-flat">
          <div class="panel-body">
            <fieldset class="content-group">
              <legend class="text-bold"><i class="icon-file-text2"></i> Tambah Info</legend>
              <?php echo $this->session->flashdata('msg'); ?>
              <form class="form-horizontal" action="" method="post">
                <div class="form-group">
                  <label class="control-label col-lg-3">Judul </label>
                  <div class="col-lg-9">
                    <input type="text" name="judul_memo" class="form-control" value="" placeholder="Judul" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-lg-3">Pin</label>
                  <div class="col-lg-9">
                    <select name="status_pin" class="form-control" required>
                      <option value="1">Ya</option>
                      <option value="0">Tidak</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-lg-3">Deskripsi</label>
                  <div class="col-lg-9">
                    <!-- Ganti textarea dengan Summernote -->
                    <textarea name="memo" class="form-control summernote" placeholder="Deskripsi" required></textarea>
                  </div>
                </div>

                <a href="users/memo" class="btn btn-default">
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
  <script>
    $(document).ready(function() {
      $('.summernote').summernote({
        height: 200,
      });
    });
  </script>

</body>

</html>
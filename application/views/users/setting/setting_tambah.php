<!-- Main content -->
<div class="container">
  <!-- Content area -->
  <div class="content">

    <!-- Dashboard content -->
    <div class="row">
      <div class="panel panel-flat">
        <div class="panel-body">
          <fieldset class="content-group">
            <legend class="text-bold"><i class="icon-file-text2"></i> Tambah Setting</legend>

            <?php echo $this->session->flashdata('msg'); ?>

            <form class="form-horizontal" action="<?php echo site_url('users/setting_simpan'); ?>" method="post">
              <div class="form-group">
                <label class="control-label col-lg-3">Key</label>
                <div class="col-lg-9">
                  <input type="text" name="key" class="form-control" value="" placeholder="Masukkan key untuk setting" required>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-lg-3">Nilai</label>
                <div class="col-lg-9">
                  <input type="text" name="value" class="form-control" value="" placeholder="Masukkan nilai setting" required>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-lg-3">Catatan</label>
                <div class="col-lg-9">
                  <textarea name="catatan" class="form-control" rows="5" placeholder="Masukkan catatan"></textarea>
                </div>
              </div>

              <a href="<?php echo site_url('users/setting/setting_data'); ?>" class="btn btn-default">
                << Kembali</a>
                  <button type="submit" name="btnsave" class="btn btn-danger" style="float:right;">Simpan</button>
            </form>
          </fieldset>
        </div>
      </div>
      <!-- /dashboard content -->
    </div>
  </div>
</div>
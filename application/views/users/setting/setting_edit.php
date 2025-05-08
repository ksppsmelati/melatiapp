<!-- Main content -->
<div class="container">
  <!-- Content area -->
  <div class="content">

    <!-- Dashboard content -->
    <div class="row">
      <div class="panel panel-flat">
        <div class="panel-body">
          <fieldset class="content-group">
            <legend class="text-bold"><i class="icon-file-text2"></i> Edit Setting</legend>
            <?php echo $this->session->flashdata('msg'); ?>
            <form class="form-horizontal" action="<?php echo site_url('users/setting_update/' . $setting->key); ?>" method="post">
              <div class="form-group">
                <label class="control-label col-lg-3">Key</label>
                <div class="col-lg-9">
                  <input type="text" name="key" class="form-control" value="<?php echo $setting->key; ?>" readonly>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-lg-3">Nilai</label>
                <div class="col-lg-9">
                  <input type="text" name="value" class="form-control" value="<?php echo htmlspecialchars($setting->value, ENT_QUOTES, 'UTF-8'); ?>" placeholder="Masukkan nilai">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-lg-3">Catatan</label>
                <div class="col-lg-9">
                  <textarea name="catatan" class="form-control" rows="5"><?php echo $setting->catatan; ?></textarea>
                </div>
              </div>
              <a href="<?php echo site_url('users/setting/setting_data'); ?>" class="btn btn-default">
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
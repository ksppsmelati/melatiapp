<!-- Main content -->
<div class="container">
  <!-- Content area -->
  <div class="content">

    <!-- Dashboard content -->
    <div class="row">
      <div class="panel panel-flat">
        <div class="panel-body">
          <fieldset class="content-group">
            <legend class="text-bold"><i class="fa fa-pen"></i> Edit Menu Icon</legend>
            <?php echo $this->session->flashdata('msg'); ?>

            <!-- Form untuk edit data menu_setting -->
            <form class="form-horizontal" action="<?php echo site_url('users/menu_setting_update/' . $menu_setting->id_menu); ?>" method="post" enctype="multipart/form-data">

              <!-- Nama Menu -->
              <div class="col-xs-6 col-sm-6">
                <div class="form-group">
                  <label class="control-label col-lg-3" for="menu_name">Nama Menu:</label>
                  <div class="col-lg-9">
                    <input type="text" class="form-control" name="menu_name" id="menu_name" value="<?php echo $menu_setting->menu_name; ?>" placeholder="Masukkan nama menu" required>
                  </div>
                </div>
              </div>

              <!-- Ikon Menu -->
              <div class="col-xs-6 col-sm-6">
                <div class="form-group">
                  <label class="control-label col-lg-3" for="icon">Ikon Menu:</label>
                  <div class="col-lg-9">
                    <input type="text" class="form-control" name="icon" id="icon" value="<?php echo $menu_setting->icon; ?>" placeholder="Masukkan ikon menu" required>
                  </div>
                </div>
              </div>

              <!-- URL Menu -->
              <div class="col-xs-6 col-sm-6">
                <div class="form-group">
                  <label class="control-label col-lg-3" for="url">URL Menu:</label>
                  <div class="col-lg-9">
                    <input type="text" class="form-control" name="url" id="url" value="<?php echo $menu_setting->url; ?>" placeholder="Masukkan URL menu" required>
                  </div>
                </div>
              </div>

              <!-- Kategori Menu -->
              <div class="col-xs-6 col-sm-6">
                <div class="form-group">
                  <label class="control-label col-lg-3" for="category">Kategori Menu:</label>
                  <div class="col-lg-9">
                    <input type="text" class="form-control" name="category" id="category" value="<?php echo $menu_setting->category; ?>" placeholder="Masukkan kategori menu" required>
                  </div>
                </div>
              </div>

              <!-- Fungsi Menu -->
              <div class="col-xs-6 col-sm-6">
                <div class="form-group">
                  <label class="control-label col-lg-3" for="fungsi">Fungsi Menu:</label>
                  <div class="col-lg-9">
                    <input type="text" class="form-control" name="fungsi" id="fungsi" value="<?php echo $menu_setting->fungsi; ?>" placeholder="Masukkan fungsi menu" required>
                  </div>
                </div>
              </div>

              <!-- Access Level -->
              <div class="col-xs-6 col-sm-6">
                <div class="form-group">
                  <label class="control-label col-lg-3" for="access_level">Access Level:</label>
                  <div class="col-lg-9">
                    <input type="text" class="form-control" name="access_level" id="access_level" value="<?php echo $menu_setting->access_level; ?>" placeholder="Masukkan access level menu" required>
                  </div>
                </div>
              </div>

              <!-- Tombol Submit -->
              <div class="col-xs-12 col-sm-12">
                <div class="form-group">
                  <button type="submit" id="submit" class="btn btn-danger" style="float:right;">Update</button>
                </div>
              </div>

            </form>
          </fieldset>
        </div>
      </div>
      <!-- /dashboard content -->
    </div>
  </div>
</div>
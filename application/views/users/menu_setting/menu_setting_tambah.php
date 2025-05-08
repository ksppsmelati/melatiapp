<div class="container">
  <div class="content">
    <?php echo $this->session->flashdata('msg'); ?>
    <div class="row">
      <div class="panel panel-flat">
        <div class="panel-body">
          <div class="navigation-buttons">
            <i class="fa fa-server"></i> Setting menu tambah
            <div class="btn-group" style="float: right;">
              <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-bars"></i>
              </button>
              <ul class="dropdown-menu dropdown-menu-right" role="menu">
                <li><a href="<?php echo site_url('users/menu_setting_tambah'); ?>"><i class="fa fa-plus"></i> Menu setting tambah</a></li>
                <li><a href="<?php echo site_url('users/menu_setting_data'); ?>"><i class="fa fa-server"></i> Menu setting data</a></li>
              </ul>
            </div>
          </div>
          <div class="clearfix"></div>
          <form action="<?php echo site_url('users/menu_setting_simpan'); ?>" method="post" enctype="multipart/form-data">

            <div class="col-xs-6 col-sm-6">
              <div class="form-group">
                <label for="menu_name">Nama Menu:</label>
                <input type="text" class="form-control" name="menu_name" id="menu_name" placeholder="Masukkan nama menu" required>
              </div>
            </div>
            <div class="col-xs-6 col-sm-6">
              <div class="form-group">
                <label for="icon">Ikon Menu:</label>
                <input type="text" class="form-control" name="icon" id="icon" placeholder="Masukkan ikon menu" required>
              </div>
            </div>
            <div class="col-xs-6 col-sm-6">
              <div class="form-group">
                <label for="url">URL Menu:</label>
                <input type="text" class="form-control" name="url" id="url" placeholder="Masukkan URL menu" required>
              </div>
            </div>
            <div class="col-xs-6 col-sm-6">
              <div class="form-group">
                <label for="category">Kategori Menu:</label>
                <input type="text" class="form-control" name="category" id="category" placeholder="Masukkan category menu" required>
              </div>
            </div>
            <div class="col-xs-6 col-sm-6">
              <div class="form-group">
                <label for="fungsi">Fungsi Menu:</label>
                <input type="text" class="form-control" name="fungsi" id="fungsi" placeholder="Masukkan fungsi menu" required>
              </div>
            </div>
            <div class="col-xs-6 col-sm-6">
              <div class="form-group">
                <label for="access_level">Access Level:</label>
                <input type="text" class="form-control" name="access_level" id="access_level" placeholder="Masukkan access level menu" required>
              </div>
            </div>
            <div class="col-xs-12 col-sm-12">
              <div class="form-group">
                <button type="submit" id="submit" class="btn btn-danger" style="float:right;">Simpan</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
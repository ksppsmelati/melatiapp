<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<div class="container">
  <div class="content">
    <?php echo $this->session->flashdata('msg'); ?>
    <div class="row">
      <div class="panel panel-flat">
        <div class="panel-body">
          <div class="navigation-buttons">
            <i class="fa fa-plane"></i> Menu user access tambah
            <div class="btn-group" style="float: right;">
              <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-bars"></i>
              </button>
              <ul class="dropdown-menu dropdown-menu-right" role="menu">
                <li><a href="<?php echo site_url('users/menu_access_tambah'); ?>"><i class="fa fa-plus"></i> Menu Access tambah</a></li>
                <li><a href="<?php echo site_url('users/menu_access_data'); ?>"><i class="fa fa-plane"></i> Menu User Access</a></li>
              </ul>
            </div>
          </div>
          <div class="clearfix"></div>
          <!-- Form Section -->
          <form action="<?php echo site_url('users/menu_access_simpan'); ?>" method="post" enctype="multipart/form-data">
            
            <!-- ID User -->
            <div class="form-row mb-3">
              <div class="col-md-6">
                <label for="id_user">Nama:</label>
                <select class="form-control select2" name="id_user" id="id_user" required>
                  <option value="" disabled selected>Pilih Nama</option>
                  <?php
                  // Ambil semua pengguna dari tabel tbl_user
                  $users = $this->db->get('tbl_user')->result();
                  foreach ($users as $user) {
                    echo "<option value='{$user->id_user}'>{$user->nama_lengkap}</option>";
                  }
                  ?>
                </select>
              </div>
            </div>

            <!-- ID Menu -->
            <div class="form-row mb-3">
              <div class="col-md-6">
                <label for="id_menu">Menu:</label>
                <select class="form-control select2" name="id_menu" id="id_menu" required>
                  <option value="" disabled selected>Pilih Menu</option>
                  <?php
                  // Ambil semua menu dari tbl_user_main_menu
                  $menus = $this->db->get('tbl_user_main_menu')->result();
                  foreach ($menus as $menu) {
                    echo "<option value='{$menu->id_menu}'>{$menu->menu_name}</option>";
                  }
                  ?>
                </select>
              </div>
            </div>

            <!-- Has Access -->
            <div class="form-row mb-3">
              <div class="col-md-6">
                <label for="has_access">Has Access:</label>
                <select class="form-control" name="has_access" id="has_access" required>
                  <option value="1">Ya</option>
                  <option value="0">Tidak</option>
                </select>
              </div>
            </div>

            <!-- Submit Button -->
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

<script>
  // Inisialisasi Select2
  $(document).ready(function() {
    $('.select2').select2();
  });
</script>

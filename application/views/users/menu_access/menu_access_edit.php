<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<!-- Main content -->
<div class="container">
  <!-- Content area -->
  <div class="content">

    <!-- Dashboard content -->
    <div class="row">
      <div class="panel panel-flat">
        <div class="panel-body">
          <fieldset class="content-group">
            <legend class="text-bold"><i class="fa fa-pen"></i> Edit Menu User Access</legend>
            <?php echo $this->session->flashdata('msg'); ?>

            <!-- Form untuk edit data menu_setting -->
            <form class="form-horizontal" action="<?php echo site_url('users/menu_access_update/' . $menu_access->id_access); ?>" method="post" enctype="multipart/form-data">

              <!-- Ikon Menu -->
              <div class="col-xs-6 col-sm-6">
                <div class="form-group">
                  <label class="control-label col-lg-3" for="icon">Nama:</label>
                  <div class="col-lg-9">
                    <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap" value="<?php echo $menu_access->nama_lengkap; ?>" required readonly>
                    <input type="hidden" class="form-control" name="id_user" id="id_user" value="<?php echo $menu_access->id_user; ?>" required readonly>
                  </div>
                </div>
              </div>

              <!-- URL Menu -->
              <div class="col-xs-6 col-sm-6">
                <div class="form-group">
                  <label class="control-label col-lg-3" for="menu">Menu:</label>
                  <div class="col-lg-9">
                    <select class="form-control select2" name="id_menu" id="id_menu" required>
                      <option value="" disabled selected>Pilih Menu</option>
                      <?php
                      // Ambil semua menu dari tbl_user_main_menu
                      $menus = $this->db->get('tbl_user_main_menu')->result();
                      foreach ($menus as $menu) {
                        // Menentukan apakah menu ini adalah menu yang saat ini dipilih
                        $selected = ($menu->id_menu == $menu_access->id_menu) ? 'selected' : '';
                        echo "<option value='{$menu->id_menu}' $selected>{$menu->menu_name}</option>";
                      }
                      ?>
                    </select>
                  </div>
                </div>
              </div>

              <!-- Kategori Menu -->
              <div class="col-xs-6 col-sm-6">
  <div class="form-group">
    <label class="control-label col-lg-3" for="has_access">Access:</label>
    <div class="col-lg-9">
      <select class="form-control" name="has_access" id="has_access" required>
        <option value="1" <?php echo ($menu_access->has_access == 1) ? 'selected' : ''; ?>>Ya</option>
        <option value="0" <?php echo ($menu_access->has_access == 0) ? 'selected' : ''; ?>>Tidak</option>
      </select>
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

<script>
  // Inisialisasi Select2
  $(document).ready(function() {
    $('.select2').select2();
  });
</script>
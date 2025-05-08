<style>
  .under-construction {
    text-align: center;
    color: #777;
    padding: 50px 0;
  }

  .under-construction .fa-cog {
    font-size: 50px;
    animation: spin 2s infinite linear;
  }

  @keyframes spin {
    0% {
      transform: rotate(0deg);
    }

    100% {
      transform: rotate(360deg);
    }
  }

  .under-construction h1 {
    font-size: 16px;
    margin: 20px 0;
  }
</style>
<div class="container">
  <!-- Content area -->
  <div class="content">
    <!-- Dashboard content -->
    <div class="row">
      <div class="col-md-1"></div>
      <div class="panel panel-flat col-md-9">
        <?php
        echo $this->session->flashdata('msg');
        ?>
        <div class="panel-body">
          <div class="navigation-buttons">
            <div class="btn-group" style="float: left;">
              <!-- Tombol Back (di pojok kiri atas) -->
              <i class="fa fa-warning"></i> Under Construction
            </div>
            <div class="btn-group" style="float: right;">
              <!-- Tombol Dropdown (di pojok kanan atas) -->
              <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-bars"></i>
              </button>
              <!-- Isi Dropdown -->
              <ul class="dropdown-menu dropdown-menu-right" role="menu">
                <li><a href="<?php echo site_url('users/'); ?>"><i class="fa fa-wrench"></i> Sub #1</a></li>
                <li><a href="<?php echo site_url('users/'); ?>"><i class="fa fa-wrench"></i> Sub #2</a></li>
              </ul>
            </div>
          </div>
          <div class="clearfix"></div>
          <hr>
          <fieldset class="content-group">
            <div class="under-construction">
              <i class="fa fa-cog"></i>
              <h1>Halaman dalam proses pengembangan</h1>
            </div>
            <div class="row">
              <div class="col-md-12">
                <a href="users/" class="btn btn-default">
                  << Kembali</a>
              </div>
            </div>
          </fieldset>
        </div>
      </div>
    </div>
    <!-- /dashboard content -->
  </div>
</div>
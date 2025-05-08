<!-- Main content -->
<div class="container">
  <!-- Content area -->
  <div class="content">
    <br><br>
    <!-- Dashboard content -->

    <div class="row">
      <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
        <div class="panel panel-flat">

          <?php
          echo $this->session->flashdata('msg');
          ?>
          <div class="panel-body">
            <div class="navigation-buttons text-right">
              <div class="btn-group">
                <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-bars"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-right" role="menu">
                  <li><a href="users/sm"><i class="fa fa-hourglass-half"></i> Menunggu Proses</a></li>
                  <li><a href="users/ss"><i class="fa fa-check-circle"></i> Selesai Otorisasi</a></li>
                  <li><a href="users/lap_sm"><i class="fa fa-file"></i> Laporan Otorisasi</a></li>
                </ul>
              </div>
            </div>
            <fieldset class="content-group">
              <legend class="text-bold"><i class="icon-printer"></i> Laporan Otorisasi</legend>
              <form class="form-inline" action="" method="post">
                <div class="form-group">Tgl Transaksi
                  <div class="input-group">
                    <!-- <div class="input-group-addon"><i class="icon-calendar22"></i></div> -->
                    <input type="date" name="tgl1" class="form-control daterange-single" value="" maxlength="10" required>
                  </div>
                </div>
                &nbsp; Sampai
                <div class="form-group">
                  <div class="input-group">
                    <!-- <div class="input-group-addon"><i class="icon-calendar22"></i></div> -->
                    <input type="date" name="tgl2" class="form-control daterange-single" value="" maxlength="10" required>
                  </div>
                </div>
                <button type="submit" name="data_lap" class="btn btn-danger" style="float:right;">Enter</button>
              </form>
            </fieldset>
          </div>

        </div>
        <div class="col-md-2"></div>
      </div>
    </div>
  </div>
</div>
<!-- /dashboard content -->
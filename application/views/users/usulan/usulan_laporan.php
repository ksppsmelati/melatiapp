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
            <fieldset class="content-group">
              <legend class="text-bold"><i class="icon-printer"></i> Laporan Usulan</legend>
              <form class="form-inline" action="" method="post">
                <div class="form-group">Dari Tanggal
                  <div class="input-group">
                    <div class="input-group-addon"><i class="icon-calendar22"></i></div>
                    <input type="date" name="tgl1" class="form-control daterange-single" value="" maxlength="10" required>
                  </div>
                </div>
                &nbsp; Sampai
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-addon"><i class="icon-calendar22"></i></div>
                    <input type="date" name="tgl2" class="form-control daterange-single" value="" maxlength="10" required>
                  </div>
                </div>
                <button type="submit" name="usulan_data_laporan" class="btn btn-danger" style="float:right;"><i class="fa-solid fa-magnifying-glass"></i></button>
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
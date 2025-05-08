<!-- Main content -->
<div class="content-wrapper">
  <!-- Content area -->
  <div class="content">
<br><br>
<div class="container">
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
                            <a href="javascript:history.go(-1);" class="btn btn-light btn-sm">
                              <i class="fa fa-arrow-left"></i> 
                            </a>
                          </div>
                        </div>
                        <!-- Membersihkan float -->
                        <div class="clearfix"></div>
            <fieldset class="content-group">
              <legend class="text-bold"><i class="fa fa fa-calendar"></i> Aplikasi</legend>
               <div class="table-responsive">
                   <iframe src=""></iframe>
                </div>
            </fieldset>
          </div>

      </div>
    </div>
    <!-- /dashboard content -->
    </div>


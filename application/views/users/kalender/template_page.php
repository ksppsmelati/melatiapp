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
              <i class="fa fa-star"></i> Judul
            </div>
            <div class="btn-group" style="float: right;">
              <!-- Tombol Dropdown (di pojok kanan atas) -->
              <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-bars"></i>
              </button>
              <!-- Isi Dropdown -->
              <ul class="dropdown-menu dropdown-menu-right" role="menu">
                <li><a href="<?php echo site_url('users/'); ?>"><i class="fa fa-star"></i> Sub #1</a></li>
                <li><a href="<?php echo site_url('users/'); ?>"><i class="fa fa-star"></i> Sub #2</a></li>
              </ul>
            </div>
          </div>
          <div class="clearfix"></div>
          <hr>
          <fieldset class="content-group">
            <div class="table-responsive">
              <table class="table datatable-basic" width="100%">
                <thead>
                  <tr>
                    <th>No</th>
                    <th style="position: sticky; left: 0; z-index: 1; background:#fff;">Item</th>
                    <th>Quantity</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td style="position: sticky; left: 0; z-index: 1; background:#fff;">Apples</td>
                    <td>5</td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <td style="position: sticky; left: 0; z-index: 1; background:#fff;">Bananas</td>
                    <td>7</td>
                  </tr>
                  <tr>
                    <td>3</td>
                    <td style="position: sticky; left: 0; z-index: 1; background:#fff;">Oranges</td>
                    <td>3</td>
                  </tr>
                </tbody>
              </table>
              <!-- isi conten -->
            </div>
          </fieldset>
        </div>
      </div>
    </div>
    <!-- /dashboard content -->
  </div>
</div>
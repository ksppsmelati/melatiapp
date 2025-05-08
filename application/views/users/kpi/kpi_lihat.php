<div class="container">
    <!-- Content area -->
    <div class="content">
        <!-- Dashboard content -->
        <div class="row">
            <div class="col-md-1"></div>
            <div class="panel panel-flat">
                <?php echo $this->session->flashdata('msg'); ?>
                <div class="panel-body">
                    <div class="navigation-buttons">
                        <div class="btn-group" style="float: left;">
                            <!-- Tombol Back (di pojok kiri atas) -->
                            <a href="<?= base_url('users/kpi_info') ?>" class="btn btn-light btn-sm"><i class="fa fa-arrow-left"></i> Kembali</a>
                        </div>
                        <div class="btn-group" style="float: right;">
                            <!-- Tombol Dropdown (di pojok kanan atas) -->
                            <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bars"></i>
                            </button>
                            <!-- Isi Dropdown -->
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <li><a href="<?= base_url('kpi/edit/' . $kpi->id_kpi) ?>"><i class="fa fa-pencil"></i> Edit</a></li>
                                <li><a href="<?= base_url('kpi/delete/' . $kpi->id_kpi) ?>" onclick="return confirm('Are you sure you want to delete this item?')"><i class="fa fa-trash"></i> Delete</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                    <fieldset class="content-group">
                        <div class="form-group">
                            <label for="tgl">Tanggal</label>
                            <input type="text" class="form-control" id="tgl" value="<?= $kpi->tgl ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="id_user">Nama</label>
                            <input type="text" class="form-control" id="id_user" value="<?= strtoupper($kpi->nama_lengkap) ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="id_user">Level</label>
                            <input type="text" name="level" class="form-control" value="<?= $levelText = getLevelText($kpi->level) ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="nilai">Nilai</label>
                            <input type="text" class="form-control" id="nilai" value="<?= $kpi->nilai ?>" readonly>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
        <!-- /dashboard content -->
    </div>
</div>

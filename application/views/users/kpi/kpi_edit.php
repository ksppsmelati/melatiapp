<div class="container">
    <div class="content">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h4 class="panel-title">Edit KPI</h4>
                </div>
                <div class="panel-body">
                    <?php echo form_open('users/kpi/kpi_update/' . $kpi->id_kpi); ?>
                    <div class="form-group">
                        <label for="tgl">Tanggal</label>
                        <input type="date" name="tgl" class="form-control" value="<?= $kpi->tgl ?>" required>
                    </div>
                    <div class="form-group">
                            <label for="id_user">User</label>
                            <input type="text" class="form-control" id="id_user" value="<?= strtoupper($kpi->nama_lengkap) ?>" readonly>
                        </div>
                    <input type="hidden" name="id_user" value="<?= $kpi->id_user ?>">
                    <div class="form-group">
                        <label for="level">Level</label>
                        <input type="text" name="level" class="form-control" value="<?= $levelText = getLevelText($kpi->level) ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="nilai">Nilai</label>
                        <input type="number" name="nilai" class="form-control" value="<?= $kpi->nilai ?>" required>
                    </div>
                    <button type="submit" class="btn btn-danger" style="float:right;"> Update</button>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
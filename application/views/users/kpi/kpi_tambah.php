<style>
    label {
        font-weight: bold;
    }
</style>

<div class="container">
    <div class="content">
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <div class="navigation-buttons">
                        <div class="btn-group" style="float: left;">
                            <i class="fa fa-star"></i> Tambah KPI
                        </div>

                        <div class="btn-group" style="float: right;">
                            <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bars"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <li><a href="<?php echo site_url('users/kpi_info'); ?>"><i class="fa fa-file"></i> KPI Data</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <hr>

                    <!-- Form untuk menyimpan KPI satu per satu -->
                    <?php echo form_open('users/kpi_simpan'); ?>
                    <div class="col-xs-6 col-sm-6">
                        <div class="form-group">
                            <label for="tgl">Tanggal</label>
                            <input type="date" id="tgl" name="tgl" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6">
                        <div class="form-group">
                            <label for="nama_lengkap">Nama Lengkap:</label>
                            <select class="form-control" id="nama_lengkap" name="nama_lengkap" onchange="updateUserID()" required>
                                <option value="" disabled selected>Pilih User</option>
                                <?php if (!empty($users)) : ?>
                                    <?php foreach ($users as $user) : ?>
                                        <option value="<?= $user['id_user']; ?>"><?= strtoupper($user['nama_lengkap']); ?></option>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <option value="" disabled>Tidak ada user tersedia</option>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6">
                        <input type="hidden" id="id_user_hidden" name="id_user">
                        <div class="form-group">
                            <label>Nilai</label>
                            <input type="number" name="nilai" class="form-control" placeholder="Masukkan nilai" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-danger" style="float:right;">Simpan</button>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="panel panel-flat">
                <?php
                echo $this->session->flashdata('msg');
                ?>
                <div class="panel-body">
                    <!-- Form untuk menyimpan KPI untuk semua user -->
                    <h4>Tambah KPI untuk Semua User</h4>
                    <?php echo form_open('users/kpi_simpan_semua'); ?>
                    <div class="col-xs-6 col-sm-6">
                        <div class="form-group">
                            <label for="tgl_semua">Tanggal</label>
                            <input type="date" id="tgl_semua" name="tgl_semua" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6">
                        <div class="form-group">
                            <label for="nilai_semua">Nilai</label>
                            <input type="number" name="nilai_semua" class="form-control" placeholder="Masukkan nilai" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-danger" style="float:right;">Simpan Semua</button>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#nama_lengkap').select2({
            placeholder: "Pilih User",
            allowClear: true
        });
    });

    function updateUserID() {
        var select = document.getElementById('nama_lengkap');
        var hiddenInput = document.getElementById('id_user_hidden');
        hiddenInput.value = select.options[select.selectedIndex].value;
    }
</script>
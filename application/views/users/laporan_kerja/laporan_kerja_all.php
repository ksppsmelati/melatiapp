<div class="container">
    <!-- Content area -->
    <div class="content">
        <?php echo $this->session->flashdata('msg'); ?>
        <!-- Data Laporan Kerja content -->
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="navigation-buttons">
                        <div class="btn-group" style="float: left;">
                            <!-- Tombol Back (di pojok kiri atas) -->
                            <a href="javascript:history.go(-1);" class="btn btn-light btn-sm">
                                <i class="fa fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                        <div class="btn-group" style="float: right;">
                            <!-- Tombol Dropdown (di pojok kanan atas) -->
                            <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bars"></i>
                            </button>
                            <!-- Isi Dropdown -->
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <li><a href="<?php echo site_url('users/laporan_kerja'); ?>"><i class="fa fa-plus"></i> Tambah Laporan Kerja</a></li>
                                <li><a href="<?php echo site_url('users/data_laporan_kerja'); ?>"><i class="fa fa-file"></i> Data Laporan Kerja</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Membersihkan float -->
                    <div class="clearfix"></div>
                    <legend class="text-bold"><i class="fa fa-briefcase"></i> Semua Laporan Kerja </legend>
                    <div class="clearfix"></div>
                    <a href="<?= base_url('users/laporan_kerja_export_all?bulan=' . $selectedMonth . '&tahun=' . $selectedYear) ?>" class="btn btn-primary">Export Word</a>
                    <hr>

                    <!-- Form untuk memilih bulan dan tahun -->
                    <form method="post" action="<?php echo site_url('users/laporan_kerja_all'); ?>">
                        <div class="col-xs-5">
                            <select name="bulan" id="bulan" class="form-control">
                                <?php
                                // Generate options for months
                                for ($i = 1; $i <= 12; $i++) {
                                    $month = date("F", mktime(0, 0, 0, $i, 1));
                                    $selected = ($i == $selectedMonth) ? 'selected' : '';
                                    echo "<option value='$i' $selected>$month</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-xs-5">
                            <select name="tahun" id="tahun" class="form-control">
                                <?php
                                // Generate options for years (adjust the range as needed)
                                for ($i = date("Y"); $i >= 2020; $i--) {
                                    $selected = ($i == $selectedYear) ? 'selected' : '';
                                    echo "<option value='$i' $selected>$i</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                    </form>
                    <!-- Akhir form -->
                </div>
                <!-- Tabel laporan kerja -->
                <?php if (!empty($laporan_kerja)) : ?>
                    <div class="table-responsive">
                        <table class="table datatable-basic" width="100%">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Level</th>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                    <th>Pekerjaan</th>
                                    <th> </th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($laporan_kerja as $laporan) : ?>
                                    <tr>
                                        <td><a href="<?php echo site_url('users/laporan_kerja_lihat/' . $laporan['id']); ?>"><?php echo $laporan['nama_lengkap']; ?></a></td>
                                        <td><a href="<?php echo site_url('users/laporan_kerja_lihat/' . $laporan['id']); ?>"><?php echo $levelText = getLevelText($laporan['level']); ?></a></td>
                                        <td><a href="<?php echo site_url('users/laporan_kerja_lihat/' . $laporan['id']); ?>"><?php echo date('Y-m-d', strtotime($laporan['tanggal'])); ?></a></td>
                                        <td><a href="<?php echo site_url('users/laporan_kerja_lihat/' . $laporan['id']); ?>"><?php echo $laporan['jam']; ?></a></td>
                                        <td><a href="<?php echo site_url('users/laporan_kerja_lihat/' . $laporan['id']); ?>"><?php echo htmlspecialchars(substr(strip_tags($laporan['pekerjaan']), 0, 50)); ?>...</a></td>
                                        <td>
                                            <?php if ($laporan['approval'] == 1) : ?>
                                                <a href="<?php echo site_url('users/laporan_kerja_lihat/' . $laporan['id']); ?>">
                                                    <i class="fa fa-check-circle text-success"></i>
                                                </a>
                                            <?php else : ?>
                                                <i class="fa fa-clock"></i>
                                            <?php endif; ?>
                                        </td>

                                        <td>
                                        <a href="<?php echo site_url('users/data_laporan_kerja_approval/' . $laporan['id']); ?>" class="btn btn-primary btn-sm"><i class="fa fa-check"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else : ?>
                    <div style="text-align: center;">
                        <p>Tidak ada data laporan kerja yang ditemukan.</p>
                    </div>
                <?php endif; ?>
                <!-- Akhir tabel laporan kerja -->
            </div>
        </div>
        <!-- Data Laporan Kerja content -->
    </div>
    <!-- /content area -->
</div>
<!-- /main content -->
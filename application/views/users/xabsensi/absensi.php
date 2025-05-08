<?php
$cek = $user->row();
$id_user = $cek->id_user;
$nama = $cek->nama_lengkap;
$level = $cek->level;
$status = $cek->status;
$kode_kantor = $cek->kode_kantor;

$tgl = date('m-Y');
// Contoh nilai level dari variabel $level
$level = $cek->level;

// You need to define the following functions and variables:
// - tgl_hari($date): Format a date as needed.
// - is_weekend(): Check if the current day is a weekend.
// - $absen: Variable to determine the user's attendance status.

?>

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
                        <div class="navigation-buttons text-right">
                            <div class="btn-group">
                                <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-bars"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                    <li><a href="users/absensi/absensi"><i class="fa fa-sign-in"></i> Absen</a></li>
                                    <li><a href="users/absensi/detail_absensi"><i class="fa fa-check"></i> Detail</a></li>
                                </ul>
                            </div>
                        </div>
                        <fieldset class="content-group">
                            <legend class="text-bold"><i class="fa fa-fingerprint"></i> Absensi KSPPS MELATI</legend>
                            <i><?= tgl_hari(date('d-m-Y')) ?></i>
                            <div class="table-responsive">
                                <div class="card-body">
                                    <table class="table w-100">
                                        <thead>
                                            <th>Status</th>
                                            <!-- <th>Tanggal</th> -->
                                            <th>Absen Masuk</th>
                                            <th>Absen Pulang</th>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <?php if (is_weekend()) : ?>
                                                    <td class="bg-light text-danger" colspan="4">Hari ini libur. Tidak Perlu absen</td>
                                                <?php else : ?>
                                                    <td><i class="fa fa-3x <?= ($absen < 2) ? 'fa-exclamation-triangle text-warning' : 'fa-check-circle text-success' ?>"></i></td>
                                                    <td><?= tgl_hari(date('d-m-Y')) ?></td>
                                                    <td>
                                                        <a href="<?= base_url('users/absensi/absensi/masuk') ?>" class="btn btn-primary btn-sm btn-fill" <?= ($absen == 1) ? 'disabled style="cursor:not-allowed"' : '' ?>>Absen Masuk</a>
                                                    </td>
                                                    <td>
                                                        <a href="<?= base_url('users/absensi/absensi/pulang') ?>" class="btn btn-success btn-sm btn-fill" <?= ($absen !== 1 || $absen == 2) ? 'disabled style="cursor:not-allowed"' : '' ?>>Absen Pulang</a>
                                                    </td>
                                                <?php endif; ?>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
            <!-- /dashboard content -->
        </div>
        <!-- batas -->
        <div class="container">
            <!-- Dashboard content -->
            <div class="row">
                <div class="col-md-1"></div>
                <div class="panel panel-flat col-md-9">
                    <?php
                    echo $this->session->flashdata('msg');
                    ?>

                    <div class="panel-body">
                        <fieldset class="content-group">
                            <legend class="text-bold"><i class="fa fa-user"></i> Detail Absen</legend>
                            
                                <div class="card-body">
                                    <!-- detail -->
                                    <div class="row mb-2">

                                        <div class="col-xs-12 col-sm-6 ml-auto text-right">
                                            <form action="" method="get">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="bulan">Pilih Bulan</label>
                                                            <select name="bulan" id="bulan" class="form-control">
                                                                <option value="" disabled selected>-- Pilih Bulan --</option>
                                                                <?php foreach ($all_bulan as $bn => $bt) : ?>
                                                                    <option value="<?= $bn ?>" <?= ($bn == $bulan) ? 'selected' : '' ?>><?= $bt ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="tahun">Pilih Tahun</label>
                                                            <select name="tahun" id="tahun" class="form-control">
                                                                <option value="" disabled selected>-- Pilih Tahun --</option>
                                                                <?php for ($i = date('Y'); $i >= (date('Y') - 5); $i--) : ?>
                                                                    <option value="<?= $i ?>" <?= ($i == $tahun) ? 'selected' : '' ?>><?= $i ?></option>
                                                                <?php endfor; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>&nbsp;</label>
                                                            <button type="submit" class="btn btn-primary btn-fill btn-block">Tampilkan</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header border-bottom">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-6">
                                                            <table class="table border-0">
                                                                <tr>
                                                                    <th class="border-0 py-0">Nama</th>
                                                                    <th class="border-0 py-0">:</th>
                                                                    <th class="border-0 py-0"><?= $nama ?></th>
                                                                </tr>
                                                                <tr>
                                                                    <th class="border-0 py-0">Level</th>
                                                                    <th class="border-0 py-0">:</th>
                                                                    <th class="border-0 py-0"><?= $level ?></th>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-6 ml-auto text-right mb-2">
                                                            <div class="dropdown d-inline">
                                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="droprop-action" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="fa fa-print"></i>
                                                                    Export Laporan
                                                                </button>
                                                                <div class="dropdown-menu" aria-labelledby="droprop-action">
                                                                    <a href="<?= base_url('absensi/export_pdf/' . $this->uri->segment(3) . "?bulan=$bulan&tahun=$tahun") ?>" class="dropdown-item" target="_blank"><i class="fa fa-file-pdf-o"></i> PDF</a>
                                                                    <a href="<?= base_url('absensi/export_excel/' . $this->uri->segment(3) . "?bulan=$bulan&tahun=$tahun") ?>" class="dropdown-item" target="_blank"><i class="fa fa-file-excel-o"></i> Excel</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <h4 class="card-title mb-4">Absen Bulan : <?= bulan($bulan) . ' ' . $tahun ?></h4>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <th>No</th>
                                                                <th>Tanggal</th>
                                                                <th>Jam Masuk</th>
                                                                <th>Jam Keluar</th>
                                                            </thead>
                                                            <tbody>
                                                                <?php if ($absen) : ?>
                                                                    <?php foreach ($hari as $i => $h) : ?>
                                                                        <?php
                                                                        $absen_harian = array_search($h['tgl'], array_column($absen, 'tgl')) !== false ? $absen[array_search($h['tgl'], array_column($absen, 'tgl'))] : '';
                                                                        ?>
                                                                        <tr <?= (in_array($h['hari'], ['Sabtu', 'Minggu'])) ? 'class="bg-danger text-white"' : '' ?>>
                                                                            <td><?= ($i + 1) ?></td>
                                                                            <td><?= $h['hari'] . ', ' . $h['tgl'] ?></td>
                                                                            <td><?= is_weekend($h['tgl']) ? 'Libur Akhir Pekan' : check_jam(@$absen_harian['jam_masuk'], 'masuk') ?></td>
                                                                            <td><?= is_weekend($h['tgl']) ? 'Libur Akhir Pekan' : check_jam(@$absen_harian['jam_pulang'], 'pulang') ?></td>
                                                                        </tr>
                                                                    <?php endforeach; ?>
                                                                <?php else : ?>
                                                                    <tr>
                                                                        <td class="bg-light text-center" colspan="4">Tidak ada data absen</td>
                                                                    </tr>
                                                                <?php endif; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <!-- /detail -->
                                </div>
                            
                        </fieldset>
                    </div>
                </div>
            </div>
            <!-- /dashboard content -->
        </div>
    </div>
</div>
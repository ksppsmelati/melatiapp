<?php
$cek = $user->row();
$id_user = $cek->id_user;
$nama = $cek->nama_lengkap;
$level = $cek->level;
$status = $cek->status;
$kode_kantor = $cek->kode_kantor;
$tgl = date('m-Y');
?>

<!-- Main content -->
<div class="container">
    <!-- Content area -->
    <div class="content">
        <!-- Dashboard content -->
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <?php
                    echo $this->session->flashdata('msg');
                    ?>
                    <div class="btn-group" style="float: left;">
                            <!-- Tombol Back (di pojok kiri atas) -->
                            <i class="fa fa-file-text"></i> Data Absen
                        </div>
                    <div class="navigation-buttons text-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bars"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <li><a href="<?= base_url('users/absensi/check_absen'); ?>"><i class="fa fa-fingerprint"></i> Absen</a></li>
                                <li><a href="<?= base_url('users/absensi/detail_absensi'); ?>"><i class="fa fa-file-text"></i> Data Absen</a></li>
                            </ul>
                        </div>
                    </div>
                    <br>
                    <div class="row mb-2">
                        <!-- <h4 class="col-xs-12 col-sm-6 mt-0">Detail Absen : <b><?= bulan($bulan) . ' ' . $tahun ?></b></h4> -->
                        <div class="col-xs-12 col-sm-6 ml-auto text-left">
                            <form action="" method="get">
                                <div class="row">
                                    <div class="col-xs-5">
                                        <select name="bulan" id="bulan" class="form-control">
                                            <option value="" disabled selected>-- Pilih Bulan --</option>
                                            <?php foreach ($all_bulan as $bn => $bt) : ?>
                                                <option value="<?= $bn ?>" <?= ($bn == $bulan) ? 'selected' : '' ?>>
                                                    <?= $bt ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-xs-5">
                                        <select name="tahun" id="tahun" class="form-control">
                                            <option value="" disabled selected>-- Pilih Tahun --</option>
                                            <?php for ($i = date('Y'); $i >= (date('Y') - 5); $i--) : ?>
                                                <option value="<?= $i ?>" <?= ($i == $tahun) ? 'selected' : '' ?>>
                                                    <?= $i ?>
                                                </option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>

                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header border-bottom">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6 ml-auto text-right mb-2">
                                            <div class="btn-group">
                                                <a href="<?= base_url('users/export_excel/' . $this->uri->segment(3) . "?bulan=$bulan&tahun=$tahun") ?>" class="btn btn-secondary">
                                                    <i class="fa fa-file-excel"></i> Export
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <!-- <div class="navigation-buttons">
                        <div class="btn-group" style="float: left;">
                            <small><?= $nama ?> | <?= bulan($bulan) . ' ' . $tahun ?></small>
                        </div>
                    </div> -->
                </div>
                <div class="table-responsive">
                    <table class="table datatable-basic" width="100%">
                        <!-- <div class="table-responsive">
                                    <table class="table datatable-basic table-bordered"> -->
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
                                    <tr <?= (in_array($h['hari'], ['Sabtu', 'Minggu'])) ? 'style="background-color: #f44336; color: #fff;"' : '' ?> <?= ($absen_harian == '') ? '' : '' ?>>
                                        <td>
                                            <?= ($i + 1) ?>
                                        </td>
                                        <td>
                                            <?= $h['hari'] . ', ' . $h['tgl'] ?>
                                        </td>
                                        <td>
                                            <?= is_weekend($h['tgl']) ? 'Libur Akhir Pekan' : check_jam(@$absen_harian['jam_masuk'], 'masuk') ?>
                                        </td>
                                        <td>
                                            <?= is_weekend($h['tgl']) ? 'Libur Akhir Pekan' : check_jam(@$absen_harian['jam_pulang'], 'pulang') ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                               <!-- kosong -->
                            <?php endif; ?>
                        </tbody>
                        <!-- </table>
                                </div> -->
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /dashboard content -->
</div>
<?php
$cek = $user->row();
$id_user = $cek->id_user;
$nama = $cek->nama_lengkap;
$level = $cek->level;
$status = $cek->status;
$kode_kantor = $cek->kode_kantor;
$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m'); // Default to current month
$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y'); // Default to current year
?>
<!-- Di view (misalnya kpi_view.php) -->
<style>
    .container {
        width: 100%;
        margin: 0;
        padding: 0;
    }
</style>
<div class="container">
    <div class="content">
        <div class="row">
            <div class="panel panel-flat">
                <?php echo $this->session->flashdata('msg'); ?>
                <div class="panel-body">
                    <div class="navigation-buttons">
                        <div class="btn-group" style="float: left;">
                            <i class="fa fa-star"></i> DATA KPI KARYAWAN
                        </div>
                        <div class="btn-group" style="float: right;">
                            <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bars"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <li><a href="<?php echo site_url('users/'); ?>"><i class="fa fa-star"></i> Sub #1</a></li>
                                <li><a href="<?php echo site_url('users/'); ?>"><i class="fa fa-star"></i> Sub #2</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <a href="users/kpi/kpi_tambah" class="btn btn-danger">+ Tambah</a>
                    <hr>
                    <form action="<?= base_url('users/kpi_data') ?>" method="get">
                        <div class="row">
                            <div class="col-xs-5">
                                <select name="bulan" id="bulan" class="form-control">
                                    <?php for ($i = 1; $i <= 12; $i++) : ?>
                                        <option value="<?= str_pad($i, 2, '0', STR_PAD_LEFT) ?>" <?= ($i == $bulan) ? 'selected' : '' ?>>
                                            <?= DateTime::createFromFormat('!m', $i)->format('F') ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="col-xs-5">
                                <select name="tahun" id="tahun" class="form-control">
                                    <?php
                                    $current_year = date('Y');
                                    for ($i = $current_year - 5; $i <= $current_year + 5; $i++) :
                                    ?>
                                        <option value="<?= $i ?>" <?= ($i == $tahun) ? 'selected' : '' ?>><?= $i ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="col-xs-1">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="table-responsive">
                    <table class="table datatable-basic" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Nama</th>
                                <!-- <th>ID User</th> -->
                                <th>Nilai</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($kpi as $i => $k) : ?>
                                <tr>
                                    <td><?= ($i + 1) ?></td>
                                    <td><?= $k['tgl'] ?></td>
                                    <td><?= strtoupper($k['nama_lengkap'] ?? '') ?></td>
                                    <!-- <td><?= $k['id_user'] ?></td> -->
                                    <td><?= $k['nilai'] ?></td>
                                    <td>
                                        <a href="<?= base_url('users/kpi/kpi_lihat/' . $k['id_kpi']) ?>" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
                                        <a href="<?= base_url('users/kpi/kpi_edit/' . $k['id_kpi']) ?>" class="btn btn-success btn-xs"><i class="icon-pencil7"></i></a>
                                        <a href="<?= base_url('users/kpi/kpi_hapus/' . $k['id_kpi']) ?>" class="btn btn-danger btn-xs" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"> <i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$cek = $user->row();
$id_user = $cek->id_user;
$nama = $cek->nama_lengkap;
$level = $cek->level;
$status = $cek->status;
$kode_kantor = $cek->kode_kantor;
$tanggal_awal = isset($_GET['tanggal_awal']) ? $_GET['tanggal_awal'] : date('Y-m-d');
$tanggal_akhir = isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : date('Y-m-d');
?>
<style>
    .container {
        width: 100%;
        margin: 0;
        padding: 0;
    }
</style>
<div class="container">
    <!-- Content area -->
    <div class="content">
        <!-- Dashboard content -->
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
                    <form action="<?= base_url('users/kpi_info') ?>" method="get">
                        <div class="row">
                            <div class="col-xs-5">
                                <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control" value="<?= isset($_GET['tanggal_awal']) ? $_GET['tanggal_awal'] : (isset($tanggal_awal) ? $tanggal_awal : date('Y-m-d')) ?>" required>
                            </div>
                            <div class="col-xs-5">
                                <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control" value="<?= isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : (isset($tanggal_akhir) ? $tanggal_akhir : date('Y-m-d')) ?>" required>
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
                                <th>Level</th>
                                <th>Perolehan</th>
                                <th>Total Hadir</th>
                                <!-- <th>Hadir</th> -->
                                <!-- <th>Setengah Hari</th> -->
                                <th>Telat</th>
                                <th>Izin</th>
                                <th>Sakit</th>
                                <!-- <th>Cuti</th> -->
                                <th>Tidak Masuk</th>
                                <th>Poin Kedisiplinan</th>
                                <th>Skor Akhir</th>
                                <th>Monitoring</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($kpi as $i => $k) : ?>
                                <tr>
                                    <td><?= ($i + 1) ?></td>
                                    <td><?= $k->tgl ?></td>
                                    <td><?= strtoupper($k->nama_lengkap) ?></td>
                                    <td><?php echo getLevelText($k->level); ?> <?php echo getKodeKantorText($k->kode_kantor); ?></td>
                                    <td><?= $k->nilai ?></td>
                                    <td><?= isset($rekap[$k->id_user]['total_hadir']) ? $rekap[$k->id_user]['total_hadir'] : 0 ?></td>
                                    <!-- <td><?= isset($rekap[$k->id_user]['hadir']) ? $rekap[$k->id_user]['hadir'] : 0 ?></td> -->
                                    <!-- <td><?= isset($rekap[$k->id_user]['setengah_hari']) ? $rekap[$k->id_user]['setengah_hari'] : 0 ?></td> -->
                                    <td><?= isset($rekap[$k->id_user]['telat']) ? $rekap[$k->id_user]['telat'] : 0 ?></td>
                                    <td><?= isset($rekap[$k->id_user]['izin']) ? $rekap[$k->id_user]['izin'] : 0 ?></td>
                                    <td><?= isset($rekap[$k->id_user]['sakit']) ? $rekap[$k->id_user]['sakit'] : 0 ?></td>
                                    <!-- <td><?= isset($rekap[$k->id_user]['cuti']) ? $rekap[$k->id_user]['cuti'] : 0 ?></td> -->
                                    <td><?= isset($rekap[$k->id_user]['tidak_masuk']) ? $rekap[$k->id_user]['tidak_masuk'] : 0 ?></td>
                                    <td>x</td>
                                    <td>x</td>
                                    <td><?= isset($petugas_counts[$k->id_user]) ? $petugas_counts[$k->id_user] : 0 ?></td>
                                    <td>
                                        <a href="<?= base_url('users/kpi/kpi_lihat/' . $k->id_kpi) ?>" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
                                        <a href="<?= base_url('users/kpi/kpi_edit/' . $k->id_kpi) ?>" class="btn btn-success btn-xs"><i class="icon-pencil7"></i></a>
                                        <a href="<?= base_url('users/kpi/kpi_hapus/' . $k->id_kpi) ?>" class="btn btn-danger btn-xs" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"> <i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <!-- isi conten -->
                </div>
            </div>
        </div>
        <!-- /dashboard content -->
    </div>
</div>
<?php
$cek = $user->row();
$id_user = $cek->id_user;
$nama = $cek->nama_lengkap;
$level = $cek->level;
$status = $cek->status;
$kode_kantor = $cek->kode_kantor;
$tgl = date('m-Y');
$tanggal_awal = isset($_GET['tanggal_awal']) ? $_GET['tanggal_awal'] : date('Y-m-d');
$tanggal_akhir = isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : date('Y-m-d');
?>

<!-- Main content -->
<div class="container">
    <!-- Content area -->
    <div class="content">
        <!-- Dashboard content -->
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <?php
                    echo $this->session->flashdata('msg');
                    ?>

                    <div class="navigation-buttons">
                        <div class="btn-group" style="float: left;">
                            <!-- Tombol Back (di pojok kiri atas) -->
                            <i class="fa fa-calendar"></i> Rekap Absensi Satpam
                        </div>

                        <div class="btn-group" style="float: right;">
                            <!-- Tombol Dropdown (di pojok kanan atas) -->
                            <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bars"></i>
                            </button>
                            <!-- Isi Dropdown -->
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <li><a href="<?php echo site_url('users/absen_info'); ?>"><i class="fa fa-television"></i>Info Absen</a></li>
                                <li><a href="<?php echo site_url('users/edit_absen'); ?>"><i class="fa fa-cog"></i> Kelola Absen</a></li>
                                <li><a href="<?php echo site_url('users/rekap_by_date_range'); ?>"><i class="fa fa-history"></i> Rekap Absen</a></li>
                                <li><a href="<?php echo site_url('users/edit_absen_manual_rekap'); ?>"><i class="fa fa-list-alt"></i> Data Absen Satpam</a></li>
                                <li><a href="<?php echo site_url('users/rekap_by_date_range_manual'); ?>"><i class="fa fa-calendar"></i> Rekap Absen Satpam</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <hr>

                    <form action="<?= base_url('users/rekap_by_date_range_manual') ?>" method="get">
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
                            <br><br><br>
                            
                        </div>
                    </form>
                    <div class="row">
                            <div class="col-xs-3">
                            <a href="<?= base_url('users/export_rekap_by_date_range_manual?tanggal_awal=' . $tanggal_awal . '&tanggal_akhir=' . $tanggal_akhir) ?>" class="btn btn-danger btn-sm">
                                    <i class="fa fa-file-excel"></i> Export
                                </a>
                            </div>
                            <div class="col-xs-9">
                            
                            </div>
                        </div>
                </div>
                <div class="table-responsive">
                    <!-- Table content -->
                    <table class="table datatable-basic" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th style="position: sticky; left: 0; z-index: 1; background:#fff;">Nama Lengkap</th>
                                <th>Hadir</th>
                                <th>Setengah Hari</th>
                                <th>Telat</th>
                                <th>Izin</th>
                                <th>Cuti</th>
                                <th>Sakit</th>
                                <th>Perjalanan Tugas</th>
                                <th>Tidak Masuk</th>
                                <th>Total Hadir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $nomor = 1; ?>
                            <?php foreach ($rekap as $user_id => $userData) : ?>
                                <tr>
                                    <td><?= $nomor++ ?></td>
                                    <td style="position: sticky; left: 0; z-index: 1; background:#fff;"><?= $userData['nama_lengkap'] ?></td>
                                    <td><?= $userData['hadir'] ?></td>
                                    <td><?= $userData['setengah_hari'] ?></td>
                                    <td><?= $userData['telat'] ?></td>
                                    <td><?= $userData['izin'] ?></td>
                                    <td><?= $userData['cuti'] ?></td>
                                    <td><?= $userData['sakit'] ?></td>
                                    <td><?= $userData['perjalanan_tugas'] ?></td>
                                    <td><?= $userData['tidak_masuk'] ?></td>
                                    <td><?= $userData['total_hadir'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <?php
                    echo $this->session->flashdata('msg');
                    ?>
                    <div class="navigation-buttons">
                        <div class="btn-group" style="float: left;">
                            <i class="fa fa-fingerprint"></i> Detail Absensi
                        </div>
                    </div>
                    <br>
                    <hr>
                    <form action="<?= base_url('users/rekap_by_date_range_manual') ?>" method="get">
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
                <div id="scrollable-table" class="table-responsive" style="overflow-x: auto;">
                    <table class="table datatable-basic" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th style="position: sticky; left: 0; z-index: 1; background:#fff;">Nama Lengkap</th>
                                <?php
                                $start_date = strtotime($tanggal_awal);
                                $end_date = strtotime($tanggal_akhir);
                                for ($current_date = $start_date; $current_date <= $end_date; $current_date = strtotime('+1 day', $current_date)) {
                                    $day = date('d', $current_date);
                                    $tgl = date('Y-m-d', $current_date);
                                    $weekendClass = is_weekend($tgl) ? 'text-danger' : ''; // Menambahkan kelas 'text-danger' jika hari akhir pekan
                                ?>
                                    <th class="<?= $weekendClass ?>"><?= $day ?></th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $nomor = 1; ?>
                            <?php foreach ($rekap as $user_id => $userData) : ?>
                                <tr>
                                    <td><?= $nomor++ ?></td>
                                    <td style="position: sticky; left: 0; z-index: 1; background:#fff;"><?= $userData['nama_lengkap'] ?></td>
                                    <?php foreach ($userData['absensi_detail'] as $tgl => $absensi) : ?>
                                        <td>
                                            <?php
                                            // Jika keterangan izin atau cuti tidak kosong, tampilkan keterangan tersebut dengan warna merah untuk izin dan biru untuk cuti
                                            if ($absensi['keterangan'] == 'Izin') {
                                                echo "<span style='color: red;'>Izin</span>";
                                            } elseif ($absensi['keterangan'] == 'Cuti') {
                                                echo "<span style='color: blue;'>Cuti</span>";
                                            } elseif ($absensi['keterangan'] == 'Sakit') {
                                                echo "<span style='color: blue;'>Sakit</span>";
                                            } elseif ($absensi['keterangan'] == 'Perjalanan_tugas') {
                                                echo "<span style='color: blue;'>Perjalanan_tugas</span>";
                                            } else {
                                                // Jika tidak ada izin atau cuti, tampilkan jam masuk dengan warna hijau atau '-' jika tidak ada, dan tampilkan jam pulang dengan warna orange atau '-' jika tidak ada
                                                echo isset($absensi['jam_masuk']) ? check_jam($absensi['jam_masuk'], 'masuk') : " ";
                                                echo "<br>";
                                                echo isset($absensi['jam_pulang']) ? check_jam($absensi['jam_pulang'], 'pulang') : " ";
                                            }
                                            ?>
                                        </td>
                                    <?php endforeach; ?>

                                </tr>
                            <?php endforeach; ?>

                        </tbody>

                    </table>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                let isDragging = false;
                let startPositionX;
                let startScrollLeft;

                $("#scrollable-table").on("mousedown", function(event) {
                    isDragging = true;
                    startPositionX = event.pageX;
                    startScrollLeft = $(this).scrollLeft();
                });

                $(document).on("mousemove", function(event) {
                    if (isDragging) {
                        let deltaX = event.pageX - startPositionX;
                        $("#scrollable-table").scrollLeft(startScrollLeft - deltaX);
                    }
                });

                $(document).on("mouseup", function() {
                    isDragging = false;
                });
            });
        </script>
    </div>
</div>
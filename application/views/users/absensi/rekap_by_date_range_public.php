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


function get_nama_hari($timestamp)
{
    $hari = array(
        0 => 'Minggu',
        1 => 'Senin',
        2 => 'Selasa',
        3 => 'Rabu',
        4 => 'Kamis',
        5 => 'Jumat',
        6 => 'Sabtu'
    );
    return $hari[date('w', $timestamp)];
}

?>

<style>
    .table {
        border-collapse: collapse;
        width: 100%;
    }

    .table th,
    .table td {
        padding: 10px;
        text-align: center;
        border: 1px solid #dee2e6;
    }

    .table th {
        background-color: #f8f9fa;
        font-weight: bold;
    }

    .badge {
        padding: 5px 10px;
        border-radius: 5px;
        color: #fff;
        font-weight: bold;
    }

    .badge-danger {
        background-color: #e74c3c;
        /* red */
    }

    .badge-info {
        background-color: #3498db;
        /* blue */
    }

    .badge-purple {
        background-color: #9b59b6;
        /* purple */
    }

    .badge-primary {
        background-color: #2980b9;
        /* dark blue */
    }

    tr:hover {
        background-color: #f1f1f1;
    }

    /* Hide scrollbar for Webkit browsers */
    #scrollable-table::-webkit-scrollbar {
        display: none;
    }

    /* Hide scrollbar for Internet Explorer and Edge */
    #scrollable-table {
        -ms-overflow-style: none;
        /* IE and Edge */
        scrollbar-width: none;
        /* Firefox */
    }
</style>

<!-- Main content -->
<div class="container">
    <div class="content">
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <?= $this->session->flashdata('msg'); ?>

                    <div class="navigation-buttons">
                        <div class="btn-group" style="float: left;">
                            <i class="fa-solid fa-user-clock"></i> Rekap Absensi
                        </div>
                    </div>
                    <hr>

                    <form action="<?= base_url('users/rekap_by_date_range_public') ?>" method="get">
                        <div class="row">
                            <div class="col-xs-5">
                                <input type="date" name="tanggal_awal" class="form-control" value="<?= $tanggal_awal ?>" required>
                            </div>
                            <div class="col-xs-5">
                                <input type="date" name="tanggal_akhir" class="form-control" value="<?= $tanggal_akhir ?>" required>
                            </div>
                            <div class="col-xs-2">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </form>

                    <hr>
                    <div class="row">
                        <div class="col-xs-3">
                            <button type="button" class="btn btn-info">
                                <span>Hari Kerja: </span><strong><?= $totalWorkingDays ?></strong>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- <div class="table-responsive">
                    <table class="table table-striped" width="100%">
                        <thead>
                            <tr>
                                <th>Hadir Lengkap</th>
                                <th>Setengah Hari</th>
                                <th>Telat</th>
                                <th>Izin</th>
                                <th>Cuti</th>
                                <th>Sakit</th>
                                <th>Perjalanan Tugas</th>
                                <th>Mangkir</th>
                                <th>Total Hadir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rekap as $user_id => $userData) : ?>
                                <tr>
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
                </div> -->

                <!-- Chart Section -->
                <div class="chart-container" style="margin-top: 30px;">
                    <div id="attendance-chart"></div>
                </div>

                <div id="scrollable-table" class="table-responsive" style="overflow-x: auto; overflow-y: hidden; width: 100%;">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <?php
                                $start_date = strtotime($tanggal_awal);
                                $end_date = strtotime($tanggal_akhir);
                                for ($current_date = $start_date; $current_date <= $end_date; $current_date = strtotime('+1 day', $current_date)) {
                                    $day = date('d', $current_date);
                                    $tgl = date('Y-m-d', $current_date);
                                    $weekendClass = is_weekend($tgl) ? 'text-danger' : '';
                                    // Ganti nama hari dengan bahasa Indonesia
                                    $hari = get_nama_hari($current_date); // Fungsi untuk mendapatkan nama hari dalam bahasa Indonesia
                                ?>
                                    <th class="<?= $weekendClass ?>"><?= $day . ' (' . $hari . ')' ?></th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rekap as $user_id => $userData) : ?>
                                <tr>
                                    <?php foreach ($userData['absensi_detail'] as $tgl => $absensi) : ?>
                                        <td>
                                            <?php
                                            // Tampilkan detail kehadiran
                                            if ($absensi['keterangan'] == 'Izin') {
                                                echo "<span class='badge badge-info'>Izin</span>";
                                            } elseif ($absensi['keterangan'] == 'Cuti') {
                                                echo "<span class='badge' style='background-color: #800080;'>Cuti</span>";
                                            } elseif ($absensi['keterangan'] == 'Sakit') {
                                                echo "<span class='badge' style='background-color: #fd7e14;'>Sakit</span>";
                                            } elseif ($absensi['keterangan'] == 'Perjalanan_tugas') {
                                                echo "<span class='badge' style='background-color: #20c997;'>Perjalanan Tugas</span>";
                                            } else {
                                                echo "Masuk: " . (isset($absensi['jam_masuk']) ? check_jam($absensi['jam_masuk'], 'masuk') : "-");
                                                echo "<br>";
                                                echo "Pulang: " . (isset($absensi['jam_pulang']) ? check_jam($absensi['jam_pulang'], 'pulang') : "-");
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
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Prepare data for the chart
    const attendanceData = {
        labels: [],
        hadir: [],
        setengah_hari: [],
        telat: [],
        izin: [],
        cuti: [],
        sakit: [],
        perjalanan_tugas: []
    };

    <?php foreach ($rekap as $user_id => $userData) : ?>
        attendanceData.labels.push('<?= $userData['nama_lengkap'] ?>');
        attendanceData.hadir.push(<?= $userData['hadir'] ?>);
        attendanceData.setengah_hari.push(<?= $userData['setengah_hari'] ?>);
        attendanceData.telat.push(<?= $userData['telat'] ?>);
        attendanceData.izin.push(<?= $userData['izin'] ?>);
        attendanceData.cuti.push(<?= $userData['cuti'] ?>);
        attendanceData.sakit.push(<?= $userData['sakit'] ?>);
        attendanceData.perjalanan_tugas.push(<?= $userData['perjalanan_tugas'] ?>);
    <?php endforeach; ?>

    // Create the chart
    const options = {
        chart: {
            type: 'bar',
            height: 300,
            stacked: false,
            toolbar: {
                show: false,
                tools: {
                    download: false
                }
            }
        },
        series: [{
                name: 'Hadir',
                data: attendanceData.hadir
            },
            {
                name: 'Setengah Hari',
                data: attendanceData.setengah_hari
            },
            {
                name: 'Telat',
                data: attendanceData.telat
            },
            {
                name: 'Izin',
                data: attendanceData.izin
            },
            {
                name: 'Cuti',
                data: attendanceData.cuti
            },
            {
                name: 'Sakit',
                data: attendanceData.sakit
            },
            {
                name: 'Perjalanan Tugas',
                data: attendanceData.perjalanan_tugas
            }
        ],
        xaxis: {
            categories: attendanceData.labels,
        },
        tooltip: {
            shared: true,
            intersect: false,
        },
        colors: [
            '#2196f3', // Green for "Hadir"
            '#3b43d6', // Yellow for "Setengah Hari"
            '#e74c3c', // Red for "Telat"
            '#3498db', // Cyan for "Izin"
            '#6f42c1', // Purple for "Cuti"
            '#fd7e14', // Orange for "Sakit"
            '#20c997' // Teal for "Perjalanan Tugas"
        ]
    };

    const chart = new ApexCharts(document.querySelector("#attendance-chart"), options);
    chart.render();

    // Implement dragging scroll for the table
    $(document).ready(function() {
        let isDragging = false;
        let startPositionX;
        let startScrollLeft;

        $("#scrollable-table").on("mousedown", function(e) {
            isDragging = true;
            startPositionX = e.pageX - $(this).offset().left;
            startScrollLeft = $(this).scrollLeft();
        });

        $("#scrollable-table").on("mousemove", function(e) {
            if (!isDragging) return;
            e.preventDefault();
            const x = e.pageX - $(this).offset().left;
            const walk = (x - startPositionX) * 2; // Scroll-fast
            $(this).scrollLeft(startScrollLeft - walk);
        });

        $("#scrollable-table").on("mouseup mouseleave", function() {
            isDragging = false;
        });
    });

    // Menghitung jumlah hari antara tanggal_awal dan tanggal_akhir
    function calculateDays(tanggal_awal, tanggal_akhir) {
        const startDate = new Date(tanggal_awal);
        const endDate = new Date(tanggal_akhir);
        const timeDifference = endDate.getTime() - startDate.getTime();
        const daysDifference = timeDifference / (1000 * 3600 * 24); // Konversi milidetik ke hari
        return daysDifference;
    }

    // Ambil tanggal awal dan akhir dari PHP
    const tanggalAwal = '<?= $tanggal_awal ?>'; // Ambil nilai tanggal_awal dari PHP
    const tanggalAkhir = '<?= $tanggal_akhir ?>'; // Ambil nilai tanggal_akhir dari PHP

    // Hitung jumlah hari
    const daysDifference = calculateDays(tanggalAwal, tanggalAkhir);

    // Jika rentang hari lebih dari 21, tampilkan SweetAlert
    if (daysDifference > 31) {
        Swal.fire({
            icon: 'warning',
            title: 'Perhatian!',
            text: 'Rentang tanggal lebih dari 31 hari, harap pilih ulang rentang tanggal!',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect ke halaman users/rekap_by_date_range_public
                window.location.href = '<?= base_url("users/rekap_by_date_range_public") ?>';
            }
        });
    }
</script>
<?php
$cek = $user->row(); //  mengambil nilai data dari tabel tbl_user 
$level = $cek->level; //  nilai level dari variabel $level
$id_user = $cek->id_user;
$kode_kantor = $cek->kode_kantor;
?>
<style>
    .table-striped tbody tr:nth-child(odd) {
        background-color: white;
    }

    .table-striped tbody tr:nth-child(even) {
        background-color: #ccc;
    }

    .table th {
        font-weight: bold;
    }
</style>
<div class="container">
    <div class="content">
        <?php
        echo $this->session->flashdata('msg');
        ?>
        <!-- Dashboard content -->

        <div class="row">
            <!-- Basic datatable -->
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <div class="navigation-buttons">
                        <div class="btn-group">
                            <h5 class="navigation-buttons"><i class="icon-file-empty2"></i> Data Laporan Kunjungan</h5>
                        </div>
                        <div class="btn-group" style="float: right;">
                            <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bars"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <li><a href="<?php echo site_url('users/kunjungan_data'); ?>"><i class="fa fa-television"></i> Data Kunjungan</a></li>
                            </ul>
                        </div>
                    </div>
                    <hr style="margin:0px;">
                    <br>
                    <form method="GET" action="<?= site_url('users/kunjungan_laporan') ?>" class="form-inline">
                        <label for="tanggal_awal" class="mr-2">Tanggal Awal</label>
                        <input type="date" name="tanggal_awal" value="<?= $tanggal_awal ?>" class="form-control mr-3" />

                        <label for="tanggal_akhir" class="mr-2">Tanggal Akhir</label>
                        <input type="date" name="tanggal_akhir" value="<?= $tanggal_akhir ?>" class="form-control mr-3" />

                        <button type="submit" class="btn btn-primary">Filter</button>
                    </form>

                    <br>

                    <form action="<?= base_url('users/kunjungan_export_excel/' . $tanggal_awal . '/' . $tanggal_akhir) ?>" method="post" target="_blank">
                        <button type="submit" name="btnexport" class="btn btn-success" style="display: flex; align-items: center; justify-content: center;">
                            <i class="icon-file-excel" style="font-size: 18px; margin-right: 8px;"></i>
                            Export
                        </button>
                    </form>

                </div>
                <div class="table-responsive">
                    <table class="table datatable-basic" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Petugas</th>
                                <th>Penagihan</th>
                                <th>Survey</th>
                                <th>Promosi</th>
                                <th>Kolekting</th>
                                <th>Lainnya</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($user_visit_data as $user_id => $user_info) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= strtoupper($user_info['inpuser']) ?></td>
                                    <td><?= $user_info['visit_count_penagihan'] ?></td>
                                    <td><?= $user_info['visit_count_survey'] ?></td>
                                    <td><?= $user_info['visit_count_promosi'] ?></td>
                                    <td><?= $user_info['visit_count_kolekting'] ?></td>
                                    <td><?= $user_info['visit_count_lainnya'] ?></td>
                                    <td><?= $user_info['visit_count'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <!-- Chart for Visits by User -->
                    <div class="col-md-12">
                        <h3 class="text-center">Grafik Total Kunjungan</h3>
                        <div id="chart-user"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include ApexCharts Script -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    // Chart for Visits by User
    var options_user = {
        series: [{
            name: 'Kunjungan',
            data: <?= $chart_visits_user ?>
        }],
        chart: {
            type: 'bar',
            height: 350
        },
        xaxis: {
            categories: <?= $chart_categories_user ?>,
        },
        title: {
            text: 'Kunjungan per Petugas',
            align: 'center'
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
                endingShape: 'rounded'
            }
        },
        yaxis: {
            title: {
                text: 'Jumlah Kunjungan'
            }
        }
    };

    var chart_user = new ApexCharts(document.querySelector("#chart-user"), options_user);
    chart_user.render();
</script>
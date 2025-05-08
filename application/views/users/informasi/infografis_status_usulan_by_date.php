<style>
    .container {
        width: 100%;
    }
</style>
<div class="container">
    <div class="content">
        <?php echo $this->session->flashdata('msg'); ?>
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <div class="navigation-buttons">
                        <div class="btn-group" style="float: left;">
                            <i class="fa fa-television"></i> GRAFIK STATUS USULAN
                        </div>

                        <div class="btn-group" style="float: right;">
                            <!-- <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bars"></i>
                            </button> -->
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <hr>
                    <form method="GET" action="<?= site_url('users/infografis_status_usulan_by_date') ?>">
                        <div class="row">
                            <div class="col-xs-5">
                                <input type="date" name="tanggal_awal" class="form-control" value="<?= $tanggal_awal ?>">
                            </div>
                            <div class="col-xs-5">
                                <input type="date" name="tanggal_akhir" class="form-control" value="<?= $tanggal_akhir ?>">
                            </div>
                            <div class="col-xs-2">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                            </div>
                        </div>

                    </form>
                </div>

                <!-- Status Survey Table with Graph -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel-body">
                            <h5>Status Survey</h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table datatable-basic table-striped">
                                <thead>
                                    <tr>
                                        <th>Jumlah Sudah Survey</th>
                                        <th>Jumlah Belum Survey</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($usulan_status) : ?>
                                        <tr>
                                            <td><?= $usulan_status->sudah_survey ?></td>
                                            <td><?= $usulan_status->belum_survey ?></td>
                                        </tr>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="2">Tidak ada data usulan dalam rentang tanggal yang dipilih.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div id="surveyStatusChart"></div>
                    </div>
                </div>

                <!-- Status Analisa Table with Graph -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel-body">
                            <h5>Status Analisa</h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table datatable-basic table-striped">
                                <thead>
                                    <tr>
                                        <th>Sudah Analisa</th>
                                        <th>Belum Analisa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?= $survey_status->sudah_analisa ?></td>
                                        <td><?= $survey_status->belum_analisa ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div id="analisaStatusChart"></div>
                    </div>
                </div>

                <!-- Recommendation Table with Graph -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel-body">
                            <h5>Status Rekomendasi</h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table datatable-basic table-striped">
                                <thead>
                                    <tr>
                                        <th>Tidak Rekomendasi</th>
                                        <th>Pertimbangkan</th>
                                        <th>Rekomendasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?= $survey_status->tidak_rekomendasi ?></td>
                                        <td><?= $survey_status->pertimbangkan ?></td>
                                        <td><?= $survey_status->rekomendasi ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div id="recommendationChart"></div>
                    </div>
                </div>

                <!-- Menunggu Komite Table with Graph -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel-body">
                            <h5>Status Menunggu Komite</h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table datatable-basic table-striped">
                                <thead>
                                    <tr>
                                        <th>Menunggu Komite</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?= $survey_status->menunggu_komite ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div id="komiteStatusChart"></div>
                    </div>
                </div>

                <!-- ACC, Revisi, Ditolak Table with Graph -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel-body">
                            <h5>Status ACC, Revisi, Ditolak</h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table datatable-basic table-striped">
                                <thead>
                                    <tr>
                                        <th>ACC</th>
                                        <th>Revisi</th>
                                        <th>Ditolak</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?= $survey_status->acc ?></td>
                                        <td><?= $survey_status->revisi ?></td>
                                        <td><?= $survey_status->ditolak ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div id="accRevisiStatusChart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add ApexCharts library -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
    // Example data passed from PHP
    var usulanStatus = {
        sudahSurvey: <?= $usulan_status->sudah_survey ?>,
        belumSurvey: <?= $usulan_status->belum_survey ?>
    };

    var surveyStatus = {
        sudahAnalisa: <?= $survey_status->sudah_analisa ?>,
        belumAnalisa: <?= $survey_status->belum_analisa ?>
    };

    var recommendationStatus = {
        tidakRekomendasi: <?= $survey_status->tidak_rekomendasi ?>,
        pertimbangkan: <?= $survey_status->pertimbangkan ?>,
        rekomendasi: <?= $survey_status->rekomendasi ?>
    };

    var committeeStatus = {
        menungguKomite: <?= $survey_status->menunggu_komite ?>
    };

    var accRevisiStatus = {
        acc: <?= $survey_status->acc ?>,
        revisi: <?= $survey_status->revisi ?>,
        ditolak: <?= $survey_status->ditolak ?>
    };

    // Survey Status Chart
    var surveyStatusChart = new ApexCharts(document.querySelector("#surveyStatusChart"), {
        chart: {
            type: 'pie'
        },
        series: [usulanStatus.sudahSurvey, usulanStatus.belumSurvey],
        labels: ['Sudah Survey', 'Belum Survey'],
        title: {
            text: 'Status Survey Usulan',
            align: 'center'
        }
    });

    // Analisa Status Chart
    var analisaStatusChart = new ApexCharts(document.querySelector("#analisaStatusChart"), {
        chart: {
            type: 'pie'
        },
        series: [surveyStatus.sudahAnalisa, surveyStatus.belumAnalisa],
        labels: ['Sudah Analisa', 'Belum Analisa'],
        title: {
            text: 'Status Analisa Usulan',
            align: 'center'
        }
    });

    // Recommendation Status Chart
    var recommendationChart = new ApexCharts(document.querySelector("#recommendationChart"), {
        chart: {
            type: 'bar'
        },
        series: [{
            name: 'Status',
            data: [recommendationStatus.tidakRekomendasi, recommendationStatus.pertimbangkan, recommendationStatus.rekomendasi]
        }],
        xaxis: {
            categories: ['Tidak Rekomendasi', 'Pertimbangkan', 'Rekomendasi']
        },
        title: {
            text: 'Status Rekomendasi Usulan',
            align: 'center'
        }
    });

    // Committee Status Chart
    var komiteStatusChart = new ApexCharts(document.querySelector("#komiteStatusChart"), {
        chart: {
            type: 'donut'
        },
        series: [committeeStatus.menungguKomite],
        labels: ['Menunggu Komite'],
        title: {
            text: 'Status Menunggu Komite',
            align: 'center'
        }
    });

    // ACC, Revisi, Ditolak Status Chart
    var accRevisiStatusChart = new ApexCharts(document.querySelector("#accRevisiStatusChart"), {
        chart: {
            type: 'pie'
        },
        series: [accRevisiStatus.acc, accRevisiStatus.revisi, accRevisiStatus.ditolak],
        labels: ['ACC', 'Revisi', 'Ditolak'],
        title: {
            text: 'Status ACC, Revisi, Ditolak',
            align: 'center'
        }
    });

    // Render the charts
    surveyStatusChart.render();
    analisaStatusChart.render();
    recommendationChart.render();
    komiteStatusChart.render();
    accRevisiStatusChart.render();
</script>

<!-- CSS to style the chart containers -->
<style>
    .table-responsive {
        margin-bottom: 20px;
    }

    .row>.col-md-6 {
        margin-bottom: 20px;
    }

    #surveyStatusChart,
    #analisaStatusChart,
    #recommendationChart,
    #komiteStatusChart,
    #accRevisiStatusChart {
        width: 100%;
        height: 350px;
    }
</style>
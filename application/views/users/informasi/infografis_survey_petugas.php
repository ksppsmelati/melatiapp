<?php
// Prepare data for the chart (using PHP)
$petugas_counts = [];
if (is_array($survey_data)) {
    foreach ($survey_data as $data) {
        $petugas_counts[$data['surveyor']] = [
            'nama' => $data['nama_lengkap'],
            'jumlah' => $data['jumlah']
        ];
    }
}

// Encode the data for use in JavaScript
$petugas_counts_json = json_encode($petugas_counts);
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chroma-js/2.1.0/chroma.min.js"></script>

<div class="container">
    <div class="content">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="panel panel-flat">
                <div class="panel-body">
                    <div class="navigation-buttons">
                        <div class="btn-group" style="float: left;">
                            <i class="fa-solid fa-person-running"></i> Grafik Jumlah Survey Petugas
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <hr>

                    <!-- Form untuk memilih rentang tanggal -->
                    <form method="get" action="<?php echo site_url('users/infografis_survey_petugas'); ?>">
                        <div class="row">
                            <div class="col-xs-4">
                                <input type="date" name="tanggal_awal" class="form-control" value="<?= $tanggal_awal ?>" required>
                            </div>
                            <div class="col-xs-4">
                                <input type="date" name="tanggal_akhir" class="form-control" value="<?= $tanggal_akhir ?>" required>
                            </div>
                            <div class="col-xs-2">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                            </div>
                            <div class="col-xs-2">
                                <a href="<?php echo site_url('users/infografis_survey_petugas'); ?>" class="btn btn-secondary"><i class="fa fa-refresh"></i></a>
                            </div>
                        </div>
                    </form>
                </div>

                <fieldset class="content-group">
                    <div class="table-responsive">
                        <table class="table datatable-basic table-striped" width="100%">
                            <thead>
                                <tr>
                                    <th>Petugas</th>
                                    <th>Jumlah Survey</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($petugas_counts as $petugas => $data) : ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($data['nama'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($data['jumlah'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                        <div>
                            <canvas id="petugasChart" width="100%"></canvas>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
</div>

<script>
    function generateColors(count) {
        return chroma.scale('Set3').mode('lab').colors(count);
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Get data from PHP
        var petugasCounts = <?php echo $petugas_counts_json; ?>;

        // Prepare data for Chart.js
        var petugasLabels = Object.values(petugasCounts).map(function(data) {
            return data.nama; // Use 'nama_lengkap' as the label
        });
        var petugasData = Object.values(petugasCounts).map(function(data) {
            return data.jumlah; // Use 'jumlah' for the data
        });
        var petugasColors = generateColors(petugasData.length);

        // Create the chart
        var ctx = document.getElementById('petugasChart').getContext('2d');
        var petugasChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: petugasLabels, // Display petugas names
                datasets: [{
                    label: 'Jumlah Survey',
                    data: petugasData,
                    backgroundColor: petugasColors,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.raw + ' Survey';
                            }
                        }
                    }
                }
            }
        });
    });
</script>

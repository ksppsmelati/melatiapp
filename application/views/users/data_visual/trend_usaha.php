<?php
$cek = $user->row(); // mengambil data user
$id_user = $cek->id_user;
$nama = $cek->nama_lengkap;
$level = $cek->level;

// Pengelompokan data tren berdasarkan jenis usaha dan status
$trend_counts = [];
foreach ($agunan_data as $data) {
    $jns_usaha_text = getKodeJnsUsahaText($data->jns_usaha);

    if (!isset($trend_counts[$jns_usaha_text])) {
        $trend_counts[$jns_usaha_text] = [
            'down' => 0,
            'same' => 0,
            'up' => 0,
            'total' => 0 // Menambahkan total untuk menghitung rata-rata
        ];
    }

    // Penghitungan jumlah tren
    switch ($data->status) {
        case 0:
            $trend_counts[$jns_usaha_text]['down']++;
            break;
        case 1:
            $trend_counts[$jns_usaha_text]['same']++;
            break;
        case 2:
            $trend_counts[$jns_usaha_text]['up']++;
            break;
    }

    // Menambahkan total usaha untuk menghitung rata-rata
    $trend_counts[$jns_usaha_text]['total']++;
}

// Menghitung rata-rata untuk setiap jenis usaha
$average_trend = [];
foreach ($trend_counts as $jns_usaha => $counts) {
    $average_trend[$jns_usaha] = [
        'average' => ($counts['up'] / $counts['total']) * 100, // Rata-rata dalam persen
        'total_up' => $counts['up'],
        'total_down' => $counts['down'],
        'total_same' => $counts['same']
    ];
}

// Menentukan jenis usaha yang paling naik dan paling turun
$most_up = null;
$most_down = null;
foreach ($average_trend as $jns_usaha => $values) {
    if (is_null($most_up) || $values['average'] > $average_trend[$most_up]['average']) {
        $most_up = $jns_usaha;
    }
    if (is_null($most_down) || $values['average'] < $average_trend[$most_down]['average']) {
        $most_down = $jns_usaha;
    }
}

$trend_counts_json = json_encode($trend_counts);
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<div class="container-fluid">
    <div class="row">
        <section class="trend-section col-12 mb-4" style="border-radius: 10px; padding: 20px; background-color: #f0f4f7;">
            <div class="panel-heading">
                <h3 class="text-center text-dark">
                    <i class="fa fa-line-chart"></i> Trend Usaha Monitoring Tahun <?php echo date('Y'); ?>
                </h3>
            </div>
            <div class="chart-container" style="position: relative; height:auto; width:100%;">
                <div id="trendChart"></div>
            </div>
        </section>

        <!-- Tampilan data usaha yang paling naik dan turun -->
        <!-- <section class="summary-section col-12 mb-4" style="border-radius: 10px; padding: 20px; background-color: #e7f4e4;">
            <div class="panel-heading">
                <h4 class="text-center text-dark">Rangkuman Usaha</h4>
            </div>
            <div class="summary-content text-center">
                <p><strong>Usaha Paling Naik:</strong> <span style="color: #27ae60;"><?php echo $most_up; ?></span> (Jumlah Naik: <?php echo $average_trend[$most_up]['total_up']; ?>)</p>
                <p><strong>Usaha Paling Turun:</strong> <span style="color: #c0392b;"><?php echo $most_down; ?></span> (Jumlah Turun: <?php echo $average_trend[$most_down]['total_down']; ?>)</p>
                <p><strong>Total Usaha Sama:</strong> <span><?php echo $average_trend[$most_up]['total_same']; ?></span></p>
            </div>
        </section> -->

        <!-- Tabel detail tren usaha -->
        <section class="detail-section col-12 mb-4" style="border-radius: 10px; padding: 20px; background-color: #ffffff;">
            <div class="panel-heading">
                <h4 class="text-center text-dark">Detail Tren Usaha</h4>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered text-center">
                    <thead>
                        <tr style="background-color: #34495e; color: white;">
                            <th>Jenis Usaha</th>
                            <th>Total Naik</th>
                            <th>Total Sama</th>
                            <th>Total Turun</th>
                            <th>Rata-rata Kenaikan (%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($average_trend as $jns_usaha => $values): ?>
                            <tr>
                                <td><?php echo $jns_usaha; ?></td>
                                <td><?php echo $values['total_up']; ?></td>
                                <td><?php echo $values['total_same']; ?></td>
                                <td><?php echo $values['total_down']; ?></td>
                                <td><?php echo number_format($values['average'], 2); ?>%</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Ambil data tren dari PHP (menggunakan JSON)
        var trendCounts = <?php echo $trend_counts_json; ?>;

        // Siapkan label dan data untuk ApexCharts
        var trendLabels = Object.keys(trendCounts);
        var downData = trendLabels.map(label => trendCounts[label].down);
        var sameData = trendLabels.map(label => trendCounts[label].same);
        var upData = trendLabels.map(label => trendCounts[label].up);

        // Konfigurasi untuk ApexCharts
        var options = {
            chart: {
                height: 450,
                type: 'line',
                toolbar: {
                    show: true,
                },
            },
            series: [
                {
                    name: 'Turun',
                    data: downData,
                },
                {
                    name: 'Sama',
                    data: sameData,
                },
                {
                    name: 'Naik',
                    data: upData,
                }
            ],
            colors: ['#e74c3c', '#f39c12', '#2ecc71'],
            stroke: {
                curve: 'smooth',
                width: 2,
            },
            xaxis: {
                categories: Array.from({length: trendLabels.length}, (_, i) => i + 1), // Indeks tanpa label
                title: {
                    text: '' // Kosongkan judul
                },
                labels: {
                    show: false // Sembunyikan label di sumbu X
                }
            },
            yaxis: {
                title: {
                    text: 'Jumlah Usaha'
                },
                min: 0,
            },
            tooltip: {
                shared: true,
                intersect: false,
                y: {
                    formatter: function(value) {
                        return value + " usaha"; // Menampilkan jumlah usaha di tooltip
                    }
                },
                x: {
                    // Menampilkan nama usaha di tooltip
                    formatter: function(val, opts) {
                        return trendLabels[opts.dataPointIndex]; // Menampilkan nama jenis usaha di tooltip
                    }
                }
            },
            legend: {
                show: false, // Tidak menampilkan legenda
            },
            responsive: [
                {
                    breakpoint: 600,
                    options: {
                        chart: {
                            height: 300
                        },
                    }
                }
            ]
        };

        // Render ApexCharts di container
        var chart = new ApexCharts(document.querySelector("#trendChart"), options);
        chart.render();
    });
</script>
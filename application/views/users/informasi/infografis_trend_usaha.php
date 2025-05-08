<?php
// Pengelompokan data tren berdasarkan jenis usaha dan status
$trend_counts = [];
foreach ($agunan_data as $data) {
  $jns_usaha_text = getKodeJnsUsahaText($data->jns_usaha);
  if (!isset($trend_counts[$jns_usaha_text])) {
    $trend_counts[$jns_usaha_text] = [
      'down' => 0,
      'same' => 0,
      'up' => 0
    ];
  }
  if ($data->status == 0) {
    $trend_counts[$jns_usaha_text]['down']++;
  } elseif ($data->status == 1) {
    $trend_counts[$jns_usaha_text]['same']++;
  } elseif ($data->status == 2) {
    $trend_counts[$jns_usaha_text]['up']++;
  }
}

// Encode the trend counts to JSON for use in JavaScript
$trend_counts_json = json_encode($trend_counts);

$tanggal_awal = isset($_GET['tanggal_awal']) ? $_GET['tanggal_awal'] : date('Y-01-01');
$tanggal_akhir = isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : date('Y-m-d');
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
              <i class="fa fa-line-chart"></i> Grafik Trend Usaha
            </div>
            <div class="btn-group" style="float: right;">
              <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-bars"></i>
              </button>
              <ul class="dropdown-menu dropdown-menu-right" role="menu">
                <li><a href="users/infografis_trend_usaha"><i class="fa fa-line-chart"></i> Trend Usaha</a></li>
                <li><a href="users/infografis_jml_usaha"><i class="fa fa-area-chart"></i> Jumlah Usaha</a></li>
                <li><a href="users/infografis_monitoring_petugas"><i class="fa fa-user"></i> Monitoring Petugas</a></li>
              </ul>
            </div>
          </div>
          <div class="clearfix"></div>
          <hr>
          <?php
          // Menyimpan nama rute yang sedang aktif dalam variabel
          $current_route = $this->router->fetch_class() . '/' . $this->router->fetch_method();
          ?>
          <form method="get" action="<?php echo site_url($current_route); ?>">
            <div class="row">
              <div class="col-xs-4">
                <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control" value="<?= isset($_GET['tanggal_awal']) ? $_GET['tanggal_awal'] : (isset($tanggal_awal) ? $tanggal_awal : date('Y-m-d')) ?>" required>
              </div>
              <div class="col-xs-4">
                <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control" value="<?= isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : (isset($tanggal_akhir) ? $tanggal_akhir : date('Y-m-d')) ?>" required>
              </div>
              <div class="col-xs-2">
                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
              </div>
              <div class="col-xs-2">
                <a href="<?php echo site_url($current_route); ?>" class="btn btn-secondary"><i class="fa fa-refresh"></i></a>
              </div>
            </div>
          </form>
          <hr>
        </div>
        <fieldset class="content-group">
          <div class="table-responsive">
            <table class="table datatable-basic table-striped" width="100%">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Jenis Usaha</th>
                  <th><i class="fa fa-arrow-up" style="color: green;"></i> <span style="color: green;">NAIK</span></th>
                  <th><i class="fa fa-equals" style="color: orange;"></i> <span style="color: orange;">SAMA</span></th>
                  <th><i class="fa fa-arrow-down" style="color: red;"></i> <span style="color: red;">TURUN</span></th>
                  <th>Total Data</th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1;
                foreach ($trend_counts as $trend => $count) : ?>
                  <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo htmlspecialchars($trend, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($count['up'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($count['same'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($count['down'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($count['down'] + $count['same'] + $count['up'], ENT_QUOTES, 'UTF-8'); ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
            <div>
              <canvas id="trendChart"></canvas>
            </div>
          </div>
        </fieldset>
      </div>
    </div>
  </div>
</div>

<script>
  function getRandomColor() {
    var letters = '0123456789ABCDEF';
    var color = '#';
    for (var i = 0; i < 6; i++) {
      color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
  }

  function generateColors(count) {
    return chroma.scale('Set3').mode('lab').colors(count);
  }

  document.addEventListener('DOMContentLoaded', function() {
    // Get data from PHP
    var trendCounts = <?php echo $trend_counts_json; ?>;

    // Prepare data for Chart.js
    var trendLabels = Object.keys(trendCounts);
    var trendData = trendLabels.map(function(label) {
      return {
        label: label,
        down: trendCounts[label].down,
        same: trendCounts[label].same,
        up: trendCounts[label].up
      };
    });

    var trendColors = generateColors(trendLabels.length);

    // Create Trend Chart
    var ctxTrend = document.getElementById('trendChart').getContext('2d');
    var trendChart = new Chart(ctxTrend, {
      type: 'bar',
      data: {
        labels: trendLabels,
        datasets: [{
            label: 'Turun',
            data: trendData.map(data => data.down),
            backgroundColor: '#FF6F6F'
          },
          {
            label: 'Sama',
            data: trendData.map(data => data.same),
            backgroundColor: '#FFC107'
          },
          {
            label: 'Naik',
            data: trendData.map(data => data.up),
            backgroundColor: '#4CAF50'
          }
        ]
      },
      options: {
        responsive: true,
        scales: {
          x: {
            beginAtZero: true,
            ticks: {
              autoSkip: false,
              maxRotation: 90,
              minRotation: 90
            }
          },
          y: {
            beginAtZero: true
          }
        },
        plugins: {
          legend: {
            position: 'top',
          },
          tooltip: {
            callbacks: {
              label: function(tooltipItem) {
                var label = trendLabels[tooltipItem.dataIndex];
                var trendDataPoint = trendData[tooltipItem.dataIndex];
                if (tooltipItem.datasetIndex === 0) {
                  return label + ' - Turun: ' + trendDataPoint.down;
                } else if (tooltipItem.datasetIndex === 1) {
                  return label + ' - Sama: ' + trendDataPoint.same;
                } else if (tooltipItem.datasetIndex === 2) {
                  return label + ' - Naik: ' + trendDataPoint.up;
                }
              }
            }
          }
        }
      }
    });
  });
</script>
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

$petugas_counts = [];
foreach ($agunan_data as $data) {
  if (!isset($petugas_counts[$data->petugas_input])) {
    $petugas_counts[$data->petugas_input] = 0;
  }
  $petugas_counts[$data->petugas_input]++;
}

// Encode the petugas counts to JSON for use in JavaScript
$petugas_counts_json = json_encode($petugas_counts);

$tanggal_awal = isset($_GET['tanggal_awal']) ? $_GET['tanggal_awal'] : date('Y-m-01');
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
              <i class="fa fa-user"></i> Grafik Jumlah Monitoring Petugas
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
              <br><br><br>
            </div>
          </form>
        </div>
        <fieldset class="content-group">
          <div class="table-responsive">
            <table class="table datatable-basic table-striped" width="100%">
              <thead>
                <tr>
                  <th>Petugas</th>
                  <th>Jumlah</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($petugas_counts as $petugas => $count) : ?>
                  <tr>
                    <td><?php echo htmlspecialchars(strtoupper($petugas), ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($count, ENT_QUOTES, 'UTF-8'); ?></td>
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
    var petugasCounts = <?php echo $petugas_counts_json; ?>;

    // Prepare data for Chart.js
    var petugasLabels = Object.keys(petugasCounts);
    var petugasData = Object.values(petugasCounts);
    var petugasColors = generateColors(petugasLabels.length);

    // Create petugas_input Chart
    var ctxPetugas = document.getElementById('petugasChart').getContext('2d');
    var petugasChart = new Chart(ctxPetugas, {
      type: 'bar',
      data: {
        labels: petugasLabels,
        datasets: [{
          data: petugasData,
          backgroundColor: petugasColors
        }]
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
            position: 'top'
          },
          tooltip: {
            callbacks: {
              label: function(tooltipItem) {
                return tooltipItem.label + ': ' + tooltipItem.raw;
              }
            }
          }
        }
      }
    });
  });
</script>
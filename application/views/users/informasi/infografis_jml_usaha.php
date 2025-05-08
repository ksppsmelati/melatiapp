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
              <i class="fa fa-area-chart"></i> Grafik Total Jumlah Usaha
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
                  <th>No</th>
                  <th>Jenis Usaha</th>
                  <th>Total Data</th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1;
                foreach ($trend_counts as $trend => $count) : ?>
                  <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo htmlspecialchars($trend, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($count['down'] + $count['same'] + $count['up'], ENT_QUOTES, 'UTF-8'); ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
            <div>
              <canvas id="statusBarChart"></canvas>
            </div>
          </div>
        </fieldset>
      </div>
    </div>
  </div>
</div>

<script>
  function getKodeJnsUsahaText(jnsUsaha) {
    var labels = {
      "1000": "SAYURAN, BUAH DAN ANEKA UMBI",
      "1010": "PERKEBUNAN TEMBAKAU",
      "1020": "PERTANIAN PADI",
      "1030": "PERTANIAN TANAMAN SEMUSIM LAINNYA",
      "1040": "PERTANIAN TANAMAN HIAS DAN PENGEMBANGBIAKAN TANAMAN",
      "1050": "PENGELOLAAN HUTAN",
      "1060": "JASA PENUNJANG KEHUTANAN",
      "2000": "PETERNAKAN SAPI DAN KERBAU",
      "2010": "PETERNAKAN DOMBA DAN KAMBING",
      "2020": "PETERNAKAN UNGGAS",
      "2030": "PETERNAKAN LAINNYA",
      "2040": "PERIKANAN BUDIDAYA",
      "2050": "PERIKANAN TANGKAP",
      "3000": "PENGGALIAN BATU, PASIR DAN TANAH LIAT",
      "3010": "PERTAMBANGAN EMAS, PERAK BATU BARA DAN PERTAMBANGAN LAINNYA",
      "3020": "AKTIVITAS JASA PENUNJANG PERTAMBANGAN",
      "4000": "INDUSTRI MAKANAN",
      "4010": "INDUSTRI MINUMAN",
      "4020": "INDUSTRI PENGOLAHAN TEMBAKAU",
      "4030": "INDUSTRI TEKSTIL",
      "4040": "INDUSTRI LAINNYA",
      "5000": "PERDAGANGAN KELONTONG",
      "5010": "PERDAGANGAN SAYURAN, BUAH DAN ANEKA UMBI",
      "5020": "PERDAGANGAN ELEKTRONIK",
      "5030": "PERDAGANGAN KENDARAAN",
      "5040": "PERDAGANGAN",
      "6000": "JASA KONSTRUKSI",
      "6010": "JASA KEUANGAN",
      "6020": "JASA KONSULTASI MANAJEMEN",
      "6030": "JASA KOMPUTER",
      "6040": "JASA PENDIDIKAN",
      "6050": "JASA PEMELIHARAAN DAN PERBAIKAN",
      "6060": "JASA PERIKLANAN DAN PUBLIKASI",
      "6070": "JASA PENYIMPANAN DAN PENGANGKUTAN",
      "6080": "JASA PERLINDUNGAN DAN KEAMANAN",
      "6090": "JASA KESEHATAN DAN KEDOKTERAN",
      "6100": "JASA HIBURAN DAN REKREASI",
      "6110": "JASA LAINNYA"
    };

    return labels[jnsUsaha] || "Subkategori tidak ditemukan";
  }

  function getRandomColor() {
    var letters = '0123456789ABCDEF';
    var color = '#';
    for (var i = 0; i < 6; i++) {
      color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
  }

  function generateColors(count) {
    var colors = [];
    for (var i = 0; i < count; i++) {
      colors.push(getRandomColor());
    }
    return colors;
  }

  function generateColors(count) {
    return chroma.scale('Set3').mode('lab').colors(count);
  }

  document.addEventListener('DOMContentLoaded', function() {
    // Get data from PHP
    var jenisUsahaCounts = <?php echo json_encode($jenis_usaha_counts); ?>;
    var trendCounts = <?php echo $trend_counts_json; ?>;
    var petugasCounts = <?php echo $petugas_counts_json; ?>;

    // Prepare data for Chart.js
    var labels = [];
    var counts = [];
    var colors = generateColors(jenisUsahaCounts.length); // Generate colors dynamically

    jenisUsahaCounts.forEach(function(item) {
      labels.push(getKodeJnsUsahaText(item.jns_usaha));
      counts.push(item.count);
    });

    // Create Bar Chart
    var ctxBar = document.getElementById('statusBarChart').getContext('2d');
    var statusBarChart = new Chart(ctxBar, {
      type: 'bar',
      data: {
        labels: labels,
        datasets: [{
          label: 'Grafik Total Jumlah Usaha',
          data: counts,
          backgroundColor: colors, // Use generated colors
          borderColor: colors.map(color => chroma(color).darken(1.5).hex()), // Darker border colors
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        scales: {
          x: {
            beginAtZero: true,
            ticks: {
              // autoSkip: false
              display: false
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
                return labels[tooltipItem.dataIndex] + ': ' + counts[tooltipItem.dataIndex];
              }
            }
          }
        }
      }
    });
  });
</script>
<style>
  .container {
    width: 100%;
  }
</style>
<div class="container">
  <div class="content">
    <div class="row">
      <div class="col-md-1"></div>
      <div class="panel panel-flat">
        <div class="panel-body">
          <div class="navigation-buttons">
            <div class="btn-group" style="float: left;">
              <i class="fa fa-line-chart"></i> Grafik Usulan
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="card" style="margin-bottom: 60px;">
          <div class="cardText">
            <div class="cardText">
              <div class="container" style="max-width: 100%;">
                <?php
                $bulan_tahun = !empty($usulan_by_kantor) ? date('F Y', strtotime($usulan_by_kantor[0]->bulan_tahun)) : 'Data Tidak Tersedia';
                $total_nominal = 0;
                foreach ($usulan_by_kantor as $row) {
                  $total_nominal += $row->total_nominal;
                }
                ?>
                <h5 class="text-center">Data Usulan <?php echo $bulan_tahun; ?></h5>
                <div id="chart"></div>
                <div class="text-center" style="margin-top: 20px;">
                  <h6>Total <br> <?php echo 'Rp ' . number_format($total_nominal, 0, ',', '.'); ?></h6>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
  var options = {
    chart: {
      type: 'line',
      height: 400, // Tinggi grafik
      zoom: {
        enabled: false // Menonaktifkan zoom
      }
    },
    series: [{
        name: 'Jumlah Usulan',
        data: [
          <?php foreach ($usulan_by_kantor as $row) {
            // Get the Kode Kantor Text using the function
            $kodeKantorText = getKodeKantorText($row->kode_kantor);
            echo '{ x: "' . $kodeKantorText . '", y: ' . $row->jumlah_usulan . '},';
          } ?>
        ]
      },
      {
        name: 'Total Nominal',
        data: [
          <?php foreach ($usulan_by_kantor as $row) {
            // Get the Kode Kantor Text using the function
            $kodeKantorText = getKodeKantorText($row->kode_kantor);
            echo '{ x: "' . $kodeKantorText . '", y: ' . $row->total_nominal . '},';
          } ?>
        ]
      }
    ],
    colors: ['#FF5733', '#33B5E5'], // Warna garis yang lebih menarik
    xaxis: {
      categories: [
        <?php foreach ($usulan_by_kantor as $row) {
          // Get the Kode Kantor Text using the function
          $kodeKantorText = getKodeKantorText($row->kode_kantor);
          echo "'" . $kodeKantorText . "',";
        } ?>
      ],
      title: {
        text: '',
        style: {
          fontSize: '14px',
          fontWeight: 'bold',
          color: '#333'
        }
      }
    },
    yaxis: {
      title: {
        text: 'Jumlah Usulan / Total Nominal',
        style: {
          fontSize: '14px',
          fontWeight: 'bold',
          color: '#333'
        }
      },
      labels: {
        formatter: function(val) {
          // Menambahkan format Rupiah pada nilai nominal
          return 'Rp ' + val.toLocaleString();
        }
      }
    },
    tooltip: {
      shared: true, // Tooltip akan menampilkan semua data yang relevan dalam satu tooltip
      intersect: false,
      x: {
        show: true
      },
      y: {
        formatter: function(val, {
          seriesIndex
        }) {
          if (seriesIndex === 1) {
            // Menampilkan total nominal sebagai Rupiah
            return 'Rp ' + val.toLocaleString();
          }
          return val; // Untuk data jumlah usulan, tampilkan angka biasa
        }
      }
    },
    dataLabels: {
      enabled: true, // Menampilkan angka di atas garis
      formatter: function(val, {
        seriesIndex
      }) {
        if (seriesIndex === 1) {
          // Format nominal sebagai Rupiah
          return 'Rp ' + val.toLocaleString();
        }
        return val; // Untuk jumlah usulan, tampilkan angka biasa
      },
      style: {
        fontSize: '12px',
        colors: ['#000']
      }
    },
    stroke: {
      curve: 'smooth', // Garis lebih halus
      width: 2 // Ketebalan garis
    },
    grid: {
      borderColor: '#e0e0e0',
      strokeDashArray: 5, // Garis grid putus-putus
    },
    markers: {
      size: 5, // Ukuran titik
      colors: ['#FF5733', '#33B5E5'], // Warna marker sesuai garis
      strokeWidth: 2
    },
    legend: {
      position: 'top', // Menempatkan legenda di atas grafik
      horizontalAlign: 'center',
      floating: false,
      offsetY: 0,
      offsetX: 0
    }
  };

  var chart = new ApexCharts(document.querySelector("#chart"), options);
  chart.render();
</script>
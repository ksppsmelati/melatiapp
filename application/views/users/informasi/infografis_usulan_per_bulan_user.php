<style>
  .container {
    width: 100%;
  }
</style>
<div class="container">
  <div class="content">
    <div class="row">
      <div class="panel panel-flat">
        <div class="panel-body">
          <div class="navigation-buttons">
            <div class="btn-group" style="float: left;">
              <i class="fa fa-bar-chart"></i> Grafik Usulan Karyawan
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="card">
          <div class="cardText">
            <div class="container" style="max-width: 100%;">

              <?php
              $bulan_tahun = !empty($usulan_by_user) ? date('F Y', strtotime($usulan_by_user[0]->bulan_tahun)) : 'Data Tidak Tersedia';
              $total_nominal = 0;
              foreach ($usulan_by_user as $row) {
                $total_nominal += $row->total_nominal;
              }
              ?>
              <h5 class="text-center">Grafik Usulan Karyawan <?php echo $bulan_tahun; ?></h5>
              <div id="chart-usulan"></div> <!-- Grafik Jumlah Usulan -->
              <div id="chart-nominal" style="margin-top: 40px;"></div> <!-- Grafik Total Nominal -->

              <div class="text-center" style="margin-top: 20px;">
                <h6>Total Nominal<br><?php echo 'Rp ' . number_format($total_nominal, 0, ',', '.'); ?></h6>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="panel panel-flat">
        <div class="panel-body">
          <div class="navigation-buttons">
            <div class="btn-group" style="float: left;">
              <i class="fa fa-bar-chart"></i> Tabel Usulan Per Karyawan <?php echo $bulan_tahun; ?>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="table-responsive">
          <table class="table datatable-basic" width="100%">
            <thead>
              <tr>
                <th>Nama</th>
                <th>Jumlah</th>
                <th>Total Nominal</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($usulan_by_user as $row) : ?>
                <tr>
                  <td><?php echo $row->nama_lengkap; ?></td>
                  <td><?php echo $row->jumlah_usulan; ?></td>
                  <td data-sort="<?php echo $row->total_nominal; ?>">
                    <?php echo 'Rp ' . number_format($row->total_nominal, 0, ',', '.'); ?>
                  </td>
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
<script>
  // Grafik Jumlah Usulan (Bar Chart)
  var optionsUsulan = {
    chart: {
      type: 'bar',
      height: 400,
    },
    series: [{
      name: 'Jumlah Usulan',
      data: [
        <?php foreach ($usulan_by_user as $row) {
          echo '{ x: "' . $row->nama_lengkap . '", y: ' . $row->jumlah_usulan . '},';
        } ?>
      ]
    }],
    colors: ['#48dbfb'],
    xaxis: {
      title: {
        text: ' ',
        style: {
          fontSize: '14px',
          fontWeight: 'bold',
          color: '#333'
        }
      }
    },
    yaxis: {
      title: {
        text: 'Jumlah Usulan',
        style: {
          fontSize: '14px',
          fontWeight: 'bold',
          color: '#333'
        }
      }
    },
    dataLabels: {
      enabled: true,
      style: {
        fontSize: '12px',
        colors: ['#000']
      }
    },
    tooltip: {
      enabled: true
    },
    stroke: {
      width: 2
    },
    grid: {
      borderColor: '#e0e0e0',
      strokeDashArray: 5
    },
    markers: {
      size: 5,
      colors: ['#FF5733'],
      strokeWidth: 2
    }
  };

  var chartUsulan = new ApexCharts(document.querySelector("#chart-usulan"), optionsUsulan);
  chartUsulan.render();

  // Grafik Total Nominal (Line Chart)
  var optionsNominal = {
    chart: {
      type: 'line',
      height: 400,
    },
    series: [{
      name: 'Total Nominal',
      data: [
        <?php foreach ($usulan_by_user as $row) {
          echo '{ x: "' . $row->nama_lengkap . '", y: ' . $row->total_nominal . '},';
        } ?>
      ]
    }],
    colors: ['#33B5E5'],
    xaxis: {
      title: {
        text: ' ',
        style: {
          fontSize: '14px',
          fontWeight: 'bold',
          color: '#333'
        }
      }
    },
    yaxis: {
      title: {
        text: 'Total Nominal',
        style: {
          fontSize: '14px',
          fontWeight: 'bold',
          color: '#333'
        }
      },
      labels: {
        formatter: function(val) {
          return 'Rp ' + val.toLocaleString();
        }
      }
    },
    dataLabels: {
      enabled: true,
      formatter: function(val) {
        return 'Rp ' + val.toLocaleString();
      },
      style: {
        fontSize: '12px',
        colors: ['#000']
      }
    },
    tooltip: {
      enabled: true,
      y: {
        formatter: function(val) {
          return 'Rp ' + val.toLocaleString();
        }
      }
    },
    stroke: {
      width: 2
    },
    grid: {
      borderColor: '#e0e0e0',
      strokeDashArray: 5
    },
    markers: {
      size: 5,
      colors: ['#33B5E5'],
      strokeWidth: 2
    }
  };

  var chartNominal = new ApexCharts(document.querySelector("#chart-nominal"), optionsNominal);
  chartNominal.render();
</script>
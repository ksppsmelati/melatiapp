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

  $tanggal_awal = isset($_GET['tanggal_awal']) ? $_GET['tanggal_awal'] : date('Y-m-d');
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
                <i class="fa fa-star"></i> Informasi
              </div>
              <div class="btn-group" style="float: right;">
                <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-bars"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-right" role="menu">
                  <li><a href="#"><i class="fa fa-star"></i> Sub #1</a></li>
                  <li><a href="#"><i class="fa fa-star"></i> Sub #2</a></li>
                </ul>
              </div>
            </div>
            <div class="clearfix"></div>
            <hr>
            <form action="<?= base_url('users/informasi') ?>" method="get">
              <div class="row">
                <div class="col-xs-5">
                  <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control" value="<?= isset($_GET['tanggal_awal']) ? $_GET['tanggal_awal'] : (isset($tanggal_awal) ? $tanggal_awal : date('Y-m-d')) ?>" required>
                </div>
                <div class="col-xs-5">
                  <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control" value="<?= isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : (isset($tanggal_akhir) ? $tanggal_akhir : date('Y-m-d')) ?>" required>
                </div>
                <div class="col-xs-1">
                  <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                </div>
                <br><br><br>

              </div>
            </form>
            <fieldset class="content-group">
              <div class="table-responsive">
                <table class="table datatable-basic table-striped" width="100%">
                  <thead>
                    <tr>
                      <th style="display: none;"></th>
                      <th>ID</th>
                      <!-- <th>Tanggal</th> -->
                      <th style="position: sticky; left: 0; z-index: 1; background:#fff;">Nama Anggota</th>
                      <th>Alamat</th>
                      <th>Jenis Usaha</th>
                      <th>Status</th>
                      <th>Jumlah Karywan</th>
                      <!-- <th>No. Kontrak</th> -->
                      <!-- <th>Jenis Dokumen</th> -->
                      <!-- <th>Atas Nama</th> -->
                      <!-- <th>Keterangan</th> -->
                      <th>Petugas Input</th>
                      <!-- <th>Petugas Ubah</th> -->
                      <th>Foto Jaminan</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (!empty($agunan_data)) : ?>
                      <?php foreach ($agunan_data as $data) : ?>
                        <tr>
                          <td style="display: none;"><?php echo $data->tanggal_ubah; ?></td>
                          <td><?php echo $data->id; ?></td>
                          <!-- <td><?php echo $data->tanggal; ?></td> -->
                          <td style="position: sticky; left: 0; z-index: 1; background:#fff;">
                            <a href="<?php echo site_url('users/monitoring/monitoring_lihat/' . $data->id); ?>">
                              <?php echo $data->nama_anggota; ?>
                            </a>
                          </td>
                          <td><?php echo $data->alamat; ?></td>
                          <td><?php echo $kodeJnsUsahaText = getKodeJnsUsahaText($data->jns_usaha); ?></td>
                          <td>
                            <?php
                            if ($data->status == 1) {
                              echo '<i class="fa fa-equals" style="color: orange;"></i> <span style="color: orange;">SAMA</span>';
                            } elseif ($data->status == 2) {
                              echo '<i class="fa fa-arrow-up" style="color: green;"></i> <span style="color: green;">NAIK</span>';
                            } elseif ($data->status == 0) {
                              echo '<i class="fa fa-arrow-down" style="color: red;"></i> <span style="color: red;">TURUN</span>';
                            }
                            ?>
                          </td>
                          <td><?php echo $data->jml_karyawan; ?></td>
                          <!-- <td>
                                              <?php
                                              $kode_kantor = $data->kode_kantor;
                                              $kantor = [
                                                '01' => 'PUSAT',
                                                '02' => 'SEDAYU',
                                                '03' => 'SAPURAN',
                                                '04' => 'KERTEK',
                                                '05' => 'WONOSOBO',
                                                '06' => 'KALIWIRO',
                                                '07' => 'BANJARNEGARA',
                                                '08' => 'RANDUSARI',
                                                '09' => 'KEPIL',
                                              ];

                                              // Mengecek apakah kode kantor ada dalam array
                                              if (array_key_exists($kode_kantor, $kantor)) {
                                                echo $kantor[$kode_kantor];
                                              } else {
                                                echo 'Tidak diketahui';
                                              }
                                              ?>
                                          </td> -->

                          <!-- <td><?php echo $data->no_kontrak; ?></td> -->
                          <!-- <td>
                                              <?php
                                              $jenis_dokumen = $data->jenis_dokumen;
                                              $kode_dok = [
                                                '1' => 'SHM',
                                                '2' => 'SHM A/Rusun',
                                                '3' => 'SHGB',
                                                '4' => 'SHP',
                                                '5' => 'SHGU',
                                                '6' => 'BPKB',
                                                '7' => 'AJB',
                                                '8' => 'BILYET DEPOSITO',
                                                '9' => 'BUKU TABUNGAN',
                                                '10' => 'CEK',
                                                '11' => 'BILYET GIRO',
                                                '12' => 'SURAT PERNYATAAN & KUASA',
                                                '13' => 'INVOICE / FAKTUR',
                                                '14' => 'SIPTB',
                                                '15' => 'DOKUMEN KONTAK',
                                                '16' => 'SAHAM',
                                                '17' => 'OBLIGASI',
                                                '18' => 'SK INSTITUSI/LEMBAGA',
                                                '19' => 'LAIN-LAIN',
                                                '20' => 'LETTER C/GIRIK',
                                                '21' => 'KARTU PASAR',

                                              ];

                                              // Mengecek apakah kode dokumen ada dalam array
                                              if (array_key_exists($jenis_dokumen, $kode_dok)) {
                                                echo $kode_dok[$jenis_dokumen];
                                              } else {
                                                echo '-';
                                              }
                                              ?>
                                          </td> -->

                          <!-- <td><?php echo $data->atas_nama; ?></td> -->
                          <!-- <td><?php echo substr($data->keterangan, 0, 30); ?></td> -->
                          <td><?php echo $data->petugas_input; ?></td>
                          <!-- <td><?php echo $data->petugas_ubah; ?></td> -->



                          <td>
                            <?php
                            $foto_monitoring = $data->foto_monitoring;
                            $thumbnailURL = './foto/foto_monitoring/' . $foto_monitoring;
                            if (!empty($foto_monitoring) && file_exists($thumbnailURL)) {
                            ?>
                              <a href="javascript:void(0);" onclick="openPopup('<?php echo $thumbnailURL; ?>');">
                                <img src="<?php echo $thumbnailURL; ?>" class="gambar" alt="Thumbnail" width="30">
                              </a>
                            <?php
                            } else {
                              echo "";
                            }
                            ?>
                          </td>
                          <td>
                            <a href="<?php echo site_url('users/monitoring_lihat/' . $data->id); ?>" class="btn btn-primary btn-xs"><i class="icon-eye"></i></a>
                            <?php
                            $allowedLevels = ['kadiv_opr', 'admin', 'k_arsip', 's_admin'];
                            if (in_array($user->row()->level, $allowedLevels)) : ?>
                              <a href="<?php echo site_url('users/monitoring_edit/' . $data->id); ?>" class="btn btn-success btn-xs"><i class="icon-pencil7"></i></a>
                            <?php endif; ?>
                            <?php
                            $allowedLevels = ['kadiv_opr', 'k_arsip', 's_admin'];
                            if (in_array($user->row()->level, $allowedLevels)) :
                            ?>
                              <a href="#" class="btn btn-danger btn-xs hapus-monitoring" data-id="<?php echo $data->id; ?>"><i class="icon-trash"></i></a>
                            <?php endif; ?>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    <?php else : ?>

                    <?php endif; ?>
                  </tbody>
                </table>
                <div>
                  <canvas id="statusChart"></canvas>
                  <canvas id="statusBarChart"></canvas>
                  <canvas id="trendChart"></canvas>
                  <canvas id="petugasChart"></canvas>
                </div>
              </div>
            </fieldset>
          </div>
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

      // Create Chart
      var ctx = document.getElementById('statusChart').getContext('2d');
      var statusChart = new Chart(ctx, {
        type: 'pie',
        data: {
          labels: labels,
          datasets: [{
            label: 'Jumlah Usaha',
            data: counts,
            backgroundColor: colors, // Use generated colors
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
                  return labels[tooltipItem.dataIndex] + ': ' + counts[tooltipItem.dataIndex];
                }
              }
            }
          }
        }
      });

      // Create Bar Chart
      var ctxBar = document.getElementById('statusBarChart').getContext('2d');
      var statusBarChart = new Chart(ctxBar, {
        type: 'bar',
        data: {
          labels: labels,
          datasets: [{
            label: 'Jumlah Usaha',
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
                autoSkip: false
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
                autoSkip: false
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

      // Prepare data for petugas_input Chart
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
            label: 'Jumlah Data Monitoring Petugas',
            data: petugasData,
            backgroundColor: petugasColors, // Use generated colors
            borderColor: petugasColors.map(color => chroma(color).darken(1.5).hex()), // Darker border colors
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          scales: {
            x: {
              beginAtZero: true,
              ticks: {
                autoSkip: false
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
                  return petugasLabels[tooltipItem.dataIndex] + ': ' + petugasData[tooltipItem.dataIndex];
                }
              }
            }
          }
        }
      });

    });
  </script>
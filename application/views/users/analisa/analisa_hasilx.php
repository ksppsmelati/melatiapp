<?php
function hitung_usia($tgl_lahir)
{
  $birthDate = new DateTime($tgl_lahir);
  $today = new DateTime('today');
  $usia = $birthDate->diff($today)->y; // Mengambil selisih tahun
  return $usia;
}
?>

<style>
  .container {
    width: 100%;
    margin: 0;
    padding-top: 10px;
  }

  th {
    font-weight: bold;
  }
</style>
<div class="container">
  <div class="content">
    <div class="row">
      <div class="panel panel-flat">
        <?php echo $this->session->flashdata('msg'); ?>
        <div class="panel-body">
          <div class="navigation-buttons text-right">
            <div class="btn-group">
              <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-bars"></i>
              </button>
              <ul class="dropdown-menu dropdown-menu-right" role="menu">
                <li><a href="users/analisa/analisa"><i class="fa fa-line-chart"></i> Data Survey</a></li>
                <li><a href="users/analisa/analisa_hasil"><i class="fa fa-file-text"></i> Hasil Analisa</a></li>
              </ul>
            </div>
          </div>

          <div class="clearfix"></div>
          <fieldset class="content-group">
            <legend class="text-bold"><i class="fa fa fa-file-text"></i> Hasil Analisa</legend>

            <div class="table-responsive">
              <table class="table datatable-basic" width="100%">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Tgl Survey</th>
                    <th>Nama</th>
                    <th>Usia</th>
                    <th>Alamat</th>
                    <th>Plafon</th>
                    <th>Pendapatan Bersih</th>
                    <th>Pengeluaran</th>
                    <th>Laba Usaha</th>
                    <th>Skor Kredit</th>
                    <th>DTI Rasio</th>
                    <th>Surveyor</th>
                    <th>Keputusan</th>
                    <th>Lending Max</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($survey_data as $data) :
                    // Hitung total pendapatan
                    $total_pendapatan = $data->pendapatan_bersih + $data->pendapatan_istri + $data->pendapatan_lain;

                    // Hitung total pengeluaran
                    $total_pengeluaran = $data->biaya_rt + $data->biaya_pendidikan + $data->biaya_lain;

                    // Hitung Debt-to-Income Ratio (DTI) dengan pemeriksaan untuk menghindari pembagian dengan nol
                    $dti_ratio = ($total_pendapatan != 0) ? ($total_pengeluaran / $total_pendapatan) * 100 : 0;

                    // Hitung Skor Kredit
                    $skor_kredit = 0;

                    switch ($data->riwayat_pembiayaan) {
                      case 'Lancar':
                        $skor_kredit += 50; // Pembiayaan lancar
                        break;
                      case 'KurangLancar':
                        $skor_kredit += 30; // Pembiayaan kurang lancar
                        break;
                      case 'Macet':
                        $skor_kredit += 10; // Pembiayaan macet
                        break;
                      case 'TidakTerbayar':
                        $skor_kredit += 0;  // Pembiayaan tidak terbayar
                        break;
                      case 'Restrukturisasi':
                        $skor_kredit += 20; // Pembiayaan dalam restrukturisasi
                        break;
                      case 'Penyelesaian':
                        $skor_kredit += 15; // Pembiayaan dalam penyelesaian
                        break;
                      case 'Penghapusan':
                        $skor_kredit += 5;  // Penghapusan piutang/pembiayaan
                        break;
                      case 'Kebangkrutan':
                        $skor_kredit += 0;  // Pembiayaan terkait kebangkrutan
                        break;
                      case 'PengalihanUtang':
                        $skor_kredit += 10; // Pengalihan utang ke pihak lain
                        break;
                      case 'Pencairan':
                        $skor_kredit += 25; // Pencairan
                        break;
                      default:
                        $skor_kredit += 0; // Nilai default jika tidak ada yang cocok
                    }

                    // Tambahkan bobot DTI ke skor kredit
                    if ($dti_ratio < 30) {
                      $skor_kredit += 30; // DTI kurang dari 30%
                    }

                    // Hitung bobot untuk nilai pasar
                    if ($data->nilai_pasar >= 100000000) {
                      $skor_kredit += 20; // Nilai pasar tinggi
                    } elseif ($data->nilai_pasar >= 50000000) {
                      $skor_kredit += 10; // Nilai pasar sedang
                    } else {
                      $skor_kredit += 5; // Nilai pasar rendah
                    }

                    // Hitung bobot untuk nilai likuid
                    if ($data->nilai_likuid >= 50000000) {
                      $skor_kredit += 20; // Nilai likuid tinggi
                    } elseif ($data->nilai_likuid >= 20000000) {
                      $skor_kredit += 10; // Nilai likuid sedang
                    } else {
                      $skor_kredit += 5; // Nilai likuid rendah
                    }

                    // Hitung bobot untuk kondisi rumah
                    switch ($data->kondisi_rumah) {
                      case 'Permanen':
                        $skor_kredit += 20; // Kondisi permanen
                        break;
                      case 'Semi_Permanen':
                        $skor_kredit += 15; // Kondisi semi permanen
                        break;
                      case 'Tidak_Permanen':
                        $skor_kredit += 10; // Kondisi tidak permanen
                        break;
                      default:
                        $skor_kredit += 0; // Nilai default jika tidak ada yang cocok
                    }

                    // Hitung usia
                    $usia = hitung_usia($data->tgl_lahir); // Asumsikan kolom tgl_lahir ada di $data

                    // Keputusan otomatis berdasarkan skor kredit dan DTI
                    $keputusan = '';
                    if ($skor_kredit >= 80 && $dti_ratio < 30) {
                      $keputusan = 'Disetujui';
                    } elseif ($skor_kredit >= 60 && $dti_ratio < 40) {
                      $keputusan = 'Perlu Pertimbangan';
                    } else {
                      $keputusan = 'Ditolak';
                    }

                    // Hitung lending maksimal
                    $lending_maksimal = 0;
                    if ($skor_kredit >= 80 && $dti_ratio < 30) {
                      $lending_maksimal = $total_pendapatan * 5;
                    } elseif ($skor_kredit >= 60 && $dti_ratio < 40) {
                      $lending_maksimal = $total_pendapatan * 3;
                    } else {
                      $lending_maksimal = $total_pendapatan; // 1 kali pendapatan bersih
                    }
                  ?>
                    <tr>
                      <td><strong><?php echo 'PBY' . $data->id_pby; ?></strong></td>
                      <td><?php echo $data->tgl_survey; ?></td>
                      <td><strong><?php echo $data->nama; ?></strong></td>
                      <td><?php echo $usia; ?> Thn</td>
                      <td><?php echo $data->alamat; ?></td>
                      <td><?php echo 'Rp '. number_format($data->nominal, 0); ?></td>
                      <td><?php echo 'Rp '. number_format($total_pendapatan, 0); ?></td>
                      <td><?php echo 'Rp '. number_format($total_pengeluaran, 0); ?></td>
                      <td><?php echo 'Rp '. number_format($total_pendapatan - $total_pengeluaran, 0); ?></td>
                      <td><?php echo $skor_kredit; ?> %</td>
                      <td><?php echo $dti_ratio; ?> %</td>
                      <td><?php echo $this->usulan_model->getUsernameById($data->id_user); ?></td>
                      <td><strong><?php echo $keputusan; ?></strong></td>
                      <td><?php echo number_format($lending_maksimal, 0); ?></td>
                      <td>
                        <a href="<?php echo base_url('users/analisa/analisa_detail/' . $data->id_pby); ?>" class="btn btn-info btn-xs"><i class="fa fa-search"></i></a>
                        <a href="<?php echo base_url('users/analisa/analisa_edit/' . $data->id_pby); ?>" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a>
                        <a href="<?php echo base_url('users/analisa/analisa_delete/' . $data->id_pby); ?>" class="btn btn-danger btn-xs" onclick="return confirm('Anda yakin ingin menghapus data ini?');"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </fieldset>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
$current_route = $this->router->fetch_class() . '/' . $this->router->fetch_method();
?>
<style>
  .table-striped tbody tr:nth-child(odd) {
    background-color: white;
  }

  .table-striped tbody tr:nth-child(even) {
    background-color: #ccc;
  }

  .table th {
    font-weight: bold;
  }

  .container {
    width: 100%;
    margin: 0;
  }
</style>
<!-- Main content -->
<div class="container">
  <!-- Content area -->
  <div class="content">
    <!-- Dashboard content -->
    <div class="row">
      <div class="panel panel-flat">
        <?php echo $this->session->flashdata('msg'); ?>
        <div class="panel-body">
          <div class="navigation-buttons">
            <i class="fa fa-file-text"></i> Data Hasil Komite
            <div class="btn-group" style="float: right;">
              <!-- Tombol Dropdown (di pojok kanan atas) -->
              <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-bars"></i>
              </button>
              <!-- Isi Dropdown -->
              <ul class="dropdown-menu dropdown-menu-right" role="menu">
                <li><a href="users/komite_data"><i class="fa fa-line-chart"></i> Data Komite</a></li>
                <li><a href="users/komite_hasil"><i class="fa fa-file-text"></i> Hasil Komite</a></li>
              </ul>
            </div>
          </div>
          <hr>
          <form action="<?= base_url('users/komite_hasil') ?>" method="get">
            <div class="row">
              <div class="col-xs-4">
                <input type="date" name="start_date" id="start_date" class="form-control" value="<?= isset($_GET['start_date']) ? $_GET['start_date'] : (isset($start_date) ? $start_date : '') ?>"> 
              </div>
              <div class="col-xs-4">
                <input type="date" name="end_date" id="end_date" class="form-control" value="<?= isset($_GET['end_date']) ? $_GET['end_date'] : (isset($end_date) ? $end_date : date('Y-m-d')) ?>">
              </div>
              <div class="col-xs-1">
                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
              </div>
              <div class="col-xs-1">
                <a href="<?php echo site_url($current_route); ?>" class="btn btn-secondary">&nbsp;&nbsp;&nbsp;<i class="fa fa-refresh"></i></a>
              </div>
            </div>
          </form>
          <br>

          <div class="row">
            <div class="col-xs-3">
              <a href="<?= base_url('users/komite_hasil_export_excel?start_date=' . (isset($_GET['start_date']) ? $_GET['start_date'] : (isset($start_date) ? $start_date : date('Y-m-01'))) . '&end_date=' . (isset($_GET['end_date']) ? $_GET['end_date'] : (isset($end_date) ? $end_date : date('Y-m-d')))) ?>" class="btn btn-success">
                <i class="fa fa-file-excel-o"></i> Export
              </a>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>
        <div id="scrollable-table" class="table-responsive" style="overflow-x: auto;">
          <!-- Tampilkan data survey -->
          <table class="table datatable-basic" width="100%">
            <thead>
              <tr>
                <th style="display: none;">No.</th>
                <th>ID/Cek Bi</th>
                <!--<th>NIK</th>-->
                <th>Nama</th>
                <!--<th>Nama Ibu</th>-->
                <!--<th>Tempat Lahir</th>-->
                <!--<th>Tanggal Lahir</th>-->
                <!--<th>JK</th>-->
                <th>Alamat</th>
                <!-- <th>Alamat Usaha/Kantor</th> -->
                <!-- <th>Pekerjaan Pokok</th> -->
                <!-- <th>Pekerjaan Sampingan</th> -->
                <th>Plafon Usulan</th>
                <!-- <th>Riwayat Pembiayaan</th> -->
                <!-- <th>Bidang Usaha</th> -->
                <!-- <th>Sumber Pelunasan</th> -->
                <!-- <th>Telepon</th> -->
                <!-- <th>Jangka Waktu</th>
                      <th>Jaminan</th>
                      <th>Jam Mulai</th>
                      <th>Jam Selesai</th>
                      <th>Tempat Survey</th>
                      <th>Kondisi Rumah</th>
                      <th>Kekayaan 1</th>
                      <th>Harga Taksiran Kekayaan 1</th>
                      <th>Kekayaan 2</th>
                      <th>Harga Taksiran Kekayaan 2</th>
                      <th>Sumber Informasi</th>
                      <th>Penjualan Usaha Per</th>
                      <th>Jumlah Penjualan</th>
                      <th>Harga Pokok Barang</th>
                      <th>Biaya Usaha</th>
                      <th>Laba Usaha</th>
                      <th>Laba Usaha Bayar</th>
                      <th>Pendapatan Istri</th>
                      <th>Pendapatan Lainya</th>
                      <th>Jumlah Pendapatan Diterima</th>
                      <th>Biaya Rumah Tangga</th>
                      <th>Biaya Pendidikan</th>
                      <th>Biaya Lain-Lain</th>
                      <th>Jumlah Pengeluaran</th>
                      <th>Pendapatan Bersih</th>
                      <th>Lending Maksimal</th>
                      <th>BPKB</th>
                      <th>Jenis Kendaraan</th>
                      <th>Tahun Pembuatan</th>
                      <th>Merk</th>
                      <th>Nomor Mesin</th>
                      <th>Tipe</th>
                      <th>Nomor Rangka</th>
                      <th>Nomor Polisi</th>
                      <th>Kepemilikan</th>
                      <th>Atas Nama</th>
                      <th>Alamat Atas Nama</th>
                      <th>Nilai Pasar</th>
                      <th>Nilai Likuiditas</th>
                      <th>SERTIFIKAT</th>
                      <th>Atas Nama Sertifikat</th>
                      <th>Luas</th>
                      <th>Alamat Lokasi Tanah</th>
                      <th>Map</th>
                      <th>Kecamatan</th>
                      <th>Jarak</th>
                      <th>Untuk Mencapai Lokasi</th>
                      <th>Bentuk Tanah</th>
                      <th>Jenis Tanah</th>
                      <th>Nilai Pasar Wajar</th>
                      <th>Nilai Likuiditas Tanah</th>
                      <th>Kepemilikan Tanah</th>
                      <th>Checklist</th> -->
                <th>Inpuser</th>
                <!-- <th>Tgl Survey</th> -->
                <th>Surveyor</th>
                <th>Analyst</th>
                <th>Hasil Analisa</th>
                <!-- <th>Tgl BI Checking</th> -->
                <th>Hasil Komite</th>
                <th>Realisasi</th>
                <th>Aksi</th>
                <!-- Tambahkan kolom lain sesuai kebutuhan -->
              </tr>
            </thead>
            <tbody>
              <?php $no = 1;
              foreach ($survey_data as $data) : ?>
                <tr>
                  <td style="display: none;">
                    <?php echo $no++; ?>
                  </td>
                  <td data-color="<?php
                                  if (!empty($data->tgl_cek_bi) && $data->status_analisa == 1) {
                                    echo 'green'; // Nilai hijau jika tgl_cek_bi ada dan status_analisa = 1
                                  } elseif ($data->status_analisa == 1 && empty($data->tgl_cek_bi)) {
                                    echo 'blue'; // Nilai biru jika status_analisa sudah 1 tapi belum ada tgl_cek_bi
                                  } elseif (!empty($data->tgl_cek_bi)) {
                                    echo 'orange'; // Nilai oranye jika hanya tgl_cek_bi yang ada
                                  } else {
                                    echo 'black'; // Nilai hitam jika tgl_cek_bi belum ada dan status_analisa masih 0
                                  }
                                  ?>" onclick="copyToClipboard('<?php echo $tgl_formatted = date('Ymd', strtotime($data->tgl_cek_bi)) . '_PBY' . $data->id_pby; ?>')" style="color: <?php
                                                                                                                                                                                    if (!empty($data->tgl_cek_bi) && $data->status_analisa == 1) {
                                                                                                                                                                                      echo 'green';
                                                                                                                                                                                    } elseif ($data->status_analisa == 1 && empty($data->tgl_cek_bi)) {
                                                                                                                                                                                      echo 'blue';
                                                                                                                                                                                    } elseif (!empty($data->tgl_cek_bi)) {
                                                                                                                                                                                      echo 'orange';
                                                                                                                                                                                    } else {
                                                                                                                                                                                      echo 'inherit'; // Default black
                                                                                                                                                                                    }
                                                                                                                                                                                    ?>;">
                    <?php
                    if (!empty($data->tgl_cek_bi)) {
                      echo date('Ymd', strtotime($data->tgl_cek_bi)) . '_PBY' . $data->usulan_id;
                    } else {
                      echo 'PBY' . $data->usulan_id;
                    }
                    ?>
                  </td>
                  <!--<td onclick="copyToClipboard('<?php echo $data->nik; ?>')">-->
                  <!--  <?php echo $data->nik; ?>-->
                  <!--</td>-->
                  <td onclick="copyToClipboard('<?php echo $data->nama; ?>')">
                    <strong><?php echo $data->nama; ?></strong>
                  </td>
                  <!--<td onclick="copyToClipboard('<?php echo $data->nama_ibu; ?>')">-->
                  <!--  <?php echo $data->nama_ibu; ?>-->
                  <!--</td>-->
                  <!--<td onclick="copyToClipboard('<?php echo $data->tempat_lahir; ?>')">-->
                  <!--  <?php echo $data->tempat_lahir; ?>-->
                  <!--</td>-->
                  <!--<td onclick="copyToClipboard('<?php echo $data->tgl_lahir; ?>')">-->
                  <!--  <?php echo $data->tgl_lahir; ?>-->
                  <!--</td>-->
                  <!--<td onclick="copyToClipboard('<?php echo $data->jk; ?>')">-->
                  <!--  <?php echo $data->jk; ?>-->
                  <!--</td>-->
                  <td>
                    <?php echo $data->alamat; ?> <?php echo $data->kelurahan_nama; ?> <?php echo $data->kecamatan_nama; ?> <?php echo $data->kota_nama; ?>
                  </td>
                  <!-- <td><?php echo $data->alamat_usaha; ?></td> -->
                  <!-- <td>
                      <?php echo $data->pekerjaan; ?>
                    </td> -->
                  <!-- <td><?php echo $data->pekerjaan_sampingan; ?></td> -->
                  <td>
                    <strong><?php echo 'Rp ' . number_format($data->nominal, 0, ',', '.'); ?></strong>
                  </td>
                  <!-- <td><?php echo $data->riwayat_pembiayaan; ?></td> -->
                  <!-- <td><?php echo $data->bidang_usaha; ?></td> -->
                  <!-- <td><?php echo $data->sumber_pelunasan; ?></td> -->
                  <!-- <td onclick="copyToClipboard('<?php echo $data->telepon; ?>')">
                    <?php echo $data->telepon; ?>
                  </td> -->
                  <!-- <td><?php echo $data->jangka_waktu; ?></td>
                        <td><?php echo $data->jaminan; ?></td>
                        <td><?php echo $data->jam_mulai; ?></td>
                        <td><?php echo $data->jam_selesai; ?></td>
                        <td><?php echo $data->tempat_survey; ?></td>
                        <td><?php echo $data->kondisi_rumah; ?></td>
                        <td><?php echo $data->kekayaan1; ?></td>
                        <td><?php echo $data->harga_taksiran1; ?></td>
                        <td><?php echo $data->kekayaan2; ?></td>
                        <td><?php echo $data->harga_taksiran2; ?></td>
                        <td><?php echo $data->sumber_info; ?></td>
                        <td><?php echo $data->penjualan_usaha; ?></td>
                        <td><?php echo $data->jml_penjualan; ?></td>
                        <td><?php echo $data->hrg_pokok_brg; ?></td>
                        <td><?php echo $data->biaya_usaha; ?></td>
                        <td><?php echo $data->laba_usaha; ?></td>
                        <td><?php echo $data->laba_usaha_bayar; ?></td>
                        <td><?php echo $data->pendapatan_istri; ?></td>
                        <td><?php echo $data->pendapatan_lain; ?></td>
                        <td><?php echo $data->jml_pendapatan_diterima; ?></td>
                        <td><?php echo $data->biaya_rt; ?></td>
                        <td><?php echo $data->biaya_pendidikan; ?></td>
                        <td><?php echo $data->biaya_lain; ?></td>
                        <td><?php echo $data->jml_pengeluaran; ?></td>
                        <td><?php echo $data->pendapatan_bersih; ?></td>
                        <td><?php echo $data->lending_maksimal; ?></td>
                        <td><?php echo $data->bpkb; ?></td>
                        <td><?php echo $data->jns_kendaraan; ?></td>
                        <td><?php echo $data->thn_pembuatan; ?></td>
                        <td><?php echo $data->merk; ?></td>
                        <td><?php echo $data->no_mesin; ?></td>
                        <td><?php echo $data->tipe; ?></td>
                        <td><?php echo $data->no_rangka; ?></td>
                        <td><?php echo $data->no_pol; ?></td>
                        <td><?php echo $data->kepemilikan; ?></td>
                        <td><?php echo $data->an; ?></td>
                        <td><?php echo $data->an_alamat; ?></td>
                        <td><?php echo $data->nilai_pasar; ?></td>
                        <td><?php echo $data->nilai_likuid; ?></td>
                        <td><?php echo $data->sertifikat; ?></td>
                        <td><?php echo $data->an_sertifikat; ?></td>
                        <td><?php echo $data->luas; ?></td>
                        <td><?php echo $data->alamat_lokasi; ?></td>
                        <td><?php echo $data->lokasi; ?></td>
                        <td><?php echo $data->kecamatan; ?></td>
                        <td><?php echo $data->jarak; ?></td>
                        <td><?php echo $data->capai_lokasi; ?></td>
                        <td><?php echo $data->bentuk_tanah; ?></td>
                        <td><?php echo $data->jenis_tanah; ?></td>
                        <td><?php echo $data->nilai_pasar_wajar; ?></td>
                        <td><?php echo $data->nilai_likuid_t; ?></td>
                        <td><?php echo $data->kepemilikan_t; ?></td>
                        <td><?php echo $data->checklist; ?></td> -->
                  <td style="text-align: center;">
                    <?php echo $this->Usulan_model->getUsernameById($data->id_user); ?><br>
                    <span style="font-size: 80%; opacity: 0.7;"> <?php echo date('Y-m-d', strtotime($data->tanggal)); ?></span>
                  </td>
                  <!-- <td>
                    <?php echo date('Y-m-d', strtotime($data->tgl_survey)); ?>
                  </td> -->
                  <td style="text-align: center;">
                    <?php echo $this->Usulan_model->getUsernameById($data->surveyor); ?><br>
                    <span style="font-size: 80%; opacity: 0.7;"> <?php echo date('Y-m-d', strtotime($data->tgl_survey)); ?></span>
                  </td>
                  <td>
                    <?php echo $this->Usulan_model->getUsernameById($data->analyst); ?>
                  </td>
                  <td>
                    <?php if (!empty($data->hasil_analisa)) : ?>
                      <?php
                      // Check the value of hasil_analisa and display the corresponding small badge
                      switch ($data->hasil_analisa) {
                        case '1':
                          echo '<span class="badge badge-danger badge-sm">Tidak Rekomendasi</span>';
                          break;
                        case '2':
                          echo '<span class="badge badge-primary badge-sm">Pertimbangkan</span>';
                          break;
                        case '3':
                          echo '<span class="badge badge-success badge-sm">Rekomendasi</span>';
                          break;
                        default:
                          echo '<span class="badge badge-secondary badge-sm">-</span>'; // Fallback if no matching value
                      }
                      ?>
                    <?php else : ?>
                      <span class="badge badge-secondary badge-sm"> - </span>
                    <?php endif; ?>
                  </td>
                  <!-- <td>
                    <?php if (!empty($data->tgl_cek_bi)) : ?>
                      <?= date('Y-m-d', strtotime($data->tgl_cek_bi)); ?>
                    <?php else : ?>
                      <span style="color: red;">N/A</span>
                    <?php endif; ?>
                  </td> -->
                  <td>
                    <?php
                    // Check the value of status_komite and display the corresponding small badge
                    switch ($data->status_komite) {
                      case '1':
                        echo '<span class="badge badge-success badge-sm">Acc</span>';
                        break;
                      case '2':
                        echo '<span class="badge badge-warning badge-sm">Ditunda</span>';
                        break;
                      case '3':
                        echo '<span class="badge badge-danger badge-sm">Ditolak</span>';
                        break;
                      default:
                        echo '<span class="badge badge-secondary badge-sm">-</span>'; // Fallback if no matching value
                    }
                    ?>
                  </td>
                  <td>
                    <strong><?php echo 'Rp ' . number_format($data->jml_realisasi, 0, ',', '.'); ?></strong>
                  </td>
                  <td>
                    <a href="<?php echo base_url('users/analisa_detail/' . $data->id_pby); ?>" class="btn btn-info btn-xs"><i class="fa fa-search"></i></a>
                    <a href="<?php echo base_url('users/komite_edit/' . $data->id_pby); ?>" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i></a>
                    <a href="<?php echo base_url('users/analisa_print/' . $data->id_pby); ?>" class="btn btn-primary btn-xs" target="_blank"><i class="fa-solid fa-print"></i></a>
                    <a href="<?php echo base_url('users/analisa_print_form/' . $data->id_pby); ?>" class="btn btn-warning btn-xs" target="_blank"><i class="fa-solid fa-file-invoice-dollar"></i></a>
                    <?php if ($data->category === 'SLIK') : ?>
                      <a href="<?php echo base_url('users/file_user_lihat_id_pby/' . $data->id_pby); ?>" class="btn btn-xs" style="background-color: #6f42c1; color: white;">
                        <i class="fa-solid fa-book-open"></i>
                      </a>
                      <!-- <a href="<?php echo base_url('users/analisa_download_file/' . $data->id_pby); ?>" class="btn btn-warning btn-xs" style="background-color: #e83e8c; color: white;"><i class="fa fa-download"></i></a> -->
                    <?php endif; ?>
                  </td>
                  <!-- Tambahkan kolom lain sesuai kebutuhan -->
                </tr>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<script>
  $(document).ready(function() {
    let isDragging = false;
    let startPositionX;
    let startScrollLeft;

    $("#scrollable-table").on("mousedown", function(event) {
      isDragging = true;
      startPositionX = event.pageX;
      startScrollLeft = $(this).scrollLeft();
    });

    $(document).on("mousemove", function(event) {
      if (isDragging) {
        let deltaX = event.pageX - startPositionX;
        $("#scrollable-table").scrollLeft(startScrollLeft - deltaX);
      }
    });

    $(document).on("mouseup", function() {
      isDragging = false;
    });
  });

  function copyToClipboard(text) {
    // Buat elemen input untuk menyalin teks
    const input = document.createElement('input');
    input.setAttribute('value', text);
    document.body.appendChild(input);
    input.select();
    document.execCommand('copy');
    document.body.removeChild(input);

    // Menggunakan SweetAlert untuk menampilkan pesan
    swal({
      title: "",
      text: text,
      type: "success",
      timer: 1000,
      showConfirmButton: false
    });
  }
</script>
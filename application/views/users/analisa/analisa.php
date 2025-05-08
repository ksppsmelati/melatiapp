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

  .custom-popup-content {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 100%;
  }

  .popup-image-container {
    max-width: 100%;
    max-height: 100%;
    width: auto;
    height: auto;
  }

  .popup-image {
    max-width: 100%;
    max-height: 100%;
    width: auto;
    height: auto;
  }

  /* Custom styles for the popup */
  .custom-popup-content {
    padding: 0;
    /* Remove padding */
    background: none;
    /* Remove background */
    box-shadow: none;
    /* Remove box-shadow */
  }

  /* Custom styles for the close button */
  .custom-popup-close-button {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 40px;
    color: #fff;
    /* Change color if needed */
    cursor: pointer;
    background: transparent;
    border: none;
  }

  .gambar {
    width: 30px;
    /* Set the width of the thumbnail */
    height: 30px;
    /* Set the height of the thumbnail */
    object-fit: cover;
    /* Ensure the image covers the area and maintains aspect ratio */
    display: block;
    /* padding: 3px; */
    /* margin-bottom: 20px; */
    line-height: 1.5384616;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 3px;
    -webkit-transition: border .2s ease-in-out;
    -o-transition: border .2s ease-in-out;
    transition: border .2s ease-in-out;
  }
</style>
<!-- Main content -->
<div class="container">
  <!-- Content area -->
  <div class="content">
    <!-- Dashboard content -->
    <?php echo $this->session->flashdata('msg'); ?>
    <div class="row">
      <div class="panel panel-flat">
        <div class="panel-body">
          <div class="navigation-buttons">
            <i class="fa fa-file-text"></i> Data survey
            <div class="btn-group" style="float: right;">
              <!-- Tombol Dropdown (di pojok kanan atas) -->
              <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-bars"></i>
              </button>
              <!-- Isi Dropdown -->
              <ul class="dropdown-menu dropdown-menu-right" role="menu">
                <li><a href="users/analisa"><i class="fa fa-line-chart"></i> Data Survey</a></li>
                <li><a href="users/analisa_hasil"><i class="fa fa-file-text"></i> Hasil Analisa</a></li>
                <li><a href="users/infografis_analisa_petugas"><i class="fa-solid fa-chart-simple"></i> Jml Analisa Petugas</a></li>
              </ul>
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
                <th>ID/CekBI</th>
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
                <th>Nominal</th>
                <th>Ttd</th>
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
                <th>Surveyor</th>
                <th>Slik</th>
                <!-- <th>Tgl BI Checking</th> -->
                <th>Analisa</th>
                <th>Hasil Analisa</th>
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
                                  ?>" onclick="copyToClipboard('<?php
                                                                // Menangani null atau kosong pada tgl_cek_bi agar tidak memunculkan peringatan
                                                                $tgl_cek_bi = !empty($data->tgl_cek_bi) ? date('Ymd', strtotime($data->tgl_cek_bi)) : '';
                                                                echo $tgl_cek_bi . '_PBY' . $data->id_pby;
                                                                ?>')" style="color: <?php
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
                  <td onclick="copyToClipboard('<?php echo $data->nama; ?>')" style="text-align: center; vertical-align: middle;">
                    <strong><?php echo $data->nama; ?></strong>
                    <?php if (!empty($data->keterangan)) : ?>
                      <div style="color: red;">
                        <i class="fa fa-times-circle"></i><br>
                        <?= nl2br(htmlspecialchars($data->keterangan)); ?>
                      </div>
                    <?php endif; ?>
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
                  <td>
                    <?php
                    $ttd = $data->ttd;  // Mendapatkan nama file ttd
                    $thumbnailURL = './foto/foto_usulan/foto_ttd/' . $ttd;  // Pastikan path file gambar benar

                    // Cek apakah nama ttd tidak kosong dan file gambar ada
                    if (!empty($ttd) && file_exists($thumbnailURL)) {
                    ?>
                      <!-- Menampilkan gambar ttd dengan link untuk melihat gambar besar -->
                      <a href="javascript:void(0);" onclick="openPopup('<?php echo $thumbnailURL; ?>');">
                        <img src="<?php echo $thumbnailURL; ?>" class="gambar" alt="Thumbnail" width="30" loading="lazy">
                      </a>
                    <?php
                    } else {
                      echo '<span style="color:grey"><i class="fa fa-times-circle"></i></span>';  // Menampilkan pesan jika tidak ada tanda tangan
                    }
                    ?>
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
                  <td style="text-align: center;">
                    <?php echo $this->Usulan_model->getUsernameById($data->surveyor); ?><br>
                    <span style="font-size: 80%; opacity: 0.7;"> <?php echo date('Y-m-d', strtotime($data->tgl_survey)); ?></span>
                  </td>
                  <td>
                    <?php
                    // Cek jika ada data untuk id_pby terkait
                    if (!empty($data->id_pby)) :
                      // Misalkan kita cek apakah ada file terkait id_pby di tbl_file_user
                      $this->db->where('id_pby', $data->id_pby);
                      $query = $this->db->get('tbl_file_user');

                      // Jika ada data (baris) yang ditemukan
                      if ($query->num_rows() > 0) :
                    ?>
                        <span style="display:none;">1</span>
                        <span style="color: green;"><i class="fa fa-check-circle"></i></span> <!-- Tanda centang jika ada data -->
                      <?php else : ?>
                        <span style="display:none;">0</span>
                        <span style="color: grey;"><i class="fa fa-times-circle"></i></span> <!-- Tanda silang jika tidak ada data -->
                      <?php endif; ?>
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
                    <?php if ($data->status_analisa == 1) : ?>
                      <span class="status-analisa" style="color: green;">
                        <span style="display:none;">1</span>
                        <i class="fa fa-check-circle"></i> <!-- Tanda centang jika status_analisa == 1 -->
                      </span>
                    <?php else : ?>
                      <span class="status-analisa" style="color: grey;">
                        <span style="display:none;">0</span>
                        <i class="fa fa-times-circle"></i> <!-- Tanda silang jika status_analisa selain 1 -->
                      </span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <?php if ($data->hasil_analisa == 1) : ?>
                      <span class="hasil-analisa" style="color: green;">
                        <span style="display:none;">1</span>
                        <i class="fa fa-check-circle"></i> <!-- Tanda centang jika status_analisa == 1 -->
                      </span>
                    <?php else : ?>
                      <span class="hasil-analisa" style="color: grey;">
                        <span style="display:none;">0</span>
                        <i class="fa fa-times-circle"></i> <!-- Tanda silang jika status_analisa selain 1 -->
                      </span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <a href="<?php echo base_url('users/analisa_detail/' . $data->id_pby); ?>" class="btn btn-info btn-xs"><i class="fa fa-search"></i></a>
                    <a href="<?php echo base_url('users/analisa_edit/' . $data->id_pby); ?>" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i></a>
                    <a href="<?php echo base_url('users/analisa_print/' . $data->id_pby); ?>" class="btn btn-primary btn-xs" target="_blank"><i class="fa-solid fa-print"></i></a>
                    <a href="<?php echo base_url('users/analisa_print_form/' . $data->id_pby); ?>" class="btn btn-warning btn-xs" target="_blank"><i class="fa-solid fa-file-invoice-dollar"></i></a>
                    <!--<a href="<?php echo base_url('users/analisa_download/' . $data->id_pby); ?>" class="btn btn-success btn-xs"><i class="fa fa-download"></i></a>-->
                    <a href="<?php echo site_url('users/file_user_id_pby_upload/' . $data->id_pby); ?>" class="btn btn-light btn-xs" style="background-color: #6c757d; color: white;"><i class="fa fa-upload" aria-hidden="true"></i></a>
                    <?php if ($data->category === 'SLIK') : ?>
                      <a href="<?php echo base_url('users/file_user_lihat_id_pby/' . $data->id_pby); ?>" class="btn btn-xs" style="background-color: #6f42c1; color: white;">
                        <i class="fa-solid fa-book-open"></i>
                      </a>
                      <!-- <a href="<?php echo base_url('users/analisa_download_file/' . $data->id_pby); ?>" class="btn btn-warning btn-xs" style="background-color: #e83e8c; color: white;"><i class="fa fa-download"></i></a> -->
                    <?php endif; ?>
                    <a href="<?php echo base_url('users/analisa_delete/' . $data->id_pby); ?>" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

  function openPopup(imageURL) {
    Swal.fire({
      html: `<img src="${imageURL}" class="popup-image" />`,
      showCloseButton: true,
      showConfirmButton: false,
      customClass: {
        content: 'custom-popup-content',
        closeButton: 'custom-popup-close-button'
      }
    });
  }
</script>
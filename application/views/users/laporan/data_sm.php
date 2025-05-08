<style type="text/css">
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
</style>
<link rel="stylesheet" href="assets/css/sweetalert2.min.css">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="container">
  <div class="content">
    <?php
    echo $this->session->flashdata('msg');
    ?>
    <!-- Dashboard content -->

    <div class="row">
      <!-- Basic datatable -->
      <div class="panel panel-flat">
        <div class="panel-body">
          <div class="navigation-buttons">
            <div class="btn-group" style="float: left;">
              <i class="icon-file-empty2"></i> Data Laporan Otorisasi
            </div>
            <div class="btn-group" style="float: right;">
              <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-bars"></i>
              </button>
              <ul class="dropdown-menu dropdown-menu-right" role="menu">
                <li><a href="users/sm"><i class="fa fa-hourglass-half"></i> Menunggu Proses</a></li>
                <li><a href="users/ss"><i class="fa fa-check-circle"></i> Selesai Otorisasi</a></li>
                <li><a href="users/lap_sm"><i class="fa fa-file"></i> Laporan Otorisasi</a></li>
              </ul>
            </div>
          </div>
          <div class="clearfix"></div>
          <form action="" method="post" target="_blank">
            <a href="<?= base_url("users/data_sm_export/$tgl1/$tgl2") ?>" class="btn btn-success" target="_blank">Export Excel</a>
          </form>
        </div>
        <div class="table-responsive">
          <table class="table datatable-basic" width="100%">
            <thead>
              <tr>
                <th>No</th>
                <!-- <th width="10%">Tanggal</th>
                    <th width="19%">Nomor</th> -->
                <th>Status</th>
                <th>Tgl Transaksi</th>
                <!-- <th>Waktu</th> -->
                <th>Nama Anggota</th>
                <th>No. Rekening</th>
                <th>Nominal</th>
                <th>Foto</th>
                <th>Keterangan</th>
                <th>Tgl Input</th>
                <th>Inpuser</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              foreach ($sql->result() as $baris) {
              ?>
                <tr>
                  <td><?php echo $no; ?></td>
                  <td>
                    <span style="display:none;"><?php echo $baris->dibaca; ?></span>
                    <?php if ($baris->dibaca == 1) : ?>
                      <i class="icon-checkmark4" style="color: green;"></i>
                    <?php else : ?>
                      <i class="fa fa-refresh" aria-hidden="true" style="color: orange;"></i>
                    <?php endif; ?>
                  </td>
                  <!-- <td><?php echo $baris->tgl_sm; ?></td> -->
                  <!-- <td><?php echo $baris->no_surat; ?></td> -->
                  <td><?php echo $baris->tgl_transaksi; ?></td>
                  <!-- <td><?php echo date('H:i:s', strtotime($baris->tgl_no_asal)); ?></td> -->
                  <td><?php echo $baris->nama_anggota; ?></td>
                  <td><?php echo $baris->nomor_rekening; ?></td>
                  <td><?php echo 'Rp ' . number_format($baris->nominal, 0, ',', '.'); ?></td>
                  <td>
                      <?php
                      $data_keterangan = isset($baris->keterangan) ? $baris->keterangan : ''; // Menghindari kesalahan jika properti keterangan tidak ada
                      $query_lampiran = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $baris->token_lampiran));
                      foreach ($query_lampiran->result() as $lampiran) {
                        $thumbnailURL = 'lampiran/' . $lampiran->nama_berkas;
                        $keterangan = $data_keterangan; // Menggunakan variabel keterangan yang telah disiapkan sebelumnya
                      ?>
                        <a href="javascript:void(0);" onclick="openPopup('<?php echo $thumbnailURL; ?>', '<?php echo $keterangan; ?>');">
                          <img src="<?php echo $thumbnailURL; ?>" alt="Thumbnail" width="30">
                        </a>
                      <?php } ?>
                    </td>
                  <td><?php echo $baris->keterangan; ?></td>
                  <td><?php echo $baris->tgl_sm_date; ?></td>
                  <td><?php echo $baris->pengirim; ?></td>
                </tr>
              <?php
                $no++;
              } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
    // sweet alert 
    function openPopup(imageURL, keterangan) {
    Swal.fire({
      html: `<div class="popup-image-container"><div class="popup-keterangan">${keterangan}</div><img src="${imageURL}" class="popup-image" /></div>`,
      showCloseButton: true,
      showConfirmButton: false,
      customClass: {
        content: 'custom-popup-content',
        closeButton: 'custom-popup-close-button'
      }
    });
  }
  // Sweet alert 
</script>
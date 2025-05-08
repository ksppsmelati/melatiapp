<?php
$cek = $user->row();
$id_user = $cek->id_user;
?>
<!-- Link ke SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.3/dist/sweetalert2.min.css">

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
</style>

<!-- Link ke SweetAlert2 JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.3/dist/sweetalert2.min.js"></script>

<script src="assets/js/select2.min.js"></script>
<script src="assets/js/jquery-ui.js"></script>
<script>
  $(function() {
    $("#tgl_ns").datepicker();
  });
  $(function() {
    $("#tgl_no_asal").datepicker();
  });
</script>
<script type="text/javascript" src="assets/js/core/app.js"></script>


<!-- Main content -->

<!-- Content area -->
<div class="container">
  <div class="content">
    <!-- Dashboard content -->
    <div class="row">
      <div class="panel panel-flat">
        <div class="panel-body">
          <fieldset class="content-group">
            <span class="text-bold"><i class="icon-folder-download2"></i> Edit Data Otorisasi</span><br>
            <span style="font-size: 80%; opacity: 0.7;">Tgl Input : <?php echo date('d-m-Y', strtotime($query->tgl_sm_date)); ?></span>
            <hr>
            <?php
            echo $this->session->flashdata('msg');
            ?>
            <div class="msg"></div>
            <form class="form-horizontal" action="" method="post">
              <div class="form-group">
                <label class="control-label col-lg-3">Tgl Transaksi</label>
                <div class="col-lg-4">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="icon-calendar"></i></span>
                    <input type="text" name="tgl_transaksi" class="form-control daterange-single" id="tgl_transaksi" value="<?php echo date('d-m-Y', strtotime($query->tgl_transaksi)); ?>" style="pointer-events: none;">
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-lg-3">Nama Anggota</label>
                <div class="col-lg-9">
                  <input type="text" name="nama_anggota" id="nama_anggota" class="form-control" value="<?php echo $query->nama_anggota; ?>" placeholder="" style="pointer-events: none;">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-lg-3">No. Rekening</label>
                <div class="col-lg-9">
                  <input type="number" name="nomor_rekening" id="nomor_rekening" class="form-control" value="<?php echo $query->nomor_rekening; ?>" placeholder="" style="pointer-events: none;">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-lg-3">Kantor</label>
                <div class="col-lg-9">
                  <?php
                  $kodeKantor = $query->kode_kantor;
                  $namaKantor = '';
                  switch ($kodeKantor) {
                    case '01':
                      $namaKantor = 'Pusat';
                      break;
                    case '02':
                      $namaKantor = 'Sedayu';
                      break;
                    case '03':
                      $namaKantor = 'Sapuran';
                      break;
                    case '04':
                      $namaKantor = 'Kertek';
                      break;
                    case '05':
                      $namaKantor = 'Wonosobo';
                      break;
                    case '06':
                      $namaKantor = 'Kaliwiro';
                      break;
                    case '07':
                      $namaKantor = 'Banjarnegara';
                      break;
                    case '08':
                      $namaKantor = 'Randusari';
                      break;
                    case '09':
                      $namaKantor = 'Kepil';
                      break;
                    default:
                      $namaKantor = $kodeKantor;
                      break;
                  }
                  ?>
                  <input type="text" name="kode_kantor" id="kode_kantor" class="form-control" value="<?php echo $namaKantor; ?>" placeholder="" style="pointer-events: none;">
                </div>
              </div>

              <!-- <div class="form-group">
                      <label class="control-label col-lg-3">Penerima</label>
                      <div class="col-lg-9">
                            <input type="text" name="penerima" id="penerima" class="form-control" value="<?php echo $query->penerima; ?>" placeholder="">
                      </div>
                    </div> -->

              <div class="form-group">
                <label class="control-label col-lg-3">Nominal</label>
                <div class="col-lg-9">
                  <input type="number" name="nominal" id="nominal" class="form-control" value="<?php echo $query->nominal; ?>" placeholder="">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-lg-3">Keterangan</label>
                <div class="col-lg-9">
                  <input type="text" name="keterangan" id="keterangan" class="form-control" value="<?php echo $query->keterangan; ?>" placeholder="" style="pointer-events: none;">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-lg-3">Surat Kuasa</label>
                <div class="col-lg-9">
                  <select class="form-control cari_surat" name="id_surat" id="id_surat" required>
                    <option value="" disabled selected>Pilih Surat</option>
                    <?php
                    // Ambil data surat kuasa berdasarkan user
                    $surat_kuasa = $this->db->where('category', 'surat_kuasa')->where('id_user', $id_user)->get('tbl_file_user')->result();
                    foreach ($surat_kuasa as $surat) {
                      // Menampilkan data surat dengan nilai yang dipilih sebelumnya
                      $selected = ($query->id_surat == $surat->id) ? 'selected' : '';
                      echo "<option value='{$surat->id}' {$selected}>{$surat->nama}</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-lg-3"><b>Foto</b></label>
                <div class="col-lg-12">
                  <table class="table table-bordered" width="100%">
                    <tr style="background:#222;color:#f1f1f1;">
                      <th width='10%'><b>NO.</b></th>
                      <th><b>Berkas</b></th>
                      <th width='10%'><b>Aksi</b></th>
                    </tr>
                    <?php
                    $lampiran = $this->db->get_where('tbl_lampiran', "token_lampiran='$query->token_lampiran'");
                    $no = 1;
                    foreach ($lampiran->result() as $baris) { ?>
                      <tr>
                        <td>
                          <?php echo $no; ?>
                        </td>
                        <td>
                          <a href="lampiran/<?php echo $baris->nama_berkas; ?>" class="btn-view">
                            <img src="lampiran/<?php echo $baris->nama_berkas; ?>" alt="Thumbnail" style="width: auto; height: 50px;">
                          </a>
                        </td>
                        <td>
                          <!-- <a href="lampiran/<?php echo $baris->nama_berkas; ?>" target="_blank" class="btn btn-default xs btn-view"><i class="icon-eye"></i></a> -->
                          <a href="lampiran/<?php echo $baris->nama_berkas; ?>" download title="<?php echo substr($baris->ukuran / 1024, 0, 5); ?> MB" class="btn btn-default xs"><i class="icon-download"></i></a>
                        </td>
                      </tr>
                    <?php
                      $no++;
                    } ?>
                  </table>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-lg-3"><b>Surat Kuasa</b></label>
                <div class="col-lg-12">
                  <table class="table table-bordered" width="100%">
                    <tr style="background:#222;color:#f1f1f1;">
                      <th width='10%'><b>NO.</b></th>
                      <th><b>Berkas</b></th>
                      <th width='10%'><b>Aksi</b></th>
                    </tr>
                    <?php
                    $surat_kuasa = $this->db->get_where("tbl_file_user", array('id' => $query->id_surat));
                    $no = 1;
                    foreach ($surat_kuasa->result() as $baris) {
                      // Dapatkan ekstensi file
                      $file_ext = pathinfo($baris->file_name, PATHINFO_EXTENSION);
                      // Cek apakah file adalah gambar (jpg, png, jpeg, gif)
                      $is_image = in_array(strtolower($file_ext), ['jpg', 'jpeg', 'png', 'gif']);
                    ?>
                      <tr>
                        <td><?php echo $no; ?></td>
                        <td>
                          <?php if ($is_image) { ?>
                            <!-- Tampilkan thumbnail jika file adalah gambar -->
                            <a href="files/file_user/<?php echo $baris->file_name; ?>" class="btn-view">
                              <img src="files/file_user/<?php echo $baris->file_name; ?>" alt="Thumbnail" style="width: auto; height: 50px;">
                            </a>
                          <?php } else { ?>
                            <!-- Tampilkan ikon jika file bukan gambar -->
                            <a href="files/file_user/<?php echo $baris->file_name; ?>" class="btn-view">
                              <?php echo $baris->file_name; ?>
                              <!-- Alternatif: Gunakan ikon generik untuk file -->
                              <!-- <i class="icon-file"></i> Nama file: <?php echo $baris->file_name; ?> -->
                            </a>
                          <?php } ?>
                        </td>
                        <td>
                          <!-- <a href="files/file_user/<?php echo $baris->file_name; ?>" target="_blank" class="btn btn-default xs btn-view"><i class="icon-eye"></i></a> -->
                          <a href="files/file_user/<?php echo $baris->file_name; ?>" download title="Surat Kuasa" class="btn btn-default xs"><i class="icon-download"></i></a>
                        </td>
                      </tr>
                    <?php
                      $no++;
                    } ?>
                  </table>
                </div>
              </div>


              <div class="form-group">
                <label class="control-label col-lg-3">Petugas</label>
                <div class="col-lg-9">
                  <input class="form-control" type="text" name="pengirim" id="pengirim" class="form-control" value="<?php echo $query->pengirim; ?>" placeholder="" readonly>
                </div>
              </div>


              <hr>
              <a href="users/sm" class="btn btn-default">
                << Kembali</a>
                  <button type="submit" name="btnupdate" id="submit-all" class="btn btn-danger" style="float:right;">Update</button>
            </form>

          </fieldset>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    var viewButtons = document.querySelectorAll(".btn-view");
    viewButtons.forEach(function(button) {
      button.addEventListener("click", function(event) {
        event.preventDefault();
        var imageUrl = this.getAttribute("href");

        Swal.fire({
          // title: "Gambar",
          html: `<div class="popup-image-container"><img src="${imageUrl}" class="popup-image" /></div>`,
          customClass: {
            content: "custom-popup-content",
            confirmButton: "custom-popup-button"
          },
          showCloseButton: true,
          confirmButtonText: "Tutup"
        });
      });
    });
  });

  $(document).ready(function() {
    $(".cari_penerima").select2({
      placeholder: "Penerima"
    });
  });

  $(document).ready(function() {
    $('.cari_surat').select2();
  });
</script>
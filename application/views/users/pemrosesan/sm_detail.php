<!-- Link ke SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.3/dist/sweetalert2.min.css">

<!-- Link ke SweetAlert2 JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.3/dist/sweetalert2.min.js"></script>

<script src="assets/js/select2.min.js"></script>
<script src="assets/js/jquery-ui.js"></script>
<script>
  $(function () {
    $("#tgl_ns").datepicker();
  });
  $(function () {
    $("#tgl_no_asal").datepicker();
  });
</script>
<script type="text/javascript" src="assets/js/core/app.js"></script>


<!-- Main content -->
<div class="container">
  <!-- Content area -->
  <div class="content">

    <!-- Dashboard content -->
    <div class="row">
      <div class="col-md-2"></div>
      <div class="col-md-8">
        <div class="panel panel-flat">

          <div class="panel-body">

            <fieldset class="content-group">
              <legend class="text-bold"><i class="icon-folder-download2"></i> Detail Otorisasi Masuk</legend>
              <?php
              echo $this->session->flashdata('msg');
              ?>
              <div class="msg"></div>
              <form class="form-horizontal" action="" enctype="multipart/form-data" method="post">
                <!-- <div class="form-group">
                      <label class="control-label col-lg-3">Nomor</label>
                      <div class="col-lg-5">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="icon-database"></i></span>
                          <select class="form-control cari_ns" name="ns" id="ns" required disabled>
                            <option value="<?php echo $query->no_surat; ?>"><?php echo $query->no_surat; ?></option>
                          </select>
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="icon-calendar"></i></span>
                          <input type="text" name="tgl_ns" class="form-control daterange-single" id="tgl_ns" value="<?php echo $query->tgl_ns; ?>" maxlength="10" required placeholder="Masukkan Tanggal">
                        </div>
                      </div>
                    </div> -->

                <!-- <div class="form-group">
                  <label class="control-label col-lg-3">No. Asal</label>
                  <div class="col-lg-5">
                    <input type="text" name="no_asal" id="no_asal" class="form-control"
                      value="<?php echo $query->no_asal; ?>" placeholder="" required readonly>
                  </div>
                  <div class="col-lg-4">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="icon-calendar"></i></span>
                      <input type="text" name="tgl_no_asal" class="form-control daterange-single" id="tgl_no_asal"
                        value="<?php echo $query->tgl_no_asal; ?>" maxlength="10" required
                        placeholder="Masukkan Tanggal">
                    </div>
                  </div>
                </div> -->

                <!--                 <div class="form-group">
                  <label class="control-label col-lg-3">Pengirim</label>
                  <div class="col-lg-9">
                    <input type="text" name="pengirim" id="pengirim" class="form-control"
                      value="<?php echo $query->pengirim; ?>" placeholder="">
                  </div>
                </div> -->
                <div class="form-group">
                  <label class="control-label col-lg-3">Tanggal</label>
                  <!--                       <div class="col-lg-5">
                            <input type="text" name="no_asal" id="no_asal" class="form-control" value="<?php echo $query->no_asal; ?>" placeholder="" required readonly>
                      </div> -->
                  <div class="col-lg-4">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="icon-calendar"></i></span>
                      <input type="text" name="tgl_no_asal" class="form-control daterange-single" id="tgl_no_asal"
                        value="<?php echo $query->tgl_no_asal; ?>" maxlength="10" required
                        placeholder="Masukkan Tanggal" style="pointer-events: none;">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-lg-3">Nama Anggota</label>
                  <div class="col-lg-9">
                    <input type="text" name="nama_anggota" id="nama_anggota" class="form-control"
                      value="<?php echo $query->nama_anggota; ?>" placeholder="" style="pointer-events: none;">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-lg-3">No. Rekening</label>
                  <div class="col-lg-9">
                    <input type="text" name="nomor_rekening" id="nomor_rekening" class="form-control"
                      value="<?php echo $query->nomor_rekening; ?>" placeholder="" style="pointer-events: none;">
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
                    <input type="text" name="kode_kantor" id="kode_kantor" class="form-control"
                      value="<?php echo $namaKantor; ?>" placeholder="" style="pointer-events: none;">
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
                    <input type="text" name="nominal" id="nominal" class="form-control"
                      value="<?php echo $query->nominal; ?>" placeholder="" style="pointer-events: none;">
                  </div>
                </div>
                <script type="text/javascript">
                  function formatRupiah(input) {
                    var value = input.value.replace(/\D/g, '');
                    var formattedValue = new Intl.NumberFormat('id-ID', {
                      style: 'currency',
                      currency: 'IDR',
                      minimumFractionDigits: 0,
                      maximumFractionDigits: 0
                    }).format(value);
                    input.value = formattedValue;
                  }

                  // Panggil fungsi formatRupiah saat halaman dimuat
                  window.addEventListener('DOMContentLoaded', function () {
                    var inputRupiah = document.getElementById('nominal');
                    formatRupiah(inputRupiah);
                  });
                </script>
                <div class="form-group">
                  <label class="control-label col-lg-3">Keterangan</label>
                  <div class="col-lg-9">
                    <input type="text" name="keterangan" id="keterangan" class="form-control"
                      value="<?php echo $query->keterangan; ?>" placeholder="" style="pointer-events: none;">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-lg-3"><b>Lampiran</b></label>
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
                              <img src="lampiran/<?php echo $baris->nama_berkas; ?>" alt="Thumbnail"
                                style="width: auto; height: 50px;">
                            </a>
                          </td>
                          <td>
                            <a href="lampiran/<?php echo $baris->nama_berkas; ?>" target="_blank"
                              class="btn btn-default xs btn-view"><i class="icon-eye"></i></a>
                            <a href="lampiran/<?php echo $baris->nama_berkas; ?>" download
                              title="<?php echo substr($baris->ukuran / 1024, 0, 5); ?> MB" class="btn btn-default xs"><i
                                class="icon-download"></i></a>
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
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-6">
                          <input type="text" name="pengirim" id="pengirim" class="form-control"
                            value="<?php echo $query->pengirim; ?>" placeholder="" readonly>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
                <script>
                  document.addEventListener("DOMContentLoaded", function () {
                    var viewButtons = document.querySelectorAll(".btn-view");
                    viewButtons.forEach(function (button) {
                      button.addEventListener("click", function (event) {
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
                </script>
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


                <hr>
                <a href="users/sm" class="btn btn-default">
                  << Kembali</a>
                    <!-- <?php if ($user->row()->level == 'user'): ?>
                        <?php if ($query->disposisi == 0) { ?>
                                  <button type="submit" name="btndisposisi" class="btn btn-primary" style="float:right;" onclick="return confirm('Anda yakin?')">Disposisi</button>
                        <?php } else { ?>
                                  <button type="submit" name="btndisposisi0" class="btn btn-primary" style="float:right;" onclick="return confirm('Anda yakin?')">Batal Disposisi</button>
                        <?php } ?>
                    <?php endif; ?> -->
              </form>

            </fieldset>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /dashboard content -->
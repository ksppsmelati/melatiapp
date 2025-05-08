<?php
$cek = $user->row();
$username = $cek->username;
$nama_lengkap = $cek->nama_lengkap;
?>

<style>
  .animate-camera-click {
    animation: cameraClickAnimation 0.5s;
  }

  @keyframes cameraClickAnimation {
    0% {
      transform: scale(1);
    }

    50% {
      transform: scale(1.2);
    }

    100% {
      transform: scale(1);
    }
  }

  /* General Dropzone style */
  .dropzone {
    border: 2px dashed #0087F7;
    margin-top: 10px;
    text-align: center;
    padding: 40px;
    background-color: #f7f7f7;
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  /* Icons */
  .fa-camera-retro {
    font-size: 48px;
    color: #555;
  }

  .fa-cloud-upload-alt {
    font-size: 24px;
    color: #555;
    margin-bottom: 10px;
  }
</style>

<link rel="stylesheet" type="text/css" href="assets/upload/dropzone.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.css">

<script src="assets/js/select2.min.js"></script>
<script src="assets/js/jquery-ui.js"></script>
<script type="text/javascript" src="assets/js/core/app.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.js"></script>
<script type="text/javascript" src="assets/upload/dropzone.min.js"></script>

<div class="container">
  <div class="content">
    <div class="row">
      <div class="panel panel-flat">
        <div class="panel-body">
          <fieldset class="content-group">
            <legend class="text-bold"><i class="fa fa-archive"></i> Info Data Agunan</legend>

            <form class="form-horizontal" enctype="multipart/form-data">
              <div class="row">

                <div class="col-xs-12 col-sm-6" style="display: none;">
                  <div class="form-group">
                    <label class="control-label col-lg-3" style="font-weight: bold;">Tanggal</label>
                    <div class="col-lg-9">
                      <div class="input-group">
                        <span class="input-group-addon"><i class="icon-calendar" style="pointer-events: none;"></i></span>
                        <input type="text" name="tanggal" class="form-control daterange-single" id="tanggal" style="pointer-events: none;" value="<?php echo date('Y-m-d'); ?>">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-sm-12 col-sm-6">
                  <div class="form-group">
                    <div class="col-lg-9">
                      <!-- kosong -->
                    </div>
                  </div>
                </div>

                <div class="col-sm-12 col-sm-6">
                  <div class="form-group">
                    <label class="control-label col-lg-3" style="font-weight: bold;"> </label>
                    <div class="col-lg-9">
                      <select class="form-control cari_anggota" name="cari_anggota">
                        <option value="" disabled selected> Cari No. kontrak / Nama / No. Registrasi</option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="col-xs-6 col-sm-6">
                  <div class="form-group">
                    <label class="control-label col-lg-3" style="font-weight: bold;">Nama Anggota</label>
                    <div class="col-lg-9">
                      <input type="text" name="nm" id="nm" class="form-control" required readonly>
                    </div>
                  </div>
                </div>

                <div class="col-xs-6 col-sm-6">
                  <div class="form-group">
                    <label class="control-label col-lg-3" style="font-weight: bold;">Alamat</label>
                    <div class="col-lg-9">
                      <input type="text" name="alamat" id="alamat" class="form-control" required readonly>
                    </div>
                  </div>
                </div>

                <div class="col-xs-6 col-sm-6">
                  <div class="form-group">
                    <label class="control-label col-lg-3" style="font-weight: bold;">Kode Kantor</label>
                    <div class="col-lg-9">
                      <input type="text" name="kdloc" id="kdloc" class="form-control" required readonly>
                    </div>
                  </div>
                </div>

                <div class="col-xs-6 col-sm-6">
                  <div class="form-group">
                    <label class="control-label col-lg-3" style="font-weight: bold;">No. Kontrak</label>
                    <div class="col-lg-9">
                      <input type="number" name="nokontrak" id="nokontrak" class="form-control" required readonly>
                    </div>
                  </div>
                </div>

                <div class="col-xs-6 col-sm-6">
                  <div class="form-group">
                    <label class="control-label col-lg-3" style="font-weight: bold;">No. Registrasi</label>
                    <div class="col-lg-9">
                      <input type="text" name="noreg" id="noreg" class="form-control" required readonly>
                    </div>
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6">
                  <div class="form-group">
                    <label class="control-label col-lg-3" style="font-weight: bold;">Jenis Jaminan</label>
                    <div class="col-lg-9">
                      <input type="number" name="jnsjamin" id="jnsjamin" class="form-control" required readonly>
                    </div>
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6">
                  <div class="form-group">
                    <label class="control-label col-lg-3" style="font-weight: bold;">Plafond</label>
                    <div class="col-lg-9">
                      <input type="number" name="digunakan" id="digunakan" class="form-control" required readonly>
                    </div>
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6">
                  <div class="form-group">
                    <label class="control-label col-lg-3" style="font-weight: bold;">Jenis Dokumen</label>
                    <div class="col-lg-9">
                      <input type="number" name="jnsdokumen" id="jnsdokumen" class="form-control" required readonly>
                    </div>
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6">
                  <div class="form-group">
                    <label class="control-label col-lg-3" style="font-weight: bold;">Atas Nama</label>
                    <div class="col-lg-9">
                      <input type="text" name="an" id="an" class="form-control" required readonly>
                    </div>
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6">
                  <div class="form-group">
                    <label class="control-label col-lg-3" style="font-weight: bold;">Lokasi Jaminan</label>
                    <div class="col-lg-9">
                      <input type="text" name="lokasi" id="lokasi" class="form-control" required readonly></textarea>
                    </div>
                  </div>
                </div>

                <div class="col-lg-12 col-sm-6">
                  <div class="form-group">
                    <label class="control-label col-lg-6" style="font-weight: bold;">Keterangan </label>
                    <div class="col-lg-12">
                      <textarea name="catatan" id="catatan" class="form-control" required readonly style="height: 100px;"></textarea>
                    </div>
                  </div>
                </div>
            </form>

          </fieldset>
          <!-- penerima dokumen hanya yang mempunyai level s_admin-->

        </div>
      </div>
    </div>
  </div>
</div>

<script>
  // otomatis nama dan rekening
  $(document).ready(function() {
    // Fungsi saat nilai pada select cari_anggota berubah
    $('.cari_anggota').change(function() {
      var selectedNm = $('option:selected', this).attr('data-nm');
      var selectedAlamat = $('option:selected', this).attr('data-alamat');
      var selectedKdloc = $('option:selected', this).attr('data-kdloc');
      var selectedNokontrak = $('option:selected', this).attr('data-nokontrak');
      var selectedNoreg = $('option:selected', this).attr('data-noreg');
      var selectedJnsjamin = $('option:selected', this).attr('data-jnsjamin');
      var selectedDigunakan = $('option:selected', this).attr('data-digunakan');
      var selectedJnsdokumen = $('option:selected', this).attr('data-jnsdokumen');
      var selectedAn = $('option:selected', this).attr('data-an');
      var selectedLokasi = $('option:selected', this).attr('data-lokasi');
      var selectedCatatan = $('option:selected', this).attr('data-catatan');
      $('#nm').val(selectedNm);
      $('#alamat').val(selectedAlamat);
      $('#kdloc').val(selectedKdloc);
      $('#nokontrak').val(selectedNokontrak);
      $('#noreg').val(selectedNoreg);
      $('#jnsjamin').val(selectedJnsjamin);
      $('#digunakan').val(selectedDigunakan);
      $('#jnsdokumen').val(selectedJnsdokumen);
      $('#an').val(selectedAn);
      $('#lokasi').val(selectedLokasi);
      $('#catatan').val(selectedCatatan);
    });

    // Fungsi saat nilai pada input cari berubah
    $('#cari').on('input', function() {
      var cari = $(this).val();

      // Cek apakah inputan cari berupa nomor rekening atau nama anggota
      var isNokontrak = /^\d+$/.test(cari);

      // Cek setiap opsi pada select cari_anggota
      $('.cari_anggota option').each(function() {
        var optionValue = $(this).val();
        var optionNm = $(this).attr('data-nm');
        var optionAlamat = $(this).attr('data-alamat');
        var optionKdloc = $(this).attr('data-kdloc');
        var optionNokontrak = $(this).attr('data-nokontrak');
        var optionNoreg = $(this).attr('data-noreg');
        var optionJnsjamin = $(this).attr('data-jnsjamin');
        var optionDigunakan = $(this).attr('data-digunakan');
        var optionJnsdokumen = $(this).attr('data-jnsdokumen');
        var optionAn = $(this).attr('data-an');
        var optionLokasi = $(this).attr('data-lokasi');
        var optionCatatan = $(this).attr('data-catatan');

        // Jika isNomorRekening true, cari berdasarkan nomor rekening
        // Jika isNomorRekening false, cari berdasarkan nama anggota
        if ((isNoKontrak && optionNokontrak === cari) || (!isNoKontrak && optionNm === cari)) {
          // Set nilai pada select cari_anggota
          $('.cari_anggota').val(optionValue).trigger('change');

          // Keluar dari loop each
          return false;
        }
      });
    });
  });

  // Cari anggota
  $(document).ready(function() {
    $(".cari_anggota").select2({
      ajax: {
        url: "<?php echo base_url('get-agunan-data'); ?>",
        dataType: "json",
        delay: 250,
        processResults: function(data) {
          return {
            results: $.map(data, function(item) {
              return {
                text: item.nm + ' - ' + item.nokontrak,
                id: item.nokontrak,
                nm: item.nm,
                alamat: item.alamat,
                kdloc: item.kdloc,
                nokontrak: item.nokontrak,
                noreg: item.noreg,
                jnsjamin: item.jnsjamin,
                digunakan: item.digunakan,
                jnsdokumen: item.jnsdokumen,
                an: item.an,
                lokasi: item.lokasi,
                catatan: item.catatan
              };
            })
          };
        },
        cache: true
      },
      minimumInputLength: 4
    });

    // Fungsi ini akan dipanggil saat pilihan diubah
    $(".cari_anggota").on("select2:select", function(e) {
      var data = e.params.data;

      // Mengisi input dengan informasi yang sesuai
      $("#nm").val(data.nm);
      $("#alamat").val(data.alamat);
      $("#kdloc").val(data.kdloc);
      $("#nokontrak").val(data.nokontrak);
      $("#noreg").val(data.noreg);
      $("#jnsjamin").val(data.jnsjamin);
      $("#digunakan").val(data.digunakan);
      $("#jnsdokumen").val(data.jnsdokumen);
      $("#an").val(data.an);
      $("#lokasi").val(data.lokasi);
      $("#catatan").val(data.catatan);
    });

    // Fungsi ini akan dipanggil saat pilihan dibatalkan
    $(".cari_anggota").on("select2:unselect", function() {
      // Mengosongkan input jika pilihan dibatalkan
      $("#nm").val("");
      $("#alamat").val("");
      $("#kdloc").val("");
      $("#nokontrak").val("");
      $("#noreg").val("");
      $("#jnsjamin").val("");
      $("#digunakan").val("");
      $("#jnsdokumen").val("");
      $("#an").val("");
      $("#lokasi").val("");
      $("#catatan").val("");
    });
  });
  // /Cari anggota

</script>
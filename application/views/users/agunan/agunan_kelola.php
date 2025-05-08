<?php
$cek = $user->row();
$username = $cek->username;
?>

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
            <legend class="text-bold"><i class="fa fa-archive"></i> Kelola Data Agunan</legend>
            <?php
            echo $this->session->flashdata('msg');
            ?>
            <div class="msg"></div>
            <form class="form-horizontal" action="users/agunan" enctype="multipart/form-data" method="post">
              <div class="form-group">
                <label class="control-label col-lg-3 col-sm-3" style="font-weight: bold;">Tanggal</label>
                <div class="col-lg-4 col-sm-4">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="icon-calendar" style="pointer-events: none;"></i></span>
                    <input type="text" name="tanggal" class="form-control daterange-single" id="tanggal" style="pointer-events: none;" value="<?php echo date('d-m-Y'); ?>">
                  </div>
                </div>
                <label class="control-label col-lg-1 col-sm-1"></label>
                <div class="col-lg-4 col-sm-4">
                  <input type="checkbox" id="inputManualCheckbox" onchange="toggleManualInput()">
                  <small for="inputManualCheckbox">Input Manual</small>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-lg-3" style="font-weight: bold;">Cari </label>
                <div class="col-lg-9">
                  <select class="form-control cari_anggota" name="cari_anggota" required>
                    <option value="" disabled selected> No. kontrak / Nama / No. Reg</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-lg-3" style="font-weight: bold;">Nama Anggota</label>
                <div class="col-lg-9">
                  <input type="text" name="nm" id="nm" class="form-control" required readonly>
                  <input type="text" name="nm_manual" id="nm_manual" class="form-control" placeholder="Nama Anggota (Input Manual)" oninput="syncManualInput('nm_manual', 'nm')" style="display: none;">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-lg-3" style="font-weight: bold;">Alamat</label>
                <div class="col-lg-9">
                  <input type="text" name="alamat" id="alamat" class="form-control" required readonly>
                  <input type="text" name="alamat_manual" id="alamat_manual" class="form-control" placeholder="Alamat (Input Manual)" oninput="syncManualInput('alamat_manual', 'alamat')" style="display: none;">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-lg-3" style="font-weight: bold;">Kantor</label>
                <div class="col-lg-9">
                  <input type="number" name="kdloc" id="kdloc" class="form-control" required readonly>
                  <input type="number" name="kdloc_manual" id="kdloc_manual" class="form-control" placeholder="Kantor (Input Manual)" oninput="syncManualInput('kdloc_manual', 'kdloc')" style="display: none;">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-lg-3" style="font-weight: bold;">No. Kontrak</label>
                <div class="col-lg-9">
                  <input type="number" name="nomor_rekening" id="nomor_rekening" class="form-control" required readonly>
                  <input type="number" name="nomor_kontrak_manual" id="nomor_kontrak_manual" class="form-control" placeholder="No. Kontrak (Input Manual)" oninput="syncManualInput('nomor_kontrak_manual', 'nomor_rekening')" style="display: none;">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-lg-3" style="font-weight: bold;">No. Reg</label>
                <div class="col-lg-9">
                  <input type="text" name="noreg" id="noreg" class="form-control" required readonly>
                  <input type="text" name="noreg_manual" id="noreg_manual" class="form-control" placeholder="No. Reg (Input Manual)" oninput="syncManualInput('noreg_manual', 'noreg')" style="display: none;">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-lg-3" style="font-weight: bold;">Jenis Jaminan</label>
                <div class="col-lg-9">
                  <input type="number" name="jnsjamin" id="jnsjamin" class="form-control" required readonly>
                  <input type="number" name="jnsjamin_manual" id="jnsjamin_manual" class="form-control" placeholder="Jenis jaminan (Input Manual)" oninput="syncManualInput('jnsjamin_manual', 'jnsjamin')" style="display: none;">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-lg-3" style="font-weight: bold;">Plafond</label>
                <div class="col-lg-9">
                  <input type="number" name="digunakan" id="digunakan" class="form-control" required readonly>
                  <input type="number" name="digunakan_manual" id="digunakan_manual" class="form-control" placeholder="Plafond (Input Manual)" oninput="syncManualInput('digunakan_manual', 'digunakan')" style="display: none;">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-lg-3" style="font-weight: bold;">Jenis Dokumen</label>
                <div class="col-lg-9">
                  <input type="number" name="jnsdokumen" id="jnsdokumen" class="form-control" required readonly>
                  <input type="number" name="jnsdokumen_manual" id="jnsdokumen_manual" class="form-control" placeholder="Jenis Dokumen (Input Manual)" oninput="syncManualInput('jnsdokumen_manual', 'jnsdokumen')" style="display: none;">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-lg-3" style="font-weight: bold;">Atas Nama</label>
                <div class="col-lg-9">
                  <input type="text" name="an" id="an" class="form-control" required readonly>
                  <input type="text" name="an_manual" id="an_manual" class="form-control" placeholder="Atas Nama (Input Manual)" oninput="syncManualInput('an_manual', 'an')" style="display: none;">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-lg-3" style="font-weight: bold;">Lokasi Jaminan</label>
                <div class="col-lg-9">
                  <textarea name="lokasi" id="lokasi" class="form-control" required readonly></textarea>
                  <textarea name="lokasi_manual" id="lokasi_manual" class="form-control" placeholder="Lokasi Jaminan (Input Manual)" oninput="syncManualInput('lokasi_manual', 'lokasi')" style="display: none;"></textarea>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-lg-3" style="font-weight: bold;">Catatan</label>
                <div class="col-lg-9">
                  <textarea name="catatan" id="catatan" class="form-control" required readonly></textarea>
                  <textarea name="catatan_manual" id="catatan_manual" class="form-control" placeholder="Catatan (Input Manual)" oninput="syncManualInput('catatan_manual', 'catatan')" style="display: none;"></textarea>
                </div>
              </div>

              <div class="form-group">
                  <label class="control-label col-lg-3" style="font-weight: bold;">Petugas Input</label>
                  <div class="col-lg-9">
                      <input type="text" name="username" id="username" class="form-control" required readonly value="<?php echo $username; ?>">
                  </div>
              </div>

              <div class="form-group">
                <div class="col-lg-12">
                  <div class="dropzone" id="myDropzone">
                    <div class="dz-message">
                      <i class="fas fa-camera-retro" id="cameraIcon" onclick="captureImage()"></i>
                      <p class="upload-text">Ambil Foto</p>
                    </div>
                  </div>
                </div>
              </div>

              <script>
                function syncManualInput(manualInputId, hiddenInputId) {
                  var manualInputValue = document.getElementById(manualInputId).value;
                  document.getElementById(hiddenInputId).value = manualInputValue;
                }
              </script>


              <hr>
              <a href="users/agunan" class="btn btn-default">
                << Kembali</a>
                  <button type="submit" id="submit-all" class="btn btn-danger" style="float:right;">Simpan</button>
            </form>

          </fieldset>
          <!-- penerima dokumen hanya yang mempunyai level s_admin-->
          <div>
            <div>
              <?php
              $this->db->where('level', 's_admin');
              $this->db->order_by('nama_lengkap', 'ASC');
              $result = $this->db->get('tbl_user')->result();
              $namaLengkap = '';
              if (!empty($result)) {
                $namaLengkap = $result[0]->nama_lengkap;
              }
              ?>
              <input type="text" name="penerima" id="penerima" class="form-control" value="<?php echo $namaLengkap; ?>" readonly style="display: none;">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $('.msg').html('');

  // otomatis nama dan rekening
  $(document).ready(function() {
    // Fungsi saat nilai pada select cari_anggota berubah
    $('.cari_anggota').change(function() {
      var selectedNm = $('option:selected', this).attr('data-nm');
      var selectedAlamat = $('option:selected', this).attr('data-alamat');
      var selectedKdloc = $('option:selected', this).attr('data-kdloc');
      var selectedRekening = $('option:selected', this).attr('data-rekening');
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
      $('#nomor_rekening').val(selectedRekening);
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
      var isNomorRekening = /^\d+$/.test(cari);

      // Cek setiap opsi pada select cari_anggota
      $('.cari_anggota option').each(function() {
        var optionValue = $(this).val();
        var optionNm = $(this).attr('data-nm');
        var optionAlamat = $(this).attr('data-alamat');
        var optionKdloc = $(this).attr('data-kdloc');
        var optionRekening = $(this).attr('data-rekening');
        var optionNoreg = $(this).attr('data-noreg');
        var optionJnsjamin = $(this).attr('data-jnsjamin');
        var optionDigunakan = $(this).attr('data-digunakan');
        var optionJnsdokumen = $(this).attr('data-jnsdokumen');
        var optionAn = $(this).attr('data-an');
        var optionLokasi = $(this).attr('data-lokasi');
        var optionCatatan = $(this).attr('data-catatan');

        // Jika isNomorRekening true, cari berdasarkan nomor rekening
        // Jika isNomorRekening false, cari berdasarkan nama anggota
        if ((isNomorRekening && optionRekening === cari) || (!isNomorRekening && optionNama === cari)) {
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
                text: item.nocif,
                id: item.nokontrak,
                nm: item.nm,
                alamat: item.alamat,
                kdloc: item.kdloc,
                rekening: item.nokontrak,
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
      minimumInputLength: 1
    });

    // Fungsi ini akan dipanggil saat pilihan diubah
    $(".cari_anggota").on("select2:select", function(e) {
      var data = e.params.data;

      // Mengisi input dengan informasi yang sesuai
      $("#nm").val(data.nm);
      $("#alamat").val(data.alamat);
      $("#kdloc").val(data.kdloc);
      $("#nomor_rekening").val(data.rekening);
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
      $("#nomor_rekening").val("");
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


  // Function to toggle manual input fields
  function toggleManualInput() {
    var inputManualCheckbox = document.getElementById('inputManualCheckbox');
    var namaAnggotaManual = document.getElementById('nm_manual');
    var nomorRekeningManual = document.getElementById('nomor_kontrak_manual');
    var noregManual = document.getElementById('noreg_manual');

    if (inputManualCheckbox.checked) {
      // Jika checkbox dicentang, tampilkan input manual
      namaAnggotaManual.style.display = 'block';
      nomorRekeningManual.style.display = 'block';
      noregManual.style.display = 'block';
    } else {
      // Jika checkbox tidak dicentang, sembunyikan input manual
      namaAnggotaManual.style.display = 'none';
      nomorRekeningManual.style.display = 'none';
      noregManual.style.display = 'none';
    }
  }
</script>
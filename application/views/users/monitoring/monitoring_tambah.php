<?php
$cek = $user->row();
$level = $cek->level;
$username = $cek->username;
$id_user = $cek->id_user;
$nama_lengkap = $cek->nama_lengkap;

// Data jenis usaha dengan kategori dan subkategori
$jenis_usaha = array(
  "1" => array(
    "nama" => "PERTANIAN",
    "subkategori" => array(
      "1000" => "SAYURAN, BUAH DAN ANEKA UMBI",
      "1010" => "PERKEBUNAN TEMBAKAU",
      "1020" => "PERTANIAN PADI",
      "1030" => "PERTANIAN TANAMAN SEMUSIM LAINNYA",
      "1040" => "PERTANIAN TANAMAN HIAS DAN PENGEMBANGBIAKAN TANAMAN",
      "1050" => "PENGELOLAAN HUTAN",
      "1060" => "JASA PENUNJANG KEHUTANAN",
      "1999" => "JASA LAINNYA"
    )
  ),
  "2" => array(
    "nama" => "PETERNAKAN",
    "subkategori" => array(
      "2000" => "PETERNAKAN SAPI DAN KERBAU",
      "2010" => "PETERNAKAN DOMBA DAN KAMBING",
      "2020" => "PETERNAKAN UNGGAS",
      "2030" => "PERIKANAN BUDIDAYA",
      "2040" => "PERIKANAN TANGKAP",
      "2999" => "PETERNAKAN LAINNYA"
    )
  ),
  "3" => array(
    "nama" => "PERTAMBANGAN DAN PENGGALIAN",
    "subkategori" => array(
      "3000" => "PENGGALIAN BATU, PASIR DAN TANAH LIAT",
      "3010" => "PERTAMBANGAN EMAS, PERAK BATU BARA",
      "3020" => "AKTIVITAS JASA PENUNJANG PERTAMBANGAN",
      "3999" => "PERTAMBANGAN DAN PENGGALIAN LAINNYA"
    )
  ),
  "4" => array(
    "nama" => "INDUSTRI PENGOLAHAN",
    "subkategori" => array(
      "4000" => "INDUSTRI MAKANAN",
      "4010" => "INDUSTRI MINUMAN",
      "4020" => "INDUSTRI PENGOLAHAN TEMBAKAU",
      "4030" => "INDUSTRI TEKSTIL",
      "4040" => "INDUSTRI PENGOLAHAN KAYU",
      "4050" => "INDUSTRI PENGOLAHAN LOGAM (BESI, ALUMINIUM DLL)",
      "4060" => "INDUSTRI PERCETAKAN DAN PENERBITAN",
      "4070" => "INDUSTRI MATERIAL BANGUNAN",
      "4999" => "INDUSTRI LAINNYA"
    )
  ),
  "5" => array(
    "nama" => "PERDAGANGAN",
    "subkategori" => array(
      "5000" => "PERDAGANGAN KELONTONG",
      "5010" => "PERDAGANGAN SAYURAN, BUAH DAN ANEKA UMBI",
      "5020" => "PERDAGANGAN ELEKTRONIK",
      "5030" => "PERDAGANGAN KENDARAAN",
      "5040" => "PERDAGANGAN SEMBAKO",
      "5050" => "PERDAGANGAN MAKANAN/MINUMAN",
      "5060" => "PERDAGANGAN PAKAIAN",
      "5070" => "PERDAGANGAN DAGING",
      "5080" => "PERDAGANGAN BAHAN MAKANAN SEHARI-HARI / BUMBU DLL",
      "5090" => "PERDAGANGAN PERALATAN RUMAH TANGGA",
      "5999" => "PERDAGANGAN LAINNYA"
    )
  ),
  "6" => array(
    "nama" => "JASA",
    "subkategori" => array(
      "6000" => "JASA KONSTRUKSI",
      "6010" => "JASA KEUANGAN",
      "6020" => "JASA KONSULTASI MANAJEMEN",
      "6030" => "JASA KOMPUTER",
      "6040" => "JASA PENDIDIKAN",
      "6050" => "JASA PEMELIHARAAN DAN PERBAIKAN (BENGKEL, SERVICE DLL)",
      "6060" => "JASA PERIKLANAN DAN PUBLIKASI",
      "6070" => "JASA PENYIMPANAN DAN PENGANGKUTAN",
      "6080" => "JASA PERLINDUNGAN DAN KEAMANAN",
      "6090" => "JASA KESEHATAN DAN KEDOKTERAN",
      "6100" => "JASA HIBURAN DAN REKREASI",
      "6110" => "JASA TUKANG BANGUNAN",
      "6120" => "JASA TRAVEL DAN PERJALANAN",
      "6999" => "JASA LAINNYA"
    )
  )
);
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
            <div class="navigation-buttons">
              <div class="btn-group" style="float: left;">
                <i class="fa fa-television"></i> Tambah Monitoring
              </div>

              <div class="btn-group" style="float: right;">
                <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-bars"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-right" role="menu">
                  <li><a href="<?php echo site_url('users/monitoring_by_range_tgl'); ?>"><i class="fa fa-television"></i> Data Monitoring</a></li>
                </ul>
              </div>
            </div>
            <div class="navigation-buttons text-right">
              <div class="btn-group">
                <input type="checkbox" id="inputManualCheckbox" onchange="toggleManualInput()">
                <small for="inputManualCheckbox">Input Manual&nbsp&nbsp&nbsp</small>
              </div>
            </div>
            <div class="clearfix"></div>
            <hr>
            <form class="form-horizontal" id="myForm" action="users/monitoring_simpan" enctype="multipart/form-data" method="post">
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

                <div class="col-xs-12 col-sm-6">
                  <div class="form-group">
                    <label class="control-label col-lg-3" style="font-weight: bold;"> </label>
                    <div class="col-lg-9">
                      <!-- kosong -->
                    </div>
                  </div>
                </div>

                <div class="col-xs-12 col-sm-6">
                  <div class="form-group">
                    <label class="control-label col-lg-3" style="font-weight: bold;"> </label>
                    <div class="col-lg-9">
                      <select class="form-control cari_anggota" name="cari_anggota">
                        <option value="" disabled selected> Cari No. kontrak / Nama / No. Registrasi</option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="col-xs-6 col-sm-6" style="display: none;">
                  <div class="form-group">
                    <label class="control-label col-lg-3" style="font-weight: bold;">Tgl Masuk</label>
                    <div class="col-lg-9">
                      <input type="text" name="inptgljam" id="inptgljam" class="form-control" required readonly>
                    </div>
                  </div>
                </div>

                <div class="col-xs-6 col-sm-6">
                  <div class="form-group">
                    <label class="control-label col-lg-3" style="font-weight: bold;">Nama Anggota</label>
                    <div class="col-lg-9">
                      <input type="text" name="nm" id="nm" class="form-control" required readonly>
                      <input type="text" name="nm_manual" id="nm_manual" class="form-control" placeholder="Nama Anggota (Input Manual)" oninput="syncManualInput('nm_manual', 'nm')" style="display: none;">
                    </div>
                  </div>
                </div>

                <div class="col-xs-6 col-sm-6">
                  <div class="form-group">
                    <label class="control-label col-lg-3" style="font-weight: bold;">Alamat</label>
                    <div class="col-lg-9">
                      <input type="text" name="alamat" id="alamat" class="form-control" required readonly>
                      <input type="text" name="alamat_manual" id="alamat_manual" class="form-control" placeholder="Alamat (Input Manual)" oninput="syncManualInput('alamat_manual', 'alamat')" style="display: none;">
                    </div>
                  </div>
                </div>

                <div class="col-xs-6 col-sm-6">
                  <div class="form-group">
                    <label class="control-label col-lg-3" style="font-weight: bold;">Kode Kantor</label>
                    <div class="col-lg-9">
                      <input type="text" name="kdloc" id="kdloc" class="form-control" required readonly>
                      <select name="kdloc_manual" id="kdloc_manual" class="form-control" onchange="syncManualInput('kdloc_manual', 'kdloc')" style="display: none;">
                        <option value="">Pilih Kode Kantor Manual</option>
                        <option value="01">PUSAT</option>
                        <option value="02">SEDAYU</option>
                        <option value="03">SAPURAN</option>
                        <option value="04">KERTEK</option>
                        <option value="05">WONOSOBO</option>
                        <option value="06">KALIWIRO</option>
                        <option value="07">BANJARNEGARA</option>
                        <option value="08">RANDUSARI</option>
                        <option value="09">KEPIL</option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="col-xs-6 col-sm-6">
                  <div class="form-group">
                    <label class="control-label col-lg-3" style="font-weight: bold;">No. Kontrak</label>
                    <div class="col-lg-9">
                      <input type="number" name="nokontrak" id="nokontrak" class="form-control" required readonly>
                      <input type="number" name="nokontrak_manual" id="nokontrak_manual" class="form-control" placeholder="No. Kontrak (Input Manual)" oninput="syncManualInput('nokontrak_manual', 'nokontrak')" style="display: none;">
                    </div>
                  </div>
                </div>

                <div class="col-xs-6 col-sm-6" style="display: none;">
                  <div class="form-group">
                    <label class="control-label col-lg-3" style="font-weight: bold;" style="display: none;">No. Registrasi</label>
                    <div class="col-lg-9">
                      <input type="text" name="noreg" id="noreg" class="form-control" required readonly>
                      <input type="text" name="noreg_manual" id="noreg_manual" class="form-control" placeholder="No. Registrasi (Input Manual)" oninput="syncManualInput('noreg_manual', 'noreg')" style="display: none;">
                    </div>
                  </div>
                </div>

                <div class="col-xs-6 col-sm-6" style="display: none;">
                  <div class="form-group">
                    <label class="control-label col-lg-3" style="font-weight: bold;">Jenis Jaminan</label>
                    <div class="col-lg-9">
                      <input type="number" name="jnsjamin" id="jnsjamin" class="form-control" readonly>
                      <select name="jnsjamin_manual" id="jnsjamin_manual" class="form-control" onchange="syncManualInput('jnsjamin_manual', 'jnsjamin')" style="display: none;">
                        <option value="">Pilih Jenis Jaminan</option>
                        <option value="1">KENDARAAN RODA 2 (FE0)</option>
                        <option value="2">KENDARAAN RODA 2 (NOTRAIL)</option>
                        <option value="3">KENDARAAN RODA 2 (BT)</option>
                        <option value="4">KENDARAAN RODA 4 (FE0)</option>
                        <option value="5">KENDARAAN RODA 4 (NOTRAIL)</option>
                        <option value="6">KENDARAAN RODA 4 (BT)</option>
                        <option value="99">LAINNYA</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6">
                  <div class="form-group">
                    <label class="control-label col-lg-3" style="font-weight: bold;">Plafond</label>
                    <div class="col-lg-9">
                      <input type="number" name="digunakan" id="digunakan" class="form-control" required readonly>
                      <input type="number" name="digunakan_manual" id="digunakan_manual" class="form-control" placeholder="Plafon (Input Manual)" oninput="syncManualInput('digunakan_manual', 'digunakan')" style="display: none;">
                    </div>
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6">
                  <div class="form-group">
                    <label class="control-label col-lg-3" style="font-weight: bold;">Jenis Jaminan</label>
                    <div class="col-lg-9">
                      <input type="number" name="jnsdokumen" id="jnsdokumen" class="form-control" required readonly>
                      <select name="jnsdokumen_manual" id="jnsdokumen_manual" class="form-control" onchange="syncManualInput('jnsdokumen_manual', 'jnsdokumen')" style="display: none;">
                        <option value="">Pilih Jenis Jaminan</option>
                        <option value="1">SHM</option>
                        <option value="2">SHM A/Rusun</option>
                        <option value="3">SHGB</option>
                        <option value="4">SHP</option>
                        <option value="5">SHGU</option>
                        <option value="6">BPKB</option>
                        <option value="7">AJB</option>
                        <option value="8">BILYET DEPOSITO</option>
                        <option value="9">BUKU TABUNGAN</option>
                        <option value="10">CEK</option>
                        <option value="11">BILYET GIRO</option>
                        <option value="12">SURAT PERNYATAAN & KUASA</option>
                        <option value="13">INVOICE / FAKTUR</option>
                        <option value="14">SIPTB</option>
                        <option value="15">DOKUMEN KONTAK</option>
                        <option value="16">SAHAM</option>
                        <option value="17">OBLIGASI</option>
                        <option value="18">SK INSTITUSI/LEMBAGA</option>
                        <option value="20">LETTER C/GIRIK</option>
                        <option value="21">KARTU PASAR</option>
                        <option value="19">LAIN-LAIN</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6" style="display: none;">
                  <div class="form-group">
                    <label class="control-label col-lg-3" style="font-weight: bold;">Atas Nama</label>
                    <div class="col-lg-9">
                      <input type="text" name="an" id="an" class="form-control" required readonly>
                      <input type="text" name="an_manual" id="an_manual" class="form-control" placeholder="Atas Nama (Input Manual)" oninput="syncManualInput('an_manual', 'an')" style="display: none;">
                    </div>
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6">
                  <div class="form-group">
                    <label class="control-label col-lg-3" style="font-weight: bold;">Lokasi Jaminan</label>
                    <div class="col-lg-9">
                      <input type="text" name="lokasi" id="lokasi" class="form-control" required readonly>
                      <input type="text" name="lokasi_manual" id="lokasi_manual" class="form-control" placeholder="Lokasi Jaminan (Input Manual)" oninput="syncManualInput('lokasi_manual', 'lokasi')" style="display: none;">
                    </div>
                  </div>
                </div>

                <div class="col-xs-6 col-sm-6">
                  <div class="form-group">
                    <label class="control-label col-lg-3" style="font-weight: bold;">Jenis Usaha<span style="color: red;">*</span></label>
                    <div class="col-lg-9">
                      <select class="form-control" name="jns_usaha" id="jns_usaha" required>
                        <option value="" disabled selected>Pilih Jenis Usaha</option>
                        <?php
                        foreach ($jenis_usaha as $kode => $usaha) {
                          echo '<optgroup label="' . $usaha["nama"] . '">';
                          foreach ($usaha["subkategori"] as $sub_kode => $sub_nama) {
                            echo '<option value="' . $sub_kode . '">' . $sub_nama . '</option>';
                          }
                          echo '</optgroup>';
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="col-xs-6 col-sm-6">
                  <div class="form-group">
                    <label class="control-label col-lg-3" style="font-weight: bold;">Status Usaha<span style="color: red;">*</span></label>
                    <div class="col-lg-9">
                      <select class="form-control" name="status" id="status" required onchange="showInputField()">
                        <option value="" disabled selected> Pilih Status Usaha</option>
                        <option value="2">NAIK</option>
                        <option value="1">SAMA</option>
                        <option value="0">TURUN</option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="col-xs-6 col-sm-6">
                  <div class="form-group">
                    <label class="control-label col-lg-3" style="font-weight: bold;">Jumlah Karyawan<span style="color: red;">*</span></label>
                    <div class="col-lg-9">
                      <input type="text" name="jml_karyawan" id="jml_karyawan" class="form-control">
                    </div>
                  </div>
                </div>

                <div class="col-xs-12 col-sm-12">
                  <div class="form-group">
                    <label class="control-label col-xs-12" style="font-weight: bold;">Foto Jaminan<span style="color: red;">*</span></label>
                    <div class="dropzone" id="myDropzone">
                      <div class="dz-message">
                        <i class="fas fa-camera-retro" id="cameraIcon" name="cameraIcon" onclick="captureImage()"></i>
                        <p class="upload-text">Foto Jaminan</p>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
              <div class="form-group" style="display: none;">
                <label class="control-label col-lg-3" style="font-weight: bold;">Petugas Input</label>
                <div class="col-lg-9">
                  <input type="text" name="username" id="username" class="form-control" required readonly value="<?php echo $nama_lengkap; ?>">
                </div>
              </div>

              <div class="form-group" style="display: none;">
                <label class="control-label col-lg-3" style="font-weight: bold;">ID User</label>
                <div class="col-lg-9">
                  <input type="text" name="id_user" id="id_user" class="form-control" required readonly value="<?php echo $id_user; ?>">
                </div>
              </div>

              <div class="col-xs-12 col-sm-12" style="display: none;">
                <div class="form-group">
                  <label class="control-label col-xs-12" style="font-weight: bold;">Kritik & Saran</label>
                  <div class="col-sm-12">
                    <textarea name="catatan" id="catatan" class="form-control" style="height: 100px;"></textarea>
                  </div>
                </div>
              </div>

              <div class="col-xs-12 col-sm-12">
                <div class="form-group">
                  <label class="control-label col-xs-12" style="font-weight: bold;">Keterangan<span style="color: red;">*</span></label>
                  <div class="col-sm-12">
                    <textarea name="keterangan" id="keterangan" class="form-control" style="height: 100px;" required></textarea>
                  </div>
                </div>
              </div>

              <div class="col-xs-6 col-sm-6" id="pembawaField" style="display: none;">
                <div class="form-group">
                  <label class="control-label col-lg-3" style="font-weight: bold;">Nama Pembawa</label>
                  <div class="col-lg-9">
                    <input type="text" name="pembawa" id="pembawa" class="form-control" placeholder="Masukkan Nama pembawa">
                  </div>
                </div>
              </div>

              <input type="hidden" name="penerima" id="penerima" class="form-control" value="<?php echo $nama_lengkap; ?>" readonly>
              <button type="submit" id="submit_compressed" class="btn btn-danger" style="float:right;">Simpan</button>
            </form>

          </fieldset>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="panel panel-flat">
        <div class="panel-body">
          <table class="table table-striped table-xs" width="100%">
            <thead>
              <tr>
                <th>Code</th>
                <th>Jenis Jaminan</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>SHM</td>
              </tr>
              <tr>
                <td>2</td>
                <td>SHM A/Rusun</td>
              </tr>
              <tr>
                <td>3</td>
                <td>SHGB</td>
              </tr>
              <tr>
                <td>4</td>
                <td>SHP</td>
              </tr>
              <tr>
                <td>5</td>
                <td>SHGU</td>
              </tr>
              <tr>
                <td>6</td>
                <td>BPKB</td>
              </tr>
              <tr>
                <td>7</td>
                <td>AJB</td>
              </tr>
              <tr>
                <td>8</td>
                <td>BILYET DEPOSITO</td>
              </tr>
              <tr>
                <td>9</td>
                <td>BUKU TABUNGAN</td>
              </tr>
              <tr>
                <td>10</td>
                <td>CEK</td>
              </tr>
              <tr>
                <td>11</td>
                <td>BILYET GIRO</td>
              </tr>
              <tr>
                <td>12</td>
                <td>SURAT PERNYATAAN & KUASA</td>
              </tr>
              <tr>
                <td>13</td>
                <td>INVOICE / FAKTUR</td>
              </tr>
              <tr>
                <td>14</td>
                <td>SIPTB</td>
              </tr>
              <tr>
                <td>15</td>
                <td>DOKUMEN KONTAK</td>
              </tr>
              <tr>
                <td>16</td>
                <td>SAHAM</td>
              </tr>
              <tr>
                <td>17</td>
                <td>OBLIGASI</td>
              </tr>
              <tr>
                <td>18</td>
                <td>SK INSTITUSI/LEMBAGA</td>
              </tr>
              <tr>
                <td>19</td>
                <td>LAIN-LAIN</td>
              </tr>
              <tr>
                <td>20</td>
                <td>LETTER C/GIRIK</td>
              </tr>
              <tr>
                <td>21</td>
                <td>KARTU PASAR</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $('.msg').html('');

  Dropzone.options.myDropzone = {
    url: "<?php echo base_url('users/monitoring_simpan') ?>",
    paramName: "foto_monitoring",
    acceptedFiles: "image/jpg,image/jpeg",
    autoProcessQueue: false,
    maxFilesize: 10, //MB
    parallelUploads: 1,
    maxFiles: 1,
    addRemoveLinks: true,
    dictCancelUploadConfirmation: "Yakin ingin membatalkan upload ini?",
    dictInvalidFileType: "Type file ini tidak dizinkan",
    dictFileTooBig: "File yang Anda Upload terlalu besar {{filesize}} MB. Maksimal Upload {{maxFilesize}} MB",
    dictRemoveFile: "Hapus",

    init: function() {
      myDropzone = this; // closure
      var submitButton = document.querySelector("#submit_compressed")

      submitButton.addEventListener("click", function(e) {
        e.preventDefault();
        e.stopPropagation();

        var nm = $('#nm').val();
        var alamat = $('#alamat').val();
        var kdloc = $('#kdloc').val();
        var noKontrak = $('#nokontrak').val();
        // var noReg = $('#noreg').val();
        var jnsDok = $('#jnsdokumen').val();
        var digunakan = $('#digunakan').val();
        var lokasi = $('#lokasi').val();
        var cabang = $('#cabang').val();
        var pembawa = $('#pembawa').val();
        var status = $('#status').val();
        var keterangan = $('#keterangan').val();

        if (nm === '' || alamat === '' || kdloc === '' || noKontrak === '' || jnsDok === '' || digunakan === '' || lokasi === '' || status === null || status === '' || keterangan === '') {
          // Jika ada input yang kosong, tampilkan pesan kesalahan dengan Sweet Alert
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Mohon lengkapi semua kolom sebelum menyimpan.',
            confirmButtonColor: '#f44336',
            confirmButtonText: 'OK'
          });
          return; // Berhenti pengiriman formulir
        }
        myDropzone.processQueue();
      });

      // files are dropped here:
      this.on("addedfile", function(file) {
        // Cek apakah file sudah terkompres
        if (file.hasOwnProperty("compressed")) {
          // File sudah terkompres, tidak perlu melakukan proses kompresi lagi
          return;
        }

        var reader = new FileReader();

        reader.onload = function(event) {
          var img = new Image();

          img.onload = function() {
            var canvas = document.createElement("canvas");
            var ctx = canvas.getContext("2d");

            var maxWidth = 800; // Lebar maksimum gambar
            var maxHeight = 800; // Tinggi maksimum gambar

            var width = img.width;
            var height = img.height;

            // Menghitung ulang lebar dan tinggi gambar sesuai dengan rasio aspek
            if (width > height) {
              if (width > maxWidth) {
                height *= maxWidth / width;
                width = maxWidth;
              }
            } else {
              if (height > maxHeight) {
                width *= maxHeight / height;
                height = maxHeight;
              }
            }

            // Mengatur ukuran canvas sesuai dengan gambar yang terkompresi
            canvas.width = width;
            canvas.height = height;

            // Menggambar gambar ke dalam canvas dengan ukuran yang terkompresi
            ctx.drawImage(img, 0, 0, width, height);

            // Mengonversi canvas menjadi gambar terkompresi dalam format JPEG dengan kualitas 0.8
            canvas.toBlob(function(blob) {
              var compressedFile = new File([blob], file.name, {
                type: "image/jpeg"
              });
              compressedFile.compressed = true; // Menandai file sebagai sudah terkompres

              // Menambahkan file terkompresi ke Dropzone untuk diupload
              myDropzone.addFile(compressedFile);
            }, "image/jpeg", 0.8);
          };

          img.src = event.target.result;
        };

        reader.readAsDataURL(file);
        if (!file.hasOwnProperty("compressed")) {
          myDropzone.removeFile(file);
        }
      });

      this.on("sending", function(file, xhr, formData) {
        // Mengumpulkan data form lainnya
        var data = $("#myForm").serializeArray();
        $.each(data, function(key, el) {
          formData.append(el.name, el.value);
        });
      });

      this.on("complete", function(file) {
        //Event ketika Memulai mengupload
        myDropzone.removeFile(file);
      });

      this.on("success", function(file, response) {
        // Menggunakan SweetAlert untuk menampilkan alert
        Swal.fire({
          icon: 'success',
          title: 'Sukses!',
          text: 'Data berhasil dikirim.',
          showCancelButton: true,
          confirmButtonColor: '#5cb85c',
          cancelButtonColor: '#D3D3D3',
          confirmButtonText: 'Tambah Kritik Saran',
          cancelButtonText: 'Tidak'
        }).then((result) => {
          if (result.isConfirmed) {
            // Show the Kritik Saran modal
            window.location = "<?php echo base_url(); ?>users/kritik_saran_tambah";
          } else if (result.dismiss === Swal.DismissReason.cancel) {
            // Redirect to Monitoring page
            window.location = "<?php echo base_url(); ?>users/monitoring_by_range_tgl";
          }
        });
      });
    }
  };


  // Capture Image
  function captureImage() {
    if (window.AndroidFunction) {
      window.AndroidFunction.captureImage();
    }
  }
  const cameraIcon = document.getElementById('cameraIcon');

  cameraIcon.addEventListener('click', () => {
    // Tambahkan kelas animasi ke ikon kamera saat diklik
    cameraIcon.classList.add('animate-camera-click');

    // Hapus kelas animasi setelah selesai
    setTimeout(() => {
      cameraIcon.classList.remove('animate-camera-click');
    }, 1000); // Ganti dengan durasi animasi yang diinginkan (dalam milidetik)
  });
  // /Capture Image

  // otomatis nama dan rekening
  $(document).ready(function() {
    // Fungsi saat nilai pada select cari_anggota berubah
    $('.cari_anggota').change(function() {
      var selectedInptgljam = $('option:selected', this).attr('data-inptgljam');
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

      $('#inptgljam').val(selectedInptgljam);
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

    });

    // Fungsi saat nilai pada input cari berubah
    $('#cari').on('input', function() {
      var cari = $(this).val();

      // Cek apakah inputan cari berupa nomor rekening atau nama anggota
      var isNokontrak = /^\d+$/.test(cari);

      // Cek setiap opsi pada select cari_anggota
      $('.cari_anggota option').each(function() {
        var optionValue = $(this).val();
        var optionInptgljam = $(this).attr('data-inptgljam');
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
                // text: item.nocif + ' - ' + item.nokontrak,
                text: (item.nm || item.nocif) + ' - ' + (item.nokontrak || ''),
                id: item.nokontrak || 0,
                inptgljam: item.inptgljam || 0,
                nm: item.nm || 'N/A',
                alamat: item.alamat || 'N/A',
                kdloc: item.kdloc || 0,
                nokontrak: item.nokontrak || 0,
                noreg: item.noreg || 0,
                jnsjamin: item.jnsjamin || 0,
                digunakan: item.digunakan || 0,
                jnsdokumen: item.jnsdokumen || 0,
                an: item.an || 'N/A',
                lokasi: item.lokasi || 'N/A'
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
      $("#inptgljam").val(data.inptgljam);
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

    });

    // Fungsi ini akan dipanggil saat pilihan dibatalkan
    $(".cari_anggota").on("select2:unselect", function() {
      // Mengosongkan input jika pilihan dibatalkan
      $("#inptgljam").val("");
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

    });
  });
  // /Cari anggota

  // Mendapatkan elemen input teks
  var pembawaInput = document.getElementById('pembawa');

  // Menambahkan event listener untuk memantau perubahan pada input
  pembawaInput.addEventListener('input', function() {
    // Mengonversi nilai input menjadi huruf kapital
    this.value = this.value.toUpperCase();
  });

  // Mendapatkan elemen input teks
  var pembawaInput = document.getElementById('pembawa');

  // Menambahkan event listener untuk memantau perubahan pada input
  pembawaInput.addEventListener('input', function() {
    // Mengonversi nilai input menjadi huruf kapital
    this.value = this.value.toUpperCase();
  });

  function syncManualInput(manualInputId, hiddenInputId) {
    var manualInputValue = document.getElementById(manualInputId).value;
    document.getElementById(hiddenInputId).value = manualInputValue;
  }

  // Function to toggle manual input fields
  function toggleManualInput() {
    var inputManualCheckbox = document.getElementById('inputManualCheckbox');
    var nmManual = document.getElementById('nm_manual');
    var alamatManual = document.getElementById('alamat_manual');
    var kdlocManual = document.getElementById('kdloc_manual');
    var nokontrakManual = document.getElementById('nokontrak_manual');
    var noregManual = document.getElementById('noreg_manual');
    var jnsjaminManual = document.getElementById('jnsjamin_manual');
    var digunakanManual = document.getElementById('digunakan_manual');
    var jnsdokumenManual = document.getElementById('jnsdokumen_manual');
    var anManual = document.getElementById('an_manual');
    var lokasiManual = document.getElementById('lokasi_manual');

    if (inputManualCheckbox.checked) {
      // Jika checkbox dicentang, tampilkan input manual
      nmManual.style.display = 'block';
      alamatManual.style.display = 'block';
      kdlocManual.style.display = 'block';
      nokontrakManual.style.display = 'block';
      noregManual.style.display = 'block';
      jnsjaminManual.style.display = 'block';
      digunakanManual.style.display = 'block';
      jnsdokumenManual.style.display = 'block';
      anManual.style.display = 'block';
      lokasiManual.style.display = 'block';

    } else {
      // Jika checkbox tidak dicentang, sembunyikan input manual
      nmManual.style.display = 'none';
      alamatManual.style.display = 'none';
      kdlocManual.style.display = 'none';
      nokontrakManual.style.display = 'none';
      noregManual.style.display = 'none';
      jnsjaminManual.style.display = 'none';
      digunakanManual.style.display = 'none';
      jnsdokumenManual.style.display = 'none';
      anManual.style.display = 'none';
      lokasiManual.style.display = 'none';

    }
  }

  $(document).ready(function() {
    $('#jns_usaha').select2({
      placeholder: "Pilih Jenis Usaha",
      allowClear: true
    });
  });
</script>
<?php
$cek = $user->row();
$level = $cek->level;
$nama_lengkap = $cek->nama_lengkap;
$id_monitoring = $monitoring->id;
$thumbnailURL = (!empty($monitoring->foto_monitoring) && file_exists('./foto/foto_monitoring/' . $monitoring->foto_monitoring)) ? './foto/foto_monitoring/' . $monitoring->foto_monitoring : '';
$kantorNames = [
    '01' => 'PUSAT',
    '02' => 'SEDAYU',
    '03' => 'SAPURAN',
    '04' => 'KERTEK',
    '05' => 'WONOSOBO',
    '06' => 'KALIWIRO',
    '07' => 'BANJARNEGARA',
    '08' => 'RANDUSARI',
    '09' => 'KEPIL'
];

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
        text-align: center;
        background-color: #f7f7f7;
        display: flex;
        flex-direction: column;
        align-items: center;
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

<div class="container">
    <div class="content">
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <fieldset class="content-group">
                        <div class="navigation-buttons">
                            <div class="btn-group" style="float: left;">
                                <i class="icon-pencil7"></i> EDIT - ID: <?php echo $monitoring->id; ?><br>
                                <span style="font-size: 80%; opacity: 0.7;">Tgl Masuk: <?php echo $monitoring->tgl_masuk; ?></span>
                            </div>
                            <div class="btn-group" style="float: right;">
                                <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-bars"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <li><a href="<?php echo site_url('users/monitoring_tambah'); ?>"><i class="fa fa-plus"></i> Tambah Monitoring</a></li>
                                <li><a href="<?php echo site_url('users/monitoring_by_range_tgl'); ?>"><i class="fa fa-television"></i> Data Monitoring</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr>

                        <form class="form-horizontal" id="myForm" action="<?php echo site_url('users/monitoring_update/' . $id_monitoring); ?>" enctype="multipart/form-data" method="post">
                            <div class="row">

                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" style="font-weight: bold;">Nama Anggota</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="nm" id="nm" class="form-control" value="<?php echo $monitoring->nama_anggota; ?>" required readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" style="font-weight: bold;">Alamat</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="alamat" id="alamat" class="form-control" value="<?php echo $monitoring->alamat; ?>" required readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" style="font-weight: bold;">Kode Kantor</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="kode_kantor" id="kode_kantor" class="form-control" value="<?php echo $monitoring->kode_kantor; ?>" required readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" style="font-weight: bold;">No. Kontrak</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="no_kontrak" id="no_kontrak" class="form-control" value="<?php echo $monitoring->no_kontrak; ?>" required readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" style="font-weight: bold;">No. Registrasi</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="no_registrasi" id="no_registrasi" class="form-control" value="<?php echo $monitoring->no_registrasi; ?>" required readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" style="font-weight: bold;">Jenis Jaminan</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="jenis_jaminan" id="jenis_jaminan" class="form-control" value="<?php echo $monitoring->jenis_jaminan; ?>" required readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" style="font-weight: bold;">Plafond</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="plafond" id="plafond" class="form-control" value="<?php echo $monitoring->plafond; ?>" required readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" style="font-weight: bold;">Jenis Dokumen</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="jenis_dokumen" id="jenis_dokumen" class="form-control" value="<?php echo $jenisDokumenText = getJenisDokumenText($monitoring->jenis_dokumen); ?>" required readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" style="font-weight: bold;">Atas Nama</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="atas_nama" id="atas_nama" class="form-control" value="<?php echo $monitoring->atas_nama; ?>" required readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" style="font-weight: bold;">Lokasi Jaminan</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="lokasi_jaminan" id="lokasi_jaminan" class="form-control" value="<?php echo $monitoring->lokasi_jaminan; ?>" required readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" style="font-weight: bold;">Jenis Usaha</label>
                                        <div class="col-lg-9">
                                            <select class="form-control" name="jns_usaha" id="jns_usaha" required>
                                                <option value="" disabled>Pilih Jenis Usaha</option>
                                                <?php
                                                foreach ($jenis_usaha as $kode => $usaha) {
                                                    echo '<optgroup label="' . $usaha["nama"] . '">';
                                                    foreach ($usaha["subkategori"] as $sub_kode => $sub_nama) {
                                                        $selected = ($sub_kode == $monitoring->jns_usaha) ? 'selected' : '';
                                                        echo '<option value="' . $sub_kode . '" ' . $selected . '>' . $sub_nama . '</option>';
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
                                        <label class="control-label col-lg-3" style="font-weight: bold;">Status Usaha</label>
                                        <div class="col-lg-9">
                                            <select name="status" id="status" class="form-control" style="background-color: #fdfd96;" required>
                                                <option value="1" <?php echo ($monitoring->status == 1) ? 'selected' : ''; ?>>&#x1F7E1; SAMA</option>
                                                <option value="2" <?php echo ($monitoring->status == 2) ? 'selected' : ''; ?>>&#x1F7E2; NAIK</option>
                                                <option value="0" <?php echo ($monitoring->status == 0) ? 'selected' : ''; ?>>&#x1F534; TURUN</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" style="font-weight: bold;">Jumlah Karyawan</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="jml_karyawan" id="jml_karyawan" class="form-control" value="<?php echo $monitoring->jml_karyawan; ?>">
                                        </div>
                                    </div>
                                </div>


                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" style="font-weight: bold;">Foto Jaminan</label>
                                        <div class="col-lg-9">
                                            <?php
                                            $foto_monitoring = $monitoring->foto_monitoring; // Fix here: Use object property access
                                            $thumbnailURL = './foto/foto_monitoring/' . $foto_monitoring;
                                            if (!empty($foto_monitoring) && file_exists($thumbnailURL)) {
                                            ?>
                                                <a href="javascript:void(0);" onclick="openPopup('<?php echo $thumbnailURL; ?>');">
                                                    <img src="<?php echo $thumbnailURL; ?>" class="gambar" alt="Thumbnail">
                                                </a>
                                            <?php
                                            } else {
                                                echo "";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12">
                                    <div class="form-group">
                                        <div class="dropzone" id="myDropzone">
                                            <div class="dz-message">
                                                <div style="width: 100px; height: 100px; overflow: hidden; position: relative;">
                                                    <img src="<?php echo $thumbnailURL; ?>" width="100%" height="auto" loading="lazy">
                                                </div>
                                                <i class="fas fa-plus-circle plus-icon" onclick="document.getElementById('foto_monitoring').click();"></i>
                                                <p style="font-size: 14px;">foto monitoring</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12" style="display: none;">
                                    <div class="form-group">
                                        <label class="control-label col-lg-6" style="font-weight: bold;">Kritik & Saran </label>
                                        <div class="col-lg-12">
                                            <textarea name="catatan" id="catatan" class="form-control" ><?php echo $monitoring->catatan; ?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label col-lg-6" style="font-weight: bold;">Keterangan </label>
                                        <div class="col-lg-12">
                                            <textarea name="keterangan" id="keterangan" class="form-control"><?php echo $monitoring->keterangan; ?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-6" style="display: none;">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" style="font-weight: bold;">Tanggal Ubah</label>
                                        <div class="col-lg-9">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="icon-calendar" style="pointer-events: none;"></i></span>
                                                <input type="text" name="tanggal_ubah" class="form-control daterange-single" id="tanggal_ubah" style="pointer-events: none;" value="<?php echo date('Y-m-d'); ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-sm-6" style="display: none;">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" style="font-weight: bold;">Petugas Update</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="petugas_ubah" id="petugas_ubah" class="form-control" required readonly value="<?php echo $nama_lengkap; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix"></div>
                                <hr>
                                <a href="users/monitoring" class="btn btn-default">
                                    << Kembali</a>
                                        <button type="submit" id="submit_compressed" class="btn btn-danger" style="float:right;">Update</button>
                        </form>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" type="text/css" href="assets/upload/dropzone.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.css">

<script src="assets/js/select2.min.js"></script>
<script src="assets/js/jquery-ui.js"></script>
<script type="text/javascript" src="assets/js/core/app.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.js"></script>
<script type="text/javascript" src="assets/upload/dropzone.min.js"></script>

<script>
    $('.msg').html('');
    Dropzone.options.myDropzone = {
        url: "<?php echo site_url('users/monitoring_update/' . $id_monitoring); ?>",
        paramName: "foto_monitoring",
        acceptedFiles: "'image/jpg,image/jpeg,image/png,image/bmp",
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

                var _status = $('#status').val();

                if (_status === '') {
                    // Jika ada input yang kosong, tampilkan pesan kesalahan dengan Sweet Alert
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Mohon masukan status sebelum menyimpan.',
                        confirmButtonColor: '#f44336',
                        confirmButtonText: 'OK'
                    });
                    return; // Berhenti pengiriman formulir
                }

                if (myDropzone.getQueuedFiles().length === 0) {
                    submitFormWithoutFile();
                } else {
                    myDropzone.processQueue();
                }
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
                    confirmButtonColor: '#f44336',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location = "<?php echo site_url('users/monitoring_by_range_tgl'); ?>";
                    }
                });
            });
        }

    };

    function submitFormWithoutFile() {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('users/monitoring_update/' . $id_monitoring); ?>",
            data: $("#myForm").serialize(),
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses!',
                    text: 'Data berhasil dikirim.',
                    confirmButtonColor: '#f44336',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location = "<?php echo site_url('users/monitoring_by_range_tgl'); ?>";
                    }
                });
            }
        });
    }

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

    // Mendapatkan elemen input teks
    var pembawaInput = document.getElementById('pembawa');

    // Menambahkan event listener untuk memantau perubahan pada input
    pembawaInput.addEventListener('input', function() {
        // Mengonversi nilai input menjadi huruf kapital
        this.value = this.value.toUpperCase();
    });

    // Fungsi saat nilai pada select status berubah
    function showInputField() {
        var selectedValue = document.getElementById("status").value;

        // Objek untuk memetakan nilai yang dipilih dengan elemen yang ingin ditampilkan
        var elementsToShow = {
            "DIBAWA": "pembawaField",
            "CABANG": "cabangField"
        };

        // Menampilkan atau menyembunyikan elemen berdasarkan nilai yang dipilih
        for (var key in elementsToShow) {
            if (selectedValue === key) {
                document.getElementById(elementsToShow[key]).style.display = "block";
            } else {
                document.getElementById(elementsToShow[key]).style.display = "none";
            }
        }
    }

    // Panggil fungsi showInputField saat halaman dimuat untuk menyesuaikannya dengan status awal
    window.onload = function() {
        showInputField();
    };

    function toggleFields() {
        var status = document.getElementById('status').value;
        var cabangField = document.getElementById('cabangField');
        var pembawaField = document.getElementById('pembawaField');
        var myDropzone = document.getElementById('myDropzone');

        // Reset style
        cabangField.style.display = 'none';
        pembawaField.style.display = 'none';
        myDropzone.style.display = 'none';

        // Reset disabled attribute
        document.getElementById('cabang').disabled = true;
        document.getElementById('nama_pembawa').disabled = true;

        // Reset values
        document.getElementById('cabang').value = '';
        document.getElementById('nama_pembawa').value = '';

        // Show appropriate fields based on selected status
        if (status == 'CABANG') {
            cabangField.style.display = '';
            document.getElementById('cabang').disabled = false;
        } else if (status == 'DIBAWA') {
            pembawaField.style.display = '';
            document.getElementById('nama_pembawa').disabled = false;
        } else if (status == 'DIAMBIL') {
            myDropzone.style.display = ''; // Show the dropzone if "DIAMBIL" is selected
        }
    }

    // Call toggleFields function on page load to initialize field visibility
    toggleFields();

    // Function to reset all fields
    function resetAllFields() {
        document.getElementById('cabang').value = '';
        document.getElementById('nama_pembawa').value = '';
        document.getElementById('status').value = '';
        toggleFields(); // Reset the field visibility
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
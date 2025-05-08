<?php
$cek = $user->row();
$level = $cek->level;
$nama_lengkap = $cek->nama_lengkap;
$id_agunan = $agunan->id;
$thumbnailURL = (!empty($agunan->foto_agunan) && file_exists('./foto/foto_agunan/' . $agunan->foto_agunan)) ? './foto/foto_agunan/' . $agunan->foto_agunan : '';
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
                                <i class="icon-pencil7"></i> EDIT DATA BPKB - ID: <?php echo $agunan->id; ?><br>
                                <span style="font-size: 80%; opacity: 0.7;">Tgl Masuk: <?php echo $agunan->tgl_masuk; ?></span>
                            </div>
                            <div class="btn-group" style="float: right;">
                                <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-bars"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                    <li><a href="<?php echo site_url('users/agunan/agunan'); ?>"><i class="fa fa-id-card"></i> DATA BPKB</a></li>
                                    <li><a href="<?php echo site_url('users/agunan/agunan_shm'); ?>"><i class="fa fa-folder"></i> DATA SHM</a></li>
                                    <?php
                                $allowedLevels = ['kadiv_opr', 'k_arsip', 's_admin'];
                                if (in_array($user->row()->level, $allowedLevels)) {
                                    echo '<li><a href="' . site_url('users/agunan_data_proses') . '"><i class="fa fa-shopping-cart"></i> DATA PESANAN</a></li>';
                                }
                                ?>
                                <?php
                                $allowedLevels = ['admin'];
                                if (in_array($user->row()->level, $allowedLevels)) {
                                    echo '<li><a href="' . site_url('users/agunan_data_proses_cabang') . '"><i class="fa fa-shopping-cart"></i> DATA PESANAN</a></li>';
                                }
                                ?>
                                </ul>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr>

                        <form class="form-horizontal" id="myForm" action="<?php echo site_url('users/agunan_update/' . $id_agunan); ?>" enctype="multipart/form-data" method="post">
                            <div class="row">

                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" style="font-weight: bold;">Nama Anggota</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="nm" id="nm" class="form-control" value="<?php echo $agunan->nama_anggota; ?>" required readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" style="font-weight: bold;">Alamat</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="alamat" id="alamat" class="form-control" value="<?php echo $agunan->alamat; ?>" required readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" style="font-weight: bold;">Kode Kantor</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="kode_kantor" id="kode_kantor" class="form-control" value="<?php echo $agunan->kode_kantor; ?>" required readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" style="font-weight: bold;">No. Kontrak</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="no_kontrak" id="no_kontrak" class="form-control" value="<?php echo $agunan->no_kontrak; ?>" required readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" style="font-weight: bold;">Tgl Masuk</label>
                                        <div class="col-lg-9">
                                            <input type="date" name="tgl_masuk" id="tgl_masuk" class="form-control" value="<?php echo $agunan->tgl_masuk; ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" style="font-weight: bold;">No. Registrasi</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="no_registrasi" id="no_registrasi" class="form-control" value="<?php echo $agunan->no_registrasi; ?>" required readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" style="font-weight: bold;">Jenis Jaminan</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="jenis_jaminan" id="jenis_jaminan" class="form-control" value="<?php echo $agunan->jenis_jaminan; ?>" required readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" style="font-weight: bold;">Plafond</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="plafond" id="plafond" class="form-control" value="<?php echo $agunan->plafond; ?>" required readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" style="font-weight: bold;">Jenis Dokumen</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="jenis_dokumen" id="jenis_dokumen" class="form-control" value="<?php echo $agunan->jenis_dokumen; ?>" required readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" style="font-weight: bold;">Atas Nama</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="atas_nama" id="atas_nama" class="form-control" value="<?php echo $agunan->atas_nama; ?>" required readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" style="font-weight: bold;">Lokasi Jaminan</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="lokasi_jaminan" id="lokasi_jaminan" class="form-control" value="<?php echo $agunan->lokasi_jaminan; ?>" required readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" style="font-weight: bold;">Status</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="status_sekarang" id="status_sekarang" class="form-control" value="<?php $cabangName = array_key_exists($agunan->cabang, $kantorNames) ? $kantorNames[$agunan->cabang] : '';
                                                                                                                                        echo $agunan->status . ' ' . $cabangName . ' ' . $agunan->nama_pembawa; ?>" required readonly style="background-color: #fdfd96;">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label col-lg-3" style="font-weight: bold;">Foto Pengambilan</label>
                                            <div class="col-lg-9">
                                                <?php
                                                $foto_agunan = $agunan->foto_agunan; // Fix here: Use object property access
                                                $thumbnailURL = './foto/foto_agunan/' . $foto_agunan;
                                                if (!empty($foto_agunan) && file_exists($thumbnailURL)) {
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
                                        <label class="control-label col-lg-6" style="font-weight: bold;">Keterangan </label>
                                        <div class="col-lg-12">
                                            <textarea name="keterangan" id="keterangan" class="form-control" required ><?php echo $agunan->keterangan; ?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-6" style="font-weight: bold;">Catatan </label>
                                        <div class="col-lg-12">
                                            <textarea name="catatan" id="catatan" class="form-control"><?php echo $agunan->catatan; ?></textarea>
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

                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" style="font-weight: bold;">Update Status</label>
                                        <div class="col-lg-9">
                                            <?php
                                            // Check if the current status is "DIAMBIL"
                                            $isDisabled = ($agunan->status == "DIAMBIL" && $level !== 'k_arsip' && $level !== 's_admin') ? 'disabled' : '';
                                            ?>
                                            <select class="form-control" name="status" id="status" required onchange="toggleFields()" <?= $isDisabled; ?>>
                                                <option value="" selected required> Pilih Status </option>
                                                <?php if ($level === 's_admin' || $level === 'k_arsip'|| $level === 'k_admin') : ?>
                                                    <option value="BRANGKAS" <?php if ($agunan->status == "BRANGKAS") echo "selected"; ?>>BRANGKAS</option>
                                                <?php endif; ?>
                                                <?php if ($level === 'admin') : ?>
                                                    <option value="CABANG" <?php if ($agunan->status == "CABANG") echo "selected"; ?>>CABANG</option>
                                                <?php endif; ?>
                                                <option value="DIBAWA" <?php if ($agunan->status == "DIBAWA") echo "selected"; ?>>DIBAWA</option>
                                                <option value="DIAMBIL" <?php if ($agunan->status == "DIAMBIL") echo "selected"; ?>>DIAMBIL</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-6 col-sm-6" id="cabangField" style="display: none;">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" style="font-weight: bold;">Kantor Cabang</label>
                                        <div class="col-lg-9">
                                            <select class="form-control" name="cabang" id="cabang">
                                                <option value="" disabled selected> Pilih Cabang </option>
                                                <option value="02" <?php if ($agunan->cabang == "02") echo "selected"; ?>>SEDAYU</option>
                                                <option value="03" <?php if ($agunan->cabang == "03") echo "selected"; ?>>SAPURAN</option>
                                                <option value="04" <?php if ($agunan->cabang == "04") echo "selected"; ?>>KERTEK</option>
                                                <option value="05" <?php if ($agunan->cabang == "05") echo "selected"; ?>>WONOSOBO</option>
                                                <option value="06" <?php if ($agunan->cabang == "06") echo "selected"; ?>>KALIWIRO</option>
                                                <option value="07" <?php if ($agunan->cabang == "07") echo "selected"; ?>>BANJARNEGARA</option>
                                                <option value="08" <?php if ($agunan->cabang == "08") echo "selected"; ?>>RANDUSARI</option>
                                                <option value="09" <?php if ($agunan->cabang == "09") echo "selected"; ?>>KEPIL</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-6 col-sm-6" id="pembawaField" style="display: none;">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" style="font-weight: bold;">Nama Pembawa</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="nama_pembawa" id="nama_pembawa" class="form-control" placeholder="Masukkan Nama pembawa" value="<?php echo $agunan->nama_pembawa; ?>" oninput="this.value = this.value.toUpperCase()">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12" >
                                    <div class="form-group">
                                        <div class="dropzone" id="myDropzone" style="display: none;">
                                            <div class="dz-message">
                                                <div style="width: 100px; height: 100px; overflow: hidden; position: relative;">
                                                    <img src="<?php echo $thumbnailURL; ?>" width="100%" height="auto" loading="lazy">
                                                </div>
                                                <i class="fas fa-plus-circle plus-icon" onclick="document.getElementById('foto_agunan').click();"></i>
                                                <p style="font-size: 14px;">foto pengambilan</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix"></div>
                                <hr>
                                <a href="users/agunan" class="btn btn-default">
                << Kembali</a>
                                <button type="submit" id="submit_compressed" class="btn btn-danger" style="float:right;">Simpan</button>
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
        url: "<?php echo site_url('users/agunan_update/' . $id_agunan); ?>",
        paramName: "foto_agunan",
        acceptedFiles: "image/jpg,image/jpeg,image/bmp",
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

                if (_status === 'DIAMBIL' && myDropzone.getQueuedFiles().length === 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Mohon upload file foto sebelum menyimpan.',
                        confirmButtonColor: '#f44336',
                        confirmButtonText: 'OK'
                    });
                    return; // Prevent form submission if no file is uploaded
                }

                if (myDropzone.getQueuedFiles().length > 0) {
                    myDropzone.processQueue(); // Process the file upload queue
                } else {
                    submitFormWithoutFile(); // Submit without file
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
                        window.history.back();
                    }
                });
            });
        }

    };

    function submitFormWithoutFile() {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('users/agunan_update/' . $id_agunan); ?>",
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
                        window.history.back();
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
             myDropzone.style.display = '';  // Show the dropzone if "DIAMBIL" is selected
             document.getElementById('nama_pembawa').value = '';
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
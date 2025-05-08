<?php
$cek = $user->row();
$id_user = $cek->id_user;
$nama_lengkap = strtoupper($cek->nama_lengkap);
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

    /* Upload text */
    .upload-text {
        font-size: 16px;
        color: #555;
        margin-bottom: 5px;
    }
    .required {
    color: red;
    font-style: italic;
    margin-top: 10px;
    font-size: 12px;
  }

  .form-control.status {
        border: 1px solid grey;
        border-radius: 5px;
    }
</style>

<link rel="stylesheet" type="text/css" href="assets/upload/dropzone.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.css">

<script src="assets/js/jquery-ui.js"></script>
<script type="text/javascript" src="assets/js/core/app.js"></script>
<script type="text/javascript" src="assets/upload/dropzone.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.js"></script>
<div class="container">
    <div class="content">
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <div class="navigation-buttons">
                        <div class="btn-group" style="float: left;">
                            <!-- Tombol Back (di pojok kiri atas) -->
                            <i class="fa fa-check-square"></i> Tambah Data Absen Satpam
                        </div>
                        <div class="navigation-buttons text-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bars"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <li><a href="<?= base_url('users/edit_absen_tambah_manual'); ?>"><i class="fa fa-check-square"></i> Tambah Absen</a></li>
                                <li><a href="<?= base_url('users/edit_absen_manual'); ?>"><i class="fa fa-calendar"></i> Data Absen Satpam</a></li>
                            </ul>
                        </div>
                    </div>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                    <fieldset class="content-group">
                        <!-- Form tambah data absen -->
                        <form id="myForm" action="<?= base_url('users/simpan_absen_manual'); ?>" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                <div class="form-group">
                                        <label for="tgl">Tanggal:</label>
                                        <input type="date" class="form-control" id="tgl" name="tgl" value="<?= date('Y-m-d'); ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_lengkap">Nama Lengkap:</label>
                                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?= $nama_lengkap; ?>" readonly>
                                    </div>

                                    <!-- Input tersembunyi untuk ID User -->
                                    <input type="hidden" id="id_user" name="id_user" value="<?= $id_user; ?>">
                                    <input type="hidden" id="latitude" name="latitude">
                                    <input type="hidden" id="longitude" name="longitude">

                                    <div class="form-group">
                                        <label for="waktu">Waktu:</label>
                                        <input type="time" class="form-control" id="waktu" name="waktu" value="<?= date('H:i:s'); ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="keterangan">Status:</label>
                                        <select class="form-control status" id="keterangan" name="keterangan">
                                            <option value="Masuk" style="color: green;">Masuk</option>
                                            <option value="Pulang" style="color: orange; ">Pulang</option>
                                            <option value="Izin" style="color: red; ">Izin</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <div class="dropzone" id="myDropzone">
                                            <div class="dz-message">
                                                <i class="fas fa-camera-retro" id="cameraIcon" name="cameraIcon" onclick="captureImage()"></i>
                                            </div>
                                        </div>
                                        <span class="required">*Foto wajib diisi</span>
                                    </div>

                                    <div class="form-group">
                                        <label for="keterangan_absen">Keterangan:</label>
                                        <textarea class="form-control" id="keterangan_absen" name="keterangan_absen" placeholder="Masukkan Keterangan Absen"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <!-- <a href="users/check_absen" class="btn btn-default"><< Kembali</a> -->
                                            <button type="submit" id="submit_compressed" class="btn btn-danger" style="float:right;">Simpan</button>
                                </div>
                            </div>
                        </form>

                    </fieldset>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
    $('.msg').html('');
    Dropzone.options.myDropzone = {
        // Prevents Dropzone from uploading dropped files immediately
        url: "<?php echo base_url('users/simpan_absen_manual') ?>",
        paramName: "foto_absen",
        acceptedFiles:"image/jpg,image/jpeg,image/bmp",
        autoProcessQueue: false,
        maxFilesize: 10, //MB
        parallelUploads: 1,
        maxFiles: 1,
        addRemoveLinks: true,
        dictCancelUploadConfirmation: "Yakin ingin membatalkan upload ini?",
        dictInvalidFileType: "Type file ini tidak dizinkan",
        dictFileTooBig: "File yang Anda Upload terlalu besar {{filesize}} MB. Maksimal Upload {{maxFilesize}} MB",
        dictRemoveFile: "Hapus",
        renameFile: function(file) {
            var now = new Date();
            var timestamp = now.getTime(); // Gunakan timestamp sebagai nama file
            var randomNum = Math.floor(Math.random() * 1000); // Angka acak antara 0 dan 999
            var fileExtension = file.name.split('.').pop(); // Dapatkan ekstensi file

            // Gabungkan timestamp, angka acak, dan ekstensi file untuk mendapatkan nama file yang unik
            var fileName = timestamp + '-' + randomNum + '.' + fileExtension;

            return fileName;
        },


        init: function() {
            myDropzone = this; // closure
            var submitButton = document.querySelector("#submit_compressed")

            submitButton.addEventListener("click", function(e) {
                e.preventDefault();

                var keterangan_absen = $('#keterangan_absen').val();

                if (keterangan_absen === '') {
                    // Jika ada input yang kosong, tampilkan pesan kesalahan dengan Sweet Alert
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Mohon isi keterangan absen sebelum menyimpan.',
                        confirmButtonColor: '#f44336',
                        confirmButtonText: 'OK'
                    });
                    return; // Berhenti pengiriman formulir
                }

                myDropzone.processQueue(); // Tell Dropzone to process all queued files.
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
                        window.location = "<?php echo base_url(); ?>users/edit_absen_manual";
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

    navigator.geolocation.getCurrentPosition(function(position) {
            $('#latitude').val(position.coords.latitude);
            $('#longitude').val(position.coords.longitude);
        });
</script>
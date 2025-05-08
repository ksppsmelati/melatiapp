<?php
$cek = $user->row();
$inpuser = $cek->id_user;
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
                            <i class="fa fa-plus"></i> Tambah Data Absen
                        </div>

                        <div class="btn-group" style="float: right;">
                            <!-- Tombol Dropdown (di pojok kanan atas) -->
                            <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bars"></i>
                            </button>
                            <!-- Isi Dropdown -->
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <li><a href="<?php echo site_url('users/absen_info'); ?>"><i class="fa fa-television"></i>Info Absen</a></li>
                                <li><a href="<?php echo site_url('users/edit_absen'); ?>"><i class="fa fa-cog"></i> Kelola Absen</a></li>
                                <li><a href="<?php echo site_url('users/rekap_by_date_range'); ?>"><i class="fa fa-history"></i> Rekap Absen</a></li>
                                <li><a href="<?php echo site_url('users/edit_absen_manual_rekap'); ?>"><i class="fa fa-list-alt"></i> Data Absen Manual</a></li>
                                <li><a href="<?php echo site_url('users/rekap_by_date_range_manual'); ?>"><i class="fa fa-calendar"></i> Rekap Absen Manual</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                    <fieldset class="content-group">
                        <!-- Form tambah data absen -->
                        <form id="myForm" action="<?= base_url('users/simpan_absen'); ?>" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <!-- Tambahkan file CSS Select2 -->

                                    <!-- Tambahkan elemen select -->
                                    <div class="form-group">
                                        <label for="nama_lengkap">Nama Lengkap:</label>
                                        <select class="form-control" id="nama_lengkap" name="nama_lengkap">
                                            <option value="">Pilih Nama</option>
                                            <?php foreach ($nama_lengkap as $user) : ?>
                                                <option value="<?= $user['id_user']; ?>" data-sisa-cuti="<?= $user['sisa_cuti']; ?>">
                                                    <?= strtoupper($user['nama_lengkap']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <!-- Form untuk menampilkan sisa cuti berdasarkan pilihan nama -->
                                    <div class="form-group">
                                        <label for="sisa_cuti">Sisa Cuti:</label>
                                        <input type="text" class="form-control" id="sisa_cuti" name="sisa_cuti" readonly>
                                    </div>

                                    <!-- Input tersembunyi untuk ID User -->
                                    <input type="hidden" id="id_user_hidden" name="id_user">
                                    <input type="hidden" id="inpuser" name="inpuser" value="<?php echo $inpuser; ?>" readonly>
                                    <input type="hidden" id="jns_absen" name="jns_absen" value="1" readonly>

                                    <input type="hidden" id="latitude" name="latitude">
                                    <input type="hidden" id="longitude" name="longitude">

                                    <!-- Tambahkan file JavaScript Select2 -->


                                    <div class="form-group">
                                        <label for="tgl">Tanggal:</label>
                                        <input type="date" class="form-control" id="tgl" name="tgl" value="<?= date('Y-m-d'); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="waktu">Waktu:</label>
                                        <input type="text" class="form-control" id="waktu" name="waktu" value="<?= date('H:i:s'); ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="keterangan">Status:</label>
                                        <select class="form-control" id="keterangan" name="keterangan">
                                            <option value="Masuk" style="color: green;">Masuk</option>
                                            <option value="Pulang" style="color: orange; ">Pulang</option>
                                            <option value="Izin" style="color: blue; ">Izin</option>
                                            <option value="Cuti" style="color: grey;">Cuti</option>
                                            <option value="Sakit" style="color: red; ">Sakit</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <div class="dropzone" id="myDropzone">
                                            <div class="dz-message">
                                                <i class="fas fa-camera-retro" id="cameraIcon" name="cameraIcon" onclick="captureImage()"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="keterangan_absen">Keterangan:</label>
                                        <textarea class="form-control" id="keterangan_absen" name="keterangan_absen" placeholder="Masukkan Keterangan Absen"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <a href="users/rekap_by_date_range" class="btn btn-default">
                                        << Kembali</a>
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
    $(document).ready(function() {
        // Inisialisasi Select2 pada elemen select
        $('#nama_lengkap').select2({
            placeholder: 'Pilih Nama Lengkap',
            allowClear: true // Menampilkan tombol untuk menghapus pilihan
        });

        // Ketika pengguna memilih nama lengkap, isi input ID User tersembunyi
        $('#nama_lengkap').on('change', function() {
            var selectedUserId = $(this).val(); // Ambil nilai id_user dari opsi yang dipilih
            $('#id_user_hidden').val(selectedUserId); // Isi nilai id_user_hidden dengan nilai id_user yang dipilih
        });
    });
</script>

<script>
    $('.msg').html('');
    Dropzone.options.myDropzone = {
        // Prevents Dropzone from uploading dropped files immediately
        url: "<?php echo base_url('users/simpan_absen') ?>",
        paramName: "lampiran",
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
                        window.location = "<?php echo base_url(); ?>users/edit_absen_tambah";
                    }
                });
            });
        }

    };

    function submitFormWithoutFile() {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('users/simpan_absen'); ?>",
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
                        window.location = "<?php echo base_url(); ?>users/edit_absen_tambah";
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

    navigator.geolocation.getCurrentPosition(function(position) {
        $('#latitude').val(position.coords.latitude);
        $('#longitude').val(position.coords.longitude);
    });

    $(document).ready(function() {
        $('#nama_lengkap').on('change', function() {
            var selectedOption = $(this).find('option:selected');
            var sisaCuti = selectedOption.data('sisa-cuti');

            // Tampilkan sisa cuti pada input
            $('#sisa_cuti').val(sisaCuti);
        });
    });
</script>
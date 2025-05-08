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
<!-- Tambahkan CSS Summernote -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.css" rel="stylesheet">

<!-- Tambahkan script Summernote dan jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<div class="container">
    <!-- Content area -->
    <div class="content">
        <?php echo $this->session->flashdata('msg'); ?>
        <!-- Laporan Kerja content -->
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="navigation-buttons">
                        <div class="btn-group" style="float: left;">
                            <i class="fa fa-briefcase"></i> Tambah Laporan Kerja
                        </div>

                        <div class="btn-group" style="float: right;">
                            <!-- Tombol Dropdown (di pojok kanan atas) -->
                            <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bars"></i>
                            </button>
                            <!-- Isi Dropdown -->
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <li><a href="<?php echo site_url('users/laporan_kerja'); ?>"><i class="fa fa-plus"></i> Tambah Laporan Kerja</a></li>
                                <li><a href="<?php echo site_url('users/data_laporan_kerja'); ?>"><i class="fa fa-file"></i> Data Laporan Kerja</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Membersihkan float -->
                    <div class="clearfix"></div>
                    <br>
                    <!-- <legend class="text-bold"><i class="fa fa-briefcase"></i> Tambah Laporan Kerja</legend> -->

                    <!-- Form untuk melaporkan pekerjaan -->
                    <form id="myForm" action="<?php echo site_url('users/submit_laporan'); ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group" style="display: none;">
                            <label for="id_user">ID User:</label>
                            <input type="text" class="form-control" name="id_user" id="id_user" value="<?php echo isset($_SESSION['id_user']) ? $_SESSION['id_user'] : ''; ?>" readonly>
                        </div>

                        <div class="form-group">
                            <!-- <label for="tanggal">Tanggal:</label> -->
                            <input type="date" class="form-control" name="tanggal" id="tanggal" required>
                        </div>

                        <div class="form-group" style="display: none;">
                            <label for="jam">Jam:</label>
                            <input type="time" class="form-control" name="jam" id="jam" required readonly>
                        </div>
                        <div class="form-group">
                            <div class="dropzone" id="myDropzone" style="display: none;">
                                <div class="dz-message">
                                    <i class="fas fa-camera-retro" id="cameraIcon" name="cameraIcon" onclick="captureImage()"></i>
                                    <p class="upload-text">Ambil Foto</p>
                                </div>
                            </div>
                            <button id="toggleDropzone" class="btn btn-secondary">
                                + <i class="fa fa-camera" aria-hidden="true"></i>
                            </button>
                        </div>

                        <div class="form-group">
                            <label for="pekerjaan">Pekerjaan:</label>
                            <textarea class="form-control" name="pekerjaan" id="pekerjaan" rows="4" required></textarea>
                        </div>
                        <div class="form-group">
                            <input type="submit" id="submit_compressed" class="btn btn-danger" style="float:right;" value="Simpan">
                        </div>
                    </form>
                    <!-- /Form untuk melaporkan pekerjaan -->

                </div>
            </div>
        </div>
        <!-- /Laporan Kerja content -->
    </div>
    <!-- /content area -->
</div>
<!-- /main content -->

<link rel="stylesheet" type="text/css" href="assets/upload/dropzone.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.css">

<script src="assets/js/jquery-ui.js"></script>
<script type="text/javascript" src="assets/js/core/app.js"></script>
<script type="text/javascript" src="assets/upload/dropzone.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.js"></script>


<script>
    // Fungsi untuk mengisi tanggal awal sebagai tanggal hari berlangsung
    function setDefaultDate() {
        const currentDate = new Date();
        const year = currentDate.getFullYear();
        const month = (currentDate.getMonth() + 1).toString().padStart(2, '0');
        const day = currentDate.getDate().toString().padStart(2, '0');
        const formattedDate = `${year}-${month}-${day}`;
        document.getElementById("tanggal").value = formattedDate;
    }

    // Fungsi untuk mengisi jam awal sebagai jam saat halaman dimuat
    function setDefaultTime() {
        const currentDate = new Date();
        const hours = currentDate.getHours().toString().padStart(2, '0');
        const minutes = currentDate.getMinutes().toString().padStart(2, '0');
        const formattedTime = `${hours}:${minutes}`;
        document.getElementById("jam").value = formattedTime;
    }

    // Panggil fungsi setDefaultDate dan setDefaultTime saat dokumen siap
    document.addEventListener("DOMContentLoaded", function() {
        setDefaultDate();
        setDefaultTime();
    });


    $(document).ready(function() {
        // Inisialisasi Summernote pada textarea dengan nama "pekerjaan"
        $('#pekerjaan').summernote({
            height: '50vh',
        });
    });
</script>

<script>
    $('.msg').html('');
    Dropzone.options.myDropzone = {
        url: "<?php echo base_url('users/submit_laporan') ?>",
        paramName: "foto_pekerjaan",
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

                var pekerjaan = $('#pekerjaan').val();

                if (pekerjaan === '') {
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
                        window.location = "<?php echo base_url(); ?>users/data_laporan_kerja";
                    }
                });
            });
        }

    };

    function submitFormWithoutFile() {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('users/submit_laporan'); ?>",
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
                        window.location = "<?php echo base_url(); ?>users/data_laporan_kerja";
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

    document.getElementById('toggleDropzone').addEventListener('click', function() {
        var dropzone = document.getElementById('myDropzone');
        // Toggle visibility of dropzone
        if (dropzone.style.display === 'none') {
            dropzone.style.display = 'block';
        } else {
            dropzone.style.display = 'none';
        }
    });
</script>
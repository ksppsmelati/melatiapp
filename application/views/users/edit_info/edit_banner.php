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

<!-- Tambahkan script Summernote dan jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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
                            <i class="fa fa-briefcase"></i> Edit Banner
                        </div>

                    </div>
                    <!-- Membersihkan float -->
                    <div class="clearfix"></div>
                    <br>
                    <!-- <legend class="text-bold"><i class="fa fa-briefcase"></i> Tambah Laporan Kerja</legend> -->

                    <!-- Form untuk melaporkan pekerjaan -->
                    <form id="myForm" action="<?php echo site_url('users/submit_banner'); ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <div class="dropzone" id="myDropzone">
                                <div class="dz-message">
                                    <i class="fas fa-camera-retro" id="cameraIcon" name="cameraIcon" onclick="captureImage()"></i>
                                    <p class="upload-text">Ambil Foto Banner</p>
                                </div>
                            </div>
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
    $('.msg').html('');
    Dropzone.options.myDropzone = {
        url: "<?php echo base_url('users/submit_banner') ?>",
        paramName: "foto_banner",
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
                        window.location = "<?php echo base_url(); ?>users/";
                    }
                });
            });
        }

    };

    function submitFormWithoutFile() {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('users/submit_banner'); ?>",
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
                        window.location = "<?php echo base_url(); ?>users/";
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
</script>
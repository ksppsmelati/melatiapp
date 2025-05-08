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
<!-- Main content -->
<div class="container">
    <!-- Content area -->
    <div class="content">
        <?php echo $this->session->flashdata('msg'); ?>

        <!-- Form tambah data kerusakan -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-flat">
                    <div class="panel-body">
                        <div class="navigation-buttons">
                            <i class="fa fa-warning"></i> Tambah Data Kerusakan

                            <div class="btn-group" style="float: right;">
                                <!-- Tombol Dropdown (di pojok kanan atas) -->
                                <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-bars"></i>
                                </button>
                                <!-- Isi Dropdown -->
                                <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                    <li><a href="<?php echo site_url('users/kerusakan/data_kerusakan'); ?>"><i class="fa fa-file"></i> Data Kerusakan</a></li>
                                    <li><a href="<?php echo site_url('users/kerusakan/data_kerusakan_respond'); ?>"><i class="fa fa-reply-all"></i> Data Respond</a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- Membersihkan float -->
                        <div class="clearfix"></div>
                        <form id="myForm" action="<?php echo site_url('users/simpan_kerusakan'); ?>" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="tanggal">Tanggal:</label>
                                <input type="date" class="form-control" name="tanggal" id="tanggal" required readonly="">
                            </div>
                            <div class="form-group" style="display: none;">
                                <label for="petugas">Petugas:</label>
                                <input type="text" class="form-control" name="petugas" id="petugas" value="<?php echo $this->session->userdata('username'); ?>" required readonly="">
                            </div>
                            <div class="form-group">
                                <label for="kantor">Kantor:</label>
                                <select class="form-control" name="kantor" id="kantor" required>
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
                            <div class="form-group">
                                <label for="kerusakan">Keterangan Kerusakan:</label>
                                <textarea class="form-control" name="kerusakan" id="kerusakan" rows="4" placeholder="Masukkan keterangan kerusakan di sini" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>Foto Kerusakan:</label>
                                <div class="dropzone" id="myDropzone">
                                    <div class="dz-message">
                                        <i class="fas fa-camera-retro" id="cameraIcon" name="cameraIcon" onclick="captureImage()"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" style="display:none">
                                <label for="tindakan">Tindakan:</label>
                                <textarea class="form-control" name="tindakan" id="tindakan" rows="4"></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" id="submit_compressed" class="btn btn-danger" style="float:right;">Kirim</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
    // Fungsi untuk mengatur tanggal default dan mengisi otomatis kolom "Petugas" dari session
    function setDefaultDateAndPetugas() {
        // Mengatur tanggal default
        var today = new Date();
        var year = today.getFullYear();
        var month = String(today.getMonth() + 1).padStart(2, '0'); // Tambahkan 1 karena bulan dimulai dari 0
        var day = String(today.getDate()).padStart(2, '0');
        var formattedDate = year + '-' + month + '-' + day;
        document.getElementById('tanggal').value = formattedDate;

        // Mengisi otomatis kolom "Petugas" dari session
        var petugas = '<?php echo $this->session->userdata('username'); ?>';
        document.getElementById('petugas').value = petugas;
    }

    // Panggil fungsi setDefaultDateAndPetugas() saat halaman dimuat
    window.onload = setDefaultDateAndPetugas;
</script>

<script>
    $('.msg').html('');
    Dropzone.options.myDropzone = {
        // Prevents Dropzone from uploading dropped files immediately
        url: "<?php echo base_url('users/simpan_kerusakan') ?>",
        paramName: "foto_kerusakan",
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
                        window.location = "<?php echo base_url(); ?>users/data_kerusakan";
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
</script>
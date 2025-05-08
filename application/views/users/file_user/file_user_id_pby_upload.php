<?php
$cek = $user->row();
$nama_lengkap = $cek->nama_lengkap;
?>

<style>
    @keyframes fadeInOut {

        0%,
        100% {
            opacity: 0;
        }

        50% {
            opacity: 1;
        }
    }

    .status-animation {
        animation: fadeInOut 1s ease-in-out infinite;
    }

    label {
        font-weight: bold;
    }

    .custom-file-upload {
        position: relative;
        margin-bottom: 20px;
    }

    .file-upload-wrapper {
        position: relative;
        display: inline-block;
        width: 100%;
    }

    .file-label {
        background-color: #f1f1f1;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        width: 100%;
        text-align: center;
        cursor: pointer;
        font-weight: bold;
        display: block;
        color: #333;
        transition: background-color 0.3s ease;
    }

    .file-label:hover {
        background-color: #e2e6ea;
    }

    .file-label i {
        margin-right: 8px;
        color: #ff5733;
    }

    .file-input {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }

    #file_size {
        margin-top: 10px;
        font-size: 14px;
        color: #888;
    }
</style>

<div class="container">
    <!-- Content area -->
    <div class="content">
        <?php echo $this->session->flashdata('msg'); ?>

        <div class="row">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="navigation-buttons">
                        <div class="btn-group" style="float: left;">
                            <i class="fa fa-upload"></i> Upload SLIK - <strong><?php echo 'PBY' . $id_pby; ?></strong> | <span style="font-size: 80%; opacity: 0.7;"> <?php echo $nama; ?></span>
                        </div>

                        <div class="btn-group" style="float: right;">
                            <!-- Tombol Dropdown (di pojok kanan atas) -->
                            <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bars"></i>
                            </button>
                            <!-- Isi Dropdown -->
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <!-- <li><a href="<?php echo site_url('users/file_user_upload'); ?>"><i class="fa fa-upload"></i> Upload</a></li> -->
                                <li><a href="<?php echo site_url('users/file_user_categories'); ?>"><i class="fa fa-file"></i> File User Data</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Membersihkan float -->
                    <div class="clearfix"></div>
                    <br>

                    <form id="myForm" action="<?php echo site_url('users/file_user_submit_slik'); ?>" method="post" enctype="multipart/form-data">

                        <div class="form-group">
                            <progress id="progressBar" value="0" max="100" style="width: 100%; display: none;"></progress>
                            <p id="status"></p>
                        </div>

                        <div class="col-xs-12 col-sm-12">
                            <div class="form-group custom-file-upload">
                                <label for="file_upload">Pilih File:</label>
                                <div class="file-upload-wrapper">
                                    <label class="file-label" id="fileLabel" for="file_upload">
                                        <i class="fa fa-upload"></i> Pilih File
                                    </label>
                                    <input type="file" class="form-control file-input" name="file_upload" id="file_upload" required accept=".pdf, image/*">
                                </div>
                                <p id="file_size"></p>
                            </div>
                        </div>
                        <input type="hidden" class="form-control" name="id_pby" id="id_pby" value="<?php echo $id_pby; ?>" required readonly>
                        <input type="hidden" class="form-control" name="nama" id="nama" value="<?php echo $nama; ?>" required readonly>
                        <div class="col-xs-6 col-sm-6" style="display: none;">
                            <div class="form-group">
                                <label for="category">Kategori:</label>
                                <input type="text" class="form-control" name="category" id="category" value="SLIK" readonly>
                            </div>
                        </div>

                        <div class="form-group" style="display: none;">
                            <label for="folder">Folder:</label>
                            <input type="text" class="form-control" name="folder" id="folder" placeholder="Masukkan nama folder">
                        </div>

                        <div class="col-xs-6 col-sm-6" style="display: none;">
                            <div class="form-group">
                                <label for="tahun">Tahun:</label>
                                <input type="number" class="form-control" name="tahun" id="tahun" value="<?php echo date('Y'); ?>" required readonly>
                            </div>
                        </div>

                        <div class="col-xs-6 col-sm-6" style="display: none;">
                            <div class="form-group">
                                <label for="download_status">Download:</label>
                                <input type="number" class="form-control" name="download_status" id="download_status" value="0">
                            </div>
                        </div>

                        <div class="col-xs-6 col-sm-6" style="display: none;">
                            <div class="form-group">
                                <label for="uploaded_at">Tanggal:</label>
                                <input type="date" class="form-control" name="uploaded_at" id="uploaded_at" value="<?php echo date('Y-m-d'); ?>" required readonly>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6" style="display: none;">
                            <div class="form-group">
                                <label for="uploaded_by">User Upload:</label>
                                <input type="text" class="form-control" name="uploaded_by" id="uploaded_by" value="<?php echo $nama_lengkap; ?>" required readonly>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12">
                            <div class="form-group">
                                <label for="description">Deskripsi:</label>
                                <textarea class="form-control" name="description" id="description" placeholder="Masukkan deskripsi file" rows="4"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <input type="submit" class="btn btn-danger" style="float:right;" value="Upload">
                        </div>
                    </form>

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
    // Function to display the size of the selected file
    document.getElementById("file_upload").addEventListener("change", function() {
        const fileInput = this;
        const fileSize = fileInput.files[0].size / 1024 / 1024; // Size in MB
        const fileSizeElement = document.getElementById("file_size");
        fileSizeElement.textContent = "Ukuran File: " + fileSize.toFixed(2) + " MB";
    });

    document.getElementById("file_upload").addEventListener("change", function() {
        const fileInput = this;
        const fileLabel = document.getElementById("fileLabel");
        const fileSizeElement = document.getElementById("file_size");

        // Get the selected file
        const file = fileInput.files[0];

        if (file) {
            // Display the file name on the label
            fileLabel.textContent = file.name;

            // Optional: Display file size
            const fileSize = file.size / 1024 / 1024; // Size in MB
            fileSizeElement.textContent = "Ukuran File: " + fileSize.toFixed(2) + " MB";
        } else {
            // Reset the label if no file is selected
            fileLabel.innerHTML = '<i class="fa fa-upload"></i> Pilih File';
            fileSizeElement.textContent = "";
        }
    });
</script>
<?php
$cek = $user->row();
$id_user = $cek->id_user;
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
        animation: fadeInOut 2s ease-in-out infinite;
    }

    label {
        font-weight: bold;
    }

    /* .custom-file-upload {
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
    } */

    /* #file_size {
        margin-top: 10px;
        font-size: 14px;
        color: #888;
    } */
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
                            <i class="fa fa-upload"></i> Upload Surat Kuasa
                        </div>
                    </div>
                    <!-- Membersihkan float -->
                    <div class="clearfix"></div>
                    <br>

                    <form id="myForm" action="<?php echo site_url('users/file_user_surat_kuasa_submit'); ?>" method="post" enctype="multipart/form-data">

                        <div class="form-group">
                            <progress id="progressBar" value="0" max="100" style="width: 100%; display: none;"></progress>
                            <p id="status"></p>
                        </div>
                        <input type="hidden" class="form-control" name="id_user" id="id_user" value="<?php echo $id_user; ?>" required readonly>
                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group custom-file-upload">
                                <label for="file_upload">Pilih File:</label>
                                <input type="file" class="form-control file-input" name="file_upload" id="file_upload" required accept=".pdf, image/*" onchange="updateFileName()">
                                <p id="file_size"></p>
                            </div>
                        </div>

                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label for="nama">Nama:</label>
                                <input type="text" class="form-control" name="nama" id="nama" placeholder="Masukkan nama" required>
                            </div>
                        </div>

                        <div class="col-xs-6 col-sm-6" style="display: none;">
                            <div class="form-group">
                                <label for="category">Kategori:</label>
                                <input type="text" class="form-control" name="category" id="category" value="surat_kuasa" readonly>
                            </div>
                        </div>

                        <div class="form-group" style="display: none;">
                            <label for="folder">Folder:</label>
                            <input type="text" class="form-control" name="folder" id="folder" placeholder="Masukkan nama folder">
                        </div>

                        <div class="col-xs-6 col-sm-6" style="display: none;">
                            <div class="form-group">
                                <label for="tahun">Tahun:</label>
                                <input type="number" class="form-control" name="tahun" id="tahun" value="<?php echo date('Y'); ?>" placeholder="Masukkan tahun" required readonly>
                            </div>
                        </div>

                        <div class="col-xs-6 col-sm-6" style="display: none;">
                            <div class="form-group">
                                <label for="download_status">Download:</label>
                                <input type="number" class="form-control" name="download_status" id="download_status" value="1" readonly>
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
                                <label for="description">No Rekening:</label>
                                <input type="text" class="form-control" name="description" id="description" placeholder="Masukkan No Rekening">
                            </div>
                        </div>
                        <div class="clearfix"></div>

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
    document.getElementById("myForm").addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent standard form submission

        document.getElementById("progressBar").style.display = "block";

        const categorySelect = document.getElementById('category');
        const newCategoryInput = document.getElementById('new_category');
        let selectedCategory;

        // Determine which category to use
        if (categorySelect.value === "new" && newCategoryInput.value.trim() !== "") {
            selectedCategory = newCategoryInput.value.trim(); // Use the new category input
        } else {
            selectedCategory = categorySelect.value; // Use the selected category
        }

        // Create a new FormData object
        const formData = new FormData(this);
        formData.set('category', selectedCategory); // Update the category value

        const xhr = new XMLHttpRequest();
        xhr.open("POST", this.action, true);

        xhr.upload.addEventListener("progress", function(e) {
            if (e.lengthComputable) {
                const percentComplete = (e.loaded / e.total) * 100;
                const statusElement = document.getElementById("status");

                statusElement.textContent = Math.round(percentComplete) + "% proses...";
                statusElement.classList.add("status-animation"); // Add animation class

                document.getElementById("progressBar").value = percentComplete;
                document.getElementById("progressBar").style.display = "block"; // Show progress bar

                // Optionally, remove the animation class after a brief delay
                setTimeout(function() {
                    statusElement.classList.remove("status-animation");
                }, 1000);
            }
        });

        xhr.addEventListener("load", function() {
            if (xhr.status === 200) {
                document.getElementById("status").textContent = "Upload Complete!";
                const redirectUrl = "<?php echo site_url('users/file_user_surat_kuasa_by_id_user'); ?>";
                window.location.href = redirectUrl;
            } else {
                document.getElementById("status").textContent = "Upload Failed!";
            }
        });

        xhr.send(formData); // Send the form data with AJAX
    });

    // Function to display the size of the selected file
    document.getElementById("file_upload").addEventListener("change", function() {
        const fileInput = this;
        const fileSize = fileInput.files[0].size / 1024 / 1024; // Size in MB
        const fileSizeElement = document.getElementById("file_size");
        fileSizeElement.textContent = "Ukuran File: " + fileSize.toFixed(2) + " MB";
    });

    function toggleNewCategoryInput() {
        const categorySelect = document.getElementById('category');
        const newCategoryInput = document.getElementById('new_category');
        if (categorySelect.value === "new") {
            newCategoryInput.style.display = 'block'; // Show input if "Tambah Kategori Baru" is selected
        } else {
            newCategoryInput.style.display = 'none'; // Hide input for other selections
        }
    }

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

    function updateFileName() {
        var fileInput = document.getElementById('file_upload');
        var fileNameInput = document.getElementById('nama');

        // Jika ada file yang dipilih
        if (fileInput.files.length > 0) {
            var fileName = fileInput.files[0].name;

            // Menghapus ekstensi file (misalnya .pdf, .jpg)
            fileName = fileName.substring(0, fileName.lastIndexOf('.'));

            // Mengatur nilai awal input nama file
            fileNameInput.value = fileName;
        }
    }
</script>
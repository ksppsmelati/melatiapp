    <style>
        label {
            font-weight: bold;
        }

        /* Add margin to the bottom of the input for spacing */
        .form-group {
            margin-bottom: 15px;
        }

        /* Optional: Ensure clearfix to prevent overlap issues */
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }

        .suggestions-box {
            /* border: 1px solid #ccc; */
            background-color: white;
            max-height: 200px;
            overflow-y: auto;
            position: absolute;
            z-index: 1000;
            width: calc(100% - 20px);
            /* Adjust to fit */
            margin-top: -1px;
            /* Align with input */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .suggestion-item {
            padding: 10px;
            cursor: pointer;
        }

        .suggestion-item:hover {
            background-color: #f0f0f0;
        }

        .file-upload-group {
            margin-bottom: 10px;
        }

        .img-preview {
            display: block;
            margin-top: 10px;
            margin-bottom: 10px;
            max-width: 100%;
            height: auto;
            border: 1px solid #ddd;
            border-radius: 4px;
            max-height: 100px;
            transition: all 0.3s ease;
        }

        .preview-container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        input[type="file"] {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px;
            background-color: #f9f9f9;
            transition: border 0.3s ease;
        }

        input[type="file"]:focus {
            border-color: #007bff;
            outline: none;
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
    </style>

    <!-- Main content -->
    <div class="container">
        <!-- Content area -->
        <div class="content">
            <?php echo $this->session->flashdata('msg'); ?>
            <!-- Edit Survey Form -->
            <div class="row">
                <div class="panel panel-flat">
                    <div class="panel-body">
                        <div class="navigation-buttons">
                            <i class="fa fa-poll"></i> Cek BI Edit <br>
                            <span style="font-size: 80%; opacity: 0.7;"><?php echo date('Y-m-d', strtotime($cek_bi_data->tanggal)); ?></span>
                            <span style="font-size: 80%; opacity: 0.7;"> | <?php echo $this->Cek_bi_model->getUsernameById($cek_bi_data->id_user); ?></span>
                            <div class="btn-group" style="float: right;">
                                <!-- Tombol Dropdown (di pojok kanan atas) -->
                                <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-bars"></i>
                                </button>
                                <!-- Isi Dropdown -->
                                <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                    <li><a href="users/cek_bi_tambah"><i class="fa fa-plus"></i> Tambah Usulan</a>
                                    </li>
                                    <li><a href="users/cek_bi_data"><i class="fa fa-file-text"></i> Data Usulan</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- Membersihkan float -->
                        <div class="clearfix"></div>
                        <hr>
                        <div class="card-body">
                            <form method="post" enctype="multipart/form-data" action="<?= base_url('users/cek_bi_update/' . $cek_bi_data->id); ?>" id="myForm">
                                <input type="hidden" name="id" id="id" class="form-control" required value="<?= $cek_bi_data->id; ?>">
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="nama">Nama Pemohon<span style="color: red;">*</span></label>
                                        <input type="text" name="nama" id="nama" class="form-control" required value="<?= $cek_bi_data->nama; ?>" placeholder="Masukan nama pemohon" oninput="this.value = this.value.toUpperCase();">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="nik">NIK<span style="color: red;">*</span></label>
                                        <input type="text" name="nik" id="nik" class="form-control" required value="<?= $cek_bi_data->nik; ?>" placeholder="Masukan NIK">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="tgl_lahir">Tanggal Lahir<span style="color: red;">*</span></label>
                                        <input type="date" name="tgl_lahir" id="tgl_lahir" class="form-control" required value="<?= isset($cek_bi_data->tgl_lahir) ? $cek_bi_data->tgl_lahir : ''; ?>" placeholder="Masukan Tanggal Lahir">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="tempat_lahir">Tempat Lahir<span style="color: red;">*</span></label>
                                        <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" required value="<?= $cek_bi_data->tempat_lahir; ?>" placeholder="Masukan Tempat Lahir" oninput="this.value = this.value.toUpperCase();">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="jk">Jenis Kelamin<span style="color: red;">*</span></label>
                                        <select name="jk" id="jk" class="form-control" required>
                                            <option value="L" <?= ($cek_bi_data->jk == 'L') ? 'selected' : ''; ?>>Laki-laki</option>
                                            <option value="P" <?= ($cek_bi_data->jk == 'P') ? 'selected' : ''; ?>>Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="foto_ktp">Foto KTP<span style="color: red;">*</span></label>

                                        <?php
                                        // Cek apakah foto_ktp sudah ada
                                        $foto_ktp = isset($cek_bi_data->foto_ktp) ? $cek_bi_data->foto_ktp : '';
                                        $thumbnailURL = './foto/foto_cek_bi/foto_ktp/' . $foto_ktp;

                                        // Jika foto KTP ada dan file tersebut ada di server, tampilkan foto
                                        if (!empty($foto_ktp) && file_exists($thumbnailURL)) {
                                        ?>
                                            <div class="mt-2">
                                                <!-- Thumbnail yang bisa diklik untuk popup -->
                                                <a href="javascript:void(0);" onclick="openPopup('<?php echo $thumbnailURL; ?>');">
                                                    <img src="<?php echo $thumbnailURL; ?>" alt="Thumbnail KTP" class="img-preview">
                                                </a>
                                            </div>
                                        <?php
                                        }
                                        ?>

                                        <!-- Input file selalu tampil untuk mengganti foto -->
                                        <input type="file" name="foto_ktp" id="foto_ktp" class="form-control" accept="image/*" onchange="previewImage(event, 'fotoKTPPreview')">
                                        <div class="mt-2">
                                            <!-- Area untuk preview foto baru -->
                                            <img class="img-preview" id="fotoKTPPreview" alt="Preview KTP" style="display:none;" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="alamat">Alamat Rumah<span style="color: red;">*</span></label>
                                        <input type="text" name="alamat" id="alamat" class="form-control" required value="<?= $cek_bi_data->alamat; ?>" placeholder="Masukan alamat rumah" oninput="this.value = this.value.toUpperCase();">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="nama_ibu">Nama Ibu</label>
                                        <input type="text" name="nama_ibu" id="nama_ibu" class="form-control" required value="<?= $cek_bi_data->nama_ibu; ?>" placeholder="Masukan nama ibu" oninput="this.value = this.value.toUpperCase();">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="telepon">Telepon<span style="color: red;">*</span></label>
                                        <input type="text" name="telepon" id="telepon" class="form-control" required value="<?= $cek_bi_data->telepon; ?>">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="pekerjaan">Pekerjaan<span style="color: red;">*</span></label>
                                        <input type="text" name="pekerjaan" id="pekerjaan" class="form-control" required value="<?= $cek_bi_data->pekerjaan; ?>" placeholder="Masukan pekerjaan sesuai KTP" oninput="this.value = this.value.toUpperCase();">
                                    </div>
                                </div>

                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group" style="float: left;">
                                        <label for="cek_req">Persetujuan BI Checking<span style="color: red;">*</span></label>
                                        <select class="form-control" id="cek_req" name="cek_req" required>
                                            <option value="">Pilih</option>
                                            <option value="1" <?= $cek_bi_data->cek_req == '1' ? 'selected' : ''; ?>>Ya, Setuju</option>
                                            <option value="0" <?= $cek_bi_data->cek_req == '0' ? 'selected' : ''; ?>>Tidak / Nanti</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group" style="float: right;">
                                        <label for="ttd">Tanda Tangan</label>
                                        <?php
                                        // Check if the signature exists in the database
                                        $ttd = isset($cek_bi_data->ttd) ? $cek_bi_data->ttd : '';
                                        $thumbnailURL = './foto/foto_cek_bi/foto_ttd/' . $ttd;

                                        if (!empty($ttd) && file_exists($thumbnailURL)) {
                                        ?>
                                            <div class="mt-2">
                                                <!-- Display the image if it exists -->
                                                <a href="javascript:void(0);" onclick="openPopup('<?php echo $thumbnailURL; ?>');">
                                                    <img src="<?php echo $thumbnailURL; ?>" alt="Thumbnail Tanda Tangan" class="img-preview">
                                                </a>
                                            </div>
                                        <?php
                                        } else {
                                            // If no signature is available, display a message or placeholder
                                            echo '<p style="color: red;">No signature available.</p>';
                                        }
                                        ?>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12" id="signatureSection" style="display: <?= !empty($cek_bi_data->ttd) ? 'block' : 'none'; ?>;">
                                    <div class="signature-container" style="text-align: center;">
                                        <canvas id="signature-pad" width="300" height="200" style="border: 1px solid #000; border-radius: 10px;"></canvas>
                                        <br>
                                        <p><small>Tanda tangan anggota untuk persetujuan BI Checking.</small></p>
                                        <button type="button" id="clear" class="btn btn-muted mt-2">Hapus</button>
                                    </div>
                                    <input type="hidden" name="ttd" id="ttd">
                                </div>
                                <div class="clearfix"></div>
                                <!-- Tambahkan kolom lainnya sesuai dengan data survei -->
                                <button type="submit" class="btn btn-danger" id="kirimButton" style="float:right;"> Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Tambahkan pustaka Leaflet dan Leaflet Control Geocoder -->
        </div>
        <!-- /Edit Survey Form -->
    </div>
    <!-- /content area -->
    </div>
    <!-- /main content -->
    <script src="https://cdn.jsdelivr.net/npm/compressorjs@1.0.7/dist/compressor.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.umd.min.js"></script>

    <script>
        document.querySelectorAll('input[type="file"]').forEach(function(input) {
            input.addEventListener('change', function(event) {
                const file = event.target.files[0];

                if (file) {
                    // Gunakan Compressor.js untuk melakukan kompresi
                    new Compressor(file, {
                        quality: 0.3, // Menyesuaikan kualitas kompresi (0 - 1)
                        success(result) {
                            // Membuat nama file unik dengan menggabungkan timestamp dan nama input
                            const inputName = input.getAttribute('name');
                            const timestamp = Date.now();
                            const fileExtension = file.name.split('.').pop(); // Ekstensi file asli
                            const uniqueFileName = inputName + '_' + timestamp + '.' + fileExtension; // Nama file unik

                            const compressedFile = new File([result], uniqueFileName, {
                                type: result.type,
                                lastModified: timestamp
                            });

                            // Gantikan file input dengan file yang sudah dikompres
                            const dataTransfer = new DataTransfer();
                            dataTransfer.items.add(compressedFile);
                            input.files = dataTransfer.files; // Mengganti file di input

                            console.log('File berhasil dikompres dengan nama unik:', compressedFile);
                        },
                        error(err) {
                            console.error('Gagal melakukan kompresi:', err.message);
                        },
                    });
                }
            });
        });

        function previewImage(event, previewId) {
            const file = event.target.files[0];
            const previewElement = document.getElementById(previewId);

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewElement.src = e.target.result; // Set src dari preview ke hasil pembacaan
                    previewElement.style.display = 'block'; // Tampilkan gambar preview
                }
                reader.readAsDataURL(file); // Baca file sebagai Data URL
            } else {
                previewElement.src = ""; // Kosongkan src jika tidak ada file
                previewElement.style.display = 'none'; // Sembunyikan gambar preview
            }
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

        document.addEventListener('DOMContentLoaded', function() {
            const cekReq = document.getElementById('cek_req');
            const signatureSection = document.getElementById('signatureSection');
            const canvas = document.getElementById('signature-pad');
            const clearButton = document.getElementById('clear');
            const ttdInput = document.getElementById('ttd');
            const ctx = canvas.getContext('2d');
            let drawing = false;

            // Fungsi untuk mulai menggambar
            canvas.addEventListener('mousedown', function() {
                drawing = true;
                ctx.beginPath();
            });

            canvas.addEventListener('mouseup', function() {
                drawing = false;
            });

            canvas.addEventListener('mousemove', function(event) {
                if (drawing) {
                    const rect = canvas.getBoundingClientRect();
                    const x = event.clientX - rect.left;
                    const y = event.clientY - rect.top;
                    ctx.lineTo(x, y);
                    ctx.strokeStyle = 'black'; // Tanda tangan hitam
                    ctx.lineWidth = 2;
                    ctx.stroke();
                }
            });

            // Untuk perangkat touch (mobile)
            canvas.addEventListener('touchstart', function() {
                drawing = true;
                ctx.beginPath();
            });

            canvas.addEventListener('touchend', function() {
                drawing = false;
            });

            canvas.addEventListener('touchmove', function(event) {
                const touch = event.touches[0];
                const rect = canvas.getBoundingClientRect();
                const x = touch.clientX - rect.left;
                const y = touch.clientY - rect.top;
                if (drawing) {
                    ctx.lineTo(x, y);
                    ctx.strokeStyle = 'black';
                    ctx.lineWidth = 2;
                    ctx.stroke();
                }
            });

            // Menonaktifkan scroll saat menggambar di canvas (Desktop & Mobile)
            canvas.addEventListener('touchmove', function(event) {
                event.preventDefault(); // Mencegah scroll pada perangkat mobile
            }, {
                passive: false
            });

            // Mencegah scroll dengan mouse (desktop)
            canvas.addEventListener('wheel', function(event) {
                event.preventDefault(); // Mencegah scroll dengan mouse
            }, {
                passive: false
            });

            // Show signature section if "Ya, Setuju" is selected
            cekReq.addEventListener('change', function() {
                if (cekReq.value == '1') {
                    signatureSection.style.display = 'block'; // Tampilkan elemen tanda tangan
                } else {
                    signatureSection.style.display = 'none'; // Sembunyikan elemen tanda tangan
                    ctx.clearRect(0, 0, canvas.width, canvas.height); // Bersihkan canvas
                    ttdInput.value = ''; // Kosongkan input hidden
                }
            });

            // Clear signature pad
            clearButton.addEventListener('click', function() {
                ctx.clearRect(0, 0, canvas.width, canvas.height); // Bersihkan canvas
                ttdInput.value = ''; // Kosongkan input hidden
            });

            // Save signature as base64 but not required
            document.getElementById('myForm').addEventListener('submit', function() {
                // Simpan tanda tangan sebagai base64 jika "Ya, Setuju" dipilih
                if (cekReq.value == '1') {
                    ttdInput.value = canvas.toDataURL('image/png'); // Simpan tanda tangan sebagai base64
                }
            });
        });
    </script>
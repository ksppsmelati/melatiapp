    <style>
        label {
            font-weight: bold;
        }

        /* Style for the map container */
        #map-container {
            width: 100%;
            height: 400px;
            /* Fixed height for the map container */
            position: relative;
            margin-top: 15px;
            /* Space between input and map */
            margin-bottom: 20px;
            /* Space below the map */
        }

        /* Style for the map itself */
        #map {
            width: 100%;
            /* Full width of the container */
            height: 100%;
            /* Full height of the container */
            border-radius: 10px;
        }

        /* Ensure map looks good on mobile devices */
        @media (max-width: 768px) {
            #map-container {
                height: 300px;
                /* Smaller height for mobile devices */
            }
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
            max-height: 50px;
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
                            <i class="fa fa-poll"></i> Usulan Edit <br>
                            <span style="font-size: 80%; opacity: 0.7;"><?php echo date('Y-m-d', strtotime($usulan_data->tanggal)); ?></span>
                            <span style="font-size: 80%; opacity: 0.7;"> | <?php echo $this->Usulan_model->getUsernameById($usulan_data->id_user); ?></span>
                            <div class="btn-group" style="float: right;">
                                <!-- Tombol Dropdown (di pojok kanan atas) -->
                                <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-bars"></i>
                                </button>
                                <!-- Isi Dropdown -->
                                <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                    <li><a href="users/usulan_tambah"><i class="fa fa-plus"></i> Tambah Usulan</a>
                                    </li>
                                    <li><a href="users/usulan_data"><i class="fa fa-file-text"></i> Data Usulan</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- Membersihkan float -->
                        <div class="clearfix"></div>
                        <hr>
                        <div class="card-body">
                            <form method="post" enctype="multipart/form-data" action="<?= base_url('users/update_usulan/' . $usulan_data->id); ?>" id="myForm">
                                <input type="hidden" name="id" id="id" class="form-control" required value="<?= $usulan_data->id; ?>">
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="nama">Nama Pemohon<span style="color: red;">*</span></label>
                                        <input type="text" name="nama" id="nama" class="form-control" required value="<?= $usulan_data->nama; ?>" placeholder="Masukan nama pemohon" oninput="this.value = this.value.toUpperCase();">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="nik">NIK<span style="color: red;">*</span></label>
                                        <input type="text" name="nik" id="nik" class="form-control" required value="<?= $usulan_data->nik; ?>" placeholder="Masukan NIK">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="tgl_lahir">Tanggal Lahir<span style="color: red;">*</span></label>
                                        <input type="date" name="tgl_lahir" id="tgl_lahir" class="form-control" required value="<?= isset($usulan_data->tgl_lahir) ? $usulan_data->tgl_lahir : ''; ?>" placeholder="Masukan Tanggal Lahir">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="tempat_lahir">Tempat Lahir<span style="color: red;">*</span></label>
                                        <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" required value="<?= $usulan_data->tempat_lahir; ?>" placeholder="Masukan Tempat Lahir" oninput="this.value = this.value.toUpperCase();">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="jk">Jenis Kelamin<span style="color: red;">*</span></label>
                                        <select name="jk" id="jk" class="form-control" required>
                                            <option value="L" <?= ($usulan_data->jk == 'L') ? 'selected' : ''; ?>>Laki-laki</option>
                                            <option value="P" <?= ($usulan_data->jk == 'P') ? 'selected' : ''; ?>>Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="foto_ktp">Foto KTP<span style="color: red;">*</span></label>

                                        <?php
                                        // Cek apakah foto_ktp sudah ada
                                        $foto_ktp = isset($usulan_data->foto_ktp) ? $usulan_data->foto_ktp : '';
                                        $thumbnailURL = './foto/foto_usulan/foto_ktp/' . $foto_ktp;

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
                                        <input type="text" name="alamat" id="alamat" class="form-control" required value="<?= $usulan_data->alamat; ?>" placeholder="Masukan alamat rumah" oninput="this.value = this.value.toUpperCase();">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="nama_ibu">Nama Ibu</label>
                                        <input type="text" name="nama_ibu" id="nama_ibu" class="form-control" required value="<?= $usulan_data->nama_ibu; ?>" placeholder="Masukan nama ibu" oninput="this.value = this.value.toUpperCase();">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="telepon">Telepon<span style="color: red;">*</span></label>
                                        <input type="text" name="telepon" id="telepon" class="form-control" required value="<?= $usulan_data->telepon; ?>">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="pekerjaan">Pekerjaan<span style="color: red;">*</span></label>
                                        <input type="text" name="pekerjaan" id="pekerjaan" class="form-control" required value="<?= $usulan_data->pekerjaan; ?>" placeholder="Masukan pekerjaan sesuai KTP" oninput="this.value = this.value.toUpperCase();">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="nominal">Plafon Usulan<span style="color: red;">*</span></label>
                                        <input type="number" name="nominal" id="nominal" class="form-control" required value="<?= $usulan_data->nominal; ?>" placeholder="Masukan besaran nilai pembiayaan">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="tujuan">Penggunaan Dana<span style="color: red;">*</span></label>
                                        <input type="text" name="tujuan" id="tujuan" class="form-control" required value="<?= $usulan_data->tujuan; ?>" oninput="this.value = this.value.toUpperCase();">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="jangka_waktu">Jangka Waktu</label>
                                        <select class="form-control" name="jangka_waktu" id="jangka_waktu">
                                            <option value="" selected disabled>Pilih Jangka Waktu</option>
                                            <option value="3" <?php echo ($usulan_data->jangka_waktu == '3') ? 'selected' : ''; ?>>3 (tempo)</option>
                                            <option value="6" <?php echo ($usulan_data->jangka_waktu == '6') ? 'selected' : ''; ?>>6 (tempo)</option>
                                            <option value="9" <?php echo ($usulan_data->jangka_waktu == '9') ? 'selected' : ''; ?>>9 (tempo)</option>
                                            <option value="12" <?php echo ($usulan_data->jangka_waktu == '12') ? 'selected' : ''; ?>>12 bulan</option>
                                            <option value="18" <?php echo ($usulan_data->jangka_waktu == '18') ? 'selected' : ''; ?>>18 bulan</option>
                                            <option value="24" <?php echo ($usulan_data->jangka_waktu == '24') ? 'selected' : ''; ?>>24 bulan</option>
                                            <option value="36" <?php echo ($usulan_data->jangka_waktu == '36') ? 'selected' : ''; ?>>36 bulan</option>
                                            <option value="42" <?php echo ($usulan_data->jangka_waktu == '42') ? 'selected' : ''; ?>>42 bulan</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- Jaminan Selection -->
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="jaminan">Jenis Jaminan</label>
                                        <select class="form-control" name="jaminan" id="jaminan" required onchange="showSection()">
                                            <option value="" <?= set_select('jaminan', '', empty($usulan_data->jaminan)); ?>>Pilih Jenis jaminan</option>
                                            <option value="sertifikat" <?= set_select('jaminan', 'sertifikat', $usulan_data->jaminan == 'sertifikat'); ?>>Sertifikat (SHM)</option>
                                            <option value="bpkb" <?= set_select('jaminan', 'bpkb', $usulan_data->jaminan == 'bpkb'); ?>>BPKB</option>
                                            <option value="lainnya" <?= set_select('jaminan', 'lainnya', $usulan_data->jaminan == 'lainnya'); ?>>Lainnya</option>
                                        </select>

                                    </div>
                                </div>

                                <!-- Sertifikat Section -->
                                <div id="sertifikat-section" style="display: none;">
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="sertifikat">Nomor Sertifikat</label>
                                            <input type="text" name="sertifikat" id="sertifikat" class="form-control" value="<?= $usulan_data->sertifikat; ?>" placeholder="Masukan nomor sertifikat" value="<?php echo isset($sertifikat) ? $sertifikat : ''; ?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="tgl_pembukuan">Tanggal Pembukuan</label>
                                            <input type="date" name="tgl_pembukuan" id="tgl_pembukuan" class="form-control" value="<?php echo isset($tgl_pembukuan) ? $tgl_pembukuan : date('Y-m-d'); ?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="an_sertifikat">Atas Nama Sertifikat</label>
                                            <input type="text" name="an_sertifikat" id="an_sertifikat" class="form-control" value="<?= $usulan_data->an_sertifikat; ?>" placeholder="Masukan atas nama sertifikat" value="<?php echo isset($an_sertifikat) ? $an_sertifikat : ''; ?>" oninput="this.value = this.value.toUpperCase();">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="luas">Luas Tanah</label>
                                            <div style="position: relative;">
                                                <input type="number" name="luas" id="luas" class="form-control" placeholder="Masukan luas tanah" value="<?= $usulan_data->luas; ?>" style="padding-right: 30px;">
                                                <span style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%);">m²</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="nib">NIB</label>
                                            <input type="text" name="nib" id="nib" class="form-control" placeholder="Masukan NIB" value="<?= $usulan_data->nib; ?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="alamat_lokasi">Kecamatan Letak Tanah</label>
                                            <input type="text" name="alamat_lokasi" id="alamat_lokasi" class="form-control" placeholder="Masukan kecamatan letak tanah" value="<?= $usulan_data->alamat_lokasi; ?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12">
                                        <div class="form-group">
                                            <label for="batas">Batas-batas</label>
                                            <input name="batas" id="batas" class="form-control" placeholder="Contoh: Utara: Desa A, Timur: Sungai X, Selatan: Jalan Y, Barat: Kebun Z" value="<?= $usulan_data->batas; ?>"></input>
                                        </div>
                                    </div>
                                </div>

                                <!-- BPKB Section -->
                                <div id="bpkb-section" style="display: none;">
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="bpkb">Nomor BPKB</label>
                                            <input type="text" name="bpkb" id="bpkb" class="form-control" placeholder="Masukan nomor BPKB" value="<?= $usulan_data->bpkb; ?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="merk">Merk</label>
                                            <input type="text" name="merk" id="merk" class="form-control" placeholder="Masukan merk" value="<?= $usulan_data->merk; ?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="no_pol">Nomor Polisi</label>
                                            <input type="text" name="no_pol" id="no_pol" class="form-control" placeholder="Masukan nomor polisi" value="<?= $usulan_data->no_pol; ?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="no_rangka">Nomor Rangka</label>
                                            <input type="text" name="no_rangka" id="no_rangka" class="form-control" placeholder="Masukan nomor rangka" value="<?= $usulan_data->no_rangka; ?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="no_mesin">Nomor Mesin</label>
                                            <input type="text" name="no_mesin" id="no_mesin" class="form-control" placeholder="Masukan nomor mesin" value="<?= $usulan_data->no_mesin; ?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="thn_pembuatan">Tahun Pembuatan</label>
                                            <input type="number" name="thn_pembuatan" id="thn_pembuatan" class="form-control" placeholder="Masukan tahun pembuatan" value="<?= $usulan_data->thn_pembuatan; ?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="warna">Warna</label>
                                            <input type="text" name="warna" id="warna" class="form-control" placeholder="Masukan warna" value="<?= $usulan_data->warna; ?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="an_bpkb">Atas Nama BPKB</label>
                                            <input type="text" name="an_bpkb" id="an_bpkb" class="form-control" placeholder="Masukan atas nama BPKB" value="<?= $usulan_data->an_bpkb; ?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12">
                                        <div class="form-group">
                                            <label for="alamat_bpkb">Alamat BPKB</label>
                                            <input type="text" name="alamat_bpkb" id="alamat_bpkb" class="form-control" placeholder="Masukan alamat BPKB" value="<?= $usulan_data->alamat_bpkb; ?>">
                                        </div>
                                    </div>
                                </div>

                                <!-- Lainnya Section -->
                                <div id="lainnya-section" style="display: none;">
                                    <div class="col-xs-12 col-sm-12">
                                        <div class="form-group">
                                            <label for="lainnya">Jaminan Lainnya</label>
                                            <input type="text" name="lainnya" id="lainnya" class="form-control" placeholder="Masukan jenis jaminan lainnya" value="<?= $usulan_data->lainnya; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group" style="float: left;">
                                        <label for="status">Status<span style="color: red;">*</span></label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="Aktif" <?= ($usulan_data->status == 'Aktif') ? 'selected' : ''; ?>>Aktif</option>
                                            <option value="Nonaktif" <?= ($usulan_data->status == 'Nonaktif') ? 'selected' : ''; ?>>Nonaktif</option>
                                            <option value="Batal" <?= ($usulan_data->status == 'Batal') ? 'selected' : ''; ?>>Batal</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group" style="float: right;">
                                        <label for="cek_req">Persetujuan BI Checking<span style="color: red;">*</span></label>
                                        <select class="form-control" id="cek_req" name="cek_req" required>
                                            <option value="">Pilih</option>
                                            <option value="1" <?= $usulan_data->cek_req == '1' ? 'selected' : ''; ?>>Ya, Setuju</option>
                                            <option value="0" <?= $usulan_data->cek_req == '0' ? 'selected' : ''; ?>>Tidak / Nanti</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12">
                                    <div class="form-group" style="float: right;">
                                        <label for="ttd">Tanda Tangan</label>
                                        <?php
                                        // Check if the signature exists in the database
                                        $ttd = isset($usulan_data->ttd) ? $usulan_data->ttd : '';
                                        $thumbnailURL = './foto/foto_usulan/foto_ttd/' . $ttd;

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

                                <div class="col-xs-12 col-sm-12" id="signatureSection" style="display: <?= !empty($usulan_data->ttd) ? 'block' : 'none'; ?>;">
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
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/compressorjs@1.0.7/dist/compressor.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.umd.min.js"></script>

    <script>
        // script toggle 
        document.addEventListener('DOMContentLoaded', function() {

            var toggleSelect = document.getElementById('bpkb-sertifikat-toggle');
            var bpkbSection = document.getElementById('bpkb-section');
            var sertifikatSection = document.getElementById('sertifikat-section');
            var lainnyaSection = document.getElementById('lainnya-section');

            toggleSelect.addEventListener('change', function() {
                if (toggleSelect.value === 'bpkb') {
                    bpkbSection.style.display = 'block';
                    sertifikatSection.style.display = 'none';
                    lainnyaSection.style.display = 'none';
                } else if (toggleSelect.value === 'sertifikat') {
                    bpkbSection.style.display = 'none';
                    sertifikatSection.style.display = 'block';
                    lainnyaSection.style.display = 'none';
                } else if (toggleSelect.value === 'lainnya') {
                    bpkbSection.style.display = 'none';
                    sertifikatSection.style.display = 'none';
                    lainnyaSection.style.display = 'block';
                }
            });

            // Initial setup
            toggleSelect.dispatchEvent(new Event('change'));
        });


        // Script untuk peta 
        function initMap() {
            var defaultLocation = [-7.150975, 110.140259]; // Jawa Tengah coordinates
            var map = L.map('map').setView(defaultLocation, 8);

            // Load tile layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {}).addTo(map);

            map.zoomControl.remove();

            // Add custom zoom control to the bottom right
            L.control.zoom({
                position: 'bottomright' // Set zoom control position
            }).addTo(map);

            var marker = L.marker(defaultLocation, {
                draggable: true
            }).addTo(map);

            // Update location input when marker is dragged
            marker.on('dragend', function(event) {
                updateLocationInput(event.target.getLatLng());
            });

            // Update location input when the map is clicked
            map.on('click', function(e) {
                marker.setLatLng(e.latlng);
                updateLocationInput(e.latlng);
            });

            // Update input field with latitude and longitude
            function updateLocationInput(location) {
                document.getElementById('lokasi').value = location.lat + ', ' + location.lng;
            }

            // Custom search functionality
            var searchInput = document.getElementById('search-input');
            var suggestionsBox = document.getElementById('suggestions');

            searchInput.addEventListener('input', function() {
                var query = searchInput.value;
                if (query.length >= 2) {
                    fetch('https://nominatim.openstreetmap.org/search?q=' + encodeURIComponent(query) +
                            '&format=json&addressdetails=1&countrycodes=ID&viewbox=105,-8.5,110.5,-6&bounded=1')
                        .then(response => response.json())
                        .then(data => {
                            suggestionsBox.innerHTML = ''; // Clear previous suggestions
                            data.forEach(result => {
                                const item = document.createElement('div');
                                item.className = 'suggestion-item';
                                item.innerHTML = `<strong>${result.display_name}</strong><br>`;

                                // Click event for selecting a suggestion
                                item.addEventListener('click', function() {
                                    const latLng = [result.lat, result.lon];
                                    map.setView(latLng, 12); // Zoom in closer
                                    marker.setLatLng(latLng); // Move marker
                                    updateLocationInput({
                                        lat: result.lat,
                                        lng: result.lon
                                    });
                                    suggestionsBox.innerHTML = ''; // Clear suggestions
                                });

                                suggestionsBox.appendChild(item);
                            });
                        });
                } else {
                    suggestionsBox.innerHTML = ''; // Clear suggestions if input is less than 2 characters
                }
            });


            // Clear suggestions when clicking outside
            document.addEventListener('click', function(event) {
                if (!searchInput.contains(event.target)) {
                    suggestionsBox.innerHTML = ''; // Clear suggestions
                }
            });
        }

        window.onload = function() {
            initMap();
        };

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

        $(document).ready(function() {
            // Show the section based on the selected value when the page loads
            var selectedOption = $('#jaminan').val();
            showSection(selectedOption);

            // Handle the change event
            $('#jaminan').on('change', function() {
                var selectedValue = $(this).val();
                showSection(selectedValue);
            });

            // Function to show/hide sections based on the selected value
            function showSection(value) {
                $('#sertifikat-section, #bpkb-section, #lainnya-section').hide();

                if (value === 'sertifikat') {
                    $('#sertifikat-section').show();
                } else if (value === 'bpkb') {
                    $('#bpkb-section').show();
                } else if (value === 'lainnya') {
                    $('#lainnya-section').show();
                }
            }
        });

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
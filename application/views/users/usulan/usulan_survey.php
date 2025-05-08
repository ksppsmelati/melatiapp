<?php
$cek = $user->row();
$surveyor = $cek->id_user;
?>
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
                        <i class="fa fa-poll"></i> Form Survey <br>
                        <span style="font-size: 80%; opacity: 0.7;">Tgl Input : <?php echo date('d-m-Y', strtotime($survey_data->tanggal)); ?></span>
                        <span style="font-size: 80%; opacity: 0.7;"> | <?php echo $this->Usulan_model->getUsernameById($survey_data->id_user); ?></span>
                        <!-- <div class="btn-group" style="float: right;">
                            <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bars"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <li><a href="users/usulan_tambah"><i class="fa fa-plus"></i> Tambah Usulan</a>
                                </li>
                                <li><a href="users/usulan_data"><i class="fa fa-file-text"></i> Data Usulan</a>
                                </li>
                            </ul>
                        </div> -->
                    </div>
                    <!-- Membersihkan float -->
                    <div class="clearfix"></div>
                    <hr>
                    <div class="card-body">
                        <form method="post" enctype="multipart/form-data" action="<?= base_url('users/update_survey/' . $survey_data->usulan_id); ?>">
                            <input type="hidden" name="surveyor" value="<?php echo htmlspecialchars($surveyor); ?>" required>
                            <input type="hidden" name="id_pby" id="id_pby" class="form-control" required value="<?= $survey_data->usulan_id; ?>">
                            <input type="hidden" name="kode_kantor" id="kode_kantor" class="form-control" required value="<?= $survey_data->kode_kantor; ?>">
                            <div class="col-xs-6 col-sm-6">
                                <div class="form-group">
                                    <label for="nama">Nama Pemohon<span style="color: red;">*</span></label>
                                    <input type="text" name="nama" id="nama" class="form-control" required readonly value="<?= $survey_data->nama; ?>" placeholder="Masukan nama pemohon" oninput="this.value = this.value.toUpperCase();">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6">
                                <div class="form-group">
                                    <label for="nik">NIK<span style="color: red;">*</span></label>
                                    <input type="text" name="nik" id="nik" class="form-control" required readonly value="<?= $survey_data->nik; ?>" placeholder="Masukan NIK">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6">
                                <div class="form-group">
                                    <label for="tgl_lahir">Tanggal Lahir<span style="color: red;">*</span></label>
                                    <input type="date" name="tgl_lahir" id="tgl_lahir" class="form-control" required readonly value="<?= isset($survey_data->tgl_lahir) ? $survey_data->tgl_lahir : ''; ?>" placeholder="Masukan Tanggal Lahir">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6">
                                <div class="form-group">
                                    <label for="tempat_lahir">Tempat Lahir<span style="color: red;">*</span></label>
                                    <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" required readonly value="<?= $survey_data->tempat_lahir; ?>" placeholder="Masukan Tempat Lahir" oninput="this.value = this.value.toUpperCase();">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6">
                                <div class="form-group">
                                    <label for="foto_ktp">Foto KTP<span style="color: red;">*</span></label>

                                    <?php
                                    // Ambil nama file foto_ktp dari data survey_data
                                    $foto_ktp = isset($survey_data->foto_ktp) ? $survey_data->foto_ktp : '';

                                    // Buat URL lengkap untuk thumbnail
                                    $thumbnailURL = './foto/foto_usulan/foto_ktp/' . $foto_ktp;

                                    // Jika file foto_ktp tidak kosong dan ada di server, tampilkan thumbnail
                                    if (!empty($foto_ktp) && file_exists($thumbnailURL)) {
                                    ?>
                                        <div class="mt-2">
                                            <a href="javascript:void(0);" onclick="openPopup('<?php echo $thumbnailURL; ?>');">
                                                <img src="<?php echo $thumbnailURL; ?>" alt="Thumbnail KTP" class="img-preview">
                                            </a>
                                        </div>
                                    <?php
                                    } else {
                                    ?>
                                        <!-- Jika tidak ada foto, tampilkan input untuk upload dan preview -->
                                        <input type="file" name="foto_ktp" id="foto_ktp" class="form-control" required accept="image/*" onchange="previewImage(event, 'fotoKTPPreview')">
                                        <div class="mt-2">
                                            <img id="fotoKTPPreview" alt="Preview KTP" style="display:none; max-width: 100px;" />
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>

                            <div class="col-xs-6 col-sm-6">
                                <div class="form-group">
                                    <label for="alamat">Alamat Lengkap<span style="color: red;">*</span></label>
                                    <input type="text" name="alamat" id="alamat" class="form-control" required readonly value="<?= $survey_data->alamat; ?> <?= $survey_data->kelurahan_nama; ?> <?= $survey_data->kecamatan_nama; ?> <?= $survey_data->kota_nama; ?>" placeholder="Masukan alamat rumah" oninput="this.value = this.value.toUpperCase();">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6">
                                <div class="form-group">
                                    <label for="nama_ibu">Nama Ibu</label>
                                    <input type="text" name="nama_ibu" id="nama_ibu" class="form-control" required readonly value="<?= $survey_data->nama_ibu; ?>" placeholder="Masukan nama ibu" oninput="this.value = this.value.toUpperCase();">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6">
                                <div class="form-group">
                                    <label for="telepon">Telepon<span style="color: red;">*</span></label>
                                    <input type="text" name="telepon" id="telepon" class="form-control" readonly value="<?= $survey_data->telepon; ?>">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6">
                                <div class="form-group">
                                    <label for="pekerjaan">Pekerjaan<span style="color: red;">*</span></label>
                                    <input type="text" name="pekerjaan" id="pekerjaan" class="form-control" readonly value="<?= $survey_data->pekerjaan; ?>" placeholder="Masukan pekerjaan sesuai KTP" oninput="this.value = this.value.toUpperCase();">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6">
                                <div class="form-group">
                                    <label for="alamat_usaha">Alamat Usaha/Kantor<span style="color: red;">*</span></label>
                                    <input type="text" name="alamat_usaha" id="alamat_usaha" class="form-control" required value="<?= isset($survey_data->alamat_usaha) ? $survey_data->alamat_usaha : ''; ?>" placeholder="Masukan alamat usaha / kantor">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6">
                                <div class="form-group">
                                    <label for="pekerjaan_sampingan">Pekerjaan Sampingan</label>
                                    <input type="text" name="pekerjaan_sampingan" id="pekerjaan_sampingan" class="form-control" value="<?= isset($survey_data->pekerjaan_sampingan) ? $survey_data->pekerjaan_sampingan : ''; ?>" placeholder="Masukan pekerjaan sampingan">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6">
                                <div class="form-group">
                                    <label for="nominal">Plafon Usulan<span style="color: red;">*</span></label>
                                    <input type="text" name="nominal" id="nominal" class="form-control" required readonly value="Rp <?= number_format($survey_data->nominal, 0, ',', '.'); ?>" placeholder="Masukan besaran nilai plafon pembiayaan">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6" style="display: none;">
                                <div class="form-group">
                                    <label for="riwayat_pembiayaan">Riwayat Pembiayaan</label>
                                    <select name="riwayat_pembiayaan" id="riwayat_pembiayaan" class="form-control">
                                        <option value="" selected>Pilih Riwayat Pembiayaan</option>
                                        <option value="lancar" style="color: green;">Lancar</option>
                                        <option value="kurang" style="color: blue;">Kurang</option>
                                        <option value="diragukan" style="color: orange;">Diragukan</option>
                                        <option value="macet" style="color: red;">Macet</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6">
                                <div class="form-group">
                                    <label for="tujuan">Penggunaan Dana</label>
                                    <input type="text" name="tujuan" id="tujuan" class="form-control" readonly value="<?= $survey_data->tujuan; ?>">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6">
                                <div class="form-group">
                                    <label for="bidang_usaha">Bidang Usaha<span style="color: red;">*</span></label>
                                    <input type="text" name="bidang_usaha" id="bidang_usaha" class="form-control" required value="<?= isset($survey_data->bidang_usaha) ? $survey_data->bidang_usaha : ''; ?>" placeholder="Masukan bidang usaha">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6">
                                <div class="form-group">
                                    <label for="sumber_pelunasan">Sumber Pelunasan<span style="color: red;">*</span></label>
                                    <select name="sumber_pelunasan" id="sumber_pelunasan" class="form-control" required>
                                        <option value="" selected>Pilih Sumber Pelunasan</option>
                                        <option value="gaji">Gaji</option>
                                        <option value="hasil_usaha">Hasil Usaha</option>
                                        <option value="lainya">Lainya</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6">
                                <div class="form-group">
                                    <label for="jangka_waktu">Jangka Waktu</label>
                                    <select class="form-control" name="jangka_waktu" id="jangka_waktu" disabled>
                                        <option value="" selected disabled>Pilih Jangka Waktu</option>
                                        <option value="3" <?php echo ($survey_data->jangka_waktu == '3') ? 'selected' : ''; ?>>3 (tempo)</option>
                                        <option value="6" <?php echo ($survey_data->jangka_waktu == '6') ? 'selected' : ''; ?>>6 (tempo)</option>
                                        <option value="9" <?php echo ($survey_data->jangka_waktu == '9') ? 'selected' : ''; ?>>9 (tempo)</option>
                                        <option value="12" <?php echo ($survey_data->jangka_waktu == '12') ? 'selected' : ''; ?>>12 bulan</option>
                                        <option value="18" <?php echo ($survey_data->jangka_waktu == '18') ? 'selected' : ''; ?>>18 bulan</option>
                                        <option value="24" <?php echo ($survey_data->jangka_waktu == '24') ? 'selected' : ''; ?>>24 bulan</option>
                                        <option value="36" <?php echo ($survey_data->jangka_waktu == '36') ? 'selected' : ''; ?>>36 bulan</option>
                                        <option value="42" <?php echo ($survey_data->jangka_waktu == '42') ? 'selected' : ''; ?>>42 bulan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6">
                                <div class="form-group">
                                    <label for="jaminan">Jaminan</label>
                                    <input type="text" name="jaminan" id="jaminan" class="form-control" readonly value="<?= $survey_data->jaminan; ?>">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <h4 class="text-bold"><i class="fa fa-line-chart"></i> Analisa Survey</h4>
                            <legend class="text-bold"></i> 1. Umum</legend>
                            <div class="col-xs-6 col-sm-6">
                                <div class="form-group">
                                    <label for="tgl_survey">Tanggal Survey</label>
                                    <input type="date" name="tgl_survey" id="tgl_survey" class="form-control" value="<?= isset($survey_data->tgl_survey) ? $survey_data->tgl_survey : date('Y-m-d'); ?>">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6" style="display: none;">
                                <div class="form-group">
                                    <label for="jam_mulai">Jam Mulai</label>
                                    <input type="time" name="jam_mulai" id="jam_mulai" class="form-control" value="<?= isset($survey_data->jam_mulai) ? $survey_data->jam_mulai : date('H:i'); ?>">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6" style="display: none;">
                                <div class="form-group">
                                    <label for="jam_selesai">Jam Selesai</label>
                                    <input type="time" name="jam_selesai" id="jam_selesai" class="form-control" value="<?= isset($survey_data->jam_selesai) ? $survey_data->jam_selesai : ''; ?>">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6">
                                <div class="form-group">
                                    <label for="tempat_survey">Tempat Survey</label>
                                    <select name="tempat_survey" id="tempat_survey" class="form-control">
                                        <option value="" selected>Pilih Tempat Survey</option>
                                        <option value="rumah">Rumah</option>
                                        <option value="kantor">Kantor</option>
                                        <option value="tempat_usaha">Tempat Usaha</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6">
                                <div class="form-group">
                                    <label for="kondisi_rumah">Kondisi Rumah</label>
                                    <select name="kondisi_rumah" id="kondisi_rumah" class="form-control">
                                        <option value="" selected>Pilih Kondisi Rumah</option>
                                        <option value="permanen">Permanen</option>
                                        <option value="semi_permanen">Semi Permanen</option>
                                    </select>
                                </div>
                            </div>

                            <div class="clearfix"></div>
                            <h4 class="text-bold"> 2. Sumber Informasi</h4>
                            <div class="col-xs-12 col-sm-12">
                                <div class="form-group">
                                    <label for="sumber_info">Sumber Informasi / Cek Ling</label>
                                    <textarea name="sumber_info" id="sumber_info" class="form-control" rows="5" placeholder="Tulis cek lingkungan"><?= isset($survey_data->sumber_info) ? $survey_data->sumber_info : ''; ?></textarea>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="clearfix"></div>
                            <h4 class="text-bold"> 3. Penilaian Jaminan</h4>
                            <div class="col-xs-6 col-sm-6">
                                <div class="form-group">
                                    <label for="bpkb-sertifikat-toggle">Pilih Jaminan:</label>
                                    <select id="bpkb-sertifikat-toggle" class="form-control" disabled>
                                        <option value="bpkb" <?php echo ($survey_data->jaminan == 'bpkb') ? 'selected' : ''; ?>>BPKB</option>
                                        <option value="sertifikat" <?php echo ($survey_data->jaminan == 'sertifikat') ? 'selected' : ''; ?>>SERTIFIKAT</option>
                                        <option value="lainnya" <?php echo ($survey_data->jaminan == 'lainnya') ? 'selected' : ''; ?>>LAINNYA</option>
                                    </select>
                                </div>
                            </div>
                            <div id="bpkb-section">
                                <!-- Fields related to BPKB -->
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="bpkb">No BPKB</label>
                                        <input type="text" name="bpkb" id="bpkb" class="form-control" value="<?= isset($survey_data->bpkb) ? $survey_data->bpkb : ''; ?>" placeholder="Masukan nomor BPKB">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="jns_kendaraan">Jenis Kendaraan</label>
                                        <select name="jns_kendaraan" id="jns_kendaraan" class="form-control">
                                            <option value="" <?= (empty($survey_data->jns_kendaraan)) ? 'selected' : ''; ?>>-- Pilih Jenis Kendaraan --</option>
                                            <option value="2" <?= (isset($survey_data->jns_kendaraan) && $survey_data->jns_kendaraan == '2') ? 'selected' : ''; ?>>Roda 2 (Sepeda Motor)</option>
                                            <option value="4" <?= (isset($survey_data->jns_kendaraan) && $survey_data->jns_kendaraan == '4') ? 'selected' : ''; ?>>Roda 4 (Mobil)</option>
                                            <option value="6" <?= (isset($survey_data->jns_kendaraan) && $survey_data->jns_kendaraan == '6') ? 'selected' : ''; ?>>Roda 6 (Truk)</option>
                                            <option value="8" <?= (isset($survey_data->jns_kendaraan) && $survey_data->jns_kendaraan == '8') ? 'selected' : ''; ?>>Roda 8 (Bus)</option>
                                            <option value="lainnya" <?= (isset($survey_data->jns_kendaraan) && $survey_data->jns_kendaraan == 'lainnya') ? 'selected' : ''; ?>>Lainnya</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="thn_pembuatan">Tahun Pembuatan</label>
                                        <input type="number" name="thn_pembuatan" id="thn_pembuatan" class="form-control" value="<?= isset($survey_data->thn_pembuatan) ? $survey_data->thn_pembuatan : ''; ?>" placeholder="Masukan tahun pembuatan">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="merk">Merk</label>
                                        <input type="text" name="merk" id="merk" class="form-control" value="<?= isset($survey_data->merk) ? $survey_data->merk : ''; ?>" placeholder="Masukan merk">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="tipe">Tipe</label>
                                        <input type="text" name="tipe" id="tipe" class="form-control" value="<?= isset($survey_data->tipe) ? $survey_data->tipe : ''; ?>" placeholder="Masukan tipe">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="no_pol">Nomor Polisi</label>
                                        <input type="text" name="no_pol" id="no_pol" class="form-control" value="<?= isset($survey_data->no_pol) ? $survey_data->no_pol : ''; ?>" placeholder="Masukan nomor polisi">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="no_rangka">Nomor Rangka</label>
                                        <input type="text" name="no_rangka" id="no_rangka" class="form-control" value="<?= isset($survey_data->no_rangka) ? $survey_data->no_rangka : ''; ?>" placeholder="Masukan nomor rangka">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="no_mesin">Nomor Mesin</label>
                                        <input type="text" name="no_mesin" id="no_mesin" class="form-control" value="<?= isset($survey_data->no_mesin) ? $survey_data->no_mesin : ''; ?>" placeholder="Masukan nomor mesin">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="kepemilikan">Kepemilikan</label>
                                        <input type="text" name="kepemilikan" id="kepemilikan" class="form-control" value="<?= isset($survey_data->kepemilikan) ? $survey_data->kepemilikan : ''; ?>" placeholder="Masukan nama pemilik">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="an">Atas Nama</label>
                                        <input type="text" name="an" id="an" class="form-control" value="<?= isset($survey_data->an) ? $survey_data->an : ''; ?>" placeholder="Masukan nama atas nama">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="an_alamat">Alamat Atas Nama</label>
                                        <input type="text" name="an_alamat" id="atasnama" class="form-control" value="<?= isset($survey_data->an_alamat) ? $survey_data->an_alamat : ''; ?>" placeholder="Masukan alamat atas nama">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="nilai_pasar">Nilai Pasar</label>
                                        <input type="number" name="nilai_pasar" id="nilai_pasar" class="form-control" value="<?= isset($survey_data->nilai_pasar) ? $survey_data->nilai_pasar : ''; ?>" placeholder="Masukan nominal nilai pasar">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6" style="display: none;">
                                    <div class="form-group">
                                        <label for="nilai_likuid">Nilai Likuiditas</label>
                                        <input type="number" name="nilai_likuid" id="nilai_likuid" class="form-control" value="<?= isset($survey_data->nilai_likuid) ? $survey_data->nilai_likuid : ''; ?>" placeholder="Masukan nominal nilai likuiditas">
                                    </div>
                                </div>
                                <!-- Add other BPKB-related fields here -->
                            </div>

                            <div id="sertifikat-section" style="display: none;">
                                <!-- Fields related to SERTIFIKAT -->
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="sertifikat">SERTIFIKAT</label>
                                        <input type="text" name="sertifikat" id="sertifikat" class="form-control" value="<?= isset($survey_data->sertifikat) ? $survey_data->sertifikat : ''; ?>" placeholder="Masukan nomor sertifikat">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="an_sertifikat">Atas Nama Sertifikat</label>
                                        <input type="text" name="an_sertifikat" id="an_sertifikat" class="form-control" value="<?= isset($survey_data->an_sertifikat) ? $survey_data->an_sertifikat : ''; ?>" placeholder="Masukan atas nama sertifikat">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="luas">Luas</label>
                                        <input type="text" name="luas" id="luas" class="form-control" value="<?= isset($survey_data->luas) ? $survey_data->luas : ''; ?>" placeholder="Masukan luas tanah">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="alamat_lokasi">Lokasi tanah</label>
                                        <input type="text" name="alamat_lokasi" id="alamat_lokasi" class="form-control" value="<?= isset($survey_data->alamat_lokasi) ? $survey_data->alamat_lokasi : ''; ?>" placeholder="Masukan alamat lokasi tanah">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6" style="display: none;">
                                    <div class="form-group">
                                        <label for="lokasi"> Koordinat</label>
                                        <input type="text" name="lokasi" id="lokasi" class="form-control" value="<?= isset($survey_data->lokasi) ? $survey_data->lokasi : ''; ?>" placeholder="Masukkan lokasi tanah" readonly>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <!-- Tambahkan elemen untuk menampilkan peta -->
                                <div id="map-container" style="display: none;">
                                    <input type="text" id="search-input" class="form-control" placeholder="Cari lokasi...">
                                    <div id="suggestions" class="suggestions-box"></div>
                                    <br>
                                    <div id="map"></div>
                                </div>
                                <br>
                                <hr>
                                <div class="clearfix"></div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="kecamatan">Kecamatan </label>
                                        <input type="text" name="kecamatan" id="kecamatan" class="form-control" value="<?= isset($survey_data->kecamatan) ? $survey_data->kecamatan : ''; ?>" placeholder="Masukan kecamatan">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="jarak">Jarak</label>
                                        <input type="text" name="jarak" id="jarak" class="form-control" value="<?= isset($survey_data->jarak) ? $survey_data->jarak : ''; ?>" placeholder="Masukan jarak ke pusat desa/kecamatan/kota">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="capai_lokasi">Untuk mencapai lokasi</label>
                                        <select name="capai_lokasi" id="capai_lokasi" class="form-control">
                                            <option value="" selected>Pilih mencapai lokasi</option>
                                            <option value="jalan_kaki">Jalan Kaki</option>
                                            <option value="roda_dua">Roda Dua</option>
                                            <option value="roda_empat">Roda Empat</option>
                                            <option value="roda_diatas_empat">Roda diatas empat</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="bentuk_tanah">Bentuk tanah</label>
                                        <select name="bentuk_tanah" id="bentuk_tanah" class="form-control">
                                            <option value="" selected>Pilih Bentuk tanah</option>
                                            <option value="segiempat">Segiempat</option>
                                            <option value="segitiga">Segitiga</option>
                                            <option value="trapesium">Trapesium</option>
                                            <option value="tak_beraturan">Tak beraturan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="jenis_tanah">Jenis tanah</label>
                                        <select name="jenis_tanah" id="jenis_tanah" class="form-control">
                                            <option value="" selected>Pilih Jenis tanah</option>
                                            <option value="pekarangan">Pekarangan</option>
                                            <option value="pertanian">Pertanian</option>
                                            <option value="sawah">Sawah</option>
                                            <option value="lainnya">Lainnya</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="akses_jalan">Akses Jalan</label>
                                        <select name="akses_jalan" id="akses_jalan" class="form-control">
                                            <option value="" selected>Pilih Akses Jalan</option>
                                            <option value="aspal">Aspal</option>
                                            <option value="semen">Semen</option>
                                            <option value="tanah">Tanah</option>
                                            <option value="lainnya">Lainnya</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="nilai_pasar_wajar">Nilai pasar wajar</label>
                                        <input type="number" name="nilai_pasar_wajar" id="nilai_pasar_wajar" class="form-control" value="<?= isset($survey_data->nilai_pasar_wajar) ? $survey_data->nilai_pasar_wajar : ''; ?>" placeholder="Masukan nominal nilai pasar wajar">
                                    </div>
                                </div>
                                <!-- <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="nilai_likuid_t">Nilai likuiditas</label>
                                        <input type="number" name="nilai_likuid_t" id="nilai_likuid_t" class="form-control" value="<?= isset($survey_data->nilai_likuid_t) ? $survey_data->nilai_likuid_t : ''; ?>" placeholder="Masukan nominal nilai likuiditas tanah">
                                    </div>
                                </div> -->
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="kepemilikan_t">Kepemilikan</label>
                                        <input type="text" name="kepemilikan_t" id="kepemilikan_t" class="form-control" value="<?= isset($survey_data->kepemilikan_t) ? $survey_data->kepemilikan_t : ''; ?>" placeholder="Masukan kepemilikan tanah (pribadi / pinjam (nama dan hubungan))">
                                    </div>
                                </div>
                                <!-- Add other SERTIFIKAT-related fields here -->
                            </div>

                            <div id="lainnya-section" style="display: none;">
                                <!-- Fields related to LAINNYA -->
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="lainnya">LAINNYA</label>
                                        <input type="text" name="lainnya" id="lainnya" class="form-control" value="<?= isset($survey_data->lainnya) ? $survey_data->lainnya : ''; ?>" placeholder="Masukan jaminan lainnya" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12">
                                <div class="form-group">
                                    <label for="catatan">Catatan</label>
                                    <textarea name="catatan" id="catatan" class="form-control" rows="10" placeholder="Tulis Catatan"><?= isset($survey_data->catatan) ? $survey_data->catatan : ''; ?></textarea>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group file-upload-group">
                                        <label for="foto_jaminan_1">Foto 1<span style="color: red;">*</span></label>
                                        <input type="file" name="foto_jaminan_1" id="foto_jaminan_1" class="form-control" required accept="image/*" onchange="previewImage(event, 'preview1')">
                                        <div class="preview-container">
                                            <img id="preview1" class="img-preview" alt="Preview Foto 1" style="display: none;" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group file-upload-group">
                                        <label for="foto_jaminan_2">Foto 2<span style="color: red;">*</span></label>
                                        <input type="file" name="foto_jaminan_2" id="foto_jaminan_2" class="form-control" required accept="image/*" onchange="previewImage(event, 'preview2')">
                                        <div class="preview-container">
                                            <img id="preview2" class="img-preview" alt="Preview Foto 2" style="display: none;" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group file-upload-group">
                                        <label for="foto_jaminan_3">Foto 3<span style="color: red;">*</span></label>
                                        <input type="file" name="foto_jaminan_3" id="foto_jaminan_3" class="form-control" required accept="image/*" onchange="previewImage(event, 'preview3')">
                                        <div class="preview-container">
                                            <img id="preview3" class="img-preview" alt="Preview Foto 3" style="display: none;" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group file-upload-group">
                                        <label for="foto_jaminan_4">Foto 4<span style="color: red;">*</span></label>
                                        <input type="file" name="foto_jaminan_4" id="foto_jaminan_4" class="form-control" required accept="image/*" onchange="previewImage(event, 'preview4')">
                                        <div class="preview-container">
                                            <img id="preview4" class="img-preview" alt="Preview Foto 4" style="display: none;" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <form method="post" id="checklistForm">
                                <label style="font-style: italic; font-size: xx-small; font-weight: lighter;">
                                    <input type="checkbox" name="checklist" id="checklist" value="setuju"> Pemilik
                                    jaminan telah diperiksa petugas BMT Melati dan tidak keberatan jika kendaraan /
                                    tanah miliknya dijadikan jaminan pembiayaan dan mengetahui segala resiko yang
                                    timbul di kemudian hari.
                                </label><br>

                                <!-- Tambahkan kolom lainnya sesuai dengan data survei -->
                                <button type="submit" class="btn btn-danger" id="kirimButton" style="float:right;" disabled> Kirim Survey</button>
                            </form>
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

<script>
    // script toggle 
    document.addEventListener('DOMContentLoaded', function() {
        // Mengecek apakah checkbox "setuju" telah dicentang
        document.getElementById('checklist').addEventListener('change', function() {
            var kirimButton = document.getElementById('kirimButton');
            if (this.checked) {
                kirimButton.removeAttribute('disabled');
            } else {
                kirimButton.setAttribute('disabled', 'true');
            }
        });

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
        var defaultLocation = [-7.150975, 110.140259]; // Default to Jawa Tengah
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

        // Try to get the user's current location
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var userLocation = [position.coords.latitude, position.coords.longitude];
                map.setView(userLocation, 12); // Zoom closer to user location
                marker.setLatLng(userLocation);
                updateLocationInput({
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                });
            }, function() {
                console.log('Geolocation failed, using default location');
            });
        } else {
            console.log('Geolocation not supported, using default location');
        }

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
            html: `
            <div style="text-align: center;">
                <img src="${imageURL}" class="popup-image" style="max-width: 100%; height: auto; margin-bottom: 10px;" />
                <br />
                <button class="btn btn-primary" onclick="openInDefaultApp('${imageURL}')">Open in Default App</button>
            </div>
        `,
            showCloseButton: true,
            showConfirmButton: false,
            customClass: {
                content: 'custom-popup-content',
                closeButton: 'custom-popup-close-button'
            }
        });
    }

    // Fungsi untuk membuka gambar di aplikasi default perangkat
    function openInDefaultApp(imageURL) {
        // Membuka gambar di jendela baru, yang memungkinkan perangkat untuk memutuskan aplikasi mana yang akan digunakan
        window.open(imageURL, '_blank');
    }

    $(document).ready(function() {
        // Perubahan warna untuk semua input text
        $('input').on('input', function() {
            if ($(this).val() === "") {
                $(this).css({
                    'background-color': '#ffe6e6'
                });
            } else {
                $(this).css({
                    'background-color': '#e6ffe6'
                });
            }
        });

        // Perubahan warna untuk elemen select biasa
        $('select').on('change', function() {
            if ($(this).val() === "") {
                $(this).css({
                    'background-color': '#ffe6e6'
                });
            } else {
                $(this).css({
                    'background-color': '#e6ffe6'
                });
            }
        });

        // Perubahan warna untuk elemen select yang menggunakan Select2
        $('select').on('select2:select select2:unselect', function(e) {
            var select2Element = $(this).next('.select2-container').find('.select2-selection');
            if ($(this).val() === "") {
                select2Element.css({
                    'background-color': '#ffe6e6'
                });
            } else {
                select2Element.css({
                    'background-color': '#e6ffe6'
                });
            }
        });

        // Inisialisasi warna awal untuk semua input dan select (termasuk Select2)
        $('input').each(function() {
            if ($(this).val() === "") {
                $(this).css({
                    'background-color': '#ffe6e6'
                });
            } else {
                $(this).css({
                    'background-color': '#e6ffe6'
                });
            }
        });

        $('select').each(function() {
            var select2Element = $(this).next('.select2-container').find('.select2-selection');
            if ($(this).val() === "") {
                $(this).css({
                    'background-color': '#ffe6e6'
                });
                // Jika select menggunakan Select2, ganti juga warnanya
                if (select2Element.length) {
                    select2Element.css({
                        'background-color': '#ffe6e6'
                    });
                }
            } else {
                $(this).css({
                    'background-color': '#e6ffe6'
                });
                // Jika select menggunakan Select2, ganti juga warnanya
                if (select2Element.length) {
                    select2Element.css({
                        'background-color': '#e6ffe6'
                    });
                }
            }
        });
    });
</script>
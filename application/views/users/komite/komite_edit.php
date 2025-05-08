<?php
$cek = $user->row();
$id_user = $cek->id_user;
$level = $cek->level;
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

    .branch {
        list-style: none;
        padding: 0;
        font-family: Arial, sans-serif;
    }

    .branch-item {
        border: 1px solid #e0e0e0;
        margin: 10px 0;
        padding: 10px;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .branch-item:hover {
        /* background-color: #f5f5f5; */
        background-color: #add8e6;
    }

    .branch-item a {
        text-decoration: none;
        font-weight: 500;
        color: #000;
    }

    .marker-icon {
        margin-right: 10px;
        font-size: 20px;
        transition: transform 0.3s ease;
    }

    .branch-item.active .marker-icon {
        transform: rotate(180deg);
    }

    .branch-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .branch-details {
        display: none;
        margin-top: 10px;
    }

    .branch-item.active .branch-details {
        display: inline-block;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const markerIcons = document.querySelectorAll('.branch-title'); // Hanya target marker-icon

        markerIcons.forEach((icon) => {
            icon.addEventListener('click', (e) => {
                const branchItem = icon.closest('.branch-item'); // Mencari elemen .branch-item terdekat
                if (branchItem) {
                    branchItem.classList.toggle('active');
                }
            });
        });
    });
</script>
<div class="container">
    <div class="content">
        <?php echo $this->session->flashdata('msg'); ?>
        <!-- Edit Survey Form -->
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <div class="navigation-buttons">
                        <i class="fa fa-poll"></i> Edit Form Komite<br>
                        <span style="font-size: 80%; opacity: 0.7;"><strong><?php echo 'PBY' . $survey_data->id_pby; ?></strong> </span>
                        <span style="font-size: 80%; opacity: 0.7;"> | <strong><?php echo $survey_data->nama; ?></strong> </span>
                        <span style="font-size: 80%; opacity: 0.7;"> | <strong><?php echo 'Rp ' . number_format($survey_data->nominal, 0, ',', '.'); ?></strong></span>
                        <div class="btn-group" style="float: right;">
                            <!-- Tombol Dropdown (di pojok kanan atas) -->
                            <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bars"></i>
                            </button>
                            <!-- Isi Dropdown -->
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <li><a href="users/analisa/analisa"><i class="fa fa-plus"></i> Data Survey</a></li>
                                <li><a href="users/analisa/analisa"><i class="fa fa-file-text"></i> Data Survey</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                    <form method="post" enctype="multipart/form-data" action="<?= base_url('users/komite_edit/' . $survey_data->id_pby); ?>" id="checklistForm">
                        <ul class="branch">
                            <li class="branch-item">
                                <div class="branch-title">
                                    <h4 class="text-bold"><i class="fa fa-person"></i> Data Pemohon</h4>
                                    <div class="marker-icon"><i class="fa-solid fa-caret-down"></i></div>
                                </div>
                                <div class="branch-details">
                                    <input type="hidden" name="id_pby" id="id_pby" class="form-control" required value="<?= $survey_data->id_pby; ?>">
                                    <input type="hidden" name="tgl_komite" id="tgl_komite" class="form-control" required value="<?= date('Y-m-d'); ?>">
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="nama">Nama Pemohon<span style="color: red;">*</span></label>
                                            <input type="text" name="nama" id="nama" class="form-control" required readonly value="<?= $survey_data->nama; ?>" placeholder="Masukan nama pemohon">
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
                                            <label for="alamat">Alamat Rumah<span style="color: red;">*</span></label>
                                            <input type="text" name="alamat" id="alamat" class="form-control" required readonly value="<?= $survey_data->alamat; ?>" placeholder="Masukan alamat rumah">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="alamat_usaha">Alamat Usaha/Kantor</label>
                                            <input type="text" name="alamat_usaha" id="alamat_usaha" class="form-control" readonly value="<?= isset($survey_data->alamat_usaha) ? $survey_data->alamat_usaha : ''; ?>" placeholder="Masukan alamat usaha / kantor">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="telepon">Telepon</label>
                                            <input type="text" name="telepon" id="telepon" class="form-control" readonly value="<?= $survey_data->telepon; ?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="pekerjaan">Pekerjaan Pokok</label>
                                            <input type="text" name="pekerjaan" id="pekerjaan" class="form-control" readonly value="<?= $survey_data->pekerjaan; ?>" placeholder="Masukan pekerjaan pokok">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="pekerjaan_sampingan">Pekerjaan Sampingan</label>
                                            <input type="text" name="pekerjaan_sampingan" id="pekerjaan_sampingan" class="form-control" readonly value="<?= isset($survey_data->pekerjaan_sampingan) ? $survey_data->pekerjaan_sampingan : ''; ?>" placeholder="Masukan pekerjaan sampingan">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="foto_ktp">Foto KTP<span style="color: red;">*</span></label>

                                            <?php
                                            // Ambil nama file foto_ktp dari data usulan_data
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
                                            <label for="nominal">Besar Pembiayaan<span style="color: red;">*</span></label>
                                            <input type="number" name="nominal" id="nominal" class="form-control" required readonly value="<?= $survey_data->nominal; ?>" placeholder="Masukan besaran nilai pembiayaan">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="riwayat_pembiayaan">Riwayat Pembiayaan Terakhir</label>
                                            <select name="riwayat_pembiayaan" id="riwayat_pembiayaan" class="form-control">
                                                <option value="lancar">Lancar</option>
                                                <option value="kurang">Kurang</option>
                                                <option value="diragukan">Diragukan</option>
                                                <option value="macet">Macet</option>
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
                                            <label for="bidang_usaha">Bidang Usaha</label>
                                            <input type="text" name="bidang_usaha" id="bidang_usaha" class="form-control" readonly value="<?= isset($survey_data->bidang_usaha) ? $survey_data->bidang_usaha : ''; ?>" placeholder="Masukan bidang usaha">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="sumber_pelunasan">Sumber Pelunasan</label>
                                            <select name="sumber_pelunasan" id="sumber_pelunasan" class="form-control" disabled>
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
                                </div>
                            </li>

                            <div class="clearfix"></div>

                            <li class="branch-item">
                                <div class="branch-title">
                                    <h4 class="text-bold"><i class="fa-solid fa-person-running"></i> Data Survey</h4>
                                    <div class="marker-icon"><i class="fa-solid fa-caret-down"></i></div>
                                </div>
                                <div class="branch-details">
                                    <legend class="text-bold"></i> Umum</legend>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="tgl_survey">Tanggal Survey</label>
                                            <input type="date" name="tgl_survey" id="tgl_survey" class="form-control" readonly value="<?= isset($survey_data->tgl_survey) ? $survey_data->tgl_survey : date('Y-m-d'); ?>">
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
                                            <select name="tempat_survey" id="tempat_survey" class="form-control" disabled>
                                                <option value="rumah">Rumah</option>
                                                <option value="kantor">Kantor</option>
                                                <option value="tempat_usaha">Tempat Usaha</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="kondisi_rumah">Kondisi Rumah</label>
                                            <select name="kondisi_rumah" id="kondisi_rumah" class="form-control" disabled>
                                                <option value="permanen">Permanen</option>
                                                <option value="semi_permanen">Semi Permanen</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="kekayaan1">Kekayaan 1</label>
                                            <input type="text" name="kekayaan1" id="kekayaan1" class="form-control" value="<?= isset($survey_data->kekayaan1) ? $survey_data->kekayaan1 : ''; ?>" placeholder="Masukan jenis kekayaan">
                                        </div>
                                    </div> -->
                                    <!-- <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="harga_taksiran1">Harga Taksiran Kekayaan 1</label>
                                            <input type="text" name="harga_taksiran1" id="harga_taksiran1" class="form-control" value="<?= isset($survey_data->harga_taksiran1) ? $survey_data->harga_taksiran1 : ''; ?>" placeholder="Masukan nilai taksiran kekayaan">
                                        </div>
                                    </div> -->
                                    <!-- <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="kekayaan2">Kekayaan 2</label>
                                            <input type="text" name="kekayaan2" id="kekayaan2" class="form-control" value="<?= isset($survey_data->kekayaan2) ? $survey_data->kekayaan2 : ''; ?>" placeholder="Masukan jenis kekayaan">
                                        </div>
                                    </div> -->
                                    <!-- <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="harga_taksiran2">Harga Taksiran Kekayaan 2</label>
                                            <input type="text" name="harga_taksiran2" id="harga_taksiran2" class="form-control" value="<?= isset($survey_data->harga_taksiran2) ? $survey_data->harga_taksiran2 : ''; ?>" placeholder="Masukan nilai taksiran kekayaan">
                                        </div>
                                    </div> -->
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="sumber_info">Sumber Informasi / Cek Ling</label>
                                            <textarea name="sumber_info" id="sumber_info" class="form-control" placeholder="Tulis Sumber Info" rows="10"><?= isset($survey_data->sumber_info) ? $survey_data->sumber_info : ''; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <!-- <h1 class="text-bold"> 2. Sumber Informasi</h1>
                                    <div class="clearfix"></div> -->
                                    <h1 class="text-bold"> 2. Kalkulasi kebutuhan modal usaha</h1>
                                    <legend class="text-bold"></i> A. Laba Usaha</legend>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="catatan">Catatan</label>
                                            <textarea name="catatan" id="catatan" class="form-control" placeholder="Tulis Catatan" rows="10"><?= isset($survey_data->catatan) ? $survey_data->catatan : ''; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="penjualan_usaha">Penjualan Usaha Per</label>
                                            <select name="penjualan_usaha" id="penjualan_usaha" class="form-control">
                                                <option value="bulan">Bulan</option>
                                                <option value="tahun">Tahun</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="hrg_pokok_brg">Harga Pokok Barang</label>
                                            <input type="number" name="hrg_pokok_brg" id="hrg_pokok_brg" class="form-control" value="<?= isset($survey_data->hrg_pokok_brg) ? $survey_data->hrg_pokok_brg : ''; ?>" placeholder="Masukan nilai harga pokok" oninput="calculateLabaUsaha()">
                                        </div>
                                    </div>

                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="jml_penjualan">Jumlah Penjualan</label>
                                            <input type="number" name="jml_penjualan" id="jml_penjualan" class="form-control" value="<?= isset($survey_data->jml_penjualan) ? $survey_data->jml_penjualan : ''; ?>" placeholder="Masukan jumlah penjualan" oninput="calculateLabaUsaha()">
                                        </div>
                                    </div>

                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="biaya_usaha">Biaya Usaha</label>
                                            <input type="number" name="biaya_usaha" id="biaya_usaha" class="form-control" value="<?= isset($survey_data->biaya_usaha) ? $survey_data->biaya_usaha : ''; ?>" placeholder="Masukan nilai biaya usaha" oninput="calculateLabaUsaha()">
                                        </div>
                                    </div>

                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="laba_usaha">Pendapatan Usaha</label>
                                            <input type="number" name="laba_usaha" id="laba_usaha" class="form-control" value="<?= isset($survey_data->laba_usaha) ? $survey_data->laba_usaha : ''; ?>" placeholder="Masukan nilai laba usaha" readonly>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <legend class="text-bold"> B. Kemampuan Bayar</legend>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="laba_usaha_bayar">Laba Usaha Bayar</label>
                                            <input type="number" name="laba_usaha_bayar" id="laba_usaha_bayar" class="form-control" value="<?= isset($survey_data->laba_usaha_bayar) ? $survey_data->laba_usaha_bayar : ''; ?>" placeholder="Masukan nilai kemampuan bayar dari laba usaha" oninput="calculateTotal()">
                                        </div>
                                    </div>

                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="pendapatan_istri">Pendapatan Istri</label>
                                            <input type="number" name="pendapatan_istri" id="pendapatan_istri" class="form-control" value="<?= isset($survey_data->pendapatan_istri) ? $survey_data->pendapatan_istri : ''; ?>" placeholder="Masukan nilai pendapatan istri" oninput="calculateTotal()">
                                        </div>
                                    </div>

                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="pendapatan_lain">Pendapatan Lainnya</label>
                                            <input type="number" name="pendapatan_lain" id="pendapatan_lain" class="form-control" value="<?= isset($survey_data->pendapatan_lain) ? $survey_data->pendapatan_lain : ''; ?>" placeholder="Masukan nilai pendapatan lain" oninput="calculateTotal()">
                                        </div>
                                    </div>

                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="jml_pendapatan_diterima">Jumlah Pendapatan Diterima</label>
                                            <input type="number" name="jml_pendapatan_diterima" id="jml_pendapatan_diterima" class="form-control" value="<?= isset($survey_data->jml_pendapatan_diterima) ? $survey_data->jml_pendapatan_diterima : ''; ?>" placeholder="Pendapatan total" readonly>
                                        </div>
                                    </div>

                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="pendapatan_bersih">Pendapatan Bersih</label>
                                            <input type="number" name="pendapatan_bersih" id="pendapatan_bersih" class="form-control" value="<?= isset($survey_data->pendapatan_bersih) ? $survey_data->pendapatan_bersih : ''; ?>" placeholder="Masukan nilai pendapatan bersih">
                                        </div>
                                    </div>


                                    <div class="clearfix"></div>
                                    <legend class="text-bold"> C. Biaya diluar usaha</legend>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="biaya_rt">Biaya Rumah Tangga</label>
                                            <input type="number" name="biaya_rt" id="biaya_rt" class="form-control" value="<?= isset($survey_data->biaya_rt) ? $survey_data->biaya_rt : ''; ?>" placeholder="Masukan nilai biaya rumah tangga">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="biaya_pendidikan">Biaya Pendidikan</label>
                                            <input type="number" name="biaya_pendidikan" id="biaya_pendidikan" class="form-control" value="<?= isset($survey_data->biaya_pendidikan) ? $survey_data->biaya_pendidikan : ''; ?>" placeholder="Masukan nilai biaya pendidikan">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="biaya_lain">Biaya Lain-Lain</label>
                                            <input type="number" name="biaya_lain" id="biaya_lain" class="form-control" value="<?= isset($survey_data->biaya_lain) ? $survey_data->biaya_lain : ''; ?>" placeholder="Masukan nilai biaya lain">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="jml_pengeluaran">Jumlah Pengeluaran</label>
                                            <input type="number" name="jml_pengeluaran" id="jml_pengeluaran" class="form-control" value="<?= isset($survey_data->jml_pengeluaran) ? $survey_data->jml_pengeluaran : ''; ?>" placeholder="Masukan nilai jumlah pengeluaran">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="lending_maksimal">Lending Maksimal</label>
                                            <input type="number" name="lending_maksimal" id="lending_maksimal" class="form-control" value="<?= isset($survey_data->lending_maksimal) ? $survey_data->lending_maksimal : ''; ?>" placeholder="Masukan nilai lending maksimal">
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <div class="clearfix"></div>

                            <li class="branch-item">
                                <div class="branch-title">
                                    <h4 class="text-bold"><i class="fa fa-archive"></i> Data Jaminan <?php echo $survey_data->jaminan; ?></h4>
                                    <div class="marker-icon"><i class="fa-solid fa-caret-down"></i></div>
                                </div>
                                <div class="branch-details">
                                    <?php if (isset($survey_data->jaminan) && $survey_data->jaminan == 'bpkb') { ?>
                                        <div class="col-xs-6 col-sm-6">
                                            <div class="form-group">
                                                <label for="bpkb">BPKB</label>
                                                <input type="text" name="bpkb" id="bpkb" class="form-control" readonly value="<?= isset($survey_data->bpkb) ? $survey_data->bpkb : ''; ?>">
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                            <div class="form-group">
                                                <label for="jns_kendaraan">Jenis Kendaraan</label>
                                                <input type="text" name="jns_kendaraan" id="jns_kendaraan" class="form-control" readonly value="<?= isset($survey_data->jns_kendaraan) ? $survey_data->jns_kendaraan : ''; ?>">
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                            <div class="form-group">
                                                <label for="thn_pembuatan">Tahun Pembuatan</label>
                                                <input type="number" name="thn_pembuatan" id="thn_pembuatan" class="form-control" readonly value="<?= isset($survey_data->thn_pembuatan) ? $survey_data->thn_pembuatan : ''; ?>" min="1900" max="2099" placeholder="Masukan tahun pembuatan">
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                            <div class="form-group">
                                                <label for="merk">Merk</label>
                                                <input type="text" name="merk" id="merk" class="form-control" readonly value="<?= isset($survey_data->merk) ? $survey_data->merk : ''; ?>" placeholder="Masukan merk">
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                            <div class="form-group">
                                                <label for="no_mesin">Nomor Mesin</label>
                                                <input type="text" name="no_mesin" id="no_mesin" class="form-control" readonly value="<?= isset($survey_data->no_mesin) ? $survey_data->no_mesin : ''; ?>" placeholder="Masukan nomor mesin">
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                            <div class="form-group">
                                                <label for="tipe">Tipe</label>
                                                <input type="text" name="tipe" id="tipe" class="form-control" readonly value="<?= isset($survey_data->tipe) ? $survey_data->tipe : ''; ?>" placeholder="Masukan tipe">
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                            <div class="form-group">
                                                <label for="no_rangka">Nomor Rangka</label>
                                                <input type="text" name="no_rangka" id="no_rangka" class="form-control" readonly value="<?= isset($survey_data->no_rangka) ? $survey_data->no_rangka : ''; ?>" placeholder="Masukan nomor rangka">
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                            <div class="form-group">
                                                <label for="no_pol">Nomor Polisi</label>
                                                <input type="text" name="no_pol" id="no_pol" class="form-control" readonly value="<?= isset($survey_data->no_pol) ? $survey_data->no_pol : ''; ?>" placeholder="Masukan nomor polisi">
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                            <div class="form-group">
                                                <label for="kepemilikan">Kepemilikan</label>
                                                <input type="text" name="kepemilikan" id="kepemilikan" class="form-control" readonly value="<?= isset($survey_data->kepemilikan) ? $survey_data->kepemilikan : ''; ?>" placeholder="Masukan nama pemilik">
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                            <div class="form-group">
                                                <label for="an">Atas Nama</label>
                                                <input type="text" name="an" id="an" class="form-control" readonly value="<?= isset($survey_data->an) ? $survey_data->an : ''; ?>" placeholder="Masukan nama atas nama">
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                            <div class="form-group">
                                                <label for="an_alamat">Alamat Atas Nama</label>
                                                <input type="text" name="an_alamat" id="atasnama" class="form-control" readonly value="<?= isset($survey_data->an_alamat) ? $survey_data->an_alamat : ''; ?>" placeholder="Masukan alamat atas nama">
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                            <div class="form-group">
                                                <label for="nilai_pasar">Nilai Pasar</label>
                                                <input type="number" name="nilai_pasar" id="nilai_pasar" class="form-control" value="<?= isset($survey_data->nilai_pasar) ? $survey_data->nilai_pasar : ''; ?>" placeholder="Masukan nominal nilai pasar">
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                            <div class="form-group">
                                                <label for="nilai_likuid">Nilai Likuiditas</label>
                                                <input type="number" name="nilai_likuid" id="nilai_likuid" class="form-control" value="<?= isset($survey_data->nilai_likuid) ? $survey_data->nilai_likuid : ''; ?>" placeholder="Masukan nominal nilai likuiditas">
                                            </div>
                                        </div>
                                    <?php } elseif (isset($survey_data->jaminan) && $survey_data->jaminan == 'sertifikat') { ?>
                                        <div class="col-xs-6 col-sm-6">
                                            <div class="form-group">
                                                <label for="sertifikat">SERTIFIKAT</label>
                                                <input type="number" name="sertifikat" id="sertifikat" class="form-control" readonly value="<?= isset($survey_data->sertifikat) ? $survey_data->sertifikat : ''; ?>" placeholder="Masukan nomor sertifikat">
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
                                                <label for="alamat_lokasi">Alamat Lokasi tanah</label>
                                                <input type="text" name="alamat_lokasi" id="alamat_lokasi" class="form-control" value="<?= isset($survey_data->alamat_lokasi) ? $survey_data->alamat_lokasi : ''; ?>" placeholder="Masukan alamat lokasi tanah">
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                            <div class="form-group">
                                                <label for="lokasi">Koordinat</label>
                                                <input type="text" name="lokasi" id="lokasi" class="form-control" value="<?= isset($survey_data->lokasi) ? $survey_data->lokasi : ''; ?>" placeholder="Masukkan lokasi tanah">
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <!-- Tambahkan elemen untuk menampilkan peta -->
                                        <div id="map-container" style="display:none">
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
                                                <label for="kecamatan">Kecamatan</label>
                                                <input type="text" name="kecamatan" id="kecamatan" class="form-control" value="<?= isset($survey_data->kecamatan_nama) ? $survey_data->kecamatan_nama : ''; ?>" placeholder="Masukan kecamatan">
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
                                                    <option value="jalan_kali" <?= isset($survey_data->capai_lokasi) && $survey_data->capai_lokasi == 'jalan_kali' ? 'selected' : ''; ?>>Jalan Kaki</option>
                                                    <option value="roda_dua" <?= isset($survey_data->capai_lokasi) && $survey_data->capai_lokasi == 'roda_dua' ? 'selected' : ''; ?>>Roda Dua</option>
                                                    <option value="roda_empat" <?= isset($survey_data->capai_lokasi) && $survey_data->capai_lokasi == 'roda_empat' ? 'selected' : ''; ?>>Roda Empat</option>
                                                    <option value="roda_diatas_empat" <?= isset($survey_data->capai_lokasi) && $survey_data->capai_lokasi == 'roda_diatas_empat' ? 'selected' : ''; ?>>Roda diatas empat</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                            <div class="form-group">
                                                <label for="bentuk_tanah">Bentuk tanah</label>
                                                <select name="bentuk_tanah" id="bentuk_tanah" class="form-control">
                                                    <option value="segiempat" <?= isset($survey_data->bentuk_tanah) && $survey_data->bentuk_tanah == 'segiempat' ? 'selected' : ''; ?>>Segiempat</option>
                                                    <option value="segitiga" <?= isset($survey_data->bentuk_tanah) && $survey_data->bentuk_tanah == 'segitiga' ? 'selected' : ''; ?>>Segitiga</option>
                                                    <option value="trapesium" <?= isset($survey_data->bentuk_tanah) && $survey_data->bentuk_tanah == 'trapesium' ? 'selected' : ''; ?>>Trapesium</option>
                                                    <option value="tak_beraturan" <?= isset($survey_data->bentuk_tanah) && $survey_data->bentuk_tanah == 'tak_beraturan' ? 'selected' : ''; ?>>Tak beraturan</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                            <div class="form-group">
                                                <label for="jenis_tanah">Jenis tanah</label>
                                                <select name="jenis_tanah" id="jenis_tanah" class="form-control">
                                                    <option value="darat">Darat</option>
                                                    <option value="ladang">Ladang</option>
                                                    <option value="sawah">Sawah</option>
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
                                        <div class="col-xs-6 col-sm-6">
                                            <div class="form-group">
                                                <label for="nilai_likuid_t">Nilai likuiditas</label>
                                                <input type="number" name="nilai_likuid_t" id="nilai_likuid_t" class="form-control" value="<?= isset($survey_data->nilai_likuid_t) ? $survey_data->nilai_likuid_t : ''; ?>" placeholder="Masukan nominal nilai likuiditas tanah">
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                            <div class="form-group">
                                                <label for="kepemilikan_t">Kepemilikan</label>
                                                <input type="text" name="kepemilikan_t" id="kepemilikan_t" class="form-control" value="<?= isset($survey_data->kepemilikan_t) ? $survey_data->kepemilikan_t : ''; ?>" placeholder="Masukan kepemilikan tanah (dasar,hibah,jual beli)">
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <p>Data jaminan tidak tersedia atau tidak valid.</p>
                                    <?php } ?>

                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="foto_jaminan_1">Foto 1<span style="color: red;">*</span></label>

                                            <?php
                                            $foto_jaminan_1 = isset($survey_data->foto_jaminan_1) ? $survey_data->foto_jaminan_1 : '';
                                            $thumbnailURL = './foto/foto_usulan/' . $foto_jaminan_1;

                                            if (!empty($foto_jaminan_1) && file_exists($thumbnailURL)) {
                                            ?>
                                                <div class="mt-2">
                                                    <a href="javascript:void(0);" onclick="openPopup('<?php echo $thumbnailURL; ?>');">
                                                        <img src="<?php echo $thumbnailURL; ?>" alt="Thumbnail KTP" class="img-preview">
                                                    </a>
                                                </div>
                                            <?php
                                            } else {
                                            ?>
                                                <input type="file" name="foto_jaminan_1" id="foto_jaminan_1" class="form-control" accept="image/*" onchange="previewImage(event, 'foto_jaminan_1_Preview')">
                                                <div class="mt-2">
                                                    <img id="foto_jaminan_1_Preview" alt="foto_jaminan_1" style="display:none; max-width: 100px;" />
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="foto_jaminan_2">Foto 2<span style="color: red;">*</span></label>

                                            <?php
                                            $foto_jaminan_2 = isset($survey_data->foto_jaminan_2) ? $survey_data->foto_jaminan_2 : '';
                                            $thumbnailURL = './foto/foto_usulan/' . $foto_jaminan_2;

                                            if (!empty($foto_jaminan_2) && file_exists($thumbnailURL)) {
                                            ?>
                                                <div class="mt-2">
                                                    <a href="javascript:void(0);" onclick="openPopup('<?php echo $thumbnailURL; ?>');">
                                                        <img src="<?php echo $thumbnailURL; ?>" alt="Thumbnail KTP" class="img-preview">
                                                    </a>
                                                </div>
                                            <?php
                                            } else {
                                            ?>
                                                <input type="file" name="foto_jaminan_2" id="foto_jaminan_2" class="form-control" accept="image/*" onchange="previewImage(event, 'foto_jaminan_2_Preview')">
                                                <div class="mt-2">
                                                    <img id="foto_jaminan_2_Preview" alt="foto_jaminan_2" style="display:none; max-width: 100px;" />
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="foto_jaminan_3">Foto 3<span style="color: red;">*</span></label>

                                            <?php
                                            $foto_jaminan_3 = isset($survey_data->foto_jaminan_3) ? $survey_data->foto_jaminan_3 : '';
                                            $thumbnailURL = './foto/foto_usulan/' . $foto_jaminan_3;

                                            if (!empty($foto_jaminan_3) && file_exists($thumbnailURL)) {
                                            ?>
                                                <div class="mt-2">
                                                    <a href="javascript:void(0);" onclick="openPopup('<?php echo $thumbnailURL; ?>');">
                                                        <img src="<?php echo $thumbnailURL; ?>" alt="Thumbnail" class="img-preview">
                                                    </a>
                                                </div>
                                            <?php
                                            } else {
                                            ?>
                                                <input type="file" name="foto_jaminan_3" id="foto_jaminan_3" class="form-control" accept="image/*" onchange="previewImage(event, 'foto_jaminan_3_Preview')">
                                                <div class="mt-2">
                                                    <img id="foto_jaminan_3_Preview" alt="foto_jaminan_3" style="display:none; max-width: 100px;" />
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="foto_jaminan_4">Foto 4<span style="color: red;">*</span></label>

                                            <?php
                                            $foto_jaminan_4 = isset($survey_data->foto_jaminan_4) ? $survey_data->foto_jaminan_4 : '';
                                            $thumbnailURL = './foto/foto_usulan/' . $foto_jaminan_4;

                                            if (!empty($foto_jaminan_4) && file_exists($thumbnailURL)) {
                                            ?>
                                                <div class="mt-2">
                                                    <a href="javascript:void(0);" onclick="openPopup('<?php echo $thumbnailURL; ?>');">
                                                        <img src="<?php echo $thumbnailURL; ?>" alt="Thumbnail" class="img-preview">
                                                    </a>
                                                </div>
                                            <?php
                                            } else {
                                            ?>
                                                <input type="file" name="foto_jaminan_4" id="foto_jaminan_4" class="form-control" accept="image/*" onchange="previewImage(event, 'foto_jaminan_4_Preview')">
                                                <div class="mt-2">
                                                    <img id="foto_jaminan_4_Preview" alt="foto_jaminan_4" style="display:none; max-width: 100px;" />
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label for="status_analisa">Status Analisa</label>
                                <!-- Display "Sudah" or "Belum" based on the value of status_analisa -->
                                <span class="form-control" readonly>
                                    <?php if (isset($survey_data->status_analisa)) : ?>
                                        <?php if ($survey_data->status_analisa == 1) : ?>
                                            <span class="badge badge-success badge-sm">Checked</span>
                                        <?php else : ?>
                                            <span class="badge badge-danger badge-sm">Not Checked</span>
                                        <?php endif; ?>
                                    <?php else : ?>
                                        <span class="badge badge-secondary badge-sm">Not Checked</span>
                                    <?php endif; ?>
                                </span>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label for="analyst">Analist</label>
                                <input type="text" name="analyst" id="analyst" class="form-control" readonly value="<?= $this->Usulan_model->getUsernameById($survey_data->analyst); ?>">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label for="hasil_analisa">Hasil Analisa</label>
                                <span class="form-control" readonly>
                                    <?php
                                    switch ($survey_data->hasil_analisa) {
                                        case '1':
                                            echo '<span class="badge badge-danger badge-sm">Tidak Rekomendasi</span>';
                                            break;
                                        case '2':
                                            echo '<span class="badge badge-primary badge-sm">Pertimbangkan</span>';
                                            break;
                                        case '3':
                                            echo '<span class="badge badge-success badge-sm">Rekomendasi</span>';
                                            break;
                                        default:
                                            echo '<span class="badge badge-secondary badge-sm">-</span>';
                                            break;
                                    }
                                    ?>
                                </span>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label for="pimpinan_komite">Pimpinan Komite</label>
                                <select class="form-control select2" name="pimpinan_komite" id="pimpinan_komite" required>
                                    <option value="" disabled selected>Pilih Nama</option>
                                    <?php
                                    $users = $this->db->where('status', 'aktif')->get('tbl_user')->result();
                                    // $users = $this->db->get('tbl_user')->result();
                                    foreach ($users as $user) {
                                        echo "<option value='{$user->id_user}'>{$user->nama_lengkap}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label for="status_komite">Status Komite</label>
                                <select name="status_komite" id="status_komite" class="form-control">
                                    <option value="" <?= (is_null($survey_data->status_komite)) ? 'selected' : ''; ?>>-- Pilih Status --</option>
                                    <option value="1" <?= (isset($survey_data->status_komite) && $survey_data->status_komite == '1') ? 'selected' : ''; ?>>Acc</option>
                                    <option value="2" <?= (isset($survey_data->status_komite) && $survey_data->status_komite == '2') ? 'selected' : ''; ?>>Ditunda</option>
                                    <option value="3" <?= (isset($survey_data->status_komite) && $survey_data->status_komite == '3') ? 'selected' : ''; ?>>Ditolak</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label for="jml_realisasi">Jumlah Realisasi</label>
                                <input type="number" name="jml_realisasi" id="jml_realisasi" class="form-control" inputmode="numeric" value="<?= isset($survey_data->jml_realisasi) ? $survey_data->jml_realisasi : ''; ?>">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label for="akad">Akad</label>
                                <input type="text" name="akad" id="akad" class="form-control" value="<?= isset($survey_data->akad) ? $survey_data->akad : ''; ?>">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label for="tgl_dropping">Tgl Dropping</label>
                                <input type="date" name="tgl_dropping" id="tgl_dropping" class="form-control" value="<?= isset($survey_data->tgl_dropping) ? $survey_data->tgl_dropping : ''; ?>">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label for="cara_angsuran">Cara Angsuran</label>
                                <select name="cara_angsuran" id="cara_angsuran" class="form-control">
                                    <option value="" <?= (is_null($survey_data->cara_angsuran)) ? 'selected' : ''; ?>>-- Pilih Cara Angsuran --</option>
                                    <option value="harian" <?= (isset($survey_data->cara_angsuran) && $survey_data->cara_angsuran == 'harian') ? 'selected' : ''; ?>>Harian</option>
                                    <option value="bulanan" <?= (isset($survey_data->cara_angsuran) && $survey_data->cara_angsuran == 'bulanan') ? 'selected' : ''; ?>>Bulanan</option>
                                    <option value="tunai" <?= (isset($survey_data->cara_angsuran) && $survey_data->cara_angsuran == 'tunai') ? 'selected' : ''; ?>>Tunai</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label for="pengikat">Pengikat</label>
                                <select name="pengikat" id="pengikat" class="form-control">
                                    <option value="" <?= (is_null($survey_data->pengikat)) ? 'selected' : ''; ?>>-- Pilih Pengikat --</option>
                                    <option value="internal" <?= (isset($survey_data->pengikat) && $survey_data->pengikat == 'internal') ? 'selected' : ''; ?>>Internal</option>
                                    <option value="notariil" <?= (isset($survey_data->pengikat) && $survey_data->pengikat == 'notariil') ? 'selected' : ''; ?>>Notariil</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12">
                            <div class="form-group">
                                <label for="catatan_komite">Catatan Komite</label>
                                <textarea name="catatan_komite" id="catatan_komite" class="form-control" rows="5" placeholder="Tulis catatan komite"><?= isset($survey_data->catatan_komite) ? $survey_data->catatan_komite : ''; ?></textarea>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                        <div class="col-xs-4 col-sm-2 text-center">
                            <div class="form-group" style="float: right;">
                                <label for="ttd_gm">General Manager</label>
                                <?php
                                $ttd_gm = isset($survey_data->ttd_gm) ? $survey_data->ttd_gm : '';
                                $thumbnailURL = './foto/foto_usulan/foto_ttd/' . $ttd_gm;

                                if (!empty($ttd_gm) && file_exists($thumbnailURL)) {
                                ?>
                                    <div class="mt-2">
                                        <a href="javascript:void(0);" onclick="openPopup('<?php echo $thumbnailURL; ?>');">
                                            <img src="<?php echo $thumbnailURL; ?>" alt="Thumbnail Tanda Tangan" class="img-preview">
                                        </a>
                                    </div>
                                <?php
                                } else {
                                    echo '<p style="color: red;">No ttd.</p>';
                                }
                                ?>
                            </div><br>
                            <?= $this->Usulan_model->getUsernameByLevel('gm'); ?>
                        </div>
                        <div class="col-xs-4 col-sm-2 text-center">
                            <div class="form-group" style="float: right;">
                                <label for="ttd_mb">Manager Bussiness</label>
                                <?php
                                $ttd_mb = isset($survey_data->ttd_mb) ? $survey_data->ttd_mb : '';
                                $thumbnailURL = './foto/foto_usulan/foto_ttd/' . $ttd_mb;

                                if (!empty($ttd_mb) && file_exists($thumbnailURL)) {
                                ?>
                                    <div class="mt-2">
                                        <a href="javascript:void(0);" onclick="openPopup('<?php echo $thumbnailURL; ?>');">
                                            <img src="<?php echo $thumbnailURL; ?>" alt="Thumbnail Tanda Tangan" class="img-preview">
                                        </a>
                                    </div>
                                <?php
                                } else {
                                    echo '<p style="color: red;">No ttd.</p>';
                                }
                                ?>
                            </div><br>
                            <?= $this->Usulan_model->getUsernameByLevel('mng_bisnis'); ?>
                        </div>
                        <div class="col-xs-4 col-sm-2 text-center">
                            <div class="form-group" style="float: right;">
                                <label for="ttd_mc">Manager Cabang</label>
                                <?php
                                $ttd_mc = isset($survey_data->ttd_mc) ? $survey_data->ttd_mc : '';
                                $thumbnailURL = './foto/foto_usulan/foto_ttd/' . $ttd_mc;

                                if (!empty($ttd_mc) && file_exists($thumbnailURL)) {
                                ?>
                                    <div class="mt-2">
                                        <a href="javascript:void(0);" onclick="openPopup('<?php echo $thumbnailURL; ?>');">
                                            <img src="<?php echo $thumbnailURL; ?>" alt="Thumbnail Tanda Tangan" class="img-preview">
                                        </a>
                                    </div>
                                <?php
                                } else {
                                    echo '<p style="color: red;">No ttd.</p>';
                                }
                                ?>
                            </div><br>
                            <?= $this->Usulan_model->getUsernameByLevelAndKantor('k_cabang', $survey_data->id_pby); ?>
                        </div>
                        <div class="col-xs-4 col-sm-2 text-center">
                            <div class="form-group" style="float: right;">
                                <label for="ttd_ad">Admin Cabang</label>
                                <?php
                                $ttd_ad = isset($survey_data->ttd_ad) ? $survey_data->ttd_ad : '';
                                $thumbnailURL = './foto/foto_usulan/foto_ttd/' . $ttd_ad;

                                if (!empty($ttd_ad) && file_exists($thumbnailURL)) {
                                ?>
                                    <div class="mt-2">
                                        <a href="javascript:void(0);" onclick="openPopup('<?php echo $thumbnailURL; ?>');">
                                            <img src="<?php echo $thumbnailURL; ?>" alt="Thumbnail Tanda Tangan" class="img-preview">
                                        </a>
                                    </div>
                                <?php
                                } else {
                                    echo '<p style="color: red;">No ttd.</p>';
                                }
                                ?>
                            </div><br>
                            <?php echo 'Admin ' . $kodeKantorText = getKodeKantorText($survey_data->kode_kantor); ?>
                            <!-- <?= $this->Usulan_model->getUsernameByLevelAndKantor('admin', $survey_data->id_pby); ?> -->
                        </div>
                        <div class="col-xs-4 col-sm-2 text-center">
                            <div class="form-group" style="float: right;">
                                <label for="ttd_mt">Marketing</label>
                                <?php
                                $ttd_mt = isset($survey_data->ttd_mt) ? $survey_data->ttd_mt : '';
                                $thumbnailURL = './foto/foto_usulan/foto_ttd/' . $ttd_mt;

                                if (!empty($ttd_mt) && file_exists($thumbnailURL)) {
                                ?>
                                    <div class="mt-2">
                                        <a href="javascript:void(0);" onclick="openPopup('<?php echo $thumbnailURL; ?>');">
                                            <img src="<?php echo $thumbnailURL; ?>" alt="Thumbnail Tanda Tangan" class="img-preview">
                                        </a>
                                    </div>
                                <?php
                                } else {
                                    echo '<p style="color: red;">No ttd.</p>';
                                }
                                ?>
                            </div><br>
                            <?php echo 'Marketing ' . $kodeKantorText = getKodeKantorText($survey_data->kode_kantor); ?>
                            <!-- <?= $this->Usulan_model->getUsernameByLevelAndKantor('marketing', $survey_data->id_pby); ?> -->
                        </div>
                        <div class="col-xs-4 col-sm-2 text-center">
                            <div class="form-group" style="float: right;">
                                <label for="ttd_sv">Surveyor</label>
                                <?php
                                $ttd_sv = isset($survey_data->ttd_sv) ? $survey_data->ttd_sv : '';
                                $thumbnailURL = './foto/foto_usulan/foto_ttd/' . $ttd_sv;

                                if (!empty($ttd_sv) && file_exists($thumbnailURL)) {
                                ?>
                                    <div class="mt-2">
                                        <a href="javascript:void(0);" onclick="openPopup('<?php echo $thumbnailURL; ?>');">
                                            <img src="<?php echo $thumbnailURL; ?>" alt="Thumbnail Tanda Tangan" class="img-preview">
                                        </a>
                                    </div>
                                <?php
                                } else {
                                    echo '<p style="color: red;">No ttd.</p>';
                                }
                                ?>
                            </div><br>
                            <?= $this->Usulan_model->getUsernameById($survey_data->surveyor); ?>
                        </div>

                        <div class="clearfix"></div>
                        <hr>

                        <!-- TTD -->

                        <!-- TTD GM -->
                        <?php if ($level == 'gm' || $level == 's_admin') : ?>
                            <div class="col-xs-12 col-sm-12 text-center">
                                <label for="ttd_gm">General Manager</label><br>
                                <canvas id="signature-pad-gm" width="300" height="200" style="border: 1px solid #000; border-radius: 10px;"></canvas>
                                <p><small>Tanda tangan GM</small></p>
                                <button type="button" id="clear-gm" class="btn btn-muted mt-2">Hapus</button>
                                <input type="hidden" name="ttd_gm" id="ttd_gm">
                            </div>
                        <?php endif; ?>

                        <!-- TTD Manager Business -->
                        <?php if ($level == 'mng_bisnis' || $level == 's_admin') : ?>
                            <div class="col-xs-12 col-sm-12 text-center">
                                <label for="ttd_mb">Manager Business</label><br>
                                <canvas id="signature-pad-mb" width="300" height="200" style="border: 1px solid #000; border-radius: 10px;"></canvas>
                                <p><small>Tanda tangan Manager Business</small></p>
                                <button type="button" id="clear-mb" class="btn btn-muted mt-2">Hapus</button>
                                <input type="hidden" name="ttd_mb" id="ttd_mb">
                            </div>
                        <?php endif; ?>

                        <!-- TTD Manager Cabang -->
                        <?php if ($level == 'k_cabang' || $level == 's_admin') : ?>
                            <div class="col-xs-12 col-sm-12 text-center">
                                <label for="ttd_mc">Manager Cabang</label><br>
                                <canvas id="signature-pad-mc" width="300" height="200" style="border: 1px solid #000; border-radius: 10px;"></canvas>
                                <p><small>Tanda tangan Manager Cabang</small></p>
                                <button type="button" id="clear-mc" class="btn btn-muted mt-2">Hapus</button>
                                <input type="hidden" name="ttd_mc" id="ttd_mc">
                            </div>
                        <?php endif; ?>

                        <!-- TTD Admin -->
                        <?php if ($level == 'admin' || $level == 's_admin') : ?>
                            <div class="col-xs-12 col-sm-12 text-center">
                                <label for="ttd_ad">Admin Cabang</label><br>
                                <canvas id="signature-pad-ad" width="300" height="200" style="border: 1px solid #000; border-radius: 10px;"></canvas>
                                <p><small>Tanda tangan Admin Cabang</small></p>
                                <button type="button" id="clear-ad" class="btn btn-muted mt-2">Hapus</button>
                                <input type="hidden" name="ttd_ad" id="ttd_ad">
                            </div>
                        <?php endif; ?>

                        <!-- TTD Marketing -->
                        <?php if ($level == 'marketing' || $level == 's_admin') : ?>
                            <div class="col-xs-12 col-sm-12 text-center">
                                <label for="ttd_mt">Marketing</label><br>
                                <canvas id="signature-pad-mt" width="300" height="200" style="border: 1px solid #000; border-radius: 10px;"></canvas>
                                <p><small>Tanda tangan Marketing</small></p>
                                <button type="button" id="clear-mt" class="btn btn-muted mt-2">Hapus</button>
                                <input type="hidden" name="ttd_mt" id="ttd_mt">
                            </div>
                        <?php endif; ?>

                        <!-- TTD Surveyor -->
                        <?php if ($cek->id_user == $survey_data->surveyor  || $level == 's_admin') : ?>
                            <div class="col-xs-12 col-sm-12 text-center">
                                <label for="ttd_sv">Surveyor</label><br>
                                <canvas id="signature-pad-sv" width="300" height="200" style="border: 1px solid #000; border-radius: 10px;"></canvas>
                                <p><small>Tanda tangan Surveyor</small></p>
                                <button type="button" id="clear-sv" class="btn btn-muted mt-2">Hapus</button>
                                <input type="hidden" name="ttd_sv" id="ttd_sv">
                            </div>
                        <?php endif; ?>

                        <div class="col-xs-12 col-sm-12">
                            <form method="post" id="checklistForm">
                                <button type="submit" class="btn btn-danger" id="kirimButton" style="float: right;"> Update</button>
                            </form>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Edit Survey Form -->
    </div>
</div>

<!-- Tambahkan pustaka Leaflet dan Leaflet Control Geocoder -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    function initMap() {
        var defaultLocation = [-7.150975, 110.140259]; // Jawa Tengah coordinates
        var map = L.map('map').setView(defaultLocation, 8);


        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {

        }).addTo(map);

        // Tambahkan pencarian lokasi
        var geocoder = L.Control.Geocoder.nominatim();
        var control = L.Control.geocoder({
            geocoder: geocoder,
            defaultMarkGeocode: false
        }).on('markgeocode', function(event) {
            var location = event.geocode.center;
            map.setView(location, map.getZoom());
            updateLocationInput(location);
        }).addTo(map);

        var marker = L.marker(defaultLocation, {
            draggable: true
        }).addTo(map);

        marker.on('dragend', function(event) {
            updateLocationInput(event.target.getLatLng());
        });

        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            updateLocationInput(e.latlng);
        });

        function updateLocationInput(location) {
            document.getElementById('lokasi').value = location.lat + ', ' + location.lng;
        }
    }

    initMap();

    // function changeColor(selectElement) {
    //     if (selectElement.value == "1") {
    //         selectElement.style.backgroundColor = "#d4edda"; 
    //         selectElement.style.color = "#155724"; 
    //     } else if (selectElement.value == "0") {
    //         selectElement.style.backgroundColor = "#fff3cd"; 
    //         selectElement.style.color = "#856404"; 
    //     }
    // }

    // Panggil fungsi untuk mengatur warna awal saat halaman dimuat
    // document.addEventListener("DOMContentLoaded", function() {
    //     changeColor(document.getElementById("status_analisa"));
    // });

    function calculateTotal() {
        // Get values from the input fields
        const labaUsahaBayar = parseFloat(document.getElementById('laba_usaha_bayar').value) || 0;
        const pendapatanIstri = parseFloat(document.getElementById('pendapatan_istri').value) || 0;
        const pendapatanLain = parseFloat(document.getElementById('pendapatan_lain').value) || 0;

        // Calculate the total
        const totalPendapatan = labaUsahaBayar + pendapatanIstri + pendapatanLain;

        // Set the total value to the input for jml_pendapatan_diterima
        document.getElementById('jml_pendapatan_diterima').value = totalPendapatan;
    }

    function calculateLabaUsaha() {
        // Get values from the input fields
        const jmlPenjualan = parseFloat(document.getElementById('jml_penjualan').value) || 0;
        const hrgPokokBrg = parseFloat(document.getElementById('hrg_pokok_brg').value) || 0;
        const biayaUsaha = parseFloat(document.getElementById('biaya_usaha').value) || 0;

        // Calculate Laba Usaha
        const labaUsaha = (jmlPenjualan * hrgPokokBrg) - biayaUsaha;

        // Set the calculated value to the laba_usaha input
        document.getElementById('laba_usaha').value = labaUsaha;
    }

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

    // script TTD

    document.addEventListener('DOMContentLoaded', function() {
        // Array for storing the canvas id, clear button id, and hidden input id
        const signaturePads = [{
                canvasId: 'signature-pad-gm',
                clearButtonId: 'clear-gm',
                inputId: 'ttd_gm'
            },
            {
                canvasId: 'signature-pad-mb',
                clearButtonId: 'clear-mb',
                inputId: 'ttd_mb'
            },
            {
                canvasId: 'signature-pad-mc',
                clearButtonId: 'clear-mc',
                inputId: 'ttd_mc'
            },
            {
                canvasId: 'signature-pad-ad',
                clearButtonId: 'clear-ad',
                inputId: 'ttd_ad'
            },
            {
                canvasId: 'signature-pad-mt',
                clearButtonId: 'clear-mt',
                inputId: 'ttd_mt'
            },
            {
                canvasId: 'signature-pad-sv',
                clearButtonId: 'clear-sv',
                inputId: 'ttd_sv'
            }
        ];

        signaturePads.forEach(function(pad) {
            const canvas = document.getElementById(pad.canvasId);
            const clearButton = document.getElementById(pad.clearButtonId);
            const input = document.getElementById(pad.inputId);

            if (!canvas || !clearButton || !input) return;

            const ctx = canvas.getContext('2d');
            let drawing = false;

            // Disable scroll when drawing
            function disableScroll() {
                document.body.style.overflow = 'hidden';
            }

            function enableScroll() {
                document.body.style.overflow = 'auto';
            }

            // Start drawing
            function startDrawing(event) {
                drawing = true;
                ctx.beginPath();
                disableScroll();
            }

            // Stop drawing
            function stopDrawing() {
                drawing = false;
                enableScroll();
            }

            // Draw on the canvas
            function draw(event) {
                if (!drawing) return;

                const rect = canvas.getBoundingClientRect();
                let x, y;

                if (event.type.includes('mouse')) {
                    x = event.clientX - rect.left;
                    y = event.clientY - rect.top;
                } else if (event.type.includes('touch')) {
                    const touch = event.touches[0];
                    x = touch.clientX - rect.left;
                    y = touch.clientY - rect.top;
                }

                ctx.lineTo(x, y);
                ctx.strokeStyle = 'black';
                ctx.lineWidth = 2;
                ctx.stroke();
            }

            // Event listeners for desktop and mobile devices
            canvas.addEventListener('mousedown', startDrawing);
            canvas.addEventListener('mouseup', stopDrawing);
            canvas.addEventListener('mousemove', draw);

            canvas.addEventListener('touchstart', startDrawing, {
                passive: false
            });
            canvas.addEventListener('touchend', stopDrawing);
            canvas.addEventListener('touchmove', draw, {
                passive: false
            });

            // Clear the canvas when the clear button is clicked
            clearButton.addEventListener('click', function() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                input.value = ''; // Clear the hidden input
            });

            // Update the hidden input with the canvas data
            document.getElementById('checklistForm').addEventListener('submit', function() {
                signaturePads.forEach(function(pad) {
                    const canvas = document.getElementById(pad.canvasId);
                    const input = document.getElementById(pad.inputId);

                    if (canvas && input) {
                        input.value = canvas.toDataURL();
                    }
                });
            });
        });
    });


    // Inisialisasi Select2
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
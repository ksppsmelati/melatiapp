<?php
$cek = $user->row();
$analyst = $cek->id_user;
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
                        <i class="fa fa-poll"></i> Edit Form Survey <br>
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
                    <form method="post" action="<?= base_url('users/analisa_edit/' . $survey_data->id_pby); ?>">
                        <ul class="branch">
                            <li class="branch-item">
                                <div class="branch-title">
                                    <h4 class="text-bold"><i class="fa fa-person"></i> Data Pemohon</h4>
                                    <div class="marker-icon"><i class="fa-solid fa-caret-down"></i></div>
                                </div>
                                <div class="branch-details">
                                    <input type="hidden" name="id_pby" id="id_pby" class="form-control" required value="<?= $survey_data->id_pby; ?>">
                                    <input type="hidden" name="analyst" id="analyst" class="form-control" required value="<?= $analyst; ?>">
                                    <input type="hidden" name="tgl_analisa" id="tgl_analisa" class="form-control" required value="<?= date('Y-m-d'); ?>">
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
                                            <input type="text" name="pekerjaan_sampingan" id="pekerjaan_sampingan" class="form-control" value="<?= isset($survey_data->pekerjaan_sampingan) ? $survey_data->pekerjaan_sampingan : ''; ?>" placeholder="Masukan pekerjaan sampingan">
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
                                            <input type="text" name="tujuan" id="tujuan" class="form-control" value="<?= $survey_data->tujuan; ?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="bidang_usaha">Bidang Usaha</label>
                                            <input type="text" name="bidang_usaha" id="bidang_usaha" class="form-control" value="<?= isset($survey_data->bidang_usaha) ? $survey_data->bidang_usaha : ''; ?>" placeholder="Masukan bidang usaha">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="sumber_pelunasan">Sumber Pelunasan</label>
                                            <select name="sumber_pelunasan" id="sumber_pelunasan" class="form-control">
                                                <option value="gaji">Gaji</option>
                                                <option value="hasil_usaha">Hasil Usaha</option>
                                                <option value="lainya">Lainya</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="jangka_waktu">Jangka Waktu</label>
                                            <select class="form-control" name="jangka_waktu" id="jangka_waktu">
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
                                                <option value="permanen">Permanen</option>
                                                <option value="semi_permanen">Semi Permanen</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="sumber_info">Sumber Informasi / Cek Ling</label>
                                            <textarea name="sumber_info" id="sumber_info" class="form-control" placeholder="Tulis Sumber Info" rows="10"><?= isset($survey_data->sumber_info) ? $survey_data->sumber_info : ''; ?></textarea>
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

                                    <div class="clearfix"></div>
                                    <h1 class="text-bold">Kalkulasi kebutuhan modal usaha</h1>
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
                                                <input type="text" name="bpkb" id="bpkb" class="form-control" readonly value="<?= isset($survey_data->bpkb) ? $survey_data->bpkb : ''; ?>" placeholder="Masukan nomor BPKB">
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                            <div class="form-group">
                                                <label for="jns_kendaraan">Jenis Kendaraan</label>
                                                <input type="text" name="jns_kendaraan" id="jns_kendaraan" class="form-control" readonly value="<?= isset($survey_data->jns_kendaraan) ? $survey_data->jns_kendaraan : ''; ?>" placeholder="Masukan jenis kendaraan">
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
                                                <input type="text" name="merk" id="merk" class="form-control" value="<?= isset($survey_data->merk) ? $survey_data->merk : ''; ?>" placeholder="Masukan merk">
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
                                                <input type="text" name="tipe" id="tipe" class="form-control" value="<?= isset($survey_data->tipe) ? $survey_data->tipe : ''; ?>" placeholder="Masukan tipe">
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
                                        <div class="col-xs-6 col-sm-6">
                                            <div class="form-group">
                                                <label for="nilai_likuid">Nilai Likuiditas</label>
                                                <input type="number" name="nilai_likuid" id="nilai_likuid" class="form-control" value="<?= isset($survey_data->nilai_likuid) ? $survey_data->nilai_likuid : ''; ?>" placeholder="Masukan nominal nilai likuiditas">
                                            </div>
                                        </div>
                                    <?php } elseif (isset($survey_data->jaminan) && $survey_data->jaminan == 'sertifikat') { ?>
                                        <div class="col-xs-6 col-sm-6">
                                            <div class="form-group">
                                                <label for="sertifikat">Nomor Sertifikat</label>
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
                                                <label for="jenis_tanah">Jenis Tanah</label>
                                                <select name="jenis_tanah" id="jenis_tanah" class="form-control">
                                                    <option value="">-- Pilih Jenis Tanah --</option>
                                                    <option value="darat" <?= ($survey_data->jenis_tanah == 'darat') ? 'selected' : ''; ?>>Darat</option>
                                                    <option value="ladang" <?= ($survey_data->jenis_tanah == 'ladang') ? 'selected' : ''; ?>>Ladang</option>
                                                    <option value="sawah" <?= ($survey_data->jenis_tanah == 'sawah') ? 'selected' : ''; ?>>Sawah</option>
                                                    <option value="lainnya" <?= ($survey_data->jenis_tanah == 'lainnya') ? 'selected' : ''; ?>>Lainnya</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                            <div class="form-group">
                                                <label for="akses_jalan">Akses Jalan</label>
                                                <select name="akses_jalan" id="akses_jalan" class="form-control" required>
                                                    <option value="">-- Pilih Akses Jalan --</option>
                                                    <option value="aspal" <?= ($survey_data->akses_jalan == 'aspal') ? 'selected' : ''; ?>>Aspal</option>
                                                    <option value="semen" <?= ($survey_data->akses_jalan == 'semen') ? 'selected' : ''; ?>>Semen</option>
                                                    <option value="tanah" <?= ($survey_data->akses_jalan == 'tanah') ? 'selected' : ''; ?>>Tanah</option>
                                                    <option value="lainnya" <?= ($survey_data->akses_jalan == 'lainnya') ? 'selected' : ''; ?>>Lainnya</option>
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
                                <label for="tgl_cek_bi">Tanggal Cek BI</label>
                                <input type="date" name="tgl_cek_bi" id="tgl_cek_bi" class="form-control" value="<?= isset($survey_data->tgl_cek_bi) ? $survey_data->tgl_cek_bi : ''; ?>">
                            </div>
                        </div>

                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label for="slik">Slik</label><br>
                                <?php if ($survey_data->category === 'SLIK') : ?>
                                    <a href="<?php echo base_url('users/file_user_lihat_id_pby/' . $survey_data->id_pby); ?>" class="btn btn-xs" style="background-color: #6f42c1; color: white;" title="Lihat File SLIK">
                                        <i class="fa-solid fa-book-open"></i>
                                    </a>
                                <?php else : ?>
                                    <button class="btn btn-xs" style="background-color: #e83e8c; color: white;" title="Data SLIK Tidak Ada">
                                        <i class="fa-solid fa-times"></i>
                                    </button>
                                <?php endif; ?>
                                <a href="<?php echo site_url('users/file_user_id_pby_upload/' . $survey_data->id_pby); ?>" class="btn btn-light btn-xs" style="background-color: #6c757d; color: white;"><i class="fa fa-upload" aria-hidden="true"></i></a>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <!-- Input untuk Status Analisa -->
                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label for="status_analisa">Status Analisa</label>
                                <select name="status_analisa" id="status_analisa" class="form-control" onchange="changeColor(this)">
                                    <option value="" <?= (is_null($survey_data->status_analisa)) ? 'selected' : ''; ?>>-- Pilih Status --</option>
                                    <option value="0" <?= (isset($survey_data->status_analisa) && $survey_data->status_analisa === '0') ? 'selected' : ''; ?>>Not Checked</option>
                                    <option value="1" <?= (isset($survey_data->status_analisa) && $survey_data->status_analisa === '1') ? 'selected' : ''; ?>>Checked</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label for="hasil_analisa">Hasil Analisa</label>
                                <select name="hasil_analisa" id="hasil_analisa" class="form-control">
                                    <option value="" <?= (is_null($survey_data->hasil_analisa)) ? 'selected' : ''; ?>>-- Pilih Status --</option>
                                    <option value="1" <?= (isset($survey_data->hasil_analisa) && $survey_data->hasil_analisa === '1') ? 'selected' : ''; ?>>Tidak Rekomendasi</option>
                                    <option value="2" <?= (isset($survey_data->hasil_analisa) && $survey_data->hasil_analisa === '2') ? 'selected' : ''; ?>>Pertimbangkan</option>
                                    <option value="3" <?= (isset($survey_data->hasil_analisa) && $survey_data->hasil_analisa === '3') ? 'selected' : ''; ?>>Rekomendasi</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12">
                            <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <textarea name="keterangan" id="keterangan" class="form-control" placeholder="Tulis Keterangan" rows="5"><?= isset($survey_data->keterangan) ? $survey_data->keterangan : ''; ?></textarea>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12">
                            <form method="post" id="checklistForm">
                                <!-- Tambahkan kolom lainnya sesuai dengan data survei -->
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

    function changeColor(selectElement) {
        if (selectElement.value == "1") {
            selectElement.style.backgroundColor = "#d4edda"; // Warna hijau muda
            selectElement.style.color = "#155724"; // Warna teks hijau gelap
        } else if (selectElement.value == "0") {
            selectElement.style.backgroundColor = "#fff3cd"; // Warna kuning muda
            selectElement.style.color = "#856404"; // Warna teks kuning gelap
        }
    }

    // Panggil fungsi untuk mengatur warna awal saat halaman dimuat
    document.addEventListener("DOMContentLoaded", function() {
        changeColor(document.getElementById("status_analisa"));
    });

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
</script>
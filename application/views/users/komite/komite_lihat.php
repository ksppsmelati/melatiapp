<style>
    label {
        font-weight: bold;
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
<div class="container">
    <div class="content">
        <!-- Survey detail content -->
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <i class="fa fa-file-text"></i> Detail Survey - <strong onclick="copyToClipboard('<?php echo date('Ymd') . '_PBY' . $survey_detail->id_pby; ?>')"> <?php echo 'PBY' . $survey_detail->id_pby; ?></strong><br>
                    <span style="font-size: 80%; opacity: 0.7;">Tgl Survey : <?php echo date('d-m-Y', strtotime($survey_detail->tgl_survey)); ?></span>
                    <span style="font-size: 80%; opacity: 0.7;"> | <?php echo $this->Usulan_model->getUsernameById($survey_detail->surveyor); ?></span>
                    <hr>
                    <div class="row">
                        <ul class="branch">
                            <li class="branch-item">
                                <div class="branch-title">
                                    <h4 class="text-bold"><i class="fa fa-person"></i> Data Pemohon</h4>
                                    <div class="marker-icon"><i class="fa-solid fa-caret-down"></i></div>
                                </div>
                                <div class="branch-details">
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Nama Lengkap</label>
                                            <p class="form-control" onclick="copyToClipboard('<?php echo $survey_detail->nama; ?>')">
                                                <?php echo $survey_detail->nama; ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label>NIK</label>
                                            <p class="form-control" onclick="copyToClipboard('<?php echo $survey_detail->nik; ?>')"><?php echo $survey_detail->nik; ?></p>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="foto_ktp">Foto KTP<span style="color: red;">*</span></label>

                                            <?php
                                            // Ambil nama file foto_ktp dari data usulan_data
                                            $foto_ktp = isset($survey_detail->foto_ktp) ? $survey_detail->foto_ktp : '';

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
                                            <label>Nama Ibu</label>
                                            <p class="form-control" onclick="copyToClipboard('<?php echo $survey_detail->nama_ibu; ?>')"><?php echo $survey_detail->nama_ibu; ?></p>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Jenis Kelamin</label>
                                            <p class="form-control" onclick="copyToClipboard('<?php echo ($survey_detail->jk == 'L') ? 'Laki-laki' : 'Perempuan'; ?>')">
                                                <?php echo ($survey_detail->jk == 'L') ? 'Laki-laki' : 'Perempuan'; ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Tgl Lahir</label>
                                            <p class="form-control" onclick="copyToClipboard('<?php echo $survey_detail->tgl_lahir; ?>')"><?php echo $survey_detail->tgl_lahir; ?></p>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Tempat Lahir</label>
                                            <p class="form-control" onclick="copyToClipboard('<?php echo $survey_detail->tempat_lahir; ?>')"><?php echo $survey_detail->tempat_lahir; ?></p>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Negara</label>
                                            <p class="form-control" onclick="copyToClipboard('<?php echo $survey_detail->negara; ?>')"><?php echo $survey_detail->negara; ?></p>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Status Kawin</label>
                                            <p class="form-control" onclick="copyToClipboard('<?php echo $survey_detail->status_kawin; ?>')"><?php echo $survey_detail->status_kawin; ?></p>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Status Pendidikan</label>
                                            <p class="form-control" onclick="copyToClipboard('<?php echo $survey_detail->status_pendidikan; ?>')"><?php echo $survey_detail->status_pendidikan; ?></p>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Jenis Alamat</label>
                                            <p class="form-control" onclick="copyToClipboard('<?php echo $survey_detail->jns_alamat; ?>')"><?php echo $survey_detail->jns_alamat; ?></p>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Dusun RT/RW</label>
                                            <p class="form-control" onclick="copyToClipboard('<?php echo $survey_detail->alamat; ?>')"><?php echo $survey_detail->alamat; ?></p>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Kelurahan</label>
                                            <p class="form-control" onclick="copyToClipboard('<?php echo $survey_detail->kelurahan_nama; ?>')"><?php echo $survey_detail->kelurahan_nama; ?></p> <!-- Display Kelurahan name -->
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Kecamatan</label>
                                            <p class="form-control" onclick="copyToClipboard('<?php echo $survey_detail->kecamatan_nama; ?>')"><?php echo $survey_detail->kecamatan_nama; ?></p> <!-- Display Kecamatan name -->
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Kota/Kabupaten</label>
                                            <p class="form-control" onclick="copyToClipboard('<?php echo $survey_detail->kota_nama; ?>')"><?php echo $survey_detail->kota_nama; ?></p> <!-- Display Kota/Kabupaten name -->
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Kode POS</label>
                                            <p class="form-control" onclick="copyToClipboard('<?php echo $survey_detail->kode_pos; ?>')"><?php echo $survey_detail->kode_pos; ?></p>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Alamat Usaha/Kantor</label>
                                            <p class="form-control" onclick="copyToClipboard('<?php echo $survey_detail->alamat_usaha; ?>')"><?php echo $survey_detail->alamat_usaha; ?></p>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Pekerjaan Pokok</label>
                                            <p class="form-control" onclick="copyToClipboard('<?php echo $survey_detail->pekerjaan; ?>')"><?php echo $survey_detail->pekerjaan; ?></p>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Pekerjaan Sampingan</label>
                                            <p class="form-control" onclick="copyToClipboard('<?php echo $survey_detail->pekerjaan_sampingan; ?>')"><?php echo $survey_detail->pekerjaan_sampingan; ?></p>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Plafon Usulan</label>
                                            <p class="form-control"><span class="badge badge-success"><?php echo 'Rp ' . number_format($survey_detail->nominal, 0, ',', '.'); ?></span></p>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <div class="clearfix"></div>

                            <li class="branch-item">
                                <div class="branch-title">
                                    <h4 class="text-bold"><i class="fa fa-archive"></i> Data Jaminan <?php echo $survey_detail->jaminan; ?></h4>
                                    <div class="marker-icon"><i class="fa-solid fa-caret-down"></i></div>
                                </div>
                                <div class="branch-details">
                                    <?php if ($survey_detail->jaminan == 'bpkb') : ?>
                                        <div class="col-xs-6 col-sm-6">
                                            <div class="form-group">
                                                <label>No. BPKB</label>
                                                <p class="form-control"><?php echo $survey_detail->bpkb; ?></p>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                            <div class="form-group">
                                                <label>Jenis Kendaraan</label>
                                                <p class="form-control">
                                                    <?php
                                                    if (isset($survey_detail->jns_kendaraan)) {
                                                        switch ($survey_detail->jns_kendaraan) {
                                                            case '2':
                                                                echo 'Roda 2 (Sepeda Motor)';
                                                                break;
                                                            case '4':
                                                                echo 'Roda 4 (Mobil)';
                                                                break;
                                                            case '6':
                                                                echo 'Roda 6 (Truk)';
                                                                break;
                                                            case '8':
                                                                echo 'Roda 8 (Bus)';
                                                                break;
                                                            case 'lainnya':
                                                                echo 'Lainnya';
                                                                break;
                                                            default:
                                                                echo '-';
                                                                break;
                                                        }
                                                    } else {
                                                        echo '-'; // Jika tidak ada nilai, tampilkan '-'
                                                    }
                                                    ?>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                            <div class="form-group">
                                                <label>Tahun Pembuatan</label>
                                                <p class="form-control"><?php echo $survey_detail->thn_pembuatan; ?></p>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                            <div class="form-group">
                                                <label>Merk</label>
                                                <p class="form-control"><?php echo $survey_detail->merk; ?></p>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                            <div class="form-group">
                                                <label>Nomor Mesin</label>
                                                <p class="form-control"><?php echo $survey_detail->no_mesin; ?></p>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                            <div class="form-group">
                                                <label>Tipe</label>
                                                <p class="form-control"><?php echo $survey_detail->tipe; ?></p>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                            <div class="form-group">
                                                <label>Nomor Rangka</label>
                                                <p class="form-control"><?php echo $survey_detail->no_rangka; ?></p>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                            <div class="form-group">
                                                <label>Nomor Polisi</label>
                                                <p class="form-control"><?php echo $survey_detail->no_pol; ?></p>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                            <div class="form-group">
                                                <label>Kepemilikan</label>
                                                <p class="form-control"><?php echo $survey_detail->kepemilikan; ?></p>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                            <div class="form-group">
                                                <label>Atas Nama</label>
                                                <p class="form-control"><?php echo $survey_detail->an; ?></p>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                            <div class="form-group">
                                                <label>Alamat Atas Nama</label>
                                                <p class="form-control"><?php echo $survey_detail->an_alamat; ?></p>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                            <div class="form-group">
                                                <label>Nilai Pasar</label>
                                                <p class="form-control"><?php echo $survey_detail->nilai_pasar; ?></p>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                            <div class="form-group">
                                                <label>Nilai Likuiditas</label>
                                                <p class="form-control"><?php echo $survey_detail->nilai_likuid; ?></p>
                                            </div>
                                        </div>
                                    <?php elseif ($survey_detail->jaminan == 'sertifikat') : ?>
                                        <div class="col-xs-6 col-sm-6">
                                            <div class="form-group">
                                                <label>No. Sertifikat (SHM)</label>
                                                <p class="form-control"><?php echo $survey_detail->sertifikat; ?></p>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                            <div class="form-group">
                                                <label>Atas Nama Sertifikat</label>
                                                <p class="form-control"><?php echo $survey_detail->an_sertifikat; ?></p>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                            <div class="form-group">
                                                <label>Luas</label>
                                                <p class="form-control"><?php echo $survey_detail->luas; ?></p>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                            <div class="form-group">
                                                <label>Alamat Lokasi Tanah</label>
                                                <p class="form-control"><?php echo $survey_detail->alamat_lokasi; ?></p>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                            <div class="form-group">
                                                <label>Map</label>
                                                <?php
                                                $lokasi = $survey_detail->lokasi;
                                                $map_link = !empty($lokasi) ? "https://www.google.com/maps?q={$lokasi}" : null;
                                                ?>

                                                <p>
                                                    <?php if ($map_link) : ?>
                                                        <a href="<?php echo $map_link; ?>" target="_blank"><i class="fas fa-map-marker-alt"></i> Lihat Lokasi</a>
                                                    <?php else : ?>
                                                        -
                                                    <?php endif; ?>
                                                </p>
                                            </div>
                                        </div>

                                        <div class="col-xs-6 col-sm-6">
                                            <div class="form-group">
                                                <label>Jarak</label>
                                                <p class="form-control"><?php echo $survey_detail->jarak; ?></p>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                            <div class="form-group">
                                                <label>Untuk Mencapai Lokasi</label>
                                                <p class="form-control"><?php echo $survey_detail->capai_lokasi; ?></p>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                            <div class="form-group">
                                                <label>Bentuk Tanah</label>
                                                <p class="form-control"><?php echo $survey_detail->bentuk_tanah; ?></p>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                            <div class="form-group">
                                                <label>Jenis Tanah</label>
                                                <p class="form-control"><?php echo $survey_detail->jenis_tanah; ?></p>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                            <div class="form-group">
                                                <label>Nilai Pasar Wajar</label>
                                                <p class="form-control"><?php echo $survey_detail->nilai_pasar_wajar; ?></p>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                            <div class="form-group">
                                                <label>Nilai Likuiditas Tanah</label>
                                                <p class="form-control"><?php echo $survey_detail->nilai_likuid_t; ?></p>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                            <div class="form-group">
                                                <label>Kepemilikan Tanah</label>
                                                <p class="form-control"><?php echo $survey_detail->kepemilikan_t; ?></p>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Inpuser</label>
                                            <p class="form-control"><?php echo $this->Usulan_model->getUsernameById($survey_detail->id_user); ?></p>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Surveyor</label>
                                            <p class="form-control"><?php echo $this->Usulan_model->getUsernameById($survey_detail->surveyor); ?></p>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12">
                                        <div class="form-group">
                                            <label>Catatan</label>
                                            <p><?php echo htmlspecialchars($survey_detail->catatan); ?></p>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="foto_jaminan_1">Foto 1</label>
                                            <?php
                                            $foto_jaminan_1 = isset($survey_detail->foto_jaminan_1) ? $survey_detail->foto_jaminan_1 : '';
                                            $thumbnailURL = './foto/foto_usulan/' . $foto_jaminan_1;
                                            if (!empty($foto_jaminan_1) && file_exists($thumbnailURL)) {
                                            ?>
                                                <div class="mt-2">
                                                    <a href="javascript:void(0);" onclick="openPopup('<?php echo $thumbnailURL; ?>');">
                                                        <img src="<?php echo $thumbnailURL; ?>" alt="Thumbnail foto_jaminan_1" class="img-preview" style="max-width: 100px;">
                                                    </a>
                                                </div>
                                            <?php
                                            } else {
                                            ?>
                                                <div class="mt-2">
                                                    <p>N/A</p>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="foto_jaminan_2">Foto 2</label>
                                            <?php
                                            $foto_jaminan_2 = isset($survey_detail->foto_jaminan_2) ? $survey_detail->foto_jaminan_2 : '';
                                            $thumbnailURL = './foto/foto_usulan/' . $foto_jaminan_2;
                                            if (!empty($foto_jaminan_2) && file_exists($thumbnailURL)) {
                                            ?>
                                                <div class="mt-2">
                                                    <a href="javascript:void(0);" onclick="openPopup('<?php echo $thumbnailURL; ?>');">
                                                        <img src="<?php echo $thumbnailURL; ?>" alt="Thumbnail foto_jaminan_2" class="img-preview" style="max-width: 100px;">
                                                    </a>
                                                </div>
                                            <?php
                                            } else {
                                            ?>
                                                <div class="mt-2">
                                                    <p>N/A</p>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="foto_jaminan_3">Foto 3</label>
                                            <?php
                                            $foto_jaminan_3 = isset($survey_detail->foto_jaminan_3) ? $survey_detail->foto_jaminan_3 : '';
                                            $thumbnailURL = './foto/foto_usulan/' . $foto_jaminan_3;
                                            if (!empty($foto_jaminan_3) && file_exists($thumbnailURL)) {
                                            ?>
                                                <div class="mt-2">
                                                    <a href="javascript:void(0);" onclick="openPopup('<?php echo $thumbnailURL; ?>');">
                                                        <img src="<?php echo $thumbnailURL; ?>" alt="Thumbnail foto_jaminan_3" class="img-preview" style="max-width: 100px;">
                                                    </a>
                                                </div>
                                            <?php
                                            } else {
                                            ?>
                                                <div class="mt-2">
                                                    <p>N/A</p>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="foto_jaminan_4">Foto 4</label>
                                            <?php
                                            $foto_jaminan_4 = isset($survey_detail->foto_jaminan_4) ? $survey_detail->foto_jaminan_4 : '';
                                            $thumbnailURL = './foto/foto_usulan/' . $foto_jaminan_4;
                                            if (!empty($foto_jaminan_4) && file_exists($thumbnailURL)) {
                                            ?>
                                                <div class="mt-2">
                                                    <a href="javascript:void(0);" onclick="openPopup('<?php echo $thumbnailURL; ?>');">
                                                        <img src="<?php echo $thumbnailURL; ?>" alt="Thumbnail foto_jaminan_4" class="img-preview" style="max-width: 100px;">
                                                    </a>
                                                </div>
                                            <?php
                                            } else {
                                            ?>
                                                <div class="mt-2">
                                                    <p>N/A</p>
                                                </div>
                                            <?php
                                            }
                                            ?>
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

                                </div>
                            </li>
                            <div class="clearfix"></div>

                            <li class="branch-item">
                                <div class="branch-title">
                                    <h4 class="text-bold"><i class="fa-solid fa-chart-pie"></i> Data Analisa</h4>
                                    <div class="marker-icon"><i class="fa-solid fa-caret-down"></i></div>
                                </div>
                                <div class="branch-details">
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Riwayat Pembiayaan</label>
                                            <?php
                                            $riwayat_pembiayaan = $survey_detail->riwayat_pembiayaan;

                                            $badge_class = '';
                                            if ($riwayat_pembiayaan === 'lancar') {
                                                $badge_class = 'badge badge-success';
                                            } elseif ($riwayat_pembiayaan === 'kurang') {
                                                $badge_class = 'badge badge-primary';
                                            } elseif ($riwayat_pembiayaan === 'diragukan') {
                                                $badge_class = 'badge badge-warning';
                                            } elseif ($riwayat_pembiayaan === 'macet') {
                                                $badge_class = 'badge badge-danger';
                                            } else {
                                                // Default case, you may want to handle it differently based on your requirements
                                                $badge_class = 'badge badge-secondary';
                                            }
                                            ?>
                                            <p class="form-control"><span class="<?php echo $badge_class; ?>"><?php echo $riwayat_pembiayaan; ?></span></p>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Tujuan</label>
                                            <p class="form-control" onclick="copyToClipboard('<?php echo $survey_detail->tujuan; ?>')"><?php echo $survey_detail->tujuan; ?></p>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Bidang Usaha</label>
                                            <p class="form-control" onclick="copyToClipboard('<?php echo $survey_detail->bidang_usaha; ?>')"><?php echo $survey_detail->bidang_usaha; ?></p>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Sumber Pelunasan</label>
                                            <p class="form-control" onclick="copyToClipboard('<?php echo $survey_detail->sumber_pelunasan; ?>')"><?php echo $survey_detail->sumber_pelunasan; ?></p>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Telepon</label>
                                            <p class="form-control" onclick="copyToClipboard('<?php echo $survey_detail->telepon; ?>')"><?php echo $survey_detail->telepon; ?></p>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Jangka Waktu</label>
                                            <p class="form-control" onclick="copyToClipboard('<?php echo $survey_detail->jangka_waktu; ?>')"><?php echo $survey_detail->jangka_waktu; ?></p>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Jenis Jaminan</label>
                                            <p class="form-control" onclick="copyToClipboard('<?php echo $survey_detail->jaminan; ?>')"><span class="badge badge-success"><?php echo $survey_detail->jaminan; ?></span></p>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6" style="display: none;">
                                        <div class="form-group">
                                            <label>Jam Mulai Survey</label>
                                            <p class="form-control"><?php echo $survey_detail->jam_mulai; ?></p>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6" style="display: none;">
                                        <div class="form-group">
                                            <label>Jam Selesai Survey</label>
                                            <p class="form-control"><?php echo $survey_detail->jam_selesai; ?></p>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Tempat Survey</label>
                                            <p class="form-control"><?php echo $survey_detail->tempat_survey; ?></p>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Kondisi Rumah</label>
                                            <p class="form-control"><?php echo $survey_detail->kondisi_rumah; ?></p>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Kekayaan 1</label>
                                            <p class="form-control"><?php echo $survey_detail->kekayaan1; ?></p>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Harga Taksiran Kekayaan 1</label>
                                            <p class="form-control"><?php echo $survey_detail->harga_taksiran1; ?></p>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Kekayaan 2</label>
                                            <p class="form-control"><?php echo $survey_detail->kekayaan2; ?></p>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Harga Taksiran Kekayaan 2</label>
                                            <p class="form-control"><?php echo $survey_detail->harga_taksiran2; ?></p>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Sumber Informasi</label>
                                            <p class="form-control"><?php echo $survey_detail->sumber_info; ?></p>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Penjualan Usaha Per</label>
                                            <p class="form-control"><?php echo $survey_detail->penjualan_usaha; ?></p>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Jumlah Penjualan</label>
                                            <p class="form-control"><?php echo $survey_detail->jml_penjualan; ?></p>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Harga Pokok Barang</label>
                                            <p class="form-control"><?php echo $survey_detail->hrg_pokok_brg; ?></p>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Biaya Usaha</label>
                                            <p class="form-control"><?php echo $survey_detail->biaya_usaha; ?></p>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Laba Usaha</label>
                                            <p class="form-control"><?php echo $survey_detail->laba_usaha; ?></p>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Laba Usaha Bayar</label>
                                            <p class="form-control"><?php echo $survey_detail->laba_usaha_bayar; ?></p>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Pendapatan Istri</label>
                                            <p class="form-control"><?php echo $survey_detail->pendapatan_istri; ?></p>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Pendapatan Lainya</label>
                                            <p class="form-control"><?php echo $survey_detail->pendapatan_lain; ?></p>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Jumlah Pendapatan Diterima</label>
                                            <p class="form-control"><?php echo $survey_detail->jml_pendapatan_diterima; ?></p>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Biaya Rumah Tangga</label>
                                            <p class="form-control"><?php echo $survey_detail->biaya_rt; ?></p>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Biaya Pendidikan</label>
                                            <p class="form-control"><?php echo $survey_detail->biaya_pendidikan; ?></p>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Biaya Lain-Lain</label>
                                            <p class="form-control"><?php echo $survey_detail->biaya_lain; ?></p>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Jumlah Pengeluaran</label>
                                            <p class="form-control"><?php echo $survey_detail->jml_pengeluaran; ?></p>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Pendapatan Bersih</label>
                                            <p class="form-control"><?php echo $survey_detail->pendapatan_bersih; ?></p>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label>Lending Maksimal</label>
                                            <p class="form-control"><?php echo $survey_detail->lending_maksimal; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <!-- <a href="<?php echo base_url('users/analisa'); ?>" class="btn btn-secondary"><< Kembali</a> -->
                </div>
            </div>
        </div>
        <!-- /survey detail content -->
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
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

    function copyToClipboard(text) {
        // Menggunakan API Clipboard yang lebih modern
        navigator.clipboard.writeText(text).then(function() {
            // Menampilkan SweetAlert untuk notifikasi sukses
            swal({
                title: "Copied!",
                text: text,
                icon: "success",
                timer: 1000,
                button: false
            });
        }).catch(function(error) {
            // Menampilkan pesan jika terjadi kesalahan
            swal({
                title: "Error!",
                text: "Gagal menyalin teks.",
                icon: "error",
                timer: 2000,
                button: true
            });
        });
    }

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
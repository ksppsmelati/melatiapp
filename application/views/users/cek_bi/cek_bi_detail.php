<style>
    label {
        font-weight: bold;
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
        <!-- Form content -->
        <div class="row">
            <div class="panel panel-flat col-12">
                <div class="panel-body">
                    <i class="fa fa-file-text"></i> Detail Cek BI - <strong onclick="copyToClipboard('<?php echo date('Ymd') . '_MLT' . $cek_bi_detail->id; ?>')"> <?php echo 'MLT' . $cek_bi_detail->id; ?></strong><br>
                    <span style="font-size: 80%; opacity: 0.7;">Tgl Masuk : <?php echo date('d-m-Y', strtotime($cek_bi_detail->tanggal)); ?></span>
                    <hr>
                    <div class="row">
                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label>Nama</label>
                                <p class="form-control" onclick="copyToClipboard('<?php echo $cek_bi_detail->nama; ?>')"><?php echo $cek_bi_detail->nama; ?></p>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label>Nama Ibu</label>
                                <p class="form-control" onclick="copyToClipboard('<?php echo $cek_bi_detail->nama_ibu; ?>')"><?php echo $cek_bi_detail->nama_ibu; ?></p>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label>Jenis Kelamin</label>
                                <p class="form-control" onclick="copyToClipboard('<?php echo ($cek_bi_detail->jk == 'L') ? 'LAKI-LAKI' : (($cek_bi_detail->jk == 'P') ? 'PEREMPUAN' : 'Tidak Diketahui'); ?>')"><?php echo ($cek_bi_detail->jk == 'L') ? 'LAKI-LAKI' : (($cek_bi_detail->jk == 'P') ? 'PEREMPUAN' : 'Tidak Diketahui'); ?></p>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label>Tanggal Lahir</label>
                                <p class="form-control" onclick="copyToClipboard('<?php echo $cek_bi_detail->tgl_lahir; ?>')"><?php echo $cek_bi_detail->tgl_lahir; ?></p>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label>Tempat Lahir</label>
                                <p class="form-control" onclick="copyToClipboard('<?php echo $cek_bi_detail->tempat_lahir; ?>')"><?php echo $cek_bi_detail->tempat_lahir; ?></p>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label>Penduduk</label>
                                <p class="form-control" onclick="copyToClipboard('<?php echo ($cek_bi_detail->negara === 'INDONESIA') ? 'YA' : 'TIDAK'; ?>')">
                                    <?php
                                    echo ($cek_bi_detail->negara === 'INDONESIA') ? 'YA' : 'TIDAK';
                                    ?>
                                </p>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label>Status Perkawinan</label>
                                <p class="form-control" onclick="copyToClipboard('<?php echo $cek_bi_detail->status_kawin; ?>')"><?php echo $cek_bi_detail->status_kawin; ?></p>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label>Status Pendidikan</label>
                                <p class="form-control" onclick="copyToClipboard('<?php echo $cek_bi_detail->status_pendidikan; ?>')"><?php echo $cek_bi_detail->status_pendidikan; ?></p>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label>Jenis Alamat</label>
                                <p class="form-control" onclick="copyToClipboard('<?php echo $cek_bi_detail->alamat; ?> ')"><?php echo $cek_bi_detail->alamat; ?></p>
                            </div>
                        </div>

                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label>Kelurahan</label>
                                <p class="form-control" onclick="copyToClipboard('<?php echo $cek_bi_detail->kelurahan_nama; ?> ')"><?php echo $cek_bi_detail->kelurahan_nama; ?></p>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label>Kecamatan</label>
                                <p class="form-control" onclick="copyToClipboard('<?php echo $cek_bi_detail->kecamatan_nama; ?> ')"><?php echo $cek_bi_detail->kecamatan_nama; ?></p>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label>Kota/Kabupaten</label>
                                <p class="form-control" onclick="copyToClipboard('<?php echo $cek_bi_detail->kota_nama; ?> ')"><?php echo $cek_bi_detail->kota_nama; ?></p>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label>Kode POS</label>
                                <p class="form-control" onclick="copyToClipboard('<?php echo $cek_bi_detail->kode_pos; ?> ')"><?php echo $cek_bi_detail->kode_pos; ?></p>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label>Negara</label>
                                <p class="form-control" onclick="copyToClipboard('<?php echo $cek_bi_detail->negara; ?> ')"><?php echo $cek_bi_detail->negara; ?></p>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label for="foto_ktp">Foto KTP<span style="color: red;">*</span></label>

                                <?php
                                // Ambil nama file foto_ktp dari data usulan_data
                                $foto_ktp = isset($cek_bi_detail->foto_ktp) ? $cek_bi_detail->foto_ktp : '';

                                // Buat URL lengkap untuk thumbnail
                                $thumbnailURL = './foto/foto_cek_bi/foto_ktp/' . $foto_ktp;

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
                                <label>Nomor Identitas</label>
                                <p class="form-control" onclick="copyToClipboard('<?php echo $cek_bi_detail->nik; ?>')"><?php echo $cek_bi_detail->nik; ?></p>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label>Telepon</label>
                                <p class="form-control" onclick="copyToClipboard('<?php echo $cek_bi_detail->telepon; ?>')"><?php echo $cek_bi_detail->telepon; ?></p>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label>Pekerjaan</label>
                                <p class="form-control" onclick="copyToClipboard('<?php echo $cek_bi_detail->pekerjaan; ?>')"><?php echo $cek_bi_detail->pekerjaan; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
</script>
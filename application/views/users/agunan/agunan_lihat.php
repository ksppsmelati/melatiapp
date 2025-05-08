<?php
$cek = $user->row();
$nama_lengkap = $cek->nama_lengkap;
?>

<style type="text/css">
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

    .gambar {
        width: 30px;
        /* Set the width of the thumbnail */
        height: 30px;
        /* Set the height of the thumbnail */
        object-fit: cover;
        /* Ensure the image covers the area and maintains aspect ratio */
        display: block;
        /* padding: 3px; */
        /* margin-bottom: 20px; */
        line-height: 1.5384616;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 3px;
        -webkit-transition: border .2s ease-in-out;
        -o-transition: border .2s ease-in-out;
        transition: border .2s ease-in-out;
    }

    .modal-content {
        border-radius: 10px;
    }
</style>
<link rel="stylesheet" type="text/css" href="assets/upload/dropzone.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.css">

<script src="assets/js/select2.min.js"></script>
<script src="assets/js/jquery-ui.js"></script>
<script type="text/javascript" src="assets/js/core/app.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.js"></script>
<script type="text/javascript" src="assets/upload/dropzone.min.js"></script>

<div class="container">
    <div class="content">
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <fieldset class="content-group">
                        <div class="navigation-buttons">
                            <div class="btn-group" style="float: left;">
                                <span style="font-size: 150%; opacity: 0.7;">ID: <?php echo $agunan->id; ?></span><br>
                                <span style="font-size: 80%; opacity: 0.7;">Tgl Masuk: <?php echo $agunan->tgl_masuk; ?></span>
                            </div>

                            <div class="btn-group" style="float: right;">
                                <a href="<?php echo site_url('users/agunan_cetak/' . $agunan->id); ?>" class="btn btn-danger" target="_blank">
                                    <i class="fa fa-print"></i>
                                </a>

                                <?php
                                $allowedLevels = ['admin', 'k_arsip', 'kadiv_opr', 's_admin','k_admin'];

                                if (in_array($user->row()->level, $allowedLevels)) {
                                    echo ' <a href="#" class="btn btn-info" data-toggle="modal" data-target="#shareModal">
                                    <i class="fa fa-shopping-cart"></i>
                                </a>';
                                }
                                ?>
                                <?php
                                $allowedLevels = ['admin', 'k_arsip', 'kadiv_opr', 's_admin','k_admin'];

                                if (in_array($user->row()->level, $allowedLevels)) {
                                    echo '<a href="' . site_url('users/agunan/agunan_edit/' . $agunan->id) . '" class="btn btn-primary">
                                     <i class="fa fa-pen"></i></a>';
                                }
                                ?>
                            </div>
                            <div class="clearfix"></div>
                            <hr>

                            <form class="form-horizontal" enctype="multipart/form-data">
                                <div class="row">

                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label col-lg-3" style="font-weight: bold;">Nama Anggota</label>
                                            <div class="col-lg-9">
                                                <input type="text" name="nm" id="nm" class="form-control" value="<?php echo $agunan->nama_anggota; ?>" readonly required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label col-lg-3" style="font-weight: bold;">Alamat</label>
                                            <div class="col-lg-9">
                                                <input type="text" name="alamat" id="alamat" class="form-control" value="<?php echo $agunan->alamat; ?>" readonly required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label col-lg-3" style="font-weight: bold;">Kantor</label>
                                            <div class="col-lg-9">
                                                <input type="hidden" name="kode_kantor" id="kode_kantor" value="<?php echo $agunan->kode_kantor; ?>" required>
                                                <input type="text" id="nama_kantor" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label col-lg-3" style="font-weight: bold;">No. Kontrak</label>
                                            <div class="col-lg-9">
                                                <input type="text" name="no_kontrak" id="no_kontrak" class="form-control" value="<?php echo $agunan->no_kontrak; ?>" readonly required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label col-lg-3" style="font-weight: bold;">No. Registrasi</label>
                                            <div class="col-lg-9">
                                                <input type="text" name="no_registrasi" id="no_registrasi" class="form-control" value="<?php echo $agunan->no_registrasi; ?>" readonly required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label col-lg-3" style="font-weight: bold;">Jenis Jaminan</label>
                                            <div class="col-lg-9">
                                                <input type="hidden" name="jenis_jaminan" id="jenis_jaminan" class="form-control" value="<?php echo $agunan->jenis_jaminan; ?>" readonly required>
                                                <input type="text" id="nama_jaminan" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label col-lg-3" style="font-weight: bold;">Plafond</label>
                                            <div class="col-lg-9">
                                                <input type="text" name="plafond" id="plafond" class="form-control" value="<?php echo $agunan->plafond; ?>" readonly required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label col-lg-3" style="font-weight: bold;">Jenis Dokumen</label>
                                            <div class="col-lg-9">
                                                <input type="hidden" name="jenis_dokumen" id="jenis_dokumen" class="form-control" value="<?php echo $agunan->jenis_dokumen; ?>" readonly required>
                                                <input type="text" id="nama_dokumen" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label col-lg-3" style="font-weight: bold;">Atas Nama</label>
                                            <div class="col-lg-9">
                                                <input type="text" name="atas_nama" id="atas_nama" class="form-control" value="<?php echo $agunan->atas_nama; ?>" readonly required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label col-lg-3" style="font-weight: bold;">Lokasi Jaminan</label>
                                            <div class="col-lg-9">
                                                <input type="text" name="lokasi_jaminan" id="lokasi_jaminan" class="form-control" value="<?php echo $agunan->lokasi_jaminan; ?>" readonly required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label col-lg-3" style="font-weight: bold;">Status </label>
                                            <div class="col-lg-9">
                                                <input type="text" name="status" id="status" class="form-control" required readonly style="background-color: #fdfd96;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label col-lg-3" style="font-weight: bold;">Foto Pengambilan</label>
                                            <div class="col-lg-9">
                                                <?php
                                                $foto_agunan = $agunan->foto_agunan; // Fix here: Use object property access
                                                $thumbnailURL = './foto/foto_agunan/' . $foto_agunan;
                                                if (!empty($foto_agunan) && file_exists($thumbnailURL)) {
                                                ?>
                                                    <a href="javascript:void(0);" onclick="openPopup('<?php echo $thumbnailURL; ?>');">
                                                        <img src="<?php echo $thumbnailURL; ?>" class="gambar" alt="Thumbnail">
                                                    </a>
                                                <?php
                                                } else {
                                                    echo "";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-lg-12" style="font-weight: bold;">Keterangan </label>
                                            <div class="col-lg-12">
                                                <textarea name="keterangan" id="keterangan" class="form-control" readonly required><?php echo $agunan->keterangan; ?></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <?php if (!empty($agunan->catatan)) : ?>
                                        <div class="col-lg-12 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label col-lg-12" style="font-weight: bold;">Catatan</label>
                                                <div class="col-lg-12">
                                                    <textarea name="catatan" id="catatan" class="form-control" readonly><?php echo htmlspecialchars($agunan->catatan, ENT_QUOTES, 'UTF-8'); ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>


                                    <div class="clearfix"></div>
                                    <hr>
                                    <div class="row" style="font-size: 80%; opacity: 0.7;">
                                        <div class="col-xs-6 col-sm-6">
                                            <label class="control-label" style="font-weight: bold;">inpdate:</label>
                                            <span><?php echo $agunan->tanggal; ?></span>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                            <label class="control-label" style="font-weight: bold;">inpuser:</label>
                                            <span><?php echo $agunan->petugas_input; ?></span>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                            <label class="control-label" style="font-weight: bold;">chdate:</label>
                                            <span><?php echo $agunan->tanggal_ubah; ?></span>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                            <label class="control-label" style="font-weight: bold;">chuser:</label>
                                            <span><?php echo $agunan->petugas_ubah; ?></span>
                                        </div>
                                    </div>

                                </div>
                            </form>
                            <!-- Modal Pesan -->
                            <div class="modal fade" id="shareModal" tabindex="-1" role="dialog" aria-labelledby="shareModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="shareModalLabel">Pesan Agunan</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="shareNote">Catatan:</label>
                                                <textarea class="form-control" id="shareNote" rows="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                            <button type="button" class="btn btn-danger" id="shareButton">Kirim</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
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

    function formatRupiah(amount) {
        var numberString = amount.toString();
        var split = numberString.split(',');
        var sisa = split[0].length % 3;
        var rupiah = split[0].substr(0, sisa);
        var ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            var separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
        return 'Rp ' + rupiah;
    }

    function setNameFromCode(inputId, outputId, namesMap) {
        var inputElement = document.getElementById(inputId);
        var outputElement = document.getElementById(outputId);
        var code = inputElement.value;

        outputElement.value = namesMap[code] || '-';
    }

    document.addEventListener("DOMContentLoaded", function() {
        var kantorNames = {
            '01': 'PUSAT',
            '02': 'SEDAYU',
            '03': 'SAPURAN',
            '04': 'KERTEK',
            '05': 'WONOSOBO',
            '06': 'KALIWIRO',
            '07': 'BANJARNEGARA',
            '08': 'RANDUSARI',
            '09': 'KEPIL'
        };

        var dokumenNames = {
            '1': 'SHM',
            '2': 'SHM A/Rusun',
            '3': 'SHGB',
            '4': 'SHP',
            '5': 'SHGU',
            '6': 'BPKB',
            '7': 'AJB',
            '8': 'BILYET DEPOSITO',
            '9': 'BUKU TABUNGAN',
            '10': 'CEK',
            '11': 'BILYET GIRO',
            '12': 'SURAT PERNYATAAN & KUASA',
            '13': 'INVOICE / FAKTUR',
            '14': 'SIPTB',
            '15': 'DOKUMEN KONTAK',
            '16': 'SAHAM',
            '17': 'OBLIGASI',
            '18': 'SK INSTITUSI/LEMBAGA',
            '19': 'LAIN-LAIN',
            '20': 'LETTER C/GIRIK',
            '21': 'KARTU PASAR'
        };

        var jaminanNames = {
            '1': 'KENDARAAN RODA 2 (FE0)',
            '2': 'KENDARAAN RODA 2 (NOTRAIL)',
            '3': 'KENDARAAN RODA 2 (BT)',
            '4': 'KENDARAAN RODA 4 (FE0)',
            '5': 'KENDARAAN RODA 4 (NOTRAIL)',
            '6': 'KENDARAAN RODA 4 (BT)',
            '7': 'TANAH DAN BANGUNAN (SKMHT)',
            '8': 'TANAH DAN BANGUNAN (APHT)',
            '9': 'TANAH DAN BANGUNAN (NOTARIS)',
            '10': 'TANAH DAN BANGUNAN (BT)',
            '11': 'EMAS',
            '12': 'DEPOSITO/TABUNGAN',
            '13': 'KENDARAAN RODA 2 (KUASA JUAL BELI)',
            '14': 'KENDARAAN RODA 4 (KUASA JUAL BELI)',
            '15': 'TANAH DAN BANGUNAN (KUASA JUAL BELI)',
            '16': 'SK INSTITUSI/LEMBAGA',
            '99': 'LAINNYA'
        };

        setNameFromCode('kode_kantor', 'nama_kantor', kantorNames);
        setNameFromCode('jenis_dokumen', 'nama_dokumen', dokumenNames);
        setNameFromCode('jenis_jaminan', 'nama_jaminan', jaminanNames);

        var plafondInput = document.getElementById('plafond');
        var plafondValue = plafondInput.value;

        if (plafondValue) {
            plafondInput.value = formatRupiah(plafondValue);
        }

        var statusInput = document.getElementById('status');
        var statusValue = "<?php echo $agunan->status; ?>";
        var cabangCode = "<?php echo $agunan->cabang; ?>";

        // Mendapatkan nama kantor dari peta kantor
        var cabangName = kantorNames[cabangCode] || '';

        // Menetapkan nilai status dengan nama kantor yang sesuai
        statusInput.value = statusValue + ' ' + cabangName + ' <?php echo $agunan->nama_pembawa; ?>';
    });

    document.getElementById('shareButton').addEventListener('click', function() {
        var note = document.getElementById('shareNote').value;
        var agunanId = '<?php echo $agunan->id; ?>';
        var url = '<?php echo site_url('users/agunan_lihat/' . $agunan->id); ?>';
        var message = 'BPKB ID: ' + agunanId + '%0A%0ALink: ' + url;

        if (note) {
            message += '%0A%0ACatatan: ' + encodeURIComponent(note);
        }

        var whatsappUrl = 'https://wa.me/?text=' + message;

        window.open(whatsappUrl, '_blank');
    });

    // untuk ubah status_proses dan update data petugas ubah dan tanggal ubah
    $(document).ready(function() {
        // Mengatur peristiwa klik pada tombol "Update Status Proses"
        $('#shareButton').on('click', function() {
            // Mendapatkan ID entitas dari PHP
            var entityId = '<?php echo $agunan->id; ?>';
            // Mendapatkan nilai petugas_ubah dari input dengan ID petugas_ubah
            var petugas_ubah = '<?php echo $nama_lengkap; ?>';
            // Mendapatkan nilai tanggal_ubah dari input dengan ID tanggal_ubah
            var tanggal_ubah = getCurrentDate();

            // Mengirim permintaan AJAX ke server (ke URL controller CodeIgniter)
            $.ajax({
                url: '<?= base_url("users/agunan_update_status_proses/") ?>' + entityId,
                method: 'POST',
                data: {
                    status_proses: 1,
                    tanggal_ubah: tanggal_ubah, // Menggunakan nilai dari variabel tanggal_ubah
                    petugas_ubah: petugas_ubah // Menggunakan nilai dari variabel petugas_ubah
                },
                success: function(response) {
                    // Tindakan setelah permintaan berhasil
                    console.log('Status proses berhasil diperbarui.');
                    // Menutup modal
                    // $('#shareModal').modal('hide');
                    // Mengarahkan ke halaman yang diinginkan
                    window.location.href = '<?= base_url("users/agunan") ?>';
                },
                error: function(xhr, status, error) {
                    // Tindakan jika terjadi kesalahan
                    console.error('Kesalahan saat memperbarui status proses:', error);
                }
            });
        });

        // Fungsi untuk mendapatkan tanggal saat ini dalam format YYYYmmdd
        function getCurrentDate() {
            var today = new Date();
            var year = today.getFullYear();
            var month = ('0' + (today.getMonth() + 1)).slice(-2);
            var day = ('0' + today.getDate()).slice(-2);
            return year + month + day;
        }
    });
</script>
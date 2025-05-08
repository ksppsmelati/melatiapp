<?php
$cek = $user->row();
$level = $cek->level;
$nama_lengkap = $cek->nama_lengkap;
$nokontrak = $sp_data->nokontrak;
$thumbnailURL = (!empty($sp_data->ttd) && file_exists('./foto/ttd/' . $sp_data->ttd)) ? './foto/ttd/' . $sp_data->ttd : '';
?>

<style>
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
</style>

<div class="container">
    <div class="content">
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <fieldset class="content-group">
                        <div class="navigation-buttons">
                            <div class="btn-group" style="float: left;">
                                <i class="icon-pencil7"></i> EDIT - <?php echo $sp_data->nokontrak; ?><br>
                                <span style="font-size: 80%; opacity: 0.7;">Tanggal: <?php echo $sp_data->tgl_input; ?></span>
                            </div>
                            <div class="btn-group" style="float: right;">
                                <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-bars"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                    <li><a href="<?php echo site_url('users/sp_data_tambah'); ?>"><i class="fa fa-plus"></i> Tambah sp_data</a></li>
                                    <li><a href="<?php echo site_url('users/sp_data_data'); ?>"><i class="fa fa-television"></i> Data sp_data</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr>

                        <form class="form-horizontal" id="myForm" action="<?php echo site_url('users/sp_update/' . $nokontrak); ?>" enctype="multipart/form-data" method="post">
                            <div class="row">
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" style="font-weight: bold;">No SP</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="nomor_sp" id="nomor_sp" class="form-control" value="<?php echo $sp_data->nomor_sp; ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" style="font-weight: bold;">No Akad</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="noakad" id="noakad" class="form-control" value="<?php echo $sp_data->noakad; ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" style="font-weight: bold;">Nama Anggota</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="nama" id="nama" class="form-control" value="<?php echo $sp_data->nama; ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" style="font-weight: bold;">Alamat</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="alamat" id="alamat" class="form-control" value="<?php echo $sp_data->alamat; ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" style="font-weight: bold;">Jenis Dokumen</label>
                                        <div class="col-lg-9">
                                            <select name="jnsdokumen" id="jnsdokumen" class="form-control" required>
                                                <option value="">-- Pilih Dokumen --</option>
                                                <?php
                                                $jenisDokumenList = [
                                                    "1" => "SHM",
                                                    "2" => "SHM A/Rusun",
                                                    "3" => "SHGB",
                                                    "4" => "SHP",
                                                    "5" => "SHGU",
                                                    "6" => "BPKB",
                                                    "7" => "AJB",
                                                    "8" => "BILYET DEPOSITO",
                                                    "9" => "BUKU TABUNGAN",
                                                    "10" => "CEK",
                                                    "11" => "BILYET GIRO",
                                                    "12" => "SURAT PERNYATAAN & KUASA",
                                                    "13" => "INVOICE / FAKTUR",
                                                    "14" => "SIPTB",
                                                    "15" => "DOKUMEN KONTAK",
                                                    "16" => "SAHAM",
                                                    "17" => "OBLIGASI",
                                                    "18" => "SK INSTITUSI/LEMBAGA",
                                                    "19" => "LAIN-LAIN",
                                                    "20" => "LETTER C/GIRIK",
                                                    "21" => "KARTU PASAR"
                                                ];

                                                foreach ($jenisDokumenList as $key => $label) {
                                                    $selected = ($sp_data->jnsdokumen == $key) ? 'selected' : '';
                                                    echo "<option value=\"$key\" $selected>$label</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" style="font-weight: bold;">Jenis SP</label>
                                        <div class="col-lg-9">
                                            <select name="jenis_sp" id="jenis_sp" class="form-control" required>
                                                <option value="">-- Pilih Jenis SP --</option>
                                                <option value="SP1" <?= ($sp_data->jenis_sp == 'SP1') ? 'selected' : ''; ?>>SP 1</option>
                                                <option value="SP2" <?= ($sp_data->jenis_sp == 'SP2') ? 'selected' : ''; ?>>SP 2</option>
                                                <option value="SP3" <?= ($sp_data->jenis_sp == 'SP3') ? 'selected' : ''; ?>>SP 3</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-6" style="display: none;">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" style="font-weight: bold;">Tanggal Ubah</label>
                                        <div class="col-lg-9">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="icon-calendar" style="pointer-events: none;"></i></span>
                                                <input type="text" name="tanggal_ubah" class="form-control daterange-single" id="tanggal_ubah" style="pointer-events: none;" value="<?php echo date('Y-m-d'); ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-sm-6" style="display: none;">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" style="font-weight: bold;">Petugas Update</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="chuser" id="chuser" class="form-control" required readonly value="<?php echo $nama_lengkap; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix"></div>
                                <hr>
                                <a href="users/sp_data" class="btn btn-default">
                                    << Kembali</a>
                                        <button type="submit" id="submit" class="btn btn-danger" style="float:right;">Update</button>
                        </form>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.css">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/compressorjs@1.0.7/dist/compressor.min.js"></script>

<script>
    // Fungsi untuk preview gambar sebelum diunggah
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

    // Kompresi gambar menggunakan Compressor.js
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
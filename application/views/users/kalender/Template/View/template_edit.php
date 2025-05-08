<?php
$cek = $user->row();
$level = $cek->level;
$nama_lengkap = $cek->nama_lengkap;
$id = $kunjungan->id;
$thumbnailURL = (!empty($kunjungan->foto_kunjungan) && file_exists('./foto/foto_kunjungan/' . $kunjungan->foto_kunjungan)) ? './foto/foto_kunjungan/' . $kunjungan->foto_kunjungan : '';
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
                                <i class="icon-pencil7"></i> EDIT - ID: <?php echo $kunjungan->id; ?><br>
                                <span style="font-size: 80%; opacity: 0.7;">Tanggal: <?php echo $kunjungan->tanggal; ?></span>
                            </div>
                            <div class="btn-group" style="float: right;">
                                <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-bars"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                    <li><a href="<?php echo site_url('users/kunjungan_tambah'); ?>"><i class="fa fa-plus"></i> Tambah Kunjungan</a></li>
                                    <li><a href="<?php echo site_url('users/kunjungan_data'); ?>"><i class="fa fa-television"></i> Data Kunjungan</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr>

                        <form class="form-horizontal" id="myForm" action="<?php echo site_url('users/kunjungan_update/' . $id); ?>" enctype="multipart/form-data" method="post">
                            <div class="row">

                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" style="font-weight: bold;">Nama Anggota</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="nama_anggota" id="nama_anggota" class="form-control" value="<?php echo $kunjungan->nama_anggota; ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" style="font-weight: bold;">Alamat</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="alamat" id="alamat" class="form-control" value="<?php echo $kunjungan->alamat; ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" style="font-weight: bold;" for="tujuan">Tujuan</label>
                                        <div class="col-lg-9">
                                            <select name="tujuan" id="tujuan" class="form-control" required>
                                                <option value="" disabled <?php echo empty($kunjungan->tujuan) ? 'selected' : ''; ?>>Pilih Tujuan</option>
                                                <option value="PENAGIHAN" <?php echo $kunjungan->tujuan == 'PENAGIHAN' ? 'selected' : ''; ?>>PENAGIHAN</option>
                                                <option value="SURVEY" <?php echo $kunjungan->tujuan == 'SURVEY' ? 'selected' : ''; ?>>SURVEY</option>
                                                <option value="PROMOSI" <?php echo $kunjungan->tujuan == 'PROMOSI' ? 'selected' : ''; ?>>PROMOSI</option>
                                                <option value="KOLEKTING" <?php echo $kunjungan->tujuan == 'KOLEKTING' ? 'selected' : ''; ?>>KOLEKTING</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" style="font-weight: bold;">Kantor</label>
                                        <div class="col-lg-9">
                                            <select name="kode_kantor" id="kode_kantor" class="form-control" required>
                                                <option value="" <?php echo ($kunjungan->kode_kantor == '') ? 'selected' : ''; ?>>- Pilih Kantor -</option>
                                                <option value="01" <?php echo ($kunjungan->kode_kantor == '01') ? 'selected' : ''; ?>>PUSAT</option>
                                                <option value="02" <?php echo ($kunjungan->kode_kantor == '02') ? 'selected' : ''; ?>>SEDAYU</option>
                                                <option value="03" <?php echo ($kunjungan->kode_kantor == '03') ? 'selected' : ''; ?>>SAPURAN</option>
                                                <option value="04" <?php echo ($kunjungan->kode_kantor == '04') ? 'selected' : ''; ?>>KERTEK</option>
                                                <option value="05" <?php echo ($kunjungan->kode_kantor == '05') ? 'selected' : ''; ?>>WONOSOBO</option>
                                                <option value="06" <?php echo ($kunjungan->kode_kantor == '06') ? 'selected' : ''; ?>>KALIWIRO</option>
                                                <option value="07" <?php echo ($kunjungan->kode_kantor == '07') ? 'selected' : ''; ?>>BANJARNEGARA</option>
                                                <option value="08" <?php echo ($kunjungan->kode_kantor == '08') ? 'selected' : ''; ?>>RANDUSARI</option>
                                                <option value="09" <?php echo ($kunjungan->kode_kantor == '09') ? 'selected' : ''; ?>>KEPIL</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <!-- <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" style="font-weight: bold;">Lokasi</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="lokasi" id="lokasi" class="form-control" value="<?php echo $kunjungan->lokasi; ?>" required>
                                        </div>
                                    </div>
                                </div> -->

                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" style="font-weight: bold;">Foto Kunjungan</label>
                                        <div class="col-lg-9">
                                            <?php
                                            $foto_kunjungan = $kunjungan->foto_kunjungan; // Fix here: Use object property access
                                            $thumbnailURL = './foto/foto_kunjungan/' . $foto_kunjungan;
                                            if (!empty($foto_kunjungan) && file_exists($thumbnailURL)) {
                                            ?>
                                                <div class="mt-2">
                                                    <!-- Thumbnail yang bisa diklik untuk popup -->
                                                    <a href="javascript:void(0);" onclick="openPopup('<?php echo $thumbnailURL; ?>');">
                                                        <img src="<?php echo $thumbnailURL; ?>" class="gambar" alt="Thumbnail">
                                                    </a>
                                                </div>
                                            <?php
                                            } else {
                                                echo "";
                                            }
                                            ?>

                                            <!-- Input file untuk mengganti foto -->
                                            <input type="file" name="foto_kunjungan" id="foto_kunjungan" class="form-control" accept="image/*" onchange="previewImage(event, 'fotoKunjunganPreview')">

                                            <!-- Area untuk preview foto baru -->
                                            <div class="mt-2">
                                                <img class="img-preview" id="fotoKunjunganPreview" alt="Preview Foto Kunjungan" style="display:none;" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label col-lg-6" style="font-weight: bold;">Keterangan </label>
                                        <div class="col-lg-12">
                                            <textarea name="keterangan" id="keterangan" class="form-control"><?php echo $kunjungan->keterangan; ?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- <div class="col-xs-12 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label col-lg-6" style="font-weight: bold;">catatan </label>
                                        <div class="col-lg-12">
                                            <textarea name="catatan" id="catatan" class="form-control"><?php echo $kunjungan->catatan; ?></textarea>
                                        </div>
                                    </div>
                                </div> -->

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
                                <a href="users/kunjungan_data" class="btn btn-default">
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
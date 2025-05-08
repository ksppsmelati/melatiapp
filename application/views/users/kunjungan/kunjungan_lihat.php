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
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>


<div class="container">
    <div class="content">
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <fieldset class="content-group">
                        <div class="navigation-buttons">
                            <div class="btn-group" style="float: right;">
                                <?php
                                $allowedLevels = ['admin', 'k_arsip', 'kadiv_opr', 's_admin'];

                                if (in_array($user->row()->level, $allowedLevels)) {
                                    echo '<a href="' . site_url('users/kunjungan_edit/' . $kunjungan->id) . '" class="btn btn-primary">
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
                                                <input type="text" name="nama_anggota" id="nama_anggota" class="form-control" value="<?php echo $kunjungan->nama_anggota; ?>" readonly required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label col-lg-3" style="font-weight: bold;">Alamat</label>
                                            <div class="col-lg-9">
                                                <input type="text" name="alamat" id="alamat" class="form-control" value="<?php echo $kunjungan->alamat; ?>" readonly required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label col-lg-3" style="font-weight: bold;">Tujuan</label>
                                            <div class="col-lg-9">
                                                <input type="text" name="tujuan" id="tujuan" class="form-control" value="<?php echo $kunjungan->tujuan; ?>" readonly required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label col-lg-3" style="font-weight: bold;">Foto Kunjungan</label>
                                            <div class="col-lg-9">
                                                <?php
                                                $foto_kunjungan = $kunjungan->foto_kunjungan; // Fix here: Use object property access
                                                $thumbnailURL = './foto/foto_kunjungan/' . $foto_kunjungan;
                                                if (!empty($foto_kunjungan) && file_exists($thumbnailURL)) {
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
                                    <div class="clearfix"></div>

                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label col-lg-3" style="font-weight: bold;">Lokasi</label>
                                            <div class="col-lg-9">
                                                <input type="text" name="lokasi" id="lokasi" class="form-control" value="<?php echo $kunjungan->lokasi; ?>" readonly required>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Menambahkan Map -->
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label col-lg-3" style="font-weight: bold;">Peta Lokasi</label>
                                            <div class="col-lg-9">
                                                <div id="map" style="height: 200px;"></div> <!-- Peta akan muncul di sini -->
                                                <br>
                                                <!-- Link ke Google Maps -->
                                                <a id="googleMapsLink" href="#" target="_blank">Buka di Google Maps</a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label col-lg-12" style="font-weight: bold;">Keterangan </label>
                                            <div class="col-lg-12">
                                                <textarea name="keterangan" id="keterangan" class="form-control" readonly required><?php echo $kunjungan->keterangan; ?></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-6 col-sm-6" style="display: none;">
                                        <div class="form-group">
                                            <label class="control-label col-lg-3" style="font-weight: bold;">Catatan</label>
                                            <div class="col-lg-9">
                                                <input type="text" name="catatan" id="catatan" class="form-control" value="<?php echo $kunjungan->catatan; ?>" readonly required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="clearfix"></div>
                                    <hr>
                                    <div class="row" style="font-size: 80%; opacity: 0.7;">
                                        <div class="col-xs-6 col-sm-6">
                                            <label class="control-label" style="font-weight: bold;">inpdate:</label>
                                            <span><?php echo $kunjungan->tanggal; ?></span>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                            <label class="control-label" style="font-weight: bold;">inpuser:</label>
                                            <span><?php echo $kunjungan->id_user; ?></span>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                            <label class="control-label" style="font-weight: bold;">chdate:</label>
                                            <span><?php echo $kunjungan->tanggal_ubah; ?></span>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                            <label class="control-label" style="font-weight: bold;">chuser:</label>
                                            <span><?php echo $kunjungan->chuser; ?></span>
                                        </div>
                                    </div>

                                </div>
                            </form>
                            <!-- Modal Pesan -->
                            <div class="modal fade" id="shareModal" tabindex="-1" role="dialog" aria-labelledby="shareModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="shareModalLabel">Pesan kunjungan</h5>
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

    // Ambil nilai lokasi dari input (format: "latitude, longitude")
    var lokasi = "<?php echo $kunjungan->lokasi; ?>"; // Contoh: "-7.3934331, 109.6505767"

    // Pisahkan nilai latitude dan longitude
    var koordinat = lokasi.split(",");
    var latitude = parseFloat(koordinat[0]);
    var longitude = parseFloat(koordinat[1]);

    // Inisialisasi peta
    var map = L.map('map').setView([latitude, longitude], 13);

    // Menambahkan tile layer (peta dasar)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Menambahkan marker di lokasi
    var marker = L.marker([latitude, longitude]).addTo(map);
    marker.bindPopup("<b>Lokasi</b><br>").openPopup();

    // Membuat link untuk membuka lokasi di Google Maps
    var googleMapsLink = "https://www.google.com/maps?q=" + latitude + "," + longitude;
    document.getElementById("googleMapsLink").href = googleMapsLink;
</script>
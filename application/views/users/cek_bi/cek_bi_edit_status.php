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
                        <i class="fa fa-poll"></i> Edit Status Cek BI <br>
                        <span style="font-size: 80%; opacity: 0.7;"><strong><?php echo 'MLT' . $cek_bi_data->id; ?></strong> </span>
                        <span style="font-size: 80%; opacity: 0.7;"> | <strong><?php echo $cek_bi_data->nama; ?></strong> </span>
                        <div class="btn-group" style="float: right;">
                            <!-- Tombol Dropdown (di pojok kanan atas) -->
                            <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bars"></i>
                            </button>
                            <!-- Isi Dropdown -->
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <li><a href="users/cek_bi_tambah"><i class="fa fa-plus"></i> Tambah Cek BI</a></li>
                                <li><a href="users/cek_bi_data"><i class="fa fa-file-text"></i> Data Cek BI</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                    <form method="post" action="<?= base_url('users/cek_bi_update_status/' . $cek_bi_data->id); ?>">
                        <ul class="branch">
                            <li class="branch-item">
                                <div class="branch-title">
                                    <h4 class="text-bold"><i class="fa fa-person"></i> Data Pemohon</h4>
                                    <div class="marker-icon"><i class="fa-solid fa-caret-down"></i></div>
                                </div>
                                <div class="branch-details">
                                    <input type="hidden" name="id" id="id" class="form-control" required value="<?= $cek_bi_data->id; ?>">
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="nama">Nama Pemohon<span style="color: red;">*</span></label>
                                            <input type="text" name="nama" id="nama" class="form-control" required readonly value="<?= $cek_bi_data->nama; ?>" placeholder="Masukan nama pemohon">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="nik">NIK<span style="color: red;">*</span></label>
                                            <input type="text" name="nik" id="nik" class="form-control" required readonly value="<?= $cek_bi_data->nik; ?>" placeholder="Masukan NIK">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="alamat">Alamat<span style="color: red;">*</span></label>
                                            <input type="text" name="alamat" id="alamat" class="form-control" required readonly value="<?= $cek_bi_data->alamat; ?>" placeholder="Masukan alamat rumah">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="telepon">Telepon</label>
                                            <input type="text" name="telepon" id="telepon" class="form-control" readonly value="<?= $cek_bi_data->telepon; ?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="pekerjaan">Pekerjaan</label>
                                            <input type="text" name="pekerjaan" id="pekerjaan" class="form-control" readonly value="<?= $cek_bi_data->pekerjaan; ?>" placeholder="Masukan pekerjaan pokok">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="foto_ktp">Foto KTP<span style="color: red;">*</span></label>

                                            <?php
                                            // Ambil nama file foto_ktp dari data usulan_data
                                            $foto_ktp = isset($cek_bi_data->foto_ktp) ? $cek_bi_data->foto_ktp : '';

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
                                </div>
                            </li>

                        </ul>
                        <div class="clearfix"></div>
                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label for="tgl_cek_bi">Tanggal Cek BI</label>
                                <input type="date" name="tgl_cek_bi" id="tgl_cek_bi" class="form-control" value="<?= isset($cek_bi_data->tgl_cek_bi) ? $cek_bi_data->tgl_cek_bi : ''; ?>">
                            </div>
                        </div>

                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label for="slik">Slik</label><br>
                                <?php if ($cek_bi_data->category === 'SLIK_MLT') : ?>
                                    <a href="<?php echo base_url('users/file_user_lihat_id_mlt/' . $cek_bi_data->id); ?>" class="btn btn-xs" style="background-color: #6f42c1; color: white;" title="Lihat File SLIK">
                                        <i class="fa-solid fa-book-open"></i>
                                    </a>
                                <?php else : ?>
                                    <button class="btn btn-xs" style="background-color: #e83e8c; color: white;" title="Data SLIK Tidak Ada">
                                        <i class="fa-solid fa-times"></i>
                                    </button>
                                <?php endif; ?>
                                <a href="<?php echo site_url('users/cek_bi_upload/' . $cek_bi_data->id); ?>" class="btn btn-light btn-xs" style="background-color: #6c757d; color: white;"><i class="fa fa-upload" aria-hidden="true"></i></a>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <div class="col-xs-12 col-sm-12">
                            <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <textarea name="keterangan" id="keterangan" class="form-control" placeholder="Tulis Keterangan" rows="5"><?= isset($cek_bi_data->keterangan) ? $cek_bi_data->keterangan : ''; ?></textarea>
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
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
</style>

<div class="container">
    <div class="content">
        <?php echo $this->session->flashdata('msg'); ?>
        <!-- Edit Survey Form -->
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <div class="navigation-buttons">
                        <i class="fa fa-poll"></i> BI Checking - <strong> <?php echo 'PBY' . $survey_data->id_pby; ?></strong>
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
                    <form method="post" action="<?= base_url('users/analisa_cek_bi/' . $survey_data->id_pby); ?>">
                        <input type="hidden" name="id_pby" id="id_pby" class="form-control" required value="<?= $survey_data->id_pby; ?>">
                        <input type="hidden" name="analyst" id="analyst" class="form-control" required value="<?= $analyst; ?>">
                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label for="nama">Nama Pemohon<span style="color: red;">*</span></label>
                                <input type="text" name="nama" id="nama" class="form-control" required readonly value="<?= $survey_data->nama; ?>" placeholder="Masukan nama pemohon">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label for="nama_ibu">Nama Ibu<span style="color: red;">*</span></label>
                                <input type="text" name="nama_ibu" id="nama_ibu" class="form-control" required readonly value="<?= $survey_data->nama_ibu; ?>" placeholder="Masukan nama ibu">
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
                                <label for="nik">NIK<span style="color: red;">*</span></label>
                                <input type="text" name="nik" id="nik" class="form-control" required readonly value="<?= $survey_data->nik; ?>" placeholder="Masukan NIK">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label for="alamat">Dusun RT/RW<span style="color: red;">*</span></label>
                                <input type="text" name="alamat" id="alamat" class="form-control" required readonly value="<?= $survey_data->alamat; ?>" placeholder="Masukan alamat rumah">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label for="alamat">Kelurahan<span style="color: red;">*</span></label>
                                <input type="text" name="kelurahan" id="kelurahan" class="form-control" required readonly value="<?= $survey_data->kelurahan_nama; ?>">
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
                        <div class="clearfix"></div>
                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label for="tgl_cek_bi">Tanggal Cek BI</label>
                                <input type="date" name="tgl_cek_bi" id="tgl_cek_bi" class="form-control" value="<?= isset($survey_data->tgl_cek_bi) ? $survey_data->tgl_cek_bi : ''; ?>">
                            </div>
                        </div>

                        <!-- Input untuk Status Analisa -->
                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label for="status_analisa">Status Analisa</label>
                                <select name="status_analisa" id="status_analisa" class="form-control" onchange="changeColor(this)" disabled>
                                    <option value="" <?= (is_null($survey_data->status_analisa)) ? 'selected' : ''; ?>>-- Pilih Status --</option>
                                    <option value="0" <?= (isset($survey_data->status_analisa) && $survey_data->status_analisa === '0') ? 'selected' : ''; ?>>Not Checked</option>
                                    <option value="1" <?= (isset($survey_data->status_analisa) && $survey_data->status_analisa === '1') ? 'selected' : ''; ?>>Checked</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label for="hasil_analisa">Hasil Analisa</label>
                                <select name="hasil_analisa" id="hasil_analisa" class="form-control" disabled>
                                    <option value="" <?= (is_null($survey_data->hasil_analisa)) ? 'selected' : ''; ?>>-- Pilih Status --</option>
                                    <option value="1" <?= (isset($survey_data->hasil_analisa) && $survey_data->hasil_analisa === '1') ? 'selected' : ''; ?>>Tidak Rekomendasi</option>
                                    <option value="2" <?= (isset($survey_data->hasil_analisa) && $survey_data->hasil_analisa === '2') ? 'selected' : ''; ?>>Pertimbangkan</option>
                                    <option value="3" <?= (isset($survey_data->hasil_analisa) && $survey_data->hasil_analisa === '3') ? 'selected' : ''; ?>>Rekomendasi</option>
                                </select>
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
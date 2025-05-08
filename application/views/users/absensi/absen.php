<?php
$cek = $user->row();
$id_user = $cek->id_user;
$level = $cek->level;
$device_info = $cek->device_info;
$device_reg = $cek->device_reg;
$nama = $cek->nama_lengkap;
$level = $cek->level;
$status = $cek->status;
$kode_kantor_user = $cek->kode_kantor;
$tgl = date('m-Y');
$cek_latitude = $this->session->userdata('latitude') ? $this->session->userdata('latitude') : -7.358726649824624;
$cek_longitude = $this->session->userdata('longitude') ? $this->session->userdata('longitude') : 109.90308206551964;
// $cek_latitude = $this->session->userdata('latitude');
// $cek_longitude = $this->session->userdata('longitude');
$latitude = $this->session->userdata('latitude') ? $this->session->userdata('latitude') : -7.358726649824624;
$longitude = $this->session->userdata('longitude') ? $this->session->userdata('longitude') : 109.90308206551964;
// Ambil kode_kantor dari tbl_setting

?>

<style>
    .circle-btn {
        display: inline-block;
        width: 100px;
        /* Adjust the size as needed */
        height: 100px;
        /* Adjust the size as needed */
        line-height: 150px;
        /* Should be equal to height for vertical centering */
        border-radius: 50%;
        text-align: center;
        font-size: 24px;
        /* Adjust the font size as needed */
        margin: 10px;
        cursor: pointer;
        border: none;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        /* Adjust the shadow properties as needed */
        transition: box-shadow 0.3s ease;
        /* Add a smooth transition effect */
        position: relative;
    }

    .circle-btn i {
        font-size: 2em;
        /* Adjust the icon size as needed */
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .circle-btn:active {
        box-shadow: none;
        font-size: 3em;
        /* Remove the box shadow when the button is pressed */
    }

    /* Tambahkan animasi pada tombol saat diklik */
    @keyframes clickAnimation {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.2);
        }

        100% {
            transform: scale(1);
        }
    }

    /* Tambahkan class untuk animasi saat diklik */
    .clicked {
        animation: clickAnimation 0.3s ease;
    }

    .text-container {
        display: flex;
        flex-wrap: wrap;
    }

    .info,
    .keterangan {
        flex: 1 1 50%;
        /* 50% width for each column, adjust as needed */
        padding: 0px;
        /* Add padding for spacing */
    }

    .jam-container {
        display: flex;
        justify-content: space-between;
        width: 100%;
    }

    .jam-masuk,
    .jam-pulang {
        display: flex;
        align-items: center;
        border-radius: 30px;
        background-color: #f0f0f0;
    }

    .jam-masuk i,
    .jam-pulang i {
        margin-right: 5px;
        margin-left: 5px;
    }

    .content-group2 {
        display: none;
    }

    .content-group.show {
        display: block;
    }

    .btn-container {
        display: flex;
        justify-content: center;
        width: 100%;
        margin: auto;
    }

    .btn-container button {
        /* Sesuaikan lebar dan padding dengan kebutuhan */
        padding: 12px 24px;
        font-size: 16px;
        /* Gunakan persentase atau auto untuk lebar tombol */
        width: auto;
        /* Atau bisa dihapus agar lebarnya disesuaikan dengan teks */
        margin: 0 8px;
        /* Jarak antar tombol */
        border-radius: 4px;
        /* Agar tombol berbentuk rounded */
        border: none;
        /* Hilangkan border agar lebih rapi */
        cursor: pointer;
        /* Kursor pointer saat dihover */
        transition: opacity 0.3s ease;
        /* Transisi untuk efek hover */
    }

    .btn-container button:hover {
        opacity: 0.8;
        /* Mengurangi opacity saat tombol dihover */
    }


    .text-shadow {
        text-shadow: 2px 2px 4px rgba(128, 128, 128, 0.5);
        /* Soft gray shadow */
    }

    .circle-button {
        border-radius: 50%;
        /* Membuat tombol menjadi bulat */
        width: 40px;
        /* Lebar tombol */
        height: 40px;
        /* Tinggi tombol */
        line-height: 40px;
        /* Menengahkan ikon di dalam tombol */
        text-align: center;
        /* Menengahkan ikon di dalam tombol */
        padding: 0;
        /* Hapus padding agar tombol lebih rapi */
        font-size: 20px;
        /* Ukuran font ikon */
    }

    .map-background {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        opacity: 0.9;
        /* Adjust opacity for transparency */
        z-index: -1;
        /* Ensure it stays in the background */
        border-radius: 10px;
    }

    .panel-body {
        position: relative;
        z-index: 1;
        /* Ensure content is above the map */
    }

    /* .content {
                position: relative;
                z-index: 2;
            } */
</style>

<!-- Main content -->
<div class="container">
    <div class="content">
        <?php if ($absen < 1) : ?>
            <div class="row" style="position: relative; z-index: 1500; display: flex; justify-content: center; ">
                <div class="panel panel-flat">
                    <?php echo $this->session->flashdata('msg'); ?>
                    <div class="panel-body" style="padding: 5px;">
                        <!-- Toggle button -->
                        <div style="text-align: center;">
                            <button id="toggleButton" onclick="toggleContentGroup()" class="btn btn-secondary circle-button"><i class="fa fa-plus"></i></button>
                        </div>

                        <fieldset class="content-group2" id="contentGroup" style="display: none;">
                            <hr>
                            <div class="btn-container">
                                <button id="btnIzin" onclick="izin()" class="btn btn-info">Izin</button>
                                <button id="btnCuti" onclick="cuti()" class="btn btn-success">Cuti</button>
                                <button id="btnSakit" onclick="sakit()" class="btn btn-primary">Sakit</button>
                            </div>
                            <hr>
                            <div class="btn-container">
                                <button id="btnPerjalanan" onclick="perjalanan_tugas()" class="btn btn-warning">Perjalanan Tugas</button>
                            </div>
                            <br>
                        </fieldset>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="panel panel-flat">
                <?php echo $this->session->flashdata('msg'); ?>
                <div class="panel-body">
                    <div class="navigation-buttons">
                        <div class="btn-group" style="float: left;">
                            <!-- Tombol Back (di pojok kiri atas) -->
                            <i class="fa fa-fingerprint"></i> Absensi KSPPS MELATI
                        </div>
                        <div class="navigation-buttons text-right">
                            <div class="btn-group">
                                <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-bars"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                    <li><a href="<?= base_url('users/absensi/check_absen'); ?>"><i class="fa fa-fingerprint"></i> Absen</a></li>
                                    <li><a href="<?= base_url('users/absensi/detail_absensi'); ?>"><i class="fa fa-file-text"></i> Data Absen</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- Membersihkan float -->
                    <div class="clearfix"></div>
                    <hr>
                    <fieldset class="content-group">
                        <div class="panel panel-flat">
                            <div class="panel-body" style="height: 100px;">
                                <div id="map" class="map-background"></div>
                            </div>
                        </div>
                        <div class="text-container">
                            <div class="info">
                                <p>Nama: <br><b><?= htmlspecialchars(ucwords($nama)) ?></b></p>
                                <p>Tanggal: <br><b><?= date('d-m-Y') ?> </b></p>

                            </div>
                            <div class="keterangan">
                                <p>Keterangan: <br>
                                    <?php if ($absen < 1) : ?>
                                        <small><b class="text-danger">Belum Absen</b> <i class="fa fa-1x fa-exclamation-triangle text-warning"></i></small>
                                    <?php elseif ($absen == 1) : ?>
                                        <small><b class="text-success">Sudah Absen Masuk</b> <i class="fa fa-1x fa-check-circle text-success"></i></small>
                                    <?php elseif ($absen >= 2) : ?>
                                        <small><b class="text-success">Sudah Absen Pulang</b> <i class="fa fa-1x fa-check-circle text-success"></i></small>
                                    <?php endif; ?>
                                </p>
                                <p>Jarak : <br><b><span id="nearest-distance" class="distance-indicator"><i class="fas fa-spinner fa-spin"></i></span></b></p>
                            </div>
                        </div>
                        <div class="jam-container">
                            <div class="jam-masuk">
                                <i class="fa fa-sign-in text-success"></i>
                                <span><?= !empty($jam_masuk) ? check_jam($jam_masuk, 'masuk') : '<span class="badge badge-secondary"> - : - : - </span>' ?></span>
                            </div>
                            <div class="jam-pulang">
                                <i class="fa fa-sign-out text-warning"></i>
                                <span><?= !empty($jam_pulang) ? check_jam($jam_pulang, 'pulang') : '<span class="badge badge-secondary"> - : - : - </span>' ?></span>
                            </div>
                        </div>

                        <br>
                        <div class="text-center">
                            <?php if ($absen < 1) : ?>
                                <button id="btnAbsenMasuk" ontouchstart="startTimer('masuk')" ontouchend="stopTimer()" class="btn btn-secondary circle-btn"><i class="fas fa-fingerprint"></i></button>
                            <?php elseif ($absen == 1) : ?>
                                <button id="btnAbsenPulang" ontouchstart="startTimer('pulang')" ontouchend="stopTimer()" class="btn btn-success circle-btn" style="display: none;"><i class="fas fa-fingerprint"></i></button>

                                <div class="keterangan">
                                    <p>
                                        <?php if ($keterangan == 'Izin') : ?>
                                    <div id="infoPulang" class="alert alert-primary" style="display: ;"> Hai <?php echo htmlspecialchars(ucwords($nama)); ?>! Hari ini kamu <b>(Izin) 🙏</b>
                                    </div>
                                <?php elseif ($keterangan == 'Cuti') : ?>
                                    <div id="infoPulang" class="alert alert-primary" style="display: ;"><?php echo htmlspecialchars(ucwords($nama)); ?>! Hari ini kamu <b>(Cuti) 🏖️</b>
                                    </div>
                                <?php elseif ($keterangan == 'Sakit') : ?>
                                    <div id="infoPulang" class="alert alert-info" style="display: ;">Hai <?php echo htmlspecialchars(ucwords($nama)); ?>! Hari ini kamu sedang <b>(Sakit)</b> ya, semoga cepat sembuh ya! 🙏❤️
                                    </div>
                                <?php elseif ($keterangan == 'Perjalanan_tugas') : ?>
                                    <div id="infoPulang" class="alert alert-info" style="display: ;">Hai <?php echo htmlspecialchars(ucwords($nama)); ?>! Hari ini kamu sedang <b>(Perjalanan Tugas)</b>, hati-hati dan semoga sukses!
                                    </div>
                                <?php elseif ($keterangan == 'Masuk') : ?>
                                    <div id="infoPulang" class="alert alert-success" style="display: ;">
                                        <?php if (!empty($ucapan_masuk_by_day)) : ?>
                                            <?php foreach ($ucapan_masuk_by_day as $ucapan) : ?>
                                                <div>
                                                    <?php
                                                    // Mengambil isi ucapan
                                                    $kode_php = $ucapan->isi_ucapan;

                                                    // Mengeksekusi kode PHP
                                                    ob_start();
                                                    eval('?>' . $kode_php);
                                                    $output = ob_get_clean();

                                                    // Menampilkan hasil
                                                    echo $output;
                                                    ?>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <p>Selamat bekerja <?php echo htmlspecialchars(ucwords($nama)); ?></p>
                                        <?php endif; ?>
                                    </div>
                                <?php else : ?>
                                    <!-- kosong -->
                                <?php endif; ?>

                                </p>
                                </div>

                            <?php elseif ($absen >= 2) : ?>
                                <div class="alert alert-success">
                                    <?php if (!empty($ucapan_pulang_by_day)) : ?>
                                        <?php foreach ($ucapan_pulang_by_day as $ucapan) : ?>
                                            <div>
                                                <?php
                                                // Mengambil isi ucapan
                                                $kode_php = $ucapan->isi_ucapan;

                                                // Mengeksekusi kode PHP
                                                ob_start();
                                                eval('?>' . $kode_php);
                                                $output = ob_get_clean();

                                                // Menampilkan hasil
                                                echo nl2br(htmlspecialchars($output));
                                                ?>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <p>Anda sudah melakukan absensi masuk dan pulang hari ini. Terimakasih 😊</p>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- libur manual -->
                        <!-- <div class="text-center">
                                <div class="alert alert-danger">Hari ini libur. Tidak Perlu absen</div>
                            </div> -->
                        <br>
                        <!-- Ikon refresh di tengah tanpa latar belakang tombol -->
                        <div style="text-align: center;">
                            <button type="button" class="btn btn-info" id="btnRefreshPage" style="background: none; border: none;" onclick="animateButton()">
                                <i class="fa fa-refresh" aria-hidden="true" style="color: #808080; font-size: 24px;"></i>
                            </button>
                        </div>
                        <div class="text-center">
                            <button type="button" class="btn btn-secondary" onclick="openGoogleMaps()">
                                <i class="fa fa-map" aria-hidden="true"></i> Google Maps
                            </button>
                        </div>
                        <br>
                        <div class="lokasi" data-latitude="<?= $latitude ?>" data-longitude="<?= $longitude ?>">
                            <i class="fa fa-street-view" aria-hidden="true"></i>
                            <span class="lokasi-data"></span>
                            <div>
                                Lat: <span id="latitude">
                                    <?= $latitude ?>
                                </span>, Lng: <span id="longitude">
                                    <?= $longitude ?>
                                </span> <span class="status-indicator"></span>
                            </div>
                        </div>
                    </fieldset>
                </div>

            </div>
        </div>
        <input type="hidden" id="deviceInfo" name="device_info">

        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Include Leaflet.Fullscreen CSS and JavaScript -->
<link rel="stylesheet" href="https://unpkg.com/leaflet-fullscreen/dist/leaflet.fullscreen.css" />
<script src="https://unpkg.com/leaflet-fullscreen/dist/Leaflet.fullscreen.min.js"></script>

<script>
    let isAttendanceInProgress = false;
    let sessionLatitude = <?php echo json_encode($cek_latitude); ?>;
    let sessionLongitude = <?php echo json_encode($cek_longitude); ?>;
    let latitude = <?php echo json_encode($latitude); ?>;
    let longitude = <?php echo json_encode($longitude); ?>;
    let deviceReg = <?php echo json_encode($device_reg); ?>;
    let currentDeviceInfo = document.getElementById('deviceInfo').value;
    let pressTimer;
    let kode_kantor;
    let kodeKantorUser = <?php echo json_encode($kode_kantor_user); ?>;

    getDeviceInfo();
    setInterval(updateClock, 1000);
    updateClock();

    // Check if geolocation is supported
    if (navigator.geolocation) {
        // Watch the position and call updateUI on changes
        var watchOptions = {
            enableHighAccuracy: true, // Use GPS if available
            maximumAge: 0,
            // maximumAge: 30000, // Maximum age of cached position (30 seconds)
            timeout: 10000 // Timeout for obtaining the location (10 seconds)
        };

        // Untuk mendapatkan lokasi terkini satu kali
        navigator.geolocation.getCurrentPosition(
            function(position) {
                // Success callback
                updateUI(position);
            },
            function(error) {
                // Error callback
                handleLocationError(error);

                // If location cannot be obtained, try to use the session data if available
                var sessionLatitude = parseFloat("<?= $this->session->userdata('latitude') ?>");
                var sessionLongitude = parseFloat("<?= $this->session->userdata('longitude') ?>");

                if (!isNaN(sessionLatitude) && !isNaN(sessionLongitude)) {
                    // Location data is available in the session, use it to update the UI
                    updateUI({
                        coords: {
                            latitude: sessionLatitude,
                            longitude: sessionLongitude
                        }
                    });
                }
            },
            watchOptions
        );
    } else {
        // Geolocation is not supported by the browser
        console.error('Geolocation tidak didukung pada browser ini');
        $(".lokasi-data").html('Geolocation tidak didukung');
    }

    function getPlaceName(latitude, longitude) {
        const url = buildNominatimUrl(latitude, longitude);

        // Lakukan permintaan AJAX ke Nominatim
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                if (data.address) {
                    // Extract relevant location information
                    var locationInfo = '';

                    if (data.address.hamlet) {
                        locationInfo += data.address.hamlet + ', ';
                    }

                    if (data.address.suburb) {
                        locationInfo += data.address.suburb + ', ';
                    }

                    if (data.address.village) {
                        locationInfo += data.address.village + ', ';
                    }

                    if (data.address.county) {
                        locationInfo += data.address.county + ', ';
                    }

                    if (data.address.state_district) {
                        locationInfo += data.address.state_district + ', ';
                    }

                    if (data.address.state) {
                        locationInfo += data.address.state + '';
                    }

                    // if (data.address.country) {
                    //     locationInfo += data.address.country;
                    // }

                    $(".lokasi-data").html(locationInfo);
                } else {
                    $(".lokasi-data").html('Nama lokasi tidak ditemukan');
                }
            },
            error: function(error) {
                console.error('Gagal mendapatkan nama lokasi:', error);
                $(".lokasi-data").html('Gagal mendapatkan nama lokasi, pastikan GPS Aktif');
            }
        });
    }

    function buildNominatimUrl(latitude, longitude) {
        const baseUrl = 'https://nominatim.openstreetmap.org/reverse';
        return `${baseUrl}?lat=${latitude}&lon=${longitude}&format=json&addressdetails=1`;
    }

    if (!isNaN(sessionLatitude) && !isNaN(sessionLongitude)) {
        // Location data is available in the session, use it to update the UI
        updateUI({
            coords: {
                latitude: sessionLatitude,
                longitude: sessionLongitude
            }
        });
    } else {
        // Location data is not available in the session, fetch the current location
        getLocationAndUpdateUI();
    }
    // Function to fetch current location and update the UI
    function getLocationAndUpdateUI() {
        // Watch the position and call updateUI on changes
        var watchOptions = {
            enableHighAccuracy: true,
            maximumAge: 0,
            // maximumAge: 30000,
            timeout: 10000
        };

        // Untuk mendapatkan lokasi terkini satu kali
        var watchId = navigator.geolocation.getCurrentPosition(
            updateUI,
            handleLocationError,
            watchOptions
            // {
            //     enableHighAccuracy: true,
            //     maximumAge: 30000,
            //     timeout: 10000
            // }
        );
    }

    // Function to handle position changes
    function handlePositionChange(position) {
        latitude = position.coords.latitude;
        longitude = position.coords.longitude;

        updateUI(position);
    }

    // Function to set session data
    function setSessionData(latitude, longitude) {
        $.ajax({
            url: '<?= base_url('users/set_location_session') ?>',
            type: 'POST',
            data: {
                latitude,
                longitude
            },
            success: function(response) {
                console.log('Location session data set successfully');
            },
            error: function(error) {
                console.error('Failed to set location session data:', error);
            }
        });
    }

    // Function to handle location error
    function handleLocationError(error) {
        console.error('Gagal mendapatkan lokasi:', error);
        $(".lokasi-data").html('Gagal mendapatkan lokasi');

        if (!isNaN(sessionLatitude) && !isNaN(sessionLongitude)) {
            // Location data is available in the session, use it to update the UI
            updateUI({
                coords: {
                    latitude: sessionLatitude,
                    longitude: sessionLongitude
                }
            });
        }
    }

    function updateUI(position) {
        latitude = position.coords.latitude;
        longitude = position.coords.longitude;

        $(".lokasi").attr("data-latitude", latitude);
        $(".lokasi").attr("data-longitude", longitude);

        // Set session data
        setSessionData(latitude, longitude);

        // Update UI with new position information
        getPlaceName(latitude, longitude);

        // Nonaktifkan tombol absen masuk dan absen pulang jika sudah absen
        disableAbsenButtons(latitude, longitude);

        // Update status coordinate
        updateCoordinates(latitude, longitude);

        // Add the following line inside the navigator.geolocation.getCurrentPosition success callback
        updateNearestDistance(latitude, longitude, kodeKantorUser);

        // Update status based on nearest distance
        updateStatusBasedOnDistance(latitude, longitude);
    }

    function updateNearestDistance(latitude, longitude) {
        const allowedLocations = [{
                latitude: -7.445610843417763,
                longitude: 109.97591093621132,
                // kode_kantor: ['02']
                kode_kantor: <?php echo $kantor_sedayu_02; ?>
            }, // Kantor Sedayu
            {
                latitude: -7.461971861399689,
                longitude: 109.98020660636926,
                kode_kantor: <?php echo $kantor_sapuran_03; ?>
            }, // Kantor Sapuran
            {
                latitude: -7.34931690,
                longitude: 109.90654280,
                kode_kantor: <?php echo $kantor_pusat_01; ?>
            }, // Kantor Pusat
            {
                latitude: -7.34931690,
                longitude: 109.90654280,
                kode_kantor: <?php echo $kantor_wonosobo_05; ?>
            }, // Kantor Wonosobo
            {
                latitude: -7.3871189,
                longitude: 109.9611114,
                kode_kantor: <?php echo $kantor_kertek_04; ?>
            }, // Kantor Kertek
            {
                latitude: -7.45885742956058,
                longitude: 109.85569769430116,
                kode_kantor: <?php echo $kantor_kaliwiro_06; ?>
            }, // Kantor Kaliwiro 
            {
                latitude: -7.507866910342331,
                longitude: 110.0335132132964,
                kode_kantor: <?php echo $kantor_randusari_08; ?>
            }, // Kantor Randusari
            {
                latitude: -7.396602577966272,
                longitude: 109.69295985242302,
                kode_kantor: <?php echo $kantor_banjarnegara_07; ?>
            }, // Kantor Banjarnegara
            {
                latitude: -7.525556363924079,
                longitude: 110.00411724420917,
                kode_kantor: <?php echo $kantor_kepil_09; ?>
            }, // Kantor Kepil

            // Add more allowed locations as needed
        ];

        let nearestDistance = calculateNearestDistance(latitude, longitude, allowedLocations);
        let nearestKodeKantor = allowedLocations.find(location => calculateDistance(latitude, longitude, location.latitude, location.longitude) === nearestDistance / 1000)?.kode_kantor;

        $("#nearest-distance").text(nearestDistance.toFixed(2) + " meter");

        // Membandingkan dengan kode kantor pengguna
        let isValidKodeKantor = compareKodeKantor(nearestKodeKantor, kodeKantorUser);

        // Mapping kode kantor ke nama kantor
        const kantorNames = {
            '01': 'Kantor Pusat',
            '02': 'Kantor Sedayu',
            '03': 'Kantor Sapuran',
            '04': 'Kantor Kertek',
            '05': 'Kantor Wonosobo',
            '06': 'Kantor Kaliwiro',
            '07': 'Kantor Banjarnegara',
            '08': 'Kantor Randusari',
            '09': 'Kantor Kepil'
        }
        var userLevel = <?php echo json_encode($level); ?>;
        var idUser = <?php echo json_encode($id_user); ?>;
        const validBypassLevels = ['gm', 'fo', 'audit', 'mng_bisnis', 'kadiv_pemasaran', 'ofb', 'it', 'k_hrd', 'k_cabang', 'surveyor', 'kadiv_manrisk', 'kadiv_opr', 'k_arsip', 'satpam', 'kadiv_maal', 'fund_maal', 'kadiv_opr', 'umum_dan_pengadaan', 'ao'];
        const validBypassUsers = ['0'];
        if (isValidKodeKantor || validBypassLevels.includes(userLevel) || validBypassUsers.includes(idUser)) {
            console.log("Kode kantor sama.");
        } else {
            const nearestKodeKantorNames = nearestKodeKantor.map(kode => kantorNames[kode] || kode).join(', ');
            Swal.fire({
                icon: 'warning',
                title: 'Lokasi Kantor Tidak Valid',
                text: `Akun anda terdaftar di ${kantorNames[kodeKantorUser] || kodeKantorUser}, Silahkan melakukan absen di kantor tersebut`,
                // text: `Kantor terdekat: ${nearestKodeKantorNames}, Kantor Anda: ${kantorNames[kodeKantorUser] || kodeKantorUser}`,
                showConfirmButton: false,
                allowOutsideClick: false,
            });
        }
    }

    function compareKodeKantor(nearestKodeKantor, kodeKantorUser) {
        if (nearestKodeKantor.includes(kodeKantorUser)) {
            return true; // Kode kantor terdekat sama dengan kode kantor user
        } else {
            return false; // Kode kantor terdekat tidak sama dengan kode kantor user
        }
    }

    function calculateNearestDistance(lat, lon, allowedLocations) {
        var nearestDistance = Number.MAX_VALUE;

        for (var i = 0; i < allowedLocations.length; i++) {
            var allowedLocation = allowedLocations[i];
            var distance = calculateDistance(lat, lon, allowedLocation.latitude, allowedLocation.longitude);

            if (distance < nearestDistance) {
                nearestDistance = distance;
            }
        }

        return nearestDistance * 1000; // Convert distance to meters
    }

    function updateStatusBasedOnDistance(latitude, longitude) {
        var nearestDistance = $("#nearest-distance").text();
        var distanceThreshold = 50; // Set your desired threshold in meters

        // Convert nearestDistance to a numeric value
        nearestDistance = parseFloat(nearestDistance);

        // Update status and indicator based on distance
        // Pemeriksaan jarak dan penyesuaian warna
        if (nearestDistance < distanceThreshold) {
            document.getElementById("nearest-distance").classList.add("text-success");
            document.querySelector(".status-indicator").innerHTML = '<i class="fa fa-compass text-success"></i>';
        } else {
            document.getElementById("nearest-distance").classList.add("text-danger");
            document.querySelector(".status-indicator").innerHTML = '<i class="fa fa-compass text-danger"></i>';
        }
    }

    function disableAbsenButtons(latitude, longitude) {
        $.ajax({
            url: '<?= base_url('users/check_absen_status') ?>',
            type: 'POST',
            data: {
                latitude: latitude,
                longitude: longitude
            },
            success: function(response) {
                // var status_absen = JSON.parse(response);

                if (status.absen_masuk) {
                    $("#btnAbsenMasuk").prop("disabled", true);
                }

                if (status.absen_pulang) {
                    $("#btnAbsenPulang").prop("disabled", true);
                }
            },
            error: function(error) {
                console.error('Gagal memeriksa status absen:', error);
            }
        });
    }

    function sendLocationData(keterangan) {

        if (isAttendanceInProgress) {
            console.log('Attendance is already in progress.');
            return;
        }

        isAttendanceInProgress = true;

        latitude = $(".lokasi").data("latitude");
        longitude = $(".lokasi").data("longitude");

        // Check the user's level
        var userLevel = <?php echo json_encode($level); ?>;

        const validBypassLevels = ['gm'];
        // const validBypassLevels = ['gm', 'fo', 'audit', 'mng_bisnis'];

        // If the user is a super admin user, proceed with sending data without location check
        if (validBypassLevels.includes(userLevel.toLowerCase())) {
            sendAbsenData(keterangan, latitude, longitude);
        } else {
            // Array of allowed locations
            var allowedLocations = <?php echo $titik_absen; ?>;

            var isWithinAllowedRange = false;

            // Check if the user's location is within any of the allowed ranges
            for (var i = 0; i < allowedLocations.length; i++) {
                var allowedLocation = allowedLocations[i];
                var distance = calculateDistance(latitude, longitude, allowedLocation.latitude, allowedLocation.longitude);

                // Set a threshold for allowed distance, adjust as needed
                var distanceThreshold = <?php echo (float)$jarak_absen; ?>; // Adjust this threshold as needed

                if (distance <= distanceThreshold) {
                    isWithinAllowedRange = true;
                    break; // No need to check further if within range
                }
            }

            if (isWithinAllowedRange) {
                // Location is within one of the allowed ranges, proceed with sending data
                sendAbsenData(keterangan, latitude, longitude);
            } else {
                // Location is outside all allowed ranges, display a message or take appropriate action
                Swal.fire({
                    icon: "warning",
                    title: 'Anda berada di luar wilayah yang diizinkan untuk absen.',
                    confirmButtonColor: "#f44336",
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Reload halaman setelah konfirmasi
                        location.reload();
                    }
                });


                isAttendanceInProgress = false;
            }
        }
    }

    // Function to send absen data to the server

    function sendAbsenData(keterangan, latitude, longitude) {
        <?php
        $swalText = '';
        if (isset($absen)) {
            if ($absen < 1) {
                $swalText = 'Masuk';
            } elseif ($absen == 1) {
                $swalText = 'Pulang';
            } elseif ($absen >= 2) {
                $swalText = 'Selesai';
            }
        }
        ?>

        const swalText = '<?= $swalText ?>';
        const lokasiData = $(".lokasi-data").html();

        if (!lokasiData) {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan!',
                text: 'Lokasi Anda tidak ditemukan. Silakan Refresh atau periksa GPS anda.',
                confirmButtonText: 'OK',
                confirmButtonColor: "#f44336"
            }).then(() => {
                location.reload();
            });
        } else {
            Swal.fire({
                title: `<strong>Konfirmasi Absen ${swalText}</strong>\n${getCurrentTime()}`,
                html: `
        <div class="camera-container" style="text-align: center; margin-bottom: 10px;">
          <video id="cameraStream" autoplay playsinline style="width: 200px; height: 200px; border-radius: 50%; border: 2px solid #ccc; object-fit: cover; transform: scaleX(-1);"></video>
        </div>
        <div id="previewContainer" style="display: none; margin-top: 10px; text-align: center;">
          <canvas id="capturedPhoto" style="display:none; width: 200px; height: 200px; border-radius: 50%; border: 2px solid #ccc; object-fit: cover; transform: scaleX(-1);"></canvas>
          <img id="imagePreview" style="max-width: 100%; max-height: 200px;">
          <button type="button" id="retryCapture" class="btn btn-danger btn-sm" style="margin-top: 10px;">Ambil Ulang</button>
        </div>
        <p><i class="fa fa-street-view" aria-hidden="true"></i> <strong>${lokasiData}</strong></p>
        <p>Apakah Anda yakin ingin mengirim data absen?</p>
      `,
                showCancelButton: true,
                confirmButtonText: '<span style="font-size: 12px;"><i class="fa fa-thumbs-up"></i> OK</span>',
                cancelButtonText: '<span style="font-size: 12px;">Batal</span>',
                confirmButtonColor: "#f44336",
                customClass: {
                    confirmButton: 'swal-confirm-button',
                    cancelButton: 'swal-cancel-button'
                },
                didOpen: () => {
                    const videoElement = document.getElementById('cameraStream');
                    const capturedPhoto = document.getElementById('capturedPhoto');
                    const previewContainer = document.getElementById('previewContainer');
                    const imagePreview = document.getElementById('imagePreview');
                    const retryButton = document.getElementById('retryCapture');

                    startCameraStream(videoElement).then(() => {
                        retryButton.addEventListener('click', () => {
                            videoElement.style.display = 'block';
                            capturedPhoto.style.display = 'none';
                            previewContainer.style.display = 'none';
                            startCameraStream(videoElement);
                        });

                        // Tambahkan event listener untuk tombol OK
                        const confirmButton = document.querySelector('.swal2-confirm');
                        confirmButton.addEventListener('click', () => {
                            capturePhotoAndSend(latitude, longitude, keterangan);
                        });
                    }).catch(error => {
                        console.error("Error starting camera stream:", error);
                        Swal.close(); // Tutup Swal jika ada error saat memulai stream
                    });
                }
            }).then((result) => {
                if (result.isDismissed) {
                    location.reload();
                } else {
                    console.log('Pengiriman data absen dibatalkan');
                }
            });
        }
    }

    function getCurrentTime() {
        const now = new Date();
        const hours = now.getHours().toString().padStart(2, '0');
        const minutes = now.getMinutes().toString().padStart(2, '0');
        return `(${hours}:${minutes})`;
    }

    function startCameraStream(videoElement) {
        return new Promise((resolve, reject) => {
            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                navigator.mediaDevices.getUserMedia({
                        video: true
                    })
                    .then(function(stream) {
                        videoElement.srcObject = stream;
                        videoElement.onloadeddata = () => {
                            videoElement.play().then(() => resolve()).catch(reject);
                        };
                    })
                    .catch(function(error) {
                        console.error("Error accessing the camera: ", error);
                        reject(error);
                    });
            } else {
                console.log("Camera not supported by the browser.");
                reject("Camera not supported");
            }
        });
    }

    function capturePhotoAndSend(latitude, longitude, keterangan) {
        const videoElement = document.getElementById('cameraStream');
        const capturedPhoto = document.getElementById('capturedPhoto');
        const previewContainer = document.getElementById('previewContainer');
        const imagePreview = document.getElementById('imagePreview');
        const canvas = capturedPhoto;

        canvas.width = videoElement.videoWidth;
        canvas.height = videoElement.videoHeight;
        const context = canvas.getContext('2d');
        context.drawImage(videoElement, 0, 0, canvas.width, canvas.height);

        const photoDataUrl = canvas.toDataURL('image/jpeg');

        imagePreview.src = photoDataUrl;
        videoElement.style.display = 'none';
        capturedPhoto.style.display = 'block';
        previewContainer.style.display = 'block';

        Swal.fire({
            title: 'Mengirim foto...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: '<?= base_url('users/absen') ?>/' + keterangan,
            type: 'POST',
            data: {
                latitude: latitude,
                longitude: longitude,
                photo: photoDataUrl
            },
            success: function(response) {
                console.log('Data lokasi dan foto berhasil dikirim ke server');
                Swal.close();
                showSuccessPopup(); // Tampilkan popup sukses setelah pengiriman berhasil
                setTimeout(function() {
                    location.reload();
                }, 1500);
            },
            error: function(error) {
                console.error('Gagal mengirim data lokasi dan foto ke server:', error);
                Swal.close();
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Terjadi kesalahan saat mengirim data. Silakan coba lagi.'
                });
            }
        });
    }

    function sendIzinData(keterangan, latitude, longitude) {
        // Determine the text based on the keterangan parameter
        let swalText = '';
        if (keterangan === 'Izin') {
            swalText = 'Izin';
        } else if (keterangan === 'Cuti') {
            swalText = 'Cuti';
        } else if (keterangan === 'Sakit') {
            swalText = 'Sakit';
        } else if (keterangan === 'Perjalanan_tugas') {
            swalText = 'Perjalanan Tugas';
        }

        // Show a confirmation dialog before sending the data
        Swal.fire({
            title: `Konfirmasi ${swalText}`, // Menggunakan template literals di sini
            text: `Apakah Anda yakin ingin mengirim data ${swalText} ?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: '<span style="font-size: 12px;"><i class="fa fa-thumbs-up"></i>  OK</span>',
            cancelButtonText: '<span style="font-size: 12px;">Batal</span>',
            confirmButtonColor: "#f44336",
            customClass: {
                confirmButton: 'swal-confirm-button',
                cancelButton: 'swal-cancel-button'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // If the user clicks "OK," proceed with sending the data
                $.ajax({
                    url: '<?= base_url('users/absen') ?>/' + keterangan,
                    type: 'POST',
                    data: {
                        latitude: latitude,
                        longitude: longitude
                    },
                    success: function(response) {
                        console.log('Data lokasi berhasil dikirim ke server');
                        showSuccessPopup();
                        // Tunda reload halaman selama 1.5 detik (sesuaikan jika perlu)
                        setTimeout(function() {
                            location.reload(); // Reload halaman setelah absen berhasil
                        }, 1500); // Reload halaman setelah absen berhasil
                    },
                    error: function(error) {
                        console.error('Gagal mengirim data lokasi ke server:', error);
                    }
                });
            } else {
                console.log('Pengiriman data absen dibatalkan');
                location.reload();
            }
        });
    }

    // Function to show SweetAlert success popup
    function showSuccessPopup() {
        Swal.fire({
            icon: 'success',
            title: 'Absen Berhasil!',
            // text: 'Data absen berhasil dikirim.',
            showConfirmButton: false,
            timer: 1000 // Automatically close the popup after 1.5 seconds
        });
    }

    // Function to update coordinate
    function updateCoordinates(latitude, longitude) {
        $("#latitude").text(latitude);
        $("#longitude").text(longitude);
    }

    // Function to calculate the distance between two sets of latitude and longitude
    function calculateDistance(lat1, lon1, lat2, lon2) {
        var R = 6371; // Radius of the earth in kilometers
        var dLat = deg2rad(lat2 - lat1);
        var dLon = deg2rad(lon2 - lon1);
        var a =
            Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
            Math.sin(dLon / 2) * Math.sin(dLon / 2);
        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        var distance = R * c; // Distance in kilometers
        return distance;
    }

    // Function to convert degrees to radians
    function deg2rad(deg) {
        return deg * (Math.PI / 180)
    }

    function updateClock() {
        var currentTimeElement = document.getElementById('current-time');
        if (currentTimeElement) {
            currentTimeElement.innerText = new Date().toLocaleTimeString('en-US', {
                hour12: false
            });
        }
    }

    $(document).ready(function() {
        // Tambahkan event listener untuk tombol refresh halaman
        $('#btnRefreshPage').on('click', function() {
            location.reload(true);
            updateUI(latitude, longitude);
        });
    });

    function animateButton() {
        // Tambahkan class 'clicked' saat tombol diklik
        document.getElementById('btnRefreshPage').classList.add('clicked');

        // Hilangkan class 'clicked' setelah animasi selesai
        setTimeout(function() {
            document.getElementById('btnRefreshPage').classList.remove('clicked');
        }, 300); // Sesuaikan durasi animasi (dalam milidetik) dengan durasi CSS
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Tambahkan pengecekan apakah elemen dengan ID 'btnAbsenPulang' dan 'infoPulang' ada
        var btnAbsenPulang = document.getElementById('btnAbsenPulang');
        var infoPulang = document.getElementById('infoPulang');

        // Pengecekan apakah elemen ditemukan sebelum mengakses properti 'style'
        if (btnAbsenPulang && infoPulang) {
            var currentHour = new Date().getHours();
            var level = <?php echo json_encode($level); ?>;

            if (
                // Pengecekan jam untuk semua level 
                ((currentHour >= 12 && currentHour < 13) ||
                    // Pengecekan jam untuk level 'satpam'
                    (level === 'satpam' && currentHour >= 8 && currentHour < 21) ||
                    // Pengecekan jam untuk level selain 'satpam'
                    (level !== 'satpam' && currentHour >= 13 && currentHour < 21))
            ) {
                btnAbsenPulang.style.display = '';
                infoPulang.style.display = 'none';
            } else {
                btnAbsenPulang.style.display = 'none';
                infoPulang.style.display = '';
            }
        } else {
            console.error("Elemen dengan ID 'btnAbsenPulang' atau 'infoPulang' tidak ditemukan.");
        }
    });

    function startTimer(action) {
        pressTimer = setTimeout(function() {
            sendLocationData(action);
        }, 1000); // 1000 milliseconds (1 second)
    }

    function stopTimer() {
        clearTimeout(pressTimer);
        updateNearestDistance(latitude, longitude, kodeKantorUser);
    }

    const _baseUrl = "<?php echo base_url(); ?>";
    document.addEventListener('DOMContentLoaded', function() {
        function getDeviceInfo() {
            const originalUserAgent = navigator.userAgent;

            // Filter user agent string as needed
            const filteredUserAgent = originalUserAgent.replace(/Chrome\/\d+\.\d+\.\d+\.\d+/i, '');

            const deviceInfo = {
                userAgent: filteredUserAgent,
                platform: navigator.platform,
            };

            const deviceInfoJSON = JSON.stringify(deviceInfo);

            $.ajax({
                type: "POST",
                url: _baseUrl + "users/update_device_info", // Adjust baseUrl as needed
                data: {
                    device_info: deviceInfoJSON
                },
                success: function(response) {
                    console.log('Device info updated successfully:', response);
                },
                error: function(error) {
                    console.error('Error updating device info:', error);
                }
            });
        }

        // Call the function to get and send device info
        getDeviceInfo();
    });

    // peringatan device
    document.addEventListener("DOMContentLoaded", function() {
        function showDeviceWarningPopup() {
            Swal.fire({
                icon: 'warning',
                title: 'Perangkat tidak terdaftar',
                text: 'Harap melakukan absen menggunakan perangkat yang sudah terdaftar untuk akun anda.',
                showConfirmButton: false, // Menyembunyikan tombol OK
                allowOutsideClick: false // Tidak memperbolehkan menutup dengan mengklik di luar kotak peringatan
            }).then(function() {
                // Membandingkan device_info dengan device_reg setelah pengguna menutup SweetAlert
                var currentDeviceInfo = document.getElementById('deviceInfo').value;
                if (currentDeviceInfo !== deviceReg) {
                    // Jika tidak sama, panggil kembali fungsi SweetAlert
                    showDeviceWarningPopup();
                }
            });
        }

        // Membandingkan device_info dengan device_reg saat halaman dimuat
        var currentDeviceInfo = document.getElementById('deviceInfo').value;
        if (currentDeviceInfo !== deviceReg) {
            // Jika tidak sama, panggil kembali fungsi SweetAlert
            showDeviceWarningPopup();
        }
    });

    function getDeviceInfo() {
        // Mendapatkan user agent dari navigator
        const originalUserAgent = navigator.userAgent;

        // Menghilangkan bagian setelah "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36"
        const filteredUserAgent = originalUserAgent.replace(/Chrome\/\d+\.\d+\.\d+\.\d+/i, '');

        // Membuat objek deviceInfo tanpa bagian yang dihapus
        const deviceInfo = {
            userAgent: filteredUserAgent,
            platform: navigator.platform,
            // Informasi perangkat lainnya sesuai kebutuhan Anda
        };

        // Mengubah objek deviceInfo menjadi JSON
        var deviceInfoJSON = JSON.stringify(deviceInfo);

        // Menyimpan deviceInfo ke input hidden
        document.getElementById('deviceInfo').value = deviceInfoJSON;
    }

    function izin() {
        // Panggil sendAbsenData dengan keterangan Izin
        sendIzinData('Izin', <?= $latitude ?>, <?= $longitude ?>);
    }

    function cuti() {
        // Panggil sendAbsenData dengan keterangan Cuti
        window.location.href = '<?php echo base_url(); ?>users/edit_absen_tambah_cuti';
    }

    function sakit() {
        // Panggil sendAbsenData dengan keterangan Sakit
        window.location.href = '<?php echo base_url(); ?>users/edit_absen_tambah_sakit';
    }

    function perjalanan_tugas() {
        // Panggil sendAbsenData dengan keterangan Sakit
        window.location.href = '<?php echo base_url(); ?>users/edit_absen_tambah_perjalanan_tugas';
    }

    function toggleContentGroup() {
        var contentGroup = document.getElementById("contentGroup");
        var toggleButton = document.getElementById("toggleButton");
        var row = document.querySelector(".row");

        // Toggle the visibility of the content-group
        contentGroup.classList.toggle("show");

        // Change the icon based on the visibility
        if (contentGroup.classList.contains("show")) {
            row.style.display = "block";
            toggleButton.innerHTML = '<i class="fa fa-minus" aria-hidden="true"></i>';
        } else {
            row.style.display = "flex";
            toggleButton.innerHTML = '<i class="fa fa-plus"></i>';
        }
    }

    // Inisialisasi peta dengan kontrol fullscreen di bagian kanan atas
    var map = L.map('map', {
        fullscreenControl: {
            position: 'bottomright' // Atur posisi fullscreen control ke top right
        }
    }).setView([-7.5, 109.9], 11); // Set initial view to a default location

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(map);

    // Function to create markers for kantor locations
    function createKantorMarkers() {
        var kantorLocations = <?php echo $marker; ?>

        var kantorMarkers = [];
        for (var i = 0; i < kantorLocations.length; i++) {
            var kantor = kantorLocations[i];

            // Example of customizing marker color and popup content
            var marker = L.marker([kantor.lat, kantor.lng], {
                    icon: L.icon({
                        iconUrl: 'https://img.icons8.com/?size=100&id=inX6oX9dQzDs&format=png&color=000000', // URL to custom marker icon
                        iconSize: [25, 25], // size of the icon
                        iconAnchor: [12, 25], // point of the icon which will correspond to marker's location
                        popupAnchor: [1, -18], // point from which the popup should open relative to the iconAnchor
                    })
                })
                .bindPopup(kantor.name)
                .addTo(map);

            kantorMarkers.push(marker);
        }
        return kantorMarkers;
    }

    // Function to handle geolocation success
    function onLocationFound(latitude, longitude) {
        var userLatLng = L.latLng(latitude, longitude);
        var userMarker = L.marker(userLatLng).addTo(map);
        // userMarker.bindPopup("Lokasi Anda").openPopup();

        // Add circle around user location
        var circle = L.circle(userLatLng, {
            color: 'green',
            fillColor: '#AFE1AF',
            fillOpacity: 0.3,
            radius: 30 // Radius in meters
        }).addTo(map);

        var kantorMarkers = createKantorMarkers();

        var minDistance = Infinity;
        var nearestKantor = null;

        for (var i = 0; i < kantorMarkers.length; i++) {
            var kantorMarker = kantorMarkers[i];
            var distance = userLatLng.distanceTo(kantorMarker.getLatLng());
            if (distance < minDistance) {
                minDistance = distance;
                nearestKantor = kantorMarker.getPopup().getContent();
            }
        }

        var radius = Math.round(minDistance);
        userMarker.bindPopup("Jarak Kamu sekitar " + radius + " meter dari " + nearestKantor).openPopup();
    }

    // Function to handle geolocation error
    function onLocationError(e) {
        // alert(e.message);
    }

    // Get current location using geolocation API
    map.locate({
        setView: true,
        maxZoom: 16
    });

    map.on('locationfound', function(e) {
        onLocationFound(e.latitude, e.longitude);
    });
    map.on('locationerror', onLocationError);

    function openGoogleMaps() {
        var lat = document.getElementById('latitude').textContent;
        var lng = document.getElementById('longitude').textContent;
        window.open('https://www.google.com/maps?q=' + lat + ',' + lng, '_blank');
    }

    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById('btnCheckAbsen').style.visibility = 'hidden';
    });
</script>
<script>
    // Passing the decoded PHP arrays into JavaScript
    const kantorPusat = <?php echo json_encode($kantor_pusat_01); ?>;
    const kantorSedayu = <?php echo json_encode($kantor_sedayu_02); ?>;
    const kantorSapuran = <?php echo json_encode($kantor_sapuran_03); ?>;
    const kantorKertek = <?php echo json_encode($kantor_kertek_04); ?>;
    const kantorWonosobo = <?php echo json_encode($kantor_wonosobo_05); ?>;
    const kantorKaliwiro = <?php echo json_encode($kantor_kaliwiro_06); ?>;
    const kantorBanjarnegara = <?php echo json_encode($kantor_banjarnegara_07); ?>;
    const kantorRandusari = <?php echo json_encode($kantor_randusari_08); ?>;
    const kantorKepil = <?php echo json_encode($kantor_kepil_09); ?>;
    

    // Check the result for all kantor variables
    console.log("Kantor Pusat:", kantorPusat);
    console.log("Kantor Sedayu:", kantorSedayu);
    console.log("Kantor Sapuran:", kantorSapuran);
    console.log("Kantor Kertek:", kantorKertek);
    console.log("Kantor Wonosobo:", kantorWonosobo);
    console.log("Kantor Kaliwiro:", kantorKaliwiro);
    console.log("Kantor Banjarnegara:", kantorBanjarnegara);
    console.log("Kantor Randusari:", kantorRandusari);
    console.log("Kantor Kepil:", kantorKepil);
</script>
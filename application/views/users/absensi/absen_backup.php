<?php
$cek = $user->row();
$id_user = $cek->id_user;
$level = $cek->level;
$device_info = $cek->device_info;
$device_reg = $cek->device_reg;
$nama = $cek->nama_lengkap;
$level = $cek->level;
$status = $cek->status;
$tgl = date('m-Y');
$cek_latitude = $cek->latitude;
$cek_longitude = $cek->longitude;
$latitude = $this->session->userdata('latitude');
$longitude = $this->session->userdata('longitude');

function getHari($dayNumber)
{
    $days = [
        1 => 'Senin',
        2 => 'Selasa',
        3 => 'Rabu',
        4 => 'Kamis',
        5 => 'Jumat',
        6 => 'Sabtu',
        7 => 'Minggu',
    ];

    return $days[$dayNumber];
}

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
</style>

<!-- Main content -->
<div class="container">
    <div class="content">
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
                                    <li><a href="<?= base_url('users/edit_absen_manual'); ?>"><i class="fa fa-calendar"></i> Data Absen Manual</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- Membersihkan float -->
                    <div class="clearfix"></div>
                    <hr>
                    <fieldset class="content-group">
                        <div class="text-container">
                            <div class="info">
                                <!-- <?= getHari(date('N')) ?> -->
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
                                <p>Jarak : <br><b><span id="nearest-distance" class="distance-indicator"><i class="fas fa-spinner fa-spin"></i></span> m</b></p>
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
                            <?php if (is_weekend()) : ?>
                                <div class="alert alert-danger">Hari ini libur. Tidak Perlu absen</div>
                            <?php else : ?>
                                <?php if ($absen < 1) : ?>
                                    <button id="btnAbsenMasuk" ontouchstart="startTimer('masuk')" ontouchend="stopTimer()" class="btn btn-secondary circle-btn"><i class="fas fa-fingerprint"></i></button>
                                <?php elseif ($absen == 1) : ?>
                                    <button id="btnAbsenPulang" ontouchstart="startTimer('pulang')" ontouchend="stopTimer()" class="btn btn-success circle-btn" style="display: none;"><i class="fas fa-fingerprint"></i></button>

                                    <div class="keterangan">
                                        <p>
                                            <?php if ($keterangan == 'Izin') : ?>
                                        <div id="infoPulang" class="alert alert-primary" style="display: ;"> Hai <?php echo htmlspecialchars(ucwords($nama)); ?>! Hari ini kamu <b>(Izin) ??</b>
                                        </div>
                                    <?php elseif ($keterangan == 'Cuti') : ?>
                                        <div id="infoPulang" class="alert alert-primary" style="display: ;"><?php echo htmlspecialchars(ucwords($nama)); ?>! Hari ini kamu <b>(Cuti) ???</b>
                                        </div>
                                    <?php elseif ($keterangan == 'Sakit') : ?>
                                        <div id="infoPulang" class="alert alert-info" style="display: ;">Hai <?php echo htmlspecialchars(ucwords($nama)); ?>! Hari ini kamu sedang <b>(Sakit)</b> ya, semoga cepat sembuh ya! ????
                                        </div>
                                    <?php elseif ($keterangan == 'Masuk') : ?>
                                        <div id="infoPulang" class="alert alert-success" style="display: ;">Selamat bekerja <?php echo htmlspecialchars(ucwords($nama)); ?>
                                        </div>
                                    <?php else : ?>
                                        <!-- kosong -->
                                    <?php endif; ?>
                                    </p>
                                    </div>

                                <?php elseif ($absen >= 2) : ?>
                                    <div class="alert alert-success">Anda sudah melakukan absensi masuk dan pulang hari ini.
                                        Terimakasih ??
                                    </div>
                                <?php endif; ?>
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
        <?php if ($absen < 1) : ?>
            <div class="row">
                <div class="panel panel-flat">
                    <?php echo $this->session->flashdata('msg'); ?>
                    <div class="panel-body">
                        <!-- Toggle button -->
                        <div style="text-align: center;">
                            <button id="toggleButton" onclick="toggleContentGroup()" class="btn btn-secondary"><i class="fas fa-calendar"></i> Opsi Izin</button>
                        </div>

                        <fieldset class="content-group2" id="contentGroup" style="display: none;">
                            <legend></legend>
                            <div class="btn-container">
                                <button id="btnIzin" onclick="izin()" class="btn btn-info">Izin</button>
                                <button id="btnCuti" onclick="cuti()" class="btn btn-success">Cuti</button>
                                <button id="btnSakit" onclick="sakit()" class="btn btn-primary">Sakit</button>
                            </div>
                        </fieldset>

                    </div>
                </div>
            </div>
        <?php endif; ?>
        <br><br>

        <script>
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

            function toggleContentGroup() {
                var contentGroup = document.getElementById("contentGroup");
                var toggleButton = document.getElementById("toggleButton");

                // Toggle the visibility of the content-group
                contentGroup.classList.toggle("show");

                // Change the icon based on the visibility
                if (contentGroup.classList.contains("show")) {
                    toggleButton.innerHTML = '<i class="fa fa-eject" aria-hidden="true"></i>';
                } else {
                    toggleButton.innerHTML = '<i class="fas fa-calendar"></i> Opsi Izin';
                }
            }
        </script>

        <style>
            .content-group2 {
                display: none;
            }

            .content-group.show {
                display: block;
            }

            .btn-container {
                display: flex;
                justify-content: space-between;
                width: 90%;
                /* Sesuaikan lebar container dengan kebutuhan */
                margin: auto;
                /* Tengahkan container */
            }

            .btn-container button {
                width: 30%;
                /* Sesuaikan lebar tombol dengan kebutuhan */
                padding: 10px;
                /* Sesuaikan padding dengan kebutuhan */
                font-size: 16px;
                /* Sesuaikan ukuran font dengan kebutuhan */
            }

            /* Ubah warna tombol saat di-hover */
            .btn-container button:hover {
                opacity: 0.8;
            }
        </style>

    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let isAttendanceInProgress = false;

    function getPlaceName(latitude, longitude) {
        function buildNominatimUrl(latitude, longitude) {
            const baseUrl = 'https://nominatim.openstreetmap.org/reverse';
            const format = 'json';
            const addressDetails = 1;

            return `${baseUrl}?lat=${latitude}&lon=${longitude}&format=${format}&addressdetails=${addressDetails}`;
        }

        // Penggunaan:
        var url = buildNominatimUrl(latitude, longitude);

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

    // Check if location data is available in the database
    var sessionLatitude = <?php echo $cek_latitude; ?>;
    var sessionLongitude = <?php echo $cek_longitude; ?>;

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
        // var watchOptions = {
        //     enableHighAccuracy: true,
        //     maximumAge: 30000,
        //     timeout: 10000
        // };

        // Untuk mendapatkan lokasi terkini satu kali
        var watchId = navigator.geolocation.getCurrentPosition(
            updateUI,
            handleLocationError,
            // watchOptions 
            {
                enableHighAccuracy: true,
                maximumAge: 30000,
                timeout: 10000
            }
        );
    }

    // Function to handle position changes
    function handlePositionChange(position) {
        var latitude = position.coords.latitude;
        var longitude = position.coords.longitude;

        // Update UI with new position information
        getPlaceName(latitude, longitude);

        var locationInfo = 'Latitude: ' + latitude + ', Longitude: ' + longitude;
        $(".lokasi-data").html(locationInfo);

        // Nonaktifkan tombol absen masuk dan absen pulang jika sudah absen
        disableAbsenButtons(latitude, longitude);

        // Update nearest distance
        updateNearestDistance(latitude, longitude);

        // Set session data
        setSessionData(latitude, longitude);
    }



    // Function to set session data
    function setSessionData(latitude, longitude) {
        $.ajax({
            url: '<?= base_url('users/set_location_session') ?>',
            type: 'POST',
            data: {
                latitude: latitude,
                longitude: longitude
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
    }

    function updateUI(position) {
        var latitude = position.coords.latitude;
        var longitude = position.coords.longitude;

        // Set session data
        setSessionData(latitude, longitude);

        // Update UI with new position information
        getPlaceName(latitude, longitude);

        var locationInfo = 'Latitude: ' + latitude + ', Longitude: ' + longitude;
        $(".lokasi-data").html(locationInfo);

        // Nonaktifkan tombol absen masuk dan absen pulang jika sudah absen
        disableAbsenButtons(latitude, longitude);

        function updateNearestDistance() {
            let latitude = $(".lokasi").data("latitude");
            let longitude = $(".lokasi").data("longitude");
            const allowedLocations = [{
                    latitude: -7.445610843417763,
                    longitude: 109.97591093621132
                }, // Kantor Sedayu
                {
                    latitude: -7.34931690,
                    longitude: 109.90654280
                }, // Kantor Pusat
                {
                    latitude: -7.3871189,
                    longitude: 109.9611114
                }, // Kantor Kertek
                {
                    latitude: -7.45885742956058,
                    longitude: 109.85569769430116
                }, // Kantor Kaliwiro 
                {
                    latitude: -7.507866910342331,
                    longitude: 110.0335132132964
                }, // Kantor Randusari
                {
                    latitude: -7.396602577966272,
                    longitude: 109.69295985242302
                }, // Kantor Banjarnegara
                {
                    latitude: -7.525556363924079,
                    longitude: 110.00411724420917
                }, // Kantor Kepil
                {
                    latitude: -7.2915327,
                    longitude: 109.9254426
                }, // Rumah
                // Add more allowed locations as needed
            ];

            let nearestDistance = calculateNearestDistance(latitude, longitude, allowedLocations);
            $("#nearest-distance").text(nearestDistance.toFixed(2));
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

        // Add the following line inside the navigator.geolocation.getCurrentPosition success callback
        updateNearestDistance(latitude, longitude);

        // Update status based on nearest distance
        updateStatusBasedOnDistance(latitude, longitude);
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

    // Check if geolocation is supported
    if (navigator.geolocation) {
        // Watch the position and call updateUI on changes
        var watchOptions = {
            enableHighAccuracy: true, // Use GPS if available
            maximumAge: 30000, // Maximum age of cached position (30 seconds)
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

        var latitude = $(".lokasi").data("latitude");
        var longitude = $(".lokasi").data("longitude");

        // Check the user's level
        var userLevel = <?php echo json_encode($level); ?>;

        // If the user is a marketing user, proceed with sending data without location check
        if (userLevel.toLowerCase() === 'marketing') {
            sendAbsenData(keterangan, latitude, longitude);
        } else {
            // Array of allowed locations
            var allowedLocations = [{
                    latitude: -7.445610843417763,
                    longitude: 109.97591093621132
                }, // Kantor Sedayu
                {
                    latitude: -7.34931690,
                    longitude: 109.90654280
                }, // Kantor Pusat
                {
                    latitude: -7.3871189,
                    longitude: 109.9611114
                }, // Kantor Kertek
                {
                    latitude: -7.45885742956058,
                    longitude: 109.85569769430116
                }, // Kantor Kaliwiro 
                {
                    latitude: -7.507866910342331,
                    longitude: 110.0335132132964
                }, // Kantor Randusari
                {
                    latitude: -7.396602577966272,
                    longitude: 109.69295985242302
                }, // Kantor Banjarnegara
                {
                    latitude: -7.525556363924079,
                    longitude: 110.00411724420917
                }, // Kantor Kepil
                {
                    latitude: -7.2915327,
                    longitude: 109.9254426
                }, // Rumah
                // {
                //     latitude: -7.34931690,
                //     longitude: 109.90654280
                // }, 

            ];

            var isWithinAllowedRange = false;

            // Check if the user's location is within any of the allowed ranges
            for (var i = 0; i < allowedLocations.length; i++) {
                var allowedLocation = allowedLocations[i];
                var distance = calculateDistance(latitude, longitude, allowedLocation.latitude, allowedLocation.longitude);

                // Set a threshold for allowed distance, adjust as needed
                var distanceThreshold = 0.030; // Adjust this threshold as needed

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
                });

                isAttendanceInProgress = false;
            }
        }
    }

    // Function to send absen data to the server
    function sendAbsenData(keterangan, latitude, longitude) {
        // Determine the text based on the $absen value
        <?php
        $swalText = '';
        if ($absen < 1) {
            $swalText = 'Masuk';
        } elseif ($absen == 1) {
            $swalText = 'Pulang';
        } elseif ($absen >= 2) {
            $swalText = 'Selesai';
        }
        ?>

        // Show a confirmation dialog before sending the data
        Swal.fire({
            title: `Konfirmasi Absen <?= $swalText ?>\n${getCurrentTime()}`,
            text: `Apakah Anda yakin ingin mengirim data absen\n\n <?= $swalText ?> ?`,
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
                // Handle "Batal" case as needed
            }
        });

        // Function to get the current time
        function getCurrentTime() {
            const now = new Date();
            const hours = now.getHours().toString().padStart(2, '0');
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const currentTime = `${hours}:${minutes}`;
            return `(${currentTime})`;
        }
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
                // Handle "Batal" case as needed
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

    // Update the clock every second
    setInterval(updateClock, 1000);

    // Initial call to display the time immediately
    updateClock();

    $(document).ready(function() {
        // Tambahkan event listener untuk tombol refresh halaman
        $('#btnRefreshPage').on('click', function() {
            location.reload(true); // Reload halaman dengan melewati cache
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

    // peringatan device
    document.addEventListener("DOMContentLoaded", function() {
        function showDeviceWarningPopup() {
            Swal.fire({
                icon: 'warning',
                title: 'Perangkat tidak terdaftar',
                text: 'Harap melakukan absen menggunakan perangkat yang sudah terdaftar untuk akun anda dan silahkan login ulang.',
                showConfirmButton: false, // Menyembunyikan tombol OK
                allowOutsideClick: false // Tidak memperbolehkan menutup dengan mengklik di luar kotak peringatan
            }).then(function() {
                // Membandingkan device_info dengan device_reg setelah pengguna menutup SweetAlert
                if ('<?php echo $device_info; ?>' !== '<?php echo $device_reg; ?>') {
                    // Jika tidak sama, panggil kembali fungsi SweetAlert
                    showDeviceWarningPopup();
                }
            });
        }

        // Membandingkan device_info dengan device_reg saat halaman dimuat
        if ('<?php echo $device_info; ?>' !== '<?php echo $device_reg; ?>') {
            // Jika tidak sama, panggil fungsi SweetAlert
            showDeviceWarningPopup();
        }
    });

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


    // press button
    let pressTimer;

    function startTimer(action) {
        pressTimer = setTimeout(function() {
            sendLocationData(action);
        }, 1000); // 1000 milliseconds (1 second)
    }

    function stopTimer() {
        clearTimeout(pressTimer);
        updateNearestDistance();
    }
</script>
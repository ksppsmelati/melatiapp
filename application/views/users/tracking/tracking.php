<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<!-- Leaflet JavaScript -->
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

<!-- Include Leaflet.Fullscreen CSS and JavaScript -->
<link rel="stylesheet" href="https://unpkg.com/leaflet-fullscreen/dist/leaflet.fullscreen.css" />
<script src="https://unpkg.com/leaflet-fullscreen/dist/Leaflet.fullscreen.min.js"></script>

<style>
    .table tbody tr:nth-child(odd) {
        background-color: #f2f2f2;
        /* Warna abu-abu untuk baris ganjil */
    }

    .table tbody tr:nth-child(even) {
        background-color: #fff;
        /* Warna putih untuk baris genap */
    }
</style>
<!-- Main content -->
<div class="container">
    <!-- Content area -->
    <div class="content">
        <?php echo $this->session->flashdata('msg'); ?>

        <!-- Map content -->
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <legend class="text-bold"><i class="fa fa-street-view"></i> Tracking Marketing KSPPS MELATI
                    </legend>

                    <!--map content-->
                    <div id="userMap" style="height: 400px;"></div>
                </div>
            </div>
        </div>
        <!-- /Map content -->


        <!-- Blog content -->
        <div class="row">
            <div class="panel panel-flat">
                <div class="table-responsive">
                    <!-- Display user tracking data -->
                    <table class="table datatable-basic" width="100%">
                        <thead>
                            <tr>
                                <!--<th>User ID</th>-->
                                <th>Nama</th>
                                <th>Lokasi</th>
                                <th>Kantor</th>
                                <th>Update Terakhir</th>
                                <th>Status</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($userLocations as $location) : ?>
                                <?php
                                // Memanggil metode getOnlineStatus dari model User_model
                                $onlineStatus = $this->User_model->getOnlineStatus($location->username);

                                // Tentukan teks dan warna berdasarkan status online atau offline
                                $statusText = ($onlineStatus == '1') ? 'Online' : 'Offline';
                                $statusColor = ($onlineStatus == '1') ? 'green' : 'red';
                                ?>
                                <tr>
                                    <!--<td><?php echo $location->id_user; ?></td>-->
                                    <td <?php if ($onlineStatus == '0')
                                            echo 'style="color: red;"'; ?>>
                                        <a href="users/pengguna/d/<?php echo $location->id_user; ?>"><?php echo $location->username; ?></a>
                                    </td>
                                    <td class="lokasi-data" data-latitude="<?php echo $location->latitude; ?>" data-longitude="<?php echo $location->longitude; ?>">
                                        <!-- Location name will be displayed here -->
                                    </td>
                                    <td>
                                    <?php echo $kodeKantorText = getKodeKantorText($location->kode_kantor); ?>
                                    </td>

                                    <td class="loc-update-time">
                                        <?php
                                        // Format waktu sesuai dengan preferensi Anda
                                        $timestamp = strtotime($location->loc_update_time); // Ubah loc_update_time menjadi timestamp jika perlu
                                        $tanggal = date('Y-m-d', $timestamp); // Format tanggal (misalnya: 04-10-2023)
                                        $jam = date('H:i:s', $timestamp); // Format jam (misalnya: 14:30:00)

                                        // Gunakan CSS inline untuk mengubah warna teks jam menjadi hijau
                                        echo $tanggal . ' <span style="color: green; font-weight: bold;"> - ' . $jam . '</span>';
                                        ?>
                                    </td>
                                    <td class="status-data">
                                        <span style="color: <?php echo $statusColor; ?>">
                                            <?php echo $statusText; ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
        <!-- /Blog content -->

    </div>
    <!-- /content area -->
</div>
<!-- /main content -->
<script>
    // JavaScript for reverse geocoding and auto-update 
    // Function to get location name based on latitude and longitude using Photon API
    async function getLocationName(latitude, longitude, element) {
        // Ensure valid latitude and longitude values
        if (!isValidCoordinate(latitude) || !isValidCoordinate(longitude)) {
            console.error('Invalid latitude or longitude values.');
            return;
        }

        // Show loading spinner while fetching data
        element.html('<i class="fas fa-spinner fa-spin"></i>');

        try {
            const response = await fetch(`https://photon.komoot.io/reverse?lat=${latitude}&lon=${longitude}`);

            if (!response.ok) {
                throw new Error(`Failed to fetch location data. Status: ${response.status}`);
            }

            const data = await response.json();
            var locationInfo = extractLocationInfo(data);
            var mapLink = generateMapLink(latitude, longitude, locationInfo);

            // Display the location information in the specified element
            element.html(mapLink);
        } catch (error) {
            console.error('Error fetching location data:', error);

            // Display an error message in the specified element
            element.html('<i class="fa-regular fa-clock"></i>');
        }
    }

    // Helper function to check if a coordinate is valid
    function isValidCoordinate(coord) {
        return typeof coord === 'number' && !isNaN(coord) && isFinite(coord);
    }

    // Function to generate a clickable map link
    function generateMapLink(latitude, longitude, locationInfo) {
        var mapLink = `<a href="https://maps.google.com/?q=${latitude},${longitude}" target="_blank">${locationInfo}</a>`;
        return mapLink;
    }

    // Function to extract location info from Photon API response
    function extractLocationInfo(data) {
        if (data.features && data.features.length > 0) {
            var properties = data.features[0].properties;
            var locationName = properties.name || '';
            var stateDistrict = properties.state_district || ''; // Name of Kecamatan
            var countyName = properties.county || ''; // Name of Kabupaten

            var locationInfo = [locationName, stateDistrict, countyName].filter(Boolean).join(', ');

            if (locationInfo) {
                return locationInfo;
            } else {
                return 'Location not found';
            }
        } else {
            return 'Location not found';
        }
    }

    // Function to periodically update location names for each user
    // Function to update the location names for each user
    function updateLocationNames() {
        // console.log("Updating location names...");
        $(".lokasi-data").each(function() {
            var latitude = $(this).data("latitude");
            var longitude = $(this).data("longitude");
            var element = $(this);

            // Check if latitude and longitude are both 0
            if (latitude === 0 && longitude === 0) {
                element.text('-'); // Set the text to '-'
            } else {
                getLocationName(latitude, longitude, element);
            }
        });
    }

    // Initial call to update location names
    updateLocationNames();

    // Set an interval to update location names every 5 seconds (you can adjust the interval as needed)
    setInterval(updateLocationNames, 30000); // Update every 30 seconds

        // Inisialisasi peta dengan kontrol fullscreen di bagian kanan atas
        var userMap = L.map('userMap', {
        fullscreenControl: {
            position: 'bottomright' // Atur posisi fullscreen control ke top right
        }
    }).setView([-7.604, 110.456], 8); // Set initial view to a default location


    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(userMap);

    // Function to create a marker and bind a popup
    // function createMarker(latitude, longitude, locationInfo, username) {
    //     var marker = L.marker([latitude, longitude]).addTo(userMap);
    //     marker.bindPopup(`<b>${username}</b><br>${locationInfo}`);
    // }


    function createMarker(latitude, longitude, locationInfo, username) {
        var marker = L.marker([latitude, longitude]).addTo(userMap);

        // Tambahkan label ke marker (tooltip) dan bindPopup
        var tooltip = L.tooltip({
            permanent: false,
            className: 'custom-tooltip'
        }).setContent(`<b>${username}</b><br>${locationInfo}`);
        marker.bindTooltip(tooltip).openTooltip();

        // Tambahkan juga popup yang dapat ditutup
        var popup = L.popup().setContent(`<b>${username}</b><br>${locationInfo}`);
        marker.bindPopup(popup);

        // Tambahkan event click untuk menutup popup
        marker.on('click', function() {
            marker.closePopup();
        });
    }


    // Function to update the map with markers based on user locations
    function updateMapWithMarkers() {
        $(".lokasi-data").each(function() {
            var latitude = $(this).data("latitude");
            var longitude = $(this).data("longitude");
            var locationInfo = $(this).text();
            var username = $(this).closest("tr").find("td:eq(0)").text(); // Get username from the same row

            // Create a marker with username and location info in the popup
            createMarker(latitude, longitude, locationInfo, username);
        });
    }

    // Initial call to update the map with markers
    updateMapWithMarkers();

    // Set an interval to update the map every 5 seconds (you can adjust the interval as needed)
    setInterval(updateMapWithMarkers, 5000); // Update every 5 seconds
</script>
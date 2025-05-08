<?php
$cek = $user->row(); //  mengambil nilai data dari tabel tbl_user 
$level = $cek->level; //  nilai level dari variabel $level

$masuk_count = 0;
foreach ($absensi as $absen) {
    if ($absen['keterangan'] == 'Masuk') {
        $masuk_count++;
    }
}
$pulang_count = 0;
foreach ($absensi as $absen) {
    if ($absen['keterangan'] == 'Pulang') {
        $pulang_count++;
    }
}
$izin_count = 0;
foreach ($absensi as $absen) {
    if ($absen['keterangan'] == 'Izin') {
        $izin_count++;
    }
}
$sakit_count = 0;
foreach ($absensi as $absen) {
    if ($absen['keterangan'] == 'Sakit') {
        $sakit_count++;
    }
}
$cuti_count = 0;
foreach ($absensi as $absen) {
    if ($absen['keterangan'] == 'Cuti') {
        $cuti_count++;
    }
}
$perjalanan_tugas_count = 0;
foreach ($absensi as $absen) {
    if ($absen['keterangan'] == 'Perjalanan_tugas') {
        $perjalanan_tugas_count++;
    }
}
$na_count = 0;
foreach ($absensi as $absen) {
    if (!isset($absen['keterangan'])) {
        $na_count++;
    }
}

?>
<style>
    .status-summary {
        display: inline-block;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
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
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <div class="navigation-buttons">
                        <div class="btn-group" style="float: left;">
                            <!-- Tombol Back (di pojok kiri atas) -->
                            <i class="fa fa-television"></i> Info Absen
                        </div>
                        <div class="btn-group" style="float: right;">
                            <!-- Tombol Dropdown (di pojok kanan atas) -->
                            <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bars"></i>
                            </button>
                            <!-- Isi Dropdown -->
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <li><a href="<?php echo site_url('users/absen_info'); ?>"><i class="fa fa-television"></i>Info Absen</a></li>
                                <li><a href="<?php echo site_url('users/edit_absen'); ?>"><i class="fa fa-cog"></i> Kelola Absen</a></li>
                                <li><a href="<?php echo site_url('users/rekap_by_date_range'); ?>"><i class="fa fa-history"></i> Rekap Absen</a></li>
                                <li><a href="<?php echo site_url('users/edit_absen_manual_rekap'); ?>"><i class="fa fa-list-alt"></i> Data Absen Satpam</a></li>
                                <li><a href="<?php echo site_url('users/rekap_by_date_range_manual'); ?>"><i class="fa fa-calendar"></i> Rekap Absen Satpam</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Membersihkan float -->
                    <div class="clearfix"></div>
                    <hr>
                    <form action="<?= base_url('users/absen_info'); ?>" method="get">
                        <div class="col-xs-5">
                            <?php if ($level === 's_admin' || $level === 'k_hrd') : ?>
                                <a href="<?= base_url('users/edit_absen_tambah'); ?>" class="btn btn-danger">+ Tambah</a>
                            <?php endif; ?>
                        </div>
                        <div style="float: right;">
                            <input type="date" class="form-control" id="tgl" name="tgl" value="<?php echo isset($_GET['tgl']) ? htmlspecialchars($_GET['tgl']) : date('Y-m-d'); ?>" onchange="this.form.submit()">
                        </div>
                    </form>
<br><br>
                    <hr>
                    <div class="col-sm-12 text-center">
                        <div class="status-summary">
                            <small>
                                <b style="color: green;">Masuk:</b> [<?= $masuk_count ?>] &nbsp;&nbsp;
                                <b style="color: orange;">Pulang:</b> [<?= $pulang_count ?>] &nbsp;&nbsp;
                                <b style="color: blue;">Izin:</b> [<?= $izin_count ?>] &nbsp;&nbsp;
                                <b style="color: red;">Sakit:</b> [<?= $sakit_count ?>] &nbsp;&nbsp;
                                <b style="color: grey;">Cuti:</b> [<?= $cuti_count ?>] &nbsp;&nbsp;
                                <b style="color: #00bcd4;">Perjalanan Tugas:</b> [<?= $perjalanan_tugas_count ?>] &nbsp;&nbsp;
                                <b>N/A:</b> [<?= $na_count ?>]
                            </small>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <!-- Tabel hasil pencarian -->
                    <table class="table table-striped datatable-basic" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th style="position: sticky; left: 0; z-index: 1; background:#fff;">Nama</th>
                                <th>Kantor</th>
                                <th>Status</th>
                                <th>Jam</th>
                                <th></th>
                                <th>Lokasi Absen</th>
                                <th>Lampiran</th>
                                <th>Foto</th>
                                <th>Keterangan</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($absensi)) : ?>
                                <?php $nomor = 1; ?>
                                <?php foreach ($absensi as $absen) : ?>
                                    <tr>
                                        <td><?= $nomor++; ?></td>
                                        <td style="position: sticky; left: 0; z-index: 1; background:#fff;"><?= strtoupper($absen['nama_lengkap']); ?></td>
                                        <td><?php echo $kodeKantorText = getKodeKantorText($absen['kode_kantor']); ?></td>
                                        <td>
                                            <?php if ($absen['keterangan'] == 'Masuk') : ?>
                                                <button class="btn btn-success" style="padding: 1px 5px;"><small><?= $absen['keterangan']; ?></small></button>
                                            <?php elseif ($absen['keterangan'] == 'Pulang') : ?>
                                                <button class="btn btn-warning" style="padding: 1px 5px;"><small><?= $absen['keterangan']; ?></small></button>
                                            <?php elseif ($absen['keterangan'] == 'Izin') : ?>
                                                <button class="btn btn-primary" style="padding: 1px 5px;"><small><?= $absen['keterangan']; ?></small></button>
                                            <?php elseif ($absen['keterangan'] == 'Sakit') : ?>
                                                <button class="btn btn-danger" style="padding: 1px 5px;"><small><?= $absen['keterangan']; ?></small></button>
                                            <?php elseif ($absen['keterangan'] == 'Cuti') : ?>
                                                <button class="btn btn-secondary" style="padding: 1px 5px;"><small><?= $absen['keterangan']; ?></small></button>
                                            <?php elseif ($absen['keterangan'] == 'Perjalanan_tugas') : ?>
                                                <button class="btn btn-info" style="padding: 1px 5px;"><small><?= $absen['keterangan']; ?></small></button>
                                            <?php else : ?>
                                                <?php if (isset($absen['keterangan'])) : ?>
                                                    <?= $absen['keterangan']; ?>
                                                <?php else : ?>
                                                    N/A
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= $absen['waktu']; ?></td>
                                        <td>
                                            <?php if (!empty($absen['latitude']) && !empty($absen['longitude'])) : ?>
                                                <a href="https://www.google.com/maps?q=<?= $absen['latitude']; ?>,<?= $absen['longitude']; ?>" target="_blank">
                                                    <i class="fa-solid fa-location-crosshairs"></i>
                                                </a>
                                            <?php else : ?>
                                                <span>N/A</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="lokasi-data" data-latitude="<?php echo $absen['latitude']; ?>" data-longitude="<?php echo $absen['longitude']; ?>">
                                        </td>
                                        <td>
                                            <?php
                                            // Ambil nama file foto_absen dari data absen
                                            $lampiran = $absen['lampiran'];

                                            // Buat URL lengkap untuk thumbnail
                                            $thumbnailURL = './foto/foto_absen/' . $lampiran; // Perbaikan: tambahkan tanda '/' setelah 'foto_absen'

                                            // Jika file foto_absen tidak kosong, tampilkan thumbnail
                                            if (!empty($lampiran) && file_exists($thumbnailURL)) {
                                            ?>
                                                <a href="javascript:void(0);" onclick="openPopup('<?php echo $thumbnailURL; ?>');">
                                                    <img src="<?php echo $thumbnailURL; ?>" alt="Thumbnail" width="30">
                                                </a>
                                            <?php
                                            } else {
                                                echo ""; // Pesan jika foto tidak tersedia
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            // Ambil nama file foto_absen dari data absen
                                            $foto_absen = $absen['foto_absen'];

                                            // Buat URL lengkap untuk thumbnail
                                            $thumbnailURL = './foto/foto_absen/absensi/' . $foto_absen; // Perbaikan: tambahkan tanda '/' setelah 'foto_absen'

                                            // Jika file foto_absen tidak kosong, tampilkan thumbnail
                                            if (!empty($foto_absen) && file_exists($thumbnailURL)) {
                                            ?>
                                                <a href="javascript:void(0);" onclick="openPopup('<?php echo $thumbnailURL; ?>');">
                                                    <img src="<?php echo $thumbnailURL; ?>" alt="Thumbnail" width="30">
                                                </a>
                                            <?php
                                            } else {
                                                echo ""; // Pesan jika foto tidak tersedia
                                            }
                                            ?>
                                        </td>
                                        <td><?= $absen['keterangan_absen']; ?></td>
                                        <td>
                                            <?php
                                            // Mendapatkan id_user
                                            $id_user = $absen['id_user'];

                                            // Query untuk mendapatkan nomor telepon berdasarkan id_user
                                            $this->db->select('telp');
                                            $this->db->from('tbl_user');
                                            $this->db->where('id_user', $id_user);
                                            $query = $this->db->get();
                                            $result = $query->row();

                                            // Jika nomor telepon ditemukan, buat link WhatsApp
                                            if ($result) {
                                                $phone_number = $result->telp;

                                                // Mengubah nomor telepon jika perlu
                                                // Jika nomor telepon tidak dimulai dengan +62, tambahkan kode negara Indonesia
                                                if (substr($phone_number, 0, 3) !== '+62') {
                                                    // Menghapus karakter non-digit dari nomor telepon
                                                    $phone_number = preg_replace('/\D/', '', $phone_number);

                                                    // Jika nomor telepon dimulai dengan 0, hilangkan 0 dan tambahkan kode negara Indonesia (+62)
                                                    if (substr($phone_number, 0, 1) === '0') {
                                                        $phone_number = '+62' . ltrim($phone_number, '0');
                                                    } else {
                                                        // Jika nomor telepon tidak memiliki kode negara (tidak dimulai dengan +), tambahkan kode negara Indonesia (+62)
                                                        $phone_number = '+62' . $phone_number;
                                                    }
                                                }

                                                // Membuat link ke WhatsApp
                                                $whatsapp_link = "https://api.whatsapp.com/send?phone=" . urlencode($phone_number);
                                            ?>
                                                <!-- Tombol "Chat WA" -->
                                                <a href="<?php echo $whatsapp_link; ?>" class="btn btn-success" style="padding: 1px 5px;"><i class="fa fa-comment"></i></a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="8" style="text-align: center;">Tidak ada data absen yang ditemukan</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                </fieldset>
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

    // Lokasi
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
            var stateDistrict = properties.state_district || '';
            var countyName = properties.county || '';

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
    // END lokasi
</script>
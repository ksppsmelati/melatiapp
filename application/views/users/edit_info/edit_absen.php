<?php
$cek = $user->row(); //  mengambil nilai data dari tabel tbl_user 
$level = $cek->level; //  nilai level dari variabel $level
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
</style>
<div class="container">
    <div class="content">
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <div class="navigation-buttons">
                        <div class="btn-group" style="float: left;">
                            <!-- Tombol Back (di pojok kiri atas) -->
                            <i class="fa fa-cog"></i> Kelola Data Absen
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
                    <form action="<?= base_url('users/edit_absen'); ?>" method="get">
                        <div class="col-xs-5">
                            <?php if ($level === 's_admin' || $level === 'k_hrd') : ?>
                                <a href="<?= base_url('users/edit_absen_tambah'); ?>" class="btn btn-danger">+ Tambah</a>
                            <?php endif; ?>
                        </div>
                        <div  style="float: right;">
                            <input type="date" class="form-control" id="tgl" name="tgl" value="<?php echo isset($_GET['tgl']) ? htmlspecialchars($_GET['tgl']) : date('Y-m-d'); ?>" onchange="this.form.submit()">
                        </div>
                    </form>
                </div>
                <div class="table-responsive">
                    <!-- Tabel hasil pencarian -->
                    <table class="table datatable-basic" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Waktu</th>
                                <th>Status</th>
                                <th>Nama</th>
                                <th></th>
                                <th>Lokasi Absen</th>
                                <th>Lampiran</th>
                                <th>Foto</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($absensi)) : ?>
                                <?php $nomor = 1; ?>
                                <?php foreach ($absensi as $absen) : ?>
                                    <tr>
                                        <td><?= $nomor++; ?></td>
                                        <td><?= date('d-m-Y', strtotime($absen['tgl'])); ?></td>
                                        <td><?= $absen['waktu']; ?></td>
                                        <td>
                                            <?php if ($absen['keterangan'] == 'Masuk') : ?>
                                                <button class="btn btn-primary" style="padding: 1px 5px;"><small><?= $absen['keterangan']; ?></small></button>
                                            <?php elseif ($absen['keterangan'] == 'Pulang') : ?>
                                                <button class="btn btn-danger" style="padding: 1px 5px;"><small><?= $absen['keterangan']; ?></small></button>
                                            <?php else : ?>
                                                <?= $absen['keterangan']; ?>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= $absen['nama_lengkap']; ?></td>
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
                                            $thumbnailURL = './foto/foto_absen/' . $lampiran; 

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
                                            <?php if ($level === 's_admin' || $level === 'k_hrd') : ?>
                                                <a href="<?= base_url('users/edit_absen_id/') . $absen['id_absen']; ?>" class="btn btn-primary btn-edit"><i class="icon-pencil"></i></a>
                                                <a href="#" onclick="confirmDelete(event, '<?= base_url('users/hapus_absen/') . $absen['id_absen']; ?>')" class="btn btn-danger btn-delete"><i class="icon-trash"></i></a>
                                            <?php endif; ?>
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
    function confirmDelete(event, url) {
        event.preventDefault(); // Prevent the default anchor click behavior

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Make an AJAX request to delete the record
                var xhr = new XMLHttpRequest();
                xhr.open('GET', url, true);
                xhr.onload = function() {
                    if (xhr.status >= 200 && xhr.status < 400) {
                        // Show success message and reload the page
                        Swal.fire(
                            'Terhapus!',
                            'Data berhasil terhapus.',
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    } else {
                        // Handle error
                        Swal.fire(
                            'Error!',
                            'Data tidak berhasil terhapus. Silahkan coba lagi.',
                            'error'
                        );
                    }
                };
                xhr.onerror = function() {
                    // Handle error
                    Swal.fire(
                        'Error!',
                        'Data tidak berhasil terhapus. Silahkan coba lagi.',
                        'error'
                    );
                };
                xhr.send();
            }
        });
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
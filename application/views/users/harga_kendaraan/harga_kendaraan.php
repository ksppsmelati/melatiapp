<style>
    .content-wrapper {
        width: 100%;
        min-width: 100vw;
        /* Set a minimum width for the content-wrapper */
        box-sizing: border-box;
    }

    .container {
        width: 100%;
        margin: 0;
        padding: 0;
    }

    .card {
        width: 30%;
        margin: 1%;
        display: inline-block;
        vertical-align: top;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
        transition: transform 0.3s ease-in-out;
    }

    .card:hover {
        transform: scale(1.05);
    }

    .card img {
        width: 100%;
        height: auto;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
    }

    .card-content {
        padding: 10px;
    }

    #hargaKendaraanContainer {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        min-width: 100%;
    }

    #searchInput {
        margin-bottom: 10px;
        width: 100%;
        /* Make the search input full-width */
        border-radius: 10px;
    }

    .panel {
        min-width: 100%;
        /* Adjust the value based on your design */
    }

    .link-details {
        color: inherit;
        /* Set the link color to inherit from its parent */
        text-decoration: none;
        /* Remove underline */
    }
</style>

<!-- Main content -->
<div class="content-wrapper">
    <!-- Content area -->
    <div class="content">
        <?php echo $this->session->flashdata('msg'); ?>
        <div class="container">
            <div class="row ">
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h5 class="panel-title"><i class="fa fa-tags"></i> Harga Kendaraan</h5>

                        <?php
                        $allowedLevels = ['kadiv_manrisk', 's_admin'];

                        if (in_array($user->row()->level, $allowedLevels)) {
                            echo '<br>';
                            echo '<a href="users/harga_kendaraan/t" class="btn btn-danger">+ Tambah</a>';
                        }
                        ?>
                    </div>
                    <div class="input-group mb-3" style="display: flex; justify-content: center; padding: 0 20px;">
                        <input type="text" id="searchInput" class="form-control" placeholder="Cari..">
                    </div>

                    <div id="hargaKendaraanContainer" class="d-flex flex-wrap justify-content-around align-items-start">
                        <?php
                        $allowedLevels = ['kadiv_manrisk', 's_admin'];

                        if ($harga_kendaraan && $harga_kendaraan->num_rows() > 0) {
                            // Group harga_kendaraan by model
                            $groupedVehicles = [];
                            foreach ($harga_kendaraan->result() as $baris) {
                                $model = $baris->model;
                                if (!isset($groupedVehicles[$model])) {
                                    $groupedVehicles[$model] = [];
                                }
                                $groupedVehicles[$model][] = $baris;
                            }

                            // Display one card for each model
                            foreach ($groupedVehicles as $model => $modelGroup) {
                                // Find the vehicle with the latest year in the group
                                $latestVehicle = null;
                                foreach ($modelGroup as $vehicle) {
                                    if ($latestVehicle === null || $vehicle->tahun > $latestVehicle->tahun) {
                                        $latestVehicle = $vehicle;
                                    }
                                }

                                // Find a vehicle with a valid photo if the latest one doesn't have one
                                $photoVehicle = $latestVehicle;
                                if (empty($latestVehicle->foto)) {
                                    foreach ($modelGroup as $vehicle) {
                                        if (!empty($vehicle->foto)) {
                                            $photoVehicle = $vehicle;
                                            break;
                                        }
                                    }
                                }
                        ?>
                                <div class="card mb-3" data-model="<?php echo strtolower($latestVehicle->model); ?>">
                                    <!-- Display data for the model group -->
                                    <a href="users/harga_kendaraan/lihat/<?php echo $latestVehicle->id; ?>" class="link-details">
                                        <!-- Make the entire card clickable -->
                                        <img src="<?php echo $photoVehicle->foto ? base_url('foto/kendaraan/' . $photoVehicle->foto) : base_url('foto/kendaraan/no_image.jpg'); ?>" alt="Foto <?php echo $latestVehicle->model; ?>" class="card-img-top" style="height: 100px; object-fit: cover;" decoding="async" loading="lazy">
                                    </a>
                                    <div class="card-content flex-grow-1">
                                        <!-- Display data for the model group -->
                                        <a href="users/harga_kendaraan/lihat/<?php echo $latestVehicle->id; ?>" class="link-details">
                                            <small class="card-text" style="font-size: smaller;"><?php echo $latestVehicle->merek; ?></small><br>
                                            <strong class="card-text"><?php echo $latestVehicle->model; ?></strong><br>
                                        </a>
                                    </div>
                                </div>
                            <?php
                            }
                        } else {
                            // Tampilkan pesan jika tidak ada harga kendaraan
                            ?>
                            <p>Tidak ada harga kendaraan yang tersedia.</p>
                        <?php
                        }
                        ?>
                    </div>


                    <script>
                        $(document).ready(function() {
                            var hargaKendaraanContainer = $('#hargaKendaraanContainer');

                            $('#searchInput').on('input', function() {
                                var searchTerm = $(this).val().toLowerCase();

                                hargaKendaraanContainer.find('.card').filter(function() {
                                    var cardData = $(this).data('merek') + ' ' + $(this).data('model') + ' ' + $(this).data('tahun') + ' ' + $(this).data('harga');
                                    $(this).toggle(cardData.toLowerCase().indexOf(searchTerm) > -1);
                                });
                            });

                            lightbox.option({
                                'resizeDuration': 200,
                                'wrapAround': true
                            });
                        });
                    </script>
                </div>
            </div>
            <!-- /dashboard content -->
        </div>
    </div>
</div>
<script async src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/js/lightbox.min.js"></script>
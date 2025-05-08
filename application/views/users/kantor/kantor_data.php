<style type="text/css">
    .container {
        width: 100%;
        margin: 0;
        padding-top: 10px;
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
        <?php echo $this->session->flashdata('msg'); ?>
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <div class="navigation-buttons">
                        <div class="btn-group" style="float: left;">
                            <i class="fa fa-television"></i> DATA KANTOR
                        </div>

                        <div class="btn-group" style="float: right;">
                            <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bars"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <li><a href="<?php echo site_url('users/kantor_data'); ?>"><i class="fa fa-television"></i> Data kantor</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                </div>
                <div class="table-responsive">
                    <table class="table datatable-basic table-striped" width="100%">
                        <thead>
                            <tr>
                                <!-- <th>No</th> -->
                                <th>Kode Kantor</th>
                                <th>Nama Kantor</th>
                                <th>Alamat</th>
                                <th>Telepon</th>
                                <th>Email</th>
                                <th>Map</th>
                                <!-- <th>Latitude</th> -->
                                <!-- <th>Longitude</th> -->
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($kantor_data)) : ?>
                                <?php $no = 1; // Inisialisasi nomor urut 
                                ?>
                                <?php foreach ($kantor_data as $data) : ?>
                                    <tr>
                                        <!-- <td><?php echo $no++; ?></td> -->
                                        <td><?php echo $data->kode_kantor; ?></td>
                                        <td><?php echo $data->nama_kantor; ?></td>
                                        <td><?php echo $data->alamat; ?></td>
                                        <td><?php echo $data->telepon; ?></td>
                                        <td><?php echo $data->email; ?></td>
                                        <td>
                                            <?php if (!empty($data->latitude) && !empty($data->longitude)) : ?>
                                                <a href="https://www.google.com/maps?q=<?= $data->latitude; ?>,<?= $data->longitude; ?>" target="_blank">
                                                    <i class="fa-solid fa-location-crosshairs"></i>
                                                </a>
                                            <?php else : ?>
                                                <span>N/A</span>
                                            <?php endif; ?>
                                        </td>
                                        <!-- <td><?php echo $data->link_map; ?></td> -->
                                        <!-- <td><?php echo $data->latitude; ?></td> -->
                                        <!-- <td><?php echo $data->longitude; ?></td> -->
                                        <td><?php echo $data->status; ?></td>
                                        <td>
                                            <?php
                                            $allowedLevels = ['s_admin'];
                                            if (in_array($user->row()->level, $allowedLevels)) : ?>
                                                <a href="<?php echo site_url('users/kantor_edit/' . $data->id); ?>" class="btn btn-success btn-xs"><i class="icon-pencil7"></i></a>
                                            <?php endif; ?>
                                            <?php
                                            $allowedLevels = ['s_admin'];
                                            if (in_array($user->row()->level, $allowedLevels)) :
                                            ?>
                                                <a href="#" class="btn btn-danger btn-xs hapus-kantor" data-id="<?php echo $data->id; ?>"><i class="icon-trash"></i></a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>

                            <?php endif; ?>
                        </tbody>
                    </table>
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

    $(document).ready(function() {
        // Handle SweetAlert for delete action
        $('.hapus-kantor').on('click', function(e) {
            e.preventDefault();
            var kantorId = $(this).data('id');

            Swal.fire({
                title: 'Konfirmasi Hapus ?',
                text: 'Anda yakin ingin menghapus data!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to the delete URL or perform AJAX delete
                    window.location.href = '<?php echo site_url('users/kantor_hapus/'); ?>' + kantorId;
                }
            });
        });
    });
</script>
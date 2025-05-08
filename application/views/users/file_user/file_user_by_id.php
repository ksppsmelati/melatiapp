<?php
$cek = $user->row(); // Mengambil nilai data dari tabel tbl_user 
$level = $cek->level; // Nilai level dari variabel $level

$file_extensions = array(
    'image/jpeg' => 'JPEG',
    'application/pdf' => 'PDF',
    'application/zip' => 'ZIP',
    'text/plain' => 'TXT',
    // Add more MIME types and their extensions as needed
);

// Sample file data
$file = array('file_type' => 'application/pdf'); // This would normally come from your database

// Determine the extension based on the file type
$extension = isset($file_extensions[$file['file_type']]) ? $file_extensions[$file['file_type']] : 'Unknown'; // Default extension
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
        background: none;
        box-shadow: none;
    }

    /* Custom styles for the close button */
    .custom-popup-close-button {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 40px;
        color: #fff;
        cursor: pointer;
        background: transparent;
        border: none;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<div class="container">
    <!-- Content area -->
    <div class="content">
        <?php echo $this->session->flashdata('msg'); ?>
        <!-- Data File Center content -->
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="navigation-buttons">
                        <div class="btn-group" style="float: left;">
                            <!-- Tombol Back (di pojok kiri atas) -->
                            <i class="fa fa-folder"></i> Data Kategori : <b><?php echo $category; ?></b>
                        </div>
                        <div class="btn-group" style="float: right;">
                            <!-- Tombol Dropdown (di pojok kanan atas) -->
                            <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bars"></i>
                            </button>
                            <!-- Isi Dropdown -->
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <!-- <li><a href="<?php echo site_url('users/file_user_upload'); ?>"><i class="fa fa-plus"></i> Tambah File</a></li> -->
                                <li><a href="<?php echo site_url('users/file_user_by_id_user'); ?>"><i class="fa fa-file"></i> My File</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Membersihkan float -->
                    <div class="clearfix"></div>
                    <a href="javascript:void(0);" class="btn btn-light" style="background-color: #F2F3F5;" onclick="window.history.back();">
                        <i class="fa fa-arrow-left"></i>
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table datatable-basic" width="100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>File</th>
                                <th>Kategori</th>
                                <th>Tahun</th>
                                <th>Size</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <!-- Looping file dalam kategori -->
                            <?php foreach ($files as $file) : ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $file['nama']; ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; max-width: 100%;">
                                        <a href="<?php echo site_url('users/file_user_lihat/' . $file['id']); ?>" style="display: inline-block; max-width: 100%; overflow-wrap: break-word;">
                                            <?php echo htmlspecialchars($file['file_name']); ?>
                                        </a>
                                    </td>
                                    <td><?php echo $file['category']; ?></td>
                                    <td><?php echo $file['tahun']; ?></td>
                                    <td><?php echo $file['file_size']; ?> KB</td>
                                    <td><?php echo $file['description']; ?></td>
                                    <td>
                                        <a href="<?php echo site_url('users/file_user_lihat/' . $file['id']); ?>" class="btn btn-info btn-sm">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>
                                        <!-- <a href="<?php echo site_url('users/file_user_download/' . $file['id']); ?>" class="btn btn-success btn-sm">
                                            <i class="fa fa-download" aria-hidden="true"></i>
                                        </a> -->
                                        <?php
                                        // Define the allowed levels
                                        $allowedLevels = ['mng_bisnis', 'kadiv_manrisk', 'kadiv_opr', 's_admin', 'k_arsip'];

                                        // Check if the user's level is in the allowed levels
                                        if (in_array($user->row()->level, $allowedLevels)) :
                                        ?>
                                            <a href="<?php echo site_url('users/file_user_edit/' . $file['id']); ?>" class="btn btn-primary btn-sm">
                                                <i class="fa fa-pencil" aria-hidden="true"></i>
                                            </a>
                                            <a href="<?php echo site_url('users/file_user_hapus/' . $file['id']); ?>" class="btn btn-danger btn-sm delete-btn" data-id="<?php echo $file['id']; ?>">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </a>
                                        <?php endif; ?>

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Data File Center content -->
    </div>
    <!-- /content area -->
</div>
<!-- /main content -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.delete-btn');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();

                const deleteUrl = button.getAttribute('href');
                const dataId = button.getAttribute('data-id');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = deleteUrl;
                    }
                });
            });
        });
    });
</script>
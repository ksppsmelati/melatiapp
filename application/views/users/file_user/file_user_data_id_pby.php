<?php
$cek = $user->row(); // Mengambil nilai data dari tabel tbl_user 
$level = $cek->level; // Nilai level dari variabel $level
$allowedLevels = ['mng_bisnis', 'kadiv_manrisk', 'kadiv_opr', 's_admin', 'k_hrd', 'k_arsip'];
?>

<style>
    .table-responsive {
        margin-bottom: 20px;
    }

    th {
        font-weight: bold;
    }
</style>

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
                            <i class="fa fa-folder"></i> Data File SLIK
                        </div>

                        <div class="btn-group" style="float: right;">
                            <!-- Tombol Dropdown (di pojok kanan atas) -->
                            <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bars"></i>
                            </button>
                            <!-- Isi Dropdown -->
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <li><a href="<?php echo site_url('users/file_user_data'); ?>"><i class="fa fa-file"></i> Data File Center</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Membersihkan float -->
                    <div class="clearfix"></div>
                    <hr>

                    <div id="scrollable-table" class="table-responsive" style="overflow-x: auto;">
                        <table class="table datatable-basic" width="100%">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>File</th>
                                    <th>Type</th>
                                    <th>Kategori</th>
                                    <th>Tahun</th>
                                    <th>Size</th>
                                    <th>Inpuser</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($file_user as $file) : ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><strong><?php echo 'PBY' . $file['id_pby']; ?></strong></td>
                                        <td><strong><?php echo $file['nama']; ?></strong></td>
                                        <td>
                                            <a href="<?php echo site_url('users/file_user_lihat_id_pby/' . $file['id_pby']); ?>">
                                                <?php
                                                $file_name_without_extension = pathinfo($file['file_name'], PATHINFO_FILENAME);
                                                // Mengganti semua underscore dengan spasi
                                                $file_name_without_underscore = str_replace('_', ' ', $file_name_without_extension);
                                                echo htmlspecialchars($file_name_without_underscore);
                                                ?>
                                            </a>
                                        </td>
                                        <td>
                                            <?php
                                            switch ($file['file_type']) {
                                                case 'application/pdf':
                                                    echo '<i class="fa fa-file-pdf"></i> PDF';
                                                    break;
                                                case 'application/vnd.ms-powerpoint':
                                                case 'application/vnd.openxmlformats-officedocument.presentationml.presentation':
                                                    echo '<i class="fa fa-file-powerpoint"></i> PowerPoint';
                                                    break;
                                                case 'application/msword':
                                                case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
                                                    echo '<i class="fa fa-file-word"></i> Word';
                                                    break;
                                                case 'application/vnd.ms-excel':
                                                case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
                                                    echo '<i class="fa fa-file-excel"></i> Excel';
                                                    break;
                                                case 'image/jpeg':
                                                case 'image/jpg':
                                                    echo '<i class="fa fa-file-image"></i> JPG';
                                                    break;
                                                case 'image/png':
                                                    echo '<i class="fa fa-file-image"></i> PNG';
                                                    break;
                                                case 'application/zip':
                                                case 'application/x-rar-compressed':
                                                    echo '<i class="fa fa-file-archive"></i> Archive';
                                                    break;
                                                default:
                                                    echo '<i class="fa fa-file"></i> Other';
                                                    break;
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $file['category']; ?></td>
                                        <td><?php echo $file['tahun']; ?></td>
                                        <td><?php echo $file['file_size']; ?> KB</td>
                                        <td><?php echo strtoupper($file['nama_lengkap']); ?></td>
                                        <td>
                                            <a href="<?php echo site_url('users/file_user_lihat_id_pby/' . $file['id_pby']); ?>" class="btn btn-info btn-sm">
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                            </a>

                                            <?php if (in_array($user->row()->level, $allowedLevels)) : ?>
                                                <a href="<?php echo site_url('users/file_user_edit_id_pby/' . $file['id_pby']); ?>" class="btn btn-primary btn-sm">
                                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                                </a>
                                                <a href="<?php echo site_url('users/file_user_lihat_id_pby/' . $file['id_pby']); ?>" class="btn btn-primary btn-sm" style="background-color: #6f42c1; color: white;">
                                                    <i class="fa-solid fa-book-open" aria-hidden="true"></i>
                                                </a>
                                                <a href="javascript:void(0);" class="btn btn-danger btn-sm delete-btn" data-id="<?php echo $file['id_pby']; ?>">
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
        </div>
        <!-- Data File Center content -->
    </div>
    <!-- /content area -->
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    // Tangkap klik pada tombol hapus
    document.querySelectorAll('.delete-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            var fileId = this.getAttribute('data-id'); // Ambil ID file

            // Tampilkan konfirmasi SweetAlert
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "File yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika dikonfirmasi, redirect ke URL hapus
                    window.location.href = "<?php echo site_url('users/file_user_hapus/'); ?>" + fileId;
                }
            });
        });
    });
</script>
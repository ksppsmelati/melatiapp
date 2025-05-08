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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<div class="container">
    <!-- Content area -->
    <div class="content">
        <?php echo $this->session->flashdata('msg'); ?>
        <!-- Data Laporan Kerja content -->
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="navigation-buttons">
                        <div class="btn-group" style="float: left;">
                            <!-- Tombol Back (di pojok kiri atas) -->
                            <i class="fa fa-briefcase"></i> Data Laporan Kerja
                        </div>

                        <div class="btn-group" style="float: right;">
                            <!-- Tombol Dropdown (di pojok kanan atas) -->
                            <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bars"></i>
                            </button>
                            <!-- Isi Dropdown -->
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <li><a href="<?php echo site_url('users/laporan_kerja'); ?>"><i class="fa fa-plus"></i> Tambah Laporan Kerja</a></li>
                                <li><a href="<?php echo site_url('users/data_laporan_kerja'); ?>"><i class="fa fa-file"></i> Data Laporan Kerja</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Membersihkan float -->
                    <div class="clearfix"></div>
                    <a href="users/laporan_kerja" class="btn btn-danger">+ Tambah</a>
                    <hr>
                    <form method="post" action="<?php echo site_url('users/data_laporan_kerja'); ?>">
                        <div class="col-xs-5">
                            <select name="bulan" id="bulan" class="form-control">
                                <?php
                                for ($i = 1; $i <= 12; $i++) {
                                    $month = date("F", mktime(0, 0, 0, $i, 1));
                                    $selected = ($i == $selectedMonth) ? 'selected' : '';
                                    echo "<option value='$i' $selected>$month</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-xs-5">
                            <select name="tahun" id="tahun" class="form-control">
                                <?php
                                for ($i = date("Y"); $i >= 2020; $i--) {
                                    $selected = ($i == $selectedYear) ? 'selected' : '';
                                    echo "<option value='$i' $selected>$i</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                    </form>

                </div>
                <?php if (!empty($laporan_kerja)) : ?>
                    <div class="table-responsive">
                        <table class="table datatable-basic" width="100%">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Foto</th>
                                    <th>Pekerjaan</th>
                                    <th> </th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($laporan_kerja as $laporan) : ?>
                                    <tr>
                                        <td>
                                            <a href="<?php echo site_url('users/laporan_kerja_lihat/' . $laporan['id']); ?>">
                                                <b><?php echo date('d-m-Y', strtotime($laporan['tanggal'])); ?></b>
                                            </a>
                                        </td>
                                        <td>

                                        <?php
                                        $foto_pekerjaan = $laporan['foto_pekerjaan'];
                                        $thumbnailURL = './foto/foto_pekerjaan/' . $foto_pekerjaan;
                                        if (!empty($foto_pekerjaan) && file_exists($thumbnailURL)) {
                                        ?>
                                            <a href="javascript:void(0);" onclick="openPopup('<?php echo $thumbnailURL; ?>');">
                                                <img src="<?php echo $thumbnailURL; ?>" alt="Thumbnail" width="30">
                                            </a>
                                        <?php
                                        } else {
                                            echo "-"; 
                                        }
                                        ?>
                                    </td>
                                        <td>
                                            <a href="<?php echo site_url('users/laporan_kerja_lihat/' . $laporan['id']); ?>">
                                                <?php echo htmlspecialchars_decode(substr(strip_tags($laporan['pekerjaan']), 0, 25)); ?>...
                                            </a>
                                        </td>
                                        <td>
                                            <?php if ($laporan['approval'] == 1) : ?>
                                                <i class="fa fa-check-circle text-success"></i> <!-- Ikon centang jika approval = 1 -->
                                            <?php else : ?>
                                                <i class="fa fa-clock"></i> <!-- Ikon silang jika approval = 0 -->
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo site_url('users/laporan_kerja_edit/' . $laporan['id']); ?>" class="btn btn-primary btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                            <a href="<?php echo site_url('users/laporan_kerja_hapus/' . $laporan['id']); ?>" class="btn btn-danger btn-sm delete-btn" data-id="<?php echo $laporan['id']; ?>">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else : ?>
                    <div style="text-align: center;">
                        <p>Tidak ada data laporan kerja yang ditemukan.</p>
                    </div>

                <?php endif; ?>
            </div>
        </div>
        <!-- Data Laporan Kerja content -->
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
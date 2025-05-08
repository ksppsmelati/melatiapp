<?php
$cek = $user->row();
$kode_atasan = $cek->kode_atasan;
?>
<style>
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

    .container {
        width: 100%;
        margin: 0;
        padding: 0;
    }
</style>
<div class="container">
    <!-- Content area -->
    <div class="content">
        <?php echo $this->session->flashdata('msg'); ?>
        <!-- Data Laporan Kerja content -->
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="navigation-buttons">
                        <!-- <div class="btn-group" style="float: left;">
                            <a href="javascript:history.go(-1);" class="btn btn-light btn-sm">
                                <i class="fa fa-arrow-left"></i> Kembali
                            </a>
                        </div> -->

                        <div class="btn-group" style="float: right;">
                            <!-- Tombol Dropdown (di pojok kanan atas) -->
                            <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bars"></i>
                            </button>
                            <!-- Isi Dropdown -->
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <li><a href="<?php echo site_url('users/laporan_kerja'); ?>"><i class="fa fa-plus"></i> Tambah Laporan Kerja</a></li>
                                <li><a href="<?php echo site_url('users/data_laporan_kerja'); ?>"><i class="fa fa-file"></i> Data Laporan Kerja</a></li>
                                <li><a href="<?= base_url('users/laporan_kerja_atasan_export_excel?bulan=' . $selectedMonth . '&tahun=' . $selectedYear) ?>"><i class="fa-solid fa-file-excel"></i> Export to Excel</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Membersihkan float -->
                    <div class="clearfix"></div>
                    <legend class="text-bold"><i class="fa fa-briefcase"></i> Rekap Laporan Kerja | <?php echo ucwords($kode_atasan); ?></legend>
                    <form method="post" action="<?php echo site_url('users/laporan_kerja_by_atasan'); ?>">
                        <div class="col-xs-5">
                            <select name="bulan" id="bulan" class="form-control">
                                <?php
                                // Generate options for months
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
                                // Generate options for years (adjust the range as needed)
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
                <!-- Add this form above your table -->


                <?php if (!empty($laporan_kerja)) : ?>
                    <div class="table-responsive">
                        <table class="table datatable-basic" width="100%">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                    <th>Pekerjaan</th>
                                    <th>Foto</th>
                                    <th> </th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($laporan_kerja as $laporan) : ?>
                                    <tr>
                                        <td><a href="<?php echo site_url('users/laporan_kerja_lihat/' . $laporan['id']); ?>"><?php echo $laporan['nama_lengkap']; ?></a></td>
                                        <td><a href="<?php echo site_url('users/laporan_kerja_lihat/' . $laporan['id']); ?>"><?php echo date('d-m-Y', strtotime($laporan['tanggal'])); ?></a></td>
                                        <td><a href="<?php echo site_url('users/laporan_kerja_lihat/' . $laporan['id']); ?>"><?php echo $laporan['jam']; ?></a></td>
                                        <td><a href="<?php echo site_url('users/laporan_kerja_lihat/' . $laporan['id']); ?>" title="<?php echo htmlspecialchars(strip_tags($laporan['pekerjaan'])); ?>"><?php echo htmlspecialchars(substr(strip_tags($laporan['pekerjaan']), 0, 50)); ?>...</a></td>
                                        <td>
                                            <?php
                                            $foto_pekerjaan = $laporan['foto_pekerjaan']; // Fix here: Use object property access
                                            $thumbnailURL = './foto/foto_pekerjaan/' . $foto_pekerjaan;
                                            if (!empty($foto_pekerjaan) && file_exists($thumbnailURL)) {
                                            ?>
                                                <a href="javascript:void(0);" onclick="openPopup('<?php echo $thumbnailURL; ?>');">
                                                    <img src="<?php echo $thumbnailURL; ?>" class="gambar" alt="Thumbnail" loading="lazy">
                                                </a>
                                            <?php
                                            } else {
                                                echo "-";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php if ($laporan['approval'] == 1) : ?>
                                                <a href="<?php echo site_url('users/laporan_kerja_lihat/' . $laporan['id']); ?>">
                                                    <i class="fa fa-check-circle text-success"></i>
                                                </a>
                                            <?php else : ?>
                                                <i class="fa fa-clock"></i>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo site_url('users/data_laporan_kerja_approval_atasan/' . $laporan['id']); ?>" class="btn btn-primary btn-sm"><i class="fa fa-check"></i></a>

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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    function openPopup(imageURL) {
        Swal.fire({
            html: `<img src="${imageURL}" class="popup-image" style="width: 100%;" />`,
            showCloseButton: true,
            showConfirmButton: false,
            customClass: {
                content: 'custom-popup-content',
                closeButton: 'custom-popup-close-button'
            }
        });
    }
</script>
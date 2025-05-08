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
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                <div class="navigation-buttons">
                        <div class="btn-group" style="float: left;">
                            <!-- Tombol Back (di pojok kiri atas) -->
                            <i class="fa fa-list-alt"></i> Data Absen Satpam
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
                    <div class="clearfix"></div>
                    <hr>
                    <form action="<?= base_url('users/edit_absen_manual_rekap'); ?>" method="get">
                        <div class="col-xs-5">
                            <input type="date" class="form-control" id="tanggal_awal" name="tanggal_awal" value="<?php echo isset($_GET['tanggal_awal']) ? htmlspecialchars($_GET['tanggal_awal']) : date('Y-m-d'); ?>">
                        </div>
                        <div class="col-xs-5">
                            <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" value="<?php echo isset($_GET['tanggal_akhir']) ? htmlspecialchars($_GET['tanggal_akhir']) : date('Y-m-d'); ?>">
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                    </form>
                </div>
                <div class="table-responsive">
                    <table class="table datatable-basic" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Tanggal</th>
                                <th>Waktu</th>
                                <th>Status</th>
                                <th>Foto</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($absensi)) : ?>
                                <?php $nomor = 1; ?>
                                <?php foreach ($absensi as $absen) : ?>
                                    <tr>
                                        <td><?= $nomor++; ?></td>
                                        <td><?= $absen->nama_lengkap; ?></td>
                                        <td>
                                            <?php
                                            $tgl_list = explode(',', $absen->tgl_list);
                                            foreach ($tgl_list as $tgl) {
                                                echo date('d-m-Y', strtotime($tgl)) . '<br>';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $waktu_list = explode(',', $absen->waktu_list);
                                            foreach ($waktu_list as $waktu) {
                                                echo $waktu . '<br>';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $keterangan_list = explode(',', $absen->keterangan_list);
                                            foreach ($keterangan_list as $keterangan) {
                                                if ($keterangan == 'Masuk') {
                                                    echo '<button class="btn btn-primary" style="padding: 1px 5px;"><small>' . $keterangan . '</small></button><br>';
                                                } elseif ($keterangan == 'Pulang') {
                                                    echo '<button class="btn btn-danger" style="padding: 1px 5px;"><small>' . $keterangan . '</small></button><br>';
                                                } else {
                                                    echo $keterangan . '<br>';
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $foto_list = explode(',', $absen->foto_list);
                                            foreach ($foto_list as $foto_absen) {
                                                $thumbnailURL = './foto/foto_absen/manual/' . $foto_absen;
                                                if (!empty($foto_absen) && file_exists($thumbnailURL)) {
                                                    echo '<a href="javascript:void(0);" onclick="openPopup(\'' . $thumbnailURL . '\');"><img src="' . $thumbnailURL . '" class="gambar" alt="Thumbnail"></a>';
                                                } else {
                                                    echo "-<br>";
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $keterangan_absen_list = explode(',', $absen->keterangan_absen_list);
                                            foreach ($keterangan_absen_list as $keterangan_absen) {
                                                echo '- ' . $keterangan_absen . '<br>';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="7" style="text-align: center;">Tidak ada data absen yang ditemukan</td>
                                </tr>
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
    function confirmDelete(event, url) {
        event.preventDefault();

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
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
</script>
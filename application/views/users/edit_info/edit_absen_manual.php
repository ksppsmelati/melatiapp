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
                            <i class="fa fa-calendar"></i> Data Absen Satpam
                        </div>
                        <div class="navigation-buttons text-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bars"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <li><a href="<?= base_url('users/edit_absen_tambah_manual'); ?>"><i class="fa fa-check-square"></i> Tambah Absen</a></li>
                                <li><a href="<?= base_url('users/edit_absen_manual'); ?>"><i class="fa fa-calendar"></i> Data Absen Satpam</a></li>
                            </ul>
                        </div>
                    </div>
                    </div>
                    <!-- Membersihkan float -->
                    <div class="clearfix"></div>
                    <hr>
                    <form action="<?= base_url('users/edit_absen_manual'); ?>" method="get">
                        <div class="col-xs-5">
                            <input type="number" class="form-control" id="tahun" name="tahun" placeholder="Tahun" value="<?php echo isset($_GET['tahun']) ? htmlspecialchars($_GET['tahun']) : date('Y'); ?>" min="2000" max="2100">
                        </div>
                        <div class="col-xs-5">
                            <select class="form-control" id="bulan" name="bulan">
                                <?php 
                                for ($i = 1; $i <= 12; $i++) {
                                    $selected = ($i == date('m')) ? 'selected' : '';
                                    echo "<option value='".str_pad($i, 2, '0', STR_PAD_LEFT)."' $selected>".date('F', mktime(0, 0, 0, $i, 10))."</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
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
                                            <?php
                                            // Ambil nama file foto_absen dari data absen
                                            $foto_absen = $absen['foto_absen'];

                                            // Buat URL lengkap untuk thumbnail
                                            $thumbnailURL = './foto/foto_absen/manual/' . $foto_absen; // Perbaikan: tambahkan tanda '/' setelah 'foto_absen'

                                            // Jika file foto_absen tidak kosong, tampilkan thumbnail
                                            if (!empty($foto_absen) && file_exists($thumbnailURL)) {
                                            ?>
                                                <a href="javascript:void(0);" onclick="openPopup('<?php echo $thumbnailURL; ?>');">
                                                    <img src="<?php echo $thumbnailURL; ?>" alt="Thumbnail" width="30">
                                                </a>
                                            <?php
                                            } else {
                                                echo "-"; // Pesan jika foto tidak tersedia
                                            }
                                            ?>
                                        </td>
                                        <td><?= $absen['keterangan_absen']; ?></td>
                                        <td>
                                                <a href="#" onclick="confirmDelete(event, '<?= base_url('users/hapus_absen_manual/') . $absen['id_absen']; ?>')" class="btn btn-danger btn-delete"><i class="icon-trash"></i></a>
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
        event.preventDefault(); // Menghentikan perilaku default dari tautan

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
                // Jika pengguna menekan Ya, maka arahkan ke URL penghapusan
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
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
<!-- Main content -->
<div class="container">
    <!-- Content area -->
    <div class="content">
        <?php echo $this->session->flashdata('msg'); ?>
        <!-- Daftar Data Kerusakan -->
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <div class="navigation-buttons">
                        <i class="fa fa-reply-all"></i> Data Kerusakan Respond
                        <div class="btn-group" style="float: right;">
                            <!-- Tombol Dropdown (di pojok kanan atas) -->
                            <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bars"></i>
                            </button>
                            <!-- Isi Dropdown -->
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <li><a href="<?php echo site_url('users/kerusakan/data_kerusakan'); ?>"><i class="fa fa-file"></i> Data Kerusakan</a></li>
                                <li><a href="<?php echo site_url('users/kerusakan/data_kerusakan_respond'); ?>"><i class="fa fa-reply-all"></i> Data Respond</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Membersihkan float -->
                    <div class="clearfix"></div>
                    <a href="users/kerusakan" class="btn btn-danger">+ Tambah</a>
                </div>
                <div class="table-responsive">
                    <!-- <table class="table table-bordered table-striped"> -->
                    <table class="table table-striped table datatable-basic" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Petugas</th>
                                <th>Kantor</th>
                                <th>Kerusakan</th>
                                <th>Foto</th>
                                <th>Tindakan</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1; // Inisialisasi nomor urut
                            foreach ($kerusakan as $kerusakan_item) : ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td>
                                        <?php echo date('Y-m-d', strtotime($kerusakan_item['created_at'])); ?>
                                    </td>
                                    <td>
                                        <?php echo $kerusakan_item['petugas']; ?>
                                    </td>
                                    <td>
                                        <?php
                                        $kantorOptions = [
                                            '01' => 'PUSAT',
                                            '02' => 'SEDAYU',
                                            '03' => 'SAPURAN',
                                            '04' => 'KERTEK',
                                            '05' => 'WONOSOBO',
                                            '06' => 'KALIWIRO',
                                            '07' => 'BANJARNEGARA',
                                            '08' => 'RANDUSARI',
                                            '09' => 'KEPIL'
                                        ];
                                        echo isset($kantorOptions[$kerusakan_item['kantor']]) ? $kantorOptions[$kerusakan_item['kantor']] : 'Nilai tidak valid';
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        // Ambil teks kerusakan
                                        $kerusakan_text = $kerusakan_item['kerusakan'];

                                        // Tentukan batas karakter yang ingin ditampilkan
                                        $char_limit = 20; // Misalnya, 50 karakter

                                        // Potong teks jika melebihi batas karakter
                                        if (strlen($kerusakan_text) > $char_limit) {
                                            $kerusakan_text = substr($kerusakan_text, 0, $char_limit) . '...';
                                        }

                                        // Tampilkan teks yang telah dipotong
                                        echo $kerusakan_text;
                                        ?>
                                    </td>

                                    <td>

                                        <?php
                                        // Ambil nama file foto_kerusakan dari data kerusakan_item
                                        $foto_kerusakan = $kerusakan_item['foto_kerusakan'];

                                        // Buat URL lengkap untuk thumbnail
                                        $thumbnailURL = './foto/kerusakan/' . $foto_kerusakan;

                                        // Jika file foto_kerusakan tidak kosong, tampilkan thumbnail
                                        if (!empty($foto_kerusakan) && file_exists($thumbnailURL)) {
                                        ?>
                                            <a href="javascript:void(0);" onclick="openPopup('<?php echo $thumbnailURL; ?>');">
                                                <img src="<?php echo $thumbnailURL; ?>" alt="Thumbnail" width="30">
                                            </a>
                                        <?php
                                        } else {
                                            echo "N/A"; // Pesan jika foto tidak tersedia
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo $kerusakan_item['tindakan']; ?>
                                    </td>
                                    <td>
                                        <?php
                                        $allowedLevels = ['kadiv_manrisk', 's_admin', 'it'];

                                        if (in_array($user->row()->level, $allowedLevels)) {
                                        ?>
                                            <button type="button" class="btn btn-sm btn-primary" onclick="editKerusakan(<?php echo $kerusakan_item['id']; ?>)">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger" onclick="hapusKerusakan(<?php echo htmlspecialchars($kerusakan_item['id']); ?>)">
                                                <i class="fa fa-trash"></i>
                                            </button>

                                        <?php
                                        }
                                        ?>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /main content -->

<!-- Modal HTML -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    function hapusKerusakan(id) {
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: 'Apakah Anda yakin ingin menghapus data kerusakan ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect ke controller hapus_kerusakan dengan parameter id
                window.location.href = "<?php echo site_url('users/hapus_kerusakan/'); ?>" + id;
            }
        });
    }


    function editKerusakan(id) {
        // Redirect ke controller edit_kerusakan
        window.location.href = "<?php echo site_url('users/edit_kerusakan/'); ?>" + id;
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
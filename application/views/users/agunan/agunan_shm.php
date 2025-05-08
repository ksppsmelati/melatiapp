<?php
$cek = $user->row();
$level = $cek->level;
$nama_lengkap = $cek->nama_lengkap;
$kode_kantor = $cek->kode_kantor;

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
    <?php if ($this->session->flashdata('msg')): ?>
        <div class="alert alert-danger">
            <?php echo $this->session->flashdata('msg'); ?>
        </div>
    <?php endif; ?>
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <div class="navigation-buttons">
                        <div class="btn-group" style="float: left;">
                            <i class="fa fa-folder"></i> DATA SHM
                        </div>

                        <div class="btn-group" style="float: right;">
                            <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bars"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <li><a href="<?php echo site_url('users/agunan/agunan'); ?>"><i class="fa fa-id-card"></i> DATA BPKB</a></li>
                                <li><a href="<?php echo site_url('users/agunan/agunan_shm'); ?>"><i class="fa fa-folder"></i> DATA SHM</a></li>
                                <?php
                                $allowedLevels = ['kadiv_opr', 'k_arsip', 's_admin','k_admin'];
                                if (in_array($user->row()->level, $allowedLevels)) {
                                    echo '<li><a href="' . site_url('users/agunan_data_proses') . '"><i class="fa fa-shopping-cart"></i> DATA PESANAN</a></li>';
                                }
                                ?>
                                <?php
                                $allowedLevels = ['admin'];
                                if (in_array($user->row()->level, $allowedLevels)) {
                                    echo '<li><a href="' . site_url('users/agunan_data_proses_cabang') . '"><i class="fa fa-shopping-cart"></i> DATA PESANAN</a></li>';
                                }
                                ?>
                            </ul>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <hr>

                    <div class="col-md-6 mb-3 mb-md-0" style="margin-bottom: 10px;">
                        <?php
                        $allowedLevels = ['admin', 'k_arsip', 'kadiv_opr', 's_admin','k_admin'];
                        if (in_array($user->row()->level, $allowedLevels)) {
                            echo '<a href="users/agunan/agunan_tambah_shm" class="btn btn-danger mb-3">+ Tambah SHM</a>';
                        }
                        ?>
                        <?php
                        $allowedLevels = ['admin', 'k_arsip', 'kadiv_opr', 's_admin','k_admin'];
                        if (in_array($user->row()->level, $allowedLevels)) {
                            echo '<a href="users/agunan/agunan_tambah" class="btn btn-primary mb-3">+ Tambah BPKB</a>';
                        }
                        ?>
                    </div>

                    <form method="get" action="<?= site_url('users/agunan/agunan_shm'); ?>" style="float: right;">
                        <div class="row">
                                <select name="kode_kantor" id="kode_kantor" class="form-control mr-2" onchange="this.form.submit()">
                                    <?php foreach ($kantorNames as $key => $name) : ?>
                                        <option value="<?= $key ?>" <?= ($selected_kode_kantor == $key || ($selected_kode_kantor == null && $key == 'all')) ? 'selected' : ''; ?>>
                                            <?= $name ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                        </div>
                    </form>

                </div>
                <div class="table-responsive">
                    <table class="table datatable-basic table-striped" width="100%">
                        <thead>
                            <tr>
                                <th style="display: none;"></th>
                                <th></th>
                                <th>ID</th>
                                <!-- <th>Tanggal</th> -->
                                <th style="position: sticky; left: 0; z-index: 1; background:#fff;">Nama Anggota</th>
                                <th>Alamat</th>
                                <th>Kantor</th>
                                <th>No. Kontrak</th>
                                <!-- <th>Jenis Dokumen</th> -->
                                <!-- <th>Atas Nama</th> -->
                                <!-- <th>Keterangan</th> -->
                                <!-- <th>Petugas Input</th> -->
                                <!-- <th>Petugas Ubah</th> -->
                                <th>Status</th>
                                <!-- <th>Foto</th> -->
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($agunan_data)) : ?>
                                <?php foreach ($agunan_data as $data) : ?>
                                    <tr>
                                        <td style="display: none;"><?php echo $data->tanggal_ubah; ?></td>
                                        <td>
                                            <?php if ($data->status_proses == 1) : ?>
                                                <i class="fa fa-shopping-cart text-danger"></i>
                                            <?php else : ?>
                                                <!--  -->
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo $data->id; ?></td>
                                        <!-- <td><?php echo $data->tanggal; ?></td> -->
                                        <td style="position: sticky; left: 0; z-index: 1; background:#fff;">
                                            <a href="<?php echo site_url('users/agunan/agunan_lihat_shm/' . $data->id); ?>">
                                                <?php echo $data->nama_anggota; ?>
                                            </a>
                                        </td>
                                        <td><?php echo $data->alamat; ?></td>
                                        <td><?php echo $kodeKantorText = getKodeKantorText($data->kode_kantor); ?></td>
                                        <td><?php echo $data->no_kontrak; ?></td>
                                        <!-- <td><?php echo $kodeJnsDokumenText = getJenisDokumenText($data->jenis_dokumen); ?></td> -->

                                        <!-- <td><?php echo $data->atas_nama; ?></td> -->
                                        <!-- <td><?php echo substr($data->keterangan, 0, 30); ?></td> -->
                                        <!-- <td><?php echo $data->petugas_input; ?></td> -->
                                        <!-- <td><?php echo $data->petugas_ubah; ?></td> -->
                                        <td>
                                            <?php
                                            // Mengecek apakah kode kantor ada dalam array
                                            $cabangName = array_key_exists($data->cabang, $kantorNames) ? $kantorNames[$data->cabang] : '';
                                            echo $data->status . ' ' . $cabangName . ' ' . $data->nama_pembawa;
                                            ?>
                                        </td>
                                        <!-- <td>
                                            <?php
                                            $foto_agunan = $data->foto_agunan;
                                            $thumbnailURL = './foto/foto_agunan/' . $foto_agunan;
                                            if (!empty($foto_agunan) && file_exists($thumbnailURL)) {
                                            ?>
                                                <a href="javascript:void(0);" onclick="openPopup('<?php echo $thumbnailURL; ?>');">
                                                    <img src="<?php echo $thumbnailURL; ?>" class="gambar" alt="Thumbnail" width="30">
                                                </a>
                                            <?php
                                            } else {
                                                echo "";
                                            }
                                            ?>
                                        </td> -->
                                        <td>
                                            <a href="<?php echo site_url('users/agunan_lihat_shm/' . $data->id); ?>" class="btn btn-primary btn-xs"><i class="icon-eye"></i></a>
                                            <?php
                                            $allowedLevels = ['kadiv_opr', 'admin', 'k_arsip', 's_admin','k_admin'];
                                            if (in_array($user->row()->level, $allowedLevels)) : ?>
                                                <a href="<?php echo site_url('users/agunan_edit_shm/' . $data->id); ?>" class="btn btn-success btn-xs"><i class="icon-pencil7"></i></a>
                                            <?php endif; ?>
                                            <?php
                                            $allowedLevels = ['kadiv_opr', 'k_arsip', 'admin', 's_admin','k_admin'];
                                            if (in_array($user->row()->level, $allowedLevels)) :
                                            ?>
                                                <a href="#" class="btn btn-info btn-xs shareButton" data-id="<?php echo $data->id; ?>" data-toggle="modal" data-target="#shareModal"><i class="fa fa-shopping-cart"></i></a>
                                            <?php endif; ?>
                                            <?php
                                            $allowedLevels = ['kadiv_opr', 'k_arsip', 's_admin','k_admin'];
                                            if (in_array($user->row()->level, $allowedLevels)) :
                                            ?>
                                                <a href="#" class="btn btn-danger btn-xs delete-agunan" data-id="<?php echo $data->id; ?>"><i class="icon-trash"></i></a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>

                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <!-- Modal Pesan -->
                <div class="modal fade" id="shareModal" tabindex="-1" role="dialog" aria-labelledby="shareModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="shareModalLabel">Pesan Agunan</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <p id="agunanIdText"><?php echo $data->id; ?></p>
                                </div>
                                <div class="form-group">
                                    <label for="shareNote">Catatan:</label>
                                    <textarea class="form-control" id="shareNote" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                <button type="button" class="btn btn-danger" id="shareButton" data-id="">Kirim</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        $('.delete-agunan').on('click', function(e) {
            e.preventDefault();
            var shmId = $(this).data('id');

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
                    window.location.href = '<?php echo site_url('users/agunan_delete_shm/'); ?>' + shmId;
                }
            });
        });
    });

    $(document).ready(function() {
        // Menangkap peristiwa klik pada tombol "Share"
        $(document).on('click', '.shareButton', function() {
            // Mendapatkan ID entitas dari atribut data-id
            var entityId = $(this).data('id');

            // Memperbarui teks dalam modal dengan ID yang sesuai
            $('#agunanIdText').text('BPKB ID: ' + entityId);

            // Menyimpan ID entitas dalam modal
            $('#shareModal').data('id', entityId);
        });

        // Menangkap peristiwa klik pada tombol "Kirim" dalam modal
        $(document).on('click', '#shareButton', function() {
            // Mendapatkan catatan dari textarea
            var note = $('#shareNote').val();
            // Mendapatkan ID entitas dari data yang disimpan dalam modal
            var agunanId = $('#shareModal').data('id');

            // Membentuk URL
            var url = '<?php echo site_url("users/agunan_lihat_shm/"); ?>' + agunanId;
            var message = 'SHM ID: ' + agunanId + '%0A%0ALink: ' + url;

            // Menambahkan catatan jika ada
            if (note) {
                message += '%0A%0ACatatan: ' + encodeURIComponent(note);
            }

            // Membentuk URL WhatsApp
            var whatsappUrl = 'https://wa.me/?text=' + message;

            // Membuka URL WhatsApp di tab baru
            window.open(whatsappUrl, '_blank');
        });
    });


    // untuk ubah status_proses dan update data petugas ubah dan tanggal ubah
    $(document).ready(function() {
        // Menangkap peristiwa klik pada tombol "Share" di tabel
        $(document).on('click', '.shareButton', function() {
            // Mendapatkan ID entitas dari atribut data-id
            var entityId = $(this).data('id');

            // Memperbarui teks dalam modal dengan ID yang sesuai
            $('#agunanIdText').text('SHM ID: ' + entityId);

            // Menyimpan ID entitas dalam tombol "Kirim" di modal
            $('#shareButton').data('id', entityId);
        });

        // Menangkap peristiwa klik pada tombol "Kirim" di dalam modal
        $('#shareButton').on('click', function() {
            // Mendapatkan ID entitas dari atribut data-id pada tombol "Kirim"
            var entityId = $(this).data('id');

            // Mendapatkan nilai petugas_ubah
            var petugas_ubah = '<?php echo $nama_lengkap; ?>';

            // Mendapatkan nilai tanggal_ubah dari fungsi getCurrentDate
            var tanggal_ubah = getCurrentDate();

            // Mendapatkan nilai dari textarea dengan ID shareNote
            var catatan = $('#shareNote').val().trim();

            // Mengirim permintaan AJAX ke server (ke URL controller CodeIgniter)
            $.ajax({
                url: '<?= base_url("users/agunan_update_status_proses_shm/") ?>' + entityId,
                method: 'POST',
                data: {
                    status_proses: 1,
                    tanggal_ubah: tanggal_ubah, // Menggunakan nilai dari variabel tanggal_ubah
                    petugas_ubah: petugas_ubah, // Menggunakan nilai dari variabel petugas_ubah
                    catatan: catatan // Tambahkan catatan yang diambil dari textarea
                },
                success: function(response) {
                    // Tindakan setelah permintaan berhasil
                    console.log('Status proses berhasil diperbarui.');
                    // Menutup modal
                    $('#shareModal').modal('hide');
                    // Mengarahkan ke halaman yang diinginkan
                    <?php
                    $allowedLevels = ['kadiv_opr', 'k_arsip', 's_admin','k_admin'];
                    if (in_array($user->row()->level, $allowedLevels)) {
                        $redirectUrl = base_url("users/agunan_data_proses");
                    } else {
                        $redirectUrl = base_url("users/agunan_data_proses_cabang");
                    }
                    ?>
                    window.location.href = '<?= $redirectUrl ?>';

                },
                error: function(xhr, status, error) {
                    // Tindakan jika terjadi kesalahan
                    console.error('Kesalahan saat memperbarui status proses:', error);
                }
            });
        });

        // Fungsi untuk mendapatkan tanggal saat ini dalam format YYYYmmdd
        function getCurrentDate() {
            var today = new Date();
            var year = today.getFullYear();
            var month = ('0' + (today.getMonth() + 1)).slice(-2);
            var day = ('0' + today.getDate()).slice(-2);
            return year + month + day;
        }
    });
</script>
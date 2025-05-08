<?php
$cek = $user->row();
$level = $cek->level;
$id_user = $cek->id_user;
$nama_lengkap = $cek->nama_lengkap;

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
        <?php echo $this->session->flashdata('msg'); ?>
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <div class="navigation-buttons">
                        <div class="btn-group" style="float: left;">
                            <i class="fa fa-television"></i> DATA TRANSAKSI IMFA
                        </div>

                        <div class="btn-group" style="float: right;">
                            <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bars"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <li><a href="<?php echo site_url('users/transaksi_imfa_data'); ?>"><i class="fa fa-television"></i> Data Transaksi IMFA</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <?php
                    $current_route = $this->router->fetch_class() . '/' . $this->router->fetch_method();
                    ?>
                </div>
                <div class="table-responsive">
                    <table class="table datatable-basic table-striped" width="100%">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>NO-TRN</th>
                                <th>KODE</th>
                                <th>NO-DEBET</th>
                                <th>NO-KREDIT</th>
                                <th>KETERANGAN</th>
                                <th>DOKUMEN</th>
                                <th>NOMINAL-DR</th>
                                <th>NOMINAL-CR</th>
                                <th>Inpuser</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($transaksi_data)) : ?>
                                <?php $no = 1; ?>
                                <?php foreach ($transaksi_data as $data) : ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $data->notrn; ?></td>
                                        <td><?php echo $data->kodetrn; ?></td>
                                        <td><?php echo $data->dracc; ?></td>
                                        <td><?php echo $data->cracc; ?></td>
                                        <td><?php echo substr($data->ket, 0, 30); ?></td>
                                        <td><?php echo $data->dokumen; ?></td>
                                        <td><?php echo number_format($data->nominalrp, 2); ?></td>
                                        <td><?php echo number_format($data->nominalva, 2); ?></td>
                                        <td><?php echo $data->inpuser; ?></td>
                                        <td>
                                            <a href="<?php echo site_url('users/kunjungan_lihat/' . $data->notrn); ?>" class="btn btn-primary btn-xs"><i class="icon-eye"></i></a>
                                            <?php
                                            $allowedLevels = ['kadiv_opr', 'admin', 'k_arsip', 's_admin'];
                                            if (in_array($user->row()->level, $allowedLevels)) : ?>
                                                <a href="<?php echo site_url('users/kunjungan_edit/' . $data->notrn); ?>" class="btn btn-success btn-xs"><i class="icon-pencil7"></i></a>
                                            <?php endif; ?>
                                            <?php
                                            $allowedLevels = ['kadiv_opr', 'k_arsip', 's_admin'];
                                            if (in_array($user->row()->level, $allowedLevels)) :
                                            ?>
                                                <a href="#" class="btn btn-danger btn-xs hapus-kunjungan" data-id="<?php echo $data->notrn; ?>"><i class="icon-trash"></i></a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="10" class="text-center">Data tidak ditemukan</td>
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
        $('.hapus-kunjungan').on('click', function(e) {
            e.preventDefault();
            var kunjunganId = $(this).data('id');

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
                    window.location.href = '<?php echo site_url('users/kunjungan_hapus/'); ?>' + kunjunganId;
                }
            });
        });
    });
</script>
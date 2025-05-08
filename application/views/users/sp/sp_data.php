<?php
$cek = $user->row();
$level = $cek->level;
$id_user = $cek->id_user;
$nama_lengkap = $cek->nama_lengkap;

$tanggal_awal = isset($_GET['tanggal_awal']) ? $_GET['tanggal_awal'] : date('Y-m-01');
$tanggal_akhir = isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : date('Y-m-d');
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
                            <i class="fa-solid fa-file-pen"></i></i> DATA SP
                        </div>

                        <div class="btn-group" style="float: right;">
                            <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bars"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <li><a href="<?php echo site_url('users/sp_data_col'); ?>"><i class="fa-solid fa-file"></i> Data COL</a></li>
                                <li><a href="<?php echo site_url('users/sp_data'); ?>"><i class="fa-solid fa-file-pen"></i> Data SP</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <?php
                    $allowedLevels = ['kadiv_opr', 'mng_bisnis', 's_admin', 'marketing', 'ao', 'k_cabang', 'kadiv_manrisk', 'kadiv_pemasaran', 'surveyor', 'fo', 'it'];

                    if (in_array($user->row()->level, $allowedLevels)) {
                        echo '<a href="users/sp_tambah" class="btn btn-danger">+ Tambah</a>';
                    }
                    ?>
                    <hr>
                    <?php
                    // Menyimpan nama rute yang sedang aktif dalam variabel
                    $current_route = $this->router->fetch_class() . '/' . $this->router->fetch_method();
                    ?>
                    <form method="get" action="<?php echo site_url($current_route); ?>">
                        <div class="row">
                            <div class="col-xs-4">
                                <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control" value="<?= isset($_GET['tanggal_awal']) ? $_GET['tanggal_awal'] : (isset($tanggal_awal) ? $tanggal_awal : date('Y-m-d')) ?>" required>
                            </div>
                            <div class="col-xs-4">
                                <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control" value="<?= isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : (isset($tanggal_akhir) ? $tanggal_akhir : date('Y-m-d')) ?>" required>
                            </div>
                            <div class="col-xs-2">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                            </div>
                            <div class="col-xs-2">
                                <a href="<?php echo site_url($current_route); ?>" class="btn btn-secondary"><i class="fa fa-refresh"></i></a>
                            </div>
                            <br><br><br>
                        </div>
                    </form>
                </div>
                <div class="table-responsive">
                    <table class="table datatable-basic table-striped" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No Kontrak</th>
                                <th style="position: sticky; left: 0; z-index: 1; background:#fff;">Nama Anggota</th>
                                <th>Alamat</th>
                                <th>Jenis Dokumen</th>
                                <th>Kantor</th>
                                <th>SP</th>
                                <th>Tanggal</th>
                                <th>Inpuser</th>
                                <th>ttd</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($sp_data)) : ?>
                                <?php $no = 1; // Inisialisasi nomor urut 
                                ?>
                                <?php foreach ($sp_data as $data) : ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $data->nokontrak; ?></td>
                                        <td style="position: sticky; left: 0; z-index: 1; background:#fff;">
                                            <a href="<?php echo site_url('users/sp_lihat/' . $data->nokontrak); ?>">
                                                <?php echo strtoupper($data->nama); ?>
                                            </a>
                                        </td>
                                        <td><?php echo $data->alamat; ?></td>
                                        <td><?php echo getJenisDokumenText($data->jnsdokumen); ?></td>
                                        <td><?php echo getKodeKantorText($data->kdloc); ?></td>
                                        <td><?php echo $data->jenis_sp; ?></td>
                                        <td><?php echo $data->tgl_input; ?></td>
                                        <td><?php echo $data->inpuser; ?></td>
                                        <td><?php echo $data->ttd; ?></td>
                                        <td>
                                            <a href="<?php echo site_url('users/sp_lihat/' . $data->nokontrak); ?>" class="btn btn-primary btn-xs"><i class="icon-eye"></i></a>
                                            <?php
                                            $jenis_sp = strtoupper($data->jenis_sp);
                                            $jnsdokumen = isset($data->jnsdokumen) ? strtoupper($data->jnsdokumen) : '';

                                            // Tentukan route print berdasarkan jenis SP dan jenis dokumen
                                            if ($jenis_sp === 'SP1') {
                                                $print_url = site_url('users/sp_print_SP1/' . $data->nokontrak);
                                            } elseif ($jenis_sp === 'SP2') {
                                                $print_url = site_url('users/sp_print_SP2/' . $data->nokontrak);
                                            } elseif ($jenis_sp === 'SP3') {
                                                if ($jnsdokumen === '1') {
                                                    $print_url = site_url('users/sp_print_SP3_SHM/' . $data->nokontrak);
                                                } else {
                                                    $print_url = site_url('users/sp_print_SP3_BPKB/' . $data->nokontrak);
                                                }
                                            } else {
                                                $print_url = '#'; // fallback jika jenis_sp tidak dikenali
                                            }
                                            ?>
                                            <a href="<?php echo $print_url; ?>" target="_blank" class="btn btn-warning btn-xs">
                                                <i class="icon-printer"></i>
                                            </a>
                                            <?php
                                            $allowedLevels = ['kadiv_opr', 'admin', 'k_arsip', 's_admin'];
                                            if (in_array($user->row()->level, $allowedLevels)) : ?>
                                                <a href="<?php echo site_url('users/sp_edit/' . $data->nokontrak); ?>" class="btn btn-success btn-xs"><i class="icon-pencil7"></i></a>
                                            <?php endif; ?>
                                            <a href="javascript:void(0);" onclick="confirmDelete('<?php echo site_url('users/sp_hapus/' . $data->nokontrak); ?>')" class="btn btn-danger btn-xs">
                                                <i class="fa fa-trash"></i>
                                            </a>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(url) {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    }
</script>
<?php
$cek = $user->row();
$level = $cek->level;
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
                            <i class="fa fa-television"></i> DATA MONITORING
                        </div>

                        <div class="btn-group" style="float: right;">
                            <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bars"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <li><a href="<?php echo site_url('users/monitoring_by_range_tgl'); ?>"><i class="fa fa-television"></i> Data Monitoring</a></li>

                            </ul>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <?php
                    $allowedLevels = ['kadiv_opr', 'mng_bisnis', 's_admin', 'marketing', 'ao', 'k_cabang', 'kadiv_manrisk', 'kadiv_pemasaran', 'surveyor','fo'];

                    if (in_array($user->row()->level, $allowedLevels)) {
                        echo '<a href="users/monitoring_tambah" class="btn btn-danger">+ Tambah</a>';
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
                                <th style="display: none;"></th>
                                <th>ID / Tanggal</th>
                                <!-- <th>Tanggal</th> -->
                                <th style="position: sticky; left: 0; z-index: 1; background:#fff;">Nama Anggota</th>
                                <th>Alamat</th>
                                <th>Jenis Usaha</th>
                                <th>Status</th>
                                <th>Jumlah Karywan</th>
                                <!-- <th>No. Kontrak</th> -->
                                <!-- <th>Jenis Dokumen</th> -->
                                <!-- <th>Atas Nama</th> -->
                                <!-- <th>Keterangan</th> -->
                                <th>Petugas Input</th>
                                <!-- <th>Petugas Ubah</th> -->
                                <th>Foto Jaminan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($agunan_data)) : ?>
                                <?php foreach ($agunan_data as $data) : ?>
                                    <tr>
                                        <td style="display: none;"><?php echo $data->tanggal_ubah; ?></td>
                                        <td><?php echo $data->id; ?> - <?php echo $data->kode_kantor; ?><br>
                                        <span style="font-size: 12px;">[ <?php echo date('d-m-Y', strtotime($data->tanggal)); ?> ]</span>
                                        </td>
                                        <!-- <td><?php echo $data->tanggal; ?></td> -->
                                        <td style="position: sticky; left: 0; z-index: 1; background:#fff;">
                                            <a href="<?php echo site_url('users/monitoring/monitoring_lihat/' . $data->id); ?>">
                                                <?php echo strtoupper($data->nama_anggota); ?>
                                            </a>
                                        </td>
                                        <td><?php echo strtoupper($data->alamat); ?></td>
                                        <td><?php echo $kodeJnsUsahaText = getKodeJnsUsahaText($data->jns_usaha); ?></td>
                                        <td>
                                            <?php
                                            if ($data->status == 1) {
                                                echo '<i class="fa fa-equals" style="color: orange;"></i> <span style="color: orange;">SAMA</span>';
                                            } elseif ($data->status == 2) {
                                                echo '<i class="fa fa-arrow-up" style="color: green;"></i> <span style="color: green;">NAIK</span>';
                                            } elseif ($data->status == 0) {
                                                echo '<i class="fa fa-arrow-down" style="color: red;"></i> <span style="color: red;">TURUN</span>';
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $data->jml_karyawan; ?></td>
                                        <!-- <td><?php echo $kodeKantorText = getKodeKantorText($data->kode_kantor); ?></td> -->
                                        <!-- <td><?php echo $data->no_kontrak; ?></td> -->
                                        <!-- <td>
                                            <?php
                                            $jenis_dokumen = $data->jenis_dokumen;
                                            $kode_dok = [
                                                '1' => 'SHM',
                                                '2' => 'SHM A/Rusun',
                                                '3' => 'SHGB',
                                                '4' => 'SHP',
                                                '5' => 'SHGU',
                                                '6' => 'BPKB',
                                                '7' => 'AJB',
                                                '8' => 'BILYET DEPOSITO',
                                                '9' => 'BUKU TABUNGAN',
                                                '10' => 'CEK',
                                                '11' => 'BILYET GIRO',
                                                '12' => 'SURAT PERNYATAAN & KUASA',
                                                '13' => 'INVOICE / FAKTUR',
                                                '14' => 'SIPTB',
                                                '15' => 'DOKUMEN KONTAK',
                                                '16' => 'SAHAM',
                                                '17' => 'OBLIGASI',
                                                '18' => 'SK INSTITUSI/LEMBAGA',
                                                '19' => 'LAIN-LAIN',
                                                '20' => 'LETTER C/GIRIK',
                                                '21' => 'KARTU PASAR',

                                            ];

                                            // Mengecek apakah kode dokumen ada dalam array
                                            if (array_key_exists($jenis_dokumen, $kode_dok)) {
                                                echo $kode_dok[$jenis_dokumen];
                                            } else {
                                                echo '-';
                                            }
                                            ?>
                                        </td> -->

                                        <!-- <td><?php echo $data->atas_nama; ?></td> -->
                                        <!-- <td><?php echo substr($data->keterangan, 0, 30); ?></td> -->
                                        <td><?php echo strtoupper($data->petugas_input); ?></td>
                                        <!-- <td><?php echo $data->petugas_ubah; ?></td> -->



                                        <td>
                                            <?php
                                            $foto_monitoring = $data->foto_monitoring;
                                            $thumbnailURL = './foto/foto_monitoring/' . $foto_monitoring;
                                            if (!empty($foto_monitoring) && file_exists($thumbnailURL)) {
                                            ?>
                                                <a href="javascript:void(0);" onclick="openPopup('<?php echo $thumbnailURL; ?>');">
                                                    <img src="<?php echo $thumbnailURL; ?>" class="gambar" alt="Thumbnail" width="30" loading="lazy">
                                                </a>
                                            <?php
                                            } else {
                                                echo "";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo site_url('users/monitoring_lihat/' . $data->id); ?>" class="btn btn-primary btn-xs"><i class="icon-eye"></i></a>
                                            <?php
                                            $allowedLevels = ['kadiv_opr', 'admin', 'k_arsip', 's_admin'];
                                            if (in_array($user->row()->level, $allowedLevels)) : ?>
                                                <a href="<?php echo site_url('users/monitoring_edit/' . $data->id); ?>" class="btn btn-success btn-xs"><i class="icon-pencil7"></i></a>
                                            <?php endif; ?>
                                            <?php
                                            $allowedLevels = ['kadiv_opr', 'k_arsip', 's_admin'];
                                            if (in_array($user->row()->level, $allowedLevels)) :
                                            ?>
                                                <a href="#" class="btn btn-danger btn-xs hapus-monitoring" data-id="<?php echo $data->id; ?>"><i class="icon-trash"></i></a>
                                            <?php endif; ?>
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
        $('.hapus-monitoring').on('click', function(e) {
            e.preventDefault();
            var monitoringId = $(this).data('id');

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
                    window.location.href = '<?php echo site_url('users/monitoring_hapus/'); ?>' + monitoringId;
                }
            });
        });
    });
</script>
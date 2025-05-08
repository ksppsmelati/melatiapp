<?php
$cek = $user->row();
$nama_lengkap = $cek->nama_lengkap;
$kode_kantor = $cek->kode_kantor;
$level = $cek->level;
$kantorNames = [
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
                            <i class="fa fa-truck"></i> DATA AGUNAN TRACKING
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="table-responsive">
                    <table class="table datatable-basic" width="100%">
                        <thead>
                            <tr>
                                <th>Jenis Dokumen</th>
                                <!-- <th>ID</th> -->
                                <!-- <th>Tanggal</th> -->
                                <th style="position: sticky; left: 0; z-index: 1; background:#fff;">Nama Anggota</th>
                                <!-- <th>Alamat</th> -->
                                <!-- <th>Kantor</th> -->
                                <!-- <th>No. Kontrak</th> -->
                                <th>Status</th>
                                <!-- <th>Foto</th> -->
                                <th>Catatan</th> 
                                <th>Pemesan</th>
                                <th>Pengubah</th>
                                <!-- <th>Tgl. Ubah</th> -->
                                <!-- <th>Catatan</th> -->
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($agunan_tracking)) : ?>
                                <?php foreach ($agunan_tracking as $data) : ?>
                                    <tr>
                                        <td>
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

                                            // Determine the document type and the appropriate link
                                            $document_type = isset($kode_dok[$jenis_dokumen]) ? $kode_dok[$jenis_dokumen] : '-';
                                            $edit_link = ($jenis_dokumen == 6) ? 'users/agunan/agunan_lihat/' . $data->id : 'users/agunan/agunan_lihat_shm/' . $data->id;
                                            ?>
                                            <a href="<?php echo site_url($edit_link); ?>">
                                                <?php echo $document_type; ?>
                                            </a> - <?php
                                                    $edit_link = ($data->jenis_dokumen == 6) ? 'users/agunan/agunan_lihat/' . $data->id : 'users/agunan/agunan_lihat_shm/' . $data->id;
                                                    ?>
                                            <a href="<?php echo site_url($edit_link); ?>">
                                                <?php echo $data->id; ?>
                                            </a><br>
                                            <span style="font-size: 12px;">[ <?php echo $data->no_kontrak; ?> ]</span>
                                        </td>
                                        <!-- <td><?php echo $data->tanggal; ?></td> -->
                                        <td style="position: sticky; left: 0; z-index: 1; background:#fff;">
                                            <?php
                                            $edit_link = ($data->jenis_dokumen == 6) ? 'users/agunan/agunan_lihat/' . $data->id : 'users/agunan/agunan_lihat_shm/' . $data->id;
                                            ?>
                                            <a href="<?php echo site_url($edit_link); ?>">
                                                <?php echo $data->nama_anggota; ?>
                                            </a>
                                        </td>
                                        <!-- <td><?php echo $data->alamat; ?></td> -->
                                        <!-- <td><?php echo $data->no_kontrak; ?></td> -->
                                        <td style="white-space: normal; word-wrap: break-word; word-break: break-word; max-width: 200px; overflow-wrap: break-word;">
                                            <?php
                                            // Determine the button color based on the status
                                            $status = $data->status;
                                            $buttonColor = '';

                                            switch ($status) {
                                                case 'BRANGKAS':
                                                    $buttonColor = '#6c757d'; // Example color for BRANGKAS
                                                    break;
                                                case 'DIAMBIL':
                                                    $buttonColor = '#28a745'; // Example color for DIAMBIL
                                                    break;
                                                case 'DIBAWA':
                                                    $buttonColor = '#ff9807'; // Example color for DIAMBIL
                                                    break;
                                                case 'CABANG':
                                                    $buttonColor = '#17a2b8'; // Example color for DIAMBIL
                                                     break;
                                                case 'AGUNAN_DIPUSAT':
                                                    $buttonColor = '#9F2B68'; // Example color for AGUNAN_DIPUSAT
                                                    break;
                                                case 'NOTARIS':
                                                    $buttonColor = '#db0a5b'; // Example color for NOTARIS
                                                    break;
                                                default:
                                                    $buttonColor = '#5bc0de'; // Default color
                                                    break;
                                            }
                                            ?>

                                            <button style="
                                                background-color: <?php echo $buttonColor; ?>;
                                                color: white;
                                                border: none;
                                                padding: 2px 5px; /* Minimal padding */
                                                font-size: 9px; /* Smaller font size */
                                                border-radius: 3px;
                                                cursor: pointer;
                                            " title="<?php echo htmlspecialchars($status); ?>">
                                                <?php echo htmlspecialchars($status); ?>
                                            </button>
                                            <?php
                                            // Mengecek apakah kode kantor ada dalam array
                                            $cabangName = array_key_exists($data->cabang, $kantorNames) ? $kantorNames[$data->cabang] : '';
                                            echo $cabangName . ' ' . $data->nama_pembawa;
                                            ?>
                                        </td>
                                        <!-- <td>
                                            <?php
                                            $foto_agunan = $data->foto_agunan;
                                            $thumbnailURL = './foto/foto_agunan/' . $foto_agunan;
                                            if (!empty($foto_agunan) && file_exists($thumbnailURL)) {
                                            ?>
                                                <a href="javascript:void(0);" onclick="openPopup('<?php echo $thumbnailURL; ?>');">
                                                    <img src="<?php echo $thumbnailURL; ?>" class="gambar" alt="Thumbnail">
                                                </a>
                                            <?php
                                            } else {
                                                echo "-";
                                            }
                                            ?>
                        </td> -->
                                        <!-- <td><?php echo $data->atas_nama; ?></td> -->
                                        <!--<td><?php echo substr($data->keterangan, 0, 30); ?></td> -->
                                        <td><?php echo substr($data->catatan ?? '', 0, 30); ?></td>

                                        <td><?php echo $data->petugas_pesan; ?><br>
                                            <?php if (!empty($data->tanggal_pesan)) : ?>
                                                <span style="font-size: 12px;">[ <?php echo date('d-m-Y', strtotime($data->tanggal_pesan)); ?> ]</span>
                                            <?php else : ?>
                                                <!-- kosong -->
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo $data->petugas_ubah; ?> <br>
                                            <?php if (!empty($data->tanggal_ubah)) : ?>
                                                <span style="font-size: 12px;">[ <?php echo date('d-m-Y', strtotime($data->tanggal_ubah)); ?> ]</span>
                                            <?php else : ?>
                                                <!-- kosong -->
                                            <?php endif; ?>
                                        </td>
                                        <!-- <td><?php echo $data->catatan; ?></td> -->
                                        <td>
                                            <a href="<?php echo site_url(($data->jenis_dokumen == 6) ? 'users/agunan_lihat/' . $data->id : 'users/agunan_lihat_shm/' . $data->id); ?>" class="btn btn-primary btn-xs">
                                                <i class="fa fa-eye"></i>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    // untuk ubah status_proses dan update data petugas ubah dan tanggal ubah
    $(document).ready(function() {
        $('.selesai-btn').on('click', function(e) {
            e.preventDefault(); // Mencegah tindakan default dari anchor tag

            var entityId = $(this).data('id');
            var jenisDokumen = $(this).data('jenis');
            var petugas_ubah = '<?php echo $nama_lengkap; ?>';
            var tanggal_ubah = getCurrentDate();
            var url = (jenisDokumen == 6) ? '<?php echo base_url("users/agunan_update_status_proses/"); ?>' : '<?php echo base_url("users/agunan_update_status_proses_shm/"); ?>';

            // Mengirim permintaan AJAX ke server
            $.ajax({
                url: url + entityId,
                method: 'POST',
                data: {
                    status_proses: 0,
                    tanggal_ubah: tanggal_ubah,
                    petugas_ubah: petugas_ubah
                },
                success: function(response) {
                    // Tindakan setelah permintaan berhasil
                    console.log('Status proses berhasil diperbarui.');
                    location.reload(); // Memperbarui halaman
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
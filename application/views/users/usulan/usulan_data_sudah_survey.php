<?php
$cek = $user->row(); //  mengambil nilai data dari tabel tbl_user 
$level = $cek->level; //  nilai level dari variabel $level
$id_user = $cek->id_user;
$kode_kantor = $cek->kode_kantor;
?>

<style>
    .table-striped tbody tr:nth-child(odd) {
        background-color: white;
    }

    .table-striped tbody tr:nth-child(even) {
        background-color: #ccc;
    }

    .table th {
        font-weight: bold;
    }

    .container {
        width: 100%;
        margin: 0;
    }

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
                        <i class="fa-solid fa-file-waveform"></i> Usulan Proses
                        <div class="btn-group" style="float: right;">
                            <!-- Tombol Dropdown (di pojok kanan atas) -->
                            <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bars"></i>
                            </button>
                            <!-- Isi Dropdown -->
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <!-- <li><a href="users/usulan_tambah"><i class="fa fa-plus"></i> Tambah Usulan</a>
                                </li> -->
                                <li><a href="users/usulan_data"><i class="fa-solid fa-file-import"></i> Usulan Masuk</a>
                                </li>
                                <li><a href="users/usulan_data_sudah_survey"><i class="fa-solid fa-file-waveform"></i> Usulan Proses</a>
                                </li>
                                <li><a href="users/infografis_survey_petugas"><i class="fa-solid fa-person-running"></i> Jml Survey Petugas</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- Membersihkan float -->
                    <div class="clearfix"></div>
                    <!-- <a href="users/usulan_tambah" class="btn btn-danger">+ Tambah</a> -->
                </div>
                <div id="scrollable-table" class="table-responsive" style="overflow-x: auto;">
                    <table class="table datatable-basic" width="100%">
                        <thead>
                            <tr>
                                <th style="display: none;">No.</th>
                                <th>ID/CekBI</th>
                                <th>Tanggal</th>
                                <th style="position: sticky; left: 0; z-index: 1; background:#fff;">Nama</th>
                                <!-- <th>Pekerjaan</th> -->
                                <th>Alamat</th>
                                <!-- <th>Tujuan Pembiayaan</th> -->
                                <th>Plafond</th>
                                <th>TTD</th>
                                <th>Wewenang survey</th>
                                <th>No. Telepon</th>
                                <!-- <th>Jangka Waktu</th> -->
                                <th>Jaminan</th>
                                <th>Aksi</th> <!-- Kolom untuk aksi -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($usulan_data as $usulan) :
                                // Cek apakah level bukan 'surveyor' atau 's_admin'
                                if (!in_array($level, ['surveyor', 's_admin'])) :
                                    // Jika level bukan 'surveyor' atau 's_admin', lakukan filter berdasarkan kode_kantor
                                    if ($usulan->kode_kantor == $kode_kantor) :
                            ?>
                                        <tr>
                                            <td style="display: none;">
                                                <?php echo $no++; ?>
                                            </td>
                                            <td>
                                                <strong class="<?php echo ($usulan->status_survey == 1) ? 'text-primary' : ''; ?>">
                                                    <?php
                                                    if (!empty($usulan->tgl_cek_bi)) {
                                                        echo date('Ymd', strtotime($usulan->tgl_cek_bi)) . '_PBY' . $usulan->id;
                                                    } else {
                                                        echo 'PBY' . $usulan->id;
                                                    }
                                                    ?>
                                                </strong>
                                            </td>
                                            <td>
                                                <?php echo date('Y-m-d', strtotime($usulan->tanggal)); ?>
                                            </td>
                                            <td style="position: sticky; left: 0; z-index: 1; background:#fff;">
                                                <strong><?php echo $usulan->nama; ?></strong>
                                            </td>
                                            <!-- <td>
                                        <?php echo $usulan->pekerjaan; ?>
                                    </td> -->
                                            <td>
                                                <?php echo $usulan->alamat; ?>
                                            </td>
                                            <!-- <td>
                                        <?php echo $usulan->tujuan; ?>
                                    </td> -->
                                            <td>
                                                <strong><?php echo 'Rp ' . number_format($usulan->nominal, 0, ',', '.'); ?></strong>
                                            </td>
                                            <td>
                                                <?php
                                                $ttd = $usulan->ttd;  // Mendapatkan nama file ttd
                                                $thumbnailURL = './foto/foto_usulan/foto_ttd/' . $ttd;  // Pastikan path file gambar benar

                                                // Cek apakah nama ttd tidak kosong dan file gambar ada
                                                if (!empty($ttd) && file_exists($thumbnailURL)) {
                                                ?>
                                                    <!-- Menampilkan gambar ttd dengan link untuk melihat gambar besar -->
                                                    <a href="javascript:void(0);" onclick="openPopup('<?php echo $thumbnailURL; ?>');">
                                                        <img src="<?php echo $thumbnailURL; ?>" class="gambar" alt="Thumbnail" width="30" loading="lazy">
                                                    </a>
                                                <?php
                                                } else {
                                                    echo '<span style="color:red">N/A</span>';  // Menampilkan pesan jika tidak ada tanda tangan
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($usulan->nominal <= 20000000) {
                                                    echo 'CABANG ' . getKodeKantorText($usulan->kode_kantor); // Keterangan untuk nominal <= 20.000.000
                                                } else {
                                                    echo 'PUSAT'; // Keterangan untuk nominal > 20.000.000
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php echo $usulan->telepon; ?>
                                            </td>
                                            <!-- <td>
                                        <?php echo $usulan->jangka_waktu; ?>
                                    </td> -->
                                            <td>
                                                <?php echo $usulan->jaminan; ?>
                                            </td>
                                            <td>
                                                <?php if ($usulan->status_survey == 1) : ?>
                                                    <a href="<?php echo base_url('users/usulan_survey_edit/' . $usulan->id); ?>" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i> Edit Survey</a>
                                                <?php else : ?>
                                                    <a href="<?php echo base_url('users/usulan_survey/' . $usulan->id); ?>" class="btn btn-danger btn-sm">Survey</a>
                                                    <!-- <a href="<?php echo base_url('users/usulan_hapus/' . $usulan->id); ?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete this proposal?')">Delete</a> -->
                                                <?php endif; ?>
                                                <a href="<?php echo base_url('users/analisa_print/' . $usulan->id); ?>" class="btn btn-primary btn-xs" target="_blank"><i class="fa-solid fa-print"></i></a>
                                                <!-- <a href="<?php echo base_url('users/usulan_edit/' . $usulan->id); ?>" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i></a> -->
                                                <a href="javascript:void(0);" class="btn btn-danger btn-sm" onclick="hapusUsulan(<?php echo $usulan->id; ?>)"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    <?php
                                    endif; // End if untuk kode_kantor filter
                                else :
                                    // Jika level adalah 'surveyor' atau 's_admin', tampilkan semua data tanpa filter kode_kantor
                                    ?>
                                    <tr>
                                        <td style="display: none;">
                                            <?php echo $no++; ?>
                                        </td>
                                        <td>
                                            <strong class="<?php echo ($usulan->status_survey == 1) ? 'text-primary' : ''; ?>">
                                            <?php
                                                    if (!empty($usulan->tgl_cek_bi)) {
                                                        echo date('Ymd', strtotime($usulan->tgl_cek_bi)) . '_PBY' . $usulan->id;
                                                    } else {
                                                        echo 'PBY' . $usulan->id;
                                                    }
                                                    ?>
                                            </strong>
                                        </td>
                                        <td>
                                            <?php echo date('Y-m-d', strtotime($usulan->tanggal)); ?>
                                        </td>
                                        <td style="position: sticky; left: 0; z-index: 1; background:#fff;">
                                            <strong><?php echo $usulan->nama; ?></strong>
                                        </td>
                                        <!-- <td>
                                        <?php echo $usulan->pekerjaan; ?>
                                    </td> -->
                                        <td>
                                            <?php echo $usulan->alamat; ?>
                                        </td>
                                        <!-- <td>
                                        <?php echo $usulan->tujuan; ?>
                                    </td> -->
                                        <td>
                                            <strong><?php echo 'Rp ' . number_format($usulan->nominal, 0, ',', '.'); ?></strong>
                                        </td>
                                        <td>
                                            <?php
                                            $ttd = $usulan->ttd;  // Mendapatkan nama file ttd
                                            $thumbnailURL = './foto/foto_usulan/foto_ttd/' . $ttd;  // Pastikan path file gambar benar

                                            // Cek apakah nama ttd tidak kosong dan file gambar ada
                                            if (!empty($ttd) && file_exists($thumbnailURL)) {
                                            ?>
                                                <!-- Menampilkan gambar ttd dengan link untuk melihat gambar besar -->
                                                <a href="javascript:void(0);" onclick="openPopup('<?php echo $thumbnailURL; ?>');">
                                                    <img src="<?php echo $thumbnailURL; ?>" class="gambar" alt="Thumbnail" width="30" loading="lazy">
                                                </a>
                                            <?php
                                            } else {
                                                echo '<span style="color:red">N/A</span>';  // Menampilkan pesan jika tidak ada tanda tangan
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($usulan->nominal <= 20000000) {
                                                echo 'CABANG ' . getKodeKantorText($usulan->kode_kantor); // Keterangan untuk nominal <= 20.000.000
                                            } else {
                                                echo 'PUSAT'; // Keterangan untuk nominal > 20.000.000
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo $usulan->telepon; ?>
                                        </td>
                                        <!-- <td>
                                        <?php echo $usulan->jangka_waktu; ?>
                                    </td> -->
                                        <td>
                                            <?php echo $usulan->jaminan; ?>
                                        </td>
                                        <td>
                                            <?php if ($usulan->status_survey == 1) : ?>
                                                <a href="<?php echo base_url('users/usulan_survey_edit/' . $usulan->id); ?>" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i> Edit Survey</a>
                                            <?php else : ?>
                                                <a href="<?php echo base_url('users/usulan_survey/' . $usulan->id); ?>" class="btn btn-danger btn-sm">Survey</a>
                                                <!-- <a href="<?php echo base_url('users/usulan_hapus/' . $usulan->id); ?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete this proposal?')">Delete</a> -->
                                            <?php endif; ?>
                                            <a href="<?php echo base_url('users/analisa_print/' . $usulan->id); ?>" class="btn btn-primary btn-xs" target="_blank"><i class="fa-solid fa-print"></i></a>
                                            <!-- <a href="<?php echo base_url('users/usulan_edit/' . $usulan->id); ?>" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i></a> -->
                                            <!-- <a href="javascript:void(0);" class="btn btn-danger btn-sm" onclick="hapusUsulan(<?php echo $usulan->id; ?>)"><i class="fa fa-trash"></i></a> -->
                                            <?php if ($usulan->category === 'SLIK' && in_array($level, ['s_admin', 'kadiv_manrisk', 'k_cabang', 'mng_bisnis', 'surveyor', 'kadiv_opr', 'it'])) : ?>
                                                <a href="<?php echo base_url('users/file_user_lihat_id_pby/' . $usulan->id); ?>" class="btn btn-xs" style="background-color: #6f42c1; color: white;">
                                                    <i class="fa-solid fa-book-open"></i>
                                                </a>
                                                <!-- <a href="<?php echo base_url('users/analisa_download_file/' . $usulan->id); ?>" class="btn btn-warning btn-xs" style="background-color: #e83e8c; color: white;">
                                                <i class="fa fa-download"></i>
                                            </a> -->
                                            <?php else : ?>
                                                <!-- Tidak menampilkan tombol jika level tidak sesuai -->
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                            <?php
                                endif; // End else
                            endforeach; // End foreach loop
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        let isDragging = false;
        let startPositionX;
        let startScrollLeft;

        $("#scrollable-table").on("mousedown", function(event) {
            isDragging = true;
            startPositionX = event.pageX;
            startScrollLeft = $(this).scrollLeft();
        });

        $(document).on("mousemove", function(event) {
            if (isDragging) {
                let deltaX = event.pageX - startPositionX;
                $("#scrollable-table").scrollLeft(startScrollLeft - deltaX);
            }
        });

        $(document).on("mouseup", function() {
            isDragging = false;
        });
    });

    function hapusUsulan(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Usulan yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Lakukan permintaan AJAX untuk menghapus data
                $.ajax({
                    url: '<?php echo base_url('users/usulan_hapus/'); ?>' + id,
                    type: 'POST',
                    success: function(response) {
                        var res = JSON.parse(response);
                        if (res.status === 'success') {
                            Swal.fire(
                                'Terhapus!',
                                res.message,
                                'success'
                            ).then(() => {
                                location.reload(); // Reload halaman setelah konfirmasi penghapusan
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                res.message,
                                'error'
                            );
                        }
                    }
                });
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
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
</style>

<div class="container">
    <div class="content">
        <?php echo $this->session->flashdata('msg'); ?>
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <div class="navigation-buttons">
                        <div class="btn-group">
                            <h5 class="navigation-buttons"><i class="fa-solid fa-clipboard-list"></i> Data Usulan</h5>
                        </div>
                        <div class="btn-group" style="float: right;">
                            <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bars"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <li><a href="users/usulan_laporan"><i class="fa fa-file"></i> Laporan Usulan</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Membersihkan float -->
                    <div class="clearfix"></div>
                    <hr>
                    <a href="users/usulan_tambah" class="btn btn-danger">+ Tambah</a>

                    <form method="get" action="<?= current_url(); ?>" style="float: right;">
                        <div class="row">
                            <div>
                                <select name="usulan_type" id="usulan_type" onchange="this.form.submit()" class="form-control mr-2">
                                    <option value="usulan_saya" <?= ($usulan_type == 'usulan_saya') ? 'selected' : ''; ?>>Usulan Saya</option>
                                    <option value="semua_usulan" <?= ($usulan_type == 'semua_usulan') ? 'selected' : ''; ?>>Semua Usulan</option>
                                </select>
                            </div>
                        </div>
                    </form>

                </div>
                <div id="scrollable-table" class="table-responsive" style="overflow-x: auto;">

                    <table class="table datatable-basic" width="100%">
                        <thead>
                            <tr>
                                <th style="display: none;">No.</th>
                                <th>ID/CekBI</th>
                                <!-- <th>Survey</th> -->
                                <th>Status</th>
                                <th style="position: sticky; left: 0; z-index: 1; background:#fff;">Nama</th>
                                <!-- <th>Pekerjaan</th> -->
                                <th>Alamat</th>
                                <!-- <th>Tujuan Pembiayaan</th> -->
                                <th>Plafon Usulan</th>
                                <th>Wewenang survey</th>
                                <th>No. Telepon</th>
                                <!-- <th>Jangka Waktu</th> -->
                                <th>Tanggal</th>
                                <th>Jaminan</th>
                                <th>Inpuser</th>
                                <th>Aksi</th> <!-- Kolom untuk aksi -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($usulan_data as $usulan) : ?>
                                <tr>
                                    <td style="display: none;">
                                        <?php echo $no++; ?>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <strong><?php
                                                if (!empty($usulan->tgl_cek_bi)) {
                                                    echo date('Ymd', strtotime($usulan->tgl_cek_bi)) . '_PBY' . $usulan->id;
                                                } else {
                                                    echo 'PBY' . $usulan->id;
                                                }
                                                ?></strong><br>
                                        <?php
                                        if ($usulan->cek_req == 1 && empty($usulan->tgl_cek_bi)) {
                                            echo '<i class="text-warning" style="font-size: 1rem;">Request</i>';
                                        } elseif ($usulan->cek_req == 1 && !empty($usulan->tgl_cek_bi)) {
                                            echo '<i class="text-success" style="font-size: 1rem;">Checked</i>';
                                        } else {
                                            echo '<i class="text-muted" style="font-size: 1rem;">N/A</i>';
                                        }
                                        ?>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <?php if (!empty($usulan->status)) : ?>
                                            <?php if ($usulan->status == 'Batal') : ?>
                                                <div style="color: red;">
                                                    <i class="fa fa-times-circle"></i><br> Batal
                                                </div>
                                            <?php elseif ($usulan->status == 'Nonaktif') : ?>
                                                <div style="color: grey;">
                                                    <i class="fa fa-exclamation-circle"></i><br> Nonaktif
                                                </div>
                                            <?php elseif ($usulan->status == 'Aktif') : ?>
                                                <div>
                                                    <?php
                                                    // Tentukan status berdasarkan status survei, analisa, dan komite
                                                    if ($usulan->status_survey == 0) {
                                                        $status_icon = '<i class="fa fa-clock" style="color: #808080;" title="Menunggu Survei"></i>';
                                                        $status_text = '<span style="color: #808080;">Menunggu Survei</span>';
                                                    } elseif ($usulan->status_survey == 1 && $usulan->status_analisa == 0) {
                                                        $status_icon = '<i class="fa fa-clock" style="color: orange;" title="Menunggu Analisa"></i>';
                                                        $status_text = '<span style="color: orange;">Menunggu Analisa</span>';
                                                    } elseif ($usulan->status_survey == 1 && $usulan->status_analisa == 1) {
                                                        // Setelah analisa, periksa status komite
                                                        if ($usulan->status_komite == 1) {
                                                            $status_icon = '<i class="fa fa-check-circle" style="color: green;" title="Acc"></i>';
                                                            $status_text = '<span style="color: green;">Acc</span>';
                                                        } elseif ($usulan->status_komite == 2) {
                                                            $status_icon = '<i class="fa fa-edit" style="color: #00bcd4;" title="Revisi"></i>';
                                                            $status_text = '<span style="color: #00bcd4;">Revisi</span>';
                                                        } elseif ($usulan->status_komite == 3) {
                                                            $status_icon = '<i class="fa fa-times-circle" style="color: red;" title="Ditolak"></i>';
                                                            $status_text = '<span style="color: red;">Ditolak</span>';
                                                        } else {
                                                            // Jika belum ada keputusan komite, status menunggu komite
                                                            $status_icon = '<i class="fa fa-clock" style="color: #007bff;" title="Menunggu Komite"></i>';
                                                            $status_text = '<span style="color: #007bff;">Menunggu Komite</span>';
                                                        }
                                                    } else {
                                                        $status_icon = '<i class="fa-solid fa-question-circle" style="color: gray;" title="Tidak Ada Status"></i>';
                                                        $status_text = '<span style="color: gray;">N/A</span>';
                                                    }
                                                    ?>
                                                    <!-- Tampilkan tracking status -->
                                                    <div>
                                                        <?= $status_icon; ?><br>
                                                        <?= $status_text; ?>
                                                    </div>
                                                    <!-- Tampilkan keterangan jika ada -->
                                                    <?php if (!empty($usulan->keterangan)) : ?>
                                                        <div style="color: red;">
                                                            <i class="fa fa-times-circle"></i><br>
                                                            <?= nl2br(htmlspecialchars($usulan->keterangan)); ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                    <!-- <td>
                                        <?php echo date('Y-m-d', strtotime($usulan->tanggal)); ?>
                                    </td> -->
                                    <td style="position: sticky; left: 0; z-index: 1; background:#fff;">
                                        <strong><?php echo $usulan->nama; ?></strong>
                                    </td>
                                    <!-- <td>
                                        <?php echo $usulan->pekerjaan; ?>
                                    </td> -->
                                    <td>
                                        <?php echo $usulan->alamat; ?> <?php echo $usulan->kelurahan_nama; ?> <?php echo $usulan->kecamatan_nama; ?> <?php echo $usulan->kota_nama; ?>
                                    </td>
                                    <!-- <td>
                                        <?php echo $usulan->tujuan; ?>
                                    </td> -->
                                    <td>
                                        <strong><?php echo 'Rp ' . number_format($usulan->nominal, 0, ',', '.'); ?></strong>
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
                                        <?php echo date('Y-m-d', strtotime($usulan->tanggal)); ?>
                                    </td>
                                    <td>
                                        <?php echo $usulan->jaminan; ?>
                                    </td>
                                    <td>
                                        <?php echo $this->Usulan_model->getUsernameById($usulan->id_user); ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo base_url('users/usulan_detail/' . $usulan->id); ?>" class="btn btn-success btn-xs" style="margin: 1px;"><i class="fa fa-eye"></i></a>
                                        <a href="<?php echo base_url('users/usulan_edit/' . $usulan->id); ?>" class="btn btn-info btn-xs" style="margin: 1px;"><i class="fa fa-pencil"></i></a>
                                        <a href="<?php echo base_url('users/analisa_print/' . $usulan->id); ?>" class="btn btn-primary btn-xs" target="_blank" style="margin: 1px;"><i class="fa-solid fa-print"></i></a>
                                        <!-- <a href="<?php echo site_url('users/file_user_id_pby_upload/' . $usulan->id); ?>" class="btn btn-light btn-xs" style="background-color: #6c757d; color: white;"><i class="fa fa-upload" aria-hidden="true"></i></a> -->
                                        <?php if ($usulan->category === 'SLIK' && in_array($level, ['s_admin', 'kadiv_manrisk', 'k_cabang', 'mng_bisnis', 'surveyor', 'kadiv_opr', 'audit', 'it'])) : ?>
                                            <a href="<?php echo base_url('users/file_user_lihat_id_pby/' . $usulan->id); ?>" class="btn btn-xs" style="background-color: #6f42c1; color: white;">
                                                <i class="fa-solid fa-book-open"></i>
                                            </a>
                                            <!-- <a href="<?php echo base_url('users/analisa_download_file/' . $usulan->id); ?>" class="btn btn-warning btn-xs" style="background-color: #e83e8c; color: white;">
                                                <i class="fa fa-download"></i>
                                            </a> -->
                                        <?php else : ?>
                                            <!-- Tidak menampilkan tombol jika level tidak sesuai -->
                                        <?php endif; ?>
                                        <?php if ($level === 's_admin') : ?>
                                            <a href="javascript:void(0);" class="btn btn-danger btn-sm" onclick="hapusUsulan(<?php echo $usulan->id; ?>)"><i class="fa fa-trash"></i></a>
                                        <?php endif; ?>
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
</script>
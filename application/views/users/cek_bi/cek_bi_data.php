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
                        <i class="fa-solid fa-clipboard-list"></i> Data BI Cheking
                    </div>
                    <!-- Membersihkan float -->
                    <div class="clearfix"></div>
                    <hr>
                    <a href="users/cek_bi_tambah" class="btn btn-danger">+ Tambah</a>
                </div>
                <div id="scrollable-table" class="table-responsive" style="overflow-x: auto;">

                    <table class="table datatable-basic" width="100%">
                        <thead>
                            <tr>
                                <th style="display: none;">No.</th>
                                <th>ID</th>
                                <th style="position: sticky; left: 0; z-index: 1; background:#fff;">Nama</th>
                                <th>Alamat</th>
                                <th>No. Telepon</th>
                                <th>Ttd</th>
                                <th>Slik</th>
                                <th>Tanggal</th>
                                <th>Inpuser</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($cek_bi_data as $cek_bi) : ?>
                                <tr>
                                    <td style="display: none;">
                                        <?php echo $no++; ?>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <strong><?php
                                                if (!empty($cek_bi->tgl_cek_bi)) {
                                                    echo date('Ymd', strtotime($cek_bi->tgl_cek_bi)) . '_MLT' . $cek_bi->id;
                                                } else {
                                                    echo 'MLT' . $cek_bi->id;
                                                }
                                                ?></strong><br>
                                        <?php
                                        if ($cek_bi->cek_req == 1 && empty($cek_bi->tgl_cek_bi)) {
                                            echo '<i class="text-warning" style="font-size: 1rem;">Request</i>';
                                        } elseif ($cek_bi->cek_req == 1 && !empty($cek_bi->tgl_cek_bi)) {
                                            echo '<i class="text-success" style="font-size: 1rem;">Checked</i>';
                                        } else {
                                            echo '<i class="text-muted" style="font-size: 1rem;">N/A</i>';
                                        }
                                        ?>
                                    </td>
                                    <!-- <td>
                                        <?php echo date('Y-m-d', strtotime($cek_bi->tanggal)); ?>
                                    </td> -->
                                    <td style="position: sticky; left: 0; z-index: 1; background:#fff;">
                                        <strong><?php echo $cek_bi->nama; ?></strong>
                                    </td>
                                    <!-- <td>
                                        <?php echo $cek_bi->pekerjaan; ?>
                                    </td> -->
                                    <td>
                                        <?php echo $cek_bi->alamat; ?> <?php echo $cek_bi->kelurahan_nama; ?> <?php echo $cek_bi->kecamatan_nama; ?> <?php echo $cek_bi->kota_nama; ?>
                                    </td>
                                    <!-- <td>
                                        <?php echo $cek_bi->tujuan; ?>
                                    </td> -->
                                    <td>
                                        <?php echo $cek_bi->telepon; ?>
                                    </td>
                                    <td>
                                        <?php
                                        $ttd = $cek_bi->ttd;  // Mendapatkan nama file ttd
                                        $thumbnailURL = './foto/foto_cek_bi/foto_ttd/' . $ttd;  // Pastikan path file gambar benar

                                        // Cek apakah nama ttd tidak kosong dan file gambar ada
                                        if (!empty($ttd) && file_exists($thumbnailURL)) {
                                        ?>
                                            <!-- Menampilkan gambar ttd dengan link untuk melihat gambar besar -->
                                            <a href="javascript:void(0);" onclick="openPopup('<?php echo $thumbnailURL; ?>');">
                                                <img src="<?php echo $thumbnailURL; ?>" class="gambar" alt="Thumbnail" width="30" loading="lazy">
                                            </a>
                                        <?php
                                        } else {
                                            echo '<span style="color:grey"><i class="fa fa-times-circle"></i></span>';  // Menampilkan pesan jika tidak ada tanda tangan
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        // Cek jika ada data untuk id_pby terkait
                                        if (!empty($cek_bi->id)) :
                                            // Misalkan kita cek apakah ada file terkait id_pby di tbl_file_user
                                            $this->db->where('id_mlt', $cek_bi->id);
                                            $query = $this->db->get('tbl_file_user');

                                            // Jika ada data (baris) yang ditemukan
                                            if ($query->num_rows() > 0) :
                                        ?>
                                                <span style="display:none;">1</span>
                                                <span style="color: green;"><i class="fa fa-check-circle"></i></span> <!-- Tanda centang jika ada data -->
                                            <?php else : ?>
                                                <span style="display:none;">0</span>
                                                <span style="color: grey;"><i class="fa fa-times-circle"></i></span> <!-- Tanda silang jika tidak ada data -->
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php echo date('Y-m-d', strtotime($cek_bi->tanggal)); ?>
                                    </td>
                                    <td>
                                        <?php echo $this->Cek_bi_model->getUsernameById($cek_bi->id_user); ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo base_url('users/cek_bi_detail/' . $cek_bi->id); ?>" class="btn btn-success btn-xs" style="margin: 1px;"><i class="fa fa-eye"></i></a>
                                        <?php if (in_array($level, ['s_admin', 'it'])) : ?>
                                            <a href="<?php echo base_url('users/cek_bi_edit_status/' . $cek_bi->id); ?>" class="btn btn-warning btn-xs" style="margin: 1px;"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <?php endif; ?>
                                        <a href="<?php echo base_url('users/cek_bi_edit/' . $cek_bi->id); ?>" class="btn btn-info btn-xs" style="margin: 1px;"><i class="fa fa-pencil"></i></a>
                                        <a href="<?php echo base_url('users/cek_bi_print/' . $cek_bi->id); ?>" class="btn btn-primary btn-xs" target="_blank" style="margin: 1px;"><i class="fa-solid fa-print"></i></a>
                                        <?php if (in_array($level, ['s_admin', 'it'])) : ?>
                                            <a href="<?php echo site_url('users/cek_bi_upload/' . $cek_bi->id); ?>" class="btn btn-light btn-xs" style="background-color: #6c757d; color: white;">
                                                <i class="fa fa-upload" aria-hidden="true"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if ($cek_bi->category === 'SLIK_MLT') : ?>
                                            <a href="<?php echo base_url('users/file_user_lihat_id_mlt/' . $cek_bi->id); ?>" class="btn btn-xs" style="background-color: #6f42c1; color: white;">
                                                <i class="fa-solid fa-book-open"></i>
                                            </a>
                                        <?php else : ?>
                                            <!-- Tidak menampilkan tombol jika level tidak sesuai -->
                                        <?php endif; ?>
                                        <?php if (in_array($level, ['s_admin'])) : ?>
                                            <a href="javascript:void(0);" class="btn btn-danger btn-sm" onclick="hapusCekBi(<?php echo $cek_bi->id; ?>)"><i class="fa fa-trash"></i></a>
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

    function hapusCekBi(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data BI Checking yang dihapus tidak dapat dikembalikan!",
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
                    url: '<?php echo base_url('users/cek_bi_hapus/'); ?>' + id,
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
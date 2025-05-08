<!-- Main content -->
<div class="container">
    <!-- Content area -->
    <div class="content">
        <?php echo $this->session->flashdata('msg'); ?>

        <!-- Daftar Data Blokir -->
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <div class="navigation-buttons">
                        <i class="fa fa-unlock-alt"></i> Data Proses Blokir
                        <div class="btn-group" style="float: right;">
                            <!-- Tombol Dropdown (di pojok kanan atas) -->
                            <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bars"></i>
                            </button>
                            <!-- Isi Dropdown -->
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <li><a href="<?php echo site_url('users/blokir'); ?>"><i class="fa fa-plus"></i> Tambah Data Blokir</a></li>
                                <li><a href="<?php echo site_url('users/data_blokir'); ?>"><i class="fa fa-unlock-alt"></i> Data Proses Blokir</a></li>
                                <li><a href="<?php echo site_url('users/data_blokir_selesai'); ?>"><i class="fa fa-lock"></i> Data Selesai Blokir</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Membersihkan float -->
                    <div class="clearfix"></div>
                    <a href="<?php echo site_url('users/blokir'); ?>" class="btn btn-danger">+ Tambah Blokir</a>
                </div>
                <div class="table-responsive">
                    <table class="table datatable-basic" width="100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Tgl Effektif</th>
                                <th>Nama Anggota</th>
                                <th>No. Rekening</th>
                                <th>Nominal Blokir</th>
                                <th>Keterangan</th>
                                <th>No.Blokir</th>
                                <th>Petugas</th>
                                <th>Kantor</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($blokir as $blokir_item) : ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td>
                                        <?php echo date('Y-m-d', strtotime($blokir_item['tanggal'])); ?>
                                    </td>
                                    <td>
                                        <b><?php echo $blokir_item['nama']; ?></b>
                                    </td>
                                    <td>
                                        <?php echo $blokir_item['no_rek']; ?>
                                    </td>
                                    <td>
                                        <b>Rp <?php echo number_format($blokir_item['jumlah'], 0, ',', '.'); ?></b>
                                    </td>
                                    <td>
                                        <?php echo htmlspecialchars_decode(substr(strip_tags($blokir_item['keterangan']), 0, 25)); ?>...
                                    </td>
                                    <td>
                                        <?php echo $blokir_item['nomor_blokir']; ?>
                                    </td>
                                    <td>
                                        <?php echo $blokir_item['petugas']; ?>
                                    </td>
                                    <td><?php echo $kodeKantorText = getKodeKantorText($blokir_item['kantor']); ?></td>

                                    <td style="color: <?php echo ($blokir_item['status'] == 'done') ? 'green' : 'red'; ?>;">
                                        <?php echo $blokir_item['status']; ?>
                                    </td>


                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" onclick="editBlokir(<?php echo $blokir_item['id']; ?>)">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" onclick="hapusBlokir(<?php echo $blokir_item['id']; ?>)">
                                            <i class="fa fa-trash"></i>
                                        </button>
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    $(document).ready(function() {
        // Open modal when an image is clicked
        $('.open-modal').click(function() {
            var imageSrc = $(this).data('image');
            $('#modalImage').attr('src', imageSrc);
        });
    });

    function hapusBlokir(id) {
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: 'Apakah Anda yakin ingin menghapus data blokir ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect ke controller hapus_blokir
                window.location.href = "<?php echo site_url('users/hapus_blokir/'); ?>" + id;
            }
        });
    }

    function editBlokir(id) {
        // Redirect ke controller edit_blokir
        window.location.href = "<?php echo site_url('users/edit_blokir/'); ?>" + id;
    }
</script>

<!-- /main content -->
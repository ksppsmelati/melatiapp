<?php
$cek = $user->row(); //  mengambil nilai data dari tabel tbl_user 
$id_user = $cek->id_user;
?>
<style>
    .catatan-title {
        word-wrap: break-word;
        max-width: 200px;
        /* Adjust as needed */
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
<!-- Main content -->
<div class="container">
    <!-- Content area -->
    <div class="content">
        <?php
        echo $this->session->flashdata('msg');
        ?>
            <!-- Dashboard content -->
            <div class="row">
                <!-- Basic datatable -->
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h5 class="panel-title"><i class="fa fa-sticky-note"></i> Catatan Pribadi</h5>
                        <?php
                        echo '<br>';
                        echo '<a href="users/catatan/t" class="btn btn-danger">+ Tambah</a>';
                        ?>

                    </div>
                    <div class="table-responsive">
                        <table class="table datatable-basic" width="100%">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($catatan)) : ?>
                                    <?php foreach ($catatan as $baris) : ?>
                                        <tr>
                                            <td class="catatan-title" data-toggle="tooltip" data-placement="top" title="<?php echo $baris->judul_catatan; ?>">
                                                <a href="<?php echo site_url('users/catatan/lihat/' . $baris->id_catatan); ?>">
                                                    <b><?php echo $baris->judul_catatan; ?></b>
                                                </a>
                                            </td>
                                            <td><?php echo date('d-m-Y', strtotime($baris->tanggal)); ?></td>
                                            <td>
                                                <a href="<?php echo site_url('users/catatan/e/' . $baris->id_catatan); ?>" class="btn btn-success btn-xs"><i class="icon-pencil7"></i></a>
                                                <a href="#" class="btn btn-danger btn-xs delete-catatan" data-id="<?php echo $baris->id_catatan; ?>"><i class="icon-trash"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    
                                <?php endif; ?>
                            </tbody>
                        </table>

                    </div>

                </div>
                <!-- /basic datatable -->
            </div>
            <!-- /dashboard content -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script>
            $(document).ready(function() {
                // Get the table body
                var tbody = $('table.datatable-basic tbody');

                // Get all the rows inside the tbody
                var rows = tbody.find('tr').toArray();

                // Sort the rows based on the date column (index 1)
                rows.sort(function(a, b) {
                    var dateA = new Date($(a).find('td:eq(1)').text());
                    var dateB = new Date($(b).find('td:eq(1)').text());

                    return dateB - dateA;
                });

                // Append the sorted rows back to the table
                tbody.empty().append(rows);
            });
            $(document).ready(function() {
                // Handle SweetAlert for delete action
                $('.delete-catatan').on('click', function(e) {
                    e.preventDefault();
                    var catatanId = $(this).data('id');

                    Swal.fire({
                        title: 'Konfirmasi Hapus ?',
                        text: 'Anda yakin ingin menghapus catatan!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Redirect to the delete URL or perform AJAX delete
                            window.location.href = 'users/catatan/h/' + catatanId;
                        }
                    });
                });
            });
        </script>
<?php
// Memuat data pengguna
$cek = $user->row(); // Mengambil nilai data dari tabel tbl_user 
$id_user = $cek->id_user;
?>
<style>
    .setting-title {
        word-wrap: break-word;
        max-width: 200px;
        /* Adjust as needed */
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .truncate {
        white-space: nowrap; /* Mencegah teks membungkus ke baris baru */
        overflow: hidden;    /* Menyembunyikan teks yang melampaui batas */
        text-overflow: ellipsis; /* Menambahkan '...' di akhir teks yang terpotong */
        max-width: 200px;    /* Atur lebar maksimum sesuai kebutuhan */
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
                    <h5 class="panel-title"><i class="fa fa-cog"></i> Setting Aplikasi</h5>
                </div>
                <div class="table-responsive">
                    <table class="table datatable-basic" width="100%">
                        <thead>
                            <tr>
                                <th>Key</th>
                                <th>Value</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($settings)) : ?>
                                <?php foreach ($settings as $setting) : ?>
                                    <tr>
                                        <td class="setting-title" data-toggle="tooltip" data-placement="top" title="<?php echo $setting->key; ?>">
                                            <a href="<?php echo site_url('users/setting_edit/' . $setting->key); ?>">
                                                <b><?php echo $setting->key; ?></b>
                                            </a>
                                        </td>
                                        <td class="truncate"><?php echo $setting->value; ?></td>
                                        <td>
                                            <a href="<?php echo site_url('users/setting_edit/' . $setting->key); ?>" class="btn btn-success btn-xs"><i class="icon-pencil7"></i></a>
                                            <a href="#" class="btn btn-danger btn-xs delete-setting" data-key="<?php echo $setting->key; ?>"><i class="icon-trash"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="3" class="text-center">Tidak ada pengaturan ditemukan.</td>
                                </tr>
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

                // Sort the rows based on the value column (index 1) if needed
                // Uncomment and modify this section if you need to sort by a specific column
                /*
                rows.sort(function(a, b) {
                    var valueA = $(a).find('td:eq(1)').text();
                    var valueB = $(b).find('td:eq(1)').text();
                    return valueA.localeCompare(valueB);
                });
                */

                // Append the sorted rows back to the table
                tbody.empty().append(rows);
            });

            $(document).ready(function() {
                // Handle SweetAlert for delete action
                $('.delete-setting').on('click', function(e) {
                    e.preventDefault();
                    var settingKey = $(this).data('key');

                    Swal.fire({
                        title: 'Konfirmasi Hapus ?',
                        text: 'Anda yakin ingin menghapus pengaturan ini!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Redirect to the delete URL or perform AJAX delete
                            window.location.href = 'users/setting/setting_delete/' + settingKey;
                        }
                    });
                });
            });
        </script>

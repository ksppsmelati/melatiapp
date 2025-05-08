<?php
$cek = $user->row();
$id_user = $cek->id_user;
?>

<div class="container">
    <div class="content">
        <?php
        echo $this->session->flashdata('msg');
        ?>
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h5 class="panel-title"><i class="fa-solid fa-icons"></i> Menu Icon</h5>
                    <?php
                    echo '<br>';
                    echo '<a href="' . site_url('users/menu_setting_tambah') . '" class="btn btn-danger">+ Tambah</a>';
                    ?>
                </div>
                <div class="table-responsive">
                    <table class="table datatable-basic" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Menu</th>
                                <th>Icon</th>
                                <th>URL</th>
                                <th>Kategori</th>
                                <th>Fungsi</th>
                                <th>Access Level</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($menu_setting)) : ?>
                                <?php foreach ($menu_setting as $menu) : ?>
                                    <tr>
                                        <td><?php echo $menu->id_menu; ?></td>
                                        <td style="text-align: center; vertical-align: middle;">
                                            <i class="<?php echo $menu->icon; ?>"></i><br>
                                            <?php echo $menu->menu_name; ?>
                                        </td>
                                        <td><?php echo $menu->icon; ?></td>
                                        <td><a href="<?php echo $menu->url; ?>" target="_blank"><?php echo $menu->url; ?></a></td>
                                        <td><?php echo $menu->category; ?></td>
                                        <td><?php echo $menu->fungsi; ?></td>
                                        <td><?php echo $menu->access_level; ?></td>
                                        <td>
                                            <a href="<?php echo site_url('users/menu_setting_edit/' . $menu->id_menu); ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                                            <a href="javascript:void(0);" onclick="confirmDelete('<?php echo site_url('users/menu_setting_hapus/' . $menu->id_menu); ?>')" class="btn btn-danger"><i class="fa fa-trash"></i></a>
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

<!-- SweetAlert2 untuk konfirmasi penghapusan -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    function confirmDelete(deleteUrl) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = deleteUrl;
            }
        });
    }
</script>
<div class="container">
    <div class="content">
        <?php echo $this->session->flashdata('msg'); ?>
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <h5 class="panel-title"><i class="fa fa-plane"></i> Menu User Access</h5>

                    <div class="clearfix"></div>
                    <hr>
                    <a href="<?php echo site_url('users/menu_access_tambah'); ?>" class="btn btn-danger">+ Tambah</a>
                    <form method="get" action="<?php echo site_url('users/menu_access_data'); ?>" style="float: right;">
                        <div class="form-row xs-3">
                                <select class="form-control select2" name="id_user" id="id_user" required onchange="this.form.submit()">
                                    <option value="" disabled selected>Filter Nama</option>
                                    <?php
                                    // Ambil semua pengguna dari tabel tbl_user
                                    $users = $this->db->get('tbl_user')->result();
                                    foreach ($users as $user) {
                                        // Cek jika id_user sudah dipilih
                                        $selected = (isset($_GET['id_user']) && $_GET['id_user'] == $user->id_user) ? 'selected' : '';
                                        echo "<option value='{$user->id_user}' {$selected}>{$user->nama_lengkap}</option>";
                                    }
                                    ?>
                                </select>
                        </div>
                    </form>
                </div>
                <div class="table-responsive">
                    <table class="table datatable-basic" width="100%">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Level</th>
                                <th>Menu</th>
                                <th>Access</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($menu_access)) : ?>
                                <?php foreach ($menu_access as $menu) : ?>
                                    <tr>
                                        <td><?php echo $menu->nama_lengkap; ?></td>
                                        <td><?php echo $levelText = getLevelText($menu->level); ?></td>
                                        <td style="text-align: center;">
                                            <i class="<?php echo $menu->icon; ?>"></i><br>
                                            <?php echo $menu->menu_name; ?>
                                        </td>
                                        <td>
                                            <?php if ($menu->has_access == 1) : ?>
                                                <button class="btn btn-success btn-sm">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                            <?php else : ?>
                                                <button class="btn btn-danger btn-sm">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo site_url('users/menu_access_edit/' . $menu->id_access); ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                                            <a href="javascript:void(0);" onclick="confirmDelete('<?php echo site_url('users/menu_access_hapus/' . $menu->id_access); ?>')" class="btn btn-danger"><i class="fa fa-trash"></i></a>
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

    $(document).ready(function() {
        $('#id_user').select2({
            placeholder: "Filter Nama",
            allowClear: true
        });
    });
</script>
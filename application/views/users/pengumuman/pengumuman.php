<style>
    .memo-title {
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
                    <h5 class="panel-title"><i class="fa fa-bullhorn"></i> Pengumuman</h5>

                    <?php
                    $allowedLevels = ['kabag_hrd', 's_admin'];

                    if (in_array($user->row()->level, $allowedLevels)) {
                        echo '<br>';
                        echo '<a href="users/pengumuman/t" class="btn btn-danger">+ <i class="fa fa-bullhorn"></i></a>';
                    }
                    ?>

                </div>
                <div class="table-responsive">
                    <table class="table datatable-basic" width="100%">
                        <thead>
                            <tr>
                                <th width="30px;">No.</th>
                                <th>Judul</th>
                                <th>Tanggal</th>
                                <th>Pengumuman</th>
                                <th>Aksi</th>
                                <?php
                                if ($user->row()->level == 'admin') { ?>
                                    <th class="text-center" width="170"></th>
                                <?php
                                } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            if ($pengumuman && $pengumuman->num_rows() > 0) { // Periksa apakah ada pengumuman dan jumlah baris lebih dari 0
                                foreach ($pengumuman->result() as $baris) {
                            ?>
                                    <tr>
                                        <td><?php echo $no; ?></td>
                                        <td class="pengumuman-title" data-toggle="tooltip" data-placement="top" title="<?php echo $baris->judul_pengumuman; ?>">
                                            <a href="users/pengumuman/lihat/<?php echo $baris->id_pengumuman; ?>">
                                                <?php echo $baris->judul_pengumuman; ?>
                                            </a>
                                        </td>
                                        <td>
                                            <?php echo date('d-m-Y', strtotime($baris->tanggal)); ?>
                                        </td>
                                        <td class="isi_pengumuman" data-toggle="tooltip" data-placement="top" title="<?php echo strip_tags($baris->isi_pengumuman); ?>">
                                            <a href="users/pengumuman/lihat/<?php echo $baris->id_pengumuman; ?>">
                                                <?php
                                                $trimmedText = mb_strimwidth(strip_tags($baris->isi_pengumuman), 0, 200, '...');
                                                echo $trimmedText;
                                                ?>
                                            </a>
                                        </td>
                                        <td>
                                            <?php if (in_array($user->row()->level, $allowedLevels)) { ?>
                                                <a href="users/pengumuman/lihat/<?php echo $baris->id_pengumuman; ?>" class="btn btn-info btn-xs"><i class="icon-eye"></i></a>
                                                <a href="users/pengumuman/e/<?php echo $baris->id_pengumuman; ?>" class="btn btn-success btn-xs"><i class="icon-pencil7"></i></a>
                                                <a href="users/pengumuman/h/<?php echo $baris->id_pengumuman; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Apakah Anda yakin?')"><i class="icon-trash"></i></a>
                                            <?php } else { ?>
                                                <a href="users/pengumuman/lihat/<?php echo $baris->id_pengumuman; ?>" class="btn btn-info btn-xs"><i class="icon-eye"></i></a>
                                            <?php } ?>
                                        </td>
                                    </tr>

                                <?php
                                    $no++;
                                }
                            } else {
                                // Tampilkan pesan jika tidak ada pengumuman
                                ?>
                                <tr style="text-align: center;">
                                    <td colspan="4">Tidak ada pengumuman yang tersedia.</td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>
            <!-- /basic datatable -->
        </div>
        <!-- /dashboard content -->
    </div>
</div>

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
</script>
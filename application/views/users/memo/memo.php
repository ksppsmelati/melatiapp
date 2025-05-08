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
                    <h5 class="panel-title"><i class="fa fa-info-circle"></i> Informasi</h5>

                    <?php
                    $allowedLevels = ['k_hrd', 's_admin', 'kadiv_manrisk'];

                    if (in_array($user->row()->level, $allowedLevels)) {
                        echo '<br>';
                        echo '<a href="users/memo/t" class="btn btn-danger">+ <i class="icon-file-text2"></i></a>';
                    }
                    ?>

                </div>
                <div class="table-responsive">
                    <table class="table datatable-basic" width="100%">
                        <thead>
                            <tr>
                                <th> </th>
                                <th> </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($memo && $memo->num_rows() > 0) { // Periksa apakah ada memo dan jumlah baris lebih dari 0
                                foreach ($memo->result() as $baris) {
                            ?>
                                    <tr>
                                        <td class="memo-title" data-toggle="tooltip" data-placement="top" title="<?php echo $baris->judul_memo; ?>">
                                            <a href="users/memo/lihat/<?php echo $baris->id_memo; ?>">
                                                <b>
                                                    <?php echo $baris->judul_memo; ?><br>
                                                    <span style="font-size: 12px; color:lightslategray">[ <?php echo $baris->tanggal; ?> ]</span>
                                                </b>
                                            </a>

                                        <td>
                                            <a href="users/memo/lihat/<?php echo $baris->id_memo; ?>" class="btn btn-primary btn-xs"><i class="icon-eye"></i></a>
                                            <?php if (in_array($user->row()->level, $allowedLevels)) { ?>
                                                <a href="users/memo/e/<?php echo $baris->id_memo; ?>" class="btn btn-success btn-xs"><i class="icon-pencil7"></i></a>
                                                <a href="users/memo/h/<?php echo $baris->id_memo; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Apakah Anda yakin?')"><i class="icon-trash"></i></a>
                                            <?php } ?>
                                        </td>

                                    </tr>
                                <?php
                                }
                            } else {
                                ?>
                                <!-- kosong -->
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
<div class="container">
    <div class="content">
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <div class="navigation-buttons">
                        <div class="btn-group" style="float: left;">
                            <i class="fa-solid fa-sack-dollar"></i> Riwayat Saldo - <?php echo $notab; ?>
                        </div>
                        <div class="btn-group" style="float: right;">
                            <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bars"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <li><a href="<?php echo site_url('users/saldo_data'); ?>"><i class="fa-solid fa-sack-dollar"></i> Simpanan</a></li>
                                <li><a href="<?php echo site_url('users/pembiayaan_data'); ?>"><i class="fa-solid fa-hand-holding-dollar"></i> Pembiayaan</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                    <div class="row">
                        <form method="POST" action="<?php echo site_url('users/saldo_data_riwayat/' . $notab); ?>">
                            <div class="col-xs-4">
                                <input type="date" class="form-control" name="start_date" value="<?php echo date('Y-m-d', strtotime($start_date)); ?>" required>
                            </div>
                            <div class="col-xs-4">
                                <input type="date" class="form-control" name="end_date" value="<?php echo date('Y-m-d', strtotime($end_date)); ?>" required>
                            </div>
                            <div class="col-xs-2">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                </div>

                <fieldset class="content-group">
                    <div class="table-responsive">
                        <table class="table datatable-basic" width="100%">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Keterangan</th>
                                    <th>MUTASI-DR</th>
                                    <th>MUTASI-CR</th>
                                    <!-- <th>SALDO-AKHIR</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;  // Initialize counter
                                foreach ($history as $data) : ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo date('d-m-Y', strtotime($data['tgltrn'])); ?></td>
                                        <td><?php echo $data['ket']; ?></td>

                                        <!-- Kolom Debit -->
                                        <td>
                                            <?php if ($data['dc'] == 'D') : ?>
                                                <span class="text-danger"><?php echo 'Rp ' . number_format($data['nominal'], 0, ',', '.'); ?></span>
                                            <?php else : ?>
                                                -
                                            <?php endif; ?>
                                        </td>

                                        <!-- Kolom Kredit -->
                                        <td>
                                            <?php if ($data['dc'] == 'C') : ?>
                                                <span class="text-success"><?php echo 'Rp ' . number_format($data['nominal'], 0, ',', '.'); ?></span>
                                            <?php else : ?>
                                                -
                                            <?php endif; ?>
                                        </td>

                                        <!-- Kolom Saldo Akhir -->
                                        <!-- <td><?php echo 'Rp ' . number_format($data['saldo_akhir'], 0, ',', '.'); ?></td> -->
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </fieldset>


            </div>
        </div>
    </div>
</div>

<style>
    .text-success {
        color: #28a745;
        /* Green for credits */
    }

    .text-danger {
        color: #dc3545;
        /* Red for debits */
    }

    .list-unstyled {
        padding-left: 0;
    }
</style>
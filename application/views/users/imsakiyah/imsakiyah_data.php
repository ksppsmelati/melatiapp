<?php
$cek = $user->row();
$level = $cek->level;
$id_user = $cek->id_user;
$nama_lengkap = $cek->nama_lengkap;

// Mendapatkan tanggal hari ini
$today = date('Y-m-d');
?>
<div class="container">
    <div class="content">
        <?php echo $this->session->flashdata('msg'); ?>
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <div class="navigation-buttons">
                        <div class="btn-group" style="float: left;">
                            <i class="fa-solid fa-calendar"></i> Jadwal Imsakiyah Ramadhan 1446 H / <?php echo date('Y'); ?> M<p>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table datatable-basic table-striped" width="100%">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Imsak</th>
                                <th>Subuh</th>
                                <th>Zuhur</th>
                                <th>Ashar</th>
                                <th>Maghrib</th>
                                <th>Isya</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($imsakiyah)) : ?>
                                <?php foreach ($imsakiyah as $data) : ?>
                                    <?php
                                    // Cek apakah tanggal saat ini adalah tanggal hari ini
                                    $is_today = (date('Y-m-d', strtotime($data->tanggal)) == $today);
                                    ?>
                                    <tr <?php echo $is_today ? 'style="font-weight: bold; color: #16a085;"' : ''; ?>>
                                        <td>
                                            <?php echo date('d M Y', strtotime($data->tanggal)); ?>
                                        </td>
                                        <td><?php echo $data->imsak; ?></td>
                                        <td><?php echo $data->subuh; ?></td>
                                        <td><?php echo $data->zuhur; ?></td>
                                        <td><?php echo $data->ashar; ?></td>
                                        <td><?php echo $data->maghrib; ?></td>
                                        <td><?php echo $data->isya; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="7" class="text-center">Jadwal Imsakiyah tidak tersedia.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

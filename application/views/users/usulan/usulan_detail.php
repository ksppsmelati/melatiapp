<?php
// Tentukan status berdasarkan status survei, analisa, dan komite
if ($usulan_detail->status_survey == 0) {
    $status_badge = '<span class="badge" style="background-color: #808080; color: white;" title="Belum Survei"><i class="fa fa-clock"></i> Menunggu Survei</span>';
} elseif ($usulan_detail->status_survey == 1 && $usulan_detail->status_analisa == 0) {
    $status_badge = '<span class="badge badge-warning" title="Menunggu Analisa"><i class="fa fa-clock"></i> Menunggu Analisa</span>';
} elseif ($usulan_detail->status_survey == 1 && $usulan_detail->status_analisa == 1) {
    // Setelah analisa, periksa status komite
    if ($usulan_detail->status_komite == 1) {
        $status_badge = '<span class="badge badge-success" title="Acc"><i class="fa fa-check-circle"></i> Acc</span>';
    } elseif ($usulan_detail->status_komite == 2) {
        $status_badge = '<span class="badge badge-primary" title="Revisi"><i class="fa fa-edit"></i> Revisi</span>';
    } elseif ($usulan_detail->status_komite == 3) {
        $status_badge = '<span class="badge badge-danger" title="Ditolak"><i class="fa fa-times-circle"></i> Ditolak</span>';
    } else {
        $status_badge = '<span class="badge badge-info" title="Menunggu Komite"><i class="fa fa-clock"></i> Menunggu Komite</span>';
    }
} else {
    $status_badge = '<span class="badge" style="background-color: #808080; color: white;" title="Tidak Ada Status"><i class="fa-solid fa-question-circle"></i> N/A</span>';
}
?>
<style>
    label {
        font-weight: bold;
    }
</style>
<!-- Main content -->
<div class="container">
    <!-- Content area -->
    <div class="content">
        <?php echo $this->session->flashdata('msg'); ?>
        <!-- Form content -->
        <div class="row">
            <div class="panel panel-flat col-12">
                <div class="panel-body">
                    <h4><i class="fa fa-file-text"></i> <strong><?php
                                                                if (!empty($usulan_detail->tgl_cek_bi)) {
                                                                    echo date('Ymd', strtotime($usulan_detail->tgl_cek_bi)) . '_PBY' . $usulan_detail->id;
                                                                } else {
                                                                    echo 'PBY' . $usulan_detail->id;
                                                                }
                                                                ?></h4></strong>
                    <span style="font-size: 80%; opacity: 0.7;">Tgl Masuk : <?php echo date('d-m-Y', strtotime($usulan_detail->tanggal)); ?></span>
                    <span style="float: right;">
                        <p><?= $status_badge; ?></p>
                    </span>
                    <hr>
                    <div class="row">
                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label>Nama</label>
                                <p><?php echo $usulan_detail->nama; ?></p>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label>Jenis Kelamin</label>
                                <p><?php echo ($usulan_detail->jk == 'L') ? 'LAKI-LAKI' : (($usulan_detail->jk == 'P') ? 'PEREMPUAN' : 'Tidak Diketahui'); ?></p>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label>Pekerjaan</label>
                                <p><?php echo $usulan_detail->pekerjaan; ?></p>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label>Alamat</label>
                                <p><?php echo $usulan_detail->alamat; ?> <?php echo $usulan_detail->kelurahan_nama; ?> <?php echo $usulan_detail->kecamatan_nama; ?> <?php echo $usulan_detail->kota_nama; ?> <?php echo $usulan_detail->provinsi_nama; ?></p>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label>Tujuan Pembiayaan</label>
                                <p><?php echo $usulan_detail->tujuan; ?></p>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label>Plafon Usulan</label>
                                <p>Rp <?php echo number_format($usulan_detail->nominal, 0, ',', '.'); ?></p>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label>Telepon</label>
                                <p><?php echo $usulan_detail->telepon; ?></p>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label>Jangka Waktu</label>
                                <p><?php echo $usulan_detail->jangka_waktu; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
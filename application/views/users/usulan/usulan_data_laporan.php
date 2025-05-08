<?php
$cek = $user->row(); //  mengambil nilai data dari tabel tbl_user 
$level = $cek->level; //  nilai level dari variabel $level
$id_user = $cek->id_user;
$kode_kantor = $cek->kode_kantor;
?>
<style>
    .table-striped tbody tr:nth-child(odd) {
        background-color: white;
    }

    .table-striped tbody tr:nth-child(even) {
        background-color: #ccc;
    }

    .table th {
        font-weight: bold;
    }

    .container {
        width: 100%;
        margin: 0;
    }
</style>
<div class="container">
  <div class="content">
    <?php
    echo $this->session->flashdata('msg');
    ?>
    <!-- Dashboard content -->

    <div class="row">
      <!-- Basic datatable -->
      <div class="panel panel-flat">
        <div class="panel-heading">
          <div class="navigation-buttons">
            <div class="btn-group">
              <h5 class="navigation-buttons"><i class="icon-file-empty2"></i> Data Laporan Usulan</h5>
            </div>
            <div class="btn-group" style="float: right;">
              <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-bars"></i>
              </button>
              <ul class="dropdown-menu dropdown-menu-right" role="menu">
                <li><a href="users/usulan?usulan_type=usulan_saya"><i class="fa-solid fa-clipboard-list"></i> Usulan Saya</a></li>
                <li><a href="users/usulan?usulan_type=semua_usulan"><i class="fa-solid fa-clipboard-list"></i> Semua Usulan</a></li>

              </ul>
            </div>
          </div>
          <hr style="margin:0px;">
          <br>
          <form class="form-inline" method="post" action="<?= base_url('users/usulan_laporan'); ?>" onchange="this.form.submit()">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-addon"><i class="icon-calendar22"></i></div>
                <!-- Display tgl1 value in a date input field for editing -->
                <input type="date" name="tgl1" class="form-control" value="<?= $tgl1 ?>" required>
              </div>
            </div>
            &nbsp; Sampai
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-addon"><i class="icon-calendar22"></i></div>
                <!-- Display tgl2 value in a date input field for editing -->
                <input type="date" name="tgl2" class="form-control" value="<?= $tgl2 ?>" required>
              </div>
            </div>
            <button type="submit" name="usulan_data_laporan" class="btn btn-danger"><i class="fa-solid fa-magnifying-glass"></i></button>
          </form>

          <br>

          <form action="<?= base_url('users/usulan_export_excel/' . $tgl1 . '/' . $tgl2) ?>" method="post" target="_blank">
            <button type="submit" name="btnexport" class="btn btn-success" style="display: flex; align-items: center; justify-content: center;">
              <i class="icon-file-excel" style="font-size: 18px; margin-right: 8px;"></i>
              Export
            </button>
          </form>
          
        </div>
        <div class="table-responsive">
          <table class="table datatable-basic" width="100%">
            <thead>
              <tr>
                <th style="display: none;">No.</th>
                <th>ID/CekBI</th>
                <!-- <th>Survey</th> -->
                <th>Status</th>
                <th style="position: sticky; left: 0; z-index: 1; background:#fff;">Nama</th>
                <!-- <th>Pekerjaan</th> -->
                <th>Alamat</th>
                <!-- <th>Tujuan Pembiayaan</th> -->
                <th>Plafon Usulan</th>
                <th>Wewenang survey</th>
                <th>No. Telepon</th>
                <!-- <th>Jangka Waktu</th> -->
                <th>Tanggal</th>
                <th>Jaminan</th>
                <th>Inpuser</th>
                <th>Aksi</th> <!-- Kolom untuk aksi -->
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              foreach ($sql->result() as $baris) : ?>
                <tr>
                  <td style="display: none;">
                    <?php echo $no++; ?>
                  </td>
                  <td style="text-align: center; vertical-align: middle;">
                    <strong><?php
                            if (!empty($baris->tgl_cek_bi)) {
                              echo date('Ymd', strtotime($baris->tgl_cek_bi)) . '_PBY' . $baris->id;
                            } else {
                              echo 'PBY' . $baris->id;
                            }
                            ?></strong><br>
                    <?php
                    if ($baris->cek_req == 1 && empty($baris->tgl_cek_bi)) {
                      echo '<i class="text-warning" style="font-size: 1rem;">Request</i>';
                    } elseif ($baris->cek_req == 1 && !empty($baris->tgl_cek_bi)) {
                      echo '<i class="text-success" style="font-size: 1rem;">Checked</i>';
                    } else {
                      echo '<i class="text-muted" style="font-size: 1rem;">N/A</i>';
                    }
                    ?>
                  </td>
                  <td style="text-align: center; vertical-align: middle;">
                    <?php if (!empty($baris->status)) : ?>
                      <?php if ($baris->status == 'Batal') : ?>
                        <div style="color: red;">
                          <i class="fa fa-times-circle"></i><br> Batal
                        </div>
                      <?php elseif ($baris->status == 'Nonaktif') : ?>
                        <div style="color: grey;">
                          <i class="fa fa-exclamation-circle"></i><br> Nonaktif
                        </div>
                      <?php elseif ($baris->status == 'Aktif') : ?>
                        <div>
                          <?php
                          // Tentukan status berdasarkan status survei, analisa, dan komite
                          if ($baris->status_survey == 0) {
                            $status_icon = '<i class="fa fa-clock" style="color: #808080;" title="Menunggu Survei"></i>';
                            $status_text = '<span style="color: #808080;">Menunggu Survei</span>';
                          } elseif ($baris->status_survey == 1 && $baris->status_analisa == 0) {
                            $status_icon = '<i class="fa fa-clock" style="color: orange;" title="Menunggu Analisa"></i>';
                            $status_text = '<span style="color: orange;">Menunggu Analisa</span>';
                          } elseif ($baris->status_survey == 1 && $baris->status_analisa == 1) {
                            // Setelah analisa, periksa status komite
                            if ($baris->status_komite == 1) {
                              $status_icon = '<i class="fa fa-check-circle" style="color: green;" title="Acc"></i>';
                              $status_text = '<span style="color: green;">Acc</span>';
                            } elseif ($baris->status_komite == 2) {
                              $status_icon = '<i class="fa fa-edit" style="color: #00bcd4;" title="Revisi"></i>';
                              $status_text = '<span style="color: #00bcd4;">Revisi</span>';
                            } elseif ($baris->status_komite == 3) {
                              $status_icon = '<i class="fa fa-times-circle" style="color: red;" title="Ditolak"></i>';
                              $status_text = '<span style="color: red;">Ditolak</span>';
                            } else {
                              // Jika belum ada keputusan komite, status menunggu komite
                              $status_icon = '<i class="fa fa-clock" style="color: #007bff;" title="Menunggu Komite"></i>';
                              $status_text = '<span style="color: #007bff;">Menunggu Komite</span>';
                            }
                          } else {
                            $status_icon = '<i class="fa-solid fa-question-circle" style="color: gray;" title="Tidak Ada Status"></i>';
                            $status_text = '<span style="color: gray;">N/A</span>';
                          }
                          ?>
                          <!-- Tampilkan tracking status -->
                          <div>
                            <?= $status_icon; ?><br>
                            <?= $status_text; ?>
                          </div>
                          <!-- Tampilkan keterangan jika ada -->
                          <?php if (!empty($baris->keterangan)) : ?>
                            <div style="color: red;">
                              <i class="fa fa-times-circle"></i><br>
                              <?= nl2br(htmlspecialchars($baris->keterangan)); ?>
                            </div>
                          <?php endif; ?>
                        </div>
                      <?php endif; ?>
                    <?php endif; ?>
                  </td>
                  <!-- <td>
                                        <?php echo date('Y-m-d', strtotime($baris->tanggal)); ?>
                                    </td> -->
                  <td style="position: sticky; left: 0; z-index: 1; background:#fff;">
                    <strong><?php echo $baris->nama; ?></strong>
                  </td>
                  <!-- <td>
                                        <?php echo $baris->pekerjaan; ?>
                                    </td> -->
                  <td>
                    <?php echo $baris->alamat; ?> <?php echo $baris->kelurahan_nama; ?> <?php echo $baris->kecamatan_nama; ?> <?php echo $baris->kota_nama; ?>
                  </td>
                  <!-- <td>
                                        <?php echo $baris->tujuan; ?>
                                    </td> -->
                  <td>
                    <strong><?php echo 'Rp ' . number_format($baris->nominal, 0, ',', '.'); ?></strong>
                  </td>
                  <td>
                    <?php
                    if ($baris->nominal <= 20000000) {
                      echo 'CABANG ' . getKodeKantorText($baris->kode_kantor); // Keterangan untuk nominal <= 20.000.000
                    } else {
                      echo 'PUSAT'; // Keterangan untuk nominal > 20.000.000
                    }
                    ?>
                  </td>
                  <td>
                    <?php echo $baris->telepon; ?>
                  </td>
                  <!-- <td>
                                        <?php echo $baris->jangka_waktu; ?>
                                    </td> -->
                  <td>
                    <?php echo date('Y-m-d', strtotime($baris->tanggal)); ?>
                  </td>
                  <td>
                    <?php echo $baris->jaminan; ?>
                  </td>
                  <td>
                    <?php echo $this->Usulan_model->getUsernameById($baris->id_user); ?>
                  </td>
                  <td>
                    <a href="<?php echo base_url('users/usulan_detail/' . $baris->id); ?>" class="btn btn-success btn-xs" style="margin: 1px;"><i class="fa fa-eye"></i></a>
                    <a href="<?php echo base_url('users/usulan_edit/' . $baris->id); ?>" class="btn btn-info btn-xs" style="margin: 1px;"><i class="fa fa-pencil"></i></a>
                    <a href="<?php echo base_url('users/analisa_print/' . $baris->id); ?>" class="btn btn-primary btn-xs" target="_blank" style="margin: 1px;"><i class="fa-solid fa-print"></i></a>
                    <!-- <a href="<?php echo site_url('users/file_user_id_pby_upload/' . $baris->id); ?>" class="btn btn-light btn-xs" style="background-color: #6c757d; color: white;"><i class="fa fa-upload" aria-hidden="true"></i></a> -->
                    <?php if ($baris->category === 'SLIK' && in_array($level, ['s_admin', 'kadiv_manrisk', 'k_cabang', 'mng_bisnis', 'surveyor', 'kadiv_opr', 'it'])) : ?>
                      <a href="<?php echo base_url('users/file_user_lihat_id_pby/' . $baris->id); ?>" class="btn btn-xs" style="background-color: #6f42c1; color: white;">
                        <i class="fa-solid fa-book-open"></i>
                      </a>
                      <!-- <a href="<?php echo base_url('users/analisa_download_file/' . $baris->id); ?>" class="btn btn-warning btn-xs" style="background-color: #e83e8c; color: white;">
                                                <i class="fa fa-download"></i>
                                            </a> -->
                    <?php else : ?>
                      <!-- Tidak menampilkan tombol jika level tidak sesuai -->
                    <?php endif; ?>
                    <?php if ($level === 's_admin') : ?>
                      <a href="javascript:void(0);" class="btn btn-danger btn-sm" onclick="hapusUsulan(<?php echo $baris->id; ?>)"><i class="fa fa-trash"></i></a>
                    <?php endif; ?>
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
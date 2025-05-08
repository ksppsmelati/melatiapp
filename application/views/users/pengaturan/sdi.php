<!-- membuat container width 100% -->
<style>
  .container {
    width: 100%;
    margin: 0;
    padding-top: 10px;
  }

  .evaluasi-container {
    display: flex;
    align-items: center;
    margin: 5px 0;
    /* Jarak antar item */
  }

  .evaluasi-container span {
    font-size: 12px;
    /* Ukuran font */
    padding: 5px 10px;
    /* Padding untuk ruang di sekitar teks */
    border-radius: 5px;
    /* Sudut yang melengkung */
    transition: background-color 0.3s ease;
    /* Transisi warna latar belakang */
  }

  .evaluasi-sudah {
    color: #4CAF50;
    /* Hijau untuk sudah evaluasi */
    background-color: rgba(76, 175, 80, 0.1);
    /* Latar belakang hijau transparan */
  }

  .evaluasi-perlu {
    color: #FF9800;
    /* Oranye untuk perlu evaluasi */
    background-color: rgba(255, 152, 0, 0.1);
    /* Latar belakang oranye transparan */
  }

  .evaluasi-tidak {
    color: #F44336;
    /* Merah untuk tidak perlu evaluasi */
    background-color: rgba(244, 67, 54, 0.1);
    /* Latar belakang merah transparan */
  }

  /* Ikon styling */
  .evaluasi-container i {
    margin-right: 5px;
    /* Jarak antara ikon dan teks */
  }
</style>

<!-- Main content -->
<div class="content">
  <?php
  echo $this->session->flashdata('msg');
  ?>
  <div class="container">
    <!-- Dashboard content -->
    <div class="row">
      <!-- Basic datatable -->
      <div class="panel panel-flat">
        <div class="panel-heading">
          <h5 class="panel-title"><i class="icon-users"></i> SDI</h5>
          <br>
          <form action="<?= base_url('users/sdi_export_excel/') ?>" method="post" target="_blank">
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
                <th width="2px;">No.</th>
                <!-- <th>ID</th> -->
                <th style="position: sticky; left: 0; z-index: 1; background:#fff;">Nama</th>
                <th>Tgl Lahir</th>
                <th>Telp</th>
                <th>Sts</th>
                <th>Level</th>
                <th>Pend</th>
                <th>Tgl Masuk</th>
                <th>Masa Kerja</th>
                <th>Rate</th>
                <!-- <th>JK</th> -->
                <!-- <th>Alamat</th> -->
                <th>Sisa Cuti</th>
                <th>Evaluasi</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              foreach ($level_users->result() as $baris) {
                // Skip rendering the row for users with level 's_admin'
                if ($baris->level == "s_admin" || $baris->status != "aktif") {
                  continue;
                }
              ?>

                <tr>
                  <td><?php echo $no . '.'; ?></td>
                  <!-- <td><?php echo $baris->id_user; ?></td> -->
                  <td style="position: sticky; left: 0; z-index: 1; background:#fff; text-transform: uppercase;"><a href="users/pengguna/d/<?php echo $baris->id_user; ?>"><?php echo $baris->nama_lengkap; ?></a></td>
                  <td><?php echo $baris->tgl_lahir; ?></td>
                  <td><?php echo $baris->telp; ?></td>
                  <td><?php
                      if ($baris->status == "pending" or $baris->status == NULL) { ?>
                      <i class="icon-cross3" style="color: red;"></i>
                    <?php
                      } else { ?>
                      <i class="icon-checkmark4" style="color: green;"></i>
                    <?php
                      } ?>
                  </td>
                  <td><?php echo $levelText = getLevelText($baris->level); ?> <?php echo $kodeKantorText = getKodeKantorText($baris->kode_kantor); ?></td>
                  <td><?php echo $baris->jenjang_pen; ?> <?php echo $baris->jurusan_pen; ?></td>
                  <td><?php echo date('Y-m-d', strtotime($baris->tgl_daftar)); ?></td>
                  <td><?php echo isset($baris->years) ? $baris->years . ' th ' : '' ?> <?php echo isset($baris->months) ? $baris->months . ' bln' : ''; ?></td>
                  <td><?php echo $baris->performa; ?></td>
                  <!-- <td><?php echo $baris->jenis_kelamin; ?></td> -->
                  <!-- <td><?php echo $baris->alamat; ?></td> -->
                  <!-- <td><?php echo $baris->pengalaman; ?></td> -->
                  <td><?php echo $baris->sisa_cuti; ?></td>
                  <td>
                    <?php
                    // Inisialisasi variabel
                    $class = 'evaluasi-tidak'; // Default class
                    $evaluasiText = ""; // Default text
                    $icon = ""; // Default icon

                    // Cek masa evaluasi
                    if (($baris->years > 0 || $baris->months > 0) && $baris->months % 3 == 0) {
                      $class = 'evaluasi-perlu';
                      $evaluasiText = "Masa Evaluasi";
                      $icon = "<i class='fas fa-clock'></i>";
                    }

                    // Update evaluasi di database jika perlu
                    if (!empty($baris) && (!($baris->years > 0 || $baris->months > 0) || (isset($baris->months) && $baris->months % 3 != 0))) {
                      $this->db->set('evaluasi', 0);
                      $this->db->where('id_user', $baris->id_user);
                      $this->db->update('tbl_user');
                    }

                    // Ambil nilai evaluasi terbaru setelah update
                    $baris = $this->db->get_where('tbl_user', ['id_user' => $baris->id_user])->row();

                    // Tentukan class CSS berdasarkan kondisi evaluasi
                    if ($baris) {
                      $years = isset($baris->years) ? $baris->years : 0;
                      $months = isset($baris->months) ? $baris->months : 0;

                      // Cek apakah masa evaluasi
                      $isInEvaluationPeriod = ($years == 0 && $months > 0 && $months % 3 == 0);

                      if ($baris->evaluasi == 1) {
                        $class = 'evaluasi-sudah'; // Class untuk warna hijau
                        $text = "<i class='fas fa-check-circle'></i> Sudah Evaluasi"; // Ikon centang
                      } else if ($baris->evaluasi == 0 && $isInEvaluationPeriod) {
                        $class = 'evaluasi-perlu'; // Class untuk warna oranye
                        $text = "<i class='fas fa-exclamation-circle'></i> Perlu Evaluasi"; // Ikon seruan
                      } else {
                        $class = 'evaluasi-tidak';
                        $text = "";
                      }
                    } else {
                      // Jika user tidak ditemukan, tetap dengan default class dan text
                      $class = 'evaluasi-tidak';
                      $text = "";
                    }
                    ?>

                    <div class="evaluasi-container">
                      <span class="<?php echo $class; ?>">
                        <?php echo $icon; ?> <?php echo $evaluasiText; ?><br> <?php echo $text; ?>
                      </span>
                    </div>
                  </td>
                  <td>
                    <!-- <a href="users/pengguna/d/<?php echo $baris->id_user; ?>" class="btn btn-info btn-xs"><i class="icon-eye"></i></a> -->
                    <a href="users/sdi/e/<?php echo $baris->id_user; ?>" class="btn btn-success btn-xs"><i class="icon-pencil7"></i></a>
                    <!-- <a href="users/pengguna/h/<?php echo $baris->id_user; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Apakah Anda yakin?')"><i class="icon-trash"></i></a> -->
                  </td>
                </tr>
              <?php
                $no++;
              } ?>
            </tbody>
          </table>
        </div>
      </div>
      <!-- /basic datatable -->
    </div>
  </div>
  <!-- /dashboard content -->
</div>
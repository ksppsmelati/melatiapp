<style>
  .container {
    width: 100%;
    margin: 0;
    padding-top: 10px;
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
          <h5 class="panel-title"><i class="icon-users"></i> Data User</h5>
          <br>
          <a href="users/pengguna/t" class="btn btn-danger">+ <i class="icon-user"></i> User Baru</a>
        </div>
        <div class="table-responsive">
          <table class="table datatable-basic" width="100%">
            <thead>
              <tr>
                <th width="30px;">No.</th>
                <th>Nama</th>
                <th>ID</th>
                <th>No. Tlp</th>
                <th>CIF</th>
                <th>Status</th>
                <th>Level</th>
                <th>Devisi</th>
                <th>A1</th>
                <th>A2</th>
                <th>Kantor</th>
                <th>Tgl Daftar</th>
                <th>Login Terakhir</th>
                <th class="text-center" width="170"></th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              foreach ($level_users->result() as $baris) {
                // Skip rendering the row for users with level 's_admin'
                if ($baris->level == "s_admin") {
                  continue;
                }
              ?>

                <tr>
                  <td><?php echo $no . '.'; ?></td>
                  <td><a href="users/pengguna/d/<?php echo $baris->id_user; ?>"><?php echo strtoupper($baris->nama_lengkap); ?></a></td>
                  <td><?php echo $baris->id_user; ?></td>
                  <?php
                  // Nomor telepon yang ingin ditampilkan dan dihubungkan ke WhatsApp
                  $phone_number = $baris->telp;

                  // Menghapus karakter-karakter non-digit dari nomor telepon
                  $phone_number = preg_replace('/\D/', '', isset($phone_number) ? $phone_number : '');

                  // Jika nomor telepon dimulai dengan 0, hilangkan 0 dan tambahkan kode negara Indonesia (+62)
                  if (substr($phone_number, 0, 1) === '0') {
                    $phone_number = '+62' . ltrim($phone_number, '0');
                  } else {
                    // Jika nomor telepon tidak memiliki kode negara (tidak dimulai dengan +), tambahkan kode negara Indonesia (+62)
                    if (substr($phone_number, 0, 1) !== '+') {
                      $phone_number = '+62' . $phone_number;
                    }
                  }
                  ?>

                  <td><a href="https://api.whatsapp.com/send?phone=<?php echo urlencode($phone_number); ?>"><?php echo $baris->telp; ?></a></td>
                  <td><?php echo $baris->nocif; ?></td>
                  <td><?php
                      if ($baris->status == "pending" or $baris->status == NULL) { ?>
                      <i class="icon-cross3" style="color: red;"></i>
                    <?php
                      } else { ?>
                      <i class="icon-checkmark4" style="color: green;"></i>
                    <?php
                      } ?>
                  </td>
                  <td><?php echo $levelText = getLevelText($baris->level); ?></td>
                  <td><?php echo $kodeDevisiText = getKodeDevisiText($baris->kode_devisi); ?></td>
                  <td><?php echo $baris->kode_atasan; ?></td>
                  <td><?php echo $baris->kode_atasan_2; ?></td>
                  <td><?php echo $kodeKantorText = getKodeKantorText($baris->kode_kantor); ?></td>
                  <td><?php if ($baris->tgl_daftar == "") {
                        echo "-";
                      } else {
                        echo $baris->tgl_daftar;
                      } ?></td>
                  <td><?php if ($baris->terakhir_login == "") {
                        echo "-";
                      } else {
                        echo $baris->terakhir_login;
                      } ?></td>
                  <td>
                    <a href="users/pengguna/d/<?php echo $baris->id_user; ?>" class="btn btn-info btn-xs"><i class="icon-eye"></i></a>
                    <a href="users/pengguna/e/<?php echo $baris->id_user; ?>" class="btn btn-success btn-xs"><i class="icon-pencil7"></i></a>
                    <a href="users/pengguna/h/<?php echo $baris->id_user; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Apakah Anda yakin?')"><i class="icon-trash"></i></a>
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
</div>
<!-- /dashboard content -->
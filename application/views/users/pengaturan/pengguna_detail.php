<?php
$user = $query;
$jk = $user->jenis_kelamin;
?>
<!-- Main content -->
<div class="container">
  <!-- Content area -->
  <div class="content">
    <!-- Dashboard content -->
    <div class="row">
      <div class="panel panel-flat">
        <div class="panel-body">
          <fieldset class="content-group">
            <legend class="text-bold"><i class="icon-user"></i> Detail User</legend>
            <?php
            echo $this->session->flashdata('msg');
            ?>
            <?php
            $gambar_src = ($jk == 'L') ? 'foto/default.png' : 'foto/perempuan.png';
            ?>
            <center>
              <img src="<?php echo $gambar_src; ?>" alt="<?php echo $user->nama_lengkap; ?>" class="img-circle" width="100">
              <br>
              <b>
                <?php if ($user->level == "s_admin") {
                  echo "Super Admin";
                } else {
                  echo ucwords($user->level);
                } ?>
              </b>
            </center>
            <hr>
            <table width="100%" border=0>
            <tr>
                <th><b>ID User</b></th>
                <td><b>:</b></td>
                <td> <?php echo $user->id_user; ?></td>
              </tr>
              <tr>
                <th width="30%"><b>Username</b></th>
                <td width="2%"><b>:</b></td>
                <td> <?php echo $user->username; ?></td>
              </tr>
              <tr>
                <th><b>Nama Lengkap</b></th>
                <td><b>:</b></td>
                <td> <?php echo $user->nama_lengkap; ?></td>
              </tr>
              <tr>
                <th><b>Status</b></th>
                <td><b>:</b></td>
                <td> <?php echo $user->status; ?></td>
              </tr>
              <tr>
                <th><b>Email</b></th>
                <td><b>:</b></td>
                <td> <?php echo $user->email; ?></td>
              </tr>
              <tr>
                <th><b>Alamat</b></th>
                <td><b>:</b></td>
                <td> <?php echo $user->alamat; ?></td>
              </tr>
              <tr>
                <th><b>Kantor</b></th>
                <td><b>:</b></td>
                <td><?php echo $kodeKantorText = getKodeKantorText($user->kode_kantor); ?> [<?php echo $user->kode_kantor; ?>] </td>
              </tr>
              <tr>
                <th><b>Level</b></th>
                <td><b>:</b></td>
                <td><?php echo $kodeLevelText = getLevelText($user->level); ?></td>
              </tr>
              <tr>
                <th><b>Devisi</b></th>
                <td><b>:</b></td>
                <td><?php echo $kodeDevisiText = getKodeDevisiText($user->kode_devisi); ?> [<?php echo $user->kode_devisi; ?>] </td>
              </tr>
              <tr>
                <th><b>Telepon</b></th>
                <td><b>:</b></td>
                <td> <?php echo $user->telp; ?></td>
              </tr>
              <tr>
                <th><b>Sertifikasi</b></th>
                <td><b>:</b></td>
                <td> <?php echo $user->pengalaman; ?></td>
              </tr>
            </table>
            <hr>
            <a href="javascript:history.back()" class="btn btn-default">
              << Kembali</a>
          </fieldset>
        </div>
      </div>
    </div>
    <!-- /dashboard content -->
  </div>
</div>
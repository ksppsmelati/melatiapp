<!-- File: application/views/users/saldo/saldo_data.php -->
<?php
$cek = $user->row(); // Ambil data pengguna dari tbl_user
$id_user = $cek->id_user;
$nocif = $cek->nocif;

// Mapping kode produk ke deskripsi
$kode_produk_desc = [
  10 => 'PEMBIAYAAN MUDOROBAH',
  20 => 'MURABAHAH',
  30 => 'IJAROH',
  40 => 'PEMBIAYAAN MUSYAROKAH',
  50 => 'QORDHUL HASAN',
];

?>

<div class="container">
  <div class="content">
    <div class="row">
      <div class="panel panel-flat">
        <?php echo $this->session->flashdata('msg'); ?>
        <div class="panel-body">
          <div class="navigation-buttons">
            <div class="btn-group" style="float: left;">
            <i class="fa-solid fa-hand-holding-dollar"></i> Pembiayaan
            </div>
            <div class="btn-group" style="float: right;">
              <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-bars"></i>
              </button>
              <ul class="dropdown-menu dropdown-menu-right" role="menu">
                <li><a href="<?php echo site_url('users/saldo_data'); ?>"><i class="fa-solid fa-sack-dollar"></i></i> Tabungan</a></li>
                <li><a href="<?php echo site_url('users/pembiayaan_data'); ?>"><i class="fa-solid fa-hand-holding-dollar"></i> Pembiayaan</a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>
        <fieldset class="content-group">
          <div class="table-responsive">
            <table class="table datatable-basic" width="100%">
              <thead class="thead-light">
                <tr>
                  <th>No</th>
                  <th>No Kontrak</th>
                  <th>Nama</th>
                  <th>Jenis Pembiayaan</th>
                  <th>Modal Awal</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1; // Initialize counter
                foreach ($pembiayaan as $data) : ?>
                  <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $data['nokontrak']; ?></td> <!-- No Pembiayaan -->
                    <td><?php echo $data['nama']; ?></td> <!-- Nama -->
                    <td><?php echo isset($kode_produk_desc[$data['kdprd']]) ? $kode_produk_desc[$data['kdprd']] : $data['kdprd']; ?></td> <!-- Produk -->
                    <td style="font-weight: bold;"><?php echo 'Rp ' . number_format($data['mdlawal'], 0, ',', '.'); ?></td>
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
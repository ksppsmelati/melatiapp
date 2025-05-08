<!-- File: application/views/users/saldo/saldo_data.php -->
<?php
$cek = $user->row(); // Ambil data pengguna dari tbl_user
$id_user = $cek->id_user;
$nocif = $cek->nocif;

// Mapping kode produk ke deskripsi
$kode_produk_desc = [
  10 => 'SIMPANAN MELATI',
  17 => 'SIMPANAN MASA DATANG 10 THN',
  20 => 'SIMPANAN MELATI EMAS SYARIAH',
  21 => 'SIMPANAN PEMBIAYAAN',
  22 => 'SIMPANAN HARI RAYA',
  23 => 'SIMPANAN UKHUWAH PENDIDIKAN',
  25 => 'SIMPANAN PEMUPUKAN MODAL',
  29 => 'SIMPANAN POKOK',
  30 => 'SIMPANAN WAJIB',
  31 => 'SIMPANAN MASA DATANG 2 TAHUN',
  32 => 'SIMPANAN MASA DATANG 5 TAHUN',
  33 => 'SIMPANAN PENYERTAAN',
  34 => 'SIMPANAN PENYERTAAN',
  35 => 'SIMPANAN UMROH',
  36 => 'SIMPANAN HAJI',
  37 => 'SIMPANAN MASA DATANG 1 TAHUN',
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
            <i class="fa-solid fa-sack-dollar"></i> Simpanan
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
        </div>
        <div class="clearfix"></div>
        <fieldset class="content-group">
          <div class="table-responsive">
            <table class="table datatable-basic" width="100%">
              <thead class="thead-light">
                <tr>
                  <th>No</th>
                  <th>No Tabungan</th>
                  <th>Nama</th>
                  <th>Produk</th>
                  <!-- <th>Nocif</th> -->
                  <th>Saldo</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1; // Initialize counter
                foreach ($tabungan as $data) : ?>
                  <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $data['notab']; ?></td>
                    <td><?php echo $data['fnama']; ?>
                      <?php if (!empty($data['namaqq'])) : ?>
                        <?php echo ' QQ ' . $data['namaqq']; ?>
                      <?php endif; ?>
                    </td>
                    <td><?php echo isset($kode_produk_desc[$data['kodeprd']]) ? $kode_produk_desc[$data['kodeprd']] : $data['kodeprd']; ?></td>
                    <!-- <td><?php echo $data['nocif']; ?></td> -->
                    <td style="font-weight: bold;"><?php echo 'Rp ' . number_format($data['sahirrp'], 0, ',', '.'); ?></td>
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
<?php
$cek = $user->row(); // Get user data from tbl_user
$id_user = $cek->id_user;
?>
<div class="container">
  <!-- Content area -->
  <div class="content">
    <?php echo $this->session->flashdata('msg'); ?>
    <div class="row">
      <div class="panel panel-flat">
        <div class="panel-body">
          <div class="navigation-buttons">
            <div class="btn-group" style="float: left;">
              <!-- Back button (top left) -->
              <i class="fa fa-envelope"></i> Data Kritik & Saran
            </div>
            <div class="btn-group" style="float: right;">
              <!-- Dropdown button (top right) -->
              <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-bars"></i>
              </button>
              <!-- Dropdown menu -->
              <ul class="dropdown-menu dropdown-menu-right" role="menu">
                <li><a href="<?php echo site_url('users/kritik_saran_tambah'); ?>"><i class="fa fa-plus"></i> Tambah Kritik & Saran</a></li>
                <li><a href="<?php echo site_url('users/kritik_saran_data'); ?>"><i class="fa fa-envelope"></i> Data Kritik & Saran</a></li>
                <li><a href="<?php echo site_url('users/kritik_saran_data_direspond'); ?>"><i class="fa fa-envelope-open"></i> Data Direspond</a></li>
                <li><a href="<?php echo site_url('users/infografis_kritik_saran_petugas'); ?>"><i class="fa-regular fa-envelope"></i> Kritik Saran Petugas</a></li>
              </ul>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
        <?php if (!empty($kritik_saran)) : ?>
          <div class="table-responsive">
            <table class="table table-striped datatable-basic" width="100%">
              <thead>
                <tr>
                  <th style="display: none;">No</th>
                  <th>Tanggal</th>
                  <th>Nama</th>
                  <th>Kritik Saran</th>
                  <th>Input User</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1; // Inisialisasi nomor urut
                foreach ($kritik_saran as $baris) : ?>
                  <tr>
                    <td style="display: none;"><a href="<?php echo site_url('users/kritik_saran_lihat/' . $baris['id']); ?>"><?php echo $no++; ?></a></td>
                    <td><a href="<?php echo site_url('users/kritik_saran_lihat/' . $baris['id']); ?>"><?php echo !empty($baris['tanggal']) ? date('d-m-Y', strtotime($baris['tanggal'])) : '-'; ?></a></td>
                    <td><a href="<?php echo site_url('users/kritik_saran_lihat/' . $baris['id']); ?>"><?php echo !empty($baris['nama']) ? strtoupper(htmlspecialchars($baris['nama'])) : '-'; ?></a></td>
                    <td>
                      <a href="<?php echo site_url('users/kritik_saran_lihat/' . $baris['id']); ?>" title="<?php echo htmlspecialchars(strip_tags($baris['kritik_saran'])); ?>">
                        <?php echo htmlspecialchars(substr(strip_tags($baris['kritik_saran']), 0, 20)) . (strlen($baris['kritik_saran']) > 20 ? '...' : ''); ?>
                      </a>
                    </td>
                    <td>
                      <a href="<?php echo site_url('users/kritik_saran_lihat/' . $baris['id']); ?>">
                        <?php echo (!empty($baris['nama_lengkap']) && $baris['id_user'] != '0') ? strtoupper(htmlspecialchars($baris['nama_lengkap'])) : '-'; ?>
                      </a>
                    </td>


                    <td>
                      <a href="<?php echo site_url('users/kritik_saran/kritik_saran_lihat/' . (!empty($baris['id']) ? $baris['id'] : '')); ?>" class="btn btn-primary btn-xs"><i class="icon-eye"></i></a>
                      <a href="<?php echo site_url('users/kritik_saran/kritik_saran_edit/' . (!empty($baris['id']) ? $baris['id'] : '')); ?>" class="btn btn-success btn-xs"><i class="icon-pencil7"></i></a>
                      <a href="javascript:void(0);" class="btn btn-danger btn-xs delete-kritik_saran" data-id="<?php echo $baris['id']; ?>"><i class="icon-trash"></i></a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php else : ?>
          <div style="text-align: center;">
            <p>Tidak ada data kritik & saran.</p>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<!-- Tambahkan ini di bagian <head> atau sebelum </body> -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  $(document).ready(function() {
    // Handle SweetAlert for delete action
    $('.delete-kritik_saran').on('click', function(e) {
      e.preventDefault();
      var kritikSaranId = $(this).data('id'); // Mengambil id dari atribut data-id

      Swal.fire({
        title: 'Konfirmasi Hapus?',
        text: 'Anda yakin ingin menghapus kritik/saran!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          // Redirect ke URL penghapusan dengan id yang sesuai
          window.location.href = 'users/kritik_saran_hapus/' + kritikSaranId;
        }
      });
    });
  });
</script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<div class="container">
  <!-- Content area -->
  <div class="content">
    <!-- Dashboard content -->
    <div class="row">
      <div class="panel panel-flat">
        <?php echo $this->session->flashdata('msg'); ?>
        <div class="panel-body">
          <div class="navigation-buttons">
            <legend class="text-bold"><i class="fa fa-comment"></i> Ucapan Data</legend>
            <div class="btn-group" style="float: left;">
              <a href="<?php echo site_url('users/ucapan_tambah'); ?>" class="btn btn-danger btn-sm"><i class="fa fa-plus"></i> Tambah Ucapan</a>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>
        <fieldset class="content-group">
          <div class="table-responsive">
            <table class="table datatable-basic" width="100%">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Hari</th>
                  <th>Kategori</th>
                  <th>Isi Ucapan</th>
                  <!-- <th>Tanggal</th> -->
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1;
                foreach ($ucapan_list as $ucapan) : ?>
                  <tr>
                    <td><?php echo $no++; ?></td>
                    <td>
                      <?php
                      // Check if 'hari' exists and translate
                      $day_mapping = [
                        'Monday'    => 'Senin',
                        'Tuesday'   => 'Selasa',
                        'Wednesday' => 'Rabu',
                        'Thursday'  => 'Kamis',
                        'Friday'    => 'Jumat',
                        'Saturday'  => 'Sabtu',
                        'Sunday'    => 'Minggu'
                      ];

                      $day_in_english = isset($ucapan->hari) ? $ucapan->hari : '';
                      $day_in_indonesian = isset($day_mapping[$day_in_english]) ? $day_mapping[$day_in_english] : $day_in_english;
                      echo htmlspecialchars($day_in_indonesian);
                      ?>
                    </td>
                    <td><?php echo $ucapan->kategori; ?></td>
                    <td><?php echo substr($ucapan->isi_ucapan, 0, 20) . '...'; ?></td>
                    <!-- <td><?php echo $ucapan->tanggal; ?></td> -->
                    <td style="white-space: normal; word-wrap: break-word; word-break: break-word; max-width: 200px; overflow-wrap: break-word;">
                      <?php
                      // Determine the button color based on the status
                      $status = $ucapan->status;
                      $buttonColor = '';

                      switch ($status) {
                        case 'nonaktif':
                          $buttonColor = '#6c757d'; // Example color for BRANGKAS
                          break;
                        case 'aktif':
                          $buttonColor = '#28a745'; // Example color for DIAMBIL
                          break;
                        default:
                          $buttonColor = '#5bc0de'; // Default color
                          break;
                      }
                      ?>

                      <button style="
                                                background-color: <?php echo $buttonColor; ?>;
                                                color: white;
                                                border: none;
                                                padding: 2px 5px; /* Minimal padding */
                                                font-size: 12px; /* Smaller font size */
                                                border-radius: 3px;
                                                cursor: pointer;
                                            " title="<?php echo htmlspecialchars($status); ?>">
                        <?php echo htmlspecialchars($status); ?>
                      </button>
                    </td>
                    <td>
                      <a href="<?php echo site_url('users/ucapan_lihat/' . $ucapan->id_ucapan); ?>" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
                      <a href="<?php echo site_url('users/ucapan_edit/' . $ucapan->id_ucapan); ?>" class="btn btn-success btn-sm"><i class="fa fa-pen"></i></a>
                      <button class="btn btn-danger btn-sm" onclick="confirmDelete('<?php echo site_url('users/ucapan_hapus/' . $ucapan->id_ucapan); ?>')"><i class="fa fa-trash"></i></button>
                    </td>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<!-- SweetAlert2 Script -->
<script>
  function confirmDelete(url) {
    Swal.fire({
      title: 'Apakah Anda yakin?',
      text: "Data ini akan dihapus secara permanen!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, Hapus!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = url;
      }
    });
  }
</script>
<?php
$cek = $user->row(); //  mengambil nilai data dari tabel tbl_user 
$level = $cek->level; //  nilai level dari variabel $level
$id_user = $cek->id_user;
?>
<style type="text/css">
  .container {
    width: 100%;
  }

  .custom-popup-content {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 100%;
  }

  .popup-image-container {
    max-width: 100%;
    max-height: 100%;
    width: auto;
    height: auto;
  }

  .popup-image {
    max-width: 100%;
    max-height: 100%;
    width: auto;
    height: auto;
  }

  /* Custom styles for the popup */
  .custom-popup-content {
    padding: 0;
    /* Remove padding */
    background: none;
    /* Remove background */
    box-shadow: none;
    /* Remove box-shadow */
  }

  /* Custom styles for the close button */
  .custom-popup-close-button {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 40px;
    color: #fff;
    /* Change color if needed */
    cursor: pointer;
    background: transparent;
    border: none;
  }

  /* Mengatur warna teks pada seluruh baris */
  .table tbody tr {
    color: #333;
    /* Warna teks default untuk baris tabel */
  }

  /* Mengatur warna teks pada baris yang sudah dibaca (misalnya warna hijau) */
  .table tbody tr td i.icon-checkmark4 {
    color: green;
  }

  /* Mengatur warna teks pada baris yang belum dibaca (misalnya warna oranye) */
  .table tbody tr td i.fa.fa-refresh {
    color: orange;
  }

  /* Tambahan: Mengatur hover baris */
  /* .table tbody tr:hover {
    background-color: #d9edf7;
  } */
</style>
<link rel="stylesheet" href="assets/css/sweetalert2.min.css">

<!-- <script src="assets/js/sweetalert2.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="assets/js/jquery-ui.js"></script>
<script src="assets/js/select2.min.js"></script>

<div class="container">
  <div class="content">
    <?php
    echo $this->session->flashdata('msg');
    ?>

    <div class="row">
      <div class="panel panel-flat">
        <div class="panel-heading">
          <div class="navigation-buttons">
            <div class="btn-group">
              <h5 class="navigation-buttons"><i class="fa fa-inbox"></i> Data Otorisasi</h5>
            </div>
            <div class="btn-group" style="float: right;">
              <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-bars"></i>
              </button>
              <ul class="dropdown-menu dropdown-menu-right" role="menu">
                <li><a href="users/sm"><i class="fa fa-hourglass-half"></i> Menunggu Proses</a></li>
                <li><a href="users/ss"><i class="fa fa-check-circle"></i> Selesai Otorisasi</a></li>

              </ul>
            </div>
          </div>
          <?php
          $allowedLevels = ['s_admin', 'k_admin', 'audit', 'k_cabang', 'marketing', 'admin', 'ao', 'fo', 'k_keuangan', 'mng_bisnis', 'kadiv_opr', 'k_arsip'];
          if (in_array($level, $allowedLevels)) :
          ?>
            <?php
            echo '<br>';
            echo '<a href="users/sm/t" class="btn btn-danger">+ Tambah</a>';
            echo '<a href="users/lap_sm" class="btn btn-secondary" style="float: right;"><i class="fa fa-file"></i> Laporan</a>';
            ?>
          <?php endif; ?>
          <hr>
          <?php
          // Menyimpan nama rute yang sedang aktif dalam variabel
          $current_route = $this->router->fetch_class() . '/' . $this->router->fetch_method();
          ?>

          <form method="get" action="<?php echo site_url($current_route); ?>">
            <div class="row">
              <div class="col-xs-5">
                <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?php echo isset($_GET['tanggal']) ? htmlspecialchars($_GET['tanggal']) : date('Y-m-d'); ?>" onchange="this.form.submit()">
              </div>
              <!-- <div class="col-xs-3">
                <input type="text" name="nama_anggota" id="nama_anggota" class="form-control" value="<?php echo isset($_GET['nama_anggota']) ? htmlspecialchars($_GET['nama_anggota']) : ''; ?>" placeholder="Nama Anggota">
              </div> -->
              <div class="col-xs-5">
                <select name="sort_by" id="sort_by" class="form-control" onchange="this.form.submit()">
                  <option value="" <?php echo !isset($_GET['sort_by']) ? 'selected' : ''; ?>>Sort</option>
                  <option value="nama_anggota_asc" <?php echo isset($_GET['sort_by']) && $_GET['sort_by'] === 'nama_anggota_asc' ? 'selected' : ''; ?>>(A-Z)</option>
                  <option value="nama_anggota_desc" <?php echo isset($_GET['sort_by']) && $_GET['sort_by'] === 'nama_anggota_desc' ? 'selected' : ''; ?>>(Z-A)</option>
                </select>
              </div>

              <div class="col-xs-1">
                <a href="<?php echo site_url($current_route); ?>" class="btn btn-secondary"><i class="fa fa-refresh"></i></a>
              </div>
            </div>
          </form>
        </div>
        <div class="table-responsive">
          <table class="table datatable-basic table-striped" width="100%">
            <thead>
              <tr>
                <th width="30px;">No.</th>
                <th>Status</th>
                <!-- <th>Tanggal</th> -->
                <th>Tanggal</th>
                <th style="position: sticky; left: 0; z-index: 1; background:#fff;">Nama Anggota</th>
                <th>No. Rek</th>
                <th>Nominal</th>
                <th>Kantor</th>
                <th>Foto/Surat kuasa</th>
                <th>Keterangan</th>
                <th>Petugas</th>
                <th class="text-center" width="170"> </th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              foreach ($sm->result() as $baris) {
                // Jika level adalah 's_admin' atau 'k_admin', atau jika id_user sama dengan $id_user yang sedang digunakan, tampilkan baris data
                // Jika bukan 's_admin' atau 'k_admin', hanya tampilkan data yang memiliki id_user yang sama dengan $id_user yang sedang digunakan
                if ($level === 's_admin' || $level === 'k_admin' || $level === 'audit' || $baris->id_user == $id_user) {
              ?>
                  <tr>
                    <td><?php echo $no . '.'; ?></td>
                    <td>
                      <?php if ($baris->dibaca == 1) : ?>
                        <i class="icon-checkmark4" style="color: green;"></i>
                      <?php else : ?>
                        <i class="fa fa-refresh" aria-hidden="true" style="color: orange;"></i>
                      <?php endif; ?>
                    </td>
                    <!-- <td><?php echo date('d-m-Y H:i:s', strtotime($baris->tgl_no_asal)); ?></td> -->
                    <!-- <td><?php echo date('d-m-Y', strtotime($baris->tgl_sm)); ?></td> -->
                    <td><?php echo date('Y-m-d', strtotime($baris->tgl_sm_date)); ?></td>
                    <td style="position: sticky; left: 0; z-index: 1; background:#fff;">
                      <a href="users/sm/l/<?php echo $baris->id_sm; ?>">
                        <?php echo $baris->nama_anggota; ?>
                      </a>
                    </td>
                    <td><?php echo $baris->nomor_rekening; ?></td>
                    <td><?php echo 'Rp ' . number_format($baris->nominal, 0, ',', '.'); ?></td>
                    <td><?php echo $kodeKantorText = getKodeKantorText($baris->kode_kantor); ?></td>
                    <td>
                      <?php
                      $data_keterangan = isset($baris->keterangan) ? $baris->keterangan : ''; // Menghindari kesalahan jika properti keterangan tidak ada
                      $query_lampiran = $this->db->get_where("tbl_lampiran", array('token_lampiran' => $baris->token_lampiran));
                      foreach ($query_lampiran->result() as $lampiran) {
                        $thumbnailURL = 'lampiran/' . $lampiran->nama_berkas;
                        $keterangan = $data_keterangan; // Menggunakan variabel keterangan yang telah disiapkan sebelumnya
                      ?>
                        <a href="javascript:void(0);" onclick="openPopup('<?php echo $thumbnailURL; ?>', '<?php echo $keterangan; ?>');">
                          <img src="<?php echo $thumbnailURL; ?>" alt="Thumbnail" width="30" loading="lazy">
                        </a>
                      <?php } ?>
                      <!-- surat kuasa -->
                      <?php
                      $surat_kuasa = $this->db->get_where("tbl_file_user", array('id' => $baris->id_surat));

                      // Cek apakah ada hasil data surat kuasa
                      if ($surat_kuasa->num_rows() > 0) {
                        foreach ($surat_kuasa->result() as $surat) {
                          // Path file
                          $fileURL = 'files/file_user/' . $surat->file_name;

                          // Dapatkan ekstensi file
                          $file_extension = pathinfo($fileURL, PATHINFO_EXTENSION);

                          // Jika file adalah gambar, tampilkan thumbnail
                          if (in_array(strtolower($file_extension), ['jpg', 'jpeg', 'png', 'gif'])) {
                      ?>
                            <a href="javascript:void(0);" onclick="openPopup('<?php echo $fileURL; ?>');">
                              <img src="<?php echo $fileURL; ?>" alt="Thumbnail" width="30" loading="lazy">
                            </a>
                          <?php
                          } else {
                            // Jika file bukan gambar, tampilkan ekstensi file
                          ?>
                            <a href="<?php echo $fileURL; ?>" target="_blank">
                              <?php echo strtoupper($file_extension); // Menampilkan ekstensi file 
                              ?>
                            </a>
                      <?php
                          }
                        }
                      } else {
                        // Jika tidak ada file, tidak tampilkan apa-apa atau berikan pesan alternatif jika diperlukan.
                        echo "";
                      }
                      ?>
                    </td>
                    <td><?php echo $baris->keterangan; ?></td>

                    <td><?php echo strtoupper($baris->pengirim); ?></td>
                    <td>
                      <?php if ($level === 's_admin' || $level === 'k_admin') : ?>
                        <a href="users/sm/d/<?php echo $baris->id_sm; ?>" class="btn btn-default btn-xs authorize-btn"><i class="icon-checkmark"></i></a>
                        <a href="users/sm/e/<?php echo $baris->id_sm; ?>" class="btn btn-success btn-xs"><i class="icon-pencil"></i></a>
                        <a href="users/sm/h/<?php echo $baris->id_sm; ?>" class="btn btn-danger btn-xs delete-btn"><i class="icon-trash"></i></a>
                      <?php endif; ?>
                      <?php if ($level !== 's_admin' && $level !== 'k_admin') : ?>
                        <a href="users/sm/l/<?php echo $baris->id_sm; ?>" class="btn btn-success btn-xs"><i class="icon-eye"></i></a>
                      <?php endif; ?>
                    </td>
                  </tr>
              <?php
                }
                $no++;
              }
              ?>
            </tbody>

          </table>
        </div>
        <!-- /basic datatable -->
      </div>
    </div>
  </div>
</div>
<!-- /dashboard content -->
<script>
  // sweet alert 
  function openPopup(imageURL, keterangan) {
    Swal.fire({
      html: `<div class="popup-image-container"><div class="popup-keterangan">${keterangan}</div><img src="${imageURL}" class="popup-image" /></div>`,
      showCloseButton: true,
      showConfirmButton: false,
      customClass: {
        content: 'custom-popup-content',
        closeButton: 'custom-popup-close-button'
      }
    });
  }
  // Sweet alert 

  document.addEventListener('DOMContentLoaded', function() {
    const authorizeButtons = document.querySelectorAll('.authorize-btn');

    authorizeButtons.forEach(button => {
      button.addEventListener('click', function(event) {
        event.preventDefault();
        const targetUrl = this.getAttribute('href');

        // Menggunakan fetch() untuk menjalankan fungsi tanpa mengubah URL
        fetch(targetUrl, {
            method: 'POST' // Anda dapat mengganti metode request sesuai kebutuhan
          })
          .then(response => {
            if (response.ok) {
              // Berhasil, lakukan apa yang diperlukan
              console.log('Fungsi berhasil dijalankan');
              // Memuat ulang halaman setelah fungsi selesai dijalankan
              location.reload();
            } else {
              // Gagal, tangani kesalahan
              console.error('Terjadi kesalahan saat menjalankan fungsi');
            }
          })
          .catch(error => {
            // Tangani kesalahan jaringan atau lainnya
            console.error('Terjadi kesalahan:', error);
          });
      });
    });
  });

  document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.delete-btn');

    deleteButtons.forEach(button => {
      button.addEventListener('click', function(event) {
        event.preventDefault();
        const targetUrl = this.getAttribute('href');

        Swal.fire({
          title: 'Apakah Anda yakin?',
          text: "Tindakan ini tidak dapat diurungkan!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Ya, hapus!',
          cancelButtonText: 'Batal'
        }).then((result) => {
          if (result.isConfirmed) {
            // Mengirimkan permintaan untuk menghapus data
            fetch(targetUrl, {
                method: 'POST' // Atur metode request sesuai kebutuhan Anda
              })
              .then(response => {
                if (response.ok) {
                  // Berhasil, lakukan apa yang diperlukan
                  console.log('Data berhasil dihapus');
                  // Memuat ulang halaman setelah data dihapus
                  location.reload();
                } else {
                  // Gagal, tangani kesalahan
                  console.error('Terjadi kesalahan saat menghapus data');
                }
              })
              .catch(error => {
                // Tangani kesalahan jaringan atau lainnya
                console.error('Terjadi kesalahan:', error);
              });
          }
        });
      });
    });
  });
</script>
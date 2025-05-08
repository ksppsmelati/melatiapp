<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/css/lightbox.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/js/lightbox.min.js"></script>
<style>
  @media (min-width: 769px) {
    .content-wrapper {
      display: initial;
      /* or use 'unset' */
    }
  }
</style>
<!-- Main content -->
<div class="content-wrapper">
  <!-- Content area -->
  <div class="content">
    <div class="container">
      <!-- Vehicle Details -->
      <div class="panel panel-flat">
        <div class="panel-heading">
          <h5 class="panel-title"><i class="fa fa-car"></i> Detail Harga Kendaraan</h5>
          <br>
          <!-- <div class="text-right">
            <div class="btn-group">
              <button type="button" class="btn btn-light btn-sm">
                <a href="users/harga_kendaraan">
                  <i class="fa fa-arrow-left"></i> Kembali
                </a>
              </button>

            </div>
          </div> -->
          <div class="form-group">
            <?php
            $allowedLevels = ['kadiv_manrisk', 's_admin'];
            ?>
            <?php if (in_array($user->row()->level, $allowedLevels)): ?>
              <!-- Edit button -->
              <a href="users/harga_kendaraan/e/<?php echo $harga_kendaraan_detail->id; ?>"
                class="btn btn-success btn-xs"><i class="icon-pencil7"></i> Edit</a>

              <!-- Delete button -->
              <a href="users/harga_kendaraan/h/<?php echo $harga_kendaraan_detail->id; ?>" class="btn btn-danger btn-xs"
                onclick="return confirm('Apakah Anda yakin?')"><i class="icon-trash"></i> Hapus</a>
            <?php endif; ?>
            <br><br>
            <?php if (!empty($harga_kendaraan_detail->foto)): ?>
              <?php
              $imageURL = base_url('foto/kendaraan/' . $harga_kendaraan_detail->foto);
              ?>
              <div style="text-align: center;">
                <a href="<?php echo $imageURL; ?>" data-lightbox="gambar"
                  data-title='<p><?php echo isset($harga_kendaraan_detail->merek) ? $harga_kendaraan_detail->merek : ''; ?> <?php echo isset($harga_kendaraan_detail->model) ? $harga_kendaraan_detail->model : ''; ?> <?php echo isset($harga_kendaraan_detail->tahun) ? $harga_kendaraan_detail->tahun : ''; ?><br><br><?php echo isset($harga_kendaraan_detail->harga_jual) ? 'Rp ' . number_format($harga_kendaraan_detail->harga_jual, 0, ',', '.') : ''; ?></p>'>
                  <img src="<?php echo $imageURL; ?>" alt="Foto" style="width: 250px; height: auto; border-radius: 10px;">
                </a>
              </div>
            <?php else: ?>
              <?php
              // Jika tidak ada foto, gunakan foto default
              $imageURL = base_url('foto/kendaraan/no_image.jpg');
              ?>
              <div style="text-align: center;">
                <a href="<?php echo $imageURL; ?>" data-lightbox="gambar"
                  data-title='<p><?php echo isset($harga_kendaraan_detail->merek) ? $harga_kendaraan_detail->merek : ''; ?> <?php echo isset($harga_kendaraan_detail->model) ? $harga_kendaraan_detail->model : ''; ?> <?php echo isset($harga_kendaraan_detail->tahun) ? $harga_kendaraan_detail->tahun : ''; ?><br><br><?php echo isset($harga_kendaraan_detail->harga_jual) ? 'Rp ' . number_format($harga_kendaraan_detail->harga_jual, 0, ',', '.') : ''; ?></p>'>
                  <img src="<?php echo $imageURL; ?>" alt="Default Foto"
                    style="width: 250px; height: auto; border-radius: 10px;">
                </a>
              </div>
            <?php endif; ?>
          </div>

        </div>

        <div class="panel-body" style="display: flex; justify-content: space-between; flex-wrap: wrap;">
          <?php if ($harga_kendaraan_detail) { ?>
            <div class="harga-kendaraan-details" style="flex: 0 0 100%; max-width: 100%;">
              <div class="row" style="display: flex; flex-wrap: wrap;">
                <div class="col-xs-12 col-sm-6" style="flex: 0 0 100%; max-width: 50%;"> <!-- Add col-xs-12 here -->
                  <div class="form-group">
                    <label><strong>Merek:</strong></label>
                    <p>
                      <?php echo isset($harga_kendaraan_detail->merek) ? $harga_kendaraan_detail->merek : ''; ?>
                    </p>
                  </div>
                  <div class="form-group">
                    <label><strong>Model:</strong></label>
                    <p>
                      <?php echo isset($harga_kendaraan_detail->model) ? $harga_kendaraan_detail->model : ''; ?>
                    </p>
                  </div>
                  <div class="form-group">
                    <label><strong>Tahun:</strong></label>
                    <p>
                      <?php echo isset($harga_kendaraan_detail->tahun) ? $harga_kendaraan_detail->tahun : ''; ?>
                    </p>
                  </div>
                  <div class="form-group">
                    <label><strong>Harga Jual:</strong></label>
                    <p style="color: green;"><strong>
                        <?php echo isset($harga_kendaraan_detail->harga_jual) ? 'Rp ' . number_format($harga_kendaraan_detail->harga_jual, 0, ',', '.') : ''; ?>
                      </strong></p>
                  </div>

                </div>
                <div class="col-xs-12 col-sm-6" style="flex: 0 0 100%; max-width: 50%;"> <!-- Add col-xs-12 here -->
                  <div class="form-group">
                    <label><strong>Transmisi:</strong></label>
                    <p>
                      <?php echo isset($harga_kendaraan_detail->transmisi) ? $harga_kendaraan_detail->transmisi : ''; ?>
                    </p>
                  </div>
                  <div class="form-group">
                    <label><strong>Bahan Bakar:</strong></label>
                    <p>
                      <?php echo isset($harga_kendaraan_detail->bahan_bakar) ? $harga_kendaraan_detail->bahan_bakar : ''; ?>
                    </p>
                  </div>
                  <div class="form-group">
                    <label><strong>Kapasitas Mesin:</strong></label>
                    <p>
                      <?php echo isset($harga_kendaraan_detail->kapasitas_mesin) ? $harga_kendaraan_detail->kapasitas_mesin : ''; ?>
                      CC
                    </p>
                  </div>
                  <div class="form-group">
                    <label><strong>Jenis Kendaraan:</strong></label>
                    <p>
                      <?php echo isset($harga_kendaraan_detail->jenis_kendaraan) ? $harga_kendaraan_detail->jenis_kendaraan : ''; ?>
                    </p>
                  </div>
                  <!-- Add more details as needed -->
                </div>
              </div>
            </div>
          <?php } else { ?>
            <p>Tidak ada detail harga kendaraan yang ditemukan.</p>
          <?php } ?>
        </div>


        <?php
        $allowedLevels = ['kadiv_manrisk', 's_admin'];
        ?>
        <div class="table-responsive">
          <table class="table datatable-basic" width="100%">
            <tbody>
              <?php
              if ($similarVehicles) {
                foreach ($similarVehicles as $vehicle) {
                  ?>
                  <tr>
                    <td><a href="users/harga_kendaraan/lihat/<?php echo $vehicle->id; ?>">
                        <?php echo $vehicle->merek; ?>
                    </td>
                    </a>
                    <td>
                      <a href="users/harga_kendaraan/lihat/<?php echo $vehicle->id; ?>">
                        <?php echo $vehicle->model; ?>
                      </a>
                    </td>
                    <td><a href="users/harga_kendaraan/lihat/<?php echo $vehicle->id; ?>">
                        <strong>
                          <?php echo $vehicle->tahun; ?>
                        </strong></a>
                    </td>
                    <td><strong>
                        <a href="users/harga_kendaraan/lihat/<?php echo $vehicle->id; ?>" style="color: green;">
                          <?php echo 'Rp ' . number_format($vehicle->harga_jual, 0, ',', '.'); ?>
                      </strong></a></td>
                    <!-- Add more columns as needed -->
                  </tr>
                  <?php
                }
              } else {
                // Tampilkan pesan jika tidak ada kendaraan serupa
                ?>
                <tr>
                  <td colspan="4">Tidak ada kendaraan serupa yang ditemukan.</td>
                </tr>
                <?php
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
      <!-- /Vehicle Details -->

    </div>
  </div>
  <!-- /content area -->
  <script>
    lightbox.option({
      'resizeDuration': 200,
      'wrapAround': true
    });
  </script>

</div>
</div>
<!-- /main content -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/css/lightbox.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/js/lightbox.min.js"></script>
<!-- membuat container width 100% -->
<style>
  .container {
    width: 100%;
    margin: 0;
    padding: 0;
  }
</style>
<!-- Main content -->




<script>
  $(document).ready(function () {
    // Get the table body
    var tbody = $('table.datatable-basic tbody');

    // Get all the rows inside the tbody
    var rows = tbody.find('tr').toArray();

    // Sort the rows based on the date column (index 1)
    rows.sort(function (a, b) {
      var dateA = new Date($(a).find('td:eq(11)').text());
      var dateB = new Date($(b).find('td:eq(11)').text());

      return dateB - dateA;
    });

    // Append the sorted rows back to the table
    tbody.empty().append(rows);
  });
  lightbox.option({
    'resizeDuration': 200,
    'wrapAround': true
  });
</script>
</div>
</div>
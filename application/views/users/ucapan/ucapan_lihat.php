<style>
    label {
        font-weight: bold;
    }
</style>
<div class="container">
  <div class="content">
    <div class="row">
      <div class="panel panel-flat">
        <?php echo $this->session->flashdata('msg'); ?>
        <div class="panel-body">
          <legend class="text-bold"><i class="fa fa-eye"></i> Lihat Ucapan</legend>
          <!-- Kategori -->
          <div class="form-group">
            <label for="kategori">Kategori</label>
            <input type="text" name="kategori" class="form-control" value="<?php echo $ucapan->kategori; ?>" readonly>
          </div>

          <!-- Pesan -->
          <div class="form-group">
            <label for="isi_ucapan">Isi Ucapan</label>
            <textarea name="isi_ucapan" class="form-control" rows="3" readonly><?php echo $ucapan->isi_ucapan; ?></textarea>
          </div>

          <!-- Hari -->
          <div class="form-group">
              <label for="hari">Hari</label>
              <?php
              // Define the mapping of days in English to Indonesian
              $day_map = [
                  'Monday'    => 'Senin',
                  'Tuesday'   => 'Selasa',
                  'Wednesday' => 'Rabu',
                  'Thursday'  => 'Kamis',
                  'Friday'    => 'Jumat',
                  'Saturday'  => 'Sabtu',
                  'Sunday'    => 'Minggu'
              ];
              // Convert the day from English to Indonesian
              $hari_indonesia = isset($day_map[$ucapan->hari]) ? $day_map[$ucapan->hari] : '';
              ?>
              <input type="text" name="hari" class="form-control" value="<?php echo htmlspecialchars($hari_indonesia); ?>" readonly>
          </div>

          <!-- Tanggal Kirim -->
          <div class="form-group" style="display: none;">
            <label for="tgl_kirim">Tanggal</label>
            <input type="date" name="tgl_kirim" class="form-control" value="<?php echo $ucapan->tanggal; ?>" readonly>
          </div>

          <!-- Status -->
          <div class="form-group">
            <label for="status">Status</label>
            <input type="text" name="status" class="form-control" value="<?php echo ucfirst($ucapan->status); ?>" readonly>
          </div>

          <!-- Buttons -->
          <a href="<?php echo site_url('users/ucapan_data'); ?>" class="btn btn-default">
            << Kembali</a>
        </div>
      </div>
    </div>
  </div>
</div>

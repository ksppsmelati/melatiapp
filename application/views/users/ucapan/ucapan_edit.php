<?php
// Day mapping
$day_options = [
  'Monday'    => 'Senin',
  'Tuesday'   => 'Selasa',
  'Wednesday' => 'Rabu',
  'Thursday'  => 'Kamis',
  'Friday'    => 'Jumat',
  'Saturday'  => 'Sabtu',
  'Sunday'    => 'Minggu'
];

// Get current day in English
$current_day = date('l');
?>
<style>
    label {
        font-weight: bold;
    }
</style>
<div class="container">
  <div class="content">
    <div class="row">
      <div class="col-md-1"></div>
      <div class="panel panel-flat">
        <?php echo $this->session->flashdata('msg'); ?>
        <div class="panel-body">
          <legend class="text-bold"><i class="fa fa-pencil"></i> Edit Ucapan</legend>
          <?php echo form_open('users/ucapan_update/' . $ucapan->id_ucapan); ?>

          <!-- Kategori -->
          <div class="form-group">
            <label for="kategori">Kategori</label>
            <select name="kategori" class="form-control" required>
              <option value="" disabled <?php echo empty($ucapan->kategori) ? 'selected' : ''; ?>>Pilih Kategori</option>
              <option value="Masuk" <?php echo $ucapan->kategori == 'Masuk' ? 'selected' : ''; ?>>Masuk</option>
              <option value="Pulang" <?php echo $ucapan->kategori == 'Pulang' ? 'selected' : ''; ?>>Pulang</option>
            </select>
          </div>

          <!-- Pesan -->
          <div class="form-group">
            <label for="pesan">Isi Ucapan</label>
            <textarea name="isi_ucapan" class="form-control" rows="3" required><?php echo $ucapan->isi_ucapan; ?></textarea>
          </div>

          <div class="form-group">
            <label for="hari">Hari</label>
            <select name="hari" class="form-control" required>
              <option value="" disabled <?php echo empty($ucapan->hari) ? 'selected' : ''; ?>>Pilih Hari</option>
              <?php foreach ($day_options as $value => $label) : ?>
                <option value="<?php echo $value; ?>" <?php echo $value == $ucapan->hari ? 'selected' : ''; ?>>
                  <?php echo $label; ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Tanggal Kirim -->
          <div class="form-group" style="display: none;">
            <label for="tgl_kirim">Tanggal</label>
            <input type="date" name="tgl_kirim" class="form-control" value="<?php echo $ucapan->tanggal; ?>" required>
          </div>

          <!-- Status -->
          <div class="form-group">
            <label for="status">Status</label>
            <select name="status" class="form-control" required>
              <option value="aktif" <?php echo $ucapan->status == 'aktif' ? 'selected' : ''; ?>>Aktif</option>
              <option value="nonaktif" <?php echo $ucapan->status == 'nonaktif' ? 'selected' : ''; ?>>Nonaktif</option>
            </select>
          </div>

          <!-- Buttons -->
          <a href="users/ucapan_data" class="btn btn-default">
            << Kembali</a>
              <button type="submit" class="btn btn-danger" style="float:right;">Update</button>
              <?php echo form_close(); ?>
        </div>
      </div>
    </div>
  </div>
</div>
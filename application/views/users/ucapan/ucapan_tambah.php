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
            <div class="panel panel-flat col-md-9">
                <?php echo $this->session->flashdata('msg'); ?>
                <div class="panel-body">
                    <legend class="text-bold"><i class="fa fa-comments"></i> Tambah Ucapan</legend>
                    <?php echo form_open('users/ucapan_submit'); ?>

                    <div class="form-group">
                        <label for="kategori">Kategori</label>
                        <select name="kategori" class="form-control" required>
                            <option value="" disabled selected>Pilih Kategori</option>
                            <option value="Masuk">Masuk</option>
                            <option value="Pulang">Pulang</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="isi_ucapan">Isi Ucapan</label>
                        <textarea name="isi_ucapan" class="form-control" rows="3" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="hari">Hari</label>
                        <select name="hari" class="form-control" required>
                            <?php foreach ($day_options as $value => $label) : ?>
                                <option value="<?php echo $value; ?>" <?php echo $value == $current_day ? 'selected' : ''; ?>>
                                    <?php echo $label; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group" style="display: none;">
                        <label for="tgl_kirim">Tanggal</label>
                        <input type="date" name="tgl_kirim" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>

                    <a href="users/ucapan_data" class="btn btn-default">
                        << Kembali</a>
                            <button type="submit" name="btnsimpan" class="btn btn-danger" style="float:right;">Simpan</button>
                            <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
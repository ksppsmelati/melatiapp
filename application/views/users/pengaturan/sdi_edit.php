<?php
$user = $query;
$tgl_masuk = strtotime($user->tgl_daftar);
$current_date = time();

// Calculate the difference in seconds
$time_difference = $current_date - $tgl_masuk;

// Calculate the number of years and months
$years = floor($time_difference / (365 * 24 * 60 * 60));
$months = floor(($time_difference % (365 * 24 * 60 * 60)) / (30 * 24 * 60 * 60));
?>

<style>
    .evaluasi-perlu {
        background-color: #f8d7da;
        /* Merah muda */
        color: #721c24;
        /* Warna teks merah gelap */
    }

    .evaluasi-sudah {
        background-color: #d4edda;
        /* Hijau muda */
        color: #155724;
        /* Warna teks hijau gelap */
    }
</style>
<!-- Tambahkan CSS Summernote -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.css" rel="stylesheet">

<!-- Tambahkan script Summernote dan jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

<!-- Main content -->
<div class="container">
    <!-- Content area -->
    <div class="content">
        <!-- Dashboard content -->
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <fieldset class="content-group">
                        <legend class="text-bold"><i class="icon-user"></i> Edit Karyawan</legend>
                        <?php
                        echo $this->session->flashdata('msg');
                        ?>
                        <form class="form-horizontal" action="" method="post">
                            <div class="form-group">
                                <label class="control-label col-lg-3">Nama</label>
                                <div class="col-lg-9">
                                    <input type="text" name="username" class="form-control" value="<?php echo isset($user->username) ? $user->username : ''; ?>" placeholder="username" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-3">Tgl Lahir</label>
                                <div class="col-lg-9">
                                    <input type="date" name="tgl_lahir" class="form-control" value="<?php echo $user->tgl_lahir; ?>" placeholder="Tanggal Lahir">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-3">Telp</label>
                                <div class="col-lg-9">
                                    <input type="text" name="telp" class="form-control" value="<?php echo $user->telp; ?>" placeholder="Telepon" maxlength="30">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-3">E-mail</label>
                                <div class="col-lg-9">
                                    <input type="text" name="email" class="form-control" value="<?php echo $user->email; ?>" placeholder="E-mail" maxlength="30">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-3">Tgl Masuk</label>
                                <div class="col-lg-9">
                                    <input type="text" name="tgl_daftar" class="form-control" value="<?php echo $user->tgl_daftar; ?>" placeholder="tanggal masuk" maxlength="30">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-3">Pendidikan</label>
                                <div class="col-lg-9">
                                    <select name="jenjang_pen" class="form-control">
                                        <option value="">Pilih Jenjang Pendidikan</option>
                                        <option value="SD" <?php echo ($user->jenjang_pen == 'SD') ? 'selected' : ''; ?>>SD</option>
                                        <option value="SMP" <?php echo ($user->jenjang_pen == 'SMP') ? 'selected' : ''; ?>>SMP</option>
                                        <option value="SMA/SMK" <?php echo ($user->jenjang_pen == 'SMA/SMK') ? 'selected' : ''; ?>>SMA/SMK</option>
                                        <option value="Diploma" <?php echo ($user->jenjang_pen == 'Diploma') ? 'selected' : ''; ?>>Diploma</option>
                                        <option value="Sarjana" <?php echo ($user->jenjang_pen == 'Sarjana') ? 'selected' : ''; ?>>Sarjana</option>
                                        <option value="Magister" <?php echo ($user->jenjang_pen == 'Magister') ? 'selected' : ''; ?>>Magister</option>
                                        <option value="Doktor" <?php echo ($user->jenjang_pen == 'Doktor') ? 'selected' : ''; ?>>Doktor</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-3">Jurusan</label>
                                <div class="col-lg-9">
                                    <input type="text" name="jurusan_pen" class="form-control" value="<?php echo $user->jurusan_pen; ?>" placeholder="Jurusan Pendidikan" maxlength="30">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-3">Sisa Cuti</label>
                                <div class="col-lg-9">
                                    <input type="number" name="sisa_cuti" class="form-control" value="<?php echo $user->sisa_cuti; ?>" placeholder="Sisa Cuti" maxlength="30">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-3">Evaluasi</label>
                                <div class="col-lg-9">
                                    <select name="evaluasi" class="form-control" id="evaluasiSelect">
                                        <option value="0" <?php echo ($user->evaluasi == 0) ? 'selected' : ''; ?>>Perlu Evaluasi</option>
                                        <option value="1" <?php echo ($user->evaluasi == 1) ? 'selected' : ''; ?>>Sudah Evaluasi</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-3">Performa</label>
                                <div class="col-lg-9">
                                    <select name="performa" class="form-control">
                                        <?php
                                        $ratings = array(
                                            1 => 'Sangat Buruk',
                                            2 => 'Buruk',
                                            3 => 'Rata-rata',
                                            4 => 'Baik',
                                            5 => 'Sangat Baik'
                                        );

                                        // Loop untuk membuat opsi dengan deskripsi
                                        foreach ($ratings as $value => $description) {
                                            // Periksa apakah nilai saat ini sama dengan nilai performa pengguna
                                            $selected = ($value == $user->performa) ? 'selected' : '';
                                            echo '<option value="' . $value . '" ' . $selected . '>' . $description . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-3">Alamat</label>
                                <div class="col-lg-9">
                                    <textarea name="alamat" class="form-control" placeholder="Alamat" maxlength="300"><?php echo $user->alamat; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-3">Sertifikasi</label>
                                <div class="col-lg-9">
                                    <textarea name="pengalaman" class="form-control" placeholder="Sertifikasi" maxlength="300"><?php echo $user->pengalaman; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-3">Pesan <i class="fa fa-envelope" style="font-size: 10px;"></i></label>
                                <div class="col-lg-9">
                                    <textarea name="pesan" class="form-control" placeholder="Pesan" maxlength="300"><?php echo $user->pesan; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-3">Notifikasi <i class="fa fa-bullhorn" style="font-size: 10px;"></i></label>
                                <div class="col-lg-9">
                                    <textarea name="notifikasi" class="form-control" placeholder="Notifikasi" maxlength="300"><?php echo $user->notifikasi; ?></textarea>
                                </div>
                            </div>

                            <a href="users/sdi" class="btn btn-default">
                                << Kembali</a>
                                    <button type="submit" name="btnupdate" class="btn btn-danger" style="float:right;">Update</button>
                        </form>

                    </fieldset>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /dashboard content -->
<script>
    $(document).ready(function() {
        // Inisialisasi Summernote pada textarea dengan nama "pesan"
        $('textarea[name=pesan]').summernote({
            height: 200, // Atur tinggi editor sesuai kebutuhan
        });
    });

    $(document).ready(function() {
        // Mengubah warna dropdown berdasarkan nilai yang dipilih
        function updateEvaluasiColor() {
            var selectedValue = $('#evaluasiSelect').val();
            if (selectedValue == '0') {
                $('#evaluasiSelect').removeClass('evaluasi-sudah').addClass('evaluasi-perlu');
            } else {
                $('#evaluasiSelect').removeClass('evaluasi-perlu').addClass('evaluasi-sudah');
            }
        }

        // Panggil fungsi untuk mengatur warna berdasarkan nilai awal
        updateEvaluasiColor();

        // Panggil fungsi saat nilai dropdown berubah
        $('#evaluasiSelect').change(function() {
            updateEvaluasiColor();
        });
    });
</script>
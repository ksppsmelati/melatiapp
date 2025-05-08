<style>
    label {
        font-weight: bold;
    }
</style>
<!-- Main content -->
<div class="container">
    <!-- Content area -->
    <div class="content">
        <?php echo $this->session->flashdata('msg'); ?>
        <!-- Form tambah data blokir -->
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <div class="navigation-buttons">
                        <i class="fa fa-lock"></i> Tambah Data Blokir

                        <div class="btn-group" style="float: right;">
                            <!-- Tombol Dropdown (di pojok kanan atas) -->
                            <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bars"></i>
                            </button>
                            <!-- Isi Dropdown -->
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <li><a href="<?php echo site_url('users/blokir'); ?>"><i class="fa fa-plus"></i> Tambah Data Blokir</a></li>
                                <li><a href="<?php echo site_url('users/data_blokir'); ?>"><i class="fa fa-unlock-alt"></i> Data Proses Blokir</a></li>
                                <li><a href="<?php echo site_url('users/data_blokir_selesai'); ?>"><i class="fa fa-lock"></i> Data Selesai Blokir</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Membersihkan float -->
                    <div class="clearfix"></div>
                    <form action="<?php echo site_url('users/simpan_blokir'); ?>" method="post" enctype="multipart/form-data">
                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label for="tanggal">Tanggal Effektif:</label>
                                <input type="date" class="form-control" name="tanggal" id="tanggal" required>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label for="nama">Nama Anggota:</label>
                                <input type="text" class="form-control" name="nama" id="nama" required>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label for="no_rek">Nomor Rekening:</label>
                                <input type="number" class="form-control" name="no_rek" id="no_rek" required>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label for="jumlah">Nominal Blokir:</label>
                                <input type="number" class="form-control" name="jumlah" id="jumlah" required>
                            </div>
                        </div>

                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label for="nomor_blokir">Nomor Blokir:</label>
                                <input type="number" class="form-control" name="nomor_blokir" id="nomor_blokir" required>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6" style="display: none;">
                            <div class="form-group">
                                <label for="petugas">Petugas:</label>
                                <input type="text" class="form-control" name="petugas" id="petugas" value="<?php echo $this->session->userdata('username'); ?>" required readonly="">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6">
                            <div class="form-group">
                                <label for="kantor">Kantor:</label>
                                <select class="form-control" name="kantor" id="kantor" required>
                                    <option value="01">PUSAT</option>
                                    <option value="02">SEDAYU</option>
                                    <option value="03">SAPURAN</option>
                                    <option value="04">KERTEK</option>
                                    <option value="05">WONOSOBO</option>
                                    <option value="06">KALIWIRO</option>
                                    <option value="07">BANJARNEGARA</option>
                                    <option value="08">RANDUSARI</option>
                                    <option value="09">KEPIL</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12">
                            <div class="form-group">
                                <label for="keterangan">Keterangan:</label>
                                <textarea class="form-control" name="keterangan" id="keterangan" rows="4" required></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-danger" style="float:right;">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Form tambah data kerusakan -->
    </div>
</div>

<script>
    // Fungsi untuk mengatur tanggal default dan mengisi otomatis kolom "Petugas" dari session
    function setDefaultDateAndPetugas() {
        // Mengatur tanggal default
        var today = new Date();
        var year = today.getFullYear();
        var month = String(today.getMonth() + 1).padStart(2, '0'); // Tambahkan 1 karena bulan dimulai dari 0
        var day = String(today.getDate()).padStart(2, '0');
        var formattedDate = year + '-' + month + '-' + day;
        document.getElementById('tanggal').value = formattedDate;

        // Mengisi otomatis kolom "Petugas" dari session
        var petugas = '<?php echo $this->session->userdata('username'); ?>';
        document.getElementById('petugas').value = petugas;
    }

    // Panggil fungsi setDefaultDateAndPetugas() saat halaman dimuat
    window.onload = setDefaultDateAndPetugas;
</script>
<!-- Main content -->
<div class="content-wrapper">
    <!-- Content area -->
    <div class="content">
        <?php echo $this->session->flashdata('msg'); ?>
        <div class="container">
            <!-- Form edit data blokir -->
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-flat">
                        <div class="panel-body">
                            <div class="navigation-buttons">
                                <i class="fa fa-lock"></i> Edit Data Blokir
                            </div>
                            <!-- Membersihkan float -->
                            <div class="clearfix"></div>
                            <form action="<?php echo site_url('users/update_blokir/' . $blokir['id']); ?>" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="tanggal">Tanggal:</label>
                                    <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?php echo date('Y-m-d', strtotime($blokir['tanggal'])); ?>" required readonly>
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama Anggota:</label>
                                    <input type="text" class="form-control" name="nama" id="nama" value="<?php echo $blokir['nama']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="kantor">Kantor:</label>
                                    <select class="form-control" name="kantor" id="kantor" required>
                                        <?php
                                        // Array asosiatif kode kantor dan nama kantor
                                        $kantorOptions = array(
                                            '01' => 'PUSAT',
                                            '02' => 'SEDAYU',
                                            '03' => 'SAPURAN',
                                            '04' => 'KERTEK',
                                            '05' => 'WONOSOBO',
                                            '06' => 'KALIWIRO',
                                            '07' => 'BANJARNEGARA',
                                            '08' => 'RANDUSARI',
                                            '09' => 'KEPIL'
                                        );

                                        // Loop untuk membuat opsi
                                        foreach ($kantorOptions as $kode => $kantor) {
                                            $selected = ($blokir['kantor'] == $kode) ? 'selected' : ''; // Perbaikan disini: mengubah $kerusakan menjadi $blokir
                                            echo "<option value=\"$kode\" $selected>$kantor</option>"; // Perbaikan disini: mengubah $blokir menjadi $kode
                                        }
                                        ?>
                                    </select>

                                </div>

                                <div class="form-group">
                                    <label for="no_rek">Nomor Rekening:</label>
                                    <input type="number" class="form-control" name="no_rek" id="no_rek" value="<?php echo $blokir['no_rek']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah">Nominal Blokir:</label>
                                    <input type="number" class="form-control" name="jumlah" id="jumlah" value="<?php echo $blokir['jumlah']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan:</label>
                                    <textarea class="form-control" name="keterangan" id="keterangan" rows="4" required><?php echo $blokir['keterangan']; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="nomor_blokir">Nomor Blokir:</label>
                                    <input type="number" class="form-control" name="nomor_blokir" id="nomor_blokir" value="<?php echo $blokir['nomor_blokir']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="petugas">Petugas:</label>
                                    <input type="text" class="form-control" name="petugas" id="petugas" value="<?php echo $blokir['petugas']; ?>" required readonly="">
                                </div>
                                <div class="form-group">
                                    <label for="status">Status:</label>
                                    <select class="form-control" name="status" id="status">
                                        <option value="proses" <?php if ($blokir['status'] == 'proses') echo 'selected'; ?>>Proses</option>
                                        <option value="done" <?php if ($blokir['status'] == 'done') echo 'selected'; ?>>Done</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-danger" style="float:right;">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Form edit data kerusakan -->
        </div>
    </div>
    <!-- /content area -->
</div>
<!-- /main content -->
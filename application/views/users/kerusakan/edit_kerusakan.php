<!-- Main content -->
<div class="container">
    <!-- Content area -->
    <div class="content">
        <?php echo $this->session->flashdata('msg'); ?>
        <!-- Form edit data kerusakan -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-flat">
                    <div class="panel-body">
                        <div class="navigation-buttons">
                            <i class="fa fa-warning"></i> Edit Data Kerusakan
                        </div>
                        <!-- Membersihkan float -->
                        <div class="clearfix"></div>
                        <form action="<?php echo site_url('users/update_kerusakan/' . $kerusakan['id']); ?>" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="tanggal">Tanggal:</label>
                                <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?php echo date('Y-m-d', strtotime($kerusakan['tanggal'])); ?>" required readonly>
                            </div>
                            <div class="form-group">
                                <label for="petugas">Petugas:</label>
                                <input type="text" class="form-control" name="petugas" id="petugas" value="<?php echo $kerusakan['petugas']; ?>" required readonly="">
                            </div>
                            <div class="form-group">
                                <label for="kantor">Kantor:</label>
                                <select class="form-control" name="kantor" id="kantor" required readonly>
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
                                    foreach ($kantorOptions as $kode => $nama) {
                                        $selected = ($kerusakan['kantor'] == $kode) ? 'selected' : '';
                                        echo "<option value='$kode' $selected>$nama</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="kerusakan">Kerusakan:</label>
                                <textarea class="form-control" name="kerusakan" id="kerusakan" rows="4" required readonly><?php echo $kerusakan['kerusakan']; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="foto_kerusakan">Foto Kerusakan:</label>

                                <?php if (!empty($kerusakan['foto_kerusakan'])) : ?>
                                    <?php
                                    $thumbnailURL = base_url('foto/kerusakan/' . $kerusakan['foto_kerusakan']);
                                    ?>
                                    <div class="text-center">
                                        <a href="javascript:void(0);" onclick="openPopup('<?php echo $thumbnailURL; ?>');">
                                            <img src="<?php echo $thumbnailURL; ?>" alt="Current Kerusakan Photo" class="mx-auto" width="100">
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="tindakan">Tindakan:</label>
                                <textarea class="form-control" name="tindakan" id="tindakan" rows="4"><?php echo $kerusakan['tindakan']; ?></textarea>
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
    <!-- /content area -->
</div>
<!-- /main content -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    function openPopup(imageURL) {
        Swal.fire({
            html: `<img src="${imageURL}" class="popup-image" style="width: 100%;" />`,
            showCloseButton: true,
            showConfirmButton: false,
            customClass: {
                content: 'custom-popup-content',
                closeButton: 'custom-popup-close-button'
            }
        });
    }
</script>
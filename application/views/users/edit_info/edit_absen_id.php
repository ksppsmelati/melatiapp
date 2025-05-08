<?php
$cek = $user->row();
$chuser = $cek->id_user;
?>
<div class="container">
    <div class="content">
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <fieldset class="content-group">
                        <legend class="text-bold"><i class="icon-pencil"></i> Edit Data Absen</legend>

                        <!-- Form edit data absen -->
                        <form action="<?= base_url('users/update_absen/') . $absen['id_absen']; ?>" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="id_user"><strong>Nama:</strong> </label>
                                        <input type="text" class="form-control" id="id_user" name="nama_lengkap" value="<?= $absen['nama_lengkap']; ?>" readonly>
                                        <input type="hidden" name="id_user" value="<?= $absen['id_user']; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="tgl"><strong>Tanggal:</strong></label>
                                        <input type="date" class="form-control" id="tgl" name="tgl" value="<?= $absen['tgl']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="waktu"><strong>Waktu:</strong></label>
                                        <input type="time" class="form-control" id="waktu" name="waktu" value="<?= $absen['waktu']; ?>">
                                    </div>

                                    <div class="form-group">
                                        <input type="hidden" class="form-control" id="chuser" name="chuser" value="<?= $absen['chuser']; ?>">
                                    </div>

                                    <div class="form-group">
                                        <input type="hidden" class="form-control" id="jns_absen" name="jns_absen" value="2">
                                    </div>

                                    <div class="form-group">
                                        <input type="hidden" class="form-control" id="latitude" name="latitude" value="<?= $absen['latitude']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" class="form-control" id="longitude" name="longitude" value="<?= $absen['longitude']; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="keterangan"><strong>Status:</strong></label>
                                        <select class="form-control" id="keterangan" name="keterangan">
                                            <option value="Masuk" <?= ($absen['keterangan'] == 'Masuk') ? 'selected' : ''; ?> style="color: green;">Masuk</option>
                                            <option value="Pulang" <?= ($absen['keterangan'] == 'Pulang') ? 'selected' : ''; ?> style="color: orange;">Pulang</option>
                                            <option value="Izin" <?= ($absen['keterangan'] == 'Izin') ? 'selected' : ''; ?> style="color: blue;">Izin</option>
                                            <option value="Cuti" <?= ($absen['keterangan'] == 'Cuti') ? 'selected' : ''; ?> style="color: grey;">Cuti</option>
                                            <option value="Sakit" <?= ($absen['keterangan'] == 'Sakit') ? 'selected' : ''; ?> style="color: red;">Sakit</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="foto_absen"><strong>Foto Absen:</strong></label><br>
                                        <?php
                                        // Ambil nama file foto_absen dari data absen
                                        $foto_absen = $absen['foto_absen'];

                                        // Buat URL lengkap untuk thumbnail
                                        $thumbnailURL = './foto/foto_absen/absensi/' . $foto_absen;

                                        // Jika file foto_absen tidak kosong, tampilkan thumbnail
                                        if (!empty($foto_absen) && file_exists($thumbnailURL)) {
                                        ?>
                                            <img src="<?php echo $thumbnailURL; ?>" alt="Thumbnail" width="30">
                                        <?php
                                        } else {
                                            echo "";
                                        }
                                        ?>
                                        <input type="file" class="form-control" id="foto_absen" name="foto_absen" accept="image/*" onchange="previewImage(event, 'preview1')">
                                        <div class="preview-container">
                                            <img id="preview1" class="img-preview" alt="Preview foto_absen" style="display: none;" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="lampiran"><strong>Lampiran:</strong></label><br>
                                        <?php
                                        $lampiran = $absen['lampiran'];

                                        $thumbnailURL = './foto/foto_absen/' . $lampiran;

                                        if (!empty($lampiran) && file_exists($thumbnailURL)) {
                                        ?>
                                            <img src="<?php echo $thumbnailURL; ?>" alt="Thumbnail" width="30">
                                        <?php
                                        } else {
                                            echo "";
                                        }
                                        ?>
                                        <input type="file" class="form-control" id="lampiran" name="lampiran" accept="image/*" onchange="previewImage(event, 'preview2')">
                                        <div class="preview-container">
                                            <img id="preview2" class="img-preview" alt="Preview lampiran" style="display: none;" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="keterangan_absen"><strong>Keterangan:</strong></label>
                                        <textarea class="form-control" id="keterangan_absen" name="keterangan_absen"><?= $absen['keterangan_absen']; ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <a href="users/edit_absen" class="btn btn-default">
                                        << Kembali</a>
                                            <button type="submit" class="btn btn-danger" style="float:right;">Update</button>
                                </div>
                            </div>
                        </form>

                    </fieldset>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/compressorjs@1.0.7/dist/compressor.min.js"></script>

<script>
    document.querySelectorAll('input[type="file"]').forEach(function(input) {
        input.addEventListener('change', function(event) {
            const file = event.target.files[0];

            if (file) {
                // Gunakan Compressor.js untuk melakukan kompresi
                new Compressor(file, {
                    quality: 0.3, // Menyesuaikan kualitas kompresi (0 - 1)
                    success(result) {
                        // Membuat nama file unik dengan menggabungkan timestamp dan nama input
                        const inputName = input.getAttribute('name');
                        const timestamp = Date.now();
                        const fileExtension = file.name.split('.').pop(); // Ekstensi file asli
                        const uniqueFileName = inputName + '_' + timestamp + '.' + fileExtension; // Nama file unik
                        const compressedFile = new File([result], uniqueFileName, {
                            type: result.type,
                            lastModified: timestamp
                        });
                        // Gantikan file input dengan file yang sudah dikompres
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(compressedFile);
                        input.files = dataTransfer.files; // Mengganti file di input
                        console.log('File berhasil dikompres dengan nama unik:', compressedFile);
                    },
                    error(err) {
                        console.error('Gagal melakukan kompresi:', err.message);
                    },
                });
            }
        });
    });

    function previewImage(event, previewId) {
        const file = event.target.files[0];
        const previewElement = document.getElementById(previewId);

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewElement.src = e.target.result; // Set src dari preview ke hasil pembacaan
                previewElement.style.display = 'block'; // Tampilkan gambar preview
            }
            reader.readAsDataURL(file); // Baca file sebagai Data URL
        } else {
            previewElement.src = ""; // Kosongkan src jika tidak ada file
            previewElement.style.display = 'none'; // Sembunyikan gambar preview
        }
    }
</script>
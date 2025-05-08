<?php
$cek = $user->row();
$level = $cek->level;
$username = $cek->username;
$id_user = $cek->id_user;
$kode_kantor = $cek->kode_kantor;
$nama_lengkap = $cek->nama_lengkap;
?>

<style>
    .file-upload-group {
        margin-bottom: 10px;
    }

    .img-preview {
        display: block;
        margin-top: 10px;
        margin-bottom: 10px;
        max-width: 100%;
        height: auto;
        border: 1px solid #ddd;
        border-radius: 4px;
        max-height: 100px;
        transition: all 0.3s ease;
    }

    .preview-container {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    input[type="file"] {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 10px;
        background-color: #f9f9f9;
        transition: border 0.3s ease;
    }

    input[type="file"]:focus {
        border-color: #007bff;
        outline: none;
    }

    .form-group label {
        font-weight: bold;
    }
</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.css">
<script src="assets/js/select2.min.js"></script>
<script src="assets/js/jquery-ui.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.js"></script>



<div class="container">
    <div class="content">
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <fieldset class="content-group">
                        <div class="navigation-buttons">
                            <div class="btn-group" style="float: left;">
                                <i class="fa fa-television"></i> Tambah SP
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr>

                        <form class="form-horizontal" id="myForm" action="users/sp_simpan" enctype="multipart/form-data" method="post">
                            <div class="row">
                                <div class="clearfix"></div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">No SP</label>
                                        <div class="col-md-9">
                                            <input type="text" name="nomor_sp" id="nomor_sp" class="form-control" readonly required>
                                            <input type="hidden" id="last_id" value="<?= $last_id; ?>">
                                        </div>
                                    </div>
                                </div>
                                <!-- Nokontrak -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Nokontrak</label>
                                        <div class="col-md-9">
                                            <input type="text" name="nokontrak" id="nokontrak" class="form-control" value="<?= $sp_data->nokontrak ?? ''; ?>" required readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">No Akad</label>
                                        <div class="col-md-9">
                                            <input type="text" name="noakad" id="noakad" class="form-control" value="<?= $sp_data->noakad ?? ''; ?>" required readonly>
                                        </div>
                                    </div>
                                </div>

                                <!-- Nama Anggota -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Nama Anggota</label>
                                        <div class="col-md-9">
                                            <input type="text" name="nama" id="nama" class="form-control" value="<?= $sp_data->nama ?? ''; ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Alamat -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Alamat</label>
                                        <div class="col-md-9">
                                            <input type="text" name="alamat" id="alamat" class="form-control" value="<?= $sp_data->alamat ?? ''; ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Kantor</label>
                                        <div class="col-md-9">
                                            <input type="text" name="kantor" id="kantor" class="form-control" value="<?= getKodeKantorText($sp_data->kdloc); ?>">
                                            <input type="hidden" name="kdloc" id="kdloc" value="<?= $sp_data->kdloc; ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Tgl Akad</label>
                                        <div class="col-md-9">
                                            <input type="text" name="tglakad" id="tglakad" class="form-control" value="<?= $sp_data->tglakad ?? ''; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Jenis SP</label>
                                        <div class="col-md-9">
                                            <select name="jenis_sp" id="jenis_sp" class="form-control" required>
                                                <option value="SP1">SP 1</option>
                                                <option value="SP2">SP 2</option>
                                                <option value="SP3">SP 3</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Jenis Dokumen</label>
                                        <div class="col-md-9">
                                            <input type="text" name="nama_jnsdokumen" id="nama_jnsdokumen" class="form-control" value="<?= getJenisDokumenText($sp_data->jnsdokumen) ?? ''; ?>">
                                            <input type="hidden" name="jnsdokumen" id="jnsdokumen" class="form-control" value="<?= $sp_data->jnsdokumen ?? ''; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">TTD</label>
                                        <div class="col-md-9">
                                            <input type="text" name="ttd" id="ttd" class="form-control" value="<?= $sp_data->ttd ?? ''; ?>">
                                        </div>
                                    </div>
                                </div>

                                <!-- Inpuser -->
                                <div class="col-md-6" style="display: none;">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Inpuser</label>
                                        <div class="col-md-9">
                                            <input type="text" name="inpuser" id="inpuser" class="form-control" required readonly value="<?php echo $nama_lengkap; ?>">
                                        </div>
                                    </div>
                                </div>

                                <!-- Tanggal -->
                                <div class="col-md-6" style="display: none;">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Tgl Input</label>
                                        <div class="col-md-9">
                                            <input type="date" name="tgl_input" id="tgl_input" class="form-control" value="<?php echo date('Y-m-d'); ?>" required readonly>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tanggal Jatuh Tempo -->
                                <div class="col-md-6" style="display: none;">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Tgl Jatuh Tempo</label>
                                        <div class="col-md-9">
                                            <input type="text" name="tglexp" id="tglexp" class="form-control" value="<?= $sp_data->tglexp ?? ''; ?>" required readonly>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- Button Simpan -->
                            <div class="form-group">
                                <div class="col-md-12 text-right">
                                    <button type="submit" id="submitButton" class="btn btn-danger">Simpan</button>
                                </div>
                            </div>
                        </form>
                        <div id="loadingSpinner" style="display: none; text-align: center; padding: 10px;">
                            <i class="fa fa-spinner fa-spin" style="font-size: 24px;"></i> Processing...
                        </div>
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

    document.getElementById('myForm').addEventListener('submit', function(event) {
        // Disable the submit button to prevent double submission
        document.getElementById('submitButton').disabled = true;

        // Show loading spinner
        document.getElementById('loadingSpinner').style.display = 'block';

        // Optionally, you can also show a loading message
        document.getElementById('submitButton').textContent = 'Processing...';

        // Allow the form to submit normally
    });

    document.addEventListener('DOMContentLoaded', function() {
        const jenisSpSelect = document.getElementById('jenis_sp');
        const nomorSpInput = document.getElementById('nomor_sp');
        const lastId = parseInt(document.getElementById('last_id').value || 0);

        function toRoman(month) {
            const roman = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
            return roman[month - 1];
        }

        function generateNomorSp() {
            const jenisSp = jenisSpSelect.value;
            const nextId = lastId + 1;
            const now = new Date();
            const romawi = toRoman(now.getMonth() + 1);
            const tahun = now.getFullYear();
            const nomorSp = `${String(nextId).padStart(3, '0')}/${jenisSp}/KSPPSMLT/${romawi}/${tahun}`;
            nomorSpInput.value = nomorSp;
        }

        jenisSpSelect.addEventListener('change', generateNomorSp);
        generateNomorSp(); // Jalankan saat pertama kali load
    });
</script>
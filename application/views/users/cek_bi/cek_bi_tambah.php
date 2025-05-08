<?php
$cek = $user->row();
$id_user = $cek->id_user;
$kode_kantor = $cek->kode_kantor;
?>
<style>
    label {
        font-weight: bold;
    }

    label {
        font-weight: bold;
    }

    /* Style for the map container */
    #map-container {
        width: 100%;
        height: 400px;
        /* Fixed height for the map container */
        position: relative;
        margin-top: 15px;
        /* Space between input and map */
        margin-bottom: 20px;
        /* Space below the map */
    }

    /* Style for the map itself */
    #map {
        width: 100%;
        /* Full width of the container */
        height: 100%;
        /* Full height of the container */
        border-radius: 10px;
    }

    /* Ensure map looks good on mobile devices */
    @media (max-width: 768px) {
        #map-container {
            height: 300px;
            /* Smaller height for mobile devices */
        }
    }

    /* Add margin to the bottom of the input for spacing */
    .form-group {
        margin-bottom: 15px;
    }

    /* Optional: Ensure clearfix to prevent overlap issues */
    .clearfix::after {
        content: "";
        clear: both;
        display: table;
    }

    .suggestions-box {
        /* border: 1px solid #ccc; */
        background-color: white;
        max-height: 200px;
        overflow-y: auto;
        position: absolute;
        z-index: 1000;
        width: calc(100% - 20px);
        /* Adjust to fit */
        margin-top: -1px;
        /* Align with input */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    .suggestion-item {
        padding: 10px;
        cursor: pointer;
    }

    .suggestion-item:hover {
        background-color: #f0f0f0;
    }

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
</style>
<div class="container">
    <div class="content">
        <?php echo $this->session->flashdata('msg'); ?>
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <div class="navigation-buttons">
                        <i class="fa fa-file-text"></i> Tambah Cek BI
                        <div class="btn-group" style="float: right;">
                            <!-- Tombol Dropdown (di pojok kanan atas) -->
                            <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bars"></i>
                            </button>
                            <!-- Isi Dropdown -->
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <li><a href="users/cek_bi_tambah"><i class="fa fa-plus"></i> Tambah Cek BI</a>
                                </li>
                                <li><a href="users/cek_bi_data"><i class="fa-solid fa-file-import"></i> Data Cek BI</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- Membersihkan float -->
                    <div class="clearfix"></div>
                    <hr>
                    <div class="card-body">
                        <form method="post" enctype="multipart/form-data" action="<?php echo site_url('users/cek_bi_simpan'); ?>" id="myForm">
                            <div class="row">
                                <input class="form-control" type="hidden" name="id_user" value="<?php echo htmlspecialchars($id_user); ?>" required>
                                <!-- <input class="form-control" type="hidden" name="kode_kantor" value="<?php echo htmlspecialchars($kode_kantor); ?>" required> -->
                                <div class="col-xs-12 col-sm-12">
                                    <div style="float: right;">
                                        <div class="form-group">
                                            <label for="kode_kantor">Kantor<span style="color: red;">*</span></label><br>
                                            <select class="form-control" name="kode_kantor" id="kode_kantor" required>
                                                <option value="" <?php echo ($kode_kantor == '') ? 'selected' : ''; ?>>- Pilih Kantor -</option>
                                                <option value="01" <?php echo ($kode_kantor == '01') ? 'selected' : ''; ?>>PUSAT</option>
                                                <option value="02" <?php echo ($kode_kantor == '02') ? 'selected' : ''; ?>>SEDAYU</option>
                                                <option value="03" <?php echo ($kode_kantor == '03') ? 'selected' : ''; ?>>SAPURAN</option>
                                                <option value="04" <?php echo ($kode_kantor == '04') ? 'selected' : ''; ?>>KERTEK</option>
                                                <option value="05" <?php echo ($kode_kantor == '05') ? 'selected' : ''; ?>>WONOSOBO</option>
                                                <option value="06" <?php echo ($kode_kantor == '06') ? 'selected' : ''; ?>>KALIWIRO</option>
                                                <option value="07" <?php echo ($kode_kantor == '07') ? 'selected' : ''; ?>>BANJARNEGARA</option>
                                                <option value="08" <?php echo ($kode_kantor == '08') ? 'selected' : ''; ?>>RANDUSARI</option>
                                                <option value="09" <?php echo ($kode_kantor == '09') ? 'selected' : ''; ?>>KEPIL</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="form_nama">Nama<span style="color: red;">*</span></label>
                                        <input class="form-control" type="text" name="nama" required placeholder="Nama lengkap">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="form_nik">NIK<span style="color: red;">*</span></label>
                                        <input class="form-control" type="text" name="nik" required placeholder="Nomor Induk Kependudukan" maxlength="16" oninput="validateNIK(this)">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="tgl_lahir">Tanggal Lahir<span style="color: red;">*</span></label>
                                        <input class="form-control" type="date" name="tgl_lahir" required>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="tempat_lahir">Tempat Lahir<span style="color: red;">*</span></label>
                                        <input class="form-control" type="text" name="tempat_lahir" required placeholder="Tempat Lahir">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="jk">Jenis Kelamin<span style="color: red;">*</span></label>
                                        <select class="form-control" name="jk" required>
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="L">Laki-laki</option>
                                            <option value="P">Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="form_pekerjaan">Pekerjaan<span style="color: red;">*</span></label>
                                        <input class="form-control" type="text" name="pekerjaan" required placeholder="Pekerjaan">
                                    </div>
                                </div>

                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="foto_ktp">Foto KTP<span style="color: red;">*</span></label>
                                        <input type="file" name="foto_ktp" id="foto_ktp" class="form-control" accept="image/*" onchange="previewImage(event, 'preview1')" required>
                                        <div class="preview-container">
                                            <img id="preview1" class="img-preview" alt="Preview foto_ktp" style="display: none;" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="jns_alamat">Jenis Alamat <span style="color: red;">*</span></label>
                                        <select name="jns_alamat" id="jns_alamat" class="form-control" required>
                                            <option value="" selected>Pilih Jenis Alamat</option>
                                            <option value="RUMAH">RUMAH</option>
                                            <option value="KANTOR">KANTOR</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="form_alamat">Dusun, RT/RW <span style="color: red;">*</span></label>
                                        <input class="form-control" type="text" name="alamat" required placeholder="Dusun RT/RW" oninput="capitalizeFirstLetter(this)">
                                    </div>
                                </div>
                                <!-- Dropdown Provinsi -->
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="provinsi">Provinsi<span style="color: red;">*</span></label>
                                        <select class="form-control" id="provinsi" name="provinsi" required>
                                            <option value="" selected>Pilih Provinsi</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Dropdown Kota/Kabupaten -->
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="kota_kabupaten">Kota / Kabupaten<span style="color: red;">*</span></label>
                                        <select class="form-control" id="kota_kabupaten" name="kota_kabupaten" required>
                                            <option value="" disable selected>Pilih Kota / Kabupaten</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Dropdown Kecamatan -->
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="kecamatan">Kecamatan<span style="color: red;">*</span></label>
                                        <select class="form-control" id="kecamatan" name="kecamatan" required>
                                            <option value="" selected>Pilih Kecamatan</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Dropdown Kelurahan -->
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="kelurahan">Kelurahan / Desa<span style="color: red;">*</span></label>
                                        <select class="form-control" id="kelurahan" name="kelurahan" required>
                                            <option value="" selected>Pilih Kelurahan / Desa</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Input Kode Pos -->
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="kode_pos">Kode Pos<span style="color: red;">*</span></label>
                                        <input class="form-control" type="text" name="kode_pos" id="kode_pos" required placeholder="Kode Pos">
                                    </div>
                                </div>

                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="negara">Negara<span style="color: red;">*</span></label>
                                        <input class="form-control" type="text" name="negara" required placeholder="Negara" value="INDONESIA">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="form_nama_ibu">Nama Ibu<span style="color: red;">*</span></label>
                                        <input class="form-control" type="text" name="nama_ibu" required placeholder="Nama Ibu">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="status_kawin">Status Kawin<span style="color: red;">*</span></label>
                                        <select class="form-control" name="status_kawin" id="status_kawin" required>
                                            <option value="">-- Pilih Status Kawin --</option>
                                            <option value="Belum Kawin">Belum Kawin</option>
                                            <option value="Kawin">Kawin</option>
                                            <option value="Cerai">Cerai</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="status_pendidikan">Status Pendidikan<span style="color: red;">*</span></label>
                                        <select class="form-control" name="status_pendidikan" id="status_pendidikan" required>
                                            <option value="">-- Pilih Status Pendidikan --</option>
                                            <option value="Tidak Sekolah">Tidak Sekolah</option>
                                            <option value="SD">SD</option>
                                            <option value="SMP">SMP</option>
                                            <option value="SMA">SMA</option>
                                            <option value="Diploma">Diploma</option>
                                            <option value="Sarjana">Sarjana</option>
                                            <option value="Magister">Magister</option>
                                            <option value="Doktor">Doktor</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="form_hp">No. Telepon<span style="color: red;">*</span></label>
                                        <input class="form-control" type="tel" name="telepon" required placeholder="Masukkan nomor telepon ( *Pastikan nomor benar dan bisa dihubungi )" onkeypress="return onlyNumberKey(event)" maxlength="13">
                                    </div>
                                </div>

                            </div>
                            <div class="col-xs-12 col-sm-12">
                                <div class="form-group" style="float: right;">
                                    <label for="cek_req">Persetujuan BI Checking<span style="color: red;">*</span></label>
                                    <select class="form-control" id="cek_req" name="cek_req" required>
                                        <option value="">Pilih</option>
                                        <option value="1">Ya, Setuju</option>
                                        <option value="0">Tidak / Nanti</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Bagian Tanda Tangan yang disembunyikan secara default -->
                            <div class="col-xs-12 col-sm-12" id="signatureSection" style="display: none;">
                                <div class="signature-container" style="text-align: center;">
                                    <canvas id="signature-pad" width="300" height="200" style="border: 1px solid #000; border-radius: 10px;"></canvas>
                                    <p><small>Tanda tangan anggota untuk persetujuan BI Checking.</small></p>
                                    <button type="button" id="clear" class="btn btn-muted mt-2">Hapus</button>
                                </div>

                                <input type="hidden" name="ttd" id="ttd"> <!-- Tidak perlu required -->

                            </div>
                            <div class="col-xs-12 col-sm-12">
                                <button class="btn btn-danger" type="submit" id="submitButton" style="float: right;">Kirim</button>
                            </div>
                    </div>
                    </form>
                    <div id="loadingSpinner" style="display: none; text-align: center; padding: 10px;">
                        <i class="fa fa-spinner fa-spin" style="font-size: 24px;"></i> Processing...
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/compressorjs@1.0.7/dist/compressor.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.umd.min.js"></script>


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

        $(document).ready(function() {
            // Inisialisasi Select2
            $('#provinsi, #kota_kabupaten, #kecamatan, #kelurahan, #status_kawin, #status_pendidikan, #kode_kantor, #jangka_waktu').select2({
                allowClear: false,
                placeholder: "Pilih"
            });

            // Memuat data provinsi dari API
            $.ajax({
                url: 'https://ibnux.github.io/data-indonesia/provinsi.json',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    var provinsiData = [];
                    $.each(data, function(key, val) {
                        provinsiData.push({
                            id: val.id,
                            text: val.nama
                        });
                    });

                    // Memasukkan data ke Select2 Provinsi
                    $('#provinsi').select2({
                        data: provinsiData
                    });
                }
            });

            // Ketika provinsi dipilih, ambil data kota/kabupaten
            $('#provinsi').change(function() {
                var provinsiID = $(this).val();
                if (provinsiID) {
                    $('#kota_kabupaten').prop('disabled', false);

                    // Ambil data kota/kabupaten berdasarkan provinsi
                    $.ajax({
                        url: 'https://ibnux.github.io/data-indonesia/kabupaten/' + provinsiID + '.json',
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            var kotaKabupatenData = [];
                            $.each(data, function(key, val) {
                                kotaKabupatenData.push({
                                    id: val.id,
                                    text: val.nama
                                });
                            });

                            // Masukkan data kota/kabupaten ke Select2
                            $('#kota_kabupaten').empty().select2({
                                data: kotaKabupatenData
                            });
                        }
                    });
                }
            });

            // Ketika kota/kabupaten dipilih, ambil data kecamatan
            $('#kota_kabupaten').change(function() {
                var kotaKabupatenID = $(this).val();
                if (kotaKabupatenID) {
                    $('#kecamatan').prop('disabled', false);

                    // Ambil data kecamatan berdasarkan kota/kabupaten
                    $.ajax({
                        url: 'https://ibnux.github.io/data-indonesia/kecamatan/' + kotaKabupatenID + '.json',
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            var kecamatanData = [];
                            $.each(data, function(key, val) {
                                kecamatanData.push({
                                    id: val.id,
                                    text: val.nama
                                });
                            });

                            // Masukkan data kecamatan ke Select2
                            $('#kecamatan').empty().select2({
                                data: kecamatanData
                            });
                        }
                    });
                }
            });

            // Ketika kecamatan dipilih, ambil data kelurahan
            $('#kecamatan').change(function() {
                var kecamatanID = $(this).val();
                if (kecamatanID) {
                    $('#kelurahan').prop('disabled', false);

                    // Ambil data kelurahan berdasarkan kecamatan
                    $.ajax({
                        url: 'https://ibnux.github.io/data-indonesia/kelurahan/' + kecamatanID + '.json',
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            var kelurahanData = [];
                            $.each(data, function(key, val) {
                                kelurahanData.push({
                                    id: val.id,
                                    text: val.nama,
                                    kodePos: val.kodePos
                                });
                            });

                            // Masukkan data kelurahan ke Select2
                            $('#kelurahan').empty().select2({
                                data: kelurahanData
                            });
                        }
                    });
                }
            });

            // Ketika kelurahan dipilih, tampilkan kode pos
            // $('#kelurahan').change(function() {
            //     var selectedOption = $(this).find(':selected');
            //     var kodePos = selectedOption.data('kodePos');
            //     $('#kode_pos').val(kodePos ? kodePos : ''); 
            // });

            $('#kelurahan').change(function() {
                var kelurahan = $(this).find(':selected').text(); // Mengambil nama kelurahan terpilih

                if (kelurahan) {
                    // Memanggil API untuk mencari kode pos berdasarkan nama kelurahan
                    $.ajax({
                        url: 'https://kodepos.vercel.app/search?q=' + kelurahan, // API pencarian kode pos
                        type: 'GET',
                        success: function(response) {
                            if (response.statusCode === 200 && response.data.length > 0) {
                                var kodePos = response.data[0].code; // Ambil kode pos dari hasil pertama
                                $('#kode_pos').val(kodePos); // Isi input kode pos
                            } else {
                                alert("Kode Pos tidak ditemukan untuk kelurahan tersebut.");
                                $('#kode_pos').val(''); // Kosongkan jika tidak ditemukan
                            }
                        },
                        error: function() {
                            alert("Gagal mengambil data kode pos. Silakan coba lagi.");
                            $('#kode_pos').val('');
                        }
                    });
                }
            });
        });

        $(document).ready(function() {
            // Perubahan warna untuk semua input text
            $('input').on('input', function() {
                if ($(this).val() === "") {
                    $(this).css({
                        'background-color': '#ffe6e6'
                    });
                } else {
                    $(this).css({
                        'background-color': '#e6ffe6'
                    });
                }
            });

            // Perubahan warna untuk elemen select biasa
            $('select').on('change', function() {
                if ($(this).val() === "") {
                    $(this).css({
                        'background-color': '#ffe6e6'
                    });
                } else {
                    $(this).css({
                        'background-color': '#e6ffe6'
                    });
                }
            });

            // Perubahan warna untuk elemen select yang menggunakan Select2
            $('select').on('select2:select select2:unselect', function(e) {
                var select2Element = $(this).next('.select2-container').find('.select2-selection');
                if ($(this).val() === "") {
                    select2Element.css({
                        'background-color': '#ffe6e6'
                    });
                } else {
                    select2Element.css({
                        'background-color': '#e6ffe6'
                    });
                }
            });
        });

        function capitalizeFirstLetter(input) {
            let words = input.value.split(' ');
            for (let i = 0; i < words.length; i++) {
                words[i] = words[i].charAt(0).toUpperCase() + words[i].slice(1).toLowerCase();
            }
            input.value = words.join(' ');
        }

        function validateNIK(input) {
            // Hanya memperbolehkan angka
            input.value = input.value.replace(/\D/g, '');

            // Batasi panjang maksimum input menjadi 16 karakter
            if (input.value.length > 16) {
                input.value = input.value.slice(0, 16);
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
            const cekReq = document.getElementById('cek_req');
            const signatureSection = document.getElementById('signatureSection');
            const canvas = document.getElementById('signature-pad');
            const clearButton = document.getElementById('clear');
            const ttdInput = document.getElementById('ttd');
            const ctx = canvas.getContext('2d');
            let drawing = false;

            // Fungsi untuk mulai menggambar
            canvas.addEventListener('mousedown', function() {
                drawing = true;
                ctx.beginPath();
            });

            canvas.addEventListener('mouseup', function() {
                drawing = false;
            });

            canvas.addEventListener('mousemove', function(event) {
                if (drawing) {
                    const rect = canvas.getBoundingClientRect();
                    const x = event.clientX - rect.left;
                    const y = event.clientY - rect.top;
                    ctx.lineTo(x, y);
                    ctx.strokeStyle = 'black'; // Tanda tangan hitam
                    ctx.lineWidth = 2;
                    ctx.stroke();
                }
            });

            // Untuk perangkat touch (mobile)
            canvas.addEventListener('touchstart', function() {
                drawing = true;
                ctx.beginPath();
            });

            canvas.addEventListener('touchend', function() {
                drawing = false;
            });

            canvas.addEventListener('touchmove', function(event) {
                const touch = event.touches[0];
                const rect = canvas.getBoundingClientRect();
                const x = touch.clientX - rect.left;
                const y = touch.clientY - rect.top;
                if (drawing) {
                    ctx.lineTo(x, y);
                    ctx.strokeStyle = 'black';
                    ctx.lineWidth = 2;
                    ctx.stroke();
                }
            });

            // Menonaktifkan scroll saat menggambar di canvas (Desktop & Mobile)
            canvas.addEventListener('touchmove', function(event) {
                event.preventDefault(); // Mencegah scroll pada perangkat mobile
            }, {
                passive: false
            });

            // Mencegah scroll dengan mouse (desktop)
            canvas.addEventListener('wheel', function(event) {
                event.preventDefault(); // Mencegah scroll dengan mouse
            }, {
                passive: false
            });

            // Show signature section if "Ya, Setuju" is selected
            cekReq.addEventListener('change', function() {
                if (cekReq.value == '1') {
                    signatureSection.style.display = 'block'; // Tampilkan elemen tanda tangan
                } else {
                    signatureSection.style.display = 'none'; // Sembunyikan elemen tanda tangan
                    ctx.clearRect(0, 0, canvas.width, canvas.height); // Bersihkan canvas
                    ttdInput.value = ''; // Kosongkan input hidden
                }
            });

            // Clear signature pad
            clearButton.addEventListener('click', function() {
                ctx.clearRect(0, 0, canvas.width, canvas.height); // Bersihkan canvas
                ttdInput.value = ''; // Kosongkan input hidden
            });

            // Save signature as base64 but not required
            document.getElementById('myForm').addEventListener('submit', function() {
                // Simpan tanda tangan sebagai base64 jika "Ya, Setuju" dipilih
                if (cekReq.value == '1') {
                    ttdInput.value = canvas.toDataURL('image/png'); // Simpan tanda tangan sebagai base64
                }
            });
        });
    </script>
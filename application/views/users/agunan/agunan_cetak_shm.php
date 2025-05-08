<title><?php echo $agunan->no_kontrak; ?></title>
<?php
$url = site_url('users/agunan_lihat_shm/' . $agunan->id);
$qrCodeUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=' . urlencode($url);
?>
<style type="text/css">
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
    }

    .container {
        /* top: 100px; */
        /* max-width: 600px; */
        /* margin: 0 auto; */
        position: relative;
    }

    .qr-code {
        position: absolute;
        top: 20px;
        right: 20px;
    }

    .content {
        padding: 20px;
    }

    .form-group {
        /* margin-bottom: 10px; */
    }

    .form-group label {
        font-weight: bold;
        display: inline-block;
        width: 150px;
    }

    .form-group input {
        border: none;
        border-bottom: 1px solid #000;
        width: calc(100% - 160px);
        display: inline-block;
    }

    @media print {
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            font-size: 12px;
            /* padding: 20px; */
            background-color: #f5f5f5;
        }

        .container {
            /* max-width: 280px; */
            /* margin: 0 auto; */
            background-color: #fff;
            /* border: 1px solid #000; */
            padding-top: 10px;
        }

        .qr-code {
            top: 10px;
            right: 20px;
        }

        .content {
            padding: 0;
        }

        .form-group input {
            border: none;
            /* border-bottom: 1px solid #ddd; */
            width: calc(100% - 160px);
            font-size: 12px;
            display: inline-block;
            padding: 5px 10px;
            background-color: transparent;
        }

        .form-group textarea {
            width: 100%;
            /* Set width to 100% of the container */
            white-space: pre-wrap;
            /* Preserve whitespace and line breaks */
            resize: none;
            /* Disable resizing */
            overflow: auto;
            /* Allow scrolling if content overflows */
            border: none;
            /* Remove border if not needed */
            border-bottom: 1px dashed #000;
            /* Add border bottom if needed */
            box-sizing: border-box;
            /* Ensure padding and border are included in width */
        }

        .form-group label {
            width: 70px;
            font-size: 12px;
            display: inline-block;
            vertical-align: top;
        }
    }
</style>

<div class="container">
    <div class="qr-code">
        <img src="<?php echo $qrCodeUrl; ?>" alt="QR Code">
    </div>
    <div class="content">
        <form>
            <div class="form-group">
                <label>ID</label>
                <input type="text" value="<?php echo $agunan->id; ?>" readonly>
            </div>
            <div class="form-group">
                <label>No. Reg</label>
                <input type="text" value="<?php echo $agunan->no_registrasi; ?>" readonly>
            </div>
            <div class="form-group">
                <label>No. Kontrak</label>
                <input type="text" value="<?php echo $agunan->no_kontrak; ?>" readonly>
            </div>

            <div class="form-group">
                <label>Tgl. Masuk</label>
                <input type="text" value="<?php echo $agunan->tgl_masuk; ?>" readonly>
            </div>

            <!-- <div class="form-group">
                <label>Kantor</label>
                <?php
                $kantorNames = array(
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

                $kode_kantor = $agunan->kode_kantor;

                if (isset($kantorNames[$kode_kantor])) {
                    echo '<input type="text" value="' . $kantorNames[$kode_kantor] . '" readonly>';
                } else {
                    echo '<input type="text" value="' . $kode_kantor . '" readonly>';
                }
                ?>
            </div> -->

            <div class="form-group">
                <label>Anggota</label>
                <input type="text" value="<?php echo $agunan->nama_anggota; ?>" readonly>
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <input type="text" value="<?php echo $agunan->alamat; ?>" readonly>
            </div>
            <div class="form-group">
                <label>Atas Nama</label>
                <input type="text" value="<?php echo $agunan->atas_nama; ?>" readonly>
            </div>
            <div class="form-group">
                <label>Lokasi Jamnian</label>
                <input type="text" value="<?php echo $agunan->lokasi_jaminan; ?>" readonly>
            </div>
            <!-- <div class="form-group">
                <label>Jumlah Jaminan</label>
                <input type="text" value="<?php echo $jumlah_jaminan; ?>" readonly>
            </div> -->
            <br>
            <div class="form-group">
                <label>Keterangan</label>
                <textarea readonly><?php echo $agunan->keterangan; ?></textarea>
            </div>

            <!-- <div class="form-group">
                <label>Jenis Jaminan</label>
                <?php
                $jenisJaminanNames = array(
                    '1' => 'KENDARAAN RODA 2 (FE0)',
                    '2' => 'KENDARAAN RODA 2 (NOTRAIL)',
                    '3' => 'KENDARAAN RODA 2 (BT)',
                    '4' => 'KENDARAAN RODA 4 (FE0)',
                    '5' => 'KENDARAAN RODA 4 (NOTRAIL)',
                    '6' => 'KENDARAAN RODA 4 (BT)',
                    '7' => 'TANAH DAN BANGUNAN (SKMHT)',
                    '8' => 'TANAH DAN BANGUNAN (APHT)',
                    '9' => 'TANAH DAN BANGUNAN (NOTARIS)',
                    '10' => 'TANAH DAN BANGUNAN (BT)',
                    '11' => 'EMAS',
                    '12' => 'DEPOSITO/TABUNGAN',
                    '13' => 'KENDARAAN RODA 2 (KUASA JUAL BELI)',
                    '14' => 'KENDARAAN RODA 4 (KUASA JUAL BELI)',
                    '15' => 'TANAH DAN BANGUNAN (KUASA JUAL BELI)',
                    '16' => 'SK INSTITUSI/LEMBAGA',
                    '99' => 'LAINNYA'
                );

                $kode_jenis_jaminan = $agunan->jenis_jaminan;

                if (isset($jenisJaminanNames[$kode_jenis_jaminan])) {
                    echo '<input type="text" value="' . $jenisJaminanNames[$kode_jenis_jaminan] . '" readonly>';
                } else {
                    echo '<input type="text" value="' . $kode_jenis_jaminan . '" readonly>';
                }
                ?>
            </div> -->

            <!-- <div class="form-group">
                <label>Jenis Dokumen</label>
                <?php
                $jenisDokumenNames = array(
                    '1' => 'SHM',
                    '2' => 'SHM A/Rusun',
                    '3' => 'SHGB',
                    '4' => 'SHP',
                    '5' => 'SHGU',
                    '6' => 'BPKB',
                    '7' => 'AJB',
                    '8' => 'BILYET DEPOSITO',
                    '9' => 'BUKU TABUNGAN',
                    '10' => 'CEK',
                    '11' => 'BILYET GIRO',
                    '12' => 'SURAT PERNYATAAN & KUASA',
                    '13' => 'INVOICE / FAKTUR',
                    '14' => 'SIPTB',
                    '15' => 'DOKUMEN KONTAK',
                    '16' => 'SAHAM',
                    '17' => 'OBLIGASI',
                    '18' => 'SK INSTITUSI/LEMBAGA',
                    '19' => 'LAIN-LAIN',
                    '20' => 'LETTER C/GIRIK',
                    '21' => 'KARTU PASAR'
                );

                $kode_jenis_dokumen = $agunan->jenis_dokumen;

                if (isset($jenisDokumenNames[$kode_jenis_dokumen])) {
                    echo '<input type="text" value="' . $jenisDokumenNames[$kode_jenis_dokumen] . '" readonly>';
                } else {
                    echo '<input type="text" value="' . $kode_jenis_dokumen . '" readonly>';
                }
                ?>
            </div> -->
        </form>
    </div>
</div>

<!-- Skrip untuk memunculkan popup cetak -->
<script type="text/javascript">
    window.onload = function() {
        window.print();
    };
</script>
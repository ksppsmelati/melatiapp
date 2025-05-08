<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $cek_bi->nama; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* @page {
            size: A4;
            margin: 0;
        } */
        body {
            font-family: "Times New Roman", serif;
            font-size: 16px;
            line-height: 1.5;
            color: #333;
            position: relative;
            min-height: 100vh;
            /* Menjamin body mencakup seluruh tinggi halaman */
            padding-top: 1cm;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .container {
            /* margin: 0 auto; */
            /* Margin kanan kiri 0 dan center dengan 'auto' */
            max-width: 100%;
            /* Memungkinkan konten memenuhi seluruh lebar */
            text-align: center;
            /* Membuat teks rata tengah */
        }

        .social-icons {
            position: absolute;
            right: 30px;
            /* Jarak dari kanan */
            text-align: right;
            /* Menyesuaikan teks di kanan */
        }

        .social-icons ul {
            list-style: none;
            /* Menghilangkan bullet point */
            padding: 0;
            margin: 0;
        }

        .social-icons li {
            margin: 0;
            padding: 0;
            line-height: 1;
            /* Menghilangkan jarak antar baris */
        }

        .social-icons small {
            font-size: 11px;
            /* Ukuran teks kecil */
            color: #f64747;
        }

        .social-icons i {
            font-size: 11px;
            /* Ukuran ikon kecil */
            color: #f64747;
            margin-left: 5px;
        }

        .header img {
            width: 150px;
            /* Ukuran logo */
        }

        .table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            padding: 8px;
            text-align: left;
            border: none;
            /* Menghilangkan garis batas */
            line-height: 0.5;
        }

        .table th {
            background-color: #f2f2f2;
        }

        .footer {
            margin-top: 40px;
            text-align: right;
            position: relative;
        }

        .footer img {
            width: 100%;
            height: auto;
            display: block;
            /* Pastikan gambar tampil sebagai blok */
            margin-top: -100px;
        }

        .footer .signature p {
            margin-top: 5px;
            text-align: center;
        }

        /* Tambahan CSS untuk meratakan teks */
        .text-justify {
            text-align: justify;
            /* Meratakan teks */
        }

        .info-table {
            width: 100%;
            margin-bottom: 20px;
            line-height: 0.5;
        }

        .info-table td {
            padding: 5px;
        }

        .info-table .label {
            text-align: left;
            width: 20%;
            /* Tentukan lebar label */
        }

        .info-table .value {
            text-align: left;
        }

        .footer .signature {
            float: right;
            text-align: center;
            margin-top: 50px;
        }

        .footer .signature img {
            max-width: 150px;
            display: block;
            margin-bottom: 5px;
        }
    </style>
</head>

<body onload="window.print();">
    <div class="container">
        <div class="header">
            <img src="<?php echo base_url($logo); ?>" alt="Logo">
            <div class="social-icons">
                <ul>
                    <li><small>ksppsmelati </small><i class="fab fa-instagram"></i></li>
                    <li><small>KSPPS Melati </small><i class="fab fa-facebook"></i></li>
                    <li><small>KSPPS Melati </small><i class="fab fa-youtube"></i></li>
                    <li><small>www.bmtmelati.com </small><i class="fa fa-globe"></i></li>
                </ul>
            </div>
        </div>
        <div class="clearfix"></div>
        <br>
        <h2 style="text-align: center;">SURAT PERNYATAAN</h2>
        <br>
        <table class="info-table">
            <tr>
                <td class="label"><strong>Surat</strong></td>
                <td class="value"><span>:</span>
                    <?php
                    if (!empty($cek_bi->tgl_cek_bi)) {
                        echo date('Ymd', strtotime($cek_bi->tgl_cek_bi)) . '_MLT' . $cek_bi->id;
                    } else {
                        echo 'MLT' . $cek_bi->id;
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td class="label"><strong>Hal</strong></td>
                <td class="value"><span>:</span> Surat Pernyataan</td>
            </tr>
        </table>
        <div class="row">
            <div class="col-md-12">
                <p class="text-justify">Dengan ini saya, yang bertanda tangan di bawah ini:</p>
                <table class="table">
                    <tr>
                        <th>Nama Lengkap</th>
                        <td><span>: </span><?php echo $cek_bi->nama; ?></td>
                    </tr>
                    <tr>
                        <th>No Identitas (KTP)</th>
                        <td><span>: </span><?php echo $cek_bi->nik; ?></td>
                    </tr>
                    <tr>
                        <th>Tempat Tanggal Lahir</th>
                        <td><span>: </span><?php echo $cek_bi->tempat_lahir . ", " . date('d-m-Y', strtotime($cek_bi->tgl_lahir)); ?></td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td><span>: </span><?php echo $cek_bi->alamat; ?> <?php echo $cek_bi->kelurahan_nama; ?> <?php echo $cek_bi->kecamatan_nama; ?></td>
                    </tr>
                    <tr>
                        <th>No. Telp</th>
                        <td><span>: </span><?php echo $cek_bi->telepon; ?></td>
                    </tr>
                    <tr>
                        <th>Pekerjaan</th>
                        <td><span>: </span><?php echo $cek_bi->pekerjaan; ?></td>
                    </tr>
                </table>

                <p class="text-justify">Menyatakan bahwa semua informasi yang saya berikan dalam pengajuan kredit ini adalah benar dan sesuai dengan keadaan yang sebenarnya.</p>
                <p class="text-justify">Saya juga memahami dan menyetujui bahwa data saya dapat digunakan dan diverifikasi oleh Biro Kredit (CLIK) yang bekerjasama dengan KSPPS Melati untuk keperluan analisis kredit, termasuk pengecekan pada Sistem Informasi Debitur (SID) oleh CLIK atau lembaga lainya yang berwenang.</p>
                <p class="text-justify">Saya memberikan izin kepada KSPPS Melati untuk melakukan pengecekan terhadap data saya, baik didalam maupun diluar lembaga ini, guna menilai kelayakan pengajuan kredit saya. Saya juga memahami bahwa hasil pengecekan data ini akan mempengaruhi keputusan pemberian kredit oleh KSPPS Melati.</p>
            </div>
        </div>

        <div class="footer">
            <p style="text-align: right; margin-right: 0px;">
                <?php
                $kota = isset($cek_bi->kota_nama) ? $cek_bi->kota_nama : '';
                $kota_clean = str_replace('KAB. ', '', $kota);

                echo $kota_clean;
                ?>,
                <!-- ........................., -->
                <?php
                $bulanIndonesia = [
                    1 => 'Januari',
                    2 => 'Februari',
                    3 => 'Maret',
                    4 => 'April',
                    5 => 'Mei',
                    6 => 'Juni',
                    7 => 'Juli',
                    8 => 'Agustus',
                    9 => 'September',
                    10 => 'Oktober',
                    11 => 'November',
                    12 => 'Desember'
                ];

                if (isset($cek_bi->tgl_cek_bi)) {
                    $tanggal = strtotime($cek_bi->tgl_cek_bi);
                    $hari = date('d', $tanggal);
                    $bulan = $bulanIndonesia[(int)date('m', $tanggal)];
                    $tahun = date('Y', $tanggal);
                    echo $hari . ' ' . $bulan . ' ' . $tahun;
                } else {
                    echo '......................';
                }
                ?>&nbsp;
            </p><br>
            <div class="signature" style="position: absolute; right: 0; z-index: 10; text-align: center;">
                <?php
                $ttd = isset($cek_bi->ttd) ? $cek_bi->ttd : '';
                $signatureURL = base_url('foto/foto_cek_bi/foto_ttd/' . $ttd);
                if (!empty($ttd)) {
                ?>
                    <img src="<?php echo $signatureURL; ?>" alt="Signature" style="max-width: 150px;">
                <?php } else { ?>
                    <!-- <p style="color: red;">No signature available.</p> -->
                <?php } ?>
                <p>( <?php echo $cek_bi->nama; ?> )</p>
            </div>
            <br>
            <img src="<?php echo base_url('foto/footer_flip.png'); ?>" alt="Footer Image" style="position: relative; bottom: 0; left: 0; width: 100%; z-index: 1; margin: 0;">
            <!-- <img src="<?php echo base_url('foto/footer_flip.png'); ?>" alt="Footer Image" style="position: relative; z-index: 1;"> -->
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
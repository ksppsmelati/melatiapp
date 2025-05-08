<?php
$cek = $user->row();
$level = $cek->level;
$nama_lengkap = $cek->nama_lengkap;
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Peringatan - <?php echo strtoupper($sp_data->nama); ?></title>
    <style>
        @media print {
            @page {
                size: A4;
                margin: 0cm;
            }

            body {
                margin: 0;
            }
        }

        body {
            font-family: "Times New Roman", serif;
            font-size: 14.5px; /* KECILKAN sedikit font */
            line-height: 1.4; /* PERKECIL spasi antarbaris */
            color: #000;
            margin: 2cm;
        }

        .text-right {
            text-align: right;
        }

        .text-justify {
            text-align: justify;
        }

        .text-center {
            text-align: center;
        }

        .mt-1 {
            margin-top: 8px;
        }

        .mt-2 {
            margin-top: 15px;
        }

        .signature {
            margin-top: 60px;
            float: right;
            text-align: center;
        }

        .signature img {
            max-width: 130px;
            margin-bottom: 5px;
        }

        .kop {
            text-align: right;
            margin-bottom: 30px;
        }

        .info {
            margin-bottom: 25px;
        }

        p {
            margin: 4px 0;
        }

        .no-print {
            display: none;
        }
    </style>
</head>

<body onload="window.print();">
    <div class="kop">
        <img src="<?php echo base_url($logo); ?>" alt="Logo" width="130">
    </div>

    <!-- Nomor & Hal -->
    <div class="info">
        <p><strong>No</strong> : <?php echo $sp_data->noakad; ?></p>
        <p><strong>Hal</strong> : SURAT PERINGATAN 3 (TIGA)</p>
    </div>

    <!-- Penerima -->
    <div class="mt-1">
        <p>Kepada</p>
        <p><strong>Yth. Sdr. <?php echo strtoupper($sp_data->nama); ?></strong></p>
        <p>di <?php echo strtoupper($sp_data->alamat); ?></p>
    </div>

    <!-- Isi Surat -->
    <div class="mt-2 text-justify">
        <p>Assalamualaikum warahmatullahi wabarakatuh.</p>

        <p>Dengan Hormat,</p>

        <p>Semoga Bapak/Ibu selalu berada dalam bimbingan dan lindungan dari Allah SWT. Aamiin.</p>

        <p>
            Tanpa mengurangi kepercayaan dan rasa hormat kami kepada Bapak/Ibu, dengan ini kami informasikan bahwa angsuran pembiayaan Bapak/Ibu seharusnya paling lambat tanggal 15 pada setiap bulannya.
        </p>

        <p>
            Perlu Bapak/Ibu ketahui bahwa dana pembiayaan tersebut berasal dari dana titipan umat yang dipercayakan kepada kami, oleh karena itu kami harap Bapak/Ibu untuk segera hadir ke Kantor KSPPS Melati guna menyelesaikan tunggakan angsuran pembiayaan tersebut.
        </p>

        <p>
            Demikian pemberitahuan dari kami. Atas perhatian dan kerjasamanya kami mengucapkan banyak terima kasih.
        </p>

        <p>Wassalamu’alaikum warahmatullahi wabarakatuh.</p>
    </div>

    <!-- Catatan -->
    <div class="mt-2">
        <p><strong>Nb.</strong></p>
        <p>Abaikan surat ini jika Anda sudah melakukan pembayaran.</p>
        <p>Mohon surat ini dibawa saat datang ke Kantor KSPPS Melati.</p>
    </div>

    <!-- Tanggal dan Penandatangan -->
    <div class="mt-2 text-right">
        <?php
        $bulanIndonesia = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        $tanggal = isset($sp_data->tgl_cek_bi) ? strtotime($sp_data->tgl_cek_bi) : time();
        $hari = date('d', $tanggal);
        $bulan = $bulanIndonesia[(int)date('m', $tanggal)];
        $tahun = date('Y', $tanggal);

        $kota = isset($sp_data->kota_nama) ? $sp_data->kota_nama : 'Wonosobo';
        $kota_clean = str_replace('KAB. ', '', strtoupper($kota));
        echo "<p>$kota_clean, $hari $bulan $tahun</p>";
        echo "<p>KSPPS Melati</p>";
        ?>
    </div>

    <!-- Tanda Tangan -->
    <div class="signature">
        <?php
        $ttd = isset($sp_data->ttd) ? $sp_data->ttd : '';
        if (!empty($ttd)) :
            $signatureURL = base_url('foto/foto_usulan/foto_ttd/' . $ttd);
        ?>
            <img src="<?php echo $signatureURL; ?>" alt="TTD">
        <?php endif; ?>
        <p>( <?php echo $nama_lengkap; ?> )</p>
        <p>Account Officer</p>
    </div>
</body>

</html>

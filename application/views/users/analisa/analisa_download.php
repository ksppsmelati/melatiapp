<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Pernyataan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: "Times New Roman", serif;
            font-size: 16px;
            line-height: 1.5;
            color: #333;
            padding: 1cm 0; /* Top and bottom padding, no left/right */
            margin: 0; /* Remove body margin */
        }
        .container {
            padding: 0 15px; /* Minimal left and right padding */
            max-width: 100%; /* Allow the container to take full width */
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .social-icons {
            position: absolute;
            right: 30px; 
            text-align: right; 
        }
        .social-icons ul {
            list-style: none; 
            padding: 0;
            margin: 0;
        }
        .social-icons li {
            margin: 0;
            padding: 0;
            line-height: 1; 
        }
        .social-icons small {
            font-size: 11px; 
            color: #f64747;
        }
        .header img {
            width: 150px; 
        }
        .table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }
        .table th, .table td {
            padding: 8px;
            text-align: left;
            border: none; 
        }
        .table th {
            /* background-color: #f2f2f2; */
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
        }
        .text-justify {
            text-align: justify; 
        }
        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .info-table td {
            padding: 5px;
        }
        .info-table .label {
            text-align: left;
            width: 20%; 
        }
        .info-table .value {
            text-align: left;
        }
    </style>
</head>
<body>
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
        <h2 style="text-align: center;">SURAT PERNYATAAN</h2>
        <table class="info-table">
            <tr>
                <td class="label"><strong>Surat</strong></td>
                <td class="value"><span>:</span> PBY<?php echo $survey->id; ?></td>
            </tr>
            <tr>
                <td class="label"><strong>Hal</strong></td>
                <td class="value"><span>:</span> Surat Pernyataan</td>
            </tr>
        </table>
        <p class="text-justify">Dengan ini saya, yang bertanda tangan di bawah ini:</p>
        <table class="table">
            <tr>
                <th>Nama Lengkap</th>
                <td><span>: </span><?php echo $survey->nama; ?></td>
            </tr>
            <tr>
                <th>No Identitas (KTP)</th>
                <td><span>: </span><?php echo $survey->nik; ?></td>
            </tr>
            <tr>
                <th>Tempat Tanggal Lahir</th>
                <td><span>: </span><?php echo $survey->tempat_lahir . ", " . date('d-m-Y', strtotime($survey->tgl_lahir)); ?></td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td><span>: </span><?php echo $survey->alamat; ?></td>
            </tr>
            <tr>
                <th>No. Telp</th>
                <td><span>: </span><?php echo $survey->telepon; ?></td>
            </tr>
            <tr>
                <th>Pekerjaan</th>
                <td><span>: </span><?php echo $survey->pekerjaan; ?></td>
            </tr>
        </table>
        
        <p class="text-justify">Menyatakan bahwa semua informasi yang saya berikan dalam pengajuan kredit ini adalah benar dan sesuai dengan keadaan yang sebenarnya.</p>
        <p class="text-justify">Saya juga memahami dan menyetujui bahwa data saya dapat digunakan dan diverifikasi oleh Biro Kredit (CLIK) yang bekerjasama dengan KSPPS Melati untuk keperluan analisis kredit, termasuk pengecekan pada Sistem Informasi Debitur (SID) oleh CLIK atau lembaga lainya yang berwenang.</p>
        <p class="text-justify">Saya memberikan izin kepada KSPPS Melati untuk melakukan pengecekan terhadap data saya, baik didalam maupun diluar lembaga ini, guna menilai kelayakan pengajuan kredit saya. Saya juga memahami bahwa hasil pengecekan data ini akan mempengaruhi keputusan pemberian kredit oleh KSPPS Melati.</p>
        
        <div class="footer">
            <p>........................., ......................&nbsp;</p>
            <p>(.................................................)</p>
            <!-- <img src="<?php echo base_url('foto/footer_flip.png'); ?>" alt="Footer Image"> -->
        </div>
    </div>
</body>
</html>

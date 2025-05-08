<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kerja</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table th, .table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Laporan Kerja Bulanan</h1>
        <p>Nama Karyawan: <?= $this->session->userdata('nama_lengkap') ?></p>
        <p>Bulan/Tahun: <?= bulan($bulan) . ' ' . $tahun ?></p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Pekerjaan</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($laporan_kerja as $laporan): ?>
                <tr>
                    <td><?= date('Y-m-d', strtotime($laporan['tanggal'])) ?></td>
                    <td><?= strip_tags($laporan['pekerjaan']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>

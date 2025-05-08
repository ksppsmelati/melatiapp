<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RESUME ANALISA PEMBIAYAAN</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: "Times New Roman", serif;
            font-size: 14px;
            color: #333;
        }

        h5 {
            text-align: center;
            font-weight: bold;
        }

        table {
            width: 100%;
            margin-bottom: 10px;
        }

        th,
        td {
            padding: 4px;
            text-align: left;
            vertical-align: top;
        }

        .table-bordered,
        .table-bordered th,
        .table-bordered td {
            border: 1px solid #000;
            border-collapse: collapse;
        }

        .table-no-border th,
        .table-no-border td {
            border: none;
        }

        .notes {
            color: red;
            font-size: 12px;
            margin-top: 10px;
        }

        .footer {
            margin-top: 40px;
            text-align: right;
        }
    </style>
</head>

<body onload="window.print();">
    <div class="container">
        <h5>RESUME ANALISA PEMBIAYAAN</h5>
        <table class="table-no-border">
            <tr>
                <th>NAMA ANGGOTA</th>
                <td>: </td>
                <td><?php echo $survey->nama; ?></td>
            </tr>
            <tr>
                <th>ALAMAT</th>
                <td>: </td>
                <td><?php echo $survey->alamat; ?>, <?php echo $survey->kelurahan_nama; ?>, <?php echo $survey->kecamatan_nama; ?>, <?php echo $survey->kota_nama; ?>, <?php echo $survey->provinsi_nama; ?></td>
            </tr>
            <tr>
                <th>NO TELP</th>
                <td>: </td>
                <td><?php echo $survey->telepon; ?></td>
            </tr>
            <tr>
                <th>PLAFON PENGAJUAN</th>
                <td>: </td>
                <td>Rp <?php echo $survey->nominal; ?><strong> Jangka Waktu </strong><?php echo $survey->jangka_waktu; ?> Bulan</td>
            </tr>
            <tr>
                <th>Status Anggota</th>
                <td>: </td>
                <td>: Lama</td>
            </tr>
            <tr>
                <th>Riwayat Pembiayaan</th>
                <td>: </td>
                <td>: 0</td>
            </tr>
            <tr>
                <th>Pembiayaan Terbesar</th>
                <td>: </td>
                <td>: Rp 6.000.000</td>
            </tr>
            <tr>
                <th>Usaha Utama</th>
                <td>: </td>
                <td>: Rp 4.600.000</td>
            </tr>
            <tr>
                <th>Keterangan Usaha</th>
                <td>: </td>
                <td>: <?php echo $survey->pekerjaan; ?></td>
            </tr>
            <tr>
                <th>Pendapatan Tambahan</th>
                <td>: </td>
                <td>: Rp 2.200.000</td>
            </tr>
            <tr>
                <th>Analisa Pembiayaan Diberikan</th>
                <td>: </td>
                <td>: Rp 21.000.000</td>
            </tr>
        </table>

        <h6>Taksiran Jaminan</h6>
        <table class="table-bordered">
            <tr>
                <th>NO</th>
                <th>NO SHM</th>
                <th>TAKSASI</th>
                <th>MERK KENDARAAN</th>
                <th>TAKSASI</th>
            </tr>
            <tr>
                <td>1</td>
                <td><?php echo $survey->sertifikat; ?></td>
                <td>Rp <?php echo $survey->nilai_pasar; ?></td>
                <td><?php echo $survey->bpkb; ?></td>
                <td>Rp <?php echo $survey->nilai_pasar; ?></td>
            </tr>
            <tr>
                <td>2</td>
                <td>0</td>
                <td>Rp</td>
                <td>HONDA SCOOPY</td>
                <td>Rp 12.600.000</td>
            </tr>
            <tr>
                <td>3</td>
                <td></td>
                <td></td>
                <td>HONDA VARIO</td>
                <td></td>
            </tr>
            <tr>
                <th colspan="4">TOTAL SEMUA JAMINAN</th>
                <th>Rp 22.500.000</th>
            </tr>
        </table>

        <div class="notes">
            <p>Catatan:</p>
            <p>1. JUALAN PAKAIAN SUAMI KERJA PABRIK</p>
            <p>2. GANTI JAMINAN 4 MOTOR</p>
            <p>3. KURANG FC BPKB BEAT, VARIO, BEAT</p>
            <p>4. KURANG FOTO JAMINAN KECUALI SCOOPY</p>
            <p>5. DILENGKAPI DAHULU SEBELUM AKAD</p>
        </div>

        <div class="footer">
            <p>28/10/2024</p>
            <p>M ARIF HANAFI</p>
            <p>Yang Membuat<br> Analis Pembiayaan</p>
        </div>
    </div>
</body>

</html>

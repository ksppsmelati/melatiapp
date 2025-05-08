<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Cetak Data Otorisasi</title>
  <base href="<?php echo base_url(); ?>" />
</head>

<body onload="window.print()">

  <table border="0" width="100%">
    <tr>
      <td width="120">
        <img src="foto/kspps_melati.png" alt="logo1" width="120">
      </td>
    </tr>
  </table>

  <hr>

  <h2 align="center">Laporan Otorisasi Masuk</h2>
  <br>
  <table border="1" width="100%">
    <tr>
      <th width="1%">No</th>
      <th>Tanggal</th>
      <th>Nama Anggota</th>
      <th>Nominal</th>
      <th>Keterangan</th>
      <th>Status Analisa</th>
      <th>Status Komite</th>
      <th>Kelurahan</th>
      <th>Kecamatan</th>
      <th>Kota</th>
      <th>Provinsi</th>
      <th>Foto</th>
      <th>Inpuser</th>
    </tr>
    <?php
    $no = 1;
    foreach ($sql->result() as $baris) { ?>
      <tr>
        <td><?php echo $no; ?></td>
        <td><?php echo date('d-m-Y', strtotime($baris->tanggal)); ?></td>
        <td><?php echo $baris->nama_anggota; ?></td>
        <td><?php echo 'Rp ' . number_format($baris->nominal, 0, ',', '.'); ?></td>
        <td><?php echo $baris->keterangan; ?></td>
        <td><?php echo $baris->status_analisa; ?></td>
        <td><?php echo $baris->status_komite; ?></td>
        <td><?php echo $baris->kelurahan_nama; ?></td>
        <td><?php echo $baris->kecamatan_nama; ?></td>
        <td><?php echo $baris->kota_nama; ?></td>
        <td><?php echo $baris->provinsi_nama; ?></td>
        <td>
          <?php foreach ($this->db->get_where("tbl_lampiran", array('token_lampiran' => $baris->token_lampiran))->result() as $lampiran) : ?>
            <img src="<?= 'lampiran/' . $lampiran->nama_berkas ?>" alt="Thumbnail" width="30">
          <?php endforeach; ?>
        </td>
        <td><?php echo $baris->pengirim; ?></td>
      </tr>
    <?php
      $no++;
    } ?>
  </table>

</body>

</html>

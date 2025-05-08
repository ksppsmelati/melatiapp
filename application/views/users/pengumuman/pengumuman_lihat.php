<!-- Main content -->
<div class="container">
  <!-- Content area -->
  <div class="content">

    <!-- pengumuman details -->
    <div class="panel panel-flat">
      <!-- <div class="panel-heading">
          <h5 class="panel-title"><i class="icon-file-text2"></i> Informasi</h5>
        </div> -->
      <div class="panel-body">
        <?php if ($pengumuman) { ?>
          <div class="pengumuman-details">
            <div class="pengumuman-header">
              <h3 class="pengumuman-title"><?php echo isset($pengumuman->judul_pengumuman) ? $pengumuman->judul_pengumuman : ''; ?></h3>
            </div>
            <div class="pengumuman-content">
              <p><?php echo isset($pengumuman->isi_pengumuman) ? $pengumuman->isi_pengumuman : ''; ?></p>
            </div>
          </div>
        <?php } else { ?>
          <p>Tidak ada pengumuman yang ditemukan.</p>
        <?php } ?>
      </div>
    </div>
    <!-- /pengumuman details -->
  </div>
</div>

<!-- Main content -->
<div class="container">
  <!-- Content area -->
  <div class="content">

    <!-- Memo details -->
    <div class="panel panel-flat">
      <!-- <div class="panel-heading">
          <h5 class="panel-title"><i class="icon-file-text2"></i> Informasi</h5>
        </div> -->
      <div class="panel-body">
        <?php if ($memo) { ?>
          <div class="memo-details">
            <div class="memo-header">
              <h3 class="memo-title"><?php echo isset($memo->judul_memo) ? $memo->judul_memo : ''; ?></h3>
            </div>
            <div class="memo-content">
              <p><?php echo isset($memo->memo) ? $memo->memo : ''; ?></p>
            </div>
            <hr>
            <div class="text-right">by : <small><?php echo $memo->nama_lengkap; ?> | <?php echo $memo->tanggal; ?><br></small></div>
          </div>
        <?php } else { ?>
          <p>Tidak ada memo yang ditemukan.</p>
        <?php } ?>
      </div>
    </div>
    <!-- /Memo details -->

  </div>
  <!-- /content area -->
</div>
<!-- /main content -->
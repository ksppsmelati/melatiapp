<!-- Main content -->
<div class="container">
  <!-- Content area -->
  <div class="content">

    <!-- Catatan details -->
    <div class="panel panel-flat">
      <!-- <div class="panel-heading">
          <h5 class="panel-title"><i class="icon-file-text2"></i> Informasi</h5>
        </div> -->

      <div class="panel-body">
        <div class="catatan-options">
          <a href="users/catatan/e/<?php echo $catatan->id_catatan; ?>" class="fa fa-pencil" style="float: right;"></a>
          <a href="#" class="fa fa-copy copy-catatan" data-judul="<?php echo isset($catatan->judul_catatan) ? $catatan->judul_catatan : ''; ?>" data-catatan="<?php echo isset($catatan->catatan) ? htmlspecialchars($catatan->catatan) : ''; ?>"></a>
        </div>
        <?php if ($catatan) { ?>
          <div class="catatan-details">
            <div class="catatan-header">
              <h3 class="catatan-title"><?php echo isset($catatan->judul_catatan) ? $catatan->judul_catatan : ''; ?></h3>
            </div>
            <div class="catatan-content">
              <p><?php echo isset($catatan->catatan) ? $catatan->catatan : ''; ?></p>
            </div>
          </div>
        <?php } else { ?>
          <p>Tidak ada catatan yang ditemukan.</p>
        <?php } ?>
      </div>
    </div>
    <!-- /Catatan details -->

  </div>
  <!-- /Content area -->
</div>
<!-- /Main content -->

<!-- Include the SweetAlert library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    const copyCatatanButtons = document.querySelectorAll('.copy-catatan');

    copyCatatanButtons.forEach(function(button) {
      button.addEventListener('click', function(event) {
        event.preventDefault(); // Mencegah tindakan default link

        const judul = this.getAttribute('data-judul');
        const catatan = this.getAttribute('data-catatan');
        const cleanedCatatan = removeHTMLTags(catatan);

        const clipboardData = judul + '\n\n' + cleanedCatatan;

        copyToClipboard(clipboardData);

        // Show SweetAlert notification
        Swal.fire({
          icon: 'success',
          title: 'Catatan telah disalin!',
          showConfirmButton: false,
          timer: 1500
        });
      });
    });

    function removeHTMLTags(html) {
    const div = document.createElement('div');
    div.innerHTML = html;
    return div.innerText.trim();
}

    function copyToClipboard(text) {
      const textarea = document.createElement('textarea');
      textarea.value = text;
      document.body.appendChild(textarea);
      textarea.select();
      document.execCommand('copy');
      document.body.removeChild(textarea);
    }
  });
</script>
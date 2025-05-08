<style>
  .container {
    width: 100%;
    margin: 0;
    padding-top: 10px;
  }
</style>
<div class="container">
  <div class="content">
    <div class="row">
      <div class="panel panel-flat">
          <!-- <div class="panel-body">
            <legend class="text-bold"><i class="fa-solid fa-file-circle-check"></i> Clik Report</legend>
          </div> -->
          <iframe id="myIframe" src="https://www.appsheet.com/start/8bca4433-76fc-4f27-b7f1-075f04409ee4" style="max-width: 100%;" width="100%" height="500" frameborder="0" scrolling="auto" loading="lazy"></iframe>
      </div>
    </div>
  </div>
</div>
<script>
  var iframe = document.getElementById('myIframe');
  iframe.onload = function() {
    // Menyesuaikan height secara dinamis jika konten lebih tinggi dari iframe
    iframe.style.height = iframe.contentWindow.document.body.scrollHeight + 'px';
  }
</script>
<!-- Main content -->
<div class="content-wrapper">
  <!-- Content area -->
  <div class="content">
    <br><br>
    <!-- Dashboard content -->
    <div class="row">
      <div class="col-md-1"></div>
      <div class="panel panel-flat col-md-9">
        <?php
        echo $this->session->flashdata('msg');
        ?>
        <div class="panel-body">
          <fieldset class="content-group">
            <!-- Banner image with padding and responsiveness -->
            <div class="text-center" style="padding: 20px;">
              <img src="foto/produk/simpati.png" alt="Banner Image" class="img-responsive" />
            </div>
            <legend class="text-bold"><i class="fa fa-wallet"></i> SIMPATI</legend>
            
            <!-- SIMPATI content -->
            <h3>Simpanan Harian Melati atau SIMPATI</h3>
            <p>
              Simpanan Harian Melati atau disingkat SIMPATI menggunakan prinsip Wadiah Yad Ad Dhamanah yaitu kami menerima titipan dari anggota, dan dana itu kami putarkan dalam usaha yang produktif.
            </p>
            <p>
              Simpanan Melati cocok digunakan untuk Anda yang mempunyai usaha dan ingin menyimpan hasil usaha dengan aman, berkah dengan sistem syariah.
            </p>
            <p><strong>Keuntungan :</strong></p>
            <ul>
              <li>Mudah dan Fleksibel, kami yang akan mendatangi Anda karena setoran yang dapat dilayani.</li>
              <li>Dapat diambil sewaktu-waktu, sesuai dengan kebutuhan.</li>
              <li>Cocok bagi yang tidak punya waktu luang untuk menyetorkan dananya.</li>
            </ul>
            <p><strong>Persyaratan :</strong></p>
            <ul>
              <li>Formulir: Mengisi formulir aplikasi pembukaan rekening</li>
              <li>Identitas: Identitas berupa KTP</li>
              <li>Setoran Awal: Setoran awal minimal Rp10.000,-</li>
              <li>Setoran Berikutnya: Setoran berikutnya Rp10.000,-</li>
              <li>Penarikan: Dapat diambil sewaktu-waktu sesuai kebutuhan.</li>
            </ul>
            <!-- End of SIMPATI content -->
            <hr></hr>
            <!-- Buka Rekening Button -->
            <div class="row">
              <div class="col-md-6 text-center">
                <b>Buka rekening simpanan sekarang</b>
              </div>
              <br>
              <div class="col-md-6 text-center">
                <a href="users/produk/syarat_ketentuan" class="btn btn-warning">Buka Rekening</a>
              </div>
            </div>
            <!-- End of Buka Rekening Button -->

          </fieldset>
        </div>
      </div>
    </div>
    <!-- /dashboard content -->
  </div>
</div>

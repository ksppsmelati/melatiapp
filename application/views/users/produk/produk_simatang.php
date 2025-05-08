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
              <img src="foto/produk/simatang.png" alt="Banner Image" class="img-responsive" />
            </div>
            <legend class="text-bold"><i class="fa fa-wallet"></i> Simatang</legend>
            
            <!-- SIMATANG content -->
            <h3>Simatang</h3>
            <p>
              SIMATANG atau Simpanan Masa Datang adalah produk simpanan yang ditujukan untuk mengantisipasi kebutuhan instan di masa depan, seperti biaya pendidikan maupun sebagai bekal di hari tua nanti tentunya dengan tetap merasa aman, berkah dan menggunakan sistem syariah.
            </p>
            <p><strong>Keuntungan :</strong></p>
            <ul>
              <li>Penarikan saldo sesuai dengan jangka waktu yang dipilih yaitu : 2 tahun, 5 tahun, 10 tahun.</li>
              <li>Sistem jemput bola oleh marketing kami.</li>
              <li>Setiap Anggota akan memperoleh bukti kepemilikan berupa buku simpanan dari KSPPS Melati.</li>
            </ul>
            <p><strong>Persyaratan</strong></p>
            <p>
              Berikut adalah beberapa hal yang perlu disiapkan untuk membuka rekening Simpanan Masa Datang:
            </p>
            <ul>
              <li>Formulir: Mengisi formulir aplikasi pembukaan rekening</li>
              <li>Identitas: Identitas berupa KTP</li>
              <li>Setoran Awal: Setoran awal minimal Rp20.000,-</li>
              <li>Setoran Berikutnya: Setoran berikutnya Rp50.000,-</li>
              <li>Jangka Waktu: Jangka waktu 2th, 5th, 10th</li>
            </ul>
            <!-- End of SIMATANG content -->
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

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
              <img src="foto/produk/simaya.png" alt="Banner Image" class="img-responsive" />
            </div>
            <legend class="text-bold"><i class="fa fa-wallet"></i> Simaya</legend>
            
            <!-- SIMAYA content -->
            <h3>SIMAYA</h3>
            <p>
              SIMAYA atau Simpanan Hari Raya merupakan produk simpanan yang ditujukan untuk memudahkan Anda dalam mewujudkan niat suci berkurban pada hari raya idul Adha maupun untuk merayakan idul fitri dengan aman, berkah, dan menggunakan sistem syariah.
            </p>
            <p><strong>Keuntungan :</strong></p>
            <ul>
              <li>Bagian perencanaan keuangan dan bijak dalam mengelola uang.</li>
              <li>Setoran simpanan sesuai dengan kemampuan.</li>
              <li>Simpanan bisa diambil 1 Bulan sebelum Hari Raya.</li>
            </ul>
            <p><strong>Persyaratan</strong></p>
            <p>
              Berikut adalah beberapa hal yang perlu disiapkan untuk membuka rekening Simpanan Hari Raya:
            </p>
            <ul>
              <li>Formulir: Mengisi formulir aplikasi pembukaan rekening</li>
              <li>Identitas: Identitas berupa KTP</li>
              <li>Setoran Awal: Setoran awal minimal Rp10.000,-</li>
              <li>Setoran Berikutnya: Setoran berikutnya Rp10.000,-</li>
              <li>Penarikan: Penarikan dilakukan 1 bulan sebelum hari raya</li>
            </ul>
            <!-- End of SIMAYA content -->
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

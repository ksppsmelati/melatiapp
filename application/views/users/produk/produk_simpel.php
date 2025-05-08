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
              <img src="foto/produk/simpel.png" alt="Banner Image" class="img-responsive" />
            </div>
            <legend class="text-bold"><i class="fa fa-wallet"></i> SIMPEL</legend>
            
            <!-- SIMPEL content -->
            <h3>Simpanan Pelajar atau SIMPEL</h3>
            <p>
              SIMPEL atau Simpanan Pelajar adalah simpanan yang bertujuan untuk membantu dan memfasilitasi Anggota dalam memenuhi biaya pendidikan dengan aman dan menggunakan sistem syariah.
            </p>
            <p><strong>Keunggulan :</strong></p>
            <ul>
              <li>Sistem jemput bola oleh marketing kami.</li>
              <li>Membantu dalam merencanakan biaya pendidikan.</li>
              <li>Setiap Anggota akan memperoleh bukti kepemilikan berupa buku simpanan dari KSPPS Melati.</li>
              <li>Transaksi penyetoran dapat dilakukan setiap saat melalui teller Kantor Cabang KSPPS Melati.</li>
            </ul>
            <p><strong>Persyaratan :</strong></p>
            <ul>
              <li>Formulir: Mengisi formulir aplikasi pembukaan rekening</li>
              <li>Identitas: Identitas berupa KTP</li>
              <li>Setoran Awal: Setoran awal minimal Rp10.000,-</li>
              <li>Setoran Berikutnya: Setoran berikutnya Rp5.000,-</li>
              <li>Penarikan: Penarikan saldo setiap semesteran atau kenaikan kelas</li>
            </ul>
            <!-- End of SIMPEL content -->
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

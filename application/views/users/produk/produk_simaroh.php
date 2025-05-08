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
              <img src="foto/produk/simaroh.png" alt="Banner Image" class="img-responsive" />
            </div>
            <legend class="text-bold"><i class="fa fa-wallet"></i> Simaroh</legend>
            
            <!-- SIMAROH content -->
            <p>
              SIMAROH (Simpanan Haji dan Umroh) adalah simpanan cocok digunakan untuk Anda yang akan mempersiapkan ibadah Haji atau Umroh.
            </p>
            <p>
              Keunggulan :
            </p>
            <ol>
              <li>Sistem jemput bola oleh marketing kami.</li>
              <li>Dana anggota dikelola secara syariah sehingga memberikan ketentraman lahir dan batin di tanah suci.</li>
              <li>Bebas biaya administrasi bulanan.</li>
              <li>Setoran awal hanya Rp 100.000,-</li>
              <li>Setiap Anggota akan memperoleh bukti kepemilikan berupa buku simpanan dari KSPPS Melati.</li>
              <li>Transaksi penyetoran dapat dilakukan setiap saat melalui teller Kantor Cabang KSPPS Melati dan penarikan hanya dapat dilakukan untuk pembayaran Haji dan Umroh.</li>
            </ol>
            <!-- End of SIMAROH content -->

            <!-- Persyaratan content -->
            <p>
              <strong>Persyaratan:</strong>
            </p>
            <ul>
              <li><i class="fa fa-file-text"></i> Formulir: Mengisi formulir aplikasi pembukaan rekening.</li>
              <li><i class="fa fa-id-card"></i> Identitas: Identitas berupa KTP.</li>
              <li><i class="fa fa-money-bill"></i> Setoran Awal: Setoran awal minimal Rp100.000,-.</li>
              <li><i class="fa fa-money-bill"></i> Setoran Berikutnya: Sesuai keinginan keberangkatan Haji/Umroh.</li>
              <li><i class="fa fa-money-bill"></i> Penarikan: Penarikan saldo pada saat pendaftaran Haji/Umroh.</li>
            </ul>
            <!-- End of Persyaratan content -->
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

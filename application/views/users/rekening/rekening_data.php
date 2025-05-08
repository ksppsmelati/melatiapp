<?php
$cek = $user->row();
$id_user = $cek->id_user;

?>
<style>
  label.control-label {
    font-weight: bold;
  }
</style>

<link rel="stylesheet" type="text/css" href="assets/upload/dropzone.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.css">

<script src="assets/js/select2.min.js"></script>`
<script src="assets/js/jquery-ui.js"></script>
<script type="text/javascript" src="assets/js/core/app.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.js"></script>

<div class="container">
  <div class="content">
    <div class="row">
      <div class="panel panel-flat">
        <div class="panel-body">
          <div class="navigation-buttons">
            <div class="btn-group" style="float: left;">
              <i class="fa-solid fa-magnifying-glass-dollar"></i> Cek Rekening
            </div>

            <div class="btn-group" style="float: right;">
              <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-bars"></i>
              </button>
              <ul class="dropdown-menu dropdown-menu-right" role="menu">
                <!-- <li><a href="<?php echo site_url('users/kunjungan_data'); ?>"><i class="fa fa-television"></i> Data Kunjungan</a></li>
                <li><a href="<?php echo site_url('users/kunjungan_laporan'); ?>"><i class="fa fa-television"></i> Laporan Kunjungan</a></li> -->
              </ul>
            </div>
          </div>

          <div class="clearfix"></div>
          <hr>
          <fieldset class="content-group">
            <?php
            echo $this->session->flashdata('msg');
            ?>
            <div class="msg"></div>
            <form class="form-horizontal" action="users/sm" enctype="multipart/form-data" method="post">

              <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                  <div class="col-lg-9">
                    <!-- kosong -->
                  </div>
                </div>
              </div>

              <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                  <label class="control-label col-lg-3">Cari </label>
                  <div class="col-lg-9">
                    <select class="form-control cari_anggota" name="cari_anggota" required>
                      <option value="" disabled selected>Cari Nama / No. Rekening</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                  <label class="control-label col-lg-3">Nama Anggota</label>
                  <div class="col-lg-9">
                    <input type="text" name="nama_anggota" id="nama_anggota" class="form-control" readonly onclick="copyToClipboard('nama_anggota')">
                  </div>
                </div>
              </div>

              <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                  <label class="control-label col-lg-3">Alamat</label>
                  <div class="col-lg-9">
                    <input type="text" name="alamat" id="alamat" class="form-control" readonly>
                  </div>
                </div>
              </div>

              <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                  <label class="control-label col-lg-3">No. Rekening</label>
                  <div class="col-lg-9">
                    <input type="number" name="nomor_rekening" id="nomor_rekening" class="form-control" readonly>
                  </div>
                </div>
              </div>

              <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                  <label class="control-label col-lg-3">Produk</label>
                  <div class="col-lg-9">
                    <input type="text" name="nama_produk" id="nama_produk" class="form-control" required readonly>
                  </div>
                </div>
              </div>

              <div class="col-xs-12 col-sm-6" style="display: none;">
                <div class="form-group">
                  <label class="control-label col-lg-3">Saldo Akhir</label>
                  <div class="col-lg-9">
                    <input type="text" name="sahirrp" id="sahirrp" class="form-control" readonly>
                  </div>
                </div>
              </div>

              <div class="col-xs-12 col-sm-6" style="display: none;">
                <div class="form-group">
                  <label class="control-label col-lg-3">CIF</label>
                  <div class="col-lg-9">
                    <input type="text" name="nocif" id="nocif" class="form-control" readonly>
                  </div>
                </div>
              </div>

              <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                  <label class="control-label col-lg-3">Kode Kantor</label>
                  <div class="col-lg-9">
                    <input type="number" name="kode_kantor" id="kode_kantor" class="form-control" required readonly>
                  </div>
                </div>
              </div>

              <div class="col-xs-12 col-sm-6" style="display: none;">
                <div class="form-group">
                  <label class="control-label col-lg-3">Kode Produk</label>
                  <div class="col-lg-9">
                    <input type="text" name="kodeprd" id="kodeprd" class="form-control" required readonly>
                  </div>
                </div>
              </div>

              <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                  <label class="control-label col-lg-3">No. Telp</label>
                  <div class="col-lg-9">
                    <input type="text" name="hp" id="hp" class="form-control" required readonly>
                  </div>
                </div>
              </div>

              <div class="col-xs-12 col-sm-12">
                <div class="form-group">
                  <label class="control-label col-lg-3">Catatan</label>
                  <div class="col-lg-12">
                    <textarea name="catatan" id="catatan" class="form-control" required readonly></textarea>
                  </div>
                </div>
              </div>

              <div class="clearfix"></div>
              <hr>
              <a href="users/" class="btn btn-default">
                << Kembali</a>
            </form>

          </fieldset>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $('.msg').html('');

  // otomatis nama dan rekening
  $(document).ready(function() {
    // Fungsi saat nilai pada select cari_anggota berubah
    $('.cari_anggota').change(function() {
      var selectedNama = $('option:selected', this).attr('data-nama');
      var selectedRekening = $('option:selected', this).attr('data-rekening');
      $('#nama_anggota').val(selectedNama);
      $('#nomor_rekening').val(selectedRekening);

    });

    // Fungsi saat nilai pada input cari berubah
    $('#cari').on('input', function() {
      var cari = $(this).val();

      // Cek apakah inputan cari berupa nomor rekening atau nama anggota
      var isNomorRekening = /^\d+$/.test(cari);

      // Cek setiap opsi pada select cari_anggota
      $('.cari_anggota option').each(function() {
        var optionValue = $(this).val();
        var optionNama = $(this).attr('data-nama');
        var optionRekening = $(this).attr('data-rekening');

        // Jika isNomorRekening true, cari berdasarkan nomor rekening
        // Jika isNomorRekening false, cari berdasarkan nama anggota
        if ((isNomorRekening && optionRekening === cari) || (!isNomorRekening && optionNama === cari)) {
          // Set nilai pada select cari_anggota
          $('.cari_anggota').val(optionValue).trigger('change');

          // Keluar dari loop each
          return false;
        }
      });
    });
  });

  // Menampilkan data anggota
  $(document).ready(function() {
    var kode_produk_desc_simpanan = {
      10: "SIMPANAN MELATI",
      17: "SIMPANAN MASA DATANG 10 THN",
      20: "SIMPANAN MELATI EMAS SYARIAH",
      21: "SIMPANAN PEMBIAYAAN",
      22: "SIMPANAN HARI RAYA",
      23: "SIMPANAN UKHUWAH PENDIDIKAN",
      25: "SIMPANAN PEMUPUKAN MODAL",
      29: "SIMPANAN POKOK",
      30: "SIMPANAN WAJIB",
      31: "SIMPANAN MASA DATANG 2 TAHUN",
      32: "SIMPANAN MASA DATANG 5 TAHUN",
      33: "SIMPANAN PENYERTAAN",
      34: "SIMPANAN PENYERTAAN",
      35: "SIMPANAN UMROH",
      36: "SIMPANAN HAJI",
      37: "SIMPANAN MASA DATANG 1 TAHUN"
    };

    var kode_produk_desc_pembiayaan = {
      10: "PEMBIAYAAN MUDOROBAH",
      20: "PEMBIAYAAN MURABAHAH",
      30: "PEMBIAYAAN IJAROH",
      40: "PEMBIAYAAN MUSYAROKAH",
      50: "PEMBIAYAAN QORDUL HASAN"
    };

    $(".cari_anggota").select2({
      ajax: {
        url: "<?php echo base_url('get-info-rekening'); ?>",
        dataType: "json",
        delay: 250,
        processResults: function(data) {
          return {
            results: $.map(data, function(item) {
              return {
                text: item.fnama + ' - ' + item.notab,
                id: item.notab,
                nama: item.fnama,
                nocif: item.nocif,
                alamat: item.alamat,
                rekening: item.notab,
                // sahirrp: item.sahirrp,
                kode_kantor: item.kodeloc,
                kodeprd: item.kodeprd,
                catatan: item.catatan,
                hp: item.hp
              };
            })
          };
        },
        cache: true
      },
      minimumInputLength: 4
    });

    // Fungsi ini akan dipanggil saat pilihan diubah
    $(".cari_anggota").on("select2:select", function(e) {
      var data = e.params.data;

      // Mengisi input dengan informasi yang sesuai
      $("#nama_anggota").val(data.nama);
      $("#nocif").val(data.nocif);
      $("#alamat").val(data.alamat);
      $("#nomor_rekening").val(data.rekening);
      $("#kode_kantor").val(data.kode_kantor);
      $("#kodeprd").val(data.kodeprd);
      // $("#sahirrp").val(data.sahirrp);
      // Cek apakah notab diawali dengan '4' (untuk pembiayaan)
      var isPembiayaan = data.rekening.startsWith('4');
      var nama_produk = isPembiayaan ?
        (kode_produk_desc_pembiayaan[data.kodeprd] || "Nama produk tidak ditemukan") :
        (kode_produk_desc_simpanan[data.kodeprd] || "Nama produk tidak ditemukan");

      $("#nama_produk").val(nama_produk);
      $("#catatan").val(data.catatan);
      $("#hp").val(data.hp);
    });


    // Fungsi ini akan dipanggil saat pilihan dibatalkan
    $(".cari_anggota").on("select2:unselect", function() {
      // Mengosongkan input jika pilihan dibatalkan
      $("#nama_anggota").val("");
      $("#nocif").val("");
      $("#alamat").val("");
      $("#nomor_rekening").val("");
      $("#kode_kantor").val("");
      $("#kodeprd").val("");
      // $("#sahirrp").val("");
      $("#nama_produk").val("");
      $("#catatan").val("");
      $("#hp").val("");
    });

  });
</script>
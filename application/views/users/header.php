<?php
$cek = $user->row();
$nama = $cek->nama_lengkap;
$email = $cek->email;
$kode_kantor = $cek->kode_kantor;
$menu = null !== $this->uri->segment(1) ? strtolower($this->uri->segment(1)) : '';
$sub_menu = null !== $this->uri->segment(2) ? strtolower($this->uri->segment(2)) : '';
$sub_menu3 = null !== $this->uri->segment(3) ? strtolower($this->uri->segment(3)) : '';
$level = $cek->level;

function getLevelText($level)
{
    switch ($level) {
        case 'umum_dan_pengadaan':
            return 'Staff Umum & Pengadaan';
        case 'marketing':
            return 'Marketing';
        case 'admin':
            return 'Admin';
        case 'ofb':
            return 'Office Boy';
        case 'satpam':
            return 'Satpam';
        case 'it':
            return 'Staff IT';
        case 'audit':
            return 'Staff Audit';
        case 'surveyor':
            return 'Staff Surveyor';
        case 'k_cabang':
            return 'Kepala Cabang';
        case 'k_hrd':
            return 'Kabag HRD';
        case 'k_keuangan':
            return 'Kabag Keuangan';
        case 'k_admin':
            return 'Kabag Admin';
        case 'k_arsip':
            return 'Kabag Arsip';
        case 'kadiv_pemasaran':
            return 'Kadiv Pemasaran';
        case 'kadiv_opr':
            return 'Kadiv Operational';
        case 'kadiv_manrisk':
            return 'Kadiv Manrisk';
        case 'mng_bisnis':
            return 'Manager Business';
        case 'gm':
            return 'General Manager';
        case 's_admin':
            return 'Super Admin';
        case 'ao':
            return 'Account Officer';
        case 'fo':
            return 'Funding Officer';
        case 'user':
            return 'User';
        case 'kadiv_maal':
            return 'Kadiv Maal';
        case 'fund_maal':
            return 'Fundrising Maal';
        default:
            return '- Pilih Level Pengguna -';
    }
}

function getKodeKantorText($kodeKantor) // Fungsi untuk mengonversi kode kantor menjadi teks keterangan
{
    switch ($kodeKantor) {
        case '00':
            return '-';
        case '01':
            return 'PUSAT';
        case '02':
            return 'SEDAYU';
        case '03':
            return 'SAPURAN';
        case '04':
            return 'KERTEK';
        case '05':
            return 'WONOSOBO';
        case '06':
            return 'KALIWIRO';
        case '07':
            return 'BANJARNEGARA';
        case '08':
            return 'RANDUSARI';
        case '09':
            return 'KEPIL';
        default:
            return 'N/A';
    }
}
function getKodeDevisiText($kodeDevisi)
{
    switch ($kodeDevisi) {
        case '01':
            return 'Pemasaran';
        case '02':
            return 'Operasional';
        case '03':
            return 'Manrisk';
        case '04':
            return 'Manajemen Bisnis';
        default:
            return 'N/A';
    }
}

function getKodeJnsUsahaText($jnsUsaha)
{
    switch ($jnsUsaha) {
        case "1000":
            return "SAYURAN, BUAH DAN ANEKA UMBI";
        case "1010":
            return "PERKEBUNAN TEMBAKAU";
        case "1020":
            return "PERTANIAN PADI";
        case "1030":
            return "PERTANIAN TANAMAN SEMUSIM LAINNYA";
        case "1040":
            return "PERTANIAN TANAMAN HIAS DAN PENGEMBANGBIAKAN TANAMAN";
        case "1050":
            return "PENGELOLAAN HUTAN";
        case "1060":
            return "JASA PENUNJANG KEHUTANAN";
        case "1999":
            return "JASA LAINNYA";
        case "2000":
            return "PETERNAKAN SAPI DAN KERBAU";
        case "2010":
            return "PETERNAKAN DOMBA DAN KAMBING";
        case "2020":
            return "PETERNAKAN UNGGAS";
        case "2030":
            return "PERIKANAN BUDIDAYA";
        case "2040":
            return "PERIKANAN TANGKAP";
        case "2999":
            return "PETERNAKAN LAINNYA";
        case "3000":
            return "PENGGALIAN BATU, PASIR DAN TANAH LIAT";
        case "3010":
            return "PERTAMBANGAN EMAS, PERAK BATU BARA";
        case "3020":
            return "AKTIVITAS JASA PENUNJANG PERTAMBANGAN";
        case "3999":
            return "PERTAMBANGAN DAN PENGGALIAN LAINNYA";
        case "4000":
            return "INDUSTRI MAKANAN";
        case "4010":
            return "INDUSTRI MINUMAN";
        case "4020":
            return "INDUSTRI PENGOLAHAN TEMBAKAU";
        case "4030":
            return "INDUSTRI TEKSTIL";
        case "4040":
            return "INDUSTRI PENGOLAHAN KAYU";
        case "4050":
            return "INDUSTRI PENGOLAHAN LOGAM (BESI, ALUMINIUM DLL)";
        case "4060":
            return "INDUSTRI PERCETAKAN DAN PENERBITAN";
        case "4070":
            return "INDUSTRI MATERIAL BANGUNAN";
        case "4999":
            return "INDUSTRI LAINNYA";
        case "5000":
            return "PERDAGANGAN KELONTONG";
        case "5010":
            return "PERDAGANGAN SAYURAN, BUAH DAN ANEKA UMBI";
        case "5020":
            return "PERDAGANGAN ELEKTRONIK";
        case "5030":
            return "PERDAGANGAN KENDARAAN";
        case "5040":
            return "PERDAGANGAN SEMBAKO";
        case "5050":
            return "PERDAGANGAN MAKANAN/MINUMAN";
        case "5060":
            return "PERDAGANGAN PAKAIAN";
        case "5070":
            return "PERDAGANGAN DAGING";
        case "5080":
            return "PERDAGANGAN BAHAN MAKANAN SEHARI-HARI / BUMBU DLL";
        case "5090":
            return "PERDAGANGAN PERALATAN RUMAH TANGGA";
        case "5999":
            return "PERDAGANGAN LAINNYA";
        case "6000":
            return "JASA KONSTRUKSI";
        case "6010":
            return "JASA KEUANGAN";
        case "6020":
            return "JASA KONSULTASI MANAJEMEN";
        case "6030":
            return "JASA KOMPUTER";
        case "6040":
            return "JASA PENDIDIKAN";
        case "6050":
            return "JASA PEMELIHARAAN DAN PERBAIKAN (BENGKEL, SERVICE DLL)";
        case "6060":
            return "JASA PERIKLANAN DAN PUBLIKASI";
        case "6070":
            return "JASA PENYIMPANAN DAN PENGANGKUTAN";
        case "6080":
            return "JASA PERLINDUNGAN DAN KEAMANAN";
        case "6090":
            return "JASA KESEHATAN DAN KEDOKTERAN";
        case "6100":
            return "JASA HIBURAN DAN REKREASI";
        case "6110":
            return "JASA TUKANG BANGUNAN";
        case "6120":
            return "JASA TRAVEL DAN PERJALANAN";
        case "6999":
            return "JASA LAINNYA";
        default:
            return "N/A";
    }
}

function getJenisDokumenText($jenisDokumen)
{
    switch ($jenisDokumen) {
        case "1":
            return "SHM";
        case "2":
            return "SHM A/Rusun";
        case "3":
            return "SHGB";
        case "4":
            return "SHP";
        case "5":
            return "SHGU";
        case "6":
            return "BPKB";
        case "7":
            return "AJB";
        case "8":
            return "BILYET DEPOSITO";
        case "9":
            return "BUKU TABUNGAN";
        case "10":
            return "CEK";
        case "11":
            return "BILYET GIRO";
        case "12":
            return "SURAT PERNYATAAN & KUASA";
        case "13":
            return "INVOICE / FAKTUR";
        case "14":
            return "SIPTB";
        case "15":
            return "DOKUMEN KONTAK";
        case "16":
            return "SAHAM";
        case "17":
            return "OBLIGASI";
        case "18":
            return "SK INSTITUSI/LEMBAGA";
        case "19":
            return "LAIN-LAIN";
        case "20":
            return "LETTER C/GIRIK";
        case "21":
            return "KARTU PASAR";
        default:
            return "N/A";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="google-site-verification" content="bR40eh0fSbqmz4PC_pJ6es28J3gJzauHPa7LPg97bx0">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-FNEXVHXRF3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-FNEXVHXRF3');
    </script>

    <base href="<?php echo base_url(); ?>" />
    <title>
        <?php echo htmlspecialchars($judul_web); ?>
    </title>
    <link rel="icon" href="<?php echo base_url(); ?>favicon.ico" type="image/x-icon" loading="lazy">
    <!-- Global stylesheets -->
    <link href="assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="assets/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="assets/css/core.css" rel="stylesheet" type="text/css">
    <link href="assets/css/components.css" rel="stylesheet" type="text/css">
    <link href="assets/css/colors.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/main.css'); ?>?v=<?php echo time(); ?>">
    <!-- <link href="assets/css/main.css" rel="stylesheet" type="text/css"> -->
    <link href="<?php echo base_url('assets/css/melatiapp.css'); ?>?v=<?php echo time(); ?>" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <!-- /global stylesheets -->
    <!-- header  -->

    <script type="text/javascript" src="assets/js/core/libraries/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/core/app.js"></script>
    <script type="text/javascript" src="assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="assets/js/core/libraries/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/js/plugins/loaders/blockui.min.js"></script>

</head>

<body>
    <!-- Page container -->
    <div class="page-container">
        <!-- Page content -->
        <div class="page-content">
            <div class="bottom-navbar" id="nav" style="color: #696969;">
                <button class="<?php if ($sub_menu == "") {
                                    echo 'active';
                                } ?>">
                    <a href="users/"><i class='fa fa-home'></i></a>
                </button>
                <button class="<?php if ($sub_menu == "kantor") {
                                    echo 'active';
                                } ?>">
                    <a href="users/kantor"><i class='fa fa-building'></i></a>
                </button>
                <button id="btnCheckAbsen" onclick="handleClickPlus(event)" class="float">
                    <a href="users/check_absen"><i class='fa fa-fingerprint' style="font-size: 30px;"></i></a>
                </button>
                <button class="<?php if ($sub_menu == "data_laporan_kerja") {
                                    echo 'active';
                                } ?>">
                    <a href="users/data_laporan_kerja"><i class="fa-solid fa-business-time"></i></a>
                </button>
                <button class="<?php if ($sub_menu == "profile") {
                                    echo 'active';
                                } ?>">
                    <a href="users/profile"><i class='fa fa-user-gear'></i></a>
                </button>
            </div>
        </div>
    </div>
    <!-- Import file javasecript -->

    <!-- Core JS files -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    <!-- /core JS files -->
    <script type="text/javascript" src="assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="assets/js/pages/datatables_basic.js"></script>
    <!-- DataTables JavaScript -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <!-- Include Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <!-- Include Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script>
    <!-- dari profile -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <!-- fungsi-fungsi javascript -->
    <script>
        function updateLocation() {
            navigator.geolocation.getCurrentPosition(function(position) {
                var latitude = position.coords.latitude;
                var longitude = position.coords.longitude;

                $.ajax({
                    url: '/update_location',
                    method: 'POST',
                    data: {
                        latitude: latitude,
                        longitude: longitude
                    },
                    success: function(response) {},
                    error: function(error) {
                        console.error('Error updating location:', error);
                    }
                });
            });
        }
        // Update ketika di muat saja
        updateLocation();

        // update setiap 5000 milidetik (5 detik)
        // setInterval(updateLocation, 5000); 

        // Service Worker
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/service-worker.js')
                .then(function(registration) {
                    // console.log('Service Worker registered with scope:', registration.scope); 
                })
                .catch(function(error) {
                    console.log('Service Worker registration failed:', error);
                });
        }

        // hilangkan navbar ketika scroll
        let prevScrollPos = window.pageYOffset;

        window.onscroll = function() {
            const currentScrollPos = window.pageYOffset;

            if (prevScrollPos > currentScrollPos) {
                // Scrolling up
                document.querySelector(".bottom-navbar").classList.remove("hidden");
            } else {
                // Scrolling down
                document.querySelector(".bottom-navbar").classList.add("hidden");
            }

            prevScrollPos = currentScrollPos;
        };

        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

    <!-- /Import file javasecript -->
</body>

</html>
<?php
$cek = $user->row(); //  mengambil nilai data dari tabel tbl_user 
$id_user = $cek->id_user; // cek ID
$nama = $cek->nama_lengkap; // cek Nama lengkap
$level = $cek->level; //  nilai level dari variabel $level

// Pengelompokan data tren berdasarkan jenis usaha dan status
$trend_counts = [];
foreach ($agunan_data as $data) {
    $jns_usaha_text = getKodeJnsUsahaText($data->jns_usaha);
    if (!isset($trend_counts[$jns_usaha_text])) {
        $trend_counts[$jns_usaha_text] = [
            'down' => 0,
            'same' => 0,
            'up' => 0
        ];
    }
    if ($data->status == 0) {
        $trend_counts[$jns_usaha_text]['down']++;
    } elseif ($data->status == 1) {
        $trend_counts[$jns_usaha_text]['same']++;
    } elseif ($data->status == 2) {
        $trend_counts[$jns_usaha_text]['up']++;
    }
}

// Encode the trend counts to JSON for use in JavaScript
$trend_counts_json = json_encode($trend_counts);
?>

<style>
    .feature ul li {
        padding: 10px;
        border-radius: 30px;
        font-weight: bold;
    }

    .feature {
        /* touch-action: pan-y; */
        /* Enable vertical scrolling while allowing horizontal swiping */
    }

    .choose li {
        flex: 0 0 100px;
        /* Full width */
        text-align: center;
        background: #f0f0f0;
        padding: 10px;
        /* Padding around each item */
        margin: 0 5px;
        /* Margin between each item */
        box-sizing: border-box;
    }

    .head {
        background-image: linear-gradient(135deg, #ff0033, #ff9933);
        color: #fff;
        /* Warna teks */
        padding: 10px 20px;
        position: fixed;
        width: 100%;
        top: 0;
        left: 0;
        z-index: 1000;
        /* Pastikan posisi di atas konten lain */
        display: flex;
        justify-content: space-between;
        /* Mengatur tata letak elemen sebelah kanan */
        align-items: center;
        /* Memusatkan vertikal */
    }

    .head .navigation-buttons {
        float: left;
        /* Untuk mengatur posisi float secara khusus dalam container */
    }

    .head .navigation-buttons .btn {
        padding: 0 10px;
        /* Sesuaikan padding sesuai keinginan */
        border: none;
        /* Menghapus border */
        background-color: transparent;
        /* Menghapus latar belakang */
        font-size: 20px;
        /* Ukuran teks */
        color: #fff;
        /* Warna teks */
    }

    .head .head-text {
        margin-right: 20px;
        /* Jarak dari tepi kanan */
        font-size: 20px;
        /* Ukuran ikon */
        color: #fff;
        /* Warna ikon */
    }

    .clearfix {
        clear: both;
        /* Membersihkan float di dalam container */
    }

    .content {
        margin-top: 60px;
        /* Pastikan konten dimulai setelah bagian fixed */
        padding: 20px;
    }

    .ovoCategori {
        display: flex;
        /* Menggunakan Flexbox untuk mengatur elemen anak */
        justify-content: flex-start;
        /* Mengatur elemen anak dari kiri */
        flex-wrap: wrap;
        /* Membungkus elemen anak jika melebihi lebar container */
    }

    .round-icon {
        width: 20px;
        /* Set the desired width */
        height: 20px;
        /* Set the same value as the width */
        border-radius: 50%;
        /* Make it round */
    }

    .round-icon:hover {
        transform: scale(1.1);
        /* Membesarkan card saat di-hover */
    }

    .icon:hover {
        transform: scale(1.1);
        /* Membesarkan card saat di-hover */
    }

    .icon {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 60px;
        height: 60px;
        margin: 0 auto 5px;
        /* Menjadikan ikon sebagai block element, menambahkan margin bawah */
        background-color: #F1F2F3;
        /* Warna background abu-abu */
        border-radius: 50%;
        /* Membuat background bulat */
    }

    .icon i {
        font-size: 24px;
        /* Ukuran ikon Font Awesome */
        color: #ff5733;
        /* Warna ikon */
    }

    .modal {
        z-index: 9999;
        /* Bootstrap default */
    }

    .modal-backdrop {
        z-index: 1040;
        /* Bootstrap default */
    }

    .modal .close {
        color: #6c757d;
        font-size: 3.5rem;
        /* Ukuran font lebih besar (1.5x ukuran standar) */
        font-weight: bold;
        /* Menebalkan tombol close */
        padding: 0.5rem;
        /* Menambah padding di sekitar tombol close */
        cursor: pointer;
        /* Menambahkan cursor pointer saat hover */
        text-shadow: none;
        /* Menghapus bayangan teks jika ada */
    }

    .modal .close:hover {
        color: #495057;
        /* Warna abu-abu gelap saat hover */
    }

    .modal .close:focus {
        box-shadow: none;
        /* Hapus bayangan fokus */
    }

    .modal-dialog {
        max-width: 90%;
        /* Lebar modal maksimum 90% dari lebar viewport */
        margin: 30px auto;
        /* Margin otomatis agar modal terpusat */
        padding: 0 20px;
    }

    .modal-content {
        margin: 0;
        width: 100%;
        /* Modal konten memenuhi lebar modal */
        border-radius: 10px;
    }

    .modal-body {
        padding: 0;
        /* Hapus padding di dalam modal-body */
    }

    /* Scoped styles for modal content */
    #feedbackModalBody {
        max-width: 600px;
        margin: auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    #feedbackModalBody .form-group {
        margin-bottom: 16px;
    }

    #feedbackModalBody .form-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 8px;
    }

    #feedbackModalBody .form-group input,
    #feedbackModalBody .form-group textarea,
    #feedbackModalBody .form-group select {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    #feedbackModalBody .form-group input[type="submit"] {
        background-color: #f44336;
        color: white;
        border: none;
        cursor: pointer;
        padding: 12px;
        font-size: 16px;
        border-radius: 4px;
        transition: background-color 0.3s;
        margin-top: 10px;
        /* Margin atas untuk jarak dari elemen lain */
    }

    #feedbackModalBody .form-group input[type="submit"]:hover {
        background-color: #e53935;
    }

    #feedbackModalBody .navigation-buttons {
        margin-bottom: 20px;
    }

    #feedbackModalBody .btn-back {
        background-color: #f0f0f0;
        color: #333;
        border: none;
        padding: 8px 16px;
        cursor: pointer;
        text-decoration: none;
        border-radius: 4px;
        transition: background-color 0.3s;
    }

    #feedbackModalBody .btn-back:hover {
        background-color: #e0e0e0;
    }

    /* Flexbox for horizontal layout */
    .form-row {
        display: flex;
        gap: 5px;
        flex-wrap: wrap;
    }

    .form-group.full-width {
        flex: 1 1 100%;
        /* Full width for single column elements */
        padding: 2px;
    }

    .form-group.half-width {
        flex: 1;
        /* Half width for two-column elements */
        padding: 2px;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chroma-js/2.1.0/chroma.min.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400&display=swap">
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">

<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>

<section class="head">
    <div class="navigation-buttons">
        <div class="btn-group">
            <a href="javascript:history.go(-1);" class="btn btn-sm">
                <i class="fa fa-chevron-left" style="font-size: 20px;"></i>
            </a>
        </div>
    </div>
    <p class="head-text">Semua Menu</p> <!-- Ikon kaca pembesar untuk pencarian -->
    <div class="clearfix"></div>
</section>
<div class="container">
    <div class="row">
        <div class="col-md-1"></div>
        <div class="panel panel-flat col-md-9">
            <?php
            echo $this->session->flashdata('msg');
            ?>

        </div>
    </div>

    <section class="cool" style="margin-top: 60px;; border-radius: 10px;">
        <div class="ovoCategori">
            <?php foreach ($menus as $menu) : ?>
                <div class="card" style="margin-top: 8px;">
                    <a class="icon" href="<?php echo (strpos($menu->url, 'http://') === 0 || strpos($menu->url, 'https://') === 0) ? $menu->url : base_url($menu->url); ?>" <?php if (!empty($menu->custom)) : ?> <?php echo $menu->custom; ?> <?php endif; ?> data-menu-name="<?php echo $menu->menu_name; ?>">
                        <i class="<?php echo $menu->icon; ?>" style="font-size: 32px;"></i>
                    </a>
                    <p><?php echo $menu->menu_name; ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- <section class="promote">
        <div class="promoteWrapper swiper mySwiper" style="border-radius: 10px;">
            <div class="cardWrapper swiper-wrapper" style="width: 300px; height: auto;">
                <a href="users/produk/produk_simpati" class="card swiper-slide">
                    <img src="foto/produk/simpati.png" alt="" loading="lazy">
                </a>
                <a href="users/produk/produk_simasya" class="card swiper-slide">
                    <img src="foto/produk/simasya.png" alt="" loading="lazy">
                </a>
                <a href="users/produk/produk_simaya" class="card swiper-slide">
                    <img src="foto/produk/simaya.png" alt="" loading="lazy">
                </a>
                <a href="users/produk/produk_simatang" class="card swiper-slide">
                    <img src="foto/produk/simatang.png" alt="" loading="lazy">
                </a>
                <a href="users/produk/produk_simaroh" class="card swiper-slide">
                    <img src="foto/produk/simaroh.png" alt="" loading="lazy">
                </a>
                <a href="users/produk/produk_simpel" class="card swiper-slide">
                    <img src="foto/produk/simpel.png" alt="" loading="lazy">
                </a>
                <a href="users/produk/produk_simmka" class="card swiper-slide">
                    <img src="foto/produk/simmka.png" alt="" loading="lazy">
                </a>
            </div>
        </div>
    </section> -->
    <!-- <section class="cool" style="border-radius: 10px; display: none; ">
        <h3>Yang Menarik di KSPPS MELATI</h3>
        <div class="coolContent">
            <div class="card">
                <div class="images">
                    <img src="foto/produk/simmka.png" alt="">
                </div>
                <div class="cardText">
                    <h3>Pusat Bantuan</h3>
                    <p>Punya kendala atau pertanyaan terkait Pembiayaan? Kamu bisa kirim email di sini</p>
                    <a href="">Lihat Bantuan</a>
                </div>
            </div>
            <div class="card">
                <div class="images">
                    <img src="foto/produk/simmka.png" alt="">
                </div>
                <div class="cardText">
                    <h3>Promo Voucher</h3>
                    <p>Yuk cek berbagai promo menarik di aplikasi melati-app sekarang</p>
                    <a href="">Lihat Bantuan</a>
                </div>
            </div>
            <div class="card">
                <div class="images">
                    <img src="foto/produk/simmka.png" alt="">
                </div>
                <div class="cardText">
                    <h3>Cerdas Finansial</h3>
                    <p>Yuk melek Finansial bersama KSPPS MELATI</p>
                    <a href="">Lihat Bantuan</a>
                </div>
            </div>
            <div class="card">
                <div class="images">
                    <img src="foto/produk/simmka.png" alt="">
                </div>
                <div class="cardText">
                    <h3>Promo Voucher</h3>
                    <p>Yuk cek berbagai promo menarik di aplikasi Melati-App sekarang</p>
                    <a href="">Lihat Bantuan</a>
                </div>
            </div>
            <div class="card">
                <div class="images">
                    <img src="foto/produk/simmka.png" alt="">
                </div>
                <div class="cardText">
                    <h3>Tips Keuangan</h3>
                    <p>Investasi Reksadana sekarang bisa mulai dari 10ribu</p>
                    <a href="">Lihat Bantuan</a>
                </div>
            </div>
            <div class="card">
                <div class="images">
                    <img src="foto/produk/simmka.png" alt="">
                </div>
                <div class="cardText">
                    <h3>Pusat Bantuan</h3>
                    <p>Punya kendala atau pertanyaan terkait pembiayaan? Kamu bisa kirim email di sini</p>
                    <a href="">Lihat Bantuan</a>
                </div>
            </div>
        </div>
    </section> -->
    <section class="cool" style="border-radius: 10px; margin-bottom: 60px;">
        <div class="panel-body">
            <div class="navigation-buttons">
                <div class="btn-group" style="float: left;">
                    <i class="fa fa-bar-chart"></i> Trend Usaha Monitoring Tahun <?php echo date('Y'); ?>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <fieldset class="content-group">
            <div class="table-responsive">
                <div>
                    <canvas id="trendChart"></canvas>
                </div>
            </div>
        </fieldset>
    </section>

    <div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog" aria-labelledby="feedbackModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <br>
                    <div class="modal-body" id="feedbackModalBody">
                        <!-- Content will be loaded here -->
                    </div>
                </div>
            </div>
        </div>
</div>

<script>
    function initializeSwiper() {
        new Swiper('.mySwiper', {
            slidesPerView: 'auto',
            spaceBetween: 10,
            loop: true,
            centeredSlides: true,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },
            speed: 800,
            effect: ['slide', 'fade'],
        });
    }

    initializeSwiper();

    function getRandomColor() {
        var letters = '0123456789ABCDEF';
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

    function generateColors(count) {
        return chroma.scale('Set3').mode('lab').colors(count);
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Get data from PHP
        var trendCounts = <?php echo $trend_counts_json; ?>;

        // Prepare data for Chart.js
        var trendLabels = Object.keys(trendCounts);
        var trendData = trendLabels.map(function(label) {
            return {
                label: label,
                down: trendCounts[label].down,
                same: trendCounts[label].same,
                up: trendCounts[label].up
            };
        });

        var trendColors = generateColors(trendLabels.length);

        // Create Trend Chart
        var ctxTrend = document.getElementById('trendChart').getContext('2d');
        var trendChart = new Chart(ctxTrend, {
            type: 'bar',
            data: {
                labels: trendLabels,
                datasets: [{
                        label: 'Turun',
                        data: trendData.map(data => data.down),
                        backgroundColor: '#FF6F6F'
                    },
                    {
                        label: 'Sama',
                        data: trendData.map(data => data.same),
                        backgroundColor: '#FFC107'
                    },
                    {
                        label: 'Naik',
                        data: trendData.map(data => data.up),
                        backgroundColor: '#4CAF50'
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            autoSkip: false,
                            maxRotation: 90,
                            minRotation: 90
                        }
                    },
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                var label = trendLabels[tooltipItem.dataIndex];
                                var trendDataPoint = trendData[tooltipItem.dataIndex];
                                if (tooltipItem.datasetIndex === 0) {
                                    return label + ' - Turun: ' + trendDataPoint.down;
                                } else if (tooltipItem.datasetIndex === 1) {
                                    return label + ' - Sama: ' + trendDataPoint.same;
                                } else if (tooltipItem.datasetIndex === 2) {
                                    return label + ' - Naik: ' + trendDataPoint.up;
                                }
                            }
                        }
                    }
                }
            }
        });
    });

    $(document).ready(function() {
        $('#feedbackModal').on('show.bs.modal', function(e) {
            var url = 'https://app.bmtmelati.com/users/kritik_saran_tambah';

            // Show a loading spinner or placeholder
            $('#feedbackModalBody').html('<div class="loading">Loading...</div>');

            // Load the external content
            $.get(url, function(data) {
                // Extract the relevant content from the external page
                var extractedContent = $(data).find('.panel-body').html();
                $('#feedbackModalBody').html(extractedContent);
            });
        });
    });
</script>
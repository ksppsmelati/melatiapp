<?php
$cek = $user->row(); //  mengambil nilai data dari tabel tbl_user 
$id_user = $cek->id_user; // cek ID
$nama = $cek->nama_lengkap; // cek Nama lengkap
$jk = $cek->jenis_kelamin; // cek jenis kelamin
$level = $cek->level; //  nilai level dari variabel $level
$status = $cek->status; // cek status
$pesan = $cek->pesan; // cek pesan
$tgl_lahir = $cek->tgl_lahir; // cek tgl_lahir
$kode_kantor = $cek->kode_kantor; // cek kode kantor
$tgl = date('m-Y'); // tanggal
$sess_latitude = $this->session->userdata('latitude'); // simpan Latitude dari session
$sess_longitude = $this->session->userdata('longitude'); // simpan Longitude dari session
$cek_latitude = isset($cek->latitude) ? $cek->latitude : 0; // Ganti dengan nama kolom latitude yang sesuai
$cek_longitude = isset($cek->longitude) ? $cek->longitude : 0;  // Ganti dengan nama kolom longitude yang sesuai
$levelText = getLevelText($level); // Mendapatkan teks level sesuai dengan nilai level
$kodeKantorText = getKodeKantorText($kode_kantor); // Dapatkan teks keterangan kode kantor
$appIcons = $cek->custom_menu; // menu custom 
$notifikasi = $cek->notifikasi; // cek notifikasi
$thumbnailURL = (!empty($cek->foto_profile) && file_exists('./foto/foto_profile/' . $cek->foto_profile)) ? './foto/foto_profile/' . $cek->foto_profile : 'foto/default.png';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400&display=swap">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>

    <style>
        body {
            overflow-x: hidden;
            /* Menghindari scroll horizontal */
        }

        .lokasi .lokasi-data {
            font-size: 12px;
        }

        @keyframes bellAnimation {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }

        /* Tambahkan CSS ini ke dalam file CSS Anda */
        @keyframes scaleUp {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }

        .card {
            transition: transform 0.2s ease;
            /* Efek transisi 0.2 detik untuk kembali ke ukuran semula */
        }

        .card.active {
            animation: scaleUp 0.5s ease forwards;
            /* Gunakan animasi keyframes scaleUp selama 0.5 detik */
            transition: none;
            /* Hapus transisi */
        }


        .bell-animation {
            animation: bellAnimation 0.5s ease forwards;
            /* Adjust the duration and easing as needed */
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

        .logo:hover {
            transform: scale(1.1);
            /* Membesarkan card saat di-hover */
        }

        .running-text {
            white-space: nowrap;
            overflow: hidden;
            animation: marquee 10s linear infinite;
        }

        @keyframes marquee {
            0% {
                transform: translateX(100%);
            }

            100% {
                transform: translateX(-100%);
            }
        }

        .promo {
            display: inline-block;
        }

        .judul {
            font-size: 14px;
            margin-right: 10px;
            text-align: center;
        }

        .notifikasi-content li {
            font-size: 13px;
            display: inline-block;
            margin-right: 20px;
            padding: 8px;
            text-align: justify;
        }

        .feature {
            /*touch-action: pan-y;*/
            /* Enable vertical scrolling while allowing horizontal swiping */
        }

        .swipe-icon {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            font-size: 24px;
            color: #aaa;
            cursor: pointer;
        }

        .swipe-icon-left {
            left: 3%;
            font-size: 12px;
        }

        .swipe-icon-right {
            right: 3%;
            font-size: 12px;
        }

        /* end notifikasi tengah */
        /* pesan toggle */
        /* Gaya untuk pesan yang dapat di-toggle */
        .toggle-message {
            display: inline-block;
            cursor: pointer;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.2);
            }
        }

        .toggle-message {
            animation: pulse 1s infinite;
            /* Adjust the duration as needed */
        }


        /* end Gaya untuk pesan yang dapat di-toggle */
        /* Gaya untuk popup pesan */
        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            z-index: 1002;
            width: 96%;
            box-sizing: border-box;
            overflow-y: auto;
            text-align: left;
            font-size: 14px;
            line-height: 1.5;
            color: #000;
            max-height: 75vh;
            /* Menetapkan tinggi maksimum agar dapat di-scroll */
            max-width: 96%;
            /* Menetapkan lebar maksimum */
        }

        /* Gaya untuk tombol tutup "x" */
        .close-button {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 40px;
            cursor: pointer;
        }

        /* Gaya untuk konten pesan */
        .popup-content {
            padding: 20px;
        }

        /* end pesan toggle */

        .hero .heroContent {
            position: relative;
            /* Ensure positioning context */
            background-image:
                linear-gradient(135deg, rgba(255, 0, 51, 0.9), rgba(255, 153, 51, 0.3));
            background-size: cover, cover;
            background-blend-mode: overlay;
            padding: 1rem;
            border-radius: 8px;
            overflow: hidden;
            /* Ensure the pseudo-element stays within the bounds */
        }

        .hero .heroContent::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('https://app.bmtmelati.com/foto/foto_banner/<?= $foto_banner; ?>');
            background-size: cover;
            background-position: center;
            transition: transform 0.3s ease-in-out;
            z-index: -1;
            transform: scale(var(--scale)) translate(var(--translateX), var(--translateY));
            /* Ensure it is behind the content */
        }

        .hero .heroContent:hover::before {
            transform: scale(calc(var(--scale) * 1.05)) translate(calc(var(--translateX) + 10px), calc(var(--translateY) + 10px));
            /* Membuat gambar membesar dan bergerak saat dihover */
            /* Membuat gambar membesar dan bergerak saat dihover */
        }

        /* Ensuring the text is above the pseudo-element */
        .hero .heroContent .text,
        .hero .heroContent .totals {
            position: relative;
            z-index: 1;
        }

        .custom-menu {
            list-style: none;
            padding: 0;
        }

        .custom-menu li {
            display: flex;
            /* Menggunakan flexbox untuk mengatur posisi */
            flex-direction: column;
            /* Menjadikan konten menjadi kolom */
            align-items: center;
            /* Mengatur penempatan horizontal ke tengah */
            text-align: center;
            /* Mengatur penempatan teks horizontal ke tengah */
            font-size: 10px;
            /* Ukuran font untuk teks di sekitar */
        }

        .custom-menu li a {
            text-decoration: none;
            /* Menghapus garis bawah default pada tautan */
        }

        .custom-menu li a i {
            color: #808080;
            font-size: 24px;
            /* Ukuran ikon Font Awesome */
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
            background-color: rgba(255, 87, 51, 0.1);
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

        .iconkecil:hover {
            transform: scale(1.1);
            /* Membesarkan card saat di-hover */
        }

        .iconkecil {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 40px;
            height: 40px;
            margin: 0 auto 5px;
            /* Menjadikan ikon sebagai block element, menambahkan margin bawah */
            background-color: #F1F2F3;
            /* Warna background abu-abu */
            border-radius: 50%;
            /* Membuat background bulat */
        }

        .iconkecil i {
            font-size: 20px;
            /* Ukuran ikon Font Awesome */
            color: #ff5733;
            /* Warna ikon */
        }

        .card p {
            font-size: 14px;
            /* Ukuran font untuk teks */
            margin: 0;
            /* Menghapus margin default pada paragraf */
            color: #333;
            /* Warna teks */
        }

        .custom-menu:hover {
            transform: scale(1.1);
            /* Membesarkan card saat di-hover */
        }

        /* Styling untuk search bar */
        .search-bar {
            display: flex;
            justify-content: center;
            /* Menempatkan search bar di tengah */
            /* margin-bottom: 10px; */
            padding-top: 10px;
        }

        /* Styling untuk input pencarian */
        .search-input {
            width: 80%;
            padding: 8px;
            /* font-size: 16px; */
            border: 1px solid #ccc;
            border-radius: 20px;
            outline: none;
            transition: all 0.3s ease;
            opacity: 1;
            /* Posisi input langsung terlihat dan berada di tengah */
        }

        .menu-name {
            white-space: normal;
            /* Membuat teks dapat membungkus */
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
    </style>
</head>

<body>
    <style>
        :root {
            --primary: #16a085;
            --secondary: #2980b9;
            --accent: #ff5733;
            --background: #f8f9fa;
            --text: #333333;
            --light-text: #6c757d;
            --card-bg: #ffffff;
            --border-radius: 12px;
            --shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
        }

        .user-profile {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 2px solid white;
            margin-right: 1rem;
            object-fit: cover;
        }

        .user-info h2 {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 0.2rem;
        }

        .user-info p {
            font-size: 0.85rem;
            opacity: 0.9;
        }

        .header-actions {
            position: absolute;
            top: 1rem;
            right: 1rem;
            display: flex;
            gap: 1rem;
        }

        .action-button {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
        }

        .action-button:hover {
            background-color: rgba(255, 255, 255, 0.3);
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: var(--accent);
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .menu-icon {
            display: inline-block;
            transition: transform 0.2s ease;
        }
        
        .menu-icon:hover {
            transform: scale(1.1);
        }
        
        .menu-icon:active {
            transform: scale(1.1);
        }
    </style>

    <section class="hero">
        <div class="heroContent">
                <div class="absen-container" style="position: absolute; right: 5%; top: 10%;">
                    <small style="font-family: 'Courier New'"> <?php echo $status_app; ?></small>
                    <br>
                </div>

                <small style="color: #fff; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);"><?php echo $greeting; ?></small><br>

                    <div class="user-profile">
                        <img class="user-avatar" src="<?php echo $thumbnailURL; ?>" alt="Profile Photo" id="userAvatar">
                        <div class="user-info">
                            <h2 id="userName"><?php echo ucwords($nama); ?></h2>
                            <small id="userRole"><?php echo ucwords($levelText); ?>
                                ( Kantor
                                <?php echo $kodeKantorText = getKodeKantorText($cek->kode_kantor); ?> )</small>
                        </div>
                    </div>

                    <!-- Tombol atau ikon pesan -->
                    <div class="toggle-message" style="position: absolute; right: 10%; <?php echo empty($pesan) ? 'display: none;' : ''; ?>">
                        <i class="fa fa-envelope" style="font-size: 20px;"></i>
                        <span class="notification-badge" style="color: red; absolute; top: 10%;"></span>
                    </div>
                    <!-- Tombol atau ikon pesan -->
                <div class="header-actions">
                    <div class="action-button" id="notificationBtn">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge" id="notifBadge">2</span>
                    </div>
                    <div class="action-button" id="messageBtn">
                        <i class="fas fa-envelope"></i>
                    </div>
                </div>
        </div>
    </section>

    <!-- notifikasi custom user -->
    <?php if (!empty($cek->notifikasi)) : ?>
        <div class="notifikasi" id="informasi">
            <div class="feature" id="swipeContainerInformasi">
                <div class="choose">
                    <i class="fas fa-chevron-left swipe-icon swipe-icon-left" onclick="hideNotification()"></i>
                    <!-- <div class="judul"><b>- notifikasi -</b></div> -->
                    <ul class="notifikasi-content">
                        <li>
                            <?php echo $cek->notifikasi; ?>
                        </li>
                    </ul>
                    <i class="fas fa-chevron-right swipe-icon swipe-icon-right" onclick="hideNotification()"></i>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <!-- end notifikasi custom user -->

    <!-- Popup pesan -->
    <div class="popup" id="pesanPopup">
        <div class="popup-content">
            <span class="close-button" onclick="closePopup()">&times;</span>
            <p>
                <?php echo $pesan; ?>
            </p>
        </div>
    </div>
    <!-- end Popup pesan -->

    <!-- pengumuman ke semua user -->
    <?php if (!empty($pengumuman)) : ?>
        <div class="pengumuman" style="padding-left: 10px; padding-right: 10px">
            <div class="feature">
                <div class="choose">
                    <ul class="notifikasi-content" style="padding-left: 10px;">
                        <li>
                            <p><i class="fa fa-bullhorn"></i>&nbsp
                                <?php echo $pengumuman->isi_pengumuman; ?>
                            </p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <!-- end pengumuman ke semua user -->

    <?php if (!empty($menu_category)) : ?>
        <section class="recomend" style="margin-left: 1rem; margin-right: 1rem; margin-bottom: 8px; border-radius: 10px; padding-top: 10px; padding-bottom: 0px; border: 0.1px solid orange;">
            <ul id="menuListContainer" style="display: flex; flex-wrap: wrap; justify-content: <?php echo count($menu_category) <= 3 ? 'flex-start' : 'center'; ?>; padding: 0; margin: 0;">
                <div class="menuCategori" id="menuList" style="display: flex; width: 100%; justify-content: space-around;">
                <?php
                $limit = 3; // Increased to 4 for better space utilization
                foreach ($menu_category as $index => $menu) :
                    if ($index < $limit) :
                ?>
                    <li class="menu-item" style="list-style: none; flex-basis: 18%; text-align: center; margin: 2px;">
                        <div style="text-align: center; padding: 0 4px;">
                        <a href="<?php echo base_url($menu->url); ?>" 
                               data-menu-name="<?php echo $menu->menu_name; ?>"
                               class="menu-icon">
                                <i class="<?php echo $menu->icon; ?>" style="font-size: 18px; color: #ff5733;"></i>
                            </a>
                            <p class="menu-name" style="font-size: 9px; margin: 2px 0 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?php echo $menu->menu_name; ?></p>
                        </div>
                    </li>
                <?php endif; endforeach; ?>
                
                <?php if (count($menu_category) > $limit) : ?>
                    <li class="menu-item" style="list-style: none; flex-basis: 18%; text-align: center; margin: 2px;">
                        <div style="text-align: center; padding: 0 4px;">
                            <button id="openMoreMenu" style="background: none; border: none; cursor: pointer; text-decoration: none; color: #ff5733; padding: 0;">
                                <i class="fas fa-ellipsis-h" style="font-size: 18px;"></i>
                                <p class="menu-name" style="font-size: 9px; margin: 2px 0 4px;">More</p>
                            </button>
                        </div>
                    </li>
                <?php endif; ?>
                </div>
            </ul>
        </section>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Mengatur SweetAlert untuk modal More dengan grid 4 item per baris
        document.getElementById("openMoreMenu").onclick = function() {
            let menuHTML = '<div style="display: flex; flex-wrap: wrap; justify-content: space-around; text-align: center;">';
            <?php foreach ($menu_category as $menu) : ?>
                menuHTML += `<div style="flex-basis: 20%; margin: 0px; text-align: center;">
                            <a class="iconkecil" href="<?php echo base_url($menu->url); ?>" data-menu-name="<?php echo $menu->menu_name; ?>">
                                <i class="<?php echo $menu->icon; ?>" style="font-size: 20px; color: #ff5733;"></i>
                            </a>
                            <strong style="font-size: 10px;"><?php echo $menu->menu_name; ?></strong>
                        </div>`;
            <?php endforeach; ?>
            menuHTML += '</div>';

            Swal.fire({
                // title: 'More Menu',
                html: menuHTML,
                showCloseButton: true,
                focusConfirm: false,
                width: '90%', // Lebar pop-up lebih besar
                padding: '10px', // Menambah padding agar lebih padat
                customClass: {
                    popup: 'menu-swal-popup'
                },
                showConfirmButton: false
            });
        };
    </script>

    <style>
        /* Gaya untuk sweetalert modal agar lebih padat */
        .menu-swal-popup {
            max-width: 700px;
            /* Lebar maksimum popup */
        }
    </style>

    <style>
        .choose {
            display: flex;
            justify-content: space-around;
            border-radius: 50px;
            padding: 10px 20px;
        }

        .choose ul {
            display: flex;
            justify-content: flex-start;
            width: 100%;
            list-style: none;
            padding: 0;
        }

        .choose ul li {
            padding-top: 0px;
        }

        .choose li {
            padding: 2px 10px;
            border-radius: 50%;
            cursor: pointer;
            background-color: #fff;
            transition: background-color 0.3s, transform 0.3s;
            text-align: center;
            margin-right: 10px;
        }

        .choose li.active {
            background-color: #F1F2F3;
            color: #ff3333;
            transform: scale(1.1);
            border: 0.5px solid #ff3333;
        }

        .category {
            visibility: hidden;
            /* Pastikan kategori yang tidak aktif tidak terlihat */
            opacity: 0;
            position: absolute;
            /* Posisi absolut agar tidak mempengaruhi layout */
            top: 0;
            left: 0;
            right: 0;
            transform: translateX(100%);
            /* Default muncul dari sisi kanan */
            transition: opacity 0.5s ease, transform 0.5s ease;
            /* Transisi halus */
        }

        .category.active {
            visibility: visible;
            /* Kategori aktif terlihat */
            opacity: 1;
            position: relative;
            /* Posisi normal saat aktif */
            transform: translateX(0);
            /* Muncul pada posisi normal */
        }

        /* Animasi bounce untuk slide dari kanan ke kiri */
        @keyframes slideInBounceRight {
            0% {
                transform: translateX(100%);
                /* Mulai dari luar layar (kanan) */
            }

            60% {
                transform: translateX(-10px);
                /* Bergerak sedikit melewati batas */
            }

            80% {
                transform: translateX(5px);
                /* Kembali ke posisi awal sedikit */
            }

            100% {
                transform: translateX(0);
                /* Berhenti di posisi normal */
            }
        }

        /* Animasi untuk slide keluar ke kiri */
        @keyframes slideOutLeft {
            0% {
                opacity: 1;
                transform: translateX(0);
                /* Awalnya di tempat */
            }

            100% {
                opacity: 0;
                transform: translateX(-100%);
                /* Keluar ke kiri */
            }
        }

        /* Animasi bounce untuk slide dari kiri ke kanan */
        @keyframes slideInBounceLeft {
            0% {
                transform: translateX(-100%);
                /* Mulai dari luar layar (kiri) */
            }

            60% {
                transform: translateX(10px);
                /* Bergerak sedikit melewati batas */
            }

            80% {
                transform: translateX(-5px);
                /* Kembali ke posisi awal sedikit */
            }

            100% {
                transform: translateX(0);
                /* Berhenti di posisi normal */
            }
        }

        /* Animasi untuk slide keluar ke kanan */
        @keyframes slideOutRight {
            0% {
                opacity: 1;
                transform: translateX(0);
                /* Awalnya di tempat */
            }

            100% {
                opacity: 0;
                transform: translateX(100%);
                /* Keluar ke kanan */
            }
        }
    </style>

    <section class="feature">
        <div class="choose">
            <ul>
                <li data-target=".menuCategory.utama" class="active">Utama</li>
                <li data-target=".menuCategory.alat">Alat</li>
                <li data-target=".menuCategory.keuangan">Keuangan</li>
                <li data-target=".menuCategory.lainnya">Lainnya</li>
            </ul>
        </div>

        <div class="menuCategory utama category active">
            <?php foreach ($menus as $menu) : ?>
                <div class="card">
                    <a class="icon" href="<?php echo base_url($menu->url); ?>" data-menu-name="<?php echo $menu->menu_name; ?>">
                        <i class="<?php echo $menu->icon; ?>"></i>
                    </a>
                    <p><?php echo $menu->menu_name; ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="menuCategory alat category">
            <?php foreach ($menu_alat as $menu) : ?>
                <div class="card">
                    <a class="icon" href="<?php echo base_url($menu->url); ?>" data-menu-name="<?php echo $menu->menu_name; ?>">
                        <i class="<?php echo $menu->icon; ?>"></i>
                    </a>
                    <p><?php echo $menu->menu_name; ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="menuCategory keuangan category">
            <?php foreach ($menu_keuangan as $menu) : ?>
                <div class="card">
                    <a class="icon" href="<?php echo base_url($menu->url); ?>" data-menu-name="<?php echo $menu->menu_name; ?>">
                        <i class="<?php echo $menu->icon; ?>"></i>
                    </a>
                    <p><?php echo $menu->menu_name; ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="menuCategory lainnya category">
            <?php foreach ($menu_lainnya as $menu) : ?>
                <div class="card">
                    <a class="icon" href="<?php echo (strpos($menu->url, 'http://') === 0 || strpos($menu->url, 'https://') === 0) ? $menu->url : base_url($menu->url); ?>" <?php if (!empty($menu->custom)) : ?> <?php echo $menu->custom; ?> <?php endif; ?> data-menu-name="<?php echo $menu->menu_name; ?>">
                        <i class="<?php echo $menu->icon; ?>" style="font-size: 32px;"></i>
                    </a>
                    <p><?php echo $menu->menu_name; ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/hammerjs@2.0.8/hammer.min.js"></script>
    <script>
        // Function to change the category
        function changeCategory(target) {
            const activeItem = document.querySelector('.choose li.active');
            const activeCategory = document.querySelector('.category.active');

            // Remove active class from the current active item
            if (activeItem) {
                activeItem.classList.remove('active');
            }

            // Add active class to the new item
            const newItem = document.querySelector(`li[data-target="${target}"]`);
            newItem.classList.add('active');

            const newCategory = document.querySelector(target);

            // Animate and change categories
            if (activeCategory) {
                const allItems = Array.from(document.querySelectorAll('.choose li'));
                const activeIndex = allItems.indexOf(activeItem);
                const newIndex = allItems.indexOf(newItem);

                if (newIndex > activeIndex) {
                    activeCategory.style.animation = 'slideOutLeft 0.5s ease forwards';
                    newCategory.style.animation = 'slideInBounceRight 0.6s ease forwards';
                } else {
                    activeCategory.style.animation = 'slideOutRight 0.5s ease forwards';
                    newCategory.style.animation = 'slideInBounceLeft 0.6s ease forwards';
                }

                activeCategory.classList.remove('active');
                setTimeout(() => {
                    activeCategory.style.display = 'none';
                }, 500); // Animation duration
            }

            newCategory.style.display = 'flex';
            setTimeout(() => {
                newCategory.classList.add('active');
            }, 10);
        }

        // Event listener for clicks on the menu
        document.querySelectorAll('.choose li').forEach((item, index, allItems) => {
            item.addEventListener('click', function() {
                const target = this.getAttribute('data-target');
                changeCategory(target);
            });
        });

        // Add swipe functionality using Hammer.js
        const categoryContainer = document.querySelector('section.feature');
        const hammer = new Hammer(categoryContainer);

        hammer.on('swipeleft', function() {
            const current = document.querySelector('.choose li.active');
            const next = current.nextElementSibling;
            if (next) {
                const target = next.getAttribute('data-target');
                changeCategory(target);
            }
        });

        hammer.on('swiperight', function() {
            const current = document.querySelector('.choose li.active');
            const prev = current.previousElementSibling;
            if (prev) {
                const target = prev.getAttribute('data-target');
                changeCategory(target);
            }
        });
    </script>

    <section class="upgrade" style="padding: 0;">
        <div class="card">
            <div class="cardText">
                <div class="cardText">
                    <!-- <p>SIMMKA - <small id="live-date"></small></p> -->
                    <p>SIMMKA</p>
                </div>
                <table class="striped-table">
                    <thead>
                        <tr>
                            <th>Jangka waktu</th>
                            <th>Nisbah Anggota</th>
                            <th>Nisbah KSPPS MELATI</th>
                            <th>Bagi Hasil</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $rowClass = 'even'; ?>
                        <?php foreach ($simulations as $simulation) : ?>
                            <tr class="<?php echo $rowClass; ?>">
                                <td>
                                    <?php echo $simulation['Jangka waktu']; ?>
                                </td>
                                <td>
                                    <?php echo $simulation['Nisbah Anggota']; ?>
                                </td>
                                <td>
                                    <?php echo $simulation['Nisbah KSPPS MELATI']; ?>
                                </td>
                                <td>Rp.
                                    <?php echo number_format($simulation['Bagi Hasil'], 0, ',', '.'); ?>
                                </td>
                            </tr>
                            <?php $rowClass = ($rowClass == 'odd') ? 'even' : 'odd'; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <small style="color: red;">*per Rp.1.000.000</small>
            </div>
        </div>
    </section>

    <section class="upgrade" style="padding: 0;">
        <div class="card islami-card">
            <div class="cardText">
                <div style="text-align: center;">
                    <p>Jadwal Imsakiyah </p> <a href="<?= base_url('users/jadwal_imsakiyah_data'); ?>" style="position: absolute; right: 0; top: 10px;">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>&nbsp;&nbsp;&nbsp;</a>
                    <p><span id="live-date"><?php echo date('d M Y'); ?></span> | <span id="live-time"></span></p>
                </div>
                <?php if ($imsakiyah) : ?>
                    <div class="imsakiyah-schedule">
                        <div class="schedule-item">
                            <span>🌙 Imsak</span>
                            <span><?php echo $imsakiyah->imsak; ?></span>
                        </div>
                        <div class="schedule-item">
                            <span>🌅 Subuh</span>
                            <span><?php echo $imsakiyah->subuh; ?></span>
                        </div>
                        <div class="schedule-item">
                            <span>☀️ Zuhur</span>
                            <span><?php echo $imsakiyah->zuhur; ?></span>
                        </div>
                        <div class="schedule-item">
                            <span>🌇 Ashar</span>
                            <span><?php echo $imsakiyah->ashar; ?></span>
                        </div>
                        <div class="schedule-item">
                            <span>🌆 Maghrib</span>
                            <span><?php echo $imsakiyah->maghrib; ?></span>
                        </div>
                        <div class="schedule-item">
                            <span>🌌 Isya</span>
                            <span><?php echo $imsakiyah->isya; ?></span>
                        </div>
                    </div>
                <?php else : ?>
                    <small style="display: block; text-align: center;">Jadwal Imsakiyah untuk hari ini belum tersedia.</small>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <style>
        .islami-card {
            /* background: url('https://app.bmtmelati.com/foto/bghero.png') no-repeat center top / cover;  */
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 20px auto;
            /* max-width: 400px; */
        }

        .imsakiyah-schedule {
            margin-top: 10px;
        }

        .schedule-item {
            display: flex;
            justify-content: space-between;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 8px;
            margin-bottom: 10px;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.05);
            font-size: 16px;
        }

        .schedule-item span:first-child {
            font-weight: bold;
            color: #2980b9;
        }

        .schedule-item span:last-child {
            color: #16a085;
            font-weight: 500;
        }

        .schedule-item:last-child {
            margin-bottom: 0;
        }

        #live-time,
        #live-date {
            color: #16a085;
        }
    </style>
    <script>
        function updateTime() {
            var now = new Date();
            var hours = now.getHours();
            var minutes = now.getMinutes();
            var seconds = now.getSeconds();

            // Tambahkan 0 jika kurang dari 10
            if (hours < 10) hours = "0" + hours;
            if (minutes < 10) minutes = "0" + minutes;
            if (seconds < 10) seconds = "0" + seconds;

            // Format waktu
            var timeString = hours + ":" + minutes + ":" + seconds;

            // Update jam di elemen dengan id 'live-time'
            document.getElementById('live-time').textContent = timeString;
        }

        // Panggil fungsi updateTime setiap detik
        setInterval(updateTime, 1000);
        updateTime(); // Panggil segera untuk menampilkan waktu langsung
    </script>


    <section class="upgrade">
        <div class="card" style="margin-bottom: 60px;">
            <div id="calendar-container" style="max-width: 100%; width: 100%; height: 300px;">
                <!-- Placeholder sebelum iframe dimuat -->
                <p style="color: gray; text-align: center;">Loading calendar...</p>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const calendarContainer = document.getElementById('calendar-container');
            const observer = new IntersectionObserver(function(entries) {
                if (entries[0].isIntersecting) {
                    // Buat iframe hanya ketika elemen masuk ke viewport
                    calendarContainer.innerHTML = `<iframe src="https://calendar.google.com/calendar/embed?height=600&wkst=1&bgcolor=%23ffffff&ctz=Asia%2FJakarta&showTitle=0&showTz=0&showCalendars=1&showDate=1&showPrint=1&hl=id&mode=MONTH&src=MzA1OTZhOGM1YjBkODgyOWIxOWJlZjNjMjFhZWFlMjlmZGYwZDkyMTMyNDc2MGNjNTc5OWYzZDVkZTNhNjI5NEBncm91cC5jYWxlbmRhci5nb29nbGUuY29t&src=aWQuaW5kb25lc2lhbiNob2xpZGF5QGdyb3VwLnYuY2FsZW5kYXIuZ29vZ2xlLmNvbQ&color=%23D50000&color=%230B8043" style="max-width: 100%;" width="100%" height="300" frameborder="0" scrolling="no" loading="lazy"></iframe>`;
                    observer.disconnect();
                }
            });
            observer.observe(calendarContainer);
        });
    </script>


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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            $(".card a.icon").click(function(e) {
                // Hapus kelas "active" dari semua elemen "card" sebelumnya
                $(".card").removeClass("active");

                // Tambahkan kelas "active" ke elemen "card" yang diklik
                $(this).closest(".card").addClass("active");
            });
            $('#btnRefreshPage').on('click', function() {
                // Reload the page, bypassing the cache
                location.reload(true);
            });
            // Sembunyikan popup saat halaman dimuat
            $("#pesanPopup").hide();

            // Tampilkan popup saat tombol pesan diklik
            $(".toggle-message").click(function() {
                $("#pesanPopup").fadeIn();
            });

            // Tutup popup saat tombol tutup diklik
            $(".close-button").click(function() {
                closePopup();
            });

            // Tutup popup saat di-klik di luar kontennya
            $(document).mouseup(function(e) {
                var container = $("#pesanPopup");
                if (!container.is(e.target) && container.has(e.target).length === 0) {
                    container.fadeOut();
                }
            });

            function updateLiveDate() {
                // Buat objek Date
                var currentDate = new Date();

                // Ambil komponen tanggal, bulan, dan tahun
                var day = currentDate.getDate();
                var month = getMonthName(currentDate.getMonth());
                var year = currentDate.getFullYear();

                // Format tanggal
                var formattedDate = day + ' ' + month + ' ' + year;

                // Tampilkan hasil pada elemen dengan id 'live-date'
                document.getElementById('live-date').innerHTML = formattedDate;
            }

            // Fungsi untuk mendapatkan nama bulan berdasarkan indeks
            function getMonthName(monthIndex) {
                var monthNames = [
                    "Januari", "Februari", "Maret",
                    "April", "Mei", "Juni", "Juli",
                    "Agustus", "September", "Oktober",
                    "November", "Desember"
                ];
                return monthNames[monthIndex];
            }

            updateLiveDate();

            // function initializeSwiper() {
            //     new Swiper('.mySwiper', {
            //         slidesPerView: 'auto',
            //         spaceBetween: 10,
            //         loop: true,
            //         centeredSlides: true,
            //         autoplay: {
            //             delay: 2500,
            //             disableOnInteraction: false,
            //         },
            //         speed: 800,
            //         effect: ['slide', 'fade'],
            //     });
            // }

            // initializeSwiper();
            // updateBlogContent();

            // Fungsi untuk menutup popup
            function closePopup() {
                $("#pesanPopup").fadeOut();
            }
            // end Script untuk menangani toggle dan menampilkan popup -->


            try {
                // Get the swipeContainer element for notification
                var notification = document.getElementById("notification");
                var swipeContainer = document.getElementById("swipeContainer");

                // Variables to track touch start and end positions
                var touchStartX = 0;
                var touchEndX = 0;

                // Add touchstart and touchend event listeners to enable swiping for notification
                swipeContainer.addEventListener("touchstart", function(e) {
                    touchStartX = e.touches[0].clientX;
                });

                swipeContainer.addEventListener("touchend", function(e) {
                    touchEndX = e.changedTouches[0].clientX;

                    // Calculate the horizontal distance swiped
                    var swipeDistance = touchEndX - touchStartX;

                    // Check if the swipe distance is greater than a threshold (e.g., 50 pixels)
                    if (Math.abs(swipeDistance) > 50) {
                        // Swipe left
                        if (swipeDistance < 0) {
                            hideNotification();
                        }
                        // Swipe right
                        else {
                            hideNotification();
                        }
                    }
                });

                // Function to hide the notification
                function hideNotification() {
                    // Get the notification element
                    var notification = document.getElementById("notification");

                    // Check if notification element exists
                    if (notification) {
                        // Hide the notification by setting its display property to 'none'
                        notification.style.display = "none";
                    } else {
                        console.error("Element with ID 'notification' not found.");
                    }
                }

                // Get the swipeContainerInformasi element for informasi
                var swipeContainerInformasi = document.getElementById("swipeContainerInformasi");

                // Variables to track touch start and end positions for informasi
                var touchStartXInformasi = 0;
                var touchEndXInformasi = 0;

                // Add touchstart and touchend event listeners to enable swiping for informasi
                swipeContainerInformasi.addEventListener("touchstart", function(e) {
                    touchStartXInformasi = e.touches[0].clientX;
                });

                swipeContainerInformasi.addEventListener("touchend", function(e) {
                    touchEndXInformasi = e.changedTouches[0].clientX;

                    // Calculate the horizontal distance swiped for informasi
                    var swipeDistanceInformasi = touchEndXInformasi - touchStartXInformasi;

                    // Check if the swipe distance is greater than a threshold (e.g., 50 pixels) for informasi
                    if (Math.abs(swipeDistanceInformasi) > 50) {
                        // Swipe left for informasi
                        if (swipeDistanceInformasi < 0) {
                            hideInformasi();
                        }
                        // Swipe right for informasi
                        else {
                            hideInformasi();
                        }
                    }
                });

                // Function to hide the informasi
                function hideInformasi() {
                    // Get the informasi element
                    var informasi = document.getElementById("informasi");

                    // Check if informasi element exists
                    if (informasi) {
                        // Hide the informasi by setting its display property to 'none'
                        informasi.style.display = "none";
                    } else {
                        console.error("Element with ID 'informasi' not found.");
                    }
                }
            } catch (error) {
                // console.error("Error:", error.message);
            }

        });
        // Animasi Tombol bell
        function animateBell() {
            const bellIcon = document.querySelector('.fa-bell');
            bellIcon.classList.add('bell-animation');
            setTimeout(() => {
                bellIcon.classList.remove('bell-animation');
            }, 500); // Adjust the duration as needed (500 milliseconds in this example)
        }


        // Select the heroContent element
        const heroContent = document.querySelector('.hero .heroContent');

        // Add a scroll event listener to the window
        window.addEventListener('scroll', () => {
            // Calculate scroll percentage
            const scrollPercentage = window.scrollY / (document.body.scrollHeight - window.innerHeight);

            // Calculate new transform values based on scroll percentage
            const scale = 1.05 + scrollPercentage * 0.1; // Scale from 1.05 to 1.15
            const translateX = 10 * scrollPercentage; // TranslateX from 0 to 10px
            const translateY = 10 * scrollPercentage; // TranslateY from 0 to 10px

            // Apply the new transform values to the pseudo-element
            heroContent.style.setProperty('--scale', scale);
            heroContent.style.setProperty('--translateX', `${translateX}px`);
            heroContent.style.setProperty('--translateY', `${translateY}px`);
        });

        // Initial transform values
        heroContent.style.setProperty('--scale', 1.05);
        heroContent.style.setProperty('--translateX', '0px');
        heroContent.style.setProperty('--translateY', '0px');

        // let swiper = new Swiper(".mySwiper", {
        //     slidesPerView: "6",
        //     spaceBetween: 1,
        //     loop: false,
        // })

        // document.addEventListener('DOMContentLoaded', function() {
        //     var menuItems = document.getElementById('customMenu');
        //     var currentIndex = 0;
        //     var startX = null;
        //     var itemWidth = menuItems.children[0].offsetWidth; 

        //     menuItems.addEventListener('mousedown', function(e) {
        //         startX = e.clientX;
        //     });

        //     menuItems.addEventListener('mouseup', function(e) {
        //         var endX = e.clientX;
        //         var threshold = 50; 
        //         if (startX && Math.abs(endX - startX) > threshold) {
        //             if (endX > startX) {
        //                 showPreviousItem();
        //             } else {
        //                 showNextItem();
        //             }
        //         }
        //         startX = null;
        //     });

        //     function showNextItem() {
        //         currentIndex = (currentIndex + 1) % menuItems.children.length;
        //         updateMenu();
        //     }

        //     function showPreviousItem() {
        //         currentIndex = (currentIndex - 1 + menuItems.children.length) % menuItems.children.length;
        //         updateMenu();
        //     }

        //     function updateMenu() {
        //         var transformValue = -currentIndex * itemWidth + 'px';
        //         menuItems.style.transform = 'translateX(' + transformValue + ')';
        //     }
        // });

        function searchMenu() {
            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById('searchMenu');
            filter = input.value.toUpperCase(); // Mengubah input menjadi huruf kapital untuk pencocokan yang lebih fleksibel
            ul = document.getElementById('menuList'); // Menargetkan div dengan id "menuList"
            li = ul.getElementsByClassName('menu-item'); // Mengambil semua item menu

            for (i = 0; i < li.length; i++) {
                a = li[i].getElementsByTagName('a')[0]; // Mengambil elemen <a> di dalam setiap li
                txtValue = a.getAttribute('data-menu-name'); // Mengambil nilai dari atribut data-menu-name (menu_name)
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    li[i].style.display = ""; // Menampilkan item jika cocok
                } else {
                    li[i].style.display = "none"; // Menyembunyikan item jika tidak cocok
                }
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            // Drag-to-scroll untuk menu
            const menuList = document.getElementById('menuList');
            let isDragging = false;
            let startX, scrollLeft;

            menuList.addEventListener('mousedown', (e) => {
                isDragging = true;
                menuList.classList.add('dragging');
                startX = e.pageX - menuList.offsetLeft;
                scrollLeft = menuList.scrollLeft;
                menuList.style.cursor = 'grabbing'; // Ganti kursor saat dragging
            });

            menuList.addEventListener('mouseleave', () => {
                isDragging = false;
                menuList.classList.remove('dragging');
                menuList.style.cursor = 'grab'; // Kembali ke kursor default
            });

            menuList.addEventListener('mouseup', () => {
                isDragging = false;
                menuList.classList.remove('dragging');
                menuList.style.cursor = 'grab'; // Kembali ke kursor default
            });

            menuList.addEventListener('mousemove', (e) => {
                if (!isDragging) return; // Berhenti jika tidak menyeret
                e.preventDefault();
                const x = e.pageX - menuList.offsetLeft;
                const walk = (x - startX) * 2; // Menyesuaikan kecepatan scroll
                menuList.scrollLeft = scrollLeft - walk;
            });

            // Event untuk membuat item menu aktif ketika diklik
            const menuItems = menuList.getElementsByClassName('menu-item');

            Array.from(menuItems).forEach((item) => {
                item.addEventListener('click', function() {
                    // Hapus kelas 'active' dari semua item
                    Array.from(menuItems).forEach(el => el.classList.remove('active'));

                    // Tambahkan kelas 'active' ke item yang diklik
                    this.classList.add('active');
                });
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
</body>

</html>
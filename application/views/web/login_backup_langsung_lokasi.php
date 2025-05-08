<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="google-site-verification" content="bR40eh0fSbqmz4PC_pJ6es28J3gJzauHPa7LPg97bx0">
    <!-- Tambahkan pustaka jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            overflow: hidden;
        }

        .btn-login {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: transform 0.2s, box-shadow 0.3s, background-color 0.3s;
            color: white;
            /* Warna teks tombol */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            /* Bayangan awal */
        }

        .btn-login:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            /* Bayangan saat dihover */
        }

        .btn-login:active {
            transform: scale(0.95);
            box-shadow: none;
            /* Menghapus bayangan saat tombol diklik */
        }

        /* Style tambahan saat tombol aktif (diklik) */
        .btn-login.active {
            transform: scale(0.95);
            box-shadow: none;
            /* Menghapus bayangan saat tombol masih aktif */
        }
    </style>
</head>

<body>

    <div class="login-container">
        <div class="login-form">
            <img src="foto/melatilogo.png" alt="Logo Melati-App" class="logo">
            <h5 class="app-name">MelatiApp</h5>
            <p class="app-version">Version 1.1</p>

            <form action="" method="post">
                <!-- Input untuk latitude -->
                <input type="hidden" id="latitude" name="latitude">
                <!-- Input untuk longitude -->
                <input type="hidden" id="longitude" name="longitude">
                <!-- Input hidden untuk device info -->
                <input type="hidden" id="deviceInfo" name="device_info">
                <!-- Tampilkan pesan set_flashdata di sini -->
                <?php if ($this->session->flashdata('msg')) : ?>
                    <?php echo $this->session->flashdata('msg'); ?>
                <?php endif; ?>

                <div class="form-group">
                    <input type="text" class="form-control" name="username" placeholder="Username" autocomplete="username" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="PIN" pattern="\d*" inputmode="numeric" autocomplete="current-password" required>
                </div>

                <button type="submit" name="btnlogin" class="btn-login">Masuk <i class="icon-circle-right2 position-right"></i></button>
            </form>
            <br>
            <!-- Text link for "Daftar" -->
            <p><a href="web/daftar">Daftar</a></p>
        </div>
    </div>

    <script>
        var deviceInfo;

        // Panggil getLocation() saat halaman dimuat
        document.addEventListener("DOMContentLoaded", function() {
            getLocation();
            getDeviceInfo();
        });

        function getLocation() {
            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var latitude = position.coords.latitude;
                    var longitude = position.coords.longitude;

                    document.getElementById('latitude').value = latitude;
                    document.getElementById('longitude').value = longitude;

                    sendLocationToServer(latitude, longitude);
                }, function(error) {
                    console.error('Error getting location:', error);
                });
            } else {
                console.error('Geolocation is not supported.');
            }
        }

        function sendLocationToServer(latitude, longitude) {
            var data = {
                latitude: latitude,
                longitude: longitude
            };

            // Mengirim data ke server PHP menggunakan AJAX
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('users/update_location'); ?>", // Ganti dengan URL yang sesuai
                data: data,
                success: function(response) {
                    // Sukses, Anda dapat menangani respons jika diperlukan
                },
                error: function(error) {
                    console.error('Error updating location:', error);
                }
            });
        }

        function getDeviceInfo() {
            // Mendapatkan user agent dari navigator
            const originalUserAgent = navigator.userAgent;

            // Menghilangkan bagian setelah "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36"
            const filteredUserAgent = originalUserAgent.replace(/Chrome\/\d+\.\d+\.\d+\.\d+/i, '');

            // Membuat objek deviceInfo tanpa bagian yang dihapus
            const deviceInfo = {
                userAgent: filteredUserAgent,
                platform: navigator.platform,
                // Informasi perangkat lainnya sesuai kebutuhan Anda
            };

            // Mengubah objek deviceInfo menjadi JSON
            var deviceInfoJSON = JSON.stringify(deviceInfo);

            // Menyimpan deviceInfo ke input hidden
            document.getElementById('deviceInfo').value = deviceInfoJSON;

            // Mengirim data device_info ke server sebagai teks JSON
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('users/update_device_info'); ?>",
                data: {
                    device_info: deviceInfoJSON
                }, // Mengirim deviceInfo sebagai teks JSON
                success: function(response) {
                    // Handle respons dari server jika diperlukan
                },
                error: function(error) {
                    console.error('Error updating device info:', error);
                }
            });
        }

        // Temukan tombol "Masuk" berdasarkan kelasnya
        var loginButton = document.querySelector('.btn-login');

        // Tambahkan event listener untuk mengaktifkan animasi saat tombol diklik
        loginButton.addEventListener('click', function() {
            // Tambahkan kelas "active" untuk memulai animasi
            loginButton.classList.add('active');

            // Set timeout untuk menghilangkan kelas "active" setelah animasi selesai
            setTimeout(function() {
                loginButton.classList.remove('active');
            }, 200); // Waktu animasi (0.2 detik) dalam milidetik
        });
    </script>

</body>

</html>
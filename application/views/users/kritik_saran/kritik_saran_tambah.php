<?php
// Pastikan $user adalah objek hasil query yang valid sebelum memprosesnya
if (isset($user) && is_object($user) && $user->num_rows() > 0) {
    $cek = $user->row();
    $id_user = $cek->id_user;
} else {
    // Jika tidak ada pengguna yang login, gunakan nilai default
    $id_user = "0"; // Atau gunakan nilai default yang sesuai
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kritik & Saran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }

        .form-group input[type="submit"]:hover {
            background-color: #dc3c31;
        }

        .btn-back {
            background-color: #e9ecef;
            color: #495057;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            text-decoration: none;
            border-radius: 4px;
        }

        .btn-back:hover {
            background-color: #dee2e6;
        }

        .submit-btn {
            text-align: right;
        }

        .form-group input[type="submit"] {
            position: relative;
            background-color: #f44336;
            color: white;
            border: none;
            cursor: pointer;
            padding: 10px;
            font-size: 16px;
            border-radius: 4px;
            overflow: hidden;
            transition: background-color 0.3s, transform 0.2s;
        }

        .form-group input[type="submit"]:hover {
            background-color: #d32f2f;
        }

        .form-group input[type="submit"]:active {
            background-color: #b71c1c;
            transform: scale(0.95);
        }

        .navigation-buttons {
            margin-bottom: 20px;
        }

        .panel {
            background-color: white;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .panel-body {
            padding: 20px;
        }

        @media (max-width: 600px) {
            .container {
                padding: 10px;
            }

            .form-group input,
            .form-group textarea,
            .form-group select {
                padding: 8px;
            }
        }

        /* Flexbox for horizontal layout */
        .form-row {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .form-group.full-width {
            flex: 1 1 100%;
            /* Full width for single column elements */
            padding: 10px;
        }

        .form-group.half-width {
            flex: 1;
            /* Half width for two-column elements */
            padding: 10px;
        }

        ::placeholder {
        text-transform: none;
    }
    </style>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="container">
        <!-- Content area -->
        <div class="panel">
            <div class="panel-body">
                <div class="navigation-buttons">
                    <div>
                        <i class="fa fa-comments"></i> Form Kritik & Saran KSPPS MELATI
                    </div>
                </div>
                <!-- Form untuk menambahkan kritik saran -->
                <form id="myForm" action="<?php echo site_url('users/kritik_saran_submit'); ?>" method="post">
                    <div class="form-row">
                        <div class="form-group half-width">
                            <label for="nama">Nama<span style="color: red;">*</span></label>
                            <input type="text" name="nama" id="nama" placeholder="Masukkan nama" required style="text-transform: uppercase;">
                        </div>

                        <div class="form-group half-width">
                            <label for="no_telepon">No Telepon</label>
                            <input type="text" name="no_telepon" id="no_telepon" placeholder="Masukkan no telepon" inputmode="numeric" pattern="[0-9]*">
                        </div>
                    </div>
                    <div class="form-group full-width">
                        <label for="alamat">Alamat</label>
                        <input type="text" name="alamat" id="alamat" placeholder="Masukkan alamat">
                    </div>
                    <div class="form-group full-width" style="display: none;">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                    <div class="form-group full-width" style="display: none;">
                        <label for="status">Status:</label>
                        <select name="status" id="status" required>
                            <option value="0" selected>Belum Ditanggapi</option>
                            <option value="1">Sudah Ditanggapi</option>
                        </select>
                    </div>

                    <div class="form-group full-width">
                        <label for="kritik_saran">Kritik / Saran<span style="color: red;">*</span></label>
                        <textarea name="kritik_saran" id="kritik_saran" rows="4" placeholder="Masukkan kritik atau saran" required></textarea>
                    </div>
                    <input type="hidden" name="id_user" id="id_user" class="form-control" value="<?php echo $id_user; ?>" readonly>


                    <div class="form-group submit-btn">
                        <input type="submit" value="Kirim" id="submitBtn">
                    </div>
                </form>
                <!-- /Form untuk menambahkan kritik saran -->
            </div>
        </div>
    </div>
</body>

</html>
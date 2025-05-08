<?php
$menu = strtolower($this->uri->segment(1));
$sub_menu = strtolower($this->uri->segment(2));
$sub_menu3 = strtolower($this->uri->segment(3));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <base href="<?php echo base_url(); ?>"/>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?php echo $judul_web; ?>
    </title>
    <link rel="icon" type="image/png" href="images/error-404.png">
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Global stylesheets -->
    <link href="assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="assets/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="assets/css/core.css" rel="stylesheet" type="text/css">
    <link href="assets/css/components.css" rel="stylesheet" type="text/css">
    <link href="assets/css/colors.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="assets/css/main.css" rel="stylesheet" type="text/css">
    <link href="assets/css/melatiapp.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->
</head>

<body>
    <div class="container-fluid d-flex align-items-center justify-content-center min-vh-100">
        <div class="text-center">
            <img src="assets/images/error-403.png" alt="" class="img-fluid mb-2" style="max-width: 150px;" />
            <div class="error-text">
                <span class="large-text font-weight-bold">Anda tidak memiliki hak akses</span>
            </div>
            <a class="btn btn-danger mt-3" href="<?php echo base_url(); ?>" style="background-color: #E84C4F;">Menu Utama</a>
        </div>
    </div>
    <!-- Add Bootstrap JS and Popper.js scripts (required for Bootstrap components) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Page container -->
    <div class="page-container">
        <!-- Page content -->
        <div class="page-content">
            <div class="bottom-navbar">
                <button class="<?php if ($sub_menu == "") {
                    echo 'active';
                } ?>">
                    <a href="users/"><i class='fa fa-home'></i></a>
                </button>
                <button class="<?php if ($sub_menu == "berita") {
                    echo 'active';
                } ?>">
                    <a href="users/berita"><i class="fa fa-newspaper"></i></a>
                </button>
                <button onclick="handleClickPlus(event)" class="float">
                    <a href="users/sm/t"><i class='fa fa-plus' style="font-size: 25px;"></i></a>
                </button>
                <button class="<?php if ($sub_menu == "kantor") {
                    echo 'active';
                } ?>">
                    <a href="users/kantor"><i class='fa fa-building'></i></a>
                </button>
                <button class="<?php if ($sub_menu == "profile") {
                    echo 'active';
                } ?>">
                    <a href="users/profile"><i class='fa fa-user-gear'></i></a>
                </button>
            </div>
        </div>
    </div>
    <!--cek tambahan-->
    <!--cek tambahan selesai-->
</body>
</html>

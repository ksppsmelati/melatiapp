<!-- Tambahkan SweetAlert2 CSS dan Font Awesome CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

<div class="panel panel-body login-form">
    <!-- Container for displaying messages -->
    <div id="msg-container">
        <?php if (!empty($msg_success)) : ?>
            <div class="alert alert-success"><?= $msg_success ?></div>
        <?php endif; ?>
        <?php if (!empty($msg_error)) : ?>
            <div class="alert alert-danger"><?= $msg_error ?></div>
        <?php endif; ?>
    </div>
    <h3>Daftar Akun</h3>
    <form id="form-daftar" class="form-horizontal" method="POST">

        <!-- Jenis kelamin input field -->
        <div class="form-group">
            <label for="jenis_kelamin" class="control-label col-md-3">Gender</label>
            <div class="col-md-9">
                <select class="form-control" name="jenis_kelamin" id="jenis_kelamin" required>
                    <option value="" selected disabled>Pilih Gender</option>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>
        </div>

        <!-- Username input field -->
        <div class="form-group">
            <label for="username" class="control-label col-md-3">Username:</label>
            <div class="col-md-9">
                <input type="text" class="form-control" placeholder="Masukkan Username" name="username" id="username" required>
                <p id="username-verification" class="text-danger"></p>
            </div>
        </div>


        <!-- Password input field -->
        <div class="form-group">
            <label for="password" class="control-label col-md-3">PIN:</label>
            <div class="col-md-9">
                <div class="input-group">
                    <input type="password" class="form-control" placeholder="Masukkan PIN" pattern="\d*" inputmode="numeric" name="password" id="password" required>
                    <span class="input-group-addon toggle-password" id="show-password">
                        <i class="fa fa-eye" aria-hidden="true"></i>
                    </span>
                </div>
                <p id="password-mismatch" class="text-danger"></p>
            </div>
        </div>

        <!-- Buttons aligned to the center -->
        <div class="form-group">
            <div class="col-md-offset-3 col-md-9 text-center">
                <button type="button" class="btn btn-default" onclick="history.go(-1);" style="float: left;">Kembali</button>
                <button type="submit" class="btn btn-danger" name="btndaftar" id="btndaftar" style="float: right;">Daftar</button>
            </div>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

<script>
    $(document).ready(function() {
        // Toggle password visibility
        $('.toggle-password').click(function() {
            var passwordField = $('#password');
            var fieldType = passwordField.attr('type');

            if (fieldType === 'password') {
                passwordField.attr('type', 'text');
                $('#show-password i').removeClass('fa-eye');
                $('#show-password i').addClass('fa-eye-slash');
            } else {
                passwordField.attr('type', 'password');
                $('#show-password i').removeClass('fa-eye-slash');
                $('#show-password i').addClass('fa-eye');
            }
        });
        // Check if the redirect flag is set, and if so, redirect
        <?php if (isset($redirect) && $redirect === true) : ?>
            setTimeout(function() {
                window.location.href = '<?= base_url('web/login'); ?>'; // Redirect to the login page
            }, 1500); // Delay for 1 seconds (1000 milliseconds)
        <?php endif; ?>
    });
</script>
<?php
$user = $user->row();
$level = $user->level;
$nama_lengkap = $user->nama_lengkap;
$thumbnailURL = (!empty($user->foto_profile) && file_exists('./foto/foto_profile/' . $user->foto_profile)) ? './foto/foto_profile/' . $user->foto_profile : 'foto/default.png';
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.css">

<style>
    .profile-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 20px;
        background-color: #f8f9fa;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        max-width: 400px;
        margin: 0 auto;
    }

    .profile-image {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #6c757d;
    }

    .profile-name {
        margin-top: 15px;
        font-size: 1.25rem;
        font-weight: bold;
        color: #343a40;
    }

    .preview-image {
        margin-top: 20px;
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
        display: none;
    }

    .swal2-popup {
        width: auto !important;
    }
</style>

<div class="container">
    <div class="content">
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <fieldset class="content-group">
                        <div class="navigation-buttons">
                            <div class="btn-group" style="float: left;">
                                <i class="icon-pencil7"></i> Edit Foto Profil
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr>
                        <?php
                        $thumbnailURL = (!empty($user->foto_profile) && file_exists('./foto/foto_profile/' . $user->foto_profile)) ? './foto/foto_profile/' . $user->foto_profile : 'foto/default.png';
                        ?>

                        <div class="text-center">
                            <!-- Preview Foto Profil -->
                            <img id="profilePreview" src="<?php echo base_url($thumbnailURL); ?>" alt="Foto Profil" class="rounded-circle img-thumbnail" style="width: 150px; height: 150px;">
                        </div>
                        <br>
                        <form id="myForm" action="<?php echo site_url('users/update_foto_profile'); ?>" method="post" enctype="multipart/form-data" class="mt-4">
                            <div class="upload-btn-wrapper text-center">
                                <label for="fotoProfileUpload" class="btn btn-secondary btn-upload">
                                    <i class="fa fa-upload"></i> Pilih Foto
                                </label>
                                <input type="file" id="fotoProfileUpload" name="foto_profile" accept="image/*" onchange="previewImage(event, 'profilePreview')" style="display: none;">
                            </div>
                            <br>
                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-danger"><i class="fa fa-save"></i> Simpan</button>
                            </div>
                        </form>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .img-thumbnail {
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid #ddd;
    }
</style>

<script>
    // Preview gambar sebelum diunggah
    function previewImage(event, previewId) {
        const file = event.target.files[0];
        const previewElement = document.getElementById(previewId);

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewElement.src = e.target.result; // Set preview image src
            }
            reader.readAsDataURL(file);
        }
    }

    // Kompres gambar menggunakan Compressor.js saat upload
    document.getElementById('fotoProfileUpload').addEventListener('change', function(event) {
        const file = event.target.files[0];

        if (file) {
            new Compressor(file, {
                quality: 0.3,
                success(result) {
                    const timestamp = Date.now();
                    const fileExtension = file.name.split('.').pop();
                    const uniqueFileName = `profile_${timestamp}.${fileExtension}`;

                    const compressedFile = new File([result], uniqueFileName, {
                        type: result.type,
                        lastModified: timestamp
                    });

                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(compressedFile);
                    event.target.files = dataTransfer.files;
                },
                error(err) {
                    console.error('Gagal melakukan kompresi:', err.message);
                },
            });
        }
    });
</script>
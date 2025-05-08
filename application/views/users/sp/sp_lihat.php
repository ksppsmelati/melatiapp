<style type="text/css">
    .custom-popup-content {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
    }

    .popup-image-container {
        max-width: 100%;
        max-height: 100%;
        width: auto;
        height: auto;
    }

    .popup-image {
        max-width: 100%;
        max-height: 100%;
        width: auto;
        height: auto;
    }

    /* Custom styles for the popup */
    .custom-popup-content {
        padding: 0;
        /* Remove padding */
        background: none;
        /* Remove background */
        box-shadow: none;
        /* Remove box-shadow */
    }

    /* Custom styles for the close button */
    .custom-popup-close-button {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 40px;
        color: #fff;
        /* Change color if needed */
        cursor: pointer;
        background: transparent;
        border: none;
    }

    .gambar {
        width: 30px;
        /* Set the width of the thumbnail */
        height: 30px;
        /* Set the height of the thumbnail */
        object-fit: cover;
        /* Ensure the image covers the area and maintains aspect ratio */
        display: block;
        /* padding: 3px; */
        /* margin-bottom: 20px; */
        line-height: 1.5384616;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 3px;
        -webkit-transition: border .2s ease-in-out;
        -o-transition: border .2s ease-in-out;
        transition: border .2s ease-in-out;
    }

    .modal-content {
        border-radius: 10px;
    }
</style>
<link rel="stylesheet" type="text/css" href="assets/upload/dropzone.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.css">

<script src="assets/js/select2.min.js"></script>
<script src="assets/js/jquery-ui.js"></script>
<script type="text/javascript" src="assets/js/core/app.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.js"></script>
<script type="text/javascript" src="assets/upload/dropzone.min.js"></script>

<div class="container">
    <div class="content">
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <fieldset class="content-group">
                        <div class="navigation-buttons">
                            <form class="form-horizontal" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label col-lg-3" style="font-weight: bold;">No Kontrak</label>
                                            <div class="col-lg-9">
                                                <input type="text" name="nokontrak" id="nokontrak" class="form-control" value="<?php echo $sp_data->nokontrak; ?>" readonly required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label col-lg-3" style="font-weight: bold;">Nama Anggota</label>
                                            <div class="col-lg-9">
                                                <input type="text" name="nama" id="nama" class="form-control" value="<?php echo $sp_data->nama; ?>" readonly required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label col-lg-3" style="font-weight: bold;">Alamat</label>
                                            <div class="col-lg-9">
                                                <input type="text" name="alamat" id="alamat" class="form-control" value="<?php echo $sp_data->alamat; ?>" readonly required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label col-lg-3" style="font-weight: bold;">Kode Produk</label>
                                            <div class="col-lg-9">
                                                <input type="text" name="kdprd" id="kdprd" class="form-control" value="<?php echo $sp_data->kdprd; ?>" readonly required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label col-lg-3" style="font-weight: bold;">Telepon</label>
                                            <div class="col-lg-9">
                                                <input type="text" name="hp" id="hp" class="form-control" value="<?php echo $sp_data->hp; ?>" readonly required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label col-lg-3" style="font-weight: bold;">No Akad</label>
                                            <div class="col-lg-9">
                                                <input type="text" name="noakad" id="noakad" class="form-control" value="<?php echo $sp_data->noakad; ?>" readonly required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label col-lg-3" style="font-weight: bold;">Tgl Akad</label>
                                            <div class="col-lg-9">
                                                <input type="text" name="tglakad" id="tglakad" class="form-control" value="<?php echo $sp_data->tglakad; ?>" readonly required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label col-lg-3" style="font-weight: bold;">O/S Awal</label>
                                            <div class="col-lg-9">
                                                <input type="text" name="mdlawal" id="mdlawal" class="form-control" value="<?php echo $sp_data->mdlawal; ?>" readonly required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label col-lg-3" style="font-weight: bold;">Tanggal Jatuh Tempo</label>
                                            <div class="col-lg-9">
                                                <input type="text" name="tglexp" id="tglexp" class="form-control" value="<?php echo $sp_data->tglexp; ?>" readonly required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label col-lg-3" style="font-weight: bold;">StsRec</label>
                                            <div class="col-lg-9">
                                                <input type="text" name="stsrec" id="stsrec" class="form-control" value="<?php echo $sp_data->stsrec; ?>" readonly required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label col-lg-3" style="font-weight: bold;">Pembayaran Setiap Tgl</label>
                                            <div class="col-lg-9">
                                                <input type="text" name="ddtagih" id="ddtagih" class="form-control" value="<?php echo $sp_data->ddtagih; ?>" readonly required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="clearfix"></div>
                                    <hr>
                                    <div class="row" style="font-size: 80%; opacity: 0.7;">
                                        <div class="col-xs-6 col-sm-6">
                                            <label class="control-label" style="font-weight: bold;">inpdate:</label>
                                            <span><?php echo $sp_data->inptgl; ?></span>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                            <label class="control-label" style="font-weight: bold;">inpuser:</label>
                                            <span><?php echo $sp_data->inpuser; ?></span>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                            <label class="control-label" style="font-weight: bold;">chdate:</label>
                                            <span><?php echo $sp_data->chgtgl; ?></span>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                            <label class="control-label" style="font-weight: bold;">chuser:</label>
                                            <span><?php echo $sp_data->chguser; ?></span>
                                        </div>
                                    </div>

                                </div>
                            </form>
                            <!-- Modal Pesan -->
                            <div class="modal fade" id="shareModal" tabindex="-1" role="dialog" aria-labelledby="shareModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="shareModalLabel">Pesan sp_data</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="shareNote">Catatan:</label>
                                                <textarea class="form-control" id="shareNote" rows="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                            <button type="button" class="btn btn-danger" id="shareButton">Kirim</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    function openPopup(imageURL) {
        Swal.fire({
            html: `<img src="${imageURL}" class="popup-image" />`,
            showCloseButton: true,
            showConfirmButton: false,
            customClass: {
                content: 'custom-popup-content',
                closeButton: 'custom-popup-close-button'
            }
        });
    }
</script>
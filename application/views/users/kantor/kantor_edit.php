<div class="container">
    <div class="content">
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <fieldset class="content-group">
                        <div class="navigation-buttons">
                            <div class="btn-group" style="float: left;">
                                <i class="icon-pencil7"></i> EDIT - ID: <?php echo $kantor_data->id; ?><br>
                            </div>
                            <div class="btn-group" style="float: right;">
                                <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-bars"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                    <li><a href="<?php echo site_url('users/kantor_tambah'); ?>"><i class="fa fa-plus"></i> Tambah Kantor</a></li>
                                    <li><a href="<?php echo site_url('users/kantor_data'); ?>"><i class="fa fa-television"></i> Data Kantor</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr>

                        <form class="form-horizontal" id="myForm" action="<?php echo site_url('users/kantor_update/' . $kantor_data->id); ?>" enctype="multipart/form-data" method="post">
                            <div class="row">

                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" style="font-weight: bold;">Kode Kantor</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="kode_kantor" id="kode_kantor" class="form-control" value="<?php echo $kantor_data->kode_kantor; ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" style="font-weight: bold;">Nama Kantor</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="nama_kantor" id="nama_kantor" class="form-control" value="<?php echo $kantor_data->nama_kantor; ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" style="font-weight: bold;">Alamat</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="alamat" id="alamat" class="form-control" value="<?php echo $kantor_data->alamat; ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" style="font-weight: bold;">Link Map</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="link_map" id="link_map" class="form-control" value="<?php echo $kantor_data->link_map; ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" style="font-weight: bold;">Telepon</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="telepon" id="telepon" class="form-control" value="<?php echo $kantor_data->telepon; ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" style="font-weight: bold;">Email</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="email" id="email" class="form-control" value="<?php echo $kantor_data->email; ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" style="font-weight: bold;">Latitude </label>
                                        <div class="col-lg-9">
                                            <input type="text" name="latitude" id="latitude" class="form-control" value="<?php echo $kantor_data->latitude; ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" style="font-weight: bold;">Longitude </label>
                                        <div class="col-lg-9">
                                            <input type="text" name="longitude" id="longitude" class="form-control" value="<?php echo $kantor_data->longitude; ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3" style="font-weight: bold;">Status</label>
                                        <div class="col-lg-9">
                                            <select name="status" id="status" class="form-control" required>
                                                <option value="aktif" <?php echo ($kantor_data->status == 'aktif') ? 'selected' : ''; ?>>Aktif</option>
                                                <option value="nonaktif" <?php echo ($kantor_data->status == 'nonaktif') ? 'selected' : ''; ?>>Nonaktif</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix"></div>
                                <hr>
                                <a href="users/kunjungan_data" class="btn btn-default">
                                    << Kembali</a>
                                        <button type="submit" id="submit" class="btn btn-danger" style="float:right;">Update</button>
                        </form>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
</div>
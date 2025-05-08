<div class="container">
    <!-- Content area -->
    <div class="content">

        <!-- Edit Info content -->
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <fieldset class="content-group">
                        <legend class="text-bold"><i class="icon-cog"></i> Edit Info SIMMKA</legend>
                        <?php echo $this->session->flashdata ('msg'); ?>
                        <form class="form-horizontal" action="<?= base_url('users/edit_info'); ?>" method="post">
                            <input type="hidden" name="id" value="<?= isset($info[0]['id']) ? $info[0]['id'] : ''; ?>">

                            <div class="row">

                                <div class="col-xs-4">
                                    <div class="form-group">
                                        <input type="text" name="info_9" class="form-control" value="<?= set_value('info_9', isset($info[0]['info_9']) ? $info[0]['info_9'] : ''); ?>" placeholder="Info_9">
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="form-group">
                                        <input type="text" name="info_1" class="form-control" value="<?= set_value('info_1', isset($info[0]['info_1']) ? $info[0]['info_1'] : ''); ?>" placeholder="Info_1">
                                    </div>
                                </div>

                                <div class="col-xs-4">
                                    <div class="form-group">
                                        <input type="text" name="info_5" class="form-control" value="<?= set_value('info_5', isset($info[0]['info_5']) ? $info[0]['info_5'] : ''); ?>" placeholder="Info_5">
                                    </div>
                                </div>

                                <div class="col-xs-4">
                                    <div class="form-group">
                                        <input type="text" name="info_10" class="form-control" value="<?= set_value('info_10', isset($info[0]['info_10']) ? $info[0]['info_10'] : ''); ?>" placeholder="Info_10">
                                    </div>
                                </div>


                                <div class="col-xs-4">
                                    <div class="form-group">
                                        <input type="text" name="info_2" class="form-control" value="<?= set_value('info_2', isset($info[0]['info_2']) ? $info[0]['info_2'] : ''); ?>" placeholder="Info_2">
                                    </div>
                                </div>

                                <div class="col-xs-4">
                                    <div class="form-group">
                                        <input type="text" name="info_6" class="form-control" value="<?= set_value('info_6', isset($info[0]['info_6']) ? $info[0]['info_6'] : ''); ?>" placeholder="Info_6">
                                    </div>
                                </div>

                                <div class="col-xs-4">
                                    <div class="form-group">
                                        <input type="text" name="info_11" class="form-control" value="<?= set_value('info_11', isset($info[0]['info_11']) ? $info[0]['info_11'] : ''); ?>" placeholder="Info_11">
                                    </div>
                                </div>

                                <div class="col-xs-4">
                                    <div class="form-group">
                                        <input type="text" name="info_3" class="form-control" value="<?= set_value('info_3', isset($info[0]['info_3']) ? $info[0]['info_3'] : ''); ?>" placeholder="Info_3">
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="form-group">
                                        <input type="text" name="info_7" class="form-control" value="<?= set_value('info_7', isset($info[0]['info_7']) ? $info[0]['info_7'] : ''); ?>" placeholder="Info_7">
                                    </div>
                                </div>

                                <div class="col-xs-4">
                                    <div class="form-group">
                                        <input type="text" name="info_13" class="form-control" value="<?= set_value('info_13', isset($info[0]['info_13']) ? $info[0]['info_13'] : ''); ?>" placeholder="Info_13">
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="form-group">
                                        <input type="text" name="info_14" class="form-control" value="<?= set_value('info_14', isset($info[0]['info_14']) ? $info[0]['info_14'] : ''); ?>" placeholder="Info_14">
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="form-group">
                                        <input type="text" name="info_15" class="form-control" value="<?= set_value('info_15', isset($info[0]['info_15']) ? $info[0]['info_15'] : ''); ?>" placeholder="Info_15">
                                    </div>
                                </div>


                                <div class="col-xs-4">
                                    <div class="form-group">
                                        <input type="text" name="info_12" class="form-control" value="<?= set_value('info_12', isset($info[0]['info_12']) ? $info[0]['info_12'] : ''); ?>" placeholder="Info_12">
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="form-group">
                                        <input type="text" name="info_4" class="form-control" value="<?= set_value('info_4', isset($info[0]['info_4']) ? $info[0]['info_4'] : ''); ?>" placeholder="Info_4">
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="form-group">
                                        <input type="text" name="info_8" class="form-control" value="<?= set_value('info_8', isset($info[0]['info_8']) ? $info[0]['info_8'] : ''); ?>" placeholder="Info_8">
                                    </div>
                                </div>
                                <button type="submit" name="btnupdate" class="btn btn-danger" style="float:right;">Simpan</button>
                            </div>
                        </form>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
</div>

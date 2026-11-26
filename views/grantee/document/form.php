<?php

$active_country = $this->session->userdata('active_country');

$default_tab_active = 'class="active"';
$default_content_active = 'active in';
if ($pid) {
    $default_tab_active = '';
    $default_content_active = '';
}
?>

<style>
    td {
        height: 80px;
        vertical-align: top;
        padding:10px;
        font-weight:bold;
    }
    tr {
        margin-top:20px;
    }
</style>

<div class="modal"></div>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header text-center"><?php echo $title ?></h1>
    </div>
</div>
<?php if (isset($notif_success) && $notif_success != '') { ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo $notif_success ?>
    </div>
<?php } ?>
<?php if (isset($notif_error) && $notif_error != '') { ?>
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo $notif_error ?>
    </div>
<?php } ?>

<form id="form" role="form" method="POST" enctype="multipart/form-data">
    <div class="row">
        <div class="tab-content">
            <div id="upload" class="tab-pane fade <?= $default_content_active ?>">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> PRE-DEPATURE<br />
                            <div class="col-lg-4">
                                <label>ToA of Gateway/Pre-Academic/Summer Program</label>
                                <p id="file_name1" style="font-size:16px">No file chosen</p>
                                <a href="javascript:;" class="btn btn-danger" id="btn-upload1">Upload</a>
                                <input type="file" id="my_file1" style="display: none;">
                                <small class="file-for-testing">File Size Max 5MB</small>
                                <a class="btn btn-success">save</a>
                                <hr>
                            </div>
                            <div class="col-lg-4">
                                <label>ToA of Academic Program </label>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <p id="file_name2" style="font-size:16px">IMG_PHOTO_1.JPEG</p>
                                    </div>
                                    <div class="col-lg-6">
                                        <a href="#"><i class="fa fa-trash fa-fw fa-2x"></i></a>
                                        <a href="#"><i class="fa fa-eye fa-fw fa-2x"></i></a>
                                    </div>
                                </div>
                                <a href="javascript:;" class="btn btn-danger" id="btn-upload2" disabled="disabled">Upload</a>
                                <input type="file" id="my_file2" style="display: none;">
                                <small class="file-for-testing">File Size Max 5MB</small>
                                <a class="btn btn-success">save</a>
                                <hr>
                            </div>
                            <div class="col-lg-4">
                                <label>Grant Document (for Visiting Scholars)</label>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <p id="file_name2" style="font-size:16px">IMG_PHOTO_1.JPEG</p>
                                    </div>
                                    <div class="col-lg-6">
                                        <a href="#"><i class="fa fa-trash fa-fw fa-2x"></i></a>
                                        <a href="#"><i class="fa fa-eye fa-fw fa-2x"></i></a>
                                    </div>
                                </div>
                                <a href="javascript:;" class="btn btn-danger" id="btn-upload2" disabled="disabled">Upload</a>
                                <input type="file" id="my_file3" style="display: none;">
                                <small class="file-for-testing">File Size Max 5MB</small>
                                <a class="btn btn-success">save</a>
                                <hr>
                            </div>
                        </div>

                        
                        <div class="panel-body mt-3">
                            <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> PRE-DEPATURE<br />
                            <div class="col-lg-4">
                                <label>ToA of Gateway/Pre-Academic/Summer Program</label>
                                <p id="file_name1" style="font-size:16px">No file chosen</p>
                                <a href="javascript:;" class="btn btn-danger" id="btn-upload1">Upload</a>
                                <input type="file" id="my_file1" style="display: none;">
                                <small class="file-for-testing">File Size Max 5MB</small>
                                <a class="btn btn-success">save</a>
                                <hr>
                            </div>
                            <div class="col-lg-4">
                                <label>ToA of Academic Program </label>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <p id="file_name2" style="font-size:16px">IMG_PHOTO_1.JPEG</p>
                                    </div>
                                    <div class="col-lg-6">
                                        <a href="#"><i class="fa fa-trash fa-fw fa-2x"></i></a>
                                        <a href="#"><i class="fa fa-eye fa-fw fa-2x"></i></a>
                                    </div>
                                </div>
                                <a href="javascript:;" class="btn btn-danger" id="btn-upload2" disabled="disabled">Upload</a>
                                <input type="file" id="my_file2" style="display: none;">
                                <small class="file-for-testing">File Size Max 5MB</small>
                                <a class="btn btn-success">save</a>
                                <hr>
                            </div>
                            <div class="col-lg-4">
                                <label>Grant Document (for Visiting Scholars)</label>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <p id="file_name2" style="font-size:16px">IMG_PHOTO_1.JPEG</p>
                                    </div>
                                    <div class="col-lg-6">
                                        <a href="#"><i class="fa fa-trash fa-fw fa-2x"></i></a>
                                        <a href="#"><i class="fa fa-eye fa-fw fa-2x"></i></a>
                                    </div>
                                </div>
                                <a href="javascript:;" class="btn btn-danger" id="btn-upload2" disabled="disabled">Upload</a>
                                <input type="file" id="my_file3" style="display: none;">
                                <small class="file-for-testing">File Size Max 5MB</small>
                                <a class="btn btn-success">save</a>
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</form>

<div class="modal fade text-center" id="mdl_info" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <p>Are you sure <br /> to delete <b><?= $title ?></b>?</p>
                <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                <a href="<?= site_url('admin/grantee/delete/' . $this->Grantee_ent_model->id) ?>" id="submit" class="btn btn-success success">Yes</a>
            </div>
        </div>
    </div>
</div>
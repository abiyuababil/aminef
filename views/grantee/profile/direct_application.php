<!-- <div class="row">
    <div class="col-lg-12 text-center">
        <h2 style="color:#0089d1">Direct Application</h2>
        <h1 class="page-header"><?php echo $grantee_grant->grant_name ?></h1>
    </div>
</div> -->
<div class="row">
<!-- <div id="submission-plan" class="tab-pane fade"> -->
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <?php //if($grantee_grant->submission_result_id == ''){ ?>
                <div class="pull-right mb-2">
                    <?php if(!$grantee_grant->submission_result_id) { ?>
                    <a href="<?= site_url('grantee/direct_application/add/'.$grantee_grant->user_grantee_id)?>" class="btn btn-success btn-sm">
                        Add New Direct Application
                    </a>
                    <?php } ?>
                </div>
                <?php //} ?>
                <table class="table table-striped table-responsive">
                    <thead>
                        <tr>
                            <th>University</th>
                            <th>Support Letter</th>
                            <!-- <th>Status</th> -->
                            <th width="200" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($direct_applications as $direct_application) : ?>
                            <tr>
                                <td><?= $direct_application->university_name; ?></td>
                                <!-- <td><?= badge_approved_declined($direct_application->status); ?></td> -->
                                <td>
                                    <?php if($direct_application->support_letter) { ?>
                                        <a class="btn btn-primary btn-xs lightbox" href="<?= base_url($direct_application->support_letter)?>">View</a>
                                    <?php } ?>
                                </td>
                                <?php if($grantee_grant->submission_result_id == ''){ ?>
                                    <td class="text-center" style="position:relative;">
                                        <?php //if($direct_application->is_authorize) { ?>
                                        <?php if($direct_application->deleteable_grantee) { ?>
                                        <a href="<?php echo site_url('grantee/direct_application/edit/'.$grantee_grant->user_grantee_id.'/'.$direct_application->id) ?>" class="btn btn-primary btn-xs">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>

                                        <a href="<?php echo site_url('grantee/direct_application/delete/'.$grantee_grant->user_grantee_id.'/'.$direct_application->id) ?>" onclick="return confirm('Are you sure want to delete this data?')" class="btn btn-danger btn-xs">
                                            <i class="fa fa-times-circle"></i> Delete
                                        </a>
                                        <?php } ?>

                                        <?php //} ?>
                                    </td>
                                <?php } else { ?>
                                    <td class="text-center" style="position:relative;"><input data-id="<?= $direct_application->id ?>" data-toggle="modal" data-target="#modal-detail-direct" type="button" class="btn-xs btn btn-primary view-detail-direct" value="Detail"></td>
                                <?php } ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<!-- </div> -->
</div>


<div class="modal fade text-center" id="modal-detail-direct" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Detail</h2>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div id="show_data_direct">

                        </div>                       
                    </div>
                    <div class="col-lg-6">
                        <div id="show_data_direct2">

                        </div>                
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
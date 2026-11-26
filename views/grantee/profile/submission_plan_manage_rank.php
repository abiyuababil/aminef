<div class="row">
    <div class="col-lg-12 text-center">
        <h2 style="color:#0089d1">Manage Rank Submission Plan</h2>
        <h1 class="page-header"><?php echo $grantee_grant->grant_name ?></h1>
    </div>
</div>
<div class="row">
    <form method="POST">
        <div class="col-lg-12">
            <?php if($this->session->flashdata('success')) { ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <?= $this->session->flashdata('success') ?>
                </div>
            <?php } ?>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="alert alert-info mt-4">
                        Once you click this, you will not be able to return to the previous step or change your university selection. 
                        <br />In the next step, you will be able to rank the universities of your choice in your preferred order, starting from the top.
                        <hr>
                        <i class="fa fa-info-circle"></i> Drag & Drop Row to sort Rank
                    </div>
                        <div class="table-responsive mt-4">
                            <table id="submission_plan_table" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>University</th>
                                    <th>Status</th>
                                    <th>Rank</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($submission_plans as $index => $submission_plan) : $rank_default = $index + 1; ?>
                                    <tr>
                                        <td><?= $submission_plan->university_name; ?></td>
                                        <td><?= badge_submission_plan($submission_plan->status); ?></td>
                                        <td>
                                            <span><?= $submission_plan->rank ?></span>
                                            <input type="hidden" name="manage_rank[<?= $submission_plan->id ?>][id]" value="<?= $submission_plan->id ?>">
                                            <input type="hidden" class="rank" name="manage_rank[<?= $submission_plan->id ?>][rank]" value="<?php echo $submission_plan->rank != null ? preg_replace('/\D/', '', $submission_plan->rank) : null; ?>">
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel-body" style="margin-top:-30px;">
                    <div class="col-lg-12">
                        <a href="<?= base_url('grantee/placement/list/'.$this->session->userdata('grantee_user_id')) ?>" class="btn btn-default mr-2">Cancel</a>
                        <button type="button" name="btn-submit" id="btn-submit" class="btn btn-success mr-2">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
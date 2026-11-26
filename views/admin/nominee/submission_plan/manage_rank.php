<style>
    .TriSea-technologies-Switch > input[type="checkbox"] {
        display: none;   
    }

    .TriSea-technologies-Switch > label {
        cursor: pointer;
        height: 0px;
        position: relative; 
        width: 40px;  
    }

    .TriSea-technologies-Switch > label::before {
        background: rgb(0, 0, 0);
        box-shadow: inset 0px 0px 10px rgba(0, 0, 0, 0.5);
        border-radius: 8px;
        content: '';
        height: 16px;
        margin-top: -8px;
        position:absolute;
        opacity: 0.3;
        transition: all 0.4s ease-in-out;
        width: 40px;
    }
    .TriSea-technologies-Switch > label::after {
        background: rgb(255, 255, 255);
        border-radius: 16px;
        box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
        content: '';
        height: 24px;
        left: -4px;
        margin-top: -8px;
        position: absolute;
        top: -4px;
        transition: all 0.3s ease-in-out;
        width: 24px;
    }
    .TriSea-technologies-Switch > input[type="checkbox"]:checked + label::before {
        background: inherit;
        opacity: 0.5;
    }
    .TriSea-technologies-Switch > input[type="checkbox"]:checked + label::after {
        background: inherit;
        left: 20px;
    }
</style>

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header"><?= $page_title ?></h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<form method="POST">
<div class="row">
    <div class="col-lg-12">
        <div class="TriSea-technologies-Switch">
            <span class="mr-2">Sort Rank by Nominee</span>
            <input id="lock_submission_plan" name="lock_submission_plan" type="checkbox" <?= $grantee_grant->lock_submission_plan  ? 'checked' : '' ?>/>
            <label for="lock_submission_plan" class="label-primary"></label>
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
                <?php foreach ($submission_plans as $submission_plan) : ?>
                    <tr>
                        <td><?= $submission_plan->university_name; ?></td>
                        <td><?= badge_submission_plan($submission_plan->status); ?></td>
                        <td>
                            <span><?= $submission_plan->rank ?? '' ?></span>
                            <input type="hidden" name="manage_rank[<?= $submission_plan->id ?>][id]" value="<?= $submission_plan->id ?>">
                            <input type="hidden" class="rank" name="manage_rank[<?= $submission_plan->id ?>][rank]" value="<?php echo $submission_plan->rank != null ? preg_replace('/\D/', '', $submission_plan->rank) : null; ?>">
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            </table>
        </div>
    </div>

    <div class="col-lg-12">
        <a href="<?= base_url('admin/nominee/submission_plan/manage/'.$grantee_grant->id) ?>" class="btn btn-default mr-2">Cancel</a>
        <button type="button" name="btn-submit" id="btn-submit" class="btn btn-success mr-2">Submit</button>
    </div>
</div>
</form>
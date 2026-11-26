<style>
	.mrl {
		margin-left: 8px !important;
	}
	.label-check {
		cursor:pointer;
	}

    .period-row { 
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 12px;
        margin-bottom: 10px;
        border-left: 4px solid #013473;
        position: relative;
    }

    .panel-default .panel-heading{
        background-color: rgb(236 240 244);
        color: #000;
        /* border-radius: 8px;
        border-top-left-radius: 8px !important;
        border-top-right-radius: 8px !important; */
        padding: 20px;
    }

    .panel-collapse{
        border: 1px solid rgb(236 240 244);
    }
</style>

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header"><?php echo $title ?></h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->

<div class="row">
    <div class="col-lg-12 mb-5">
        <form role="form" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-4">
                    <label class="small fw-bold">Cycle</label>
                    <input type="text" class="form-control form-control-sm" name="cycle" value="<?= $period->cycle ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="small fw-bold">Start Date & Time</label>
                    <input type="text" class="flatpicker form-control form-control-sm" name="period_start" value="<?= $period->start_date ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="small fw-bold">End Date & Time</label>
                    <input type="text" class="flatpicker form-control form-control-sm" name="period_end" value="<?= $period->end_date ?>" required>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-lg-12">
                    <div class="panel-group" id="accordionOne" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                            <a role="button" data-toggle="collapse" data-parent="#accordionOne" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                <div class="panel-heading panel-heading-departure text-left" role="tab" id="submission_result">
                                    <h4 class="panel-title">
                                        DET Information
                                    </h4>
                                </div>
                            </a>
                            <div id="collapseTwo" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'general' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">
                                    <div class="form-group ">
                                        <label> Information </label>
                                        <textarea name="activity" cols="30" rows="10" class="form-control editor"><?= $period->activity ?></textarea>
                                    </div>
                                    <!-- <div class="form-group">
                                        <label> Grant Length </label>
                                        <textarea name="grant_length" cols="30" rows="10" class="form-control editor"><?= $period->grant_length ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label> Specific Requirement </label>
                                        <textarea name="spesific_requirement" cols="30" rows="10" class="form-control editor"><?= $period->spesific_requirement ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label> General Requirement </label>
                                        <textarea name="general_requirement" cols="30" rows="10" class="form-control editor"><?= $period->general_requirement ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label> Submission Requirement </label>
                                        <textarea name="submission_requirement" cols="30" rows="10" class="form-control editor"><?= $period->submission_requirement ?></textarea>
                                    </div> -->
                                    <div class="form-group">
                                        <label> Timeline </label>
                                        <textarea name="deadline_note" cols="30" rows="10" class="form-control editor"><?= $period->deadline_note ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label> AMINEF </label>
                                        <textarea name="aminef" cols="30" rows="10" class="form-control editor"><?= $period->aminef ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label> Support </label>
                                        <textarea name="contact_information" cols="30" rows="10" class="form-control editor"><?= $period->contact_information ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label> How to Apply </label>
                                        <textarea name="how_to_apply" cols="30" rows="10" class="form-control editor"><?= $period->how_to_apply ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if($period) { ?>
                <input type="hidden" class="form-control form-control-sm" name="id" value="<?= $period->id ?>">
            <?php } ?>
            <input type="hidden" class="form-control form-control-sm" name="term_id" value="<?= $term_id ?>">
            <div class="row mt-4">
                <div class="col-lg-12">
                    <a href="<?php echo $btn_back ?>" class="btn btn-default">Back</a>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </div>

        </form>
    </div>
</div>
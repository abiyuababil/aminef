<form id="form" method="POST" enctype="multipart/form-data">
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default mt-4" style="background-color: white !important;">
            <div class="row">
                <div class="col-md-12">
                    <div class="accordion" id="accordionExample">
                        <div class="card">
                            <div class="card-header bg-primary text-white" id="headingOne" style="border-bottom: 2px solid #ddd;">
                                <button class="bg-primary btn-link text-white" style="color: white !important; text-decoration:none;" type="button" data-toggle="collapse" data-target="#collapse_programs" aria-expanded="true" aria-controls="collapse_programs">
                                    <h5>Select Program</h5>
                                </button>
                            </div>
                            <div id="collapse_programs" class="collapse in" aria-labelledby="headingOne" aria-expanded="true" data-parent="#accordionExample">
                                <div class="card-body p-4" style="background-color: white; position: relative; z-index: 1;">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Select Program</label>
                                            <select class="form-control select2" id="program" name="program_id">
                                                <option value="">Select Program</option>
                                                <?php foreach ($programs as $program) { ?>
                                                    <option value="<?php echo $program->id; ?>"><?php echo $program->name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Select Period</label>
                                            <select class="form-control" id="period" name="period_id">
                                                <option value="">Select Period</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button class="btn btn-primary pull-right">Download</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
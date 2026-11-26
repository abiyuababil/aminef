<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Add Score <?= $section ?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

<form method="post">
<div class="row">
    <div class="col-lg-4">
        <div class="form-group">
            <label><?= $section ?> Date</label>
            <input id="date" class="form-control" readonly name="date" value="<?= $data->date_interview ? date('d M Y', strtotime($data->date_interview)) : '' ?>" placeholder="<?= $section ?> Date">
            <!-- <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a> -->
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group">
            <label>PIC</label>
            <input type="text" readonly class="form-control" value="<?= get_pic_name($data->pic_id) ?>">
            <!-- <select name="pic" class="form_control select2">
                <option value="">-- Select --</option>
                <?php foreach($pics as $pic) { 
                    $selected = '';
                    if ($data->pic_id == $pic->id) {
                        $selected = 'selected="selected"';
                    }?>
                    <option value="<?php echo $pic->id ?>" <?php echo $selected ?>><?php echo $pic->name ?></option>
                <?php } ?>
            </select> -->
        </div>
    </div>
    <div class="col-lg-4 d-none">
        <div class="form-group">
            <label>Panelist</label>
            <select class="form-control select_multiselect_score" name="panellist_id[]" multiple='multiple' style="width:100%">
                <?php foreach ($panellist as $p) { ?>
                    <?php 
                        $data_panellist = $data->panellist_id ?? [];
                        $select = in_array($p->id, $data_panellist)  ? 'selected' : ''; 
                    ?>
                    <option value="<?php echo $p->id; ?>" <?= $select ?>><?php echo $p->name; ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="col-lg-4 d-none">
        <div class="form-group">
            <label>Program</label> 
            <select class="form-control select_multiselect" name="program" id="program">
                <option value="">-- Select Program --</option>
                <?php
                foreach ($programs as $program) {
                    $selected = $data->grant_id == $program->id ? 'selected' : '';
                ?>
                    <option value="<?php echo $program->id ?>" <?php echo $selected ?>><?php echo $program->name ?></option>
                <?php
                }
                ?>
            </select>
        </div>
    </div>
    <!-- <div class="col-lg-4">
        <div class="form-group">
            <label>Grantee</label>
            <img src="<?php echo base_url() ?>/img/loading.gif" id="load-grantee" style="display:none;">
            <select class="form-control select_multiselect" id="grantee" data-live-search="true">
                <option value="">-- Select Grantee --</option>
            </select>
        </div>
    </div> -->
    <div class="col-lg-4">
        <div class="form-group">
            <label style="margin-right:20px">Interview Format</label>
            <input type="text" readonly value="<?= isset($data->data[0]) ? ($data->data[0]->interview_format == 'online' ? 'Online' : 'Offline') : '' ?>" class="form-control">
            <!-- <div class="radio d-inline mr-4">
                <label>
                    <input type="radio" 
                    class="grant-alumni" 
                    <?= isset($data->data[0]) ? ($data->data[0]->interview_format == 'online' ? 'checked' : '') : '' ?>
                    name="interview_format" 
                    style="margin-top:1px" 
                    value="online">
                    Online
                </label>
            </div>
            <div class="radio d-inline">
                <label>
                    <input type="radio" 
                    class="grant-alumni" 
                    <?= isset($data->data[0]) ? ($data->data[0]->interview_format == 'offline' ? 'checked' : '') : '' ?>
                    name="interview_format" 
                    style="margin-top:1px" 
                    value="offline">
                    Offline
                </label>
            </div> -->
        </div>  
    </div>
</div>
<div class="row">
    <div class="col-lg-4">
        <div class="form-group">
            <label>Venue</label>
            <!-- <input type="text" class="form-control" placeholder="Venue" name="location" value="<?= isset($data->data) ? $data->data[0]->location : '' ?>"> -->
            <textarea readonly name="location" class="form-control" cols="30" rows="5"><?= isset($data->data) ? $data->data[0]->location : '' ?></textarea>
        </div>  
    </div>
</div>
<hr />
<div class="row">
    <div class="col-lg-8">
        <?php if($data) { ?>
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="table_list_score">
                    <tr>
                        <th></th>
                        <th>Panelist</th>
                        <th width="10%">Score</th>
                        <th width="10%">Rec</th>
                        <th width="10%">Interview Time</th>
                        <th width="15%">Status</th>
                        <th width="10%">Rank</th>
                        <!-- <th width="5%"></th> -->
                    </tr>

                    <?php foreach ($data->data as $krow => $grantee) { ?>
                    <tr class="trEdit">
                        <td rowspan="<?= count($grantee->data_interview) ?>"><?= get_full_name($grantee->data_interview[0]) ?></td>
                        <td><?= $grantee->data_interview[0]->panellist_name ?></td>
                        <td>
                            <input type="number" max="160" step="any" class="form-control" name="data_interview[<?= $grantee->data_interview[0]->id ?>][score]" value="<?= $grantee->data_interview[0]->score ?>">
                            <!-- <input type="hidden" value="<?= $grantee->data_interview[0]->grantee_grant_id ?>" name="grantee[]">
                            <input type="hidden" value="<?= $grantee->data_interview[0]->user_grantee_id ?>" name="grantee_id[]">
                            <input type="hidden" value="<?= $grantee->data_interview[0]->id ?>" name="section_id[<?= $grantee->data_interview[0]->grantee_grant_id ?>][]"> -->
                        </td>
                        <td>
                            <select name="data_interview[<?= $grantee->data_interview[0]->id ?>][rank_recommendation]" class="form-control">
                                <option value="">- Select -</option>
                                <option <?= $grantee->data_interview[0]->rank_recommendation == 'HR' || $grantee->data_interview[0]->rank_recommendation == 2 ? 'selected' : '' ?> value="<?= $data->section == 'review' ? 'HR' : 2 ?>">HR</option>
                                <option <?= $grantee->data_interview[0]->rank_recommendation == 'R' || $grantee->data_interview[0]->rank_recommendation == 1 ? 'selected' : '' ?> value="<?= $data->section == 'review' ? 'R' : 1 ?>">R</option>
                                <option <?= $grantee->data_interview[0]->rank_recommendation == 'NR' || $grantee->data_interview[0]->rank_recommendation == 0 ? 'selected' : '' ?> value="<?= $data->section == 'review' ? 'NR' : 0 ?>">NR</option>
                            </select>
                        </td>
                        <td style="vertical-align:middle;" rowspan="<?= count($grantee->data_interview) ?>"><input type="time" style="height: 85px;" class="form-control" name="time[<?= $grantee->id ?>]" value="<?= $grantee->date_interview ? date('H:i', strtotime($grantee->date_interview)) : '' ?>"></td>
                        <td style="vertical-align:middle;" rowspan="<?= count($grantee->data_interview) ?>">
                            <select name="status_interview[<?= $grantee->id ?>]" class="form-control" style="height: 85px;">
                                <option value="">- Select -</option>
                                <option <?= $grantee->status_interview == 'P' ? 'selected' : '' ?> value="P">Principal</option>
                                <option <?= $grantee->status_interview == 'A' ? 'selected' : '' ?> value="A">Alternate</option>
                            </select>
                        </td>
                        <td style="vertical-align:middle;" rowspan="<?= count($grantee->data_interview) ?>"><input type="number" style="height: 85px;" class="form-control daily_rank" name="daily_rank[<?= $grantee->id ?>]" value="<?= $grantee->daily_rank ?? $grantee->rank_interview_date ?>"></td>
                        <!-- <td rowspan="<?= count($grantee->data_interview) ?>"><button data-count="<?= count($grantee->data_interview) ?>" type="button" class="btn btn-danger btn-xs removeRow" onclick="deleteRowEdit(this)"><i class="fa fa-trash fa-fw"></i></button></td> -->
                    </tr>
                    <?php if (count($grantee->data_interview) > 1) {
                        for ($i = 1; $i < count($grantee->data_interview); $i++) {
                    ?>
                    <tr class="trEdit">
                        <td><?= $grantee->data_interview[$i]->panellist_name ?></td>
                        <td>
                            <input type="number" max="160" step="any" class="form-control" name="data_interview[<?= $grantee->data_interview[$i]->id ?>][score]" value="<?= $grantee->data_interview[$i]->score ?>">
                            <!-- <input type="hidden" value="<?= $grantee->data_interview[$i]->id ?>" name="section_id[<?= $grantee->data_interview[$i]->grantee_grant_id ?>][]"> -->
                        </td>
                        <td>
                            <select name="data_interview[<?= $grantee->data_interview[$i]->id ?>][rank_recommendation]" class="form-control">
                                <option value="">- Select -</option>
                                <option <?= $grantee->data_interview[$i]->rank_recommendation == 'HR' || $grantee->data_interview[$i]->rank_recommendation == 2 ? 'selected' : '' ?> value="<?= $data->section == 'review' ? 'HR' : 2 ?>">HR</option>
                                <option <?= $grantee->data_interview[$i]->rank_recommendation == 'R' || $grantee->data_interview[$i]->rank_recommendation == 1 ? 'selected' : '' ?> value="<?= $data->section == 'review' ? 'R' : 1 ?>">R</option>
                                <option <?= $grantee->data_interview[$i]->rank_recommendation == 'NR' || $grantee->data_interview[$i]->rank_recommendation == 0 ? 'selected' : '' ?> value="<?= $data->section == 'review' ? 'NR' : 0 ?>">NR</option>
                            </select>
                        </td>
                    </tr>
                    <?php }
                    } ?>
                    <?php } ?>
                </table>
            </div>
        <?php } else { ?>
            <table class="table table-striped" id="table_list_score">
                <thead>
                <tr>
                    <th width="30%">Grantee Name</th>
                    <?php if($section == 'Interview') { ?>
                        <th width="30%">Interview Time</th>
                        <?php } ?>
                        <th width="3%"></th>
                    </tr>
                </thead>
                <tbody>
                
                </tbody>
            </table>
        <?php } ?>
    </div>
</div>

<div class="row mb-5">
    <div class="col-lg-12">
        <a href="<?= base_url('admin/selection/score_page/manage/'.strtolower($section)) ?>" class="btn btn-default">Back</a>
        <button type="submit" class="btn btn-success" id="submit-score">Save</button>
    </div>
</div>
</form>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Score Page
            <!-- <a href="<?= base_url('admin/selection/score_page/manage/review') ?>"
                class="btn btn-success btn-sm pull-right" title="Export Data Alumni dalam format file excel">
                Section Review
            </a> -->
            <a href="<?= base_url('admin/selection/score_page/manage/interview') ?>"
                class="btn btn-success btn-sm pull-right mr-2">
                Section Interview List
            </a>
        </h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <form id="frm_manage" method="GET">
        <div class="data-header clearfix form-inline">
            <div class="row">
                <div class="col-lg-6">
                    <table width="100%" style="padding:5px">
                        <tr>
                            <td><label for="">Date</label></td>
                            <td>
                                <input type="text" name="start_date" id="start_date" class="form-control datepicker mb-2" placeholder="Select Date" onchange="return formSubmit(event)" value="<?= $_GET['start_date'] ?>"> - 
                                <input type="text" name="end_date" id="end_date" class="form-control datepicker mb-2" placeholder="Select Date" onchange="return formSubmit(event)" value="<?= $_GET['end_date'] ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><label for="">PIC</label></td>
                            <td>
                                <select name="pic_id" id="pic_id" class="form-control select2" onchange="return formSubmit(event)" style="width:100%;" >
                                    <option value="">All</option>
                                    <?php foreach($pics as $pic) { 
                                        $selected = '';
                                        if ($_GET['pic_id'] == $pic->id) {
                                            $selected = 'selected="selected"';
                                        }?>
                                        <option value="<?php echo $pic->id ?>" <?php echo $selected ?>><?php echo $pic->name ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <!-- <tr>
                            <td><label for="">Value</label></td>
                            <td><input type="text" name="search" id="search" class="form-control mb-2" placeholder="Search Name" onkeypress="return submitFilter(event)" value="<?= $paging['search'] ?>"></td>
                        </tr> -->
                        <!-- <tr>
                            <td><label for="">Selection</label></td>
                            <td>
                                <select name="section" id="category" class="form-control select2" onchange="return formSubmit(event)" style="width:100%;" >
                                    <option value="">All</option>
                                    <option <?php if ($paging['section'] == 'review') echo "selected"; ?> value="review">Review</option>
                                    <option <?php if ($paging['section'] == 'interview') echo "selected"; ?> value="interview">Interview</option>
                                </select>
                            </td>
                        </tr> -->
                    </table>
                </div>
            </div>
            <hr />
        </div>

        <div class="row">
            <div class="text-center justify-content-center mb-3" style="display:none;" id="loading_data">
                Loading Data ... <img src="<?php echo base_url() ?>/img/loading.gif">
            </div>
        </div>
    </form>
</div>




<div class="row">
    <div class="col-lg-6">
        
        <?php
        if ($data) {
            $no = $paging['start_row'];
            foreach ($data as $row) {
        ?>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th width="300"></th>
                        <th class="text-center" colspan="3"><?= $row->section ? ucwords($row->section) : 'Interview' ?></th>
                    </tr>
                    <tr>
                        <th></th>
                        <th class="text-center" colspan="3"><?= $row->grant_name ?> <br /><?= date('l, d F Y', strtotime($row->date_interview)) ?><?= $row->venue ? ', '. $row->venue : '' ?><br>PIC : <?= $row->pic ?></th>
                    </tr>
                    <tr>
                        <th></th>
                        <th><?= $row->section == 'review' ? 'Reviewer' : 'Interviewer' ?></th>
                        <th width="10%">Score <?= $row->section == 'review' ? 'Review' : 'Interview' ?></th>
                        <th width="10%">Rec</th>
                    </tr>

                    <?php 
                    foreach ($row->data as $krow => $grantee) { 
                        $totalScore = 0;
                        foreach($grantee->data_interview as $tscore){
                            $totalScore += $tscore->score;
                    }    
                    ?>
                        <tr>
                            <td rowspan="<?= count($grantee->data_interview)+1 ?>"><?= get_full_name($grantee->data_interview[0]) ?></td>
                            <td><?= $grantee->data_interview[0]->panellist_name ?></td>
                            <td><?= $grantee->data_interview[0]->score ?></td>
                            <td><?= get_msg_status($grantee->data_interview[0]->rank_recommendation) ?></td>
                        </tr>
                        <?php if (count($grantee->data_interview) > 1) {
                            for ($i = 1; $i < count($grantee->data_interview); $i++) {
                        ?>
                        <tr>
                            <td><?= $grantee->data_interview[$i]->panellist_name ?></td>
                            <td><?= $grantee->data_interview[$i]->score ?></td>
                            <td><?= get_msg_status($grantee->data_interview[$i]->rank_recommendation) ?></td>
                        </tr>
                        <?php } ?>
                    <?php } ?>
                    <tr>
                        <td><b>Total Score</b></td>
                        <td><b><?= $totalScore ?></b></td>
                        <td></td>
                    </tr>
                    <?php } ?>
                </table>
            </div>
            <?php } ?>
        <?php } ?>
    </div>
</div>
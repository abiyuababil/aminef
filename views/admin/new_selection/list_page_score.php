<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Selection <?= $section ?>
            <!-- <a href="<?= base_url('admin/selection/score_page/add/'.strtolower($section)) ?>"
                class="btn btn-success btn-sm pull-right" title="Export Data Alumni dalam format file excel">
                Add New
            </a> -->
        </h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <form id="frm_manage" method="GET">
            <div id="wrap-filter" class="data-header clearfix form-inline">
                <div class="col-lg-6">
                    <table width="100%" style="padding:5px">
                        <tr>
                            <td width="15%" height="40px">
                                <label for="">Interview Date</label>
                            </td>
                            <td>
                                <input type="text" class="form-control dateWithRange" name="filter_date" placeholder="Select Date" readonly style="background-color:#fff;" value="<?= $filter_date ?>">
                            </td>
                        </tr>
                        <tr>
                            <td width="15%" height="65px"><label for="">Grant</label></td>
                            <td>
                                <select name="grant" class="form-control select2" onchange="return formSubmit(event)" style="width:100%;">
                                <option value="">All</option>
                                    <?php
                                    foreach ($program_available as $pa) {
                                        $selected = '';
                                        if ($pa->id == $grant) {
                                            $selected = 'selected';
                                        }
                                    ?>
                                        <option value="<?= $pa->id ?>" <?= $selected ?>><?= $pa->name ?></option>
                                    <?php } ?>
                                </select>
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
                    </table>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <!-- <th width="30"><input type="checkbox" class="chk-all"></th> -->
                            <th width="35" class="text-center">#</th>
                            <th>Interview Date</th>
                            <th>Grants</th>
                            <th>PIC</th>
                            <th>Period</th>
                            <th width="150" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($data) { 
                            $no = 1;   
                        ?>
                        <?php foreach($data as $key => $row) { ?>
                            <tr>
                                <td><?= $no ?></td>
                                <td><?= $row->date_interview ? date('d M Y', strtotime($row->date_interview)) : '' ?></td>
                                <td><?= $row->grant_name ?></td>
                                <td><?= $row->pic ?></td>
                                <td><?= $row->fiscal_year ?></td>
                                <td class="text-center"><a class="btn btn-primary btn-xs" href="<?= base_url('admin/selection/score_page/edit/?date_interview='.date('Y-m-d H:i', strtotime($row->date_interview)).'&pic_id='.$row->pic_id.'&grant_id='.$row->grant_id) ?>">Detail</a></td>
                            </tr>
                        <?php $no++; } ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
            <div class="pull-left">
                Showing <?php echo $paging['start_row'] ?> to <?php echo $paging['end_row'] ?> of <?php echo $paging['total_rows'] ?> entries
            </div>
            <!-- /.pagination info -->
            <?php echo $paging['html'] ?>
            <!-- /.pagination -->
            <input type="hidden" name="sort_by" value="<?php echo $sort_by ?>">
            <input type="hidden" name="sort" value="<?php echo $sort ?>">
        </form>

    </div>
</div>
<?php $this->load->view('admin/partials/modal_confirm') ?>
<?php $this->load->view('admin/partials/form_filter') ?>


<div class="modal fade" id="modalDownloadSelection" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form method="POST" id="form-download-excel-selection">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Download Excel</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="panel-body">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Select Active Grant</label>
                                <select name="active_grant_id" id="active_grant_id" class="form-control">
                                    <option value="">-- Select Active Grant --</option>
                                    <?php foreach ($program_available as $key_p_a => $p_a) { ?>
                                        <option value="<?= $p_a->id ?>"><?= $p_a->name ?></option>
                                    <?php } ?>
                                </select>
                                <small class="text-danger d-none text-validation-activegrant" id="text-validation-active-grant">Choose Active Grant</small>
                            </div>  
                        </div>
                        <!-- <div class="col-lg-6">
                            <div class="form-group">
                                <label>Period</label>
                                <select name="active_grant_id" id="active_grant_id" class="form-control">
                                    <option value="">-- Select Active Grant --</option>
                                    <?php foreach ($program_available as $key_p_a => $p_a) { ?>
                                        <option value="<?= $p_a->id ?>"><?= $p_a->name ?></option>
                                    <?php } ?>
                                </select>
                                <small class="text-danger d-none text-validation-activegrant" id="text-validation-active-grant">Choose Period</small>
                            </div>  
                        </div> -->
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Date</label>
                                <input type="text" class="form-control datepicker" name="interview_date">
                            </div>  
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-center">
                    <button type="submit" class="btn btn-success">Download</button>
                </div>
            </form>
        </div>
    </div>
</div>
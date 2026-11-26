<div id="post_degree" class="active in first_tab">
    <div class="panel-body mt-3">
        <div class="col-lg-4">
            <div class="form-group">
                <label>Start Date</label>
                <input 
                    id="start_date_post_degre" 
                    type="text" 
                    class="form-control datepicker" 
                    readonly 
                    style="background-color:#fff" 
                    <?= (!$is_admin) ? '' : '' ?> 
                    placeholder="Date" 
                    name="start_date_post_degre" 
                    value="<?= $visa_interview  ? ($visa_interview->start_date_post_degre != '' ? date('d M Y', strtotime($visa_interview->start_date_post_degre)) : '') : '' ?>">
                    <?php //if(($is_admin && $this->session->userdata('role') != 'travel-booking-assistant') || $visa_interview->appointment_located == 'Jakarta') { ?>
                    <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                    <?php //} ?>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label>End Date</label>
                <input 
                    id="end_date_post_degre" 
                    type="text" 
                    class="form-control datepicker" 
                    readonly 
                    style="background-color:#fff" 
                    <?= (!$is_admin) ? '' : '' ?> 
                    placeholder="Date" 
                    name="end_date_post_degre" 
                    value="<?= $visa_interview  ? ($visa_interview->end_date_post_degre != '' ? date('d M Y', strtotime($visa_interview->end_date_post_degre)) : '') : '' ?>">
                    <?php //if(($is_admin && $this->session->userdata('role') != 'travel-booking-assistant') || $visa_interview->appointment_located == 'Jakarta') { ?>
                    <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                    <?php //} ?>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <div class="col-lg-12">
            <div class="form-group">
                <br />
                <button type="button" class="btn btn-primary add_post_degree" data-toggle="modal" data-target="#add_post_degree">Add New</button>
                <table class="table table-striped table-bordered table-responsive mt-4">
                    <thead>
                        <tr>
                            <th>Document</th>
                            <th>Upload Date</th>
                            <?php //if($is_admin) { ?>
                            <th>Action</th>
                            <?php //} ?>
                        </tr>
                    </thead>
                    <tbody id="list_post_degree">
                        <?php foreach($data_doc_post_degree as $index => $post_degree) { ?>
                        <tr id="index-post_degree-<?= $index + 1 ?>">
                            <td>
                                <?php if($post_degree->file){ ?>
                                <a href="<?= base_url($post_degree->file) ?>" class="lightbox" style="color:#337ab7">
                                    <?= file_name($post_degree->file) ?>
                                </a>
                                <?php } ?>
                            </td>
                            <td><?= $post_degree->created_date ? date('Y-m-d', strtotime($post_degree->created_date)) : '' ?></td>
                            <?php //if($is_admin) { ?>
                            <td>
                                <!-- <a onclick="edit_data_post(this, <?= $post_degree->id ?>, <?= $index + 1 ?>)" class="btn btn-primary btn-xs edit-post" style="color:#fff">
                                    Edit
                                </a> -->
                                <a href="javascript:;" onclick="del_data_post_degree(this, <?= $post_degree->id ?>)" class="btn btn-danger btn-xs" style="color:#fff"><i class="fa fa-trash fa-fw text-white"></i></a>
                            </td>
                            <?php //} ?>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="pull-right">
                <button type="button" name="btn" value="save_post_degree" onclick="return showSwal('confirm_submit', 'Are you sure you want to save?', false, false, false, '#form', 'save_post_degree')" class="btn btn-success">Save</button>
            </div>
        </div>
    </div>
</div>
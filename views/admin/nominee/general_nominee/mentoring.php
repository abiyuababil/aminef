<?php
$default_tab_active = 'class="active"';
$default_content_active = 'active in';

$file_count = 0;
foreach ($mentoring_types as $mt) {
    if ($mt['checked'] && isset($grantee_mentoring[$mt['id']])) {
        $file_count++;
    }
}
$has_files = $file_count > 0;
?>

<style>
    .containt {
        margin: 0px auto 30px auto;
    }

    .progressbar {
        counter-reset: step;
        margin: 0px;
        padding: 0px;
    }

    .progressbar li {
        display: inline-block;
        list-style-type: none;
        width: 25%;
        /* float: left; */
        font-size: 12px;
        position: relative;
        text-align: center;
        text-transform: uppercase;
        color: #7d7d7d;
    }

    .progressbar li {
        width: 30px;
        height: 30px;
        line-height: 30px;
        background-color: #b5b5b5;
        /* display: block; */
        text-align: center;
        margin: auto 10px;
        border-radius: 50%;
        cursor: pointer;
    }

    .progressbar li a {
        color: white !important;
        text-decoration: none;
    }

    .progressbar li:after {
        width: 100%;
        height: 2px;
        content: '';
        position: absolute;
        background-color: #7d7d7d;
        top: 15px;
        left: -50%;
        z-index: -1;
    }

    .progressbar li:first-child:after {
        content: none;
    }

    .progressbar li.active {
        color: white;
        background-color: #0089d1;
    }

    .progressbar li.done {
        color: white;
        background-color: #0089d1;
    }

    .progressbar li.active+li:after {
        background-color: #55b776;
    }

    .btn_step {
        width: 150px;
    }

    .next {
        float: right;
    }

    #table-report td {
        height: 80px;
        vertical-align: top;
        padding: 10px;
        font-weight: bold;
    }

    #table-report tr {
        margin-top: 20px;
    }

    .invalid-tooltip {
        position: absolute;
        top: auto;
        z-index: 5;
        display: none;
        max-width: 100%;
        padding: 0.5rem;
        margin-top: 0.1rem;
        font-size: 12px;
        line-height: 1;
        color: #fff;
        background-color: rgba(220, 53, 69, .8);
        border-radius: 0.2rem;
    }

    #delete-alert {
        position: fixed;
        top: 10px;
        right: 30px;
        z-index: 1001;
        font-weight: bold;
        border: none;
        outline: none;
        cursor: pointer;
        display: none;
    }

    #success-alert {
        position: fixed;
        top: 10px;
        right: 30px;
        z-index: 1001;
        font-weight: bold;
        border: none;
        outline: none;
        cursor: pointer;
        display: none;
    }
    
    .selected-preparation-n {
        display:none;
    }
    
    .selected-preparation-b {
        display:block;
    }

    .d-none-testing {
        display: none !important;
    }



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

<div class="row <?= $is_grantee || $is_alumni_page ? 'd-none' : '' ?>">
    <div class="col-lg-12">
        <h1><?=$title ?></h1>
        <h3 class="page-header"><?=$grantee_grant->grant_name ?> (<?= $grantee_grant->fiscal_year_period ?>)</h3>
    </div>
</div>

<?php if (isset($notif_success) && $notif_success != '' && !$is_grantee) { ?>
    <div class="mt-3 alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo $notif_success ?>
    </div>
<?php } ?>
<?php if (isset($notif_error) && $notif_error != '') { ?>
    <div class="mt-3 alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo $notif_error ?>
    </div>
<?php } ?>
<div class="mt-3 alert alert-success" id="success-alert" style="width:200px">
    <button type="button" class="close" data-dismiss="alert">x</button>
    Delete <strong>Success! </strong>
</div>
<div class="mt-3 alert alert-danger" id="delete-alert" style="width:200px">
    <button type="button" class="close" data-dismiss="alert">x</button>
    Delete <strong>Failed! </strong>
</div>

<form autocomplete="new-password" id="form" role="form" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="section" value="mentoring">
    <div class="row warp-alumni-page">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div id="wrap-mentoring">
                    <?php if($data_mentoring) : ?>
                        <?php foreach($data_mentoring as $km => $mentoring): ?>
                        <?php
                            $del_btn = ''; 
                            if($km > 0 && !$is_alumni_page) : 
                            $del_btn = '
                                <img src="'.base_url('/img/loading.gif').'" class="delete-load-mentoring" style="display:none;position:absolute; top:35px; right:75px;">
                                <a 
                                    href="javascript:;" 
                                    onclick="del_item(this, \'mentoring-item\','.$mentoring->id.', \'mentoring\')" 
                                    class="btn btn-danger btn-delete-nominee" 
                                    style="position:absolute; top:25px; right:15px;">
                                    <i class="fa fa-trash fa-fw"></i>
                                </a>';
                        ?>
                            <hr>
                        <?php endif; ?>
                        <div id="mentoring-item-<?= $km ?>" class="mentoring-item" style="position:relative">
                            <div class="panel-body">
                                <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> Mentoring Section</p>
                                <div class="col-lg-12 <?= $grantee_grant->guideline_mentee ? '' : 'hide' ?>">
                                    <a href="<?= base_url($grantee_grant->guideline_mentee) ?>" download title="Click to Download" class="btn btn-primary mb-5" style="color:#fff">
                                        <i class="fa fa-download fa-fw text-white"></i> Download Guideline for Mentee
                                    </a>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Name of Mentor</label>
                                        <input type="hidden" name="mentoring[<?= $km ?>][mentoring_id]" value="<?= $mentoring->id ?>">
                                        <select class="form-control select-panelis-mentoring select2 <?= $is_grantee ? 'd-none' : '' ?>" name="mentoring[<?= $km ?>][panellist_id]" id="panellis_<?= $km ?>" onchange="get_panellist(<?= $km ?>)">
                                            <option value="">-- Select Name of Mentor --</option>
                                            <?php foreach($panellist as $pl) : ?>
                                                <option value="<?= $pl->id ?>" <?= $mentoring->panellist_id == $pl->id ? 'selected' : '' ?>><?= $pl->name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <input type="hidden" class="form-control" placeholder="Field of Study" value="" id="text_panellis_<?= $km ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="text" class="form-control" placeholder="Email" id="email_<?= $km ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Phone Number</label>
                                        <input type="text" class="form-control" placeholder="Phone Number" id="tel_<?= $km ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Start Date</label>
                                        <input 
                                            type="text" 
                                            readonly
                                            style="background-color:#fff"
                                            class="form-control datepicker" 
                                            name="mentoring[<?= $km ?>][date]" 
                                            placeholder="Date" 
                                            value="<?= $mentoring->date ? date('d M Y', strtotime($mentoring->date)) : '' ?>"
                                        >
                                        <?php if (!isset($is_grantee)) { ?>
                                        <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>End Date</label>
                                        <input 
                                            type="text" 
                                            readonly
                                            style="background-color:#fff"
                                            class="form-control datepicker" 
                                            name="mentoring[<?= $km ?>][end_date]" 
                                            placeholder="End Date" 
                                            value="<?= $mentoring->end_date ? date('d M Y', strtotime($mentoring->end_date)) : '' ?>"
                                        >
                                        <?php if (!isset($is_grantee)) { ?>
                                        <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Field of Study</label>
                                        <textarea type="text" class="form-control" placeholder="Field of Study" id="field_of_study_<?= $km ?>" readonly style="resize:none;"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <input class="hide_status_mentoring" value="<?= $mentoring->status ?>" name="mentoring[<?= $km ?>][status_hide]" type="hidden">
                                        <select class="form-control select_status_mentoring" name="mentoring[<?= $km ?>][status]" id="status_0">
                                            <option value="">-- Select Status --</option>
                                            <option <?= $mentoring->status == 'Not Started' ? 'selected' : '' ?> value="Not Started">Not Started</option>
                                            <option <?= $mentoring->status == 'In Progress' ? 'selected' : '' ?> value="In Progress">In Progress</option>
                                            <option <?= $mentoring->status == 'Completed' ? 'selected' : '' ?> value="Completed">Completed</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Essay After Mentoring</label>
                                    </div>
                                </div> -->
                                <!-- <div class="col-lg-4">
                                    <div class="form-group">
                                        <label style="margin-right:20px">Check for Plagiarism</label><br />
                                        <div class="radio d-inline mr-4">
                                            <label>
                                                <input type="radio" 
                                                        class="radio-nominee" 
                                                        <?= $mentoring->plagiarism ==  'yes' ? 'checked' : '' ?>
                                                        name="mentoring[<?= $km ?>][plagiarism]" 
                                                        style="margin-top:1px" 
                                                        value="yes">
                                                        Yes
                                            </label>
                                        </div>
                                        <div class="radio d-inline">
                                            <label>
                                                <input type="radio" 
                                                        class="radio-nominee" 
                                                        <?= $mentoring->plagiarism ==  'no' ? 'checked' : '' ?>
                                                        name="mentoring[<?= $km ?>][plagiarism]" 
                                                        style="margin-top:1px" 
                                                        value="no">
                                                        No
                                            </label>
                                        </div>
                                    </div>  
                                </div> -->
                            </div>
                            <?php //if($mentoring->status == 'Completed' || $is_admin) { ?>
                            <div class="panel-body <?= $is_admin ? '' : 'hide' ?> panel-file-mentoring">
                                <div class="col-lg-12">
                                    <label>Final Essays</label>
                                    <?php if($is_admin) { ?>
                                    <div class="row my-3">
                                        <div class="col-lg-12">
                                            <div class="TriSea-technologies-Switch">
                                                <span class="mr-2"> Lock Grantee Upload</span>
                                                <input id="lock_mentoring" name="mentoring[<?= $km ?>][lock_mentoring]" type="checkbox" <?= $mentoring->lock_mentoring  ? 'checked' : '' ?>/>
                                                <label for="lock_mentoring" class="label-primary"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <!-- <input type="file" id="file_essay_0" name="file_essay_0[]" multiple class="hidden">
                                    <br />
                                    <a href="javascript:;" class="btn btn-primary upload-button mb-3" data-file-value="file_essay_0" style="color:#fff;">Add New</a> -->

                                    
                                    <table class="table table-bordered" width="100%">
                                        <thead>
                                            <tr>
                                                <th width="30%">Document Name</th>
                                                <th width="15%">Upload Date</th>
                                                <th>File</th>
                                                <th class="text-right action-col <?= $has_files ? '' : 'hide' ?>" style="width:1%;white-space:nowrap">
                                                    <span class="action-label <?= $file_count > 1 ? 'hide' : '' ?>">Action</span>
                                                    <a href="javascript:;" class="btn btn-primary btn-xs pull-right btn-download-mentoring <?= $file_count > 1 ? '' : 'hide' ?>" title="Download all files" style="color:#fff"><i class="fa fa-download fa-fw"></i> Download All Files</a>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $all_uploaded = true;
                                                foreach ($mentoring_types as $mentoring_type) { 
                                                    if(!$mentoring_type['checked']) {continue;}
                                                    if (!isset($grantee_mentoring[$mentoring_type['id']])) {
                                                        $all_uploaded = false;
                                                    }
                                            ?>
                                                <tr class="mentoring-row">
                                                    <td><?= $mentoring_type['name'] ?></td>
                                                    <td><?= $grantee_mentoring[$mentoring_type['id']]->created_at ?></td>
                                                    <td>
                                                        <a class="<?= isset($grantee_mentoring[$mentoring_type['id']]) || (!$is_admin && $mentoring->lock_mentoring) ? 'hide' : '' ?> btn btn-primary btn-xs upload-mentoring btn-mentoring-<?= $mentoring_type['id'] ?>" data-file-value="upload-mentoring-type-<?= $mentoring_type['id'] ?>">Upload</a>
                                                        <input 
                                                            data-mentoring="<?= $mentoring_type['id'] ?>"
                                                            data-id="<?= $mentoring->id ?>"
                                                            data-grantee_grant_id="<?= $grantee_grant_id ?>"
                                                            data-is_admin="<?= $is_admin ?>"
                                                            type="file" 
                                                            class="upload-mentoring-type-<?= $mentoring_type['id'] ?> hide"
                                                        >
                                                        <?php if(isset($grantee_mentoring[$mentoring_type['id']])) { ?>
                                                            <?php $download_name = get_full_name($grantee_grant).'_'.ucwords(strtolower($mentoring_type['name'])).'_'.($grantee_grant->fiscal_year_period ?: $grantee_grant->fiscal_year).'.'.pathinfo($grantee_mentoring[$mentoring_type['id']]->file, PATHINFO_EXTENSION); ?>
                                                            <a href="<?= base_url($grantee_mentoring[$mentoring_type['id']]->file) ?>" data-filename="<?= htmlspecialchars($download_name, ENT_QUOTES) ?>" class="lightbox pull-left mr-2 data-mentoring-<?= $grantee_mentoring[$mentoring_type['id']]->id ?>"><?= htmlspecialchars($download_name) ?></a>
                                                            <i class="fa fa-circle-o-notch fa-spin download-spinner hide"></i>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="action-mentoring-<?= $mentoring_type['id'] ?> action-col text-right <?= $has_files ? '' : 'hide' ?>" style="white-space:nowrap">
                                                        <?php if(isset($grantee_mentoring[$mentoring_type['id']])) { ?>
                                                            <a href="javascript:;" class="btn btn-primary btn-xs mr-2 btn-download-file" title="Download" style="color:#fff"><i class="fa fa-download fa-fw"></i> Download</a>
                                                            <a href="javascript:;" onclick="del_mentoring(this, <?= $grantee_mentoring[$mentoring_type['id']]->id ?>, <?= $is_admin ?>)" class="<?= (!$is_admin && $mentoring->lock_mentoring) ? 'hide' : '' ?> btn btn-danger btn-xs" style="color:#fff"><i class="fa fa-trash fa-fw text-white"></i></a>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <?php //} ?>
                            <?php echo $del_btn ?>
                        </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <div id="mentoring-item-0" class="mentoring-item" style="position:relative">
                            <div class="panel-body">
                                <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> Mentoring Section</p>
                                <div class="col-lg-12 <?= $grantee_grant->guideline_mentee ? '' : 'hide' ?>">
                                    <a href="<?= base_url($grantee_grant->guideline_mentee) ?>" download title="Click to Download" class="btn btn-primary mb-5" style="color:#fff">
                                        <i class="fa fa-download fa-fw text-white"></i> Download Guideline for Mentee
                                    </a>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Name of Mentor</label>
                                        <input type="hidden" name="mentoring[0][mentoring_id]" value="">
                                        <select class="form-control select2" name="mentoring[0][panellist_id]" id="panellis_0" onchange="get_panellist(0)">
                                            <option value="">-- Select Name of Mentor --</option>
                                            <?php foreach($panellist as $pl) : ?>
                                                <option value="<?= $pl->id ?>"><?= $pl->name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Field of Study</label>
                                        <input type="text" class="form-control" placeholder="Field of Study" id="field_of_study_0" readonly style="resize:none;"></input>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="text" class="form-control" placeholder="Email" id="email_0" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Telp</label>
                                        <input type="text" class="form-control" placeholder="Telp" id="tel_0" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Start Date</label>
                                        <input type="text" class="form-control datepicker" name="mentoring[0][date]" placeholder="Start Date">
                                        <?php if (!isset($is_grantee)) { ?>
                                        <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>End Date</label>
                                        <input type="text" class="form-control datepicker" name="mentoring[0][end_date]" placeholder="End Date">
                                        <?php if (!isset($is_grantee)) { ?>
                                        <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select class="form-control" name="mentoring[0][status]" id="status_0">
                                            <option value="">-- Select Status --</option>
                                            <option value="Not Started">Not Started</option>
                                            <option value="In Progress">In Progress</option>
                                            <option value="Completed">Completed</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Essay After Mentoring</label>
                                        <input type="file" id="file_essay_0" name="file_essay_0[]" multiple>
                                    </div>
                                </div> -->
                                <!-- <div class="col-lg-4">
                                    <div class="form-group">
                                        <label style="margin-right:20px">Check for Plagiarism</label><br />
                                        <div class="radio d-inline mr-4">
                                            <label>
                                                <input type="radio" 
                                                        class="radio-nominee" 
                                                        name="mentoring[0][plagiarism]" 
                                                        style="margin-top:1px" 
                                                        value="yes">
                                                        Yes
                                            </label>
                                        </div>
                                        <div class="radio d-inline">
                                            <label>
                                                <input type="radio" 
                                                        class="radio-nominee" 
                                                        name="mentoring[0][plagiarism]" 
                                                        style="margin-top:1px" 
                                                        value="no">
                                                        No
                                            </label>
                                        </div>
                                    </div>  
                                </div> -->
                            </div>
                            <?php if($mentoring_types) { ?>
                            <div class="panel-body">
                                <div class="col-lg-12">
                                    <label>Final Essays</label>
                                    <?php if($is_admin) { ?>
                                    <div class="row my-3">
                                        <div class="col-lg-12">
                                            <div class="TriSea-technologies-Switch">
                                                <span class="mr-2"> Lock Grantee Upload</span>
                                                <input id="lock_mentoring" name="mentoring[<?= $km ?>][lock_mentoring]" type="checkbox" <?= $mentoring->lock_mentoring  ? 'checked' : '' ?>/>
                                                <label for="lock_mentoring" class="label-primary"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <!-- <input type="file" id="file_essay_0" name="file_essay_0[]" multiple class="hidden">
                                    <br />
                                    <a href="javascript:;" class="btn btn-primary upload-button mb-3" data-file-value="file_essay_0" style="color:#fff;">Add New</a> -->
                                    
                                    <table class="table table-bordered" width="100%">
                                        <thead>
                                            <tr>
                                                <th width="30%">Document Name</th>
                                                <th width="15%">Upload Date</th>
                                                <th>File</th>
                                                <th class="text-right action-col <?= $has_files ? '' : 'hide' ?>" style="width:1%;white-space:nowrap">
                                                    <span class="action-label <?= $file_count > 1 ? 'hide' : '' ?>">Action</span>
                                                    <a href="javascript:;" class="btn btn-primary btn-xs pull-right btn-download-mentoring <?= $file_count > 1 ? '' : 'hide' ?>" title="Download all files" style="color:#fff"><i class="fa fa-download fa-fw"></i> Download All Files</a>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $all_uploaded = true;
                                                foreach ($mentoring_types as $mentoring_type) { 
                                                    if(!$mentoring_type['checked']) {continue;}
                                                    if (!isset($grantee_mentoring[$mentoring_type['id']])) {
                                                        $all_uploaded = false;
                                                    }
                                            ?>
                                                <tr>
                                                    <td><?= $mentoring_type['name'] ?></td>
                                                    <td><?= $grantee_mentoring[$mentoring_type['id']]->created_at ?></td>
                                                    <td>
                                                        <a class="<?= isset($grantee_mentoring[$mentoring_type['id']]) || (!$is_admin && $mentoring->lock_mentoring) ? 'hide' : '' ?> btn btn-primary btn-xs upload-mentoring btn-mentoring-<?= $mentoring_type['id'] ?>" data-file-value="upload-mentoring-type-<?= $mentoring_type['id'] ?>">Upload</a>
                                                        <input 
                                                            data-mentoring="<?= $mentoring_type['id'] ?>"
                                                            data-grantee_grant_id="<?= $grantee_grant_id ?>"
                                                            data-is_admin="<?= $is_admin ?? 0?>"
                                                            type="file" 
                                                            class="upload-mentoring-type-<?= $mentoring_type['id'] ?> hide"
                                                        >
                                                        <?php if(isset($grantee_mentoring[$mentoring_type['id']])) { ?>
                                                            <?php $download_name = get_full_name($grantee_grant).'_'.ucwords(strtolower($mentoring_type['name'])).'_'.($grantee_grant->fiscal_year_period ?: $grantee_grant->fiscal_year).'.'.pathinfo($grantee_mentoring[$mentoring_type['id']]->file, PATHINFO_EXTENSION); ?>
                                                            <a href="<?= base_url($grantee_mentoring[$mentoring_type['id']]->file) ?>" data-filename="<?= htmlspecialchars($download_name, ENT_QUOTES) ?>" class="lightbox pull-left mr-2 data-mentoring-<?= $grantee_mentoring[$mentoring_type['id']]->id ?>"><?= htmlspecialchars($download_name) ?></a>
                                                            <i class="fa fa-circle-o-notch fa-spin download-spinner hide"></i>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="action-mentoring-<?= $mentoring_type['id'] ?> action-col text-right <?= $has_files ? '' : 'hide' ?>" style="white-space:nowrap">
                                                        <?php if(isset($grantee_mentoring[$mentoring_type['id']])) { ?>
                                                            <a href="javascript:;" class="btn btn-primary btn-xs mr-2 btn-download-file" title="Download" style="color:#fff"><i class="fa fa-download fa-fw"></i> Download</a>
                                                            <a href="javascript:;" onclick="del_mentoring(this, <?= $grantee_mentoring[$mentoring_type['id']]->id ?>, <?= $is_admin ?>)" class="btn btn-danger btn-xs" style="color:#fff"><i class="fa fa-trash fa-fw text-white"></i></a>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="panel-body <?= $is_grantee ? '' : 'd-none' ?>">
                    <button type="button" id="btn-submit-mentoring" class="btn btn-success btn-submit button-for-grantee pull-right" name="btn-submit" value="save" style='color:#fff;'>Save</button>
                </div>
                <!-- <div class="panel-body">
                    <div class="col-lg-4">
                        <button type="button" class="btn btn-primary btn-for-add" onclick="add_mentoring()"><i class="fa fa-plus fa-fw"></i> Add New</button>
                        <img src="<?php echo base_url() ?>/img/loading.gif" class="add-load" style="display:none;">
                    </div>
                </div>
                </div> -->
            </div>
        </div>
    </div>
    <?php if(!$is_alumni_page) { ?>
    <div class="row">
        <div class="col-lg-12" style="margin-bottom:10px;">
            <div style="margin-bottom:10px;" class="pull-right">
                <?php if (!isset($is_grantee)) { ?>
                    <a href="<?= $back_url ?>" class="btn btn-primary mr-2">Back</a>
                    <a href="#" data-id="<?= $grantee_grant_id ?>" data-section="candidate" class="btn btn-danger drop">Drop</a>
                    <a href="#" data-id="<?= $grantee_grant_id ?>" data-section="candidate" class="btn btn-warning withdraw">Withdraw</a>
                    <button type="submit" id="btn-submit" class="btn btn-success btn-submit" name="btn-submit" value="save">Save</button>
                    <!-- <button type="submit" id="btn-submit" class="btn btn-warning btn-submit" name="btn-submit" value="send_email_mentoring">Send EMail Mentoring</button> -->
                <?php } ?>
            </div>
        </div>
    </div>
    <?php } ?>
</form>

<input type="hidden" id="data_section" value="mentoring">
<?php $this->load->view('admin/partials/modal_confirm') ?>

<div class="modal fade" id="mdl_upload_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Essay After Mentoring</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <label>File</label>
                        <input type="file" id="file_essay" name="file_essay" multiple>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-12 text-right">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="button" id="btn-upload-essay" class="btn btn-primary success">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php

$active_country = $this->session->userdata('active_country');
$number_alfa = range('a', 'z');

$default_tab_active = 'class="active"';
$default_content_active = 'active in';
if ($pid) {
    $default_tab_active = '';
    $default_content_active = '';
}
?>

<style>
    .select2 {
        width:100% !important;
    }

    .agreement-page{
        margin-top:30px;
        margin-bottom:40px;
    }

    .agreement-status{
        border:none;
        border-radius:15px;
        background:#eefaf0;
        box-shadow:0 5px 20px rgba(0,0,0,.05);
    }

    .status-icon{
        width:50px;
        height:50px;
        border-radius:50%;
        background: #28a745;
        color:#fff;
        text-align:center;
        line-height:50px;
        font-size:30px;
    }

    .status-icon-warning{
        width:50px;
        height:50px;
        border-radius:50%;
        background: #f1c867ff;
        color:#fff;
        text-align:center;
        line-height:50px;
        font-size:30px;
    }

    .agreement-status h3{
        margin-top:5px;
        color:#28a745;
        font-weight:bold;
    }

    .agreement-card{
        border:0;
        border-radius:18px;
        box-shadow:0 10px 30px rgba(0,0,0,.08);
    }

    .agreement-card .panel-body{
        padding:35px;
    }

    .agreement-card h3{
        margin-top:0;
        font-weight:600;
    }

    .file-card{

        border:1px solid #eee;
        border-radius:15px;

        padding:15px;

        text-align:center;

        transition:.3s;
    }

    /* .file-card:hover{

        transform:translateY(-4px);

        box-shadow:0 8px 20px rgba(0,0,0,.1);
    } */

    .file-card img{

        border-radius:10px;

        margin:auto;

        max-height:180px;
    }

    .btn-success{

        border-radius:8px;

        padding:12px 24px;

        font-weight:600;
    }

    @media(max-width:768px){

        .agreement-card .panel-body{
            padding:20px;
        }

        .status-icon{
            width:55px;
            height:55px;
            line-height:55px;
            font-size:22px;
        }

        .page-header h1{
            font-size:28px;
        }

        .btn-lg{
            width:100%;
        }

        .file-card{
            margin-bottom:20px;
        }

    }
    .upload-box{

    border:2px dashed #b8d8c5;

    border-radius:15px;

    background:#fafdfb;

    text-align:center;

    padding:40px 20px;

    transition:.3s;

    margin-top:20px;
}

.upload-box:hover{

    border-color:#28a745;

    background:#f2fcf5;
}

.upload-icon{

    font-size:60px;

    color:#28a745;

    margin-bottom:15px;
}

.btn-file{

    position:relative;

    overflow:hidden;

    border-radius:8px;
}

.btn-file input[type=file]{

    position:absolute;

    left:0;

    top:0;

    opacity:0;

    width:100%;

    height:100%;

    cursor:pointer;
}

.selected-file{

    margin-top:20px;

    background:#fff;

    border:1px solid #ddd;

    border-radius:10px;

    padding:12px 15px;

    text-align:left;

    box-shadow:0 2px 8px rgba(0,0,0,.05);
}

.selected-file .file-name{

    font-weight:600;

    margin-left:8px;
}
</style>

<div class="row">
    <div class="col-lg-12 text-center">
        <h2 style="color:#0089d1">Duolingo English Test - Agreement</h2>
    </div>
</div>

<div class="container agreement-page">

    <!-- Status -->
    <?php if($application->status_agreement == 'revise') { ?>
    <div class="alert alert-warning">
        <div class="media-left">
            <div class="status-icon-warning">
                <i class="fa fa-exclamation"></i>
            </div>
        </div>

        <div class="media-body">
            <h4>Need to be revised with note: </h4>
            <p><?= $application->note_agreement ?></p>
        </div>
    </div>
    <?php } ?>

    <?php if($application->status_agreement == 'approve') { ?>
    <div class="alert alert-success">
        <div class="media-left">
            <div class="status-icon">
                <i class="fa fa-check"></i>
            </div>
        </div>

        <div class="media-body">
            <small>Status Agreement</small>
            <h4>Accepted</h4>
        </div>
    </div>
    <?php } ?>

    <!-- Card -->
    <div class="panel panel-default agreement-card">
        <form id="form" method="POST" enctype="multipart/form-data">
        <?php if($application->agreement_template != '') { ?>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-8">
                        <h3>
                            Upload Duolingo English Testing Agreement
                        </h3>
                        <p class="text-muted">
                            Please download, review and upload the signed Agreement.
                        </p>
                        <br>
                        <a download href="<?= base_url($application->agreement_template) ?>" class="btn btn-success btn-lg">
                            <i class="fa fa-download"></i>
                            Download Agreement
                        </a>
                    </div>
                </div>

                <hr>
                
                <?php if($application->status_agreement != 'approve') { ?>
                <div class="upload-box">
                    <h4>Click The Button Below</h4>
                    <p class="text-muted">
                        File Size Max 5MB
                    </p>
                    <label class="btn btn-primary btn-file">
                        <i class="fa fa-folder-open"></i>
                        Choose File
                        <input
                            type="file"
                            name="tnc"
                            id="tnc"
                            hidden>
                    </label>

                    <br><br>

                    <div id="selected-file" class="selected-file" style="display:none;">
                        <i class="fa fa-file-o text-success"></i>
                        <span class="file-name"></span>
                        <button
                            type="button"
                            class="btn btn-xs btn-danger remove-file pull-right">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <?php } ?>

                <?php if($application->agreement != '') { ?>
                <div class="row <?= $application->status_agreement != 'approve' ? 'mt-5' : '' ?>    ">
                    <div class="col-md-3">
                        <div class="file-card">
                            <?php if(!in_array($application->status_agreement, ['approve', 'submitted'])) { ?>
                            <a href="<?= base_url('det/application/delete_tnc/'.$application->id) ?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure want to delete this data?')" style="position:absolute;top:10px;right:30px;">
                                <i class="fa fa-trash fa-fw text-white"></i>
                            </a>
                            <?php } ?>
                            <a href="<?= base_url() ?><?= $application->agreement ?>" class="lightbox" aria-haspopup="dialog">
                                <img height="100" src="<?= get_preview($application->agreement); ?>">
                            </a>
                            <h5 style="overflow-wrap: anywhere;"><?= file_name($application->agreement) ?></h5>
                            
                            <a href="<?= base_url($application->agreement) ?>" download class="btn btn-default btn-block">
                                <i class="fa fa-download"></i>
                                Download
                            </a>
                        </div>
                    </div>
                </div>
                <?php } ?>

                <?php if($application->status_agreement == '' || $application->status_agreement == 'revise') { ?>
                <div class="row mt-3">
                    <div class="col-lg-12">
                        <button type="submit" class="btn btn-success pull-right">Save</button>
                    </div>
                </div>
                <?php } ?>
            </div>
        <?php } ?>
        </form>
    </div>
</div>
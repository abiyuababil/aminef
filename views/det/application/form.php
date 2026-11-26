<style>
    .containt {
        margin: 0px auto 30px auto;
    }

    .progressbar {
        counter-reset: step;
        margin: 0px;
        padding: 0px;
    }

    .select2-container {
        width: 100% !important;
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

    .progressbar li.done {
        color: white;
        background-color: #0089d1;
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

    .progressbar li.active+li:after {
        background-color: #55b776;
    }

    .display {
        display: none;
    }

    .no-padding{
        padding: 0px !important;
    }

    .text-white {
        color: white;
    }

    .btn-download-guide {
        position: absolute;
        top: 106px;
        right : 0;
        width : 150px;
    }

    .btn-download-form {
        position: absolute;
        top: 147px;
        right : 0;
        width : 150px;
    }

    input[type='radio'] {
        -webkit-appearance:none;
        width:15px;
        height:15px;
        border:1px solid #b455fb;
        border-radius:50%;
        outline:none;
    }
    input[type='radio']:hover {
        box-shadow:0 0 5px 0px orange inset;
    }
    input[type='radio']:before {
        content:'';
        display:block;
        width: 55%;
        height: 55%;
        margin: 25% auto;
        border-radius: 50%;    
    }
    input[type='radio']:checked:before {
        background:blue;
    }
    .font-weight-bold {
        margin-top: 5px;
    }

    .span-note a {
        color: #0000ff;
    }
</style>
<div class="row">
    <div class="col-lg-12 text-center">
        <h2 style="color:#0089d1">Application</h2>
        <h1>Duolingo English Test - <?php echo $detail_data['fiscal_year']->year ?></h1>
        <p class="page-header">
            <?= $application->term_name ?? '' ?> <br />
            Period : <?= $application->start_date ? date('d M Y', strtotime($application->start_date)) : '' ?> - <?= $application->end_date ? date('d M Y', strtotime($application->end_date)) : '' ?>
        </p>
        
        <?php
        if ($application && !in_array($application->status, [STATUS_DET_IN_PROGRESS])) { ?>
                <h3 class="alert alert-success">Submitted</h3>
        <?php } ?>
    </div>
</div>

<!-- Submission view render conponent -->
<?= $this->load->view('component/det_applications', [
    'data_questions' => $detail_data['questions'],
    'is_admin' => false,
    'userGranteeId' => $this->session->userdata('grantee_user_id'),
    'granteeGrantId' => $this->session->userdata('grantee_grant_id'),
    'disabled' => !in_array($application->status, [STATUS_DET_IN_PROGRESS]) ? 'disabled' : ''
], true); ?>

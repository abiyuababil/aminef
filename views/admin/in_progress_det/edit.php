
<div class="row">
    <div class="col-lg-12">
        <h1>
            <?= get_full_name($application) ?> 
        </h1>
        <h3>
            Duolingo English Test - <?= $application->year ?>
        </h3>
        <p class="page-header">
            <?= $application->term_name ?> <br />
            Period : <?= date('d M Y', strtotime($application->start_date)) ?> - <?= date('d M Y', strtotime($application->end_date)) ?>
        </p>
        <?= get_status_badge_det($application->status) ?>
    </div>
    <!-- /.col-lg-12 -->
</div>


<!-- Submission view render conponent -->
<div class="p-5">
<?= $this->load->view('component/det_applications', [
    'data_questions' => $question['detail_data']['questions'],
    'is_admin' => true,
    'userGranteeId' => $application->user_id,
    'granteeGrantId' => $application->id,
    'disabled' => in_array($application->status, [STATUS_DET_SUBMITTED, STATUS_DET_REJECTED, STATUS_DET_COMPLETE, STATUS_DET_WITHDRAWN]) ? 'disabled' : ''
], true); ?>
</div>
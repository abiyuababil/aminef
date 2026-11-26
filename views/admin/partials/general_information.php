<div id="general_information" class="active in first_tab">
    <div class="panel-group" id="accordionOne" role="tablist" aria-multiselectable="true">
        <div class="panel">
            <div class="panel-body">
                <p>Welcome to the document submission portal for ongoing grantees. As part of AMINEF program reporting requirements, all grantees are required to submit the necessary documents through this portal following the submission schedule outlined below. </p>
                <br />
                
                <?php if($submission_ongoing){ ?>
                <label>IMPORTANT SUBMISSION DEADLINE</label>

                <table class="table table-bordered table-responsive mt-4">
                    <thead>
                        <tr>
                            <th>Semester</th>
                            <th>Type of Document</th>
                            <th>Submission Deadline</th>
                        </tr>
                    </thead>
                    <tbody id="general_information_table">
                        <?php 
                            foreach($submission_ongoing as $submission) { 
                                $type_of_document = get_all_db('am_type_of_document_submission_ongoing', ['submission_ongoing_id' => $submission->id]);
                        ?>
                            <?php foreach($type_of_document as $idx => $type) { ?>
                                <tr>
                                    <?php if($idx == 0) { ?>
                                        <td rowspan="<?= count($type_of_document) ?>"><?= $submission->semester ?></td>
                                    <?php } ?>
                                    <td><?= $type->type_of_document ?></td>
                                    <td><?= $type->deadline ?></td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
                <p><b>Note</b>: Late submissions may result in incomplete documentation of your information in the database.</p>
                <?php } ?>
                
                <label class="mt-5">U.S. PERSONAL INFORMATION</label>
                <p>Please complete the following U.S. personal information in the My Profile section <a onclick="return set_session('profile_contact')" style="color:#337ab7" href="<?= base_url('grantee/profile/form/' . $grantee_grant->user_grantee_id) ?>">(click here)</a>. You may update this information at any time as changes occur on your side:</p>
                <ul>
                    <li>U.S. University Email Address</li>
                    <li>U.S. Phone Number</li>
                    <li>U.S. Mailing Address</li>
                </ul>
                <p><b>Note</b>: Accurate and up-to-date contact details are essential for official communication and mailing purposes.</p>
            </div>
        </div>
    </div>
</div>
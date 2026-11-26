<div id="visa_dependent" class="active in first_tab">
    <!-- VISA RENEWAL -->
    <?php if($grantee_grant->is_degree){ ?>
    <div class="panel-group" id="accordionParent" role="tablist" aria-multiselectable="true" style="margin-bottom:5px;">
        <?php $this->load->view('admin/partials/visa_renewal'); ?>
    </div>
    <?php } ?>

    <!-- VISA DEPENDEN SECTION  -->
    <div class="panel-group" id="accordionParent" role="tablist" aria-multiselectable="true">
        <?php $this->load->view('admin/partials/visa_dependent')?>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="pull-right">
                <button type="button" name="btn" value="save_visa_interview_dependent" onclick="return showSwal('confirm_submit', 'Are you sure you want to save?', false, false, false, '#form', 'save_visa_interview_dependent')" class="btn btn-success">Save</button>
            </div>
        </div>
    </div>
</div>
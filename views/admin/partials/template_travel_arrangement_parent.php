<script type="text/template" id="applicant-template-parent">
    <div class="panel panel-default travelArrangement-item">
    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionTravel0" href="#collapseToeflTransport{travel_id}{index}" aria-expanded="false" aria-controls="collapseToeflTransport{travel_id}{index}" onclick="return set_session('interview_apointment{travel_id}{index}')">
        <div class="panel-heading panel-heading-test-section text-left" role="tab" id="ToeflTransport">
            <h4 class="panel-title">
                <span id="label_name_{travel_id}">{label_name}</span> 
                <?php if($is_admin) { ?>
                <span><i class="fa fa-pencil-square-o ml-3 btn-noaction edit_name" data-name="{label_name}" data-id ="{travel_id}" title="Edit Name"></i></span>
                <?php } ?>
                <div class="btn-group pull-right">
                    <?php if($is_admin) { ?>
                    <button type="button" data-travel_id="{travel_id}" class="btn btn-xs btn-danger btn-noaction pull-right removeApplicant"><i class="fa fa-trash fa-fw text-white"></i></button>
                    <?php } ?>
                    <input type="hidden" name="travel_arrangement[{index}][name_travel]" value="{label_name}" id="name_travel_{index}">
                    <input type="hidden" name="travel_arrangement[{index}][category_travel]" value="{category_travel}" id="category_travel_{index}">
                    <input type="hidden" name="travel_arrangement[{index}][travel_id]" value="{travel_id}">
                </div>
            </h4>
        </div>
    </a>
    <div id="collapseToeflTransport{travel_id}{index}" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'interview_apointment{travel_id}{index}' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="ToeflTransport">
    </div>
</div>
</script>

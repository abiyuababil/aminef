<div class="panel panel-default travelArrangement-item">
    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionTravel0" href="#collapseToeflTransport<?= $travel->id ?><?= $key ?>" aria-expanded="false" aria-controls="collapseToeflTransport<?= $travel->id ?><?= $key ?>" onclick="return set_session('interview_apointment<?= $travel->id ?><?= $key ?>')">
        <div class="panel-heading panel-heading-test-section text-left" role="tab" id="ToeflTransport">
            <h4 class="panel-title">
                <span id="label_name_<?= $travel->id ?>"><?= $travel->name ?></span> 
                <?php if($is_admin) { ?>
                <span><i class="fa fa-pencil-square-o ml-3 btn-noaction edit_name" data-name="<?= $travel->name ?>" data-id ="<?= $travel->id ?>" title="Edit Name"></i></span>
                <?php } ?>
                <div class="btn-group pull-right">
                    <?php if($is_admin) { ?>
                    <button type="button" data-travel_id="<?= $travel->id ?>" class="btn btn-xs btn-danger btn-noaction pull-right removeApplicant"><i class="fa fa-trash fa-fw text-white"></i></button>
                    <?php } ?>
                    <input type="hidden" name="travel_arrangement[<?= $key ?>][name_travel]" value="<?= $travel->name ?>" id="name_travel_<?= $key ?>">
                    <input type="hidden" name="travel_arrangement[<?= $key ?>][category_travel]" value="{category_travel}" id="category_travel_<?= $key ?>">
                    <input type="hidden" name="travel_arrangement[<?= $key ?>][travel_id]" value="<?= $travel->id ?>">
                </div>
            </h4>
        </div>
    </a>
    <div id="collapseToeflTransport<?= $travel->id ?><?= $key ?>" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'interview_apointment'.$travel->id.$key ? 'in' : '' ?>" role="tabpanel" aria-labelledby="ToeflTransport">
    </div>
</div>

<?php foreach ($tree as $key => $travel): ?>

    <?php
        $current_key = isset($parent_key)
            ? $parent_key . '_' . $key
            : $key;
        $has_child = !empty($travel->children);
        $show_form = !$has_child;
        if ($has_child && !$is_admin && !has_renderable_child($travel, $is_admin)) {
            continue;
        }
        
    ?>

    <?php if($has_child): ?>
    <div class="panel panel-default travelArrangement-item">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionTravel<?= $travel->parent_id ?>" href="#collapseToeflTransport<?= $travel->id ?><?= $current_key ?>" aria-expanded="false" aria-controls="collapseToeflTransport<?= $travel->id ?><?= $current_key ?>" onclick="return set_session('interview_apointment<?= $travel->id ?><?= $current_key ?>')">
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
                        <?php if(has_permission('travel_arrangement', 'edit') || $is_admin) { ?>
                        <button 
                            type="button"
                            class="btn btn-primary add_child btn-noaction btn-xs pull-right mr-2 <?= $travel->name == 'Admission Test' ? 'hidden' : '' ?>"
                            data-parentname="<?= htmlspecialchars($travel->name, ENT_QUOTES, 'UTF-8') ?>"
                            data-parentid="<?= $travel->id ?>"
                            data-currentkey="<?= $current_key ?>"
                        >
                            <i class="fa fa-plus fa-fw"></i> Add New
                        </button>
                        <?php } ?>
                        <input type="hidden" name="travel_arrangement[<?= $current_key ?>][name_travel]" value="<?= $travel->name ?>" id="name_travel_<?= $current_key ?>">
                        <input type="hidden" name="travel_arrangement[<?= $current_key ?>][category_travel]" value="<?= $travel->category ?>" id="category_travel_<?= $current_key ?>">
                        <input type="hidden" name="travel_arrangement[<?= $current_key ?>][travel_id]" value="<?= $travel->id ?>">
                    </div>
                </h4>
            </div>
        </a>
        <div id="collapseToeflTransport<?= $travel->id ?><?= $current_key ?>" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'interview_apointment' . $travel->id . $key ? 'in' : '' ?>" role="tabpanel" aria-labelledby="ToeflTransport">
            <div class="panel-body panel-parent-<?= $travel->id ?><?= $current_key ?>">
            <?php
                $this->load->view('admin/partials/template_travel_recursive', [
                    'tree' => $travel->children,
                    'is_admin' => $is_admin,
                    'url_delete' => $url_delete,
                    'parent_key' => $current_key,
                ]);
            ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php if ($show_form): ?>

        <?php 
        // Skip if not admin and both transportation and accommodation are hidden
        if($travel->category == 'Domestic Ticket')
        {
            if (!$is_admin && ($travel->show_transportation == 'No' || empty($travel->show_transportation)) && ($travel->show_accomodation == 'No' || empty($travel->show_accomodation))) {
                continue;
            }
        }else if($travel->category == 'International Ticket'){
            if (!$is_admin && ($travel->show_international_ticket == 'No' || empty($travel->show_international_ticket))) {
                continue;
            }
        }else if($travel->category == 'US Departure'){
            if (
                !$is_admin && 
                ($travel->show_academic_ticket == 'No' || empty($travel->show_academic_ticket)) && 
                ($travel->show_pre_academic_ticket == 'No' || empty($travel->show_pre_academic_ticket)) && 
                ($travel->show_international_ticket == 'No' || empty($travel->show_international_ticket)) && 
                ($travel->show_transportation == 'No' || empty($travel->show_transportation)) && 
                ($travel->show_accomodation == 'No' || empty($travel->show_accomodation))
             ) {
                continue;
            }
        }else if($travel->category == 'Returning Travel Arrangement')
        {
            if (!$is_admin && ($travel->show_transportation == 'No' || empty($travel->show_transportation)) && ($travel->show_accomodation == 'No' || empty($travel->show_accomodation)) && ($travel->show_transportation_domestic == 'No' || empty($travel->show_transportation_domestic))) {
                continue;
            }
        }
        
        // Load appropriate template based on category
        $template_data = [
            'travel' => $travel,
            'key' => $current_key,
            'is_admin' => $is_admin,
            'url_delete' => $url_delete,
        ];
        
        switch($travel->category) {
            case 'Domestic Ticket':
                $this->load->view('admin/partials/template_travel_arrangement_current_domestic', $template_data);
                break;
            case 'Returning Travel Arrangement':
                $this->load->view('admin/partials/template_travel_arrangement_current_returning', $template_data);
                break;
            case 'Parent Travel Arrangement':
                $this->load->view('admin/partials/template_travel_arrangement_current_parent', $template_data);
                break;
            case 'US Departure':
                $this->load->view('admin/partials/template_travel_arrangement_current_us_departure', $template_data);
                break;
            default:
                $this->load->view('admin/partials/template_travel_arrangement_current_international', $template_data);
                break;
        }
        ?>
    <?php endif; ?>
<?php endforeach; ?>

<?php //if (!isset($current_status) || $current_status != TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_APPROVED): ?>
<!-- <div class="alert alert-info">
    <i class="fa fa-info-circle"></i> <strong>Arranged By AMINEF</strong> - AMINEF will handle all your travel arrangements including flight bookings. You will receive your flight details once arrangements are confirmed.
</div> -->
<?php //endif; ?>

<!-- <div class  ="mb-4 text-right">
    <?= !empty($current_status) ? format_status_travel_arrangement_non_eta($current_status, $application->type ?? null) : ''; ?>
</div> -->

<?php
$flight_details = isset($flight_details) && $flight_details ? $flight_details : null;
$tba_flight_proposals = isset($tba_flight_proposals) && is_array($tba_flight_proposals) ? $tba_flight_proposals : [];
$tba_international_proposals = [];
$tba_other_proposals = [];
$tba_car_rental_proposals = [];
$tba_accommodation_proposals = [];

foreach ($tba_flight_proposals as $proposal) {
    if ($proposal->ref_type === 'tba_international_flight_proposal') {
        $tba_international_proposals[] = $proposal;
        continue;
    }

    if ($proposal->ref_type === 'tba_other_flight_proposal') {
        $tba_other_proposals[] = $proposal;
    }

    if ($proposal->ref_type === 'tba_car_rental_proposal' && $proposal->is_selected == 1) {
        $tba_car_rental_proposals[] = $proposal;
    }

    if ($proposal->ref_type === 'tba_accommodation_proposal' && $proposal->is_selected == 1) {
        $tba_accommodation_proposals[] = $proposal;
    }
}

$filter_tba_flight_proposals = array_filter($tba_flight_proposals, function ($proposal) {
    return $proposal->ref_type !== 'tba_car_rental_proposal' && $proposal->ref_type !== 'tba_accommodation_proposal';
});

$has_tba_flight_proposals = !empty($filter_tba_flight_proposals);
$tba_international_count = count($tba_international_proposals);
$tba_other_count = count($tba_other_proposals);
$tba_car_rental_count = count($tba_car_rental_proposals);
$tba_accommodation_count = count($tba_accommodation_proposals);
$has_submitted_tba_selection = false;

foreach ($tba_flight_proposals as $proposal) {
    if ((int)$proposal->is_selected === 1) {
        $has_submitted_tba_selection = true;
        break;
    }
}

$can_edit_flight_details = isset($current_status) && in_array($current_status, [
    TRAVEL_ARRANGEMENT_NON_ETA_STATUS_DRAFT,
    TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_DECLINED
]);

if (!function_exists('format_grantee_tba_time_limit')) {
    function format_grantee_tba_time_limit($date)
    {
        if (empty($date)) {
            return '-';
        }

        $timestamp = strtotime($date);
        if ($timestamp === false) {
            return '-';
        }

        return date('d F Y H:i', $timestamp);
    }
}

$ticket_international = [];
$ticket_domestic = [];
$ticket_accommodation = [];

foreach ($tickets as $ticket) {
    if ($ticket->type === 'international') {
        $ticket_international[] = $ticket;
        continue;
    }

    if ($ticket->type === 'domestic') {
        $ticket_domestic[] = $ticket;
    }

    if ($ticket->type === 'accommodation') {
        $ticket_accommodation[] = $ticket;
    }
}
$has_international_flight = !empty($flight_details->departure_from) || !empty($flight_details->arival);
$has_domestic_flight = !empty($flight_details->other_departure_from) || !empty($flight_details->other_arrival);
$has_car_rental = !empty($flight_details->pickup_point) || !empty($flight_details->drop_off_point) || !empty($flight_details->car_departure_date);
$has_accommodation = !empty($flight_details->location);
?>

<style>
    .tba-proposals-list {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        align-items: stretch;
    }
    .tba-proposal-card {
        background: #fff;
        border: 1px solid #dfe7ef;
        border-radius: 6px;
        padding: 16px;
        margin-bottom: 0;
        width: calc((100% - 32px) / 3);
        min-width: 0;
        display: flex;
        flex-direction: column;
    }
    .tba-proposal-card:last-child {
        margin-bottom: 0;
    }
    .tba-proposal-description {
        white-space: pre-wrap;
        color: #4f5f6f;
        margin-bottom: 10px;
        font-weight: 400;
        border-left: 3px solid #dfe7ef;
        padding-left: 10px;
    }
    .tba-proposal-description.is-clamped {
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        line-clamp: 2;
        overflow: hidden;
        white-space: normal;
    }
    .tba-proposal-description-toggle {
        display: none;
        margin-top: -4px;
        margin-bottom: 10px;
        padding: 0;
        border: 0;
        background: transparent;
        color: #0e6ba8;
        font-size: 12px;
        font-weight: 400;
        text-decoration: underline;
    }
    .tba-proposal-description-toggle:focus,
    .tba-proposal-description-toggle:hover {
        color: #0a537f;
        outline: none;
    }
    .tba-proposal-price {
        color: #0e6ba8;
        font-weight: 400;
    }
    .tba-proposal-time-limit {
        margin-top: 8px;
        color: #6b7783;
        font-size: 13px;
    }
    .tba-proposal-time-limit strong {
        font-weight: 400;
    }
    .tba-proposal-card label {
        display: block;
        margin: 0;
        cursor: pointer;
    }
    .tba-proposal-card.is-locked label {
        cursor: default;
    }
    .tba-proposal-option {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }
    .tba-proposal-option input[type="radio"] {
        display: none;
    }
    .tba-proposal-option > span {
        flex: 1;
    }
    @media (max-width: 991px) {
        .tba-proposal-card {
            width: calc((100% - 16px) / 2);
        }
    }
    @media (max-width: 767px) {
        .tba-proposal-card {
            width: 100%;
        }
    }
    .tba-proposal-card.is-selected {
        border-color: #28a745;
        background: #edf9f0;
        box-shadow: inset 0 0 0 1px #b9e3c4;
    }
    .tba-proposal-card.is-selected .tba-proposal-price {
        color: #1f7a34;
    }
    .tba-proposal-card.is-selected .tba-proposal-description {
        border-left-color: #7bc48d;
    }
    .tba-proposal-header {
        display: flex;
        align-items: baseline;
        gap: 6px;
        flex-wrap: wrap;
        margin-bottom: 6px;
    }
    .tba-proposal-header strong {
        display: inline-flex;
        align-items: center;
        line-height: 20px;
    }
    .tba-proposal-selected-note {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        color: #1f7a34;
        font-weight: 600;
        font-size: 13px;
        line-height: 20px;
    }
    .type-selector-box {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        padding: 16px;
        border-radius: 6px;
        margin-bottom: 20px;
        transition: border-color 0.2s ease;
    }
    .type-selector-box.validation-error {
        border: 1px solid #ef4444;
        box-shadow: 0 0 0 1px #ef4444;
    }
</style>

<div class="row mb-3">
    <div class="col-lg-12">
        <div class="panel-body">
            <div class="form-group">
                <label><strong>Travel Purpose <span class="text-danger">*</span></strong></label>
                <?php if(isset($current_status) && $current_status != TRAVEL_ARRANGEMENT_NON_ETA_STATUS_DRAFT) : ?>
                    <div>
                        <?= isset($application) && $application->travel_purposes ? html_escape($application->travel_purposes) : '' ?>
                        <input type="hidden" id="travel_purposes" name="travel_purposes" value="<?= html_escape($application->travel_purposes) ?>">
                        <?php if (!empty($application->travel_purposes) && in_array(strtolower(trim($application->travel_purposes)), ['other', 'others'], true) && !empty($application->travel_purposes_other)): ?>
                            <div style="margin-top: 6px; padding: 10px 14px; background: #f8fafc; border: 1px solid #e2e8f0; border-left: 3px solid #0e6ba8; border-radius: 4px;">
                                <strong>Other Purpose:</strong>
                                <div style="margin-top: 4px;"><?= nl2br(html_escape($application->travel_purposes_other)) ?></div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php else : ?>
                    <select class="form-control select2" data-live-search="true" id="travel_purposes" name="travel_purposes" required <?= isset($current_status) && $current_status != TRAVEL_ARRANGEMENT_NON_ETA_STATUS_DRAFT ? 'disabled' : '' ?>>
                        <option></option>
                        <?php 
                            foreach(get_all_db('am_travel_purpose', ['is_active' => true]) as $travel_purpose) : 
                            $selected = '';
                            if ($travel_purpose->name == $application->travel_purposes) {
                                $selected = 'selected="selected"';
                            }
                        ?>
                            <option <?= $selected ?> value="<?= $travel_purpose->name ?>"><?= $travel_purpose->name ?></option>
                        <?php  endforeach;?>
                    </select>
                <?php endif; ?>
            </div>
            <?php 
                $is_other_selected = isset($application) && in_array(strtolower(trim((string)$application->travel_purposes)), ['other', 'others'], true);
                $is_draft = !isset($current_status) || $current_status == TRAVEL_ARRANGEMENT_NON_ETA_STATUS_DRAFT;
            ?>
            <div class="form-group" id="wrapper_travel_purposes_other" style="<?= ($is_other_selected && $is_draft) ? '' : 'display: none;' ?>">
                <label for="travel_purposes_other"><strong>Please Specify Travel Purpose <span class="text-danger">*</span></strong></label>
                <input type="text" id="travel_purposes_other" name="travel_purposes_other" class="form-control" placeholder="Please describe the purpose of your travel and any relevant details." <?= $is_draft ? '' : 'disabled' ?> value="<?= isset($application) && $application->travel_purposes_other ? html_escape($application->travel_purposes_other) : '' ?>">
                <!-- <textarea id="travel_purposes_other" name="travel_purposes_other" class="form-control editor" rows="4" placeholder="Please describe the purpose of your travel and any relevant details." <?php //$is_draft ? '' : 'disabled' ?>><?php //isset($application) && $application->travel_purposes_other ? html_escape($application->travel_purposes_other) : '' ?></textarea> -->
            </div>
        </div>
    </div>
</div>
<div class="panel-group" id="accordion-aminef" role="tablist" aria-multiselectable="true">
    
    <div class="panel panel-default">
        <div class="panel-heading text-left" role="tab" id="headingFlightDetails">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion-aminef" href="#collapseFlightDetails" aria-expanded="<?= $has_tba_flight_proposals ? 'false' : 'true' ?>" aria-controls="collapseFlightDetails">
                    Travel Details <span style="float:right;margin-left:20px;"><i class="fa fa-chevron-down" aria-hidden="true"></i></span>
                </a>
            </h4>
        </div>
        <div id="collapseFlightDetails" class="panel-collapse collapse <?= $has_tba_flight_proposals ? '' : 'in' ?>" role="tabpanel" aria-labelledby="headingFlightDetails">
            <div class="panel-body">
                <form id="form-flight-details" method="POST" novalidate>
                    <input type="hidden" name="form_type" value="flight_details">
                    <input type="hidden" name="application_id" value="<?= isset($id) ? $id : '' ?>">

                    <div class="form-group">
                        <label>Are you travelling with your dependents?</label>
                        <div>
                            <label class="radio-inline">
                                <input type="radio" name="with_dependent" value="1" class="trigger-with_dependent" <?= ($flight_details && (int)$flight_details->with_dependent === 1) ? 'checked' : '' ?> <?= $can_edit_flight_details ? '' : 'disabled' ?>> Yes
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="with_dependent" value="0" class="trigger-with_dependent" <?= (!$flight_details || (int)$flight_details->with_dependent !== 1) ? 'checked' : '' ?> <?= $can_edit_flight_details ? '' : 'disabled' ?>> No
                            </label>
                        </div>
                    </div>
                    
                    <?php if ($can_edit_flight_details): ?>
                    <div class="type-selector-box mb-5" id="typeSelectorBox">
                        <label>Select Travel</label>
                        <div class="radio-group">
                            <label class="radio-inline">
                                <input type="radio" class="type_flight_aminef" name="type_flight_aminef" value="International" <?php echo $has_international_flight ? 'checked' : '' ?> required>
                                International Flight
                            </label>
                            <label class="radio-inline">
                                <input type="radio" class="type_flight_aminef" name="type_flight_aminef" value="Domestic" <?php echo $has_domestic_flight ? 'checked' : '' ?> required>
                                Domestic Flight
                            </label>
                            <label class="radio-inline">
                                <input type="radio" class="type_flight_aminef" name="type_flight_aminef" value="Other" <?php echo $has_car_rental ? 'checked' : '' ?> required>
                                Car Rental
                            </label>
                            <label class="radio-inline">
                                <input type="radio" class="type_flight_aminef" name="type_flight_aminef" value="Accommodation" <?php echo $has_accommodation ? 'checked' : '' ?> required>
                                Accommodation
                            </label>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="panel-group" id="accordion-aminef-detail" role="tablist" aria-multiselectable="true">
                        <!-- DETAIL INTERNATIONAL FLIGHT -->
                        <div class="panel panel-default <?= $has_international_flight ? '' : 'hide' ?>" id="panel-international-flight">

                            <div class="panel-heading text-left" role="tab" id="detailHeadingFlightDetails">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#accordion-aminef-detail" href="#collapseChildDetailInter" aria-expanded="<?= $has_international_flight ? 'true' : 'false' ?>" aria-controls="collapseChildDetailInter">
                                        International Flight <span style="float:right;margin-left:20px;"><i class="fa fa-chevron-down" aria-hidden="true"></i></span>
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseChildDetailInter" class="panel-collapse collapse <?= $has_tba_flight_proposals ? '' : 'in' ?>" role="tabpanel" aria-labelledby="detailHeadingFlightDetails">
                                <div class="flight-section">
                                    <h4>International Flight</h4>
            
                                    <div class="form-group">
                                        <label>Roundtrip</label>
                                        <div>
                                            <label class="radio-inline">
                                                <input type="radio" name="roundtrip" value="1" class="trigger-roundtrip" <?= ($flight_details && (int)$flight_details->roundtrip === 1) ? 'checked' : '' ?> <?= $can_edit_flight_details ? '' : 'disabled' ?>> Yes
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="roundtrip" value="0" class="trigger-roundtrip" <?= (!$flight_details || (int)$flight_details->roundtrip !== 1) ? 'checked' : '' ?> <?= $can_edit_flight_details ? '' : 'disabled' ?>> No
                                            </label>
                                        </div>
                                    </div>
            
                                    <div class="form-group">
                                        <label>From</label>
                                        <input type="text" class="form-control" name="departure_from" value="<?= $flight_details ? html_escape($flight_details->departure_from) : '' ?>" placeholder="Enter departure airport/city" <?= $can_edit_flight_details ? '' : 'disabled' ?>>
                                    </div>
            
                                    <div class="form-group">
                                        <label>Departure Date</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            <input type="text" class="form-control datepicker" name="departure_date" value="<?= $flight_details ? html_escape($flight_details->departure_date) : '' ?>" placeholder="Select Date" <?= $can_edit_flight_details ? '' : 'disabled' ?>>
                                        </div>
                                    </div>
            
                                    <div class="form-group">
                                        <label>To</label>
                                        <input type="text" class="form-control" name="arival" value="<?= $flight_details ? html_escape($flight_details->arival) : '' ?>" placeholder="Enter arrival airport/city" <?= $can_edit_flight_details ? '' : 'disabled' ?>>
                                    </div>
            
                                    <div id="roundtrip-fields" class="<?= ($flight_details && (int)$flight_details->roundtrip === 1) ? '' : 'hidden' ?>">
                                        <hr>
                                        <h4 style="font-size:16px;">Return Flight</h4>
                                        <div class="form-group">
                                            <label>From</label>
                                            <input type="text" class="form-control" name="return_departure_from" value="<?= $flight_details ? html_escape($flight_details->return_departure_from) : '' ?>" placeholder="Enter departure airport/city" <?= $can_edit_flight_details ? '' : 'disabled' ?>>
                                        </div>
            
                                        <div class="form-group">
                                            <label>Return Date</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input type="text" class="form-control datepicker" name="return_departure_date" value="<?= $flight_details ? html_escape($flight_details->return_departure_date) : '' ?>" placeholder="Select Date" <?= $can_edit_flight_details ? '' : 'disabled' ?>>
                                            </div>
                                        </div>
            
                                        <div class="form-group">
                                            <label>To</label>
                                            <input type="text" class="form-control" name="return_arrival" value="<?= $flight_details ? html_escape($flight_details->return_arrival) : '' ?>" placeholder="Enter arrival airport/city" <?= $can_edit_flight_details ? '' : 'disabled' ?>>
                                        </div>
                                    </div>
            
                                    <div class="form-group">
                                        <label>Note</label>
                                        <textarea class="form-control" name="note" rows="4" placeholder="Additional notes" <?= $can_edit_flight_details ? '' : 'disabled' ?>><?= $flight_details ? html_escape($flight_details->note) : '' ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- DETAIL DOMESTIC FLIGHT -->
                        <div class="panel panel-default <?= $has_domestic_flight ? '' : 'hide' ?>" id="panel-domestic-flight">
                            <div class="panel-heading text-left" role="tab" id="detailHeadingFlightDetailsDomestic">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#accordion-aminef-detail" href="#collapseChildDetailDom" aria-expanded="<?= $has_domestic_flight ? 'true' : 'false' ?>" aria-controls="collapseChildDetailDom">
                                        Domestic Flight <span style="float:right;margin-left:20px;"><i class="fa fa-chevron-down" aria-hidden="true"></i></span>
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseChildDetailDom" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="detailHeadingFlightDetailsDomestic">
                                <div class="flight-section" id="domestic_flight_section">
                                    <h4>Domestic Flight</h4>

                                    <div class="form-group">
                                        <label>From</label>
                                        <input type="text" class="form-control" name="other_departure_from" value="<?= $flight_details ? html_escape($flight_details->other_departure_from) : '' ?>" placeholder="Enter departure airport/city" <?= $can_edit_flight_details ? '' : 'disabled' ?>>
                                    </div>

                                    <div class="form-group">
                                        <label>Departure Date</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            <input type="text" class="form-control datepicker" name="other_departure_date" value="<?= $flight_details ? html_escape($flight_details->other_departure_date) : '' ?>" placeholder="Select Date" <?= $can_edit_flight_details ? '' : 'disabled' ?>>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>To</label>
                                        <input type="text" class="form-control" name="other_arrival" value="<?= $flight_details ? html_escape($flight_details->other_arrival) : '' ?>" placeholder="Enter arrival airport/city" <?= $can_edit_flight_details ? '' : 'disabled' ?>>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- DETAIL CAR RENTAL -->
                        <div class="panel panel-default <?= $has_car_rental ? '' : 'hide' ?>" id="panel-car-rental">
                            <div class="panel-heading text-left" role="tab" id="detailHeadingFlightDetailsCarRental">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#accordion-aminef-detail" href="#collapseChildDetailCar" aria-expanded="<?= $has_car_rental ? 'true' : 'false' ?>" aria-controls="collapseChildDetailCar">
                                        Car Rental <span style="float:right;margin-left:20px;"><i class="fa fa-chevron-down" aria-hidden="true"></i></span>
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseChildDetailCar" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="detailHeadingFlightDetailsCarRental">
                                <div class="flight-section" id="car_rental_section">
                                    <div class="form-group">
                                        <label>Pickup Point</label>
                                        <input type="text" class="form-control" name="pickup_point" value="<?= $flight_details ? html_escape($flight_details->pickup_point) : '' ?>" placeholder="Enter Pickup Point" <?= $can_edit_flight_details ? '' : 'disabled' ?>>
                                    </div>

                                    <div class="form-group">
                                        <label>Departure Date</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            <input type="text" class="form-control datepicker" name="car_departure_date" value="<?= $flight_details ? html_escape($flight_details->car_departure_date) : '' ?>" placeholder="Select Date" <?= $can_edit_flight_details ? '' : 'disabled' ?>>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Drop off Point</label>
                                        <input type="text" class="form-control" name="drop_off_point" value="<?= $flight_details ? html_escape($flight_details->drop_off_point) : '' ?>" placeholder="Enter Drop off Point" <?= $can_edit_flight_details ? '' : 'disabled' ?>>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- DETAIL ACCOMMODATION -->
                        <div class="panel panel-default <?= $has_accommodation ? '' : 'hide' ?>" id="panel-accommodation">
                            <div class="panel-heading text-left" role="tab" id="detailHeadingFlightDetailsAccommodation">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#accordion-aminef-detail" href="#collapseChildDetailAccomm" aria-expanded="<?= $has_accommodation ? 'true' : 'false' ?>" aria-controls="collapseChildDetailAccomm">
                                        Accommodation <span style="float:right;margin-left:20px;"><i class="fa fa-chevron-down" aria-hidden="true"></i></span>
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseChildDetailAccomm" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="detailHeadingFlightDetailsAccommodation">
                                <div class="flight-section" id="car_rental_section">
                                    <div class="form-group">
                                        <label>Location</label>
                                        <input type="text" class="form-control" name="location" value="<?= $flight_details ? html_escape($flight_details->location) : '' ?>" placeholder="Enter Location" <?= $can_edit_flight_details ? '' : 'disabled' ?>>
                                    </div>

                                    <div class="form-group">
                                        <label>Check-in Date</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            <input type="text" class="form-control datepicker" name="checkin_date" value="<?= $flight_details ? html_escape($flight_details->checkin_date) : '' ?>" placeholder="Select Date" <?= $can_edit_flight_details ? '' : 'disabled' ?>>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Check-out Date</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            <input type="text" class="form-control datepicker" name="checkout_date" value="<?= $flight_details ? html_escape($flight_details->checkout_date) : '' ?>" placeholder="Select Date" <?= $can_edit_flight_details ? '' : 'disabled' ?>>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Room</label>
                                        <select name="room" id="room" class="form-control" <?= $can_edit_flight_details ? '' : 'disabled' ?>>
                                            <option value="" disabled selected style="color: #9ca3af;">Select Room & Bed Preference</option>
                                            <option value="single">Single Room (1 Single Bed)</option>
                                            <option value="twin">Twin Room (2 Single Beds)</option>
                                            <option value="double">Double Room (1 Queen / Full Bed)</option>
                                            <option value="king">King Room (1 King Bed)</option>
                                            <option value="deluxe-twin">Deluxe Room (2 Double Beds)</option>
                                            <option value="suite-king">Suite (1 King Bed)</option>
                                            <option value="family">Family Room (1 Double + 1 Single Bed)</option>
                                        </select>
                                    </div>
            
                                    <div class="form-group">
                                        <label>Note</label>
                                        <textarea class="form-control" name="note_accommodation" rows="4" placeholder="e.g. Near event venue, smoking room, include breakfast, twin beds, etc." <?= $can_edit_flight_details ? '' : 'disabled' ?>><?= $flight_details ? html_escape($flight_details->note_accommodation) : '' ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    

                    <div class="text-right">
                        <?php if ($can_edit_flight_details): ?>
                            <button type="submit" name="action" value="draft" class="btn btn-default">
                                <i class="fa fa-save"></i> Save as Draft
                            </button>
                            <button type="submit" name="action" value="submit" class="btn btn-primary">
                                <i class="fa fa-paper-plane"></i> Submit Flight Details
                            </button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php if ($has_tba_flight_proposals): ?>
        <div class="panel panel-default">
            <div class="panel-heading text-left" role="tab" id="headingTbaFlightProposal">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion-aminef" href="#collapseTbaFlightProposal" aria-expanded="true" aria-controls="collapseTbaFlightProposal">
                        Flight Proposal <span style="float:right;margin-left:20px;"><i class="fa fa-chevron-down" aria-hidden="true"></i></span>
                    </a>
                </h4>
            </div>
            <div id="collapseTbaFlightProposal" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTbaFlightProposal">
                <div class="panel-body">
                    <?php if (!isset($current_status) || ($current_status != TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_APPROVED && $current_status != TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_TICKET_SENT)): ?>
                        <?php if ($has_submitted_tba_selection): ?>
                            <div class="alert alert-success">
                                <i class="fa fa-check-circle"></i> Your TBA flight selection has been submitted.
                            </div>
                        <?php elseif (isset($current_status) && $current_status == TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_DECLINED): ?>
                            <div class="alert alert-danger">
                                <i class="fa fa-exclamation-triangle"></i> Your previous flight proposal was rejected. Please review the options again and make a new selection.
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info">
                                <i class="fa fa-info-circle"></i> The AMINEF Travel Booking Assistant has provided the following flight options for your review. Please select your preferred option by clicking on the list item. Kindly ensure your response is submitted prior to the specified deadline for each option.
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <form id="form-tba-flight-selection" method="POST">
                        <input type="hidden" name="application_id" value="<?= isset($id) ? (int)$id : 0 ?>">

                        <?php if (!empty($tba_international_proposals)): ?>
                            <div class="flight-section">
                                <h4>International Flight</h4>
                                <div class="tba-proposals-list">
                                    <?php foreach ($tba_international_proposals as $index => $proposal): ?>
                                        <?php $is_international_checked = (int)$proposal->is_selected === 1; ?>
                                        <div class="tba-proposal-card <?= $is_international_checked ? 'is-selected' : '' ?> <?= $has_submitted_tba_selection ? 'is-locked' : '' ?>">
                                            <label class="tba-proposal-option">
                                                <input
                                                    type="radio"
                                                    name="tba_international_selection"
                                                    value="<?= (int)$proposal->id ?>"
                                                    <?= $is_international_checked ? 'checked' : '' ?>
                                                    <?= $has_submitted_tba_selection ? 'disabled' : '' ?>
                                                >
                                                <span>
                                                    <div class="tba-proposal-header">
                                                        <strong>Option <?= $index + 1 ?></strong>
                                                        <?php if ($is_international_checked): ?>
                                                            <span class="tba-proposal-selected-note">
                                                                <i class="fa fa-check-circle"></i> Selected
                                                            </span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="tba-proposal-description is-clamped"><?= nl2br(html_escape($proposal->description)) ?></div>
                                                    <button type="button" class="tba-proposal-description-toggle">Read more</button>
                                                    <div class="tba-proposal-price"><?= html_escape(format_money($proposal->price, $proposal->currency)) ?></div>
                                                    <?php if (!empty($proposal->time_limit)): ?>
                                                        <div class="tba-proposal-time-limit"><strong>Time Limit:</strong> <?= html_escape(format_grantee_tba_time_limit($proposal->time_limit)) ?></div>
                                                    <?php endif; ?>
                                                </span>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($tba_other_proposals)): ?>
                            <div class="flight-section" style="margin-bottom:20px;">
                                <h4>Domestic Flight</h4>
                                <div class="tba-proposals-list">
                                    <?php foreach ($tba_other_proposals as $index => $proposal): ?>
                                        <?php $is_other_checked = (int)$proposal->is_selected === 1; ?>
                                        <div class="tba-proposal-card <?= $is_other_checked ? 'is-selected' : '' ?> <?= $has_submitted_tba_selection ? 'is-locked' : '' ?>">
                                            <label class="tba-proposal-option">
                                                <input
                                                    type="radio"
                                                    name="tba_other_selection"
                                                    value="<?= (int)$proposal->id ?>"
                                                    <?= $is_other_checked ? 'checked' : '' ?>
                                                    <?= $has_submitted_tba_selection ? 'disabled' : '' ?>
                                                >
                                                <span>
                                                    <div class="tba-proposal-header">
                                                        <strong>Option <?= $index + 1 ?></strong>
                                                        <?php if ($is_other_checked): ?>
                                                            <span class="tba-proposal-selected-note">
                                                                <i class="fa fa-check-circle"></i> Selected
                                                            </span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="tba-proposal-description is-clamped"><?= nl2br(html_escape($proposal->description)) ?></div>
                                                    <button type="button" class="tba-proposal-description-toggle">Read more</button>
                                                    <div class="tba-proposal-price"><?= html_escape(format_money($proposal->price, $proposal->currency)) ?></div>
                                                    <?php if (!empty($proposal->time_limit)): ?>
                                                        <div class="tba-proposal-time-limit"><strong>Time Limit:</strong> <?= html_escape(format_grantee_tba_time_limit($proposal->time_limit)) ?></div>
                                                    <?php endif; ?>
                                                </span>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($tba_car_rental_proposals)): ?>
                            <div class="flight-section hide" style="margin-bottom:20px;">
                                <h4>Car Rental</h4>
                                <div class="tba-proposals-list">
                                    <?php foreach ($tba_car_rental_proposals as $index => $proposal): ?>
                                        <?php $is_other_checked = (int)$proposal->is_selected === 1; ?>
                                        <div class="tba-proposal-card <?= $is_other_checked ? 'is-selected' : '' ?> <?= $has_submitted_tba_selection ? 'is-locked' : '' ?>">
                                            <label class="tba-proposal-option">
                                                <input
                                                    type="radio"
                                                    name="tba_other_selection"
                                                    value="<?= (int)$proposal->id ?>"
                                                    <?= $is_other_checked ? 'checked' : '' ?>
                                                    <?= $has_submitted_tba_selection ? 'disabled' : '' ?>
                                                >
                                                <span>
                                                    <div class="tba-proposal-header">
                                                        <strong>Option <?= $index + 1 ?></strong>
                                                        <?php if ($is_other_checked): ?>
                                                            <span class="tba-proposal-selected-note">
                                                                <i class="fa fa-check-circle"></i> Selected
                                                            </span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="tba-proposal-description is-clamped"><?= nl2br(html_escape($proposal->description)) ?></div>
                                                    <button type="button" class="tba-proposal-description-toggle">Read more</button>
                                                    <div class="tba-proposal-price"><?= html_escape(format_money($proposal->price, $proposal->currency)) ?></div>
                                                    <?php if (!empty($proposal->time_limit)): ?>
                                                        <div class="tba-proposal-time-limit"><strong>Time Limit:</strong> <?= html_escape(format_grantee_tba_time_limit($proposal->time_limit)) ?></div>
                                                    <?php endif; ?>
                                                </span>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!$has_submitted_tba_selection): ?>
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-check"></i> Submit Selection
                                </button>
                            </div>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if (isset($current_status) && ($current_status == TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_APPROVED || $current_status ==  TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_TICKET_SENT)): ?>
        <?php $tickets = isset($tickets) && is_array($tickets) ? $tickets : []; ?>
        <div class="panel panel-default">
            <div class="panel-heading text-left" role="tab" id="headingTicket">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion-aminef" href="#collapseTicket" aria-expanded="true" aria-controls="collapseTicket">
                        <?= $has_accommodation ? 'Voucher' : 'Ticket' ?> <span style="float:right;margin-left:20px;"><i class="fa fa-chevron-down" aria-hidden="true"></i></span>
                    </a>
                </h4>
            </div>
            <div id="collapseTicket" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTicket">
                <div class="panel-body">
                    <?php if($ticket_international || $ticket_domestic) : ?>
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i> Your travel tickets are ready for download.
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($ticket_international)): ?>
                        <h4>International Flight</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>File</th>
                                        <th>Note</th>
                                        <th>Uploaded At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($ticket_international as $ticket): ?>
                                        <?php if($ticket->filepath == '') {continue;}?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td><a href="<?= base_url($ticket->filepath) ?>" class="lightbox"><?= html_escape(basename($ticket->filepath)) ?></a></td>
                                            <td><?= !empty($ticket->note) ? html_escape($ticket->note) : '-' ?></td>
                                            <td><?= date('d F Y H:i', strtotime($ticket->created_at)) ?></td>
                                            <td>
                                                <a href="<?= base_url($ticket->filepath) ?>" class="btn btn-primary btn-xs" download>
                                                    <i class="fa fa-download"></i> Download
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php //else: ?>
                        <?php //if($has_tba_flight_proposals) : ?>
                        <!-- <h4>International Flight</h4>
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i> No tickets have been uploaded yet. Please check back later.
                        </div> -->
                        <?php //endif; ?>
                    <?php endif; ?>

                    <?php if (!empty($ticket_domestic)): ?>
                        <h4>Domestic Flight</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>File</th>
                                        <th>Note</th>
                                        <th>Uploaded At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($ticket_domestic as $ticket): ?>
                                        <?php if($ticket->filepath == '') {continue;}?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td><a href="<?= base_url($ticket->filepath) ?>" class="lightbox"><?= html_escape(basename($ticket->filepath)) ?></a></td>
                                            <td><?= !empty($ticket->note) ? html_escape($ticket->note) : '-' ?></td>
                                            <td><?= date('d F Y H:i', strtotime($ticket->created_at)) ?></td>
                                            <td>
                                                <a href="<?= base_url($ticket->filepath) ?>" class="btn btn-primary btn-xs" download>
                                                    <i class="fa fa-download"></i> Download
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php //else: ?>
                        <?php //if($has_tba_flight_proposals) : ?>
                        <!-- <h4>Domestic Flight</h4>
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i> No tickets have been uploaded yet. Please check back later.
                        </div> -->
                        <?php //endif; ?>
                    <?php endif; ?>

                    <?php if (!empty($ticket_accommodation)): ?>
                        <h4>Accommodation</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>File</th>
                                        <th>Note</th>
                                        <th>Uploaded At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($ticket_accommodation as $ticket): ?>
                                        <?php if($ticket->filepath == '') {continue;}?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td><a href="<?= base_url($ticket->filepath) ?>" class="lightbox"><?= html_escape(basename($ticket->filepath)) ?></a></td>
                                            <td><?= !empty($ticket->note) ? html_escape($ticket->note) : '-' ?></td>
                                            <td><?= date('d F Y H:i', strtotime($ticket->created_at)) ?></td>
                                            <td>
                                                <a href="<?= base_url($ticket->filepath) ?>" class="btn btn-primary btn-xs" download>
                                                    <i class="fa fa-download"></i> Download
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php //else: ?>
                        <?php //if($has_tba_flight_proposals) : ?>
                        <!-- <h4>Domestic Flight</h4>
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i> No tickets have been uploaded yet. Please check back later.
                        </div> -->
                        <?php //endif; ?>
                    <?php endif; ?>
                    
                    <?php if (!empty($tba_car_rental_proposals)): ?>
                        <div class="flight-section" style="margin-bottom:20px;">
                            <h4>Car Rental</h4>
                            <div class="tba-proposals-list">
                                <?php foreach ($tba_car_rental_proposals as $index => $proposal): ?>
                                    <?php $is_other_checked = (int)$proposal->is_selected === 1; ?>
                                    Car Details : <?= nl2br(html_escape($proposal->description)) ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

</div>

<script>
    (function () {
        function syncTbaProposalToggles() {
            var descriptions = document.querySelectorAll('.tba-proposal-description');

            Array.prototype.forEach.call(descriptions, function (description) {
                var toggle = description.parentNode.querySelector('.tba-proposal-description-toggle');

                if (!toggle || toggle.getAttribute('data-toggle-bound') === '1') {
                    if (toggle && description.scrollHeight <= description.clientHeight + 1 && description.classList.contains('is-clamped')) {
                        toggle.style.display = 'none';
                    } else if (toggle && description.scrollHeight > description.clientHeight + 1) {
                        toggle.style.display = 'inline-block';
                    }
                    return;
                }

                if (description.scrollHeight <= description.clientHeight + 1) {
                    toggle.style.display = 'none';
                    return;
                }

                toggle.style.display = 'inline-block';
                toggle.setAttribute('data-toggle-bound', '1');

                toggle.addEventListener('click', function (event) {
                    event.preventDefault();
                    event.stopPropagation();

                    var isClamped = description.classList.contains('is-clamped');
                    if (isClamped) {
                        description.classList.remove('is-clamped');
                        toggle.textContent = 'Show less';
                        return;
                    }

                    description.classList.add('is-clamped');
                    toggle.textContent = 'Read more';
                });
            });
        }

        syncTbaProposalToggles();

        // Re-measure when a collapse/tab becomes visible: hidden panes report zero heights.
        if (window.jQuery) {
            window.jQuery(document).off('shown.bs.collapse.tbaProposal shown.bs.tab.tbaProposal').on('shown.bs.collapse.tbaProposal shown.bs.tab.tbaProposal', function () {
                syncTbaProposalToggles();
            });
        }
    })();
</script>
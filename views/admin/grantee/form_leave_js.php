<script src="<?php echo base_url() ?>js/jquery-ui.min.js"></script>
<script>
    var leave_category = $("#leave_category").val();
    var granteeGrantId = '<?= $grantee_grant->id ?>';

    $(document).ready(function() {
        // $('#leave_category').trigger('change')
        $( ".datepickerDate" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "dd M yy",
            yearRange: "<?php echo date('Y') - 150 ?>:<?php echo date('Y') + 20 ?>"
        });
        var dateToday = new Date();
        // var disabledDates = function() {
        //     var tmp = null;
        //     $.ajax({
        //         async: false,
        //         type: 'GET',
        //         url: '<?php echo site_url('grantee/leaves/get_disable_date/') ?>'+granteeGrantId+'/'+leave_category,
        //         success: function(data) {
        //             tmp = data;
        //         }
        //     });
        //     return tmp;
        // }();
        var dates = $("#start_date, #end_date").datepicker({
            changeMonth: true,
            minDate: dateToday,
            changeYear: true,
            dateFormat: "dd M yy",
            yearRange: "<?php echo date('Y') - 150 ?>:<?php echo date('Y') + 20 ?>",
            onSelect: function(selectedDate) {
                startDate = selectedDate;
                var selected_id = $(this).attr("id")
                $("#end_date").datepicker("option", "minDate", selectedDate);
                if(selected_id == 'start_date'){
                    remove_error('validation-error-start-date')
                }else{
                    remove_error('validation-error-end-date')
                }
            }
            // beforeShowDay: function(date){
            //     var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
            //     return [ disabledDates.indexOf(string) == -1 ]
            // },
            // onSelect: function( selectedDate ) {
            //     var option = this.id == "start_date" ? "minDate" : "maxDate",
            //         instance = $( this ).data( "datepicker" ),
            //         date = $.datepicker.parseDate(
            //             instance.settings.dateFormat ||
            //             $.datepicker._defaults.dateFormat,
            //             selectedDate, instance.settings );
            //         categoryLeave = $("#leave_category").val();
            //         if(categoryLeave == <?= SICK_LEAVE ?>){
            //             ofDay = <?= (($grantee_grant->sick_leave != 0 ? $grantee_grant->sick_leave : $grantee_grant->sick_leave_grant) - 1) - array_sum($sick_leave_day)?>;
            //         }else if(categoryLeave == <?= EMERGENCY_LEAVE ?>){
            //             ofDay = <?= (($grantee_grant->emergency_leave != 0 ? $grantee_grant->emergency_leave : $grantee_grant->emergency_leave_grant) - 1) - array_sum($emergency_leave_day)?>;
            //         }else{
            //             ofDay = <?= (($grantee_grant->personal_travel != 0 ? $grantee_grant->personal_travel : $grantee_grant->personal_travel_grant) - 1) - array_sum($personal_travel_day)?>;
            //         }
            //         secondoption = this.id == "start_date" ? "maxDate" : "minDate";

            //         newDate = new Date(date.getFullYear(), date.getMonth(), date.getDate());
            //         newDatemax = new Date(date.getFullYear(), date.getMonth(), date.getDate()-ofDay);
            //         if(this.id == "start_date"){
            //             newDate = new Date(date.getFullYear(), date.getMonth(), date.getDate());
            //             newDatemax = new Date(date.getFullYear(), date.getMonth(), date.getDate()+ofDay);
            //         }
            //         if(this.id == "end_date"){
            //             if(newDatemax < dateToday){
            //                 newDatemax = dateToday;
            //             }
            //         }
            //     if(categoryLeave != <?= SICK_LEAVE ?>){
            //         dates.not( this ).datepicker( "option", option, newDate );
            //         dates.not( this ).datepicker( "option", secondoption, newDatemax );
            //     }else{
            //         if(this.id == "start_date"){
            //         dates.not( this ).datepicker( "option", option, newDate );
            //         dates.not( this ).datepicker( "option", secondoption, newDatemax );
            //         }
            //     }
            // }
        });
    });

    $("#end_date").datepicker({
        dateFormat: "dd M yy",
        // minDate: dateToday,
        onSelect: function(selectedDate) {
            var todayMinusOne = new Date();
            var leave_category = $('#leave_category').val()
            todayMinusOne.setDate(todayMinusOne.getDate() - 1);
            if(leave_category != 2){
                if (new Date(selectedDate) < todayMinusOne) {
                    Swal.fire({
                        icon: "error",
                        text: "The selected date must be today or in the future.",
                        showConfirmButton: false,
                        timer: 2500
                    });
                    $(this).val(''); // Clear the invalid date
                }
            }
            remove_error('validation-error-end-date')
        }
    });

    $("#leave_category").change(function(){
        $("#start_date").val('');
        $("#end_date").val('');
        // var disabledDatesChange = function() {
        //     var tmp = null;
        //     $.ajax({
        //         async: false,
        //         type: 'GET',
        //         url: '<?php echo site_url('grantee/leaves/get_disable_date/') ?>'+granteeGrantId+'/'+this.value,
        //         success: function(data) {
        //             tmp = data;
        //         }
        //     });
        //     return tmp;
        // }();
        var date = new Date();
        var currentMonth = date.getMonth();
        var currentDate = date.getDate();
        var currentYear = date.getFullYear()+1;
        var minYear = date.getFullYear()-1;
        $("#start_date, #end_date").datepicker( "option", "maxDate", new Date(currentYear, currentMonth, currentDate));
        if(this.value == <?= SICK_LEAVE ?>){
            $("#start_date, #end_date").datepicker( "option", "minDate", new Date(minYear, currentMonth, currentDate));
            $('#label_start').html('Start Date')
            $('#label_end').html('End Date')
        }else{
            $("#start_date, #end_date").datepicker( "option", "minDate", new Date());
        }
        $('.validation-error-form-upload').addClass('hide');
        if(this.value == <?= PERSONAL_TRAVEL ?> || this.value == <?= RESEARCH_TRAVEL ?>){
            $("#section_destination").removeClass("hide");
            $("#section_form_upload").removeClass("hide");
            $("#section_boarding_pass").removeClass("hide");
            $("#section_departure_site_date").removeClass("hide");
            $("#section_arrival_site_date").removeClass("hide");
            $("#section_departure_indo_date").removeClass("hide");
            $("#section_arrival_indo_date").removeClass("hide"); 
            $("#section_contact").removeClass("hide");
            $("#section_departure_time").removeClass("hide");

            // $("#section_destination_purpose").removeClass("hide");
            $('#destination').val('').trigger('change');
            $('#label_start').html('Date of Departure from Site')
            $('#label_end').html('Date of Arrival at Site')
            $("#total-request-label").html('Total Requested Travel Days')
            var optionDestination = `
                    <option value="">-- Select Destination --</option>
                    <option value="domestic">Domestic</option>
                    <option value="international">International</option>`;
            if(this.value == <?= RESEARCH_TRAVEL ?>){
                optionDestination = `
                    <option value="">-- Select Destination --</option>
                    <option value="international">International</option>`;
                $('#destination').html('').append(optionDestination);
                $("#research_travel").removeClass("hide");
                $("#section_form_upload").addClass("hide");
            }else{
                $("#research_travel").addClass("hide");
                $('#destination').html('').append(optionDestination);
            }
            
        }else if(this.value == <?= SICK_LEAVE ?>){
            $("#section_form_upload").removeClass("hide");

            $("#section_destination").addClass("hide");
            $("#section_boarding_pass").addClass("hide");
            $("#section_destination_purpose").addClass("hide");
            $("#section_departure_site_date").addClass("hide");
            $("#section_arrival_site_date").addClass("hide");
            $("#section_departure_indo_date").addClass("hide");
            $("#section_arrival_indo_date").addClass("hide");
            $("#section_contact").addClass("hide");
            $("#section_departure_time").addClass("hide");
            $('#label_start').html('Start Date')
            $('#label_end').html('End Date')
            $("#total-request-label").html('Total Requested Sick Leave')
            $("#research_travel").addClass("hide");
        }else if(this.value == <?= EMERGENCY_LEAVE ?>){
            $("#section_destination_purpose").removeClass("hide");
            
            $("#section_destination").addClass("hide");
            $("#section_boarding_pass").addClass("hide");
            $("#section_form_upload").removeClass("hide");
            $("#section_departure_site_date").addClass("hide");
            $("#section_arrival_site_date").addClass("hide");
            $("#section_departure_indo_date").addClass("hide");
            $("#section_arrival_indo_date").addClass("hide");
            $("#section_contact").addClass("hide");
            $("#section_departure_time").addClass("hide");
            $('#label_start').html('Start Date')
            $('#label_end').html('End Date')
            $("#total-request-label").html('Total Requested Emergency Leave')
            $("#research_travel").addClass("hide");
        }else{
            $("#section_destination").addClass("hide");
            $("#section_form_upload").addClass("hide");
            $("#section_boarding_pass").addClass("hide");
            $("#section_destination_purpose").addClass("hide");
            $("#section_departure_time").addClass("hide");
            $("#research_travel").addClass("hide");
        }

        <?php if ($grantee_grant->category_grant == ETA ) { ?>
            if (this.value == '<?php echo PERSONAL_TRAVEL; ?>') {
                $('#required-form-upload').removeClass('hide');
            } else {
                $('#required-form-upload').addClass('hide');
            }
        <?php  } ?>
    });

    $("#destination").change(function() {
        if(this.value == 'international'){
            $("#section_departure_indo_date").removeClass("hide");
            $("#section_arrival_indo_date").removeClass("hide");
            $("#section_destination_purpose").removeClass("hide");
            $(".international-travel-required").removeClass("hide");
        }else{
            $("#section_departure_indo_date").addClass("hide");
            $("#section_arrival_indo_date").addClass("hide");
            $("#section_destination_purpose").removeClass("hide");
            $(".international-travel-required").addClass("hide");
        }
        
        if (this.value == '') {
            $("#section_destination_purpose").addClass("hide");
        }

        let category_grant = '<?php echo $grantee_grant->category_grant; ?>';
        let destination = $('#destination').val();
        if (category_grant == 3) {
            let download_url = null;
            if (destination == 'domestic') {
                download_url = '<?php echo site_url() . $user_grantee_grant->personal_travel_form; ?>';
            } else if (destination == 'international') {
                download_url = '<?php echo site_url() . $user_grantee_grant->international_travel_form; ?>';
            }

            if (download_url != null) {
                $('#download-template-form').removeClass('hide');
                $('#download-template-form').find('a').prop('href', download_url);
            } else {
                $('#download-template-form').addClass('hide');
            }
        }
    });

    // $("#form_leave").on('submit', function() {

    //     var invalid = false;
    //     var leave_category = $("#leave_category").val();
    //     var totalRequest = $('#total_request').val();
    //     // get disabled date
    //     var disabledDatesChange = function() {
    //         var tmp = null;
    //         $.ajax({
    //             async: false,
    //             type: 'GET',
    //             url: '<?php echo site_url('grantee/leaves/get_disable_date/') ?>'+granteeGrantId+'/'+leave_category,
    //             success: function(data) {
    //                 tmp = data;
    //             }
    //         });
    //         return tmp;
    //     }();
    //     if (leave_category != '') {
    //         $(".validation-error-leave-category").addClass('hide');
    //     } else {
    //         $(".validation-error-leave-category").removeClass('hide');
    //         invalid = true;
    //     }
        
    //     var start_date = $("#start_date").val();
    //     if (start_date != '') {
    //         $(".validation-error-start-date").addClass('hide');
    //     } else {
    //         $(".validation-error-start-date").removeClass('hide');
    //         invalid = true;
    //     }
        
    //     var end_date = $("#end_date").val();
    //     if (end_date != '') {
    //         $(".validation-error-end-date").addClass('hide');
    //     } else {
    //         $(".validation-error-end-date").removeClass('hide');
    //         invalid = true;
    //     }
        
    //     var total_request = $("#total_request").val();
    //     if (total_request != '') {
    //         $(".validation-error-total-request").addClass('hide');
    //     } else {
    //         $(".validation-error-total-request").removeClass('hide');
    //         invalid = true;
    //     }

    //     // validasi total request
    //     if(leave_category == <?= PERSONAL_TRAVEL ?>){
    //         var calculate = parseInt(totalRequest) + parseInt(totalPersonalTravel);
    //         if(calculate > granteeGrantPersonalTravel){
    //             Swal.fire({
    //                 icon: "error",
    //                 text: "You have exceeded your available leave days. Please adjust your request to match your remaining leave balance.",
    //                 showConfirmButton: false,
    //                 timer: 2500
    //             });
    //             var invalid = true;
    //         }
    //     }else if(leave_category == <?= SICK_LEAVE ?>) {
    //         var calculate = parseInt(totalRequest) + parseInt(totalSick);
    //         if(calculate > granteeGrantSick){
    //             Swal.fire({
    //                 icon: "error",
    //                 text: "You have exceeded your available leave days. Please adjust your request to match your remaining leave balance.",
    //                 showConfirmButton: false,
    //                 timer: 2500
    //             });
    //             var invalid = true;
    //         }
    //     }else if(leave_category == <?= EMERGENCY_LEAVE ?>){
    //         var calculate = parseInt(totalRequest) + parseInt(totalEmergency);
    //         if(calculate > granteeGrantEmergency){
    //             Swal.fire({
    //                 icon: "error",
    //                 text: "You have exceeded your available leave days. Please adjust your request to match your remaining leave balance.",
    //                 showConfirmButton: false,
    //                 timer: 2500
    //             });
    //             var invalid = true;
    //         }
    //     }

    //     if(jQuery.inArray(formatDate(start_date), disabledDatesChange) !== -1) {
    //         invalid = true;
    //         $("#start_date").val('');
    //         $("#end_date").val('');
    //         $("#label-for-date").html('From date/To date has been taken')
    //         var date = new Date();
    //         var currentMonth = date.getMonth();
    //         var currentDate = date.getDate();
    //         var currentYear = date.getFullYear()+1;
    //         $("#start_date, #end_date").datepicker( "option", "maxDate", new Date(currentYear, currentMonth, currentDate));
    //         $("#success-alert").fadeTo(5000, 500).slideUp(500, function() {
    //         $("#success-alert").slideUp(500);
    //         });
    //         $(".validation-error-end-date").addClass('hide');
    //         $(".validation-error-start-date").addClass('hide');
    //     }

    //     if(invalid == false){
    //         return true;
    //     }else{
    //         $("#btn-submit").prop( "disabled", false );
    //         $("#btn-submit").html('Save');
    //         return false;
    //     }
    // });

    let is_form_confirmed = false; 

    $("#form_leave").on('submit', function(e) {
        
        if (is_form_confirmed) {
            return true; 
        }

        e.preventDefault(); 
        var invalid = false;
        var leave_category = $("#leave_category").val();
        var totalRequest = $('#total_request').val();
        var destination = $('#destination').val();

        // Validasi input
        if (leave_category == '') {
            $(".validation-error-leave-category").removeClass('hide');
            invalid = true;
        } else {
            $(".validation-error-leave-category").addClass('hide');
        }

        var start_date = $("#start_date").val();
        if (start_date == '') {
            $(".validation-error-start-date").removeClass('hide');
            invalid = true;
        } else {
            $(".validation-error-start-date").addClass('hide');
        }

        var end_date = $("#end_date").val();
        if (end_date == '') {
            $(".validation-error-end-date").removeClass('hide');
            invalid = true;
        } else {
            $(".validation-error-end-date").addClass('hide');
        }

        if(destination == 'international'){
            var departure_indo_date = $("#departure_indo_date").val();
            if (departure_indo_date == '') {
                $(".validation-error-departure-indo-date").removeClass('hide');
                invalid = true;
            } else {
                $(".validation-error-departure-indo-date").addClass('hide');
            }

            var arrival_indo_date = $("#arrival_indo_date").val();
            if (arrival_indo_date == '') {
                $(".validation-error-arrival-indo-date").removeClass('hide');
                invalid = true;
            } else {
                $(".validation-error-arrival-indo-date").addClass('hide');
            }
        }

        <?php if ($grantee_grant->category_grant == ETA ) { ?>
            let destination_purpose = $('textarea[name="destination_purpose"]').val();
            let contact_telephone = $('input[name="telephone"]').val();
            let contact_email = $('input[name="email"]').val();
            let contact_address = $('textarea[name="address"]').val();
            let personal_leave_type = '<?php echo PERSONAL_TRAVEL; ?>';
            let form_upload = $('input[name="form_upload"]').val();
            if (leave_category == personal_leave_type) {
                if (destination_purpose == '') {
                    $(".validation-error-destination-purpose").removeClass('hide');
                    invalid = true;
                } else {
                    $(".validation-error-destination-purpose").addClass('hide');
                }

                if (destination == '') {
                    $(".validation-error-destination").removeClass('hide');
                    invalid = true;
                } else {
                    $(".validation-error-destination").addClass('hide');
                }

                if(destination == 'international'){
                    if (contact_telephone == '') {
                        $(".validation-error-contact-phone").removeClass('hide');
                        invalid = true;
                    } else {
                        $(".validation-error-contact-phone").addClass('hide');
                    }

                    if (contact_email == '') {
                        $(".validation-error-email-contact").removeClass('hide');
                        invalid = true;
                    } else {
                        $(".validation-error-email-contact").addClass('hide');
                    }

                    if (contact_address == '') {
                        $(".validation-error-contact-address").removeClass('hide');
                        invalid = true;
                    } else {
                        $(".validation-error-contact-address").addClass('hide');
                    }
                }

                if (form_upload == '') {
                    $(".validation-error-form-upload").removeClass('hide');
                    invalid = true;
                } else {
                    $(".validation-error-form-upload").addClass('hide');
                }
            }
        <?php } ?>

        var total_request = $("#total_request").val();
        if (total_request == '') {
            $(".validation-error-total-request").removeClass('hide');
            invalid = true;
        } else {
            $(".validation-error-total-request").addClass('hide');
        }

        let remaining_leave = 0;
        if (invalid == false) {
            let is_exceeded = false;
            if (leave_category == <?= PERSONAL_TRAVEL ?>) {
                var calculate = parseInt(totalRequest) + parseInt(totalPersonalTravel);
                remaining_leave = granteeGrantPersonalTravel - calculate;
                if (calculate > granteeGrantPersonalTravel) {
                    is_exceeded = true;
                }
            } else if (leave_category == <?= SICK_LEAVE ?>) {
                var calculate = parseInt(totalRequest) + parseInt(totalSick);
                remaining_leave = granteeGrantPersonalTravel - calculate;
                if (calculate > granteeGrantSick) {
                    is_exceeded = true;
                }
            } else if (leave_category == <?= EMERGENCY_LEAVE ?>) {
                var calculate = parseInt(totalRequest) + parseInt(totalEmergency);
                remaining_leave = granteeGrantPersonalTravel - calculate;
                if (calculate > granteeGrantEmergency) {
                    is_exceeded = true;
                }
            } else if (leave_category == <?= RESEARCH_TRAVEL ?>) {
                var calculate = parseInt(totalRequest) + parseInt(totalResearch);
                remaining_leave = granteeResearch - calculate;
                if (calculate > granteeResearch) {
                    is_exceeded = true;
                }
            }
            
            if (is_exceeded) {
                Swal.fire({
                    title: 'Do you want to proceed?',
                    text: "Please be aware that you have submitted a request for " + totalRequest + " extra days beyond your original allocated personal leave days. This will result in a reduction of your grant payment. Please contact us if this was not your intention.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, submit it',
                    cancelButtonText: 'No, cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        is_form_confirmed = true;
                        $("#btn-submit").prop("disabled", false);
                        $("#btn-submit").html('Saving...');
                        $("#form_leave").submit();
                    } else {
                        is_form_confirmed = false;
                    }
                });

                $("#btn-submit").prop( "disabled", false );
                $("#btn-submit").html('Save');
                return false;
            } else {
                is_form_confirmed = true;
                $("#btn-submit").prop("disabled", false);
                $("#btn-submit").html('Saving...');
                $("#form_leave").submit();
            }
        } else {
            $("#btn-submit").prop( "disabled", false );
            $("#btn-submit").html('Save');
            return false;
            return false; // Jika invalid, hentikan proses
        }
    });


    function remove_error(error_element) {
        $('.' + error_element).addClass('hide');
    }

    $("#btn-submit").click(function() {
        $("#btn-submit").prop( "disabled", true );
        $("#btn-submit").html('<img src="<?php echo base_url() ?>/img/loading.gif">');
        $("#form_leave").submit();
    });
    
    function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) 
            month = '0' + month;
        if (day.length < 2) 
            day = '0' + day;

        return [year, month, day].join('-');
    }
</script>

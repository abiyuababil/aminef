<script src="<?php echo base_url() ?>js/jquery-ui.min.js"></script>
<script>
    var leave_category = $("#leave_category").val();
    var granteeGrantId = '<?= $this->session->userdata('grantee_grant_id') ?>';

    $(document).ready(function() {
        $('#leave_category, #destination').trigger('change')
        $( ".datepickerDate" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "dd M yy",
            yearRange: "<?php echo date('Y') - 150 ?>:<?php echo date('Y') + 20 ?>"
        });
        var dateToday = new Date();
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
                    <option <?= $data->destination == 'domestic' ? 'selected' : '' ?> value="domestic">Domestic</option>
                    <option <?= $data->destination == 'international' ? 'selected' : '' ?>  value="international">International</option>`;
            if(this.value == <?= RESEARCH_TRAVEL ?>){
                optionDestination = `
                    <option value="">-- Select Destination --</option>
                    <option <?= $data->destination == 'international' ? 'selected' : '' ?>  value="international">International</option>`;
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
    });

    $("#destination").change(function() {
        if(this.value == 'international'){
            $("#section_departure_indo_date").removeClass("hide");
            $("#section_arrival_indo_date").removeClass("hide");
            $("#section_destination_purpose").removeClass("hide");
        }else{
            $("#section_departure_indo_date").addClass("hide");
            $("#section_arrival_indo_date").addClass("hide");
            $("#section_destination_purpose").removeClass("hide");
        }
        
        if (this.value == '') {
            $("#section_destination_purpose").addClass("hide");
        }
    });

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
                    // text: "Please be aware that you have submitted a request for " + totalRequest + " extra days beyond your original allocated personal leave days. This will result in a reduction of your grant payment. Please contact us if this was not your intention.",
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

    function delete_file_upload(el, id) {
        if (confirm("Are you sure want to delete this ?")){
            showSwal('loading', 'Please wait while we process your request.');
            $.ajax({
                type: 'GET',
                url:  "<?= base_url(); ?>admin/travel_request/delete_form/" + id,
                dataType: 'JSON',
                success: function(r) {
                    Swal.close(); 
                    $('#file_form').remove();
                    showSwal('success', 'Successfully delete the file', false, true, 1500);
                }
            });
        }

    }
</script>

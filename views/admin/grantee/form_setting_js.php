<script src="<?php echo base_url() ?>js/jquery-ui.min.js"></script>
<script>
    $(document).ready(function(){
        $(".datepicker").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "dd M yy",
            yearRange: "<?php echo date('Y') - 150 ?>:<?php echo date('Y') + 20 ?>"
        });
    });

    $('#is_unlimited_grant_support').change(function() {
        if (this.checked) {
            $("input[name='setting[grant_support]']").val('0').attr('readonly', true);
        } else {
            val = $("input[name='setting[grant_support]']").data('value');
            $("input[name='setting[grant_support]']").val(val).attr('readonly', false);
        }
    });
    $('#is_unlimited_grant_total').change(function() {
        if (this.checked) {
            $("input[name='setting[grant_total]']").val('0').attr('readonly', true);
        } else {
            val = $("input[name='setting[grant_total]']").data('value');
            $("input[name='setting[grant_total]']").val(val).attr('readonly', false);
        }
    });
    $('#is_unlimited_international_travel').change(function() {
        if (this.checked) {
            $("input[name='setting[international_travel]']").val('0').attr('readonly', true);
        } else {
            val = $("input[name='setting[international_travel]']").data('value');
            $("input[name='setting[international_travel]']").val(val).attr('readonly', false);
        }
    });
    
    var dates = $( ".datepickerperiod" ).datepicker({ 
        changeMonth: true,
        changeYear: true,
        dateFormat: "dd M yy",
        // minDate: new Date(),
        yearRange: "<?php echo date('Y') - 150 ?>:<?php echo date('Y') + 20 ?>",
            onSelect: function( selectedDate ) {
                var option = this.id == "start_date" ? "minDate" : "maxDate",
                    instance = $( this ).data( "datepicker" ),
                    date = $.datepicker.parseDate(
                        instance.settings.dateFormat ||
                        $.datepicker._defaults.dateFormat,
                        selectedDate, instance.settings );

                    newDate = new Date(date.getFullYear(), date.getMonth(), date.getDate());
                    newDatemax = new Date(date.getFullYear(), date.getMonth(), date.getDate());
                    if(this.id == "start_date"){
                        newDate = new Date(date.getFullYear(), date.getMonth(), date.getDate());
                        newDatemax = new Date(date.getFullYear(), date.getMonth(), date.getDate());
                    }
                    if(this.id == "end_date"){
                        if(newDatemax < new Date()){
                            newDatemax = new Date();
                        }
                    }
                    dates.not( this ).datepicker( "option", option, newDate );
            }
    });


    $("#form").on('submit', function(e) { 
        // $("#btn-submit").html('<img src="<?php echo base_url() ?>/img/loading.gif">').prop( "disabled", true )
        if(<?= $grantee_grant->country_id ?> == 1){
            var p_grant_cost = parseInt('<?= $period->grant_cost ?>')
            var p_grant_support = parseInt('<?= $period->grant_supporting ?>')
            var p_international_travel = parseInt('<?= $period->international_travel ?>')
            var international_travel = $("#international_travel").val();
            var grant_support   = $("#grant_support").val();
            var grant_cost = $("#grant_total").val();
            var is_unlimited_grant_cost = '<?= $period->is_unlimited_grant_cost ?>'
            var is_unlimited_grant_supporting = '<?= $period->is_unlimited_grant_supporting ?>'
            var is_unlimited_international_travel = '<?= $period->is_unlimited_international_travel ?>'
            if(grant_cost == ''){
                grant_cost = 0
            }
            if(grant_support == ''){
                grant_support = 0
            }
            if(international_travel == ''){
                international_travel = 0
            }

            var grant_cost = parseInt(grant_cost);
            var grant_support = parseInt(grant_support);
            var international_travel = parseInt(international_travel);
            var message = "";

            // grant cost
            var calculate_grant_cost = function() {
                var tmp = null;
                $.ajax({
                    async: false,
                    type: 'GET',
                    url: '<?php echo site_url('admin/grantee/get_calculate_cost?period_id=') ?>'+ <?= $period->id ?> + '&category=grant_cost&grantee_grant_id=<?= $grantee_grant->id ?>' ,
                    success: function(data) {
                        tmp = data;
                    }
                });
                return tmp;
            }();
            if(is_unlimited_grant_cost == false && (parseInt(calculate_grant_cost)+grant_cost) > p_grant_cost) {
                alert('Cost is exceeded the total cost. Please check the total cost on Active Grant - Period')
                e.preventDefault()
                $("#btn-submit").html('Submit').prop( "disabled", false )
                return false
            }

            // support
            var calculate_grant_support = function() {
                var tmp = null;
                $.ajax({
                    async: false,
                    type: 'GET',
                    url: '<?php echo site_url('admin/grantee/get_calculate_cost?period_id=') ?>'+ <?= $period->id ?> + '&category=grant_support&grantee_grant_id=<?= $grantee_grant->id ?>' ,
                    success: function(data) {
                        tmp = data;
                    }
                });
                return tmp;
            }();
            if(is_unlimited_grant_supporting == false && (parseInt(calculate_grant_support)+grant_support) > p_grant_support) {
                alert('Cost is exceeded the total cost. Please check the total cost on Active Grant - Period')
                e.preventDefault()
                $("#btn-submit").html('Submit').prop( "disabled", false )
                return false
            }

            // international travel
            var calculate_international_travel = function() {
                var tmp = null;
                $.ajax({
                    async: false,
                    type: 'GET',
                    url: '<?php echo site_url('admin/grantee/get_calculate_cost?period_id=') ?>'+ <?= $period->id ?> + '&category=travel&grantee_grant_id=<?= $grantee_grant->id ?>' ,
                    success: function(data) {
                        tmp = data;
                    }
                });
                return tmp;
            }();
            if(is_unlimited_international_travel == false && (parseInt(calculate_international_travel)+international_travel) > p_international_travel) {
                alert('Cost is exceeded the total cost. Please check the total cost on Active Grant - Period')
                e.preventDefault()
                $("#btn-submit").html('Submit').prop( "disabled", false )
                return false
            }
        }

    });

    $('.start_date').on('change', function() {
        let start_date = $(this).val();
        let category_id = $(this).data('cr_id');
        if (start_date) {
            let parsed = $.datepicker.parseDate("dd M yy", start_date);

            // end_date (+14 days after start_date)
            let end_date_obj = new Date(parsed.getTime());
            end_date_obj.setDate(end_date_obj.getDate() + 14);
            let end_date = $.datepicker.formatDate("dd M yy", end_date_obj);
            $('input[name="report_date['+category_id+'][end_date]"]').val(end_date);

            // reminder (-7 days from before start_date)
            let reminder_obj = new Date(parsed.getTime());
            reminder_obj.setDate(reminder_obj.getDate() - 7);
            let reminder = $.datepicker.formatDate("dd M yy", reminder_obj);
            $('input[name="report_date['+category_id+'][remainder]"]').val(reminder);
        } else {
            $('input[name="report_date['+category_id+'][end_date]"]').val('');
            $('input[name="report_date['+category_id+'][remainder]"]').val('');
        }
    });

    $(document).on('click', '#apply-default-reports', function(e){
        if (typeof window.__reportDefaults === 'undefined') return;
        $.each(window.__reportDefaults, function(id, def){
            if (def.start !== undefined && def.start !== '') {
                $('input[name="report_date['+id+'][date]"]').val(def.start);
            }
            if (def.end !== undefined && def.end !== '') {
                $('input[name="report_date['+id+'][end_date]"]').val(def.end);
            }
            if (def.reminder !== undefined && def.reminder !== '') {
                $('input[name="report_date['+id+'][remainder]"]').val(def.reminder);
            }
        });
    });
</script>
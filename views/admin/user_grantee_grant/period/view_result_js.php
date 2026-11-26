<script>
    $(".option-survey").click(function() {
        $(".result-loading").show();
        var option = $(this).data('option');
        var option_type = $(this).data('option-type');
        var custom_fields_id = $(this).data('custom-fields-id');
        var period_id = $(this).data('period-id');
        $.ajax({
            url: '<?= base_url('admin/User_grantee_grant/get_survey_answer')?>',
            method: "POST",
            dataType: "json",
            data:{
                value: option,
                option_type: option_type,
                custom_fields_id: custom_fields_id,
                period_id: period_id,
            },
            
        }).success(function(data) {
            $(".result-loading").hide();
            $(".data-body").remove();
            $(".table-result").append("<tbody class='data-body'></tbody>");
            if (data.length > 0){
                $.each(data, function(index, value) {
                    if(value.country_id == 1){
                        if(value.middle_name != ''){
                            var full_name =  value.first_name + " " + value.last_name + " " + value.middle_name
                        }else{
                            var full_name =  value.first_name + " " + value.last_name
                        }
                    }else{
                        if(value.middle_name != ''){
                            var full_name =  value.last_name + ", " + value.first_name + " " + value.middle_name
                        }else{
                            var full_name =  value.last_name + ", " + value.first_name
                        }
                    }
                    var $tr = $('<tr>').append(
                    $('<td>').text(full_name),
                ).appendTo('.table-result > tbody');
                });
            }else{
                var $tr = $('<tr>').append(
                    $('<td>').text("Not Found"),
                ).appendTo('.table-result > tbody');
            }
        });
    })


    
    $('#modal_answer').on('show.bs.modal', function(event){
      $.fn.modal.Constructor.prototype.enforceFocus = function () { 

        var button = $(event.relatedTarget);
        var option_type = button.data('option-type');
        var custom_fields_id = button.data('custom-fields-id');
        var period_id = button.data('period-id');
        var question = button.data('question');

        $(".modal-title").html(question);
        $.ajax({
            url: '<?= base_url('admin/User_grantee_grant/get_survey_answer_text')?>',
            method: "POST",
            dataType: "json",
            data:{
                option_type: option_type,
                custom_fields_id: custom_fields_id,
                period_id: period_id,
            },
            
        }).success(function(data) {
            $(".data-body-text").remove();
            $("#spinner").hide();
            $(".table-result-text").append("<tbody class='data-body-text'></tbody>");
            if (data.length > 0){
                $.each(data, function(index, value) {
                    if(value.country_id == 1){
                        if(value.middle_name != null){
                            var full_name =  value.first_name + " " + value.last_name + " " + value.middle_name
                        }else{
                            var full_name =  value.first_name + " " + value.last_name
                        }
                    }else{
                        if(value.middle_name != null){
                            var full_name =  value.last_name + ", " + value.first_name + " " + value.middle_name
                        }else{
                            var full_name =  value.last_name + ", " + value.first_name
                        }
                    }
                    var $tr = $('<tr>').append(
                    $('<td>').text((index+1) + '.' + ' ' + full_name + " - " + value.value),
                ).appendTo('.table-result-text > tbody');
                });
            }else{
                var $tr = $('<tr>').append(
                    $('<td>').text("Not Found"),
                ).appendTo('.table-result-text > tbody');
            }
        });
      };
    });
</script>
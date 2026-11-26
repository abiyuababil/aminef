<script>
$("#category_id").change(function() {
    var step_el = 'step_id';
    var load_id = '#load-' + step_el;
    $(load_id).show();
    reset_step(this.id);
    reset_question(this.id);
    $.ajax({
        type: 'GET',
        url: '<?php echo site_url('admin/missing_document/get_steps') ?>/' + this.value,
        dataType: 'JSON',
        success: function(r) {
            $.each(r, function(id, val) {
                $('#' + step_el).append('<option value="' + val.id + '">' + val.label + '</option>');
            });
            $(load_id).hide();
        }
    });
});

$("#step_id").change(function() {
    var question_el = 'question_id';
    var load_id = '#load-' + question_el;
    $(load_id).show();
    reset_question(this.id);
    $.ajax({
        type: 'GET',
        url: '<?php echo site_url('admin/missing_document/get_questions') ?>/' + this.value,
        dataType: 'JSON',
        success: function(r) {
            $.each(r, function(id, val) {
                $('#' + question_el).append('<option value="' + val.id + '">' + val.name + '</option>');
            });
            $(load_id).hide();
        }
    });
});

$("#question_id").change(function() {
    var question_el = 'question_id';
    var load_id = '#load-' + question_el;
    $(load_id).show();
    $('#data_value').html('')
    $.ajax({
        type: 'GET',
        url: '<?php echo site_url('admin/missing_document/get_value_question') ?>/' + this.value + '/<?= $grantee_grant_id ?>',
        dataType: 'JSON',
        success: function(r) {
            $('#data_value').append(r);
            $(load_id).hide();
            $('.lightbox').topbox();
            $('.select_multiselect').select2();
        }
    });
});

function reset_step(id) {
    var step = '#step_id';
    $(step).html('');
    $(step).append('<option value="">-- Select Step --</option>');
}

function reset_question(id) {
    var question = '#question_id';
    $(question).html('');
    $(question).append('<option value="">-- Select Question --</option>');
}


$(document).ready(function(){
    var data_missing = '<?= $data_missing->id ?>'
    var data_before = '<?= $data_missing->data_before ?>'
    if(data_before == '' && data_missing){
        $("#question_id").trigger('change');
    }
});
</script>
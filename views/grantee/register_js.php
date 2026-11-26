<script>
$(document).ready(function() {
    var showPicker = false;
    $( ".datepicker" ).datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "dd M yy",
        maxDate:"<?php echo date('d M Y', strtotime('-16 year')) ?>" ,
        defaultDate:"<?php echo date('d M Y', strtotime('-16 year')) ?>" ,
        yearRange: "<?php echo date('Y') - 100 ?>:<?php echo date('Y') - 16 ?>",
        onClose: function(dateText, inst) {
            showPicker = false;
        }
    });
    $( ".datepickeror" ).datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "dd M yy",
    });
    $(".ui-datepicker").on("mouseenter", function() {
        if (!showPicker) {
            showPicker = true;
            //Reverse the years
            var dropYear = $("select.ui-datepicker-year");
            dropYear.find('option').each(function() {
                dropYear.prepend(this);
            });
        }

    });

    $('#password').bind('click keyup', function(){
        var str=$('#password').val();
        var upper_text= new RegExp('[A-Z]');
        var number_check=new RegExp('[0-9]');

        var flag='T';

        if(str.match(upper_text)){
            $('#d12').html("<i class='fa fa-check' aria-hidden='true'></i> One Upper Case Letter");
            $('#d12').css("color", "green");
        }else{
            $('#d12').css("color", "red");
            $('#d12').html("<i class='fa fa-times' aria-hidden='true'></i> One Upper Case Letter");
        flag='F';}

        if(str.match(number_check)){
            $('#d15').html("<i class='fa fa-check' aria-hidden='true'></i> One Number");
            $('#d15').css("color", "green");
        }else{
            $('#d15').css("color", "red");
            $('#d15').html("<i class='fa fa-times' aria-hidden='true'></i> One Number");
        flag='F';}


        if(str.length>7){
            $('#d16').html("<i class='fa fa-check' aria-hidden='true'></i> Length 8 Char ");
            $('#d16').css("color", "green");
        }else{
            $('#d16').css("color", "red");
            $('#d16').html("<i class='fa fa-times' aria-hidden='true'></i> Length 8 Char ");
        flag='F';}


        if(flag=='T'){
            $("#d1").fadeOut();
            $(".btn-subpas").prop("disabled", false);
        }else{
            $("#d1").show();
            $(".btn-subpas").prop("disabled", true);
        }
    });

    // $('#password').blur(function(){
    //     $("#d1").fadeOut();
    // });

    $('#password').focus(function(){
        $("#d1").show();
    });

    $('#chk-offline').change(function(){
        if($(this).is(':checked')) {
        $('.form-offline').removeClass('hide');
        } else {
        $('.form-offline').addClass('hide');
        }
    });
})

function emptyValue(object){
    $(object).closest('.form-group').find('.datepickeror').val('');
}
</script>
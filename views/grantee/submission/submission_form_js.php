<script src="<?php echo base_url() ?>js/jquery-ui.min.js"></script>
<script src="<?php echo base_url() ?>js/select2.min.js"></script>
<script>

    $('.progressbar li').on('click', function(){
        // $(this).find('a').click();
    });

    $(".datepicker" ).datepicker({
    changeMonth: true,
    changeYear: true,
    dateFormat: "dd M yy",
    yearRange: "<?php echo date('Y') - 150 ?>:<?php echo date('Y') + 20 ?>",
    onClose: function() {
        $(this).trigger('blur');
    }
    });

    function next_step(step){
        $("#li_step_"+(step-1)).removeClass("active");
        $("#li_step_"+(step-1)).addClass("done");
        $("#li_step_"+step).addClass("active");
    }

    function back_step(step){
        console.log(step)
        $("#li_step_"+(step+1)).removeClass("active");
        $("#li_step_"+(step+1)).removeClass("done");
        $("#li_step_"+step).addClass("active");
    }
        

    function reset_done(step, args){
        // remove all class done
        $(".stepper-list").removeClass("done");
        for (let i = step; i > 0; i--) {
            $(`#li_step_${i}`).addClass("done");
        }

        // trigger a clicked when li clicked
        var children = $(args).children('a');
        children[0].click()
    }

    var error = 0;

    $(document).ready(function(){

        $(".submit-submission").click(function(){
            if (error == 0){
                $("#" + $(this).data('submit')).submit();
            }
        })
        
        $(".select2").select2();
        $(".datetime").datetimepicker({
            format: 'yyyy-mm-dd hh:ii',
            autoclose: true,
        });
        $(".select2").on('select2:close', function () {
            $(this).trigger('blur');
        });

        
        // loop and check if value are not empty 
        $( '.autosave').each( function () {
            var is_required = $(this).attr('required');
            if (is_required){
                if($(this).val() == ''){
                }
            }
        });
        
        $(".upload-button").click(function(){

            var data_value = $(this).data('file-value');
            var fileview   = $(this).closest('.col-lg-4').find('.fileview'); 
            var icon       = $(this).closest('.col-lg-4').find('.submission-spinner'); 
            var base_url   = "<?= base_url()?>";

            // trigger click to closest type file
            $(`.${data_value}`).click();

            // add event when file has choosen
            $(`.${data_value}`).change(function(e){

                // define variable name
                var custom_fields_id = $(this).data('id');
                var step_id = $(this).data('step');
                var category_id = $(this).data('category-id');
                var grant_id = $(this).data('grant-id');
                var fileName = e.target.files[0].name;

                // set filename into label
                $(this).closest('.col-lg-4').find('.filename').html(fileName)
                icon.css('display', 'block')

                // define value form data
                var formData = new FormData();
                formData.append("file", e.target.files[0]);
                formData.append("user_grantee_custom_fields_id", custom_fields_id),
                formData.append("user_grantee_step_id", step_id),
                formData.append("user_grantee_category_id", category_id),
                formData.append("user_grantee_grant_id", grant_id)

                // autosave
                $.ajax({
                    url: "<?= base_url(); ?>grantee/submission/save_fields", 
                    type: 'POST',
                    data: formData, // The form with the file inputs.
                    processData: false,
                    contentType: false                    // Using FormData, no need to process data.
                }).done(function(r){
                    console.log("Success: Files sent!");
                    var postsjson = $.parseJSON(r);
                    if(postsjson.redirect){
                        window.location.href = postsjson.redirect;
                        return false
                    }
                    fileview.css("display", "block");
                    icon.css('display', 'none');
                    fileview.attr("href", base_url+postsjson.filepath );
                });
            })
            });
    
        $("#btn-submit").click(function(){
            $("#mdl_info").modal();    
            event.preventDefault();
        });



        $(".autosave").blur(function(){
            var data_value = $(this).val();
            var custom_fields_id = $(this).data('id');
            var is_required = $(this).attr("required");

            // add logic for checkbox
            if ($(this).is(':checkbox')){
                data_value = [];
                    $.each($(`input[type='checkbox']:checked`), function(){
                        data_value.push($(this).val())
                    })
            }

            // logic for required 
            if (is_required){
                // jika datanya tidak kosong
                if (data_value) {
                    if (error > 0) error--;
                }else{
                    error++;
                }
            }

            if (error == 0){
                $(".next, .submit-submission").removeClass("disabled");
            }else{
                $(".next, .submit-submission").addClass("disabled");
            }

            var step_id = $(this).data('step');
            var category_id = $(this).data('category-id');
            var grant_id = $(this).data('grant-id');
            $.ajax({
                url: "<?= base_url(); ?>grantee/submission/save_fields",
                method: "POST",
                data: {
                    value: data_value,
                    user_grantee_custom_fields_id: custom_fields_id,
                    user_grantee_step_id: step_id,
                    user_grantee_category_id: category_id,
                    user_grantee_grant_id: grant_id
                }
            })
            .success(function(data){
                console.log(data);
            })
        })
    })
  
</script>
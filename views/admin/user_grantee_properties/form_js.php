<script>

    $("#category-type").change(function(){
        // jika yang dipilih adalah category
        if ($(this).val() == 1){
            $(".category-wrap").removeClass("hide")
            $(".category-report-wrap").addClass("hide")
        }else{
            // jika yang dipilih adalah category report
            $(".category-report-wrap").removeClass("hide")
            $(".category-wrap").addClass("hide")
            $(".step-wrap").addClass("hide")
        }
    })
    
    $("#category").change(function(){
        $(".step-wrap").removeClass("hide")
        // get step
        $.ajax({
            url: '<?= site_url('admin/user_grantee_properties/get_step') ?>',
            dataType: "json",
            data: {
                grant_id: $("#grant").val(),
                category_id: $("#category").val()
            },
            success: function(data) {
                
                // remove current step option 
                $("#step").html('').append(
                    $("<option>", {
                        value: "",
                        text: "Select Step"
                    })
                )
                for(let option of data){
                    $("#step").append(
                        $("<option>", {
                            value: option.id,
                            text: option.name,
                            selected: $("#temp_step_id").val() == option.id ? true : false
                        })
                    )
                }
            }
        })
	})

    $("#grant").change(function(){
        // get category 
        $(".step-wrap").addClass('hide')
        $.ajax({
            url: '<?= site_url('admin/user_grantee_properties/get_category') ?>',
            data: {
                grant_id: $(this).val()
            },
            dataType: "json",
            success: function(data) {

                // remove current category option 
                $("#category").html('').append(
                    $("<option>", {
                        value: "",
                        text: "Select Category"
                    })
                )
                for(let option of data.category){
                    $("#category").append(
                        $("<option>", {
                            value: option.id,
                            text: option.name,
                            selected: $("#temp_category_id").val() == option.id ? true : false
                        })
                    )
                }

                if ($("#temp_category_id").val() != "0"){
                    $("#category").trigger('change')
                }

                // get data category report
                $("#category-report").html('').append(
                    $("<option>", {
                        value: "",
                        text: "Select Category"
                    })
                )
                for(let option of data.category_report){
                    $("#category-report").append(
                        $("<option>", {
                            value: option.id,
                            text: option.name,
                            selected: $("#temp_category_report_id").val() == option.id ? true : false
                        })
                    )
                }
            }
        })
	})
    
    $("#property-type").on('change', function(){

        // menampilkan object yang ada optionnya 
        const optionsShow = ['select', 'multiselect', 'radio', 'checkbox']
        if (optionsShow.includes($(this).val())){
            $(".property-options").removeClass("hide");
        }else{
            $(".property-options").addClass("hide");
        }
    })

    $(".add-option").click(function() {
        $(".option-data").append($(".sample-option").html());
    })
    
    // check property type
    if ( $("#property-type").val() != ""){
        $("#property-type").trigger('change')
    }

    // check category type
    if ( $("#category-type").val() != ""){
        $("#category-type").trigger('change')
    }


    if ( $("#grant").val() !== "" ){
        $("#grant").trigger('change')
    }



</script>
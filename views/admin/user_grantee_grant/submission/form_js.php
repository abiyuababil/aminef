<script>
    const SITE_URL = '<?php echo site_url(); ?>';

    $(document).ready(function(){
        <?php if ($this->User_grantee_property_model->available_alumni == 'yes') { ?>
            setTimeout(function(){
                    $("input[name='available_alumni'][value='yes']").trigger('change'); 
                    $("input[name='available_alumni'][value='yes']").prop('checked', true);
            }, 0);
        <?php } else { ?>
            setTimeout(function(){
                $("input[name='available_alumni'][value='no']").trigger('change'); 
                $("input[name='available_alumni'][value='no']").prop('checked', true);
            }, 0);
        <?php } ?>

        <?php if (isset($this->User_grantee_property_model->available_vendor) && $this->User_grantee_property_model->available_vendor == 'yes') { ?>
            setTimeout(function(){
                $("input[name='available_vendor'][value='yes']").trigger('change'); 
                $("input[name='available_vendor'][value='yes']").prop('checked', true);
            }, 0);
        <?php } else { ?>
            setTimeout(function(){
                $("input[name='available_vendor'][value='no']").trigger('change'); 
                $("input[name='available_vendor'][value='no']").prop('checked', true);
            }, 0);
        <?php } ?>

        <?php if (in_array($this->User_grantee_property_model->type, ['element group', 'radio group', 'education group'])) { ?>
            $("#vendor_mapping_group").addClass('hide');
            $("#vendor_field_container").addClass('hide');
        <?php } ?>

        $("#is_limit").trigger('change');
        $("#trigger_notify_ticket").trigger('change');

        
        tinymce.init({
            selector: '.editor',
            plugins: 'link table',
            toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | link',
            contenteditable: true,
            spellchecker: false
        });
    });

    // var allEditors = document.querySelectorAll('.editor');
    // for (var i = 0; i < allEditors.length; ++i) {
    //     ClassicEditor.create(allEditors[i]);
    // }

    function propertyTypeChanged(object, param = '') {
        // menampilkan object yang ada optionnya 
        const optionsShow = ['select', 'multiselect', 'radio', 'checkbox', 'multiple choice grid', 'radio group', 'declare']
        var element = param != '' ? '.element-item' : '.radio-group-element-item';
        
        var subElement = param == '.element-item' ? '.element-item' : '.sub-radio-group-element-item';
        if (param == '.education-group-element-items' || $(object).closest('.sub-education-group-element-item').length) {
            subElement = '.sub-education-group-element-item';
        }
        
        if (optionsShow.includes($(object).val())) {
            $(object).closest(subElement).find('.sub-element-options').removeClass('hide');
        }else{
            $(object).closest(subElement).find(".sub-element-options").addClass('hide');
        }

        if ($(object).val() == 'select'){
            $(object).closest(subElement).find('.sub-element-other').removeClass('hide');
        }else{
            $(object).closest(subElement).find(".sub-element-other").addClass('hide');
        }

        if ($(object).val() == 'file'){
            $(object).closest(subElement).find('.sub-element-note').removeClass('hide');
            $(object).closest(subElement).find('.sub-element-trigger-notify').removeClass('hide');
            $(object).closest(subElement).find('.sub-element-trigger-ticket').removeClass('hide');
            $(object).closest(subElement).find('.sub-element-passport-dependent').removeClass('hide');
            $(object).closest(subElement).find('.sub-element-trigger-alumni').removeClass('hide');
            $(object).closest(subElement).find('.sub-element-validation-selection').removeClass('hide');
        }else{
            $(object).closest(subElement).find(".sub-element-note").addClass('hide');
            $(object).closest(subElement).find('.sub-element-trigger-notify').addClass('hide');
            $(object).closest(subElement).find('.sub-element-trigger-ticket').addClass('hide');
            $(object).closest(subElement).find('.sub-element-passport-dependent').addClass('hide');
            $(object).closest(subElement).find('.sub-element-trigger-alumni').addClass('hide');
            $(object).closest(subElement).find('.sub-element-validation-selection').addClass('hide');
        }

        if ($(object).val() == 'text'){
            $(object).closest(subElement).find('.sub-element-limit').removeClass('hide');
        }else{
            $(object).closest(subElement).find(".sub-element-limit").addClass('hide');
        }

        if ($(object).val() == 'input'){
            $(object).closest(subElement).find('.sub-element-number').removeClass('hide');
            $(object).closest(subElement).find('.sub-element-validation').removeClass('hide');
            $(object).closest(subElement).find('.sub-element-validation-selection').removeClass('hide');
        }else{
            $(object).closest(subElement).find(".sub-element-number").addClass('hide');
            $(object).closest(subElement).find(".sub-element-validation").addClass('hide');
        }

    }

    // untuk tombol add optionnya sub element 
    // $(".form-group").on('click', '.add-sub-element-option', function(){
    function addSubElementOption(object){

        var propertyType = $('#property-type').val();
        var classElement = propertyType === 'element group' || propertyType === 'table schedule' ? '.opdt-item' : (propertyType === 'declare' ? '.opdt-declare-item' : '.opdt-radio-group-item') 

        // get name from previous last element before add element 
        var get_name = $(object).closest('.sub-element-options').find('.sub-element-parent-options '+classElement+':last .option-sub-element').attr('name')
        console.log(get_name, "KEPANGGIL");
        // append and add attribute name
        $(object).closest('.sub-element-options').find('.sub-element-parent-options').append($('.sample-option-sub-element').html());
        $(object).closest('.sub-element-options').find('.sub-element-parent-options .opdt-radio-group-item:last .option-sub-element').attr('name', get_name);
    }
    $(".select2").select2();
    
    $("#is_basic").change(function(){
        if ($(this).is(":checked")){
            $(".property-basic-information").next('.select2-container').show()
            $(".property-from-alumni").next('.select2-container').hide()
            $(".property-basic-information").next('.select2-container').css('display', 'initial')
            $("#basic_field").show()
            $("#property_field").hide()
        }else{
            $(".property-basic-information").next('.select2-container').hide()
            $(".property-from-alumni").next('.select2-container').show()
            $(".property-from-alumni").next('.select2-container').css('display', 'initial')
            $("#property_field").show()
            $("#basic_field").hide()
        }
    })

    // $("#is_basic").trigger('change')

    $("#property-type").on('change', function() {
        if (['element group', 'radio group', 'education group'].includes($(this).val())) {
            $("#vendor_mapping_group").addClass('hide');
            $("#vendor_field_container").addClass('hide');
        } else {
            $("#vendor_mapping_group").removeClass('hide');
            if ($('input:radio[name="available_vendor"]:checked').val() === 'yes') {
                $("#vendor_field_container").removeClass('hide').show();
            }
        }

    // menampilkan object yang ada optionnya 
    // const optionsShow = ['select', 'multiselect', 'radio', 'checkbox', 'multiple choice grid', 'radio group', 'element group', 'file', 'input']
        const optionsShow = ['select', 'multiselect', 'radio', 'checkbox', 'multiple choice grid', 'radio group', 'element group', 'education group', 'file', 'input', 'field of study', 'parent field of study', 'text', 'declare', 'table schedule']
        if (optionsShow.includes($(this).val())) {
            $(".property-option").removeClass("hide");
            $(".add-option").removeClass('hide');
            $(".property-sort_indicator").removeClass('hide');
            $("#have_other").show(); 
            // tambahkan logic seandainya yang dipilih adalah radio group
            if ($(this).val() == 'radio group') {
                $(".property-limit").addClass('hide');
                $(".property-underQuestion").addClass('hide');
                $(".property-multiple").removeClass('hide');
                $(".property-trigger-notify").addClass('hide');
                $(".property-trigger-ticket").addClass('hide');
                $(".property-passport-dependent").addClass('hide');
                $(".property-trigger-alumni").addClass('hide');
                $(".property-column_options").addClass("hide");
                $(".property-options").addClass("hide");
                if ($("input[name='have_other'").is(':checked')) {
                    $("#have_other_option").prop('checked', false);
                }
                $(".property-element-group-options").addClass('hide');
                $(".property-education-group-options").addClass('hide');
                $(".property-radio-group-options").removeClass('hide');
                $("#description_file").css('display', 'none');
                $(".is_number").addClass('hide');
                $(".available_alumni_element").trigger('change');
            } else if ($(this).val() == 'education group') {
                $(".property-limit").addClass('hide');
                $(".property-underQuestion").addClass('hide');
                $(".property-multiple").addClass('hide');
                $(".property-trigger-notify").addClass('hide');
                $(".property-trigger-ticket").addClass('hide');
                $(".property-trigger-alumni").addClass('hide');
                $(".property-column_options").addClass("hide");
                $(".property-options").addClass("hide");
                if ($("input[name='have_other'").is(':checked')) {
                    $("#have_other_option").prop('checked', false);
                }
                $(".property-element-group-options").addClass('hide');
                $(".property-radio-group-options").addClass('hide');
                $(".property-declare-options").addClass('hide');
                $(".property-education-group-options").removeClass('hide');
                $("#description_file").css('display', 'none');
                $(".is_number").addClass('hide');
                $(".available_alumni_element").trigger('change');
            } else if ($(this).val() == 'declare') {
                $(".property-limit").addClass('hide');
                $(".property-underQuestion").addClass('hide');
                $(".property-multiple").removeClass('hide');
                $(".property-trigger-notify").addClass('hide');
                $(".property-trigger-ticket").addClass('hide');
                $(".property-passport-dependent").addClass('hide');
                $(".property-trigger-alumni").addClass('hide');
                $(".property-column_options").addClass("hide");
                $(".property-options").addClass("hide");
                if ($("input[name='have_other'").is(':checked')) {
                    $("#have_other_option").prop('checked', false);
                }
                $(".property-element-group-options").addClass('hide');
                $(".property-education-group-options").addClass('hide');
                $(".property-radio-group-options").addClass('hide');
                $(".property-declare-options").removeClass('hide');
                $("#description_file").css('display', 'none');
                $(".is_number").addClass('hide');
            } else if ($(this).val() == 'element group') {
                $(".property-limit").addClass('hide');
                $(".property-underQuestion").addClass('hide');
                $(".property-multiple").removeClass('hide');
                $(".property-trigger-notify").addClass('hide');
                $(".property-trigger-ticket").addClass('hide');
                $(".property-passport-dependent").addClass('hide');
                $(".property-trigger-alumni").addClass('hide');
                $(".property-column_options").addClass("hide");
                $(".property-options").addClass("hide");
                if ($("input[name='have_other'").is(':checked')) {
                    $("#have_other_option").prop('checked', false);
                }
                $(".property-radio-group-options").addClass('hide');
                $(".property-declare-options").addClass('hide');
                $(".property-education-group-options").addClass('hide');
                $(".property-element-group-options").removeClass('hide');
                $("#description_file").css('display', 'none');
                $(".is_number").addClass('hide');
                $(".available_alumni_element").trigger('change');
            } else if ($(this).val() == 'file'){
                $(".property-limit").addClass('hide');
                $(".property-underQuestion").addClass('hide');
                $(".property-multiple").removeClass('hide');
                $(".property-trigger-notify").removeClass('hide');
                $(".property-trigger-ticket").removeClass('hide');
                $(".property-passport-dependent").removeClass('hide');
                $(".property-trigger-alumni").removeClass('hide');
                $(".row-file").removeClass('hide');
                $("#description_file").css('display', 'block');
                $(".property-column_options").addClass("hide");
                $(".property-options").addClass("hide");
                if ($("input[name='have_other'").is(':checked')) {
                    $("#have_other_option").prop('checked', false);
                }
                $(".property-radio-group-options").addClass("hide");
                $(".property-declare-options").addClass("hide");
                $(".property-element-group-options").addClass("hide");
                $(".property-education-group-options").addClass("hide");
                $(".is_number").addClass('hide');
            }else if($(this).val() == 'input') {
                $(".property-limit").addClass('hide');
                $(".property-underQuestion").addClass('hide');
                $(".is_number").removeClass('hide');
                $(".property-options").addClass("hide");
                $(".property-trigger-notify").addClass('hide');
                $(".property-trigger-ticket").addClass('hide');
                $(".property-passport-dependent").addClass('hide');
                $(".property-trigger-alumni").addClass('hide');
                $(".row-file").removeClass('hide');
                if ($("input[name='have_other'").is(':checked')) {
                    $("#have_other_option").prop('checked', false);
                }
            } else if ($(this).val() == 'field of study') {
                $(".property-option").addClass("hide");
                $(".is_number").addClass('hide');
                $(".property-limit").addClass('hide');
                $(".property-underQuestion").addClass('hide');
                $(".property-multiple").addClass('hide');
                $(".property-trigger-notify").addClass('hide');
                $(".property-trigger-ticket").addClass('hide');
                $(".property-passport-dependent").addClass('hide');
                $(".property-trigger-alumni").addClass('hide');
                $(".row-file").removeClass('hide');
                $(".property-radio-group-options").addClass("hide");
                $(".property-declare-options").addClass("hide");
                $(".property-element-group-options").addClass("hide");
                $(".property-options").removeClass("hide");
                $(".add-option").addClass('hide');
            } else if ($(this).val() == 'parent field of study') {
                $(".property-option").addClass("hide");
                $(".is_number").addClass('hide');
                $(".property-limit").addClass('hide');
                $(".property-underQuestion").addClass('hide');
                $(".property-multiple").addClass('hide');
                $(".property-trigger-notify").addClass('hide');
                $(".property-trigger-ticket").addClass('hide');
                $(".property-passport-dependent").addClass('hide');
                $(".property-trigger-alumni").addClass('hide');
                $(".row-file").removeClass('hide');
                $(".property-radio-group-options").addClass("hide");
                $(".property-declare-options").addClass("hide");
                $(".property-element-group-options").addClass("hide");
                $(".property-options").removeClass("hide");
                $(".add-option").addClass('hide');
            }else if($(this).val() == 'text') {
                $(".property-limit").removeClass('hide');
                $(".property-underQuestion").removeClass('hide');
                $(".is_number").addClass('hide');
                $(".property-multiple").addClass('hide');
                $(".property-trigger-notify").addClass('hide');
                $(".property-trigger-ticket").addClass('hide');
                $(".property-passport-dependent").addClass('hide');
                $(".property-trigger-alumni").addClass('hide');
                $(".row-file").removeClass('hide');
                $(".property-column_options").addClass("hide");
                $(".property-options").addClass("hide");
                if ($("input[name='have_other'").is(':checked')) {
                    $("#have_other_option").prop('checked', false);
                }
                $(".property-radio-group-options").addClass("hide");
                $(".property-declare-options").addClass("hide");
                $(".property-element-group-options").addClass("hide");
                $(".property-education-group-options").addClass("hide");
                $("#description_file").css('display', 'none');
            } else if ($(this).val() == 'table schedule') {
                $(".property-limit").addClass('hide');
                $(".property-underQuestion").addClass('hide');
                $(".property-multiple").removeClass('hide');
                $(".property-trigger-notify").addClass('hide');
                $(".property-trigger-ticket").addClass('hide');
                $(".property-passport-dependent").addClass('hide');
                $(".property-trigger-alumni").addClass('hide');
                $(".property-column_options").addClass("hide");
                $(".property-options").addClass("hide");
                if ($("input[name='have_other'").is(':checked')) {
                    $("#have_other_option").prop('checked', false);
                }
                $(".property-radio-group-options").addClass('hide');
                $(".property-declare-options").addClass('hide');
                $(".property-education-group-options").addClass('hide');
                $(".property-element-group-options").removeClass('hide');
                $("#description_file").css('display', 'none');
                $(".is_number").addClass('hide');
            }else{
                $(".is_number").addClass('hide');
                $(".property-limit").addClass('hide');
                $(".property-underQuestion").addClass('hide');
                $(".property-multiple").addClass('hide');
                $(".property-trigger-notify").addClass('hide');
                $(".property-trigger-ticket").addClass('hide');
                $(".property-passport-dependent").addClass('hide');
                $(".property-trigger-alumni").addClass('hide');
                $(".row-file").removeClass('hide');
                $(".property-radio-group-options").addClass("hide");
                $(".property-declare-options").addClass("hide");
                $(".property-element-group-options").addClass("hide");
                $(".property-education-group-options").addClass("hide");
                $(".property-options").removeClass("hide");
                $("#description_file").css('display', 'none');
                // tambahan logic seandainya yang dipilih adalah multiple choice grid
                if ($(this).val() == 'multiselect') {
                    $("#have_other").hide(); 
                }
                if ($(this).val() == 'multiple choice grid'){
                        $(".property-column_options").removeClass("hide");
                        // $(".property-options").addClass("hide");
                        $("#have_other").hide(); 
                        if ($("input[name='have_other'").is(':checked')) {
                            $("#have_other_option").prop('checked', false);
                        }
                    }else{
                        $(".property-column_options").addClass("hide");
                    }
                }
        } else {
            $(".property-limit").addClass('hide');
            $(".property-limit").removeClass('hide');
            $(".property-multiple").addClass('hide');
            $(".property-trigger-notify").addClass('hide');
            $(".property-trigger-ticket").addClass('hide');
            $(".property-passport-dependent").addClass('hide');
            $(".property-trigger-alumni").addClass('hide');
            $(".row-file").removeClass('hide');
            $(".property-column_options").addClass("hide");
            $(".property-options").addClass("hide");
            if ($("input[name='have_other'").is(':checked')) {
                $("#have_other_option").prop('checked', false);
            }
            $(".property-radio-group-options").addClass("hide");
            $(".property-declare-options").addClass("hide");
            $(".property-element-group-options").addClass("hide");
            $(".property-education-group-options").addClass("hide");
            $("#description_file").css('display', 'none');
        }

        if ($(this).val() == 'file') {
            $(".guide_file").removeClass('hide');
        } else {
            $("#filename").text('');
            $(".guide_file").addClass('hide');
            $("#preview-file").addClass('hide');
            $("#remove-file").addClass('hide');
            $(".custom-file-input").val('');
            $("input[name='file'").val('');
        }

        if ($(this).val() == 'date') {
            $(".property-sort_indicator").removeClass('hide');
        } else {
            $(".property-sort_indicator").addClass('hide');
        }

        if ($(this).val() == 'checkbox' || $(this).val() == 'separator') {
            $("#advanced-checkbox").removeClass('hide');
        } else {
            $("#advanced-checkbox").addClass('hide');
        }
        
    });


    $(".add-option").click(function() {
        var max_id = $('.parents-option > div').length;
        $(".parents-option").append($(".sample-option").html());
        $('.parents-option > div:last-child').attr('id', 'opdt-item-' + (max_id+1));
    })

    $(".add-column_option").click(function() {
        var max_id = $('.parents-column_option > div').length;
        $(".parents-column_option").append($(".sample-column_option").html());
        $('.parents-column_option > div:last-child').attr('id', 'opdt-item-' + (max_id+1));
    })


    $(".add-radio-group-option").click(function() {
        // start length dari 0 
        var max_id = $('.parents-radio-group-option .opdt-radio-group-item').length;
        $(".parents-radio-group-option").append($(".sample-radio-group-option").html());
        $('.parents-radio-group-option .opdt-radio-group-item:last').attr('id', 'opdt-radio-group-item-' + (max_id+1));
        $('.parents-radio-group-option .radio-group-element-item:last').attr('id', 'element-item-' + (max_id+1));
        $('.parents-radio-group-option .add-element-radio-group:last').attr({
            'data-which-element':'element-item-' + (max_id+1),
            'data-which-option': 'opdt-radio-group-item-' + (max_id+1)
        });

        // update name options
        $('#opdt-radio-group-item-' + (max_id+1) + ' input').attr({
            'name' : 'radio_group_options['+max_id+'][element]',
            'data-index': max_id
        });
    })

    // tambahkan declare option e.g Yes / No
    $(".add-declare-option").click(function() {
        // start length dari 0 
        var max_id = $('.parents-declare-option .opdt-declare-item').length;
        $(".parents-declare-option").append($(".sample-declare-option").html());
        $('.parents-declare-option .opdt-declare-item:last').attr('id', 'opdt-declare-item-' + (max_id+1));
        $('.parents-declare-option .declare-element-item:last').attr('id', 'declare-element-item-' + (max_id+1));
        $('.parents-declare-option .add-element-declare:last').attr({
            'data-which-element':'declare-element-item-' + (max_id+1),
            'data-which-option': 'opdt-declare-item-' + (max_id+1)
        });

        // update name options
        $('#opdt-declare-item-' + (max_id+1) + ' input').attr({
            'name' : 'declare_options['+max_id+'][element]',
            'data-index': max_id
        });
    })

    $(".add-element-group").click(function () {
        // get latest data index 
        var data_index = $(".parents-element-group-options .element-item:last").data("index");
        if (typeof data_index === 'undefined' || isNaN(data_index)) {
            data_index = 0;
        }
        $(".parents-element-group-options").append($(".sample-element-group-element").html());

        $(".parents-element-group-options .element-item:last").attr("data-index", data_index + 1);
        $(".parents-element-group-options .element-item:last").attr("id", "field-element-" + (data_index + 1));
        $(".parents-element-group-options .element-item:last .element-title").text("Element " + (data_index + 1));
        $(".parents-element-group-options .element-item:last .remove-fieldset").attr("data-fieldset", "field-element-" + (data_index + 1));

        // set name on each object 
        $(".parents-element-group-options .element-item:last .property-name").attr("name", "element_group_options["+(data_index + 1)+"][property_name]")
        $(".parents-element-group-options .element-item:last .property-type").attr("name", "element_group_options["+(data_index + 1)+"][property_type]")
        $(".parents-element-group-options .element-item:last .required").attr("name", "element_group_options["+(data_index + 1)+"][required]")
        $(".parents-element-group-options .element-item:last .option-sub-element").attr("name", "element_group_options["+(data_index + 1)+"][options][]")
        $(".parents-element-group-options .element-item:last .is_number_element").attr("name", "element_group_options["+(data_index + 1)+"][is_number]")
        $(".parents-element-group-options .element-item:last .is_limit_element").attr("name", "element_group_options["+(data_index + 1)+"][is_limit]")
        $(".parents-element-group-options .element-item:last .trigger_notify_ticket_element").attr("name", "element_group_options["+(data_index + 1)+"][trigger_notify_ticket]")
        $(".parents-element-group-options .element-item:last .passport_dependent_element").attr("name", "element_group_options["+(data_index + 1)+"][passport_dependent]")
        $(".parents-element-group-options .element-item:last .is_score_test_element").attr("name", "element_group_options["+(data_index + 1)+"][is_score_test]")
        $(".parents-element-group-options .element-item:last .note").attr("name", "element_group_options["+(data_index + 1)+"][note]").addClass('editor')
        $(".parents-element-group-options .element-item:last .is_validation_selection").attr("name", "element_group_options["+(data_index + 1)+"][validation_for_selection]")
        $(".parents-element-group-options .element-item:last .is_limit_element").attr("onchange", "showLimitChar(this, "+(data_index + 1)+")")
        $(".parents-element-group-options .element-item:last .trigger_notify_ticket_element").attr("onchange", "showCategoryEta(this, "+(data_index + 1)+")")
        $(".parents-element-group-options .element-item:last .passport_dependent_element").attr("onchange", "showCategoryEta(this, "+(data_index + 1)+")")
        $(".parents-element-group-options .element-item:last .is_limit_char").addClass("sub-element-limit-char-"+(data_index + 1))
        $(".parents-element-group-options .element-item:last .limit_char").attr("name", "element_group_options["+(data_index + 1)+"][limit_char]")
        $(".parents-element-group-options .element-item:last .min_limit_char").attr("name", "element_group_options["+(data_index + 1)+"][min_limit_char]")
        $(".parents-element-group-options .element-item:last .type_limit_char").attr("name", "element_group_options["+(data_index + 1)+"][type_limit_char]")
        $(".parents-element-group-options .element-item:last .other").attr("name", "element_group_options["+(data_index + 1)+"][have_other]")
        $(".parents-element-group-options .element-item:last .available_alumni_element").attr("name", "element_group_options["+(data_index + 1)+"][available_alumni]").trigger('change'); 
        $(".parents-element-group-options .element-item:last .is_basic_element").attr("name", "element_group_options["+(data_index + 1)+"][is_basic]")
        $(".parents-element-group-options .element-item:last .basic-fields-element").attr("name", "element_group_options["+(data_index + 1)+"][basic_fields]")
        $(".parents-element-group-options .element-item:last .user-property-id-element").attr("name", "element_group_options["+(data_index + 1)+"][user_property_id]")
        $(".parents-element-group-options .element-item:last .available_vendor_element").attr("name", "element_group_options["+(data_index + 1)+"][available_vendor]").trigger('change'); 
        $(".parents-element-group-options .element-item:last .vendor-field-element").attr("name", "element_group_options["+(data_index + 1)+"][vendor_field]")

        $(".parents-element-group-options .element-item:last .label-check").attr("for", "group_element_available_validation_"+(data_index + 1))
        $(".parents-element-group-options .element-item:last .group_element_available_validation_element").attr("id", "group_element_available_validation_"+(data_index + 1))
        $(".parents-element-group-options .element-item:last .group_element_available_validation_element").attr("name", "element_group_options["+(data_index + 1)+"][group_element_available_validation]")
        $(".parents-element-group-options .element-item:last .property-from-validation").attr("name", "element_group_options["+(data_index + 1)+"][group_element_validation_for]")
        tinymce.init({
            selector: '.editor',
            plugins: 'link',
            toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | link',
            contenteditable: true,
            spellchecker: false
        });

    })

    // tambahkan radio group element option
    $(".parents-radio-group-option").on('click','.add-element-radio-group', function() {
        var which_element = $(this).data('which-element');
        var which_option = $(this).data('which-option');
        var index_option = $("#" + which_option + " input").data("index");
        if (typeof(index_option) == 'undefined'){
            index_option = 0;
        }
        var max_id = $('#'+which_element+' > fieldset').length;
        var num = max_id + 1;
        var fieldsetId = "fieldset-" + index_option + "-" + num;

        $("#"+which_element).append($(".sample-radio-group-element").html());
        $("#"+which_element + " > fieldset:last-child").attr({
            id : fieldsetId,
            "data-index": num
        });
        $("#"+which_element + " > fieldset:last-child .sub-element-title").text("Element " + num);
        $("#"+which_element + " > fieldset:last-child .remove-fieldset").attr("data-fieldset", fieldsetId);

        // update name based on options
        $("#"+which_element + " > fieldset:last-child .property-name").attr("name", 'element_radio_group_options[' + index_option + ']['+max_id+'][property_name]');
        $("#"+which_element + " > fieldset:last-child .property-type").attr("name", 'element_radio_group_options[' + index_option + ']['+max_id+'][property_type]');
        $("#"+which_element + " > fieldset:last-child .required").attr("name", 'element_radio_group_options[' + index_option + ']['+max_id+'][required]');
        $("#"+which_element + " > fieldset:last-child .is_number_element").attr("name", 'element_radio_group_options[' + index_option + ']['+max_id+'][is_number]');
        $("#"+which_element + " > fieldset:last-child .is_limit_element").attr("name", 'element_radio_group_options[' + index_option + ']['+max_id+'][is_limit]');
        $("#"+which_element + " > fieldset:last-child .trigger_notify_ticket_element").attr("name", 'element_radio_group_options[' + index_option + ']['+max_id+'][trigger_notify_ticket]');
        $("#"+which_element + " > fieldset:last-child .passport_dependent_element").attr("name", 'element_radio_group_options[' + index_option + ']['+max_id+'][passport_dependent]');
        $("#"+which_element + " > fieldset:last-child .is_score_test_element").attr("name", 'element_radio_group_options[' + index_option + ']['+max_id+'][is_score_test]');
        $("#"+which_element + " > fieldset:last-child .note").attr("name", 'element_radio_group_options[' + index_option + ']['+max_id+'][note]').addClass('editor');
        $("#"+which_element + " > fieldset:last-child .option-sub-element").attr("name", 'element_radio_group_options[' + index_option + ']['+max_id+'][options][]');
        $("#"+which_element + " > fieldset:last-child .other").attr("name", 'element_radio_group_options[' + index_option + ']['+max_id+'][have_other]');
        $("#"+which_element + " > fieldset:last-child .available_alumni_element").attr("name", 'element_radio_group_options[' + index_option + ']['+max_id+'][available_alumni]');
        $("#"+which_element + " > fieldset:last-child .is_basic_element").attr("name", 'element_radio_group_options[' + index_option + ']['+max_id+'][is_basic]');
        $("#"+which_element + " > fieldset:last-child .basic-fields-element").attr("name", 'element_radio_group_options[' + index_option + ']['+max_id+'][basic_fields]');
        $("#"+which_element + " > fieldset:last-child .user-property-id-element").attr("name", 'element_radio_group_options[' + index_option + ']['+max_id+'][user_property_id]');
        $("#"+which_element + " > fieldset:last-child .available_vendor_element").attr("name", 'element_radio_group_options[' + index_option + ']['+max_id+'][available_vendor]');
        $("#"+which_element + " > fieldset:last-child .vendor-field-element").attr("name", 'element_radio_group_options[' + index_option + ']['+max_id+'][vendor_field]');
        tinymce.init({
            selector: '.editor',
            plugins: 'link',
            toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | link',
            contenteditable: true,
            spellchecker: false
        });

    })

    $(".parents-declare-option").on('click','.add-element-declare', function() {
        var which_element = $(this).data('which-element');
        var which_option = $(this).data('which-option');
        var index_option = $("#" + which_option + " input").data("index");
        if (typeof(index_option) == 'undefined'){
            index_option = 0;
        }
        var max_id = $('#'+which_element+' > fieldset').length;
        var num = max_id + 1;
        var fieldsetId = "fieldset-declare-" + index_option + "-" + num;
        var button_delete = "<a href='#' style='margin-left: 10px;' class='btn btn-danger btn-xs remove-fieldset' data-fieldset='" + fieldsetId + "'><i class='fa fa-trash'></i></a>";
        $("#"+which_element).append($(".sample-declare-element").html());
        $("#"+which_element + " > fieldset:last-child").attr({
            id : fieldsetId,
            "data-index": num
        });
        $("#"+which_element + " > fieldset:last-child legend").html("Element " + num + button_delete);

        $("#"+which_element + " > fieldset:last-child .property-name").attr("name", 'element_declare_options[' + index_option + ']['+max_id+'][property_name]');
        $("#"+which_element + " > fieldset:last-child .property-type").attr("name", 'element_declare_options[' + index_option + ']['+max_id+'][property_type]');
        $("#"+which_element + " > fieldset:last-child .required").attr("name", 'element_declare_options[' + index_option + ']['+max_id+'][required]');
        $("#"+which_element + " > fieldset:last-child .is_number_element").attr("name", 'element_declare_options[' + index_option + ']['+max_id+'][is_number]');
        $("#"+which_element + " > fieldset:last-child .is_limit_element").attr("name", 'element_declare_options[' + index_option + ']['+max_id+'][is_limit]');
        $("#"+which_element + " > fieldset:last-child .trigger_notify_ticket_element").attr("name", 'element_declare_options[' + index_option + ']['+max_id+'][trigger_notify_ticket]');
        $("#"+which_element + " > fieldset:last-child .passport_dependent_element").attr("name", 'element_declare_options[' + index_option + ']['+max_id+'][passport_dependent]');
        $("#"+which_element + " > fieldset:last-child .is_score_test_element").attr("name", 'element_declare_options[' + index_option + ']['+max_id+'][is_score_test]');
        $("#"+which_element + " > fieldset:last-child .note").attr("name", 'element_declare_options[' + index_option + ']['+max_id+'][note]').addClass('editor');
        $("#"+which_element + " > fieldset:last-child .option-sub-element").attr("name", 'element_declare_options[' + index_option + ']['+max_id+'][options][]');
        $("#"+which_element + " > fieldset:last-child .other").attr("name", 'element_declare_options[' + index_option + ']['+max_id+'][have_other]');
        tinymce.init({
            selector: '.editor',
            plugins: 'link',
            toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | link',
            contenteditable: true,
            spellchecker: false
        });

    })

    $(".parents-radio-group-option, .parents-element-group-options, .parents-declare-option").on('click', '.remove-fieldset', function(){
        if (confirm("Are you sure want to delete this ?")){
            var option_id = $(this).data('id');
            var fieldDelete = $("#delete_element_group_options");
            if (option_id && fieldDelete.length) {
                var oldValue = fieldDelete.val();
                if (oldValue != '') {
                    fieldDelete.val(oldValue + ", " + option_id);
                } else {
                    fieldDelete.val(option_id);
                }
            }

            var container = $(this).closest('.radio-group-element-item');
            var declare_container = $(this).closest('.declare-element-item');
            var is_element_group = $(this).closest('.parents-element-group-options').length > 0;

            // Target the exact element directly from the clicked button rather than relying solely on global ID
            var target = $(this).closest('.element-item, .sub-radio-group-element-item, .sub-declare-element-item, fieldset');
            if (target.length) {
                target.remove();
            } else {
                var get_data = $(this).data('fieldset');
                if (get_data) {
                    $("#" + get_data).remove();
                }
            }

            if (is_element_group) {
                reindex_element_group();
            } else if (container.length) {
                reindex_sub_elements(container);
            } else if (declare_container.length && typeof reindex_declare_elements === 'function') {
                reindex_declare_elements(declare_container);
            }
        }
    })

    // check property type
    if ( $("#property-type").val() != ""){
        $("#property-type").trigger('change')
    }
    if ( $(".property-type").val() != ""){
        $(".property-type").trigger('change')
    }

    function del_option(el, item_class) {
        if (confirm("Are you sure want to delete this ?")) {
            var item = $(el).closest('.' + item_class);
            // Main radio option: inside .parents-radio-group-option but NOT inside sub-element dropdowns
            var is_main_radio_option = item.hasClass('opdt-radio-group-item') &&
                item.closest('.parents-radio-group-option').length > 0 &&
                item.closest('.sub-element-options, .sub-element-parent-options').length === 0;
            if (is_main_radio_option) {
                // Collect any element IDs inside this radio group option to mark them deleted
                item.find('.remove-fieldset[data-id], input[name*="[property_id]"]').each(function() {
                    var elId = $(this).data('id') || $(this).val();
                    if (elId) {
                        var fieldDelete = $("#delete_element_group_options");
                        if (fieldDelete.length) {
                            var oldValue = fieldDelete.val();
                            if (oldValue != '') {
                                fieldDelete.val(oldValue + ", " + elId);
                            } else {
                                fieldDelete.val(elId);
                            }
                        }
                    }
                });
            }
            // For main radio options, remove the card-element-option wrapper; otherwise remove item directly
            if (is_main_radio_option) {
                item.closest('.card-element-option').remove();
            } else {
                item.remove();
            }
            if (is_main_radio_option) {
                reindex_radio_group_options();
            }
        }
    }

    function move_option_up(btn, item_class) {
        item_class = item_class || 'opdt-item';
        var item = $(btn).closest('.' + item_class);
        var prev = item.prevAll('.' + item_class).first();
        if (prev.length) {
            item.insertBefore(prev);
        }
    }

    function move_option_down(btn, item_class) {
        item_class = item_class || 'opdt-item';
        var item = $(btn).closest('.' + item_class);
        var next = item.nextAll('.' + item_class).first();
        if (next.length) {
            item.insertAfter(next);
        }
    }

    function with_tinymce_save(callback) {
        if (typeof tinymce !== 'undefined') {
            try {
                tinymce.triggerSave();
                tinymce.remove();
            } catch(e) {}
            callback();
            try {
                tinymce.init({
                    selector: '.editor',
                    plugins: 'link table',
                    toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | link',
                    contenteditable: true,
                    spellchecker: false
                });
            } catch(e) {}
        } else {
            callback();
        }
    }

    function move_radio_group_option_up(btn) {
        var item = $(btn).closest('.card-element-option');
        var prev = item.prevAll('.card-element-option').first();
        if (prev.length) {
            with_tinymce_save(function() {
                item.insertBefore(prev);
                reindex_radio_group_options();
            });
        }
    }

    function move_radio_group_option_down(btn) {
        var item = $(btn).closest('.card-element-option');
        var next = item.nextAll('.card-element-option').first();
        if (next.length) {
            with_tinymce_save(function() {
                item.insertAfter(next);
                reindex_radio_group_options();
            });
        }
    }

    function reindex_radio_group_options() {
        $('.parents-radio-group-option .card-element-option .opdt-radio-group-item').each(function(i) {
            var optIndex = i;
            $(this).children('.col-lg-12:first').attr('id', 'opdt-radio-group-item-' + optIndex);
            $(this).find('input[name^="radio_group_options"][name*="[element]"]').attr({
                'name': 'radio_group_options[' + optIndex + '][element]',
                'data-index': optIndex
            });
            $(this).find('.radio-group-element-item').attr('id', 'element-item-' + optIndex);
            $(this).find('.add-element-radio-group').attr({
                'data-which-option': 'opdt-radio-group-item-' + optIndex,
                'data-which-element': 'element-item-' + optIndex
            });
            $(this).find('.radio-group-element-item [name^="element_radio_group_options"]').each(function() {
                var currentName = $(this).attr('name');
                var newName = currentName.replace(/^element_radio_group_options\[\d+\]/, 'element_radio_group_options[' + optIndex + ']');
                $(this).attr('name', newName);
            });
            reindex_sub_elements($(this).find('.radio-group-element-item'));
        });
    }

    function move_sub_element_up(btn) {
        var fieldset = $(btn).closest('.sub-radio-group-element-item');
        var prev = fieldset.prevAll('.sub-radio-group-element-item').first();
        if (prev.length) {
            var container = fieldset.closest('.radio-group-element-item');
            with_tinymce_save(function() {
                fieldset.insertBefore(prev);
                reindex_sub_elements(container);
            });
        }
    }

    function move_sub_element_down(btn) {
        var fieldset = $(btn).closest('.sub-radio-group-element-item');
        var next = fieldset.nextAll('.sub-radio-group-element-item').first();
        if (next.length) {
            var container = fieldset.closest('.radio-group-element-item');
            with_tinymce_save(function() {
                fieldset.insertAfter(next);
                reindex_sub_elements(container);
            });
        }
    }

    function reindex_sub_elements(container) {
        var optIndex = $(container).closest('.opdt-radio-group-item').find('input[name^="radio_group_options"][name*="[element]"]').attr('data-index');
        if (typeof optIndex === 'undefined') optIndex = 0;
        $(container).find('.sub-radio-group-element-item').each(function(j) {
            var subIndex = j;
            var num = j + 1;
            var fieldsetId = 'fieldset-' + optIndex + '-' + num;
            $(this).attr('id', fieldsetId).attr('data-index', num);
            $(this).find('.sub-element-title').text('Element ' + num);
            $(this).find('.remove-fieldset').attr('data-fieldset', fieldsetId);
            $(this).find('[name^="element_radio_group_options"]').each(function() {
                var currentName = $(this).attr('name');
                var newName = currentName.replace(/^element_radio_group_options\[\d+\]\[\d+\]/, 'element_radio_group_options[' + optIndex + '][' + subIndex + ']');
                $(this).attr('name', newName);
            });
        });
    }

    function reindex_declare_elements(container) {
        // container is .declare-element-item; its parent row is .opdt-declare-item
        var optIndex = $(container).closest('.opdt-declare-item').find('input[name^="declare_options"][name*="[element]"]').attr('data-index');
        if (typeof optIndex === 'undefined') optIndex = 0;
        $(container).find('.sub-declare-element-item').each(function(j) {
            var subIndex = j;
            var num = j + 1;
            var fieldsetId = 'fieldset-declare-' + optIndex + '-' + num;
            $(this).attr('id', fieldsetId).attr('data-index', num);
            $(this).find('legend').contents().filter(function() {
                return this.nodeType === 3;
            }).first().replaceWith('Element ' + num + ' ');
            $(this).find('.remove-fieldset').attr('data-fieldset', fieldsetId);
            $(this).find('[name^="element_declare_options"]').each(function() {
                var currentName = $(this).attr('name');
                var newName = currentName.replace(/^element_declare_options\[\d+\]\[\d+\]/, 'element_declare_options[' + optIndex + '][' + subIndex + ']');
                $(this).attr('name', newName);
            });
        });
    }

    function move_element_group_up(btn) {
        var item = $(btn).closest('.element-item');
        var prev = item.prevAll('.element-item').first();
        if (prev.length) {
            with_tinymce_save(function() {
                item.insertBefore(prev);
                reindex_element_group();
            });
        }
    }

    function move_element_group_down(btn) {
        var item = $(btn).closest('.element-item');
        var next = item.nextAll('.element-item').first();
        if (next.length) {
            with_tinymce_save(function() {
                item.insertAfter(next);
                reindex_element_group();
            });
        }
    }

    function reindex_element_group() {
        $('.parents-element-group-options .element-item').each(function(k) {
            var index = k;
            var num = k + 1;
            $(this).attr('data-index', num);
            $(this).attr('id', 'field-element-' + index);
            $(this).find('.element-title').text('Element ' + num);
            $(this).find('.remove-fieldset').attr('data-fieldset', 'field-element-' + index);
            $(this).find('[name^="element_group_options"]').each(function() {
                var currentName = $(this).attr('name');
                var newName = currentName.replace(/^element_group_options\[\d+\]/, 'element_group_options[' + index + ']');
                $(this).attr('name', newName);
            });
            $(this).find('.label-check').attr('for', 'group_element_available_validation_' + index);
            $(this).find('.group_element_available_validation_element').attr('id', 'group_element_available_validation_' + index);
        });
    }

    $('input:radio[name="available_alumni"]').change(
    function(){
        if ($(this).is(':checked') && $(this).val() == 'yes') {
            $("#is_basic_field").css('display', 'block'); 
            $("#basic_field").css('display', 'block'); 
            $(".select2").select2();
            $("#is_basic").trigger('change')
        }else{
            $("#is_basic_field").css('display', 'none');
            $("#basic_field").css('display', 'none');
            $("#property_field").css('display', 'none');
        }
    });

    $('input:radio[name="available_validation"]').change(
    function(){
        if ($(this).is(':checked') && $(this).val() == 'yes') {
            $("#validation_for").css('display', 'block');
        }else{
            $("#validation_for").css('display', 'none');
        }
    });

    $('input:radio[name="available_vendor"]').change(
    function(){
        if ($(this).is(':checked') && $(this).val() == 'yes') {
            $("#vendor_field_container").css('display', 'block');
        }else{
            $("#vendor_field_container").css('display', 'none');
        }
    });

    function show_preview(element, type, upload_type) {
        const file = element.files[0];
        const filetype = file.name.split('.').pop();
        const allowed_extensions = ['jpg', 'jpeg', 'png', 'pdf', 'docx'];

        const is_valid_extension = allowed_extensions.some(function(extension) {
            return filetype.toLowerCase().endsWith(extension);
        });

        if (is_valid_extension > 0) {
            let formData = new FormData();
            formData.append(upload_type, file);
            formData.append('type', upload_type);
            $("#filename").addClass('hide').text('');
            $("#preview-file").addClass('hide');
            $("#remove-file").addClass('hide');
            $("#preview-file").attr('href', SITE_URL);
            $.ajax({
                url: SITE_URL + 'admin/user_grantee_grant/save_file', 
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType : 'JSON',
                success: function(response) {
                    if (response.status) {
                        $("#filename").removeClass('hide').text(response.filename);
                        $("#preview-file").removeClass('hide');
                        $("#remove-file").removeClass('hide');
                        $("#filename").attr('href', SITE_URL + response.filepath);
                        $("#preview-file").attr('href', SITE_URL + response.filepath);
                        $("input[name='file']").val(response.filepath);
                    } else {
                        $("#filename").addClass('hide').text('');
                        $("#preview-file").addClass('hide');
                        $("#remove-file").addClass('hide');
                        $("#filename").attr('href', SITE_URL);
                        $("#preview-file").attr('href', SITE_URL);
                        $("input[name='file']").val('');
                        alert('Failed to upload your file, please try again');
                    }
                    
                },
                error: function(xhr, status, error) {
                    console.error(error); 
                }
            });
        } else {
        }
    }

    function del_file() {
        if (confirm("Are you sure want to delete file?")) {
            $("#filename").addClass('hide').text('');
            $("#preview-file").addClass('hide');
            $("#remove-file").addClass('hide');
            $("#filename").attr('href', SITE_URL);
            $("#preview-file").attr('href', SITE_URL);
            $("input[name='file']").val('');

            return false;
        } 
    }

    $("#is_limit").change(function() {
        if(this.checked) {
            $('#limit_char').removeClass('hide')
            $('#min_limit_char').removeClass('hide')
            $('#type_limit_char').removeClass('hide')
            $('.label-limit').removeClass('hide')
        }else{
            $('#limit_char').addClass('hide')
            $('#min_limit_char').addClass('hide')
            $('#type_limit_char').addClass('hide')
            $('.label-limit').addClass('hide')
        }
    });

    $("#trigger_notify_ticket").change(function() {
        if(this.checked) {
            $('.eta-category').removeClass('hide')
        }else{
            $('.eta-category').addClass('hide')
        }
    });

    $("#is_advanced_checkbox").on('change', function(){
        show_advanced_checkbox_option();
    }); 

    $(document).on('change', '.group_element_available_validation_element', function(){
        let is_checked = $(this).is(':checked');
        if (is_checked) {
            $(this).closest('.element-group-validation-item').find('.element-group-validation-field').removeClass('hide');
        } else {
            $(this).closest('.element-group-validation-item').find('.element-group-validation-field').addClass('hide');
        }
    });

    show_advanced_checkbox_option();

    function show_advanced_checkbox_option()
    {
        let is_advanced_checkbox = $("#is_advanced_checkbox");

        if (is_advanced_checkbox.is(':checked')) {
            $(".advanced-checkbox").removeClass('hide');
        } else {
            $(".advanced-checkbox").addClass('hide');
        }

    }

    function showLimitChar(element, index) {
        if(element.checked) {
            $('.sub-element-limit-char-'+index).removeClass('hide')
        }else{
            $('.sub-element-limit-char-'+index).addClass('hide')
        }
    }

    function showLimitCharInFieldset(element) {
        var $box = $(element).closest('fieldset').find('.is_limit_char');
        if (element.checked) {
            $box.removeClass('hide');
        } else {
            $box.addClass('hide');
        }
    }

    function showCategoryEtaInFieldset(element) {
        var $box = $(element).closest('fieldset').find('.sub-element-eta-category');
        if (element.checked) {
            $box.removeClass('hide');
        } else {
            $box.addClass('hide');
        }
    }

    function showCategoryEta(element, index) {
        console.log('kesini');
        if(element.checked) {
            $('.sub-element-eta-category-'+index).removeClass('hide')
        }else{
            $('.sub-element-eta-category-'+index).addClass('hide')
        }
    }

    function toggleAlumniFields(elem) {
        var isYes = $(elem).val() === 'yes';
        var container = $(elem).closest('.form-group').next('.alumni-fields-container');
        if (isYes) {
            container.removeClass('hide');
        } else {
            container.addClass('hide');
        }
    }

    function toggleVendorFields(elem) {
        var isYes = $(elem).val() === 'yes';
        var container = $(elem).closest('.form-group').next('.vendor-fields-container');
        if (isYes) {
            container.removeClass('hide');
        } else {
            container.addClass('hide');
        }
    }

    function toggleBasicAlumniFields(elem) {
        var isChecked = $(elem).is(':checked');
        var container = $(elem).closest('.alumni-fields-container');
        if (isChecked) {
            container.find('.basic-field-select-container').removeClass('hide');
            container.find('.custom-field-select-container').addClass('hide');
        } else {
            container.find('.basic-field-select-container').addClass('hide');
            container.find('.custom-field-select-container').removeClass('hide');
        }
    }

    // ==========================================
    // EDUCATION GROUP ADMIN FUNCTIONS
    // ==========================================

    function appendEducationElement(containerId, levelKey, data) {
        var $container = $('#' + containerId);
        var curCount = $container.find('> fieldset').length;
        var nextIdx = curCount + 1;
        var templateHtml = $(".sample-education-group-element").html();
        var $elem = $(templateHtml);

        $elem.attr({
            id: 'edu-fieldset-' + levelKey.replace('/', '_') + '-' + nextIdx,
            'data-index': nextIdx
        });

        $elem.find('.element-number').text('Element ' + nextIdx);
        $elem.find('.remove-education-fieldset').attr('data-fieldset', 'edu-fieldset-' + levelKey.replace('/', '_') + '-' + nextIdx);

        // Bind name attributes with levelKey and nextIdx
        $elem.find('.property-name').attr('name', 'element_education_group_options[' + levelKey + '][' + nextIdx + '][property_name]');
        $elem.find('.property-id').attr('name', 'element_education_group_options[' + levelKey + '][' + nextIdx + '][property_id]');
        $elem.find('.property-type').attr('name', 'element_education_group_options[' + levelKey + '][' + nextIdx + '][property_type]');
        $elem.find('.required').attr('name', 'element_education_group_options[' + levelKey + '][' + nextIdx + '][required]');
        $elem.find('.is_number_element').attr('name', 'element_education_group_options[' + levelKey + '][' + nextIdx + '][is_number]');
        $elem.find('.is_limit_element').attr('name', 'element_education_group_options[' + levelKey + '][' + nextIdx + '][is_limit]');
        $elem.find('.other').attr('name', 'element_education_group_options[' + levelKey + '][' + nextIdx + '][have_other]');
        $elem.find('.note').attr('name', 'element_education_group_options[' + levelKey + '][' + nextIdx + '][note]').addClass('editor');
        $elem.find('.option-sub-element').attr('name', 'element_education_group_options[' + levelKey + '][' + nextIdx + '][options][]');
        $elem.find('.is_validation_selection').attr('name', 'element_education_group_options[' + levelKey + '][' + nextIdx + '][validation_for_selection]');
        $elem.find('.is_score_test_element').attr('name', 'element_education_group_options[' + levelKey + '][' + nextIdx + '][is_score_test]');
        $elem.find('.trigger_notify_finance').attr('name', 'element_education_group_options[' + levelKey + '][' + nextIdx + '][trigger_notify_finance]');
        $elem.find('.trigger_notify_ticket_element').attr('name', 'element_education_group_options[' + levelKey + '][' + nextIdx + '][trigger_notify_ticket]');
        $elem.find('.trigger_set_to_alumni').attr('name', 'element_education_group_options[' + levelKey + '][' + nextIdx + '][trigger_set_to_alumni]');
        $elem.find('.eta_category').attr('name', 'element_education_group_options[' + levelKey + '][' + nextIdx + '][eta_category]');
        $elem.find('.type_limit_char').attr('name', 'element_education_group_options[' + levelKey + '][' + nextIdx + '][type_limit_char]');
        $elem.find('.min_limit_char').attr('name', 'element_education_group_options[' + levelKey + '][' + nextIdx + '][min_limit_char]');
        $elem.find('.limit_char').attr('name', 'element_education_group_options[' + levelKey + '][' + nextIdx + '][limit_char]');
        $elem.find('.group_element_available_validation_element').attr('name', 'element_education_group_options[' + levelKey + '][' + nextIdx + '][group_element_available_validation]');
        $elem.find('.group_element_available_validation_element').attr('id', 'edu_group_element_available_validation_' + levelKey.replace('/', '_') + '_' + nextIdx);
        $elem.find('.element-group-validation-item .label-check').attr('for', 'edu_group_element_available_validation_' + levelKey.replace('/', '_') + '_' + nextIdx);
        $elem.find('.property-from-validation').attr('name', 'element_education_group_options[' + levelKey + '][' + nextIdx + '][group_element_validation_for]');
        $elem.find('.available_alumni_element').attr('name', 'element_education_group_options[' + levelKey + '][' + nextIdx + '][available_alumni]').trigger('change');
        $elem.find('.is_basic_element').attr('name', 'element_education_group_options[' + levelKey + '][' + nextIdx + '][is_basic]');
        $elem.find('.basic-fields-element').attr('name', 'element_education_group_options[' + levelKey + '][' + nextIdx + '][basic_fields]');
        $elem.find('.user-property-id-element').attr('name', 'element_education_group_options[' + levelKey + '][' + nextIdx + '][user_property_id]');

        if (data) {
            $elem.find('.required').prop('checked', true);
            if (data.name) $elem.find('.property-name').val(data.name);
            if (data.type) {
                $elem.find('.property-type').val(data.type);
                propertyTypeChanged($elem.find('.property-type')[0], '.education-group-element-items');
            }
            if (data.is_number) $elem.find('.is_number_element').prop('checked', true);
            if (data.is_limit) $elem.find('.is_limit_element').prop('checked', true);
            if (data.have_other) $elem.find('.other').prop('checked', true);
            if (data.note) $elem.find('.note').val(data.note);
            if (data.validation_for_selection) $elem.find('.is_validation_selection').val(data.validation_for_selection);
            if (data.available_alumni) {
                $elem.find('.available_alumni_element[value="' + data.available_alumni + '"]').prop('checked', true).trigger('change');
            }
            if (typeof data.is_basic !== 'undefined') {
                $elem.find('.is_basic_element').prop('checked', data.is_basic == 1).trigger('change');
            }
            if (data.basic_fields) $elem.find('.basic-fields-element').val(data.basic_fields);
            if (data.user_property_id) $elem.find('.user-property-id-element').val(data.user_property_id);
            if (data.is_score_test) $elem.find('.is_score_test_element').prop('checked', true);
            if (data.trigger_notify_finance) $elem.find('.trigger_notify_finance').prop('checked', true);
            if (data.trigger_notify_ticket) {
                $elem.find('.trigger_notify_ticket_element').prop('checked', true);
                $elem.find('.sub-element-eta-category').removeClass('hide');
            }
            if (data.trigger_set_to_alumni) $elem.find('.trigger_set_to_alumni').prop('checked', true);
            if (data.eta_category) $elem.find('.eta_category').val(data.eta_category);
            if (data.type_limit_char) $elem.find('.type_limit_char').val(data.type_limit_char);
            if (data.min_limit_char) $elem.find('.min_limit_char').val(data.min_limit_char);
            if (data.limit_char) $elem.find('.limit_char').val(data.limit_char);
            if (data.group_element_available_validation) {
                $elem.find('.group_element_available_validation_element').prop('checked', true);
                $elem.find('.element-group-validation-field').removeClass('hide');
            }
            if (data.group_element_validation_for) $elem.find('.property-from-validation').val(data.group_element_validation_for);
            if (data.is_limit) $elem.find('.is_limit_char').removeClass('hide');
            if (data.options && data.options.length > 0) {
                var $optContainer = $elem.find('.sub-element-parent-options');
                $optContainer.empty();
                $.each(data.options, function(i, optVal) {
                    var optHtml = '<div class="col-lg-12 opdt-education-group-item" style="padding-left:0; margin-bottom:5px;">' +
                                  '<div class="form-group property-option" style="position:relative; margin-bottom:5px;">' +
                                  '<input type="text" class="form-control option-sub-element" name="element_education_group_options[' + levelKey + '][' + nextIdx + '][options][]" value="' + optVal + '">' +
                                  '<a href="javascript:;" onclick="del_option(this, \'opdt-education-group-item\')" class="btn btn-danger btn-sm" style="position:absolute; top:0; right:0;"><i class="fa fa-trash fa-fw"></i></a>' +
                                  '</div></div>';
                    $optContainer.append(optHtml);
                });
            }
        }

        $container.append($elem);

        tinymce.init({
            selector: '.editor',
            plugins: 'link table',
            toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | link',
            contenteditable: true,
            spellchecker: false
        });
    }

    $(document).on('click', '.add-element-education-group', function() {
        var level = $(this).data('level');
        var targetId = $(this).data('target');
        appendEducationElement(targetId, level, {name: '', type: 'input'});
    });

    $(document).on('click', '.remove-education-fieldset', function() {
        if (!confirm('Are you sure want to delete this ?')) return;
        var elementId = $(this).data('id');
        if (elementId) {
            var currentDel = $('#delete_education_group_options').val();
            $('#delete_education_group_options').val(currentDel ? currentDel + ',' + elementId : elementId);
        }
        var container = $(this).closest('.education-group-element-items');
        // Use DOM traversal - find closest fieldset or sub-education-group-element-item
        var target = $(this).closest('.sub-education-group-element-item, fieldset');
        if (target.length) {
            target.remove();
        } else {
            var fieldsetId = $(this).data('fieldset');
            if (fieldsetId) {
                $('#' + fieldsetId).remove();
            }
        }
        if (container.length) {
            reindex_education_elements(container);
        }
    });

    function reindex_education_elements(container) {
        var levelKey = $(container).attr('data-level');
        $(container).find('.sub-education-group-element-item').each(function(k) {
            var idx = k;
            var num = k + 1;
            var slug = $(container).attr('id').replace('education-element-items-', '');
            var fieldsetId = 'edu-fieldset-' + slug + '-' + num;
            $(this).attr('id', fieldsetId).attr('data-index', num);
            // update legend text (Element N) and data-fieldset on delete button
            $(this).find('legend').contents().filter(function() {
                return this.nodeType === 3;
            }).first().replaceWith('Element ' + num + ' ');
            $(this).find('.remove-education-fieldset').attr('data-fieldset', fieldsetId);
            // update field names
            $(this).find('[name^="element_education_group_options"]').each(function() {
                var currentName = $(this).attr('name');
                if (currentName) {
                    var newName = currentName.replace(/^element_education_group_options\[[^\]]+\]\[\d+\]/, 'element_education_group_options[' + levelKey + '][' + idx + ']');
                    $(this).attr('name', newName);
                }
            });
            // update validation checkbox id/for
            var valId = 'edu_group_element_available_validation_' + slug + '_' + num;
            $(this).find('.group_element_available_validation_element').attr('id', valId);
            $(this).find('.element-group-validation-item .label-check').attr('for', valId);
        });
    }

    $(document).on('click', '.btn-load-standard-education', function() {
        if (!confirm('Load standard education fields into all tabs (S1/D4, S2, S3)?')) {
            return;
        }

        var standardS1 = [
            { name: 'Institution (Do not translate)', type: 'input' },
            { name: 'NIM (Nomor Induk Mahasiswa)/ Student ID', type: 'input' },
            { name: 'Country', type: 'country' },
            { name: 'State', type: 'state' },
            { name: 'City', type: 'city' },
            { name: 'Name of Diploma or Degree Equivalent (e.g. BA/MA/MFA):', type: 'input' },
            { name: 'Actual Name of Degree or Diploma (Do not translate)', type: 'input' },
            { name: 'Discipline', type: 'input' },
            { name: 'Last GPA', type: 'input' },
            { name: 'Enrolled From', type: 'date' },
            { name: 'Enrolled ToPA', type: 'date' },
            { name: 'Date Degree Received', type: 'date' },
            { name: 'Upload Transcript', type: 'file' },
            { name: 'Upload Diploma', type: 'file' }
        ];

        var standardS2 = [
            { name: 'University / Institution Name', type: 'input' },
            { name: 'Major / Field of Study', type: 'input' },
            { name: 'Graduation Year', type: 'input', is_number: 1 },
            { name: 'GPA', type: 'input' },
            // { name: 'Master Thesis Title', type: 'input' },
            { name: 'Diploma / Degree Certificate', type: 'file', note: 'Upload your Master Diploma (PDF/JPG, Max 5MB)' },
            { name: 'Academic Transcript', type: 'file', note: 'Upload your Master Transcript (PDF/JPG, Max 5MB)' }
        ];

        var standardS3 = [
            { name: 'University / Institution Name', type: 'input' },
            { name: 'Major / Field of Study', type: 'input' },
            { name: 'Graduation Year', type: 'input', is_number: 1 },
            { name: 'GPA', type: 'input' },
            // { name: 'Dissertation Title', type: 'input' },
            { name: 'Diploma / Degree Certificate', type: 'file', note: 'Upload your Doctoral Diploma (PDF/JPG, Max 5MB)' },
            { name: 'Academic Transcript', type: 'file', note: 'Upload your Doctoral Transcript (PDF/JPG, Max 5MB)' }
        ];

        // Track existing IDs for deletion if container already has items
        $('.education-group-element-items').each(function() {
            $(this).find('.remove-education-fieldset').each(function() {
                var elId = $(this).data('id');
                if (elId) {
                    var currentDel = $('#delete_education_group_options').val();
                    $('#delete_education_group_options').val(currentDel ? currentDel + ',' + elId : elId);
                }
            });
            $(this).empty();
        });

        // Populate S1
        $.each(standardS1, function(i, field) {
            appendEducationElement('education-element-items-S1_D4', 'S1/D4', field);
            appendEducationElement('education-element-items-S2', 'S2', field);
            appendEducationElement('education-element-items-S3', 'S3', field);
        });

        show_toast_message('Standard education fields successfully loaded for S1/D4, S2, and S3!')
        // alert('Standard education fields successfully loaded for S1/D4, S2, and S3!');
    });

    $(document).on('click', '.btn-copy-s1-to-others', function() {
        var s1Items = [];
        $('#education-element-items-S1_D4 > fieldset').each(function() {
            var $f = $(this);
            var optValues = [];
            $f.find('.option-sub-element').each(function() {
                if ($(this).val()) optValues.push($(this).val());
            });

            s1Items.push({
                name: $f.find('.property-name').val(),
                type: $f.find('.property-type').val(),
                required: $f.find('.required').is(':checked') ? 1 : 0,
                have_other: $f.find('.other').is(':checked') ? 1 : 0,
                is_number: $f.find('.is_number_element').is(':checked') ? 1 : 0,
                is_limit: $f.find('.is_limit_element').is(':checked') ? 1 : 0,
                note: $f.find('.note, textarea.editor').val() || '',
                options: optValues,
                validation_for_selection: $f.find('.is_validation_selection').val() || '',
                available_alumni: $f.find('.available_alumni_element:checked').val() || 'no',
                is_basic: $f.find('.is_basic_element').is(':checked') ? 1 : 0,
                basic_fields: $f.find('.basic-fields-element').val() || '',
                user_property_id: $f.find('.user-property-id-element').val() || '',
                is_score_test: $f.find('.is_score_test_element').is(':checked') ? 1 : 0,
                trigger_notify_finance: $f.find('.trigger_notify_finance').is(':checked') ? 1 : 0,
                trigger_notify_ticket: $f.find('.trigger_notify_ticket_element').is(':checked') ? 1 : 0,
                trigger_set_to_alumni: $f.find('.trigger_set_to_alumni').is(':checked') ? 1 : 0,
                eta_category: $f.find('.eta_category').val() || '',
                type_limit_char: $f.find('.type_limit_char').val() || '',
                min_limit_char: $f.find('.min_limit_char').val() || '',
                limit_char: $f.find('.limit_char').val() || '',
                group_element_available_validation: $f.find('.group_element_available_validation_element').is(':checked') ? 1 : 0,
                group_element_validation_for: $f.find('.property-from-validation').val() || ''
            });
        });

        if (s1Items.length === 0) {
            alert('Please add fields in S1/D4 first before copying!');
            return;
        }

        if (!confirm('Copy all S1/D4 fields to S2 (Master) and S3 (Doctor)?')) {
            return;
        }

        // Copy to S2
        $.each(s1Items, function(i, field) {
            appendEducationElement('education-element-items-S2', 'S2', field);
        });

        // Copy to S3
        $.each(s1Items, function(i, field) {
            appendEducationElement('education-element-items-S3', 'S3', field);
        });

        show_toast_message('Fields copied from S1/D4 to S2 and S3 successfully!');
        // alert('Fields copied from S1/D4 to S2 and S3 successfully!');
    });

</script>
<script>

    function copyURL(element) {
        var url = $(element).data('url');
    
        navigator.clipboard.writeText(url)
        .then(function() {
            Swal.fire({
                icon: "success",
                title: "Successfully copied",
                showConfirmButton: false,
                timer: 1500
            });
        })
    }

    $('.have_other').change(function() {
        var id = $(this).data('id');
        if ($(this).is(':checked') && ($(this).val() == 'Other' || $(this).val() == 'Lainnya')) {
            $('.text-other-'+id).show();
            if($(this).hasClass('is_required')){
                $('.text-other-'+id).prop('required', true);
            }
        }else{
            $('.text-other-'+id).hide();
            if($(this).hasClass('is_required')){
                $('.text-other-'+id).prop('required', false);
            }
        }
    })

    $("form").submit(function(e){
        e.preventDefault(); 


        // const formData = $(this).serializeArray();
        var form = this;
        var formData = new FormData(form);
        $.ajax({
            url: "<?= base_url(); ?>panellist/panellist_auth/save_submission_eta",
            method: "POST",
            dataType: "JSON",
            data: formData,
            processData: false,
            contentType: false,
        })
        .success(function(r) {
            if (r == false) {
                Swal.fire({
                    icon: "error",
                    title: "Email already register",
                    showConfirmButton: false,
                    timer: 2000
                });
            }else{
                Swal.fire({
                    icon: "success",
                    title: "Form submited.",
                    showConfirmButton: false,
                    timer: 2000
                }).then(function() {
                    location.reload();
                });;
            }
        })
    })

    function validationCheckbox(element)
    {
        if($(element).hasClass('is_required')){
            if($(element).is(':checked')){
                $(element).closest('.form-group').find('input[type="checkbox"]').prop('required', false);
            }else{
                $(element).closest('.form-group').find('input[type="checkbox"]').prop('required', true);
            }
        }
    }

    $('.select2-country').select2({
        placeholder: "Select a country",
    });

    $('.select2-level-of-study').select2({
        placeholder: "Select a level of study",
    });

    $('.select2-state').select2({
        placeholder: "Select a state",
        ajax: {
            url: function (params) {
                let key_of_unique = $(this).data('select_key_country');
                let country_id = $(".select2-country[data-select_key_country='"+key_of_unique+"']").val();
                return '<?php echo site_url('world/data_state_panellist') ?>' + (country_id ? '/' + country_id : '');
            },
            dataType: 'json'
        }
    });

    $('.select2-city').select2({
        placeholder: "Select a city",
        ajax: {
            url: function (params) {
                let key_of_unique = $(this).data('select_key_country');
                console.log("unique", key_of_unique);
                let state_id = $(".select2-state[data-select_key_country='"+key_of_unique+"']").val();
                return '<?php echo site_url('world/data_city_panellist') ?>' + (state_id ? '/' + state_id : '');
            },
            dataType: 'json'
        }
    });
    
    $('.select2-parent-field-of-study').select2({
        placeholder: "Select Field of Study",
    });
    
    $('.select2-field-of-study').select2({
        placeholder: "Select Specialization",
        ajax: {
            url: function (params) {
                let key_of_unique = $(this).data('select_key_state_of_study');
                let parent_id = $(".select2-parent-field-of-study[data-select_key_state_of_study='"+key_of_unique+"']").val();
                return '<?php echo site_url('world/field_of_study') ?>' + (parent_id ? '/' + parent_id : '');
            },
            dataType: 'json'
        }
    });
    
    $(".select2-parent-field-of-study").on('select2:select', function() {
        let current_value = $(this).select2('data')[0].text;
        if (current_value == 'Other' || current_value == 'Lainnya') {
            let other_input_element = $(this).closest('div').find(".text-have-other");
            other_input_element.show();
        }
        
        $(this).trigger('blur');
        let key_of_unique = $(this).data('select_key_state_of_study');
        $(".select2-field-of-study[data-select_key_state_of_study='" + key_of_unique + "']").val(null).trigger('change').trigger('blur');
    });
    $(".select2-field-of-study").on('select2:select', function() {
        let current_value = $(this).select2('data')[0].text;
        if (current_value == 'Other' || current_value == 'Lainnya') {
            let other_input_element = $(this).closest('div').find(".text-have-other");
            other_input_element.show();
        }
        
        $(this).trigger('blur');
    });

    function copyForm(id) {
        Swal.fire({
            title: "Input Title",
            input: "text",
            inputAttributes: {
                autocapitalize: "off"
            },
            showCancelButton: true,
            confirmButtonText: "Copy",
            showLoaderOnConfirm: true,
            preConfirm: async (inputValue) => {
                if (!inputValue) {
                    Swal.showValidationMessage('Title is required');
                    return false;
                }

                try {
                    const url = `<?= base_url('admin/eta_host_school_application/copy_form/')?>` + id;
                    const response = await fetch(url, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({ title: inputValue })
                    });

                    console.log(response)
                    if (!response.ok) {
                        const errorData = await response.json();
                        return Swal.showValidationMessage(errorData.message);
                    }

                    const result = await response.json();
                    return result;

                } catch (error) {
                    Swal.showValidationMessage(`Something went wrong`);
                }
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    icon: 'success',
                    title: 'Form copied successfully!',
                    text: result.value.message || 'Copy successful.'
                }).then(() => {
                    window.location.href = '<?= base_url('admin/eta_host_school_application/manage')?>';
                });
            }
        });
    }

    $(document).on('click', '.confirm-del-form', function (e) {
        e.preventDefault();

        var id = $(this).data('id');
        var url = $(this).data('url');

        $.ajax({
            url: '<?= site_url("admin/eta_host_school_application/check_relation") ?>',
            type: 'POST',
            data: {id: id},
            dataType: 'json',
            success: function (response) {
                let msg = response.has_relation
                            ? "This data is related to other records. Are you sure you want to delete it?"
                            : "Are you sure you want to delete this data?";

                Swal.fire({
                    title: 'Delete Confirmation',
                    text: msg,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            }
        });
    });


</script>
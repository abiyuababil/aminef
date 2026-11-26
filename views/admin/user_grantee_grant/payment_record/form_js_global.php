<script>
    //  =========== ADD SUB CATEGORY ================
    function show_toast(msg, type = 'success') {
        if (window.Swal && Swal.fire) {
            Swal.fire({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1500,
                icon: type === 'error' ? 'error' : 'success',
                title: msg,
                showClass: { popup: '' },
                hideClass: { popup: '' }
            });
            return;
        }
        console.log((type || 'info') + ': ' + msg);
    }
    $(document).on('click', '.btn-cat-add', function () {
        const tab = $(this).data('tab');
        const select = $(this).data('select');
        const select_type = $(this).data('type');
        const parentModal = $(this).closest('.modal').attr('id');

        let category = '';
        if(tab == 'grant_cost'){
            category = 'Grant Cost';
        }else{
            category = $('#' + tab).val();
        }

        
        if(!category) return alert('Please select category first!');

        $('#add_sub_cat_tab').val(category);
        $('#add_selsect').val(select);
        $('#select_type').val(select_type);
        $('#add_sub_cat_name').val('');

        $('#modalAddSubCategoryPayment').data('parent-modal', parentModal);

        // Gelapkan modal pertama
        if(parentModal) {
            $('#' + parentModal).css('z-index', '1040');
        }

        $('#modalAddSubCategoryPayment').modal({
            backdrop: true,
            keyboard: false
        });

        setTimeout(() => {
            $('body').addClass('modal-open');
        }, 200);
    });

    $('#modalAddSubCategoryPayment').on('hidden.bs.modal', function () {
        
        const parentModalId = $(this).data('parent-modal');
        if(parentModalId) {
            $('body').addClass('modal-open');
            $('#' + parentModalId).css('z-index', '1050');
        }
    });


    $(document).on('click', '#btn_save_sub_cat', function () {
        const category = $('#add_sub_cat_tab').val();
        const select = $('#add_selsect').val();
        const select_type = $('#select_type').val();

        const name = $('#add_sub_cat_name').val();
        if (!name || !name.trim()) {
            $('#add_sub_cat_name').focus();
            return;
        }

        console.log(select)

        $.ajax({
            url: '<?= base_url() ?>admin/grantee/add_sub_category',
            method: 'POST',
            data: { name: name.trim(), category: category },
            dataType: 'json',
            success: function (resp) {
                if (resp && resp.success) {
                    const safe_name = $('<span>').text(resp.data.name).html();
                    
                    const newOption = new Option(safe_name, resp.data.id, true, true);
                    if(select_type == 'select2') {
                        $('#' + select)
                            .append(newOption)
                            .trigger('change');
                    }else{
                        $('#' + select).append(newOption);
                        $('#' + select).selectpicker('refresh');
                        $('#' + select).selectpicker('val', resp.data.id);
                    }
                    
                    $('#modalAddSubCategoryPayment').modal('hide');
                    show_toast('Sub Category "' + resp.name + '" added');
                } else {
                    show_toast(resp.message || 'Failed to add sub category', 'error');
                }
            },
            error: function () {
                show_toast('Error adding sub category', 'error');
            }
        });
    });

    $(document).on('keypress', '#add_sub_cat_name', function (e) {
        if (e.which === 13) {
            e.preventDefault();
            $('#btn_save_sub_cat').click();
        }
    });


    // =========== PAYMENT ITEM ================
    $(document).on('select2:select', '.select2', function (e) {
        let $select = $(this);
        let data = e.params.data;
        let type = e.params.data.title ?? 'item';
        const parentModal = $(this).closest('.modal').attr('id');

        if (data.id === '__add_new__') {

            let $option = $(data.element);

            let category = $option.data('category');
            let subcategory = $option.data('subcategory');

            let value_subcategory = subcategory ? $('#' + subcategory).val() : null;

            if(type === 'sub'){
                // simpan reference select yg aktif
                // $('#modalAddSubCategoryPayment').data('select', $select);
                // $('#modalAddSubCategoryPayment').data('category', category);
                // $('#modalAddSubCategoryPayment').data('subcategory', subcategory);


                let $category = $('#' + category).val();


                $('#add_sub_cat_tab').val($category);
                $('#add_selsect').val($select.data('select2Id'));
                $('#select_type').val('select2');
    
                $select.val(null).trigger('change');

                $('#modalAddSubCategoryPayment').data('parent-modal', parentModal);

                if(parentModal) {
                    $('#' + parentModal).css('z-index', '1040');
                }
    
                $('#add_sub_cat_name').val('');
                $('#modalAddSubCategoryPayment').modal('show');
            }else{
                if(!value_subcategory){
                    $select.val(null).trigger('change');
                    return alert('Please select sub category first!');
                }
                // simpan reference select yg aktif
                $('#modalAddPaymentItem').data('select', $select);
                $('#modalAddPaymentItem').data('category', category);
                $('#modalAddPaymentItem').data('subcategory', subcategory);
    
                $select.val(null).trigger('change');

                $('#modalAddPaymentItem').data('parent-modal', parentModal);

                if(parentModal) {
                    $('#' + parentModal).css('z-index', '1040');
                }
    
                $('#add_payment_item_name').val('');
                $('#modalAddPaymentItem').modal('show');
            }
        }
    });

    $('#btn_save_payment_item').on('click', function () {
        let name = $('#add_payment_item_name').val().trim();
        let category = $('#modalAddPaymentItem').data('category');
        let subcategory = $('#modalAddPaymentItem').data('subcategory');
        let $select = $('#modalAddPaymentItem').data('select');

        let $category = $('#' + category).val();
        let $subcategory = $('#' + subcategory).val();
        if($category == undefined) {
            $category = 'Grant Cost';
        }

        if (!name) {
            alert('Name cannot be empty');
            $('#add_payment_item_name').focus();
            return;
        }

        let $btn = $(this)
        $btn.prop('disabled', true);

        $.ajax({
            url: '<?= base_url() ?>admin/grantee/add_payment_item', // endpoint lo
            type: 'POST',
            dataType: 'json',
            data: { 
                name: name,
                category: $category,
                subcategory: $subcategory
            },
            success: function (res) {
                if (res && res.success) {
    
                    let newOption = new Option(res.data.name, res.data.id, true, true);
    
                    let addOption = $select.find('option[value="__add_new__"]');
                    if (addOption.length) {
                        $(newOption).insertBefore(addOption);
                    } else {
                        $select.append(newOption);
                    }
    
                    $select.trigger('change');
    
                    $('#modalAddPaymentItem').modal('hide');
                    show_toast(res.message || 'Successfully added payment item', 'success');
                }else {
                    show_toast(res.message || 'Failed to add payment item', 'error');
                }
            },
            complete: function () {
                $btn.prop('disabled', false);
            },
            error: function () {
                show_toast('Error adding payment item', 'error');
            }
        });
    });

    $('#modalAddPaymentItem').on('hidden.bs.modal', function () {
        
        const parentModalId = $(this).data('parent-modal');
        if(parentModalId) {
            $('body').addClass('modal-open');
            $('#' + parentModalId).css('z-index', '1050');
        }
    });
</script>
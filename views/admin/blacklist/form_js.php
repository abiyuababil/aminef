<script>
    $(document).ready(function(){
        const check_all = $("#select-all-applicant");
        const seach_grantee = $("#search_grantee");
        const save_button = $("#save");
        const progress_dialog = $("#progress-dialog");

        seach_grantee.on('change', function(){
            let q = $(this).val();
            var formData = new FormData();
            formData.append("q", q);
            $.ajax({
                url : '<?php echo site_url('admin/blacklist/search_grantee/'); ?>',
                type : 'POST',
                data: formData,
                dataType : 'JSON',
                processData: false,
                contentType: false, // Using FormData, no need to process data.
                success : function(response) {
                    let table_rows = '';
                    let table_body = $("tbody.applicant-list");
                    if (response.length > 0) {
                        for (i = 0; i < response.length; i++) {
                            table_rows += '<tr>';
                                table_rows += '<td>';
                                    table_rows += '<input data-user_grantee_id="' + response[i].id +'" class="checkbox-applicant" type="checkbox"/>';
                                table_rows += '</td>';
                                
                                table_rows += '<td>';
                                    table_rows += response[i].first_name + ' ' + (response[i].middle_name !== null ? response[i].middle_name : '') + ' ' + response[i].last_name;
                                table_rows += '</td>';
                                
                                table_rows += '<td>';
                                    table_rows += response[i].primary_email;
                                table_rows += '</td>';
                            table_rows += '</tr>';
                        }
                        check_all.prop('disabled', false);
                    } else {
                        check_all.prop('disabled', true);
                        table_rows += '<tr><td width="100%" colspan="3" class="text-center">No data.</td></tr>';
                    }

                    table_body.html(table_rows);
                }, error : function (response) {
                    console.error(response);
                }
            });
        });

        check_all.on('click', function(){
            let is_checked = $(this).prop('checked');
            if (is_checked) {
                $(document).find('.checkbox-applicant').prop("checked", true);
            } else {
                $(document).find('.checkbox-applicant').prop("checked", false);
            }

            show_download_button();
        });

        save_button.on('click', function(e){
            e.preventDefault();
            
            $(this).prop('disabled',true);
            
            let users_grantee_data = [];
            var note = $('#note').val();
            
            $(document).find('.checkbox-applicant').each(function(){
                if ($(this).prop('checked')) {
                    let user_grantee_id = $(this).data('user_grantee_id')
                    users_grantee_data.push(user_grantee_id);
                }
            });

            if (users_grantee_data.length == 0) {
                alert("Please select applicant before click download");
                return false;
            }
            
            $.post('<?php echo site_url('admin/blacklist/save/'); ?>', { data : users_grantee_data, note : note }, function(response) {
                r = JSON.parse(response);
                if(r.success){
                    window.location.href = '<?= site_url('admin/blacklist/manage')?>';
                }
            }).fail(function(error) {
                console.error(error);
            });
        });

        
        $(document).on('click', '.checkbox-applicant', function(){
            var is_checked = false;
            $(document).find('.checkbox-applicant').each(function(){
                is_checked = $(this).prop('checked');
                if (!is_checked) {
                    check_all.prop('checked', false);
                } 
            });
            
            show_download_button();
        });

        $(document).on('click', '.download-single-document', function(e){
            e.preventDefault();
            progress_dialog.modal('show');
            $.ajax({
                url : $(this).attr('href'),
                type : 'GET',
                dataType : 'JSON',
                success : function(response) {
                    var link = document.createElement('a');
                    link.href = response.fileurl;
                    link.download = response.filename;
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    progress_dialog.modal('hide');
                }, error : function(response) {
                    console.error(response);
                }
            });
        });

        function show_download_button()
        {
            var available_data = false;
            $(document).find('.checkbox-applicant').each(function(){
                is_checked = $(this).prop('checked');
                if (available_data == false && is_checked) {
                    available_data = true;
                }
            });

            if (available_data) {
                save_button.removeClass('hide');
            } else {
                save_button.addClass('hide');
            }
        }
    });
</script>
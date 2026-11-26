<script>
    function accept_submission_document(user_id, grantee_grant_id, grant_id, category_id) {
        if (confirm("Are you sure want to Complete this ?")){
            var note = $('#note_document').val();
            var document = $('#document').val();
            $("#btn-accept-submission").html('<img src="<?php echo base_url() ?>/img/loading.gif">')
            $(".btn").attr('disabled', 'disabled');
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/current_grantee/accept_submission_document') ?>',
                data: {
                    note    : note,
                    user_id : user_id,
                    grantee_grant_id : grantee_grant_id,
                    grant_id : grant_id,
                    document : document,
                    category_id : category_id
                },
                success: function(r) {
                    if(r.err_message == false){
                        location.href=r.redirect;
                    }
                }
            });
        }

    }

    function revise_submission_document(user_id, grantee_grant_id, grant_id, category_id) {
        if (confirm("Are you sure this grantee is Revise ?")){
            var note = $('#note_document').val();
            var document = $('#document').val();
            $("#btn-revise-submission").html('<img src="<?php echo base_url() ?>/img/loading.gif">')
            $(".btn").attr('disabled', 'disabled');
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/current_grantee/revise_submission_document') ?>',
                data: {
                    note    : note,
                    user_id : user_id,
                    grantee_grant_id : grantee_grant_id,
                    grant_id : grant_id,
                    document : document,
                    category_id : category_id
                },
                success: function(r) {
                    if(r.err_message == false){
                        location.href=r.redirect;
                    }
                }
            });
        }

    }

    function arrived_submission_document(user_id, grantee_grant_id, grant_id, category_id) {
        if (confirm("Are you sure this grantee is Arrived ?")){
            var note = $('#note_document').val();
            var document = $('#document').val();
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/current_grantee/arrived_submission_document') ?>',
                data: {
                    note    : note,
                    user_id : user_id,
                    grantee_grant_id : grantee_grant_id,
                    grant_id : grant_id,
                    document : document,
                    category_id : category_id
                },
                success: function(r) {
                    if(r.err_message == false){
                        location.href=r.redirect;
                    }
                }
            });
        }

    }

    function withdraw_submission_document(user_id, grantee_grant_id, grant_id, category_id) {
        if (confirm("Are you sure this grantee is Withdraw ?")){
            var note = $('#note_document').val();
            var document = $('#document').val();
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/current_grantee/withdraw_submission_document') ?>',
                data: {
                    note    : note,
                    user_id : user_id,
                    grantee_grant_id : grantee_grant_id,
                    grant_id : grant_id,
                    document : document,
                    category_id : category_id
                },
                success: function(r) {
                    if(r.err_message == false){
                        location.href=r.redirect;
                    }
                }
            });
        }

    }

    function permit_reject_submission_document(user_id, grantee_grant_id, grant_id, category_id) {
        if (confirm("Are you sure this grantee is Reject ?")){
            var note = $('#note_document').val();
            var document = $('#document').val();
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/current_grantee/permit_reject_submission_document') ?>',
                data: {
                    note    : note,
                    user_id : user_id,
                    grantee_grant_id : grantee_grant_id,
                    grant_id : grant_id,
                    document : document,
                    category_id : category_id
                },
                success: function(r) {
                    if(r.err_message == false){
                        location.href=r.redirect;
                    }
                }
            });
        }

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
</script>
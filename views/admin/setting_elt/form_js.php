
<script>
    function count(){ 
        $('#ac').text($('#available .term').length);
        $('#cc').text($('#assigned .term').length);
    }

    count();

    $(document).on('click','.term',function(){
        $(this).toggleClass('selected');
    });

    $(document).on('dblclick','#available .term',function(){

        // $(this).removeClass('selected').appendTo('#assigned');
        // count();

        $('#available .selected').each(function(){
            let termId=$(this).data('id');
            $(this)
                .removeClass('selected')
                .appendTo('#assigned');
            loadGrantee(termId);
        });
        count();
    });

    $(document).on('dblclick','#assigned .term',function(){
        // $(this).removeClass('selected').appendTo('#available');

        $('#assigned .selected').each(function(){
            let termId=$(this).data('id');
            $(this)
                .removeClass('selected')
                .appendTo('#available');
            removeGrantee(termId);
        });
        count();
    });

    $('#right').click(function(){
        // $('#available .selected').removeClass('selected').appendTo('#assigned');
        // count();
        $('#available .selected').each(function(){
            let termId=$(this).data('id');
            $(this)
                .removeClass('selected')
                .appendTo('#assigned');
            loadGrantee(termId);
        });
        count();
    });

    $('#left').click(function(){
        // $('#assigned .selected').removeClass('selected').appendTo('#available');
        $('#assigned .selected').each(function(){
            let termId=$(this).data('id');
            $(this)
                .removeClass('selected')
                .appendTo('#available');
            removeGrantee(termId);
        });
        count();
    });

    $('#allright').click(function(){
        // $('#available .term').appendTo('#assigned').removeClass('selected');
        $('#available .term').each(function(){
            let termId=$(this).data('id');
            $(this).appendTo('#assigned');
            loadGrantee(termId);
        });
        count();
    });

    $('#allleft').click(function(){
        // $('#assigned .term').appendTo('#available').removeClass('selected');
        
        $('#assigned .term').each(function(){
            let termId=$(this).data('id');
            $(this).appendTo('#available');
            removeGrantee(termId);
        });
        count();
    });

    function filter(i,l){
        var v=$(i).val().toLowerCase();
        $(l+' .term').each(function(){
            $(this).toggle($(this).text().toLowerCase().indexOf(v)>-1);
        });
    }

    $('#sa').keyup(()=>filter('#sa','#available'));
    $('#sb').keyup(()=>filter('#sb','#assigned'));

    $('#form').submit(function(){
        $('#hidden').empty();
        $('#assigned .term').each(function(){
            $('#hidden').append('<input type="hidden" name="term_id[]" value="'+$(this).data('id')+'">');
        });
    });
    
    function loadGrantee(termId)
    {
        if ($('#grantee_'+termId).length)
            return;

        $.ajax({
            url: "<?= site_url('admin/settings_elt/get_term_grantees') ?>",
            type: "POST",
            data: {
                term_id: termId
            },
            success: function(res){
                $('#grantee-container').append(res);
            }
        });
    }

    function removeGrantee(termId)
    {
        $('#grantee_'+termId).remove();
    }
</script>
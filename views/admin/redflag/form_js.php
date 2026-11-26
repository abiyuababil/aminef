<script>
    $(document).ready(function(){
        $('.selectpicker').selectpicker();
        $('#user_id').trigger('change');
    
        // Deteksi ketika user mengetik di kolom search
        $(document).on('input', '#user_id ~ .dropdown-menu .bs-searchbox input', function () {
            let keyword = $(this).val();
    
            if (keyword.length >= 2) { // minimal 2 huruf
                $.ajax({
                    url: '<?= base_url()?>/admin/redflag/get_options', // endpoint backend
                    type: 'GET',
                    data: { 
                        q: keyword,
                        data: 'alumni'
                    },
                    dataType: 'json',
                    success: function (res) {
                        let $select = $('#user_id');
                        $select.empty(); // hapus option lama
                        if(res.length){
                            $select.append('<option value="">- Search Name -</option>');
        
                            $.each(res, function (i, item) {
                                $select.append('<option value="' + item.id + '">' + item.text + '</option>');
                            });
                        }
    
                        $select.selectpicker('refresh'); // refresh selectpicker
                    }
                });
            }
        });

        $(document).on('change', '#user_id', function() {
            const user_id = $(this).val();
            $.ajax({
                url: '<?= base_url()?>/admin/redflag/get_options', // endpoint backend
                type: 'GET',
                data: { 
                    data: 'program',
                    user_id: user_id
                },
                dataType: 'json',
                success: function (res) {
                    let $select = $('#program_id');
                    $select.empty(); // hapus option lama
                    if(res.length){
                        $select.append('<option value="">- Select -</option>');
    
                        $.each(res, function (i, item) {
                            $select.append('<option value="' + item.id + '">' + item.text + '</option>');
                        });
                    }

                    $select.selectpicker('refresh'); // refresh selectpicker
                }
            });

        });
    });
	
    function submitFilter(e) {
        if (e.keyCode == 13) {
            $('#frm_manage').submit();
            return false;
        }
    }



</script>
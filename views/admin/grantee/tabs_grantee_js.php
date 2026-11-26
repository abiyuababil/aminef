<script>
    $(document).ready(function(){
            default_active_tab();

            var getData = $('#id_univ_grantee').val();
            if(getData){
                $.ajax({
                    type: 'GET',
                    url: '<?php echo site_url('grantee/placement/get_detail_univ/') ?>' + getData,
                    dataType: 'JSON',
                    success: function(r) {
                        $('#country').val(r.country_name)
                        $('#state').val(r.state_name)
                        $('#city').val(r.city_name)
                        // location.reload();
                    }
                });
            }
            // $(".next").click(function(){
            //     checking_active();
            //     show_required_active();

            //     if(error > 0) {
            //         show_required_active();
            //     }else {
            //         $('.text-required').remove();
            //         // if (confirm("Are you sure you want to go to the next step ? Please check all data before you submit.")){
            //         //     var selected = $(".tabs").tabs("option", "active");
            //         //     var data = $(this).data('index');
            //         //     $("#"+data).addClass("active in");
            //         //     $(".tabs").tabs("option", "active", selected + 1);
            //         //     location.hash = "#"+data;
            //         // }

            //         var selected = $(".tabs").tabs("option", "active");
            //         var data = $(this).data('index');
            //         $("#"+data).addClass("active in");
            //         $(".tabs").tabs("option", "active", selected + 1);
            //         location.hash = "#"+data;
            //     }
            // })
            // $(".previous").click(function(e){
            //     var selected = $(".tabs").tabs("option", "active");
            //     $(".tabs").tabs("option", "active", selected - 1);
            //     location.hash = e.target.getAttribute("href")
            // })
    });

    function default_active_tab() {
        let current_step = location.hash;
        if(current_step) {
            let $target = $(current_step);
            if ($target.length) {
                $target.closest('.tab-content').children('.tab-pane').removeClass('active in');
                $target.addClass('active in');
                $target.css({"display":"block"});
            }
            $(".tabs").tabs();
            var selected = $(".tabs").tabs("option", "active");
            $(".tabs").tabs("option", "active", selected);
        } else {
            $(".tabs").tabs({active:'#step_1'});
        }
    }


    if (window.location.hash) {
        let hash = window.location.hash;

        // cari tab dengan href sesuai hash
        let $tab = $('.nav-pills a[href="' + hash + '"]');

        if ($tab.length) {
            $tab.tab('show');
        }
    }
    
    $('.nav-pills a').on('shown.bs.tab', function (e) {
        let hash = $(e.target).attr('href');
        history.replaceState(null, null, hash);
    });
</script>
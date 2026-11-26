<script>
    $(document).ready(function(){
            default_active_tab_admin();
    });

    function default_active_tab_admin() {
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
</script>
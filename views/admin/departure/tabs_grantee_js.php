<script>
    $(document).ready(function(){
            default_active_tab();
    });

    function navigate_tab(id) {
        location.hash = "#" + id;
        
    }

    function default_active_tab() {
        // let current_step = '<?= $this->session->userdata('last_tab') ?>';
        // $(".tabs").tabs({
        //     active: current_step
        // });
        let current_step = location.hash;
        if(current_step) {
            let first_tab = $('.first_tab').attr('id');
            $(current_step).addClass('active in');
            $(current_step).removeAttr("style");
            $(current_step).css({"display":"block"});
            if (first_tab != current_step.replace('#', '')) {
                $("#" + first_tab).removeClass('active in');
                $("#" + first_tab).css({"display":"none"});
            }
            $(".tabs").tabs();
            var selected = $(".tabs").tabs("option", "active");
            $(".tabs").tabs("option", "active", selected);
        } else {
            $(".tabs").tabs({active:'#departure_documents'});
        }
    }
</script>
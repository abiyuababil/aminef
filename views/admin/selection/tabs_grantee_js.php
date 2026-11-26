<script>
    $(document).ready(function(){
        $(".tabs").tabs({active:'#step_1'});
        $(".next").click(function(){
            var selected = $(".tabs").tabs("option", "active");
            $(".tabs").tabs("option", "active", selected + 1)
        })
        $(".previous").click(function(){
            var selected = $(".tabs").tabs("option", "active");
            $(".tabs").tabs("option", "active", selected - 1)
        })
    })
</script>
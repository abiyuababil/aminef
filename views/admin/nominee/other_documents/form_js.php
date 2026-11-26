<script>
    $(document).ready(function(){
        $(".btn-add-letter").click(function(){
            $(".letter").append($(".additional-letter").html());     
        });
    });
    

    function del_item(el, item_class) {
        console.log(item_class)
        if (confirm("Are you sure want to delete this ?"))
            $(el).closest('.' + item_class).remove();
    }
</script>
$(document).ready(function () {
    $('.del_new_applied').click(function(){
        var id_apply= $(this).attr('data-idut');
        $('.warning_background').show();
        ele = this;
        $('.yes_unsave_uv').click(function(){
            $.ajax({
                url:'/Ajax/del_new_applied',
                type:"POST",
                dataType:"JSON",
                data: {
                    id_apply : id_apply,
                },
                success: function (data){
                }
            });
            $(ele).parents('tr').remove();
            $('.warning_background').hide();
        });
    });
});
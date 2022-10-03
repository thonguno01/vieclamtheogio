$('#id_cat').select2({
    width: '100%',
    placeholder: "Chọn ngành nghề",
});

$(document).ready(function() {
    $('.add_tag').click(function() {
        var flag = true;
        var cate_have_tag = $('#cate_have_tag').val();

        var tag_name = $('.tag_name').val();
        var flag_tag_name = false;
        if (tag_name == '') {
            $('.n_eror_tag_name').html('Không để trống mục này');
            flag = false;
        } else {
            $.ajax({
                url: '/admin/Submit_form/check_tag_alias',
                type: "POST",
                dataType: "JSON",
                async: false,
                data: {
                    tag_name: tag_name,
                    cate_have_tag: cate_have_tag,
                },
                success: function(data) {
                    if (data.length > 0) {
                        $('.n_eror_tag_name').html('Tag name không được trùng');
                        flag_tag_name = false;
                    } else {
                        $('.n_eror_tag_name').html('');
                        flag_tag_name = true;
                    }
                }
            });
        }

        var cat_parent = $('#cate_have_tag').val();


    })
})
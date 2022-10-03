$(document).ready(function() {
    CKEDITOR.replace('editor_nd');
    CKEDITOR.replace('editor_ndgy');
    $('.info_work').validate({
        onfocusout: false,
        onkeyup: false,
        onclick: false,
        rules: {
            "tag_name": {
                required: {
                    depends: function() {
                        $(this).val($.trim($(this).val()));
                        return true;
                    }
                },
                minlength: 10,
            },
            "tag_des": {
                required: {
                    depends: function() {
                        $(this).val($.trim($(this).val()));
                        return true;
                    }
                },
                minlength: 140,
                maxlength: 155,
            },
            "tag_key": {
                required: {
                    depends: function() {
                        $(this).val($.trim($(this).val()));
                        return true;
                    }
                },
            },
            "title_suggest": {
                required: {
                    depends: function() {
                        $(this).val($.trim($(this).val()));
                        return true;
                    }
                },
            }
        },
        messages: {
            "tag_name": {
                required: 'Không để trống mục này',
                minlength: '(10  kí tự trở lên)',
            },
            "tag_des": {
                required: 'Không để trống mục này',
                minlength: '(140 => 155 kí tự)',
                maxlength: '(140 => 155 kí tự)'
            },
            "tag_key": {
                required: 'Không để trống mục này'
            },
            "title_suggest": {
                required: 'Không để trống mục này'
            },
        },
        errorPlacement: function(error, element) {
            $(element).parent('div').children('.n_dtin_ntd_eror').html(error);
        },
        submitHandler: function() {
            var tag_name = $('#tag_name').val();
            var tag_parent = $('#n_type_congviec').val();
            var tag_des = $('#tag_des').val();
            var tag_key = $('#tag_key').val();
            var content = CKEDITOR.instances['editor_nd'].getData();
            var title_suggest = $('#title_suggest').val();
            var content_suggest = CKEDITOR.instances['editor_ndgy'].getData();
            var tag_id = $('#tag_id').val();
            $.ajax({
                url: '/admin/Submit_form/add_edit_tag',
                type: "POST",
                dataType: "JSON",
                data: {
                    tag_id: tag_id,
                    tag_name: tag_name,
                    tag_parent: tag_parent,
                    tag_des: tag_des,
                    tag_key: tag_key,
                    content: content,
                    title_suggest: title_suggest,
                    content_suggest: content_suggest,
                },
                success: function(data) {
                    console.log(data);
                    if (data.kq == true) {
                        window.location = '/admin/list_tag';
                    } else {
                        alert(data.msg);
                    }
                }
            });
        }
    });
});
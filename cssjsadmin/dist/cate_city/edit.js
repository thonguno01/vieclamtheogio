$(document).ready(function() {
    CKEDITOR.replace('editor_nd');
    CKEDITOR.replace('editor_ndgy');
    $('#n_city').select2();
    $('#n_type_congviec').select2();
    $('.info_work').validate({
        onfocusout: false,
        onkeyup: false,
        onclick: false,
        rules: {
            "cit_id": {
                required: true,
                min: 1,
                check_cate_city: true,
            },
            "cat_id": {
                required: true,
                min: 1,
                check_cate_city: true,
            },
            "meta_title": {
                required: {
                    depends: function() {
                        $('#meta_title').val($.trim($('#meta_title').val()));
                        return true;
                    }
                },
                minlength: 50,
                maxlength: 70,
            },
            "meta_description": {
                required: {
                    depends: function() {
                        $(this).val($.trim($(this).val()));
                        return true;
                    }
                },
                minlength: 140,
                maxlength: 155,
            },
            "meta_key": {
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
            },
        },
        messages: {
            "cit_id": {
                required: 'Không để trống mục này',
                min: 'Không để trống mục này',
                check_cate_city: 'Đã có bài viết tại tỉnh thành ngành nghề này'
            },
            "cat_id": {
                required: 'Không để trống mục này',
                min: 'Không để trống mục này',
                check_cate_city: 'Đã có bài viết tại tỉnh thành ngành nghề này'
            },
            "meta_title": {
                required: 'Không để trống mục này hoặc không được chứa space',
                minlength: '(50 => 70 kí tự)',
                maxlength: '(50 => 70 kí tự)'
            },
            "meta_description": {
                required: 'Không để trống mục này',
                minlength: '(140 => 155 kí tự)',
                maxlength: '(140 => 155 kí tự)'
            },
            "meta_key": {
                required: 'Không để trống mục này'
            },
            "title_suggest": {
                required: 'Không để trống mục này'
            },
        },
        errorPlacement: function(error, element) {
            $(element).parent('div').children('.n_dtin_ntd_eror').html(error);
        }
    });
});
$.validator.addMethod('check_cate_city', function() {
    var check = true;
    $.ajax({
        url: '/admin/Submit_form/check_cate_city',
        type: "POST",
        dataType: "JSON",
        async: false,
        data: {
            cat_id: $('#n_type_congviec').val(),
            cit_id: $('#n_city').val(),
        },
        success: function(data) {
            check = data.kq;
        }
    });
    return check;
});
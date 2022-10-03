$(document).ready(function() {
    CKEDITOR.replace('editor_nd');
    CKEDITOR.replace('editor_ndgy');
    $('#edit_cate').validate({
        onfocusout: false,
        onkeyup: false,
        onclick: false,
        ignore: [],
        debug: false,
        rules: {
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
                }
            },
            "content": {
                required: function(textarea) {
                    CKEDITOR.instances[textarea.id].updateElement(); // update textarea
                    var editorcontent = textarea.value.replace(/<[^>]*>/gi, ''); // strip tags
                    return editorcontent.length === 0;
                },
            },
            "title_suggest": {
                required: {
                    depends: function() {
                        $(this).val($.trim($(this).val()));
                        return true;
                    }
                }
            },
            "content_suggest": {
                required: function(textarea) {
                    CKEDITOR.instances[textarea.id].updateElement(); // update textarea
                    var editorcontent = (textarea.value.replace(/<[^>]*>/gi, '')); // strip tags
                    return editorcontent.length === 0;
                },
            }
        },
        messages: {
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
            "content": {
                required: 'Không để trống mục này',
            },
            "title_suggest": {
                required: 'Không để trống mục này'
            },
            "content_suggest": {
                required: 'Không để trống mục này'
            }
        },
        errorPlacement: function(error, element) {
            $(element).parent().find('.n_dtin_ntd_eror').html(error);
        },
        // submitHandler: function() {
        // 	$.ajax({
        //         url:'/admin/Submit_form/add_edit_tag',
        //         type:"POST",
        //         dataType:"JSON",
        //         data: {
        //             tag_id: tag_id,
        //             tag_name: tag_name,
        //             tag_parent: tag_parent,
        //             tag_des: tag_des,
        //             tag_key: tag_key,
        //             content: content,
        //             title_suggest: title_suggest,
        //             content_suggest: content_suggest,
        //         },
        //         success:function(data){
        //             console.log(data);
        //             if(data.kq==true ){
        //                 window.location = '/admin/list_tag';
        //             }else{
        //                 alert(data.msg);
        //             }
        //         }
        //     });
        // }
    });
});
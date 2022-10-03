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
			},
			"tag_id": {
				required: true,
                min: 1,
                check_cate_city: true,
			},
			"meta_title": {
				required: true,
			},
			"meta_description": {
				required: true
			},
			"meta_key": {
				required: true
			},
			"title_suggest": {
				required: true
			}
		},
		messages: {
			"cit_id": {
				required: 'Không để trống mục này',
				min: 'Không để trống mục này',
			},
			"tag_id": {
				required: 'Không để trống mục này',
				min: 'Không để trống mục này',
                check_cate_city: 'Đã có bài viết tại tỉnh thành tags này'
			},
			"meta_title": {
				required: 'Không để trống mục này'	
			},
			"meta_description": {
				required: 'Không để trống mục này'	
			},
			"meta_key": {
				required: 'Không để trống mục này'	
			},
			"title_suggest": {
				required: 'Không để trống mục này'	
			}
		},
        errorPlacement: function(error, element) {
            $(element).parent('div').children('.n_dtin_ntd_eror').html(error);
        }
	});
});
$.validator.addMethod('check_cate_city',function(){
    var check = true;
    $.ajax({
        url:'/admin/Submit_form/check_cate_city',
        type:"POST",
        dataType:"JSON",
        async: false,
        data: {
            tag_id: $('#n_type_congviec').val(),
            cit_id: $('#n_city').val(),
        },
        success:function(data){
            check = data.kq;
        }
    });
    return check;
});
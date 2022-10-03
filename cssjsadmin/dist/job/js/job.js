$(document).ready(function() {
    $('.add_job').click(function() {
        var flag = true;

        //validate tên ngành nghề
        var cat_name = $('.cat_name').val();
        var flag_cat_name = false;
        if (cat_name == '') {
            $('.n_eror_catname').html('Không để trống mục này');
            flag = false;
        } else {
            $.ajax({
                url: '/admin/Submit_form/check_cat_name',
                type: "POST",
                dataType: "JSON",
                async: false,
                data: {
                    cat_name: cat_name,
                },
                success: function(data) {
                    if (data.length > 0) {
                        $('.n_eror_catname').html('Ngành nghề đã tồn tại');
                        flag_cat_name = false;
                    } else {
                        $('.n_eror_catname').html('');
                        flag_cat_name = true;
                    }
                }
            });
        }

        //validate từ khóa
        if ($('.title_cat').val() == '') {
            $('.n_eror_title_cat').html('Không để trống mục này.');
            flag = false;
        } else {
            $('.n_eror_title_cat').html('');
        }


        //validate từ khóa
        if ($('.key_cat').val() == '') {
            $('.n_eror_key_cat').html('Không để trống mục này.');
            flag = false;
        } else {
            $('.n_eror_key_cat').html('');
        }

        //validate nội dung
        if ($('.content_cat').val() == '') {
            $('.n_eror_content_cat').html('Không để trống mục này.');
            flag = false;
        } else {
            $('.n_eror_content_cat').html('');
        }

        //validate tiêu đề đề xuất
        if ($('.title_suggest').val() == '') {
            $('.n_eror_title_suggest').html('Không để trống mục này.');
            flag = false;
        } else {
            $('.n_eror_title_suggest').html('');
        }

        //validate nội dung đề xuất
        if ($('.content_suggest').val() == '') {
            $('.n_eror_content_suggest').html('Không để trống mục này.');
            flag = false;
        } else {
            $('.n_eror_content_suggest').html('');
        }


        if (flag == true && flag_cat_name == true) {
            var data = new FormData;
            data.append('cat_name', cat_name);
            data.append('title_cat', $('.title_cat').val());
            data.append('key_cat', $('.key_cat').val());
            data.append('content_cat', $('.content_cat').val());
            data.append('title_suggest', $('.title_suggest').val());
            data.append('content_suggest', $('.content_suggest').val());
            $.ajax({
                url: '/admin/Submit_form/add_job',
                type: "POST",
                dataType: "JSON",
                async: false,
                contentType: false,
                cache: false,
                processData: false,
                data: data,
                success: function(data) {
                    alert(data.msg);
                    if (data.kq == true) {
                        window.location.href = '/admin/job_list';
                    }
                }
            })
        }
    })


})
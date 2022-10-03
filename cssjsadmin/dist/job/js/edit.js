$(document).ready(function() {
    $('.edit_job').click(function() {
        var flag = true;



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

        var url_tim_uv = $('.url_tim_uv').val();
        var url_tim_tintd = $('.url_tim_ntd').val();
        var content_category = $('.content_category').val();
        var cat_index = $('.cat_index').val();

        if (flag == true) {
            var data = new FormData;
            data.append('title_cat', $('.title_cat').val());
            data.append('key_cat', $('.key_cat').val());
            data.append('content_cat', $('.content_cat').val());
            data.append('title_suggest', $('.title_suggest').val());
            data.append('content_suggest', $('.content_suggest').val());
            data.append('url_tim_uv', url_tim_uv);
            data.append('url_tim_tintd', url_tim_tintd);
            data.append('content_category', content_category);
            data.append('id_category', $('.id_category').val());
            data.append('cat_index', cat_index);

            $.ajax({
                url: '/admin/Submit_form/edit_job',
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
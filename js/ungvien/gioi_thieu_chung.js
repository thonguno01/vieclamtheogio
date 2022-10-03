$(document).ready(function() {
    $('.n_ttcb_update').click(function() {
        var flag = true;
        //Giới thiệu chung
        if ($('.n_gtc_text').val().trim() == '') {
            alert('Không để trống mục này');
            flag = false;
        } else {

        }

        if (flag == true) {
            var data = new FormData;
            data.append('n_gtc_text', $('.n_gtc_text').val());
            console.log(data);
            $.ajax({
                url: '/Ajax/gioi_thieu_chung_uv',
                type: "POST",
                dataType: "JSON",
                contentType: false,
                cache: false,
                processData: false,
                data: data,
                success: function(data) {
                    console.log(data);
                    if (data.kq == true) {
                        window.location.reload();
                    }
                }
            });
        }
    })
})
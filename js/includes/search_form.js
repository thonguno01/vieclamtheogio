$(document).ready(function() {
    $('.select').select2({
        width: '100%',
        placeholder: "Tất cả ",
    });
    $('.n_city_uv').select2({
        width: '75%%',
        placeholder: "Tất cả ",
    });

    function searchuv(hinhthuc, loailv, gioitinh, honnhan, luong) {
        var city_uv = $("#n_city_uv").val();
        var keyword_uv = $("#keyword_uv").val().toLowerCase();

        $.ajax({
            url: '/Ajax/search_uv',
            type: "POST",
            dataType: "JSON",
            data: {
                city: city_uv,
                keyword: keyword_uv,
                hinhthuc: hinhthuc,
                loailv: loailv,
                gioitinh: gioitinh,
                honnhan: honnhan,
                luong: luong,
            },
            success: function(data) {
                console.log(data);
                window.location = data.url;
            }
        });
    }
    $('.n_tim_kiem').click(function() {
        var hinhthuc = $(".s_hinhthuc").val();
        var loailv = $(".s_loailv").val();
        var gioitinh = $(".s_gioitinh").val();
        var honnhan = $(".s_honnhan").val();
        var luong = $(".s_luong").val();
        searchuv(hinhthuc, loailv, gioitinh, honnhan, luong);
    });
    $('.loc_ungvien_mb').on('click', function(event) {
        var hinhthuc = $('input[name=s_hinhthuc_mb]:checked').val();
        var loailv = $('input[name=s_loailv_mb]:checked').val();
        var gioitinh = $('input[name=s_gioitinh_mb]:checked').val();
        var honnhan = $('input[name=s_honnhan_mb]:checked').val();
        var luong = $('input[name=s_luong_mb]:checked').val();
        searchuv(hinhthuc, loailv, gioitinh, honnhan, luong);
    });
});
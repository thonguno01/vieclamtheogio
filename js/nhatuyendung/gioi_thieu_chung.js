var checkImg = true;

function upFile(event) {
    // var loadFile = function(event) {
    var preview_logo1 = document.getElementById('preview_logo1');
    var match = ["image/gif", "image/png", "image/jpg", "image/jpeg", "image/jfif", "image/PNG"];
    var file_data = $('#up_photo1').prop('files')[0];
    if (file_data != undefined) {
        var type = file_data.type;
        var match = ["image/gif", "image/png", "image/jpg", "image/jpeg", "image/jfif", "image/PNG"];
        if (type == match[0] || type == match[1] || type == match[2] || type == match[3] || type == match[4] || type == match[5]) {

            if (file_data.size <= 8000000) {
                preview_logo1.src = URL.createObjectURL(event.target.files[0]);
            } else {
                alert('Bạn chỉ được upload file dưới 8MB');
                checkImg = false;
            }
        } else {
            alert('Bạn chỉ được upload file ảnh');
            return false;
        }
    }
}

function loadFile(event) {
    // var loadFile = function(event) {
    var preview_logo2 = document.getElementById('preview_logo2');
    var match = ["image/gif", "image/png", "image/jpg", "image/jpeg", "image/jfif", "image/PNG"];
    var file_data = $('#up_photo2').prop('files')[0];
    if (file_data != undefined) {
        var type = file_data.type;
        var match = ["image/gif", "image/png", "image/jpg", "image/jpeg", "image/jfif", "image/PNG"];
        if (type == match[0] || type == match[1] || type == match[2] || type == match[3] || type == match[4] || type == match[5]) {
            if (file_data.size <= 8000000) {
                preview_logo2.src = URL.createObjectURL(event.target.files[0]);
            } else {
                alert('Bạn chỉ được upload file dưới 8MB');
                checkImg = false;
            }
        } else {
            alert('Bạn chỉ được upload file ảnh');
            checkImg = false;
        }
    }
}


function postFile(event) {
    // var loadFile = function(event) {
    var preview_logo3 = document.getElementById('preview_logo3');
    var match = ["image/gif", "image/png", "image/jpg", "image/jpeg", "image/jfif", "image/PNG"];
    var file_data = $('#up_photo3').prop('files')[0];
    if (file_data != undefined) {
        var type = file_data.type;
        var match = ["image/gif", "image/png", "image/jpg", "image/jpeg", "image/jfif", "image/PNG"];
        if (type == match[0] || type == match[1] || type == match[2] || type == match[3] || type == match[4] || type == match[5]) {
            if (file_data.size <= 8000000) {
                preview_logo3.src = URL.createObjectURL(event.target.files[0]);
            } else {
                alert('Bạn chỉ được upload file dưới 8MB');
                checkImg = false;
            }
        } else {
            alert('Bạn chỉ được upload file ảnh');
            return false;
        }
    }
}

$(document).ready(function() {
    $('.btn_update_intro').click(function() {
        var flag = true;
        //Giới thiệu chung
        if ($('#mtdn').val().trim() == '') {
            $('.n_eror_mtdn').html('Không để trống mục này.');
            flag = false;
            $("#mtdn").parents('.head_intro_work')[0].scrollIntoView();
        } else {
            $('.n_eror_mtdn').html('');
        }
        if ($('#csptnl').val().trim() == '') {
            $('.n_eror_csptnl').html('Không để trống mục này.');
            flag = false;
            $("#csptnl").parents('.head_intro_work')[0].scrollIntoView();
        } else {
            $('.n_eror_csptnl').html('');
        }


        if (checkImg == true) {
            var file1 = $('#up_photo1').prop('files')[0];
            var file2 = $('#up_photo2').prop('files')[0];
            var file3 = $('#up_photo3').prop('files')[0];
        } else {
            var file1 = '';
            var file2 = '';
            var file3 = '';
        }
        if (flag == true) {
            var data = new FormData();
            data.append('img1', file1);
            data.append('img2', file2);
            data.append('img3', file3);
            data.append('gtc', $('#mtdn').val());
            data.append('csptnl', $('#csptnl').val());
            data.append('chtt', $('#chtt').val());
            data.append('salary', $('#hlln').val());
            console.log(data);
            $.ajax({
                url: '/Ajax/gioi_thieu_chung_ntd',
                type: "POST",
                dataType: "JSON",
                contentType: false,
                cache: false,
                processData: false,
                data: data,
                success: function(data) {
                    console.log(data);
                    if (data.kq == true) {
                        alert("Cập nhật thành công.")
                        window.location.reload();
                    }
                }
            })
        }
    })
})
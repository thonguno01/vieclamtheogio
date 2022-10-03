var timeleft = 60;
var email = $('#send_email').val();
var downloadTimer = setInterval(function() {
    if (timeleft < 0) {
        clearInterval(downloadTimer);
        $("#time_countdown").click(function() {
            $.ajax({
                url: '/Ajax/re_send_email_reset_pass_uv',
                type: "POST",
                dataType: "JSON",
                async: false,
                data: {
                    send_email: email,
                },
                success: function(data) {
                    alert(data.msg)
                    if (data.kq === true) {
                        location.reload();
                    }
                }
            })
        });
        $("#noti_xacthuc").hide();
    } else {
        document.getElementById("time_countdown").innerHTML = "Gửi lại email xác nhận (" + timeleft + "s)";
        $("#time_countdown").click(function() {
            $('#time_countdown').attr("disabled", "disabled");
            if (timeleft > 0) {
                $("#noti_xacthuc").show();
            }
        });
    }
    timeleft -= 1;
}, 1000);
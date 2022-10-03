var timeleft = 1;
var downloadTimer = setInterval(function() {
    console.log(downloadTimer);
    if (timeleft < 0) {
        clearInterval(downloadTimer);
        $("#time_countdown").click(function() {
            $.ajax({
                url: '/Ajax/re_send_email_ntd',
                type: "POST",
                dataType: "JSON",
                async: false,
                data: {},
                success: function(res) {
                    alert(res.msg);
                }
            });
            // location.reload();
        });

        $("#noti_xacthuc").hide();
    } else {
        document.getElementById("time_countdown").innerHTML = "Gửi lại email xác thực (" + timeleft + "s)";
        $("#time_countdown").click(function() {
            $('#time_countdown').attr("disabled", "disabled");
            if (timeleft > 0) {
                $("#noti_xacthuc").show();
            }
        });
    }
    timeleft -= 1;
}, 1000);
var timeleft = 60;
var downloadTimer = setInterval(function(){
    if(timeleft < 0){
        clearInterval(downloadTimer);
        $(".rep_confirm").attr("href", "");
        $("#noti_xacthuc").hide();
    } else {
        document.getElementById("time_countdown").innerHTML = "Gửi lại email xác thực (" + timeleft + "s)";
        $(".rep_confirm").click(function(){
        if(timeleft >0){
            $("#noti_xacthuc").show();
        }
        });
    }
    timeleft -= 1;
}, 1000); 

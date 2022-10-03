$('.btn_save_change').click(function(){
    var regex_email= /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

    var flag=true;
        // validate email
        if ($('#send_email').val()==''){
            $('.n_eror_email').html('Không để trống mục này.');
            flag=false;
            $("#send_email").parents('.dky_ntd_info')[0].scrollIntoView();
        } else if 
            (regex_email.test($('#send_email').val()) == false){
                $('.n_eror_email').html('Bạn chưa nhập đúng định dạng email.');
                flag=false;
                $("#send_email").parents('.dky_ntd_info')[0].scrollIntoView();
        } else{
            $('.n_eror_email').html('');
            window.location.href='/gui-email-quen-mat-khau';
        }

})
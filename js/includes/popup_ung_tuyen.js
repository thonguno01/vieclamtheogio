$(document).ready(function () {
    
    $('.n_tdow').click(function(){
        $(this).toggleClass('n_tdow_pick');
    })
    
    $('.n_close_popup_ut').click(function(){
        $('.popup_ung_tuyen_bg').hide();
    });

    $('.btn_save_ut').click(function(){
        var ds_ca_1 = [];
        var ds_ca_2 = [];
        var ds_ca_3 = [];
        if ($(this).data('ca') == 1){
            var so_ca_chon = $('.n_tdow_pick').length;
            if (so_ca_chon<=0){
                alert('Bạn chưa chọn ca để có thể ứng tuyển');
            }else{
                var ca_chon=[];
                $('.n_tdow_pick').each(function(){
                    ca_chon.push($(this).attr('value'));
                });
                var i=Math.floor(ca_chon[0]/10);
                var time = $('#ca_'+i).html();
                var s = '<p class="n_text_label">Ca' + i +': (<span class="calam_span">' + time + '</span>)</p>';
                s = s + 'Lịch làm đã chọn: ';
                var lich_chon = [];
                $.each( ca_chon, function( index, value ){
                    if (value > 10*(i+1)){
                        s = s + lich_chon;
                        ds_ca_1.push(i);
                        ds_ca_2.push(lich_chon.join(','));
                        ds_ca_3.push(time);
                        lich_chon = [];
                        i=Math.floor(value/10);
                        time = $('#ca_'+i).html();
                        s = s + '<p class="n_text_label">Ca' + i +': (<span class="calam_span">' + time + '</span>)</p>';
                        s = s + 'Lịch làm đã chọn: ';
                    }
                    switch(value % 10) {
                        case 2:
                            lich_chon.push('thứ 2');
                            break;
                        case 3:
                            lich_chon.push('thứ 3');
                            break;
                        case 4:
                            lich_chon.push('thứ 4');
                            break;
                        case 5:
                            lich_chon.push('thứ 5');
                            break;
                        case 6:
                            lich_chon.push('thứ 6');
                            break;
                        case 7:
                            lich_chon.push('thứ 7');
                            break;
                        case 8:
                            lich_chon.push('chủ nhật');
                            break;
                        default:
                            break;
                    }
                });
                ds_ca_1.push(i);
                ds_ca_2.push(lich_chon.join(','));
                ds_ca_3.push(time);
                s = s + lich_chon;
                $('#ca_lam_saved').html(s);
                $('.ca_lam_saved').show();
                $('.note_ntd').show();
            }
        }else{
            $('.note_ntd').show();
        }
        ds_ca_1 = ds_ca_1.join(',');
        ds_ca_2 = ds_ca_2.join('/');
        ds_ca_3 = ds_ca_3.join(',');
        ds_ca_3 = ds_ca_3.replaceAll(' ','');
        localStorage.setItem('ds_ca_1',ds_ca_1);
        localStorage.setItem('ds_ca_2',ds_ca_2);
        localStorage.setItem('ds_ca_3',ds_ca_3);
    });

    $('.btn_send_uc_img').click(function(){
        var s = '';
        if ($('.btn_send_uc').data('ca') == 1){
            s = $('#ca_lam_saved').html();
            var ds_ca_1 = localStorage.getItem('ds_ca_1');
            var ds_ca_2 = localStorage.getItem('ds_ca_2');
            var ds_ca_3 = localStorage.getItem('ds_ca_3');
        }else{
            s = 1;
            var ds_ca_1 = 0;
            var ds_ca_2 = '';
            var ds_ca_3 = '';
        }
        if (s == ''){
            alert('Bạn chưa lưu ca ứng tuyển');
        }else{
            $(this).hide();
            $('.btn_sent_uc_img').show();
            $('.btn_send_uc').css('left','calc(50% - 115px)');
            $('.n_btn_ut').hide();
            $('.n_job_uted_after').toggleClass('hide');
            $('.n_job_uted').toggleClass('hide');
            $('.n_job_uted_bottom').toggleClass('hide');

            console.log(note_ntd);
            $.ajax({
                url: "/Ajax/apply_new",
                type: 'POST',
                dataType: "json",
                data: {
                    ds_ca_1 : ds_ca_1,
                    ds_ca_2 : ds_ca_2,
                    ds_ca_3 : ds_ca_3,
                    id_new : $('.btn_send_uc').data('idnew'),
                    id_ntd : $('.btn_send_uc').data('idntd'),
                    id_user : $('.btn_send_uc').data('iduser'),
                    note_ntd : $('#note_ntd').val(),
                },
                success: function(kq) {
                    if (kq['id_ut'] > 0 && kq['id_tb'] > 0){
                        alert('ứng tuyển thành công');
                    }
                    $('.popup_ung_tuyen_bg').hide();
                },
                error: function() {
                }
            });
        }
    });
})
$(document).ready(function() {
    $('.btn_delete').click(function() {
        $('.warning_background').show();
        ele = this;
        var id_new = $(this).attr('data-idnew');
        $('.btn_yes').click(function() {
            delete_new(id_new);
            $(ele).parents('tr').remove();
            $('.warning_background').hide();
        });
    });
    $('.btn_reload_new').click(function() {
        var id_new = $(this).attr('data-idnew');
        $.ajax({
            url: '/Ajax/refresh_new',
            type: "POST",
            // dataType:"JSON",
            data: {
                id_new: id_new,
            },
            success: function(data) {
                window.location.reload();
            }
        });
    });
});

function delete_new(id_new) {
    $.ajax({
        url: '/Ajax/delete_new',
        type: "POST",
        dataType: "JSON",
        data: {
            id_new: id_new
        },
        success: function(data) {}
    });
}

function refreshNew(id) {
    let alert = confirm('Bạn sẽ mất 1 điểm để làm mới tin và tin sẽ được lên đầu!');
    if (alert == true) {
        $.ajax({
            url: '/Ajax/lamMoiTin',
            type: "POST",
            dataType: "JSON",
            data: {
                id: id
            },
            success: function(data) {}
        });

    } else {
        return false;
    }
}
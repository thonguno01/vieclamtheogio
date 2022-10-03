$(document).ready(function() {
    $('.select').select2({
        width: '100%',
        placeholder: "Tất cả ",
    });
    $('.n_city_uv').select2({
        width: '75%%',
        placeholder: "Tất cả ",
    });

});
$("button.button_save_uv").hover(function() {
    // $(this).find('img').attr('src', '/images/Group 1000003745.svg');
    $(this).parent().find('.alert-hover').css('display', 'block');
}, function() {
    // $(this).find('img').attr('src', '/images/Group 1000003744.svg');
    $('.alert-hover').css('display', 'none');
});
$("button.button_chat").hover(function() {
    $(this).parent().find('.chat-hover').css('display', 'block');
}, function() {
    $('.chat-hover').css('display', 'none');
});
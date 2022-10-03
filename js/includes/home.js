$(document).ready(function () {
    $('.n_list_newest_jobs').slick({
        dots: true,
        arrows: false,
        infinite: true,
        speed: 300,
        slidesToShow: 1,
        slidesToScroll: 1
    });
    $('.n_title_cate_job_text').click(function(){
        if ($(document).width()<=600){
            $(this).toggleClass('n_title_cate_job_active');
            $(this).parents('.n_title_cate_job').next().toggleClass('n_job_cate');
            $(this).parents('.n_title_cate_job').next().children('.n_title_cate_job_see_more_375').toggle();
        }
    });
    $('.n_frequent_ques').click(function(){
        $(this).next().toggle();
        $(this).children('.n_open').toggle();
        $(this).children('.n_close').toggle();
    });
});
$(".product-wrapper>a.product-item2").parent().css({
    "padding": "5px 0",
    "justify-content":"space-between"
});

$('.alert .close').on('click', function() {
    $(this).parent().fadeOut(200);
});

$('.slide-toggle').click(function(event) {
    /* Act on the event */
    event.preventDefault();
    if($(this).parent().hasClass('lose-effic')==1){
        return false;
    };
    $(this).siblings('.weui-media-box_text').toggle();
    var state = $(this).siblings('.weui-media-box_text').css('display');
    if (state == 'none') {
        $(this).children('img').css('display', 'none');
        $(this).children('.open').css('display', 'block');
    } else if (state == 'block') {
        $(this).children('img').css('display', 'none');
        $(this).children('.shut').css('display', 'block');
    }
});

$('.credit .g-content .click-detail').on('click', function(event) {
    event.preventDefault();
    /* Act on the event */
    $(this).parent().siblings('.detail-txt').toggle();
    var state = $(this).parent().siblings('.detail-txt').css('display');
    if (state == 'none') {
        $(this).siblings().children('img').css('display', 'none');
        $(this).siblings().children('.open').css('display', 'inline-block');
    } else if (state == 'block') {
        $(this).siblings().children('img').css('display', 'none');
        $(this).siblings().children('.shut').css('display', 'inline-block');
    }
});
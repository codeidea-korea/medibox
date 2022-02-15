$(function(){
// ------------------------------------

    // 포인트결제 창 탭메뉴 active 배경 슬라이드 효과
    const pointMenu = $('#point_tab_menu>ul>li');
    const highLight = $('.highlight');
    const firstTarget = pointMenu.eq(0);
    const firstLeft = firstTarget.offset().left;
    const firstWidth = firstTarget.innerWidth();

    firstTarget.addClass('on');
    highLight.css({"left" : firstLeft, "width" : firstWidth});

    pointMenu.on('click', function(){
        // 탭메뉴 active menu slide bg effect
        const targetLeft = $(this).offset().left;
        const targetWidth = $(this).innerWidth();

        $(this).addClass('on').siblings().removeClass('on');
        highLight.css({"left" : targetLeft, "width" : targetWidth})

        // 탭메뉴 filter
        $('#point_payment>div').hide();
        if (pointMenu.eq(0).hasClass('on')) {
            $('#point_payment>div').show();
        } else if (pointMenu.eq(1).hasClass('on')) {
            $('.my_point_wrap').show();
        } else if (pointMenu.eq(2).hasClass('on')) {
            $('.my_pass_wrap').show();
        };
    });

// ------------------------------------
});
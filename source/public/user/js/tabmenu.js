$(function(){
// ------------------------------------

    // 포인트결제 창 탭메뉴 active 배경 슬라이드 효과
    const pointMenu = $('#point_tab_menu>ul>li');
    const firstTarget = pointMenu.eq(0);
    
    firstTarget.addClass('on');
    firstTarget.addClass('highlight');

    pointMenu.on('click', function(){
        $(this).addClass('on').siblings().removeClass('on');
        $(this).addClass('highlight').siblings().removeClass('highlight');

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

    // 22.03.04 추가
    const reservationMenu = $('#brand_intro .reservation_des .tab_menu>li');
    const reservationContent = $('#brand_intro .reservation_des .tab_content');

    reservationContent.eq(0).show();
    reservationMenu.on('click', function(){
        let reserIndex = $(this).index();

        $(this).addClass('on').siblings().removeClass('on');

        reservationContent.hide();
        reservationContent.eq(reserIndex).show();
    });

    // 22.03.07 추가
    $('.itm_num').each(function(){
        let itm = $(this).parents('.tab_content').find('ul>li').length;

        itm ? $(this).text(itm) : $(this).text(0);
    });

// ------------------------------------
});
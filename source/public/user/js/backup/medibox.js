$(function(){
// -------------------------------------
    // 윈도우 로드 후 fadeOut
    $(window).on('load', function(){
        $('#loading').fadeOut();
    });

    // .gnb 결제 버튼 클릭시 팝업창 fadeIn
    /*
    $('.gnb li:nth-child(1)>a').on('click', function(){
        $('.popup').addClass('on');
    });
    */

    // 회원가입 완료 버튼 클릭시 팝업창 fadeIn
    $('#complete_btn').on('click', function(){
        $('.popup').addClass('on');
    });

    $('#logout').on('click', function(){
        $('#popup06').addClass('on');
    });

    $('#withdrawal').on('click', function(){
        $('#popup07').addClass('on');
    });

    $('.close_btn').on('click', function(){
        $(this).parents('.popup').removeClass('on');
    })

    const select = $('.select_box');
    const option = $('.option>li');

    // 결제페이지 매장 선택하기, 서비스 선택하기 클릭 이벤트
    select.on('click', function(){
        $('.option').stop().slideUp();
        $(this).next().stop().slideToggle();
    });

    // 옵션 값으로 변경, 옵션 창 slideUp
    option.on('click', function(){
        let optionValue = $(this).text();
        $(this).parent().prev().addClass('on');
        $(this).parent().prev().children('span').text(optionValue);
        $(this).parent().stop().slideUp();
    });

    $('#history_lnb .depth01>li>a').on('click', function(){
        $(this).parent().siblings().find('.depth02').slideUp();
        $(this).next().stop().slideToggle();
    });

    $('.brand_item_slider').on('init reInit afterChange', function(e,s,c){
        var i = (c ? c : 0);

        $('.brand_item_num .snum').text(i+1 + " / " + s.slideCount);
    });

    $('.brand_item_slider').slick({
        arrows:false,
    });


// -------------------------------------
});
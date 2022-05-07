$(function(){
// -------------------------------------
    // 윈도우 로드 후 fadeOut
    $(window).on('load', function(){
        $('#loading').fadeOut();
    });

    // 22.03.18 추가
    $('.popup a').on('click', function(){
        $(this).parents('.popup').removeClass('on');

        return false;
    });    

    // .gnb 결제 버튼 클릭시 팝업창 fadeIn
    $('.gnb li:nth-child(1)>a').on('click', function(){
        $('.popup').addClass('on');
    });

    // 회원가입 완료 버튼 클릭시 팝업창 fadeIn
    $('#complete_btn').on('click', function(){
        $('.popup').addClass('on');
    });

    $('#logout').on('click', function(){
        $('#popup10').addClass('on');
    });

    $('#withdrawal').on('click', function(){
        $('#popup07').addClass('on');
    });

    // ---------------- 2차 ----------------
    // 결제 메인페이지 멤버십 혜택 모달창
    function memberModalOpen(g) {
        $('#point_payment '+ g +' .boon_btn').on('click', function(){
            $('.modal_wrap' + g).addClass('on');
            if ($('.modal_wrap').hasClass('on')) {
                $('body').css("overflow", "hidden");
            };
        });
    };    

    // 멤버십별 혜택 모달창 오픈
    let gradeArr = ["classic", "gold", "platinum", "black"];
    for (let grade of gradeArr) {
        memberModalOpen('.' + grade);
    };    

    // 예약 링크 공유 모달창 오픈
    function shareModalOpen() {
        $('.share_btn').on('click', function(){
            $('.modal_wrap.share').addClass('on');
            if ($('.modal_wrap').hasClass('on')) {
                $('body').css("overflow", "hidden");
            };
        });
    };

    shareModalOpen();

    // 날짜선택 모달창 오픈
    function dateModalOpen() {
        $('.date_open_btn').on('click', function(){
            $('.modal_wrap.date').addClass('on');
            if ($('.modal_wrap').hasClass('on')) {
                $('body').css("overflow", "hidden");
            };
        });
    };

    dateModalOpen();

    // 모달창 확인,취소버튼, 백그라운드 클릭시 모달닫기
    $('.top_bar_wrap, .modal_wrap .close_btn').on('click', function(){
        $('.modal_wrap').removeClass('on');
        $('body').css("overflow", "auto");

        return false;
    });    

    // 모달창 배경 클릭 시 닫히게
    const closeBg = '<div class="close_bg"></div>';
    $('.modal_wrap').prepend(closeBg);
    $('.close_bg').on('click', function(){
        $(this).parent().removeClass('on');
    });
    
    // ----------------------------------------------

    // 22.03.14 추가
    // imgChange
    function imgChange(width, selector, before, after){
        if ($(window).width() > width){
            $(selector).attr("src", before);
        } else {
            $(selector).attr("src", after);
        }
    }
    imgChange(550, '#Advertisement.ad01 img', "/user/img/bottom_banner01_l.jpg", "/user/img/bottom_banner01_s.jpg");

    $(window).on('resize', function(){
        imgChange(550, '#Advertisement.ad01 img', "/user/img/bottom_banner01_l.jpg", "/user/img/bottom_banner01_s.jpg");
    });


    const select = $('.select_box');
    const option = $('.option>li');
    const policy = $('.policy>li');

    // 결제페이지 매장 선택하기, 서비스 선택하기 클릭 이벤트
    select.each(function(){
        $(this).on('click', function(){
            let thisNext = $(this).next();
            let optionAll = $(this).parents('.tab_content').find('.option');
            // 22.03.17 추가
            let policyAll = $(this).parents('.tab_content').find('.policy');

            if (!thisNext.hasClass('on')) {
                $(this).parents('section').find('.option').removeClass('on');
                optionAll.removeClass('on');
                // 22.03.17 추가
                policyAll.removeClass('on');
                thisNext.addClass('on');
            } else {
                thisNext.removeClass('on');
            };
        });
    });

    // 옵션 값으로 변경, 옵션 창 slideUp
    option.on('click', function(){
        let optionValue = $(this).text();
        $(this).parent().prev().addClass('on');
        $(this).parent().prev().children('span').text(optionValue);
        $(this).parent().removeClass('on');
    });

    // 개인정보 수집, 제공 slideUp
    policy.on('click', function(){
        $(this).parent().prev().addClass('on');
    });


    $('#history_lnb .depth01>li>a').on('click', function(){
        $(this).parent().siblings().find('.depth02').slideUp();
        $(this).next().stop().slideToggle();
    });

    $('#history_lnb .depth02>li>a').on('click', function(){
        $(this).parent().parent().stop().slideUp();
    });
    
    // 브랜드 메인 이벤트 슬라이드
    $('#brand .event_slider').slick({
        arrows: false,
        infinite: false,
    });

    $('.brand_item_slider').on('init reInit afterChange', function(e,s,c){
        var i = (c ? c : 0);

        $('.brand_item_num .snum').text(i+1 + " / " + s.slideCount);
    });

    $('.brand_item_slider').slick({
        arrows:false,
    });

    $('.itm_num').each(function(){
        let itm = $(this).parent().parent().find('ul>li').length;

        itm ? $(this).text(itm) : $(this).text(0);
    });    

    $('.designer_num').each(function(){
        let designer = $(this).parents('.tab_content').find('h5').length;

        designer ? $(this).text(designer) : $(this).text(0);
    });    

    // 프로필 푸터링크 메뉴 사이 라인
    let footerLink = $('.footer_link>ul>li~li');
    let footerLine = '<div class="line"></div>';
    footerLink.before(footerLine);    

    // 22.03.07 추가 (예약페이지 메뉴 slide toggle)
    $('#brand_intro .menu>h4').on('click', function(){
        $(this).toggleClass('on');
        $(this).next().stop().slideToggle();
    });

    // ---------------- 2차 ----------------
    $('#res_detail .menu a').on('click', function(){
        $('#res_detail .menu a').removeClass('on');
        $(this).toggleClass('on');

        return false;
    });

    // 예약 확인 상세 페이지 (예약알림설정)
    $('#alarm').on('click', function(){
        $(this).toggleClass('on');
        $('.time_wrap').toggleClass('on');
    });

    // 예약 알람 버튼 애니메이션
    $('.time_wrap ul>li').on('click', function(){
        if ($('#alarm').hasClass('on')) {
            $(this).addClass('on').siblings().removeClass('on');
        };
    });

    // 바코드 버튼 이벤트
    $('#barcode .closeup_btn').on('click', function(){
        $('#barcode').addClass('on').css("height", "100vh");
        $('#header').hide();
    });

    // 바코드 닫기 버튼
    $('#barcode .close_btn').on('click', function(){
        $('#barcode').removeClass('on').removeAttr('style');
        $('#header').show();
    });
    // -------------------------------------

// -------------------------------------
});
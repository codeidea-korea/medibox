<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medibox</title>

    <link rel="stylesheet" href="{{ asset('user/css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/medibox.css') }}">
    <script src="{{ asset('user/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('user/js/slick.min.js') }}"></script>
    <script src="{{ asset('user/js/medibox.js') }}"></script>
</head>
<body>
    
    <header id="header">
        <!-- 뒤로가기 버튼 -->
        <button class="back" onclick="history.back()">
            <svg xmlns="http://www.w3.org/2000/svg" width="24.705" height="24" viewBox="0 0 24.705 24">
                <g id="back_arrow" transform="translate(-22.295 -60)">
                  <rect id="사각형_207" data-name="사각형 207" width="24" height="24" transform="translate(23 60)" fill="none"/>
                  <g id="그룹_389" data-name="그룹 389" transform="translate(-0.231)">
                    <g id="그룹_388" data-name="그룹 388">
                      <line id="선_29" data-name="선 29" x2="22.655" transform="translate(23.845 72)" fill="none" stroke="#1d1d1b" stroke-miterlimit="10" stroke-width="1"/>
                      <path id="패스_174" data-name="패스 174" d="M3382.394,1143.563l-7.163,6.331" transform="translate(-3352 -1077.894)" fill="none" stroke="#000" stroke-linecap="square" stroke-width="1"/>
                      <path id="패스_175" data-name="패스 175" d="M3375.231,1143.563l7.163,6.331" transform="translate(-3352 -1071.563)" fill="none" stroke="#000" stroke-linecap="square" stroke-width="1"/>
                    </g>
                  </g>
                </g>
              </svg>
        </button>
        <!-- page title -->
        <div class="title">
            <span>브랜드</span>
        </div>
    </header>


    <!-- 미니쉬스파 브랜드 소개 페이지 -->
    <section id="brand_intro">
        <div class="brand_item_slider">
            <figure class="nail01"></figure>
            <figure class="nail02"></figure>
            <figure class="nail03"></figure>
            <figure class="nail04"></figure>
            <figure class="nail05"></figure>
        </div>
        <div class="brand_item_num">
            <span class="snum"></span>
        </div>
        <div class="brand_item_des">
            <h2>바라는 네일</h2>
            <span>NAIL</span>
            <p>바라는 네일의 네일룸과 패디룸의 모든 공간은 고객님의 편안한 휴식 시간을 온전히 즐기실 수 있도록 준비되어있습니다. 바라는 네일에 들어오시는 순간부터 나가실 때까지 고객님 한분한분을 위한 맞춤관리로 프라이빗한 프리미엄 관리를 경험하 실수 있습니다.</p>
            <p>파고드는 발톱관리 & 문제성 손발톱관리 & 물어뜯는 손톱관리 & 문제성 각질프리미엄 관리를 함께 만나실 수 있습니다.</p>
            <p>고객님의 맞춤관리로 네일과 패디관리뿐만 아니라 휴식과 편안함을 즐기실 수 있는 공간을 제공해드립니다.</p>
        </div>
    </section>

</body>
</html>
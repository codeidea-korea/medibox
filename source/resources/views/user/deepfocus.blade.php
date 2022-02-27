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
        <button class="back" onclick="location.href='/brand';">
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
            <figure class="deep_focus01"></figure>
            <figure class="deep_focus02"></figure>
            <figure class="deep_focus03"></figure>
            <figure class="deep_focus04"></figure>
            <figure class="deep_focus05"></figure>
        </div>
        <div class="brand_item_num">
            <span class="snum"></span>
        </div>
        <div class="brand_item_des">
            <h2>딥포커스 검안센터</h2>
            <span>Deep Focus</span>
            <p>‘왜 유럽과 미국에서는 보편화된 전문 검안을 한국에서는 찾아보기 어려울까?’ 이런 의문으로 시작한 딥포커스 정밀 검안센터는 ‘김광용 OPTICIAN’에 의해 15년 동안 연구된 눈 중심 전문 검안센터입니다.</p>
            <p>우리의 눈은 특정 질환이 아니더라도 다양한 불편 증상이 생길 수 있습니다. 때문에 눈 질환과 시기능 이상은 구별이 필요합니다.</p>
            <p>체계적이고 정밀한 검안을 통해 고객님들께 선명하고 편안한 시력을 선사하여 만족도 높은 시생활이 가능토록 도와드립니다.</p>
        </div>
    </section>

</body>
</html>
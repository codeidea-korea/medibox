<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medibox</title>

    <link rel="stylesheet" href="{{ asset('user/css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/medibox.css') }}">
</head>
<body>
    
    <!-- header -->
    <header id="header">
        <!-- 뒤로가기 버튼 -->
        <button class="back" onclick="location.href='/';">
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


    <!-- 브랜드 메뉴 -->
    <section id="brand">
        <ul>
            <li class="minish_spa">
                <a href="/brand/minishspa">
                    <div class="txt_box">
                        <span>Minsh Spa</span>
                        <h2>미니쉬 스파</h2>
                    </div>
                </a>
            </li>
            <li class="valmont_spa">
                <a href="/brand/valmontspa">
                    <div class="txt_box">
                        <span>Valmont Spa</span>
                        <h2>발몽 스파</h2>
                    </div>
                </a>
            </li>
            <li class="nail">
                <a href="/brand/nail">
                    <div class="txt_box">
                        <span>Nail</span>
                        <h2>바라는 네일</h2>
                    </div>
                </a>
            </li>
            <li class="deep_fucus">
                <a href="/brand/deepfocus">
                    <div class="txt_box">
                        <span>Deep Focus</span>
                        <h2>딥포커스 검안센터</h2>
                    </div>
                </a>
            </li>
            <li class="minish_manul_therapy">
                <a href="/brand/minishtherapy">
                    <div class="txt_box">
                        <span>Minish Manul Therapy</span>
                        <h2>미니쉬 도수</h2>
                    </div>
                </a>
            </li>
            <li class="foresta_black">
                <a href="/brand/forestablack">
                    <div class="txt_box">
                        <span>Foresta Black</span>
                        <h2>포레스타 블랙</h2>
                    </div>
                </a>
            </li>
        </ul>
    </section>
</body>
</html>
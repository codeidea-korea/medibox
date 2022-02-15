<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medibox</title>

    <link rel="stylesheet" href="{{ asset('user/css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/medibox.css') }}">
    <script src="{{ asset('user/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('user/js/medibox.js') }}"></script>
</head>
<body>

    <!-- header -->
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
            <span>결제 내역</span>
        </div>
    </header>


    <nav id="history_lnb">
        <ul class="depth01">
            <li>
                <a href="#!">전체 기간</a>
                <ul class="depth02">
                    <li><a href="#!">1개월</a></li>
                    <li><a href="#!">3개월</a></li>
                    <li><a href="#!">6개월</a></li>
                    <li><a href="#!">1년</a></li>
                </ul>
            </li>
            <li>
                <a href="#!">전체 내역</a>
                <ul class="depth02">
                    <li><a href="#!">포인트</a></li>
                    <li><a href="#!">정액권</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <section id="pay_history">
        <ul>
            <li>
                <div class="history_item">
                    <div class="left">
                        <h3>바라는 네일 정액권</h3>
                        <span class="category">정액권</span>
                        <span class="date">2022년 1월 12일 18:35</span>
                    </div>
                    <div class="right">
                        <span class="point">- 90,000 P</span>
                        <span class="whether use">사용</span>
                    </div>
                </div>
            </li>
            <li>
                <div class="history_item">
                    <div class="left">
                        <h3>미니쉬 치과병원</h3>
                        <span class="category">내 포인트</span>
                        <span class="date">2022년 1월 10일 14:30</span>
                    </div>
                    <div class="right">
                        <span class="point">- 300,000 P</span>
                        <span class="whether refund">환불</span>
                    </div>
                </div>
            </li>
            <li>
                <div class="history_item">
                    <div class="left">
                        <h3>미니쉬 치과병원</h3>
                        <span class="category">내 포인트</span>
                        <span class="date">2022년 1월 10일 14:20</span>
                    </div>
                    <div class="right">
                        <span class="point">+ 10,000,000 P</span>
                        <span class="whether charge">충전</span>
                    </div>
                </div>
            </li>
            <li>
                <div class="history_item">
                    <div class="left">
                        <h3>미니쉬 스파</h3>
                        <span class="category">패키지</span>
                        <span class="date">2021년 12월 12일 12:00</span>
                    </div>
                    <div class="right">
                        <span class="point">- 500,000 P</span>
                        <span class="whether use">사용</span>
                    </div>
                </div>
            </li>
            <li>
                <div class="history_item">
                    <div class="left">
                        <h3>발몽 스파</h3>
                        <span class="category">패키지</span>
                        <span class="date">2021년 12월 1일 20:34</span>
                    </div>
                    <div class="right">
                        <span class="point">- 300,000P</span>
                        <span class="whether use">사용</span>
                    </div>
                </div>
            </li>
            <li>
                <div class="history_item">
                    <div class="left">
                        <h3>포레스타 블랙 정액권</h3>
                        <span class="category">정액권</span>
                        <span class="date">2021년 12월 1일 20:34</span>
                    </div>
                    <div class="right">
                        <span class="point">- 1,000,000 P</span>
                        <span class="whether use">사용</span>
                    </div>
                </div>
            </li>
        </ul>
    </section>


</body>
</html>
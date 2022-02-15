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

    <!-- loading 화면 (로딩 후 fadeOut)-->
    <div id="loading">
        <div class="slogan">
            <h2 class="main_title">MEDI BOX</h2>
            <p class="main_sub_title">
                특별한 당신을 위한<br>
                Health Care
            </p>
        </div>
    </div>

    <!-- intro -->
    <div id="intro">
        <div class="container">
            <h2 class="main_title">MEDI BOX</h2>
            <p class="main_sub_title">
                특별한 당신을 위한<br>
                Health Care
            </p>
            <nav class="gnb">
                <ul>
                    <li>
                        <a href="#!">
                            <div class="menu_box">
                                <img src="/user/img/icon_pay.svg" alt="결제">
                                <span>결제</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#!">
                            <div class="menu_box">
                                <img src="/user/img/icon_login.svg" alt="결제">
                                <span>MY</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#!">
                            <div class="menu_box">
                                <img src="/user/img/icon_brand.svg" alt="결제">
                                <span>브랜드</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#!">
                            <div class="menu_box">
                                <img src="/user/img/icon_reserve.svg" alt="결제">
                                <span>예약</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>


    <!-- 로그인이 필요한 서비스입니다. (팝업창) -->
    <div id="popup01" class="popup">
        <div class="container">
            <div class="top">
                <strong class="popup_icon">!</strong>
                <span>로그인이 필요한<br>서비스입니다.</span>
            </div>
            <div class="bottom">
                <!-- 버튼 클릭 시 로그인 화면으로 이동 -->
                <a href="./login.html">확인</a>
            </div>
        </div>
    </div>


</body>
</html>
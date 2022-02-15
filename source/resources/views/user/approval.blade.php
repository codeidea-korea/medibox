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
            <span>포인트 결제</span>
        </div>
    </header>


    <!-- 관리자 승인 로딩 페이지 -->
    <section id="approval">
        <div class="container">
            <figure>
                <img src="/user/img/icon_approval.png" alt="메디박스 관리자 승인">
            </figure>
            <h2>
                관리자 승인중입니다.<br>
                잠시만 기다려주세요.
            </h2>
            <p>관리자가 승인 후, 포인트 결제가 완료됩니다.</p>
        </div>

    </section>

    <!-- 포인트 결제 완료 팝업 -->
    <div id="popup03" class="popup">
        <div class="container">
            <div class="top">
                <strong class="popup_icon">success</strong>
                <span>포인트 결제가<br>완료되었습니다.</span>
            </div>
            <div class="bottom">
                <!-- 버튼 클릭 시 로그인 화면으로 이동 -->
                <a href="#!">확인</a>
            </div>
        </div>
    </div>

    <!-- 포인트 결제 취소 팝업 -->
    <div id="popup04" class="popup">
        <div class="container">
            <div class="top">
                <strong class="popup_icon">cancel</strong>
                <span>포인트 결제가<br>취소되었습니다.</span>
            </div>
            <div class="bottom">
                <!-- 버튼 클릭 시 로그인 화면으로 이동 -->
                <a href="#!">확인</a>
            </div>
        </div>
    </div>

    <!-- 보유 포인트 부족 팝업 -->
    <div id="popup05" class="popup">
        <div class="container">
            <div class="top">
                <strong class="popup_icon">empty</strong>
                <span>보유 포인트가<br>부족합니다.</span>
            </div>
            <div class="bottom">
                <!-- 버튼 클릭 시 로그인 화면으로 이동 -->
                <a href="#!">확인</a>
            </div>
        </div>
    </div>

</body>
</html>
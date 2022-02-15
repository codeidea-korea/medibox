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
                <span>마이페이지</span>
            </div>
        </header>

        <section id="myPage">
            <form action="/terms/agreement" method="post">
                <!-- id -->
                <p>
                    <label for="id">아이디(휴대폰 번호)</label>
                    <input type="tel" name="id" id="id" placeholder="휴대폰 번호를 입력해주세요." pattern="[0-9]{3}[0-9]{4}[0-9]{4}" required>
                </p>

                <!-- password -->
                <p>
                    <label for="pw">비밀번호</label>
                    <input type="password" name="pw" id="pw_1" placeholder="비밀번호를 입력해주세요." pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,20}" required>
                </p>

                <!-- edit password -->
                <p>
                    <label for="pw">비밀번호 수정</label>
                    <input type="password" name="pw" id="pw_2" placeholder="비밀번호를 입력해주세요." pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,20}" required>

                    <!-- 형식과 다를 때 나오는 오류메시지 -->
                    <span id="id_error1">영문, 숫자, 특수문자를 포함한 8~20자로 설정해주세요.</span>
                </p>

                <!-- edit password check -->
                <p>
                    <label for="pw">비밀번호 확인</label>
                    <input type="password" name="pw" id="pw_3" placeholder="비밀번호를 입력해주세요." required>

                    <!-- 비밀번호가 일치하지 않을 때 나오는 오류메시지 -->
                    <span id="id_error1">비밀번호가 일치하지 않습니다.<span>
                </p>
                <p>
                    <label for="user_name">이름</label>
                    <input type="text" name="user_name" id="user_name" placeholder="이름을 입력해주세요.">
                </p>

                <!-- 수신 동의 체크박스 -->
                <p class="receive_check">
                    <label for="receive_check">수신 동의</label>
                    <input type="checkbox" name="receive_check" id="receive_check" required>
                    <label for="receive_check">이벤트 정보 수신 동의</label>
                </p>
            </form>

            <!-- 약관 및 정책 -->
            <div class="policy_wrap">
                <a href="/terms/policy">약관 및 정책</a>
            </div>

            <!-- 로그아웃 & 회원탈퇴 -->
            <div class="logout_wrap">
                <a href="#!" id="logout">로그아웃</a>
                <a href="#!" id="withdrawal">회원탈퇴하기</a>
            </div>
        </section>


        <!-- 로그아웃 팝업창 -->
        <div id="popup06" class="popup">
            <div class="container">
                <div class="top">
                    <span>로그아웃하시겠습니까?</span>
                </div>
                <div class="bottom">
                    <a href="#!">예</a>
                    <a href="#!" class="close_btn">아니오</a>
                </div>
            </div>
        </div>


        <!-- 회원탈퇴 팝업창 -->
        <div id="popup07" class="popup">
            <div class="container">
                <div class="top">
                    <span>회원탈퇴를 하시겠습니까?</span>
                </div>
                <div class="bottom">
                    <a href="#!">예</a>
                    <a href="#!" class="close_btn">아니오</a>
                </div>
            </div>
        </div>
        
</body>
</html>
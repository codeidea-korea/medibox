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
            <form>
                <!-- id -->
                <p>
                    <label for="id">아이디(휴대폰 번호)</label>
                    <input type="tel" name="id" id="id" placeholder="휴대폰 번호를 입력해주세요." pattern="[0-9]{3}[0-9]{4}[0-9]{4}" value="{{$id}}" required>
                </p>

                <!-- password -->
                <p>
                    <label for="pw">비밀번호</label>
                    <input type="password" name="pw" id="pw_1" placeholder="비밀번호를 입력해주세요." pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,20}" value="{{$pw}}" required>
                </p>

                <!-- edit password -->
                <p>
                    <label for="pw">비밀번호 수정</label>
                    <input type="password" onkeyup="checkValidationPassword()" name="pw" id="pw_2" placeholder="비밀번호를 입력해주세요." pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,20}" required>

                    <!-- 형식과 다를 때 나오는 오류메시지 -->
                    <span id="id_error1">영문, 숫자, 특수문자를 포함한 8~20자로 설정해주세요.</span>
                </p>

                <!-- edit password check -->
                <p>
                    <label for="pw">비밀번호 확인</label>
                    <input type="password" onkeyup="checkValidationPassword2()" name="pw" id="pw_3" placeholder="비밀번호를 입력해주세요." required>

                    <!-- 비밀번호가 일치하지 않을 때 나오는 오류메시지 -->
                    <span id="id_error2">비밀번호가 일치하지 않습니다.<span>
                </p>
                <p>
                    <label for="user_name">이름</label>
                    <input type="text" name="user_name" id="user_name" placeholder="이름을 입력해주세요." value="{{$name}}">
                </p>

                <!-- 수신 동의 체크박스 -->
                <p class="receive_check">
                    <label for="receive_check">수신 동의</label>
                    <input type="checkbox" name="receive_check" id="receive_check" required value="{{$receive}}">
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

	    <script type="text/javascript" src="{{ asset('user/js/medibox-apis.js') }}?v=2022012918"></script>
        <script>
        
        function checkValidationPassword(){
            var pw = document.querySelector('#pw_2').value;
            var regx = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%*#?&])[A-Za-z\d$@$!%*#?&]{8,}$/;

            $('#pw_error1').hide();
            if (!pw || pw == '' || regx.test(pw) !== true) {
                $('#pw_error1').show();
                return false;
            }
            return true;
        }
        function checkValidationPassword2(){
            var pw_1 = document.querySelector('#pw_2').value;
            var pw_2 = document.querySelector('#pw_3').value;

            $('#pw_error2').hide();
            if (pw_1 != pw_2) {
                $('#pw_error2').show();
                return false;
            }
            return true;
        }
        function checkValidation(){
            var id = document.querySelector('#id').value;
            var pw = document.querySelector('#pw_1').value;
            var pw2 = document.querySelector('#pw_2').value;
            var pw3 = document.querySelector('#pw_3').value;
            var name = document.querySelector('#user_name').value;
            var regPhone = /^01([0|1|6|7|8|9])-?([0-9]{3,4})-?([0-9]{4})$/;
            var regPw = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%*#?&])[A-Za-z\d$@$!%*#?&]{8,}$/;

            if(!id || id == '') {
                alert('올바른 휴대폰 번호를 입력해주세요.');
                return false;
            }
            if (regPhone.test(id) !== true) {
                alert('올바른 휴대폰 번호를 입력해주세요.');
                return false;
            }
            if (!pw || pw == '' || regPw.test(pw) !== true) {
                alert('비밀번호를 입력해주세요.');
                return false;
            }
            if (pw2 && pw2 !== '') {
                if (!checkValidationPassword() || !checkValidationPassword2()) {
                    return false;
                }
            }
            if(!name || name == '') {
                alert('이름을 입력해주세요.');
                return false;
            }
            var isAllow04 = $('#receive_check').is(":checked");

            return true;
        }
        function modify(){
            if(!checkValidation()) {
                return;
            }
            var id = document.querySelector('#id').value;
            var pw = document.querySelector('#pw_1').value;
            var name = document.querySelector('#user_name').value;
            var isAllow04 = $('#receive_check').is(":checked");

            medibox.methods.user.modify({
                id: id
                , pw: pw
                , name: name
                , event_yn: isAllow04 ? 'Y' : 'N'
            }, function(request, response){
                console.log('output : ' + response);
                if(!response.result){
                    alert(response.ment);
                    return false;
                }
                alert('수정되었습니다.');
            }, function(e){
                console.log(e);
            });
        }
        </script>


        <!-- 로그아웃 팝업창 -->
        <div id="popup06" class="popup">
            <div class="container">
                <div class="top">
                    <span>로그아웃하시겠습니까?</span>
                </div>
                <div class="bottom">
                    <a href="#!" onclick="logout()">예</a>
                    <a href="#!" class="close_btn">아니오</a>
                </div>
            </div>
        </div>
        <form method="post" id="logoutFrm" action="/user/logout/proccess">
            {{ csrf_field() }}
        </form>
        <script>
        function logout(){
            $('#logoutFrm').submit();
        }
        </script>


        <!-- 회원탈퇴 팝업창 -->
        <div id="popup07" class="popup">
            <div class="container">
                <div class="top">
                    <span>회원탈퇴를 하시겠습니까?</span>
                </div>
                <div class="bottom">
                    <a href="#!" onclick="leave()">예</a>
                    <a href="#!" class="close_btn">아니오</a>
                </div>
            </div>
        </div>
        <script>
        function leave(){
            if(!confirm('탈퇴를 하시겠습니까? 이 작업은 돌이킬 수 없습니다.')){
                return false;
            }
            medibox.methods.user.delete({
                id: {{session('user_seqno')}}
            }, function(request, response){
                console.log('output : ' + response);
                if(!response.result){
                    alert('탈퇴 중 오류가 발생하였습니다.');
                    return;
                }
                alert('탈퇴되었습니다.');
                logout();
            }, function(e){
                console.log(e);
            });
        }
        </script>
        
</body>
</html>
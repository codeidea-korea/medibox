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
            <button class="back" onclick="location.href='/user/login';">
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
                <span>회원가입</span>
            </div>
        </header>

        <section id="signUp">
            <form action="/terms/agreement" method="post" onsubmit="checkValidation()">
                {{ csrf_field() }}
                <!-- id -->
                <p>
                    <label for="id">아이디(휴대폰 번호)</label>
                    <input type="tel" name="id" id="id" placeholder="휴대폰 번호를 입력해주세요." onkeyup="checkValidationIdDupplicated()" pattern="[0-9]{3}-[0-9]{4}-[0-9]{4}" required>

                    <!-- 형식과 다르거나 중복 됐을 때 나오는 오류메시지 -->
                    <span id="id_error1">올바른 휴대폰 번호를 입력해주세요.</span>
                    <span id="id_error2">이미 가입되어있는 휴대폰 번호입니다.</span>
                </p>
                <!-- password -->
                <p>
                    <label for="pw">비밀번호</label>
                    <input type="password" name="pw1" id="pw_1" placeholder="비밀번호를 입력해주세요." onkeyup="checkValidationPassword()" pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,20}" required>

                    <!-- 형식과 다를 때 나오는 오류메시지 -->
                    <span id="pw_error1">영문, 숫자, 특수문자를 포함한 8~20자로 설정해주세요.</span>
                </p>
                <!-- password check -->
                <p>
                    <label for="pw">비밀번호 확인</label>
                    <input type="password" name="pw2" id="pw_2" placeholder="비밀번호를 입력해주세요." onkeyup="checkValidationPassword2()" required>

                    <!-- 비밀번호가 일치하지 않을 때 나오는 오류메시지 -->
                    <span id="pw_error2">비밀번호가 일치하지 않습니다.<span>
                </p>
                <!-- 다음 버튼 -->
                <button type="submit" id="next_btn">다음</button>
            </form>
        </section>

        
    <script src="{{ asset('user/js/jquery-3.6.0.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('user/js/medibox-apis.js') }}?v=2022012918"></script>
    <script>
        function hideValidationText(){
            $('#id_error1').hide();
            $('#id_error2').hide();
            $('#pw_error1').hide();
            $('#pw_error2').hide();
        }
        function checkValidationPassword(){
            var pw_1 = document.querySelector('#pw_1').value;
            var regx = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%*#?&])[A-Za-z\d$@$!%*#?&]{8,}$/;

            $('#pw_error1').hide();
            if (!pw_1 || pw_1 == '' || regx.test(pw_1) !== true) {
                $('#pw_error1').show();
                return false;
            }
            return true;
        }
        function checkValidationPassword2(){
            var pw_1 = document.querySelector('#pw_1').value;
            var pw_2 = document.querySelector('#pw_2').value;

            $('#pw_error2').hide();
            if (pw_1 != pw_2) {
                $('#pw_error2').show();
                return false;
            }
            return true;
        }
        var isDupplicated = false;
        function checkValidationIdDupplicated(){
            $('#id_error1').hide();
            $('#id_error2').hide();
            var regPhone = /^01([0|1|6|7|8|9])-?([0-9]{3,4})-?([0-9]{4})$/;
            var id = document.querySelector('#id').value;

            if (!id || id == '' || regPhone.test(id) !== true) {
                $('#id_error1').show();
                return false;
            }

            medibox.methods.user.isDupplicated({
                id: id
            }, function(request, response){
                console.log('output : ' + response);
                if(!response.result){
                    $('#id_error2').show();
                    isDupplicated = true;
                    return false;
                }
                $('#id_error2').hide();
                isDupplicated = false;
                return true;
            }, function(e){
                console.log(e);
            });
        }
        function checkValidation(){
            var id = document.querySelector('#id').value;
            var pw_1 = document.querySelector('#pw_1').value;
            var pw_2 = document.querySelector('#pw_2').value;
            var regPhone = /^01([0|1|6|7|8|9])-?([0-9]{3,4})-?([0-9]{4})$/;
            hideValidationText();

            if (!id || id == '' || regPhone.test(id) !== true) {
                $('#id_error1').show();
                return false;
            }
            if(isDupplicated) {
                $('#id_error2').show();
                return false;
            }
            if(checkValidationPassword()) {
                $('#pw_error1').show();
                return false;
            }
            if(checkValidationPassword2()) {
                $('#pw_error2').show();
                return false;
            }

            return true;
        }
        hideValidationText();
    </script>
</body>
</html>
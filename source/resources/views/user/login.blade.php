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
    
    <!-- 로그인 화면 -->
    <div id="login">
        <!-- 뒤로가기 버튼 -->
        <button class="back" onclick="history.back()">
            <svg xmlns="http://www.w3.org/2000/svg" width="24.705" height="24" viewBox="0 0 24.705 24">
                <g id="back_arrow" transform="translate(-22.295 -60)">
                  <rect id="사각형_207" data-name="사각형 207" width="24" height="24" transform="translate(23 60)" fill="none"/>
                  <g id="그룹_389" data-name="그룹 389" transform="translate(-0.231)">
                    <g id="그룹_388" data-name="그룹 388">
                      <line id="선_29" data-name="선 29" x2="22.655" transform="translate(23.845 72)" fill="none" stroke="#ffffff" stroke-miterlimit="10" stroke-width="1"/>
                      <path id="패스_174" data-name="패스 174" d="M3382.394,1143.563l-7.163,6.331" transform="translate(-3352 -1077.894)" fill="none" stroke="#fff" stroke-linecap="square" stroke-width="1"/>
                      <path id="패스_175" data-name="패스 175" d="M3375.231,1143.563l7.163,6.331" transform="translate(-3352 -1071.563)" fill="none" stroke="#fff" stroke-linecap="square" stroke-width="1"/>
                    </g>
                  </g>
                </g>
              </svg>
        </button>
        <div class="container">
            <!-- main_title -->
            <h2 class="main_title">MEDI BOX</h2>
            <p class="main_sub_title">
                특별한 당신을 위한<br>
                Health Care
            </p>
            <form method="post">
                <!-- login id -->
                <p>
                    <label for="id">아이디(휴대폰 번호)</label>
                    <input type="tel" name="id" pattern="[0-9]{3}[0-9]{4}[0-9]{4}" id="id" placeholder="휴대폰 번호를 입력해주세요." required>
                </p>
                <!-- login password -->
                <p>
                    <label for="pw">비밀번호</label>
                    <input type="password" name="pw" id="pw" placeholder="비밀번호를 입력해주세요." required>
                </p>
                <!-- login button -->
                <p>
                    <button type="button" onclick="login()" id="login_btn">로그인</button>
                </p>
            </form>
        </div>
        <div class="sign_up">
            <!-- sign up -->
            <span>
                아직 메디박스 회원이 아니신가요?
                <a href="/user/signup">회원가입하기</a>
            </span>
        </div>
    </div>

    <script src="{{ asset('user/js/jquery-3.6.0.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('user/js/medibox-apis.js') }}?v=2022012918"></script>
    <script>
        function checkValidation(){
            var id = document.querySelector('#id').value;
            var pw = document.querySelector('#pw').value;
            var regPhone = /^01([0|1|6|7|8|9])-?([0-9]{3,4})-?([0-9]{4})$/;

            if(!id || id == '') {
                alert('올바른 휴대폰 번호를 입력해주세요.');
                return false;
            }
            if (regPhone.test(id) !== true) {
                alert('올바른 휴대폰 번호를 입력해주세요.');
                return false;
            }
            if(!pw || pw == '' || pw.length < 4) {
                alert('비밀번호를 입력해주세요.');
                return false;
            }
            return true;
        }
        function login(){
            if(!checkValidation()) {
                return;
            }
            var id = document.querySelector('#id').value;
            var pw = document.querySelector('#pw').value;

            medibox.methods.user.login({
                id: id
                , pw: pw
            }, function(request, response){
                console.log('output : ' + response);
                if(!response.result){
                    alert(response.ment);
                    return false;
                }
                window.location.href = '/index';
            }, function(e){
                console.log(e);
            });
        }
    </script>

</body>
</html>
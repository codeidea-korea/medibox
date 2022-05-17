
@include('user.header')

	<!-- google 로그인 추가 -->
    <script src="https://apis.google.com/js/api:client.js" async defer></script>
	<!-- 네이버 로그인 추가 -->
  	<script type="text/javascript" src="https://static.nid.naver.com/js/naverLogin_implicit-1.0.3.js" charset="utf-8"></script>
	<!-- 카카오 로그인 추가 -->
  	<script type="text/javascript" src="https://developers.kakao.com/sdk/js/kakao.min.js"></script>
    
    <!-- 로그인 화면 -->
    <div id="login">
        <!-- 뒤로가기 버튼 -->
        <button class="back" onclick="location.href='/';">
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
                오직 당신을 위한<br>
                Health & Beauty care
            </p>
            <form method="post" action="/user/login/proccess" onsubmit="login()">
                {{ csrf_field() }}
                <!-- login id -->
                <p>
                    <label for="id">아이디(휴대폰 번호)</label>
                    <input type="tel" name="id" id="id" maxLength=13 placeholder="휴대폰 번호를 입력해주세요." required>
                </p>
                <!-- login password -->
                <p>
                    <label for="pw">비밀번호</label>
                    <input type="password" name="pw" id="pw" placeholder="비밀번호를 입력해주세요." required>
                </p>
                <!-- login button -->
                <p>
                    <button type="submit" id="login_btn">로그인</button>
                </p>
            </form>
            
            <!------------ 2차버전 추가 ------------>
            <!-- 아이디 찾기 & 비밀번호 찾기 & 회원가입 -->
            <!-- 
            <ul class="find">
                <li>
                    <a href="#" onclick="wait()">아이디 찾기</a>
                </li>
                <li>
                    <a href="#" onclick="wait()">비밀번호 찾기</a>
                </li>
                <li>
                    <a href="/user/signup">회원가입하기</a>
                </li>
            </ul>
            -->
            <!--
            <div class="social_login">
                <h4>
                    <span>간편로그인</span>
                </h4>
                <ul>
                    <li>
                        <a href="#!">
                            <img src="{{ asset('user/img/kakao.svg') }}" alt="카카오 로그인" id="loginKakao">
                        </a>
                    </li>
                    <li>
                        <a href="#!">
                            <img src="{{ asset('user/img/naver.svg') }}" alt="네이버 로그인" id="naver_id_login">
                        </a>
                    </li>
                    <li>
                        <a href="#!">
                            <img src="{{ asset('user/img/google.svg') }}" alt="구글 로그인" id="loginGoogle">
                        </a>
                    </li>
                </ul>
            </div>
            -->
            <!------------------------------------>

            <!--------------- 1차 ---------------->
            <!-- sign up -->
            <div class="sign_up">
                <span>
                    아직 메디박스 회원이 아니신가요?
                    <a href="/user/signup">회원가입하기</a>
                </span>
            </div> <!-- -->
            <!------------------------------------>
            
        </div>
    </div>

    <script src="{{ asset('user/js/jquery-3.6.0.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('user/js/medibox-apis.js') }}?v=2022012918"></script>
    <script>
        function wait(){
            alert('준비중입니다.');
        }
        var naver_id_login;
        function initSNSLogin(){
            Kakao.init('d4aeeca0375caae66d2a2aa8bfa2efd9');
			$('#loginKakao').off().on('click', function(){
			    location.href = 'https://kauth.kakao.com/oauth/authorize?client_id=d4aeeca0375caae66d2a2aa8bfa2efd9&redirect_uri=https://'+location.hostname+'/login/oauth/kakao&response_type=code';
			});
            // 구글 로그인
            setTimeout(() => {
                gapi.load('auth2', function() {
                    gapi.auth2.init({
                        client_id: '473022129853-9lub1aopq2814f7o4k31ek2t9qc81c5u.apps.googleusercontent.com'
//						, cookiepolicy: 'single_host_origin'
                        , scope: "profile email"
                        , ux_mode: 'redirect'
                        , redirect_uri: 'https://'+location.hostname+'/login/oauth/google'
                    });
                });
            }, 300);
            // 네이버 로그인
            naver_id_login = new naver_id_login("w6z6OE_m70O7AnhQJXAb", "https://"+location.hostname+"/login/oauth/naver");
            var state = naver_id_login.getUniqState();
            naver_id_login.setButton("white", 2,40);
            naver_id_login.setDomain(location.hostname);
            naver_id_login.setState(state);
            //  	naver_id_login.setPopup();
            naver_id_login.init_naver_id_login();
            $('#naver_id_login > a').html('&nbsp;');
        }
        function checkValidation(){
            var id = document.querySelector('#id').value;
            var pw = document.querySelector('#pw').value;
            var regPhone = /^01([0|1|6|7|8|9])-?([0-9]{3,4})-?([0-9]{4})$/;

            if(!id || id == '') {
                alert('올바른 휴대폰 번호를 입력해주세요.');
                return false;
            }
            /*
            if (regPhone.test(id) !== true) {
                alert('올바른 휴대폰 번호를 입력해주세요.');
                return false;
            }
            */
            if(!pw || pw == '' || pw.length < 4) {
                alert('비밀번호를 입력해주세요.');
                return false;
            }
            return true;
        }
        function login(){
            if(!checkValidation()) {
                return false;
            }
            /*
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
                localStorage.setItem('userKey', JSON.parse(request).id);
                window.location.href = '/index';
            }, function(e){
                console.log(e);
            });
            */
            return true;
        }
    </script>

@include('user.footer')

</body>
</html>
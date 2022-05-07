
@include('user.header')
    
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
        <form action="signup2.html" method="post">
            <!-- id -->
            <div>
                <!-- 22.03.21 태그 수정 -->
                <!-- <label for="id">아이디(휴대폰 번호)</label> -->
                <h2>아이디(휴대폰 번호)</h2>
                <span class="cNum">
                    <input type="text" name="id" id="id" placeholder="휴대폰 번호를 입력해주세요." pattern="[0-9]{3}[0-9]{4}[0-9]{4}" required>

                    <!-------------- 22.03.19 수정 --------------->
                    <!-- <button type="button" id="getNum">인증번호 받기</button> -->


                    <!-- 버튼 비활성화 -->
                    <button type="button" id="getNum" class="signup_btn">인증번호 받기</button>
                    <!-- 버튼 활성화 -->
                    <!-- <button type="button" id="getNum" class="signup_btn on">인증번호 받기</button> -->
                    <!-- ------------------------------------- -->

                </span>

                <!-- 인증번호 발송 메세지 -->
                <span id="cNum_message">
                    인증번호 발송을 요청했습니다. 인증번호가 오지 않으면 입력정보가 정확한지 다시 확인해주세요.
                </span>

                <!-- 형식과 다르거나 중복 됐을 때 나오는 오류메시지 -->
                <!-- <span id="id_error1">올바른 휴대폰 번호를 입력해주세요.</span> -->
                <!-- 22.03.09 수정 -->
                <!-- <span id="id_error2">이미 가입되어있는 휴대폰 번호입니다.</span> -->
            </div>

            <!-- 인증번호 -->
            <div>
                <!-- 22.03.21 태그 수정 -->
                <!-- <label for="cNum">인증번호</label> -->
                <h2>인증번호</h2>
                <span class="cNum">
                    <input type="password" name="cNum" id="cNum" placeholder="인증번호 입력"
                        pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,20}" required>

                    <!-------------- 22.03.19 수정 --------------->
                    <!-- <button type="button" id="numCheck">확인</button> -->


                    <!-- 버튼 비활성화 -->
                    <button type="button" id="numCheck" class="signup_btn">확인</button>
                    <!-- 버튼 활성화 -->
                    <!-- <button type="button" id="numCheck" class="signup_btn on">확인</button> -->
                    <!-- ------------------------------------- -->

                </span>

                <!-- 형식과 다를 때 나오는 오류메시지 -->
                <span class="cNumCount_wrap">
                    <span id="cNumCount">02:58</span>
                    <span>인증번호는 3분 이내 입력해야합니다. 제한시간이 지났을 경우, 인증번호를 다시 받아주세요.</span>
                </span>
            </div>

            
            <!-- 버튼 비활성화 -->
            <button type="submit" id="next_btn" class="btn">다음</button>
            <!-- 버튼 활성화 -->
            <!-- <button type="submit" id="next_btn" class="btn on">다음</button> -->
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
            $('#name_error1').hide();
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
            var name = document.querySelector('#name').value;
            var regPhone = /^01([0|1|6|7|8|9])-?([0-9]{3,4})-?([0-9]{4})$/;
            hideValidationText();

            if (!id || id == '' || regPhone.test(id) !== true) {
                $('#id_error1').show();
                return false;
            }
            if (!name || name == '') {
                $('#name_error1').show();
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
@include('user.footer')

</body>
</html>
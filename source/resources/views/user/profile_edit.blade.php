
@include('user.header')
    
        <!-- header -->
        <header id="header">
            <!-- 뒤로가기 버튼 -->
            <button class="back" onclick="history.back();">
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
                <!--------------- 1차 ---------------->
                <!-- <span>마이페이지</span> -->
                <!------------------------------------>

                <!------------ 2차버전 추가 ------------>
                <span>프로필</span>
                <!------------------------------------>
            </div>

            <button class="edit" onclick="modify()">
                <!-- 22.03.20 (내용 수정) -->
                <!-- <span>수정</span> -->
                <span>저장</span>
            </button>
        </header>

        <!--------------- 1차 ---------------->
        <section id="myPage">
        <!------------------------------------>

        <!------------ 2차버전 수정 ------------>
        <!--  <section id="myPage"> -->
        <!------------------------------------>



            <!-- * p태그로 감싼 부분 전부 div박스로 변경 * -->
            <form>
                <!-- id -->
                <!--------------- 1차 ---------------->
                <!-- <p>
                    <label for="id">아이디(휴대폰 번호)</label>
                    <input type="tel" name="id" id="id" placeholder="휴대폰 번호를 입력해주세요." pattern="[0-9]{3}[0-9]{4}[0-9]{4}" required>
                </p> -->
                <!------------------------------------>

                <!------------ 2차버전 수정 [ p태그 -> div태그, label태그 -> h2태그 ] ------------>
                <div>
                    <h2>아이디(휴대폰 번호)</h2>
                    <input type="tel" name="id" id="id" placeholder="휴대폰 번호를 입력해주세요." value="{{$user->id}}" required>
                </div>
                <!------------------------------------>                


                
                <!------------ 2차버전 추가 ------------>
                <!-- 이름 -->
                <div>
                    <h2>이름</h2>
                    <input type="text" name="user_name" id="user_name" value="{{$user->name}}" placeholder="이름을 입력해주세요.">
                </div>
                
                <!-- 성별 -->
                <div class="sex_select">
                    <h2>성별</h2>
                    <input type="radio" name="sex" value="W" id="w" 
                    @if ($user->gender == 'W') 
                    checked
                    @endif >
                    <label for="w">여자</label>
                    <input type="radio" name="sex" value="M" id="m"
                    @if ($user->gender == 'M') 
                    checked
                    @endif>
                    <label for="m">남자</label>
                </div>
                
                <!-- 최초추천샵 -->
                <div class="shop_select">
                    <h2>최초추천샵</h2>
                    <div class="select_wrap">
                        <div class="select_box">
                            <span>
                    @if ($user->recommended_shop == '') 
                    최초추천샵 선택하기
                    @else
                    {{$user->recommended_shop}}
                    @endif</span>
                            <img src="/user/img/arrow_bottom.svg" alt="">
                        </div>
                        <ul class="option">
                            <li onclick="changeRecommendedShop('포레스타 블랙')">포레스타 블랙</li>
                            <li onclick="changeRecommendedShop('바라는 네일')">바라는 네일</li>
                            <li onclick="changeRecommendedShop('딥포커스 검안센터')">딥포커스 검안센터</li>
                            <li onclick="changeRecommendedShop('발몽스파')">발몽스파</li>
                            <li onclick="changeRecommendedShop('미니쉬 도수')">미니쉬 도수</li>
                            <li onclick="changeRecommendedShop('미니쉬 스파')">미니쉬 스파</li>
                            <li onclick="changeRecommendedShop('미니쉬 치과병원')">미니쉬 치과병원</li>
                            <li onclick="changeRecommendedShop('기타')">기타</li>
                        </ul>
                    </div>
                </div>
                <input type="hidden" name="recommended_shop" id="recommended_shop" value="{{$user->recommended_shop}}">
                
                <!-- 추천인코드 -->
                <div>
                    <h2>추천인코드(선택)</h2>
                    <input type="tel" name="recommended_code" id="recommended_code" placeholder="추천인 휴대폰번호를 입력해주세요." value="{{$user->recommended_code}}">
                </div>
                <!------------------------------------>



                <!-- password -->
                <!--------------- 1차 ---------------->
                <!-- <p>
                    <label for="pw">비밀번호</label>
                    <input type="password" name="pw" id="pw_1" placeholder="비밀번호를 입력해주세요." pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,20}" required>
                </p> -->
                <!------------------------------------>

                <!------------ 2차버전 수정 [ p태그 -> div태그, label태그 -> h2태그(+내용변경) ] ------------>
                <div>
                    <h2>기존 비밀번호</h2>
                    <input type="password" name="pw" id="pw_1" placeholder="비밀번호를 입력해주세요." pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,20}" value="{{$user->pw}}" required>
                </div>
                <!------------------------------------>
                



                <!-- edit password -->
                <!--------------- 1차 ---------------->
                <!-- <p>
                    <label for="pw">비밀번호 수정</label>
                    <input type="password" name="pw" id="pw_2" placeholder="비밀번호를 입력해주세요." pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,20}" required> -->

                    <!-- 형식과 다를 때 나오는 오류메시지 -->
                    <!-- <span id="id_error1">영문, 숫자, 특수문자를 포함한 8~20자로 설정해주세요.</span>
                </p> -->
                <!------------------------------------>

                <!------------ 2차버전 수정 [ p태그 -> div태그, label태그 -> h2태그(+내용변경) ] ------------>
                <div>
                    <h2>새로운 비밀번호</h2>
                    <input type="password" name="pw" id="pw_2" onkeyup="checkValidationPassword()" placeholder="비밀번호를 입력해주세요." pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,20}" required>

                    <!-- 형식과 다를 때 나오는 오류메시지 -->
                    <span id="pw_error1">영문, 숫자, 특수문자를 포함한 8~20자로 설정해주세요.</span>
                </div>
                <!------------------------------------>




                <!-- edit password check -->
                <!--------------- 1차 ---------------->
                <!-- <p>
                    <label for="pw">비밀번호 확인</label>
                    <input type="password" name="pw" id="pw_3" placeholder="비밀번호를 입력해주세요." required> -->

                    <!-- 비밀번호가 일치하지 않을 때 나오는 오류메시지 -->
                    <!-- <span id="id_error1">비밀번호가 일치하지 않습니다.<span>
                </p> -->
                <!------------------------------------>

                <!------------ 2차버전 수정 [ p태그 -> div태그, label태그 -> h2태그(+내용변경) ] ------------>
                <div>
                    <h2>새로운 비밀번호 확인</h2>
                    <input type="password" name="pw" id="pw_3" onkeyup="checkValidationPassword2()" placeholder="비밀번호를 입력해주세요." required>

                    <!-- 비밀번호가 일치하지 않을 때 나오는 오류메시지 -->
                    <span id="pw_error2">비밀번호가 일치하지 않습니다.<span>
                </div>
                <!------------------------------------>



                <!--------------- 1차 ---------------->
                <!-- <p>
                    <label for="user_name">이름</label>
                    <input type="text" name="user_name" id="user_name" placeholder="이름을 입력해주세요.">
                </p> -->
                <!------------------------------------>


    

                <!-- 수신 동의 체크박스 -->
                <!--------------- 1차 ---------------->
                <!-- <p class="receive_check">
                    <label for="receive_check">수신 동의</label>
                    <input type="checkbox" name="receive_check" id="receive_check" required>
                    <label for="receive_check">이벤트 정보 수신 동의</label>
                </p> -->
                <!------------------------------------>

                <!------------ 2차버전 수정,추가 [ p태그 -> div태그, label태그 -> h2태그(+내용변경) ] ------------>
                <div class="receive_check">
                    <h2>이벤트 정보 수신 동의(선택)</h2>
                    <input type="checkbox" name="push_check" id="push_check" @if ($user->push_yn == 'Y') checked @endif>
                    <label for="push_check">PUSH 알림</label>
                    <input type="checkbox" name="email_check" id="email_check" @if ($user->email_yn == 'Y') checked @endif>
                    <label for="email_check">이메일</label>
                    <input type="checkbox" name="sns_check" id="sns_check" @if ($user->sns_yn == 'Y') checked @endif>
                    <label for="sns_check">SNS</label>
                </div>
                <!------------------------------------>
            </form>

            <!-- 약관 및 정책 -->
            <div class="policy_wrap">
                <a href="/terms/policy">약관 및 정책</a>
            </div>

            <!-- 로그아웃 & 회원탈퇴 -->
            <div class="logout_wrap">
                <a href="#!" id="logout" onclick="logoutConfirm()">로그아웃</a>
                <a href="#!" id="withdrawal" onclick="signoutConfirm()">회원탈퇴하기</a>
            </div>
        </section>

	    <script type="text/javascript" src="{{ asset('user/js/medibox-apis.js') }}?v=2022012918"></script>
        <script>
        $('#pw_error1').hide();
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
        function changeRecommendedShop(val){
            $('input[name=recommended_shop]').val(val);
        }
        function modify(){
            if(!checkValidation()) {
                return;
            }
            var id = document.querySelector('#id').value;
            var pw = document.querySelector('#pw_1').value;
            var pw2 = document.querySelector('#pw_2').value;
            if (!pw2 || pw2 == '') {
                pw2 = pw;
            }
            var name = document.querySelector('#user_name').value;
            var isAllow04 = $('#receive_check').is(":checked");
            var recommended_shop = document.querySelector('#recommended_shop').value;
            var recommended_code = document.querySelector('#recommended_code').value;
            
            var push_check = $('#push_check').is(":checked");
            var email_check = $('#email_check').is(":checked");
            var sns_check = $('#sns_check').is(":checked");
            var gender = $('input[name=sex]:checked').val();

            medibox.methods.user.modify({
                id: id
                , pw: pw
                , pw2: pw2
                , name: name
                , recommended_shop: recommended_shop
                , recommended_code: recommended_code
                , event_yn: isAllow04 ? 'Y' : 'N'
                , gender: gender
                , push_yn: push_check ? 'Y' : 'N'
                , email_yn: email_check ? 'Y' : 'N'
                , sns_yn: sns_check ? 'Y' : 'N'
            }, function(request, response){
                console.log('output : ' + response);
                if(!response.result){
                    alert(response.ment);
                    return false;
                }
                $('#popup09').addClass('on');
            }, function(e){
                console.log(e);
            });
        }
        $(document).ready(function(){
            $('.popup a').off();
            setTimeout(() => {
                $('.popup a').off();
            }, 50);
        });
        </script>


        <!-- 로그아웃 팝업창 -->
        <div id="popup06" class="popup">
            <div class="container">
                <div class="top">
                    <!--------------- 1차 ---------------->
                    <!-- <span>로그아웃하시겠습니까?</span> -->
                    <!------------------------------------>

                    <!------------ 2차버전 수정 ------------>
                    <strong class="popup_icon_check popup_icon">check</strong>
                    <span>
                        로그아웃되었습니다.<br>
                        메인페이지로 이동합니다.
                    </span>
                    <!------------------------------------>
                </div>
                <div class="bottom">
                    <!--------------- 1차 ---------------->
                    <!-- <a href="#!">예</a>
                    <a href="#!" class="close_btn">아니오</a> -->
                    <!------------------------------------>

                    <!------------ 2차버전 수정 ------------>
                    <a href="#!" onclick="logout()">확인</a>
                    <!------------------------------------>
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
        function logoutConfirm(){
            $('#popup10').addClass('on');
        }
        function signoutConfirm(){
            $('#popup07').addClass('on');
        }
        function closePop(){
            $('.popup.select').removeClass('on');
        }
        </script>


        <!-- 회원탈퇴 팝업창 -->
        <div id="popup07" class="popup">
            <div class="container">
                <div class="top">
                    <span>회원탈퇴를 하시겠습니까?</span>
                    <!------------ 2차버전 추가 ------------>
                    <span class="des">
                        확인버튼 클릭 시 탈퇴되며, 포인트와<br>
                        저장된 정보는 모두 삭제됩니다.
                    </span>
                    <!------------------------------------>
                </div>
                <div class="bottom">
                    <!--------------- 1차 ---------------->
                    <!-- <a href="#!">예</a>
                    <a href="#!" class="close_btn">아니오</a> -->
                    <!------------------------------------>
                        
                    <!------------ 2차버전 수정 ------------>
                    <a href="#!" class="close_btn" onclick="closePop()">아니오</a>
                    <a href="#!" onclick="leave()">예</a>
                    <!------------------------------------>       
                </div>
            </div>
        </div>
        <!------------ 2차버전 추가 ------------>
        <!-- 회원탈퇴 예 선택 후 팝업창 -->
        <!-- 22.03.11 수정 -->
        <!-- <div id="popup08" class="popup"> -->
        <div id="popup08" class="popup select">
            <div class="container">
                <div class="top">
                    <span>메디박스를<br>
                        이용해주셔서 감사합니다.<br>
                        더 좋은 서비스로<br>
                        보답드리겠습니다.</span>
                </div>
                <div class="bottom">
                    <a href="#!" onclick="logout()">확인</a>
                </div>
            </div>
        </div>
        

        <!-- 정보 수정 완료 팝업창 -->
        <div id="popup09" class="popup">
            <div class="container">
                <div class="top">
                    <strong class="popup_icon_check popup_icon">check</strong>
                    <span>
                        정보가 수정되었습니다.
                    </span>
                </div>
                <div class="bottom">
                    <a href="/profile">확인</a>
                </div>
            </div>
        </div>


        <!-- 로그아웃 확인 팝업창 -->
        <!-- 22.03.11 수정 -->
        <!-- <div id="popup10" class="popup"> -->
        <div id="popup10" class="popup select">
            <div class="container">
                <div class="top">
                    <span>로그아웃하시겠습니까?</span>
                </div>
                <div class="bottom">
                    <a href="#!" class="close_btn" onclick="closePop()">아니오</a>
                    <a href="#!" onclick="logout()">네</a>
                </div>
            </div>
        </div>
        <!------------------------------------>        

        <script>
        function leave(){
            medibox.methods.user.delete({
                id: {{session('user_seqno')}}
            }, function(request, response){
                console.log('output : ' + response);
                if(!response.result){
                    alert('탈퇴 중 오류가 발생하였습니다.');
                    return;
                }
                $('#popup08').addClass('on');
            }, function(e){
                console.log(e);
            });
        }
        </script>
        
@include('user.footer')

</body>
</html>
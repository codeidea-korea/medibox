
@include('user.header2')

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
            <span>비밀번호 변경</span>
        </div>
    </header>

    <!-- 22.03.19 수정 -->
    <!-- <section id="change_pw"> -->
    <section id="signUp">
        <form action="#!" method="post">
            <!-- password -->
            <div>
                <h2>새로운 비밀번호</h2>

                <!-- 22.03.19 수정 (placeholder 내용 변경) -->
                <!-- <input type="password" name="pw" id="pw_1" placeholder="비밀번호를 입력해주세요." pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,20}" required> -->
                
                <input type="password" name="pw" id="pw_1" placeholder="새로운 비밀번호를 입력해주세요." onkeyup="checkAllChoose()" pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,20}" required>
                <!-- ----------------------------------- -->

                <!-- 22.03.19 수정 (id 수정) -->
                <!-- 형식과 다를 때 나오는 오류메시지 -->
                <!-- <span id="id_error1">영문, 숫자, 특수문자를 포함한 8~20자로 설정해주세요.</span> -->
                <span id="pw_error1">비밀번호는 8자 이상  숫자, 알파벳, 특수기호를 혼합하여 입력해주세요.</span>
            </div>

            <!-- password check -->
            <div>
                <h2>새로운 비밀번호 확인</h2>

                <!-- 22.03.19 수정 (placeholder 내용 변경) -->
                <!-- <input type="password" name="pw" id="pw_2" placeholder="비밀번호를 입력해주세요." required> -->

                <input type="password" name="pw" id="pw_2" placeholder="새로운 비밀번호를 다시 입력해주세요." onkeyup="checkAllChoose()" required>
                <!-- ----------------------------------- -->

                <!-- 22.03.19 수정 (id 수정) -->
                <!-- 비밀번호가 일치하지 않을 때 나오는 오류메시지 -->
                <!-- <span id="id_error1">비밀번호가 일치하지 않습니다.<span> -->
                <span id="pw_error2">비밀번호가 일치하지 않습니다.<span>
            </div>


            <!-- 22.03.19 수정 -->

            <!-- 완료 버튼 -->
            <!-- 버튼 비활성화 -->
            <button type="button" id="complete_btn" class="btn" onclick="modifyPassword()">완료</button>
            <!-- 버튼 활성화 -->
            <!-- <button type="submit" id="complete_btn" class="btn on">완료</button> -->

            <!-- ------------ -->
        </form>
    </section>  
    <script>
        function checkValidationPassword(){
            var pw_1 = document.querySelector('#pw_1').value;
            var regx = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%*#?&])[A-Za-z\d$@$!%*#?&]{8,}$/;

            $('#pw_error1').hide();
            $('#pw_1').removeClass('on');
            if (!pw_1 || pw_1 == '' || regx.test(pw_1) !== true) {
                $('#pw_error1').show();
                $('#pw_1').addClass('on');
                return false;
            }
            return true;
        }
        function checkValidationPassword2(){
            var pw_1 = document.querySelector('#pw_1').value;
            var pw_2 = document.querySelector('#pw_2').value;

            $('#pw_error2').hide();
            $('#pw_2').removeClass('on');
            if (pw_1 != pw_2) {
                $('#pw_error2').show();
                $('#pw_2').addClass('on');
                return false;
            }
            return true;
        }
        function checkAllChoose(){
            if(!checkValidationPassword()) {
                $('#next_btn').removeClass('on');
                return false;
            }
            if(!checkValidationPassword2())  {
                $('#next_btn').removeClass('on');
                return false;
            }
            $('#complete_btn').addClass('on');
        }
        function hideValidationText(){
            $('#pw_error1').hide();
            $('#pw_error2').hide();
        }
        function modifyPassword(){
            // 실제 비밀번호 변경 처리
            if(!$('#complete_btn').hasClass('on')){
                return false;
            }
            var user_password = document.querySelector('#pw_1').value;

            medibox.methods.user.changePassword({
                seqno: {{$userInfo->user_seqno}},
                user_phone: "{{$userInfo->user_phone}}",
                user_password: user_password
            }, function(request, response){
                console.log('output : ' + response);
                if(!response.result){
                    alert(response.ment);
                    return false;
                }
                alert('비밀번호가 변경되었습니다. 로그인하여 주세요.');
                location.href = '/user/login';
                return true;
            }, function(e){
                console.log(e);
            });
        }
        $('.popup a').off();
        $('#complete_btn').off()
        hideValidationText();
    </script>
@include('user.footer')
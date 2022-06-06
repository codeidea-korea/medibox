
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
            <span>비밀번호 찾기</span>
        </div>
    </header>

    <!-- 22.03.19 수정 -->
    <!-- <section id="find_pw"> -->
    <section id="signUp">
        <form id="passwordFrm" action="#!" method="post">
                {{ csrf_field() }}
            <!-- id -->
            <div> 
                <h2>아이디(휴대폰 번호)</h2>

                <span class="cNum">
                    <input type="tel" name="phoneNo" id="id" placeholder="휴대폰 번호를 입력해주세요." 
                        required>

                    <!-------------- 22.03.19 수정 --------------->
                    <!-- <button type="button" id="getNum">인증번호 받기</button> -->


                    <!-- 버튼 비활성화 -->
                    <button type="button" id="getNum" class="signup_btn" onclick="sendSmsAuth()">인증번호 받기</button>
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
                <!-- <span id="id_error2">이미 가입되어있는 휴대폰 번호입니다.</span> -->
            </div>

            <!-- password -->
            <div class="_authCheck">
                <h2>인증번호</h2>
                <span class="cNum">
                    <input type="password" name="authCode" id="cNum" placeholder="인증번호 입력" required>

                    <!-------------- 22.03.19 수정 --------------->
                    <!-- <button type="button" id="numCheck">확인</button> -->


                    <!-- 버튼 비활성화 -->
                    <button type="button" id="numCheck" class="signup_btn" onclick="confirmAuthCodeSMS()">확인</button>
                    <!-- 버튼 활성화 -->
                    <!-- <button type="button" id="numCheck" class="signup_btn on">확인</button> -->
                    <!-- ------------------------------------- -->
                    
                </span>

                <!-- 형식과 다를 때 나오는 오류메시지 -->
                <span class="cNumCount_wrap">
                    <span id="cNumCount" class="_timer">02:58</span>
                    <span>인증번호는 3분 이내 입력해야합니다. 제한시간이 지났을 경우, 인증번호를 다시 받아주세요.</span>
                </span>
            </div>

            <input type="hidden" id="userID" name="userID">
            <!-- 다음 버튼 -->
            <!-- 버튼 비활성화 -->
            <button type="button" id="next_btn" class="btn" onclick="gotoModifyPassword()">다음</button>
            <!-- 버튼 활성화 -->
            <!-- <button type="submit" id="next_btn" class="btn on">다음</button> -->
        </form>
    </section>


    <!-- 인증이 완료되었습니다. -->
    <div id="popup11" class="popup">
        <div class="container">
            <div class="top">
                <strong class="popup_icon popup_icon_check">check</strong>
                <span>인증이 완료되었습니다.</span>
            </div>
            <div class="bottom">
                <a href="#!">확인</a>
            </div>
        </div>
    </div>
    <script>
    $('._timer').hide();
    $('._authCheck').hide();
    $('#cNum_message').hide();

    var timerAuthCode;
    var timerCnt = 0;
    var maxTime = 180;
    var isAllowed = false;

    function sendSmsAuth(target)
    {
        const phoneNo = $('input[name=phoneNo]').val();
        
        if(!phoneNo || phoneNo == '' || phoneNo.length < 11)
        {
            alert('올바른 핸드폰 번호를 입력해주세요.');
            return false;
        }
        $('._timer').show();
        $('._authCheck').show();
        $('#cNum_message').show();

        // 회원 가입 여부 부터 확인
        
        medibox.methods.user.isDupplicated({
            id: phoneNo
        }, function(req, res){
            console.log('output : ' + res);
            if(res.result){
                $('#popup15').addClass('on');
                return false;
            }
            medibox.methods.sms.sendAuth({
                phoneNo: phoneNo
            }, function(request, response){
                console.log('output : ' + response);
                if(!response.result){
                    alert(response.ment);
                    return false;
                }

                if(timerAuthCode) clearInterval(timerAuthCode);
                timerCnt = 0;
                var tmpTxtTime = Math.floor((maxTime-timerCnt) / 60) + ':' + ((maxTime-timerCnt) % 60 < 10 ? '0' : '') + (maxTime-timerCnt) % 60;
                $('._timer').text( tmpTxtTime );
                timerAuthCode = setInterval(function (){
                    if(timerCnt >= maxTime)
                    {
                        alert('인증시간이 만료되었습니다. 다시 인증 요청하여 주시길 바랍니다.');
                        isAllowed = false; 
                        if(timerAuthCode) clearInterval(timerAuthCode);				
                        $('._timer').text( '00:00' );
                        return;
                    }
                    timerCnt = timerCnt + 1;
                    var txtTime = Math.floor((maxTime-timerCnt) / 60) + ':' + ((maxTime-timerCnt) % 60 < 10 ? '0' : '') + (maxTime-timerCnt) % 60;
                    $('._timer').text( txtTime );
                }, 1000);
                $('input[name=authCode]').removeAttr('disabled');
                $('._timer').show();
                alert('인증번호를 발송하였습니다.');
            }, function(e){
                console.log(e);
                alert('서버 통신 오류');
            });
            return true;
        }, function(e){
            console.log(e);
        });
    }
    function confirmAuthCodeSMS()
    {
        isAllowed = false; 
        if(timerAuthCode) clearInterval(timerAuthCode);
        
        var phoneNo = $('input[name=phoneNo]').val();
        var authCode = $('input[name=authCode]').val();
        $('input[name=authCode]').attr('disabled', 'disabled');
        
        if(!phoneNo || phoneNo == '' || phoneNo.length < 11)
        {
            alert('올바른 핸드폰 번호를 입력해주세요.');
            return false;
        }
        if(!authCode || authCode == ''){
            alert('문자로 발송된 인증코드를 입력해주세요.');
            return false;
        }
        
        medibox.methods.sms.checkAuth({
            phoneNo: phoneNo
            , auth_code: authCode
        }, function(request, response){
            console.log('output : ' + response);
            if(!response.result){
                alert('인증코드가 일치하지 않습니다.');
                return false;
            }
            $('#userID').val(response.userInfo.user_phone);
            $('#next_btn').addClass('on'); 
        }, function(e){
            console.log(e);
                alert('서버 통신 오류');
        });
        return true;
    }
    function gotoModifyPassword(){
        // 실제 비밀번호 변경 처리
        if(!$('#next_btn').hasClass('on')){
            return false;
        }
        $('#passwordFrm').attr("action", "/user/login/change-password");
        $('#passwordFrm').submit();
    }
    $('.popup a').off();
    </script>

    @include('user.footer')

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
            <form action="/terms/agreement" method="post" onsubmit="return checkValidation()">
                {{ csrf_field() }}
                <!-- id -->
                <div>
                    <!-- 22.03.20 (태그 수정) -->
                    <!-- <label for="id">아이디(휴대폰 번호)</label> -->
                    <h2>아이디(휴대폰 번호)</h2>
                    <!-- 22.03.11 type 수정, pattern 추가 -->
                    <!-- <input type="tel" name="id" id="id" placeholder="휴대폰 번호를 입력해주세요." pattern="[0-9]{3}[0-9]{4}[0-9]{4}" required> -->
                    <input type="text" name="id" id="id" placeholder="휴대폰 번호를 입력해주세요." maxLength=13 onkeyup="checkValidationIdDupplicated()" required>

                    <!-- 형식과 다르거나 중복 됐을 때 나오는 오류메시지 -->
                    <span id="id_error1">올바른 휴대폰 번호를 입력해주세요.</span>
                    <span id="id_error2">이미 가입되어있는 휴대폰 번호입니다.</span>
                    <!-- 22.03.09 수정 -->
                    <!-- <span id="id_error2">이미 가입되어있는 휴대폰 번호입니다.</span> -->
                </div>
                <div>
                    <!-- 22.03.20 (태그 수정) -->
                    <!-- <label for="pw">비밀번호</label> -->
                    <h2>이름</h2>
                    <input type="text" name="name" id="name" placeholder="이름을 입력해주세요." required onkeyup="checkAllChoose()">
                    <span id="name_error1">이름을 입력해주세요.</span>
                </div>
                <!-- password -->
                <div>
                    <!-- 22.03.20 (태그 수정) -->
                    <!-- <label for="pw">비밀번호 확인</label> -->
                    <h2>비밀번호</h2>
                    <input type="password" name="pw1" id="pw_1" placeholder="비밀번호를 입력해주세요." onkeyup="checkAllChoose()" pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,20}" required>

                    <!-- 형식과 다를 때 나오는 오류메시지 -->
<!--                    <span id="pw_error1">영문, 숫자, 특수문자를 포함한 8~20자로 설정해주세요.</span> -->
                    <span id="pw_error1">비밀번호는 8자 이상  숫자, 알파벳, 특수기호를 혼합하여 입력해주세요.</span>
                </div>
                <!-- password check -->
                <div>
                    <h2>비밀번호 확인</h2>
                    <input type="password" name="pw2" id="pw_2" placeholder="비밀번호를 입력해주세요." onkeyup="checkAllChoose()" required>

                    <!-- 비밀번호가 일치하지 않을 때 나오는 오류메시지 -->
                    <span id="pw_error2">비밀번호가 일치하지 않습니다.<span>
                </div>
                <!-- 2022.03.07 추가 -->
                <!-- 최초추천샵 -->
                <div class="shop_select">
                    <h2>최초추천샵</h2>
                    <div class="select_wrap">
                        <div class="select_box">
                            <span>최초추천샵 선택하기</span>
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
                    <input type="hidden" name="recommended_shop">
                </div>

                <!-- 추천인코드 -->
                <div>
                    <h2>추천인코드(선택)</h2>
                    <input type="text" name="recommended_code" id="recommended_code" placeholder="추천인 휴대폰번호를 입력해주세요.">
                </div>                
                <!-- 다음 버튼 -->
                <!-- 22.03.18 수정 -->
                <!-- <button type="submit" id="next_btn" disabled>다음</button> -->

                <!-- 버튼 비활성화 -->
                <button type="submit" id="next_btn" class="btn">다음</button>
                <!-- 버튼 활성화 -->
                <!-- <button type="submit" id="next_btn" class="btn on">다음</button> -->
            </form>
        </section>

        
    <script src="{{ asset('user/js/jquery-3.6.0.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('user/js/medibox-apis.js') }}?v=2022012918"></script>
    <script>
        function checkAllChoose(){
            if(!checkValidationPassword()) {
                $('#next_btn').removeClass('on');
                return false;
            }
            if(!checkValidationPassword2())  {
                $('#next_btn').removeClass('on');
                return false;
            }
            var id = document.querySelector('#id').value;
            if(isDupplicated || !id || id == '')  {
                $('#next_btn').removeClass('on');
                return false;
            }
            if(!checkValidationName())  {
                $('#next_btn').removeClass('on');
                return false;
            }
            var shop = $('input[name=recommended_shop]').val();
            if(!shop || shop == '')  {
                $('#next_btn').removeClass('on');
                return false;
            }
            $('#next_btn').addClass('on');
        }
        function changeRecommendedShop(val){
            $('input[name=recommended_shop]').val(val);
            checkAllChoose();
        }
        function hideValidationText(){
            $('#id_error1').hide();
            $('#id_error2').hide();
            $('#pw_error1').hide();
            $('#pw_error2').hide();
            $('#name_error1').hide();

            $('#id').removeClass('on');
            $('#name').removeClass('on');
            $('#pw_1').removeClass('on');
            $('#pw_2').removeClass('on');
        }
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
        function checkValidationName(){
            var name = document.querySelector('#name').value;
            $('#name').removeClass('on');
            $('#name_error1').hide();

            if (!name || name == '') {
                $('#name_error1').show();
                $('#name').addClass('on');
                return false;
            }
            return true;
        }
        var isDupplicated = false;
        function checkValidationIdDupplicated(){
            $('#id_error1').hide();
            $('#id_error2').hide();
            $('#id').removeClass('on');
            var regPhone = /^01([0|1|6|7|8|9])-?([0-9]{3,4})-?([0-9]{4})$/;
            var id = document.querySelector('#id').value;

            if (!id || id == '' || regPhone.test(id) !== true) {
                $('#id').addClass('on');
                $('#id_error1').show();
                return false;
            }

            medibox.methods.user.isDupplicated({
                id: id
            }, function(request, response){
                console.log('output : ' + response);
                if(!response.result){
                    $('#next_btn').removeClass('on');
                    $('#id_error2').show();
                    $('#id').addClass('on');
                    isDupplicated = true;
                    return false;
                }
                $('#id_error2').hide();
                $('#id').removeClass('on');
                isDupplicated = false;
                checkAllChoose();
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
            var recommended_code = document.querySelector('#recommended_code').value;
            var regPhone = /^01([0|1|6|7|8|9])-?([0-9]{3,4})-?([0-9]{4})$/;
            hideValidationText();

            $('#id').removeClass('on');
            $('#name').removeClass('on');
            $('#pw_1').removeClass('on');
            $('#pw_2').removeClass('on');

            if (!id || id == '' || regPhone.test(id) !== true) {
                $('#id_error1').show();
                $('#id').addClass('on');
                return false;
            }
            if (!name || name == '') {
                $('#name_error1').show();
                $('#name').addClass('on');
                return false;
            }
            if(isDupplicated) {
                $('#id_error2').show();
                $('#id').addClass('on');
                return false;
            }
            if(!checkValidationPassword()) {
                $('#pw_error1').show();
                $('#pw_1').addClass('on');
                return false;
            }
            if(!checkValidationPassword2()) {
                $('#pw_error2').show();
                $('#pw_2').addClass('on');
                return false;
            }
            if(!$('#next_btn').hasClass('on')) {
                return false;
            }
            var shop = $('input[name=recommended_shop]').val();
            if(!shop || shop == '')  {
                return false;
            }
            if(recommended_code && recommended_code != '')  {
                if(recommended_code.replaceAll('-','') == id.replaceAll('-','')) {
                    alert('본인을 추천인으로 등록하실 수는 없습니다.');
                    return false;
                }
            }

            return true;
        }
        hideValidationText();
    </script>
@include('user.footer')

</body>
</html>
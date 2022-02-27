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
            <button class="back" onclick="location.href='/user/signup/';">
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


        <!-- 약관동의 -->
        <section id="agreement">
          <form action="#!" method="post">
            <input type="hidden" name="id" id="id" value="{{$id}}">
            <input type="hidden" name="pw" id="pw" value="{{$pw}}">
            <input type="hidden" name="name" id="name" value="{{$name}}">
            <!-- 전체동의 -->
            <div class="all_check_wrap">
              <p>
                <input type="checkbox" id="all_check" onclick="toggleAll()">
                <label for="all_check">전체동의</label>
              </p>
              <span>
                <img src="/user/img/arrow_top.svg" alt="전체동의" class="arrow_top">
              </span>
            </div>
            <!-- 필수, 선택 동의 -->
            <p>
              <input type="checkbox" name="agree01" id="agree01" onclick="checkAllCheckToggle()" required>
              <label for="agree01">(필수) 14세 이상 사용가능</label>
            </p>
            <p>
              <input type="checkbox" name="agree02" id="agree02" onclick="checkAllCheckToggle()" required>
              <label for="agree02">(필수) 이용약관</label>
              <a href="/terms/policy" class="agreement_view_btn">보기</a>
            </p>
            <p>
              <input type="checkbox" name="agree03" id="agree03" onclick="checkAllCheckToggle()" required>
              <label for="agree03">(필수) 개인정보 처리방침</label>
              <a href="/terms/privacy" class="agreement_view_btn">보기</a>
            </p>
            <p>
              <input type="checkbox" name="agree04" id="agree04" onclick="checkAllCheckToggle()">
              <label for="agree04">(선택) 이벤트 정보 수신</label>
              <a href="/terms/privacy" class="agreement_view_btn">보기</a>
            </p>
            <!-- 완료 버튼 -->
            <button type="button" id="complete_btn" onclick="join()">완료</button>
          </form>
        </section>
    
        <script src="{{ asset('user/js/jquery-3.6.0.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('user/js/medibox-apis.js') }}?v=2022012918"></script>
          <script>
              var isCheckedAll = false;
              function toggleAll(){
                  isCheckedAll = !isCheckedAll;
                  $('#all_check').prop('checked', isCheckedAll);
                  $('#agree01').prop('checked', isCheckedAll);
                  $('#agree02').prop('checked', isCheckedAll);
                  $('#agree03').prop('checked', isCheckedAll);
                  $('#agree04').prop('checked', isCheckedAll);
              }
              function checkAllCheckToggle(){
                  var isAllow01 = $('#agree01').is(":checked");
                  var isAllow02 = $('#agree02').is(":checked");
                  var isAllow03 = $('#agree03').is(":checked");
                  var isAllow04 = $('#agree04').is(":checked");
                  if(isAllow01 && isAllow02 && isAllow03 && isAllow04) {
                    isCheckedAll = true;
                    $('#all_check').prop('checked', isCheckedAll);
                  } else {
                    isCheckedAll = false;
                    $('#all_check').prop('checked', isCheckedAll);
                  }
              }
              function checkValidation(){
                  var id = document.querySelector('#id').value;
                  var pw = document.querySelector('#pw').value;
                  var name = document.querySelector('#name').value;
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
                  /*
                  if(!name || name == '') {
                      alert('이름을 입력해주세요.');
                      return false;
                  }
                  */
                  var isAllow01 = $('#agree01').is(":checked");
                  var isAllow02 = $('#agree02').is(":checked");
                  var isAllow03 = $('#agree03').is(":checked");
                  var isAllow04 = $('#agree04').is(":checked");

                  if (!isAllow01 || !isAllow02 || !isAllow03) {
                      alert('약관에 동의해주세요.');
                      return false;
                  }

                  return true;
              }
              function join(){
                  if(!checkValidation()) {
                      return;
                  }
                  var id = document.querySelector('#id').value;
                  var pw = document.querySelector('#pw').value;
                  var name = document.querySelector('#name').value;
                  var isAllow04 = $('#agree04').is(":checked");
        
                  medibox.methods.user.add({
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
                      $('.popup').addClass('on');
                  }, function(e){
                      console.log(e);
                  });
              }
              $(document).ready(function(){
                $('#complete_btn').off();
              });
          </script>

          <!-- 회원가입 완료 시 (팝업창) -->
          <div id="popup02" class="popup">
            <div class="container">
                <div class="top">
                    <strong class="popup_icon">success</strong>
                    <span>환영합니다!<br>회원가입이 완료되었습니다.</span>
                </div>
                <div class="bottom">
                    <!-- 버튼 클릭 시 로그인 화면으로 이동 -->
                    <a href="/user/login">확인</a>
                </div>
            </div>
        </div>
</body>
</html>
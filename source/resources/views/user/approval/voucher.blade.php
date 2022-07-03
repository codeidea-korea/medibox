
@include('user.header')

<!-- header -->
<header id="header">
    <!-- 뒤로가기 버튼 -->
    <button class="back" onclick="gotoMain()">
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
        <span>바우처 결제</span>
    </div>
</header>


<!-- 관리자 승인 로딩 페이지 -->
<section id="approval">
    <div class="container">
        <figure>
            <img src="/user/img/icon_approval.png" alt="메디박스 관리자 승인">
        </figure>
        <h2>
            관리자 승인중입니다.<br>
            잠시만 기다려주세요.
        </h2>
        <p>관리자가 승인 후, 바우처 결제가 완료됩니다.</p>
    </div>

</section>
<div id="popup18" class="popup">
        <div class="container">
            <div class="top">
                <strong class="popup_icon_check popup_icon">check</strong>
                <span>바우처 사용이<br>완료되었습니다.</span>
            </div>
            <div class="bottom">
            <a href="#!" onclick="closePop()">확인</a>
            </div>
        </div>
    </div>
    <div id="popup19" class="popup">
        <div class="container">
            <div class="top">
                <strong class="popup_icon_cancel popup_icon">cancel</strong>
                <span>바우처 사용이<br>취소되었습니다.</span>
            </div>
            <div class="bottom">
            <a href="#!" onclick="gotoMain()">확인</a>
            </div>
        </div>
    </div>

<div id="popup06" class="popup">
    <div class="container">
        <div class="top">
            <strong class="popup_icon">empty</strong>
            <span>세션이 만료되었습니다.<br>로그인을 다시 하신 뒤 결제 하여 주세요.</span>
        </div>
        <div class="bottom">
            <!-- 버튼 클릭 시 로그인 화면으로 이동 -->
            <a href="#!" onclick="gotoMain()">확인</a>
        </div>
    </div>
</div>

<div id="popup07" class="popup">
    <div class="container">
        <div class="top">
            <strong class="popup_icon">empty</strong>
            <span>존재하지 않는 회원입니다.<br>로그인 후 다시 접근하여 주세요.</span>
        </div>
        <div class="bottom">
            <!-- 버튼 클릭 시 로그인 화면으로 이동 -->
            <a href="#!" onclick="gotoMain()">확인</a>
        </div>
    </div>
</div>

<div id="popup08" class="popup">
    <div class="container">
        <div class="top">
            <strong class="popup_icon">empty</strong>
            <span>더 이상 판매하지 않는 상품입니다.<br>관리자에게 문의하여 주세요.</span>
        </div>
        <div class="bottom">
            <!-- 버튼 클릭 시 로그인 화면으로 이동 -->
            <a href="#!" onclick="gotoMain()">확인</a>
        </div>
    </div>
</div>

<script src="{{ asset('user/js/jquery-3.6.0.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('user/js/medibox-apis.js') }}?v=2022041218"></script>
<script>
var code = '{{ $code }}';
function checkApprove(){
    medibox.methods.point.membership.checkApprove({ user_seqno: {{ $userSeqno }}, hst_seqno: {{ $id }} }, function(request, response){
        console.log('output : ' + response);
        if(!response.result){
            if(response.code == 'HISTORY-NULL') {
                $('#popup19').addClass('on');
                return false;
            }
            alert(response.ment);
            return false;
        }
        if(response.code == 'S1') {
            $('#popup18').addClass('on');
        } else if(response.code == 'S2') {
            // 대기중
            setTimeout(checkApprove, 2000);
        }
    }, function(e){
        console.log(e);
        alert('서버 통신 에러');
    });
}
if(code == 'S') {
    $(document).ready(function(){
        checkApprove();
    });
} else if(code == 'USER-INPUT') {
    $('#popup06').addClass('on');
} else if(code == 'USER-NULL') {
    $('#popup07').addClass('on');
} else if(code == 'SERVICE-NULL') {
    $('#popup08').addClass('on');
} else if(code == 'POINT-LESS') {
    $('#popup05').addClass('on');
}
function closePop(){
    $('#popup18').removeClass('on');
    $('#popup19').removeClass('on');
    $('#popup05').removeClass('on');
    $('#popup06').removeClass('on');
    $('#popup07').removeClass('on');
    $('#popup08').removeClass('on');

    gotoMain();
}
function gotoMain(){
    location.href = '/';
}
</script>
@include('user.footer')

</body>
</html>
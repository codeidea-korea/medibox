
@include('user.header')
    
        <!-- header -->
        <header id="header" class="profile">
            <!-- page title -->
            <div class="title">
                <span>프로필</span>
            </div>
        </header>


        <!-- 프로필 메인 -->
        <section id="profile">
            <div class="top_wrap">
                <div class="user_wrap">
                    <!-- 유저 프로필 사진 -->
                    <figure>
                        <img src="" alt="">
                    </figure>
                    <div class="user">
                        <span class="user_id" id="id">{{$name}}님 반갑습니다.</span>

                        <!-- 22.04.01 한글깨짐현상 수정 -->
                        <!-- <span class="user_class">Classic</span> -->
                        <span class="user_class">
                            <strong>고객등급</strong>
                            Classic
                        </span>
                        <!----------------------------->
                        
                        <a href="/profile/edit-prev" class="profile_edit_btn">프로필 편집</a>
                    </div>
                </div>
                <div class="quick_menu_wrap">
                    <ul>
                        <li><a href="/point">
                            <img src="/user/img/icon_service.svg" alt="Medibox service">
                            서비스
                        </a></li>
                        <li><a href="/profile/voucher">
                            <img src="/user/img/icon_voucher.svg" alt="medibox voucher">
                            바우처
                        </a></li>
                        <li><a href="/profile/coupon">
                            <img src="/user/img/icon_coupon.svg" alt="medibox coupon">
                            쿠폰
                        </a></li>
                    </ul>
                </div>
            </div>
            <div class="bottom_wrap">
                <div class="menu_wrap">
                    <ul class="history_menu menu">
                        <li><a href="/point/history">결제내역</a></li>
                        <li><a href="#" onclick="wait()">예약내역</a></li>
                    </ul>
                    <ul class="profile_menu menu">
                        <li><a href="#!" onclick="wait()">공지사항</a></li>
                        <li><a href="#!" onclick="wait()">자주 묻는 질문</a></li>
                        <li><a href="#!" onclick="wait()">도움말</a></li>
                        <li><a href="/terms/policy">약관 및 정책</a></li>
                        <li><a href="#!" onclick="wait()">버전</a></li>
                    </ul>
                </div>

                <!-- 22.03.28 추가 -->
                <div class="logout_wrap">
                <button type="button" id="logout" onclick="logoutConfirm()">로그아웃</button>
                </div>
                <!------------------>

                <div class="service_menu">
                    <h3>메디박스 고객센터</h3>
                    <ul class="working_time">
                        <li>운영시간 / 평일 9:00 ~ 17:30 (주말,공휴일 휴무)</li>
                        <li>점심시간 / 오후 12:00 ~ 13:00</li>
                    </ul>
                    <ul class="inquire">
                        <li>
                            <a href="#!">1600 - 1600</a>
                        </li>
                        <li>
                            <a href="#!">카카오 1:1 문의</a>
                        </li>
                    </ul>
                </div>
            </div>
        </section>


        <footer id="footer">
            <div class="footer_link">
                <ul>
                    <li><a href="/profile/edit-prev">사용자 정보</a></li>
                    <li><a href="/terms/usage">이용약관</a></li>
                    <li><a href="/terms/policy">개인정보처리방침</a></li>
                    <li><a href="#!" onclick="wait()">사업자 정보 확인</a></li>
                </ul>
            </div>
            <div class="copyright_wrap">
                <span>
                    ㈜미니쉬테크는 통신판매중개자로서 메디박스의 거래 당사자가 아니며,<br> 입점 판매자가 등록한 상품정보 및 거래에 대해 책임을 지지 않습니다.
                </span>
            </div>
        </footer>    

        <!-- 22.03.28 추가 -->
        <!-- 로그아웃 팝업창 -->
        <div id="popup06" class="popup">
            <div class="container">
                <div class="top">
                    <strong class="popup_icon_check popup_icon">check</strong>
                    <span>
                    로그아웃되었습니다.<br>
                    메인페이지로 이동합니다.
                    </span>
                </div>
                <div class="bottom">
                    <a href="#!" onclick="$('#logoutFrm').submit();">확인</a>
                </div>
            </div>
        </div>

        <div id="popup10" class="popup select">
            <div class="container">
                <div class="top">
                    <span>로그아웃하시겠습니까?</span>
                </div>
                <div class="bottom">
                    <a href="#!" class="close_btn">아니오</a>
                    <a href="#!" onclick="logout()">네</a>
                </div>
            </div>
        </div>
        <!--------------->
        <form method="post" id="logoutFrm" action="/user/logout/proccess">
            {{ csrf_field() }}
        </form>

    <script>
        $(document).ready(function(){
            $('#logout').off();
        });
        function wait(){
            alert('준비중입니다.');
        }
        function logout(){
            $('#popup10').removeClass('on');
            $('#popup06').addClass('on');
        }
        function logoutConfirm(){
            $('#popup10').addClass('on');
        }
    </script>
@include('user.footer')
</body>
</html>
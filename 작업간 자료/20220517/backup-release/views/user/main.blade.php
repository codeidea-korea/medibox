
@include('user.header')

    <!-- loading 화면 (로딩 후 fadeOut)-->
    <div id="loading">
        <div class="slogan">
            <h2 class="main_title">MEDI BOX</h2>
            <p class="main_sub_title">
                오직 당신을 위한<br>
                Health & Beauty care
            </p>
        </div>
    </div>

    <!-- intro {{$isLogin}} -->
    <div id="intro">
        <div class="container">
            <h2 class="main_title">MEDI BOX</h2>
            <p class="main_sub_title">
                오직 당신을 위한<br>
                Health & Beauty care 
            </p>
            <nav class="gnb">
                <ul>
                    <li>
                    @if ( session('user_seqno') )
                        <a href="/point">
                    @else
                        <a href="#!">
                    @endif
                            <div class="menu_box">
                                <img src="/user/img/icon_pay.svg" alt="결제">
                                <span>결제</span>
                            </div>
                        </a>
                    </li>
                    @if ( session('user_seqno') )
                        <li>
                            <a href="/profile">
                                <div class="menu_box">
                                    <img src="/user/img/icon_login.svg" alt="MYpage">
                                    <span>MY</span>
                                </div>
                            </a>
                        </li>
                    @else
                        <li>
                            <a href="/user/login" onclick="$('#popup01').remove();">
                                <div class="menu_box">
                                    <img src="/user/img/icon_login.svg" alt="로그인">
                                    <span>로그인</span>
                                </div>
                            </a>
                        </li>
                        <script>
                            $('.gnb li:nth-child(2)>a').on('click', function(){
                                $('.popup').addClass('on');
                            });
                        </script>
                    @endif
                    <li>
                        <a href="/brand">
                            <div class="menu_box">
                                <img src="/user/img/icon_brand.svg" alt="브랜드">
                                <span>브랜드</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="/reservation">
                            <div class="menu_box">
                                <img src="/user/img/icon_reserve.svg" alt="예약">
                                <span>예약</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <script>
        @if ( session('user_seqno') )
            $(document).ready(function(){
                $('.gnb li:nth-child(1)>a').off();
            });
        @else
    //        $('.gnb li:nth-child(1)>a').off();
        @endif
        window.onpageshow = function(event) {
            $('#loading').fadeOut('slow');
            $('.popup').removeClass('on');
        }
    </script>
@include('user.footer')

</body>
</html>
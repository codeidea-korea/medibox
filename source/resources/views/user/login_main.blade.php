
@include('user.header')

    <!-- loading 화면 (로딩 후 fadeOut)-->
    <div id="loading">
        <div class="slogan">
            <h2 class="main_title">MEDI BOX</h2>
            <p class="main_sub_title">
                특별한 당신을 위한<br>
                Health Care
            </p>
        </div>
    </div>

    <!-- intro -->
    <div id="intro">
        <div class="container">
            <h2 class="main_title">MEDI BOX</h2>
            <p class="main_sub_title">
                특별한 당신을 위한<br>
                Health Care
            </p>
            <nav class="gnb">
                <ul>
                    <li>
                        <a href="#!">
                            <div class="menu_box">
                                <img src="/user/img/icon_pay.svg" alt="결제">
                                <span>결제</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#!">
                            <div class="menu_box">
                                <img src="/user/img/icon_login.svg" alt="결제">
                                <span>MY</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#!">
                            <div class="menu_box">
                                <img src="/user/img/icon_brand.svg" alt="결제">
                                <span>브랜드</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#!">
                            <div class="menu_box">
                                <img src="/user/img/icon_reserve.svg" alt="결제">
                                <span>예약</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>


    @include('user.footer')


</body>
</html>
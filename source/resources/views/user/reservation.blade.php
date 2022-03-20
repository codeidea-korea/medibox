
@include('user.header')
    
        <!-- header -->
        <header id="header">
            <!-- 뒤로가기 버튼 -->
            <button class="back" onclick="location.href='/';">
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
                <span>예약하기</span>
            </div>
        </header>

        <section id="reservation">
            <ul>
                <li>
                    <a href="/reservation/minishspa">
                        <div class="menu_box">
                            <img src="/user/img/icon_minish_spa.svg" alt="미니쉬 스파">
                            <span>미니쉬스파</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="/reservation/valmontspa">
                        <div class="menu_box">
                            <img src="/user/img/icon_valmont_spa.svg" alt="발몽스파">
                            <span>발몽스파</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="/reservation/nail">
                        <div class="menu_box">
                            <img src="/user/img/icon_nail.svg" alt="바라는 네일">
                            <span>바라는 네일</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="/reservation/deepfocus">
                        <div class="menu_box">
                            <img src="/user/img/icon_deep_focus.svg" alt="딥 포커스">
                            <span>딥포커스</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="/reservation/forestablack">
                        <div class="menu_box">
                            <img src="/user/img/icon_foresta_black.svg" alt="포레스타블랙">
                            <span>포레스타블랙</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="/reservation/minishmanultherapy">
                        <div class="menu_box">
                            <img src="/user/img/icon_minish_manul_therapy.svg" alt="미니쉬도수">
                            <span>미니쉬도수</span>
                        </div>
                    </a>
                </li>
            </ul>

            <!-- 22.03.14 수정 -->
            <!-- <figure class="Advertisement">
                <img src="./img/bottom_banner.jpg" alt="믿고 책임질 수 있는 치아교정 클리닉">
            </figure> -->
            <figure id="Advertisement" class="ad01">
                <img src="/user/img/bottom_banner01_s.jpg" alt="건강하니까 이쁜거야! 미니쉬 치과 병원">
            </figure>
            <figure id="Advertisement" class="ad02">
                <img src="/user/img/bottom_banner02.jpg" alt="믿고 책임질 수 있는 치아교정 클리닉">
            </figure>
        </section>

        @include('user.footer')

        
</body>
</html>
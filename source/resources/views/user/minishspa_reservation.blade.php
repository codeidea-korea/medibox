
@include('user.header')

    <header id="header">
        <!-- 뒤로가기 버튼 -->
        <button class="back" onclick="location.href='/reservation';">
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
            <span>예약 상세</span>
        </div>
    </header>


    <!-- 미니쉬스파 예약 페이지 -->
    <section id="brand_intro">
        <div class="brand_item_slider">
            <figure class="minish_spa01"></figure>
            <!-- <figure class="minish_spa02"></figure>
            <figure class="minish_spa03"></figure>
            <figure class="minish_spa04"></figure>
            <figure class="minish_spa05"></figure> -->
        </div>
        <div class="brand_item_num">
            <span class="snum"></span>
        </div>
        <!-- 22.03.07 수정 -->
        <!-- <div class="reservation_des">
            <div class="title">
                <h2>미니쉬 스파</h2>
                <a href="#!" class="share_btn">
                    <img src="./img/icon_share.svg" alt="공유하기">
                </a>
            </div>
            <ul class="tab_menu">
                <li class="on">정보</li>
                <li>서비스</li>
                <li>문의</li>
            </ul>
            <div class="tab_content">
                <div class="intro_inner">
                    <h3>제휴업체소개</h3>
                    <p>
                        ‘나 자신도 몰랐던 입속 상태를 정확히 진단받고, 건강한 구강 관리가 가능토록 미니쉬가 만들었습니다.’<br>
                        미니쉬 스파에서는 구강질환이 발생하지 않도록 예방하고 이미 발생한 구강질환은 비침습적 방법으로 관리할 수 있도록 개인별 구강 상태에 맞는 관리 프로그램을 진행해드립니다.
                    </p>
                </div>
                <div class="info_inner">
                    <h3>업체 정보</h3>
                    <ul>
                        <li class="working_time">
                            10:00 ~ 20:00<br>
                            월요일 휴무
                        </li>
                        <li class="tel">
                            02-540-2252
                        </li>
                        <li class="address">
                            서울시 강남구 연주로 728
                        </li>
                    </ul>
                </div>
            </div>
            <div class="tab_content">
                <div class="service_inner menu_inner">
                    <h3>서비스(<span class="itm_num"></span>)</h3>

                    <div class="menu">
                        <h4>BASIC (구강 예방치료 프로그램)</h4>
                        <ul>
                            <li>
                                <span class="program">미니쉬 SPA</span>
                                <span class="price">100,000원</span>
                            </li>
                        </ul>
                    </div>

                    <div class="menu">
                        <h4>SPECIAL (생애주기 예방 프로그램)</h4>
                        <ul>
                            <li>
                                <span class="program">건치 백세 프로그램 (4회)</span>
                                <span class="price">700,000원</span>
                            </li>
                            <li>
                                <span class="program">잇몸튼튼 프로그램(4회)</span>
                                <span class="price">700,000원</span>
                            </li>
                            <li>
                                <span class="program">맘앤대디 프로그램(2인 1회)</span>
                                <span class="price">700,000원</span>
                            </li>
                        </ul>
                    </div>

                    <div class="menu">
                        <h4>PREMIUM</h4>
                        <ul>
                            <li>
                                <span class="program">
                                    구강종합검진 (1회)<br>
                                    + 평생 건강관리 (4회)
                                </span>
                                <span class="price">1,080,000원</span>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
            <div class="tab_content">
                <div class="inquiry_inner">
                    <h3>준비중입니다.</h3>
                </div>
            </div>
        </div> -->
        <!-- 22.03.09 수정 -->
        <div class="brand_item_des reservation_des">
            <h2>미니쉬 스파</h2>
            <span>Minsh Spa</span>
            <ul class="address">
                <li>서울 강남구 연주로 728</li>
            </ul>
            <ul class="working_time">
                <li>평일 10:00 ~ 20:00</li>
                <li>주말 10:00 ~ 18:00</li>
                <li>공휴일, 명절 연휴 휴무</li>
            </ul>
        </div>

        <!-- 22.03.18 수정 -->
        <!-- <a href="tel:02-540-2252" class="reservation_btn">예약하기</a> -->
        <a href="http://s.handsos.com/User_default.asp?pkCompany=12536181&pkMobileID=15226" target="_blank" class="reservation_btn">예약하기</a>
    </section>
@include('user.footer')


</body>
</html>
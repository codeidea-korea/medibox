
@include('user.header')

        <!-- header -->
        <header id="header">
            <!-- 뒤로가기 버튼 -->
            <button class="back" onclick="history.back()">
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
                <span>쿠폰</span>
            </div>
        </header>

        <!-- 22.03.30 추가 -->
        <nav id="history_lnb">
            <ul class="depth01">
                <li>
                    <a href="#!">전체 기간</a>
                    <ul class="depth02">
                        <!-- 22.03.31 추가 -->
                        <li><a href="#!">전체</a></li>
                        <!------------------>

                        <li><a href="#!">1개월</a></li>
                        <li><a href="#!">3개월</a></li>
                        <li><a href="#!">6개월</a></li>
                        <li><a href="#!">1년</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#!">전체 내역</a>

                    <!-- 22.03.31 수정 -->
                    <ul class="depth02">
                        <!-- <li><a href="#!">포인트</a></li>
                        <li><a href="#!">정액권</a></li> -->

                        <li><a href="#!">전체</a></li>
                        <li><a href="#!">발몽스파</a></li>
                        <li><a href="#!">바라는네일</a></li>
                        <li><a href="#!">딥포커스</a></li>
                        <li><a href="#!">포레스타블랙</a></li>
                        <li><a href="#!">미니쉬 스파</a></li>
                        <li><a href="#!">미니쉬 도수</a></li>
                        <li><a href="#!">기타</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!---------------->        

        <!-- 포인트 & 정액권 페이지 -->
        <section id="point_payment">

            <!-- 22.03.30 추가 -->
            <!-- 쿠폰이 없을 때 -->
            <figure class="empty_reservation">
                <img src="/user/img/icon_empty_reservation.png" alt="쿠폰이 없습니다.">
                <p>쿠폰이 없습니다.</p>
            </figure>

            <!-- 쿠폰이 있을 때 -->
            <!-- <div class="coupon_tab">
                <div><a href="./coupon_approval.html">
                    <div class="left">
                        <h3>
                            [포인트] 수능 이벤트
                        </h3>
                        <strong>30,000P</strong>
                        <p class="type">전체 사용</p>
                        <p class="deadline">기한 : 2022-3-19</p>
                    </div>
                    <div class="right"></div>
                </a></div>
                <div><a href="./coupon_approval.html">
                    <div class="left">
                        <h3>
                            [쿠폰] 딥포커스 연휴 이벤트
                        </h3>
                        <strong>딥포커스 검안 1회권</strong>
                        <p class="type">딥포커스 검안센터</p>
                        <p class="deadline">기한 : 2022-2-1</p>
                    </div>
                    <div class="right"></div>
                </a></div>
                <div><a href="./coupon_approval.html">
                    <div class="left">
                        <h3>
                            [쿠폰] 발몽 스파 10주년 기념
                        </h3>
                        <strong>고급 와인 증정</strong>
                        <p class="type">발몽스파</p>
                        <p class="deadline">기한 : 2022-2-1</p>
                    </div>
                    <div class="right"></div>
                </a></div>
                <div><a href="./coupon_approval.html">
                    <div class="left">
                        <h3>
                            [포인트] VIP 고객 감사 이벤트
                        </h3>
                        <strong>100,000P</strong>
                        <p class="type">전체 사용</p>
                        <p class="deadline">기한 : 2022-3-19</p>
                    </div>
                    <div class="right"></div>
                </a></div>
                <div><a href="./coupon_approval.html">
                    <div class="left">
                        <h3>
                            [쿠폰] 바라는 네일 리뷰 작성 이벤트
                        </h3>
                        <strong>베이직 케어&패디 1회권</strong>
                        <p class="type">발몽스파</p>
                        <p class="deadline">기한 : 2022-2-1</p>
                    </div>
                    <div class="right"></div>
                </a></div>
            </div> -->
        </section>
    
    
@include('user.footer')


</body>
</html>
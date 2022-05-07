
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
            <span>딥포커스 검안센터</span>
        </div>
    </header>


    <!-- 딥포커스 검안센터 예약 페이지 -->
    <section id="brand_intro">
        <div class="brand_item_slider">
            <figure class="deep_focus01"></figure>
            <figure class="deep_focus02"></figure>
            <!-- <figure class="deep_focus03"></figure>
            <figure class="deep_focus04"></figure>
            <figure class="deep_focus05"></figure> -->
        </div>
        <div class="brand_item_num">
            <span class="snum"></span>
        </div>

        <div class="reservation_des">
            <div class="title">
                <h2>딥포커스 검안센터</h2>
                <a href="#!" class="share_btn">
                    <img src="/user/img/icon_share.svg" alt="공유하기">
                </a>
            </div>
            <ul class="tab_menu">
                <li class="on">정보</li>
                <li>서비스</li>

                <!-- 22.03.28 삭제 -->
                <!-- <li>문의</li> -->
            </ul>

            <!-- 정보탭 -->
            <div class="tab_content">
                <div class="intro_inner">
                    <h3>제휴업체소개</h3>
                    <p>
                        ‘왜 유럽과 미국에서는 보편화된 전문 검안을 한국에서는 찾아보기 어려울까?’<br>
                        이런 의문으로 시작한 딥포커스 정밀 검안센터는 ‘김광용 OPTICIAN’에 의해 15년동안 연구된 눈 중심 전문 검안 센터입니다. 우리의 눈은 특정 질환이 아니더라도 다양한 불편 증상이 생길 수 있습니다. 때문에 눈 질환과 시기능 이상은 구별이 필요합니다.<br>
                        체계적이고 정밀한 검안을 통해 고객님들께 선명하고 편안한 시력을 선사하여 만족도 높은 시생활이 가능토록 도와드립니다.
                    </p>
                </div>
                <div class="info_inner">
                    <h3>업체 정보</h3>
                    <ul>
                        <li class="working_time">
                            10:00 ~ 19:00
                        </li>
                        <li class="tel">
                            010-3909-8669
                        </li>
                        <li class="address">
                            서울시 강남구 도산대로49길9 2층<br>딥포커스 in 미니쉬라운지 청담
                        </li>
                    </ul>
                </div>
            </div>

            <!-- 서비스탭 -->
            <div class="tab_content">
                <div class="service_inner menu_inner">
                    <h3>서비스(<span class="itm_num"></span>)</h3>

                    <div class="menu">
                        <h4>BASIC</h4>
                        <ul>
                            <li><a href="#" onclick="wait()">
                                <span class="program">
                                    포커스 비전케어 (40분)
                                    <small>상담 문진 (10분)</small>
                                    <small>국내 휴비츠 검안 장비 (20분)</small>
                                    <small>소프트렌즈, 하드렌즈 기본 검안 (10분)</small>
                                </span>
                                <span class="price">100,000원</span>
                            </a></li>
                        </ul>
                    </div>

                    <div class="menu">
                        <h4>LUXURY</h4>
                        <ul>
                            <li><a href="#" onclick="wait()">
                                <span class="program">
                                    딥포커스 비전케어 (60분)
                                    <small>상담 문진 (10분)</small>
                                    <small>아이 프로파일러 (20분)</small>
                                    <small>양안시 정밀검안 (30분)</small>
                                </span>
                                <span class="price">200,000원</span>
                            </a></li>
                        </ul>
                    </div>

                    <div class="menu">
                        <h4>SPECIAL</h4>
                        <ul>
                            <li><a href="#" onclick="wait()">
                                <span class="program">
                                    딥포커스 아이테라피 (120분)
                                    <small>상담 문진 (10분)</small>
                                    <small>마이크로 양안시 정밀검안 (60분)</small>
                                    <small>사시 약시 안구피로 개선 아이테라피 (50분)</small>
                                </span>
                                <span class="price">300,000원</span>
                            </a></li>
                        </ul>
                    </div>

                </div>
            </div>


            <!-- 22.03.28 삭제 -->
            <!-- 문의탭 -->
            <!-- <div class="tab_content">
                <div class="inquiry_inner">
                    <div class="inquiry_area_wrap">
                        <textarea id="inquiry_area" name="inquiry_area" placeholder="문의사항을 남겨주세요." maxlength="200" required></textarea>
                        <button type="submit" id="inquiry_btn">문의등록</button>
                    </div>
                    <div class="inquiry_list_wrap">
                        <ul>
                            <li>
                                <span class="name">김승우</span>
                                <span class="date">2022년 3월 1일</span>
                                <span class="wait">답변 전</span>
                                <p>
                                    미니쉬 스파는 미니쉬 병원에서 받을 수 있는 건가요? 정확한 위치 좀 알려주세요 ㅠㅠ
                                </p>
                            </li>
                            <li>
                                <span class="name">이예진</span>
                                <span class="date">2022년 3월 1일</span>
                                <span class="wait">답변 전</span>
                                <p>
                                    미니쉬 스파가 뭐예요?
                                </p>
                            </li>
                            <li>
                                <span class="name">박승아</span>
                                <span class="date">2022년 2월 15일</span>
                                <p>
                                    미니쉬 스파 치면 세균막 관리과정은 총 몇시간 소요되는지 궁금합니다.
                                </p>
                            </li> -->
                            <!-- 답변에는 background (class="answer") -->
                            <!-- <li class="answer">
                                <span class="name">미니쉬 스파</span>
                                <span class="date">2022년 2월 27일</span>
                                <p>
                                    안녕하세요. 미니쉬스파입니다 ^^ ‘치면 세균막 관리
                                    과정’은 총 13단계로 50분의 시간이 소요됩니다.
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div> -->
            <!--------------->
        </div>


        <!-------------- 1차 -------------->
        <!-- <div class="brand_item_des">
            <h2>딥포커스 검안센터</h2>
            <span>Deep Focus</span>
            <ul class="address">
                <li>서울 강남구 도산대로49길 9 스타크빌딩 2층 (신사동)</li>
            </ul>
            <ul class="working_time">
                <li>평일 10:00 ~ 20:00</li>
                <li>토요일 10:00 ~ 20:00</li>
                <li>일요일 정기 휴무</li>
                <li>19:00 라스트 오더</li>
            </ul>
        </div> -->
        <!--------------------------------->


        <!-- <a href="http://s.handsos.com/User_default.asp?pkCompany=12536181&pkMobileID=15226" target="_blank" class="reservation_btn">예약하기</a> -->

        <a href="/brands/4/shops/0/reservation/cart" target="_blank" class="reservation_btn">예약하기</a>
    </section>


    <div class="modal_wrap share">
        <div class="modal_inner">
            <h4>링크 공유</h4>
            <ul>
                <li><a href="#" onclick="wait()">
                    <img src="/user/img/icon_copy.svg" alt="링크 복사">
                    <span>링크 복사</span>
                </a></li>
                <li><a href="#" onclick="wait()">
                    <img src="/user/img/kakao.svg" alt="카카오톡 공유하기">
                    <span>카카오톡</span>
                </a></li>
                <li><a href="#" onclick="wait()">
                    <img src="/user/img/naver.svg" alt="네이버 공유하기">
                    <span>네이버</span>
                </a></li>
                <li><a href="#" onclick="wait()">
                    <img src="/user/img/google.svg" alt="구글 공유하기">
                    <span>구글</span>
                </a></li>
            </ul>
            <a href="#" class="close_btn">취소</a>
        </div>
    </div>


    @include('user.footer')

</body>
</html>
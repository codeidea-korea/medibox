
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
            <span>미니쉬 도수</span>
        </div>
    </header>


    <!-- 미니쉬도수 예약 페이지 -->
    <section id="brand_intro">
        <div class="brand_item_slider">
            <figure class="minish_manul_therapy01"></figure>
            <!-- <figure class="minish_manul_therapy02"></figure>
            <figure class="minish_manul_therapy03"></figure>
            <figure class="minish_manul_therapy04"></figure>
            <figure class="minish_manul_therapy05"></figure> -->
        </div>
        <div class="brand_item_num">
            <span class="snum"></span>
        </div>

        <div class="reservation_des">
            <div class="title">
                <h2>미니쉬 도수</h2>
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
                        ‘MANUAL THERAPY’, 모든 인체의 건강은 예방 관리가 가장 중요합니다.
                        호감가는 인상을 결정하는 것은 아름다운 이목구비 뿐 아니라 체형도 중요한 요인이 됩니다. 일상생활 속 잘못된 자세가 반복되면 그 사람의 체형으로 고착화됩니다.<br>
                        미니쉬치과병원에서는 관절 전문 병원 출신의 물리치료사분을 채용하여 대기고객을 위한 체형교정 서비스를 제공하고 있습니다. 근골격의 변형예측, 근육 형상 검사가 가능한 장비를 활용한 검사 결과에 따라 개개인에 맞는 자가운동 치료 솔루션을 처방해드립니다.<br>
                        멤버십 고객분들을 위한 미니쉬라운지청담만의 특별한 매뉴얼 테라피를 경험해보시기 바랍니다.
                    </p>
                </div>
                <div class="info_inner">
                    <h3>업체 정보</h3>
                    <ul>
                        <li class="working_time">
                            10:00 ~ 20:00<br>
                            주말 정기 휴일
                        </li>
                        <li class="tel">
                            1899-2854
                        </li>
                        <li class="address">
                            서울시 강남구 언주로 728 5층 도수치료센터
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
                                <span class="program">체형개선 관리 (60분)</span>
                                <span class="price">100,000원</span>
                            </a></li>
                            <li><a href="#" onclick="wait()">
                                <span class="program">통증완화 관리 (60분)</span>
                                <span class="price">100,000원</span>
                            </a></li>
                            <li><a href="#" onclick="wait()">
                                <span class="program">유연성 회복 (60분)</span>
                                <span class="price">100,000원</span>
                            </a></li>
                            <li><a href="#" onclick="wait()">
                                <span class="program">피로회복 관리 (60분)</span>
                                <span class="price">100,000원</span>
                            </a></li>
                        </ul>
                    </div>

                    <div class="menu">
                        <h4>LUXURY</h4>
                        <ul>
                            <li><a href="#" onclick="wait()">
                                <span class="program">
                                    딥슬립 관리 (90분)
                                    <!--
                                    <small>도수[물리 치료] (40분)</small>
                                    <small>미니쉬 X 발몽스파 (50분)</small>
-->
                                </span>
                                <span class="price">350,000원</span>
                            </a></li>
                            <li><a href="#" onclick="wait()">
                                <span class="program">
                                    직장인 관리 (90분)
                                    <!--
                                    <small>도수[물리 치료] (40분)</small>
                                    <small>미니쉬 X 발몽스파 (50분)</small>
-->
                                </span>
                                <!-- 22.03.29 수정 -->
                                <!-- <span class="price">700,000원</span> -->
                                <span class="price">350,000원</span>
                            </a></li>
                        </ul>
                    </div>

                    <div class="menu">
                        <h4>SPECIAL</h4>
                        <ul>
                            <li><a href="#" onclick="wait()">
                                <span class="program">
                                    골프 테라피 (120분)
                                    <!--
                                    <small>도수[물리 치료] (60분)</small>
                                    <small>미니쉬 X 발몽스파 (60분)</small> -->
                                </span>
                                <span class="price">450,000원</span>
                            </a></li>
                            <li><a href="#" onclick="wait()">
                                <span class="program">
                                    산후 관리 (120분) <!--
                                    <small>도수[물리 치료] (60분)</small>
                                    <small>미니쉬 X 발몽스파 (60분)</small> -->
                                </span>
                                <span class="price">450,000원</span>
                            </a></li>
                            <li><a href="#" onclick="wait()">
                                <span class="program">
                                    웨딩 관리 (120분) <!--
                                    <small>도수[물리 치료] (60분)</small>
                                    <small>미니쉬 X 발몽스파 (60분)</small> -->
                                </span>
                                <span class="price">450,000원</span>
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
        </div>
        
        <!-------------- 1차 -------------->
        <!-- <div class="brand_item_des">
            <h2>미니쉬 도수</h2>
            <span>Minish Manul Therapy</span>
            <ul class="address">
                <li>서울 강남구 언주로 728</li>
            </ul>
            <ul class="working_time">
                <li>평일 10:00 ~ 20:00</li>
                <li>주말 10:00 ~ 18:00</li>
                <li>공휴일, 명절 연휴 휴무</li>
            </ul>
        </div> -->
        <!--------------------------------->


        <a href="http://s.handsos.com/User_default.asp?pkCompany=12536181&pkMobileID=15226" target="_blank" class="reservation_btn">예약하기</a>
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
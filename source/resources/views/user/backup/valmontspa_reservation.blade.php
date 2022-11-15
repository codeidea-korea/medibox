
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
            <span>발몽 스파</span>
        </div>
    </header>


    <!-- 발몽스파 예약 페이지 -->
    <section id="brand_intro">
        <div class="brand_item_slider">
            <figure class="valmont_spa01"></figure>
            <figure class="valmont_spa02"></figure>
            <figure class="valmont_spa03"></figure>
            <figure class="valmont_spa04"></figure>
            <!-- <figure class="valmont_spa05"></figure> -->
        </div>
        <div class="brand_item_num">
            <span class="snum"></span>
        </div>

        <div class="reservation_des">
            <div class="title">
                <h2>발몽 스파</h2>
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
                        스위스 발몽 코스메틱의 기술력과 미니쉬가 만나 우리의 고객이 건강하게 아름다워질 수 있도록 합니다. 발몽의 노하우를 전수받은 숙련된 테라피스트가 발몽제품과 발몽 테크닉을 얼굴 피부와 전신에 완벽히 적용합니다. 최상급 인테리어로 안락함과 행복함을 드리며 필요와 기대에 맞추고자 노력합니다. 편안한 휴식을 위해 1인 1룸, 청결한 위생을 위해 1인1시트, 체계적인 분석과 진단을 통한 트리트먼트로 오직 한 분을 위한 시간과 공간을 선사합니다. 
                    </p>
                </div>
                <div class="info_inner">
                    <h3>업체 정보</h3>
                    <ul>
                        <li class="working_time">
                            10:00 ~ 19:00
                        </li>
                        <li class="tel">
                            02-2039-2854
                        </li>
                        <li class="address">
                            서울시 강남구 도산대로49길9 2층<br>발몽스파 in 미니쉬라운지 청담
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- 서비스탭 -->
            <div class="tab_content">
                <div class="service_inner menu_inner">
                    <h3>서비스(<span class="itm_num"></span>)</h3>
    
                    <div class="menu">
                        <h4>[페이셜] MINISH SPECIAL</h4>
                        <ul>
                            <li><a href="#">
                                <span class="program">MINISH SPECIAL (90분)</span>
                                <span class="price">300,000원</span>
                            </a></li>
                            <li><a href="#">
                                <span class="program">MINISH SPECIAL (120분)</span>
                                <span class="price">450,000원</span>
                            </a></li>
                        </ul>
                    </div>
    
                    <div class="menu">
                        <h4>[페이셜] 하이드레이션</h4>
                        <ul>
                            <li><a href="#">
                                <span class="program">하이드레이션 (30분)</span>
                                <span class="price">140,000원</span>
                            </a></li>
                            <li><a href="#">
                                <span class="program">하이드레이션 (60분)</span>
                                <span class="price">210,000원</span>
                            </a></li>
                            <li><a href="#">
                                <span class="program">하이드레이션 (90분)</span>
                                <span class="price">280,000원</span>
                            </a></li>
                            <li><a href="#">
                                <span class="program">하이드레이션 (120분)</span>
                                <span class="price">440,000원</span>
                            </a></li>
                        </ul>
                    </div>
    
                    <div class="menu">
                        <h4>[페이셜] 에너지</h4>
                        <ul>
                            <li><a href="#">
                                <span class="program">에너지 (30분)</span>
                                <span class="price">140,000원</span>
                            </a></li>
                            <li><a href="#">
                                <span class="program">에너지 (60분)</span>
                                <span class="price">210,000원</span>
                            </a></li>
                            <li><a href="#">
                                <span class="program">에너지 (90분)</span>
                                <span class="price">280,000원</span>
                            </a></li>
                            <li><a href="#">
                                <span class="program">에너지 (120분)</span>
                                <span class="price">440,000원</span>
                            </a></li>
                        </ul>
                    </div>
    
                    <div class="menu">
                        <h4>[페이셜] 래디언스</h4>
                        <ul>
                            <li><a href="#">
                                <span class="program">래디언스 (30분)</span>
                                <span class="price">140,000원</span>
                            </a></li>
                            <li><a href="#">
                                <span class="program">래디언스 (60분)</span>
                                <span class="price">210,000원</span>
                            </a></li>
                            <li><a href="#">
                                <span class="program">래디언스 (90분)</span>
                                <span class="price">280,000원</span>
                            </a></li>
                            <li><a href="#">
                                <span class="program">래디언스 (120분)</span>
                                <span class="price">440,000원</span>
                            </a></li>
                        </ul>
                    </div>
    
                    <div class="menu">
                        <h4>[페이셜] 라인 & 볼륨</h4>
                        <ul>
                            <li><a href="#">
                                <span class="program">라인 & 볼륨 (30분)</span>
                                <span class="price">140,000원</span>
                            </a></li>
                            <li><a href="#">
                                <span class="program">라인 & 볼륨 (60분)</span>
                                <span class="price">210,000원</span>
                            </a></li>
                            <li><a href="#">
                                <span class="program">라인 & 볼륨 (90분)</span>
                                <span class="price">280,000원</span>
                            </a></li>
                            <li><a href="#">
                                <span class="program">라인 & 볼륨 (120분)</span>
                                <span class="price">440,000원</span>
                            </a></li>
                        </ul>
                    </div>
    
                    <div class="menu">
                        <!-- 22.04.06 수정 -->
                        <!-- <h4>MINISH TOUCH</h4> -->
                        <h4>[바디] MINISH TOUCH</h4>
                        <ul>
                            <li><a href="#">
                                <span class="program">MINISH TOUCH (30분)</span>
                                <span class="price">160,000원</span>
                            </a></li>
                            <li><a href="#">
                                <span class="program">MINISH TOUCH (60분)</span>
                                <span class="price">240,000원</span>
                            </a></li>
                            <li><a href="#">
                                <span class="program">MINISH TOUCH (90분)</span>
                                <span class="price">350,000원</span>
                            </a></li>
                            <li><a href="#">
                                <span class="program">MINISH TOUCH (120분)</span>
                                <span class="price">460,000원</span>
                            </a></li>
                        </ul>
                    </div>
    
                    <div class="menu">
                        <!-- 22.04.06 수정 -->
                        <!-- <h4>마더 투 비 (임산부)</h4> -->
                        <h4>[바디] 마더 투 비 (임산부)</h4>
                        <ul>
                            <li><a href="#">
                                <span class="program">마더 투 비 (60분)</span>
                                <span class="price">270,000원</span>
                            </a></li>
                            <li><a href="#">
                                <span class="program">마더 투 비 (90분)</span>
                                <span class="price">350,000원</span>
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
            <h2>발몽 스파</h2>
            <span>Valmont Spa</span>
            <ul class="address">
                <li>서울 강남구 도산대로49길 9 스타크빌딩 2층 (신사동)</li>
            </ul>
            <ul class="working_time">
                <li>평일 9:00 ~ 20:00</li>
                <li>주말 9:00 ~ 20:00</li>
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

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
            <span>바라는 네일</span>
        </div>
    </header>


    <!-- 바라는네일 예약 페이지 -->
    <section id="brand_intro">
        <div class="brand_item_slider">
            <figure class="nail01"></figure>
            <!-- <figure class="nail02"></figure>
            <figure class="nail03"></figure>
            <figure class="nail04"></figure>
            <figure class="nail05"></figure> -->
        </div>
        <div class="brand_item_num">
            <span class="snum"></span>
        </div>

        <div class="reservation_des">
            <div class="title">
                <h2>바라는 네일</h2>
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
                        최고의 힐링을 위한 프라이빗하고 편안한 실내 PREMIUM PRIVATE SERVICE<br>
                        고객님의 건강을 위한 흡진테이블 For your health<br>
                        쾌적한 힐링휴식공간 Pediroom<br>
                        항균, 탈취 비스포크슈드레스 케어 Clean shoes care<br>
                        육체적,심리적안정 아로마컬러테라피 Aroamtherapy
                    </p>
                </div>
                <div class="info_inner">
                    <h3>업체 정보</h3>
                    <ul>
                        <li class="working_time">
                            10:00 ~ 19:00<br>
                            일요일 정기 휴일
                        </li>
                        <li class="tel">
                            010-4283-7144
                        </li>
                        <li class="address">
                            서울시 강남구 도산대로49길9 2층<br>바라는네일 in 미니쉬라운지 청담
                        </li>
                    </ul>
                </div>
            </div>

            <!-- 서비스탭 -->
            <div class="tab_content">
                <div class="service_inner menu_inner">
                    <h3>서비스(<span class="itm_num"></span>)</h3>
    
                    <div class="menu">
                        <h4>베이직 케어</h4>
                        <ul>
                            <li><a href="#">
                                <span class="program">손기본케어 (60분)</span>

                                <!-- 22.04.05 수정 -->
                                <!-- <span class="price">여 36,300원</span> -->
                                <span class="price">여 37,000원</span>

                            </a></li>
                            <li><a href="#">
                                <span class="program">손기본케어 (60분)</span>

                                <!-- 22.04.05 수정 -->
                                <!-- <span class="price">남 48,400원</span> -->
                                <span class="price">남 49,000원</span>

                            </a></li>
                            <li><a href="#">
                                <!-- 22.04.05 수정 -->
                                
                                <!-- <span class="program">손교정케어 (60분)</span> -->
                                <!-- <span class="price">72,600원</span> -->                                
                                <span class="program">손기본케어 (60분)</span>
                                <span class="price">73,000원</span>
                                
                            </a></li>
                            <li><a href="#">
                                <span class="program">발기본케어 (60분)</span>

                                <!-- 22.04.05 수정 -->
                                <!-- <span class="price">여 60,500원</span> -->
                                <span class="price">여 61,000원</span>

                            </a></li>
                            <li><a href="#">
                                <span class="program">발기본케어 (60분)</span>

                                <!-- 22.04.05 수정 -->
                                <!-- <span class="price">남 72,600원</span> -->
                                <span class="price">남 73,000원</span>

                            </a></li>
                            <li><a href="#">

                                <!-- 22.04.05 수정 -->
                                <!-- <span class="program">발교정케어 (90분)</span> -->
                                <span class="program">발기본케어 (90분)</span>
                                
                                <span class="price">121,000원</span>
                            </a></li>
                        </ul>
                    </div>
    
                    <div class="menu">
                        <h4>젤</h4>
                        <ul>
                            <li><a href="#">
                                <span class="program">젤네일아트[베이직] (90분)</span>

                                <!-- 22.04.05 수정 -->
                                <!-- <span class="price">96,800원</span> -->
                                <span class="price">97,000원</span>

                            </a></li>
                            <li><a href="#">
                                <span class="program">젤패디아트[베이직] (90분)</span>
                                <span class="price">121,000원</span>
                            </a></li>
                            <li><a href="#">
                                <span class="program">젤제거 (30분)</span>

                                <!-- 22.04.05 수정 -->
                                <!-- <span class="price">36,300원</span> -->
                                <span class="price">37,000원</span>

                            </a></li>
                            <li><a href="#">
                                <span class="program">젤아트[네일&패디] (120분)</span>
                                <span class="price">121,000원</span>
                            </a></li>
                        </ul>
                    </div>
    
                    <div class="menu">
                        <h4>각질관리 (베이직케어 제외)</h4>
                        <ul>
                            <li><a href="#">
                                <span class="program">각질1단계 (30분)</span>
                                
                                <!-- 22.04.05 수정 -->
                                <!-- <span class="price">96,800원</span> -->
                                <span class="price">97,000원</span>

                            </a></li>
                            <li><a href="#">
                                <span class="program">각질2단계 (40분)</span>
                                
                                <!-- 22.04.05 수정 -->
                                <!-- <span class="price">133,100원</span> -->
                                <span class="price">134,000원</span>

                            </a></li>
                            <li><a href="#">
                                <span class="program">각질3단계 (50분)</span>
                                
                                <!-- 22.04.05 수정 -->
                                <!-- <span class="price">169,400원</span> -->
                                <span class="price">170,000원</span>

                            </a></li>
                            <li><a href="#">
                                <span class="program">각질4단계 (60분)</span>
                                
                                <!-- 22.04.05 수정 -->
                                <!-- <span class="price">217,800원</span> -->
                                <span class="price">218,000원</span>

                            </a></li>
                        </ul>
                    </div>
    
                    <div class="menu">
                        <h4>문제성 특수관리</h4>
                        <ul>
                            <li><a href="#">
                                <span class="program">
                                    물어뜯는손톱 (120분)<br>
                                    [베이직교정케어포함]
                                </span>

                                <!-- 22.04.05 수정 -->
                                <!-- <span class="price">193,600원</span> -->
                                <span class="price">194,000원</span>

                            </a></li>
                            <li><a href="#">
                                <span class="program">
                                    파고드는발톱 (100분)<br>
                                    [베이직교정패디큐어포함]
                                </span>

                                <!-- 22.04.05 수정 -->
                                <!-- <span class="price">1회 181,500원</span> -->
                                <span class="price">1회 182,000원</span>

                            </a></li>
                            <li><a href="#">
                                <span class="program">
                                    파고드는발톱 (100분)<br>
                                    [베이직교정패디큐어포함]
                                </span>
                                <span class="price">2회 242,000원</span>
                            </a></li>
                            <li><a href="#">
                                <span class="program">
                                    파고드는발톱 (120분)<br>
                                    [베이직교정패디큐어포함]
                                </span>

                                <!-- 22.04.05 수정 -->
                                <!-- <span class="price">1회 240,900원</span> -->
                                <span class="price">1회 241,000원</span>

                            </a></li>
                            <li><a href="#">
                                <span class="program">
                                    파고드는발톱 (120분)<br>
                                    [베이직교정패디큐어포함]
                                </span>

                                <!-- 22.04.05 수정 -->
                                <!-- <span class="price">2회 350,900원</span> -->
                                <span class="price">2회 351,000원</span>

                            </a></li>
                        </ul>
                    </div>
    
                    <div class="menu">
                        <h4>멤버십 서비스</h4>
                        <ul>
                            <li><a href="#">
                                <span class="program">
                                    베이직케어 (90분)
                                </span>
                                <span class="price">100,000원</span>
                            </a></li>
                            <li><a href="#">
                                <span class="program">
                                    베이직케어 (120분)<br>
                                    [네일+패디+각질]
                                </span>
                                <span class="price">250,000원</span>
                            </a></li>
                            <li><a href="#">
                                <span class="program">베이직젤네일+젤패디 (180분)</span>
                                <span class="price">250,000원</span>
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
            <h2>바라는 네일</h2>
            <span>NAIL</span>
            <ul class="address">
                <li>서울 강남구 도산대로49길 9 스타크빌딩 2층 (신사동) 바라는 네일 본점</li>
            </ul>
            <ul class="working_time">
                <li>평일 10:00 ~ 19:00</li>
                <li>토요일 10:00 ~ 19:00</li>
                <li>일요일 정기 휴무</li>
            </ul>
        </div> -->
        <!--------------------------------->


        <!-- <a href="http://s.handsos.com/User_default.asp?pkCompany=12536181&pkMobileID=15226" target="_blank" class="reservation_btn">예약하기</a> -->

        <a href="/brands/3/shops/0/reservation/cart" target="_blank" class="reservation_btn">예약하기</a>
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

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
            <span>포레스타 블랙</span>
        </div>
    </header>


    <!-- 포레스타블랙 브랜드 소개 페이지 -->
    <section id="brand_intro">
        <div class="brand_item_slider">
            <figure class="foresta_black01"></figure>
            <!-- <figure class="foresta_black02"></figure>
            <figure class="foresta_black03"></figure>
            <figure class="foresta_black04"></figure>
            <figure class="foresta_black05"></figure> -->
        </div>
        <div class="brand_item_num">
            <span class="snum"></span>
        </div>

        <div class="reservation_des">
            <div class="title">
                <h2>포레스타 블랙</h2>
                <a href="#!" class="share_btn">
                    <img src="/user/img/icon_share.svg" alt="공유하기">
                </a>
            </div>
            <ul class="tab_menu">
                <li class="on">정보</li>
                <li>서비스</li>
                <li>디자이너</li>

                <!-- 22.03.28 삭제 -->
                <!-- <li>문의</li> -->
            </ul>

            <!-- 정보탭 -->
            <div class="tab_content">
                <div class="intro_inner">
                    <h3>제휴업체소개</h3>
                    <p>
                        포레스타(Foresta)는 ‘숲’이라는 뜻의 이탈리아어에서 유래하였으며 큰 숲 안에 살아 숨쉬는 생명의 무한한 에너지, 그리고 숲과 같은 휴식 공간을 상징합니다. 자연의 향이 가득한 공간인 포레스타에서는 각 분야 최고의 전문가들이 특별한 여러분을 위한 토탈 뷰티 서비스를 제공하며 일상에 지친 심신의 활력을 되찾아 드립니다.
                    </p>
                </div>
                <div class="info_inner">
                    <h3>업체 정보</h3>
                    <ul>
                        <li class="working_time">
                            10:00 ~ 19:00<br>
                            월요일 정기 휴무
                        </li>
                        <li class="tel">
                            02-540-2252
                        </li>
                        <li class="address">
                            서울시 강남구 도산대로 45길 16-11<br>
                        </li>
                    </ul>
                </div>
            </div>

            <!------------ 디자이너 사진 있을때 ------------>
            <!-- 서비스탭 -->
            <!-- <div class="tab_content">
                <div class="service_inner pic_inner">
                    <h3>서비스(<span class="itm_num"></span>)</h3>
                    <ul>
                        <li>
                            <figure>
                                <img src="/user/img/img_foresta_black_reservation_service01.jpg" alt="남자 여자 컷트 + 스타일링 72,600원">
                            </figure>
                            <div class="des">
                                <p>남자 여자 컷트 + 스타일링</p>
                                <strong>72,600원</strong>
                            </div>
                        </li>
                        <li>
                            <figure>
                                <img src="/user/img/img_foresta_black_reservation_service02.jpg" alt="남자 펌 + 컷 + 클리닉 383,000원">
                            </figure>
                            <div class="des">
                                <p>남자 펌 + 컷 + 클리닉</p>
                                <strong>383,000원</strong>
                            </div>
                        </li>
                        <li>
                            <figure>
                                <img src="/user/img/img_foresta_black_reservation_service03.jpg" alt="솜브레 탈색 239,000원">
                            </figure>
                            <div class="des">
                                <p>솜브레 탈색</p>
                                <strong>239,000원</strong>
                            </div>
                        </li>
                        <li>
                            <figure>
                                <img src="/user/img/img_foresta_black_reservation_service04.jpg" alt="컬러 239,000원">
                            </figure>
                            <div class="des">
                                <p>컬러</p>
                                <strong>239,000원</strong>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            -->

            <!-- 디자이너탭 -->
            <!-- <div class="tab_content">
                <div class="designer_inner pic_inner">
                    <h3>서비스(<span class="itm_num"></span>)</h3>
                    <ul>
                        <li>
                            <figure>
                                <img src="/user/img/img_foresta_black_reservation_designer01.jpg" alt="정재명 대표 CEO, Chief">
                            </figure>
                            <div class="des">
                                <p>정재명 대표</p>
                                <strong>CEO, Chief</strong>
                            </div>
                        </li>
                        <li>
                            <figure>
                                <img src="/user/img/img_foresta_black_reservation_designer02.jpg" alt="하루 부원장 Art Director">
                            </figure>
                            <div class="des">
                                <p>하루 부원장</p>
                                <strong>Art Director</strong>
                            </div>
                        </li>
                        <li>
                            <figure>
                                <img src="/user/img/img_foresta_black_reservation_designer03.jpg" alt="정준 원장 Cheif">
                            </figure>
                            <div class="des">
                                <p>정준 원장</p>
                                <strong>Cheif</strong>
                            </div>
                        </li>
                        <li>
                            <figure>
                                <img src="/user/img/img_foresta_black_reservation_designer04.jpg" alt="유주 디자이너 Stylist">
                            </figure>
                            <div class="des">
                                <p>유주 디자이너</p>
                                <strong>Stylist</strong>
                            </div>
                        </li>
                        <li>
                            <figure>
                                <img src="/user/img/img_foresta_black_reservation_designer05.jpg" alt="우호림 원장 Chief">
                            </figure>
                            <div class="des">
                                <p>우호림 원장</p>
                                <strong>Chief</strong>
                            </div>
                        </li>
                        <li>
                            <figure>
                                <img src="/user/img/img_foresta_black_reservation_designer06.jpg" alt="정아름 실장 Top Stylist">
                            </figure>
                            <div class="des">
                                <p>정아름 실장</p>
                                <strong>Top Stylist</strong>
                            </div>
                        </li>
                        <li>
                            <figure>
                                <img src="/user/img/img_foresta_black_reservation_designer07.jpg" alt="호진 디자이너 Stylist">
                            </figure>
                            <div class="des">
                                <p>호진 디자이너</p>
                                <strong>Stylist</strong>
                            </div>
                        </li>
                        <li>
                            <figure>
                                <img src="/user/img/img_foresta_black_reservation_designer08.jpg" alt="혜윤 디자이너 Stylist">
                            </figure>
                            <div class="des">
                                <p>혜윤 디자이너</p>
                                <strong>Stylist</strong>
                            </div>
                        </li>
 
                    </ul>
                </div>
            </div> -->

            <!-- 서비스탭 -->
            <div class="tab_content">
                <div class="service_inner menu_inner">
                    <h3>서비스(<span class="itm_num"></span>)</h3>

                    <div class="menu">
                        <h4>CUT</h4>
                        <ul>
                            <li><a href="#">

                                <!-- 22.03.31 수정 -->
                                <!-- <span class="program">원장</span> -->
                                <span class="program">원장 (60분)</span>

                                <span class="price">181,500원</span>
                            </a></li>
                            <li><a href="#">

                                <!-- 22.03.31 수정 -->
                                <!-- <span class="program">부원장</span> -->
                                <span class="program">부원장 (60분)</span>

                                <span class="price">121,000원</span>
                            </a></li>
                            <li><a href="#">

                                <!-- 22.03.31 수정 -->
                                <!-- <span class="program">실장</span> -->
                                <span class="program">실장 (60분)</span>

                                <span class="price">108,900원</span>
                            </a></li>
                        </ul>
                    </div>

                    <div class="menu">
                        <h4>DRY</h4>
                        <ul>
                            <li><a href="#">

                                <!-- 22.03.31 수정 -->
                                <!-- <span class="program">원장</span> -->
                                <span class="program">원장 (40분)</span>

                                <span class="price">121,000원</span>
                            </a></li>
                            <li><a href="#">

                                <!-- 22.03.31 수정 -->
                                <!-- <span class="program">부원장</span> -->
                                <span class="program">부원장 (40분)</span>

                                <span class="price">108,900</span>
                            </a></li>
                            <li><a href="#">

                                <!-- 22.03.31 수정 -->
                                <!-- <span class="program">실장</span> -->
                                <span class="program">실장 (40분)</span>

                                <span class="price">96,800원</span>
                            </a></li>
                        </ul>
                    </div>

                    <div class="menu">
                        <h4>PERM</h4>
                        <ul>
                            <li><a href="#">

                                <!-- 22.03.31 수정 -->
                                <!-- <span class="program">PERM</span> -->
                                <span class="program">PERM (180분)</span>

                                <span class="price">363,000원</span>
                            </a></li>
                        </ul>
                    </div>

                    <div class="menu">
                        <h4>COLOR</h4>
                        <ul>
                            <li><a href="#">

                                <!-- 22.03.31 수정 -->
                                <!-- <span class="program">COLOR </span> -->
                                <span class="program">COLOR (120분)</span>
                                
                                <span class="price">242,000원</span>
                            </a></li>
                        </ul>
                    </div>

                    <div class="menu">
                        <h4>CARE</h4>
                        <ul>
                            <li><a href="#">

                                <!-- 22.03.31 수정 -->
                                <!-- <span class="program">두피케어 + 스피드 모발 케어</span> -->
                                <span class="program">두피케어 + 스피드 모발 케어 (90분)</span>
                                
                                <span class="price">242,000원</span>
                            </a></li>
                        </ul>
                    </div>

                </div>
            </div>

            <!-- 디자이너탭 -->
            <div class="tab_content">
                <div class="service_inner menu_inner">
                    <h3>디자이너(<span class="designer_num"></span>)</h3>

                    <div class="menu">
                        <h5><a href="#">원장</a></h5>
                    </div>

                    <div class="menu">
                        <h5><a href="#">부원장</a></h5>
                    </div>

                    <div class="menu">
                        <h5><a href="#">실장</a></h5>
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
                                <p>
                                    커트가 토요일 가능이라고 적혀있는데 토요일은 몇시가 가장 사람이 적나요?
                                </p>
                            </li> -->
                            <!-- 답변에는 background (class="answer") -->
                            <!-- <li class="answer">
                                <span class="name">포레스타 블랙</span>
                                <span class="date">2022년 3월 1일</span>
                                <p>
                                    안녕하세요. 포레스타블랙 송실장입니다.<br>
                                    현재 토요일은 예약이 마감되었습니다. 월요일에 뵙겠습니다. 감사합니다.
                                </p>
                            </li>
                            <li>
                                <span class="name">이은지</span>
                                <span class="date">2022년 3월 1일</span>
                                <p>
                                    기장에 따른 가격변화가 있는지 궁금합니다.
                                </p>
                            </li> -->
                            <!-- 답변에는 background (class="answer") -->
                            <!-- <li class="answer">
                                <span class="name">포레스타 블랙</span>
                                <span class="date">2022년 3월 1일</span>
                                <p>
                                    안녕하세요. 포레스타블랙 송실장입니다. 기장에 따른 가격 변화가 있습니다. 어떤 시술인지에 따라 상이하기때문에 자세한 가격은 매장에 오셔서 디자이너가 확인 후 알려드리도록 하겠습니다.
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
            <h2>포레스타 블랙</h2>
            <span>Foresta Black</span>
            <ul class="address">
                <li>서울 강남구 신사동 650-8</li>
            </ul>
            <ul class="working_time">
                <li>월요일 휴무</li>
                <li>화요일 10:00 ~ 19:00</li>
                <li>수요일 10:00 ~ 19:00</li>
                <li>목요일 10:00 ~ 19:00</li>
                <li>금요일 10:00 ~ 19:00</li>
                <li>토요일 10:00 ~ 19:00</li>
                <li>일요일 10:00 ~ 19:00</li>
            </ul>
        </div> -->
        <!--------------------------------->
        

<!-- <a href="http://s.handsos.com/User_default.asp?pkCompany=12536181&pkMobileID=15226" target="_blank" class="reservation_btn">예약하기</a> -->

<a href="/brands/6/shops/0/reservation/cart" target="_blank" class="reservation_btn">예약하기</a>
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
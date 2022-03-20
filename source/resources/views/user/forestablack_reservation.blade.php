
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

        <!-- 22.03.07 수정 -->
        <!-- <div class="reservation_des">
            <div class="title">
                <h2>포레스타 블랙</h2>
                <a href="#!" class="share_btn">
                    <img src="./img/icon_share.svg" alt="공유하기">
                </a>
            </div>
            <ul class="tab_menu">
                <li class="on">정보</li>
                <li>서비스</li>
                <li>디자이너</li>
                <li>문의</li>
            </ul>
            <div class="tab_content">
                <div class="intro_inner">
                    <h3>제휴업체소개</h3>
                    <p>
                        국내 최초이자 유일한 아베다의 뷰티 최상 등급인 포레스타 블랙본점은 최고의 제품과 서비스, 기술력으로 당신의 아름다움을 만들어드립니다.<br>
                        자연을 주제로 한 포레스타 블랙만의 다채로움 펌, 전문 디자이너들의 노련한 컷팅 기술로 트랜디한 스타일의 변신을 주도합니다.                        
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
                            서울시 강남구 도산대로 45길 16-11<br>
                            압구정로데오역 5번 출구 방향 5분
                        </li>
                    </ul>
                </div>
            </div>
            <div class="tab_content">
                <div class="service_inner pic_inner">
                    <h3>서비스(<span class="itm_num"></span>)</h3>
                    <ul>
                        <li>
                            <figure>
                                <img src="./img/img_foresta_black_reservation_service01.jpg" alt="남자 여자 컷트 + 스타일링 72,600원">
                            </figure>
                            <div class="des">
                                <p>남자 여자 컷트 + 스타일링</p>
                                <strong>72,600원</strong>
                            </div>
                        </li>
                        <li>
                            <figure>
                                <img src="./img/img_foresta_black_reservation_service02.jpg" alt="남자 펌 + 컷 + 클리닉 383,000원">
                            </figure>
                            <div class="des">
                                <p>남자 펌 + 컷 + 클리닉</p>
                                <strong>383,000원</strong>
                            </div>
                        </li>
                        <li>
                            <figure>
                                <img src="./img/img_foresta_black_reservation_service03.jpg" alt="솜브레 탈색 239,000원">
                            </figure>
                            <div class="des">
                                <p>솜브레 탈색</p>
                                <strong>239,000원</strong>
                            </div>
                        </li>
                        <li>
                            <figure>
                                <img src="./img/img_foresta_black_reservation_service04.jpg" alt="컬러 239,000원">
                            </figure>
                            <div class="des">
                                <p>컬러</p>
                                <strong>239,000원</strong>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="tab_content">
                <div class="designer_inner pic_inner">
                    <h3>서비스(<span class="itm_num"></span>)</h3>
                    <ul>
                        <li>
                            <figure>
                                <img src="./img/img_foresta_black_reservation_designer01.jpg" alt="정재명 대표 CEO, Chief">
                            </figure>
                            <div class="des">
                                <p>정재명 대표</p>
                                <strong>CEO, Chief</strong>
                            </div>
                        </li>
                        <li>
                            <figure>
                                <img src="./img/img_foresta_black_reservation_designer02.jpg" alt="하루 부원장 Art Director">
                            </figure>
                            <div class="des">
                                <p>하루 부원장</p>
                                <strong>Art Director</strong>
                            </div>
                        </li>
                        <li>
                            <figure>
                                <img src="./img/img_foresta_black_reservation_designer03.jpg" alt="정준 원장 Cheif">
                            </figure>
                            <div class="des">
                                <p>정준 원장</p>
                                <strong>Cheif</strong>
                            </div>
                        </li>
                        <li>
                            <figure>
                                <img src="./img/img_foresta_black_reservation_designer04.jpg" alt="유주 디자이너 Stylist">
                            </figure>
                            <div class="des">
                                <p>유주 디자이너</p>
                                <strong>Stylist</strong>
                            </div>
                        </li>
                        <li>
                            <figure>
                                <img src="./img/img_foresta_black_reservation_designer05.jpg" alt="우호림 원장 Chief">
                            </figure>
                            <div class="des">
                                <p>우호림 원장</p>
                                <strong>Chief</strong>
                            </div>
                        </li>
                        <li>
                            <figure>
                                <img src="./img/img_foresta_black_reservation_designer06.jpg" alt="정아름 실장 Top Stylist">
                            </figure>
                            <div class="des">
                                <p>정아름 실장</p>
                                <strong>Top Stylist</strong>
                            </div>
                        </li>
                        <li>
                            <figure>
                                <img src="./img/img_foresta_black_reservation_designer07.jpg" alt="호진 디자이너 Stylist">
                            </figure>
                            <div class="des">
                                <p>호진 디자이너</p>
                                <strong>Stylist</strong>
                            </div>
                        </li>
                        <li>
                            <figure>
                                <img src="./img/img_foresta_black_reservation_designer08.jpg" alt="혜윤 디자이너 Stylist">
                            </figure>
                            <div class="des">
                                <p>혜윤 디자이너</p>
                                <strong>Stylist</strong>
                            </div>
                        </li>
 
                    </ul>
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
        </div>
        
        <!-- 22.03.18 수정 -->
        <!-- <a href="tel:02-540-2252" class="reservation_btn">예약하기</a> -->
        <a href="http://s.handsos.com/User_default.asp?pkCompany=12536181&pkMobileID=15226" target="_blank" class="reservation_btn">예약하기</a>
    </section>
@include('user.footer')


</body>
</html>
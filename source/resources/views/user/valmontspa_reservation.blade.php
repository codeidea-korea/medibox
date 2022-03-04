
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


    <!-- 발몽스파 예약 페이지 -->
    <section id="brand_intro">
        <div class="brand_item_slider">
            <figure class="valmont_spa01"></figure>
            <figure class="valmont_spa02"></figure>
            <figure class="valmont_spa03"></figure>
            <figure class="valmont_spa04"></figure>
            <figure class="valmont_spa05"></figure>
        </div>
        <div class="brand_item_num">
            <span class="snum"></span>
        </div>
        <div class="brand_item_des reservation_des">
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
        </div>
        <a href="tel:02-540-2252" class="reservation_btn">전화 예약하기</a>
    </section>

    @include('user.footer')

</body>
</html>

@include('user.header')
    
    <header id="header">
        <!-- 뒤로가기 버튼 -->
        <button class="back" onclick="location.href='/brand';">
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
            <span>브랜드</span>
        </div>
    </header>


    <!-- 미니쉬스파 브랜드 소개 페이지 -->
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
        <div class="brand_item_des">
            <h2>미니쉬 구강 스파</h2>

            <!-- 22.03.30 수정 -->
            <!-- <span>Minsh Spa</span> -->
            <span>MINISH Dental Spa</span>
            
            <p>‘나 자신도 몰랐던 입속 상태를 정확히 진단받고, 건강한 구강 관리가 가능토록 미니쉬가 만들었습니다.’</p>
            <p>미니쉬 스파에서는 구강질환이 발생하지 않도록 예방하고 이미 발생한 구강질환은 비침습적 방법으로 관리할 수 있도록 개인별 구강 상태에 맞는 관리 프로그램을 진행해드립니다. 최첨단 의료 장비를 통해 구강질환의 원인 세균에 대한 분석, 전문가의 섬세한 손길을 통해 체계적인 구강 관리를 원하시는 분들께 추천하고 있습니다.</p>
        </div>
    </section>

    @include('user.footer')

</body>
</html>

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
            <figure class="valmont_spa01"></figure>
            <figure class="valmont_spa02"></figure>
            <figure class="valmont_spa03"></figure>
            <figure class="valmont_spa04"></figure>
            <figure class="valmont_spa05"></figure>
        </div>
        <div class="brand_item_num">
            <span class="snum"></span>
        </div>
        <div class="brand_item_des">
            <h2>발몽 스파</h2>
            <span>Valmont Spa</span>
            <p>스위스 발몽 코스메틱의 기술력과 미니쉬가 만나 우리의 고객이 건강하게 아름다워질 수 있도록 합니다.</p>
            <p>발몽의 노하우를 전수받은 숙련된 테라피스트가 발몽제품과 발몽 테크닉을 얼굴 피부와 전신에 완벽히 적용합니다. 최상급 인테리어로 안락함과 행복함을 드리며, 필요와 기대에 맞추고자 노력합니다.</p>
            <p>편안한 휴식을 위해 1인 1룸, 청결한 위생을 위해 1인 1시트, 체계적인 분석과 진단을 통한 트리트먼트로 오직 한 분을 위한 시간과 공간을 선사합니다.</p>
        </div>
    </section>

    @include('user.footer')

</body>
</html>
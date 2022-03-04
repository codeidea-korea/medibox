
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
            <figure class="minish_manul_therapy01"></figure>
            <figure class="minish_manul_therapy02"></figure>
            <figure class="minish_manul_therapy03"></figure>
            <figure class="minish_manul_therapy04"></figure>
            <figure class="minish_manul_therapy05"></figure>
        </div>
        <div class="brand_item_num">
            <span class="snum"></span>
        </div>
        <div class="brand_item_des">
            <h2>미니쉬 도수</h2>
            <span>Minish Manul Therapy</span>
            <p>‘MANUAL THERAPY’, 모든 인체의 건강은 예방관리가 가장 중요합니다. 호감가는 인상을 결정하는 것은 이목구비 뿐 아니라 체형도 중요한 요인이 됩니다. 일상생활 속 잘못된 자세가 반복되면 그 사람의 체형으로 고착화됩니다.</p>
            <p>미니쉬 도수에서는 관절 전문 병원 출신의 물리치료사의 체형교정 서비스를 제공하고 근골격의 변형예측, 근육 형상 검사가 가능한 장비를 활용한 검사 결과에 따라 개개인에 맞는 자가운동 치료 솔루션을 처방해드립니다. </p>
            <p>멤버십 고객분들을 위한 미니쉬라운지청담만의 특별한 매뉴얼 테라피를 경험해보기시 바랍니다.</p>
        </div>
    </section>

    @include('user.footer')

</body>
</html>
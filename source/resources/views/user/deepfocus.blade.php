
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
            <!-- 22.03.18 수정 -->
            <figure class="deep_focus01"></figure>
            <figure class="deep_focus02"></figure>
            <!-- <figure class="deep_focus03"></figure>
            <figure class="deep_focus04"></figure>
            <figure class="deep_focus05"></figure> -->
        </div>
        <div class="brand_item_num">
            <span class="snum"></span>
        </div>
        <div class="brand_item_des">
            <h2>딥포커스 검안센터</h2>
            <span>Deep Focus</span>

            <p>‘검안에 눈뜨다’ 더 선명한 세상을 마주하는 DEEP FOCUS ‘유럽과 미국엔 보편화된 전문 검안 센터, 왜 한국에선 찾기 어려울까?’ ‘김광용 OPTICIAN’이 15여 년간 연구한 눈 중심 전문 검안 센터는 이처럼 간단한 질문에서 출발하였습니다.</p>
            <p>익숙한듯 당연하지만, 하루하루 눈의 쓰임새는 정말 중요합니다. 특정 질환이 아니더라도 다양한 불편 증상이 생길 수 있습니다. 때문에 눈 질환과 시기능 이상은 구별이 필요합니다.</p>
            <p>우리의 눈은 세상을 보고, 사랑하는 이의 눈을 마주하기도 합니다. 정밀하고 체계적인 검안 시스템을 갖춘 딥포커스에서 더욱 선명해질 당신의 시선을 약속합니다.</p>
        </div>
    </section>

    @include('user.footer')

</body>
</html>